<?php
include_once 'application/core/google_calendar.php';

class model
{
    protected $db_connection;
    protected $gcalendar;

    protected $db_user = 'cryptomoni_rbs2';
    protected $db_password = 'muxcIb-cewrys-pynko7';
    protected $db_name = 'cryptomoni_rbs2';
    protected $db_host = 'localhost';
    protected $db_port = 3306;

    function __construct()
    {
        $this->db_connection = new mysqli(
            $this->db_host,
            $this->db_user,
            $this->db_password,
            $this->db_name,
            $this->db_port)
        ;
        $this->gcalendar = new google_calendar();
    }

    function get_locations()
    {
        $query = "SELECT * FROM locations";
        $query = $this->db_connection->query($query);

        $result = Array();
        while ($row = $query->fetch_object())
            array_push($result, $row);

        return $result;
    }

    function get_location($location_id)
    {
        $query = "SELECT * FROM locations WHERE id='{$location_id}'";
        $query = $this->db_connection->query($query);

        $row = $query->fetch_object();
        $result = Array(
            'location_id' => $row->id,
            'location_name' => $row->name,
            'location_address' => $row->address,
            'location_working_hours' => Array()
        );

        $query = "SELECT * FROM locations_working_hours WHERE location_id='{$location_id}'";
        $query = $this->db_connection->query($query);

        while ($row = $query->fetch_object()) {
            $row->open_at = date('H:i', strtotime($row->open_at));
            $row->close_at = date('H:i', strtotime($row->close_at));

            array_push($result['location_working_hours'], Array(
                'day_id' => $row->day_id,
                'open_at' => $row->open_at,
                'close_at' => $row->close_at
            ));
        }

        return $result;
    }

    function get_services_categories()
    {
        $query = "SELECT * FROM service_categories";
        $query = $this->db_connection->query($query);

        $result = Array();
        while ($row = $query->fetch_object())
            array_push($result, $row);

        return $result;
    }

    function get_services($category_id = NULL)
    {
        if ($category_id) {
            $query = "SELECT * FROM services WHERE category_id={$category_id}";
        } else {
            $query = "SELECT * FROM services";
        }
        $query = $this->db_connection->query($query);

        $result = Array();
        while ($row = $query->fetch_object())
            array_push($result, $row);

        return $result;
    }

    function get_grouped_services()
    {
        $query = <<<eot
            SELECT services.*, service_categories.name AS category_name
            FROM services
            INNER JOIN service_categories ON services.category_id=service_categories.id
eot;

        $query = $this->db_connection->query($query);

        $result = Array();
        while ($row = $query->fetch_object()) {
            if (!isset($result[$row->category_id])) {
                $result[$row->category_id]['category_name'] = $row->category_name;
                $result[$row->category_id]['services_group'] = Array();
            }
            array_push($result[$row->category_id]['services_group'], $row);
        }

        return $result;
    }

    // Пока что три фильтра
    // По филиалу – location_id
    // По категории оказываемых услуг – category_id
    // По времени записи – reservation_date
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
        while ($row = $query->fetch_object())
            array_push($result, $row);

        return $result;
    }

    function get_master($master_id)
    {
        // Вытаскиваем основную информацию о мастере
        $query = "SELECT * FROM masters WHERE id={$master_id}";
        $query = $this->db_connection->query($query);

        $row = $query->fetch_object();
        $result = Array(
            'id' => $row->id,
            'location_id' => $row->location_id,
            'name' => $row->name,
            'description' => $row->description,
            'photo' => $row->photo,
            'working_hours' => Array(),
            'specialisations' => Array(),
            'calendar_link' => $row->calendar_link,
            'calendar_id' => $row->calendar_id
        );

        // Выстаскиваем его часы работы
        $query = "SELECT day_id AS day, working_hours_start AS start, working_hours_end AS end FROM masters_working_hours WHERE master_id={$master_id}";
        $query = $this->db_connection->query($query);

        while ($row = $query->fetch_object()) {
            $row->start = date('H:i', strtotime($row->start));
            $row->end = date('H:i', strtotime($row->end));

            array_push($result['working_hours'], $row);
        }

        // Вытаскиваем его специализации
        $query = "SELECT category_id FROM masters_services WHERE master_id={$master_id}";
        $query = $this->db_connection->query($query);

        while ($row = $query->fetch_object())
            array_push($result['specialisations'], $row);

        return $result;
    }
}