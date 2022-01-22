<?php
namespace ElementorDefaultCPT;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

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
		wp_register_script( 'bx-main-slider', plugins_url( '/assets/bxslider/jquery.bxslider.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'bx-main-slider', plugins_url( '/assets/bxslider/bxslider.css', __FILE__ ) );  // BxSlider
		
		wp_register_script( 'slick-slider-js', plugins_url( '/assets/slick/slick.min.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'slick-slider-css', plugins_url( '/assets/slick/slick.css', __FILE__ ) );  // Slick
		wp_enqueue_style( 'slick-slider-theme', plugins_url( '/assets/slick/slick-theme.css', __FILE__ ) );  // Slick Theme
		
		wp_register_script( 'owl-slider-js', plugins_url( '/assets/owl_carousel/owl_carousel.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'owl-slider-css', plugins_url( '/assets/owl_carousel/owl_carousel.css', __FILE__ ) );  // Slick
		
		wp_register_script( 'prettyphoto-main', plugins_url( '/assets/prettyphoto/prettyphoto-main.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'prettyphoto-theme', plugins_url( '/assets/prettyphoto/prettyphoto.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'prettyphoto-theme', plugins_url( '/assets/prettyphoto/prettyphoto.css', __FILE__ ) );  // Slick Theme
		
		wp_enqueue_style( 'wpicon-moon', plugins_url( '/assets/icons/wpicon-moon.css', __FILE__ ) );  // Slick Theme
		
		
		
		wp_register_script('custom_countdown', plugins_url( '/assets/countdown/jquery.countdown.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script('custom_downcount', plugins_url( '/assets/countdown/jquery-downcount.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_enqueue_style( 'custom_countdown', plugins_url( '/assets/countdown/countdown.css', __FILE__ ) );  // countdown
		
		
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
		
		require_once( __DIR__ . '/widgets/main-slider.php' );
		// require_once( __DIR__ . '/widgets/call-to-action.php' );
		// require_once( __DIR__ . '/widgets/call-to-action-text.php' );
		// require_once( __DIR__ . '/widgets/call-to-action-image.php' );
		require_once( __DIR__ . '/widgets/project-facts.php' );
		
		require_once( __DIR__ . '/widgets/fancy-heading.php' );
		// require_once( __DIR__ . '/widgets/call-to-action-banner.php' );
		require_once( __DIR__ . '/widgets/call-to-action-video.php' );
		require_once( __DIR__ . '/widgets/timeline.php' );
		
		require_once( __DIR__ . '/widgets/CPT/wp-elementor-events.php' );
		require_once( __DIR__ . '/widgets/CPT/wp-elementor-events-cta.php' );
	
		require_once( __DIR__ . '/widgets/CPT/wp-elementor-woo.php' );
		require_once( __DIR__ . '/widgets/CPT/wp-elementor-posts.php' );
		// require_once( __DIR__ . '/widgets/call-to-action-small-box.php' );
		require_once( __DIR__ . '/widgets/gallery.php' );
		
		
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
		
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Main_Slider() );
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action() );
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Text() );
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Image() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Project_Facts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Timeline_Forest() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Fancy_Heading() );
		// \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Woo_Listing() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Video() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Events_Listing() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Events_Call_To_Action() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog_Listing() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Main_Gallery() );
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
Plugin::instance();
