<?php
class round_list_Controller
{

    function round_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/roundlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function get_round_list()
    {

        global $wpdb;
        $roundId = $_POST['id'];

        $result['status'] = 0;
        $roundtable = $wpdb->prefix . "round";

        $result_sql = $wpdb->get_results("SELECT * FROM $roundtable WHERE leagueid = '$roundId' and RSTATUS = 'active' and iscomplete = 'NO' order by id ASC");

        $round_string  = '';

        if (count($result_sql)>0) {
            foreach ($result_sql as $round) {            
                $basematchlink = home_url("/matches/?id=" . $round->id);
                $round_string .= '<div class="card-body col-sm-6">
              <a class="sportbut" style="min-width: 500px !important;" href=' . $basematchlink . ' >' . $round->rname . '</a> </br></br></br>
              </div>';
            }
         
        }else{
            $round_string .='<div class="card-body col-sm-4">
            <h1 class="card-title"> No rounds Found !</h1>
            </div>';
        }
       
   

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['round_string'] = $round_string;
        }
        echo json_encode($result);
        exit();
    }
}

$round_list_Controller = new round_list_Controller();

add_action('wp_ajax_nopriv_round_list_Controller::get_round_list', array($round_list_Controller, 'get_round_list'));
add_action('wp_ajax_round_list_Controller::get_round_list', array($round_list_Controller, 'get_round_list'));


add_shortcode('round_list_short_code', array($round_list_Controller, 'round_list_short_code'));
