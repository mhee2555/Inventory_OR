<?php

require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');
require('../Class.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("RFID");
// --- ใส่โลโก้ ---


// $sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
$sheet->mergeCells('A2:B2'); // พิมพ์โดย poseMA
$sheet->mergeCells('A4:B4'); // วันที่พิมพ์
$sheet->mergeCells('A6:B6'); // เวลา
// $sheet->mergeCells('A7:B7'); // หัวข้อ "SUDs"


$select_date_history_s = $_GET['select_date_history_s'];
$select_date_history_l = $_GET['select_date_history_l'];
// --- ใส่ข้อมูล ---
$datetime = new DatetimeTH();

$select_date_history_s_SHOW = explode("-", $select_date_history_s);
$select_date_history_l_SHOW = explode("-", $select_date_history_l);

$text_date = "วันที่ : " . $select_date_history_s_SHOW[0] . " " . $datetime->getTHmonthFromnum($select_date_history_s_SHOW[1]) . " " . " พ.ศ." . " " . ($select_date_history_s_SHOW[2] + 543) . " ถึง " .  $select_date_history_l_SHOW[0] . " " . $datetime->getTHmonthFromnum($select_date_history_l_SHOW[1]) . " " . " พ.ศ." . " " . ($select_date_history_l_SHOW[2] + 543);



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

$sheet->setCellValue('A2', 'พิมพ์โดย ' . $_FirstName);
$sheet->setCellValue('A4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->setCellValue('A6', $text_date);

$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);




// --- หัวตาราง ---
$sheet->setCellValue('A7', 'RFID'); // หัวข้อ
$sheet->setCellValue('A8', 'ชื่อเครื่องมือ');
$sheet->setCellValue('B8', 'จำนวน');




$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];


if ($db == 1) {
    $query = " SELECT
                    item.itemname,
                    item.itemcode,
                    SUM( deproomdetailsub.qty_weighing ) AS cnt
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                WHERE
                    DATE( deproom.CreateDate ) BETWEEN '$select_date_history_s'  AND '$select_date_history_l' 
                    AND deproom.IsCancel = 0 
                    AND deproomdetail.IsCancel = 0 
                    AND deproomdetailsub.ItemStockID IS NOT NULL 
                GROUP BY
                    item.itemname,
                    item.itemcode 
                ORDER BY
                    item.itemname ASC  ";
} else {
    $query = "SELECT
    item.itemname ,
    item.itemcode ,
    (
    SELECT COUNT
        ( deproomdetailsub.ID ) 
    FROM
        deproomdetailsub
        INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
    WHERE
        CONVERT ( DATE, deproomdetailsub.PayDate ) BETWEEN '$select_date_history_s'  AND '$select_date_history_l' 
        AND itemstock.ItemCode = item.itemcode
    ) AS cnt,
    itemtype.TyeName 
FROM
    deproom
    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID 
WHERE
    CONVERT ( DATE, deproom.CreateDate ) BETWEEN '$select_date_history_s'  AND '$select_date_history_l' 
    AND deproom.IsCancel = 0 
    AND deproomdetail.IsCancel = 0 
    AND itemtype.TyeName = 'SUDs' 
GROUP BY
    item.itemname,
    item.itemcode,
    itemtype.TyeName 
ORDER BY
    item.itemname ASC ";
}


$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [$row['itemname'], $row['cnt']];
}


$row = 9;
foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $row, $item[0]);
    $sheet->setCellValue('B' . $row, $item[1]);
    $sheet->getRowDimension($row)->setRowHeight(30); // ตั้งค่าความสูงของแถวข้อมูล
    $row++;
}

$sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
$sheet->getStyle('A7')->getFont()->setSize(16)->setBold(true); // หัวข้อ "SUDs" ตัวหนา
$sheet->getStyle('A8:B8')->getFont()->setSize(14)->setBold(true); // หัวตาราง
$sheet->getRowDimension('8')->setRowHeight(30); // ตั้งค่าความสูงของแถวข้อมูล
$sheet->getStyle('A9:B' . ($row - 1))->getFont()->setSize(12); // ข้อมูล


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

$sheet->getStyle('A7:B7')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($row - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B8:B' . ($row - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// --- จัดรูปแบบความกว้างของคอลัมน์ ---
$sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================

// สร้างไฟล์ Excel
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle("items lotincabinet");

// --- ใส่โลโก้ ---
$sheet2->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet2);


// --- ผสานเซลล์ ---
$sheet2->mergeCells('B1:C3'); // พิมพ์โดย poseMA
$sheet2->mergeCells('B4:C5'); // วันที่พิมพ์
$sheet2->mergeCells('A7:B7'); // หัวข้อ "SUDs"



// --- ใส่ข้อมูล ---


$sheet2->setCellValue('B1', 'พิมพ์โดย poseMA');
$sheet2->setCellValue('B4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet2->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet2->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



// --- หัวตาราง ---
$sheet2->setCellValue('A7', 'items lotincabinet'); // หัวข้อ
$sheet2->setCellValue('A8', 'ชื่อเครื่องมือ');
$sheet2->setCellValue('B8', 'จำนวน');

$select_date_history_s = $_GET['select_date_history_s'];
$select_date_history_l = $_GET['select_date_history_l'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];

$query = " SELECT
                item.itemname,
                item.itemcode,
                SUM( deproomdetailsub.qty_weighing ) AS cnt
            FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
            WHERE
                DATE( deproom.CreateDate ) BETWEEN '$select_date_history_s'  AND '$select_date_history_l' 
                AND deproom.IsCancel = 0 
                AND deproomdetail.IsCancel = 0 
                AND deproomdetailsub.ItemStockID IS  NULL 
            GROUP BY
                item.itemname,
                item.itemcode 
            ORDER BY
                item.itemname ASC ";



$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [$row['itemname'], $row['cnt']];
}


$row = 9;
foreach ($dataArray as $item) {
    $sheet2->setCellValue('A' . $row, $item[0]);
    $sheet2->setCellValue('B' . $row, $item[1]);
    $sheet2->getRowDimension($row)->setRowHeight(30); // ตั้งค่าความสูงของแถวข้อมูล
    $row++;
}

$sheet2->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
$sheet2->getStyle('A7')->getFont()->setSize(16)->setBold(true); // หัวข้อ "SUDs" ตัวหนา
$sheet2->getStyle('A8:B8')->getFont()->setSize(14)->setBold(true); // หัวตาราง
$sheet2->getRowDimension('8')->setRowHeight(30); // ตั้งค่าความสูงของแถวข้อมูล
$sheet2->getStyle('A9:B' . ($row - 1))->getFont()->setSize(12); // ข้อมูล


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

$sheet2->getStyle('A7:B7')->applyFromArray($styleArray);
$sheet2->getStyle('A8:A' . ($row - 1))->applyFromArray($styleArray);
$sheet2->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet2->getStyle('B8:B' . ($row - 1))->applyFromArray($styleArray_Center);
// --- จัดรูปแบบความกว้างของคอลัมน์ ---
$sheet2->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet2->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
$sheet2->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ

$spreadsheet->setActiveSheetIndex(0);


// --- บันทึกไฟล์ ---
$writer = new Xlsx($spreadsheet);
$filename = 'Report_Issue_Order_HN.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
