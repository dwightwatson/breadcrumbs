<?php

namespace Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Watson\Breadcrumbs\Exceptions\DefinitionAlreadyExistsException;

class DefinitionAlreadyExistsExceptionTest extends TestCase
{
    /** @test */
    function it_can_be_instantiated()
    {
        $result = new DefinitionAlreadyExistsException;

        $this->assertInstanceOf(DefinitionAlreadyExistsException::class, $result);
    }
}
