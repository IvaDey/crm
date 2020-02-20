<?php
class base_data_controller extends controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new base_data_model();
    }

    function action_index($params = NULL)
    {
        // Нужен полноценный редирект
        $this->view->generate('404_view.php');
    }

    function action_about()
    {
        $info = $this->model->get_info($_SESSION['id']);
        $data = Array(
            'menu_item_id' => 'nav-base_data',
            'sub_menu_item_id' => 'sub-nav-base_data-about',
            'title' => 'Данные о компании',
            'css_name' => 'base_data/about.css',
            'script_name' => 'base_data/about.js',
            'company_info' => $info['company_info']
        );
        $this->view->generate('template_view.php', 'base_data/about_view.php', $data);
    }

    function action_locations()
    {
        $data = Array(
            'menu_item_id' => 'nav-base_data',
            'sub_menu_item_id' => 'sub-nav-base_data-locations',
            'title' => 'Представительства',
            'css_name' => 'base_data/locations.css',
            'script_name' => 'base_data/locations.js',
            'locations' => $this->model->get_locations()
        );
        $this->view->generate('template_view.php', 'base_data/locations_view.php', $data);
    }

    function action_services()
    {
        $data = Array(
            'menu_item_id' => 'nav-base_data',
            'sub_menu_item_id' => 'sub-nav-base_data-services',
            'title' => 'Список услуг',
            'css_name' => 'base_data/services.css',
            'script_name' => 'base_data/services.js'
        );
        $this->view->generate('template_view.php', 'base_data/services_view.php', $data);
    }

    function action_masters()
    {
        $data = Array(
            'menu_item_id' => 'nav-base_data',
            'sub_menu_item_id' => 'sub-nav-base_data-masters',
            'title' => 'Список мастеров',
            'css_name' => 'base_data/masters.css',
            'script_name' => 'base_data/masters.js'
        );
        $this->view->generate('template_view.php', 'base_data/masters_view.php', $data);
    }

    // API methods
    function action_set_gcalendar_integration()
    {
        if (!$_GET['auth_code']) {
            print_r(json_encode(Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            ), JSON_UNESCAPED_UNICODE));
            return;
        } else {
            print_r(json_encode($this->model->set_gcalendar_integration($_GET['auth_code']), JSON_UNESCAPED_UNICODE));
            return;
        }
    }

    function action_update_company_info()
    {
        $this->model->update_company_info($_SESSION['id'], Array(
            'name' => $_GET['name'] ? $_GET['name'] : '',
            'description' => $_GET['description'] ? $_GET['description'] : '',
            'address' => $_GET['address'] ? $_GET['address'] : '',
            'phone' => $_GET['phone'] ? $_GET['phone'] : '',
            'email' => $_GET['email'] ? $_GET['email'] : ''
        ));

        print_r(json_encode(Array(
            'error_code' => 0,
            'error_description' => 'ok'
        ), JSON_UNESCAPED_UNICODE));
    }
}