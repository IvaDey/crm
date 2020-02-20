<?php
class widget_controller extends controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Model();
    }

    function action_index($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-widget',
            'title' => 'IvaDey RBS – виджет демо',
        );
        $this->view->generate('template_view.php', 'widget_view.php', $data);
    }
}