<?php

namespace Watson\Breadcrumbs;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;

class Renderer
{
    /**
     * The view factory.
     */
    protected Factory $view;

    /**
     * The config repository.
     */
    protected Repository $config;

    /**
     * Create a new renderer instance.
     *
     * @return void
     */
    public function __construct(Factory $view, Repository $config)
    {
        $this->view = $view;
        $this->config = $config;
    }

    /**
     * Render the given breadcrumbs if any are provided.
     */
    public function render(Collection $breadcrumbs): ?Htmlable
    {
        return $this->view->make($this->config->get('breadcrumbs.view'), compact('breadcrumbs'));
    }
}
