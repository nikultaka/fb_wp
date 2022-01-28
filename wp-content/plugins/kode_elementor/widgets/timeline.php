<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Project Facts
 *
 * Elementor widget for project facts.
 *
 * @since 1.0.0
 */
class Timeline_Forest extends Widget_Base {

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
		return 'timeline';
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
		return __( 'Timeline', 'elementor-call-to-action' );
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
		return 'eicon-alert';
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
			'timeline_forest_settings',
			[
				'label' => __( 'Timeline', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'timeline',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'timeline_title' => 'INTERNATIONAL CUP' ],
					[ 'timeline_title' => 'FEDERATION CUP' ],
					[ 'timeline_title' => 'INTERNATIONAL CUP' ],
					[ 'timeline_title' => 'FEDERATION CUP' ],
					[ 'timeline_title' => 'INTERNATIONAL CUP' ],
					[ 'timeline_title' => 'FEDERATION CUP' ],
					[ 'timeline_title' => 'INTERNATIONAL CUP' ],
					[ 'timeline_title' => 'FEDERATION CUP' ],
				],
				'fields' => [
					[
						'name' => 'timeline_title',
						'label' => esc_html__( 'Timeline Title', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'INTERNATIONAL CUP', 'essential-addons-elementor' )
					],
					[
						'name' => 'timeline_caption',
						'label' => esc_html__( 'Timeline Caption', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'Voluptate illum dolore ita ipsum, quid deserunt singulis, labore admodum ita multos malis ea nam nam tamen fore amet. Vidisse quid incurreret ut ut possumus transferrem', 'essential-addons-elementor' )
					],
					[
						'name' => 'timeline_year',
						'label' => esc_html__( 'Timeline Year', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( '2013', 'essential-addons-elementor' )
					]
				],
				'title_field' => '{{timeline_title}}',
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'timeline_forest_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'timeline_forest_sub_title_color',
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
			'timeline_forest_title_color',
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
			'timeline_forest_image_background',
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
			'timeline_forest_bg_color',
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
		$settings = $this->get_settings();?>
		<div class="timeline-wrapper timeline-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php 
				echo '
				<div class="kode-team-timeline">
					<span class="timeline-circle"></span>
					<ul>';
						foreach($settings['timeline'] as $slide_id => $slides){
						
							echo '
							<li>
								<span class="kode-timezoon">'.esc_html($slides['timeline_year']).'</span>
								<div class="timeline-inner">
								  <h2>'.esc_html($slides['timeline_title']).'</h2>
								  <p>'.esc_html($slides['timeline_caption']).'</p>
								</div>
							</li>';
						}
					echo '
					</ul>
					<span class="timeline-circle bottom-circle"></span>
				</div>';
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
