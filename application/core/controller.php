<?php
class controller
{
    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    function action_index($params = NULL)
    {
    }
}