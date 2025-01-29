ARG CLI_IMAGE
ARG PHP_VERSION=8.3

FROM ${CLI_IMAGE} as cli

FROM uselagoon/php-${PHP_VERSION}-fpm:25.1.0

RUN apk update \
    && apk add --no-cache \
    php-exif \
    php-mbstring \
    tzdata

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=cli /app /app
