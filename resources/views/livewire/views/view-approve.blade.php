<div class="px-4">
    <div class="flex bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="px-8 w-full">
            <div class="mb-2 text-gray-500">Módulo de aprobación de transcripciones:</div>
            <div class="justify-between w-full">
                <div class="ml-2 text-xs text-gray-500">Acciones que puedes realizar:</div>
                <div class="flex items-center border-1 w-fit ml-4">
                    <div class="flex flex-col items-center bg-stone-100 m-2 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#007595">
                            <path
                                d="M562.15-136v-78.38l202.31-201.31q4.18-3.57 8.35-5.32 4.17-1.76 8.23-1.76 4.43 0 8.82 1.58 4.39 1.57 7.99 4.73l44 45.77q3.51 4.18 5.29 8.43 1.78 4.26 1.78 8.4 0 4.15-1.75 8.31-1.76 4.15-5.32 8.24L640.54-136h-78.39Zm263.39-217.62-45-45.76 45 45.76Zm-240 194.24h45l132.69-131.93-22-23.79-22-22.75-133.69 133.47v45ZM288.62-136Q264-136 248-152.15q-16-16.15-16-40.47v-574.76q0-24.32 16.15-40.47T288.62-824H596l132 132v135.85h-32V-664H568v-128H288.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v574.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h186.15v32H288.62ZM496-480Zm245.23 164.9-22-22.75 44 46.54-22-23.79Z" />
                        </svg>
                        <span class="flex align-bottom text-xs text-gray-500 ml-2">
                            Activar edición
                        </span>
                    </div>
                    <div class="flex flex-col items-center bg-stone-100 m-2 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#1ca30a">
                            <path
                                d="M268-267.69 69.69-466l28.54-28.31 170 170L295.92-352l28.31 28.31-56.23 56Zm226 0L295.69-466 324-494.54l170 170 368-368L890.31-664 494-267.69ZM466.31-466l-28.54-28.31 198-198L664.31-664l-198 198Z" />
                        </svg>
                        <span class="flex align-bottom text-xs text-gray-500 ml-2">
                            Aprobar transcripción
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
    <div class="min-w-full mt-2">
        <table class="min-w-full divide-y divide-neutral-200/70">
            <thead class="bg-stone-50">
                <tr class="text-neutral-800 bg-stone-200">
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
                            Estudio
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Procedencia
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            Identificación
                        </span>
                    </th>
                    <th class="px-5 py-3 text-xs text-left uppercase">
                        <span class="flex items-center">
                            acciones
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200/70 w-full">
                <tr class="h-2"></tr>
                @foreach ($estudios as $estudio)
                    <tr wire:key="visible-{{ $estudio->id }}"
                        class="w-full text-green-600 text-xs bg-slate-300 h-10 hover:bg-slate-200">
                        <td class="pl-2">
                            <b class="text-stone-600">{{ $estudio->patient->name }}</b>
                        </td>
                        <td class="px-2 whitespace-nowrap">
                            {{ $estudio->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-2 max-w-[300px] truncate">
                            {{ $estudio->study_name }}
                        </td>
                        <td class="px-2">
                            {{ $estudio->exam->departurePlace->name }}
                        </td>
                        <td class="px-2">
                            {{ $estudio->patient->document }}
                        </td>
                        <td class="flex">
                            <button wire:click="activeEdit({{ $estudio->id }})" title="Activar edición"
                                class="cursor-pointer block border border-transparent bg-green-100 hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                    width="20px" fill="#007595">
                                    <path
                                        d="M562.15-136v-78.38l202.31-201.31q4.18-3.57 8.35-5.32 4.17-1.76 8.23-1.76 4.43 0 8.82 1.58 4.39 1.57 7.99 4.73l44 45.77q3.51 4.18 5.29 8.43 1.78 4.26 1.78 8.4 0 4.15-1.75 8.31-1.76 4.15-5.32 8.24L640.54-136h-78.39Zm263.39-217.62-45-45.76 45 45.76Zm-240 194.24h45l132.69-131.93-22-23.79-22-22.75-133.69 133.47v45ZM288.62-136Q264-136 248-152.15q-16-16.15-16-40.47v-574.76q0-24.32 16.15-40.47T288.62-824H596l132 132v135.85h-32V-664H568v-128H288.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v574.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h186.15v32H288.62ZM496-480Zm245.23 164.9-22-22.75 44 46.54-22-23.79Z" />
                                </svg>
                            </button>
                            <template x-data="{ open: @entangle('open') }" x-if="!open">
                                <button wire:click="approve({{ $estudio->id }})" title="Aprovar transcripción"
                                    wire:confirm="La transcripción será aprobada y guardada sin cambios"
                                    class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                    <svg class="group-hover:text-white transition-colors duration-300"
                                        xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                        width="20px" fill="currentColor">
                                        <path
                                            d="M268-267.69 69.69-466l28.54-28.31 170 170L295.92-352l28.31 28.31-56.23 56Zm226 0L295.69-466 324-494.54l170 170 368-368L890.31-664 494-267.69ZM466.31-466l-28.54-28.31 198-198L664.31-664l-198 198Z" />
                                    </svg>
                                </button>
                            </template>
                        </td>
                    </tr>
                    <tr wire:key="hidde-{{ $estudio->id }}" style="display: contents;"
                        class="border-b border-neutral-200">

                        {{-- El colspan debe ser igual al total de columnas visibles  --}}
                        @if ($open && $estudioId == $estudio->id)
                            <td colspan="6" class="bg-neutral-100 px-4 py-3 text-xs text-neutral-700">
                                <div>
                                    <form wire:submit.prevent="saveAndApprove({{ $estudio->id }})">
                                        <label for="reading">Digitado por:
                                            <b>{{ $estudio->transcriberUser->name }}</b>
                                        </label>
                                        <textarea wire:model="singleEstudio"
                                            class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                            name="reading" id="reading" rows="6"></textarea>
                                        <div class="flex">
                                            <button type="submit"
                                                class="flex justify-around items-center w-[110px] group cursor-pointer mr-4 px-1 py-1 text-xs text-center text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 uppercase">
                                                <span>Aprobar</span>
                                                <svg class="group-hover:text-white transition-colors duration-300"
                                                    xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                    <path
                                                        d="M268-267.69 69.69-466l28.54-28.31 170 170L295.92-352l28.31 28.31-56.23 56Zm226 0L295.69-466 324-494.54l170 170 368-368L890.31-664 494-267.69ZM466.31-466l-28.54-28.31 198-198L664.31-664l-198 198Z" />
                                                </svg>
                                            </button>
                                            <button type="button" wire:click="deactivate"
                                                class="flex justify-around items-center w-[110px] group cursor-pointer px-1 py-1 text-xs text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 uppercase">
                                                <span>cancelar</span>
                                                <svg class="group-hover:text-white transition-colors duration-300"
                                                    xmlns="http://www.w3.org/2000/svg" height="20px"
                                                    viewBox="0 -960 960 960" width="20px" fill="currentColor">
                                                    <path
                                                        d="M822.23-116.77 585.69-353.31l-87.92 87.93-142.31-142.31 23.31-21.77 119 119 64.61-66.16-386.84-386.84 23.31-21.77 646.69 646.69-23.31 21.77ZM293.77-265.38 151.46-407.69 174.77-431l116 116 27.69-27.69 26.31 26.31-51 51ZM660-427.62l-23.31-23.3 151.62-151.62 21.77 24.85L660-427.62ZM558-528.08l-23.31-23.3 48.08-47.08 23.31 23.31L558-528.08Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td colspan="6" class="bg-neutral-100 pb-4 text-sm text-neutral-600">
                                <textarea x-data="{
                                    resize: () => {
                                        $el.style.height = '0px';
                                        $el.style.height = $el.scrollHeight + 'px'
                                    }
                                }" x-init="resize()"
                                    class="p-2.5 w-full bg-white shadow-md rounded-b-lg border-b-gray-300 resize-none overflow-hidden" rows="4"
                                    disabled="true">{{ $estudio->reading }}</textarea>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($estudios)
        {{ $estudios->links('vendor.livewire.custom-pagination') }}
    @endif
</div>
