<?php
// Dữ liệu mẫu
$userData = [
    'fullname' => 'Huỳnh Đình Hội',
    'email' => 'hoidh@example.com',
    'phone' => '0123456789',
    'birthday' => '1990-01-01',
    'gender' => 'male',
    'address' => 'TP.HCM, Việt Nam',
    'avatar' => 'https://placehold.co/150x150/667eea/ffffff?text=HDH' // Avatar mặc định
];

// Xử lý upload avatar (giả lập)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    // TODO: Xử lý upload file thật sau này
    echo "<script>alert('Upload avatar thành công!');</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông tin cá nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        money: {
                            income: '#10B981',
                            expense: '#EF4444',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-small': 'bounceSmall 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceSmall: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .input-focus-effect {
            transition: all 0.3s ease;
        }
        .input-focus-effect:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .button-hover-effect {
            transition: all 0.3s ease;
        }
        .button-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }
        .avatar-container {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 to-primary-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header với animation -->
        <header class="bg-white shadow-lg animate-fade-in">
            <div class="max-w-7xl mx-auto py-6 px-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 animate-slide-up">
                        Quản lý thông tin cá nhân
                    </h1>
                    <a href="trangchu.php" 
                       class="text-primary-600 hover:text-primary-700 flex items-center space-x-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.707 3.293a1 1 0 010 1.414L6.414 9H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 01-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span>Quay về trang chủ</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content với animation -->
        <main class="flex-grow container mx-auto px-4 py-8 animate-fade-in">
            <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-8 animate-slide-up">
                <form method="POST" action="" enctype="multipart/form-data">
                    <!-- Avatar Section với animation -->
                    <div class="mb-8 flex flex-col items-center avatar-container">
                        <div class="relative mb-4 group">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-r from-primary-400 to-primary-600 border-4 border-white shadow-xl transition-transform duration-300 hover:scale-105">
                                <img id="avatar-preview" 
                                     src="<?php echo htmlspecialchars($userData['avatar']); ?>" 
                                     alt="Avatar" 
                                     class="w-full h-full object-cover">
                            </div>
                            <label class="absolute bottom-0 right-0 bg-primary-500 rounded-full p-3 cursor-pointer hover:bg-primary-600 transition-all duration-300 transform hover:scale-110 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                <input type="file" name="avatar" accept="image/*" class="hidden" onchange="previewImage(this)">
                            </label>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800 animate-bounce-small">
                            <?php echo htmlspecialchars($userData['fullname']); ?>
                        </h2>
                        <p class="text-gray-500">
                            <?php echo htmlspecialchars($userData['email']); ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Input fields với hiệu ứng focus -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                            <input type="text" 
                                   name="fullname" 
                                   value="<?php echo htmlspecialchars($userData['fullname']); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" 
                                   name="email" 
                                   value="<?php echo htmlspecialchars($userData['email']); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="<?php echo htmlspecialchars($userData['phone']); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" 
                                   name="birthday" 
                                   value="<?php echo htmlspecialchars($userData['birthday']); ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="gender" 
                                           value="male" 
                                           <?php echo $userData['gender'] === 'male' ? 'checked' : ''; ?>
                                           class="mr-2">
                                    Nam
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="gender" 
                                           value="female" 
                                           <?php echo $userData['gender'] === 'female' ? 'checked' : ''; ?>
                                           class="mr-2">
                                    Nữ
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                            <textarea name="address" 
                                      rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500"><?php echo htmlspecialchars($userData['address']); ?></textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                            <input type="password" 
                                   name="new_password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                            <input type="password" 
                                   name="confirm_password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus-effect focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <!-- Buttons với animation -->
                    <div class="md:col-span-2 flex justify-end space-x-4 mt-6">
                        <button type="button" 
                                onclick="toggleEdit()"
                                class="px-6 py-3 bg-white border-2 border-primary-500 text-primary-500 rounded-lg button-hover-effect hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                <span>Chỉnh sửa</span>
                            </span>
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-primary-500 text-white rounded-lg button-hover-effect hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Lưu thay đổi</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Preview ảnh
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle chỉnh sửa form
        function toggleEdit() {
            const inputs = document.querySelectorAll('input:not([type="file"]), textarea');
            inputs.forEach(input => {
                input.disabled = !input.disabled;
                if (!input.disabled) {
                    input.focus();
                }
            });
        }

        // Form validation với animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.querySelector('input[name="new_password"]')?.value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]')?.value;

            if (newPassword && newPassword !== confirmPassword) {
                e.preventDefault();
                const errorDiv = document.createElement('div');
                errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded animate-shake';
                errorDiv.textContent = 'Mật khẩu xác nhận không khớp!';
                document.querySelector('form').prepend(errorDiv);
            }
        });

        // Thêm animation khi load trang
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('animate-fade-in');
        });
    </script>
</body>
</html>