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

	function wpha_teams_filter_category($settings){
		$teams = '';
		$parent = array('all'=>__('All', 'kode_forest'));
		if( empty($settings['category']) ){
			$parent = array('all'=>__('All', 'kode_forest'));
			$settings['category-id'] = '';
		}else{
			$term = get_term_by('slug', $settings['category'], 'team-category');
			//$parent = array($settings['category']=>$term->name);
			if(isset($term->term_id)){
				$settings['category-id'] = $term->term_id;
			}else{
				$settings['category-id'] = '';
			}
			
		}
		if(isset($settings['filter-category']) && $settings['filter-category'] == 'show'){
			$teams = '';
			$filter_active = 'active';
			$teams_category = $parent + explode(',', $settings['category']);
			$teams .= '<div class="top-category-list"><ul data-type="print_all_teamss" data-style="'.esc_attr($settings['style']).'" class="kf_filtrable_pinter" data-nouce="'.esc_attr(wp_create_nonce('validate-post-information')).'" data-ajax="'.esc_url(admin_url( 'admin-ajax.php' )).'">';
			foreach($teams_category as $filter_id => $filter){	
				$term = get_term_by('term_id', $filter, 'team-category');			
				$teams .= '<li class="' . esc_attr($filter_active) . '">';
				$teams .= '<span class="kode-button" ';
				$teams .= 'data-value="' . esc_attr($filter) . '" >' . esc_attr($filter) . '</span></li>';
				$filter_active = '';
			}
			$teams .= '</ul></div>';
			
		}
		
		$teams_ajax  = '<div class="wpha-loader-wrapper"><span></span></div>';
		
		return array('html'=>$teams,'jax_wrapper'=>$teams_ajax);
	}
	
	function wpha_filter_query_exe_team($settings,$args){
		//Get Query
		
		if(isset($settings['filter']) && $settings['filter'] == 'show'){
			if(isset($_GET['style']) && $_GET['style'] == 'style-1'){
				$settings['style'] = 'style-1';
			}else if(isset($_GET['style']) && $_GET['style'] == 'full'){				
				$settings['style'] = 'style-2';
			}else{
				
			}
			
			if(isset($_GET['order']) && $_GET['order'] == 'asc'){
				$args['order'] = 'asc';
			}else if(isset($_GET['order']) && $_GET['order'] == 'desc'){
				$args['order'] = 'desc';
			}else{
				
			}
			
			if(isset($_GET['orderby']) && $_GET['orderby'] == 'date'){
				$args['orderby'] = 'date';
			}else if(isset($_GET['order']) && $_GET['order'] == 'title'){
				$args['orderby'] = 'title';
			}else if(isset($_GET['order']) && $_GET['order'] == 'rand'){
				$args['orderby'] = 'rand';
			}else{
				
			}
		}
		
		return $args;
		
	}
	
	function wpha_filter_query_html_team($query,$settings){
		$teams = '';
		$settings['filter_title'] = (empty($settings['filter_title']))? '15': $settings['filter_title'];
		if(isset($settings['filter']) && $settings['filter'] == 'show'){
			$layout_select_full = add_query_arg( 'style', 'full' , esc_url(get_permalink()) );	
			$layout_select_grid = add_query_arg( 'style', 'grid' , esc_url(get_permalink()) );	
			$post_total_count = $query->post_count;
			$teams  .= '
			<!--Destination Meta Wrap Start-->
			
			<div class="wpha_filter_meta col-md-12">								
				<form action="'.esc_url(get_permalink()).'" method="get">
					<!--SEARCH FILTER START-->
					<div class="wpha-hotal-iteams">
						<div class="wpha-up-hotal-content">
							<div class="row">
								<div class="wpha_hotel_view col-md-5">		
									<h4>Top '.esc_attr($settings['filter_title']).'</h4>
									<p>Total '.esc_attr($post_total_count).' '.esc_attr($settings['filter_title']).'</p>
								</div>
								<div class="wpha_hotel_view col-md-2">												
									<a href="'.esc_url($layout_select_full).'"><i class="fa fa-th-list"></i></a>
									<a href="'.esc_url($layout_select_grid).'"><i class="fa fa-th-large"></i></a>
								</div>
								<div class="wpha-up-right col-md-5 col-xs-12">
									<div class="row">
										<div class="col-md-6">
											<select onchange="this.form.submit()" name="orderby" class="chosen-select">
												<option value="any">'.esc_attr__('Any','kode-teams-list').'</option>';
												$teams  .= '
												<option ';
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'date'){$teams  .= 'selected';}
												$teams  .= '
												 value="date">'.esc_attr__('Publish Date','kode-teams-list').'</option>';
												$teams  .= '
												<option ';
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'title'){$teams  .= 'selected';}
												$teams  .= ' value="title">'.esc_attr__('Title','kode-teams-list').'</option> <option ';							
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'rand'){$teams  .= 'selected';}
												$teams  .= ' 
												 value="rand">'.esc_attr__('Random','kode-teams-list').'</option>
											</select>
										</div>
										<div class="col-md-6">
											<select onchange="this.form.submit()" name="order" class="chosen-select">
												<option value="any">'.esc_attr__('Any','kode-woo-list').'</option>';
												$teams  .= '
												<option ';
												if(isset($_GET['order']) && $_GET['order'] == 'asc'){$teams  .= 'selected';}
												$teams  .= '
												 value="asc">'.esc_attr__('ASC','kode-woo-list').'</option>';
												$teams  .= '
												<option ';
												if(isset($_GET['order']) && $_GET['orderby'] == 'desc'){$teams  .= 'selected';}
												$teams  .= ' value="desc">'.esc_attr__('DESC','kode-woo-list').'</option>
											</select>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!--SEARCH FILTER END-->
				</form>
			</div>
			<!--Destination Meta Wrap End-->';
		}
		return $teams;
	}
	
	function wpha_get_teams_item( $settings = array() ){
		$item_id = empty($settings['element_item_id'])? '': ' id="' . $settings['element_item_id'] . '" ';

		global $wpha_spaces;
		$margin = (!empty($settings['margin_bottom']) && 
			$settings['margin_bottom'] != '')? 'margin-bottom: ' . esc_attr($settings['margin_bottom']) . 'px;': '';
		$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
		
		//$ret  = wpha_get_item_title($settings);
		$ret = '';
		$ret .= '<div class="wpha-item-wrapper"  ' . $item_id . $margin_style . '>';
		
		// query post and sticky post
		$args = array('post_type' => 'team', 'suppress_filters' => false);
		if( !empty($settings['category']) || !empty($settings['tag']) ){
			$args['tax_query'] = array('relation' => 'OR');
			
			if( !empty($settings['category']) ){
				array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'team-category', 'field'=>'slug'));
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

		//Filter HTML Print Here
		$filter = wpha_teams_filter_category($settings);
		
		$ret .= $filter['html'];
		
		
		
		//Execution of Filter
		$args = wpha_filter_query_exe_team($settings,$args);
		
		$query = new WP_Query( $args );
		
		$ret .= wpha_filter_query_html_team($query,$settings);
		// set the excerpt length
		if( !empty($settings['num_excerpt']) ){
			global $wpha_excerpt_length; $wpha_excerpt_length = $settings['num_excerpt'];
			add_filter('excerpt_length', 'wpha_set_excerpt_length');
		} 
		
		// get teams by the teams style
		global $wpha_post_settings, $wpha_lightbox_id;
		$wpha_lightbox_id++;
		$wpha_post_settings['num_excerpt'] = $settings['num_excerpt'];
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];	
		$wpha_post_settings['style'] = $settings['style'];	
		
		$ret .= $filter['jax_wrapper'];
		
		$ret .= '<div class="wpha-item-holder">';
		if($settings['style'] == 'style-1'){
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic '.esc_attr($settings['padding']).'">';
			$ret .= '<div class="row">';
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$teams_size = $settings['column_size'];	
			$ret .= wpha_get_teams_full($query, $teams_size, $settings);
			$ret .= '</div>';
			$ret .= '</div>';
		}else if(strpos($settings['style'], 'style-2') !== false){
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$teams_size = $settings['column_size'];	
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic '.esc_attr($settings['padding']).'">';
			$ret .= '<div class="row">';
			$ret .= wpha_get_teams_grid($query, $teams_size, $settings);			
			$ret .= '</div>';
			$ret .= '</div>';
		}else if(strpos($settings['style'], 'style-3') !== false){
			$teams_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic">';
			$ret .= '<div class="row">';
			$ret .= wpha_get_teams_list($query, $teams_size, $settings);
			$ret .= '</div>';
			$ret .= '</div>';
		}else if(strpos($settings['style'], 'style-4') !== false){
			$teams_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic '.esc_attr($settings['padding']).'">';
			$ret .= '<div class="row">';
			$ret .= wpha_get_teams_widget($query, $teams_size, $settings);
			$ret .= '</div>';
			$ret .= '</div>';
		}else if(strpos($settings['style'], 'style-5') !== false){
			$teams_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic '.esc_attr($settings['padding']).'">';
			$ret .= '<div class="row">';
			$ret .= wpha_get_teams_modern_normal_5($query, $teams_size, $settings);
			$ret .= '</div>';
			$ret .= '</div>';
		}else{
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$teams_size = $settings['column_size'];
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-teams kode-teams-classic '.esc_attr($settings['padding']).'">';
			$ret .= '<div class="row">';
			$ret .= wpha_get_teams_grid($query, $teams_size, $settings);			
			$ret .= '</div>';
			$ret .= '</div>';
		}
		$ret .= '</div>
		<div class="clearfix clear"></div>';
		
		if( $settings['pagination'] == 'true' ){
			$ret .= wp_elementor_get_pagination($query->max_num_pages, $args['paged']);
		}
		$ret .= '</div>'; // teams-item-wrapper
		
		remove_filter('excerpt_length', 'wpha_set_excerpt_length');
		return $ret;
	}
	
	
	//////////////////////////////////////////////////////////////////
	// Destination Item Meta Info
	//////////////////////////////////////////////////////////////////
	function wpha_get_teams_info( $teams_id='', $array = array(), $wrapper = true, $sep = '',$div_wrap = 'div' ){
		global $wpha_plugin_option; $ret = '';
		if( empty($array) ) return $ret;
		//$exclude_meta = empty($wpha_plugin_option['post-meta-data'])? array(): esc_attr($wpha_plugin_option['post-meta-data']);
		
		foreach($array as $post_info){
			
			if( !empty($sep) ) $ret .= $sep;

			switch( $post_info ){
				case 'date':
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-date"><i class="fa fa-clock-o"></i>';
					$ret .= '<a href="' . esc_url(get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d'))) . '">';
					$ret .= esc_attr(get_the_time());
					$ret .= '</a>';
					$ret .= '</'.esc_attr($div_wrap).'>';
					break;
				case 'features':
					$tag = get_the_term_list($teams_id, 'features', '', ' ' , '' );
					if(empty($tag)) break;					
					
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-tags">';
					$ret .= $tag;						
					$ret .= '</'.esc_attr($div_wrap).'>';					
					break;
				case 'state':
					$category = get_the_term_list($teams_id, 'state', '', ' ' , '' );
					if(empty($category)) break;
					
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-category">';
					$ret .= $category;					
					$ret .= '</'.esc_attr($div_wrap).'>';			
					break;
				case 'comment':
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-comment"><i class="fa fa-comment-o"></i>';
					$ret .= '<a href="' . esc_url(get_permalink($teams_id)) . '#respond" >' . esc_attr(get_comments_number()) . ' Comments</a>';						
					$ret .= '</'.esc_attr($div_wrap).'>';					
					break;
				case 'views':
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-views"><i class="fa fa-eye"></i>';
					$ret .= '<a href="' . esc_url(get_permalink($teams_id)) . '" >' . esc_attr(wpha_get_teams_views(get_the_ID())) . '<em>' . esc_html__('Views','real-estate').' </em></a>';
					$ret .= '</'.esc_attr($div_wrap).'>';							
					break;		
				case 'author':
					ob_start();
					the_author_posts_link();
					$author = ob_get_contents();
					ob_end_clean();
					
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-author"><i class="fa fa-user"></i>';
					$ret .= $author;
					$ret .= '</'.esc_attr($div_wrap).'>';			
					break;						
			}
		}
		
		if($wrapper && !empty($ret)){
			return '<div class="wpha-teamsadvisor-info wpha-info-new">' . $ret . '<div class="clear"></div></div>';
		}else if( !empty($ret) ){
			return $ret;
		}
		return '';			
	}
	
	function wpha_get_teams_list($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
	
		$ret = ''; $current_size = 0;				
		
		while($query->have_posts()){ $query->the_post();
		global $post;
			
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}

			$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
			$ret .= '<div class="kode-ux kode-teams-widget-ux">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			$item_id = 'vt_teams_'.$post->ID;
			// $votes = wpha_get_voting_by_id($item_id);
			
			// $settings['votes'] = $votes;
			
			$ret .= wpha_get_teams_style_3( $settings );
			
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
	
	
	function wpha_get_teams_widget($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
	
		$ret = ''; $current_size = 0;				
		
		while($query->have_posts()){ $query->the_post();
		global $post;
			
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}

			$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
			$ret .= '<div class="kode-ux kode-teams-widget-ux">';
			
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_teams_style_4( $settings );
			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // column_class
			$current_size ++;
		}
		$ret .= '<div class="clear"></div>';
		//$ret .= '</div>'; // close the kode-isotope
		wp_reset_postdata();
		
		return $ret;
	}

	function wpha_get_teams_grid($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
		
		
		$ret = ''; $current_size = 0;			
		//$ret .= '<div class="kode-isotope" data-type="teams" data-layout="' . $teams_layout  . '" >';
		while($query->have_posts()){ $query->the_post();
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clearfix clear"></div>';
			}

			$ret .= '<div class="col-sm-6 col-xs-12 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-ux kode-teams-grid-ux">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_teams_style_2( $settings );
			
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

	function wpha_get_teams_full($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		while($query->have_posts()){ $query->the_post();
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-teams-single-full ">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_teams_style_1( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_teams_modern_normal($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		while($query->have_posts()){ $query->the_post();
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-teams-single-full ">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_teams_style_1( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	
	function wpha_get_teams_modern_normal_5($query, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_teams_grid_carousel($query, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		while($query->have_posts()){ $query->the_post();
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-teams-single-full ">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $post;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_teams_style_5( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_teams_grid_carousel($query, $size,$settings){
		
		$ret = ''; 			
		
		$ret .= '<div class="owl-carousel owl-theme" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';			
		while($query->have_posts()){ $query->the_post();
		global $post;
			$ret .= '<div class="item">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
			$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
			$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
			$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
			$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
			$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
			$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
			$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
			$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			
			$settings['post'] = $post;

			$settings['votes'] = '';
			
			if(isset($settings['style']) && $settings['style'] == 'style-1'){
				$ret .= wpha_get_teams_style_1($settings);
			}else if(isset($settings['style']) && $settings['style'] == 'style-2'){
				$ret .= wpha_get_teams_style_2($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'style-3'){
				$ret .= wpha_get_teams_style_3($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'style-4'){
				$ret .= wpha_get_teams_style_4($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'style-5'){
				$ret .= wpha_get_teams_style_5($settings);	
			}
			
			$ret .= ob_get_contents();
			
			ob_end_clean();					
			$ret .= '</div>'; // kode-item
		}
		$ret .= '</div>';
		$ret .= '<div class="clear"></div>';			
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_teams_style_1( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		
		return '
			<div class="city_team_fig">
				<figure class="overlay-event-detail">
					'.get_the_post_thumbnail($mypost->ID, $settings['thumbnail_size']).'
					<div class="city_top_social">
						<ul>
							<li><a href="'.esc_url($settings['facebook']).'"><i class="fa fa-facebook"></i></a></li>
							<li><a href="'.esc_url($settings['twitter']).'"><i class="fa fa-twitter"></i></a></li>
							<li><a href="'.esc_url($settings['linkedin']).'"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="'.esc_url($settings['youtube']).'"><i class="fa fa-youtube"></i></a></li>
						</ul>
					</div>
				</figure>
				<div class="city_team_text">
					<h4><a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr(substr(get_the_title($mypost->ID),0,$title_num_fetch)).'</a></h4>
					<p>'.esc_attr($settings['designation']).'</p>
				</div>
			</div>';
	}
	
	function wpha_get_teams_style_2( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		
		$teams = '
		<div class="city_senior_team">
			<figure class="box">
				<div class="box-layer layer-1"></div>
				<div class="box-layer layer-2"></div>
				<div class="box-layer layer-3"></div>
				'.get_the_post_thumbnail($mypost->ID, $settings['thumbnail_size']).'
			</figure>
			<div class="city_senior_team_text">
				<span>'.esc_attr($settings['designation']).'</span>
				<h5>'.esc_attr(substr(get_the_title($mypost->ID),0,$title_num_fetch)).'</h5>
				<a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr($settings['phone']).'</a>
				<a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_url($settings['website']).'</a>
			</div>
		</div>';
		
		return $teams;
	}
	
	function wpha_get_teams_style_3( $settings ){
		$mypost = $settings['post'];
		$all_review = '';
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		
		return '		
			<div class="teams-grid-03 hover-effect-01">
				<figure>
					'.get_the_post_thumbnail($mypost->ID, $settings['thumbnail_size']).'
					<div class="hover-content-01"></div>
					<div class="hover-plus">
						<a class="radio-btn-2" href="'.esc_url(get_permalink($mypost->ID)).'" data-rel="prettyPhoto"></a>
					</div>
				</figure>
				<div class="teams-content-03">
					<h6><a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr(substr(get_the_title($mypost->ID),0,$title_num_fetch)).'</a></h6>
					<ul class="meta_tag">
						<li><span class="fa fa-sun-o"></span><a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr($settings['votes']).' Likes</a></li>
						<li><span class="icon-location-2"></span><a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr($all_review).' Reviews</a></li>
					</ul>
				</div>
			</div>';
	}
	
	
	function wpha_get_teams_style_5( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		

		return '
		<div class="team-grid">
			<figure>'.get_the_post_thumbnail($mypost->ID, $settings['thumbnail_size']).'</figure>
			<div class="team-grid-content">
				<h4><a href="'.esc_url(get_permalink($mypost->ID)).'">'.esc_attr(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>
				<strong>'.esc_attr($settings['designation']).'</strong>
				<div class="clearfix clear"></div>
				<div class="city_top_social">
					<ul>
						<li><a href="'.esc_url($settings['facebook']).'"><i class="fa fa-facebook"></i></a></li>
						<li><a href="'.esc_url($settings['twitter']).'"><i class="fa fa-twitter"></i></a></li>
						<li><a href="'.esc_url($settings['linkedin']).'"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="'.esc_url($settings['youtube']).'"><i class="fa fa-youtube"></i></a></li>
					</ul>
				</div>
			</div>
		</div>';
	}
	
	
	// Related Posts Function, matches posts by tags - call using joints_related_posts(); )
	function wpha_related_team_member($post_id) {
		global $post,$council_admin_option;	
		
		$tags = wp_get_post_terms($post_id, 'team-category', array("fields" => "all"));
		$tag_arr = '';
		if($tags) {
			if(isset($tags)){
				foreach( $tags as $tag ) {
					$tag_arr .= $tag->slug . ',';
				}
				
				if( !empty($tag_arr)){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($tag_arr)){
						array_push($args['tax_query'], array('terms'=>explode(',', $tag_arr), 'taxonomy'=>'team-category', 'field'=>'slug'));
					}				
				}
				
				$args['post_type'] = 'team';
				$args['numberposts'] = 3;
				$args['post__not_in'] = array($post_id);
			
				
				$related_posts = get_posts( $args );			
				if($related_posts) {
					echo '<div class="mayor_team">					
						<div class="section_heading center">
							<span>Goverment</span>
							<h2>Related Memeber</h2>
						</div>';
						foreach ( $related_posts as $post ) : setup_postdata( $post );
						$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($post->ID, 'post-option', true ));
						if( !empty($wpha_post_option) ){
							$wpha_post_option = json_decode( $wpha_post_option, true );
						}
						$settings['designation'] = (empty($wpha_post_option['designation']))? '': $wpha_post_option['designation'];
						$settings['location'] = (empty($wpha_post_option['location']))? '': $wpha_post_option['location'];
						$settings['phone'] = (empty($wpha_post_option['phone']))? '': $wpha_post_option['phone'];
						$settings['website'] = (empty($wpha_post_option['website']))? '': $wpha_post_option['website'];
						$settings['email'] = (empty($wpha_post_option['email']))? '': $wpha_post_option['email'];
						$settings['facebook'] = (empty($wpha_post_option['facebook']))? '': $wpha_post_option['facebook'];
						$settings['twitter'] = (empty($wpha_post_option['twitter']))? '': $wpha_post_option['twitter'];
						$settings['youtube'] = (empty($wpha_post_option['youtube']))? '': $wpha_post_option['youtube'];
						$settings['linkedin'] = (empty($wpha_post_option['linkedin']))? '': $wpha_post_option['linkedin'];
						?>
							<div class="col-md-4 col-sm-6">
								<div class="city_team_fig">
									<figure class="overlay-event-detail">
										<img src="<?php echo esc_url($image_src[0])?>" alt="<?php the_title(); ?>">
										<div class="city_top_social">
											<ul>
												<li><a href="<?php echo esc_url($settings['facebook']);?>"><i class="fa fa-facebook"></i></a></li>
												<li><a href="<?php echo esc_url($settings['twitter']);?>"><i class="fa fa-twitter"></i></a></li>
												<li><a href="<?php echo esc_url($settings['linkedin']);?>"><i class="fa fa-linkedin"></i></a></li>
												<li><a href="<?php echo esc_url($settings['youtube']);?>"><i class="fa fa-youtube"></i></a></li>
											</ul>
										</div>
									</figure>
									<div class="city_team_text">
										<h4><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
										<p><?php echo esc_attr($settings['designation'])?></p>
									</div>
								</div>
							</div>
						<?php endforeach;
						echo '</div>';
					
				} wp_reset_postdata();
		
				echo '</div>';
			}
		}
	}