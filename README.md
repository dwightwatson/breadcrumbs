Breadcrumbs for Laravel
=======================

[![Build Status](https://travis-ci.org/dwightwatson/breadcrumbs.svg?branch=master)](https://travis-ci.org/dwightwatson/breadcrumbs)
[![Total Downloads](https://poser.pugx.org/watson/breadcrumbs/downloads.svg)](https://packagist.org/packages/watson/breadcrumbs)
[![License](https://poser.pugx.org/watson/breadcrumbs/license.svg)](https://packagist.org/packages/watson/breadcrumbs)

Breadcrumbs is a simple breadcrumb generator for Laravel that tries to hook into the magic to make it easy to get up and running. It ships with support for Bootstrap 3 and 4 (with 4 the default) but it's easy to drop in your own view instead.

## Installation

Require the package through Composer as per usual.

```sh
$ composer require watson/breadcrumbs
```

## Usage

Create a new file at `routes/breadcrumbs.php` to define your breadcrumbs. By default the package will work with named routes which works with resourceful routing. However, you're also free to define routes by the controller action/pair.

```php
Breadcrumbs::for('home', function () {
    $this->then('Home', route('home'));
});

Breadcrumbs::for('users.index', function () {
    $this->extends('home')->then('Users', route('users.index'));
});

Breadcrumbs::for('users.show', function (User $user) {
    $this->extends('users.index')->then($user->full_name, route('users.show', $user));
});

Breadcrumbs::for('users.edit', function (User $user) {
    $this->extends('users.show', $user)->then($user->full_name, route('users.show', $user));
});
```

Note that you can call `extends()` from within a breadcrumb definition which lets you build up the breadcrumb tree. Pass any parameters you need further up through the second parameter.

### Rendering the breadcrumbs

In your view file, you simply need to call the `render()` method wherever you want your breadcrumbs to appear. It's that easy. If there are no breadcrumbs for the current route, then nothing will be returned.

```php
{{ Breadcrumbs::render() }}
```

### Customising the breadcrumb view

The package ships with a Bootstrap 3 compatible view which you can publish and customise as you need, or override completely with your own view. Simply run the following command to publish the view.

```sh
$ php artisan vendor:publish --provider="Watson\Breadcrumbs\ServiceProvider" --tag=views
```

This will publish the default `bootstrap4` view to your `resources/views/vendor/breadcrumbs` directory from which you can edit the file to your heart's content. If you want to use your own view instead, run the following command to publish the config file.

```sh
$ php artisan vendor:publish --provider="Watson\Breadcrumbs\ServiceProvider" --tag=config
```

This will publish `config/breadcrumbs.php` which provides you the option to set your own view file for your breadcrumbs.

## Credits

This package is inspired by the work of [Dave James Miller](https://github.com/davejamesmiller/laravel-breadcrumbs), which I've used for some time. It has been re-written by scratch for my use case with a little more magic and less customisation, plus taking advantage of some newer features in PHP. Many thanks to Dave for his work.
