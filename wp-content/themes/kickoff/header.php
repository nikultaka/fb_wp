<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php 
		global $kode_post_option;
		$kode_theme_option = get_option(KODE_SMALL_TITLE . '_admin_option', array());	
		
		$mega_menu = get_option('mega_main_menu_options');
		$menu_class = '';		
		if(is_array($mega_menu)){
			if(in_array('main_menu',$mega_menu['mega_menu_locations'])){
				$menu_class = 'kode_mega_menu';
			}
		}
		$kode_onepage = '';
		if(isset($kode_theme_option['enable-one-page-header-navi'])){
			if($kode_theme_option['enable-one-page-header-navi'] == 'enable'){
				$kode_onepage = 'nav_one_page';
			}
		}
		
		$header_class = '';
		$header_sticky = '';
		if(isset($kode_theme_option['enable-sticky-menu'])){
			if($kode_theme_option['enable-sticky-menu'] == 'enable'){
					$header_sticky = 'header-sticky';
			}
		}
		
		
		$select_club = '';
		if(isset($kode_theme_option['select_club']) && $kode_theme_option['select_club'] <> ''){
			$select_club = 'kode-'.$kode_theme_option['select_club'];
		}
		
		$header_class = $header_sticky.' ' .$menu_class .' '.$kode_onepage.' '.$select_club;
		if(!isset($kode_theme_option['enable-sticky-class']) && $kode_theme_option['enable-sticky-class'] == ''){
			$kode_theme_option['enable-sticky-class'] = '.header_sticky_nav';
		}
		wp_head(); 
		?>
</head>
<?php 
if( !empty($kode_theme_option['body-background-image']) && is_numeric($kode_theme_option['body-background-image']) ){
		$alt_text = get_post_meta($kode_theme_option['body-background-image'] , '_wp_attachment_image_alt', true);	
		$image_src = wp_get_attachment_image_src($kode_theme_option['body-background-image'], 'full');
		$img = esc_url($image_src[0]);
		$style_img = 'background:url('.$img.') !important; background-repeat:no-repeat; background-size:cover';
	}else if( !empty($kode_theme_option['body-background-image']) ){
		$img = esc_url($kode_theme_option['body-background-image']);
		$style_img = 'background:url('.$img.') !important; background-repeat:no-repeat; background-size:cover';
	}
	else{
		$style_img ='';
	}

?>
<body style="" <?php body_class($header_class);?> id="home">
<div class="body-wrapper" data-sticky="<?php echo esc_attr($kode_theme_option['enable-sticky-class'])?>" data-home="<?php echo esc_url(home_url('/')); ?>" >
	<?php 	
	if(isset($kode_post_option['enable-header-top']) && $kode_post_option['enable-header-top'] == 'disable'){
		
	}else{
		kode_get_selected_header($kode_post_option,$kode_theme_option);
	}
	?>
	<?php get_template_part( 'header', 'title' ); ?>
	<div class="content-wrapper">