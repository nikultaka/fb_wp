<?php get_header(); ?>
<div class="content">
	<div class="container">
		<div class="row">
		<?php 
			global $kode_sidebar, $kode_theme_option;
			$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($kode_post_option) ){
				$kode_post_option = json_decode( $kode_post_option, true );					
			}
			if( empty($kode_post_option['sidebar']) || $kode_post_option['sidebar'] == 'default-sidebar' ){
				$kode_sidebar = array(
					'type'=>$kode_theme_option['archive-sidebar-template'],
					'left-sidebar'=>$kode_theme_option['archive-sidebar-left'], 
					'right-sidebar'=>$kode_theme_option['archive-sidebar-right']
				); 
			}else{
				$kode_sidebar = array(
					'type'=>$kode_post_option['sidebar'],
					'left-sidebar'=>$kode_post_option['left-sidebar'], 
					'right-sidebar'=>$kode_post_option['right-sidebar']
				); 				
			}
			
			$kode_sidebar = kode_get_sidebar_class($kode_sidebar);
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'left-sidebar'){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['left'])?>">
					<?php get_sidebar('left'); ?>
				</div>	
			<?php } ?>
			<div class="<?php echo esc_attr($kode_sidebar['center'])?>">
					<?php
						if( !is_tax('work_category') && !is_tax('work_tag') ){		
							// set the excerpt length
							if( !empty($kode_theme_option['archive-num-excerpt']) ){
								global $kode_excerpt_length; $kode_excerpt_length = $kode_theme_option['archive-num-excerpt'];
								add_filter('excerpt_length', 'kode_set_excerpt_length');
							} 

							global $wp_query, $kode_post_settings;
							$kode_lightbox_id++;
							$kode_post_settings['excerpt'] = intval($kode_theme_option['archive-num-excerpt']);
							$kode_post_settings['thumbnail-size'] = 'full';
							$kode_post_settings['title-num-fetch'] = '-1';
							$kode_post_settings['blog-style'] = $kode_theme_option['archive-blog-style'];					
							echo '<div class="kode-blog-list kode-fullwidth-blog row">';
							if($kode_theme_option['archive-blog-style'] == 'blog-full'){
								echo kode_get_blog_full($wp_query);
							}else if($kode_theme_option['archive-blog-style'] == 'blog-medium'){
								echo '<div class="kode-blog-list kode-mediium-blog margin-bottom">';
								echo kode_get_blog_medium($wp_query);			
								echo '</div>';
							}else{
								$blog_size = 3;
								echo '<div class="kode-blog-list kode-blog-grid margin-bottom-30">';
								echo kode_get_blog_grid($wp_query, $blog_size, 'fitRows');
								echo '</div>';	
							}
							echo '<div class="clear"></div>';
							echo '</div>';
							
							
							$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
							echo kode_get_pagination($wp_query->max_num_pages, $paged);													
						
						}else{
							// set the excerpt length
							if( !empty($kode_theme_option['archive-num-excerpt']) ){
								global $kode_excerpt_length; $kode_excerpt_length = $kode_theme_option['archive-num-excerpt'];
								add_filter('excerpt_length', 'kode_set_excerpt_length');
							} 

							global $wp_query, $kode_post_settings;
							$kode_lightbox_id++;
							$settings['num-fetch'] = -1;
							$settings['margin-bottom'] = 30;
							//$kode_post_settings['blog-style'] = $kode_theme_option['archive-blog-style'];	

							echo '<div style="margin:30px 0px 0px 0px" class="kode-work-column">';
							$settings['work-style'] = 'work-4column';
							$settings['pagination'] = 'enable';
							echo kode_get_work_item($settings);
							echo '<div class="clear"></div>';
							echo '</div>';
															
						
						
						}
					?>
				</div>
			<?php
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'right-sidebar' && $kode_sidebar['right'] != ''){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['right'])?>">
					<?php get_sidebar('right'); ?>
				</div>	
			<?php } ?>
		</div><!-- Row -->	
	</div><!-- Container -->		
</div><!-- content -->
<?php get_footer(); ?>