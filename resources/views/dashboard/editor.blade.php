<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        // Toggle dark mode
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }

        window.onload = function() {
            var ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: [12000, 15000, 14000, 17000, 22000, 30000, 25000, 23000, 19000, 24000, 20000, 27000],
                        backgroundColor: '#4F46E5',
                        borderColor: '#4F46E5',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">

    <!-- Sidebar -->
    <div class="flex">
        <aside class="w-64 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center mb-4">
                <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-full mr-2">
                <div>
                    <p class="font-bold">John Smith</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">CEO, Oxish</p>
                </div>
            </div>
            <nav class="space-y-4">
                <a href="#" class="block p-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 rounded-lg">Dashboard</a>
                <a href="#" class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">Projects</a>
                <a href="#" class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">Transaction</a>
                <a href="#" class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">My Team</a>
                <a href="#" class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">Reports</a>
                <a href="#" class="block p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg">Settings</a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <button onclick="toggleDarkMode()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Toggle Dark Mode</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                    <p class="text-gray-500 dark:text-gray-400">Total Projects</p>
                    <h2 class="text-3xl font-bold">10,724</h2>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                    <p class="text-gray-500 dark:text-gray-400">Completed Projects</p>
                    <h2 class="text-3xl font-bold">9,801</h2>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                    <p class="text-gray-500 dark:text-gray-400">Running Projects</p>
                    <h2 class="text-3xl font-bold">923</h2>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Revenue Chart</h2>
                <canvas id="revenueChart" height="100"></canvas>
            </div>

            <!-- Transaction List -->
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Transactions</h2>
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-2">Name</th>
                            <th class="pb-2">Status</th>
                            <th class="pb-2">Date</th>
                            <th class="pb-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2">Robert Carter</td>
                            <td class="py-2 text-yellow-500">Pending</td>
                            <td class="py-2">June 14, 2023</td>
                            <td class="py-2 text-green-500">$24,387.71</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2">Daniel Foster</td>
                            <td class="py-2 text-green-500">Completed</td>
                            <td class="py-2">June 12, 2023</td>
                            <td class="py-2 text-green-500">$8,646.20</td>
                        </tr>
                        <tr class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2">Angela Baker</td>
                            <td class="py-2 text-red-500">Failed</td>
                            <td class="py-2">June 10, 2023</td>
                            <td class="py-2 text-red-500">$1,234.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
