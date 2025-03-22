<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $action;
    public $id;
    public $title;
    public $restore;
    public function __construct($action, $id, $title = 'Konfirmasi Hapus', $restore = false)
    {
        $this->action = $action;
        $this->id = $id;
        $this->title = $title;
        $this->restore = $restore;
    }

    public function render()
    {
        return view('components.modal');
    }
}
