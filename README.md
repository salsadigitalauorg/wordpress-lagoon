# WordPress Composer image to work with Amazee.io platform

Visit https://hub.docker.com/r/salsadigital/wordpress-lagoon-cli/tags to 
download the latest image.

## Build local images
docker image build . -f ./.docker/Dockerfile.cli -t salsadigital/wordpress-lagoon-cli:[tag]
docker image build . -f ./.docker/Dockerfile.cli -t salsadigital/wordpress-lagoon-cli:latest

## Push image to Dockerhub
Login to docker first, ensure salsadigital/wordpress-lagoon-cli project
has you listed in the access group.
docker push salsadigital/wordpress-lagoon-cli:[tag]
docker push salsadigital/wordpress-lagoon-cli:latest

