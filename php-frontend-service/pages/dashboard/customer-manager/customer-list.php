<?php 
    include_once __DIR__ . '/../../../api/request.php';
    
    // call api to get customer list
    $customerApiUrl = 'http://localhost:8000/api/customer-manager/customer-list';
    $customerResponse = apiRequest('GET', $customerApiUrl);
    $customers = json_decode($customerResponse, true);

    // call api to get customer groups
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);
    
  
    


    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_customer_id'])) {
            $customerId = $_POST['delete_customer_id'];
            $deleteLedApiUrl = 'http://localhost:8000/api/customer-manager/delete-customer/' . $customerId;
            $response = apiRequest('DELETE', $deleteLedApiUrl);
           
            $responseData = json_decode($response, true);
            
            if (isset($responseData['status']) && $responseData['status'] === 'success') {

                echo '<div class="alert alert-success">Xóa Customer thành công!</div>';
                // reload the page 
              echo '<script>setTimeout(function() { window.location.href = "index.php?page=customer"; }, 200);</script>';
                
            } else {
                echo '<div class="alert alert-danger">Lỗi khi xóa customer: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
            }
        }
    }

?>
<style>
    .table {
    font-size: 12px !important;
}
</style>

<div class="container">
  <h4 class="mb-4">Danh sách khách hàng</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Từ khóa...">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="customerSelect" id="customerSelect">
            <option value="#">-- Chọn nhóm khách hàng --</option>
            <?php foreach ($customerGroups as $group): ?>
                <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-control" id="customerstatus" name="customerstatus">
            <option value="">--Lựa chọn--</option>
            <option selected="selected" value="0">Kích hoạt</option>
            <option value="1">Dừng hoạt động</option>
        </select>
    </div>
    <div class="col-md-6 mt-3">
      <a href="index.php?page=add-customer-manager" class="btn btn-sm btn-success me-2"> Thêm mới</a>
      <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
      <a href="pages/dashboard/customer-manager/export-customer.php" class="btn btn-sm btn-info me-2">Xuất Excel</a>
      <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#importModal">
        Nhập file Excel
      </button>
      
      
      <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
    </div>
  
    </div>


<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>STT</th>
          <th>Mã KH</th>
          <th>Tên KH</th>
          <th>Điện thoại</th>
          <th>Địa chỉ</th>
          <th>Căn hộ</th>
          <th>Nhóm KH</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($customers as $key => $customer): ?>
                <tr class="customer-row" data-customer-group-id="<?= $customer['CustomerGroupID'] ?>" data-customer-status="<?= $customer['Inactive'] ?>">
                    <td><?= $key + 1 ?></td>
                    <td><?= $customer['CustomerCode'] ?></td>
                    <td class="customer-name"><?= $customer['CustomerName'] ?></td>
                    <td><?= $customer['Mobile'] ?></td>
                    <td><?= $customer['Address'] ?></td>
                    <td><?= $customer['CompartmentName'] ?></td>
                    <td><?= $customer['CustomerGroupName'] ?></td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge text-<?= $customer ['Inactive'] == 0 ? 'success' : 'warning' ?>">
                             <?= $customer ['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                          <!-- Sửa -->
                          <a href="index.php?page=update-customer-manager&id=<?= $customer['CustomerID'] ?>" title="Sửa">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                          </a>

                          <!-- Xóa -->
                          <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                            <input type="hidden" name="delete_customer_id" value="<?= $customer['CustomerID'] ?>">
                            <button type="submit" title="Xóa" style="border:none; background:none; cursor:pointer;">
                              <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
                            </button>
                          </form>

                          <!-- Thẻ -->
                          <a href="index.php?page=card-customer-manager&id=<?= $customer['CustomerID'] ?>" title="Thẻ" target="_blank">
                            <i class="fa fa-credit-card warning"></i>
                          </a>
                        </div>
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
      var selectedCustomer = $('#customerSelect').val();
      var selectedstatus = $('#customerstatus').val();
      $('.customer-row').each(function(){

        var customerName = $(this).find('.customer-name').text().toLowerCase();
        var customerGroupID = $(this).data('customer-group-id').toString();
        var customerStatus = $(this).data('customer-status').toString();
        
        var matchesSearch = customerName.includes(searchTerm);
        var matchesCustomer = selectedCustomer === '#' || selectedCustomer === customerGroupID;
        var matchesStatus = selectedstatus === '' || selectedstatus == customerStatus;
        if (matchesSearch && matchesCustomer && matchesStatus) {
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
