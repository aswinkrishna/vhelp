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
define( 'DB_NAME', 'a2itproducts_eq_blog' );

/** MySQL database username */
define( 'DB_USER', 'a2itproducts_eq_blog' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Hello@1985' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'N8`l?K$5?(#s(FTOI d+udX=gj3hvv4n 0G8g2E002XA/IA|*0Pm7&gq9br@2InI' );
define( 'SECURE_AUTH_KEY',  'wn8x_]T*J}sQ91EuGuv*>rve3DJ9bUi?kidkMT~l4#t!N9aQf CNLkMvh&dMHd`[' );
define( 'LOGGED_IN_KEY',    '9x#MsHMs8Z>P$j!hDV0OO5q5^MW$l@%5~$5CLJ>oB!o;N w6X6Ks;&1t3OduO$]U' );
define( 'NONCE_KEY',        'b`5rfe=:]&4N;]VY#Oa4#P^5seRRY#G$*;.<1&pr0bn)I0Khx#vdGgukZhC.YCD,' );
define( 'AUTH_SALT',        '(%-Nlg{F~zn.Dl>f80>3#qky(TQu1g 8l.kJ1NaOqCzj3y=#v_TX*;Ne<YVJ7^T8' );
define( 'SECURE_AUTH_SALT', '1]&k(4HAn9L2L>r.u6*n+shA&/w4p :]~+1,4iaKi`w*.pR_q([*kboo5<OJxxz4' );
define( 'LOGGED_IN_SALT',   'lk/ zBob0W}E _mENE/gVQeH_7ZmTg>k{zQ5^6xUpE/w$x6YEH5Ad/K,vYj[57/;' );
define( 'NONCE_SALT',       '8!UnyZO^;v</2l7w-S20,=*EWM!!E8o|kSo:,c(_hU).yLm1+4?M_I[39sp6p 2R' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
