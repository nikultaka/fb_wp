<?php 
	while ( have_posts() ){ the_post();
		$content = kode_content_filter(get_the_content(), true); 
		if(!empty($content)){
			?>
			<div class="container">
				<div class="kode-item k-content">
					<?php echo esc_attr($content); ?>
				</div>
			</div>
			<?php
		}
	} 
?>