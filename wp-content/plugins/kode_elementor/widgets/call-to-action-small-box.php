<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Call To Action Small Box
 *
 * Elementor widget for call to action small box.
 *
 * @since 1.0.0
 */
class Call_To_Action_Small_Box extends Widget_Base {

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
		return 'call-to-action-small-box';
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
		return __( 'CTA Small Box', 'elementor-call-to-action' );
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
			'call_to_action_small_box_settings',
			[
				'label' => __( 'CTA Small Box', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'call_to_action_small_box_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Trust political party', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Difference We Can To Make A Change', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_icon',
			[
				'label' => esc_html__( 'Add Icon', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'false',
				'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
				'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
				'return_value' => 'true'
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_select_icon',
			[
				'label' => esc_html__( 'Select Icon', 'essential-addons-elementor' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-bullhorn',
				'condition' => [
					'call_to_action_small_box_icon' => 'true'
				]
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_button_url',
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
			'call_to_action_small_box_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#063869',
				'selectors' => [
					'{{WRAPPER}} .helper, {{WRAPPER}} .helper:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .helper .heading-04 h3' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_sub_title_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .helper .heading-04 p' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_small_box_icon_color',
			[
				'label' => esc_html__( 'CTA Icon Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .small-box-icon' => 'color: {{VALUE}};',
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
		<div class="call-to-action-small-box-wrapper call-to-action-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="helper bg-01 <?php if($settings['call_to_action_small_box_icon']){echo 'helper-icon-selected';}?>">
				<div class="heading-04">
					<h3><?php echo esc_html($settings['call_to_action_small_box_title'])?></h3>
					<p><?php echo esc_html($settings['call_to_action_small_box_sub_title'])?></p>
				</div>
				<?php if($settings['call_to_action_small_box_icon']){ ?>
					<span class="small-box-icon">?</span>
				<?php }?>
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
