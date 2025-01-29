# Salsa MySQL 8 Upgrade

A WordPress plugin that monitors and reports database collation status, ensuring utf8mb4_general_ci compatibility.

## Description

This plugin adds a new check to the WordPress Site Health page that verifies if all database tables are using the recommended `utf8mb4_general_ci` collation. This is important for ensuring proper character encoding and sorting in MySQL 8.

## Features

- Adds a new check to WordPress Site Health
- Monitors database table collations
- Reports tables using non-standard collations
- Provides clear status indicators and recommendations

## Installation

1. Upload the `salsa_mysql8_upgrade` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit Tools > Site Health to see the database collation status

## Usage

1. Navigate to Tools > Site Health in your WordPress admin panel
2. Look for the "Database Tables Collation" check in the Status tab
3. The check will show:
   - A "good" status if all tables use utf8mb4_general_ci
   - A "critical" status if any tables use different collations, with a list of affected tables

## Requirements

- WordPress 5.2 or higher
- PHP 8.3 or higher
- MySQL 8.0 or higher

## Support

For support, please create an issue in the plugin's repository.

## License

GPL-2.0+ 