<div class="w-[calc(100vw-300px)] px-4">
    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2 mb-4">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2">
                <span class="text-stone-800 font-medium">Hola, Dr(a) {{ Auth::user()->name }}</span>
                <h2 class="text-sm text-gray-500">Estas son tus plantillas. Puedes:</h2>
            </div>
            <div class="flex justify-between w-full">
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/templatePlus.svg') }}">
                        </span>
                    </div>
                    <span class="relative mt-1 text-sm">
                        <button wire:click="openDrawerCreateTemplate()"
                            class="relative left-1 text-[9px] text-sky-700 font-medium border-2 px-2 py-1 rounded-sm bg-blue-800/10 hover:bg-blue-800 hover:text-stone-50 cursor-pointer">
                            CREAR PLANTILLA
                        </button>
                        @if ($showDrawerCreateTemplate)
                            <div>
                                <livewire:drawers.drawer-create-template />
                            </div>
                        @endif
                        <span class="relative flex top-[-25px] size-2">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-sky-500"></span>
                        </span>
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/edit.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">EDITAR PLANTILLAS</span>
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/delete.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">ELIMINAR PLANTILLAS</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="flex items-center min-w-1/2">
            <label for="search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar...</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.1000="search" type="text" id="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Ingresa la busqueda..." />
            </div>
        </div>
    </div>
    <div x-data="{ visible: @entangle('mensajeVisible') }" x-init="$watch('visible', value => {
        if (value) {
            setTimeout(() => visible = false, 5000);
        }
    })" x-show="visible" x-transition
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
        {{ $mensajeTexto }}
    </div>

    <table class="min-w-full divide-y shadow-md divide-neutral-200/70">
        <thead class="bg-stone-50">
            <thead class="bg-stone-50">
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        ID
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        TÍTULO
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        CONTENIDO
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        FECHA DE CREACIÓN
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        ACCIONES
                    </span>
                </th>
            </thead>
        <tbody class="divide-y divide-neutral-200/70">
            @foreach ($templates as $template)
                <tr wire:key="{{ $template->id }}" class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200">
                    <td class="px-4 text-sm font-medium">{{ $template->id }}</td>
                    <td class="px-4 text-sm font-medium max-w-80">
                        @if ($editingId === $template->id)
                            <textarea wire:model="editingTitle" cols="40" rows="3" class="px-1"></textarea>
                        @else
                            {{ $template->title }}
                        @endif
                    </td>
                    <td class="px-4 py-1 max-w-90">
                        @if ($editingId === $template->id)
                            <textarea wire:model="editingContent" cols="60" rows="5" class="px-1 text-xs"></textarea>
                        @else
                            {{ $template->content }}
                        @endif
                    </td>
                    <td class="px-5 whitespace-nowrap">{{ $template->created_at }}</td>
                    <td class="px-5 whitespace-nowrap">
                        @if ($editingId === $template->id)
                            <div class="flex">
                                <button wire:click="saveUpdate({{ $template->id }})"
                                    class="flex flex-col items-center bg-gray-500/20 text-sky-700 hover:text-stone-50 hover:bg-blue-800/10 py-1 px-1 border-r-1 rounded-l-md cursor-pointer">
                                    <img src="{{ asset('images/save.svg') }}" width="20">
                                    <div class="text-[9px]">Guardar</div>
                                </button>
                                <button wire:click="cancelEditing"
                                    class="flex flex-col items-center bg-gray-500/20 text-sky-700 hover:text-stone-50 hover:bg-yellow-300/30 py-1 px-1 rounded-r-md cursor-pointer">
                                    <img src="{{ asset('images/backCancel.svg') }}" width="20">
                                    <div class="text-[9px]">Cancelar</div>
                                </button>
                            </div>
                        @else
                            <button wire:click="enableEditing({{ $template->id }})"
                                class="cursor-pointer hover:bg-green-500/20 py-1 px-2 rounded-md">
                                <img src="{{ asset('images/edit.svg') }}">
                            </button>
                            <button wire:click="deleteTemplate({{ $template->id }})"
                                wire:confirm="¿Estás seguro de eliminar la plantilla: {{ $template->title }}?"
                                class="cursor-pointer hover:bg-pink-100 rounded-lg px-1 py-1 mx-1 text-center">
                                <img src="{{ asset('images/delete.svg') }}">
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $templates->links('livewire::tailwind') }}
    </div>
</div>
