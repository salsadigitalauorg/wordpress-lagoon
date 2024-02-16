# WordPress Composer image to work with Amazee.io platform

Visit https://hub.docker.com/r/salsadigitalau/wordpress-lagoon/tags to 
download the latest image.

## Build local images

`composer self-update --2 && COMPOSER_MEMORY_LIMIT=1 composer update`

`docker image build --no-cache . -f ./.docker/Dockerfile.cli -t salsadigitalau/wordpress-lagoon:[tag]`

`docker image rm salsadigitalau/wordpress-lagoon:latest`

`docker image build --no-cache . -f ./.docker/Dockerfile.cli -t salsadigitalau/wordpress-lagoon:latest`

## Push image to Dockerhub
Login to docker first, ensure salsadigitalau/wordpress-lagoon project
has you listed in the access group.

`docker push salsadigitalau/wordpress-lagoon:[tag]`

`docker push salsadigitalau/wordpress-lagoon:latest`

## Supported environment variables

Rever to the wp-config.php file to see how they are being used.

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

