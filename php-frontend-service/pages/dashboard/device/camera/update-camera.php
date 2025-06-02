

<?php 
    include_once __DIR__ . '/../../../../api/request.php';  


    // call api to find camera by ID
    $cameraId = $_GET['id'] ?? null;
    $findCameraApiUrl = 'http://localhost:8000/api/equipment/find-camera/' . $cameraId;
    $cameraResponse = apiRequest('GET', $findCameraApiUrl);
    $camera = json_decode($cameraResponse, true);
    if (!$camera) {
        echo "<div class='alert alert-danger'>Không tìm thấy camera với ID: $cameraId</div>";
        exit;
    }

    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);


   $cameraTypes = [
    "Geovision", "Panasonic i-Pro", "Axis", "Secus", "Shany-Stream1", "Shany-Stream21",
    "Vivotek", "Lilin", "Messoa", "Entrovision", "Sony", "Bosch", "Vantech", "SC330",
    "SecusFFMPEG", "CNB", "HIK", "Enster", "Afidus", "Dahua", "ITX", "Hanse", "Samsung",
    "Tiandy", "Camtron", "HIVIZ", "DMAX"
    ];

    $streamTypes = [
        "H264", "MJPEG", "PlayFile", "Local Video Capture Device", "JPEG", "MPEG4", "Onvif"
    ];


    $resolutionOptions = [
        "1920x1080", "1280x720", "1280x960","1280x1024", "1600x1200", "2048x1536", "720x480"
    ];


    $sdkOptions = [
        "KztekSDK2", "AForgeSDK", "AxisSDK", "GeoSDK", "ScSDK", "FFMPEG", "VLC", 
        "KztekSDK", "HIKSDK", "TiandySDK", "DahuaSDK"
    ];

    // call api to update camera
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'CameraID' => $cameraId,
            'CameraName' => $_POST['CameraName'],
            'CameraType' => $_POST['CameraType'],
            'PCID' => $_POST['computer'],
            'HttpURL' => $_POST['HttpURL'],
            'HttpPort' => $_POST['HttpPort'],
            'RtspPort' => $_POST['RtspPort'],
            'UserName' => $_POST['UserName'],
            'Password' => $_POST['Password'],
            'Channel' => $_POST['Channel'],
            'StreamType' => $_POST['StreamType'],
            'Resolution' => $_POST['Resolution'],
            'FrameRate' => $_POST['FrameRate'],
            'SDK' => $_POST['SDK'],
            'EnableRecording' => isset($_POST['EnableRecording']) ? 0 : 1,
            'Inactive' => isset($_POST['Inactive']) ? 0 : 1,
        ];

       

        $updateCameraApiUrl = 'http://localhost:8000/api/equipment/update-camera/' . $cameraId;
        $updateResponse = apiRequest('PUT', $updateCameraApiUrl, $data);
        $updateResult = json_decode($updateResponse, true);
        var_dump($updateResult);

        if ($updateResult && isset($updateResult['status']) && $updateResult['status'] === 'success') {
        echo "<div class='alert alert-success'>Cập nhật camera thành công!</div>";
        } else {
            $errorMessage = $updateResult['message'] ?? 'Cập nhật camera thất bại!';
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }

       

       
    }
    
    
    
    

   
?>

<div class="container mt-5">
  <h2 class="mb-4">Cập nhật camera</h2>
  <form method="POST">
  
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên camera<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="CameraName" placeholder="Tên camera" value="<?= $camera['CameraName'] ?>" >
        </div>
      </div>
   

    <!-- Thông tin cơ bản -->
      

         <div class="col-md-5 mt-2 form-section">
            <label class="form-label">Loại camera<span class="text-danger">*</span></label>   
            <select class="form-control valid" id="CameraType" name="CameraType">
                <?php foreach($cameraTypes as $cameraType) : ?>
                <option value="<?= $cameraType ?>" <?= $camera['CameraType'] == $cameraType ? 'selected' : '' ?>><?= $cameraType ?></option>
                <?php endforeach; ?>
            </select>
         </div>



    <div class="col-md-5 mt-2 form-section">
            <label class="form-label">Tên máy tính<span class="text-danger">*</span></label>   
            <select class="form-select" name="computer" id="">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>" <?= $computer['PCID'] == $camera['PCID'] ? 'selected' : '' ?>><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
         </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Địa chỉ IP <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="HttpURL" value="<?= $camera['HttpURL'] ?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Cổng HTTP<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="HttpPort" value="<?= $camera['HttpPort'] ?>" >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Cổng RTSP<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="RtspPort" value="<?= $camera['RtspPort'] ?>" >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên đăng nhập<span class="text-danger">*</span></label>
          <input type="password" class="form-control" name="UserName" value="<?= $camera['UserName'] ?>" >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Mật khẩu<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Password"  value="<?= $camera['Password'] ?>" >
        </div>
      </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Kênh<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="Channel"  value="<?= $camera['Channel'] ?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Định dạng truyền ảnh<span class="text-danger">*</span></label>
        <select class="form-control " id="StreamType" name="StreamType">
            <?php foreach($streamTypes as $streamType) : ?>
                <option value="<?= $streamType ?>" <?= $camera['StreamType'] == $streamType ? 'selected' : '' ?>><?= $streamType ?></option>
            <?php endforeach; ?>
        </select>
        
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Độ phân giải<span class="text-danger">*</span></label>
        <select class="form-control " id="Resolution" name="Resolution" >
            <?php foreach($resolutionOptions as $resolution) : ?>
                <option value="<?= $resolution ?>" <?= $camera['Resolution'] == $resolution ? 'selected' : '' ?>><?= $resolution ?></option>
            <?php endforeach; ?>
        </select>
       
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tốc độ khung hình (FPS)<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="FrameRate" value="<?= $camera['FrameRate'] ?>"  >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">SDK<span class="text-danger">*</span></label>
        <select class="form-control valid" id="SDK" name="SDK">
            <?php foreach($sdkOptions as $sdkOption) : ?>
                <option value="<?= $sdkOption ?>" <?= $camera['SDK'] == $sdkOption ? 'selected' : '' ?>><?= $sdkOption ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-check mt-3">
        
        <label class="form-check-label" for="inactiveCheck">Ghi hình camera</label>
        <input type="checkbox" class="form-check-input" name="EnableRecording" id="EnableRecording" <?= $camera['EnableRecording'] == 0 ? 'checked' : '' ?>>
    </div>

    <input type="hidden" name="IsFaceRecognize" value="0">
    
    

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck" <?= $camera['Inactive'] == 1 ? 'checked' : '' ?>>
        <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label >
    </div>

    </div>

    
    <div class="mt-4 btn-group-custom">
      <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
      <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
      <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
      <a href="index.php?page=camera" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    </form>
</div>
    