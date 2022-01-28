<?php
/**
 * The default template for displaying standard post format
 */
	global $kode_post_settings,$post,$kode_post_option; 	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kode_football_news_fig">
		<figure>
			<?php get_template_part('single/thumbnail', get_post_format()); ?>
			<a href="<?php echo esc_url(get_permalink())?>" class="kode_football_news_search"><i class="fa fa-search-plus"></i></a>
		</figure>
		<div class="kode_football_news_caption">
			<span><?php echo esc_attr(get_the_date('m'));?><br> <?php echo esc_attr(get_the_date('d'));?></span>
			<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo substr(esc_attr(get_the_title()),0,$kode_post_settings['title-num-fetch']);?></a></h5>
			<p>Rubgy WC</p>
		</div>
		<div class="kode_football_news_icon">
			<a href="<?php echo esc_url(get_permalink())?>"><?php _e('Read More','kickoff');?></a>
			<span><i class="fa fa-heart"></i>27</span>
		</div>
	</div>
</article><!-- #post -->