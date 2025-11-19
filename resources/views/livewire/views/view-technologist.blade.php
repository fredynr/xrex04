<div x-data="{
    showDrawerStudyTech: @entangle('showDrawerStudyTech'),
}" class="px-4">
    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2 text-gray-500">Solicitudes pendientes por realizar:</div>
            <div class="flex justify-between w-full">
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/clock.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PENDIENTES:</span>
                        {{ $this->totalPendings }}
                    </span>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' => $currentTable === 'tables.table-pendings-to-do',
                ])>
                    <button wire:click="$dispatch('navigateTableTechnologist', ['tables.table-pendings-to-do']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/stacks.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">SOLICITUDES NUEVAS:</span>
                            {{ $this->totalExams }}
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' => $currentTable === 'tables.table-estudios-returned',
                ])>
                    <button wire:click="$dispatch('navigateTableTechnologist', ['tables.table-estudios-returned']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/undo.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">
                                ESTUDIOS DEVUELTOS:</span>
                            {{ $this->totalDevueltos }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex items-center min-w-1/2">
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscar</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text"
                    wire:input.debounce.500ms="searchMapTable($event.target.value, '{{ $currentTable }}')" id="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ingresa la busqueda..." />
            </div>
        </div>
    </div>
    <div class="bg-stone-50 mt-4">
        @switch($currentTable)
            @case('tables.table-pendings-to-do')
                @livewire('tables.table-pendings-to-do', ['search' => $search], key('pendings-' . $search))
            @break

            @case('tables.table-estudios-returned')
                @livewire('tables.table-estudios-returned', ['search' => $search], key($currentTable))
            @break

            @default
                <div class="p-4 text-gray-500">Vista no encontrada!!!!!!!!!!!!!!!!!!!</div>
        @endswitch
    </div>
</div>
