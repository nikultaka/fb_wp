<?php
/**
 * Plugin Name: Kodeforest Newsletter Widget
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show newsletter( Specified by category ).
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_newsletter_widget' );
if( !function_exists('kode_newsletter_widget') ){
	function kode_newsletter_widget() {
		register_widget( 'Kodeforest_Newsletter' );
	}
}

if( !class_exists('Kodeforest_Newsletter') ){
	class Kodeforest_Newsletter extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_newsletter_widget', 
				esc_html__('Kodeforest Newsletter Widget','kickoff'), 
				array('description' => esc_html__('A widget about newsletter widget.', 'kickoff')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			

			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . esc_attr($title) . $args['after_title']; 
			}
			?>
			
			<div class="kode_football_footer_caption">
				<div class="kode_football_footer_newsleter">
				 <?php echo '
					<form method="post" id="kode-submit-form" data-ajax="'.esc_url(AJAX_URL).'" data-security="'.wp_create_nonce('kode-create-nonce').'" data-action="newsletter_mailchimp">
						<div class="kode_football_footer_search">
							<label>Name</label>
							<input type="text" id="newsletter-email" name="name" placeholder="Your name here ..." class="placeholder2">
						</div>
						<div class="kode_football_footer_search">
							<label>Email</label>
							<input type="text" id="newsletter-email" name="email" placeholder="Your email here ..." class="placeholder2">
						</div>
						<button class="kode_footer_newslater_submit">Submit</button>
					</form> ';
					?>
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
			

			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title :', 'kickoff'); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			
			
			<!-- Widget Icon --> 
			
			
		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			

			return $instance;
		}	
	}
}
?>