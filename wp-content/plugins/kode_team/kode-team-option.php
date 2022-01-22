<?php
	/*	
	*	KodeForest Team File
	*	---------------------------------------------------------------------
	*	This file creates all team options and attached to the theme
	*	---------------------------------------------------------------------
	*/
	
	// add a team option to team page
	if( is_admin() ){ add_action('after_setup_theme', 'kode_create_team_options'); }
	if( !function_exists('kode_create_team_options') ){
	
		function kode_create_team_options(){
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			if( !class_exists('kode_page_options') ) return;
			new kode_page_options( 
				
				// page option settings
				array(
					'page-layout' => array(
						'title' => __('Page Layout', 'kode-team'),
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
									'title' => __('Left Sidebar' , 'kode-team'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper left-sidebar-wrapper both-sidebar-wrapper'
								),
								'right-sidebar' => array(
									'title' => __('Right Sidebar' , 'kode-team'),
									'type' => 'combobox_sidebar',
									'options' => $kode_theme_option['sidebar-element'],
									'wrapper-class' => 'sidebar-wrapper right-sidebar-wrapper both-sidebar-wrapper'
								),
						)
					),
					'page-option' => array(
						'title' => __('Page Option', 'kode-team'),
						'options' => array(
							'page-caption' => array(
								'title' => __('Page Caption' , 'kode-team'),
								'type' => 'textarea'
							),							
							'header-background' => array(
								'title' => __('Header Background Image' , 'kode-team'),
								'button' => __('Upload', 'kode-team'),
								'type' => 'upload',
							),
							'team_logo' => array(
								'title' => __('Upload Team Logo', 'kode-team'),
								'button' => __('Set As Team Logo', 'kode-team'),
								'wrapper-class' => 'columns four',
								'type' => 'upload'
							),	
							'association' => array(
								'title' => __('Association' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),
							'header_coach' => array(
								'title' => __('Head Coach' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),
							'captain' => array(
								'title' => esc_attr__('Captain' , 'kode-team'),
								'type' => 'combobox',
								'options' => kode_get_post_list_id_emptyfirst('player'),
								'wrapper-class' => 'columns four',
								'description'=> esc_attr__('Select captain of the team.', 'kode-team')
							),
							'ranking' => array(
								'title' => __('Ranking' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),	
							'facebook' => array(
								'title' => __('Facebook' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),
							'twitter' => array(
								'title' => __('Twitter' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),
							'youtube' => array(
								'title' => __('Youtube' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),
							'pinterest' => array(
								'title' => __('Pinterest' , 'kode-team'),
								'type' => 'text',
								'wrapper-class' => 'columns four',
							),	
							'player_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Tournament Stats' , 'kode-team'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'player-opponent'=> array(
								'title'=> __('Enable Opponent' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-goals'=> array(
								'title'=> __('Enable Goals' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-assist'=> array(
								'title'=> __('Enable Assist' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-own_goal'=> array(
								'title'=> __('Enable Own Goal' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-penalty'=> array(
								'title'=> __('Enable Penalty' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-position'=> array(
								'title'=> __('Enable Position' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-yellow-card'=> array(
								'title'=> __('Enable Yellow Card' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'player-red-card'=> array(
								'title'=> __('Enable Red Card' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'teams_stats_tournaments' => array(
								'title' => '',
								'header_title' => esc_attr__('Team Tournament Stats' , 'kode-team'),
								'type' => 'header',
								'wrapper-class' => 'header-class'
							),	
							'team-goals'=> array(
								'title'=> __('Enable Team Goals' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-sot'=> array(
								'title'=> __('Enable Team Short On Target' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-ck'=> array(
								'title'=> __('Enable Team Corner Kicks' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-yc'=> array(
								'title'=> __('Enable Team Yellow Cards' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							),	
							'team-pa'=> array(
								'title'=> __('Enable Team Passing Accuracy' ,'kode-team'),
								'type'=> 'checkbox',
								'wrapper-class' => 'three columns',
							)
						)
					),

				),
				// page option attribute
				array(
					'post_type' => array('team'),
					'meta_title' => __('Team Option', 'kode-team'),
					'meta_slug' => 'team-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				)
			);
			
		}
	}	
	
	// add team in page builder area
	add_filter('kode_page_builder_option', 'kode_register_team_item');
	if( !function_exists('kode_register_team_item') ){
		function kode_register_team_item( $page_builder = array() ){
			global $kode_spaces;
		
			$page_builder['content-item']['options']['team'] = array(
				'title'=> __('Team', 'kode-team'), 
				'icon'=>'fa-users',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> __('Category' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('team_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('team_tag'),
						'description'=> __('Will be ignored when the team filter option is enabled.', 'kode-team')
					),					
					'team-style'=> array(
						'title'=> __('Team Style' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'normal-view' => __('Normal View', 'kode-team'),
							'modern-view' => __('Modern View', 'kode-team')
						),
					),					
					'num-fetch'=> array(
						'title'=> __('Num Fetch' ,'kode-team'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> __('Specify the number of teams you want to pull out.', 'kode-team')
					),	
					'num-excerpt'=> array(
						'title'=> __('Num Excerpt' ,'kode-team'),
						'type'=> 'text',	
						'default'=> '20',
						'wrapper-class'=>'team-style-wrapper classic-team-wrapper classic-team-no-space-wrapper'
					),
					'orderby'=> array(
						'title'=> __('Order By' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode-team'), 
							'title' => __('Title', 'kode-team'), 
							'rand' => __('Random', 'kode-team'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode-team'), 
							'asc'=> __('Ascending Order', 'kode-team'), 
						)
					),			
					'pagination'=> array(
						'title'=> __('Enable Pagination' ,'kode-team'),
						'type'=> 'checkbox'
					),					
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode-team')
					),				
				)
			);
			
			$page_builder['content-item']['options']['team-table'] = array(
				'title'=> __('Points Table', 'kode-team'), 
				'icon'=>'fa-table',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> __('Category' ,'kode-team'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('team_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'kode-team'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('team_tag'),
						'description'=> __('Will be ignored when the team filter option is enabled.', 'kode-team')
					),	
					'table-style'=> array(
						'title'=> __('Select Style' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'style-full' => __('Style Full', 'kode-team'), 
							'style-small' => __('Style Small', 'kode-team'), 
						)
					),					
					'num-fetch'=> array(
						'title'=> __('Top Number of Teams' ,'kode-team'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> __('Specify the number of teams you want to pull out.', 'kode-team')
					),	
					'orderby'=> array(
						'title'=> __('Order By' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode-team'), 
							'title' => __('Title', 'kode-team'), 
							'rand' => __('Random', 'kode-team'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode-team'), 
							'asc'=> __('Ascending Order', 'kode-team'), 
						)
					),			
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode-team')
					),				
				)
			);
			
			$page_builder['content-item']['options']['leader-board'] = array(
				'title'=> esc_html__('Leader Board', 'kode-team'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'title-num-excerpt'=> array(
						'title'=> esc_html__('Title Num Length (Word)' ,'kode-team'),
						'type'=> 'text',	
						'default'=> '15',
						'description'=> esc_html__('This is a number of word (decided by spaces) that you want to show on the event title. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.', 'kode-team')
					),	
					'pattern-image' => array(
						'title' => esc_html__('Background Pattern' , 'kode-team'),
						'button' => esc_html__('Upload', 'kode-team'),
						'type' => 'upload',											
					),
					'player-image' => array(
						'title' => esc_html__('Player Image' , 'kode-team'),
						'button' => esc_html__('Upload', 'kode-team'),
						'type' => 'upload',											
					),
					'category'=> array(
						'title'=> esc_html__('Category' ,'kode-team'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('team_category'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'tag'=> array(
						'title'=> esc_html__('Tag' ,'kode-team'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('team_tag'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'num-fetch' => array(
						'title' => esc_html__('Number Fetch', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Write number of fetch teams on the leader board.', 'kode-team')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kode-team')
					),					
				)
			);
			
			$page_builder['content-item']['options']['team-slider'] = array(
				'title'=> __('Team Slider', 'kode-team'), 
				'icon'=>'fa-align-justify',
				'type'=>'item',
				'options'=>array(					
					'category'=> array(
						'title'=> __('Category' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('team_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> kode_get_term_list('team_tag'),
						'description'=> __('Will be ignored when the team filter option is enabled.', 'kode-team')
					),					
					'num-title-fetch'=> array(
						'title'=> __('Num Fetch' ,'kode-team'),
						'type'=> 'text',	
						'default'=> '25',
						'description'=> __('Specify the number of title word you want to pull out.', 'kode-team')
					),	
					'orderby'=> array(
						'title'=> __('Order By' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'kode-team'), 
							'title' => __('Title', 'kode-team'), 
							'rand' => __('Random', 'kode-team'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'kode-team'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'kode-team'), 
							'asc'=> __('Ascending Order', 'kode-team'), 
						)
					),
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => __('Spaces after ending of this item', 'kode-team')
					),				
				)
			);
			
			$page_builder['content-item']['options']['cricket-points-table'] = array(
				'title'=> esc_html__('Cric Points Table', 'kode-team'), 
				'icon'=>'fa-calendar-check-o',
				'type'=>'item',
				'options'=> array(					
					'header-title'=> array(
						'title'=> esc_html__('Points Table Title' ,'kode-team'),
						'type'=> 'text',	
						'default'=> 'Next Match',
						'description'=> esc_html__('Add Next Event Title Here.', 'kode-team')
					),					
					'category'=> array(
						'title'=> esc_html__('Category' ,'kode-team'),
						'type'=> 'multi-combobox',
						'options'=> kode_get_term_list('team_category'),
						'description'=> esc_html__('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'kode-team')
					),	
					'margin-bottom' => array(
						'title' => esc_html__('Margin Bottom', 'kode-team'),
						'type' => 'text',
						'default' => '',
						'description' => esc_html__('Spaces after ending of this item Note:Donot write px with it.', 'kode-team')
					),					
				)
			);
			
			return $page_builder;
		}
	}
	
	
	
	// Generate Options in theme Option Panel
	add_filter('kode_themeoption_panel', 'kode_register_team_themeoption');
	if( !function_exists('kode_register_team_themeoption') ){
		function kode_register_team_themeoption( $array ){		
			global $kode_theme_option;
			if(!isset($kode_theme_option['sidebar-element'])){$kode_theme_option['sidebar-element'] = array('blog','contact');}
			//if empty
			if( empty($array['general']['options']) ){
				return $array;
			}
			
			//Blog options
			$post_themeoption_team = array(
				'title' => esc_html__('Team Post Type', 'kode-team'),
				'options' => array(
					'team_post_type' => array(
						'title' => esc_html__('Post Type Name', 'kode-team'),
						'type' => 'text',	
						'default' => 'Team',	
						'description' => 'Post type name should be first letter capitilize.',
					),
					'team_post_type_slug' => array(
						'title' => esc_html__('Post Type Slug', 'kode-team'),
						'type' => 'text',	
						'default' => 'team',	
						'description' => 'Post type name should be all letters will be lower.',
					),
					'team_post_type_category' => array(
						'title' => esc_html__('Post Type Category', 'kode-team'),
						'type' => 'checkbox',	
						'default' => 'enable'
					),
					'team_post_type_category_slug' => array(
						'title' => esc_html__('Post Type Category', 'kode-team'),
						'type' => 'text',	
						'default' => 'team_category',	
						'description' => 'Post type Category name should be all letters will be lower.',
					),
					'team_post_type_tag' => array(
						'title' => esc_html__('Post Type Tag', 'kode-team'),
						'type' => 'checkbox',	
						'default' => 'enable'
					),
					
					'team_post_type_tag_slug' => array(
						'title' => esc_html__('Post Type Tags', 'kode-team'),
						'type' => 'text',	
						'default' => 'team_tag',	
						'description' => 'Post type Tags name should be all letters will be lower.',
					),
				),
			);
			
			
			//Blog options
			$post_themeoption_team_set = array(
				'title' => esc_html__('Team Settings', 'kode-team'),
				'options' => array(
					'general_setting' => array(
						'title' => __('General Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'General Setting',
						'description' => 'Enter the General Setting string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_name' => array(
						'title' => __('Team Name' , 'kode-team'),
						'type' => 'text',
						'default' => 'Team Name',
						'description' => 'Enter the Team Name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'association' => array(
						'title' => __('Association' , 'kode-team'),
						'type' => 'text',
						'default' => 'Association',
						'description' => 'Enter the team Association string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'header_coach' => array(
						'title' => __('Head Coach' , 'kode-team'),
						'type' => 'text',
						'default' => 'Head Coach',
						'description' => 'Enter the team Head Coach string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'captain' => array(
						'title' => esc_attr__('Captain' , 'kode-team'),
						'type' => 'text',
						'default' => 'Captain',
						'description' => 'Enter the team Captain string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'ranking' => array(
						'title' => __('Ranking' , 'kode-team'),
						'type' => 'text',
						'default' => 'Ranking',
						'description' => 'Enter the team Ranking string you wish to have.',
						'wrapper-class' => 'columns four',
					),	
					
				),
				
				
			);
			
			//Team Detail string settings
			$post_themeoption_team_detail = array(
				'title' => esc_html__('Team Detail Table', 'kode-team'),
				'options' => array(
					'team-detail-table-1' => array(
						'title' => esc_html__('Team Detail Team Stats', 'kode-team'),
						'type' => 'checkbox',	
						'default' => 'enable',
						'description' => 'Click Here to enable / disable the team detail team stats table from here.',
					),
					'team-detail-table-2' => array(
						'title' => esc_html__('Team Detail Players Lineup', 'kode-team'),
						'type' => 'checkbox',	
						'default' => 'enable',
						'description' => 'Click Here to enable / disable the team detail Players Lineup table from here.',
					),
					'team_tournament' => array(
						'title' => __('Tournament Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Tournament',
						'description' => 'Enter the Tournament table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_opponent' => array(
						'title' => __('Opponent Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'OPPONENT',
						'description' => 'Enter the Opponent table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_goals_settings' => array(
						'title' => __('Goals Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Goals',
						'description' => 'Enter the Goals table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_shorts_on_target' => array(
						'title' => __('Shorts on Target Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Shorts on Target',
						'description' => 'Enter the Shorts on Target table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_corner_kick' => array(
						'title' => __('Corner Kick Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Corner Kick',
						'description' => 'Enter the Corner Kick table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_yellow_card' => array(
						'title' => __('Yellow Card Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Yellow Card',
						'description' => 'Enter the Yellow Card table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					'team_passing_accuracy' => array(
						'title' => __('Passing Accuracy Setting' , 'kode-team'),
						'type' => 'text',
						'default' => 'Passing Accuracy',
						'description' => 'Enter the Passing Accuracy table name string you wish to have.',
						'wrapper-class' => 'columns four',
					),
					
				),
				
				
			);
			
			$post_themeoption_player_set_detail = array(
				// general menu
				'title' => esc_html__('Team Player Detail Table', 'kode-team'),
				'options' => array(
					'team_player_name' => array(
						'title' => __('Player Name' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Player Name',
						'description' => 'Enter the Player Name text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_opponent' => array(
						'title' => __('Player Opponent' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Opponent',
						'description' => 'Enter the Player Opponent text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_goal' => array(
						'title' => __('Player Goal' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Goal',
						'description' => 'Enter the Player Goal text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_assist' => array(
						'title' => __('Player Assist' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Assist',
						'description' => 'Enter the Player Assist text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_own_goal' => array(
						'title' => __('Player Own Goal' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Own Goal',
						'description' => 'Enter the Player Own Goal text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_penalty' => array(
						'title' => __('Player Penalty' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Penalty',
						'description' => 'Enter the Player Penalty text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_position' => array(
						'title' => __('Player Position' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Position',
						'description' => 'Enter the Player Position text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_yellow_card' => array(
						'title' => __('Player Yellow Card' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Yellow Card',
						'description' => 'Enter the Player Yellow Card text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_red_card' => array(
						'title' => __('Player Red Card' , 'kode-team'),							
						'type' => 'text',
						'default'=>'Red Card',
						'description' => 'Enter the Player Red Card text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
					'team_player_league' => array(
						'title' => __('Player League' , 'kode-team'),							
						'type' => 'text',
						'default'=>'League',
						'description' => 'Enter the Player League text string name you wish to have.',
						'wrapper-class' => 'four columns'
					),
				),
			);	
			
			

			$array['game-mode']['options']['team-mode'] = $post_themeoption_team;
			$array['game-mode']['options']['team-settings'] = $post_themeoption_team_set;
			$array['game-mode']['options']['team-detail-settings'] = $post_themeoption_team_detail;
			$array['game-mode']['options']['team-player-detail-settings'] = $post_themeoption_player_set_detail;
			
			
			return $array;
		}
	}	
	
?>