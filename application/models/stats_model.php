<?php
class stats_model extends model {
    public function get_reservations_stats($start, $end) {
        $result = Array();
        $date = $start;
        while ($date <= $end) {
            $query = "SELECT COUNT(id) AS reservations_count FROM reservations WHERE Date(created_at) = '{$date}'";
            $query = $this->db_connection->query($query);

            if ($row = $query->fetch_object()) {
                array_push($result, Array(
                    'reservations_count' => $row->reservations_count,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            } else {
                array_push($result, Array(
                    'reservations_count' => 0,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            }

            $date = Date('Y-m-d', strtotime($date) + 60 * 60 * 24);
        }

        return $result;
    }

    public function get_visits_stats($start, $end) {
        $result = Array();
        $date = $start;
        while ($date <= $end) {
            $query = "SELECT COUNT(id) AS visits_count FROM reservations WHERE Date(reservation_date) = '{$date}'";
            $query = $this->db_connection->query($query);

            if ($row = $query->fetch_object()) {
                array_push($result, Array(
                    'visits_count' => $row->visits_count,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            } else {
                array_push($result, Array(
                    'visits_count' => 0,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            }

            $date = Date('Y-m-d', strtotime($date) + 60 * 60 * 24);
        }

        return $result;
    }

    public function get_revenue_stats($start, $end) {
        $result = Array();
        $date = $start;
        while ($date <= $end) {
            $query = "SELECT SUM(total_cost) AS total_revenue FROM reservations WHERE Date(reservation_date) = '{$date}'";
            $query = $this->db_connection->query($query);

            if ($row = $query->fetch_object()) {
                array_push($result, Array(
                    'revenue' => $row->total_revenue,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            } else {
                array_push($result, Array(
                    'revenue' => 0,
                    'date' => Date('d.m.Y', strtotime($date))
                ));
            }

            $date = Date('Y-m-d', strtotime($date) + 60 * 60 * 24);
        }

        return $result;
    }
}

























