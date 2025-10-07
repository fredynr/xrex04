<?php

namespace App\Livewire\Views;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Template;

class ViewTemplates extends Component
{
    use WithPagination;

    public $editingTitle;
    public $editingContent;
    public $editingId = null;
    public $showDrawerCreateTemplate = false;

    public $search = '';
    public $mensajeTexto = '';
    public $mensajeVisible = false;

    protected $rules = [
        'editingTitle' => 'required|string|max:255',
        'editingContent' => 'required|string',
    ];

    public function openDrawerCreateTemplate()
    {
        $this->showDrawerCreateTemplate = true;
    }

    #[On('close-drawer-create-template')]
    public function closeDrawerCreateTemplate()
    {
        $this->showDrawerCreateTemplate = false;
        $this->resetPage();
    }

    public function deleteTemplate($id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        $this->mensajeTexto = '¡Registro eliminado correctamente!';
        $this->mensajeVisible = true;
    }

    public function enableEditing($templateId)
    {
        $this->editingId = $templateId;
        $template = Template::find($templateId);
        $this->editingTitle = $template->title;
        // $this->editingContent = $template->content;
        $this->editingContent = str_replace('<br />', "\n", $template->content);
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->resetValidation();
    }

    public function saveUpdate($templateId)
    {
        $this->validate();
        $template = Template::find($templateId);
        $template->update([
            'title' => $this->editingTitle,
            // 'content' => $this->editingContent,
            'content' => nl2br($this->editingContent),
        ]);
        $this->editingId = null;
        session()->flash('message', 'Template actualizado correctamente.');
    }


    public function render()
    {
        $query = Template::where('user_id', Auth::id());

        if (strlen(trim($this->search)) >= 3) {
            $query->where(function ($subQuery) {
                $subQuery->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        $templates = $query->paginate(10);

        return view('livewire.views.view-templates', compact('templates'));
    }
}
