<?php 
    include_once __DIR__ . '/../../../../api/request.php';  

    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);
    
    // call api to add new controller
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerData = [
            'ControllerName' => $_POST['ControllerName'] ?? '',
            'PCID' => $_POST['Computer'] ?? '',
            'CommunicationType' => $_POST['CommunicationType'] ?? '',
            'Comport' => $_POST['Comport'] ?? '',
            'Baudrate' => $_POST['Baudrate'] ?? '',
            'LineTypeID' => $_POST['LineTypeID'] ?? '',
            'Reader1Type' => $_POST['Reader1Type'] ?? '',
            'Reader2Type' => $_POST['Reader2Type'] ?? '',
            'Address' => $_POST['Address'] ?? '',
            'Inactive' => isset($_POST['Inactive']) ? 0 : 1,
        ];

        $apiAddController = 'http://localhost:8000/api/equipment/add-controller';
        $apiResponse = apiRequest('POST', $apiAddController, $controllerData);
        $responseData = json_decode($apiResponse, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {
           
            // Optionally redirect or reload the page
           
            echo '<div class="alert alert-success">Thêm mới bộ điều khiển thành công!</div>';
            
        } else {
            echo '<div class="alert alert-danger">Lỗi khi thêm mới bộ điều khiển: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }

    }
    
    

   
?>


<div class="container mt-5">
  <h2 class="mb-4">Thêm mới bộ điều khiển</h2>
  <form method="POST">
    
      <!-- Thông tin cơ bản -->
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên bộ điều khiển <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="ControllerName" placeholder="Tên bộ điều khiển" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Máy tính<span class="text-danger">*</span></label>   
        <select class="form-select" name="Computer" id="">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>"><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>



    <div class="col-md-5 mt-2 mt-3 form-section">
        <label class="form-label">Giao thức truyền thông <span class="text-danger">*</span></label>
        <select class="form-control valid" id="CommunicationType" name="CommunicationType" >
            <option value="1">TCP/IP</option>
            <option value="0">RS232/485/422</option>
        </select>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Địa chỉ IP<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Comport" placeholder="địa chỉ" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Port<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Baudrate" value="8000" placeholder="địa chỉ" >
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Loại bộ điều khiển<span class="text-danger">*</span></label>   
        <select class="form-control long-select"  id="LineTypeID" name="LineTypeID">
            <option value="">--Chọn Loại--</option>
            <option value="0">IDTECK</option>   
            <option value="1">Honeywell SY-MSA30/60L</option>
            <option value="2">Honeywell Nstar</option>
            <option value="3">Pegasus PP-3760</option>
            <option value="4">Pegasus PP-6750</option>
            <option value="5">Pegasus PFP-3700</option>
            <option value="6">FINGERTEC</option>
            <option value="7">DS3000</option>
            <option value="8">CS3000</option>
            <option value="9">RCP4000</option>
            <option value="10">PEGASUS PB7/PT3</option>
            <option value="11">PEGASUS PB5</option>
            <option value="12">IDTECK (006)</option>
            <option value="13">IDTECK (iTDC)</option>
            <option value="14">IDTECK (iMDC)</option>
            <option value="15">IDTECK (Elevator384)</option>
            <option value="16">Promax - FAT810W Kanteen</option>
            <option value="17">Promax - AC908</option>
            <option value="18">HAEIN S&amp;amp;S</option>
            <option value="19">Promax - PCR310U</option>
            <option value="20">NetPOS Client MDB</option>
            <option value="21">NetPOS Client SERVER</option>
            <option value="22">Promax - FAT810W Parking</option>
            <option value="23">Promax - FAT810W Vending Machine</option>
            <option value="24">Pegasus - PP-110/PP-5210/PUA-310</option>
            <option value="25">Futech SC100</option>
            <option value="26">Honeywell HSR900</option>
            <option value="27">AC9xxPCR</option>
            <option value="28">E02.NET</option>
            <option value="29">Futech SC101</option>
            <option value="30">Futech SC100FPT</option>
            <option value="31">Futech SC100LANCASTER</option>
            <option value="32">Futech FUCM100</option>
            <option value="33">IDTECK 8 Number</option>
            <option value="34">E01 RS485</option>
            <option value="35">E02.NET Card Int</option>
            <option value="36">FUPC100</option>
            <option value="37">E02.NET Mifare</option>
            <option value="38">SOYAL</option>
            <option value="39">E02.NET Mifare SR30</option>
            <option value="40">Ingressus</option>
            <option value="41">E01 RS485 V2</option>
            <option value="42">Ingressus Mifare</option>
            <option value="43">FAT810WDispenser</option>
            <option value="44">FUCMHID100</option>
            <option value="45">USB Mifare</option>
            <option value="46">USB Proximity</option>
            <option value="47">IDTECKSR30</option>
            <option value="48">E02QRCode</option>
            <option value="49">E04.NET</option>
            <option value="50">E04.NET Mifare</option>
            <option value="51">E05.NET</option>
            <option value="52">KZ-MFC01.NET</option>
            <option value="53">E02_FPT</option>
            <option value="54">E05.NET Mifare</option>
            <option value="55">IDTECK Mifare</option>
            <option value="56">FaceMQTT</option>
            <option value="57">E02Mifare_BTNMT</option>
            <option value="58">FaceMQTT_V2</option>
            <option value="59">E02_FirstSeri10</option>
            <option value="60">Ingress_FirstSeri10</option>
            <option value="61">SupremaCS40</option>
            <option value="62">KZE02NET</option>
            <option value="63">E05v2</option>
            <option value="64">SC200</option>
            <option value="65">KZE05NET</option>
            <option value="66">FAT810_Proximity_Dispenser</option>
            <option value="67">MT166_CardDispenser</option>
            <option value="68">Soyal-AR725</option>
            <option value="69">Zkteco-C3_400</option>
            <option value="72">Dahua Standalone Controller</option>
            <option value="73">KZE02 v2</option>
        </select>
    </div>
   
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Reader1Type<span class="text-danger">*</span></label>
            <select class="form-control valid" id="Reader1Type" name="Reader1Type" >
                <option value="0">1</option>
                <option value="1">2</option>
            </select>
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Reader2Type<span class="text-danger">*</span></label>
            <select class="form-control valid" id="Reader2Type" name="Reader2Type" >
                <option value="0">1</option>
                <option value="1">2</option>
            </select>
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Address(RS232/485/422)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Address"  value="1" >
        </div>
    </div> 

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
        <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
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



    