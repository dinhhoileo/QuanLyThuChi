<?php
// BƯỚC 1: Lấy tên trang hiện tại để xử lý active state
$current_page = basename($_SERVER['PHP_SELF']);

// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU
$userName = "Anh";

// --- Hàm hỗ trợ định dạng tiền tệ ---
function formatCurrency($number) {
    return number_format($number, 0, ',', '.') . 'đ';
}

// --- Dữ liệu giao dịch giả lập cho trang này ---
$transactions = [
    [ 'id' => 1, 'type' => 'expense', 'description' => 'Ăn trưa bạn bè', 'category' => 'Ăn uống', 'date' => '2025-09-21', 'amount' => 350000 ],
    [ 'id' => 2, 'type' => 'income', 'description' => 'Lương tháng 9', 'category' => 'Thu nhập', 'date' => '2025-09-20', 'amount' => 15000000 ],
    [ 'id' => 3, 'type' => 'expense', 'description' => 'Mua sắm online Tiki', 'category' => 'Mua sắm', 'date' => '2025-09-19', 'amount' => 1200000 ],
    [ 'id' => 4, 'type' => 'expense', 'description' => 'Tiền thuê nhà', 'category' => 'Nhà ở', 'date' => '2025-09-15', 'amount' => 4500000 ],
    [ 'id' => 5, 'type' => 'expense', 'description' => 'Đổ xăng xe máy', 'category' => 'Di chuyển', 'date' => '2025-09-14', 'amount' => 70000 ],
    [ 'id' => 6, 'type' => 'income', 'description' => 'Thưởng dự án', 'category' => 'Thu nhập', 'date' => '2025-09-12', 'amount' => 2000000 ],
    [ 'id' => 7, 'type' => 'expense', 'description' => 'Xem phim cuối tuần', 'category' => 'Giải trí', 'date' => '2025-09-10', 'amount' => 250000 ],
];

// Lấy danh sách danh mục duy nhất từ giao dịch
$categories = array_unique(array_column($transactions, 'category'));

// Ánh xạ category với icon
$category_icons = [
    'Ăn uống' => 'utensils-crossed', 'Thu nhập' => 'briefcase', 'Mua sắm' => 'shopping-cart',
    'Nhà ở' => 'home', 'Di chuyển' => 'bus', 'Giải trí' => 'film',
];

// Tính toán thống kê ban đầu
$total_income = array_sum(array_column(array_filter($transactions, fn($t) => $t['type'] === 'income'), 'amount'));
$total_expense = array_sum(array_column(array_filter($transactions, fn($t) => $t['type'] === 'expense'), 'amount'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giao Dịch - SpendWise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; } .sidebar { transition: transform 0.3s ease-in-out; } </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1>
        </div>
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
                 <button id="add-transaction-btn" class="flex items-center justify-center bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    <i data-lucide="plus" class="mr-2 h-5 w-5"></i>Thêm Giao Dịch
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
                        
                        <a href="quanly_giaodich.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_giaodich.php') ? $active_class : $inactive_class; ?>" 
                           <?php echo ($current_page == 'quanly_giaodich.php') ? 'aria-current="page"' : ''; ?>>Quản lý Giao dịch</a>
                        <a href="quanly_danhmuc.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_danhmuc.php') ? $active_class : $inactive_class; ?>">Danh mục Chi tiêu</a>
                       
                    </nav>
                </div>

                <!-- Thẻ thống kê -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-green-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-700">Tổng Thu</p>
                            <p id="summary-income" class="text-2xl font-bold text-green-900 mt-1"><?php echo formatCurrency($total_income); ?></p>
                        </div>
                        <div class="bg-green-200 p-2 rounded-full">
                            <i data-lucide="trending-up" class="h-6 w-6 text-green-700"></i>
                        </div>
                    </div>
                    <div class="bg-red-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-700">Tổng Chi</p>
                            <p id="summary-expense" class="text-2xl font-bold text-red-900 mt-1"><?php echo formatCurrency($total_expense); ?></p>
                        </div>
                        <div class="bg-red-200 p-2 rounded-full">
                            <i data-lucide="trending-down" class="h-6 w-6 text-red-700"></i>
                        </div>
                    </div>
                    <div class="bg-sky-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-sky-700">Số Dư</p>
                            <p id="summary-balance" class="text-2xl font-bold text-sky-900 mt-1"><?php echo formatCurrency($total_income - $total_expense); ?></p>
                        </div>
                        <div class="bg-sky-200 p-2 rounded-full">
                            <i data-lucide="wallet" class="h-6 w-6 text-sky-700"></i>
                        </div>
                    </div>
                </div>

                 <!-- Bộ lọc -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Bộ lọc và Tìm kiếm</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <input type="text" id="search-input" placeholder="Tìm theo ghi chú..." class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:col-span-2">
                        <select id="category-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                            <option value="all">Tất cả danh mục</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="type-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                            <option value="all">Mọi loại GD</option>
                            <option value="income">Thu</option>
                            <option value="expense">Chi</option>
                        </select>
                        <input type="date" id="start-date-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                        <input type="date" id="end-date-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                        <button id="reset-filter-btn" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 flex items-center justify-center">
                            <i data-lucide="rotate-ccw" class="mr-2 h-5 w-5"></i> Xóa bộ lọc
                        </button>
                    </div>
                </div>

                <!-- Bảng Giao dịch -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loại</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ghi chú</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Danh mục</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Số tiền</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="transaction-table-body">
                            <?php foreach ($transactions as $tx): ?>
                                <tr class="hover:bg-gray-50" 
                                    data-description="<?php echo strtolower(htmlspecialchars($tx['description'])); ?>" 
                                    data-category="<?php echo htmlspecialchars($tx['category']); ?>" 
                                    data-type="<?php echo htmlspecialchars($tx['type']); ?>"
                                    data-date="<?php echo htmlspecialchars($tx['date']); ?>"
                                    data-amount="<?php echo htmlspecialchars($tx['amount']); ?>">
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <?php if ($tx['type'] === 'expense'): ?>
                                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight"><span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span><span class="relative">Chi</span></span>
                                        <?php else: ?>
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight"><span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span><span class="relative">Thu</span></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm"><p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($tx['description']); ?></p></td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <i data-lucide="<?php echo $category_icons[$tx['category']] ?? 'tag'; ?>" class="h-5 w-5 text-gray-500 mr-2"></i>
                                            <p class="text-gray-900 whitespace-no-wrap"><?php echo htmlspecialchars($tx['category']); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm"><p class="text-gray-900 whitespace-no-wrap"><?php echo date('d/m/Y', strtotime($tx['date'])); ?></p></td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-right"><p class="font-semibold <?php echo $tx['type'] === 'expense' ? 'text-red-600' : 'text-green-600'; ?> whitespace-no-wrap"><?php echo ($tx['type'] === 'expense' ? '-' : '+') . ' ' . formatCurrency($tx['amount']); ?></p></td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-2"><i data-lucide="edit" class="w-5 h-5"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Thêm/Sửa Giao Dịch -->
    <div id="transaction-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="flex justify-between items-center p-4 border-b"><h3 id="modal-title" class="text-xl font-semibold">Thêm Giao Dịch Mới</h3><button id="close-modal-btn" class="text-gray-500 hover:text-gray-800"><i data-lucide="x" class="w-6 h-6"></i></button></div>
            <div class="p-6"><form><div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Loại giao dịch</label><div><label class="inline-flex items-center"><input type="radio" class="form-radio text-red-600" name="type" value="expense" checked><span class="ml-2">Chi tiêu</span></label><label class="inline-flex items-center ml-6"><input type="radio" class="form-radio text-green-600" name="type" value="income"><span class="ml-2">Thu nhập</span></label></div></div><div class="mb-4"><label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Số tiền</label><input type="number" id="amount" placeholder="0đ" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div class="mb-4"><label for="category" class="block text-gray-700 text-sm font-bold mb-2">Danh mục</label><select id="category" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><option>Ăn uống</option><option>Di chuyển</option></select></div><div class="mb-4"><label for="date" class="block text-gray-700 text-sm font-bold mb-2">Ngày</label><input type="date" id="date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div><label for="description" class="block text-gray-700 text-sm font-bold mb-2">Ghi chú</label><textarea id="description" rows="2" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea></div></form></div>
            <div class="flex justify-end items-center p-4 border-t bg-gray-50 rounded-b-lg"><button id="cancel-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 mr-2">Hủy</button><button class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">Lưu</button></div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');
        menuButton.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });

        const modal = document.getElementById('transaction-modal');
        const addTransactionBtn = document.getElementById('add-transaction-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');
        addTransactionBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => { if (event.target === modal) { closeModal(); } });

        // --- LOGIC LỌC DỮ LIỆU ---
        const searchInput = document.getElementById('search-input');
        const categoryFilter = document.getElementById('category-filter');
        const typeFilter = document.getElementById('type-filter');
        const startDateFilter = document.getElementById('start-date-filter');
        const endDateFilter = document.getElementById('end-date-filter');
        const resetFilterBtn = document.getElementById('reset-filter-btn');
        const transactionTableBody = document.getElementById('transaction-table-body');
        const transactionRows = transactionTableBody.querySelectorAll('tr');

        // Thẻ thống kê
        const summaryIncomeEl = document.getElementById('summary-income');
        const summaryExpenseEl = document.getElementById('summary-expense');
        const summaryBalanceEl = document.getElementById('summary-balance');

        function formatCurrencyJS(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }

        function filterTransactions() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;
            const selectedType = typeFilter.value;
            const startDate = startDateFilter.value;
            const endDate = endDateFilter.value;

            let visibleIncome = 0;
            let visibleExpense = 0;

            transactionRows.forEach(row => {
                const description = row.dataset.description;
                const category = row.dataset.category;
                const type = row.dataset.type;
                const date = row.dataset.date;
                const amount = parseFloat(row.dataset.amount);

                const nameMatch = description.includes(searchTerm);
                const categoryMatch = selectedCategory === 'all' || selectedCategory === category;
                const typeMatch = selectedType === 'all' || selectedType === type;
                const dateMatch = (!startDate || date >= startDate) && (!endDate || date <= endDate);

                if (nameMatch && categoryMatch && typeMatch && dateMatch) {
                    row.style.display = '';
                    if (type === 'income') {
                        visibleIncome += amount;
                    } else {
                        visibleExpense += amount;
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Cập nhật thẻ thống kê
            summaryIncomeEl.textContent = formatCurrencyJS(visibleIncome);
            summaryExpenseEl.textContent = formatCurrencyJS(visibleExpense);
            summaryBalanceEl.textContent = formatCurrencyJS(visibleIncome - visibleExpense);
        }

        function resetFilters() {
            searchInput.value = '';
            categoryFilter.value = 'all';
            typeFilter.value = 'all';
            startDateFilter.value = '';
            endDateFilter.value = '';
            filterTransactions();
        }

        [searchInput, categoryFilter, typeFilter, startDateFilter, endDateFilter].forEach(el => {
            el.addEventListener('input', filterTransactions);
            el.addEventListener('change', filterTransactions);
        });

        resetFilterBtn.addEventListener('click', resetFilters);
    </script>
</body>
</html>

