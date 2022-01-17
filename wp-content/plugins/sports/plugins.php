    <?php
    /**
     * Hello World
     *
     * @package    WordPressSports
     * @author      Palladium_Hub
     * @copyright   2021 Palladium_Hub
     * @license     GPL-2.0-or-later
     *
     * @wordpress-plugin
     * Plugin Name: WordPress Sports
     * Description: This plugin for an admin page.
     * Version:     1.0.0
     * Author:      Palladium_Hub
     * Author URI:  https://palladiumhub.com/
     * Text Domain: hello-world
     * License:     GPL v2 or later
     */

    include_once("sports_controller.php");
    ob_start();

    register_activation_hook(__FILE__, 'sportsCreateTable');
    function sportsCreateTable()
    {
        global $wpdb;
        global $sports_table_name;
        global $league_table_name;
        global $round_table_name;

        $sports_table_name = $wpdb->prefix . 'sports';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE `$sports_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `name` VARCHAR(50) NOT NULL,
        `status` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";


        $league_table_name = $wpdb->prefix . 'league';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlLeague = "CREATE TABLE `$league_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `sports` VARCHAR(50) NOT NULL,
        `name` VARCHAR(50) NOT NULL,
        `round` ENUM('yes','no') NOT NULL,
        `status` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";


        $round_table_name = $wpdb->prefix . 'round';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlRound = "CREATE TABLE `$round_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `leagueid` int(11) NOT NULL,
        `rname` VARCHAR(50) NOT NULL,
        `scoremultiplier` INT(50) NOT NULL,
        `scoretype` VARCHAR(50) NOT NULL,
        `rstatus` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";


        $match_table_name = $wpdb->prefix . 'match';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlMatch = "CREATE TABLE `$match_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `leagueid` int(11) NOT NULL,
        `round` VARCHAR(50) NOT NULL,
        `team1` VARCHAR(50) NOT NULL,
        `team2` VARCHAR(50) NOT NULL,   
        `mstatus` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";

        if ($wpdb->get_var("SHOW TABLES LIKE '$sports_table_name'") != $sports_table_name ||
        $wpdb->get_var("SHOW TABLES LIKE '$league_table_name'") != $league_table_name || 
        $wpdb->get_var("SHOW TABLES LIKE '$round_table_name'") != $round_table_name ||
        $wpdb->get_var("SHOW TABLES LIKE '$match_table_name'") != $match_table_name) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            dbDelta($sqlLeague);
            dbDelta($sqlRound);
            dbDelta($sqlMatch);
        }
    }
