<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_igni {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'igni_item', array( $this, 'kode_print_element' ) );
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
            "name" => __("Crowd Item", 'vc_extend'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'vc_extend'),
			"description" => __("KodeForest", 'vc_extend'),
            "base" => "igni_item",
            "class" => "",
            "controls" => "full",
            "icon" => '', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Title Fetch", 'vc_extend'),
					"param_name" => "title_num_fetch",
					"value" => __("5", 'vc_extend'),
					"description" => __("Specify the number of title of post in ignitiondeck you want to pull out.", 'vc_extend')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Category', 'js_composer' ),
					'param_name' => 'igni_category',
					'value' => kode_get_term_list_emptyfirst('project_category'),
					'description' => __( 'Select Category.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Project Type', 'js_composer' ),
					'param_name' => 'igni_tag',
					'value' => kode_get_term_list_emptyfirst('project_type'),
					'description' => __( 'Select Tag.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Style', 'js_composer' ),
					'param_name' => 'igni_style',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__('2 Column Grid', 'kickoff') => '2',
						__('3 Column Grid', 'kickoff') => '3',
						__('4 Column Grid', 'kickoff') => '4'
					),
					'description' => __( 'Select Style.', 'js_composer' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Fetch", 'vc_extend'),
					"param_name" => "num_fetch",
					"value" => __("5", 'vc_extend'),
					"description" => __("Specify the number of igni you want to pull out.", 'vc_extend')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Excerpt", 'vc_extend'),
					"param_name" => "num_excerpt",
					"value" => __("20", 'vc_extend'),
					"description" => __("Specify the number of igni description you want to pull out.", 'vc_extend')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order By', 'js_composer' ),
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
					'type' => 'dropdown',
					'heading' => __( 'Pagination', 'js_composer' ),
					'param_name' => 'pagination',
					'value' => array(
						__( ' ', 'js_composer' ) => 'no-category',
						__( 'Enable', 'js_composer' ) => 'enable',
						__( 'Disable', 'js_composer' ) => 'disable'						
					),				
				),
            )
        ));
    }
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
    public function kode_print_element( $atts, $content = null ) {
		extract( shortcode_atts( array(        
			'title_num_fetch' => '',
			'igni_category' => '',
			'igni_tag' => '',
			'igni_style' => '',
			'num_fetch' => '',
			'num_excerpt' => '',
			'orderby' => '',
			'order' => '',
			'pagination' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		
		$settings['title-num-fetch'] = $title_num_fetch;
		$settings['category'] = $igni_category;
		$settings['tag'] = $igni_tag;
		$settings['project-view'] = $igni_style;
		$settings['num-fetch'] = $num_fetch;
		$settings['num-excerpt'] = $num_excerpt;
		$settings['orderby'] = $orderby;		
		$settings['order'] = $order;
		$settings['pagination'] = $pagination;
		$output = '<div class="row">'.kode_get_crowdfunding_item($settings).'</div>';
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
new kode_extend_vc_addon_igni();