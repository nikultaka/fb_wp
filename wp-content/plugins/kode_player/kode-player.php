<?php
/*
Plugin Name: KodeForest Player
Plugin URI: 
Description: A Custom Post Type Plugin To Use With KodeForest Theme ( This plugin functionality might not working properly on another theme )
Version: 1.0.0
Author: KodeForest
Author URI: http://www.kodeforest.com
License: 
*/


include_once( 'kode-player-item.php');	
include_once( 'kode-player-option.php');	

// action to loaded the plugin translation file
add_action('plugins_loaded', 'kode_player_init');
if( !function_exists('kode_player_init') ){
	function kode_player_init() {
		load_plugin_textdomain( 'kode-player', false, dirname(plugin_basename( __FILE__ ))  . '/languages/' ); 
	}
}



// add action to create player post type
add_action( 'init', 'kode_create_player' );
if( !function_exists('kode_create_player') ){
	function kode_create_player() {
		global $kode_theme_option;
		
		if(isset($kode_theme_option['player_post_type_slug']) && $kode_theme_option['player_post_type_slug'] <> ''){
			$player_slug = $kode_theme_option['player_post_type_slug'];
			$player_slug_cap = $kode_theme_option['player_post_type'];
			$player_category_slug = $kode_theme_option['player_post_type_category_slug'];			
			$player_tag_slug = $kode_theme_option['player_post_type_tag_slug'];	
			$post_type_tag = $kode_theme_option['player_post_type_tag'];
			$post_type_category = $kode_theme_option['player_post_type_category'];
		}else{
			$player_slug = 'player';
			$player_slug_cap = 'Player';
			$player_category_slug = 'player_category';
			$player_tag_slug = 'player_tag';		
			$post_type_tag = 'enable';
			$post_type_category = 'enable';
		}
	
		register_post_type( $player_slug,
			array(
				'labels' => array(
					'name'               => sprintf(__('%s', 'kode-player'),$player_slug_cap),
					'singular_name'      => sprintf(__('%s', 'kode-player'),$player_slug_cap),
					'add_new'            => __('Add New', 'kode-player'),
					'add_new_item'       => sprintf(__('Add New %s', 'kode-player'),$player_slug_cap),
					'edit_item'          => sprintf(__('Edit %s', 'kode-player'),$player_slug_cap),
					'new_item'           => sprintf(__('New %s', 'kode-player'),$player_slug_cap),
					'all_items'          => sprintf(__('All %s', 'kode-player'),$player_slug_cap),
					'view_item'          => sprintf(__('View %s', 'kode-player'),$player_slug_cap),
					'search_items'       => sprintf(__('Search %s', 'kode-player'),$player_slug_cap),
					'not_found'          => sprintf(__('No %s found', 'kode-player'),$player_slug_cap),
					'not_found_in_trash' => sprintf(__('No %s found in Trash', 'kode-player'),$player_slug_cap),
					'parent_item_colon'  => '',
					'menu_name'          => sprintf(__('%s', 'kode-player'),$player_slug_cap),
				),
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-universal-access',
				'query_var'          => true,				
				'rewrite'            => array( 'slug' => $player_slug  ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => true,
				'menu_position'      => 30,
				'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt','custom-fields' )
			)
		);
		
		if(isset($post_type_category) && $post_type_category == 'enable'){
			// create player categories
			register_taxonomy(
				$player_category_slug, array($player_slug), array(
					'hierarchical' => true,
					'show_admin_column' => true,
					'label' => __('Categories', 'kode-player'), 
					'singular_label' => __('Category', 'kode-player'), 
					'rewrite' => array( 'slug' => $player_category_slug  )));
			register_taxonomy_for_object_type($player_category_slug, $player_slug);
		}
		
		if(isset($post_type_tag) && $post_type_tag == 'enable'){
			// create player tag
			register_taxonomy(
				$player_tag_slug, array($player_slug), array(
					'hierarchical' => false, 
					'show_admin_column' => true,
					'label' => __('Tags', 'kode-player'), 
					'singular_label' => __('Tag', 'kode-player'),  
					'rewrite' => array( 'slug' => $player_tag_slug  )));
			register_taxonomy_for_object_type($player_tag_slug, $player_slug);	
		}

		// add filter to style single template
		if( defined('WP_THEME_KEY') && WP_THEME_KEY == 'kickoff' ){
			add_filter('single_template', 'kode_register_player_template');
		}	
	}
}

if( !function_exists('kode_register_boxer_template') ){
	function kode_register_boxer_template($single_template) {
		global $post;
		$player_slug = 'player';
		$player_slug_cap = 'Player';
		$player_category_slug = 'player_category';
		$player_tag_slug = 'player_tag';	
		if ($post->post_type == 'boxer') {
			$single_template = dirname( __FILE__ ) . '/single-boxer.php';
		}
		return $single_template;	
	}
}
if( !function_exists('kode_register_player_template') ){
	function kode_register_player_template($single_template) {
		global $post;
		$player_slug = 'player';
		$player_slug_cap = 'Player';
		$player_category_slug = 'player_category';
		$player_tag_slug = 'player_tag';	
		if ($post->post_type == $player_slug) {
			$single_template = dirname( __FILE__ ) . '/single-'.$player_slug.'.php';
		}
		return $single_template;	
	}
}

include_once( 'kode-player-element.php');	
include_once( 'kode-player-slider-element.php');

//Elementor
include_once( 'elementor/wp-elementor-init.php');
