<?php
	/*	
	*	Kodeforest Post Option file
	*	---------------------------------------------------------------------
	*	This file creates all post options to the post page
	*	---------------------------------------------------------------------
	*/
	
	// Generate Options in theme Option Panel
	add_filter('kode_themeoption_panel', 'kode_register_post_themeoption');
	if( !function_exists('kode_register_post_themeoption') ){
		function kode_register_post_themeoption( $array ){		
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			//if empty
			if( empty($array['general']['options']) ){
				return $array;
			}
			//Blog options
			$post_themeoption = array(
				'title' => esc_html__('Blog General', 'kickoff'),
				'options' => array(
					'post-title' => array(
						'title' => 'Sub Header Post Title',
						'type' => 'text',	
						'description' => 'Sub Header Post Title'
					),
					'post-caption' => array(
						'title' => 'Sub Header Post Caption',
						'type' => 'textarea',
						'description' => 'Add Sub Header Post Caption'
					),
					'kode-post-thumbnail-size' => array(
						'title' => esc_html__('Single Post Thumbnail Size', 'kickoff'),
						'type'=> 'combobox',
						'options'=> kode_get_thumbnail_list(),
						'default'=> 'kode-post-thumbnail-size'
					),
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
					'single-post-author' => array(
						'title' => esc_html__('Single Post Author', 'kickoff'),
						'type' => 'checkbox',							
					),					
				)
			);
			
			
			$array['general']['options']['blog-style'] = $post_themeoption;
			return $array;
		}
	}		

	// add a post option to post page
	if( is_admin() ){
		add_action('init', 'kode_create_post_options');
	}
	if( !function_exists('kode_create_post_options') ){
	
		function kode_create_post_options(){
			global $kode_theme_option;
			if( !class_exists('kode_page_options') ) return;
			new kode_page_options( 
				
				// page option settings
				array(
					'page-layout' => array(
						'title' => esc_html__('Page Layout', 'kickoff'),
						'options' => array(
								'sidebar' => array(
									'title' => esc_html__('Sidebar Template' , 'kickoff'),
									'type' => 'radioimage',
									'options' => array(
										//'default-sidebar'=>KODE_PATH . '/framework/include/backend_assets/images/default-sidebar-2.png',
										'no-sidebar'=>KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
										'both-sidebar'=>KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
										'right-sidebar'=>KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
										'left-sidebar'=>KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
									),
									'default' => 'default-sidebar'
								),	
								'left-sidebar' => array(
									'title' => esc_html__('Left Sidebar' , 'kickoff'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								),
								'right-sidebar' => array(
									'title' => esc_html__('Right Sidebar' , 'kickoff'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								),						
						)
					),
					
					'page-option' => array(
						'title' => esc_html__('Page Option', 'kickoff'),
						'options' => array(
							'page-title' => array(
								'title' => esc_html__('Post Title' , 'kickoff'),
								'type' => 'text',
								'description' => esc_html__('Post title', 'kickoff')
							),
							'page-caption' => array(
								'title' => esc_html__('Post Caption' , 'kickoff'),
								'type' => 'textarea'
							),
							'post_media_type' => array(
								'title' => esc_html__('Select Post Media' , 'kickoff'),
								'type' => 'combobox',
								'options' => array(
									'audio'=>	esc_html__('Audio URL' , 'kickoff'),
									'video'=>	esc_html__('Video URL' , 'kickoff'),
									'featured_image'=>	esc_html__('Feature Image' , 'kickoff'),
									'slider'=>	esc_html__('Slider' , 'kickoff'),
								),
								'description'=> esc_html__('Select post media type.', 'kickoff')
							),	
							'kode_audio' => array(
								'title' => esc_html__('Audio URL' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'audio-wrapper post_media_type-wrapper',
								'description' => esc_html__('Add audio url, it could be uploaded mp3 , wav or add soundcloud track or profile url.', 'kickoff')
							),		
							'kode_video' => array(
								'title' => esc_html__('Video URL' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'video-wrapper post_media_type-wrapper',
								'description' => esc_html__('Add video url, it could be uploaded video track or youtube, vimeo.', 'kickoff')
							),	
							'slider'=> array(	
								'overlay'=> 'false',
								'caption'=> 'false',
								'type'=> 'slider',
								'wrapper-class' => 'slider-wrapper post_media_type-wrapper',
							)							
						)
					),

				),
				// page option attribute
				array(
					'post_type' => array('post'),
					'meta_title' => esc_html__('Kodeforest Post Option', 'kickoff'),
					'meta_slug' => 'kodeforest-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);	
		}
	}
	
	add_action('pre_post_update', 'kode_save_post_meta_option');
	if( !function_exists('kode_save_post_meta_option') ){
		function kode_save_post_meta_option( $post_id ){
			if( get_post_type() == 'post' && isset($_POST['post-option']) ){
				$post_option = kode_stopbackslashes(kode_stripslashes($_POST['post-option']));
				$post_option = json_decode(kode_decode_stopbackslashes($post_option), true);
				
				if(!empty($post_option['rating'])){
					update_post_meta($post_id, 'kode-post-rating', floatval($post_option['rating']) * 100);
				}else{
					delete_post_meta($post_id, 'kode-post-rating');
				}
			}
		}
	}
	
?>