<?php 
	/*	
	*	Kodeforest Framework File
	*	---------------------------------------------------------------------
	*	This file includes the functions to run the plugins - Theme Options
	*	---------------------------------------------------------------------
	*/

	if(is_ssl()){
		define('KODE_HTTP', 'https://');
	}else{
		define('KODE_HTTP', 'http://');
	}
	
	//Data validation HTMl
	if( !function_exists('kode_esc_html') ){	
		function kode_esc_html ($html) {
			return esc_html($html);
		}
	}	
	
	//Data Validation
	if( !function_exists('kode_esc_html_excerpt') ){	
		function kode_esc_html_excerpt ($html) {
			return esc_html(strip_tags($html));
		}
	}
	//Get the Theme Options
	if(isset($_GET['preset']) && is_numeric($_GET['preset'])){
		global $kode_theme_option_class;
		$kode_theme_option = $kode_theme_option_class->value;			
		if(empty($kode_theme_option)){
			$kode_theme_option = get_option(KODE_SMALL_TITLE . '_admin_option', array());	
		}
	}else{
		$kode_theme_option = get_option(KODE_SMALL_TITLE . '_admin_option', array());	
	}
	
	
	//Define the content width - Clearing the ThemeCheck
	$kode_theme_option['content-width'] = 960;
	
	//Default Variables
	$kode_gallery_id = 0;
	$kode_lightbox_id = 0;
	$kode_crop_video = false;
	$kode_excerpt_length = 55;
	$kode_excerpt_read_more = true;
	$kode_wrapper_id = 0;
	
	
	
	$kode_thumbnail_size = array(
		'kode-full-slider' => array('width'=>1600, 'height'=>900, 'crop'=>true),
		'kode-post-thumbnail-size' => array('width'=>570, 'height'=>300, 'crop'=>true),
		'kode-team-size' => array('width'=>350, 'height'=>350, 'crop'=>true),
		'kode-small-grid-size' => array('width'=>240, 'height'=>260, 'crop'=>true),
		'kode-blog-small-size' => array('width'=>240, 'height'=>320, 'crop'=>true),
		'kode-causes-small-size' => array('width'=>370, 'height'=>250, 'crop'=>true),
		'kode-post-slider-side' => array('width'=>770, 'height'=>330, 'crop'=>true),
		'kode-blog-post-size' => array('width'=>1170, 'height'=>350, 'crop'=>true),
	);
	
	$kode_thumbnail_size = apply_filters('custom-thumbnail-size', $kode_thumbnail_size);
	// Create Sizes on the theme activation
	add_action( 'after_setup_theme', 'kode_define_thumbnail_size' );
	if( !function_exists('kode_define_thumbnail_size') ){
		function kode_define_thumbnail_size(){
			add_theme_support( 'post-thumbnails' );
		
			global $kode_thumbnail_size;		
			foreach($kode_thumbnail_size as $kode_size_slug => $kode_size){
				add_image_size($kode_size_slug, $kode_size['width'], $kode_size['height'], $kode_size['crop']);
			}
		}
	}
	
	// add the image size filter to ThemeOptions
	add_filter('image_size_names_choose', 'kode_define_custom_size_image');
	function kode_define_custom_size_image( $sizes ){	
		$additional_size = array();
		
		global $kode_thumbnail_size;
		foreach($kode_thumbnail_size as $kode_size_slug => $kode_size){
			$additional_size[$kode_size_slug] = $kode_size_slug;
		}
		
		return array_merge($sizes, $additional_size);
	}
	
	// Get All The Sizes
	function kode_get_thumbnail_list(){
		global $kode_thumbnail_size;
		
		$sizes = array();
		foreach( get_intermediate_image_sizes() as $size ){
			if(in_array( $size, array( 'thumbnail', 'medium', 'large' )) ){
				$sizes[$size] = $size . ' -- ' . get_option($size . '_size_w') . 'x' . get_option($size . '_size_h');
			}else if( !empty($kode_thumbnail_size[$size]) ){
				$sizes[$size] = $size . ' -- ' . $kode_thumbnail_size[$size]['width'] . 'x' . $kode_thumbnail_size[$size]['height'];
			}else{
			
			}
		}
		$sizes['full'] = esc_html__('full size (Real Images)', 'kickoff');
		
		return $sizes;
	}	
	
	function kode_get_thumbnail_list_vc(){
		global $kode_thumbnail_size;
		
		$sizes = array();
		$sizes[''] = esc_html__('0', 'kickoff');
		foreach( get_intermediate_image_sizes() as $size ){
			if(in_array( $size, array( 'thumbnail', 'medium', 'large' )) ){
				$sizes[$size . ' -- ' . get_option($size . '_size_w') . 'x' . get_option($size . '_size_h')] = $size;
			}else if( !empty($kode_thumbnail_size[$size]) ){
				$sizes[$size . ' -- ' . $kode_thumbnail_size[$size]['width'] . 'x' . $kode_thumbnail_size[$size]['height']] = $size;
			}else{
			
			}
		}
		$sizes['full'] = esc_html__('full size (Real Images)', 'kickoff');
		
		return $sizes;
	}
	
	
	// create page builder
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kf_function_utility.php');
	include_once(KODE_LOCAL_PATH . '/framework/kf_function_regist.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode-demo-options.php');
	
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kf_function_utility.php');	
	
	
	// Create Theme Options
	include_once(KODE_LOCAL_PATH . '/framework/include/kf_pagebuilder.php');	
	include_once(KODE_LOCAL_PATH . '/framework/include/kf_themeoption.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kode-include-script.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kode_google_fonts.php');
	
	// Frontend Assets & functions
		
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode_loadstyle.php');
	

	//Events
	if(class_exists('EM_Events')){
		include_once( KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode-events-options.php');
	}
	//WooCommerce
	if(class_exists('WooCommerce')){
		include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode-woo-options.php');
	}
	//IgnitionDeck
	if(class_exists('Deck')){
		include_once( KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode-igni-options.php');
	}
	
	
	// create page options
	include_once( KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode-post-options.php');
	
	//Frontend
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/elements/kf_media_center.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/elements/kode_page_elements.php');
	include_once( KODE_LOCAL_PATH . '/framework/include/kode_front_func/elements/kf_blogging.php');		
	
	// page builder template
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kf_themeoptions_html.php');	
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kf_theme_meta.php');
	
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kf_pagebuilder_backend.php');	
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kf_pagebuilder_meta.php');	
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/kf_pagebuilder_scripts.php');	
	
	
?>