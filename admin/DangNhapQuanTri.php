<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập Quản trị</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: "Segoe UI", Arial, sans-serif; color: #2b2f38; background: linear-gradient(135deg, #e0f2ff, #f5e8ff); min-height: 100vh; }

    .navbar { display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,0.75); backdrop-filter: blur(8px); padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 10; }
    .nav-links { display: flex; gap: 20px; }
    .nav-links a { text-decoration: none; color: #333; font-weight: 500; padding: 8px 5px; transition: .2s; }
    .nav-links a:hover { color: #1976d2; transform: translateY(-1px); }
    .nav-links a.active { color: #1976d2; border-bottom: 2px solid #1976d2; }

    .container { max-width: 440px; margin: 80px auto; padding: 0 20px; }
    .card { position: relative; overflow: hidden; background: rgba(255,255,255,0.9); border-radius: 16px; padding: 28px; box-shadow: 0 15px 45px rgba(10,31,68,0.08); animation: floatIn .5s ease; }
    .card::after { content: ""; position: absolute; inset: -40% -40% auto auto; width: 240px; height: 240px; background: radial-gradient(170px 170px at 70% 30%, rgba(25,118,210,.12), transparent); transform: rotate(25deg); }
    .card h1 { font-size: 24px; margin-bottom: 18px; color: #2c3e50; text-align: center; }
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
    .field label { font-size: 13px; color: #5f6b7a; }
    .input-wrap { position: relative; }
    .field input { width: 100%; padding: 12px 44px 12px 12px; border: 1px solid #d7dce1; border-radius: 10px; outline: none; background: #ffffff; transition: box-shadow .2s, border-color .2s, transform .06s; }
    .field input:focus { border-color: #1976d2; box-shadow: 0 0 0 4px rgba(25,118,210,.12); }
    .toggle-pwd { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; font-size: 13px; }
    .actions { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; }
    .btn { background: linear-gradient(135deg,#1976d2,#125a9c); color: #fff; border: none; padding: 11px 16px; border-radius: 10px; cursor: pointer; font-weight: 700; letter-spacing: .2px; box-shadow: 0 8px 20px rgba(25,118,210,.25); transition: transform .06s ease, filter .2s; }
    .btn:hover { filter: brightness(1.05); }
    .btn:active { transform: translateY(1px); }
    .btn.loading { position: relative; pointer-events: none; opacity: .9; }
    .btn.loading::after { content: ""; width: 16px; height: 16px; border-radius: 50%; border: 2px solid rgba(255,255,255,.6); border-top-color: white; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); animation: spin .9s linear infinite; }
    .muted { color: #748092; font-size: 13px; }
    .alert { margin-top: 12px; padding: 10px 12px; border-radius: 10px; display: none; }
    .alert.error { background: #fdecea; color: #b0413e; border: 1px solid #f5c6cb; }

    .toast { position: fixed; right: 20px; bottom: 20px; background: #111827; color: #fff; padding: 12px 14px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,.2); opacity: 0; transform: translateY(10px); transition: .25s; }
    .toast.show { opacity: 1; transform: translateY(0); }
    .link-btn { background: transparent; border: none; color: #1976d2; cursor: pointer; padding: 0; font-size: 13px; }
    .link-btn:hover { text-decoration: underline; }
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.4); display: none; align-items: center; justify-content: center; }
    .modal { width: 420px; background: #fff; border-radius: 14px; padding: 18px; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
    .modal h3 { margin-bottom: 8px; }
    .modal .actions { justify-content: flex-end; }

    @keyframes floatIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="nav-links">
      <a href="../user/trangchu.php">Trang người dùng</a>
      <a href="#" class="active">Đăng nhập quản trị</a>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <h1>Đăng nhập Quản trị</h1>
      <form id="adminLoginForm">
        <div class="field">
          <label for="username">Tài khoản</label>
          <input type="text" id="username" name="username" placeholder="admin" required>
        </div>
        <div class="field">
          <label for="password">Mật khẩu</label>
          <div class="input-wrap">
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <span class="toggle-pwd" id="togglePwd">Hiện</span>
          </div>
        </div>
        <div class="actions">
          <button type="button" class="link-btn" id="forgotBtn">Quên mật khẩu?</button>
          <button type="submit" class="btn">Đăng nhập</button>
        </div>
        <div id="alert" class="alert error"></div>
      </form>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <div class="modal-backdrop" id="forgotModal">
    <div class="modal">
      <h3>Khôi phục mật khẩu</h3>
      <p class="muted" style="margin-bottom:10px;">Nhập email hoặc tài khoản của bạn. (SAMPLE)</p>
      <div class="field">
        <label for="forgotInput">Email hoặc tài khoản</label>
        <input type="text" id="forgotInput" placeholder="admin hoặc admin@example.com">
      </div>
      <div class="actions" style="margin-top:12px;">
        <button class="btn secondary" id="cancelForgot" type="button">Hủy</button>
        <button class="btn" id="sendForgot" type="button">Gửi liên kết</button>
      </div>
    </div>
  </div>

  <script>
    // SAMPLE AUTH LOGIC: Thay bằng kiểm tra CSDL/Session thực tế sau này
    // Dữ liệu mẫu: username=admin, password=admin123
    const SAMPLE_USERNAME = "admin"; // SAMPLE DATA
    const SAMPLE_PASSWORD = "admin123"; // SAMPLE DATA

    const form = document.getElementById("adminLoginForm");
    const alertBox = document.getElementById("alert");
    const pwd = document.getElementById("password");
    const togglePwd = document.getElementById("togglePwd");
    const toast = document.getElementById("toast");
    const forgotBtn = document.getElementById('forgotBtn');
    const forgotModal = document.getElementById('forgotModal');
    const cancelForgot = document.getElementById('cancelForgot');
    const sendForgot = document.getElementById('sendForgot');
    const forgotInput = document.getElementById('forgotInput');

    form.addEventListener("submit", function(e) {
      e.preventDefault();
      const submitBtn = form.querySelector('.btn');
      submitBtn.classList.add('loading');
      setTimeout(() => {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value;

      if (username === SAMPLE_USERNAME && password === SAMPLE_PASSWORD) {
        // SAMPLE: mô phỏng đăng nhập thành công → điều hướng trang quản trị danh mục
        showToast('Đăng nhập thành công (SAMPLE)');
        window.location.href = "./QuanLyDanhMucChiTieu.php"; // Thay bằng dashboard thực tế
        return;
      }

      alertBox.textContent = "Sai tài khoản hoặc mật khẩu (dữ liệu mẫu).";
      alertBox.style.display = "block";
      submitBtn.classList.remove('loading');
      }, 500);
    });

    togglePwd.addEventListener('click', function() {
      const isPwd = pwd.getAttribute('type') === 'password';
      pwd.setAttribute('type', isPwd ? 'text' : 'password');
      togglePwd.textContent = isPwd ? 'Ẩn' : 'Hiện';
    });

    function showToast(message) {
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 1800);
    }

    // Forgot password (SAMPLE)
    if (forgotBtn) {
      forgotBtn.addEventListener('click', ()=> {
        forgotModal.style.display = 'flex';
        setTimeout(()=> forgotInput && forgotInput.focus(), 50);
      });
    }
    if (cancelForgot) {
      cancelForgot.addEventListener('click', ()=> {
        forgotModal.style.display = 'none';
        forgotInput.value = '';
      });
    }
    if (sendForgot) {
      sendForgot.addEventListener('click', ()=> {
        // SAMPLE: mô phỏng gửi email/reset link
        showToast('Đã gửi liên kết khôi phục (SAMPLE)');
        forgotModal.style.display = 'none';
        forgotInput.value = '';
      });
    }
  </script>
</body>
</html>

