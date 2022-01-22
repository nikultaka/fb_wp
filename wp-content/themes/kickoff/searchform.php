<div class="widget widget-search">
	<form class="kode-search" method="get" id="searchform" action="<?php  echo esc_url(home_url('/')); ?>/">
		<?php
			$search_val = get_search_query();
			if( empty($search_val) ){
				$search_val = esc_html__("Type keywords..." , "kickoff");
			}
		?>
	<input type="text" name="s" id="s" placeholder="Search" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
	<label><input type="submit" value=""></label>
  </form>
</div>