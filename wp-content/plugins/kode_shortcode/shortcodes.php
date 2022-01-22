<?php
/* ---------------------------------------------------------------------- */
/*	Code Formatter
/* ---------------------------------------------------------------------- */
function kode_shortcodes_formatter($content) {
	$block = join("|",array("social_icons","social_icon_item","kode_packages_wrap","kode_donation","kode_image_gallery","gallery_item","services","list_items","list_item","youtube","calltoaction", "vimeo", "client","soundcloud", "button", "dropcap", "highlight", "checklist", "tabs", "tab", "accordian", "toggle", "one_half", "one_third", "one_fourth", "two_third", "three_fourth", "tagline_box", "pricing_table", "pricing_column", "pricing_price", "pricing_row", "pricing_footer", "content_boxes", "content_box", "slider", "slide", "testimonials", "testimonial", "progress", "person", "recent_posts", "recent_works", "alert", "fontawesome", "social_links", "title", "separator", "tooltip", "fullwidth", "map", "counters_circle", "counter_circle", "counters_box", "counter_box", "flexslider", "blog", "imageframe", "images", "image", "sharing", "featured_products_slider", "products_slider", "menu_anchor"));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}

add_filter('the_content', 'kode_shortcodes_formatter');
add_filter('widget_text', 'kode_shortcodes_formatter');

add_shortcode('wpml_translate', 'wpml_translate_shortcode');	
if( !function_exists('wpml_translate_shortcode') ){
	function wpml_translate_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array( 'lang' => '' ), $atts));
		
		$lang_active = ICL_LANGUAGE_CODE;
		if($lang == $lang_active){
			return $content;
		}
	}	
}

//////////////////////////////////////////////////////////////////
// Heading kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('heading', 'kode_shortcode_heading');
function kode_shortcode_heading($atts,$content = null) {

	extract(shortcode_atts(array(
			'style' => '',
			'title' => '',
			'title_color' => '',
			'caption' => '',
			'caption_color' => '',
			'item_margin' => ''
		), $atts));
		$heading = '';
		if($style == 'simple-style'){
			$heading = '
				<style scoped>
				.kode-maindivider span::before, .kode-maindivider span::after{border-top-color:'.esc_attr($caption_color).'}
				</style>
				<div style="margin-bottom:'.esc_attr($item_margin).'" class="kode-maintitle kode-tstitle">
				
					<h2 style="color:'.esc_attr($title_color).'">'.esc_attr($title).'</h2>
					<h3 style="color:'.esc_attr($caption_color).'">'.esc_attr($caption).'</h3>
					<div class="clearfix clear"></div>
					<div class="kode-maindivider"><span></span></div><div class="clearfix clear"></div>
					<p>'.$content.'</p>
				</div>';
		}else if($style == 'normal-style'){
			$heading = '
				<style scoped>
					.heading-12 span.left, .heading-12 span.right{background:'.esc_attr($caption_color).'}
				</style>
				<div class="heading heading-12">
					<p style="color:'.esc_attr($caption_color).'">'.esc_attr($caption).'</p>
					<h2 style="color:'.esc_attr($title_color).'"><span class="left"></span>'.esc_attr($title).'<span class="right"></span></h2>
					<p>'.$content.'</p>
				</div>';
		}else{
			$heading = '
			<div class="kode-widget-title"> <h2 style="color:'.esc_attr($title_color).'">'.esc_attr($title).'</h2> </div>';
		}
		
		return $heading;
			
}
//'shortcode' => '[progressbar title="{{title}}" text_color="{{text_color}}" filled_color="{{filled_color}}" unfilled_color="{{unfilled_color}}" filled="{{filled}}" ][/progressbar]',
//////////////////////////////////////////////////////////////////
// progressbar kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('progressbar', 'kode_shortcode_progressbar');
function kode_shortcode_progressbar($atts,$content = null) {

	extract(shortcode_atts(array(
			'title' => '',
			'text_color' => '',
			'filled_color' => '',
			'unfilled_color' => '',
			'filled' => ''
		), $atts));
		$progress = '';
		$progress = '
		<div class="progress-holder">
			<span style="color:'.esc_attr($text_color).'  !important">'.esc_attr($title).'</span>
			<div style="background:'.esc_attr($unfilled_color).' !important" class="progress">
				<div style="width:'.esc_attr($filled).'%;background:'.esc_attr($filled_color).' !important" class="progress-bar"> '.esc_attr($filled).'%</div>
			</div>
		</div> ';
	
		
		return $progress;
			
}
//'shortcode' => '[progressbar title="{{title}}" text_color="{{text_color}}" filled_color="{{filled_color}}" unfilled_color="{{unfilled_color}}" filled="{{filled}}" ][/progressbar]',
//////////////////////////////////////////////////////////////////
// progressbar kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('kode_donation', 'kode_shortcode_kode_donation');
function kode_shortcode_kode_donation($atts,$content = null) {

	extract(shortcode_atts(array(
			'email' => '',
			'controler' => '',
			'thankyou_page' => '',
		), $atts));
		$url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"]);
		$donation = '';
		$donation = '
		<div id="koderespond">
			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" class="payPalForm">
			<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="payPalForm">-->
				<div class="k_donation">
					
					<input type="hidden" name="cmd" value="_donations" />
					
					<input type="hidden" name="item_name" value="Donation" />

					<!-- Your PayPal email: -->
					<input type="hidden" name="business" value="'.$email.'" />

					<!-- PayPal will send an IPN notification to this URL: -->
					<input type="hidden" name="notify_url" value="'.$controler.'" /> 

					<!-- The return page to which the user is navigated after the donations is complete: -->
					<input type="hidden" name="return" value="'.$thankyou_page.'" /> 

					<!-- Signifies that the transaction data will be passed to the return page by POST -->
					<input type="hidden" name="rm" value="2" />				
					
					<input type="hidden" name="src" value="1">
					<input type="hidden" name="sra" value="1">

					<!--General configuration variables for the paypal landing page. Consult 
					http://www.paypal.com/IntegrationCenter/ic_std-variable-ref-donate.html for more info -->

					<input type="hidden" name="no_note" value="1" />
					<input type="hidden" name="cbt" value="Go Back To The Site" />
					<input type="hidden" name="no_shipping" value="1" />
					<input type="hidden" name="lc" value="US" />


					<!-- The amount of the transaction: -->
					<div class="donation-nav">
						<div class="donation-list">
							<input type="radio" checked="checked" value="1" name="radio" id="radio1"><label for="radio1"><span><span></span></span><small>$5</small></label>
						</div>
						<div class="donation-list">
							<input type="radio" value="2" name="radio" id="radio2"><label for="radio2"><span><span></span></span><small>$10</small></label>
						</div>
						<div class="donation-list">
							<input type="radio" value="3" name="radio" id="radio3"><label for="radio3"><span><span></span></span><small>$25</small></label>
						</div>
						<div class="donation-list">
							<input type="radio" checked="checked" value="1" name="radio" id="radio4"><label for="radio4"><span><span></span></span><small>$35</small></label>
						</div>
						<div class="donation-list">
							<input type="radio" value="2" name="radio" id="radio5"><label for="radio5"><span><span></span></span><small>$45</small></label>
						</div>
						<div class="donation-list">
							<input type="radio" value="3" name="radio" id="radio6"><label for="radio6"><span><span></span></span><small>$55</small></label>
						</div>
					</div>
					
					<div class="kode-maintitle">
						<h3>OR</h3>
					</div>
					<div class="row">						
						<div class="col-md-4">
							<p><i class="fa fa-users"></i>
								<label>
									<select name="t3">
										<option value="0">--One Time Only--</option>
										<option value="D">Daily</option>
										<option value="W">Weekly</option>
										<option value="M" >Monthly</option>
										<option value="Y">Yearly</option>
									</select>
								</label>
							</p>
						</div>
						<div class="col-md-4">
							<p><i class="fa fa-users"></i> <input type="text" name="p3" placeholder="1"></p>
						</div>
						<div class="col-md-4">
							<p><i class="fa fa-users"></i> <input type="text" name="a3" placeholder="Recurring Amount"></p>
						</div>
						<div class="col-md-4">
							<p><i class="fa fa-users"></i> <input type="text" name="amount" placeholder="Other Amount *"></p>
						</div>	
						<div class="col-md-4">
							<p><i class="fa fa-users"></i>
							<label>';
									$options = array(
										'AUD' => 'Australian Dollars (A $)',
										'BRL' => 'Brazilian Real',
										'CAD' => 'Canadian Dollars (C $)',
										'CZK' => 'Czech Koruna',
										'DKK' => 'Danish Krone',
										'EUR' => 'Euros (&euro;)',
										'HKD' => 'Hong Kong Dollar ($)',
										'HUF' => 'Hungarian Forint',
										'JPY' => 'Yen (&yen;)',
										'MYR' => 'Malaysian Ringgit',
										'MXN' => 'Mexican Peso',
										'NOK' => 'Norwegian Krone',
										'NZD' => 'New Zealand Dollar ($)',
										'PHP' => 'Philippine Peso',
										'PLN' => 'Polish Zloty',
										'GBP' => 'Pounds Sterling (&pound;)',
										'RUB' => 'Russian Ruble',
										'SGD' => 'Singapore Dollar ($)',
										'SEK' => 'Swedish Krona',
										'CHF' => 'Swiss Franc',
										'TWD' => 'Taiwan New Dollar',
										'THB' => 'Thai Baht',
										'TRY' => 'Turkish Lira',
										'USD' => 'U.S. Dollars ($)',
									);
							$donation .= '<select name="currency_code">';
								foreach($options as $key=>$val){
									$donation .= '<option value="'.esc_attr($key).'">'.esc_attr($val).'</option>';
								}
							$donation .= '
								</select>
							</label>
							</p>
						</div>
						<!-- You can change the image of the button: -->
						<p class="kd-button"> <input type="submit"  name="submit" alt="PayPal - The safer, easier way to pay online!" value="Donate Now"/></p>
						<!--<input type="submit"  name="submit" alt="PayPal - The safer, easier way to pay online!" value="Donate Now"/>-->
					</div>
				</form>
			</div>';
		
		return $donation;
			
}
//////////////////////////////////////////////////////////////////
// skill Bar
//////////////////////////////////////////////////////////////////
add_shortcode('skill', 'kode_shortcode_skill');
function kode_shortcode_skill($atts, $content = null) {
	global $data;
	
	wp_register_script('kode-waypoints-min', KODE_PATH.'/framework/include/frontend_assets/default/js/waypoints-min.js', false, '1.0', true);
	wp_enqueue_script('kode-waypoints-min');
	wp_enqueue_script('circle-chart', KODE_PATH . '/framework/include/frontend_assets/default/js/jquery.circlechart.js', array(), '1.0', true);	

	extract(shortcode_atts(array(
		'filled_color' => '',
		'unfilled_color' => '',
		'value' => '70',
		'unit' => ''
	), $atts));
	static $kode_skill_id = 1;
	
	if(!$filled_color) {
		$filled_color = $filled_color;
	}

	if(!$unfilled_color) {
		$unfilled_color = $unfilled_color;
	}

	$html = '';
	$html .= '<script type="text/javascript">
	jQuery(document).ready(function($){
		/* ---------------------------------------------------------------------- */
		/*	Circle Progress
		/* ---------------------------------------------------------------------- */
		if($("#skill-'.$kode_skill_id.'").length){
			$("#skill-'.$kode_skill_id.'").percentcircle({
				animate : true,
				diameter : 200,
				guage: 15,
				coverBg: "red",
				bgColor: "'.$unfilled_color.'",
				fillColor: "'.$filled_color.'",
				percentSize: "50px",
				percentWeight: "normal"
			});
		}
	});
	</script>';
	$html .= '<div id="skill-'.esc_attr($kode_skill_id).'" class="circle-progress" data-bgColor="'.esc_attr($filled_color).'" data-fillColor="'.esc_attr($unfilled_color).'" data-percent="'.esc_attr($value).'"></div>';
	$kode_skill_id++;
	
	return $html;
}

//[calltoaction class="{{class}}" title="{{title}}" color="{{color}}" align="{{align}}" btn_text="{{btn_text}}" btn_url="{{btn_url}}" ][/calltoaction]
//////////////////////////////////////////////////////////////////
// progressbar kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('calltoaction', 'kode_shortcode_calltoaction');
function kode_shortcode_calltoaction($atts,$content = null) {

	extract(shortcode_atts(array(
			'class' => '',
			'title' => '',
			'color' => '',
			'style' => '',
			'align' => '',
			'btn_text' => '',
			'btn_url' => '',
			'btn_text_1' => '',
			'btn_url_1' => ''
		), $atts));
		$call_to_action = '';
		if($style == 'style-1'){
		$call_to_action = '
			<div class="kode-classic-action kode-'.esc_attr($align).' '.esc_attr($class).'">
				<h2><i class="fa fa-briefcase"></i> '.esc_attr($title).'</h2>
				<div class="kode-actionbtn">
					<a style="color:'.esc_attr($color).'" href="'.esc_url($btn_url).'">'.$btn_text.'</a>
					<a style="color:'.esc_attr($color).'" href="'.esc_url($btn_url_1).'">'.$btn_text_1.'</a>
				</div>
			</div>';
		}else if($style == 'style-2'){
		$call_to_action = '
		<div class="kode-main-action kode-'.esc_attr($align).' '.esc_attr($class).'">
			<span style="color:'.esc_attr($color).'" >'.esc_attr($title).'</span>
			<a style="color:'.esc_attr($color).'" href="'.esc_url($btn_url).'"><i class="fa fa-sign-in"></i> '.esc_attr($btn_text).'</a>
		</div>';
		}else{
			$call_to_action = '
			<div class="kode-classic-action kode-'.esc_attr($align).' '.esc_attr($class).'">
				<h2><i class="fa fa-briefcase"></i> '.esc_attr($title).'</h2>
				<div class="kode-actionbtn">
					<a style="color:'.esc_attr($color).'" href="'.esc_url($btn_url).'">'.$btn_text.'</a>
					<a style="color:'.esc_attr($color).'" href="'.esc_url($btn_url_1).'">'.$btn_text_1.'</a>
				</div>
			</div>';
		}
	
		
		return $call_to_action;
			
}


//////////////////////////////////////////////////////////////////
// timeline kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('timeline', 'kode_shortcode_timeline');
function kode_shortcode_timeline($atts,$content = null) {

	extract(shortcode_atts(array(
			'size' => '',
		), $atts));
		
		$timeline = '';		
		$timeline .= '
		<div class="kode-team-timeline">
			<span class="timeline-circle"></span>
			<ul>
				'.do_shortcode($content).'
			</ul>
			<span class="timeline-circle bottom-circle"></span>
	  </div>';
	  
	return $timeline;
}
//////////////////////////////////////////////////////////////////
// timeline_item kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('timeline_item', 'kode_shortcode_timeline_item');
function kode_shortcode_timeline_item($atts,$content = null) {

	extract(shortcode_atts(array(
			'year' => '',
			'title' => '',
			'desc' => '',
			'icon' => '',
			'class' => '',
		), $atts));
		
		$timeline = '';		
		$timeline .= '
		<li>
			<span class="kode-timezoon">'.esc_attr($year).'</span>
			<div class="timeline-inner">
			  <h2>'.esc_attr($title).'</h2>
			  <p>'.esc_attr($desc).'</p>
			</div>
		  </li>';
	  
	return $timeline;
}
//////////////////////////////////////////////////////////////////
// Heading kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('newsletter', 'kode_shortcode_newsletter');
function kode_shortcode_newsletter($atts) {

	extract(shortcode_atts(array(
			'title' => '',
			'type' => '',
			'caption' => '',
			'email' => '',
			'layout' => ''
		), $atts));
		
		$newsletter = '';
			if($type == 'mailchimp'){
				$newsletter .= '
				<div class="kode-newsletters newslatter-form">
					<i class="fa fa-envelope-o"></i>
					<h2>'.esc_attr($title).'</h2>
					<h4>'.esc_attr($caption).'</h4>
					<form method="post" id="kode-submit-form" data-ajax="' . esc_url(AJAX_URL) . '" data-security="' . wp_create_nonce(KODE_SMALL_TITLE . '-create-nonce') . '" data-action="newsletter_mailchimp">
						<input type="text" id="email" name="email" placeholder="Subscribe Email">						
						<input type="submit" value="Subscribe" class="thbg-color">
						<p class="status"></p>
					</form>
				</div>';			
			}else{
				if($layout == 'style-1'){
				$newsletter .= '<div class="kode-newslatter">
					<div class="newslatter-wrap">
						<div class="newslatter-info">
							<h2>'.esc_attr($title).'</h2>
							<span>'.esc_attr($caption).'</span>
						</div>
						<form action="http://feedburner.google.com/fb/a/mailverify" method="post">
							<input type="text" name="email" placeholder="Subscribe Email">						
							<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
							<input type="hidden" name="loc" value="en_US"/>
							<input type="submit" value="Subcribe Now" class="thbg-color">
						</form>
					</div>
				</div>';
				}else{
					$newsletter .= '<div class="newslatter-form">
					<form action="http://feedburner.google.com/fb/a/mailverify" method="post">
						<input type="text" name="email" placeholder="Subscribe Email">
						<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
						<input type="hidden" name="loc" value="en_US"/>
						<input type="submit" value="Subscribe" class="thbg-color">
					</form>
				</div>';
					
				}	
			}
		return $newsletter;
			
}
//////////////////////////////////////////////////////////////////
// Albums kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('albums', 'kode_shortcode_albums');
function kode_shortcode_albums($atts) {

	extract(shortcode_atts(array(
			'size' => 'element1-1',
			'header' => '',
			'category' => '',
			'num_fetch' => '4',
			'num_excerpt' => '300',
			'pagination' => 'No',
			'orderby' => 'date',
			'order' => 'desc',
			'item_margin' => '30',
			
		), $atts));

		$album_script = '
		<Albums>
			<size>'.esc_attr($size).'</size>
			<header>'.esc_attr($header).'</header>
			<category>'.esc_attr($category).'</category>
			<num-fetch>'.esc_attr($num_fetch).'</num-fetch>
			<num-excerpt>'.esc_attr($num_excerpt).'</num-excerpt>
			<pagination>'.esc_attr($pagination).'</pagination>
			<orderby>'.esc_attr($orderby).'</orderby>
			<order>'.esc_attr($order).'</order>
			<item-margin>'.esc_attr($item_margin).'</item-margin>
		</Albums>';
		
		$page_xml_val = new DOMDocument();
		$page_xml_val->loadXML($album_script);
		return print_album_item($page_xml_val->documentElement);		
}
//////////////////////////////////////////////////////////////////
// Gallery kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('kode_image_gallery', 'kode_shortcode_image_gallery');
function kode_shortcode_image_gallery($atts, $content = null) {

	extract(shortcode_atts(array(
			'gallery_col' => '',			
		), $atts));

		$gallery_html = '
		<div class="kode-gallery-thumb">
			'.do_shortcode($content).'
		</div>';
		
		
		return $gallery_html;		
}
//////////////////////////////////////////////////////////////////
// Gallery kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('gallery_item', 'kode_shortcode_gallery_item');
function kode_shortcode_gallery_item($atts) {

	extract(shortcode_atts(array(
			'link' => '',
			'image' => '',
		), $atts));

		$gallery_item = '
		<div class="kode_item_gallery">
			<a href="'.esc_attr($link).'"><img alt="" src="'.$image.'"></a>			
		</div>';
		
		
		return $gallery_item;		
}
//////////////////////////////////////////////////////////////////
// Event Circle kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('counter_circle', 'kode_shortcode_counter_circle');
function kode_shortcode_counter_circle($atts) {

	extract(shortcode_atts(array(			
			'header' => '',		
			'animation' => 'ticks',			
			'event_id' => '4',
			'color' => '#ffffff',
			'unfilled_color' => '#ffffff',
			'filled_color' => '#E14E3D',
			'width' => '',
			'height' => '',
			'item_margin' => '30',
			'circle_width_filled' => '1.0',
			'circle_width_unfilled' => '0.1',
			
		), $atts));
		static $counter_circle = 2;
		$counter_circle++;
		$event_html = '';
		//Select Single Events
		if(class_exists('EM_Events')){
			
			$order = 'DESC';
			$limit = 5;//Default limit
			$offset = '';
			$rowno = 0;
			$event_count = 0;
			if($event_id <> ''){
				$EM_Event = em_get_event($event_id,'post_id');
				//print_r($EM_Event);
				if(isset($EM_Event)){
					$today = esc_attr(date ( "Y-m-d" ));					
				
					// $hour = date('H',$EM_Event->start_time);
					// $min = date('i',$EM_Event->start_time);
					// $sec = date('s',$EM_Event->start_time);
					$month = esc_attr(date('m',$EM_Event->start));
					$day = esc_attr(date('d',$EM_Event->start));
					$year = esc_attr(date('Y',$EM_Event->start));

					$start_date_time = esc_attr(date ( "Y-m-d", $EM_Event->start));


					//$start_date_time = mktime($hour, $min, $sec, $month, $day, $year);
					
					//$current = mktime();
					if($today < $start_date_time){
						$event_html .= '<div class="circle-time"><script>jQuery(document).ready(function($){  
						$("#countdown-'.esc_js($counter_circle).'").TimeCircles({
							"animation": "'.esc_js($animation).'",
							"bg_width": "'.esc_js($circle_width_filled).'",
							"fg_width": "'.esc_js($circle_width_unfilled).'",
							"circle_bg_color": "'.esc_js($unfilled_color).'",							
							text_size: 0.07,
							"time": {
								"Days": {
									"text": "'.esc_attr__('Days','kickoff').'",
									"color": "'.esc_js($filled_color).'",
									"show": true
								},
								"Hours": {					
									"text": "'.esc_attr__('Hours','kickoff').'",
									"color": "'.esc_js($filled_color).'",
									"show": true
								},
								"Minutes": {
									"text": "'.esc_attr__('Minutes','kickoff').'",
									"color": "'.esc_js($filled_color).'",
									"show": true
								},
								"Seconds": {					
									"text": "'.esc_attr__('Seconds','kickoff').'",
									"color": "'.esc_js($filled_color).'",
									"show": true
								}
							}
						}); });</script>
						<div class="event-timer">
							<div id="countdown-'.esc_attr($counter_circle).'" data-date="'.esc_attr($year).'-'.esc_attr($month).'-'.esc_js($day).' 00:00:00" style="margin-bottom:'.esc_js($item_margin).'px;width: '.esc_attr($width).'; height: '.esc_attr($height).'; padding: 0px; box-sizing: border-box;color:'.esc_attr($color).';"></div>
						</div></div>';											
					}else{
						$event_html .= '<h5>There is no upcoming event in current date to show.</h5>';
					}	
				}
			}
		}
		
		return $event_html;		
}
//////////////////////////////////////////////////////////////////
// Youtube kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('youtube', 'kode_shortcode_youtube');
	function kode_shortcode_youtube($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 600,
				'height' => 360,
				'autoplay' => 'false',
				'api_params' => ''
			), $atts);

			$autoplay = "";
			if($atts['autoplay'] == "true" || $atts['autoplay'] == "yes") {
				$autoplay = "&amp;autoplay=1";
			}

			return '<div style="max-width:'.esc_attr($atts['width']).'px;max-height:'.esc_attr($atts['height']).'px;"><div class="video-kode_shortcode"><iframe title="YouTube video player" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" src="http://www.youtube.com/embed/' . esc_attr($atts['id']) . '?wmode=transparent'.esc_attr($autoplay). esc_attr($atts['api_params']) .'" frameborder="0" allowfullscreen></iframe></div></div>';
	}

//////////////////////////////////////////////////////////////////
// Vimeo kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('vimeo', 'kode_shortcode_vimeo');
	function kode_shortcode_vimeo($atts) {
		$atts = shortcode_atts(
			array(
				'id' => '',
				'width' => 600,
				'height' => 360,
				'autoplay' => 'false',
				'api_params' => 'webkitallowfullscreen mozallowfullscreen allowfullscreen'
			), $atts);

		//$protocol = (is_ssl())? 's' : '';

		$autoplay = "";
		if($atts['autoplay'] == "true" || $atts['autoplay'] == "yes") {
			$autoplay = "?autoplay=1";
		} else {
			$autoplay = "?autoplay=0";
		}
		return '<div style="max-width:'.esc_attr($atts['width']).'px;max-height:'.esc_attr($atts['height']).'px;"><div class="video-kode_shortcode"><iframe src="https://player.vimeo.com/video/'.esc_attr($atts['id']).'" width="'.esc_attr($atts['width']).'" height="'.esc_attr($atts['height']).'" frameborder="0" '.esc_attr($atts['api_params']).'></iframe></div></div>';
		//return '<div style="max-width:'.esc_attr($atts['width']).'px;max-height:'.esc_attr($atts['height']).'px;"><div class="video-kode_shortcode"><iframe src="http'.$protocol.'://player.vimeo.com/video/' . esc_attr($atts['id']) .esc_attr($autoplay). esc_attr($atts['api_params']) . '" width="' . esc_attr($atts['width']) . '" height="' . esc_attr($atts['height']) . '" frameborder="0"></iframe></div></div>';
	}

//////////////////////////////////////////////////////////////////
// SoundCloud kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('soundcloud', 'kode_shortcode_soundcloud');
	function kode_shortcode_soundcloud($atts) {
		$atts = shortcode_atts(
			array(
				'url' => '',
				'width' => '100%',
				'height' => 81,
				'comments' => 'true',
				'auto_play' => 'true',
				'color' => 'ff7700',
			), $atts);

			if($atts['comments'] == 'yes') {
				$atts['comments'] = 'true';
			} elseif($atts['comments'] == 'no') {
				$atts['comments'] = 'false';
			}

			if($atts['auto_play'] == 'yes') {
				$atts['auto_play'] = 'true';
			} elseif($atts['auto_play'] == 'no') {
				$atts['auto_play'] = 'false';
			}

			if($atts['color']) {
				$atts['color'] = str_replace('#', '', $atts['color']);
			}
			return '<iframe width="'.esc_attr($atts['width']).'" height="'.esc_attr($atts['height']).'" scrolling="no" frameborder="no" src="'.esc_url('https://w.soundcloud.com/player/?url=' . esc_url($atts['url']) . '&amp;auto_play=' . esc_attr($atts['auto_play']) . '&amp;hide_related=false&amp;show_comments=' . esc_attr($atts['comments']) . '&amp;show_user=true&amp;show_reposts=false&amp;visual=true').'"></iframe>';
			//return '<iframe width="'.esc_attr($atts['width']).'" height="'.esc_attr($atts['height']).'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . esc_url(urlencode($atts['url'])) . '&amp;show_comments=' . esc_attr($atts['comments']) . '&amp;auto_play=' . esc_attr($atts['auto_play']) . '&amp;color=' . esc_attr($atts['color']) . '"></iframe>';
			//return '<object height="' . $atts['height'] . '" width="' . $atts['width'] . '"><param name="movie" value="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '"></param><param name="allowscriptaccess" value="always"></param><embed allowscriptaccess="always" height="' . $atts['height'] . '" src="http://player.soundcloud.com/player.swf?url=' . urlencode($atts['url']) . '&amp;show_comments=' . $atts['comments'] . '&amp;auto_play=' . $atts['auto_play'] . '&amp;color=' . $atts['color'] . '" type="application/x-shockwave-flash" width="' . $atts['width'] . '"></embed></object>';
	}

//////////////////////////////////////////////////////////////////
// Button kode_shortcode
//////////////////////////////////////////////////////////////////
//'kode_shortcode' => '[button link="{{url}}" target="{{target}}" color="{{color}}" bgcolor="{{bgcolor}}" size="{{size}}" ]{{content}}[/button]',
add_shortcode('button', 'kode_shortcode_button');
function kode_shortcode_button($atts, $content = null) {
	extract(shortcode_atts(array(
		'link' => '#',
		'target'=> '_self',
		'color' => '#333',
		'bgcolor' => '#ccc',
		'size'=> 'small',			
	), $atts));

	static $nightrock_button_counter = 1;
	$styles = '<style scoped>
		.button-'.$nightrock_button_counter.'{
			background-color:'.$bgcolor.' !important;
			color:'.$color.' !important;
		}
	</style>';
	$html = $styles . '<a class="button-'.esc_attr($nightrock_button_counter).' custom-btn kd-' . esc_attr($size) .'" href="' . esc_attr($link) . '" target="' . esc_attr($target) . '">' .do_shortcode($content). '</a>';

	$nightrock_button_counter++;

	return $html;
}


//////////////////////////////////////////////////////////////////
// Social Icons
//////////////////////////////////////////////////////////////////
add_shortcode('social_icons', 'kode_shortcode_social_icons');
function kode_shortcode_social_icons($atts, $content = null) {
	extract(shortcode_atts(array(		
		'size'=> 'small',			
	), $atts));

	static $kode_counter = 1;
	$styles = '<style scoped>
		#kode-links-'.esc_attr($kode_counter).'{
			
		}
	</style>';
	$html = $styles . '<ul id="kode-links-'.esc_attr($kode_counter).'" class="social-links1 '.esc_attr($size).'">'.do_shortcode($content).'</ul>';

	$kode_counter++;

	return $html;
}
//////////////////////////////////////////////////////////////////
// Social Icons
//////////////////////////////////////////////////////////////////
add_shortcode('social_icon_item', 'kode_shortcode_social_icons_item');
function kode_shortcode_social_icons_item($atts, $content = null) {
	extract(shortcode_atts(array(
		'link' => '#',
		'icon' => '',
		'class' => '',
		'target'=> '_self'
	), $atts));

	static $kode_counter = 1;
	$styles = '<style scoped>
		#kode-links-'.esc_attr($kode_counter).'{
			
		}
	</style>';
	$html = $styles . '<li id="kode-links-'.esc_attr($kode_counter).'" class="'.esc_attr($class).'"><a target="'.esc_attr($target).'" href="'.esc_url($link).'"><i class="fa '.esc_attr($icon).'"></i></a></li>';

	$kode_counter++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Social Network Shortcode
//////////////////////////////////////////////////////////////////
//[social_network class="{{class}}" ][/social_network]
add_shortcode('social_network', 'kode_shortcode_snetwork');
function kode_shortcode_snetwork($atts, $content = null) {
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));

	static $nightrock_button_counter = 1;

	global $kode_header_social_icon, $kode_theme_option;
	$type = empty($kode_theme_option['header-social-type'])? 'dark': $kode_theme_option['header-social-type'];
	
	$html_snetwork = '<div class="kode_short">';
	$html_snetwork .= '<div class="socialnetwork">';
	$html_snetwork .= '<ul class="'.esc_attr($type).'">';
	$html_snetwork .= empty($kode_theme_option['delicious-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['delicious-header-social']).'"><i class="fa fa-delicious"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['digg-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['digg-header-social']).'"><i class="fa fa-digg"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['facebook-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['facebook-header-social']).'"><i class="fa fa-facebook"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['flickr-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['flickr-header-social']).'"><i class="fa fa-flickr"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['google-plus-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['google-plus-header-social']).'"><i class="fa fa-google-plus"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['linkedin-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['linkedin-header-social']).'"><i class="fa fa-linkedin"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['pinterest-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['pinterest-header-social']).'"><i class="fa fa-pinterest"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['skype-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['skype-header-social']).'"><i class="fa fa-skype"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['stumble-upon-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['stumble-upon-header-social']).'"><i class="fa fa-stumbleupon"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['tumblr-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['tumblr-header-social']).'"><i class="fa fa-tumblr"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['twitter-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['twitter-header-social']).'"><i class="fa fa-twitter"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['vimeo-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['vimeo-header-social']).'"><i class="fa fa-vimeo-square"></i></a></li>';
	$html_snetwork .= empty($kode_theme_option['youtube-header-social'])? '': '<li><a href="'.esc_url($kode_theme_option['youtube-header-social']).'"><i class="fa fa-youtube"></i></a></li>';
	$html_snetwork .= '</ul>';
	$html_snetwork .= '</div>';
	$html_snetwork .= '</div>';
	
	$nightrock_button_counter++;

	return $html_snetwork;
}

//////////////////////////////////////////////////////////////////
// List Items Shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('list_items', 'kode_shortcode_list_items');
function kode_shortcode_list_items($atts, $content = null) {
	extract(shortcode_atts(array(
		'class' => '',
		'align' => '',
		
	), $atts));

	static $list_item_counter = 1;

	$html_items = '
	<ul class="kode-form-list strip-info '.esc_attr($class).'">
		'.do_shortcode($content).'
	</ul>';
	
	$list_item_counter++;

	return $html_items;
}

add_shortcode('list_item', 'kode_shortcode_list_item');
function kode_shortcode_list_item($atts, $content = null) {
	extract(shortcode_atts(array(
		'icon' => '',
		'title' => '',
		'caption' => '',
		'color' => '',
		
	), $atts));	
	static $list_item_counter = 1;
	$html_item = '<li style="color:'.esc_attr($color).'"><i class="fa '.esc_attr($icon).'"></i> <p><strong>'.esc_attr($title).':</strong> '.esc_attr($caption).'</p></li>';	
	$list_item_counter++;

	return $html_item;
}
//////////////////////////////////////////////////////////////////
// Button kode_shortcode
//////////////////////////////////////////////////////////////////
//[theme_button class="{{class}}" btn_text="{{btn_text}}" color="{{color}}" align="{{align}}" btn_background="{{btn_background}}" btn_url="{{btn_url}}" ][/theme_button]
add_shortcode('theme_button', 'kode_shortcode_tbtn');
function kode_shortcode_tbtn($atts, $content = null) {
	extract(shortcode_atts(array(
		'class' => '#',
		'btn_text'=> '_self',
		'color' => '#333',
		'align' => '#ccc',
		'btn_background'=> 'small',
		'btn_url'=> 'small',
	), $atts));

	static $nightrock_button_counter = 1;
	$styles = '<style scoped>
		.button-'.$nightrock_button_counter.'{
			color:'.$color.' !important;
			background:'.$bgcolor.' !important;
		}
	</style>';
	$html = $styles . '<a class="button-'.esc_attr($nightrock_button_counter).' custom-btn kd-' . esc_attr($size) .'" href="' . esc_attr($link) . '" target="' . esc_attr($target) . '">' .do_shortcode($content). '</a>';

	$nightrock_button_counter++;

	return $html;
}
//////////////////////////////////////////////////////////////////
// Dropcap kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('dropcap', 'kode_shortcode_dropcap');
	function kode_shortcode_dropcap( $atts, $content = null ) {
	
	static $nightrock_dropcap_counter = 1;
	$nightrock_dropcap_counter++;
		extract(shortcode_atts(array(
			'color' => '#333',
		), $atts));
		$style_dropcap = '<style scoped>
		.dropcap-'.esc_attr($nightrock_dropcap_counter).'{color:'.esc_attr($color).';}
		</style>';
		return $style_dropcap . '<span class="dropcap dropcap-'.esc_attr($nightrock_dropcap_counter).'">' .do_shortcode($content). '</span>';

}

//////////////////////////////////////////////////////////////////
// Highlight kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('highlight', 'kode_shortcode_highlight');
	function kode_shortcode_highlight($atts, $content = null) {
		extract(shortcode_atts(array(
				'color' => 'yellow',
				'bg_color' => 'bg_color',
		), $atts));
			if($color == 'black') {
				return '<span class="highlight2" style="color:'.esc_attr($color).';background-color:'.esc_attr($bg_color).';">' .do_shortcode($content). '</span>';
			} else {
				return '<span class="highlight1" style="color:'.esc_attr($color).';background-color:'.esc_attr($bg_color).';">' .do_shortcode($content). '</span>';
			}

	}


//////////////////////////////////////////////////////////////////
// Check list kode_shortcode
//////////////////////////////////////////////////////////////////
// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = plugin_dir_path( __FILE__ ) .'tinymce/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

global $icons;

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}
	function get_icon_code($icon_name=''){
	global $icons;
		foreach($icons as $keys=>$val){		
			if($keys == $icon_name){
				$code = $val;
			}
		}
		return $code;
	}	

add_shortcode('checklist', 'kode_shortcode_checklist');
	function kode_shortcode_checklist( $atts, $content = null ) {
		global $data, $icons;

		static $kode_checklist_counter = 1;

		extract(shortcode_atts(array(
			'icon' => 'fa-lock',
			'iconcolor' => '',
			'circle' => 'yes'
		), $atts));

	$str = "";
	$str .= '<div id="checklist-'.esc_attr($kode_checklist_counter).'" class="check-list">
	<style type="text/css" scoped>
	#checklist-'.esc_attr($kode_checklist_counter).' ul li:before{
		color:'.esc_attr($iconcolor).' !important;
		content:"'.esc_attr(get_icon_code($icon)).'" !important;
		margin-right:10px;
	}
	</style>';
	$str .= html_entity_decode($content);
	$str .= '</div>';
	$kode_checklist_counter++;

	return $str;
}

//////////////////////////////////////////////////////////////////
// Tabs kode_shortcode
//////////////////////////////////////////////////////////////////
	$tab_array = array();
	add_shortcode('tabs', 'kode_tab_kode_shortcode');
	function kode_tab_kode_shortcode( $atts, $content = null ){
		//layout="horizontal" backgroundcolor="#81d742" inactivecolor="#dd9933"
		extract( shortcode_atts(
			array(
			"layout" => '',
			"backgroundcolor" => '',
			"inactivecolor" => ''), 
			$atts)
		);
		static $count_tabs = 0;
		$count_tabs++;
		if($layout == 'vertical'){
			$item_class = 'kd-vertical-tab';
			$div_class = '';
		}else{
			$item_class = 'kd-horizontal-tab';
			$div_class = '<div class="clear"></div>';
		}
		$tab = '<style scoped>.tabs-kode-'.esc_attr($count_tabs).' .active a{background:'.esc_attr($backgroundcolor).'} .tabs-kode-'.esc_attr($count_tabs).' a{background:'.esc_attr($inactivecolor).'}</style>';
		global $tab_array;
		$tab_array = array();
		
		do_shortcode($content);
		
		$num = sizeOf($tab_array);
		$tab .= '<div class="'.esc_attr($item_class).' tabs kd-tab">';
		
		// tab title
		$tab = $tab . '<ul class="nav nav-tabs" role="tablist">';
		for($i=0; $i<$num; $i++){
			
			if($i == 0){$active = 'active';}else{$active = '';}
		
			$tab = $tab . '<li role="presentation" class="'.esc_attr($active).'"><a href="#tab-' . esc_attr($i)  .esc_attr($count_tabs). '" aria-controls="tab-' . esc_attr($i) .esc_attr($count_tabs). '" role="tab" data-toggle="tab"';
			$tab = $tab . '>' . esc_attr($tab_array[$i]["title"]) . '</a></li>';
		}				
		$tab = $tab . '</ul>';
		
		// tab content
		$tab = $tab . $div_class;
		$tab = $tab . '<div class="tab-content">';
		for($i=0; $i<$num; $i++){
			if($i == 0){$active = 'active';}else{$active = '';}

			$tab = $tab . '<div role="tabpanel" class="tab-pane '.esc_attr($active).'" id="tab-' . esc_attr($i) .esc_attr($count_tabs). '" ';
			$tab = $tab . '>' . esc_attr($tab_array[$i]["content"]) . '</div>';
		}
		$tab = $tab . "</div>"; // kode-tab-content
		
		$tab = $tab . "</div>"; // kode-tab

		return $tab;
	}
	add_shortcode('tab', 'tab_item_kode_shortcode');
	function tab_item_kode_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array("title" => ''), $atts) );
		
		global $tab_array;

		$tab_array[] = array("title" => $title , "content" => do_shortcode($content));
	}	

	
	//////////////////////////////////////////////////////////////////
	// Our Clients kode_shortcode
	//////////////////////////////////////////////////////////////////
	$client_array = array();
	add_shortcode('our_clients', 'kode_our_clients');
	function kode_our_clients( $atts, $content = null ){
		
		extract( shortcode_atts(
			array( ), 
			$atts)
		);
		static $count_clients = 0;
		$count_clients++;
	
		$client = '';
		$client .= '<div class="kode-partner"><ul class="row">';
		$client .= do_shortcode($content);
		$client .= '</ul></div>';
		
		return $client;
	}
	add_shortcode('client', 'kode_shortcode_client_item');
	function kode_shortcode_client_item( $atts ){
		extract( shortcode_atts(array("image" => '',"link" => '','target' => ''), $atts) );
		$client = '';
		$client .= '<li class="col-md-3"><a target="' . esc_url($target) . '" href="' . esc_url($link) . '"><img src="'.esc_url($image).'" alt="" /></a></li>';
		return $client;
	}	
//////////////////////////////////////////////////////////////////
// Accordian
//////////////////////////////////////////////////////////////////
add_shortcode('accordian', 'kode_shortcode_accordian');
	function kode_shortcode_accordian( $atts, $content = null ) {
	$out = '';
	$out = '
	<script type="text/JavaScript">
	jQuery( document ).ready(function($) {
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
	</script>';
	$out .= '<div class="kd-accordion">';
	$out .= do_shortcode($content);
	$out .= '</div>';

   return $out;
}

//////////////////////////////////////////////////////////////////
// Toggle kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('toggle', 'kode_shortcode_toggle');
	function kode_shortcode_toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title'      => '',
		'open' => 'no'
	), $atts));

	$toggleclass = '';
	$toggleclass2 = '';
	$togglestyle = 'display: none;';

	if($open == 'yes'){
		$toggleclass = "in";
		$toggleclass2 = "default-open";
		$togglestyle = "display: block;";
	}
	static $count_item = 0;
	$count_item++;
	$out = '';
	$out .= '
			<div class="accordion" id="section-'.esc_attr($count_item).'">
				' .esc_attr($title) . '<span class="fa fa-plus"></span>
			</div>
			<div class="accordion-content">
				<p>'. do_shortcode($content) . '</p>
			</div>';	

   return $out;
}

//////////////////////////////////////////////////////////////////
// Column one_half kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_half', 'kode_shortcode_one_half');
	function kode_shortcode_one_half($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_half last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_half">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_third kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_third', 'kode_shortcode_one_third');
	function kode_shortcode_one_third($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_third last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_third">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column two_third kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('two_third', 'kode_shortcode_two_third');
	function kode_shortcode_two_third($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="two_third last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="two_third">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_fourth kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_fourth', 'kode_shortcode_one_fourth');
	function kode_shortcode_one_fourth($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="one_fourth last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_fourth">' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column three_fourth kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('three_fourth', 'kode_shortcode_three_fourth');
	function kode_shortcode_three_fourth($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'last' => 'no',
			), $atts);

			if($atts['last'] == 'yes') {
				return '<div class="three_fourth last">' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="three_fourth">' .do_shortcode($content). '</div>';
			}

	}


//////////////////////////////////////////////////////////////////
// Pricing table
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_table', 'kode_shortcode_pricing_table');
	function kode_shortcode_pricing_table($atts, $content = null) {
		global $data;

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'bordercolor' => '',
			'dividercolor' => ''
		), $atts));

		static $nightrock_pricing_table_counter = 1;

		if(!$backgroundcolor) {
			$backgroundcolor = $data['pricing_bg_color'];
		}

		if(!$bordercolor) {
			$bordercolor = $data['pricing_border_color'];
		}

		if(!$dividercolor) {
			$dividercolor = $data['pricing_divider_color'];
		}

		$str = "<style scoped type='text/css'>
		#pricing-table-{$nightrock_pricing_table_counter}.full-boxed-pricing{background-color:{$bordercolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter} .column{background-color:{$backgroundcolor} !important;border-color:{$dividercolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter}.sep-boxed-pricing .column{background-color:{$bordercolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter} .column li{border-color:{$dividercolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter} li.normal-row{background-color:{$backgroundcolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter}.full-boxed-pricing li.title-row{background-color:{$backgroundcolor} !important;}
		#pricing-table-{$nightrock_pricing_table_counter} li.pricing-row,#pricing-table-{$nightrock_pricing_table_counter} li.footer-row{background-color:{$bordercolor} !important;}
		</style>";

		if($atts['type'] == '2') {
			$type = 'sep';
		} elseif($atts['type'] == '1') {
			$type = 'full';
		} else {
			$type = 'third';
		}
		$str .= '<div id="pricing-table-'.esc_attr($nightrock_pricing_table_counter).'" class="'.esc_attr($type).'-boxed-pricing">';
		$str .= do_shortcode($content);
		$str .= '</div><div class="clear"></div>';

		$nightrock_pricing_table_counter++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Column
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_column', 'kode_shortcode_pricing_column');
	function kode_shortcode_pricing_column($atts, $content = null) {
		$str = '<div class="column">';
		$str .= '<ul>';
		if($atts['title']):
		$str .= '<li class="title-row">'.esc_attr($atts['title']).'</li>';
		endif;
		$str .= do_shortcode($content);
		$str .= '</ul>';
		$str .= '</div>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Row
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_price', 'kode_shortcode_pricing_price');
	function kode_shortcode_pricing_price($atts, $content = null) {
		$str = '';
		$str .= '<li class="pricing-row">';
		if(isset($atts['currency']) && !empty($atts['currency']) && isset($atts['price']) && (!empty($atts['price']) || ($atts['price'] == '0')) ) {
			$class = '';
			$price = explode('.', $atts['price']);
			if($price[1]){
				$class .= 'price-with-decimal';
			}
			$str .= '<div class="price '.esc_attr($class).'">';
				$str .= '<strong>'.esc_attr($atts['currency']).'</strong>';
				$str .= '<em class="exact_price">'.esc_attr($price[0]).'</em>';
				if($price[1]){
					$str .= '<sup>'.esc_attr($price[1]).'</sup>';
				}
				if($atts['time']) {
					$str .= '<em class="time">'.esc_attr($atts['time']).'</em>';
				}
			$str .= '</div>';
		} else {
			$str .= do_shortcode($content);
		}
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Row
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_row', 'kode_shortcode_pricing_row');
	function kode_shortcode_pricing_row($atts, $content = null) {
		$str = '';
		$str .= '<li class="normal-row">';
		$str .= do_shortcode($content);
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Pricing Footer
//////////////////////////////////////////////////////////////////
add_shortcode('pricing_footer', 'kode_shortcode_pricing_footer');
	function kode_shortcode_pricing_footer($atts, $content = null) {
		$str = '';
		$str .= '<li class="footer-row">';
		$str .= do_shortcode($content);
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Content box kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('content_boxes', 'kode_shortcode_content_boxes');
	function kode_shortcode_content_boxes($atts, $content = null) {
		global $data;

		extract(shortcode_atts(array(
			'layout' => 'icon-with-title',
			'iconcolor' => '',
			'circlecolor' => '',
			'circlebordercolor' => '',
			'backgroundcolor' => ''
		), $atts));

		static $nightrock_content_box_counter = 1;

		if(!$iconcolor) {
			$iconcolor = $data['icon_color'];
		}

		if(!$circlecolor) {
			$circlecolor = $data['icon_circle_color'];
		}

		if(!$circlebordercolor) {
			$circlebordercolor = $data['icon_border_color'];
		}

		if(!$backgroundcolor) {
			$backgroundcolor = $data['content_box_bg_color'];
		}

		$str = "<style scoped type='text/css'>
		#content-boxes-{$nightrock_content_box_counter} article.col{background-color:{$backgroundcolor} !important;}
		#content-boxes-{$nightrock_content_box_counter} .fontawesome-icon.circle-yes{color:{$iconcolor} !important;background-color:{$circlecolor} !important;border-color: {$circlebordercolor} !important;}
		#content-boxes-{$nightrock_content_box_counter} a:hover .fontawesome-icon.circle-yes{background-color: {$data['primary_color']} !important;border-color:{$data['primary_color']} !important;}
		</style>";

		preg_match_all('/(\[content_box (.*?)\](.*?)\[\/content_box\])/s', $content, $matches);
		if( is_array( $matches ) && !empty( $matches ) ) {
			$columns = count($matches[0]);
			if( $columns > 0 ) {
				$columns = $columns;
			} else if( $columns > 4 ) {
				$columns = 4;
			} else if ( !$columns ) {
				$columns = 4;
			}
		} else {
			$columns = 4;
		}
		$str .= '<section class="clearfix columns content-boxes content-boxes-'.esc_attr($layout).' columns-'.esc_attr($columns).'" id="content-boxes-'.esc_attr($nightrock_content_box_counter).'">';
		$str .= do_shortcode($content);
		$str .= '</section>';

		$nightrock_content_box_counter++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Content box kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('content_box', 'kode_shortcode_content_box');
	function kode_shortcode_content_box($atts, $content = null) {

		extract(shortcode_atts(array(
			'link' => '',
			'linktarget' => '_self',
			'width' => '35',
			'height' => '35',
			'animation_type' => '',
			'animation_direction' => 'left',
			'animation_speed' => '',
			'img_id' => '',
		), $atts));

		$direction_suffix = '';
		$animation_class = '';
		$animation_attribues = '';
		if($animation_type) {
			$animation_class = ' animated';
			if($animation_type != 'flash' && $animation_type != 'shake') {
				$direction_suffix = 'In'.ucfirst($animation_direction);
				$animation_type .= $direction_suffix;
			}
			$animation_attribues = ' animation_type="'.$animation_type.'"';

			if($animation_speed) {
				$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
			}
		}

		$str = '';
		if(!empty($atts['last']) && $atts['last'] == 'yes'):
		$str .= '<article class="col last">';
		else:
		$str .= '<article class="col">';
		endif;

		if((isset($atts['image']) && $atts['image']) || (isset($atts['title']) && $atts['title'])):
			if(!empty($atts['image'])) {
				$margin_left = -$atts['image_width']/2;
				$margin_top = 0;
				if($atts['image_height'] < 64) {
					$margin_top = strval((64 - $atts['image_height'])/2).'px';
				}
				$padding_left = $atts['image_width']+10;
				$img_id = "id".strval(mt_rand());
				$str .= "<style scoped type='text/css'>
				.content-boxes-icon-boxed .col .heading-and-icon img#{$img_id} { width:{$atts['image_width']}px; height:{$atts['image_height']}px; margin-left:{$margin_left}px !important;margin-top:{$margin_top} !important;}
				.content-boxes-icon-on-side .col-content-container.{$img_id} { padding-left:{$padding_left}px !important; }
				</style>";
			}
			if(!empty($atts['image']) || !empty($atts['icon'])){
				$str .=	'<div class="heading heading-and-icon">';
			} else {
				$str .=	'<div class="heading">';
			}

			if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']) {
				$str .= '<a href="'.esc_url($atts['link']).'" target="'.esc_attr($linktarget).'">';
			}


		if(isset($atts['image']) && $atts['image']):
		if($animation_type) {
			$animation_class = 'class="animated"';
		}
		$str .= '<img id="'.esc_attr($img_id).'" src="'.esc_url($atts['image']).'" width="'.esc_attr($atts['image_width']).'" height="'.esc_attr($atts['image_height']).'" alt="" '.esc_attr($animation_class).' '.esc_attr($animation_attribues).'>';
		elseif(!empty($atts['icon']) && $atts['icon']):
			$str .= '<i class="fontawesome-icon medium circle-yes icon-'.esc_attr($atts['icon']).esc_attr($animation_class).'" '.esc_attr($animation_attribues).'></i>';
		endif;
		if($atts['title']):
		$str .= '<h2>'.esc_attr($atts['title']).'</h2>';
		endif;
		if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']) {
			$str .= '</a>';
		}
		$str .= '</div>';
		endif;

		$str .= '<div class="col-content-container '.$img_id.'">';

		$str .= do_shortcode($content);

		if(isset($atts['link']) && $atts['link'] && isset($atts['linktext']) && $atts['linktext']):
		$str .= '<span class="more"><a href="'.esc_url($atts['link']).'" target="'.esc_attr($linktarget).'">'.esc_attr($atts['linktext']).'</a></span>';
		endif;

		$str .= '</div>';

		$str .= '</article>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Slider
//////////////////////////////////////////////////////////////////
add_shortcode('slider', 'kode_shortcode_slider');
	function kode_shortcode_slider($atts, $content = null) {
		wp_enqueue_script( 'jquery.flexslider' );

		extract(shortcode_atts(array(
			'width' => '100%',
			'height' => '100%'
		), $atts));
		$str = '';
		$str .= '<div class="flexslider clearfix" style="max-width:'.esc_attr($width).';height:'.esc_attr($height).';">';
		$str .= '<ul class="slides">';
		$str .= do_shortcode($content);
		$str .= '</ul>';
		$str .= '</div>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Slide
//////////////////////////////////////////////////////////////////
add_shortcode('slide', 'kode_shortcode_slide');
	function kode_shortcode_slide($atts, $content = null) {
		extract(shortcode_atts(array(
			'alt' => '',
			'linktarget' => '_self',
			'lightbox' => 'no'
		), $atts));

		if($lightbox == 'yes') {
			$rel = 'prettyPhoto';
		} else {
			$rel = '';
		}

		$str = '';
		$title = 'title=""';
		if(!$alt) {
			$src = str_replace('&#215;', 'x', $content);
			if(!empty($atts['link']) && $atts['link']) {
				$image_id = tf_get_attachment_id_from_url($atts['link']);
			} else {
				$image_id = tf_get_attachment_id_from_url($src);
			}

			if($image_id) {
				$alt_att = 'alt="'. get_post_meta($image_id, '_wp_attachment_image_alt', true).'"';
				$title = 'title="'. get_post_field("post_excerpt", $image_id).'"';
			}
		} else {
			$alt_att = 'alt="' . $alt . '"';
		}

		if(!empty($atts['type']) && $atts['type'] == 'video') {
			$str .= '<li>';
		} else {
			$str .= '<li class="image">';
		}

		if(isset($atts['link']) && empty($atts['link']) && !$atts['link'] && $atts['type'] == 'image') {
			$atts['link'] = $src;
		}
		if(!empty($atts['link']) && $atts['link']):
		$str .= '<a href="'.esc_url($atts['link']).'" target="'.esc_attr($linktarget).'" data-rel="'.esc_attr($rel).'" '.esc_attr($title).'>';
		endif;
		if(!empty($atts['type']) && $atts['type'] == 'video') {
			$str .= '<div class="full-video">'.do_shortcode($content).'</div>';
		} else {
			$str .= '<img src="'.str_replace('&#215;', 'x', $content).'" '. esc_attr($alt_att).' />';
		}
		if(!empty($atts['link']) && $atts['link']):
		$str .= '</a>';
		endif;
		$str .= '</li>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Testimonials
//////////////////////////////////////////////////////////////////
add_shortcode('testimonials', 'kode_shortcode_testimonials');
	function kode_shortcode_testimonials($atts, $content = null) {
		global $data;

		wp_enqueue_script( 'jquery.cycle' );

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'textcolor' => ''
		), $atts));

		static $nightrock_testimonials_id = 1;

		if(!$backgroundcolor) {
			$backgroundcolor = $data['testimonial_bg_color'];
		}


		if(!$textcolor) {
			$textcolor = $data['testimonial_text_color'];
		}

		$str = "<style scoped type='text/css'>
		#testimonials-{$nightrock_testimonials_id} q{background-color:{$backgroundcolor} !important;color:{$textcolor} !important;}
		#testimonials-{$nightrock_testimonials_id} .review blockquote div:after{border-top-color:{$backgroundcolor} !important;}
		</style>
		";

		$str .= '<div id="testimonials-'.esc_attr($nightrock_testimonials_id).'" class="reviews clearfix">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		$nightrock_testimonials_id++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
add_shortcode('testimonial', 'kode_shortcode_testimonial');
	function kode_shortcode_testimonial($atts, $content = null) {
		if(!isset($atts['gender'])) {
			$atts['gender'] = 'male';
		}

		if( $atts['gender'] == 'none' ) {
			$atts['gender'] = 'no-avatar';
		}

		$str = '';
		$str .= '<div class="review '.esc_attr($atts['gender']).'">';
		$str .= '<blockquote>';
		$str .= '<q>';
		$str .= do_shortcode($content);
		$str .= '</q>';
		if($atts['name']):
			$str .= '<div class="clearfix"><span class="company-name">';
			$str .= '<strong>'.$atts['name'].'</strong>';
			if($atts['company']):
				if(!empty($atts['link']) && $atts['link']):
				$str .= '<a href="'.esc_url($atts['link']).'" target="'.esc_attr($atts['target']).'">';
				endif;
				$str .= ',<span> '.$atts['company'].'</span>';
				if(!empty($atts['link']) && $atts['link']):
				$str .= '</a>';
				endif;
			endif;
			$str .= '</span></div>';
		endif;
		$str .= '</blockquote>';
		$str .= '</div>';

		return $str;
	}


//////////////////////////////////////////////////////////////////
// Progess Bar
//////////////////////////////////////////////////////////////////
add_shortcode('progress', 'kode_shortcode_progress');
function kode_shortcode_progress($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'jquery.waypoint' );

	extract(shortcode_atts(array(
		'filledcolor' => '',
		'unfilledcolor' => '',
		'value' => '70',
		'unit' => ''
	), $atts));

	if(!$filledcolor) {
		$filledcolor = $data['counter_filled_color'];
	}

	if(!$unfilledcolor) {
		$unfilledcolor = $data['counter_unfilled_color'];
	}

	$html = '';
	$html .= '<div class="progress-bar" style="background-color:'.esc_attr($unfilledcolor).' !important;border-color:'.esc_attr($unfilledcolor).' !important;">';
	$html .= '<div class="progress-bar-content" data-percentage="'.esc_attr($atts['percentage']).'" style="width: ' . esc_attr($atts['percentage']) . '%;background-color:'.esc_attr($filledcolor).' !important;border-color:'.esc_attr($filledcolor).' !important;">';
	$html .= '</div>';
	$html .= '<span class="progress-title">' . $content . ' ' . $atts['percentage'];
	if(isset($atts['unit']) && $atts['unit']) {
		$html .= $atts['unit'].'</span>';
	} else {
		$html .= '</span>';
	}
	$html .= '</div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Person
//////////////////////////////////////////////////////////////////
//[member name="Roy Miller" picture="http://hadi/night-rock/wp-content/uploads/2014/07/11.jpg" pic_link="#" title="Developer" email="miller@kodeforest.com" facebook="#" twitter="#" linkedin="#" dribbble="#" linktarget="_self"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat justo eget luctus vulputate. [/member]
add_shortcode('member', 'kode_shortcode_person');
function kode_shortcode_person($atts, $content = null) {
	global $data;
	extract(shortcode_atts(array(
		'name' => '',
		'picture' => '',
		'pic_link' => '70',
		'title' => '',
		'email' => '',
		'facebook' => '',
		'twitter' => '',
		'linkedin' => '',
		'dribbble' => '',
		'linktarget' => '',
		
	), $atts));
	
	$html = '';
	$html .= '<div class="event-orgnizer"><article class="member">
		<figure><a href="'.esc_url($pic_link).'"><img alt="" src="'.esc_url($picture).'"></a>
			<figcaption>
				<div class="social-network">
					<a target="'.$linktarget.'" class="email" href="mailto:'.esc_url($email).'"><i class="fa fa-envelope fa-2x"></i></a>
					<a target="'.$linktarget.'" class="facebook" href="'.esc_url($facebook).'"><i class="fa fa-facebook fa-2x"></i></a>
					<a target="'.$linktarget.'" class="twitter" href="'.esc_url($twitter).'"><i class="fa fa-twitter fa-2x"></i></a>
					<a target="'.$linktarget.'" class="linkedin" href="'.esc_url($linkedin).'"><i class="fa fa-linkedin fa-2x"></i></a>
					<a target="'.$linktarget.'" class="dribbble" href="'.esc_url($facebook).'"><i class="fa fa-dribbble fa-2x"></i></a>					
				</div>
				<a class="anker-plus" href="'.esc_url($pic_link).'"></a>
			</figcaption>
		</figure>
		<div class="text webkit">
			<h3><a href="'.esc_url($pic_link).'">'.esc_attr($name).'</a></h3>
			<p>'.esc_attr($title).'</p>
			<p>'.do_shortcode($content).'</p>
		</div>
	</article></div>';
	

	return $html;
}
//////////////////////////////////////////////////////////////////
// Alert Message
//////////////////////////////////////////////////////////////////
add_shortcode('alert', 'kode_shortcode_alert');
function kode_shortcode_alert($atts, $content = null) {

	extract(shortcode_atts(array(
		'type' => 'general',
		'icon' => 'fa-lock',
	), $atts));
	$item_class = '';
	if($type == 'general'){
		$item_class = 'genral-message';
	}else if($type == 'error'){
		$item_class = 'error-message';
	}else if($type == 'success'){
		$item_class = 'success-message';
	}else if($type == 'notice'){
		$item_class = 'information-message';
	}else{
		$item_class = 'warning-message';
	}
	
	$html = '';
	$html .= '<div class="alert '.esc_attr($item_class).' alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
		<p><i class="fa '.esc_attr($icon).'"></i>'.do_shortcode($content).'</p>
	</div>';
	

	return $html;
}
//////////////////////////////////////////////////////////////////
// Recent Posts
//////////////////////////////////////////////////////////////////
add_shortcode('recent_post', 'kode_shortcode_recent');
function kode_shortcode_recent($atts, $content = null) {
//<Recent-Posts><size>element2-3</size><header>&lt;span class=&quot;color&quot;&gt;From Our&lt;/span&gt; Blog</header><feature-post>110</feature-post><num-excerpt>140</num-excerpt><category>6</category><num-fetch>2</num-fetch><item-margin>30</item-margin></Recent-Posts>
	extract(shortcode_atts(array(
		'size' => 'element2-3',
		'header' => '',
		'feature_post' => 110,
		'num_excerpt' => 140,
		'category' => 6,
		'num_fetch' => 2,
		'item_margin' => 30,
	), $atts));

	$html_recent_post = '<Recent-Posts>
		<size>'.esc_attr($size).'</size>
		<header>'.esc_attr($header).'</header>
		<feature-post>'.esc_attr($feature_post).'</feature-post>
		<num-excerpt>'.esc_attr($num_excerpt).'</num-excerpt>
		<category>'.esc_attr($category).'</category>
		<num-fetch>'.esc_attr($num_fetch).'</num-fetch>
		<item-margin>'.esc_attr($item_margin).'</item-margin>
	</Recent-Posts>';
	
		$page_xml_val = new DOMDocument();
		$page_xml_val->loadXML($html_recent_post);
		return print_recent_posts_item($page_xml_val->documentElement);			
}
//////////////////////////////////////////////////////////////////
// Recent Posts
//////////////////////////////////////////////////////////////////
add_shortcode('news_slider', 'kode_shortcode_news_slider');
function kode_shortcode_news_slider($atts, $content = null) {
//<News-Slider><size>element1-3</size><header>&lt;span class=&quot;color&quot;&gt;Recent &lt;/span&gt; Posts</header><category>All</category><num-excerpt>98</num-excerpt><num-fetch>4</num-fetch><item-margin>30</item-margin></News-Slider>
	extract(shortcode_atts(array(
		'size' => 'element1-3',
		'header' => '',
		'category' => 'All',
		'num_excerpt' => 98,
		'num_fetch' => 4,
		'item_margin' => 30,
	), $atts));

	$html_recent_post = '
	<News-Slider>
		<size>'.esc_attr($size).'</size>
		<header>'.esc_attr($header).'</header>
		<category>'.esc_attr($category).'</category>
		<num-excerpt>'.esc_attr($num_excerpt).'</num-excerpt>
		<num-fetch>'.esc_attr($num_fetch).'</num-fetch>
		<item-margin>'.esc_attr($item_margin).'</item-margin>
	</News-Slider>';
	
		$page_xml_val = new DOMDocument();
		$page_xml_val->loadXML($html_recent_post);
		return print_post_slider_item($page_xml_val->documentElement);			
}

//////////////////////////////////////////////////////////////////
// Recent Posts
//////////////////////////////////////////////////////////////////
add_shortcode('events', 'kode_shortcode_events');
function kode_shortcode_events($atts, $content = null) {
//<Event><size>element1-1</size><header>&lt;span class=&quot;color&quot;&gt;Upcoming &lt;/span&gt; Events</header><event-type>Event Listing</event-type><num-excerpt>300</num-excerpt><item-scope>Future</item-scope><category>14</category><num-fetch>2</num-fetch><order>desc</order><item-margin>0</item-margin></Event>
//'kode_shortcode' => '[events size="{{size}}" header="{{header}}" category="{{category}}" item_scope="{{item_scope}}" num_fetch="{{num_fetch}}" num_excerpt="{{num_excerpt}}" order="{{order}}" item_margin="{{item_margin}}"][/events]',
	extract(shortcode_atts(array(
		'size' => 'element1-1',
		'header' => '',
		'item_scope' => 'Future',
		'category' => 14,
		'num_excerpt' => 300,
		'num_fetch' => 2,
		'order' => 'DESC',
		'item_margin' => 30,
	), $atts));

	$html_event = '
	<Event>
		<size>element1-1</size>
		<header>'.esc_attr($header).'</header>
		<event-type>Event Listing</event-type>
		<num-excerpt>'.esc_attr($num_excerpt).'</num-excerpt>
		<item-scope>'.esc_attr($item_scope).'</item-scope>
		<category>'.esc_attr($category).'</category>
		<num-fetch>'.esc_attr($num_fetch).'</num-fetch>
		<order>'.esc_attr($order).'</order>
		<item-margin>'.esc_attr($item_margin).'</item-margin>
	</Event>';
	
		$page_xml_val = new DOMDocument();
		$page_xml_val->loadXML($html_event);
		return print_event_item($page_xml_val->documentElement);			
}

//////////////////////////////////////////////////////////////////
// FontAwesome Icons
//////////////////////////////////////////////////////////////////
//[fontawesome icon="fa-times-circle-o" circle="yes" size="large" iconcolor="#dd9933" circlecolor="#1e73be" circlebordercolor="#dd3333"]
add_shortcode('fontawesome', 'kode_shortcode_fontawesome');
function kode_shortcode_fontawesome($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'icon' => '',
		'circle' => '',
		'size' => '',
		'iconcolor' => '',		
		'circlecolor' => '',
		'circlebordercolor' => '',		
	), $atts));

	static $count_fontaw = 0;
	$count_fontaw++;
	
	$style = '';
	
	$style .= '<style scoped>.fa-icon-'.esc_attr($count_fontaw).'{color:'.esc_attr($iconcolor).';background-color:'.esc_attr($circlecolor).' !important;border:1px solid '.esc_attr($circlebordercolor).' !important;}</style>';

	$html = $style . '<i class="fontawesome-icon fa-icon-'.esc_attr($count_fontaw).' '.esc_attr($size).' circle-'.esc_attr($circle).' fa '.esc_attr($icon).'"></i>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Social Links
//////////////////////////////////////////////////////////////////
add_shortcode('social_links', 'kode_shortcode_social_links');
function kode_shortcode_social_links($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'colorscheme' => '',
		'linktarget' => '_self',
		'show_custom' => "no"
	), $atts));

	if(!$colorscheme) {
		$colorscheme = strtolower($data['social_links_color']);
	}

	$nofollow = '';
	if($data['nofollow_social_links']) {
		$nofollow = ' rel="nofollow"';
	}

	$html = '<div class="social_links_kode_shortcode clearfix">';
	$html .= '<ul class="social-networks social-networks-'.$colorscheme.' clearfix">';
	foreach($atts as $key => $link) {
		if($link && $key != 'linktarget' && $key != 'colorscheme' && $key != 'show_custom') {

			if($key == "pinterest") {
				$html .= '<li class="tf-pinterest">';
			} else {
				$html .= '<li class="'.esc_attr($key).'">';
			}
			$html .= '<a class="'.esc_attr($key).'" href="'.esc_url($link).'" target="'.esc_attr($linktarget).'"'.esc_attr($nofollow).'>'.esc_attr(ucwords($key)).'</a>
			<div class="popup">
				<div class="holder">
					<p>'.esc_attr(ucwords($key)).'</p>
				</div>
			</div>
			</li>';
		}
	}
	if($atts['show_custom'] == "yes") {
		$html .= '<li class="custom"><a target="'.esc_attr($linktarget).'" href="'.esc_url($data['custom_icon_link']).'"'.esc_attr($nofollow).'><img src="'.esc_url($data['custom_icon_image']).'" alt="'.esc_attr($data['custom_icon_name']).'"/></a>
			<div class="popup">
				<div class="holder">
					<p>'.esc_attr($data['custom_icon_name']).'</p>
				</div>
			</div>
		</li>';
	}
	$html .= '</ul>';
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Clients container
//////////////////////////////////////////////////////////////////
add_shortcode('clients_kode', 'kode_shortcode_clients');
function kode_shortcode_clients($atts, $content = null) {
	wp_enqueue_script( 'jquery.carouFredSel' );

	extract(shortcode_atts(array(
		'picture_size' => 'fixed'
	), $atts));

	$css_class = "related-posts";
	$carousel_class = "clients-carousel";
	if($picture_size != 'fixed') {
		$css_class = "";
		$carousel_class = "";
	}

	$picture_size == 'fixed';

	$html = '<div class="'.esc_attr($css_class).' related-projects clientslider-container"><div id="carousel" class="'.esc_attr($carousel_class).' es-carousel-wrapper"><div class="es-carousel"><ul>';
	$html .= do_shortcode($content);
	$html .= '</ul><div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div></div></div></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Project Facts
//////////////////////////////////////////////////////////////////
add_shortcode('facts', 'kode_shortcode_facts');
function kode_shortcode_facts($atts, $content = null) {
	global $data;
	wp_enqueue_script('jquery.waypoint', KODE_PATH . '/framework/assets/default/js/waypoints-min.js', array(), '1.0', true);	
	extract(shortcode_atts(array(
		'icon' => '',
		'color' => '',
		'value' => '70',
		'sub_text' => ''
	), $atts));
	static $kode_facts_id = 1;


	$html = '';
	$html .= '<script type="text/javascript">
	jQuery(document).ready(function($){
		/* ---------------------------------------------------------------------- */
		/*	Counter Functions
		/* ---------------------------------------------------------------------- */
		if($("#count-'.esc_js($kode_facts_id).'").length){
			$("#count-'.esc_js($kode_facts_id).'").counterUp({
				delay: 10,
				time: 1000
			});
		}
	});
	</script>';
	
	$html .= '
		<div class="kd-counter">
			<i class="fa-3x fa '.esc_attr($icon).'"></i>
			<span id="count-'.esc_attr($kode_facts_id).'" class="word-count">'.esc_attr($value).'</span>
			<small>'.esc_attr($sub_text).'</small>
		</div>';
	$kode_facts_id++;
	
	return $html;
}
//////////////////////////////////////////////////////////////////
// Services kode_shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('services', 'kode_shortcode_services');
function kode_shortcode_services($atts,$content = null) {

	extract(shortcode_atts(array(
			'title' => '',
			'icon' => '',
			'type' => '',			
		), $atts));
		$services = '';
		if($type == 'style-1'){
		$services = '
			<div class="kode-services services-three">
				<i class="fa '.$icon.'"></i>
				<div class="kode-spacer">
					<h3>'.esc_attr($title).'</h3>
					<p>'.esc_attr($content).'</p>
				</div>
			</div>';
		}else if($type == 'style-2'){
			$services = '
			<div class="kode-services with-circle">
				<div class="services-wrap">
					<span class="kode-service-icon"><i class="fa '.$icon.'"></i></span>
					<h4>'.esc_attr($title).'</h4>
					<p>'.esc_attr($content).'</p>
					<a href="#">Discover More</a>
				</div>	
			</div>';
		}else{
			$services = '
				<div class="kode-services kode-circle-services">					
					<i class="thbg-color fa '.$icon.'"></i>					
					<h2>'.esc_attr($title).'</h2>
					<p>'.esc_attr($content).'</p>					
				</div>';
		}
	
		
		return $services;
			
}
//////////////////////////////////////////////////////////////////
// Client
//////////////////////////////////////////////////////////////////
add_shortcode('client_kode', 'kode_shortcode_client');
function kode_shortcode_client($atts, $content = null) {
	extract(shortcode_atts(array(
		'linktarget' => '_self',
		'link' => '',
		'image' => '',
		'alt' => '',
	), $atts));

	$html = '<li>';
	if ($link) {
		$html .= '<a href="'.esc_url($link).'" target="'.esc_attr($linktarget).'"><img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" /></a>';
	} else {
		$html .= '<img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" />';
	}
	$html .= '</li>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Title
//////////////////////////////////////////////////////////////////
add_shortcode('title', 'kode_shortcode_title');
function kode_shortcode_title($atts, $content = null) {
	extract(shortcode_atts(array(
		'size' => '2',
		'align' => '',		
	), $atts));
	$align_title = '';
	if($align == 'left'){$align_title = 'text-align:left;float:left;';}else if($align == 'right'){$align_title = 'text-align:right;float:right;';}else if($align == 'center'){$align_title = 'text-align:center;width:100%;display:block;';}else{$align_title = '';}
	$html = '<div style="'.esc_attr($align_title).'" class="title"><h'.esc_attr($size).'>'.do_shortcode($content).'</h'.$size.'><div class="title-sep-container"><div class="title-sep"></div></div></div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Separator
//////////////////////////////////////////////////////////////////
add_shortcode('separator', 'kode_shortcode_separator');
function kode_shortcode_separator($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => 'none',
		'top'	=> '',
		'bottom' => ''
	), $atts));
	$html = '';
	$margin_bottom = '';
	if($style != 'none') {
		if( empty($bottom) ) {
			$margin_bottom = 'margin-bottom:'.esc_attr($top).'px;';
		} else {
			$margin_bottom = 'margin-bottom:'.esc_attr($bottom).'px;';
		}
	}

	$border_color = '';
	// if($color) {
		// if($style == 'single') {
			// $border_color = 'background-color:' . $color . '!important;';
		// } else {
			// $border_color = 'border-color:' . $color . '!important;';
		// }
	// }
	$html .= '<div class="clearfix clear"></div><div class="div-'.$style.'" style="margin-top:'.esc_attr($top).'px;'.esc_attr($margin_bottom).esc_attr($border_color).'"><span></span></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Tooltip
//////////////////////////////////////////////////////////////////
add_shortcode('tooltip', 'kode_shortcode_tooltip');
function kode_shortcode_tooltip($atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => 'none',
	), $atts));
	$html = '';
	$html .= '<span class="tooltip_kode" title="'.esc_attr($title).'" data-placement="top" data-rel="tooltip" href="#">'.$content.'</span>';
	

	return $html;
}

//////////////////////////////////////////////////////////////////
// Google Map
//////////////////////////////////////////////////////////////////
add_shortcode('map', 'kode_shortcode_google_map');
function kode_shortcode_google_map($atts, $content = null) {
	global $data , $kode_theme_option;

	wp_enqueue_script( 'gmaps.api' );
	wp_enqueue_script( 'jquery.ui.map' );

	extract(shortcode_atts(array(
		'address' => '',
		'type' => 'satellite',
		'width' => '100%',
		'height' => '300px',
		'zoom' => '14',
		'scrollwheel' => 'true',
		'scale' => 'true',
		'zoom_pancontrol' => 'true',		
	), $atts));
	$popup = '';
	static $nightrock_map_counter = 1;

	if($scrollwheel == 'yes') {
		$scrollwheel = 'true';
	} elseif($scrollwheel == 'no') {
		$scrollwheel = 'false';
	}

	if($scale == 'yes') {
		$scale = 'true';
	} elseif($scale == 'no') {
		$scale = 'false';
	}

	if($zoom_pancontrol == 'yes') {
		$zoom_pancontrol = 'true';
	} elseif($zoom_pancontrol == 'no') {
		$zoom_pancontrol = 'false';
	}

	if($popup == 'yes') {
		$popup = 'true';
	} elseif($popup == 'no') {
		$popup = 'false';
	}

	$address = addslashes($address);
	$addresses = explode('|', $address);

	$markers = '';
	$marker_counter = 0;
	foreach($addresses as $address_string) {
		$markers .= "{
			id: 'gmap-".esc_js($nightrock_map_counter)."-".esc_js($marker_counter)."',
			address: '".esc_js($address_string)."',
			html: {
				content: '".esc_js($address_string)."',
				
			}
		},";
		$marker_counter++;
	}

	if(!$data['status_gmap']) {

		$html = "<script type='text/javascript'>
		jQuery(document).ready(function($) {
			window['gmap-".esc_js($nightrock_map_counter)."'] = {
				address: '".esc_js($addresses[0])."',
				zoom: ".esc_js($zoom).",
				scrollwheel: ".esc_js($scrollwheel).",
				scaleControl: ".esc_js($scale).",
				navigationControl: ".esc_js($zoom_pancontrol).",
				maptype: '".esc_js($type)."',
				markers: [".$markers."]
			};
			jQuery('#gmap-".esc_js($nightrock_map_counter)."').goMap({
				address: '".esc_js($addresses[0])."',
				zoom: ".esc_js($zoom).",
				scrollwheel: ".esc_js($scrollwheel).",
				scaleControl: ".esc_js($scale).",
				navigationControl: ".esc_js($zoom_pancontrol).",
				maptype: '".esc_js($type)."',
				markers: [".$markers."]
			});
		});
		</script>";
	}
	wp_enqueue_script('kf-gomap-api', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key='.esc_attr($kode_theme_option['google-map-api']).'');
	wp_register_script('kf-gomap', KODE_PATH.'/framework/include/frontend_assets/default/js/gomap.js', false, '1.0', true);
	wp_enqueue_script('kf-gomap');		
	$html .= '<div class="kode_shortcode-map" id="gmap-'.esc_attr($nightrock_map_counter).'" style="width:'.esc_attr($width).';height:'.esc_attr($height).';">';
	$html .= '</div>';

	$nightrock_map_counter++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counters (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('counters_circle', 'kode_shortcode_counters_circle');
function kode_shortcode_counters_circle($atts, $content = null) {
	$html = '<div class="counters-circle clearfix">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counters (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('code', 'kode_shortcode_code');
function kode_shortcode_code($atts, $content = null) {
	$html = '<div class="code">';
	$html .= $content;
	$html .= '</div>';

	return $html;
}
//////////////////////////////////////////////////////////////////
// Social Sharing Box
//////////////////////////////////////////////////////////////////
add_shortcode('sharing', 'kode_shortcode_sharing');
function kode_shortcode_sharing($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'tagline' => '',
		'title' => '',
		'link' => '',
		'description' => '',
		'backgroundcolor' => '',
		'pinterest_image' => ''
	), $atts));

	if(!$backgroundcolor) {
		$backgroundcolor = $data['social_bg_color'];
	}

	$nofollow = '';
	if($data['nofollow_social_links']) {
		$nofollow = ' rel="nofollow"';
	}

	$html = '<div class="share-box" style="background-color:'.esc_attr($backgroundcolor).';">
		<h4>'.esc_attr($tagline).'</h4>
		<ul class="social-networks social-networks-'.esc_attr(strtolower($data['socialbox_icons_color'])).'">';
			if($data['sharing_facebook']):
			$html .= '<li class="facebook">
				<a href="http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;='.esc_url($link).'&p&#91;images&#93;&#91;0&#93;=http://www.gravatar.com/avatar/2f8ec4a9ad7a39534f764d749e001046.png&p&#91;title&#93;='.esc_attr($title).'" target="_blank"'.esc_attr($nofollow).'>
					Facebook
				</a>
				<div class="popup">
					<div class="holder">
						<p>Facebook</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_twitter']):
			$html .= '<li class="twitter">
				<a href="http://twitter.com/home?status='.esc_attr($title).' '.esc_url($link).'" target="_blank"'.esc_attr($nofollow).'>
					Twitter
				</a>
				<div class="popup">
					<div class="holder">
						<p>Twitter</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_linkedin']):
			$html .= '<li class="linkedin">
				<a href="http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url($link).'&amp;title='.esc_attr($title).'" target="_blank"'.esc_attr($nofollow).'>
					LinkedIn
				</a>
				<div class="popup">
					<div class="holder">
						<p>LinkedIn</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_reddit']):
			$html .= '<li class="reddit">
				<a href="http://reddit.com/submit?url='.esc_url($link).'&amp;title='.esc_attr($title).'" target="_blank"'.esc_attr($nofollow).'>
					Reddit
				</a>
				<div class="popup">
					<div class="holder">
						<p>Reddit</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_tumblr']):
			$html .= '<li class="tumblr">
				<a href="http://www.tumblr.com/share/link?url='.esc_url(urlencode($link)).'&amp;name='.esc_attr(urlencode($title)).'&amp;description='.esc_url(urlencode($description)).'" target="_blank"'.esc_attr($nofollow).'>
					Tumblr
				</a>
				<div class="popup">
					<div class="holder">
						<p>Tumblr</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_google']):
			$html .= '<li class="google">
				<a href="https://plus.google.com/share?url='.esc_url($link).'" onclick="javascript:window.open(this.href,
  \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" target="_blank"'.esc_attr($nofollow).'>
					Google +1
				</a>
				<div class="popup">
					<div class="holder">
						<p>Google +1</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_pinterest']):
			$html .= '<li class="tf-pinterest">
				<a href="http://pinterest.com/pin/create/button/?url='.esc_url(urlencode($link)).'&amp;description='.esc_attr(urlencode($title)).'&amp;media='.esc_url(urlencode($pinterest_image)).'" target="_blank"'.esc_attr($nofollow).'>
					Pinterest
				</a>
				<div class="popup">
					<div class="holder">
						<p>Pinterest</p>
					</div>
				</div>
			</li>';
			endif;
			if($data['sharing_email']):
			$html .= '<li class="email">
				<a href="mailto:?subject='.esc_attr($title).'&amp;body='.esc_url($link).'">
					Email
				</a>
				<div class="popup">
					<div class="holder">
						<p>Email</p>
					</div>
				</div>
			</li>';
			endif;
		$html .= '</ul>
	</div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Attatchment ID helper functions
//////////////////////////////////////////////////////////////////
function tf_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$attachment_id = false;

	if ( '' == $attachment_url ) {
		return;
 	}

	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', esc_url($attachment_url) );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', esc_url($attachment_url) );

		// Run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	}
	return $attachment_id;
}

function kickoff_mailchimp_subscriber_status( $email, $status, $list_id, $api_key, $merge_fields = array('FNAME' => '','LNAME' => '') ){
	$data = array(
		'apikey'        => $api_key,
		'email_address' => $email,
		'status'        => $status,
		'merge_fields'  => $merge_fields
	);
	$mch_api = curl_init(); // initialize cURL connection
 
	curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
	curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
	curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
	curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
	curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
	curl_setopt($mch_api, CURLOPT_POST, true);
	curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
 
	$result = curl_exec($mch_api);
	return $result;
}

function kickoff_newsletter_mailchimp(){
	global $kode_theme_option;

	$email = $_POST['email'];
	$status = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
	$list_id = $kode_theme_option['mail-chimp-listid']; // where to get it read above
	$api_key = $kode_theme_option['mail-chimp-api']; // where to get it read above
	$merge_fields = array('FNAME' => 'support','LNAME' => 'kodeforest');
	$result = json_decode(kickoff_mailchimp_subscriber_status($email, $status, $list_id, $api_key, $merge_fields ),true);
	if( $result['status'] == 400 ){
		echo json_encode(array('fail'=>false, 'message'=>$result['detail']));			
	} elseif( $result['status'] == 'subscribed' ){
		echo json_encode(array('success'=>true, 'message'=>'Thank you. You have subscribed successfully'));
	}else{
		echo json_encode(array('fail'=>false, 'message'=>'mailchimp not working!'));			
	}

	die();
}


function kickoff_ajax_newsletter_mailchimp(){

	wp_register_script('kode-news-ltr', KODE_PATH.'/js/newsletter.js', array('jquery') ); 
	wp_enqueue_script('kode-news-ltr');

	wp_localize_script( 'kode-news-ltr', 'ajax_login_object', array( 'loadingmessage' => esc_html__('Sending user info, please wait...','kickoff')));

	// Enable the user with no privileges to run newsletter_mailchimp() in AJAX
	add_action( 'wp_ajax_nopriv_newsletter_mailchimp', 'kickoff_newsletter_mailchimp' );
	add_action( 'wp_ajax_newsletter_mailchimp', 'kickoff_newsletter_mailchimp' );
}	

// Execute the action only if the user isn't logged in
add_action('init', 'kickoff_ajax_newsletter_mailchimp');		
