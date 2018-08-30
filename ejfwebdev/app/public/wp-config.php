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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'CCQoPTX6PWfvTunaV8OnA/7gNCdh/dTer5GYG6XwcAAtVJyuWISHKj1ptBxdV9ud3oy9RZxLK07j5/YTxcwB8Q==');
define('SECURE_AUTH_KEY',  'gGnQPkTqgvsqQ1yipG2LaE3g/TEnUa6YvjWdrSkMVIchyL3m+zCxDLDyghN2OrEC7I9CHcBgYMMmCk6rCgWrEg==');
define('LOGGED_IN_KEY',    'VE0aaRVvhllTxg9mPJ3i3vgVfClgn3jG68Si2hJ26218YcBMmkoSBA0Jh+eXQ60Vdh6P3CEgVxqwppAAi3k++w==');
define('NONCE_KEY',        'yGc+p4y7DBPEaBvXpB8vXhujVFD/eE83rjKDcyFNQ8InWa/DOx1036NNr00SgIwbOfnZIpSxu/fZoj0oNeB/MA==');
define('AUTH_SALT',        '05RbZIZFZ2YiWxMBjo0l7/X37/Z7X9T5d82TP65rZuIBhuPg2YildzVhWrWKgOqKEYDEguM6/GvBfrEn0WTjqA==');
define('SECURE_AUTH_SALT', 'm/jKlRVtWxG2q5eIFmr7AapCfJafUIi96QYmjYVi1qzFa245VzoQn24JccTETuHV8jGnrDPeMwNPr/9dStWNeA==');
define('LOGGED_IN_SALT',   'gLIARYqdNC8JUTvhIXxKFa/rvggWvr/EuCmEtmHddLS6O50675NeGbLUfHJAMFcRjp0n51rNVJgjkTRy7DSfjA==');
define('NONCE_SALT',       '+1CfG3tPnT8BoaGXLYQ1DCXD14URKCYR0FkUAUpE2XSoErFWHxMfYYNKW/ipDpXiY1TVArXDzZrx1MutDITh/w==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}

/* Inserted by Local by Flywheel. Fixes $is_nginx global for rewrites. */
if ( ! empty( $_SERVER['SERVER_SOFTWARE'] ) && strpos( $_SERVER['SERVER_SOFTWARE'], 'Flywheel/' ) !== false ) {
	$_SERVER['SERVER_SOFTWARE'] = 'nginx/1.10.1';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
