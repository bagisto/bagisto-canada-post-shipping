# Introduction

CanadaPost Shipping module provides Canada Post Shipping methods for shipping the product.

It packs in lots of demanding features that allows your business to scale in no time:

- The admin can enable or disable the Canada Post Shipping method.
- The admin can set the CanadaPost shipping method name that will be shown from the front side.
- The admin can define the allowed methods, weight units and rate type.
- Tax rate can be calculated based on Canada Post shipping


## Requirements:

- **Bagisto**: v1.3.1

## Installation with composer:
- Run the following command
```
composer require bagisto/bagisto-canada-post-shipping
```

- Run these commands below to complete the setup
```
composer dump-autoload
```

```
php artisan route:cache
php artisan config:cache
```

## Installation without composer:

- Unzip the respective extension zip and then merge "packages" folders into project root directory.
- Goto config/app.php file and add following line under 'providers'

```
Webkul\CanadaPost\Providers\CanadaPostServiceProvider::class
```

- Goto composer.json file and add following line under 'psr-4'

```
"Webkul\\CanadaPost\\": "packages/Webkul/CanadaPost/src"
```

- Run these commands below to complete the setup

```
composer dump-autoload
```

```
php artisan route:cache
```

> now execute the project on your specified domain.