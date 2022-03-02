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
        $teamtable = $wpdb->prefix . "team";
        $roundtable = $wpdb->prefix . "round";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $selectteamtable = $wpdb->prefix . "selectteam";

        $userid = get_current_user_id();

        $result_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ," . $jointeamtable . ".roundselect as roundselect,           
        " . $sportstable . ".name as sportname,  " . $teamtable . ".teamname as team1name , t.teamname as team2name,
        (SELECT teamid from " . $jointeamtable . " where matchid = " . $matchtable . ".id and userid = $userid ) as teamid,
        (SELECT teamid from " . $selectteamtable . " where matchid = " . $matchtable . ".id and userid = $userid) as selectteamid,
        " . $roundtable . ".scoretype as scoretype," . $roundtable . ".scoremultiplier as scoremultiplier
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
        LEFT JOIN " . $jointeamtable . " on " . $jointeamtable . ".matchid = " . $matchtable . ".id and " . $jointeamtable . ".userid = " . $userid . "
        LEFT JOIN " . $selectteamtable . " on " . $selectteamtable . ".matchid = " . $matchtable . ".id and " . $selectteamtable . ".userid = " . $userid . "
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        WHERE " . $matchtable . ".round = " . $matchId . "  and MSTATUS = 'active' group by id  ");
        $match_string  = '';

        $roundselect_sql = $wpdb->get_results("SELECT " . $jointeamtable . ".*,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname
        FROM " . $jointeamtable . "
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid WHERE " . $jointeamtable . ".userid = $userid ");


        $teamname_sql = $wpdb->get_results("SELECT " . $jointeamtable . ".*,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname
        FROM " . $jointeamtable . "
        LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid WHERE " . $jointeamtable . ".userid = $userid AND " . $matchtable . ".round != $matchId ");

        $allteam = array();
        foreach ($teamname_sql as $row) {
            array_push($allteam, $row->teamname);
            
        }
        $allteam = array_map('strtolower', $allteam);

        $team_sql = $wpdb->get_results("SELECT " . $jointeamtable . ".leagueid, " . $jointeamtable . ".roundid,   CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname 
        FROM " . $jointeamtable . " LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid 
        WHERE " . $jointeamtable . ".userid = $userid 
        ");

        $result2_sql = $wpdb->get_row("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ," . $jointeamtable . ".roundselect as roundselect,           
        " . $sportstable . ".name as sportname,(SELECT teamid from " . $jointeamtable . " where matchid = " . $matchtable . ".id and userid = $userid ) as teamid," . $roundtable . ".scoretype as scoretype," . $roundtable . ".scoremultiplier as scoremultiplier 
        FROM " . $matchtable . " 
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $matchtable . ".leagueid
        LEFT JOIN " . $jointeamtable . " on " . $jointeamtable . ".matchid = " . $matchtable . ".id and userid = " . $userid . "
        LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports 
        WHERE " . $matchtable . ".round = " . $matchId . "  and MSTATUS = 'active' group by id  ");

        $scoremultiplier = $result2_sql->scoremultiplier;
        $scoretype = $result2_sql->scoretype;
        $leagueid = $result2_sql->leagueid;
        $round = $result2_sql->round;
        $type = ucfirst($scoretype);


        $validate_sql = $wpdb->get_results("SELECT * FROM $roundtable WHERE " . $roundtable . ".scoremultiplier ='1' and " . $roundtable . ".scoretype = 'added'");
        if (count($result_sql) > 0) {
            $match_string .= '
            <span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -30px;  margin-left: 135px; font-family: Oswald; "><b>Go Back</b></a></span>
            <div class="row">
            <div class="score112 kode-bg-color">
					<span class="kode-halfbg thbg-color"></span>
						<center>
							<div class="col-md-6">
                            <span class="text23">Score Type : ' . $type . '</span>
							</div>
							<div class="col-md-6">';
        if($scoremultiplier == 0 && $scoretype == 'added'){
            $match_string .= '<span class="text23">Super Scorer Round</span>
            </div>
						</center>				
				</div>
                </div>
                <span><a onclick="load_select_team_model(' . $leagueid . ',' . $round . ')" class="title btn" style="float: right; background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -50px;  margin-right: 95px; font-family: Oswald; "><b>Select Team</b></a></span><br><br><br>';
        }else{
            $match_string .= '<span class="text23">Score Multiplier : ' . $scoremultiplier . '</span>
            </div>
						</center>				
				</div>
                </div><br><br><br>';
        }      
            foreach ($result_sql as $match) {
   
                $teamname1 = strtolower($match->team1);
                $teamname2 = strtolower($match->team2);

                // if ($userid == $match->datauserid || $match->datauserid == '') {

                $match_string .= ' 
                               
                <div class="col-md-4 col-sm-4 col-xsx-4" style="padding-right: 5px;  padding-left: 5px;">
                                        <div class="serviceBox">
                                          <div class="service-icon">
                                            <span><i class="fa fa-trophy"></i></span>
                                          </div>
                                        <div class="row service-content">';
                if ($match->roundselect == 'scorePredictorround') {
                    $match_string .= '<span><a data-date="' . $match->enddate . '" id="match-' . $match->id . '" onclick="load_score_predicter_model(' . $match->id . ',' . $match->teamid . ')" class="title btn" style="float:right; background-color: #ffcc00; color: #24890d; font-size: 13px; margin-top:-50px; font-family: Oswald; "><b>Predict Score</b></a></span>';
                }
                if ($match->roundselect == 'jokeround') {
                    $match_string .= '<span><h3 class="title" style="float:right; color: #ffcc00; margin-top:-50px; font-family: Oswald; "><b>Joker Round</b></h3></span>';
                }
                $match_string .= ' <span class="kode-subtitle col-sm-4"><span class="text2">sport</span><h3 class="text">' . $match->sportname . '</h3></span>
                                          <span class="kode-subtitle col-sm-4 "><span class="text2">League</span><h3 class="text">' . $match->leaguename . '</h3></span>
                                          <span class="kode-subtitle col-sm-4"><span class="text2">Round</span><h3 class="text">' . $match->roundname . '</h3></span>
                                          <div class="col-md-6">
                                          <span><span class="text2">Team 1</span><h3 class="title"><b>' . $match->team1name . '</b></h3></span>';
                /*START*/ //////////////////
                if (is_user_logged_in()) {
                    if ($match->scoremultiplier == 0 && $match->scoretype == 'added') {
                        $match_string .= '<a class="read2-more pointer "  onclick="select_team(' . $match->t1id . ',' . $match->id . ')">';
                        if (
                            $match->selectteamid != '' && $match->selectteamid == 1
                        ) {
                            $match_string .= 'TEAM SELECTED';
                        } else {
                            $match_string .= 'SELECT TEAM';
                        }
                        $match_string .= '</a>';
                    }
                } else {
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="' . $singinlink . '" class="read2-more pointer" title="Join Team" data-toggle="tooltip">SELECT TEAM</a>';
                }
                /*END*/ //////////////////
                if (is_user_logged_in()) {
                    $match_string .= '<a class="read-more pointer match-' . $match->id . ' team_' . $match->t1id . '_' . $match->id . ' teamname_' . $teamname1 . '"  data-teamname1="' . $match->team1 . '" data-date="' . $match->enddate . '" id="match-' . $match->id . '" onclick="join_team(' . $match->t1id . ',' . $match->id . ',' . $match->leagueid . ',' . $match->round . ',' . $userid . ')">';

                    if (in_array($teamname1, $allteam)) {
                        $match_string .= 'PREVIOUSLY SELECTED';
                    } else {

                        if ($match->teamid != '' && $match->teamid == 1) {
                            $match_string .= 'SELECTED';
                        } else {
                            $match_string .= 'SELECT';
                        }
                    }
                    $match_string .= '</a>';
                } else {
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="' . $singinlink . '" class="read-more pointer" title="Join Team" data-toggle="tooltip">SELECT</a>';
                }

                $match_string .= '</div>
                                  <div class="col-md-6">
                                  <span><span class="text2">Team 2</span><h3 class="title"><b>' . $match->team2name . '</b></h3></span>';
                /*START*/ //////////////////
                if (is_user_logged_in()) {
                    if ($match->scoremultiplier == 0 && $match->scoretype == 'added') {
                        $match_string .= '<a class="read2-more pointer"  onclick="select_team(' . $match->t2id . ',' . $match->id . ')">';
                        if (
                            $match->selectteamid != '' && $match->selectteamid == 0
                        ) {
                            $match_string .= 'TEAM SELECTED';
                        } else {
                            $match_string .= 'SELECT TEAM';
                        }
                        $match_string .= '</a>';
                    }
                } else {
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="' . $singinlink . '" class="read2-more pointer" title="Join Team" data-toggle="tooltip">SELECT TEAM</a>';
                }
                /*END*/ //////////////////
                if (is_user_logged_in()) {
                    $match_string .= '<a class="read-more pointer match-' . $match->id . ' team_' . $match->t2id . '_' . $match->id . ' teamname_' . $teamname2 . '" data-teamname2="' . $match->team2 . '" data-date="' . $match->enddate . '" id="match-' . $match->id . '" onclick="join_team(' . $match->t2id . ',' . $match->id . ',' . $match->leagueid . ',' . $match->round . ',' . $userid . ')">';
                    if (in_array($teamname2, $allteam)) {
                        $match_string .= 'PREVIOUSLY SELECTED';
                    } else {
                        if (
                            $match->teamid != '' && $match->teamid == 0
                        ) {
                            $match_string .= 'SELECTED';
                        } else {
                            $match_string .= 'SELECT';
                        }
                    }
                    $match_string .= '</a>';
                } else {
                    $singinlink = home_url('my-account/');
                    $match_string .= '<a  href="' . $singinlink . '" class="read-more pointer" title="Join Team" data-toggle="tooltip">SELECT</a>';
                }

                $match_string .= '</div>
                      
                                          </div>
                                        </div>
                                      </div>';
                // }
            }
          
        } else {
            $match_string .= '
            <span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -30px;  margin-left: 135px; font-family: Oswald; "><b>Go Back</b></a></span>
            <div class="card-body col-sm-4">
            <h1 class="card-title"> No Matches Found !</h1>
            </div>';
        }

        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['match_string'] = $match_string;
            $result['teamData'] = $team_sql;
            $result['roundSelectData'] = $roundselect_sql;
            $result['validateData'] = $validate_sql;
        }
        echo json_encode($result);
        exit();
    }

    function add_team_join()
    {
        global $wpdb;
        if ($_POST['uid'] != "") {
            $userid = $_POST['uid'];
        } else {
            $userid = get_current_user_id();
        }

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


        if ($roundselect == 'jokeround') {

            $jointeamtable = $wpdb->prefix . "jointeam";
            $delete_teamsql = $wpdb->query("DELETE  FROM " . $jointeamtable . " WHERE " . $jointeamtable . ".leagueid = $leagueid and " . $jointeamtable . ".roundselect = 'jokeround' 
            and " . $jointeamtable . ".userid = $userid ");
            $result_teamsql = $wpdb->get_row("SELECT " . $jointeamtable . ".id FROM " . $jointeamtable . " WHERE " . $jointeamtable . ".leagueid = $leagueid and " . $jointeamtable . ".roundid = $roundid  and " . $jointeamtable . ".userid = $userid ");
        } else {

            $jointeamtable = $wpdb->prefix . "jointeam";
            $result_teamsql = $wpdb->get_row("SELECT " . $jointeamtable . ".id FROM " . $jointeamtable . " WHERE " . $jointeamtable . ".roundid = $roundid and " . $jointeamtable . ".userid = $userid ");
        }
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

    function add_team_selection()
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
        $leagueid = $result_sql->leagueid;
        $roundid = $result_sql->round;

        $Selectteamtable = $wpdb->prefix . "selectteam";
        $result_teamsql = $wpdb->get_row("SELECT " . $Selectteamtable . ".id FROM " . $Selectteamtable . " WHERE " . $Selectteamtable . ".matchid = $matchId and " . $Selectteamtable . ".userid = $userid ");

        $updateId = $result_teamsql->id;
        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";


        if ($updateId == '') {
            $wpdb->insert($Selectteamtable, array(
                'userid'             => $userid,
                'sportid'            => $sportid,
                'leagueid'           => $leagueid,
                'roundid'            => $roundid,
                'matchid'            => $matchId,
                'teamid'             => $teamId,
            ));

            $data['status'] = 1;
            $data['msg'] = "You SELECTED Team Successfully2";
        } else {
            $wpdb->update(
                $Selectteamtable,
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
        $userid = get_current_user_id();
        $scorepredictor     = $_POST['scorepredictor'];
        $hdnsprmatchid = $_POST['hdnsprmatchid'];
        $hdnsprteamid = $_POST['hdnsprteamid'];
        $scorepredictortable = $wpdb->prefix . "scorepredictor";

        if ($updateId == '') {
            $wpdb->insert($scorepredictortable, array(
                'scorepredictor'         => $scorepredictor,
                'matchid'                => $hdnsprmatchid,
                'teamid'                 => $hdnsprteamid,
                'userid'                 => $userid,
            ));
            $data['status'] = 1;
            $data['msg'] = "Your Predicted Score added successfully";
        } else {
            $wpdb->update(
                $scorepredictortable,
                array(
                    'scorepredictor'         => $scorepredictor,
                    'matchid'                => $hdnsprmatchid,
                    'teamid'                 => $hdnsprteamid,
                    'userid'                 => $userid,
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
        $userid = get_current_user_id();
        $scorepredictortable = $wpdb->prefix . "scorepredictor";
        $result_sql = $wpdb->get_results("SELECT * FROM " . $scorepredictortable . " WHERE matchid = " . $matchid . " AND userid = $userid ");

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

add_action('wp_ajax_match_list_Controller::add_team_selection', array($match_list_Controller, 'add_team_selection'));
add_action('wp_ajax_nopriv_match_list_Controller::add_team_selection', array($match_list_Controller, 'add_team_selection'));

add_action('wp_ajax_match_list_Controller::score_predictor_insert_data', array($match_list_Controller, 'score_predictor_insert_data'));
add_action('wp_ajax_nopriv_match_list_Controller::score_predictor_insert_data', array($match_list_Controller, 'score_predictor_insert_data'));

add_action('wp_ajax_match_list_Controller::score_predictor_load_data', array($match_list_Controller, 'score_predictor_load_data'));
add_action('wp_ajax_nopriv_match_list_Controller::score_predictor_load_data', array($match_list_Controller, 'score_predictor_load_data'));

add_action('wp_ajax_match_list_Controller::send_mail_users_enddate', array($match_list_Controller, 'send_mail_users_enddate'));
add_action('wp_ajax_nopriv_match_list_Controller::send_mail_users_enddate', array($match_list_Controller, 'send_mail_users_enddate'));

add_shortcode('match_list_short_code', array($match_list_Controller, 'match_list_short_code'));
