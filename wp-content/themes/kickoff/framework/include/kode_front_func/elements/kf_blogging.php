<?php
	/*	
	*	Kodeforest Blog Item Management File
	*	---------------------------------------------------------------------
	*	This file contains functions that help you get blog item
	*	---------------------------------------------------------------------
	*/
	
	if( !function_exists('kode_get_news_item') ){
		function kode_get_news_item( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			$ret = '';
			//$ret  = kode_get_item_title($settings);
			$ret .= '<div class="col-md-12 news-item-wrapper"  ' . $item_id . $margin_style . '>';
			
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
			if(isset($settings['enable-sticky'])){
				if( $settings['enable-sticky'] == 'enable' ){
					if( get_query_var('paged') <= 1 ){
						$sticky_args = $args;
						$sticky_args['post__in'] = get_option('sticky_posts');
						if( !empty($sticky_args['post__in']) ){
							$sticky_query = new WP_Query($sticky_args);	
						}
					}
					$args['post__not_in'] = get_option('sticky_posts', '');
				}else{
					$args['ignore_sticky_posts'] = 1;
				}
			}
			
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
			$args['paged'] = empty($args['paged'])? 1: $args['paged'];
			$args['offset'] = (empty($settings['offset']))? 0: $settings['offset'];			
			$query = new WP_Query( $args );
			
			
			// merge query
			if( !empty($sticky_query) ){
				$query->posts = array_merge($sticky_query->posts, $query->posts);
				$query->post_count = $sticky_query->post_count + $query->post_count;
			}

			// set the excerpt length
			if( !empty($settings['num-excerpt']) ){
				global $kode_excerpt_length; $kode_excerpt_length = $settings['num-excerpt'];
				add_filter('excerpt_length', 'kode_set_excerpt_length');
			} 
			
			// get blog by the blog style
			global $kode_post_settings, $kode_lightbox_id;
			$kode_lightbox_id++;
			$kode_post_settings['excerpt'] = intval($settings['num-excerpt']);
			// $kode_post_settings['thumbnail-size'] = $settings['thumbnail-size'];			
			$kode_post_settings['news-style'] = $settings['news-style'];			
			
			$ret .= '<div class="news-item-holder row">';
			if($settings['news-style'] == 'news-timeline'){
				$blog_size = 1;
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$ret .= kode_get_news_full($query, $blog_size);	
			}else if($settings['news-style'] == 'news-medium'){
				$blog_size = 2;
				$kode_post_settings['thumbnail-size'] = array(150,150);
				$ret .= kode_get_news_medium($query, $blog_size);			
			}else if(strpos($settings['news-style'], 'news-grid') !== false){
				$blog_size = 3;
				$kode_post_settings['thumbnail-size'] = $kode_post_settings['thumbnail-size'];
				$ret .= kode_get_news_grid($query, $blog_size);			
			}else{
				$blog_size = 2;
				$blog_size = str_replace('news-1-', '', $settings['news-style']);
				$ret .= kode_get_news_grid($query, $blog_size);
			}
			$ret .= '</div>';
			
			if( $settings['pagination'] == 'enable' ){
				$ret .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			$ret .= '</div>'; // blog-item-wrapper
			
			
			return $ret;
		}
	}
	
	if( !function_exists('kode_get_blog_item') ){
		function kode_get_blog_item( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			//$ret  = kode_get_item_title($settings);
			$ret = '';
			$ret .= '<div class="blog-item-wrapper"  ' . $item_id . $margin_style . '>';
			
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

			// if( $settings['enable-sticky'] == 'enable' ){
				// if( get_query_var('paged') <= 1 ){
					// $sticky_args = $args;
					// $sticky_args['post__in'] = get_option('sticky_posts');
					// if( !empty($sticky_args['post__in']) ){
						// $sticky_query = new WP_Query($sticky_args);	
					// }
				// }
				// $args['post__not_in'] = get_option('sticky_posts', '');
			// }else{
				// $args['ignore_sticky_posts'] = 1;
			// }
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
			$args['paged'] = empty($args['paged'])? 1: $args['paged'];
			$query = new WP_Query( $args );
			$settings['title-num-fetch'] = (empty($settings['title-num-fetch']))? '20': $settings['title-num-fetch'];

			// merge query
			// if( !empty($sticky_query) ){
				// $query->posts = array_merge($sticky_query->posts, $query->posts);
				// $query->post_count = $sticky_query->post_count + $query->post_count;
			// }

			// set the excerpt length
			if( !empty($settings['num-excerpt']) ){
				global $kode_excerpt_length; $kode_excerpt_length = $settings['num-excerpt'];
				add_filter('excerpt_length', 'kode_set_excerpt_length');
			} 
			
			// get blog by the blog style
			global $kode_post_settings, $kode_lightbox_id;
			$kode_lightbox_id++;
			$kode_post_settings['excerpt'] = intval($settings['num-excerpt']);
			//$kode_post_settings['thumbnail-size'] = $settings['thumbnail-size'];			
			$kode_post_settings['blog-style'] = $settings['blog-style'];			
			
			$ret .= '<div class="blog-item-holder">';
			if($settings['blog-style'] == 'blog-full'){
				$ret .= '<div class="kode-blog-list kode-fullwidth-blog row">';
				$kode_post_settings['thumbnail-size'] = 'kode-blog-post-size';
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= kode_get_blog_full($query);
				$ret .= '</div>';
			}else if($settings['blog-style'] == 'blog-medium'){
				$ret .= '<div class="kode-blog-list kode-medium-blog row">';
				$kode_post_settings['thumbnail-size'] = 'kode-small-grid-size';
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= kode_get_blog_medium($query);			
				$ret .= '</div>';
			}else if(strpos($settings['blog-style'], 'blog-grid') !== false){
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$blog_size = $settings['blog-size'];
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= '<div class="kode-blog-list kode-grid-blog row">';
				$ret .= kode_get_blog_grid($query, $blog_size, '');			
				$ret .= '</div>';
			}else if(strpos($settings['blog-style'], 'blog-cricket') !== false){
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$blog_size = $settings['blog-size'];
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= '<div class="kode-blog-list crkt-latestnews">
				<div class="crkt-hd">
                    <h6>Latest News &amp; Updates ...</h6>
                </div>';
				$ret .= kode_get_blog_cricket($query, $blog_size, '');			
				$ret .= '</div>';
			}else if(strpos($settings['blog-style'], 'blog-modern') !== false){
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$blog_size = $settings['blog-size'];
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= '<div class="kode-blog-list kode-grid-blog row">';
				$ret .= kode_get_blog_modern($query, $blog_size, '');			
				$ret .= '</div>';
			}else if(strpos($settings['blog-style'], 'blog-small') !== false){
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$blog_size = $settings['blog-size'];
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= '<div class="kode-blog-list kode-box-blog row">';
				$ret .= kode_get_blog_small($query, $blog_size, '');			
				$ret .= '</div>';		
			}else if(strpos($settings['blog-style'], 'blog-simple') !== false){
				$kode_post_settings['thumbnail-size'] = 'kode-post-thumbnail-size';
				$blog_size = $settings['blog-size'];
				$kode_post_settings['title-num-fetch'] = $settings['title-num-fetch'];
				$ret .= '<div class="kode-blog-list kode-box-blog row">';
				$ret .= kode_get_blog_simple($query, $blog_size, '');
				$ret .= '</div>';		
			}else{
				$blog_size = str_replace('blog-1-', '', $settings['blog-style']);
				$ret .= kode_get_blog_grid($query, $blog_size, '');
			}
			$ret .= '</div>';
			
			if( $settings['pagination'] == 'enable' ){
				$ret .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			$ret .= '</div>'; // blog-item-wrapper
			
			
			return $ret;
		}
	}

	if( !function_exists('kode_get_blog_info') ){
		function kode_get_blog_info( $array = array(), $wrapper = true, $sep = '',$custom_wrap='div' ){
			global $kode_theme_option; $ret = '';
			if( empty($array) ) return $ret;
			$exclude_meta = empty($kode_theme_option['post-meta-data'])? array(): esc_attr($kode_theme_option['post-meta-data']);
			
			foreach($array as $post_info){
				if( in_array($post_info, $exclude_meta) ) continue;
				if( !empty($sep) ) $ret .= $sep;
				
				switch( $post_info ){
					case 'date':
						$ret .= '<'.esc_attr($custom_wrap).' class="blog-info blog-date"><i class="fa fa-clock-o"></i>';
						$ret .= '<a href="' . esc_url(get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d'))) . '">';
						$ret .= esc_attr(get_the_time());
						$ret .= '</a>';
						$ret .= '</'.esc_attr($custom_wrap).'>';	
						break;
					case 'tag':
						$tag = get_the_term_list(get_the_ID(), 'post_tag', '', '<span class="sep">,</span> ' , '' );
						if(empty($tag)) break;					
						$ret .= '<'.esc_attr($custom_wrap).' class="blog-info blog-tag"><i class="fa fa-tag"></i>';
						$ret .= $tag;						
						$ret .= '</'.esc_attr($custom_wrap).'>';						
						break;
					case 'category':
						$category = get_the_term_list(get_the_ID(), 'category', '', '<span class="sep">,</span> ' , '' );
						if(empty($category)) break;
						
						$ret .= '<'.esc_attr($custom_wrap).' class="blog-info blog-category"><i class="fa fa-list"></i>';
						$ret .= $category;					
						$ret .= '</'.esc_attr($custom_wrap).'>';					
						break;
					case 'comment':
						$ret .= '<'.esc_attr($custom_wrap).' class="blog-info blog-comment"><i class="fa fa-comment-o"></i>';
						$ret .= '<a href="' . esc_url(get_permalink()) . '#respond" >' . esc_attr(get_comments_number()) . ' ' . esc_html__('Comment','kickoff').'</a>';						
						$ret .= '</'.esc_attr($custom_wrap).'>';							
						break;
					case 'author':
						ob_start();
						the_author_posts_link();
						$author = ob_get_contents();
						ob_end_clean();
						
						$ret .= '<'.esc_attr($custom_wrap).' class="blog-info blog-author"><i class="fa fa-user"></i>';
						$ret .= $author;
						$ret .= '</'.esc_attr($custom_wrap).'>';						
						break;						
				}
			}
			
			
			if($wrapper && !empty($ret)){
				return '<div class="kode-blog-info kode-info">' . $ret . '<div class="clear"></div></div>';
			}else if( !empty($ret) ){
				return $ret;
			}
			return '';
		}
	}
	
	
	if( !function_exists('kode_get_blog_simple') ){
		function kode_get_blog_simple($query, $size){
			$ret = ''; $current_size = 0;
			
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-simple">';
				$ret .= '<div class="kode-ux kode-blog-simple-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // kode-item			
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
			
		}
	}	
	
	
	if( !function_exists('kode_get_blog_modern') ){
		function kode_get_blog_modern($query, $size){
			$ret = ''; $current_size = 0;
			
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-modern">';
				$ret .= '<div class="kode-ux kode-blog-modern-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // kode-item			
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
			
		}
	}	
	
	

	if( !function_exists('kode_get_blog_widget') ){
		function kode_get_blog_widget($query, $size){
			$ret = ''; $current_size = 0;
			
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-widget">';
				$ret .= '<div class="kode-ux kode-blog-widget-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // kode-item			
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}
	

	if( !function_exists('kode_get_news_medium') ){
		function kode_get_news_medium($query, $size){
			
			$ret = ''; $current_size = 0;
			
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="news-listing kd-mediumview">';
				$ret .= '<div class="kode-item kode-news-grid">';
				ob_start();
				
				get_template_part('single/content_news');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // kode-item			
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			//$ret .= '</div>'; // close the kode-isotope
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	if( !function_exists('kode_get_news_full') ){
		function kode_get_news_full($query, $size){
			
			$ret = ''; $current_size = 0;
			$size = 3;
			//$ret .= '<div class="kode-isotope" data-type="blog" data-layout="' . $blog_layout  . '" >';
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-news-grid-ux">';
				ob_start();
				
				get_template_part('single/content_news');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux		
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			//$ret .= '</div>'; // close the kode-isotope
			wp_reset_postdata();
			
			return $ret;
		}
	}	
	
	if( !function_exists('kode_get_news_grid') ){
		function kode_get_news_grid($query, $size){
			
			$ret = ''; $current_size = 0;
			
			//$ret .= '<div class="kode-isotope" data-type="blog" data-layout="' . $blog_layout  . '" >';
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="news-listing">';
				$ret .= '<div class="kode-ux kode-item">';
				ob_start();
				
				get_template_part('single/content_news');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // news-listing		
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			//$ret .= '</div>'; // close the kode-isotope
			wp_reset_postdata();
			
			return $ret;
		}
	}	
	
	if( !function_exists('kode_get_blog_grid') ){
		function kode_get_blog_grid($query, $size, $blog_layout = 'fitRows'){
			if($blog_layout == 'carousel'){ return kode_get_blog_grid_carousel($query, $size); }
		
			$ret = ''; $current_size = 0;
			
			//$ret .= '<div class="kode-isotope" data-type="blog" data-layout="' . $blog_layout  . '" >';
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-grid-ux">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux				
				$ret .= '</div>'; // column_class
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			//$ret .= '</div>'; // close the kode-isotope
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	
	if( !function_exists('kode_get_blog_small') ){
		function kode_get_blog_small($query, $size, $blog_layout = 'fitRows'){
			
			$ret = ''; $current_size = 0;
			
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clearfix clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-ux kode-blog-small-ux">';
				ob_start();
				
				get_template_part('single/content');
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
	
	
	if( !function_exists('kode_get_blog_grid_carousel') ){
		function kode_get_blog_grid_carousel($query, $size){
			$ret = ''; 
			
			$ret .= '<div class="kode-blog-carousel-item kode-item" >';
			$ret .= '<div class="flexslider" data-type="carousel" data-nav-container="blog-item-holder" data-columns="' . esc_attr($size) . '" >';	
			$ret .= '<ul class="slides" >';			
			while($query->have_posts()){ $query->the_post();
				$ret .= '<li class="kode-item kode-blog-grid">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();					
				$ret .= '</li>'; // kode-item
			}
			$ret .= '</ul>';
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // close the flexslider
			$ret .= '</div>'; // close the kode-item
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	if( !function_exists('kode_get_blog_medium') ){
		function kode_get_blog_medium($query){
			$ret = '';$current_size = 0;
			$size = 2;
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}

				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-medium">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux			
				$ret .= '</div>'; // kode-item
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}		
	
	
	if( !function_exists('kode_get_blog_cricket') ){
		function kode_get_blog_cricket($query){
			$ret = '';$current_size = 0;
			$size = 2;
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}
				
				if( !is_single() ){
					global $kode_post_settings; 
					if($kode_post_settings['excerpt'] < 0) global $more; $more = 0;
				}	

			$post_format_data = '';
			$content = trim(get_the_content(esc_html__( 'Read More', 'kickoff' )));
			if(preg_match('#^<a.+href=[\'"]([^\'"]+).+</a>#', $content, $match)){ 
				$post_format_data = $match[1];
				$content = substr($content, strlen($match[0]));
			}else if(preg_match('#^https?://\S+#', $content, $match)){
				$post_format_data = $match[0];
				$content = substr($content, strlen($match[0]));
			}	
			
			if( !is_single() ){ 
				global $kode_post_settings; 
				if($kode_post_settings['excerpt'] < 0) global $more; $more = 0;
			}else{
				global $kode_post_settings, $kode_theme_option;
			}
			
			if(!isset($kode_post_settings['title-num-fetch']) && empty($kode_post_settings['title-num-fetch'])){
				$kode_post_settings['title-num-fetch'] = '21';
			}

				// $ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-cricket">';
				if($current_size % 2 == 0){
					ob_start();?>
					<div class="crkt-news">
						<div class="thumb">
							<?php get_template_part('single/thumbnail', get_post_format()) ?>
							<div class="crkt-cup">
								<span class="cup-name">
									Worldcup
								</span>
								<span class="cup-name crkt-date">
									<?php echo esc_attr(get_the_date('d/m/Y'));?>									
								</span>
							</div>
						</div>
						<div class="text">
							<h4><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h4>
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
									
								</div>';
									
								}
							?>
							<a class="crkt-icon" href="<?php echo esc_url(get_permalink())?>"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<?php
					$ret .= ob_get_contents();
					ob_end_clean();			
				}else{ 
					ob_start();?>
					<div class="crkt-news">
						<div class="text">
							<h4><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h4>
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
									
								</div>';
									
								}
							?>
							<a class="crkt-icon" href="<?php echo esc_url(get_permalink())?>"><i class="fa fa-plus"></i></a>
						</div>
						<div class="thumb">
							<?php get_template_part('single/thumbnail', get_post_format()) ?>
							<div class="crkt-cup">
								<span class="cup-name">
									Worldcup
								</span>
								<span class="cup-name crkt-date">
									<?php echo esc_attr(get_the_date('d/m/Y'));?>									
								</span>
							</div>
						</div>
					</div>
					<?php					
					$ret .= ob_get_contents();
					ob_end_clean();
				}
				$ret .= '</div>'; // kode-ux			
				// $ret .= '</div>'; // kode-item
				$current_size ++;
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}
	
	
	if( !function_exists('kode_get_blog_full') ){
		function kode_get_blog_full($query){
			$ret = '';$current_size = 0;
		
			$size = 1;
			while($query->have_posts()){ $query->the_post();
				if( $current_size % $size == 0 ){
					$ret .= '<div class="clear"></div>';
				}
				$ret .= '<div class="' . esc_attr(kode_get_column_class('1/' . $size)) . '">';
				$ret .= '<div class="kode-item kode-blog-full ">';
				ob_start();
				
				get_template_part('single/content');
				$ret .= ob_get_contents();
				
				ob_end_clean();			
				$ret .= '</div>'; // kode-ux
				$ret .= '</div>'; // kode-item
				$current_size++;
			}
			wp_reset_postdata();
			
			return $ret;
		}
	}	
	
	if( !function_exists('kode_get_blog_list_normal_item') ){
		function kode_get_blog_list_normal_item( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			//$ret  = kode_get_item_title($settings);
			$ret = '';
			$ret .= '<div class="blog-list-item-wrapper"  ' . $item_id . $margin_style . '>';
			
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

				// if( $settings['enable-sticky'] == 'enable' ){
					// if( get_query_var('paged') <= 1 ){
						// $sticky_args = $args;
						// $sticky_args['post__in'] = get_option('sticky_posts');
						// if( !empty($sticky_args['post__in']) ){
							// $sticky_query = new WP_Query($sticky_args);	
						// }
					// }
					// $args['post__not_in'] = get_option('sticky_posts', '');
				// }else{
					// $args['ignore_sticky_posts'] = 1;
				// }
				$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
				$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
				$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
				$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				$args['paged'] = empty($args['paged'])? 1: $args['paged'];
				$query = new WP_Query( $args );
				$ret = '
				<div class="video-blog-kickoff">
					<!--// CRICKET HEADIND //-->
					<div class="crkt-hd3">
						<h4>Latest Videos</h4>
					</div>
					<!--// CRICKET HEADIND //-->
					<!--// CRICKET VIDEO WRAP //-->
					<div class="crkt-event-wrap crkt-videos-wrap">';
					$settings['title-num-fetch'] = (empty($settings['title-num-fetch']))? '20': $settings['title-num-fetch'];
					while($query->have_posts()){
						$query->the_post();
						global $post;
							$ret .= '
							<div class="crkt-videos">
								<div class="thumb">
									<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(80,80)).'</a>
								</div>
								<div class="text">
									<h4><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,30)).'</a></h4>
									<p><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_content(),0,50)).'</a></p>
									<span>'.esc_attr(get_the_date('d/m/Y')).'</span>
								</div>
							</div>';			
					}
					$ret .= '
						<div class="crkt-viewmore">
							<a href="'.esc_url(get_permalink()).'">'.esc_attr__('View more','kickoff').'</a>
						</div>
					</div>
					<!--// CRICKET VIDEO WRAP //-->
				</div>
			</div>';
			return $ret;
		}
	}
	
	
	if( !function_exists('kode_get_blog_simple_slider_item') ){
		function kode_get_blog_simple_slider_item( $settings = array() ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			if(isset($settings['post-style']) && $settings['post-style'] == 'slider'){
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

				// if( $settings['enable-sticky'] == 'enable' ){
					// if( get_query_var('paged') <= 1 ){
						// $sticky_args = $args;
						// $sticky_args['post__in'] = get_option('sticky_posts');
						// if( !empty($sticky_args['post__in']) ){
							// $sticky_query = new WP_Query($sticky_args);	
						// }
					// }
					// $args['post__not_in'] = get_option('sticky_posts', '');
				// }else{
					// $args['ignore_sticky_posts'] = 1;
				// }
				$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
				$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
				$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
				// $args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				// $args['paged'] = empty($args['paged'])? 1: $args['paged'];
				$query = new WP_Query( $args );
				$ret = '
				<div class="crkt-posts">
					<div class="crkt-hd">
						<h6>'.esc_html_e('ICC Test Player Rankings ...','kickoff').'</h6>
					</div>
					<!--// CRICKET VIDEO WRAP //-->
					<div class="crkt-slider"><ul class="bxslider" data-min="1" data-max="1">';
					$settings['title-num-fetch'] = (empty($settings['title-num-fetch']))? '20': $settings['title-num-fetch'];
					while($query->have_posts()){
						$query->the_post();
						global $post;
							$ret .= '
							<li>
								<div class="thumb">
									'.get_the_post_thumbnail($post->ID, array(350,350)).'
									<div class="post-caption">
									  <small>'.esc_attr($get_post->post_title).'</small>
									  <h5><a href="'.esc_url(get_permalink()).'"><span>Number <b>1 Test</b></span> <b>Player </b>In World</a></h5>
									  <p>'.esc_attr(substr(get_the_content(),0,30)).'</p>
									</div>
								</div>
							</li>';			
					}
					$ret .= '
					</ul>
					<!--// CRICKET VIDEO WRAP //-->
				</div>
			</div>';
			}else{
				$settings['select_post'];
				$get_post = get_post($settings['select_post']);
				$ret .= '
				<div class="crkt-posts">
					<div class="crkt-hd">
						<h6>'.esc_html_e('Popular Posts','kickoff').'</h6>
					</div>
					<div class="thumb">
						'.get_the_post_thumbnail($post->ID, array(350,350)).'
						<div class="post-caption">
							<small>'.esc_attr($get_post->post_title).'</small>
							<h5><a href="'.esc_url(get_permalink()).'"><span><b>Boxing Day </b>Test </span> Victory for <b>England</b></a></h5>
							<p>'.esc_attr(get_the_date('D M Y')).'</p>
						</div>
					</div>
				</div>';
			}
			return $ret;
		}
	}
	
	

?>