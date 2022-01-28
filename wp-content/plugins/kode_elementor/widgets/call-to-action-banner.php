<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Call To Action Banner
 *
 * Elementor widget for call to action banner.
 *
 * @since 1.0.0
 */
class Call_To_Action_Banner extends Widget_Base {

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
		return 'call-to-action-banner';
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
		return __( 'CTA Banner', 'elementor-call-to-action' );
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
			'call_to_action_banner_settings',
			[
				'label' => __( 'Call To Action Banner', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'call_to_action_banner_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Let Us Help to Make a Perfect Nation', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_banner_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Join Our Party', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_banner_btn_link',
			[
				'label' => esc_html__( 'Button Link', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '#', 'essential-addons-elementor' )
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'call_to_action_banner_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'call_to_action_banner_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .join-velue h3' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_banner_btn_color',
			[
				'label' => esc_html__( 'Button Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .join-velue .pull-right .btn-small' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_banner_btn_bg_color',
			[
				'label' => esc_html__( 'Button BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .join-velue .pull-right .btn-small' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_banner_border',
			[
				'label' => esc_html__( 'Border Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5
					],
				]
			]
		);
		
		$this->add_control(
			'call_to_action_banner_btn_border_color',
			[
				'label' => esc_html__( 'Button Border Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .join-velue .pull-right .btn-small' => 'border-color: {{VALUE}};',
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
		<div class="call-to-action-banner-wrapper call-to-action-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="join-velue">					
				<h3><?php echo esc_html($settings['call_to_action_banner_title'])?></h3>
				<div class="pull-right">
					<a href="<?php echo esc_url($settings['call_to_action_banner_btn_link'])?>" class="btn-small borderd white-b btn-e eft-clr-2"><span></span><?php echo esc_html($settings['call_to_action_banner_btn_text'])?></a>
				</div>
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
