<?php 
    include_once __DIR__ . '/../../../../api/request.php';
    
    
    // call api to get card list
    $cardListApiUrl = 'http://localhost:8000/api/card-manager/card-list';
    $cardListResponse = apiRequest('GET', $cardListApiUrl);
   
    $cardLists = json_decode($cardListResponse, true);
 
    // call api to get card groups 

    $cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
    $cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
    $cardCategories = json_decode($cardCategoryResponse, true);

    // call api to get customer groups
    
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);

     // call API to get apartment categories

    $apartmentCategoryApiUrl = 'http://localhost:8000/api/category/apartment-category';
    $apartmentCategoryResponse = apiRequest('GET', $apartmentCategoryApiUrl);
    $apartmentCategories = json_decode($apartmentCategoryResponse, true);

   


?>
<style>
    .table {
    font-size: 12px !important;
}
</style>

<div class="container ms-3">
  <h4 class="mb-4">Báo cáo tổng hợp thẻ theo căn hộ (<?php echo count($cardLists); ?>)</h4>

   <div class="row mb-3">
    <div class="col-md-3">
      <input id="searchInput" type="text" class="form-control" placeholder="Mã thẻ, Biển số">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="customerSelect" id="customerSelect">
            <option value="">-- Nhóm khách hàng --</option>
            <?php foreach ($customerGroups as $group): ?>
                <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
             
              <select name="apartmentGroupSelect" id="apartmentGroupSelect" class="form-select">
                <option value="">-Chọn nhóm căn hộ-</option>
                    <?php foreach($apartmentCategories as $apartmentCategory): ?>
                  <option value="<?= $apartmentCategory['CompartmentID'] ?>"><?= $apartmentCategory['CompartmentName'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
    <div class="col-md-3">
        <select class="form-select" id="cardGroupSelect" name="cardGroupSelect">
            <option value="">-- Nhóm thẻ --</option>
            <?php foreach ($cardCategories as $cardCate): ?>
                <option value="<?= $cardCate['CardGroupID'] ?>"><?= $cardCate['CardGroupName'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="col-md-7 mt-3">
        <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
        
        <a href="pages/dashboard/card-manager/export-card.php" class="btn btn-sm btn-info me-2">Xuất Excel</a>
        <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>

    </div>
  
    </div>
    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
            <th>STT</th> <!-- Checkbox for Select All -->
            <th>Căn hộ</th>
            
           
        </tr>
      </thead>
      <tbody>
            
              
      </tbody>
    </table>
    
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>



$(document).ready(function(){
    function filterCards() {
        
        var searchTerm = $('#searchInput').val().toLowerCase();
        var selectedCustomer = $('#customerSelect').val();
        var cardGroupSelected = $('#cardGroupSelect').val();
        var apartmentSelected = $('#apartmentGroupSelect').val();
        
        $('.card-row').each(function(){
            var $row = $(this);
           
            
            var cardNumber = $row.find('.card-number').text().toLowerCase();
            var plate = $row.find('.plate').text().toLowerCase();
            
            // Lấy giá trị từ data attributes, mặc định là chuỗi rỗng nếu không có
            var customerGroupID = $row.data('customer-group-id') || '';
            var cardGroupID = $row.data('card-group-id') || '';
            var apartmentGroupID = $row.data('apartment-group-id') || '';
            
            // Chuyển đổi tất cả thành chuỗi để so sánh
            customerGroupID = customerGroupID.toString();
            cardGroupID = cardGroupID.toString();
            apartmentGroupID = apartmentGroupID.toString();
            
            var matchesSearch = searchTerm === '' || 
                              cardNumber.includes(searchTerm) || 
                              plate.includes(searchTerm);
            var matchesApartment = apartmentSelected === '' || 
                                 apartmentSelected === apartmentGroupID;
            var matchesCustomer = selectedCustomer === '' || 
                                selectedCustomer === customerGroupID;
            var matchesCardGroup = cardGroupSelected === '' || 
                                 cardGroupSelected === cardGroupID;

            if (matchesSearch && matchesCustomer && matchesApartment && matchesCardGroup) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    }

    // Tìm kiếm khi nhấn nút
    $('#searchButton').on('click', filterCards);
    
    // Tìm kiếm khi nhập vào ô tìm kiếm
    $('#searchInput').on('keyup', filterCards);
    
    // Tìm kiếm khi thay đổi select box
    $('#customerSelect, #cardGroupSelect, #apartmentGroupSelect').on('change', filterCards);

    $('#reloadButton').on('click', function() {
        location.reload();
    });
});
</script>
<!-- Modal for Import -->