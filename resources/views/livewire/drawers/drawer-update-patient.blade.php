    <div class="fixed z-999 top-0 left-0 w-full h-full bg-gray-500/75 text-white">
        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div class="relative w-screen max-w-md">
                        <div class="absolute top-2 left-0 -ml-5">
                            <button wire:click="closeDrawer" type="button"
                                class="ring-2 shadow-md ring-stone-50 cursor-pointer relative rounded-full bg-blue-500 w-[30px] h-[30px] text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden">
                                <span class="text-lg flex flex-center justify-center">X</span>
                            </button>
                        </div>
                        <div class="flex h-full flex-col items-start overflow-y-auto bg-white shadow-xl">
                            <div class="w-full bg-gray-100 p-4 sm:px-6">
                                <div class="flex items-center gap-4 bg-gray-100">
                                    <img class="bg-gray-200 w-10 h-10 rounded-full"
                                        src="{{ asset('images/edit.svg') }}">
                                    <div class="font-medium dark:text-white">
                                        <h2 class="text-lg uppercase font-semibold text-gray-900">
                                            EDITAR DATOS DEL PACIENTE
                                        </h2>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $patientName }} {{ $patient->first_surname }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6 px-3 w-full">
                                <div class="flex flex-col items-center justify-center w-full">
                                    <form wire:submit.prevent="updatePatient" class="w-80 text-gray-900">
                                        <label for="patient-name"
                                            class="block mb-1 text-sm text-gray-900 dark:text-white">Primer
                                            Nombre</label>
                                        <input type="text"
                                            oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                            wire:model.defer="patientName" id="patient-name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        <label for="patient-middlename"
                                            class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Segundo
                                            Nombre</label>
                                        <input type="text"
                                            oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                            wire:model.defer="patientMiddlename" id="patient-middlename"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        <label for="patient-surname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Primer
                                            Apellido</label>
                                        <input type="text"
                                            oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                            wire:model.defer="patientSurname" id="patient-surname"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        <label for="patient-lastname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Segundo
                                            Apellido</label>
                                        <input type="text"
                                            oninput="this.value = this.value.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^A-Z]/g, '');"
                                            wire:model.defer="patientLastname" id="patient-lastname"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">

                                        <label for="patient-direction"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                                        <input type="text" wire:model.defer="patientDirection" id="patient-direction"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        <label for="patient-email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" wire:model.defer="patientEmail" id="patient-email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        @error('patientEmail')
                                            <p class="mt-2 text-xs text-red-600">
                                                {{ $message }} </p>
                                        @enderror
                                        <label for="patient-phone"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
                                        <input type="text" wire:model.defer="patientPhone" id="patient-phone"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 mb-2">
                                        <label for="patient-birth"
                                            class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Fecha
                                            de nacimiento</label>
                                        <input type="date" wire:model.defer="patientBirth" id="patient-birth"
                                            class="border-1 p-2">
                                        <button type="submit"
                                            class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Guardar Cambios
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
