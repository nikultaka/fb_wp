<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Call To Action Video
 *
 * Elementor widget for call to action video.
 *
 * @since 1.0.0
 */
class Call_To_Action_Video extends Widget_Base {

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
		return 'call-to-action-video';
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
		return __( 'CTA Video', 'elementor-call-to-action' );
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
		return 'eicon-slider-video';
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
			'call_to_action_video_settings',
			[
				'label' => __( 'Call To Action Video', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'call_to_action_video_sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Trainer : Roy Stone', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_video_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Running Tutorial Session', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_video_caption',
			[
				'label' => esc_html__( 'Caption', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Source: Youtube, Vimeo', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'call_to_action_video_btn_link',
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
			'call_to_action_video_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'call_to_action_video_title_color',
			[
				'label' => esc_html__( 'Text Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .video-blog .heading-02 h2,{{WRAPPER}} .video-blog .heading-02 small,{{WRAPPER}} .video-blog .heading-02 h3' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'call_to_action_video_btn_color',
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
			'call_to_action_video_btn_bg_color',
			[
				'label' => esc_html__( 'Button BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .join-velue .pull-right .btn-small' => 'background-color: {{VALUE}};',
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
		<div class="call-to-action-video-wrapper call-to-action-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="kode-video-call-to-action-video">
				<h2><?php echo esc_html($settings['call_to_action_video_title'])?></h2>
				<p><a href="<?php echo esc_url($settings['call_to_action_video_btn_link'])?>" data-rel="prettyphoto[]"><i class="fa fa-play"></i></a></p>
				<h4><?php echo esc_html($settings['call_to_action_video_sub_title'])?></h4>
				<p><?php echo esc_html($settings['call_to_action_video_caption'])?></p>
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
