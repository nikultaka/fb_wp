<?php get_header(); ?>
<div class="content">
<?php if (in_array('elementor-page elementor-page-'.esc_attr(get_queried_object_id()).'',get_body_class())) { ?>
	<div class="elementor-container-default">
<?php } else { ?>
	<div class="container">
<?php }?>
		<div class="row">
		<?php 
			global $kode_sidebar, $kode_theme_option;
			$kode_post_settings['thumbnail-size'] = 'kode-blog-post-size';
			$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($kode_post_option) ){
				$kode_post_option = json_decode( $kode_post_option, true );					
			}
			if( empty($kode_post_option['sidebar']) || $kode_post_option['sidebar'] == 'default-sidebar' ){
				$kode_sidebar = array(
					'type'=>$kode_theme_option['post-sidebar-template'],
					'left-sidebar'=>$kode_theme_option['post-sidebar-left'], 
					'right-sidebar'=>$kode_theme_option['post-sidebar-right']
				); 
			}else{
				$kode_sidebar = array(
					'type'=>$kode_post_option['sidebar'],
					'left-sidebar'=>$kode_post_option['left-sidebar'], 
					'right-sidebar'=>$kode_post_option['right-sidebar']
				); 				
			}
			//$kode_theme_option['single-post-author'] = 'enable';
			
			$kode_sidebar = kode_get_sidebar_class($kode_sidebar);			
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'left-sidebar'){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['left'])?>">
					<?php get_sidebar('left'); ?>
				</div>	
			<?php } ?>
			<div class="<?php echo esc_attr($kode_sidebar['center'])?>">
				<div class="kode-item kode-blog-full ">
				<?php while ( have_posts() ){ the_post();global $post; ?>
					<div class="kode-blog-list kode-fullwidth-blog">
						<div class="kode-time-zoon">
						<?php if(isset($kode_theme_option['single-post-date']) && $kode_theme_option['single-post-date'] == 'enable'){ ?>
							<time datetime="<?php echo esc_attr(get_the_date('Y-m-d'));?>"><?php echo esc_attr(get_the_date('d'));?>  <span><?php echo esc_attr(get_the_date('M'));?></span></time>
						<?php } ?>		
							<h5><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title()?></a></h5>
						</div>
						<?php if(isset($kode_theme_option['single-post-feature-image']) && $kode_theme_option['single-post-feature-image'] == 'enable'){ ?>
						<figure><?php get_template_part('single/thumbnail', get_post_format()); ?></figure>
						<?php } ?>
						<?php if(isset($kode_theme_option['single-post-meta']) && $kode_theme_option['single-post-meta'] == 'enable'){ ?>
						<div class="kode-blog-info">
							<ul class="kode-blog-options">
								<?php echo kode_get_blog_info(array('author','comment','category','tag'), false, '','li');?>							
							</ul>
							<?php kode_get_social_shares()?>
						</div>
						<?php } ?>
					</div>
					<div class="kode-editor">
					<?php the_content();
					
					?>
					</div>
					<?php if(isset($kode_theme_option['single-post-author2']) && $kode_theme_option['single-post-author2'] == 'enable'){ ?>
						<?php if(get_the_author_meta('description') <> ''){ ?>
							<div class="kode-admin-post">
								<figure><?php echo get_avatar(get_the_author_meta('ID'), 90); ?></figure>
								<div class="admin-info">
									<h4><?php the_author_posts_link(); ?></h4>
									<?php if(get_the_author_meta('description') <> ''){ ?>
										<p><?php echo esc_attr(get_the_author_meta('description')); ?></p>
									<?php }?>
								</div>
							</div>
						<?php }?>
					<?php } ?>
					<?php if(isset($kode_theme_option['single-next-pre']) && $kode_theme_option['single-next-pre'] == 'enable'){ ?>
					<div class="kode-postsection">
						<?php previous_post_link('<div class="kode-prev thcolorhover previous-nav inner-post">%link</div>', '<i class="icon-angle-left"></i><span>%title</span>', true); ?>
						<?php next_post_link('<div class="kode-next thcolorhover next-nav inner-post">%link</div>', '<span>%title</span><i class="icon-angle-right"></i>', true); ?>
					</div>
					<?php }?>
					<!-- Blog Detail -->
					<?php if(isset($kode_theme_option['single-post-comments']) && $kode_theme_option['single-post-comments'] == 'enable'){ ?>
					<?php comments_template( '', true ); ?>
					<?php } ?>
				<?php } ?>
				</div>
				<div class="clear clearfix"></div>
			</div>
			<?php			
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'right-sidebar' && $kode_sidebar['right'] != ''){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['right'])?>">
					<?php get_sidebar('right'); ?>
				</div>	
			<?php } 			
			?>
		</div><!-- Row -->	
	</div><!-- Container -->
	<div class="margin-bottom-50"></div>
</div><!-- content -->
<?php get_footer(); ?>