# Laravel Payment processing library for PagaloGT

[![Latest Version on Packagist](https://img.shields.io/packagist/v/arielmejiadev/pagalogt.svg?style=flat-square)](https://packagist.org/packages/arielmejiadev/pagalogt)
[![Total Downloads](https://img.shields.io/packagist/dt/arielmejiadev/pagalogt.svg?style=flat-square)](https://packagist.org/packages/arielmejiadev/pagalogt)

It provides a fluent syntax to make payments in Laravel with PagaloGT payment gateway.

## Installation

You can install the package via composer:

```bash
composer require arielmejiadev/pagalogt
```

## Publish config file

Its not necessary but you can publish the config file:

```php
php artisan vendor:publish --tag=pagalogt-config
```

## Usage

- Add your PagaloGT credentials on the app ```.env``` file:

You can get the credentials [Here](https://app.pagalocard.com/developerint), you need to create an account and follow some steps with PagaloGT.

```dotenv
PAGALO_TEST_IDEN_EMPRESA='{TestPagaloIdenEmpresa}'
PAGALO_TEST_TOKEN='{TestPagaloToken}'
PAGALO_TEST_KEY_PUBLIC='{TestPagaloKeyPublic}'
PAGALO_TEST_KEY_SECRET='{TestPagaloKeySecret}'
PAGALO_ENVIRONMENT='test'
```

- For development and testing (to avoid real transactions):

```php
$payment = new PagaloGT();
return $payment->add(1, 'Test transaction', 100.00)
    ->setClient('John', 'Doe', 'john@doe.com')
    ->withTestCard('John Doe')
    ->withTestCredentials()
    ->pay();
```

- Using the Facade

```php
return PagaloGT::add(1, 'Test transaction', 100.00)
    ->setClient('John', 'Doe', 'john@doe.com')
    ->withTestCard('John Doe')
    ->withTestCredentials()
    ->pay();
```

- On production

```dotenv
PAGALO_TOKEN='{LivePagaloToken}'
PAGALO_IDEN_EMPRESA='{LivePagaloIdenEmpresa}'
PAGALO_KEY_PUBLIC='{LivePagaloKeyPublic}'
PAGALO_KEY_SECRET='{LivePagaloKeySecret}'
PAGALO_ENVIRONMENT='live'
```

```php
return PagaloGT->add(1, 'Test transaction', 100.00)
    ->setClient('John', 'Doe', 'john@doe.com')
    ->setCard('JOHN JOSEPH DOE DULLIE', 'XXXX XXXX XXXX XXXX', 12, 2022, 742)
    ->pay();
```

### Support Cybersource:

The library is ready to support cybersource transactions, it only needs to add a config variable:

```dotenv
PAGALO_USE_CYBERSOURCE=true
```

You need to add a script to generate the ```deviceFingerPrint``` on your checkout form.

In the docs you can get scripts ready to use for:

- Blade file: [Cybersource Script for blade files](BLADESCRIPT.md)
- VueJS file:

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email arielmejiadev@gmail.com instead of using the issue tracker.

## Credits

- [Ariel Mejia Dev](https://github.com/arielmejiadev)
- [Victor Yoalli](https://github.com/victoryoalli)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
