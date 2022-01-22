<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_heading {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'heading_item', array( $this, 'kode_print_element' ) );
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
            "name" => __("Heading Item", 'vc_extend'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'vc_extend'),
			"description" => __("KodeForest", 'vc_extend'),
            "base" => "heading_item",
            "class" => "",
            "controls" => "full",
            "icon" => 'call-to-action', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('KodeForest', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            'admin_enqueue_css' => array(plugins_url('assets/vc_style_extend.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Alignment', 'js_composer' ),
					'param_name' => 'alignment',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Left', 'js_composer' ) => 'left',
						__( 'Right', 'js_composer' ) => 'right',
						__( 'Center', 'js_composer' ) => 'center',
					),
					'description' => __( '', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Heading Style', 'js_composer' ),
					'param_name' => 'element_style',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Style 1', 'js_composer' ) => 'style-1',
						__( 'Style 2', 'js_composer' ) => 'style-2',
						__( 'Style 3', 'js_composer' ) => 'style-3',
						__( 'Style4', 'js_composer' ) => 'style-4',
					),
					'description' => __( 'Select Style.', 'js_composer' )
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
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Title color", 'vc_extend'),
					"param_name" => "title_color",
					"value" => __("", 'vc_extend'),
					"description" => __("", 'vc_extend')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Caption", 'vc_extend'),
					"param_name" => "caption",
					"value" => __("", 'vc_extend'),
					"description" => __("Add heading caption here.", 'vc_extend')
				), 
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Caption color", 'vc_extend'),
					"param_name" => "caption_color",
					"value" => __("", 'vc_extend'),
					"description" => __("", 'vc_extend')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Description", 'vc_extend'),
					"param_name" => "description",
					"value" => __(" ", 'vc_extend'),
					"description" => __("", 'vc_extend')
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Description color", 'vc_extend'),
					"param_name" => "description_color",
					"value" => __("", 'vc_extend'),
					"description" => __("", 'vc_extend')
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => __("Line color", 'vc_extend'),
					"param_name" => "line_color",
					"value" => __("", 'vc_extend'),
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
			'alignment' => '',
			'element_style' => '',
			'title' => '',
			'title_color' => '',
			'caption' => '',
			'caption_color' => '',
			'description' => '',
			'description_color' => '',
			'line_color' => '',
			'margin_bottom' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['alignment'] = $alignment;
		$settings['element-style'] = $element_style;
		$settings['title'] = $title;
		$settings['title-color'] = $title_color;
		$settings['caption'] = $caption;
		$settings['caption-color'] = $caption_color;
		$settings['description'] = $description;
		$settings['num-excerpt'] = $num_excerpt;
		$settings['description-color'] = $description_color;		
		$settings['line-color'] = $line_color;
		$settings['pagination'] = $pagination;
		$settings['margin-bottom'] = $margin_bottom;
		$output = '<div class="row">'.kode_get_headings_item($settings).'</div>';
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
new kode_extend_vc_addon_heading();