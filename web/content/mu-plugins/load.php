<?php // mu-plugins/load.php

if (file_exists(WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php')) {
  require WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php';
}

if (file_exists(WPMU_PLUGIN_DIR.'/wp_lagoon_logs/wp_lagoon_logs.php')) {
  require WPMU_PLUGIN_DIR.'/wp_lagoon_logs/wp_lagoon_logs.php';
}
