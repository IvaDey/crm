<?php
require_once './application/models/auth_model.php';

class logout_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new auth_model();
    }

    function action_index($params = NULL)
    {
        $this->model->logout($_SESSION['user']);

        unset($_SESSION['user']);
        setcookie('access_token', '', time() - 100);

        $host = 'https://'.$_SERVER['HTTP_HOST'];
        header('Location:'.$host);
    }
}