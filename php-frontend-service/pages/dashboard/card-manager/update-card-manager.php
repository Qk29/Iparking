<?php 
include_once __DIR__ . '/../../../api/request.php';

// Lấy CardID từ URL
$cardId = isset($_GET['id']) ? $_GET['id'] : null;
if (!$cardId) {
    echo "<div class='alert alert-danger'>Không tìm thấy ID thẻ!</div>";
    exit;
}

// Gọi API để lấy thông tin chi tiết thẻ
$cardDetailApiUrl = 'http://localhost:8000/api/card-manager/find-card/' . $cardId;
$cardDetailResponse = apiRequest('GET', $cardDetailApiUrl);

$cardDetail = json_decode($cardDetailResponse, true);





// Lấy danh sách nhóm khách hàng
$customerGroupApiUrl = 'http://localhost:8000/api/category/customer-group';
$customerGroupResponse = apiRequest('GET', $customerGroupApiUrl);
$customerGroups = json_decode($customerGroupResponse, true) ?? [];

// Lấy danh sách nhóm căn hộ
$apartmentCategoryApiUrl = 'http://localhost:8000/api/category/apartment-category';
$apartmentCategoryResponse = apiRequest('GET', $apartmentCategoryApiUrl);
$apartmentCategories = json_decode($apartmentCategoryResponse, true) ?? [];

// Lấy danh sách nhóm thẻ
$cardCategoryApiUrl = 'http://localhost:8000/api/category/card-category';
$cardCategoryResponse = apiRequest('GET', $cardCategoryApiUrl);
$cardCategories = json_decode($cardCategoryResponse, true) ?? [];

// Xử lý form khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("==> Form cập nhật đã được submit");

    // Dữ liệu khách hàng
    $customerData = [
        "CustomerID" => $cardDetail['CustomerID'], // Lấy từ dữ liệu thẻ hiện tại
        "CustomerGroupID" => $_POST['CustomerGroupID'],
        "CustomerCode" => $_POST['CustomerCode'],
        "CustomerName" => $_POST['CustomerName'],
        "Mobile" => $_POST['Mobile'],
        "Address" => $_POST['Address'],
        "CompartmentID" => $_POST['CompartmentID'],
        "IDNumber" => $_POST['IDNumber'],
        'EnableAccount' => 1,
        "Account" => ''
    ];

    // Gửi yêu cầu cập nhật khách hàng
    
    $customerUpdateApiUrl = 'http://localhost:8000/api/customer-manager/update-customer/' . $cardDetail['CustomerID'];
    $customerResponse = apiRequest('PUT', $customerUpdateApiUrl, $customerData);
    error_log("Response API cập nhật khách hàng: " . print_r($customerResponse, true));
    $customerResult = json_decode($customerResponse, true);

    if (!$customerResult) {
        error_log("LỖI: Không nhận được phản hồi JSON hợp lệ từ API khi cập nhật khách hàng");
        echo "<div class='alert alert-danger'>Lỗi khi cập nhật khách hàng!</div>";
        exit;
    }

    if (isset($customerResult['status']) && $customerResult['status'] === 'success') {
        error_log("==> Cập nhật khách hàng thành công");

        // Dữ liệu thẻ
        $cardData = [
            "CardID" => $cardId,
            "CardNo" => $_POST['CardNo'] ?? '',
            "CardGroupID" => $_POST['CardGroupID'] ?? '',
            "Description" => $_POST['Description'] ?? '',
            "CardNumber" => $_POST['CardNumber'] ?? '',
            "DateRegister" => $_POST['DateRegister'] ?? null,
            "DateRelease" => $_POST['DateRelease'] ?? null,
            "ImportDate" => $_POST['ImportDate'] ?? null,
            "ExpireDate" => $_POST['ExpireDate'] ?? null,
            "IsLock" => isset($_POST['IsLock']) ? 1 : 0,
            "Plate1" => $_POST['Plate1'] ?? null,
            "Plate2" => $_POST['Plate2'] ?? null,
            "Plate3" => $_POST['Plate3'] ?? null,
            "VehicleName1" => $_POST['VehicleName1'] ?? null,
            "VehicleName2" => $_POST['VehicleName2'] ?? null,
            "VehicleName3" => $_POST['VehicleName3'] ?? null,
            "CustomerID" => $cardDetail['CustomerID']
        ];

        error_log("Dữ liệu thẻ được gửi để cập nhật: " . print_r($cardData, true));

        // Gửi yêu cầu cập nhật thẻ
        $cardUpdateApiUrl = 'http://localhost:8000/api/card-manager/update-card/' . $cardId;
        $cardResponse = apiRequest('PUT', $cardUpdateApiUrl, $cardData);
        $cardResult = json_decode($cardResponse, true);

        error_log("Kết quả cập nhật thẻ: " . print_r($cardResult, true));

        if (isset($cardResult['status']) && $cardResult['status'] === 'success') {
            echo "<div class='alert alert-success'>Cập nhật khách hàng và thẻ thành công!</div>";
            echo "<script>window.location.href = 'index.php?page=card-customer-manager';</script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi cập nhật thẻ: " . htmlspecialchars($cardResult['message'] ?? 'Không rõ lỗi') . "</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Lỗi khi cập nhật khách hàng: " . htmlspecialchars($customerResult['message'] ?? 'Không rõ lỗi') . "</div>";
        exit;
    }
}


// format date
function formatDate($date) {
    if (!$date) return '';
    return date('Y-m-d', strtotime($date));
}
?>

<div class="container ">
    <h2>Cập nhật thông tin thẻ</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Thông tin thẻ -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">Thông tin thẻ</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>Số thẻ</label>
                            <input type="text" name="CardNo" class="form-control" placeholder="Số thẻ" value="<?= $cardDetail['CardNo'] ?? '' ?>">
                        </div>
                        <div class="form-group required">
                            <label>Nhóm thẻ</label>
                            <select name="CardGroupID" class="form-control">
                                <option value="">-Chọn nhóm thẻ-</option>
                                <?php foreach ($cardCategories as $cardCategory): ?>
                                    <option value="<?= $cardCategory['CardGroupID'] ?>" <?= ($cardDetail['CardGroupID'] ?? '') === $cardCategory['CardGroupID'] ? 'selected' : '' ?>>
                                        <?= $cardCategory['CardGroupName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="Description" class="form-control" placeholder="Mô tả"><?= $cardDetail['Description'] ?? '' ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>Mã thẻ</label>
                            <input type="text" name="CardNumber" class="form-control" placeholder="Mã thẻ" value="<?= $cardDetail['CardNumber'] ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày đăng ký</label>
                            <input type="date" name="DateRegister" class="form-control" value="<?= formatDate($cardDetail['DateRegister']) ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày phát</label>
                            <input type="date" name="DateRelease" class="form-control" value="<?= formatDate($cardDetail['DateRelease']) ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày hoạt động</label>
                            <input type="date" name="ImportDate" class="form-control" value="<?= formatDate($cardDetail['ImportDate']) ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày hết hạn</label>
                            <input type="date" name="ExpireDate" class="form-control" value="<?= formatDate($cardDetail['ExpireDate']) ?? '' ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="IsLock" id="khoaThe" <?= ($cardDetail['IsLock'] ?? 0) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="khoaThe">Khóa thẻ</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin chung -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">Thông tin chung</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>Biển số 1</label>
                            <input type="text" name="Plate1" class="form-control" placeholder="Biển số 1" value="<?= $cardDetail['Plate1'] ?? '' ?>">
                        </div>
                        <div class="form-group required">
                            <label>Biển số 2</label>
                            <input type="text" name="Plate2" class="form-control" placeholder="Biển số 2" value="<?= $cardDetail['Plate2'] ?? '' ?>">
                        </div>
                        <div class="form-group required">
                            <label>Biển số 3</label>
                            <input type="text" name="Plate3" class="form-control" placeholder="Biển số 3" value="<?= $cardDetail['Plate3'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>Tên xe 1</label>
                            <input type="text" name="VehicleName1" class="form-control" placeholder="Tên xe 1" value="<?= $cardDetail['VehicleName1'] ?? '' ?>">
                        </div>
                        <div class="form-group required">
                            <label>Tên xe 2</label>
                            <input type="text" name="VehicleName2" class="form-control" placeholder="Tên xe 2" value="<?= $cardDetail['VehicleName2'] ?? '' ?>">
                        </div>
                        <div class="form-group required">
                            <label>Tên xe 3</label>
                            <input type="text" name="VehicleName3" class="form-control" placeholder="Tên xe 3" value="<?= $cardDetail['VehicleName3'] ?? '' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">Thông tin khách hàng</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Tìm kiếm" disabled>
                        </div>
                        <div class="form-group required">
                            <label>Nhóm KH</label>
                            <select name="CustomerGroupID" class="form-control">
                                <option value="">-Nhóm khách hàng-</option>
                                <?php foreach ($customerGroups as $customerGroup): ?>
                                    <option value="<?= $customerGroup['CustomerGroupID'] ?>" <?= ($cardDetail['CustomerGroupID'] ?? '') === $customerGroup['CustomerGroupID'] ? 'selected' : '' ?>>
                                        <?= $customerGroup['CustomerGroupName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label>Mã KH</label>
                            <input type="text" name="CustomerCode" class="form-control" placeholder="Mã KH" value="<?= $cardDetail['CustomerCode'] ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>SĐT</label>
                            <input type="text" name="Mobile" class="form-control" placeholder="SĐT" value="<?= $cardDetail['Mobile'] ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="Address" class="form-control" placeholder="Địa chỉ" value="<?= $cardDetail['Address'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group required">
                            <label>Nhóm căn hộ</label>
                            <select name="CompartmentID" class="form-control">
                                <option value="">-Chọn nhóm căn hộ-</option>
                                <?php foreach ($apartmentCategories as $apartmentCategory): ?>
                                    <option value="<?= $apartmentCategory['CompartmentID'] ?>" <?= ($cardDetail['CompartmentId'] ?? '') === $apartmentCategory['CompartmentID'] ? 'selected' : '' ?>>
                                        <?= $apartmentCategory['CompartmentName'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tên KH</label>
                            <input type="text" name="CustomerName" class="form-control" placeholder="Tên KH" value="<?= $cardDetail['CustomerName'] ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label>CMT</label>
                            <input type="text" name="IDNumber" class="form-control" placeholder="CMT" value="<?= $cardDetail['IDNumber'] ?? '' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 btn-group-custom">
            <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
            <a href="index.php?page=card-customer-manager" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
</div>