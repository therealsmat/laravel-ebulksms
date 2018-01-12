# laravel-ebulksms

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Requirements
[PHP](https://php.net)5.4 or newer, [Composer](https://getcomposer.org) are required.

## Installation
You need to be have an Ebulk account to use this package. If you do not have one, [click here](https://ebulksms.com).

Require the package with composer.
``` bash
$ composer require therealSMAT/laravel-ebulksms
```
You might need to add ` therealsmat\Ebulksms\EbulkSmsServiceProvider::class,` to the providers array `config/app.php` if your laravel version is less than 5.5.

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Configuration
Publish the configuration file by using this command
`php artisan vendor:publish --provider="therealsmat\Ebulksms\EbulkSmsServiceProvider::class"`

You will get a config file named `ebulksms.php` in your config directory. Customize the defaults to your ebulk sms settings.
```php
    <?php 
    
    return [
    
        /**
         * Your login username on eBulkSMS (same as your email address)
         */
        'username'          => getenv('EBULK_USERNAME'),
    
        /**
         * Your Ebulk SMS Api Key
         */
        'apiKey'            => getenv('EBULK_API_KEY'),
    
        /**
         * Your chosen sender name
         */
        'sender'            => getenv('EBULK_SENDER_NAME'),
    
        /**
         * Country code to be appended to each phone number
         */
        'country_code'      => '234'
    ];
```


## Usage
``` php
$skeleton = new League\Skeleton();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/:vendor/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
