<?php

namespace Tests;

use Mockery;
use Watson\Breadcrumbs\Route;
use PHPUnit\Framework\TestCase;
use Illuminate\Routing\Route as BaseRoute;

class RouteTest extends TestCase
{
    protected $route;

    function setUp()
    {
        $this->baseRoute = Mockery::mock(BaseRoute::class)->shouldDeferMissing();

        $this->route = new Route($this->baseRoute);
    }

    /** @test */
    function it_gets_the_route_name()
    {
        $this->baseRoute->shouldReceive('getName')
            ->once()
            ->andReturn('pages.index');

        $result = $this->route->name();

        $this->assertEquals('pages.index', $result);
    }

    /** @test */
    function it_gets_the_controller_action_name()
    {
        $this->baseRoute->shouldReceive('getActionName')
            ->andReturn('App\\Http\\Controllers\\PagesController@getIndex');

        $this->baseRoute->shouldReceive('getAction')
            ->andReturn(['namespace' => 'App\\Http\\Controllers']);

        $result = $this->route->name();

        $this->assertEquals('PagesController@getIndex', $result);
    }


    /** @test */
    function it_returns_null_if_closure()
    {
        $this->baseRoute->shouldReceive('getActionName')->andReturn('Closure');

        $result = $this->route->name();

        $this->assertNull($result);
    }

    /** @test */
    function it_returns_parameters()
    {
        $this->baseRoute->shouldReceive('parameters')
            ->andReturn(['foo' => 'bar']);

        $result = $this->route->parameters();

        $this->assertEquals(['foo' => 'bar'], $result);
    }
}
