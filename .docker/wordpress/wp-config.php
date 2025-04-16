<?php

// Adding configuration to enable WP cache plugin.
if (getenv('ENABLE_WP_CACHE')) {
  /** Enable W3 Total Cache */
  define('WP_CACHE', true); // Managed in project-level in .env file.
}

// Disable built-in crontab.
define('DISABLE_WP_CRON', true);

// Disable plugin updates.
if (getenv('LAGOON_ENVIRONMENT') == 'production' || getenv('LAGOON_ENVIRONMENT') == 'master') {
  define('DISALLOW_FILE_MODS', TRUE);
}

// Increase memory limit.
define('WP_MEMORY_LIMIT', getenv('WP_MEMORY_LIMIT') ?: '400M');

// Disable FTP.
define('FS_METHOD', 'direct');

// Configuring WP 2FA premium plugin.
if (getenv('WP_LAGOON_WP2FA')) {
  define( 'WP2FA_ENCRYPT_KEY', getenv('WP_LAGOON_WP2FA'));
}

// Add CDN-77 specific headers to prevent mixed content warning.
if (!empty($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], 'cdn77')) {
  $_SERVER['HTTPS'] = 'on';
}

/** Settings that make Quant work properly. */
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';

if (!empty($_SERVER['HTTP_HOST'])) {
  define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
  define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
  define('WP_PLUGIN_URL', $protocol . $_SERVER['HTTP_HOST'] . '/content/plugins' );
  define('WP_CONTENT_URL', $protocol . $_SERVER['HTTP_HOST'] . '/content');
}
elseif (!empty(getenv('LAGOON_ROUTE'))) {
  define('WP_SITEURL', $protocol . getenv('LAGOON_ROUTE'));
  define('WP_HOME', $protocol . getenv('LAGOON_ROUTE'));
  define('WP_PLUGIN_URL', $protocol . getenv('LAGOON_ROUTE') . '/content/plugins' );
  define('WP_CONTENT_URL', $protocol . getenv('LAGOON_ROUTE') . '/content');
}
define ('WPCF7_LOAD_JS', false);

define('WP_CONTENT_DIR', '/app/' . getenv('WEBROOT') . '/content');
define('WP_PLUGIN_DIR', '/app/' . getenv('WEBROOT') . '/content/plugins' );
define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins');
define('WPMU_PLUGIN_URL', WP_CONTENT_URL . '/mu-plugins' );

// Defining WordPress constants.
if (getenv('LAGOON_ENVIRONMENT_TYPE')) {
  define('WP_ENVIRONMENT_TYPE', getenv('LAGOON_ENVIRONMENT_TYPE'));
}

if (getenv('CONCATENATE_SCRIPTS')) {
  define('CONCATENATE_SCRIPTS', TRUE);
}

if (getenv('COMPRESS_SCRIPTS')) {
  define('COMPRESS_SCRIPTS', TRUE);
}

if (getenv('COMPRESS_CSS')) {
  define('COMPRESS_CSS', TRUE);
}

if (getenv('WP_DEBUG')) {
  define('WP_DEBUG', TRUE);
}

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
define('DB_NAME', getenv('MARIADB_DATABASE') ?: 'lagoon');

/** MySQL database username */
define('DB_USER', getenv('MARIADB_USERNAME') ?: 'lagoon');

/** MySQL database password */
define('DB_PASSWORD', getenv('MARIADB_PASSWORD') ?: 'lagoon');

/** MySQL hostname */
define('DB_HOST', getenv('MARIADB_HOST') ?: 'mariadb');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', getenv('MARIADB_CHARSET') ?: 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', getenv('MARIADB_COLLATE') ?: 'utf8mb4_general_ci');

/** Disable SSL for database connections */
define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
define('MYSQL_SSL_SET', false);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
if (getenv('WP_AUTH_KEY')) {
  define( 'AUTH_KEY', getenv('WP_AUTH_KEY'));
}
else {
  define( 'WP_MISSING_AUTH_KEY', true);
}

if (getenv('WP_SECURE_AUTH_KEY')) {
  define( 'SECURE_AUTH_KEY',  getenv('WP_SECURE_AUTH_KEY'));
}
else {
  define( 'WP_MISSING_SECURE_AUTH_KEY', true);
}

if (getenv('WP_LOGGED_IN_KEY')) {
  define( 'LOGGED_IN_KEY', getenv('WP_LOGGED_IN_KEY'));
}
else {
  define( 'WP_MISSING_LOGGED_IN_KEY', true);
}

if (getenv('WP_NONCE_KEY')) {
  define( 'NONCE_KEY', getenv('WP_NONCE_KEY'));
}
else {
  define( 'WP_MISSING_NONCE_KEY', true);
}

if (getenv('WP_AUTH_SALT')) {
  define( 'AUTH_SALT', getenv('WP_AUTH_SALT'));
}
else {
  define( 'WP_MISSING_AUTH_SALT', true);
}

if (getenv('WP_SECURE_AUTH_SALT')) {
  define( 'SECURE_AUTH_SALT', getenv('WP_SECURE_AUTH_SALT'));
}
else {
  define( 'WP_MISSING_SECURE_AUTH_SALT', true);
}

if (getenv('WP_LOGGED_IN_SALT')) {
  define( 'LOGGED_IN_SALT', getenv('WP_LOGGED_IN_SALT'));
}
else {
  define( 'WP_MISSING_LOGGED_IN_SALT', true);
}

if (getenv('WP_NONCE_SALT')) {
  define( 'NONCE_SALT', getenv('WP_NONCE_SALT'));
}
else {
  define( 'WP_MISSING_NONCE_SALT', true);
}

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
if (!defined('WP_DEBUG')) {
  define( 'WP_DEBUG', false );
}
define( 'WP_DEBUG_LOG', '/tmp/wp-errors.log' );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

// Disable Wordpress core update
define( 'WP_AUTO_UPDATE_CORE', false );

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
