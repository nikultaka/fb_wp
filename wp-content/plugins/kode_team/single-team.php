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
								
				$team_first_img = wp_get_attachment_image_src($kode_post_option['team_logo'], 'full');?>
				
				<div class="kode-pagecontent">
					<div class="row">
						<div class="col-md-6">
							<a href="<?php echo esc_url(get_permalink());?>"><?php echo get_the_post_thumbnail($post->ID, 'blog-post')?></a>
							<!--<a href="<?php echo esc_url(get_permalink());?>" class="kode-player-thumb"><img src="<?php echo esc_url($team_first_img[0])?>" alt=""></a>-->
						</div>
						<div class="col-md-6">
							<table class="kode-table">
							<?php if(isset($kode_theme_option['general_setting']) && $kode_theme_option['general_setting'] <> ''){?>
								<caption><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['general_setting'])?></caption>
								<?php }else { ?>
									<td><?php echo esc_attr__('General Setting','kode-team');?></td>
									<?php } ?>		
								<tbody>
									<tr>
									<?php if(isset($kode_theme_option['team_name']) && $kode_theme_option['team_name'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_name'])?>:</td>
										<td><?php echo esc_attr(get_the_title())?></td>
										<?php }else { ?>
									<td><?php echo esc_attr__('Team Name','kode-team');?></td>
									<?php } ?>		
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['header_coach']) && $kode_theme_option['header_coach'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['header_coach'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['header_coach'])?></td>
									<?php }else { ?>
										<td><?php echo esc_attr__('Header Coach','kode-team');?></td>
									<?php } ?>	
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['captain']) && $kode_theme_option['captain'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['captain'])?>:</td>
										<?php if($kode_post_option['captain'] == '0'){?>
											<td><a href="#" ><?php echo esc_attr('--','kode-team')?></a></td>
										<?php } else { ?>
											<td><a href="<?php echo esc_url(get_permalink($kode_post_option['captain']));?>" ><?php echo esc_attr(get_the_title($kode_post_option['captain']))?></a></td>
										<?php
										} ?>
										<?php }else { ?>
										<td><?php echo esc_attr__('Captain','kode-team');?></td>
									<?php } ?>		
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['association']) && $kode_theme_option['association'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['association'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['association'])?></td>
									<?php }else { ?>
										<td><?php echo esc_attr__('Association','kode-team');?></td>
									<?php } ?>	
									</tr>
									<tr>
									<?php if(isset($kode_theme_option['ranking']) && $kode_theme_option['ranking'] <> ''){?>
										<td><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['ranking'])?>:</td>
										<td><?php echo esc_attr($kode_post_option['ranking'])?></td>
									<?php }else { ?>
										<td><?php echo esc_attr__('Ranking','kode-team');?></td>
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
					<div class="clearfix clear"></div>
						
					<div class="row">
						<?php if(isset($kode_theme_option['team-detail-table-1']) && $kode_theme_option['team-detail-table-1'] == 'enable'){ ?>
						<div class="team-detail-table-ap padding-bottom-30-flat col-md-12">
						<h3><?php echo get_the_title($post->ID);?> - <?php esc_html_e('Team Stats','kode-team')?></h3>
						<?php $kode_parti_events_first = kode_get_all_eventsid_by_teamid($post->ID);?>
							<table class="kode-table">
								<thead>
									<tr>
									<?php if(isset($kode_theme_option['team_tournament']) && $kode_theme_option['team_tournament'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_tournament'])?></th>
										<?php }else { ?>
										<td><?php echo esc_attr__('Tournament','kode-team');?></td>
									<?php } ?>
									<?php if(isset($kode_theme_option['team_opponent']) && $kode_theme_option['team_opponent'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_opponent'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('opponent','kode-team');?></td>
									<?php } ?>
									<?php if(isset($kode_theme_option['team_goals_settings']) && $kode_theme_option['team_goals_settings'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_goals_settings'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('Goals','kode-team');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['team_shorts_on_target']) && $kode_theme_option['team_shorts_on_target'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_shorts_on_target'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('Shorts On Target','kode-team');?></td>
									<?php } ?>
									<?php if(isset($kode_theme_option['team_corner_kick']) && $kode_theme_option['team_corner_kick'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_corner_kick'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('Corner Kicks','kode-team');?></td>
									<?php } ?>	
									<?php if(isset($kode_theme_option['team_yellow_card']) && $kode_theme_option['team_yellow_card'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_yellow_card'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('Team Yellow Cards','kode-team');?></td>
									<?php } ?>
									<?php if(isset($kode_theme_option['team_passing_accuracy']) && $kode_theme_option['team_passing_accuracy'] <> ''){?>
										<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_passing_accuracy'])?></th>
									<?php }else { ?>
									<td><?php echo esc_attr__('Passing Accuracy','kode-team');?></td>
									<?php } ?>	
									</tr>
								</thead>
								<tbody>
									<?php 	
										$kode_parti_events_first = kode_get_all_eventsid_by_teamid($post->ID);									
										$kode_post_option['select_team_first'] = $post->ID;
										$formation = 'first';
										kode_print_team_fixture_detail($kode_parti_events_first,$kode_post_option,$formation);							
									?>									
								</tbody>
							</table>
						</div>
						<?php } ?>
						<?php if(isset($kode_theme_option['team-detail-table-2']) && $kode_theme_option['team-detail-table-2'] == 'enable'){ ?>
						<div class="col-md-12">
							<h3><?php echo get_the_title($post->ID);?> - <?php esc_html_e('Players Line up','kode-team')?></h3>
							<div class="tab-pane">
								<table class="kode-table">
									<thead>
										<tr>
										<?php if(isset($kode_theme_option['team_player_name']) && $kode_theme_option['team_player_name'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_name'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Player Name','kode-team');?></td>
										<?php } ?>
										<?php if(isset($kode_theme_option['team_player_opponent']) && $kode_theme_option['team_player_opponent'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_opponent'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('opponent Name','kode-team');?></td>
										<?php } ?>
										<?php if(isset($kode_theme_option['team_player_goal']) && $kode_theme_option['team_player_goal'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_goal'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Goals','kode-team');?></td>
										<?php } ?>
										<?php if(isset($kode_theme_option['team_player_assist']) && $kode_theme_option['team_player_assist'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_assist'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Assist','kode-team');?></td>
										<?php } ?>
										<?php if(isset($kode_theme_option['team_player_own_goal']) && $kode_theme_option['team_player_own_goal'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_own_goal'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Own Goal','kode-team');?></td>
										<?php } ?>
											<?php if(isset($kode_theme_option['team_player_penalty']) && $kode_theme_option['team_player_penalty'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_penalty'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Penalty','kode-team');?></td>
										<?php } ?>
											<?php if(isset($kode_theme_option['team_player_position']) && $kode_theme_option['team_player_position'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_position'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Position','kode-team');?></td>
										<?php } ?>
											<?php if(isset($kode_theme_option['team_player_yellow_card']) && $kode_theme_option['team_player_yellow_card'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_yellow_card'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Yellow Card','kode-team');?></td>
										<?php } ?>
											<?php if(isset($kode_theme_option['team_player_red_card']) && $kode_theme_option['team_player_red_card'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_red_card'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('Red Card','kode-team');?></td>
										<?php } ?>
											<?php if(isset($kode_theme_option['team_player_league']) && $kode_theme_option['team_player_league'] <> ''){?>
											<th><?php echo sprintf(__('%s','kode-team'),$kode_theme_option['team_player_league'])?></th>
										<?php }else { ?>
											<td><?php echo esc_attr__('League','kode-team');?></td>
										<?php } ?>
										</tr>
									</thead>
									<tbody>
									<?php

										$arguments_team = array('post_type'=>'player', 'posts_per_page' => -1);
										$all_team_posts = get_posts($arguments_team);
										//print_R($all_team_posts);
										foreach($all_team_posts as $all_team_post){
										$select_national = get_post_meta($all_team_post->ID,'select_national',true);
											if($post->ID == $select_national){
												$kode_parti_events_first = kode_get_all_eventsid_by_teamid($post->ID);
												foreach($kode_parti_events_first as $parti_event){
													$args = array('orderby' => 'name', 'order' => 'DESC', 'fields' => 'all');
													$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
													foreach($get_categories as $category){		
														$event_post_data = kode_decode_stopbackslashes(get_post_meta($parti_event, 'post-option', true ));
														if( !empty($event_post_data) ){
															$event_post_data = json_decode( $event_post_data, true );					
														}
														if($event_post_data['select_team_second'] == $post->ID){
															echo kode_show_player_lineup_second($category->name,$event_post_data,$all_team_post,'Yes');	
														}else{
															echo kode_show_player_lineup_first($category->name,$event_post_data,$all_team_post,'Yes');	
														}
													}
												}

											}											
										}
									?>
									</tbody>
								</table>									
							</div>
						</div>
						<?php } ?>	
					</div>
					<!--Team Members -->
					<div class="kode-editor">
						<?php the_content();?>
					</div>                
				</div>
				<!-- Blog Detail -->
				<?php comments_template( '', true ); ?>
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