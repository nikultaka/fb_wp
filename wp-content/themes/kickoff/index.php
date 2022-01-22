<?php get_header(); 
	global $kode_theme_option, $kode_post_option;	
	$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
	if( !empty($kode_post_option) ){
		$kode_post_option = json_decode( $kode_post_option, true );					
	}
	if(isset($kode_post_option['header-background'])){
		if( is_numeric($kode_post_option['header-background']) ){
			$image_src = wp_get_attachment_image_src($kode_post_option['header-background'], 'full');	
			$header_background = ' style="background-image: url(\'' . esc_url($image_src[0]) . '\');" ';		
		}else{
			if(esc_url($kode_post_option['header-background']) <> ''){
				$header_background = ' style="background-image: url(\'' . esc_url($kode_post_option['header-background']) . '\');" ';
			}else{
				$header_background = ' style="background-image: url(\'' . KODE_PATH . '/images/subheader-bg.jpg\');" ';
			}		
		}
	}else{
		$header_background = '';
	}
	$kode_theme_option['kode-header-style'] = (empty($kode_theme_option['kode-header-style']))? 'header-style-1': $kode_theme_option['kode-header-style'];
	$page_caption = '';
	$page_background = ''; $page_title = get_the_title(); 
	if(!empty($kode_post_option['page-caption'])){ $page_caption = $kode_post_option['page-caption'];} ?>
<div <?php echo esc_attr($header_background); ?>  class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="page-info">
					<h2><?php echo esc_attr(kode_text_filter($page_title)); ?></h2>
					<?php if( !empty($page_caption) ){ ?>
						<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>
					<?php }?>
				</div>
			</div>
			<div class="col-md-6">
				<?php kode_get_breadcumbs();?>
			</div>
		</div>
	</div>
</div>
<div class="content kode-main-content-k">
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
			<div class="kode-main-content <?php echo esc_attr($kode_sidebar['center'])?>">
				<?php		
					// set the excerpt length
					if( !empty($kode_theme_option['archive-num-excerpt']) ){
						global $kode_excerpt_length; $kode_excerpt_length = 55;
						add_filter('excerpt_length', 'kode_set_excerpt_length');
					} 

					global $wp_query, $kode_post_settings;
					$kode_lightbox_id++;
					$kode_post_settings['excerpt'] = 'full';
					$kode_post_settings['thumbnail-size'] = 'full';			
					$kode_post_settings['blog-style'] = 'blog-full';							
				
					echo '<div class="kode-blog-list kode-fullwidth-blog row">';
					if($kode_post_settings['blog-style'] == 'blog-full'){
						
						$kode_post_settings['blog-info'] = array('author', 'date', 'category', 'comment');
						echo kode_get_blog_full($wp_query);
					}else{
						$kode_post_settings['blog-info'] = array('date', 'comment');
						$kode_post_settings['blog-info-widget'] = true;
						
						$blog_size = str_replace('blog-1-', '', $kode_theme_option['archive-blog-style']);
						echo kode_get_blog_grid($wp_query, $blog_size, 
							$kode_theme_option['archive-thumbnail-size'], 'fitRows');
					}
					echo '<div class="clear"></div>';
					echo '</div>';
					
					
					$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
					echo kode_get_pagination($wp_query->max_num_pages, $paged);													
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