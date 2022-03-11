<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/fb_wp/wp-load.php';

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');

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
        $user_sql = $wpdb->get_results("SELECT * FROM " . $usertable . " where ID NOT IN (SELECT userid FROM " . $jointeamtable . " where matchid =$match->id )");
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

add_action('members_invitation_cron', 'send_mail_users_enddate');

// put this line inside a function, 
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit
wp_schedule_single_event(time() + 86400, 'members_invitation_cron');
