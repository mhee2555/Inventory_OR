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

$sheet->setTitle("สรุปค่าใช้จ่าย");

$type_date = $_GET['type_date'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$month1 = $_GET['month1'];
$month2 = $_GET['month2'];
$checkday = $_GET['checkday'];
$checkmonth = $_GET['checkmonth'];
$checkyear = $_GET['checkyear'];
$year1 = $_GET['year1'];
$year2 = $_GET['year2'];



if ($type_date == 1) {

    if ($checkday == 1) {

        $date1 = explode("-", $date1);

        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "WHERE DATE(itemstock_transaction_detail.CreateDate) = '$date1'  ";
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "WHERE DATE(itemstock_transaction_detail.CreateDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}

if ($type_date == 2) {
    $year1 = $year1-543;

    if ($checkmonth == 1) {
        $where_date = "WHERE MONTH(itemstock_transaction_detail.CreateDate) = '$month1' AND YEAR(itemstock_transaction_detail.CreateDate) = '$year1'   ";

    } else {
        $where_date = "WHERE MONTH(itemstock_transaction_detail.CreateDate) BETWEEN '$month1' 	AND '$month2' AND YEAR(itemstock_transaction_detail.CreateDate) = '$year1'  ";
    }
}

if ($type_date == 3) {
    $year1 = $year1-543;
    $year2 = $year2-543;
    if ($checkyear == 1) {
        $where_date = "WHERE YEAR(itemstock_transaction_detail.CreateDate) = '$year1'  ";

    } else {
        $where_date = "WHERE YEAR(itemstock_transaction_detail.CreateDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}

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

$sheet->setCellValue('E3', 'พิมพ์โดย ' . $_FirstName );
$sheet->setCellValue('E4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('E3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'Code'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'Name');
$sheet->setCellValue('D8', 'HN Code');
$sheet->setCellValue('E8', 'ราคา');


$dataArray = [];

$query = " SELECT
                itemstock.UsageCode,
                item.itemname,
                item.itemcode2,
                itemstock_transaction_detail.hncode,
                item.SalePrice 
            FROM
                itemstock_transaction_detail
                INNER JOIN itemstock ON itemstock_transaction_detail.ItemStockID = itemstock.RowID
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            $where_date AND item.itemtypeID IN (	30,31 )  ";
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

   $cal_cnt = number_format( ($row['SalePrice'] * $row['cnt']) ,2);
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'UsageCode'    => $row['UsageCode'],
        'itemname'   => $row['itemname'],
        'hncode'  => $row['hncode'],
        'SalePrice'      => $row['SalePrice']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['UsageCode']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['hncode']);
    $sheet->setCellValue('E' . $rowIndex, (string)$item['SalePrice']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:E8')->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF643695'  // สีพื้นหลังในรูปแบบ ARGB (เช่น ม่วงอ่อน)
        ],
    ],
    'font' => [
        'color' => [
            'argb' => 'FFFFFFFF' // สีตัวหนังสือ: สีขาว
        ],
    ],
]);



$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];

$styleArray_Center = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];

$sheet->getStyle('A8:E8')->applyFromArray($styleArray);
$sheet->getStyle('A8:E' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B8:E' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B9:B' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('E')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
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
$filename = "Report_item_sale.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
