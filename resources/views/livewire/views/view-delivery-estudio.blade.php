<div class="px-4">
    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="px-8 w-full">
            <div class="mb-2 text-gray-500">Módulo de entrega de estudios:</div>
            <div class="justify-between w-full">
                <div class="ml-2 text-xs text-gray-500">Acciones que puedes realizar:</div>
                <div class="flex items-center border-1 w-fit ml-4">
                    <div class="flex flex-col items-center bg-stone-100 m-2 p-2">
                        <img src="{{ asset('images/file-pdf.svg') }}" width="24">
                        <span class="flex align-bottom text-xs text-gray-500 ml-2">
                            Descargar lectura
                        </span>
                    </div>
                    <div class="flex flex-col items-center bg-stone-100 m-2 p-2">
                        <img src="{{ asset('images/showRad.svg') }}" width="24">
                        <span class="flex align-bottom text-xs text-gray-500 ml-2">
                            Descargar DICOM
                        </span>
                    </div>
                    <div class="flex flex-col items-center bg-stone-100 m-2 p-2">
                        <img src="{{ asset('images/sendMail.svg') }}" width="24">
                        <span class="flex align-bottom text-xs text-gray-500 ml-2">
                            Enviar correo de resultados
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center min-w-1/2">
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Buscar</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input wire:model.live="search" type="text" id="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ingresa la busqueda..." />
            </div>
        </div>
    </div>
    <table class="min-w-full divide-y shadow-md divide-neutral-200/70">
        <thead class="bg-stone-50">
            <tr class="text-neutral-800">
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Paciente
                    </span>
                </th>
                <th class="px-5 py-3 text-xs text-left uppercase">
                    <span class="flex items-center">
                        Fecha de estudio
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
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                        </svg>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200/70">
            @foreach ($estudios as $estudio)
                <tr class="text-neutral-600 text-xs bg-neutral-50 h-10 hover:bg-slate-200">
                    <td class="px-2 text-sm font-medium whitespace-nowrap">
                        {{ $estudio->patient->name }}
                    </td>
                    <td class="px-2 whitespace-nowrap">
                        {{ $estudio->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-2 whitespace-nowrap">
                        {{ $estudio->patient->document }}
                    </td>
                    <td class="px-2 whitespace-nowrap">
                        {{ $estudio->exam->departurePlace->name }}
                    </td>
                    <td class="max-w-[200px] truncate px-2" title="{{ $estudio->study_name }}">
                        {{ $estudio->study_name }}
                    </td>
                    <td class="px-2 whitespace-nowrap">
                        {{ $estudio->study_state }}
                    </td>
                    <td class="flex items-center h-10 px-2">
                        <a href="{{ route('pdfView', $estudio->id) }}"
                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                            target="_blank">
                            <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/file-pdf.svg') }}"
                                title="descargar PDF">
                        </a>
                        @if ($estudio->study_id_orthanc)
                            <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}"
                                target="_blank"
                                class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/showRad.svg') }}"
                                    title="Ver imagen DICOM">
                            </a>
                        @else
                            <span class="text-muted">Estudio no disponible</span>
                        @endif
                        <button wire:click="openDrawerSendMail('{{ $estudio->id }}')"
                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                            <img class="max-w-[20px] min-w-[20px]" src="images/sendMail.svg">
                        </button>
                        @if ($showDrawerSendMail && $estudioId == $estudio->id)
                            <livewire:drawers.drawer-send-mail :patientEmail="$estudio->patient->email" :estudioId="$estudio->id"
                                :studyID="$estudio->study_id_orthanc" :patient_id="$estudio->patient->id" />
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

