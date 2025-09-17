<?php
require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle("ติดตามอุปกรณ์");

$select_follow_month = $_GET['select_follow_month'];
$select_follow_year = $_GET['select_follow_year'];




// --- ใส่โลโก้ ---


// $sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(40);
$drawing->setOffsetY(25);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);


// --- ผสานเซลล์ ---
// $sheet->mergeCells('D1:E3'); // พิมพ์โดย poseMA
// $sheet->mergeCells('D4:E5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา
// $sheet->mergeCells('A7:B7'); // หัวข้อ "SUDs"



// --- ใส่ข้อมูล ---

$Userid = $_GET['Userid'];

$_FirstName = "";
$user = "SELECT
	employee.FirstName 
FROM
	users
	INNER JOIN employee ON users.EmpCode = employee.EmpCode
WHERE users.ID = '$Userid' ";
$meQuery_user = $conn->prepare($user);
$meQuery_user->execute();
while ($row_user = $meQuery_user->fetch(PDO::FETCH_ASSOC)) {
    $_FirstName = $row_user['FirstName'];
}

$sheet->setCellValue('E3', 'พิมพ์โดย ' . $_FirstName);
$sheet->setCellValue('E4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);


use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


// เดือน/ปีที่ต้องการ
$year  = $select_follow_year;
$month = $select_follow_month;
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// หัวคงที่
$sheet->setCellValue('A8', 'ลำดับ');
$sheet->setCellValue('B8', 'อุปกรณ์');

// วางหัววันที่ เริ่มคอลัมน์ C
for ($day = 1; $day <= $daysInMonth; $day++) {
    $colIndex  = $day + 2; // A=1,B=2,C=3
    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
    $cell = $colLetter . '8';

    // ใส่ค่าเป็นตัวเลขแบบ explicit (ตัดปัญหา ValueBinder เดิม)
    $sheet->setCellValueExplicit($cell, $day, DataType::TYPE_NUMERIC);
}

// จัดสไตล์ให้ช่วงหัวข้อทั้งหมดทีเดียว
$lastCol = Coordinate::stringFromColumnIndex(2 + $daysInMonth); // คอลัมน์สุดท้ายของหัววันที่
$sheet->getStyle("A8:B8")->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF643695']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'font' => ['bold' => true,'color' => ['argb' => 'FFFFFFFF']],
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
]);

$sheet->getStyle("C8:{$lastCol}8")->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF643695']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'font' => ['bold' => true,'color' => ['argb' => 'FFFFFFFF']],
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
]);

// (ถ้าต้องการ) ตั้งความสูงแถวหัวตารางให้ดูเนียน
$sheet->getRowDimension(8)->setRowHeight(22);









use PhpOffice\PhpSpreadsheet\Style\Border;

// ======================
// 1) ตั้งค่าพื้นฐาน
// ======================
$year  = (int)$select_follow_year;   // เช่น 2025
$month = (int)$select_follow_month;  // เช่น 9
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$startDate = sprintf('%04d-%02d-01', $year, $month);
$endDate   = date('Y-m-t', strtotime($startDate)); // วันสุดท้ายของเดือน

$headerRow = 8;      // แถวหัวตาราง (เราทำไปแล้ว: A8=Code, B8=ชื่อรายการ, C8..=1..สิ้นเดือน)
$dataStartRow = $headerRow + 1;  // เริ่มข้อมูลที่แถว 9

// เตรียม array วันที่ 1..สิ้นเดือนในรูปแบบ Y-m-d
$days = [];
for ($d = 1; $d <= $daysInMonth; $d++) {
    $days[$d] = sprintf('%04d-%02d-%02d', $year, $month, $d);
}

// ======================
// 2) ดึงรายการ item ที่ต้องตาม (จาก set_item_daily) + ชื่อ
// ======================
$sqlItems = "
    SELECT DISTINCT d.itemcode, d.itemname
    FROM daily_stock_item d
    WHERE d.itemcode IN (SELECT s.itemCode FROM set_item_daily s)
      AND d.snapshot_date >= :startDate
      AND d.snapshot_date <  DATE_ADD(:endDate, INTERVAL 1 DAY)
      GROUP BY d.itemcode 
    ORDER BY d.itemname, d.itemcode

";
$stmItems = $conn->prepare($sqlItems);
$stmItems->execute([':startDate' => $startDate, ':endDate' => $endDate]);
$items = $stmItems->fetchAll(PDO::FETCH_ASSOC);

// ถ้าอยากรวม item ที่อยู่ใน set_item_daily แต่เดือนนี้ไม่มีบันทึก ก็สามารถดึงจาก set_item_daily ตรง ๆ แล้ว LEFT JOIN เข้า daily_stock_item เพิ่มเติมได้เช่นกัน

if (!$items) {
    // ไม่มีข้อมูล
    // คุณอาจจะแจ้งข้อความหรือข้ามได้เลย
}

// ======================
// 3) ดึงค่าคงเหลือทั้งเดือนของทุก item ครั้งเดียว
//     คืนมาเป็น: [itemcode][Y-m-d] = calculated_balance
// ======================
$sqlData = "
    SELECT DATE(d.snapshot_date) AS ddate, d.itemcode, COALESCE(d.calculated_balance, 0) AS val
    FROM daily_stock_item d
    WHERE d.itemcode IN (SELECT s.itemCode FROM set_item_daily s)
      AND d.snapshot_date >= :startDate
      AND d.snapshot_date <  DATE_ADD(:endDate, INTERVAL 1 DAY)
";
$stmData = $conn->prepare($sqlData);
$stmData->execute([':startDate' => $startDate, ':endDate' => $endDate]);

$byItemByDay = []; // เช่น $byItemByDay['I00152']['2025-09-03'] = 12
while ($r = $stmData->fetch(PDO::FETCH_ASSOC)) {
    $byItemByDay[$r['itemcode']][$r['ddate']] = (float)$r['val'];
}

// ======================
// 4) เขียนข้อมูลลง Excel
//    คอลัมน์: A=count, B=ชื่อรายการ, C..=วัน 1..สิ้นเดือน
// ======================
$row = $dataStartRow;
$running = 1;

foreach ($items as $it) {
    $itemcode = $it['itemcode'];
    $itemname = $it['itemname'];

    // A: ลำดับ
    $sheet->setCellValueExplicit("A{$row}", $running, DataType::TYPE_NUMERIC);
    // B: ชื่อรายการ (หรือจะใส่รหัสในคอลัมน์ A แล้วชื่อรายการคอลัมน์ B ตามที่ต้องการ)
    $sheet->setCellValueExplicit("B{$row}", $itemname, DataType::TYPE_STRING);

    // เติมค่าวัน 1..สิ้นเดือน
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $colIndex  = $day + 2; // C=3 (เพราะ A=1,B=2)
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $cellAddr  = $colLetter . $row;

        $dateKey = $days[$day]; // Y-m-d
        $val = isset($byItemByDay[$itemcode][$dateKey]) ? $byItemByDay[$itemcode][$dateKey] : 0;

        // ถ้าต้องการ int ให้เป็นตัวเลขจริง (ไม่แปลงเป็น string)
        $sheet->setCellValueExplicit($cellAddr, $val, DataType::TYPE_NUMERIC);

        // จัดกึ่งกลางแนวนอนให้คอลัมน์วันที่อ่านง่าย
        $sheet->getStyle($cellAddr)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    // (ออปชั่น) จัดขอบแถวทั้งหมด
    $lastColLetter = Coordinate::stringFromColumnIndex(2 + $daysInMonth);
    $sheet->getStyle("A{$row}:{$lastColLetter}{$row}")
          ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_HAIR);

    $row++;
    $running++;
}

// (ออปชั่น) ปรับความกว้างคอลัมน์ A,B เล็กน้อย
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getStyle("A{$dataStartRow}:A".($row-1))
      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// (ถ้าต้องการ) Freezepane ให้อ่านง่าย: ล็อคหัวคอลัมน์/บรรทัด
$sheet->freezePane('C9'); // เลื่อนแล้วให้คอลัมน์ A,B และแถว 1..8 ค้าง






















// $sheet->setCellValue('A8', 'Code'); // หัวข้อ
// $sheet->setCellValue('B8', 'รหัสอุปกรณ์');
// $sheet->setCellValue('C8', 'Name');
// $sheet->setCellValue('D8', 'HN Code');
// $sheet->setCellValue('E8', 'ราคา');


// $dataArray = [];

// $query = " SELECT
//                 itemstock.UsageCode,
//                 item.itemname,
//                 item.itemcode2,
//                 itemstock_transaction_detail.hncode,
//                 item.SalePrice 
//             FROM
//                 itemstock_transaction_detail
//                 INNER JOIN itemstock ON itemstock_transaction_detail.ItemStockID = itemstock.RowID
//                 INNER JOIN item ON itemstock.ItemCode = item.itemcode 
//             $where_date AND item.itemtypeID IN (	30,31 )  ";
// $meQuery = $conn->prepare($query);
// $meQuery->execute();

// while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

//    $cal_cnt = number_format( ($row['SalePrice'] * $row['cnt']) ,2);
//     $dataArray[] = [
//         'itemcode2'   => $row['itemcode2'],
//         'UsageCode'    => $row['UsageCode'],
//         'itemname'   => $row['itemname'],
//         'hncode'  => $row['hncode'],
//         'SalePrice'      => $row['SalePrice']
//     ];
// }

// $rowIndex = 9;
// $count = 1;

// foreach ($dataArray as $item) {
//     $sheet->setCellValue('A' . $rowIndex, (string)$item['itemcode2']);
//     $sheet->setCellValue('B' . $rowIndex, (string)$item['UsageCode']);
//     $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
//     $sheet->setCellValue('D' . $rowIndex, (string)$item['hncode']);
//     $sheet->setCellValue('E' . $rowIndex, (string)$item['SalePrice']);
//     $sheet->getRowDimension($rowIndex)->setRowHeight(30);
//     $rowIndex++;
//     $count++;
// }


// $sheet->getStyle('A8:E8')->applyFromArray([
//     'fill' => [
//         'fillType' => Fill::FILL_SOLID,
//         'startColor' => [
//             'argb' => 'FF643695'  // สีพื้นหลังในรูปแบบ ARGB (เช่น ม่วงอ่อน)
//         ],
//     ],
//     'font' => [
//         'color' => [
//             'argb' => 'FFFFFFFF' // สีตัวหนังสือ: สีขาว
//         ],
//     ],
// ]);



// $styleArray = [
//     'borders' => [
//         'allBorders' => [
//             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//         ],
//     ],
//     'alignment' => [
//         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
//         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
//     ],
// ];

// $styleArray_Center = [
//     'borders' => [
//         'allBorders' => [
//             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//         ],
//     ],
//     'alignment' => [
//         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
//         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
//     ],
// ];

// $sheet->getStyle('A8:E8')->applyFromArray($styleArray);
// $sheet->getStyle('A8:E' . ($rowIndex - 1))->applyFromArray($styleArray);

// $sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('B8:E' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

// $sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// $sheet->getStyle('B9:B' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);



// // $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// // $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('E')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================
// ====================================================================================================


// สร้าง Writer และให้ดาวน์โหลด
$writer = new Xlsx($spreadsheet);
$filename = "Report_follow_item.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
