<?php
class sign_up_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new sign_up_model();
    }

    function action_index($params = NULL)
    {
        $this->view->generate('sign_up_view.php');
    }
}