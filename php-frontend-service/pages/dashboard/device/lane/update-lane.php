<?php
include_once __DIR__ . '/../../../../api/request.php';

// Lấy danh sách máy tính
$computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
$computerResponse = apiRequest('GET', $computerApiUrl);
$computers = json_decode($computerResponse, true);

// Lấy danh sách camera
$cameraApiUrl = 'http://localhost:8000/api/equipment/camera-list';
$cameraResponse = apiRequest('GET', $cameraApiUrl);
$cameras = json_decode($cameraResponse, true);

// Lấy danh sách nhóm xe
$getVehicleGroupUrl = 'http://localhost:8000/api/vehicle-group/get-all';
$vehicleGroupResponse = apiRequest('GET', $getVehicleGroupUrl);
$vehicleGroups = json_decode($vehicleGroupResponse, true);

// Lấy chi tiết làn
$laneId = $_GET['id'] ?? '';
$detailLaneApiUrl = 'http://localhost:8000/api/lane/find-lane/' . $laneId;
$detailLaneResponse = apiRequest('GET', $detailLaneApiUrl);
$detailLane = json_decode($detailLaneResponse, true);


// Chuẩn bị dữ liệu checked/selected
$vehicleTypeLeftArr = isset($detailLane['VehicleTypeLeft']) ? explode(',', $detailLane['VehicleTypeLeft']) : [];
$vehicleTypeRightArr = isset($detailLane['VehicleTypeRight']) ? explode(',', $detailLane['VehicleTypeRight']) : [];
$cardTypeLeftArr = isset($detailLane['CardTypeLeft']) ? explode(',', $detailLane['CardTypeLeft']) : [];
$cardTypeRightArr = isset($detailLane['CardTypeRight']) ? explode(',', $detailLane['CardTypeRight']) : [];

// Xử lý submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateLaneUrl = 'http://localhost:8000/api/lane/update-lane/' . $laneId;
    $data = [
        'LaneName' => $_POST['LaneName'] ?? '',
        'PCID' => $_POST['PCID'] ?? '',
        'LaneType' => $_POST['LaneType'] ?? 0,
        'C1' => $_POST['C1'] ?? '',
        'C2' => $_POST['C2'] ?? '',
        'C3' => $_POST['C3'] ?? '',
        'C4' => $_POST['C4'] ?? '',
        'C5' => $_POST['C5'] ?? '',
        'C6' => $_POST['C6'] ?? '',
        'CheckPlateLevelIn' => $_POST['CheckPlateLevelIn'] ?? 0,
        'CheckPlateLevelOut' => $_POST['CheckPlateLevelOut'] ?? 0,
        'CheckPlateOutOption2' => $_POST['CheckPlateOutOption2'] ?? 0,
        'OpenBarrieIn' => $_POST['OpenBarrieIn'] ?? 0,
        'OpenBarrieOption1' => $_POST['OpenBarrieOption1'] ?? 0,
        'OpenBarrieOption2' => $_POST['OpenBarrieOption2'] ?? 0,
        'VehicleTypeLeft' => isset($_POST['VehicleTypeLeft']) ? implode(',', $_POST['VehicleTypeLeft']) : '',
        'VehicleTypeRight' => isset($_POST['VehicleTypeRight']) ? implode(',', $_POST['VehicleTypeRight']) : '',
        'CardTypeLeft' => isset($_POST['CardTypeLeft']) ? implode(',', $_POST['CardTypeLeft']) : '',
        'CardTypeRight' => isset($_POST['CardTypeRight']) ? implode(',', $_POST['CardTypeRight']) : '',
        'IsLoop' => isset($_POST['IsLoop']) ? 1 : 0,
        'IsPrint' => isset($_POST['IsPrint']) ? 1 : 0,
        'IsFree' => isset($_POST['IsFree']) ? 1 : 0,
        'IsLED' => isset($_POST['IsLED']) ? 1 : 0,
        'Inactive' => isset($_POST['Inactive']) ? 1 : 0,
    ];
    $response = apiRequest('PUT', $updateLaneUrl, $data);
    $responseData = json_decode($response, true);

    if (isset($responseData['status']) && $responseData['status'] === 'success') {
        echo '<div class="alert alert-success">Cập nhật làn thành công!</div>';
        echo '<script>setTimeout(function() { window.location.href = "index.php?page=in-out-lane"; }, 1000);</script>';
    } else {
        echo '<div class="alert alert-danger">Lỗi khi cập nhật làn: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
    }
}
?>

<style>
    .form-section { border-right: 1px solid #ddd; }
    .form-label { font-weight: bold; }
    .btn-group-custom button { margin-right: 10px; }
    .permission-box { padding-left: 20px; }
    .dropdown-item:hover { background-color: transparent !important; }
</style>

<div class="container mt-5">
    <h4 class="mb-4">Cập nhật làn</h4>
    <form method="POST">
        <div class="row">
            <!-- Thông tin cơ bản -->
            <div class="col-md-10 mt-2 form-section">
                <div class="form-group">
                    <label class="form-label">Tên làn <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="LaneName" placeholder="Tên làn" value="<?= htmlspecialchars($detailLane['LaneName'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-10 mt-2 form-section">
                <label class="form-label">Máy tính <span class="text-danger">*</span></label>   
                <select class="form-control" name="PCID">
                    <option value="#">-- Chọn máy tính --</option>
                    <?php foreach ($computers as $computer): ?>
                        <option value="<?= $computer['PCID'] ?>" <?= ($detailLane['PCID'] ?? '') == $computer['PCID'] ? 'selected' : '' ?>>
                            <?= $computer['ComputerName'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-10 mt-2 form-section">
                <label class="form-label">Loại làn <span class="text-danger">*</span></label>   
                <select class="form-control" id="LaneType" name="LaneType">
                    <option value="">--Chọn Loại--</option>
                    <option value="0" <?= ($detailLane['LaneType'] ?? '') == 0 ? 'selected' : '' ?>>0. Vào</option>
                    <option value="1" <?= ($detailLane['LaneType'] ?? '') == 1 ? 'selected' : '' ?>>1. Ra</option>
                    <option value="2" <?= ($detailLane['LaneType'] ?? '') == 2 ? 'selected' : '' ?>>2. Vào - Ra</option>
                    <option value="3" <?= ($detailLane['LaneType'] ?? '') == 3 ? 'selected' : '' ?>>3. Vào - Vào</option>
                    <option value="4" <?= ($detailLane['LaneType'] ?? '') == 4 ? 'selected' : '' ?>>4. Ra - Ra</option>
                    <option value="5" <?= ($detailLane['LaneType'] ?? '') == 5 ? 'selected' : '' ?>>5. Vào - Ra 2</option>
                    <option value="6" <?= ($detailLane['LaneType'] ?? '') == 6 ? 'selected' : '' ?>>6. Quản lý trung tâm</option>
                    <option value="7" <?= ($detailLane['LaneType'] ?? '') == 7 ? 'selected' : '' ?>>7. Làn vào sử dụng FaceID</option>
                    <option value="8" <?= ($detailLane['LaneType'] ?? '') == 8 ? 'selected' : '' ?>>8. Làn ra sử dụng FaceID</option>
                    <option value="9" <?= ($detailLane['LaneType'] ?? '') == 9 ? 'selected' : '' ?>>9. #</option>
                </select>
            </div>

            <!-- Camera C1, C2, C3 -->
            <div class="col-md-10 mt-2 form-section">
                <div class="row">
                    <?php for ($ci = 1; $ci <= 3; $ci++): ?>
                        <div class="col-md-4">
                            <label class="form-label">C<?= $ci ?> <span class="text-danger">*</span></label>            
                            <select class="form-control" name="C<?= $ci ?>">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>" <?= ($detailLane['C' . $ci] ?? '') == $camera['CameraID'] ? 'selected' : '' ?>>
                                        <?= $camera['CameraName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Camera C4, C5, C6 -->
            <div class="col-md-10 mt-2 form-section" id="c4c5c6Section">
                <div class="row">
                    <?php for ($ci = 4; $ci <= 6; $ci++): ?>
                        <div class="col-md-4">
                            <label class="form-label">C<?= $ci ?> <span class="text-danger">*</span></label>            
                            <select class="form-control" name="C<?= $ci ?>">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>" <?= ($detailLane['C' . $ci] ?? '') == $camera['CameraID'] ? 'selected' : '' ?>>
                                        <?= $camera['CameraName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Kiểm tra Biển số lúc vào -->
            <div class="col-md-10 mt-2 form-section">      
                <label class="form-label">Kiểm tra Biển số lúc vào <span class="text-danger">*</span></label>  
                <select class="form-control" id="CheckPlateLevelIn" name="CheckPlateLevelIn">
                    <option value="1" <?= ($detailLane['CheckPlateLevelIn'] ?? '') == 1 ? 'selected' : '' ?>>So sánh >= 4 ký tự (Thẻ tháng)</option>
                    <option value="2" <?= ($detailLane['CheckPlateLevelIn'] ?? '') == 2 ? 'selected' : '' ?>>So sánh tất cả ký tự (Thẻ tháng)</option>
                    <option value="0" <?= ($detailLane['CheckPlateLevelIn'] ?? '') == 0 ? 'selected' : '' ?>>Không so sánh (Thẻ tháng)</option>
                </select>
            </div>

            <!-- Kiểm tra Biển số lúc ra -->
            <div class="col-md-10 mt-2 form-section">
                <label class="form-label">Kiểm tra Biển số lúc ra <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" id="CheckPlateLevelOut" name="CheckPlateLevelOut">
                            <option value="1" <?= ($detailLane['CheckPlateLevelOut'] ?? '') == 1 ? 'selected' : '' ?>>So sánh >= 4 ký tự</option>
                            <option value="2" <?= ($detailLane['CheckPlateLevelOut'] ?? '') == 2 ? 'selected' : '' ?>>So sánh tất cả ký tự</option>
                            <option value="0" <?= ($detailLane['CheckPlateLevelOut'] ?? '') == 0 ? 'selected' : '' ?>>Không so sánh</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" id="CheckPlateOutOption2" name="CheckPlateOutOption2">
                            <option value="3" <?= ($detailLane['CheckPlateOutOption2'] ?? '') == 3 ? 'selected' : '' ?>>So sánh biển đăng ký, biển vào, biển ra</option>
                            <option value="4" <?= ($detailLane['CheckPlateOutOption2'] ?? '') == 4 ? 'selected' : '' ?>>Chỉ so sánh biển vào, biển ra</option>
                            <option value="5" <?= ($detailLane['CheckPlateOutOption2'] ?? '') == 5 ? 'selected' : '' ?>>Chỉ so sánh biển ra, biển đăng ký</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Mở barie vào -->
            <div class="col-md-10 mt-2 form-section">
                <label class="form-label">Mở barie vào <span class="text-danger">*</span></label>
                <select class="form-control" id="OpenBarrieIn" name="OpenBarrieIn">
                    <option value="0" <?= ($detailLane['OpenBarrieIn'] ?? '') == 0 ? 'selected' : '' ?>>Không mở barrie</option>
                    <option value="2" <?= ($detailLane['OpenBarrieIn'] ?? '') == 2 ? 'selected' : '' ?>>Tự mở với mọi loại thẻ</option>
                    <option value="3" <?= ($detailLane['OpenBarrieIn'] ?? '') == 3 ? 'selected' : '' ?>>Thẻ tháng đúng BS đăng ký và thẻ lượt</option>
                    <option value="8" <?= ($detailLane['OpenBarrieIn'] ?? '') == 8 ? 'selected' : '' ?>>Chỉ mở với thẻ tháng</option>
                </select>
            </div>

            <!-- Mở barie ra -->
            <div class="col-md-10 mt-2 form-section">
                <label class="form-label">Mở barie ra <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" id="OpenBarrieOption1" name="OpenBarrieOption1">
                            <option value="0" <?= ($detailLane['OpenBarrieOption1'] ?? '') == 0 ? 'selected' : '' ?>>Không mở barrie</option>
                            <option value="4" <?= ($detailLane['OpenBarrieOption1'] ?? '') == 4 ? 'selected' : '' ?>>Chỉ mở khi BS vào ra giống nhau</option>
                            <option value="5" <?= ($detailLane['OpenBarrieOption1'] ?? '') == 5 ? 'selected' : '' ?>>Mở với mọi trường hợp</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" id="OpenBarrieOption2" name="OpenBarrieOption2">
                            <option value="2" <?= ($detailLane['OpenBarrieOption2'] ?? '') == 2 ? 'selected' : '' ?>>Tự mở với mọi loại thẻ</option>
                            <option value="6" <?= ($detailLane['OpenBarrieOption2'] ?? '') == 6 ? 'selected' : '' ?>>Chỉ mở với thẻ tháng đúng BS đăng ký</option>
                            <option value="7" <?= ($detailLane['OpenBarrieOption2'] ?? '') == 7 ? 'selected' : '' ?>>Chỉ mở với thẻ lượt</option>
                            <option value="8" <?= ($detailLane['OpenBarrieOption2'] ?? '') == 8 ? 'selected' : '' ?>>Chỉ mở với thẻ tháng</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Loại xe làn trái và phải -->
            <div class="col-md-10 mt-4 mb-3 form-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLeft" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Loại xe làn trái <span class="badge badge-light text-dark ml-1"><?= count($vehicleTypeLeftArr) ?> selected</span>
                            </button>
                            <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuLeft">
                                <?php foreach ($vehicleGroups as $vehicleGroup): ?>
                                    <label class="dropdown-item" style="color: white !important;">
                                        <input type="checkbox" name="VehicleTypeLeft[]" value="<?= $vehicleGroup['VehicleGroupID'] ?>" <?= in_array($vehicleGroup['VehicleGroupID'], $vehicleTypeLeftArr) ? 'checked' : '' ?>>
                                        <?= $vehicleGroup['VehicleGroupName'] ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuRight" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Loại xe làn phải <span class="badge badge-light text-dark ml-1"><?= count($vehicleTypeRightArr) ?> selected</span>
                            </button>
                            <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuRight">
                                <?php foreach ($vehicleGroups as $vehicleGroup): ?>
                                    <label class="dropdown-item" style="color: white !important;">
                                        <input type="checkbox" name="VehicleTypeRight[]" value="<?= $vehicleGroup['VehicleGroupID'] ?>" <?= in_array($vehicleGroup['VehicleGroupID'], $vehicleTypeRightArr) ? 'checked' : '' ?>>
                                        <?= $vehicleGroup['VehicleGroupName'] ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loại thẻ làn trái và phải -->
            <div class="col-md-10 mt-4 mb-3 form-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLeftCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Loại thẻ làn trái <span class="badge badge-light text-dark ml-1"><?= count($cardTypeLeftArr) ?> selected</span>
                            </button>
                            <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuLeftCard">
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeLeft[]" value="1" <?= in_array('1', $cardTypeLeftArr) ? 'checked' : '' ?>> Thuê bao
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeLeft[]" value="2" <?= in_array('2', $cardTypeLeftArr) ? 'checked' : '' ?>> Vé lượt
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeLeft[]" value="3" <?= in_array('3', $cardTypeLeftArr) ? 'checked' : '' ?>> Vé miễn phí
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeLeft[]" value="4" <?= in_array('4', $cardTypeLeftArr) ? 'checked' : '' ?>> Thẻ vip
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuRightCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Loại thẻ làn phải <span class="badge badge-light text-dark ml-1"><?= count($cardTypeRightArr) ?> selected</span>
                            </button>
                            <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuRightCard">
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeRight[]" value="1" <?= in_array('1', $cardTypeRightArr) ? 'checked' : '' ?>> Thuê bao
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeRight[]" value="2" <?= in_array('2', $cardTypeRightArr) ? 'checked' : '' ?>> Vé lượt
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeRight[]" value="3" <?= in_array('3', $cardTypeRightArr) ? 'checked' : '' ?>> Vé miễn phí
                                </label>
                                <label class="dropdown-item" style="color: white !important;">
                                    <input type="checkbox" name="CardTypeRight[]" value="4" <?= in_array('4', $cardTypeRightArr) ? 'checked' : '' ?>> Thẻ vip
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Các checkbox -->
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" name="IsLoop" id="isLoopCheck" <?= $detailLane['IsLoop']  == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="isLoopCheck">Sử dụng vòng (loop)</label>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" name="IsPrint" id="isPrintCheck" <?= $detailLane['IsPrint']  == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="isPrintCheck">Tự động in biên lai</label>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" name="IsFree" id="isFreeCheck" <?= $detailLane['IsFree']  == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="isFreeCheck">Nút miễn phí cho xe ưu tiên</label>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" name="IsLED" id="isLEDCheck" <?= $detailLane['IsLED']  == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="isLEDCheck">Hiển thị LED</label>
            </div>
            <div class="form-check mt-3">
                <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck" <?= $detailLane['Inactive']  == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4 btn-group-custom">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
            <a href="index.php?page=in-out-lane" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleCameraSections() {
        var laneType = $('#LaneType').val();
        var c4c5c6Section = $('#c4c5c6Section');
        var dualLaneTypes = ['2', '3', '4', '5'];
        if (dualLaneTypes.includes(laneType)) {
            c4c5c6Section.show();
        } else {
            c4c5c6Section.hide();
        }
    }
    $(document).ready(function() {
        toggleCameraSections();
        $('#LaneType').change(toggleCameraSections);
    });
</script>