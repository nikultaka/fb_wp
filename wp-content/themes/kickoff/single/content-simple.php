<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings,$post,$kode_post_option; 
	
?>

<article id="blog-simple-<?php the_ID(); ?>" <?php post_class('blog-simple'); ?>>
	<div class="kode-blog-list-new">
		<div class="kode-thumb">
			<?php get_template_part('single/thumbnail', get_post_format());?>
		</div>
		<div class="kode-text">
			<div class="kode-avatar">				
				<?php echo get_avatar(get_the_author_meta('ID'), 90); ?>
			</div>
			<h2><?php echo esc_attr(get_the_date());?></h2>			
			<?php echo kode_get_blog_info(array( 'author') ,false,'' ,'p'); ?>
			<h4><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr(substr(get_the_title(),0,$kode_post_settings['title-num-fetch'])); ?></a></h4>						
		</div>
	</div>
</article>