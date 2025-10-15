<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Báo cáo - SpendWise</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body class="flex h-screen overflow-hidden">

  <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
    <div class="flex items-center justify-center h-20 border-b"><h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1></div>
    <nav class="mt-6">
      <a href="trangchu.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200"><i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span></a>
      <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span></a>
      <a href="baoCao.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 bg-gray-200"><i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span></a>
      <a href="lap_kehoach.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="target"></i><span class="mx-3">Kế hoạch</span></a>
      <a href="nganSachTam.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="wallet"></i><span class="mx-3">Ngân sách tạm</span></a>
      <a href="caiDat.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt</span></a>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
      <div class="flex items-center">
        <button id="menu-button" class="text-gray-500 focus:outline-none md:hidden"><i data-lucide="menu" class="h-6 w-6"></i></button>
        <h2 class="text-2xl font-semibold text-gray-800 ml-4">Báo cáo</h2>
      </div>
    </header>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
      <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-3">Chi tiêu theo tháng (SAMPLE)</h2>
            <canvas id="monthly"></canvas>
          </div>
          <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-3">Phân bổ theo danh mục (SAMPLE)</h2>
            <canvas id="byCat"></canvas>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    lucide.createIcons();
    const menuButton=document.getElementById('menu-button');
    const sidebar=document.querySelector('.sidebar');
    if(menuButton){menuButton.addEventListener('click',()=>{sidebar.classList.toggle('-translate-x-full');});}
    new Chart(document.getElementById('monthly'),{type:'bar',data:{labels:['T1','T2','T3','T4','T5','T6'],datasets:[{label:'Chi',data:[12,15,11,14,13,16],backgroundColor:'rgba(239,68,68,.6)'}]},options:{responsive:true}});
    new Chart(document.getElementById('byCat'),{type:'doughnut',data:{labels:['Ăn uống','Di chuyển','Mua sắm','Hóa đơn','Giải trí'],datasets:[{data:[35,12,25,18,10],backgroundColor:['#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6']}]},options:{responsive:true}});
  </script>
</body>
</html>

