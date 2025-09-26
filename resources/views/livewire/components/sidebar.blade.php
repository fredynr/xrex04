{{-- <div x-data="{ mover: false, ancho: false, ocultar: false }" class="relative">
    <button @click="mover = !mover; ocultar = !ocultar; ancho = !ancho"
        class="rounded-full bg-cyan-500 absolute top-4 -right-3 cursor-pointer">
        <img src="{{ asset('images/doubleChevron.svg') }}" alt="">
    </button>
    <header class="min-h-34 p-4 flex justify-between items-center gap-x-2 bg-cyan-700 ">
        <a class="flex-none font-semibold text-xl text-white focus:outline-hidden focus:opacity-80 dark:text-white"
            href="#" aria-label="Brand"> <img src="{{ asset('images/xrexLogo.png') }}" width="150">
            <h2 x-show="!ocultar">{{ Auth::user()->name }}</h2>
        </a>
    </header>
    <ul class="nav-left h-full bg-cyan-700 pt-4 transition-all duration-500" :class="ancho ? 'w-16' : 'w-64'">
        <li
            class="flex text-start flex items-center gap-x-3.5 py-2 text-blue-800 px-2.5 text-sm rounded-lg cursor-pointer bg-gray-100 hover:text-blue-800">
            <span><img src="{{ asset('images/notePerson.svg') }}" class="min-w-[26px]"></span>
            <span class="transition-transform duration-500" x-show="!ocultar"
                :class="mover ? '-translate-x-44' : 'translate-x-0'">Item
                INICIO
            </span>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['views.view-specialist'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-blue-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/cardMed.svg') }}" class="min-w-[26px]"></span>
                <span class="transition-transform duration-500" x-show="!ocultar"
                    :class="mover ? '-translate-x-44' : 'translate-x-0'">
                    Módulo, Lectura de Estudios
                </span>
            </button>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['views.view-technologist'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-blue-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/scan.svg') }}" class="min-w-[26px]"></span>
                <span class="transition-transform duration-500" x-show="!ocultar"
                    :class="mover ? '-translate-x-44' : 'translate-x-0'">
                    Módulo, Toma de Estudios
                </span>
            </button>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['tables.table-template'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-stone-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/template.svg') }}" class="min-w-[26px]"></span>
                <span class="text-stone-50 transition-transform duration-500" x-show="!ocultar"
                    :class="mover ? '-translate-x-44' : 'translate-x-0'">
                    Admin. Plantillas
                </span>
            </button>
        </li>
        <li
            class="flex text-start flex items-center gap-x-3.5 py-2 text-stone-50 px-2.5 text-sm rounded-lg cursor-pointer">
            <span><img src="{{ asset('images/notePerson.svg') }}" class="min-w-[26px]"></span>
            <span class="transition-transform duration-500" x-show="!ocultar"
                :class="mover ? '-translate-x-44' : 'translate-x-0'">
                Registro de pacientes
            </span>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['tables.table-delivery-estudio'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-stone-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/handPackage.svg') }}" class="min-w-[26px]"></span>
                <span class="transition-transform duration-500" :class="mover ? '-translate-x-44' : 'translate-x-0'"
                    x-show="!ocultar">
                    Módulo, Entrega de Estudios
                </span>
            </button>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['views.view-transcriber'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-stone-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/keyboard.svg') }}" class="min-w-[26px]"></span>
                <span class="transition-transform duration-500" :class="mover ? '-translate-x-44' : 'translate-x-0'"
                    x-show="!ocultar">
                    Módulo, Transcripciónes
                </span>
            </button>
        </li>
        <li>
            <button wire:click="$dispatch('navigateTo', ['views.view-approve'])"
                class="flex text-start flex items-center gap-x-3.5 py-2 text-stone-50 px-2.5 text-sm rounded-lg cursor-pointer">
                <span><img src="{{ asset('images/hand.svg') }}" class="min-w-[26px]"></span>
                <span class="transition-transform duration-500" :class="mover ? '-translate-x-44' : 'translate-x-0'"
                    x-show="!ocultar">
                    Aprovar transcripciones
                </span>
            </button>
        </li>
    </ul>
</div> --}}
{{-- Módulo, lectura de estudios -- Módulo toma de estudios --- Admin, plantillas, Registro de pacientes  --- Módulo, entrega de estudios  --- Módulo, transcriociones --- Aprovar Transcripción --}}
<div x-data="{ mover: false, ancho: false, ocultar: false }" class="relative">
    <button @click="mover = !mover; ocultar = !ocultar; ancho = !ancho"
        class="rounded-full bg-cyan-500 absolute top-4 -right-3 cursor-pointer">
        <img src="{{ asset('images/doubleChevron.svg') }}" alt="">
    </button>
    <header class="min-h-34 p-4 flex justify-between items-center gap-x-2 bg-cyan-700 ">
        <a class="flex-none font-semibold text-xl text-white focus:outline-hidden focus:opacity-80 dark:text-white"
            href="#" aria-label="Brand"> <img
                :src="mover ? '{{ asset('images/xLogo.png') }}' : '{{ asset('images/xrexLogo.png') }}'"
                :width="mover ? 30 : 150" />
            <h2 x-show="!ocultar">{{ Auth::user()->name }}</h2>
        </a>
    </header>
    <ul class="nav-left h-full bg-cyan-700 pt-4 transition-all duration-500" :class="ancho ? 'w-16' : 'w-64'">
        @foreach ($menuItems as $menuItem)
            <li>
                <button
                    wire:click="$set('itemActivo', '{{ $menuItem['label'] }}'); $dispatch('navigateTo', ['{{ $menuItem['navigate'] }}'])"
                    class="w-full flex text-start items-center my-2 py-1 text-blue-50 px-2.5 text-sm rounded-l-lg cursor-pointer
                {{ $itemActivo === $menuItem['label'] ? 'bg-stone-100 text-cyan-700' : 'text-blue-50 hover:text-cyan-700 hover:bg-sky-100' }}">
                    <span><img src="{{ asset($menuItem['icon']) }}" class="min-w-[26px]"></span>
                    <span class="ml-2 transition-transform duration-500" x-show="!ocultar"
                        :class="mover ? '-translate-x-44' : 'translate-x-0'">
                        {{ $menuItem['label'] }}
                    </span>
                </button>
            </li>
        @endforeach
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex text-start items-center my-2 py-1 text-blue-50 px-2.5 text-sm rounded-l-lg cursor-pointer hover:text-cyan-700 hover:bg-sky-100">
                    Cerrar sesión
                </button>
            </form>
        </li>
    </ul>
</div>
