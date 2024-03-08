<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $size;
    public $nombretitulo;

    public function __construct($id,$size,$nombretitulo)
    {
        $this->id = $id;
        $this->size = $size;
        $this->nombretitulo = $nombretitulo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.modal');
    }
}
