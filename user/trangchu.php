<?php
// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU
// Trong một ứng dụng thực tế, dữ liệu này sẽ được lấy từ cơ sở dữ liệu (MySQL)
// và thông tin người dùng sẽ được lấy từ session sau khi đăng nhập.

// --- Dữ liệu người dùng ---
$userName = "Anh";

// --- Dữ liệu tổng quan ---
$currentBalance = 25500000;
$totalIncome = 15000000;
$totalExpense = 8250000;
$savings = $totalIncome - $totalExpense;

// --- Dữ liệu giao dịch gần đây (mảng giả lập) ---
$recentTransactions = [
    [
        'type' => 'expense',
        'description' => 'Ăn trưa bạn bè',
        'date' => 'Hôm nay',
        'amount' => 350000,
        'category_icon' => 'utensils-crossed'
    ],
    [
        'type' => 'income',
        'description' => 'Lương tháng 9',
        'date' => 'Hôm qua',
        'amount' => 15000000,
        'category_icon' => 'briefcase'
    ],
    [
        'type' => 'expense',
        'description' => 'Mua sắm online',
        'date' => '2 ngày trước',
        'amount' => 1200000,
        'category_icon' => 'shopping-cart'
    ],
    [
        'type' => 'expense',
        'description' => 'Tiền thuê nhà',
        'date' => '5 ngày trước',
        'amount' => 4500000,
        'category_icon' => 'home'
    ]
];

// --- Dữ liệu cho biểu đồ (mảng giả lập) ---
$chartLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
$chartIncomeData = [5000000, 4500000, 5500000, 5200000];
$chartExpenseData = [2200000, 2500000, 1800000, 3100000];

// --- Hàm hỗ trợ định dạng tiền tệ ---
function formatCurrency($number) {
    return number_format($number, 0, ',', '.') . 'đ';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Quản Lý Chi Tiêu</title>
    <!-- Tích hợp Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tích hợp Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Tích hợp thư viện icon Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200">
                <i data-lucide="layout-dashboard"></i>
                <span class="mx-3">Bảng điều khiển</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="arrow-left-right"></i>
                <span class="mx-3">Giao dịch</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="pie-chart"></i>
                <span class="mx-3">Báo cáo</span>
    </a>
            <a href="lap_kehoach.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="target"></i>
                <span class="mx-3">Kế hoạch</span>
            </a>
            <a href="nganSachTam.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="wallet"></i>
                <span class="mx-3">Ngân sách tạm</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="settings"></i>
                <span class="mx-3">Cài đặt</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
            <div class="flex items-center">
                <button id="menu-button" class="text-gray-500 focus:outline-none md:hidden">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Chào mừng trở lại, <?php echo htmlspecialchars($userName); ?>!</h2>
            </div>

            <div class="flex items-center">
                <button class="flex items-center text-gray-600 hover:text-indigo-600 mx-4">
                    <i data-lucide="bell"></i>
                </button>
                
                <div class="relative">
                    <button class="relative z-10 block w-10 h-10 overflow-hidden rounded-full shadow focus:outline-none">
                        <img class="object-cover w-full h-full" src="https://placehold.co/100x100/667eea/ffffff?text=<?php echo strtoupper(substr($userName, 0, 1)); ?>" alt="Your avatar">
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <div class="container mx-auto">
                <!-- Summary Cards -->
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <div class="flex items-center p-6 bg-white rounded-lg shadow-md">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <i data-lucide="wallet"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-600">Số dư hiện tại</p>
                            <p class="text-2xl font-bold text-gray-700"><?php echo formatCurrency($currentBalance); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center p-6 bg-white rounded-lg shadow-md">
                        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                            <i data-lucide="arrow-down-circle"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-600">Tổng thu nhập (Tháng này)</p>
                            <p class="text-2xl font-bold text-gray-700"><?php echo formatCurrency($totalIncome); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center p-6 bg-white rounded-lg shadow-md">
                        <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
                           <i data-lucide="arrow-up-circle"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-600">Tổng chi tiêu (Tháng này)</p>
                            <p class="text-2xl font-bold text-gray-700"><?php echo formatCurrency($totalExpense); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center p-6 bg-white rounded-lg shadow-md">
                        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full">
                           <i data-lucide="trending-up"></i>
                        </div>
                        <div>
                            <p class="mb-1 text-sm font-medium text-gray-600">Tiết kiệm được</p>
                            <p class="text-2xl font-bold text-gray-700"><?php echo formatCurrency($savings); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Chart and Recent Transactions -->
                <div class="grid gap-6 lg:grid-cols-5">
                    <!-- Chart -->
                    <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Tổng quan Thu / Chi</h3>
                        <canvas id="overviewChart"></canvas>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Giao dịch gần đây</h3>
                        <div class="space-y-4">
                            <?php foreach ($recentTransactions as $transaction): ?>
                                <?php
                                    $isExpense = $transaction['type'] === 'expense';
                                    $amountClass = $isExpense ? 'text-red-600' : 'text-green-600';
                                    $iconBgClass = $isExpense ? 'bg-red-100' : 'bg-green-100';
                                    $iconTextClass = $isExpense ? 'text-red-500' : 'text-green-500';
                                    $prefix = $isExpense ? '-' : '+';
                                ?>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-2 <?php echo $iconBgClass; ?> rounded-full mr-3">
                                            <i data-lucide="<?php echo htmlspecialchars($transaction['category_icon']); ?>" class="<?php echo $iconTextClass; ?>"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold"><?php echo htmlspecialchars($transaction['description']); ?></p>
                                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($transaction['date']); ?></p>
                                        </div>
                                    </div>
                                    <p class="font-bold <?php echo $amountClass; ?>"><?php echo $prefix . ' ' . formatCurrency($transaction['amount']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Kích hoạt icons
        lucide.createIcons();

        // Dữ liệu biểu đồ từ PHP
        const chartLabels = <?php echo json_encode($chartLabels); ?>;
        const chartIncomeData = <?php echo json_encode($chartIncomeData); ?>;
        const chartExpenseData = <?php echo json_encode($chartExpenseData); ?>;

        // Biểu đồ
        const ctx = document.getElementById('overviewChart').getContext('2d');
        const overviewChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Thu nhập',
                    data: chartIncomeData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Chi tiêu',
                    data: chartExpenseData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                            }
                        }
                    }
                }
            }
        });
        
        // Mobile sidebar toggle
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

    </script>
</body>
</html>
