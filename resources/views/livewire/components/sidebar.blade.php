<div>
    <header class="min-h-34 p-2 flex justify-center items-center">
        <div class="font-semibold text-md text-gray-500 bg-gray-200"
            :class="mover ? 'p-2 rounded-sm' : 'p-4 rounded-xl'">
            <img :src="mover ? '' : '{{ asset('images/xrexLogo.png') }}'" :width="mover ? 25 : 150" />
            <h2 x-show="!mover">{{ Auth::user()->name }}</h2>
            <h2 x-show="mover">
                {{ collect(explode(' ', Auth::user()->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->join(' ') }}
            </h2>
        </div>
    </header>
    <ul class="nav-left h-full pt-4 transition-all duration-1000" :class="mover ? 'w-full' : 'w-64'">
        @foreach ($menuItems as $menuItem)
            <li>
                <button
                    wire:click="$set('itemActivo', '{{ $menuItem['label'] }}'); $dispatch('navigateTo', ['{{ $menuItem['navigate'] }}'])"
                    class="w-full flex text-start items-center my-2 py-1 text-blue-50 px-2.5 text-sm rounded-l-lg cursor-pointer
                {{ $itemActivo === $menuItem['label'] ? 'bg-stone-100 text-cyan-700' : 'text-blue-50 hover:text-cyan-700 hover:bg-sky-200' }}">
                    <span class="min-w-[26px]">{!! $menuItem['icon'] !!}</span>
                    <template x-if="!mover">
                        <span x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 400)"
                            class="ml-2 transition-opacity duration-900" :class="visible ? 'opacity-100' : 'opacity-0'">
                            <span>{{ $menuItem['label'] }}</span>
                        </span>
                    </template>
                </button>
            </li>
        @endforeach
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex text-start items-center my-2 py-1 text-blue-50 px-2.5 text-sm rounded-l-lg cursor-pointer hover:text-white hover:bg-cyan-600">
                    <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#0ccf2a">
                            <path
                                d="M224.62-160q-27.62 0-46.12-18.5Q160-197 160-224.62v-510.76q0-27.62 18.5-46.12Q197-800 224.62-800h256.15v40H224.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v510.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h256.15v40H224.62Zm433.84-178.46-28.08-28.77L723.15-460H367.69v-40h355.46l-92.77-92.77 28.08-28.77L800-480 658.46-338.46Z" />
                        </svg></span>
                    <template x-if="!mover">
                        <span x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 400)"
                            class="ml-2 transition-opacity duration-900" :class="visible ? 'opacity-100' : 'opacity-0'">
                            Cerrar sesión
                        </span>
                    </template>
                </button>
            </form>
        </li>
    </ul>
</div>
