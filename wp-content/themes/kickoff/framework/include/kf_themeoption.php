<?php
	/*	
	*	Kodeforest Framework File
	*	---------------------------------------------------------------------
	*	This file contains the admin option setting 
	*	---------------------------------------------------------------------
	*	http://stackoverflow.com/questions/2270989/what-does-apply-filters-actually-do-in-wordpress
	*/
	
	// create the main admin option
	if( is_admin() ){
		add_action('after_setup_theme', 'kode_create_themeoption');
	}
	
	if( !function_exists('kode_create_themeoption') ){
	
		function kode_create_themeoption(){
		
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			// Theme Options Default data
			$default_data_array = array(
				'page_title' => KODE_FULL_NAME . ' ' . esc_html__('Option', 'kickoff'),
				'menu_title' => KODE_FULL_NAME,
				'menu_slug' => KODE_SLUG,
				'save_option' => KODE_SMALL_TITLE . '_admin_option',
				'role' => 'edit_theme_options'
			);
			
			
			new kode_themeoption_panel(
				
				// Theme Options Default data
				$default_data_array,
				
				// Theme Options setting
				apply_filters('kode_themeoption_panel',
					
					array(
						// general menu
						'game-mode' => array(						
							'title' => esc_html__('Sport Settings', 'kickoff'),
							'icon' => 'fa fa-trophy',
							'options' => array(
								'game-mode-on' => array(
									'title' => esc_html__('Game Settings', 'kickoff'),
									'options' => array(
										'select_club' => array(
											'title' => esc_attr__('Select Game Mode' , 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'soccer' => esc_attr__('Soccer' , 'kickoff'),
											),
											'description'=> esc_attr__('Select your game mode.', 'kickoff')
										),
										'match-points' => array(
											'title' => 'Match Points on Winning',
											'type' => 'text',	
											'default' => '4.0',
											'description' => 'Match points given to each team on winning the match.'
										),
										'match-points-drawn' => array(
											'title' => 'Match Points on Draw',
											'type' => 'text',
											'default' => '2.0',
											'description' => 'Match points given to each team on drawn the match.'
										),
										'match-points-lossing' => array(
											'title' => 'Match Points on Lossing',
											'type' => 'text',
											'default' => '0',						
											'description' => 'Match points given to each team on lossing the match.'
										),					
										'match-points-penalty-winning' => array(
											'title' => 'Match Points on Penalty For Winning',
											'type' => 'text',
											'default' => '3.0',						
											'description' => 'Match points given to each team on penalty for winning the match.'
										),					
										'match-points-penalty-lossing' => array(
											'title' => 'Match Points on Penalty For Lossing',
											'type' => 'text',
											'default' => '1.0',
											'description' => 'Match points given to each team on penalty for lossing the match.'
										),
									),
								),
							),					
						),
						
						// general menu
						'general' => array(
							'title' => esc_html__('General Settings', 'kickoff'),
							'icon' => 'fa fa-diamond',
							'options' => array(
								'header-logo' => array(
									'title' => esc_html__('Header & TopBar', 'kickoff'),
									'options' => array(
										'logo' => array(
											'title' => esc_html__('Upload Logo', 'kickoff'),
											'button' => esc_html__('Set As Logo', 'kickoff'),
											'type' => 'upload',
											'description' => 'Please upload your logo supported for example jpeg, gif, png',
										),
										'logo-width' => array(
											'title' => esc_html__('Logo Width', 'kickoff'),
											'type' => 'text',
											'default' => '0',
											'description' => 'Please enter the width of the logo in Numbers E.g 20',
											//'selector' => '.kode-logo{ margin-top: #kode#; }',
											'data-type' => 'pixel'
										),
										'logo-height' => array(
											'title' => esc_html__('Logo Height', 'kickoff'),
											'type' => 'text',
											'default' => '0',
											'description' => 'Please enter the height of the logo in Numbers E.g 20',
											//'selector' => '.kode-logo{ margin-bottom: #kode#; }',
											'data-type' => 'pixel'
										),											
										'logo-top-margin' => array(
											'title' => esc_html__('Logo Top Margin', 'kickoff'),
											'type' => 'text',
											'default' => '0',
											'description' => 'Please enter the Top Margin of the logo in Numbers E.g 20',
											'selector' => '.kode-logo{ margin-top: #kode#; }',
											'data-type' => 'pixel'
										),
										'logo-bottom-margin' => array(
											'title' => esc_html__('Logo Bottom Margin', 'kickoff'),
											'type' => 'text',
											'default' => '0',
											'description' => 'Please enter the bottom Margin of the logo in Numbers E.g 20',
											'selector' => '.kode-logo{ margin-bottom: #kode#; }',
											'data-type' => 'pixel'
										),	
										'favicon-id' => array(
											'title' => esc_html__('Upload Favicon ( .ico file )', 'kickoff'),
											'button' => esc_html__('Select Icon', 'kickoff'),
											'type' => 'upload',
											'description' => 'You can upload the favicon icon from here.',
										),	
										
									)
								),
								'header-section' => array(
									'title' => esc_html__('Navigation Settings', 'kickoff'),
									'options' => array(
										'enable-header-option' => array(
											'title' => esc_html__('Enable Header All Pages', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'enable'
										),
										'kode-header-style' => array(
											'title' => esc_attr__('Select Header', 'kickoff'),
											'type' => 'radioheader',	
											'description'=>esc_attr__('There are 4 Different Header Styles Available here. Click on the Drop Down menu and select the Header Style here from of your choice.', 'kickoff'),
											'options' => array(
												'header-style-1'=>KODE_PATH . '/framework/include/backend_assets/images/headers/1.png',
												'header-style-2'=>KODE_PATH . '/framework/include/backend_assets/images/headers/2.png',
												'header-style-3'=>KODE_PATH . '/framework/include/backend_assets/images/headers/3.png',
												'header-style-4'=>KODE_PATH . '/framework/include/backend_assets/images/headers/4.png',
											),
										),
										'top_latest_news_btn' => array(
											'title' => esc_html__('Enable Latest News', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'enable',
											'description' => 'You can Enable / Disable the Top Bar from here.',
										),
										'top_latest_news_title' => array(
											'title' => esc_html__('Top News Title Text', 'kickoff'),
											'type' => 'text',				
											'default'=>'Latest News',
											'wrapper-class'=> '',									
											'description'=>esc_html__('Add Top News title text here to show before slider for example: Latest News.', 'kickoff')
										),
										'top_latest_news' => array(
											'title' => esc_html__('Latest News' , 'kickoff'),
											'type' => 'combobox',
											'options' => kode_get_term_list('category'),
											'wrapper-class'=> '',									
											'description'=> esc_html__('Select Category to Fetch its Posts.', 'kickoff')
										),
										'enable-sticky-menu' => array(
											'title' => esc_html__('Enable Sticky', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'disable',
											'description' => 'You can Enable / Disable the Sticky menu from here.',
										),
										'enable-sticky-class' => array(
											'title' => esc_html__('Sticky Menu Starts', 'kickoff'),
											'type' => 'text',				
											'default'=>'',
											'description'=>esc_html__('Please add class or id of section or element from where sticky menu starts for example: #kode-parallax-wrapper-3.', 'kickoff')
										),
										'enable-top-bar' => array(
											'title' => esc_html__('Enable Top Bar', 'kickoff'),
											'type' => 'checkbox',	
											'wrapper-class'=> '',
											'description'=>esc_html__('Click here to enable / disable the top bar from here.', 'kickoff')		
										),
										'enable-top-bar-login' => array(
											'title' => esc_html__('Enable Top Bar login', 'kickoff'),
											'type' => 'checkbox',	
											'wrapper-class'=> '',
										'description'=>esc_html__('Click here to enable / disable the top bar login from here.', 'kickoff')		
										),
										'enable-one-page-header-navi' => array(
											'title' => esc_html__('Enable One Page Header Nav', 'kickoff'),
											'type' => 'checkbox',
											'default' =>'disable',
											'description' => 'You can Enable / Disable One page navigation site from here.',
										),
										// 'top-bar-left-text' => array(
											// 'title' => esc_html__('Top Bar Left Text', 'kickoff'),
											// 'type' => 'textarea',	
										// ),	
										// 'top-bar-right-text' => array(
											// 'title' => esc_html__('Top Bar Right Text', 'kickoff'),
											// 'type' => 'textarea',	
											
										// ),
										'enable-breadcrumbs' => array(
											'title' => esc_html__('Breadcrumbs', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'disable',
											'description' => 'You can Enable / Disable the breadcrumbs section from here.',
										)
									)
								),
								'navigation-settings' => array(
									'title' => esc_html__('Navigation Styling', 'kickoff'),
									'options' => array(
										'navi-color' => array(
											'title' => esc_html__('Navigation Text Color', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation text color.',
											//'selector'=> '.navigation ul > li > a, .navbar-nav > li > a{color: #kode#;}'
										),
										'navi-hover-bg' => array(
											'title' => esc_html__('Navigation Text Hover BG', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation hover BG color.',
											//'selector'=> '.navigation ul > li::before, .navbar-nav > li::before{background: #kode#;}'
										),
										'navi-hover-color' => array(
											'title' => esc_html__('Navigation Text Hover Color', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation hover color.',
											//'selector'=> '.navigation ul > li:hover a, .navbar-nav > li:hover{color: #kode#;}'
										),	
										'navi-dropdown-bg' => array(
											'title' => esc_html__('Navigation DropDown BG', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation dropdown-bg color.',
											//'selector'=> '.navigation .sub-menu, .navigation .children, .navbar-nav .children{background: #kode#;}'
										),	
										'navi-dropdown-hover' => array(
											'title' => esc_html__('Navigation DropDown Text Hover', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation dropdown hover color.',
											//'selector'=> '.navigation ul li ul li::before, .navbar-nav li ul li::before{background: #kode#;}'
										),										
										'navi-dropdown-color' => array(
											'title' => esc_html__('Navigation DropDown Text Color', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picker allows you to change the navigation dropdown color.',
											//'selector'=> '.navigation .sub-menu, .navigation .children, .navbar-nav .children{color: #kode#;}'
										),
										
									)
								),	
									
								'layout-style' => array(
									'title' => esc_html__('Style & Layouts', 'kickoff'),
									'options' => array(
										'color-scheme-one' => array(
											'title' => esc_html__('Color Scheme Color One', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'selector'=> '',
											'description' => 'This Color Picker allows you to change the Color Scheme 1 of your site.',
										),
										'color-scheme-two' => array(
											'title' => esc_html__('Color Scheme Color Two', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'selector'=> '',
											'description' => 'This Color Picker allows you to change the Color Scheme 2 of your site.',
										),
										'color-scheme-three' => array(
											'title' => esc_html__('Color Scheme Color Three', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'selector'=> '',
											'description' => 'This Color Picker allows you to change the Color Scheme 3 of your site.',
										),
										'enable-boxed-style' => array(
											'title' => esc_html__('Website Layout', 'kickoff'),
											'type' => 'combobox',
											'description' => 'You can change your site layout to Full Width / Boxed Style',	
											'options' => array(
												'full-style' => esc_html__('Full Style', 'kickoff'),
												'boxed-style' => esc_html__('Boxed Style', 'kickoff')
											)
										),
										'kode-body-style' => array(
											'title' => esc_html__('Body Background Style', 'kickoff'),
											'type' => 'combobox',	
											'description' => 'You have selected the Boxed Layout. Now you can set your Boxed layout style from here.',
											'options' => array(
												'body-color' => esc_html__('Body Background Color', 'kickoff'),
												'body-background' => esc_html__('Body Background Image', 'kickoff'),
												'body-pattern' => esc_html__('Body Background Pattern', 'kickoff'),
											),
											'wrapper-class'=> 'boxed-style-wrapper enable-boxed-style-wrapper'
										),	
										'body-bg-color' => array(
											'title' => esc_html__('Body Background Color', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#ffffff',
											'description' => 'This Color Picket allows you to change Body Background Color for the Boxed Layout.',
											'wrapper-class'=> 'boxed-style-wrapper enable-boxed-style-wrapper body-color-wrapper kode-body-style-wrapper',
											'selector'=> ''
										),
										'body-background-image' => array(
											'title' => esc_html__('Background Image', 'kickoff'),
											'type' => 'upload',
											'description' => 'You can upload the background image for your Boxed Layout.',
											'wrapper-class'=> 'boxed-style-wrapper enable-boxed-style-wrapper body-background-wrapper kode-body-style-wrapper'
										),	
										'body-background-pattern' => array(
											'title' => esc_html__('Background Pattern', 'kickoff'),
											'type' => 'radioimage',
											'description' => 'There are 18 Built in Background patterns available in the theme. Just Select the pattern and save the Changes.',
											'options' => array(
												'1'=>KODE_PATH . '/images/pattern/pattern_1.png',
												'2'=>KODE_PATH . '/images/pattern/pattern_2.png', 
												'3'=>KODE_PATH . '/images/pattern/pattern_3.png',
												'4'=>KODE_PATH . '/images/pattern/pattern_4.png',
												'5'=>KODE_PATH . '/images/pattern/pattern_5.png',
												'6'=>KODE_PATH . '/images/pattern/pattern_6.png',
												'7'=>KODE_PATH . '/images/pattern/pattern_7.png',
												'8'=>KODE_PATH . '/images/pattern/pattern_8.png',
												'9'=>KODE_PATH . '/images/pattern/pattern_9.png',
												'10'=>KODE_PATH . '/images/pattern/pattern_10.png', 
												'11'=>KODE_PATH . '/images/pattern/pattern_11.png',
												'12'=>KODE_PATH . '/images/pattern/pattern_12.png',
												'13'=>KODE_PATH . '/images/pattern/pattern_13.png',
												'14'=>KODE_PATH . '/images/pattern/pattern_14.png',
												'15'=>KODE_PATH . '/images/pattern/pattern_15.png',
												'16'=>KODE_PATH . '/images/pattern/pattern_16.png',
												'17'=>KODE_PATH . '/images/pattern/pattern_17.png',
												'18'=>KODE_PATH . '/images/pattern/pattern_18.png'
											),
											'wrapper-class' => 'boxed-style-wrapper enable-boxed-style-wrapper pattern-size-wrap body-pattern-wrapper kode-body-style-wrapper',
											'default' => '1'
										),	
										'kode-body-position' => array(
											'title' => esc_html__('Body Background Position', 'kickoff'),
											'type' => 'combobox',	
											'description' => 'Select the Body Background Position you want to have for your site.',
											'options' => array(
												'body-scroll' => esc_html__('Scroll', 'kickoff'),
												'body-fixed' => esc_html__('Fixed', 'kickoff')												
											),
											'wrapper-class'=> 'boxed-style-wrapper enable-boxed-style-wrapper body-background-wrapper kode-body-style-wrapper'
										),	
										'enable-nice-scroll' => array(
											'title' => esc_html__('Nice Scroll', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'enable',
											'description' => 'You can Enable / Disable the Nice Scroll from here.',
										),
										'enable-rtl-layout' => array(
											'title' => esc_html__('Enable RTL', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'disable',
											'description' => 'You can Enable / Disable the RTL Layout of your site.',
										),
										'enable-responsive-mode' => array(
											'title' => esc_html__('Enable Responsive', 'kickoff'),
											'type' => 'checkbox',	
											'default' => 'enable',
											'description' => 'You can Enable / Disable the Responsive Layout of your site.',
										),		
										'video-ratio' => array(
											'title' => esc_html__('Default Video Ratio', 'kickoff'),
											'type' => 'text',				
											'default'=>'16/9',
											'description'=>esc_html__('Please only fill number/number as default video ratio', 'kickoff')
										),	
										'player-table' => array(
											'title' => esc_html__('Player Detail Table ', 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
											'description'=>esc_html__('Click here to turn Off the player detail matches , tournament detail table from here.', 'kickoff')
										),	
										'page-author-box' => array(
											'title' => esc_html__('Page Author', 'kickoff'),
											'type' => 'checkbox',
											'description'=> esc_html__('You can enable or disable the about author box from here.', 'kickoff'),
											'default' => 'enable',											
										),											
									)
								),	
								'footer-style' => array(
									'title' => esc_html__('Footer Settings', 'kickoff'),
									'options' => array(
										'show-footer' => array(
											'title' => esc_html__('Show Footer', 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
											'description' => 'You can Switch On / Off the Footer From here.',
										),
										'kode-footer-style' => array(
											'title' => esc_attr__('Select Footer', 'kickoff'),
											'type' => 'radioheader',	
											'description'=>esc_attr__('There are 3 Different Footer Styles Available here. Click on the Drop Down menu and select the Footer Style here from of your choice.', 'kickoff'),
											'options' => array(
												'footer-style-1'=>KODE_PATH . '/framework/include/backend_assets/images/footer/footer-1.jpg',
												'footer-style-2'=>KODE_PATH . '/framework/include/backend_assets/images/footer/footer-2.jpg',
												'footer-style-3'=>KODE_PATH . '/framework/include/backend_assets/images/footer/footer-3.jpg',
											),
										),
										'footer-background-color' => array(
											'title' => esc_html__('Footer Background Color', 'kickoff'),
											'type' => 'colorpicker',
											'default' => '#000',
											'description' => 'This Color Picker Allows you to change the Footer Background Color.',											
										),
										'footer-background-opacity'=> array(
											'title'=> esc_html__('Footer Background Opacity' ,'kickoff'),
											'type'=> 'text',												
											'default' => '0.6',
											'description'=> esc_html__('Adjust footer background opacity from 0 to 1.', 'kickoff')
										),
										'footer-background-image' => array(
											'title' => esc_html__('Footer Background Image', 'kickoff'),
											'button' => esc_html__('Upload', 'kickoff'),
											'type' => 'upload'		,
											'description' => 'You can Upload the footer Background Image from here.',											
										),
										'footer-layout' => array(
											'title' => esc_html__('Footer Layout', 'kickoff'),
											'type' => 'radioimage',
											'description' => 'There are 4 Footer Styles available in the theme. You can select any of the style you wish to have.',
											'options' => array(
												'1'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style1.png',
												'2'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style2.png', 
												'3'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style3.png',
												//'4'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style4.png',
												//'5'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style5.png',
												'6'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style6.png',
												'7'=>	KODE_PATH . '/framework/include/backend_assets/images/footer-style7.png'												
											),
											'default' => '2'
										),
										// 'show-widget-heading-border' => array(
											// 'title' => esc_html__('Show Footer Heading Border', 'kickoff'),
											// 'type' => 'checkbox',
											// 'default' => 'enable'
										// ),
										'footer-newsletter' => array(
											'title' => esc_html__('Show Newsletter', 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
											'description'=> esc_html__('Click here to Turn On / off the footer Newsletter.', 'kickoff'),
										),
										'footer-newsletter-style' => array(
											'title' => esc_html__('Footer Layout', 'kickoff'),
											'type' => 'radioimage',
											'description' => 'There are 4 Footer Styles available in the theme. You can select any of the style you wish to have.',
											'options' => array(
												'style-1'=>	KODE_PATH . '/framework/include/backend_assets/images/newsletter/newsletter-1.png',
												'style-2'=>	KODE_PATH . '/framework/include/backend_assets/images/newsletter/newsletter-2.png', 
											),
											'default' => 'style-1'
										),
										'show-copyright' => array(
											'title' => esc_html__('Show Copyright', 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
											'description'=> esc_html__('Click here to Turn On / off the Copyright area.', 'kickoff'),
										),
										'kode-copyright-text' => array(
											'title' => esc_html__('Copyright Text', 'kickoff'),
											'type' => 'textarea',	
											'class' => 'full-width',
											'description'=> esc_html__('Enter the copyright text here.', 'kickoff'),
										),	
									)
								),									
								'page-style' => array(
									'title' => esc_html__('Sub Header', 'kickoff'),
									'options' => array(
										'default-page-title' => array(
											'title' => esc_html__('Default Page Title Background', 'kickoff'),
											'type' => 'upload',	
											'selector' => '.kode-subheader { background-image: url(\'#kode#\'); }',
											'data-type' => 'upload',
											'description' => 'You can Upload the Default Page Title Header Background from here.',
										),	
										'default-post-title-background' => array(
											'title' => esc_html__('Default Post Title Background', 'kickoff'),
											'type' => 'upload',	
											'selector' => 'body.single .kode-subheader { background-image: url(\'#kode#\'); }',
											'data-type' => 'upload',
											'description' => 'You can Upload the Default Post Title Header Background from here.',
										),
										'default-search-archive-title-background' => array(
											'title' => esc_html__('Default Search Archive Title Header Background', 'kickoff'),
											'type' => 'upload',	
											'selector' => 'body.archive .kode-subheader, body.search .kode-subheader { background-image: url(\'#kode#\'); }',
											'data-type' => 'upload',
											'description' => 'You can Upload the Default Search / Archive Title Background from here.',
										),
										'default-404-title-background' => array(
											'title' => esc_html__('Default 404 Title Background', 'kickoff'),
											'type' => 'upload',	
											'selector' => 'body.error404 .kode-subheader { background-image: url(\'#kode#\'); }',
											'data-type' => 'upload',
											'description' => 'You can Upload the 404 Page Title Header Background from here.',
										),										
									)
								),
								
								
								//'blog-style' => array(),	
								
								//'portfolio-style' => array(),		

								// 'search-archive-style' => array(
									// 'title' => esc_html__('Search - Archive Style', 'kickoff'),
									// 'options' => array(
										// 'archive-sidebar-template' => array(
											// 'title' => esc_html__('Search - Archive Sidebar Template', 'kickoff'),
											// 'type' => 'radioimage',
											// 'options' => array(
												// 'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
												// 'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
												// 'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
												// 'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
											// ),
											// 'default' => 'no-sidebar'							
										// ),
										// 'archive-sidebar-left' => array(
											// 'title' => esc_html__('Search - Archive Sidebar Left', 'kickoff'),
											// 'type' => 'combobox_sidebar',
											// 'options' => $kode_theme_option['sidebar-element'],		
											// 'wrapper-class'=>'left-sidebar-wrapper both-sidebar-wrapper archive-sidebar-template-wrapper',											
										// ),
										// 'archive-sidebar-right' => array(
											// 'title' => esc_html__('Search - Archive Sidebar Right', 'kickoff'),
											// 'type' => 'combobox_sidebar',
											// 'options' => $kode_theme_option['sidebar-element'],
											// 'wrapper-class'=>'right-sidebar-wrapper both-sidebar-wrapper archive-sidebar-template-wrapper',
										// ),		
										// 'archive-blog-style' => array(
											// 'title' => esc_html__('Search - Archive Blog Style', 'kickoff'),
											// 'type' => 'combobox',
											// 'options' => array(
												// 'blog-grid' => esc_html__('Blog Grid', 'kickoff'),
												// 'blog-full' => esc_html__('Blog Full', 'kickoff'),
											// ),
											// 'default' => 'blog-full'							
										// ),	
										// 'archive-col-size' => array(
											// 'title' => esc_html__('Search - Archive Blog Style', 'kickoff'),
											// 'type' => 'combobox',
											// 'options' => array(
												// '2' => esc_html__('2 Column', 'kickoff'),
												// '3' => esc_html__('3 Column', 'kickoff'),
												// '4' => esc_html__('4 Column', 'kickoff'),
											// ),
											// 'default' => 'blog-full'							
										// ),
										// 'archive-col-size'=> array(
											// 'title'=> esc_html__('Column size' ,'kickoff'),
											// 'type'=> 'text',	
											// 'default'=> '3',
											// 'wrapper-class'=>'blog-grid-wrapper archive-blog-style-wrapper',
											// 'description'=> esc_html__('Select the column width of content.', 'kickoff')
										// ),										
										// 'archive-num-excerpt'=> array(
											// 'title'=> esc_html__('Search - Archive Num Excerpt (Word)' ,'kickoff'),
											// 'type'=> 'text',	
											// 'default'=> '25',
											// 'wrapper-class'=>'blog-full-wrapper archive-blog-style-wrapper',
											// 'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the post excerpt. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
										// ),
									// )
								// ),			
								
								'server-configuration' => array(
									'title' => esc_html__('System Diagnostic Information', 'kickoff'),
									'options' => array(
										'server-config' => array(
											'title' => esc_html__('Server Configuration', 'kickoff'),
											'type' => 'server-config',
											'wrapper-class' => 'server-config',
											'description' => 'Above information is useful to diagnose some of the possible reasons to malfunctions, performance issues or any errors. You can faciliate the process of support by providing below information to our support staff.',
										),
									)
								),
								
								'import-export-option' => array(
									'title' => esc_html__('Import/Export Option', 'kickoff'),
									'options' => array(
										'export-option' => array(
											'title' => esc_html__('Export Option', 'kickoff'),
											'type' => 'custom',
											'description'=> esc_html__('Here you can copy/download your themes current option settings. Keep this safe as you can use it as a backup should anything go wrong. Or you can use it to restore your settings on this site (or any other site). You also have the handy option to copy the link to yours sites settings. Which you can then use to duplicate on another site.', 'kickoff'),
											'option' => 
												'<input type="button" id="kode-export" class="kdf-button" value="' . esc_html__('Export', 'kickoff') . '" />' .
												'<textarea class="full-width"></textarea>'
										),
										'import-option' => array(
											'title' => esc_html__('Import Option', 'kickoff'),
											'type' => 'custom',
											'description'=> esc_html__('WARNING! This will overwrite any existing options, please proceed with caution!', 'kickoff'),
											'option' => 
												'<input type="button" id="kode-import" class="kdf-button" value="' . esc_html__('Import', 'kickoff') . '" />' .
												'<textarea class="full-width"></textarea>'
										),										
									)
								)	
							)
						),
						
						'blog-style' => array(
							'title' => esc_html__('Blog Settings', 'kickoff'),
							'icon' => 'fa fa-cubes',
							'options' => array(
								'search-archive-style' => array(
									'title' => esc_html__('Index Search - Archive Style', 'kickoff'),
									'options' => array(
										'archive-sidebar-template' => array(
											'title' => esc_html__('Index Search - Archive Sidebar Template', 'kickoff'),
											'type' => 'radioimage',
											'description' => 'You can Select the Search / Archive page sidebar position from here.',
											'options' => array(
												'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
												'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
												'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
												'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
											),
											'default' => 'no-sidebar'							
										),
										'archive-sidebar-left' => array(
											'title' => esc_html__('Search - Archive Sidebar Left', 'kickoff'),
											'type' => 'combobox_sidebar',
											'options' => $kode_theme_option['sidebar-element'],		
											'wrapper-class'=>'left-sidebar-wrapper both-sidebar-wrapper archive-sidebar-template-wrapper',											
										),
										'archive-sidebar-right' => array(
											'title' => esc_html__('Search - Archive Sidebar Right', 'kickoff'),
											'type' => 'combobox_sidebar',
											'options' => $kode_theme_option['sidebar-element'],
											'wrapper-class'=>'right-sidebar-wrapper both-sidebar-wrapper archive-sidebar-template-wrapper',
										),		
										'archive-blog-style' => array(
											'title' => esc_html__('Search - Archive Blog Style', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'blog-grid' => esc_html__('Blog Grid', 'kickoff'),
												'blog-full' => esc_html__('Blog Full', 'kickoff'),
											),
											'default' => 'blog-full'							
										),	
										'archive-col-size' => array(
											'title' => esc_html__('Search - Archive Blog Style', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'2' => esc_html__('2 Column', 'kickoff'),
												'3' => esc_html__('3 Column', 'kickoff'),
												'4' => esc_html__('4 Column', 'kickoff'),
											),
											'default' => 'blog-full'							
										),
										'archive-col-size'=> array(
											'title'=> esc_html__('Column size' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '3',
											'wrapper-class'=>'blog-grid-wrapper archive-blog-style-wrapper',
											'description'=> esc_html__('Select the column width of content.', 'kickoff')
										),										
										'archive-num-excerpt'=> array(
											'title'=> esc_html__('Search - Archive Num Excerpt (Word)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'wrapper-class'=>'blog-full-wrapper archive-blog-style-wrapper',
											'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the post excerpt. Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag.', 'kickoff')
										),
									)
								),	
								'blog-single' => array(
									'title' => esc_html__('Blog Single', 'kickoff'),
									'options' => array(
										// 'post-title' => array(
											// 'title' => 'Sub Header Post Title',
											// 'type' => 'text',	
											// 'description' => 'Sub Header Post Title'
										// ),
										// 'post-caption' => array(
											// 'title' => 'Sub Header Post Caption',
											// 'type' => 'textarea',
											// 'description' => 'Add Sub Header Post Caption'
										// ),
										
										'post-sidebar-template' => array(
											'title' => esc_html__('Single Default Sidebar', 'kickoff'),
											'type' => 'radioimage',
											'options' => array(
												'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
												'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
												'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
												'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
											),
										),
										'post-sidebar-left' => array(
											'title' => esc_html__('Single Default Sidebar Left', 'kickoff'),
											'type' => 'combobox_sidebar',
											'wrapper-class' => 'left-sidebar-wrapper both-sidebar-wrapper post-sidebar-template-wrapper',
											'options' => $kode_theme_option['sidebar-element'],		
										),
										'post-sidebar-right' => array(
											'title' => esc_html__('Single Default Sidebar Right', 'kickoff'),
											'type' => 'combobox_sidebar',
											'wrapper-class' => 'right-sidebar-wrapper both-sidebar-wrapper post-sidebar-template-wrapper',
											'options' => $kode_theme_option['sidebar-element'],
										),	
										'single-post-feature-image' => array(
											'title' => esc_html__('Single Post Feature Image', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('If you do not want to set a featured image (in case of sound post type : Audio player, in case of video post type : Video Player) kindly disable it here.', 'kickoff'),
											'default' => 'enable'
										),
										'single-post-date' => array(
											'title' => esc_html__('Single Post Date', 'kickoff'),
											'type' => 'checkbox',
											'description'=> esc_html__('Using this option you can show/hide extra information about the blog or post,  Date.', 'kickoff'),											
											'default' => 'enable'
										),
										'single-post-author2' => array(
											'title' => esc_html__('Single Post Author', 'kickoff'),
											'type' => 'checkbox',
											'description'=> esc_html__('You can enable or disable the about author box from here.', 'kickoff'),
											'default' => 'enable',											
										),	
										'single-post-comments' => array(
											'title' => esc_html__('Single Post Comments', 'kickoff'),
											'type' => 'checkbox',
											'description'=> esc_html__('Using this option you can show/hide extra information about the blog or post,  Comments.', 'kickoff'),		
											'default' => 'enable'
										),
										'single-post-meta' => array(
											'title' => esc_html__('Single Meta', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option you can show/hide Post Meta information about the blog or post,  Tags.', 'kickoff'),
											'default' => 'enable'
										),
										'single-next-pre' => array(
											'title' => esc_html__('Single Next / Previous Button', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option you can turn on/off the navigation arrows when viewing the blog single page.', 'kickoff'),
											'default' => 'enable'
										),
									)
								),
							),
						),		
						
						'event-style' => array(
							'title' => esc_html__('Event Settings', 'kickoff'),
							'icon' => 'fa-calendar-check-o',
							'options' => array(
								'Event-single' => array(
									'title' => esc_html__('Event Single', 'kickoff'),
									'options' => array(
										'single-team-performance-one' => array(
											'title' => esc_html__('Single Team Performance Table One', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Team Performance Table One.', 'kickoff'),
											'default' => 'enable'
										),
										'single-team-performance-two' => array(
											'title' => esc_html__('Single Team Performance Table Two', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Team Performance Table Two.', 'kickoff'),
											'default' => 'enable'
										),
										'team-player-line-up-one' => array(
											'title' => esc_html__('Single Player Line Up Table One', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Player Line Up Table One.', 'kickoff'),
											'default' => 'enable'
										),
										'team-player-line-up-two' => array(
											'title' => esc_html__('Single Player Line Up Table Two', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Player Line Up Table Two.', 'kickoff'),
											'default' => 'enable'
										),
										'single-event-booking' => array(
											'title' => esc_html__('Single Booking Events', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Booking for the Events from here.', 'kickoff'),
											'default' => 'enable'
										),
										'single-event-comments' => array(
											'title' => esc_html__('Single Booking Comments', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('You can switch On/Off the Comments Section of the Events from here.', 'kickoff'),
											'default' => 'enable'
										),
									)
								),
							),
						),

						'woocommerce-style' => array(
							'title' => esc_html__('Woo Settings', 'kickoff'),
							'icon' => 'fa fa-shopping-cart',
							'options' => array(
								'woocommerce-single' => array(
									'title' => esc_html__('WooCommerce Single', 'kickoff'),
									'options' => array(	
										'woo-post-title' => array(
											'title' => esc_html__('Woo Post Title', 'kickoff'),
											'type' => 'checkbox',
											'description'=> esc_html__('Using this option to show/hide Woocommerce Product Titles at the Product Details page', 'kickoff'),											
											'default' => 'enable'
										),
										'woo-post-price' => array(
											'title' => esc_html__('Woo Post Price', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Prices at the Product Details page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-post-variable-price' => array(
											'title' => esc_html__('Woo Post Variable Price', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Variables Products Prices at the Product Details page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-post-related' => array(
											'title' => esc_html__('Woo Post Related', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Related Products at the Product Details page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-post-sku' => array(
											'title' => esc_html__('Woo Post SKU', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce SKU Number at the Product Details page', 'kickoff'),	
											'default' => 'enable'
										),
										'woo-post-category' => array(
											'title' => esc_html__('Woo Post Category', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Category at the Product Details page', 'kickoff'),	
											'default' => 'enable'
										),
										'woo-post-tags' => array(
											'title' => esc_html__('Woo Post Tags', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Tags at the Product Details page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-post-outofstock' => array(
											'title' => esc_html__('Woo Post Out of Stock Icon', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Out Of Stock text', 'kickoff'),
											'default' => 'enable'
										),
										'woo-post-saleicon' => array(
											'title' => esc_html__('Woo Post Sale Icon', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Sale Icon', 'kickoff'),
											'default' => 'enable'
										)
									)
								),	
								'woocommerce-list' => array(
									'title' => esc_html__('WooCommerce Listing', 'kickoff'),
									'options' => array(	
										'woo-list-cart-btn' => array(
											'title' => esc_html__('Woo List Cart Button', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Cart Icon at the listing page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-list-title' => array(
											'title' => esc_html__('Woo List Title', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products  Titles at the listing page', 'kickoff'),
											'default' => 'enable'
										),
										'woo-list-price' => array(
											'title' => esc_html__('Woo List Price', 'kickoff'),
											'type' => 'checkbox',	
											'description'=> esc_html__('Using this option to show/hide Woocommerce Products Prices at the listing page', 'kickoff'),	
											'default' => 'enable'
										),
										// 'woo-list-rating' => array(
											// 'title' => esc_html__('Woo List Rating', 'kickoff'),
											// 'type' => 'checkbox',	
											// 'description'=> esc_html__('Using this option to show/hide Woocommerce Products rating stars at the listing page.', 'kickoff'),	
											// 'default' => 'enable'
										// ),
										'all-products-per-row' => array(
											'title' => esc_html__('Products Per Row', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'1'=> '1',
												'2'=> '2',
												'3'=> '3',
												'4'=> '4',
												'5'=> '5'
											),
											'default' => '3'							
										),
										'all-products-sidebar' => array(
											'title' => esc_html__('All Products Sidebar', 'kickoff'),
											'type' => 'radioimage',
											'description'=> esc_html__('You can select the Shop layout Side bar layout from here.', 'kickoff'),
											'options' => array(
												'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
												'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
												'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
												'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
											),
											'default' => 'no-sidebar'							
										),
										'all-products-sidebar-left' => array(
											'title' => esc_html__('All Products Sidebar Left', 'kickoff'),
											'type' => 'combobox_sidebar',
											'description'=> esc_html__('You can select the left side bar for your shop page from here.', 'kickoff'),
											'options' => $kode_theme_option['sidebar-element'],		
											'wrapper-class'=>'left-sidebar-wrapper both-sidebar-wrapper all-products-sidebar-wrapper',											
										),
										'all-products-sidebar-right' => array(
											'title' => esc_html__('All Products Sidebar Right', 'kickoff'),
											'type' => 'combobox_sidebar',
											'description'=> esc_html__('You can select the right side bar for your shop page from here.', 'kickoff'),
											'options' => $kode_theme_option['sidebar-element'],
											'wrapper-class'=>'right-sidebar-wrapper both-sidebar-wrapper all-products-sidebar-wrapper',
										)
									)
								),								
							),
						),		

						// overall elements menu
						'overall-elements' => array(
							'title' => esc_html__('Social Settings', 'kickoff'),
							'icon' => 'fa fa-share-square-o',
							'options' => array(

								'header-social' => array(),
								
								'social-shares' => array(),
								
							)				
						),
						
						// font setting menu
						'font-settings' => array(
							'title' => esc_html__('Font Settings', 'kickoff'),
							'icon' => 'fa fa-font',
							'options' => array(
								'font-family' => array(
								'title' => esc_html__('Font Family', 'kickoff'),
									'options' => array(
										'navi-font-family' => array(
											'title' => esc_html__('Navigation Font', 'kickoff'),
											'type' => 'font_option',
											'default' => 'Arial, Helvetica, sans-serif',
											'description'=> esc_html__('Please Select the Navigation Font Family from here.', 'kickoff'),
											'data-type' => 'font_option',
											'selector' => '.kode-navigation{ font-family: #gdlr#; }'
										),
										'heading-font-family' => array(
											'title' => esc_html__('Header Font', 'kickoff'),
											'type' => 'font_option',
											'default' => 'Arial, Helvetica, sans-serif',
											'description'=> esc_html__('Please Select the Heading Font Family from here.', 'kickoff'),
											'data-type' => 'font_option',
											'selector' => 'h1, h2, h3, h4, h5, h6{ font-family: #gdlr#; }'
										),			
										'body-font-family' => array(
											'title' => esc_html__('Content Font', 'kickoff'),
											'type' => 'font_option',
											'default' => 'Arial, Helvetica, sans-serif',
											'description'=> esc_html__('Please Select the Body / Content Font Family from here.', 'kickoff'),
											'data-type' => 'font_option',
											'selector' => 'body, input, textarea{ font-family: #gdlr#; }'
										),			
										
									),	
								),

								'font-size' => array(
									'title' => esc_html__('Font Size', 'kickoff'),
									'options' => array(
										
										'content-font-size' => array(
											'title' => esc_html__('Content Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '14',
											'description'=> esc_html__('This option will let you increase / decrease the Content Size of the site.', 'kickoff'),
											//'selector' => 'body{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),				
										'h1-font-size' => array(
											'title' => esc_html__('H1 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '30',
											'description'=> esc_html__('This option will let you increase / decrease the H1 Size of the site.', 'kickoff'),
											//'selector' => 'h1{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'h2-font-size' => array(
											'title' => esc_html__('H2 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '25',
											'description'=> esc_html__('This option will let you increase / decrease the H2 Size of the site.', 'kickoff'),
											//'selector' => 'h2{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'h3-font-size' => array(
											'title' => esc_html__('H3 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '20',
											'description'=> esc_html__('This option will let you increase / decrease the H3 Size of the site.', 'kickoff'),
											//'selector' => 'h3{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'h4-font-size' => array(
											'title' => esc_html__('H4 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '18',
											'description'=> esc_html__('This option will let you increase / decrease the H4 Size of the site.', 'kickoff'),
											//'selector' => 'h4{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'h5-font-size' => array(
											'title' => esc_html__('H5 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '16',
											'description'=> esc_html__('This option will let you increase / decrease the H5 Size of the site.', 'kickoff'),
											//'selector' => 'h5{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'h6-font-size' => array(
											'title' => esc_html__('H6 Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '15',
											'description'=> esc_html__('This option will let you increase / decrease the H6 Size of the site.', 'kickoff'),
											//'selector' => 'h6{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										
									)
								),								
							)					
						),
							
						
						// plugin setting menu
						'plugin-settings' => array(
							'title' => esc_html__('Slider Settings', 'kickoff'),
							'icon' => 'fa fa-image',
							'options' => array(
								'bx-slider' => array(
									'title' => esc_html__('BX Slider', 'kickoff'),
									'options' => array(		
										'bx-slider-effects' => array(
											'title' => esc_html__('BX Slider Effect', 'kickoff'),
											'type' => 'combobox',
											'description'=> esc_html__('You can select the BX slide effect from the dropdown menu.', 'kickoff'),
											'options' => array(
												'fade' => esc_html__('Fade', 'kickoff'),
												'slide'	=> esc_html__('Slide', 'kickoff')
											)
										),
										'bx-pause-time' => array(
											'title' => esc_html__('BX Slider Pause Time', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the BX slide pause time from the dropdown menu.', 'kickoff'),
											'default' => '7000'
										),
										'bx-slide-speed' => array(
											'title' => esc_html__('BX Slider Animation Speed', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the BX slide speed from the dropdown menu.', 'kickoff'),
											'default' => '600'
										),	
									)
								),
								'flex-slider' => array(
									'title' => esc_html__('Flex Slider', 'kickoff'),
									'options' => array(		
										'flex-slider-effects' => array(
											'title' => esc_html__('Flex Slider Effect', 'kickoff'),
											'type' => 'combobox',
											'description'=> esc_html__('You can select the Flex slide effect from the dropdown menu.', 'kickoff'),
											'options' => array(
												'fade' => esc_html__('Fade', 'kickoff'),
												'slide'	=> esc_html__('Slide', 'kickoff')
											)
										),
										'flex-pause-time' => array(
											'title' => esc_html__('Flex Slider Pause Time', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the Flex slide pause time from the dropdown menu.', 'kickoff'),
											'default' => '7000'
										),
										'flex-slide-speed' => array(
											'title' => esc_html__('Flex Slider Animation Speed', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the Flex slide speed from the dropdown menu.', 'kickoff'),
											'default' => '600'
										),	
									)
								),
								
								'nivo-slider' => array(
									'title' => esc_html__('Nivo Slider', 'kickoff'),
									'options' => array(		
										'nivo-slider-effects' => array(
											'title' => esc_html__('Nivo Slider Effect', 'kickoff'),
											'type' => 'combobox',
											'description'=> esc_html__('You can select the nivo slide effect from the dropdown menu.', 'kickoff'),
											'options' => array(
												'sliceDownRight'	=> esc_html__('sliceDownRight', 'kickoff'),
												'sliceDownLeft'		=> esc_html__('sliceDownLeft', 'kickoff'),
												'sliceUpRight'		=> esc_html__('sliceUpRight', 'kickoff'),
												'sliceUpLeft'		=> esc_html__('sliceUpLeft', 'kickoff'),
												'sliceUpDown'		=> esc_html__('sliceUpDown', 'kickoff'),
												'sliceUpDownLeft'	=> esc_html__('sliceUpDownLeft', 'kickoff'),
												'fold'				=> esc_html__('fold', 'kickoff'),
												'fade'				=> esc_html__('fade', 'kickoff'),
												'boxRandom'			=> esc_html__('boxRandom', 'kickoff'),
												'boxRain'			=> esc_html__('boxRain', 'kickoff'),
												'boxRainReverse'	=> esc_html__('boxRainReverse', 'kickoff'),
												'boxRainGrow'		=> esc_html__('boxRainGrow', 'kickoff'),
												'boxRainGrowReverse'=> esc_html__('boxRainGrowReverse', 'kickoff')
											)
										),
										'nivo-pause-time' => array(
											'title' => esc_html__('Nivo Slider Pause Time', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the nivo slide pause time from the dropdown menu.', 'kickoff'),
											'default' => '7000'
										),
										'nivo-slide-speed' => array(
											'title' => esc_html__('Nivo Slider Animation Speed', 'kickoff'),
											'type' => 'text',
											'description'=> esc_html__('You can select the nivo slide speed from the dropdown menu.', 'kickoff'),
											'default' => '600'
										),	
									)
								),
								'slider-caption' => array(
									'title' => esc_html__('Slider Caption', 'kickoff'),
									'options' => array(		
										'caption-title-color' => array(
											'title' => esc_html__('Caption Title Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption Title Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),	
										'caption-background-color' => array(
											'title' => esc_html__('Caption Title Background Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption background Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),
										'title-font-size' => array(
											'title' => esc_html__('Caption Title Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '30',
											'range_start' => '30',
											'range_end' => '30',
											'description'=> esc_html__('You can select the Caption Title font size on the slider from here.', 'kickoff'),
											//'selector' => 'h1{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										
										'caption-desc-color' => array(
											'title' => esc_html__('Caption Description Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption Description Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),	
										'caption-font-size' => array(
											'title' => esc_html__('Caption Description Size', 'kickoff'),
											'type' => 'sliderbar',
											'default' => '30',
											'range_start' => '30',
											'range_end' => '30',
											'description'=> esc_html__('You can select the Caption Font Size on the slider from here.', 'kickoff'),
											//'selector' => 'h1{ font-size: #kode#; }',
											'data-type' => 'pixel'											
										),
										'caption-btn-color' => array(
											'title' => esc_html__('Caption Button Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption Button Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),
										'caption-btn-color-border' => array(
											'title' => esc_html__('Caption Button Border Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption Button Border Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),										
										'caption-btn-color-bg' => array(
											'title' => esc_html__('Caption Button Background Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'description'=> esc_html__('You can select the Caption Button Background Color on the slider from here.', 'kickoff'),
											'wrapper-class'=>'show-caption-wrapper yes-wrapper'
										),	
									) ,
								)
							)					
						),
						
						'sidebar-settings' => array(
							'title' => esc_html__('Sidebar Settings', 'kickoff'),
							'icon' => 'fa fa-columns',
							'options' => array(
								'sidebar_element' => array(
									'title' => esc_html__('Sidebar', 'kickoff'),
									'description'=> esc_html__('Enter a name for new sidebar. It must be a valid name which starts with a letter. Then Click on the Add Button to create the Custom Sidebar', 'kickoff'),
									'options' => array(		
										'sidebar-element' => array(
											'title' => esc_html__('Sidebar Name', 'kickoff'),
											'placeholder' => esc_html__('type sidebar name', 'kickoff'),
											'type' => 'sidebar',
											'btn_title' => 'Add Sidebar'
										)										
									)
								),
							)
						),
						'api-settings' => array(
							'title' => esc_html__('API Settings', 'kickoff'),
							'icon' => 'fa fa-gear',
							'options' => array(
								'api_configuration' => array(
									'title' => esc_html__('API Settings', 'kickoff'),
									'options' => array(		
										'mail-chimp-api' => array(
											'title' => esc_html__('Mail Chimp API', 'kickoff'),
											'type' => 'text',
											'default' => 'API KEY',
											'description' => 'Please add mail chimp API Key here'
										),									
										'mail-chimp-listid' => array(
											'title' => esc_html__('MailChimp List ID', 'kickoff'),
											'type' => 'text',
											'description' => 'For getting list id first login to your mail chimp account then click on list > List name and Campaign defaults > you will see list id written on the right side of first section.'
										),
										'google-map-api' => array(
											'title' => esc_html__('Google Map Api', 'kickoff'),
											'type' => 'text',
											'description' => ''
										),
									)
								),
							)
						),
						
					)
				), 
				
				
				
				$kode_theme_option
			);
			
		}
		
	}

?>