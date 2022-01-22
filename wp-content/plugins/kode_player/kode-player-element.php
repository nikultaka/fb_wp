<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_player{
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'player_item', array( $this, 'kode_print_element' ) );
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
        vc_map( array(
            "name" => __("Player Item", 'kode-player'),
            //"description" => __("Fetch all the player posts from by category or tags.", 'kode-player'),
			"description" => __("KodeForest", 'kode-player'),
            "base" => "player_item",
            "class" => "",
            "controls" => "full",
            "icon" => 'call-to-action', // or css class name which you can reffer in your css file later. Example: "kode-player_my_class"
             "category" => __('KodeForest', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/kode-player.js', __FILE__)), // This will load js file in the VC backend editor
            'admin_enqueue_css' => array(plugins_url('assets/vc_style_extend.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Category', 'kode-player' ),
					'param_name' => 'player_category',
					'value' => kode_get_term_list_emptyfirst('player_category'),
					'description' => __( 'Select Category.', 'kode-player' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Tag', 'kode-player' ),
					'param_name' => 'player_tag',
					'value' => kode_get_term_list_emptyfirst('player_tag'),
					'description' => __( 'Select Tag.', 'kode-player' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Style', 'kode-player' ),
					'param_name' => 'player_style',
					'value' => array(
						__( ' ', 'kode-player' ) => 'no-category',
						__( 'Normal View', 'kode-player' ) => 'normal-view',
						__( 'Modern View', 'kode-player' ) => 'modern-view',
					),
					'description' => __( 'Select Style.', 'kode-player' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Fetch", 'kode-player'),
					"param_name" => "num_fetch",
					"value" => __("5", 'kode-player'),
					"description" => __("Specify the number of players you want to pull out.", 'kode-player')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Title Fetch", 'kode-player'),
					"param_name" => "num_title_fetch",
					"value" => __("5", 'kode-player'),
					"description" => __("Specify the number of player title you want to pull out.", 'kode-player')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Excerpt", 'kode-player'),
					"param_name" => "num_excerpt",
					"value" => __("20", 'kode-player'),
					"description" => __("Specify the number of players description you want to pull out.", 'kode-player')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order By', 'kode-player' ),
					'param_name' => 'orderby',
					'value' => array(
						__( ' ', 'kode-player' ) => 'no-category',
						__( 'Publish Date', 'kode-player' ) => 'date',
						__( 'Title', 'kode-player' ) => 'title',
						__( 'Random', 'kode-player' ) => 'rand',
					),				
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Order', 'kode-player' ),
					'param_name' => 'order',
					'value' => array(
						__( ' ', 'kode-player' ) => 'no-category',
						__( 'Descending Order', 'kode-player' ) => 'desc',
						__( 'Ascending Order', 'kode-player' ) => 'asc'						
					),				
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination', 'kode-player' ),
					'param_name' => 'pagination',
					'value' => array(
						__( ' ', 'kode-player' ) => 'no-category',
						__( 'Enable', 'kode-player' ) => 'enable',
						__( 'Disable', 'kode-player' ) => 'disable'						
					),				
				),
            )
        ) );
    }
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
    public function kode_print_element( $atts, $content = null ) {
		extract( shortcode_atts( array(        
			'player_category' => '',
			'player_tag' => '',
			'player_style' => '',
			'num_fetch' => '',
			'num_title_fetch' => '',
			'num_excerpt' => '',
			'orderby' => '',
			'order' => '',
			'pagination' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['category'] = $player_category;
		$settings['tag'] = $player_tag;
		$settings['player-style'] = $player_style;
		$settings['num-fetch'] = $num_fetch;
		$settings['num-title-fetch'] = $num_title_fetch;
		$settings['num-excerpt'] = $num_excerpt;
		$settings['orderby'] = $orderby;		
		$settings['order'] = $order;
		$settings['pagination'] = $pagination;
		
		$output = '<div class="row">'.kode_get_player_item($settings).'</div>';
		return $output;
    }
    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function kode_load_style() {
     wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );
      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'kode-player_js', plugins_url('assets/kode-player.js', __FILE__), array('jquery') );
    }
    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function kode_print_vc_notice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'kode-player'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new kode_extend_vc_addon_player();