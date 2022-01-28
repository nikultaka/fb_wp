<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Event Call to Action
 *
 * Elementor widget for event call to action.
 *
 * @since 1.0.0
 */
class Events_Call_To_Action extends Widget_Base {

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
		return 'events-cta';
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
		return __( 'Fixtures', 'elementor-call-to-action' );
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
		return 'eicon-post';
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
		
		return [ 'core-style', 'wpicon-moon', 'custom_downcount' , 'custom_countdown' ];	
		
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
			'events_upcoming_settings',
			[
				'label' => __( 'Fixtures', 'elementor-call-to-action' ),
			]
		);
		
		$this->add_control(
			'type',
			[
				'label' => esc_html__( 'Type', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'all', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'style-1' => esc_html__('Live Results', 'council'), 
					'style-2' => esc_html__('Fixutres', 'council'), 
					'style-3' => esc_html__('Upcoming Event', 'council'),
					'style-4' => esc_html__('Next Fixture', 'council'), 
					'style-5' => esc_html__('Next Match', 'council'), 
					'style-6' => esc_html__('Event List', 'council'), 
					'style-7' => esc_html__('Event Tab Widget', 'council'), 
		     	],
			]
		);
		
		$this->add_control(
			'header-title',
			[
				'label' => esc_html__( 'Header Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'type' => 'style-1',					
					'type' => 'style-6',
					'type' => 'style-2'
				],
				'default' => esc_html__( '', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'header_caption',
			[
				'label' => esc_html__( 'Header Caption', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'type' => 'style-4'					
				],
				'default' => esc_html__( '', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'fixture-limit',
			[
				'label' => esc_html__( 'Fixture Limit', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'type' => 'style-7'					
				],
				'default' => esc_html__( '', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'title_num_excerpt',
			[
				'label' => esc_html__( 'Title Num Length (Character)', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'type' => 'style-3',
					'type' => 'style-5'
				],
				'default' => esc_html__( '20', 'essential-addons-elementor' )
			]
		);

		$this->add_control(
			'category',
			[
				'label' => esc_html__( 'Category', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' => wpha_get_term_list('event-categories'),
			]
		);
		
		$this->add_control(
			'player-left-image',
			[
				'label' => esc_html__( 'Player Left Image', 'essential-addons-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' 	=> false,
				'condition' => [
					'type' => 'style-5'
				],
				'default' => [
					'url' => KODEFOREST_MAIN_URL . 'assets/banner/01.jpg',
				],
			]
		);	
		
		$this->add_control(
			'player-right-bg-image',
			[
				'label' => esc_html__( 'Player Right BG Image', 'essential-addons-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'label_block' 	=> false,
				'condition' => [
					'type' => 'style-4'
				],
				'default' => [
					'url' => KODEFOREST_MAIN_URL . 'assets/banner/01.jpg',
				],
			]
		);	
		
		$this->add_control(
			'player-right-bg-color',
			[
				'label' => esc_html__( 'Player Right BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'condition' => [
					'type' => 'style-4'
				],
				'selectors' => [
					'{{WRAPPER}} .event-content h3' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'scope',
			[
				'label' => esc_html__( 'Event Scope', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'condition' => [
					'type' => 'style-2'
				],
				'default' => esc_html__( 'all', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'past' => esc_html__('Past Events', 'council'), 
					'future' => esc_html__('Upcoming Events', 'council'), 
					'all' => esc_html__('All Events', 'council'), 
		     	],
			]
		);
		
		$this->add_control(
			'fixtures-show',
			[
				'label' => esc_html__( 'Show Fixtures', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'condition' => [
					'type' => 'style-1'
				],
				'default' => esc_html__( 'all', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'current'=>esc_html__('Current Fixtures', 'kickoff'), 
					'result'=> esc_html__('Fixture Results', 'kickoff'), 
					'future'=> esc_html__('Upcomming Fixtures', 'kickoff'), 
		     	],
			]
		);
		
		$this->add_control(
			'num_fetch',
			[
				'label' => esc_html__( 'Number Fetch ( Events )', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'type' => 'style-6',
					'type' => 'style-4',
					'type' => 'style-1'
				],
				'default' => esc_html__( '6', 'essential-addons-elementor' )
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'events_upcoming_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'events_upcoming_sub_title_color',
			[
				'label' => esc_html__( 'Caption & Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content small' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'events_upcoming_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content h3' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'events_upcoming_caption_color',
			[
				'label' => esc_html__( 'Caption Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content p' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_control(
			'events_upcoming_btn_color',
			[
				'label' => esc_html__( 'Button Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content .btn-normal.borderd' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'events_upcoming_btn_bg_color',
			[
				'label' => esc_html__( 'Button BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content .btn-normal.borderd' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'events_upcoming_btn_border_color',
			[
				'label' => esc_html__( 'Button Border Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .event-content .btn-normal.borderd' => 'border-color: {{VALUE}};',
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
		<div class="events-item-wrapper events-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php 
			
			if(isset($settings['type']) && $settings['type'] == 'style-1'){
				echo kode_get_live_result_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-2'){
				echo kode_get_fixture_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-3'){
				echo kode_get_upcoming_event_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-4'){
				$settings['player-right-bg-image'] = $settings['player-right-bg-image']['id'];
				echo kode_get_upcomming_match_fixture_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-5'){
				$settings['player-left-image'] = $settings['player-left-image']['id'];
				echo kode_get_next_match_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-6'){
				echo kode_get_normal_event_item($settings);
			}else if(isset($settings['type']) && $settings['type'] == 'style-7'){
				echo kode_fixture_tab_widget($settings);
			}
		
			?>
		</div>
		<?php 
	}
	
	function wpjb_get_image_id($image_url) {
		global $wpdb;
		if(isset($image_url)){
			$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
			if(!empty($attachment)){
				return $attachment[0]; 
			}			
		}
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
