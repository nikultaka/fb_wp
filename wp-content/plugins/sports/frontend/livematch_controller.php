<?php
class live_match_list_Controller
{

    function live_match_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/homepage_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/livematch.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    function upcoming_match_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/homepage_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/upcomingmatch.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function live_match_list()
    {
        global $wpdb;
        $result['status'] = 0;
        $sportstable = $wpdb->prefix . "sports";
        $leaguetable = $wpdb->prefix . "league";
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";
        $matchscoretable = $wpdb->prefix . "score";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $userid = get_current_user_id();


        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ,
        " . $sportstable . ".name as sportname," . $matchscoretable . ".team1score as team1score ," . $matchscoretable . ".team2score as team2score 
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $matchtable . ".id
        WHERE   MSTATUS = 'active' ");
        $live_match_string  = '';

        if (count($result_sql) > 0) {
            $live_match_string  = '<section class="elementor-section elementor-top-section elementor-element elementor-element-059106d elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="059106d" data-element_type="section">
                <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-8332903" data-id="8332903" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-b2e6b1b elementor-widget elementor-widget-fancy-heading" data-id="b2e6b1b" data-element_type="widget" data-widget_type="fancy-heading.default">
                        <div class="elementor-widget-container">
                            <div class="fancy-heading-wrapper fancy-heading-b2e6b1b">
                                <div class="kode-simple-heading kode-align-center ">
    
                                    <div class="heading heading-12 kode-align-center">
                                        <p>Devoted to</p>
                                        <h2><span class="left"></span>Current Match Statistics<span class="right"></span></h2>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>';
            $matchcount = 0;
            foreach ($result_sql as $match) {
                $timestamp = strtotime($match->enddate);
                $new_date_format = date('Y-m-d', $timestamp);

                if ($match->enddate != '' &&  $new_date_format == date("Y-m-d")) {
                    $matchcount++;
                    $live_match_string .= '
                            <div class="elementor-element elementor-element-6dbafe4 elementor-widget elementor-widget-events-list" data-id="6dbafe4" data-element_type="widget" data-widget_type="events-list.default">
                                <div class="elementor-widget-container">
                                    <div class="events-item-wrapper events-6dbafe4">
                                        <div class="kode-result-list shape-view">
                                            <div class="row margin-bottom-top-50">
                                                <div class="col-md-6">
                                                    <article>
                                                        <span class="kode-result-count thbg-colortwo">' . $match->team1score . '</span>
                                                        <div class="kode-result-thumb">
                                                            <a href="#"><img alt="" src="' . plugins_url('sports/images/2.png') . '">
                                                            </a>
                                                        </div>
                                                        <div class="kode-result-info">
                                                            <h2><a href="#">' . $match->team1 . '</a> </h2>
                                                            <ul>
                                                            <li><a href="#">sport <span>(' . $match->sportname . ')</span></a></li>
                                                            <li><a href="#">League <span>(' . $match->leaguename . ')</span></a></li>
                                                            <li><a href="#">Round <span>(' . $match->roundname . ')</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div class="col-md-6">
                                                    <article class="kode-even">
                                                        <span class="kode-result-count thbg-colortwo">' . $match->team2score . '</span>
                                                        <div class="kode-result-thumb">
                                                        <a href="#"><img alt="" src="' . plugins_url('sports/images/1.png') . '">

                                                            </a>
                                                        </div>
                                                        <div class="kode-result-info">
                                                            <h2><a href="#">' . $match->team2 . '</a></h2>
                                                            <ul>
                                                            <li><a href="#">sport <span>(' . $match->sportname . ')</span></a></li>
                                                            <li><a href="#">League <span>(' . $match->leaguename . ')</span></a></li>
                                                            <li><a href="#">Round <span>(' . $match->roundname . ')</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';
                }
            }
            if ($matchcount == 0) {
                $live_match_string .= '
                <div class="kode-result-list shape-view">
               <div class="row margin-bottom-top-50">
                <div class="col-md-12" style="background-color: #333;  border-radius: 8px;">
                 <center><a href="#" style=" font-size:50px !important; text-align: center; color: #fff; font-family: Oswald;">No Matches Today !</a></center>
                </div>
               </div>
               </div>
               </div>
               </div>
           </div>
       </section>';
            }
        } else {
            $live_match_string .= '<div class="card-body col-sm-4">
             <h1 class="card-title"> No Live Matches Found !</h1>
            </div>';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['live_match_string'] = $live_match_string;
        }
        echo json_encode($result);
        exit();
    }


    public function upcoming_match_list()
    {}
}

$live_match_list_Controller = new live_match_list_Controller();

add_action('wp_ajax_nopriv_live_match_list_Controller::live_match_list', array($live_match_list_Controller, 'live_match_list'));
add_action('wp_ajax_live_match_list_Controller::live_match_list', array($live_match_list_Controller, 'live_match_list'));

add_action('wp_ajax_nopriv_live_match_list_Controller::upcoming_match_list', array($live_match_list_Controller, 'upcoming_match_list'));
add_action('wp_ajax_live_match_list_Controller::upcoming_match_list', array($live_match_list_Controller, 'upcoming_match_list'));

add_shortcode('live_match_list_short_code', array($live_match_list_Controller, 'live_match_list_short_code'));
add_shortcode('upcoming_match_list_short_code', array($live_match_list_Controller, 'upcoming_match_list_short_code'));
