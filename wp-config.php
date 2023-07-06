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
define( 'DB_NAME', 'rate' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'jfU%KoS]lMls%o@L&/+!gyW09@y34O2zkqGE mS.D.%Xijq[#Ol__6d0eH>vf d|' );
define( 'SECURE_AUTH_KEY',  'n?CaF uxt3+&~eVXw=qzr^X]XM6^=FA.HC4,M=#hIy88o_;nO;&iz;0)LqGA+^%A' );
define( 'LOGGED_IN_KEY',    '>(){d&cso,#&{tE|IU#S_C}c|m_$Q2654pNy|?N%bEHGK4IB,N;Hsths|V+=2}1E' );
define( 'NONCE_KEY',        'X=Bh!d)X[^F2sv@>dZ7:x{$eQVzU%x-`db/a52^weloBv7jI=i[Y=hK2peVIkWE[' );
define( 'AUTH_SALT',        'ClWV*R?:bM^.doMb|%q{|V8SBRSiviy:21YMu8EpCh>gp5E1vI+<2|]_mTH6Q[+W' );
define( 'SECURE_AUTH_SALT', '*2G8>5{2vp1,KNnU,sI{EE6#ZD{ezch{n1`y%SxD;c^hMplzpajRz6<q^76U.R:y' );
define( 'LOGGED_IN_SALT',   'jx^<J).PxWmTO)dx^Njc.Q0+RYQ{%XSE2s-1uyh6&`3r1d(*vsn#Ee@o#{CTX*Sz' );
define( 'NONCE_SALT',       'U=RO5*X)!|t?tc1=a<u=Eef|kh7]4`LdKmsMpyE8i1D|fiL6.]%ogj$[4=+z_vy#' );

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
