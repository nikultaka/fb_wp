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
class Project_Facts extends Widget_Base {

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
		return 'project-facts';
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
		return __( 'Project Facts', 'elementor-call-to-action' );
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
			'project_facts_settings',
			[
				'label' => __( 'Project Facts', 'elementor-call-to-action' ),
			]
		);

		$this->add_control(
			'project_facts_icon',
			[
				'label' => esc_html__( 'Icon', 'essential-addons-elementor' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-bullhorn',
			]
		);
		
		
		$this->add_control(
			'project_facts_title',
			[
				'label' => esc_html__( 'Title', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '3586', 'essential-addons-elementor' )
			]
		);
		
		$this->add_control(
			'project_facts_caption',
			[
				'label' => esc_html__( 'Caption', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'League Goals ', 'essential-addons-elementor' )
			]
		);
		
		$this->end_controls_section();

		/**
		 * Slider Text Settings
		 */
		$this->start_controls_section(
			'project_facts_color_settings',
			[
				'label' => esc_html__( 'Color & Design', 'essential-addons-elementor' ),
			]
		);
		
		$this->add_control(
			'project_facts_sub_title_color',
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
			'project_facts_title_color',
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
			'project_facts_image_background',
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
			'project_facts_bg_color',
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
		<div class="project-facts-wrapper project-facts-<?php echo esc_attr( $this->get_id() ); ?>">
			
			<script type="text/javascript">
			jQuery(document).ready(function($){
				/* ---------------------------------------------------------------------- */
				/*	Counter Functions
				/* ---------------------------------------------------------------------- */
				if($("#count-<?php echo esc_attr( $this->get_id() ); ?>").length){
					$("#count-<?php echo esc_attr( $this->get_id() ); ?>").counterUp({
						delay: 10,
						time: 1000
					});
				}
			});
			</script>
			<div class="kd-counter">
				<?php if(strpos($settings['project_facts_icon'],'fa-') === false){ ?>
				<span>
					<i class="wpicon wpicon_set_<?php echo esc_attr($settings['project_facts_icon'])?>">
						<small class="path1"></small><small class="path2"></small><small class="path3"></small><small class="path4"></small><small class="path5"></small><small class="path6"></small><small class="path7"></small><small class="path8"></small><small class="path9"></small><small class="path10"></small><small class="path11"></small><small class="path12"></small><small class="path13"></small><small class="path14"></small><small class="path15"></small><small class="path16"></small><small class="path17"></small><small class="path18"></small><small class="path19"></small><small class="path20"></small><small class="path21"></small><small class="path22"></small><small class="path23"></small><small class="path24"></small><small class="path25"></small><small class="path26"></small><small class="path27"></small><small class="path28"></small><small class="path29"></small><small class="path30"></small><small class="path31"></small><small class="path32"></small><small class="path33"></small><small class="path34"></small><small class="path35"></small><small class="path36"></small><small class="path37"></small><small class="path38"></small><small class="path39"></small><small class="path40"></small><small class="path41"></small><small class="path42"></small><small class="path43"></small><small class="path44"></small><small class="path45"></small><small class="path46"></small><small class="path47"></small><small class="path48"></small><small class="path49"></small><small class="path50"></small><small class="path51"></small><small class="path52"></small><small class="path53"></small><small class="path54"></small><small class="path55"></small><small class="path56"></small><small class="path57"></small><small class="path58"></small><small class="path59"></small><small class="path60"></small><small class="path61"></small><small class="path62"></small><small class="path63"></small><small class="path64"></small><small class="path65"></small><small class="path66"></small><small class="path67"></small><small class="path68"></small><small class="path69"></small><small class="path70"></small><small class="path71"></small><small class="path72"></small><small class="path73"></small><small class="path74"></small><small class="path75"></small><small class="path76"></small><small class="path77"></small><small class="path78"></small><small class="path79"></small><small class="path80"></small><small class="path81"></small><small class="path82"></small><small class="path83"></small><small class="path84"></small><small class="path85"></small><small class="path86"></small><small class="path87"></small><small class="path88"></small><small class="path89"></small><small class="path90"></small><small class="path91"></small><small class="path92"></small><small class="path93"></small><small class="path94"></small><small class="path95"></small><small class="path96"></small><small class="path97"></small><small class="path98"></small><small class="path99"></small><small class="path100"></small><small class="path101"></small><small class="path102"></small><small class="path103"></small><small class="path104"></small>
					</i>
				</span>
				<?php }else{ ?>
				<span>
					<i class="fa <?php echo esc_attr($settings['project_facts_icon'])?>"></i>
				</span>
				<?php }?>
				<span id="count-<?php echo esc_attr( $this->get_id() ); ?>" class="word-count"><?php echo esc_html($settings['project_facts_title'])?></span>
				<small><?php echo esc_html($settings['project_facts_caption'])?></small>
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
