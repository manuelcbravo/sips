<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $id;
    public $required;
    public $titulo;
    public $multiple;
    public $class;

    public function __construct($id,$required,$titulo,$multiple,$class)
    {
        $this->id = $id;
        $this->required = $required;
        $this->titulo = $titulo;
        $this->multiple = $multiple;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
