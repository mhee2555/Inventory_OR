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

$sheet->setTitle("RFID");

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

        $where_date = "AND DATE(log_cabinet.ModifyDate) = '$date1'  ";
    } else {
         $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {

    $year1 = $year1 - 543;

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) = '$month1' AND YEAR(log_cabinet.ModifyDate) = '$year1'  ";
    } else {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) BETWEEN '$month1' 	AND '$month2' AND YEAR(log_cabinet.ModifyDate) = '$year1' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1 - 543;
    $year2 = $year2 - 543;

    if ($checkyear == 1) {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) = '$year1'  ";
    } else {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) BETWEEN '$year1' 	AND '$year2' ";
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





$sheet->setCellValue('H4', 'พิมพ์โดย '  . $_FirstName );
$sheet->setCellValue('H5', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('H4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('H5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'รหัสใช้งาน');
$sheet->setCellValue('E8', 'ผู้เบิก');
$sheet->setCellValue('F8', 'วันที่/เวลา');
$sheet->setCellValue('G8', 'HN Code');
$sheet->setCellValue('H8', 'สถานะ');


$dataArray = [];

$query = " SELECT
                item.itemcode2,
                item.itemname,
                itemstock.UsageCode,
                CONCAT( employee.FirstName, ' ', employee.LastName ) AS Issue_Name,
                log_cabinet.ModifyDate,
                hncode.HnCode,
                users.ID AS users_ID,
            CASE
                    
                    WHEN hncode.HnCode IS NOT NULL THEN
                    'ถูกยิงใช้กับคนไข้' ELSE 'ไม่ถูกยิงใช้กับคนไข้' 
            END AS STATUS 
            FROM
                log_cabinet
                INNER JOIN itemstock ON log_cabinet.Rfid = itemstock.RfidCode
                INNER JOIN item ON itemstock.ItemCode = item.itemcode
                INNER JOIN users ON log_cabinet.UserID = users.ID
                INNER JOIN employee ON users.EmpCode = employee.EmpCode
                LEFT JOIN hncode_detail ON itemstock.RowID = hncode_detail.ItemStockID
                LEFT JOIN hncode ON hncode_detail.DocNo = hncode.DocNo 
            WHERE
                log_cabinet.Rfid IS NOT NULL
                $where_date 
            ORDER BY log_cabinet.ModifyDate  ";
            // echo $query;
            // exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'itemname'    => $row['itemname'],
        'UsageCode'   => $row['UsageCode'],
        'Issue_Name'  => $row['Issue_Name'],
        'ModifyDate'  => $row['ModifyDate'],
        'HnCode'      => $row['HnCode'],
        'STATUS'      => $row['STATUS']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['UsageCode']);
    $sheet->setCellValue('E' . $rowIndex, (string)$item['Issue_Name']);
    $sheet->setCellValue('F' . $rowIndex, (string)$item['ModifyDate']);
    $sheet->setCellValue('G' . $rowIndex, (string)$item['HnCode']);
    $sheet->setCellValue('H' . $rowIndex, (string)$item['STATUS']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:H8')->applyFromArray([
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

$sheet->getStyle('A8:H8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B8:H' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('E')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('F')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('G')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('H')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
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
$sheet->setTitle("lotincabinet");


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

        $where_date = "AND DATE(log_cabinet.ModifyDate) = '$date1'  ";
    } else {
         $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {

    $year1 = $year1 - 543;

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) = '$month1' AND YEAR(log_cabinet.ModifyDate) = '$year1'  ";
    } else {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) BETWEEN '$month1' 	AND '$month2' AND YEAR(log_cabinet.ModifyDate) = '$year1' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1 - 543;
    $year2 = $year2 - 543;

    if ($checkyear == 1) {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) = '$year1'  ";
    } else {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}
// --- ใส่โลโก้ ---


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


$sheet->setCellValue('D1', 'พิมพ์โดย '. $_FirstName);
$sheet->setCellValue('D4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'ผู้เบิก');
$sheet->setCellValue('E8', 'วันที่/เวลา');
$sheet->setCellValue('F8', 'Qty');


$dataArray = [];

$query = " SELECT
                item.itemcode2,
                item.itemname,
                users.ID AS users_ID,
                NULL AS UsageCode,
                CONCAT(employee.FirstName, ' ', employee.LastName) AS Issue_Name,
                log_cabinet.ModifyDate,
                log_cabinet.Qty
            FROM
                log_cabinet
                INNER JOIN item ON log_cabinet.itemcode = item.itemcode
                INNER JOIN users ON log_cabinet.UserID = users.ID
                INNER JOIN employee ON users.EmpCode = employee.EmpCode
            WHERE   log_cabinet.Rfid IS NULL 
                $where_date  ";
            // echo $query;
            // exit;
$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'itemname'    => $row['itemname'],
        'Issue_Name'  => $row['Issue_Name'],
        'ModifyDate'  => $row['ModifyDate'],
        'Qty'         => $row['Qty']
    ];
}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['Issue_Name']);
    $sheet->setCellValue('E' . $rowIndex, (string)$item['ModifyDate']);
    $sheet->setCellValue('F' . $rowIndex, (string)$item['Qty']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count++;
}


$sheet->getStyle('A8:F8')->applyFromArray([
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

$sheet->getStyle('A8:F8')->applyFromArray($styleArray);
$sheet->getStyle('A8:A' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B8:F' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('E')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('F')->setWidth(30); // คอลัมน์ B ปรับอัตโนมัติ


$spreadsheet->setActiveSheetIndex(0);

// สร้าง Writer และให้ดาวน์โหลด
$writer = new Xlsx($spreadsheet);
$filename = "Report_log_cabinet.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
