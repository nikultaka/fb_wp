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
					if( have_posts() ){
						// set the excerpt length
						if( !empty($kode_theme_option['archive-num-excerpt']) ){
							global $kode_excerpt_length; $kode_excerpt_length = $kode_theme_option['archive-num-excerpt'];
							add_filter('excerpt_length', 'kode_set_excerpt_length');
						} 

						global $wp_query, $kode_post_settings;
						$kode_lightbox_id++;
						$kode_post_settings['excerpt'] = intval($kode_theme_option['archive-num-excerpt']);
						$kode_post_settings['thumbnail-size'] = 'kode-blog-post-size';			
						$kode_post_settings['title-num-fetch'] = '25';
						$kode_post_settings['blog-style'] = $kode_theme_option['archive-blog-style'];							
					
						echo '<div class="kode-blog-list kode-fullwidth-blog row">';
						if($kode_theme_option['archive-blog-style'] == 'blog-full'){
							echo kode_get_blog_full($wp_query);
						}else if($kode_theme_option['archive-blog-style'] == 'blog-medium'){
							echo '<div class="kode-blog-list kode-mediium-blog margin-bottom-30">';
							echo kode_get_blog_medium($wp_query);			
							echo '</div>';
						}else{
							$blog_size = 3;
							echo '<div class="kode-blog-list kode-blog-grid margin-bottom-30">';
							echo kode_get_blog_grid($wp_query, $blog_size, 'fitRows');
							echo '</div>';	
						}
						echo '</div>';
						
						
						$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
						echo kode_get_pagination($wp_query->max_num_pages, $paged);
					}else{ ?>
					<!--// Main Content //-->
					<div class="main-content">
						<div class="row">
							<div class="col-md-12">
								<div class="kode-pagecontent search-page-kode col-md-12">
									<div class="kode-404-page">
										<h2><?php esc_html_e('Not Found', 'kickoff'); ?></h2>
										<span><?php esc_html_e('OPS, PAGE NOT FOUND', 'kickoff'); ?></span>
										<p><?php esc_html_e('Nothing matched your search criteria. Please try again with different keywords.', 'kickoff'); ?></p>										
										<div class="kode-innersearch">
											<form class="kode-search" method="get" id="searchform" action="<?php  echo esc_url(home_url('/')); ?>/">
											<?php $search_val = get_search_query();
												if( empty($search_val) ){
													$search_val = esc_html__("Type keywords..." , "kickoff");
												} ?>
												<input type="text" name="s" id="s" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
												<label><input type="submit" value=""></label>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--// Main Content //-->
				<?php } ?>
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