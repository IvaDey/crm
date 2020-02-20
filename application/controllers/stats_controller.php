<?php
class stats_controller extends controller
{
    function __construct()
    {
        parent::__construct();

        $this->model = new stats_model();
    }

//    function action_index($params = NULL)
//    {
//        $reservations_stats_params = Array();
//        $visits_stats_params = Array();
//        $revenue_stats_params = Array();
//
//        if ($_GET['reservations_stats_params']) {
//            if ($_GET['reservations_stats_params']['start']) {
//                $reservations_stats_params['start'] = Date('Y-m-d', strtotime($_GET['reservations_stats_params']['start']));
//            } else {
//                $reservations_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            }
//            if ($_GET['reservations_stats_params']['end']) {
//                $reservations_stats_params['end'] = Date('Y-m-d', strtotime($_GET['reservations_stats_params']['end']));
//            } else {
//                $reservations_stats_params['end'] = Date('Y-m-d', time());
//            }
//        } else {
//            $reservations_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            $reservations_stats_params['end'] = Date('Y-m-d', time());
//        }
//        if ($_GET['visits_stats_params']) {
//            if ($_GET['visits_stats_params']['start']) {
//                $visits_stats_params['start'] = Date('Y-m-d', strtotime($_GET['visits_stats_params']['start']));
//            } else {
//                $visits_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            }
//            if ($_GET['visits_stats_params']['end']) {
//                $visits_stats_params['end'] = Date('Y-m-d', strtotime($_GET['visits_stats_params']['end']));
//            } else {
//                $visits_stats_params['end'] = Date('Y-m-d', time());
//            }
//        } else {
//            $visits_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            $visits_stats_params['end'] = Date('Y-m-d', time());
//        }
//        if ($_GET['revenue_stats_params']) {
//            if ($_GET['revenue_stats_params']['start']) {
//                $revenue_stats_params['start'] = Date('Y-m-d', strtotime($_GET['revenue_stats_params']['start']));
//            } else {
//                $revenue_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            }
//            if ($_GET['revenue_stats_params']['end']) {
//                $revenue_stats_params['end'] = Date('Y-m-d', strtotime($_GET['revenue_stats_params']['end']));
//            } else {
//                $revenue_stats_params['end'] = Date('Y-m-d', time());
//            }
//        } else {
//            $revenue_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
//            $revenue_stats_params['end'] = Date('Y-m-d', time());
//        }
//
//        $data = Array(
//            'menu_item_id' => 'nav-stats',
//            'css_name' => 'stats.css',
//            'script_name' => 'stats.js',
//            'title' => 'Статистика',
//            'reservations_stats' => $this->model->get_reservations_stats($reservations_stats_params['start'], $reservations_stats_params['end']),
//            'visits_stats' => $this->model->get_visits_stats($visits_stats_params['start'], $visits_stats_params['end']),
//            'revenue_stats' => $this->model->get_revenue_stats($revenue_stats_params['start'], $revenue_stats_params['end'])
//        );
//        $this->view->generate('template_view.php', 'stats_view.php', $data);
//    }

    function action_local($params = NULL)
    {
        $reservations_stats_params = Array();
        $visits_stats_params = Array();
        $revenue_stats_params = Array();

        if ($_GET['reservations_stats_params']) {
            if ($_GET['reservations_stats_params']['start']) {
                $reservations_stats_params['start'] = Date('Y-m-d', strtotime($_GET['reservations_stats_params']['start']));
            } else {
                $reservations_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            }
            if ($_GET['reservations_stats_params']['end']) {
                $reservations_stats_params['end'] = Date('Y-m-d', strtotime($_GET['reservations_stats_params']['end']));
            } else {
                $reservations_stats_params['end'] = Date('Y-m-d', time());
            }
        } else {
            $reservations_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            $reservations_stats_params['end'] = Date('Y-m-d', time());
        }
        if ($_GET['visits_stats_params']) {
            if ($_GET['visits_stats_params']['start']) {
                $visits_stats_params['start'] = Date('Y-m-d', strtotime($_GET['visits_stats_params']['start']));
            } else {
                $visits_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            }
            if ($_GET['visits_stats_params']['end']) {
                $visits_stats_params['end'] = Date('Y-m-d', strtotime($_GET['visits_stats_params']['end']));
            } else {
                $visits_stats_params['end'] = Date('Y-m-d', time());
            }
        } else {
            $visits_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            $visits_stats_params['end'] = Date('Y-m-d', time());
        }
        if ($_GET['revenue_stats_params']) {
            if ($_GET['revenue_stats_params']['start']) {
                $revenue_stats_params['start'] = Date('Y-m-d', strtotime($_GET['revenue_stats_params']['start']));
            } else {
                $revenue_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            }
            if ($_GET['revenue_stats_params']['end']) {
                $revenue_stats_params['end'] = Date('Y-m-d', strtotime($_GET['revenue_stats_params']['end']));
            } else {
                $revenue_stats_params['end'] = Date('Y-m-d', time());
            }
        } else {
            $revenue_stats_params['start'] = Date('Y-m-d', time() - 60 * 60 * 24 * 30);
            $revenue_stats_params['end'] = Date('Y-m-d', time());
        }

        $data = Array(
            'menu_item_id' => 'nav-stats',
            'sub_menu_item_id' => 'sub-nav-stats-local',
            'css_name' => 'stats/local.css',
            'script_name' => 'stats/local.js',
            'title' => 'Статистика по салону',
            'reservations_stats' => $this->model->get_reservations_stats($reservations_stats_params['start'], $reservations_stats_params['end']),
            'visits_stats' => $this->model->get_visits_stats($visits_stats_params['start'], $visits_stats_params['end']),
            'revenue_stats' => $this->model->get_revenue_stats($revenue_stats_params['start'], $revenue_stats_params['end'])
        );
        $this->view->generate('template_view.php', 'stats/local_view.php', $data);
    }

    function action_unit($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-stats',
            'sub_menu_item_id' => 'sub-nav-stats-unit',
            'css_name' => 'stats/unit.css',
            'script_name' => 'stats/unit.js',
            'title' => 'Unit экономика'
        );
        $this->view->generate('template_view.php', 'stats/unit_view.php', $data);
    }

    function action_employees($params = NULL)
    {
        $data = Array(
            'menu_item_id' => 'nav-stats',
            'sub_menu_item_id' => 'sub-nav-stats-employees',
            'css_name' => 'stats/employees.css',
            'script_name' => 'stats/employees.js',
            'title' => 'Отчеты по сотрудникам'
        );
        $this->view->generate('template_view.php', 'stats/employees_view.php', $data);
    }
}


































