<?php 
    include_once __DIR__ . '/../../../../api/request.php';  

    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);

    $ledId = $_GET['id'];

    // call api to get detail led
    $detailComputerApiUrl = 'http://localhost:8000/api/equipment/find-led/'. $ledId;
    $detailComputerResponse = apiRequest('GET', $detailComputerApiUrl);
    $detailComputer = json_decode($detailComputerResponse, true);


    // call api to update Led
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ledData = [
            'LedName' => $_POST['LEDName'] ?? '',
            'PCID' => $_POST['PCID'] ?? '',
            'Address' => $_POST['Address'] ?? '',
            'Comport' => $_POST['Comport'] ?? '',
            'Baudrate' => $_POST['Baudrate'] ?? '',
           'RowNumber' => $_POST['RowNumber'] ?? '',
            'SideIndex' => $_POST['SideIndex'] ?? '',
            'LedType' => $_POST['LedType'] ?? '',
            'EnableLED' => isset($_POST['EnableLED']) ? 1 : 0
        ];

        

        $apiAddLed = 'http://localhost:8000/api/equipment/update-led/' . $ledId;
        $apiResponse = apiRequest('PUT', $apiAddLed, $ledData);
        var_dump($apiResponse);
        $responseData = json_decode($apiResponse, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {
            echo '<div class="alert alert-success">Cập nhật LED thành công!</div>';
            // Optionally redirect or reload the page
            echo '<script>setTimeout(function() { window.location.href = "index.php?page=led-display"; }, 200);</script>';
            
        } else {
            echo '<div class="alert alert-danger">Lỗi khi cập nhật LED: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }
    }
   
?>


<div class="container mt-5">
  <h2 class="mb-4">Thêm mới LED</h2>
  <form method="POST">
    
      <!-- Thông tin cơ bản -->
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="LEDName" value="<?= $detailComputer['LEDName'] ?? '' ?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Máy tính<span class="text-danger">*</span></label>   
        <select class="form-select" name="PCID" id="">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>"  <?= $detailComputer['PCID'] == $computer['PCID'] ? 'selected' : '' ?>><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">COM(IP)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Comport" value="<?= $detailComputer['Comport'] ?? '' ?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Baudrate(Port)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Baudrate" value="<?= $detailComputer['Baudrate'] ?? '' ?>" >
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Địa chỉ(232/485/422)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Address" value="<?= $detailComputer['Address'] ?? '' ?>" >
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Số dòng<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="RowNumber" value="<?= $detailComputer['RowNumber'] ?? '' ?>"  >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Giao diện<span class="text-danger">*</span></label>   
        <select class="form-control long-select"  id="SideIndex" name="SideIndex">
            <option>-- Lựa chọn --</option>
            <option value="0" <?= $detailComputer['SideIndex'] == 0 ? 'selected' : '' ?>>Trái</option>
            <option value="1" <?= $detailComputer['SideIndex'] == 1 ? 'selected' : '' ?>>Phải</option>
            <option value="2" <?= $detailComputer['SideIndex'] == 2 ? 'selected' : '' ?>>All</option>
            
        </select>
    </div>
   
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Thiết bị hiển thị<span class="text-danger">*</span></label>
            <select class="form-control valid" id="LedType" name="LedType"><option value="--Lựa chọn--">--Lựa chọn--</option>
                <option value="DSP840" <?= $detailComputer['LedType'] == 'DSP840' ? 'selected' : '' ?>>DSP840</option>
                <option value="FUTECH" <?= $detailComputer['LedType'] == 'FUTECH' ? 'selected' : '' ?>>FUTECH</option>
                <option value="FAT810" <?= $detailComputer['LedType'] == 'FAT810' ? 'selected' : '' ?>>FAT810</option>
                <option value="FUTECH2" <?= $detailComputer['LedType'] == 'FUTECH2' ? 'selected' : '' ?>>FUTECH2</option>
                <option value="FUTECH2LINE" <?= $detailComputer['LedType'] == 'FUTECH2LINE' ? 'selected' : '' ?>>FUTECH2LINE</option>
                <option value="PGS_LED" <?= $detailComputer['LedType'] == 'PGS_LED' ? 'selected' : '' ?>>PGS_LED</option>
                <option value="ATPRO" <?= $detailComputer['LedType'] == 'ATPRO' ? 'selected' : '' ?>>ATPRO</option>
                <option value="P10_RED" <?= $detailComputer['LedType'] == 'P10_RED' ? 'selected' : '' ?>>P10_RED</option>
                <option value="P10_Fullcolor" <?= $detailComputer['LedType'] == 'P10_Fullcolor' ? 'selected' : '' ?>>P10_Fullcolor</option>
                <option value="P7_62_RGY" <?= $detailComputer['LedType'] == 'P7_62_RGY' ? 'selected' : '' ?>>P7_62_RGY</option>
                <option value="KPS_001" <?= $detailComputer['LedType'] == 'KPS_001' ? 'selected' : '' ?>>KPS_001</option>
                <option value="LED_Reversible" <?= $detailComputer['LedType'] == 'LED_Reversible' ? 'selected' : '' ?>>LED_Reversible</option>
                
            </select>
        </div>
    </div>  

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="EnableLED" id="inactiveCheck" <?= $detailComputer['EnableLED'] == 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="inactiveCheck">Kích hoạt</label>
    </div>

    </div>

    
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=controller" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>



    