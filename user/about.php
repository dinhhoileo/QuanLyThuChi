<?php
// gioithieu.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giới thiệu - MoneyFlow</title>
  <style>
    * {margin: 0; padding: 0; box-sizing: border-box;}
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f5f7fa;
      color: #333;
    }

    /* Header */
    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 10;
    }
    header .logo {
      display: flex;
      align-items: center;
      font-weight: bold;
      font-size: 20px;
      color: #16a085;
    }
    header nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }
    header .btn {
      background: #16a085;
      color: white;
      padding: 8px 15px;
      border-radius: 6px;
      text-decoration: none;
      transition: 0.3s;
    }
    header .btn:hover {
      background: #138d75;
    }

    /* Main content */
    .container {
      max-width: 1100px;
      margin: 30px auto;
      padding: 0 20px;
    }
    h1 {
      text-align: center;
      margin-bottom: 10px;
      font-size: 28px;
      color: #2c3e50;
    }
    .subtitle {
      text-align: center;
      color: #7f8c8d;
      margin-bottom: 30px;
    }

    /* Card */
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      margin-bottom: 25px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-4px);
    }
    .card h2 {
      font-size: 20px;
      color: #16a085;
      margin-bottom: 10px;
    }
    .card p {
      color: #555;
      line-height: 1.6;
      max-width: 80%;
    }
    .card img {
      width: 100px;
    }

    /* Info cards */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    .info-card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      transition: 0.3s;
    }
    .info-card:hover {
      transform: translateY(-4px);
    }
    .info-card h3 {
      font-size: 18px;
      margin-bottom: 10px;
      color: #16a085;
    }
    .info-card p {
      color: #555;
      font-size: 15px;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px;
      margin-top: 40px;
      background: #fff;
      color: #7f8c8d;
      border-top: 1px solid #e0e0e0;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">💰 MoneyFlow</div>
    <nav>
      <a href="#">Trang chủ</a>
      <a href="#">Sản phẩm</a>
      <a href="#">Dịch vụ</a>
      <a href="#">Blog</a>
    </nav>
    <a href="#" class="btn">Đăng nhập</a>
  </header>

  <!-- Main -->
  <div class="container">
    <h1>Giới Thiệu</h1>
    <p class="subtitle">Quản lý tài chính cá nhân thông minh, đơn giản và an toàn</p>

    <div class="card">
      <div>
        <h2>Mục Tiêu Của MoneyFlow</h2>
        <p>
          MoneyFlow được xây dựng với mục tiêu giúp cá nhân và doanh nghiệp quản lý tài chính hiệu quả. 
          Hệ thống hỗ trợ theo dõi thu chi, lập kế hoạch chi tiêu, phân tích báo cáo và đưa ra gợi ý tối ưu.
        </p>
      </div>
      <img src="https://cdn-icons-png.flaticon.com/512/2920/2920244.png" alt="finance">
    </div>

    <h2>Thông Tin Hỗ Trợ & Pháp Lý</h2>
    <div class="info-grid">
      <div class="info-card">
        <h3>📞 Liên Hệ Hỗ Trợ</h3>
        <p>Email: hotro@moneyflow.vn<br>Hotline: 0123 456 789</p>
      </div>
      <div class="info-card">
        <h3>📑 Điều Khoản Dịch Vụ</h3>
        <p>Người dùng cần tuân thủ các điều khoản khi sử dụng hệ thống.</p>
      </div>
      <div class="info-card">
        <h3>🔒 Chính Sách Bảo Mật</h3>
        <p>Dữ liệu người dùng được bảo mật tuyệt đối và không chia sẻ cho bên thứ ba.</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    © 2025 MoneyFlow | Mọi quyền được bảo lưu.
  </footer>

  <script>
    // JavaScript demo: alert khi click Đăng nhập
    document.querySelector(".btn").addEventListener("click", function(e){
      e.preventDefault();
      alert("Chức năng đăng nhập đang được phát triển!");
    });
  </script>
</body>
</html>
