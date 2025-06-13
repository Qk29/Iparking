<?php 
include_once __DIR__ . '/../../../api/request.php';

// Call API to get customer groups
$customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
$customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
$customerGroups = json_decode($customerGroupResponse, true);

// Call API to get apartment categories
$apartmentCategoryApiUrl = 'http://localhost:8000/api/category/apartment-category';
$apartmentCategoryResponse = apiRequest('GET', $apartmentCategoryApiUrl);
$apartmentCategories = json_decode($apartmentCategoryResponse, true);

// Call API to find customer manager
$CustomerID = $_GET['id'] ?? null;
$customerManager = null;
if ($CustomerID) {
    $apiUrl = 'http://localhost:8000/api/customer-manager/find-customer-manager/' . $CustomerID;
    $response = apiRequest('GET', $apiUrl);
    $customerManager = json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'CustomerID'        => $CustomerID, // Thêm CustomerID để cập nhật
        'CustomerCode'      => $_POST['CustomerCode'] ?? '',
        'CustomerName'      => $_POST['CustomerName'] ?? '',
        'IDNumber'          => $_POST['IDNumber'] ?? '',
        'Mobile'            => $_POST['Mobile'] ?? '',
        'CustomerGroupID'   => $_POST['CustomerGroupID'] ?? '',
        'CompartmentID'     => $_POST['CompartmentID'] ?? '',
        'Address'           => $_POST['Address'] ?? '',
        'EnableAccount'     => isset($_POST['EnableAccount']) ? 1 : 0,
        'Account'           => $_POST['Account'] ?? '',
        'Password'          => $_POST['Password'] ?? '', // Chỉ cập nhật nếu có thay đổi
        'RePassword'        => $_POST['RePassword'] ?? '',
        'Inactive'          => isset($_POST['Inactive']) ? 0 : 1,
        'DateInConstruction'=> $_POST['DateInConstruction'] ?? date('Y-m-d H:i:s'),
        'Birthday'          => $_POST['Birthday'] ?? date('Y-m-d H:i:s'),
        'DateUpdate'        => date('Y-m-d H:i:s'), // Cập nhật thời gian hiện tại khi chỉnh sửa
        'AccessLevelID'     => $_POST['AccessLevelID'] ?? '',
        'Finger1'           => $_POST['Finger1'] ?? '',
        'Finger2'           => $_POST['Finger2'] ?? '',
        'UserIDofFinger'    => $_POST['UserIDofFinger'] ?? 0,
        'DevPass'           => $_POST['DevPass'] ?? '',
        'AccessExpireDate'  => $_POST['AccessExpireDate'] ?? '',
        'UserFaceId'        => $_POST['UserFaceId'] ?? 0,
    ];

    // Kiểm tra nếu có file upload
    if (isset($_FILES['Avatar']) && $_FILES['Avatar']['error'] == 0) {
        $fileTmpPath = $_FILES['Avatar']['tmp_name'];
        $fileData = file_get_contents($fileTmpPath);
        $data['Avatar'] = base64_encode($fileData); // Cập nhật ảnh nếu có
    } elseif (!empty($customerManager['Avatar'])) {
        $data['Avatar'] = $customerManager['Avatar']; // Giữ nguyên ảnh cũ nếu không thay đổi
    }

    // Gửi dữ liệu đến API để cập nhật
    $response = apiRequest('PUT', 'http://localhost:8000/api/customer-manager/update-customer/' . $CustomerID, $data);
    var_dump($response);
    $result = json_decode($response, true);

    // Xử lý phản hồi
    if (!empty($result['status']) && $result['status'] === 'success') {
        echo "<div class='alert alert-success'>Cập nhật khách hàng thành công!</div>";
        echo "<script>window.location.href = 'index.php?page=customer';</script>";
    } else {
        echo "<div class='alert alert-danger'>Cập nhật thất bại!</div>";
    }
}
?>

<div class="container mt-2">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Cập nhật thông tin khách hàng
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Mã KH *</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="CustomerCode" value="<?= htmlspecialchars($customerManager['CustomerCode'] ?? '') ?>" placeholder="Mã KH">
                    </div>
                    <label class="col-sm-2 col-form-label">Tên KH *</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="CustomerName" value="<?= htmlspecialchars($customerManager['CustomerName'] ?? '') ?>" placeholder="Tên KH">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">CMND</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="IDNumber" value="<?= htmlspecialchars($customerManager['IDNumber'] ?? '') ?>" placeholder="CMND">
                    </div>
                    <label class="col-sm-2 col-form-label">Điện thoại</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="Mobile" value="<?= htmlspecialchars($customerManager['Mobile'] ?? '') ?>" placeholder="Điện thoại">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nhóm KH</label>
                    <div class="col-sm-4">
                        <select class="form-select" name="CustomerGroupID">
                            <option value="">-- Chọn nhóm khách hàng --</option>
                            <?php foreach($customerGroups as $customerGroup): ?>
                                <option value="<?= $customerGroup['CustomerGroupID'] ?>" <?= ($customerManager['CustomerGroupID'] ?? '') === $customerGroup['CustomerGroupID'] ? 'selected' : '' ?>>
                                    <?= $customerGroup['CustomerGroupName'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label">Căn hộ</label>
                    <div class="col-sm-4">
                        <select class="form-select" name="CompartmentID">
                            <option value="">-- Chọn căn hộ --</option>
                            <?php foreach($apartmentCategories as $apartmentCategory): ?>
                                <option value="<?= $apartmentCategory['CompartmentID'] ?>" <?= ($customerManager['CompartmentId'] ?? '') === $apartmentCategory['CompartmentID'] ? 'selected' : '' ?>>
                                    <?= $apartmentCategory['CompartmentName'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Địa chỉ</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="Address" rows="3"><?= htmlspecialchars($customerManager['Address'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input type="checkbox" name="EnableAccount" class="form-check-input" <?= ($customerManager['EnableAccount'] ?? 0) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="chophep">Cho phép đăng nhập</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Tên đăng nhập</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="Account" value="<?= htmlspecialchars($customerManager['Account'] ?? '') ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Mật khẩu</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="Password" value="" placeholder="Để trống nếu không thay đổi">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nhập lại mật khẩu</label>
                    <div class="col-sm-10">
                        <input type="password" name="RePassword" class="form-control" placeholder="Để trống nếu không thay đổi">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Ảnh đại diện</label>
                    <div class="col-sm-10">
                        <input type="file" name="Avatar" class="form-control" value="<?= $customerManager['Avatar'] ?? '' ?>">
                        
                    </div>
                </div>

                <input type="hidden" name="Inactive" value="0">
                <input type="hidden" name="DateInConstruction" value="<?= htmlspecialchars($customerManager['DateInConstruction'] ?? date('Y-m-d H:i:s')) ?>">
                <input type="hidden" name="Birthday" value="<?= htmlspecialchars($customerManager['Birthday'] ?? date('Y-m-d H:i:s')) ?>">
                <input type="hidden" name="DateUpdate" value="<?= date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="AccessLevelID" value="<?= htmlspecialchars($customerManager['AccessLevelID'] ?? '') ?>">
                <input type="hidden" name="Finger1" value="<?= htmlspecialchars($customerManager['Finger1'] ?? '') ?>">
                <input type="hidden" name="Finger2" value="<?= htmlspecialchars($customerManager['Finger2'] ?? '') ?>">
                <input type="hidden" name="UserIDofFinger" value="<?= htmlspecialchars($customerManager['UserIDofFinger'] ?? 0) ?>">
                <input type="hidden" name="DevPass" value="<?= htmlspecialchars($customerManager['DevPass'] ?? '') ?>">
                <input type="hidden" name="AccessExpireDate" value="<?= htmlspecialchars($customerManager['AccessExpireDate'] ?? '') ?>">
                <input type="hidden" name="UserFaceId" value="<?= htmlspecialchars($customerManager['UserFaceId'] ?? 0) ?>">

                <div class="mt-4 btn-group-custom">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Lưu và thoát</button>
                    <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
                    <a href="index.php?page=customer-manager" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>