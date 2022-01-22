<?php

// Creating KodeForest Category in Elementor Builder
function kodeforest_add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'kodeforest',
		[
			'title' => __( 'KodeForest', 'plugin-name' ),
			'icon' => 'fa fa-plug',
		]
	);
	$elements_manager->add_category(
		'second-category',
		[
			'title' => __( 'Second Category', 'plugin-name' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'kodeforest_add_elementor_widget_categories' );


//Adding custom icon to icon control in Elementor
function custom_svg_icon_controls( $controls_registry ) {
	// Get existing icons
	$icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
	$data = array();
	for($i=1;$i<173;$i++){
		$ret = '<i class="wpicon wpicon_set_'.esc_attr($i).'" data-name="wpicon_set_'.esc_attr($i).'">
			<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span><span class="path31"></span><span class="path32"></span><span class="path33"></span><span class="path34"></span><span class="path35"></span><span class="path36"></span><span class="path37"></span><span class="path38"></span><span class="path39"></span><span class="path40"></span><span class="path41"></span><span class="path42"></span><span class="path43"></span><span class="path44"></span><span class="path45"></span><span class="path46"></span><span class="path47"></span><span class="path48"></span><span class="path49"></span><span class="path50"></span><span class="path51"></span><span class="path52"></span><span class="path53"></span><span class="path54"></span><span class="path55"></span><span class="path56"></span><span class="path57"></span><span class="path58"></span><span class="path59"></span><span class="path60"></span><span class="path61"></span><span class="path62"></span><span class="path63"></span><span class="path64"></span><span class="path65"></span><span class="path66"></span><span class="path67"></span><span class="path68"></span><span class="path69"></span><span class="path70"></span><span class="path71"></span><span class="path72"></span><span class="path73"></span><span class="path74"></span><span class="path75"></span><span class="path76"></span><span class="path77"></span><span class="path78"></span><span class="path79"></span><span class="path80"></span><span class="path81"></span><span class="path82"></span><span class="path83"></span><span class="path84"></span><span class="path85"></span><span class="path86"></span><span class="path87"></span><span class="path88"></span><span class="path89"></span><span class="path90"></span><span class="path91"></span><span class="path92"></span><span class="path93"></span><span class="path94"></span><span class="path95"></span><span class="path96"></span><span class="path97"></span><span class="path98"></span><span class="path99"></span><span class="path100"></span><span class="path101"></span><span class="path102"></span><span class="path103"></span><span class="path104"></span>
		</i> wpicon_set_'.esc_attr($i);
		
		$data['wpicon wpicon_set_'.esc_attr($i)] = $ret;
	}
	
	// Append new icons
	$new_icons = array_merge(
		$data,
		$icons
	);
	// Then we set a new list of icons as the options of the icon control
	$controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
}
add_action( 'elementor/controls/controls_registered', 'custom_svg_icon_controls', 10, 1 );

function kodeforest_add_icon_elementor_widget(){
	$ret = '';
	$data = array();
	for($i=1;$i<173;$i++){
		$ret = '<i class="wpicon wpicon_set_'.esc_attr($i).'" data-name="wpicon_set_'.esc_attr($i).'">
			<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span><span class="path18"></span><span class="path19"></span><span class="path20"></span><span class="path21"></span><span class="path22"></span><span class="path23"></span><span class="path24"></span><span class="path25"></span><span class="path26"></span><span class="path27"></span><span class="path28"></span><span class="path29"></span><span class="path30"></span><span class="path31"></span><span class="path32"></span><span class="path33"></span><span class="path34"></span><span class="path35"></span><span class="path36"></span><span class="path37"></span><span class="path38"></span><span class="path39"></span><span class="path40"></span><span class="path41"></span><span class="path42"></span><span class="path43"></span><span class="path44"></span><span class="path45"></span><span class="path46"></span><span class="path47"></span><span class="path48"></span><span class="path49"></span><span class="path50"></span><span class="path51"></span><span class="path52"></span><span class="path53"></span><span class="path54"></span><span class="path55"></span><span class="path56"></span><span class="path57"></span><span class="path58"></span><span class="path59"></span><span class="path60"></span><span class="path61"></span><span class="path62"></span><span class="path63"></span><span class="path64"></span><span class="path65"></span><span class="path66"></span><span class="path67"></span><span class="path68"></span><span class="path69"></span><span class="path70"></span><span class="path71"></span><span class="path72"></span><span class="path73"></span><span class="path74"></span><span class="path75"></span><span class="path76"></span><span class="path77"></span><span class="path78"></span><span class="path79"></span><span class="path80"></span><span class="path81"></span><span class="path82"></span><span class="path83"></span><span class="path84"></span><span class="path85"></span><span class="path86"></span><span class="path87"></span><span class="path88"></span><span class="path89"></span><span class="path90"></span><span class="path91"></span><span class="path92"></span><span class="path93"></span><span class="path94"></span><span class="path95"></span><span class="path96"></span><span class="path97"></span><span class="path98"></span><span class="path99"></span><span class="path100"></span><span class="path101"></span><span class="path102"></span><span class="path103"></span><span class="path104"></span>
		</i> wpicon_set_'.esc_attr($i);
		
		$data[$i] = $ret;
	}
	
	return $data;
}

// retrieve all posts as a list
function wpha_get_post_list_id( $post_type ){
	$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));

	$ret = array();
	if( !empty($post_list) ){
		foreach( $post_list as $post_id ){
			$ret[$post_id->ID] = $post_id->post_title;
		}
	}
		
	return $ret;
}	

// retrieve all posts as a list
function wpha_get_post_list_id_firstempty( $post_type ){
	$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));

	$ret = array('0'=>'');
	if( !empty($post_list) ){
		foreach( $post_list as $post_id ){
			$ret[$post_id->post_title] = $post_id->ID;
		}
	}
		
	return $ret;
}	


// retrieve all posts as a list
function wpha_get_post_list( $post_type ){
	$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));

	$ret = array();
	if( !empty($post_list) ){
		foreach( $post_list as $post ){
			$ret[$post->post_name] = $post->post_title;
		}
	}
		
	return $ret;
}	

// retrieve all categories from each post type
function wpha_get_term_list( $taxonomy, $parent='' ){
	
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );
	

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		foreach( $term_list as $term ){
			if(isset($term->slug)){
				$ret[$term->slug] = $term->name;
			}
		}
	}			
	return $ret;
}	


// retrieve all categories from each post type
function wpha_get_term_list_id( $taxonomy, $parent='' ){
	
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );
	

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		foreach( $term_list as $term ){
			if(isset($term->term_id)){
				$ret[$term->term_id] = $term->name;
			}
		}
	}
		
	return $ret;
}	

function wpha_get_term_list_detail( $taxonomy, $parent='',$hidempty='' ){
	
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>1, 'parent'=>$parent) );			

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		foreach( $term_list as $term ){
			if(isset($term->slug)){
				$ret[$term->slug] = $term->name;
			}
		}
	}
		
	return $ret;
}	

// retrieve all categories from each post type
function wpha_get_term_list_emptyfirst( $taxonomy, $parent='' ){
	
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		
		foreach( $term_list as $term ){
			if(isset($term->slug)){
				$ret[$term->name] = $term->slug;
			}
		}
	}			
	array_unshift($ret, esc_html__('No Value Selected' ,'hotel-management'));
		
	return $ret;
}	

function wpha_get_term_id( $taxonomy, $parent='' ){
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		foreach( $term_list as $term ){
			$ret[$term->id] = $term->term_id;
		}
	}
		
	return $ret;
}	

function wpha_get_sidebar_list(  ){
	$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

	$ret = array();
	if( !empty($term_list) && empty($term_list['errors']) ){
		foreach( $term_list as $term ){
			$ret[$term->slug] = $term->name;
		}
	}
		
	return $ret;
}	

// string to css class name
function wpha_string_to_class($string){
	$class = preg_replace('#[^\w\s]#','',strtolower(strip_tags($string)));
	$class = preg_replace('#\s+#', '-', trim($class));
	return 'kode-skin-' . $class;
}

// calculate the size as a number ex "1/2" = 0.5
function wpha_item_size_to_num( $size ){
	if( preg_match('/^(\d+)\/(\d+)$/', $size, $size_array) )
	return $size_array[1] / $size_array[2];
	return 1;
}	

// create pagination link
function wpha_get_pagination($max_num_page, $current_page, $format = 'paged'){
	if( $max_num_page <= 1 ) return '';

	$big = 999999999; // need an unlikely integer
	return 	'<div class="kode-pagination">' . paginate_links(array(
		'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format' => '?' . $format . '=%#%',
		'current' => max(1, $current_page),
		'total' => $max_num_page,
		'prev_text'=> '<i class="fa fa-long-arrow-left"></i>',
		'next_text'=> '<i class="fa fa-long-arrow-right"></i>'
	)) . '</div>';
}	

//Strip Down slashes
function wpha_stripslashes($data){
	$data = is_array($data) ? array_map('stripslashes_deep', $data) : stripslashes($data);
	return $data;
}

//Stop backslashes from Array
function wpha_stopbackslashes($data){
	$data = str_replace('\\\\\\\\\\\\\"', '|bb6|', $data);
	$data = str_replace('\\\\\\\\\\\"', '|bb5|', $data);
	$data = str_replace('\\\\\\\\\"', '|bb4|', $data);
	$data = str_replace('\\\\\\\"', '|bb3|', $data);
	$data = str_replace('\\\\\"', '|bb2|', $data);
	$data = str_replace('\\\"', '|bb"|', $data);
	$data = str_replace('\\\\\\t', '|p2k|', $data);
	$data = str_replace('\\\\t', '|p1k|', $data);			
	$data = str_replace('\\\\\\n', '|p2k|', $data);
	$data = str_replace('\\\\n', '|p1k|', $data);
	return $data;
}

//decode and Stop back slashes
function wpha_decode_stopbackslashes($data){
	$data = str_replace('|bb6|', '\\\\\\"', $data);
	$data = str_replace('|bb5|', '\\\\\"', $data);
	$data = str_replace('|bb4|', '\\\\"', $data);
	$data = str_replace('|bb3|', '\\\"', $data);
	$data = str_replace('|bb2|', '\\"', $data);
	$data = str_replace('|bb"|', '\"', $data);
	$data = str_replace('|p2k|', '\\\t', $data);
	$data = str_replace('|p1k|', '\t', $data);			
	$data = str_replace('|p2k|', '\\\n', $data);
	$data = str_replace('|p1k|', '\n', $data);
	return $data;
}

//Define Classes
function wpha_post_classes_plugin( $classes ) {
	
	$classes[] = strtolower(str_replace(' ','-',get_option('current_theme'))).'-prop-plugin';
	
	return $classes;
}


// Column Sizes Bootstrap 3+
function wpha_get_column_class_updated( $size ){
	switch( $size ){
		case '1/12': return 'col-md-1 columns'; break;
		case '1/6': return 'col-md-2 column'; break;
		case '1/4': return 'col-md-3 columns'; break;
		case '2/5': return 'col-md-5 columns'; break;
		case '1/3': return 'col-md-4 columns'; break;
		case '1/2': return 'col-md-6 columns'; break;
		case '3/5': return 'col-md-7 columns'; break;
		case '2/3': return 'col-md-8 columns'; break;
		case '3/4': return 'col-md-9 columns'; break;
		case '4/5': return 'col-md-10 columns'; break;
		case '1/1': return 'col-md-12 columns'; break;
		default : return 'col-md-12 columns'; break;
	}
}

//Sidebar Services
function wpha_get_sidebar_class_services( $sidebar = array() ){
	global $council_admin_option;
	$sidebar_size = council_get_option('sidebar-options','services-sidebar-size');
	$both_sidebar_size = council_get_option('sidebar-options','services-both-sidebar-size');
	if( $sidebar['type'] == 'no-sidebar' ){
		return array_merge($sidebar, array('right'=>'', 'outer'=>'col-md-12', 'left'=>'col-md-12', 'center'=>'col-md-12'));
	}else if( $sidebar['type'] == 'both-sidebar' ){
		if( $both_sidebar_size == 3 ){
			return array_merge($sidebar, array('right'=>'col-md-3', 'outer'=>'col-md-3', 'left'=>'col-md-3', 'center'=>'col-md-6'));
		}else if( $both_sidebar_size == 4 ){
			return array_merge($sidebar, array('right'=>'col-md-4', 'outer'=>'col-md-4', 'left'=>'col-md-4', 'center'=>'col-md-4'));
		}
	}else{ 
	
		// determine the left/right sidebar size
		$size = ''; $center = '';
		switch ($sidebar_size){
			case 1: $size = 'col-md-1'; $center = 'col-md-11'; break;
			case 2: $size = 'col-md-2'; $center = 'col-md-10'; break;
			case 3: $size = 'col-md-3'; $center = 'col-md-9'; break;
			case 4: $size = 'col-md-4'; $center = 'col-md-8'; break;
			case 5: $size = 'col-md-5'; $center = 'col-md-7'; break;
			case 6: $size = 'col-md-6'; $center = 'col-md-6'; break;
		}

		if( $sidebar['type'] == 'left-sidebar'){
			$sidebar['outer'] = $center;
			$sidebar['left'] = $size;
			$sidebar['center'] = $center;
			return $sidebar;
		}else if( $sidebar['type'] == 'right-sidebar'){
			$sidebar['outer'] = $center;
			$sidebar['right'] = $size;
			$sidebar['center'] = $center;
			return $sidebar;			
		}else{
			$sidebar['left'] = 'col-md-12';
			$sidebar['outer'] = 'col-md-12';
			$sidebar['center'] = 'col-md-12';
			return $sidebar;
		}
	}
}