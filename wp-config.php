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
define('DB_NAME', 'ghuri');

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
define('AUTH_KEY',         'D(d4)p|rJ^BN7J~Zo#y.y<19%z}xP8s iC[KNorFY}yYG1WrR&NO^vA }U47umG:');
define('SECURE_AUTH_KEY',  'l%Aa<7F_y{T+F!^K/R?W_Z%,iwHcB~a]]d:UJ70?]<ym[:^=OY|I7jM2pEQyV*LM');
define('LOGGED_IN_KEY',    '_t/WL=hJ5+ZPQ-XCrMc={:MH/~V}.~]6,DS*!0t-,>z[a7P?=A2jI/~2N%adHz/u');
define('NONCE_KEY',        'bTmP/mrJshYA>8BOdcbh:L@R=%Dwpi>hsqTqZM9Erok<7?M0>pVKVJ`!*tB!U~Cy');
define('AUTH_SALT',        'N/LAV52eN~s-7P0Ec&6nuG=s> d8KdhuCI4#ms%wONN&L:`,7Zu$)E:.GRaAy}MK');
define('SECURE_AUTH_SALT', 'YX??;fXRMGgLssCDxUOobc?Bi7a= MoP;0iL!3N.NNN0y]>JLp5c,5;Imo^#Bk!+');
define('LOGGED_IN_SALT',   'J%ve6I8_PbBcOO4c$3TCdv(!iZ4tBz]}tA:C^Sv9#L^_$+ZR~v}T=;ZaM7Af1[}_');
define('NONCE_SALT',       'Z3pYcI?cQVs!<.rv~T#l=0uJgKVlJnj{)DXgEbYenwMwKZtL>8i_wt4{N7I#&,E-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gh_';

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
