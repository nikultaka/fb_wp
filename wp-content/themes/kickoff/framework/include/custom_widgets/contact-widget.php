<?php
/**
 * Plugin Name: Kodeforest Recent Post
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show recent posts( Specified by category ).
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_contact_widget' );
if( !function_exists('kode_contact_widget') ){
	function kode_contact_widget() {
		register_widget( 'Kodeforest_Contact' );
	}
}

if( !class_exists('Kodeforest_Contact') ){
	class Kodeforest_Contact extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_contact_widget', 
				esc_html__('Kodeforest Contact Widget','kickoff'), 
				array('description' => esc_html__('A widget that show contact us information.', 'kickoff')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $kode_theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			$description = $instance['description'];
			$contact_logo = $instance['contact_logo'];
			$address = $instance['address'];
			$phone = $instance['phone'];
			$email = $instance['email'];
			$website = $instance['website'];
			$social_icons = $instance['social_icons'];
			

			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . esc_attr($title) . $args['after_title']; 
			}
			?>
				<!--// TextWidget //-->
				<div class="widget-text">
					<div class="inner-element">
						<?php if($contact_logo <> ''){ ?>
							<a href="<?php esc_url(home_url('/'));?>" class="footer-logo"><img src="<?php echo esc_url($contact_logo);?>" alt=""></a>
						<?php }?>
						<p><?php echo esc_attr($description);?></p>
						<ul class="kode-form-list">
						  <?php if($address <> ''){ ?><li><i class="fa fa-home"></i> <p><strong><?php esc_html_e('Address','kickoff')?>:</strong> <?php echo esc_attr($address);?></p></li><?php }?>
						  <?php if($phone <> ''){ ?><li><i class="fa fa-phone"></i> <p><strong><?php esc_html_e('Phone','kickoff')?>:</strong> <?php echo esc_attr($phone);?></p></li><?php }?>
						  <?php if($email <> ''){ ?><li><i class="fa fa-envelope-o"></i> <p><strong><?php esc_html_e('Email','kickoff')?>:</strong> <?php echo esc_attr($email);?></p></li><?php }?>
						  <?php if($website <> ''){ ?><li><i class="fa fa-home"></i> <p><strong><?php esc_html_e('Website','kickoff')?>:</strong> <?php echo esc_attr($website);?></p></li><?php }?>
						</ul>
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
			$address = isset($instance['address'])? $instance['address']: '';
			$contact_logo = isset($instance['contact_logo'])? $instance['contact_logo']: '';
			$phone = isset($instance['phone'])? $instance['phone']: '';
			$email = isset($instance['email'])? $instance['email']: '';
			$website = isset($instance['website'])? $instance['website']: '';
			$social_icons = isset($instance['social_icons'])? $instance['social_icons']: '';
			
			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title :', 'kickoff'); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>
			<!-- Logo --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('contact_logo')); ?>"><?php esc_html_e('Contact Logo :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('contact_logo')); ?>" name="<?php echo esc_attr($this->get_field_name('contact_logo')); ?>" type="text" value="<?php echo esc_attr($contact_logo); ?>" />
			</p>
			<!-- Description -->			
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>" type="text" value="<?php echo esc_attr($description); ?>" />
			</p>
			<!-- Address --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Address :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>" />
			</p>
			<!-- Phone --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
			</p>
			<!-- Email --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
			</p>
			<!-- Website --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('website')); ?>"><?php esc_html_e('Website :', 'kickoff'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('website')); ?>" name="<?php echo esc_attr($this->get_field_name('website')); ?>" type="text" value="<?php echo esc_attr($website); ?>" />
			</p>
			<!-- Show Num --> 
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('social_icons')); ?>">
					<?php esc_html_e('Social Icons:','kickoff');?>
					<textarea rows="2"  cols="35" class="widefat" id="<?php echo esc_textarea($this->get_field_id('social_icons')); ?>" name="<?php echo esc_textarea($this->get_field_name('social_icons')); ?>"><?php echo esc_textarea($social_icons); ?></textarea>
				</label>
			</p>
		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);
			$instance['description'] = (empty($new_instance['description']))? '': strip_tags($new_instance['description']);
			$instance['address'] = (empty($new_instance['address']))? '': strip_tags($new_instance['address']);
			$instance['contact_logo'] = (empty($new_instance['contact_logo']))? '': strip_tags($new_instance['contact_logo']);
			
			$instance['phone'] = (empty($new_instance['phone']))? '': strip_tags($new_instance['phone']);
			$instance['email'] = (empty($new_instance['email']))? '': strip_tags($new_instance['email']);
			$instance['website'] = (empty($new_instance['website']))? '': strip_tags($new_instance['website']);
			$instance['social_icons'] = (empty($new_instance['social_icons']))? '': strip_tags($new_instance['social_icons']);

			return $instance;
		}	
	}
}
?>