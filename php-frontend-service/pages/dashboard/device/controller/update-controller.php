<?php 
    include_once __DIR__ . '/../../../../api/request.php';  

    // call api to get detail controller
    $controllerID = $_GET['id'] ?? '';
    $apiFindController = 'http://localhost:8000/api/equipment/find-controller/' .$controllerID;
    $apiFindResponse = apiRequest('GET',$apiFindController);
   
    $Controller = json_decode($apiFindResponse,true);

     // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
  
    $computers = json_decode($computerResponse, true);

    $lineTypes = [
    0 => 'IDTECK',
    1 => 'Honeywell SY-MSA30/60L',
    2 => 'Honeywell Nstar',
    3 => 'Pegasus PP-3760',
    4 => 'Pegasus PP-6750',
    5 => 'Pegasus PFP-3700',
    6 => 'FINGERTEC',
    7 => 'DS3000',
    8 => 'CS3000',
    9 => 'RCP4000',
    10 => 'PEGASUS PB7/PT3',
    11 => 'PEGASUS PB5',
    12 => 'IDTECK (006)',
    13 => 'IDTECK (iTDC)',
    14 => 'IDTECK (iMDC)',
    15 => 'IDTECK (Elevator384)',
    16 => 'Promax - FAT810W Kanteen',
    17 => 'Promax - AC908',
    18 => 'HAEIN S&S',
    19 => 'Promax - PCR310U',
    20 => 'NetPOS Client MDB',
    21 => 'NetPOS Client SERVER',
    22 => 'Promax - FAT810W Parking',
    23 => 'Promax - FAT810W Vending Machine',
    24 => 'Pegasus - PP-110/PP-5210/PUA-310',
    25 => 'Futech SC100',
    26 => 'Honeywell HSR900',
    27 => 'AC9xxPCR',
    28 => 'E02.NET',
    29 => 'Futech SC101',
    30 => 'Futech SC100FPT',
    31 => 'Futech SC100LANCASTER',
    32 => 'Futech FUCM100',
    33 => 'IDTECK 8 Number',
    34 => 'E01 RS485',
    35 => 'E02.NET Card Int',
    36 => 'FUPC100',
    37 => 'E02.NET Mifare',
    38 => 'SOYAL',
    39 => 'E02.NET Mifare SR30',
    40 => 'Ingressus',
    41 => 'E01 RS485 V2',
    42 => 'Ingressus Mifare',
    43 => 'FAT810WDispenser',
    44 => 'FUCMHID100',
    45 => 'USB Mifare',
    46 => 'USB Proximity',
    47 => 'IDTECKSR30',
    48 => 'E02QRCode',
    49 => 'E04.NET',
    50 => 'E04.NET Mifare',
    51 => 'E05.NET',
    52 => 'KZ-MFC01.NET',
    53 => 'E02_FPT',
    54 => 'E05.NET Mifare',
    55 => 'IDTECK Mifare',
    56 => 'FaceMQTT',
    57 => 'E02Mifare_BTNMT',
    58 => 'FaceMQTT_V2',
    59 => 'E02_FirstSeri10',
    60 => 'Ingress_FirstSeri10',
    61 => 'SupremaCS40',
    62 => 'KZE02NET',
    63 => 'E05v2',
    64 => 'SC200',
    65 => 'KZE05NET',
    66 => 'FAT810_Proximity_Dispenser',
    67 => 'MT166_CardDispenser',
    68 => 'Soyal-AR725',
    69 => 'Zkteco-C3_400',
    72 => 'Dahua Standalone Controller',
    73 => 'KZE02 v2',
];


    

    
    // call api to add new controller
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controllerData = [
            'ControllerName' => $_POST['ControllerName'] ?? '',
            'PCID' => $_POST['PCID'] ?? '',
            'CommunicationType' => $_POST['CommunicationType'] ?? '',
            'Comport' => $_POST['Comport'] ?? '',
            'Baudrate' => $_POST['Baudrate'] ?? '',
            'LineTypeID' => $_POST['LineTypeID'] ?? '',
            'Reader1Type' => $_POST['Reader1Type'] ?? '',
            'Reader2Type' => $_POST['Reader2Type'] ?? '',
            'Address' => $_POST['Address'] ?? '',
            'Inactive' => isset($_POST['Inactive']) ? 0 : 1,
        ];

        $apiAddController = 'http://localhost:8000/api/equipment/update-controller/' .$controllerID;
        $apiResponse = apiRequest('PUT', $apiAddController, $controllerData);
        $responseData = json_decode($apiResponse, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {

            echo '<div class="alert alert-success">Thêm mới bộ điều khiển thành công!</div>';
            
        } else {
            echo '<div class="alert alert-danger">Lỗi khi thêm mới bộ điều khiển: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
        }

    }
    
    

   
?>


<div class="container mt-5">
  <h2 class="mb-4">Cập nhật bộ điều khiển</h2>
  <form method="POST">
    
      <!-- Thông tin cơ bản -->
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group"><label class="form-label">Tên bộ điều khiển <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="ControllerName" value="<?= $Controller['ControllerName']?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Máy tính<span class="text-danger">*</span></label>   
        <select class="form-select" name="PCID" id="">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>" <?= $computer['PCID'] == $Controller['PCID'] ? 'selected' : ''  ?>><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>



    <div class="col-md-5 mt-2 mt-3 form-section">
        <label class="form-label">Giao thức truyền thông <span class="text-danger">*</span></label>
        <select class="form-control valid" id="CommunicationType" name="CommunicationType" >
            <option value="1" <?= ($Controller['CommunicationType'] ?? '') == '1' ? 'selected' : '' ?>>TCP/IP</option>
            <option value="0" <?= ($Controller['CommunicationType'] ?? '') == '0' ? 'selected' : '' ?>>RS232/485/422</option>

        </select>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Địa chỉ IP<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Comport" value="<?= $Controller['Comport']?>" >
        </div>
    </div>

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Port<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Baudrate" value="<?= $Controller['Baudrate']?>" >
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <label class="form-label">Loại bộ điều khiển<span class="text-danger">*</span></label>   
        <select class="form-control long-select"  id="LineTypeID" name="LineTypeID">
            <option value="">--Chọn Loại--</option>
            <?php foreach($lineTypes as $id => $name) : ?>
                <option value="<?= $id ?>" <?= $Controller['LineTypeID'] == $id ? 'selected': '' ?>><?= $name ?></option>

            <?php endforeach ?>
        </select>
    </div>
   
    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Reader1Type<span class="text-danger">*</span></label>
            <select class="form-control valid" id="Reader1Type" name="Reader1Type" >
                <option value="0" <?= $Controller['Reader1Type'] == 0 ? 'selected' : '' ?>>1</option>
                <option value="1" <?= $Controller['Reader1Type'] == 1 ? 'selected' : '' ?>>2</option>
            </select>
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Reader2Type<span class="text-danger">*</span></label>
            <select class="form-control valid" id="Reader2Type" name="Reader2Type" >
                <option value="0" <?= $Controller['Reader2Type'] == 0 ? 'selected' : '' ?>>1</option>
                <option value="1" <?= $Controller['Reader2Type'] == 1 ? 'selected' : '' ?>>2</option>
            </select>
        </div>
    </div>  

    <div class="col-md-5 mt-2 form-section">
        <div class="form-group">
            <label class="form-label">Address(RS232/485/422)<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="Address"  value="<?= $Controller['Address'] ?>" >
        </div>
    </div> 

    <div class="form-check mt-3">
        <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck" value="<?= $Controller['Address'] == 1 ? 'checked' : '' ?>">
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



    