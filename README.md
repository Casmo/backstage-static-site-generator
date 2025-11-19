# Static site generator for the Backstage CMS.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/casmo/backstage-static-site-generator.svg?style=flat-square)](https://packagist.org/packages/casmo/backstage-static-site-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/casmo/backstage-static-site-generator.svg?style=flat-square)](https://packagist.org/packages/casmo/backstage-static-site-generator)

Generate static versions of your [Backstage CMS](https://github.com/backstagephp/cms) websites.

## Installation

You can install the package via composer:

```bash
composer require casmo/backstage-static-site-generator
```

You can generate the static site by running the following command:

```bash
backstage:generate-static-site {--output=public/static/} {--optimize-images=true} {--minify-html=true}
```

Optimize images will resize images to max 1024 and quality to 60. Minify html will minify the html.

## Github Pages

Use the following workflow to publish the static site on Github pages.

```yml
# Simple workflow for deploying static content to GitHub Pages
name: Deploy static content to Pages

on:
  # Runs on pushes targeting the default branch
  push:
    branches: ["gh-pages"]

  # Allows you to run this workflow manually from the Actions tab
  workflow_dispatch:

# Sets permissions of the GITHUB_TOKEN to allow deployment to GitHub Pages
permissions:
  contents: read
  pages: write
  id-token: write

# Allow only one concurrent deployment, skipping runs queued between the run in-progress and latest queued.
# However, do NOT cancel in-progress runs as we want to allow these production deployments to complete.
concurrency:
  group: "pages"
  cancel-in-progress: false

jobs:
  # Single deploy job since we're just deploying
  deploy:
    environment:
      name: github-pages
      url: ${{ steps.deployment.outputs.page_url }}
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v4
        with:
          ref: 'gh-pages'
      - name: Setup Pages
        uses: actions/configure-pages@v5
      - name: Upload artifact
        uses: actions/upload-pages-artifact@v3
        with:
          path: './public/static/example.com/'
      - name: Deploy to GitHub Pages
        id: deployment
        uses: actions/deploy-pages@v4
```

Replace example.com with your domain.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mathieu de Ruiter](https://github.com/Casmo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
