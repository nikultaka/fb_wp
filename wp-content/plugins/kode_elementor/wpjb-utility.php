<?php
/**
* WPJB UTILITY
*
* @class    
* @author   Adeel Nazar
* @category core
* @package  includes/wpjb-utility
* @version  1.0
*/

	/**
	* Important Core Functions
	*/
	function wpjb_escape_content( $content ){
		return apply_filters('wpjb_escape_content', $content);
	}
	
	
	//Core Script Common in All Plugins and Theme Files
	if(!function_exists('wpha_get_thumbnail_list')){
		
		$wpha_thumbnail_size = array(
			'kode-full-slider' => array('width'=>1600, 'height'=>900, 'crop'=>true),
			'kode-post-thumbnail-size' => array('width'=>570, 'height'=>300, 'crop'=>true),
			'kode-team-size' => array('width'=>350, 'height'=>350, 'crop'=>true),
			'kode-small-grid-size' => array('width'=>240, 'height'=>260, 'crop'=>true),
			'kode-blog-small-size' => array('width'=>240, 'height'=>320, 'crop'=>true),
			'kode-causes-small-size' => array('width'=>370, 'height'=>250, 'crop'=>true),
			'kode-post-slider-side' => array('width'=>770, 'height'=>330, 'crop'=>true),
			'kode-blog-post-size' => array('width'=>1170, 'height'=>350, 'crop'=>true),
		);

		$wpha_thumbnail_size = apply_filters('custom-thumbnail-size', $wpha_thumbnail_size);
		// Create Sizes on the theme activation
		add_action( 'after_setup_theme', 'wpha_define_thumbnail_size' );
		if( !function_exists('wpha_define_thumbnail_size') ){
			function wpha_define_thumbnail_size(){
				add_theme_support( 'post-thumbnails' );
			
				global $wpha_thumbnail_size;		
				foreach($wpha_thumbnail_size as $wpha_size_slug => $wpha_size){
					add_image_size($wpha_size_slug, $wpha_size['width'], $wpha_size['height'], $wpha_size['crop']);
				}
			}
		}

		// add the image size filter to ThemeOptions
		add_filter('image_size_names_choose', 'wpha_define_custom_size_image');
		function wpha_define_custom_size_image( $sizes ){	
			$additional_size = array();
			
			global $wpha_thumbnail_size;
			foreach($wpha_thumbnail_size as $wpha_size_slug => $wpha_size){
				$additional_size[$wpha_size_slug] = $wpha_size_slug;
			}
			
			return array_merge($sizes, $additional_size);
		}

		// Get All The Sizes
		function wpha_get_thumbnail_list(){
			global $wpha_thumbnail_size;
			
			$sizes = array();
			foreach( get_intermediate_image_sizes() as $size ){
				if(in_array( $size, array( 'thumbnail', 'medium', 'large' )) ){
					$sizes[$size] = $size . ' -- ' . get_option($size . '_size_w') . 'x' . get_option($size . '_size_h');
				}else if( !empty($wpha_thumbnail_size[$size]) ){
					$sizes[$size] = $size . ' -- ' . $wpha_thumbnail_size[$size]['width'] . 'x' . $wpha_thumbnail_size[$size]['height'];
				}else{
				
				}
			}
			$sizes['full'] = esc_html__('full size (Real Images)', 'council');
			
			return $sizes;
		}

		// Get All The Sizes
		function wpha_get_thumbnail_list_emptyfirst(){
			global $wpha_thumbnail_size;
			
			$sizes = array('0'=>'');
			foreach( get_intermediate_image_sizes() as $size ){
				if(in_array( $size, array( 'thumbnail', 'medium', 'large' )) ){
					$sizes[$size . ' -- ' . get_option($size . '_size_w') . 'x' . get_option($size . '_size_h')] = $size;
				}else if( !empty($wpha_thumbnail_size[$size]) ){
					$sizes[$size . ' -- ' . $wpha_thumbnail_size[$size]['width'] . 'x' . $wpha_thumbnail_size[$size]['height']] = $size;
				}else{
				
				}
			}
			$sizes['full size (Real Images)'] = esc_html__('full', 'council');
			
			return $sizes;
		}	
		
	}
		
	// get image from image id/url
	if( !function_exists('wpjb_main_get_image_url') ){
		function wpjb_main_get_image_url( $image, $size = 'wpjb-full', $placeholder = true){
			if( is_numeric($image) ){
				$image_src = wp_get_attachment_image_src($image, $size);
				if( !empty($image_src) ) return $image_src[0];
			}else if( !empty($image) ){
				return $image;
			}

			if( is_admin() && $placeholder ){
				return WPJB_URL . '/include/images/logo.png';
			}
		}
	}

	if( !function_exists('wpjb_main_get_image') ){
		function wpjb_main_get_image( $image, $size = 'full', $settings = array() ){

			$ret = '';
			$full_image_url = '';
			$placeholder = isset($settings['placeholder'])? $settings['placeholder']: true;

			// get_image section
			if( is_numeric($image) ){
				$alt_text = get_post_meta($image , '_wp_attachment_image_alt', true);	
				$image_src = wp_get_attachment_image_src($image, $size);	
				$full_image_url = wpjb_main_get_image_url($image, NULL, $placeholder);

				if( !empty($image_src) ){
					$img_srcset = wpjb_main_get_image_srcset($image, $image_src);

					if( empty($img_srcset) ){
						$ret .= '<img src="' . esc_url($image_src[0]) . '" alt="' . esc_attr($alt_text) . '" ';
						$ret .= empty($image_src[1])? '': 'width="' . esc_attr($image_src[1]) .'" ';
						$ret .= empty($image_src[2])? '': 'height="' . esc_attr($image_src[2]) . '" ';
						$ret .= '/>';
					}else{
						$ret .= '<img ' . $img_srcset . ' alt="' . esc_attr($alt_text) . '" />';
					}
				}else if( is_admin() ){
					return '<img src="' . esc_url($full_image_url) . '" alt="" />';
				}else{
					return;
				}
			}else if( !empty($image) ){
				$full_image_url = $image;
				$ret .= '<img src="' . esc_url($image) . '" alt="" />';
			}else{
				if( is_admin() ){
					return '<img src="' . esc_url(wpjb_main_get_image_url('', NULL, $placeholder)) . '" alt="" />';
				}else{
					return;
				}
			}

			return $ret;
		}
	}

	// process data sent from the post variable
	if( !function_exists('wpjb_main_process_post_data') ){
		function wpjb_main_process_post_data( $post ){
			return stripslashes_deep($post);
		}
	}		

	// format data to specific type
	if( !function_exists('wpjb_main_format_datatype') ){
		function wpjb_main_format_datatype( $value, $data_type ){
			if( $data_type == 'color' ){
				return (strpos($value, '#') === false)? '#' . $value: $value; 
			}else if( $data_type == 'rgba' ){
				$value = str_replace('#', '', $value);
				if(strlen($value) == 3) {
					$r = hexdec(substr($value,0,1) . substr($value,0,1));
					$g = hexdec(substr($value,1,1) . substr($value,1,1));
					$b = hexdec(substr($value,2,1) . substr($value,2,1));
				}else{
					$r = hexdec(substr($value,0,2));
					$g = hexdec(substr($value,2,2));
					$b = hexdec(substr($value,4,2));
				}
				return $r . ', ' . $g . ', ' . $b;
			}else if( $data_type == 'text' ){
				return trim($value);
			}else if( $data_type == 'pixel' ){
				return (is_numeric($value))? $value . 'px': $value;
			}else if( $data_type == 'file' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'image' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'font_option'){
				return trim($value);
			}else if( $data_type == 'percent' ){
				return (is_numeric($value))? $value . '%': $value;
			}else if( $data_type == 'opacity' ){
				return $value;
			} 
		}
	}	

	// retrieve all categories from each post type
	if( !function_exists('wpjb_main_get_taxonomies') ){	
		function wpjb_main_get_taxonomies(){

			$taxonomy = get_taxonomies();
			unset($taxonomy['nav_menu']);
			unset($taxonomy['link_category']);
			unset($taxonomy['post_format']);

			return $taxonomy;

		}
	}

	// retrieve all categories from each post type
	if( !function_exists('wpjb_main_get_term_list') ){	
		function wpjb_main_get_term_list( $taxonomy, $cat = '', $with_all = false ){
			$term_atts = array(
				'taxonomy'=>$taxonomy, 
				'hide_empty'=>0,
				'number'=>999
			);
			if( !empty($cat) ){
				if( is_array($cat) ){
					$term_atts['slug'] = $cat;
				}else{
					$term_atts['parent'] = $cat;
				}
			}
			$term_list = get_categories($term_atts);

			$ret = array();
			if( !empty($with_all) ){
				$ret[$cat] = esc_html__('All', 'system-core'); 
			}

			if( !empty($term_list) ){
				foreach( $term_list as $term ){
					if( !empty($term->slug) && !empty($term->name) ){
						$ret[$term->slug] = $term->name;
					}
				}
			}

			return $ret;
		}	
	}
	if( !function_exists('wpjb_main_get_term_list_id') ){	
		function wpjb_main_get_term_list_id( $taxonomy ){
			$term_atts = array(
				'taxonomy'=>$taxonomy, 
				'hide_empty'=>0,
				'number'=>999
			);

			$term_list = get_categories($term_atts);

			$ret = array();
			if( !empty($term_list) ){
				foreach( $term_list as $term ){
					if( !empty($term->term_id) && !empty($term->name) ){
						$ret[$term->term_id] = $term->name;
					}
				}
			}

			return $ret;
		}	
	}

	// retrieve all posts from each post type
	if( !function_exists('wpjb_main_get_post_list') ){	
		function wpjb_main_get_post_list( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>999));

			$ret = array();
			if( !empty($post_list) ){
				foreach( $post_list as $post ){
					$ret[$post->ID] = $post->post_title;
				}
			}
				
			return $ret;
		}	
	}

	// page builder content/text filer to execute the shortcode	
	if( !function_exists('wpjb_main_content_filter') ){
		add_filter( 'wpjb_main_the_content', 'wptexturize'        ); add_filter( 'wpjb_main_the_content', 'convert_smilies'    );
		add_filter( 'wpjb_main_the_content', 'convert_chars'      ); add_filter( 'wpjb_main_the_content', 'prepend_attachment' );	
		add_filter( 'wpjb_main_the_content', 'wpautop');
		add_filter( 'wpjb_main_the_content', 'shortcode_unautop');
		add_filter( 'wpjb_main_the_content', 'wpjb_main_do_shortcode', 11 );
		function wpjb_main_content_filter( $content, $main_content = false ){
			if($main_content) return str_replace( ']]>', ']]&gt;', apply_filters('the_content', $content) );
			
			$content = preg_replace_callback( '|("?https?://[^\s"<]+)|im', 'wpjb_main_content_oembed', $content );

			return apply_filters('wpjb_main_the_content', $content);
		}		
	}
	if( !function_exists('wpjb_main_content_oembed') ){
		function wpjb_main_content_oembed( $link ){

			if( substr($link[1], 0, 1) == '"' ){ 
				return $link[1]; 
			}

			if( preg_match('/youtube|youtu\.be|vimeo|spotify/', $link[1]) ){
				$html = wp_oembed_get($link[1]);
				
				if( $html ) return $html;
			}
			return $link[1];
		}
	}
	


	if( !function_exists('wpjb_main_remove_extra_p') ){
		function wpjb_main_remove_extra_p( $text ){
			return str_replace('<p></p>', '', $text);
		}
	}
	if( !function_exists('wpjb_main_text_filter') ){
		add_filter('wpjb_main_text_filter', 'do_shortcode', 11);
		function wpjb_main_text_filter( $text ){
			return apply_filters('wpjb_main_text_filter', $text);
		}
	}

	// check broken html tag
	if( is_admin() ){ 
		add_filter( 'wpjb_main_the_content', 'wpjb_main_content_validate'); 
		add_filter( 'wpjb_main_text_filter', 'wpjb_main_content_validate'); 
	}
	if( !function_exists('wpjb_main_content_validate') ){
		function wpjb_main_content_validate( $content ){
			$open_tag  = substr_count($content, '<div');
			$open_tag += substr_count($content, '<iframe');

			$close_tag  = substr_count($content, '</div');
			$close_tag += substr_count($content, '</iframe');
			
			if( $open_tag == $close_tag ){
				return $content;
			}else{
				return esc_html__('Please ensure that all html is opened and closed properly.', 'system-core');
			}
		}
	}

	// escape content with html
	if( !function_exists('wpjb_main_escape_content') ){
		function wpjb_main_escape_content( $content ){
			return apply_filters('wpjb_main_escape_content', $content);
		}
	}	

	// allow specific upload file format
	add_filter('upload_mimes', 'wpjb_main_custom_upload_mimes');
	if( !function_exists('wpjb_main_custom_upload_mimes') ){
		function wpjb_main_custom_upload_mimes( $existing_mimes = array() ){
			$existing_mimes['ttf'] = 'application/x-font-ttf';
			$existing_mimes['otf'] = 'application/x-font-opentyp'; 
			$existing_mimes['eot'] = 'application/vnd.ms-fontobject'; 
			$existing_mimes['woff'] = 'application/font-woff'; 
			$existing_mimes['svg'] = 'image/svg+xml'; 

			return $existing_mimes;
		}
	}

	// change the object to string
	if( !function_exists('wpjb_main_debug_object') ){
		function wpjb_main_debug_object( $object ){

			ob_start();
			print_r($object);
			$ret = ob_get_contents() . '<br><br>';
			ob_end_clean();

			return $ret;
		}
	}

	if( !function_exists('wpjb_main_get_image_srcset') ){
		function wpjb_main_get_image_srcset( $image_id, $image ){
			
			$enable_srcset = apply_filters('wpjb_main_enable_srcset', true);
			if( !$enable_srcset ) return;
			
			if( empty($image) || empty($image[0]) || empty($image[1]) || empty($image[2]) ) return;
			
			$srcset = '';
			
			// crop image
			$smallest_image = $image;
			$cropped_sizes = array(400, 600, 800);
			foreach( $cropped_sizes as $cropped_size ){
				if( $image[1] > $cropped_size + 100 ){
					$new_height = intval($cropped_size * intval($image[2]) / intval($image[1]));
					$cropped_image = wpjb_main_get_cropped_image( $image_id, $cropped_size, $new_height, false);
					
					if( !empty($cropped_image) ){
						$srcset .= empty($srcset)? '': ', ';
						$srcset .= $cropped_image . ' ' . $cropped_size . 'w';
						$smallest_image = array($cropped_image, $cropped_size, $new_height);
					}
				}
			}			

			if( !empty($srcset) ){
				// $ret  = ' src="' . esc_url($image[0]) . '" width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" ';
				$ret  = ' src="' . esc_url($smallest_image[0]) . '" width="' . esc_attr($image[1]) . '" height="' . esc_attr($image[2]) . '" ';
				$ret .= ' srcset="' . esc_attr($srcset) . ', ' . esc_attr($image[0]) . ' ' . esc_attr($image[1]) . 'w" ';
				
				// get screen size for query
				global $content_width, $wpjb_main_container, $wpjb_main_container_multiplier, $wpjb_main_item_multiplier;
				if( empty($wpjb_main_container) ){ wpjb_main_set_container(); }
				$column_size = intval(100 * $wpjb_main_container_multiplier * $wpjb_main_item_multiplier);
				$content_size = intval($wpjb_main_container * $wpjb_main_container_multiplier * $wpjb_main_item_multiplier);
				
				$sizes = '(max-width: 767px) 100vw';
				if( $wpjb_main_container >= 2560 ){
					$sizes .= ', ' . $column_size . 'vw';
				}else{
					$sizes .= ', (max-width: ' . $wpjb_main_container . 'px) ' . $column_size . 'vw';
					$sizes .= ', ' . $content_size . 'px';
				}
				
				$ret .= ' sizes="' . esc_attr($sizes) . '" ';
				return $ret;
			}

			return '';
		}
	}

	if( !function_exists('wpjb_main_get_cropped_image') ){
		function wpjb_main_get_cropped_image( $attachment_id = 0, $width, $height, $html = true ){
			if( empty($attachment_id) ){
				return;
			}

			$original_path = get_attached_file($attachment_id);
			$orig_info = pathinfo($original_path);
			$dir = $orig_info['dirname'];
			$ext = $orig_info['extension'];	

			$suffix = "{$width}x{$height}";
			$name = wp_basename($original_path, ".{$ext}");
			$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

			$attachment = wp_get_attachment_image_src($attachment_id, 'full');
			$destfileurl = str_replace($name, $name . '-' . $suffix, $attachment[0]);

			if( !file_exists($destfilename) ){

				// get attachment for resize && check if it's resizable
				$attachment_thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail');
				if( $attachment[1] == $attachment_thumbnail[1] && $attachment[2] == $attachment_thumbnail[2] ){
					return;
				}
			
				// crop an image
				$cropped_image = wp_get_image_editor($original_path);
				if( !is_wp_error($cropped_image) ) {
					$cropped_image->resize($width, $height, true);
					$cropped_image->save($destfilename);

					if( !$html ){
						return $destfileurl;
					}else{
						$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
						return '<img src="' . esc_url($destfileurl) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" alt="' . (empty($alt_text)? '': $alt_text) . '" >';
					}
				}
			}else{
				if( !$html ){
						return $destfileurl;
				}else{
					$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
					return '<img src="' . esc_url($destfileurl) . '" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" alt="' . (empty($alt_text)? '': $alt_text) . '" >';
				}
			}

		} // wpjb_main_get_cropped_image
	} // function_exists


	if( !function_exists('wpjb_main_to_shortcode') ){
		function wpjb_main_to_shortcode( $name, $atts, $content = null ){
			$ret = '[' . $name . ' ';
			foreach( $atts as $att_key => $att_val ){
				$ret .= $att_key . '="' . esc_attr($att_val) . '" ';
			}
			$ret .= ']';

			if( $content !== null ){
				$ret .= esc_html($content) . '[/' . $name . ']';
			}

			return $ret;
		}
	}


	if( !function_exists('wpjb_main_array_insert') ){
		function wpjb_main_array_insert($array, $position, $insert){

			if( !is_int($position) ){
				$position = array_search($position, array_keys($array)) + 1;
			}
			
			return array_slice($array, 0, $position) + $insert + array_slice($array, $position);
		}
	}

	// include utility function for uses 
	// make sure to call this function inside wp_enqueue_script action
	if( !function_exists('wpjb_main_include_utility_script') ){
		function wpjb_main_include_utility_script(){
			
			if( is_admin() ){
				wp_enqueue_style('google-Montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700');
			}
		
			wp_enqueue_style('font-awesome', WPJB_URL . '/css/font-awesome/css/font-awesome.min.css');
			wp_enqueue_style('font-elegant', WPJB_URL . '/css/elegant-font/style.css');
						
			wp_enqueue_style('wpjb-utility', WPJB_URL . '/css/utility.css');
			
			wp_enqueue_script('wpjb-utility', WPJB_URL . '/js/utility.js', array('jquery'), false, true);
			wp_localize_script('wpjb-utility', 'wpjb_utility', array(
				'confirm_head' => esc_html__('Just to confirm', 'system-core'),
				'confirm_text' => esc_html__('Are you sure to do this ?', 'system-core'),
				'confirm_sub' => esc_html__('* Please noted that this could not be undone.', 'system-core'),
				'confirm_yes' => esc_html__('Yes', 'system-core'),
				'confirm_no' => esc_html__('No', 'system-core'),
			));
			
		}
	}	

	// change any string to valid html id
	if( !function_exists('wpjb_main_string_to_slug') ){
		function wpjb_main_string_to_slug( $string ){
			// lower case everything
			$string = strtolower($string);
			
			// make alphanumeric (removes all other characters)
			$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
			
			// clean up multiple dashes or whitespaces
			$string = preg_replace("/[\s-_]+/", " ", $string);
			
			// remove space at the front and back
			$string = trim($string);
			
			// convert whitespaces and underscore to dash
			$string = preg_replace("/[\s_]/", "-", $string);

			return $string;
		}
	}

	// get all thumbnail name
	if( !function_exists('wpjb_main_get_thumbnail_list') ){
		function wpjb_main_get_thumbnail_list(){
			$ret = array();
			
			$thumbnails = get_intermediate_image_sizes();
			$ret['full'] = esc_html__('full size', 'system-core');
			foreach( $thumbnails as $thumbnail ) {
				if( !empty($GLOBALS['_wp_additional_image_sizes'][$thumbnail]) ){
					$width = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['width'];
					$height = $GLOBALS['_wp_additional_image_sizes'][$thumbnail]['height'];
				}else{
					$width = get_option($thumbnail . '_size_w', '');
					$height = get_option($thumbnail . '_size_h', '');
				}
				$ret[$thumbnail] = $thumbnail . ' ' . $width . '-' . $height;
			}
			return $ret;
		}
	}
	if( !function_exists('wpjb_main_get_video_size') ){
		function wpjb_main_get_video_size( $size = '' ){

			if( empty($size) || $size == 'full' ){
				return array( 'width'=>640, 'height'=>360 );
			}
			
			if( is_array($size) && ( $size['width'] == '100%' || $size['height'] == '100%') ){
				return array( 'width'=>640, 'height'=>360 );
			}
			
			if( !empty($GLOBALS['_wp_additional_image_sizes'][$size]) ){
				$width = $GLOBALS['_wp_additional_image_sizes'][$size]['width'];
				$height = $GLOBALS['_wp_additional_image_sizes'][$size]['height'];
				if( !empty($width) && !empty($height) ){
					return array( 'width'=>$width, 'height'=>$height );
				}
			}

			return array( 'width'=>640, 'height'=>360 );
		}
	}
	
	// gdlr esc size
	if( !function_exists('wpjb_main_esc_style') ){
		function wpjb_main_esc_style($atts, $wrap = true, $important = false){
			if( empty($atts) ) return '';
			$att_style = '';

			// special attribute
			if( !empty($atts['background-shadow-color']) ){
				if( !empty($atts['background-shadow-size']['size']) && $atts['background-shadow-opacity'] ){
					$bgs_sizex = empty($atts['background-shadow-size']['x'])? '0': $atts['background-shadow-size']['x'];
					$bgs_sizey = empty($atts['background-shadow-size']['y'])? '0': $atts['background-shadow-size']['y'];
					$bgs  = $bgs_sizex . ' ' . $bgs_sizey . ' ' . $atts['background-shadow-size']['size'] . ' ';
					$bgs .= 'rgba(' . wpjb_main_format_datatype($atts['background-shadow-color'], 'rgba') . ',' . $atts['background-shadow-opacity'] . ')';

					$att_style .= 'box-shadow: ' . $bgs . '; ';
					$att_style .= '-moz-box-shadow: ' . $bgs . '; ';
					$att_style .= '-webkit-box-shadow: ' . $bgs . '; ';
				}
			}
			unset($atts['background-shadow-color']);
			unset($atts['background-shadow-size']);
			unset($atts['background-shadow-opacity']);

			// normal attribute
			foreach($atts as $key => $value){
				if( empty($value) ) continue;
				
				switch($key){
					
					case 'blur': 
						if( !empty($value) ){
							$att_style .= "-webkit-filter: blur({$value});";
							$att_style .= "-moz-filter: blur({$value});";
							$att_style .= "-o-filter: blur({$value});";
							$att_style .= "-ms-filter: blur({$value});";
							$att_style .= "filter: blur({$value});";
						}
						break;

					case 'border-radius': 
						if( is_array($value) ){
							if( !empty($value['top']) || !empty($value['right']) || !empty($value['bottom']) || !empty($value['left']) ){
								$value = wp_parse_args($value, array('top'=>'0', 'right'=>'0', 'bottom'=>'0', 'left'=>'0'));
								$value = "{$value['top']} {$value['right']} {$value['bottom']} {$value['left']}";
							}else if( !empty($value['top-left']) || !empty($value['top-right']) || !empty($value['bottom-left']) || !empty($value['bottom-right']) ){
								$value = wp_parse_args($value, array('top-left'=>'0', 'top-right'=>'0', 'bottom-left'=>'0', 'bottom-right'=>'0'));
								$value = "{$value['t-left']} {$value['t-right']} {$value['b-left']} {$value['b-right']}";
							}else{
								$value = '';
							}
						}

						if( !empty($value) ){
							$att_style .= "border-radius: {$value};";
							$att_style .= "-moz-border-radius: {$value};";
							$att_style .= "-webkit-border-radius: {$value};";
						}
						break;
					
					case 'gradient': 
					case 'gradient-v': 
						if( is_array($value) && sizeOf($value) > 1 ){
							$atts = '';
							if( $key == 'gradient-v' ){
								$atts = 'to right, ';
							}

							if( is_array($value[0]) ){
								$rgba_value = wpjb_main_format_datatype($value[0][0], 'rgba');
								$color1 = "rgba({$rgba_value}, {$value[0][1]})";
							}else{
								$color1 = $value[0];
							}
							if( is_array($value[1]) ){
								$rgba_value = wpjb_main_format_datatype($value[1][0], 'rgba');
								$color2 = "rgba({$rgba_value}, {$value[1][1]})";
							}else{
								$color2 = $value[1];
							}

							$att_style .= "background: linear-gradient({$atts}{$color1}, {$color2});";
							$att_style .= "-moz-background: linear-gradient({$atts}{$color1}, {$color2});";
							$att_style .= "-o-background: linear-gradient({$atts}{$color1}, {$color2});";
							$att_style .= "-webkit-background: linear-gradient({$atts}{$color1}, {$color2});";
						}
						break;
					
					case 'background':
					case 'background-color':
						if( is_array($value) ){
							$rgba_value = wpjb_main_format_datatype($value[0], 'rgba');
							$att_style .= "{$key}: rgba({$rgba_value}, {$value[1]}) " . ($important? ' !important': '') . ";";
						}else{
							$att_style .= "{$key}: {$value} " . ($important? ' !important': '') . ";";
						}
						break;

					case 'background-image':
						if( $value == 'none' ){
							$att_style .= "background-image: none;";
						}else if( is_numeric($value) ){
							$image_url = wpjb_main_get_image_url($value);
							if( !empty($image_url) ){
								$att_style .= "background-image: url({$image_url}) " . ($important? ' !important': '') . ";";
							}
						}else{
							$att_style .= "background-image: url({$value}) " . ($important? ' !important': '') . ";";
						}
						break;
					
					case 'padding':
					case 'margin':
					case 'border-width':
						if( is_array($value) ){
							if( !empty($value['top']) && !empty($value['right']) && !empty($value['bottom']) && !empty($value['left']) ){
								$att_style .= "{$key}: {$value['top']} {$value['right']} {$value['bottom']} {$value['left']}" . ($important? ' !important': '') . ";";
							}else{
								foreach($value as $pos => $val){
									if( $pos != 'settings' && (!empty($val) || $val === '0') ){
										if( $key == 'border-width' ){
											$att_style .= "border-{$pos}-width: {$val}" . ($important? ' !important': '') . ";";
										}else{
											$att_style .= "{$key}-{$pos}: {$val}" . ($important? ' !important': '') . ";";
										}
									}
								}
							}
						}else{
							$att_style .= "{$key}: {$value};";
						}
						break;
					
					default: 
						$value = is_array($value)? ((empty($value[0]) || $value[0] === '0')? '': $value[0]): $value;
						$att_style .= "{$key}: {$value} " . ($important? ' !important': '') . ";";
				}
			}
			
			if( !empty($att_style) ){
				if( $wrap ){
					return 'style="' . esc_attr($att_style) . '" ';
				}
				return $att_style;
			}
			return '';
		}
	}
	