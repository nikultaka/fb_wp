<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings,$post,$kode_post_option; 
	
?>

<article id="blog-small-<?php the_ID(); ?>" <?php post_class('blog-small'); ?>>
	<?php get_template_part('single/thumbnail', get_post_format());?>
	<div class="box-info">
		<a class="fa fa-photo box-icon" href="<?php echo esc_url(get_permalink()); ?>"></a>
		<div class="clearfix"></div>
		<h5><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr(substr(get_the_title(),0,$kode_post_settings['title-num-fetch'])); ?></a></h5>
		<div class="kode-blog-post">
			<ul>					
				<?php echo kode_get_blog_info(array( 'date','comment') ,false,'' ,'li'); ?>			
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
				echo '<div class="kode-blog-content"><p>' . esc_attr(get_the_excerpt()) . '</p>';
				echo '</div>';
			}
		?>	
	</div>	
</article>