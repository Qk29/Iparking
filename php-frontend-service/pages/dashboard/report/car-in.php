<?php 
    include_once __DIR__ . '/../../../api/request.php';

    
?>

<div class="container-fluid px-3">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i> Trang chủ</a></li>
      <li class="breadcrumb-item"><a href="#">Web</a></li>
      <li class="breadcrumb-item"><a href="#">Báo cáo</a></li>
      <li class="breadcrumb-item"><a href="#">Xe trong bãi</a></li>
      <li class="breadcrumb-item active" aria-current="page">Xe trong bãi hiện tại</li>
    </ol>
  </nav>

  <!-- Title -->
  <h5 class="mb-3 mt-3">Xe trong bãi hiện tại (0)</h5>

  <!-- Bộ lọc tìm kiếm -->
  <div class="bg-white p-3 border rounded mb-4">
    <form method="POST" class="row g-3 align-items-end">
      <div class="col-md-3">
        <label class="form-label">Từ khóa</label>
        <input type="text" name="keyword" class="form-control" placeholder="Mã thẻ, Biển số...">
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm khách hàng</label>
        <select name="custumerGroup" class="form-select">
          <option selected>--Chọn nhóm khách hàng--</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Từ ngày</label>
        <input type="datetime-local" name="from_date" class="form-control" value="2025-05-16T00:00">
      </div>

      <div class="col-md-3">
        <label class="form-label">Đến ngày</label>
        <input type="datetime-local" name="to_date" class="form-control" value="2025-05-16T23:59">
      </div>

      <div class="col-md-3">
        <label class="form-label">Làn</label>
        <select name="lane" class="form-select">
          <option selected>None selected</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Người dùng</label>
        <select name="user" class="form-select">
          <option selected>None selected</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Biển số hợp lệ</label>
        <select name="valid_plate" class="form-select">
          <option selected>None selected</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Nhóm thẻ</label>
        <select name="card_group" class="form-select">
          <option selected>None selected</option>
        </select>
      </div>

      <div class="col-12 d-flex align-items-center">
        <div class="form-check me-3">
          <input class="form-check-input" type="checkbox" id="checkTime" checked>
          <label class="form-check-label" for="checkTime">
            Tìm theo thời gian
          </label>
        </div>

        <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
        <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
        <button type="button" class="btn btn-success">Xuất Excel</button>
      </div>
    </form>
  </div>

  <!-- Bảng dữ liệu -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-light text-center">
        <tr>
          <th>STT</th>
          <th>CardNo</th>
          <th>Mã thẻ</th>
          <th>Biển số hợp lệ</th>
          <th>Biển số</th>
          <th>Thời gian vào</th>
          <th>Ảnh vào</th>
          <th>Nhóm thẻ</th>
          <th>Người dùng</th>
          <th>Làn vào</th>
          <th>Giám sát vào</th>
          <th>Ngày hết hạn</th>
          <th>Thời gian còn lại</th>
          <th>Phí gửi xe</th>
          <th>Xử lý</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <!-- Dữ liệu sẽ được render từ backend -->
        <tr>
          <td colspan="15">Không có dữ liệu</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
