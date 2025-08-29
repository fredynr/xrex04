<div class="z-999">
    <div class="fixed top-0 left-0 w-full h-full bg-gray-500/75 text-white">
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
                                        src="{{ asset('images/undo.svg') }}">
                                    <div class="font-medium dark:text-white">
                                        <h2 class="text-lg uppercase font-semibold text-gray-900">
                                            ESTUDIO DEVUELTO
                                        </h2>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold">Paciente:</span>
                                            {{ $patientEstudio->patient->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center">
                                        <a href="http://localhost:8042/osimis-viewer/app/index.html?study={{ $patientEstudio->study_id_orthanc }}"
                                            target="_blank"
                                            class="px-2 hover:bg-gray-100 rounded-md dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <div class="flex justify-around pt-3 cursor-pointer dark:text-white">
                                                <img class="w-6 h-6" src="{{ asset('images/hradiology.svg') }}">
                                            </div>
                                        </a>
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                ESTUDIO
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $patientEstudio->study_name }}
                                            </p>
                                        </div>
                                        <div
                                            class="ml-2 flex flex-col items-center text-base font-semibold text-gray-900">
                                            <div class="text-xs">
                                                Fecha:
                                            </div>
                                            <span class="text-xs">
                                                {{ $patientEstudio->created_at }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="p-3 m-4 sm:py-4 border-1 border-gray-200 text-gray-500">
                                    <span class="block text-xs text-gray-700">Razón de devolución:</span>
                                    {{ $patientEstudio->reason_for_return }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
