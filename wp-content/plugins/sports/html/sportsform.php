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
<button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#registerModal">
Add Sports 
</button>


<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Sport</h4>
                <button type="button" class="close" data-dismiss="modal" id="close_modal_btn1" name="close_modal_btn1">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
				<form onsubmit="return false" method="POST" name="formdata"  id="formdata" >
				<input type="hidden" name="action" value="sports_controller::insert_data">
                    <input type="hidden" id="hid" name="hid">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="name">Sport Name:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>                 
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="status">Status:</label>
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

<div class="container-fluid mt-5">
<table class="table" id="sportsdata-table"> 
		<thead>
			<!-- <th>ID</th> -->
			<th>Name</th>
			<th>Status</th>
			<th>Actions</th>
		</thead>
</table>
<div>
<script type="text/javascript">
	    var ajaxurl ="<?php echo admin_url('admin-ajax.php')?>";
</script>
