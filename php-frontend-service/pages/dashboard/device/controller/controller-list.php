<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    
    
    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);

    // call api to get controller list
    $controllerApiUrl = 'http://localhost:8000/api/equipment/controller-list';
    $controllerResponse = apiRequest('GET', $controllerApiUrl);
    $controllers = json_decode($controllerResponse, true);


    

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_controller_id'])) {
            $controllerId = $_POST['delete_controller_id'];
            $deleteControllerApiUrl = 'http://localhost:8000/api/equipment/delete-controller/' . $controllerId;
            $response = apiRequest('PUT', $deleteControllerApiUrl);
            $responseData = json_decode($response, true);
            
            if (isset($responseData['status']) && $responseData['status'] === 'success') {

                echo '<div class="alert alert-success">Xóa camera thành công!</div>';
                // reload the page 
              echo '<script>setTimeout(function() { window.location.href = "index.php?page=controller"; }, 2z00);</script>';
                
            } else {
                echo '<div class="alert alert-danger">Lỗi khi xóa camera: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
            }
        }
    }

?>


<div class="container">
  <h4 class="mb-4">Danh sách Camera</h4>

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
      <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
      <a href="index.php?page=add-controller" class="btn btn-sm btn-success me-2"> Thêm mới</a>
    </div>
    
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên</th>
          <th>Comport/IP</th>
          <th>Tên Máy tính</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($controllers as $controller): ?>
                <tr class="controller-row" data-computer-id="<?= $controller['PCID'] ?>">
                    <td class="controller-name"><?= $controller['ControllerName']  ?></td>
                    <td> <?= $controller['Comport']?></td>
                    <td><?= $controller['ComputerName']?></td>
                    
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge text-<?= $controller ['Inactive'] == 0 ? 'success' : 'warning' ?>">
                             <?= $controller['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <!-- Sửa -->
                        <a href="index.php?page=update-controller&id=<?=$controller['ControllerID'] ?>" title="Sửa" class="d-inline-block me-2">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                        </a>

                        <!-- Xóa -->
                        <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                        <input type="hidden" name="delete_controller_id" value="<?= $controller['ControllerID'] ?>">
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
      $('.controller-row').each(function(){

        var controllerName = $(this).find('.controller-name').text().toLowerCase();
        var PCID = $(this).data('computer-id') || '';
        
        var matchesSearch = controllerName.includes(searchTerm);
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
