<div class="px-4">
    <div>
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                {{ session('success') }}</div>
        @endif
    </div>

    <div>
        <div class="flex items-center min-w-1/2">
            <label for="patient_search" class="mb-2 text-sm font-medium text-gray-900 sr-only">
                Ingresa el # de documento del paciente
            </label>
            <div class="relative w-full">
                <input wire:model.live.debounce.400ms="search" type="text" id="patient_search"
                    placeholder="# de documento del paciente"
                    class="relative block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    wire:keydown.enter="patientId ? getDataPatient(patientId) : ''" autocomplete="off">
                @if (count($patients) > 0)
                    <ul
                        class="relative left-0 top-0 z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-60 overflow-auto">
                        @foreach ($patients as $patient)
                            <li class="p-2 cursor-pointer hover:bg-indigo-100" {{-- ⚡️ Llama a selectPatient al hacer clic ⚡️ --}}
                                wire:click="selectPatient({{ $patient->id }})">
                                {{ $patient->name }}
                            </li>
                        @endforeach
                    </ul>
            </div>
        @elseif (strlen($search) >= 3 && count($patients) == 0 && $patientId === null)
            {{-- formulario si no hay coincidencias --}}
            <div class="bg-stone-50 rounded-sm shadow-md px-4 py-2">
                <form wire:submit.prevent="generateWorklist">
                    {{-- inicio de campos necesaario para worklist --}}
                    <div class="flex justify-around">
                        <div>
                            <div class="mb-5">
                                <label for="procedure" class="block mb-2 text-sm font-medium text-gray-900">
                                    Nombre del estudio</label>
                                <input type="text" wire:model="procedure" placeholder="Nombre del estudio"
                                    id="procedure"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">
                                    Nombre del paciente
                                </label>
                                <input type="text" wire:model="patient_name" placeholder="Nombre del paciente"
                                    id="patient_name"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            {{-- fin de campos necesarios para worklist --}}
                            <div class="mb-5">
                                <label for="type_document" class="block mb-2 text-sm font-medium text-gray-900">
                                    Tipo de documento
                                </label>
                                <select id="type_document" wire:model="type_document"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Seleccione</option>
                                    <option value="CC">Cédula</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="TE">Tarjeta de extranjería</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="sexo" class="block mb-2 text-sm font-medium text-gray-900">
                                    Genero sexual asignado al nacer
                                </label>
                                <select id="sexo" wire:model="sexo"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Seleccione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="direction" class="block mb-2 text-sm font-medium text-gray-900">
                                    Dirección del paciente
                                </label>
                                <input type="text" wire:model="direction" placeholder="Dirección del paciente"
                                    id="direction"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="birth">Fecha de nacimiento</label>
                                <input type="date" wire:model="birth"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                        </div>
                        <div>
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                    email
                                </label>
                                <input type="email" wire:model="email" placeholder="correo electrónico" id="email"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                                    Teléfono de contacto
                                </label>
                                <input type="text" wire:model="phone" placeholder="Telefono de contacto"
                                    id="phone"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="remision" class="block mb-2 text-sm font-medium text-gray-900">
                                    Remisión
                                </label>
                                <input type="text" wire:model="remision" placeholder="Remisión" id="remision"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="eps_sender_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    EPS Remitente
                                </label>
                                <select id="eps_sender_id" wire:model="eps_sender_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Seleccione EPS</option>
                                    @foreach ($epsSenders as $epsSender)
                                        <option value="{{ $epsSender->id }}">{{ $epsSender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="departure_place_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    EPS Remitente
                                </label>
                                <select id="departure_place_id" wire:model="departure_place_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Procedencia</option>
                                    @foreach ($departure_places as $departure_place)
                                        <option value="{{ $departure_place->id }}">{{ $departure_place->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                        Hacer ingreso con documento #:<span class="text-green-600 underline">{{ $search }}</span>
                    </button>
                </form>
            </div>
            @endif
            @if (strlen($search) === 0)
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-gray-500 text-lg mb-2">
                        <img src="{{ asset('images/cartoon.svg') }}" class="absolute bottom-0 right-0">
                        <div>⬆️ Digita el número de identificación del paciente, <br> si ya está creado selecciónalo de
                            lo contrario, lo puedes crear</div>
                    </div>
                </div>
            @endif
            @if ($patientData)
                <div class="flex justify-around flex-wrap">
                    <div>
                        <div
                            class="relative flex w-full p-4 max-w-lg flex-col rounded-lg bg-white shadow-sm border border-slate-200 my-6">
                            <div class="flex items-center gap-4 text-slate-800">
                                <img src="{{ asset('images/patient.svg') }}" alt="Tania Andrew"
                                    class="relative inline-block h-[58px] w-[58px] !rounded-full  object-cover object-center" />
                                <div class="flex w-full flex-col">
                                    <div class="flex items-center justify-between">
                                        <h5 class="text-xl font-semibold text-slate-800">
                                            {{ $patientData->name }}
                                        </h5>
                                    </div>
                                    <p class="text-xs uppercase font-bold text-slate-500 mt-0.5">
                                        Número de documento: {{ $patientData->document }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <ul>
                                    <li><b>Teléfono:</b><span>{{ $patientData->phone }}</span></li>
                                    <li><b>Edad:</b><span>{{ $patientData->age }} años</span></li>
                                    <li><b>email:</b><span>{{ $patientData->email }}</span></li>
                                </ul>
                            </div>

                            <button wire:click="drawerUpdatePatient" class="absolute bottom-2 right-2 cursor-pointer" title="Editar datos del paciente">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                    width="20px" fill="#00c951">
                                    <path
                                        d="M212.31-140Q182-140 161-161q-21-21-21-51.31v-535.38Q140-778 161-799q21-21 51.31-21h346.23l-60 60H212.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v535.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h535.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-288.77l60-60v348.77Q820-182 799-161q-21 21-51.31 21H212.31ZM480-480ZM380-380v-137.31l362.39-362.38q9.3-9.31 20.46-13.58 11.15-4.27 22.69-4.27 11.77 0 22.61 4.27Q819-889 827.92-880.08L878.15-830q8.69 9.31 13.35 20.54 4.65 11.23 4.65 22.77t-3.96 22.38q-3.96 10.85-13.27 20.15L515.38-380H380Zm456.77-406.31-50.23-51.38 50.23 51.38ZM440-440h49.85l249.3-249.31-24.92-24.92-26.69-25.69L440-492.38V-440Zm274.23-274.23-26.69-25.69 26.69 25.69 24.92 24.92-24.92-24.92Z" />
                                </svg>
                            </button>
                            @if ($showDrawerUpdatePatient)
                                <div>
                                    <livewire:drawers.drawer-update-patient :patientId="$patientData->id" />
                                </div>
                            @endif

                        </div>
                        <div>
                            @foreach ($patientData->exams as $exam)
                                <div class="mb-2 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#04bf1a">
                                            <path
                                                d="M480-424.62 80.77-632.31 480-840l400 207.69-400 207.69Zm0 152.31L103.77-467.77l41.69-22.92L480-317.92l335.31-172.77L857-467.77 480-272.31ZM480-120 103.77-315.46l41.69-22.92L480-165.62l335.31-172.76L857-315.46 480-120Zm0-350.23 316.85-162.08L480-794.38 163.92-632.31 480-470.23Zm.77-162.08Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5
                                            class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            <span class="text-xl">Número de remision:</span> {{ $exam->remision }}
                                        </h5>
                                    </div>
                                    <ul class="h-[100px] mb-3 font-normal text-gray-500 overflow-y-auto">
                                        <div class="text-xs text-stone-400">Estudios realizados</div>
                                        @foreach ($exam->patientEstudios as $patientEstudio)
                                            <li class="text-sm">{{ $patientEstudio->study_name }}</li>
                                        @endforeach
                                    </ul>
                                    <div>
                                        <form wire:submit.prevent="generateWorklistOldExam">
                                            <div class="mb-1">
                                                <label for="procedure"
                                                    class="block text-sm font-medium text-gray-900">
                                                    Agregar nuevo estudio a esta remisión</label>
                                                <input type="text" wire:model="procedure"
                                                    placeholder="Ingresa el nombre del estudio" id="procedure"
                                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                                    autocomplete="off" required>
                                            </div>
                                            <button type="submit"
                                                class="w-full mt-1 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                                Nuevo estudio para esta remisión<span
                                                    class="text-green-600 underline ml-2">{{ $exam->remision }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="flex w-full p-4 max-w-md max-h-[90vh] flex-col rounded-lg bg-white shadow-sm border border-slate-200 my-6">
                        <div class="w-full bg-gray-100 p-4 sm:px-6">
                            <div class="flex items-center gap-4 bg-gray-100">
                                <img class="bg-gray-200 w-10 h-10 rounded-full"
                                    src="{{ asset('images/boxPlusArrow.svg') }}">
                                <div class="font-medium">
                                    <h2 class="text-lg uppercase font-semibold text-gray-900">
                                        NUEVO ESTUDIO CON NUEVA REMISIÓN
                                    </h2>
                                    <div class="text-sm text-gray-500">
                                        <span class="font-semibold">para el paciente: {{ $patientData->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form wire:submit.prevent="generateWlOldPatient">
                            <div class="mb-5">
                                <label for="remision_patient" class="block mb-2 text-sm font-medium text-gray-900">
                                    Remisión
                                </label>
                                <input type="text" wire:model="remision" placeholder="Remisión"
                                    id="remision_patient"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="eps_sender_id_patient"
                                    class="block mb-2 text-sm font-medium text-gray-900">
                                    EPS Remitente
                                </label>
                                <select id="eps_sender_id_patient" wire:model="eps_sender_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Seleccione EPS</option>
                                    @foreach ($epsSenders as $epsSender)
                                        <option value="{{ $epsSender->id }}">{{ $epsSender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="departure_place_id_patient"
                                    class="block mb-2 text-sm font-medium text-gray-900">
                                    Procedencia
                                </label>
                                <select id="departure_place_id_patient" wire:model="departure_place_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option selected>Procedencia</option>
                                    @foreach ($departure_places as $departure_place)
                                        <option value="{{ $departure_place->id }}">{{ $departure_place->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="procedure_patient" class="block mb-2 text-sm font-medium text-gray-900">
                                    Nombre del estudio</label>
                                <input type="text" wire:model="procedure" placeholder="Nombre del estudio"
                                    id="procedure_patient"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <button type="submit"
                                class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                Crear</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>

    </div>





</div>
