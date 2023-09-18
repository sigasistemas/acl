# This is my package acl

[![Latest Version on Packagist](https://img.shields.io/packagist/v/callcocam/acl.svg?style=flat-square)](https://packagist.org/packages/callcocam/acl)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/callcocam/acl/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/callcocam/acl/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/callcocam/acl/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/callcocam/acl/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/callcocam/acl.svg?style=flat-square)](https://packagist.org/packages/callcocam/acl)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require callcocam/acl
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="acl-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="acl-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="acl-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$acl = new Callcocam\Acl();
echo $acl->echoPhrase('Hello, Callcocam!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [](https://github.com/callcocam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
