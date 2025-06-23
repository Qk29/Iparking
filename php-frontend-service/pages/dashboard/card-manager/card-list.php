<?php 
    include_once __DIR__ . '/../../../api/request.php';
    
    
    // call api to get card list
    $cardListApiUrl = 'http://localhost:8000/api/card-manager/card-list';
    $cardListResponse = apiRequest('GET', $cardListApiUrl);
   
    $cardLists = json_decode($cardListResponse, true);
 
    // call api to get card groups 
    // call api card-category
    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

    // call api to get customer groups
    
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete_card_id'])) {
            $cardId = $_POST['delete_card_id'];
            $deleteCardApiUrl = 'http://localhost:8000/api/card-manager/delete-card/' . $cardId;
            
            $response = apiRequest('DELETE', $deleteCardApiUrl);
            
            $responseData = json_decode($response, true);
            
            if (isset($responseData['status']) && $responseData['status'] === 'success') {

                echo '<div class="alert alert-success">Xóa thẻ thành công!</div>';
                // reload the page 
              echo '<script>setTimeout(function() { window.location.href = "index.php?page=card-customer-manager"; }, 200);</script>';
                
            } else {
                echo '<div class="alert alert-danger">Lỗi khi xóa card: ' . htmlspecialchars($responseData['message'] ?? 'Không rõ lỗi') . '</div>';
            }
        }
    }

?>
<style>
    .table {
    font-size: 12px !important;
}
</style>

<div class="container ms-3">
  <h4 class="mb-4">Danh sách thẻ (<?php echo count($cardLists); ?>)</h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="số thẻ ...">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="customerSelect" id="customerSelect">
            <option value="#">-- Nhóm khách hàng --</option>
            <?php foreach ($customerGroups as $group): ?>
                <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select class="form-select" id="cardstatus" name="cardstatus">
            <option value="">-- Trạng thái --</option>
            <option value="0">Đang sử dụng</option>
            <option value="2">Chưa sử dụng</option>
            <option value="1">Đã khoá</option>
            <option value="3">Đã huỷ</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="cardGroupSelect" name="cardGroupSelect">
            <option value="">-- Nhóm thẻ --</option>
            <?php foreach ($cardCategories as $cardCate): ?>
                <option value="<?= $cardCate['CardGroupID'] ?>"><?= $cardCate['CardGroupName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="col-md-6 mt-3">
      <a href="index.php?page=add-card-manager" class="btn btn-sm btn-success me-2"> Thêm mới</a>
      <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
      <a href="pages/dashboard/card-manager/export-card.php" class="btn btn-sm btn-info me-2">Xuất Excel</a>
      <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#importModal">
        Nhập file Excel
      </button>
      
      
      <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
    </div>
  
    </div>


<div class="table-responsive">

    <?php 
        // Tổng số thẻ
        $totalCards = count($cardLists);

        // Số bản ghi mỗi trang
        $perPage = 10;

        // Tính tổng số trang
        $totalPages = ceil($totalCards / $perPage);

        // Lấy trang hiện tại từ URL (mặc định là 1)
        $currentPage = isset($_GET['pagination']) ? (int) $_GET['pagination'] : 1;
        if ($currentPage < 1) $currentPage = 1;

        // Tính chỉ số bắt đầu
        $startIndex = ($currentPage - 1) * $perPage;

        // Cắt mảng theo trang
        $pagedCards = array_slice($cardLists, $startIndex, $perPage);
    ?>
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
          <th>CardNo</th>
          <th>Mã thẻ</th>
          <th>Nhóm thẻ</th>
          <th>Biển số</th>
          <th>Ngày hết hạn</th>
          <th>Mã khách hàng</th>
          <th>Khách hàng</th>
          <th>Nhóm khách hàng</th>
          <th>Địa chỉ</th>
          <th>Căn hộ</th>
          <th>Ngày đăng ký</th>
          <th>Trạng thái</th>
          <th>Xử lí</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($pagedCards as $key => $card): ?>
              
                <tr class="card-row"
                data-card-status="<?= htmlspecialchars($card['Status'] ?? '') ?>"
                data-customer-group-id="<?= htmlspecialchars($card['CustomerGroupID'] ?? '') ?>"
                data-card-group-id="<?= htmlspecialchars($card['CardGroupID'] ?? '') ?>">

                    <td class="card-no"><?= $card['CardNo'] ?></td>
                    <td class="card-number"><?= $card['CardNumber'] ?></td>  
                    <td class="card-group-name"><?= $card['CardGroupName'] ?></td>
                    <td></td>
                    <td><?= $card['ExpireDate'] ?></td>
                    <td><?= $card['CustomerCode'] ?></td>
                    <td><?= $card['CustomerName'] ?></td>
                    <td><?= $card['CustomerGroupName'] ?></td>
                    <td><?= $card['Address'] ?></td>
                    <td><?= $card['CompartmentName'] ?></td>
                    <td><?= $card['DateRegister'] ?></td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="badge text-<?= $card ['Status'] == 0 ? 'success' : 'warning' ?>">
                             <?= $card ['Status'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt' ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                          <!-- Sửa -->
                          <a href="index.php?page=update-card-manager&id=<?= $card['CardID'] ?>" title="Sửa">
                            <i class="ace-icon fa fa-pencil bigger-120" style="color:green;"></i>
                          </a>

                          <!-- Xóa -->
                          <form action="" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                            <input type="hidden" name="delete_card_id" value="<?= $card['CardID'] ?>">
                            <button type="submit" title="Xóa" style="border:none; background:none; cursor:pointer;">
                              <i class="ace-icon fa fa-trash bigger-120" style="color:red;"></i>
                            </button>
                          </form>

                          
                    </td>
                </tr>
            <?php endforeach; ?>
              
      </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">

        <!-- Previous -->
        <?php if ($currentPage > 1): ?>
        <li class="page-item">
            <a class="page-link" href="?page=card-customer-manager&pagination=<?= $currentPage - 1 ?>">« Previous</a>
        </li>
        <?php endif; ?>

        <?php
        $range = 1; // Hiển thị các trang xung quanh current page
        $start = max(1, $currentPage - $range);
        $end = min($totalPages - 1, $currentPage + $range);

        for ($i = $start; $i <= $end; $i++):
        ?>
        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="?page=card-customer-manager&pagination=<?= $i ?>"><?= $i ?></a>
        </li>
        <?php endfor; ?>

        <!-- Dấu "..." nếu còn trang cuối -->
        <?php if ($end < $totalPages - 1): ?>
        <li class="page-item disabled"><span class="page-link">...</span></li>
        <?php endif; ?>

        <!-- Next -->
        <?php if ($currentPage < $totalPages): ?>
        <li class="page-item">
            <a class="page-link" href="?page=card-customer-manager&pagination=<?= $currentPage + 1 ?>">Next »</a>
        </li>
        <?php endif; ?>

    </ul>
    </nav>
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#searchButton').on('click', function(){
        var searchTerm = $('#searchInput').val().toLowerCase();
        var selectedCustomer = $('#customerSelect').val();
        var selectedStatus = $('#cardstatus').val();
        var cardGroupSelected = $('#cardGroupSelect').val();
        
        
        $('.card-row').each(function(){
            var cardNo = $(this).find('.card-no').text().toLowerCase();
            var customerGroupID = $(this).data('customer-group-id').toString();
            var cardStatus = $(this).data('card-status').toString();
            var cardGroupID = $(this).data('card-group-id').toString();
            
            var matchesSearch = searchTerm === '' || cardNo.includes(searchTerm);
            var matchesCustomer = selectedCustomer === '' || selectedCustomer === customerGroupID;
            var matchesStatus = selectedStatus === '' || selectedStatus === cardStatus;
            var matchesCardGroup = cardGroupSelected === '' || cardGroupSelected === cardGroupID;

            if (matchesSearch && matchesCustomer && matchesStatus &&   matchesCardGroup) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('#reloadButton').on('click', function () {
        location.reload();
    });
});
</script>
