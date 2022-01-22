<?php get_header(); ?>
	<div class="content">
		<!-- Sidebar With Content Section-->
		<?php 
			
			$kode_content_raw = json_decode(kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'kode_content', true)), true);
			$kode_content_raw = (empty($kode_content_raw))? array(): $kode_content_raw;
			
			
			if( !empty($kode_content_raw) ){ 
				echo '<div class="vc-wrapper container">';
				while ( have_posts() ){ the_post();
					if( has_shortcode( get_the_content(), 'vc_row' ) ) {
						echo kode_content_filter(get_the_content(), true); 
					}
				}
				echo '</div>';
				if(function_exists('kode_show_page_builder')){
					echo '<div class="pagebuilder-wrapper">';
					kode_show_page_builder($council_content_raw);
					echo '</div>';
				}
				
				
			}else{
				if(class_exists('register_block_type')){
					if( ! has_blocks() ){ 
						echo '<div class="container">';
					}else{
						echo '<div class="no-container-has-block">';
					}
				}else{
					if (in_array('elementor-page elementor-page-'.esc_attr(get_queried_object_id()).'',get_body_class())) {
						// your markup
						echo '<div class="elementor-container-default">';
					} else {
						// some other markup
						echo '<div class="container council-builder">';
					}
				}
				$default['show-title'] = 'enable';
				$default['show-content'] = 'enable'; 
				echo kode_get_default_content_item($default);
				echo '</div>';
			}
		?>
	</div><!-- content -->
<?php get_footer(); ?>