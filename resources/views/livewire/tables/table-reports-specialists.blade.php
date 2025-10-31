<div>
    <div class="p-4 m-4 flex justify-around items-center">
        <div class="flex flex-col">
            <label for="user" class="text-xs">Selecciona el especialista</label>
            <div class="relative">
                <select wire:model.defer="user_id" name="user" id="user"
                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
                    required>
                    <option value="">-- Todos los Especialistas --</option>
                    @foreach ($selectUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
                    stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
            </div>
        </div>
        <div class="flex flex-col">
            <label for="start-date" class="text-xs">fecha de inicio</label>
            <input wire:model.defer="startDate" type="date" id="start-date"
                class="bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
        </div>
        <div class="flex flex-col">
            <label for="end-date" class="text-xs">fecha de fin</label>
            <input wire:model.defer="endDate" type="date" id="end-date"
                class="bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
        </div>
        <div class="h-full items-center">
            <button wire:click="getEstudiosXx"
                class="h-8 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-1 text-center cursor-pointer">
                Consultar
            </button>
        </div>
    </div>
    <div class="bg-stone-50 mt-4">
        <div class="mt-6">
            @if ($estudiosXx && $estudiosXx->count())
                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-800">
                        @if ($user_id)
                            Para el especialista: <strong>{{ $userName }}</strong> |
                        @endif
                        Entre <strong>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</strong>
                        y <strong>{{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</strong>
                        <br>
                        📊 Mostrando <strong>{{ $estudiosXx->count() }}</strong> de
                        <strong>{{ $estudiosXx->total() }}</strong> estudios totales
                        (Página {{ $estudiosXx->currentPage() }} de {{ $estudiosXx->lastPage() }})
                    </p>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="table-fixed w-full divide-y shadow-md divide-neutral-200/70">
                        <thead class="bg-stone-50">
                            <tr class="text-neutral-800">
                                <th class="w-[10%] px-5 py-3 text-xs text-left uppercase">
                                    Fecha de finalización
                                </th>
                                <th class="w-[20%] px-5 py-3 text-xs text-left uppercase">
                                    Paciente
                                </th>
                                <th class="w-[30%] px-5 py-3 text-xs text-left uppercase">
                                    Nombre del estudio
                                </th>
                                <th class="w-[20%] px-5 py-3 text-xs text-left uppercase">
                                    EPS
                                </th>
                                <th class="w-[20%] px-5 py-3 text-xs text-left uppercase">
                                    Procedencia
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200/70">
                            @foreach ($estudiosXx as $estudio)
                                <tr class="w-full text-neutral-600 text-xs bg-neutral-50 hover:bg-slate-200">
                                    <td class="w-[10%] px-5 text-sm font-medium whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($estudio->date_finalized)->format('d/m/Y') }}
                                    </td>
                                    <td class="w-[20%] px-6 py-4 whitespace-nowrap truncate overflow-hidden whitespace-nowrap" title="{{ $estudio->patient->name }}">
                                        {{ $estudio->patient->name ?? 'N/A' }} {{ $estudio->patient->first_surname ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 w-[30%] truncate overflow-hidden whitespace-nowrap"
                                        title="{{ $estudio->study_name }}">
                                        {{ $estudio->study_name }}
                                    </td>
                                    <td class="px-6 py-4 w-[20%] truncate overflow-hidden whitespace-nowrap"
                                        title="{{ $estudio->exam->epsSender->name }}">
                                        {{ $estudio->exam->epsSender->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 w-[20%] truncate overflow-hidden whitespace-nowrap"
                                        title="{{ $estudio->exam->departurePlace->name }}">
                                        {{ $estudio->exam->departurePlace->name ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-center">
                    {{ $estudiosXx->links('vendor.livewire.custom-pagination') }}
                </div>
            @elseif($user_id)
                <div class="text-center py-8 bg-yellow-50 rounded-lg border border-yellow-200">
                    <div class="text-yellow-600 text-lg mb-2">
                        📭 No se encontraron estudios
                    </div>
                    <p class="text-yellow-700">
                        No hay estudios que coincidan con los criterios de búsqueda.
                    </p>
                </div>
            @else
                <!-- Estado inicial -->
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-gray-500 text-lg mb-2">
                        ⬆️ Configura los filtros y haz click en "Consultar"
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
</div>
