# WordPress Composer image to work with Amazee.io platform

Visit https://hub.docker.com/r/salsadigitalau/wordpress-lagoon/tags to 
download the latest image.

## Build local images

`rm -Rf vendor`

`composer self-update --2 && COMPOSER_MEMORY_LIMIT=1 composer update`

**Tagging images**
`[tag]` syntax as follows: `{wordpress-full-version}_php-{php-minor-version}`. Example: `6.4.3_php-8.2` - this tag reflects
Wordpress version 6.4.3 and PHP version 8.2.

### Using Intel host (e.g. Intel-based mac)

`docker image build --no-cache . -f ./.docker/Dockerfile.cli -t salsadigitalau/wordpress-lagoon:[tag]`

### Using Apple-silicon host (e.g. M-cip-based mac)
`docker buildx create --name mybuilder --use`

`docker buildx inspect --bootstrap`

`docker buildx build --platform linux/amd64,linux/arm64 --no-cache --push . -f ./.docker/Dockerfile.cli -t salsadigitalau/wordpress-lagoon:[tag]`

## Push image to Dockerhub
Login to docker first, ensure salsadigitalau/wordpress-lagoon project
has you listed in the access group.

`docker push salsadigitalau/wordpress-lagoon:[tag]`

### Revert to default builder

To avoid problems with new builder on Apple-silicon macs, reset the builder to default:

`docker context use default`

## Supported environment variables

Refer to the wp-config.php file to see how they are being used.

* COMPRESS_CSS
* COMPRESS_SCRIPTS
* CONCATENATE_SCRIPTS
* ENABLE_WP_CACHE
* LAGOON_ENVIRONMENT
* LAGOON_ENVIRONMENT_TYPE
* LAGOON_PRODUCTION_URL
* LAGOON_ROUTE
* MARIADB_DATABASE
* MARIADB_HOST
* MARIADB_PASSWORD
* MARIADB_USERNAME
* WP_AUTH_KEY
* WP_AUTH_SALT
* WP_DEBUG
* WP_LAGOON_WP2FA
* WP_LOGGED_IN_KEY
* WP_LOGGED_IN_SALT
* WP_NONCE_KEY
* WP_NONCE_SALT
* WP_SECURE_AUTH_KEY
* WP_SECURE_AUTH_SALT

