<?php
class main_model extends model {

    // Модифицирующие методы

    // Работа с филиалами
    function add_location($location_info)
    {
        // Добавляем новый филиал в БД
        $query = "INSERT INTO locations(name, address) VALUES("
            . "'" . $location_info['location_name'] . "', '" . $location_info['location_address'] . "')";
        $this->db_connection->query($query);

        // Получаем ID только что добавленного филиала
        $query = "SELECT MAX(id) AS id FROM locations";
        $query = $this->db_connection->query($query);
        $new_location_id = $query->fetch_object()->id;

        // Добавляем в БД информацию о времени работы нового филиала
        foreach ($location_info['location_working_hours'] as $day_id => $working_hours) {
            $query = "INSERT INTO locations_working_hours(location_id, day_id, open_at, close_at) VALUES("
                ."'{$new_location_id}', '{$day_id}'" . ", '" . $working_hours['open'] . "', '" . $working_hours['close'] . "')";
            $this->db_connection->query($query);
        }

        return $new_location_id;
    }

    function change_location_info($location_info)
    {
        // Обновляем основную инфу об филиале
        $query = "UPDATE locations set "
            ."name='" . $location_info['location_name'] . "', "
            ."address='" . $location_info['location_address'] . "' "
            ."WHERE id='" . $location_info['location_id'] . "'";
        $this->db_connection->query($query);

        // Обновляем часы работы филиала
        foreach ($location_info['location_working_hours'] as $day_id => $working_hours) {
            $query = "UPDATE locations_working_hours set "
                ."open_at='" . $working_hours['open'] . "', "
                ."close_at='" . $working_hours['close'] . "' "
                ."WHERE location_id='" . $location_info['location_id'] . "' AND day_id='{$day_id}'";
            $this->db_connection->query($query);
        }
    }

    function delete_location($location_id)
    {
        $query = "DELETE FROM locations WHERE id='{$location_id}'";
        $this->db_connection->query($query);

        $query = "DELETE FROM locations_working_hours WHERE location_id='{$location_id}'";
        $this->db_connection->query($query);
    }

    // Работа с категориями услуг
    function add_category($category_name)
    {
        // Добавляем новую категорию в БД
        $query = "INSERT INTO service_categories(name) VALUES('{$category_name}')";
        $this->db_connection->query($query);

        // Получаем ID только что добавленной категории
        $query = "SELECT MAX(id) AS id FROM service_categories";
        $query = $this->db_connection->query($query);
        $new_category_id = $query->fetch_object()->id;

        return $new_category_id;
    }

    function change_category_info($category_info)
    {
        // Обновляем основную инфу об филиале
        $query = "UPDATE service_categories set "
            ."name='" . $category_info['category_name'] . "' "
            ."WHERE id='" . $category_info['category_id'] . "'";
        $this->db_connection->query($query);
    }

    function delete_category($category_id)
    {
        $query = "DELETE FROM service_categories WHERE id='{$category_id}'";
        $this->db_connection->query($query);
    }

    // Работа с услугами
    function add_service($service_info)
    {
        // Добавляем новую услугу в БД
        $query = "INSERT INTO services(name, description, price, duration, category_id) VALUES("
            . "'" . $service_info['name'] . "', "
            . "'" . $service_info['description'] . "', "
            . "'" . $service_info['price'] . "', "
            . "'" . $service_info['duration'] . "', "
            . "'" . $service_info['category_id'] . "')";
        $this->db_connection->query($query);

        // Получаем ID только что добавленной услуги
        $query = "SELECT MAX(id) AS id FROM services";
        $query = $this->db_connection->query($query);
        $new_service_id = $query->fetch_object()->id;

        return $new_service_id;
    }

    function change_service_info($service_info)
    {
        // Обновляем основную инфу об услуге
        $query = "UPDATE services set "
            ."name='" . $service_info['name'] . "', "
            ."description='" . $service_info['description'] . "', "
            ."price='" . $service_info['price'] . "', "
            ."duration='" . $service_info['duration'] . "', "
            ."category_id='" . $service_info['category_id'] . "' "
            ."WHERE id='" . $service_info['id'] . "'";
        $this->db_connection->query($query);
    }

    function delete_service($id)
    {
        $query = "DELETE FROM services WHERE id='{$id}'";
        $this->db_connection->query($query);
    }

    // Работа с мастерами
    function add_master($master_info)
    {
        $new_master_avatar = 'default.png';

        // Создаем календарь для мастера
        $gcal = $this->gcalendar->createNewCalendar($master_info['name']);

        // Добавляем нового мастера в БД
        $query = "INSERT INTO masters(location_id, name, description, photo, calendar_link, calendar_id) VALUES("
            . "'{$master_info['location_id']}', "
            . "'{$master_info['name']}', "
            . "'{$master_info['description']}', "
            . "'default.png', "
            . "'{$gcal['link']}', "
            . "'{$gcal['id']}')";
        $this->db_connection->query($query);

        // Получаем ID только что добавленного мастера
        $query = "SELECT MAX(id) AS id FROM masters";
        $query = $this->db_connection->query($query);
        $new_master_id = $query->fetch_object()->id;

        // Проверяем есть ли фото, если да, то сохраняем его и добавляем в БД
        if ($master_info['add_photo']) {
            // Загружаем фотографию мастера на сервер
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/images/masters/';
            $file_name = 'master_' . $new_master_id;
            $file_extension = '.' . explode('/', $master_info['master_photo']['type'])[1];

            move_uploaded_file($master_info['master_photo']['tmp_name'], $upload_path . $file_name . $file_extension);

            // Обновляем данные в БД
            $query = "UPDATE masters set photo='master_{$new_master_id}{$file_extension}' WHERE id='{$new_master_id}'";
            $this->db_connection->query($query);

            $new_master_avatar = "master_{$new_master_id}{$file_extension}";
        }

        // Добавляем список специализаций мастера
        if (!empty($master_info['specialisations'])) {
            foreach ($master_info['specialisations'] as $specialisation) {
                $query = "INSERT INTO masters_services(master_id, category_id) VALUES("
                    . "'{$new_master_id}', '{$specialisation}')";
                $this->db_connection->query($query);
            }
        }

        // Добавляем рабочее время мастера
        foreach ($master_info['working_hours'] as $day_id => $working_hours) {
            // Если время задано, то добавляем его в БД, иначе ничего не делаем
            if ($working_hours->open && $working_hours->close) {
                $query = "INSERT INTO masters_working_hours(master_id, day_id, working_hours_start, working_hours_end) VALUES("
                    . "'{$new_master_id}', "
                    . "'{$day_id}', "
                    . "'{$working_hours->open}', "
                    . "'{$working_hours->close}')";
                $this->db_connection->query($query);
            }
        }

        return Array(
            'new_master_id' => $new_master_id,
            'new_master_avatar' => $new_master_avatar,
            'calendar_id' => $gcal['id'],
            'calendar_link' => $gcal['link']
        );
    }

    function add_master_calendar($master_id, $master_name) {
        $gcal = $this->gcalendar->createNewCalendar($master_name);

        $query = "UPDATE masters SET calendar_link='{$gcal['link']}', calendar_id='{$gcal['id']}' WHERE id='{$master_id}'";
        $this->db_connection->query($query);

        return $gcal['link'];
    }

    function change_master_info($master_info)
    {
        // Обновляем основную инфу о мастере
        $query = "UPDATE masters set "
            ."location_id='" . $master_info['location_id'] . "', "
            ."name='" . $master_info['name'] . "', "
            ."description='" . $master_info['description'] . "' "
            ."WHERE id='" . $master_info['id'] . "'";
        $this->db_connection->query($query);

        // Проверяем есть ли фото, если да, то обновляем его и добавляем в БД, если до этого была ава по умолчанию
        $query = "SELECT photo FROM masters WHERE id='{$master_info['id']}'";
        $master_photo = $this->db_connection->query($query)->fetch_object()->photo;
        if ($master_info['add_photo']) {
            // Сформируем нужные данные
            $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/images/masters/';
            $file_name = 'master_' . $master_info['id'] . '_t' . time();
            $file_extension = '.' . explode('/', $master_info['master_photo']['type'])[1];

            // Сперва проверим есть ли уже автарка
            // Если да, удаляем ее
            // Иначе меняем запись в БД
            if ($master_photo != 'default.png') {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/images/masters/' . $master_photo);
                $query = "UPDATE masters set photo='{$file_name}{$file_extension}' WHERE id='{$master_info['id']}'";
                $this->db_connection->query($query);
            } else {
                $query = "UPDATE masters set photo='{$file_name}{$file_extension}' WHERE id='{$master_info['id']}'";
                $this->db_connection->query($query);
            }

            // Загружаем фотографию мастера на сервер
            move_uploaded_file($master_info['master_photo']['tmp_name'], $upload_path . $file_name . $file_extension);
            $master_photo = $file_name . $file_extension;
        }

        // Обновялем специализации мастере
        // Сперва удалим все предыдущие специализации
        $query = "DELETE FROM masters_services WHERE master_id='{$master_info['id']}'";
        $this->db_connection->query($query);

        // Теперь доавим новые (хотя по хорошему, конечно, делать надо не так...)
        // Добавляем список специализаций мастера
        if (!empty($master_info['specialisations'])) {
            foreach ($master_info['specialisations'] as $specialisation) {
                $query = "INSERT INTO masters_services(master_id, category_id) VALUES("
                    . "'{$master_info['id']}', '{$specialisation}')";
                $this->db_connection->query($query);
            }
        }

        // Обновляем рабочие часы местера
        // Сперва удалим предыдущие данные
        $query = "DELETE FROM masters_working_hours WHERE master_id='{$master_info['id']}'";
        $this->db_connection->query($query);

        foreach ($master_info['working_hours'] as $day_id => $working_hours) {
            // Если время задано, то добавляем его в БД, иначе ничего не делаем
            if ($working_hours->open && $working_hours->close) {
                $query = "INSERT INTO masters_working_hours(master_id, day_id, working_hours_start, working_hours_end) VALUES("
                    . "'{$master_info['id']}', "
                    . "'{$day_id}', "
                    . "'{$working_hours->open}', "
                    . "'{$working_hours->close}')";
                $this->db_connection->query($query);
            }
        }

        return $master_photo;
    }

    function delete_master($params)
    {
        // Проверяем надо ли удалять календарь
        if ($params['delete_calendar']) {
            $query = "SELECT calendar_id FROM masters WHERE id='{$params['id']}'";
            $calendar_id = $this->db_connection->query($query)->fetch_object()->calendar_id;

            try {
                $this->gcalendar->deleteCalendar($calendar_id);
            }
            catch (Exception $e) {
            }
        }

        // Удаляем фотографию мастера
        $query = "SELECT photo FROM masters WHERE id='{$params['id']}'";
        $master_photo = $this->db_connection->query($query)->fetch_object()->photo;
        if ($master_photo != 'default.png') {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/images/masters/' . $master_photo);
        }

        // Удаляем основную информацию
        $query = "DELETE FROM masters WHERE id='{$params['id']}'";
        $this->db_connection->query($query);

        // Удаляем информацию о специализациях
        $query = "DELETE FROM masters_services WHERE master_id='{$params['id']}'";
        $this->db_connection->query($query);

        // Удаляем отзывы о мастере
        // Хотя может и не стоит, надо подумать
        // Вообще в идеале при удалению надо будет задавать вопрос
        // на подтверждение удаления и найстройками

        // Удалаяем информацию о времени работы
        $query = "DELETE FROM masters_working_hours WHERE master_id='{$params['id']}'";
        $this->db_connection->query($query);
    }
}

























