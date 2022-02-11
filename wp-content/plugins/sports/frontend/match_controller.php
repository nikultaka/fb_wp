<?php
class match_list_Controller
{

    function match_list_short_code()
    {
        ob_start();
        wp_enqueue_script('script', plugins_url('../Script/league_script.js', __FILE__));
        include(dirname(__FILE__) . "/html/matchlist.php");
        include(dirname(__FILE__) . "/html/scorepredictormodel.php");
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
        $jointeamtable = $wpdb->prefix . "jointeam";
        $userid = get_current_user_id();


        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ," . $jointeamtable . ".roundselect as roundselect,
        " . $sportstable . ".name as sportname,(SELECT teamid from " . $jointeamtable . " where matchid = " . $matchtable . ".id and userid = $userid ) as teamid
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid
        LEFT JOIN " . $jointeamtable . " on " . $jointeamtable . ".matchid = " . $matchtable . ".id
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        WHERE " . $matchtable . ".round = " . $matchId . "  and MSTATUS = 'active' ");
        $match_string  = '';
        $roundselect_sql = $wpdb->get_results("SELECT " . $jointeamtable . ".leagueid ," . $jointeamtable . ".roundid, " . $jointeamtable . ".roundselect, " . $jointeamtable . ".id 
        From " . $jointeamtable . " WHERE " . $jointeamtable . ".userid = $userid ");

        $team_sql = $wpdb->get_results("SELECT FROM " . $jointeamtable . " LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid ");

        $validate_sql = $wpdb->get_results("SELECT * FROM $roundtable WHERE " . $roundtable . ".scoremultiplier ='1' and " . $roundtable . ".scoretype = 'added'");

        if (count($result_sql) > 0) {

            foreach ($result_sql as $match) {
                // if ($userid == $match->datauserid || $match->datauserid == '') {

                $match_string .= '<div class="col-md-6 col-sm-6 col-xsx-6">
                                        <div class="serviceBox">
                                          <div class="service-icon">
                                            <span><i class="fa fa-trophy"></i></span>
                                          </div>
                                        <div class="row service-content">';
                if ($match->roundselect == 'scorePredictorround') {                        
                $match_string .= '<span><a data-date="'.$match->enddate.'" id="match-'.$match->id.'" onclick="load_score_predicter_model(' . $match->id . ',' . $match->teamid . ')" class="title btn" style="float:right; background-color: #ffcc00; color: #24890d; font-size: 15px; margin-top:-50px; font-family: Oswald; "><b>Predict Your Score Here</b></a></span>';
                }
                if ($match->roundselect == 'jokeround') {                        
                    $match_string .= '<span><h3 class="title" style="float:right; color: #ffcc00; margin-top:-50px; font-family: Oswald; "><b>Joker Round</b></h3></span>';
                    }
                $match_string .= '</br><span class="kode-subtitle col-sm-4"><span class="text2">sport</span><h3 class="text">' . $match->sportname . '</h3></span>
                                          <span class="kode-subtitle col-sm-4 "><span class="text2">League</span><h3 class="text">' . $match->leaguename . '</h3></span>
                                          <span class="kode-subtitle col-sm-4"><span class="text2">Round</span><h3 class="text">' . $match->roundname . '</h3><br></span>
                                          <div class="col-md-6">
                                          <span><span class="text2">Team 1</span><h3 class="title"><b>' . $match->team1 . '</b></h3></span>';
                if ( is_user_logged_in() ) {
                    $match_string .= '<a class="read-more pointer match-'.$match->id.' team_' . $match->t1id . '_' . $match->id .'"  data-teamname1="'.$match->team1.'" data-date="'.$match->enddate.'" id="match-'.$match->id.'" onclick="join_team(' . $match->t1id . ',' . $match->id .',' . $match->leagueid .',' . $match->round .')">';
                    if($match->teamid != '' && $match->teamid == 1) { $match_string .= 'SELECTED';}else{ $match_string .= 'SELECT';}
                    $match_string .= '</a>';
                }else{
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="'.$singinlink.'" class="read-more pointer" title="Join Team" data-toggle="tooltip">SELECT</a>';
                }  
                $match_string .= '</div>
                                  <div class="col-md-6">
                                  <span><span class="text2">Team 2</span><h3 class="title"><b>' . $match->team2 . '</b></h3></span>';
                if ( is_user_logged_in() ) {
                    $match_string .= '<a class="read-more pointer match-'.$match->id.' team_' . $match->t2id . '_' . $match->id .'" data-teamname2="'.$match->team2.'" data-date="'.$match->enddate.'" id="match-'.$match->id.'" onclick="join_team(' . $match->t2id . ',' . $match->id .',' . $match->leagueid .',' . $match->round .')">';
                    if($match->teamid != '' && $match->teamid == 0
                    ) { $match_string .= 'SELECTED';}else{ $match_string .= 'SELECT';}
                    $match_string .= '</a>';
                }else{
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="'.$singinlink.'" class="read-more pointer" title="Join Team" data-toggle="tooltip">SELECT</a>';
                }
                $match_string .= '</div>
                      
                                          </div>
                                        </div>
                                      </div>';
            // }
        }
        
        } else {
            $match_string .= '<div class="card-body col-sm-4">
             <h1 class="card-title"> No Matches Found !</h1>
             </div>';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['match_string'] = $match_string;
            $result['teamData'] =$team_sql;
            $result['roundSelectData'] =$roundselect_sql;
            $result['validateData'] =$validate_sql;




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
        $roundselect = $_POST['roundselect'];

        $result['status'] = 0;
        $leaguetable = $wpdb->prefix . "league";
        $matchtable = $wpdb->prefix . "match";

        $result_sql = $wpdb->get_row("SELECT " . $matchtable . ".*," . $leaguetable . ".sports as sportid
        FROM " . $matchtable . " 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid 
        WHERE " . $matchtable . ".id = " . $matchId . " and MSTATUS = 'active'");

        $sportid = $result_sql->sportid;
        $leagueid = $result_sql->leagueid;
        $roundid = $result_sql->round;


        $jointeamtable = $wpdb->prefix . "jointeam";
        $result_teamsql = $wpdb->get_row("SELECT " . $jointeamtable . ".id FROM " . $jointeamtable . " WHERE " . $jointeamtable . ".roundid = $roundid and " . $jointeamtable . ".userid = $userid ");

        $updateId = $result_teamsql->id;

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
                'roundselect'        => $roundselect,

            ));

            $data['status'] = 1;
            $data['msg'] = "You SELECTED Team Successfully2";
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
                    'roundselect'        => $roundselect,

                ),
                array('id'  => $updateId)
            );

            $data['status'] = 1;
            $data['msg'] = "You SELECTED Team Successfully2";
        }

        echo json_encode($data);
        exit;
    }
    
    function score_predictor_insert_data()
    {

        global $wpdb;
        $updateId = $_POST['hspfid'];

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";

        $scorepredictor	 = $_POST['scorepredictor'];
        $hdnsprmatchid = $_POST['hdnsprmatchid'];
        $hdnsprteamid = $_POST['hdnsprteamid'];
        $scorepredictortable = $wpdb->prefix . "scorepredictor";

        if ($updateId == '') {
            $wpdb->insert($scorepredictortable, array(
                'scorepredictor'         => $scorepredictor,            
                'matchid'                => $hdnsprmatchid,
                'teamid'                => $hdnsprteamid,

            ));
            $data['status'] = 1;
            $data['msg'] = "Your Predicted Score added successfully";
        } else {
            $wpdb->update(
                $scorepredictortable,
                array(
                    'scorepredictor'         => $scorepredictor,               
                    'matchid'                => $hdnsprmatchid,
                    'teamid'                => $hdnsprteamid,

                ),
                array('id'  => $updateId)
            );
            $data['status'] = 1;
            $data['msg'] = "Your Predicted Score updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function score_predictor_load_data()
    {
        global $wpdb;
        $matchid = $_POST['matchid'];
        $scorepredictortable = $wpdb->prefix . "scorepredictor";
        $result_sql = $wpdb->get_results("SELECT * FROM " . $scorepredictortable . " WHERE matchid = ".$matchid."");

        $result['status'] = 1;
        $result['recoed'] = $result_sql[0];
        echo json_encode($result);
        exit();
    }
}

$match_list_Controller = new match_list_Controller();

add_action('wp_ajax_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));
add_action('wp_ajax_nopriv_match_list_Controller::get_match_list', array($match_list_Controller, 'get_match_list'));

add_action('wp_ajax_match_list_Controller::add_team_join', array($match_list_Controller, 'add_team_join'));
add_action('wp_ajax_nopriv_match_list_Controller::add_team_join', array($match_list_Controller, 'add_team_join'));

add_action('wp_ajax_match_list_Controller::score_predictor_insert_data', array($match_list_Controller, 'score_predictor_insert_data'));
add_action('wp_ajax_nopriv_match_list_Controller::score_predictor_insert_data', array($match_list_Controller, 'score_predictor_insert_data'));

add_action('wp_ajax_match_list_Controller::score_predictor_load_data', array($match_list_Controller, 'score_predictor_load_data'));
add_action('wp_ajax_nopriv_match_list_Controller::score_predictor_load_data', array($match_list_Controller, 'score_predictor_load_data'));

add_shortcode('match_list_short_code', array($match_list_Controller, 'match_list_short_code'));
