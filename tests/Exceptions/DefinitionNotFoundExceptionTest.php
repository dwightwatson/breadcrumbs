<?php

namespace Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Watson\Breadcrumbs\Exceptions\DefinitionNotFoundException;

class DefinitionNotFoundExceptionTest extends TestCase
{
    /** @test */
    function it_can_be_instantiated()
    {
        $result = new DefinitionNotFoundException;

        $this->assertInstanceOf(DefinitionNotFoundException::class, $result);
    }
}
