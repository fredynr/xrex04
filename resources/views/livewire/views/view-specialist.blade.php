<div x-data="{
    showFecha: JSON.parse(localStorage.getItem('showFechaState')) || false,
    showIdentificacion: JSON.parse(localStorage.getItem('showIdentificacionState')) || false,
    showSpecialist: JSON.parse(localStorage.getItem('showSpecialistState')) || false,
    showEstado: JSON.parse(localStorage.getItem('showEstadoState')) || false,
    showProcedencia: JSON.parse(localStorage.getItem('showProcedenciaState')) || false,
}" x-init="$watch('showFecha', (value) => localStorage.setItem('showFechaState', JSON.stringify(value)));
$watch('showIdentificacion', value => localStorage.setItem('showIdentificacionState', JSON.stringify(value)));
$watch('showSpecialist', value => localStorage.setItem('showSpecialistState', JSON.stringify(value)));
$watch('showEstado', value => localStorage.setItem('showEstadoState', JSON.stringify(value)));
$watch('showProcedencia', value => localStorage.setItem('showProcedenciaState', JSON.stringify(value)));" class="px-4 w-full flex flex-col">

    <div class="w-full flex flex-wrap bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2 text-gray-500">Estudios pendientes por lectura:</div>
            <div class="flex justify-between w-full flex-wrap">
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $priority === null && $studyState === null,
                ])>
                    <button wire:click="showByPriority(null)" class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <img src="{{ asset('images/clock.svg') }}">
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">PENDIENTES:</span>
                            {{ $totalEstudios }}
                        </span>
                        <span wire:loading wire:loading.flex wire:target="showByPriority"
                            class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/50 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                            <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' => $priority === 'Alta',
                ])>
                    <button wire:click="showByPriority('Alta')" class="flex flex-col cursor-pointer">
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
                    'bg-violet-50 rounded-lg border border-gray-300' => $priority === 'Normal',
                ])>
                    <button wire:click="showByPriority('Normal')" class="flex flex-col cursor-pointer">
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
                    'bg-violet-50 rounded-lg border border-gray-300' => $priority === 'Baja',
                ])>
                    <button wire:click="showByPriority('Baja')" class="flex flex-col cursor-pointer">
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
                        $studyState === 'Corregido',
                ])>
                    <button wire:click="showByState('Corregido')" class="flex flex-col cursor-pointer">
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

                <div class="flex items-center min-w-1/2">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscar</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.500ms="search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ingresa la busqueda..." />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex flex-wrap justify-between mt-3 py-2 px-4 bg-stone-50">
        <div class="flex items-center">
            <img src="{{ asset('images/calendar.svg') }}" width="24">
            <span
                class="flex align-bottom text-xs text-gray-500 ml-2">{{ now()->translatedFormat('l d \d\e F Y') }}</span>
        </div>
        <div>
            <h3 class="text-right text-sm text-gray-500 mb-1">Mostrar/Ocultar Columnas:</h3>
            <div class="flex justify-center">
                <div>
                    <button @click="showFecha = !showFecha" id="toggle_fecha_estudio"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span x-bind:class="showFecha ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                            class="bg-green-200/10 border-l border-y border-green-600 rounded-tl-xl rounded-bl-xl flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Fecha de estudio</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="showIdentificacion = !showIdentificacion" id="toggle_identificacion"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span
                            x-bind:class="showIdentificacion ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                            class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Identificación</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="showSpecialist = !showSpecialist" id="toggle_specialist"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span x-bind:class="showSpecialist ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                            class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Especialista Asignado</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="showEstado = !showEstado" id="toggle_estado"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span x-bind:class="showEstado ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                            class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Estado</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="showProcedencia = !showProcedencia" id="toggle_Procedencia"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span x-bind:class="showProcedencia ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                            class="bg-green-200/10 border-r border-y border-green-600 rounded-tr-xl rounded-br-xl flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Procedencia</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full overflow-x-auto">
        <table class="w-full divide-y shadow-md divide-neutral-200/70">
            <thead class="bg-stone-50">
                <tr class="text-neutral-800">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">Paciente</span>
                    </th>
                    <th x-show="showFecha" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Fecha de estudio
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">Edad</span>
                    </th>
                    <th x-show="showIdentificacion" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Identificación
                        </span>
                    </th>
                    <th x-show="showSpecialist" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Especialista Asignado
                        </span>
                    </th>
                    <th x-show="showProcedencia" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Procedencia
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">Prioridad</span>
                    </th>
                    <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">Estudio</span>
                    </th>
                    <th x-show="showEstado" class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Estado
                        </span>
                    </th>
                    <th class="max-w-20 px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">Acción</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200/70">
                @foreach ($estudios as $estudio)
                    <tr class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                        wire:key="study-{{ $estudio->id }}">
                        <td class="px-5 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->name }}</td>
                        <td x-show="showFecha" class="px-5 whitespace-nowrap">
                            {{ $estudio->created_at->translatedFormat('l d \d\e F Y') }}
                        </td>
                        <td class="px-5 whitespace-nowrap">{{ $estudio->patient->age }} años</td>
                        <td x-show="showIdentificacion" class="px-5 whitespace-nowrap">{{ $estudio->patient->document }}
                        </td>
                        @if ($estudio->specialistUser === null)
                            <td x-show="showSpecialist" class="px-5 whitespace-nowrap">Sin asignación</td>
                        @else
                            <td x-show="showSpecialist" class="px-5 whitespace-nowrap">
                                {{ $estudio->specialistUser->name }}</td>
                        @endif
                        <td x-show="showProcedencia" class="px-5 whitespace-nowrap">
                            {{ $estudio->exam->departurePlace->name }}</td>
                        <td
                            class="px-5 whitespace-nowrap
                            {{ $estudio->priority === 'Normal' ? 'text-blue-500' : '' }}
                            {{ $estudio->priority === 'Baja' ? 'text-green-500' : '' }}
                            {{ $estudio->priority === 'Alta' ? 'text-red-500' : '' }}">
                            <span class="rounded-2xl bg-gray-100 px-3 py2">{{ $estudio->priority }}</span>
                        </td>
                        <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate"
                            title="{{ $estudio->study_name }}">{{ $estudio->study_name }}</td>
                        <td x-show="showEstado"
                            class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate">
                            {{ $estudio->study_state }}</td>
                        <td class="max-w-24 flex px-5">
                            @if ($estudio->specialist_user_id === Auth::user()->id)
                                <button wire:click="openDrawerReading({{ $estudio->id }})"
                                    wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                    wire:target="assignMe"
                                    class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                    type="button">
                                    <img class="max-w-[20px] min-w-[20px] min-h-[20px]"
                                        src="{{ asset('images/drawer.svg') }}" title="Realizar lectura">
                                    <span wire:loading wire:loading.flex wire:target="openDrawerReading"
                                        class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/5 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                                        <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                                    </span>
                                </button>
                                @if ($showDrawerReading && $estudioId == $estudio->id)
                                    <livewire:Drawers.drawer-reading :estudioId="$estudio->id">
                                @endif
                            @else
                                <button wire:click="assignMe({{ $estudio->id }})"
                                    wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                    wire:target="assignMe"
                                    class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                    type="button">
                                    <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/get.svg') }}"
                                        title="Asignarme este estudio">
                                </button>
                            @endif
                            @if ($estudio->study_id_orthanc)
                                <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}"
                                    target="_blank"
                                    class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                    <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/showRad.svg') }}"
                                        title="Ver imagen DICOM">
                                </a>
                            @else
                                <span class="mt-2" style="color: red; font-size: 1rem;"
                                    title="Estudio no disponible ☹">✘</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($estudios)
            {{ $estudios->links('vendor.livewire.custom-pagination') }}
        @endif
    </div>
</div>
