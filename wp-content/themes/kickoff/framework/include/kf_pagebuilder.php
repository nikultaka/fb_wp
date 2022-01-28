<?php
	/*	
	*	Kodeforest Pagebuilder File
	*	---------------------------------------------------------------------
	*	This file contains the page builder settings
	*	---------------------------------------------------------------------
	*/	
	
	// create the page option
	add_action('init', 'kode_create_page_options');
	if( !function_exists('kode_create_page_options') ){
	
		function kode_create_page_options(){
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			new kode_page_options( 
					  
				// page option settings
				array(
					// 'page-layout' => array(
						// 'title' => esc_html__('Page Layout', 'kickoff'),
						// 'options' => array(
								// 'sidebar' => array(
									// 'type' => 'radioimage',
									// 'options' => array(
										// 'no-sidebar'=>KODE_PATH . '/include/images/no-sidebar-2.png',
										// 'both-sidebar'=>KODE_PATH . '/include/images/both-sidebar-2.png', 
										// 'right-sidebar'=>KODE_PATH . '/include/images/right-sidebar-2.png',
										// 'left-sidebar'=>KODE_PATH . '/include/images/left-sidebar-2.png'
									// ),
									// 'default'=>'no-sidebar'
								// ),	
								// 'left-sidebar' => array(
									// 'title' => esc_html__('Left Sidebar' , 'kickoff'),
									// 'type' => 'combobox',
									// 'options' => $kode_theme_option['sidebar-element'],
									// 'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								// ),
								// 'right-sidebar' => array(
									// 'title' => esc_html__('Right Sidebar' , 'kickoff'),
									// 'type' => 'combobox',
									// 'options' => $kode_theme_option['sidebar-element'],
									// 'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								// ),		
								// 'page-style' => array(
									// 'title' => esc_html__('Page Style' , 'kickoff'),
									// 'type' => 'combobox',
									// 'options' => array(
										// 'normal'=> esc_html__('Normal', 'kickoff'),
										// 'no-header'=> esc_html__('No Header', 'kickoff'),
										// 'no-footer'=> esc_html__('No Footer', 'kickoff'),
										// 'no-header-footer'=> esc_html__('No Header / No Footer', 'kickoff'),
									// )
								// ),
						// )
					// ),
					
					'page-option' => array(
						'title' => esc_html__('Page Option', 'kickoff'),
						'options' => array(
							'show-sub' => array(
								'title' => esc_html__('Show Sub Header' , 'kickoff'),
								'type' => 'checkbox',
								'default' => 'enable',
								'wrapper-class' => 'four columns kode-btn-icons',
							),	
							'page-caption' => array(
								'title' => esc_html__('Page Caption' , 'kickoff'),
								'type' => 'textarea',
								'wrapper-class' => 'four columns kode-txt-area',
							),								
							'header-background' => array(
								'title' => esc_html__('Header Background Image' , 'kickoff'),
								'button' => esc_html__('Upload', 'kickoff'),
								'type' => 'upload',
								'wrapper-class' => 'four columns kode-bg-sec',
							),
							// 'enable-header-top' => array(
								// 'title' => esc_html__('Enable/Disable Header On Page', 'kickoff'),
								// 'type' => 'checkbox',
								// 'default'=>'enable',
								// 'wrapper-class' => 'three-fifth columns kode-bg-sec',
								// 'description'=> esc_html__('Disabling header will disable the top header by default so that it can be controled by pagebuilder "Header Element".', 'kickoff')											
							// ),
							// 'kode-header-style' => array(
								// 'title' => esc_html__('Header Style', 'kickoff'),
								// 'type' => 'combobox',
								// 'options' => array(
									// 'header-style-1' => esc_html__('Header Style 1', 'kickoff'),
									// 'header-style-2' => esc_html__('Header Style 2', 'kickoff'),
									// 'header-style-3' => esc_html__('Header Style 3', 'kickoff'),
									// 'header-style-4' => esc_html__('Header Style 4', 'kickoff'),
									// 'header-style-5' => esc_html__('Header Style 5', 'kickoff'),
									// 'header-style-6' => esc_html__('Header Style 6', 'kickoff'),
								// ),
								// 'wrapper-class' => 'two-fifth columns kode-bg-sec',
								// 'default'=>'header-style-1'
							// ),								
						)
					),

				),
				// page option attribute
				array(
					'post_type' => array('page'),
					'meta_title' => esc_html__('Page Option', 'kickoff'),
					'meta_slug' => 'kodeforest-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}
	
	// create the page builder
	if( is_admin() ){
		add_action('init', 'kode_create_page_builder_option');
	}
	if( !function_exists('kode_create_page_builder_option') ){	
		function kode_create_page_builder_option(){
			global $kode_theme_option;
			new kode_page_builder( 
				
				// page builder option setting
				apply_filters('kode_page_builder_option',
					array(
						'content-item' => array(
							'title' => esc_html__('Content & Post Options', 'kickoff'),
							'blank_option' => esc_html__('- Select Content Element -', 'kickoff'),
							'options' => array(
								'column1-1' => array(
									'title'=> esc_html__('Column', 'kickoff'),
									'type'=>'wrapper',
									'icon'=>'fa-columns',
									'size'=>'1/1'
								),
								'full-size-wrapper' => array(
									'title'=> esc_html__('Section', 'kickoff'), 
									'type'=>'wrapper',
									'icon'=>'fa-circle-o-notch',
									'options'=>array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'type' => array(
											'title' => esc_html__('Type', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'image'=> esc_html__('Background Image', 'kickoff'),
												'pattern'=> esc_html__('Predefined Pattern', 'kickoff'),
												'video'=> esc_html__('Video Background', 'kickoff'),
												'color'=> esc_html__('Color Background', 'kickoff'),
												'map'=> esc_html__('Google Map', 'kickoff'),
											),
											'default'=>'color'
										),	
										
										'container' => array(
											'title' => esc_html__('Container', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'full-width'=> esc_html__('Full Width', 'kickoff'),
												'container-width'=> esc_html__('Container (inside 1170px)', 'kickoff'),
											),
											'description' => esc_html__('Select container width, container full width section will be full width.', 'kickoff'),
											'default'=>'container-width'
										),
										'map_shortcode' => array(
											'title' => esc_html__('Google Map Shortcode', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'wrapper-class'=>'type-wrapper map-wrapper',
											'description' => esc_html__('Add google map shortcode to add background.', 'kickoff')
										),	
										'video_url' => array(
											'title' => esc_html__('Video URL', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'wrapper-class'=>'type-wrapper video-wrapper',
											'description' => esc_html__('add video url for the parallax video background for mp4', 'kickoff')
										),	
										'video_type' => array(
											'title' => esc_html__('Video Type', 'kickoff'),
											'type' => 'combobox',
											'options' => array(
												'mp4'=> esc_html__('Video Type Mp4 ', 'kickoff'),
												'ogg'=> esc_html__('Video Type Ogg ', 'kickoff'),
												'webm'=> esc_html__('Video Type Webm ', 'kickoff'),
											),
											'wrapper-class'=>'type-wrapper video-wrapper',
											'description' => esc_html__('Select video background type.', 'kickoff'),
											'default'=>'mp4'
										),										
										'background' => array(
											'title' => esc_html__('Background Image', 'kickoff'),
											'button' => esc_html__('Upload', 'kickoff'),
											'type' => 'upload',
											'wrapper-class' => 'type-wrapper image-wrapper'
										),	
										'trans-background'=> array(
											'title'=> esc_html__('Transparent Background' ,'kickoff'),
											'type'=> 'checkbox',
											'wrapper-class' => 'type-wrapper image-wrapper video-wrapper'
										),
										'horizontal-background'=> array(
											'title'=> esc_html__('Horizontal Moving Background' ,'kickoff'),
											'type'=> 'checkbox',
											'wrapper-class' => 'type-wrapper image-wrapper'
										),
										'background-color' => array(
											'title' => esc_html__('Overlay Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',
											'wrapper-class'=>'type-wrapper image-wrapper color-wrapper video-wrapper'
										),												
										'opacity' => array(
											'title' => esc_html__('Opacity', 'kickoff'),
											'type' => 'text',
											'default' => '0.03',
											'wrapper-class'=>'type-wrapper image-wrapper video-wrapper',
											'description' => esc_html__('add opacity to the background image. for example from .01 to 1', 'kickoff')
										),	
										'background-speed' => array(
											'title' => esc_html__('Background Speed', 'kickoff'),
											'type' => 'text',
											'default' => '0',
											'wrapper-class' => 'type-wrapper image-wrapper',
											'description' => esc_html__('Fill 0 if you don\'t want the background to scroll and 1 when you want the background to have the same speed as the scroll bar', 'kickoff') .
												'<br><br><strong>' . esc_html__('*** only allow the number between -1 to 1', 'kickoff') . '</strong>'
										),
										'padding-top' => array(
											'title' => esc_html__('Padding Top', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Spaces before starting any content in this section', 'kickoff')
										),	
										'padding-bottom' => array(
											'title' => esc_html__('Padding Bottom', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Spaces after ending of the content in this section', 'kickoff')
										),
									)
								),
								'headings' => array(
									'title'=> esc_html__('Fancy Heading', 'kickoff'), 
									'icon'=>'fa-header',
									'type'=>'item',
									'options'=>  array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),
										'alignment'=> array(
											'title'=> esc_html__('Alignment' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'left'=>esc_html__('Left', 'kickoff'), 
												'right'=>esc_html__('Right', 'kickoff'), 
												'center'=>esc_html__('Center', 'kickoff'), 
											)
										),										
										'element-style'=> array(
											'title'=> esc_html__('Heading Style' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'style-1'=>esc_html__('Style 1', 'kickoff'), 
												'style-2'=>esc_html__('Style 2', 'kickoff'), 
												'style-3'=>esc_html__('Style 3', 'kickoff'), 
												'style-4'=>esc_html__('Style 4', 'kickoff'), 
											)
										),	
										'title'=> array(
											'title'=> esc_html__('Title' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '',
											'description'=> esc_html__('Add heading title here.', 'kickoff')
										),	
										'title-color' => array(
											'title' => esc_html__('Title Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',											
										),	
										'caption'=> array(
											'title'=> esc_html__('Caption' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '',
										),
										'caption-color' => array(
											'title' => esc_html__('Caption Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',											
										),	
										'description'=> array(
											'title'=> esc_html__('Description' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '',
										),
										'description-color' => array(
											'title' => esc_html__('Description Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',											
										),	
										'line-color' => array(
											'title' => esc_html__('Line Color', 'kickoff'),
											'type' => 'colorpicker',
											'default'=> '#ffffff',											
										),										
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item', 'kickoff')
										),										
									)
								),
								'accordion' => array(
									'title'=> esc_html__('Accordion', 'kickoff'), 
									'icon'=>'fa-server',
									'type'=>'item',
									'options'=> array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'accordion'=> array(
											'type'=> 'tab',
											'default-title'=> esc_html__('Accordion' ,'kickoff')											
										),
										'initial-state'=> array(
											'title'=> esc_html__('On Load Open', 'kickoff'),
											'type'=> 'text',
											'default'=> 1,
											'description'=> esc_html__('0 will close all tab as an initial state, 1 will open the first tab and so on.', 'kickoff')						
										),												
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),
									)
								),								
								
								'sidebar' => array(
									'title'=> esc_html__('Sidebar', 'kickoff'), 
									'icon'=>'fa-th',
									'type'=>'item',
									'options'=> 
									array(
										'widget'=> array(
											'title'=> esc_html__('Select Widget Area' ,'kickoff'),
											'type'=> 'combobox_sidebar',
											'options'=> $kode_theme_option['sidebar-element'],
											'description'=> esc_html__('You can select Widget Area of your choice.', 'kickoff')
										),	
									)
								),
								'header-element' => array(
									'title'=> esc_html__('Header', 'kickoff'), 
									'icon'=>'fa-header',
									'type'=>'item',
									'options'=> 
									array(
										'kode-header-style' => array(
											'title' => esc_html__('Header Style', 'kickoff'),
											'type' => 'combobox',	
											'options' => array(
												// 'header-style-1' => esc_html__('Header Style 1', 'kickoff'),
												// 'header-style-2' => esc_html__('Header Style 2', 'kickoff'),
												// 'header-style-3' => esc_html__('Header Style 3', 'kickoff'),
												// 'header-style-4' => esc_html__('Header Style 4', 'kickoff'),
												// 'header-style-5' => esc_html__('Header Style 5', 'kickoff'),
												// 'header-style-6' => esc_html__('Header Style 6', 'kickoff'),
												'header-style-7' => esc_html__('Header Style 1', 'kickoff'),
											)
										),	
									)
								),
								'blog' => array(
									'title'=> esc_html__('Blog', 'kickoff'), 
									'icon'=>'fa-cube',
									'type'=>'item',
									'options'=>  array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),									
										'category'=> array(
											'title'=> esc_html__('Category' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('category'),
											'description'=> esc_html__('Select categories to fetch its posts.', 'kickoff')
										),	
										'tag'=> array(
											'title'=> esc_html__('Tag' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('post_tag'),
											'description'=> esc_html__('Select tags to fetch its posts.', 'kickoff')
										),	
										'blog-style'=> array(
											'title'=> esc_html__('Blog Style' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												// 'blog-simple' => esc_html__('Blog Simple', 'kickoff'),
												'blog-modern' => esc_html__('Blog Grid Modern', 'kickoff'),
												'blog-grid' => esc_html__('Blog Grid', 'kickoff'),
												'blog-cricket' => esc_html__('Blog Cricket', 'kickoff'),
												'blog-full' => esc_html__('Blog Full', 'kickoff'),
											),
											'default'=>'blog-full'
										),	
										'blog-size'=> array(
											'title'=> esc_html__('Blog Size' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'2' => esc_html__('2 Column', 'kickoff'),
												'3' => esc_html__('3 Column', 'kickoff'),
												'4' => esc_html__('4 Column', 'kickoff'),
											),
											'wrapper-class' => 'blog-grid-wrapper blog-small-wrapper blog-style-wrapper',
											'default'=>'blog-full'
										),
										'kode-thumbnail-size'=> array(
											'title'=> esc_html__('Thumbnail Size' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> kode_get_thumbnail_list()
										),
										'title-num-fetch'=> array(
											'title'=> esc_html__('Num Title (Character)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post title.', 'kickoff')
										),	
										'num-excerpt'=> array(
											'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post description.', 'kickoff')
										),	
										'num-fetch'=> array(
											'title'=> esc_html__('Num Fetch' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '8',
											'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
										),										
										'orderby'=> array(
											'title'=> esc_html__('Order By' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'date' => esc_html__('Publish Date', 'kickoff'), 
												'title' => esc_html__('Title', 'kickoff'), 
												'rand' => esc_html__('Random', 'kickoff'), 
											)
										),
										'order'=> array(
											'title'=> esc_html__('Order' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'desc'=>esc_html__('Descending Order', 'kickoff'), 
												'asc'=> esc_html__('Ascending Order', 'kickoff'), 
											)
										),	
										'pagination'=> array(
											'title'=> esc_html__('Enable Pagination' ,'kickoff'),
											'type'=> 'checkbox'
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),										
									)
								),
								'blog-list' => array(
									'title'=> esc_html__('Blog List', 'kickoff'), 
									'icon'=>'fa-cube',
									'type'=>'item',
									'options'=>  array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),									
										'category'=> array(
											'title'=> esc_html__('Category' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('category'),
											'description'=> esc_html__('Select categories to fetch its posts.', 'kickoff')
										),	
										'tag'=> array(
											'title'=> esc_html__('Tag' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('post_tag'),
											'description'=> esc_html__('Select tags to fetch its posts.', 'kickoff')
										),	
										
										'title-num-fetch'=> array(
											'title'=> esc_html__('Num Title (Character)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post title.', 'kickoff')
										),	
										'num-excerpt'=> array(
											'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post description.', 'kickoff')
										),	
										'num-fetch'=> array(
											'title'=> esc_html__('Num Fetch' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '8',
											'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
										),										
										'orderby'=> array(
											'title'=> esc_html__('Order By' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'date' => esc_html__('Publish Date', 'kickoff'), 
												'title' => esc_html__('Title', 'kickoff'), 
												'rand' => esc_html__('Random', 'kickoff'), 
											)
										),
										'order'=> array(
											'title'=> esc_html__('Order' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'desc'=>esc_html__('Descending Order', 'kickoff'), 
												'asc'=> esc_html__('Ascending Order', 'kickoff'), 
											)
										),	
										'pagination'=> array(
											'title'=> esc_html__('Enable Pagination' ,'kickoff'),
											'type'=> 'checkbox'
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),										
									)
								),
								'blog-post-slider' => array(
									'title'=> esc_html__('Blog Post Slider', 'kickoff'), 
									'icon'=>'fa-cube',
									'type'=>'item',
									'options'=>  array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),
										'post-style'=> array(
											'title'=> esc_html__('Order By' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'slider' => esc_html__('Slider (Multiple Posts)', 'kickoff'), 
												'simple-post' => esc_html__('Single Post with Feature Img', 'kickoff'), 
											)
										),										
										'category'=> array(
											'title'=> esc_html__('Category' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('category'),
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Select categories to fetch its posts.', 'kickoff')
										),	
										'tag'=> array(
											'title'=> esc_html__('Tag' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('post_tag'),
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Select tags to fetch its posts.', 'kickoff')
										),	
										'select_post'=> array(
											'title'=> esc_html__('Select Post' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> kode_get_post_list_id('post'),
											'wrapper-class'=> 'simple-post-wrapper post-style-wrapper',
											'description'=> esc_html__('Select post from the list.', 'kickoff')
										),
										'title-num-fetch'=> array(
											'title'=> esc_html__('Num Title (Character)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post title.', 'kickoff')
										),	
										'num-excerpt'=> array(
											'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post description.', 'kickoff')
										),	
										'num-fetch'=> array(
											'title'=> esc_html__('Num Fetch' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '8',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
										),										
										'orderby'=> array(
											'title'=> esc_html__('Order By' ,'kickoff'),
											'type'=> 'combobox',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'options'=> array(
												'date' => esc_html__('Publish Date', 'kickoff'), 
												'title' => esc_html__('Title', 'kickoff'), 
												'rand' => esc_html__('Random', 'kickoff'), 
											)
										),
										'order'=> array(
											'title'=> esc_html__('Order' ,'kickoff'),
											'type'=> 'combobox',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'options'=> array(
												'desc'=>esc_html__('Descending Order', 'kickoff'), 
												'asc'=> esc_html__('Ascending Order', 'kickoff'), 
											)
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),										
									)
								),
								
								'player-state' => array(
									'title'=> esc_html__('Player State', 'kickoff'), 
									'icon'=>'fa-cube',
									'type'=>'item',
									'options'=>  array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),
										'category'=> array(
											'title'=> esc_html__('Category' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('category'),
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Select categories to fetch its posts.', 'kickoff')
										),	
										'tag'=> array(
											'title'=> esc_html__('Tag' ,'kickoff'),
											'type'=> 'multi-combobox',
											'options'=> kode_get_term_list('post_tag'),
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Select tags to fetch its posts.', 'kickoff')
										),	
										'title-num-fetch'=> array(
											'title'=> esc_html__('Num Title (Character)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post title.', 'kickoff')
										),	
										'num-excerpt'=> array(
											'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '25',
											'description'=> esc_html__('This is a number of characters that you want to show on the post description.', 'kickoff')
										),	
										'num-fetch'=> array(
											'title'=> esc_html__('Num Fetch' ,'kickoff'),
											'type'=> 'text',	
											'default'=> '8',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
										),										
										'orderby'=> array(
											'title'=> esc_html__('Order By' ,'kickoff'),
											'type'=> 'combobox',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'options'=> array(
												'date' => esc_html__('Publish Date', 'kickoff'), 
												'title' => esc_html__('Title', 'kickoff'), 
												'rand' => esc_html__('Random', 'kickoff'), 
											)
										),
										'order'=> array(
											'title'=> esc_html__('Order' ,'kickoff'),
											'type'=> 'combobox',
											'wrapper-class'=> 'slider-wrapper post-style-wrapper',
											'options'=> array(
												'desc'=>esc_html__('Descending Order', 'kickoff'), 
												'asc'=> esc_html__('Ascending Order', 'kickoff'), 
											)
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),										
									)
								),
								// 'donate-service' => array(
									// 'title'=> esc_html__('Donate Services', 'kickoff'), 
									// 'icon'=>'fa-file-o',
									// 'type'=>'item',
									// 'options'=>array(
										// 'element-item-id' => array(
											// 'title' => esc_html__('Page Item ID', 'kickoff'),
											// 'type' => 'text',
											// 'default' => '',
											// 'description' => esc_html__('please add the page item id.', 'kickoff')
										// ),
										// 'element-item-class' => array(
											// 'title' => esc_html__('Page Item Class', 'kickoff'),
											// 'type' => 'text',
											// 'default' => '',
											// 'description' => esc_html__('please add the page item class.', 'kickoff')
										// ),	
										// 'title-donate'=> array(
											// 'title'=> esc_html__('Donate Title' ,'kickoff'),
											// 'type'=> 'text',						
										// ),		
										// 'desc-donate'=> array(
											// 'title'=> esc_html__('Donate Description' ,'kickoff'),
											// 'type'=> 'textarea',						
										// ),		
										// 'donate-image' => array(
											// 'title' => esc_html__('Donate Image' , 'kickoff'),
											// 'button' => esc_html__('Upload', 'kickoff'),
											// 'type' => 'upload',											
										// ),
										// 'sub-donate'=> array(
											// 'title'=> esc_html__('Sub Donate' ,'kickoff'),
											// 'type'=> 'text',						
										// ),											
										// 'link' => array(
											// 'title' => esc_html__('Link', 'kickoff'),
											// 'type' => 'text',
											// 'description' => esc_html__('Please add link here for services.', 'kickoff')
										// ),	
										// 'link-text' => array(
											// 'title' => esc_html__('Text Link', 'kickoff'),
											// 'type' => 'text',
											// 'description' => esc_html__('Please add text here for services link.', 'kickoff')
										// ),	
										// 'margin-bottom' => array(
											// 'title' => esc_html__('Margin Bottom', 'kickoff'),
											// 'type' => 'text',
											// 'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										// ),	 
									// )
								// ),
								'column-service' => array(
									'title'=> esc_html__('Service', 'kickoff'), 
									'icon'=>'fa-file-o',
									'type'=>'item',
									'options'=>array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'icon_type'=> array(
											'title'=> esc_html__('Icon Class' ,'kickoff'),
											'type'=> 'text',						
										),		
										'title'=> array(
											'title'=> esc_html__('Title' ,'kickoff'),
											'type'=> 'text',						
										),	
										'style'=> array(
											'title'=> esc_html__('Item Style' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'type-1'=> esc_html__('Style 1' ,'kickoff'),	
												'type-2'=> esc_html__('Style 2' ,'kickoff'),
												'type-3'=> esc_html__('Style 3' ,'kickoff'),												
												'type-4'=> esc_html__('Style 4' ,'kickoff'),
												'type-5'=> esc_html__('Cricket Style' ,'kickoff')
											)
										),										
										'content'=> array(
											'title'=> esc_html__('Content Text' ,'kickoff'),
											'type'=> 'tinymce',						
										),
										'link' => array(
											'title' => esc_html__('Link', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Please add link here for services.', 'kickoff')
										),	
										'link-text' => array(
											'title' => esc_html__('Text Link', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Please add text here for services link.', 'kickoff')
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),	 
									)
								),
								'simple-column' => array(
									'title'=> esc_html__('Simple Column', 'kickoff'), 
									'icon'=>'fa-sticky-note-o',
									'type'=>'item',
									'options'=>array(	
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),										
										'content'=> array(
											'title'=> esc_html__('Content Text' ,'kickoff'),
											'type'=> 'textarea',						
										),
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),	 
									)
								),			
								'content' => array(
									'title'=> esc_html__('Content', 'kickoff'), 
									'icon'=>'fa-contao',
									'type'=>'item',
									'options'=> array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'show-title' => array(
											'title' => esc_html__('Show Title' , 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
										),						
										'page-caption' => array(
											'title' => esc_html__('Page Caption' , 'kickoff'),
											'type' => 'textarea'
										),		
										'show-content' => array(
											'title' => esc_html__('Show Content (From Default Editor)' , 'kickoff'),
											'type' => 'checkbox',
											'default' => 'enable',
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),														
									)
								), 	

								'divider' => array(
									'title'=> esc_html__('Divider', 'kickoff'), 
									'icon'=>'fa-minus',
									'type'=>'item',
									'options'=>array(									
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),										
									)
								),
								
								// 'portfolio' => array(),
								
								'gallery' => array(
									'title'=> esc_html__('Gallery', 'kickoff'), 
									'icon'=>'fa-houzz',
									'type'=>'item',
									'options'=> array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'slider'=> array(	
											'overlay'=> 'false',
											'caption'=> 'false',
											'type'=> 'gallery',
										),				
										'thumbnail-size'=> array(
											'title'=> esc_html__('Thumbnail Size' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> kode_get_thumbnail_list()
										),
										'gallery-columns'=> array(
											'title'=> esc_html__('Gallery Image Columns' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array('2'=>'2', '3'=>'3', '4'=>'4'),
											'default'=> '4'
										),	
										'num-fetch'=> array(
											'title'=> esc_html__('Num Fetch (Per Page)' ,'kickoff'),
											'type'=> 'text',
											'description'=> esc_html__('Leave this field blank to fetch all image without pagination.', 'kickoff'),
											'wrapper-class'=>'gallery-style-wrapper grid-wrapper'
										),
										'show-caption'=> array(
											'title'=> esc_html__('Show Caption' ,'kickoff'),
											'type'=> 'combobox',
											'options'=> array('yes'=>'Yes', 'no'=>'No')
										),			
										'pagination'=> array(
											'title'=> esc_html__('Enable Pagination' ,'kickoff'),
											'type'=> 'checkbox'
										),	
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),	
									)	
								),		
								// 'post-slider' => array(
									// 'title'=> esc_html__('Post Slider', 'kickoff'), 
									// 'icon'=>'fa-file-o',
									// 'type'=>'item',
									// 'options'=>array(
										// 'element-item-id' => array(
											// 'title' => esc_html__('Page Item ID', 'kickoff'),
											// 'type' => 'text',
											// 'default' => '',
											// 'description' => esc_html__('please add the page item id.', 'kickoff')
										// ),
										// 'element-item-class' => array(
											// 'title' => esc_html__('Page Item Class', 'kickoff'),
											// 'type' => 'text',
											// 'default' => '',
											// 'description' => esc_html__('please add the page item class.', 'kickoff')
										// ),	
										// 'category'=> array(
											// 'title'=> esc_html__('Category' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> kode_get_term_list('category'),
											// 'description'=> esc_html__('Select categories to fetch its posts.', 'kickoff')
										// ),	
										// 'num-excerpt'=> array(
											// 'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
											// 'type'=> 'text',	
											// 'default'=> '25',
											// 'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the post excerpt. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
										// ),	
										// 'num-fetch'=> array(
											// 'title'=> esc_html__('Num Fetch' ,'kickoff'),
											// 'type'=> 'text',	
											// 'default'=> '8',
											// 'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
										// ),										
										// 'thumbnail-size'=> array(
											// 'title'=> esc_html__('Thumbnail Size' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> kode_get_thumbnail_list()
										// ),	
										// 'style'=> array(
											// 'title'=> esc_html__('Style' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> array(
												// 'no-excerpt'=>esc_html__('No Excerpt', 'kickoff'),
												// 'with-excerpt'=>esc_html__('With Excerpt', 'kickoff'),
											// )
										// ),
										// 'caption-style'=> array(
											// 'title'=> esc_html__('Caption Style' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> array(
												// 'post-bottom post-slider'=>esc_html__('Bottom Caption', 'kickoff'),
												// 'post-right post-slider'=>esc_html__('Right Caption', 'kickoff'),
												// 'post-left post-slider'=>esc_html__('Left Caption', 'kickoff')
											// ),
											// 'wrapper-class' => 'style-wrapper with-excerpt-wrapper'
										// ),											
										// 'orderby'=> array(
											// 'title'=> esc_html__('Order By' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> array(
												// 'date' => esc_html__('Publish Date', 'kickoff'), 
												// 'title' => esc_html__('Title', 'kickoff'), 
												// 'rand' => esc_html__('Random', 'kickoff'), 
											// )
										// ),
										// 'order'=> array(
											// 'title'=> esc_html__('Order' ,'kickoff'),
											// 'type'=> 'combobox',
											// 'options'=> array(
												// 'desc'=>esc_html__('Descending Order', 'kickoff'), 
												// 'asc'=> esc_html__('Ascending Order', 'kickoff'), 
											// )
										// ),			
										// 'margin-bottom' => array(
											// 'title' => esc_html__('Margin Bottom', 'kickoff'),
											// 'type' => 'text',
											// 'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										// ),											
									// )
								// ),
								
								'slider' => array(
									'title'=> esc_html__('Slider', 'kickoff'), 
									'icon'=>'fa-sliders',
									'type'=>'item',
									'options'=>array(
										'element-item-id' => array(
											'title' => esc_html__('Page Item ID', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item id.', 'kickoff')
										),
										'element-item-class' => array(
											'title' => esc_html__('Page Item Class', 'kickoff'),
											'type' => 'text',
											'default' => '',
											'description' => esc_html__('please add the page item class.', 'kickoff')
										),	
										'slider'=> array(	
											'overlay'=> 'false',
											'caption'=> 'true',
											'type'=> 'slider'						
										),	
										'slider-type'=> array(
											'title'=> esc_html__('Slider Type', 'kickoff'),
											'type'=> 'combobox',
											'options'=> array(
												'flexslider' => esc_html__('Flex slider', 'kickoff'),
												'bxslider' => esc_html__('BX Slider', 'kickoff'),
												'nivoslider' => esc_html__('Nivo Slider', 'kickoff')
											)
										),		
										'margin-bottom' => array(
											'title' => esc_html__('Margin Bottom', 'kickoff'),
											'type' => 'text',											
											'description' => esc_html__('Spaces after ending of this item Note: Donot write px with it.', 'kickoff')
										),											
									)
								),	
								 					
							)
						),
					)
				),
				// page builder option attribute
				array(
					'post_type' => array('page'),
					'title' => 'Page Options',
					'meta_title' => esc_html__('Page Builder Options', 'kickoff'),
				)
			);
			
		}
		
	}
	
	
	// show the pagebuilder item
	if( !function_exists('kode_show_page_builder') ){
		function kode_show_page_builder($content, $full_width = true){
		
			$section = array(0, false); // (size, independent)
			foreach( $content as $item ){			
				// determine the current item size
				$current_size = 1;
				if( !empty($item['size']) ){
					$current_size = kode_item_size_to_num($item['size']);
				}
				
				// print each section
				if( $item['type'] == 'color-wrapper' || $item['type'] == 'parallax-bg-wrapper' ||
					$item['type'] == 'full-size-wrapper' ){
					$section = kode_show_section($section, $current_size, true);	
				}else{
					$section = kode_show_section($section, $current_size, false);	
				}
				
				// start printing item
				if( $item['item-type'] == 'wrapper' ){
					if( $item['type'] == 'color-wrapper' ){
						kode_show_color_wrapper( $item );
					}else if(  $item['type'] == 'parallax-bg-wrapper'){
						kode_show_parallax_wrapper( $item );
					}else if(  $item['type'] == 'full-size-wrapper'){
						kode_show_full_size_wrapper( $item );
					}else{
						kode_show_column_wrapper( $item );
					}
				}else{
					kode_show_element( $item );
				}
			}
			
			echo '<div class="clear"></div>';
			
			if( !$section[1] ){
				echo '</div>';
				echo '</div>'; 
			} // close container of dependent section
			echo '</div>'; // close the last opened section
			
		}
	}
	
	// print each section
	if( !function_exists('kode_show_section') ){
		function kode_show_section( $section, $size, $independent = false ){
			global $kode_section_id;
			if( empty($kode_section_id) ){ $kode_section_id = 1; }

			if( $section[0] == 0 ){ // starting section
				echo '<div id="content-section-' . $kode_section_id . '" >';
				if( !$independent ){ echo '<div class="section-container container"><div class="row">'; } // open container
				
				$section = array($size, $independent);
				$kode_section_id ++;
			}else{

				if( $independent || $section[1] ){ // current or previous section is independent
				
					echo '<div class="clear"></div>';
					if( !$section[1] ){ echo '</div></div>'; } // close container of dependent section
					echo '</div>';
					
					echo '<div id="content-section-' . $kode_section_id . '" >';		
					if( !$independent ){ echo '<div class="section-container container"><div class="row">'; } // open container
					
					$section[0] = ceil($section[0]) + $size; $section[1] = $independent;
					$kode_section_id ++;
				}else{

					if( abs((float)$section[0] - floor($section[0])) < 0.01 || 	// is integer or
						(floor($section[0]) < floor($section[0] + $size - 0.01)) ){ 	// exceeding current line
						echo '<div class="clear"></div>';
					}
					if( $size == 1 ){
						echo '<div class="clear"></div>';
						$section[0] = ceil($section[0]) + $size; $section[1] = $independent;
					}else{
						$section[0] += $size; $section[1] = $independent;
					}
				}
			}
			
			return $section;
		}
	}	

	
	// print color wrapper
	if( !function_exists('kode_show_color_wrapper') ){
		function kode_show_color_wrapper( $content ){
			$item_id = empty($content['option']['element-item-id'])? '': ' id="' . esc_attr($content['option']['element-item-id']) . '" ';
			
			global $kode_spaces;
			$padding  = (!empty($content['option']['padding-top']) && 
				($kode_spaces['top-wrapper'] != $content['option']['padding-top']))? 
				'padding-top: ' . esc_attr($content['option']['padding-top']) . '; ': '';
			$padding .= (!empty($content['option']['padding-bottom']) && 
				($kode_spaces['bottom-wrapper'] != $content['option']['padding-bottom']))? 
				'padding-bottom: ' . esc_attr($content['option']['padding-bottom']) . '; ': '';
				
			$border = '';
			if( !empty($content['option']['border']) && $content['option']['border'] != 'none' ){
				if($content['option']['border'] == 'top' || $content['option']['border'] == 'both'){
					$border .= ' border-top: 4px solid '. esc_attr($content['option']['border-top-color']) . '; ';
				}
				if($content['option']['border'] == 'bottom' || $content['option']['border'] == 'both'){
					$border .= ' border-bottom: 4px solid '. esc_attr($content['option']['border-bottom-color']) . '; ';
				}
			}

			$content['option']['show-section'] = !empty($content['option']['show-section'])? $content['option']['show-section']: '';
			echo '<div class="kode-color-wrapper ' . ' ' . esc_attr($content['option']['show-section']) . '" ' . $item_id;
			if( !empty($content['option']['background']) || !empty($padding) ){
				echo 'style="';
				if( empty($content['option']['background-type']) || $content['option']['background-type'] == 'color' ){
					echo !empty($content['option']['background'])? 'background-color: ' . esc_attr($content['option']['background']) . '; ': '';
				}
				echo esc_attr($border);
				echo esc_attr($padding);
				echo '" ';
			}
			echo '>';
			echo '<div class="container"><div class="row">';
		
			foreach( $content['items'] as $item ){	
				if( $item['item-type'] == 'wrapper' ){
					kode_show_column_wrapper( $item );
				}else{
					kode_show_element( $item );
				}
			}	
			
			echo '<div class="clear"></div>';
			echo '</div></div>'; // close container
			echo '</div>'; // close wrapper
		}
	}	
	
	// show parallax wrapper
	if( !function_exists('kode_show_parallax_wrapper') ){
		function kode_show_parallax_wrapper( $content ){
			global $parallax_wrapper_id;
			$parallax_wrapper_id = empty($parallax_wrapper_id)? 1: $parallax_wrapper_id;
			if( empty($content['option']['element-item-id']) ){
				$content['option']['element-item-id'] = 'kode-parallax-wrapper-' . $parallax_wrapper_id;
				$parallax_wrapper_id++;
			}
			$item_id = ' id="' . esc_attr($content['option']['element-item-id']) . '" ';

			global $kode_spaces;
			$padding  = (!empty($content['option']['padding-top']) && 
				($kode_spaces['top-wrapper'] != $content['option']['padding-top']))? 
				'padding-top: ' . esc_attr($content['option']['padding-top']) . '; ': '';
			$padding .= (!empty($content['option']['padding-bottom']) && 
				($kode_spaces['bottom-wrapper'] != $content['option']['padding-bottom']))? 
				'padding-bottom: ' . esc_attr($content['option']['padding-bottom']) . '; ': '';

			$border = '';

			echo '<div class="kode-parallax-wrapper kode-background-' . esc_attr($content['option']['type']) . '" ' . $item_id;
			
			// background parallax
			if( !empty($content['option']['background']) && $content['option']['type'] == 'image' ){
				if( !empty($content['option']['background-speed']) ){
					echo 'data-bgspeed="' . esc_attr($content['option']['background-speed']) . '" ';
				}else{
					echo 'data-bgspeed="0" ';
				}				
			
				if( is_numeric($content['option']['background']) ){
					$background = wp_get_attachment_image_src($content['option']['background'], 'full');
					$background = esc_url($background[0]);
				}else{
					$background = esc_url($content['option']['background']);
				}
				if(empty($content['option']['opacity']) || $content['option']['opacity'] == ''){ $content['option']['opacity'] = '0.03';}
				if(empty($content['option']['background-color']) || $content['option']['background-color'] == ''){ $content['option']['background-color'] = '#000';}
				echo 'style="background-color:'.esc_attr($content['option']['background-color']).';background-image: url(\'' . esc_url($background) . '\'); ' . $padding . $border . '" >';			
				echo '<style scoped type="text/css">';
				echo '#' . esc_attr($content['option']['element-item-id']) . '{';
				echo ' position:relative;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ' .container{';
				echo ' position:relative;z-index:99999;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ':before{';
				echo 'opacity:'.esc_attr($content['option']['opacity']).';content:"";position:absolute;left:0px;top:0px;height:100%;width:100%;';
				echo '}';
				echo '</style>';
				if( !empty($content['option']['background-mobile']) ){
					if( is_numeric($content['option']['background-mobile']) ){
						$background = wp_get_attachment_image_src($content['option']['background-mobile'], 'full');
						$background = esc_url($background[0]);
					}else{
						$background = esc_url($content['option']['background-mobile']);
					}				
				
					echo '<style type="text/css">@media only screen and (max-width: 767px){ ';
					echo '#' . esc_attr($content['option']['element-item-id']) . '{';
					echo ' background-image: url(\'' . esc_url($background) . '\') !important;';
					echo '}';
					echo '}</style>';
				}
				
			// background pattern 
			}else if($content['option']['type'] == 'pattern'){
				$background = KODE_PATH . '/images/pattern/pattern-' . esc_attr($content['option']['pattern']) . '.png';
				echo 'style="background-image: url(\'' . esc_url($background) . '\'); ' . $padding . $border . '" >';
			
			// background video
			}else if( $content['option']['type'] == 'video' ){
				echo 'style="' . $padding . $border . '" >';
				
				global $kode_gallery_id; $kode_gallery_id++;
				$overlay_opacity = (empty($content['option']['video-overlay']))? 0: floatval($content['option']['video-overlay']);
				
				echo '<div id="kode-player-' . esc_attr($kode_gallery_id) . '" class="kode-bg-player" data-property="';
				echo '{videoURL:\'' . esc_attr($content['option']['video']) . '\',containment:\'#kode-player-' . esc_attr($kode_gallery_id) . '\',';
				echo 'startAt:0,mute:true,autoPlay:true,loop:true,printUrl:false,realfullscreen:false,quality:\'hd720\'';
				echo (!empty($content['option']['video-player']) && $content['option']['video-player'] == 'disable')? ',showControls:false':'';
				echo '}"><div class="kode-player-overlay" ';
				echo 'style="opacity: ' . esc_attr($overlay_opacity) . '; filter: alpha(opacity=' . esc_attr($overlay_opacity) * 100 . ');" ';
				echo '></div></div>';

			// background video / none
			}else if($content['option']['type'] == 'map'){
				echo '><span class="footertransparent-bg"></span>';
				echo do_shortcode($content['option']['map_shortcode']);
				echo '';
			}else if(!empty($padding) || !empty($border) ){
				echo 'style="' . $padding . $border . '" >';
			}

			echo '<div class="container">';
		
			foreach( $content['items'] as $item ){
				if( $item['item-type'] == 'wrapper' ){
					kode_show_column_wrapper( $item );
				}else{
					kode_show_element( $item );
				}
			}	
			
			echo '<div class="clear"></div>';
			echo '</div>'; // close container
			echo '</div>'; // close wrapper
		}
	}
	
	// print full size wrapper
	if( !function_exists('kode_show_full_size_wrapper') ){
		function kode_show_full_size_wrapper( $content ){
			global $kode_wrapper_id;
			$kode_wrapper_id = empty($kode_wrapper_id)? 1: $kode_wrapper_id;
			if( empty($content['option']['element-item-id']) ){
				$content['option']['element-item-id'] = 'kode-parallax-wrapper-' . $kode_wrapper_id;
				$kode_wrapper_id++;
			}
			
			$kode_trans_class = '';
			if( !empty($content['option']['trans-background']) ){
				$kode_trans_class = $content['option']['trans-background'];
			}
			$kode_wrapper_class = '';
			if( !empty($content['option']['element-item-class']) ){
				$kode_wrapper_class = $content['option']['element-item-class'];
			}
			$item_id = ' id="' . esc_attr($content['option']['element-item-id']) . '" ';

			global $kode_spaces;
			$padding  = (!empty($content['option']['padding-top']) && 
				($kode_spaces['top-wrapper'] != $content['option']['padding-top']))? 
				'padding-top: ' . esc_attr($content['option']['padding-top']) . '; ': '';
			$padding .= (!empty($content['option']['padding-bottom']) && 
				($kode_spaces['bottom-wrapper'] != $content['option']['padding-bottom']))? 
				'padding-bottom: ' . esc_attr($content['option']['padding-bottom']) . '; ': '';

			$border = '';
			$content['option']['type'] = (empty($content['option']['type']))? ' ': $content['option']['type'];
			$kode_trans_bg = '';
			$kode_solid_bg = '';
			if($kode_trans_class == 'enable'){
				$kode_trans_bg = "background-color:".esc_attr($content['option']['background-color'])."";
			}else{
				$kode_solid_bg = "background-color:".esc_attr($content['option']['background-color'])."";
			}
			if( !empty($content['option']['horizontal-background']) && $content['option']['horizontal-background'] == 'enable'){
				$kode_wrapper_class .= ' overlay movingbg';
			}
			echo '<div class="'.esc_attr($kode_wrapper_class).' kode-parallax-wrapper kode-background-' . esc_attr($content['option']['type']) . '" ' . $item_id;
			
			// background parallax
			if( !empty($content['option']['background']) && $content['option']['type'] == 'image' ){
				
				
				if( !empty($content['option']['horizontal-background']) && $content['option']['horizontal-background'] == 'enable'){
					echo 'data-id="customizer" data-title="Theme Customizer" data-direction="horizontal" ';
				}
				if( !empty($content['option']['background-speed']) ){
					echo 'data-bgspeed="' . esc_attr($content['option']['background-speed']) . '" ';
				}else{
					echo 'data-bgspeed="0" ';
				}				
			
				if( is_numeric($content['option']['background']) ){
					$background = wp_get_attachment_image_src($content['option']['background'], 'full');
					$background = esc_url($background[0]);
				}else{
					$background = esc_url($content['option']['background']);
				}
				if(empty($content['option']['opacity']) || $content['option']['opacity'] == ''){
					$content['option']['opacity'] = '0.03';
				}
				if(empty($content['option']['background-color']) || $content['option']['background-color'] == ''){
					$content['option']['background-color'] = '#000';
				}
				
				if($background <> ''){
					echo 'style="'.$kode_trans_bg.';background-image: url(\'' . esc_url($background) . '\'); ' . $padding . $border . '" >';			
				}else{
					echo 'style="'.$kode_trans_bg.';' . $padding . $border . '" >';			
				}
				echo '<style scoped>';
				echo '#' . esc_attr($content['option']['element-item-id']) . '{';
				echo ' position:relative;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ' .container{';
				echo ' position:relative;z-index:99999;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ':before{';
				echo ''.$kode_solid_bg.';opacity:'.esc_attr($content['option']['opacity']).';content:"";position:absolute;left:0px;top:0px;height:100%;width:100%;';
				echo '}';
				echo '</style>';
				
			// background pattern 
			}else if($content['option']['type'] == 'pattern'){
				$background = KODE_PATH . '/images/pattern/pattern-' . esc_attr($content['option']['pattern']) . '.png';
				echo 'style="background-image: url(\'' . esc_url($background) . '\'); ' . $padding . $border . '" >';
			
			// background MAP
			}else if($content['option']['type'] == 'map'){
				echo '><span class="footertransparent-bg"></span>';
				echo do_shortcode($content['option']['map_shortcode']);
				echo '';
			}else if($content['option']['type'] == 'color'){
				$content['option']['background-color'] = (empty($content['option']['background-color']))? ' ': $content['option']['background-color'];
				echo ' style="' . $padding . $border . ';background:'.esc_attr($content['option']['background-color']).'">';
				echo '';
			}else if($content['option']['type'] == 'video'){
				echo ' style="' . $padding . $border . ';">';
				echo '<style scoped>';
				echo '#' . esc_attr($content['option']['element-item-id']) . '{';
				echo ' position:relative;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ' .container{';
				echo ' position:relative;z-index:99999;';
				echo '}';
				echo '#' . esc_attr($content['option']['element-item-id']) . ':before{';
				echo ''.$kode_solid_bg.';opacity:'.esc_attr($content['option']['opacity']).';content:"";position:absolute;left:0px;top:0px;height:100%;width:100%;z-index:10;';
				echo '}';
				echo '</style>';
				
				$content['option']['video_url'] = (empty($content['option']['video_url']))? KODE_PATH.'/images/ocean.ogv': $content['option']['video_url'];
				$content['option']['video_type'] = (empty($content['option']['video_type']))? 'ogg': $content['option']['video_type'];
				echo '
				    <script>
						jQuery(document).ready(function($) {
							var BV = new $.BigVideo({
								useFlashForFirefox:false,
								container: $("#inner-' . esc_attr($content['option']['element-item-id']) . '"),
								forceAutoplay:true,
								controls:false,
								doLoop:false,			
								shrinkable:true
							});
							BV.init();
							BV.show([
								{ type: "video/'.$content['option']['video_type'].'",  src: "'.$content['option']['video_url'].'" },
								
							],{doLoop:true});
						});
					</script>
					<div class="kode-video-bg" id="inner-' . esc_attr($content['option']['element-item-id']) . '"></div>
				';
				
			}
			else if(!empty($padding) || !empty($border) ){
				echo 'style="' . $padding . $border . '" >';
			}
			$content['option']['container'] = (empty($content['option']['container']))? ' ': $content['option']['container'];
			if($content['option']['container'] == 'container-width'){
				echo '<div class="container">';
			}else{
				echo '<div class="container-fluid">';
				echo '<div class="row">';
			}
		
			foreach( $content['items'] as $item ){
				if( $item['item-type'] == 'wrapper' ){
					kode_show_column_wrapper( $item );
				}else{
					kode_show_element( $item );
				}
			}	
			
			echo '<div class="clear"></div>';
			if($content['option']['container'] == 'container-width'){
				echo '</div>'; // close container or Container
			}else{
				echo '</div>'; // close container or Row
				echo '</div>'; // close container or Container-fluid
			}			
			echo '</div>'; // close wrapper
		}
	}	
	
	// Column Sizes Bootstrap 3+
	if( !function_exists('kode_get_column_class') ){
		function kode_get_column_class( $size ){
			switch( $size ){
				case '1/6': return 'col-md-1 columns'; break;
				case '1/5': return 'col-md-2 column'; break;
				case '1/4': return 'col-md-3 columns'; break;
				case '2/5': return 'col-md-5 columns'; break;
				case '1/3': return 'col-md-4 columns'; break;
				case '1/2': return 'col-md-6 columns'; break;
				case '3/5': return 'col-md-7 columns'; break;
				case '2/3': return 'col-md-8 columns'; break;
				case '3/4': return 'col-md-9 columns'; break;
				case '4/5': return 'col-md-10 columns'; break;
				case '1/1': return 'col-md-12 columns'; break;
				default : return 'col-md-12 columns'; break;
			}
		}
	}
	
	// show column wrapper
	if( !function_exists('kode_show_column_wrapper') ){
		function kode_show_column_wrapper( $content ){
			
			echo '<div class="' . esc_attr(kode_get_column_class( $content['size'] )) . '" >';
			foreach( $content['items'] as $item ){
				kode_show_element( $item );
			}			
			echo '</div>'; // end of column section
		}
	}	
	
	
	// show the item
	if( !function_exists('kode_show_element') ){
		function kode_show_element( $content ){
			switch ($content['type']){
				case 'accordion': echo kode_get_accordion_item($content['option']); break;
				case 'blog': echo kode_get_blog_item($content['option']); break;
				case 'news': echo kode_get_news_item($content['option']); break;
				case 'headings': echo kode_get_headings_item($content['option']); break;
				case 'team-table': 
					if(function_exists('kode_get_team_points_table') ){
						echo kode_get_team_points_table($content['option']); 
					}
				break;
				case 'events': 
					if(class_exists('EM_Events')){
						echo kode_get_events_item($content['option']); 
					}
				break;
				case 'upcoming-event': 
					if(class_exists('EM_Events')){
						echo kode_get_upcoming_event_item($content['option']); 
					}
				break;
				case 'woo': 
					if(class_exists('WooCommerce')){
						echo kode_get_woo_item($content['option']); 
					}
				break;
				case 'team-slider': 
					if(function_exists('kode_get_team_item_slider') ){
						echo kode_get_team_item_slider($content['option']); 
					}
				break;
				case 'woo-slider': 
					if(function_exists('kode_get_woo_item_slider') ){
						echo kode_get_woo_item_slider($content['option']); 
					}
				break;
				case 'team': 
					if(function_exists('kode_get_team_item') ){
						echo kode_get_team_item($content['option']); 
					}
				break;
				case 'work': 
					if(function_exists('kode_get_work_item') ){
						echo kode_get_work_item($content['option']); 
					}
				break;
				case 'ignitiondeck': 
					if(class_exists('Deck')){
						echo kode_get_crowdfunding_item($content['option']);
					}
				break;				
				case 'header-element': 
					global $kode_theme_option;
					$kode_post_option = $content['option'];
					$kode_theme_option['enable-header-top'] = 'enable';
					echo '<div class="kode-header-pagebuilder">';
					kode_get_selected_header($kode_post_option,$kode_theme_option); 
					echo '</div>';
				break;				
				case 'player-slider': 
					if(function_exists('kode_get_player_item_slider') ){
						echo kode_get_player_item_slider($content['option']); 
					}
				break;
				case 'player': 
					if(function_exists('kode_get_player_item') ){
						echo kode_get_player_item($content['option']); 
					}
				break;
				case 'column-service': echo kode_get_column_service_item($content['option']); break;
				case 'donate-service': echo kode_get_column_donate_item($content['option']); break;
				case 'simple-column': echo kode_get_simple_column_item($content['option']); break;				
				case 'content': kode_get_default_content_item($content['option']); break;
				case 'divider': echo kode_get_divider_item($content['option']); break;
				case 'gallery': echo kode_get_gallery_item($content['option']); break;				
				case 'post-slider': echo kode_get_post_slider_item($content['option']); break;				
				case 'sidebar': echo '<div class="widget kode-widget kode-sidebar-element">';kode_get_sidebar_item($content['option']);echo '</div>'; break;
				case 'slider': echo kode_get_slider_item($content['option']); break;
				case 'leader-board': 
				if(function_exists('kode_get_leader_board_item') ){
					echo kode_get_leader_board_item($content['option']); 
				}
				break;
				case 'next-match': 
				if(function_exists('kode_get_next_match_item') ){
					echo kode_get_next_match_item($content['option']); 
				}
				break;					
				case 'testimonial': 
				if(function_exists('kode_get_testimonial_item') ){
					echo kode_get_testimonial_item($content['option']); 
				}
				break;				
				case 'next-fixtures': 
				if(function_exists('kode_get_upcomming_match_fixture_item') ){
					echo kode_get_upcomming_match_fixture_item($content['option']); 
				}
				break;				
				case 'live-result': 
				if(function_exists('kode_get_live_result_item') ){
					echo kode_get_live_result_item($content['option']); 
				}
				break;	
				case 'fixture': 
				if(function_exists('kode_get_fixture_item') ){
					echo kode_get_fixture_item($content['option']); 
				}
				break;	
				case 'cricket-points-table': 
				if(function_exists('kode_get_team_points_table_cric') ){
					echo kode_get_team_points_table_cric($content['option']); 
				}
				break;	
				case 'event-list': 
				if(function_exists('kode_get_normal_event_item') ){
					echo kode_get_normal_event_item($content['option']); 
				}
				break;	
				case 'blog-list': 
				if(function_exists('kode_get_blog_list_normal_item') ){
					echo kode_get_blog_list_normal_item($content['option']); 
				}
				break;	
				case 'blog-post-slider': 
				if(function_exists('kode_get_blog_simple_slider_item') ){
					echo kode_get_blog_simple_slider_item($content['option']); 
				}
				break;
				case 'player-state': 
				if(function_exists('kode_get_state_item') ){
					echo kode_get_state_item($content['option']); 
				}
				break;	
				default: $default['show-title'] = 'enable'; $default['show-content'] = 'enable'; echo kode_get_content_item($default); break;
			}
		}	
	}
	
?>