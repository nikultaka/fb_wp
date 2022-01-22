<?php
/**
 * The template for displaying image post format
 */
	global $kode_post_settings; 

	$post_format_data = '';
	$content = trim(get_the_content(esc_html__( 'Read More', 'kickoff' )));
	if(preg_match('#^<a.+<img.+/></a>|^<img.+/>#', $content, $match)){ 
		$post_format_data = $match[0];
		$kode_post_settings['content'] = substr($content, strlen($match[0]));
	}else if(preg_match('#^https?://\S+#', $content, $match)){
		$post_format_data = kode_get_image($match[0], 'full', true);
		$kode_post_settings['content'] = substr($content, strlen($match[0]));					
	}else{
		$kode_post_settings['content'] = $content;
	}
	
	if ( !empty($post_format_data) ){
		echo '<div class="kode-blog-thumbnail">';
		echo esc_attr($post_format_data); 
		
		if( !is_single() && is_sticky() ){
			echo '<div class="kode-sticky-banner">';
			echo '<i class="icon-bullhorn" ></i>';
			echo esc_html__('Sticky Post', 'kickoff');
			echo '</div>';
		}					
		echo '</div>';
		echo '<figcaption><a href="'.esc_url(get_permalink()).'"><i class="fa fa-plus"></i></a></figcaption>';
	} 
	?>	
