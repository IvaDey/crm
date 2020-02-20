<?php
class settings_controller extends controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new settings_model();
    }

    function action_index($params = NULL)
    {
        $info = $this->model->get_info($_SESSION['id']);
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'title' => 'Настройки',
            'css_name' => 'settings.css',
            'script_name' => 'settings.js',
            'gcalendar' => Array(
                'is_authorized' => $info['gcalendar']['is_authorized'],
                'authLink' => $info['gcalendar']['authLink']
            ),
            'company_info' => $info['company_info']
        );
        $this->view->generate('template_view.php', 'settings_view.php', $data);
    }

    function action_basic()
    {
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'sub_menu_item_id' => 'sub-nav-settings-basic',
            'title' => 'Настройки – базовая информация',
            'css_name' => 'settings/basic.css',
            'script_name' => 'settings/basic.js',
            'locations' => $this->model->get_locations(),
            'service_categories' => $this->model->get_services_categories(),
            'masters' => $this->model->get_masters()
        );
        $this->view->generate('template_view.php', 'settings/basic_view.php', $data);
    }

    function action_about()
    {
        $info = $this->model->get_info($_SESSION['id']);
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'sub_menu_item_id' => 'sub-nav-settings-about',
            'title' => 'Настройки – данные о компании',
            'css_name' => 'settings/about.css',
            'script_name' => 'settings/about.js',
            'company_info' => $info['company_info']
        );
        $this->view->generate('template_view.php', 'settings/about_view.php', $data);
    }

    function action_integrations()
    {
        $info = $this->model->get_info($_SESSION['id']);
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'sub_menu_item_id' => 'sub-nav-settings-integrations',
            'title' => 'Настройки – данные о компании',
            'css_name' => 'settings/integrations.css',
            'script_name' => 'settings/integrations.js',
            'gcalendar' => Array(
                'is_authorized' => $info['gcalendar']['is_authorized'],
                'authLink' => $info['gcalendar']['authLink']
            )
        );
        $this->view->generate('template_view.php', 'settings/integrations_view.php', $data);
    }

    function action_notifications()
    {
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'sub_menu_item_id' => 'sub-nav-settings-notifications',
            'title' => 'Настройки уведомлений',
            'css_name' => 'settings/notifications.css',
            'script_name' => 'settings/notifications.js',
            'locations' => $this->model->get_locations(),
            'service_categories' => $this->model->get_services_categories(),
            'masters' => $this->model->get_masters()
        );
        $this->view->generate('template_view.php', 'settings/notifications_view.php', $data);
    }

    function action_accounts()
    {
        $data = Array(
            'menu_item_id' => 'nav-settings',
            'sub_menu_item_id' => 'sub-nav-settings-accounts',
            'title' => 'Настройки – учетные записи',
            'css_name' => 'settings/accounts.css',
            'script_name' => 'settings/accounts.js',
            'locations' => $this->model->get_locations(),
            'service_categories' => $this->model->get_services_categories(),
            'masters' => $this->model->get_masters()
        );
        $this->view->generate('template_view.php', 'settings/accounts_view.php', $data);
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