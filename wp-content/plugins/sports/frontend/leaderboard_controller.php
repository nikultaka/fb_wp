<?php
class leader_board_Controller
{

    function leader_board()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/leaderboardlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    function loadleader_board()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/loadleaderboardlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function get_leader_board()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();

        $leaguetable = $wpdb->prefix . "league";

        $result_sql = "SELECT * FROM " . $leaguetable . " WHERE STATUS = 'active' ";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (name LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'name',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $leaderboardlink = home_url("/load-leader-board/?id=$row->id");
            $temp['league'] = $row->name;
            $action =  "<h3 class='card-title'> <a class='btn btn-default' href='$leaderboardlink' type='button'>Load $row->name's Leader Board</a></h3>";
            $temp['action'] = $action;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);
    }

    function load_leader_board(){

        global $wpdb;
        $requestData = $_POST;
        $leagueId = $_POST['id'];
    
        $data = array();
        $leaderboard = $wpdb->prefix . "leaderboard";
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";

        $result_sql = "SELECT " . $leaderboard . ".*," . $leaguetable . ".name as leaguename," . $usertable . ".display_name as username
        FROM " . $leaderboard . " 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $leaderboard . ".leagueid
        LEFT JOIN " . $usertable . " on " . $usertable . ".id = " . $leaderboard . ".userid 
        WHERE " . $leaderboard . ".id = " . $leagueId . " ";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (id LIKE '%" . $search . "%')
                            OR (score LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'leaguename',
            1 => 'username',
            2 => 'score',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $temp['leaguename'] = $row->leaguename;
            $temp['username'] = $row->username;
            $temp['userscore'] = $row->score;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);

    }


}

$leader_board_Controller = new leader_board_Controller();

add_action('wp_ajax_nopriv_leader_board_Controller::get_leader_board', array($leader_board_Controller, 'get_leader_board'));
add_action('wp_ajax_leader_board_Controller::get_leader_board', array($leader_board_Controller, 'get_leader_board'));
add_shortcode('leader_board_list', array($leader_board_Controller, 'leader_board'));

add_action('wp_ajax_nopriv_leader_board_Controller::load_leader_board', array($leader_board_Controller, 'load_leader_board'));
add_action('wp_ajax_leader_board_Controller::load_leader_board', array($leader_board_Controller, 'load_leader_board'));
add_shortcode('load_leader_board_list', array($leader_board_Controller, 'loadleader_board'));
