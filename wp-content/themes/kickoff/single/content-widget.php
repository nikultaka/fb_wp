<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings; 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kode-standard-style">
		<?php get_template_part('single/thumbnail', get_post_format()); ?>
		<div class="blog-date-wrapper">
			<span class="blog-date-day"><?php echo esc_attr(get_the_time('j')); ?></span>
			<span class="blog-date-saperator">•</span>
			<span class="blog-date-month"><?php echo esc_attr(get_the_time('M')); ?></span>
		</div>
		<header class="post-header">
			<h3 class="kode-blog-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr(get_the_title()); ?></a></h3>

			<?php echo kode_get_blog_info(array('author', 'comment')); ?>		
			<div class="clear"></div>
		</header><!-- entry-header -->
		<div class="clear"></div>
	</div>
</article><!-- #post -->