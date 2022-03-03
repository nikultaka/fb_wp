<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/fb_wp/wp-load.php';


// include($path.'wp-load.php');

// include($path.'wp-load.php');
function send_mail_users_enddate()
{
    global $wpdb;

    $result['status'] = 0;
    $matchtable = $wpdb->prefix . "match";
    $usertable = $wpdb->prefix . "users";
    $jointeamtable = $wpdb->prefix . "jointeam";
    $teamtable = $wpdb->prefix . "team";

    $attime = date("Y-m-d", strtotime('-1 day')); //current_time('Y-m-d H:i:s');

    $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*, " . $teamtable . ".teamname as team1name , t.teamname as team2name FROM " . $matchtable . "
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2 
        WHERE   MSTATUS = 'active' AND  date(" . $matchtable . ".enddate) <= '$attime' ORDER BY " . $matchtable . ".enddate");

    //echo '<pre>'; print_r($user_sql); exit;

    foreach ($result_sql as $match) {
        $user_sql = $wpdb->get_results("SELECT * FROM " . $usertable . " where ID IN (SELECT userid FROM " . $jointeamtable . " where roundid =$match->id )");
        foreach ($user_sql as $user) {
            //   send mail
            $subject = "Earn Points Now";
            $email = 'nikultaka@palladiumhub.com';
            $message = '<p>';
            $message .= 'Dear <b>' . $user->display_name . ',</b>';
            $message .= '<h3>Match Between Big Teams Starts Soon at <h3></b><h2>' . $match->enddate . '</h2></b> ';
            $message .= '<br>';
            $message .= '<b><h1>' . $match->team1name . '</h1><h3> VS </h3><h1>' . $match->team2name . '</b></h1>';
            $message .= '<br>';
            $message .= '<h4>Select Your Favourite Team & Earn Points Now,</h4>';
            $message .= 'Thanks From <i>Kick Off</i>';
            $message .= '</p>';

            $headers =  array('Content-Type: text/html; charset=UTF-8', 'From: KICKOFF Sports <nikultaka@palladiumhub.com>', 'Reply-To: ');
            $mailData =  wp_mail($user->user_email, $subject, $message, $headers);
            //  end of send mail
        }
    }


    $result['status'] = 1;
    echo json_encode($result);
    exit();
}


//send_mail_users_enddate();

// add_action('members_invitation_cron', 'send_mail_users_enddate');

// put this line inside a function, 
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit
wp_schedule_single_event(time() + 86400, 'members_invitation_cron');




if (isset($_POST['function2call']) && !empty($_POST['function2call'])) {
    $function2call = $_POST['function2call'];
    switch ($function2call) {
        case 'send_mail_users_score':
            send_mail_users_score();
            break;
    }
}


function send_mail_users_score()
{

    global $wpdb;

    $mainresult['status'] = 0;
    $roundid = $_POST['roundid'];
    $leaguetable = $wpdb->prefix . "league";
    $usertable = $wpdb->prefix . "users";
    $jointeamtable = $wpdb->prefix . "jointeam";
    $matchscoretable = $wpdb->prefix . "score";
    $roundtable = $wpdb->prefix . "round";
    $teamtable = $wpdb->prefix . "team";
    $selectteam = $wpdb->prefix . "selectteam";
    $additionalpointstable = $wpdb->prefix . "additionalpoints";
    $scorepredictortable = $wpdb->prefix . "scorepredictor";
    $matchtable = $wpdb->prefix . "match";


    $attime = date("Y-m-d", strtotime('-1 day')); //current_time('Y-m-d H:i:s');

    $result_sql = "SELECT
        " . $jointeamtable . ".*,
        " . $leaguetable . ".name AS leaguename,
        " . $usertable . ".display_name AS username,
        " . $usertable . ".user_email AS useremail,
        " . $roundtable . ".scoremultiplier AS scoremultiplier,
        " . $roundtable . ".rname AS roundname,
        " . $roundtable . ".scoretype AS scoretype,
        CASE WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score 
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score ELSE ''
        END AS teamscore,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN t.teamname
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $teamtable . ".teamname
        ELSE ''
        END AS teamname,
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
        END AS userscore
        FROM
            " . $jointeamtable . "
        LEFT JOIN " . $leaguetable . " ON " . $leaguetable . ".id = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $usertable . " ON " . $usertable . ".id = " . $jointeamtable . ".userid
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $matchscoretable . " ON " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $matchtable . " ON " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 
        LEFT JOIN " . $roundtable . " ON " . $roundtable . ".id = " . $jointeamtable . ".roundid
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
        WHERE
            " . $jointeamtable . ".roundid =$roundid AND  date(" . $matchtable . ".enddate) <= '$attime' ";

    $teamselect_sql = $wpdb->get_results("select count(*) as multipliercount,userid from (SELECT  " . $matchscoretable . ".*," . $selectteam . ".userid,
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
         group by userid");

    $ary = [];
    foreach ($teamselect_sql as $user) {
        $ary[$user->userid] = $user->multipliercount;
    }
    $calculation_sql = $result_sql;
    $calculation_sql .= " group by " . $jointeamtable . ".id";
    $result = $wpdb->get_results($calculation_sql, OBJECT);
    $scoreByUserId = [];
    foreach ($result as $row) {
        if ($row->scoretype == 'added' && $row->scoremultiplier == 0) {
            $temp['yourscore'] = $row->userscore;
            $scoreByUserId[$row->userid] += $row->userscore * $ary[$row->userid];
        } else {
            $temp['yourscore'] = $row->userscore;
            $scoreByUserId[$row->userid] += $row->userscore;
        }
    }

    $mainresult = $wpdb->get_results($result_sql);

    foreach ($mainresult as $match) {
    
        //   send mail
        $subject = "Earn Points Now";
        $message = '<p>';
        $message .= 'Dear <b>' . $match->username . ',</b>';
        $message .= '<h3>You Select <h3><b><h2>' . $match->teamname . '</h2></b> In <b><h2>' . $match->roundname . '</h2></b>';
        $message .= '<h3>Your Score In This Round Is <b><h2>' . $scoreByUserId[$row->userid] . '</h2></b>';
        $message .= 'Thanks From <i>Kick Off</i>';
        $message .= '</p>';
        $headers =  array('Content-Type: text/html; charset=UTF-8', 'From: KICKOFF Sports <nikultaka@palladiumhub.com>', 'Reply-To: ');

        $mailData =  wp_mail($match->useremail, $subject, $message, $headers);
  
        //  end of send mail     
    }


    $mainresult['status'] = 1;
    echo json_encode($mainresult);
    exit(); 
}

// add_action('members_score_cron', 'send_mail_users_score');

// put this line inside a function, 
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit
wp_schedule_single_event(time() + 86400, 'members_score_cron');

