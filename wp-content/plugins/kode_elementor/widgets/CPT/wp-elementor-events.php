<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Event Listing
 *
 * Elementor widget for Event Listing.
 *
 * @since 1.0.0
 */
class Events_Listing extends Widget_Base {

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
		return 'events-list';
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
		return __( 'CPT Events', 'elementor-call-to-action' );
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
			'events_list_settings',
			[
				'label' => __( 'Event Listing', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'filter_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Events', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'title-num-excerpt',
			[
				'label' => esc_html__( 'Title Excerpt(Character)', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '20', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'listing',
			[
				'label' => esc_html__( 'Listing', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'simple', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'simple' => __('Simple', 'tour-management'),
					'slider' => __('Slider', 'tour-management'),				
		     	],
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
			'event-style',
			[
				'label' => esc_html__( 'Style', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'event-grid-view', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'event-grid-modern' => esc_html__('Match Grid Modern', 'kickoff'),
					'event-grid-simple' => esc_html__('Match Table View', 'kickoff'),
					'event-full-view' => esc_html__('Match Full View', 'kickoff'),
					'event-grid-rugby' => esc_html__('New Rugby', 'kickoff')
		     	],
			]
		);
		
		$this->add_control(
			'scope',
			[
				'label' => esc_html__( 'Event Scope', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'all', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'past' => esc_html__('Past Events', 'council'), 
					'future' => esc_html__('Upcoming Events', 'council'), 
					'all' => esc_html__('All Events', 'council'), 
		     	],
			]
		);
		
		$this->add_control(
			'thumbnail_size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' => wpha_get_thumbnail_list(),
			]
		);
		
		$this->add_control(
			'column_size',
			[
				'label' => esc_html__( 'Column Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( '2', 'essential-addons-elementor' ),
		     	'options' 		=> [				
					'1' => __('1 Column', 'service-management'),
					'2' => __('2 Columns', 'service-management'),
					'3' => __('3 Columns', 'service-management'),
					'4' => __('4 Columns', 'service-management'),
					'6' => __('6 Columns', 'service-management')
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
			'num_excerpt',
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
		
		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'essential-addons-elementor' ),
				'label_off' => __( 'no', 'essential-addons-elementor' ),
				'return_value' => 'enable',
			]
		);
		
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'events_list_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'events_list_sub_title_color',
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
			'events_list_title_color',
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
			'events_list_image_background',
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
			'events_list_bg_color',
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
		<div class="events-item-wrapper events-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php 
			if(class_exists('EM_Events')){
				echo kode_get_events_item($settings);
			}
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
