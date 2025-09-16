<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public string $itemActivo = '';
    public $userRole;

    public $menuItems;

    public function mount()
    {
        $this->userRole = Auth::user()->role;
        $this->itemActivo = 'Módulo, lectura de estudios';
        $this->menuItems = $this->getMenuByRole($this->userRole);
    }
    private function getMenuByRole($role)
{
    $allItems = [
        [
            'label' => 'Módulo, lectura de estudios',
            'navigate' => 'views.view-specialist',
            'icon' => 'images/notePerson.svg',
            'roles' => ['Especialista', 'admin'],
        ],
        [
            'label' => 'Módulo, toma de estudios',
            'navigate' => 'views.view-technologist',
            'icon' => 'images/scan.svg',
            'roles' => ['Tecnólogo', 'admin'],
        ],
        [
            'label' => 'Admin, plantillas',
            'navigate' => 'tables.table-template',
            'icon' => 'images/template.svg',
            'roles' => ['Especialista', 'admin'],
        ],
        [
            'label' => 'Entrega de estudios',
            'navigate' => 'tables.table-delivery-estudio',
            'icon' => 'images/handPackage.svg',
            'roles' => ['Especialista', 'admin'],
        ],
        [
            'label' => 'Módulo, Transcribir',
            'navigate' => 'views.view-transcriber',
            'icon' => 'images/keyboard.svg',
            'roles' => ['transcriber', 'admin'],
        ],
        [
            'label' => 'Aprovar Transcripción',
            'navigate' => 'views.view-approve',
            'icon' => 'images/cardMed.svg',
            'roles' => ['admin'], // si decides usarlo luego
        ],
        [
            'label' => 'prueba',
            'navigate' => 'views.view-prueba',
            'icon' => 'images/keyboard.svg',
            'roles' => ['admin'], // opcional
        ],
    ];

    return collect($allItems)
        ->filter(fn($item) => in_array($role, $item['roles']))
        ->values()
        ->toArray();
}

    // public function mount()
    // {
    //     $this->userRole = Auth::user()->role; 
    //     $this->itemActivo = 'Módulo, lectura de estudios';

    //     $this->menuItems = [
    //         [
    //             'label' => 'Módulo, lectura de estudios',
    //             'navigate'  => 'views.view-specialist',
    //             'icon'  => 'images/notePerson.svg',
    //         ],
    //         [
    //             'label' => 'Módulo, toma de estudios',
    //             'navigate'  => 'views.view-technologist',
    //             'icon'  => 'images/scan.svg',
    //         ],
    //         [
    //             'label' => 'Admin, plantillas',
    //             'navigate'  => 'tables.table-template',
    //             'icon'  => 'images/template.svg',
    //         ],
    //         [
    //             'label' => 'Entrega de estudios',
    //             'navigate'  => 'tables.table-delivery-estudio',
    //             'icon'  => 'images/handPackage.svg',
    //         ],
    //         [
    //             'label' => 'Módulo, Transcribir',
    //             'navigate'  => 'views.view-transcriber',
    //             'icon'  => 'images/keyboard.svg',
    //         ],
    //         [
    //             'label' => 'Aprovar Transcripción',
    //             'navigate'  => 'views.view-approve',
    //             'icon'  => 'images/cardMed.svg',
    //         ],
    //         [
    //             'label' => 'prueba',
    //             'navigate'  => 'views.view-prueba',
    //             'icon'  => 'images/keyboard.svg',
    //         ],
    //     ];
    // }

    public function render()
    {
        return view('livewire.components.sidebar');
    }
}
