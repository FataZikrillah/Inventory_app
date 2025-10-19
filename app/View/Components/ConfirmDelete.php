<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmDelete extends Component
{
    public $route, $id;
    /**
     * Create a new component instance.
     */
    public function __construct($route, $id)
    {
        $this->route = $route;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirm-delete');
    }
}
