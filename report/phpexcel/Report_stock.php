<?php
require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

$sheet->setTitle("RFID");



$sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(20);
$drawing->setOffsetY(15);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);


// --- ผสานเซลล์ ---
$sheet->mergeCells('D1:E3'); // พิมพ์โดย poseMA
$sheet->mergeCells('D4:E5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา
// $sheet->mergeCells('A7:B7'); // หัวข้อ "SUDs"



// --- ใส่ข้อมูล ---


$sheet->setCellValue('D1', 'พิมพ์โดย ' . $_FirstName);
$sheet->setCellValue('D4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'จำนวน');


$dataArray = [];

$query = " SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,
                ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage 
            FROM
                (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
                    (
                    SELECT
                        COUNT( RowID ) 
                    FROM
                        itemstock 
                    WHERE
                        ItemCode = item.itemcode 
                        AND ( IsDamage = 0 OR IsDamage IS NULL ) 
                        AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
                    ) AS balance,
                    ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
                FROM
                    item
                    LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
                WHERE
										item.SpecialID = '0' 
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance 
                ) AS sub 
            ORDER BY
            CASE
                    
                    WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
                    0 ELSE 1 
                END,
                sub.cnt DESC ,
                sub.itemname;  ";
            // echo $query;
            // exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'itemname'    => $row['itemname'],
        'calculated_balance'   => $row['calculated_balance']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['calculated_balance']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:D8')->applyFromArray([
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

$sheet->getStyle('A8:D8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A8:D' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
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


$sheet = $spreadsheet->createSheet();
$sheet->setTitle("Weighing Smart Cabinet");




$sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(20);
$drawing->setOffsetY(15);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);


// --- ผสานเซลล์ ---
$sheet->mergeCells('D1:E3'); // พิมพ์โดย poseMA
$sheet->mergeCells('D4:E5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา
// $sheet->mergeCells('A7:B7'); // หัวข้อ "SUDs"



// --- ใส่ข้อมูล ---


$sheet->setCellValue('D1', 'พิมพ์โดย ' . $_FirstName);
$sheet->setCellValue('D4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'จำนวน');


$dataArray = [];

$query = " SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,
                ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage 
            FROM
                (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
                    (
                    SELECT
                        COUNT( RowID ) 
                    FROM
                        itemstock 
                    WHERE
                        ItemCode = item.itemcode 
                        AND ( IsDamage = 0 OR IsDamage IS NULL ) 
                        AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
                    ) AS balance,
                    ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
                FROM
                    item
                    LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
                WHERE
										item.SpecialID = '2' 
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance 
                ) AS sub 
            ORDER BY
            CASE
                    
                    WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
                    0 ELSE 1 
                END,
                sub.cnt DESC ,
                sub.itemname;  ";
            // echo $query;
            // exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'itemname'    => $row['itemname'],
        'calculated_balance'   => $row['calculated_balance']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['calculated_balance']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:D8')->applyFromArray([
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

$sheet->getStyle('A8:D8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A8:D' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ

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


$sheet = $spreadsheet->createSheet();
$sheet->setTitle("อุปกรณ์ทั่วไป");




$sheet->mergeCells('A1:A5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(20);
$drawing->setOffsetY(15);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);


// --- ผสานเซลล์ ---
$sheet->mergeCells('D1:E3'); // พิมพ์โดย poseMA
$sheet->mergeCells('D4:E5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา
// $sheet->mergeCells('A7:B7'); // หัวข้อ "SUDs"



// --- ใส่ข้อมูล ---

$sheet->setCellValue('D1', 'พิมพ์โดย '  . $_FirstName );
$sheet->setCellValue('D4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'จำนวน');


$dataArray = [];

$query = " SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,
                ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage 
            FROM
                (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
                    (
                    SELECT
                        COUNT( RowID ) 
                    FROM
                        itemstock 
                    WHERE
                        ItemCode = item.itemcode 
                        AND ( IsDamage = 0 OR IsDamage IS NULL ) 
                        AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
                    ) AS balance,
                    ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
                FROM
                    item
                    LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
                WHERE
										item.SpecialID = '1' 
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance 
                ) AS sub 
            ORDER BY
            CASE
                    
                    WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
                    0 ELSE 1 
                END,
                sub.cnt DESC ,
                sub.itemname;  ";
            // echo $query;
            // exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'itemname'    => $row['itemname'],
        'calculated_balance'   => $row['calculated_balance']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['calculated_balance']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:D8')->applyFromArray([
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

$sheet->getStyle('A8:D8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A8:D' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$spreadsheet->setActiveSheetIndex(0);

// สร้าง Writer และให้ดาวน์โหลด
$writer = new Xlsx($spreadsheet);
$filename = "Report_stock.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
