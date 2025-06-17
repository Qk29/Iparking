<?php
require __DIR__ . '/../../../../vendor/autoload.php';
include_once __DIR__ . '/../../../api/request.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

// Gọi API lấy danh sách thẻ
$apiUrl = 'http://localhost:8000/api/card-manager/card-list';
$response = apiRequest('GET', $apiUrl);
$cardLists = json_decode($response, true);

// Tạo file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tên các cột
$sheet->setCellValue('A1', 'CardNo');
$sheet->setCellValue('B1', 'Mã thẻ');
$sheet->setCellValue('C1', 'Nhóm thẻ');
$sheet->setCellValue('D1', 'Biển số');
$sheet->setCellValue('E1', 'Ngày hết hạn');
$sheet->setCellValue('F1', 'Mã KH');
$sheet->setCellValue('G1', 'Tên KH');
$sheet->setCellValue('H1', 'Nhóm KH');
$sheet->setCellValue('I1', 'Địa chỉ');
$sheet->setCellValue('J1', 'Căn hộ');
$sheet->setCellValue('K1', 'Ngày đăng ký');
$sheet->setCellValue('L1', 'Trạng thái');

// In đậm tiêu đề
$sheet->getStyle('A1:L1')->getFont()->setBold(true);

// Ghi dữ liệu
$row = 2;
foreach ($cardLists as $card) {
    $sheet->setCellValue("A{$row}", $card['CardNo']);
    $sheet->setCellValue("B{$row}", $card['CardNumber']);
    $sheet->setCellValue("C{$row}", $card['CardGroupName']);
    $sheet->setCellValue("D{$row}", ''); // Biển số nếu cần thì cập nhật lại
    $sheet->setCellValue("E{$row}", $card['ExpireDate']);
    $sheet->setCellValue("F{$row}", $card['CustomerCode']);
    $sheet->setCellValue("G{$row}", $card['CustomerName']);
    $sheet->setCellValue("H{$row}", $card['CustomerGroupName']);
    $sheet->setCellValue("I{$row}", $card['Address']);
    $sheet->setCellValue("J{$row}", $card['CompartmentId']);
    $sheet->setCellValue("K{$row}", $card['DateRegister']);
    $sheet->setCellValue("L{$row}", $card['Status'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt');
    $row++;
}

// Tạo bảng định dạng (table) Excel
$table = new Table('A1:L' . ($row - 1));
$tableStyle = new TableStyle();
$tableStyle->setShowRowStripes(true);
$table->setStyle($tableStyle);
$sheet->addTable($table);

// Xuất file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="card_list.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
