<?php

namespace Watson\Breadcrumbs\Tests;

use Watson\Breadcrumbs\Crumb;

class CrumbTest extends TestCase
{
    /** @test */
    function it_returns_title()
    {
        $crumb = new Crumb('foo', 'bar');

        $this->assertEquals('foo', $crumb->title());
    }

    /** @test */
    function it_returns_url()
    {
        $crumb = new Crumb('foo', 'bar');

        $this->assertEquals('bar', $crumb->url());
    }

    /** @test */
    function it_returns_null_url()
    {
        $crumb = new Crumb('foo');

        $this->assertNull($crumb->url());
    }
}
