# laravel-ebulksms

![Latest Version on Packagist][ico-version]
![Software License][ico-license]
![Total Downloads][ico-downloads]

## Requirements
[PHP](https://php.net) 5.4 or greater, [Composer](https://getcomposer.org) are required.

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
`php artisan vendor:publish --provider="therealsmat\Ebulksms\EbulkSmsServiceProvider"`

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
Add the following to your .env file

```dotenv
EBULK_USERNAME=***********
EBULK_API_KEY=************
EBULK_SENDER_NAME=********
```

```php
    Route::get('/sms', 'HomeController@index');
```
  For a text message
```php
    <?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use therealsmat\Ebulksms\EbulkSMS;
    
    class HomeController extends Controller
    {
        public function index(EbulkSMS $sms)
        {
            $message = 'Hello world!';
            $recipients = '0701********';
            return $sms->composeMessage($message)
                        ->addRecipients($recipients)
                        ->send();
        }
    }
```
For a flash message
```php
    <?php
        
        namespace App\Http\Controllers;
        
        use Illuminate\Http\Request;
        use therealsmat\Ebulksms\EbulkSMS;
        
        class HomeController extends Controller
        {
            public function index(EbulkSMS $sms)
            {
                $message = 'Hello world!';
                $recipients = '0701********';
                return $sms->composeMessage($message)
                            ->addRecipients($recipients)
                            ->flash();
            }
        }
```
For balance enquiry
```php
    <?php
            
            namespace App\Http\Controllers;
            
            use Illuminate\Http\Request;
            use therealsmat\Ebulksms\EbulkSMS;
            
            class HomeController extends Controller
            {
                public function index(EbulkSMS $sms)
                {
                    return $sms->getBalance();
                }
            }
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/therealsmat/laravel-ebulksms.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-yellow.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/therealsmat/laravel-ebulksmsr.svg?style=flat-square