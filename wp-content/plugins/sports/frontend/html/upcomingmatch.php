<div class="row d-grid gap-3">
    <div id="upcomingmatchlist">
    </div>
</div>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        upcoming_match_list();
    })
</script>

