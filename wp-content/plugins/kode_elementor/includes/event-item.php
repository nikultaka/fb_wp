<?php
	function wpha_events_filter_category($settings){
		$events = '';
		$parent = array('all'=>__('All', 'council'));
		if( empty($settings['category']) ){
			$parent = array('all'=>__('All', 'council'));
			$settings['category-id'] = '';
		}else{
			$term = get_term_by('slug', $settings['category'], 'event-categories');
			
			if(isset($term->term_id)){
				$settings['category-id'] = $term->term_id;
			}else{
				$settings['category-id'] = '';
			}
			
		}
		if(isset($settings['filter-category']) && $settings['filter-category'] == 'show'){
			$events = '';
			$filter_active = 'active';
			$events_category = $parent + explode(',', $settings['category']);
			$events .= '<div class="top-category-list"><ul data-type="print_all_eventss" data-style="'.esc_attr($settings['style']).'" class="kf_filtrable_pinter" data-nouce="'.esc_attr(wp_create_nonce('validate-post-information')).'" data-ajax="'.esc_url(admin_url( 'admin-ajax.php' )).'">';
			foreach($events_category as $filter_id => $filter){	
				$term = get_term_by('term_id', $filter, 'event-categories');			
				$events .= '<li class="' . esc_attr($filter_active) . '">';
				$events .= '<span class="kode-button" ';
				$events .= 'data-value="' . esc_attr($filter) . '" >' . esc_html($filter) . '</span></li>';
				$filter_active = '';
			}
			$events .= '</ul></div>';
			
		}
		
		$events_ajax  = '<div class="wpha-loader-wrapper"><span></span></div>';
		
		return array('html'=>$events,'jax_wrapper'=>$events_ajax);
	}
	
	function wpha_filter_query_events_exe($settings,$args){
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
	
	function wpha_filter_html_show_event($query_events,$settings){
		$events = '';
		$settings['filter_title'] = (empty($settings['filter_title']))? '15': $settings['filter_title'];
		if(isset($settings['filter']) && $settings['filter'] == 'show'){
			$layout_select_full = add_query_arg( 'style', 'full' , esc_url(get_permalink()) );	
			$layout_select_grid = add_query_arg( 'style', 'grid' , esc_url(get_permalink()) );	
			$post_total_count = $query_events->post_count;
			$events  .= '
			<!--Events Meta Wrap Start-->
			
			<div class="wpha_filter_meta col-md-12">								
				<form action="'.esc_url(get_permalink()).'" method="get">
					<!--SEARCH FILTER START-->
					<div class="wpha-hotal-iteams">
						<div class="wpha-up-hotal-content">
							<div class="row">
								<div class="wpha_hotel_view col-md-5">		
									<h4>Top '.esc_html($settings['filter_title']).'</h4>
									<p>Total '.esc_html($post_total_count).' '.esc_html($settings['filter_title']).'</p>
								</div>
								<div class="wpha_hotel_view col-md-2">												
									<a href="'.esc_url($layout_select_full).'"><i class="fa fa-th-list"></i></a>
									<a href="'.esc_url($layout_select_grid).'"><i class="fa fa-th-large"></i></a>
								</div>
								<div class="wpha-up-right col-md-5 col-xs-12">
									<div class="row">
										<div class="col-md-6">
											<select onchange="this.form.submit()" name="orderby" class="chosen-select">
												<option value="any">'.esc_html__('Any','council').'</option>';
												$events  .= '
												<option ';
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'date'){$events  .= 'selected';}
												$events  .= '
												 value="date">'.esc_html__('Publish Date','council').'</option>';
												$events  .= '
												<option ';
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'title'){$events  .= 'selected';}
												$events  .= ' value="title">'.esc_html__('Title','council').'</option> <option ';							
												if(isset($_GET['orderby']) && $_GET['orderby'] == 'rand'){$events  .= 'selected';}
												$events  .= ' 
												 value="rand">'.esc_html__('Random','council').'</option>
											</select>
										</div>
										<div class="col-md-6">
											<select onchange="this.form.submit()" name="order" class="chosen-select">
												<option value="any">'.esc_html__('Any','council').'</option>';
												$events  .= '
												<option ';
												if(isset($_GET['order']) && $_GET['order'] == 'asc'){$events  .= 'selected';}
												$events  .= '
												 value="asc">'.esc_html__('ASC','council').'</option>';
												$events  .= '
												<option ';
												if(isset($_GET['order']) && $_GET['orderby'] == 'desc'){$events  .= 'selected';}
												$events  .= ' value="desc">'.esc_html__('DESC','council').'</option>
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
			<!--Events Meta Wrap End-->';
		}
		return $events;
	}
	
	function wpha_get_events_item( $settings = array() ){
		$item_id = empty($settings['element_item_id'])? '': ' id="' . $settings['element_item_id'] . '" ';

		global $wpha_spaces;
		$margin = (!empty($settings['margin_bottom']) && 
			$settings['margin_bottom'] != '')? 'margin-bottom: ' . esc_attr($settings['margin_bottom']) . 'px;': '';
		$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';
		
		$order = 'DESC';
		$limit = 10;//Default limit
		$offset = '';		
		$rowno = 0;
		
		
		$ret = '';
		$ret .= '<div class="wpha-item-wrapper"  ' . $item_id . $margin_style . '>';
		
		// query_events post and sticky post
		$args = array('post_type' => 'event', 'suppress_filters' => false);
		if( !empty($settings['category']) || !empty($settings['tag']) ){
			$args['tax_query'] = array('relation' => 'OR');
			
			if( !empty($settings['category']) ){
				array_push($args['tax_query'], array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'event-categories', 'field'=>'slug'));
			}
			
		}

		$args['posts_per_page'] = (empty($settings['num_fetch']))? '5': $settings['num_fetch'];
		$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
		$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
		$settings['listing'] = (empty($settings['listing']))? '': $settings['listing'];
		$settings['padding'] = (empty($settings['padding']))? '': $settings['padding'];
		$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
		$args['paged'] = empty($args['paged'])? 1: $args['paged'];
		
		$settings['title_num_fetch'] = empty($settings['title_num_excerpt'])? '300': $settings['title_num_excerpt'];
		if(isset($settings['title_num_fetch']) && $settings['title_num_fetch'] == '-1'){
			$settings['title_num_fetch'] = 500;
		}

		//Filter HTML Print Here
		$filter = wpha_events_filter_category($settings);
		
		$ret .= $filter['html'];
		
		
		
		//Execution of Filter
		$args = wpha_filter_query_events_exe($settings,$args);
		
		
		$argu = array('pagination'=>1,'category'=>$settings['category'], 'group'=>'this','scope'=>$settings['scope'], 'limit' => $settings['num_fetch'], 'order' => $settings['order']);
		$argu['page'] = (!empty($_REQUEST['pno']) && is_numeric($_REQUEST['pno']) )? $_REQUEST['pno'] : 1;
		$query_events = EM_Events::get( $argu );
		$events_count = EM_Events:: count( $argu );	
		
		
		$ret .= wpha_filter_html_show_event($query_events,$settings);
		// set the excerpt length
		if( !empty($settings['num_excerpt']) ){
			global $wpha_excerpt_length; $wpha_excerpt_length = $settings['num_excerpt'];
			add_filter('excerpt_length', 'council_set_excerpt_length');
		} 
		
		// get events by the events style
		global $wpha_post_settings, $wpha_lightbox_id;
		$wpha_lightbox_id++;
		$wpha_post_settings['num_excerpt'] = $settings['num_excerpt'];
		$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];	
		$wpha_post_settings['style'] = $settings['style'];	
		
		$ret .= $filter['jax_wrapper'];
		
		$ret .= '<div class="wpha-item-holder">';
		
		if($settings['style'] == 'event-simple-view'){
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$events_size = $settings['column_size'];	
			$ret .= wpha_get_events_simple_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-grid-view'){
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$events_size = $settings['column_size'];	
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_grid_view($query_events, $events_size, $settings);			
			$ret .= '</div>';
		}else if($settings['style'] == 'event-medium-view'){
			$events_size = $settings['column_size'];
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_medium_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-medium-modern-view'){
			$events_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_medium_modern_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-full-view'){
			$events_size = 1;	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_full_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-news-view'){
			$events_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_news_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-calendar-view'){
			$events_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_calendar_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else if($settings['style'] == 'event-marker-view'){
			$events_size = $settings['column_size'];	
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$wpha_post_settings['num_excerpt'] = intval($settings['num_excerpt']);
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_marker_view($query_events, $events_size, $settings);
			$ret .= '</div>';
		}else{
			$wpha_post_settings['thumbnail_size'] = $settings['thumbnail_size'];
			$events_size = $settings['column_size'];
			$wpha_post_settings['title_num_fetch'] = $settings['title_num_fetch'];
			$ret .= '<div class="wpha-listing-item kode-events kode-events-classic '.esc_attr($settings['padding']).'">';
			$ret .= wpha_get_events_grid_view($query_events, $events_size, $settings);			
			$ret .= '</div>';
		}
		$ret .= '</div>
		<div class="clearfix clear"></div>';
		
		if( $settings['pagination'] == 'true' ){
			$ret .= '<div class="kode-pagination col-md-12">';
			$ret .= EM_Events::get_pagination_links($argu, $events_count);
			$ret .= '</div>';
		}
		$ret .= '</div>'; // events-item-wrapper
		
		
		return $ret;
	}
	
	//////////////////////////////////////////////////////////////////
	// Events Item Meta Info
	//////////////////////////////////////////////////////////////////
	function wpha_get_events_info( $events_id='', $array = array(), $wrapper = true, $sep = '',$div_wrap = 'div' ){
		global $wpha_plugin_option; $ret = '';
		if( empty($array) ) return $ret;
		
		
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
				case 'tags':
					$tag = get_the_term_list($events_id, 'event-tags', '', ' ' , '' );
					if(empty($tag)) break;					
					
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-tags">';
					$ret .= $tag;						
					$ret .= '</'.esc_attr($div_wrap).'>';					
					break;
				case 'category':
					$category = get_the_term_list($events_id, 'event-categories', '', ' ' , '' );
					if(empty($category)) break;
					
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-category">';
					$ret .= $category;					
					$ret .= '</'.esc_attr($div_wrap).'>';			
					break;
				case 'comment':
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-comment"><i class="fa fa-comment-o"></i>';
					$ret .= '<a href="' . esc_url(get_permalink($events_id)) . '#respond" >' . esc_html(get_comments_number()) . ' Comments</a>';						
					$ret .= '</'.esc_attr($div_wrap).'>';					
					break;
				case 'views':
					$ret .= '<'.esc_attr($div_wrap).' class="wpha-info wpha-views"><i class="fa fa-eye"></i>';
					$ret .= '<a href="' . esc_url(get_permalink($events_id)) . '" >' . esc_html(wpha_get_events_views($events_id)) . '<em>' . esc_html__('Views','council').' </em></a>';
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
			return '<div class="wpha-eventsadvisor-info wpha-info-new">' . $ret . '<div class="clear"></div></div>';
		}else if( !empty($ret) ){
			return $ret;
		}
		return '';			
	}
	
	function wpha_get_events_simple_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
	
		$ret = ''; $current_size = 0;				
		
		foreach ( $query_events as $event ) {
		global $post;
			
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			ob_start();
			
			$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
			$ret .= '<div class="kode-ux kode-events-widget-ux">';
			
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$item_id = 'vt_events_'.$event->post_id;
			
			$ret .= wpha_get_events_style_simple_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // column_class
			$current_size ++;
		}
		$ret .= '<div class="clear"></div>';
		
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_grid_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
	
		$ret = ''; $current_size = 0;				
		
		foreach ( $query_events as $event ) {
		global $post;
			
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			
			
			ob_start();
			
			
			$ret .= '<div class="col-sm-6 ' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';			
			$ret .= '<div class="kode-ux kode-events-widget-ux">';
			
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$item_id = 'vt_events_'.$event->post_id;
			
			$ret .= wpha_get_events_style_grid_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // column_class
			$current_size ++;
		}
		$ret .= '<div class="clear"></div>';
		
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_medium_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_medium_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_full_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_full_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_calendar_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_list( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_marker_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_list( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_news_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_news_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_medium_modern_view($query_events, $size, $settings){
		
		if(isset($settings['listing']) && $settings['listing'] == 'slider'){ return wpha_get_events_grid_carousel($query_events, $size, $settings); }
		
		$ret = '';$current_size = 0;
		
		foreach ( $query_events as $event ) {
		global $post;
			if( $current_size % $size == 0 ){
				$ret .= '<div class="clear"></div>';
			}
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$ret .= '<div class="' . esc_attr(wpha_get_column_class_updated('1/' . $size)) . '">';
			$ret .= '<div class="kode-item kode-events-single-full ">';
			ob_start();
			
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			$settings['post'] = $event;
			
			$settings['votes'] = '';
			
			$ret .= wpha_get_events_style_medium_modern_view( $settings );
			
			$ret .= ob_get_contents();
			
			ob_end_clean();			
			$ret .= '</div>'; // kode-ux
			$ret .= '</div>'; // kode-item
			$current_size++;
		}
		wp_reset_postdata();
		
		return $ret;
	}
	
	function wpha_get_events_grid_carousel($query_events, $size, $settings){
		
		$ret = ''; 			
		
		$ret .= '<div class="owl-carousel owl-theme" data-medium-slide="'.esc_attr($size).'" data-slide="'.esc_attr($size).'" data-small-slide="'.esc_attr($size).'" >';			
		foreach ( $query_events as $event ) {
			global $post;
			$ret .= '<div class="item">';
			ob_start();
			$wpha_post_option = wpha_decode_stopbackslashes(get_post_meta($event->post_id, 'post-option', true ));
			if( !empty($wpha_post_option) ){
				$wpha_post_option = json_decode( $wpha_post_option, true );
			}
			$settings['events_price'] = (empty($wpha_post_option['events_price']))? '': $wpha_post_option['events_price'];
			$settings['events_icons'] = (empty($wpha_post_option['events_icons']))? '': $wpha_post_option['events_icons'];
			$image_src_full = wp_get_attachment_image_src(get_post_thumbnail_id($event->post_id), array(1170,350));
			
			$settings['image_src_full'] = $image_src_full;
			$settings['num_excerpt'] = $settings['num_excerpt'];
			
			$settings['post'] = $event;

			$settings['votes'] = '';
			
			if(isset($settings['style']) && $settings['style'] == 'event-simple-view'){
				$ret .= wpha_get_events_style_simple_view($settings);
			}else if(isset($settings['style']) && $settings['style'] == 'event-grid-view'){
				$ret .= wpha_get_events_style_grid_view($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'event-medium-view'){
				$ret .= wpha_get_events_style_medium_view($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'event-medium-modern-view'){
				$ret .= wpha_get_events_style_medium_modern_view($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'event-full-view'){
				$ret .= wpha_get_events_style_full_view($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'event-calendar-view'){
				$ret .= wpha_get_events_style_calendar_view($settings);	
			}else if(isset($settings['style']) && $settings['style'] == 'event-marker-view'){
				$ret .= wpha_get_events_style_marker_view($settings);	
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
	
	function wpha_get_events_style_simple_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_month_m = date('M',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));
		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_html($mypost->get_location()->location_address);	
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_html($start_time);						
			$end_time = esc_html($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		return '		
		<div class="city_event2_fig">
			<figure class="box">
				<div class="box-layer layer-1"></div>
				<div class="box-layer layer-2"></div>
				<div class="box-layer layer-3"></div>
				'.get_the_post_thumbnail($mypost->post_id, $settings['thumbnail_size']).'
			</figure>
			<div class="city_event2_list">
				<div class="city_event2_date">
					<strong>'.esc_html($event_day).'</strong>
					<span>'.esc_html($event_month_m).' '.esc_html($event_year).'</span>
				</div>
				<div class="city_event2_text">
					'.wpha_get_events_info($mypost->post_id,array('category'),'','','span').'
					<h4><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>
					<ul>
						'.wpha_get_events_info($mypost->post_id,array('views','author','comment'),'','','li').'
					</ul>
				</div>
				<a class="theam_btn btn2 bg-color" href="'.esc_url($mypost->guid).'">'.esc_html__('Join Event','council').'</a>
			</div>
		</div>';
		
	}
	
	function wpha_get_events_style_medium_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_month_a = date('M',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));
		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_attr($mypost->get_location()->location_address);	
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_attr($start_time);						
			$end_time = esc_attr($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		return '
		<div class="city-event-item">
			<div class="city_event2_list2_row">
				<div class="city_event2_list2_fig">
					<figure class="box">
						<div class="box-layer layer-1"></div>
						<div class="box-layer layer-2"></div>
						<div class="box-layer layer-3"></div>
						'.get_the_post_thumbnail($mypost->post_id, $settings['thumbnail_size']).'
						<div class="event_categories_date">
							<h5>'.esc_html($event_day).'</h5>
							<p>'.esc_html($event_month_a).' '.esc_html($event_year).'</p>
						</div>
					</figure>
				</div>
				<div class="city_blog_text event2">
					'.wpha_get_events_info($mypost->post_id,array('category'),'','','span').'
					<h4><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>
					<ul class="city_meta_list">
						'.wpha_get_events_info($mypost->post_id,array('author','views','tags','comment'),'','','li').'
					</ul>
					<p>'.esc_html(substr($mypost->post_content,0,$settings['num_excerpt'])).'</p>
					<div class="city_blog_social">
						<a class="theam_btn border-color" href="'.esc_url($mypost->guid).'" tabindex="0">'.esc_html__('Join Event','council').'</a>
						<div class="city_blog_icon_list">
							<ul class="social_icon">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-google"></i></a></li>
							</ul>
							<a class="share_icon" href="#"><i class="fa icon-social"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}
	
	function wpha_get_events_style_grid_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));
		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_attr($mypost->get_location()->location_address);	
			// $location = esc_attr($mypost->get_location()->name);
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_attr($start_time);						
			$end_time = esc_attr($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		$ret = '
		<div class="event_grid_list margin-bottom">';
			if(!empty($image_src_full)){
				$ret .= '<div style="background-image:url('.esc_url($image_src_full[0]).');" class="event_categories_list overlay-event-detail">';
			}else{
				$ret .= '<div class="event_categories_list overlay-event-detail">';
			}
			$ret .= '
				<div class="event_categories_date">
					<h5>'.esc_html($event_day).'</h5>
					<p>'.esc_html($event_month).' '.esc_html($event_year).'</p>
				</div>
				<div class="event_categories_text">
					<h4><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>';
					if(!empty($location)){
						$ret .= '<a href="'.esc_url($mypost->guid).'"><i class="fa fa-map-marker"></i>'.esc_html($location).'</a>';
					}
					$ret .= '
				</div>
			</div>
		</div>';
		
		return $ret;
	}
	
	function wpha_get_events_style_full_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_month_a = date('M',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));

		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_attr($mypost->get_location()->location_address);	
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_attr($start_time);						
			$end_time = esc_attr($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		$ret = '
		<div class="city-event-item">';
			if(!empty($image_src_full)){
				$ret .= '<div style="background-image:url('.esc_url($image_src_full[0]).');" class="city_full_event_list overlay-event-detail">';
			}
			$ret .= '
				<div class="city_event2_calender">
					<ul>
						<li>
							<h4>'.esc_html($event_day).'</h4>
							<p>'.esc_html__('Date','council').'</p>
						</li>
						<li>
							<h4>'.esc_html($event_month).'</h4>
							<p>'.esc_html($event_month_a).'</p>
						</li>
						<li>
							<h4>'.esc_html($event_year).'</h4>
							<p>'.esc_html__('Year','council').'</p>
						</li>
					</ul>
				</div>
				<div class="city_event2_meeting">
					<h4><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>
					<ul class="city_meta_list">
						'.wpha_get_events_info($mypost->post_id,array('author','views','tags','category'),'','','li').'
					</ul>
					<p>'.esc_html(substr($mypost->post_content,0,$settings['num_excerpt'])).'</p>
				</div>
				<a class="theam_btn btn2" href="'.esc_url($mypost->guid).'">'.esc_html__('Join Event','council').'</a>
			</div>
		</div>';
		
		return $ret;
	}
	
	function wpha_get_events_style_news_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));
		$location = esc_attr($mypost->get_location()->name);
		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_attr($mypost->get_location()->location_address);	
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_attr($start_time);						
			$end_time = esc_attr($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		
		return '
		<div class="city-news-event-item">
			<div class="city_news2_detail">
				<ul class="city_meta_list">
					'.wpha_get_events_info($mypost->post_id,array('author','views','tags','category'),'','','li').'
				</ul>
				<h3><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h3>
				<p>'.esc_html(substr($mypost->post_content,0,$settings['num_excerpt'])).'</p>
				<a class="theam_btn bg-color color" href="'.esc_url($mypost->guid).'">'.esc_html__('Read More','council').'</a>
			</div>
		</div>';
	}
	
	
	function wpha_get_events_style_medium_modern_view( $settings ){
		$mypost = $settings['post'];
		$image_src_full = $settings['image_src_full'];
		$title_num_fetch = $settings['title_num_fetch'];
		$events_icons = $settings['events_icons'];
		$events_price = $settings['events_price'];
		
		$event_year = date('Y',$mypost->start);
		$event_month = date('m',$mypost->start);
		$event_day = date('d',$mypost->start);
		$event_start_time = date("G,i,s", strtotime($mypost->start_time));

		
		if(isset($mypost->get_location()->location_address)){
			$location = esc_attr($mypost->get_location()->location_address);	
		}else{
			$location = '';
		}
		$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
		$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
		if($mypost->event_all_day <> 1){ 
			$start_time = esc_attr($start_time);						
			$end_time = esc_attr($end_time); 
		}else{
			esc_html__('All Day','council'); 
			$start_time = '12:00 am'; 
			$end_time = '12:00 pm'; 
		}
		$event_start_time = date("G : i a", strtotime($start_time));	
		$event_end_time = date("G : i a", strtotime($end_time));
		
		
		
		return '
		<div class="city_event_fig">
			<figure class="box">
				<div class="box-layer layer-1"></div>
				<div class="box-layer layer-2"></div>
				<div class="box-layer layer-3"></div>
				'.get_the_post_thumbnail($mypost->post_id, $settings['thumbnail_size']).'
				<a class="paly_btn" data-rel="prettyPhoto" href="'.esc_url($image_src_full[0]).'" tabindex="-1"><i class="fa fa-plus"></i></a>
			</figure>
			<div class="city_event_text">
				<div class="city_event_history">
					<div class="event_date">
						<span>'.esc_html($event_day).'</span>
						<strong>'.esc_html($event_month).', '.esc_html($event_year).'</strong>
					</div>
					<div class="city_date_text">
						<h3 class="custom_size"><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h3>
						<a href="'.esc_url($mypost->guid).'"><i class="fa fa-clock-o"></i>'.esc_html($start_time).' - '.esc_html($end_time).' </a>
					</div>
				</div>
				<p>'.esc_html(substr($mypost->post_content,0,$settings['num_excerpt'])).'</p>
				'.wpha_get_events_info($mypost->post_id,array('author'),'','','strong').'				
			</div>
		</div>';
	}
	
	// Related Posts Function, matches posts by tags - call using joints_related_posts(); )
	function wpha_related_events_item($post_id) {
		global $post,$council_admin_option;				
		$tags = wp_get_post_terms($post_id, 'event-categories', array("fields" => "all"));
		$tag_arr = '';
		$ret = '';
		if($tags) {
			if(isset($tags)){
				foreach( $tags as $tag ) {
					$tag_arr .= $tag->slug . ',';
				}
				
				if( !empty($tag_arr)){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($tag_arr)){
						array_push($args['tax_query'], array('terms'=>explode(',', $tag_arr), 'taxonomy'=>'event-categories', 'field'=>'slug'));
					}				
				}
				
				$args['post_type'] = 'event';
				$args['numberposts'] = 2;
				$args['post__not_in'] = array($post_id);
			
				
				$related_posts = get_posts( $args );			
				if($related_posts) {
					echo '
					<div class="city_event_detail">
					<div class="event-listing-item">
					<div class="row">
					<div class="col-md-12"><h3 class="event_heading">'.esc_html__('Related Events','council').'</h3></div>';
						$title_num_fetch = 30;
						foreach ( $related_posts as $post ) : setup_postdata( $post );
							$mypost = em_get_event($post->ID);
							$event_year = date('Y',$mypost->start);
							$event_month = date('m',$mypost->start);
							$event_day = date('d',$mypost->start);
							$event_start_time = date("G,i,s", strtotime($mypost->start_time));
							
							if(isset($mypost->get_location()->location_address)){
								$location = esc_attr($mypost->get_location()->location_address);	
							}else{
								$location = '';
							}
							$start_time = date(get_option('time_format'),strtotime($mypost->start_time));
							$end_time = date(get_option('time_format'),strtotime($mypost->end_time));
							if($mypost->event_all_day <> 1){ 
								$start_time = esc_attr($start_time);						
								$end_time = esc_attr($end_time); 
							}else{
								esc_html__('All Day','council'); 
								$start_time = '12:00 am'; 
								$end_time = '12:00 pm'; 
							}
							$event_start_time = date("G : i a", strtotime($start_time));	
							$event_end_time = date("G : i a", strtotime($end_time));
							$image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
							echo '
							<div class="col-md-6">
							<div class="event_grid_list margin-bottom">';
								if(!empty($image_src)){
									echo '<div style="background-image:url('.esc_url($image_src[0]).');" class="event_categories_list overlay-event-detail">';
								}else{
									echo '<div class="event_categories_list overlay-event-detail">';
								}
								echo '
									<div class="event_categories_date">
										<h5>'.esc_html($event_day).'</h5>
										<p>'.esc_html($event_month).' '.esc_html($event_year).'</p>
									</div>
									<div class="event_categories_text">
										<h4><a href="'.esc_url($mypost->guid).'">'.esc_html(substr($mypost->post_title,0,$title_num_fetch)).'</a></h4>';
										if(!empty($location)){
											echo '<a href="'.esc_url($mypost->guid).'"><i class="fa fa-map-marker"></i>'.esc_html($location).'</a>';
										}
										echo '
									</div>
								</div>
							</div>
							</div>';
						endforeach;
						echo '</div></div></div>';
					
				} wp_reset_postdata();
			}
			// return $ret;
		}
	}

	//Get Popular posts
	function wpha_set_events_views($postID) {
		$count_key = 'event_views';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}




	function wpha_post_events_views ($post_id) {
		if ( !is_single() ) return;
		if ( empty ( $post_id) ) {
			global $post;
			$post_id = $post->ID;    
		}
		wpha_get_events_views($post_id);
	}

	add_action( 'wp_head', 'wpha_post_events_views');


	function wpha_get_events_views($postID){
		$count_key = 'event_views';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return esc_html__('0','council');
		}
		return $count;
	}
	
	
	function wpha_get_events_listing( $settings = array() ){
		
		$args = array('post_type' => 'event', 'suppress_filters' => false);
		
		$events = '';
		$settings['title_num_fetch'] = empty($settings['title-num-fetch'])? '300': $settings['title-num-fetch'];
		if(isset($settings['title_num_fetch']) && $settings['title_num_fetch'] == '-1'){
			$settings['title_num_fetch'] = 500;
		}
		$size = 3;		
		$settings['title_num_fetch'] = (empty($settings['title_num_fetch']))? '15': $settings['title_num_fetch'];
		$settings['event_post'] = (empty($settings['event_post']))? '': $settings['event_post'];
		$current_size = 0;
		
		$argu = array('pagination'=>1,'category'=>$settings['event_post'], 'group'=>'this','scope'=>'future', 'limit' => 1, 'order' => 'ASC');
		$argu['page'] = (!empty($_REQUEST['pno']) && is_numeric($_REQUEST['pno']) )? $_REQUEST['pno'] : 1;
		$query_events = EM_Events::get( $argu );
		$events_count = EM_Events:: count( $argu );	
		
		foreach ( $query_events as $event ) {
			global $post;
			$event_year = date('Y',$event->start);
			$event_month = date('m',$event->start);
			$event_day = date('d',$event->start);
			$event_start_time = date("G,i,s", strtotime($event->start_time));
			$location = '';
			
			if(isset($event->get_location()->location_address)){
				$location = esc_attr($event->get_location()->location_address);	
			}else{
				$location = '';
			}
			$start_time = date(get_option('time_format'),strtotime($event->start_time));
			$end_time = date(get_option('time_format'),strtotime($event->end_time));
			if($event->event_all_day <> 1){ 
				$start_time = esc_attr($start_time);						
				$end_time = esc_attr($end_time); 
			}else{
				esc_html__('All Day','biz-desk'); 
				$start_time = '12:00 am'; 
				$end_time = '12:00 pm'; 
			}
			$event_start_time = date("G : i a", strtotime($start_time));	
			$event_end_time = date("G : i a", strtotime($end_time));
			$ret = ''; $current_size = 0;				
			
			$ret = '
			<div class="event-content">
				<small>'.esc_html($settings['event_title_sub']).'</small>
				<h3>'.esc_html($settings['event_title']).'</h3>
				<p>'.esc_attr(substr($event->post_content,0,135)).'</p>
				<ul class="timmer" data-year="'.esc_attr($event_year).'" data-month="'.esc_attr($event_month).'" data-day="'.esc_attr($event_day).'" data-time="'.esc_attr($event_start_time).'">
					<li>
						<span>61</span>
						<small>days</small>
					</li>
					<li>
						<span>45</span>
						<small>hours</small>
					</li>
					<li>
						<span>25</span>
						<small>minutes</small>
					</li>
					<li>
						<span>55</span>
						<small>seconds</small>
					</li>
				</ul>
				<a href="'.esc_url($event->guid).'" class="btn-normal borderd white-b btn-e eft-clr-1"><span></span>'.esc_html__('See This Campaign','council').'</a>
			</div>';
		}
		
		return $ret;
	}