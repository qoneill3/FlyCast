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
define('DB_NAME', 'flyCast');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'q!$&%Nl*(>kep@wW&7oVWMIJCwhkU/NW;O4,Nvk(g{I5yx`rESqZFL][MX)h(4 7');
define('SECURE_AUTH_KEY',  '<Mg?)[+n747fLjJHHfQ~4/DsvcLr),cz4dP6pWRS<(+MOUeNnkS68P0 ~/&?K&y}');
define('LOGGED_IN_KEY',    'A.vA-U|X7#%}iIT),{uO1+DIikRDl#<3)7(trH5sxn[W 6r+Z<@3yv^#htt5xVP,');
define('NONCE_KEY',        '{m$JJgqA]pijg#vkJ!O=_@^?dW+o30|uhL%.n4QgQO*l#a|=x?O5s??.|r]F>B!n');
define('AUTH_SALT',        'dftgZYoaY0F?P/!rnmJN2C}%uI,CxtB_u?yIp!rj-o*GHqxS*XI*#M:fu-Y16-*I');
define('SECURE_AUTH_SALT', ',U/W,KdurOvQLM!Jx8c8!9gm(]V}EP9.ObF&QPch?n!_%Ouoy]g&I|`j2k[iv3>}');
define('LOGGED_IN_SALT',   '9UrYi%yvfHh,fsod|>R7;}#%CU.#.($yhFFmd*|hwy{sirL;#$2B{6_>b43Mh;&=');
define('NONCE_SALT',       '9@x#bi+7KSGOR{kh$bxJsz*yhGEE}O%=Z0-~j|4_Kw9Q[:K1(.icton+sP`X8msJ');

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
