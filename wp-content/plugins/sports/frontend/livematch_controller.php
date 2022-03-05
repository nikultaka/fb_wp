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

    function live_leaderboard_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/homepage_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/leaderboard.php");
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
        $teamtable = $wpdb->prefix . "team";
        $matchscoretable = $wpdb->prefix . "score";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $userid = get_current_user_id();


        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ,
        " . $sportstable . ".name as sportname," . $matchscoretable . ".team1score as team1score ," . $matchscoretable . ".team2score as team2score ,
        " . $teamtable . ".teamname as team1name , t.teamname as team2name
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
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
                                                            <h2><a href="#">' . $match->team1name . '</a> </h2>
                                                            <ul>
                                                            <li><a href="#">Sport <span>(' . $match->sportname . ')</span></a></li>
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
                                                            <h2><a href="#">' . $match->team2name . '</a></h2>
                                                            <ul>
                                                            <li><a href="#">Sport <span>(' . $match->sportname . ')</span></a></li>
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
    {
        global $wpdb;
        $result['status'] = 0;
        $sportstable = $wpdb->prefix . "sports";
        $leaguetable = $wpdb->prefix . "league";
        $matchtable = $wpdb->prefix . "match";
        $teamtable = $wpdb->prefix . "team";
        $roundtable = $wpdb->prefix . "round";
        $matchscoretable = $wpdb->prefix . "score";


        $attime = date("Y-m-d", strtotime('+1 day')); //current_time('Y-m-d H:i:s');


        $result_sql = $wpdb->get_row("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ,
        " . $sportstable . ".name as sportname," . $matchscoretable . ".team1score as team1score ," . $matchscoretable . ".team2score as team2score ,
        " . $teamtable . ".teamname as team1name , t.teamname as team2name 
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $matchtable . ".id
        WHERE   MSTATUS = 'active' AND  date(" . $matchtable . ".enddate) >= '$attime' ORDER BY " . $matchtable . ".enddate ");
        $upcoming_match_string  = '';

        $team1 = $result_sql->team1name;
        $team2 = $result_sql->team2name;
        $enddate = $result_sql->enddate;

        if (count($result_sql) > 0) {
            $upcoming_match_string  = '<section class="elementor-section elementor-top-section elementor-element elementor-element-095297c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="095297c" data-element_type="section">
            <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9e2fe1f" data-id="9e2fe1f" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-47716d5 elementor-widget elementor-widget-fancy-heading" data-id="47716d5" data-element_type="widget" data-widget_type="fancy-heading.default">
                            <div class="elementor-widget-container">
                                <div class="fancy-heading-wrapper fancy-heading-47716d5">
                                    <div class="kode-simple-heading kode-align-center ">
                                        <div class="heading heading-12 kode-align-center">
                                            <p>Is Your Team Ready For Next Match !</p>
                                            <h2><span class="left"></span>Next Match Started In<span class="right"></span></h2>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="elementor-section elementor-top-section elementor-element elementor-element-fc90703 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="fc90703" data-element_type="section">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-f7faee0 elementor-widget elementor-widget-events-list" data-id="f7faee0" data-element_type="widget" data-widget_type="events-list.default">
                            <div class="elementor-widget-container">
                                <div class="events-item-wrapper events-f7faee0">
                                    <div class="kode-result-list shape-view">
                                        <div class="kode-inner-fixer">
                                            <div class="kode-team-match">
                                                <ul>
                                                    <li>
                                                        <a href="#"><img alt="" src="' . plugins_url('sports/images/3.png') . '"></a></br>
                                                        <h1><a style="color: #063869;" >' . $team1 . '</a></h1>
                                                    </li>
                                                    <li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="#">vs</a></li>
                                                    <li>
                                                        <a href="#"><img alt="" src="' . plugins_url('sports/images/4.png') . '"></a></br>
                                                        <h1><a style="color: #063869;">' . $team2 . '</a></h1>
                                                    </li>
                                                </ul>
                                                <span class="kode-subtitle"><span style="color: #063869; font-size: 25px;" >Match Starts After<b> ' . $enddate . '</br></span>Match Between Both Big Teams Starts</span>
                                                                                              
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
        } else {
            $upcoming_match_string .= '
            <section class="elementor-section elementor-top-section elementor-element elementor-element-095297c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="095297c" data-element_type="section">
            <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9e2fe1f" data-id="9e2fe1f" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-47716d5 elementor-widget elementor-widget-fancy-heading" data-id="47716d5" data-element_type="widget" data-widget_type="fancy-heading.default">
                            <div class="elementor-widget-container">
                                <div class="fancy-heading-wrapper fancy-heading-47716d5">
                                    <div class="kode-simple-heading kode-align-center ">
                                        <div class="heading heading-12 kode-align-center">
                                            <p>Is Your Team Ready For Next Match !</p>
                                            <h2><span class="left"></span>Next Match Started In<span class="right"></span></h2>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="elementor-section elementor-top-section elementor-element elementor-element-fc90703 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="fc90703" data-element_type="section">
            <div class="elementor-widget-wrap elementor-element-populated">
                <div class="elementor-element elementor-element-f7faee0 elementor-widget elementor-widget-events-list" data-id="f7faee0" data-element_type="widget" data-widget_type="events-list.default">
                    <div class="elementor-widget-container">
                        <div class="events-item-wrapper events-f7faee0">
                            <div class="kode-result-list shape-view">
                                <div class="kode-inner-fixer">
                                <div class="col-md-12" >
                         <center><a href="#" style=" font-size:50px !important; text-align: center; font-family: Oswald;">No Upcoming Matches !</a></center>
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['upcoming_match_string'] = $upcoming_match_string;
        }
        echo json_encode($result);
        exit();
    }


    public function live_leaderboard_list()
    {

        global $wpdb;
        $leaguetable = $wpdb->prefix . "league";

        $result_sql = $wpdb->get_results("SELECT * FROM " . $leaguetable . " WHERE STATUS = 'active' ORDER BY id DESC LIMIT 5");

        $live_leaderboard_string  = '';

        if (count($result_sql) > 0) {

            $live_leaderboard_string  .= '
            <section class="elementor-section elementor-top-section elementor-element elementor-element-095297c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="095297c" data-element_type="section">
            <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9e2fe1f" data-id="9e2fe1f" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-47716d5 elementor-widget elementor-widget-fancy-heading" data-id="47716d5" data-element_type="widget" data-widget_type="fancy-heading.default">
                            <div class="elementor-widget-container">
                                <div class="fancy-heading-wrapper fancy-heading-47716d5">
                                    <div class="kode-simple-heading kode-align-center ">
                                        <div class="heading heading-12 kode-align-center">
                                            <p>Explore Your Favorite Leagues !</p>
                                            <h2><span class="left"></span>Leader Board<span class="right"></span></h2>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

            foreach ($result_sql as $leaderboard) {

                $live_leaderboard_string .= '
                <div class="col-md-4">                
                <div class="container10FFG">
                    <div class="card1FFG"> 
                    <div class="txtFFG">            
                    <center><a class="pointer t1FFG" onclick="load_leaderboard_Pointtable(' . $leaderboard->id . ')">' . $leaderboard->name . '</a><center>                
                    </div>                    
                    </div>
                    </div>
                </div>';
            }
        } else {
            $live_leaderboard_string .= '';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['live_leaderboard_string'] = $live_leaderboard_string;
        }
        echo json_encode($result);
        exit();
    }

    public function load_leaderboard_Pointtable()
    {
        global $wpdb;
        $leagueId = $_POST['id'];
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchscoretable = $wpdb->prefix . "score";
        $roundtable = $wpdb->prefix . "round";
        $selectteam = $wpdb->prefix . "selectteam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";

        $result_sql = "SELECT
        " . $jointeamtable . ".*,
        " . $leaguetable . ".name AS leaguename,
        " . $usertable . ".display_name AS username,
        " . $roundtable . ".scoremultiplier AS scoremultiplier,
        " . $roundtable . ".scoretype AS scoretype,
        CASE WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score 
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score ELSE ''
        END AS teamscore,
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
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 
        LEFT JOIN " . $roundtable . " ON " . $roundtable . ".id = " . $jointeamtable . ".roundid
        WHERE
            " . $jointeamtable . ".leagueid = $leagueId   
         ";


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

        // $sortfinalvalue = array();
        // arsort($scoreByUserId);
  


        $result_sql .= " group by userid";

        $mainresult = $wpdb->get_results($result_sql);


        $live_leaderboard_points_string  = '';
        if (count($mainresult) > 0) {

            foreach ($mainresult as  $leaderboardpoints) {
                $leaderboardpoints->finalPoint = $scoreByUserId[$leaderboardpoints->userid];
            }
            array_multisort($scoreByUserId, SORT_DESC, $mainresult);

            foreach ($mainresult as  $leaderboardpoints) {
                $live_leaderboard_points_string .= '
        <div class="col-md-4">                
        <div class="containerFFG">
            <div class="cardFFG">
                <div class="txtFFG">
                <div class="tFFG"><h5>Sportname : ' . $leaderboardpoints->sportname . '</h5></div>
                <div class="PFFG"><div class="tFFG"><h5>Leaguename : ' . $leaderboardpoints->leaguename . '</h5></div></div>
                <div class="PFFG"><div class="tFFG"><h5>Username : ' . $leaderboardpoints->username . '</h5></div></div>
                <div class="PFFG"><div class="tFFG"><h5>Final Points : ' . $leaderboardpoints->finalPoint . '</h5></div></div>
                </div>
            </div>
            </div>
        </div>';
            }
        } else {
            $live_leaderboard_points_string .= '
        
             <div class="col-md-12">
             <div class="container2FFG">
             <div class="card2FFG">
                 <div class="txtFFG">
                 <div class="t2FFG"><h2>No User Found In This League !</h2></div>
                 </div>
             </div>
             </div>
         </div>';
        }

        if ($mainresult > 0) {
            $result['status'] = 1;
            $result['live_leaderboard_points_string'] = $live_leaderboard_points_string;
        }
        echo json_encode($result);
        exit();
    }
}

$live_match_list_Controller = new live_match_list_Controller();

add_action('wp_ajax_nopriv_live_match_list_Controller::live_match_list', array($live_match_list_Controller, 'live_match_list'));
add_action('wp_ajax_live_match_list_Controller::live_match_list', array($live_match_list_Controller, 'live_match_list'));

add_action('wp_ajax_nopriv_live_match_list_Controller::upcoming_match_list', array($live_match_list_Controller, 'upcoming_match_list'));
add_action('wp_ajax_live_match_list_Controller::upcoming_match_list', array($live_match_list_Controller, 'upcoming_match_list'));

add_action('wp_ajax_nopriv_live_match_list_Controller::live_leaderboard_list', array($live_match_list_Controller, 'live_leaderboard_list'));
add_action('wp_ajax_live_match_list_Controller::live_leaderboard_list', array($live_match_list_Controller, 'live_leaderboard_list'));

add_action('wp_ajax_nopriv_live_match_list_Controller::load_leaderboard_Pointtable', array($live_match_list_Controller, 'load_leaderboard_Pointtable'));
add_action('wp_ajax_live_match_list_Controller::load_leaderboard_Pointtable', array($live_match_list_Controller, 'load_leaderboard_Pointtable'));

add_shortcode('live_match_list_short_code', array($live_match_list_Controller, 'live_match_list_short_code'));
add_shortcode('upcoming_match_list_short_code', array($live_match_list_Controller, 'upcoming_match_list_short_code'));
add_shortcode('live_leaderboard_list_short_code', array($live_match_list_Controller, 'live_leaderboard_list_short_code'));
