<div class="px-4">
    <div>
        <div class="flex items-center min-w-1/2">
            <label for="patient_search" class="mb-2 text-sm font-medium text-gray-900 sr-only">
                Ingresa el # de documento del paciente
            </label>
            <div class="relative w-full">
                @if (!$examId && !$showBoxOldExam)
                    <input oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        wire:model.live.debounce.400ms="search" type="text" id="patient_search"
                        placeholder="# de documento del paciente"
                        class="relative block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        wire:keydown.enter="patientId ? getDataPatient(patientId) : ''" autocomplete="off">
                @endif
                @if (count($patients) > 0)
                    <ul
                        class="relative left-0 top-0 z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-60 overflow-auto">
                        @foreach ($patients as $patient)
                            <li class="p-2 cursor-pointer hover:bg-indigo-100"
                                wire:click="selectPatient({{ $patient->id }})">
                                {{ $patient->name }} {{ $patient->first_surname }}
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
                                    * Nombre del estudio</label>
                                <select id="procedure" wire:model="procedure"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>--Selecciona--</option>
                                    @foreach ($listEstudios as $listEstudio)
                                        <option value="{{ $listEstudio->id }}">{{ $listEstudio->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" wire:model="procedure" placeholder="Nombre del estudio"
                                    id="procedure"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required> --}}
                            </div>
                            <div class="relative min-w-[430px] border-1 p-4">
                                <div class="relative w-1/4 -top-7 bg-stone-50 text-center">
                                    PACIENTE
                                </div>
                                <div class="mb-5">
                                    <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900">
                                        * Primer Nombre
                                    </label>
                                    <input type="text"
                                        oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                        wire:model.defer="patient_name" placeholder="Primer Nombre" id="patient_name"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="off" required>
                                </div>
                                <div class="mb-5">
                                    <label for="patient_middle_name"
                                        class="block mb-2 text-sm font-medium text-gray-900">
                                        Segundo Nombre
                                    </label>
                                    <input type="text"
                                        oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                        wire:model="patient_middle_name" placeholder="Segundo Nombre"
                                        id="patient_middle_name"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="off">
                                </div>
                                <div class="mb-5">
                                    <label for="patient_first_surname"
                                        class="block mb-2 text-sm font-medium text-gray-900">
                                        * Primer Apellido
                                    </label>
                                    <input type="text"
                                        oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                        wire:model="patient_first_surname" placeholder="Primer Apellido"
                                        id="patient_first_surname"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="off" required>
                                </div>
                                <div class="mb-5">
                                    <label for="patient_secund_lastname"
                                        class="block mb-2 text-sm font-medium text-gray-900">
                                        Segundo Apellido
                                    </label>
                                    <input type="text"
                                        oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                        wire:model="patient_secund_lastname" placeholder="Segundo Apellido"
                                        id="patient_secund_lastname"
                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-5">
                                <label for="type_document" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Tipo de documento
                                </label>
                                <select id="type_document" wire:model="type_document"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>--Selecciona--</option>
                                    <option value="CC">Cédula</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="TE">Tarjeta de extranjería</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="sexo" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Genero sexual asignado al nacer
                                </label>
                                <select id="sexo" wire:model="sexo"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="birth">* Fecha de nacimiento</label>
                                <input type="date" wire:model="birth" id="birth"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                    * email
                                </label>
                                <input type="email" wire:model="email" placeholder="correo electrónico"
                                    id="email"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                                @error('email')
                                    <p class="mt-2 text-xs text-red-600">
                                        {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="direction" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Dirección del paciente
                                </label>
                                <input type="text" wire:model="direction" placeholder="Dirección del paciente"
                                    id="direction"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div>
                            <div class="mb-5">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Teléfono de contacto
                                </label>
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    wire:model="phone" placeholder="Teléfono de contacto" id="phone"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="remision" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Remisión
                                </label>
                                <input type="text" wire:model="remision" placeholder="Remisión" id="remision"
                                    class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500"
                                    autocomplete="off" required>
                            </div>
                            <div class="mb-5">
                                <label for="eps_sender_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    * EPS Remitente
                                </label>
                                <select id="eps_sender_id" wire:model="eps_sender_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>--Seleccione EPS--</option>
                                    @foreach ($epsSenders as $epsSender)
                                        <option value="{{ $epsSender->id }}">{{ $epsSender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="departure_place_id" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Procedencia
                                </label>
                                <select id="departure_place_id" wire:model="departure_place_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>--Procedencia--</option>
                                    @foreach ($departure_places as $departure_place)
                                        <option value="{{ $departure_place->id }}">
                                            {{ $departure_place->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                        Hacer ingreso con documento #:<span
                            class="text-green-600 underline">{{ $search }}</span>
                    </button>
                </form>
            </div>
            @endif

            {{-- este if queda aquí para que se muestre el mensaje si no hay nada en el cuadro de busqueda --}}
            @if (strlen($search) === 0 && !$examId && !$showBoxOldExam)
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-gray-500 text-lg mb-2">
                        <img src="{{ asset('images/cartoon.svg') }}" class="absolute bottom-0 right-0">
                        <div>⬆️ Digita el número de identificación del paciente, <br> si ya está creado selecciónalo de
                            lo contrario, lo puedes crear</div>
                    </div>
                </div>
            @endif

            {{-- si el usuario seleccionó un paciente en el cuadro de busqueda le muestra los exámenes para que puede crear nuevo estudio o nuevo exam --}}
            @if ($patientData && !$showBoxOldExam && !$showBoxOldPatient && !$showBoxOldExam)
                <div class="flex justify-around flex-wrap">
                    <div>
                        {{-- el box de la info del paciente con el boton de drawerUpdatePatient --}}
                        <div
                            class="relative flex w-full p-4 max-w-lg flex-col rounded-lg bg-white shadow-sm border border-slate-200 my-6">
                            <div class="flex items-center gap-4 text-slate-800">
                                <img src="{{ asset('images/patient.svg') }}"
                                    class="relative inline-block h-[58px] w-[58px] !rounded-full  object-cover object-center" />
                                <div class="flex w-full flex-col">
                                    <div class="flex items-center justify-between">
                                        <h5 class="text-xl font-semibold text-slate-800">
                                            {{ $patientData->name }} {{ $patientData->first_surname }}
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

                            <button wire:click="drawerUpdatePatient" class="absolute bottom-2 right-2 cursor-pointer"
                                title="Editar datos del paciente">
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
                        {{-- los boxes de los exam que le pertenecen a este paciente --}}
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
                                        <div class="text-xs text-stone-400">Otros estudios</div>
                                        @foreach ($exam->patientEstudios as $patientEstudio)
                                            <li class="flex p-1 text-xs hover:bg-teal-50">
                                                <div class="w-90 truncate overflow-hidden whitespace-nowrap">{{ $patientEstudio->listEstudio->name }}</div>
                                                <div title="{{ $patientEstudio->date_realized ?? 'No se ha realizado' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#04b59f"><path d="M212.31-100Q182-100 161-121q-21-21-21-51.31v-535.38Q140-738 161-759q21-21 51.31-21h55.38v-84.61h61.54V-780h303.08v-84.61h60V-780h55.38Q778-780 799-759q21 21 21 51.31v535.38Q820-142 799-121q-21 21-51.31 21H212.31Zm0-60h535.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-375.38H200v375.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85ZM200-607.69h560v-100q0-4.62-3.85-8.46-3.84-3.85-8.46-3.85H212.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v100Zm0 0V-720v112.31Zm280 210.77q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.04 0-14.69 10.34-25.04 10.35-10.34 25.04-10.34t25.04 10.34q10.34 10.35 10.34 25.04 0 14.7-10.34 25.04-10.35 10.35-25.04 10.35Zm-160 0q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.04 0-14.69 10.34-25.04 10.35-10.34 25.04-10.34t25.04 10.34q10.34 10.35 10.34 25.04 0 14.7-10.34 25.04-10.35 10.35-25.04 10.35Zm320 0q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.04 0-14.69 10.34-25.04 10.35-10.34 25.04-10.34t25.04 10.34q10.34 10.35 10.34 25.04 0 14.7-10.34 25.04-10.35 10.35-25.04 10.35ZM480-240q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.03 0-14.7 10.34-25.04 10.35-10.35 25.04-10.35t25.04 10.35q10.34 10.34 10.34 25.04 0 14.69-10.34 25.03Q494.69-240 480-240Zm-160 0q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.03 0-14.7 10.34-25.04 10.35-10.35 25.04-10.35t25.04 10.35q10.34 10.34 10.34 25.04 0 14.69-10.34 25.03Q334.69-240 320-240Zm320 0q-14.69 0-25.04-10.35-10.34-10.34-10.34-25.03 0-14.7 10.34-25.04 10.35-10.35 25.04-10.35t25.04 10.35q10.34 10.34 10.34 25.04 0 14.69-10.34 25.03Q654.69-240 640-240Z"/></svg>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div>
                                        <form wire:submit.prevent="generateWorklistOldExam({{ $exam->id }})">
                                            <div class="mb-1">
                                                <div class="mb-5">
                                                    <label for="procedure"
                                                        class="block mb-2 text-sm font-medium text-gray-900">
                                                        * Nombre del estudio</label>
                                                    <select id="procedure" wire:model="procedure"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required>
                                                        <option value="" disabled selected>--Selecciona--
                                                        </option>
                                                        @foreach ($listEstudios as $listEstudio)
                                                            <option value="{{ $listEstudio->id }}">
                                                                {{ $listEstudio->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                    {{-- el form para un nuevo exam y nuevo estudio con este mismo paciente --}}
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
                                        <span class="font-semibold">para el paciente: {{ $patientData->name }}
                                            {{ $patientData->first_surname }}</span>
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
                                    <option value="" disabled selected>Seleccione EPS</option>
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
                                    <option value="" disabled selected>Procedencia</option>
                                    @foreach ($departure_places as $departure_place)
                                        <option value="{{ $departure_place->id }}">{{ $departure_place->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="procedure" class="block mb-2 text-sm font-medium text-gray-900">
                                    * Nombre del estudio</label>
                                <select id="procedure" wire:model="procedure"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>--Selecciona--
                                    </option>
                                    @foreach ($listEstudios as $listEstudio)
                                        <option value="{{ $listEstudio->id }}">
                                            {{ $listEstudio->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                Crear</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- muestra el box cuando se llena el formulario de nuevo paciente muestra el box y dentro de este bloque también esta el if vara verificar si es tocnólogo u otro usario --}}
            <div>
                @if ($patient_name && $examId && !$showBoxOldPatient && !$showBoxOldExam)
                    <div
                        class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                        {{ session('success') }}
                    </div>
                    <div class="flex justify-center">
                        <div
                            class="relative flex w-full p-4 max-w-lg flex-col rounded-lg bg-white shadow-[0px_30px_90px_0px_rgba(51,_65,_85,_0.12)] border border-slate-200 my-6">
                            <div class="flex items-center gap-4 text-slate-800">
                                <img src="{{ asset('images/patient.svg') }}" alt="Tania Andrew"
                                    class="relative inline-block h-[58px] w-[58px] !rounded-full  object-cover object-center" />
                                <div class="flex w-full flex-col">
                                    <div class="flex items-center justify-between">
                                        <h5 class="text-xl font-semibold text-slate-800">
                                            {{ $patient_name }} {{ $patient_first_surname }}
                                        </h5>
                                    </div>
                                    <p class="text-xs uppercase font-bold text-slate-500 mt-0.5">
                                        Número de documento: {{ $patient_id }}
                                    </p>
                                </div>
                            </div>
                            {{-- cuando se crea un nuevo WL con nuevo paciente y nuevo exam y el auth es Tecnólogo --}}
                            @if (auth()->user()->role === 'Tecnólogo')
                                <div class="mt-6 text-stone-600">
                                    <div class="mb-4 w-full text-gray-600">
                                        Ahora puedes tomar el estudio y luego enviarlo al Doctor
                                    </div>
                                    <ul>
                                        <li>
                                            <b class="mr-2">Estudio: </b><span>{{ $estudioList->name }}</span>
                                        </li>
                                    </ul>
                                    <div
                                        class="relative flex flex-wrap justify-left items-center w-full mt-2 py-1 px-4 border-1 rounded-xl bg-sky-50">
                                        <div class="text-sm mr-4">
                                            Primero toma el estudio y luego haz click aquí 👉
                                        </div>
                                        <button
                                            wire:click="getOrthancStudies({{ $patientId }}, {{ $examId }})"
                                            wire:loading.class="opacity-50 cursor-progress"
                                            wire:loading.attr="disabled"
                                            class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                            type="button" title="Obtener exámenes del paciente">
                                            <img class="max-w-[20px] min-w-[20px]"
                                                src="{{ asset('images/boxArrow.svg') }}">
                                        </button>
                                        @if (!empty($studiesToView))
                                            <ul
                                                class="absolute top-7 right-7 border-1 rounded-sm shadow-md bg-stone-50 z-999">
                                                <svg style="position: absolute; top: -17px; right:-17px; transform: rotate(45deg)"
                                                    xmlns="http://www.w3.org/2000/svg" height="40px"
                                                    viewBox="0 -960 960 960" width="40px" fill="#0ea5e9">
                                                    <path d="m280-400 200-200.67L680-400H280Z" />
                                                </svg>

                                                <div class="relative z-2">
                                                    @foreach ($studiesToView as $study)
                                                        <li
                                                            class="flex items-center h-10 p-1 hover:bg-gray-100 whitespace-nowrap">
                                                            <button wire:click="openDrawerStudyTech"
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
                                                        @if ($showDrawerStudyTech)
                                                            <div>
                                                                <livewire:drawers.drawer-study-tech :studyId="$study->id"
                                                                    :examId="$examId" :patientId="$patientId"
                                                                    wire:key="studydrawer-{{ $study->id }}" />
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                {{-- cuando se crea un nuevo WL con nuevo paciente y nuevo exam y el auth NO ES Tecnólogo --}}
                            @else
                                <div class="flex flex-col items-center justify-between">
                                    <ul class="w-full rounded-xl border-1 p-2">
                                        <li>
                                            <b class="mr-2">Estudio: </b><span>{{ $estudioList->name }}</span>
                                        </li>
                                    </ul>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960"
                                        width="48px" fill="#1304db">
                                        <path
                                            d="M296.15-240v-40h290.16q62.23 0 106.04-42.69 43.8-42.69 43.8-104.23 0-61.54-43.8-103.85-43.81-42.31-106.04-42.31H276.62l118.61 118.62-28.31 28.31L200-593.08 366.92-760l28.31 28.31-118.61 118.61h309.69q78.54 0 134.19 54.16 55.65 54.15 55.65 132 0 77.84-55.65 132.38Q664.85-240 586.31-240H296.15Z" />
                                    </svg>
                                    <button wire:click="resetear"
                                        class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                        Continuar
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- muestra el box si en el bloque de arriba el usuario asigna un nuevo estudio a un exam que ya existe --}}
            @if ($showBoxOldExam)
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                    {{ session('success') }}
                </div>
                <div class="flex justify-center">
                    <div
                        class="relative flex w-full p-4 max-w-lg flex-col rounded-lg bg-white shadow-[0px_30px_90px_0px_rgba(51,_65,_85,_0.12)] border border-slate-200 my-6">
                        <div class="flex items-center gap-4 text-slate-800">
                            <img src="{{ asset('images/patient.svg') }}" alt="Tania Andrew"
                                class="relative inline-block h-[58px] w-[58px] !rounded-full  object-cover object-center" />
                            <div class="flex w-full flex-col">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-xl font-semibold text-slate-800">
                                        {{ $patient_name }} {{ $patient_first_surname }}
                                    </h5>
                                </div>
                                <p class="text-xs uppercase font-bold text-slate-500 mt-0.5">
                                    Número de documento: {{ $patient_id }}
                                </p>
                            </div>
                        </div>
                        @if (auth()->user()->role === 'Tecnólogo')
                            <div class="mt-6 text-stone-600">
                                <div class="mb-4 w-full text-gray-600">
                                    Ahora puedes tomar el estudio y luego enviarlo al Doctor
                                </div>
                                <ul>
                                    <li>
                                        <b class="mr-2">Estudio: </b><span>{{ $estudioList->name }}</span>
                                    </li>
                                </ul>
                                <div
                                    class="relative flex flex-wrap justify-left items-center w-full mt-2 py-1 px-4 border-1 rounded-xl bg-sky-50">
                                    <div class="text-sm mr-4">
                                        Primero toma el estudio y luego haz click aquí 👉
                                    </div>
                                    <button wire:click="getOrthancStudies({{ $patientId }}, {{ $examId }})"
                                        wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                        type="button" title="Obtener exámenes del paciente">
                                        <img class="max-w-[20px] min-w-[20px]"
                                            src="{{ asset('images/boxArrow.svg') }}">
                                    </button>
                                    @if (!empty($studiesToView))
                                        <ul
                                            class="absolute top-7 right-7 border-1 rounded-sm shadow-md bg-stone-50 z-999">
                                            <svg style="position: absolute; top: -17px; right:-17px; transform: rotate(45deg)"
                                                xmlns="http://www.w3.org/2000/svg" height="40px"
                                                viewBox="0 -960 960 960" width="40px" fill="#0ea5e9">
                                                <path d="m280-400 200-200.67L680-400H280Z" />
                                            </svg>

                                            <div class="relative z-2">
                                                @foreach ($studiesToView as $study)
                                                    <li
                                                        class="flex items-center h-10 p-1 hover:bg-gray-100 whitespace-nowrap">
                                                        <button wire:click="openDrawerStudyTech"
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
                                                    @if ($showDrawerStudyTech)
                                                        <div>
                                                            <livewire:drawers.drawer-study-tech :studyId="$study->id"
                                                                :examId="$examId" :patientId="$patientId"
                                                                wire:key="studydrawer-{{ $study->id }}" />
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-between">
                                <ul class="w-full rounded-xl border-1 p-2">
                                    <li>
                                        <b class="mr-2">Estudio: </b><span>{{ $procedure }}</span>
                                    </li>
                                </ul>
                                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960"
                                    width="48px" fill="#1304db">
                                    <path
                                        d="M296.15-240v-40h290.16q62.23 0 106.04-42.69 43.8-42.69 43.8-104.23 0-61.54-43.8-103.85-43.81-42.31-106.04-42.31H276.62l118.61 118.62-28.31 28.31L200-593.08 366.92-760l28.31 28.31-118.61 118.61h309.69q78.54 0 134.19 54.16 55.65 54.15 55.65 132 0 77.84-55.65 132.38Q664.85-240 586.31-240H296.15Z" />
                                </svg>
                                <button wire:click="resetear"
                                    class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                    Continuar
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- muestra el box si en el bloque de arriba el usuario crea un nuevo exam con nuevo estudio paciente ya existe --}}
            @if ($showBoxOldPatient)
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
                    {{ session('success') }}
                </div>
                <div class="flex justify-center">
                    <div
                        class="relative flex w-full p-4 max-w-lg flex-col rounded-lg bg-white shadow-[0px_30px_90px_0px_rgba(51,_65,_85,_0.12)] border border-slate-200 my-6">
                        <div class="flex items-center gap-4 text-slate-800">
                            <img src="{{ asset('images/patient.svg') }}" alt="Tania Andrew"
                                class="relative inline-block h-[58px] w-[58px] !rounded-full  object-cover object-center" />
                            <div class="flex w-full flex-col">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-xl font-semibold text-slate-800">
                                        {{ $patient_name }} {{ $patient_first_surname }}
                                    </h5>
                                </div>
                                <p class="text-xs uppercase font-bold text-slate-500 mt-0.5">
                                    Número de documento: {{ $patient_id }}
                                </p>
                            </div>
                        </div>
                        @if (auth()->user()->role === 'Tecnólogo')
                            <div class="mt-6 text-stone-600">
                                <div class="mb-4 w-full text-gray-600">
                                    Ahora puedes tomar el estudio y luego enviarlo al Doctor
                                </div>
                                <ul>
                                    <li>
                                        <b class="mr-2">Estudio: </b><span>{{ $estudioList->name }}</span>
                                    </li>
                                </ul>
                                <div
                                    class="relative flex flex-wrap justify-left items-center w-full mt-2 py-1 px-4 border-1 rounded-xl bg-sky-50">
                                    <div class="text-sm mr-4">
                                        Primero toma el estudio y luego haz click aquí 👉
                                    </div>
                                    <button wire:click="getOrthancStudies({{ $patientId }}, {{ $examId }})"
                                        wire:loading.class="opacity-50 cursor-progress" wire:loading.attr="disabled"
                                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                                        type="button" title="Obtener exámenes del paciente">
                                        <img class="max-w-[20px] min-w-[20px]"
                                            src="{{ asset('images/boxArrow.svg') }}">
                                    </button>
                                    @if (!empty($studiesToView))
                                        <ul
                                            class="absolute top-7 right-7 border-1 rounded-sm shadow-md bg-stone-50 z-999">
                                            <svg style="position: absolute; top: -17px; right:-17px; transform: rotate(45deg)"
                                                xmlns="http://www.w3.org/2000/svg" height="40px"
                                                viewBox="0 -960 960 960" width="40px" fill="#0ea5e9">
                                                <path d="m280-400 200-200.67L680-400H280Z" />
                                            </svg>

                                            <div class="relative z-2">
                                                @foreach ($studiesToView as $study)
                                                    <li
                                                        class="flex items-center h-10 p-1 hover:bg-gray-100 whitespace-nowrap">
                                                        <button wire:click="openDrawerStudyTech"
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
                                                    @if ($showDrawerStudyTech)
                                                        <div>
                                                            <livewire:drawers.drawer-study-tech :studyId="$study->id"
                                                                :examId="$examId" :patientId="$patientId"
                                                                wire:key="studydrawer-{{ $study->id }}" />
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-between">
                                <ul class="w-full rounded-xl border-1 p-2">
                                    <li>
                                        <b class="mr-2">Estudio: </b><span>{{ $procedure }}</span>
                                    </li>
                                </ul>
                                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960"
                                    width="48px" fill="#1304db">
                                    <path
                                        d="M296.15-240v-40h290.16q62.23 0 106.04-42.69 43.8-42.69 43.8-104.23 0-61.54-43.8-103.85-43.81-42.31-106.04-42.31H276.62l118.61 118.62-28.31 28.31L200-593.08 366.92-760l28.31 28.31-118.61 118.61h309.69q78.54 0 134.19 54.16 55.65 54.15 55.65 132 0 77.84-55.65 132.38Q664.85-240 586.31-240H296.15Z" />
                                </svg>
                                <button wire:click="resetear"
                                    class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">
                                    Continuar
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>





</div>
