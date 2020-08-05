Breadcrumbs for Laravel
=======================

## Warning: this package is currently incompatible with Laravel 7. I have started a rewrite that would support Laravel 7 but I have no ETA. You'll likely want to consider another breadcrumb package in the meantime.

[![Build Status](https://travis-ci.org/dwightwatson/breadcrumbs.svg?branch=master)](https://travis-ci.org/dwightwatson/breadcrumbs)
[![Total Downloads](https://poser.pugx.org/watson/breadcrumbs/downloads.svg)](https://packagist.org/packages/watson/breadcrumbs)
[![License](https://poser.pugx.org/watson/breadcrumbs/license.svg)](https://packagist.org/packages/watson/breadcrumbs)

Breadcrumbs is a simple breadcrumb generator for Laravel that tries to hook into the magic to make it easy to get up and running.

## Installation

Require the package through Composer as per usual.

```sh
$ composer require watson/breadcrumbs
```

## Usage

Create a new file at `routes/breadcrumbs.php` to define your breadcrumbs. By default the package will work with named routes which works with resourceful routing. However, you're also free to define routes by the controller action/pair.

```php
Breadcrumbs::for('admin.pages.index', function ($trail) {
    $trail->add('Admin', route('admin.pages.index'));
});

Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.pages.index');
    $trail->add('Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.show', function ($trail, User $user) {
    $trail->parent('admin.users.index');
    $trail->add($user->full_name, route('admin.users.show', $user));
});

Breadcrumbs::for('admin.users.edit', function ($trail, User $user) {
    $trail->parent('admin.users.show', $user);
    $trail->add('Edit', route('admin.users.edit', $user));
});

Breadcrumbs::for('admin.users.roles.index', function ($trail, User $user) {
    $trail->parent('admin.users.show', $user);
    $trail->add('Roles', route('admin.users.roles.index', $user));
});

Breadcrumbs::for('admin.users.roles.show', function ($trail, User $user, Role $role) {
    $trail->parent('admin.users.roles.index', $user, $role);
    $trail->add('Edit', route('admin.users.roles.show', [$user, $role]));
});
```

Note that you can call `parent()` from within a breadcrumb definition which lets you build up the breadcrumb tree. Pass any parameters you need further up through the second parameter.

If you want to use controller/action pairs instead of named routes that's fine too. Use the usual Laravel syntax and the package will correctly map it up for you. Note that if the route is named the package will always looked for a named breadcrumb first.

```php
Breadcrumbs::for('PagesController@getIndex', function ($trail) {
    $trail->add('Home', action('PagesController@getIndex'));
});

Breadcrumbs::for('secret.page', function ($trail) {
    $trail->add('Secret page', url('secret'))
});
```

### Rendering the breadcrumbs

In your view file, you simply need to call the `render()` method wherever you want your breadcrumbs to appear. It's that easy. If there are no breadcrumbs for the current route, then nothing will be returned.

```php
{{ Breadcrumbs::render() }}
```

You don't need to escape the content of the breadcrumbs, it's already wrapped in an instance of `Illuminate\Support\HtmlString` so Laravel knows just how to use it.

### Multiple breadcrumb files

If you find that your breadcrumbs files is starting to get a little bigger you may like to break it out into multiple, smaller files. If that's the case you can simply `require` other breadcrumb files at the top of your default definition file.

```php
require 'breadcrumbs.admin.php';
```

### Customising the breadcrumb view

The package ships with a Bootstrap 3 compatible view which you can publish and customise as you need, or override completely with your own view. Simply run the following command to publish the view.

```sh
$ php artisan vendor:publish --provider="Watson\Breadcrumbs\ServiceProvider" --tag=views
```

This will publish the default `bootstrap3` view to your `resources/views/vendor/breadcrumbs` directory from which you can edit the file to your heart's content. If you want to use your own view instead, run the following command to publish the config file.

```sh
$ php artisan vendor:publish --provider="Watson\Breadcrumbs\ServiceProvider" --tag=config
```

This will publish `config/breadcrumbs.php` which provides you the option to set your own view file for your breadcrumbs.

## Credits

This package is inspired by the work of [Dave James Miller](https://github.com/davejamesmiller/laravel-breadcrumbs), which I've used for some time. It has been re-written by scratch for my use case with a little more magic and less customisation, plus taking advantage of some newer features in PHP. Many thanks to Dave for his work.
