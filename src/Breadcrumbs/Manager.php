<?php

namespace Watson\Breadcrumbs;

use Closure;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;

class Manager
{
    /**
     * The breadcrumb generator.
     *
     * @var \Watson\Breadcrumbs\Generator
     */
    protected $generator;

    /**
     * The breadcrumb renderer.
     *
     * @var \Watson\Breadcrumbs\Renderer
     */
    protected $renderer;

    /**
     * Create the instance of the manager.
     *
     * @return void
     */
    public function __construct(Router $router, Generator $generator, Renderer $renderer)
    {
        $this->router = $router;
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
    public function for(string $route, Closure $definition)
    {
        $this->generator->register($route, $definition);
    }

    /**
     * Render the breadcrumbs as an HTML string
     *
     * @return  \Illuminate\Contracts\Support\Htmlable
     */
    public function render(?string $name = null, ?array $parameters = []): ?Htmlable
    {
        $route = $this->router->current();

        $name = $name ?: $route->getName();

        if (is_null($name)) {
            return $this->renderer->render(collect());
        }

        $parameters = Arr::wrap(
            $parameters ?: $route->parameters
        );

        $breadcrumbs = $this->generator->generate($name, $parameters);

        return $this->renderer->render($breadcrumbs);
    }
}
