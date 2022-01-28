<?php
	/*	
	*	Kodeforest Include Script File
	*	---------------------------------------------------------------------
	*	This file use to include a necessary script when it's requires
	*	---------------------------------------------------------------------
	*/
	
	// Match the values
	if( !function_exists('kode_match_page_builder') ){
		function kode_match_page_builder($array, $item_type, $type, $data = array()){
			if(isset($array)){
				foreach($array as $item){
					if($item['item-type'] == $item_type && $item['type'] == $type){
						if(empty($data)){
							return true;
						}else{	
							if( strpos($item['option'][$data[0]], $data[1]) !== false ) return true;
						}
					}
					if($item['item-type'] == 'wrapper'){
						if( kode_match_page_builder($item['items'], $item_type, $type) ) return true;
					}
				}
			}
			return false;
		}
	}	
	//Add Scripts in Theme
	if(!is_admin()){
		add_action('wp_enqueue_scripts','kode_register_non_admin_styles');
		add_action('wp_enqueue_scripts','kode_register_non_admin_scripts');
		add_action( 'after_setup_theme', 'kode_theme_slug_editor_styles' );
	}
	
	// Register all Css
	if( !function_exists('kode_register_non_admin_styles') ){
		function kode_register_non_admin_styles(){	
			
			global $post,$post_id,$kode_content_raw,$kode_theme_option,$kode_font_controller;		
			
			wp_deregister_style('ignitiondeck-base');
			wp_deregister_style('woocommerce-layout');
			wp_deregister_style('flexslider');
			
			
			wp_enqueue_style( 'style', get_stylesheet_uri() );  //Default Stylesheet	
			
			wp_enqueue_style( 'svg-style', KODE_PATH . '/css/svg/svg-icon.css' );  //Font Awesome
			
			wp_enqueue_style( 'gutenberg', KODE_PATH . '/css/gutenberg.css' );  //gutenberg
			
			wp_enqueue_style( 'font-awesome', KODE_PATH . '/framework/include/frontend_assets/font-awesome/css/font-awesome.min.css' );  //Font Awesome
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'flexslider')) ){
				wp_enqueue_style( 'flexslider', KODE_PATH . '/framework/include/frontend_assets/flexslider/flexslider.css' );  //Font Awesome
			}
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'nivo-slider')) ){
				wp_enqueue_style( 'nivo-slider', KODE_PATH . '/framework/include/frontend_assets/nivo-slider/nivo-slider.css' );  //Font Awesome		
			}
			

			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'gallery') ){
				wp_enqueue_style( 'style-prettyphoto', KODE_PATH . '/framework/include/frontend_assets/default/css/prettyphoto.css' );  //Font Awesome		
			}
			
			if( is_page() &&  kode_match_page_builder($kode_content_raw, 'item', 'cricket-points-table') ){
				wp_register_script('kode-sortelements', KODE_PATH.'/js/sortelements.js', false, '1.0', true);
				wp_enqueue_script('kode-sortelements');
			}
			wp_enqueue_style( 'style-component', KODE_PATH . '/framework/include/frontend_assets/dl-menu/component.css' );  //Font Awesome
			wp_register_script('kode-modernizr', KODE_PATH.'/framework/include/frontend_assets/dl-menu/modernizr.custom.js', false, '1.0', true);
			wp_enqueue_script('kode-modernizr');
			wp_register_script('kode-dlmenu', KODE_PATH.'/framework/include/frontend_assets/dl-menu/jquery.dlmenu.js', false, '1.0', true);
			wp_enqueue_script('kode-dlmenu');
			
			if ( class_exists( 'bbPress' ) ) {
				wp_enqueue_style( 'kode-bbp-css', KODE_PATH . '/css/kode_bbpress.css' );  //Font Awesome
			}
			
			wp_enqueue_style( 'kode-buddy-press', KODE_PATH . '/css/kode_buddypress.css' );  //Font Awesome
			
			wp_enqueue_style( 'style-bootstrap', KODE_PATH . '/css/bootstrap.css' );  //Font Awesome
			wp_enqueue_style( 'style-woocommerce', KODE_PATH . '/framework/include/frontend_assets/default/css/kode-woocommerce.css' );  //Font Awesome
			
			wp_enqueue_style( 'style-typo', KODE_PATH . '/css/themetypo.css' );  //Font Awesome
			wp_enqueue_style( 'style-widget', KODE_PATH . '/css/widget.css' );  //Font Awesome
			wp_enqueue_style( 'style-color', KODE_PATH . '/css/color.css' );  //Font Awesome
			
			wp_enqueue_style( 'style-shortcode', KODE_PATH . '/css/shortcode.css' );  //Font Awesome
			
			wp_enqueue_style( 'style-responsive', KODE_PATH . '/css/responsive.css' );  //Font Awesome
			
			if(isset($kode_theme_option['navi-font-family'])){
				$font_id = str_replace( ' ', '-', $kode_theme_option['navi-font-family'] );
				wp_enqueue_style( 'style-shortcode-'.$font_id, esc_url_raw($kode_font_controller->get_google_font_url($kode_theme_option['navi-font-family'])));
			}
			
			if(isset($kode_theme_option['heading-font-family'])){
				$font_id = str_replace( ' ', '-', $kode_theme_option['heading-font-family'] );
				wp_enqueue_style( 'style-shortcode-'.$font_id, esc_url_raw($kode_font_controller->get_google_font_url($kode_theme_option['heading-font-family'])));
			}
			
			if(isset($kode_theme_option['body-font-family'])){
				$font_id = str_replace( ' ', '-', $kode_theme_option['body-font-family'] );
				wp_enqueue_style( 'style-shortcode-'.$font_id, esc_url_raw($kode_font_controller->get_google_font_url($kode_theme_option['body-font-family'])));
			}
		
			
		}
	}
	
	
	if( !function_exists('kode_theme_slug_editor_styles') ){
		function kode_theme_slug_editor_styles() {
			global $post,$post_id,$kode_content_raw,$kode_theme_option,$kode_font_controller;		
			if(isset($kode_theme_option['body-font-family'])){
				$font_id = str_replace( ' ', '-', $kode_theme_option['body-font-family'] );			
				add_editor_style( array( 'editor-style.css', esc_url_raw($kode_font_controller->get_google_font_url($kode_theme_option['body-font-family'])) ) );
			}
		}
	}
	
	add_action( 'admin_print_styles-appearance_page_custom-header', 'kode_slug_custom_header_fonts' );
	if( !function_exists('kode_slug_custom_header_fonts') ){
		function kode_slug_custom_header_fonts() {
			global $post,$post_id,$kode_content_raw,$kode_theme_option,$kode_font_controller;		
			if(isset($kode_theme_option['body-font-family'])){
				$font_id = str_replace( ' ', '-', $kode_theme_option['body-font-family'] );						
				wp_enqueue_style( 'theme-slug-fonts', esc_url_raw($kode_font_controller->get_google_font_url($kode_theme_option['body-font-family'])), array(), null );
			}
		}
	}
	

	
		 
    // Register all scripts
	if( !function_exists('kode_register_non_admin_scripts') ){
		function kode_register_non_admin_scripts(){
			
			global $post,$post_id,$kode_content_raw,$kode_post_option,$kode_theme_option;	
			
			wp_enqueue_script('jquery');
			
			if ( is_singular() && get_option( 'thread_comments' ) ) 	wp_enqueue_script( 'comment-reply' );
				

			
			//BootStrap Script Loaded
			wp_register_script('kode-bootstrap', KODE_PATH.'/js/bootstrap.min.js', array('jquery'), '1.0', true);
			wp_localize_script('kode-bootstrap', 'ajax_var', array('url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('ajax-nonce')));
			wp_enqueue_script('kode-bootstrap');
			wp_enqueue_style( 'kode-bootstrap-slider', KODE_PATH . '/css/bootstrap-slider.css' );  //Font Awesome
			wp_register_script('kode-bootstrap-slider', KODE_PATH.'/js/bootstrap-slider.js', false, '1.0', true);
			wp_enqueue_script('kode-bootstrap-slider');

			
			wp_register_script('kode-accordion', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.accordion.js', false, '1.0', true);
			wp_enqueue_script('kode-accordion');
			
			wp_register_script('kode-circlechart', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.circlechart.js', false, '1.0', true);
			wp_enqueue_script('kode-circlechart');
			
			
			if(isset($kode_theme_option['enable-one-page-header-navi'])){
				if($kode_theme_option['enable-one-page-header-navi'] == 'enable'){
					wp_register_script('kode-singlepage', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.singlePageNav.js', false, '1.0', true);
					wp_enqueue_script('kode-singlepage');
				}
			}
			
			wp_register_script('kode-filterable', KODE_PATH.'/framework/include/frontend_assets/default/js/filterable.js', false, '1.0', true);
			wp_enqueue_script('kode-filterable');
			
			// Product Slider
			if( is_page() &&  kode_match_page_builder($kode_content_raw, 'item', 'player-slider') ){
				wp_register_script('owl_carousel', KODE_PATH.'/framework/include/frontend_assets/owl_carousel/owl_carousel.js', false, '1.0', true);
				wp_enqueue_script('owl_carousel');
				wp_enqueue_style( 'owl_carousel', KODE_PATH . '/framework/include/frontend_assets/owl_carousel/owl_carousel.css' );  //Font Awesome
			}	
			
			if( is_page() &&  kode_match_page_builder($kode_content_raw, 'item', 'woo-slider') ){
				wp_register_script('owl_carousel', KODE_PATH.'/framework/include/frontend_assets/owl_carousel/owl_carousel.js', false, '1.0', true);
				wp_enqueue_script('owl_carousel');
				wp_enqueue_style( 'owl_carousel', KODE_PATH . '/framework/include/frontend_assets/owl_carousel/owl_carousel.css' );  //Font Awesome
			}	

			// Product Slider
			if( is_page() &&  kode_match_page_builder($kode_content_raw, 'item', 'testimonial', array('testimonial-style', 'simple-view')) ){
				wp_register_script('owl_carousel', KODE_PATH.'/framework/include/frontend_assets/owl_carousel/owl_carousel.js', false, '1.0', true);
				wp_enqueue_script('owl_carousel');
				wp_enqueue_style( 'owl_carousel', KODE_PATH . '/framework/include/frontend_assets/owl_carousel/owl_carousel.css' );  //Font Awesome
			}			
			
			
			if( is_search() || is_archive() || 
				( empty($kode_theme_option['enable-flex-slider']) || $kode_theme_option['enable-flex-slider'] != 'disable' ) ||
				( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'blog') ) ||
				( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'post-slider') ) ||
				( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'bxslider')) ) ||
				( is_single() && strpos($kode_post_option, '"post_media_type":"slider"') )){
				wp_enqueue_style( 'bx-slider', KODE_PATH . '/framework/include/frontend_assets/bxslider/bxslider.css' );  //Font Awesome
				wp_register_script('bx-slider', KODE_PATH.'/framework/include/frontend_assets/bxslider/jquery.bxslider.min.js', false, '1.0', true);
				wp_enqueue_script('bx-slider');
				
			}
			
			
			wp_register_script('kode-waypoints-min', KODE_PATH.'/framework/include/frontend_assets/default/js/waypoints-min.js', false, '1.0', true);
			wp_enqueue_script('kode-waypoints-min');
			
			wp_register_script('kode-bg-moving', KODE_PATH.'/framework/include/frontend_assets/default/js/bg-moving.js', false, '1.0', true);
			wp_enqueue_script('kode-bg-moving');
			
			
			
			//Custom Script Loaded
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'flexslider')) ){
				wp_enqueue_style( 'flexslider', KODE_PATH . '/framework/include/frontend_assets/flexslider/flexslider.css' );  //Font Awesome
				wp_register_script('kode-flexslider', KODE_PATH.'/framework/include/frontend_assets/flexslider/jquery.flexslider.js', false, '1.0', true);
				wp_enqueue_script('kode-flexslider');
			}
			
			//Enable RTL
			if(isset($kode_theme_option['enable-rtl-layout'])){
				if($kode_theme_option['enable-rtl-layout'] == 'enable'){
					wp_enqueue_style( 'kode-rtl', KODE_PATH . '/css/rtl.css' );  //Font Awesome	
				}
			}
			
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'wrapper', 'full-size-wrapper', array('type', 'video')) ){
				wp_register_script('kode-video', KODE_PATH.'/framework/include/frontend_assets/video_background/video.js', false, '1.0', true);
				wp_enqueue_script('kode-video');
				wp_register_script('kode-bigvideo', KODE_PATH.'/framework/include/frontend_assets/video_background/bigvideo.js', false, '1.0', true);
				wp_enqueue_script('kode-bigvideo');
				
			}
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'bxslider')) ){
				wp_enqueue_style( 'bx-slider', KODE_PATH . '/framework/include/frontend_assets/bxslider/bxslider.css' );  //Font Awesome
				wp_register_script('bx-slider', KODE_PATH.'/framework/include/frontend_assets/bxslider/jquery.bxslider.min.js', false, '1.0', true);
				wp_enqueue_script('bx-slider');
			}
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'post-slider') ){		
				wp_enqueue_style( 'bx-slider', KODE_PATH . '/framework/include/frontend_assets/bxslider/bxslider.css' );  //Font Awesome
				wp_register_script('bx-slider', KODE_PATH.'/framework/include/frontend_assets/bxslider/jquery.bxslider.min.js', false, '1.0', true);
				wp_enqueue_script('bx-slider');
			}
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'gallery') ){
				wp_register_script('kode-prettyphoto', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.prettyphoto.js', false, '1.0', true);
				wp_enqueue_script('kode-prettyphoto');
				wp_register_script('kode-prettypp', KODE_PATH.'/framework/include/frontend_assets/default/js/kode_pp.js', false, '1.0', true);
				wp_enqueue_script('kode-prettypp');
			}	
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'player-state') ){
				wp_register_script('kode-player-state-map', KODE_PATH.'/framework/include/frontend_assets/v_map/jquery.vmap.js', false, '1.0', true);
				wp_enqueue_script('kode-player-state-map');
				wp_register_script('kode-player-state-map-usa', KODE_PATH.'/framework/include/frontend_assets/v_map/jquery.vmap.usa.js', false, '1.0', true);
				wp_enqueue_script('kode-player-state-map-usa');
				wp_enqueue_style( 'kode-jqvmap', KODE_PATH . '/framework/include/frontend_assets/v_map/jqvmap.css' );  // Vmap
			}
			
			
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider') ){
				wp_enqueue_style( 'style-prettyphoto', KODE_PATH . '/framework/include/frontend_assets/default/css/prettyphoto.css' );  //Font Awesome					
				wp_register_script('kode-prettyphoto', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.prettyphoto.js', false, '1.0', true);
				wp_enqueue_script('kode-prettyphoto');
				wp_register_script('kode-prettypp', KODE_PATH.'/framework/include/frontend_assets/default/js/kode_pp.js', false, '1.0', true);
				wp_enqueue_script('kode-prettypp');
			}
			
			//if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'slider', array('slider-type', 'nivo-slider')) ){
				wp_enqueue_style( 'nivo-slider', KODE_PATH . '/framework/include/frontend_assets/nivo-slider/nivo-slider.css' );  //Font Awesome
				wp_register_script('kode-nivo-slider', KODE_PATH.'/framework/include/frontend_assets/nivo-slider/jquery.nivo.slider.js', false, '1.0', true);
				wp_enqueue_script('kode-nivo-slider');
			//}
			
			//CountDown Timer
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'upcoming-event') ){
				
				wp_register_script('custom_countdown', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery.countdown.js', false, '1.0', true);
				wp_enqueue_script('custom_countdown');		
				
				wp_enqueue_style( 'custom_countdown', KODE_PATH . '/framework/include/frontend_assets/default/css/countdown.css' );  //Count Down timer
				
			}	
			
			//CountDown Timer
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'next-match') ){
				
				wp_register_script('custom_downcount', KODE_PATH.'/framework/include/frontend_assets/default/js/jquery-downcount.js', false, '1.0', true);
				wp_enqueue_script('custom_downcount');	  //Count Down timer
				
			}
			
			//CountDown Timer
			if( is_page() && kode_match_page_builder($kode_content_raw, 'item', 'team-slider') ){
				
				wp_register_script('owl_carousel', KODE_PATH.'/framework/include/frontend_assets/owl_carousel/owl_carousel.js', false, '1.0', true);
				wp_enqueue_script('owl_carousel');
				wp_enqueue_style( 'owl_carousel', KODE_PATH . '/framework/include/frontend_assets/owl_carousel/owl_carousel.css' );  //Font Awesome
				
			}
			
			
			
			wp_register_script('kode-easing', KODE_PATH.'/framework/include/frontend_assets/jquery.easing.js', false, '1.0', true);
			wp_enqueue_script('kode-easing');
			
			wp_register_script('kode-functions', KODE_PATH.'/js/functions.js', false, '1.0', true);
			wp_enqueue_script('kode-functions');
			
		}
	}
	
	// set the global variable based on the opened page, post, ...
	add_action('wp', 'kode_define_global_variable');
	if( !function_exists('kode_define_global_variable') ){
		function kode_define_global_variable(){
			global $post;		
			if( is_page() ){
				global $kode_content_raw,$kode_post_option;				
				$kode_content_raw = json_decode(kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'kode_content', true)), true);
				$kode_content_raw = (empty($kode_content_raw))? array(): $kode_content_raw;
				$kode_post_option = kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true));
			}else if( is_single() || (!empty($post)) ){
				global $kode_post_option;			
				$kode_post_option = kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true));
			}
			
			
		}
	}