<?php
/*
 * The template for displaying a header title section
 */
	
	
	global $kode_theme_option, $kode_post_option;	
	$header_selected_class = '';
	$header_background = '';
	$kode_post_option = kode_decode_stopbackslashes(get_post_meta(get_the_ID(), 'post-option', true ));
	if( !empty($kode_post_option) ){
		$kode_post_option = json_decode( $kode_post_option, true );					
	}
	if(isset($kode_post_option['header-background'])){
		if( is_numeric($kode_post_option['header-background']) ){
			$image_src = wp_get_attachment_image_src($kode_post_option['header-background'], 'full');	
			$header_background = ' style="background-image: url(\'' . esc_url($image_src[0]) . '\');" ';		
		}else{
			if(esc_url($kode_post_option['header-background']) <> ''){
				$header_background = ' style="background-image: url(\'' . esc_url($kode_post_option['header-background']) . '\');" ';
			}else{
				// $header_background = ' style="background-image: url(\'' . KODE_PATH . '/images/subheader-bg.jpg\');" ';
			}		
		}
	}else{
		$header_background = '';
	}
	
	$kode_theme_option['kode-header-style'] = kode_get_selected_header_class($kode_post_option,$kode_theme_option);
	$page_caption = '';
	
?>
	<?php if( is_page() && (empty($kode_post_option['show-sub']) || $kode_post_option['show-sub'] != 'disable') ){ ?>
	<?php $page_background = ''; $page_title = get_the_title(); 
	if(!empty($kode_post_option['page-caption'])){ $page_caption = $kode_post_option['page-caption'];} ?>
		<div <?php echo esc_attr($header_background); ?>  class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo esc_attr(kode_text_filter($page_title)); ?></h2>
							<?php if( !empty($page_caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
					<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
						<?php kode_get_breadcumbs();?>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
	<?php }else if( is_single() && $post->post_type == 'post' ){ 
	
		if( !empty($kode_post_option['page-title']) ){
			$page_title = $kode_post_option['page-title'];
			$page_caption = $kode_post_option['page-caption'];
		}else{
			$page_title = '';
			$page_caption = '';
		} 
	?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo esc_attr(kode_text_filter($page_title)); ?></h2>
							<?php if( !empty($page_caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	<?php }else if( is_single() ){ // for custom post type
		
		$page_title = get_the_title();
		if( !empty($kode_post_option) && !empty($kode_post_option['page-caption']) ){
			$page_caption = $kode_post_option['page-caption'];
		}else if($post->post_type == 'portfolio' && !empty($kode_theme_option['page-caption']) ){
			$page_caption = $kode_theme_option['portfolio-caption'];		
		}
	?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo esc_attr(kode_text_filter($page_title)); ?></h2>
							<?php if( !empty($page_caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>	
	<?php }else if( is_404() ){ ?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php esc_html_e('404', 'kickoff'); ?></h2>
							<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	<?php }else if( is_archive() || is_search() ){
		if( is_search() ){
			$title = esc_html__('Search Results', 'kickoff');
			$caption = get_search_query();
		}else if( is_category() || is_tax('portfolio_category') || is_tax('product_cat') ){
			$title = esc_html__('Category','kickoff');
			$caption = single_cat_title('', false);
		}else if( is_tag() || is_tax('portfolio_tag') || is_tax('product_tag') ){
			$title = esc_html__('Tag','kickoff');
			$caption = single_cat_title('', false);
		}else if( is_day() ){
			$title = esc_html__('Day','kickoff');
			$caption = get_the_date('F j, Y');
		}else if( is_month() ){
			$title = esc_html__('Month','kickoff');
			$caption = get_the_date('F Y');
		}else if( is_year() ){
			$title = esc_html__('Year','kickoff');
			$caption = get_the_date('Y');
		}else if( is_author() ){
			$title = esc_html__('By','kickoff');
			
			$author_id = get_query_var('author');
			$author = get_user_by('id', $author_id);
			$caption = $author->display_name;					
		}else if( is_post_type_archive('product') ){
			$title = esc_html__('Shop', 'kickoff');
			$caption = '';
		}else{
			$title = get_the_title();
			$caption = '';
		}
	?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo esc_attr(kode_text_filter($title)); ?></h2>
							<?php if( !empty($caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>	
	<?php }else if( is_single() ){ // for custom post type
		
		$page_title = get_the_title();
		if( !empty($kode_post_option) && !empty($kode_post_option['page-caption']) ){
			$page_caption = $kode_post_option['page-caption'];
		}else if($post->post_type == 'portfolio' && !empty($kode_theme_option['page-caption']) ){
			$page_caption = $kode_theme_option['portfolio-caption'];		
		}
	?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo esc_attr(kode_text_filter($page_title)); ?></h2>
							<?php if( !empty($page_caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>	
	<?php }else if(get_post_type() == 'bp_member'){ 
		$page_title = get_the_title();
		if( !empty($kode_post_option) && !empty($kode_post_option['page-caption']) ){
			$page_caption = $kode_post_option['page-caption'];
		}else if($post->post_type == 'portfolio' && !empty($kode_theme_option['page-caption']) ){
			$page_caption = $kode_theme_option['portfolio-caption'];		
		}
	?>
		<div <?php echo esc_attr($header_background); ?> class="kode-subheader subheader-height subheader <?php echo esc_attr($kode_theme_option['kode-header-style']);?>">
			
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="page-info">
							<h2><?php echo kode_text_filter($page_title); ?></h2>
							<?php if( !empty($page_caption) ){ ?>
								<!--<p><?php echo esc_attr(kode_text_filter($page_caption)); ?></p>-->
							<?php }?>
						</div>
					</div>
					<div class="col-md-6">
						<?php if($kode_theme_option['enable-breadcrumbs'] == 'enable'){ ?>
							<?php kode_get_breadcumbs();?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>	
		<?php
	}
	?>
	<!-- is search -->