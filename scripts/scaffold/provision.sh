#!/usr/bin/env bash
##
# Provision site by importing it from the database dump or installing from
# profile and running additional steps.
#
# This script has excessive verbose output to make it easy to debug site
# provisions and deployments.
#
# shellcheck disable=SC1091,SC2086,SC2002,SC2235,SC1090,SC2012,SC2015

t=$(mktemp) && export -p >"${t}" && set -a && . ./.env && if [ -f ./.env.local ]; then . ./.env.local; fi && set +a && . "${t}" && rm "${t}" && unset t

set -eu
[ "${DREVOPS_DEBUG-}" = "1" ] && set -x

# Flag to skip site provisioning.
DREVOPS_PROVISION_SKIP="${DREVOPS_PROVISION_SKIP:-}"

# Environment setup
# ------------------------------------------------------------------------------
# Name of the webroot directory with WordPress codebase.
WEBROOT="${WEBROOT:-web}"

# WordPress site name.
WORDPRESS_SITE_NAME="${COMPOSE_PROJECT_NAME:-Example site}"

# WordPress site email.
WORDPRESS_SITE_EMAIL="${WORDPRESS_SITE_EMAIL:-webmaster@example.com}"

# WordPress Admin Email.
WORDPRESS_ADMIN_EMAIL="${WORDPRESS_ADMIN_EMAIL:-admin@example.com}"

# WordPress site URL.
WORDPRESS_SITE_URL="${LOCALDEV_URL:-http://example.com}"

# Database dump file name for import (if required).
WP_DB_DUMP_FILE="${WP_DB_DUMP_FILE:-db.sql}"

# Mariadb database name.
MARIADB_DATABASE: ${MARIADB_DATABASE:-lagoon}

# Mariadb user name.
MARIADB_USERNAME: ${MARIADB_USERNAME:-lagoon}

# Mariadb password.
MARIADB_PASSWORD: ${MARIADB_PASSWORD:-lagoon}

# Mariadb host.
MARIADB_HOST: ${MARIADB_HOST:-mariadb}

# Webroot directory.
WEBROOT: ${WEBROOT:-web}

# ------------------------------------------------------------------------------

# @formatter:off
note() { printf "       %s\n" "${1}"; }
info() { [ "${TERM:-}" != "dumb" ] && tput colors >/dev/null 2>&1 && printf "\033[34m[INFO] %s\033[0m\n" "${1}" || printf "[INFO] %s\n" "${1}"; }
pass() { [ "${TERM:-}" != "dumb" ] && tput colors >/dev/null 2>&1 && printf "\033[32m[ OK ] %s\033[0m\n" "${1}" || printf "[ OK ] %s\n" "${1}"; }
fail() { [ "${TERM:-}" != "dumb" ] && tput colors >/dev/null 2>&1 && printf "\033[31m[FAIL] %s\033[0m\n" "${1}" || printf "[FAIL] %s\n" "${1}"; }
# @formatter:on

yesno() { [ "${1}" = "1" ] && echo "Yes" || echo "No"; }
# ------------------------------------------------------------------------------
# Main provisioning logic
# ------------------------------------------------------------------------------
info "Started site provisioning."

# Check if provisioning should be skipped
[ "${DREVOPS_PROVISION_SKIP:-0}" = "1" ] && pass "Skipped site provisioning as requested." && exit 0

# Provision site from WordPress profile.
provision_from_wp_profile() {

  # Preparing the database
  info "Resetting database..."
  wp db reset --yes --path=/app/${WEBROOT}/wp --allow-root

  # Install WordPress
  info "Installing website..."
  wp core install --path=/app/${WEBROOT}/wp --allow-root --url="${WORDPRESS_SITE_URL}" --title="${WORDPRESS_SITE_NAME}" --admin_user="admin" --admin_password="$(openssl rand -base64 12)" --admin_email="${WORDPRESS_ADMIN_EMAIL}"


  pass "WordPress site installed successfully."
}

echo

provision_from_wp_profile

# Run custom provision scripts.
# The files should be located in "./scripts/custom/" directory
# and must have "provision-" prefix and ".sh" extension.
if [ -d "./scripts/custom" ]; then
  for file in ./scripts/custom/provision-*.sh; do
    if [ -f "${file}" ]; then
      echo
      info "Running custom post-install script '${file}'."
      echo
      . "${file}"
      echo
      pass "Completed running of custom post-install script '${file}'."
      echo
    fi
  done
  unset file
fi

info "Finished site provisioning."

# Attempt to check WordPress installation status using WP-CLI
if wp core is-installed --path=/app/${WEBROOT}/wp --allow-root; then
  echo "WordPress is installed."
else
  echo "WordPress is not installed or there was an error checking the installation status."
fi
