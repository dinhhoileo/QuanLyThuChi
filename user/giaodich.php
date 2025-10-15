<?php $userName = "Anh"; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tổng quan giao dịch - SpendWise</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style> body{font-family:'Inter',sans-serif;background:#f0f2f5}.sidebar{transition:transform .3s}
    :root{color-scheme:light}
    .theme-dark{color-scheme:dark}
    .theme-dark body{background-color:#0f172a;color:#e5e7eb}
    .theme-dark .bg-white{background-color:#111827 !important}
    .theme-dark .bg-gray-100{background-color:#0b1220 !important}
    .theme-dark .text-gray-700,.theme-dark .text-gray-800{color:#e5e7eb !important}
    .theme-dark .hover\:bg-gray-200:hover{background-color:#1f2937 !important}
  </style>
  <script>(function(){try{var t=localStorage.getItem('theme')||'light';if(t==='dark')document.documentElement.classList.add('theme-dark');}catch(e){}})();</script>
</head>
<body class="flex h-screen overflow-hidden">
  <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
    <div class="flex items-center justify-center h-20 border-b"><h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1></div>
    <nav class="mt-6">
      <a href="trangchu.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200"><i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span></a>
      <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 bg-gray-200"><i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span></a>
      <a href="baoCao.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span></a>
      <a href="lap_kehoach.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="target"></i><span class="mx-3">Kế hoạch</span></a>
      <a href="nganSachTam.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="wallet"></i><span class="mx-3">Ngân sách tạm</span></a>
      <a href="caiDat.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt</span></a>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
      <h2 class="text-2xl font-semibold text-gray-800">Tổng quan Giao dịch</h2>
      <a href="quanly_giaodich.php" class="text-indigo-600 hover:text-indigo-700">Quản lý chi tiết</a>
    </header>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
      <div class="container mx-auto">
        <div class="grid gap-6 md:grid-cols-3">
          <div class="bg-white rounded-lg shadow p-6"><p class="text-sm text-gray-500">Tổng thu (SAMPLE)</p><p class="text-3xl font-bold text-green-600">17.000.000đ</p></div>
          <div class="bg-white rounded-lg shadow p-6"><p class="text-sm text-gray-500">Tổng chi (SAMPLE)</p><p class="text-3xl font-bold text-red-600">9.500.000đ</p></div>
          <div class="bg-white rounded-lg shadow p-6"><p class="text-sm text-gray-500">Số dư (SAMPLE)</p><p class="text-3xl font-bold text-blue-600">7.500.000đ</p></div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 mt-6">
          <h3 class="text-lg font-semibold mb-2">Giao dịch gần đây (SAMPLE)</h3>
          <ul class="divide-y">
            <li class="py-3 flex justify-between"><span><i data-lucide="shopping-cart" class="inline-block mr-2 text-gray-500"></i>Mua sắm</span><span class="text-red-600 font-semibold">-450.000đ</span></li>
            <li class="py-3 flex justify-between"><span><i data-lucide="briefcase" class="inline-block mr-2 text-gray-500"></i>Lương</span><span class="text-green-600 font-semibold">+15.000.000đ</span></li>
            <li class="py-3 flex justify-between"><span><i data-lucide="home" class="inline-block mr-2 text-gray-500"></i>Thuê nhà</span><span class="text-red-600 font-semibold">-4.500.000đ</span></li>
          </ul>
        </div>
      </div>
    </main>
  </div>

  <script>lucide.createIcons();</script>
</body>
</html>

