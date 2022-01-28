<?php
	
	if( !function_exists('kode_get_blog_elementor') ){
		function kode_get_blog_elementor( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . esc_attr($settings['margin-bottom']) . 'px;': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			
			$ret = '';
			$ret .= '<div class="col-md-12 blog-item-wrapper"  ' . $item_id . $margin_style . '>';
			
			// query post and sticky post
			$args = array('post_type' => 'post', 'suppress_filters' => false);
			if( !empty($settings['category']) || !empty($settings['tag']) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'category', 'field'=>'slug'));
				}
				if( !empty($settings['tag']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'post_tag', 'field'=>'slug'));
				}				
			}

			$args['posts_per_page'] = (empty($settings['num_fetch']))? '5': $settings['num_fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
			$args['paged'] = empty($args['paged'])? 1: $args['paged'];
			$query = new WP_Query( $args );
			$settings['title_num_fetch'] = (empty($settings['title_num_fetch']))? '20': $settings['title_num_fetch'];
			if(isset($settings['title_num_fetch']) && $settings['title_num_fetch'] == '-1'){
				$settings['title_num_fetch'] = 500;
			}
			$settings['pagination'] = (empty($settings['pagination']))? 'disable': $settings['pagination'];

			// set the excerpt length
			if( !empty($settings['num_excerpt']) ){
				global $kode_excerpt_length; $kode_excerpt_length = $settings['num_excerpt'];
				add_filter('excerpt_length', 'kode_set_excerpt_length');
			} 
			
			// get blog by the blog style
			global $kode_post_settings, $kode_lightbox_id;
			$kode_lightbox_id++;
			$kode_post_settings['excerpt'] = intval($settings['num_excerpt']);
			$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];	
			$kode_post_settings['blog_style'] = $settings['blog_style'];	
			
			$ret .= '<div class="blog-item-holder">';
			if($settings['blog_style'] == 'blog-full'){
				$settings['blog_size'] = 1;	
				$ret .= '<div class="kode-blog-list-full kode-large-blog row">';
				$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
				$kode_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
				$ret .= kode_get_blog_full_elementor($query, $settings);
				$ret .= '</div>';
			}else if($settings['blog_style'] == 'blog-small'){
				$ret .= '<div class="kode-blog-small kode-small-blog row">';
				$blog_size = $settings['blog_size'];	
				$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
				$kode_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
				$ret .= kode_get_blog_small_elementor($query, $settings);	
				$ret .= '</div>';
			}else if(strpos($settings['blog_style'], 'blog-widget') !== false){
				$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
				$blog_size = $settings['blog_size'];	
				$kode_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
				$ret .= '<div class="kode-blog-widget kode-widget-blog row">';
				$ret .= kode_get_blog_widget_elementor($query, $settings);
				$ret .= '</div>';
			}else if(strpos($settings['blog_style'], 'blog-grid') !== false){
				$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
				$blog_size = $settings['blog_size'];
				$kode_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
				$ret .= '<div class="kode-blog-grid kode-grid-blog row">';
				$ret .= kode_get_blog_grid_elementor($query, $settings);
				$ret .= '</div>';		
			}else{
				$kode_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
				$blog_size = $settings['blog_size'];
				$kode_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
				$ret .= '<div class="kode-blog-list-dd kode-grid-blog row">';
				$ret .= kode_get_blog_grid_elementor($query, $settings);
				$ret .= '</div>';
			}
			$ret .= '</div>';
			
			if( $settings['pagination'] == 'enable' ){
				$ret .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			$ret .= '</div>'; // blog-item-wrapper
			
			
			return $ret;
		}
	}
	
	if( !function_exists('kode_get_blog_small_elementor') ){
		function kode_get_blog_small_elementor($query,$settings){
			global $kode_post_settings;
			
			$kode_post_settings['excerpt'] = $settings['num_excerpt'];
			
			$size = $settings['blog_size'];
			
			if($settings['blog_slider'] == 'slider'){ return kode_get_blog_grid_elementor_carousel($query, $size); }
			
			$ret = ''; $current_size = 0;			
			while($query->have_posts()){ 
				global $kode_post_settings,$kode_admin_option,$post;
				$query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}
				if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
				if(isset($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = $kode_post_settings['title_num_fetch'];
				}		
				$kode_post_settings['content'] = get_the_content();
				if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = 100;
				}
				$kode_post_settings['post'] = $post;
				$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
				$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true);

				$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-grid-ux">';
				ob_start(); 
				
				kode_get_blog_small_elementor_item($kode_post_settings);
				
				$ret .= ob_get_contents();
				
				ob_end_clean();		
				
				$ret .= '</div>'; // kode-ux				
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
			
		}
	}
	
	function kode_get_blog_small_elementor_item($kode_post_settings){
		global $post;
		if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
		if(isset($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = $kode_post_settings['title_num_fetch'];
		}		
		
		if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = 100;
		}
		$blog_class = 'top-margin-push-image';
		$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
		$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="kode-time-zoon">
				<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
				<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h5>
			</div>
			<?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size); ?>
			<div class="kode-blog-info">
				<ul class="kode-blog-options">
					<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
				</ul>
				<?php kode_get_social_shares()?>		
				<div class="clearfix clear"></div>
				<?php 
					if( is_single() || $kode_post_settings['excerpt'] < 0 || $kode_post_settings['excerpt'] == 'full'){
						echo '<div class="kode-blog-content">';
						echo kode_content_filter($kode_post_settings['content'], true);
						wp_link_pages( array( 
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kickoff' ) . '</span>', 
							'after' => '</div>', 
							'link_before' => '<span>', 
							'link_after' => '</span>' )
						);
						echo '</div>';
					}else if( $kode_post_settings['excerpt'] != 0 ){
						echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>
						<a href="' . esc_url(get_permalink()) . '" class="kode-modrenbtn thbg-colorhover">' . esc_html__( 'Read More', 'kickoff' ) . '</a>
					</div>';
						
					}
				?>	
			</div>
		</article><!-- #post -->
		<?php 
	}
	
	if( !function_exists('kode_get_blog_widget_elementor') ){
		function kode_get_blog_widget_elementor($query,$settings){
			global $kode_post_settings;
			
			$size = $settings['blog_size'];
			
			$kode_post_settings['excerpt'] = $settings['num_excerpt'];
			
			if($settings['blog_slider'] == 'slider'){ return kode_get_blog_grid_elementor_carousel($query, $size); }
			$ret = ''; $current_size = 0;			
			while($query->have_posts()){ 
				global $kode_post_settings,$kode_admin_option,$post;
				$query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}
				$kode_post_settings['post'] = $post;
				if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
				if(isset($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = $kode_post_settings['title_num_fetch'];
				}		
				$kode_post_settings['content'] = get_the_content();
				if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = 100;
				}
				
				$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
				$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true);

				$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-grid-ux">';
				ob_start();
				
				kode_get_blog_widget_elementor_item($kode_post_settings);
				
				$ret .= ob_get_contents();
				
				ob_end_clean();		
				
				$ret .= '</div>'; // kode-ux				
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
			
		}
	}
	
	function kode_get_blog_widget_elementor_item($kode_post_settings){
		global $post;
		if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
		if(isset($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = $kode_post_settings['title_num_fetch'];
		}		
		
		if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = 100;
		}
		$blog_class = 'top-margin-push-image';
		$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? '': $kode_post_settings['thumbnail_size'];
		$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="kode-time-zoon">
				<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
				<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h5>
			</div>
			<?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size); ?>
			<div class="kode-blog-info">
				<ul class="kode-blog-options">
					<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
				</ul>
				<?php kode_get_social_shares()?>		
				<div class="clearfix clear"></div>
				<?php 
					if( is_single() || $kode_post_settings['excerpt'] < 0 || $kode_post_settings['excerpt'] == 'full'){
						echo '<div class="kode-blog-content">';
						echo kode_content_filter($kode_post_settings['content'], true);
						wp_link_pages( array( 
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kickoff' ) . '</span>', 
							'after' => '</div>', 
							'link_before' => '<span>', 
							'link_after' => '</span>' )
						);
						echo '</div>';
					}else if( $kode_post_settings['excerpt'] != 0 ){
						echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>
						<a href="' . esc_url(get_permalink()) . '" class="kode-modrenbtn thbg-colorhover">' . esc_html__( 'Read More', 'kickoff' ) . '</a>
					</div>';
						
					}
				?>	
			</div>
		</article><!-- #post -->
		<?php 
	}
	
	if( !function_exists('kode_get_blog_grid_elementor') ){
		function kode_get_blog_grid_elementor($query,$settings){
			global $kode_post_settings;
			
			$size = $settings['blog_size'];
			
			$kode_post_settings['excerpt'] = $settings['num_excerpt'];
			
			if($settings['blog_slider'] == 'slider'){ return kode_get_blog_grid_elementor_carousel($query, $size); }
			
			$ret = ''; $current_size = 0;			
			while($query->have_posts()){ 
				global $kode_post_settings,$kode_admin_option,$post;
				$query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}
				$kode_post_settings['post'] = $post;
				if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
				if(isset($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = $kode_post_settings['title_num_fetch'];
				}		
				$kode_post_settings['content'] = get_the_content();
				if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
					$title_num_fetch = 100;
				}
				$blog_class = 'top-margin-push-image';
				$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
				$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true);

				$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-grid-ux">';
				ob_start(); 
				
				kode_get_blog_grid_elementor_item($kode_post_settings);
				
				$ret .= ob_get_contents();
				
				ob_end_clean();		
				
				$ret .= '</div>'; // kode-ux				
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			
			wp_reset_postdata();
			
			return $ret;
		}
	}	
	
	function kode_get_blog_grid_elementor_item($kode_post_settings){
		global $post;
		if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
		if(isset($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = $kode_post_settings['title_num_fetch'];
		}		
		
		if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = 100;
		}
		$blog_class = 'top-margin-push-image';
		$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
		$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="kode-time-zoon">
				<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
				<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h5>
			</div>
			<a href="<?php echo esc_attr(get_permalink());?>">
				<?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size); ?>
			</a>
			<div class="kode-blog-info">
			  <ul class="kode-blog-options">
				<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
			  </ul>
			  <?php 
					if( is_single() || $kode_post_settings['excerpt'] < 0 || $kode_post_settings['excerpt'] == 'full'){
						echo '<div class="kode-blog-content">';
						echo kode_content_filter($kode_post_settings['content'], true);
						wp_link_pages( array( 
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kickoff' ) . '</span>', 
							'after' => '</div>', 
							'link_before' => '<span>', 
							'link_after' => '</span>' )
						);
						echo '</div>';
					}else if( $kode_post_settings['excerpt'] != 0 ){
						echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>
						<a href="' . esc_url(get_permalink()) . '" class="kode-modrenbtn thbg-colorhover">' . esc_html__( 'Read More', 'kickoff' ) . '</a>
					</div>';
						
					}
				?>
			  <div class="clearfix"></div>
			  <?php kode_get_social_shares()?>	
			</div>
		</article><!-- #post -->
		
		<?php 
	}
	
	if( !function_exists('kode_get_blog_full_elementor') ){
		function kode_get_blog_full_elementor($query,$settings){
			
			$size = $settings['blog_size'];
			
			$kode_post_settings['excerpt'] = $settings['num_excerpt'];
			
			if($settings['blog_slider'] == 'slider'){ return kode_get_blog_grid_elementor_carousel($query, $size); }
		
			$ret = ''; $current_size = 0;			
			while($query->have_posts()){ 
				global $kode_post_settings,$kode_admin_option,$post;
				$query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}
				$kode_post_settings['content'] = get_the_content();
				$kode_post_settings['post'] = $post;
				$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-grid-ux">';
				ob_start(); 
				
				kode_get_blog_full_elementor_item($kode_post_settings);
				
				$ret .= ob_get_contents();
				
				ob_end_clean();		
				
				$ret .= '</div>'; // kode-ux				
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			
			wp_reset_postdata();
			
			return $ret;
		}
	}	


	function kode_get_blog_full_elementor_item($kode_post_settings){ 
		global $post;
		if(isset($kode_post_settings['excerpt']) && $kode_post_settings['excerpt'] < 0) global $kode_more; $kode_more = 0;
		if(isset($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = $kode_post_settings['title_num_fetch'];
		}		
		
		if(!isset($kode_post_settings['title_num_fetch']) && empty($kode_post_settings['title_num_fetch'])){
			$title_num_fetch = 100;
		}
		$blog_class = 'top-margin-push-image';
		$thumbnail_size = (empty($kode_post_settings['thumbnail_size']))? $kode_admin_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail_size'];
		$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="kode-time-zoon">
				<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
				<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h5>
			</div>
			<?php get_template_part('single/thumbnail', get_post_format()); ?>
			<div class="kode-blog-info">
				<ul class="kode-blog-options">
					<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
				</ul>
				<?php kode_get_social_shares()?>		
				<div class="clearfix clear"></div>
				<?php 
					if( is_single() || $kode_post_settings['excerpt'] < 0 || $kode_post_settings['excerpt'] == 'full'){
						echo '<div class="kode-blog-content">';
						echo kode_content_filter($kode_post_settings['content'], true);
						wp_link_pages( array( 
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kickoff' ) . '</span>', 
							'after' => '</div>', 
							'link_before' => '<span>', 
							'link_after' => '</span>' )
						);
						echo '</div>';
					}else if( $kode_post_settings['excerpt'] != 0 ){
						echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>
						<a href="' . esc_url(get_permalink()) . '" class="kode-modrenbtn thbg-colorhover">' . esc_html__( 'Read More', 'kickoff' ) . '</a>
					</div>';
						
					}
				?>	
			</div>
		</article><!-- #post -->
		<?php 
	}
	
	if( !function_exists('kode_get_blog_grid_elementor_carousel') ){
		function kode_get_blog_grid_elementor_carousel($query, $size){
			global $kode_post_settings;
			$ret = ''; 			
			$ret .= '<div class="owl-carousel owl-theme" data-slide="'.esc_attr($size).'" >';			
			while($query->have_posts()){ $query->the_post();
				$ret .= '<div class="item">';
					
				$ret .= '</div>'; // kode-item
			}
			$ret .= '</div>';
			$ret .= '<div class="clear"></div>';			
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	