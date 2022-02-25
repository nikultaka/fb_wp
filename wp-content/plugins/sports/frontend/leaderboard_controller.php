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
        $user2id = get_current_user_id();
        $leaderboard = $wpdb->prefix . "leaderboard";
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchscoretable = $wpdb->prefix . "score";
        $roundtable = $wpdb->prefix . "round";
        $selectteam = $wpdb->prefix . "selectteam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";

        $teamselect_sql =$wpdb->get_row("select count(*) as final_multiplier_coun from (SELECT distinct " . $matchscoretable . ".*,
        CASE
        WHEN " . $matchscoretable . ".team1score > " . $matchscoretable . ".team2score THEN concat('1_'," . $matchscoretable . ".matchid)
        WHEN " . $matchscoretable . ".team2score > " . $matchscoretable . ".team1score THEN concat('0_'," . $matchscoretable . ".matchid)
        ELSE ''
        END AS winteams ,
        CASE
        WHEN " . $selectteam . ".teamid = 1  THEN concat('1_'," . $selectteam . ".matchid)
        WHEN " . $selectteam . ".teamid = 0  THEN concat('0_'," . $selectteam . ".matchid)
        ELSE ''
        END AS selectteams
        FROM " . $matchscoretable . " 
        LEFT JOIN " . $selectteam . " on " . $selectteam . ".matchid = " . $selectteam . ".matchid
        LEFT JOIN " . $usertable . " on " . $usertable . ".id = " . $selectteam . ".userid
        WHERE " . $selectteam . ".userid = $user2id HAVING winteams = selectteams) as data");

        $finalscoremultiplier = $teamselect_sql->final_multiplier_coun;

        $result_sql = "select distinct *,sum(
            CASE
            WHEN scoretype = 'added' AND scoremultiplier = 0 AND userid = $user2id THEN userscore*$finalscoremultiplier
            ELSE userscore
            END
            ) as finalscore from (SELECT
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
            CASE WHEN " . $scorepredictortable . ".teamid = 1 THEN
                     CASE WHEN " . $scorepredictortable . ".scorepredictor = " . $matchscoretable . ".team1score THEN  
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".predictorscoremultiplier) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".predictorscoremultiplier)
                            END
                        WHEN " . $scorepredictortable . ".scorepredictor = '' OR " . $scorepredictortable . ".scorepredictor != " . $matchscoretable . ".team1score THEN
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1)
                            END    
                    END
            ELSE                 
            CASE WHEN " . $scorepredictortable . ".teamid = 0 THEN
                      CASE WHEN " . $scorepredictortable . ".scorepredictor = " . $matchscoretable . ".team2score THEN  
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".predictorscoremultiplier) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".predictorscoremultiplier)
                            END
                        WHEN " . $scorepredictortable . ".scorepredictor = '' OR " . $scorepredictortable . ".scorepredictor != " . $matchscoretable . ".team2score THEN
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1)
                            END    
                    END 
            END                     
        END
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'jokeround'  THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".jokerscoremultiplier)  
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".jokerscoremultiplier) 
        END
        END
        END
        END AS userscore
        FROM
            " . $jointeamtable . "
        LEFT JOIN " . $leaguetable . " ON " . $leaguetable . ".id = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $usertable . " ON " . $usertable . ".id = " . $jointeamtable . ".userid
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $matchscoretable . " ON " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 

        LEFT JOIN " . $roundtable . " ON " . $roundtable . ".id = " . $jointeamtable . ".roundid
        WHERE
            " . $jointeamtable . ".leagueid = $leagueId
        group by " . $jointeamtable . ".id    
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
        $user2id = get_current_user_id();
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";
        $usertable = $wpdb->prefix . "users";
        $matchscoretable = $wpdb->prefix . "score";
        $selectteam = $wpdb->prefix . "selectteam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";



        $result_sql = "SELECT distinct " . $jointeamtable . ".*," . $roundtable . ".scoremultiplier as scoremultiplier," . $roundtable . ".scoretype as scoretype,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname,
        CASE WHEN " . $jointeamtable . ".roundselect = 'nothanks' THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier)
        END                                            
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'scorePredictorround' THEN 
            CASE WHEN " . $scorepredictortable . ".teamid = 1 THEN
                     CASE WHEN " . $scorepredictortable . ".scorepredictor = " . $matchscoretable . ".team1score THEN  
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".predictorscoremultiplier) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".predictorscoremultiplier)
                            END
                        WHEN " . $scorepredictortable . ".scorepredictor = '' OR " . $scorepredictortable . ".scorepredictor != " . $matchscoretable . ".team1score THEN
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1)
                            END    
                    END
            ELSE                 
            CASE WHEN " . $scorepredictortable . ".teamid = 0 THEN
                      CASE WHEN " . $scorepredictortable . ".scorepredictor = " . $matchscoretable . ".team2score THEN  
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".predictorscoremultiplier) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".predictorscoremultiplier)
                            END
                        WHEN " . $scorepredictortable . ".scorepredictor = '' OR " . $scorepredictortable . ".scorepredictor != " . $matchscoretable . ".team2score THEN
                            CASE WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                                 WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1)
                            END    
                    END 
            END                     
        END
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'jokeround'  THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".jokerscoremultiplier)  
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".jokerscoremultiplier) 
        END
        END
        END
        END AS userscore
        FROM " . $jointeamtable . "
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $jointeamtable . ".roundid 
        WHERE " . $jointeamtable . ".leagueid = " . $leagueId . " and " . $jointeamtable . ".userid = " . $userid . " group by teamname ";

        $teamselect_sql =$wpdb->get_row("select count(*) as final_multiplier_coun from (SELECT distinct " . $matchscoretable . ".*,
        CASE
        WHEN " . $matchscoretable . ".team1score > " . $matchscoretable . ".team2score THEN concat('1_'," . $matchscoretable . ".matchid)
        WHEN " . $matchscoretable . ".team2score > " . $matchscoretable . ".team1score THEN concat('0_'," . $matchscoretable . ".matchid)
        ELSE ''
        END AS winteams ,
        CASE
        WHEN " . $selectteam . ".teamid = 1  THEN concat('1_'," . $selectteam . ".matchid)
        WHEN " . $selectteam . ".teamid = 0  THEN concat('0_'," . $selectteam . ".matchid)
        ELSE ''
        END AS selectteams
        FROM " . $matchscoretable . " 
        LEFT JOIN " . $selectteam . " on " . $selectteam . ".matchid = " . $selectteam . ".matchid
        LEFT JOIN " . $usertable . " on " . $usertable . ".id = " . $selectteam . ".userid
        WHERE " . $selectteam . ".userid = $user2id HAVING winteams = selectteams) as data");

        $finalscoremultiplier = $teamselect_sql->final_multiplier_coun;
        
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
            if($row->scoretype == 'added' && $row->scoremultiplier == 0 && $row->userid == $user2id ){
                $temp['teamscore'] = $row->userscore  * $finalscoremultiplier; 
            }else{
                $temp['teamscore'] = $row->userscore; 
            }
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
