<?php
	if( in_array(get_post_format(), array('aside', 'link', 'quote')) ){
		get_template_part('single/content', get_post_format());
	}else{
		
		global $kode_post_settings;
		if( empty($kode_post_settings['blog-style']) || $kode_post_settings['blog-style'] == 'blog-full' ){
			get_template_part('single/content-full');
		}else if( $kode_post_settings['blog-style'] == 'blog-medium' ){
			get_template_part('single/content-medium');
		}else if( strpos($kode_post_settings['blog-style'], 'blog-small') !== false ){
			get_template_part('single/content-small');
		}else if( strpos($kode_post_settings['blog-style'], 'blog-simple') !== false ){
			get_template_part('single/content-simple');
		}else if( strpos($kode_post_settings['blog-style'], 'blog-modern') !== false ){
			get_template_part('single/content-grid-modern');
		}else{
			get_template_part('single/content-grid');
		}
		
	} 
?>