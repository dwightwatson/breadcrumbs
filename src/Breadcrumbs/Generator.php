<?php

namespace Watson\Breadcrumbs;

use Closure;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Generator
{
    /**
     * The router.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * The breadcrumb registrar.
     *
     * @var \Watson\Breadcrumbs\Registrar
     */
    protected $registrar;

    /**
     * The breadcrumb trail.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $breadcrumbs;

    /**
     * Create a new instance of the generator.
     *
     * @param  \Watson\Breadcrumbs\Route  $route
     * @param  \Watson\Breadcrumbs\Registrar  $registrar
     * @return void
     */
    public function __construct(Router $router, Registrar $registrar)
    {
        $this->router = $router;
        $this->registrar = $registrar;
        $this->breadcrumbs = new Collection;
    }

    /**
     * Register a definition with the registrar.
     *
     * @param  string  $name
     * @param  \Closure  $definition
     * @return void
     * @throws \Watson\Breadcrumbs\Exceptions\DefinitionAlreadyExists
     */
    public function register(string $name, Closure $definition)
    {
        $this->registrar->set($name, $definition);
    }

    /**
     * Generate the collection of breadcrumbs from the given route.
     *
     * @return \Illuminate\Support\Collection
     */
    public function generate(array $parameters = null): Collection
    {
        $route = $this->router->current();

        $parameters = isset($parameters) ? Arr::wrap($parameters) : $route->parameters;

        if ($route && $this->registrar->has($route->getName())) {
            $this->call($route->getName(), $parameters);
        }

        return $this->breadcrumbs;
    }

    /**
     * Call a extends route with the given parameters.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @return void
     */
    public function extends(string $name, ...$parameters)
    {
        $this->call($name, $parameters);
    }

    /**
     * Add a breadcrumb to the collection.
     *
     * @param  string  $title
     * @param  string  $url
     * @return void
     */
    public function then(string $title, string $url)
    {
        $this->breadcrumbs->push(new Crumb($title, $url));
    }

    /**
     * Call the breadcrumb definition with the given parameters.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @return void
     * @throws \Watson\Breadcrumbs\DefinitionNotFoundException
     */
    protected function call(string $name, array $parameters)
    {
        $definition = $this->registrar->get($name);

        $definition->bindTo($this);

        $definition(...$parameters);
    }
}
