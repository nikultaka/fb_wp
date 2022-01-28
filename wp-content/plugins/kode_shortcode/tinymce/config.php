<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function kodeforest_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if($all) {
		$number_of_posts['-1'] = 'All';
	}

	if($default) {
		$number_of_posts[''] = 'Default';
	}

	foreach(range($range_start, $range) as $number) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function kodeforest_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if($empty_choice == true) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			$post_categories['All'] = 'All';
			foreach ( $get_categories as $cat ) {
				if(isset($cat->slug)){
					$post_categories[$cat->slug] = $cat->name;
				}	
			}
		}

		if(isset($post_categories)) {
			return $post_categories;
		}
	}
}
// return the slug list of each post
function get_post_list_sc( $post_type ){
	
	$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
	
	if( ! array_key_exists('errors', $posts) ) {
		if( $posts && is_array($posts) ) {
			$posts_title = array();
			foreach ($posts as $post) {
				$posts_title[$post->ID] = $post->post_title;
			}
		}	
	}
	
	if(isset($posts_title)) {
		return $posts_title;
	}
	

}


$album_category = kodeforest_shortcodes_categories('album-categories');
$post_category = kodeforest_shortcodes_categories('category');
$event_category =  kodeforest_shortcodes_categories('event-categories');
$team_category =  kodeforest_shortcodes_categories('team-categories');
$choices = array('yes' => 'Yes', 'no' => 'No');
$reverse_choices = array('no' => 'No', 'yes' => 'Yes');
$dec_numbers = array('0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1' );

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = KODEFOREST_TINYMCE_DIR . '/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Alert Type', 'kickoff' ),
			'desc' => __( 'Select the type of alert message', 'kickoff' ),
			'options' => array(
				'general' => 'General',
				'error' => 'Error',
				'success' => 'Success',
				'notice' => 'Notice',
			)
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'kickoff'),
			'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
			'options' => $icons
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'kickoff' ),
			'desc' => __( 'Insert the alert\'s content', 'kickoff' ),
		),
		// 'animation_type' => array(
			// 'type' => 'select',
			// 'label' => __( 'Animation Type', 'kickoff' ),
			// 'desc' => __( 'Select the type on animation to use on the shortcode', 'kickoff' ),
			// 'options' => array(
				// '0' => 'None',
				// 'bounce' => 'Bounce',
				// 'fade' => 'Fade',
				// 'flash' => 'Flash',
				// 'shake' => 'Shake',
				// 'slide' => 'Slide',
			// )
		// ),
		// 'animation_direction' => array(
			// 'type' => 'select',
			// 'label' => __( 'Direction of Animation', 'kickoff' ),
			// 'desc' => __( 'Select the incoming direction for the animation', 'kickoff' ),
			// 'options' => array(
				// 'down' => 'Down',
				// 'left' => 'Left',
				// 'right' => 'Right',
				// 'up' => 'Up',
			// )
		// ),
		// 'animation_speed' => array(
			// 'type' => 'select',
			// 'std' => '',
			// 'label' => __( 'Speed of Animation', 'kickoff' ),
			// 'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', 'kickoff' ),
			// 'options' => $dec_numbers,
		// )
	),
	'shortcode' => '[alert icon="{{icon}}" type="{{type}}" ]{{content}}[/alert]',
	'popup_title' => __( 'Alert Shortcode', 'kickoff' )
);


/*-----------------------------------------------------------------------------------*/
/*	TimeLine Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['timeline'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of social icons', 'kickoff' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			)
		)
	),
	'shortcode' => '[timeline size="{{size}}" ]{{child_shortcode}}[/timeline]',
	'popup_title' => __( 'TimeLine Shortcode', 'kickoff' ),	
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(

			'year' => array(
				'type' => 'text',
				'label' => __( 'Year', 'kickoff' ),
				'desc' => __( 'Add Year of the timeline here', 'kickoff' )
			),
			'title' => array(
				'type' => 'text',
				'label' => __( 'Title', 'kickoff' ),
				'desc' => __( 'Add title of the timeline here', 'kickoff' )
			),
			'desc' => array(
				'type' => 'textarea',
				'label' => __( 'Description', 'kickoff' ),
				'desc' => __( 'Add description of the timeline here', 'kickoff' )
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon', 'kickoff'),
				'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
				'options' => $icons
			),
			'class' => array(
				'type' => 'text',
				'label' => __( 'Class', 'kickoff' ),
				'desc' => __( 'Add class of the icon', 'kickoff' )			
			)
		),
		'shortcode' => '[timeline_item year="{{year}}" title="{{title}}" desc="{{desc}}" icon="{{icon}}" class="{{class}}" ][/timeline_item]',
		'clone_button' => __('Social Icon Item', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Social Icon Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['social_icons'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of social icons', 'kickoff' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			)
		)
	),
	'shortcode' => '[social_icons size="{{size}}" ]{{child_shortcode}}[/social_icons]',
	'popup_title' => __( 'Social Icons Shortcode', 'kickoff' ),	
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(

			'link' => array(
				'type' => 'text',
				'label' => __( 'Link', 'kickoff' ),
				'desc' => __( 'Add link or url of the destination', 'kickoff' )			
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon', 'kickoff'),
				'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
				'options' => $icons
			),
			'class' => array(
				'type' => 'text',
				'label' => __( 'Class', 'kickoff' ),
				'desc' => __( 'Add class of the icon', 'kickoff' )			
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'kickoff' ),
				'desc' => __( 'Select the type on animation to use on the shortcode', 'kickoff' ),
				'options' => array(
					'_self' => '_Self',
					'_blank' => '_Blank',
					'_new' => '_New',
					'_top' => '_Top',				
				)
			),		
		),
		'shortcode' => '[social_icon_item link="{{link}}" icon="{{icon}}" class="{{class}}" target="{{target}}" ][/social_icon_item]',
		'clone_button' => __('Social Icon Item', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Albums Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['albums'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				'element1-1' => 'Full Width',
				// 'element1-2' => 'Half Width',
				// 'element1-3' => 'One Third Width',
				// 'element1-4' => 'One Forth',
			)
		),
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $album_category
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		
		'num_excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'kickoff'),
			'desc' => __('Add Number of Characters to show under each post/items', 'kickoff')
		),
		
		'pagination' => array(
			'type' => 'select',
			'label' => __( 'Pagination', 'kickoff' ),
			'desc' => __( 'Do you want to turn on pagination.', 'kickoff' ),
			'options' => array(
				'Yes' => 'Yes',
				'No' => 'No',
			)
		),
		'orderby' => array(
			'type' => 'select',
			'label' => __( 'Orderby', 'kickoff' ),
			'desc' => __( 'Show post order by.', 'kickoff' ),
			'options' => array(
				'date' => 'date',
				'title' => 'title',
				'rand' => 'rand',
				'comment_count' => 'comment_count',
			)
		),
		
		'order' => array(
			'type' => 'select',
			'label' => __( 'Order', 'kickoff' ),
			'desc' => __( 'Select your posts/item order.', 'kickoff' ),
			'options' => array(
				'asc' => 'ASC',
				'desc' => 'DESC',
			)
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[albums size="{{size}}" header="{{header}}" category="{{category}}" num_fetch="{{num_fetch}}" num_excerpt="{{num_excerpt}}" pagination="{{pagination}}" orderby="{{orderby}}" order="{{order}}" item_margin="{{item_margin}}"][/albums]',
	'popup_title' => __( 'Albums Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Progress Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['progressbar'] = array(
	'no_preview' => true,
	'params' => array(
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => __('Add title here', 'kickoff')
		),
		'text_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Text Color', 'kickoff'),
			'desc' => __('Set the text color of the progress bar.', 'kickoff')
		),
		'filled_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Filled Color', 'kickoff'),
			'desc' => __('Set the filled color of the progress bar.', 'kickoff')
		),
		'unfilled_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Unfilled Color', 'kickoff'),
			'desc' => __('Set the unfilled color of the progress bar.', 'kickoff')
		),
		'filled' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Filled Amount', 'kickoff'),
			'desc' => __('Add Filled here', 'kickoff')
		)
	),
	'shortcode' => '[progressbar title="{{title}}" text_color="{{text_color}}" filled_color="{{filled_color}}" unfilled_color="{{unfilled_color}}" filled="{{filled}}" ][/progressbar]',
	'popup_title' => __( 'Progress bar Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Blog Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['heading'] = array(
	'no_preview' => true,
	'params' => array(
		
		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'kickoff' ),
			'desc' => __( 'Select heading style', 'kickoff' ),
			'options' => array(
				'modern-style' => 'Modern Style',
				'simple-style' => 'Simple Style',
				'normal-style' => 'Normal Style'
			)
		),		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => __('Add title here', 'kickoff')
		),		
		'title_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select title Color', 'kickoff'),
			'desc' => __('Set the title color of the heading title.', 'kickoff')
		),
		'caption' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Caption', 'kickoff'),
			'desc' => __('Add caption text here', 'kickoff')
		),
		'caption_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select caption Color', 'kickoff'),
			'desc' => __('Set the caption color of the heading caption.', 'kickoff')
		),
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Content', 'kickoff'),
			'desc' => __('Add Content text here', 'kickoff')
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[heading style="{{style}}" title="{{title}}" title_color="{{title_color}}" caption="{{caption}}" caption_color="{{caption_color}}" item_margin="{{item_margin}}" ]{{content}}[/heading]',
	'popup_title' => __( 'Heading Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Blog Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				'1/1 Full Thumbnail' => 'Full Width',
				'1/2 Blog Grid' => 'Half Width',
				'1/3 Blog Grid' => 'One Third Width',
				'1/4 Blog Widget' => 'One Forth',
			)
		),		
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $post_category
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		
		'num_excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'kickoff'),
			'desc' => __('Add Number of Characters to show under each post/items', 'kickoff')
		),
		
		'pagination' => array(
			'type' => 'select',
			'label' => __( 'Pagination', 'kickoff' ),
			'desc' => __( 'Do you want to turn on pagination.', 'kickoff' ),
			'options' => array(
				'Yes' => 'Yes',
				'No' => 'No',
			)
		),
		'orderby' => array(
			'type' => 'select',
			'label' => __( 'Orderby', 'kickoff' ),
			'desc' => __( 'Show post order by.', 'kickoff' ),
			'options' => array(
				'date' => 'date',
				'title' => 'title',
				'rand' => 'rand',
				'comment_count' => 'comment_count',
			)
		),
		
		'order' => array(
			'type' => 'select',
			'label' => __( 'Order', 'kickoff' ),
			'desc' => __( 'Select your posts/item order.', 'kickoff' ),
			'options' => array(
				'asc' => 'ASC',
				'desc' => 'DESC',
			)
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[blog size="{{size}}" header="{{header}}" category="{{category}}" num_fetch="{{num_fetch}}" num_excerpt="{{num_excerpt}}" pagination="{{pagination}}" orderby="{{orderby}}" order="{{order}}" item_margin="{{item_margin}}"][/blog]',
	'popup_title' => __( 'Blog Shortcode', 'kickoff' )
);
	// <Recent-Posts>
		// <size>element2-3</size>
		// <show-caption>&lt;span class=&quot;color&quot;&gt;From Our&lt;/span&gt; Blog</show-caption>
		// <feature-post>98</feature-post>
		// <num-excerpt>140</num-excerpt>
		// <category>6</category>
		// <num-fetch>2</num-fetch>
		// <item-margin>30</item-margin>
	// </Recent-Posts>
/*-----------------------------------------------------------------------------------*/
/*	Recent Post Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['recent_post'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				//'element1-1' => 'Full Width',
				//'element1-2' => 'Half Width',
				'element2-3' => 'Two Third',
				//'element1-4' => 'One Forth',
			)
		),
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		'feature_post' => array(
			'type' => 'select',
			'label' => __( 'Select Feature Post', 'kickoff' ),
			'desc' => __( 'Select feature post/item', 'kickoff' ),
			'options' => get_post_list_sc('post')
		),
		'post_num_excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'kickoff'),
			'desc' => __('Add Number of Characters to show under feature post/items', 'kickoff')
		),
		
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $post_category
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[recent_post size="{{size}}" header="{{header}}" feature_post="{{feature_post}}" post_num_excerpt="{{post_num_excerpt}}" category="{{category}}" num_fetch="{{num_fetch}}" item_margin="{{item_margin}}"][/recent_post]',
	'popup_title' => __( 'Recent Posts Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Counter Circle Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['counter_circle'] = array(
	'no_preview' => true,
	'params' => array(
		
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Select Event', 'kickoff' ),
			'desc' => __( 'Select Event to show its counter', 'kickoff' ),
			'options' => get_post_list_sc('event')
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Width of Counter', 'kickoff'),
			'desc' => __('Add width in pixels of counter circles', 'kickoff')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Height of Counter', 'kickoff'),
			'desc' => __('Add height in pixels of counter circles', 'kickoff')
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Text Color', 'kickoff'),
			'desc' => __('Set the color of the circle text.', 'kickoff')
		),
		'unfilled_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Unfilled Color', 'kickoff'),
			'desc' => __('Set the unfilled color of the circle.', 'kickoff')
		),
		'filled_color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Filled Color', 'kickoff'),
			'desc' => __('Set the filled color of the circle.', 'kickoff')
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[counter_circle header="{{header}}" event_id="{{event_id}}" width="{{width}}" height="{{height}}" color="{{color}}" unfilled_color="{{unfilled_color}}" filled_color="{{filled_color}}" item_margin="{{item_margin}}"][/counter_circle]',
	'popup_title' => __( 'Event Counter Circle Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Skill Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['skill'] = array(
	'no_preview' => true,
	'params' => array(
		
		'filled_color' => array(
			'type' => 'colorpicker',
			'label' => esc_attr__('Select Filled Color', 'kickoff'),
			'desc' => esc_attr__('Set the filled color of the progress bar.', 'kickoff')
		),
		'unfilled_color' => array(
			'type' => 'colorpicker',
			'label' => esc_attr__('Select Unfilled Color', 'kickoff'),
			'desc' => esc_attr__('Set the unfilled color of the progress bar.', 'kickoff')
		),
		'value' => array(
			'std' => '',
			'type' => 'text',
			'label' => esc_attr__('Value', 'kickoff'),
			'desc' => esc_attr__('Add Value here', 'kickoff')
		),
		'unit' => array(
			'std' => '',
			'type' => 'text',
			'label' => esc_attr__('Unit', 'kickoff'),
			'desc' => esc_attr__('Add Filled unit here', 'kickoff')
		)
	),
	'shortcode' => '[skill filled_color="{{filled_color}}" unfilled_color="{{unfilled_color}}" value="{{value}}" unit="{{unit}}" ][/skill]',
	'popup_title' => esc_attr__( 'Skill Circle Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	News Slider Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['news_slider'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				//'element1-1' => 'Full Width',
				//'element1-2' => 'Half Width',
				'element1-3' => 'One Third',
				//'element1-4' => 'One Forth',
			)
		),
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $post_category
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		'num_excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'kickoff'),
			'desc' => __('Add Number of Characters to show under each post/items', 'kickoff')
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[news_slider size="{{size}}" header="{{header}}" category="{{category}}" num_fetch="{{num_fetch}}" num_excerpt="{{num_excerpt}}" item_margin="{{item_margin}}"][/news_slider]',
	'popup_title' => __( 'News/Blog Slider Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Event Config
/*-----------------------------------------------------------------------------------*/
// <Event>
		// <size>element1-1</size>
		// <header>&lt;span class=&quot;color&quot;&gt;Upcoming &lt;/span&gt; Events</header>
		// <event-type>Event Listing</event-type>
		// <num-excerpt>300</num-excerpt>
		// <item-scope>Future</item-scope>
		// <category>14</category>
		// <num-fetch>2</num-fetch>
		// <pagination>Yes</pagination>
		// <order>desc</order>
		// <item-margin>0</item-margin>
	// </Event>
$kodeforest_shortcodes['events'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				'element1-1' => 'Full Width',
				'element1-2' => 'Half Width',
				'element1-3' => 'One Third Width',
				'element1-4' => 'One Forth',
			)
		),
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $event_category
		),
		'item_scope' => array(
			'type' => 'select',
			'label' => __( 'Item Scope', 'kickoff' ),
			'desc' => __( 'Select the item scope of shortcode element', 'kickoff' ),
			'options' => array(
				'Future' => 'Future',
				'Past' => 'Past',
				'All' => 'All',
			)
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		
		'num_excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'kickoff'),
			'desc' => __('Add Number of Characters to show under each post/items', 'kickoff')
		),
		
		// 'pagination' => array(
			// 'type' => 'select',
			// 'label' => __( 'Pagination', 'kickoff' ),
			// 'desc' => __( 'Do you want to turn on pagination.', 'kickoff' ),
			// 'options' => array(
				// 'Yes' => 'Yes',
				// 'No' => 'No',
			// )
		// ),
		// 'orderby' => array(
			// 'type' => 'select',
			// 'label' => __( 'Orderby', 'kickoff' ),
			// 'desc' => __( 'Show post order by.', 'kickoff' ),
			// 'options' => array(
				// 'date' => 'date',
				// 'title' => 'title',
				// 'rand' => 'rand',
				// 'comment_count' => 'comment_count',
			// )
		// ),
		
		'order' => array(
			'type' => 'select',
			'label' => __( 'Order', 'kickoff' ),
			'desc' => __( 'Select your posts/item order.', 'kickoff' ),
			'options' => array(
				'asc' => 'ASC',
				'desc' => 'DESC',
			)
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[events size="{{size}}" header="{{header}}" category="{{category}}" item_scope="{{item_scope}}" num_fetch="{{num_fetch}}" num_excerpt="{{num_excerpt}}" order="{{order}}" item_margin="{{item_margin}}"][/events]',
	'popup_title' => __( 'Event Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Event Config
/*-----------------------------------------------------------------------------------*/
// <Team>
	// <size>element1-1</size>
	// <header>&lt;span class=&quot;color&quot;&gt;Our &lt;/span&gt;Team</header>
	// <num-fetch>4</num-fetch>
	// <category>event-managers</category>
	// <pagination>No</pagination>
	// <item-margin>0</item-margin>
// </Team>
$kodeforest_shortcodes['teams'] = array(
	'no_preview' => true,
	'params' => array(
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'kickoff' ),
			'desc' => __( 'Select the size of shortcode element', 'kickoff' ),
			'options' => array(
				'element1-1' => 'Full Width',
			)
		),
		'header' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Header Title', 'kickoff'),
			'desc' => __('Add header title here', 'kickoff')
		),
		'category' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'kickoff' ),
			'desc' => __( 'Select category to fetch its items', 'kickoff' ),
			'options' => $team_category
		),
		'num_fetch' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Fetch number of items/posts', 'kickoff' ),
			'desc' => __( 'Select number of items/posts to show on page', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 20, false )
		),
		'pagination' => array(
			'type' => 'select',
			'label' => __( 'Pagination', 'kickoff' ),
			'desc' => __( 'Do you want to turn on pagination.', 'kickoff' ),
			'options' => array(
				'Yes' => 'Yes',
				'No' => 'No',
			)
		),
		'item_margin' => array(
			'std' => 30,
			'type' => 'select',
			'label' => __( 'Item Margin', 'kickoff' ),
			'desc' => __( 'Select margin from bottom', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		
	),
	'shortcode' => '[teams size="{{size}}" header="{{header}}" category="{{category}}" num_fetch="{{num_fetch}}" pagination="{{pagination}}" item_margin="{{item_margin}}"][/teams]',
	'popup_title' => __( 'Teams Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(

		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'kickoff'),
			'desc' => __('Add the button\'s url ex: http://example.com', 'kickoff')
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Target', 'kickoff'),
			'desc' => __('_self = open in same window <br />_blank = open in new window', 'kickoff'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Select Text Color', 'kickoff'),
			'desc' => __('Set the color of the Button text.', 'kickoff')
		),
		'bgcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Select Background Color', 'kickoff'),
			'desc' => __('Set the color of the Button background.', 'kickoff')
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Button Size', 'kickoff'),
			'desc' => __('Select the button\'s size', 'kickoff'),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large'
			)
		),
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Button\'s Text', 'kickoff'),
			'desc' => __('Add the text that will display in the button', 'kickoff'),
		),
	),
	'shortcode' => '[button link="{{url}}" target="{{target}}" color="{{color}}" bgcolor="{{bgcolor}}" size="{{size}}" ]{{content}}[/button]',
	'popup_title' => __('Button Shortcode', 'kickoff')
);

/*-----------------------------------------------------------------------------------*/
/*	Checklist Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['checklist'] = array(
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'kickoff'),
			'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
			'options' => $icons
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Icon Color', 'kickoff'),
			'desc' => __('Leave blank for default', 'kickoff')
		),
		'circle' => array(
			'type' => 'select',
			'label' => __('Icon in Circle', 'kickoff'),
			'desc' => __('Choose to display the icon in a circle', 'kickoff'),
			'options' => $choices
		),
	),

	'shortcode' => '[checklist icon="{{icon}}" iconcolor="{{iconcolor}}" circle="{{circle}}"]&lt;ul&gt;{{child_shortcode}}&lt;/ul&gt;[/checklist]',
	'popup_title' => __('Checklist Shortcode', 'kickoff'),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'List Item Content', 'kickoff' ),
				'desc' => __( 'Add list item content', 'kickoff' ),
			),
		),
		'shortcode' => '&lt;li&gt;{{content}}&lt;/li&gt;',
		'clone_button' => __('Add New List Item', 'kickoff')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Dropcap Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Dropcap color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'A',
			'type' => 'textarea',
			'label' => __( 'Dropcap Letter', 'kickoff' ),
			'desc' => __( 'Add the letter to be used as dropcap', 'kickoff' ),
		)

	),
	'shortcode' => '[dropcap color="{{color}}"]{{content}}[/dropcap]',
	'popup_title' => __( 'Dropcap Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Call To Action Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['calltoaction'] = array(
	'no_preview' => true,
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Action Class', 'kickoff'),
			'desc' => __('Add class of the action.', 'kickoff')
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text of action', 'kickoff'),
			'desc' => __('Add title of the action.', 'kickoff')
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Choose color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Select Style', 'kickoff'),
			'desc' => 'Select alignment of call to action text.',
			'options' => array(
				'style-1' => 'Style 1',
				'style-2' => 'Style 2',
				// 'style-3' => 'style 3'
			)
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Alignment', 'kickoff'),
			'desc' => 'Select alignment of call to action text.',
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center'
			)
		),
		'btn_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Text', 'kickoff'),
			'desc' => __('Add button text of the action.', 'kickoff')
		),
		'btn_url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'kickoff'),
			'desc' => __('Add button URL of the action.', 'kickoff')
		),
		'btn_text_1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Text Second', 'kickoff'),
			'desc' => __('Add button text of the action.', 'kickoff')
		),
		'btn_url_1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL Second', 'kickoff'),
			'desc' => __('Add button URL of the action.', 'kickoff')
		)
	),
	'shortcode' => '[calltoaction class="{{class}}" style="{{style}}" title="{{title}}" color="{{color}}" align="{{align}}" btn_text="{{btn_text}}" btn_url="{{btn_url}}" btn_text_1="{{btn_text_1}}" btn_url_1="{{btn_url_1}}" ][/calltoaction]',
	'popup_title' => __( 'Call to Action Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Theme Button Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['theme_button'] = array(
	'no_preview' => true,
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Class', 'kickoff'),
			'desc' => __('Add button class here.', 'kickoff')
		),
		'btn_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Text', 'kickoff'),
			'desc' => __('Add Button Text Here.', 'kickoff')
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Button Text color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Alignment', 'kickoff'),
			'desc' => 'Select alignment of call to action text.',
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center'
			)
		),
		'btn_background' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Button Background color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
		'btn_url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'kickoff'),
			'desc' => __('Add button URL of the action.', 'kickoff')
		)
	),
	'shortcode' => '[theme_button class="{{class}}" btn_text="{{btn_text}}" color="{{color}}" align="{{align}}" btn_background="{{btn_background}}" btn_url="{{btn_url}}" ][/theme_button]',
	'popup_title' => __( 'Call to Action Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Social Network Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['social_network'] = array(
	'no_preview' => true,
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Social Network Class', 'kickoff'),
			'desc' => __('Add social network class here.', 'kickoff')
		),
		
	),
	'shortcode' => '[social_network class="{{class}}" ][/social_network]',
	'popup_title' => __( 'Social Network Shortcode', 'kickoff' )
);
$kodeforest_shortcodes['our_clients'] = array(
	'params' => array(

		
	),
	'no_preview' => true,
	'shortcode' => '[our_clients]{{child_shortcode}}[/our_clients]',
	'popup_title' => __('Insert Tab Shortcode', 'kickoff'),

	'child_shortcode' => array(
		'params' => array(
		
			'image' => array(
				'type' => 'uploader',
				'label' => __('client Image', 'kickoff'),
				'desc' => 'Clicking this image will show lightbox'
			),
			'link' => array(
				'std' => 'Link',
				'type' => 'text',
				'label' => __('Add link for client', 'kickoff'),
				'desc' => __('link for client', 'kickoff'),
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'kickoff' ),
				'desc' => __( '', 'kickoff' ),
				'options' => array(
					'_self' => '_Self',
					'_blank' => '_Blank',
					'_new' => '_New',
					'_top' => '_Top',				
				)
			)
		),
		'shortcode' => '[client link="{{link}}" image="{{image}}" target="{{target}}" ][/client]',
		'clone_button' => __('Add Client', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Social Network Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['list_items'] = array(
	'no_preview' => true,
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Social Network Class', 'kickoff'),
			'desc' => __('Add social network class here.', 'kickoff')
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Alignment', 'kickoff'),
			'desc' => 'Select alignment of call to action text.',
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center'
			)
		),
	),
	'shortcode' => '[list_items class="{{class}}" align={{align}}]{{child_shortcode}}[/list_items]',
	'popup_title' => __( 'List Items Shortcode', 'kickoff' ),
	'child_shortcode' => array(
		'params' => array(
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon', 'kickoff'),
				'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
				'options' => $icons
			),
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Title ', 'kickoff'),
				'desc' => __('Add title here.', 'kickoff')
			),
			'caption' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Caption ', 'kickoff'),
				'desc' => __('Add title here.', 'kickoff')
			),
			'color' => array(
				'type' => 'colorpicker',
				'std' => '',
				'label' => __('Button Text color', 'kickoff'),
				'desc' => 'Leave blank for default'
			),
		),
		'shortcode' => '[list_item icon="{{icon}}" title="{{title}}" caption="{{caption}}" color="{{color}}" ][/list_item]',
		'clone_button' => __('Add Item', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	FontAwesome Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'kickoff'),
			'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
			'options' => $icons
		),
		'circle' => array(
			'type' => 'select',
			'label' => __('Icon in Circle', 'kickoff'),
			'desc' => 'Choose to display the icon in a circle',
			'options' => $choices
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Size of Icon', 'kickoff'),
			'desc' => 'Select the size of the icon',
			'options' => array(
				'large' => 'Large',
				'medium' => 'Medium',
				'small' => 'Small'
			)
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Icon Color', 'kickoff'),
			'desc' => __('Leave blank for default', 'kickoff')
		),
		'circlecolor' => array(
			'type' => 'colorpicker',
			'label' => __('Icon Circle Background Color', 'kickoff'),
			'desc' => __('Leave blank for default', 'kickoff')
		),
		'circlebordercolor' => array(
			'type' => 'colorpicker',
			'label' => __('Icon Circle Border Color', 'kickoff'),
			'desc' => __('Leave blank for default', 'kickoff')
		),
	),
	'shortcode' => '[fontawesome icon="{{icon}}" circle="{{circle}}" size="{{size}}" iconcolor="{{iconcolor}}" circlecolor="{{circlecolor}}" circlebordercolor="{{circlebordercolor}}"]',
	'popup_title' => __( 'FontAwesome Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Fullwidth Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['fullwidth'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Background Color', 'kickoff'),
			'desc' => __('Leave blank for default', 'kickoff')
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __('Backgrond Image', 'kickoff'),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __('Background Repeat', 'kickoff'),
			'desc' => 'Choose how the background image repeats.',
			'options' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat Vertically and Horizontally',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically'
			)
		),
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __('Background Position', 'kickoff'),
			'desc' => 'Choose the postion of the background image',
			'options' => array(
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
				'center top' => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom'
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __('Background Scroll', 'kickoff'),
			'desc' => 'Choose how the background image scrolls',
			'options' => array(
				'scroll' => 'Scroll: background scrolls along with the element',
				'fixed' => 'Fixed: background is fixed giving a parallax effect',
				'local' => 'Local: background scrolls along with the element\'s contents'
			)
		),
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', 'kickoff' ),
			'desc' => __( 'In pixels', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', 'kickoff' ),
			'desc' => __( 'In pixels', 'kickoff' ),
			'options' => kodeforest_shortcodes_range( 100, false )
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'kickoff' ),
			'desc' => __( 'Add content', 'kickoff' ),
		),
	),
	'shortcode' => '[fullwidth backgroundcolor="{{backgroundcolor}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" paddingTop="{{paddingtop}}px" paddingBottom="{{paddingbottom}}px"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Fullwidth Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Google Map Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['googlemap'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Map Type', 'kickoff'),
			'desc' => __('Select the type of google map to display', 'kickoff'),
			'options' => array(
				'roadmap' => 'Roadmap',
				'satellite' => 'Satellite',
				'hybrid' => 'Hybrid',
				'terrain' => 'Terrain'
			)
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __('Map Width', 'kickoff'),
			'desc' => __('Map Width in Percentage or Pixels', 'kickoff')
		),
		'height' => array(
			'std' => '300px',
			'type' => 'text',
			'label' => __('Map Height', 'kickoff'),
			'desc' => __('Map Height in Percentage or Pixels', 'kickoff')
		),
		'zoom' => array(
			'std' => 14,
			'type' => 'select',
			'label' => __('Zoom Level', 'kickoff'),
			'desc' => 'Higher number will be more zoomed in.',
			'options' => kodeforest_shortcodes_range( 25, false )
		),
		'scrollwheel' => array(
			'type' => 'select',
			'label' => __('Scrollwheel on Map', 'kickoff'),
			'desc' => 'Enable zooming using a mouse\'s scroll wheel',
			'options' => $choices
		),
		'scale' => array(
			'type' => 'select',
			'label' => __('Show Scale Control on Map', 'kickoff'),
			'desc' => 'Display the map scale',
			'options' => $choices
		),
		'zoom_pancontrol' => array(
			'type' => 'select',
			'label' => __('Show Pan Control on Map', 'kickoff'),
			'desc' => 'Displays pan control button',
			'options' => $choices
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Address', 'kickoff' ),
			'desc' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol. <br />ex: Address 1|Address 2|Address 3', 'kickoff' ),
		)
	),
	'shortcode' => '[map address="{{content}}" type="{{type}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}"][/map]',
	'popup_title' => __( 'Google Map Shortcode', 'kickoff' ),
);

/*-----------------------------------------------------------------------------------*/
/*	Donation Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['kode_donation'] = array(
	'no_preview' => true,
	'params' => array(

		'email' => array(
			'std' => 'info@example.com',
			'type' => 'text',
			'label' => __('Email', 'kickoff'),
			'desc' => __('Add paypal email where you want to receive donation.', 'kickoff')
		),
		'notify' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Process Page URL', 'kickoff'),
			'desc' => __('Process page URL where you want to store any value to database.', 'kickoff')
		),
		'success' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Thank you page', 'kickoff'),
			'desc' => 'Thank you page or sucess page.',			
		)
	),
	'shortcode' => '[kode_donation email="{{email}}" notify="{{notify}}" success="{{success}}" ][/kode_donation]',
	'popup_title' => __( 'Donation Shortcode', 'kickoff' ),
);
/*-----------------------------------------------------------------------------------*/
/*	Highlight Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' => array(

		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Highlight Text Color', 'kickoff'),
			'desc' => __('Pick a highlight color', 'kickoff')
		),
		'bg_color' => array(
			'type' => 'colorpicker',
			'label' => __('Highlight Background Color', 'kickoff'),
			'desc' => __('Pick a highlight color', 'kickoff')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content to Higlight', 'kickoff' ),
			'desc' => __( 'Add your content to be highlighted', 'kickoff' ),
		)

	),
	'shortcode' => '[highlight color="{{color}}" bg_color="{{bg_color}}"]{{content}}[/highlight]',
	'popup_title' => __( 'Highlight Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'params' => array(

		'full_image' => array(
			'type' => 'uploader',
			'label' => __('Full Image', 'kickoff'),
			'desc' => 'Upload an image that will show up in the lightbox'
		),
		'thumb_image' => array(
			'type' => 'uploader',
			'label' => __('Thumbnail Image', 'kickoff'),
			'desc' => 'Clicking this image will show lightbox'
		),
		'alt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Alt Text', 'kickoff'),
			'desc' => 'The alt attribute provides alternative information if an image cannot be viewed'
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Lightbox Description', 'kickoff'),
			'desc' => 'This will show up in the lightbox as a description below the image'
		),
	),
	'shortcode' => '&lt;a title="{{title}}" href="{{full_image}}" rel="prettyPhoto"&gt;&lt;img alt="{{alt}}" src="{{thumb_image}}" /&gt;&lt;/a&gt;',
	'popup_title' => __( 'Lightbox Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Team/Persons Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['member'] = array(
	'no_preview' => true,
	'params' => array(

		'picture' => array(
			'type' => 'uploader',
			'label' => __('Picture', 'kickoff'),
			'desc' => 'Upload an image to display'
		),
		'pic_link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Picture Link URL', 'kickoff'),
			'desc' => 'Add the URL the picture will link to, ex: http://example.com'
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Name', 'kickoff'),
			'desc' => 'Insert the name of the person'
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => 'Insert the title of the person'
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Email Address', 'kickoff'),
			'desc' => 'Insert an email address to display the email icon'
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Facebook Profile Link', 'kickoff'),
			'desc' => 'Insert a url to display the facebook icon'
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Twitter Profile Link', 'kickoff'),
			'desc' => 'Insert a url to display the twitter icon'
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('LinkedIn Profile Link', 'kickoff'),
			'desc' => 'Insert a url to display the linkedin icon'
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Dribbble Profile Link', 'kickoff'),
			'desc' => 'Insert a url to display the dribbble icon'
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Link Target', 'kickoff'),
			'desc' => __('_self = open in same window <br /> _blank = open in new window', 'kickoff'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Profile Description', 'kickoff'),
			'desc' => 'Enter the content to be displayed'
		),
	),
	'shortcode' => '[member name="{{name}}" picture="{{picture}}" pic_link="{{pic_link}}" title="{{title}}" email="{{email}}" facebook="{{facebook}}" twitter="{{twitter}}" linkedin="{{linkedin}}" dribbble="{{dribbble}}" linktarget="{{target}}"]{{content}}[/member]',
	'popup_title' => __( 'Member Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Separator Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(

		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'kickoff' ),
			'desc' => 'Choose the separator line style',
			'options' => array(
				'none' => 'No Style',
				'single' => 'Single Border',
				'double' => 'Double Border',
				'dashed' => 'Dashed Border',
				'dotted' => 'Dotted Border',
				'shadow' => 'Shadow'
			)
		),
		'top' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __('Margin Top', 'kickoff'),
			'desc' => 'Spacing above the separator',
			'options' => kodeforest_shortcodes_range( 100, false, false, 0 )
		),
		'bottom' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __('Margin Bottom', 'kickoff'),
			'desc' => 'Spacing below the separator',
			'options' => kodeforest_shortcodes_range( 100, false, false, 0 )
		)
	),
	'shortcode' => '[separator top="{{top}}" bottom="{{bottom}}" style="{{style}}"]',
	'popup_title' => __( 'Separator Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Sharing Box Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['sharingbox'] = array(
	'no_preview' => true,
	'params' => array(

		'tagline' => array(
			'std' => 'Share This Story, Choose Your Platform!',
			'type' => 'text',
			'label' => __('Tagline', 'kickoff'),
			'desc' => 'The title tagline that will display'
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => 'The post title that will be shared'
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link', 'kickoff'),
			'desc' => 'The link that will be shared'
		),
		'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Description', 'kickoff'),
			'desc' => 'The description that will be shared'
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link to Share', 'kickoff'),
			'desc' => ''
		),
		'pinterest_image' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __('Choose Image to Share on Pinterest', 'kickoff'),
			'desc' => ''
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Background Color', 'kickoff'),
			'desc' => __('Leave blank for default color', 'kickoff')
		),
	),
	'shortcode' => '[sharing tagline="{{tagline}}" title="{{title}}" link="{{link}}" description="{{description}}" pinterest_image="{{pinterest_image}}" backgroundcolor="{{backgroundcolor}}"][/sharing]',
	'popup_title' => __( 'Sharing Box Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	SoundCloud Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['soundcloud'] = array(
	'no_preview' => true,
	'params' => array(

		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('SoundCloud Url', 'kickoff'),
			'desc' => 'The SoundCloud url, ex: http://api.soundcloud.com/tracks/110813479'
		),
		'comments' => array(
			'type' => 'select',
			'label' => __('Show Comments', 'kickoff'),
			'desc' => 'Choose to display comments',
			'options' => $choices
		),
		'auto_play' => array(
			'type' => 'select',
			'label' => __('Autoplay', 'kickoff'),
			'desc' => 'Choose to autoplay the track',
			'options' => $reverse_choices
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '#ff7700',
			'label' => __('Color', 'kickoff'),
			'desc' => 'Select the color of the shortcode'
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __('Width', 'kickoff'),
			'desc' => 'In pixels (px) or percentage (%)'
		),
		'height' => array(
			'std' => '81px',
			'type' => 'text',
			'label' => __('Height', 'kickoff'),
			'desc' => 'In pixels (px)'
		),
	),
	'shortcode' => '[soundcloud url="{{url}}" comments="{{comments}}" auto_play="{{auto_play}}" color="{{color}}" width="{{width}}" height="{{height}}"]',
	'popup_title' => __( 'Sharing Box Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Social Links Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['sociallinks'] = array(
	'no_preview' => true,
	'params' => array(

		'colorscheme' => array(
			'type' => 'select',
			'label' => __('Color Scheme', 'kickoff'),
			'desc' => 'Choose the color scheme for the social links',
			'options' => array(
				'' => 'Default',
				'light' => 'Light',
				'dark' => 'Dark'
			)
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Link Target', 'kickoff'),
			'desc' => __('_self = open in same window <br />_blank = open in new window', 'kickoff'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'rss' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('RSS Link', 'kickoff'),
			'desc' => 'Insert your custom RSS link'
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Facebook Link', 'kickoff'),
			'desc' => 'Insert your custom Facebook link'
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Twitter Link', 'kickoff'),
			'desc' => 'Insert your custom Twitter link'
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Dribbble Link', 'kickoff'),
			'desc' => 'Insert your custom Dribbble link'
		),
		'google' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Google+ Link', 'kickoff'),
			'desc' => 'Insert your custom Google+ link'
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('LinkedIn Link', 'kickoff'),
			'desc' => 'Insert your custom LinkedIn link'
		),
		'blogger' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Blogger Link', 'kickoff'),
			'desc' => 'Insert your custom Blogger link'
		),
		'tumblr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Tumblr Link', 'kickoff'),
			'desc' => 'Insert your custom Tumblr link'
		),
		'reddit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Reddit Link', 'kickoff'),
			'desc' => 'Insert your custom Reddit link'
		),
		'yahoo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Yahoo Link', 'kickoff'),
			'desc' => 'Insert your custom Yahoo link'
		),
		'deviantart' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Deviantart Link', 'kickoff'),
			'desc' => 'Insert your custom Deviantart link'
		),
		'vimeo' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Vimeo Link', 'kickoff'),
			'desc' => 'Insert your custom Vimeo link'
		),
		'youtube' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Youtube Link', 'kickoff'),
			'desc' => 'Insert your custom Youtube link'
		),
		'pinterest' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Pinterst Link', 'kickoff'),
			'desc' => 'Insert your custom Pinterest link'
		),
		'digg' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Digg Link', 'kickoff'),
			'desc' => 'Insert your custom Digg link'
		),
		'flickr' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Flickr Link', 'kickoff'),
			'desc' => 'Insert your custom Flickr link'
		),
		'forrst' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Forrst Link', 'kickoff'),
			'desc' => 'Insert your custom Forrst link'
		),
		'myspace' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Myspace Link', 'kickoff'),
			'desc' => 'Insert your custom Myspace link'
		),
		'skype' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Skype Link', 'kickoff'),
			'desc' => 'Insert your custom Skype link'
		),
		'show_custom' => array(
			'type' => 'select',
			'label' => __('Show Custom Social Icon', 'kickoff'),
			'desc' => __('Show the custom social icon specified in Theme Options', 'kickoff'),
			'options' => $reverse_choices
		),
	),
	'shortcode' => '[social_links colorscheme="{{colorscheme}}" linktarget="{{target}}" rss="{{rss}}" facebook="{{facebook}}" twitter="{{twitter}}" dribbble="{{dribbble}}" google="{{google}}" linkedin="{{linkedin}}" blogger="{{blogger}}" tumblr="{{tumblr}}" reddit="{{reddit}}" yahoo="{{yahoo}}" deviantart="{{deviantart}}" vimeo="{{vimeo}}" youtube="{{youtube}}" pinterest="{{pinterest}}" digg="{{digg}}" flickr="{{flickr}}" forrst="{{forrst}}" myspace="{{myspace}}" skype="{{skype}}" show_custom="{{show_custom}}"]',
	'popup_title' => __( 'Social Links Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['our_clients'] = array(
	'params' => array(

		
	),
	'no_preview' => true,
	'shortcode' => '[our_clients]{{child_shortcode}}[/our_clients]',
	'popup_title' => __('Insert Tab Shortcode', 'kickoff'),

	'child_shortcode' => array(
		'params' => array(
		
			'image' => array(
				'type' => 'uploader',
				'label' => __('client Image', 'kickoff'),
				'desc' => 'Clicking this image will show lightbox'
			),
			'link' => array(
				'std' => 'Link',
				'type' => 'text',
				'label' => __('Add link for client', 'kickoff'),
				'desc' => __('link for client', 'kickoff'),
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'kickoff' ),
				'desc' => __( '', 'kickoff' ),
				'options' => array(
					'_self' => '_Self',
					'_blank' => '_Blank',
					'_new' => '_New',
					'_top' => '_Top',				
				),
			)
		),
		'shortcode' => '[client link="{{link}}" image="{{image}}" target="{{target}}"][/client]',
		'clone_button' => __('Add Client', 'kickoff')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['kode_image_gallery'] = array(
	'params' => array(
		'gallery_col' => array(
			'type' => 'select',
			'label' => __('Gallery Column', 'kickoff'),
			'desc' => __('Select gallery column to show it in grid view.', 'kickoff'),
			'options' => array(
				'2' => '2 Column',
				'3' => '3 Column',
				'4' => '4 Column'
			)
		),
	),
	'no_preview' => true,
	'shortcode' => '[kode_image_gallery]{{child_shortcode}}[/kode_image_gallery]',
	'popup_title' => __('Insert Tab Shortcode', 'kickoff'),

	'child_shortcode' => array(
		'params' => array(
		
			'image' => array(
				'type' => 'uploader',
				'label' => __('client Image', 'kickoff'),
				'desc' => 'Clicking this image will show lightbox'
			),
			'link' => array(
				'std' => 'Link',
				'type' => 'text',
				'label' => __('Add link for client', 'kickoff'),
				'desc' => __('link for client', 'kickoff'),
			)
		),
		'shortcode' => '[gallery_item link="{{link}}" image="{{image}}"][/gallery_item]',
		'clone_button' => __('Add Gallery', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['tabs'] = array(
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __('Layout', 'kickoff'),
			'desc' => 'Choose the layout of the shortcode',
			'options' => array(
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical'
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
		'inactivecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Inactive Color', 'kickoff'),
			'desc' => 'Leave blank for default'
		),
	),
	'no_preview' => true,
	'shortcode' => '[tabs layout="{{layout}}" backgroundcolor="{{backgroundcolor}}" inactivecolor="{{inactivecolor}}"]{{child_shortcode}}[/tabs]',
	'popup_title' => __('Insert Tab Shortcode', 'kickoff'),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => __('Tab Title', 'kickoff'),
				'desc' => __('Title of the tab', 'kickoff'),
			),
			'content' => array(
				'std' => 'Tab Content',
				'type' => 'textarea',
				'label' => __('Tab Content', 'kickoff'),
				'desc' => __('Add the tabs content', 'kickoff')
			)
		),
		'shortcode' => '[tab title="{{title}}"]{{content}}[/tab]',
		'clone_button' => __('Add Tab', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Title Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __('Title Size', 'kickoff'),
			'desc' => 'Choose the title size, H1-H6',
			'options' => kodeforest_shortcodes_range( 6, false )
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Select Alignment', 'kickoff'),
			'desc' => 'Choose the alinment of the text shortcode',
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'none' => 'none'
			)
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Title', 'kickoff'),
			'desc' => 'Insert the title text'
		),
	),
	'shortcode' => '[title align="{{align}}" size="{{size}}"]{{content}}[/title]',
	'popup_title' => __( 'Sharing Box Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Toggles Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['accordion'] = array(
	'params' => array(

	),
	'no_preview' => true,
	'shortcode' => '[accordian]{{child_shortcode}}[/accordian]',
	'popup_title' => __('Insert Toggles Shortcode', 'kickoff'),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Title', 'kickoff'),
				'desc' => 'Insert the accordion title',
			),
			'open' => array(
				'type' => 'select',
				'label' => __('Open by Default', 'kickoff'),
				'desc' => 'Choose to have the accordion open when page loads',
				'options' => $reverse_choices
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Accordion Content', 'kickoff'),
				'desc' => 'Insert the accordion content'
			)
		),
		'shortcode' => '[toggle title="{{title}}" open="{{open}}"]{{content}}[/toggle]',
		'clone_button' => __('Add Accordion', 'kickoff')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Tooltip Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Tooltip Text', 'kickoff'),
			'desc' => 'Insert the text that displays in the tooltip'
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Content', 'kickoff'),
			'desc' => 'Insert the text that will activate the tooltip hover'
		),
	),
	'shortcode' => '[tooltip title="{{title}}"]{{content}}[/tooltip]',
	'popup_title' => __( 'Tooltip Shortcode', 'kickoff' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vimeo Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['vimeo'] = array(
	'no_preview' => true,
	'params' => array(

		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Video ID', 'kickoff'),
			'desc' => 'For example the Video ID for <br />https://vimeo.com/75230326 is 75230326'
		),
		'width' => array(
			'std' => '600',
			'type' => 'text',
			'label' => __('Width', 'kickoff'),
			'desc' => 'In pixels but only enter a number, ex: 600'
		),
		'height' => array(
			'std' => '350',
			'type' => 'text',
			'label' => __('Height', 'kickoff'),
			'desc' => 'In pixels but enter a number, ex: 350'
		),
		'autoplay' => array(
			'type' => 'select',
			'label' => __( 'Autoplay Video', 'kickoff' ),
			'desc' =>  __( 'Set to yes to make video autoplaying', 'kickoff' ),
			'options' => $reverse_choices
		),
		'apiparams' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('AdditionalAPI Parameter', 'kickoff'),
			'desc' => 'Use additional API parameter, for example &title=0 to disable title on video. VimeoPlus account may be required.'
		),
	),
	'shortcode' => '[vimeo id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}" api_params="{{apiparams}}"]',
	'popup_title' => __( 'Vimeo Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Youtube Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['youtube'] = array(
	'no_preview' => true,
	'params' => array(

		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Video ID', 'kickoff'),
			'desc' => 'For example the Video ID for <br />http://www.youtube.com/LOfeCR7KqUs is LOfeCR7KqUs'
		),
		'width' => array(
			'std' => '600',
			'type' => 'text',
			'label' => __('Width', 'kickoff'),
			'desc' => 'In pixels but only enter a number, ex: 600'
		),
		'height' => array(
			'std' => '350',
			'type' => 'text',
			'label' => __('Height', 'kickoff'),
			'desc' => 'In pixels but only enter a number, ex: 350'
		),
		'autoplay' => array(
			'type' => 'select',
			'label' => __( 'Autoplay Video', 'kickoff' ),
			'desc' =>  __( 'Set to yes to make video autoplaying', 'kickoff' ),
			'options' => $reverse_choices
		),
		'apiparams' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('AdditionalAPI Parameter', 'kickoff'),
			'desc' => 'Use additional API parameter, for example &rel=0 to disable related videos'
		),
	),
	'shortcode' => '[youtube id="{{id}}" width="{{width}}" height="{{height}}" autoplay="{{autoplay}}" api_params="{{apiparams}}"]',
	'popup_title' => __( 'Vimeo Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	newsletter Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['newsletter'] = array(
	'no_preview' => true,
	'params' => array(
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => 'Add title here.'
		),
		'caption' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('caption', 'kickoff'),
			'desc' => 'Add caption here.'
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Email ID', 'kickoff'),
			'desc' => 'Add Email ID in order to receive subscribers.'
		),
		'layout' => array(
			'type' => 'select',
			'label' => __('Layout', 'kickoff'),
			'desc' => __('Select the newsletter layout.', 'kickoff'),
			'options' => array(
				'style-1' => 'Style 1',
				'style-2' => 'Style 2',
			)
		),
	),
	'shortcode' => '[newsletter title="{{title}}" caption="{{caption}}" email="{{email}}" layout={{layout}}]',
	'popup_title' => __( 'Newsletter Shortcode', 'kickoff' )
);


/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['columns'] = array(
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'kickoff'),
	'no_preview' => true,
	'params' => array(),

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'kickoff'),
				'desc' => __('Select the width of the column', 'kickoff'),
				'options' => array(
					'one_third' => 'One Third',
					'two_third' => 'Two Thirds',
					'one_half' => 'One Half',
					'one_fourth' => 'One Fourth',
					'three_fourth' => 'Three Fourth',
				)
			),
			'last' => array(
				'type' => 'select',
				'label' => __('Last Column', 'kickoff'),
				'desc' => 'Choose if the column is last in a set. This has to be set to "Yes" for the last column in a set',
				'options' => $reverse_choices
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'kickoff'),
				'desc' => __('Insert the column content', 'kickoff'),
			)
		),
		'shortcode' => '[{{column}} last="{{last}}"]{{content}}[/{{column}}] ',
		'clone_button' => __('Add Column', 'kickoff')
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Project Facts Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['facts'] = array(
	'no_preview' => true,
	'params' => array(
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => esc_attr__('Select Icon', 'kickoff'),
			'desc' => esc_attr__('Click an icon to select, click again to deselect', 'kickoff'),
			'options' => $icons
		),	
		'color' => array(
			'type' => 'colorpicker',
			'label' => esc_attr__('Select Color', 'kickoff'),
			'desc' => esc_attr__('Set the fact color.', 'kickoff')
		),
		'value' => array(
			'std' => '',
			'type' => 'text',
			'label' => esc_attr__('Value', 'kickoff'),
			'desc' => esc_attr__('Add Value here', 'kickoff')
		),
		'sub_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => esc_attr__('Sub Text', 'kickoff'),
			'desc' => esc_attr__('Add Sub Text here', 'kickoff')
		)
	),
	'shortcode' => '[facts icon="{{icon}}" color="{{color}}" value="{{value}}" sub_text="{{sub_text}}" ][/facts]',
	'popup_title' => esc_attr__( 'Project Facts Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Services Config
/*-----------------------------------------------------------------------------------*/
$kodeforest_shortcodes['services'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Services Style', 'kickoff' ),
			'desc' => __( 'Select the type of services element', 'kickoff' ),
			'options' => array(
				'style-1' => 'Style 1',
				'style-2' => 'Style 2',				
			)
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'kickoff'),
			'desc' => __('Add title here', 'kickoff')
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'kickoff'),
			'desc' => __('Click an icon to select, click again to deselect', 'kickoff'),
			'options' => $icons
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'kickoff' ),
			'desc' => __( 'Insert the alert\'s content', 'kickoff' ),
		),
	),
	'shortcode' => '[services title="{{title}}" icon="{{icon}}" type="{{type}}" ]{{content}}[/services]',
	'popup_title' => __( 'Services Shortcode', 'kickoff' )
);
/*-----------------------------------------------------------------------------------*/
/*	Table Config
/*-----------------------------------------------------------------------------------*/

$kodeforest_shortcodes['table'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Type', 'kickoff'),
			'desc' => __('Select the table style', 'kickoff'),
			'options' => array(
				'1' => 'Style 1',
				'2' => 'Style 2',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Number of Columns', 'kickoff'),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'1' => '1 Column',
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns'
			)
		)
	),
	'shortcode' => '',
	'popup_title' => __( 'Table Shortcode', 'kickoff' )
);