<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Design</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-900 text-white custom-scrollbar">

<div class="min-h-screen p-8 flex">
    <!-- Sidebar -->
    <div class="w-1/6 bg-purple-800 rounded-2xl p-4 flex flex-col items-center space-y-4">
        <i class="fas fa-chart-line text-2xl mb-4"></i>
        <i class="fas fa-cog text-xl mb-4"></i>
        <i class="fas fa-users text-xl"></i>
    </div>

    <!-- Main Content -->
    <div class="w-5/6 ml-6 space-y-6">
        <!-- Top bar with filters and user profile -->
        <div class="flex justify-between items-center bg-purple-700 p-4 rounded-2xl shadow-lg">
            <input type="text" class="bg-transparent outline-none text-white w-full" placeholder="Find any meeting moment..." />
            <div class="flex items-center space-x-4 ml-4">
                <button class="bg-purple-600 text-white py-1 px-4 rounded">Filters</button>
                <div class="bg-purple-600 p-2 rounded-full">
                    <img src="https://via.placeholder.com/40" class="rounded-full" alt="User Profile">
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="grid grid-cols-3 gap-4">
            <!-- General stats card -->
            <div class="col-span-1 bg-purple-700 p-6 rounded-2xl shadow-lg">
                <h3 class="text-white text-lg mb-4">General stats</h3>
                <p class="text-white text-4xl">352</p>
                <p class="text-purple-400">Total meetings</p>
            </div>

            <!-- Chart.js Bar Chart -->
            <div class="col-span-2 bg-purple-700 p-6 rounded-2xl shadow-lg">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Time spent in meetings and Talk to listen ratio -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-purple-700 p-6 rounded-2xl shadow-lg">
                <h3 class="text-white text-lg mb-4">Time spent in meetings</h3>
                <p class="text-purple-400">Evan Brightwood - 42h 16m</p>
                <p class="text-purple-400">Lila Cassey - 35h 42m</p>
            </div>
            <div class="bg-purple-700 p-6 rounded-2xl shadow-lg">
                <h3 class="text-white text-lg mb-4">Talk to listen ratio</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart
    var ctx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'],
            datasets: [{
                label: 'Meetings',
                data: [12, 19, 3, 5, 2, 3, 7, 10, 15, 18],
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

    // Pie Chart
    var pieCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Positive', 'Negative', 'Neutral'],
            datasets: [{
                label: 'Sentiments',
                data: [34, 5, 61],
                backgroundColor: ['#4CAF50', '#F44336', '#FFC107'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

</body>
</html>
