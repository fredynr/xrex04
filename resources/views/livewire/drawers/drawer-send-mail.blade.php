<div class="z-999">
    <div class="fixed top-0 left-0 w-full h-full bg-gray-500/75 text-white">
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
                                    src="{{ asset('images/sendMail.svg') }}">
                                <div class="font-medium dark:text-white">
                                    <h2 class="text-lg uppercase font-semibold text-gray-900">
                                        ESTUDIO DEL PACIENTE:
                                    </h2>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">{{ $patientName }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative mt-6 px-3 w-full">
                            <div class="flex flex-col items-center justify-center w-full">
                                <form wire:submit.prevent="enviarMail()" class="w-80">
                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Destinatario</label>
                                        <input wire:model.defer="patientEmail" type="text" id="email"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            required />
                                    </div>
                                    <button type="submit" wire:loading.remove
                                        class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Enviar Correo
                                    </button>
                                    <button wire:loading wire:target="enviarMail"
                                        class="w-full px-3 py-2 ring-sky-600 ring-offset-sky-700 rounded-lg bg-blue-800/10 outline-1 outline-offset-2">
                                        <svg class="animate-spin h-6 w-6 text-blue-600 w-6 h-6 block mx-auto"
                                            viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" fill="none">
                                            <circle cx="50" cy="50" r="45" stroke="currentColor"
                                                stroke-width="10" opacity="0.2" />
                                            <path d="M50 5a45 45 0 0 1 0 90" stroke="currentColor" stroke-width="10"
                                                stroke-linecap="round" />
                                        </svg>
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
