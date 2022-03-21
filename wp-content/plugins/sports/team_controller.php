<?php


class team_controller
{
    function insert_team_data()
    {
        global $wpdb;
        $updateId = $_POST['tid'];

        $data['status'] = 0;
        $data['msg'] = "Error Data Not insert";
        $sportid = $_POST['sportid'];
        $teamname = $_POST['teamname'];
        $tstatus = $_POST['tstatus'];
        $teamtable = $wpdb->prefix . "team";

        if ($updateId == '') {
            $wpdb->insert($teamtable, array(
                'sportid'      => $sportid,
                'teamname'     => $teamname,
                'tstatus'      => $tstatus,
            ));
            $data['status'] = 1;
            $data['msg'] = "Team inserted successfully";
        } else {
            $wpdb->update(
                $teamtable,
                array(
               'sportid'      => $sportid,
               'teamname'     => $teamname,
               'tstatus'      => $tstatus,
                ),
                array('id'  => $updateId)
            );
            $data['status'] = 1;
            $data['msg'] = "Team Updated successfully";
        }
        echo  json_encode($data);
        exit;
    }

    function loaddata_team_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $sportstable = $wpdb->prefix . "sports";
        $teamtable = $wpdb->prefix . "team";
        $result_sql = "SELECT * FROM " . $sportstable . " as a";
        $result_sql = "SELECT " . $teamtable . ".*," . $sportstable . ".name as sport_name FROM " . $teamtable;
        $result_sql .= " LEFT JOIN " . $sportstable . " on " . $sportstable . ".id = " . $teamtable . ".sportid";
       
        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= "AND (sport_name LIKE '%" . $search . "%')
                                OR (teamname LIKE '%" . $search . "%')
                                OR (tstatus LIKE '%" . $search . "%')";
        }
        $columns = array(
            0 => 'sport_name',
            1 => 'teamname',
            2 => 'tstatus',
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
            $temp['sportid'] = $row->sport_name;
            $temp['teamname'] = $row->teamname;
            $temp['tstatus'] = strtoupper($row->tstatus);
            $action = "<button  class='btn btn-success'  onclick='teamrecord_edit(" . $row->id . ")'><i class='fa fa-pencil-square' aria-hidden='true'> Edit</i></button>
                       <button  class='btn btn-danger' onclick='teamrecord_delete(" . $row->id . ")'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
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

    function delete_team_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $teamtable = $wpdb->prefix . "team";
        $result['status'] = 0;

        $delete_sql = $wpdb->delete($teamtable, array('id' => $deleteId));
        if ($delete_sql) {
            $result['status'] = 1;
        }
        echo json_encode($result);
        exit();
    }

    function edit_team_record()
    {
        global $wpdb;
        $editId = $_POST['id'];
        $result['status'] = 0;
        $teamtable = $wpdb->prefix . "team";

        $edit_sql = $wpdb->get_results("SELECT * FROM $teamtable WHERE id = '$editId' ");
        if ($edit_sql > 0) {
            $result['status'] = 1;
            $result['recoed'] = $edit_sql[0];
        }
        echo json_encode($result);
        exit();
    }
}

$team_controller = new team_controller();
add_action('wp_ajax_team_controller::insert_team_data', array($team_controller, 'insert_team_data'));
add_action('wp_ajax_team_controller::loaddata_team_Datatable', array($team_controller, 'loaddata_team_Datatable'));
add_action('wp_ajax_team_controller::delete_team_record', array($team_controller, 'delete_team_record'));
add_action('wp_ajax_team_controller::edit_team_record', array($team_controller, 'edit_team_record'));
