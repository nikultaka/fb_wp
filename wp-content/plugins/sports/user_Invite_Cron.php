<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/fb_wp/wp-load.php';

$path = preg_replace('/wp-content.*$/','',__DIR__);
require_once($path.'wp-load.php');

function send_mail_users_enddate()
{
    die;
    global $wpdb;

    $result['status'] = 0;
    $matchtable = $wpdb->prefix . "match";
    $usertable = $wpdb->prefix . "users";
    $jointeamtable = $wpdb->prefix . "jointeam";
    $teamtable = $wpdb->prefix . "team";

        $attime = date("Y-m-d H:i:s", strtotime('-1 day')); //current_time('Y-m-d H:i:s');
    
        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*, " . $teamtable . ".teamname as team1name , t.teamname as team2name , " . $matchtable . ".enddate - INTERVAL 4 HOUR as sendtime FROM " . $matchtable . "
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2 
        WHERE   MSTATUS = 'active' HAVING sendtime <= '$attime' ORDER BY  " . $matchtable . ".enddate");

    //echo '<pre>'; print_r($user_sql); exit;

    foreach ($result_sql as $match) {
        $user_sql = $wpdb->get_results("SELECT * FROM " . $usertable . " where ID NOT IN (SELECT userid FROM " . $jointeamtable . " where matchid =$match->id )");
        foreach ($user_sql as $user) {
            //   send mail
        
            $subject = 'There’s Still Time…';
            $message = '<h2>Hi <b>' . $user->display_name . ',</b></h2>';
            $message .= '<h3>Just in case you haven’t placed your selection for this week’s round of the Ups & Downs Tipping competition, there’s still time.</h3>';
            $message .= '<h2>To make your selection visit  https://tiptopia.com.au/ or <a href="https://tiptopia.com.au/">Click Here</a>.</h2>';
            $message .= '<h3>Good Luck.</h3>';
            $message .= '<h3>The Tip Topia Team</h3>';
            $message .= '<p><img style="width:200px;" alt="" src="https://tiptopia.com.au/wp-content/uploads/2022/04/Screen-Shot-2022-04-01-at-4.20.43-pm.png">';
            $message .= '<p>';
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
// wp_schedule_single_event(time() + 86400, 'members_invitation_cron');
