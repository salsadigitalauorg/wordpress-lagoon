<?php
/**
 * Plugin Name: Salsa MySQL 8 Upgrade
 * Plugin URI: https://salsa.digital
 * Description: Monitors and reports database collation status, ensuring utf8mb4_general_ci compatibility.
 * Version: 1.0.0
 * Author: Salsa Digital
 * Author URI: https://salsa.digital
 * License: GPL-2.0+
 */

declare(strict_types=1);

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Salsa_MySQL8_Upgrade {
    private const TARGET_COLLATION = 'utf8mb4_general_ci';
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_filter('site_status_tests', [$this, 'register_site_status_tests']);
    }

    public function register_site_status_tests($tests) {
        $tests['direct']['salsa_mysql8_collation'] = [
            'label' => __('Database Collation Check', 'salsa_mysql8_upgrade'),
            'test'  => [$this, 'check_database_collation']
        ];
        return $tests;
    }

    public function check_database_collation() {
        global $wpdb;

        // Get tables with different collation
        $query = $wpdb->prepare(
            "SHOW TABLE STATUS WHERE Collation <> %s",
            self::TARGET_COLLATION
        );
        $tables = $wpdb->get_results($query);
        $table_count = count($tables);

        $result = [
            'label'       => __('Database Tables Collation', 'salsa_mysql8_upgrade'),
            'status'      => 'good',
            'badge'       => [
                'label' => __('Performance', 'salsa_mysql8_upgrade'),
                'color' => 'blue',
            ],
            'description' => sprintf(
                '<p>%s</p>',
                __('All database tables are using the recommended utf8mb4_general_ci collation.', 'salsa_mysql8_upgrade')
            ),
            'actions'     => '',
            'test'        => 'salsa_mysql8_collation',
        ];

        if ($table_count > 0) {
            $table_list = [];
            foreach ($tables as $table) {
                $table_list[] = $table->Name . ' (' . $table->Collation . ')';
            }

            $result['status'] = 'critical';
            $result['badge']['color'] = 'red';
            $result['description'] = sprintf(
                '<p>%s</p><p>%s</p>',
                sprintf(
                    __('Found %d tables with non-standard collation:', 'salsa_mysql8_upgrade'),
                    $table_count
                ),
                implode(', ', $table_list)
            );
            $result['actions'] = sprintf(
                '<p>%s</p>',
                __('Please contact your database administrator to update the table collations to utf8mb4_general_ci.', 'salsa_mysql8_upgrade')
            );
        }

        return $result;
    }

    public static function activate() {
        // Activation code if needed
    }

    public static function deactivate() {
        // Deactivation code if needed
    }
}

// Initialize the plugin
add_action('plugins_loaded', ['Salsa_MySQL8_Upgrade', 'get_instance']);

// Register activation and deactivation hooks
register_activation_hook(__FILE__, ['Salsa_MySQL8_Upgrade', 'activate']);
register_deactivation_hook(__FILE__, ['Salsa_MySQL8_Upgrade', 'deactivate']); 