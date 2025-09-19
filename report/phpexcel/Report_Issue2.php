<?php
require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle("Issue");

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

        $where_date = "AND DATE(deproomdetailsub.PayDate) = '$date1'  ";
    } else {
         $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(deproomdetailsub.PayDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}

if ($type_date == 2) {
    $year1 = $year1 - 543;

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(deproomdetailsub.PayDate) = '$month1' AND YEAR(deproom.serviceDate) = '$year1'  ";
    } else {
        $where_date = "AND MONTH(deproomdetailsub.PayDate) BETWEEN '$month1' 	AND '$month2' AND YEAR(deproom.serviceDate) = '$year1' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1 - 543;
    $year2 = $year2 - 543;


    if ($checkyear == 1) {
        $where_date = "AND YEAR(deproomdetailsub.PayDate) = '$year1'  ";
    } else {
        $where_date = "AND YEAR(deproomdetailsub.PayDate) BETWEEN '$year1' 	AND '$year2' ";
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





$sheet->setCellValue('C4', 'พิมพ์โดย '  . $_FirstName);
$sheet->setCellValue('C5', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'Code'); // หัวข้อ
$sheet->setCellValue('B8', 'Name');
$sheet->setCellValue('C8', 'Qty');



$dataArray = [];

$query = "SELECT
            item.itemname,
            item.itemcode2,
            item.itemcode,
            deproomdetail.ID,
            SUM(deproomdetail.Qty) AS cnt,
            COUNT( deproomdetailsub.ID)  AS cnt_pay,
            itemtype.TyeName
            FROM
            deproom
            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
            INNER JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
            INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
            INNER JOIN item ON itemstock.ItemCode = item.itemcode
            INNER JOIN itemtype ON item.itemtypeID = itemtype.ID 
            WHERE
             deproom.IsCancel = 0
            $where_date
            AND deproomdetail.IsCancel = 0
            GROUP BY
            item.itemcode
            ORDER BY
            item.itemname ASC  ";
// echo $query;
// exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $dataArray[] = [
            'itemcode2'   => $row['itemcode2'],
            'itemname'    => $row['itemname'],
            'cnt_pay'   => $row['cnt_pay']
        ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['cnt_pay']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:C8')->applyFromArray([
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

$sheet->getStyle('A9:C' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


$sheet->getStyle('A8:C8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A8:C' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B9:B' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(10); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(40); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(10); // คอลัมน์ B ปรับอัตโนมัติ




$spreadsheet->setActiveSheetIndex(0);

// สร้าง Writer และให้ดาวน์โหลด
$writer = new Xlsx($spreadsheet);
$filename = "Report_Issue.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
