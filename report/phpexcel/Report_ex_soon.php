<?php
session_start();
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

$sheet->setTitle("exsoon");




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

$GN_WarningExpiringSoonDay = $_GET['GN_WarningExpiringSoonDay'];
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

$sheet->setCellValue('D3', 'พิมพ์โดย ' . $_FirstName );
$sheet->setCellValue('D4', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
$sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



$sheet->setCellValue('A8', 'ลำดับ'); // หัวข้อ
$sheet->setCellValue('B8', 'รหัสอุปกรณ์');
$sheet->setCellValue('C8', 'อุปกรณ์');
$sheet->setCellValue('D8', 'วันหมดอายุ');


$dataArray = [];

$deproom = $_SESSION['deproom'];
$RefDepID = $_SESSION['RefDepID'];
$wheredep = "";
if ($RefDepID  == '36DEN') {
    $wheredep = "AND itemstock.departmentroomid = '$deproom'  AND  itemstock.IsDeproom = 1  ";
} else {
    $wheredep = "AND  itemstock.IsDeproom = 0 ";
}
$permission = $_SESSION['permission'];

$wherepermission = "";
if ($permission != '5') {
    $wherepermission = " AND item.warehouseID = $permission ";
}


$query = " SELECT
                itemstock.ItemCode,
                itemstock.UsageCode,
                itemstock.RowID,
                DATE_FORMAT( itemstock.ExpireDate, '%d/%m/%Y' ) AS ExpireDate,
                COUNT( itemstock.Qty ) AS Qty,
            CASE
                    
                    WHEN DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                    AND DATE_ADD( CURDATE(), INTERVAL $GN_WarningExpiringSoonDay DAY ) 
                    AND DATE( itemstock.ExpireDate ) != CURDATE() THEN
                        'ใกล้หมดอายุ' ELSE 'หมดอายุ' 
                    END AS IsStatus,
                CASE
                        
                        WHEN DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                        AND DATE_ADD( CURDATE(), INTERVAL $GN_WarningExpiringSoonDay  DAY ) 
                        AND DATE( itemstock.ExpireDate ) != CURDATE() THEN
                            DATEDIFF(
                                itemstock.ExpireDate,
                            CURDATE()) ELSE DATEDIFF( CURDATE(), itemstock.ExpireDate ) 
                        END AS Exp_day,
                        item.itemname 
                    FROM
                        itemstock
                        LEFT JOIN item ON item.itemcode = itemstock.ItemCode 
                    WHERE
                        itemstock.IsCancel = 0 
                        $wherepermission
                        $wheredep
                        AND (
                            DATE( itemstock.ExpireDate ) <= CURDATE() 
                            OR DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                            AND DATE_ADD( CURDATE(), INTERVAL  $GN_WarningExpiringSoonDay DAY ) 
                        ) 
                    GROUP BY
                        itemstock.UsageCode 
                    HAVING
                        IsStatus = 'ใกล้หมดอายุ' 
                    ORDER BY
                    item.itemname,
                DATE( itemstock.ExpireDate ) ASC;  ";

$meQuery = $conn->prepare($query);
$meQuery->execute();

while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

    $dataArray[] = [
        'UsageCode'   => $row['UsageCode'],
        'itemname'    => $row['itemname'],
        'ExpireDate'  => $row['ExpireDate']
    ];

}

$rowIndex = 9;
$count = 1;

foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['UsageCode']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['ExpireDate']);
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
$sheet->getStyle('A8:D' . ($rowIndex - 1))->applyFromArray($styleArray);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A8:D' . ($rowIndex - 1))->applyFromArray($styleArray_Center);

$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C9:C' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);



// $sheet->getStyle('A1')->getFont()->setSize(20); // หัวข้อใหญ่
// $sheet->getColumnDimension('A')->setWidth(40); // คอลัมน์ A กว้างขึ้น
$sheet->getColumnDimension('A')->setWidth(10); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('B')->setWidth(20); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('C')->setWidth(55); // คอลัมน์ B ปรับอัตโนมัติ
$sheet->getColumnDimension('D')->setWidth(15); // คอลัมน์ B ปรับอัตโนมัติ
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
$filename = "Report_exsoon.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
