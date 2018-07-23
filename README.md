<p align="center">
    <img src="https://laravel.com/assets/img/components/logo-laravel.svg">
</p>

# Laravel Wrapper for zoom api ( https://zoom.github.io/api/ ) 

## Installation

### Step 1: Composer

From the command line, run:

```
composer require fessnik/zoom
```

### Step 2: Service Provider (For Laravel < 5.5)

For your Laravel app, open `config/app.php` and, within the `providers` array, append:

```
Fessnik\Zoom\ZoomServiceProvider::class
```

### Step 3: Publish Configs

First from the command line, run:

```
php artisan vendor:publish --provider="Fessnik\Zoom\ZoomServiceProvider"
```

After that you will see `zoom.php` file in config directory, where you add value for api_key and api_secret

### Usage

```
$zoom = new Zoom();

$zoom->users->list()
```

### RESOURCES
```
Users
Meetings
```

### Step 4: Remove the package
If you answered "no" on "Remove this package?" question after scaffolding you can remove 

```
composer remove fessnik/zoom
```

##### For Laravel < 5.5 
Open `config/app.php` and remove the provider:

```
Fessnik\Zoom\ZoomServiceProvider::class
```
