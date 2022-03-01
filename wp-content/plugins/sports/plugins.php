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
        global $match_table_name;
        global $score_table_name;
        global $jointeam_table_name;
        global $additionalpoints_table_name;
        global $scorepredictor_table_name;
        global $Selectteam_table_name;
        global $team_table_name;


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
        `iscomplete` VARCHAR(3),     
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
        `roundselect` VARCHAR(50) NOT NULL,         
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;"; 

        $additionalpoints_table_name = $wpdb->prefix . 'additionalpoints';
        $charset_collate = $wpdb->get_charset_collate();
        $sqladditionalpoints = "CREATE TABLE `$additionalpoints_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `leagueid` int(11) NOT NULL,
        `jokerscoremultiplier` INT(50),
        `jokerscoretype` VARCHAR(50),
        `predictorscoremultiplier` INT(50),
        `predictorscoretype` VARCHAR(50),       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;"; 

        $scorepredictor_table_name = $wpdb->prefix . 'scorepredictor';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlscorepredictor = "CREATE TABLE `$scorepredictor_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `matchid` int(11) NOT NULL,
        `teamid` int(11) NOT NULL,
        `userid` int(11) NOT NULL,
        `scorepredictor` INT(50) NOT NULL,         
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;"; 

        $Selectteam_table_name = $wpdb->prefix . 'selectteam';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlSelectteam = "CREATE TABLE `$Selectteam_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `userid` int(11) NOT NULL,
        `sportid` int(11) NOT NULL,
        `leagueid` int(11) NOT NULL,
        `roundid` int(11) NOT NULL,
        `matchid` int(11) NOT NULL,
        `teamid` int(11) NOT NULL,        
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";

        $team_table_name = $wpdb->prefix . 'team';
        $charset_collate = $wpdb->get_charset_collate();
        $sqlteam = "CREATE TABLE `$team_table_name` (
        `id` int(11) NOT NULL auto_increment,
        `sportid` int(11) NOT NULL,
        `teamname` VARCHAR(50) NOT NULL,
        `tstatus` VARCHAR(50) NOT NULL,       
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY  id (id)) $charset_collate;";


        if (
            $wpdb->get_var("SHOW TABLES LIKE '$sports_table_name'") != $sports_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$league_table_name'") != $league_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$round_table_name'") != $round_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$match_table_name'") != $match_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$score_table_name'") != $score_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$jointeam_table_name'") != $jointeam_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$additionalpoints_table_name'") != $additionalpoints_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$scorepredictor_table_name'") != $scorepredictor_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$Selectteam_table_name'") != $Selectteam_table_name ||
            $wpdb->get_var("SHOW TABLES LIKE '$team_table_name'") != $team_table_name) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            require_once(ABSPATH . 'wp-includes/pluggable.php');
            dbDelta($sql);
            dbDelta($sqlLeague);
            dbDelta($sqlRound);
            dbDelta($sqlMatch);
            dbDelta($sqlScore);
            dbDelta($sqljointeam);
            dbDelta($sqladditionalpoints);
            dbDelta($sqlscorepredictor);
            dbDelta($sqlSelectteam);
            dbDelta($sqlteam);

        }
    }
    // include_once("sports_controller.php");
    // include_once("frontend/league_controller.php");
    include_once(dirname(__FILE__) . "/user_Invite_Cron.php");
    include_once(dirname(__FILE__) . "/sports_controller.php");
    include_once(dirname(__FILE__) . "/team_controller.php");
    include_once(dirname(__FILE__) . "/frontend/sport_controller.php");
    include_once(dirname(__FILE__) . "/frontend/league_controller.php");
    include_once(dirname(__FILE__) . "/frontend/round_controller.php");
    include_once(dirname(__FILE__) . "/frontend/match_controller.php");
    include_once(dirname(__FILE__) . "/frontend/myscore_controller.php");
    include_once(dirname(__FILE__) . "/frontend/leaderboard_controller.php");
    include_once(dirname(__FILE__) . "/frontend/livematch_controller.php");


    


 