#!/bin/bash

# Exit on error
set -e

# Load environment variables if .env file exists
if [ -f .env ]; then
  export $(cat .env | grep -v '^#' | xargs)
fi

# Helper function to run wp db commands
wp_db_command() {
  # Pass MySQL/MariaDB client options for the db command
  docker compose exec -T cli wp db "$@" --allow-root --path=/app/${WEBROOT}/wp
}

echo "============================================================"
echo "Starting WordPress installation process for $LOCALDEV_URL"
echo "============================================================"

# Step 1: Install composer dependencies
echo "Step 1: Installing composer dependencies..."
docker compose exec -T cli composer install --no-dev -n --prefer-dist --working-dir=/app
echo "✅ Composer dependencies installed successfully"
echo ""

# Step 2: Reset database
echo "Step 2: Resetting database..."
wp_db_command reset --yes --url=$LOCALDEV_URL
echo "✅ Database reset completed"
echo ""

# Step 3: Install WordPress core
echo "Step 3: Installing WordPress core..."
docker compose exec -T cli wp core install \
  --allow-root \
  --url=$LOCALDEV_URL \
  --title=$COMPOSE_PROJECT_NAME \
  --admin_user=admin \
  --admin_email=admin@example.com \
  --skip-email \
  --path=/app/${WEBROOT}/wp
echo "✅ WordPress core installation completed"
echo ""

# Step 4: Activate theme
echo "Step 4: Activating default theme..."
docker compose exec -T cli wp theme activate twentytwenty \
  --path=/app/${WEBROOT}/wp \
  --allow-root
echo "✅ Theme activation completed"
echo ""

echo "============================================================"
echo "WordPress installation completed successfully!"
echo "You can access your site at: $LOCALDEV_URL"
echo "Admin username: admin"
echo "Admin password: password (from WordPress installation)"
echo "============================================================" 