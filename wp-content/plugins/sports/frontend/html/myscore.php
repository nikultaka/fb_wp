<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<div class="container-fluid mt-5">
    <h2>My Score Table</h2>
<table class="table" id="myscoredata-table"> 
		<thead>
			<!-- <th>ID</th> -->
			<th>Sport</th>
			<th>League</th>
			<th>Round</th>
            <th>Team</th>
            <th>Your score</th>
		</thead>
</table>
<div>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        my_score_list();
    })
</script>