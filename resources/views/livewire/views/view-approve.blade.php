<div>
    <div class="ml-8 flex flex-col text-xl text-red-900">
        <span class="text-gray-300 text-[8px]">cuidadin cuidadin</span>
        ESTE MODULO ESTÁ EN DESARROLLO
    </div>
    <div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="generateWorklist">
        <input type="text" wire:model="patient_name" placeholder="Nombre del paciente">
        <input type="text" wire:model="patient_id" placeholder="ID del paciente">
        <input type="text" wire:model="procedure" placeholder="Procedimiento">
        <input type="date" wire:model="scheduled_date">
        <input type="time" wire:model="scheduled_time">
        <button type="submit">Generar Worklist</button>
    </form>
</div>
</div>
