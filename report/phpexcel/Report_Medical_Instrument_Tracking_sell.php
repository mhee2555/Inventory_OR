<?php

require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');
require('../Class.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("HNCODE");
// --- ใส่โลโก้ ---


// $sheet->mergeCells('A1:D5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
// $sheet->mergeCells('E1:K3'); // พิมพ์โดย poseMA
// $sheet->mergeCells('E4:K5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา


// --- ใส่ข้อมูล ---
// $Userid = $_SESSION['Userid'];
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


$select_date_history_s = $_GET['select_SDate'];
$select_date_history_l = $_GET['select_EDate'];
// --- ใส่ข้อมูล ---
$datetime = new DatetimeTH();

$select_date_history_s_SHOW = explode("-", $select_date_history_s);
$select_date_history_l_SHOW = explode("-", $select_date_history_l);

$text_date = "วันที่ : " . $select_date_history_s_SHOW[0] . " " . $datetime->getTHmonthFromnum($select_date_history_s_SHOW[1]) . " " . " พ.ศ." . " " . ($select_date_history_s_SHOW[2] + 543) . " ถึง " .  $select_date_history_l_SHOW[0] . " " . $datetime->getTHmonthFromnum($select_date_history_l_SHOW[1]) . " " . " พ.ศ." . " " . ($select_date_history_l_SHOW[2] + 543);



$sheet->setCellValue('F3', 'พิมพ์โดย ' . $_FirstName);
$sheet->setCellValue('F4', $text_date);
$sheet->setCellValue('F5', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getCell('F3')->getStyle()->getFont()->setBold(true);
$sheet->getCell('F4')->getStyle()->getFont()->setBold(true);
$sheet->getCell('F5')->getStyle()->getFont()->setBold(true);


// --- หัวตาราง ---
$sheet->setCellValue('A6', 'ลำดับ');
$sheet->setCellValue('B6', 'วันที่');
$sheet->setCellValue('C6', 'แผนก');
$sheet->setCellValue('D6', 'ประเภท');
$sheet->setCellValue('E6', 'รหัสรายการ');
$sheet->setCellValue('F6', 'อุปกรณ์');




$select_date_history_s = $_GET['select_SDate'];
$select_date_history_l = $_GET['select_EDate'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];

// if ($db == 1) {

$query = " SELECT
                DATE_FORMAT( sell_department.serviceDate, '%d-%m-%Y' ) AS DocDate,
                sell_department.departmentID AS HnCode,
                0 AS number_box,
                department.DepName,
                itemtype.TyeName,
                itemstock.UsageCode,
                item.itemname 
            FROM
                sell_department
                INNER JOIN department ON sell_department.departmentID = department.ID
                INNER JOIN sell_department_detail ON sell_department.DocNo = sell_department_detail.DocNo
                LEFT JOIN itemstock ON sell_department_detail.ItemStockID = itemstock.RowID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                LEFT JOIN item AS item2 ON item2.ItemCode = sell_department_detail.ItemCode 
            WHERE
                DATE( sell_department.serviceDate ) BETWEEN '$select_date_history_s' AND '$select_date_history_l' 
                AND sell_department.IsCancel = 0 
            ORDER BY
                sell_department.ID ASC   ";


$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

    if ($row['HnCode'] == '') {
        $row['HnCode'] = $row['number_box'];
    }

    $dataArray[] = [
        'DocDate'              => $row['DocDate'],
        'DepName'               => $row['DepName'],
        'TyeName'              => $row['TyeName'],
        'UsageCode'            => $row['UsageCode'],
        'itemname'             => $row['itemname']
    ];
}


$rowIndex = 7;
$count_cnt = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count_cnt);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['DocDate']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['DepName']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['TyeName']);
    $sheet->setCellValue('E' . $rowIndex, (string)$item['UsageCode']);
    $sheet->setCellValue('F' . $rowIndex, (string)$item['itemname']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count_cnt++;
}




$sheet->getStyle('A6:F6')->applyFromArray([
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

$sheet->getStyle('A6:F6')->getFont()->setSize(14)->setBold(true); // หัวตาราง


// --- จัดรูปแบบตาราง ---
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

$sheet->getStyle('A6:F6')->applyFromArray($styleArray);
$sheet->getStyle('A6:F' . ($rowIndex - 1))->applyFromArray($styleArray);
$sheet->getStyle('A6:F' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A7:E' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('F7:F' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


$sheet->getColumnDimension('A')->setWidth(10);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(30);
$sheet->getColumnDimension('F')->setWidth(30);


// $sheet->getStyle('A7:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// $sheet->getStyle('B7:B' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// // --- จัดรูปแบบความกว้างของคอลัมน์ ---
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
// $sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================


$spreadsheet->setActiveSheetIndex(0);

// --- บันทึกไฟล์ ---
$writer = new Xlsx($spreadsheet);
$filename = 'Report_Create_sell_department.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
