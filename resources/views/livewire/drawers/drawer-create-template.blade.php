    <div class="relative z-10">
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
                                            src="{{ asset('images/templatePlus.svg') }}">
                                        <div class="font-medium dark:text-white">
                                            <h2 class="text-lg uppercase font-semibold text-gray-900">
                                                CREAR NUEVA PLANTILLA
                                            </h2>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Dr(a) {{ Auth::user()->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mt-6 px-3 w-full">
                                    <div class="flex flex-col items-center justify-center w-full">
                                        <form wire:submit.prevent="saveTemplate" class="w-80">
                                            <div>
                                                <label for="title"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titulo</label>
                                                <input wire:model.defer="title" type="text" id="title"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Título de tu nueva plantilla" required />
                                            </div>
                                            <label for="content"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contenido</label>
                                            <textarea wire:model.defer="content" rows="4" placeholder="Digita tu nueva plantilla" id="content"
                                                class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            <button type="submit"
                                                class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Crear plantilla
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
    </div>
