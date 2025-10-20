<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Traits\HandlesGetMenuByRole;

class Dashboard extends Component
{
    use HandlesGetMenuByRole;
    public string $itemActivo = '';
    public $userRole;
    public $menuItems;

    public function mount()
    {
        $this->userRole = Auth::user()->role;
        $this->itemActivo = 'Inicio';
        $this->menuItems = $this->getMenuByRole($this->userRole);
    }

    public function render()
    {
        return view('livewire.views.dashboard');
    }
}
