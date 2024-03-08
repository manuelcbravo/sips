<?php

namespace App\View\Components\form;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $options;
    public $titulo;
    public $tipo;
    public $holder;
    public $validationclass;
    public $required;
    public $error;

    public function __construct($id,$options,$titulo,$tipo,$holder,$validationclass, $required, $error)
    {
        $this->id = $id;
        $this->options = $options;
        $this->titulo = $titulo;
        $this->tipo = $tipo;
        $this->holder = $holder ?? '';
        $this->validationclass = $validationclass ?? '';
        $this->required = $required;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
