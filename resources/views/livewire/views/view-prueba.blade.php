<div>
    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2 text-gray-500">Estudios pendientes por lectura:</div>
            <div class="flex justify-between w-full">
                <div><button wire:click="sendWorklistToOrthanc" class="bg-blue-400 rounded-xl text-white cursor-pointer">enviar a orthanc</button></div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentTable === 'tables.table-pendings-to-read',
                ])>
                    <button
                        wire:click="$dispatch('navigateTableSpecialist', ['tables.table-pendings-to-read']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/clock.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">PENDIENTES:</span>
                            {{ $this->totalEstudios }}
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentTable === 'tables.table-high-priority',
                ])>
                    <button
                        wire:click="$dispatch('navigateTableSpecialist', ['tables.table-high-priority']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/alertTriangle.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD ALTA:</span>
                            {{ $countAlta }}
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentTable === 'tables.table-normal-priority',
                ])>
                    <button
                        wire:click="$dispatch('navigateTableSpecialist', ['tables.table-normal-priority']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/hand.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD NORMAL:</span>
                            {{ $countNormal }}
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentTable === 'tables.table-low-priority',
                ])>
                    <button
                        wire:click="$dispatch('navigateTableSpecialist', ['tables.table-low-priority']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/flag.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD BAJA:</span>
                            {{ $countBaja }}
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentTable === 'tables.table-corrected',
                ])>
                    <button
                        wire:click="$dispatch('navigateTableSpecialist', ['tables.table-corrected']); $dispatch('cleanURL')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/undo.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">CORREGIDOS:</span>
                            {{ $totalCorrected }}
                        </span>
                    </button>
                </div>

                <div x-data="{ showFilterDate: false }" class="flex items-center min-w-1/2">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscar</label>
                    <div class="flex relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text"
                            wire:input.debounce.500ms="searchMapTable($event.target.value, '{{ $currentTable }}')"
                            id="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-l-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ingresa la busqueda..." />
                        <button class="bg-gray-50 rounded-r-lg px-2 border border-gray-300 cursor-pointer"
                            @click="showFilterDate = !showFilterDate" type="button"><img
                                src="{{ asset('images/calendar.svg') }}" width="24"></button>
                    </div>
                    <div x-show="showFilterDate"
                        class="flex justify-center w-full h-[100vh] fixed top-0 z-1008 left-0 bg-stone-200/80">
                        <div class="flex flex-col mt-8 bg-white h-[70vh] max-w-[800px] rounded-lg shadow-lg">
                            <div
                                class="flex items-center justify-center w-full rounded-t-xl h-[4rem] text-lg text-stone-400 bg-stone-100">
                                Buscar por fechas
                            </div>
                            <div class="flex p-6">
                                <div class="flex flex-col mr-4 space-y-2">
                                    <label for="startDate" class="text-xs text-gray-500">Fecha de inicio</label>
                                    <input type="datetime-local" id="startDate" wire:model="startDate"
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-800 bg-white">
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <label for="endDate" class="text-xs text-gray-500">Fecha de fin</label>
                                    <input type="datetime-local" id="endDate" wire:model="endDate"
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-800 bg-white">
                                </div>
                            </div>
                            <div class="flex items-center justify-center mt-4">
                                <button @click="showFilterDate = false"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Aceptar
                                </button>
                                <button
                                    class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <div class="bg-stone-50 mt-4">
        @switch($currentTable)
            @case('tables.table-pendings-to-read')
                @livewire('tables.table-pendings-to-read', ['search' => $search], key('pendings-' . $search))
            @break

            @case('tables.table-high-priority')
                @livewire('tables.table-high-priority', ['search' => $search], key('high-' . $search))
            @break

            @case('tables.table-normal-priority')
                @livewire('tables.table-normal-priority', ['search' => $search], key('normal-' . $search))
            @break

            @case('tables.table-low-priority')
                @livewire('tables.table-low-priority', ['search' => $search], key('low-' . $search))
            @break

            @case('tables.table-corrected')
                @livewire('tables.table-corrected', ['search' => $search], key('corrected-' . $search))
            @break

            @default
                <div class="p-4 text-gray-500">Vista tablas especialista no encontrada!!!!!!!!!!!!!!!!!!!</div>
        @endswitch
    </div>
</div>
