<?php

namespace Watson\Breadcrumbs\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Watson\Breadcrumbs\Facades\Breadcrumbs;
use Watson\Breadcrumbs\Facades\Trail;

class BreadcrumbsTest extends TestCase
{
    /** @test */
    public function it_renders_breadcrumb_for_the_current_route()
    {
        Route::get('/')->name('home');

        $this->call('GET', '/');

        Breadcrumbs::for('home', function () {
            $this->then('Home', '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertStringContainsString('Home', $breadcrumbs->render());
    }

    /** @test */
    public function it_renders_breadcrumb_for_the_given_route()
    {
        Route::get('/users/{user}')->name('users.show');

        Breadcrumbs::for('users.show', function (string $user) {
            $this->then($user, '/');
        });

        $breadcrumbs = Breadcrumbs::render('users.show', ['foo']);

        $this->assertStringContainsString('foo', $breadcrumbs->render());
    }

    /** @test */
    public function it_renders_breadcrumb_for_the_current_route_with_facade()
    {
        Route::get('/')->name('home');

        $this->call('GET', '/');

        Breadcrumbs::for('home', function () {
            Trail::then('Home', '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertStringContainsString('Home', $breadcrumbs->render());
    }

    /** @test */
    public function it_renders_breadcrumb_for_the_current_route_with_parameters()
    {
        Route::get('/users/{user}')->name('home');

        $this->call('GET', '/users/taylor');

        Breadcrumbs::for('home', function (string $user) {
            $this->then($user, '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertStringContainsString('taylor', $breadcrumbs->render());
    }

    /** @test */
    public function it_renders_breadcrumb_for_the_current_route_with_bound_paramters()
    {
        $this->loadLaravelMigrations();

        DB::table('users')->insert(['name' => 'taylor', 'email' => 'taylor@example.com', 'password' => 'secret']);

        Route::get('/users/{user}', function (User $user) {
            //
        })->middleware(SubstituteBindings::class)->name('home');

        $this->call('GET', '/users/1');

        Breadcrumbs::for('home', function (User $user) {
            $this->then($user, '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertStringContainsString('taylor', $breadcrumbs->render());
    }

    /** @test */
    public function it_renders_nested_breadcrumbs()
    {
        Route::get('/')->name('home');
        Route::get('/users/{user}')->name('users.show');

        $this->call('GET', '/users/taylor');

        Breadcrumbs::for('home', function () {
            $this->then('Home', '/');
        });

        Breadcrumbs::for('users.show', function (string $user) {
            $this->extends('home')->then($user, '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertStringContainsString('Home', $breadcrumbs->render());
        $this->assertStringContainsString('taylor', $breadcrumbs->render());
    }

    /** @test */
    public function it_does_not_render_breadcrumbs_without_named_route()
    {
        Route::get('/');

        $this->call('GET', '/');

        Breadcrumbs::for('home', function () {
            $this->then('Home', '/');
        });

        $breadcrumbs = Breadcrumbs::render();

        $this->assertEquals('', $breadcrumbs->render());
    }

    /** @test */
    public function it_does_not_render_breadcrumbs_without_matching_breadcrumb()
    {
        Route::get('/')->name('home');

        $this->call('GET', '/');

        $breadcrumbs = Breadcrumbs::render();

        $this->assertEquals('', $breadcrumbs->render());
    }
}

class User extends Model
{
    //
}
