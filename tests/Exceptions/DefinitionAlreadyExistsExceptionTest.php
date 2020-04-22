<?php

namespace Watson\Breadcrumbs\Tests\Exceptions;

use Watson\Breadcrumbs\Exceptions\DefinitionAlreadyExistsException;
use Watson\Breadcrumbs\Tests\TestCase;

class DefinitionAlreadyExistsExceptionTest extends TestCase
{
    /** @test */
    function it_can_be_instantiated()
    {
        $result = new DefinitionAlreadyExistsException;

        $this->assertInstanceOf(DefinitionAlreadyExistsException::class, $result);
    }
}
