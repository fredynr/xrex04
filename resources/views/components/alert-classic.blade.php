<div x-data="{ mensaje: null, tipo: null, mostrar: false }"
    x-on:notification-classic.window="
        mensaje = $event.detail.mensaje; 
        tipo = $event.detail.tipo;       
        mostrar = true;
        setTimeout(() => { mostrar = false }, 6000);
    "
    x-cloak>
    <div x-show="mostrar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-full"
        x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-full" 
        :class="{
            'bg-green-100 border border-green-400 text-green-700': tipo === 'success',
            'bg-red-500 text-white': tipo === 'error'
        }"
        class="fixed top-4 right-16 px-4 py-3 rounded">
        <span class="font-normal" x-html="mensaje"></span>
    </div>
</div>
