<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    
    
    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);

    // call api to get led list
    $ledApiUrl = 'http://localhost:8000/api/equipment/led-list';
    $ledResponse = apiRequest('GET',$ledApiUrl);
  
    $leds = json_decode($ledResponse,true);


    

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_led_id'])) {
            $ledId = $_POST['delete_led_id'];
            $deleteLedApiUrl = 'http://localhost:8000/api/equipment/delete-led/' . $ledId;
            $response = apiRequest('PUT', $deleteLedApiUrl);
            var_dump($response);
            $responseData = json_decode($response, true);
            
            if (isset($responseData['status']) && $responseData['status'] === 'success') {

                echo '<div class="alert alert-success">Xóa LED thành công!</div>';
                // reload the page 
              echo '<script>setTimeout(function() { window.location.href = "index.php?page=led-display"; }, 200);</script>';
                
            } else {
                echo '<div class="alert alert-danger">Lỗi khi xóa camera: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
            }
        }
    }

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách LED</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="computerSelect" id="computerSelect">
            <option value="#">-- Chọn máy tính --</option>
            <?php foreach ($computers as $computer): ?>
                <option value="<?= $computer['PCID'] ?>"><?= $computer['ComputerName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
      <button id="searchButton" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary">Nạp lại</button>
      <a href="index.php?page=export-led" class="btn btn-sm btn-success">Xuất Excel</a>
      
    </div>
    <div class="mt-3">
       <!-- Thêm mới -->
 
    <a href="index.php?page=add-led" class="btn btn-sm btn-success"> Thêm mới</a>
 
    </div>
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên</th>
          
          <th>Tên Máy tính</th>
          <th>Comport</th>
          <th>Baudrate</th>
          <th>Thiết bị hiển thị</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($leds as $led): ?>
                <tr class="led-row" data-led-id="<?= $led['PCID'] ?>">
                    <td class="led-name"><?= $led['LEDName']  ?></td>
                    <td class="led-name"><?= $led['ComputerName']  ?></td>
                    <td> <?= $led['Comport']?></td>
                    <td><?= $led['Baudrate']?></td>
                    <td><?= $led['LedType']?></td>
                    
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge bg-<?= $led ['EnableLED'] == 1 ? 'success' : 'warning' ?>">
                             <?= $led['EnableLED'] == 1 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <!-- Sửa -->
                        <a href="index.php?page=update-led&id=<?=$led['LEDID'] ?>" title="Sửa" class="d-inline-block me-2">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                        </a>

                        <!-- Xóa -->
                        <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                        <input type="hidden" name="delete_led_id" value="<?= $led['LEDID'] ?>">
                        <button type="submit" class="btnDelete" title="Xóa" style="border:none; background:none; cursor:pointer;">
                            <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
                        </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
                    
      </tbody>
    </table>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function(){
    $('#searchButton').on('click', function(){
      var searchTerm = $('#searchInput').val().toLowerCase();
      var selectedComputer = $('#computerSelect').val();
      $('.led-row').each(function(){

        var ledName = $(this).find('.led-name').text().toLowerCase();
        var PCID = $(this).data('led-id') || '';
        
        var matchesSearch = ledName.includes(searchTerm);
        var matchesComputer = selectedComputer === '#' || PCID.includes(selectedComputer);
        if (matchesSearch && matchesComputer) {
          $(this).show();
        } else {
          $(this).hide();
        } 
        
      });
    });

    // Nút nạp lại
    $('#reloadButton').on('click', function () {
      location.reload();
    });
  });
</script>
