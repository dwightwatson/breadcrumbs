<?php

namespace Tests;

use Mockery;
use Watson\Breadcrumbs\Route;
use PHPUnit\Framework\TestCase;
use Watson\Breadcrumbs\Manager;
use Watson\Breadcrumbs\Renderer;
use Watson\Breadcrumbs\Generator;

class ManagerTest extends TestCase
{
    protected $breadcrumbs;

    function setUp()
    {
        parent::setUp();

        $this->renderer = Mockery::mock(Renderer::class);
        $this->generator = Mockery::mock(Generator::class);

        $this->breadcrumbs = new Manager(
            $this->renderer,
            $this->generator
        );
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
}
