<?php
/**
 * Plugin Name: Kodeforest Match Tabs
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show Match Tabs( Specified by category ).
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_match_tabs_widget' );
if( !function_exists('kode_match_tabs_widget') ){
	function kode_match_tabs_widget() {
		register_widget( 'kode_match_tabs_widget' );
	}
}

if( !class_exists('kode_match_tabs_widget') ){
	class kode_match_tabs_widget extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_match_tabs_widget', 
				esc_html__('Kodeforest Tabs Widget','kickoff'), 
				array('description' => esc_html__('A widget that show latest posts', 'kickoff')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $kode_theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			$category = $instance['category'];
			$num_fetch = $instance['num_fetch'];
			
			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . esc_attr($title) . $args['after_title']; 
			}
			
			
			echo '
			<div class="tab-widget">
				<!-- Nav tabs -->
				<ul class="widget-tabnav" role="tablist">
					<li role="presentation" class="active"><a href="#past_home" aria-controls="past_home" role="tab" data-toggle="tab">'.esc_html__('Live','kickoff').'</a></li>
					<li role="presentation"><a href="#future_home" aria-controls="future_home" role="tab" data-toggle="tab">'.esc_html__('Fixture','kickoff').'</a></li>						
				</ul>
				<!-- Tab panes -->';
				echo '
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="past_home">
						<ul class="match-widget">';
						$evn = '';
						$order = 'DESC';
						$limit = 10;//Default limit
						$offset = '';		
						$rowno = 0;
						$event_count = 0;
						$EM_Events = EM_Events::get( array('scope'=>'future', 'limit' => 5) );
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

							echo '
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
					echo '</ul>
					</div>';
				
					echo '
					<div role="tabpanel" class="tab-pane" id="future_home">
						<ul class="match-widget">';
						$evn = '';
						$order = 'DESC';
						$limit = 10;//Default limit
						$offset = '';		
						$rowno = 0;
						$event_count = 0;
						$EM_Events = EM_Events::get( array('scope'=>'past', 'limit' => 5) );
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

							echo '
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
						echo '
						</ul>
					</div>
				</div>
			</div>';
					
			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			$category = isset($instance['category'])? $instance['category']: '';
			$num_fetch = isset($instance['num_fetch'])? $instance['num_fetch']: 3;
			
			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title :', 'kickoff'); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>		

			<!-- Post Category -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category :', 'kickoff'); ?></label>		
				<select class="widefat" name="<?php echo esc_attr($this->get_field_name('category')); ?>" id="<?php echo esc_attr($this->get_field_id('category')); ?>">
				<option value="" <?php if(empty($category)) echo ' selected '; ?>><?php esc_html_e('All', 'kickoff') ?></option>
				<?php 	
				$category_list = kode_get_term_list('event-categories'); 
				
				foreach($category_list as $cat_slug => $cat_name){ ?>
					<option value="<?php echo esc_attr($cat_slug); ?>" <?php if ($category == $cat_slug) echo ' selected '; ?>><?php echo esc_attr($cat_name); ?></option>				
				<?php } ?>	
				</select> 
			</p>
				
			<!-- Show Num --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('num_fetch')); ?>"><?php esc_html_e('Num Fetch :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('num_fetch')); ?>" name="<?php echo esc_attr($this->get_field_name('num_fetch')); ?>" type="text" value="<?php echo esc_attr($num_fetch); ?>" />
			</p>

		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['category'] = (empty($new_instance['category']))? '': strip_tags($new_instance['category']);
			$instance['num_fetch'] = (empty($new_instance['num_fetch']))? '': strip_tags($new_instance['num_fetch']);

			return $instance;
		}	
	}
}
?>