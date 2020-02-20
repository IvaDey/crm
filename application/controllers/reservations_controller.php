<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 2019-07-16
 * Time: 04:42
 */

class reservations_controller extends controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new reservations_model();
    }

    // Обработчики страниц
    public function action_index($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-reservations',
            'css_name' => 'reservations.css',
            'script_name' => 'reservations.js',
            'title' => 'Онлайн журнал',
            'reservations_list' => $this->model->get_reservations(),
            'locations' => $this->model->get_locations(),
            'services' => $this->model->get_services(),
            'services_categories' => $this->model->get_services_categories(),
            'masters' => (object)$this->model->get_masters()
        );
        $this->view->generate('template_view.php', 'reservations_view.php', $data);
    }

    // Обработчики API
    // Получение списка всех записей
    public function action_get_reservations($params = NULL)
    {
        $filters = Array(
            'reservation_date' =>  $_GET['reservation_date'] ? date('Y-m-d', strtotime($_GET['reservation_date'])) : 0,
            'location_id' => $_GET['location_id'] ? $_GET['location_id'] : 0,
            'master_id' => $_GET['master_id'] ? $_GET['master_id'] : 0,
            'service_id' => $_GET['service_id'] ? $_GET['service_id'] : 0,
            'status_id' => $_GET['status_id'] ? $_GET['status_id'] : 0
        );
//        echo '<pre>'; print_r($filters); return;

        print_r(json_encode($this->model->get_reservations($filters), JSON_UNESCAPED_UNICODE));
    }

    // Проверяем возможность создать запись
    public function action_is_time_available($params = NULL)
    {
        if ($_GET['master_id'] && ($_GET['service_id'] || $_GET['interval']) && $_GET['date']) {
            if ($this->model->is_time_available($_GET)) {
                print_r(json_encode(Array(
                    'available' => 1
                )));
            } else {
                print_r(json_encode(Array(
                    'available' => 0
                )));
            }
        } else {
            print_r(json_encode(Array(
                'error_code' => 'Parameters not found'
            )));
        }
    }

    // Получениу подробной информации о записи
    public function action_get_reservation($params = NULL)
    {
        if ($_GET['id']) {
            print_r(json_encode($this->model->get_reservation($_GET['id']), JSON_UNESCAPED_UNICODE));
        } else {
            print_r(json_encode(Array(
                'error_code' => 'Not found'
            )));
        }
    }

    // Получаем доступные интервалы для записи при заданных параметрах (дата, услуга, мастер)
    public function action_get_available_times($params = NULL)
    {
        if ($_GET['date'] && $_GET['location_id'] && $_GET['service_id']) {
            print_r(json_encode($this->model->get_available_times($_GET['date'], $_GET['location_id'], $_GET['service_id'], $_GET['master_id']), JSON_UNESCAPED_UNICODE));
        } else {
            print_r(json_encode(Array(
                'error_code' => 'Parameters error'
            )));
        }
    }

    // Получаем ближайшее время записи к заданному мастеру на необходимую услугу
    public function action_get_closest_master_time($params = NULL)
    {
        $filters = Array(
            'master_id' => $_GET['master_id'],
            'interval' => $_GET['interval']
        );
        if ($filters['master_id'] && $filters['interval']) {
            $result = $this->model->get_closest_master_time($filters['master_id'], $filters['interval']);
            if ($result == '1') {
                $result = Array(
                    'error_code' => '1',
                    'error_message' => 'No available time items at the closest 7 days'
                );
            } else {
                $result = Array(
                    'error_code' => '0',
                    'date' => $result['date'],
                    'time_items' => $result['time_items']
                );
            }
        } else {
            $result = Array(
                'error_code' => '2',
                'error_message' => 'Parameters error'
            );
        }
        print_r(json_encode($result, JSON_UNESCAPED_UNICODE));

    }

    // Получаем мастеров
    // Отличие от аналогичного метода в базовой модели и контроллере main в том, что
    // здесь мы дополнительно возвращаем ближайщие варианты для записи к мастеру
    function action_get_masters($params = NULL)
    {
        $filters = Array(
            'location_id' => $_GET['location_id'],
            'category_id' => $_GET['category_id']
        );
        if ($_GET['reservation_date']['date'] && $_GET['reservation_date']['time']) {
            $filters['reservation_date'] = $_GET['reservation_date'];
        }
        if ($_GET['service_id']) {
            $filters['service_id'] = $_GET['service_id'];
        }
        $result = $this->model->get_masters($filters);
        if (count($result))
            print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
        else print_r('0');
    }

    // Создаем новую запись
    public function action_add_reservation($params = NULL)
    {
        $reservation_info = Array(
            'location_id' => $_GET['location_id'],
            'reservation_date' => Date('Y-m-d H:i', strtotime($_GET['reservation_date']['date'] . ' ' . $_GET['reservation_date']['time'])),
            'services' => $_GET['services'],
            'client' => $_GET['client']
        );
        print_r(json_encode($this->model->add_reservations($reservation_info), JSON_UNESCAPED_UNICODE));
    }

    // Редактируем заданную запись
    public function action_change_reservations($params = NULL)
    {
    }

    // Меняем статус заданной записи
    public function action_change_reservation_status($params = NULL)
    {
        if ($_GET['reservation_id'] && $_GET['new_status']) {
            print_r(json_encode(Array(
                'error_code' => $this->model->change_reservations_status($_GET['reservation_id'], $_GET['new_status'])
            )));
        } else {
            print_r(json_encode(Array(
                'error_code' => 'Not found'
            )));
        }
    }

    // Удаление записи
    public function action_delete_reservation($params = NULL)
    {
        if ($_GET['id']) {
            print_r(json_encode(Array(
                'error_code' => $this->model->delete_reservation($_GET['id'])
            )));
        } else {
            print_r(json_encode(Array(
                'error_code' => 'Not found'
            )));
        }
    }
}