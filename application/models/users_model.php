<?php
class users_model extends model {

    //------------------------------------------------------------------------------------------------------------------
    // Основные методы работы с пользователя (для админ панели)
    //------------------------------------------------------------------------------------------------------------------

    // Получение списка всех пользователей
    public function getUsers($offset = 0)
    {
        if ($offset)
            $offset--;
        $limit = 15;
        $result = Array(
            'list' => Array(),
            'pages_count' => 0
        );

        // Получаем сколько всего страниц по 25 записей есть в БД
        $query = "SELECT COUNT(id) AS count FROM users";
        $query = $this->db_connection->query($query);
        $result['pages_count'] = ceil($query->fetch_object()->count / $limit);

        // Получаем список записей
        $offset = $limit * $offset;
        $query = "SELECT id, registration_date, name, surname, phone, email FROM users LIMIT {$offset}, {$limit}";
        $query = $this->db_connection->query($query);

        while ($row = $query->fetch_object()) {
            array_push($result['list'], $row);
        }

        return $result;
    }

    // Получение списка всех клиентов (тех, кто записывался на прием, но не регистрировался)
    public function getClients($offset = 0)
    {
        if ($offset)
            $offset--;
        $limit = 15;
        $result = Array(
            'list' => Array(),
            'pages_count' => 0
        );

        // Получаем сколько всего страниц по 25 записей есть в БД
        $query = "SELECT COUNT(id) AS count FROM clients";
        $query = $this->db_connection->query($query);
        $result['pages_count'] = ceil($query->fetch_object()->count / $limit);

        // Получаем список записей
        $offset = $limit * $offset;
        $query = "SELECT * FROM clients LIMIT {$offset}, {$limit}";
        $query = $this->db_connection->query($query);

        while ($row = $query->fetch_object()) {
            $client = Array(
                'id' => $row->id,
                'name' => $row->name,
                'phone' => $row->phone,
                'email' => $row->email,
                'reservation_date' => '',
                'service_name' => '',
                'total_cost' => ''
            );

            $q2 = "SELECT id, reservation_date, total_cost FROM reservations WHERE client_id='{$row->id}'";
            if ($q2 = $this->db_connection->query($q2)->fetch_object()) {
                $client['reservation_date'] = date('j.m.Y H:i', strtotime($q2->reservation_date));
                $client['total_cost'] = $q2->total_cost;
            }

            $q2 = "SELECT name FROM services WHERE id=(SELECT service_id FROM reservations_details WHERE reservation_id='{$q2->id}')";
            if ($q2 = $this->db_connection->query($q2)->fetch_object()) {
                $client['service_name'] = $q2->name;
            }

            array_push($result['list'], (object)$client);
        }

        return $result;
    }

    //------------------------------------------------------------------------------------------------------------------
    // API для работы с пользователями (регистрация, авторизация, деавторизация и прочее)
    //------------------------------------------------------------------------------------------------------------------

    // Авторизация пользователя
    public function auth($login, $password)
    {
        $query = "SELECT password FROM users WHERE login='{$login}'";
        $user_password = $this->db_connection->query($query)->fetch_object();

        // Если данных не нашлось, то возвращаем ошибку с кодом 1
        if (!$user_password) {
            return Array('error_code' => 1, 'error_description' => 'Wrong login or password');
        } else {
            $user_password = $user_password->password;
        }

        // Если парольд совподают, то создаем сессию и возвращаем ее номер с кодом ошибки 0
        // Иначе возвращаем ошибку с кодом 1
        if ($user_password == md5($password)) {
            $access_token = md5(time());
            $expires = date('Y-m-d H:i', time() + 60 * 120);    // Длительности сессии два часа
            $query = "INSERT INTO sessions(access_token, expires) VALUES('{$access_token}', '{$expires}')";
            $this->db_connection->query($query);
            $session_id = $this->db_connection->insert_id;
            $query = "UPDATE users SET session_id='{$session_id}' WHERE login='{$login}'";
            $this->db_connection->query($query);
            $query = "SELECT access_token FROM sessions WHERE id='{$session_id}'";
            $access_token = $this->db_connection->query($query)->fetch_object()->access_token;
            return Array('error_code' => 0,
                'error_description' => 'Ok',
                'access_token' => $access_token);
        } else {
            return Array('error_code' => 1, 'error_description' => 'Wrong login or password');
        }
    }

    // Регистрация пользователя
    public function sign_up($user)
    {
        $login = $user['login'];
        $password = md5($user['password']);
        $name = $user['name'];
        $surname = $user['surname'];
        $phone = $user['phone'];
        $email = $user['email'];
        $query = <<<eot
                INSERT INTO users(login, password, name, surname, phone, email)
                VALUES('{$login}', '{$password}', '{$name}', '{$surname}', '{$phone}', '{$email}')
eot;
        $this->db_connection->query($query);

        return $this->auth($login, $user['password']);
    }

    // Logout пользователя
    public function logout($login, $access_token)
    {
        if (!$this->check_access_token($login, $access_token)) {
            return;
        }
        else {
            $query = "UPDATE users SET session_id='0' WHERE login='{$login}'";
            $this->db_connection->query($query);
        }
    }

    // Валидация регистрационных данных
    public function check_username($username)
    {
        $query = "SELECT login FROM users WHERE login='{$username}'";
        $query = $this->db_connection->query($query);

        if ($query->num_rows) {
            return Array(
                'error_code' => 1,
                'error_description' => 'Username already taken'
            );
        } else {
            return Array(
                'error_code' => 0,
                'error_description' => 'Username is free'
            );
        }
    }

    //---------------------------------------------------------------------------
    // Проверка access_token
    private function check_access_token($login, $token)
    {
        $query = "SELECT session_id FROM users WHERE login='{$login}'";
        $session_id = $this->db_connection->query($query)->fetch_object();

        // Если сессии нет, то возвращаем ложь, так как токена доступа быть не может
        if (!$session_id) {
            return 0;
        }

        $query = "SELECT access_token FROM sessions WHERE id='{$session_id}'";
        $query = $this->db_connection->query($query)->fetch_object();
        if ($query) {
            $query = $query->access_token;
        } else {
            return 0;
        }
        if ($query == $token) {
            return 1;
        } else {
            return 0;
        }
    }
}