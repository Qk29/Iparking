<?php 
    include_once __DIR__ . '/../../../../api/request.php';
     
    // call api to get customer groups
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);
   
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['delete_selected']) && !empty($_POST['delete_item'])) {
            $deleteItems = $_POST['delete_item'];
            foreach($deleteItems as $deleteCustomerGroupId) {
                
                $deleteUrl = "http://localhost:8000/api/category/customer-group-softdelete/$deleteCustomerGroupId";
                $deleteResponse = apiRequest('PUT', $deleteUrl, ['CustomerGroupID' => $deleteCustomerGroupId]);
                $result = json_decode($deleteResponse, true);
                if (isset($result['status']) && $result['status'] === 'success') {  
                    echo "<script>alert('Đã xóa nhóm khách hàng thành công!');</script>";
                    // Refresh the page to see the changes
                    echo "<script>window.location.href = 'index.php?page=customer-group';</script>";
                } else {
                    echo "<script>alert('Xóa thất bại: " . ($result['message'] ?? 'Lỗi không xác định') . "');</script>";
                }
            }
        }
    }
    
    
?>

<div class=" mt-4" style="max-width: 400px;">
    <h4 class="mb-3">Nhóm khách hàng</h4>
    <form action="" method="post">
    <!-- Buttons -->
    <div class="mb-3">
        <a href="index.php?page=add-customer-group" class="btn btn-sm btn-primary me-2">
            <i class="fa-solid fa-plus"></i> Thêm mới
        </a>
        <button type="submit" name="delete_selected" class="btn btn-sm btn-danger">
            <i class="fa-solid fa-trash"></i> Xóa
        </button>
        
    </div>

    <!-- Danh sách nhóm -->
    <ul class="list-group" style="width: 100%;">
        
    <?php
        $count= 1;
         foreach ($customerGroups as $index => $group): ?>
        <li class="list-group-item d-flex py-2 mb-2" style="border-radius: 6px;">
            <input type="checkbox" name="delete_item[]" value="<?= $group['CustomerGroupID'] ?>" class="form-check-input me-2" >
           
            <span class="me-2" style="min-width: 20px;"><?= $count++ ?>.</span>
            <span class="flex-grow-1 text-truncate" style="max-width: 200px;"><?= $group['CustomerGroupName'] ?></span>
            <a href="index.php?page=update-customer-group&id=<?= $group['CustomerGroupID'] ?>" class="text-primary text-decoration-none" title="Chỉnh sửa">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        </li>
    <?php endforeach; ?>
        
        
    </ul>

    </form>
</div>
