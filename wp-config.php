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
define('DB_NAME', 'rainbowdb');

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
define('AUTH_KEY',         'nU/#sufi9YMUer*-hUumle#{Q4u-pFBZh#Sjth//;fGLNT^zFv:~.P_JPV{8mLTw');
define('SECURE_AUTH_KEY',  '3([tCAWF0+BB)ckJ:<f;l/oQ->$_UFp0&U(L6aIPAB`oi5W0SGJE.R~y{+w9azo:');
define('LOGGED_IN_KEY',    'tnC$y*-zo<EJ>bIP)+MuW:*SNf$B33s%.=U#2^2]|jMG-BpmfX8`NfM~]B+kBha9');
define('NONCE_KEY',        's[)*n^#+6<#oh+Ih9Z4(4M0auKK/LuOeXVN>SWjKk3)j)h?zg_a$5;8{fG0~wUe>');
define('AUTH_SALT',        'A<]W)/`qdjV>1fc_y#y;.ucxIA(tQV >rFCAol1y* |zg(8#Yqkf/=[&!JJwbPd|');
define('SECURE_AUTH_SALT', '!]jyYFb2,H}nR5d`?.pI*XB~Qe){?cq`V+}9>%B{dRU:k)j*kTmR/G d=_;{P7L>');
define('LOGGED_IN_SALT',   'N;4rE$)$9md?I ?D-^j:Ct?VYcEe&}`Of/v)/pQ0p0soi8iey_Sx)H&=I0aeZDkz');
define('NONCE_SALT',       'X6NWrj?q6SOGROE#uOTMHb=p-6oH)7L(bn=jf/BrBSd5 lA%cNKwD,**KA#a19hd');

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
