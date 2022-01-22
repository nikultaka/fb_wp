<?php
require_once(KODE_LOCAL_PATH . '/framework/include/tgmpa/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'kode_register_required_plugins' );
if( !function_exists('kode_register_required_plugins') ){
	function kode_register_required_plugins(){
		$plugins = array(
			
			array(
				'name'     				=> 'Kode Players',
				'slug'     				=> 'kode_player', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_player.zip',				
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> true, 
			),
			
			array(
				'name'     				=> 'Kode Theme Installation Wizard',
				'slug'     				=> 'kode_theme_install_wizard', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_theme_install_wizard.zip',				
				'required' 				=> false,
				'force_activation' 		=> false,
				'force_deactivation' 	=> true, 
			),
			
			array(
				'name'     				=> 'Kode Testimonials',
				'slug'     				=> 'kode_testimonials', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_testimonials.zip',
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false, 
			),
			
			array(
				'name'     				=> 'Kode Teams',
				'slug'     				=> 'kode_team', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_team.zip',
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false, 
			),
			
			array(
				'name'     				=> 'Kode Shortcode',
				'slug'     				=> 'kode_shortcode', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_shortcode.zip',
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false, 
			),
			array(
				'name'     				=> 'Kode Elementor Addon',
				'slug'     				=> 'kode_elementor', 
				'source'   				=> KODE_LOCAL_PATH . '/framework/include/tgmpa/plugins/kode_elementor.zip',
				'required' 				=> true,
				'force_activation' 		=> false,
				'force_deactivation' 	=> false, 
			),
			array('name' => 'Event Manager','slug'=>'events-manager','required'=> false),
			array('name' => 'Elementor', 'slug' => 'elementor', 'required' => true),
			array('name' => 'Woo Commerce','slug' => 'woocommerce','required'  => false),
			array('name' => 'Social Login', 'slug' => 'wordpress-social-login', 'required' => true),
			array('name' => 'Contact Form 7', 'slug' => 'contact-form-7', 'required' => true)

		);

		$config = array(
			'id'           => 'kickoff',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.	
			
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'kickoff' ),
				'menu_title'                      => __( 'Install Plugins', 'kickoff' ),
				'installing'                      => __( 'Installing Plugin: %s', 'kickoff' ), // %s = plugin name.
				'oops'                            => __( 'Something went wrong with the plugin API.', 'kickoff' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop(
					'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop(
					'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'kickoff'
				), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop(
					'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
					'kickoff'
				), // %1$s = plugin name(s).
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'kickoff'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'kickoff'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'kickoff'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'kickoff' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'kickoff' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'kickoff' ),
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'kickoff' ),  // %1$s = plugin name(s).
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'kickoff' ),  // %1$s = plugin name(s).
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'kickoff' ), // %s = dashboard link.
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'kickoff' ),

				'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			),
		
		);

		tgmpa( $plugins, $config );
	}
}