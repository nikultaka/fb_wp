<?php
class my_score_Controller
{

    
    
    function my_score()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/myscore.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;       
    }

    public function get_my_score()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();

        $userid = get_current_user_id();
        $sportstable = $wpdb->prefix . "sports";
        $leaguetable = $wpdb->prefix . "league";
        $roundtable = $wpdb->prefix . "round";
        $matchtable = $wpdb->prefix . "match";
        $matchscoretable = $wpdb->prefix . "score";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";

        

        $result_sql = "SELECT " . $jointeamtable . ".*," . $sportstable . ".name as sportname," . $leaguetable . ".name as leaguename,
        " . $roundtable . ".rname as roundname," . $roundtable . ".scoremultiplier as scoremultiplier," . $roundtable . ".scoretype as scoretype,
        " . $matchtable . ".id as matchid ,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname ,
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
                     CASE WHEN " . $scorepredictortable . ".scorepredictor >= " . $matchscoretable . ".team1score THEN  
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
                      CASE WHEN " . $scorepredictortable . ".scorepredictor >= " . $matchscoretable . ".team2score THEN  
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
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $jointeamtable . ".sportid 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $jointeamtable . ".leagueid 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $jointeamtable . ".roundid 
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        WHERE " . $jointeamtable . ".userid = " . $userid . "";
      

        $totalScoreResult = $wpdb->get_results($result_sql, OBJECT);
        $toalScore = 0;
        foreach ($totalScoreResult as $row) {
            $temp['yourscore'] = $row->userscore; 
            $toalScore+=$row->userscore;    
        }
    
        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (a.sportname LIKE '%" . $search . "%')
                        OR (a.leaguename LIKE '%" . $search . "%')
                        OR (a.roundname LIKE '%" . $search . "%')
                        OR (a.teamname LIKE '%" . $search . "%')
                        OR (a.matchid LIKE '%" . $search . "%')";
        }
        $columns = array(  
            0 => 'sportname',
            1 => 'leaguename',
            2 => 'roundname',
            3 => 'teamname',
            4 => 'matchid',

            5 => 'scoremultiplier',
            6 => 'teamscore',
            7 => 'scoretype',
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
            $leaderboardlink = home_url("/load-leader-board/?id=$row->leagueid");
            $temp['sport'] = $row->sportname;
            $temp['league'] = $row->leaguename;
            $temp['round'] = $row->roundname;
            $temp['team'] = $row->teamname;
            $temp['yourscore'] = $row->userscore;
            $action = "<a class='btn btn-default ' style='background-color: #24890d; color: #fff;' href='$leaderboardlink' type='button'>Leader Board</a>";
            $temp['action'] = $action; 
            $data[] = $temp;
            $id = "";
        }
        // $a=array($temp['yourscore']);
        // array_push($a);         
        // const array = []
        // let sum = 0;

        // for (let i = 0; i < array.length; i++) {
        //     sum += array[i];
        // }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql,
            "score" => $toalScore,
        );

        echo json_encode($json_data);
        exit(0);
    }
}

$my_score_Controller = new my_score_Controller();

add_action('wp_ajax_nopriv_my_score_Controller::get_my_score', array($my_score_Controller, 'get_my_score'));
add_action('wp_ajax_my_score_Controller::get_my_score', array($my_score_Controller, 'get_my_score'));

add_shortcode('my_score_list', array($my_score_Controller, 'my_score'));
