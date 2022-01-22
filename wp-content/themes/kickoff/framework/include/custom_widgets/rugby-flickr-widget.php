<?php
/**
 * Plugin Name: Kodeforest Rugby Flickr Widget
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show Rugby flickr image.
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_rugby_flickr_widget' );
if( !function_exists('kode_rugby_flickr_widget') ){
	function kode_rugby_flickr_widget() {
		register_widget( 'Kodeforest_Rugby_Flickr' );
	}
}

if( !class_exists('Kodeforest_Rugby_Flickr') ){
	class Kodeforest_Rugby_Flickr extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_rugby_flickr_widget', 
				esc_html__('Kodeforest Rugby Flickr Widget (KodeForest)','kickoff'), 
				array('description' => esc_html__('A widget that show Rugby image from flickr', 'kickoff')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $kode_theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			$id = $instance['id'];
			$num_fetch = $instance['num_fetch'];
			$orderby = $instance['orderby'];
			
			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . esc_attr($title) . $args['after_title']; 
			}
				
			// Widget Content
			if(!empty($id)){ 
				$flickr  = '?count=' . $num_fetch;
				$flickr .= '&amp;display=' . $orderby;
				$flickr .= '&amp;user=' . $id;
				$flickr .= '&amp;size=s&amp;layout=x&amp;source=user';
				?>
					<div class="kode_football_footer_caption">
						<div class="kode_football_footer_gallery">
							<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne<?php echo esc_url($flickr); ?>"></script>
							<div class="clear"></div>
						</div>
					</div>
				<?php
			}
					
			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			$id = isset($instance['id'])? $instance['id']: '';
			$num_fetch = isset($instance['num_fetch'])? $instance['num_fetch']: 6;
			$orderby = isset($instance['orderby'])? $instance['orderby']: 'latest';
			
			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title :', 'kickoff'); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>	
			
			<!-- ID --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('id')); ?>"><?php esc_html_e('Flickr ID :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('id')); ?>" name="<?php echo esc_attr($this->get_field_name('id')); ?>" type="text" value="<?php echo esc_attr($id); ?>" />
			</p>			

			<!-- Show Num --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('num_fetch')); ?>"><?php esc_html_e('Num Fetch :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('num_fetch')); ?>" name="<?php echo esc_attr($this->get_field_name('num_fetch')); ?>" type="text" value="<?php echo esc_attr($num_fetch); ?>" />
			</p>			

			<!-- Order By -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>"><?php esc_html_e('Order By :', 'kickoff'); ?></label>		
				<select class="widefat" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>" id="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
					<option value="latest" <?php if(empty($orderby) || $orderby == 'latest') echo esc_html__(' selected ','kickoff'); ?>><?php esc_html_e('Latest', 'kickoff') ?></option>
					<option value="random" <?php if($orderby == 'random') echo esc_html__(' selected ','kickoff'); ?>><?php esc_html_e('Random', 'kickoff') ?></option>				
				</select> 
			</p>
				


		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['id'] = (empty($new_instance['id']))? '': strip_tags($new_instance['id']);
			$instance['num_fetch'] = (empty($new_instance['num_fetch']))? '': strip_tags($new_instance['num_fetch']);
			$instance['orderby'] = (empty($new_instance['orderby']))? '': strip_tags($new_instance['orderby']);

			return $instance;
		}	
	}
}
?>