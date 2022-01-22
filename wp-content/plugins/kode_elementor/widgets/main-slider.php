<?php
namespace ElementorDefaultCPT\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Main Slider
 *
 * Elementor widget for main slider.
 *
 * @since 1.0.0
 */
class Main_Slider extends Widget_Base {

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
		return 'main-slider';
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
		return __( 'KodeForest Slider', 'elementor-main-slider' );
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
		
			return [ 'slick-slider-js', 'slick-slider-css','slick-slider-theme', 'core-functions' , 'core-style' ];	
	
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
			'main_slider_settings',
			[
				'label' => __( 'Slider Configuration', 'elementor-main-slider' ),
			]
		);

		
		$this->add_control(
		  'main_slider_settings_type',
		  	[
		   	'label'       	=> esc_html__( 'Slider Type', 'essential-addons-elementor' ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'default' 		=> 'bxslider',
		     	'label_block' 	=> false,
		     	'options' 		=> [				
					'flexslider' => esc_html__('Flex slider', 'council'),
					'bxslider' => esc_html__('BX Slider', 'council'),
					'slickslider' => esc_html__('Slick Slider', 'council'),
					'carousel' => esc_html__('Carousel Slider', 'council'),
					'nivoslider' => esc_html__('Nivo Slider', 'council')
		     	],
		  	]
		);

		$this->add_control(
			'main_slider_settings_fade_in',
			[
				'label' => esc_html__( 'Fade In (ms)', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => 400,
			]
		);

		$this->add_control(
		  'main_slider_settings_loop',
		  	[
				'label' => __( 'Loop', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'false',
				'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
				'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
				'return_value' => 'true',
		  	]
		);

		$this->add_control(
		  'main_slider_settings_autoplay',
		  	[
				'label' => __( 'Autoplay', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'false',
				'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
				'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
				'return_value' => 'true',
		  	]
		);

		/**
		 * Condition: 'main_slider_settings_autoplay' => 'true'
		 */
		$this->add_control(
			'main_slider_settings_autoplay_time',
			[
				'label' => esc_html__( 'Autoplay Timeout (ms)', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'default' => 2000,
				'condition' => [
					'main_slider_settings_autoplay' => 'true'
				]
			]
		);
		
		$this->add_control(
		  'main_slider_settings_button',
		  	[
				'label' => __( 'Bullets or Navigator', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
				'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
				'return_value' => 'true',
		  	]
		);

		$this->add_control(
			'main_slider_settings_spacing',
			[
				'label' => esc_html__( 'Slide Margin', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => -0.6
				],
				'range' => [
					'px' => [
						'min' => -1,
						'max' => 1,
						'step' => 0.1
					],
				],
			]
		);
		
		$this->end_controls_section();

		/**
		 * Filp Carousel Slides
		 */
		$this->start_controls_section(
			'main_slider_setting_slides',
			[
				'label' => esc_html__( 'Manage Slides', 'essential-addons-elementor' ),
			]
		);
		

		$this->add_control(
			'main_slider_settings_slides',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'main_slider_settings_slide' => KODEFOREST_MAIN_URL . 'assets/banner/01.jpg' ],
					[ 'main_slider_settings_slide' => KODEFOREST_MAIN_URL . 'assets/banner/02.jpg' ]
				],
				'fields' => [
					[
						'name' => 'main_slider_settings_slide',
						'label' => esc_html__( 'Slide', 'essential-addons-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => KODEFOREST_MAIN_URL . 'assets/banner/01.jpg',
						],
					],
					[
						'name' => 'main_slider_settings_caption_direction',
						'label' => esc_html__( 'Caption Direction', 'essential-addons-elementor' ),
						'type' => Controls_Manager::SELECT,
						'options' 		=> [				
							'left' => esc_html__('Left', 'council'),
							'center' => esc_html__('Center', 'council'),
							'right' => esc_html__('Right', 'council')
						],
						'default' => esc_html__( 'left', 'essential-addons-elementor' )
					],
					[
						'name' => 'main_slider_settings_slide_title',
						'label' => esc_html__( 'Slide Title', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'Kickoff Sports Theme', 'essential-addons-elementor' )
					],
					[
						'name' => 'main_slider_settings_slide_caption',
						'label' => esc_html__( 'Slide Caption', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'Sed ut perspiciatis unde omnis iste natuserror sit accusantium dolore.', 'essential-addons-elementor' )
					],
					[
						'name' => 'main_slider_settings_slide_text',
						'label' => esc_html__( 'Button Text', 'essential-addons-elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'Buy Now ', 'essential-addons-elementor' )
					],
					
					[
						'name' => 'main_slider_settings_enable_slide_link',
						'label' => __( 'Enable Slide Link', 'essential-addons-elementor' ),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'false',
						'label_on' => esc_html__( 'Yes', 'essential-addons-elementor' ),
						'label_off' => esc_html__( 'No', 'essential-addons-elementor' ),
						'return_value' => 'true',
						
				  	],
				  	[
						'name' => 'main_slider_settings_slide_link',
						'label' => esc_html__( 'Slide Link', 'essential-addons-elementor' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'default' => [
		        			'url' => '#',
		        			'is_external' => '',
		     			],
		     			'show_external' => true,
		     			'condition' => [
		     				'main_slider_settings_enable_slide_link' => 'true'
		     			]
					]
				],
				'title_field' => '{{main_slider_settings_slide_title}}',
			]
		);

		$this->end_controls_section();
		
		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'main_slider_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'main_slider_title_color',
			[
				'label' => esc_html__( 'Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .slide-caption-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_slider_title_bg_color',
			[
				'label' => esc_html__( 'Title BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .slide-caption-title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .slide-caption-title:after, {{WRAPPER}} .kode-caption-wrapper .slide-caption .slide-caption-title:before' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_slider_sub_title_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .kode-sub-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_slider_btn_title_color',
			[
				'label' => esc_html__( 'Button Title Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .banner_text_btn .slide-btn' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_slider_btn_bg_color',
			[
				'label' => esc_html__( 'Button BG Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .banner_text_btn' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'main_slider_btn_border_color',
			[
				'label' => esc_html__( 'Button Border Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f4f4',
				'selectors' => [
					'{{WRAPPER}} .kode-caption-wrapper .slide-caption .banner_text_btn' => 'border-color: {{VALUE}};',
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

		// Loop Value
		if( 'true' == $settings['main_slider_settings_loop'] ) : $eael_loop = 'true'; else: $eael_loop = 'false'; endif;
		// Autoplay Value
		if( 'true' == $settings['main_slider_settings_autoplay'] ) : $eael_autoplay = $settings['main_slider_settings_autoplay_time']; else: $eael_autoplay = 'false'; endif;
		
		$wrapper = 'div';
		$wrapper_child = 'div';
		if($settings['main_slider_settings_type'] == 'slickslider'){
			$wrapper = 'div';
			$wrapper_child = 'div';
		}else{
			$wrapper = 'ul';
			$wrapper_child = 'li';
		}
		?>
		<div class="main-slider-wrapper main-slider-<?php echo esc_attr( $this->get_id() ); ?>">
			<<?php echo esc_attr($wrapper)?> class="<?php echo esc_attr( $settings['main_slider_settings_type'] ); ?>" 
			data-mode="<?php echo esc_attr( (int) $settings['main_slider_settings_fade_in'] ); ?>" 
			data-loop="<?php echo $eael_loop; ?>" 
			data-autoplay="<?php echo $eael_autoplay; ?>" 
			>
				<?php 
				foreach( $settings['main_slider_settings_slides'] as $slides ) {
					echo '<'.esc_attr($wrapper_child).'>';
					
					if( '' <> $slides['main_slider_settings_slide_title'] ) {
						
						$url = $slides['main_slider_settings_slide_link']['url'];
						$target = $slides['main_slider_settings_slide_link']['is_external'] ? 'target="_blank"' : '';
						$nofollow = $slides['main_slider_settings_slide_link']['nofollow'] ? 'rel="nofollow"' : '';
							if(!empty($slides['main_gallery_settings_slide']['id'])){
								$image_src = wp_get_attachment_image_src($slides['main_gallery_settings_slide']['id'], $settings['thumbnail-size']);	
								echo '
								<figure class="slide-item">
									<img src="'.esc_url($image_src[0]).'" alt="'.esc_attr($slides['main_slider_settings_slide_title']).'" />
									<div class="kode-caption-wrapper position-'.esc_attr($slides['main_slider_settings_caption_direction']).'">
										<div class="slide-caption kode-caption banner_fig_caption">
											<h2 class="slide-caption-title kode-caption-title kode-caption-title">
												'.esc_attr($slides['main_slider_settings_slide_title']).'
											</h2>
											<h5 class="kode-sub-title medium_text kode-caption-text">
												'.esc_attr($slides['main_slider_settings_slide_caption']).'
											</h5>
											<div class="banner_text_btn kode-linksection">
												<a href="'.esc_url($url).'" class="btn-normal bg-color slide-btn" '.$target.' '.$nofollow.'>
													'.esc_attr($slides['main_slider_settings_slide_text']).'
												</a>
											</div>
										</div>
									</div>
								</figure>';
							}else{
								echo '
								<figure class="slide-item">
									<img src="'.esc_url($slides['main_slider_settings_slide']['url']).'" alt="'.esc_attr($slides['main_slider_settings_slide_title']).'" />
									<div class="kode-caption-wrapper position-'.esc_attr($slides['main_slider_settings_caption_direction']).'">
										<div class="slide-caption kode-caption banner_fig_caption">
											<h2 class="slide-caption-title kode-caption-title kode-caption-title">
												'.esc_attr($slides['main_slider_settings_slide_title']).'
											</h2>
											<h5 class="kode-sub-title medium_text kode-caption-text">
												'.esc_attr($slides['main_slider_settings_slide_caption']).'
											</h5>
											<div class="banner_text_btn kode-linksection">
												<a href="'.esc_url($url).'" class="btn-normal bg-color slide-btn" '.$target.' '.$nofollow.'>
													'.esc_attr($slides['main_slider_settings_slide_text']).'
												</a>
											</div>
										</div>
									</div>
								</figure>';
							}
						
					}else{
						echo '<figure><img src="'.esc_url($slides['main_slider_settings_slide']['url']).'" alt=""></figure>';
					}
					echo '</'.esc_attr($wrapper_child).'>';
				}
				?>
			</<?php echo esc_attr($wrapper)?>>
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
