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
                        <div class="w-full text-gray-400 m-2 p-2 border-b-1">
                            <h2>
                                Nombre del paciente
                            </h2>
                            <div class="text-base">
                                {{ $estudio->patient->name }}
                            </div>
                        </div>
                        <div class="relative mt-6 px-1 w-full">
                            <div class="flex flex-col items-center justify-center w-full">
                                <audio controls class="w-full mt-2 rounded shadow">
                                    <source src="{{ asset('storage/audios/' . $estudio->id . '.webm') . '?v=' . time() }}" type="audio/webm">
                                    Tu navegador no soporta el reproductor de audio.
                                </audio>

                                <form wire:submit.prevent="store" class="flex flex-col w-80">
                                    <label for="transcription" class="block mb-2 text-sm font-medium text-gray-900">
                                        Digita la transcripción
                                    </label>
                                    <textarea wire:model="transcription" id="transcription" rows="4"
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
        </div>
    </div>
