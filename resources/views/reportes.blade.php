@extends('layouts.layout-reportes')
<div class="p-8">
    <div class="w-full flex flex-wrap justify-center gap-8">
        <div class="text-white relative w-2/10 p-4 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500">
            <h2 class="font-bold text-2xl">Bienvenido, {{ \Illuminate\Support\Str::before(Auth::user()->name, ' ') }}</h2>
            <p>Aquí podrás ver estadísticas y generar reportes</p>
            <img src="{{ asset('images/cartoon.svg') }}" class="absolute bottom-0 right-0">
        </div>
        <div class="w-5/10 p-4 bg-white rounded shadow">
            <p>
                Total de Estudios Transcritos en este mes: <strong>{{ $data['total_estudios'] }}</strong>
            </p>
            <canvas id="estudiosTranscritos"></canvas>
        </div>
        <div class="w-2/10 px-4 bg-white rounded shadow">
            <p>
                Total de Estudios por EPS en este mes: <strong>{{ $dataEps['total_estudios'] }}
            </p>
            <canvas id="estudiosEps"></canvas>
        </div>
    </div>

    <div>
        <div class="my-8 w-full flex flex-wrap justify-center gap-8">
            <div class="basis-[calc(50%-1rem)] p-8 bg-white rounded shadow">
                <h2 class="text-sm text-stone-400 font-medium">ESTUDIOS LEIDOS Y APROBADOS DURANTE ESTE MES</h2>
                <div class="mb-4 text-sm text-stone-400 font-light">Se muestran los estudios, que han sido leidos y
                    aprobados por cada especialista </div>
                @foreach ($estudiosXspecialist as $especialista)
                    <div class="my-4 flex justify-between">
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center mr-2">
                                <img src="{{ asset('images/doc.svg') }}" class=" rounded-full p-1 bg-green-200/80">
                            </span>
                            <div>
                                <div class="text-stone-500 font-medium">{{ $especialista->name }}</div>
                                <div class="text-stone-400 text-sm font-medium">Doctor</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="mr-4 text-xs font-light text-stone-800">
                                <div>Estudios leidos y</div>
                                <div>aprobados</div>
                            </div>
                            <span
                                class="bg-green-500/10 p-2 rounded-md text-stone-500 text-md">{{ $especialista->cantidad_estudios }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="basis-[calc(50%-1rem)] p-8 bg-white rounded shadow">
                <h2 class="text-sm text-stone-400 font-medium">ESTUDIOS DIGITADOS DURANTE ESTE MES</h2>
                <div class="mb-4 text-sm text-stone-400 font-light">Se muestran los estudios, que han sido digitados
                    por cada transcriptor </div>
                @foreach ($estudiosXtranscriptor as $especialista)
                    <div class="my-4 flex justify-between">
                        <div class="flex items-center">
                            <span class="w-10 h-10 flex items-center mr-2">
                                <img src="{{ asset('images/keyboardInput.svg') }}"
                                    class=" rounded-full p-1 bg-green-200/80">
                            </span>
                            <div>
                                <div class="text-stone-500 font-medium">{{ $especialista->name }}</div>
                                <div class="text-stone-400 text-sm font-medium">Transcriptor</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="mr-4 text-xs font-light text-stone-800">
                                <div>Estudios</div>
                                <div>Digitados</div>
                            </div>
                            <span
                                class="bg-green-500/10 p-2 rounded-md text-stone-500 text-md">{{ $especialista->cantidad_estudios }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const etiquetas = @json($data['labels']);
            const datosTrancripciones = @json($data['valores']);
            const etiquetasEps = @json($dataEps['labels']);
            const datosEps = @json($dataEps['valores']);
            const coloresBarras = [
                'rgba(255, 99, 132, 0.6)', // Color para la Barra 1 (Rojo)
                'rgba(54, 162, 235, 0.6)', // Color para la Barra 2 (Azul)
                'rgba(255, 206, 86, 0.6)', // Color para la Barra 3 (Amarillo)
                'rgba(75, 192, 192, 0.6)', // Color para la Barra 4 (Verde)
                'rgba(153, 102, 255, 0.6)', // Color para la Barra 5 (Morado)
                'rgba(255, 159, 64, 0.6)', // Color para la Barra 6 (Naranja)
                'rgba(52, 235, 213, 0.6)', // Color para la Barra 7 (azul cielo)
                'rgba(235, 52, 208, 0.6)', // Color para la Barra 8 (vilota)
                'rgba(125, 235, 52, 0.6)', // Color para la Barra 9 (verde oliva)
                'rgba(245, 245, 0, 0.6)', // Color para la Barra 10 (amarillo chillón)
                'rgba(0, 245, 180, 0, 0.6)', // Color para la Barra 10 (verde raro)
                'rgba(0, 155, 245, 0, 0.6)', // Color para la Barra 11 (azul clarito)
                'rgba(245, 102, 0, 0, 0.6)', // Color para la Barra 11 (naranja ladrillo)
                // ... ¡Añade más colores si tu mes tiene más de 6 días con registros!
            ];
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('estudiosTranscritos');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: etiquetas,
                        datasets: [{
                            label: 'Estudios por día',
                            data: datosTrancripciones,
                            backgroundColor: coloresBarras,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    generateLabels: function(chart) {
                                        const dataset = chart.data.datasets[0];
                                        return [{
                                            text: dataset.label,
                                            fillStyle: 'rgb(4, 181, 159)',
                                            strokeStyle: 'rgb(4, 181, 159)',
                                            lineWidth: 1
                                        }];
                                    }
                                }
                            }
                        }
                    }
                });

                const ctxEps = document.getElementById('estudiosEps');
                new Chart(ctxEps, {
                    type: 'pie',
                    data: {
                        labels: etiquetasEps,
                        datasets: [{
                            label: 'Estudios por EPS',
                            data: datosEps,
                        }]
                    }
                })
            });
        </script>
    @endpush
</div>
