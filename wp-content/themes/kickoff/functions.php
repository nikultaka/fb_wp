<?php
	/*	
	*	Kodeforest Function File
	*	---------------------------------------------------------------------
	*	This file include all of important function and features of the theme
	*	---------------------------------------------------------------------
	*/
	
	//Define Theme Name
	
	define('WP_THEME_KEY', 'kickoff');
	define('KODE_FULL_NAME', 'Theme Options');
	define('KODE_SMALL_TITLE', 'kickoff');
	define('KODE_SLUG', 'kickoff');
	
	define('AJAX_URL', admin_url('admin-ajax.php'));
	define('KODE_PATH', get_template_directory_uri());
	define('KODE_LOCAL_PATH', get_template_directory());
	
	//WP Customizer
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_meta/wp_customizer.php');
	
	//Responsive Menu
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kf_responsive_menu.php');
	
	// Framework
	include_once(KODE_LOCAL_PATH . '/framework/kf_framework.php' );
	include_once(KODE_LOCAL_PATH . '/framework/script-handler.php' );
	include_once(KODE_LOCAL_PATH . '/framework/include/kode_front_func/kode_header.php' );
	include_once(KODE_LOCAL_PATH . '/framework/external/import_export/kodeforest-importer.php' );
	

	
	//Custom Widgets
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/recent-comment.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/about-rugby-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/recent-post-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/popular-post-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/flickr-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/rugby-flickr-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/contact-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/newsletter-widget.php');
	include_once(KODE_LOCAL_PATH . '/framework/include/custom_widgets/kode-tabs-widget.php');
	
	
	// plugin support	
	include_once(KODE_LOCAL_PATH . '/framework/include/tgmpa/kode-activation.php');

	global $kode_theme_option;
	//Load Fonts
	if( empty($kode_theme_option['upload-font']) ){ $kode_theme_option['upload-font'] = ''; }
	$kode_font_controller = new kode_font_loader( json_decode($kode_theme_option['upload-font'], true) );	
	
	
	
	//Deregister the WooCommerce Style File
	add_action('wp_enqueue_scripts','kode_deregister_scripts');
	function kode_deregister_scripts(){
		// WooCommerce Style
		wp_deregister_style('woocommerce-general');
	}
	
	add_theme_support( 'woocommerce' );
	
	// add action to enqueue woocommerce style
	add_filter('kode_enqueue_scripts', 'kode_regiser_woo_style');
	if( !function_exists('kode_regiser_woo_style') ){
		function kode_regiser_woo_style($array){	
			global $woocommerce;
			if( !empty($woocommerce) ){
				$array['style']['kode-woo-style'] = KODE_PATH . '/framework/assets/default/css/kode-woocommerce.css';
			}
			return $array;
		}
	}
	
	//Title Hook
	function kode_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'kickoff' ), max( $paged, $page ) );
		}

		return $title;
	}
	//add_filter( 'wp_title', 'kode_wp_title', 10, 2 );
	
	// a comment callback function to create comment list
	if ( !function_exists('kode_comment_list') ){
		function kode_comment_list( $comment, $args, $depth ){
			$GLOBALS['comment'] = $comment;
			switch ( $comment->comment_type ){
				case 'pingback' :
				case 'trackback' :
				?>	
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php esc_html_e( 'Pingback :', 'kickoff' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'kickoff' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php break; ?>

				<?php default : global $post; ?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div class="thumblist">
						<figure><?php echo get_avatar( $comment, 60 ); ?></figure>
						<div class="text">
							<div class="kode-title-comment-c">
								<?php echo get_comment_author_link(); ?>
								<time datetime="<?php echo esc_attr(get_comment_time('c')); ?>"><?php echo esc_attr(get_comment_date()) . ' ' . esc_html__('at', 'kickoff') . ' ' . esc_attr(get_comment_time()); ?></time>
							</div>							
							<?php comment_text(); ?>
							<div class="clear clearfix"></div>
							<div class="kode-edit-reply">
								<?php edit_comment_link( esc_html__( 'Edit', 'kickoff' ), '<p class="edit-link">', '</p>' ); ?>
								<?php if( '0' == $comment->comment_approved ){ ?>
									<p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'kickoff' ); ?></p>
								<?php } ?>
								<?php comment_reply_link( array_merge($args, array('before' => ' ', 'reply_text' => esc_html__('Reply', 'kickoff'), 'depth' => $depth, 'max_depth' => $args['max_depth'])) ); ?>
							</div>
						</div>
					</div>
				<?php
				break;
			}
		}
	}	
	
	// WooCommerce Gallery 
	add_action( 'after_setup_theme', 'kickoff_wc_scripts_setup' );
	function kickoff_wc_scripts_setup() {
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
	
?>