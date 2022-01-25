<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<div class="row d-grid gap-3">
	<div id="matchlistdata">
	</div>
</div>

	<script type="text/javascript">
		var $ = jQuery;
		var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
		$(document).ready(function() {
			match_list(<?php echo $_GET['id'] ?>);
		})
	</script>