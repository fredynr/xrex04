<div>
    <table class="min-w-full divide-y shadow-md divide-neutral-200/70">
        <thead>
            <tr class="text-neutral-800">
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Nombre
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Fecha de solicitud
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
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Procedencia
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        email
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Teléfono
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Acción
                    </span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200/70">
            @foreach ($exams as $exam)
                <tr class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                    wire:key="exam-{{ $exam->id }}">
                    <td class="px-2 text-sm font-medium whitespace-nowrap">{{ $exam->patient->name }} {{ $exam->patient->first_surname }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->created_at }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->patient->age }} años</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->patient->document }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->departurePlace->name }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->patient->email }}</td>
                    <td class="px-2 whitespace-nowrap">{{ $exam->patient->phone }}</td>
                    <td class="flex">
                        <div>
                            <button wire:click="openDrawerUpdatePatient({{ $exam->patient->id }})"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/edit.svg') }}"
                                    title="Editar datos del paciente">
                                <span wire:loading wire:loading.flex wire:target="openDrawerUpdatePatient"
                                    class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/5 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                                    <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                                </span>
                            </button>
                            @if ($showDrawerUpdatePatient && $selectedPatientId === $exam->patient->id)
                                <div>
                                    <livewire:drawers.drawer-update-patient :patientId="$exam->patient->id"
                                        wire:key="examdrawer-{{ $exam->id }}" />
                                </div>
                            @endif
                        </div>
                        <div class="relative">
                            <button wire:click="getOrthancStudies({{ $exam->patient->id }}, {{ $exam->id }})"
                                wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                type="button" title="Obtener exámenes del paciente">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/boxArrow.svg') }}">
                            </button>
                            @if ($selectedPatientId === $exam->patient->id && !empty($studiesToView) && $examId === $exam->id)
                                <div
                                    class="fixed items-center justify-center top-0 left-0 w-full h-full z-1 bg-stone-400/40 backdrop-filter backdrop-blur-[1px] bg-opacity-10">
                                </div>
                                <ul class="absolute top-5 -left-58 border-1 rounded-sm shadow-md bg-stone-50 z-999">
                                    <svg style="position: absolute; top: -17px; right:-17px; transform: rotate(45deg)"
                                        xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960"
                                        width="40px" fill="#0ea5e9">
                                        <path d="m280-400 200-200.67L680-400H280Z" />
                                    </svg>

                                    <button class="w-full rounded-sm" wire:click="closeDrawerStudyTech">
                                        <span
                                            class="text-xs font-thin inline-block bg-slate-500 w-full h-5 text-slate-50 cursor-pointer hover:text-sky-300"
                                            wire:loading.remove>
                                            cerrar
                                        </span>
                                        <span wire:loading>
                                            <svg class="animate-spin h-4 w-4 text-blue-600" viewBox="0 0 100 100"
                                                xmlns="http://www.w3.org/2000/svg" fill="none">
                                                <circle cx="50" cy="50" r="30" stroke="currentColor"
                                                    stroke-width="10" opacity="0.2" />
                                                <path d="M50 20 A30 30 0 0 1 80 50" stroke="currentColor"
                                                    stroke-width="10" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="relative z-2">
                                        @foreach ($studiesToView as $study)
                                            <li class="flex items-center h-10 p-1 hover:bg-gray-100 whitespace-nowrap">
                                                <button wire:click="openDrawerStudyTech('{{ $study->id }}')"
                                                    class="flex items-center whitespace-nowrap cursor-pointer ml-1">
                                                    <img src="{{ asset('images/drawer.svg') }}"
                                                        title="{{ $study->description }}">
                                                    <span class="text-left ml-2 w-[200px] truncate">
                                                        {{ $study->description }}
                                                    </span>
                                                    <span wire:loading wire:loading.flex
                                                        wire:target="openDrawerStudyTech"
                                                        class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/5 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                                                        <img src="{{ asset('images/infinite-spinner.svg') }}"
                                                            width="100">
                                                    </span>
                                                </button>
                                            </li>
                                            @if ($showDrawerStudyTech && $selectedStudyId === $study->id)
                                                <div>
                                                    <livewire:drawers.drawer-study-tech :studyId="$study->id"
                                                        :examId="$exam->id" :patientId="$exam->patient->id"
                                                        wire:key="studydrawer-{{ $study->id }}" />
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </ul>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $exams->links('vendor.livewire.custom-pagination') }}
    </div>
</div>


{{-- <button
                            @click="window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Estudios cargados', duration: 4000 } }))"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                            Mostrar Toast
                        </button> --}}
