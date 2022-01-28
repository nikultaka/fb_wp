<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings; 
	$kode_post_settings['thumbnail-size'] = 'kode-small-grid-size';
?>
<article id="blog-med-<?php the_ID(); ?>" <?php post_class('kode_medium'); ?>>
  <div class="medium-wrap">
	<figure><?php get_template_part('single/thumbnail', get_post_format()); ?>
		<figcaption>
			<div class="datetime"> <i class="fa fa-photo"></i> </div>
		</figcaption>
	</figure>
	<div class="kode-blog-info">
	  <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr(substr(get_the_title(),0,$kode_post_settings['title-num-fetch'])); ?></a></h3>
	  <div class="kode-blog-post">
		<ul>
			<?php echo kode_get_blog_info(array( 'author','category') ,false,'' ,'li'); ?>		
		</ul>
	  </div>
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
				echo '<div class="kode-blog-content"><p>' . esc_attr(substr(get_the_excerpt(),0,114)) . '</p>';				
				echo '</div>';
			}
		?>			  
	  <div class="blog-timeinfo">
		<div class="datetime"><i class="fa fa-clock-o"></i> <?php echo esc_attr(get_the_date());?></div>
		<a href="<?php echo esc_url(get_permalink());?>" class="blogmore-btn thcolor th-bordercolor thbg-colorhover"><?php esc_html_e('Read More','kickoff');?></a>
	  </div>
	</div>
  </div>
</article>