<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-purple-900 text-white">

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Analytics</h1>
            <input type="text" placeholder="Find any meeting moment..." class="bg-gray-700 rounded-lg p-2">
            <div class="flex items-center">
                <span>Sarah Lee</span>
                <img src="https://via.placeholder.com/40" alt="Avatar" class="rounded-full ml-2">
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4 mt-6">
            <!-- General Stats -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h2 class="text-lg font-semibold">General Stats</h2>
                <div class="mt-4">
                    <canvas id="generalStatsChart"></canvas>
                </div>
            </div>

            <!-- Platforms -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h2 class="text-lg font-semibold">Platforms</h2>
                <div class="mt-4">
                    <canvas id="platformsChart"></canvas>
                </div>
            </div>

            <!-- Sentiments -->
            <div class="bg-gray-800 rounded-lg p-4">
                <h2 class="text-lg font-semibold">Sentiments</h2>
                <div class="mt-4">
                    <canvas id="sentimentsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Time Spent -->
        <div class="bg-gray-800 rounded-lg p-4 mt-6">
            <h2 class="text-lg font-semibold">Time Spent in Meetings</h2>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <p>Evan Brightwood - Product Manager</p>
                    <div class="w-full bg-gray-700 rounded-lg">
                        <div class="bg-blue-600 text-xs font-medium text-center p-1 leading-none rounded-lg" style="width: 50%">9h 12m</div>
                    </div>
                </div>
                <div>
                    <p>Lila Cassidy - Senior Software Developer</p>
                    <div class="w-full bg-gray-700 rounded-lg">
                        <div class="bg-blue-600 text-xs font-medium text-center p-1 leading-none rounded-lg" style="width: 40%">5h 42m</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // General Stats Chart
        var ctx1 = document.getElementById('generalStatsChart').getContext('2d');
        var generalStatsChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['4.05', '5.05', '6.05', '7.05', '8.05', '9.05', '10.05'],
                datasets: [{
                    label: 'Meetings',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Platforms Chart
        var ctx2 = document.getElementById('platformsChart').getContext('2d');
        var platformsChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Google Meet', 'Zoom', 'MS Teams'],
                datasets: [{
                    label: 'Platform Usage',
                    data: [40, 30, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Sentiments Chart
        var ctx3 = document.getElementById('sentimentsChart').getContext('2d');
        var sentimentsChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Positive', 'Negative', 'Neutral'],
                datasets: [{
                    label: 'Sentiments',
                    data: [60, 15, 25],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
