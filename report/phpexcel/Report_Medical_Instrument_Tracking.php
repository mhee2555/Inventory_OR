<?php
require 'vendor/autoload.php';
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("SUDs");
// --- ใส่โลโก้ ---


$sheet->mergeCells('A1:D5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
$sheet->mergeCells('E1:J3'); // พิมพ์โดย poseMA
$sheet->mergeCells('E4:J5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา



// --- ใส่ข้อมูล ---


$sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
$sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
$sheet->getCell('E4')->getStyle()->getFont()->setBold(true);


// --- หัวตาราง ---
$sheet->setCellValue('A6', 'เลขประจำตัวผู้ป่วย');
$sheet->setCellValue('B6', 'หัตถการ');
$sheet->setCellValue('C6', 'วันที่ส่งเครื่องมือ');
$sheet->setCellValue('D6', 'รหัสเครื่องมือ SUDs');
$sheet->setCellValue('E6', 'ชื่อเครื่องมือ SUDs');
$sheet->setCellValue('F6', 'ประเภท');
$sheet->setCellValue('G6', 'จำนวนครั้งที่ใช้ซ้ำ');
$sheet->setCellValue('H6', 'Request Name');
$sheet->setCellValue('I6', 'Create Request No');
$sheet->setCellValue('J6', 'แผนก');


$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setWidth(45);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);

$select_date_history_s = $_GET['select_SDate'];
$select_date_history_l = $_GET['select_EDate'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];
$query = "SELECT
                    hncode.ID,
                    item.itemname,
                    itemstock.UsageCode,
                    item.itemcode,
                    FORMAT ( itemstock.expDate, 'dd-MM-yyyy' ) AS expDate ,
                    FORMAT ( itemstock.CreateDate, 'dd-MM-yyyy' ) AS CreateDate ,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname,
                    itemtype.TyeName,
                    item.LimitUse,
                    sudslog.UsedCount,
                    itemstock.lotNo,
                    itemstock.serielNo,
                    [procedure].Procedure_EN AS Procedure_TH,
                    FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                    LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
                    LEFT JOIN [procedure] ON hncode.[procedure] = [procedure].ID
                WHERE
                    CONVERT(DATE,hncode.DocDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                    AND hncode.IsStatus = 1
                    AND itemtype.ID = 42
                    AND hncode.IsCancel = 0  
                ORDER BY
                    hncode.ID ASC  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $user_count = $row['UsedCount'] . '/' . $row['LimitUse'];
        $request = 'poseMA';
        $rq = '';


        $dataArray[] = [$row['HnCode'], $row['Procedure_TH'], $row['date1'], $row['UsageCode'], $row['itemname'], $row['TyeName'], $user_count, $request , $rq , $row['departmentroomname']];
    }


    $row = 7; 
    foreach ($dataArray as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $sheet->setCellValue('C' . $row, $item[2]);
        $sheet->setCellValue('D' . $row, $item[3]);
        $sheet->setCellValue('E' . $row, $item[4]);
        $sheet->setCellValue('F' . $row, $item[5]);
        $sheet->setCellValue('G' . $row, $item[6]);
        $sheet->setCellValue('H' . $row, $item[7]);
        $sheet->setCellValue('I' . $row, $item[8]);
        $sheet->setCellValue('J' . $row, $item[9]);
        $row++;
    }

$sheet->getStyle('A6:J6')->getFont()->setSize(14)->setBold(true); // หัวตาราง


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

$sheet->getStyle('A6:J6')->applyFromArray($styleArray);
$sheet->getStyle('A6:J' . ($row - 1))->applyFromArray($styleArray);
$sheet->getStyle('A6:J' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E7:E' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A7:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('B7:B' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// // --- จัดรูปแบบความกว้างของคอลัมน์ ---
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
// $sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================

// สร้างไฟล์ Excel
$sheet = $spreadsheet->createSheet();
$sheet->setTitle("Sterile");


$sheet->mergeCells('A1:D5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
$sheet->mergeCells('E1:J3'); // พิมพ์โดย poseMA
$sheet->mergeCells('E4:J5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา



// --- ใส่ข้อมูล ---


$sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
$sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
$sheet->getCell('E4')->getStyle()->getFont()->setBold(true);


// --- หัวตาราง ---
$sheet->setCellValue('A6', 'เลขประจำตัวผู้ป่วย');
$sheet->setCellValue('B6', 'หัตถการ');
$sheet->setCellValue('C6', 'วันที่ส่งเครื่องมือ');
$sheet->setCellValue('D6', 'รหัสเครื่องมือ Sterile');
$sheet->setCellValue('E6', 'ชื่อเครื่องมือ Sterile');
$sheet->setCellValue('F6', 'ประเภท');
$sheet->setCellValue('G6', 'Request Name');
$sheet->setCellValue('H6', 'Create Request No');
$sheet->setCellValue('I6', 'แผนก');


$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setWidth(45);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);

$select_date_history_s = $_GET['select_SDate'];
$select_date_history_l = $_GET['select_EDate'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];
$query = "SELECT
                    hncode.ID,
                    item.itemname,
                    itemstock.UsageCode,
                    item.itemcode,
                    FORMAT ( itemstock.expDate, 'dd-MM-yyyy' ) AS expDate ,
                    FORMAT ( itemstock.CreateDate, 'dd-MM-yyyy' ) AS CreateDate ,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname,
                    itemtype.TyeName,
                    item.LimitUse,
                    sudslog.UsedCount,
                    itemstock.lotNo,
                    itemstock.serielNo,
                    [procedure].Procedure_EN AS Procedure_TH,
                    FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                    LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
                    LEFT JOIN [procedure] ON hncode.[procedure] = [procedure].ID
                WHERE
                    CONVERT(DATE,hncode.DocDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                    AND hncode.IsStatus = 1
                    AND itemtype.ID = 44
                    AND hncode.IsCancel = 0  
                ORDER BY
                    hncode.ID ASC  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $user_count = $row['UsedCount'] . '/' . $row['LimitUse'];
        $request = 'poseMA';
        $rq = '';


        $dataArray[] = [$row['HnCode'], $row['Procedure_TH'], $row['date1'], $row['UsageCode'], $row['itemname'], $row['TyeName'] , $request , $rq , $row['departmentroomname']];
    }


    $row = 7; 
    foreach ($dataArray as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $sheet->setCellValue('C' . $row, $item[2]);
        $sheet->setCellValue('D' . $row, $item[3]);
        $sheet->setCellValue('E' . $row, $item[4]);
        $sheet->setCellValue('F' . $row, $item[5]);
        $sheet->setCellValue('G' . $row, $item[6]);
        $sheet->setCellValue('H' . $row, $item[7]);
        $sheet->setCellValue('I' . $row, $item[8]);
        $row++;
    }

$sheet->getStyle('A6:I6')->getFont()->setSize(14)->setBold(true); // หัวตาราง


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

$sheet->getStyle('A6:I6')->applyFromArray($styleArray);
$sheet->getStyle('A6:I' . ($row - 1))->applyFromArray($styleArray);
$sheet->getStyle('A6:I' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E7:E' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A7:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('B7:B' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// // --- จัดรูปแบบความกว้างของคอลัมน์ ---
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
// $sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================





// สร้างไฟล์ Excel
$sheet = $spreadsheet->createSheet();
$sheet->setTitle("OR Implant");


$sheet->mergeCells('A1:D5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(50);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// --- ผสานเซลล์ ---
$sheet->mergeCells('E1:J3'); // พิมพ์โดย poseMA
$sheet->mergeCells('E4:J5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา



// --- ใส่ข้อมูล ---


$sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
$sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
$sheet->getCell('E4')->getStyle()->getFont()->setBold(true);


// --- หัวตาราง ---
$sheet->setCellValue('A6', 'เลขประจำตัวผู้ป่วย');
$sheet->setCellValue('B6', 'หัตถการ');
$sheet->setCellValue('C6', 'วันที่ส่งเครื่องมือ');
$sheet->setCellValue('D6', 'รหัสเครื่องมือ OR Implant');
$sheet->setCellValue('E6', 'ชื่อเครื่องมือ OR Implant');
$sheet->setCellValue('F6', 'ประเภท');
$sheet->setCellValue('G6', 'Request Name');
$sheet->setCellValue('H6', 'Create Request No');
$sheet->setCellValue('I6', 'แผนก');
$sheet->setCellValue('J6', 'หมายเลขซีเรียล');
$sheet->setCellValue('K6', 'เลขล็อตการผลิต');


$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setWidth(45);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true);

$select_date_history_s = $_GET['select_SDate'];
$select_date_history_l = $_GET['select_EDate'];


$select_date_history_s = explode("-", $select_date_history_s);
$select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

$select_date_history_l = explode("-", $select_date_history_l);
$select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

$dataArray = [];
$query = "SELECT
                    hncode.ID,
                    item.itemname,
                    itemstock.UsageCode,
                    item.itemcode,
                    FORMAT ( itemstock.expDate, 'dd-MM-yyyy' ) AS expDate ,
                    FORMAT ( itemstock.CreateDate, 'dd-MM-yyyy' ) AS CreateDate ,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname,
                    itemtype.TyeName,
                    item.LimitUse,
                    sudslog.UsedCount,
                    itemstock.lotNo,
                    itemstock.serielNo,
                    [procedure].Procedure_EN AS Procedure_TH,
                    FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                    LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
                    LEFT JOIN [procedure] ON hncode.[procedure] = [procedure].ID
                WHERE
                    CONVERT(DATE,hncode.DocDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                    AND hncode.IsStatus = 1
                    AND itemtype.ID = 43
                    AND hncode.IsCancel = 0  
                ORDER BY
                    hncode.ID ASC  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $user_count = $row['UsedCount'] . '/' . $row['LimitUse'];
        $request = 'poseMA';
        $rq = '';


        $dataArray[] = [$row['HnCode'], $row['Procedure_TH'], $row['date1'], $row['UsageCode'], $row['itemname'], $row['TyeName'], $request , $rq , $row['departmentroomname'], $row['serielNo'], $row['lotNo']];
    }


    $row = 7; 
    foreach ($dataArray as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $sheet->setCellValue('C' . $row, $item[2]);
        $sheet->setCellValue('D' . $row, $item[3]);
        $sheet->setCellValue('E' . $row, $item[4]);
        $sheet->setCellValue('F' . $row, $item[5]);
        $sheet->setCellValue('G' . $row, $item[6]);
        $sheet->setCellValue('H' . $row, $item[7]);
        $sheet->setCellValue('I' . $row, $item[8]);
        $sheet->setCellValue('J' . $row, $item[9]);
        $sheet->setCellValue('K' . $row, $item[10]);
        $row++;
    }

$sheet->getStyle('A6:K6')->getFont()->setSize(14)->setBold(true); // หัวตาราง


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

$sheet->getStyle('A6:K6')->applyFromArray($styleArray);
$sheet->getStyle('A6:K' . ($row - 1))->applyFromArray($styleArray);
$sheet->getStyle('A6:K' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E7:E' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A7:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('B7:B' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// // --- จัดรูปแบบความกว้างของคอลัมน์ ---
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
// $sheet->getColumnDimension('B')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// $sheet->getColumnDimension('C')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
// ====================================================================================================

$spreadsheet->setActiveSheetIndex(0);

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
