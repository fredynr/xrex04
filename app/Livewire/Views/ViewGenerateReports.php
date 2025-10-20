<?php

namespace App\Livewire\Views;

use Livewire\Component;

class ViewGenerateReports extends Component
{
    public $currentComponent = "";
    public function showComponent($component)
    {
        $this->currentComponent = $component;
    } 


    public function render()
    {
        return view('livewire.views.view-generate-reports');
    }
}
