

<div class="row d-grid gap-3">
    <div id="leaguelistdata" >
    </div>
</div>
<button class="btn btn-sm" onclick="history.back()">Go Back</button>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        league_list(<?php echo $_GET['id'] ?>);
    })
</script>