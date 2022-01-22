<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_woo_slider {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'woo_slider_item', array( $this, 'kode_print_element' ) );
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
            "name" => __("Woo Slider", 'vc_extend'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'vc_extend'),
			"description" => __("KodeForest", 'vc_extend'),
            "base" => "woo_slider_item",
            "class" => "",
            "controls" => "full",
            "icon" => 'call-to-action', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('KodeForest', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            'admin_enqueue_css' => array(plugins_url('assets/vc_style_extend.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					'type' => 'checkbox',
					'heading' => __( 'Select Category', 'js_composer' ),
					'param_name' => 'woo_category',
					'value' => kode_get_term_list_emptyfirst('product_cat'),
					'description' => __( 'Select Category.', 'js_composer' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Select Tag', 'js_composer' ),
					'param_name' => 'woo_tag',
					'value' => kode_get_term_list_emptyfirst('product_tag'),
					'description' => __( 'Select Tag.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Style', 'js_composer' ),
					'param_name' => 'woo_style',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__('Style 1', 'kickoff') => 'woo-style-1',
						__('Style 2', 'kickoff') => 'woo-style-2',
					),
					'description' => __( 'Select Style.', 'js_composer' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title Num Fetch", 'vc_extend'),
					"param_name" => "num_title_fetch",
					"value" => __("15", 'vc_extend'),
					"description" => __("Specify the number of woo you want to pull out.", 'vc_extend')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'OrderBy', 'js_composer' ),
					'param_name' => 'orderby',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Publish Date', 'js_composer' ) => 'date',
						__( 'Title', 'js_composer' ) => 'title',	
						__( 'Random', 'js_composer' ) => 'rand',						
					),				
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
					"description" => __("Spaces after ending of this elements", 'vc_extend')
				),
            )
        ));
    }
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
    public function kode_print_element( $atts, $content = null ) {
		extract( shortcode_atts( array(        
			'woo_category' => '',
			'woo_tag' => '',
			'woo_style' => '',
			'num_title_fetch' => '',
			'orderby' => '',
			'order' => '',
			'margin_bottom' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['category'] = $woo_category;
		$settings['tag'] = $woo_tag;
		$settings['woo-style'] = $woo_style;
		$settings['num-title-fetch'] = $num_title_fetch;
		$settings['orderby'] = $orderby;
		$settings['order'] = $order;
		$settings['margin_bottom'] = $margin_bottom;
		$output = '<div class="row">'.kode_get_woo_item_slider($settings).'</div>';
		return $output;
    }
    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function kode_load_style() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );
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
new kode_extend_vc_addon_woo_slider();