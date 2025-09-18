<div x-data="{
    columns: JSON.parse(localStorage.getItem('columns')) || {
        showFecha: true,
        showIdentificacion: true,
        showProcedencia: false
    }
}" x-init="$watch('columns', value => localStorage.setItem('columns', JSON.stringify(value)))">
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
                    <button @click="$store.columnToggle.toggleColumn('showFecha')" id="toggle_fecha_estudio"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span
                            x-bind:class="{
                                'bg-green-600 text-white': $store.columnToggle.columns
                                    .showFecha,
                                'shadow-stone-400 shadow-xs': !$store.columnToggle.columns.showFecha
                            }"
                            class="bg-green-200/10 border-l border-y border-green-600 rounded-tl-xl rounded-bl-xl flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Fecha de estudio</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="$store.columnToggle.toggleColumn('showIdentificacion')" id="toggle_identificacion"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span
                            x-bind:class="{
                                'bg-green-600 text-white': $store.columnToggle.columns
                                    .showIdentificacion,
                                'shadow-stone-400 shadow-xs': !$store.columnToggle.columns.showIdentificacion
                            }"
                            class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Identificación</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="$store.columnToggle.toggleColumn('showSpecialist')" id="toggle_specialist"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span
                            x-bind:class="{
                                'bg-green-600 text-white': $store.columnToggle.columns
                                    .showSpecialist,
                                'shadow-stone-400 shadow-xs': !$store.columnToggle.columns.showSpecialist
                            }"
                            class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Especialista Asignado</span>
                        </span>
                    </button>
                </div>
                <div>
                    <button @click="$store.columnToggle.toggleColumn('showProcedencia')" id="toggle_Procedencia"
                        class="flex items-center space-x-2 cursor-pointer">
                        <span
                            x-bind:class="{
                                'bg-green-600 text-white': $store.columnToggle.columns
                                    .showProcedencia,
                                'shadow-stone-400 shadow-xs': !$store.columnToggle.columns.showProcedencia
                            }"
                            class="bg-green-200/10 border-r border-y border-green-600 rounded-tr-xl rounded-br-xl flex items-center text-xs px-2.5 py-0.5">
                            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                            <span>Procedencia</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table class="min-w-full divide-y divide-neutral-200/70">
        <thead class="bg-stone-50">
            <tr class="text-neutral-800">
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">ID</span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">Paciente</span>
                </th>
                <template x-if="$store.columnToggle.columns.showFecha">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Fecha de estudio
                        </span>
                    </th>
                </template>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">Edad</span>
                </th>
                <template x-if="$store.columnToggle.columns.showIdentificacion">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Identificación
                        </span>
                    </th>
                </template>
                <template x-if="$store.columnToggle.columns.showSpecialist">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Especialista Asignado
                        </span>
                    </th>
                </template>
                <template x-if="$store.columnToggle.columns.showProcedencia">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Procedencia
                        </span>
                    </th>
                </template>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">Prioridad</span>
                </th>
                <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">Estudio</span>
                </th>
                <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">Estado</span>
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
                    <td class="px-2 font-medium whitespace-nowrap">{{ $estudio->id }}</td>
                    <td class="px-5 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->name }}</td>
                    <template x-if="$store.columnToggle.columns.showFecha">
                        <td class="px-5 whitespace-nowrap">
                            {{ $estudio->created_at->translatedFormat('l d \d\e F Y') }}
                        </td>
                    </template>
                    <td class="px-5 whitespace-nowrap">{{ $estudio->patient->age }} años</td>
                    <template x-if="$store.columnToggle.columns.showIdentificacion">
                        <td class="px-5 whitespace-nowrap">{{ $estudio->patient->document }}</td>
                    </template>
                    <template x-if="$store.columnToggle.columns.showSpecialist">
                        @if ($estudio->specialistUser === null)
                            <td class="px-5 whitespace-nowrap">Sin asignación</td>
                        @else
                            <td class="px-5 whitespace-nowrap">{{ $estudio->specialistUser->name }}</td>
                        @endif
                    </template>
                    <template x-if="$store.columnToggle.columns.showProcedencia">
                        <td class="px-5 whitespace-nowrap">{{ $estudio->exam->departurePlace->name }}</td>
                    </template>
                    <td
                        class="px-5 whitespace-nowrap
                        {{ $estudio->priority === 'Normal' ? 'text-blue-500' : '' }}
                        {{ $estudio->priority === 'Baja' ? 'text-green-500' : '' }}
                        {{ $estudio->priority === 'Alta' ? 'text-red-500' : '' }}">
                        <span class="rounded-2xl bg-gray-100 px-3 py2">{{ $estudio->priority }}</span>
                    </td>
                    <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate"
                        title="{{ $estudio->study_name }}">{{ $estudio->study_name }}</td>
                    <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate">
                        {{ $estudio->study_state }}</td>
                    <td class="max-w-24 flex px-5">
                        @if ($estudio->specialist_user_id === Auth::user()->id)
                            <button wire:click="openDrawerReading({{ $estudio->id }})"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[2px] m-1"
                                type="button">
                                <img class="max-w-[20px] min-w-[20px] min-h-[20px]"
                                    src="{{ asset('images/drawer.svg') }}" title="Realizar lectura">
                            </button>
                            @if ($showDrawerReading && $estudioId == $estudio->id)
                                <livewire:Drawers.drawer-reading :estudioId="$estudio->id">
                            @endif
                        @else
                            <button wire:click="assignMe({{ $estudio->id }})"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[2px] m-1"
                                type="button">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/get.svg') }}"
                                    title="Asignarme este estudio">
                            </button>
                        @endif
                        <a href="http://localhost:8042/osimis-viewer/app/index.html?study={{ $estudio->study_id_orthanc }}"
                            target="_blank"
                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[2px] m-1"
                            type="button">
                            <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/showRad.svg') }}"
                                title="Ver imagen DICOM">
                        </a>
                        @if ($estudio->study_id_orthanc)
                            <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}"
                                target="_blank" class="btn btn-primary">
                                Ver estudio en visor DICOM
                            </a>
                        @else
                            <span class="text-muted">Estudio no disponible</span>
                        @endif






                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($estudios)
        <div class="mt-4 flex justify-center">{{ $estudios->links('livewire::tailwind') }}</div>
    @endif
</div>
