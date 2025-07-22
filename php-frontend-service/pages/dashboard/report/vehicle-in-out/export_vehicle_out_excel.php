<?php
if (ob_get_length()) ob_end_clean();
error_reporting(0);
ini_set('display_errors', 0);
require __DIR__ . '/../../../../../vendor/autoload.php'; // Đường dẫn autoload PhpSpreadsheet
include_once __DIR__ . '/../../../../api/request.php'; // Hàm gọi API (apiRequest)

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Lấy dữ liệu từ GET (filter)
$allowedKeys = ['search', 'customerSelect', 'cardGroupSelect', 'from_date', 'to_date'];
$queryParams = [];

foreach ($allowedKeys as $key) {
    if (isset($_GET[$key]) && $_GET[$key] !== '') {
        $queryParams[$key] = $_GET[$key];
    }
}

// Không phân trang trong export
$queryParams['offset'] = 0;
$queryParams['limit'] = 20; // hoặc giới hạn tuỳ nhu cầu

// Gọi API lấy dữ liệu
$apiUrl = 'http://localhost:8000/api/report/vehicle-out?' . http_build_query($queryParams);
$response = apiRequest('GET', $apiUrl);
$data = json_decode($response, true);

// Kiểm tra dữ liệu
$vehicles = $data['data'] ?? [];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tiêu đề cột
$headers = [
    "STT", "CardNo", "Mã thẻ", "Biển số hợp lệ", "Biển số vào", "Biển số ra",
    "Thời gian vào", "Thời gian ra", "Giám sát vào", "Giám sát ra",
    "Ảnh vào", "Ảnh ra", "Nhóm thẻ", "Khách hàng"
];

$colIndex = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($colIndex . '1', $header);
    $colIndex++;
}

// Đổ dữ liệu
$row = 2;
$stt = 1;
foreach ($vehicles as $v) {
    $sheet->setCellValue("A$row", $stt++);
    $sheet->setCellValue("B$row", $v['CardNo']);
    $sheet->setCellValue("C$row", $v['CardNumber']);
    $sheet->setCellValue("D$row", $v['IsPlateInValid'] == 1 ? 'Hợp lệ' : 'Không hợp lệ');
    $sheet->setCellValue("E$row", $v['PlateIn']);
    $sheet->setCellValue("F$row", $v['PlateOut']);
    $sheet->setCellValue("G$row", $v['DatetimeIn']);
    $sheet->setCellValue("H$row", $v['DateTimeOut']);
    $sheet->setCellValue("I$row", $v['UserNameIn']);
    $sheet->setCellValue("J$row", $v['UserNameOut']);
    $sheet->setCellValue("K$row", $v['PicDirIn']);
    $sheet->setCellValue("L$row", $v['PicDirOut']);
    $sheet->setCellValue("M$row", $v['CardGroupName']);
    $sheet->setCellValue("N$row", $v['CustomerName']);
    $row++;
}
while (ob_get_level()) ob_end_clean();
// Tạo file xuất
$filename = 'Bao_cao_xe_ra_' . date('Ymd_His') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
