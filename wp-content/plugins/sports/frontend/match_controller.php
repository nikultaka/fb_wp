<?php
class match_list_Controller
{

    function match_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/matchlist.php");
        $s = ob_get_contents();
        ob_end_clean();
        print $s;
    }

    public function get_match_list()
    {
        global $wpdb;
        $matchId = $_POST['id'];
        $result['status'] = 0;
        $sportstable = $wpdb->prefix . "sports";
        $leaguetable = $wpdb->prefix . "league";
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";

        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname ," . $leaguetable . ".name as leaguename ," . $sportstable . ".name as sportname
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        WHERE " . $matchtable . ".leagueid = " . $matchId . " and MSTATUS = 'active'");


        $match_string  = '';

        if (count($result_sql)>0) {
            foreach ($result_sql as $match) {
                $match_string .= '<div class="elementor-column elementor-col-50" data-id="3867c19" data-element_type="column">
                                      <div class="elementor-widget-wrap elementor-element-populated">
                                          <div class="elementor-element">
                                              <div class="elementor-widget-container">
                                                  <div class="kode-inner-fixer">
                                                      <div class="kode-team-match"> 
                                                              <span class="kode-subtitle col-sm-4">sport<h3>' . $match->sportname . '</h3></span>
                                                              <span class="kode-subtitle col-sm-4 ">League<h3>' . $match->leaguename . '</h3></span>
                                                              <span class="kode-subtitle col-sm-4">Round<h3>' . $match->roundname . '</h3><br></span>     
                                                          <ul>
                                                              <li><span >Team 1<h1>' . $match->team1 . '</h1></span>
                                                              <button  class="btn  btn-lg" onclick="join_team(' . $match->t1id . ','.$match->id.')">JOIN</button>
                                                              </li>

                                                              <li><span ><h2>Vs</h2></span></li>
                                                              <li><span >Team 2<h1>' . $match->team2 . '</h1></span>
                                                              <button  class="btn  btn-lg" onclick="join_team(' . $match->t2id . ','.$match->id.')">JOIN</button>
                                                              </li>
                                                          </ul>
                                                       
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>';
            }
        }else{
            $match_string .='<div class="card-body col-sm-4">
            <h1 class="card-title"> No Matches Found !</h1>
            </div>';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['match_string'] = $match_string;
        }
        echo json_encode($result);
        exit();
    }

    function add_team_join()
    {
 
        global $wpdb;
        $userid = get_current_user_id();      
        $teamId = $_POST['tid'];
        $matchId = $_POST['id'];

        $result['status'] = 0;
        $leaguetable = $wpdb->prefix . "league";
        $matchtable = $wpdb->prefix . "match";

        $result_sql = $wpdb->get_row("SELECT " . $matchtable . ".*," . $leaguetable . ".sports as sportid
        FROM " . $matchtable . " 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        WHERE " . $matchtable . ".id = " . $matchId . " and MSTATUS = 'active'");

        $sportid = $result_sql->sportid;
        $leagueid =$result_sql->leagueid;
        $roundid =$result_sql->round;

        
        $jointeamtable = $wpdb->prefix . "jointeam";
        $result_teamsql = $wpdb->get_row("SELECT " . $jointeamtable . ".id FROM " . $jointeamtable . " WHERE " . $jointeamtable . ".matchid = $matchId ");

        $updateId =$result_teamsql->id;

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";


        if ($updateId == '') {
            $wpdb->insert($jointeamtable, array(
                'userid'             => $userid,
                'sportid'            => $sportid,
                'leagueid'           => $leagueid,
                'roundid'            => $roundid,
                'matchid'            => $matchId,
                'teamid'             => $teamId,

            ));

            $data['status'] = 1;
            $data['msg'] = "You Joined Team Successfully";
           
        } else {
            $wpdb->update(
                $jointeamtable,
                array(
                    'userid'             => $userid,
                    'sportid'            => $sportid,
                    'leagueid'           => $leagueid,
                    'roundid'            => $roundid,
                    'matchid'            => $matchId,
                    'teamid'             => $teamId,
                ),
                array('id'  => $updateId)
            );

            $data['status'] = 1;
            $data['msg'] = "You Joined Team Successfully2";
        
        }

        echo json_encode($data);
        exit;

    }
}

$match_list_Controller = new match_list_Controller();

add_action('wp_ajax_nopriv_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));
add_action('wp_ajax_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));

add_action('wp_ajax_match_list_Controller::add_team_join', array($match_list_Controller, 'add_team_join'));
add_action('wp_ajax_nopriv_match_list_Controller::add_team_join', array($match_list_Controller, 'add_team_join'));


add_shortcode('match_list_short_code', array($match_list_Controller, 'match_list_short_code'));
