<div>
    <div class="h-80 flex relative m-8 p-8 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500">
        <div class="flex justify-center flex-col content-center text-white">
            <span class="text-2xl absolute top-8 left-8">Hola,
                @if (Auth::user()->role === 'Especialista')
                    Dr.
                @endif
                {{ Auth::user()->name }}
            </span>
            <div class="w-80 text-xl">Bienvenido al sistema de gestión de imágenes médicas</div>
            <div class="mt-12">¿Por dónde quieres empezar?</div>

            <ul class="flex flex-wrap absolute bottom-8 font-light z-1">
                @foreach ($menuItems as $menuItem)
                    <li>
                        <button wire:click="$dispatch('navigateTo', ['{{ $menuItem['navigate'] }}'])"
                            class="w-full flex text-start items-center my-2 text-blue-50 px-1 text-sm cursor-pointer">
                            <span class="ml-1 hover:underline">
                                » <span>{{ $menuItem['label'] }}</span>
                            </span>
                        </button>
                    </li>
                @endforeach
            </ul>

        </div>
        <img class="h-80 absolute top-0 right-0" src="{{ asset('images/undraw_medicine_hqqg.svg') }}" alt="">
    </div>
</div>
