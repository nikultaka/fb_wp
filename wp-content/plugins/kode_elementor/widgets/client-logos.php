<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Main Clients
 *
 * Elementor widget for main clients.
 *
 * @since 1.0.0
 */
class Main_Clients extends Widget_Base {

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
		return 'main-clients';
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
		return __( 'Client Logos', 'elementor-main-clients' );
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
		return 'eicon-slider-album';
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
		
		return [ 'owl-slider-js', 'owl-slider-css','core-functions' , 'core-style' ];	
		
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
			'main_clients_settings',
			[
				'label' => __( 'Clients Settings', 'elementor-main-clients' ),
			]
		);
		
		$this->add_control(
		  'clients-columns',
		  	[
		   	'label'       	=> esc_html__( 'Column', 'essential-addons-elementor' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> '2',
		     	'options' 		=> [				
					'1' => esc_html__('1 Column', 'baldiyaat'),
					'2' => esc_html__('2 Column', 'baldiyaat'),
					'3' => esc_html__('3 Column', 'baldiyaat'),
					'4' => esc_html__('4 Column', 'baldiyaat'),
					'6' => esc_html__('6 Column', 'baldiyaat')
		     	],
		  	]
		);
		
		$this->add_control(
			'thumbnail-size',
			[
				'label' => esc_html__( 'Thumbnail Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' 	=> false,
				'default' => esc_html__( 'hide', 'essential-addons-elementor' ),
		     	'options' => wpha_get_thumbnail_list(),
			]
		);
		
		$this->add_control(
			'num-fetch',
			[
				'label' => esc_html__( 'Num Fetch', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => 10,
			]
		);
		
		$this->end_controls_section();
		
		/**
		 * Clients Text Settings
		 */
		$this->start_controls_section(
			'main_clients_config_settings',
			[
				'label' => esc_html__( 'Clients Images', 'essential-addons-elementor' ),
			]
		);

		$this->add_control(
			'slider',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
					[ 'main_clients_settings_slide' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png' ],
				],
				'fields' => [
					[
						'name' => 'main_clients_settings_slide',
						'label' => esc_html__( 'Image', 'essential-addons-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => KODEFOREST_MAIN_URL . 'assets/clients/simple-clients.png',
						],
					],
					[
						'name' => 'main_clients_settings_slide_title',
						'label' => esc_html__( 'Image Title', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( '', 'essential-addons-elementor' )
					],
					[
						'name' => 'main_clients_settings_slide_caption',
						'label' => esc_html__( 'Image Caption', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( '', 'essential-addons-elementor' )
					],
					[
						'name' => 'main_clients_settings_enable_slide_link',
						'label' => __( 'Enable Image Link', 'essential-addons-elementor' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'false',
						'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
						'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
						'return_value' => 'true',
						
				  	],
				  	[
						'name' => 'main_clients_settings_slide_link',
						'label' => esc_html__( 'Image Link', 'essential-addons-elementor' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'default' => [
		        			'url' => '#',
		        			'is_external' => '',
		     			],
		     			'show_external' => true,
		     			'condition' => [
		     				'main_clients_settings_enable_slide_link' => 'true'
		     			]
					]
				],
				'title_field' => '{{main_clients_settings_slide_title}}',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Clients Text Settings
		 */
		$this->start_controls_section(
			'main_clients_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'main_clients_sub_title_color',
			[
				'label' => esc_html__( 'Image Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .slide-item .slide-caption .kode-sub-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_clients_title_color',
			[
				'label' => esc_html__( 'Image Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .slide-item .slide-caption .slide-caption-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_clients_caption_color',
			[
				'label' => esc_html__( 'Image Caption Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .slide-item .slide-caption .slide-caption-des' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_clients_button_color',
			[
				'label' => esc_html__( 'Image Button Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .slide-item .slide-caption .banner_text_btn .bg-color' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_clients_button_bg_color',
			[
				'label' => esc_html__( 'Image Button BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .slide-item .slide-caption .banner_text_btn .bg-color' => 'background-color: {{VALUE}};',
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
		$current_size = 0;
		$settings['num-fetch'] = empty($settings['num-fetch'])? 9999: intval($settings['num-fetch']);
		$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
		$num_page = ceil(sizeof($settings['slider']) / $settings['num-fetch']);
		?>
		<div class="main-clients-wrapper kode-clients kode-gutter-clients bottom-spacer kode-style-gal-<?php echo esc_attr($settings['style']);?> main-clients-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php 
			
			if($settings['style'] == 'style-1'){
				
				echo '<ul class="wpha-item-holder">';	
				$current_size = 0;
				foreach($settings['slider'] as $slide_id => $slides){
					if( ($current_size >= ($paged - 1) * $settings['num-fetch']) &&
						($current_size < ($paged) * $settings['num-fetch']) ){

						if( !empty($current_size) && ($current_size % $settings['clients-columns'] == 0) ){
							echo '<li class="clear clearfix"></li>';
						}
						
						$image_id = $slides['main_clients_settings_slide']['id'];
						$image_src = wp_get_attachment_image_src($image_id, $settings['thumbnail-size']);	
						if(!empty($image_src)){
							echo '
							<li class="clients-item columns ' . wpha_get_column_class_updated('1/' . $settings['clients-columns']) . '">
								<figure class="kode-ux">
									<img src="'.esc_url($image_src[0]).'" alt="clients title">
									<figcaption><a rel="prettyphoto[clients]" data-gal="prettyphoto[clients-'.$current_size.']" class="kode-clients-hover thbg-color" href="'.esc_url($image_src[0]).'"><i class="fa fa-plus"></i></a></figcaption>
								</figure>
							</li>'; // clients column				
						}else{
							echo '
							<li class="clients-item columns ' . wpha_get_column_class_updated('1/' . $settings['clients-columns']) . '">
								<figure class="kode-ux">
									<img src="'.esc_url($slides['main_clients_settings_slide']['url']).'" alt="clients title">
									<figcaption><a rel="prettyphoto[clients]" data-gal="prettyphoto[clients-'.$current_size.']" class="kode-clients-hover thbg-color" href="'.esc_url($slides['main_clients_settings_slide']['url']).'"><i class="fa fa-plus"></i></a></figcaption>
								</figure>
							</li>'; // clients column				
						}			
					}
					$current_size ++;
				}
				echo '<li class="clearfix clear"></li>';
				echo '</ul>'; // kode-clients-item
			}else{
				
				echo '<ul class="wpha-item-holder">';	
				$current_size = 0;
				foreach($settings['slider'] as $slide_id => $slides){
					if( ($current_size >= ($paged - 1) * $settings['num-fetch']) &&
						($current_size < ($paged) * $settings['num-fetch']) ){

						if( !empty($current_size) && ($current_size % $settings['clients-columns'] == 0) ){
							echo '<li class="clear clearfix"></li>';
						}
						$image_id = $slides['main_clients_settings_slide']['id'];
						$image_src = wp_get_attachment_image_src($image_id, $settings['thumbnail-size']);	
						if(!empty($image_src)){
							echo '
							<li class="clients-item columns ' . wpha_get_column_class_updated('1/' . $settings['clients-columns']) . '">
								<figure class="kode-ux">
									<img src="'.esc_url($image_src[0]).'" alt="clients title">
									<figcaption><a rel="prettyphoto[clients]" data-gal="prettyphoto[clients-'.$current_size.']" class="kode-clients-hover thbg-color" href="'.esc_url($image_src[0]).'"><i class="fa fa-plus"></i></a></figcaption>
								</figure>
							</li>'; // clients column				
						}else{
							echo '
							<li class="clients-item columns ' . wpha_get_column_class_updated('1/' . $settings['clients-columns']) . '">
								<figure class="kode-ux">
									<img src="'.esc_url($slides['main_clients_settings_slide']['url']).'" alt="clients title">
									<figcaption><a rel="prettyphoto[clients]" data-gal="prettyphoto[clients-'.$current_size.']" class="kode-clients-hover thbg-color" href="'.esc_url($slides['main_clients_settings_slide']['url']).'"><i class="fa fa-plus"></i></a></figcaption>
								</figure>
							</li>'; // clients column				
						}
					}
					$current_size ++;
				}
				
				echo '<li class="clearfix clear"></li>';
				echo '</ul>'; // kode-clients-item
			}
			if( $settings['pagination'] == true ){
				$ret .= kode_get_pagination($num_page, $paged);
			}
			
		echo '</div>'; // kode-clients-item
		
		
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
