<?php

namespace Watson\Breadcrumbs\Tests;

use Watson\Breadcrumbs\Registrar;
use Watson\Breadcrumbs\Exceptions\DefinitionNotFoundException;
use Watson\Breadcrumbs\Exceptions\DefinitionAlreadyExistsException;

class RegistrarTest extends TestCase
{
    protected $registrar;

    function setUp(): void
    {
        parent::setUp();

        $this->registrar = new Registrar;
    }

    /** @test */
    function it_returns_an_existing_definition()
    {
        $closure = function () {
            return 'hello';
        };

        $this->registrar->set('foo', $closure);

        $result = $this->registrar->get('foo');

        $this->assertEquals($closure, $result);
    }

    /** @test */
    function it_throws_when_definition_does_not_exist()
    {
        $this->expectException(DefinitionNotFoundException::class);

        $this->registrar->get('foo');
    }

    /** @test */
    function it_returns_true_if_definition_exists()
    {
        $this->registrar->set('foo', function () {});

        $result = $this->registrar->has('foo');

        $this->assertTrue($result);
    }

    /** @test */
    function it_returns_false_if_definition_does_not_exist()
    {
        $result = $this->registrar->has('foo');

        $this->assertFalse($result);
    }

    /** @test */
    function it_throws_if_setting_existing_definition()
    {
        $this->expectException(DefinitionAlreadyExistsException::class);

        $closure = function () {
            return 'hello';
        };

        $this->registrar->set('foo', $closure);

        $this->registrar->set('foo', $closure);
    }
}
