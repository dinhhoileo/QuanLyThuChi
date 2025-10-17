<?php
// --- Dữ liệu giả lập (bạn nên đồng bộ dữ liệu này với file admin_quanly_giaodich.php) ---
$transactions = [
    [ 'id' => 1, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'expense', 'description' => 'Ăn trưa bạn bè', 'category' => 'Ăn uống', 'date' => '2025-10-17', 'amount' => 350000 ],
    [ 'id' => 2, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'income', 'description' => 'Lương tháng 9', 'category' => 'Thu nhập', 'date' => '2025-09-20', 'amount' => 15000000 ],
    [ 'id' => 3, 'userId' => 101, 'userName' => 'Nguyễn Văn A', 'type' => 'expense', 'description' => 'Mua sắm online Tiki', 'category' => 'Mua sắm', 'date' => '2025-09-19', 'amount' => 1200000 ],
    [ 'id' => 4, 'userId' => 102, 'userName' => 'Trần Thị B', 'type' => 'expense', 'description' => 'Tiền thuê nhà', 'category' => 'Nhà ở', 'date' => '2025-10-15', 'amount' => 4500000 ],
    [ 'id' => 5, 'userId' => 102, 'userName' => 'Trần Thị B', 'type' => 'expense', 'description' => 'Đổ xăng xe máy', 'category' => 'Di chuyển', 'date' => '2025-10-14', 'amount' => 70000 ],
    [ 'id' => 6, 'userId' => 103, 'userName' => 'Lê Minh C', 'type' => 'income', 'description' => 'Thưởng dự án', 'category' => 'Thu nhập', 'date' => '2025-10-12', 'amount' => 2000000 ],
    [ 'id' => 7, 'userId' => 103, 'userName' => 'Lê Minh C', 'type' => 'expense', 'description' => 'Xem phim cuối tuần', 'category' => 'Giải trí', 'date' => '2025-10-10', 'amount' => 250000 ],
];

// Lấy danh sách người dùng và danh mục để hiển thị trong form
$users = array_unique(array_column($transactions, 'userName'));
$categories = array_unique(array_column($transactions, 'category'));

// === PHẦN LOGIC CHÍNH ĐỂ SỬA GIAO DỊCH ===

// 1. Lấy ID của giao dịch từ URL
$transaction_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$transaction_to_edit = null;

// 2. Tìm giao dịch trong mảng dữ liệu
if ($transaction_id > 0) {
    foreach ($transactions as $tx) {
        if ($tx['id'] === $transaction_id) {
            $transaction_to_edit = $tx;
            break;
        }
    }
}

// 3. Xử lý khi người dùng nhấn nút "Lưu Thay Đổi"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trong một ứng dụng thực tế, bạn sẽ lấy dữ liệu từ $_POST và cập nhật vào CSDL.
    // Ví dụ: $new_amount = $_POST['amount'];
    // UPDATE transactions SET amount = $new_amount WHERE id = $transaction_id;

    // Ở đây, chúng ta chỉ giả lập việc xử lý thành công và chuyển hướng về trang chính.
    echo "<script>
            alert('Cập nhật giao dịch thành công! (giả lập)');
            window.location.href = 'admin_quanly_giaodich.php';
          </script>";
    exit;
}

// Nếu không tìm thấy giao dịch, thông báo lỗi
if (!$transaction_to_edit) {
    die("<h1>Lỗi: Không tìm thấy giao dịch với ID: " . htmlspecialchars($transaction_id) . "</h1>");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Giao Dịch #<?php echo $transaction_to_edit['id']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; } </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 id="modal-title" class="text-2xl font-semibold text-gray-800">
                Sửa Giao Dịch cho <span class="text-indigo-600"><?php echo htmlspecialchars($transaction_to_edit['userName']); ?></span>
            </h3>
        </div>
        
        <form action="edit_transaction.php?id=<?php echo $transaction_to_edit['id']; ?>" method="POST">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Số tiền</label>
                        <input type="number" id="amount" name="amount" placeholder="0đ" 
                               value="<?php echo htmlspecialchars($transaction_to_edit['amount']); ?>"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Ngày</label>
                        <input type="date" id="date" name="date"
                               value="<?php echo htmlspecialchars($transaction_to_edit['date']); ?>"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Loại giao dịch</label>
                    <div class="flex items-center space-x-6">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-red-600 h-5 w-5" name="type" value="expense" 
                                   <?php if ($transaction_to_edit['type'] === 'expense') echo 'checked'; ?>>
                            <span class="ml-2 text-gray-700">Chi tiêu</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-green-600 h-5 w-5" name="type" value="income"
                                   <?php if ($transaction_to_edit['type'] === 'income') echo 'checked'; ?>>
                            <span class="ml-2 text-gray-700">Thu nhập</span>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Danh mục</label>
                    <select id="category" name="category" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category); ?>" 
                                    <?php if ($transaction_to_edit['category'] === $category) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Ghi chú (Mô tả)</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($transaction_to_edit['description']); ?></textarea>
                </div>
            </div>
            
            <div class="flex justify-end items-center p-6 border-t bg-gray-50 rounded-b-lg space-x-3">
                <a href="admin_quanly_giaodich.php" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300">
                    Hủy
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-indigo-700">
                    Lưu Thay Đổi
                </button>
            </div>
        </form>
    </div>

</body>
</html>