<?php
	/*	
	*	Kodeforest Framework File
	*	---------------------------------------------------------------------
	*	This file contains utility function in the theme
	*	---------------------------------------------------------------------
	*/
	if( !function_exists('kode_get_country_array') ){
		function kode_get_country_array(){
			$country_val = array();
			$kode_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
			foreach($kode_countries as $keys=>$country){
				$country_val[$keys] = $country;
			}
			return $country_val;
		}
	}
	
		
	
	// page builder content/text filer to execute the shortcode	
	if( !function_exists('kode_content_filter') ){
		add_filter( 'kode_the_content', 'wptexturize'        ); add_filter( 'kode_the_content', 'convert_smilies'    );
		add_filter( 'kode_the_content', 'convert_chars'      ); add_filter( 'kode_the_content', 'wpautop'            );
		add_filter( 'kode_the_content', 'shortcode_unautop'  ); add_filter( 'kode_the_content', 'prepend_attachment' );	
		add_filter( 'kode_the_content', 'do_shortcode'       );
		function kode_content_filter( $content, $main_content = false ){
			if($main_content) return str_replace( ']]>', ']]&gt;', apply_filters('the_content', $content) );
			return apply_filters('kode_the_content', $content);
		}		
	}
	if( !function_exists('kode_text_filter') ){
		add_filter( 'kode_text_filter', 'do_shortcode' );
		function kode_text_filter( $text ){
			return apply_filters('kode_text_filter', $text);
		}
	}	
	
	// filter shortcode out if the plugin is not activated
	if( !function_exists('kode_enable_shortcode_filter') ){
		add_filter( 'widget_text', 'kode_enable_shortcode_filter' );
		add_filter( 'the_content', 'kode_enable_shortcode_filter' ); 
		add_filter( 'kode_text_filter', 'kode_enable_shortcode_filter' ); 	
		add_filter( 'kode_the_content', 'kode_enable_shortcode_filter' ); 	
		function kode_enable_shortcode_filter( $text ){
			if( !function_exists('kode_add_tinymce_button') ){
				$text = preg_replace('#\[kode_[^\]]+]#', '', $text);
				$text = preg_replace('#\[/kode_[^\]]+]#', '', $text);
			}
			return $text;
		}
	}	
			
	// use for generating the option from admin panel
	if( !function_exists('kode_check_option_data_type') ){
		function kode_check_option_data_type( $value, $data_type = 'color' ){
			if( $data_type == 'color' ){
				return (strpos($value, '#') === false)? '#' . $value: $value; 
			}else if( $data_type == 'text' ){
				return $value;
			}else if( $data_type == 'pixel' ){
				return (is_numeric($value))? $value . 'px': $value;
			}else if( $data_type == 'upload' ){
				if(is_numeric($value)){
					$image_src = wp_get_attachment_image_src($value, 'full');	
					return (!empty($image_src))? $image_src[0]: false;
				}else{
					return $value;
				}
			}else if( $data_type == 'font'){
				if( strpos($value, ',') === false ){
					return '"' . $value . '"';
				}
				return $value;
			}else if( $data_type == 'percent' ){
				return (is_numeric($value))? $value . '%': $value;
			}
		
		}
	}	
	
	// use for layouting the sidebar size
	if( !function_exists('kode_get_sidebar_class') ){
		function kode_get_sidebar_class( $sidebar = array() ){
			global $kode_theme_option;
			$kode_theme_option['both-sidebar-size'] = 3;
			$kode_theme_option['sidebar-size'] = 3;
			if( $sidebar['type'] == 'no-sidebar' ){
				return array_merge($sidebar, array('right'=>'', 'outer'=>'col-md-12', 'left'=>'col-md-12', 'center'=>'col-md-12'));
			}else if( $sidebar['type'] == 'both-sidebar' ){
				if( $kode_theme_option['both-sidebar-size'] == 3 ){
					return array_merge($sidebar, array('right'=>'col-md-3', 'outer'=>'col-md-6', 'left'=>'col-md-3', 'center'=>'col-md-6'));
				}else if( $kode_theme_option['both-sidebar-size'] == 4 ){
					return array_merge($sidebar, array('right'=>'col-md-4', 'outer'=>'col-md-4', 'left'=>'col-md-4', 'center'=>'col-md-4'));
				}
			}else{ 
			
				// determine the left/right sidebar size
				$size = ''; $center = '';
				switch ($kode_theme_option['sidebar-size']){
					case 1: $size = 'col-md-1'; $center = 'col-md-11'; break;
					case 2: $size = 'col-md-2'; $center = 'col-md-10'; break;
					case 3: $size = 'col-md-3'; $center = 'col-md-9'; break;
					case 4: $size = 'col-md-4'; $center = 'col-md-8'; break;
					case 5: $size = 'col-md-5'; $center = 'col-md-7'; break;
					case 6: $size = 'col-md-6'; $center = 'col-md-6'; break;
				}

				if( $sidebar['type'] == 'left-sidebar'){
					$sidebar['outer'] = 'col-md-9';
					$sidebar['left'] = $size;
					$sidebar['center'] = $center;
					return $sidebar;
				}else if( $sidebar['type'] == 'right-sidebar'){
					$sidebar['outer'] = $center;
					$sidebar['right'] = $size;
					$sidebar['center'] = 'col-md-9';
					return $sidebar;			
				}else{
					$sidebar['left'] = 'col-md-12';
					$sidebar['outer'] = 'col-md-12';
					$sidebar['center'] = 'col-md-12';
					return $sidebar;
				}
			}
		}
	}

	// retrieve all posts as a list
	if( !function_exists('kode_get_post_list') ){	
		function kode_get_post_list( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));

			$ret = array();
			if( !empty($post_list) ){
				foreach( $post_list as $post ){
					$ret[$post->post_name] = $post->post_title;
				}
			}
				
			return $ret;
		}	
	}	
	
		// retrieve all posts as a list VC
	if( !function_exists('kode_get_post_list_id_vc') ){
		function kode_get_post_list_id_vc( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));
			$ret = array();
			if( !empty($post_list) ){
				foreach( $post_list as $post_id ){
					$ret[$post_id->post_title] = $post_id->ID;
				}
			}
			
			array_unshift($ret, esc_html__('No Value Selected' ,'kickoff'));
			
			return $ret;
		}	
	}
	
	// retrieve all categories from each post type
	if( !function_exists('kode_get_term_list') ){	
		add_action('init','kode_get_term_list');
		function kode_get_term_list( $taxonomy, $parent='' ){
			
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
	}
	
	// retrieve all categories from each post type
	if( !function_exists('kode_get_term_list_emptyfirst') ){	
		add_action('init','kode_get_term_list_emptyfirst');
		function kode_get_term_list_emptyfirst( $taxonomy, $parent='' ){
			
			$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

			$ret = array();
			if( !empty($term_list) && empty($term_list['errors']) ){
				
				foreach( $term_list as $term ){
					if(isset($term->slug)){
						$ret[$term->name] = $term->slug;
					}
				}
			}			
			array_unshift($ret, '-- No Value Selected--');
				
			return $ret;
		}	
	}
	
	if( !function_exists('kode_get_term_id') ){	
		function kode_get_term_id( $taxonomy, $parent='' ){
			$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

			$ret = array();
			if( !empty($term_list) && empty($term_list['errors']) ){
				foreach( $term_list as $term ){
					$ret[$term->id] = $term->term_id;
				}
			}
				
			return $ret;
		}	
	}
	
	//print_r(kode_get_term_list('team_category'));
	
	
	
	if( !function_exists('kode_get_sidebar_list') ){	
		function kode_get_sidebar_list(  ){
			$term_list = get_categories( array('taxonomy'=>$taxonomy, 'hide_empty'=>0, 'parent'=>$parent) );

			$ret = array();
			if( !empty($term_list) && empty($term_list['errors']) ){
				foreach( $term_list as $term ){
					$ret[$term->slug] = $term->name;
				}
			}
				
			return $ret;
		}	
	}
	
	// string to css class name
	if( !function_exists('kode_string_to_class') ){	
		function kode_string_to_class($string){
			$class = preg_replace('#[^\w\s]#','',strtolower(strip_tags($string)));
			$class = preg_replace('#\s+#', '-', trim($class));
			return 'kode-skin-' . $class;
		}
	}
	
	// calculate the size as a number ex "1/2" = 0.5
	if( !function_exists('kode_item_size_to_num') ){	
		function kode_item_size_to_num( $size ){
			if( preg_match('/^(\d+)\/(\d+)$/', $size, $size_array) )
			return $size_array[1] / $size_array[2];
			return 1;
		}	
	}		

	// create pagination link
	if( !function_exists('kode_get_pagination') ){	
		function kode_get_pagination($max_num_page, $current_page, $format = 'paged'){
			if( $max_num_page <= 1 ) return '';
		
			$big = 999999999; // need an unlikely integer
			return 	'<div class="kode-pagination">' . paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?' . $format . '=%#%',
				'current' => max(1, $current_page),
				'total' => $max_num_page,
				'prev_text'=> esc_html__('&lsaquo; Previous', 'kickoff'),
				'next_text'=> esc_html__('Next &rsaquo;', 'kickoff')
			)) . '</div>';
		}	
	}		
	
	if( !function_exists('kode_get_breadcumbs') ){	
		function kode_get_breadcumbs () {
			 
			// Settings
			$separator  = '&gt;';
			$id         = 'breadcrumbs';
			$class      = 'kode-breadcrumb';
			$home_title = esc_html__('Homepage','kickoff');
			 $parents = '';
			// Get the query & post information
			global $post,$wp_query;
			$category = get_the_category();
			//echo '<div class="kode-breadcrumb">';
            //echo '<span><i class="fa fa-home"></i> '.esc_html__('You are here:','kickoff').'</span>';
               
			// Build the breadcrums
			echo '<ul id="' . esc_attr($id) . '" class="' . esc_attr($class) . '">';
			 
			// Do not display on the homepage
			if ( !is_front_page() ) {
				 
				// Home page
				echo '<li class="item-home"><a class="bread-link bread-home" href="' . esc_url(get_home_url()) . '" title="' . esc_attr($home_title) . '">' . esc_attr($home_title) . '</a></li>';
				//echo '<li class="separator separator-home"> ' . $separator . ' </li>';
				 
				if ( is_single() ) {
					 $post_type = get_post_type_object(get_post_type());
					$cat = array();
					//print_r($post_type->name);
					if($post_type->name == 'post'){
						// Single post (Only display the first category)
						echo '<li class="item-cat item-cat-' . esc_attr($category[0]->term_id) . ' item-cat-' . esc_attr($category[0]->category_nicename) . '"><a class="bread-cat bread-cat-' . esc_attr($category[0]->term_id) . ' bread-cat-' . esc_attr($category[0]->category_nicename) . '" href="' . esc_url(get_category_link($category[0]->term_id )) . '" title="' . esc_attr($category[0]->cat_name) . '">' . esc_attr($category[0]->cat_name) . '</a></li>';
						//echo '<li class="separator separator-' . $category[0]->term_id . '"> ' . $separator . ' </li>';
						echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . esc_attr(get_the_title()) . '</strong></li>';
						 
					}else{
						$post_type = get_post_type_object(get_post_type());
						$slug = $post_type->rewrite;
						
						echo '<li><a href="'.esc_url(get_permalink()).'">'.esc_attr(substr(get_the_title(),0,15)).'</a></li>';
					}
					
				} else if ( is_category() ) {
					 
					// Category page
					echo '<li class="item-current item-cat-' . esc_attr($category[0]->term_id) . ' item-cat-' . esc_attr($category[0]->category_nicename) . '"><strong class="bread-current bread-cat-' . esc_attr($category[0]->term_id) . ' bread-cat-' . esc_attr($category[0]->category_nicename) . '">' . esc_attr($category[0]->cat_name) . '</strong></li>';
					 
				} else if ( is_page() ) {
					 
					// Standard page
					if( $post->post_parent ){
						 
						// If child page, get parents 
						$anc = get_post_ancestors( $post->ID );
						 
						// Get parents in the right order
						$anc = array_reverse($anc);
						 
						// Parent page loop
						foreach ( $anc as $ancestor ) {
							$parents .= '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . esc_url(get_permalink($ancestor)) . '" title="' . esc_attr(get_the_title($ancestor)) . '">' . esc_attr(get_the_title($ancestor)) . '</a></li>';
							//$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
						}
						 
						// Display parent pages
						echo ($parents);
						 
						// Current page
						echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong title="' . esc_attr(get_the_title()) . '"> ' . esc_attr(get_the_title()) . '</strong></li>';
						 
					} else {
						 
						// Just display current page if not parents
						echo '<li class="item-current item-' . esc_attr($post->ID) . '"><strong class="bread-current bread-' . esc_attr($post->ID) . '"> ' . esc_attr(get_the_title()) . '</strong></li>';
						 
					}
					 
				} else if ( is_tag() ) {
					 
					// Tag page
					 
					// Get tag information
					$term_id = get_query_var('tag_id');
					$taxonomy = 'post_tag';
					$args ='include=' . $term_id;
					$terms = get_terms( $taxonomy, $args );
					 
					// Display the tag name
					echo '<li class="item-current item-tag-' . esc_attr($terms[0]->term_id) . ' item-tag-' . esc_attr($terms[0]->slug) . '"><strong class="bread-current bread-tag-' . esc_attr($terms[0]->term_id) . ' bread-tag-' . esc_attr($terms[0]->slug) . '">' . esc_attr($terms[0]->name) . '</strong></li>';
				 
				} elseif ( is_day() ) {
					 
					// Day archive
					 
					// Year link
					echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_attr(get_year_link( get_the_time('Y') )) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_attr(get_the_time('Y')) . ' Archives</a></li>';
					//echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
					 
					// Month link
					echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><a class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" href="' . esc_url(get_month_link( get_the_time('Y'), get_the_time('m') )) . '" title="' . esc_attr(get_the_time('M')) . '">' . esc_attr(get_the_time('M')) . ' Archives</a></li>';
					//echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
					 
					// Day display
					echo '<li class="item-current item-' . esc_attr(get_the_time('j')) . '"><strong class="bread-current bread-' . esc_attr(get_the_time('j')) . '"> ' . esc_attr(get_the_time('jS')) . ' ' . esc_attr(get_the_time('M')) . ' Archives</strong></li>';
					 
				} else if ( is_month() ) {
					 
					// Month Archive
					 
					// Year link
					echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url(get_year_link( get_the_time('Y') )) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_attr(get_the_time('Y')) . ' Archives</a></li>';
					//echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
					 
					// Month display
					echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><strong class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" title="' . esc_attr(get_the_time('M')) . '">' . esc_attr(get_the_time('M')) . ' Archives</strong></li>';
					 
				} else if ( is_year() ) {
					 
					// Display year archive
					echo '<li class="item-current item-current-' . esc_attr(get_the_time('Y')) . '"><strong class="bread-current bread-current-' . esc_attr(get_the_time('Y')) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_attr(get_the_time('Y')) . ' Archives</strong></li>';
					 
				} else if ( is_author() ) {
					 
					// Auhor archive
					 
					// Get the author information
					global $author;
					$userdata = get_userdata( $author );
					 
					// Display author name
					echo '<li class="item-current item-current-' . esc_attr($userdata->user_nicename) . '"><strong class="bread-current bread-current-' . esc_attr($userdata->user_nicename) . '" title="' . esc_attr($userdata->display_name) . '">' . 'Author: ' . esc_attr($userdata->display_name) . '</strong></li>';
				 
				} else if ( get_query_var('paged') ) {
					 
					// Paginated archives
					echo '<li class="item-current item-current-' . esc_attr(get_query_var('paged')) . '"><strong class="bread-current bread-current-' . esc_attr(get_query_var('paged')) . '" title="Page ' . esc_attr(get_query_var('paged')) . '">'.esc_html__('Page','kickoff') . ' ' . esc_attr(get_query_var('paged')) . '</strong></li>';
					 
				} else if ( is_search() ) {
				 
					// Search results page
					echo '<li class="item-current item-current-' . esc_attr(get_search_query()) . '"><strong class="bread-current bread-current-' . esc_attr(get_search_query()) . '" title="Search results for: ' . esc_attr(get_search_query()) . '">'.esc_html__('Search results for:','kickoff') . ' ' . esc_attr(get_search_query()) . '</strong></li>';
				 
				} elseif ( is_404() ) {
					 
					// 404 page
					echo '<li>' . 'Error 404' . '</li>';
				}
				 
			}
			 
			echo '</ul>';
			 
		}
	}
	
	
	
	
	
	
	//Event Booking Button
	if( !function_exists('kode_event_booking') ){	
		function kode_event_booking($event){
			$notice_full = get_option('dbem_booking_button_msg_full');
			$button_text = get_option('dbem_booking_button_msg_book');
			$button_already_booked = get_option('dbem_booking_button_msg_already_booked');
			$button_booking = get_option('dbem_booking_button_msg_booking');
			$button_success = get_option('dbem_booking_button_msg_booked');
			$button_fail = get_option('dbem_booking_button_msg_error');
			$button_cancel = get_option('dbem_booking_button_msg_cancel');
			$button_canceling = get_option('dbem_booking_button_msg_canceling');
			$button_cancel_success = get_option('dbem_booking_button_msg_cancelled');
			$button_cancel_fail = get_option('dbem_booking_button_msg_cancel_error');

			if( is_user_logged_in() ){ //only show this to logged in users
				ob_start();
				$EM_Booking = $event->get_bookings()->has_booking();
				if( is_object($EM_Booking) && $EM_Booking->booking_status != 3 && get_option('dbem_bookings_user_cancellation') ){
					?><a id="em-cancel-button_<?php echo esc_attr($EM_Booking->booking_id); ?>_<?php echo wp_create_nonce('booking_cancel'); ?>" class="button em-cancel-button" href="#"><?php echo esc_attr($button_cancel); ?></a><?php
				}elseif( $event->get_bookings()->is_open() ){
					if( !is_object($EM_Booking) ){
						?><a id="em-booking-button_<?php echo esc_attr($event->event_id); ?>_<?php echo wp_create_nonce('booking_add_one'); ?>" class="button em-booking-button" href="#"><?php echo esc_attr($button_text); ?></a><?php 
					}else{
						?><span class="em-booked-button"><?php echo esc_attr($button_already_booked) ?></span><?php
					}
				}elseif( $event->get_bookings()->get_available_spaces() <= 0 ){
					?><span class="em-full-button"><?php echo esc_attr($notice_full) ?></span><?php
				}
				return apply_filters( 'em_booking_button', ob_get_clean(), $event );
			}else{
			return "<span class='em-full-button'>".esc_html__("Please Sign in","kickoff")."</span>";
			} 
		}	
	}
	
	
	
	
	//Strip Down slashes
	if( !function_exists('kode_stripslashes') ){
		function kode_stripslashes($data){
			$data = is_array($data) ? array_map('stripslashes_deep', $data) : stripslashes($data);
			return $data;
		}
	}
	//Stop backslashes from Array
	if( !function_exists('kode_stopbackslashes') ){
		function kode_stopbackslashes($data){
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
	}
	//decode and Stop back slashes
	if( !function_exists('kode_decode_stopbackslashes') ){
		function kode_decode_stopbackslashes($data){
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
	}	
	
	// retrieve all posts as a list
	if( !function_exists('kode_get_post_list_id') ){	
		function kode_get_post_list_id( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));

			$ret = array();
			if( !empty($post_list) ){
				foreach( $post_list as $post_id ){
					$ret[$post_id->ID] = $post_id->post_title;
				}
			}
			return $ret;
		}	
	}
	
	// retrieve all posts as a list VC
	if( !function_exists('kode_get_post_list_id_emptyfirst') ){
		function kode_get_post_list_id_emptyfirst( $post_type ){
			$post_list = get_posts(array('post_type' => $post_type, 'numberposts'=>1000));
			$ret = array();
			array_push($ret,esc_html__('--' ,'kickoff'));
			if( !empty($post_list) ){
				foreach( $post_list as $post_id ){
					$ret[$post_id->ID] = $post_id->post_title;
				}
			}
			
			return $ret;
		}	
	}
	
	
	//Get Popular posts
	if( !function_exists('kode_set_post_views') ){	
		function kode_set_post_views($postID) {
			$count_key = 'post_views';
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
	}
	
	
	if( !function_exists('kode_post_post_views') ){	
		function kode_post_post_views ($post_id) {
			if ( !is_single() ) return;
			if ( empty ( $post_id) ) {
				global $post;
				$post_id = $post->ID;    
			}
			kode_set_post_views($post_id);
		}
	}
	add_action( 'wp_head', 'kode_post_post_views');

	if( !function_exists('kode_get_post_views') ){	
		function kode_get_post_views($postID){
			$count_key = 'post_views';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
				return "esc_html__('0 View','kickoff')";
			}
			return $count.' Views';
		}
	}
	
	
	
	add_action( 'registered_post_type', 'event_label_rename', 10, 2 );
	if( !function_exists('event_label_rename') ){
		function event_label_rename( $post_type, $args ) {
			global $kode_theme_option;
			if(isset($kode_theme_option['select_club'])){ 
				if($kode_theme_option['select_club'] == 'cricket' || $kode_theme_option['select_club'] == 'soccer'){
					if ( 'event' === $post_type ) {
						global $wp_post_types;
						$args->labels->menu_name = esc_html__( 'Matches', 'kickoff' );			
						$wp_post_types[ $post_type ] = $args;
					}
				}else{
					if ( 'event' === $post_type ) {
						global $wp_post_types;
						$args->labels->menu_name = esc_html__( 'Fights', 'kickoff' );			
						$wp_post_types[ $post_type ] = $args;
					}
				}
			}
		} 
	} 
	
	
	function kode_ajax_login(){

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-login-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_login'] = $_POST['username'];
		$info['user_password'] = $_POST['password'];
		$info['remember'] = true;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			echo json_encode(array('loggedin'=>false, 'message'=>esc_attr__('Wrong username or password.','kickoff')));
		} else {
			echo json_encode(array('loggedin'=>true, 'message'=>esc_attr__('Login successful, Now Redirecting...','kickoff')));
		}

		die();
	}	
	
	function kode_ajax_login_init(){

		wp_register_script('ajax-login-script', KODE_PATH.'/js/ajax-login-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-login-script');

		wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'redirecturl' => home_url(),
			'loadingmessage' => __('Sending user info, please wait...','kickoff')
		));

		// Enable the user with no privileges to run ajax_login() in AJAX
		add_action( 'wp_ajax_nopriv_ajaxlogin', 'kode_ajax_login' );
	}	
	
	// Execute the action only if the user isn't logged in
	if (!is_user_logged_in()) {
		add_action('init', 'kode_ajax_login_init');		
	}
	
	function kode_signin_form(){ ?>
		
		<a data-target="#myModal" data-toggle="modal" href="#"><?php esc_attr_e('Login','kickoff');?></a>
		
		<div aria-hidden="true" role="dialog" tabindex="-1" id="myModal" class="modal fade kd-loginbox">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<a aria-label="Close" data-dismiss="modal" class="close" href="#"><span aria-hidden="true">×</span></a>
						<?php if (is_user_logged_in()) {
							global $current_user;?>
							<div class="kd-login-title">
								<h3><?php esc_attr_e('You Are Already Signed In','kickoff');?></h3>
								<span><?php esc_attr_e('Welcome ','kickoff');?><?php echo esc_attr($current_user->display_name);?></span>
								<div class="kd-login-network logout-btn">
									<ul>
										<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
									</ul>
								</div>
							</div>
						<?php }else{ ?>
							<div class="kd-login-title">
								<h2><?php esc_attr_e('LOGIN TO','kickoff');?></h2>
								<span><?php esc_attr_e('Your Account','kickoff');?></span>
							</div>
							
							<form id="login" action="login" method="post">
								<?php echo do_action( 'wordpress_social_login' );  ?>
								<div class="kd-login-sepratore"><span>OR</span></div>
								<p><i class="fa fa-envelope-o"></i> <input id="username" name="username" type="text" placeholder="Username"></p>
								<p><i class="fa fa-lock"></i> <input id="password" name="password" type="password" placeholder="Your Password"></p>
								<p><input type="submit" class="thbg-color" value="Login now"> <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_attr_e('Forget Password?','kickoff');?></a></p>
								<p class="status"></p>
								<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
								
							</form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	
	
	function kode_ajax_signup(){
		
		// First check the nonce, if it fails the function will break
		//check_ajax_referer( 'ajax-signup-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$default_role = get_option('default_role');

		$nickname = $_POST['nickname'];
		$user_email = $_POST['user_email'];
		$user_pass = $_POST['user_pass'];		

		$userdata = array(
			'user_login'    => $nickname,			
			'user_email'  => $user_email,
			'user_pass'  => $user_pass,
			'role' => $default_role
		);
		$exists = email_exists($user_email);
		$user_signup = wp_insert_user( $userdata );
		if ( !$exists ){
			if ( is_wp_error($user_signup) ){
				echo json_encode(array('signup'=>false, 'message'=>esc_attr__('Please verify the details you are providing.','kickoff')));
			} else {
				echo json_encode(array('signup'=>true, 'message'=>esc_attr__('Your request submitted successfully, Redirecting you to login page!','kickoff')));
			}
		}else{
			echo json_encode(array('signup'=>false, 'message'=>'Notice: Email already exists!'.$exists.''));			
		}

		die();
	}	
	
	function kode_ajax_signup_init(){

		wp_register_script('ajax-signup-script', KODE_PATH.'/js/ajax-signup-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-signup-script');

		wp_localize_script( 'ajax-signup-script', 'ajax_signup_object', array( 
			'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
			'redirecturl' => esc_url(home_url()),
			'loadingmessage' => esc_attr__('Sending user info, please wait...','kickoff')
		));
		
		// Enable the user with no privileges to run ajax_login() in AJAX
		add_action('wp_ajax_ajaxsignup', 'kode_ajax_signup');
		add_action('wp_ajax_nopriv_ajaxsignup', 'kode_ajax_signup' );
	}
	
	add_action('init', 'kode_ajax_signup_init');	
	
	
	function kode_signup_form(){ ?>
		<a data-target="#myModalTwo" data-toggle="modal" href="#"><?php esc_html_e('Register','kickoff');?></a>
		<?php
		$users_can_register = get_option('users_can_register');
		if($users_can_register <> 1){ ?>
			<!-- Modal -->
			<div aria-hidden="true" role="dialog" tabindex="-1" id="myModalTwo" class="modal fade kd-loginbox">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<a aria-label="Close" data-dismiss="modal" class="close" href="#"><span aria-hidden="true">×</span></a>
							<div class="kd-login-title">
								<p class="kode-allowed"><?php esc_attr_e('Sign up not allowed by admin.','kickoff');?></p>
								<p class="kode-allowed"><?php esc_attr_e('Please contact admin for the registration.','kickoff');?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<div class="modal fade kd-loginbox" id="myModalTwo" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<a href="#" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
							
							<div class="kd-login-title">
								<h2><?php _e('Register TO','kickoff');?></h2>
								<span><?php _e('Your Account','kickoff');?></span>
							</div>
							<?php echo do_action( 'wordpress_social_login' );  ?>
							<div class="kd-login-sepratore"><span>OR</span></div>
							<form id="sing-up" action="signup" method="post">		
								<p><i class="fa fa-user"></i> <input type="text" id="user_nickname" name="user_nickname" placeholder="Enter user name" /></p>
								<p><i class="fa fa-envelope-o"></i><input type="text" id="user_email" name="user_email" placeholder="Enter your email" /></p>
								<p><i class="fa fa-lock"></i> <input id="user_pass" name="user_pass" type="password" placeholder="Enter your password"></p>
								<?php wp_nonce_field( 'ajax-signup-nonce', 'security' ); ?>
								<p><input type="submit" value="Register now" class="thbg-color" /> </p>								
								<p class="status"></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php }
	}
	
	
	
	
	//Get Popular posts
	if( !function_exists('kode_set_post_views') ){	
		function kode_set_post_views($postID) {
			$count_key = 'post_views';
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
	}
	
	
	if( !function_exists('kode_post_post_views') ){	
		function kode_post_post_views ($post_id) {
			if ( !is_single() ) return;
			if ( empty ( $post_id) ) {
				global $post;
				$post_id = $post->ID;    
			}
			kode_set_post_views($post_id);
		}
	}
	add_action( 'wp_head', 'kode_post_post_views');

	if( !function_exists('kode_get_post_views') ){	
		function kode_get_post_views($postID){
			$count_key = 'post_views';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
				return "esc_html__('0 View','kickoff')";
			}
			return $count.' Views';
		}
	}
	
	//Event Booking Button
	if( !function_exists('kode_event_booking_btn') ){	
		function kode_event_booking_btn($event){
			$notice_full = get_option('dbem_booking_button_msg_full');
			$button_text = get_option('dbem_booking_button_msg_book');
			$button_already_booked = get_option('dbem_booking_button_msg_already_booked');
			$button_booking = get_option('dbem_booking_button_msg_booking');
			$button_success = get_option('dbem_booking_button_msg_booked');
			$button_fail = get_option('dbem_booking_button_msg_error');
			$button_cancel = get_option('dbem_booking_button_msg_cancel');
			$button_canceling = get_option('dbem_booking_button_msg_canceling');
			$button_cancel_success = get_option('dbem_booking_button_msg_cancelled');
			$button_cancel_fail = get_option('dbem_booking_button_msg_cancel_error');

			if( is_user_logged_in() ){ //only show this to logged in users
				ob_start();
				$EM_Booking = $event->get_bookings()->has_booking();
				if( is_object($EM_Booking) && $EM_Booking->booking_status != 3 && get_option('dbem_bookings_user_cancellation') ){
					?><a id="em-cancel-button_<?php echo $EM_Booking->booking_id; ?>_<?php echo wp_create_nonce('booking_cancel'); ?>" class="thbg-colorhover button em-cancel-button" href="#"><?php echo __('Not Attending','kickoff')?></a><?php
				}elseif( $event->get_bookings()->is_open() ){
					if( !is_object($EM_Booking) ){
						?><a id="em-booking-button_<?php echo $event->event_id; ?>_<?php echo wp_create_nonce('booking_add_one'); ?>" class="thbg-colorhover button em-booking-button" href="#"><?php echo __('Attend This Event','kickoff');?></a><?php 
					}else{
						?><span class="em-booked-button"><?php echo $button_already_booked ?></span><?php
					}
				}elseif( $event->get_bookings()->get_available_spaces() <= 0 ){
					?><span class="em-full-button"><?php echo $notice_full ?></span><?php
				}
				return apply_filters( 'em_booking_button', ob_get_clean(), $event );
			}else{
			return "<span class='em-full-button'>".__("Please Sign in","kickoff")."</span>";
			} 
		}	
	}
	
	if( !function_exists('kode_booking_form_event_manager') ){	
	function kode_booking_form_event_manager() {

		global $EM_Notices,$EM_Event;
		//count tickets and available tickets
		$tickets_count = count($EM_Event->get_bookings()->get_tickets()->tickets);
		$available_tickets_count = count($EM_Event->get_bookings()->get_available_tickets());
		//decide whether user can book, event is open for bookings etc.
		$can_book = is_user_logged_in() || (get_option('dbem_bookings_anonymous') && !is_user_logged_in());
		$is_open = $EM_Event->get_bookings()->is_open(); //whether there are any available tickets right now
		$show_tickets = true;
		//if user is logged out, check for member tickets that might be available, since we should ask them to log in instead of saying 'bookings closed'
		if( !$is_open && !is_user_logged_in() && $EM_Event->get_bookings()->is_open(true) ){
			$is_open = true;
			$can_book = false;
			$show_tickets = false;
		}
		?>
		<div id="em-booking" class="em-booking <?php if( get_option('dbem_css_rsvp') ) echo 'css-booking'; ?>">
			<?php 
				// We are firstly checking if the user has already booked a ticket at this event, if so offer a link to view their bookings.
				$EM_Booking = $EM_Event->get_bookings()->has_booking();
			?>
			<?php 
			if(!empty($EM_Event->bookings)){
				if( is_object($EM_Booking) && !get_option('dbem_bookings_double') ): //Double bookings not allowed ?>
					<p>
						<?php echo get_option('dbem_bookings_form_msg_attending'); ?>
						<a href="<?php echo em_get_my_bookings_url(); ?>"><?php echo get_option('dbem_bookings_form_msg_bookings_link'); ?></a>
					</p>
				<?php elseif( !$EM_Event->event_rsvp ): //bookings not enabled ?>
					<p><?php echo get_option('dbem_bookings_form_msg_disabled'); ?></p>
				<?php elseif( $EM_Event->get_bookings()->get_available_spaces() <= 0 ): ?>
					<p><?php echo get_option('dbem_bookings_form_msg_full'); ?></p>
				<?php elseif( !$is_open ): //event has started ?>
					<p><?php echo get_option('dbem_bookings_form_msg_closed');  ?></p>
				<?php else: ?>
					<?php echo $EM_Notices; ?>
					<?php if( $tickets_count > 0) : ?>
						<?php //Tickets exist, so we show a booking form. ?>
						<form class="em-booking-form" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url',''); ?>#em-booking'>
							<input type='hidden' name='action' value='booking_add'/>
							<input type='hidden' name='event_id' value='<?php echo $EM_Event->event_id; ?>'/>
							<input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('booking_add'); ?>'/>
							<?php 
								// Tickets Form
								if( $show_tickets && ($can_book || get_option('dbem_bookings_tickets_show_loggedout')) && ($tickets_count > 1 || get_option('dbem_bookings_tickets_single_form')) ){ //show if more than 1 ticket, or if in forced ticket list view mode
									do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
									//Show multiple tickets form to user, or single ticket list if settings enable this
									//If logged out, can be allowed to see this in settings witout the register form 
									em_locate_template('forms/bookingform/tickets-list.php',true, array('EM_Event'=>$EM_Event));
									do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
									$show_tickets = false;
								}
							?>
							<?php if( $can_book ): ?>
								<div class='em-booking-form-details'>
									<?php 
										if( $show_tickets && $available_tickets_count == 1 && !get_option('dbem_bookings_tickets_single_form') ){
											do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
											//show single ticket form, only necessary to show to users able to book (or guests if enabled)
											$EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
											em_locate_template('forms/bookingform/ticket-single.php',true, array('EM_Event'=>$EM_Event, 'EM_Ticket'=>$EM_Ticket));
											do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
										} 
									?>
									<?php
										do_action('em_booking_form_before_user_details', $EM_Event);
										if( has_action('em_booking_form_custom') ){ 
											//Pro Custom Booking Form. You can create your own custom form by hooking into this action and setting the option above to true
											do_action('em_booking_form_custom', $EM_Event); //do not delete
										}else{
											//If you just want to modify booking form fields, you could do so here
											em_locate_template('forms/bookingform/booking-fields.php',true, array('EM_Event'=>$EM_Event));
										}
										do_action('em_booking_form_after_user_details', $EM_Event);
									?>
									<?php do_action('em_booking_form_footer', $EM_Event); //do not delete ?>
									<div class="em-booking-buttons">
										<?php if( preg_match('/https?:\/\//',get_option('dbem_bookings_submit_button')) ): //Settings have an image url (we assume). Use it here as the button.?>
										<input type="image" src="<?php echo get_option('dbem_bookings_submit_button'); ?>" class="em-booking-submit" id="em-booking-submit" />
										<?php else: //Display normal submit button ?>
										<input type="submit" class="em-booking-submit" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />
										<?php endif; ?>
									</div>
									<?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete ?>
								</div>
							<?php else: ?>
								<p class="em-booking-form-details"><?php echo get_option('dbem_booking_feedback_log_in'); ?></p>
							<?php endif; ?>
						</form>	
						<?php 
						if( !is_user_logged_in() && get_option('dbem_bookings_login_form') ){
							//User is not logged in, show login form (enabled on settings page)
							em_locate_template('forms/bookingform/login.php',true, array('EM_Event'=>$EM_Event));
						}
						?>
						<br class="clear" style="clear:left;" />  
					<?php endif; ?>
				<?php endif;
			}
			?>
		</div>
	<?php }
	}

?>
