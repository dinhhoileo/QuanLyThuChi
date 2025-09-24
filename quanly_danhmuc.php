<?php
// BƯỚC 1: Lấy tên trang hiện tại để xử lý active state
$current_page = basename($_SERVER['PHP_SELF']);

// PHẦN XỬ LÝ LOGIC VÀ DỮ LIỆU
$userName = "Anh";

// --- Dữ liệu danh mục giả lập với số lượng giao dịch ---
// 'group' => 'fixed' (cố định), 'flexible' (linh hoạt)
$categories = [
    ['id' => 1, 'name' => 'Ăn uống', 'group' => 'flexible', 'icon' => 'utensils-crossed', 'transaction_count' => 58],
    ['id' => 2, 'name' => 'Tiền thuê nhà', 'group' => 'fixed', 'icon' => 'home', 'transaction_count' => 12],
    ['id' => 3, 'name' => 'Di chuyển', 'group' => 'flexible', 'icon' => 'bus', 'transaction_count' => 34],
    ['id' => 4, 'name' => 'Hóa đơn điện', 'group' => 'fixed', 'icon' => 'zap', 'transaction_count' => 12],
    ['id' => 5, 'name' => 'Mua sắm', 'group' => 'flexible', 'icon' => 'shopping-cart', 'transaction_count' => 25],
    ['id' => 6, 'name' => 'Giải trí', 'group' => 'flexible', 'icon' => 'film', 'transaction_count' => 18],
    ['id' => 7, 'name' => 'Sức khỏe', 'group' => 'fixed', 'icon' => 'heart-pulse', 'transaction_count' => 9],
    ['id' => 8, 'name' => 'Nuôi pet', 'group' => 'flexible', 'icon' => 'dog', 'transaction_count' => 15],
    ['id' => 9, 'name' => 'Thu nhập', 'group' => 'income', 'icon' => 'briefcase', 'transaction_count' => 5],
];

// Tính toán thống kê
$total_categories = count($categories);
$fixed_count = count(array_filter($categories, fn($cat) => $cat['group'] === 'fixed'));
$flexible_count = count(array_filter($categories, fn($cat) => $cat['group'] === 'flexible'));
$income_count = count(array_filter($categories, fn($cat) => $cat['group'] === 'income'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Danh Mục - SpendWise</title>
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
                 <button id="add-category-btn" class="flex items-center justify-center bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">
                    <i data-lucide="plus" class="mr-2 h-5 w-5"></i>Thêm Danh Mục
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
                        <a href="quanly_danhmuc.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'quanly_danhmuc.php') ? $active_class : $inactive_class; ?>"
                           <?php echo ($current_page == 'quanly_danhmuc.php') ? 'aria-current="page"' : ''; ?>>Danh mục Chi tiêu</a>
                        <a href="lap_kehoach.php" class="<?php echo $base_class; ?> <?php echo ($current_page == 'lap_kehoach.php') ? $active_class : $inactive_class; ?>">Lập kế hoạch</a>
                    </nav>
                </div>

                <!-- Thẻ thống kê với màu pastel -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-violet-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div><p class="text-sm font-medium text-violet-700">Tổng Danh Mục</p><p class="text-3xl font-bold text-violet-900 mt-1"><?php echo $total_categories; ?></p></div>
                        <div class="bg-violet-200 p-2 rounded-full"><i data-lucide="layers" class="h-6 w-6 text-violet-700"></i></div>
                    </div>
                    <div class="bg-sky-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div><p class="text-sm font-medium text-sky-700">Chi Tiêu Cố Định</p><p class="text-3xl font-bold text-sky-900 mt-1"><?php echo $fixed_count; ?></p></div>
                         <div class="bg-sky-200 p-2 rounded-full"><i data-lucide="lock" class="h-6 w-6 text-sky-700"></i></div>
                    </div>
                    <div class="bg-amber-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div><p class="text-sm font-medium text-amber-700">Chi Tiêu Linh Hoạt</p><p class="text-3xl font-bold text-amber-900 mt-1"><?php echo $flexible_count; ?></p></div>
                         <div class="bg-amber-200 p-2 rounded-full"><i data-lucide="activity" class="h-6 w-6 text-amber-700"></i></div>
                    </div>
                    <div class="bg-green-100 p-5 rounded-lg shadow-md flex items-start justify-between">
                        <div><p class="text-sm font-medium text-green-700">Nguồn Thu Nhập</p><p class="text-3xl font-bold text-green-900 mt-1"><?php echo $income_count; ?></p></div>
                         <div class="bg-green-200 p-2 rounded-full"><i data-lucide="briefcase" class="h-6 w-6 text-green-700"></i></div>
                    </div>
                </div>

                <!-- Bộ lọc và Tìm kiếm -->
                <div class="bg-white p-4 rounded-lg shadow-md mb-6 flex items-center space-x-4">
                    <div class="flex-grow">
                        <input type="text" id="search-input" placeholder="Tìm kiếm theo tên danh mục..." class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select id="group-filter" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-500">
                            <option value="all">Tất cả các nhóm</option>
                            <option value="fixed">Cố định</option>
                            <option value="flexible">Linh hoạt</option>
                            <option value="income">Thu nhập</option>
                        </select>
                    </div>
                </div>

                <!-- Bảng Danh mục -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên Danh Mục</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nhóm</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Số Giao Dịch</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="category-table-body">
                            <?php foreach ($categories as $cat): ?>
                                <tr class="hover:bg-gray-50" data-name="<?php echo strtolower(htmlspecialchars($cat['name'])); ?>" data-group="<?php echo htmlspecialchars($cat['group']); ?>">
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="bg-gray-100 p-2 rounded-full mr-4"><i data-lucide="<?php echo $cat['icon']; ?>" class="h-5 w-5 text-gray-600"></i></div>
                                            <p class="text-gray-900 font-medium whitespace-no-wrap"><?php echo htmlspecialchars($cat['name']); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                        <?php if ($cat['group'] === 'fixed'): ?>
                                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-800 leading-tight"><span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span><span class="relative">Cố định</span></span>
                                        <?php elseif ($cat['group'] === 'flexible'): ?>
                                            <span class="relative inline-block px-3 py-1 font-semibold text-blue-900 leading-tight"><span aria-hidden class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span><span class="relative">Linh hoạt</span></span>
                                        <?php else: ?>
                                             <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight"><span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span><span class="relative">Thu nhập</span></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                        <p class="text-gray-900 font-medium whitespace-no-wrap"><?php echo $cat['transaction_count']; ?></p>
                                    </td>
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

    <!-- Modal Thêm/Sửa Danh Mục -->
    <div id="category-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modal-title" class="text-xl font-semibold">Thêm Danh Mục Mới</h3>
                <button id="close-modal-btn" class="text-gray-500 hover:text-gray-800"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label for="category-name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục</label>
                        <input type="text" id="category-name" placeholder="Ví dụ: Ăn uống" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="category-icon" class="block text-gray-700 text-sm font-bold mb-2">Biểu tượng (Icon)</label>
                        <select id="category-icon" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="utensils-crossed">Ăn uống</option>
                            <option value="home">Nhà ở</option>
                            <option value="bus">Di chuyển</option>
                            <option value="shopping-cart">Mua sắm</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nhóm</label>
                        <div>
                            <label class="inline-flex items-center"><input type="radio" class="form-radio text-gray-600" name="group" value="fixed"><span class="ml-2">Chi tiêu Cố định</span></label>
                            <label class="inline-flex items-center ml-6"><input type="radio" class="form-radio text-blue-600" name="group" value="flexible" checked><span class="ml-2">Chi tiêu Linh hoạt</span></label>
                             <label class="inline-flex items-center mt-2"><input type="radio" class="form-radio text-green-600" name="group" value="income"><span class="ml-2">Thu nhập</span></label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex justify-end items-center p-4 border-t bg-gray-50 rounded-b-lg">
                <button id="cancel-btn" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 mr-2">Hủy</button>
                <button class="bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-700">Lưu</button>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.querySelector('.sidebar');
        menuButton.addEventListener('click', () => { sidebar.classList.toggle('-translate-x-full'); });

        const modal = document.getElementById('category-modal');
        const addBtn = document.getElementById('add-category-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');
        
        addBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => { if (event.target === modal) { closeModal(); } });

        // --- LOGIC LỌC DỮ LIỆU ---
        const searchInput = document.getElementById('search-input');
        const groupFilter = document.getElementById('group-filter');
        const categoryTableBody = document.getElementById('category-table-body');
        const categoryRows = categoryTableBody.querySelectorAll('tr');

        function filterCategories() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedGroup = groupFilter.value;

            categoryRows.forEach(row => {
                const name = row.dataset.name;
                const group = row.dataset.group;

                const nameMatch = name.includes(searchTerm);
                const groupMatch = selectedGroup === 'all' || selectedGroup === group;

                if (nameMatch && groupMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterCategories);
        groupFilter.addEventListener('change', filterCategories);
    </script>
</body>
</html>

