<?php
// BƯỚC 1: Lấy tên trang hiện tại để xử lý active state
$current_page = basename($_SERVER['PHP_SELF']);

// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU
// Trong ứng dụng thực tế, dữ liệu này sẽ được lấy từ cơ sở dữ liệu (MySQL).

// --- Dữ liệu người dùng ---
$userName = "Anh";

// --- Dữ liệu thẻ tổng quan (Tháng 9, 2025) ---
$totalIncome = 17000000;
$totalExpense = 6120000;
$currentBalance = 25500000;

// --- Dữ liệu giao dịch gần đây ---
$recentTransactions = [
    [ 'type' => 'expense', 'description' => 'Ăn tối nhà hàng', 'category_icon' => 'utensils-crossed', 'amount' => 550000 ],
    [ 'type' => 'expense', 'description' => 'Đổ xăng xe máy', 'category_icon' => 'fuel', 'amount' => 70000 ],
    [ 'type' => 'income', 'description' => 'Thưởng dự án', 'category_icon' => 'award', 'amount' => 2000000 ],
    [ 'type' => 'expense', 'description' => 'Mua sắm online', 'category_icon' => 'shopping-cart', 'amount' => 1200000 ],
];

// --- Dữ liệu cho biểu đồ cột (6 tháng gần nhất) ---
$barChartData = [
    'labels' => ['T4', 'T5', 'T6', 'T7', 'T8', 'T9'],
    'income' => [15000000, 15500000, 16000000, 15000000, 18000000, 17000000],
    'expense' => [7800000, 8100000, 9200000, 7500000, 8900000, 6120000],
];

// --- Dữ liệu cho biểu đồ tròn (Chi tiêu tháng 9) ---
$pieChartData = [
    'labels' => ['Ăn uống', 'Di chuyển', 'Nhà ở', 'Mua sắm', 'Giải trí', 'Khác'],
    'values' => [2500000, 800000, 1500000, 1200000, 420000, 700000],
];

// --- Dữ liệu cảnh báo kế hoạch ---
$budgetAlerts = [
    [ 'category' => 'Mua sắm', 'spent' => 1200000, 'budget' => 1000000, 'icon' => 'shirt' ],
    [ 'category' => 'Giải trí', 'spent' => 420000, 'budget' => 500000, 'icon' => 'film' ]
];

// Hàm hỗ trợ định dạng tiền tệ
function formatCurrency($number) {
    return number_format($number, 0, ',', '.') . 'đ';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Dịch - Quản Lý Chi Tiêu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; } .sidebar { transition: transform 0.3s ease-in-out; } </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1>
        </div>
        <nav class="mt-6">
            <a href="tongquan.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 <?php echo ($current_page == 'tongquan.php') ? 'bg-gray-200' : ''; ?>">
                <i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span>
            </a>
            <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 hover:bg-gray-200 <?php echo in_array($current_page, ['giaodich.php', 'quanly_giaodich.php', 'quanly_danhmuc.php', 'lap_kehoach.php']) ? 'bg-gray-200' : ''; ?>">
                <i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="target"></i><span class="mx-3">Kế hoạch</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200">
                <i data-lucide="settings"></i><span class="mx-3">Cài đặt</span>
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
            <div class="flex items-center">
                <button id="menu-button" class="text-gray-500 focus:outline-none md:hidden">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Giao Dịch</h2>
            </div>
            <div class="flex items-center">
                 <button class="flex items-center justify-center bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    <i data-lucide="plus" class="mr-2 h-5 w-5"></i>Thêm Giao Dịch
                </button>
                <div class="relative ml-6">
                    <button class="relative z-10 block w-10 h-10 overflow-hidden rounded-full shadow focus:outline-none">
                        <img class="object-cover w-full h-full" src="https://placehold.co/100x100/667eea/ffffff?text=<?php echo strtoupper(substr($userName, 0, 1)); ?>" alt="Your avatar">
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <div class="container mx-auto">
                <div class="mb-6 bg-white rounded-lg shadow-md p-2">
                    <nav class="flex space-x-2" aria-label="Tabs">
                        <?php 
                            $active_class = "bg-indigo-600 text-white";
                            $inactive_class = "text-gray-600 hover:bg-indigo-100 hover:text-indigo-700";
                            $base_class = "flex-1 text-center font-semibold whitespace-nowrap py-3 px-4 rounded-md text-base transition-colors duration-200";
                        ?>
                        <a href="giaodich.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'giaodich.php') ? $active_class : $inactive_class; ?>" 
                           <?php echo ($current_page == 'giaodich.php') ? 'aria-current="page"' : ''; ?>>
                            Tổng quan
                        </a>
                        <a href="quanly_giaodich.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_giaodich.php') ? $active_class : $inactive_class; ?>">
                            Quản lý Giao dịch
                        </a>
                        <a href="quanly_danhmuc.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_danhmuc.php') ? $active_class : $inactive_class; ?>">
                            Danh mục Chi tiêu
                        </a>
                        <a href="lap_kehoach.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'lap_kehoach.php') ? $active_class : $inactive_class; ?>">
                            Lập kế hoạch
                        </a>
                    </nav>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-green-50 p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-green-200 p-3 rounded-full">
                            <i data-lucide="arrow-down-left" class="h-6 w-6 text-green-700"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Tổng thu tháng này</p>
                            <p class="text-2xl font-bold text-gray-800"><?php echo formatCurrency($totalIncome); ?></p>
                        </div>
                    </div>
                    <div class="bg-red-50 p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-red-200 p-3 rounded-full">
                            <i data-lucide="arrow-up-right" class="h-6 w-6 text-red-700"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Tổng chi tháng này</p>
                            <p class="text-2xl font-bold text-gray-800"><?php echo formatCurrency($totalExpense); ?></p>
                        </div>
                    </div>
                    <div class="bg-indigo-50 p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-indigo-200 p-3 rounded-full">
                            <i data-lucide="wallet" class="h-6 w-6 text-indigo-700"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Số dư hiện tại</p>
                            <p class="text-2xl font-bold text-gray-800"><?php echo formatCurrency($currentBalance); ?></p>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
                    <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Thu nhập và Chi tiêu (6 tháng)</h3>
                        <div class="relative h-80"><canvas id="barChart"></canvas></div>
                    </div>
                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Cơ cấu chi tiêu tháng này</h3>
                        <div class="relative h-80"><canvas id="pieChart"></canvas></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Giao dịch gần nhất</h3>
                        <ul class="space-y-4">
                             <?php foreach ($recentTransactions as $tx): ?>
                                 <li class="flex items-center justify-between">
                                     <div class="flex items-center">
                                         <div class="bg-gray-100 p-2 rounded-full mr-4"><i data-lucide="<?php echo $tx['category_icon']; ?>" class="h-5 w-5 text-gray-600"></i></div>
                                         <div><p class="font-medium text-gray-800"><?php echo htmlspecialchars($tx['description']); ?></p></div>
                                     </div>
                                     <p class="font-bold <?php echo $tx['type'] === 'expense' ? 'text-red-600' : 'text-green-600'; ?>">
                                         <?php echo ($tx['type'] === 'expense' ? '-' : '+') . formatCurrency($tx['amount']); ?>
                                     </p>
                                 </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Theo dõi kế hoạch</h3>
                        <ul class="space-y-4">
                            <?php foreach ($budgetAlerts as $alert): ?>
                                <?php
                                    $spent = $alert['spent']; $budget = $alert['budget'];
                                    $percentage = ($budget > 0) ? round(($spent / $budget) * 100) : 0;
                                    $isOverBudget = $spent > $budget;
                                    $progressBarColor = $isOverBudget ? 'bg-red-500' : ($percentage > 80 ? 'bg-yellow-500' : 'bg-green-500');
                                ?>
                                <li>
                                    <div class="flex items-center justify-between mb-1">
                                         <div class="flex items-center text-sm font-medium text-gray-600">
                                            <i data-lucide="<?php echo $alert['icon']; ?>" class="h-4 w-4 mr-2"></i>
                                            <span><?php echo htmlspecialchars($alert['category']); ?></span>
                                        </div>
                                        <span class="text-sm font-semibold <?php echo $isOverBudget ? 'text-red-600' : 'text-gray-600'; ?>">
                                            <?php echo formatCurrency($spent) . ' / ' . formatCurrency($budget); ?>
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="<?php echo $progressBarColor; ?> h-2.5 rounded-full" style="width: <?php echo min($percentage, 100); ?>%"></div>
                                    </div>
                                    <?php if ($isOverBudget): ?>
                                        <p class="text-xs text-red-600 mt-1 text-right">Đã vượt ngân sách <?php echo formatCurrency($spent - $budget); ?>!</p>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        const barChartData = <?php echo json_encode($barChartData); ?>;
        const pieChartData = <?php echo json_encode($pieChartData); ?>;
        
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: barChartData.labels,
                datasets: [{
                    label: 'Thu nhập', data: barChartData.income,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)', borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1, borderRadius: 5,
                }, {
                    label: 'Chi tiêu', data: barChartData.expense,
                    backgroundColor: 'rgba(239, 68, 68, 0.7)', borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1, borderRadius: 5,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { callback: value => new Intl.NumberFormat('vi-VN').format(value) } } },
                plugins: { legend: { position: 'top' } }
            }
        });

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieChartData.labels,
                datasets: [{
                    label: 'Chi tiêu', data: pieChartData.values,
                    backgroundColor: [ 'rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)' ],
                    borderColor: '#fff', borderWidth: 2
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { padding: 15 } } } }
        });
        
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');
        menuButton.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });
    </script>
</body>
</html>