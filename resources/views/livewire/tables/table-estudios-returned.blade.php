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
                    <td class="flex px-5">
                        <button wire:click="openDrawerInfoReturned({{ $estudio->id }})" class="cursor-pointer"><img
                                src="{{ asset('images/infoSquad.svg') }}" alt="">
                        </button>
                        @if ($showDrawerInfoReturned && $studyID === $estudio->id)
                            <livewire:drawers.drawer-info-returned :estudioId="$estudio->id"
                                wire:key="drawer-info-{{ $estudio->id }}" />
                        @endif
                        <button wire:click="getOrthancStudies({{ $estudio->patient->id }})"
                            class="cursor-pointer block text-white bg-slate-50 hover:bg-slate-200 focus:outline-none font-medium rounded-lg text-sm px-2 py-2 text-center"
                            type="button">
                            <img src="{{ asset('images/boxArrow.svg') }}">
                        </button>
                        @if ($selectedPatientId === $estudio->patient->id)
                            @foreach ($studiesToView as $studyView)
                                <button wire:click="openDrawerCorrection('{{ $studyView->id }}')"
                                    class="cursor-pointer ml-1"><img src="{{ asset('images/modal.svg') }}"
                                        title="{{ $studyView->description }}">
                                </button>
                                @if ($showDrawerCorrection && $studyID === $studyView->id)
                                    <div>
                                        <livewire:drawers.drawer-correction :estudioId="$estudio->id" :studyID="$studyView->id"
                                            :studyName="$studyView->description" :examId="$estudio->exam_id" :patientId="$estudio->patient->id"
                                            :patientName="$estudio->patient->name"
                                            :studiesToView="$studiesToView"
                                            wire:key="return-{{ $estudio->id }}" />
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex justify-center">
        {{ $estudiosReturned->links('livewire::tailwind') }}
    </div>

</div>
