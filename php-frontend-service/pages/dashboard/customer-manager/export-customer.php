<?php
require __DIR__ . '/../../../../vendor/autoload.php';
include_once __DIR__ . '/../../../api/request.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle;

$customerApiUrl = 'http://localhost:8000/api/customer-manager/customer-list';
$customerResponse = apiRequest('GET', $customerApiUrl);
$customers = json_decode($customerResponse, true);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tên cột
$sheet->setCellValue('A1', 'Mã khách hàng');
$sheet->setCellValue('B1', 'Tên khách hàng');
$sheet->setCellValue('C1', 'Điện thoại');
$sheet->setCellValue('D1', 'Địa chỉ');
$sheet->setCellValue('E1', 'Căn hộ');
$sheet->setCellValue('F1', 'Nhóm khách hàng');
$sheet->setCellValue('G1', 'Trạng thái');

// In đậm hàng tiêu đề
$sheet->getStyle('A1:G1')->getFont()->setBold(true);

$row = 2;
foreach ($customers as $customer) {
    $sheet->setCellValue("A{$row}", $customer['CustomerCode']);
    $sheet->setCellValue("B{$row}", $customer['CustomerName']);
    $sheet->setCellValue("C{$row}", $customer['Mobile']);
    $sheet->setCellValue("D{$row}", $customer['Address']);
    $sheet->setCellValue("E{$row}", $customer['CompartmentName']);
    $sheet->setCellValue("F{$row}", $customer['CustomerGroupName']);
    $sheet->setCellValue("G{$row}", $customer['Inactive'] == 0 ? 'Kích hoạt' : 'Ngừng kích hoạt');
    $row++;
}

// Tạo bảng Excel
$table = new Table('A1:G' . ($row - 1));
$tableStyle = new TableStyle();
$tableStyle->setShowRowStripes(true); // sọc
$table->setStyle($tableStyle);
$sheet->addTable($table);

// Xuất file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="customer_list.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
