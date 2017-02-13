<?php

namespace Watson\Breadcrumbs;

use Closure;
use Watson\Breadcrumbs\Exceptions\DefinitionNotFoundException;
use Watson\Breadcrumbs\Exceptions\DefinitionAlreadyExistsException;

class Registrar
{
    /**
     * Breadcrumb definitions.
     *
     * @var array
     */
    protected $definitions = [];

    /**
     * Get a definition for a route name.
     *
     * @param  string  $name
     * @return \Closure
     * @throws \Watson\Breadcrumbs\DefinitionNotFoundException
     */
    public function get(string $name): Closure
    {
        if ( ! $this->has($name)) {
            throw new DefinitionNotFoundException("No breadcrumbs defined for route [{$name}].");
        }

        return $this->definitions[$name];
    }

    /**
     * Return whether a definition exists for a route name
     *
     * @param  string  $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->definitions);
    }

    /**
     * Set the registration for a route name.
     *
     * @param  string  $name
     * @param  \Closure  $definition
     * @return void
     * @throws \Watson\Breadcrumbs\DefinitionAlreadyExists
     */
    public function set(string $name, Closure $definition)
    {
        if ($this->has($name)) {
            throw new DefinitionAlreadyExistsException(
                "Breadcrumbs have already been defined for route [{$name}]."
            );
        }

        $this->definitions[$name] = $definition;
    }
}
