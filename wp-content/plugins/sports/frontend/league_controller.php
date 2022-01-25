<?php
class league_list_Controller
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

    public function get_league_list()
    {

        global $wpdb;
        $sportId = $_POST['id'];
       
        $result['status'] = 0;
        $leaguetable = $wpdb->prefix . "league";

        $result_sql = $wpdb->get_results("SELECT * FROM $leaguetable WHERE sports = '$sportId' and STATUS = 'active'");

        $league_string  = '';

        if (!empty($result_sql)) {
            foreach ($result_sql as $league) {
                $basematchlink = home_url("/matches/?id=" . $league->id);
                $league_string .= '<div class="card-body col-sm-4">
              <h3 class="card-title"> <a class="btn btn-block btn-lg" href=' . $basematchlink . ' type="button">' . $league->name . '</a></h3>
              </div>';
            }
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['league_string'] = $league_string;
        }
        echo json_encode($result);
        exit();
    }
}

$league_list_Controller = new league_list_Controller();

add_action('wp_ajax_nopriv_league_list_Controller::get_league_list', array($league_list_Controller, 'get_league_list'));
add_action('wp_ajax_league_list_Controller::get_league_list', array($league_list_Controller, 'get_league_list'));


add_shortcode('league_list_short_code', array($league_list_Controller, 'league_list_short_code'));