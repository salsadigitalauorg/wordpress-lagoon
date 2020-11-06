ARG CLI_IMAGE
FROM salsadigital/wordpress-lagoon-cli:latest as builder

FROM amazeeio/php:7.4-fpm

# Create temporary wordpress log file.
RUN touch /tmp/wp-errors.log && fix-permissions /tmp/wp-errors.log

COPY --from=builder /app /app
