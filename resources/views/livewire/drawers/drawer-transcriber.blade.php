    <div class="fixed z-999 top-0 left-0 w-full h-full bg-gray-500/75 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full">
                <div class="relative w-screen h-[100vh] flex items-center justify-center">
                    <div class="absolute top-10">
                        <button wire:click="closeDrawer" type="button"
                            class="ring-2 shadow-md ring-stone-50 cursor-pointer relative rounded-full bg-blue-500 w-[30px] h-[30px] text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden">
                            <span class="text-lg flex flex-center justify-center">X</span>
                        </button>
                    </div>
                    <div
                        class="h-[70vh] absolute bottom-0 w-[96vw] max-w-[1400px] rounded-t-xl flex justify-around overflow-y-auto bg-white shadow-xl">
                        <div class="w-[25%] py-12">
                            <div class="w-full m-2 bg-gray-100 p-4 sm:px-6 rounded-md">
                                <div class="flex items-center gap-4 bg-gray-100">
                                    <img class="bg-gray-200 w-10 h-10 rounded-full"
                                        src="{{ asset('images/keyboard.svg') }}">
                                    <div class="font-medium dark:text-white">
                                        <h2 class="text-lg uppercase font-semibold text-gray-900">
                                            NOMBRE DEL ESTUDIO
                                        </h2>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $estudio->study_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full m-2 bg-gray-100 p-4 sm:px-6 rounded-md">
                                <div class="flex items-center gap-4 bg-gray-100">
                                    <img class="bg-gray-200 w-10 h-10 rounded-full"
                                        src="{{ asset('images/patient.svg') }}">
                                    <div class="font-medium dark:text-white">
                                        <h2 class="text-lg uppercase font-semibold text-gray-900">
                                            Nombre del paciente
                                        </h2>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $estudio->patient->name }} {{ $estudio->patient->first_surname }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6 px-1 w-full">
                                <div class="flex flex-col items-center justify-center">
                                    <audio controls class="w-full mt-2 rounded shadow">
                                        <source
                                            src="{{ asset('storage/audios/' . $estudio->id . '.webm') . '?v=' . time() }}"
                                            type="audio/webm">
                                        Tu navegador no soporta el reproductor de audio.
                                    </audio>

                                </div>
                            </div>
                            <div class="w-full m-2 flex justify-between bg-gray-100 p-4 sm:px-6 rounded-md">
                                <button wire:click="redirectPdf" class="flex flex-col items-center cursor-pointer block text-red-800 border border-transparent hover:border-red-400 focus:outline-none rounded-lg p-[3px] m-1">
                                    <span class="text-[10px]">Vista Previa </span><img
                                        src="{{ asset('/images/pdf.svg') }}" alt="">
                                </button>
                                @if ($pdfDataUrl)
                                    <div class="fixed top-0 left-0 w-[100vw] mt-4 border p-2 bg-stone-950">
                                        <h3>Vista Previa del PDF</h3>

                                        <iframe src="{{ $pdfDataUrl }}"
                                            style="width: 100%; height: 600px; border: none;"
                                            title="Vista Previa del PDF Generado">
                                        </iframe>

                                        <button wire:click="$set('pdfDataUrl', null)"
                                            class="m-4 p-2 bg-red-600 rounded-sm text-stone-50 cursor-pointer">
                                            Cerrar Vista Previa
                                        </button>
                                    </div>
                                @endif
                                <div>
                                    <div 
                                        class="flex flex-col items-center block p-[3px] m-1">
                                        <span class="text-[10px] text-stone-800">{{ $estudio->date_audio }}</span>
                                        <img class="max-w-[24px] min-w-[24px]" src="{{ asset('images/clock.svg') }}"
                                            title="Fecha de grabación">
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}"
                                        target="_blank"
                                        class="flex flex-col items-center cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                                        <span class="text-[10px] text-stone-800">Imagen DICOM</span>
                                        <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/showRad.svg') }}"
                                            title="Ver imagen DICOM">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <form wire:submit.prevent="store"
                            class="w-[60%] h-[90%] py-12 flex flex-col items-center justify-center">
                            <textarea wire:model="transcription" id="transcription" rows="14"
                                class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Digita la transcripción aquí..."></textarea>
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
