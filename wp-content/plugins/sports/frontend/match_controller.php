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


        $teamname_by_round_sql = $wpdb->get_results("SELECT * FROM " . $matchtable . " WHERE " . $matchtable . ".round = $matchId ");
        $allteam_by_array = array();
        foreach ($teamname_by_round_sql as $row) {
            array_push($allteam_by_array, $row->team1);
            array_push($allteam_by_array, $row->team2);
        }
        $allteam_by_array = array_map('strtolower', $allteam_by_array);


        $team_sql = $wpdb->get_results("SELECT " . $jointeamtable . ".leagueid, " . $jointeamtable . ".roundid,   CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchtable . ".team2
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchtable . ".team1
        ELSE ''
        END AS teamname 
        FROM " . $jointeamtable . " LEFT JOIN " . $matchtable . " on " . $matchtable . ".id = " . $jointeamtable . ".matchid 
        WHERE " . $jointeamtable . ".userid = $userid 
        ");

        $result2_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname," . $leaguetable . ".name as leaguename ," . $jointeamtable . ".roundselect as roundselect,           
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
        WHERE " . $matchtable . ".round = " . $matchId . "  and MSTATUS = 'active' group by id ");

        $scoremultiplier = $result2_sql[0]->scoremultiplier;
        $scoretype = $result2_sql[0]->scoretype;
        $round = $result2_sql[0]->round;
        $roundname = $result2_sql[0]->roundname;
        $leaguename = $result2_sql[0]->leaguename;
        $sportname = $result2_sql[0]->sportname;

        $type = ucfirst($scoretype);

        if (count($result2_sql) > 0) {
            $teamselect_string = '';

            foreach ($result2_sql as $team) {
                $team1 = strtoupper($team->team1name);
                $team2 = strtoupper($team->team2name);

                $teamselect_string .= '<div class="block2 col-md-3 ">';
                /*START*/ //////////////////
                if ($team->scoremultiplier == 0 && $team->scoretype == 'added') {
                    $teamselect_string .= '<center><div class="block bg-hover-grass pointer " onclick="select_team(' . $team->t1id . ',' . $team->id . ',' . $round . ')"><a class=" pointer " style="color: #ffcc00;"  data-dateteam="' . $team->enddate . '" id="matchteam-' . $team->id . '" >';
                    // echo '<pre>';
                    // print_r($team->selectteamid);

                    if (
                        $team->selectteamid != '' && $team->selectteamid == 1
                    ) {
                        $teamselect_string .= '<b>' . $team1 . '</b> SELECTED';
                    } else {
                        $teamselect_string .= '<b>' . $team1 . '</b>';
                    }
                    $teamselect_string .= '</a>';
                }
                /*END*/ //////////////////
                $teamselect_string .= '</div>
                <span><center><img alt="" src="' . plugins_url('sports/images/5.png') . '"><center></span>';
                /*START*/ //////////////////
                if ($team->scoremultiplier == 0 && $team->scoretype == 'added') {
                    $teamselect_string .= '<center><div class="block bg-hover-grass pointer" onclick="select_team(' . $team->t2id . ',' . $team->id . ',' . $round . ')" ><a class="pointer" style="color: #ffcc00;" data-dateteam="' . $team->enddate . '" id="matchteam-' . $team->id . '">';
                    if (
                        $team->selectteamid != '' && $team->selectteamid == 0
                    ) {
                        $teamselect_string .= '<b>' . $team2 . '</b> SELECTED';
                    } else {
                        $teamselect_string .= '<b>' . $team2 . '</b>';
                    }
                    $teamselect_string .= '</a>';
                }
                /*END*/ //////////////////
                $teamselect_string .= '</div>
            </div>
            ';
            }
        } else {
            // $teamselect_string .= ''; 
        }


        ///////////////////////////////////////////////////////


        $validate_sql = $wpdb->get_results("SELECT * FROM $roundtable WHERE " . $roundtable . ".scoremultiplier ='1' and " . $roundtable . ".scoretype = 'added'");
        if (count($result_sql) > 0) {



            $match_string .= '
            <span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -4%;  float : left; font-family: Oswald; "><b>Go Back</b></a></span>
            <div class="row">
            <div class="score112 kode-bg-color">
					<span class="kode-halfbg thbg-color" style="border-radius: 0px 8px 8px 0px;"></span>
						<center>
							<div class="col-md-6">
                            <span class="text23">Score Type : ' . $type . '</span>
							</div>
							<div class="col-md-6">';
            if ($scoremultiplier == 0 && $scoretype == 'added') {
                $singinlink = home_url('login/');
                if (is_user_logged_in()) {
                    $match_string .= '<span class="text23">Super Scorer Round</span>
            </div>
						</center>				
				</div>
                </div>
                <span><a onclick="load_select_team_model(' . $round . ')" class="title btn" style="float: right; background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -49px; margin-left: 124px;  float : left;  font-family: Oswald; "><b>Select Team</b></a></span><br><br><br>';
                } else {
                    $match_string .= '<span class="text23">Super Scorer Round</span>
                </div>
                            </center>				
                    </div>
                    </div>
                    
                    <span><a href="' . $singinlink . '" class="title btn" style="float: right; background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -49px; margin-left: 124px;  float : left; font-family: Oswald; "><b>Login To SeLect Team</b></a></span><br><br><br>';
                }
            } else {
                $match_string .= '<span class="text23">Score Multiplier : ' . $scoremultiplier . '</span>
            </div>
						</center>				
				</div>
                </div><br><br><br>';
            }

            $match_string .= '
<div class="score113 kode-bg-color">
        <center>

        <span class="kode-subtitle col-sm-4" style="border-radius: 15px 0px 0px 15px; background-color: #195d10; padding: 3px !important;"><span class="text113">sport</span><h3 class="text114">'. $sportname .'</h3></span>
        <span class="kode-subtitle col-sm-4" style="background-color: #003e00; padding: 3px !important;"><span class="text113">League</span><h3 class="text114">'. $leaguename .'</h3></span>
        <span class="kode-subtitle col-sm-4" style="border-radius: 0px 15px 15px 0px; background-color: #0a2506; padding: 3px !important;"><span class="text113">Round</span><h3 class="text114">'. $roundname .'</h3></span>

        </center>				
</div><br><br><br>';



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
                    $match_string .= '<span><h3 class="title" style="float:right; color: #ffc107; margin-top:-50px; font-family: Oswald; "><b>Joker Round</b></h3></span>';
                }
                $match_string .= '<div class="col-md-6">
                                          <span><span class="text2">Team 1</span><h3 class="title"><b>' . $match->team1name . '</b></h3></span>';
                if (is_user_logged_in()) {
                    $match_string .= '<a class="read-more pointer match-' . $match->id . ' team_' . $match->t1id . '_' . $match->id . ' teamname_' . $teamname1 . '"  data-teamname1="' . $match->team1 . '" data-date="' . $match->enddate . '" id="match-' . $match->id . '" data-scoretype="' . $match->scoretype . '" onclick="join_team(' . $match->t1id . ',' . $match->id . ',' . $match->leagueid . ',' . $match->round . ',' . $match->scoremultiplier . ',' . $userid . ',' . $teamname1 . ')">';

                    $containsAllValues = !array_diff($allteam_by_array, $allteam);
                    if ($containsAllValues == 1 && $containsAllValues != '') {

                        if ($match->teamid != '' && $match->teamid == 1) {
                            $match_string .= 'SELECTED';
                        } else {
                            $match_string .= 'SELECT';
                        }


                        // $match_string .= 'SELECT';
                    } else {

                        if (in_array($teamname1, $allteam)) {
                            $match_string .= 'PREVIOUSLY SELECTED';
                        } else {
                            if ($match->teamid != '' && $match->teamid == 1) {
                                $match_string .= 'SELECTED';
                            } else {
                                $match_string .= 'SELECT';
                            }
                        }
                    }


                    $match_string .= '</a>';
                } else {
                    $singinlink = home_url('login/');
                    $match_string .= '<a  href="' . $singinlink . '" class="read-more pointer" title="Join Team" data-toggle="tooltip">SELECT</a>';
                }

                $match_string .= '</div>
                                  <div class="col-md-6">
                                  <span><span class="text2">Team 2</span><h3 class="title"><b>' . $match->team2name . '</b></h3></span>';
                if (is_user_logged_in()) {
                    $match_string .= '<a class="read-more pointer match-' . $match->id . ' team_' . $match->t2id . '_' . $match->id . ' teamname_' . $teamname2 . '" data-teamname2="' . $match->team2 . '" data-date="' . $match->enddate . '" id="match-' . $match->id . '" data-scoretype="' . $match->scoretype . '" onclick="join_team(' . $match->t2id . ',' . $match->id . ',' . $match->leagueid . ',' . $match->round . ',' . $match->scoremultiplier . ',' . $userid . ',' . $teamname2 . ')">';

                    $containsAllValues = !array_diff($allteam_by_array, $allteam);
                    if ($containsAllValues == 1 && $containsAllValues != '') {

                        if (
                            $match->teamid != '' && $match->teamid == 0
                        ) {
                            $match_string .= 'SELECTED';
                        } else {
                            $match_string .= 'SELECT';
                        }

                        // $match_string .= 'SELECT';
                    } else {

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
                    }
                    $match_string .= '</a>';
                } else {
                    $singinlink = home_url('login/');
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
            <span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -4%;  float : left; font-family: Oswald; "><b>Go Back</b></a></span></br></br>
            <div class="card-body col-sm-4">
            <h1 class="card-title"> No Matches Found !</h1>
            </div>';
        }

        /////////////////////////////////


        if ($result_sql > 0) {
            $result['status'] = 1;
            $result['match_string'] = $match_string;
            $result['teamselect_string'] = $teamselect_string;
            $result['teamData'] = $team_sql;
            $result['roundSelectData'] = $roundselect_sql;
            $result['validateData'] = $validate_sql;
            $result['teamname_by_round_Data'] = $teamname_by_round_sql;
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
        $teamnameid = $_POST['teamnameid'];
        $auto = "";
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
                'teamnameid'         => $teamnameid,
                'auto'               => $auto,

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
                    'teamnameid'         => $teamnameid,
                    'auto'               => $auto,


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

    function send_mail_users_score()
    {

        global $wpdb;

        $mainresult['status'] = 0;
        $roundid = $_POST['roundid'];
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchscoretable = $wpdb->prefix . "score";
        $roundtable = $wpdb->prefix . "round";
        $teamtable = $wpdb->prefix . "team";
        $selectteam = $wpdb->prefix . "selectteam";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";
        $scorepredictortable = $wpdb->prefix . "scorepredictor";
        $matchtable = $wpdb->prefix . "match";


        $attime = date("Y-m-d", strtotime('-1 day')); //current_time('Y-m-d H:i:s');

        $result_sql = "SELECT
        " . $jointeamtable . ".*,
        " . $leaguetable . ".name AS leaguename,
        " . $usertable . ".display_name AS username,
        " . $usertable . ".user_email AS useremail,
        " . $roundtable . ".scoremultiplier AS scoremultiplier,
        " . $roundtable . ".rname AS roundname,
        " . $roundtable . ".scoretype AS scoretype,
        CASE WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score 
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score ELSE ''
        END AS teamscore,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN t.teamname
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $teamtable . ".teamname
        ELSE ''
        END AS teamname,
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
        LEFT JOIN " . $matchtable . " ON " . $matchtable . ".id = " . $jointeamtable . ".matchid
        LEFT JOIN " . $scorepredictortable . " on " . $scorepredictortable . ".matchid = " . $jointeamtable . ".matchid 
        LEFT JOIN " . $roundtable . " ON " . $roundtable . ".id = " . $jointeamtable . ".roundid
        LEFT JOIN " . $teamtable . " on " . $teamtable . ".id = " . $matchtable . ".team1
        LEFT JOIN " . $teamtable . " as t on t.id = " . $matchtable . ".team2
        WHERE
            " . $jointeamtable . ".roundid =$roundid AND  date(" . $matchtable . ".enddate) <= '$attime' ";
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

        $mainresult = $wpdb->get_results($result_sql);

        foreach ($mainresult as $match) {
            //   send mail
            $subject = "Earn Points Now";
            $message = '<p>';
            $message .= 'Dear <b>' . $match->username . ',</b>';
            $message .= '<h3>You Select <h3><b><h2>' . $match->teamname . '</h2></b> In <b><h2>' . $match->roundname . '</h2></b>';
            $message .= '<h3>Your Score In This Round Is <b><h2>' . $scoreByUserId[$match->userid] . '</h2></b>';
            $message .= 'Thanks From <i>Kick Off</i>';
            $message .= '</p>';
            $headers =  array('Content-Type: text/html; charset=UTF-8', 'From: KICKOFF Sports <nikultaka@palladiumhub.com>', 'Reply-To: ');

            $mailData =  wp_mail($match->useremail, $subject, $message, $headers);
            //  end of send mail     
        }


        $mainresult['status'] = 1;
        echo json_encode($mainresult);
        exit();
    }
}


add_action('members_score_cron', 'send_mail_users_score');

// put this line inside a function, 
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit
// wp_schedule_single_event(time() + 86400, 'members_score_cron');




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

add_action('wp_ajax_match_list_Controller::send_mail_users_score', array($match_list_Controller, 'send_mail_users_score'));
add_action('wp_ajax_nopriv_match_list_Controller::send_mail_users_score', array($match_list_Controller, 'send_mail_users_score'));

add_shortcode('match_list_short_code', array($match_list_Controller, 'match_list_short_code'));
