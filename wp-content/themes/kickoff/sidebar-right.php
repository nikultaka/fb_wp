<?php
/**
 * A template for calling the right sidebar in everypage
 */
 
	global $kode_sidebar;
?>

<?php if( $kode_sidebar['type'] == 'right-sidebar' || $kode_sidebar['type'] == 'both-sidebar' ){ ?>
<div class="kode-sidebar kode-right-sidebar columns">
	<?php dynamic_sidebar($kode_sidebar['right-sidebar']); ?>
</div>
<?php } ?>