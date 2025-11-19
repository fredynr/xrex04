    <div class="fixed z-999 top-0 left-0 w-full h-full bg-gray-500/75 text-white">
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
                            <div class="flex gap-4 bg-gray-100">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960"
                                        width="48px" fill="#04bf1a">
                                        <path
                                            d="M719.38-440 193.85-630.15l12.61-37.54L744.31-472q29.23 11.08 42.46 34.15Q800-414.77 800-389.23v124.61q0 27.62-18.5 46.12Q763-200 735.38-200H224.62q-27.62 0-46.12-18.5Q160-237 160-264.62v-110.76q0-27.62 18.5-46.12Q197-440 224.62-440h494.76Zm16 200q9.24 0 16.93-7.69 7.69-7.69 7.69-16.93v-110.76q0-9.24-7.69-16.93-7.69-7.69-16.93-7.69H224.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v110.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h510.76Zm-329.23-60H700v-40H406.15v40ZM280-289.23q13.15 0 21.96-8.81t8.81-21.96q0-13.15-8.81-21.96T280-350.77q-13.15 0-21.96 8.81T249.23-320q0 13.15 8.81 21.96t21.96 8.81ZM200-240v-160 160Z" />
                                    </svg>
                                </div>
                                <div class="font-medium">
                                    <h2 class="text-lg text-gray-900 uppercase font-semibold">
                                        NOMBRE DEL PACIENTE
                                    </h2>
                                    <div class="flex text-sm text-gray-500">
                                        <span class="ml-1">{{ $patient->name }} {{ $patient->first_surname }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative mt-1 px-4 w-full">
                            <div class="p-2 mt-2 mb-2 border hover:shadow-md hover:bg-gray-50">
                                <a href="{{ route('viewer.redirect', ['studyId' => $this->orthancID]) }}"
                                    target="_blank">
                                    <div class="flex justify-around items-center pt-3 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="22px" width="22px"
                                            viewBox="0 0 256 256" enable-background="new 0 0 256 256"
                                            xml:space="preserve">
                                            <g>
                                                <g>
                                                    <g>
                                                        <path fill="#000000"
                                                            d="M10,92.9v83.2h63.1c49.8,0,63.3,0.2,63.7,0.7c0.3,0.4,3.8,8.7,7.7,18.4c3.9,9.7,7.8,18.7,8.8,20c3.8,5.5,10,10,16.4,12c2.4,0.7,4.2,1.6,4.8,2.4c0.5,0.6,1.9,4.2,3.1,7.8c1.3,3.6,2.6,7,3,7.7c0.6,1.1,1.3,1.2,27.5,1.2c23.5,0,27-0.1,27-0.9c0-0.5-2.6-7.7-5.8-16.1c-3.2-8.4-5.8-15.8-5.8-16.4c0-0.6,0.8-2.3,1.7-3.7c4.3-6.4,5.6-14.2,3.5-21.7c-0.6-2.4-1.9-5.9-2.7-7.7c-0.8-1.9-1.5-3.4-1.5-3.5c0-0.1,4.8-0.2,10.7-0.2H246V92.9V9.7H128H10V92.9z M239,92.9v76.3h-8.6h-8.6l-1.5-3.3c-0.8-1.9-5-12.2-9.4-23.1c-4.4-10.8-8.1-19.8-8.2-19.9c-0.1-0.1-1.3,0.4-2.8,1.1c-4.2,2-8.2,6-10.3,10.1c-1.7,3.4-1.8,4.1-1.6,8.2c0.2,3.8,0.8,5.8,3.5,12.6c1.8,4.5,3.8,9.5,4.5,11.1l1.2,3.1h-90.2H17V92.9V16.7h111h111V92.9z" />
                                                        <path fill="#000000"
                                                            d="M117.7,32.7c-0.2,0.2-0.4,1.7-0.4,3.5v3.1h-17c-14.4,0-17.2,0.1-18.3,0.9c-1.7,1.2-1.7,4.3-0.1,5.8c1.2,1,2.5,1.1,18.3,1.3l17,0.2V53v5.4H95.9c-20.7,0-21.4,0.1-22.9,1.2c-1.9,1.5-2,3.9-0.3,5.5c1.2,1,2.6,1.1,22.9,1.3l21.7,0.2V72v5.5H94.9c-18.6,0-22.7,0.2-24,0.9c-2.8,1.5-2.8,5.2-0.1,6.7c0.7,0.3,9.4,0.6,23.7,0.6h22.7v5.4v5.5l-20.2,0.2C78.9,97,76.7,97.1,75.4,98c-1.9,1.2-2.1,3.9-0.4,5.6c1.1,1.1,1.9,1.2,21.7,1.2h20.6v5.8v5.8H97.7c-16.8,0-19.8,0.1-20.9,0.9c-1.2,0.8-1.3,1.3-1.3,8.2c0,14.7,2.5,21.4,8.8,23.7c7.1,2.6,12.4-0.8,19-11.7c3.7-6.1,8.8-11.6,11.7-12.3l2-0.5l0.3,11.3l0.3,11.4l10.3,0.2l10.3,0.1v-11.6v-11.6l2.2,0.9c3.8,1.6,5.9,3.9,11.7,12.5c6.1,9.2,8.6,11.5,12.9,12c6,0.7,10.9-2.6,13.1-8.5c1.4-3.7,2.5-11.7,2.5-17.9c0-3.7-0.2-4.4-1.4-5.6l-1.4-1.5h-19.8h-19.7v-5.8v-5.8h20.8h20.8l1.2-1.3c1.6-1.7,1.6-2.8-0.1-4.9l-1.4-1.6l-20.6-0.2l-20.6-0.2v-5.5v-5.5h23c15,0,23.3-0.2,24.1-0.6c2.7-1.4,2.4-5.5-0.5-6.8c-0.9-0.4-8.6-0.6-23.9-0.6h-22.6V72v-5.4l22.1-0.2l22.1-0.2l1.1-1.4c1.5-1.8,1.4-3.3-0.3-5l-1.4-1.4h-21.8h-21.7V53v-5.4l17-0.2l17-0.2l1.5-1.4c1.9-1.7,1.9-3.5,0.2-5.2c-1.3-1.3-1.7-1.3-18.6-1.3h-17.2v-3.5v-3.5h-10C122.6,32.3,117.9,32.5,117.7,32.7z" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium">
                                                <span class="text-gray-900">ESTUDIO:</span> <span
                                                    class="text-gray-600 font-light">{{ $studyName }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="flex flex-col items-center justify-center w-full">
                                <form wire:submit.prevent="update" class="w-80" enctype="multipart/form-data">
                                    <label for="tech_description" class="block mb-2 text-sm font-medium text-gray-900">
                                        Comentar el estudio
                                    </label>
                                    <textarea wire:model="techDescription" id="tech_description" rows="4"
                                        class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Escribe el comentario aquí..."></textarea>
                                    <div class="w-xs">
                                        <label for="priority" class="block mb-2 text-sm font-medium text-gray-900">
                                            Asigna la prioridad
                                        </label>
                                        <select wire:model="priority" id="priority"
                                            class="block w-full p-2 text-gray-900 border rounded-lg text-xs focus:ring-blue-500 border-blue-500"
                                            required>
                                            <option value="">Seleccione</option>
                                            <option value="Baja">Baja</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Alta">Alta</option>
                                        </select>
                                    </div>

                                    <div class="w-xs">
                                        <label for="specialist" class="block mb-2 text-sm font-medium text-gray-900">
                                            Asigna el especialista
                                        </label>
                                        <select wire:model="especialista" id="specialist"
                                            class="block w-full p-2 text-gray-900 border rounded-lg text-xs focus:ring-blue-500 border-blue-500">
                                            <option value="">Selecciona un especialista</option>
                                            @foreach ($especialistas as $especialista)
                                                <option value="{{ $especialista->id }}">{{ $especialista->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="border-2 p-4 my-4 rounded-xl">
                                        <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-white"
                                            for="file_input">Sube la imagen de la remisón del paciente</label>
                                        <input wire:model="remision"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                            id="file_input" type="file" accept=".jpg,image/jpeg">
                                        @error('remision')
                                            <div class="text-red-600 text-sm mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" wire:loading.disabled
                                        class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <span wire:loading.remove>Enviar Estudio</span>
                                        <div wire:loading wire:loading.delay class="flex items-center justify-center">
                                            <svg class="animate-spin h-3 w-3 text-blue-600 fill-blue-800/20"
                                                viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" fill="none">
                                                <circle cx="50" cy="50" r="45" stroke="currentColor"
                                                    stroke-width="10" opacity="0.2" />
                                                <path d="M50 5a45 45 0 0 1 0 90" stroke="currentColor" stroke-width="10"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </div>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
