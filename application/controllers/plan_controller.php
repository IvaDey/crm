<?php
class plan_controller extends controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function action_index($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-plan',
            'title' => 'Тариф'
//            'css_name' => 'settings.css',
//            'script_name' => 'settings.js',
        );
        $this->view->generate('template_view.php', 'plan_view.php', $data);
    }
}