<?php

namespace Watson\Breadcrumbs\Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\HtmlString;
use Illuminate\View\Factory;
use Mockery;
use Watson\Breadcrumbs\Generator;
use Watson\Breadcrumbs\Manager;
use Watson\Breadcrumbs\Route;

class ManagerTest extends TestCase
{
    protected $breadcrumbs;

    function setUp(): void
    {
        parent::setUp();

        $this->view = Mockery::mock(Factory::class);
        $this->config = Mockery::mock(Repository::class);
        $this->generator = Mockery::mock(Generator::class);

        $this->breadcrumbs = new Manager($this->view, $this->config, $this->generator);
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
    function it_renders_the_correct_view_with_breadcrumbs()
    {
        $this->generator->shouldReceive('generate')
            ->once()
            ->andReturn(collect([1, 2, 3]));

        $this->config->shouldReceive('get')
            ->with('breadcrumbs.view')
            ->once()
            ->andReturn('index.html');

        $this->view->shouldReceive('make')
            ->with('index.html', ['breadcrumbs' => collect([1, 2, 3])])
            ->once()
            ->andReturn(new HtmlString('foo'));

        $result = $this->breadcrumbs->render();

        $this->assertEquals('foo', $result->toHtml());
        $this->assertInstanceOf(HtmlString::class, $result);
    }
}
