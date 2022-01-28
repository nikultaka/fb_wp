<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<div class="container-fluid mt-5">
 
<h2>League List Table</h2>

<table class="table"  id="leaderboardlistdata-table"> 

		<thead>
			<!-- <th>ID</th> -->
			<th>Leagues</th>
			<th>Action</th>
		</thead>
</table>
<div>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        leader_board_list();
    })
</script>