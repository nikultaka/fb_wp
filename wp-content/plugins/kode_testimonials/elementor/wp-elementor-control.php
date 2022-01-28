<?php
namespace ElementorCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Testimonial Widget
 *
 * Elementor widget for Testimonial.
 *
 * @since 1.0.0
 */
class Testimonail_Listing extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'testimonial-list';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'CPT Testimonials', 'elementor-call-to-action' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-testimonial';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'kodeforest' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		
		return [ 'core-style', 'wpicon-moon', 'bx-main-slider' ];
		
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		
		$this->start_controls_section(
			'testimonials_list_settings',
			[
				'label' => __( 'Testimonials Settings', 'elementor-call-to-action' ),
			]
		);
		
		$this->add_control(
			'category',
			[
				'label' => esc_html__( 'Category', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' => wpha_get_term_list('testimonial_category'),
			]
		);
		
		$this->add_control(
			'testimonial-style',
			[
				'label' => esc_html__( 'Style', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'style-2', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'simple-view' => __('Simple View', 'kode_testimonial'),
					'normal-view' => __('Normal View', 'kode_testimonial'),
					'modern-view' => __('Modern View', 'kode_testimonial')
		     	],
			]
		);
		
		$this->add_control(
			'num-fetch',
			[
				'label' => esc_html__( 'Num Fetch', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '5', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'num-excerpt',
			[
				'label' => esc_html__( 'Num Excerpt ( Character )', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '50', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'date' => __('Publish Date', 'service-management'), 
					'title' => __('Title', 'service-management'), 
					'rand' => __('Random', 'service-management'), 
		     	],
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'desc'=>__('Descending Order', 'service-management'), 
					'asc'=> __('Ascending Order', 'service-management'), 
		     	],
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'testimonials_list_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'testimonials_list_sub_title_color',
			[
				'label' => esc_html__( 'Caption & Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .countup-no.overlay-b .countup-content span' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'testimonials_list_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .countup-no.overlay-b .countup-content .count-up' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'testimonials_list_image_background',
			[
				'label' => esc_html__( 'Background Image', 'essential-addons-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [
					'url' => KODEFOREST_MAIN_URL . 'assets/call-to-action/short-code-img01.jpg',
				],
			]
		);
		
		$this->add_control(
			'testimonials_list_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1e73be',
				'selectors' => [
					'{{WRAPPER}} .countup-no.overlay-b:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		
		$this->end_controls_section();
		
		
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {		
		
		$settings = $this->get_settings();
		?>
		<div class="testimonials-item-wrapper testimonials-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php 
			
			echo kode_get_testimonial_item($settings);
			
			?>
		</div>
		<?php 
		
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {}
	
}
