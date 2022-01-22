<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Call To Action Text
 *
 * Elementor widget for call to action text.
 *
 * @since 1.0.0
 */
class Call_To_Action_Text extends Widget_Base {

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
		return 'call-to-action-text';
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
		return __( 'CTA Text', 'elementor-call-to-action' );
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
				'label' => __( 'Call To Action Text', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'call_to_action_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Trust political party', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Difference We Can To Make A Change', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_content',
			[
				'label' => esc_html__( 'Content', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default' => esc_html__( '“Volunteers are the heart of a community. Our volunteers are a valuable resource” Our city relies on our volunteers for everything from staffing special event.', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_sub_text',
			[
				'label' => esc_html__( 'Call Back Text', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Call for the Meeting', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_phone',
			[
				'label' => esc_html__( 'Phone Number', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '0800 55 70 900', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_button_text',
			[
				'label' => esc_html__( 'Button Text', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Contact Us', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_button_url',
			[
				'label' => esc_html__( 'Button URL', 'essential-addons-elementor' ),
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
			'call_to_action_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'call_to_action_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#063869',
				'selectors' => [
					'{{WRAPPER}} .post-log h2.title-l' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_sub_title_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .post-log i' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_content_color',
			[
				'label' => esc_html__( 'Content Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .post-log p' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_cb_text_color',
			[
				'label' => esc_html__( 'Call Back Text Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .post-log .poster-contacts span' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_phone_color',
			[
				'label' => esc_html__( 'Ph Text Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .post-log .poster-contacts h4' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_button_text_color',
			[
				'label' => esc_html__( 'Button Text Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#dd0f0f',
				'selectors' => [
					'{{WRAPPER}} .post-log .poster-contacts .borderd' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_button_border_color',
			[
				'label' => esc_html__( 'Button Border Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#dd0f0f',
				'selectors' => [
					'{{WRAPPER}} .post-log .poster-contacts .borderd' => 'border-color: {{VALUE}};',
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
			<div class="post-log">
				<h2 class="title-l"><?php echo esc_html($settings['call_to_action_title'])?></h2>
				<div class="clearfix clear"></div>
				<i><?php echo esc_html($settings['call_to_action_sub_title'])?></i><?php echo council_content_filter($settings['call_to_action_content'])?>
				<div class="sprate-border margin-45"></div>
				<div class="poster-contacts">
					<div class="pull-left">
						<span><?php echo esc_html($settings['call_to_action_sub_text'])?></span>
						<h4><?php echo esc_html($settings['call_to_action_phone'])?></h4>
					</div>
					<div class="pull-right">
						<a href="<?php echo esc_url($settings['call_to_action_button_url'])?>" class="btn-normal borderd rd1 btn-e eft-clr-2"><span></span><?php echo esc_html($settings['call_to_action_button_text'])?></a>
					</div>
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
