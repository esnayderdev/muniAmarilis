<x-app-layout>
    <div class="relative overflow-x-auto sm:rounded-lg p-5 m-4">
        <div class="w-full flex gap-4 mb-8">
            <div class="w-1/3">
                <canvas id="chartBar"></canvas>
            </div>
            <div class="w-1/6">
                <canvas id="cakeBar"></canvas>
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400">
            <thead class="text-xs text-gray-100 uppercase bg-gray-500 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Proyecto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actividad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Entregable
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    @foreach ($project->activities as $activity)
                        @foreach ($activity->deliverables as $deliverable)
                            <tr class="bg-white hover:bg-gray-200">
                                <td class="px-6 py-4">
                                    {{ $project->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $activity->nombre }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $deliverable->nombre }}

                                </td>
                                <td class="px-6 py-4">
                                    {{ $deliverable->estado ? 'Completado' : 'No Completado' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <x-slot name="js">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            var chartBar = document.getElementById('chartBar').getContext('2d');
            var cakeBar = document.getElementById('cakeBar').getContext('2d');
            var chartData = @json($dataBar);
            var cakeData = @json($dataPastel);

            var myChart = new Chart(chartBar, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: chartData.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var pieChart = new Chart(cakeBar, {
            type: 'pie',
            data: {
                labels: cakeData.labels,
                datasets: cakeData.datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed;
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
        </script>
    </x-slot>
</x-app-layout>
