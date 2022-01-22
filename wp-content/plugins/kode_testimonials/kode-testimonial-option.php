<?php
	/*	
	*	Testimonial Option file
	*	---------------------------------------------------------------------
	*	This file creates all testimonial options and attached to the theme
	*	---------------------------------------------------------------------
	*/
	
	// add a testimonial option to testimonial page
	if( is_admin() ){ add_action('after_setup_theme', 'kode_create_testimonial_options'); }
	if( !function_exists('kode_create_testimonial_options') ){
	
		function kode_create_testimonial_options(){
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			if( !class_exists('kode_page_options') ) return;
			new kode_page_options( 
				
				
					  
				// page option settings
				array(
					'page-layout' => array(
						'title' => __('Page Layout', 'kode_testimonial'),
						'options' => array(
								'sidebar' => array(
									'type' => 'radioimage',
									'options' => array(
										'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
										'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
										'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
										'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
									),
									'default' => 'no-sidebar'
								),	
								'left-sidebar' => array(
									'title' => __('Left Sidebar' , 'kode_testimonial'),
									'type' => 'combobox',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								),
								'right-sidebar' => array(
									'title' => __('Right Sidebar' , 'kode_testimonial'),
									'type' => 'combobox',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								),						
						)
					),
					
					'page-option' => array(
						'title' => __('Page Option', 'kode_testimonial'),
						'options' => array(
							'page-caption' => array(
								'title' => __('Page Caption' , 'kode_testimonial'),
								'type' => 'textarea'
							),							
							'header-background' => array(
								'title' => __('Header Background Image' , 'kode_testimonial'),
								'button' => __('Upload', 'kode_testimonial'),
								'type' => 'upload',
							),	
							'designation' => array(
								'title' => __('Designation' , 'kode_testimonial'),
								'type' => 'text',
							),						
						)
					),

				),
				
				// page option attribute
				array(
					'post_type' => array('testimonial'),
					'meta_title' => __('Testimonial Option', 'kode_testimonial'),
					'meta_slug' => 'testimonial-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}	
	
	// add testimonial in page builder area
	add_filter('kode_page_builder_option', 'kode_register_testimonial_item');
	if( !function_exists('kode_register_testimonial_item') ){
		function kode_register_testimonial_item( $page_builder = array() ){
			global $kode_spaces;
		
			$page_builder['content-item']['options']['testimonial'] = array(
				'title'=> __('Testimonial', 'kode_testimonial'), 
				'icon'=>'fa-quote-left',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> __('Category' ,'kode_testimonial'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('testimonial_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode_testimonial')
					),	
					// 'tag'=> array(
						// 'title'=> __('Tag' ,'kode_testimonial'),
						// 'type'=> 'multi-combobox',
						// 'options'=> kode_get_term_list('testimonial_tag'),
						// 'description'=> __('Will be ignored when the testimonial filter option is enabled.', 'kode_testimonial')
					// ),					
					'testimonial-style'=> array(
						'title'=> __('Testimonial Style' ,'kode_testimonial'),
						'type'=> 'combobox',
						'options'=> array(
							'simple-view' => __('Simple View', 'kode_testimonial'),
							'normal-view' => __('Normal View', 'kode_testimonial'),
							'modern-view' => __('Modern View', 'kode_testimonial')
						),
					),					
					'num-fetch'=> array(
						'title'=> __('Num Fetch' ,'kode_testimonial'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> __('Specify the number of testimonials you want to pull out.', 'kode_testimonial')
					),	
					'num-excerpt'=> array(
						'title'=> __('Num Excerpt' ,'kode_testimonial'),
						'type'=> 'text',	
						'default'=> '20'
					),
					'orderby'=> array(
						'title'=> __('Order By' ,'kode_testimonial'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode_testimonial'), 
							'title' => __('Title', 'kode_testimonial'), 
							'rand' => __('Random', 'kode_testimonial'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode_testimonial'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode_testimonial'), 
							'asc'=> __('Ascending Order', 'kode_testimonial'), 
						)
					),			
					// 'pagination'=> array(
						// 'title'=> __('Enable Pagination' ,'kode_testimonial'),
						// 'type'=> 'checkbox'
					// ),					
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode_testimonial'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode_testimonial')
					),				
				)
			);
			return $page_builder;
		}
	}
	
?>