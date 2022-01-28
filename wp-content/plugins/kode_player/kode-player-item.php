<?php
	/*	
	*	Team Listing
	*	---------------------------------------------------------------------
	*	This file contains functions that help you create player item
	*	---------------------------------------------------------------------
	*/
	
	//Team Listing
	if( !function_exists('kode_get_player_item') ){
		function kode_get_player_item( $settings ){
			// $settings['category'];
			// $settings['tag'];
			// $settings['num-excerpt'];
			// $settings['num-fetch'];
			// $settings['player-style'];
			// $settings['order'];
			// $settings['orderby'];
			// $settings['order'];
			// $settings['margin-bottom'];
			// query posts section
			$args = array('post_type' => 'player', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
			$settings['num-title-fetch'] = empty($settings['num-title-fetch'])? '10' : $settings['num-title-fetch'];

			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'player_category', 'field'=>'slug'));
				}
				if( !empty($settings['tag'])){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'player_tag', 'field'=>'slug'));
				}				
			}			
			$query = new WP_Query( $args );

			// create the player filter
			$settings['num-excerpt'] = empty($settings['num-excerpt'])? 0: $settings['num-excerpt'];
			$size = 4;
			$player  = '<div class="kode-player kode-player-classic col-md-12"><ul class="row">';
			if($settings['player-style'] == 'normal-view'){
				$size = 4;
				$player  = '<div class="kode-team kode-team-list col-md-12"><ul class="row">';
			}else{
				$size = 4;
				$player  = '<div class="kode-team kode-team-list kode-team-modern col-md-12"><ul class="row">';
			}
			$phone = '';
			$website = '';
			$facebook = '';
			$twitter = '';
			$youtube = '';
			$pinterest = '';
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings;
				$player_option = kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true));
				if( !empty($player_option) ){
					$player_option = json_decode( $player_option, true );					
				}
				if( $current_size % $size == 0 ){
					$player .= '<li class="clear"></li>';
				}	
				if($settings['player-style'] == 'normal-view'){
					$player .= '<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">		
						<div class="kode-ux">					
							<figure><a class="kode-team-thumb" href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
							  <figcaption>
								<ul class="kode-team-network-kick">';
									if(isset($facebook) && $facebook <> ''){
										$player .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($twitter) && $twitter <> ''){
										$player .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($youtube) && $youtube <> ''){
										$player .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($pinterest) && $pinterest <> ''){
										$player .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
									}
								$player .= '
								</ul>
								<div class="clearfix"></div>
								<h2><a href="'.esc_url(get_permalink()).'">'.substr(esc_attr(get_the_title()),0,$settings['num-title-fetch']).'</a></h2>
								<a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.__('View Detail','kode-player').'</a>
							  </figcaption>
							</figure>
						</div>	
					</li>';
				}else{
					$player .= '<li class="col-sm-6 ' . esc_attr(kode_get_column_class('1/' . $size)) . '">		
						<div class="kode-ux">					
							<figure><a class="kode-team-thumb" href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
							  <figcaption>
							   <ul class="kode-team-network-kick">';
									if(isset($facebook) && $facebook <> ''){
										$player .= '<li><a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($twitter) && $twitter <> ''){
										$player .= '<li><a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($youtube) && $youtube <> ''){
										$player .= '<li><a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($pinterest) && $pinterest <> ''){
										$player .= '<li><a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i></a></li>';
									}
								$player .= '
								</ul>
								<div class="clearfix"></div>
								<h2><a href="'.esc_url(get_permalink()).'">'.substr(esc_attr(get_the_title()),0,$settings['num-title-fetch']).'</a></h2>
								<a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.__('View Detail','kode-player').'</a>
							  </figcaption>
							</figure>
						</div>	
					</li>';
				}
				$current_size++;
			}
			wp_reset_postdata();
			if( $settings['pagination'] == 'enable' ){
				$player .= kode_get_pagination($query->max_num_pages, $args['paged']);
			}
			$player .= '</ul></div>';
			
			return $player;
		}
	}	
	
	add_action( 'wp_ajax_nopriv_load_ajax_team_players_first', 'kode_show_players_lineup' );
	add_action('wp_ajax_load_ajax_team_players_first', 'kode_show_players_lineup');
	function kode_show_players_lineup(){		
		$html = array();
		$kode_post_id = '';
		$kode_team_id = '';
		if(isset($_POST['post_id'])){
			$kode_post_id = $_POST['post_id'];
		}
		if(isset($_POST['settings'])){
			$kode_settings = $_POST['settings'];
			$settings['slug'] = $_POST['settings'];
		}
		if(isset($_POST['team_id'])){
			$kode_team_id = $_POST['team_id'];
		}
		
		$option_value = kode_decode_stopbackslashes(get_post_meta($kode_post_id, 'post-option', true ));
		if( !empty($option_value) ){
			$option_value = json_decode( $option_value, true );					
		}
		
		$ret = '<div class="kode-option-input">';
		$ret .= '<div class="kode-player-tabs">
		<table class="kode-table">
			<thead>
			<tr>
				<th>'.__('Select','kode-player').'</th>
				<th class="player-name-sec">'.__('Player','kode-player').'</th>
				<th>'.__('Goals','kode-player').'</th>
				<th>'.__('Assist','kode-player').'</th>
				<th>'.__('OG','kode-player').'</th>
				<th>'.__('Penalty','kode-player').'</th>
				<th>'.__('Pos','kode-player').'</th>
				<th>'.__('YC','kode-player').'</th>
				<th>'.__('RC','kode-player').'</th>
				<th>'.__('POTM','kode-player').'</th>
			</tr>
		</thead>	
		<tbody>';
			$notice = '';
			$args = array('post_type'=>'player', 'posts_per_page' => -1);
			$posts = get_posts($args);
			foreach($posts as $post){
				$selected_team_id = get_post_meta($post->ID,'select_national',true);
				if($kode_team_id == $selected_team_id){
					$player_pos = '';
					if(!empty($option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)])){
						$player_pos = $option_value[$settings['slug'].'-pos-'.esc_attr($post->ID)];						
					}
					
					$player_sel = '';
					if(!empty($option_value[$settings['slug'].'-player-'.esc_attr($post->ID)])){
						$player_sel = $option_value[$settings['slug'].'-player-'.esc_attr($post->ID)];
					}
					$player_selected = '';
					if($player_sel == 'enable'){
						$player_selected = 'checked';
					}
					$player_goal = '';
					if(!empty($option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)])){
						$player_goal = $option_value[$settings['slug'].'-pg-'.esc_attr($post->ID)];						
					}
					$player_goal_assit = '';
					if(!empty($option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)])){
						$player_goal_assit = $option_value[$settings['slug'].'-ag-'.esc_attr($post->ID)];						
					}
					$player_own_goal = '';
					if(!empty($option_value[$settings['slug'].'-og-'.esc_attr($post->ID)])){
						$player_own_goal = $option_value[$settings['slug'].'-og-'.esc_attr($post->ID)];						
					}
					$player_penalty = '';
					if(!empty($option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)])){
						$player_penalty = $option_value[$settings['slug'].'-ps-'.esc_attr($post->ID)];						
					}
					$player_yellow = '';
					if(!empty($option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)])){
						$player_yellow = $option_value[$settings['slug'].'-yc-'.esc_attr($post->ID)];						
					}
					$player_red = '';
					if(!empty($option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)])){
						$player_red = $option_value[$settings['slug'].'-rc-'.esc_attr($post->ID)];
					}
					
					$player_om = 'off';
					if(!empty($option_value[$settings['slug'].'-pom'])){
						$player_om = 'checked';
					}
					
					$ret .= '<tr class="player-row">
						<td><input type="checkbox" '.esc_attr($player_selected).' class="player_selected" name="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-player-'.esc_attr($post->ID).'" /></td>
						<td>'.esc_attr($post->post_title).'<input type="hidden" value="'.$post->ID.'" name="'.$settings['slug'].'-name" data-slug="'.$settings['slug'].'-name" /> </td>
						<td><input disabled="disabled" type="text" title="Goals" name="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pg-'.esc_attr($post->ID).'" value="'.$player_goal.'" /></td>
						<td><input disabled="disabled" type="text" title="Assit" name="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ag-'.esc_attr($post->ID).'" value="'.$player_goal_assit.'" /></td>
						<td><input disabled="disabled" type="text" title="Own Goal" name="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-og-'.esc_attr($post->ID).'" value="'.$player_own_goal.'" /></td>
						<td><input disabled="disabled" type="text" title="Penalty" name="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-ps-'.esc_attr($post->ID).'" value="'.$player_penalty.'" /></td>
						<td>
						<select disabled="disabled" class="select-pos" name="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-pos-'.esc_attr($post->ID).'">
							<option '.(($player_pos=='no-pos')?'selected="selected"':"").' value="no-pos">No Pos</option>
							<option '.(($player_pos=='GK')?'selected="selected"':"").' value="GK">GK</option>
							<option '.(($player_pos=='LB')?'selected="selected"':"").' value="LB">LB</option>
							<option '.(($player_pos=='LWB')?'selected="selected"':"").' value="LWB">LWB</option>
							<option '.(($player_pos=='CB')?'selected="selected"':"").' value="CB">CB</option>
							<option '.(($player_pos=='RB')?'selected="selected"':"").' value="RB">RB</option>
							<option '.(($player_pos=='RWB')?'selected="selected"':"").' value="RWB">RWB</option>
							<option '.(($player_pos=='LM')?'selected="selected"':"").' value="LM">LM</option>
							<option '.(($player_pos=='CM')?'selected="selected"':"").' value="CM">CM</option>
							<option '.(($player_pos=='CDM')?'selected="selected"':"").' value="CDM">CDM</option>
							<option '.(($player_pos=='RM')?'selected="selected"':"").' value="RM">RM</option>
							<option '.(($player_pos=='LW')?'selected="selected"':"").' value="LW">LW</option>
							<option '.(($player_pos=='RW')?'selected="selected"':"").' value="RW">RW</option>
							<option '.(($player_pos=='LF')?'selected="selected"':"").' value="LF">LF</option>
							<option '.(($player_pos=='CF')?'selected="selected"':"").' value="CF">CF</option>
							<option '.(($player_pos=='RF')?'selected="selected"':"").' value="RF">RF</option>
							<option '.(($player_pos=='ST')?'selected="selected"':"").' value="ST">ST</option>
						</select>
						</td>
						<td><input disabled="disabled" type="text" title="Yellow Card" name="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-yc-'.esc_attr($post->ID).'" value="'.$player_yellow.'" /></td>
						<td><input disabled="disabled" type="text" title="Red Card" name="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" data-slug="'.$settings['slug'].'-rc-'.esc_attr($post->ID).'" value="'.$player_red.'" /></td>
						<td><input disabled="disabled" '.$player_om.' type="radio" title="player of the match" name="'.$settings['slug'].'-pom-" data-slug="'.$settings['slug'].'-pom" value="'.$settings['slug'].'-pom-'.esc_attr($post->ID).'" /></td>
					</tr>';
					$notice = '';
				}else{
					$notice = '<p>These is no player added in this team. Please go to players and add player in this selected team.</p>';
				}
			} wp_reset_postdata();
		$ret .= '
		<tbody>
		</table></div></div>';
		wp_reset_query();
		
		// $ret .= $notice;		
		
		die($ret);
		
	}
	
	
	function kode_show_player_lineup_first($category, $kode_post_option, $all_team_post,$show_all=''){
		$kode_player = '';
		if(isset($kode_post_option['team_lineup_first-player-'.esc_attr($all_team_post->ID)])){
			$kode_player = $kode_post_option['team_lineup_first-player-'.esc_attr($all_team_post->ID)];	
		}
		if($kode_player == 'enable'){
			$kode_player_goal = '';
			if(isset($kode_post_option['team_lineup_first-pg-'.esc_attr($all_team_post->ID)])){
				$kode_player_goal = $kode_post_option['team_lineup_first-pg-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_assit = '';
			if(isset($kode_post_option['team_lineup_first-ag-'.esc_attr($all_team_post->ID)])){
				$kode_player_assit = $kode_post_option['team_lineup_first-ag-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_own = '';
			if(isset($kode_post_option['team_lineup_first-og-'.esc_attr($all_team_post->ID)])){
				$kode_player_own = $kode_post_option['team_lineup_first-og-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_penality = '';
			if(isset($kode_post_option['team_lineup_first-ps-'.esc_attr($all_team_post->ID)])){
				$kode_player_penality = $kode_post_option['team_lineup_first-ps-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_pos = '';
			if(isset($kode_post_option['team_lineup_first-pos-'.esc_attr($all_team_post->ID)])){
				$kode_player_pos = $kode_post_option['team_lineup_first-pos-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_yellow = '';
			if(isset($kode_post_option['team_lineup_first-yc-'.esc_attr($all_team_post->ID)])){
				$kode_player_yellow = $kode_post_option['team_lineup_first-yc-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_red = '';
			if(isset($kode_post_option['team_lineup_first-rc-'.esc_attr($all_team_post->ID)])){
				$kode_player_red = $kode_post_option['team_lineup_first-rc-'.esc_attr($all_team_post->ID)];	
			}
			
			if($kode_player_goal == '' || $kode_player_goal == ' '){
				$kode_player_goal = 0;
			}
			
			if($kode_player_assit == '' || $kode_player_assit == ' '){
				$kode_player_assit = 0;
			}
			
			if($kode_player_own == '' || $kode_player_own == ' '){
				$kode_player_own = 0;
			}
			
			if($kode_player_penality == '' || $kode_player_penality == ' '){
				$kode_player_penality = 0;
			}
			
			if($kode_player_pos == '' || $kode_player_pos == ' '){
				$kode_player_pos = 0;
			}
			
			if($kode_player_yellow == '' || $kode_player_yellow == ' '){
				$kode_player_yellow = 0;
			}
			
			if($kode_player_red == '' || $kode_player_red == ' '){
				$kode_player_red = 0;
			}
			$html_player = '';
			if($show_all == 'Yes'){
				$html_player = '
				<tr>
					<td class="player-name-sec"><a href="'.get_permalink($all_team_post->ID).'">'.get_the_title($all_team_post->ID).'</a></td>
					<td class="player-team-opp-sec">VS <a href="'.esc_url(get_permalink($kode_post_option['select_team_second'])).'">'.esc_attr(get_the_title($kode_post_option['select_team_second'])).'</a></td>
					<td class="player-goal-sec">'.esc_attr($kode_player_goal).'</td>
					<td class="player-assist-sec">'.esc_attr($kode_player_assit).'</td>
					<td class="player-owngoal-sec">'.esc_attr($kode_player_own).'</td>
					<td class="player-penality-sec">'.esc_attr($kode_player_penality).'</td>
					<td class="player-pos-sec">'.esc_attr($kode_player_pos).'</td>
					<td class="player-yellow-sec">'.esc_attr($kode_player_yellow).'</td>
					<td class="player-redcard-sec">'.esc_attr($kode_player_red).'</td>';					
					if(!empty($category)){
						 $html_player .= '<td class="player-team-league-sec">'.esc_attr($category).'</td>';
					}
					$html_player .= '
				</tr>';
			}else{
				$html_player = '
				<tr>
					<td class="player-name-sec"><a href="'.get_permalink($all_team_post->ID).'">'.get_the_title($all_team_post->ID).'</a></td>
					<td class="player-team-opp-sec">VS <a href="'.esc_url(get_permalink($kode_post_option['select_team_second'])).'">'.esc_attr(get_the_title($kode_post_option['select_team_second'])).'</a></td>
					<td class="player-goal-sec">'.esc_attr($kode_player_goal).'</td>
					<td class="player-assist-sec">'.esc_attr($kode_player_assit).'</td>
					<td class="player-owngoal-sec">'.esc_attr($kode_player_own).'</td>
					<td class="player-penality-sec">'.esc_attr($kode_player_penality).'</td>
					<td class="player-pos-sec">'.esc_attr($kode_player_pos).'</td>
					<td class="player-yellow-sec">'.esc_attr($kode_player_yellow).'</td>
					<td class="player-redcard-sec">'.esc_attr($kode_player_red).'</td>';				
					if(!empty($category)){
						$html_player .= '<td class="player-team-league-sec">'.esc_attr($category).'</td>';
					}
					$html_player .= '
				</tr>';
				
			}
			return $html_player;
		}
	}
	
	
	function kode_show_player_lineup_second($category, $kode_post_option, $all_team_post,$show_all= ''){		
		$kode_player = '';
		if(isset($kode_post_option['team_lineup_second-player-'.esc_attr($all_team_post->ID)])){
			$kode_player = $kode_post_option['team_lineup_second-player-'.esc_attr($all_team_post->ID)];	
		}
		if($kode_player == 'enable'){
			$kode_player_goal = '';
			if(isset($kode_post_option['team_lineup_second-pg-'.esc_attr($all_team_post->ID)])){
				$kode_player_goal = $kode_post_option['team_lineup_second-pg-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_assit = '';
			if(isset($kode_post_option['team_lineup_second-ag-'.esc_attr($all_team_post->ID)])){
				$kode_player_assit = $kode_post_option['team_lineup_second-ag-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_own = '';
			if(isset($kode_post_option['team_lineup_second-og-'.esc_attr($all_team_post->ID)])){
				$kode_player_own = $kode_post_option['team_lineup_second-og-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_penality = '';
			if(isset($kode_post_option['team_lineup_second-ps-'.esc_attr($all_team_post->ID)])){
				$kode_player_penality = $kode_post_option['team_lineup_second-ps-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_pos = '';
			if(isset($kode_post_option['team_lineup_second-pos-'.esc_attr($all_team_post->ID)])){
				$kode_player_pos = $kode_post_option['team_lineup_second-pos-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_yellow = '';
			if(isset($kode_post_option['team_lineup_second-yc-'.esc_attr($all_team_post->ID)])){
				$kode_player_yellow = $kode_post_option['team_lineup_second-yc-'.esc_attr($all_team_post->ID)];	
			}
			$kode_player_red = '';
			if(isset($kode_post_option['team_lineup_second-rc-'.esc_attr($all_team_post->ID)])){
				$kode_player_red = $kode_post_option['team_lineup_second-rc-'.esc_attr($all_team_post->ID)];	
			}
			
			if($kode_player_goal == '' || $kode_player_goal == ' '){
				$kode_player_goal = 0;
			}
			
			if($kode_player_assit == '' || $kode_player_assit == ' '){
				$kode_player_assit = 0;
			}
			
			if($kode_player_own == '' || $kode_player_own == ' '){
				$kode_player_own = 0;
			}
			
			if($kode_player_penality == '' || $kode_player_penality == ' '){
				$kode_player_penality = 0;
			}
			
			if($kode_player_pos == '' || $kode_player_pos == ' '){
				$kode_player_pos = 0;
			}
			
			if($kode_player_yellow == '' || $kode_player_yellow == ' '){
				$kode_player_yellow = 0;
			}
			
			if($kode_player_red == '' || $kode_player_red == ' '){
				$kode_player_red = 0;
			}
			
			$html_player = '';
			if($show_all == 'Yes'){
				$html_player = '
				<tr>
					<td class="player-name"><a href="'.get_permalink($all_team_post->ID).'">'.get_the_title($all_team_post->ID).'</a></td>
					<td class="player-team-opp">VS <a href="'.esc_url(get_permalink($kode_post_option['select_team_first'])).'">'.esc_attr(get_the_title($kode_post_option['select_team_first'])).'</a></td>
					<td class="player-goal">'.esc_attr($kode_player_goal).'</td>
					<td class="player-assist">'.esc_attr($kode_player_assit).'</td>
					<td class="player-owngoal">'.esc_attr($kode_player_own).'</td>
					<td class="player-penality">'.esc_attr($kode_player_penality).'</td>
					<td class="player-pos">'.esc_attr($kode_player_pos).'</td>
					<td class="player-yellow">'.esc_attr($kode_player_yellow).'</td>
					<td class="player-redcard">'.esc_attr($kode_player_red).'</td>';					
					if(!empty($category)){
						 $html_player .= '<td class="player-team-league">'.esc_attr($category).'</td>';
					}
					$html_player .= '
				</tr>';
			}else{
				$html_player = '
				<tr>
					<td class="player-name"><a href="'.get_permalink($all_team_post->ID).'">'.get_the_title($all_team_post->ID).'</a></td>
					<td class="player-team-opp">VS <a href="'.esc_url(get_permalink($kode_post_option['select_team_first'])).'">'.esc_attr(get_the_title($kode_post_option['select_team_first'])).'</a></td>
					<td class="player-goal">'.esc_attr($kode_player_goal).'</td>
					<td class="player-assist">'.esc_attr($kode_player_assit).'</td>
					<td class="player-owngoal">'.esc_attr($kode_player_own).'</td>
					<td class="player-penality">'.esc_attr($kode_player_penality).'</td>
					<td class="player-pos">'.esc_attr($kode_player_pos).'</td>
					<td class="player-yellow">'.esc_attr($kode_player_yellow).'</td>
					<td class="player-redcard">'.esc_attr($kode_player_red).'</td>';				
					if(!empty($category)){
						$html_player .= '<td class="player-team-league">'.esc_attr($category).'</td>';
					}
					$html_player .= '
				</tr>';
				
			}
			return $html_player;
		}
	}
	
	
	
	
	//Team Listing
	if( !function_exists('kode_get_player_item_slider') ){
		function kode_get_player_item_slider( $settings ){
			
			// query posts section
			$args = array('post_type' => 'player', 'suppress_filters' => false);
			$args['posts_per_page'] = 100;
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;

			if( !empty($settings['category']) || (!empty($settings['tag'])) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'player_category', 'field'=>'slug'));
				}
				if( !empty($settings['tag'])){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'player_tag', 'field'=>'slug'));
				}				
			}			
			$query = new WP_Query( $args );

			// create the player filter
			
			$settings['num-title-fetch'] = empty($settings['num-title-fetch'])? '25': $settings['num-title-fetch'];
			$settings['player-column-size'] = empty($settings['player-column-size'])? '4': $settings['player-column-size'];
			
			$size = 4;
			$player = '<div class="kode-team kode-team-list col-md-12">';
			if($settings['header-title'] <> ''){
				$player .= '
				<div class="kode-maintitle kode-tstitle">
					<h2>'.esc_attr($settings['header-title']).'</h2>
				</div>';
			}
			$player  .= '
			<div data-slide="'.esc_attr($settings['player-column-size']).'" class="owl-carousel owl-theme kode-team-list next-prev-style">';
			$phone = '';
			$website = '';
			$facebook = '';
			$twitter = '';
			$youtube = '';
			$pinterest = '';
			$designation = '';
			$current_size = 0;
			while($query->have_posts()){ $query->the_post();
				global $kode_post_option,$post,$kode_post_settings;
				$player_option = kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true));
				if( !empty($player_option) ){
					$player_option = json_decode( $player_option, true );					
				}
				
				 
				// if( $current_size % $size == 0 ){
					// $player .= '<li class="clear"></li>';
				// }	
				if(isset($settings['style-layout']) && $settings['style-layout'] == 'style-1'){
				$player .= '
				 <div class="item">
				  <figure><a href="'.esc_url(get_permalink()).'" class="kode-team-thumb">'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'</a>
					<figcaption>
					  <ul class="kode-team-network-kick">';
						if(isset($player_option['facebook']) && $player_option['facebook'] <> ''){
							$player .= '<li><a href="'.esc_url($player_option['facebook']).'"><i class="fa fa-facebook"></i></a></li>';
						}
						if(isset($player_option['twitter']) && $player_option['twitter'] <> ''){
							$player .= '<li><a href="'.esc_url($player_option['twitter']).'"><i class="fa fa-twitter"></i></a></li>';
						}
						if(isset($player_option['youtube']) && $player_option['youtube'] <> ''){
							$player .= '<li><a href="'.esc_url($player_option['youtube']).'"><i class="fa fa-youtube"></i></a></li>';
						}
						if(isset($player_option['pinterest']) && $player_option['pinterest'] <> ''){
							$player .= '<li><a href="'.esc_url($player_option['pinterest']).'"><i class="fa fa-pinterest"></i></a></li>';
						}
						$player .= '
					  </ul>
					  <div class="clearfix"></div>
					  <h2><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_title()).'</a></h2>
					  <a class="kode-modren-btn thbg-colortwo" href="'.esc_url(get_permalink()).'">'.esc_attr__('View Detail','kode-player').'</a>
					</figcaption>
				  </figure>
				</div>
				';
				}else{
					$player .= '
					 <div class="item">
					  <div class="kode_football_heros_fig">
							<figure>
								'.get_the_post_thumbnail($post->ID, 'kode-blog-small-size').'
								<ul class="kode_football_heros_icon">';
									if(isset($player_option['facebook']) && $player_option['facebook'] <> ''){
										$player .= '<li><a href="'.esc_url($player_option['facebook']).'"><i class="fa fa-facebook"></i></a></li>';
									}
									if(isset($player_option['twitter']) && $player_option['twitter'] <> ''){
										$player .= '<li><a href="'.esc_url($player_option['twitter']).'"><i class="fa fa-twitter"></i></a></li>';
									}
									if(isset($player_option['youtube']) && $player_option['youtube'] <> ''){
										$player .= '<li><a href="'.esc_url($player_option['youtube']).'"><i class="fa fa-youtube"></i></a></li>';
									}
									if(isset($player_option['pinterest']) && $player_option['pinterest'] <> ''){
										$player .= '<li><a href="'.esc_url($player_option['pinterest']).'"><i class="fa fa-pinterest"></i></a></li>';
									}
									$player .= '
								</ul>
							</figure>
							<div class="kode_football_heros_caption">
								<h4>'.esc_attr(get_the_title()).'</h4>
								<h6>'.esc_attr($designation).'</h6>
							</div>
						</div>
					</div>
					';
				}
				
			}
			wp_reset_postdata();
			
			$current_size++;

			$player .= '</div></div>';
			
			return $player;
		}
	}	
	
?>