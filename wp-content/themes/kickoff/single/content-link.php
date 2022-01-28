<?php
/**
 * The template for displaying link post format
 */

	if( !is_single() ){ 
		global $kode_post_settings; 
		if($kode_post_settings['excerpt'] < 0) global $more; $more = 0;
	}	

	$post_format_data = '';
	$content = trim(get_the_content(esc_html__( 'Read More', 'kickoff' )));
	if(preg_match('#^<a.+href=[\'"]([^\'"]+).+</a>#', $content, $match)){ 
		$post_format_data = $match[1];
		$content = substr($content, strlen($match[0]));
	}else if(preg_match('#^https?://\S+#', $content, $match)){
		$post_format_data = $match[0];
		$content = substr($content, strlen($match[0]));
	}	
	
	if( !is_single() ){ 
		global $kode_post_settings; 
		if($kode_post_settings['excerpt'] < 0) global $more; $more = 0;
	}else{
		global $kode_post_settings, $kode_theme_option;
	}
	
	if(!isset($kode_post_settings['title-num-fetch']) && empty($kode_post_settings['title-num-fetch'])){
		$kode_post_settings['title-num-fetch'] = '21';
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kode-time-zoon">
		<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
		<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h5>
	</div>
	<?php get_template_part('single/thumbnail', get_post_format()); ?>
	<div class="kode-blog-info">
		<ul class="kode-blog-options">
			<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
		</ul>
		<?php kode_get_social_shares()?>		
		<div class="clearfix clear"></div>
		<?php 
			if( is_single() || $kode_post_settings['excerpt'] < 0 || $kode_post_settings['excerpt'] == 'full'){
				echo '<div class="kode-blog-content">';
				echo kode_content_filter($kode_post_settings['content'], true);
				wp_link_pages( array( 
					'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kickoff' ) . '</span>', 
					'after' => '</div>', 
					'link_before' => '<span>', 
					'link_after' => '</span>' )
				);
				echo '</div>';
			}else if( $kode_post_settings['excerpt'] != 0 ){
				echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>
				<a href="' . esc_url(get_permalink()) . '" class="kode-modrenbtn thbg-colorhover">' . esc_html__( 'Read More', 'kickoff' ) . '</a>
			</div>';
				
			}
		?>	
	</div>
</article><!-- #post -->