<div>
    <div class="h-80 flex relative m-8 p-8 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500">
        <div class="flex justify-center flex-col content-center text-white z-3">
            <span class="text-2xl absolute top-8 left-8 z-2">Hola,
                {{ Auth::user()->name }}
            </span>
            <div class="w-80 text-xl">Bienvenido al sistema resultados de estudios médicos</div>
            <div class="mt-12">Aquí podrás descargar y ver tus estudios y las lecturas realizadas</div>
            <div class="flex w-full absolute bottom-8 font-light">
                Abajo encontrarás tus estudios
            </div>
        </div>
        <img class="h-80 absolute top-0 right-0 z-1 hidden md:block" src="{{ asset('images/undraw_medicine_hqqg.svg') }}">

        <div class="fixed bottom-8 right-8 space-y-5">
            <div class="bg-teal-50 border-t-2 border-1 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30" role="alert"
                tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
                <div class="flex">
                    <div class="shrink-0">
                        <span
                            class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                </path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="ms-3">
                        <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white">
                            Antes de irte no olvides
                        </h3>
                        <p class="text-sm text-gray-700 dark:text-neutral-400">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex text-start items-center text-stone-40 px-2.5 text-sm rounded-l-lg cursor-pointer">
                                <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                        width="24px" fill="#0ccf2a">
                                        <path
                                            d="M224.62-160q-27.62 0-46.12-18.5Q160-197 160-224.62v-510.76q0-27.62 18.5-46.12Q197-800 224.62-800h256.15v40H224.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v510.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69h256.15v40H224.62Zm433.84-178.46-28.08-28.77L723.15-460H367.69v-40h355.46l-92.77-92.77 28.08-28.77L800-480 658.46-338.46Z" />
                                    </svg></span>
                                Cerrar sesión
                            </button>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        @foreach ($estudios as $estudio)
            <div class="flex flex-wrap bg-white shadow-sm m-8 p-4">
                <div class="w-full md:w-1/4 m-1 p-2 rounded-lg border-2 bg-emerald-50">
                    <h2 class="text-stone-600">Estudio realizado:</h2>
                    <p class="text-sm text-stone-500">{{ $estudio->study_name }}</p>
                </div>
                <div class="w-full md:w-1/6 m-1 p-2 rounded-lg border-2 bg-emerald-50">
                    <a href="{{ route('viewer.redirect', ['studyId' => $estudio->study_id_orthanc]) }}" target="_blank"
                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1">
                        <img src="{{ asset('images/radiology.svg') }}">
                        <span class="border-b-2 border-blue-700 text-blue-700">Ver imagen</span>
                    </a>
                </div>
                <div class="w-full md:w-1/6 m-1 p-2 rounded-lg border-2 bg-emerald-50">
                    <a href="{{ route('pdfView', $estudio->id) }}"
                        class="cursor-pointer block border border-transparent hover:border-gray-400 focus:outline-none rounded-lg p-[3px] m-1"
                        target="_blank">
                        <img class="max-w-[20px] min-w-[20px]" src="{{ asset('images/file-pdf.svg') }}"
                            title="descargar PDF">
                        <span class="border-b-2 border-blue-700 text-blue-700">Descargar PDF</span>
                    </a>
                </div>
                <div class="w-full md:w-1/6 m-1 p-2 rounded-lg border-2 bg-emerald-50">
                    <h2 class="text-stone-600">Fecha de toma del estudio</h2>
                    <p class="text-sm text-stone-500">
                        @if ($estudio->date_realized)
                            {{ $estudio->date_realized }}
                        @else
                            00-00-0000
                        @endif
                    </p>
                </div>
                <div class="w-full md:w-1/6 m-1 p-2 rounded-lg border-2 bg-emerald-50">
                    <h2 class="text-stone-600">Especialista</h2>
                    <p class="text-sm text-stone-500">Doctor: {{ $estudio->specialistUser->name }}</p>
                </div>
            </div>
        @endforeach
    </div>

</div>
