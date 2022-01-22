<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_service {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'service_item', array( $this, 'kode_print_element' ) );
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
            "name" => __("Service Item", 'vc_extend'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'vc_extend'),
			"description" => __("KodeForest", 'vc_extend'),
            "base" => "service_item",
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
					"heading" => __("Icon Class", 'vc_extend'),
					"param_name" => "icon_type",
					"value" => __("", 'vc_extend'),
					"description" => __("Add Icon Class here.", 'vc_extend')
				), 
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title", 'vc_extend'),
					"param_name" => "title",
					"value" => __("", 'vc_extend'),
					"description" => __("Add heading title here.", 'vc_extend')
				), 
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Style', 'js_composer' ),
					'param_name' => 'style',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Style 1', 'js_composer' ) => 'type-1',
						__( 'Style 2', 'js_composer' ) => 'type-2',
						__( 'Style 3', 'js_composer' ) => 'type-3',
						__( 'Style 4', 'js_composer' ) => 'type-4',
						__( 'Cricket Style', 'js_composer' ) => 'type-5',
					),
					'description' => __( '', 'js_composer' )
				),
				array(
					"type" => "textarea",
					"class" => "",
					"heading" => __("Description", 'vc_extend'),
					"param_name" => "content_desc",
					"value" => __("", 'vc_extend'),
					"description" => __("Add description here.", 'vc_extend')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Link", 'vc_extend'),
					"param_name" => "link",
					"value" => __("", 'vc_extend'),
					"description" => __("Please add link here for services.", 'vc_extend')
				), 
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Link text", 'vc_extend'),
					"param_name" => "link_text",
					"value" => __(" ", 'vc_extend'),
					"description" => __("", 'vc_extend')
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
			'icon_type' => '',
			'title' => '',
			'style' => '',
			'content_desc' => '',
			'link' => '',
			'link_text' => '',
			'margin_bottom' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['icon-type'] = $icon_type;
		$settings['title'] = $title;
		$settings['style'] = $style;
		$settings['content'] = $content_desc;
		$settings['link'] = $link;
		$settings['link-text'] = $link_text;		
		$settings['margin-bottom'] = $margin_bottom;
		$output = '<div class="row">'.kode_get_column_service_item($settings).'</div>';
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
new kode_extend_vc_addon_service();