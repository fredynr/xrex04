<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Sidebar extends Component
{
    public string $itemActivo = '';

    public $menuItems;

    public function mount()
    {
        $this->itemActivo = 'Módulo, lectura de estudios';

        $this->menuItems = [
            [
                'label' => 'Módulo, lectura de estudios',
                'navigate'  => 'views.view-specialist',
                'icon'  => 'images/notePerson.svg',
            ],
            [
                'label' => 'Módulo, toma de estudios',
                'navigate'  => 'views.view-technologist',
                'icon'  => 'images/cardMed.svg',
            ],
            [
                'label' => 'Admin, plantillas',
                'navigate'  => 'tables.table-template',
                'icon'  => 'images/scan.svg',
            ],
            [
                'label' => 'Entrega de estudios',
                'navigate'  => 'tables.table-delivery-estudio',
                'icon'  => 'images/template.svg',
            ],
            [
                'label' => 'Módulo, Transcribir',
                'navigate'  => 'views.view-transcriber',
                'icon'  => 'images/handPackage.svg',
            ],
            [
                'label' => 'Aprovar Transcripción',
                'navigate'  => 'views.view-approve',
                'icon'  => 'images/keyboard.svg',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
