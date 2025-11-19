# Static site generator for the Backstage CMS.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/casmo/backstage-static-site-generator.svg?style=flat-square)](https://packagist.org/packages/casmo/backstage-static-site-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/casmo/backstage-static-site-generator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/casmo/backstage-static-site-generator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/casmo/backstage-static-site-generator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/casmo/backstage-static-site-generator/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/casmo/backstage-static-site-generator.svg?style=flat-square)](https://packagist.org/packages/casmo/backstage-static-site-generator)

Generate static versions of your [Backstage CMS](https://github.com/backstagephp/cms) websites.

## Installation

You can install the package via composer:

```bash
composer require casmo/backstage-static-site-generator
```

You can generate the static site by running the following command:

```bash
backstage:generate-static-site {--output=public/static/} {--optimize-images=true}
```

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
