<?php
/**
 * The template for displaying audio post format
 */
	if( !is_single() ){ 
		global $kode_post_settings; 
	}else{
		global $kode_post_settings, $kode_theme_option;
	}
	
	$post_format_data = '';
	$content = trim(get_the_content(esc_html__('Read More', 'kickoff')));		
	if(preg_match('#^https?://\S+#', $content, $match)){ 				
		$post_format_data = do_shortcode('[audio src="' . $match[0] . '" ][/audio]');
		$kode_post_settings['content'] = substr($content, strlen($match[0]));					
	}else if(preg_match('#^\[audio\s.+\[/audio\]#', $content, $match)){ 
		$post_format_data = do_shortcode($match[0]);
		$kode_post_settings['content'] = substr($content, strlen($match[0]));
	}else{
		$kode_post_settings['content'] = $content;
	}	

	if ( !empty($post_format_data) ){
		echo '<div class="kode-blog-thumbnail kode-audio">' . $post_format_data . '</div>';
	}else{
		$k_post_option = json_decode(get_post_meta($post->ID, 'post-option', true), true);		
		
		$thumbnail_size = (empty($kode_post_settings['thumbnail-size']))? $kode_theme_option['kode-post-thumbnail-size']: $kode_post_settings['thumbnail-size'];
		
		//Get Thumbnail Width and Height
		$kode_img_size = kode_get_video_size($thumbnail_size);
		$kode_width = $kode_img_size['width'];
		$kode_height = $kode_img_size['height'];
		
		// Get Slider Images
		$k_post_option['slider'] = (empty($k_post_option['slider']))? ' ': $k_post_option['slider'];
		$raw_slider_data = kode_decode_stopbackslashes($k_post_option['slider']);	
		$filter_slider_data = json_decode(kode_stripslashes($raw_slider_data), true);		
		
		//Get Media Type Selected
		$k_post_option['post_media_type'] = (empty($k_post_option['post_media_type']))? ' ': $k_post_option['post_media_type'];
		if(!empty($k_post_option['kode_audio'])){
			if(strpos($k_post_option['kode_audio'],'soundcloud')){
				echo '<div class="kode-blog-thumbnail kode-audio">' . do_shortcode('[soundcloud url="'.esc_url($k_post_option['kode_audio']).'" comments="yes" auto_play="no" color="#ff7700" width="100%" height="'.esc_attr($kode_height).'px"][/soundcloud]') . '</div>';				
			}else{				
				$kode_get_image = kode_get_image(get_post_thumbnail_id(), esc_attr($thumbnail_size), true);
				if(!empty($kode_get_image)){
					echo '<div class="kode-blog-thumbnail">';
						if( is_single() ){
								echo kode_get_image(get_post_thumbnail_id(), $thumbnail_size, true);	
								echo '<div class="kode-blog-thumbnail kode-audio">' . do_shortcode('[audio mp3="'.$k_post_option['kode_audio'].'"][/audio]') . '</div>';
						}else{
							$temp_option = json_decode(get_post_meta(get_the_ID(), 'post-option', true), true);
							echo kode_get_image(get_post_thumbnail_id(), $thumbnail_size,true);
							echo '<div class="kode-blog-thumbnail kode-audio">' . do_shortcode('[audio mp3="'.$k_post_option['kode_audio'].'"][/audio]') . '</div>';							
							if( is_sticky() ){
								echo '<div class="kode-sticky-banner">';
								echo '<i class="fa fa-bullhorn" ></i>';
								echo esc_html__('Sticky Post', 'kickoff');
								echo '</div>';
							}
						}						
					echo '</div>';
				}else{
					if(!empty($k_post_option['kode_audio'])){
						echo '<div class="kode-blog-thumbnail kode-audio">' . do_shortcode('[audio mp3="'.$k_post_option['kode_audio'].'"][/audio]') . '</div>';
					}
				}
				
			}
		}
	} 
			
			
?>	
