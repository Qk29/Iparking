<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    
    
    // call api to get computer list
    $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
    $computerResponse = apiRequest('GET', $computerApiUrl);
    $computers = json_decode($computerResponse, true);

   
// call api get-lane
    $getLanesUrl  = 'http://localhost:8000/api/lane/get-all';
    $laneResponse  = apiRequest('GET', $getLanesUrl );
    $lanes  = json_decode($laneResponse, true);

    
    
    

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_lane_id'])) {
            $laneId = $_POST['delete_lane_id'];
            
            $deleteLaneApiUrl = 'http://localhost:8000/api/lane/delete-lane/'.$laneId;
            
            $response = apiRequest('DELETE', $deleteLaneApiUrl);
            
            $responseData = json_decode($response, true);
            
            if (isset($responseData['status']) && $responseData['status'] === 'success') {

                echo '<div class="alert alert-success">Xóa làn thành công!</div>';
                // reload the page 
              echo '<script>setTimeout(function() { window.location.href = "index.php?page=in-out-lane"; }, 200);</script>';
                
            } else {
                echo '<div class="alert alert-danger">Lỗi khi xóa làn: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
            }
        }
    }

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách làn vào ra</h4>

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
      
    </div>
    <div class="mt-3">
       <!-- Thêm mới -->
 
    <a href="index.php?page=add-lane" class="btn btn-sm btn-success"> Thêm mới</a>
 
    </div>
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên làn</th>
          <th>Loại làn </th>
          <th>Tên máy tính</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($lanes as $lane): ?>
                <tr class="lane-row" data-lane-id="<?= $lane['PCID'] ?>">
                    <td class="lane-name"><?= $lane['LaneName']  ?></td>
                    <td ><?= $lane['LaneType']  ?></td>
                    <td> <?= $lane['ComputerName']?></td>
                    
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge bg-<?= $lane ['Inactive'] == 0 ? 'success' : 'warning' ?>">
                             <?= $lane['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <!-- Sửa -->
                        <a href="index.php?page=update-lane&id=<?=$lane['LaneID'] ?>" title="Sửa" class="d-inline-block me-2">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                        </a>

                        <!-- Xóa -->
                        <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                        <input type="hidden" name="delete_lane_id" value="<?= $lane['LaneID'] ?>">
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
      $('.lane-row').each(function(){

        var laneName = $(this).find('.lane-name').text().toLowerCase();
        var PCID = $(this).data('lane-id') || '';
        
        var matchesSearch = laneName.includes(searchTerm);
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
