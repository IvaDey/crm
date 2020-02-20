<?php
class oops_controller extends controller
{
    function action_index($params = NULL)
    {
        $this->view->generate('404_view.php');
    }
}