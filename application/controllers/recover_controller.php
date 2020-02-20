<?php
require_once './application/models/auth_model.php';

class recover_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new recover_model();
    }

    function action_index($params = NULL)
    {
        $this->view->generate('recover_view.php');
    }
}