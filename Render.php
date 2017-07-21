<?php

namespace Watson\Breadcrumbs;

use Illuminate\View\View;
use Illuminate\Contracts\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\Factory as FactoryContract;
class Renderer
{
    /**
     * The view factory instance.
     *
     * @var \Illuminate\View\Factory
     */
    protected $factory;

    /**
     * Construct the renderer instance.
     *
     * @param  \Illuminate\View\Factory  $factory
     * @return void
     */
    public function __construct(FactoryContract $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Render the given breadcrumbs into the given view.
     *
     * @param  string  $view
     * @param  \Illuminate\Support\Collection  $breadcrumbs
     * @return \Illuminate\Support\HtmlString
     */
    public function render(string $view, Collection $breadcrumbs): HtmlString
    {
        return new HtmlString(
            $this->makeView($view, $breadcrumbs)->render()
        );
    }

    /**
    * Get a view instance of the given view file with breadcrumbs.
    *
    * @param  string  $view
    * @param  \Illuminate\Support\Collection  $breadcrumbs
    * @return \Illuminate\View\View
    */
    protected function makeView(string $view, Collection $breadcrumbs): View
    {
        return $this->factory->make($view, compact('breadcrumbs'));
    }
}
