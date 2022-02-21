<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_sport' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Testing@123');     

/** MySQL hostname */     
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('FS_METHOD', 'direct');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jhvKKV^Eiy;NiVU}IzK<|m|%ZI U~u>@!Hc,tpy_)Bwt^qjcE=:.zoka1@p*{uh`' );
define( 'SECURE_AUTH_KEY',  ';DL[HqicFUHz<>+n4Z+c8tC~)taT`:(y>-%FWcZ;Lg2LO}zWWdu`Fi8+)Hr A:jH' );
define( 'LOGGED_IN_KEY',    'BFU}pq!V7M{r*Lwh WMni?R~ySKz9Dq7~>YAVRC.|Ir?E>+ALpBdEZLyJ5-xUj8s' );
define( 'NONCE_KEY',        'giI:o]L(^9m]dk|AaE?Qg4Aeu!;hxtt)&Fq0lkLwu:X*QwAyo:r6Pnx:x_Zh`EJ=' );
define( 'AUTH_SALT',        'bt4X[ jfTG$<_!F;+%<g4lw0y+_W@l9 N<s S8zt$_cp},NpS]^[?:% I|oFO>fP' );
define( 'SECURE_AUTH_SALT', 'Bw+^lWz(H<GosH}bz.,j][w[ZRumOC#<t9*JCO8/INshc7/?>$?nP)NIoi7ov@h ' );
define( 'LOGGED_IN_SALT',   '4yX{,o`pd-&jcHla,kZB{ZKR]#@DCa<>=uoU)A8kjhc3XX+JL3]#xbNmVauKCTb)' );
define( 'NONCE_SALT',       '4&/aF4#HDR7><3g8./bu_:>vmkimeedcd|[g e>UOc|_)w5?Q,iNR`vsu$U#VPbd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
