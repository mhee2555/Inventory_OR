<?php
require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("create_request");
// --- ใส่โลโก้ ---


$sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
$sheet->mergeCells('B1:C3'); // พิมพ์โดย poseMA
$sheet->mergeCells('B4:C5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา



// --- ใส่ข้อมูล ---


$sheet->setCellValue('B1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('B4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
$sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



// --- หัวตาราง ---
$sheet->setCellValue('A8', 'ชื่อเครื่องมือ');
$sheet->setCellValue('B8', 'จำนวน');

$select_date_history_s = $_GET['select_date_history_s'];
$select_date_history_l = $_GET['select_date_history_l'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];

if($db == 1){
    $query = " SELECT
                item.itemname ,
                item.itemcode ,
                SUM( deproomdetail.IsQtyStart ) AS cnt ,
                itemtype.TyeName
                FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                deproom.CreateDate >= '$select_date_history_s 00:00:00' AND deproom.CreateDate <= '$select_date_history_l 23:59:59'
                AND deproom.IsCancel = 0
                AND deproomdetail.IsCancel = 0
                AND deproomdetail.IsStart = 1
                GROUP BY
                item.itemname,
                item.itemcode,
                itemtype.TyeName
                ORDER BY item.itemname ASC  ";
}else{
    $query = " SELECT
                item.itemname ,
                item.itemcode ,
                SUM ( deproomdetail.IsQtyStart ) AS cnt ,
                itemtype.TyeName
                FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                CONVERT(DATE,deproom.CreateDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                AND deproom.IsCancel = 0 
                AND deproomdetail.IsCancel = 0 
                AND deproomdetail.IsStart = 1
                AND itemtype.TyeName = 'SUDs'
                GROUP BY
                item.itemname,
                item.itemcode,
                itemtype.TyeName
                ORDER BY item.itemname ASC  ";
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

$sheet->getStyle('A8:A' . ($row - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B8:B' . ($row - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
// --- จัดรูปแบบความกว้างของคอลัมน์ ---
$sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================


// --- บันทึกไฟล์ ---
$writer = new Xlsx($spreadsheet);
$filename = 'Report_Create_Order_HN.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
