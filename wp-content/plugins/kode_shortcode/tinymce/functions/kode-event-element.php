<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_event {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'events_item', array( $this, 'kode_print_element' ) );
        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'kode_load_style' ) );
    }
 
    public function kode_vc_notice() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'kode_print_vc_notice' ));
            return;
        }
 
        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.
        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map(array(
            "name" => __("Events Item", 'vc_extend'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'vc_extend'),
			"description" => __("KodeForest", 'vc_extend'),
            "base" => "events_item",
            "class" => "",
            "controls" => "full",
            "icon" => 'call-to-action', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('KodeForest', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            'admin_enqueue_css' => array(plugins_url('assets/vc_style_extend.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title num Excerpt", 'vc_extend'),
					"param_name" => "title_num_excerpt",
					"value" => __("5", 'vc_extend'),
					"description" => __("This is a number of word (decided by spaces) that you want to show on the event title. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.", 'vc_extend')
				), 
				array(
					'type' => 'checkbox',
					'heading' => __( 'Select Category', 'js_composer' ),
					'param_name' => 'category',
					'value' => kode_get_term_list_emptyfirst('event-categories'),
					'description' => __( 'Select Category.', 'js_composer' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Select Tag', 'js_composer' ),
					'param_name' => 'tag',
					'value' => kode_get_term_list_emptyfirst('event-tags'),
					'description' => __( 'Select Tag.', 'js_composer' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Excerpt", 'vc_extend'),
					"param_name" => "num_excerpt",
					"value" => __("25", 'vc_extend'),
					"description" => __("This is a number of word (decided by spaces) that you want to show on the post excerpt. <strong>Use 0 to hide the excerpt, -1 to show full posts and use the wordpress more tag</strong>.", 'vc_extend')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Fetch", 'vc_extend'),
					"param_name" => "num_fetch",
					"value" => __("5", 'vc_extend'),
					"description" => __("Specify the number of blog you want to pull out.", 'vc_extend')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Event Style', 'js_composer' ),
					'param_name' => 'event_style',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Match Grid Modern', 'js_composer' ) => 'event-grid-modern',
						__( 'Match Table View', 'js_composer' ) => 'event-grid-simple',
						__( 'Match Full View', 'js_composer' ) => 'event-full-view',
						__( 'New Rugby', 'js_composer' ) => 'event-grid-rugby',
					),
					'description' => __( 'Select Style.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Match Scope', 'js_composer' ),
					'param_name' => 'scope',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Past Matches', 'js_composer' ) => 'past',
						__( 'Upcoming Matches', 'js_composer' ) => 'future',
						__( 'All Matches', 'js_composer' ) => 'all',
					),
					'description' => __( 'Select Style.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order', 'js_composer' ),
					'param_name' => 'order',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Descending Order', 'js_composer' ) => 'desc',
						__( 'Ascending Order', 'js_composer' ) => 'asc'						
					),				
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Margin Bottom", 'vc_extend'),
					"param_name" => "margin_bottom",
					"value" => __(" ", 'vc_extend'),
					"description" => __("", 'vc_extend')
				),
            )
        ));
    }
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
    public function kode_print_element( $atts, $content = null ) {
		extract( shortcode_atts( array(        
			'title_num_excerpt' => '',
			'category' => '',
			'tag' => '',
			'num_excerpt' => '',
			'num_fetch' => '',
			'event_style' => '',
			'scope' => '',
			'order' => '',
			'margin_bottom' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['category'] = $category;
		$settings['tag'] = $tag;
		$settings['title-num-excerpt'] = $title_num_excerpt;
		$settings['num-excerpt'] = $num_excerpt;
		$settings['num-fetch'] = $num_fetch;
		$settings['scope'] = $scope;
		$settings['order'] = $order;	
		$settings['margin-bottom'] = $margin_bottom;
		$output = '<div class="row">'.kode_get_events_item($settings).'</div>';
		return $output;
    }
    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function kode_load_style() {
      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }
    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function kode_print_vc_notice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new kode_extend_vc_addon_event();