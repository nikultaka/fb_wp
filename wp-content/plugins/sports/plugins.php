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


    

    register_activation_hook(__FILE__, 'sportsCreateTable');
    function sportsCreateTable()
    {
        global $wpdb;
        global $sports_table_name;
        global $league_table_name;
        global $round_table_name;
        global $score_table_name;
        global $leaderboard_table_name;



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
        `t1id` int(1) DEFAULT 1,
        `t2id` int(1) DEFAULT 0,
        `enddate` DATETIME NOT NULL,  
        `mstatus` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";


        $score_table_name = $wpdb->prefix . 'score';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlScore = "CREATE TABLE `$score_table_name` (
        `id` int(11) NOT NULL auto_increment, 
        `matchid` int(11) NOT NULL,
        `team1score` VARCHAR(50) NOT NULL,
        `team2score` VARCHAR(50) NOT NULL,              
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";   
        

        $leaderboard_table_name = $wpdb->prefix . 'leaderboard';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlleaderboard = "CREATE TABLE `$leaderboard_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `userid` int(11) NOT NULL,
        `leagueid` int(11) NOT NULL,
        `score` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;"; 

        $jointeam_table_name = $wpdb->prefix . 'jointeam';
        $charset_collate = $wpdb->get_charset_collate();
        $sqljointeam = "CREATE TABLE `$jointeam_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `userid` int(11) NOT NULL,
        `sportid` int(11) NOT NULL,
        `leagueid` int(11) NOT NULL,
        `roundid` int(11) NOT NULL,
        `matchid` int(11) NOT NULL,
        `teamid` int(11) NOT NULL,     
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;"; 


        if (
            $wpdb->get_var("SHOW TABLES LIKE '$sports_table_name'") != $sports_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$league_table_name'") != $league_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$round_table_name'") != $round_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$match_table_name'") != $match_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$score_table_name'") != $score_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$leaderboard_table_name'") != $leaderboard_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$jointeam_table_name'") != $jointeam_table_name) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            require_once(ABSPATH . 'wp-includes/pluggable.php');
            dbDelta($sql);
            dbDelta($sqlLeague);
            dbDelta($sqlRound);
            dbDelta($sqlMatch);
            dbDelta($sqlScore);
            dbDelta($sqlleaderboard);
            dbDelta($sqljointeam);

        }
    }
    // include_once("sports_controller.php");
    // include_once("frontend/league_controller.php");
    include_once(dirname(__FILE__) . "/sports_controller.php");
    include_once(dirname(__FILE__) . "/frontend/sport_controller.php");
    include_once(dirname(__FILE__) . "/frontend/league_controller.php");
    include_once(dirname(__FILE__) . "/frontend/round_controller.php");
    include_once(dirname(__FILE__) . "/frontend/match_controller.php");
    include_once(dirname(__FILE__) . "/frontend/myscore_controller.php");
    include_once(dirname(__FILE__) . "/frontend/leaderboard_controller.php");

    


 