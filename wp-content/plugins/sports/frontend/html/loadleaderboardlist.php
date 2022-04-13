<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<span><a  onclick="history.back()" class="title btn" style="background-color: #ffcc00; color: #24890d; font-size: 25px; margin-top: -4%;  margin-left: 15px; font-family: Oswald; "><b>Go Back</b></a></span>
</br></br>

<style>
    .dataTables_filter {
        display: none;
    }
</style>

<div class="container-fluid mt-5" style="overflow: auto;">
    <table class="table" id="loadleaderboardlistdata-table" style="width: 1092px !important;">
        <thead>
            <th>No</th>
            <th>League Name</th>
            <th>User Name</th>
            <th>User Points</th>
            <th>Action</th>
        </thead>
    </table></br></br></br>
</div>


<div class="modal fade"  data-backdrop="false" id="matchscoredetailsmodal" tabindex="-1" role="dialog" aria-labelledby="matchscoredetailslabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="matchscoredetailslabel">Score Details</h3>
            </div>
            <div class="modal-body">
                <table class="table" id="loadmatchscoredetails-table" >
                    <thead>
                        <th>Round Name</th>
                        <th>Team Name</th>
                        <th>Team Score</th>
                    </thead>
                </table></br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        load_leader_board_list(<?php echo $_GET['id']?>, <?php echo $_GET['userid'] ?>);
    })
</script>