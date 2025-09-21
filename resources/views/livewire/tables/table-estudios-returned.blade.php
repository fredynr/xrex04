<div>
    <table class="min-w-full divide-y divide-neutral-200/70">
        <thead>
            <tr class="text-neutral-800">
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        STUDY ID
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Nombre
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Edad
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Identificación
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Especialista
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Estado
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Fecha de devolución
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Acción
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200/70">
            @foreach ($estudiosReturned as $estudio)
                <tr class="text-neutral-600 bg-neutral-50" wire:key="estudio-{{ $estudio->id }}">
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->id }}</td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->name }}</td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->age }}</td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->document }}
                    </td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">
                        {{ $estudio->specialistUser->name ?? 'Sin asignar' }}</td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->study_state }}</td>
                    <td class="px-5 py-1 text-sm font-medium whitespace-nowrap">{{ $estudio->updated_at }}</td>
                    <td class="flex px-5 py-1 text-sm">
                        <div>
                            <button wire:click="openDrawerInfoReturned({{ $estudio->id }})"
                                class="cursor-pointer"><img src="{{ asset('images/infoSquad.svg') }}" alt="">
                            </button>
                            @if ($showDrawerInfoReturned && $studyID === $estudio->id)
                                <livewire:drawers.drawer-info-returned :estudioId="$estudio->id"
                                    wire:key="drawer-info-{{ $estudio->id }}" />
                            @endif
                        </div>
                        <div class="relative">
                            <button wire:click="getOrthancStudies({{ $estudio->patient->id }})"
                                wire:loading.attr="disabled" class="cursor-pointer disabled:cursor-not-allowed"
                                type="button">
                                <img wire:loading.remove src="{{ asset('images/boxArrow.svg') }}">
                                <span wire:loading wire:loading.delay>
                                    <img src="{{ asset('images/spinner.gif') }}" class="w-6">
                                </span>
                            </button>
                            @if ($selectedPatientId === $estudio->patient->id)
                                <ul class="absolute top-2 -left-50 border-1 rounded-sm shadow-md bg-stone-50 z-999">
                                    <button wire:click="closeDrawerInfoReturned">
                                        <span
                                            class="inline-block bg-slate-500 rounded-full w-5 h-5 -ml-1 -mt-1 text-slate-50 cursor-pointer"
                                            wire:loading.remove>
                                            X
                                        </span>
                                        <span wire:loading>
                                            <svg class="animate-spin h-6 w-6 text-blue-600" viewBox="0 0 100 100"
                                                xmlns="http://www.w3.org/2000/svg" fill="none">
                                                <circle cx="50" cy="50" r="45" stroke="currentColor"
                                                    stroke-width="10" opacity="0.2" />
                                                <path d="M50 5a45 45 0 0 1 0 90" stroke="currentColor"
                                                    stroke-width="10" stroke-linecap="round" />
                                            </svg>
                                        </span>
                                    </button>
                                    @foreach ($studiesToView as $study)
                                        <li class="flex items-center h-10 p-1 hover:bg-gray-100 whitespace-nowrap">
                                            <button wire:click="openDrawerCorrection('{{ $study->id }}')"
                                                class="flex items-center whitespace-nowrap cursor-pointer ml-1">
                                                <img src="{{ asset('images/drawer.svg') }}"
                                                    title="{{ $study->description }}">
                                                <span class="text-left ml-2 w-[200px] truncate">
                                                    {{ $study->description }}
                                                </span>
                                                <span wire:loading wire:loading.flex wire:target="openDrawerCorrection"
                                                    class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-stone-50 opacity-50">
                                                    <img src="{{ asset('images/spinner.gif') }}">
                                                </span>
                                            </button>
                                        </li>
                                        @if ($showDrawerCorrection && $studyID === $study->id)
                                            <div>
                                                <livewire:drawers.drawer-correction :estudioId="$estudio->id" :studyID="$study->id"
                                                    :studyName="$study->description" :examId="$estudio->exam_id" :patientId="$estudio->patient->id"
                                                    :patientName="$estudio->patient->name" :studiesToView="$studiesToView" :specialistUserId="$estudio->specialist_user_id"
                                                    wire:key="return-{{ $estudio->id }}" />
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $estudiosReturned->links('vendor.livewire.custom-pagination') }}
    </div>

</div>
