<?php
include_once 'application/core/google_calendar.php';

class settings_model extends model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_info($company_id)
    {
        // Данные календаря
        $result = Array(
            'gcalendar' => Array(
                'is_authorized' => $this->gcalendar->is_authorized() ? $this->gcalendar->get_owner() : 0,
                'authLink' => $this->gcalendar->is_authorized() ? 0 : $this->gcalendar->getAuthLink()
            )
        );

        // Данные компании
        $query = "SELECT * FROM company_info WHERE id='{$company_id}'";
        $query = $this->db_connection->query($query);
        $query = $query->fetch_object();
        $result['company_info'] = Array(
            'name' => $query->name,
            'description' => $query->description,
            'address' => $query->address,
            'phone' => $query->phone,
            'email' => $query->email
        );

        return $result;
    }

    public function set_gcalendar_integration($authCode)
    {
        return $this->gcalendar->setAccessCode($authCode);
    }

    public function update_company_info($id, $new_info)
    {
        $query = <<<eot
            UPDATE company_info SET
            name='{$new_info['name']}',
            description='{$new_info['description']}',
            address='{$new_info['address']}',
            phone='{$new_info['phone']}',
            email='{$new_info['email']}'
            WHERE id='{$id}'
eot;
        $this->db_connection->query($query);
    }
}