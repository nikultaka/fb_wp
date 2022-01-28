<?php
	/*	
	*	Goodlayers Portfolio Option file
	*	---------------------------------------------------------------------
	*	This file creates all player options and attached to the theme
	*	---------------------------------------------------------------------
	*/
	
	// add a player option to player page
	if( is_admin() ){ add_action('after_setup_theme', 'kode_create_player_options'); }
	if( !function_exists('kode_create_player_options') ){
	
		function kode_create_player_options(){
			global $kode_theme_option,$kode_countries;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			if( !class_exists('kode_page_options') ) return;
			new kode_page_options( 
				
				// page option settings
				array(
					'page-layout' => array(
						'title' => __('Page Layout', 'kode-player'),
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
									'title' => __('Left Sidebar' , 'kode-player'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								),
								'right-sidebar' => array(
									'title' => __('Right Sidebar' , 'kode-player'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								),
						)
					),
					'page-option' => array(
						'title' => __('Page Option', 'kode-player'),
						'options' => array(
							'page-caption' => array(
								'title' => __('Page Caption' , 'kode-player'),
								'type' => 'textarea'
							),							
							'header-background' => array(
								'title' => __('Header Background Image' , 'kode-player'),
								'button' => __('Upload', 'kode-player'),
								'type' => 'upload',
							),	
							'player_info' => array(
								'title' => '',
								'header_title' => esc_attr__('Personal Information' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'date_of_birth' => array(
								'title' => __('Date of Birth' , 'kode-player'),
								'type' => 'date-picker',
								'wrapper-class' => 'four columns'
							),
							'place_of_birth' => array(
								'title' => __('Place Of Birth' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns'
							),
							'nationality' => array(
								'title' => __('Nationality' , 'kode-player'),								
								'type' => 'combobox',
								'wrapper-class' => 'four columns',
								'options' => $kode_countries
							),
							'height' => array(
								'title' => __('Height' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => 'Height will be in feet and will be converted into centimeter or meter as per themeoption panel',
							),
							'position' => array(
								'title' => __('Playing Position' , 'kode-player'),							
								'type' => 'combobox',
								'wrapper-class' => 'four columns',
								'options' => array(
									'GK'=>'Goalkeeper',
									'LB'=>'Left Back',
									'LWB'=>'Left Wing Back',
									'CB'=>'Centre Back',
									'RB'=>'Right Back',
									'RWB'=>'Right Wing Back',
									'LM'=>'Left Midfielder',
									'CM'=>'Centre Midfielder',
									'CDM'=>'Centre Defensive Midfielder',
									'CAM'=>'Centre Attacking Midfielder',
									'RM'=>'Right Midfielder',
									'LW'=>'Left Winger',
									'RW'=>'Right Winger',
									'LF'=>'Left Forward',
									'CF'=>'Centre Forward',
									'RF'=>'Right Forward',
									'ST'=>'Striker',
								),
							),
							'select_national' => array(
								'title' => esc_attr__('Select Team' , 'kode-player'),
								'type' => 'combobox',
								'options' => kode_get_post_list_id('team'),
								'wrapper-class' => 'four columns',
								'description'=> esc_attr__('Select team of the player.', 'kode-player')
							),	
							// 'club_info' => array(
								// 'title' => '',
								// 'header_title' => esc_attr__('Club Information' , 'kode-player'),
								// 'type' => 'header',
								// 'wrapper-class' => 'header-class'
							// ),	
							// 'select_club' => array(
								// 'title' => esc_attr__('Select Club' , 'kode-player'),
								// 'type' => 'multi-combobox',
								// 'options' => kode_get_post_list_id('team'),								
								// 'description'=> esc_attr__('Select club of the player.', 'kode-player')
							// ),
							// 'national_info' => array(
								// 'title' => '',
								// 'header_title' => esc_attr__('National Team' , 'kode-player'),
								// 'type' => 'header',
								// 'wrapper-class' => 'header-class'
							// ),	
							
							'player_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Tournament Stats' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'player-opponent'=> array(
								'title'=> __('Enable Opponent' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-goals'=> array(
								'title'=> __('Enable Goals' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-assist'=> array(
								'title'=> __('Enable Assist' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-own_goal'=> array(
								'title'=> __('Enable Own Goal' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-penalty'=> array(
								'title'=> __('Enable Penalty' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-position'=> array(
								'title'=> __('Enable Position' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-yellow-card'=> array(
								'title'=> __('Enable Yellow Card' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-red-card'=> array(
								'title'=> __('Enable Red Card' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'teams_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Team Tournament Stats' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'team-goals'=> array(
								'title'=> __('Enable Team Goals' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-sot'=> array(
								'title'=> __('Enable Team Short On Target' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-ck'=> array(
								'title'=> __('Enable Team Corner Kicks' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-yc'=> array(
								'title'=> __('Enable Team Yellow Cards' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-pa'=> array(
								'title'=> __('Enable Team Passing Accuracy' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),
							'designation' => array(
								'title' => __('Designation' , 'kode-player'),
								'type' => 'text',
								'description' => 'Please enter the Designation of the Team Member here.',
							),
							'facebook' => array(
								'title' => __('Facebook' , 'kode-player'),
								'type' => 'text',
								'description' => 'Please enter the Facebook social profile URL of the Team Member here.',
							),
							'twitter' => array(
								'title' => __('Twitter' , 'kode-player'),
								'type' => 'text',
								'description' => 'Please enter the Twitter social profile URL of the Team Member here.',
							),
							'youtube' => array(
								'title' => __('Youtube' , 'kode-player'),
								'type' => 'text',
								'description' => 'Please enter the Youtube social profile URL of the Team Member here.',
							),
							'pinterest' => array(
								'title' => __('Pinterest' , 'kode-player'),
								'type' => 'text',
								'description' => 'Please enter the Pinterest social profile URL of the Team Member here.',
							),	
						)
					),

				),
				// page option attribute
				array(
					'post_type' => array('player'),
					'meta_title' => __('Player Option', 'kode-player'),
					'meta_slug' => 'player-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}	
	
	
	if( is_admin() ){ add_action('after_setup_theme', 'kode_create_boxer_options'); }
	if( !function_exists('kode_create_boxer_options') ){
	
		function kode_create_boxer_options(){
			global $kode_theme_option,$kode_countries;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			if( !class_exists('kode_page_options') ) return;
			new kode_page_options( 
				
				// page option settings
				array(
					'page-layout' => array(
						'title' => __('Page Layout', 'kode-player'),
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
									'title' => __('Left Sidebar' , 'kode-player'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								),
								'right-sidebar' => array(
									'title' => __('Right Sidebar' , 'kode-player'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								),
						)
					),
					'page-option' => array(
						'title' => __('Page Option', 'kode-player'),
						'options' => array(
							'page-caption' => array(
								'title' => __('Page Caption' , 'kode-player'),
								'type' => 'textarea'
							),							
							'header-background' => array(
								'title' => __('Header Background Image' , 'kode-player'),
								'button' => __('Upload', 'kode-player'),
								'type' => 'upload',
							),	
							'player_info' => array(
								'title' => '',
								'header_title' => esc_attr__('Personal Information' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'date_of_birth' => array(
								'title' => __('Date of Birth' , 'kode-player'),
								'type' => 'date-picker',
								'wrapper-class' => 'four columns'
							),
							'place_of_birth' => array(
								'title' => __('Place Of Birth' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns'
							),
							'nationality' => array(
								'title' => __('Nationality' , 'kode-player'),								
								'type' => 'combobox',
								'wrapper-class' => 'four columns',
								'options' => $kode_countries
							),
							'height' => array(
								'title' => __('Height' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => 'Height will be in feet and will be converted into centimeter or meter as per themeoption panel',
							),
							'weight' => array(
								'title' => __('Weight' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => 'Weight will be in Lbs/KG.',
							),
							'reach' => array(
								'title' => __('Reach' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',								
							),
							'stance' => array(
								'title' => __('Stance' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',								
							),
							'trainer' => array(
								'title' => esc_attr__('Select Trainer' , 'kode-player'),
								'type' => 'combobox',
								'options' => kode_get_post_list_id('team'),
								'wrapper-class' => 'four columns',
								'description'=> esc_attr__('Select Trainer of the boxer.', 'kode-player')
							),
							'gym' => array(
								'title' => __('Gym' , 'kode-player'),
								'type' => 'text',
								'wrapper-class' => 'four columns',								
							),
							'player_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Tournament Stats' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'player-opponent'=> array(
								'title'=> __('Enable Opponent' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-goals'=> array(
								'title'=> __('Enable Goals' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-assist'=> array(
								'title'=> __('Enable Assist' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-own_goal'=> array(
								'title'=> __('Enable Own Goal' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-penalty'=> array(
								'title'=> __('Enable Penalty' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-position'=> array(
								'title'=> __('Enable Position' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-yellow-card'=> array(
								'title'=> __('Enable Yellow Card' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-red-card'=> array(
								'title'=> __('Enable Red Card' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'teams_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Team Tournament Stats' , 'kode-player'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'team-goals'=> array(
								'title'=> __('Enable Team Goals' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-sot'=> array(
								'title'=> __('Enable Team Short On Target' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-ck'=> array(
								'title'=> __('Enable Team Corner Kicks' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-yc'=> array(
								'title'=> __('Enable Team Yellow Cards' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-pa'=> array(
								'title'=> __('Enable Team Passing Accuracy' ,'kode-player'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							)
						)
					),

				),
				// page option attribute
				array(
					'post_type' => array('boxer'),
					'meta_title' => __('Boxer Option', 'kode-player'),
					'meta_slug' => 'boxer-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}	
	
	
	// Generate Options in theme Option Panel
	add_filter('kode_themeoption_panel', 'kode_register_football_themeoption');
	if( !function_exists('kode_register_football_themeoption') ){
		function kode_register_football_themeoption( $array ){		
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			//if empty
			if( empty($array['general']['options']) ){
				return $array;
			}
			
			//Blog options
			$post_themeoption_player = array(
				// general menu
				'title' => esc_html__('Player Post Type', 'kode-player'),
				'options' => array(
					'player_post_type' => array(
						'title' => esc_html__('Post Type Name', 'kode-player'),
						'type' => 'text',	
						'default' => 'Player',	
						'description' => 'Post type name should be first letter capitilize.',
					),
					'player_post_type_slug' => array(
						'title' => esc_html__('Post Type Slug', 'kode-player'),
						'type' => 'text',	
						'default' => 'player',	
						'description' => 'Post type name should be all letters will be lower.',
					),
					'player_post_type_category' => array(
						'title' => esc_html__('Post Type Category', 'kode-player'),
						'type' => 'checkbox',	
						'default' => 'enable'
					),
					'player_post_type_category_slug' => array(
						'title' => esc_html__('Post Type Category', 'kode-player'),
						'type' => 'text',	
						'default' => 'player_category',	
						'description' => 'Post type Category name should be all letters will be lower.',
					),
					'player_post_type_tag' => array(
						'title' => esc_html__('Post Type Tag', 'kode-player'),
						'type' => 'checkbox',	
						'default' => 'enable'
					),
					'player_post_type_tag_slug' => array(
						'title' => esc_html__('Post Type Tags', 'kode-player'),
						'type' => 'text',	
						'default' => 'player_tag',	
						'description' => 'Post type Tags name should be all letters will be lower.',
					),
				),
					
			);	
			
			$post_themeoption_player_set = array(
				// general menu
				'title' => esc_html__('Player Information', 'kode-player'),
				'options' => array(
					'personal_info' => array(
						'title' => __('Personal Information' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Personal Information',
						'description' => 'Enter the information you want to show in the bio table of the player.',
						'wrapper-class' => 'four columns'
					),
					'date_of_birth' => array(
						'title' => __('Date of Birth' , 'kode-player'),
						'type' => 'text',
						'default'=>'Date of Birth',
						'description' => 'Enter the date of birth string you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'place_of_birth' => array(
						'title' => __('Place Of Birth' , 'kode-player'),
						'type' => 'text',
						'default'=>'Place Of Birth',
						'description' => 'Enter the Place of birth string you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'nationality' => array(
						'title' => __('Nationality' , 'kode-player'),								
						'type' => 'text',
						'default'=>'Nationality',
						'description' => 'Enter the player nationality string you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'height' => array(
						'title' => __('Height' , 'kode-player'),
						'type' => 'text',
						'default'=>'Height',
						'description' => 'Enter the player height string you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'position' => array(
						'title' => __('Playing Position' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Playing Position',
						'description' => 'Enter the player position string you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'select_national' => array(
						'title' => esc_attr__('Select Team' , 'kode-player'),
						'type' => 'text',
						'default'=>'Select Team',
						'description' => 'Enter the Select team string you wish to have.',
						'wrapper-class' => 'four columns'
					),	
					'player_stats_while_tournaments' => array(
						'title' => esc_attr__('Player Stats While Tournaments' , 'kode-player'),
						'type' => 'text',
						'default'=>'Player Stats While Tournaments',
						'description' => 'Enter the Player Stats While Tournament string you wish to have.',
						'wrapper-class' => 'four columns'
					),	
					'player_tournaments_played' => array(
						'title' => esc_attr__('Tournaments Played In' , 'kode-player'),
						'type' => 'text',
						'default'=>'Tournaments Played In',
						'description' => 'Enter the Tournaments Played In string you wish to have.',
						'wrapper-class' => 'four columns'
					),	
				),
					
			);	
			
			$post_themeoption_player_set_tornament = array(
				// general menu
				'title' => esc_html__('Player Stats Tournament', 'kode-player'),
				'options' => array(
					'player-detail-table-1' => array(
						'title' => esc_html__('Player Detail Player Stats', 'kode-player'),
						'type' => 'checkbox',	
						'default' => 'enable',
						'description' => 'Click Here to enable / disable the Player detail Player stats table from here.',
					),
					'player-detail-table-2' => array(
						'title' => esc_html__('Player Detail Players Lineup', 'kode-player'),
						'type' => 'checkbox',	
						'default' => 'enable',
						'description' => 'Click Here to enable / disable the Player detail Players Lineup table from here.',
					),
					'single_player_name' => array(
						'title' => __('Player Name' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Player Name',
						'description' => 'Enter the Player Name string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_opponent' => array(
						'title' => __('Player Opponent' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Opponent',
						'description' => 'Enter the Player Opponent string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_goals' => array(
						'title' => __('Player Goals' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Goals',
						'description' => 'Enter the Player Goals string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_assist' => array(
						'title' => __('Player Assist' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Player Assist',
						'description' => 'Enter the Player Assist string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_own_goal' => array(
						'title' => __('Player Own Goal' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Own Goal',
						'description' => 'Enter the Player Own Goal string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_penalty' => array(
						'title' => __('Player Penalty' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Penalty',
						'description' => 'Enter the Player Penalty string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_position' => array(
						'title' => __('Player Position' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Position',
						'description' => 'Enter the Player Position string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_yellow_card' => array(
						'title' => __('Yellow Card' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Yellow Card',
						'description' => 'Enter the Player Yellow Card string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_red_card' => array(
						'title' => __('Red Card' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Red Card',
						'description' => 'Enter the Player Red Card string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_league' => array(
						'title' => __('Player league' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Player league',
						'description' => 'Enter the Player league string you want to show in the Player Stats While Tournament table.',
						'wrapper-class' => 'four columns'
					),
					
				),
					
			);	
			
			$post_themeoption_player_set_tornament_played = array(
				// general menu
				'title' => esc_html__('Tournament Played In', 'kode-player'),
				'options' => array(
					'single_player_tornament_in' => array(
						'title' => __('Tournament' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Tournament',
						'description' => 'Enter the Tournament string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_opponent_in' => array(
						'title' => __('Opponent' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Opponent',
						'description' => 'Enter the Opponent string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_goals_in' => array(
						'title' => __('Goals' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Goals',
						'description' => 'Enter the Goals string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_short_in' => array(
						'title' => __('Shorts on Target' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Shorts on Target',
						'description' => 'Enter the Shorts on Target string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_corner_kick_in' => array(
						'title' => __('Corner Kick' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Corner Kick',
						'description' => 'Enter the Corner Kick string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_yellow_card_in' => array(
						'title' => __('Yellow Card' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Yellow Card',
						'description' => 'Enter the Yellow Card string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					'single_player_passing_in' => array(
						'title' => __('Passing Accuracy' , 'kode-player'),							
						'type' => 'text',
						'default'=>'Passing Accuracy',
						'description' => 'Enter the Passing Accuracy string you want to show in the Tournaments Played In table.',
						'wrapper-class' => 'four columns'
					),
					
				),
					
			);
			
			

			$array['game-mode']['options']['player-mode'] = $post_themeoption_player;			
			$array['game-mode']['options']['player-settings'] = $post_themeoption_player_set;
			$array['game-mode']['options']['player-settings_tornment'] = $post_themeoption_player_set_tornament;
			$array['game-mode']['options']['player-settings_tornment_in'] = $post_themeoption_player_set_tornament_played;
			
			return $array;
		}
	}	
	
	
	
	// add player in page builder area
	add_filter('kode_page_builder_option', 'kode_register_player_item');
	if( !function_exists('kode_register_player_item') ){
		function kode_register_player_item( $page_builder = array() ){
			global $kode_spaces;
		
			$page_builder['content-item']['options']['player'] = array(
				'title'=> __('Player', 'kode-player'), 
				'icon'=>'fa-male',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> __('Category' ,'kode-player'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('player_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-player')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'kode-player'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('player_tag'),
						'description'=> __('Will be ignored when the player filter option is enabled.', 'kode-player')
					),					
					'player-style'=> array(
						'title'=> __('Player Style' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'normal-view' => __('Normal View', 'kode-player'),
							'modern-view' => __('Modern View', 'kode-player')
						),
					),					
					'num-fetch'=> array(
						'title'=> __('Num Fetch' ,'kode-player'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> __('Specify the number of players you want to pull out.', 'kode-player')
					),
					'num-title-fetch'=> array(
						'title'=> __('Num Title Fetch' ,'kode-player'),
						'type'=> 'text',	
						'default'=> '10',
						'description'=> __('Specify the number of player title you want to pull out.', 'kode-player')
					),
					'num-excerpt'=> array(
						'title'=> __('Num Excerpt' ,'kode-player'),
						'type'=> 'text',	
						'default'=> '20',
						'wrapper-class'=>'player-style-wrapper classic-player-wrapper classic-player-no-space-wrapper'
					),
					'orderby'=> array(
						'title'=> __('Order By' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode-player'), 
							'title' => __('Title', 'kode-player'), 
							'rand' => __('Random', 'kode-player'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode-player'), 
							'asc'=> __('Ascending Order', 'kode-player'), 
						)
					),			
					'pagination'=> array(
						'title'=> __('Enable Pagination' ,'kode-player'),
						'type'=> 'checkbox'
					),					
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode-player'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode-player')
					),				
				)
			);
			
			$page_builder['content-item']['options']['player-slider'] = array(
				'title'=> __('Player Slider', 'kode-player'), 
				'icon'=>'fa-rocket',
				'type'=>'item',
				'options'=>array(					
					'style-layout'=> array(
						'title'=> __('Style' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'style-1'=>__('Layout Style 1', 'kode-player'), 
							'style-2'=>__('Layout Style 2', 'kode-player'), 
						)
					),	
					'player-column-size'=> array(
						'title'=> __('Player Column Size' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'2'=>__('2 Columns', 'kode-player'), 
							'3'=>__('3 Columns', 'kode-player'), 
							'4'=>__('4 Columns', 'kode-player'), 
							'6'=>__('6 Columns', 'kode-player'), 
						)
					),						
					'category'=> array(
						'title'=> __('Category' ,'kode-player'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('player_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-player')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'kode-player'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('player_tag'),
						'description'=> __('Will be ignored when the player filter option is enabled.', 'kode-player')
					),					
					'num-title-fetch'=> array(
						'title'=> __('Num Fetch' ,'kode-player'),
						'type'=> 'text',	
						'default'=> '25',
						'description'=> __('Specify the number of title word you want to pull out.', 'kode-player')
					),	
					'orderby'=> array(
						'title'=> __('Order By' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode-player'), 
							'title' => __('Title', 'kode-player'), 
							'rand' => __('Random', 'kode-player'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode-player'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode-player'), 
							'asc'=> __('Ascending Order', 'kode-player'), 
						)
					),
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode-player'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode-player')
					),				
				)
			);
			return $page_builder;
		}
	}
	
	
	
	add_action('pre_post_update', 'kode_save_post_meta_option');
	if( !function_exists('kode_save_post_meta_option') ){
	function kode_save_post_meta_option( $post_id ){
			if( get_post_type() == 'player' && isset($_POST['post-option']) ){
				$post_option = kode_stopbackslashes(kode_stripslashes($_POST['post-option']));
				$post_option = json_decode(kode_decode_stopbackslashes($post_option), true);
				
				if(!empty($post_option['select_national'])){
					update_post_meta($post_id, 'select_national', esc_attr($_POST['select_national']));
				}else{
					delete_post_meta($post_id, 'select_national');
				}
				if(!empty($post_option['select_club'])){
					update_post_meta($post_id, 'select_club', esc_attr($_POST['select_club']));
				}else{
					delete_post_meta($post_id, 'select_club');
				}
			}
		}
	}
?>