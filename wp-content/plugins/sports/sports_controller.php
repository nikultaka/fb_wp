<?php
add_action('admin_menu', 'sports_admin_menu');

function sports_admin_menu()
{
    add_menu_page(
        'Sports', // page title
        'Sports', // menu title
        'manage_options', // capability
        'sports', // menu slug
        'sports', // callback function
        'dashicons-games'
    );
    add_submenu_page(
        'sports', // parent slug 
        'League', // page title
        'League', // menu title 
        'manage_options', // capability
        'league', // slug
        'league' // callback 
    );
}

function sports()
{
    ob_start();
    wp_enqueue_script('script', plugins_url('/Script/sports_script.js', __FILE__));
    include(dirname(__FILE__) . "/html/sportsform.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}

function league()
{
    ob_start();
    global $wpdb;
    $sportstable = $wpdb->prefix . "sports";
    $query = "SELECT * FROM " . $sportstable . " WHERE STATUS = 'active'";
    $pagessql = $wpdb->get_results($query);

    $roundtable = $wpdb->prefix . "round";
    $leagueid = $_GET['id'];
    $querym = "SELECT * FROM " . $roundtable . " WHERE leagueid=" . $leagueid . "  RSTATUS = 'active'";
    $roundsql = $wpdb->get_results($querym);


    wp_enqueue_script('script', plugins_url('/Script/league_script.js', __FILE__));
    include(dirname(__FILE__) . "/html/leagueform.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}


/**********************************************************************************************************************************/


class sports_controller
{
    function insert_data()
    {
        global $wpdb;
        $updateId = $_POST['hid'];

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";
        $name = $_POST['name'];
        $status = $_POST['status'];
        $sportstable = $wpdb->prefix . "sports";

        if ($updateId == '') {
            $wpdb->insert($sportstable, array(
                'name'     => $name,
                'status'   => $status,
            ));
            $data['status'] = 1;
            $data['msg'] = "Sports inserted successfully";
        } else {
            $wpdb->update(
                $sportstable,
                array(
                    'name'     => $name,
                    'status'     => $status
                ),
                array('id'  => $updateId)
            );
            $data['status'] = 1;
            $data['msg'] = "Sports Updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function loaddata_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $sportstable = $wpdb->prefix . "sports";
        $result_sql = "SELECT a.* FROM " . $sportstable . " as a";
        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (a.name LIKE '%" . $search . "%')
                                OR (a.status LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'a.id',
            1 => 'a.name',
            2 => 'a.status',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY a.id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $temp['id'] = $row->id;
            $temp['name'] = $row->name;
            $temp['status'] = strtoupper($row->status);
            $action = "<button  class='btn btn-success'  onclick='record_edit(" . $row->id . ")'><i class='fa fa-pencil-square' aria-hidden='true'> Edit</i></button>
                       <button  class='btn btn-danger' onclick='record_delete(" . $row->id . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
            $temp['action'] = $action;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);
    }

    function delete_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $sportstable = $wpdb->prefix . "sports";
        $result['status'] = 0;

        $delete_sql = $wpdb->delete($sportstable, array('id' => $deleteId));
        if ($delete_sql) {
            $result['status'] = 1;
        }
        echo json_encode($result);
        exit();
    }

    function edit_record()
    {
        global $wpdb;
        $editId = $_POST['id'];
        $result['status'] = 0;
        $sportstable = $wpdb->prefix . "sports";

        $edit_sql = $wpdb->get_results("SELECT * FROM $sportstable WHERE id = '$editId' ");
        if ($edit_sql > 0) {
            $result['status'] = 1;
            $result['recoed'] = $edit_sql[0];
        }
        echo json_encode($result);
        exit();
    }
}

$sports_controller = new sports_controller();
add_action('wp_ajax_sports_controller::insert_data', array($sports_controller, 'insert_data'));
add_action('wp_ajax_sports_controller::loaddata_Datatable', array($sports_controller, 'loaddata_Datatable'));
add_action('wp_ajax_sports_controller::delete_record', array($sports_controller, 'delete_record'));
add_action('wp_ajax_sports_controller::edit_record', array($sports_controller, 'edit_record'));


/**********************************************************************************************************************************/


class league_controller
{

    function leagueinsert_data()
    {

        global $wpdb;
        $updateId = $_POST['hlid'];
        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";

        $sports = $_POST['sports'];
        $name = $_POST['name'];
        $status = $_POST['status'];
        $leaguetable = $wpdb->prefix . "league";

        if ($updateId == '') {
            $wpdb->insert($leaguetable, array(
                'sports'         => $sports,
                'name'           => $name,
                'status'         => $status,

            ));
            $data['status'] = 1;
            $data['msg'] = "League added successfully";
        } else {
            $wpdb->update(
                $leaguetable,
                array(
                    'sports'     => $sports,
                    'name'       => $name,
                    'status'     => $status
                ),
                array('id'  => $updateId)
            );
            $data['status'] = 1;
            $data['msg'] = "League updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function loadleague_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $sportstable = $wpdb->prefix . "sports";
        $leaguetable = $wpdb->prefix . "league";
        $result_sql = "SELECT " . $leaguetable . ".*," . $sportstable . ".name as sport_name FROM " . $leaguetable;
        $result_sql .= " LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $leaguetable . ".sports";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (sport_name LIKE '%" . $search . "%')
                                OR (name LIKE '%" . $search . "%')
                                OR (status LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'id',
            1 => 'sport_name',
            2 => 'name',
            3 => 'status',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $temp['id'] = $row->id;
            $temp['sports'] = $row->sport_name;
            $temp['name'] = $row->name;
            $temp['round'] = strtoupper($row->round);
            $temp['status'] = strtoupper($row->status);
            $action = "<button  class='btn btn-sm btn-success'  onclick='leaguerecord_edit(" . $row->id . ")'><i class='fa fa-edit' aria-hidden='true'> Edit</i></button>
                       <button  class='btn btn-sm btn-danger' onclick='leaguerecord_delete(" . $row->id . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
            $action .=  " <button  class='btn btn-sm btn-secondary' id='leaguerounds' onclick='leagueround(" . $row->id . ")'><i class='fa fa-flag-checkered' aria-hidden='true'></i> Rounds</button>";
            $action .=  " <button  class='btn btn-sm btn-primary leaguematchClass' id='leaguematch' onclick='leaguematch(" . $row->id . ")'><i class='fa fa-futbol-o' aria-hidden='true'></i> Matches</button>";
            $action .=  " <button  class='btn btn-sm btn-warning text-grey' id='leagueleaderboard' onclick='leagueleaderboard(" . $row->id . ")'><i class='fa fa-group' aria-hidden='true'></i> LeaderBoard</button>";
            $action .=  " <button  class='btn btn-sm btn-info text-white' id='loadadditionalpoints' onclick='loadadditionalpoints(" . $row->id . ")'><i class='fa fa-plus-circle' aria-hidden='true'></i>  Additional Points</button>";


            $temp['action'] = $action;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);
    }

    function deleteleague_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $leaguetable = $wpdb->prefix . "league";

        $result['status'] = 0;

        $delete_sql = $wpdb->delete($leaguetable, array('id' => $deleteId));
        $this->delete_all_data($deleteId);
        if ($delete_sql) {
            $result['status'] = 1;
        }
        echo json_encode($result);
        exit();
    }
    function delete_all_data($leagueid)
    {
        global $wpdb;
        $roundtable = $wpdb->prefix . "round";
        $wpdb->delete($roundtable, array('leagueid' => $leagueid));

        $matchtable = $wpdb->prefix . "match";
        $wpdb->delete($matchtable, array('leagueid' => $leagueid));

        $scoretable = $wpdb->prefix . "score";
        $wpdb->delete($scoretable, array('leagueid' => $leagueid));

        $jointeamtable = $wpdb->prefix . "jointeam";
        $wpdb->delete($jointeamtable, array('leagueid' => $leagueid));
        return true;
    }


    function editleague_record()
    {
        global $wpdb;
        $editId = $_POST['id'];

        $result['status'] = 0;
        $leaguetable = $wpdb->prefix . "league";

        $edit_sql = $wpdb->get_results("SELECT * FROM $leaguetable WHERE id = '$editId' ");
        if ($edit_sql > 0) {
            $result['status'] = 1;
            $result['recoed'] = $edit_sql[0];
        }
        echo json_encode($result);
        exit();
    }

    /***********  round  ****************************************************************************************************/


    function roundinsert_data()
    {

        global $wpdb;
        $updateId = $_POST['hrid'];

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";

        $rname = $_POST['rname'];
        $scoremultiplier = $_POST['scoremultiplier'];
        $scoretype = $_POST['scoretype'];
        $rstatus = $_POST['rstatus'];
        $hdnleagueid = $_POST['hdnleagueid'];
        $roundtable = $wpdb->prefix . "round";

        if ($updateId == '') {
            $wpdb->insert($roundtable, array(
                'rname'             => $rname,
                'scoremultiplier'   => $scoremultiplier,
                'scoretype'         => $scoretype,
                'leagueid'          => $hdnleagueid,
                'rstatus'           => $rstatus,

            ));
            $data['status'] = 1;
            $data['msg'] = "Round inserted successfully";
        } else {
            $wpdb->update(
                $roundtable,
                array(
                    'rname'             => $rname,
                    'scoremultiplier'   => $scoremultiplier,
                    'scoretype'         => $scoretype,
                    'leagueid'          => $hdnleagueid,
                    'rstatus'           => $rstatus,
                ),
                array('id'  => $updateId)
            );

            $data['status'] = 1;
            $data['msg'] = "Round updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function loadround_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $hdnleagueid = $_POST['hdnleagueid'];
        $roundtable = $wpdb->prefix . "round";
        $result_sql = "SELECT * FROM " . $roundtable . " WHERE leagueid = " . $hdnleagueid . "";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (rname LIKE '%" . $search . "%')
                                OR (scoremultiplier LIKE '%" . $search . "%')
                                OR (scoretype LIKE '%" . $search . "%')
                                OR (rstatus LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'id',
            1 => 'rname',
            2 => 'scoremultiplier',
            3 => 'scoretype',
            4 => 'rstatus',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY a.id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $temp['id'] = $row->id;
            $temp['rname'] = $row->rname;
            $temp['scoremultiplier'] = $row->scoremultiplier;
            $temp['scoretype'] = strtoupper($row->scoretype);
            $temp['rstatus'] = strtoupper($row->rstatus);
            $action = "<button  class='btn btn-sm btn-success'  onclick='editround_record(" . $row->id . ")'><i class='fa fa-pencil-square' aria-hidden='true'> Edit</i></button>
                       <button  class='btn btn-sm btn-danger' onclick='deleteround_record(" . $row->id . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
            $temp['action'] = $action;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);
    }

    function deleteround_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $roundtable = $wpdb->prefix . "round";
        $result['status'] = 0;

        $delete_sql = $wpdb->delete($roundtable, array('id' => $deleteId));
        if ($delete_sql) {
            $result['status'] = 1;
        }
        echo json_encode($result);
        exit();
    }


    function editround_record()
    {
        global $wpdb;
        $editId = $_POST['id'];
        $result['status'] = 0;
        $roundtable = $wpdb->prefix . "round";

        $edit_sql = $wpdb->get_results("SELECT * FROM $roundtable WHERE id = '$editId' ");
        if ($edit_sql > 0) {
            $result['status'] = 1;
            $result['recoed'] = $edit_sql[0];
        }
        echo json_encode($result);
        exit();
    }

    /***********  round  ****************************************************************************************************/


    /***********  match  ****************************************************************************************************/

    function matchinsert_data()
    {

        global $wpdb;
        $updateId = $_POST['hmid'];


        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";

        $round = $_POST['round'];
        $team1 = $_POST['team1'];
        $team2 = $_POST['team2'];
        $enddate = $_POST['enddate'];
        $mstatus = $_POST['mstatus'];
        $hdnleagueid = $_POST['hmhdnleagueid'];

        $matchtable = $wpdb->prefix . "match";

        if ($updateId == '') {
            $wpdb->insert($matchtable, array(
                'round'             => $round,
                'team1'             => $team1,
                'team2'             => $team2,
                'leagueid'          => $hdnleagueid,
                'enddate'           => $enddate,
                'mstatus'           => $mstatus,
            ));
            $data['status'] = 1;
            $data['msg'] = "Match added successfully";
        } else {
            $wpdb->update(
                $matchtable,
                array(
                    'round'             => $round,
                    'team1'             => $team1,
                    'team2'             => $team2,
                    'leagueid'          => $hdnleagueid,
                    'enddate'           => $enddate,
                    'mstatus'           => $mstatus,
                ),
                array('id'  => $updateId)
            );

            $data['status'] = 1;
            $data['msg'] = "Match updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function loadmatch_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $hdnleagueid = $_POST['hmhdnleagueid'];
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";
        $result_sql = "SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname FROM " . $matchtable;
        $result_sql .= " LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round WHERE " . $matchtable . ".leagueid = " . $hdnleagueid . "";

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (roundname LIKE '%" . $search . "%')
                                OR (team1 LIKE '%" . $search . "%')
                                OR (team2 LIKE '%" . $search . "%')
                                OR (enddate LIKE '%" . $search . "%')
                                OR (mstatus LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'id',
            1 => 'roundname',
            2 => 'team1',
            3 => 'team2',
            4 => 'enddate',
            5 => 'mstatus',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY a.id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {

            $temp['id'] = $row->id;
            $temp['round'] = $row->roundname;
            $temp['team1'] = $row->team1;
            $temp['team2'] = $row->team2;
            $temp['enddate'] = $row->enddate;
            $temp['mstatus'] = strtoupper($row->mstatus);
            $action = "<button  class='btn btn-sm btn-success'  onclick='editmatch_record(" . $row->id . ")'><i class='fa fa-pencil-square' aria-hidden='true'> Edit</i></button>
                       <button  class='btn btn-sm btn-danger' onclick='deletematch_record(" . $row->id . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
            $action .=  " <button  class='btn btn-sm btn-primary' id='loadmatchscoretable' onclick='loadmatchscoretable(" . $row->id . ")'><i class='fa fa-bar-chart' aria-hidden='true'></i> Add Result</button>";

            $temp['action'] = $action;
            $data[] = $temp;
            $id = "";
        }

        $resultRound = "SELECT * FROM " . $roundtable . " where leagueid = " . $hdnleagueid;
        $roundData = $wpdb->get_results($resultRound, "OBJECT");
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql,
            "round" => $roundData
        );

        // $roundtable = $wpdb->prefix . "round";
        // $leagueid = $_GET['id'];
        // $querym = "SELECT * FROM " . $roundtable . " WHERE leagueid=".$hdnleagueid."  RSTATUS = 'active'";
        // $roundsql = $wpdb->get_results($querym);

        echo json_encode($json_data);
        exit(0);
    }

    function deletematch_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $matchtable = $wpdb->prefix . "match";
        $result['status'] = 0;

        $delete_sql = $wpdb->delete($matchtable, array('id' => $deleteId));
        if ($delete_sql) {
            $result['status'] = 1;
        }
        echo json_encode($result);
        exit();
    }


    function editmatch_record()
    {
        global $wpdb;
        $editId = $_POST['id'];
        $result['status'] = 0;
        $matchtable = $wpdb->prefix . "match";
        $roundtable = $wpdb->prefix . "round";

        // $edit_sql = $wpdb->get_results("SELECT * FROM $matchtable WHERE id = '$editId' ");
        $edit_sql = $wpdb->get_results("SELECT " . $matchtable . ".*," . $roundtable . ".rname as roundname FROM " . $matchtable . " LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $matchtable . ".round WHERE " . $matchtable . ".id = '$editId' ");

        if ($edit_sql > 0) {
            $result['status'] = 1;
            $result['recoed'] = $edit_sql[0];
        }
        echo json_encode($result);
        exit();
    }




    /***********  match  ****************************************************************************************************/

    /***********  matchscore  ****************************************************************************************************/

    function matchscoreinsert_data()
    {

        global $wpdb;
        $updateId = $_POST['hmsid'];

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";

        $team1score = $_POST['team1score'];
        $team2score = $_POST['team2score'];
        $hdnmatchid = $_POST['hdnmatchid'];

        $matchscoretable = $wpdb->prefix . "score";

        if ($updateId == '') {
            $wpdb->insert($matchscoretable, array(
                'team1score'             => $team1score,
                'team2score'             => $team2score,
                'matchid'                => $hdnmatchid,
            ));

            $data['status'] = 1;
            $data['msg'] = "Match Score added successfully";
        } else {
            $wpdb->update(
                $matchscoretable,
                array(
                    'team1score'             => $team1score,
                    'team2score'             => $team2score,
                    'matchid'                => $hdnmatchid,
                ),
                array('id'  => $updateId)
            );

            $data['status'] = 1;
            $data['msg'] = "Match Score updated successfully";
        }

        echo  json_encode($data);
        exit;
    }

    function loadmatchscore_Datatable()
    {
        global $wpdb;
        $matchid = $_POST['matchid'];
        $matchtable = $wpdb->prefix . "match";
        $matchscoretable = $wpdb->prefix . "score";
        //  $result_sql = $wpdb->get_results("SELECT * FROM " . $matchscoretable . " WHERE matchid = ".$matchid."");
        $result_sql = $wpdb->get_results("SELECT " . $matchscoretable . ".*," . $matchtable . ".team1 as teamname1 ," . $matchtable . ".team2 as teamname2 
        FROM " . $matchtable . " 
        LEFT JOIN " . $matchscoretable . " on " . $matchtable . ".id = " . $matchscoretable . ".matchid 
        WHERE " . $matchtable . ".id = " . $matchid . "");

        $result['status'] = 1;
        $result['recoed'] = $result_sql[0];
        echo json_encode($result);
        exit();
    }

    // function deletematchscore_record()
    // {
    //     global $wpdb;
    //     $deleteId = $_POST['id'];
    //     $matchscoretable = $wpdb->prefix . "score";
    //     $result['status'] = 0;

    //     $delete_sql = $wpdb->delete($matchscoretable, array('id' => $deleteId));
    //     if ($delete_sql) {
    //         $result['status'] = 1;
    //     }
    //     echo json_encode($result);
    //     exit();
    // }


    /***********  matchscore  ****************************************************************************************************/

    /***********  leaderboard  ****************************************************************************************************/

    function loadleaderboard_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $lbhdnleagueid = $_POST['lbhdnleagueid'];

        $data = array();
        $leaderboard = $wpdb->prefix . "leaderboard";
        $leaguetable = $wpdb->prefix . "league";
        $usertable = $wpdb->prefix . "users";
        $jointeamtable = $wpdb->prefix . "jointeam";
        $matchscoretable = $wpdb->prefix . "score";
        $roundtable = $wpdb->prefix . "round";
        $additionalpointstable = $wpdb->prefix . "additionalpoints";


        $result_sql = "SELECT " . $jointeamtable . ".*," . $leaguetable . ".name as leaguename," . $usertable . ".display_name as username,
        " . $roundtable . ".scoremultiplier as scoremultiplier," . $roundtable . ".scoretype as scoretype,
        CASE
        WHEN " . $jointeamtable . ".teamid = 0 THEN " . $matchscoretable . ".team2score
        WHEN " . $jointeamtable . ".teamid = 1 THEN " . $matchscoretable . ".team1score
        ELSE ''
        END AS teamscore,
        CASE WHEN " . $jointeamtable . ".roundselect = 'nothanks' THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team2score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'subtracted' THEN -(" . $matchscoretable . ".team1score * " . $roundtable . ".scoremultiplier)
        END                                            
        ELSE
        CASE WHEN " . $jointeamtable . ".roundselect = 'scorePredictorround' THEN 
        CASE 
            WHEN " . $jointeamtable . ".teamid = 0 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team2score * " . $additionalpointstable . ".predictorscoremultiplier) 
            WHEN " . $jointeamtable . ".teamid = 1 AND " . $roundtable . ".scoretype = 'added' THEN +(" . $matchscoretable . ".team1score * " . $additionalpointstable . ".predictorscoremultiplier)
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
        FROM " . $jointeamtable . " 
        LEFT JOIN " . $leaguetable . " on " . $leaguetable . ".id = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $usertable . " on " . $usertable . ".id = " . $jointeamtable . ".userid 
        LEFT JOIN " . $matchscoretable . " on " . $matchscoretable . ".matchid = " . $jointeamtable . ".matchid
        LEFT JOIN " . $additionalpointstable . " ON " . $additionalpointstable . ".leagueid = " . $jointeamtable . ".leagueid
        LEFT JOIN " . $roundtable . " on " . $roundtable . ".id = " . $jointeamtable . ".roundid 
        WHERE " . $jointeamtable . ".leagueid = " . $lbhdnleagueid . " ";

        $totalScorebyleague = $wpdb->get_results($result_sql, OBJECT);
        $totalScore = 0;
        foreach ($totalScorebyleague as $row) {
            $temp['yourscore'] = $row->userscore;
                $totalScore += $row->userscore;
          
        }

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (id LIKE '%" . $search . "%')
                            OR (score LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'leaguename',
            1 => 'username',
            2 => 'score',
        );
        $result_sql .= " GROUP BY userid ";
        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= "ORDER BY id DESC";
        }
        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }
        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }
        $list_data = $wpdb->get_results($result_sql, "OBJECT");
 
        $arr_data = array();
        $arr_data = $result;

        foreach ($list_data as $row) {
            $temp['leaguename'] = $row->leaguename;
            $temp['username'] = $row->username;
            $temp['score'] = $totalScore;
            $data[] = $temp;
            $id = "";
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit(0);
    }


    /***********  leaderboard  ****************************************************************************************************/

     /***********  matchscore  ****************************************************************************************************/

     function additionalpointsinsert_data()
     {
         global $wpdb;
         $updateId = $_POST['hapid'];
 
         $data['status'] = 0;
         $data['msg'] = "Error Data Not insert";
 
         $jokerscoremultiplier = $_POST['jokerscoremultiplier'];
         $jokerscoretype = $_POST['jokerscoretype'];
         $predictorscoremultiplier = $_POST['predictorscoremultiplier'];
         $predictorscoretype = $_POST['predictorscoretype'];
         $hdnapid = $_POST['hdnapid'];
 
         $additionalpointstable = $wpdb->prefix . "additionalpoints";
 
         if ($updateId == '') {
             $wpdb->insert($additionalpointstable, array(
                 'jokerscoremultiplier'       => $jokerscoremultiplier,
                 'jokerscoretype'             => $jokerscoretype,
                 'predictorscoremultiplier'   => $predictorscoremultiplier,
                 'predictorscoretype'         => $predictorscoretype,
                 'leagueid'                   => $hdnapid,

             ));
 
             $data['status'] = 1;
             $data['msg'] = "Additional Points added successfully";
         } else {
             $wpdb->update(
                 $additionalpointstable,
                 array(
                    'jokerscoremultiplier'       => $jokerscoremultiplier,
                    'jokerscoretype'             => $jokerscoretype,
                    'predictorscoremultiplier'   => $predictorscoremultiplier,
                    'predictorscoretype'         => $predictorscoretype,
                    'leagueid'                   => $hdnapid,
                 ),
                 array('id'  => $updateId)
             );
 
             $data['status'] = 1;
             $data['msg'] = "Additional Points updated successfully";
         }
 
         echo  json_encode($data);
         exit;
     }
 
     function loadadditionalpoints_Datatable()
     {
         global $wpdb;
         $leagueid = $_POST['id'];
         $additionalpointstable = $wpdb->prefix . "additionalpoints";

         $result_sql = $wpdb->get_results("SELECT " . $additionalpointstable . ".* 
         FROM " . $additionalpointstable . " WHERE " . $additionalpointstable . ".leagueid = " . $leagueid . "  ");
      
         $result['status'] = 1;
         $result['recoed'] = $result_sql[0];
         echo json_encode($result);
         exit();
     }
 
    //  function deleteadditionalpoints_record()
    //  {
    //      global $wpdb;
    //      $deleteId = $_POST['id'];
    //      $additionalpointstable = $wpdb->prefix . "score";
    //      $result['status'] = 0;
 
    //      $delete_sql = $wpdb->delete($additionalpointstable, array('id' => $deleteId));
    //      if ($delete_sql) {
    //          $result['status'] = 1;
    //      }
    //      echo json_encode($result);
    //      exit();
    //  }
 
 
     /***********  additionalpoints  ****************************************************************************************************/
 
}

$league_controller = new league_controller();

//League
add_action('wp_ajax_league_controller::leagueinsert_data', array($league_controller, 'leagueinsert_data'));
add_action('wp_ajax_league_controller::loadleague_Datatable', array($league_controller, 'loadleague_Datatable'));
add_action('wp_ajax_league_controller::deleteleague_record', array($league_controller, 'deleteleague_record'));
add_action('wp_ajax_league_controller::editleague_record', array($league_controller, 'editleague_record'));

//Round
add_action('wp_ajax_league_controller::roundinsert_data', array($league_controller, 'roundinsert_data'));
add_action('wp_ajax_league_controller::loadround_Datatable', array($league_controller, 'loadround_Datatable'));
add_action('wp_ajax_league_controller::deleteround_record', array($league_controller, 'deleteround_record'));
add_action('wp_ajax_league_controller::editround_record', array($league_controller, 'editround_record'));

//Match
add_action('wp_ajax_league_controller::matchinsert_data', array($league_controller, 'matchinsert_data'));
add_action('wp_ajax_league_controller::loadmatch_Datatable', array($league_controller, 'loadmatch_Datatable'));
add_action('wp_ajax_league_controller::deletematch_record', array($league_controller, 'deletematch_record'));
add_action('wp_ajax_league_controller::editmatch_record', array($league_controller, 'editmatch_record'));

//MatchScore
add_action('wp_ajax_league_controller::matchscoreinsert_data', array($league_controller, 'matchscoreinsert_data'));
add_action('wp_ajax_league_controller::loadmatchscore_Datatable', array($league_controller, 'loadmatchscore_Datatable'));
// add_action('wp_ajax_league_controller::deletematchscore_record', array($league_controller, 'deletematchscore_record'));

//LeaderBoard
add_action('wp_ajax_league_controller::loadleaderboard_Datatable', array($league_controller, 'loadleaderboard_Datatable'));

//Additional Points
add_action('wp_ajax_league_controller::additionalpointsinsert_data', array($league_controller, 'additionalpointsinsert_data'));
add_action('wp_ajax_league_controller::loadadditionalpoints_Datatable', array($league_controller, 'loadadditionalpoints_Datatable'));
// add_action('wp_ajax_league_controller::deleteadditionalpoints_record', array($league_controller, 'deleteadditionalpoints_record'));

/**********************************************************************************************************************************/
