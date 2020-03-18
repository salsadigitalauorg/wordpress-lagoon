<?php // mu-plugins/load.php

if (file_exists(WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php')) {
  require WPMU_PLUGIN_DIR.'/disable-wp-rest-api/disable-wp-rest-api.php';
}
