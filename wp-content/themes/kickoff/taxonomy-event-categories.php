<?php get_header(); ?>
<div class="content">
	<div class="container">
		<div class="row">
		<?php 
			global $kode_sidebar, $kode_theme_option;
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
			global $EM_Event;
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
			$kode_post_option['ball_possession_team_first'];

			$start_time = date(get_option('time_format'),strtotime($EM_Event->start_time));
			$end_time = date(get_option('time_format'),strtotime($EM_Event->end_time));
			
			?>
				<div class="event-detail">
					<div class="row">
						<div class="col-md-12">
							<div class="kode-detail-element">
								<h2><?php echo esc_attr(get_the_title());?></h2>
								<ul class="kode-team-network-kick">
									<li><a href="#" class="fa fa-facebook"></a></li>
									<li><a href="#" class="fa fa-twitter"></a></li>
									<li><a href="#" class="fa fa-linkedin"></a></li>
								</ul>
							</div>
							<div class="kode-inner-fixer">
								<div class="kode-team-match">
									<ul>										
									<?php 
									$team_first_img = wp_get_attachment_image_src($kode_team_option_first->team_logo, 'full');
									$team_second_img = wp_get_attachment_image_src($kode_team_option_second->team_logo, 'full');
									 ?>
										<li><a href="<?php echo esc_url(get_permalink($kode_post_option['select_team_first']))?>"><img src="<?php echo esc_url($team_first_img[0]);?>" /></a></li>
										<li class="home-kode-vs"><a class="kode-modren-btn thbg-colortwo" href="#"><?php _e('vs','kickoff');?></a></li>
										<li><a href="<?php echo esc_url(get_permalink($kode_post_option['select_team_second']))?>"><img src="<?php echo esc_url($team_second_img[0]);?>" /></a></li>
									</ul>
									<div class="clearfix"></div>
									<h3><?php echo esc_attr(get_the_title());?></h3>
									<span class="kode-subtitle"><?php echo esc_attr($location_town);?> - <?php echo esc_attr(date(get_option('date_format'),$EM_Event->start));?> <?php if($EM_Event->event_all_day <> 1){ echo esc_attr($start_time);?> to <?php echo esc_attr($end_time); }else{ esc_html_e('All Day','kickoff'); $start_time = '12:00'; $end_time = '12:00'; } ?></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<p><?php _e('Mauris vel varius felis. Duis feugiat interdum nibh, nec consequat erat dapibus sit amet. Ut at nibh varius, dignissim magna non, interdum urna. Maecenas enean..','kickoff');?></p>
						</div>
					</div>
					<?php 
					
					// $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
					// $dd = wp_get_post_terms( $kode_post_option['select_team_first'], 'event-categories',$args );
					// print_r($dd);
					$kode_parti_events_first = kode_get_all_events_id($kode_post_option['select_team_first']);
					$kode_parti_events_second = kode_get_all_events_id($kode_post_option['select_team_second']);
					
					?>
					<div class="kode-player-tabs">

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
										<th><?php _e('Tournament','kickoff');?></th>
										<th><?php _e('Goals','kickoff');?></th>
										<th><?php _e('Shorts On Target','kickoff');?></th>
										<th><?php _e('Corner Kicks','kickoff');?></th>
										<th><?php _e('Yellow Cards','kickoff');?></th>
										<th><?php _e('Passing Accuracy','kickoff');?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($kode_parti_events_first as $parti_event){
									$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
									$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
								if($parti_event <> $EM_Event->post_id){ ?>
									<tr>
										<td><?php echo esc_attr($get_categories[0]->name);?></td>
										<td><?php echo esc_attr($kode_post_option['goal_scored_team_first']);?></td>
										<td><?php echo esc_attr($kode_post_option['shorts_on_targets_team_first']);?></td>
										<td><?php echo esc_attr($kode_post_option['corner_kicks_team_first']);?></td>
										<td><?php echo esc_attr($kode_post_option['red_cards_team_first']);?></td>
										<td><?php echo esc_attr($kode_post_option['ball_possession_team_first']);?>%</td>
									</tr>
								<?php }else{ ?>
									<tr>
										<td><?php echo esc_attr($get_categories[0]->name);?></td>
										<td>--</td>
										<td>--</td>
										<td>--</td>
										<td>--</td>
										<td>--</td>
									</tr>
									<?php
									}
								}
								?>									
								</tbody>
							</table>
						</div>
						<div id="profiletwo" class="tab-pane" role="tabpanel">
							<table class="kode-table">
								<thead>
									<tr>
										<th><?php _e('Tournament','kickoff');?></th>
										<th><?php _e('Goals','kickoff');?></th>
										<th><?php _e('Shorts On Target','kickoff');?></th>
										<th><?php _e('Corner Kicks','kickoff');?></th>
										<th><?php _e('Yellow Cards','kickoff');?></th>
										<th><?php _e('Passing Accuracy','kickoff');?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($kode_parti_events_second as $parti_event){
									$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
									$get_categories = wp_get_post_terms( $parti_event, 'event-categories',$args );
									if($parti_event <> $EM_Event->post_id){ ?>
										<tr>
											<td><?php echo esc_attr($get_categories[0]->name);?></td>
											<td><?php echo esc_attr($kode_post_option['goal_scored_team_second']);?></td>
											<td><?php echo esc_attr($kode_post_option['shorts_on_targets_team_second']);?></td>
											<td><?php echo esc_attr($kode_post_option['corner_kicks_team_second']);?></td>
											<td><?php echo esc_attr($kode_post_option['red_cards_team_second']);?></td>
											<td><?php echo esc_attr($kode_post_option['ball_possession_team_second']);?>%</td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td><?php echo esc_attr($get_categories[0]->name);?></td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
											<td>--</td>
										</tr>
										<?php
										}
									}
								?>									
								</tbody>
							</table>
						</div>
					</div>

					</div>
					<div class="kode-editor">
						<?php $content = str_replace(']]>', ']]&gt;',$EM_Event->post_content); ?>
						<p><?php echo do_shortcode($content); ?> </p>
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