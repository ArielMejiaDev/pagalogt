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
PAGALO_IDEN_EMPRESA='{LivePagaloIdenEmpresa}'                                             
PAGALO_TOKEN='{LivePagaloToken}'
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

## Validate response

### In Laravel 5.5 to Laravel 6.x

The package provide constants to validate response you can do something like:

```php
$response['decision'] === 'ACCEPT';
$response['reasonCode'] === 100;
```

To avoid magic numbers you can do something like this:


```php
use \ArielMejiaDev\PagaloGT\PagaloGT;
// ...
$response = PagaloGT::add(1, 'Test transaction from Laravel 5.5', 100.00)
        ->setClient('John', 'Doe', 'john@doe.com')
        ->withTestCard('John Doe')
        ->withTestCredentials()
        ->pay();
    if($response['decision'] === PagaloGT::APPROVE_DECISION && 
       $response['reasonCode'] === PagaloGT::APPROVE_REASON_CODE ) {
        // do something
    }
```

### In Laravel 7 and 8

You can use the old validation way (since Laravel 5.5 - 6.x)

In laravel 7 and 8 the library change response, so you can validate like this:

```php
$response = PagaloGT::add(1, 'product', 100.00)->withTestCard()->withTestCredentials()->pay();
if($response->successful()) {
    // do something
}
```

Other methods to validate:

```php
$response->fail();
$response->successful();
$response->ok()
$response->header('single header');
$response->headers();
```

### Support Cybersource:

The library is ready to support cybersource transactions, it only needs to add a config variable:

```dotenv
PAGALO_USE_CYBERSOURCE=true
```

You need to add a script to generate the ```deviceFingerPrint``` on your checkout form.

In the docs you can get scripts ready to use for:

- Blade file: [Cybersource Script for blade files](BLADESCRIPT.md)
- VueJS file: (pending)

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
