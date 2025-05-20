<?php 
    include_once __DIR__ . '/../../../api/request.php';

    // call api get-lane
    $getLanesUrl  = 'http://localhost:8000/api/lane/get-all';
    $laneResponse  = apiRequest('GET', $getLanesUrl );
    $lanes  = json_decode($laneResponse, true);
    
    //call api get-vehicle-group
    $getVehicleGroupUrl  = 'http://localhost:8000/api/vehicle-group/get-all';
    $vehicleGroupResponse  = apiRequest('GET', $getVehicleGroupUrl );
    $vehicleGroups  = json_decode($vehicleGroupResponse, true);
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tạo mới người dùng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .form-section {
      border-right: 1px solid #ddd;
    }
    .form-label {
      font-weight: bold;
    }
    .btn-group-custom button {
      margin-right: 10px;
    }
    .permission-box {
      padding-left: 20px;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h4 class="mb-4">Thêm mới nhóm thẻ</h4>
  <form method="POST">
    <div class="row">
      <!-- Thông tin cơ bản -->
      <div class="col-md-10 form-section">
        <div class="form-group">
          <label class="form-label">Tên nhóm thẻ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="CardGroupName" placeholder="Tên nhóm thẻ">
        </div>

        <div class="form-group">
          <label class="form-label">Mô tả <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Description" placeholder="Mô tả nhóm thẻ">
        </div>

        <div class="form-group">      
            <label class="form-label">Loại thẻ <span class="text-danger">*</span></label>  
            <select class="form-control"  name="CardType" id="CardType">
            <option value="0">Thuê bao</option>
            <option value="1">Vé lượt</option>
            <option value="2">Vé miễn phí</option>
            <option value="3">Vé vip</option>
        </select>
       </div>

        <div class="form-group">      
            <label class="form-label">Nhóm xe <span class="text-danger">*</span></label>  
            <select class="form-control"  name="VehicleGroupID" id="VehicleGroupID">
            <?php foreach($vehicleGroups as $vehicleGroup): ?>
                <option value="<?= $vehicleGroup['VehicleGroupID'] ?>"><?= $vehicleGroup['VehicleGroupName'] ?></option>  
            <?php endforeach; ?>  
            
        </select>
       </div>

       

    <div class="form-group">
        <label class="form-label">Phân làn cho nhóm thẻ</label>
        <div class="row">
            <!-- Danh sách chưa chọn -->
            <div class="col-md-5">
                <label>Empty list</label>
                <input class="form-control mb-2 filter-input" data-target="nonselected" type="text" placeholder="Filter">

                <div class="btn-group d-flex mb-2">
                    <button type="button" class="btn btn-outline-primary w-50 moveall">
                        <i class="fa fa-arrow-right"></i><i class="fa fa-arrow-right"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary w-50 move">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>

                <select multiple class="form-control" id="nonselected" size="8"></select>
            </div>

            <!-- Spacer -->
            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                <!-- để trống hoặc thêm mô tả nếu cần -->
            </div>

            <!-- Danh sách đã chọn -->
            <div class="col-md-5">
                <label>Showing all</label>
                <input class="form-control mb-2 filter-input" data-target="selected" type="text" placeholder="Filter">

                <div class="btn-group d-flex mb-2">
                    <button type="button" class="btn btn-outline-primary w-50 remove">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary w-50 removeall">
                        <i class="fa fa-arrow-left"></i><i class="fa fa-arrow-left"></i>
                    </button>
                </div>

                <select multiple class="form-control" id="selected" size="8">
                    <?php foreach($lanes as $lane): ?>
                        <option value="<?= $lane['LaneID'] ?>"><?= $lane['LaneName'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Select ẩn và hidden input để submit -->
        <select multiple class="d-none" name="duallistbox_demo1[]" id="cbLaneList"></select>
        <input type="hidden" id="listLanes" name="listLanes" value="1,">
    </div>

    </div>

    <div class="form-group mt-3 row">
    <label class="col-form-label col-md-2">Thời gian hoạt động</label>
    <div class="col-md-3">
        <input type="time" class="form-control" name="ValidTimeStart" value="00:00">
    </div>
    <label class="col-form-label col-md-1 text-center">đến</label>
    <div class="col-md-3">
        <input type="time" class="form-control" name="ValidTimeEnd" value="23:59">
    </div>

    <div class="form-group row mt-5">
        <div class="col-md-5">
        <input type="checkbox" name="EnableFree" id="EnableFree">
        <span for=""> Miễn phí trong khoảng thời gian</span>
        </div>

        <div class="col-md-5">
        <input type="time" class="form-control" name="FreeTime" id="FreeTime" value="23:59">
        </div>
    </div>

    <div class="form-group mt-3 row">
    <label class="col-form-label col-md-2">TG ban ngày(TG hợp lệ thẻ thuê bao) </label>
    <div class="col-md-3">
        <input type="time" class="form-control" name="time_from" value="00:00">
    </div>
    <label class="col-form-label col-md-1 text-center">đến</label>
    <div class="col-md-3">
        <input type="time" class="form-control" name="time_to" value="23:59">
    </div>
   

    <div class="form-group mt-3">
        <label class="form-label" for="">Tính phí theo</label>
        <select name="" id="" class="form-control">
            <option value="0">Lượt</option>
            <option value="1">Block</option>
            <option value="2">Khoảng thời gian</option>
        </select>
    </div>

    <div class="form-group mt-3">
        <label class="form-label" for="">Phí lượt</label>
        <input type="text" id="EachFee" name="EachFee" class="form-control" placeholder="Nhập phí lượt">
    </div>

    <div class="form-group mt-3">
        <label class="form-label" for="">STT</label>
        <input type="text" id="SortOder" name="SortOder" class="form-control" placeholder="Nhập phí lượt">
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-5">
        <input type="checkbox" name="IsCheckPlate" id="IsCheckPlate">
        <span for=""> Kiểm tra biển số xe</span>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-5">
        <input type="checkbox" name="IsHaveMoneyExpiredDate" id="IsHaveMoneyExpiredDate">
        <span for=""> Tính tiền thuê bao ngừng sử dụng</span>
        </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-md-5">
        <input type="checkbox" name="Inactive" id="Inactive">
        <span for=""> Ngừng sử dụng</span>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-5">
        <input type="checkbox" name="IsSpecialGroup" id="IsSpecialGroup">
        <span for=""> Sử dụng mái che</span>
        </div>
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-5">
        <input type="checkbox" name="isLockingCharge" id="isLockingCharge">
        <span for=""> Tính tiền gửi xe với thẻ bị khoá</span>
        </div>
    </div>


    </div>

    

    <!-- Buttons -->
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=user-system" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
  </form>
</div>
</body>
</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.move').click(function () {
        $('#nonselected option:selected').each(function () {
            $(this).remove().appendTo('#selected');
        });
        updateHidden();
    });

    $('.moveall').click(function () {
        $('#nonselected option').each(function () {
            $(this).remove().appendTo('#selected');
        });
        updateHidden();
    });

    $('.remove').click(function () {
        $('#selected option:selected').each(function () {
            $(this).remove().appendTo('#nonselected');
        });
        updateHidden();
    });

    $('.removeall').click(function () {
        $('#selected option').each(function () {
            $(this).remove().appendTo('#nonselected');
        });
        updateHidden();
    });

    //  Lọc option khi người dùng gõ vào ô input
    $('.filter-input').on('input', function () {
        const keyword = $(this).val().toLowerCase();
        const target = $(this).data('target');
        const selectBox = $(`#${target} option`);

        selectBox.each(function () {
            const text = $(this).text().toLowerCase();
            if (text.includes(keyword)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    function updateHidden() {
        let selected = $('#selected option');
        let cb = $('#cbLaneList');
        let input = $('#listLanes');

        cb.empty();
        let vals = [];

        selected.each(function () {
            let val = $(this).val();
            let text = $(this).text();
            cb.append(`<option value="${val}" selected>${text}</option>`);
            vals.push(val);
        });

        input.val(vals.join(',') + (vals.length ? ',' : ''));
    }
});
</script>
