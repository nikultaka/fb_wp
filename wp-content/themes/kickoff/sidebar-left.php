<?php
/**
 * A template for calling the left sidebar on everypage
 */
 
	global $kode_sidebar;
?>

<?php if( $kode_sidebar['type'] == 'left-sidebar' || $kode_sidebar['type'] == 'both-sidebar' ){ ?>
<div class="kode-sidebar kode-left-sidebar columns">
	<?php dynamic_sidebar($kode_sidebar['left-sidebar']); ?>
</div>
<?php } ?>