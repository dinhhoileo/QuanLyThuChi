<?php
header('Location: trangchu.php');
exit;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang chủ - Quản lý Tài chính</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f5f7fa;
      color: #333;
    }

    /* Navbar */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #fff;
      padding: 15px 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 10;
    }
    .nav-links {
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      padding: 8px 5px;
    }
    .nav-links a.active {
      color: #1976d2;
      border-bottom: 2px solid #1976d2;
    }
    .user-icon {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background: #1976d2;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    /* Container */
    .container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
      max-width: 1200px;
      margin: 30px auto;
      padding: 0 20px;
    }

    /* Card */
    .card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .card h2 {
      font-size: 18px;
      margin-bottom: 15px;
      color: #2c3e50;
    }

    /* Tổng quan tài chính */
    .balance {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .income {
      color: green;
      margin-bottom: 5px;
    }
    .expense {
      color: red;
      margin-bottom: 5px;
    }
    .progress-bar {
      height: 8px;
      border-radius: 5px;
      background: #eee;
      margin: 15px 0;
      overflow: hidden;
    }
    .progress {
      height: 100%;
      background: #1976d2;
      width: 65%;
    }
    .link {
      color: #1976d2;
      text-decoration: none;
      font-size: 14px;
    }

    /* Recent expenses */
    .expense-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid #eee;
    }
    .expense-item:last-child { border-bottom: none; }
    .expense-info {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .expense-icon {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 16px;
    }
    .green { background: #27ae60; }
    .blue { background: #3498db; }
    .orange { background: #f39c12; }
    .expense-text { font-size: 14px; }

    /* Search filter */
    .filter {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .filter input, .filter select, .filter button {
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .filter button {
      background: #1976d2;
      color: white;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }
    .filter button:hover {
      background: #125a9c;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="nav-links">
      <a href="#" class="active">Trang chủ</a>
      <a href="about.php">Giới thiệu</a>
      <a href="#">Tài khoản</a>
      <a href="#">Cài đặt</a>
    </div>
    <div class="user-icon">U</div>
  </div>

  <!-- Main content -->
  <div class="container">
    <!-- Tổng quan -->
    <div>
      <div class="card">
        <h2>Tổng quan tài chính</h2>
        <div class="balance">12.345.000 VNĐ</div>
        <div class="income">Tổng thu trong tháng: +8.000.000 VNĐ</div>
        <div class="expense">Tổng chi trong tháng: -3.500.000 VNĐ</div>
        <div class="progress-bar">
          <div class="progress"></div>
        </div>
        <a href="#" class="link">Xem tất cả giao dịch</a>
      </div>

      <!-- Biểu đồ -->
      <div class="card">
        <h2>Biểu đồ Thu nhập & Chi tiêu</h2>
        <canvas id="financeChart" height="200"></canvas>
      </div>
    </div>

    <!-- Search + Recent expenses -->
    <div>
      <div class="filter">
        <h2>Tìm kiếm</h2>
        <input type="text" placeholder="🔍 Từ khóa, danh mục..."><br>
        <select>
          <option>Danh mục</option>
          <option>Ăn uống</option>
          <option>Đi lại</option>
          <option>Hóa đơn</option>
        </select><br>
        <input type="date"><br>
        <input type="number" placeholder="Số tiền"><br>
        <button>Tìm kiếm</button>
      </div>

      <div class="card">
        <h2>Các khoản chi tiêu gần đây</h2>
        <div class="expense-item">
          <div class="expense-info">
            <div class="expense-icon green">🛒</div>
            <div class="expense-text">
              Siêu thị Go! - 14/03/2024
            </div>
          </div>
          <div>-350.000 VNĐ</div>
        </div>
        <div class="expense-item">
          <div class="expense-info">
            <div class="expense-icon blue">🏠</div>
            <div class="expense-text">
              Nhà hàng Phố Việt - 12/03/2024
            </div>
          </div>
          <div>-500.000 VNĐ</div>
        </div>
        <div class="expense-item">
          <div class="expense-info">
            <div class="expense-icon orange">💡</div>
            <div class="expense-text">
              Hóa đơn điện - 10/03/2024
            </div>
          </div>
          <div>-800.000 VNĐ</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Demo JS: click tìm kiếm
    document.querySelector(".filter button").addEventListener("click", function(){
      alert("Chức năng tìm kiếm đang phát triển!");
    });

    // Chart.js - dữ liệu demo
    const ctx = document.getElementById('financeChart').getContext('2d');
    const financeChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
        datasets: [
          {
            label: 'Thu nhập',
            data: [2000000, 2500000, 1800000, 1700000],
            backgroundColor: 'rgba(46, 204, 113, 0.8)'
          },
          {
            label: 'Chi tiêu',
            data: [1000000, 1500000, 1200000, 800000],
            backgroundColor: 'rgba(231, 76, 60, 0.8)'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          }
        },
        scales: {
          y: {
            ticks: {
              callback: function(value) {
                return value.toLocaleString('vi-VN') + ' ₫';
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>
