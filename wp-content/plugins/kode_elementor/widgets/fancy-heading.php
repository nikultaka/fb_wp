<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Fancy Heading
 *
 * Elementor widget for fancy heading.
 *
 * @since 1.0.0
 */
class Fancy_Heading extends Widget_Base {

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
		return 'fancy-heading';
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
		return __( 'Fancy Heading', 'elementor-call-to-action' );
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
		return 'eicon-heading';
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
		
		return [ 'core-style', 'wpicon-moon' ];	
		
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
			'fancy_heading_settings',
			[
				'label' => __( 'Fancy Heading', 'elementor-call-to-action' ),
			]
		);
		
		
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Fancy Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'see what were doing', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Fancy Caption', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'see what were doing', 'essential-addons-elementor' )
			]
		);
		
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'fancy_heading_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
		  'element-style',
		  	[
		   	'label'       	=> esc_html__( 'Fancy Type', 'essential-addons-elementor' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'style-1',
		     	'label_block' 	=> false,
		     	'options' 		=> [				
					'style-1' => esc_html__('Style 1', 'council'),
					'style-2' => esc_html__('Style 2', 'council'),
					'style-3' => esc_html__('Style 3', 'council')
		     	],
		  	]
		);
		
		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'essential-addons-elementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .heading-style-4.heading,{{WRAPPER}} .fancy-heading-style-1' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'fancy_heading_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#063869',
				'selectors' => [
					'{{WRAPPER}} .kode-simple-heading .heading h2' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'fancy_heading_sub_title_color',
			[
				'label' => esc_html__( 'Caption', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666666',
				'selectors' => [
					'{{WRAPPER}} .kode-simple-heading .heading p' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'fancy_heading_border_dots_color',
			[
				'label' => esc_html__( 'Border Dots Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff0008',
				'selectors' => [
					'{{WRAPPER}} .fancy-heading-wrapper .kode-simple-heading .heading h2 span' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'fancy_heading_border_line_color',
			[
				'label' => esc_html__( 'Border Line Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff0008',
				'selectors' => [
					'{{WRAPPER}} .kode-simple-heading .heading h2:before' => 'border-bottom-color: {{VALUE}};',
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
		<div class="fancy-heading-wrapper fancy-heading-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php echo kode_get_headings_item($settings);?>
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
