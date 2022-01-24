<?php
class match_list_Controller
{

    function match_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/matchlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function get_match_list()
    {
       
        global $wpdb;
        $requestData = $_POST;
        $matchId = $_POST['id'];
        $data = array();
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";

        $result_sql = "SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname FROM " . $matchtable;
        $result_sql .= " LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round WHERE " . $matchtable . ".leagueid = " . $matchId . "";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (roundname LIKE '%" . $search . "%')
                                OR (team1 LIKE '%" . $search . "%')
                                OR (team2 LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'id',
            1 => 'roundname',
            2 => 'team1',
            3 => 'team2',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY a.id DESC";
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

            $temp['id'] = $row->id;
            $temp['round'] = $row->roundname;
            $temp['team1'] = $row->team1;
            $temp['team2'] = $row->team2;
            $data[] = $temp;
            $id = "";
        }


        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql,
        
        );

        echo json_encode($json_data);
        exit(0);
    }

    
}

$match_list_Controller = new match_list_Controller();

add_action('wp_ajax_nopriv_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));
add_action('wp_ajax_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));

add_shortcode('match_list_short_code', array($match_list_Controller, 'match_list_short_code'));