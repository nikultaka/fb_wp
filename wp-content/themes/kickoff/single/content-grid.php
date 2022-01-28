<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings,$post,$kode_post_option; 	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kode-time-zoon">
		<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
		<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h5>
	</div>
	<a href="<?php echo esc_attr(get_permalink());?>">
	<?php get_template_part('single/thumbnail', get_post_format()); ?>
	</a>
	<div class="kode-blog-info">
	  <ul class="kode-blog-options">
		<?php echo kode_get_blog_info(array('author','comment','category'), false, '','li');?>
	  </ul>
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
	  <div class="clearfix"></div>
	  <?php kode_get_social_shares()?>	
	</div>
</article><!-- #post -->