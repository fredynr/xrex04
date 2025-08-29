{{-- voiceRecorder() está dentro del archivo voiveRecorder.js --}}
<div x-data="voiceRecorder()">
    <div class="flex justify-center w-100 mt-4">
        <button @click="togglePauseResume()" :disabled="state !== 'recording' && state !== 'paused'"
            :class="{
                'cursor-not-allowed opacity-50': state === 'initial' || state === 'stopped',
                'cursor-pointer': state === 'recording' || state === 'paused'
            }"
            x-text="state === 'paused' ? 'Reanudar Grabación' : 'Pausar Grabación'" id="btn-pause"
            class="flex flex-col items-center border-l border-y border-green-600 rounded-tl-xl rounded-bl-xl text-xs text-sky-800 px-2.5 py-0.5 transition-all duration-200">
            <img src="{{ asset('images/pause.svg') }}" alt="">
            {{-- <span class="text-[9px]">Pausar grabación</span> --}}
        </button>
        <button @click="startRec()" :disabled="state !== 'initial' && state !== 'stopped'"
            :class="{
                'cursor-not-allowed opacity-50': state === 'recording' || state === 'paused',
                'cursor-pointer': state === 'initial' || state === 'stopped'
            }"
            id="btn-start"
            class="flex flex-col items-center bg-green-200/10 border border-green-600 text-green-800 px-2.5 py-0.5 transition-all duration-200">
            <img src="{{ asset('images/mic.svg') }}">
            {{-- <span class="text-[9px]">Iniciar grabación</span> --}}
        </button>
        <button @click="stopRecording()"
            :class="{
                'cursor-not-allowed opacity-50': state === 'initial' || state === 'stopped' || state === 'paused',
                'cursor-pointer': state === 'recording'
            }"
            x-text="state === 'initial' ? 'No Iniciada' : (state === 'recording' ? 'Detener Grabación' : 'Grabación Detenida')"
            id="btn-stop"
            class="flex flex-col bg-green-200/10 border-r border-y border-green-600 text-xs items-center px-2.5 py-0.5 text-red-400">
            <span class="text-lg">&#8718;</span>
        </button>
        <button @click="saveRecording()"
            :class="{
                'cursor-not-allowed opacity-50': state === 'initial' || state === 'recording' || state === 'paused',
                'cursor-pointer': state === 'stopped'
            }"
            class="bg-green-600 text-xs text-white px-2.5 py-0.5 rounded-tr-xl rounded-br-xl hover:bg-green-700">
            Enviar Audio
        </button>
        {{-- <span class="text-[9px]">Detener grabación</span> --}}
    </div>
    <div class="playback">
        <audio id="audioPlayback" controls x-ref="audioPlayer" :src="audioUrl">
        </audio>
    </div>

</div>
</div>
