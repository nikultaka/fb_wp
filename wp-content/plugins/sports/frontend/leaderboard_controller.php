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


    function load_leader_board()
    {
        global $wpdb;
        $requestData = $_POST;
        $leagueId = $_POST['id'];
        $userId = $_POST['userid'];

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

        $result_sql = "SELECT
        " . $jointeamtable . ".*,
        " . $leaguetable . ".name AS leaguename,
        " . $usertable . ".display_name AS username,
        " . $roundtable . ".scoremultiplier AS scoremultiplier,
        " . $roundtable . ".scoretype AS scoretype,
        CASE WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score 
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score ELSE ''
        END AS teamscore,
        CASE
        WHEN " . $roundtable . ".iscomplete = 'YES' THEN  
        CASE WHEN  " . $jointeamtable . ".roundselect = 'nothanks' THEN
            CASE WHEN " . $roundtable . ".scoremultiplier = 0 THEN 
                CASE 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * 1)
                END  
            ELSE 
                CASE 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier)
                END  
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
        END 
        ELSE ''
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
         ";


         $teamselect_sql = "select count(*) as multipliercount,roundid,userid from (SELECT distinct " . $matchscoretable . ".*," . $selectteam . ".roundid as roundid," . $selectteam . ".userid as userid,
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
         HAVING winteams = selectteams) as data
         group by roundid,userid";
         
         $result = $wpdb->get_results($teamselect_sql, OBJECT);
        $ary = [];
        $ary2 = [];
        foreach ($result as $user) {
            $ary[$user->userid][$user->roundid] = $user->multipliercount;
            $ary2[$user->userid][$user->roundid] = $user->roundid; 
        } 

        $calculation_sql = $result_sql;
        $calculation_sql .= " group by " . $jointeamtable . ".id HAVING userscore > 0 ";
        $result = $wpdb->get_results($calculation_sql, OBJECT);
        $scoreByUserId = [];
        foreach ($result as $row) {
            if ($row->scoretype == 'added' && $row->scoremultiplier == 0) {
                if($row->roundid == $ary2[$row->userid][$row->roundid] && $ary2[$row->userid][$row->roundid] != ''){
                    $temp['yourscore'] = $row->userscore;
                    $scoreByUserId[$row->userid] += $row->userscore * $ary[$row->userid][$row->roundid];
                }else{
                    $temp['yourscore'] = $row->userscore;
                    $scoreByUserId[$row->userid] += $row->userscore *1;
                }
            } else {
                $temp['yourscore'] = $row->userscore;
                $scoreByUserId[$row->userid] += $row->userscore;
            }
        }
    
        $result_sql .= " group by userid";
        $mainresult = $wpdb->get_results($result_sql);

        $totalData = 0;
        $totalFiltered = 0;
        if (count($mainresult) > 0) {
            $totalData = count($mainresult);
            $totalFiltered = count($mainresult);
        }

        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }

        $mainresult = $wpdb->get_results($result_sql);
        foreach ($mainresult as  $leaderboardpoints) {
            $leaderboardpoints->finalPoint = $scoreByUserId[$leaderboardpoints->userid];
        }
        array_multisort($scoreByUserId, SORT_DESC, $mainresult);

        foreach ($mainresult as $row) {
            $temp['leaguename'] = $row->leaguename;
            $temp['username'] = $row->username;
            $temp['userspoints'] = $row->finalPoint;
            $action = "<button  class='btn btn-sm' data-toggle='modal'  id='load_match_score_details_list' onclick='load_match_score_details_list(" . $row->leagueid . "," . $row->userid . ")'>Details</button>";
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
        $teamtable = $wpdb->prefix . "team";
        $roundtable = $wpdb->prefix . "round";
        $usertable = $wpdb->prefix . "users";
        $matchscoretable = $wpdb->prefix . "score";
        $selectteam = $wpdb->prefix . "selectteam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";



        $result_sql = "SELECT distinct " . $jointeamtable . ".*,
        " . $roundtable . ".rname as roundname," . $roundtable . ".scoremultiplier as scoremultiplier," . $roundtable . ".scoretype as scoretype,
        " . $matchtable . ".id as matchid ,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN t.teamname
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $teamtable . ".teamname
        ELSE ''
        END AS teamname ,
        CASE
        WHEN " . $roundtable . ".iscomplete = 'YES' THEN 
        CASE WHEN  " . $jointeamtable . ".roundselect = 'nothanks' THEN
            CASE WHEN " . $roundtable . ".scoremultiplier = 0 THEN 
                CASE 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * 1) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * 1)
                END  
            ELSE 
                CASE 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier) 
                    WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier)
                END  
            END				
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'scorePredictorround' THEN 
            CASE WHEN " . $scorepredictortable . ".teamid = 1   THEN
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
            CASE WHEN " . $scorepredictortable . ".teamid = 0  THEN
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
        END 
        ELSE ''
        END AS userscore
        FROM " . $jointeamtable . "
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $jointeamtable . ".roundid 
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid and " . $scorepredictortable . ".userid = " . $userid . "
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        WHERE " . $jointeamtable . ".leagueid = " . $leagueId . " and " . $jointeamtable . ".userid = " . $userid . " group by teamname HAVING userscore > 0 ";


        $teamselect_sql = "select count(*) as multipliercount,roundid from (SELECT distinct " . $matchscoretable . ".*," . $selectteam . ".roundid as roundid,
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
        WHERE " . $selectteam . ".userid = $userid HAVING winteams = selectteams) as data
        group by roundid";

        $result = $wpdb->get_results($teamselect_sql, OBJECT);
        $ary = [];
        foreach ($result as $round) {
            $ary[$round->roundid] = $round->multipliercount;
        }

        $totalScoreResult = $wpdb->get_results($result_sql, OBJECT);
        $toalScore = 0;
        foreach ($totalScoreResult as $row) {
            if ($row->scoretype == 'added' && $row->scoremultiplier == 0 && $row->userid == $userid) {
                $temp['yourscore'] = $row->userscore;
                $toalScore += $row->userscore * $ary[$row->roundid];
            } else {
                $temp['yourscore'] = $row->userscore;
                $toalScore += $row->userscore;
            }          
        }

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (teamname LIKE '%" . $search . "%')
                            OR (userscore LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'teamname',
            1 => 'userscore',
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
            if ($row->scoretype == 'added' && $row->scoremultiplier == 0 && $row->userid == $userid) {
                $temp['teamscore'] = $row->userscore  * $ary[$row->roundid];
            } else {
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
