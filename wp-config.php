<?php
define( 'FS_METHOD', 'direct' );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'x_juego_lestradamus' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'zxcv' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'AHlxw37XT%pa;fsp3vUqO h#<i7+I=M*%ENjBQ09g,P~uVM0IKsN<aGNU5FU)Lsx' );
define( 'SECURE_AUTH_KEY',  'h@#JY3BYD,38*n({X)uL{#){C<N%Fu~E<rl|exE*N,jiOn5NxwByl=9}?  21yJR' );
define( 'LOGGED_IN_KEY',    '*2QE^A?:fY4afxONgKo6<*l(dQbHA6QeX2!Q?J8taU|fR>k7L2I573g7e2PD:`mN' );
define( 'NONCE_KEY',        '8KFLswJ04G|J4~RV!z>-lz*/^@nAO7yBzQH~r/rnuPjnqj8(3#+ukv`is&p6 R[Z' );
define( 'AUTH_SALT',        '/iUFu{b*r/a+E<5LhcMsWSK_W>;Om|#<v_550eHSgrkX/O)_3J>+M_-nDmMlBal ' );
define( 'SECURE_AUTH_SALT', '+z(y;?e3*3HI)6q,jls79N(B6IFi9u%h.N&Hr#ql=C shheU_S_ISPj]4)3vkBgl' );
define( 'LOGGED_IN_SALT',   '+9#a>G<EM6?(|6i=za$,cGx$/q?olj}dswL.NN6kjIm@t^)>+OjE`$hYkPI73y#_' );
define( 'NONCE_SALT',       '~f0^b.YAdiVl*^]+.Ah4w%Hr9X:C%~`iaR@k*#D/X1D{4sbwfg-T>@kgR`Cl]P2}' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_juego';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
