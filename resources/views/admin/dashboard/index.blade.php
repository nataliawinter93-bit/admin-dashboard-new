<x-admin-layout title="Analytics">
    <h1 class="text-2xl font-bold mb-6">Analytics</h1>

    <div class="bg-white p-6 rounded shadow">
        <p>Grafik</p>
    </div>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Activity Logs Chart</h2>
        <canvas id="logsChart" height="120"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const dates = @json($dates);
            const counts = @json($counts);

            const ctx = document.getElementById('logsChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Logs per day',
                        data: counts,
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.3)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                }
            });
        </script>
    @endpush

</x-admin-layout>
