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

    // public function get_leader_board()
    // {
    //     global $wpdb;
    //     $requestData = $_POST;
    //     $data = array();

    //     $leaguetable = $wpdb->prefix . "league";

    //     $result_sql = "SELECT * FROM " . $leaguetable . " WHERE STATUS = 'active' ";

    //     if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
    //         $search = $requestData['search']['value'];
    //         $result_sql .= "AND (name LIKE '%" . $search . "%')";
    //     }
    //     $columns = array(
    //         0 => 'name',
    //     );

    //     if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
    //         $order_by = $columns[$requestData['order'][0]['column']];
    //         $result_sql .= " ORDER BY " . $order_by;
    //     } else {
    //         $result_sql .= "ORDER BY id DESC";
    //     }
    //     if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
    //         $result_sql .= " " . $requestData['order'][0]['dir'];
    //     } else {
    //         $result_sql .= " DESC ";
    //     }

    //     $result = $wpdb->get_results($result_sql, OBJECT);
    //     $totalData = 0;
    //     $totalFiltered = 0;
    //     if (count($result) > 0) {
    //         $totalData = count($result);
    //         $totalFiltered = count($result);
    //     }
    //     // This is for pagination
    //     if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
    //         $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
    //     }
    //     $list_data = $wpdb->get_results($result_sql, "OBJECT");
    //     $arr_data = array();
    //     $arr_data = $result;

    //     foreach ($list_data as $row) {
    //         $leaderboardlink = home_url("/load-leader-board/?id=$row->id");
    //         $temp['league'] = $row->name;
    //         $action =  "<h3 class='card-title'> <a class='btn btn-default' href='$leaderboardlink' type='button'>Load $row->name's Leader Board</a></h3>";
    //         $temp['action'] = $action;
    //         $data[] = $temp;
    //         $id = "";
    //     }

    //     $json_data = array(
    //         "draw" => intval($requestData['draw']),
    //         "recordsTotal" => intval($totalData),
    //         "recordsFiltered" => intval($totalFiltered),
    //         "data" => $data,
    //         "sql" => $result_sql
    //     );

    //     echo json_encode($json_data);
    //     exit(0);
    // }

    function load_leader_board()
    {
        global $wpdb;
        $requestData = $_POST;
        $leagueId = $_POST['id'];

        $data = array();

        $leaderboard = $wpdb->prefix . "leaderboard";
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchscoretable = $wpdb->prefix . "score";
        $roundtable = $wpdb->prefix . "round";



        $result_sql = "select *,sum(userscore) as finalscore from (SELECT
        " . $jointeamtable . ".*,
        " . $leaguetable . ".name AS leaguename,
        " . $usertable . ".display_name AS username,
        " . $roundtable . ".scoremultiplier AS scoremultiplier,
        " . $roundtable . ".scoretype AS scoretype,
        CASE WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score 
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score ELSE ''
        END AS teamscore,
        CASE WHEN " . $jointeamtable . ".roundselect = 'nothanks' THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier)
        END                                            
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'scorePredictorround' THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 3) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 3)
        END
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'jokeround'  THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 3)  
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 3) 
        END
        END
        END
        END AS userscore
        FROM
            " . $jointeamtable . "
        LEFT JOIN " . $leaguetable . " ON " . $leaguetable . ".id = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $usertable . " ON " . $usertable . ".id = " . $jointeamtable . ".userid
        LEFT JOIN " . $matchscoretable . " ON " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $roundtable . " ON " . $roundtable . ".id = " . $jointeamtable . ".roundid
        WHERE
            " . $jointeamtable . ".leagueid = $leagueId
        ORDER BY
            userscore
        DESC) as data
        group by userid
        order by finalscore DESC";
      

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
            $temp['userspoints'] = $row->finalscore;
            $action ="<button  class='btn btn-sm' data-toggle='modal'  id='load_match_score_details_list' onclick='load_match_score_details_list(" . $row->leagueid . "," . $row->userid . ")'>Details</button>";
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


    function load_match_score_details()
    {

        global $wpdb;
        $requestData = $_POST;
        $leagueId = $_POST['id'];
        $userid = $_POST['uid'];

        $data = array();
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";
        $matchscoretable = $wpdb->prefix . "score";


        $result_sql = "SELECT " . $jointeamtable . ".*," . $roundtable . ".scoremultiplier as scoremultiplier," . $roundtable . ".scoretype as scoretype,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score
        ELSE ''
        END AS teamscore
        FROM " . $jointeamtable . "
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $jointeamtable . ".roundid 
        WHERE " . $jointeamtable . ".leagueid = " . $leagueId . " and " . $jointeamtable . ".userid = " . $userid . "  ";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (teamname LIKE '%" . $search . "%')
                            OR (teamscore LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'teamname',
            1 => 'teamscore',
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
            $temp['teamname'] = $row->teamname;
            $temp['teamscore'] = $row->scoretype == 'added' ?
                "+ " . $row->scoremultiplier * $row->teamscore :
                "- " . $row->scoremultiplier * $row->teamscore;

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

add_action('wp_ajax_nopriv_leader_board_Controller::load_match_score_details', array($leader_board_Controller, 'load_match_score_details'));
add_action('wp_ajax_leader_board_Controller::load_match_score_details', array($leader_board_Controller, 'load_match_score_details'));
