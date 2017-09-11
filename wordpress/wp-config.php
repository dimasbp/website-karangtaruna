<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+vbLNVmBfnfrN.[RunUo?{n/F0E4BNSK9&i9KFJyG?1yUjKv!U ^Q`Lo5$9s_c2?');
define('SECURE_AUTH_KEY',  'mmgF<?57aTXeh&/%ym45A*jk6Q_IWz|!]h}!JR0q?bJuLC:VW_P54qn}S1,cc5w~');
define('LOGGED_IN_KEY',    ',wvd/|.I?2r0!L^yS}m/dp>,>oX4RBN&@~M:vqPj$,w0T7zd&j3O4xKTDFx<iiKS');
define('NONCE_KEY',        'a#t*H{J7BpQpr/]Orv!7qYZXX,iX:h<J1#]2[6SMm9#p~_G2TMdkc!2z;WR(mq_x');
define('AUTH_SALT',        'fEK()FPjL7dhkTog2rcEg+QP1Lvdl^BlT8*`NjR,-#cE!#8/`&o+aUMms~ oQ/=c');
define('SECURE_AUTH_SALT', '{F:j0ANaS?Slk?l6h7?3`Z/*K=i@LB5p <&cP%s2H_|Dse^*pTtd; 7${j,$oXZ0');
define('LOGGED_IN_SALT',   'dh5vd{;_Y0zn<#?8qIu^c#b}69WxeL)s5/D7w8A_T%~4$`;*h)6u6][N6:3w:+l*');
define('NONCE_SALT',       'CdTkRq5M$0)mde|CWZ}B+^9W_0|1E|J E.!dILX4gmN]h9JFm5((;-=73pkYR~eH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
