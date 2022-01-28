<?php get_header(); ?>
<div class="content">
	<div class="container">
		<div class="row">
		<?php 
			global $kode_sidebar, $kode_theme_option,$kode_countries,$kode_post_option;
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
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'left-sidebar'){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['left'])?>">
					<?php get_sidebar('left'); ?>
				</div>	
			<?php } ?>
			<div class="kode-item  <?php echo esc_attr($kode_sidebar['center'])?>">
			<?php while ( have_posts() ){ the_post(); ?>
				<div class="kode-pagecontent">
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo esc_url(get_permalink());?>"><?php echo get_the_post_thumbnail($post->ID, 'kode-team-size')?></a>
						</div>
						<div class="col-md-8">
							<table class="kode-table">
								<caption>
								<?php 
									if(isset($kode_theme_option['personal_info']) && $kode_theme_option['personal_info'] <> ''){
										echo esc_attr(get_the_title())?> - <?php echo sprintf(__('%s','kode-player'),$kode_theme_option['personal_info']);
									}else{
										echo esc_attr(get_the_title())?> - <?php echo esc_attr__('Personal Info','kode-player');
									}
								?></caption>
								<tbody>
									<tr>
									<?php if(isset($kode_theme_option['date_of_birth']) && $kode_theme_option['date_of_birth'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['date_of_birth'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['date_of_birth'])?></td>
									<?php }else { ?>
										<td><?php echo esc_attr__('Date Of Birth','kode-player');?></td>
									<?php } ?>
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['place_of_birth']) && $kode_theme_option['place_of_birth'] <> ''){?> 
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['place_of_birth'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['place_of_birth'])?></td>
									<?php }else { ?>
										<td><?php echo esc_attr__('Place Of Birth','kode-player');?></td>
									<?php } ?>	
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['nationality']) && $kode_theme_option['nationality'] <> ''){?> 
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['nationality'])?>:</td>
										<?php $country = kode_get_country_array();?>
										<td><?php echo esc_attr($country[$kode_post_option['nationality']])?></td>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Nationality','kode-player');?></td>
									<?php } ?>	
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['select_national']) && $kode_theme_option['select_national'] <> ''){?> 
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['select_national'])?>:</td>
										<td><?php echo esc_attr(get_the_title($kode_post_option['select_national']))?></td>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Select Team','kode-player');?></td>
									<?php } ?>		
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['height']) && $kode_theme_option['height'] <> ''){?> 
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['height'])?>:</td>										
										<td><?php echo esc_attr($kode_post_option['height'])?></td>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Height','kode-player');?></td>
									<?php } ?>	
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['position']) && $kode_theme_option['position'] <> ''){?> 
										<td><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['position'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['position'])?></td>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Position','kode-player');?></td>
									<?php } ?>	
									</tr>									
								</tbody>
							</table>
						</div>
					</div>
				   <div class="kode-detail-element">
                        <h2><?php echo esc_attr(get_the_title());?></h2>
                        <?php kode_get_social_shares()?>
                   </div>
					<?php if(isset($kode_theme_option['player-detail-table-1']) && $kode_theme_option['player-detail-table-1'] == 'enable'){?>		
					<div class="team-detail-table-ap padding-bottom-30-flat">
						<?php if(isset($kode_theme_option['player_stats_while_tournaments']) && $kode_theme_option['player_stats_while_tournaments'] <> ''){?> 
						<h3><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['player_stats_while_tournaments'])?></h3>
						<?php }else { ?>	
							<td><?php echo esc_attr__('Player Stats While Tournaments','kode-player');?></td>
						<?php } ?>	
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
								<?php if(isset($kode_theme_option['single_player_name']) && $kode_theme_option['single_player_name'] <> ''){?> 
									<th class="player-name-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_name'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Player Name','kode-player');?></td>
								<?php } ?>
								<?php if(isset($kode_theme_option['single_player_opponent']) && $kode_theme_option['single_player_opponent'] <> ''){?> 
									<th class="player-team-opp-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_opponent'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Opponent','kode-player');?></td>
								<?php } ?>	
								<?php if(isset($kode_theme_option['single_player_goals']) && $kode_theme_option['single_player_goals'] <> ''){?> 
									<th class="player-goal-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_goals'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Goals','kode-player');?></td>
								<?php } ?>	
								<?php if(isset($kode_theme_option['single_player_assist']) && $kode_theme_option['single_player_assist'] <> ''){?> 
									<th class="player-assist-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_assist'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Assist','kode-player');?></td>
								<?php } ?>		
								<?php if(isset($kode_theme_option['single_player_own_goal']) && $kode_theme_option['single_player_own_goal'] <> ''){?> 
									<th class="player-owngoal-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_own_goal'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Own Goal','kode-player');?></td>
								<?php } ?>			
								<?php if(isset($kode_theme_option['single_player_penalty']) && $kode_theme_option['single_player_penalty'] <> ''){?> 
									<th class="player-penality-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_penalty'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Penalty','kode-player');?></td>
								<?php } ?>				
								<?php if(isset($kode_theme_option['single_player_position']) && $kode_theme_option['single_player_position'] <> ''){?> 
									<th class="player-pos-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_position'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Position','kode-player');?></td>
								<?php } ?>	
								<?php if(isset($kode_theme_option['single_player_yellow_card']) && $kode_theme_option['single_player_yellow_card'] <> ''){?> 
									<th class="player-yellow-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_yellow_card'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Yellow Card','kode-player');?></td>
								<?php } ?>	
								<?php if(isset($kode_theme_option['single_player_red_card']) && $kode_theme_option['single_player_red_card'] <> ''){?> 
									<th class="player-redcard-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_red_card'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('Red Card','kode-player');?></td>
								<?php } ?>	
								<?php if(isset($kode_theme_option['single_player_league']) && $kode_theme_option['single_player_league'] <> ''){?> 
									<th class="player-team-league-sec"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_league'])?></th>
								<?php }else { ?>	
										<td><?php echo esc_attr__('League','kode-player');?></td>
								<?php } ?>		
								</tr>
							</thead>
							<tbody>
							<?php 		
							$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
							$all_team_posts = get_posts($arguments_team);
							//print_R($all_team_posts);
							foreach($all_team_posts as $all_team_post){
								if($all_team_post->ID == $post->ID){
									$select_national = get_post_meta($all_team_post->ID,'select_national',true);
									if($kode_post_option['select_national'] == $select_national){
										$kode_parti_events_first = kode_get_all_eventsid_by_teamid($kode_post_option['select_national']);
										foreach($kode_parti_events_first as $parti_event){
											$args = array('orderby' => 'name', 'order' => 'DESC', 'fields' => 'all');
											$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
											foreach($get_categories as $category){												
												$event_post_data = kode_decode_stopbackslashes(get_post_meta($parti_event, 'post-option', true ));
												if( !empty($event_post_data) ){
													$event_post_data = json_decode( $event_post_data, true );					
												}
												if($event_post_data['select_team_second'] == $kode_post_option['select_national']){
													echo kode_show_player_lineup_second($category->name,$event_post_data,$all_team_post,'Yes');	
												}else{
													echo kode_show_player_lineup_first($category->name,$event_post_data,$all_team_post,'Yes');	
												}
											}
										}
									}	
								}								
							}
							?>									
							</tbody>
						</table>
						<div class="team_stats">
							<?php if(isset($kode_theme_option['player_tournaments_played']) && $kode_theme_option['player_tournaments_played'] <> ''){?> 
						<h3><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['player_tournaments_played'])?></h3>
						<?php }else { ?>	
							<td><?php echo esc_attr__('Tournament Played In','kode-player');?></td>
						<?php } ?>	
							<?php						
							if(isset($kode_post_option['team-goals']) && $kode_post_option['team-goals'] == 'disable'){
								echo '<style scoped>.league-team-score-first,.league-team-score-second{display:none}</style>';
							}
							
							if(isset($kode_post_option['team-sot']) && $kode_post_option['team-sot'] == 'disable'){
								echo '<style scoped>.league-team-target-first, .league-team-target-second{display:none}</style>';
							}
							
							if(isset($kode_post_option['team-ck']) && $kode_post_option['team-ck'] == 'disable'){
								echo '<style scoped>.league-team-ck-first, .league-team-ck-second{display:none}</style>';
							}
							
							if(isset($kode_post_option['team-yc']) && $kode_post_option['team-yc'] == 'disable'){
								echo '<style scoped>.league-team-rc-first,.league-team-rc-second{display:none}</style>';
							}
							if(isset($kode_post_option['team-pa']) && $kode_post_option['team-pa'] == 'disable'){
								echo '<style scoped>.league-possession-first, .league-possession-second{display:none}</style>';
							}
							
							?>
							<?php $kode_parti_events_first = kode_get_all_eventsid_by_teamid($kode_post_option['select_national']);?>
							<table class="kode-table">
								<thead>
									<tr>
									<?php if(isset($kode_theme_option['single_player_tornament_in']) && $kode_theme_option['single_player_tornament_in'] <> ''){?> 
										<th class="league-name-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_tornament_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Tournament','kode-player');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['single_player_opponent_in']) && $kode_theme_option['single_player_opponent_in'] <> ''){?> 
										<th class="league-team-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_opponent_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Opponent','kode-player');?></td>
									<?php } ?>
									<?php if(isset($kode_theme_option['single_player_goals_in']) && $kode_theme_option['single_player_goals_in'] <> ''){?> 
										<th class="league-team-score-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_goals_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Goals','kode-player');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['single_player_short_in']) && $kode_theme_option['single_player_short_in'] <> ''){?> 
										<th class="league-team-target-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_short_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Shorts On Target','kode-player');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['single_player_corner_kick_in']) && $kode_theme_option['single_player_corner_kick_in'] <> ''){?> 
										<th class="league-team-ck-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_corner_kick_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Corner Kicks','kode-player');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['single_player_yellow_card_in']) && $kode_theme_option['single_player_yellow_card_in'] <> ''){?> 
										<th class="league-team-rc-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_yellow_card_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Yellow Card','kode-player');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['single_player_passing_in']) && $kode_theme_option['single_player_passing_in'] <> ''){?> 
										<th class="league-possession-first"><?php echo sprintf(__('%s','kode-player'),$kode_theme_option['single_player_passing_in'])?></th>
									<?php }else { ?>	
										<td><?php echo esc_attr__('Passing Accuracy','kode-player');?></td>
									<?php } ?>	
									</tr>
								</thead>
								<tbody>
								<?php 		
								$kode_post_option['select_team_first'] = $kode_post_option['select_national'];
								kode_print_team_fixture_detail($kode_parti_events_first,$kode_post_option,'first');
								?>									
								</tbody>
							</table>
						</div>
                     </div>	
					<?php } ?>	
					<!--Team Members -->
					<div class="kode-editor">
						<?php 						
							echo '<div class="kode-blog-content">';
							echo kode_content_filter(get_the_content(), true);
							wp_link_pages( array( 
								'before' => '<div class="page-links"><span class="page-links-title">' . esc_attr__( 'Pages:', 'kode-player' ) . '</span>', 
								'after' => '</div>', 
								'link_before' => '<span>', 
								'link_after' => '</span>' )
							);
							echo '</div>';
						?>
					</div>  
											
                </div>

				<!-- Blog Detail -->
				<?php comments_template( '', true ); ?>
			<?php } ?>
			</div>
			<?php
			if($kode_sidebar['type'] == 'both-sidebar' || $kode_sidebar['type'] == 'right-sidebar' && $kode_sidebar['right'] != ''){ ?>
				<div class="<?php echo esc_attr($kode_sidebar['right'])?>">
					<?php get_sidebar('right'); ?>
				</div>	
			<?php } ?>
		</div><!-- Row -->	
	</div><!-- Container -->		
</div><!-- content -->
<?php get_footer(); ?>