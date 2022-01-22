<?php
	/*	
	*	Kodeforest Event Option file
	*	---------------------------------------------------------------------
	*	This file creates all post options to the post page
	*	---------------------------------------------------------------------
	*/
	
	// add a post admin option
	// add a post option to post page
	if( is_admin() ){ add_action('init', 'kode_create_event_options'); }
	if( !function_exists('kode_create_event_options') ){
	
		function kode_create_event_options(){
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
									'no-sidebar'=>		KODE_PATH . '/framework/include/backend_assets/images/no-sidebar.png',
									'both-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/both-sidebar.png', 
									'right-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/right-sidebar.png',
									'left-sidebar'=>	KODE_PATH . '/framework/include/backend_assets/images/left-sidebar.png'
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
								'description' => esc_html__('Leave this field blank to use the default title from admin panel > general > blog style section.', 'kickoff')
							),
							'page-caption' => array(
								'title' => esc_html__('Post Caption' , 'kickoff'),
								'type' => 'textarea'
							),
							'team_first' => array(
								'title' => '',
								'header_title' => esc_html__('Team First Detail' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'select_team_first' => array(
								'title' => esc_html__('Select Team First' , 'kickoff'),
								'type' => 'combobox',
								'options' => kode_get_post_list_id('team'),
								'wrapper-class' => 'four columns',
								'ajax'	=>	'load_ajax_team_players_first',
								'settings'	=>	'team_lineup_first',
								'description'=> esc_html__('Select Team for the fixture.', 'kickoff')
							),	
							'goal_scored_team_first' => array(
								'title' => esc_html__('Number of Goals Scored' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Goal Scored by Team.', 'kickoff')
							),
							'total_shots_team_first' => array(
								'title' => esc_html__('Total Shots' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of total shorts by Team.', 'kickoff')
							),
							'shorts_on_targets_team_first' => array(
								'title' => esc_html__('Shots on target' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of shorts on target by Team.', 'kickoff')
							),
							'ball_possession_team_first' => array(
								'title' => esc_html__('Ball possession' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Ball Possession by Team in percentage for example: 60%.', 'kickoff')
							),
							'corner_kicks_team_first' => array(
								'title' => esc_html__('Corner kicks' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of corner kicks taken by Team.', 'kickoff')
							),
							'fouls_committed_team_first' => array(
								'title' => esc_html__('Fouls committed' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of fouls committed by Team.', 'kickoff')
							),
							'offsides_team_first' => array(
								'title' => esc_html__('Offsides' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of offsides taken by Team.', 'kickoff')
							),
							'saves_team_first' => array(
								'title' => esc_html__('Saves' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of saves done by Team.', 'kickoff')
							),
							'yellow_cards_team_first' => array(
								'title' => esc_html__('Yellow cards' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Yellow Cards Shown to Team.', 'kickoff')
							),
							'red_cards_team_first' => array(
								'title' => esc_html__('Red cards' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Red Cards Shown to Team.', 'kickoff')
							),
							'team_player_selection_first' => array(
								'title' => '',
								'header_title' => esc_html__('Players Line Up' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							
							'team_lineup_first' => array(
								'title' => esc_html__('Players Lineup' , 'kickoff'),
								'type' => 'player-lineup',	
								'wrapper-class' => 'player_line_up_class_first'								
							),
							'team_second_detail' => array(
								'title' => '',
								'header_title' => esc_html__('Team Second Detail' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'select_team_second' => array(
								'title' => esc_html__('Select Team Second' , 'kickoff'),
								'type' => 'combobox',
								'options' => kode_get_post_list_id('team'),
								'wrapper-class' => 'four columns',
								'ajax'	=>	'load_ajax_team_players_first',
								'settings'	=>	'team_lineup_second',
								'description'=> esc_html__('Select Team for the fixture.', 'kickoff')
							),	
							'goal_scored_team_second' => array(
								'title' => esc_html__('Number of Goals Scored' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Goal Scored by Team.', 'kickoff')
							),
							'total_shots_team_second' => array(
								'title' => esc_html__('Total Shots' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of total shorts by Team.', 'kickoff')
							),
							'shorts_on_targets_team_second' => array(
								'title' => esc_html__('Shots on target' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of shorts on target by Team.', 'kickoff')
							),
							'ball_possession_team_second' => array(
								'title' => esc_html__('Ball possession' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Ball Possession by Team in percentage for example: 60%.', 'kickoff')
							),
							'corner_kicks_team_second' => array(
								'title' => esc_html__('Corner kicks' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of corner kicks taken by Team.', 'kickoff')
							),
							'fouls_committed_team_second' => array(
								'title' => esc_html__('Fouls committed' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of fouls committed by Team.', 'kickoff')
							),
							'offsides_team_second' => array(
								'title' => esc_html__('Offsides' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of offsides taken by Team.', 'kickoff')
							),
							'saves_team_second' => array(
								'title' => esc_html__('Saves' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of saves done by Team.', 'kickoff')
							),
							'yellow_cards_team_second' => array(
								'title' => esc_html__('Yellow cards' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Yellow Cards Shown to Team.', 'kickoff')
							),
							'red_cards_team_second' => array(
								'title' => esc_html__('Red cards' , 'kickoff'),
								'type' => 'text',
								'wrapper-class' => 'four columns',
								'description' => esc_html__('Number of Red Cards Shown to Team.', 'kickoff')
							),
							'team_player_selection_second' => array(
								'title' => '',
								'header_title' => esc_html__('Players Line Up' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'team_lineup_second' => array(
								'title' => esc_html__('Players Line up' , 'kickoff'),
								'type' => 'player-lineup-second',	
								'wrapper-class' => 'player_line_up_class_second'									
							),
							'player_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_html__('Tournament Stats' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'player-opponent'=> array(
								'title'=> esc_html__('Enable Opponent' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-goals'=> array(
								'title'=> esc_html__('Enable Goals' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-assist'=> array(
								'title'=> esc_html__('Enable Assist' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-own_goal'=> array(
								'title'=> esc_html__('Enable Own Goal' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-penalty'=> array(
								'title'=> esc_html__('Enable Penalty' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-position'=> array(
								'title'=> esc_html__('Enable Position' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-yellow-card'=> array(
								'title'=> esc_html__('Enable Yellow Card' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-red-card'=> array(
								'title'=> esc_html__('Enable Red Card' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'teams_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_html__('Team Tournament Stats' , 'kickoff'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'team-goals'=> array(
								'title'=> esc_html__('Enable Team Goals' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-sot'=> array(
								'title'=> esc_html__('Enable Team Short On Target' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-ck'=> array(
								'title'=> esc_html__('Enable Team Corner Kicks' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-yc'=> array(
								'title'=> esc_html__('Enable Team Yellow Cards' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-pa'=> array(
								'title'=> esc_html__('Enable Team Passing Accuracy' ,'kickoff'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							)
						)
					),
				),
				
				// page option attribute
				array(
					'post_type' => array('event'),
					'meta_title' => esc_html__('Kodeforest Event Option', 'kickoff'),
					'meta_slug' => 'kodeforest-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}
	
	
	// Generate Options in theme Option Panel
	add_filter('kode_themeoption_panel', 'kode_register_event_themeoption');
	if( !function_exists('kode_register_event_themeoption') ){
		function kode_register_event_themeoption( $array ){		
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			//if empty
			if( empty($array['general']['options']) ){
				return $array;
			}
			
			//Blog options
			$post_themeoption_event = array(
				'title' => esc_html__('Fixture Settings', 'kickoff'),
				'options' => array(
					'select_team_first' => array(
						'title' => esc_html__('Select Team First' , 'kickoff'),
						'type' => 'text',
						'default' => 'Select Team First',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team member string for the fixture.', 'kickoff'),
					),	
					'goal_scored_team_first' => array(
						'title' => esc_html__('Number of Goals Scored' , 'kickoff'),
						'type' => 'text',
						'default' => 'Number of Goals Scored',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Goal scored by team first text string for the fixture.', 'kickoff'),
					),
					'total_shots_team_first' => array(
						'title' => esc_html__('Total Shots' , 'kickoff'),
						'type' => 'text',
						'default' => 'Total Shots',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter total number of shots by team first text string for the fixture.', 'kickoff'),
					),
					'shorts_on_targets_team_first' => array(
						'title' => esc_html__('Shots on target' , 'kickoff'),
						'type' => 'text',
						'default' => 'Shots on target',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter shorts on target by team first text string for the fixture.', 'kickoff'),
					),
					'ball_possession_team_first' => array(
						'title' => esc_html__('Ball possession' , 'kickoff'),
						'type' => 'text',
						'default' => 'Ball possession',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter ball possession team first scored by team first text string for the fixture.', 'kickoff'),
					),
					'corner_kicks_team_first' => array(
						'title' => esc_html__('Corner kicks' , 'kickoff'),
						'type' => 'text',
						'default' => 'Corner kicks',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter ball possession team first scored by team first text string for the fixture.', 'kickoff'),
					),
					'fouls_committed_team_first' => array(
						'title' => esc_html__('Fouls committed' , 'kickoff'),
						'type' => 'text',
						'default' => 'Fouls committed',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter fouls comitted scored by team first text string for the fixture.', 'kickoff'),
					),
					'offsides_team_first' => array(
						'title' => esc_html__('Offsides' , 'kickoff'),
						'type' => 'text',
						'default' => 'Offsides',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter offside team first text string for the fixture.', 'kickoff'),
					),
					'saves_team_first' => array(
						'title' => esc_html__('Saves' , 'kickoff'),
						'type' => 'text',
						'default' => 'Saves',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter saves team first text string for the fixture.', 'kickoff'),
					),
					'yellow_cards_team_first' => array(
						'title' => esc_html__('Yellow cards' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow cards',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter yellow cards team first text string for the fixture.', 'kickoff'),
					),
					'red_cards_team_first' => array(
						'title' => esc_html__('Red cards' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red cards',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter red card first text string for the fixture.', 'kickoff'),
					),
					
					'select_team_second' => array(
						'title' => esc_html__('Select Team Second' , 'kickoff'),
						'type' => 'text',
						'default' => 'Select Team Second',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Second team text string for the fixture.', 'kickoff'),
					),	
					'goal_scored_team_second' => array(
						'title' => esc_html__('Number of Goals Scored' , 'kickoff'),
						'type' => 'text',
						'default' => 'Number of Goals Scored',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter goals scored second team text string for the fixture.', 'kickoff'),
					),
					'total_shots_team_second' => array(
						'title' => esc_html__('Total Shots' , 'kickoff'),
						'type' => 'text',
						'default' => 'Total Shots',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter total shorts second team text string for the fixture.', 'kickoff'),
					),
					'shorts_on_targets_team_second' => array(
						'title' => esc_html__('Shots on target' , 'kickoff'),
						'type' => 'text',
						'wrapper-class' => 'four columns',
						'default' => 'Shots on target',
						'description'=> esc_html__('Enter shorts on target second team text string for the fixture.', 'kickoff'),
					),
					'ball_possession_team_second' => array(
						'title' => esc_html__('Ball possession' , 'kickoff'),
						'type' => 'text',
						'default' => 'Ball possession',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter ball possession team second text string for the fixture.', 'kickoff'),
					),
					'corner_kicks_team_second' => array(
						'title' => esc_html__('Corner kicks' , 'kickoff'),
						'type' => 'text',
						'default' => 'Corner kicks',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter corner Kicks team second text string for the fixture.', 'kickoff'),
					),
					'fouls_committed_team_second' => array(
						'title' => esc_html__('Fouls committed' , 'kickoff'),
						'type' => 'text',
						'default' => 'Fouls committed',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter fouls committed by team second text string for the fixture.', 'kickoff'),
					),
					'offsides_team_second' => array(
						'title' => esc_html__('Offsides' , 'kickoff'),
						'type' => 'text',
						'default' => 'Offsides',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter offside team second text string for the fixture.', 'kickoff'),
					),
					'saves_team_second' => array(
						'title' => esc_html__('Saves' , 'kickoff'),
						'type' => 'text',
						'default' => 'Saves',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter saves team text string for the fixture.', 'kickoff'),
					),
					'yellow_cards_team_second' => array(
						'title' => esc_html__('Yellow cards' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow cards',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter yellow card team second text string for the fixture.', 'kickoff'),
					),
					'red_cards_team_second' => array(
						'title' => esc_html__('Red cards' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red cards',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter red card team second text string for the fixture.', 'kickoff'),
					),
				),
			);
			
			//Team performance Table Strings
			
			$post_themeoption_event_team_1 = array(
				'title' => esc_html__('Team 1 Performance Table', 'kickoff'),
				'options' => array(
					'team_performance_1' => array(
						'title' => esc_html__('Team Performance 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Team Performance',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team Performance string for the fixture.', 'kickoff'),
					),	
					'team_performance_team_1' => array(
						'title' => esc_html__('Team 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Team',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 name string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_match' => array(
						'title' => esc_html__('Team 1 Match' , 'kickoff'),
						'type' => 'text',
						'default' => 'Match',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Match for the team 1 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_goal' => array(
						'title' => esc_html__('Goal Team 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goals',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Goal 1 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_won' => array(
						'title' => esc_html__('Won Team 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Won',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Won Team 1 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_lost' => array(
						'title' => esc_html__('Lost Team 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Lost',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Lost Team 1 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_draw' => array(
						'title' => esc_html__('Team 1 Draw' , 'kickoff'),
						'type' => 'text',
						'default' => 'Draw',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Daw Team 1 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_1_pts' => array(
						'title' => esc_html__('Team 1 Points' , 'kickoff'),
						'type' => 'text',
						'default' => 'PTS+/-',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter PTS+/- Team 1 string for the fixture.', 'kickoff'),
					),
				),
			);
			
			
			$post_themeoption_event_team_2 = array(
				'title' => esc_html__('Team 2 Performance Table', 'kickoff'),
				'options' => array(
					'team_performance_2' => array(
						'title' => esc_html__('Team Performance 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Team Performance',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team Performance string for the fixture.', 'kickoff'),
					),	
					'team_performance_team_2' => array(
						'title' => esc_html__('Team 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Team',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 name string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_match' => array(
						'title' => esc_html__('Team 2 Match' , 'kickoff'),
						'type' => 'text',
						'default' => 'Match',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Match for the team 2 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_goal' => array(
						'title' => esc_html__('Goal' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goals',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Goal 2 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_won' => array(
						'title' => esc_html__('Won Team 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Won',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Won Team 2 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_lost' => array(
						'title' => esc_html__('Lost Team 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Lost',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Lost Team 2 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_draw' => array(
						'title' => esc_html__('Team 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Draw',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Daw Team 2 string for the fixture.', 'kickoff'),
					),
					'team_performance_team_2_pts' => array(
						'title' => esc_html__('Team 2 Points' , 'kickoff'),
						'type' => 'text',
						'default' => 'PTS+/-',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter PTS+/- Team 2 string for the fixture.', 'kickoff'),
					),
				),
			);
			
			$post_themeoption_event_line_1 = array(
				'title' => esc_html__('Team 1 Player Line Up', 'kickoff'),
				'options' => array(
					'team_player_line_1' => array(
						'title' => esc_html__('Team 1 Player Line Up' , 'kickoff'),
						'type' => 'text',
						'default' => 'Players Line up',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Players Line up string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_player_name' => array(
						'title' => esc_html__('Team 1 Player Name' , 'kickoff'),
						'type' => 'text',
						'default' => 'Player Name',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Players Name up string for the fixture.', 'kickoff'),
					),	
					'team_player_line_1_opponent' => array(
						'title' => esc_html__('Team 1 Player Opponent' , 'kickoff'),
						'type' => 'text',
						'default' => 'Opponent',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Opponent string for the fixture.', 'kickoff'),
					),	
					'team_player_line_1_goal' => array(
						'title' => esc_html__('Team 1 Player Name' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goal',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Goal string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_assist' => array(
						'title' => esc_html__('Team 1 Assist' , 'kickoff'),
						'type' => 'text',
						'default' => 'Assist',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Assist Team 1 string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_own_goal' => array(
						'title' => esc_html__('Team 1 Own Goal' , 'kickoff'),
						'type' => 'text',
						'default' => 'Own Goal',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Own Goal team 1 string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_penalty' => array(
						'title' => esc_html__('Team 1 Penalty' , 'kickoff'),
						'type' => 'text',
						'default' => 'Penalty',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Penalty string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_position' => array(
						'title' => esc_html__('Team 1 Player Position' , 'kickoff'),
						'type' => 'text',
						'default' => 'Position',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Position string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_yellow_card' => array(
						'title' => esc_html__('Team 1 yellow card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Yellow Card string for the fixture.', 'kickoff'),
					),
					'team_player_line_1_red_card' => array(
						'title' => esc_html__('Team 1 Red Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Red Card string for the fixture.', 'kickoff'),
					),
					
				),
			);
			
			$post_themeoption_event_line_2 = array(
				'title' => esc_html__('Team 2 Player Line Up', 'kickoff'),
				'options' => array(
					'team_player_line_2' => array(
						'title' => esc_html__('Team 2 Player Line Up' , 'kickoff'),
						'type' => 'text',
						'default' => 'Players Line up',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Players Line up string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_player_name' => array(
						'title' => esc_html__('Team 2 Player Name' , 'kickoff'),
						'type' => 'text',
						'default' => 'Player Name',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Players Name up string for the fixture.', 'kickoff'),
					),	
					'team_player_line_2_opponent' => array(
						'title' => esc_html__('Team 2 Player Opponent' , 'kickoff'),
						'type' => 'text',
						'default' => 'Opponent',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Opponent string for the fixture.', 'kickoff'),
					),	
					'team_player_line_2_goal' => array(
						'title' => esc_html__('Team 2 Player Name' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goal',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Goal string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_assist' => array(
						'title' => esc_html__('Team 2 Assist' , 'kickoff'),
						'type' => 'text',
						'default' => 'Assist',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Assist Team 2 string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_own_goal' => array(
						'title' => esc_html__('Team 2 Own Goal' , 'kickoff'),
						'type' => 'text',
						'default' => 'Own Goal',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Own Goal team 2 string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_penalty' => array(
						'title' => esc_html__('Team 2 Penalty' , 'kickoff'),
						'type' => 'text',
						'default' => 'Penalty',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Penalty string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_position' => array(
						'title' => esc_html__('Team 2 Player Position' , 'kickoff'),
						'type' => 'text',
						'default' => 'Position',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Position string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_yellow_card' => array(
						'title' => esc_html__('Team 2 yellow card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Yellow Card string for the fixture.', 'kickoff'),
					),
					'team_player_line_2_red_card' => array(
						'title' => esc_html__('Team 2 Red Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Red Card string for the fixture.', 'kickoff'),
					),
					
				),
			);
			
			$post_themeoption_event_result_1 = array(
				'title' => esc_html__('Team 1 Result Table', 'kickoff'),
				'options' => array(
					'team_result_1_tournment' => array(
						'title' => esc_html__('Team Result Table 1' , 'kickoff'),
						'type' => 'text',
						'default' => 'Tournament',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Tornument string for the fixture.', 'kickoff'),
					),
					'team_result_1_opponent' => array(
						'title' => esc_html__('Team Result Table 1 opponent' , 'kickoff'),
						'type' => 'text',
						'default' => 'Opponent',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Opponent string for the fixture.', 'kickoff'),
					),
					'team_result_1_goals' => array(
						'title' => esc_html__('Team Result Table 1 Goals' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goals',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Goals string for the fixture.', 'kickoff'),
					),
					'team_result_1_target' => array(
						'title' => esc_html__('Team Result Table 1 Shorts On Target' , 'kickoff'),
						'type' => 'text',
						'default' => 'Shorts On Target',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Shorts On Target string for the fixture.', 'kickoff'),
					),
					'team_result_1_corner_kick' => array(
						'title' => esc_html__('Team Result Table 1 Corner Kick' , 'kickoff'),
						'type' => 'text',
						'default' => 'Corner Kick',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Corner Kick string for the fixture.', 'kickoff'),
					),
					'team_result_1_yellow_card' => array(
						'title' => esc_html__('Team Result Table 1 Yellow Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Yellow Card string for the fixture.', 'kickoff'),
					),
					'team_result_1_red_card' => array(
						'title' => esc_html__('Team Result Table 1 Red Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 1 Result Red Card string for the fixture.', 'kickoff'),
					),
				),
			);
			
			$post_themeoption_event_result_2 = array(
				'title' => esc_html__('Team 2 Result Table', 'kickoff'),
				'options' => array(
					'team_result_2_tournment' => array(
						'title' => esc_html__('Team Result Table 2' , 'kickoff'),
						'type' => 'text',
						'default' => 'Tournament',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Tornument string for the fixture.', 'kickoff'),
					),
					'team_result_2_opponent' => array(
						'title' => esc_html__('Team Result Table 2 opponent' , 'kickoff'),
						'type' => 'text',
						'default' => 'Opponent',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Opponent string for the fixture.', 'kickoff'),
					),
					'team_result_2_goals' => array(
						'title' => esc_html__('Team Result Table 2 Goals' , 'kickoff'),
						'type' => 'text',
						'default' => 'Goals',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Goals string for the fixture.', 'kickoff'),
					),
					'team_result_2_target' => array(
						'title' => esc_html__('Team Result Table 2 Shorts On Target' , 'kickoff'),
						'type' => 'text',
						'default' => 'Shorts On Target',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Shorts On Target string for the fixture.', 'kickoff'),
					),
					'team_result_2_corner_kick' => array(
						'title' => esc_html__('Team Result Table 2 Corner Kick' , 'kickoff'),
						'type' => 'text',
						'default' => 'Corner Kick',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Corner Kick string for the fixture.', 'kickoff'),
					),
					'team_result_2_yellow_card' => array(
						'title' => esc_html__('Team Result Table 2 Yellow Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Yellow Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Yellow Card string for the fixture.', 'kickoff'),
					),
					'team_result_2_red_card' => array(
						'title' => esc_html__('Team Result Table 2 Red Card' , 'kickoff'),
						'type' => 'text',
						'default' => 'Red Card',
						'wrapper-class' => 'four columns',
						'description'=> esc_html__('Enter Team 2 Result Red Card string for the fixture.', 'kickoff'),
					),
				),
			);
			

			$array['game-mode']['options']['event-mode'] = $post_themeoption_event;	
			$array['game-mode']['options']['event-team-performance-1'] = $post_themeoption_event_team_1;	
			$array['game-mode']['options']['event-team-performance-2'] = $post_themeoption_event_team_2;
			$array['game-mode']['options']['event-team-line-1'] = $post_themeoption_event_line_1;	
			$array['game-mode']['options']['event-team-line-2'] = $post_themeoption_event_line_2;
			$array['game-mode']['options']['event-team-result-1'] = $post_themeoption_event_result_1;
			$array['game-mode']['options']['event-team-result-2'] = $post_themeoption_event_result_2;
			
			return $array;
		}
	}	
	
	
	// add work in page builder area
	add_filter('kode_page_builder_option', 'kode_register_event_item');
	if( !function_exists('kode_register_event_item') ){
		function kode_register_event_item( $page_builder = array() ){
			global $kode_spaces;
			$page_builder['content-item']['options']['events'] = array(
				'title'=> esc_html__('Events', 'kickoff'), 
				'icon'=>'fa-calendar',
				'type'=>'item',
				'options'=> array(					
					'title-num-excerpt'=> array(
						'title'=> esc_html__('Title Num Length (Word)' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '15',
						'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the event title. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
					),	
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-tags'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'num-excerpt'=> array(
						'title'=> esc_html__('Num Excerpt (Word)' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '25',
						'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the post excerpt. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
					),	
					'num-fetch'=> array(
						'title'=> esc_html__('Num Fetch' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> esc_html__('Specify the number of posts you want to pull out.', 'kickoff')
					),										
					'event-style'=> array(
						'title'=> esc_html__('Event Style' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'event-grid-modern' => esc_html__('Match Grid Modern', 'kickoff'),
							'event-grid-simple' => esc_html__('Match Table View', 'kickoff'),
							'event-full-view' => esc_html__('Match Full View', 'kickoff'),
							'event-grid-rugby' => esc_html__('New Rugby', 'kickoff'),
						),
						'default'=>'event-full-view'
					),		
					'scope'=> array(
						'title'=> esc_html__('Match Scope' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'past' => esc_html__('Past Matches', 'kickoff'), 
							'future' => esc_html__('Upcoming Matches', 'kickoff'), 
							'all' => esc_html__('All Matches', 'kickoff'), 
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
					// 'pagination'=> array(
						// 'title'=> esc_html__('Enable Pagination' ,'kickoff'),
						// 'type'=> 'checkbox'
					// ),										
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note: Donot Write px with it.', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['upcoming-event'] = array(
				'title'=> esc_html__('Upcoming Event', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'title-num-excerpt'=> array(
						'title'=> esc_html__('Title Num Length (Word)' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '15',
						'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the event title. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kickoff')
					),	
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-tags'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['live-result'] = array(
				'title'=> esc_html__('Live Result', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'header-title'=> array(
						'title'=> esc_html__('Header Title' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '15',
						'description'=> esc_html__('This is header title which will manage header title.', 'kickoff')
					),	
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-tags'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'fixtures-show'=> array(
						'title'=> esc_html__('Show Fixtures Tab' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'current'=>esc_html__('Current Fixtures', 'kickoff'), 
							'result'=> esc_html__('Fixture Results', 'kickoff'), 
							'future'=> esc_html__('Upcomming Fixtures', 'kickoff'), 
						)
					),	
					'num-fetch' => array(
						'title' => esc_html__('Number Fetch', 'kickoff'),
						'type' => 'text',
						'default' => '3',
						'description' => esc_html__('Show number of matches in each tab.', 'kickoff')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['fixture'] = array(
				'title'=> esc_html__('Fixtures', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'header-title'=> array(
						'title'=> esc_html__('Header Title' ,'kickoff'),
						'type'=> 'text',	
						'default'=> '15',
						'description'=> esc_html__('This is header title which will manage header title.', 'kickoff')
					),	
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-tags'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'scope'=> array(
						'title'=> esc_html__('Fixture Scope' ,'kickoff'),
						'type'=> 'combobox',
						'options'=> array(
							'all'=>esc_html__('All Fixtures', 'kickoff'), 
							'past'=> esc_html__('Past Fixtures', 'kickoff'), 
							'future'=> esc_html__('Future Fixtures', 'kickoff'), 
						)
					),	
					'num-fetch' => array(
						'title' => esc_html__('Number Fetch', 'kickoff'),
						'type' => 'text',
						'default' => '3',
						'description' => esc_html__('Show number of matches in each tab.', 'kickoff')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['next-fixtures'] = array(
				'title'=> esc_html__('Next Fixtures', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'header-title'=> array(
						'title'=> esc_html__('Header Title Right' ,'kickoff'),
						'type'=> 'text',	
						'default'=> 'Upcoming Fixtures',
						'description'=> esc_html__('Header Title of right side.', 'kickoff')
					),	
					'header-description'=> array(
						'title'=> esc_html__('Header Description Right' ,'kickoff'),
						'type'=> 'text',	
						'default'=> 'Nullam ac urna eu felis dapibus sit sed ame augue. Sed non neque elit.',
						'description'=> esc_html__('Header Description of right side.', 'kickoff')
					),	
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'player-right-bg-image' => array(
						'title' => esc_html__('Background Image' , 'kickoff'),
						'button' => esc_html__('Upload', 'kickoff'),
						'type' => 'upload',											
					),
					'player-right-bg-color' => array(
						'title' => esc_html__('Background Color', 'kickoff'),
						'type' => 'colorpicker',
						'default' => '#ffffff',						
					),					
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			$page_builder['content-item']['options']['next-match'] = array(
				'title'=> esc_html__('Next Match', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'title-num-excerpt'=> array(
						'title'=> esc_html__('Next Event Title' ,'kickoff'),
						'type'=> 'text',	
						'default'=> 'Next Match',
						'description'=> esc_html__('Add Next Event Title Here.', 'kickoff')
					),	
					'player-left-image' => array(
						'title' => esc_html__('Player Left Image' , 'kickoff'),
						'button' => esc_html__('Upload', 'kickoff'),
						'type' => 'upload',											
					),
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			
			$page_builder['content-item']['options']['event-list'] = array(
				'title'=> esc_html__('Event List', 'kickoff'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(
					'header-title'=> array(
						'title'=> esc_html__('Event List' ,'kickoff'),
						'type'=> 'text',	
						'default'=> 'Next Match',
						'description'=> esc_html__('Add Next Event Title Here.', 'kickoff')
					),					
					'category'=> array(
						'title'=> esc_html__('Category' ,'kickoff'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('event-categories'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kickoff')
					),
					'num-fetch' => array(
						'title' => esc_html__('Number Of Events', 'kickoff'),
						'type' => 'text',
						'default' => '3',
						'description' => esc_html__('Show number of events in list view.', 'kickoff')
					),					
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kickoff'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kickoff')
					),					
				)
			);
			
			
			
			
			
			
			
			return $page_builder;
		}
	}
	
	if( !function_exists('kode_get_event_info') ){
		function kode_get_event_info( $event_id='', $array = array(), $wrapper = true, $sep = '',$div_wrap = 'div' ){
			global $kode_theme_option; $ret = '';
			if( empty($array) ) return $ret;
			//$exclude_meta = empty($kode_theme_option['post-meta-data'])? array(): esc_attr($kode_theme_option['post-meta-data']);
			
			foreach($array as $post_info){
				
				if( !empty($sep) ) $ret .= $sep;

				switch( $post_info ){
					case 'date':
						$ret .= '<'.esc_attr($div_wrap).' class="event-info event-date"><i class="fa fa-clock-o"></i>';
						$ret .= '<a href="' . esc_url(get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d'))) . '">';
						$ret .= esc_attr(get_the_time());
						$ret .= '</a>';
						$ret .= '</'.esc_attr($div_wrap).'>';
						break;
					case 'tag':
						$tag = get_the_term_list($event_id, 'event-tags', '', '<span class="sep">,</span> ' , '' );
						if(empty($tag)) break;					
						
						$ret .= '<'.esc_attr($div_wrap).' class="event-info event-tags"><i class="fa fa-tag"></i>';
						$ret .= $tag;						
						$ret .= '</'.esc_attr($div_wrap).'>';					
						break;
					case 'category':
						$category = get_the_term_list($event_id, 'event-categories', '', '<span class="sep">,</span> ' , '' );
						if(empty($category)) break;
						
						$ret .= '<'.esc_attr($div_wrap).' class="event-info event-category"><i class="fa fa-list"></i>';
						$ret .= $category;					
						$ret .= '</'.esc_attr($div_wrap).'>';			
						break;
					case 'comment':
						$ret .= '<'.esc_attr($div_wrap).' class="event-info event-comment"><i class="fa fa-comment-o"></i>';
						$ret .= '<a href="' . esc_url(get_permalink($event_id)) . '#respond" >' . esc_attr(get_comments_number()) . '</a>';						
						$ret .= '</'.esc_attr($div_wrap).'>';					
						break;
					case 'author':
						ob_start();
						the_author_posts_link();
						$author = ob_get_contents();
						ob_end_clean();
						
						$ret .= '<'.esc_attr($div_wrap).' class="event-info event-author"><i class="fa fa-user"></i>';
						$ret .= $author;
						$ret .= '</'.esc_attr($div_wrap).'>';			
						break;						
				}
			}
			
			
			if($wrapper && !empty($ret)){
				return '<div class="kode-event-info kode-info">' . $ret . '<div class="clear"></div></div>';
			}else if( !empty($ret) ){
				return $ret;
			}
			return '';			
		}
	}
	
	//Event Listing
	// if( !function_exists('kode_get_all_events_id') ){
		// function kode_get_all_events_id( ){
			// $event_id = array();
			// $EM_Events = EM_Events::get( array('scope'=>'all') );
			// foreach($EM_Events as $event){
				// $event_id[] = $event->post_id;
			// }
			// return $event_id;
		// }
	// }
	
	// select_team_first
	
	
	
	//Event Listing
	if( !function_exists('kode_get_all_eventsid_by_teamid') ){
		function kode_get_all_eventsid_by_teamid( $kode_team_id ){
			$event_id = array();
			$EM_Events = EM_Events::get( array('scope'=>'all') );
			foreach($EM_Events as $event){
				$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
				$category = wp_get_post_terms( $event->post_id, 'event-categories',$args );
				$event_post_data = json_decode(kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true)));
				if($event_post_data->select_team_first == $kode_team_id){
					$event_id[] = $event->post_id;
				}else if($event_post_data->select_team_second == $kode_team_id){
					$event_id[] = $event->post_id;
				}
			}
			return $event_id;
		}
	}
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_performance') ){
		function kode_get_team_performance($team_id){
			$kode_html = '';
			if(isset($team_id)){
				$team_win_result = kode_get_result_team_won($team_id, 'won');
				$team_lost_result = kode_get_result_team_won($team_id, 'loss');
				$team_draw_result = kode_get_result_team_won($team_id, 'draw');
				if(empty($team_win_result['goal_scored_team']) && empty($team_lost_result['goal_scored_team'])){
					$total_goals = 0;
				}else if(empty($team_lost_result['goal_scored_team'])){
					$total_goals = $team_win_result['goal_scored_team'];					
					$total_goals = array_merge(array(1=>'0'),$team_win_result['goal_scored_team']);	
					$total_goals = array_sum($total_goals);
				}else if(empty($team_win_result['goal_scored_team'])){
					$total_goals = $team_lost_result['goal_scored_team'];					
					$total_goals = array_merge(array(1=>'0'),$team_lost_result['goal_scored_team']);	
					$total_goals = array_sum($total_goals);					
				}else{
					$total_goals = array_merge($team_win_result['goal_scored_team'],$team_lost_result['goal_scored_team']);	
					$total_goals = array_sum($total_goals);
				}
				
				
				if(!empty($team_lost_result['select_team'])){
					$team_loss = count($team_lost_result['select_team']);
				}else{
					$team_loss = 0;
				}
				
				if(!empty($team_win_result['select_team'])){
					$team_won = count($team_win_result['select_team']);
				}else{
					$team_won = 0;
				}
				
				if(!empty($team_draw_result['select_team'])){
					$team_draw = count($team_draw_result['select_team']);
				}else{
					$team_draw = 0;
				}
				if(!empty($team_draw_result['select_team'])){
					if(empty($team_win_result['select_team'])){
						$total_matches = array_merge($team_lost_result['select_team'],$team_draw_result['select_team']);		
					} else if(empty($team_lost_result['select_team'])){
						$total_matches = array_merge($team_win_result['select_team'],$team_draw_result['select_team']);		
					}else{
						$total_matches = array_merge($team_win_result['select_team'],$team_lost_result['select_team'],$team_draw_result['select_team']);		
					}
				}else{
					if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];
					}else if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];
					}else{
						$total_matches = array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}
				global $kode_theme_option;
				
				$total_matches = count($total_matches);
				$points_on_winning = $team_won*$kode_theme_option['match-points'];
				$points_on_draw = $team_draw*$kode_theme_option['match-points-drawn'];
				$total_points = $points_on_draw+$points_on_winning;
				$kode_html = '<td><a href="'.esc_url(get_permalink($team_id)).'">'.esc_attr(get_the_title($team_id)).'</a></td>';
				$kode_html .= '<td>'.esc_attr($total_matches).'</td>';
				$kode_html .= '<td>'.esc_attr($total_goals).'</td>';
				$kode_html .= '<td>'.esc_attr($team_won).'</td>';
				$kode_html .= '<td>'.esc_attr($team_loss).'</td>';
				$kode_html .= '<td>'.esc_attr($team_draw).'</td>';
				$kode_html .= '<td>'.esc_attr($total_points).'</td>';
				
			
			}
			return $kode_html;
		}
	}
	
	//get all the teams who played in an event
	if( !function_exists('kode_get_all_top_teams') ){
		function kode_get_all_top_teams(  ){
			$team_exist = array();
			$args = array('post_type' => 'team', 'suppress_filters' => false);
			$args['posts_per_page'] = -1;;
			$args['orderby'] = 'post_date';
			
			$args['order'] = 'desc';
			$query = new WP_Query( $args );			
			$current_size = 0;
			while($query->have_posts()){
				$query->the_post();
				global $post;
				$EM_Events = EM_Events::get( array('scope'=>'all') );
				foreach($EM_Events as $event){
					$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');					
					$event_post_data = json_decode(kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true)));
					if($event_post_data->select_team_first == $post->ID || $event_post_data->select_team_second == $post->ID){
						$team_exist[] = $post->ID;
					}
				}
			}
			//remove Duplicate Values
			return array_unique($team_exist);
		}
	}
	
	//get all the teams who played in an event
	if( !function_exists('kode_get_winner_all_matches_id') ){
		function kode_get_winner_all_matches_id(  ){
			$winner_all_matches = array();
			$args = array('post_type' => 'team', 'suppress_filters' => false);
			$args['posts_per_page'] = -1;;
			$args['orderby'] = 'post_date';
			
			$args['order'] = 'desc';
			$query = new WP_Query( $args );			
			$current_size = 0;
			while($query->have_posts()){
				$query->the_post();
				global $post;
				$winner_id = kode_get_result_win_team( $post->ID );
				if(is_numeric($winner_id)){
					if($winner_id == $post->ID){
						$winner_all_matches[] = $post->ID;
					}
				}else{
					$winner_all_matches[] = $winner_id;
				}
			}
			
			//remove Duplicate Values
			return $winner_all_matches;
		}
	}
	
	
	
	//get all the teams who played in an event
	if( !function_exists('kode_get_result_win_team') ){
		function kode_get_result_win_team( $team_id ){
			$result = '';
			$EM_Events = EM_Events::get( array('scope'=>'all') );
			foreach($EM_Events as $event){
				$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');					
				$event_post_data = json_decode(kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true)));
				if(isset($team_id)){
					if($event_post_data->select_team_first == $team_id || $event_post_data->select_team_second == $team_id){
						$first_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_first, 'post-option', true)));
						$second_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_second, 'post-option', true)));
						if(isset($event_post_data->goal_scored_team_first) || isset($event_post_data->goal_scored_team_second)){
							if($event_post_data->goal_scored_team_first < $event_post_data->goal_scored_team_second){
								$result =	$event_post_data->select_team_first;
							}else if($event_post_data->goal_scored_team_first == $event_post_data->goal_scored_team_second){
								$result =	'draw';	
							}else if($event_post_data->goal_scored_team_first > $event_post_data->goal_scored_team_second){
								$result =	$event_post_data->select_team_first;	
							}else{
								$result =	'match in process';
							}
						}else{
							$result =	'match is yet to be played';
						}
					}else{
						$result =	'no match found';
					}
				}else{
					$result =	'no match found';
				}
			}
			
			return $result;
			
		}
	}	
	
	
	//get all the teams who played in an event
	if( !function_exists('kode_get_result_team_won') ){
		function kode_get_result_team_won( $team_id, $result ){
			$match_result = array();
			$kode_events = EM_Events::get( array('scope'=>'past') );
			foreach($kode_events as $event_sec){
				$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');					
				$event_post_data = kode_decode_stopbackslashes(get_post_meta($event_sec->post_id, 'post-option', true));
				if(is_array($event_post_data)){
					$event_post_data= implode($event_post_data,",");
				}
				$event_post_data = json_decode($event_post_data);
				
				if(isset($team_id)){
					$first_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_first, 'post-option', true)));
					$second_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_second, 'post-option', true)));
					
					if($result == 'won'){
						
						if($event_post_data->select_team_first == $team_id){	
							if((int)$event_post_data->goal_scored_team_first > (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_first;
								
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_second;
							}						
						}else if($event_post_data->select_team_second == $team_id){
							if((int)$event_post_data->goal_scored_team_first < (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_second;
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_first;

							}						
						}						
					}else if($result == 'loss'){
						if($event_post_data->select_team_first == $team_id){							
							if((int)$event_post_data->goal_scored_team_first < (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_first;
								
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_second;
							}						
							
						}else if($event_post_data->select_team_second == $team_id){
							if((int)$event_post_data->goal_scored_team_first > (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_second;
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_first;

							}						
						}
						
					}else if($result == 'draw'){
						
						if($event_post_data->select_team_first == $team_id){							
							if((int)$event_post_data->goal_scored_team_first == (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_first;
								
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_second;
							}						
						}else if($event_post_data->select_team_second == $team_id){
							if((int)$event_post_data->goal_scored_team_first == (int)$event_post_data->goal_scored_team_second){
								$match_result['select_team'][] =	$event_post_data->select_team_second;
								$match_result['goal_scored_team'][] =	$event_post_data->goal_scored_team_second;
								$match_result['total_shots_team'][] =	$event_post_data->total_shots_team_second;
								$match_result['shorts_on_targets_team'][] =	$event_post_data->shorts_on_targets_team_second;
								$match_result['ball_possession_team'][] =	$event_post_data->ball_possession_team_second;
								$match_result['corner_kicks_team'][] =	$event_post_data->corner_kicks_team_second;
								$match_result['fouls_committed_team'][] =	$event_post_data->fouls_committed_team_second;
								$match_result['offsides_team'][] =	$event_post_data->offsides_team_second;
								$match_result['saves_team'][] =	$event_post_data->saves_team_second;
								$match_result['yellow_cards_team'][] =	$event_post_data->yellow_cards_team_second;
								$match_result['red_cards_team'][] =	$event_post_data->red_cards_team_second;
								
								$match_result['select_team_opp'][] =	$event_post_data->select_team_first;
								$match_result['goal_scored_team_opp'][] =	$event_post_data->goal_scored_team_first;
								$match_result['total_shots_team_opp'][] =	$event_post_data->total_shots_team_first;
								$match_result['shorts_on_targets_team_opp'][] =	$event_post_data->shorts_on_targets_team_first;
								$match_result['ball_possession_team_opp'][] =	$event_post_data->ball_possession_team_first;
								$match_result['corner_kicks_team_opp'][] =	$event_post_data->corner_kicks_team_first;
								$match_result['fouls_committed_team_opp'][] =	$event_post_data->fouls_committed_team_first;
								$match_result['offsides_team_opp'][] =	$event_post_data->offsides_team_first;
								$match_result['saves_team_opp'][] =	$event_post_data->saves_team_first;
								$match_result['yellow_cards_team_opp'][] =	$event_post_data->yellow_cards_team_first;
								$match_result['red_cards_team_opp'][] =	$event_post_data->red_cards_team_first;
							}
						}									
					}

				}else{
					$match_result[] = 'no match found';
				}
			}	
			if(!empty($match_result)){
				return $match_result;	
			}else{
				$match_result['team_id'][] =	array();
				$match_result['score'][] =	array();
				$match_result['opp_team_id'][] =	array();
				$match_result['opp_score'][] =	array();
				
			}
			
		}
	}	
	
	
	// print_R(kode_get_winner_all_matches_id());
	
	// print_R(kode_get_result_win_team(33));
	
	
	//Event Listing
	if( !function_exists('kode_get_events_item') ){
		function kode_get_events_item( $settings ){
			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
			$evn = '';
			$order = 'DESC';
			$limit = 10;//Default limit
			$offset = '';		
			$rowno = 0;
			$event_count = 0;
			
			$argu = array('pagination'=>1,'category'=>$settings['category'], 'group'=>'this','scope'=>$settings['scope'], 'limit' => $settings['num-fetch'], 'order' => $settings['order']);
			$argu['page'] = (!empty($_REQUEST['pno']) && is_numeric($_REQUEST['pno']) )? $_REQUEST['pno'] : 1;
			$query_events = EM_Events::get( $argu );
			$events_count = EM_Events:: count( $argu );	
			
			$current_size = 0;
			$size = 1;
			// $evn = '<div class="event-listing">';
			
			if($settings['event-style'] == 'event-grid-view'){
				$size = 3;
				$evn = '<div '.$margin_style.' class="event-listing event-grid-view row">';
			}else if($settings['event-style'] == 'event-grid-modern'){
				$size = 3;
				$evn = '<div '.$margin_style.' class="kode-result-list shape-view">';
			}else if($settings['event-style'] == 'event-grid-rugby'){
				$size = 3;
				$evn = '<div '.$margin_style.' class="kode-result-rugby col-md-12">';
			}else if($settings['event-style'] == 'event-grid-simple'){
				$size = 1;
				$evn .= '<div '.$margin_style.' class="match-listing"><table class="kode-table">
                    <thead>
                      <tr>
                        <th>'.__('Upcoming Match','kickoff').'</th>
                        <th>'.__('Date','kickoff').'</th>
                        <th>'.__('Venue','kickoff').'</th>
						<th class="kode-booking">'.__('Booking','kickoff').'</th>
                      </tr>
                    </thead>
                    <tbody>';
			}else{
				$size = 3;
				$evn = '<div '.$margin_style.' class="kode-result-list shape-view">';
			}
			$team_first_result = '';
			$team_second_result = '';
			$total_matches = 0;
			$settings['title-num-excerpt'] = (empty($settings['title-num-excerpt']))? '15': $settings['title-num-excerpt'];
			$modern_layout = $settings['event-style'];
			foreach ( $query_events as $event ) {
				$event_year = date('Y',$event->start);
				$event_month = date('m',$event->start);
				$event_day = date('d',$event->start);
				$event_start_time = date("G,i,s", strtotime($event->start_time));
				if(!empty($event->get_location()->name)){
					$location = esc_attr($event->get_location()->name);
				}
				
				$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
				if(is_array($event_post_data)){
					$event_post_data= implode($event_post_data,",");
				}
				if( !empty($event_post_data)){
					$event_post_data = json_decode( $event_post_data, true );				
				}

				
				$team_win_result = kode_get_result_team_won($event_post_data['select_team_second'], 'won');
				$team_lost_result = kode_get_result_team_won($event_post_data['select_team_second'], 'loss');
				$team_draw_result = kode_get_result_team_won($event_post_data['select_team_second'], 'draw');
				
				if(empty($team_lost_result['goal_scored_team'])){
					$total_goals = $team_win_result['goal_scored_team'];
					if(empty($total_goals)){
						$total_goals = array();
						$total_goals = array_sum($total_goals);	
					}else{
						$total_goals = array_sum($total_goals);	
					}
				}else if(empty($team_win_result['goal_scored_team'])){
					$total_goals = $team_lost_result['goal_scored_team'];
					$total_goals = array_sum($total_goals);
				}else{
					$total_goals = array_merge($team_lost_result['goal_scored_team'],$team_win_result['goal_scored_team']);
					$total_goals = array_sum($total_goals);
				}
				
				if(!empty($team_lost_result['select_team'])){
					$team_loss = count($team_lost_result['select_team']);
				}else{
					$team_loss = 0;
				}
				
				if(!empty($team_win_result['select_team'])){
					$team_won = count($team_win_result['select_team']);
				}else{
					$team_won = 0;
				}
				
				if(!empty($team_draw_result['select_team'])){
					$team_draw = count($team_draw_result['select_team']);
				}else{
					$team_draw = 0;
				}
				if(empty($team_draw_result['select_team'])){
					if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];	
					}else if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];	
					}else{
						$total_matches = array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}else if(empty($team_lost_result['select_team'])){
					if(empty($team_draw_result['select_team'])){
						$total_matches = $team_win_result['select_team'];	
					}else if(empty($team_win_result['select_team'])){
						$total_matches = $team_draw_result['select_team'];	
					}else{
						$total_matches = array_merge($team_draw_result['select_team'],$team_win_result['select_team']);	
					}
				}else if(empty($team_win_result['select_team'])){
					$total_matches = array_merge($team_draw_result['select_team'],$team_lost_result['select_team']);	
				}else{
					$total_matches = array_merge($team_draw_result['select_team'], $team_lost_result['select_team'],$team_win_result['select_team']);	
				}
				if(!empty($total_matches)){
					$total_matches = count($total_matches);
				}
				$formulla = 4/4.0*0+2*$team_won/2*$total_matches;
				
				$kode_team_option_first = kode_decode_stopbackslashes(get_post_meta($event_post_data['select_team_first'], 'post-option', true ));
				if( !empty($kode_team_option_first) ){
					$kode_team_option_first = json_decode( $kode_team_option_first, true );					
				}
				$kode_team_option_second = kode_decode_stopbackslashes(get_post_meta($event_post_data['select_team_second'], 'post-option', true ));
				if( !empty($kode_team_option_second) ){
					$kode_team_option_second = json_decode( $kode_team_option_second, true );					
				}
				$team_first_img = '';
				$team_second_img = '';
				if(!empty($kode_team_option_first['team_logo'])){
					$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
				}
				if(!empty($kode_team_option_second['team_logo'])){
					$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
				}
				
				if($modern_layout == 'event-full-view'){
					if(isset($event_post_data['goal_scored_team_first']) && isset($event_post_data['goal_scored_team_second'])){
						if((int)$event_post_data['goal_scored_team_first'] < (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'loss';
							$team_second_result = 'win';
						}else if((int)$event_post_data['goal_scored_team_first'] > (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'win';
							$team_second_result = 'loss';
						}else if((int)$event_post_data['goal_scored_team_first'] == (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'draw';
							$team_second_result = 'draw';
						}else{}
					}else{
						$event_post_data['goal_scored_team_first'] = 0;
						$event_post_data['goal_scored_team_second'] = 0;
						
					}
					$loc = '';
					if(isset($event->get_location()->location_address)){
						$location = esc_attr($event->get_location()->location_address);	
						if($location <> ''){
							$loc = $location;			
						}
					}else{
						$loc = '';				
					}
					$evn .= '
					<div class="kode-inner-fixer">
						<div class="kode-team-match">
							<ul>
								<li>
									<a href="'.esc_url(get_permalink($event_post_data['select_team_first'])).'">';
									if(!empty($kode_team_option_first['team_logo'])){
										$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
										$evn .= '<img alt="" src="'.esc_url($team_first_img[0]).'">';
									}
									$evn .= '
									</a>
								</li>
								<li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="'.esc_url($event->guid).'">'.esc_html__('vs','kickoff').'</a></li>
								<li>
									<a href="'.esc_url(get_permalink($event_post_data['select_team_second'])).'">';
									if(!empty($kode_team_option_second['team_logo'])){
										$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
										$evn .= '<img alt="" src="'.esc_url($team_second_img[0]).'">';
									}
									$evn .= '
									</a>
								</li>
							</ul>
							<div class="clearfix"></div>
							<h3><a href="'.esc_url($event->guid).'">'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,$settings['title-num-excerpt'])).' VS '.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,$settings['title-num-excerpt'])).'</a></h3>
							<span class="kode-subtitle">'.esc_html__('Match Between Both Big Teams Starts','kickoff').' <br>'.esc_attr(date('D M d Y',$event->start)).' '.esc_attr($event->start_time).' '.esc_attr($loc).'</span>
						</div>
					</div>					
					';				
				}else if($modern_layout == 'event-grid-modern'){
					if(isset($event_post_data['goal_scored_team_first']) && isset($event_post_data['goal_scored_team_second'])){
						if((int)$event_post_data['goal_scored_team_first'] < (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'loss';
							$team_second_result = 'win';
						}else if((int)$event_post_data['goal_scored_team_first'] > (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'win';
							$team_second_result = 'loss';
						}else if((int)$event_post_data['goal_scored_team_first'] == (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'draw';
							$team_second_result = 'draw';
						}else{}
					}else{
						$event_post_data['goal_scored_team_first'] = 0;
						$event_post_data['goal_scored_team_second'] = 0;
						
					}
					$evn .= '
					<div class="row margin-bottom-top-50">
						<div class="col-md-6">
							<article>
								<span class="kode-result-count thbg-colortwo">'.esc_attr($event_post_data['goal_scored_team_first']).'</span>
								<div class="kode-result-thumb">
									<a href="'.esc_url(get_permalink($event_post_data['select_team_first'])).'">';
										if(!empty($kode_team_option_first['team_logo'])){
											$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
											$evn .= '<img alt="" src="'.esc_url($team_first_img[0]).'">';
										}
										$evn .= '
									</a>
								</div>
								<div class="kode-result-info">
									<h2><a href="'.esc_url(get_permalink($event_post_data['select_team_first'])).'">'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,$settings['title-num-excerpt'])).'</a> <span>'.$team_first_result.'</span></h2>
									<ul>';
									$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
									$all_team_posts = get_posts($arguments_team);									
									foreach($all_team_posts as $all_team_post){
										$kode_player = '';
										if(isset($event_post_data['team_lineup_first-player-'.esc_attr($all_team_post->ID)])){
											$kode_player = $event_post_data['team_lineup_first-player-'.esc_attr($all_team_post->ID)];	
										}
										if($kode_player == 'enable'){
											$kode_player_goal = '';
											if(isset($event_post_data['team_lineup_first-pg-'.esc_attr($all_team_post->ID)])){
												$kode_player_goal = $event_post_data['team_lineup_first-pg-'.esc_attr($all_team_post->ID)];	
											}
											
											if($kode_player_goal == '' || $kode_player_goal == ' '){
												$kode_player_goal = 0;
											}
											$evn .= '<li><a href="'.esc_url(get_permalink($all_team_post->ID)).'">'.esc_attr(get_the_title($all_team_post->ID)).' <span>('.esc_attr($kode_player_goal).')</span></a></li>';
										}
									}
									$evn .= '
									</ul>
								</div>
							</article>
						</div>
						<div class="col-md-6">
							<article class="kode-even">
								<span class="kode-result-count thbg-colortwo">'.$event_post_data['goal_scored_team_second'].'</span>
								<div class="kode-result-thumb">
									<a href="'.esc_url(get_permalink($event_post_data['select_team_second'])).'">';
									
									if(!empty($kode_team_option_second['team_logo'])){
										$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
										$evn .= '<img alt="'.esc_attr(get_the_title($event_post_data['select_team_second'])).'" src="'.esc_url($team_second_img[0]).'">';
									}
									$evn .= '	
									</a>
								</div>
								<div class="kode-result-info">
									<h2><a href="'.esc_url(get_permalink($event_post_data['select_team_second'])).'">'.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,$settings['title-num-excerpt'])).'</a> <span>'.$team_second_result.'</span></h2>
									<ul>';
									$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
									$all_team_posts = get_posts($arguments_team);									
									foreach($all_team_posts as $all_team_post){
										$kode_player = '';
										if(isset($event_post_data['team_lineup_second-player-'.esc_attr($all_team_post->ID)])){
											$kode_player = $event_post_data['team_lineup_second-player-'.esc_attr($all_team_post->ID)];	
										}
										if($kode_player == 'enable'){
											$kode_player_goal = '';
											if(isset($event_post_data['team_lineup_second-pg-'.esc_attr($all_team_post->ID)])){
												$kode_player_goal = $event_post_data['team_lineup_second-pg-'.esc_attr($all_team_post->ID)];	
											}
											
											if($kode_player_goal == '' || $kode_player_goal == ' '){
												$kode_player_goal = 0;
											}
											$evn .= '<li><a href="'.esc_url(get_permalink($all_team_post->ID)).'">'.esc_attr(get_the_title($all_team_post->ID)).' <span>('.esc_attr($kode_player_goal).')</span></a></li>';
										}
									}
									$evn .= '
									</ul>
								</div>
							</article>
						</div>
					</div>';
				}else if($modern_layout == 'event-grid-simple'){				
					$loc = '';
					$start_time = date(get_option('time_format'),strtotime($event->start_time));
					$end_time = date(get_option('time_format'),strtotime($event->end_time));
					if($event->event_all_day <> 1){ 
						$start_time = esc_attr($start_time);						
						$end_time = esc_attr($end_time); 
					}else{
						esc_html__('All Day','kickoff'); 
						$start_time = '12:00 am'; 
						$end_time = '12:00 pm'; 
					} 
					if(isset($event->get_location()->location_address)){
						$location = esc_attr($event->get_location()->location_address);	
						if($location <> ''){
							$loc = $location;			
						}
					}else{
						$loc = '';				
					}
					
					$evn .= '					
                      <tr>
                        <td><a href="'.esc_url($event->guid).'">'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,$settings['title-num-excerpt'])).' <span>VS</span>'.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,$settings['title-num-excerpt'])).'</a></td>
                        <td>'.esc_attr(date('Y, D, d, M',$event->start)).'  '.esc_attr($start_time).' '.esc_attr($end_time).'</td>
                        <td>'.esc_attr($loc).'</td>
						<td class="kode-booking">'.kode_event_booking_btn($event).'</td>
                      </tr>
                    ';
				}else if($modern_layout == 'event-grid-rugby'){				
					if(isset($event_post_data['goal_scored_team_first']) && isset($event_post_data['goal_scored_team_second'])){
						if((int)$event_post_data['goal_scored_team_first'] < (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'loss';
							$team_second_result = 'win';
						}else if((int)$event_post_data['goal_scored_team_first'] > (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'win';
							$team_second_result = 'loss';
						}else if((int)$event_post_data['goal_scored_team_first'] == (int)$event_post_data['goal_scored_team_second']){
							$team_first_result = 'draw';
							$team_second_result = 'draw';
						}else{}
					}else{
						$event_post_data['goal_scored_team_first'] = 0;
						$event_post_data['goal_scored_team_second'] = 0;
						
					}
					$loc = '';
					if(isset($event->get_location()->location_address)){
						$location = esc_attr($event->get_location()->location_address);	
						if($location <> ''){
							$loc = $location;			
						}
					}else{
						$loc = '';				
					}
					$loc = '';
					$start_time = date(get_option('time_format'),strtotime($event->start_time));
					$end_time = date(get_option('time_format'),strtotime($event->end_time));
					if($event->event_all_day <> 1){ 
						$start_time = esc_attr($start_time);						
						$end_time = esc_attr($end_time); 
					}else{
						esc_html__('All Day','kickoff'); 
						$start_time = '12:00 am'; 
						$end_time = '12:00 pm'; 
					} 
					if(isset($event->get_location()->location_address)){
						$location = esc_attr($event->get_location()->location_address);	
						if($location <> ''){
							$loc = $location;			
						}
					}else{
						$loc = '';				
					}
					
					$evn .= '
					<div class="kode_football_latest_champion">
						<h5>'.esc_attr($event->post_title).'</h5>
						<ul>
							<li>'.esc_attr(date('D M d Y',$event->start)).'</li>
							<li>'.esc_attr($event->start_time).'</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="kode_football_latest_win">
								<div class="kode_football_latest_eangle">
									<h6>'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,$settings['title-num-excerpt'])).'</h6>
									<span>'.esc_attr($team_first_result).'</span>
								</div>
								<div class="kode_football_latest_fig">
									<figure>
										<a href="'.esc_url(get_permalink($event_post_data['select_team_first'])).'">';
										if(!empty($kode_team_option_first['team_logo'])){
											$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
											$evn .= '<img alt="image" src="'.esc_url($team_first_img[0]).'">';
										}
										$evn .= '
										</a>
									</figure>
								</div>
								<div class="kode_football_latest_run">
									<span>'.esc_attr($event_post_data['goal_scored_team_first']).'</span>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="kode_football_latest_compition">
								<a href="'.esc_url($event->guid).'">'.esc_html__('VS','kickoff').'</a>
							</div>
						</div>
						<div class="col-md-5">
							<div class="kode_football_latest_win right-side-content">
								<div class="kode_football_latest_run">
									<span>'.esc_attr($event_post_data['goal_scored_team_second']).'</span>
								</div>
								<div class="kode_football_latest_fig">
									<figure>
										<a href="'.esc_url(get_permalink($event_post_data['select_team_second'])).'">';
										if(!empty($kode_team_option_second['team_logo'])){
											$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
											$evn .= '<img alt="'.esc_attr(get_the_title($event_post_data['select_team_second'])).'" src="'.esc_url($team_second_img[0]).'">';
										}
										$evn .= '
										</a>
									</figure>
								</div>
								<div class="kode_football_latest_eangle">
									<h6>'.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,$settings['title-num-excerpt'])).'</h6>
									<span>'.esc_attr($team_second_result).'</span>
								</div>
							</div>
						</div>
					</div>
					';
				}
				$current_size++;
			}
			if($modern_layout == 'event-grid-simple'){
			$evn .= '</tbody>
                 </table></div>';
			}else{
				$evn .= '</div>';	
			}
			if( $settings['pagination'] == 'enable' ){
				$evn .= '<div class="kode-pagination col-md-12">';
				$evn .= EM_Events::get_pagination_links($argu, $events_count);
				$evn .= '</div>';
			}
			wp_reset_postdata();
			wp_reset_query();
			
		return $evn;
		}
	}
	
	function kode_get_upcoming_event_item($settings = array()){
		
		$evn = '';
		$order = 'DESC';
		$limit = 10;//Default limit
		$offset = '';		
		$rowno = 0;
		$event_count = 0;
		$custom_events = EM_Events::get( array('category'=>$settings['category'], 'group'=>'this','scope'=>'future', 'limit' => 1, 'order' => 'ASC') );
		$events_count = count ( $custom_events );	
		$current_size = 0;
		$size = 1;
		$start_time = '12:00';
		$end_time = '12:00';
		$evn = '<div class="kode-inner-fixer-fc">';
		foreach ( $custom_events as $k_event ) {
			
			if($k_event->event_all_day <> 1){
				$start_time = $k_event->start_time;
				$end_time = $k_event->end_time;
			}else{

				$start_time = '12:00';
				$end_time = '12:00';
				
			}
			$event_year = date('Y',$k_event->start);
			$event_month = date('m',$k_event->start);
			$event_day = date('d',$k_event->start);
			// print_r($k_event->start_time);
			$event_start_time = date("G,i,s", strtotime($start_time));
			if(!empty($k_event->get_location()->name)){
				$location = esc_attr($k_event->get_location()->name);
			}else{
				$location = '';
			}
			
			$event_post_data = kode_decode_stopbackslashes(get_post_meta($k_event->post_id, 'post-option', true ));
			if( !empty($event_post_data) ){
				$event_post_data = json_decode( $event_post_data, true );					
			}
			$kode_team_option_first = kode_decode_stopbackslashes(get_post_meta($event_post_data['select_team_first'], 'post-option', true ));
			if( !empty($kode_team_option_first) ){
				$kode_team_option_first = json_decode( $kode_team_option_first, true );					
			}
			
			$kode_team_option_second = kode_decode_stopbackslashes(get_post_meta($event_post_data['select_team_second'], 'post-option', true ));
			if( !empty($kode_team_option_second) ){
				$kode_team_option_second = json_decode( $kode_team_option_second, true );					
			}
			
			$team_first_img = '';
			$team_second_img = '';
			if(!empty($kode_team_option_first['team_logo'])){
				$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
			}
			if(!empty($kode_team_option_second['team_logo'])){
				$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
			}
			$loc = '';
			if(isset($k_event->get_location()->location_address)){
				$location = esc_attr($k_event->get_location()->location_address);	
				if($location <> ''){
					$loc = $location;			
				}
			}else{
				$loc = '';				
			}
			$evn .= '
			<div class="kode-fixer-counter">
				<div class="countdown_label" 
				data-label-year="'.esc_html__('Year','kickoff').'"
				data-label-month="'.esc_html__('Month','kickoff').'"
				data-label-week="'.esc_html__('Week','kickoff').'"
				data-label-day="'.esc_html__('Days','kickoff').'"
				data-label-min="'.esc_html__('Minutes','kickoff').'"
				data-label-hour="'.esc_html__('Hours','kickoff').'"
				data-label-sec="'.esc_html__('Seconds','kickoff').'"
				data-year="'.esc_attr($event_year).'" 
				data-month="'.esc_attr($event_month).'" 
				data-day="'.esc_attr($event_day).'" 
				data-time="'.esc_attr($event_start_time).'" 
				id="defaultCountdown-'.esc_attr($k_event->post_id).'"
				></div>
			</div>      
			<div class="kode-team-match">
				<ul>
					<li>
						<a href="'.esc_url(get_permalink($event_post_data['select_team_first'])).'">';
						if(!empty($kode_team_option_first['team_logo'])){
							$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
							$evn .= '<img alt="" src="'.esc_url($team_first_img[0]).'">';
						}
						$evn .= '
						</a>
					</li>
					<li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="'.esc_url($k_event->guid).'">'.esc_html__('vs','kickoff').'</a></li>
					<li>
					<a href="'.esc_url(get_permalink($event_post_data['select_team_second'])).'">';
					if(!empty($kode_team_option_second['team_logo'])){
						$team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
						$evn .= '<img alt="" src="'.esc_url($team_second_img[0]).'">';
					}
					$evn .= '
					</a>
					</li>
				</ul>
				<div class="clearfix"></div>
				<h3><a href="'.esc_url($k_event->guid).'">'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,20)).' VS '.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,20)).'</a></h3>
				<span class="kode-subtitle">'.esc_html__('Match Between Both Big Teams Starts','kickoff').' <br>'.esc_attr(date_i18n('D M d Y',$k_event->start)).' '.esc_attr($k_event->start_time).' '.esc_attr($loc).'</span>
			</div>';

		}
		
		$evn .= '</div>';
		
		return $evn;

		
	}
	
	//Event participated, values of team one and team two kode_post_option , $event_array , first of second
	function kode_print_team_fixture_detail($event_participated,$kode_post_option,$formation){
		foreach($event_participated as $parti_event){
			$args = array('orderby' => 'name', 'order' => 'DESC', 'fields' => 'all');
			$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
			
			$event_post_data = json_decode(kode_decode_stopbackslashes(get_post_meta($parti_event, 'post-option', true)));
			if($formation == 'second'){
				$team_win_result = kode_get_result_team_won($event_post_data->select_team_second, 'won');
				$team_lost_result = kode_get_result_team_won($event_post_data->select_team_second, 'loss');
				$team_draw_result = kode_get_result_team_won($event_post_data->select_team_second, 'draw');
			}else{
				$team_win_result = kode_get_result_team_won($event_post_data->select_team_first, 'won');
				$team_lost_result = kode_get_result_team_won($event_post_data->select_team_first, 'loss');
				$team_draw_result = kode_get_result_team_won($event_post_data->select_team_first, 'draw');
			}
			$event_date = get_post_meta($parti_event,'event_start_date',true);
			
			$first_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_first, 'post-option', true)));
			$second_team = json_decode(kode_decode_stopbackslashes(get_post_meta($event_post_data->select_team_second, 'post-option', true)));
			$current_team = '';
			
			if($formation == 'first'){
				if($kode_post_option['select_team_first'] == $event_post_data->select_team_first){
					$current_team = $event_post_data->select_team_second;
					$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
						foreach($get_categories as $category){
							if(strtotime($event_date) < strtotime(date('Y-m-d'))) { ?>
								<tr>
									<td class="league-name-first"><?php echo esc_attr($category->name);?></td>
									<td class="league-team-first"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
									<td class="league-team-score-first"><?php echo esc_attr($event_post_data->goal_scored_team_first);?></td>
									<td class="league-team-target-first"><?php echo esc_attr($event_post_data->shorts_on_targets_team_first);?></td>
									<td class="league-team-ck-first"><?php echo esc_attr($event_post_data->corner_kicks_team_first);?></td>
									<td class="league-team-rc-first"><?php echo esc_attr($event_post_data->red_cards_team_first);?></td>
									<td class="league-possession-first"><?php echo esc_attr($event_post_data->ball_possession_team_first);?>%</td>
								</tr>
							<?php }else{ ?>
								<tr>
									<td class="league-name-first"><?php echo esc_attr($category->name);?></td>
									<td class="league-team-first"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
									<td class="league-team-score-first"><?php echo esc_attr($event_post_data->goal_scored_team_first);?></td>
									<td class="league-team-target-first"><?php echo esc_attr($event_post_data->shorts_on_targets_team_first);?></td>
									<td class="league-team-ck-first"><?php echo esc_attr($event_post_data->corner_kicks_team_first);?></td>
									<td class="league-team-rc-first"><?php echo esc_attr($event_post_data->red_cards_team_first);?></td>
									<td class="league-possession-first"><?php echo esc_attr($event_post_data->ball_possession_team_first);?>%</td>
								</tr>
								<?php
								}
						}
				}else if($kode_post_option['select_team_first'] == $event_post_data->select_team_second){
					$current_team = $event_post_data->select_team_first;
					$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
					foreach($get_categories as $category){
						if(strtotime($event_date) < strtotime(date('Y-m-d'))) { ?>
							<tr>
								<td class="league-name-second"><?php echo esc_attr($category->name);?></td>
								<td class="league-team-second"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-team-score-second"><?php echo esc_attr($event_post_data->goal_scored_team_second);?></td>
								<td class="league-team-target-second"><?php echo esc_attr($event_post_data->shorts_on_targets_team_second);?></td>
								<td class="league-team-ck-second"><?php echo esc_attr($event_post_data->corner_kicks_team_second);?></td>
								<td class="league-team-rc-second"><?php echo esc_attr($event_post_data->red_cards_team_second);?></td>
								<td class="league-possession-second"><?php echo esc_attr($event_post_data->ball_possession_team_second);?>%</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="league-name-second"><?php echo esc_attr($category->name);?></td>
								<td class="league-name-second"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-name-score-second"><?php echo esc_attr($event_post_data->goal_scored_team_second);?></td>
								<td class="league-name-target-second"><?php echo esc_attr($event_post_data->shorts_on_targets_team_second);?></td>
								<td class="league-name-ck-second"><?php echo esc_attr($event_post_data->corner_kicks_team_second);?></td>
								<td class="league-name-ck-second"><?php echo esc_attr($event_post_data->red_cards_team_second);?></td>
								<td class="league-possession-second"><?php echo esc_attr($event_post_data->ball_possession_team_second);?>%</td>
							</tr>
							<?php
							}
					}
				}
				
			}else{
				if($kode_post_option['select_team_second'] == $event_post_data->select_team_second){
					$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
					$current_team = $event_post_data->select_team_first;
					foreach($get_categories as $category){
						if(strtotime($event_date) < strtotime(date('Y-m-d'))) { ?>
							<tr>
								<td class="league-name-second"><?php echo esc_attr($category->name);?></td>
								<td class="league-team-second"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-team-score-second"><?php echo esc_attr($event_post_data->goal_scored_team_second);?></td>
								<td class="league-team-target-second"><?php echo esc_attr($event_post_data->shorts_on_targets_team_second);?></td>
								<td class="league-team-ck-second"><?php echo esc_attr($event_post_data->corner_kicks_team_second);?></td>
								<td class="league-team-rc-second"><?php echo esc_attr($event_post_data->red_cards_team_second);?></td>
								<td class="league-possession-second"><?php echo esc_attr($event_post_data->ball_possession_team_second);?>%</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="league-name-second"><?php echo esc_attr($category->name);?></td>
								<td class="league-team-second"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-team-score-second"><?php echo esc_attr($event_post_data->goal_scored_team_second);?></td>
								<td class="league-team-target-second"><?php echo esc_attr($event_post_data->shorts_on_targets_team_second);?></td>
								<td class="league-team-ck-second"><?php echo esc_attr($event_post_data->corner_kicks_team_second);?></td>
								<td class="league-team-rc-second"><?php echo esc_attr($event_post_data->red_cards_team_second);?></td>
								<td class="league-possession-second"><?php echo esc_attr($event_post_data->ball_possession_team_second);?>%</td>
							</tr>
							<?php
							}
					}
					
					
				}else if($kode_post_option['select_team_second'] == $event_post_data->select_team_first){
					$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
					$current_team = $event_post_data->select_team_second;
					foreach($get_categories as $category){
						if(strtotime($event_date) < strtotime(date('Y-m-d'))) { ?>
							<tr>
								<td class="league-name-first"><?php echo esc_attr($category->name);?></td>
								<td class="league-team-first"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-team-score-first"><?php echo esc_attr($event_post_data->goal_scored_team_first);?></td>
								<td class="league-team-target-first"><?php echo esc_attr($event_post_data->shorts_on_targets_team_first);?></td>
								<td class="league-team-ck-first"><?php echo esc_attr($event_post_data->corner_kicks_team_first);?></td>
								<td class="league-team-rc-first"><?php echo esc_attr($event_post_data->red_cards_team_first);?></td>
								<td class="league-possession-first"><?php echo esc_attr($event_post_data->ball_possession_team_first);?>%</td>
							</tr>
						<?php }else{ ?>
							<tr>
								<td class="league-name-first"><?php echo esc_attr($category->name);?></td>
								<td class="league-team-first"><a href="<?php echo get_permalink($current_team);?>"><?php echo get_the_title($current_team);?></a></td>
								<td class="league-team-score-first"><?php echo esc_attr($event_post_data->goal_scored_team_first);?></td>
								<td class="league-team-target-first"><?php echo esc_attr($event_post_data->shorts_on_targets_team_first);?></td>
								<td class="league-team-ck-first"><?php echo esc_attr($event_post_data->corner_kicks_team_first);?></td>
								<td class="league-team-rc-first"><?php echo esc_attr($event_post_data->red_cards_team_first);?></td>
								<td class="league-possession-first"><?php echo esc_attr($event_post_data->ball_possession_team_first);?>%</td>
							</tr>
							<?php
							}
					}
					
					
				}
			}
		}
	}
	
	if(!function_exists('kode_get_next_match_item')){
		function kode_get_next_match_item($settings = array()){
			$evn = '';
			$order = 'DESC';
			$limit = 10;//Default limit
			$offset = '';		
			$rowno = 0;
			$event_count = 0;
			$EM_Events = EM_Events::get( array('category'=>$settings['category'], 'group'=>'this','scope'=>'future', 'limit' => 1, 'order' => 'ASC' ));
			$events_count = count ( $EM_Events );	
			$current_size = 0;
			$size = 1;
			$pattern_image = (empty($settings['player-left-image']))? '': $settings['player-left-image'];
			// $args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			$pattern_image = wp_get_attachment_image_src($pattern_image, 'full');
			$html_event = '
			<!--kode_football_match_wraper start-->
			<div class="kode_football_match_wraper">
				<!--kode_football_match_fig start-->
				<div class="kode_football_match_fig">
					<figure>
						<img src="'.esc_url($pattern_image[0]).'" alt="image">
					</figure>
				</div>
				<!--kode_football_match_fig end-->';
				foreach($EM_Events as $event){
					if($event->event_all_day <> 1){
						$start_time = $event->start_time;
						$end_time = $event->end_time;
					}else{

						$start_time = '12:00';
						$end_time = '12:00';
						
					}
					$event_year = date('Y',$event->start);
					$event_month = date('m',$event->start);
					$event_day = date('d',$event->start);
					// print_r($event->start_time);
					$event_start_time = date("G,i,s", strtotime($start_time));
					$html_event .= '
					<!--kode_football_matck_counter start-->
					<div class="kode_football_matck_counter">
						<!--kode_football_latest_heading start-->
						<div class="kode_football_latest_heading heading_2">
							<h2>'.esc_attr('Next','kickoff').' <span>'.esc_attr('Match','kickoff').'</span></h2>
							<strong><i class="fa icon-person"></i><b></b></strong>
						</div>
						<!--kode_football_latest_heading end-->
						<!--COUNTDOWN START-->
						<ul class="kode_countdown" data-year="'.esc_attr($event_year).'" data-month="'.esc_attr($event_month).'" data-day="'.esc_attr($event_day).'" data-time="'.esc_attr($event_start_time).'">
							<li>
								<span class="days">00</span>
								<h5 class="">'.esc_attr('Days','kickoff').'</h5>
							</li>
							<li>
								<span class="hours">00</span>
								<h5 class="">'.esc_attr('Hours','kickoff').'</h5>
							</li>
							<li>
								<span class="minutes">00</span>
								<h5 class="">'.esc_attr('Minutes','kickoff').'</h5>
							</li>
							<li>
								<span class="seconds">00</span>
								<h5 class="">'.esc_attr('Seconds','kickoff').'</h5>
							</li>
						</ul>
						<!--COUNTDOWN END-->
						<div class="kode_football_latest_view">
							<a href="#">'.esc_attr('View All','kickoff').'</a>
							<a href="#">'.esc_attr('Buy Tickets','kickoff').'</a>
						</div>
					</div>
					<!--kode_football_matck_counter end-->';
				}
			$html_event .= '
			</div>
			<!--kode_football_match_wraper end-->';
			
			return $html_event;
		}
	}
	
	
	if(!function_exists('kode_get_upcomming_match_fixture_item')){
		function kode_get_upcomming_match_fixture_item($settings = array()){
			$evn = '';
			$order = 'DESC';
			$limit = 10;//Default limit
			$offset = '';		
			$rowno = 0;
			$event_count = 0;
			// header-title
			// header-description
			// player-right-bg-image
			// player-right-bg-color
			$EM_Events = EM_Events::get( array('category'=>$settings['category'], 'group'=>'this','scope'=>'future', 'limit' => 6, 'order' => 'ASC' ));
			$events_count = count ( $EM_Events );	
			$current_size = 0;
			$size = 1;
			$pattern_image = (empty($settings['player-right-bg-image']))? '': $settings['player-right-bg-image'];
			
			// $args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			$pattern_image = wp_get_attachment_image_src($pattern_image, 'full');
			
			$html_event = '
			<!--kode_football_match_wraper start-->
			<div class="kode_football_ipl_wraper">				
				<!--kode_football_ipl_list start-->
				<div class="kode_football_ipl_list">
					<!--kode_football_ipl_cols start-->
						<div class="kode_football_ipl_tabs">
							<div class="kode_football_ipl_cols">';
								$counter_event = 0;
								foreach($EM_Events as $event){
									$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
									if( !empty($event_post_data)){
										$event_post_data = json_decode( $event_post_data, true );				
									}
									$counter_event++;
									if($event->event_all_day <> 1){
										$start_time = $event->start_time;
										$end_time = $event->end_time;
									}else{

										$start_time = '12:00';
										$end_time = '12:00';
										
									}
									$event_year = date('Y',$event->start);
									$event_month = date('m',$event->start);
									$event_day = date('d',$event->start);
									// print_r($event->start_time);
									$event_start_time = date("G,i,s", strtotime($start_time));
									$html_event .= '
									<!--kode_football_matck_counter start-->
									<div class="kode_football_ipl_compition">
										<h4>'.esc_attr($counter_event).'</h4>
										<div class="kode_football_ipl_caption">
											<div class="kode_football_ipl_row">
												<h5>'.get_the_title($event_post_data['select_team_first']).'</h5>
												<h3>'.esc_attr('VS','kickoff').'</h3>
												<h5>'.get_the_title($event_post_data['select_team_second']).'</h5>
											</div>
											<ul class="kode_football_ipl_date">
												<li>'.esc_attr(date('d M D, Y',$event->start)).'</li>
												<li>'.esc_attr($start_time).'</li>
											</ul>
										</div>
									</div>
									<!--kode_football_matck_counter end-->';
								}
					$html_event .= '
							</div>
						<!--kode_football_match_fig start-->
						<style scroped>
							.kode_football_ipl_fixture:after{background:url('.esc_url($pattern_image[0]).');}
						</style>
						<div class="kode_football_ipl_fixture">
							<h3>'.esc_attr($settings['header-title']).'</h3>
							<p>'.esc_attr($settings['header-description']).'</p>
						</div>
						<!--kode_football_match_fig end-->
					</div>
				</div>	
			</div>
			<!--kode_football_match_wraper end-->';
			
			return $html_event;
		}
	}
	
	
	if(!function_exists('kode_get_live_result_item')){
		function kode_get_live_result_item( $settings = array() ){
			$evn = '';
				$order = 'DESC';
				$limit = 10;//Default limit
				$offset = '';		
				$rowno = 0;
				$event_count = 0;
				// header-title
				// header-description
				// player-right-bg-image
				// player-right-bg-color
				
				if( empty($settings['category']) ){
					$parent = array('all'=>esc_attr__('All', 'kickoff'));
					$settings['category-id'] = '';
				}else{
					$term = get_term_by('slug', $settings['category'], 'event-categories');
					//$parent = array($settings['category']=>$term->name);
					if(isset($term->term_id)){
						$settings['category-id'] = $term->term_id;
					}else{
						$settings['category-id'] = '';
					}
					
				}
				$thebookstore_category = explode(',', $settings['category']);
				// $categories = thebookstore_get_term_id_name('event-categories' );
				$html_event = '			
				<div class="crkt-board">';
					if(isset($settings['header-title']) && $settings['header-title'] <> ''){
						$html_event .= '
						<div class="crkt-hd2">
							<h2>'.esc_attr($settings['header-title']).'</h2>
						</div>';
					}
					$html_event .= '	
					<!--// CRICKET ACCORDIAN WRAP //-->
					<div class="crkt-accordian">';
						$html_event .= '
						<script type="text/javascript">
						jQuery(document).ready(function($){
							/* ---------------------------------------------------------------------- */
							/*	Accordion Script
							/* ---------------------------------------------------------------------- */
							if($(".accordion").length){
								//custom animation for open/close
								$.fn.slideFadeToggle = function(speed, easing, callback) {
								  return this.animate({opacity: "toggle", height: "toggle"}, speed, easing, callback);
								};

								$(".accordion").accordion({
								  defaultOpen: "section1",
								  cookieName: "nav",
								  speed: "slow",
								  animateOpen: function (elem, opts) { //replace the standard slideUp with custom function
									elem.next().stop(true, true).slideFadeToggle(opts.speed);
								  },
								  animateClose: function (elem, opts) { //replace the standard slideDown with custom function
									elem.next().stop(true, true).slideFadeToggle(opts.speed);
								  }
								});
							}
						});
						</script>';
						foreach($thebookstore_category as $category_val){
							if(!empty($category_val)){
							$cat_name = str_replace('-',' ',$category_val);
							$html_event .= '
							<div class="accordion" id="section-'.esc_attr($category_val).'">'.esc_attr($cat_name).'<span class="fa fa-angle-down"></span></div>
							<div class="accordion-content">
								<!--// CRICKET CURRENT TABS WRAP //-->
								<div class="crkt-tab-wrap">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs crkt-tabnav" role="tablist">
										<li role="presentation" class="active current"><a href="#home-'.esc_attr($category_val).'" aria-controls="home" role="tab" data-toggle="tab">'.esc_attr('Current','kickoff').'</a></li>
										<li role="presentation" class="current"><a href="#profile-'.esc_attr($category_val).'" aria-controls="profile" role="tab" data-toggle="tab">'.esc_attr('Results','kickoff').'</a></li>
										<li role="presentation" class="current"><a href="#messages-'.esc_attr($category_val).'" aria-controls="messages" role="tab" data-toggle="tab">'.esc_attr('Fixtures','kickoff').'</a></li>
									</ul>
									<!-- Tab panes -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="home-'.esc_attr($category_val).'">
											<!-- CURRENT MATCH START -->
											<ul class="current-match">';
												$EM_Events = EM_Events::get( array('category'=>$category_val, 'group'=>'this','scope'=>'all', 'limit' => 50, 'order' => 'ASC' ));
												$events_count = count ( $EM_Events );	
												$current_size = 0;
												$size = 1;
												$counter_event = 0;
												foreach($EM_Events as $event){
													$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
													if( !empty($event_post_data)){
														$event_post_data = json_decode( $event_post_data, true );				
													}
													$counter_event++;
													if($event->event_all_day <> 1){
														$start_time = $event->start_time;
														$end_time = $event->end_time;
													}else{

														$start_time = '12:00';
														$end_time = '12:00';
														
													}
													$event_year = date('Y',$event->start);
													$event_month = date('m',$event->start);
													$event_day = date('d',$event->start);
													
													
													$event_current_d = mktime(0, 0, 0, date('m'), date('d'), date('y'));
													$event_start_time = date("G,i,s", strtotime($start_time));
													if($event_current_d == $event->start){
														$html_event .= '
														<li>
															<h4><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr($event->post_title).'</a></h4>
															<a class="score-btn" href="#">'.esc_attr('Scorecard','kickoff').'</a>
														</li>';
													}	
												}	
												$html_event .= '
											</ul>
											<!-- CURRENT MATCH END -->
										</div>
										<div role="tabpanel" class="tab-pane" id="profile-'.esc_attr($category_val).'">										
											<!-- CURRENT MATCH START -->
											<ul class="current-match">';
												$EM_Events = EM_Events::get( array('category'=>$category_val, 'group'=>'this','scope'=>'past', 'limit' => 50, 'order' => 'ASC' ));
												$events_count = count ( $EM_Events );	
												$current_size = 0;
												$size = 1;
												$counter_event = 0;
												foreach($EM_Events as $event){
													$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
													if( !empty($event_post_data)){
														$event_post_data = json_decode( $event_post_data, true );				
													}
													$counter_event++;
													if($event->event_all_day <> 1){
														$start_time = $event->start_time;
														$end_time = $event->end_time;
													}else{

														$start_time = '12:00';
														$end_time = '12:00';
														
													}
													$event_year = date('Y',$event->start);
													$event_month = date('m',$event->start);
													$event_day = date('d',$event->start);
													// print_r($event->start_time);
													$event_start_time = date("G,i,s", strtotime($start_time));
														$html_event .= '
														<li>
															<h4><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr($event->post_title).'</a></h4>
															<a class="score-btn" href="#">'.esc_attr('Scorecard','kickoff').'</a>
														</li>';
												}	
												$html_event .= '
											</ul>
											<!-- CURRENT MATCH END -->
										</div>
										<div role="tabpanel" class="tab-pane" id="messages-'.esc_attr($category_val).'">
											<!-- CURRENT MATCH START -->
											<ul class="current-match">';
												$EM_Events = EM_Events::get( array('category'=>$category_val, 'group'=>'this','scope'=>'fture', 'limit' => 50, 'order' => 'ASC' ));
												$events_count = count ( $EM_Events );	
												$current_size = 0;
												$size = 1;
												$counter_event = 0;
												foreach($EM_Events as $event){
													$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
													if( !empty($event_post_data)){
														$event_post_data = json_decode( $event_post_data, true );				
													}
													$counter_event++;
													if($event->event_all_day <> 1){
														$start_time = $event->start_time;
														$end_time = $event->end_time;
													}else{

														$start_time = '12:00';
														$end_time = '12:00';
														
													}
													$event_year = date('Y',$event->start);
													$event_month = date('m',$event->start);
													$event_day = date('d',$event->start);
													// print_r($event->start_time);
													$event_start_time = date("G,i,s", strtotime($start_time));
														$html_event .= '
														<li>
															<h4><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr($event->post_title).'</a></h4>
															<a class="score-btn" href="#">'.esc_attr('Scorecard','kickoff').'</a>
														</li>';
												}	
												$html_event .= '
											</ul>
											<!-- CURRENT MATCH END -->
										</div>
									</div>
								</div>
								<!--// CRICKET CURRENT TABS WRAP //-->
							</div>';
							}
						}
						$html_event .= '
					</div>
				</div>';
				
				return $html_event;
			
		}
	}
	
	
	
	if(!function_exists('kode_get_fixture_item')){
		function kode_get_fixture_item( $settings = array() ){
			$evn = '';
				$order = 'DESC';
				$limit = 10;//Default limit
				$offset = '';		
				$rowno = 0;
				$event_count = 0;
				// header-title
				// header-description
				// player-right-bg-image
				// player-right-bg-color
				$category = get_term_by( 'slug', $settings['category'], 'event-categories' );
			
				$category = em_get_category($category->term_id);
				$cat_img = $category->get_image_url();
				
				$EM_Events = EM_Events::get( array('category'=>$settings['category'], 'group'=>'this','scope'=>'future', 'limit' => $settings['num-fetch'], 'order' => 'ASC') );
				$events_count = count ( $EM_Events );	
				$current_size = 0;
				$size = 1;
				$evn = '
				<!--// CRICKET FIXTURES //-->
				<div class="crkt-fixtures-bg">					
					<div class="crkt-fixtures-wrap">';
						if(isset($settings['header-title']) && $settings['header-title'] <> ''){
							$evn .= '
							<div class="crkt-fixtures-hd">
								<h4>'.esc_attr($settings['header-title']).'</h4>
								<ul class="crkt-social-2">
									<li><a class="fa fa-google-plus crkt-google" href="#"></a></li>
									<li><a class="fa fa-twitter crkt-twitter" href="#"></a></li>
									<li><a class="fa fa-facebook crkt-facebook" href="#"></a></li>
								</ul>
							</div>';
						}
						$evn .= '
						<!--// CRICKET FIXTURE WRAP //-->
						<div class="crkt-fixtures-innrwrap">
							<div class="crkt-daterange">								
								<h4><i class="fa fa-calendar"></i>'.esc_attr(' Today:','kickoff').''.date('d M Y').' </h4>
								<div class="crkt-pagination">
									<h6>1 of 15</h6>
									<a class="crkt-prev" href="#"></a>
									<a class="crkt-next" href="#"></a>
								</div>
								<div class="crkt-dropdown">
									<div class="dropdown">
										<button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">
										Teams
										<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
											$loop_array = kode_get_post_list_id('team');
											foreach($loop_array as $team_key => $team_val){
												$evn .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.esc_attr($team_val).'</a></li>';	
											}
											$evn .= '
										</ul>
									</div>
									<div class="dropdown">
										<button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
										Leagues
										<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">';
											$thebookstore_category = explode(',', $settings['category']);
											foreach($thebookstore_category as $category_val){
												$cat_val = str_replace('-',' ',$category_val);
												$evn .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.esc_attr($cat_val).'</a></li>';	
											}
											$evn .= '
										</ul>
									</div>
									<div class="dropdown">
										<button class="dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-expanded="false">
										More options
										<i class="fa fa-angle-down"></i>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu3">
											<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.esc_attr('Teams','kickoff').'</a></li>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.esc_attr('Events','kickoff').'</a></li>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.esc_attr('More options','kickoff').'</a></li>
										</ul>
									</div>
								</div>';
								$abc_count = '';
								$current_session_day = 0;
								$current_session_date = '';
								foreach ( $EM_Events as $event ) {
									$event_year = date('Y',$event->start);
									$event_month = date('m',$event->start);
									$event_day = date('d',$event->start);
									$session_date = date_i18n(get_option('date_format'), $event->start);
									if(!empty($event->get_location()->location_id)){
										
										$location = esc_attr($event->get_location()->name);
									}										
									$event_start_time = date("G,i,s", strtotime($event->start_time));
									
									if( $current_session_date != $session_date ){
										$current_session_day++;
										$current_session_date = $session_date;
										
										if($event_hd == 0){
											$active_hd_class = 'active';
										}else{
											$active_hd_class = '';
										}
										$evn .= '
										<div class="crkt-fixtures-dec">
											<h6>'.esc_attr($current_session_date).'<span> '.esc_attr('Fixtures','kickoff').'</span></h6>';
									}
									$evn .= '		
									<div class="text">
										<h4><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr($event->post_title).'</a></h4>
										<p><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr(substr($event->post_content,0,50)).'</a></p>
										<span>'.esc_attr('Edgebaston, Birbinghum,  13:00GMT','kickoff').'</span>
										<div class="crkt-fixtures-link">
											<a href="#">'.esc_attr('Ranking Predictor','kickoff').'</a>
											<a href="#">'.esc_attr('Match Center','kickoff').'</a>
										</div>
									</div>';
									$session_date = date_i18n(get_option('date_format'), $event->start);
									if( $current_session_date != $session_date ){
										$current_session_day++;
										$current_session_date = $session_date;		
										if($event_hd == 0){
											$active_hd_class = 'active';
										}else{
											$active_hd_class = '';
										}
										$evn .= '</div>';
									}
								}
								$evn .= '										
							</div>
							<div class="crkt-fixtures-more">
								<a href="'.esc_url(get_permalink()).'">'.esc_attr('More Fixtures','kickoff').'</a>
							</div>
						</div>
					</div>
				<!--// CRICKET FIXTURE WRAP //-->
				</div>					
				<!--// CRICKET FIXTURES //-->';
				
				return $evn;
			
		}
	}
	
	
	if(!function_exists('kode_get_normal_event_item')){
		function kode_get_normal_event_item( $settings = array() ){
			$EM_Events = EM_Events::get( array('category'=>$settings['category'], 'group'=>'this','scope'=>'future', 'limit' => $settings['num-fetch'], 'order' => 'ASC') );
			$events_count = count ( $EM_Events );	
				$evn = '';
				if(isset($settings['header-title']) && $settings['header-title'] <> ''){
					$evn = '
					<div class="crkt-hd3">
						<h4>'.esc_attr($settings['header-title']).'</h4>
					</div>';
				}
				// CRICKET HEADIND //-->
				// CRICKET EVENT WRAP //-->
				$evnt .= '		
				<div class="crkt-event-wrap">';
					foreach( $EM_Events as $event ){
						$event_year = date('Y',$event->start);
						$event_month = date('m',$event->start);
						$event_day = date('d',$event->start);
						$session_date = date_i18n(get_option('date_format'), $event->start);
						if(!empty($event->get_location()->location_id)){
							
							$location = esc_attr($event->get_location()->name);
						}										
						$event_start_time = date("G,i,s", strtotime($event->start_time));
						$evnt .= '<div class="crkt-event">
							<div class="thumb">
								'.get_the_post_thumbnail( $event->post_id, array(150,150)).'
							</div>
							<div class="text">
								<h5><a href="#">'.esc_attr('iCC Cricket World Cup','kickoff').'</a></h5>
								<span><a href="'.esc_url(get_permalink($event->post_id)).'">'.esc_attr($event->post_title).'</a></span>
								<p>'.esc_attr(substr($event->post_content,0,80)).'</p>
							</div>
						</div>';
					}
					$evnt .= '
				</div>
				<!--// CRICKET EVENT WRAP //-->';

			return 	$evnt;
		}
	}
	
	function kode_fixture_tab_widget($settings){
		$ret = '
		<div class="tab-widget">
			<!-- Nav tabs -->
			<ul class="widget-tabnav" role="tablist">
				<li role="presentation" class="active"><a href="#past_home" aria-controls="past_home" role="tab" data-toggle="tab">'.esc_html__('Live','kickoff').'</a></li>
				<li role="presentation"><a href="#future_home" aria-controls="future_home" role="tab" data-toggle="tab">'.esc_html__('Fixture','kickoff').'</a></li>						
			</ul>
			<!-- Tab panes -->';
			$ret .= '
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="past_home">
					<ul class="match-widget">';
					$evn = '';
					$order = 'DESC';
					$limit = 10;//Default limit
					$settings['fixture-limit'];
					$offset = '';		
					$rowno = 0;
					$event_count = 0;
					$EM_Events = EM_Events::get( array('scope'=>'future','category'=>$settings['category'], 'limit' => $settings['fixture-limit']) );
					$events_count = count ( $EM_Events );	
					$current_size = 0;
					$size = 1;			
					$team_first_result = '';
					$team_second_result = '';
					foreach ( $EM_Events as $event ) {
						$event_year = date('Y',$event->start);
						$event_month = date('m',$event->start);
						$event_day = date('d',$event->start);
						$event_start_time = date("H:i:s", strtotime($event->start_time));
						$event_end_time = date("H:i:s", strtotime($event->end_time));						
						$start_time = date(get_option('time_format'),strtotime($event->start_time));
						$end_time = date(get_option('time_format'),strtotime($event->end_time));
						if($event->event_all_day <> 1){ 
							$start_time = esc_attr($start_time);						
							$end_time = esc_attr($end_time); 
						}else{
							esc_html__('All Day','kickoff'); 
							$start_time = '12:00 am'; 
							$end_time = '12:00 pm'; 
						}
						$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
						if( !empty($event_post_data) ){
							$event_post_data = json_decode( $event_post_data, true );					
						}

						$ret .= '
						<li>
							<div class="kode-cell">
								<span>'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,5)).' <small>'.esc_attr($event_post_data['goal_scored_team_first']).'</small></span>
							</div>
							<div class="kode-cell">
								<span class="kode-vs">'.esc_html__('vs','kickoff').'</span>
								<small>('.esc_attr($start_time).' '.esc_attr($end_time).')</small>
							</div>
							<div class="kode-cell">
								<span>'.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,5)).' <small>'.esc_attr($event_post_data['goal_scored_team_second']).'</small></span>
							</div>
						</li>';
					}	
				$ret .= '</ul>
				</div>';
			
				$ret .= '
				<div role="tabpanel" class="tab-pane" id="future_home">
					<ul class="match-widget">';
					$evn = '';
					$order = 'DESC';
					$limit = 10;//Default limit
					$offset = '';		
					$rowno = 0;
					$event_count = 0;
					$EM_Events = EM_Events::get( array('scope'=>'past','category'=>$settings['category'], 'limit' => $settings['fixture-limit']) );
					$events_count = count ( $EM_Events );	
					$current_size = 0;
					$size = 1;			
					$team_first_result = '';
					$team_second_result = '';
					foreach ( $EM_Events as $event ) {
						$event_year = date('Y',$event->start);
						$event_month = date('m',$event->start);
						$event_day = date('d',$event->start);
						$event_start_time = date("H:i:s", strtotime($event->start_time));
						$event_end_time = date("H:i:s", strtotime($event->end_time));						
						
						$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
						if( !empty($event_post_data) ){
							$event_post_data = json_decode( $event_post_data, true );					
						}

						if($event->event_all_day <> 1){ 
							$start_time = esc_attr($start_time);						
							$end_time = esc_attr($end_time); 
						}else{
							esc_html__('All Day','kickoff'); 
							$start_time = '12:00 am'; 
							$end_time = '12:00 pm'; 
						}
						$event_post_data = kode_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
						if( !empty($event_post_data) ){
							$event_post_data = json_decode( $event_post_data, true );					
						}

						$ret .= '
						<li>
							<div class="kode-cell">
								<span>'.esc_attr(substr(get_the_title($event_post_data['select_team_first']),0,5)).' <small>'.esc_attr($event_post_data['goal_scored_team_first']).'</small></span>
							</div>
							<div class="kode-cell">
								<span class="kode-vs">'.esc_html__('vs','kickoff').'</span>
								<small>('.esc_attr($start_time).' '.esc_attr($end_time).')</small>
							</div>
							<div class="kode-cell">
								<span>'.esc_attr(substr(get_the_title($event_post_data['select_team_second']),0,5)).' <small>'.esc_attr($event_post_data['goal_scored_team_second']).'</small></span>
							</div>
						</li>';
					}	
					$ret .= '
					</ul>
				</div>
			</div>
		</div>';
		
		return $ret;
	}
	
	
?>