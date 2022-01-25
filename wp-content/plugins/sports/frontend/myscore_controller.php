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
echo '<pre>';
print_r("comminf soon");

    }
    
}

$my_score_Controller = new my_score_Controller();

add_action('wp_ajax_nopriv_my_score_Controller::get_my_score', array($my_score_Controller, 'get_my_score'));
add_action('wp_ajax_my_score_Controller::get_my_score', array($my_score_Controller, 'get_my_score'));

add_shortcode('my_score_list', array($my_score_Controller, 'my_score'));