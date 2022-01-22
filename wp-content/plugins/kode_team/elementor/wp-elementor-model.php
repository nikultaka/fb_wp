<?php
namespace ElementorCPT;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin_Team {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		
		wp_enqueue_style( 'elementor-main-style', plugins_url( '/assets/style.css', __FILE__ ) );  // Main Slider Main
		wp_register_script( 'core-functions', plugins_url( '/assets/js/main-functions.js', __FILE__ ), [ 'jquery' ], false, true );
		
		wp_register_script( 'owl-slider-js', plugins_url( '/assets/owl_carousel/owl_carousel.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'owl-slider-css', plugins_url( '/assets/owl_carousel/owl_carousel.css', __FILE__ ) );  // Slick
		
		wp_enqueue_style( 'wpicon-moon', plugins_url( '/assets/icons/wpicon-moon.css', __FILE__ ) );  // Slick Theme
		
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		
		require_once( __DIR__ . '/wp-elementor-control.php' );
		
		
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Teams_Listing() );
		
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin_Team::instance();
