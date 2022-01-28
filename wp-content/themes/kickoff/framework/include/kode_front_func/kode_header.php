<?php
	/*	
	*	Kodeforest Header File
	*	---------------------------------------------------------------------
	*	This file contains utility function in the theme
	*	---------------------------------------------------------------------
	*/
	
	
	if( !function_exists('kode_get_woo_cart') ){
		function kode_get_woo_cart(){
			if(class_exists('Woocommerce')){
				global $post,$post_id,$product,$woocommerce;	
				$currency = get_woocommerce_currency_symbol();
				if($woocommerce->cart->cart_contents_count <> 0){
					return $shopping_cart_div = '<div class="widget_shopping_cart_content"></div>';
				}else{
					return $shopping_cart_div = '<div class="widget_shopping_cart_content"></div>';
				}
			}
		}
	}
	
	
	if( !function_exists('kode_get_selected_header') ){
		function kode_get_selected_header($kode_post_option,$kode_theme_option) {
			if(isset($kode_theme_option['enable-header-option'])){
				if($kode_theme_option['enable-header-option'] == 'disable'){
					if(isset($kode_post_option['kode-header-style'])){
						$kode_theme_option['kode-header-style'] = $kode_post_option['kode-header-style'];
						kode_get_header($kode_theme_option);	
					}else{
						kode_get_header($kode_theme_option);	
					}
				}else{
				
					kode_get_header($kode_theme_option);	
				}
			}else{
				if(isset($kode_post_option['kode-header-style'])){
					$kode_theme_option['kode-header-style'] = $kode_post_option['kode-header-style'];
					kode_get_header($kode_theme_option);						
				}else{
					kode_get_header($kode_theme_option);	
				}
			}
		}
	}	
	
	if( !function_exists('kode_get_selected_header_class') ){	
		function kode_get_selected_header_class($kode_post_option,$kode_theme_option) {	
			if(isset($kode_theme_option['enable-header-option'])){
				if($kode_theme_option['enable-header-option'] == 'disable'){
					if(isset($kode_post_option['kode-header-style'])){
						$kode_theme_option['kode-header-style'] = $kode_post_option['kode-header-style'];
						return $kode_theme_option['kode-header-style'];
					}else{						
						return $kode_theme_option['kode-header-style'];
					}
				}else{
					if(!empty($kode_theme_option['kode-header-style'])){
						return $kode_theme_option['kode-header-style'];
					}else{
						return '';
					}
				}
			}else{
				if(isset($kode_post_option['kode-header-style'])){
					$kode_theme_option['kode-header-style'] = $kode_post_option['kode-header-style'];
					return $kode_theme_option['kode-header-style'];
				}else{
					return $kode_theme_option['kode-header-style'];
				}
			}
		}
	}
	
	
	if( !function_exists('kode_get_header') ){	
		function kode_get_header ($kode_theme_option) { 			
			if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-1'){ ?>
				<header id="mainheader" class="kode-header-absolute kode-header-1">
					<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<!--// TopBaar //-->
					<div class="kode-topbar-kickoff">
						<div class="container">
							<div class="row">
								<div class="col-md-6 kode_bg_white">
								<?php
								//latest news script
								if(isset($kode_theme_option['top_latest_news_btn']) && $kode_theme_option['top_latest_news_btn'] == 'enable'){
									$args = array( 'posts_per_page' => 5, 'category' => $kode_theme_option['top_latest_news'] );
									$kode_posts = get_posts($args);
									if(!empty($kode_posts)){
										echo '<ul class="bxslider">';
											foreach($kode_posts as $kode_post){
												echo '<li><span class="kode-barinfo">';
												if(isset($kode_theme_option['top_latest_news_title'])){
													echo '<strong>'.esc_attr($kode_theme_option['top_latest_news_title']).' : </strong> ';
												}
												echo '<a href="'.esc_url(get_permalink($kode_post->ID)).'">'.esc_attr($kode_post->post_title).'</a></span></li>';
											}
										echo '</ul>';
									}
								}
								?>	
								</div>
								<?php if(isset($kode_theme_option['enable-top-bar-login']) && $kode_theme_option['enable-top-bar-login'] == 'enable'){ ?>
								<div class="col-md-6">							
									<ul class="kode-userinfo">
										<?php 
										if(class_exists('Woocommerce')){
											global $woocommerce;?>									
											<li class="cart-option woocommerce">
											<span><i class="fa fa-shopping-cart"></i> <?php esc_html_e('Cart','kickoff');?> (<?php echo esc_attr($woocommerce->cart->cart_contents_count);?>)</span>
											<?php echo kode_get_woo_cart(); ?>
											</li>
										<?php }?>
										<?php if (is_user_logged_in()) {
											global $current_user;?>
											<li><a href=""><?php esc_attr_e('Welcome ','kickoff');?><?php echo esc_attr($current_user->display_name);?></a></li>
											<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
										<?php }else{ ?>
											<li><?php kode_signin_form()?></li>
											<li><?php kode_signup_form()?></li>
										<?php }?>
									</ul>
								</div>
								<?php }?>
							</div>
						</div>
					</div>
					<!--// TopBaar //-->
					<?php }?>
					<div class="header-8">
						<div class="container">
							<!--NAVIGATION START-->
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<div class="kode-navigation pull-left">
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'left' ); ?>	
								<!--Navigation Wrap End-->
							</div>
							<!--NAVIGATION END--> 
							<!--LOGO START-->	
							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" >
								<?php 
									if(empty($kode_theme_option['logo'])){ 
										echo kode_get_image(KODE_PATH . '/images/logo.png');
									}else{
										if(kode_get_image($kode_theme_option['logo']) <> ''){
											echo kode_get_image($kode_theme_option['logo']);
										}else{
											echo kode_get_image(KODE_PATH . '/images/logo.png');
										}
										
									}
								?>						
								</a>
							</div>
							<!--LOGO END-->	
							<!--NAVIGATION START-->
							<div class="kode-navigation">					
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'right' ); ?>	
								<!--Navigation Wrap End-->
							</div>
						</div>
					</div>
				</header>	
			<?php
			}else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-2'){ ?>
				<div class="header_2">
					<!--kode_football_top_wraper start-->
					<div class="kode_football_top_wraper">
						<!--container start-->
						<div class="container">
							<!--row start-->
							<div class="row">
								<div class="col-md-5">
									<?php kode_print_header_social_icon('kode_football_top_social'); ?>
								</div>
								<div class="col-md-2"></div>
								<div class="col-md-5">
									<div class="kode_football_top_login">
										<ul class="kode_football_regsiter">
											<?php if (is_user_logged_in()) {
											global $current_user;?>
											<li><a href=""><?php esc_attr_e('Welcome ','kickoff');?><?php echo esc_attr($current_user->display_name);?></a></li>
											<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
											<?php }else{ ?>
											<li><?php kode_signin_form()?></li>
											<li><?php kode_signup_form()?></li>
											<?php }?>
										</ul>
										<ul class="kode_football_icon_cart">
											<li><?php if(class_exists('Woocommerce')){ 
											global $woocommerce;
											$cart_url = $woocommerce->cart->get_cart_url();?>
												<a href="<?php echo esc_url($cart_url); ?>"><span><i class="fa fa-cart-plus"></i> <?php esc_html_e('Cart','kickoff');?> (<?php echo esc_attr($woocommerce->cart->cart_contents_count);?>)</span></a>
												<?php echo kode_get_woo_cart(); ?>
											<?php }?></li>
											<li><?php echo get_search_form();?></li>
										</ul>
									</div>
								</div>
							</div>
						<!--row end-->
						</div>
					<!--container end-->
					</div>
					<!--kode_football_top_wraper end-->
					<!--kode_football_top_navi_wraper start-->
					<div class="kode_football_top_navi_wraper">
						<!--container start-->
						<div class="container">
							<!--row start-->
							<div class="row">
								<?php
									// mobile navigation
									if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
										( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
										echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
										echo '<button class="dl-trigger">Open Menu</button>';
										wp_nav_menu( array(
											'theme_location'=>'main_menu', 
											'container'=> '', 
											'menu_class'=> 'dl-menu kode-main-mobile-menu',
											'walker'=> new kode_dlmenu_walker() 
										) );						
										echo '</div>';
									}	
								?>	
								<div class="col-md-5">
									<div class="kode_football_top_navigation">
										<?php get_template_part( 'header', 'left' ); ?>	
									</div>
								</div>
								<div class="col-md-2">
									<div class="kode_football_top_navi_fig">
										<figure>
											<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" >
											<?php 
												if(empty($kode_theme_option['logo'])){ 
													echo kode_get_image(KODE_PATH . '/images/logo.png');
												}else{
													echo kode_get_image($kode_theme_option['logo']);
												}
											?>						
											</a>
										</figure>
									</div>
								</div>
								<div class="col-md-5">
									<div class="kode_football_top_navigation_right">
										<?php get_template_part( 'header', 'right' ); ?>	
									</div>
								</div>
							</div>
						<!--row end-->
						</div>
					<!--container end-->
					</div>
				<!--kode_football_top_navi_wraper end-->
				</div>
			<?php
			}else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-3'){ ?>
				<header id="header-style-3" class="cricket-header">				
				<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<div class="crkt-topbar">
						<div class="pull-left">
							<ul>
								<?php if (is_user_logged_in()) {
								global $current_user;?>
								<li><a href="#" data-toggle="modal" data-target="#myModal"><?php _e('Login','kickoff');?></a></li>
								<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
								<?php }else{ ?>
								<li><?php kode_signin_form()?></li>
								<li><?php kode_signup_form()?></li>
								<?php }?>
							</ul>
						</div>
						<div class="crkt-search-wrap">
							<div class="crkt-search">
								<input type="text" placeholder="Enter Keywords...">
								<button><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				<?php }?>
					<div class="crkt-navigation-wrap">
						<div class="crkt-logo">
							<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" >
							<?php 
								if(empty($kode_theme_option['logo'])){ 
									echo kode_get_image(KODE_PATH . '/images/logo.png');
								}else{
									echo kode_get_image($kode_theme_option['logo']);
								}
							?>						
							</a>
						</div>
						<nav class="crkt-navigation">
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<?php get_template_part( 'header', 'nav' ); ?>
						</nav>
						<div class="crkt-social">
							<?php kode_print_header_social_icon('kode_social_icon'); ?>
						</div>
					</div>
				</header>
			<?php
			}else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-4'){ ?>
				<header class="kode_header_2">
					<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<div class="kode_top_strip2">
						<div class="container">
							<div class="kode_loc">
								<?php 
									if( !empty($kode_theme_option['top-bar-left-text']) ) {
										echo do_shortcode($kode_theme_option['top-bar-left-text']); 
									}	
								?>
							</div>
							<div class="kode_contact_icon">
								<?php 
									if( !empty($kode_theme_option['top-bar-right-text']) ) {
										echo do_shortcode($kode_theme_option['top-bar-right-text']); 
									}	
								?>
							</div>
						</div>
					</div>
					<?php }?>
					<div class="kode_nav_1 header_sticky_nav">
						<div class="container">
							<!--Logo Wrap Start-->
							<div class="kode_logo_2">
								<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" >
								<?php 
									if(empty($kode_theme_option['logo'])){ 
										echo kode_get_image(KODE_PATH . '/images/logo.png');
									}else{
										echo kode_get_image($kode_theme_option['logo']);
									}
								?>						
								</a>
							</div>
							<!--Logo Wrap End-->
							<div class="kode_heart">
							<?php
							$mega_menu = get_option('mega_main_menu_options');
							if(is_array($mega_menu)){
								if(!in_array('main_menu',$mega_menu['mega_menu_locations'])){
									//Donation Button
									if(isset($kode_theme_option['enable-donation-btn']) && $kode_theme_option['enable-donation-btn'] == 'enable'){
										if(isset($kode_theme_option['donatation_page']) && $kode_theme_option['donatation_page'] != ''){ ?>
											<?php if(get_permalink($kode_theme_option['donatation_page']) <> ''){ ?>
												<a href="<?php echo esc_url(get_permalink($kode_theme_option['donatation_page']));?>" class="kode-donate-btn thbg-color"><?php echo esc_attr($kode_theme_option['donation-btn-text']);?></a>
											<?php 
											}
										}
									}
								}
							}else{
								//Donation Button
								if(isset($kode_theme_option['enable-donation-btn']) && $kode_theme_option['enable-donation-btn'] == 'enable'){
									if(isset($kode_theme_option['donatation_page']) && $kode_theme_option['donatation_page'] != ''){ ?>
										<?php if(get_permalink($kode_theme_option['donatation_page']) <> ''){ ?>
											<a href="<?php echo esc_url(get_permalink($kode_theme_option['donatation_page']));?>"><?php echo esc_attr($kode_theme_option['donation-btn-text']);?></a>
										<?php 
										}
									}
								}
							} ?>
							</div>
							<!--Dil Wrap End-->
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<?php get_template_part( 'header', 'nav' ); ?>	
							
						</div>
					</div>
				</header>
			<?php
			}else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-5'){ ?>
				<header class="kode_header_5">
					<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<div class="kode_top_strip2">
						<div class="container">
							<div class="kode_coun">
								<?php 
									if( !empty($kode_theme_option['top-bar-left-text']) ) {
										echo do_shortcode($kode_theme_option['top-bar-left-text']); 
									}	
								?>
							</div>
							<?php kode_print_header_social_icon('kode_social_icon'); ?>
							<div class="kode_cart_wrap">
								<?php 
									if( !empty($kode_theme_option['top-bar-right-text']) ) {
										echo do_shortcode($kode_theme_option['top-bar-right-text']); 
									}	
								?>
							</div>
						</div>
					</div>
					<?php }?>
					<div class="kode_nav_1 header_sticky_nav">
						<div class="container">
							<!--Logo Wrap Start-->
							<div class="kode_logo_2">
								<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" >
								<?php 
									if(empty($kode_theme_option['logo'])){ 
										echo kode_get_image(KODE_PATH . '/images/logo.png');
									}else{
										echo kode_get_image($kode_theme_option['logo']);
									}
								?>						
								</a>
							</div>
							<!--Logo Wrap End-->
							<!--Cart Wrap Start-->
							<div class="kode_cart_fill">
								<?php 
								if(class_exists('Woocommerce')){
									global $woocommerce;?>									
									<?php echo kode_get_woo_cart(); ?>
									<span>(<?php echo esc_attr($woocommerce->cart->cart_contents_count);?>)</span>
								<?php }?>
							</div>
							<!--Cart Wrap End-->
							<!--Search Wrap Start-->
							<div class="kode_search">
								<a href="#"><i class="fa fa-search"></i></a>
							</div>
							<!--Search Wrap End-->
							<div id="kode_search" class="kode_search hide">
								<form class="kode-search kode_search-form" method="get" id="searchform" action="<?php  echo esc_url(home_url('/')); ?>/">
									<?php
										$search_val = get_search_query();
										if( empty($search_val) ){
											$search_val = esc_html__("Type keywords..." , "kickoff");
										}
									?>
									<input class="kode_search kode_search-input" type="text" name="s" id="s" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
									<button class="kode_search-submit" type="submit"><i class="fa fa-search"></i></button>
								</form>
								<span class="kode_search-close"></span>
							</div><!-- /kode_search -->
							<div class="overlay"></div>
							<!--Navigation Wrap Start-->
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<?php get_template_part( 'header', 'nav' ); ?>	
							<!--Navigation Wrap End-->
						</div>
					</div>
				</header>
			<?php
			}else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-6'){
				?>
				<header class="kode_header_7 header_sticky_nav">
					<div class="kode_top_eng">
						<div class="container">
						<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
							<div class="kode_welcome">
								<?php 
									if( !empty($kode_theme_option['top-bar-left-text']) ) {
										echo do_shortcode($kode_theme_option['top-bar-left-text']); 
									}	
								?>
							</div>
							<div class="kode_select_opt">
								
								<!--Items DropDown Start-->
								<div class="kode_umeed_list">
									<?php 
										if( !empty($kode_theme_option['top-bar-right-text']) ) {
											echo do_shortcode($kode_theme_option['top-bar-right-text']); 
										}	
									?>
								</div>
								<!--Items DropDown End-->
								
							</div>
						<?php }?>
							<div class="kode_sec_strip">
								<div class="row">
									<div class="col-md-4">
										<div class="kode_logo">
											<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" >
											<?php 
												if(empty($kode_theme_option['logo'])){ 
													echo kode_get_image(KODE_PATH . '/images/logo.png');
												}else{
													echo kode_get_image($kode_theme_option['logo']);
												}
											?>						
											</a>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="kode_search_bar">
											<form class="kode-search" method="get" id="searchform" action="<?php  echo esc_url(home_url('/')); ?>/">
												<?php
													$search_val = get_search_query();
													if( empty($search_val) ){
														$search_val = esc_html__("Type keywords..." , "kickoff");
													}
												?>
												<input class="kode_search" type="text" name="s" id="s" autocomplete="off" data-default="<?php echo esc_attr($search_val); ?>" />
												<button><i class="fa fa-search"></i></button>
											</form>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="kode_call">
											<div class="kode_ph_no">
												<p><?php esc_html_e('Call Us With Hotline 24/7','kickoff')?></p>
												<h4><?php esc_html_e('(123) 878 545','kickoff')?></h4>
											</div>
											<div class="kode_left_thumb">
												<i class="fa fa-phone"></i>
											</div>
										</div>
									</div>
									
								</div>
							</div> 
						</div>
						
						<!--Navigation Wrap Start-->
						<div class="kode_nav_1 ">
							<div class="container">
								<!--Navigation Wrap Start-->
								<?php
									// mobile navigation
									if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
										( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
										echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
										echo '<button class="dl-trigger">Open Menu</button>';
										wp_nav_menu( array(
											'theme_location'=>'main_menu', 
											'container'=> '', 
											'menu_class'=> 'dl-menu kode-main-mobile-menu',
											'walker'=> new kode_dlmenu_walker() 
										) );						
										echo '</div>';
									}	
								?>	
								<?php get_template_part( 'header', 'nav' ); ?>	
								<!--Navigation Wrap End-->
								
								<!--Donate Now Button Start-->
								<div class="kode_donate_btn">
									<?php
									$mega_menu = get_option('mega_main_menu_options');
									if(is_array($mega_menu)){
										if(!in_array('main_menu',$mega_menu['mega_menu_locations'])){
											//Donation Button
											if(isset($kode_theme_option['enable-donation-btn']) && $kode_theme_option['enable-donation-btn'] == 'enable'){
												if(isset($kode_theme_option['donatation_page']) && $kode_theme_option['donatation_page'] != ''){ ?>
													<?php if(get_permalink($kode_theme_option['donatation_page']) <> ''){ ?>
														<a href="<?php echo esc_url(get_permalink($kode_theme_option['donatation_page']));?>" class="kode-donate-btn thbg-color"><?php echo esc_attr($kode_theme_option['donation-btn-text']);?></a>
													<?php 
													}
												}
											}
										}
									}else{
										//Donation Button
										if(isset($kode_theme_option['enable-donation-btn']) && $kode_theme_option['enable-donation-btn'] == 'enable'){
											if(isset($kode_theme_option['donatation_page']) && $kode_theme_option['donatation_page'] != ''){ ?>
												<?php if(get_permalink($kode_theme_option['donatation_page']) <> ''){ ?>
													<a href="<?php echo esc_url(get_permalink($kode_theme_option['donatation_page']));?>"><?php echo esc_attr($kode_theme_option['donation-btn-text']);?></a>
												<?php 
												}
											}
										}
									} ?>									
								</div>
								<!--Donate Now Button End-->
							</div>
						</div>
						<!--Navigation Wrap End-->
					</div>
				</header>				
			<?php }else if(isset($kode_theme_option['kode-header-style']) && $kode_theme_option['kode-header-style'] == 'header-style-7'){ ?>
				<header id="mainheader" class="kode-header-absolute kode-header-1">
					<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<!--// TopBaar //-->
					<div class="kode-topbar-kickoff">
						<div class="container">
							<div class="row">
								<div class="col-md-6 kode_bg_white">
								<?php
								//latest news script
								if(isset($kode_theme_option['top_latest_news_btn']) && $kode_theme_option['top_latest_news_btn'] == 'enable'){
									$args = array( 'posts_per_page' => 5, 'category' => $kode_theme_option['top_latest_news'] );
									$kode_posts = get_posts($args);
									if(!empty($kode_posts)){
										echo '<ul class="bxslider">';
											foreach($kode_posts as $kode_post){
												echo '<li><span class="kode-barinfo">';
												if(isset($kode_theme_option['top_latest_news_title'])){
													echo '<strong>'.esc_attr($kode_theme_option['top_latest_news_title']).' : </strong> ';
												}
												echo '<a href="'.esc_url(get_permalink($kode_post->ID)).'">'.esc_attr($kode_post->post_title).'</a></span></li>';
											}
										echo '</ul>';
									}
								}
								?>	
								</div>
								<?php if(isset($kode_theme_option['enable-top-bar-login']) && $kode_theme_option['enable-top-bar-login'] == 'enable'){ ?>
								<div class="col-md-6">							
									<ul class="kode-userinfo">
										<?php 
										if(class_exists('Woocommerce')){
											global $woocommerce;?>									
											<li class="cart-option woocommerce">
											<span><i class="fa fa-shopping-cart"></i> <?php esc_html_e('Cart','kickoff');?> (<?php echo esc_attr($woocommerce->cart->cart_contents_count);?>)</span>
											<?php echo kode_get_woo_cart(); ?>
											</li>
										<?php }?>
										<?php if (is_user_logged_in()) {
											global $current_user;?>
											<li><a href=""><?php esc_attr_e('Welcome ','kickoff');?><?php echo esc_attr($current_user->display_name);?></a></li>
											<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
										<?php }else{ ?>
											<li><?php kode_signin_form()?></li>
											<li><?php kode_signup_form()?></li>
										<?php }?>
									</ul>
								</div>
								<?php }?>
							</div>
						</div>
					</div>
					<!--// TopBaar //-->
					<?php }?>
					<div class="header-8">
						<div class="container">
							<!--NAVIGATION START-->
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<div class="kode-navigation pull-left">
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'left' ); ?>	
								<!--Navigation Wrap End-->
							</div>
							<!--NAVIGATION END--> 
							<!--LOGO START-->	
							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" >
								<?php 
									if(empty($kode_theme_option['logo'])){ 
										echo kode_get_image(KODE_PATH . '/images/logo.png');
									}else{
										if(kode_get_image($kode_theme_option['logo']) <> ''){
											echo kode_get_image($kode_theme_option['logo']);
										}else{
											echo kode_get_image(KODE_PATH . '/images/logo.png');
										}
										
									}
								?>						
								</a>
							</div>
							<!--LOGO END-->	
							<!--NAVIGATION START-->
							<div class="kode-navigation">					
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'right' ); ?>	
								<!--Navigation Wrap End-->
							</div>
						</div>
					</div>
				</header>				
			<?php }else{ ?>
				<header id="mainheader" class="kode-header-absolute kode-header-1">
					<?php if(isset($kode_theme_option['enable-top-bar']) && $kode_theme_option['enable-top-bar'] == 'enable'){	?>
					<!--// TopBaar //-->
					<div class="kode-topbar-kickoff">
						<div class="container">
							<div class="row">
								<div class="col-md-6 kode_bg_white">
								<?php
								//latest news script
								if(isset($kode_theme_option['top_latest_news_btn']) && $kode_theme_option['top_latest_news_btn'] == 'enable'){
									$args = array( 'posts_per_page' => 5, 'category' => $kode_theme_option['top_latest_news'] );
									$kode_posts = get_posts($args);
									if(!empty($kode_posts)){
										echo '<ul class="bxslider">';
											foreach($kode_posts as $kode_post){
												echo '<li><span class="kode-barinfo">';
												if(isset($kode_theme_option['top_latest_news_title'])){
													echo '<strong>'.esc_attr($kode_theme_option['top_latest_news_title']).' : </strong> ';
												}
												echo '<a href="'.esc_url(get_permalink($kode_post->ID)).'">'.esc_attr($kode_post->post_title).'</a></span></li>';
											}
										echo '</ul>';
									}
								}
								?>	
								</div>
								<?php if(isset($kode_theme_option['enable-top-bar-login']) && $kode_theme_option['enable-top-bar-login'] == 'enable'){ ?>
								<div class="col-md-6">							
									<ul class="kode-userinfo">
										<?php 
										if(class_exists('Woocommerce')){
											global $woocommerce;?>									
											<li class="cart-option woocommerce">
											<span><i class="fa fa-shopping-cart"></i> <?php esc_html_e('Cart','kickoff');?> (<?php echo esc_attr($woocommerce->cart->cart_contents_count);?>)</span>
											<?php echo kode_get_woo_cart(); ?>
											</li>
										<?php }?>
										<?php if (is_user_logged_in()) {
											global $current_user;?>
											<li><a href=""><?php esc_attr_e('Welcome ','kickoff');?><?php echo esc_attr($current_user->display_name);?></a></li>
											<li><a data-original-title="Facebook" href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="fa fa-user"></i> <?php esc_attr_e('Logout','kickoff');?></a></li>
										<?php }else{ ?>
											<li><?php kode_signin_form()?></li>
											<li><?php kode_signup_form()?></li>
										<?php }?>
									</ul>
								</div>
								<?php }?>
							</div>
						</div>
					</div>
					<!--// TopBaar //-->
					<?php }?>
					<div class="header-8">
						<div class="container">
							<!--NAVIGATION START-->
							<?php
								// mobile navigation
								if( class_exists('kode_dlmenu_walker') && has_nav_menu('main_menu') &&
									( empty($kode_theme_option['enable-responsive-mode']) || $kode_theme_option['enable-responsive-mode'] == 'enable' ) ){
									echo '<div class="kode-responsive-navigation dl-menuwrapper" id="kode-responsive-navigation" >';
									echo '<button class="dl-trigger">Open Menu</button>';
									wp_nav_menu( array(
										'theme_location'=>'main_menu', 
										'container'=> '', 
										'menu_class'=> 'dl-menu kode-main-mobile-menu',
										'walker'=> new kode_dlmenu_walker() 
									) );						
									echo '</div>';
								}	
							?>	
							<div class="kode-navigation pull-left">
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'left' ); ?>	
								<!--Navigation Wrap End-->
							</div>
							<!--NAVIGATION END--> 
							<!--LOGO START-->	
							<div class="logo">
								<a href="<?php echo esc_url(home_url('/')); ?>" >
								<?php 
									if(empty($kode_theme_option['logo'])){ 
										echo kode_get_image(KODE_PATH . '/images/logo.png');
									}else{
										if(kode_get_image($kode_theme_option['logo']) <> ''){
											echo kode_get_image($kode_theme_option['logo']);
										}else{
											echo kode_get_image(KODE_PATH . '/images/logo.png');
										}
										
									}
								?>						
								</a>
							</div>
							<!--LOGO END-->	
							<!--NAVIGATION START-->
							<div class="kode-navigation">					
								<!--Navigation Wrap Start-->
								<?php get_template_part( 'header', 'right' ); ?>	
								<!--Navigation Wrap End-->
							</div>
						</div>
					</div>
				</header>	
			<?php
			}
		}
	}

	