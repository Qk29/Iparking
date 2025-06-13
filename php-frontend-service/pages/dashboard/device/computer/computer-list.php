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

?>


<div class="container mt-5">
  <h4 class="mb-4">Danh sách Máy Tính</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="gate" id="gateSelect">
            <option value="#">-- Chọn cổng --</option>
            <?php foreach ($gates as $gate): ?>
                <option value="<?= $gate['GateID'] ?>"><?= $gate['GateName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
      <button id="searchButton" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Tìm kiếm</button>
      <button id="reloadButton" class="btn btn-sm btn-secondary">Nạp lại</button>
      <a href="index.php?page=add-computer" class="btn btn-sm btn-success"> Thêm mới</a>
    </div>
   
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>Tên Máy Tính</th>
          <th>Địa chỉ IP</th>
          <th>Cổng</th>
          <th>Mô tả</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($computers as $computer): ?>
                <tr class="gate-row" data-gate-id="<?= $computer['GateID'] ?>">
                    <td class="gate-name"><?= $computer['ComputerName']  ?></td>
                    <td> <?= $computer['IPAddress']?></td>
                    <td><?= $computer['GateName']?></td>
                    <td><?= $computer['Description'] ?></td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge text-<?= $computer ['Inactive'] == 0 ? 'success' : 'warning' ?>">
                             <?= $computer['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <!-- Sửa -->
                        <a href="index.php?page=update-computer&id=<?=$computer['PCID'] ?>" title="Sửa" class="d-inline-block me-2">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                        </a>

                        <!-- Xóa -->
                        <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');" class="d-inline-block me-2">
                        <input type="hidden" name="delete_computer_id" value="<?= $computer['PCID'] ?>">
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
      var selectedGate = $('#gateSelect').val();
      $('.gate-row').each(function(){

        var cardGroupName = $(this).find('.gate-name').text().toLowerCase();
        var cardGate = $(this).data('gate-id') || '';
        
        var matchesSearch = cardGroupName.includes(searchTerm);
        var matchesGate = selectedGate === '#' || cardGate.includes(selectedGate);
        if (matchesSearch && matchesGate) {
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
