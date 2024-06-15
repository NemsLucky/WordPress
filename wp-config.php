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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'lucky' );

/** Database password */
define( 'DB_PASSWORD', 'Bonjour5' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'J*1$O;sl<L> }n_(,SUNlnZ|h~uhU(hMwz.Heb*;ysg}YcFX|{+aD=!;6gwQc=y!' );
define( 'SECURE_AUTH_KEY',  '2Pnf5[!;rdNrtqoD29]MAcshpi!M/X3^XK,V;s2EfW8M$e{pWU8ckEvxTtKFl0e5' );
define( 'LOGGED_IN_KEY',    '>!l![w]KcV.p1z<{w*<N-X/Qi%#B+i@r@aM+{]uUDYSw7enE>l`a!=hvAzBSy,!f' );
define( 'NONCE_KEY',        'hIrc2#P& tfhx*rXiiX22odo#Y:wa%ho.Z5HFGVYd^j#tMO7CS/b6VJ3T/~b+_w3' );
define( 'AUTH_SALT',        '}KS*&>COiqz>1G70.V!)sDr7%AzSp)lD:3,x{Kv^dyxl?|eCy{p+9*4>d}z`m+9J' );
define( 'SECURE_AUTH_SALT', ',]:EYS,?CDB I/| Dkix*(,9GwiN5&<t$R)Mlp2*Tjb|,B9hy2#r<zM/nXYS+d(3' );
define( 'LOGGED_IN_SALT',   'p^Z4x50tzocfk{2Bx(KhLm@4qa1~/Y{<6w7GPTo4&}7]^p,Wvs(*a)$RjS,NO4B3' );
define( 'NONCE_SALT',       'Xo1l{&1h+- pG06<8.GdWr$a: ViGNc*/j+=%sG|P8BhWZ $5BXG$1bUtt6[rse/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpd_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
