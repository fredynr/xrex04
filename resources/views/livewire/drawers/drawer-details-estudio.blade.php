    <div class="fixed z-999 top-0 left-0 w-full h-full bg-gray-500/75 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="relative w-screen max-w-md">
                    <div class="absolute top-2 left-0 -ml-5">
                        <button wire:click="closeDrawerAddendum" type="button"
                            class="ring-2 shadow-md ring-stone-50 cursor-pointer relative rounded-full bg-blue-500 w-[30px] h-[30px] text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden">
                            <span class="text-lg flex flex-center justify-center">X</span>
                        </button>
                    </div>
                    <div class="flex h-full flex-col items-start overflow-y-auto bg-white shadow-xl">
                        <div class="w-full bg-gray-100 p-4 sm:px-6">
                            <div class="flex items-center gap-4 bg-gray-100">
                                <img class="bg-gray-200 w-10 h-10 rounded-full" src="{{ asset('images/patient.svg') }}">
                                <div class="font-medium dark:text-white">
                                    <h2 class="text-lg uppercase font-semibold text-gray-900">
                                        NOMBRE DEL PACIENTE
                                    </h2>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center w-full justify-center py-3 sm:py-4">
                            <div class="flex items-center w-80">
                                @if ($estudio->study_id_orthanc)
                                    <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}" target="_blank"
                                        class="px-2 hover:bg-gray-100 rounded-md dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <div class="flex justify-around pt-3 cursor-pointer dark:text-white">
                                            <img class="w-6 h-6" src="{{ asset('images/hradiology.svg') }}">
                                        </div>
                                    </a>
                                @else
                                    <span class="mt-2" style="color: red; font-size: 1rem;"
                                        title="Estudio no disponible ☹">✘</span>
                                @endif
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        ESTUDIO 
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $estudio->study_name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="relative mt-6 px-1 w-full">
                            <div class="flex flex-col items-center justify-center w-full">
                                <div class="text-stone-400">
                                   El estudio se encuetra en estado: {{ $estudio->study_state }}
                                   @if ($estudio->specialistUser)
                                   La lectura fue realizada por el doctor: {{ $estudio->specialistUser->name }}
                                       @else
                                       No se ha realizado la lectura
                                   @endif
                                   La fecha en que se realizó el estudio fue: {{ $estudio->date_realized }}
                                </div>
                            </div>
                            <div class="flex flex-col items-center justify-center w-full">
                                <div class="w-80">
                                    <textarea
                                    class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    rows="10" disabled >{{ $estudio->reading ?? 'No hay lectura' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


