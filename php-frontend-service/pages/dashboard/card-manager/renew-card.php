<?php 
    include_once __DIR__ . '/../../../api/request.php';
    
    
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

    

    
?>
<style>
    .table {
    font-size: 12px !important;

    
}
</style>

<div class="container ms-3">
  <h4 class="mb-4">Gia hạn thẻ </h4>

   <div class="row mb-3">
    <div class="col-md-4">
      <input id="searchInput" type="text" class="form-control" placeholder="Mã thẻ, mã khách hàng ...">
    </div>
    <div class="col-md-3" >
        <select class="form-select" name="customerSelect" id="customerSelect">
            <option value="">-- Nhóm khách hàng --</option>
            <?php foreach ($customerGroups as $group): ?>
                <option value="<?= $group['CustomerGroupID'] ?>"><?= $group['CustomerGroupName'] ?></option>
            <?php endforeach; ?>
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
    
    <div class="col-md-2">
        
        <button id="reloadButton" class="btn btn-sm btn-secondary me-2">Nạp lại</button>
                
        <button id="searchButton" class="btn btn-sm btn-primary me-2"><i class="bi bi-search"></i> Tìm kiếm</button>
        
    </div>

    <div class="col-md-3 mt-3">
        <label name="form-lable">Ngày gia hạn mới</label>
        <input type="date" class="form-control" id="newExpireDate" name="newExpireDate" value="<?= date('Y-m-d') ?>">
        
    </div>
  
    </div>


<div class="table-responsive">

    <table class="table table-bordered table-hover text-center">
      <thead class="table-light">
        
        <tr>
            <th><input type="checkbox" id="selectAll"></th> <!-- Checkbox for Select All -->
            <th>STT</th>
            <th>Số thẻ</th>
            <th>Mã thẻ</th>
            <th>Ngày hết hạn</th>
            <th>Họ tên</th>
            <th>Mã KH</th>
            <th>Nhóm KH</th>
            <th>Phương tiện</th>
            <th>Địa chỉ</th>
            <th>Nhóm thẻ</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($cardLists as $key => $card): ?>
              
                <tr class="card-row"
                data-customer-group-id="<?= htmlspecialchars($card['CustomerGroupID'] ?? '') ?>"
                data-card-group-id="<?= htmlspecialchars($card['CardGroupID'] ?? '') ?>">
                    <td>
                        <input type="checkbox" class="card-checkbox rowCheckbox" value="<?= $card['CardID'] ?>">
                    </td>
                    <td ><?= $key + 1 ?></td>
                    <td class="card-no"><?= $card['CardNo'] ?></td>
                    <td class="card-number"><?= $card['CardNumber'] ?></td>  
                    <td><?= $card['ExpireDate'] ?></td>
                  
                    <td><?= $card['CustomerName'] ?></td>
                    <td><?= $card['CustomerCode'] ?></td>
                    <td><?= $card['CustomerGroupName'] ?></td>
                    <td><?= $card['Plate1'] ?></td>
                    <td><?= $card['Address'] ?></td>
                    <td><?= $card['CardGroupName'] ?></td>
                    
                </tr>
            <?php endforeach; ?>
              
      </tbody>
    </table>
    <div class="col-md-6 d-flex gap-2">
            <div class=" mt-3">
                <button id="renewButton" onclick="ExtendAllCards()" class="btn btn-success btn-sm">Gia hạn 0 thẻ</button>
            </div>

            <div class=" mt-3">
                <button id="renewSelectedButton" onclick="ExtendCards()" class="btn btn-warning btn-sm">Gia hạn 0 thẻ</button>
            </div>
    </div>
    
    
  </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Ẩn tất cả dòng thẻ khi mới vào
    $('.card-row').hide(); 

    // Xử lý tìm kiếm
    $('#searchButton').on('click', function() {
        var searchTerm = $('#searchInput').val().toLowerCase();
        var selectedCustomer = $('#customerSelect').val();
        var cardGroupSelected = $('#cardGroupSelect').val();
        var visibleRows = 0;

        $('.card-row').hide(); // Ẩn tất cả trước

        $('.card-row').each(function() {
            var cardNo = $(this).find('.card-no').text().toLowerCase();
            var customerGroupID = $(this).data('customer-group-id').toString();
            var cardGroupID = $(this).data('card-group-id').toString();

            var matchesSearch = searchTerm === '' || cardNo.includes(searchTerm);
            var matchesCustomer = selectedCustomer === '' || selectedCustomer === customerGroupID;
            var matchesCardGroup = cardGroupSelected === '' || cardGroupSelected === cardGroupID;

            if (matchesSearch && matchesCustomer && matchesCardGroup) {
                $(this).show();
                visibleRows++;
            }
        });

        // Reset checkbox khi tìm kiếm lại
        $('.rowCheckbox').prop('checked', false);
        $('#selectAll').prop('checked', false);

        // Cập nhật nút "Gia hạn tất cả"
        $('#renewButton').text('Gia hạn ' + visibleRows + ' thẻ');

        // Cập nhật nút "Gia hạn đã chọn"
        updateSelectedCount();
    });

    // Nút "Nạp lại"
    $('#reloadButton').on('click', function() {
        location.reload();
    });

    // Tick chọn tất cả các checkbox đang hiển thị
    $('#selectAll').on('change', function() {
        $('.rowCheckbox:visible').prop('checked', $(this).prop('checked'));
        updateSelectedCount();
    });

    // Tick từng checkbox thì cập nhật lại số lượng
    $(document).on('change', '.rowCheckbox', function() {
        updateSelectedCount();

        // Nếu tất cả đều được chọn thì chọn luôn SelectAll
        if ($('.rowCheckbox:visible:checked').length === $('.rowCheckbox:visible').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    // Hàm cập nhật số lượng thẻ được chọn
    function updateSelectedCount() {
        var selectedCount = $('.rowCheckbox:visible:checked').length;
        $('#renewSelectedButton').text('Gia hạn ' + selectedCount + ' thẻ');
    }

    
});

function ExtendCards(){
        var selectedCards = [];
        $('.rowCheckbox:checked').each(function() {
            selectedCards.push($(this).val());
        });

        if (selectedCards.length === 0) {
            alert('Vui lòng chọn ít nhất một thẻ để gia hạn.');
            return;
        }

        var newExpireDate = $('#newExpireDate').val();
        if (!newExpireDate) {
            alert('Vui lòng chọn ngày gia hạn mới.');
            return;
        }

        // Gửi yêu cầu gia hạn thẻ
        $.ajax({
            url: 'http://localhost:8000/api/card-manager/renew-cards',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                cardIds: selectedCards,
                newExpireDate: newExpireDate
            }),
            success: function(response) {
                alert('Gia hạn thành công!');
                location.reload(); // Nạp lại trang sau khi gia hạn
            },
            error: function(xhr, status, error) {
                alert('Lỗi khi gia hạn thẻ: ' + error);
            }
        });
    }
    function ExtendAllCards(){
        var selectedCards = [];
        $('.rowCheckbox:visible').each(function() {
            selectedCards.push($(this).val());
        });
        if (selectedCards.length === 0) {
            alert('Vui lòng chọn ít nhất một thẻ để gia hạn.');
            return;
        }

        var newExpireDate = $('#newExpireDate').val();
        if (!newExpireDate) {
            alert('Vui lòng chọn ngày gia hạn mới.');
            return;
        }
        // Gửi yêu cầu gia hạn thẻ
        $.ajax({
            url: 'http://localhost:8000/api/card-manager/renew-cards',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                cardIds: selectedCards,
                newExpireDate: newExpireDate
            }),
            success: function(response) {
                alert('Gia hạn thành công!');
                location.reload(); // Nạp lại trang sau khi gia hạn
            },
            error: function(xhr, status, error) {
                alert('Lỗi khi gia hạn thẻ: ' + error);
            }
        });
    }
</script>

