

<?php 
    include_once __DIR__ . '/../../../../api/request.php';  


    // call api to get gate list
    $gateApiUrl = 'http://localhost:8000/api/equipment/gate-list';
    $gateResponse = apiRequest('GET', $gateApiUrl);
    $gates = json_decode($gateResponse, true);

    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);

    // call api to add new camera
    $addCameraApiUrl = 'http://localhost:8000/api/equipment/add-camera';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cameraData = [
            'CameraName' => $_POST['CameraName'] ?? '',
            'CameraType' => $_POST['CameraType'] ?? '',
            'PCID' => $_POST['computer'] ?? '',
            'HttpURL' => $_POST['HttpURL'] ?? '',
            'HttpPort' => $_POST['HttpPort'] ?? '',
            'RtspPort' => $_POST['RtspPort'] ?? '',
            'Username' => $_POST['Username'] ?? '',
            'Password' => $_POST['Password'] ?? '',
            'Channel' => $_POST['Channel'] ?? 0,
            'StreamType' => $_POST['StreamType'] ?? '',
            'Resolution' => $_POST['Resolution'] ?? '',
            'FrameRate' => $_POST['FrameRate'] ?? null,
            'SDK' => $_POST['SDK'] ?? '',
            'EnableRecording' => isset($_POST['EnableRecording']) ? 0 : 1,
            'IsFaceRecognize' => isset($_POST['IsFaceRecognize']) ? 0 : 1,
            'Inactive' => isset($_POST['Inactive']) ? 0 : 1,
            
        ];

        $response = apiRequest('POST', $addCameraApiUrl, $cameraData);
        $responseData = json_decode($response, true);

        if (isset($responseData['status']) && $responseData['status'] === 'success') {  
            echo '<div class="alert alert-success">Thêm mới camera thành công!</div>';
        } else {
            echo '<div class="alert alert-danger">Lỗi khi thêm mới camera: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }
    }
    
    
    

   
?>

<div class="container mt-5">
  <h2 class="mb-4">Thêm mới camera</h2>
  <form method="POST">
  
      <!-- Thông tin cơ bản -->
      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên camera<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="CameraName" placeholder="Tên camera" >
        </div>
      </div>
   

    <!-- Thông tin cơ bản -->
      

         <div class="col-md-5 mt-2 form-section">
            <label class="form-label">Loại camera<span class="text-danger">*</span></label>   
            <select class="form-control valid" id="CameraType" name="CameraType">
                <option value="">--Chọn loại camera--</option>
                <option value="Geovision">Geovision</option>
                <option value="Panasonic i-Pro">Panasonic i-Pro</option>
                <option value="Axis">Axis</option>
                <option value="Secus">Secus</option>
                <option value="Shany-Stream1">Shany-Stream1</option>
                <option value="Shany-Stream21">Shany-Stream2</option>
                <option value="Vivotek">Vivotek</option>
                <option value="Lilin">Lilin</option>
                <option value="Messoa">Messoa</option>
                <option value="Entrovision">Entrovision</option>
                <option value="Sony">Sony</option>
                <option value="Bosch">Bosch</option>
                <option value="Vantech">Vantech</option>
                <option value="SC330">SC330</option>
                <option value="SecusFFMPEG">SecusFFMPEG</option>
                <option value="CNB">CNB</option>
                <option value="HIK">HIK</option>
                <option value="Enster">Enster</option>
                <option value="Afidus">Afidus</option>
                <option value="Dahua">Dahua</option>
                <option value="ITX">ITX</option>
                <option value="Hanse">Hanse</option>
                <option value="Samsung">Samsung</option>
                <option value="Tiandy">Tiandy</option>
                <option value="Camtron">Camtron</option>
                <option value="HIVIZ">HIVIZ</option>
                <option value="DMAX">DMAX</option>
            </select>
         </div>



    <div class="col-md-5 mt-2 form-section">
            <label class="form-label">Tên máy tính<span class="text-danger">*</span></label>   
            <select class="form-select" name="computer" id="">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>"><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
         </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Địa chỉ IP <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="HttpURL" value="192.168.1." >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Cổng HTTP<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="HttpPort" value="80" >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Cổng RTSP<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="RtspPort" value="554" >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên đăng nhập<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Username"  >
        </div>
      </div>

      <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Mật khẩu<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="Password" >
        </div>
      </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Kênh<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="Channel" value="0" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Định dạng truyền ảnh<span class="text-danger">*</span></label>
        <select class="form-control " id="StreamType" name="StreamType">
            <option value="H264">H264</option>
            <option value="MJPEG">MJPEG</option>
            <option value="PlayFile">PlayFile</option>
            <option value="Local Video Capture Device">Local Video Capture Device</option>
            <option value="JPEG">JPEG</option>
            <option value="MPEG4">MPEG4</option>
            <option value="Onvif">Onvif</option>
        </select>
        
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Độ phân giải<span class="text-danger">*</span></label>
        <select class="form-control " id="Resolution" name="Resolution" >
            <option value="720x480">D1 (720x480)</option>
            <option value="1280x720">720p HD (1280x720)</option>
            <option value="1280x960">960p HD (1280x960)</option>
            <option value="1280x1024">1.3 MP(1280x1024)</option>
            <option value="1600x1200">2 MP (1600x1200)</option>
            <option value="1920x1080">1080p HD (1920x1080)</option>
            <option value="2048x1536">3 MP (2048x1536)</option>
        </select>
       
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tốc độ khung hình (FPS)<span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="FrameRate"  >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">SDK<span class="text-danger">*</span></label>
        <select class="form-control valid" id="SDK" name="SDK">
            <option value="KztekSDK2">KztekSDK2</option>
            <option value="AForgeSDK">AForgeSDK</option>
            <option value="AxisSDK">AxisSDK</option>
            <option value="GeoSDK">GeoSDK</option>
            <option value="ScSDK">ScSDK</option>
            <option value="FFMPEG">FFMPEG</option>
            <option value="VLC">VLC</option>
            <option value="KztekSDK">KztekSDK</option>
            <option value="HIKSDK">HIKSDK</option>
            <option value="TiandySDK">TiandySDK</option>
            <option value="DahuaSDK">DahuaSDK</option>
        </select>
    </div>

    <div class="form-check mt-3">
        
        <label class="form-check-label" for="inactiveCheck">Ghi hình camera</label>
        <input type="checkbox" class="form-check-input" name="EnableRecording" id="EnableRecording">
    </div>

    <input type="hidden" name="IsFaceRecognize" value="0">
    
    

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
        <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
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
    