<?php
	/*	
	*	Testimonial Listing
	*	---------------------------------------------------------------------
	*	This file contains functions that help you create testimonial item
	*	---------------------------------------------------------------------
	*/
	
	//Testimonial Listing
	if( !function_exists('kode_get_testimonial_item') ){
		function kode_get_testimonial_item( $settings ){
			// $settings['category'];
			// $settings['tag'];
			// $settings['num-excerpt'];
			// $settings['num-fetch'];
			// $settings['testimonial-style'];
			// $settings['scope'];
			// $settings['order'];
			// $settings['margin-bottom'];
			// query posts section
			$args = array('post_type' => 'testimonial', 'suppress_filters' => false);
			$args['posts_per_page'] = (empty($settings['num-fetch']))? '5': $settings['num-fetch'];
			$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
			//$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;

			if( !empty($settings['category']) ){
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'testimonial_category', 'field'=>'slug'));
				}
				// if( !empty($settings['tag'])){
					// array_push($args['tax_query'], array('terms'=>explode(',', $settings['tag']), 'taxonomy'=>'testimonial_tag', 'field'=>'slug'));
				// }				
			}			
			$query = new WP_Query( $args );

			// create the testimonial filter
			$settings['num-excerpt'] = empty($settings['num-excerpt'])? '196' : $settings['num-excerpt'];
			
			$size = 4;
			if($settings['testimonial-style'] == 'simple-view'){
				//$testimonial  = '<div class="row"><div class="col-md-12"><div class="owl-carousel owl-theme">';
				$testimonial  = '<div class="kode-testimonials-6" > <ul class="bxslider">';
			}else if($settings['testimonial-style'] == 'normal-view'){
				$testimonial  = '<div class="kd-testimonial" > <ul class="bxslider">';
			}else{
				$testimonial  = '<div class="kd-testimonial kdtwitter" > <ul class="bxslider">';
			}
			while($query->have_posts()){ $query->the_post();
			global $post;
			$testimonial_option = json_decode(kode_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true)), true);
				// if( $current_size % $size == 0 ){
					// $testimonial .= '<div class="clear"></div>';
				// }	designation
				if($settings['testimonial-style'] == 'simple-view'){
				$testimonial .= '              
				<li>
					<div class="kode-text">
						<p>"'.strip_tags(mb_substr(get_the_content(),0,$settings['num-excerpt'])).'"</p>
						<div class="client-name">
							<h4>'.esc_attr(get_the_title()).esc_attr($testimonial_option['designation']).'</h4>
							<div class="kode-thumb">
								<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(80,80)).'</a>
							</div>
						</div>
					</div>
				</li>
                <!--ITEM END-->';
				}else if($settings['testimonial-style'] == 'normal-view'){
					$testimonial .= "
					 <li>
                      <i>''</i>
                     <p>".strip_tags(mb_substr(get_the_content(),0,$settings['num-excerpt']))."</p>
                      <span>".esc_attr($testimonial_option['designation'])."</span>
                    </li>
					";
				}else{
				$testimonial .= '
				<li>
					<h2>'.esc_attr(get_the_title()).'</h2>
					<p>'.strip_tags(mb_substr(get_the_content(),0,$settings['num-excerpt'])).'</p>
					<a href="'.esc_url(get_permalink()).'">'.esc_attr($testimonial_option['designation']).'</a>
				</li>';
				}
				//$current_size++;
			}
			wp_reset_postdata();
			if($settings['testimonial-style'] == 'simple-view'){
				$testimonial .= '</ul></div>';
			}else{
				$testimonial .= '</ul></div>';
			}			
			
			return $testimonial;
		}
	}	
	
?>