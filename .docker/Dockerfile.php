ARG WP_VERSION
ARG PHP_VERSION

FROM salsadigital/wordpress-lagoon-cli:wp-${WP_VERSION}-php-8.3.15 AS builder

FROM uselagoon/php-${PHP_VERSION}-fpm:25.1.0

RUN apk update \
    && apk add --no-cache \
    php-exif \
    php-mbstring \
    tzdata

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=builder /app /app
