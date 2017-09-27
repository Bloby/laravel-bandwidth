laravel-bandwidth
======

**NOTE:** This package is no longer in active development. Feel free to fork and extend it as needed.

A simple Laravel interface for interacting with the Bandwidth API.


# Installation
To install the package, simply add the following to your Laravel installation's `composer.json` file:

```json
"require": {
	"laravel/framework": "5.*",
	"blob/laravel-bandwidth": "dev-master"
},
```

Run `composer update` to pull in the files.

Then, add the following **Service Provider** to your `providers` array in your `config/app.php` file:

```php
'providers' => array(
	...
	Bandwidth\Providers\BandwidthServiceProvider::class,
	Bandwidth\Providers\BandwidthE911ServiceProvider::class,
);
```

From the command-line run:
`php artisan vendor:publish`

# Configuration

Open `config/bandwidth.php` and configure the api endpoint and credentials:

```php
return [
	// API URL
	'url'		 =>	'https://test.dashboard.bandwidth.com/api',

    // API USERNAME
    'username'	 =>	'admin_user',

    // API PASSWORD
    'password'	 =>	'password123',

    // API account id
    'account_id' =>	11554646,

    'timezone'	=>	'UTC',
    
    'e911' => [
        'url'       => 'https://staging-service.dashcs.com/dash-api/soap/emergencyprovisioning/v1?wsdl',
        'login'     => 'test',
        'password'  => 'test1111',
    ]
];
```

# Usage
```php
//$DIDs = MOR::getDIDs($client_id);
```
