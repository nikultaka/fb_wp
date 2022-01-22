<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Call To Action Image
 *
 * Elementor widget for call to action image.
 *
 * @since 1.0.0
 */
class Call_To_Action_Image extends Widget_Base {

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
		return 'call-to-action-image';
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
		return __( 'CTA Image', 'elementor-call-to-action' );
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
		return 'eicon-call-to-action';
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
			'call_to_action_settings',
			[
				'label' => __( 'Call to Action Image', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'call_to_action_image_top',
			[
				'label' => esc_html__( 'Foreground Image', 'essential-addons-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [
					'url' => KODEFOREST_MAIN_URL . 'assets/call-to-action/slide-img-01.jpg',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_image_background',
			[
				'label' => esc_html__( 'Background Image', 'essential-addons-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [
					'url' => KODEFOREST_MAIN_URL . 'assets/call-to-action/slide-img-02.jpg',
				],
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'call_to_action_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'call_to_action_border_color',
			[
				'label' => esc_html__( 'Border Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d5092c',
				'selectors' => [
					'{{WRAPPER}} .fig-pictures .backend-img::before' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_border_size',
			[
				'label' => esc_html__( 'Border Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fig-pictures .backend-img::before' => 'border-size: {{VALUE}};',
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
		<div class="call-to-action-text-wrapper call-to-action-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="fig-pictures" style="background-image: url(<?php echo esc_url($settings['call_to_action_image_background']['url'])?>);">
				<figure>
					<div class="backend-img img-d">
						<img src="<?php echo esc_url($settings['call_to_action_image_top']['url'])?>" alt="<?php echo esc_attr__('Large Image','council')?>">
					</div>
				</figure>
			</div>
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
