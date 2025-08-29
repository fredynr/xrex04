let recognition;
let isRecording = false;
let finalTranscript = '';
export default function voiceRecorder() {
    return {
        // --- Propiedades de Estado de Alpine.js ---
        mediaRecorder: null, // Instancia de MediaRecorder
        audioChunks: [],     // Array para almacenar los fragmentos de audio
        currentBlob: null,   // El Blob final del audio grabado
        audioUrl: '',        // URL para reproducir el audio en el elemento <audio>
        state: 'initial',    // Estado de la grabadora: 'initial', 'recording', 'paused', 'stopped'
        currentStream: null, // Para mantener una referencia al stream del micrófono

        init() {
            if (!navigator.mediaDevices || !window.MediaRecorder) {
                alert('Tu navegador no soporta la API de grabación de audio. Por favor, actualiza o usa otro navegador.');
                this.state = 'unsupported'; // Un estado para indicar que no es compatible
            }
        },


        // ... otras propiedades de estado (mediaRecorder, audioChunks, state, etc.) ...

        // AQUÍ ES DONDE DEFINES LA FUNCIÓN 'startRec' como un método del objeto:
        async startRec() { // Usamos 'async' porque contiene await navigator.mediaDevices.getUserMedia
            if (this.state === 'recording' || this.state === 'paused') {
                console.log('Ya grabando o pausado. No se puede iniciar de nuevo.');
                return;
            }
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.mediaRecorder = new MediaRecorder(stream);
                this.audioChunks = []; // Limpiar chunks
                this.audioUrl = ''; // Limpiar URL
                if (this.$refs.audioPlayer) {
                    this.$refs.audioPlayer.removeAttribute('src');
                    this.$refs.audioPlayer.load();
                }

                this.mediaRecorder.ondataavailable = event => this.audioChunks.push(event.data);
                this.mediaRecorder.onstop = () => {
                    this.currentBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                    this.audioUrl = URL.createObjectURL(this.currentBlob);
                    this.state = 'stopped';
                    stream.getTracks().forEach(track => track.stop());
                };
                this.mediaRecorder.onpause = () => {
                    // updateUIForPaused()
                    this.state = 'paused';
                }
                this.mediaRecorder.onresume = () => this.state = 'recording';

                this.mediaRecorder.start();
                this.state = 'recording';
                // updateUIForRecording()
            } catch (err) {
                console.error('Error al acceder al micrófono:', err);
                alert('No se pudo acceder al micrófono.');
                this.state = 'initial';
            }
        },

        togglePauseResume() {
            // 1. Verificamos que haya una instancia de mediaRecorder y que la grabadora esté
            //    en un estado donde se pueda pausar o reanudar (grabando o pausada).
            if (this.mediaRecorder && (this.state === 'recording' || this.state === 'paused')) {
                // 2. Comprobamos el estado actual del mediaRecorder para saber qué acción tomar.
                if (this.mediaRecorder.state === 'recording') {
                    this.mediaRecorder.pause(); // Si está grabando, la pausamos.
                    // El mediaRecorder.onpause se encargará de actualizar this.state a 'paused'.
                    console.log('Grabación pausada.');
                } else if (this.mediaRecorder.state === 'paused') {
                    this.mediaRecorder.resume(); // Si está pausada, la reanudamos.
                    // El mediaRecorder.onresume se encargará de actualizar this.state a 'recording'.
                    console.log('Grabación reanudada.');
                }
            } else {
                console.log('No se puede pausar/reanudar. La grabadora no está activa.');
            }
        },

        stopRecording() {
            // Aseguramos que haya un mediaRecorder activo (grabando o pausado) para poder detenerlo.
            if (this.mediaRecorder && (this.state === 'recording' || this.state === 'paused')) {
                this.mediaRecorder.stop(); // Detiene el MediaRecorder.
                // Importante: El cambio de estado a 'stopped' y la creación del Blob
                // ocurren dentro del manejador de evento 'mediaRecorder.onstop'.
                // Por eso, no cambiamos 'this.state' aquí directamente.
            } else {
                console.log('No se puede detener. No hay una grabación activa o pausada.');
            }
        },
        saveRecording() {
            if (!this.currentBlob) {
                alert('No hay audio para guardar.');
                return;
            }
            const reader = new FileReader();
            reader.onloadend = () => {
                const base64Audio = reader.result;
                // Envía el audio a Livewire
                Livewire.dispatch('guardarAudio', {
                    payload: base64Audio
                });
                this.mediaRecorder = null;
                this.audioChunks = [];
                this.currentBlob = null;
                this.audioUrl = '';
                this.state = 'initial';
                this.currentStream = null;
                this.audioUrl = '';
                alert('🎉 Audio guardado exitosamente');
            };
            reader.readAsDataURL(this.currentBlob); // Convierte el blob a base64
        }

        // ... otras funciones como togglePauseResume(), stopRecording(), playRecording(), saveRecording(), resetRecorder() ...
    }
}

function initializeSpeechRecognition() {
    if ('webkitSpeechRecognition' in window) {
        recognition = new webkitSpeechRecognition();
    } else if ('speechRecognition' in window) {
        recognition = new speechRecognition();
    } else {
        transcriptTextarea.value = 'Tu navegador no soporta la API de Reconocimiento de Voz.';
        startButton.disabled = true;
        stopButton.disabled = true;
        return;
    }
}
initializeSpeechRecognition()

document.addEventListener('startRecognition', () => {
    let transcriptTextarea = document.getElementById('transcript');
    if (recognition) {
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'es-CO';
        recognition.start();

        recognition.onstart = () => {
            isRecording = true;
            const startButton = document.getElementById('startButton');
            const stopButton = document.getElementById('stopButton');
            if (startButton && stopButton) {
                startButton.disabled = true;
                startButton.classList.add('bg-slate-400');
                stopButton.classList.remove('bg-slate-400');
                stopButton.disabled = false;
            }
        };

        recognition.onresult = (event) => {
            let interimTranscript = '';
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                } else {
                    interimTranscript += event.results[i][0].transcript;
                }
            }

            transcriptTextarea.value = finalTranscript
            transcript.dispatchEvent(new Event('input'));
        };

        recognition.onend = () => {
            isRecording = false;
            startButton.disabled = false;
            stopButton.disabled = true;
        }

        stopButton.addEventListener("click", () => {
            recognition.stop();
            startButton.disabled = false;
            startButton.classList.remove('bg-slate-400');
            stopButton.disabled = true;
            stopButton.classList.add("bg-slate-400");
        })

    } else {
        console.log("❌ El reconocimiento de voz no está disponible.");
    }
});

document.addEventListener('resetRecognition', () => {
    recognition.stop();
    isRecording = false;
    finalTranscript = '';
})

document.addEventListener('stopRecognition', () => {
    if (recognition && isRecording) {
        recognition.stop();
        isRecording = false;
    }
})

