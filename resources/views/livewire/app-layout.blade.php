<div>
    <div class="flex h-screen">
        @livewire('components.sidebar')

        <div class="flex-1">
            @switch($currentView)
                @case('views.view-specialist')
                    @livewire('views.view-specialist')
                @break

                @case('views.view-technologist')
                    @livewire('views.view-technologist')
                @break

                @case('tables.table-estudios-returned')
                    @livewire('tables.table-estudios-returnes')
                @break

                @case('tables.table-template')
                    @livewire('tables.table-template')
                @break

                @case('tables.table-delivery-estudio')
                    @livewire('tables.table-delivery-estudio')
                @break

                @case('views.view-transcriber')
                    @livewire('views.view-transcriber')
                @break

                @case('views.view-approve')
                    @livewire('views.view-approve')
                @break

                @default
                    <div class="p-4 text-gray-500">Vista no encontrada</div>
            @endswitch
        </div>
    </div>

    <!-- Toast Component -->
    {{-- <div 
    x-data="toastComponent()" 
    x-init="init()" 
    x-show="visible" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-3 rounded shadow-lg z-50"
    style="display: none;"
>
    <span x-text="text"></span>
    
</div>

<script>
    function toastComponent() {
        return {
            visible: false,
            text: '',
            init() {
                window.addEventListener('toast', e => {
                    this.text = e.detail.message || 'Notificación';
                    this.visible = true;
                    setTimeout(() => this.visible = false, e.detail.duration || 3000);
                });
            }
        }
    }
</script> --}}
    <div x-data="toastComponent()" x-init="init()" x-show="visible"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-3 rounded shadow-lg z-50 flex items-start gap-4"
        style="display: none;">
        <span x-text="text" class="flex-1"></span>
        <button @click="visible = false"
            class="text-white hover:text-gray-300 font-bold text-lg leading-none">&times;</button>
    </div>

    <script>
        window.addEventListener('toast', e => {
            console.log('Toast recibido:', e.detail);
        });

        function toastComponent() {
            return {
                visible: false,
                text: '',
                timeoutId: null,
                init() {
                    window.addEventListener('toast', e => {
                        this.text = e.detail.message || 'Notificación';
                        this.visible = true;

                        // Clear any previous timeout
                        if (this.timeoutId) clearTimeout(this.timeoutId);

                        // Set new timeout (default to 60s if not provided)
                        this.timeoutId = setTimeout(() => this.visible = false, e.detail.duration || 60000);
                    });
                }
            }
        }
    </script>

</div>
