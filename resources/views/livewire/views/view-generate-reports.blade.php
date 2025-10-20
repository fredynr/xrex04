<div class="m-4">
    <div class="w-[500px] flex flex-wrap bg-stone-50 rounded-sm shadow-md px-4 py-2">
        <div class="flex flex-col justify-around px-8 w-full">
            <div class="mb-2 text-gray-500">Módulo para generar reportes:</div>
            <div class="flex justify-between w-full flex-wrap">
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentComponent === 'tables.table-reports-transcribers',
                ])>
                    <button wire:click="showComponent('tables.table-reports-transcribers')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#00000">
                                    <path
                                        d="M184.62-240q-27.62 0-46.12-18.5Q120-277 120-304.62v-350.76q0-27.62 18.5-46.12Q157-720 184.62-720h590.76q27.62 0 46.12 18.5Q840-683 840-655.38v350.76q0 27.62-18.5 46.12Q803-240 775.38-240H184.62Zm0-40h590.76q9.24 0 16.93-7.69 7.69-7.69 7.69-16.93v-350.76q0-9.24-7.69-16.93-7.69-7.69-16.93-7.69H184.62q-9.24 0-16.93 7.69-7.69 7.69-7.69 16.93v350.76q0 9.24 7.69 16.93 7.69 7.69 16.93 7.69Zm144.61-49.23h301.54v-61.54H329.23v61.54Zm-120-120h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm-480-120h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54Zm120 0h61.54v-61.54h-61.54v61.54ZM160-280v-400 400Z" />
                                </svg>
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">TRANSCRIPTORES:</span>
                        </span>
                        <span wire:loading wire:loading.flex wire:target="showComponent"
                            class="fixed items-center justify-center top-0 left-0 w-full h-full z-[1000] bg-gray-400/50 backdrop-filter backdrop-blur-[1px] bg-opacity-5">
                            <img src="{{ asset('images/infinite-spinner.svg') }}" width="100">
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentComponent === 'tables.table-reports-specialists',
                ])>
                    <button wire:click="showComponent('tables.table-reports-specialists')"
                        class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#007595">
                                    <path
                                        d="M680-334.62q-38.46 0-65.38-26.92-26.93-26.92-26.93-65.38 0-38.46 26.93-65.39 26.92-26.92 65.38-26.92 38.46 0 65.38 26.92 26.93 26.93 26.93 65.39t-26.93 65.38q-26.92 26.92-65.38 26.92Zm0-40q21.62 0 36.96-15.34 15.35-15.35 15.35-36.96 0-21.62-15.35-36.96-15.34-15.35-36.96-15.35t-36.96 15.35q-15.35 15.34-15.35 36.96 0 21.61 15.35 36.96 15.34 15.34 36.96 15.34ZM467.69-98.46v-88.31q0-13.74 6.56-25.85 6.56-12.1 18.37-19.3 27.78-16.66 58.59-27.63 30.82-10.96 62.94-16.22L680-190l65.08-85.77q32.49 5.26 63.23 16.22 30.74 10.97 58.84 27.63 11.85 7.15 18.12 19.11 6.27 11.96 7.04 25.27v89.08H467.69Zm39-40h162.23l-70.15-92.16q-24.39 5.74-47.43 14.91-23.03 9.17-44.65 21.25v56Zm184.39 0h161.23v-56q-21.39-12.31-44.42-20.96-23.04-8.66-47.43-14.43l-69.38 91.39Zm-22.16 0Zm22.16 0ZM224.98-160q-27.21 0-46.1-18.98Q160-197.96 160-224.62v-510.76q0-26.66 18.98-45.64T224.62-800h510.76q26.66 0 45.64 18.98T800-735.38v147.69q-9.08-8.46-18.46-15.31-9.39-6.85-21.54-10.54v-121.84q0-10.77-6.92-17.7-6.93-6.92-17.7-6.92H224.62q-10.77 0-17.7 6.92-6.92 6.93-6.92 17.7v510.76q0 10.77 6.92 17.7 6.93 6.92 17.7 6.92h133.69q-.69 3.31-1.04 6.62-.35 3.3-.35 6.61V-160H224.98ZM300-610.77h296.92q14.46-8.46 30.46-12.31 16-3.84 32.62-5.38v-22.31H300v40ZM300-460h180.77q1.54-11 4.11-20.62 2.58-9.61 5.97-19.38H300v40Zm0 150.77h111.85q10.23-8.23 21.19-15.62 10.96-7.38 22.42-12.61v-11.77H300v40ZM200-200v-560 146.23V-630v430Zm480-226.92Z" />
                                </svg>
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">ESPECIALISTAS:</span>
                        </span>
                    </button>
                </div>
                <div @class([
                    'flex flex-col p-2',
                    'bg-violet-50 rounded-lg border border-gray-300' =>
                        $currentComponent === 'tables.table-reports-eps',
                ])>
                    <button wire:click="showComponent('tables.table-reports-eps')" class="flex flex-col cursor-pointer">
                        <div class="flex justify-center">
                            <span class="w-10 h-10 rounded-full bg-green-100 flex justify-center p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#04bf1a">
                                    <path
                                        d="M109.23-153.85v-680h360v160h381.54v520H109.23Zm40-40h280v-120h-280v120Zm0-160h280v-120h-280v120Zm0-160h280v-120h-280v120Zm0-160h280v-120h-280v120Zm320 480h341.54v-440H469.23v440Zm95.39-280v-40H700v40H564.62Zm0 160v-40H700v40H564.62Z" />
                                </svg>
                            </span>
                        </div>
                        <span class="text-sm">
                            <span class="text-[9px] text-gray-500 font-medium">EPS:</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-stone-50 mt-4">
        @switch($currentComponent)
            @case('tables.table-reports-transcribers')
                <livewire:tables.table-reports-transcribers />
            @break

            @case('tables.table-reports-specialists')
                <livewire:tables.table-reports-specialists />
            @break

            @case('tables.table-reports-eps')
                <livewire:tables.table-reports-eps />
            @break

            @default
                <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-gray-500 text-lg mb-2">
                        ⬆️ Selecciona alguna opción para generar reportes ⬆️
                    </div>
                </div>
        @endswitch

    </div>

</div>
