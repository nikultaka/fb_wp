<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new kodeforest_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="kodeforest-popup">

	<div id="kodeforest-shortcode-wrap">

		<div id="kodeforest-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => 'Choose a Shortcode',
					'accordion' => 'Accordion',
					'alert' => 'Alert',
					//'albums' => 'Albums',
					//'blog' => 'Blog',
					'button' => 'Button',
					'checklist' => 'Checklist',
					'calltoaction' => 'Call To Action',
					//'clientslider' => 'Client Slider',
					'columns' => 'Columns',
					//'contentboxes' => 'Content Boxes',
					//'counter_circle' => 'Event Counters Circle',
					//'countersbox' => 'Counters Box',
					'dropcap' => 'Dropcap',
					'kode_donation' => 'Donation',					
					//'events' => 'Events',
					//'flexslider' => 'Flexslider',
					'fontawesome' => 'Icons',
					'facts' => 'Project Facts',
					//'fullwidth' => 'Full Width Container',
					'googlemap' => 'Google Map',
					'kode_image_gallery' => 'Image Gallery',
					'highlight' => 'Highlight',
					'heading' => 'Headings',					
					//'imageframe' => 'Image Frame',
					//'imagecarousel' => 'Image Carousel',
					//'lightbox' => 'Lightbox',
					//'menuanchor' => 'Menu Anchor',
					//'member' => 'Member',
					//'news_slider' => 'News/Blog Slider',
					'newsletter' => 'Newsletter',
					'our_clients' => 'Our Clients',
					//'pricingtable' => 'Pricing Table',
					'progressbar' => 'Progress Bar',
					//'recent_post' => 'Recent Posts',
					//'recentworks' => 'Recent Works',
					// 'services' => 'Services',
					'separator' => 'Separator',
					//'sharingbox' => 'Sharing Box',
					//'slider' => 'Slider',
					'soundcloud' => 'SoundCloud',
					'social_network' => 'Social Network',
					//'theme_button' => 'Theme Button',
					//'teams' => 'Teams',
					'timeline' => 'TimeLine',
					'social_icons' => 'Social Icons',
					'skill' => 'Skill Circle',
					'list_items' => 'List Icons',
					'tabs' => 'Tabs',
					'table' => 'Table',
					//'taglinebox' => 'Tagline Box',
					//'testimonials' => 'Testimonials',
					//'title' => 'Title',
					//'toggles' => 'Toggles',
					//'tooltip' => 'Tooltip',
					'vimeo' => 'Vimeo',
					//'woofeatured' => 'Woocommerce Featured Products Slider',
					//'wooproducts' => 'Woocommerce Products Slider',
					'youtube' => 'Youtube'
			);
			?>
			<table id="kodeforest-sc-form-table" class="kodeforest-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label">Choose Shortcode</td>
						<td class="field">
							<div class="kodeforest-form-select-field">
							<!--<div class="kodeforest-shortcodes-arrow">&#xf107;</div>-->
								<select name="kodeforest_select_shortcode" id="kodeforest_select_shortcode" class="kodeforest-form-select kodeforest-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="kodeforest-sc-form">

				<table id="kodeforest-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="kodeforest-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="kodeforest-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#kodeforest-sc-form-table -->

			</form>
			<!-- /#kodeforest-sc-form -->

		</div>
		<!-- /#kodeforest-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#kodeforest-shortcode-wrap -->

</div>
<!-- /#kodeforest-popup -->

</body>
</html>