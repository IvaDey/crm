<?php
class auth_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new auth_model();
    }

    function action_index($params = NULL)
    {
//        require_once './application/models/auth_model.php';

        // Сперва проверим нет ли попытки входа
        // Для этого проверим массив $_POST на наличие логина и пароля
        if ($_POST['username'] && $_POST['pass']) {
            // Проведем аутентификацию пользователя
            $connect = json_decode($this->model->logon($_POST['username'], $_POST['pass']));

            // Если аутентификация прошла успешна, то логиним пользователя, создаем сессию
            // и редиректим по запрашиваемому адрессу
            if ($connect->result == 1) {
                $_SESSION['id'] = $connect->id;
                $_SESSION['user'] = $connect->username;
                $requestedUrl = $_COOKIE['requested_url'];
                setcookie('requested_url', '', time() - 100);
                setcookie('access_token', $connect->access_token, time() + 3600 * 24);

                $host = 'https://'.$_SERVER['HTTP_HOST'] . '/' . $requestedUrl;
                header('Location:'.$host);
            }
            else {
                $this->view->generate('auth_view.php');
            }
        } else if ($_COOKIE['access_token']) {
            $connect = json_decode($this->model->re_logon($_COOKIE['access_token'], $_SERVER['HTTP_USER_AGENT']));

            // Если повторная аутентификация прошла успешна, то создаем новую сессию
            // и редиректим по запрашиваемому адрессу
            if ($connect->result == 1) {
                $_SESSION['id'] = $connect->id;
                $_SESSION['user'] = $connect->username;
                $requestedUrl = $_COOKIE['requested_url'];
                setcookie('requested_url', '', time() - 100);
                setcookie('access_token', $connect->access_token, time() + 3600 * 24);

                $host = 'https://'.$_SERVER['HTTP_HOST'] . '/' . $requestedUrl;
                header('Location:'.$host);
            }
            else {
                $this->view->generate('auth_view.php');
            }
        }
        else $this->view->generate('auth_view.php');
    }

    // API методы для виджета (временно здесь)
    // Хотя они вроде уже и не нужны
    public function action_sign_in()
    {
        if (!$_GET['login'] || !$_GET['password']) {
            print_r(json_encode(Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            ), JSON_UNESCAPED_UNICODE));
            return;
        }

        print_r(json_encode($this->model->sign_in($_GET['login'], $_GET['password']), JSON_UNESCAPED_UNICODE));
    }

    public function action_sign_up()
    {
    }

    public function action_sign_out()
    {
        if (isset($_GET['login'])) {
            $this->model->sign_out($_GET['login']);
        }
    }
}



//
//require_once './application/core/model.php';
//require_once './application/models/auth_model.php';
//
//$model = new auth_model();
//// Сперва проверим нет ли попытки входа
//// Для этого проверим массив $_POST на наличие логина и пароля
//if ($_POST['username'] && $_POST['pass']) {
//    // Проведем аутентификацию пользователя
//    $connect = json_decode($model->logon($_POST['username'], $_POST['pass']));
//
//    // Если аутентификация прошла успешна, то логиним пользователя, создаем сессию
//    // и редиректим по запрашиваемому адрессу
//    if ($connect->result == 1) {
//        $_SESSION['user'] = $connect->username;
//        $_SESSION['status'] = $connect->userStatus;
//        $content = "main_view.php";
//
//        include_once './application/bootstrap.php';
//    }
//    else include_once './application/views/auth_view.php';
//}
//else include_once './application/views/auth_view.php';