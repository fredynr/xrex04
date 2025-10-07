<div {{-- Estado inicial de la alerta --}} x-data="{ mensaje: null, tipo: null, mostrar: false }" {{-- Escucha cualquier evento llamado 'notificacion-guardado' en toda la página --}}
    x-on:notification-success-float.window="
        mensaje = $event.detail.mensaje; 
        tipo = $event.detail.tipo;       
        mostrar = true;
        setTimeout(() => { mostrar = false }, 4000);
    "
    {{-- Opcional: Esto ayuda a que no haya un parpadeo inicial --}} x-cloak>
    {{-- Contenedor de la Alerta --}}
    <div x-show="mostrar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-full"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-full" {{-- Estilos condicionales basados en el 'tipo' (ej. success, error) --}}
        :class="{
            'bg-green-500 text-white': tipo === 'success',
            'bg-red-500 text-white': tipo === 'error'
        }"
        class="fixed bottom-4 right-4 p-4 rounded-lg shadow-xl z-50 min-w-[300px]">
        <span class="font-bold" x-text="mensaje"></span>
    </div>
</div>
