<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    // call api to get gate list
    $gateApiUrl = 'http://localhost:8000/api/equipment/gate-list';
    $gateResponse = apiRequest('GET', $gateApiUrl);
    $gates = json_decode($gateResponse, true);
    

  if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete_gate_id'])) {
    $deleteGateId = $_POST['delete_gate_id'];
    $deleteGateApiUrl = 'http://localhost:8000/api/equipment/delete-gate/' . $deleteGateId;
    $response = apiRequest('PUT', $deleteGateApiUrl);
    
    $responseData = json_decode($response, true);
    if (isset($responseData['status']) && $responseData['status'] === 'success') {
        echo '<div class="alert alert-success">Xóa cổng thành công!</div>';
        // Redirect or perform other actions as needed
    } else {
        echo '<div class="alert alert-danger">Lỗi khi xóa cổng: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
    }
  }
   
     

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách Cổng</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-3">
      <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
      <a href="index.php?page=add-gate" class="btn btn-sm btn-success me-2"> Thêm mới</a>
 
    </div>
   
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên</th>
          <th>Mô tả</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($gates as $gate): ?>
            <tr class="gate-row">
              <td class="gate-name"><?= $gate['GateName'] ?></td>
              <td><?= $gate['Description'] ?></td>
              <td>
                <div class="d-flex justify-content-center align-items-center">
                    <span class="badge text-<?= $gate ['Inactive'] == 0 ? 'success' : 'warning' ?>">
                    <?= $gate['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                    </span>
                </div>
            </td>
            <td>
              <!-- Sửa -->
                <a href="index.php?page=update-gate&id=<?=$gate['GateID'] ?>" title="Sửa" class="d-inline-block me-2">
                    <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                </a>

                <!-- Xóa -->
                <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                <input type="hidden" name="delete_gate_id" value="<?= $gate['GateID'] ?>">
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
      $('.gate-row').each(function(){
        var cardGroupName = $(this).find('.gate-name').text().toLowerCase();
        if (cardGroupName.includes(searchTerm)) {
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
