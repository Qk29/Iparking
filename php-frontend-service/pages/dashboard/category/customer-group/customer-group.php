<?php 
    include_once __DIR__ . '/../../../../api/request.php';
     
    // call api to get customer groups
    $customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
    $customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
    $customerGroups = json_decode($customerGroupResponse, true);
    // echo '<pre>';
    // print_r($customerGroups);
    // echo '</pre>';
    // exit;

    function buildCustomerGroupTree($groups, $parentId = '0') {
        $branch = [];
        foreach ($groups as $group) {
            $groupParentId = empty($group['ParentID']) ? '0' : $group['ParentID'];
            if ($groupParentId === $parentId) {
                $children = buildCustomerGroupTree($groups, $group['CustomerGroupID']);
                if ($children) {
                    $group['children'] = $children;
                }
                $branch[] = $group;
            }
        }
        return $branch;
    }

    // Đặt hàm renderCustomerGroupTree ở đây!
    function renderCustomerGroupTree($tree, $level = 0, &$count = 1, $parentLast = []) {
        $total = count($tree);
        $i = 0;
        foreach ($tree as $group) {
            $i++;
            // Xác định ký hiệu cây
            $isLast = ($i === $total);
            $prefix = '';
            if ($level > 0) {
                for ($j = 1; $j < $level; $j++) {
                    $prefix .= !empty($parentLast[$j]) ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '<span style="color:#ccc;">│</span>&nbsp;&nbsp;';
                }
                $prefix .= $isLast ? '<span style="color:#ccc;">└─</span> ' : '<span style="color:#ccc;">├─</span> ';
            }
            // Icon
            $icon = $level === 0 ? '<i class="fa fa-folder-open text-warning me-1"></i>' : '';
            // Màu nền xen kẽ
            $bg = $level === 0 ? '#fff' : ($level === 1 ? '#f8f9fa' : '#f1f3f4');
            ?>
            <li class="list-group-item d-flex py-2 mb-2 align-items-center"
                style="border-radius: 6px; padding-left: <?= 16 + 24 * $level ?>px; background: <?= $bg ?>; border-left: <?= $level > 0 ? '3px solid #dee2e6' : 'none' ?>;">
                <input type="checkbox" name="delete_item[]" value="<?= $group['CustomerGroupID'] ?>" class="form-check-input me-2" >
                <span class="me-2" style="min-width: 28px;"><?= $count++ ?>.</span>
                <span class="flex-grow-1 text-truncate d-flex align-items-center" style="max-width: 200px;">
                    <?= $prefix . $icon ?><span><?= htmlspecialchars($group['CustomerGroupName']) ?></span>
                </span>
                <a href="index.php?page=update-customer-group&id=<?= $group['CustomerGroupID'] ?>" class="text-primary text-decoration-none ms-2" title="Chỉnh sửa">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </li>
            <?php
            if (!empty($group['children'])) {
                $parentLast[$level + 1] = $isLast;
                renderCustomerGroupTree($group['children'], $level + 1, $count, $parentLast);
            }
        }
    }
    
    $customerGroupTree = buildCustomerGroupTree($customerGroups);
   
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
        <?php $count = 1; renderCustomerGroupTree($customerGroupTree, 0, $count, []); ?>
    </ul>
    </form>
</div>
