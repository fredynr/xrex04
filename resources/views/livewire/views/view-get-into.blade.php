<div>
    <div class="ml-8 flex flex-col text-xl text-red-900">
        <span class="text-gray-300 text-[8px]">cuidadin cuidadin</span>
        ESTE MODULO ESTÁ EN DESARROLLO
    </div>
    <div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form wire:submit.prevent="generateWorklist" class="max-w-sm mx-auto">
            <div  class="mb-5">
                <label for="patient_name" class="block mb-2 text-sm font-medium text-gray-900" >Nombre del paciente</label>
                <input type="text" wire:model="patient_name" placeholder="Nombre del paciente" id="patient_name" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-5">
                <label for="identification" class="block mb-2 text-sm font-medium text-gray-900" >Número de identificación</label>
                <input type="text" wire:model="patient_id" placeholder="Número de identificación" id="identification" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-5">
                <label for="procedure" class="block mb-2 text-sm font-medium text-gray-900" >Procedimiento</label>
                <input type="text" wire:model="procedure" placeholder="Procedimiento" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-5">
                <label for="schedule_date">Fecha</label>
                <input type="date" wire:model="scheduled_date" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="mb-5">
                <label for="schedule_time">Hora</label>
                <input type="time" wire:model="scheduled_time" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" class="w-full mt-3 cursor-pointer px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg bg-blue-800/20 hover:bg-blue-800 hover:text-stone-50 outline-1 outline-offset-2 ring-blue-300">Generar Worklist</button>
        </form>
    </div>
</div>
