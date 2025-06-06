<?php 
        include_once __DIR__ . '/../../../../api/request.php';

        // call api get-lane
        $getLanesUrl  = 'http://localhost:8000/api/lane/get-all';
        $laneResponse  = apiRequest('GET', $getLanesUrl );
        $lanes  = json_decode($laneResponse, true);
        
        //call api get-vehicle-group
        $getVehicleGroupUrl  = 'http://localhost:8000/api/vehicle-group/get-all';
        $vehicleGroupResponse  = apiRequest('GET', $getVehicleGroupUrl );
        $vehicleGroups  = json_decode($vehicleGroupResponse, true);
        

        // call api to get computer list
        $computerApiUrl = 'http://localhost:8000/api/equipment/computer-list';
        $computerResponse = apiRequest('GET', $computerApiUrl);
        $computers = json_decode($computerResponse, true);

        // call api to get camera list
        $cameraApiUrl = 'http://localhost:8000/api/equipment/camera-list';
        $cameraResponse = apiRequest('GET', $cameraApiUrl);
        $cameras = json_decode($cameraResponse, true);
?>
    <style>
        .form-section {
            border-right: 1px solid #ddd;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-group-custom button {
            margin-right: 10px;
        }
        .permission-box {
            padding-left: 20px;
        }
        .dropdown-item:hover {
            background-color: transparent !important;
        }
    </style>
    

    <div class="container mt-5">
        <h4 class="mb-4">Thêm mới làn</h4>
        <form method="POST">
            <div class="row">
                <!-- Thông tin cơ bản -->
                <div class="col-md-10 mt-2 form-section">
                    <div class="form-group">
                        <label class="form-label">Tên làn <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="LaneName" placeholder="Tên làn">
                    </div>
                </div>

                <div class="col-md-10 mt-2 form-section">
                    <label class="form-label">Máy tính <span class="text-danger">*</span></label>   
                    <select class="form-control" name="PCID" id="">
                        <option value="#">-- Chọn máy tính --</option>
                        <?php foreach ($computers as $computer): ?>
                            <option value="<?= $computer['PCID'] ?>"><?= $computer['ComputerName'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-10 mt-2 form-section">
                    <label class="form-label">Loại làn <span class="text-danger">*</span></label>   
                    <select class="form-control" id="LaneType" name="LaneType">
                        <option value="">--Chọn Loại--</option>
                        <option value="0">0. Vào </option>
                        <option value="1">1. Ra </option>
                        <option value="2">2. Vào - Ra </option>
                        <option value="3">3. Vào - Vào </option>
                        <option value="4">4. Ra - Ra </option>
                        <option value="5">5. Vào - Ra 2</option>
                        <option value="6">6. Quản lý trung tâm</option>
                        <option value="7">7. Làn vào sử dụng FaceID</option>
                        <option value="8">8. Làn ra sử dụng FacceID</option>
                        <option value="9">9. #</option>
                    </select>
                </div>

                <!-- Camera C1, C2, C3  -->
                <div class="col-md-10 mt-2 form-section">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">C1. Ô tô <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C1" name="C1">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">C2. Xe máy <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C2" name="C2">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">C3. Toàn cảnh <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C3" name="C3">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                    </div>
                </div>

                <!-- Camera C4, C5, C6  -->
                <div class="col-md-10 mt-2 form-section" id="c4c5c6Section">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">C4. Ô tô <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C4" name="C4">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">C5. Xe máy <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C5" name="C5">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">C6. Toàn cảnh <span class="text-danger">*</span></label>            
                            <select class="form-control" id="C6" name="C6">
                                <option value="">--Chọn Camera--</option>
                                <?php foreach ($cameras as $camera): ?>
                                    <option value="<?= $camera['CameraID'] ?>"><?= $camera['CameraName'] ?></option>
                                <?php endforeach; ?>
                            </select>     
                        </div>
                    </div>
                </div>

                <!-- Kiểm tra Biển số lúc vào -->
                <div class="col-md-10 mt-2 form-section">      
                    <label class="form-label">Kiểm tra Biển số lúc vào <span class="text-danger">*</span></label>  
                    <select class="form-control" id="CheckPlateLevelIn" name="CheckPlateLevelIn">
                        <option value="1">So sánh >= 4 ký tự (Thẻ tháng)</option>
                        <option value="2">So sánh tất cả ký tự (Thẻ tháng)</option>
                        <option selected="selected" value="0">Không so sánh (Thẻ tháng)</option>
                    </select>
                </div>


                <!-- Kiểm tra Biển số lúc ra  -->
                <div class="col-md-10 mt-2 form-section">
                    <label class="form-label">Kiểm tra Biển số lúc ra <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" id="CheckPlateLevelOut" name="CheckPlateLevelOut">
                                <option value="1">So sánh >= 4 ký tự</option>
                                <option value="2">So sánh tất cả ký tự</option>
                                <option selected="selected" value="0">Không so sánh</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="CheckPlateLevelOutOption2" name="CheckPlateLevelOutOption2">
                                <option value="3">So sánh biển đăng ký, biển vào, biển ra</option>
                                <option value="4">Chỉ so sánh biển vào, biển ra</option>
                                <option value="5">Chỉ so sánh biển ra, biển đăng ký</option>
                            </select>
                        </div>
                    </div>
                </div>

                 <div class="col-md-10 mt-2 form-section">
                    <label class="form-label">Mở barie vào <span class="text-danger">*</span></label>                   
                <select class="form-control" id="OpenBarrieIn1" name="OpenBarrieIn1">
                                <option selected="selected" value="0">Không mở barrie</option>
                                <option value="2">Tự mở với mọi loại thẻ</option>
                                <option value="3">Thẻ tháng đúng BS đăng ký và thẻ lượt</option>
                                <option value="8">Chỉ mở với thẻ tháng</option>
                </select>

                
                <!-- Mở Barrie vào  -->
                <div class="col-md-10 mt-2 form-section">
                    <label class="form-label">Mở Barrie ra <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" id="OpenBarrieOption1" name="OpenBarrieOption1">
                                <option selected="selected" value="0">Không mở barrie</option>
                                <option value="4">Chỉ mở khi BS vào ra giống nhau</option>
                                <option value="5">Mở với mọi trường hợp</option>
                          
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="OpenBarrieOption2" name="OpenBarrieOption2">
                                <option value="2">Tự mở với mọi loại thẻ</option>
                                <option value="6">Chỉ mở với thẻ tháng đúng BS đăng ký</option>
                                <option value="7">Chỉ mở với thẻ lượt</option>
                                <option value="8">Chỉ mở với thẻ tháng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Loại xe làn trái và làn phải  -->
                <div class="col-md-10 mt-4 mb-3 form-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLeft" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Loại xe làn trái <span class="badge badge-light text-dark ml-1">All selected (4)</span>
                                </button>
                                <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuLeft">
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Ô tô</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Xe máy</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Xe đạp</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Xe đạp điện</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuRight" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Loại xe làn phải <span class="badge badge-light text-dark ml-1">All selected (4)</span>
                                </button>
                                <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuRight">
                                    <?php foreach($vehicleGroups as $vehicleGroup): ?>
                                        <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> <?= $vehicleGroup['VehicleGroupName'] ?></label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loại thẻ làn trái và làn phải  -->
                 <div class="col-md-10 mt-4 mb-3 form-section">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLeft" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Loại thẻ làn trái <span class="badge badge-light text-dark ml-1">All selected (4)</span>
                                </button>
                                <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuLeft">
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Thuê bao</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Vé lượt</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Vé miễn phí</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Thẻ vip</label>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuRight" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Loại thẻ làn phải <span class="badge badge-light text-dark ml-1">All selected (4)</span>
                                </button>
                                <div class="dropdown-menu" style="background-color: #6fa8dc;" aria-labelledby="dropdownMenuRight">
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Thuê bao</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Vé lượt</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Vé miễn phí</label>
                                    <label class="dropdown-item" style="color: white !important;"><input type="checkbox" checked> Thẻ vip</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
                    <label class="form-check-label" for="inactiveCheck">Sử dụng vòng (loop)</label>
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
                    <label class="form-check-label" for="inactiveCheck">Tự động in biên lai</label>
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
                    <label class="form-check-label" for="inactiveCheck">Nút miễn phí cho xe ưu tiên</label>
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
                    <label class="form-check-label" for="inactiveCheck">Hiển thị LED</label>
                </div>

                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" name="Inactive" id="inactiveCheck">
                    <label class="form-check-label" for="inactiveCheck">Ngừng sử dụng</label>
                </div>

                
            </div>

            <!-- Buttons -->
            <div class="mt-4 btn-group-custom">
                <button type="submit" class="btn btn-success"><i class="fas fa-sync-alt"></i> Lưu</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu và thoát</button>
                <button type="reset" class="btn btn-secondary"><i class="fas fa-undo"></i> Nhập lại</button>
                <a href="index.php?page=card-category" class="btn btn-warning text-white"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        // Hàm kiểm tra và hiển thị/ẩn C4, C5, C6 dựa trên Loại làn
        function toggleCameraSections() {
            var laneType = $('#LaneType').val();
            var c4c5c6Section = $('#c4c5c6Section');
            
            // Các giá trị Loại làn có 2 làn
            var dualLaneTypes = ['2', '3', '4', '5'];
            
            if (dualLaneTypes.includes(laneType)) {
                c4c5c6Section.show();
            } else {
                c4c5c6Section.hide();
            }
        }

        $(document).ready(function() {
            // Gọi hàm khi trang load và khi thay đổi Loại làn
            toggleCameraSections(); // Kiểm tra lần đầu khi tải trang
            $('#LaneType').change(toggleCameraSections);
        });
    </script>