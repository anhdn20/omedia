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
define( 'DB_NAME', 'omedia' );

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
define( 'AUTH_KEY',         '@{3x+nnx(}~-I)@4;.!Gmhb*oQ_+}ZgzxC((U?#pEJjAQ$_4qRZi<_HW^x#Fik<~' );
define( 'SECURE_AUTH_KEY',  'JtUX+9?L;2L1?J;Zz%R2[{0CNfvL0h72M_&+0@Q(Q<UHHw!@qa4.QA2ks.a5)La5' );
define( 'LOGGED_IN_KEY',    '@n/3F9KeAqJIp4(f!-/qun3GY4za2r()B:??;RMAvhrRp`-;z2 U;+2Cq&((|sv{' );
define( 'NONCE_KEY',        'QAli9.DrhILw-scF.,LV)mh%g^ZTaRwN82<WIO=YF8n-y~;GxgPxPQZO(=j7Qu``' );
define( 'AUTH_SALT',        '|BL{nw{r{naIku>|1}g{bS<GJpb4)RuQv^rzBcu|=4f,c!~B?W}aQvzRNy0#ukH?' );
define( 'SECURE_AUTH_SALT', 'u6Nr9=Z[$srl*ify2pil|~I WjO`-=5~}Q4^QDy;F1}mdisNK5f:#2M?%nViAS&l' );
define( 'LOGGED_IN_SALT',   ')~.IP$=$w9k,K- +L{>(/Us*8w2-1@4(i`,2=sJ5C34[k{G)iXBkiOqRA1}Okn)e' );
define( 'NONCE_SALT',       'B2Z@.6<nX&$dIF]`e%u[eqo7K!1C3`|0u IThCb`{~sQC3.BIZ5Lu&85hnY!g#O>' );

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
