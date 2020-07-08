ARG CLI_IMAGE
FROM ${CLI_IMAGE:-builder} as builder

FROM amazeeio/php:7.2-fpm

# Adding caching directory.
RUN mkdir -p /app/web/content/cache/tmp && fix-permissions /app/web/content/cache/tmp

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=builder /app /app
