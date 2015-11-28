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
define('DB_NAME', 'db_keyLessOption');

/** MySQL database username */
define('DB_USER', 'keyLessUser');

/** MySQL database password */
define('DB_PASSWORD', 'Te0]%6.Qh_X0');

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
define('AUTH_KEY',         'z,q48F&]ygrtbo6ooY=*qKKWr-q;-glay^mL]VHu!#U&S?/w5NyghBHH5ho}>pZ-');
define('SECURE_AUTH_KEY',  'VqZ*XAea(=0Q9}a%9K:T74+x>_I(/Y/Xh1 KKYEQ0n7qy:-!As>vg`ID5~+{8{=*');
define('LOGGED_IN_KEY',    'X>]49}k)jVh6&qq>U))jz(dV}:w%%39%{1miI[W6(/i`5tP..w@Vjt*n?8rGY0r$');
define('NONCE_KEY',        ';e|;gh:2)dkWQr-S@MrI6F<hu4miOPe%QCR4{](+]Xrm(`w<Ox*zV}rfr|[)D@}P');
define('AUTH_SALT',        'N^{#P8axm-1~;S,.LqhrDJDT~dnAo;>lQ;N730nt]/-|<I3UeZu,p<N={?Rr+xy)');
define('SECURE_AUTH_SALT', 'oy6kgR,0>V<wS LpP#9f)%Z+#mDOedj=]V/D/t2vu`t~[FXBAZTO^>YF]]ZS=A?+');
define('LOGGED_IN_SALT',   '|3D=f/Dg+/-1B?}FH;Zg<+^X8V-v>#EHR1A0(zy::aI9lGEjt2z+F_rdA`.Ej{Uh');
define('NONCE_SALT',       'X-HQ7}fm9y7*0!#S&Gcj>%./Mk=T1CoLa^29TtidLWb,jn]2SZ-,D{U;oth;dZ+3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'auto_';

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
