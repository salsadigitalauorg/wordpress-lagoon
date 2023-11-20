ARG CLI_IMAGE

FROM ${CLI_IMAGE} as cli

FROM uselagoon/php-8.1-fpm:latest

RUN apk update \
    && apk add --no-cache \
    php-exif \
    php-mbstring \
    tzdata

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=cli /app /app
