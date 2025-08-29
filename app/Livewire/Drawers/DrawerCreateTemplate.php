<?php

namespace App\Livewire\Drawers;

use Livewire\Component;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;

class DrawerCreateTemplate extends Component
{
    public $content;
    public $title;

    protected $rulesForCreate = [
        'title' => 'required',
        'content' => 'required'
    ];

    public function closeDrawer()
    {
        $this->dispatch('close-drawer-create-template');
        $this->reset();
    }

    public function saveTemplate()
    {
        $this->validate($this->rulesForCreate);
        try {
            Template::create([
                'title' => $this->title,
                'content' => $this->content,
                'user_id' => Auth::id()
            ]);
            $this->closeDrawer();
        } catch (\Exception $e) {
            session()->flash('error', 'No se pudo crear la plantilla');
        }
        $this->closeDrawer();
    }
    public function render()
    {
        return view('livewire.drawers.drawer-create-template');
    }
}
