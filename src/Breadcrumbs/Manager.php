<?php

namespace Watson\Breadcrumbs;

use Closure;
use Illuminate\Support\HtmlString;

class Manager
{
    /**
     * Create the instance of the manager.
     *
     * @param  \Watson\Breadcrumbs\Renderer  $renderer
     * @param  \Watson\Breadcrumbs\Generator  $generator
     * @return void
     */
    public function __construct(Renderer $renderer, Generator $generator)
    {
        $this->renderer = $renderer;
        $this->generator = $generator;
    }

    /**
     * Register a breadcrumb definition by passing it off to the registrar.
     *
     * @param  string  $route
     * @param  \Closure  $definition
     * @return void
     */
    public function for(string $route, Closure $definition): void
    {
        $this->generator->register($route, $definition);
    }

    /**
     * Render the breadcrumbs as an HTML string.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render(): ?HtmlString
    {
        if ($breadcrumbs = $this->generator->generate()) {
            return $this->renderer->render(config('breadcrumbs.view'), $breadcrumbs);
        }
    }
}
