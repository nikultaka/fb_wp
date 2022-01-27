<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<div class="container-fluid mt-5">
<table class="table"  id="loadleaderboardlistdata-table"> 
		<thead>
			<!-- <th>ID</th> -->
            <th>League Name</th>
			<th>User Name</th>
			<th>User Score</th>
		</thead>
</table>
<div>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        load_leader_board_list(<?php echo $_GET['id'] ?>);
    })
</script>