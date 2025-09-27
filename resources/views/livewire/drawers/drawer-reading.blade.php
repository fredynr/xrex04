<div class="fixed z-999 top-0 left-0 w-full h-full bg-gray-500/75 text-white">
    <div x-data="{ reading: @entangle('reading').live }" class="relative z-10"
        @voiceTranscribed.window="reading = $event.detail; $nextTick(() => console.log('✅ Valor actualizado:'))">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="relative w-screen max-w-md">

                    @if ($this->studyFinder)
                        {{-- la X que cierra el drawer --}}
                        <div class="absolute top-2 left-0 -ml-5">
                            <button wire:click="closeDrawer()" type="button" wire:target="closeDrawer"
                                wire:loading.remove
                                class="ring-2 shadow-md ring-stone-50 cursor-pointer relative rounded-full bg-blue-500 w-[30px] h-[30px] text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden">
                                <span class="text-lg flex flex-center justify-center">X</span>
                            </button>
                        </div>
                        <div class="flex h-full flex-col items-start overflow-y-auto bg-white shadow-xl">
                            <div class="w-full bg-gray-100 p-4 sm:px-6">
                                <div class="flex items-center gap-4 bg-gray-100">
                                    <img class="bg-gray-200 w-10 h-10 rounded-full"
                                        src="{{ asset('images/patient.svg') }}">
                                    <div class="font-medium dark:text-white">
                                        <h2 class="text-lg uppercase font-semibold text-gray-900">
                                            {{ $this->studyFinder->patient->name }}
                                        </h2>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            EDAD {{ $this->studyFinder->patient->age }} AÑOS
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 px-3 sm:px-6">
                                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center">
                                            @if ($this->studyFinder->study_id_orthanc)
                                                <a href="{{ route('viewer.redirect', ['studyId' => $this->studyFinder->study_id_orthanc]) }}"
                                                    target="_blank"
                                                    class="px-2 hover:bg-gray-100 rounded-md dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <div
                                                        class="flex justify-around pt-3 cursor-pointer dark:text-white">
                                                        <img class="w-6 h-6" src="{{ asset('images/hradiology.svg') }}">
                                                    </div>
                                                </a>
                                            @endif
                                            <div class="flex-1 min-w-0 ms-4">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    ESTUDIO
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $this->studyFinder->study_name }}
                                                </p>
                                            </div>
                                            <div
                                                class="flex flex-col items-center text-base font-semibold text-gray-900">
                                                <div class="text-xs">Fecha:</div><span class="text-xs">
                                                    {{ $this->studyFinder->created_at }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <div x-data="{ openReturn: false }" class="mb-3 bg-slate-50">
                                        <button @click="openReturn = !openReturn"
                                            :class="openReturn
                                                ?
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-700 border border-b-1 border-gray-300 bg-blue-100 rounded-t-md cursor-pointer' :
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-500 border border-b-1 border-gray-200 bg-slate-50 rounded-t-md cursor-pointer hover:bg-gray-100'"
                                            class="gap-3">
                                            Devolver al tecnólogo
                                            <svg :class="openReturn ? 'rotate-90 text-blue-600' : 'rotate-0 text-gray-500'"
                                                class="w-3 h-3 shrink-0 transition-transform duration-300 ease-in-out origin-center"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"
                                                aria-hidden="true">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1 L5 5 L9 1" />
                                            </svg>
                                        </button>
                                        <div x-show="openReturn" @click.outside="openReturn = false"
                                            class="w-100 h-full mb-3 flex justify-center">
                                            <form wire:submit.prevent="returnToTech" class="w-80">
                                                <textarea wire:model.defer="reasonForReturn" rows="4" placeholder="Envía un comentario...🚀"
                                                    class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                                    required></textarea>
                                                <button type="submit" wire:target="returnToTech" wire:loading.remove
                                                    class="w-full mt-2 cursor-pointer px-3 py-2 text-blue-500 text-xs ring-sky-600 ring-offset-sky-700 font-medium text-center rounded-lg bg-blue-800/10 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2">Devolver
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <li x-data="{ openPrevius: false }" class="relative">
                                        <button @click="openPrevius = !openPrevius"
                                            :class="openPrevius
                                                ?
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-700 border border-b-1 border-gray-300 bg-blue-100 rounded-t-md cursor-pointer' :
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-500 border border-b-1 border-gray-200 bg-slate-50 rounded-t-md cursor-pointer hover:bg-gray-100'"
                                            class="gap-3">
                                            <span>Estudios anteriores</span>
                                            <svg :class="openPrevius ? 'rotate-90 text-blue-600' : 'rotate-0 text-gray-500'"
                                                class="w-3 h-3 shrink-0 transition-transform duration-300 ease-in-out origin-center"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"
                                                aria-hidden="true">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1 L5 5 L9 1" />
                                            </svg>
                                        </button>
                                        <div x-show="openPrevius"
                                            class="p-2 bg-slate-50 border border-x-1 border-b-1 border-t-0 border-gray-200">
                                            <p>
                                                @foreach ($oldEstudios as $oldStudy)
                                                    <div class="bg-white border border-1 p-2 mb-2"
                                                        wire:key="$old-study-{{ $oldStudy->id }}">
                                                        <span
                                                            class="text-blue-600 text-xs inline-flex items-center py-0.5 rounded-sm dark:bg-gray-700 dark:text-blue-400">
                                                            <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                                                            </svg>
                                                            {{ $oldStudy->created_at->translatedFormat('l d \d\e F Y') }}
                                                        </span>
                                                        <div class="flex w-full items-center">
                                                            <div class="w-1/2 text-gray-600 text-xs truncate">
                                                                {{ $oldStudy->study_name }}
                                                            </div>
                                                            @if ($oldStudy->study_id_orthanc)
                                                                <a href="{{ route('viewer.redirect', ['studyId' => $oldStudy->study_id_orthanc]) }}"
                                                                    target="_blank"
                                                                    class="flex bg-gray-200 rounded-sm text-gray-800 text-xs font-medium items-center ml-2 p-1.5 rounded-sm">
                                                                    <img src="{{ asset('images/hradiology.svg') }}"
                                                                        width="14">
                                                                    <span
                                                                        class="pl-1 text-[9px] text-gray-400">DICOM</span>
                                                                </a>
                                                            @endif
                                                            <div x-data="{ open: false }">
                                                                <button @click="open = !open"
                                                                    class="flex bg-gray-200 rounded-sm text-gray-800 text-xs font-medium items-center ml-2 p-1.5 rounded-sm cursor-pointer">
                                                                    <img src="{{ asset('images/noteDoc.svg') }}"
                                                                        width="14">
                                                                    <span class="pl-1 text-[9px] text-gray-400">LECTURA
                                                                    </span>
                                                                </button>
                                                                <div x-show="open"
                                                                    x-transition:enter="transition ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0 transform scale-90"
                                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                                    x-transition:leave="transition ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                                    x-transition:leave-end="opacity-0 transform scale-90"
                                                                    class="absolute top-25 left-0 bg-slate-800 p-4 overflow-y-auto ">
                                                                    @if ($oldStudy->specialistUser)
                                                                        <div @click.outside="open = !open"
                                                                            class="text-center ring-2 shadow-md ring-stone-50 cursor-pointer rounded-full bg-blue-500 w-[25px] h-[25px] text-gray-300 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden"
                                                                            @click="open = !open">X</div>
                                                                        <div class="text-yellow-600">
                                                                            ESPECIALISTA:
                                                                            {{ $oldStudy->specialistUser->name }}
                                                                        </div>
                                                                        <div
                                                                            class="relative max-h-80 overflow-y-auto p-4 rounded">
                                                                            <p class="text-stone-400 pb-8">
                                                                                {{ $oldStudy->reading }}
                                                                            </p>
                                                                        </div>
                                                                        <div
                                                                            class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-slate-900 pointer-events-none z-10">
                                                                        </div>
                                                                    @else
                                                                        <h2 @click.outside="open = !open">NO
                                                                            HAY REGISTRO</h2>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </p>
                                        </div>
                                    </li>

                                    <li x-data="{ openComment: false }" @click="openComment = !openComment"
                                        class="py-3 sm:py-4">
                                        <button type="button"
                                            :class="openComment
                                                ?
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-700 border border-b-1 border-gray-300 bg-blue-100 rounded-t-md cursor-pointer' :
                                                'flex items-center justify-between w-full p-1 font-medium text-gray-500 border border-b-1 border-gray-200 bg-slate-50 rounded-t-md cursor-pointer hover:bg-gray-100'"
                                            class="gap-3">
                                            <span>COMENTARIO:</span>
                                            <span
                                                class="inline-flex text-center items-center px-2 py-1 text-sm text-gray-700">
                                                Tecnólogo: {{ $this->studyFinder->user->name }}
                                            </span>
                                            <svg :class="openComment ? 'rotate-90 text-blue-600' : 'rotate-0 text-gray-500'"
                                                class="w-3 h-3 shrink-0 transition-transform duration-300 ease-in-out origin-center"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"
                                                aria-hidden="true">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1 L5 5 L9 1" />
                                            </svg>
                                        </button>

                                        <p x-show="openComment"
                                            class="text-sm text-gray-500 bg-slate-50 border p-2 dark:text-gray-400">
                                            {{ $this->studyFinder->tech_description }}
                                        </p>
                                    </li>
                                    <li class="py-3">
                                        {{-- inicio del grid DICOM VOICE PLANTILLAS FORM --}}
                                        <div class="grid grid-cols-5 grid-rows-2 gap-1">
                                            @if ($this->studyFinder->study_id_orthanc)
                                                <a href="{{ route('viewer.redirect', ['studyId' => $this->studyFinder->study_id_orthanc]) }}"
                                                    target="_blank"
                                                    class="col-span-1 row-span-2 text-xs font-medium rounded-lg border-1 border-indigo-300 hover:border-gray-100 hover:bg-gray-50 hover:border-1 focus:ring-1 focus:outline-none focus:ring-blue-300">
                                                    <div
                                                        class="flex items-center flex-col pt-3 text-xs text-gray-500 cursor-pointer dark:text-white">
                                                        <img class="w-6 h-6"
                                                            src="{{ asset('images/hradiology.svg') }}">
                                                        <span>DICOM</span>
                                                    </div>
                                                </a>
                                            @endif

                                            <ul class="col-span-4 row-span-2 border rounded-md shadow-md">
                                                <!-- 🔹 Acordeón principal -->
                                                <div class="h-full">
                                                    <button wire:click="toggleParent"
                                                        class="inline-flex items-center justify-around h-full w-full h-full rounded-lg pr-12 transition-colors bg-white text-neutral-700 hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none cursor-pointer">
                                                        <div class="flex flex-col w-90">
                                                            <span class="text-xs font-medium">
                                                                MIS PLANTILLAS
                                                            </span>
                                                            <span
                                                                class="text-xs font-light text-neutral-400">{{ Auth::user()->name }}
                                                            </span>
                                                        </div>
                                                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 10 6">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M9 5 5 1 1 5" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                @if ($openParent)
                                                    <div
                                                        class="absolute z-50 bg-stone-800/70 bottom-0 left-0 w-full h-full text-sm">
                                                        <div class="bg-gray-100 h-full rounded-t-lg mt-24 overflow-auto pb-40">
                                                            <div
                                                                class="w-full flex justify-center mb-4 p-1 bg-gray-800 rounded-t-lg">
                                                                <button wire:click="toggleParent"
                                                                    class="cursor-pointer text-white border-bottom-2">
                                                                    cerrar
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="w-full flex flex-col items-center justify-center ">
                                                                @foreach ($templates as $template)
                                                                    <div wire:key="tmpl-{{ $template->id }}"
                                                                        class="w-9/10 bg-white mb-1 rounded">
                                                                        <button
                                                                            wire:click="toggleChild({{ $template->id }})"
                                                                            class="flex justify-start relative text-left w-full p-2 rounded-t-sm bg-white text-gray-800 focus:bg-blue-50 focus:ring-1 focus:ring-gray-300 hover:bg-gray-100">
                                                                            <span class="flex">
                                                                                <span class="text-lg">
                                                                                    <img class="mr-2"
                                                                                        src="{{ asset('images/plus.svg') }}"
                                                                                        width="18">
                                                                                </span>
                                                                                {{ $template->title }}
                                                                            </span>
                                                                            <svg data-accordion-icon
                                                                                class="w-3 h-3 rotate-180 shrink-0 absolute right-5"
                                                                                aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 10 6">
                                                                                <path stroke="#00ffc2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="1"
                                                                                    d="M9 5 5 1 1 5" />
                                                                            </svg>
                                                                        </button>
                                                                        @if ($openChildId === $template->id)
                                                                            <div x-on:click="$wire.putTemplate(@js($template->content))"
                                                                                class="text-stone-50 bg-slate-500 text-xs p-2 cursor-pointer">
                                                                                <p> {{ preg_replace('/<br\s*\/?>/i', "\n", $template->content) }}
                                                                                </p>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </ul>

                                        </div>
                                        {{-- fin del grid DICOM VOICE PLANTILLAS FORM --}}
                                    </li>
                                </ul>
                            </div>
                    @endif

                    {{-- Inicio formulario --}}
                    <div class="grid grid-cols-5 grid-rows-2 gap-1">
                        <a href="{{ asset('storage/remisiones') }}/{{ $this->estudioId }}.jpg"
                            class="flex justify-center items-center flex-col ml-3 text-xs text-gray-500 rounded-lg cursor-pointer border-1 border-gray-200 hover:bg-gray-100 dark:text-white"
                            target="_blank">
                            <img src="{{ asset('images/referrer.svg') }}">
                            <span>REMISIÓN</span>
                        </a>
                        <div
                            class="col-start-1 row-start-2 rounded-lg flex flex-col justify-center ml-3 text-xs text-gray-500 border-1 border-gray-200">
                            <div class="flex">
                                <button id="startButton" @click="$dispatch('startRecognition')"
                                    class="flex justify-center pt-3 rounded-l-lg cursor-pointer w-46 focus:outline-1 focus:outline-red-500">
                                    <img class="w-7 h-7" src="{{ asset('images/speech.svg') }}">
                                </button>
                                <button id="stopButton" @click="$dispatch('stopRecognition')"
                                    class="flex justify-center pt-3 rounded-r-lg cursor-pointer w-46 focus:outline-1 focus:outline-red-500">
                                    <img class="w-6 h-6" src="{{ asset('images/pause.svg') }}">
                                </button>
                            </div>
                            <span>MICRÓFONO</span>
                        </div>
                        <div class="col-span-4 row-span-2 col-start-2 row-start-1">
                            <div class="mt-1">
                                <form wire:submit.prevent="updatePatientEstudio">
                                    <div>
                                        <textarea rows="4" id="transcript" wire:model="reading"
                                            class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    <button type="submit" wire:target="updatePatientEstudio" wire:loading.remove
                                        class="w-full cursor-pointer px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Enviar Lectura
                                    </button>
                                    <button type="submit" wire:loading wire:target="updatePatientEstudio"
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
                        {{-- <div class="col-span-4 row-span-2 col-start-2 row-start-1">
                                    <div class="mt-1">
                                        <form wire:submit.prevent="updatePatientEstudioTxt">x-bind:value="reading"
                                            <div>
                                                <textarea rows="4" wire:model="readingTxt"
                                                    class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            </div>
                                            <button type="submit"
                                                class="w-full cursor-pointer px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                finalizar
                                            </button>
                                        </form>
                                    </div>
                                </div> --}}
                    </div>
                    {{-- fin formulario --}}
                    {{-- Grabadora de voz --}}
                    <div>
                        <livewire:components.recorder :estudioId="$estudioId" wire:key="$estudioId" />
                    </div>
                    {{-- Fin de grabadora de voz --}}

                </div>
            </div>
        </div>
    </div>
</div>
</div>
