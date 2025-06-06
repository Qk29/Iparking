<?php
require __DIR__ . '/../../../../../vendor/autoload.php';
include_once __DIR__ . '/../../../../api/request.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Gọi API để lấy danh sách LED
$ledApiUrl = 'http://localhost:8000/api/equipment/led-list';
$ledResponse = apiRequest('GET', $ledApiUrl);
$leds = json_decode($ledResponse, true);

// Tạo đối tượng spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tên cột
$sheet->setCellValue('A1', 'Tên LED');
$sheet->setCellValue('B1', 'Tên Máy tính');
$sheet->setCellValue('C1', 'Comport');
$sheet->setCellValue('D1', 'Baudrate');
$sheet->setCellValue('E1', 'Thiết bị hiển thị');
$sheet->setCellValue('F1', 'Trạng thái');

$row = 2;
foreach ($leds as $led) {
    $sheet->setCellValue("A{$row}", $led['LEDName']);
    $sheet->setCellValue("B{$row}", $led['ComputerName']);
    $sheet->setCellValue("C{$row}", $led['Comport']);
    $sheet->setCellValue("D{$row}", $led['Baudrate']);
    $sheet->setCellValue("E{$row}", $led['LedType']);
    $sheet->setCellValue("F{$row}", $led['EnableLED'] == 1 ? 'Kích hoạt' : 'Ngừng kích hoạt');
    $row++;
}

// Gửi file Excel về trình duyệt
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="led_list.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
