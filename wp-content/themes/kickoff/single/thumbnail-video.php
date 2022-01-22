<?php
/**
 * The template for displaying video post format
 */
 
	if( !is_single() ){ 
		global $kode_post_settings; 
	}else{
		global $kode_post_settings, $kode_theme_option;
	}

	$post_format_data = '';
	$content = trim(get_the_content(esc_html__('Read More', 'kickoff')));	
	if(preg_match('#^https?://\S+#', $content, $match)){ 		
		if( is_single() || $kode_post_settings['blog-style'] == 'blog-full' ){
			$post_format_data = kode_get_video($match[0], 'full');
		}else{
			$post_format_data = kode_get_video($match[0], $kode_post_settings['thumbnail-size']);
			
		}
		$kode_post_settings['content'] = substr($content, strlen($match[0]));				
	}else if(preg_match('#^\[video\s.+\[/video\]#', $content, $match)){ 
		$post_format_data = do_shortcode($match[0]);
		$kode_post_settings['content'] = substr($content, strlen($match[0]));
	}else if(preg_match('#^\[embed.+\[/embed\]#', $content, $match)){ 
		global $wp_embed; 
		$post_format_data = $wp_embed->run_shortcode($match[0]);
		$kode_post_settings['content'] = substr($content, strlen($match[0]));
	}else{
		$kode_post_settings['content'] = $content;
	}

	if ( !empty($post_format_data) ){
		echo '<div class="kode-blog-thumbnail kode-video">' . $post_format_data . '</div>';
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
		if(!empty($k_post_option['kode_video'])){
			echo '<div class="kode-blog-thumbnail kode-video">' . kode_get_video($k_post_option['kode_video'],$thumbnail_size).'</div>';	
		}
	}
?>	

