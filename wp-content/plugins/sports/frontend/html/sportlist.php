

<div class="row d-grid gap-3">
    <div id="sportlistdata" >
    </div>
</div>

<script type="text/javascript">
    var $ = jQuery;
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    $(document).ready(function() {
        get_all_sport_list();
    })
</script>