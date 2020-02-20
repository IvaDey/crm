<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 2019-07-16
 * Time: 04:43
 */
include_once './application/core/vk_bot.php';

class reservations_model extends model
{
    protected $vk_bot = NULL;

    function __construct()
    {
        parent::__construct();

        $this->vk_bot = new vk_bot('a5ec43b71cad43ff8d045241f388044aa33c2d8dcbe136c06ba6bc1302e1dfaf69fdae564a46fc7901c96', 172217576);
    }

    protected function notify($notify_info)
    {
        // Потенциальная структура для сообщения с уведомлением:
//         Новая запись № {$new_reservation_id}
//
//         Время: {$reservation_date} {$reservation_time}.
//         Место: {$location_name}, {$locationd_address}.
//         Услуга: {$service_name}.
//         Сотрудник: {$master_name}.
        $message = <<<eot
                Новая запись № {$notify_info['reservation_id']}
                Дата: {$notify_info['date']}
                Время: {$notify_info['time']}
eot;

        $this->vk_bot->sendMessage(181077753, $message);
    }

    // Получаем список всех записей, соттветствующих фильтру (если фильтр пустой, возвращаем все записи)
    // $filters – массив, содержащий филтры для отбора записей:
    //      date - дата, по которой необходимо фильтровать
    //      location_id – id филиала
    //      master_id – id мастера, по которому необходимо фильтровать
    //      status_id – id статуса записи, по которому необходимо фильтровать
    //      service_id – id услуги, по которой необходимо фильтровать
    public function get_reservations($filters = NULL)
    {
        //  Формируем условие выборки согласно заданным фильтрам
        $condition = 'WHERE 1';
        if (isset($filters)) {
            if ($filters['reservation_date']) {
                $condition .= " AND reservation_date LIKE '{$filters['reservation_date']}%'";
            }
            if ($filters['location_id']) {
                $condition .= " AND location_id='{$filters['location_id']}'";
            }
            if ($filters['master_id']) {
                $condition .= " AND master_id='{$filters['master_id']}'";
            }
            if ($filters['service_id']) {
                $condition .= " AND service_id='{$filters['service_id']}'";
            }
            if ($filters['status_id']) {
                $condition .= " AND status_id='{$filters['status_id']}'";
            }
        }

        $query = "SELECT *, "
            ."  (SELECT name FROM services WHERE id=service_id) AS service_name, "
            ."  (SELECT name FROM masters WHERE id=master_id) AS master_name "
            ."FROM reservations "
            ."INNER JOIN reservations_details ON reservations.id=reservations_details.reservation_id "
            ."{$condition}";
        $query = $this->db_connection->query($query);

        $result = Array();
        $prev_res_id = NULL;

        while ($row = $query->fetch_object()) {
            $tmp = "SELECT * FROM clients WHERE id='{$row->client_id}'";
            if (!($tmp = $this->db_connection->query($tmp)->fetch_object())) {
                $tmp = Array(
                    'id' => '0',
                    'name' => '0',
                    'phone' => '0',
                    'email' => '0'
                );
            }

            if ($prev_res_id != $row->id) {
                $result[$row->id] = Array(
                    'reservation_id' => $row->id,
                    'created_at' => date('j.m.Y H:i', strtotime($row->created_at)),
                    'reservation_date' => Array(
                        'date' => date('j.m.Y', strtotime($row->reservation_date)),
                        'time' => date('H:i', strtotime($row->reservation_date))
                    ),
                    'master' => Array(
                        'id' => $row->master_id,
                        'name' => $row->master_name
                    ),
                    'services_count' => $row->services_count,
                    'services' => Array(),
                    'client' => Array(
                        'id' => $tmp->id,
                        'name' => $tmp->name,
                        'phone' => $tmp->phone,
                        'email' => $tmp->email
                    ),
                    'total_duration' => $row->total_duration,
                    'total_cost' => $row->total_cost,
                    'status_id' => $row->status_id
                );
                $prev_res_id = $row->id;
            }

            array_push($result[$row->id]['services'], Array(
                'id' => $row->service_id,
                'name' => $row->service_name
            ));
        }

        return $result;
    }

    public function get_reservations_copy($filters = NULL)
    {
        //  Формируем условие выборки согласно заданным фильтрам
        $condition = 'WHERE 1';
        if (isset($filters)) {
            if ($filters['reservation_date']) {
                $condition .= " AND reservation_date LIKE '{$filters['reservation_date']}%'";
            }
            if ($filters['location_id']) {
                $condition .= " AND location_id='{$filters['location_id']}'";
            }
            if ($filters['master_id']) {
                $condition .= " AND master_id='{$filters['master_id']}'";
            }
            if ($filters['service_id']) {
                $condition .= " AND service_id='{$filters['service_id']}'";
            }
            if ($filters['status_id']) {
                $condition .= " AND status_id='{$filters['status_id']}'";
            }
        }

        $query = "SELECT *, "
            ."  (SELECT name FROM services WHERE id=service_id) AS service_name, "
            ."  (SELECT name FROM masters WHERE id=master_id) AS master_name "
            ."FROM reservations "
            ."INNER JOIN reservations_details ON reservations.id=reservations_details.reservation_id "
            ."{$condition}";
        $query = $this->db_connection->query($query);

        $result = Array();

        while ($row = $query->fetch_object()) {
            $tmp = "SELECT * FROM clients WHERE id='{$row->client_id}'";
            if (!($tmp = $this->db_connection->query($tmp)->fetch_object())) {
                $tmp = Array(
                    'id' => '0',
                    'name' => '0',
                    'phone' => '0',
                    'email' => '0'
                );
            }

            array_push($result, Array(
                'reservation_id' => $row->id,
                'created_at' => date('j.m.Y H:i', strtotime($row->created_at)),
                'reservation_date' => Array(
                    'date' => date('j.m.Y', strtotime($row->reservation_date)),
                    'time' => date('H:i', strtotime($row->reservation_date))
                ),
                'master' => Array(
                    'id' => $row->master_id,
                    'name' => $row->master_name
                ),
                'services_count' => $row->services_count,
                'service' => Array(
                    'id' => $row->service_id,
                    'name' => $row->service_name
                ),
                'client' => Array(
                    'id' => $tmp->id,
                    'name' => $tmp->name,
                    'phone' => $tmp->phone,
                    'email' => $tmp->email
                ),
                'total_duration' => $row->total_duration,
                'status_id' => $row->status_id
            ));
        }

        return $result;
    }

    // Проверяем возможность создать запись
    // На вход получает информацию о записи:
    // service_id – идентификатор услуги, на которую производится запись
    // interval – используется в случае как замена длительности услуги, если service_id == NULL
    // master_id – идентификатор мастера, к которому происходит запись
    // date – дата и время записи
    // А еще нужна проверка на то, что салон открыт в это время и мастер работает
    public function is_time_available($reservation_info)
    {
        // Сперва проверим открыт ли салон в этот день и работает ли мастер
        $day_id = date('N', strtotime($reservation_info['date']));
        $query = "SELECT working_hours_start, working_hours_end FROM masters_working_hours "
            ."WHERE master_id='{$reservation_info['master_id']}' AND day_id='{$day_id}'";
        $query = $this->db_connection->query($query)->fetch_object();
        if ($query) {
            $time = date('H:i', strtotime($reservation_info['date']));
            if (!($time >= $query->working_hours_start && $time <= $query->working_hours_end)) {
                return 0;
            }
        } else {
            return 0;
        }

        // Получаем длительность услуги
        if ($reservation_info['service_id']) {
            $query = "SELECT duration FROM services WHERE id='{$reservation_info['service_id']}'";
            $service_duration = $this->db_connection->query($query)->fetch_object()->duration;
        } else {
            $service_duration = $reservation_info['interval'];
        }

        // Получаем нужную дату записи
        $reservation_start = date('Y-m-d', strtotime($reservation_info['date']));

        // Получаем все записи к нужному мастеру на переданную дату
        // Остальные даты проверять нет необходимости, так как одна услуга выполняется в пределах одного дня
        $query = <<<eot
            SELECT reservation_date, total_duration
            FROM reservations
            INNER JOIN reservations_details ON reservations.id=reservations_details.reservation_id
            WHERE master_id='{$reservation_info['master_id']}'
                 AND reservation_date LIKE '{$reservation_start}%'
eot;
        $query = $this->db_connection->query($query);

        // Теперь проверим все записи и если хотя бы с одной будет пересечение, то возврщаем ложь
        // Получаем дату и время проверяемой записи в формате timestamp
        $pr_start = strtotime($reservation_info['date']);
        $pr_end = strtotime($reservation_info['date']) + $service_duration * 60;
        while ($row = $query->fetch_object()) {
            // Получаем время существующей
            $r_start = strtotime($row->reservation_date);
            $r_end = strtotime($row->reservation_date) + $row->total_duration * 60;

            // Проверяем потенцеальную и имеющиеся записи на пересечение
            if (!($pr_end <= $r_start || $pr_start >= $r_end)) {
                return 0;
            }
        }

        // Если все норм, то возвращаем истину
        return 1;
    }

    // Получаем подробную информацию о записи
    public function get_reservation($reservation_id)
    {
        $query = "SELECT *, "
            ."  (SELECT name FROM services WHERE id=service_id) AS service_name, "
            ."  (SELECT name FROM masters WHERE id=master_id) AS master_name "
            ."FROM reservations "
            ."INNER JOIN reservations_details ON reservations.id=reservations_details.reservation_id "
            ."WHERE id='{$reservation_id}'";
        $query = $this->db_connection->query($query);

        // Достаем первую строку и создаем результирующий маассив
        $row = $query->fetch_object();
        $result = Array(
            'reservation_id' => $row->id,
            'created_at' => date('j.m.Y H:i', strtotime($row->created_at)),
            'reservation_date' => Array(
                'date' => date('j.m.Y', strtotime($row->reservation_date)),
                'time' => date('H:i', strtotime($row->reservation_date))
            ),
            'services' => Array(Array(
                'service_id' => $row->service_id,
                'service_name' => $row->service_name,
                'master_id' => $row->master_id,
                'master_name' => $row->master_name
            )),
            'status_id' => $row->status_id
        );

        // Достаем оставшиеся строки, если они есть
        while ($row = $query->fetch_object()) {
            array_push($result['services'], Array(
                'service_id' => $row->service_id,
                'service_name' => $row->service_name,
                'master_id' => $row->master_id,
                'master_name' => $row->master_name
            ));
        }

        return $result;
    }

    // Получаем доступные варианты для записи при заданных параметрах (дата, услуга)
    public function get_available_times($date, $location_id, $service_id, $master_id)
    {
        // Зададим интервал
        $interval = 30;

        // Сперва проверим, что салон открыт в это время
        $day_id = date('N', strtotime($date));    // Номер дня недели
        $query = <<<eot
            SELECT open_at, close_at
            FROM locations
            INNER JOIN locations_working_hours ON locations.id=locations_working_hours.location_id
            WHERE id='{$location_id}' AND day_id='{$day_id}'
eot;
        $query = $this->db_connection->query($query);
        if ($query->num_rows == 0) {
            return Array(
                'error_code' => 1,
                'error_description' => 'Location is closed at the this time'
            );
        } else {
            $query = $query->fetch_object();
            $location_working_hours['open'] = $query->open_at;
            $location_working_hours['close'] = $query->close_at;
        }

        // Теперь проверим доступность мастеров на данную дату
        // Сперва получим id специализации услуги
        $query = "SELECT category_id, duration FROM services WHERE id='{$service_id}'";
        $query = $this->db_connection->query($query)->fetch_object();
        $service_category_id = $query->category_id;
        $service_duration = $query->duration;

        // Теперь получим время работы всех мастеров, имеющих данную специализацию и работающих в заданный день
        if (!$master_id)
            $master_id = '%';
        $query = <<<eot
                SELECT master_id 
                FROM 
                masters
                INNER JOIN masters_services ON masters.id=masters_services.master_id
                WHERE category_id='{$service_category_id}' AND location_id='{$location_id}' AND master_id LIKE '{$master_id}'
eot;
        $query = $this->db_connection->query($query);
        $masters = Array();

        while ($row = $query->fetch_object()) {
            $query_2 = <<<eot
                SELECT master_id, working_hours_start, working_hours_end
                FROM masters_working_hours
                WHERE day_id='{$day_id}' AND master_id='{$row->master_id}'
eot;

            $query_2 = $this->db_connection->query($query_2);
            if ($query_2 = $query_2->fetch_object()) {
                array_push($masters, Array(
                    'id' => $query_2->master_id,
                    'working_hours_start' => $query_2->working_hours_start,
                    'working_hours_end' => $query_2->working_hours_end
                ));
            }
        }
        // Если доступных мастеровов не оказалось в заданный день, то вернем ошибку с кодом 2
        if (empty($masters)) {
            return Array(
                'error_code' => 2,
                'error_description' => 'No available masters on this date'
            );
        }

        // Наконец получим доступные интервалы для записи
        $result = Array();
        foreach ($masters as $master) {
            $start = strtotime($date . $master['working_hours_start']);
            $end = strtotime($date . $master['working_hours_end']);
            $result[$master['id']] = Array();

            while ($start <= $end) {
                // Если текущий вариант раньше текущего момента времени, то пропускаем его
                if ($start < time()) {
                    $start += $interval * 60;
                    continue;
                }

                if (($this->is_time_available(Array(
                    'date' => date('j.m.Y H:i', $start),
                    'master_id' => $master['id'],
                    'service_id' => $service_id
                )))) {
                    array_push($result[$master['id']], date('H:i', $start));
                }

                $start += $interval * 60;
            }
        }

        return $result;
    }

    // Получаем список доступных мастеров для записи на заданную дату и услугу
    public function get_available_masters($date, $service_id)
    {
        // Сперва проверим, что салон открыт в это время
        $day_id = date('N', strtotime($date));    // Номер дня недели
        $query = <<<eot
            SELECT open_at, close_at
            FROM locations
            INNER JOIN locations_working_hours ON locations.id=locations_working_hours.location_id
            WHERE id='{$location_id}' AND day_id='{$day_id}'
eot;
        $query = $this->db_connection->query($query);
        if ($query->num_rows == 0) {
            return Array(
                'error_code' => 1,
                'error_description' => 'Location is closed at the this time'
            );
        } else {
            $query = $query->fetch_object();
            $location_working_hours['open'] = $query->open_at;
            $location_working_hours['close'] = $query->close_at;
        }

        // Теперь проверим доступность мастеров на данную дату
        // Сперва получим id специализации услуги
        $query = "SELECT category_id, duration FROM services WHERE id='{$service_id}'";
        $query = $this->db_connection->query($query)->fetch_object();
        $service_category_id = $query->category_id;
        $service_duration = $query->duration;

        // Теперь получим время работы всех мастеров, имеющих данную специализацию и работающих в заданный день
        $query = "SELECT master_id FROM masters_services WHERE category_id='{$service_category_id}'";
        $query = $this->db_connection->query($query);
        $masters = Array();

        while ($row = $query->fetch_object()) {
            $query_2 = <<<eot
                SELECT master_id, working_hours_start, working_hours_end
                FROM masters_working_hours
                WHERE day_id='{$day_id}' AND master_id='{$row->master_id}'
eot;

            $query_2 = $this->db_connection->query($query_2);
            if ($query_2 = $query_2->fetch_object()) {
                array_push($masters, Array(
                    'id' => $query_2->master_id,
                    'working_hours_start' => $query_2->working_hours_start,
                    'working_hours_end' => $query_2->working_hours_end
                ));
            }
        }
        // Если доступных мастеровов не оказалось в заданный день, то вернем ошибку с кодом 2
        if (empty($masters)) {
            return Array(
                'error_code' => 2,
                'error_description' => 'No available masters on this date'
            );
        }

        return $result;
    }

    // Получаем ближайшее время записи к заданному мастеру (не более 5 меток)
    // master_id – id мастера, для которого необходимо найти ближайшее время на запись
    // interval – временной промежуток необходимого свободного времени, в минутах
    public function get_closest_master_time($master_id, $interval)
    {
        // Получаем текущее время и округляем в большую сторону до ближайшего круглого значения, кратного 30 минутам
        $cur_time = time();
        $strt = $cur_time;
        $m = Date('i', $cur_time);
        while ($m % 30 != 0) {
            $cur_time += 60;
            $m = Date('i', $cur_time);
        }

        // Получаем время работы мастера
        $wh = Array();
        $query = <<<eot
                SELECT working_hours_start AS wh_start, working_hours_end AS wh_end, day_id
                FROM masters_working_hours
                WHERE master_id='{$master_id}'
eot;
        $query = $this->db_connection->query($query);
        while ($row = $query->fetch_object()) {
            $wh[$row->day_id] = Array(
                'wh_start' => Date('H:i', strtotime($row->wh_start)),
                'wh_end' => Date('H:i', strtotime($row->wh_end))
            );
        }

        // Создаем результирующий массив
        $result = Array(
            'date' => NULL,
            'time_items' => Array()
        );

        // Пока в массиве меньше 5 записей – ищем
        while (count($result['time_items']) < 5) {
            // Если у нас уже есть варианты, но текущая дата отличается от них, то выходим из цикла
            if ($result['date'] && $result['date'] != date('j.m', $cur_time))
                break;

            // Сперва проверим, что текущая временная метка попадает в промежуток работы мастера
            $day_id = Date('N', $cur_time);
            $time = Date('H:i', $cur_time);

            if (isset($wh[$day_id]) && $time >= $wh[$day_id]['wh_start'] && $time <= $wh[$day_id]['wh_end']) {
                // Если время свободно, то добавляем этот вариант в массив
                if ($this->is_time_available(Array(
                    'date' => date('j.m.Y H:i', $cur_time),
                    'master_id' => $master_id,
                    'interval' => $interval
                ))) {
                    if (!$result['date']) {
                        $result['date'] = date('j.m', $cur_time);
                    }
                    array_push($result['time_items'], Date('G:i', $cur_time));
                }
            }

            // Прибавляем 30 минут
            $cur_time += 30 * 60;
            if (($cur_time - $strt) / 60 / 60 / 24 > 7) {
                return '1';
            }
        }

        return $result;
    }

    // Пока что три фильтра
    // По филиалу – location_id
    // По категории оказываемых услуг – category_id
    // По выбранному времени записи – reservation_date
    // Также может быть передан id услуги, но он нужен не для фильтрации мастеров, а установки интервала поиска
    //      ближайшего времени для записи. По умолчанию он равен 30 минутам
    function get_masters($filters = [])
    {
        if ($filters['location_id'] && $filters['category_id']) {
            $query = <<<eot
                SELECT *
                FROM masters
                INNER JOIN masters_services ON masters.id=masters_services.master_id
                WHERE category_id='{$filters['category_id']}' AND location_id='{$filters['location_id']}'
eot;
        } elseif ($filters['category_id']) {
            $query = <<<eot
                SELECT *
                FROM masters
                INNER JOIN masters_services ON masters.id=masters_services.master_id
                WHERE category_id='{$filters['category_id']}'
eot;
        } elseif ($filters['location_id']) {
            $query = <<<eot
                SELECT *
                FROM masters
                WHERE location_id='{$filters['location_id']}'
eot;
        } else {
            $query = "SELECT * FROM masters";
        }
        $query = $this->db_connection->query($query);

        $result = Array();
        while ($row = $query->fetch_object()) {
            // Если задано время записи, то проверим свободен ли мастер
            if ($filters['reservation_date']) {
                if (!$this->is_time_available(Array(
                    'service_id' => $filters['service_id'],
                    'interval' => 30,
                    'master_id' => $row->id,
                    'date' => $filters['reservation_date']['date'] . ' ' . $filters['reservation_date']['time']
                ))) {
                    continue;
                }
            }

            // Получаем ближайшее доступное время
            if ($filters['service_id']) {
                $tmp = "SELECT duration FROM services WHERE id='{$filters['service_id']}'";
                $tmp = $this->db_connection->query($tmp)->fetch_object()->duration;

                $closest_time = $this->get_closest_master_time($row->id, $tmp);
            } else {
                $closest_time = $this->get_closest_master_time($row->id, 30);
            }

            array_push($result, Array(
                'id' => $row->id,
                'location_id' => $row->location_id,
                'name' => $row->name,
                'description' =>$row->description,
                'photo' => $row->photo,
                'rating' => $row->rating,
                'closest_available_time' => $closest_time
            ));
        }

        return $result;
    }

    // Создаем новую запись
    // Надо добавить предварительную проверку о том, что заданное время и мастер доступны для записи
    public function add_reservations($reservation_info)
    {
        $default_status_id = 1;

        $query = <<<EOT
            INSERT INTO clients(name, phone, email) VALUES(
                '{$reservation_info['client']['name']}',
                '{$reservation_info['client']['phone']}',
                '{$reservation_info['client']['email']}'
            )
EOT;
        $this->db_connection->query($query);

        // Получаем id только что добавленного клиента
        $query = "SELECT MAX(id) as id FROM clients";
        $new_client_id = $this->db_connection->query($query)->fetch_object()->id;
        $services_count = count($reservation_info['services']);

        // Создаем новую запись
        $query = <<<EOT
            INSERT INTO reservations(location_id, reservation_date, services_count, client_id, status_id)
            VALUES(
                '{$reservation_info['location_id']}',
                '{$reservation_info['reservation_date']}',
                '{$services_count}',
                '{$new_client_id}',
                '{$default_status_id}'
            )
EOT;
        $this->db_connection->query($query);

        // Получаем id только что сделанной записи и вносим в БД информацию об услугах
        $query = "SELECT MAX(id) as id FROM reservations";
        $new_reservation_id = $this->db_connection->query($query)->fetch_object()->id;
        $total_duration = 0;
        $total_cost = 0;
        foreach ($reservation_info['services'] as $service) {
            // Добавляем услугу в БД
            $query = <<<EOT
            INSERT INTO reservations_details(reservation_id, service_id, master_id) VALUES(
                '{$new_reservation_id}',
                '{$service['service_id']}',
                '{$service['master_id']}'
            )
EOT;
            $this->db_connection->query($query);

            $query = "SELECT duration, price FROM services WHERE id='{$service['service_id']}'";
            $query = $this->db_connection->query($query)->fetch_object();
            $total_duration += $query->duration;
            $total_cost += $query->price;

            // Добавляем услугу в гугл календарь
            // Сперва получаем индетификатор календаря выбранного мастера
            $query = "SELECT calendar_id FROM masters WHERE id='{$service['master_id']}'";
            $calendar_id = $this->db_connection->query($query)->fetch_object()->calendar_id;
            // Теперь получаем название услуги
            $query = "SELECT name FROM services WHERE id='{$service['service_id']}'";
            $service_name = $this->db_connection->query($query)->fetch_object()->name;
            // Получаем адрес филиала, в который произведена запись
            $query = "SELECT address FROM locations WHERE id='{$reservation_info['location_id']}'";
            $address = $this->db_connection->query($query)->fetch_object()->address;
            // Создаем событие
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $service_name,
                'location' => $address,
                'description' => "Клиент: {$reservation_info['client']['name']}\n"
                                ."Телефон: {$reservation_info['client']['phone']}\n"
                                ."Почта: {$reservation_info['client']['email']}\n",
                'start' => array(
                    'dateTime' => date('Y-m-d\TH:i:sP', strtotime($reservation_info['reservation_date']))
                ),
                'end' => array(
                    'dateTime' => date('Y-m-d\TH:i:sP', strtotime($reservation_info['reservation_date']) + $service_duration * 60)
                ),
                'reminders' => array(
                    'useDefault' => FALSE
                )
            ));
            // По хорошему нужно добавлять все ссылки на ивенты в массив и возвращать его
            $event_link = $this->gcalendar->createEvent($calendar_id, $event);
            $query = "UPDATE reservations SET gcalendar_event_link='{$event_link}' WHERE id='{$new_reservation_id}'";
            $this->db_connection->query($query);
        }

        // Добавляем в БД информацию об общей длительности услуг
        $query = "UPDATE reservations SET total_duration='{$total_duration}', total_cost='{$total_cost}' WHERE id='{$new_reservation_id}'";
        $this->db_connection->query($query);

        // Уведомляем о новой записи
        $this->notify(Array(
            'reservation_id' =>$new_reservation_id,
            'date' => date('j.m.Y', strtotime($reservation_info['date'])),
            'time' => date('H:i', strtotime($reservation_info['date']))
        ));

        // Возвращаем id только что сделанной записи
        return $new_reservation_id;
    }

    // Редактируем заданную запись
    // Надо добавить предварительную проверку о том, что заданное время и мастер доступны для записи
    public function change_reservations($reservation_id, $new_data)
    {
        // Удаляем детали записи и заносим новые
        // Удаление старых данных
        $query = "DELETE FROM reservations_details WHERE reservation_id='{$reservation_id}'";
        $this->db_connection->query($query);
        // Добавление новых
        $total_duration = 0;
        foreach ($new_data['services'] as $service) {
            $query = <<<EOT
            INSERT INTO reservations_details(reservation_date, client_id, status_id) VALUES(
                '{$reservation_id}',
                '{$service['service_id']}',
                '{$service['master_id']}'
            )
EOT;
            $this->db_connection->query($query);

            $query = "SELECT duration FROM dervices WHERE id='{$service->service_id}'";
            $total_duration += $this->db_connection->query($query)->fetch_object()->duration;
        }

        // Обновляем оснвную информацию о бронировании
        $query = <<<EOT
            UPDATE reservations
                SET n='{$new_data['reservation_date']}',
                SET total_duration='{$total_duration}'
            )
EOT;
        $this->db_connection->query($query);
    }

    // Меняем статус заданной записи
    public function change_reservations_status($reservation_id, $new_status)
    {
        $query = "UPDATE reservations SET status_id='{$new_status}' WHERE id='{$reservation_id}'";
        $this->db_connection->query($query);
        return '0';
    }

    // Удаление записи
    public function delete_reservation($reservation_id)
    {
        $query = "DELETE FROM reservations WHERE id='{$reservation_id}'";
        $this->db_connection->query($query);

        return '0';
    }
}





























