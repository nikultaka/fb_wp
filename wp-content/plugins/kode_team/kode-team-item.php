<?php
	/*	
	*	Team Listing
	*	---------------------------------------------------------------------
	*	This file contains functions that help you create team item
	*	---------------------------------------------------------------------
	*/
	
	//Team Listing
	if( !function_exists('kode_get_team_item') ){
		function kode_get_team_item( $settings ){
			// $settings['category'];
			// $settings['tag'];
			// $settings['num-excerpt'];
			// $settings['num-fetch'];
			// $settings['team-style'];
			// $settings['order'];
			// $settings['orderby'];
			// $settings['order'];
			// $settings['margin-bottom'];
			// query posts section
			$args = array('post_type' => 'team', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			$settings['column_size'] = (empty($settings['column_size']))? '4': $settings['column_size'];
			

			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'team_category', 'field'=>'slug'));
				}
				if( !empty($settings['tag'])){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'team_tag', 'field'=>'slug'));
				}				
			}			
			$query = new WP_Query( $args );

			// create the team filter
			$settings['num-excerpt'] = empty($settings['num-excerpt'])? 0: $settings['num-excerpt'];
			$size = 4;
			$team  = '<div class="kode-team kode-team-classic col-md-12"><ul class="row">';
			if($settings['team-style'] == 'normal-view'){
				$size = 4;
				$team  = '<div class="kode-team kode-team-list col-md-12"><ul class="row">';
			}else{
				$size = 4;
				$team  = '<div class="kode-team kode-team-list kode-team-modern col-md-12"><ul class="row">';
			}
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings;
				$team_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
				$designation = $team_option['designation'];
				$phone = $team_option['phone'];
				$website = $team_option['website'];
				$email = $team_option['email'];
				$facebook = $team_option['facebook'];
				$twitter = $team_option['twitter'];
				$youtube = $team_option['youtube'];
				$pinterest = $team_option['pinterest'];
				if( $current_size % $size == 0 ){
					$team .= '<li class="clear"></li>';
				}	
				if($settings['team-style'] == 'normal-view'){
					$team .= '<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">		
						<div class="kode-ux">					
							<figure><a class="kode-team-thumb" href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							  <figcaption>
								<ul class="kode-team-network-kick">';
									if(isset($facebook) && $facebook <> ''){
										$team .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($twitter) && $twitter <> ''){
										$team .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($youtube) && $youtube <> ''){
										$team .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($pinterest) && $pinterest <> ''){
										$team .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
									}
								$team .= '
								</ul>
								<div class="clearfix"></div>
								<h2><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h2>
								<a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.__('View Detail','kode-team').'</a>
							  </figcaption>
							</figure>
						</div>	
					</li>';
				}else if($settings['team-style'] == 'modern-view'){
					$team .= '<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">		
						<div class="kode_football_heros_fig">
							<figure>
								'.get_the_post_thumbnail($post->ID, array(350,350)).'
								<ul class="kode_football_heros_icon">';
									if(isset($facebook) && $facebook <> ''){
										$team .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($twitter) && $twitter <> ''){
										$team .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($youtube) && $youtube <> ''){
										$team .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($pinterest) && $pinterest <> ''){
										$team .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
									}
								$team .= '
								</ul>
							</figure>
							<div class="kode_football_heros_caption">
								<h4><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h4>
								<h6>Mid Fielder</h6>
							</div>
						</div>
					</li>';
				}else{
					$team .= '<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">		
						<div class="kode-ux">					
							<figure><a class="kode-team-thumb" href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(350,350)).'</a>
							  <figcaption>';
									if(isset($facebook) && $facebook <> ''){
										$team .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($twitter) && $twitter <> ''){
										$team .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($youtube) && $youtube <> ''){
										$team .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($pinterest) && $pinterest <> ''){
										$team .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
									}
								$team .= '
								</ul>
								<div class="clearfix"></div>
								<h2><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h2>
								<a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.__('View Detail','kode-team').'</a>
							  </figcaption>
							</figure>
						</div>	
					</li>';
				}
				$current_size++;
			}
			wp_reset_postdata();
			if( $settings['pagination'] == 'enable' ){
				$team .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			$team .= '</ul></div>';
			
			return $team;
		}
	}	
	
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_ranking_table_sorted_array') ){
		function kode_get_team_ranking_table_sorted_array($team_id){
			global $kode_theme_option;
			$team_content_data = array();
			$kode_html = '';
			if(isset($team_id)){
				$team_win_result = kode_get_result_team_won($team_id, 'won');
				$team_lost_result = kode_get_result_team_won($team_id, 'loss');
				$team_draw_result = kode_get_result_team_won($team_id, 'draw');
				
				
				// goal_scored_team
				
				
				
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
				
				$event_post_data = kode_decode_stopbackslashes(get_post_meta($team_id, 'post-option', true ));
				if( !empty($event_post_data)){
					$event_post_data = json_decode( $event_post_data, true );				
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
						$total_matches = @array_merge($team_lost_result['select_team'],$team_draw_result['select_team']);		
					} else if(empty($team_lost_result['select_team'])){
						$total_matches = @array_merge($team_win_result['select_team'],$team_draw_result['select_team']);		
					}else{
						$total_matches = @array_merge($team_win_result['select_team'],$team_lost_result['select_team'],$team_draw_result['select_team']);		
					}
				}else{
					if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];
					}else if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];
					}else{
						$total_matches = @array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}
				
				
				
				$goal_scored_team = kode_get_total_data_from_all_matches($team_id,'goal_scored_team');
				$total_shots_team = kode_get_total_data_from_all_matches($team_id,'total_shots_team');
				$shorts_on_targets_team = kode_get_total_data_from_all_matches($team_id,'shorts_on_targets_team');
				$ball_possession_team = kode_get_total_data_from_all_matches($team_id,'ball_possession_team');
				$corner_kicks_team = kode_get_total_data_from_all_matches($team_id,'corner_kicks_team');
				$fouls_committed_team = kode_get_total_data_from_all_matches($team_id,'fouls_committed_team');
				$offsides_team = kode_get_total_data_from_all_matches($team_id,'offsides_team');
				$saves_team = kode_get_total_data_from_all_matches($team_id,'saves_team');
				$yellow_cards_team = kode_get_total_data_from_all_matches($team_id,'yellow_cards_team');
				$red_cards_team = kode_get_total_data_from_all_matches($team_id,'red_cards_team');
				
				if(!empty($total_matches)){
					$total_matches = count($total_matches);
				}else{
					$total_matches = 0;
				}
				$points_on_winning = $team_won*$kode_theme_option['match-points'];
				$points_on_draw = $team_draw*$kode_theme_option['match-points-drawn'];
				$total_points = $points_on_draw+$points_on_winning;
				$kode_team_option_first = kode_decode_stopbackslashes(get_post_meta($team_id, 'post-option', true ));
				if( !empty($kode_team_option_first) ){
					$kode_team_option_first = json_decode( $kode_team_option_first, true );					
				}
				
				
				$team_first_img = wp_get_attachment_image_src($kode_team_option_first['team_logo'], 'full');
				// $team_second_img = wp_get_attachment_image_src($kode_team_option_second['team_logo'], 'full');
				$post_team = get_post($team_id);
				
				$team_content_data['team_img_url'] = $team_first_img[0];
				$team_content_data['team_id'] = $team_id;
				$team_content_data['matches'] = $total_matches;
				$team_content_data['won'] = $team_won;
				$team_content_data['loss'] = $team_loss;
				$team_content_data['draw'] = $team_draw;
				$team_content_data['points'] = $total_points;
				$team_content_data['goal_scored_team'] = $goal_scored_team;
				$team_content_data['total_shots_team'] = $total_shots_team;
				$team_content_data['shorts_on_targets_team'] = $shorts_on_targets_team;
				$team_content_data['ball_possession_team'] = $ball_possession_team;
				$team_content_data['corner_kicks_team'] = $corner_kicks_team;
				$team_content_data['fouls_committed_team'] = $fouls_committed_team;
				$team_content_data['offsides_team'] = $offsides_team;
				$team_content_data['saves_team'] = $saves_team;
				$team_content_data['yellow_cards_team'] = $yellow_cards_team;
				$team_content_data['red_cards_team'] = $red_cards_team;
				
				
			
			}
			
			return $team_content_data;
		}
	}
	
	
	//get all the teams who played in an event and data all matches
	if( !function_exists('kode_get_total_data_from_all_matches') ){
		function kode_get_total_data_from_all_matches($team_id,$array_key){
			$total_matches = array();
			$team_win_result = kode_get_result_team_won($team_id, 'won');
			$team_lost_result = kode_get_result_team_won($team_id, 'loss');
			$team_draw_result = kode_get_result_team_won($team_id, 'draw');
			
			if(!empty($team_draw_result[$array_key])){
				if(empty($team_win_result[$array_key])){
					$total_matches = @array_merge($team_lost_result[$array_key],$team_draw_result[$array_key]);		
					
				} else if(empty($team_lost_result[$array_key])){
					$total_matches = @array_merge($team_win_result[$array_key],$team_draw_result[$array_key]);
					
				}else{
					$total_matches = @array_merge($team_win_result[$array_key],$team_lost_result[$array_key],$team_draw_result[$array_key]);		
					
				}
			}else{
				if(empty($team_win_result[$array_key])){
					$total_matches = $team_lost_result[$array_key];
				}else if(empty($team_lost_result[$array_key])){
					$total_matches = $team_win_result[$array_key];
				}else{
					$total_matches = @array_merge($team_lost_result[$array_key],$team_win_result[$array_key]);
					
				}				
			}
			
			if(!is_array($total_matches)){
				$total_matches = $total_matches;
			}else{
				$total_matches = $total_matches;
				$total_matches = array_sum($total_matches);
			}
			
			return $total_matches;
		}
	}
	
	
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_points_table') ){
		function kode_get_team_points_table($settings){
			
			$kode_teams = get_posts(array('post_type'=>'team','posts_per_page'=>$settings['num-fetch']));
			if(isset($settings['table-style']) && $settings['table-style'] == 'style-full'){
			$size = 4;
			$team  = '
			<div class="tab-pane" role="tabpanel">
				<table class="kode-table">
					<thead>
						<tr>
							<th>'.esc_attr__('Team','kode-team').'</th>
							<th>'.esc_attr__('Matches','kode-team').'</th>
							<th>'.esc_attr__('Goals','kode-team').'</th>
							<th>'.esc_attr__('Won','kode-team').'</th>
							<th>'.esc_attr__('Lost','kode-team').'</th>
							<th>'.esc_attr__('Draw','kode-team').'</th>
							<th>'.esc_attr__('Pts','kode-team').'+/-</th>
						</tr>
					</thead>
					<tbody>
					';
			$current_size = 0;
			foreach($kode_teams as $kode_team){
				$counter++;
				$team_id = $kode_team->ID;
				$team_raw_data = kode_get_team_ranking_table_sorted_array($team_id);
				
				$team_unsorted_array[$kode_team->ID] = $team_raw_data['points'];
				

			}
			arsort($team_unsorted_array);
			$counter = 0;
			foreach($team_unsorted_array as $keys => $val){					
				$team  .= '<tr>'.kode_get_team_performance_modern($keys).'</tr>';
			}
			$team  .= '</tbody></table></div>';
			}else{
				$size = 4;
				$team  = '
				<table class="kode-table kode-table-v2">
                    <thead>
                      <tr>
                        <th>'.__('Team','kode-team').'</th>
                        <th>'.__('w','kode-team').'</th>
                        <th>'.__('d','kode-team').'</th>
                        <th>'.__('l','kode-team').'</th>
                        <th>'.__('pts','kode-team').'</th>
                      </tr>
                    </thead>
                    <tbody>
						';
				$current_size = 0;
				$counter = 0;
				foreach($kode_teams as $kode_team){
					$counter++;
					$team_id = $kode_team->ID;
					$team_raw_data = kode_get_team_ranking_table_sorted_array($team_id);
					
					$team_unsorted_array[$kode_team->ID] = $team_raw_data['points'];
					

				}
				arsort($team_unsorted_array);
				$counter = 0;
				foreach($team_unsorted_array as $keys => $val){					
					$team  .= '<tr>'.kode_get_team_performance_modern($keys).'</tr>';
				}
				$team  .= '</tbody></table>';
			}
			
			
			return $team;
		}
	}
	
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_leader_board_item') ){
		function kode_get_leader_board_item($settings){
		
			$kode_args = array('post_type' => 'team', 'suppress_filters' => false);
			$kode_args['posts_per_page'] = $settings['num-fetch'];
			$kode_args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$kode_args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$pattern_image = (empty($settings['pattern-image']))? '': $settings['pattern-image'];
			$player_image = (empty($settings['player-image']))? '': $settings['player-image'];
			
			$pattern_image = wp_get_attachment_image_src($pattern_image, 'full');
			$player_image = wp_get_attachment_image_src($player_image, 'full');
			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$kode_args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($kode_args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'team_category', 'field'=>'slug'));
				}
				
			}			
			
			$size = 4;
			$team_leader = '';
			if(!empty($pattern_image)){
				$team_leader = '
				<style>
				.kode_football_leader_wraper:before{
					background:url('.esc_url($pattern_image[0]).');
				}
				</style>';
			}
			$team_leader .= '
			<div class="kode_football_leader_wraper">
				<div class="container">';
					if(isset($settings['header-title']) && $settings['header-title'] <> ''){
						$team_leader .= '
						<!--kode_football_leader_heading start-->
						<div class="kode_football_leader_heading">
							<h2>'.esc_attr($settings['header-title']).'</h2>
						</div>';
					}
					$team_leader .= '
					<!--kode_football_leader_heading end-->
					<!--kode_football_leader_cols start-->
					<div class="kode_football_leader_row">
						<div class="kode_footbal_leader_team">
							<h5>Team</h5>
							<ul>
								<li><h5>P</h5></li>
								<li><h5>W</h5></li>
								<li><h5>D</h5></li>
								<li><h5>L</h5></li>
								<li><h5>PTS</h5></li>
							</ul>
						</div>';
					$query_team = new WP_Query( $kode_args );
					
					$current_size = 0;
					while($query_team->have_posts()){ $query_team->the_post();
						global $kode_post_option,$post,$kode_post_settings;
						$team_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
						$team_leader  .= '<div class="kode_footbal_leader_team team_1">'.kode_get_team_performance_small($post->ID).'</div>';
					}wp_reset_postdata();
					$team_leader  .= '
					</div>
					<div class="kode_football_leader_fig">
						<figure>
							<img alt="image" src="'.esc_url($player_image[0]).'">
						</figure>
					</div>
				<!--kode_football_leader_cols end-->
				</div>
			</div>';
			
			
			
			return $team_leader;
		}
	}
	
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_performance_small') ){
		function kode_get_team_performance_small($team_id){
			global $kode_theme_option;
			$kode_html = '';
			$total_matches = 0;
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
						$total_matches = @array_merge($team_lost_result['select_team'],$team_draw_result['select_team']);		
					} else if(empty($team_lost_result['select_team'])){
						$total_matches = @array_merge($team_win_result['select_team'],$team_draw_result['select_team']);		
					}else{
						$total_matches = @array_merge($team_win_result['select_team'],$team_lost_result['select_team'],$team_draw_result['select_team']);		
					}
				}else{
					if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];
					}else if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];
					}else{
						$total_matches = @array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}
				if(!empty($total_matches)){
					$total_matches = count($total_matches);
				}else{
					$total_matches = 0;
				}
				$points_on_winning = $team_won*$kode_theme_option['match-points'];
				$points_on_draw = $team_draw*$kode_theme_option['match-points-drawn'];
				$total_points = $points_on_draw+$points_on_winning;
				$kode_html = '
				<h5><a href="'.esc_url(get_permalink($team_id)).'">'.esc_attr(get_the_title($team_id)).'</a></h5>
				<ul>
					<li>'.esc_attr($formulla).'</li>
					<li>'.esc_attr($team_won).'</li>
					<li>'.esc_attr($team_draw).'</li>
					<li>'.esc_attr($team_loss).'</li>
					<li>'.esc_attr($total_points).'</li>
				</ul>';
				
			
			}
			return $kode_html;
		}
	}
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_performance_modern') ){
		function kode_get_team_performance_modern($team_id){
			global $kode_theme_option;
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
						$total_matches = @array_merge($team_lost_result['select_team'],$team_draw_result['select_team']);		
					} else if(empty($team_lost_result['select_team'])){
						$total_matches = @array_merge($team_win_result['select_team'],$team_draw_result['select_team']);		
					}else{
						$total_matches = @array_merge($team_win_result['select_team'],$team_lost_result['select_team'],$team_draw_result['select_team']);		
					}
				}else{
					if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];
					}else if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];
					}else{
						$total_matches = @array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}
				if(!empty($total_matches)){
					$total_matches = count($total_matches);
				}else{
					$total_matches = 0;
				}
				$points_on_winning = $team_won*$kode_theme_option['match-points'];
				$points_on_draw = $team_draw*$kode_theme_option['match-points-drawn'];
				$total_points = $points_on_draw+$points_on_winning;
				$kode_html = '<td><a href="'.esc_url(get_permalink($team_id)).'">'.esc_attr(get_the_title($team_id)).'</a></td>';
				// $kode_html .= '<td>'.esc_attr($total_matches).'</td>';
				// $kode_html .= '<td>'.esc_attr($total_goals).'</td>';
				$kode_html .= '<td>'.esc_attr($team_won).'</td>';
				$kode_html .= '<td>'.esc_attr($team_draw).'</td>';
				$kode_html .= '<td>'.esc_attr($team_loss).'</td>';
				$kode_html .= '<td>'.esc_attr($total_points).'</td>';
				
			
			}
			return $kode_html;
		}
	}
	
	
	//Team Listing
	if( !function_exists('kode_get_team_item_slider') ){
		function kode_get_team_item_slider( $settings ){
			// $settings['category'];
			// $settings['tag'];
			// $settings['num-excerpt'];
			// $settings['num-fetch'];
			// $settings['team-style'];
			// $settings['order'];
			// $settings['orderby'];
			// $settings['order'];
			// $settings['margin-bottom'];
			// query posts section
			$args = array('post_type' => 'team', 'suppress_filters' => false);
			$args['posts_per_page'] = 10;
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;

			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'team_category', 'field'=>'slug'));
				}
			}			
			$query = new WP_Query( $args );

			// create the team filter
			
			$settings['num-title-fetch'] = empty($settings['num-title-fetch'])? '25': $settings['num-title-fetch'];
			
			$size = 4;
			$team  = '<div class="kode-team kode-team-list col-md-12"><div data-slide="3" class="owl-carousel owl-theme kode-team-list next-prev-style">';
			
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings;
				$team_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
				$designation = empty($team_option['designation'])? '': $team_option['designation'];
				$phone = empty($team_option['phone'])? '': $team_option['phone'];
				$website = empty($team_option['website'])? '': $team_option['website'];
				$email = empty($team_option['email'])? '': $team_option['email'];
				$facebook = empty($team_option['facebook'])? '': $team_option['facebook'];
				$twitter = empty($team_option['twitter'])? '': $team_option['twitter'];
				$youtube = empty($team_option['youtube'])? '': $team_option['youtube'];
				$pinterest = empty($team_option['pinterest'])? '': $team_option['pinterest'];
				
				// if( $current_size % $size == 0 ){
					// $team .= '<li class="clear"></li>';
				// }	
				$team .= '
				<div class="item">
					<figure>
						<a href="'.esc_url(get_permalink()).'" class="kode-team-thumb">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
						<figcaption>
							<ul class="kode-team-network-kick">';
								if(isset($facebook) && $facebook <> ''){
									$team .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
								}
								if(isset($twitter) && $twitter <> ''){
									$team .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
								}
								if(isset($youtube) && $youtube <> ''){
									$team .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
								}
								if(isset($pinterest) && $pinterest <> ''){
									$team .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
								}
							$team .= '
							</ul>
							<div class="clearfix"></div>
							<h2><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h2>
							<a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.__('View Detail','kode-team').'</a>
						</figcaption>
					</figure>
				</div>';
			
				$current_size++;
			}
			wp_reset_postdata();
			$team .= '</div></div>';
			
			return $team;
		}
	}	
	
	if( !function_exists('kode_get_team_points_table_cric') ){
		function kode_get_team_points_table_cric( $settings ){
	
			$kode_args = array('post_type' => 'team', 'suppress_filters' => false);
			$kode_args['posts_per_page'] = $settings['num-fetch'];
			$kode_args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$kode_args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			// $args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			$pattern_image = wp_get_attachment_image_src($pattern_image, 'full');
			$player_image = wp_get_attachment_image_src($player_image, 'full');
			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$kode_args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($kode_args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'team_category', 'field'=>'slug'));
				}
				// if( !empty($settings['tag'])){
					// array_push($kode_args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'team_tag', 'field'=>'slug'));
				// }				
			}			
			
			
			$size = 4;
	
			$team = '
			<script>
			jQuery(document).ready(function($){
			 var table = $(".crkt-table");
    
			$(".pts-point, .won-point").each(function(){
					
					var th = $(this),
						thIndex = th.index(),
						inverse = false;
					
					th.click(function(){
						
						table.find("td").filter(function(){
							
							return $(this).index() === thIndex;
							
						}).sortElements(function(a, b){
							
							return $.text([a]) > $.text([b]) ?
								inverse ? -1 : 1
								: inverse ? 1 : -1;
							
						}, function(){
							
							// parentNode is the element we want to move
							return this.parentNode; 
							
						});
						
						inverse = !inverse;
							
					});
						
				});
				});
			</script>
			<div class="points-table-complete-data">
				<!--// CRICKET HEADIND //-->
				<div class="crkt-hd3">
					<h4>Points Table</h4>
				</div>
				<!--// CRICKET HEADIND //-->
				<div class="crkt-event-wrap crkt-table-wrap">
				<!--// CRICKET TABLE //-->
				<table class="crkt-table">
					<thead>
						<tr>
							<th class="position-point">ID</th>
							<th class="team-point">Team</th>
							<th class="won-point">Won</th>
							<th class="pts-point">Pts</th>
						</tr>
					</thead>
					<tbody>';
					$query_team = new WP_Query( $kode_args );
						$current_size = 0;
						while($query_team->have_posts()){ $query_team->the_post();
							global $kode_post_option,$post,$kode_post_settings;
							$team_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
							$team .= kode_get_team_performance_small_normal($post->ID);
						}
						$team .= '
					</tbody>
				</table>
				<!--// CRICKET TABLE //-->
				</div>
			</div>';
			
			return $team;
		}
	}		
	
	
	//get all the teams who played in an event and their performance
	if( !function_exists('kode_get_team_performance_small_normal') ){
		function kode_get_team_performance_small_normal($team_id){
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
				
				
				$team_loss = count($team_lost_result['select_team']);
				$team_won = count($team_win_result['select_team']);
				$team_draw = count($team_draw_result['select_team']);
				
				if(!empty($team_draw_result['select_team'])){
					if(empty($team_win_result['select_team'])){
						$total_matches = @array_merge($team_lost_result['select_team'],$team_draw_result['select_team']);		
					} else if(empty($team_lost_result['select_team'])){
						$total_matches = @array_merge($team_win_result['select_team'],$team_draw_result['select_team']);		
					}else{
						$total_matches = @array_merge($team_win_result['select_team'],$team_lost_result['select_team'],$team_draw_result['select_team']);		
					}
				}else{
					if(empty($team_win_result['select_team'])){
						$total_matches = $team_lost_result['select_team'];
					}else if(empty($team_lost_result['select_team'])){
						$total_matches = $team_win_result['select_team'];
					}else{
						$total_matches = @array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
					}
				}
				$total_matches = count($total_matches);
				$formulla = 4/4.0*0+2*$team_won/2*$total_matches;
				$kode_html = '				
				<tr>
					<td>'.esc_attr($team_id).'</td>
					<td>'.esc_attr(get_the_title($team_id)).'</td>
					<td>'.esc_attr($team_won).'</td>
					<td>'.esc_attr($formulla).'</td>
				</tr>';
				
			
			}
			return $kode_html;
		}
	}
	
?>