<?php

class dbModel
{
    private $db_user = NULL;
    private $db_password = NULL;
    private $db_name = NULL;
    private $db_host = NULL;
    private $db_port = NULL;
    private $en_to_ru = NULL;

    private $db_connection = NULL;

    function __construct($user, $password, $db_name, $host, $port)
    {
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db_name = $db_name;
        $this->db_host = $host;
        $this->db_port = $port;

        $this->db_connection = new mysqli($this->db_host,$this->db_user,$this->db_password,$this->db_name,$this->db_port);

        $this->en_to_ru = Array(
            'Jan' => 'янв',
            'Feb' => 'фев',
            'Mar' => 'мар',
            'Apr' => 'апр',
            'May' => 'май',
            'Jun' => 'июн',
            'Jul' => 'июл',
            'Aug' => 'авг',
            'Sep' => 'сен',
            'Oct' => 'окт',
            'Nov' => 'ноя',
            'Dec' => 'дек'
        );
    }


    function getCurrentScreen($user_id)
    {
        $query = "SELECT screen_id FROM currentScreen WHERE user_id='{$user_id}'";
        $scr = $this->db_connection->query($query);

        if ($scr->num_rows == 0)
            return json_encode(Array('result' => 'unknown_user'));
        else return json_encode(Array('result' => $scr->fetch_object()->screen_id));
    }

    function getUserStatus($user_id)
    {
        $query = "SELECT status FROM usersInfo WHERE user_id='{$user_id}'";
        $scr = $this->db_connection->query($query);

        if ($scr->num_rows == 0)
            return json_encode(Array('result' => 'unknown_user'));
        else return json_encode(Array('result' => $scr->fetch_object()->status));
    }

    function updateUserStatus($user_id, $status)
    {
        $query = "UPDATE usersInfo SET status='{$status}' WHERE user_id='{$user_id}'";
        $this->db_connection->query($query);

        return json_encode(Array('result' => 'ok'));
    }

    function getButton($keyboard_id, $keyboard_caption)
    {
        $query = "SELECT * FROM keyboards WHERE keyboard_id='{$keyboard_id}' AND caption='{$keyboard_caption}'";
        return $this->db_connection->query($query)->fetch_object();
    }

    function registerNewUser($user)
    {
        $query = "INSERT INTO currentScreen(screen_id, user_id) VALUES('{$user['screen_id']}', '{$user['user_id']}')";
        $this->db_connection->query($query);

        $query = "INSERT INTO usersInfo(user_id, name, username) "
            ."VALUES('{$user['user_id']}', '{$user['name']}', '{$user['username']}')";
        $this->db_connection->query($query);

        return json_encode(Array('result' => 'ok'));
    }

    function updateScreen($user_id, $screen_id)
    {
        $query = "UPDATE currentScreen set screen_id='{$screen_id}' WHERE user_id='{$user_id}'";
        $this->db_connection->query($query);

        return json_encode(Array('result' => 'ok'));
    }

    function getAdminID()
    {
        $query = "SELECT user_id FROM usersInfo WHERE status='admin'";
        $query = $this->db_connection->query($query)->fetch_object();

        return $query->user_id;
    }

    function customQuery($query)
    {
        return $this->db_connection->query($query);
    }

    function checkReservationsDone($time)
    {
        $query = "UPDATE reservations SET status='done' WHERE end_time<'{$time}'";
        $this->db_connection->query($query);

        return json_encode(Array('result' => 'ok'));
    }

    function getReservationList($location_id)
    {
        $this->checkReservationsDone(Date('Y-m-d H:i', time()));

        $query = "SELECT * FROM reservations WHERE location_id='{$location_id}' AND status='active'";
        $query = $this->db_connection->query($query);
        $result = Array();

        if ($query->num_rows == 0)
            return false;

        while ($row = $query->fetch_object())
        {
            $time_stamp = strtotime($row->start_time);
            $date = Date('j', $time_stamp).' '.$this->en_to_ru[Date('M', $time_stamp)];

            $timeRange = Date('G:i', $time_stamp).' – ';
            $time_stamp = strtotime($row->end_time);
            $timeRange .= Date('G:i', $time_stamp);


            $user = json_decode($this->getUserInfo($row->user_id));
            array_push($result, Array(
                'reservation_id' => $row->reservation_id,
                'name' => $user->name,
                'username' => '@'.$user->username,
                'date' => $date,
                'time_range' => $timeRange
            ));
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function reserveBoardroom($reserveInfo)
    {
        $query = "INSERT INTO reservations(location_id, user_id, start_time, end_time) "
            ."VALUE('{$reserveInfo['location_id']}', '{$reserveInfo['user_id']}', "
            ."'{$reserveInfo['start_time']}', '{$reserveInfo['end_time']}')";

        return $this->db_connection->query($query);
    }

    // Данный метод отмечает бронь как отмененную
    // На вход необходимо передать номер брони и ID пользователя, которому принадлежит данная бронь
    // В случае, если бронь пользователю не принадлежит, то метод вернет логическое значение false
    function cancelReservation($reservation_id, $user_id)
    {
        // Получаем ID пользователя, создавшего бронь с заданным номером
        $query = "SELECT user_id FROM reservations WHERE reservation_id='{$reservation_id}'";
        $query = $this->db_connection->query($query);

        // Если бронь с заданным номер есть, то вытаскиваем идентификатор пользователя
        // Иначе возвращаем строку 'not found'
        if ($query->num_rows)
            $query = $query->fetch_object()->user_id;
        else return 'not found';

        // Проверяем соответствие идентификатор создавшего и отменяюдего бронь пользователей
        // Если совпадают, то отменяем бронь
        if ($query == $user_id) {
            $query = "UPDATE reservations SET status='canceled' WHERE reservation_id='{$reservation_id}'";

            $this->db_connection->query($query);

            return 'success';//$this->db_connection->query($query);
        }

        // Иначе возвращаем false
        return false;
    }

    function getUserInfo($user_id)
    {
        $query = "SELECT * FROM usersInfo WHERE user_id='{$user_id}'";
        $query = $this->db_connection->query($query);

        return json_encode($query->fetch_object(), JSON_UNESCAPED_UNICODE);
    }

    function isLocationFreeOnDate($location_id, $date, $timeRange)
    {
        $query = "SELECT start_time, end_time FROM reservations WHERE "
            ."location_id='{$location_id}' AND status='active' AND start_time LIKE '{$date}%'";

        $query = $this->db_connection->query($query);

        $res = Array();

        while ($row = $query->fetch_object())
        {
            $start_time = Date("Y-m-d H:i", strtotime($row->start_time));
            $end_time = Date("Y-m-d H:i", strtotime($row->end_time));
            if (!($timeRange['start'] >= $end_time || $timeRange['end'] <= $start_time))
            {
                return false;
            }
        }
        return true;
    }
}
































