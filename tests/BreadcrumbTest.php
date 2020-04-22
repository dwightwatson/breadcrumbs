<?php

namespace Watson\Breadcrumbs\Tests;

use Watson\Breadcrumbs\Breadcrumb;

class BreadcrumbTest extends TestCase
{
    /** @test */
    function it_returns_title()
    {
        $breadcrumb = new Breadcrumb('foo', 'bar');

        $this->assertEquals('foo', $breadcrumb->title());
    }

    /** @test */
    function it_returns_url()
    {
        $breadcrumb = new Breadcrumb('foo', 'bar');

        $this->assertEquals('bar', $breadcrumb->url());
    }

    /** @test */
    function it_returns_null_url()
    {
        $breadcrumb = new Breadcrumb('foo');

        $this->assertNull($breadcrumb->url());
    }
}
