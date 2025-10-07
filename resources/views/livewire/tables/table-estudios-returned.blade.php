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
                        Especialista
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Estado
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Fecha de devolución
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
            @foreach ($estudiosReturned as $estudio)
                <tr class="text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200"
                    wire:key="estudio-{{ $estudio->id }}">
                    <td class="px-2 text-sm font-medium whitespace-nowrap">{{ $estudio->patient->name }}</td>
                    <td class="px-2 text-sm whitespace-nowrap">{{ $estudio->patient->age }}</td>
                    <td class="px-2 text-sm whitespace-nowrap">{{ $estudio->patient->document }}
                    </td>
                    <td class="px-2 text-sm whitespace-nowrap">
                        {{ $estudio->specialistUser->name ?? 'Sin asignar' }}</td>
                    <td class="px-2 text-sm whitespace-nowrap">{{ $estudio->study_state }}</td>
                    <td class="px-2 text-sm whitespace-nowrap">{{ $estudio->updated_at }}</td>
                    <td class="flex relative">
                        <div>
                            <button wire:click="openDrawerInfoReturned({{ $estudio->id }})"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/infoSquad.svg') }}"
                                    title="Ver detalles de devolución">
                                <span wire:loading wire:loading.flex wire:target="openDrawerInfoReturned"
                                    class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/5 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                                    <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                                </span>
                            </button>
                            @if ($showDrawerInfoReturned && $studyID === $estudio->id)
                                <div class="relative z-11">
                                    <livewire:drawers.drawer-info-returned :estudioId="$estudio->id"
                                        wire:key="drawer-info-{{ $estudio->id }}" />
                                </div>
                            @endif
                        </div>
                        <div>
                            <button wire:click="getOrthancStudies({{ $estudio->patient->id }})"
                                wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                type="button" title="Obtener el nuevo estudio">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/boxArrow.svg') }}">
                            </button>
                            @if ($selectedPatientId === $estudio->patient->id && !empty($studiesToView))
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
                                            <div class="relative z-10">
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
