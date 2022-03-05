<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
<script src="moment.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    form .error {
        color: #ff0000;
    }

    .swal2-container {
        z-index: 99999999999999999999999999999999999;
    }

    .dataTables_filter {
        display: none;
    }
</style>

<!-- Button trigger modal -->
</br></br><button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#leagueModal">
    Add League
</button>



<!-- Modal -->
</br>
<div class="modal fade" id="leagueModal" tabindex="-1" role="dialog" aria-labelledby="leagueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add League</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="leagueformdata" id="leagueformdata">
                    <input type="hidden" name="action" value="league_controller::leagueinsert_data">
                    <input type="hidden" id="hlid" name="hlid">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="sports">Sports Name :</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="sports" name="sports" required>
                                <!-- <option value="" selected="">----Select Sport----</option> -->
                                <?php foreach ($pagessql as $sports) { ?>
                                    <option class="custom-select" value='<?php echo $sports->id ?>'><?php echo $sports->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="name">League Name :</label>
                        </div>
                        <div class="col-sm-7" style="max-width: 54%;">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="status">Status :</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select status.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                        <button type="submit" class="btn btn-primary" id="save_Btn" name="save_Btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="container-fluid mt-5">
    <table class="table" id="leaguedata-table">
        <thead>
            <!-- <th>ID</th> -->
            <th width="15%">Sport Name</th>
            <th>League Name</th>
            <th>Status</th>
            <th>Actions</th>
        </thead>
    </table>
</div>
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
</script>

<!------------------------------------------------------------------------------------>
<!-- round Modal -->
<div class="modal fade" id="roundModal" tabindex="-1" role="dialog" aria-labelledby="roundModalLabel" aria-hidden="true" style="z-index:999999999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Round</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="roundformdata" id="roundformdata">
                    <input type="hidden" name="action" value="league_controller::roundinsert_data">
                    <input type="hidden" id="hrid" name="hrid">
                    <input type="hidden" id="hdnleagueid" name="hdnleagueid">

                    <div class="row">

                        <div class="col-md-3">
                            <label for="rname">Round Name :</label>
                            <input type="text" class="form-control" id="rname" name="rname" required>
                        </div>

                        <div class="col-md-2">
                            <label for="scoremultiplier">Score Multiplier :</label>
                            <input type="number" class="form-control" id="scoremultiplier" name="scoremultiplier" min="0" required>
                        </div>

                        <!-- <div class="col"> -->
                        <div class="col-md-1.5">
                            <label for="scoretype">Score Type :</label>
                            <select class="form-control" id="scoretype" name="scoretype" required>
                                <option value="added">Added</option>
                                <option value="subtracted">Subtracted</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select Score Type.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="rstatus">Status :</label>
                            <select class="form-control" id="rstatus" name="rstatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select status.
                            </div>
                        </div>
                        <div class="col-md-1.5" style="margin-top: 35px;">
                            <input type="checkbox" id="iscomplete" name="iscomplete" value="YES" />
                            <label for="iscomplete">Is Completed ?</label>
                        </div>
                        <!-- </div> -->
                        <div class="col-md-2" style="margin-top: 3%;">
                            <button type="submit" class="btn btn-sm btn-primary" id="save_Btnround" name="save_Btnround">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="modal-body">
                    <div class="container-fluid mt-3">
                        <table class="table" style="width: 100%; color:#343a40;" id="rounddata-table">
                            <thead>
                                <!-- <th>ID</th> -->
                                <th width="25%">Round Name</th>
                                <th width="20%">Score Multiplier</th>
                                <th width="10%">Score Type</th>
                                <th width="10%">Status</th>
                                <th width="5%">Is Completed</th>
                                <th width="30%">Actions</th>
                            </thead>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- round Modal -->

<!------------------------------------------------------------------------------------>



<!-- match Modal -->
<div class="modal fade" id="matchmodal" tabindex="-1" role="dialog" aria-labelledby="matchmodalLabel" aria-hidden="true" style="z-index:99999999999 !important;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="overflow-y: auto; max-height: 95vh;">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="modal-title" class="modal-title">Add Match</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="matchformdata" id="matchformdata">
                    <input type="hidden" name="action" value="league_controller::matchinsert_data">
                    <input type="hidden" id="hmid" name="hmid">
                    <input type="hidden" id="hmhdnleagueid" name="hmhdnleagueid">
                    <div class="row">

                        <div class="col-md-3" id="roundNameDivId">
                            <label for="round"><b>Round</b></label>
                            <select class="form-control" id="round" name="round" required></select>
                        </div>
                        <div class="col-md-4">
                            <label for="name"><b>Team 1</b></label>
                            <select class="form-control" id="team1" name="team1" required></select>
                        </div>
                        <h4 style="margin-top: 3%;"><span><b> VS </b></span></h4>
                        <div class="col-md-4">
                            <label for="name"><b>Team 2</b></label>
                            <select class="form-control" id="team2" name="team2" data-rule-notequalTo="#team1" required></select>
                        </div>

                        <div class="col-md-4">
                            <label for="enddate"><b>Cut Off Time</b></label>
                            <input type="text" autocomplete="off" class="form-control date-time-picker" id="enddate" name="enddate" required>
                        </div>
                        <div class="col-md-3">
                            <label for="mstatus"><b>Status</b></label>
                            <select class="form-control" id="mstatus" name="mstatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select status.
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-md-5" style="margin-top: 3%;">
                            <button type="submit" class="btn btn-sm btn-primary" id="save_Btnmatch" name="save_Btnmatch"> Save </button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="modal-body">
                    <div class="container-fluid mt-3">
                        <table class="table" style="width: 100%; color:#343a40;" id="matchdata-table">
                            <thead>
                                <!-- <th>ID</th> -->
                                <th width="15%">Round Name</th>
                                <th width="15%">Team 1</th>
                                <th width="15%">Team 2</th>
                                <th width="15%">Cut Off Time</th>
                                <th width="5%">Status</th>
                                <th width="35%">Actions</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- match Modal -->

<!------------------------------------------------------------------------------------>



<!-- matchscore Modal -->
<div class="modal fade" id="matchscoremodal" tabindex="-1" role="dialog" aria-labelledby="matchscoremodalLabel" aria-hidden="true" style="z-index:99999999999; margin-left: -10px;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="modal-title" class="modal-title">Add Score</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="return false" method="POST" name="matchscoreformdata" id="matchscoreformdata">
                    <input type="hidden" name="action" value="league_controller::matchscoreinsert_data">
                    <input type="hidden" id="hmsid" name="hmsid">
                    <input type="hidden" id="hdnmatchid" name="hdnmatchid">
                    <div class="row">

                        <div class="col-md-4">
                            <label for="name"><b>
                                    <div id="teamname1"></div>
                                </b></label>
                            <input type="text" class="form-control" id="team1score" name="team1score" required>
                        </div>
                        <h4 style="margin-top: 3%;"><span><b>VS</b></span></h4>
                        <div class="col-md-4">
                            <label for="name"><b>
                                    <div id="teamname2"></div>
                                </b></label>
                            <input type="text" class="form-control" id="team2score" name="team2score" required>
                        </div>
                        <!-- </div> -->
                        <div class="col-md-3" style="margin-top: 3%;">
                            <button type="submit" class="btn btn-sm btn-primary" id="save_Btnmatchscore" name="save_Btnmatchscore">Save</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                        </div>
                    </div>
                    <br>
                </form>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- matchscore Modal -->

<!------------------------------------------------------------------------------------>



<!-- leaderboard Modal -->
<div class="modal fade" id="leaderboardModal" tabindex="-1" role="dialog" aria-labelledby="leaderboardModalLabel" aria-hidden="true" style="z-index:99999999999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="modal-title" class="modal-title">Leader Board</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" id="lbhdnleagueid" name="lbhdnleagueid">
                <div class="container-fluid mt-3">
                    <table class="table" style="width: 100%; color:#343a40;" id="leaderboarddata-table">
                        <thead>
                            <th>League Name</th>
                            <th>User Name</th>
                            <th>Points</th>
                        </thead>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="close_modal_btn2" name="close_modal_btn2">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- leaderboard Modal -->

<!------------------------------------------------------------------------------------>

<!-- additionalpoints Modal -->
<div class="modal fade" id="additionalpointsmodal" tabindex="-1" role="dialog" aria-labelledby="additionalpointsmodalLabel" aria-hidden="true" style="z-index:99999999999">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 id="modal-title" class="modal-title">Additional Points</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active additionalClass" data-sample="tab1" data-toggle="tab" href="#jokerround">A Joker Round</a></li>
                        <li class="nav-item"><a class="nav-link additionalClass" data-sample="tab2" data-toggle="tab" href="#scorepridictorround">Score Predictor Round</a></li>
                    </ul>

                    <div class="tab-content"></br>
                        <div id="jokerround" class="tab-pane fade-in active">
                            <h3>A Joker Round</h3>
                            <form onsubmit="return false" method="POST" name="apformdata" id="apformdata">
                                <input type="hidden" name="action" value="league_controller::additionalpointsinsert_data">
                                <input type="hidden" id="hapid" name="hapid" value="">
                                <input type="hidden" id="hdnapid" name="hdnapid">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="jokerscoremultiplier">Score Multiplier :</label>
                                        <input type="number" class="form-control" id="jokerscoremultiplier" name="jokerscoremultiplier" min="0">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="jokerscoretype"> Score Type :</label>
                                        <select class="form-control" id="jokerscoretype" name="jokerscoretype">
                                            <option value="added">Added</option>
                                            <option value="subtracted">Subtracted</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select Score Type.
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div id="scorepridictorround" class="tab-pane fade">
                            <h3>Score Predictor Round</h3>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="predictorscoremultiplier">Score Multiplier :</label>
                                    <input type="number" class="form-control" id="predictorscoremultiplier" name="predictorscoremultiplier" min="0">
                                </div>
                                <div class="col-sm-3">
                                    <label for="predictorscoretype"> Score Type :</label>
                                    <select class="form-control" id="predictorscoretype" name="predictorscoretype">
                                        <option value="added">Added</option>
                                        <option value="subtracted">Subtracted</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select Score Type.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-3" style="margin-top: 4%;">
                    <button type="submit" class="btn btn-primary" id="save_Btnap" name="save_Btnap">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- additionalpoints Modal -->