<?php
/**
 * The default template for displaying standard post format
 */

	if( !is_single() ){ 
		global $kode_post_settings; 
		if($kode_post_settings['excerpt'] < 0) global $more; $more = 0;
	}else{
		global $kode_post_settings, $kode_theme_option;
	}
	
	if(!isset($kode_post_settings['title-num-fetch']) && empty($kode_post_settings['title-num-fetch'])){
		$kode_post_settings['title-num-fetch'] = '100';
	}
	if($kode_post_settings['title-num-fetch'] == '-1'){
		$post_title = esc_attr(get_the_title());
	}else{
		$post_title = esc_attr(substr(get_the_title(),0,$kode_post_settings['title-num-fetch']));
	}
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kode-time-zoon">
		<time class="datetime"><?php echo esc_attr(get_the_date('d'));?><span><?php echo esc_attr(get_the_date('M'));?></span></time>
		<h5><a href="<?php echo esc_attr(get_permalink());?>"><?php echo esc_attr($post_title);?></a></h5>
	</div>
	<?php get_template_part('single/thumbnail', get_post_format()); ?>
	<div class="kode-blog-info">
		<?php if(get_the_title() <> ''){ ?>
			<ul class="kode-blog-options">
				<?php if( is_sticky(get_the_ID()) ){ ?>
					<li class="blog-info blog-date"><i class="fa fa-bullhorn"></i> <a href="<?php echo esc_url(get_permalink())?>"> <?php esc_html_e('Featured','kickoff');?></a></li>
					<li class="blog-info blog-time"><i class="fa fa-calendar"></i><a href="<?php echo esc_url(get_permalink())?>"><?php echo esc_html(get_the_date(get_option('date_format')));?></a></li>
				<?php }else{ ?>
					<li class="blog-info blog-time"><i class="fa fa-calendar"></i><a href="<?php echo esc_url(get_permalink())?>"><?php echo esc_html(get_the_date(get_option('date_format')));?></a></li>
				<?php }?>
				<?php echo kode_get_blog_info(array('author','comment'), false, '','li');?>
			</ul>
		<?php }else{ ?>
			<ul class="kode-blog-options">
				<?php if( is_sticky(get_the_ID()) ){ ?>
					<li class="blog-info blog-date"><i class="fa fa-bullhorn"></i> <a href="<?php echo esc_url(get_permalink())?>"> <?php esc_html_e('Featured','baldiyaat');?></a></li>
					<li class="blog-info blog-time"><i class="fa fa-calendar"></i><a href="<?php echo esc_url(get_permalink())?>"><?php echo esc_html(get_the_date(get_option('date_format')));?></a></li>
				<?php }else{ ?>
					<li class="blog-info blog-time"><i class="fa fa-calendar"></i><a href="<?php echo esc_url(get_permalink())?>"><?php echo esc_html(get_the_date(get_option('date_format')));?></a></li>
				<?php }?>
				<?php echo kode_get_blog_info(array('author'), false, '','li');?>
				<?php echo kode_get_blog_info(array('comment'), false, '','li');?>
				<?php echo kode_get_blog_info(array('tag'), false, '','li');?>
			</ul>
		<?php }?>		
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