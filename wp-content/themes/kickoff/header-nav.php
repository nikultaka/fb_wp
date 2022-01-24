<?php 
	global $kode_theme_option;

	echo '<div class="kode-navigation-wrapper">';

	// navigation
	if( has_nav_menu('main_menu') ){
		if( class_exists('kode_menu_walker') ){
			echo '<nav class="navigation" id="kode-main-navigation">';
			wp_nav_menu( array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-menu kode-main-menu',
				'walker'=> new kode_menu_walker() 
			) );
			echo '</nav>'; // kode-navigation
		}else{
			$mega_menu = get_option('mega_main_menu_options');
			if(is_array($mega_menu)){
				if(!in_array('main_menu',$mega_menu['mega_menu_locations'])){
					echo '<nav class="navigation">';
					wp_nav_menu( array('theme_location'=>'main_menu') );
					echo '</nav>'; // kode-navigation
				}else{
					wp_nav_menu( array('theme_location'=>'main_menu') );
				}
			}else{
				echo '<nav class="navigation">';
				wp_nav_menu( array('theme_location'=>'main_menu') );
				echo '</nav>'; // kode-navigation
			}
		}
		
		
	}else{
		$args = array(
		'sort_column' => 'menu_order, post_title',
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'show_home'   => false,
		'menu'            => '', 
		'container'       => '', 
		'link_before' => '',
		'link_after'  => '' );
		echo '<nav class="navigation" id="kode-main-navigation">';
			wp_page_menu( $args );
		echo '</nav>';
	
	}
	
	echo '<div class="clear"></div>';
	echo '</div>'; // kode-navigation-wrapper
?>