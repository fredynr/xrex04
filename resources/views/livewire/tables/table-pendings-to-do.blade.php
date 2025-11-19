<div x-data="{
    showFecha: JSON.parse(localStorage.getItem('showFechaState')) || false,
    showIdentificacion: JSON.parse(localStorage.getItem('showIdentificacion')) || true,
    showEmail: JSON.parse(localStorage.getItem('showEmail')) || false,
    showProcedencia: JSON.parse(localStorage.getItem('showProcedencia')) || false,
    showTelefono: JSON.parse(localStorage.getItem('showTelefono')) || false
}" x-init="$watch('showFecha', (value) => localStorage.setItem('showFechaState', JSON.stringify(value)));
$watch('showIdentificacion', value => localStorage.setItem('showIdentificacionState', JSON.stringify(value)));
$watch('showProcedencia', value => localStorage.setItem('showProcedencia', JSON.stringify(value)));
$watch('showEmail', value => localStorage.setItem('showEmail', JSON.stringify(value)));
$watch('showTelefono', value => localStorage.setItem('showTelefono', JSON.stringify(value)));">

    <div class="relative" wire:loading.attr="disabled" wire:target="verificarTodosOrthanc">
        <table class="table-fixed w-full divide-y shadow-md divide-neutral-200/70">
            <thead>
                <tr class="text-neutral-800">
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Paciente
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Estudio
                        </span>
                    </th>
                    <th x-show="showFecha" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Fecha de solicitud
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Edad
                        </span>
                    </th>
                    <th x-show="showIdentificacion" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Identificación
                        </span>
                    </th>
                    <th x-show="showProcedencia" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Procedencia
                        </span>
                    </th>
                    <th x-show="showEmail" class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            email
                        </span>
                    </th>
                    <th x-show=showTelefono class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Teléfono
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <div class="flex">
                            <span class="flex items-center mr-2">
                                Acción
                            </span>
                            {{-- <button wire:click="verificarTodosOrthanc"
                                wire:confirm="⚠️ ¡Advertencia! Este proceso puede tardar varios minutos dependiendo de la cantidad de estudios. ¿Desea continuar?"
                                wire:loading.attr="disabled" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#fc8b28"><path d="M172.31-180Q142-180 121-201q-21-21-21-51.31v-455.38Q100-738 121-759q21-21 51.31-21h182.3v60h-182.3q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v455.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h615.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-455.38q0-4.62-3.85-8.46-3.84-3.85-8.46-3.85h-182.3v-60h182.3Q818-780 839-759q21 21 21 51.31v455.38Q860-222 839-201q-21 21-51.31 21H172.31ZM480-354 293.85-540.15 336-582.31l114 114V-780h60v311.69l114-114 42.15 42.16L480-354Z"/></svg>
                            </button> --}}
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200/70">

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
                                    <span
                                        x-bind:class="showFecha ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
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
                                <button @click="showEmail = !showEmail" id="toggle_email"
                                    class="flex items-center space-x-2 cursor-pointer">
                                    <span
                                        x-bind:class="showEmail ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                                        class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>email</span>
                                    </span>
                                </button>
                            </div>
                            <div>
                                <button @click="showProcedencia = !showProcedencia" id="toggle_procedencia"
                                    class="flex items-center space-x-2 cursor-pointer">
                                    <span
                                        x-bind:class="showProcedencia ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                                        class="bg-green-200/10 border border-green-600 flex items-center text-xs px-2.5 py-0.5">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>Procedencia</span>
                                    </span>
                                </button>
                            </div>
                            <div>
                                <button @click="showTelefono = !showTelefono" id="toggle_telefono"
                                    class="flex items-center space-x-2 cursor-pointer">
                                    <span
                                        x-bind:class="showTelefono ? 'bg-green-600 text-white' : 'shadow-stone-400 shadow-xs'"
                                        class="bg-green-200/10 border-r border-y border-green-600 rounded-tr-xl rounded-br-xl flex items-center text-xs px-2.5 py-0.5">
                                        <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-green-500 rounded-full"></span>
                                        <span>Teléfono</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($estudios as $estudio)
                    <tr class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                        wire:key="estudio-{{ $estudio->id }}">
                        <td class="px-2 w-48 truncate overflow-hidden whitespace-nowrap text-sm font-medium"
                            title="{{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}">
                            {{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}
                        </td>
                        <td class="px-2 w-48 truncate overflow-hidden whitespace-nowrap"
                            title="{{ $estudio->listEstudio->name }}">{{ $estudio->listEstudio->name }}</td>
                        <td x-show="showFecha" class="px-2 whitespace-nowrap">{{ $estudio->created_at }}</td>
                        <td class="px-2 whitespace-nowrap">{{ $estudio->patient->age }} años</td>
                        <td x-show="showIdentificacion" class="px-2 whitespace-nowrap">
                            {{ $estudio->patient->document }}
                        </td>
                        <td x-show="showProcedencia" class="px-2 w-48 truncate overflow-hidden whitespace-nowrap"
                            title="{{ $estudio->exam->departurePlace->name }}">
                            {{ $estudio->exam->departurePlace->name }}
                        </td>
                        <td x-show="showEmail" class="px-2 w-48 truncate overflow-hidden whitespace-nowrap"
                            title="{{ $estudio->patient->email }}">{{ $estudio->patient->email }}</td>
                        <td x-show="showTelefono" class="px-2 whitespace-nowrap">{{ $estudio->patient->phone }}</td>
                        <td class="max-w-12 flex">
                            <div>
                                <button wire:click="openDrawerUpdatePatient({{ $estudio->patient->id }})"
                                    class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                    title="Editar datos del paciente">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#007595">
                                        <path
                                            d="M212.31-140Q182-140 161-161q-21-21-21-51.31v-535.38Q140-778 161-799q21-21 51.31-21h346.23l-60 60H212.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v535.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h535.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-288.77l60-60v348.77Q820-182 799-161q-21 21-51.31 21H212.31ZM480-480ZM380-380v-137.31l362.39-362.38q9.3-9.31 20.46-13.58 11.15-4.27 22.69-4.27 11.77 0 22.61 4.27Q819-889 827.92-880.08L878.15-830q8.69 9.31 13.35 20.54 4.65 11.23 4.65 22.77t-3.96 22.38q-3.96 10.85-13.27 20.15L515.38-380H380Zm456.77-406.31-50.23-51.38 50.23 51.38ZM440-440h49.85l249.3-249.31-24.92-24.92-26.69-25.69L440-492.38V-440Zm274.23-274.23-26.69-25.69 26.69 25.69 24.92 24.92-24.92-24.92Z" />
                                    </svg>
                                    <span wire:loading wire:loading.flex wire:target="openDrawerUpdatePatient"
                                        class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/5 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                                        <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                                    </span>
                                </button>
                                @if ($showDrawerUpdatePatient && $selectedPatientId === $estudio->patient->id)
                                    <div>
                                        <livewire:drawers.drawer-update-patient :patientId="$estudio->patient->id"
                                            wire:key="estudiodrawer-{{ $estudio->id }}" />
                                    </div>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="flex">
                                    @if ($estudioInOrthanc && $estudio->accession_number === $accessionNumber)
                                        <button wire:click="openDrawerStudyTech({{ $estudio->id }})"
                                            wire:loading.class="opacity-50 cursor-progress"
                                            wire:loading.attr="disabled"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                            type="button" title="abrir para enviar">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#1ca30a">
                                                <path
                                                    d="M800-200v-560H537.69v560H800Zm-600 40v-124.62h40V-200h257.69v-560H240v84.62h-40V-800h640v640H200Zm297.69-320Zm40 0h-40 40Zm0 0ZM200-380v-80h-80v-40h80v-80h40v80h80v40h-80v80h-40Z" />
                                            </svg>
                                        </button>
                                    @else
                                        <button wire:loading.remove
                                            wire:click="getSingleEstudio('{{ $estudio->accession_number ?? '' }}')"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                            title="obtener estudio">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                                <path
                                                    d="M172.31-180Q142-180 121-201q-21-21-21-51.31v-455.38Q100-738 121-759q21-21 51.31-21h182.3v60h-182.3q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v455.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h615.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-455.38q0-4.62-3.85-8.46-3.84-3.85-8.46-3.85h-182.3v-60h182.3Q818-780 839-759q21 21 21 51.31v455.38Q860-222 839-201q-21 21-51.31 21H172.31ZM480-354 293.85-540.15 336-582.31l114 114V-780h60v311.69l114-114 42.15 42.16L480-354Z" />
                                            </svg>
                                        </button>
                                        <span wire:loading>
                                            <svg class="animate-spin h-4 w-4 text-blue-600" viewBox="0 0 100 100"
                                                xmlns="http://www.w3.org/2000/svg" fill="none">
                                                <circle cx="50" cy="50" r="30" stroke="currentColor"
                                                    stroke-width="10" opacity="0.2" />
                                                <path d="M50 20 A30 30 0 0 1 80 50" stroke="currentColor"
                                                    stroke-width="10" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                    @endif

                                    {{-- @if (in_array($estudio->id, $estudiosConOrthanc))
                                        <button wire:click="openDrawerStudyTech({{ $estudio->id }})"
                                            wire:loading.class="opacity-50 cursor-progress"
                                            wire:loading.attr="disabled"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                            type="button" title="{{ $estudio->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#1ca30a">
                                                <path
                                                    d="M800-200v-560H537.69v560H800Zm-600 40v-124.62h40V-200h257.69v-560H240v84.62h-40V-800h640v640H200Zm297.69-320Zm40 0h-40 40Zm0 0ZM200-380v-80h-80v-40h80v-80h40v80h80v40h-80v80h-40Z" />
                                            </svg>
                                        </button>
                                    @endif --}}

                                    @if ($showDrawerStudyTech && $selectedStudyId === $estudio->id)
                                        <div>
                                            <livewire:drawers.drawer-study-tech :studyId="$studyIdOrthanc" :estudioId="$estudio->id" :examId="$estudio->exam->id"
                                                :patientId="$estudio->patient->id" wire:key="studydrawer-{{ $estudio->id }}" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 flex justify-center">
            {{ $estudios->links('vendor.livewire.custom-pagination') }}
        </div>
        {{-- <div wire:loading.class.remove="hidden" wire:target="verificarTodosOrthanc"
            class="absolute inset-0 bg-gray-500 opacity-75 hidden z-50 flex items-center justify-center">
            <div class="text-white text-lg font-bold">
                Procesando... No cierre ni navegue la página.
            </div>
        </div> --}}
    </div>
</div>


{{-- <button
                            @click="window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Estudios cargados', duration: 4000 } }))"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                            Mostrar Toast
                        </button> --}}
