<?php

namespace Watson\Breadcrumbs;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Arr;

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
    * @param  \Illuminate\Contracts\Routing\Registrar  $registrar
    * @return void
    */
    public function __construct(Registrar $registrar)
    {
        $this->route = $registrar->current();
    }

    /**
     * Get whether a current route is present.
     *
     * @return bool
     */
    public function present(): bool
    {
        return ! is_null($this->route);
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

        $namespace = Arr::get($this->route->getAction(), 'namespace');

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
