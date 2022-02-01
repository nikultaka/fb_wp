<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<button class="btn btn-sm" onclick="history.back()">Go Back</button></br></br>

<div class="container-fluid mt-5">
    <table class="table" id="loadleaderboardlistdata-table">
        <thead>
            <!-- <th>ID</th> -->
            <th>League Name</th>
            <th>User Name</th>
            <th>User Points</th>
        </thead>
    </table> 
</div>


<div class="modal fade"  data-backdrop="false" id="matchscoredetailsmodal" tabindex="-1" role="dialog" aria-labelledby="matchscoredetailslabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="matchscoredetailslabel">Score Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="loadmatchscoredetails-table">
                    <thead>
                        <th>Team Name</th>
                        <th>Team Score</th>
                    </thead>
                </table>
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
        load_leader_board_list(<?php echo $_GET['id'] ?>);
    })
</script>