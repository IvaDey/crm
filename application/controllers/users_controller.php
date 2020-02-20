<?php
class users_controller extends controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new users_model();
    }


    function action_index($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-users',
            'css_name' => 'users.css',
            'script_name' => 'users.js',
            'title' => 'IvaDey journal – пользователи и клиенты',
            'usersList' => $this->model->getUsers(),
            'clientsList' => $this->model->getClients()
        );
//        echo '<pre>'; print_r($data); return;
        $this->view->generate('template_view.php', 'users_view.php', $data);
    }

    //------------------------------------------------------------------------------------------------------------------
    // API методы для получения списка пользователей и клиентов, а также данных о них
    //------------------------------------------------------------------------------------------------------------------

    // Параметр offset в данном случае представляет собой номер страницы а не реальное численное смещение
    // На данный момент установлен неизменяемый лимит выдачи результатов по умолчанию в размере 25 записей
    public function action_getUsers()
    {
        if ($_GET['offset']) {
            print_r(json_encode(Array(
                'usersList' => $this->model->getUsers($_GET['offset'])
            )));
        } else {
            print_r(json_encode(Array(
                'usersList' => $this->model->getUsers()
            )));
        }
    }

    // Параметр offset в данном случае представляет собой номер страницы а не реальное численное смещение
    // На данный момент установлен неизменяемый лимит выдачи результатов по умолчанию в размере 25 записей
    public function action_getClients()
    {
        if ($_GET['offset']) {
            print_r(json_encode(Array(
                'clientsList' => $this->model->getClients($_GET['offset'])
            )));
        } else {
            print_r(json_encode(Array(
                'clientsList' => $this->model->getClients()
            )));
        }
    }

    //------------------------------------------------------------------------------------------------------------------
    // API методы авторизации, регистрации, деавторизации и подобного
    //------------------------------------------------------------------------------------------------------------------
    function action_login($params = NULL)
    {
        if (!$_GET['login'] || !$_GET['password']) {
            print_r(json_encode(Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            ), JSON_UNESCAPED_UNICODE));
            return;
        }

        print_r(json_encode($this->model->auth($_GET['login'], $_GET['password']), JSON_UNESCAPED_UNICODE));
    }

    function action_signup($params = NULL)
    {
        if (!$_GET['login'] || !$_GET['password'] ||
            !$_GET['name'] || !$_GET['phone']) {
            print_r(json_encode(Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            ), JSON_UNESCAPED_UNICODE));
            return;
        }

        print_r(json_encode($this->model->sign_up(Array(
            'login' => $_GET['login'],
            'password' => $_GET['password'],
            'name' => $_GET['name'],
            'surname' => $_GET['surname'],
            'phone' => $_GET['phone'],
            'email' => $_GET['email']
        )), JSON_UNESCAPED_UNICODE));
    }

    function action_check_username($params = NULL)
    {
        if (!$_GET['login']) {
            print_r(json_encode(Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            ), JSON_UNESCAPED_UNICODE));
            return;
        }

        print_r(json_encode($this->model->check_username($_GET['login']), JSON_UNESCAPED_UNICODE));
    }
}