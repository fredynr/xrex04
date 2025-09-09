<div class="w-[calc(100vw-300px)] px-4" x-data="{ showDrawer: @entangle('showDrawer') }" >
    @if (session()->has('message'))
        <div x-data="{ showAlert: true }" x-show="showAlert" x-ignore
            class="fixed bottom-4 right-4 bg-blue-500 text-white p-4 rounded shadow-lg">
            <p>✅ {{ session('message') }}</p>
            <button @click="showAlert = false" class="absolute top-1 right-2 text-white text-lg">×</button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2 text-gray-500">Estudios pendientes por lectura:</div>
            <div class="flex justify-between w-full">
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/clock.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PENDIENTES:</span>
                        {{ $totalStudies }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/alertTriangle.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD ALTA:</span>
                        {{ $countAlta }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/hand.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD NORMAL:</span>
                        {{ $countNormal }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/flag.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PRIORIDAD BAJA:</span>
                        {{ $countBaja }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex items-center min-w-1/2">
            <label wire:model.live="search" for="search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscar...</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input wire:model.live="search" type="text" id="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Ingresa la busqueda..." />
            </div>
        </div>
    </div>

    @if ($studies->count() === 0)
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="w-full flex flex-col items-center">
                <span>No Hay estudios pendientes para lectura</span>
                <img src="{{ asset('images/complete.svg') }}" width="200">
            </div>
        </div>
    @else
        <div>
            <div class="mb-4">
                <div class="flex justify-between w-full mt-3 py-2 px-4 bg-stone-50">
                    <div class="flex items-center">
                        <img src="{{ asset('images/calendar.svg') }}" width="24">
                        <span
                            class="flex align-bottom text-xs text-gray-500 ml-2">{{ now()->translatedFormat('l d \d\e F Y') }}</span>
                    </div>
                    <div>
                        <h3 class="text-right text-sm text-gray-500 mb-1">Mostrar/Ocultar Columnas:</h3>
                        <div class="flex justify-center">
                            <div>
                                <label for="toggle_fecha_estudio" class="flex items-center space-x-2 cursor-pointer">
                                    <input wire:model.live="showFecha" type="checkbox" id="toggle_fecha_estudio"
                                        class="hidden">
                                    <span
                                        class="bg-green-200/10 border-l border-y border-green-600 rounded-tl-xl rounded-bl-xl flex items-center text-xs px-2.5 py-0.5 @if ($showFecha) bg-green-600 text-white @else shadow-stone-400 shadow-xs @endif">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>Fecha de estudio</span>
                                    </span>
                                </label>
                            </div>
                            <div>
                                <label for="toggle_identificacion" class="flex items-center space-x-2 cursor-pointer">
                                    <input wire:model.live="showIdentificacion" type="checkbox"
                                        id="toggle_identificacion" class="hidden">
                                    <span
                                        class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5 @if ($showIdentificacion) bg-green-600 text-white @else shadow-stone-400 shadow-xs @endif">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>Identificación</span>
                                    </span>
                                </label>
                            </div>
                            <div>
                                <label for="toggle_procedencia" class="flex items-center space-x-2 cursor-pointer">
                                    <input wire:model.live="showProcedencia" type="checkbox" id="toggle_procedencia"
                                        class="hidden">
                                    <span
                                        class="bg-green-200/10 border-r border-y border-green-600 rounded-tr-xl rounded-br-xl flex items-center text-xs px-2.5 py-0.5 @if ($showProcedencia) bg-green-600 text-white @else shadow-stone-400 shadow-xs @endif">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>Procedencia</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="min-w-full divide-y shadow-md divide-neutral-200/70">
                    <thead class="bg-stone-50">
                        <tr class="text-neutral-800">
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    ID
                                </span>
                            </th>
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Paciente
                                    {{-- <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                </svg> --}}
                                </span>
                            </th>
                            @if ($showFecha)
                                <th class="px-5 py-3 text-xs text-left uppercase">
                                    <span class="flex items-center">
                                        Fecha de estudio
                                    </span>
                                </th>
                            @endif
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Edad
                                </span>
                            </th>
                            @if ($showIdentificacion)
                                <th class="px-5 py-3 text-xs text-left uppercase">
                                    <span class="flex items-center">
                                        Identificación
                                    </span>
                                </th>
                            @endif
                            @if ($showProcedencia)
                                <th class="px-5 py-3 text-xs text-left uppercase">
                                    <span class="flex items-center">
                                        Procedencia

                                    </span>
                                </th>
                            @endif
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Prioridad

                                </span>
                            </th>
                            <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Estudio
                                </span>
                            </th>
                            <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Estado
                                </span>
                            </th>
                            <th class="max-w-20 px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Acción
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200/70">
                        @foreach ($studies as $study)
                            <tr class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                                wire:key="study-{{ $study->id }}">
                                <td class="px-2 font-medium whitespace-nowrap">
                                    {{ $study->id }}</td>
                                <td class="px-5 text-sm font-medium whitespace-nowrap">
                                    {{ $study->patient->name }}</td>
                                @if ($showFecha)
                                    <td class="px-5 whitespace-nowrap">
                                        {{ $study->created_at->translatedFormat('l d \d\e F Y') }}</td>
                                @endif
                                <td class="px-5 whitespace-nowrap">{{ $study->patient->age }} años</td>
                                @if ($showIdentificacion)
                                    <td class="px-5 whitespace-nowrap">{{ $study->patient->document }}</td>
                                @endif
                                @if ($showProcedencia)
                                    <td class="px-5 whitespace-nowrap">
                                        {{ $study->exam->departurePlace->name }}</td>
                                @endif
                                <td
                                    class="px-5 whitespace-nowrap
                                {{ $study->priority === 'Normal' ? 'text-blue-500' : '' }}
                                {{ $study->priority === 'Baja' ? 'text-green-500' : '' }}
                                {{ $study->priority === 'Alta' ? 'text-red-500' : '' }}">
                                    <span class="rounded-2xl bg-gray-100 px-3 py2">{{ $study->priority }}</span>
                                </td>
                                <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate"
                                    title="{{ $study->study_name }}">
                                    {{ $study->study_name }}
                                </td>
                                <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate">
                                    {{ $study->study_state }}
                                </td>
                                <td class="max-w-20 flex px-5 whitespace-nowrap">
                                    <button wire:click="openDrawer({{ $study->id }})" @click="showDrawer = true"
                                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[2px] m-1"
                                        type="button">
                                        <img src="{{ asset('images/drawer.svg') }}" title="Realizar lectura">
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $studies->links('livewire::tailwind') }}
            </div>
            <div x-show="showDrawer" style="display: none;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="-translate-x-full opacity-0"
                class="fixed top-0 left-0 w-full h-full bg-gray-500/75 text-white">
                @if ($estudioId)
                    <livewire:drawers.drawer-reading :estudioId="$estudioId" key="{{ $estudioId }}" />
                @endif

            </div>
    @endif
</div>
