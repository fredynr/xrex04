<div class="px-4">
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
            <div class="mb-2 text-gray-500">Estudios pendientes por transcribir:</div>
            <div class="flex justify-between w-xs">
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/clock.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">PENDIENTES:</span>
                        {{ $totalPendings }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <div class="flex justify-center">
                        <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                            <img src="{{ asset('images/calendarReturn.svg') }}">
                        </span>
                    </div>
                    <span class="text-sm">
                        <span class="text-[9px] text-gray-500 font-medium">Este mes haz digitado:</span>
                        {{ $totalMonthAuth }}
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

    @if ($estudios->isEmpty())
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="w-full flex flex-col items-center">
                <span>No Hay estudios pendientes para transcribir</span>
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
                </div>
                <table class="min-w-full divide-y shadow-md divide-neutral-200/70">
                    <thead class="bg-stone-50">
                        <tr class="text-neutral-800">
                            <th class="px-2 py-3 text-xs text-left uppercase">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                        width="22px" fill="#00000">
                                        <path
                                            d="M200-200v-560 560Zm24.62 40q-27.62 0-46.12-18.5Q160-197 160-224.62v-510.76q0-27.62 18.5-46.12Q197-800 224.62-800h510.76q27.62 0 46.12 18.5Q800-763 800-735.38v312.46q-9.77-2.39-19.77-3.58T760-427.69v-307.69q0-9.24-7.69-16.93-7.69-7.69-16.93-7.69H224.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v510.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h307.69q0 10.23 1.19 20.23t3.58 19.77H224.62ZM760-68.46 732.46-96l82.23-84H620v-40h194.69l-82.23-84L760-331.54 891.54-200 760-68.46ZM460-300h40v-160h160v-40H500v-160h-40v160H300v40h160v160Z" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Paciente
                                </span>
                            </th>
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Edad
                                </span>
                            </th>
                            <th class="px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Identificación
                                </span>
                            </th>
                            <th class="max-w-30 px-5 py-3 text-xs text-left uppercase">
                                <span class="flex items-center">
                                    Estudio
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
                        @foreach ($estudios as $estudio)
                            <tr x-data="{ open: false }" x-init="$watch('open', value => {
                                if (value) {
                                    $el.nextElementSibling.style.display = 'contents';
                                    $el.nextElementSibling.classList.add('table-row');
                                } else {
                                    $el.nextElementSibling.style.display = 'none';
                                }
                            });"
                                class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                                wire:key="estudio-{{ $estudio->id }}">
                                <td class="px-2 font-medium">
                                    <button @click=" open = !open " class="cursor-pointer">
                                        <template x-if="!open">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#0369a1">
                                                <path
                                                    d="M460-300h40v-160h160v-40H500v-160h-40v160H300v40h160v160ZM224.62-160q-27.62 0-46.12-18.5Q160-197 160-224.62v-510.76q0-27.62 18.5-46.12Q197-800 224.62-800h510.76q27.62 0 46.12 18.5Q800-763 800-735.38v510.76q0 27.62-18.5 46.12Q763-160 735.38-160H224.62Zm0-40h510.76q9.24 0 16.93-7.69 7.69-7.69 7.69-16.93v-510.76q0-9.24-7.69-16.93-7.69-7.69-16.93-7.69H224.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v510.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69ZM200-760v560-560Z" />
                                            </svg>
                                        </template>
                                        <template x-if="open">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#00000">
                                                <path
                                                    d="M356-464h248v-32H356v32ZM240.62-184q-24.32 0-40.47-16.15T184-240.62v-478.76q0-24.32 16.15-40.47T240.62-776h478.76q24.32 0 40.47 16.15T776-719.38v478.76q0 24.32-16.15 40.47T719.38-184H240.62Zm0-32h478.76q9.24 0 16.93-7.69 7.69-7.69 7.69-16.93v-478.76q0-9.24-7.69-16.93-7.69-7.69-16.93-7.69H240.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v478.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69ZM216-744v528-528Z" />
                                            </svg>
                                        </template>
                                    </button>
                                <td class="px-5 text-sm font-medium whitespace-nowrap">
                                    {{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}</td>
                                <td class="px-5 whitespace-nowrap">{{ $estudio->patient->age }} años</td>
                                <td class="px-5 whitespace-nowrap">{{ $estudio->patient->document }}</td>
                                <td class="max-w-40 px-5 overflow-hidden text-ellipsis whitespace-nowrap truncate"
                                    title="{{ $estudio->study_name }}">
                                    {{ $estudio->study_name }}
                                </td>

                                <td class="max-w-20 flex px-5">
                                    @if ($estudio->transcriber_user_id === Auth::id())
                                        <button wire:click="openDrawerTranscriber({{ $estudio->id }})"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[2px] m-1"
                                            type="button" title="Abrir la utilidad de transcribir el estudio">
                                            <img class="max-w-[20px] min-w-[20px]"
                                                src="{{ asset('images/drawer.svg') }}">
                                        </button>
                                        <div>
                                            @if ($showDrawerTranscriber && $estudioId == $estudio->id)
                                                <livewire:drawers.drawer-transcriber :estudio="$estudio"
                                                    wire:key="transcriber-{{ $estudio->id }}" />
                                            @endif
                                        </div>
                                    @else
                                        <button wire:click="assignMe({{ $estudio->id }})"
                                            wire:loading.class="opacity-50 cursor-progress"
                                            wire:loading.attr="disabled" wire:target="assignMe"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                            type="button">
                                            <img class="max-w-[20px] min-w-[20px]"
                                                src="{{ asset('images/get.svg') }}" title="Asignarme este estudio">
                                        </button>
                                    @endif
                                    <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}"
                                        target="_blank"
                                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                        <img class="max-w-[20px] min-w-[20px]"
                                            src="{{ asset('images/showRad.svg') }}" title="Ver imagen DICOM">
                                    </a>
                                </td>
                            </tr>
                            {{-- columnas ocultas --}}
                            <tr wire:key="hidde-{{ $estudio->id }}" style="display: none;">
                                <td colspan="6" class="bg-neutral-100 px-4 pb-4 border-x border-b border-sky-600">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <strong class="text-sm text-gray-600">Procedencia:</strong><br>
                                            <span
                                                class="text-xs text-gray-500">{{ $estudio->exam->departurePlace->name }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-sm text-gray-600">Prioridad:</strong><br>
                                            <span
                                                class="rounded-2xl px-3 py2 text-xs
                                            {{ $estudio->priority === 'Normal' ? 'text-blue-500 bg-blue-100' : '' }}
                                            {{ $estudio->priority === 'Baja' ? 'text-green-500 bg-green-100' : '' }}
                                            {{ $estudio->priority === 'Alta' ? 'text-red-500 bg-red-100' : '' }}">{{ $estudio->priority }}</span>
                                        </div>
                                        <div>
                                            <strong class="text-sm text-gray-600">Fecha del audio:</strong><br>
                                            <span
                                                class="text-xs text-gray-500">{{ $estudio->date_audio->translatedFormat('l d \d\e F Y h:i A') }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $estudios->links('livewire::tailwind') }}
            </div>
    @endif
</div>
