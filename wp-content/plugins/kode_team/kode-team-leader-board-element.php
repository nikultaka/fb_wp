<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class kode_extend_vc_addon_team_leader_board {
    function __construct() {
        // We safely integrate with VC with this hook
        //add_action( 'init', array( $this, 'kode_vc_notice' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'team_leader_board_item', array( $this, 'kode_print_element' ) );
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
            "name" => __("Leader Board Item", 'kode-team'),
            //"description" => __("Fetch all the team posts from by category or tags.", 'kode-team'),
			"description" => __("KodeForest", 'kode-team'),
            "base" => "team_leader_board_item",
            "class" => "",
            "controls" => "full",
            "icon" => 'call-to-action', // or css class name which you can reffer in your css file later. Example: "kode-team_my_class"
            "category" => __('KodeForest', 'kode-team'),
            //'admin_enqueue_js' => array(plugins_url('assets/kode-team.js', __FILE__)), // This will load js file in the VC backend editor
             'admin_enqueue_css' => array(plugins_url('assets/vc_style_extend.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Category', 'kode-team' ),
					'param_name' => 'team_category',
					'value' => kode_get_term_list_emptyfirst('team_category'),
					'description' => __( 'Select Category.', 'kode-team' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Select Tag', 'kode-team' ),
					'param_name' => 'team_tag',
					'value' => kode_get_term_list_emptyfirst('team_tag'),
					'description' => __( 'Select Tag.', 'kode-team' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Title Num Fetch", 'kode-team'),
					"param_name" => "title_num_excerpt",
					"value" => __("5", 'kode-team'),
					"description" => __("Specify the number of title characters you want to pull out.", 'kode-team')
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Background Pattern", 'kode-team'),
					"param_name" => "pattern_image",
					"value" => __("", 'kode-team'),
					"description" => __("Upload Pattern Image from here.", 'kode-team')
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => __("Player Image", 'kode-team'),
					"param_name" => "player_image",
					"value" => __("", 'kode-team'),
					"description" => __("Upload Pattern Image from here.", 'kode-team')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Num Fetch", 'kode-team'),
					"param_name" => "num_fetch",
					"value" => __("5", 'kode-team'),
					"description" => __("Specify the number of teams you want to pull out.", 'kode-team')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Margin Bottom", 'kode-team'),
					"param_name" => "margin_bottom",
					"value" => __("", 'kode-team'),
					"description" => __("", 'kode-team')
				),
            )
        ) );
    }
	
	
    
    /*
    Shortcode logic how it should be rendered
    */
    public function kode_print_element( $atts, $content = null ) {
		extract( shortcode_atts( array(        
			'team_category' => '',
			'team_tag' => '',
			'title_num_excerpt' => '',
			'num_fetch' => '',
			'pattern_image' => '',
			'player_image' => '',
			'margin_bottom' => ''
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content		
		$settings['category'] = $team_category;
		$settings['tag'] = $team_tag;
		$settings['title-num-excerpt'] = $title_num_excerpt;
		$settings['num-fetch'] = $num_fetch;
		$settings['pattern-image'] = $pattern_image;
		$settings['player-image'] = $player_image;		
		$settings['margin-bottom'] = $margin_bottom;
		
		$output = '<div class="row">'.kode_get_leader_board_item($settings).'</div>';
		return $output;
    }
    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function kode_load_style() {
      
      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'kode-team_js', plugins_url('assets/kode-team.js', __FILE__), array('jquery') );
    }
    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function kode_print_vc_notice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'kode-team'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new kode_extend_vc_addon_team_leader_board();