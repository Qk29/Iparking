<?php 
    include_once __DIR__ . '/../../../../api/request.php';

    // call api get-lane
    $getLanesUrl  = 'http://localhost:8000/api/lane/get-all';
    $laneResponse  = apiRequest('GET', $getLanesUrl );
    $lanes  = json_decode($laneResponse, true);
    
    //call api get-vehicle-group
    $getVehicleGroupUrl  = 'http://localhost:8000/api/vehicle-group/get-all';
    
    $vehicleGroupResponse  = apiRequest('GET', $getVehicleGroupUrl );
    $vehicleGroups  = json_decode($vehicleGroupResponse, true);
   

    $addCardGroupUrl = 'http://localhost:8000/api/category/add-card-group';
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'CardGroupName' => $_POST['CardGroupName'],
            'Description' => $_POST['Description'],
            'CardType' => $_POST['CardType'],
            'VehicleGroupID' => $_POST['VehicleGroupID'],
            'ValidTimeStart' => $_POST['ValidTimeStart'],
            'ValidTimeEnd' => $_POST['ValidTimeEnd'],
            'Formulation' => $_POST['Formulation'],
            'FreeTime' => $_POST['FreeTime'] ?? 0,
            'IsHaveMoneyExcessTime' => isset($_POST['IsHaveMoneyExcessTime']) ? 1 : 0,
            'EnableFree' => isset($_POST['EnableFree']) ? 1 : 0,
            'DayTimeFrom' => $_POST['DayTimeFrom'],
            'DayTimeTo' => $_POST['DayTimeTo'],
            'EachFee' => $_POST['EachFee'],
            'SortOrder' => $_POST['SortOrder'],
            'IsCheckPlate' => isset($_POST['IsCheckPlate']) ? 1 : 0,
            'RestrictedNumber' => $_POST['RestrictedNumber'] ?? 0,
            'IsHaveMoneyExpiredDate' => isset($_POST['IsHaveMoneyExpiredDate']) ? 1 : 0,
            'Inactive' => isset($_POST['Inactive']) ? 1 : 0,
            'IsSpecialGroup' => isset($_POST['IsSpecialGroup']) ? 1 : 0,
            'isLockingCharge' => isset($_POST['isLockingCharge']) ? 1 : 0,
            'listLanes' => $_POST['listLanes'],
            'Time0' => isset($_POST['Time0']) ? $_POST['Time0'] : 0,
            'Time1' => isset($_POST['Time1']) ? $_POST['Time1'] : 0,
            'Time2' => isset($_POST['Time2']) ? $_POST['Time2'] : 0,
            'Time3' => isset($_POST['Time3']) ? $_POST['Time3'] : 0,
            'Time4' => isset($_POST['Time4']) ? $_POST['Time4'] : 0,
            'Time5' => isset($_POST['Time5']) ? $_POST['Time5'] : 0,
            'Block0' => isset($_POST['Block0']) ? $_POST['Block0'] : 0,
            'Block1' => isset($_POST['Block1']) ? $_POST['Block1'] : 0,
            'Block2' => isset($_POST['Block2']) ? $_POST['Block2'] : 0,
            'Block3' => isset($_POST['Block3']) ? $_POST['Block3'] : 0,
            'Block4' => isset($_POST['Block4']) ? $_POST['Block4'] : 0,
            'Block5' => isset($_POST['Block5']) ? $_POST['Block5'] : 0,
            'TimePeriods' => $_POST['TimePeriods'] ?? '00:00-00:00-00:00-00:00',
            'Costs' => $_POST['Costs'] ?? '0'
        ];

       
;
        // Gửi yêu cầu POST đến API
        $response = apiRequest('POST', $addCardGroupUrl, $data);
        if (empty($response)) {
            echo "API trả về response rỗng";
        } else {
            echo "Response từ API: " . htmlspecialchars($response);
        }

        var_dump($response);
        // Kiểm tra phản hồi từ API

        
        // Xử lý phản hồi từ API
        $responseData = json_decode($response, true);
        if ($responseData && isset($responseData['success']) && $responseData['success'] == true) {
            echo "<script>alert('Tạo mới nhóm thẻ thành công!');</script>";
        } else { 
            echo "<script>alert('Có lỗi: " . $responseData['message'] . "');</script>";
        }
    }
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
            <input type="hidden" name="TimePeriods" value="00:00-00:00-00:00-00:00-00:00">
            <input type="hidden" name="Costs" value="0">
        </div>

        <div class="form-group row">      
            <label class="form-label">Loại thẻ <span class="text-danger">*</span></label>  
            <select class="form-control col-md-5 ml-3"  name="CardType" id="CardType">
                <option value="0">Thuê bao</option>
                <option value="1">Vé lượt</option>
                <option value="2">Vé miễn phí</option>
                <option value="3">Vé vip</option>
            </select>
            <div class="col-md-5">
                <input type="checkbox" class="" name="IsHaveMoneyExcessTime" id="IsHaveMoneyExcessTime" value="true">
                <span>Tính tiền thẻ thuê quá giờ</span>
                
            </div>

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
        <label class="form-label">Phân làn cho nhóm thẻ<span class="text-danger">*</span></label>
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

                <select multiple class="form-control" id="nonselected" size="8">
                    <?php foreach($lanes as $lane): ?>
                        <option value="<?= $lane['LaneID'] ?>"><?= $lane['LaneName'] ?></option>
                    <?php endforeach; ?>
                </select>
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
                    
                </select>
            </div>
        </div>

        <!-- Select ẩn và hidden input để submit -->
        <select multiple class="d-none" name="duallistbox_demo1[]" id="cbLaneList"></select>
        <input type="hidden" id="listLanes" name="listLanes" value="">
    </div>

    </div>

    <div class="form-group mt-3 row">
    <label class="col-form-label form-label col-md-2">Thời gian hoạt động<span class="text-danger">*</span></label>
    <div class="col-md-3">
        <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control timepicker valid" name="ValidTimeStart" value="00:00">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-clock"></i></span>
        </div>
        </div>
    </div>
    <label class="col-form-label col-md-1 text-center">đến</label>
    <div class="col-md-3">
        <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control timepicker valid" name="ValidTimeEnd" value="23:59">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-clock"></i></span>
        </div>
        </div>
    </div>

    <div class="form-group row mt-5">
        <div class="col-md-5">
        <input type="checkbox" name="EnableFree" id="EnableFree">
        <span for=""> Miễn phí trong khoảng thời gian</span>
        </div>

        <div class="col-md-5">
        <input type="text" class="form-control" name="FreeTime" id="FreeTime" value="0">
        </div>
    </div>

    <div class="form-group mt-3 row">
    <label class="col-form-label form-label col-md-2">TG ban ngày(TG hợp lệ thẻ thuê bao)<span class="text-danger">*</span> </label>
    <div class="col-md-3">
        <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control timepicker valid" name="DayTimeFrom" value="00:00">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-clock"></i></span>
        </div>
        </div>
    </div>
    <label class="col-form-label col-md-1 text-center">đến</label>
    <div class="col-md-3 ">
        <div class="input-group bootstrap-timepicker">
        <input type="text" class="form-control timepicker valid" name="DayTimeTo" value="23:59">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-clock"></i></span>
        </div>
        </div>
    </div>
   

    <div class="form-group mt-3">
        <label class="form-label" for="">Tính phí theo<span class="text-danger">*</span></label>
        <select name="Formulation" id="Formulation" class="form-control" onchange="OpenFormulationBox()">
            <option value="0">Lượt</option>
            <option value="1">Block</option>
            <option value="2">Khoảng thời gian</option>
        </select>
        <div id="blockSection" class="row mt-3" style="display: none;">
        <div class="col-md-6">
            <label>Block 0</label>
            <input type="text" name="Block0" class="form-control" value="0">
            <label>Block 1</label>
            <input type="text" name="Block1" class="form-control" value="0">
            <label>Block 2</label>
            <input type="text" name="Block2" class="form-control" value="0">
            <label>Block 3</label>
            <input type="text" name="Block3" class="form-control" value="0">
            <label>Block 4</label>
            <input type="text" name="Block4" class="form-control" value="0">
            <label>Block 5</label>
            <input type="text" name="Block5" class="form-control" value="0">
        </div>
        <div class="col-md-6">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time0" class="form-control" value="0">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time1" class="form-control" value="0">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time2" class="form-control" value="0">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time3" class="form-control" value="0">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time4" class="form-control" value="0">
            <label>Thời gian (phút)</label>
            <input type="text" name="Time5" class="form-control" value="0">
        </div>
</div>
    </div>

    <div class="form-group mt-3" id="veluot">
        <label class="form-label" for="">Phí lượt<span class="text-danger">*</span></label>
        <input type="text" id="EachFee" name="EachFee" value="0" class="form-control" placeholder="Nhập phí lượt">
    </div>

    <div class="form-group mt-3" id="FeeHidden">
        <input type="hidden" id="EachFeeHidden" name="EachFeeHidden" value="0" class="form-control" placeholder="Nhập phí lượt">
    </div>

    <div class="form-group mt-3">
        <label class="form-label" for="">STT<span class="text-danger">*</span></label>
        <input type="text" id="SortOrder" name="SortOrder" class="form-control" placeholder="">
    </div>

    <div class="form-group row mt-3">
        <div class="col-md-5">
        <label class="form-label" for="">Số lượng xe giới hạn<span class="text-danger">*</span></label>
        <input type="number" id="RestrictedNumber" name="RestrictedNumber" class="form-control">
        </div>
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
      <a href="index.php?page=card-category" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
  </form>
</div>
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

        input.val(vals.join(',') + (vals.length ? ',' : null));
    }
});

// Mở hoặc đóng phần tử dựa trên giá trị của Formulation
    function OpenFormulationBox(){
        var selectedValue = document.getElementById("Formulation").value;
        var blockSection = document.getElementById("blockSection");
        var veluot = document.getElementById('veluot');
        var feeHidden = document.getElementById("FeeHidden");
        var eachFeeInput = document.getElementById("EachFee");
        var eachFeeHiddenInput = document.getElementById("EachFeeHidden");

        if(selectedValue === "1"){
            veluot.style.display = "none";
            blockSection.style.display = "flex";
            feeHidden.style.display = "block";
            eachFeeHiddenInput.name = "EachFee";
            eachFeeInput.name = "";
            eachFeeHiddenInput.value = "0";

        }else{
            blockSection.style.display = "none";
        }
    }
</script>
</body>
</html>



