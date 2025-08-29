<?php

namespace App\Livewire;

use Livewire\Component;

class AppLayout extends Component
{
    public $currentView = 'views.view-specialist';
    protected $listeners = ['navigateTo'];
    public function navigateTo($view)
    {
        $this->currentView = $view;
    }

    public function render()
    {
        return view('livewire.app-layout', [
            'currentView' => $this->currentView
        ]);
    }
}
