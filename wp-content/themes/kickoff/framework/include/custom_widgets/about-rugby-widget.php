<?php
/**
 * Plugin Name: Kodeforest About Us
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show About Us( Specified by category ).
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_about_us_widget' );
if( !function_exists('kode_about_us_widget') ){
	function kode_about_us_widget() {
		register_widget( 'Kodeforest_About_Us' );
	}
}

if( !class_exists('Kodeforest_About_Us') ){
	class Kodeforest_About_Us extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_about_us_widget', 
				esc_attr__('Kodeforest About Us Widget','kickoff'), 
				array('description' => esc_attr__('A widget that shows About us information.', 'kickoff')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			$description = $instance['description'];
			$contact_logo = $instance['contact_logo'];
			

			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . esc_attr($title) . $args['after_title']; 
			}
			?>
				<!--// TextWidget //-->
				
				<div class="kode_football_footer_caption">
					<div class="kode_football_footer_logo">
						<figure>
						<?php if($contact_logo <> ''){ ?>
							<a href="<?php esc_url(home_url());?>"><img alt="image" src="<?php echo esc_url($contact_logo);?>"></a>
						<?php }?>	
						</figure>
						<p><?php echo esc_attr($description);?></p>
					</div>
				</div>
				<!--// TextWidget //-->
<?php
					
			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			$description = isset($instance['description'])? $instance['description']: '';
			$contact_logo = isset($instance['contact_logo'])? $instance['contact_logo']: '';
			
			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title :', 'kickoff'); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<!-- Logo --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_logo')); ?>"><?php esc_attr_e('Contact Logo :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('contact_logo')); ?>" name="<?php echo esc_attr($this->get_field_name('contact_logo')); ?>" type="text" value="<?php echo esc_attr($contact_logo); ?>" />
			</p>
			<!-- Description -->			
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_attr_e('Description :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" type="text" value="<?php echo esc_attr($description); ?>" />
			</p>
			
		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['description'] = (empty($new_instance['description']))? '': strip_tags($new_instance['description']);
			$instance['contact_logo'] = (empty($new_instance['contact_logo']))? '': strip_tags($new_instance['contact_logo']);

			return $instance;
		}	
	}
}
?>