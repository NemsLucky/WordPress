<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

define('FS_METHOD', 'direct');

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'lucky');

/** Database password */
define('DB_PASSWORD', 'Bonjour5');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'POq^WmUZ>8]J<q4i;aF?P=o$Iw;,D+?$a/SL^.T{e>5F+z@4.?<rRd&epN[nM%kF');
define('SECURE_AUTH_KEY',  'RgC8q5bpNCN@C*g;$Lu-/f5C-L3}5mD_;y<<>R~7Q*FZ6wl>gn/<+/Bj67 LbW(d');
define('LOGGED_IN_KEY',    '5[#{GWj~1_q2uQAOJ]Dul9HhizOl%Og0SHwy&TU|:L;tGdZ(Z&QYCg&zkLIU5T_J');
define('NONCE_KEY',        '/DDt=!dVB3I*S`SjrU&7aA[ijj|Oj{5Zxt3Qb)k7hZ%A}:)=Gj!*5(eTi3)*-?u_');
define('AUTH_SALT',        'WJfxX{h)Iq|WOEyG5bVCj[M>UyY-6Uq~^g$fvxl;??/k}pv!7dCVMJoh4OF4 z|Q');
define('SECURE_AUTH_SALT', 'c$b6!p? bl!A=ju05{[fHpr9g-U6Z?S(!Mq0X2^sD6#J=@I&3fecw]uo+)i*0],U');
define('LOGGED_IN_SALT',   'ZB*hS[cjC1gfv/5jN,,gX_$NGglNU.!XwQN#|BQ$%!l#,R=)z.vC`;pu|MiSrRv|');
define('NONCE_SALT',       '-vShH7NFg5[NP&fWD?P+^41L8j;3I0e-opLfHp`@DDXaQo8BBni<O{VRkHN^udFO');

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
