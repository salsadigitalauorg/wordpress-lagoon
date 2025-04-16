ARG WP_VERSION
ARG PHP_VERSION
ARG CLI_IMAGE

FROM ${CLI_IMAGE} AS cli

FROM uselagoon/php-${PHP_VERSION}-fpm:25.4.0

RUN apk update \
    && apk add --no-cache \
    php-exif \
    php-mbstring \
    tzdata

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=cli /app /app
