<?php
	/*	
	*	Kodeforest Theme File
	*	---------------------------------------------------------------------
	*	This file contains the function use to print the elements of the theme
	*	---------------------------------------------------------------------
	*/
	
	// print title
	if( !function_exists('kode_get_item_title') ){
		function kode_get_item_title( $atts ){
			$ret = '';
			
			$atts['title-type'] = (empty($atts['title-type']))? $atts['type']: $atts['title-type'];
		
			if( !empty($atts['title-type']) && $atts['title-type'] != 'none' ){
				$item_class  = 'pos-' . str_replace('-divider', '', $atts['title-type']);
				$item_class .= (!empty($atts['carousel']))? ' kode-nav-container': '';
				
				$ret .= '<div class="kode-item-title-wrapper kode-item ' . esc_attr($item_class) . ' ">';
				
				$ret .= '<div class="kode-item-title-head">';
				$ret .= !empty($atts['carousel'])? '<i class="icon-angle-left kode-flex-prev"></i>': '';
				if(!empty($atts['title'])){
					$ret .= '<h3 class="kode-item-title kode-skin-title kode-skin-border">' . esc_attr($atts['title']) . '</h3>';
				}
				$ret .= !empty($atts['carousel'])? '<i class="icon-angle-right kode-flex-next"></i>': '';
				$ret .= '<div class="clear"></div>';
				$ret .= '</div>';
				
				$ret .= (strpos($atts['title-type'], 'divider') > 0)? '<div class="kode-item-title-divider"></div>': '';
				
				if(!empty($atts['caption'])){
					$ret .= '<div class="kode-item-title-caption kode-skin-info">' . esc_attr($atts['caption']) . '</div>';
				}
				
				if(!empty($atts['right-text']) && !empty($atts['right-text-link'])){
					$ret .= '<a class="kode-item-title-link" href="' . esc_url($atts['right-text-link']) . '" >' . esc_attr($atts['right-text']) . '</a>';
				}
				
				$ret .= '</div>'; // kode-item-title-wrapper
			}
			return $ret;
		}
	}

	if( !function_exists('kode_get_column_donate_item') ){
		function kode_get_column_donate_item($settings){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';
	
			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';		
			
			if( is_numeric($settings['donate-image']) ){
				$kode_image = wp_get_attachment_image_src($settings['donate-image'], 'full');
				$kode_image = esc_url($kode_image[0]);
			}else{
				$kode_image = esc_url($settings['donate-image']);
			}
			
			$title_donate = empty($settings['title-donate'])? '': '<h2>' .esc_attr( $settings['title-donate'] ). '</h3>';
			$desc_donate = empty($settings['desc-donate'])? '': '<p>' .esc_attr( $settings['desc-donate'] ). '</p>';
			$html_donate = '';
			$html_donate = '<div class="kode-cause">
				<div class="row">
					<div class="col-md-6">
						<img alt="'.esc_attr($settings['title-donate']).'" src="'.esc_attr($kode_image).'">
					</div>
					<div class="col-md-6">
						'.$title_donate.'
						'.$desc_donate.'
						<a class="read-more" href="'.esc_url($settings['link']).'">'.esc_attr($settings['link-text']).'</a>
						<!--RANGE SLIDER START-->
						<div class="kode-range">
							Min: $ <span class="range-slider">500</span>
							<input class="range" type="text" data-slider-min="0" data-slider-max="2000" data-slider-step="1" data-slider-value="500"/>
							<span id="ex6CurrentSliderValLabel"></span>
						</div>
						<!--RANGE SLIDER END-->
						<!--DONATE TEXT START-->
						<div class="donate-text">
							<p>'.esc_attr($settings['sub-donate']).'</p>
							<a class="btn-filled" href="'.esc_url($kode_theme_option['donatation_page']).'">Donate Now</a>
						</div>               
						<!--DONATE TEXT END-->             
					</div>
				</div>
				</div>';
			
			return $html_donate;
			
		}
	}

	// title item
	if( !function_exists('kode_get_title_item') ){
		function kode_get_title_item( $settings ){	
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';
	
			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';		
			
			$ret  = '<div class="kode-title-item" ' . $item_id . $margin_style . ' >';
			//$ret .= kode_get_item_title($settings);			
			$ret .= '</div>';
			return $ret;
		}
	}
	
	// accordion item
	if( !function_exists('kode_get_sidebar_item') ){
		function kode_get_sidebar_item( $settings ){
			$ret = '';
			return dynamic_sidebar($settings['widget']);			
		}
	}	
	
	// accordion item
	if( !function_exists('kode_get_accordion_item') ){
		function kode_get_accordion_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';
	
			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			
			$accordion = is_array($settings['accordion'])? esc_attr($settings['accordion']): json_decode($settings['accordion'], true);

			//$ret  = kode_get_item_title($settings);	
			$ret = '';
			$ret .= '<div class="kode-item kd-accordion kode-accordion-item" ' . $item_id . $margin_style . ' >';
			$ret .= '
			<script type="text/javascript">
			jQuery(document).ready(function($){
				/* ---------------------------------------------------------------------- */
				/*	Accordion Script
				/* ---------------------------------------------------------------------- */
				if($(".accordion").length){
					//custom animation for open/close
					$.fn.slideFadeToggle = function(speed, easing, callback) {
					  return this.animate({opacity: "toggle", height: "toggle"}, speed, easing, callback);
					};

					$(".accordion").accordion({
					  defaultOpen: "section1",
					  cookieName: "nav",
					  speed: "slow",
					  animateOpen: function (elem, opts) { //replace the standard slideUp with custom function
						elem.next().stop(true, true).slideFadeToggle(opts.speed);
					  },
					  animateClose: function (elem, opts) { //replace the standard slideDown with custom function
						elem.next().stop(true, true).slideFadeToggle(opts.speed);
					  }
					});
				}
			});
			</script>
			';
			$current_tab = 0;
			foreach( $accordion as $tab ){  $current_tab++;
				// $ret .= '<div class="accordion-tab';
				$ret .= '<div id="';
				$ret .= ($current_tab == intval($settings['initial-state']))? 'section1"': 'section_'.$current_tab.'"';
				$ret .= ' class="accordion" ';
				//$ret .= empty($tab['kdf-tab-title-id'])? '': 'id="' . esc_attr($tab['kdf-tab-title-id']) . '" ';
				$ret .= '><span class="fa ';
				$ret .= ($current_tab == intval($settings['initial-state']))? 'fa-minus': 'fa-plus';
				$ret .= '"></span>' . kode_text_filter($tab['kdf-tab-title']) . '</div>';
				$ret .= '<div class="accordion-content">' . kode_content_filter($tab['kdf-tab-content']) . '</div>';			
			}
			$ret .= '</div>';
			
			return $ret;
		}
	}	

	
	// Simple Column item
	if( !function_exists('kode_get_simple_column_item') ){
		function kode_get_simple_column_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			
			$ret  = '<div '.$item_id.' class="simple-column" '.$margin_style.'>'.kode_content_filter($settings['content']).'</div>';
			return $ret;
		}
	}	
	
	// column service item
	if( !function_exists('kode_get_column_service_item') ){
		function kode_get_column_service_item( $settings ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . esc_attr($settings['page-item-id']) . '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			$settings['style'] = empty($settings['style'])? 'type-1': $settings['style'];
			$settings['icon_type'] = empty($settings['icon_type'])? 'fa fa-lock': $settings['icon_type'];
			if($settings['style'] == 'type-1'){
			$ret = '
				<div '.$item_id.' class="kode-services with-circle kode-' . esc_attr($settings['style']) . '" '.$margin_style.'>
					<div class="services-wrap">';
						
						if($settings['icon_type'] <> ''){
							$ret .= '<span class="kode-service-icon"><i class="' . esc_attr($settings['icon_type']) . '"></i></span>';
						}
						$ret .= '
						<h4>' . kode_text_filter($settings['title']) . '</h4>
						<p>'.kode_content_filter($settings['content']).'</p>';
						if($settings['link-text'] <> ''){
							$ret  .= '<a class="custom-btn theme-bg" href="'.esc_url($settings['link']).'">'.esc_attr($settings['link-text']).'</a>';
						}
						$ret .= '
					</div>
				</div>';
			}else if($settings['style'] == 'type-2'){
			$ret = '
				<div class="kode-services kdleft">';
					if($settings['icon_type'] <> ''){
						$ret .= '<i class="' . esc_attr($settings['icon_type']) . '"></i>';
					}
					$ret .= '<div class="kode-service-info">
						<h2>' . kode_text_filter($settings['title']) . '</h2>
						'.kode_content_filter($settings['content']).'
					</div>
				</div>';
			}else if($settings['style'] == 'type-3'){
			$ret = '<div class="kd-services">';
				if($settings['icon_type'] <> ''){
					$ret .= '<i class="thbg-color ' . esc_attr($settings['icon_type']) . '"></i>';
				}
				$ret .= '<h5>' . kode_text_filter($settings['title']) . '</h5>
				'.kode_content_filter($settings['content']).'
				<a class="custom-btn theme-bg" href="'.esc_url($settings['link']).'">'.esc_attr($settings['link-text']).'</a>
			</div>';
			}else if($settings['style'] == 'type-4'){
				$ret = '
				<div class="kode-services-3">
					<i class="' . esc_attr($settings['icon_type']) . '"></i>
					<div class="kode-text-3">
						<h2>' . kode_text_filter($settings['title']) . '</h2>
						'.kode_content_filter($settings['content']).'
						<a class="kode-read-more" href="'.esc_url($settings['link']).'">'.esc_attr($settings['link-text']).'</a>
					</div>
				</div>';				
			}else if($settings['style'] == 'type-5'){
				$ret = '
				<div class="kode-services-4">
					<div class="crkt-team-dec">
						<h4><a href="'.esc_url($settings['link']).'">' . kode_text_filter($settings['title']) . '</a></h4>
						'.kode_content_filter($settings['content']).'
						<span class="' . esc_attr($settings['icon_type']) . '"></span>
					</div>
				</div>';				
			}else{
				$ret = '
				<div class="kode-services-3">
					<i class="' . esc_attr($settings['icon_type']) . '"></i>
					<div class="kode-text-3">
						<h2>' . kode_text_filter($settings['title']) . '</h2>
						'.kode_content_filter($settings['content']).'
						<a class="kode-read-more" href="'.esc_url($settings['link']).'">'.esc_attr($settings['link-text']).'</a>
					</div>
				</div>';	
			}
			
			return $ret;
		}
	}
	
	
	// breaking news item
	if( !function_exists('kode_get_headings_item') ){
		function kode_get_headings_item( $settings ){
			global $kode_counter;
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';
			$settings['element-item-class'] = (empty($settings['element-item-class']))? '': $settings['element-item-class'];
			$settings['element-style'] = (empty($settings['element-style']))? '': $settings['element-style'];
			$settings['title'] = (empty($settings['title']))? '': $settings['title'];
			$settings['caption'] = (empty($settings['caption']))? '': $settings['caption'];
			$settings['title-color'] = (empty($settings['title-color']))? '': $settings['title-color'];
			$settings['line-color'] = (empty($settings['line-color']))? '': $settings['line-color'];
			$settings['caption-color'] = (empty($settings['caption-color']))? '': $settings['caption-color'];
			$settings['alignment'] = (empty($settings['alignment']))? 'center': $settings['alignment'];
			
			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). 'px;': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			$ret = '<div class="kode-simple-heading kode-align-'.esc_attr($settings['alignment']).' '.esc_attr($settings['element-item-class']).'" '.$margin_style.'>';
			if($settings['element-style'] == 'style-1'){
				if(isset($settings['title']) && $settings['title'] <> ''){
					if($settings['description'] <> ''){
						$ret .= '
						<style scoped>
						.kode-maindivider-'.esc_attr($kode_counter).' span::before, .kode-maindivider span::after{border-top-color:'.esc_attr($settings['line-color']).'}
						</style>';
					}
					$ret .= '
					<div '.$margin_style.' class="kode-maintitle kode-maintitle-'.esc_attr($kode_counter).' kode-tstitle">
						<h2 style="color:'.esc_attr($settings['title-color']).'">'.esc_attr($settings['title']).'</h2>';
						if($settings['caption'] <> ''){
							$ret .= '<h3 style="color:'.esc_attr($settings['caption-color']).'">'.esc_attr($settings['caption']).'</h3>';
						}
						if($settings['description'] <> ''){
							$ret .= '
							<div class="clearfix clear"></div>
							<div class="kode-maindivider"><span></span></div><div class="clearfix clear"></div>
							<p>'.esc_attr($settings['description']).'</p>';
						}
						$ret .= '
					</div>';
				}
			}else if($settings['element-style'] == 'style-2'){
				if(isset($settings['title']) && $settings['title'] <> ''){
					$ret .= '
					<style scoped>
						.heading-12 span.left, .heading-12 span.right{background:'.esc_attr($settings['line-color']).'}
					</style>
					<div class="heading heading-12 kode-align-'.esc_attr($settings['alignment']).'">
						<p style="color:'.esc_attr($settings['caption-color']).'">'.esc_attr($settings['caption']).'</p>
						<h2 style="color:'.esc_attr($settings['title-color']).'"><span class="left"></span>'.esc_attr($settings['title']).'<span class="right"></span></h2>';
						if(isset($settings['description']) && $settings['description'] <> ''){
							$ret .= '<p>'.esc_attr($settings['description']).'</p>';
						}
					$ret .= '</div>';
				}
			}else if($settings['element-style'] == 'style-3'){
				if(isset($settings['title']) && $settings['title'] <> ''){
					$ret .= '
					<style scoped>
					#kode-heading-'.esc_attr($kode_counter).' .kode-icon i:before{
						background-color:'.esc_attr($settings['line-color']).' !important;
					}
					</style>
					<div class="kode-widget-title"> <h2 style="color:'.esc_attr($settings['title-color']).'">'.esc_attr($settings['title']).'</h2> </div>';
				}
			}else{
				if(isset($settings['title']) && $settings['title'] <> ''){
					$ret .= '
					<style scoped>
					#kode-heading-'.esc_attr($kode_counter).' .kf_property_line:before{
						color:'.esc_attr($settings['line-color']).' !important;
					}
					</style>
					<div  id="kode-heading-'.esc_attr($kode_counter).'" class="kode_football_latest_heading">
						<h2 style="color:'.esc_attr($settings['title-color']).'">'.esc_attr($settings['title']).'</h2>
						<strong><i class="fa icon-person"></i><b></b></strong>
					</div>';
				}
			}
			
			$ret .= '</div>';
			
			return $ret;
		}
	}
	
	
	
	// content item
	if( !function_exists('kode_get_content_item') ){
		function kode_get_content_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). 'px;': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			$ret = '<div '.$item_id.' class="kode-content-container" '.$margin_style.'>';
			while ( have_posts() ){ the_post();
				$content = kode_content_filter(get_the_content(), true); 
				
				//$ret .= '<div class="container">';
					//Show Title
					if( empty($settings['show-title']) || $settings['show-title'] != 'disable' ){
						$ret .= '<div class="kode-item kode-title"><h2>';
							$ret .= get_the_title();
						$ret .= '</h2></div>';
					}
					//Show Content
					if( empty($settings['show-content']) || $settings['show-content'] != 'disable' ){
						if(!empty($content)){
							$ret .= '<div class="kode-item kode-content pagebuilder-item-content">';
								$ret .= $content;
								ob_start();
								wp_link_pages( array( 
									'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'council' ) . '</span>', 
									'after' => '</div>', 
									'link_before' => '<span>', 
									'link_after' => '</span>' )
								);
								$ret .= ob_get_contents();
								ob_end_clean();
							$ret .= '</div>';
						}
					}
					ob_start();
					
					wp_link_pages( array( 
						'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'council' ) . '</span>', 
						'after' => '</div>', 
						'link_before' => '<span>', 
						'link_after' => '</span>' )
					);
					
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					
					$ret .= ob_get_contents();
					ob_end_clean();

			} // WHile Loop End
			$ret .= '</div>'; // End Element Container
			return $ret;
		}
	}	
	
	// content item
	if( !function_exists('kode_get_default_content_item') ){
		function kode_get_default_content_item( $settings ){			
			$item_id = empty($settings['page-item-id'])? '': ' id="' .esc_attr( $settings['page-item-id'] ). '" ';
			?>
			<div <?php echo esc_attr($item_id);?> class="kode-content-container">
			<?php
			while ( have_posts() ){ the_post();
				$content = kode_content_filter(get_the_content(), true); 
					//Show Title
					if(isset($kode_post_option['enable-title-top']) && $kode_post_option['enable-title-top'] == 'enable'){ ?>
						<div class="kode-item kode-title">
							<h2><?php echo esc_html(get_the_title());?></h2>
						</div>
					<?php }
					//Show Content
					if( empty($settings['show-content']) || $settings['show-content'] != 'disable' ){
						if(!empty($content)){ ?>
							<div class="kode-item kode-content pagebuilder-item-content">
								<?php echo kode_content_filter(get_the_content(), true); 
								wp_link_pages( array( 
									'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'council' ) . '</span>', 
									'after' => '</div>', 
									'link_before' => '<span>', 
									'link_after' => '</span>' )
								);
								?>
							</div>
							<?php
						}
					}
					
					if(get_the_author_meta('description') <> ''){ ?>
					<div class="kode-single-detail">
						<div class="kode-admin-post">
							<figure><?php echo get_avatar(get_the_author_meta('ID'), 90); ?></figure>
							<div class="admin-info">
								<h4><?php the_author_posts_link(); ?></h4>
								<p><?php echo esc_html(get_the_author_meta('description')); ?></p>
							</div>
						</div>
					</div>
					<?php }				
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				// Grid Container
			} // WHile Loop End
			?>
			</div>
		<?php
		}
	}

	// tab item
	if( !function_exists('kode_get_tab_item') ){
		function kode_get_tab_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';

			global $kode_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $kode_spaces['bottom-item'])? 'margin-bottom: ' . esc_attr( $settings['margin-bottom'] ) . ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			
			$tabs = is_array($settings['tab'])? $settings['tab']: json_decode($settings['tab'], true);			
			$current_tab = 0;
			$ret = '';
			//$ret  = kode_get_item_title($settings);	
			$ret .= '<div class="kode-item kode-tab-item '  . esc_attr($settings['style']) . '" ' . $item_id . $margin_style . '>';
			$ret .= '<div class="tab-title-wrapper" >';
			foreach( $tabs as $tab ){  $current_tab++;
				$ret .= '<h4 class="tab-title';
				$ret .= ($current_tab == intval($settings['initial-state']))? ' active" ': '" ';
				$ret .= empty($tab['kdf-tab-title-id'])? '>': 'id="' . esc_attr($tab['kdf-tab-title-id']) . '" >';
				$ret .= empty($tab['kdf-tab-icon-title'])? '': '<i class="' . esc_attr($tab['kdf-tab-icon-title']) . '" ></i>';				
				$ret .= '<span>' . kode_text_filter($tab['kdf-tab-title']) . '</span></h4>';				
			}
			$ret .= '</div>';
			
			$current_tab = 0;
			$ret .= '<div class="tab-content-wrapper" >';
			foreach( $tabs as $tab ){  $current_tab++;
				$ret .= '<div class="tab-content';
				$ret .= ($current_tab == intval($settings['initial-state']))? ' active" >': '" >';
				$ret .= kode_content_filter($tab['kdf-tab-content']) . '</div>';
							
			}	
			$ret .= '</div>';	
			$ret .= '<div class="clear"></div>';
			$ret .= '</div>'; // kode-tab-item 
			
			return $ret;
		}
	}		

	if( !function_exists('kode_get_divider_item') ){
		function kode_get_divider_item( $settings ){
			$item_id = empty($settings['element-item-id'])? '': ' id="' .esc_attr( $settings['element-item-id'] ). '" ';
			
			global $kode_spaces;
			
			$margin = (!empty($settings['margin-bottom']))? 'margin-bottom: ' .esc_attr( $settings['margin-bottom'] ). ';': '';
			$margin_style = (!empty($margin))? ' style="' .esc_attr( $margin ). '" ': '';
			
			//$style = empty($settings['size'])? '': ' style="width: ' . $settings['size'] . ';" ';
			$ret  = '<div class="clear"></div>';
			$ret .= '<div class="kode-item kode-divider-item" ' . $item_id . $margin_style . ' >';
			$ret .= '<div class="kode-divider"></div>';
			$ret .= '</div>';					
			
			return $ret;
		}
	}
	

?>