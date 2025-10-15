<?php
$userName = "Anh"; // SAMPLE USER
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tổng quan - SpendWise</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style> body{font-family:'Inter',sans-serif;background:#f0f2f5}.sidebar{transition:transform .3s} </style>
</head>
<body class="flex h-screen overflow-hidden">

  <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
    <div class="flex items-center justify-center h-20 border-b"><h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1></div>
    <nav class="mt-6">
      <a href="trangchu.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200"><i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span></a>
      <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 hover:bg-gray-200"><i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span></a>
      <a href="baoCao.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span></a>
      <a href="lap_kehoach.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="target"></i><span class="mx-3">Kế hoạch</span></a>
      <a href="nganSachTam.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="wallet"></i><span class="mx-3">Ngân sách tạm</span></a>
      <a href="caiDat.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt</span></a>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
      <h2 class="text-2xl font-semibold text-gray-800">Tổng quan</h2>
      <a href="quanLyThongTinNguoiDung.php" class="text-indigo-600 hover:text-indigo-700">Tài khoản</a>
    </header>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
      <div class="container mx-auto">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
          <div class="flex items-center p-6 bg-white rounded-lg shadow-md"><div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full"><i data-lucide="wallet"></i></div><div><p class="mb-1 text-sm text-gray-600">Số dư</p><p class="text-2xl font-bold text-gray-700">25.500.000đ</p></div></div>
          <div class="flex items-center p-6 bg-white rounded-lg shadow-md"><div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full"><i data-lucide="arrow-down-circle"></i></div><div><p class="mb-1 text-sm text-gray-600">Tổng thu (tháng)</p><p class="text-2xl font-bold text-gray-700">15.000.000đ</p></div></div>
          <div class="flex items-center p-6 bg-white rounded-lg shadow-md"><div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full"><i data-lucide="arrow-up-circle"></i></div><div><p class="mb-1 text-sm text-gray-600">Tổng chi (tháng)</p><p class="text-2xl font-bold text-gray-700">8.250.000đ</p></div></div>
          <div class="flex items-center p-6 bg-white rounded-lg shadow-md"><div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full"><i data-lucide="trending-up"></i></div><div><p class="mb-1 text-sm text-gray-600">Tiết kiệm</p><p class="text-2xl font-bold text-gray-700">6.750.000đ</p></div></div>
        </div>

        <div class="grid gap-6 lg:grid-cols-5 mt-6">
          <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Tổng quan Thu / Chi</h3>
            <canvas id="chart"></canvas>
          </div>
          <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Nhắc việc</h3>
            <ul class="list-disc pl-5 text-gray-700 space-y-2">
              <li>SAMPLE: Cập nhật ngân sách tuần này</li>
              <li>SAMPLE: Xem lại chi tiêu cuối tuần</li>
              <li>SAMPLE: Tạo mục tiêu tiết kiệm mới</li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    lucide.createIcons();
    const ctx=document.getElementById('chart').getContext('2d');
    new Chart(ctx,{type:'line',data:{labels:['T1','T2','T3','T4','T5','T6'],datasets:[{label:'Thu',data:[5,4.5,5.5,5.2,5.8,6],borderColor:'rgb(16,185,129)',backgroundColor:'rgba(16,185,129,.1)',fill:true},{label:'Chi',data:[2.2,2.5,1.8,3.1,2.7,3],borderColor:'rgb(239,68,68)',backgroundColor:'rgba(239,68,68,.1)',fill:true}]},options:{responsive:true,plugins:{legend:{position:'bottom'}}}});
  </script>
</body>
</html>


