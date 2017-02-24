<?php

namespace Watson\Breadcrumbs;

class Breadcrumb
{
    /**
     * The breadcrumb title.
     *
     * @var string
     */
    protected $title;

    /**
     * The breacrumb URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Construct the breadcrumb instance.
     *
     * @param  string  $title
     * @param  string  $url
     * @return void
     */
    public function __construct(string $title, string $url = null)
    {
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * Get the breadcrumb title.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Get the breadcrumb URL.
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }
}
