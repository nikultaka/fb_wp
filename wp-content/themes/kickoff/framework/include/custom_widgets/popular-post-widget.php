<?php
/**
 * Plugin Name: Kodeforest Popular Post
 * Plugin URI: http://kodeforest.com/
 * Description: A widget that show popular posts( Specified by comment ).
 * Version: 1.0
 * Author: Kodeforest
 * Author URI: http://www.kodeforest.com
 *
 */

add_action( 'widgets_init', 'kode_popular_post_widget' );
if( !function_exists('kode_popular_post_widget') ){
	function kode_popular_post_widget() {
		register_widget( 'Kodeforest_Popular_Post' );
	}
}

if( !class_exists('Kodeforest_Popular_Post') ){
	class Kodeforest_Popular_Post extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::__construct(
				'kode_popular_post_widget', 
				esc_html__('Kodeforest Popular Post Widget','kickoff'), 
				array('description' => esc_html__('A widget that show popular posts ( by comment )', 'kickoff')));  
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
				echo $args['before_title'] . $title . $args['after_title']; 
			}
				
			// Widget Content
			$current_post = array(get_the_ID());		
			$query_args = array('post_type' => 'post', 'suppress_filters' => false);
			$query_args['posts_per_page'] = $num_fetch;
			$query_args['orderby'] = 'comment_count';
			$query_args['order'] = 'desc';
			$query_args['paged'] = 1;
			$query_args['category_name'] = $category;
			$query_args['ignore_sticky_posts'] = 1;
			$query_args['post__not_in'] = array(get_the_ID());
			$query = new WP_Query( $query_args );
			
			if($query->have_posts()){
				echo '<div class="widget-recentpost"><ul class="recent-posts">';
					while($query->have_posts()){ $query->the_post();
						
						$thumbnail = kode_get_image(get_post_thumbnail_id(), array(80,80));
				
				echo '<li>
                      <div class="datetime">'.get_the_date('d').' <span>'.get_the_date('M').'</span></div>
                      <div class="post-info">
                        <h6><a href="' . esc_url(get_permalink()) . '">' . esc_attr(get_the_title()) . '</a></h6>
                        <p>'.strip_tags(mb_substr(get_the_content(),0,65)).'</p>
                      </div>
                    </li>';					
				   
					
					}
				echo '</ul></div>';
			}
			wp_reset_postdata();
					
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
				<option value="" <?php if(empty($category)) echo esc_html__(' selected ','kickoff'); ?>><?php esc_html_e('All', 'kickoff') ?></option>
				<?php 	
				$category_list = kode_get_term_list('category'); 
				foreach($category_list as $cat_slug => $cat_name){ ?>
					<option value="<?php echo esc_attr($cat_slug); ?>" <?php if ($category == $cat_slug) echo esc_html__(' selected ','kickoff'); ?>><?php echo esc_attr($cat_name); ?></option>				
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