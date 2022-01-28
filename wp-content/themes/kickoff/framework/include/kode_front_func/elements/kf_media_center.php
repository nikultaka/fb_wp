<?php
	/*	
	*	Kodeforest Media Center File
	*	---------------------------------------------------------------------
	*	This file contains functions that manage the media in the theme
	*	---------------------------------------------------------------------
	*/	

	
	if( !function_exists('kode_get_social_shares') ){
		function kode_get_social_shares(){	
			global $kode_theme_option;
			$thumbnail = array();
			$page_title = rawurlencode(get_the_title());
			$current_url = KODE_HTTP . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>
			<ul class="kode-team-network-kick">
				<?php if(isset($kode_theme_option['facebook-share']) && $kode_theme_option['facebook-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-facebook" href="http://www.facebook.com/share.php?u=<?php echo esc_url($current_url); ?>" data-original-title="Facebook"></a></li><?php }?>
				<?php if(isset($kode_theme_option['digg-share']) && $kode_theme_option['digg-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-digg" href="http://digg.com/submit?url=<?php echo esc_url($current_url); ?>&#038;title=<?php echo esc_attr($page_title); ?>" data-original-title="Digg"></a></li><?php }?>
				<?php if(isset($kode_theme_option['google-plus-share']) && $kode_theme_option['google-plus-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-google-plus" href="https://plus.google.com/share?url=<?php echo esc_url($current_url); ?>" data-original-title="Google"></a></li><?php }?>
				<?php if(isset($kode_theme_option['linkedin-share']) && $kode_theme_option['linkedin-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo esc_url($current_url); ?>&#038;title=<?php echo esc_attr($page_title); ?>" data-original-title="Linkedin"></a></li><?php }?>
				<?php if(isset($kode_theme_option['my-space-share']) && $kode_theme_option['my-space-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-steam" href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo esc_url($current_url); ?>" data-original-title="Myspace"></a></li><?php }?>
				<?php if(isset($kode_theme_option['pinterest-share']) && $kode_theme_option['pinterest-share'] == 'enable'){ $thumbnail_id = get_post_thumbnail_id( get_the_ID() );$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'large' ); ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($current_url); ?>&media=<?php echo esc_url($thumbnail[0]); ?>" data-original-title="Pinterest"></a></li><?php }?>
				<?php if(isset($kode_theme_option['reddit-share']) && $kode_theme_option['reddit-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-reddit" href="http://reddit.com/submit?url=<?php echo esc_url($current_url); ?>&#038;title=<?php echo esc_attr($page_title); ?>" data-original-title="Reddit"></a></li><?php }?>
				<?php if(isset($kode_theme_option['stumble-upon-share']) && $kode_theme_option['stumble-upon-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-stumbleupon" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url($current_url); ?>&#038;title=<?php echo esc_attr($page_title); ?>" data-original-title="Stumble"></a></li><?php }?>
				<?php if(isset($kode_theme_option['twitter-share']) && $kode_theme_option['twitter-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-twitter" href="http://twitter.com/home?status=<?php echo esc_attr(str_replace('%26%23038%3B', '%26', $page_title)) . ' - ' . esc_url($current_url); ?>" data-original-title="Twitter"></a></li><?php }?>
				<?php if(isset($kode_theme_option['instagram-share']) && $kode_theme_option['instagram-share'] == 'enable'){ ?><li><a title="" data-placement="top" data-toggle="tooltip" class="thbg-colorhover fa fa-instagram" href="http://instagram.com/home?status=<?php echo esc_attr(str_replace('%26%23038%3B', '%26', $page_title)) . ' - ' . esc_url($current_url); ?>" data-original-title="Instagram"></a></li><?php }?>
			
			</ul>
			<?php 
		}
	}
	
	$kode_header_social_icon = array(
		'delicious'		=> esc_html__('Delicius','kickoff'), 
		'digg'			=> esc_html__('Digg','kickoff'),
		'facebook'		=> esc_html__('Facebook','kickoff'), 
		'flickr'		=> esc_html__('Flickr','kickoff'),
		'google-plus' 	=> esc_html__('Google Plus','kickoff'),						
		'linkedin' 		=> esc_html__('Linkedin','kickoff'),		
		'pinterest' 	=> esc_html__('Pinterest','kickoff'),		
		'skype'			=> esc_html__('Skype','kickoff'),
		'stumble-upon' 	=> esc_html__('Stumble Upon','kickoff'),
		'tumblr' 		=> esc_html__('Tumblr','kickoff'),
		'twitter' 		=> esc_html__('Twitter','kickoff'),
		'vimeo' 		=> esc_html__('Vimeo','kickoff'),
		'youtube' 		=> esc_html__('Youtube','kickoff'),
		'instagram' 		=> esc_html__('Instagram','kickoff'),
	);	
	
	add_filter('kode_themeoption_panel', 'kode_register_header_social_option');
	if( !function_exists('kode_register_header_social_option') ){
		function kode_register_header_social_option( $array ){		
			if( empty($array['overall-elements']['options']) ) return $array;
			
			global $kode_header_social_icon;
			$header_social = array( 									
				'title' => esc_html__('Social Profile', 'kickoff'),
				'options' => array(
				)
			);
				
			foreach( $kode_header_social_icon as $social_slug => $social_name ){
				$header_social['options'][$social_slug . '-header-social'] = array(
					'title' => $social_name . ' ' . esc_html__('Social Profile', 'kickoff'),
					'type' => 'text',
					'description' => 'Enter URL of your social profile here.'
				);
				
			}
			
			$array['overall-elements']['options']['header-social'] = $header_social;
			return $array;
		}
	}
	
	
	
	if( !function_exists('kode_print_header_social') ){
		function kode_print_header_social(){
			global $kode_header_social_icon, $kode_theme_option;
			$type = empty($kode_theme_option['header-social-type'])? 'dark': $kode_theme_option['header-social-type'];
			
			foreach( $kode_header_social_icon as $social_slug => $social_name ){
				if( !empty($kode_theme_option[$social_slug . '-header-social']) ){ ?>
				<div class="social-icon">
					<a href="<?php echo esc_attr($kode_theme_option[$social_slug . '-header-social']); ?>" target="_blank" >
						<img width="32" height="32" src="<?php echo KODE_PATH . '/images/' . $type . '/social-icon/' . $social_slug . '.png'; ?>" alt="<?php echo esc_attr($social_name); ?>" />
					</a>
				</div>
				<?php				
				}
			}
			echo '<div class="clear"></div>';
		}
	}	
	
	if( !function_exists('kode_print_header_social_icon') ){
		function kode_print_header_social_icon($class=''){
			global $kode_header_social_icon, $kode_theme_option;
			$type = empty($kode_theme_option['header-social-type'])? 'dark': esc_attr($kode_theme_option['header-social-type']); ?>
			<ul class="<?php echo esc_attr($type).' '.$class;?> kode-team-network ">
				<?php if(isset($kode_theme_option['delicious-header-social']) && $kode_theme_option['delicious-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['delicious-header-social']);?>"><i class="fa fa-delicious"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['digg-header-social']) && $kode_theme_option['digg-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['digg-header-social']);?>"><i class="fa fa-digg"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['facebook-header-social']) && $kode_theme_option['facebook-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['facebook-header-social']);?>"><i class="fa fa-facebook"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['flickr-header-social']) && $kode_theme_option['flickr-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['flickr-header-social']);?>"><i class="fa fa-flickr"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['google-plus-header-social']) && $kode_theme_option['google-plus-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['google-plus-header-social']);?>"><i class="fa fa-google-plus"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['linkedin-header-social']) && $kode_theme_option['linkedin-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['linkedin-header-social']);?>"><i class="fa fa-linkedin"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['pinterest-header-social']) && $kode_theme_option['pinterest-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['pinterest-header-social']);?>"><i class="fa fa-pinterest"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['skype-header-social']) && $kode_theme_option['skype-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['skype-header-social']);?>"><i class="fa fa-skype"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['stumble-upon-header-social']) && $kode_theme_option['stumble-upon-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['stumble-upon-header-social']);?>"><i class="fa fa-stumbleupon"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['tumblr-header-social']) && $kode_theme_option['tumblr-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['tumblr-header-social']);?>"><i class="fa fa-tumblr"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['twitter-header-social']) && $kode_theme_option['twitter-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['twitter-header-social']);?>"><i class="fa fa-twitter"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['vimeo-header-social']) && $kode_theme_option['vimeo-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['vimeo-header-social']);?>"><i class="fa fa-vimeo-square"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['youtube-header-social']) && $kode_theme_option['youtube-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['youtube-header-social']);?>"><i class="fa fa-youtube"></i></a></li><?php }?>
				<?php if(isset($kode_theme_option['instagram-header-social']) && $kode_theme_option['instagram-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['instagram-header-social']);?>"><i class="fa fa-instagram"></i></a></li><?php }?>
			
			</ul>	
			<?php				
		}
	}
	
	if( !function_exists('kode_print_header_social_icon') ){
		function kode_print_header_social_icon($class=''){
			global $kode_header_social_icon, $kode_theme_option;
			$type = empty($kode_theme_option['header-social-type'])? 'dark': esc_attr($kode_theme_option['header-social-type']); ?>
			<ul class="<?php echo esc_attr($type).' '.$class;?> kode_football_top_social ">
				<?php if($kode_theme_option['delicious-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['delicious-header-social']);?>"><i class="fa fa-delicious"></i></a></li><?php }?>
				<?php if($kode_theme_option['digg-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['digg-header-social']);?>"><i class="fa fa-digg"></i></a></li><?php }?>
				<?php if($kode_theme_option['facebook-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['facebook-header-social']);?>"><i class="fa fa-facebook"></i></a></li><?php }?>
				<?php if($kode_theme_option['flickr-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['flickr-header-social']);?>"><i class="fa fa-flickr"></i></a></li><?php }?>
				<?php if($kode_theme_option['google-plus-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['google-plus-header-social']);?>"><i class="fa fa-google-plus"></i></a></li><?php }?>
				<?php if($kode_theme_option['linkedin-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['linkedin-header-social']);?>"><i class="fa fa-linkedin"></i></a></li><?php }?>
				<?php if($kode_theme_option['pinterest-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['pinterest-header-social']);?>"><i class="fa fa-pinterest"></i></a></li><?php }?>
				<?php if($kode_theme_option['skype-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['skype-header-social']);?>"><i class="fa fa-skype"></i></a></li><?php }?>
				<?php if($kode_theme_option['stumble-upon-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['stumble-upon-header-social']);?>"><i class="fa fa-stumbleupon"></i></a></li><?php }?>
				<?php if($kode_theme_option['tumblr-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['tumblr-header-social']);?>"><i class="fa fa-tumblr"></i></a></li><?php }?>
				<?php if($kode_theme_option['twitter-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['twitter-header-social']);?>"><i class="fa fa-twitter"></i></a></li><?php }?>
				<?php if($kode_theme_option['vimeo-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['vimeo-header-social']);?>"><i class="fa fa-vimeo-square"></i></a></li><?php }?>
				<?php if($kode_theme_option['youtube-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['youtube-header-social']);?>"><i class="fa fa-youtube"></i></a></li><?php }?>
				<?php if($kode_theme_option['instagram-header-social'] <> ''){ ?><li><a href="<?php echo esc_url($kode_theme_option['instagram-header-social']);?>"><i class="fa fa-instagram"></i></a></li><?php }?>
			
			</ul>	
			<?php				
		}
	}
	
	add_filter('kode_themeoption_panel', 'kode_register_social_shares_option');
	if( !function_exists('kode_register_social_shares_option') ){
		function kode_register_social_shares_option( $array ){	
			if( empty($array['overall-elements']['options']) ) return $array;
			
			$kode_social_shares = array(
				'digg'			=> esc_html__('Digg','kickoff'),			
				'facebook'		=> esc_html__('Facebook','kickoff'), 
				'google-plus' 	=> esc_html__('Google Plus','kickoff'),	
				'linkedin' 		=> esc_html__('Linkedin','kickoff'),
				'my-space' 		=> esc_html__('My Space','kickoff'),
				'pinterest' 	=> esc_html__('Pinterest','kickoff'),
				'reddit' 		=> esc_html__('Reddit','kickoff'),
				'stumble-upon' 	=> esc_html__('Stumble Upon','kickoff'),
				'twitter' 		=> esc_html__('Twitter','kickoff'),
				'instagram' 		=> esc_html__('Instagram','kickoff'),
			);	
			$header_social = array( 									
				'title' => esc_html__('Social Shares', 'kickoff'),
				'options' => array(
					'enable-social-share'=> array(
						'title' => esc_html__('Enable Social Share' ,'kickoff'),
						'type' => 'checkbox',
						'description' => 'Enable this option to show the social shares below each post'
					)
				)
			);
				
			foreach( $kode_social_shares as $social_slug => $social_name ){
				$header_social['options'][$social_slug . '-share'] = array(
					'title' => $social_name,
					'type' => 'checkbox',
					'description' => 'Enable this option to show the social Icon under post.'					
				);
			}
			
			$array['overall-elements']['options']['social-shares'] = $header_social;
			return $array;
		}
	}	
	
	if( !function_exists('kode_get_video') ){
		function kode_get_video($video, $size = 'full'){
			if( empty($video) ) return '';
			
			$video_size = kode_get_video_size($size);
			$width = $video_size['width']; 
			$height = $video_size['height']; 

			// video shortcode
			if(preg_match('#^\[video\s.+\[/video\]#', $video, $match)){ 
				return do_shortcode($match[0]);
				
			// embed shortcode
			}else if(preg_match('#^\[embed.+\[/embed\]#', $video, $match)){ 
				global $wp_embed; 
				return $wp_embed->run_shortcode($match[0]);
				
			// youtube link
			}else if(strpos($video, 'youtube') !== false){
				preg_match('#[?&]v=([^&]+)(&.+)?#', $video, $id);
				$id[2] = empty($id[2])? '': $id[2];
				return '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $id[2] . '" width="' . $width . '" height="' . $height . '" ></iframe>';
			
			// youtu.be link
			}else if(strpos($video, 'youtu.be') !== false){
				preg_match('#youtu.be\/([^?&]+)#', $video, $id);
				return '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent" width="' . $width . '" height="' . $height . '" ></iframe>';
			
			// vimeo link
			}else if(strpos($video, 'vimeo') !== false){
				preg_match('#https?:\/\/vimeo.com\/(\d+)#', $video, $id);
				return '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
			
			// another link
			}else if(preg_match('#^https?://\S+#', $video, $match)){ 	
				$path_parts = pathinfo($match[0]);
				if( !empty($path_parts['extension']) ){
					return do_shortcode('[video width="' . $width . '" height="' . $height . '" src="' . esc_url($match[0]) . '" ][/video]');
				}else{
					global $wp_embed; 
					$video_embed = '[embed width="' . $width . '" height="' . $height . '" ]' . esc_url($match[0]) . '[/embed]';
					return $wp_embed->run_shortcode($video_embed);
				}				
			}
			return '';
		}
	}	
	
	// use for printing the image from  image id
	if( !function_exists('kode_get_image') ){
		function kode_get_image($image, $size = 'full', $link = array(), $attr = ''){
			if( empty($image) ) return '';
		
			if( is_numeric($image) ){
				$alt_text = get_post_meta($image , '_wp_attachment_image_alt', true);	
				$image_src = wp_get_attachment_image_src($image, $size);	
				if( empty($image_src) ) return '';
				
				if( $link === true ){ 
					$image_full = wp_get_attachment_image_src($image, 'full');
					$link = array('url'=>esc_url($image_full[0]));
				}else if( !empty($link) && empty($link['url']) ){
					$image_full = wp_get_attachment_image_src($image, 'full');
					$link['url'] = esc_url($image_full[0]);				
				}
				$ret = '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($alt_text) . '" width="' . esc_attr($image_src[1]) .'" height="' . esc_attr($image_src[2]) . '" ' . $attr . '/>';
			}else{
				if( $link === true ){ 
					$link = array('url'=>esc_url($image)); 
				}else if( !empty($link) && empty($link['url']) ){
					$link['url'] = esc_url($image);		
				}
				$ret = '<img src="' . esc_url($image) . '" alt="" ' . $attr . ' />';
			}
			
			if( !empty($link) ){
				$pretty_photo  = '<a href="' . esc_url($link['url']) . '" ';
				$pretty_photo .= (empty($link['id']))? '': 'data-rel="prettyphoto[]" data-pretty-group="kode-gal-' . $link['id'] . '" ';
				//$pretty_photo .= (!empty($link['type']) && $link['type'] == 'link')? 'data-rel="prettyphoto[]" ': '';
				$pretty_photo .= (!empty($link['type']) && $link['type'] == 'video')? 'data-pretty-type="iframe" ': '';
				$pretty_photo .= (!empty($link['new-tab']) && $link['new-tab'] == 'enable')? 'target="_blank" ': '';
				$pretty_photo .= '>' . $ret;
				$pretty_photo .= (!empty($link['close-tag']))? '': '</a>';
				return $pretty_photo;
			}
			return $ret;
		}
	}
	
	if( !function_exists('kode_get_attachment_info') ){
		function kode_get_attachment_info($attachment_id, $type = '') {
			$attachment = get_post($attachment_id);
			if( !empty($attachment) ){
				$ret = array(
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'title' => $attachment->post_title
				);
				
				if( !empty($type) ) return $ret[$type];
				return $ret;
			}
			return array();
		}	
	}	
	
	// use for printing slider
	if( !function_exists('kode_get_slider_item') ){
		function kode_get_slider_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' . esc_attr($settings['element-item-id']) . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			$settings['thumbnail-size'] = 'full';
			$ret  = '<div class="kode-item kode-slider-item" ' . $item_id . $margin_style . ' >';
			$ret .= kode_get_slider($settings['slider'], $settings['thumbnail-size'], $settings['slider-type']);
			$ret .= '</div>';
			return $ret;
		}
	}
	
	// use for printing post slider
	if( !function_exists('kode_get_post_slider_item') ){
		function kode_get_post_slider_item( $settings ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			$slide_order = array();
			$slide_data = array();
			
			// query posts section
			$args = array('post_type' => 'post', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['ignore_sticky_posts'] = 1;

			if( is_numeric($settings['category']) ){
				$args['category'] = (empty($settings['category']))? '': $settings['category'];	
			}else{ 
				if( !empty($settings['category']) || !empty($settings['tag']) ){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($settings['category']) ){
						array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'category', 'field'=>'slug'));
					}
					if( !empty($settings['tag']) ){
						array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'post_tag', 'field'=>'slug'));
					}				
				}	
			}
			$query = new WP_Query( $args );	
			
			// set the excerpt length
			global $kode_theme_option, $kode_excerpt_length, $kode_excerpt_read_more; 
			$kode_excerpt_read_more = false;
			$kode_excerpt_length = $settings['num-excerpt'];
			add_filter('excerpt_length', 'kode_set_excerpt_length');

			global $post;
			while($query->have_posts()){ $query->the_post();
				$image_id = get_post_thumbnail_id();
				
				if( !empty($image_id) ){
					$slide_order[] = $image_id;
					$slide_data[$image_id] = array(	
						'title'=> esc_attr(get_the_title()),
						'slide-link'=> 'url',
						'url'=> esc_url(get_permalink()),
						'new-tab'=> 'disable',
						'caption-position'=>$settings['caption-style']
					);
					
					if( $settings['style'] == 'no-excerpt' ){
						$slide_data[$image_id]['caption']  = '<div class="kode-caption-date" >';
						$slide_data[$image_id]['caption'] .= '<i class="fa fa-calendar"></i>';
						$slide_data[$image_id]['caption'] .= esc_attr(get_the_time(get_option('date_format')));				
						$slide_data[$image_id]['caption'] .= '</div>';				
						
						$slide_data[$image_id]['caption'] .= '<div class="kode-title-link" >';
						$slide_data[$image_id]['caption'] .= '<i class="fa fa-angle-right" ></i>';
						$slide_data[$image_id]['caption'] .= '</div>';		
					}else{
						$slide_data[$image_id]['caption']  = '<div class="blog-info blog-date"><i class="fa fa-calendar"></i>';
						$slide_data[$image_id]['caption'] .= esc_attr(get_the_time(get_option('date_format')));		
						$slide_data[$image_id]['caption'] .= '</div>';
						$slide_data[$image_id]['caption'] .= '<div class="blog-info blog-comment"><i class="fa fa-comment"></i>';
						$slide_data[$image_id]['caption'] .= esc_attr(get_comments_number());
						$slide_data[$image_id]['caption'] .= '</div>';					
						$slide_data[$image_id]['caption'] .= '<div class="clear"></div>';					
						$slide_data[$image_id]['caption'] .= '<p>'.esc_attr(get_the_excerpt()).'</p>';
					}
				}
			}	
			
			$kode_excerpt_read_more = true;
			
			
			if( $settings['style'] == 'no-excerpt' ){
				$settings['caption-style'] = 'no-excerpt';
			}
			
			$ret  = '<div class="kode-item kode-post-slider-item style-' . $settings['caption-style'] . '" ' . $item_id . $margin_style . ' >';
			$ret .= kode_get_slider(array($slide_order, $slide_data), $settings['thumbnail-size'], 'bxslider');
			$ret .= '</div>';
			return $ret;
		}
	}	
	
	// use for printing slider
	if( !function_exists('kode_get_slider') ){
		function kode_get_slider( $slider_data, $thumbnail_size, $slider_type = 'flexslider' ){
			if( is_array($slider_data) ){
				$slide_order = $slider_data[0];
				$slide_data = $slider_data[1];
			}else{
				$slider_option = json_decode($slider_data, true);
				$slide_order = $slider_option[0];
				$slide_data = $slider_option[1];			
			}
			
			$slides = array();
			$slide_order = empty($slide_order)? array(): $slide_order;
			foreach($slide_order as $slide){
				$slides[$slide] = $slide_data[$slide];
			}
				
			if($slider_type == 'flexslider'){
				return kode_get_flex_slider($slides, array('size'=> $thumbnail_size));
			}else if($slider_type == 'nivoslider'){
				return kode_get_nivo_slider($slides, array('size'=> $thumbnail_size));
			}else if($slider_type == 'bxslider'){
				return kode_get_bx_slider($slides, array('size'=> $thumbnail_size));
			}else{
				return 'slider is not defined';
			}
			
		}
	}	
	
	// use for printing flex slider
	if( !function_exists('kode_get_flex_slider') ){
		function kode_get_flex_slider($slides, $settings = array()){
			global $kode_theme_option, $kode_gallery_id; $kode_gallery_id++;
			
			$ret  = '<div class="flexslider" ';
			$ret .= empty($settings['pausetime'])? 'data-pausetime="' . esc_attr($kode_theme_option['flex-pause-time']) . '" ': 
						'data-pausetime="' . esc_attr($settings['pausetime']) . '" ';
			$ret .= empty($settings['slidespeed'])? 'data-slidespeed="' . esc_attr($kode_theme_option['flex-slide-speed']) . '" ': 
						'data-slidespeed="' . esc_attr($settings['slidespeed']) . '" ';			
			$ret .= empty($settings['effect'])? 'data-effect="' . esc_attr($kode_theme_option['flex-slider-effects']) . '" ': 
						'data-effect="' . esc_attr($settings['effect']) . '" ';	
						
			$ret .= empty($settings['columns'])? '': 'data-columns="' . esc_attr($settings['columns']) . '" ';
			$ret .= empty($settings['carousel'])? '': 'data-type="carousel" ';
			$ret .= empty($settings['nav-container'])? '': 'data-nav-container="' . esc_attr($settings['nav-container']) . '" ';
			$ret .= '>';
			$ret .= '<ul class="slides" >';
			$title_font_size = '';
			if(isset($kode_theme_option['title-font-size'])){
				if($kode_theme_option['title-font-size'] == 0){
					$title_font_size = 'font-size:'.esc_attr($kode_theme_option['title-font-size']).'px';
				}
			}
			$caption_font_size = '';
			if(isset($kode_theme_option['caption-font-size'])){
				if($kode_theme_option['caption-font-size'] == 0){
					$caption_font_size = 'font-size:'.esc_attr($kode_theme_option['caption-font-size']).'px';
				}
			}
			$slides = empty($slides)? array(): $slides;
			foreach($slides as $slide_id => $slide){
				$ret .= '<li>';
				
				if( is_array($slide) ){

					// flex slider caption
					$caption = '';
					if( !empty($slide['title']) || !empty($slide['caption']) ){
						$slide['caption-position'] = empty($slide['caption-position'])? 'left': esc_attr($slide['caption-position']);
					
						$caption .= '<div class="kode-caption-wrapper position-' . esc_attr($slide['caption-position']) . '">';
						$caption .= '<div class="kode-caption-inner" >';
						$caption .= '<div class="kode-caption">';
						$caption .= empty($slide['title'])? '': '<div style="'.$title_font_size.';color:'.esc_attr($kode_theme_option['caption-title-color']).'" class="kode-caption-title">' . esc_attr($slide['title']) . '</div>';
						$caption .= empty($slide['caption'])? '': '<div style="'.$caption_font_size.';color:'.esc_attr($kode_theme_option['caption-desc-color']).'" class="kode-caption-text">' . $slide['caption']. '</div>';
						$caption .= empty($slide['button_txt'])? '': '<div style="color:'.esc_attr($kode_theme_option['caption-btn-color']).';background:'.esc_attr($kode_theme_option['caption-btn-color-bg']).'" class="kode-linksection">' . esc_attr($slide['button_txt']) . '</div>';
						$caption .= '</div>'; // kode-slider-caption
						$caption .= '</div>'; // kode-slider-caption-wrapper
						$caption .= '</div>';
					}				
				
					// flex slider link
					if( empty($slide['slide-link']) || $slide['slide-link'] == 'none' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size'])) . $caption;
					}else if( $slide['slide-link'] == 'url' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'new-tab'=>esc_attr($slide['new-tab']), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'current' ){	
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'image' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'video' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'type'=>'video', 'id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}
				}else{
					$ret .= kode_get_image(esc_attr($slide), esc_attr($settings['size']), array('id'=>esc_attr($kode_gallery_id)));
				}
				$ret .= '</li>';
			}
			$ret .= '</ul>';
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	
	// use for printing bx slider
	if( !function_exists('kode_get_bx_slider') ){
		function kode_get_bx_slider($slides, $settings = array()){
			global $kode_theme_option, $kode_gallery_id; $kode_gallery_id++;
			
			$ret  = '<div class="kode-bxslider" ';
			$ret .= empty($settings['pausetime'])? 'data-pausetime="' . esc_attr($kode_theme_option['bx-pause-time']) . '" ': 
						'data-pausetime="' . esc_attr($settings['pausetime']) . '" ';
			$ret .= empty($settings['slidespeed'])? 'data-slidespeed="' . esc_attr($kode_theme_option['bx-slide-speed']) . '" ': 
						'data-slidespeed="' . esc_attr($settings['slidespeed']) . '" ';			
			$ret .= empty($settings['effect'])? 'data-effect="' . esc_attr($kode_theme_option['bx-slider-effects']) . '" ': 
						'data-effect="' . esc_attr($settings['effect']) . '" ';	
						
			$ret .= empty($settings['columns'])? '': 'data-columns="' . esc_attr($settings['columns']) . '" ';
			$ret .= empty($settings['carousel'])? '': 'data-type="carousel" ';
			//$ret .= empty($settings['nav-container'])? '': 'data-nav-container="' . $settings['nav-container'] . '" ';
			$ret .= '>';
			$ret .= '<ul class="bxslider" >';
			$title_font_size = '';
			if(isset($kode_theme_option['title-font-size'])){
				if($kode_theme_option['title-font-size'] == 0){
					$title_font_size = 'font-size:'.esc_attr($kode_theme_option['title-font-size']).'px';
				}
			}
			$caption_font_size = '';
			if(isset($kode_theme_option['caption-font-size'])){
				if($kode_theme_option['caption-font-size'] == 0){
					$caption_font_size = 'font-size:'.esc_attr($kode_theme_option['caption-font-size']).'px';
				}
			}
			$slides = empty($slides)? array(): $slides;
			foreach($slides as $slide_id => $slide){
				$ret .= '<li>';
				
				if( is_array($slide) ){

					// flex slider caption
					$caption = '';
					if( !empty($slide['title']) || !empty($slide['caption']) ){
						$slide['caption-position'] = empty($slide['caption-position'])? 'left': esc_attr($slide['caption-position']);
					
						$caption .= '<div class="kode-caption-wrapper position-' . esc_attr($slide['caption-position']) . '">';
						$caption .= '<div class="kode-caption-inner" >';
						$caption .= '<div class="kode-caption">';
						$caption .= empty($slide['title'])? '': '<div style="'.$title_font_size.';color:'.esc_attr($kode_theme_option['caption-title-color']).'" class="kode-caption-title">' . esc_attr($slide['title']) . '</div>';
						$caption .= empty($slide['caption'])? '': '<div style="'.$caption_font_size.';color:'.esc_attr($kode_theme_option['caption-desc-color']).'" class="kode-caption-text">' . $slide['caption']. '</div>';
						$caption .= empty($slide['button_txt'])? '': '<div style="color:'.esc_attr($kode_theme_option['caption-btn-color']).';background:'.esc_attr($kode_theme_option['caption-btn-color-bg']).'" class="kode-linksection">' . esc_attr($slide['button_txt']) . '</div>';
						$caption .= '</div>'; // kode-slider-caption
						$caption .= '</div>'; // kode-slider-caption-wrapper
						$caption .= '</div>';
					}				
				
					// bx slider link
					if( empty($slide['slide-link']) || $slide['slide-link'] == 'none' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size'])) . $caption;
					}else if( $slide['slide-link'] == 'url' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'new-tab'=>esc_attr($slide['new-tab']), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'current' ){	
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'image' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}else if( $slide['slide-link'] == 'video' ){
						$ret .= kode_get_image(esc_attr($slide_id), esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'type'=>'video', 'id'=>esc_attr($kode_gallery_id), 'close-tag'=>true));
						$ret .= $caption . '</a>';
					}
				}else{
					$ret .= kode_get_image($slide, esc_attr($settings['size']), array('id'=>esc_attr($kode_gallery_id)));
				}
				$ret .= '</li>';
			}
			$ret .= '</ul>';
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	// use for printing nivo slider
	if( !function_exists('kode_get_nivo_slider') ){
		function kode_get_nivo_slider($slides, $settings = array()){
			global $kode_theme_option, $kode_gallery_id; $kode_gallery_id++;
			
			$i = 0; $caption = '';
			$ret  = '<div class="nivoSlider-wrapper">';
			$ret .= '<div class="nivoSlider" ';
			$ret .= empty($settings['pausetime'])? 'data-pausetime="' . esc_attr($kode_theme_option['nivo-pause-time']) . '" ': 
						'data-pausetime="' . esc_attr($settings['pausetime']) . '" ';
			$ret .= empty($settings['slidespeed'])? 'data-slidespeed="' . esc_attr($kode_theme_option['nivo-slide-speed']) . '" ': 
						'data-slidespeed="' . esc_attr($settings['slidespeed']) . '" ';			
			$ret .= empty($settings['effect'])? 'data-effect="' . esc_attr($kode_theme_option['nivo-slider-effects']) . '" ': 
						'data-effect="' . esc_attr($settings['effect']) . '" ';
			$ret .= '>';
			$title_font_size = '';
			if(isset($kode_theme_option['title-font-size'])){
				if($kode_theme_option['title-font-size'] == 0){
					$title_font_size = 'font-size:'.esc_attr($kode_theme_option['title-font-size']).'px';
				}
			}
			$caption_font_size = '';
			if(isset($kode_theme_option['caption-font-size'])){
				if($kode_theme_option['caption-font-size'] == 0){
					$caption_font_size = 'font-size:'.esc_attr($kode_theme_option['caption-font-size']).'px';
				}
			}
			$slides = empty($slides)? array(): $slides;
			foreach($slides as $slide_id => $slide){ 
				if( is_array($slide) ){

					// nivo slider caption
					$id = 'nivo-caption' . $kode_gallery_id . '-' . $i; $i++;
					if( !empty($slide['title']) || !empty($slide['caption']) ){
						$slide['caption-position'] = empty($slide['caption-position'])? 'left': esc_attr($slide['caption-position']);
						
						$caption .= '<div class="kode-nivo-caption" id="' . $id . '" >';
						$caption .= '<div class="kode-caption-wrapper position-' . $slide['caption-position'] . '">';
						$caption .= '<div class="kode-caption-inner" >';
						$caption .= '<div class="kode-caption">';
						$caption .= empty($slide['title'])? '': '<div style="'.$title_font_size.';color:'.esc_attr($kode_theme_option['caption-title-color']).'" class="kode-caption-title">' . esc_attr($slide['title']) . '</div>';
						$caption .= empty($slide['caption'])? '': '<div style="'.$caption_font_size.';color:'.esc_attr($kode_theme_option['caption-desc-color']).'" class="kode-caption-text">' . $slide['caption']. '</div>';
						$caption .= empty($slide['button_txt'])? '': '<div style="color:'.esc_attr($kode_theme_option['caption-btn-color']).';background:'.esc_attr($kode_theme_option['caption-btn-color-bg']).'" class="kode-linksection">' . esc_attr($slide['button_txt']) . '</div>';
						$caption .= '</div>'; // kode-caption
						$caption .= '</div>'; // kode-caption-inner
						$caption .= '</div>'; // kode-caption-wrapper
						$caption .= '</div>'; // kode-nivo-caption
					}				
					
					// flex slider link
					$attr = ' title="#' . $id . '" '; 
					if( empty($slide['slide-link']) || $slide['slide-link'] == 'none' ){
						$ret .= kode_get_image($slide_id, esc_attr($settings['size']), array(), $attr);
					}else if( $slide['slide-link'] == 'url' ){
						$ret .= kode_get_image($slide_id, esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'new-tab'=>esc_attr($slide['new-tab'])), $attr);
					}else if( $slide['slide-link'] == 'current' ){	
						$ret .= kode_get_image($slide_id, esc_attr($settings['size']), 
							array('id'=>esc_attr($kode_gallery_id)), $attr);
					}else if( $slide['slide-link'] == 'image' ){
						$ret .= kode_get_image($slide_id, esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'id'=>esc_attr($kode_gallery_id)), $attr);
					}else if( $slide['slide-link'] == 'video' ){
						$ret .= kode_get_image($slide_id, esc_attr($settings['size']), 
							array('url'=>esc_url($slide['url']), 'type'=>'video', 'id'=>esc_attr($kode_gallery_id)), $attr);
					}
				}else{
					$ret .= kode_get_image($slide, esc_attr($settings['size']), array('id'=>$kode_gallery_id), $attr);
				}
			}
			$ret .= '</div>'; // nivoSlider
			$ret .= $caption;
			$ret .= '</div>'; // nivoSlider-wrapper
			
			return $ret;
		}
	}	
	
	// gallery item
	if( !function_exists('kode_get_gallery_item') ){
		function kode_get_gallery_item( $settings ){
			// title section	
			//$ret .= kode_get_item_title($settings);		
			$ret = '';
			$slider_option = json_decode($settings['slider'], true);
			
			$slide_order = $slider_option[0];
			$slide_data = $slider_option[1];					
			
			$slides = array();
			if(!empty($slide_order)){
				foreach( $slide_order as $slide_id ){
					$slides[$slide_id] = $slide_data[$slide_id];
				}
			}
			$settings['slider'] = $slides;
			
			//if( $settings['gallery-style'] == 'thumbnail' ) return kode_get_gallery_thumbnail($settings);
			return $ret . kode_get_gallery($settings);
		}
	}	
	
	// print gallery function
	if( !function_exists('kode_get_gallery') ){
		function kode_get_gallery( $settings ){
			global $kode_gallery_id,$counter, $kode_spaces; $kode_gallery_id++; 

			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			
			// start printing gallery
			$current_size = 0;
			$settings['num-fetch'] = empty($settings['num-fetch'])? 9999: intval($settings['num-fetch']);
			$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
			$num_page = ceil(sizeof($settings['slider']) / $settings['num-fetch']);
			
			$ret  = '<div class="kode-gallery kode-gutter-gallery bottom-spacer col-md-12"><ul class="row kode-item" ' . $item_id . $margin_style . '>';
			foreach($settings['slider'] as $slide_id => $slide){
				if( ($current_size >= ($paged - 1) * $settings['num-fetch']) &&
					($current_size < ($paged) * $settings['num-fetch']) ){

					if( !empty($current_size) && ($current_size % $settings['gallery-columns'] == 0) ){
						$ret .= '<li class="clear"></li>';
					}			
					$ret .= '<li class="gallery-item ' . kode_get_column_class('1/' . $settings['gallery-columns']) . '">';
					$ret .= '
					
					<figure class="kode-ux">';
						if( empty($slide['slide-link']) || $slide['slide-link'] == 'none' ){
							$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']));
						}else if($slide['slide-link'] == 'url' || $slide['slide-link'] == 'attachment'){		
							$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']), 
								array('url'=>esc_url($slide['url']), 'new-tab'=>esc_attr($slide['new-tab'])));				
						}else if($slide['slide-link'] == 'current'){
							$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']), 
								array('id'=>esc_attr($kode_gallery_id)));
						}else if($slide['slide-link'] == 'image'){
							$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']), 
								array('url'=>esc_url($slide['url']), 'id'=>esc_attr($kode_gallery_id)));
						}else if($slide['slide-link'] == 'video'){
							$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']), 
								array('url'=>esc_url($slide['url']), 'type'=>'video', 'id'=>$kode_gallery_id));
						}
						$image_src = wp_get_attachment_image_src($slide_id, 'full');	
						if(!isset($slide['gallery_caption'])){
							$slide['gallery_caption'] = '';
						}
						if(!isset($slide['gallery_title'])){
							$slide['gallery_title'] = '';
						}
						$ret .= '
						 <figcaption><a rel="prettyphoto[gallery]" data-gal="prettyphoto[gallery-'.$counter.']" class="kode-gallery-hover thbg-color" href="'.esc_url($image_src[0]).'"><i class="fa fa-plus"></i></a></figcaption>
					</figure>
					';
					if($settings['show-caption'] != 'no'){
						$ret .= '<span class="gallery-caption">' . kode_get_attachment_info($slide_id, 'caption') . '</span>';
					}
					//$ret .= '</div>'; // gallery item
					$ret .= '</li>'; // gallery column				
				}
				$current_size ++;
			}
			$ret .= '<li class="clear"></li>';
			
			
			$ret .= '</ul>'; // kode-gallery-item
			
			if( $settings['pagination'] == 'enable' ){
				$ret .= kode_get_pagination($num_page, $paged);
			}
			$ret .= '</div>'; // kode-gallery-item
			
			
			return $ret;
		}
	}
	if( !function_exists('kode_get_gallery_thumbnail') ){
		function kode_get_gallery_thumbnail( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' . esc_attr($settings['element-item-id']) . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . esc_attr($margin) . '" ': '';			
			
			$ret  = '<div class="kode-gallery-item kode-item kode-gallery-thumbnail" ' . $item_id . $margin_style . '>';
			
			// full image
			$ret .= '<div class="kode-gallery-thumbnail-container">';
			foreach($settings['slider'] as $slide_id => $slide){
				$ret .= '<div class="kode-gallery-thumbnail" data-id="' . $slide_id . '" >';
				$ret .= kode_get_image($slide_id);
				if($settings['show-caption'] != 'no'){
					$ret .= '<div class="gallery-caption-wrapper">';
					$ret .= '<span class="gallery-caption">';
					$ret .= kode_get_attachment_info($slide_id, 'caption');
					$ret .= '</span>';
					$ret .= '</div>';
				}
				$ret .= '</div>';
			}
			$ret .= '</div>';
			
			// start printing gallery
			$current_size = 0;
			foreach($settings['slider'] as $slide_id => $slide){
				if( !empty($current_size) && ($current_size % $settings['gallery-columns'] == 0) ){
					$ret .= '<div class="clear"></div>';
				}			
			
				$ret .= '<div class="gallery-column ' . kode_get_column_class('1/' . $settings['gallery-columns']) . '">';
				$ret .= '<div class="gallery-item" data-id="' . $slide_id . '" >';
				$ret .= kode_get_image($slide_id, esc_attr($settings['thumbnail-size']));
				$ret .= '</div>'; // gallery item
				$ret .= '</div>'; // gallery column
				$current_size ++;
			}
			$ret .= '<div class="clear"></div>';
			
			$ret .= '</div>'; // kode-gallery-item
			
			return $ret;
		}
	}	
	
	
	
		


?>