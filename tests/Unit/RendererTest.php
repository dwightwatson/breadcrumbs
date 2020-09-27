<?php

namespace Watson\Breadcrumbs\Tests\Unit;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\HtmlString;
use Mockery;
use Watson\Breadcrumbs\Renderer;

class RendererTest extends TestCase
{
    protected $renderer;

    function setUp(): void
    {
        parent::setUp();

        $this->view = Mockery::mock(Factory::class);
        $this->config = Mockery::mock(Repository::class);

        $this->renderer = new Renderer($this->view, $this->config);
    }

    /** @test */
    function it_renders_the_correct_view_with_breadcrumbs()
    {
        $this->config->shouldReceive('get')
            ->with('breadcrumbs.view')
            ->once()
            ->andReturn('index.html');

        $this->view->shouldReceive('make')
            ->with('index.html', ['breadcrumbs' => collect([1, 2, 3])])
            ->once()
            ->andReturn(new HtmlString('foo'));

        $result = $this->renderer->render(collect([1, 2, 3]));

        $this->assertEquals('foo', $result->toHtml());
        $this->assertInstanceOf(HtmlString::class, $result);
    }
}
