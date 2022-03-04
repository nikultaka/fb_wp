<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
      form .error {
            color: #ff0000;
        }
</style>

	<!-- Button trigger modal -->
    </br></br><button type="button" class="btn btn-primary mt-5" style="float: left;" data-toggle="modal" data-target="#registerteamModal">
Add Team 
</button></br>


<!-- Modal -->
<div class="modal fade" id="registerteamModal" tabindex="-1" role="dialog" aria-labelledby="registerteamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Team</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
				<form onsubmit="return false" method="POST" name="teamformdata"  id="teamformdata" >
				<input type="hidden" name="action" value="team_controller::insert_team_data">
                    <input type="hidden" id="tid" name="tid">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="sportid">Sports Name :</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="sportid" name="sportid" required>
                                <!-- <option value="" selected="">----Select Sport----</option> -->
                                <?php foreach ($pagessql as $sports) { ?>
                                    <option class="custom-select" value='<?php echo $sports->id ?>'><?php echo $sports->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="teamname">Team Name:</label>
                        </div>
                        <div class="col-sm-7" >
                            <input type="text" style="max-width: 92% !important; " class="form-control" id="teamname" name="teamname" required>
                        </div>
                    </div>                 
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="tstatus">Status:</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control" id="tstatus" name="tstatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select status.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_btn2"
                            name="close_modal_btn2">Close</button> 
                        <button type="submit" class="btn btn-primary" id="save_Btn" name="save_Btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

    </br></br><div class="container-fluid mt-5">
<table class="table" id="teamdata-table"> 
		<thead>
			<!-- <th>ID</th> -->
			<th>Sport Name</th>
			<th>Team Name</th>
			<th>Status</th>
			<th>Actions</th>
		</thead>
</table>
<div>
<script type="text/javascript">
	    var ajaxurl ="<?php echo admin_url('admin-ajax.php')?>";
</script>
