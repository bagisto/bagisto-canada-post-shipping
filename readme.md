# Introduction

CanadaPost Shipping module provides Canada Post Shipping methods for shipping the product.

It packs in lots of demanding features that allows your business to scale in no time:

- The admin can enable or disable the Canada Post Shipping method.
- The admin can set the CanadaPost shipping method name that will be shown from the front side.
- The admin can define the allowed methods, weight units and rate type.
- Tax rate can be calculated based on Canada Post shipping


## Requirements:

- **Bagisto**: v1.3.1

## Installation :
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

> now execute the project on your specified domain.
