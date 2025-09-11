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
                'icon'  => 'images/scan.svg',
            ],
            [
                'label' => 'Admin, plantillas',
                'navigate'  => 'tables.table-template',
                'icon'  => 'images/template.svg',
            ],
            [
                'label' => 'Entrega de estudios',
                'navigate'  => 'tables.table-delivery-estudio',
                'icon'  => 'images/handPackage.svg',
            ],
            [
                'label' => 'Módulo, Transcribir',
                'navigate'  => 'views.view-transcriber',
                'icon'  => 'images/keyboard.svg',
            ],
            [
                'label' => 'Aprovar Transcripción',
                'navigate'  => 'views.view-approve',
                'icon'  => 'images/cardMed.svg',
            ],
            [
                'label' => 'prueba',
                'navigate'  => 'views.view-prueba',
                'icon'  => 'images/keyboard.svg',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
