<?php get_header(); ?>
<div class="content">
	<div class="container">
		<div class="row">
		<?php 
			global $kode_sidebar, $kode_theme_option,$kode_post_option;
			$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($kode_post_option) ){
				$kode_post_option = json_decode( $kode_post_option, true );					
			}
			if( empty($kode_post_option['sidebar']) || $kode_post_option['sidebar'] == 'default-sidebar' ){
				$kode_sidebar = array(
					'type'=>$kode_theme_option['post-sidebar-template'],
					'left-sidebar'=>$kode_theme_option['post-sidebar-left'], 
					'right-sidebar'=>$kode_theme_option['post-sidebar-right']
				); 
			}else{
				$kode_sidebar = array(
					'type'=>$kode_post_option['sidebar'],
					'left-sidebar'=>$kode_post_option['left-sidebar'], 
					'right-sidebar'=>$kode_post_option['right-sidebar']
				); 				
			}
			$kode_sidebar = kode_get_sidebar_class($kode_sidebar);
			
			if(is_active_sidebar($kode_sidebar['left'])){
				if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'left-sidebar'){ ?>
					<div class="<?php echo esc_attr($kode_sidebar['left'])?>">
						<?php get_sidebar('left'); ?>
					</div>	
				<?php }
			}
			?>
			<div class="kode-item  <?php echo esc_attr($kode_sidebar['center'])?>">
			<?php while ( have_posts() ){ the_post(); 
				global $EM_Event,$post;
				$event_year = esc_attr(date('Y',$EM_Event->start));
				$event_month = esc_attr(date('m',$EM_Event->start));
				$event_day = esc_attr(date('d',$EM_Event->start));
				$event_start_time = esc_attr(date("H:i:s", strtotime($EM_Event->start_time)));			
				$location = '';
				if(isset($EM_Event->get_location()->address)){
					$location = esc_attr($EM_Event->get_location()->address);
				}else{
					$location = '';				
				}
				
				$location_town = '';
				if(isset($EM_Event->get_location()->address)){
					$location_town = $EM_Event->get_location()->town;
				}else{
					$location_town = '';				
				}
				
				$kode_team_option_first = json_decode(kode_decode_stopbackslashes(get_post_meta($kode_post_option['select_team_first'], 'post-option', true)));
				$kode_team_option_second = json_decode(kode_decode_stopbackslashes(get_post_meta($kode_post_option['select_team_second'], 'post-option', true)));
				$start_time = date(get_option('time_format'),strtotime($EM_Event->start_time));
				$end_time = date(get_option('time_format'),strtotime($EM_Event->end_time));	?>
				<div class="event-detail">
					<div class="row">
						<div class="col-md-12">
							<div class="kode-detail-element">
								<h2><?php echo esc_attr(get_the_title());?></h2>
								<?php kode_get_social_shares()?>
							</div>
							<div class="kode-inner-fixer">
								<div class="kode-team-match">
									<ul>										
									<?php 
									if(!empty($kode_team_option_first)){
										$team_first_img = wp_get_attachment_image_src($kode_team_option_first->team_logo, 'full');
										$team_second_img = wp_get_attachment_image_src($kode_team_option_second->team_logo, 'full');
									}else{
										$team_first_img = array();
										$team_second_img = array();
									}?>
										<li><a href="<?php echo esc_url(get_permalink($kode_post_option['select_team_first']))?>"><img src="<?php echo esc_url($team_first_img[0]);?>" /></a></li>
										<li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="<?php echo esc_url($EM_Event->guid);?>">vs</a></li>
										<li><a href="<?php echo esc_url(get_permalink($kode_post_option['select_team_second']))?>"><img src="<?php echo esc_url($team_second_img[0]);?>" /></a></li>
									</ul>
									<div class="clearfix"></div>
									<h3><?php echo esc_attr(get_the_title());?></h3>
									<span class="kode-subtitle"><?php echo esc_attr($location_town);?> - 
									<?php echo esc_attr(date(get_option('date_format'),$EM_Event->start));?> 
									<?php 
									if($EM_Event->event_all_day <> 1){ 
										echo esc_attr($start_time);
										echo __('to','kickoff');
										echo esc_attr($end_time); 
									}else{
										esc_html_e('All Day','kickoff'); 
										$start_time = '12:00'; 
										$end_time = '12:00'; 
									} 
									?></span>
								</div>
							</div>
						</div>
					</div>
					<?php 
					$kode_parti_events_first = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_first']);
					$kode_parti_events_second = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_second']); 
					?>
					<div class="kode-player-tabs">
						<div class="row">
						<?php if(isset($kode_theme_option['single-team-performance-one']) && $kode_theme_option['single-team-performance-one'] == 'enable'){ ?>	
							<div class="col-md-12 col-lg-6">
							<?php if(isset($kode_theme_option['team_performance_1']) && $kode_theme_option['team_performance_1'] <> ''){?> 
								<h3><?php echo get_the_title($kode_post_option['select_team_first']);?> - <?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_1'])?></h3>
							<?php }else { ?>	
								<td><?php echo esc_attr__('Team Performance','kickoff');?></td>
							<?php } ?>	
								<div class="tab-pane" role="tabpanel">
									<table class="kode-table">
										<thead>
											<tr>
												<?php if(isset($kode_theme_option['team_performance_team_1']) && $kode_theme_option['team_performance_team_1'] <> ''){?> 
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Team','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_performance_team_1_match']) && $kode_theme_option['team_performance_team_1_match'] <> ''){?> 
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_match'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Matches','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_1_goal']) && $kode_theme_option['team_performance_team_1_goal'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Goals','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_1_won']) && $kode_theme_option['team_performance_team_1_won'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_won'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Won','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_1_lost']) && $kode_theme_option['team_performance_team_1_lost'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_lost'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Lost','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_1_draw']) && $kode_theme_option['team_performance_team_1_draw'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_draw'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Draw','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_1_pts']) && $kode_theme_option['team_performance_team_1_pts'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_1_pts'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('PTS+/-','kickoff');?></td>
											<?php } ?>		
											</tr>
										</thead>
										<tbody>
											<?php
											$team_win_result = kode_get_result_team_won($kode_post_option['select_team_first'], 'won');
											$team_lost_result = kode_get_result_team_won($kode_post_option['select_team_first'], 'loss');
											$team_draw_result = kode_get_result_team_won($kode_post_option['select_team_first'], 'draw');
											
											echo '<tr>';
										
											
											
											
											
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
											
											$team_loss = count($team_lost_result['select_team']);
											$team_won = count($team_win_result['select_team']);
											$team_draw = count($team_draw_result['select_team']);
											if(empty($team_draw_result['select_team'])){
												if(empty($team_lost_result['select_team'])){
													$total_matches = $team_win_result['select_team'];	
												}else if(empty($team_win_result['select_team'])){
													$total_matches = $team_lost_result['select_team'];	
												}else{
													$total_matches = array_merge($team_lost_result['select_team'],$team_win_result['select_team']);		
												}
											}else if(empty($team_lost_result['select_team'])){
												$total_matches = @array_merge($team_draw_result['select_team'],$team_win_result['select_team']);	
											}else if(empty($team_win_result['select_team'])){
												$total_matches = @array_merge($team_draw_result['select_team'],$team_lost_result['select_team']);	
											}else{
												$total_matches = @array_merge($team_draw_result['select_team'], $team_lost_result['select_team'],$team_win_result['select_team']);	
											}										
											$total_matches = count($total_matches);
											$formulla = 4/4.0*0+2*$team_won/2*$total_matches;
											
											
											
											echo '<td><a href="'.esc_url(get_permalink($kode_post_option['select_team_first'])).'">'.get_the_title($kode_post_option['select_team_first']).'</a></td>';
											echo '<td>'.$total_matches.'</td>';
											echo '<td>'.$total_goals.'</td>';
											echo '<td>'.$team_won.'</td>';
											echo '<td>'.$team_loss.'</td>';
											echo '<td>'.$team_draw.'</td>';
											echo '<td>'.$formulla.'</td>';
											
											?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						<?php } ?>	
						<?php if(isset($kode_theme_option['single-team-performance-two']) && $kode_theme_option['single-team-performance-two'] == 'enable'){ ?>	
							<div class="col-md-12 col-lg-6">
							<?php if(isset($kode_theme_option['team_performance_2']) && $kode_theme_option['team_performance_2'] <> ''){?> 
								<h3><?php echo get_the_title($kode_post_option['select_team_second']);?> - <?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_2'])?></h3>
								<?php }else { ?>	
									<td><?php echo esc_attr__('Team Performance','kickoff');?></td>
								<?php } ?>
								<div class="tab-pane" role="tabpanel">
									<table class="kode-table">
										<thead>
											<tr>
											<?php if(isset($kode_theme_option['team_performance_team_2']) && $kode_theme_option['team_performance_team_2'] <> ''){?> 
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Team','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_performance_team_2_match']) && $kode_theme_option['team_performance_team_2_match'] <> ''){?> 
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_match'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Matches','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_2_goal']) && $kode_theme_option['team_performance_team_2_goal'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Goals','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_2_won']) && $kode_theme_option['team_performance_team_2_won'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_won'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Won','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_2_lost']) && $kode_theme_option['team_performance_team_2_lost'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_lost'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Lost','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_2_draw']) && $kode_theme_option['team_performance_team_2_draw'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_draw'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Draw','kickoff');?></td>
											<?php } ?>		
											<?php if(isset($kode_theme_option['team_performance_team_2_pts']) && $kode_theme_option['team_performance_team_2_pts'] <> ''){?> 	
												<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_performance_team_2_pts'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('PTS+/-','kickoff');?></td>
											<?php } ?>		
											</tr>
										</thead>
										<tbody>
										<?php
										echo '<tr>';
										
										
										$team_win_result = kode_get_result_team_won($kode_post_option['select_team_second'], 'won');
										$team_lost_result = kode_get_result_team_won($kode_post_option['select_team_second'], 'loss');
										$team_draw_result = kode_get_result_team_won($kode_post_option['select_team_second'], 'draw');
										
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
										
										$team_loss = count($team_lost_result['select_team']);
										$team_won = count($team_win_result['select_team']);
										$team_draw = count($team_draw_result['select_team']);
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
										$total_matches = count($total_matches);
										$formulla = 4/4.0*0+2*$team_won/2*$total_matches;
										
										
										
										echo '<td><a href="'.esc_url(get_permalink($kode_post_option['select_team_second'])).'">'.get_the_title($kode_post_option['select_team_second']).'</a></td>';
										echo '<td>'.$total_matches.'</td>';
										echo '<td>'.$total_goals.'</td>';
										echo '<td>'.$team_won.'</td>';
										echo '<td>'.$team_loss.'</td>';
										echo '<td>'.$team_draw.'</td>';
										echo '<td>'.$formulla.'</td>';
										
										?>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						<?php } ?>
						<?php if(isset($kode_theme_option['team-player-line-up-one']) && $kode_theme_option['team-player-line-up-one'] == 'enable'){ ?>			
							<div class="col-md-12">
							<?php if(isset($kode_theme_option['team_player_line_1']) && $kode_theme_option['team_player_line_1'] <> ''){?> 
								<h3><?php echo get_the_title($kode_post_option['select_team_first']);?> - <?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1'])?></h3>
								<?php }else { ?>	
									<td><?php echo esc_attr__('Player Line Up','kickoff');?></td>
								<?php } ?>
								<div class="tab-pane">
									<?php
									
									if(isset($kode_post_option['player-opponent']) && $kode_post_option['player-opponent'] == 'disable'){
										echo '<style scoped>.player-team-opp, .player-team-opp-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-goals']) && $kode_post_option['player-goals'] == 'disable'){
										echo '<style scoped>.player-goal, .player-goal-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-assist']) && $kode_post_option['player-assist'] == 'disable'){
										echo '<style scoped>.player-assist, .player-assist-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-own_goal']) && $kode_post_option['player-own_goal'] == 'disable'){
										echo '<style scoped>.player-owngoal, .player-owngoal-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-penalty']) && $kode_post_option['player-penalty'] == 'disable'){
										echo '<style scoped>.player-penality, .player-penality-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-position']) && $kode_post_option['player-position'] == 'disable'){
										echo '<style scoped>.player-pos, .player-pos-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-yellow-card']) && $kode_post_option['player-yellow-card'] == 'disable'){
										echo '<style scoped>.player-yellow, .player-yellow-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-red-card']) && $kode_post_option['player-red-card'] == 'disable'){
										echo '<style scoped>.player-redcard, .player-redcard-sec{display:none}</style>';
									}	
									
								?>
									<table class="kode-table">
										<thead>
											<tr>
											<?php if(isset($kode_theme_option['team_player_line_1_player_name']) && $kode_theme_option['team_player_line_1_player_name'] <> ''){?> 
												<th class="player-name-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_player_name'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Player Name','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_opponent']) && $kode_theme_option['team_player_line_1_opponent'] <> ''){?> 	
												<th class="player-team-opp-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_opponent'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Opponent','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_goal']) && $kode_theme_option['team_player_line_1_goal'] <> ''){?> 	
												<th class="player-goal-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Goals','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_assist']) && $kode_theme_option['team_player_line_1_assist'] <> ''){?> 	
												<th class="player-assist-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_assist'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Assist','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_own_goal']) && $kode_theme_option['team_player_line_1_own_goal'] <> ''){?> 	
												<th class="player-owngoal-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_own_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Own Goals','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_penalty']) && $kode_theme_option['team_player_line_1_penalty'] <> ''){?> 	
												<th class="player-penality-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_penalty'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Penalty','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_position']) && $kode_theme_option['team_player_line_1_position'] <> ''){?> 	
												<th class="player-pos-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_position'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Position','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_yellow_card']) && $kode_theme_option['team_player_line_1_yellow_card'] <> ''){?> 	
												<th class="player-yellow-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_yellow_card'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Yellow Card','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_1_red_card']) && $kode_theme_option['team_player_line_1_red_card'] <> ''){?> 	
												<th class="player-redcard-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_1_red_card'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Red Card','kickoff');?></td>
											<?php } ?>
												<!--<th class="player-team-league-sec">League</th>-->
											</tr>
										</thead>
										<tbody>									
										<?php
										
										$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
										$all_team_posts = get_posts($arguments_team);
										
										foreach($all_team_posts as $all_team_post){
											if(isset($kode_post_option['team_lineup_first-name-'.$all_team_post->ID]) && $kode_post_option['team_lineup_first-name-'.$all_team_post->ID] == $all_team_post->ID){
												echo kode_show_player_lineup_first($category="",$kode_post_option,$all_team_post,'no');
											}											
										}
										?>
										</tbody>
									</table>									
								</div>
							</div>
						<?php } ?>
						<?php if(isset($kode_theme_option['team-player-line-up-two']) && $kode_theme_option['team-player-line-up-two'] == 'enable'){ ?>		
							<div class="col-md-12">
							<?php if(isset($kode_theme_option['team_player_line_2']) && $kode_theme_option['team_player_line_2'] <> ''){?> 
								<h3><?php echo get_the_title($kode_post_option['select_team_second']);?> - <?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2'])?></h3>
								<?php }else { ?>	
									<td><?php echo esc_attr__('Player Line Up','kickoff');?></td>
								<?php } ?>
								<div class="tab-pane">
									<?php
									if(isset($kode_post_option['player-opponent']) && $kode_post_option['player-opponent'] == 'disable'){
										echo '<style scoped>.player-team-opp, .player-team-opp-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-goals']) && $kode_post_option['player-goals'] == 'disable'){
										echo '<style scoped>.player-goal, .player-goal-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-assist']) && $kode_post_option['player-assist'] == 'disable'){
										echo '<style scoped>.player-assist, .player-assist-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-own_goal']) && $kode_post_option['player-own_goal'] == 'disable'){
										echo '<style scoped>.player-owngoal, .player-owngoal-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-penalty']) && $kode_post_option['player-penalty'] == 'disable'){
										echo '<style scoped>.player-penality, .player-penality-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-position']) && $kode_post_option['player-position'] == 'disable'){
										echo '<style scoped>.player-pos, .player-pos-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-yellow-card']) && $kode_post_option['player-yellow-card'] == 'disable'){
										echo '<style scoped>.player-yellow, .player-yellow-sec{display:none}</style>';
									}
									
									if(isset($kode_post_option['player-red-card']) && $kode_post_option['player-red-card'] == 'disable'){
										echo '<style scoped>.player-redcard, .player-redcard-sec{display:none}</style>';
									}								
								?>
									<table class="kode-table">
										<thead>
											<tr>
											<?php if(isset($kode_theme_option['team_player_line_2_player_name']) && $kode_theme_option['team_player_line_2_player_name'] <> ''){?> 
												<th class="player-name-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_player_name'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Player Name','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_opponent']) && $kode_theme_option['team_player_line_2_opponent'] <> ''){?> 
												<th class="player-team-opp-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_opponent'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Opponent','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_goal']) && $kode_theme_option['team_player_line_2_goal'] <> ''){?> 	
												<th class="player-goal-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Goals','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_assist']) && $kode_theme_option['team_player_line_2_assist'] <> ''){?> 	
												<th class="player-assist-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_assist'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Assist','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_own_goal']) && $kode_theme_option['team_player_line_2_own_goal'] <> ''){?> 	
												<th class="player-owngoal-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_own_goal'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Own Goals','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_penalty']) && $kode_theme_option['team_player_line_2_penalty'] <> ''){?> 	
												<th class="player-penality-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_penalty'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Penalty','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_position']) && $kode_theme_option['team_player_line_2_position'] <> ''){?> 	
												<th class="player-pos-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_position'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Position','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_yellow_card']) && $kode_theme_option['team_player_line_2_yellow_card'] <> ''){?> 	
												<th class="player-yellow-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_yellow_card'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Yellow Card','kickoff');?></td>
											<?php } ?>	
											<?php if(isset($kode_theme_option['team_player_line_2_red_card']) && $kode_theme_option['team_player_line_2_red_card'] <> ''){?> 	
												<th class="player-redcard-sec"><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_player_line_2_red_card'])?></th>
											<?php }else { ?>	
												<td><?php echo esc_attr__('Red Card','kickoff');?></td>
											<?php } ?>	
												<!--<th class="player-team-league-sec">League</th>-->
											</tr>
										</thead>
										<tbody>			
										<?php
										
										$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
										$all_team_posts = get_posts($arguments_team);
										//print_R($all_team_posts);
										foreach($all_team_posts as $all_team_post){
											if(isset($kode_post_option['team_lineup_second-name-'.$all_team_post->ID]) && $kode_post_option['team_lineup_second-name-'.$all_team_post->ID] == $all_team_post->ID){
												echo kode_show_player_lineup_second($category="",$kode_post_option,$all_team_post);
											}
										}
										?>
										</tbody>
									</table>									
								</div>
							</div>
						<?php } ?>
						</div>
					
						<!-- Nav tabs -->
						<ul role="tablist" class="player-nav">
							<li class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="hometwo" href="#hometwo" aria-expanded="true"><?php echo get_the_title($kode_post_option['select_team_first']);?></a></li>
							<li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="profiletwo" href="#profiletwo" aria-expanded="false"><?php echo get_the_title($kode_post_option['select_team_second']);?></a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div id="hometwo" class="tab-pane active" role="tabpanel">
								<table class="kode-table">
									<thead>
										<tr>
										<?php if(isset($kode_theme_option['team_result_1_tournment']) && $kode_theme_option['team_result_1_tournment'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_tournment'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Tournament','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_opponent']) && $kode_theme_option['team_result_1_opponent'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_opponent'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('opponent','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_goals']) && $kode_theme_option['team_result_1_goals'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_goals'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Goals','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_target']) && $kode_theme_option['team_result_1_target'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_target'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Short On Target','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_corner_kick']) && $kode_theme_option['team_result_1_corner_kick'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_corner_kick'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Corner Kick','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_yellow_card']) && $kode_theme_option['team_result_1_yellow_card'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_yellow_card'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Yellow Card','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_1_red_card']) && $kode_theme_option['team_result_1_red_card'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_1_red_card'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Red Cards','kickoff');?></td>
										<?php } ?>	
										</tr>
									</thead>
									<tbody>
									<?php 	
									$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
									if( !empty($kode_post_option) ){
										$kode_post_option = json_decode( $kode_post_option, true );					
									}
									$kode_parti_events_first = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_first']);
									$kode_parti_events_second = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_second']); 
									kode_print_team_fixture_detail($kode_parti_events_first,$kode_post_option,'first');
									//kode_print_team_fixture_detail($event_post_data,$event_post_data->select_team_second);
									?>									
									</tbody>
								</table>
							</div>
							
							<div id="profiletwo" class="tab-pane" role="tabpanel">
								<table class="kode-table">
									<thead>
										<tr>
											<?php if(isset($kode_theme_option['team_result_2_tournment']) && $kode_theme_option['team_result_2_tournment'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_tournment'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Tournament','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_opponent']) && $kode_theme_option['team_result_2_opponent'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_opponent'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('opponent','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_goals']) && $kode_theme_option['team_result_2_goals'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_goals'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Goals','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_target']) && $kode_theme_option['team_result_2_target'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_target'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Short On Target','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_corner_kick']) && $kode_theme_option['team_result_2_corner_kick'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_corner_kick'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Corner Kick','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_yellow_card']) && $kode_theme_option['team_result_2_yellow_card'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_yellow_card'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Yellow Card','kickoff');?></td>
										<?php } ?>	
										<?php if(isset($kode_theme_option['team_result_2_red_card']) && $kode_theme_option['team_result_2_red_card'] <> ''){?> 
											<th><?php echo sprintf(__('%s','kickoff'),$kode_theme_option['team_result_2_red_card'])?></th>
										<?php }else { ?>	
											<td><?php echo esc_attr__('Red Cards','kickoff');?></td>
										<?php } ?>	
										</tr>
									</thead>
									<tbody>
									<?php 	
									$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
									if( !empty($kode_post_option) ){
										$kode_post_option = json_decode( $kode_post_option, true );					
									}
									$kode_parti_events_first = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_first']);									
									$kode_parti_events_second = kode_get_all_eventsid_by_teamid($kode_post_option['select_team_second']); 									
									
									kode_print_team_fixture_detail($kode_parti_events_second,$kode_post_option,'second');
									?>									
									</tbody>
								</table>							
							</div>
						</div>
					</div>
					<div class="kode-editor">
						<?php $content = str_replace(']]>', ']]&gt;',$EM_Event->post_content); ?>
						<?php echo do_shortcode($content); ?>
					</div>
					<?php if(isset($kode_theme_option['single-event-booking']) && $kode_theme_option['single-event-booking'] == 'enable'){ ?>
					<h3><?php echo esc_attr__('Booking Form','kickoff')?></h3>
					<?php kode_booking_form_event_manager();?>
					<?php 
					$EM_Tickets = $EM_Event->get_tickets();
					?>
					<?php } ?>
				</div>
				<?php if(isset($kode_theme_option['single-event-comments']) && $kode_theme_option['single-event-comments'] == 'enable'){ ?>
				<!-- Blog Detail -->
				<?php comments_template( '', true ); ?>
				<?php } ?>
			<?php } ?>
			</div>
			<?php
			if(is_active_sidebar($kode_sidebar['right'])){
				if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'right-sidebar' && $kode_sidebar['right'] != ''){ ?>
					<div class="<?php echo esc_attr($kode_sidebar['right'])?>">
						<?php get_sidebar('right'); ?>
					</div>	
				<?php }
			}
			?>
		</div><!-- Row -->	
	</div><!-- Container -->		
</div><!-- content -->
<?php get_footer(); ?>