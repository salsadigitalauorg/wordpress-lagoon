ARG CLI_IMAGE
FROM salsadigital/wordpress-lagoon-cli:latest as builder

FROM uselagoon/php-8.0-fpm

RUN apk update \
    && apk add --no-cache \
    php-exif \
    php-mbstring \
    tzdata

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=builder /app /app
