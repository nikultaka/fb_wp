<?php
/*
Plugin Name: KodeForest Team
Plugin URI: 
Description: A Custom Post Type Plugin To Use With KodeForest Theme ( This plugin functionality might not working properly on another theme )
Version: 1.0.0
Author: KodeForest
Author URI: http://www.kodeforest.com
License: 
*/
global $kode_theme_option;

include_once( 'kode-team-item.php');	
include_once( 'kode-team-option.php');	


// action to loaded the plugin translation file
add_action('plugins_loaded', 'kode_team_init');
if( !function_exists('kode_team_init') ){
	function kode_team_init() {
		load_plugin_textdomain( 'kode-team', false, dirname(plugin_basename( __FILE__ ))  . '/languages/' ); 
	}
}

// add action to create team post type
add_action( 'init', 'kode_create_team' );
if( !function_exists('kode_create_team') ){
	function kode_create_team() {
		global $kode_theme_option;
		
		if(isset($kode_theme_option['team_post_type_slug']) && $kode_theme_option['team_post_type_slug'] <> ''){
			$player_slug = $kode_theme_option['team_post_type_slug'];
			$player_slug_cap = $kode_theme_option['team_post_type'];
			$player_category_slug = $kode_theme_option['team_post_type_category_slug'];			
			$player_tag_slug = $kode_theme_option['team_post_type_tag_slug'];	
			$post_type_tag = $kode_theme_option['team_post_type_tag'];
			$post_type_category = $kode_theme_option['team_post_type_category'];
		}else{
			$player_slug = 'team';
			$player_slug_cap = 'Team';
			$player_category_slug = 'team_category';
			$player_tag_slug = 'team_tag';	
			$post_type_tag = 'enable';
			$post_type_category = 'enable';
		}
	
		register_post_type( $player_slug,
			array(
				'labels' => array(
					'name'               => sprintf(__('%s', 'kode-team'),$player_slug_cap),
					'singular_name'      => sprintf(__('%s', 'kode-team'),$player_slug_cap),
					'add_new'            => __('Add New', 'kode-team'),
					'add_new_item'       => sprintf(__('Add New %s', 'kode-team'),$player_slug_cap),
					'edit_item'          => sprintf(__('Edit %s', 'kode-team'),$player_slug_cap),
					'new_item'           => sprintf(__('New %s', 'kode-team'),$player_slug_cap),
					'all_items'          => sprintf(__('All %s', 'kode-team'),$player_slug_cap),
					'view_item'          => sprintf(__('View %s', 'kode-team'),$player_slug_cap),
					'search_items'       => sprintf(__('Search %s', 'kode-team'),$player_slug_cap),
					'not_found'          => sprintf(__('No %s found', 'kode-team'),$player_slug_cap),
					'not_found_in_trash' => sprintf(__('No %s found in Trash', 'kode-team'),$player_slug_cap),
					'parent_item_colon'  => '',
					'menu_name'          => sprintf(__('%s', 'kode-team'),$player_slug_cap),
				),
				'public'             => true,
				'publicly_queryable' => true,
				'rewrite' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'menu_icon'          => 'dashicons-shield',
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
					'label' => __('Categories', 'kode-team'), 
					'singular_label' => __('Category', 'kode-team'), 
					'rewrite' => array( 'slug' => $player_category_slug  )));
			register_taxonomy_for_object_type($player_category_slug, $player_slug);
		}
		
		if(isset($post_type_tag) && $post_type_tag == 'enable'){
			// create player tag
			register_taxonomy(
				$player_tag_slug, array($player_slug), array(
					'hierarchical' => false, 
					'show_admin_column' => true,
					'label' => __('Tags', 'kode-team'), 
					'singular_label' => __('Tag', 'kode-team'),  
					'rewrite' => array( 'slug' => $player_tag_slug  )));
			register_taxonomy_for_object_type($player_tag_slug, $player_slug);	
		}

		// add filter to style single template
		if( defined('WP_THEME_KEY') && WP_THEME_KEY == 'kickoff' ){
			add_filter('single_template', 'kode_register_team_template');
		}
		
	}
	
}

if( !function_exists('kode_register_team_template') ){
	function kode_register_team_template($single_template) {
		global $post;

		if ($post->post_type == 'team') {
			$single_template = dirname( __FILE__ ) . '/single-team.php';
		}
		return $single_template;	
	}
}


include_once( 'kode-team-element.php');	
include_once( 'kode-team-table-element.php');	
include_once( 'kode-team-leader-board-element.php');
include_once( 'kode-team-slider-element.php');
include_once( 'kode-team-cricket-points-table-element.php');

//Elementor
include_once( 'elementor/wp-elementor-init.php');