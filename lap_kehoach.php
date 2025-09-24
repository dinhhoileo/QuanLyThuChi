<?php
// BƯỚC 1: Lấy tên trang hiện tại để xử lý active state
$current_page = basename($_SERVER['PHP_SELF']);

// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU
$userName = "Anh";
function formatCurrency($number) { return number_format($number, 0, ',', '.') . 'đ'; }

// --- Dữ liệu kế hoạch/ngân sách giả lập ---
// group: 'fixed' (cố định), 'flexible' (linh hoạt)
$budgets = [
    // Chi tiêu cố định
    ['category' => 'Tiền thuê nhà', 'icon' => 'home', 'group' => 'fixed', 'budget_amount' => 4500000, 'spent_amount' => 4500000],
    ['category' => 'Hóa đơn điện', 'icon' => 'zap', 'group' => 'fixed', 'budget_amount' => 500000, 'spent_amount' => 480000],
    
    // Chi tiêu linh hoạt
    ['category' => 'Ăn uống', 'icon' => 'utensils-crossed', 'group' => 'flexible', 'budget_amount' => 3000000, 'spent_amount' => 2500000],
    ['category' => 'Di chuyển', 'icon' => 'bus', 'group' => 'flexible', 'budget_amount' => 700000, 'spent_amount' => 650000],
    ['category' => 'Mua sắm', 'icon' => 'shopping-cart', 'group' => 'flexible', 'budget_amount' => 1500000, 'spent_amount' => 1200000],
    ['category' => 'Giải trí', 'icon' => 'film', 'group' => 'flexible', 'budget_amount' => 1000000, 'spent_amount' => 950000],
];

// --- Tính toán thống kê tổng quan ---
$total_budget = array_sum(array_column($budgets, 'budget_amount'));
$total_spent = array_sum(array_column($budgets, 'spent_amount'));
$total_remaining = $total_budget - $total_spent;

// --- Tính toán ngày còn lại trong tháng ---
$days_in_month = date('t');
$current_day = date('j');
$days_left = $days_in_month - $current_day + 1;


// Tách ra 2 nhóm
$fixed_budgets = array_filter($budgets, fn($b) => $b['group'] === 'fixed');
$flexible_budgets = array_filter($budgets, fn($b) => $b['group'] === 'flexible');

// Lấy danh sách các danh mục chưa có kế hoạch để đưa vào modal
$all_categories = ['Ăn uống', 'Tiền thuê nhà', 'Di chuyển', 'Hóa đơn điện', 'Mua sắm', 'Giải trí', 'Sức khỏe', 'Nuôi pet'];
$budgeted_categories = array_column($budgets, 'category');
$unbudgeted_categories = array_diff($all_categories, $budgeted_categories);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lập Kế Hoạch Chi Tiêu - SpendWise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; } .sidebar { transition: transform 0.3s ease-in-out; } </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 border-b"><h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1></div>
        <nav class="mt-6">
            <!-- BƯỚC 2: Cập nhật liên kết và logic active cho sidebar -->
            <a href="tongquan.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200 <?php echo ($current_page == 'tongquan.php') ? 'bg-gray-200' : ''; ?>">
                <i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span>
            </a>
            <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 hover:bg-gray-200 <?php echo in_array($current_page, ['giaodich.php', 'quanly_giaodich.php', 'quanly_danhmuc.php', 'lap_kehoach.php']) ? 'bg-gray-200' : ''; ?>">
                <i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span></a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="target"></i><span class="mx-3">Kế hoạch</span></a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt</span></a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
             <div class="flex items-center">
                <button id="menu-button" class="text-gray-500 focus:outline-none md:hidden"><i data-lucide="menu" class="h-6 w-6"></i></button>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Giao Dịch</h2>
            </div>
             <div class="flex items-center">
                 <button id="add-budget-btn" class="flex items-center justify-center bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    <i data-lucide="plus" class="mr-2 h-5 w-5"></i>Thêm Kế Hoạch
                </button>
                <div class="relative ml-6">
                    <button class="relative z-10 block w-10 h-10 overflow-hidden rounded-full shadow focus:outline-none">
                        <img class="object-cover w-full h-full" src="https://placehold.co/100x100/667eea/ffffff?text=<?php echo strtoupper(substr($userName, 0, 1)); ?>" alt="Your avatar">
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <div class="container mx-auto">
                <!-- Thanh điều hướng phụ -->
                <div class="mb-6 bg-white rounded-lg shadow-md p-2">
                    <nav class="flex space-x-2" aria-label="Tabs">
                        <!-- BƯỚC 3: Cập nhật liên kết và logic active cho các tab -->
                        <?php 
                            $active_class = "bg-indigo-600 text-white";
                            $inactive_class = "text-gray-600 hover:bg-indigo-100 hover:text-indigo-700";
                            $base_class = "flex-1 text-center font-semibold whitespace-nowrap py-3 px-4 rounded-md text-base transition-colors duration-200";
                        ?>
                        <a href="giaodich.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'giaodich.php') ? $active_class : $inactive_class; ?>">Tổng quan</a>
                        <a href="quanly_giaodich.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_giaodich.php') ? $active_class : $inactive_class; ?>">Quản lý Giao dịch</a>
                        <a href="quanly_danhmuc.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_danhmuc.php') ? $active_class : $inactive_class; ?>">Danh mục Chi tiêu</a>
                        <a href="lap_kehoach.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'lap_kehoach.php') ? $active_class : $inactive_class; ?>"
                           <?php echo ($current_page == 'lap_kehoach.php') ? 'aria-current="page"' : ''; ?>>Lập kế hoạch</a>
                    </nav>
                </div>
                
                <!-- Thẻ Tóm Tắt Tổng Quan -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tổng quan kế hoạch tháng <?php echo date('m/Y'); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div class="bg-indigo-100 p-5 rounded-lg shadow flex items-start justify-between">
                             <div><p class="text-sm font-medium text-indigo-700">Tổng Ngân Sách</p><p class="text-2xl font-bold text-indigo-900 mt-1"><?php echo formatCurrency($total_budget); ?></p></div>
                             <div class="bg-indigo-200 p-2 rounded-full"><i data-lucide="piggy-bank" class="h-6 w-6 text-indigo-700"></i></div>
                        </div>
                        <div class="bg-red-100 p-5 rounded-lg shadow flex items-start justify-between">
                            <div><p class="text-sm font-medium text-red-700">Đã Chi</p><p class="text-2xl font-bold text-red-900 mt-1"><?php echo formatCurrency($total_spent); ?></p></div>
                             <div class="bg-red-200 p-2 rounded-full"><i data-lucide="shopping-bag" class="h-6 w-6 text-red-700"></i></div>
                        </div>
                        <div class="bg-green-100 p-5 rounded-lg shadow flex items-start justify-between">
                            <div><p class="text-sm font-medium text-green-700">Còn Lại</p><p class="text-2xl font-bold text-green-900 mt-1"><?php echo formatCurrency($total_remaining); ?></p></div>
                            <div class="bg-green-200 p-2 rounded-full"><i data-lucide="wallet" class="h-6 w-6 text-green-700"></i></div>
                        </div>
                    </div>
                    <?php $overall_percentage = ($total_budget > 0) ? ($total_spent / $total_budget) * 100 : 0; ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                         <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full" style="width: <?php echo min(100, $overall_percentage); ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Phần Chi Tiêu Cố Định -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chi Tiêu Cố Định</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($fixed_budgets as $budget): ?>
                            <?php
                                $percentage = ($budget['budget_amount'] > 0) ? ($budget['spent_amount'] / $budget['budget_amount']) * 100 : 0;
                                $remaining = $budget['budget_amount'] - $budget['spent_amount'];
                                $progress_color = 'bg-green-500';
                                if ($percentage >= 100) $progress_color = 'bg-red-500';
                                elseif ($percentage >= 80) $progress_color = 'bg-yellow-500';
                            ?>
                            <div class="bg-white p-5 rounded-lg shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center"><i data-lucide="<?php echo $budget['icon']; ?>" class="h-6 w-6 text-gray-600 mr-3"></i><span class="font-semibold text-lg"><?php echo $budget['category']; ?></span></div>
                                    <div><button class="text-gray-400 hover:text-indigo-600"><i data-lucide="pencil" class="h-4 w-4"></i></button><button class="text-gray-400 hover:text-red-600 ml-2"><i data-lucide="trash-2" class="h-4 w-4"></i></button></div>
                                </div>
                                <?php if ($percentage >= 100): ?>
                                    <div class="text-xs text-red-600 font-semibold mb-2 flex items-center"><i data-lucide="alert-triangle" class="h-4 w-4 mr-1"></i>Đã vượt ngân sách!</div>
                                <?php endif; ?>
                                <p class="text-gray-600 text-sm">Đã chi: <span class="font-bold text-gray-800"><?php echo formatCurrency($budget['spent_amount']); ?></span> / <?php echo formatCurrency($budget['budget_amount']); ?></p>
                                <p class="text-gray-600 text-sm mt-1">Còn lại: <span class="font-bold <?php echo ($remaining < 0) ? 'text-red-600' : 'text-green-600'; ?>"><?php echo formatCurrency($remaining); ?></span></p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3"><div class="<?php echo $progress_color; ?> h-2.5 rounded-full" style="width: <?php echo min(100, $percentage); ?>%"></div></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                 <!-- Phần Chi Tiêu Linh Hoạt -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Chi Tiêu Linh Hoạt</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($flexible_budgets as $budget): ?>
                            <?php
                                $percentage = ($budget['budget_amount'] > 0) ? ($budget['spent_amount'] / $budget['budget_amount']) * 100 : 0;
                                $remaining = $budget['budget_amount'] - $budget['spent_amount'];
                                $daily_suggestion = ($remaining > 0 && $days_left > 0) ? $remaining / $days_left : 0;
                                $progress_color = 'bg-green-500';
                                if ($percentage >= 100) $progress_color = 'bg-red-500';
                                elseif ($percentage >= 80) $progress_color = 'bg-yellow-500';
                            ?>
                            <div class="bg-white p-5 rounded-lg shadow-md">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center"><i data-lucide="<?php echo $budget['icon']; ?>" class="h-6 w-6 text-gray-600 mr-3"></i><span class="font-semibold text-lg"><?php echo $budget['category']; ?></span></div>
                                    <div><button class="text-gray-400 hover:text-indigo-600"><i data-lucide="pencil" class="h-4 w-4"></i></button><button class="text-gray-400 hover:text-red-600 ml-2"><i data-lucide="trash-2" class="h-4 w-4"></i></button></div>
                                </div>
                                <?php if ($percentage >= 80 && $percentage < 100): ?>
                                    <div class="text-xs text-yellow-600 font-semibold mb-2 flex items-center"><i data-lucide="alert-triangle" class="h-4 w-4 mr-1"></i>Sắp chạm tới ngân sách!</div>
                                <?php elseif ($percentage >= 100): ?>
                                     <div class="text-xs text-red-600 font-semibold mb-2 flex items-center"><i data-lucide="alert-triangle" class="h-4 w-4 mr-1"></i>Đã vượt ngân sách!</div>
                                <?php endif; ?>
                                <p class="text-gray-600 text-sm">Đã chi: <span class="font-bold text-gray-800"><?php echo formatCurrency($budget['spent_amount']); ?></span> / <?php echo formatCurrency($budget['budget_amount']); ?></p>
                                <p class="text-gray-600 text-sm mt-1">Còn lại: <span class="font-bold <?php echo ($remaining < 0) ? 'text-red-600' : 'text-green-600'; ?>"><?php echo formatCurrency($remaining); ?></span></p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-3"><div class="<?php echo $progress_color; ?> h-2.5 rounded-full" style="width: <?php echo min(100, $percentage); ?>%"></div></div>
                                <?php if ($daily_suggestion > 0): ?>
                                <p class="text-xs text-gray-500 italic mt-3 text-center">Gợi ý: bạn có thể chi ~<?php echo formatCurrency($daily_suggestion); ?>/ngày</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Thêm/Sửa Kế Hoạch -->
    <div id="budget-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="flex justify-between items-center p-4 border-b"><h3 id="modal-title" class="text-xl font-semibold">Thêm Kế Hoạch Mới</h3><button id="close-modal-btn" class="text-gray-500 hover:text-gray-800"><i data-lucide="x" class="w-6 h-6"></i></button></div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label for="budget-category" class="block text-gray-700 text-sm font-bold mb-2">Chọn danh mục</label>
                        <select id="budget-category" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <?php foreach($unbudgeted_categories as $cat): ?>
                            <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="budget-amount" class="block text-gray-700 text-sm font-bold mb-2">Số tiền ngân sách</label>
                        <input type="number" id="budget-amount" placeholder="0đ" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </form>
            </div>
            <div class="flex justify-end items-center p-4 border-t bg-gray-50 rounded-b-lg"><button id="cancel-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 mr-2">Hủy</button><button class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">Lưu</button></div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');
        menuButton.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });

        const modal = document.getElementById('budget-modal');
        const addBtn = document.getElementById('add-budget-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');
        addBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => { if (event.target === modal) { closeModal(); } });
    </script>
</body>
</html>

