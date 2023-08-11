<?php

/**
 * Plugin Name: WP Lagoon Configuration
 * Description: Checks for necessary environment variables and displays admin notices if they're missing.
 * Version: 1.0
 * Author: Salsa Digital (ivan.grynenko@salsa.digital)
 */

function wp_lagoon_config_admin_notices() {
  // Only show this error to administrators.
  if (!current_user_can('manage_options')) {
    return;
  }

  $messages = [];

  if (defined('WP_MISSING_AUTH_KEY') && WP_MISSING_AUTH_KEY) {
    $messages[] = 'Error: Add WP_AUTH_KEY variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_SECURE_AUTH_KEY') && WP_MISSING_SECURE_AUTH_KEY) {
    $messages[] = 'Error: Add WP_SECURE_AUTH_KEY variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_LOGGED_IN_KEY') && WP_MISSING_LOGGED_IN_KEY) {
    $messages[] = 'Error: Add WP_LOGGED_IN_KEY variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_NONCE_KEY') && WP_MISSING_NONCE_KEY) {
    $messages[] = 'Error: Add WP_NONCE_KEY variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_AUTH_SALT') && WP_MISSING_AUTH_SALT) {
    $messages[] = 'Error: Add WP_AUTH_SALT variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_SECURE_AUTH_SALT') && WP_MISSING_SECURE_AUTH_SALT) {
    $messages[] = 'Error: Add WP_SECURE_AUTH_SALT variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_LOGGED_IN_SALT') && WP_MISSING_LOGGED_IN_SALT) {
    $messages[] = 'Error: Add WP_LOGGED_IN_SALT variable to the list of variables - via the .env file or by other means.';
  }

  if (defined('WP_MISSING_NONCE_SALT') && WP_MISSING_NONCE_SALT) {
    $messages[] = 'Error: Add WP_NONCE_SALT variable to the list of variables - via the .env file or by other means.';
  }

  foreach ($messages as $message) {
    echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
  }

}

add_action('admin_notices', 'wp_lagoon_config_admin_notices');
