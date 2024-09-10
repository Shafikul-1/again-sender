<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom styles for chart placeholders */
        .chart-placeholder {
            width: 100%;
            height: 200px;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Top Navbar -->
    <nav class="bg-black text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <div class="bg-purple-600 w-10 h-10 rounded-full"></div>
            <h1 class="text-xl font-semibold">oplata</h1>
        </div>
        <div class="flex items-center space-x-6">
            <button class="text-gray-400 hover:text-white">Dashboard</button>
            <button class="text-gray-400 hover:text-white">Transactions</button>
            <button class="text-gray-400 hover:text-white">Accounts</button>
            <button class="text-gray-400 hover:text-white">Settings</button>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gray-600 rounded-full"></div>
                <span>Annette Max</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-6">
        <!-- Header Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-4xl font-bold">$120,420.50</h2>
            <p class="text-gray-500">Total balance from all accounts <span class="font-bold">USD</span></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Overview Section -->
            <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Overview</h3>
                    <div class="space-x-4">
                        <button class="py-1 px-3 bg-gray-200 rounded-md hover:bg-gray-300">7 days</button>
                        <button class="py-1 px-3 bg-gray-200 rounded-md hover:bg-gray-300">14 days</button>
                        <button class="py-1 px-3 bg-gray-200 rounded-md hover:bg-gray-300">30 days</button>
                    </div>
                </div>

                <!-- Income and Spending -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-xl font-bold">$9,650.00</h4>
                        <p class="text-gray-500">Income of March 2023</p>
                        <div class="chart-placeholder">Income Chart</div>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold">$7,845.00</h4>
                        <p class="text-gray-500">Spending of March 2023</p>
                        <div class="chart-placeholder">Spending Chart</div>
                    </div>
                </div>

                <!-- Latest Transactions -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold">Latest transactions</h4>
                    <table class="min-w-full mt-4">
                        <thead>
                            <tr>
                                <th class="text-left text-gray-600">Name</th>
                                <th class="text-left text-gray-600">Status</th>
                                <th class="text-left text-gray-600">Source</th>
                                <th class="text-left text-gray-600">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td>Narva Phone</td>
                                <td class="text-yellow-600">In progress</td>
                                <td>Apple Store</td>
                                <td>$6,182.00</td>
                            </tr>
                            <tr class="border-b">
                                <td>Jacob Jones</td>
                                <td class="text-yellow-600">In progress</td>
                                <td>Apple Store</td>
                                <td>$9,824.60</td>
                            </tr>
                            <tr class="border-b">
                                <td>Kathryn Murphy</td>
                                <td class="text-yellow-600">In progress</td>
                                <td>Amazon</td>
                                <td>$12,640.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Your Assets Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Your Assets</h3>
                <div class="chart-placeholder">Asset Analysis Chart</div>

                <!-- Accounts -->
                <h4 class="text-lg font-semibold mt-6">Accounts</h4>
                <ul class="space-y-2 mt-4">
                    <li class="flex justify-between">
                        <span>Visa debit card</span>
                        <span>$82,200.00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Mastercard</span>
                        <span>$64,120.50</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Paypal</span>
                        <span>$9,230.50</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
