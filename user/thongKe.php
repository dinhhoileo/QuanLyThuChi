<?php
// Dữ liệu mẫu cho thống kê
$monthlyData = [
    'labels' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
    'expenses' => [1200000, 1500000, 1800000, 1300000, 1600000, 2000000, 1700000, 1900000, 1500000, 1400000, 1600000, 1800000]
];

$categoryData = [
    'Ăn uống' => 3500000,
    'Di chuyển' => 1200000,
    'Mua sắm' => 2500000,
    'Hóa đơn' => 1800000,
    'Giải trí' => 900000,
    'Khác' => 600000
];

// Tính toán tổng quan
$totalExpense = array_sum($monthlyData['expenses']);
$avgExpense = $totalExpense / 12;
$maxExpense = max($monthlyData['expenses']);
$maxMonth = $monthlyData['labels'][array_search(max($monthlyData['expenses']), $monthlyData['expenses'])];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê chi tiêu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{color-scheme:light}
        .theme-dark{color-scheme:dark}
        .theme-dark body{background-color:#0f172a;color:#e5e7eb}
        .theme-dark .bg-white{background-color:#111827 !important}
        .theme-dark .text-gray-800{color:#e5e7eb !important}
    </style>
    <script>(function(){try{var t=localStorage.getItem('theme')||'light';if(t==='dark')document.documentElement.classList.add('theme-dark');}catch(e){}})();</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Thống kê chi tiêu</h1>
            <div class="flex gap-4">
                <a href="nganSachTam.php" class="text-blue-500 hover:text-blue-600">← Quay lại</a>
                <a href="trangchu.php" class="text-blue-500 hover:text-blue-600">Trang chủ</a>
            </div>
        </div>

        <!-- Tổng quan -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Tổng chi tiêu</h3>
                <p class="text-2xl font-bold text-blue-600"><?php echo number_format($totalExpense); ?>₫</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Trung bình/tháng</h3>
                <p class="text-2xl font-bold text-green-600"><?php echo number_format($avgExpense); ?>₫</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Chi tiêu cao nhất</h3>
                <p class="text-2xl font-bold text-red-600"><?php echo number_format($maxExpense); ?>₫</p>
                <p class="text-sm text-gray-500">Tháng <?php echo $maxMonth; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Tổng danh mục</h3>
                <p class="text-2xl font-bold text-purple-600"><?php echo count($categoryData); ?></p>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Biểu đồ chi tiêu theo tháng -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Chi tiêu theo tháng</h2>
                <canvas id="monthlyChart"></canvas>
            </div>

            <!-- Biểu đồ phân bổ theo danh mục -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Phân bổ theo danh mục</h2>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Bảng chi tiết -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Chi tiết theo danh mục</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3">Danh mục</th>
                            <th class="text-right p-3">Số tiền</th>
                            <th class="text-right p-3">Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($categoryData as $category => $amount): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3"><?php echo $category; ?></td>
                            <td class="p-3 text-right"><?php echo number_format($amount); ?>₫</td>
                            <td class="p-3 text-right">
                                <?php echo round(($amount / $totalExpense) * 100, 1); ?>%
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Biểu đồ chi tiêu theo tháng
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($monthlyData['labels']); ?>,
                datasets: [{
                    label: 'Chi tiêu',
                    data: <?php echo json_encode($monthlyData['expenses']); ?>,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value.toLocaleString('vi-VN') + '₫'
                        }
                    }
                }
            }
        });

        // Biểu đồ phân bổ theo danh mục
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($categoryData)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($categoryData)); ?>,
                    backgroundColor: [
                        '#3B82F6', '#10B981', '#F59E0B', 
                        '#EF4444', '#8B5CF6', '#6B7280'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
</body>
</html>