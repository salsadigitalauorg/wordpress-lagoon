<?php // mu-plugins/load.php

if (file_exists(WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php')) {
  require WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php';
}

if (file_exists(WPMU_PLUGIN_DIR.'/wp_lagoon_logs/wp_lagoon_logs.php')) {
  require WPMU_PLUGIN_DIR.'/wp_lagoon_logs/wp_lagoon_logs.php';
}

// Override QuantCDN config for non production envs.
if (empty(getenv('LAGOON_ENVIRONMENT')) || getenv('LAGOON_ENVIRONMENT') != 'production') {
  add_filter('option_wp_quant_settings', 'override_wp_quant_settings');
  function override_wp_quant_settings() {
    $quant_settings = [
      'enabled' => 0,
      'webserver_url' => 'http://localhost',
      'webserver_host' => 'www.example.com',
      'api_endpoint' => 'https://api.quantcdn.io',
      'api_account' => '',
      'api_project' => '',
      'api_token' => '',
    ];

    return $quant_settings;
  }
}
elseif (getenv('LAGOON_ENVIRONMENT') == 'production') {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');

  // Disable ability to check for plugin updates.
  add_filter( 'site_transient_update_plugins', 'mu_remove_plugin_updates' );
}

/**
 * Helper functions to disable plugin updates.
 */
function mu_remove_plugin_updates( $value ) {
  unset( $value->response['plugin/plugin-file.php'] );
  return $value;
}
