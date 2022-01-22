<?php

class Aleague_list_controller
{

    function league_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/leaguelist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    function get_league_list()
    {
        echo json_encode(array('status'=>1));
        die;
        // echo '<pre>';
        // print_r("hellllllllllllllllllllllllllllll");
        // die;
        // global $wpdb;
        // $result['status'] = 0;
        // $leaguetable = $wpdb->prefix . "league";

        // $get_sql = $wpdb->get_results("SELECT * FROM $leaguetable WHERE status = 'active' ");
        // echo '<pre>';
        // print_r($get_sql);
        // print_r("helloooooooo");

        // $league_string  = '';
        // if(!empty($get_sql))
        // {
        //     foreach($get_sql as $league){
        //         $league_string .= '';
        //     }
        // }

        // if ($get_sql > 0) {
        //     $result['status'] = 1;
        //     $result['league_string'] = $league_string;
        // }
        // echo json_encode($result);
        // exit();
    }

}

$league_list_Controller = new Aleague_list_controller();

add_action('wp_ajax_nopriv_Aleague_list_Controller::get_league_list', array($league_list_Controller, 'get_league_list'));
add_action('wp_ajax_A league_list_Controller::get_league_list', array($league_list_Controller, 'get_league_list'));


add_shortcode('league_list_short_code', array($league_list_Controller, 'league_list_short_code'));