# WordPress Composer image to work with Amazee.io platform

Visit https://hub.docker.com/r/salsadigital/wordpress-lagoon-cli/tags to 
download the latest image.

## Build local images

First, clean up any existing vendor directory and update composer:

```bash
rm -Rf vendor && \
composer self-update --2 && COMPOSER_MEMORY_LIMIT=1 composer update
```

**Tagging images**
Tag syntax follows the pattern: `wp-{wordpress-version}-php-{php-version}`
Example: `wp-6.4.3-php-8.3` - this tag reflects WordPress version 6.4.3 and PHP version 8.3.

### Building images (recommended method for all platforms)

1. Set up buildx builder (if not already done):
```bash
docker buildx create --name mywpbuilder --use
docker buildx inspect --bootstrap
```

2. Login to Docker Hub:
```bash
# Pull the access details, including the Docker Hub username and your personal access token
docker login --username <your-username> --password <your-access-token>
```

3. Build and push the image:
```bash
# For multi-platform build (recommended)
docker buildx build --platform linux/amd64,linux/arm64 --no-cache --push . \
  -f .docker/Dockerfile.cli \
  -t salsadigital/wordpress-lagoon-cli:wp-6.4.3-php-8.3 \
  --build-arg PHP_VERSION=8.3
```

### Post-build cleanup

To avoid problems with the buildx builder, reset to default when done:
```bash
docker context use default
```

## Automated Builds

This repository supports automated builds via GitHub Actions. To trigger a new build:

1. Create a new tag following the pattern: `wp-{wordpress-version}-php-{php-version}`
   Example: `wp-6.4.3-php-8.3`

2. Push the tag to GitHub:
   ```bash
   git tag wp-6.4.3-php-8.3
   git push origin wp-6.4.3-php-8.3
   ```

The GitHub Action will automatically build the CLI image for both AMD64 and ARM64 architectures:
- `salsadigital/wordpress-lagoon-cli:wp-6.4.3-php-8.3`

You can also trigger a build manually through the GitHub Actions interface.

## Automated Dependency Updates

This repository uses Renovate Bot to automatically update dependencies. The updates run:
- Every day at 10 PM Sydney time
- Only between 10 PM and 5 AM Sydney time
- Can be manually triggered through GitHub Actions

The bot will:
- Automatically update minor and patch versions
- Create PRs for major version updates
- Group WordPress plugin updates together
- Maintain a dependency dashboard in the repository's issues

Configuration:
- `.github/renovate.json`: Renovate Bot configuration
- `.github/workflows/renovate.yml`: GitHub Action schedule configuration

## Release Process

This repository uses automated release notes generation based on PR labels. When creating a PR, please:

1. Use the PR template
2. Apply appropriate labels:
   - 🚨 `breaking-change`: For breaking changes
   - 🚀 `enhancement`: For new features
   - 🐛 `bug`: For bug fixes
   - 🔒 `security`: For security updates
   - 🔄 `wordpress`: For WordPress core/plugin updates
   - 🐳 `docker`: For Docker-related changes
   - 📦 `dependencies`: For dependency updates
   - 📚 `documentation`: For documentation changes
   - 🧰 `maintenance`: For maintenance tasks

Release notes are automatically generated when:
1. A new tag is created
2. PRs are merged to master
3. Labels are properly applied to PRs

To create a new release:
1. Go to the "Releases" section
2. Click "Draft a new release"
3. Create a new tag following our version pattern
4. Let GitHub automatically generate release notes
5. Review and publish the release

