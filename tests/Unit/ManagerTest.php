<?php

namespace Watson\Breadcrumbs\Tests\Unit;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Support\HtmlString;
use Mockery;
use Watson\Breadcrumbs\Generator;
use Watson\Breadcrumbs\Manager;
use Watson\Breadcrumbs\Renderer;

class ManagerTest extends TestCase
{
    protected $breadcrumbs;

    function setUp(): void
    {
        parent::setUp();

        $this->router = Mockery::mock(Registrar::class);
        $this->generator = Mockery::mock(Generator::class);
        $this->renderer = Mockery::mock(Renderer::class);

        $this->breadcrumbs = new Manager($this->router, $this->generator, $this->renderer);
    }

    /** @test */
    function it_passes_registrations_to_registrar()
    {
        $closure = function () {
            return 'hello';
        };

        $this->generator->shouldReceive('register')
            ->with('foo', $closure)
            ->once();

        $this->breadcrumbs->for('foo', $closure);
    }

    /** @test */
    function it_renders_with_the_current_route()
    {
        $route = new Route('GET', '/', ['as' =>'home']);

        $this->router->shouldReceive('current')
            ->once()
            ->andReturn($route);

        $breadcrumbs = collect([1, 2, 3]);

        $this->generator->shouldReceive('generate')
            ->once()
            ->with($route)
            ->andReturn($breadcrumbs);

        $this->renderer->shouldReceive('render')
            ->once()
            ->with($breadcrumbs)
            ->andReturn(new HtmlString('foo'));

        $result = $this->breadcrumbs->render();

        $this->assertEquals('foo', $result->toHtml());
        $this->assertInstanceOf(HtmlString::class, $result);
    }
}
