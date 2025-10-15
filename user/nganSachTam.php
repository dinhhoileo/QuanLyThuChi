<?php
// Dữ liệu mẫu cho danh mục chi tiêu
$categories = [
    'food' => 'Ăn uống',
    'transport' => 'Di chuyển',
    'shopping' => 'Mua sắm',
    'bills' => 'Hóa đơn',
    'entertainment' => 'Giải trí',
    'other' => 'Khác'
];

// Dữ liệu mẫu cho các khoản chi
$expenses = [
    [
        'id' => 1,
        'name' => 'Tiền điện tháng 9',
        'amount' => 1500000,
        'date' => '2025-09-25',
        'category' => 'bills'
    ],
    [
        'id' => 2,
        'name' => 'Mua laptop mới',
        'amount' => 25000000,
        'date' => '2025-10-01',
        'category' => 'shopping'
    ]
];

// Thêm vào phần dữ liệu mẫu
$savingGoals = [
    [
        'id' => 1,
        'name' => 'Mua iPhone 15',
        'target_amount' => 25000000,
        'current_amount' => 15000000,
        'start_date' => '2025-08-01',
        'end_date' => '2025-12-31',
        'daily_saving' => 100000,
        'remaining_days' => 100
    ],
    [
        'id' => 2,
        'name' => 'Du lịch Đà Lạt',
        'target_amount' => 10000000,
        'current_amount' => 3000000,
        'start_date' => '2025-09-01',
        'end_date' => '2025-11-30',
        'daily_saving' => 70000,
        'remaining_days' => 68
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngân sách tạm</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Ngân sách tạm</h1>
            <div class="flex gap-4">
                <a href="thongKe.php" class="text-blue-500 hover:text-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                        <path d="M12 2.252A8 8 0 0112 18.251v-8H4a8 8 0 018-7.749z" />
                    </svg>
                    Xem thống kê
                </a>
                <a href="trangchu.php" class="text-blue-500 hover:text-blue-600">← Trang chủ</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <!-- Form thêm khoản chi -->
            <h2 class="text-lg font-semibold mb-4">Thêm khoản chi mới</h2>
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tên khoản chi</label>
                    <input type="text" 
                           class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-100 focus:border-blue-500"
                           placeholder="VD: Tiền điện">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Số tiền</label>
                    <input type="number" 
                           class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-100 focus:border-blue-500"
                           placeholder="VD: 1,000,000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Ngày</label>
                    <input type="date" 
                           class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-100 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Danh mục</label>
                    <select class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-100 focus:border-blue-500">
                        <?php foreach ($categories as $key => $value): ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        Thêm khoản chi
                    </button>
                </div>
            </form>

        

        <!-- Thêm section Mục tiêu tiết kiệm -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Mục tiêu tiết kiệm</h2>
                <button onclick="showAddGoalForm()" 
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    + Thêm mục tiêu
                </button>
            </div>

            <!-- Danh sách mục tiêu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($savingGoals as $goal): ?>
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($goal['name']); ?></h3>
                            <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                <?php echo $goal['remaining_days']; ?> ngày còn lại
                            </span>
                        </div>
                        
                        <!-- Progress bar -->
                        <div class="mb-3">
                            <?php $progress = ($goal['current_amount'] / $goal['target_amount']) * 100; ?>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-500 h-2.5 rounded-full" 
                                     style="width: <?php echo $progress; ?>%"></div>
                            </div>
                            <div class="flex justify-between text-sm mt-1">
                                <span><?php echo number_format($goal['current_amount']); ?>₫</span>
                                <span class="text-gray-500"><?php echo number_format($goal['target_amount']); ?>₫</span>
                            </div>
                        </div>

                        <!-- Daily saving -->
                        <div class="text-sm text-gray-600">
                            <p>Tiết kiệm mỗi ngày: <span class="font-medium text-gray-800">
                                <?php echo number_format($goal['daily_saving']); ?>₫
                            </span></p>
                            <p>Thời gian: <?php echo date('d/m/Y', strtotime($goal['start_date'])); ?> 
                                - <?php echo date('d/m/Y', strtotime($goal['end_date'])); ?></p>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex justify-end gap-2 mt-3">
                            <button onclick="addDailySaving(<?php echo $goal['id']; ?>)"
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200">
                                + Thêm tiền
                            </button>
                            <button onclick="editGoal(<?php echo $goal['id']; ?>)"
                                    class="text-blue-600 hover:text-blue-800">
                                Sửa
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Modal thêm mục tiêu mới -->
        <div id="goalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg max-w-md mx-auto mt-20 p-6">
                <h3 class="text-lg font-semibold mb-4">Thêm mục tiêu tiết kiệm</h3>
                <form id="goalForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên mục tiêu</label>
                        <input type="text" name="goal_name" required
                               class="w-full p-2 border rounded-lg focus:ring focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số tiền mục tiêu</label>
                        <input type="number" name="target_amount" required
                               class="w-full p-2 border rounded-lg focus:ring focus:border-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ngày bắt đầu</label>
                            <input type="date" name="start_date" required
                                   class="w-full p-2 border rounded-lg focus:ring focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ngày kết thúc</label>
                            <input type="date" name="end_date" required
                                   class="w-full p-2 border rounded-lg focus:ring focus:border-blue-500">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="hideAddGoalForm()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Hủy
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Thêm mục tiêu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            // Xử lý form
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();
                // TODO: Xử lý thêm khoản chi
                alert('Đã thêm khoản chi mới!');
                this.reset();
            });

            function showAddGoalForm() {
                document.getElementById('goalModal').classList.remove('hidden');
            }

            function hideAddGoalForm() {
                document.getElementById('goalModal').classList.add('hidden');
            }

            function addDailySaving(goalId) {
                const amount = prompt('Nhập số tiền muốn thêm:');
                if (amount) {
                    // TODO: Gửi request để cập nhật số tiền
                    alert('Đã thêm ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount));
                }
            }

            function editGoal(goalId) {
                // TODO: Mở form chỉnh sửa mục tiêu
                alert('Chỉnh sửa mục tiêu #' + goalId);
            }

            document.getElementById('goalForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // TODO: Xử lý thêm mục tiêu mới
                alert('Đã thêm mục tiêu mới!');
                hideAddGoalForm();
                this.reset();
            });

            // Tự động tính toán số tiền cần tiết kiệm mỗi ngày
            function calculateDailySaving() {
                const targetAmount = document.querySelector('input[name="target_amount"]').value;
                const startDate = new Date(document.querySelector('input[name="start_date"]').value);
                const endDate = new Date(document.querySelector('input[name="end_date"]').value);
                
                if (targetAmount && startDate && endDate) {
                    const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                    const dailyAmount = Math.ceil(targetAmount / days);
                    alert('Bạn cần tiết kiệm ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(dailyAmount) + ' mỗi ngày');
                }
            }

            // Thêm event listeners cho form
            document.querySelector('input[name="end_date"]').addEventListener('change', calculateDailySaving);
            document.querySelector('input[name="target_amount"]').addEventListener('change', calculateDailySaving);
        </script>
    </div>
</body>
</html>