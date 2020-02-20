<?php
class auth_model extends model
{
    // Попробуем залогинить админа
    function logon($user, $password)
    {
        $query = "SELECT id, username, password FROM admins WHERE username='{$user}'";
        $query = $this->db_connection->query($query);

        // Если в БД нет такого пользователя, то возвращаем ноль
        // и сообщение, что пользователь не найден
        if ($query->num_rows == 0)
            return json_encode(Array('result' => 0, 'message' => 'user not found'));

        // Иначе проеряем статус и пароль и возвращаем результат
        $query = $query->fetch_object();
        if ($query->password == md5($password)) {
            $tmp_id = $query->id; // Не понмю нахер это надо, но пусть пока будет здесь костыль
            $tmp_username = $query->username;
            // Создаем сессию
            $access_token = md5(time() . $password);
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $expires = Date('Y-m-d H:i:s', time() + 3600 * 24);

            $query = "INSERT INTO sessions(username, access_token, user_agent, expires) VALUES('{$user}', '{$access_token}', '{$user_agent}', '{$expires}')";
            $this->db_connection->query($query);

            return json_encode(Array(
                'result' => 1,
                'id' => $tmp_id,
                'access_token' => $access_token,
                'username' => $tmp_username
            ));
        }
        else return json_encode(Array('result' => 0, 'message' => 'Access denied'));//'incorrect password'));
    }

    // Повторная авторизация по cookie
    function re_logon($accessToken, $userAgent)
    {
        $query = "SELECT id, username, user_agent, expires FROM sessions WHERE access_token='{$accessToken}'";
        $query = $this->db_connection->query($query);
        // Если записи в БД нет, то доступ запрещен
        if (!$query->num_rows) {
            return json_encode(Array('result' => 0, 'message' => 'Access denied'));
        } else {
            // Иначе проверим на не несколько сценариев:
            // 1. Правильный user_agent;
            // 2. Действительность access_token (он еще актуален и его не пришла пора менять);
            $query = $query->fetch_object();
            if ($userAgent == $query->user_agent && strtotime($query->expires) >= time()) {
                // Если все ок, то предоставляем доступ и обновляем время жизни сессии
                $newExpires = Date('Y-m-d H:i:s', time() + 3600 * 24);
                $tmp = "UPDATE sessions SET expires='{$newExpires}' WHERE id='{$query->id}'";
                $this->db_connection->query($tmp);

                return json_encode(Array(
                    'result' => 1,
                    'id' => $query->id,
                    'username' => $query->username,
                    'access_token' => $accessToken,
                    'message' => 'ReLogon is success'
                ));
            } else {
                return json_encode(Array('result' => 0, 'message' => 'Access denied'));
            }
        }
    }

    // Деавторизация админа
    function logout($login)
    {
        $query = "DELETE FROM sessions WHERE username='{$login}'";
        $this->db_connection->query($query);
    }

    // Регистрируем пользователя

    // Временные методы для работы с пользователями
    function sign_in($login, $password)
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
            $query = "INSERT INTO sessions(username, access_token, expires) VALUES('{$login}', '{$access_token}', '{$expires}')";
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

    function sign_out($login)
    {
        $query = "DELETE FROM sessions WHERE username='{$login}'";
        $this->db_connection->query($query);
    }
}