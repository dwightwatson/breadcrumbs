<?php

namespace Watson\Breadcrumbs;

use Illuminate\Routing\Route as BaseRoute;

class Route
{
    /**
     * The base router instance.
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;

    /**
    * Construct the route instance.
    *
    * @param  \Illuminate\Routing\Route
    * @return void
    */
    public function __construct(BaseRoute $route)
    {
        $this->route = $route;
    }

    /**
     * Get the current route name or controller/action pair.
     *
     * @return string
     */
    public function name()
    {
        if ($name = $this->route->getName()) {
            return $name;
        }

        $name = $this->route->getActionName();

        if ($name === 'Closure') {
            return null;
        }

        $namespace = array_get($this->route->getAction(), 'namespace');

        return str_replace($namespace . '\\', '', $name);
    }

    /**
     * Get the current route parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return $this->route->parameters();
    }
}
