<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cài đặt - SpendWise</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style> body{font-family:'Inter',sans-serif;background:#f0f2f5}.sidebar{transition:transform .3s}
    :root{color-scheme:light}
    .theme-dark{color-scheme:dark}
    .theme-dark body{background-color:#0f172a;color:#e5e7eb}
    .theme-dark .bg-white{background-color:#111827 !important}
    .theme-dark .bg-gray-50{background-color:#0b1220 !important}
    .theme-dark .bg-gray-100{background-color:#0b1220 !important}
    .theme-dark .text-gray-700,.theme-dark .text-gray-800,.theme-dark .text-gray-900{color:#e5e7eb !important}
    .theme-dark .text-gray-500{color:#cbd5e1 !important}
    .theme-dark .border-b,.theme-dark .border{border-color:#334155 !important}
    .theme-dark .hover\:bg-gray-200:hover{background-color:#1f2937 !important}
  </style>
  <script>(function(){try{var t=localStorage.getItem('theme')||'light';if(t==='dark')document.documentElement.classList.add('theme-dark');}catch(e){}})();</script>
</head>
<body class="flex h-screen overflow-hidden">
  <aside class="sidebar fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform -translate-x-full md:relative md:translate-x-0">
    <div class="flex items-center justify-center h-20 border-b"><h1 class="text-2xl font-bold text-indigo-600">SpendWise</h1></div>
    <nav class="mt-6">
      <a href="trangchu.php" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-200"><i data-lucide="layout-dashboard"></i><span class="mx-3">Bảng điều khiển</span></a>
      <a href="giaodich.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="arrow-left-right"></i><span class="mx-3">Giao dịch</span></a>
      <a href="baoCao.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="pie-chart"></i><span class="mx-3">Báo cáo</span></a>
      <a href="lap_kehoach.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="target"></i><span class="mx-3">Kế hoạch</span></a>
      <a href="nganSachTam.php" class="flex items-center px-6 py-3 mt-4 text-gray-600 hover:bg-gray-200"><i data-lucide="wallet"></i><span class="mx-3">Ngân sách tạm</span></a>
      <a href="caiDat.php" class="flex items-center px-6 py-3 mt-4 text-gray-700 bg-gray-200"><i data-lucide="settings"></i><span class="mx-3">Cài đặt</span></a>
    </nav>
  </aside>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="flex items-center justify-between h-20 px-6 py-4 bg-white border-b">
      <div class="flex items-center"><button id="menu-button" class="text-gray-500 focus:outline-none md:hidden"><i data-lucide="menu" class="h-6 w-6"></i></button><h2 class="text-2xl font-semibold text-gray-800 ml-4">Cài đặt</h2></div>
    </header>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
      <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6 space-y-6">
          <div>
            <h2 class="font-semibold text-gray-800 mb-2">Giao diện (SAMPLE)</h2>
            <label class="inline-flex items-center mr-4"><input type="radio" name="theme" id="themeLight" class="mr-2">Sáng</label>
            <label class="inline-flex items-center"><input type="radio" name="theme" id="themeDark" class="mr-2">Tối</label>
          </div>
          <div>
            <h2 class="font-semibold text-gray-800 mb-2">Đơn vị tiền tệ (SAMPLE)</h2>
            <select class="border rounded px-3 py-2"><option>VND</option><option>USD</option></select>
          </div>
          <div>
            <h2 class="font-semibold text-gray-800 mb-2">Thông báo (SAMPLE)</h2>
            <label class="flex items-center"><input type="checkbox" class="mr-2" checked> Nhận thông báo email</label>
          </div>
          <div class="text-right">
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Lưu</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    lucide.createIcons();
    document.getElementById('menu-button').addEventListener('click',()=>{document.querySelector('.sidebar').classList.toggle('-translate-x-full');});
    (function(){
      var light=document.getElementById('themeLight');
      var dark=document.getElementById('themeDark');
      try{
        var saved=localStorage.getItem('theme')||'light';
        if(saved==='dark'){dark.checked=true;document.documentElement.classList.add('theme-dark');}
        else {light.checked=true;document.documentElement.classList.remove('theme-dark');}
      }catch(e){}
      function applyTheme(val){
        if(val==='dark'){document.documentElement.classList.add('theme-dark');}
        else {document.documentElement.classList.remove('theme-dark');}
        try{localStorage.setItem('theme',val);}catch(e){}
      }
      light.addEventListener('change',function(){if(this.checked)applyTheme('light');});
      dark.addEventListener('change',function(){if(this.checked)applyTheme('dark');});
    })();
  </script>
</body>
</html>

