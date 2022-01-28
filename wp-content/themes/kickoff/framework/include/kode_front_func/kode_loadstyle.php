<?php
	/*	
	*	Kodeforest Load Style
	*	---------------------------------------------------------------------
	*	This file create the custom style
	*	For Color Scheme, and Typography Options
	*	---------------------------------------------------------------------
	*/	
		global $kode_theme_option;
		
		// load the style using this file
		if(!is_admin()){
			//for Frontend only
			add_action('wp_footer', 'kode_generate_style_custom');
		}
		
		add_action('kode_save_theme_options', 'kode_save_font_options');
		if( !function_exists('kode_save_font_options') ){
			function kode_save_font_options($options){
				
				// write file content
				$kode_theme_option = get_option(KODE_SMALL_TITLE . '_admin_option', array());
				
				// for updating google font list to use on front end
				global $kode_font_controller; $google_font_list = array(); 
				
				foreach( $options as $menu_key => $menu ){
					foreach( $menu['options'] as $submenu_key => $submenu ){
						if( !empty($submenu['options']) ){
							foreach( $submenu['options'] as $option_slug => $option ){
								if( !empty($option['selector']) ){
									// prevents warning message
									$option['data-type'] = (empty($option['data-type']))? 'color': $option['data-type'];
									
									// if( !empty($kode_theme_option[$option_slug]) ){
										// $value = kode_check_option_data_type($kode_theme_option[$option_slug], $option['data-type']);
									// }else{
										// $value = '';
									// }
									// if($value){
										// $kode_font = str_replace('#kode#', $value, $option['selector']) . "\r\n";
									// }
									
									// updating google font list
									if( $menu_key == 'font-settings' && $submenu_key == 'font-family' ){
										if( !empty($kode_font_controller->google_font_list[$kode_theme_option[$option_slug]]) ){
											$google_font_list[$kode_theme_option[$option_slug]] = $kode_font_controller->google_font_list[$kode_theme_option[$option_slug]];
										}
									}
								}
							}
						}
					}
				}
				
				// update google font list
				update_option(KODE_SMALL_TITLE . '_google_font_list', $google_font_list);	
				
				
				
			}
		}
		
		$kode_allowed_html_array = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'ul' => array(),
			'li' => array(),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'&gt;' => array(),
			'style' => array(
				'scoped'=>array(),
				'id'=>array(),
			),
		);	
		
		
		if( !function_exists('kode_generate_style_custom') ){
			function kode_generate_style_custom( $kode_theme_options,$page_options= "" ){
				global $kode_allowed_html_array;
				// write file content
				if($page_options == 'Yes'){
					$kode_theme_option = $kode_theme_options;
					$k_option = 'custom_style';
					if(isset($_GET['layout']) && $_GET['layout'] == 'boxed'){
						$kode_theme_option['enable-boxed-style'] = 'boxed-style';
					}else{
						$kode_theme_option['enable-boxed-style'] = 'full-style';
					}
				}else{
					$kode_theme_option = get_option(KODE_SMALL_TITLE . '_admin_option', array());
					$k_option = 'default_stylesheet';
				}
				
				$style = '<style id="'.$k_option.'" scoped>';
				
				
				if(!empty($kode_theme_option['logo-width'])){
					if($kode_theme_option['logo-width'] <> ''){
						if($kode_theme_option['logo-width'] <> 0){
							$style .= '.logo img{';
							$style .= 'width:'.$kode_theme_option['logo-width'] .'px';
							$style .= '}' . "\r\n";
						}
						
					}
				}
				
				if(!empty($kode_theme_option['logo-height'])){
					if($kode_theme_option['logo-height'] <> ''){
						if($kode_theme_option['logo-height'] <> 0){
							$style .= '.logo img{';
							$style .= 'height:'.$kode_theme_option['logo-height'] .'px';
							$style .= '}' . "\r\n";
						}
					}
				}
				
				if(!empty($kode_theme_option['navi-font-family'])){
					if($kode_theme_option['navi-font-family'] <> ''){
						$style .= '.kode-navigation-wrapper{';
						$style .= 'font-family:'.$kode_theme_option['navi-font-family'] .'';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['heading-font-family'])){
					if($kode_theme_option['heading-font-family'] <> ''){
						$style .= '.kode-caption-title, .kode-caption-text, h1, h2, h3, h4, h5, h6{';
						$style .= 'font-family:'.$kode_theme_option['heading-font-family'] .'';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['body-font-family'])){
					if($kode_theme_option['body-font-family'] <> ''){
						$style .= 'body{';
						$style .= 'font-family:'.$kode_theme_option['body-font-family'] .'';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['content-font-size'])){
					if($kode_theme_option['content-font-size'] <> ''){
						$style .= 'body{';
						$style .= 'font-size:'.$kode_theme_option['content-font-size'] .'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h1-font-size'])){
					if($kode_theme_option['h1-font-size'] <> ''){
						$style .= 'h1{';
						$style .= 'font-size:'.$kode_theme_option['h1-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h2-font-size'])){
					if($kode_theme_option['h2-font-size'] <> ''){
						$style .= 'h2{';
						$style .= 'font-size:'.$kode_theme_option['h2-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h3-font-size'])){
					if($kode_theme_option['h3-font-size'] <> ''){
						$style .= 'h3{';
						$style .= 'font-size:'.$kode_theme_option['h3-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h4-font-size'])){
					if($kode_theme_option['h4-font-size'] <> ''){
						$style .= 'h4{';
						$style .= 'font-size:'.$kode_theme_option['h4-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h5-font-size'])){
					if($kode_theme_option['h5-font-size'] <> ''){
						$style .= 'h5{';
						$style .= 'font-size:'.$kode_theme_option['h5-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				if(!empty($kode_theme_option['h6-font-size'])){
					if($kode_theme_option['h6-font-size'] <> ''){
						$style .= 'h6{';
						$style .= 'font-size:'.$kode_theme_option['h6-font-size'].'px';
						$style .= '}' . "\r\n";
						
					}
				}
				
				
				
				
				if(!empty($kode_theme_option['navi-color'])){
					if($kode_theme_option['navi-color'] <> ''){
						$style .= '.navigation ul > li > a, .navbar-nav > li > a{';
						$style .= 'color:'.$kode_theme_option['navi-color'].' !important';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['navi-hover-bg'])){
					if($kode_theme_option['navi-hover-bg'] <> ''){
						$style .= '.navigation ul > li:hover > a{';
						$style .= 'background-color:'.$kode_theme_option['navi-hover-bg'].' !important';
						$style .= '}' . "\r\n";
					}
				}
				
				if(!empty($kode_theme_option['top-bar-background-color'])){
					if($kode_theme_option['top-bar-background-color'] <> ''){
						$style .= ' .kode_top_strip2{';
						$style .= 'background:'.$kode_theme_option['top-bar-background-color'].' !important';
						$style .= '}' . "\r\n";
					}
				}
				
				
				
				
				
				if(!empty($kode_theme_option['navi-hover-color'])){
					if($kode_theme_option['navi-hover-color'] <> ''){
						$style .= '.navigation ul > li:hover > a, .navbar-nav > li:hover{';
						$style .= 'color:'.$kode_theme_option['navi-hover-color'].' !important';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['navi-dropdown-bg'])){
					if($kode_theme_option['navi-dropdown-bg'] <> ''){
						$style .= '.navigation .sub-menu, .navigation .children, .navbar-nav .children{';
						$style .= 'background:'.$kode_theme_option['navi-dropdown-bg'].' !important';
						$style .= '}' . "\r\n";
						
					}
				}

				if(!empty($kode_theme_option['navi-dropdown-hover'])){
					if($kode_theme_option['navi-dropdown-hover'] <> ''){
						$style .= '.navigation ul li ul > li:hover > a, .navbar-nav li ul > li:hover > a{ ';
						$style .= 'background:'.$kode_theme_option['navi-dropdown-hover'].' !important';
						$style .= ' }' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['navi-dropdown-color'])){
					if($kode_theme_option['navi-dropdown-color'] <> ''){
						$style .= '.navigation .sub-menu, .navigation .children, .navbar-nav .children{ ';
						$style .= 'color:'.$kode_theme_option['navi-dropdown-color'].' !important';
						$style .= ' }' . "\r\n";
						
					}
				}			
				
				if(!empty($kode_theme_option['top-bar-background-color'])){
					if($kode_theme_option['top-bar-background-color'] <> ''){
						$style .= '#header-style-3 .kode_top_strip:before, .kode_header_7 .kode_top_eng:before{';
						$style .= 'background:'.$kode_theme_option['top-bar-background-color'].' !important';
						$style .= '}' . "\r\n";
					}
				}
				
				if(!empty($kode_theme_option['top-bar-text-color'])){
					if($kode_theme_option['top-bar-text-color'] <> ''){
						$style .= '.kode_header_5 ul.kode_social_icon li a i{';
						$style .= 'color:'.$kode_theme_option['top-bar-text-color'].' !important';
						$style .= '}' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['header-background-opacity'])){
					if($kode_theme_option['header-background-opacity'] <> ''){
						$style .= '#header-style-3 .kode_top_strip:before, .kode_header_7 .kode_top_eng:before{';
						$style .= 'opacity:'.$kode_theme_option['header-background-opacity'].' !important';
						$style .= '}' . "\r\n";
					}
				}
				
				
				//Background As Pattern
				if(isset($kode_theme_option['header-background-image'])){
					if($kode_theme_option['header-background-image'] <> ''){
						if( !empty($kode_theme_option['header-background-image']) && is_numeric($kode_theme_option['header-background-image']) ){
							$alt_text = get_post_meta($kode_theme_option['header-background-image'] , '_wp_attachment_image_alt', true);	
							$image_src = wp_get_attachment_image_src($kode_theme_option['header-background-image'], 'full');
							
							$style .= '.kode_header_7 .kode_top_eng, .kode_top_strip{background:url(' . esc_url($image_src[0]).')}';
						}else if( !empty($kode_theme_option['body-background-pattern']) ){
							$style .= '.kode_header_7 .kode_top_eng, .kode_top_strip{background:url(' . $kode_theme_option['header-background-image'].')}';
						}
					}
				}
				
				//Background As Pattern
				if(isset($kode_theme_option['kode-body-style'])){
					if($kode_theme_option['kode-body-style'] == 'body-pattern'){
						if($kode_theme_option['body-background-pattern'] <> ''){
							if( !empty($kode_theme_option['body-background-pattern']) && is_numeric($kode_theme_option['body-background-pattern']) ){
								// $alt_text = get_post_meta($kode_theme_option['body-background-pattern'] , '_wp_attachment_image_alt', true);	
								// $image_src = wp_get_attachment_image_src($kode_theme_option['body-background-image'], 'full');
								$style .= 'body{background:url(' . esc_url(KODE_PATH . '/images/pattern/pattern_'.$kode_theme_option['body-background-pattern'].'.png') . ') !important}';
							}else if( !empty($kode_theme_option['body-background-pattern']) ){
								$style .= 'body{background:url(' . esc_url(KODE_PATH . '/images/pattern/pattern_'.$kode_theme_option['body-background-pattern'].'.png') . ') !important}';
							}
						}
					}
				}
				
				//Background As Image
				if(isset($kode_theme_option['kode-body-style'])){
					if($kode_theme_option['kode-body-style'] == 'body-background'){
						if($kode_theme_option['body-background-image'] <> ''){
							if( !empty($kode_theme_option['body-background-image']) && is_numeric($kode_theme_option['body-background-image']) ){
								$alt_text = get_post_meta($kode_theme_option['body-background-image'] , '_wp_attachment_image_alt', true);	
								$image_src = wp_get_attachment_image_src($kode_theme_option['body-background-image'], 'full');
								$style .= 'body{background:url(' . esc_url($image_src[0]) . ') !important}';
								if($kode_theme_option['kode-body-position'] == 'body-scroll'){
									$style .= 'body{background-attachment:scroll !important}';
								}else{
									$style .= 'body{background-attachment:fixed !important}';
								}
							}else if( !empty($kode_theme_option['body-background-image']) ){
								$style .= 'body{background:url(' . esc_url($kode_theme_option['body-background-image']) . ') !important}';
								if($kode_theme_option['kode-body-position'] == 'body-scroll'){
									$style .= 'body{background-attachment:scroll !important}';
								}else{
									$style .= 'body{background-attachment:fixed !important}';
								}
							}
						}
					}
				}
				
				//Background As Color
				if(isset($kode_theme_option['body-bg-color'])){
					if($kode_theme_option['body-bg-color'] <> ''){
						$style .= 'body { ';
						$style .= 'background-color: ' . $kode_theme_option['body-bg-color'] . ' !important;  }' . "\r\n";
					}
				}
				

				if(!empty($kode_theme_option['enable-boxed-style'])){
					if($kode_theme_option['enable-boxed-style'] == 'boxed-style'){
						if( !empty($kode_theme_option['boxed-background-image']) && is_numeric($kode_theme_option['boxed-background-image']) ){
							$alt_text = get_post_meta($kode_theme_option['boxed-background-image'] , '_wp_attachment_image_alt', true);	
							$image_src = wp_get_attachment_image_src($kode_theme_option['boxed-background-image'], 'full');
							$style .= 'body{background:url(' . esc_url($image_src[0]) . ') !important}';
						}else if( !empty($kode_theme_option['boxed-background-image']) ){
							$style .= 'body{background:url(' . esc_url($kode_theme_option['boxed-background-image']) . ') !important}';
						}
						
						$style .= '.logged-in.admin-bar .body-wrapper .kode-header-1{';
						$style .= 'margin-top:0px !important;';
						$style .= '}' . "\r\n";
						$style .= '.body-wrapper .kode-topbar:before{width:25%;}';
						$style .= '.body-wrapper #footer-widget .kode-widget-bg-footer:before{width:23em;}';
						$style .= '.body-wrapper .eccaption{top:40%;}';
						$style .= '.body-wrapper .main-content{}';
						$style .= '.body-wrapper {';
						$style .= 'width: 1200px; margin: 0 auto; margin-top: 40px; margin-bottom: 40px; box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);position:relative;';
						$style .= '}' . "\r\n";
					}
				}
				
				
				if(isset($kode_theme_option['footer-background-opacity'])){
					if($kode_theme_option['footer-background-opacity'] <> ''){
						$style .= 'footer:before{ ';
						$style .= ' content: "";
						height: 100%;
						left: 0;
						position: absolute;
						top: 0;
						width: 100%;opacity: ' . esc_attr($kode_theme_option['footer-background-opacity']) . ';  }' . "\r\n";
					}
				}
				

				
				//Background As Color
				if(isset($kode_theme_option['footer-background-color'])){				
					if($kode_theme_option['footer-background-color'] <> ''){
						
						$style .= 'footer:before, #footer1 .footer-medium{ ';
						$style .= 'background-color: ' . esc_attr($kode_theme_option['footer-background-color'] ). ' !important;  }' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['footer-background-image'])){
					if( !empty($kode_theme_option['footer-background-image']) && is_numeric($kode_theme_option['footer-background-image']) ){
						$alt_text = get_post_meta($kode_theme_option['footer-background-image'] , '_wp_attachment_image_alt', true);	
						$image_src = wp_get_attachment_image_src($kode_theme_option['footer-background-image'], 'full');
						$style .= 'footer{background:url(' . esc_url($image_src[0]) . ');background-size: cover;float: left;position: relative;width: 100%;}';
					}else if( !empty($kode_theme_option['footer-background-image']) ){
						$style .= 'footer{background:url(' . esc_url($kode_theme_option['footer-background-image']) . ');background-size: cover;float: left;position: relative;width: 100%;}';
					}
				}
				
				if(isset($kode_theme_option['logo-bottom-margin'])){
				if($kode_theme_option['logo-bottom-margin'] <> ''){
					$style .= '.logo{';
					$style .= 'margin-bottom: ' . $kode_theme_option['logo-bottom-margin'] . 'px;  }' . "\r\n";
				}
				}
				
				if(isset($kode_theme_option['logo-top-margin'])){
				if($kode_theme_option['logo-top-margin'] <> ''){
					$style .= '.logo{';
					$style .= 'margin-top: ' . $kode_theme_option['logo-top-margin'] . 'px;  }' . "\r\n";
				}
				}
				
				if(isset($kode_theme_option['color-scheme-one'])){
					if(empty($kode_theme_option['color-scheme-one'])){
						$kode_theme_option['color-scheme-one'] = '#03AF14';
					}
				}
				
				
				if(isset($kode_theme_option['color-scheme-one'])){
					if($kode_theme_option['color-scheme-one'] <> ''){
						
						$style .= '.amount, 
						.thcolor,.thcolorhover:hover,.kode-section-title h2,.kode-pro-inner:hover figcaption h4 a,.next-prev-style .owl-nav div,
						.kode-blog-list ul li:hover .kode-time-zoon h5 a,.kode-large-blog ul li:hover .kode-blog-btn,.children li a:before,
						.kode-grid-blog .kode-blog-options li a:hover,.widget-tabnav li:hover a,.widget-tabnav li.active a,
						.kode-recent-blog > ul > li:hover h6 a,.widget-recent-news ul li:hover h6 a,
						.kode-related-blog ul li:hover h6 a,
						.kode-gallery ul li:hover h2 a,.player-nav li.active a,.fixer-pagination a:hover,.next-prev-style .owl-nav div {';
						$style .= 'color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";

						//Cricket Color Scheme
						$style .= '
						.crkt-topbar {';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						
						
						
						$style .= '
						
						.heading-12 span.left, .heading-12 span.right, .thbg-color,.thbg-colorhover:hover,.navbar-nav > li > a:before,.owl-nav div:hover,.kode-team-network li a:hover,
						.kode-team-list figure:hover figcaption h2 a,.kode-services ul li:hover .service-info,.kode-table thead,
						.kode-blog-list ul li:hover .kode-time-zoon time,.kode-blog-list ul li:hover .kode-time-zoon:before,.kode-bottom-footer,
						.children > li:hover > a,.pagination a:hover,.pagination span,.page-links > a:hover, .page-links > span,.widget-tabnav li a:before,.widget-recent-news ul li:hover time,
						.kode-table caption,.shop-btn a:hover,.fixer-btn a:hover, .crkt-slider .bx-wrapper .bx-controls-direction a, .kode-underconstruction .kode-innersearch form input[type="submit"] {';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						//BuddyPress
						$style .= '.bbp-breadcrumb, .bbp-topic-tags, #bbpress-forums li.bbp-header, #bbpress-forums li.bbp-footer, #bbpress-forums li.bbp-header ul.forum-titles{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						
						$style .= '.next-prev-style .owl-nav div,
						.th-bordercolor,.th-bordercolorhover:hover,.kd-headbar,.kode-section-title h2,.owl-nav div:hover,
						.kode-team-list figure:hover figcaption h2 a,.next-prev-style .owl-nav div,.kode-table,
						.kode-simple-form ul li input[type="submit"],.children,.kode-grid-blog .kode-blog-info:before,.kode-modrenbtn:hover,
						.kode-widget-title h2,.widget-recent-news ul li:hover time,blockquote,.kode-inner-fixer,
						#koderespond form p input[type="button"],#koderespond form p input[type="submit"],.kode-header-three .navbar-nav > li > a::before {';
						$style .= 'border-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
	   

						$style .= '.tab-widget {';
						$style .= 'border-color: 0px 2px 0px 0px ' . $kode_theme_option['color-scheme-one'] . ',0px 2px 0px 0px ' . $kode_theme_option['color-scheme-one'] . ' inset !important;  }' . "\r\n";


						$style .= '.kode-admin-post:before,
						.kode-result-list article:before,
						.kode-testimonial figure:before,
						.countdown-amount:before{';
						$style .= 'border-top-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
			
						$style .= '.theme_color_default,.kode-services-3:hover i, .kode_coun p span, .kode-event-list-2 .kode-text h2, .kode-rating::before, .rating-box::before,.rating-box::before, .thcolor,.thcolorhover:hover,.kode-blog-list ul li:hover .kode-blog-info h2 a,.footer-nav ul li a:hover,
		.top-nav ul li a:hover,.services-view-two ul li:hover h2,.upcoming_event_widget ul li:hover .event-widget-info a,
		.kode-content .widget-recentpost ul li:hover h6 a,#koderespond form p i,.kode-postoption li a,.kode-team ul li:hover h4 a,.kode-actionbtn a:hover,
		.kode-blog-list.kode-box-blog ul li:hover h5 a , .widget_rss ul li a.rsswidget{';
						$style .= 'color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-topbar-kickoff::before, .kode-subheader, .kode-cause-list .kode-thumb, .theme_background_default:before,.theme_background_default, .kode_search_bar button, .kode_header_7 .kode_donate_btn a:hover, .kode_header_7 .kode_search_bar form a, .slider-selection, .kode-causes-list.kode-causes-box .progress-bar:before,.kode-causes-list.kode-causes-box .progress-bar, .kode_cart_fill span, .kode_heart a, .progress-section, .btn-borderd:hover, .kode-team-section, .kode-social-icons ul li a, .btn-filled, .btn-filled-rounded, .kode-event-list-2 .kode-thumb, .custom-btn, .navbar-nav .children > li:hover > a,.kd-accordion .accordion.accordion-open, .thbg-color,.thbg-colorhover:hover,.kode-topbar:before,.kode-causes-box ul li:hover .cause-inner-caption,
		.gallery-link a:hover,.kode-team figure figcaption ul li:hover a,.team-network ul li:hover a,.kode-blog-list ul li figcaption time,
		#footer-widget .widget-text:before,.main-navbaar .navbar-nav > li:before,
		.services-view-two ul li:hover i,.services-view-two ul li:hover h2:before,.services-view-two ul li:hover .service-btn,
		.pagination a:hover,.pagination span,.page-links > a, .page-links > span,.widget_archive ul li:hover,.kode-content .widget-recentpost ul li:hover time,
		#koderespond form p input[type="submit"]:hover,.kode-postsection a:hover,
		.kode-services.services-three ul li i,.widget_categories ul li:hover,.widget-recentpost ul li:hover time,.widget-text ul li:hover i,
		.with-circle ul li i,.kode-causes-list .kode-main-action a,.kode-blog-list.kode-box-blog ul li:hover .box-icon, .widget_calendar table tr td:hover, .widget_calendar table thead, .widget_pages ul li:hover > a, .widget_meta ul li a:hover, .widget_recent_comments ul li .comment-author-link a, .widget_recent_entries ul li a:hover, .widget-search input[type="submit"]:hover, .tagcloud a, .widget_nav_menu ul li:hover > a, .comment-form input[type="submit"], #kodecomments ul li .text a.comment-reply-link:hover, .kode-search label, .event-table:hover .event-cell h2, .kode-ux:hover .box-icon, .widget-recentpost ul li:hover .datetime, .kode-ux:hover figcaption .cause-inner-caption, .kode-blog-list figcaption .datetime, .kode-blog-list figcaption .datetime, #footer-widget .kode-widget-bg-footer:before, .kode-services.with-circle i, #theme_bg_color, .kode-pagination a:hover, .kode-pagination span, .page-links > a:hover, .page-links > span,.kode-pro-info a.added_to_cart, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce .cart .button, .woocommerce .cart input.button, .kode-services.services-three i, .dl-menuwrapper button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .widget_kode_flickr_widget a:after{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						$style .= '.kode_header_7 .kode_donate_btn a:hover, .kode-services-3:hover, .th-bordercolor,.th-bordercolorhover:hover,.detail-thumb,.kode-couses-numbers ul li span,.kode-shop-list ul li figure,
		.kode-blog-list.kode-grid-blog ul li figure,.kode-blog-list.kode-mediium-blog figure, .widget_text img:hover, #kodecomments ul li .text a.comment-reply-link:hover, .widget-recentpost ul li:hover .datetime, .team-network ul li:hover a, .page-links > a:hover, .page-links > span,.kode-pagination a:hover, .kode-pagination span, .blog-more:hover, .kode-icons .kode-team-network li a:hover, .kode-postsection a:hover{';
						$style .= 'border-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						$style .= '.table thead{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode_header_5 .kode_nav_1 .navigation ul > li > a:hover, .kode-team-member .kode-text, .kode-team-member .kode-text {';
						$style .= 'border-top-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						
						$style .= '.kode-team-member a:before {';
						$style .= 'outline-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-topbar-kickoff::after{';
						$style .= 'border-bottom-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
					
						$style .= '#buddypress div.item-list-tabs ul li.current a, #buddypress div.item-list-tabs ul li.selected a, 
						#buddypress .comment-reply-link, #buddypress a.button, #buddypress button, #buddypress div.generic-button a, #buddypress input[type="button"], #buddypress input[type="reset"], #buddypress input[type="submit"], #buddypress ul.button-nav li a, a.bp-title-button, #buddypress table.forum thead tr, #buddypress table.messages-notices thead tr, #buddypress table.notifications thead tr, #buddypress table.notifications-settings thead tr, #buddypress table.profile-fields thead tr, #buddypress table.profile-settings thead tr, #buddypress table.wp-profile-fields thead tr, #buddypress .standard-form input[type="submit"]:focus{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";
						
						$style .= '#buddypress div.item-list-tabs ul li.current a, #buddypress div.item-list-tabs ul li.selected a{';
						$style .= 'border-color: ' . $kode_theme_option['color-scheme-one'] . ' !important;  }' . "\r\n";

					}
				}
				
				if(isset($kode_theme_option['color-scheme-three'])){
					if($kode_theme_option['color-scheme-three'] <> ''){
						$style .= '.thbg-colortwo, .thbg-colortwohover:hover, #mainbanner .flex-control-paging li a.flex-active, .kode-pro-inner:hover .kode-pro-info, .kode-medium-blog > ul > li:hover .medium-info time{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-three'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-modren-btn{';
						$style .= 'border-color: ' . $kode_theme_option['color-scheme-three'] . ' !important;  }' . "\r\n";
						
						$style .= '.thcolortwo,.thcolortwohover:hover,.kode-medium-blog >ul >li:hover h5 a,.kode-medium-blog .kode-blog-options li a:hover{';
						$style .= 'color: ' . $kode_theme_option['color-scheme-three'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-modren-btn,.kode-modren-btn, .th-bordertwocolor,.th-bordercolortwohover:hover,.kode-medium-blog,.kode-medium-blog >ul >li:hover .medium-info time,
	.kode-loginform p input[type="submit"]{';
						$style .= 'border-color: ' . $kode_theme_option['color-scheme-three'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-result-count::before{';
						$style .= 'border-bottom-color: ' . $kode_theme_option['color-scheme-three'] . ' !important;  }' . "\r\n";
						
					}
				}	
				
				if(isset($kode_theme_option['color-scheme-two'])){
					if($kode_theme_option['color-scheme-two'] <> ''){
						
				
						$style .= '.dddddd{';
						$style .= 'color: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
						
						$style .= '.aaaaaaaa{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
						
						$style .= '.subheader-height:before{';
						$style .= 'background: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
						
						$style .= '.kode-topbar-kickoff{';
						$style .= 'background-color: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
						
						$style .= '.subheader-height:after{';
						$style .= 'border-bottom-color: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
						
						
						$style .= '.kode-team-member a:before {';
						$style .= 'outline-color: ' . $kode_theme_option['color-scheme-two'] . ' !important;  }' . "\r\n";
					
						

					}
				}
				
				
				if(isset($kode_theme_option['footer-background-opacity'])){
					if($kode_theme_option['footer-background-opacity'] <> ''){
						$style .= '#footer1 .footer-medium:before{ ';
						$style .= ' content: "";
						height: 100%;
						left: 0;
						position: absolute;
						top: 0;
						width: 100%;opacity: ' . esc_attr($kode_theme_option['footer-background-opacity']) . ';  }' . "\r\n";
					}
				}
				

				
				//Background As Color
				if(isset($kode_theme_option['footer-background-color'])){				
					if($kode_theme_option['footer-background-color'] <> ''){
						
						$style .= '#footer1 .footer-medium:before{ ';
						$style .= 'background-color: ' . esc_attr($kode_theme_option['footer-background-color'] ). ';  }' . "\r\n";
						
					}
				}
				
				if(!empty($kode_theme_option['footer-background-image'])){
					if( !empty($kode_theme_option['footer-background-image']) && is_numeric($kode_theme_option['footer-background-image']) ){
						$alt_text = get_post_meta($kode_theme_option['footer-background-image'] , '_wp_attachment_image_alt', true);	
						$image_src = wp_get_attachment_image_src($kode_theme_option['footer-background-image'], 'full');
						$style .= '#footer1 .footer-medium{background:url(' . esc_url($image_src[0]) . ');background-size: cover;float: left;position: relative;width: 100%;}';
					}else if( !empty($kode_theme_option['footer-background-image']) ){
						$style .= '#footer1 .footer-medium{background:url(' . esc_url($kode_theme_option['footer-background-image']) . ');background-size: cover;float: left;position: relative;width: 100%;}';
					}
				}
				
				
				
				
				if(isset($kode_theme_option['woo-post-title']) && $kode_theme_option['woo-post-title'] == 'disable'){
							$style .= '.woocommerce-content-item .product .product_title.entry-title{ display:none;}';							
						}
						
						if(isset($kode_theme_option['woo-post-price']) && $kode_theme_option['woo-post-price'] == 'disable'){
							$style .= '.woocommerce-content-item div[itemprop="offers"]{ display:none;}';
						}
						
						if(isset($kode_theme_option['woo-post-variable-price']) && $kode_theme_option['woo-post-price'] == 'disable'){
							$style .= '.woocommerce-content-item div[itemprop="offers"]{ display:none;}';
						}
						
						if(isset($kode_theme_option['woo-post-related']) && $kode_theme_option['woo-post-related'] == 'disable'){
							$style .= '.woocommerce-content-item .product .related.products{ display:none;}';
						}
						
						if(isset($kode_theme_option['woo-post-sku']) && $kode_theme_option['woo-post-sku'] == 'disable'){
							$style .= '.woocommerce-content-item .product .sku_wrapper{ display:none;}';
						}
						
						if(isset($kode_theme_option['woo-post-category']) && $kode_theme_option['woo-post-category'] == 'disable'){
							$style .= '.woocommerce-content-item .product .posted_in{ display:none; !important;}';
						}
						
						if(isset($kode_theme_option['woo-post-tags']) && $kode_theme_option['woo-post-tags'] == 'disable'){
							$style .= '.woocommerce-content-item .product .tagged_as{ display:none !important;}';
						}
						
						if(isset($kode_theme_option['woo-post-outofstock']) && $kode_theme_option['woo-post-outofstock'] == 'disable'){
							
						}
						
						if(isset($kode_theme_option['woo-post-saleicon']) && $kode_theme_option['woo-post-saleicon'] == 'disable'){
							$style .= '.woocommerce-content-item .product .onsale{ display:none;}';
						}
				
				
				
				echo $style .='</style>';
				//echo wp_kses( $style, $kode_allowed_html_array );
				
			}
		}