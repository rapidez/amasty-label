# Rapidez Amasty Label

## Requirements

You need to have the [Amasty Product Labels](https://amasty.com/product-labels-for-magento-2.html) module installed and configured within your Magento 2 installation.

## Installation

```
composer require rapidez/amasty-label
```

If you haven't published the Rapidez views yet, publish them with:
```
php artisan vendor:publish --provider="Rapidez\Core\RapidezServiceProvider" --tag=views
```

### Product page

Add `@include('amastylabel::product')` where you'd like to display the labels, most likely somewhere around the images: `resources/views/vendor/rapidez/product/overview.blade.php`.

### Category page

Add `@include('amastylabel::category')` in: `resources/views/vendor/rapidez/category/partials/listing/item.blade.php`.

## Views

If you need to change the views you can publish them with:
```
php artisan vendor:publish --provider="Rapidez\AmastyLabel\AmastyLabelServiceProvider" --tag=views
```

## Note

Not all features are implemented yet! For example the priorities and shape/image label types aren't supported.
