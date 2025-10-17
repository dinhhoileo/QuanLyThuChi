<?php
// BƯỚC 1: Lấy tên trang hiện tại để xử lý active state
$current_page = basename($_SERVER['PHP_SELF']);

// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU CỦA ADMIN
$adminName = "Admin"; // Tên hiển thị cho admin

// --- Hàm hỗ trợ định dạng tiền tệ ---
function formatCurrency($number) {
    return number_format($number, 0, ',', '.') . 'đ';
}

// --- Dữ liệu giao dịch giả lập từ NHIỀU NGƯỜI DÙNG ---
$transactions = [
    // Giao dịch của Nguyễn Văn A
    [ 'id' => 1, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'expense', 'description' => 'Ăn trưa bạn bè', 'category' => 'Ăn uống', 'date' => '2025-10-17', 'amount' => 350000 ],
    [ 'id' => 2, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'income', 'description' => 'Lương tháng 9', 'category' => 'Thu nhập', 'date' => '2025-09-20', 'amount' => 15000000 ],
    [ 'id' => 3, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'expense', 'description' => 'Mua sắm online Tiki', 'category' => 'Mua sắm', 'date' => '2025-09-19', 'amount' => 1200000 ],
    
    // Giao dịch của Trần Thị B
    [ 'id' => 4, 'userId' => 102, 'userName' => 'Trần Thị B', 'type' => 'expense', 'description' => 'Tiền thuê nhà', 'category' => 'Nhà ở', 'date' => '2025-10-15', 'amount' => 4500000 ],
    [ 'id' => 5, 'userId' => 102, 'userName' => 'Trần Thị B', 'type' => 'expense', 'description' => 'Đổ xăng xe máy', 'category' => 'Di chuyển', 'date' => '2025-10-14', 'amount' => 70000 ],
    
    // Giao dịch của Lê Minh C
    [ 'id' => 6, 'userId' => 103, 'userName' => 'Lê Minh C', 'type' => 'income', 'description' => 'Thưởng dự án', 'category' => 'Thu nhập', 'date' => '2025-10-12', 'amount' => 2000000 ],
    [ 'id' => 7, 'userId' => 103, 'userName' => 'Lê Minh C', 'type' => 'expense', 'description' => 'Xem phim cuối tuần', 'category' => 'Giải trí', 'date' => '2025-10-10', 'amount' => 250000 ],
];

// // Lấy danh sách người dùng duy nhất (bao gồm cả ID và Tên)
$users = array_reduce($transactions, function ($carry, $item) {
    if (!isset($carry[$item['userId']])) {
        $carry[$item['userId']] = $item['userName'];
    }
    return $carry;
}, []);
$categories = array_unique(array_column($transactions, 'category'));

// Ánh xạ category với icon
$category_icons = [
    'Ăn uống' => 'utensils-crossed', 'Thu nhập' => 'briefcase', 'Mua sắm' => 'shopping-cart',
    'Nhà ở' => 'home', 'Di chuyển' => 'bus', 'Giải trí' => 'film',
];

// Tính toán thống kê ban đầu trên TẤT CẢ giao dịch
$total_income = array_sum(array_column(array_filter($transactions, fn($t) => $t['type'] === 'income'), 'amount'));
$total_expense = array_sum(array_column(array_filter($transactions, fn($t) => $t['type'] === 'expense'), 'amount'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản Lý Giao Dịch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; } .sidebar { transition: transform 0.3s ease-in-out; } </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200">
                <i data-lucide="layout-dashboard"></i><span class="mx-3">Tổng Quan Admin</span>
            </a>
            <a href="admin_quanly_giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 bg-gray-200">
                <i data-lucide="arrow-left-right"></i><span class="mx-3">Quản Lý Giao Dịch</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="users"></i><span class="mx-3">Quản Lý Người Dùng</span></a>
            <a href="#" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt Hệ thống</span></a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
             <div class="flex items-center">
                <button id="menu-button" class="text-gray-500 focus:outline-none md:hidden"><i data-lucide="menu" class="h-6 w-6"></i></button>
                <h2 class="text-2xl font-semibold text-gray-800 ml-4">Quản Lý Giao Dịch </h2>
            </div>
             <div class="flex items-center">
                 <button id="add-transaction-btn" class="flex items-center justify-center bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    <i data-lucide="plus" class="mr-2 h-5 w-5"></i>Thêm Giao Dịch
                </button>
                <div class="relative ml-6">
                    <button class="relative z-10 block w-10 h-10 overflow-hidden rounded-full shadow focus:outline-none">
                        <img class="object-cover w-full h-full" src="https://placehold.co/100x100/1f2937/ffffff?text=AD" alt="Admin avatar">
                    </button>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-green-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-700">Tổng Thu Toàn Hệ Thống</p>
                            <p id="summary-income" class="text-2xl font-bold text-green-900 mt-1"><?php echo formatCurrency($total_income); ?></p>
                        </div>
                        <div class="bg-green-200 p-2 rounded-full"><i data-lucide="trending-up" class="h-6 w-6 text-green-700"></i></div>
                    </div>
                    <div class="bg-red-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-700">Tổng Chi Toàn Hệ Thống</p>
                            <p id="summary-expense" class="text-2xl font-bold text-red-900 mt-1"><?php echo formatCurrency($total_expense); ?></p>
                        </div>
                        <div class="bg-red-200 p-2 rounded-full"><i data-lucide="trending-down" class="h-6 w-6 text-red-700"></i></div>
                    </div>
                    <div class="bg-sky-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-sky-700">Số Dư Toàn Hệ Thống</p>
                            <p id="summary-balance" class="text-2xl font-bold text-sky-900 mt-1"><?php echo formatCurrency($total_income - $total_expense); ?></p>
                        </div>
                        <div class="bg-sky-200 p-2 rounded-full"><i data-lucide="wallet" class="h-6 w-6 text-sky-700"></i></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Bộ lọc và Tìm kiếm</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                        <input type="text" id="search-input" placeholder="Tìm theo ghi chú..." class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 lg:col-span-2">
                        
                        <select id="user-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                            <option value="all">Tất cả người dùng</option>
                            <?php foreach($users as $name): ?>
                                <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>

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
                        <button id="reset-filter-btn" class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 flex items-center justify-center">
                            <i data-lucide="rotate-ccw" class="mr-2 h-5 w-5"></i> Xóa bộ lọc
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Người Dùng</th>
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
                                    data-amount="<?php echo htmlspecialchars($tx['amount']); ?>"
                                    data-username="<?php echo htmlspecialchars($tx['userName']); ?>">
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 font-semibold whitespace-no-wrap"><?php echo htmlspecialchars($tx['userName']); ?></p>
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
                                        <a href="edit_transaction.php?id=<?php echo $tx['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 inline-block" title="Sửa giao dịch">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-900 inline-block" onclick="alert('Chức năng Xóa sẽ được phát triển sau!'); return false;" title="Xóa giao dịch">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="transaction-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
         <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="flex justify-between items-center p-4 border-b"><h3 id="modal-title" class="text-xl font-semibold">Thêm Giao Dịch Mới</h3><button id="close-modal-btn" class="text-gray-500 hover:text-gray-800"><i data-lucide="x" class="w-6 h-6"></i></button></div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label for="user-select-modal" class="block text-gray-700 text-sm font-bold mb-2">Người dùng</label>
                        <select id="user-select-modal" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                             <?php foreach($users as $id => $name): ?>
                                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4"><label class="block text-gray-700 text-sm font-bold mb-2">Loại giao dịch</label><div><label class="inline-flex items-center"><input type="radio" class="form-radio text-red-600" name="type" value="expense" checked><span class="ml-2">Chi tiêu</span></label><label class="inline-flex items-center ml-6"><input type="radio" class="form-radio text-green-600" name="type" value="income"><span class="ml-2">Thu nhập</span></label></div></div>
                    <div class="mb-4"><label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Số tiền</label><input type="number" id="amount" placeholder="0đ" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    <div class="mb-4"><label for="category" class="block text-gray-700 text-sm font-bold mb-2">Danh mục</label><select id="category" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><option>Ăn uống</option><option>Di chuyển</option></select></div>
                    <div class="mb-4"><label for="date" class="block text-gray-700 text-sm font-bold mb-2">Ngày</label><input type="date" id="date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    <div><label for="description" class="block text-gray-700 text-sm font-bold mb-2">Ghi chú</label><textarea id="description" rows="2" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea></div>
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

        const searchInput = document.getElementById('search-input');
        const userFilter = document.getElementById('user-filter');
        const categoryFilter = document.getElementById('category-filter');
        const typeFilter = document.getElementById('type-filter');
        const resetFilterBtn = document.getElementById('reset-filter-btn');
        const transactionTableBody = document.getElementById('transaction-table-body');
        const transactionRows = transactionTableBody.querySelectorAll('tr');

        const summaryIncomeEl = document.getElementById('summary-income');
        const summaryExpenseEl = document.getElementById('summary-expense');
        const summaryBalanceEl = document.getElementById('summary-balance');

        function formatCurrencyJS(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }

        function filterTransactions() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedUser = userFilter.value;
            const selectedCategory = categoryFilter.value;
            const selectedType = typeFilter.value;
            
            let visibleIncome = 0;
            let visibleExpense = 0;

            transactionRows.forEach(row => {
                const description = row.dataset.description;
                const userName = row.dataset.username;
                const category = row.dataset.category;
                const type = row.dataset.type;
                const amount = parseFloat(row.dataset.amount);

                const nameMatch = description.includes(searchTerm);
                const userMatch = selectedUser === 'all' || selectedUser === userName;
                const categoryMatch = selectedCategory === 'all' || selectedCategory === category;
                const typeMatch = selectedType === 'all' || selectedType === type;

                if (nameMatch && userMatch && categoryMatch && typeMatch) {
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

            summaryIncomeEl.textContent = formatCurrencyJS(visibleIncome);
            summaryExpenseEl.textContent = formatCurrencyJS(visibleExpense);
            summaryBalanceEl.textContent = formatCurrencyJS(visibleIncome - visibleExpense);
        }

        function resetFilters() {
            searchInput.value = '';
            userFilter.value = 'all';
            categoryFilter.value = 'all';
            typeFilter.value = 'all';
            filterTransactions();
        }
        
        [searchInput, userFilter, categoryFilter, typeFilter].forEach(el => {
            el.addEventListener('input', filterTransactions);
            el.addEventListener('change', filterTransactions);
        });

        resetFilterBtn.addEventListener('click', resetFilters);
    </script>
</body>
</html>