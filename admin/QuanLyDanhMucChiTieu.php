<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Danh mục Chi tiêu</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: "Segoe UI", Arial, sans-serif; background: linear-gradient(135deg, #e0f2ff, #f5e8ff); color: #2b2f38; }

    .navbar { display: flex; align-items: center; justify-content: space-between; background: rgba(255,255,255,.75); backdrop-filter: blur(8px); padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 10; }
    .nav-links { display: flex; gap: 20px; }
    .nav-links a { text-decoration: none; color: #333; font-weight: 500; padding: 8px 5px; transition: .2s; }
    .nav-links a:hover { color: #1976d2; transform: translateY(-1px); }
    .nav-links a.active { color: #1976d2; border-bottom: 2px solid #1976d2; }

    .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
    .card { background: rgba(255,255,255,.95); border-radius: 16px; padding: 20px; box-shadow: 0 15px 45px rgba(10,31,68,0.06); margin-bottom: 20px; }
    .card h1 { font-size: 24px; margin-bottom: 10px; color: #2c3e50; }

    .grid { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
    .field label { font-size: 13px; color: #5f6b7a; }
    .field input, .field select, .field textarea { padding: 10px 12px; border: 1px solid #d7dce1; border-radius: 10px; outline: none; background: #fff; transition: box-shadow .2s, border-color .2s; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color: #1976d2; box-shadow: 0 0 0 4px rgba(25,118,210,.12); }
    .btn { background: linear-gradient(135deg,#1976d2,#125a9c); color: #fff; border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer; font-weight: 700; letter-spacing: .2px; box-shadow: 0 8px 20px rgba(25,118,210,.18); transition: transform .06s ease, filter .2s; }
    .btn:hover { filter: brightness(1.05); }
    .btn:active { transform: translateY(1px); }
    .btn.secondary { background: #6c757d; box-shadow: none; }
    .btn.danger { background: #dc3545; box-shadow: none; }

    .toolbar { display: flex; gap: 10px; margin-bottom: 12px; align-items: center; }
    .search { flex: 1; }
    .search input { width: 100%; padding: 10px 12px; border: 1px solid #d7dce1; border-radius: 10px; }
    .sort { display: flex; gap: 8px; }

    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
    th { background: #f8fafc; color: #556; font-weight: 700; cursor: pointer; user-select: none; }
    tr:hover { background: #fafafa; }
    .actions { display: flex; gap: 8px; }
    .muted { font-size: 13px; color: #7f8c8d; }

    .toast { position: fixed; right: 20px; bottom: 20px; background: #111827; color: #fff; padding: 12px 14px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,.2); opacity: 0; transform: translateY(10px); transition: .25s; }
    .toast.show { opacity: 1; transform: translateY(0); }

    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.4); display: none; align-items: center; justify-content: center; }
    .modal { width: 420px; background: #fff; border-radius: 14px; padding: 18px; box-shadow: 0 20px 60px rgba(0,0,0,.25); }
    .modal h3 { margin-bottom: 8px; }
    .modal .actions { justify-content: flex-end; }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="nav-links">
      <a href="./DangNhapQuanTri.php">Đăng xuất</a>
      <a href="#" class="active">Danh mục chi tiêu</a>
      <a href="../user/trangchu.php">Trang người dùng</a>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <h1>Quản lý Danh mục Chi tiêu</h1>
      <p class="muted">Các mục có nhãn "SAMPLE" đang sử dụng dữ liệu mẫu. Sau này thay bằng dữ liệu CSDL.</p>
    </div>

    <div class="grid">
      <div class="card">
        <h2>Thêm / Sửa danh mục</h2>
        <form id="categoryForm">
          <input type="hidden" id="categoryId" value="">
          <div class="field">
            <label for="categoryName">Tên danh mục</label>
            <input type="text" id="categoryName" placeholder="Ví dụ: Ăn uống" required>
          </div>
          <div class="field">
            <label for="categoryType">Loại</label>
            <select id="categoryType">
              <option value="expense">Chi tiêu</option>
              <option value="income">Thu nhập</option>
            </select>
          </div>
          <div class="field">
            <label for="categoryNote">Ghi chú</label>
            <textarea id="categoryNote" rows="3" placeholder="Ghi chú (không bắt buộc)"></textarea>
          </div>

          <div class="actions">
            <button type="submit" class="btn" id="saveBtn">Lưu</button>
            <button type="button" class="btn secondary" id="resetBtn">Làm mới</button>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="toolbar">
          <div class="search"><input type="text" id="searchInput" placeholder="Tìm danh mục..."></div>
          <div class="sort">
            <button class="btn secondary" id="sortName">Sắp xếp theo tên</button>
            <button class="btn secondary" id="sortType">Sắp xếp theo loại</button>
          </div>
        </div>
        <h2>Danh sách danh mục</h2>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Tên danh mục</th>
              <th>Loại</th>
              <th>Ghi chú</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody id="categoryTableBody">
            <!-- SAMPLE ROWS: dữ liệu mẫu, sẽ được thay bằng render từ CSDL -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal-backdrop" id="confirmModal">
    <div class="modal">
      <h3>Xác nhận xóa</h3>
      <p class="muted">Bạn có chắc muốn xóa danh mục này không?</p>
      <div class="actions" style="margin-top:12px;">
        <button class="btn secondary" id="cancelDelete">Hủy</button>
        <button class="btn danger" id="confirmDelete">Xóa</button>
      </div>
    </div>
  </div>

  <div id="toast" class="toast"></div>

  <script>
    // SAMPLE DATA: Thay bằng dữ liệu lấy từ CSDL sau này
    let sampleCategories = [
      { id: 1, name: "Ăn uống", type: "expense", note: "SAMPLE" },
      { id: 2, name: "Đi lại", type: "expense", note: "SAMPLE" },
      { id: 3, name: "Lương", type: "income", note: "SAMPLE" }
    ];

    const tableBody = document.getElementById('categoryTableBody');
    const form = document.getElementById('categoryForm');
    const idInput = document.getElementById('categoryId');
    const nameInput = document.getElementById('categoryName');
    const typeInput = document.getElementById('categoryType');
    const noteInput = document.getElementById('categoryNote');
    const resetBtn = document.getElementById('resetBtn');
    const saveBtn = document.getElementById('saveBtn');
    const searchInput = document.getElementById('searchInput');
    const sortName = document.getElementById('sortName');
    const sortType = document.getElementById('sortType');
    const toast = document.getElementById('toast');
    const confirmModal = document.getElementById('confirmModal');
    const cancelDelete = document.getElementById('cancelDelete');
    const confirmDelete = document.getElementById('confirmDelete');
    let pendingDeleteId = null;

    function renderTable() {
      tableBody.innerHTML = '';
      const keyword = (searchInput.value || '').toLowerCase();
      const filtered = sampleCategories.filter(c =>
        c.name.toLowerCase().includes(keyword) || (c.note||'').toLowerCase().includes(keyword)
      );
      filtered.forEach((c, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${idx + 1}</td>
          <td>${c.name}</td>
          <td>${c.type === 'expense' ? 'Chi tiêu' : 'Thu nhập'}</td>
          <td>${c.note || ''}</td>
          <td>
            <div class="actions">
              <button class="btn secondary" data-action="edit" data-id="${c.id}">Sửa</button>
              <button class="btn danger" data-action="delete" data-id="${c.id}">Xóa</button>
            </div>
          </td>`;
        tableBody.appendChild(tr);
      });
    }

    function resetForm() {
      idInput.value = '';
      nameInput.value = '';
      typeInput.value = 'expense';
      noteInput.value = '';
      saveBtn.textContent = 'Lưu';
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const id = idInput.value ? parseInt(idInput.value, 10) : null;
      const payload = {
        id: id ?? (Math.max(0, ...sampleCategories.map(x => x.id)) + 1),
        name: nameInput.value.trim(),
        type: typeInput.value,
        note: noteInput.value.trim()
      };

      if (!payload.name) return;

      if (id) {
        // SAMPLE UPDATE: Thay bằng API/CSDL
        const idx = sampleCategories.findIndex(x => x.id === id);
        if (idx >= 0) sampleCategories[idx] = payload;
      } else {
        // SAMPLE CREATE: Thay bằng API/CSDL
        sampleCategories.push(payload);
      }

      renderTable();
      resetForm();
      showToast(id ? 'Cập nhật danh mục (SAMPLE)' : 'Thêm danh mục (SAMPLE)');
    });

    resetBtn.addEventListener('click', function() {
      resetForm();
    });

    tableBody.addEventListener('click', function(e) {
      const btn = e.target.closest('button');
      if (!btn) return;
      const action = btn.getAttribute('data-action');
      const id = parseInt(btn.getAttribute('data-id'), 10);

      if (action === 'edit') {
        // SAMPLE EDIT LOAD: Thay bằng fetch từ CSDL
        const c = sampleCategories.find(x => x.id === id);
        if (!c) return;
        idInput.value = c.id;
        nameInput.value = c.name;
        typeInput.value = c.type;
        noteInput.value = c.note || '';
        saveBtn.textContent = 'Cập nhật';
      }

      if (action === 'delete') {
        pendingDeleteId = id; // mở modal xác nhận
        confirmModal.style.display = 'flex';
      }
    });

    // Khởi tạo
    renderTable();

    // Tìm kiếm
    searchInput.addEventListener('input', renderTable);

    // Sắp xếp
    let nameAsc = true;
    sortName.addEventListener('click', function(){
      sampleCategories.sort((a,b)=> nameAsc ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name));
      nameAsc = !nameAsc; renderTable();
    });
    let typeAsc = true;
    sortType.addEventListener('click', function(){
      const weight = v => v === 'income' ? 1 : 0; // income sau expense
      sampleCategories.sort((a,b)=> typeAsc ? weight(a.type)-weight(b.type) : weight(b.type)-weight(a.type));
      typeAsc = !typeAsc; renderTable();
    });

    // Modal xác nhận xóa (SAMPLE)
    cancelDelete.addEventListener('click', ()=> { confirmModal.style.display = 'none'; pendingDeleteId = null; });
    confirmDelete.addEventListener('click', ()=> {
      if (pendingDeleteId != null) {
        sampleCategories = sampleCategories.filter(x => x.id !== pendingDeleteId);
        pendingDeleteId = null;
        renderTable();
        showToast('Đã xóa danh mục (SAMPLE)');
      }
      confirmModal.style.display = 'none';
    });

    function showToast(message) {
      toast.textContent = message;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 1800);
    }
  </script>
</body>
</html>

