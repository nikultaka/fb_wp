<?php
class sport_list_Controller
{

    function sport_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/sportlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function get_sport_list()
    {
        global $wpdb;
        $result['status'] = 0;
        $sportstable = $wpdb->prefix . "sports";

        $get_sql = $wpdb->get_results("SELECT * FROM " . $sportstable . " WHERE STATUS = 'active'");

        $sport_string  = '';

        if (!empty($get_sql)) {          
            foreach ($get_sql as $sport) {
            $baseleaguelink = home_url("/leagues/?id=". $sport->id);
            $sport_string .= '<div class="card-body col-sm-4">
              <h3 class="card-title"> <a class="btn btn-block btn-lg" href='.$baseleaguelink.' type="button">' . $sport->name . '</a></h3>
              </div>';
            }
        }

        if ($get_sql > 0) {
            $result['status'] = 1;
            $result['sport_string'] = $sport_string;
        }
        echo json_encode($result);
        exit();
    }

    
}

$sport_list_Controller = new sport_list_Controller();

add_action('wp_ajax_nopriv_sport_list_Controller::get_sport_list', array($sport_list_Controller, 'get_sport_list'));
add_action('wp_ajax_sport_list_Controller::get_sport_list', array($sport_list_Controller, 'get_sport_list'));

add_shortcode('sport_list_short_code', array($sport_list_Controller, 'sport_list_short_code'));