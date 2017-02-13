<?php

namespace Tests;

use Mockery;
use Illuminate\View\View;
use Illuminate\View\Factory;
use PHPUnit\Framework\TestCase;
use Watson\Breadcrumbs\Renderer;
use Illuminate\Support\HtmlString;

class RendererTest extends TestCase
{
    function setUp()
    {
        parent::setUp();

        $this->factory = Mockery::mock(Factory::class);

        $this->renderer = new Renderer($this->factory);
    }

    /** @test */
    function it_renders_the_correct_view_with_breadcrumbs()
    {
        $view = Mockery::mock(View::class);

        $view->shouldReceive('render')
            ->once()
            ->andReturn(new HtmlString('foo'));

        $this->factory->shouldReceive('make')
            ->with('index.html', ['breadcrumbs' => collect([1, 2, 3])])
            ->once()
            ->andReturn($view);

        $result = $this->renderer->render('index.html', collect([1, 2, 3]));

        $this->assertEquals('foo', $result->toHtml());
        $this->assertInstanceOf(HtmlString::class, $result);
    }
}
