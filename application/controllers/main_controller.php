<?php
class main_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new main_model();
    }

    // Read only методы

    function action_index($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-home',
            'title' => 'Главная',
            'css_name' => 'main.css',
            'script_name' => 'main.js'
        );
        $this->view->generate('template_view.php', 'main_view.php', $data);
    }

    function action_get_services($params = NULL)
    {
        $result = $this->model->get_services($_GET['category_id']);
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r('0');
    }

    function action_get_master($params = NULL)
    {
        $result = $this->model->get_master($_GET['id']);
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r('0');
    }

    function action_get_masters($params = NULL)
    {
        $filters = Array(
            'location_id' => $_GET['location_id'],
            'category_id' => $_GET['category_id'],
            'reservation_date' => $_GET['reservation_date']
        );
        $result = $this->model->get_masters($filters);
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r(json_encode(Array()));
    }

    function action_get_location($params = NULL)
    {
        $result = $this->model->get_location($_GET['location_id']);
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r('0');
    }

    function action_get_locations($params = NULL) {
        $result = $this->model->get_locations();
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r(json_encode(Array(
            'error_code' => '1',
            'error_name' => 'Locations not found'
        ), JSON_UNESCAPED_UNICODE));
    }

    // Модифицирующие методы

    // Работа с филиалами
    function action_add_location($params = NULL)
    {
        $result = Array(
            'new_location_id' => $this->model->add_location($_GET)
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    function action_change_location_info($params = NULL)
    {
        $this->model->change_location_info($_GET);
        print_r(0);
    }

    function action_delete_location($params = NULL)
    {
        $this->model->delete_location($_GET['location_id']);
        print_r('0');
    }

    // Работа с категориями услуг
    function action_add_category($params = NULL)
    {
        $result = Array(
            'new_category_id' => $this->model->add_category($_GET['category_name'])
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    function action_change_category_info($params = NULL)
    {
        $this->model->change_category_info($_GET);
        print_r(0);
    }

    function action_delete_category($params = NULL)
    {
        $this->model->delete_category($_GET['category_id']);
        print_r('0');
    }

    // Работа с услугами
    function action_add_service($params = NULL)
    {
        $result = Array(
            'new_service_id' => $this->model->add_service($_GET)
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    function action_change_service_info($params = NULL)
    {
        $this->model->change_service_info($_GET);
        print_r(0);
    }

    function action_delete_service($params = NULL)
    {
        $this->model->delete_service($_GET['id']);
        print_r('0');
    }

    function action_get_grouped_services($params = NULL)
    {
        $result = $this->view->generate_json_data($this->model->get_grouped_services());
        print_r($result);
    }

    // Работа с мастерами
    function action_add_master($params = NULL)
    {
        $master_info = Array(
            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'add_photo' => (bool)$_REQUEST['add_photo'],
            'location_id' => $_REQUEST['location_id'],
            'working_hours' => json_decode($_REQUEST['working_hours']),
            'specialisations' => json_decode($_REQUEST['specialisations']),
            'master_photo' => $_FILES['photo']
        );
        $result = Array(
            'new_master' => $this->model->add_master($master_info)
        );

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    function action_add_master_calendar($params = NULL)
    {
        $master_info = Array(
            'id' => $_GET['id'],
            'name' => $_GET['name']
        );

        if (!($master_info['id'] && $master_info['name'])) {
            $result = Array(
                'error_code' => 2,
                'error_description' => 'Parameters error'
            );
        } else {
            $result = Array(
                'error_code' => 0,
                'error_description' => 'ok',
                'gcal' => $this->model->add_master_calendar($master_info['id'], $master_info['name'])
            );
        }

        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    function action_change_master_info($params = NULL)
    {
        $master_info = Array(
            'id' => $_REQUEST['id'],
            'name' => $_REQUEST['name'],
            'description' => $_REQUEST['description'],
            'add_photo' => (bool)$_REQUEST['add_photo'],
            'location_id' => $_REQUEST['location_id'],
            'working_hours' => json_decode($_REQUEST['working_hours']),
            'specialisations' => json_decode($_REQUEST['specialisations']),
            'master_photo' => $_FILES['photo']
        );
        print_r(json_encode(Array(
            'new_photo' => $this->model->change_master_info($master_info)
        ), JSON_UNESCAPED_UNICODE));
    }

    function action_delete_master($params = NULL)
    {
        $params = Array(
            'id' => $_GET['id'],
            'delete_calendar' => $_GET['delete_calendar'] == 'true' ? true : false
        );
        $this->model->delete_master($params);
        print_r('0');
    }
}


































