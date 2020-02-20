<?php
class Route
{
    static function start()
    {
        // контроллер, действие и параметры по умолчанию
        $controller_name = 'main';
        $action_name = 'index';
        $params = NULL;

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[1]) )
        {
            // Проверяем на наличие параметров
            // Если есть знак вопроса, значит есть параметры
            if (substr_count($routes[1], '?')) {
                $params = parse_url($routes[1]);
                $controller_name = $params['path'];
                parse_str($params['query'], $params);
            } else $controller_name = $routes[1];
        }

        // Проверяем авторизован ли пользователь
        // Если нет, то проверяем был ли передан access_token, если да, то надо проверить его валидность
        if (!$_SESSION['user'] && $controller_name != 'auth') {
            if (isset($_GET['access_token'])) {
                $query = "SELECT id, expires FROM sessions WHERE access_token='{$_GET['access_token']}'";
                $db = new mysqli('localhost', 'cryptomoni_rbs2', 'muxcIb-cewrys-pynko7', 'cryptomoni_rbs2', 3306);
                $query = $db->query($query);
                if ($query = $query->fetch_object()) {
                    if (strtotime($query->expires) < time()) {
                        $query = "DELETE FROM sessions WHERE id='{$query->id}'";
                        $db->query($query);
                        Route::AuthPage($controller_name);
                    }
                } else {
                    Route::AuthPage($controller_name);
                }
            } else {
                // Иначе перенаправляем на страницу авторизации или регистрации
                if ($controller_name != 'sign_up' && $controller_name != 'recover')
                    Route::AuthPage($controller_name);
            }
        }

        // получаем имя экшена
        if ( !empty($routes[2]) )
        {
            // Проверяем на наличие параметров
            // Если есть знак вопроса, значит есть параметры
            if (substr_count($routes[2], '?')) {
                $params = parse_url($routes[2]);
                $action_name = $params['path'];
                parse_str($params['query'], $params);
            } else $action_name = $routes[2];
        }

        // добавляем постфиксы
        $model_name = $controller_name.'_model';
        $controller_name = $controller_name.'_controller';
        $action_name = 'action_'.$action_name;

        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = strtolower($model_name).'.php';
        $model_path = "./application/models/".$model_file;
        if(file_exists($model_path))
        {
            require_once "./application/models/".$model_file;
        }

        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "./application/controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            require_once "./application/controllers/".$controller_file;
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            Route::ErrorPage404();
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action($params);
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    static function ErrorPage404()
    {
        $host = 'https://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'oops');
    }

    static function AuthPage($controller_name)
    {
        $host = 'https://'.$_SERVER['HTTP_HOST'].'/';
        setcookie('requested_url', $controller_name, time() + 3600);
        header('Location:'.$host.'auth');
    }
}