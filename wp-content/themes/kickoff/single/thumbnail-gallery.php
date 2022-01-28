<?php
/**
 * The template for displaying video post format
 */
	global $kode_post_settings; 
	
	$post_format_data = '';
	$content = trim(get_the_content(esc_html__( 'Read More', 'kickoff' )));	
	if(preg_match('#\[gallery[^\]]+]#', $content, $match)){ 
		if( is_single() ){
			$post_format_data = do_shortcode($match[0]);
		}else{
			preg_match('#\[gallery.+ids\s?=\s?\"([^\"]+).+]#', $match[0], $match2);
			$post_format_data = kode_get_bx_slider(explode(',', $match2[1]), array('size'=>$kode_post_settings['thumbnail-size']));
		}
		$kode_post_settings['content'] = substr($content, strlen($match[0]));
	}else{
		$kode_post_settings['content'] = $content;
	}

	if ( !empty($post_format_data) ){
		echo '<div class="kode-blog-thumbnail kode-gallery">' . $post_format_data . '</div>';
	} 
?>	
			