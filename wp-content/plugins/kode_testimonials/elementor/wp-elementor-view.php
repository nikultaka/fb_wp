<?php
/**
 * WPHA GET SERVICES ITEM
 *
 * @class    WPHA_GET_SERVICES_ITEM
 * @author   Adeel Nazar
 * @category core
 * @package  includes/wpha-get-services-item
 * @version  1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}	

/**
* Important Core Functions
*/

function wpha_get_testimonial_small_item($settings){
	// query post and sticky post
	$args = array('post_type' => 'testimonial', 'suppress_filters' => false);
	if( !empty($settings['category']) || !empty($settings['tag']) ){
		$args['tax_query'] = array('relation' => 'OR');
		
		if( !empty($settings['category']) ){
			array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'testimonial_category', 'field'=>'slug'));
		}
		
	}

	$args['posts_per_page'] = (empty($settings['num_fetch']))? '5': $settings['num_fetch'];
	$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
	$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
	$settings['listing'] = (empty($settings['listing']))? '': $settings['listing'];
	$settings['padding'] = (empty($settings['padding']))? '': $settings['padding'];
	$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
	$args['paged'] = empty($args['paged'])? 1: $args['paged'];
	
	$settings['title_num_excerpt'] = (empty($settings['title_num_excerpt']))? '20': $settings['title_num_excerpt'];

	
	$query = new WP_Query( $args );
	
	$ret = '
	<!--CITY CLIENT WRAP START-->

	<div class="city_testimonial">
					<ul class="modern-testi-bxslider bx-pager">';
					while($query->have_posts()){ 
						$query->the_post();
						global $post;
						$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
						if( !empty($wpha_post_option) ){
							$wpha_post_option = json_decode( $wpha_post_option, true );
						}
						$wpha_post_option['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
						$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(150,150));
						
						$ret .= '
						<li>
							<div class="city_client_fig">
								<figure class="box">
									<div class="box-layer layer-1"></div>
									<div class="box-layer layer-2"></div>
									<div class="box-layer layer-3"></div>
									<img src="'.esc_url($image_src_full[0]).'" alt="'.esc_attr(substr(get_the_title(),0,10)).'">
								</figure>
								<div class="city_client_text">
									<p>'.esc_attr(substr(get_the_content(),0,120)).'</p>
									<h4><a href="#">'.esc_attr(substr(get_the_title(),0,10)).'</a> </h4>';
									if(!empty($wpha_post_option['designation'])){
										$ret .= '<span><a href="#">'.esc_attr($wpha_post_option['designation']).'</a></span>';
									}
									$ret .= '
								</div>
							</div>
						</li>';
					}
					$ret .= '
					</ul>
				</div>
				<div class="city_client_link" id="bx-pager">';
					$counter_testi = 0;
					while($query->have_posts()){ 
						$query->the_post();
						global $post;
						$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(90,90));
						$ret .= '
						<a data-slide-index="'.esc_attr($counter_testi).'" href="">
							<div class="client_arrow">
								<figure class="box">
									<div class="box-layer layer-1"></div>
									<div class="box-layer layer-2"></div>
									<div class="box-layer layer-3"></div>
									<img src="'.esc_url($image_src_full[0]).'" alt="">
								</figure>
							</div>	
						</a>';
						$counter_testi++;
					}
					wp_reset_postdata();
					wp_reset_query();
					$ret .= '
				</div>
			</div>
		</div>
	</div>
	<!--CITY CLIENT WRAP END-->';
	
	return $ret;
}
	
	
// Testimonial Item
function wpha_get_testimonials_item( $settings = array() ){
	$item_id = empty($settings['element_item_id'])? '': ' id="' . $settings['element_item_id'] . '" ';

	global $wpha_spaces;
	$margin = (!empty($settings['margin_bottom']) && 
		$settings['margin_bottom'] != '')? 'margin-bottom: ' . esc_attr($settings['margin_bottom']) . 'px;': '';
	$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
	
	//$ret  = wpha_get_item_title($settings);
	$ret = '';
	$ret .= '<div class="wpha-item-wrapper"  ' . $item_id . $margin_style . '>';
	
	// query post and sticky post
	$args = array('post_type' => 'testimonial', 'suppress_filters' => false);
	if( !empty($settings['category']) || !empty($settings['tag']) ){
		$args['tax_query'] = array('relation' => 'OR');
		
		if( !empty($settings['category']) ){
			array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'testimonial_category', 'field'=>'slug'));
		}
		
	}

	$args['posts_per_page'] = (empty($settings['num_fetch']))? '5': $settings['num_fetch'];
	$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
	$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
	$settings['listing'] = (empty($settings['listing']))? '': $settings['listing'];
	$settings['padding'] = (empty($settings['padding']))? '': $settings['padding'];
	$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
	$args['paged'] = empty($args['paged'])? 1: $args['paged'];
	
	$settings['title_num_fetch'] = (empty($settings['title_num_fetch']))? '20': $settings['title_num_fetch'];
	
	$query = new WP_Query( $args );
	
	// set the excerpt length
	if( !empty($settings['num_excerpt']) ){
		global $wpha_excerpt_length; $wpha_excerpt_length = $settings['num_excerpt'];
		add_filter('excerpt_length', 'wpha_set_excerpt_length');
	} 
	
	// get testimonials by the testimonials style
	global $wpha_post_settings, $wpha_lightbox_id;
	$wpha_lightbox_id++;
	$wpha_post_settings['num_excerpt'] = $settings['num_excerpt'];
	$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];	
	$wpha_post_settings['style'] = $settings['style'];	
	
	if($settings['testimonial-style'] == 'simple-view'){
				//$testimonial  = '<div class="row"><div class="col-md-12"><div class="owl-carousel owl-theme">';
				$testimonial  = '<div class="kode-testimonials-6" > <ul class="bxslider">';
			}else if($settings['testimonial-style'] == 'normal-view'){
				$testimonial  = '<div class="kd-testimonial" > <ul class="bxslider">';
			}else{
				$testimonial  = '<div class="kd-testimonial kdtwitter" > <ul class="bxslider">';
			}
	
	
	$ret .= '<div class="wpha-item-holder">';
	if($settings['style'] == 'style-1'){
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic '.esc_attr($settings['padding']).'">';
		$ret .= '<div class="row">';
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$testimonials_size = $settings['column_size'];	
		$ret .= wpha_get_testimonials_full($query, $testimonials_size, $settings);
		$ret .= '</div>';
		$ret .= '</div>';
	}else if(strpos($settings['style'], 'style-2') !== false){
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$testimonials_size = $settings['column_size'];	
		$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic '.esc_attr($settings['padding']).'">';
		$ret .= '<div class="row">';
		$ret .= wpha_get_testimonials_grid($query, $testimonials_size, $settings);			
		$ret .= '</div>';
		$ret .= '</div>';
	}else if(strpos($settings['style'], 'style-3') !== false){
		$testimonials_size = $settings['column_size'];	
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic">';
		$ret .= '<div class="row">';
		$ret .= wpha_get_testimonials_list($query, $testimonials_size, $settings);
		$ret .= '</div>';
		$ret .= '</div>';
	}else if(strpos($settings['style'], 'style-4') !== false){
		$testimonials_size = $settings['column_size'];	
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic '.esc_attr($settings['padding']).'">';
		$ret .= '<div class="row">';
		$ret .= wpha_get_testimonials_widget($query, $testimonials_size, $settings);
		$ret .= '</div>';
		$ret .= '</div>';
	}else if(strpos($settings['style'], 'style-5') !== false){
		$testimonials_size = $settings['column_size'];	
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic '.esc_attr($settings['padding']).'">';
		$ret .= '<div class="row">';
		$ret .= wpha_get_testimonials_modern_normal_5($query, $testimonials_size, $settings);
		$ret .= '</div>';
		$ret .= '</div>';
	}else{
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
		$testimonials_size = $settings['column_size'];
		$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
		$ret .= '<div class="wpha-listing-item kode-testimonials kode-testimonials-classic '.esc_attr($settings['padding']).'">';
		$ret .= '<div class="row">';
		$ret .= wpha_get_testimonials_grid($query, $testimonials_size, $settings);			
		$ret .= '</div>';
		$ret .= '</div>';
	}
	$ret .= '</div>
	<div class="clearfix clear"></div>';
	
	$ret .= '</div>'; // testimonials-item-wrapper
	
	remove_filter('excerpt_length', 'wpha_set_excerpt_length');
	return $ret;
}

function wpha_get_testimonials_list($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }

	$ret = ''; $current_size = 0;				
	
	while($query->have_posts()){ $query->the_post();
	global $post;
		
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clear"></div>';
		}

		$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
		$ret .= '<div class="kode-ux kode-testimonials-widget-ux">';
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_3( $settings );
		
		$ret .= ob_get_contents();
		
		ob_end_clean();			
		$ret .= '</div>'; // kode-ux
		$ret .= '</div>'; // column_class
		$current_size ++;
	}
	$ret .= '<div class="clear"></div>';
	//$ret .= '</div>'; // close the kode-isotope
	wp_reset_postdata();
	
	return $ret;
}


function wpha_get_testimonials_widget($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }

	$ret = ''; $current_size = 0;				
	
	while($query->have_posts()){ $query->the_post();
	global $post;
		
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clear"></div>';
		}

		$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
		$ret .= '<div class="kode-ux kode-testimonials-widget-ux">';
		
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_4( $settings );
		
		$ret .= '</div>'; // kode-ux
		$ret .= '</div>'; // column_class
		$current_size ++;
	}
	$ret .= '<div class="clear"></div>';
	//$ret .= '</div>'; // close the kode-isotope
	wp_reset_postdata();
	
	return $ret;
}

function wpha_get_testimonials_grid($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }
	
	
	$ret = ''; $current_size = 0;			
	//$ret .= '<div class="kode-isotope" data-type="testimonials" data-layout="' . $testimonials_layout  . '" >';
	while($query->have_posts()){ $query->the_post();
	global $post;
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clearfix clear"></div>';
		}

		$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
		$ret .= '<div class="kode-ux kode-testimonials-grid-ux">';
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_2( $settings );
		
		$ret .= ob_get_contents();
		
		ob_end_clean();			
		$ret .= '</div>'; // kode-ux				
		$ret .= '</div>'; // column_class
		$current_size ++;
	}
	$ret .= '<div class="clear"></div>';
	//$ret .= '</div>'; // close the kode-isotope
	wp_reset_postdata();
	
	return $ret;
}

function wpha_get_testimonials_full($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }
	
	$ret = '';$current_size = 0;
	
	while($query->have_posts()){ $query->the_post();
	global $post;
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clear"></div>';
		}
		$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
		$ret .= '<div class="kode-item kode-testimonials-single-full ">';
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_1( $settings );
		
		$ret .= ob_get_contents();
		
		ob_end_clean();			
		$ret .= '</div>'; // kode-ux
		$ret .= '</div>'; // kode-item
		$current_size++;
	}
	wp_reset_postdata();
	
	return $ret;
}

function wpha_get_testimonials_modern_normal($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }
	
	$ret = '';$current_size = 0;
	
	while($query->have_posts()){ $query->the_post();
	global $post;
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clear"></div>';
		}
		$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
		$ret .= '<div class="kode-item kode-testimonials-single-full ">';
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_1( $settings );
		
		$ret .= ob_get_contents();
		
		ob_end_clean();			
		$ret .= '</div>'; // kode-ux
		$ret .= '</div>'; // kode-item
		$current_size++;
	}
	wp_reset_postdata();
	
	return $ret;
}


function wpha_get_testimonials_modern_normal_5($query, $size, $settings){
	
	if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_testimonials_grid_carousel($query, $size, $settings); }
	
	$ret = '';$current_size = 0;
	
	while($query->have_posts()){ $query->the_post();
	global $post;
		if( $current_size % $size == 0 ){
			$ret .= '<div class="clear"></div>';
		}
		$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
		$ret .= '<div class="kode-item kode-testimonials-single-full ">';
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		
		if($current_size % 2 == 0){
			$settings['class'] = 'client_fig';
		}else if($current_size == 3){
			$settings['class'] = 'client_fig padding-top img-none';
		}else{
			$settings['class'] = 'client_fig padding-top';
		}
		
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		$settings['post'] = $post;
		
		$ret .= wpha_get_testimonials_style_5( $settings );
		
		$ret .= ob_get_contents();
		
		ob_end_clean();			
		$ret .= '</div>'; // kode-ux
		$ret .= '</div>'; // kode-item
		$current_size++;
	}
	wp_reset_postdata();
	
	return $ret;
}

function wpha_get_testimonials_grid_carousel($query, $size,$settings){
	
	$ret = ''; 			
	if(isset($settings['style']) && $settings['style'] == 'style-1'){
		$ret .= '<div class="kode-testimonials-6"> <ul class="bxslider" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';				
	}else if(isset($settings['style']) && $settings['style'] == 'style-2'){
		$ret .= '<div class="kd-testimonial"> <ul class="bxslider" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';				
	}else if(isset($settings['style']) && $settings['style'] == 'style-3'){
		$ret .= '<div class="kd-testimonial kdtwitter"> <ul class="bxslider" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';
	}else{
		$ret .= '<div class="kd-testimonial kdtwitter"> <ul class="bxslider" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';
	}
	$current_size = 0;
	$settings['class'] = '';
	while($query->have_posts()){ $query->the_post();
	global $post;
		
		ob_start();
		$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
		if( !empty($wpha_post_option) ){
			$wpha_post_option = json_decode( $wpha_post_option, true );
		}
		$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
		
		$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(50,50));
		
		$settings['image_src_full'] = $image_src_full;
		$settings['num_excerpt'] = $settings['num_excerpt'];
		
		$settings['post'] = $post;
		
		if(isset($settings['style']) && $settings['style'] == 'style-1'){
			$ret .= wpha_get_testimonials_style_1($settings);
		}else if(isset($settings['style']) && $settings['style'] == 'style-2'){
			$ret .= wpha_get_testimonials_style_2($settings);	
		}else if(isset($settings['style']) && $settings['style'] == 'style-3'){
			$ret .= wpha_get_testimonials_style_3($settings);	
		}else if(isset($settings['style']) && $settings['style'] == 'style-4'){
			$ret .= wpha_get_testimonials_style_4($settings);	
		}else if(isset($settings['style']) && $settings['style'] == 'style-5'){
			$ret .= wpha_get_testimonials_style_5($settings);	
		}
		
		$ret .= ob_get_contents();
		
		ob_end_clean();					
		
		$current_size++;
	}
	$ret .= '<ul></div>';
	$ret .= '<div class="clear"></div>';			
	wp_reset_postdata();
	
	return $ret;
}

function wpha_get_testimonials_style_1( $settings ){
	$mypost = $settings['post'];
	$image_src_full = $settings['image_src_full'];
	$title_num_fetch = $settings['title_num_fetch'];
	return '
	<li>
		<div class="kode-text">
			<p>"'.strip_tags(mb_substr($mypost->post_content,0,$settings['num-excerpt'])).'"</p>
			<div class="client-name">
				<h4>'.esc_attr($mypost->post_title).esc_attr($testimonial_option['designation']).'</h4>
				<div class="kode-thumb">
					<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($mypost->ID, array(80,80)).'</a>
				</div>
			</div>
		</div>
	</li>';
}

function wpha_get_testimonials_style_2( $settings ){
	$mypost = $settings['post'];
	$image_src_full = $settings['image_src_full'];
	$title_num_fetch = $settings['title_num_fetch'];
	
	$testimonials = "
	 <li>
	  <i>''</i>
	 <p>".strip_tags(mb_substr($mypost->post_content,0,$settings['num_excerpt']))."</p>
	  <span>".esc_attr($settings['designation'])."</span>
	</li>";
	
	return $testimonials;
}

function wpha_get_testimonials_style_3( $settings ){
	$mypost = $settings['post'];
	$all_review = '';
	$image_src_full = $settings['image_src_full'];
	$title_num_fetch = $settings['title_num_fetch'];
	
	return '
	<li>
		<h2>'.esc_attr($mypost->post_title).'</h2>
		<p>'.strip_tags(mb_substr($mypost->post_content,0,$settings['num_excerpt'])).'</p>
		<a href="'.esc_url($mypost->guid).'">'.esc_attr($settings['designation']).'</a>
	</li>';
}


function wpha_get_testimonials_style_4( $settings ){
	$mypost = $settings['post'];
	$all_review = '';
	$image_src_full = $settings['image_src_full'];
	$title_num_fetch = $settings['title_num_fetch'];
	
	return '';
}


function wpha_get_testimonials_style_5( $settings ){
	$mypost = $settings['post'];
	$image_src_full = $settings['image_src_full'];
	$title_num_fetch = $settings['title_num_fetch'];
	
	return '';
}