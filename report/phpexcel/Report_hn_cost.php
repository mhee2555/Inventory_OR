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
// $Userid = $_GET['Userid'];

// $_FirstName = "";
// $user = "SELECT
// 	employee.FirstName 
// FROM
// 	users
// 	INNER JOIN employee ON users.EmpCode = employee.EmpCode
// WHERE users.ID = '$Userid' ";
// $meQuery_user = $conn->prepare($user);
// $meQuery_user->execute();
// while ($row_user = $meQuery_user->fetch(PDO::FETCH_ASSOC)) {
//     $_FirstName = $row_user['FirstName'];
// }


// // --- ใส่ข้อมูล ---
// $datetime = new DatetimeTH();
// $text_date = "วันที่ : " . date('d') . " " . $datetime->getTHmonthFromnum(date('m')) . " พ.ศ. " . (date('Y') + 543);


// $sheet->setCellValue('I3', 'พิมพ์โดย ' . $_FirstName);
// $sheet->setCellValue('I4', $text_date);
// $sheet->setCellValue('I5', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
// $sheet->getStyle('I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getStyle('I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getStyle('I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getCell('I3')->getStyle()->getFont()->setBold(true);
// $sheet->getCell('I4')->getStyle()->getFont()->setBold(true);
// $sheet->getCell('I5')->getStyle()->getFont()->setBold(true);


$DocNo = $_GET['DocNo'];

$query = "SELECT
            CONCAT( employee1.FirstName, ' ', employee1.LastName ) AS name_1,
            DATE_FORMAT( deproom.serviceDate, '%d/%m/%Y' ) AS CreateDate,
            TIME( deproom.serviceDate ) AS CreateTime,
            hncode.HnCode,
            hncode.number_box,
            hncode.DocNo,
            departmentroom.departmentroomname,
            deproom.Remark,
            ( SELECT GROUP_CONCAT( doctor.Doctor_Name SEPARATOR ' , ' ) AS Doctor_Name FROM doctor WHERE FIND_IN_SET( doctor.ID, hncode.doctor ) ) AS Doctor_Name,
            ( SELECT GROUP_CONCAT( `procedure`.Procedure_TH SEPARATOR ' , ' ) AS Procedures FROM `procedure` WHERE FIND_IN_SET( `procedure`.ID, hncode.`procedure` ) ) AS Procedures
            
        FROM
            hncode
            LEFT JOIN users AS user1 ON hncode.UserCode = user1.ID
            LEFT JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
            LEFT JOIN departmentroom ON hncode.departmentroomid = departmentroom.id
            LEFT JOIN doctor ON hncode.doctor = doctor.ID
            LEFT JOIN deproom ON deproom.DocNo = hncode.DocNo_SS 
        WHERE
            hncode.DocNo = '$DocNo' ";
$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $_name1 = $row['name_1'];
    $_HnCode = $row['HnCode'];
    $_number_box = $row['number_box'];
    $_departmentroomname = $row['departmentroomname'];
    $_Doctor_Name = $row['Doctor_Name'];
    $_Procedures = $row['Procedures'];
    $_CreateDate = $row['CreateDate'];
    $_CreateTime = $row['CreateTime'];
    $_Remark = $row['Remark'];

    if($_HnCode == ""){
        $_HnCode = $_number_box;
    }
}

$sheet->setCellValue('F1', 'HN Number : ' . $_HnCode);
$sheet->setCellValue('F2', 'วันที่ : ' . $_CreateDate);
$sheet->setCellValue('F3', 'ห้องผ่าตัด : ' . $_departmentroomname);
$sheet->setCellValue('F4', 'แพทย์ : ' . $_Doctor_Name);
$sheet->setCellValue('F5', 'หัตถการ : ' . $_Procedures);
$sheet->getStyle('F1:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('F1:F5')->getFont()->setSize(14)->setBold(true); // หัวตาราง

// --- หัวตาราง ---
$sheet->setCellValue('A6', 'ลำดับ');
$sheet->setCellValue('B6', 'รหัสอุปกรณ์');
$sheet->setCellValue('C6', 'ประเภท');
$sheet->setCellValue('D6', 'อุปกรณ์');
$sheet->setCellValue('E6', 'จำนวน');
$sheet->setCellValue('F6', 'ราคา');



$dataArray = [];

// if ($db == 1) {

$query = " SELECT
                i.itemname,
                i.itemcode2,
                i.SalePrice,
                MAX(hd.ID)              AS AnyDetailID,   -- แทน ANY_VALUE()
                SUM(hd.Qty)             AS cnt,
                it.TyeName
            FROM
                hncode h
                LEFT JOIN hncode_detail hd
                    ON hd.DocNo = h.DocNo
                -- join itemstock เฉพาะกรณีมี ItemStockID (>0)
                LEFT JOIN itemstock s
                    ON hd.ItemStockID IS NOT NULL
                AND hd.ItemStockID <> 0
                AND s.RowID = hd.ItemStockID
                -- เลือกทาง join ไป item:
                -- - ถ้า ItemStockID มีค่า -> i.itemcode = s.ItemCode
                -- - ถ้า ItemStockID เป็น NULL/0 -> i.itemcode = hd.ItemCode
                LEFT JOIN item i
                    ON (
                        (hd.ItemStockID IS NOT NULL AND hd.ItemStockID <> 0 AND i.itemcode = s.ItemCode)
                    OR (hd.ItemStockID IS NULL OR  hd.ItemStockID = 0  AND i.itemcode = hd.ItemCode)
                    )
                LEFT JOIN itemtype it
                    ON i.itemtypeID = it.ID
            WHERE
                h.DocNo = '$DocNo'
            GROUP BY
                i.itemname, i.itemcode2, i.SalePrice, it.TyeName
            ORDER BY
                i.itemname ASC; ";



$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {


   $cal_cnt = number_format( ($row['SalePrice'] * $row['cnt']) ,2);
   $cal_cnt_real = ($row['SalePrice'] * $row['cnt']);

    $dataArray[] = [
        'itemcode2'   => $row['itemcode2'],
        'TyeName'     => $row['TyeName'],
        'itemname'    => $row['itemname'],
        'cnt'         => $row['cnt'],
        'cal_cnt'   => $cal_cnt,
        'cal_cnt_real'   => $cal_cnt_real
    ];
}


$rowIndex = 7;
$count_cnt = 1;
$sum_cal = 0;
foreach ($dataArray as $item) {
    $sheet->setCellValue('A' . $rowIndex, (string)$count_cnt);
    $sheet->setCellValue('B' . $rowIndex, (string)$item['itemcode2']);
    $sheet->setCellValue('C' . $rowIndex, (string)$item['TyeName']);
    $sheet->setCellValue('D' . $rowIndex, (string)$item['itemname']);
    $sheet->setCellValue('E' . $rowIndex, (string)$item['cnt']);
    $sheet->setCellValue('F' . $rowIndex, (string)$item['cal_cnt']);
    $sheet->getRowDimension($rowIndex)->setRowHeight(30);
    $rowIndex++;
    $count_cnt++;
    $sum_cal += (int)$item['cal_cnt_real'];
}


$sum_cal = number_format( ($sum_cal) ,2);

$sheet->mergeCells('A' . $rowIndex.':'.'E' . $rowIndex); // เวลา
$sheet->setCellValue('A' . $rowIndex, 'รวม');
$sheet->setCellValue('F' . $rowIndex, (string)$sum_cal);
$sheet->getRowDimension($rowIndex)->setRowHeight(30);


$sheet->getStyle('A' . $rowIndex.':'.'E' . $rowIndex)->getFont()->setSize(14)->setBold(true); // หัวตาราง
$sheet->getStyle('A' . $rowIndex.':'.'E' . $rowIndex)->applyFromArray([
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




// $sheet->setCellValue('I3', 'พิมพ์โดย ' . $_FirstName);
// $sheet->setCellValue('I4', $text_date);
// $sheet->setCellValue('I5', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
// $sheet->getStyle('I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getStyle('I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getStyle('I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getCell('I3')->getStyle()->getFont()->setBold(true);
// $sheet->getCell('I4')->getStyle()->getFont()->setBold(true);
// $sheet->getCell('I5')->getStyle()->getFont()->setBold(true);



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
$sheet->getStyle('A6:F' . ($rowIndex))->applyFromArray($styleArray);
$sheet->getStyle('A6:F' . ($rowIndex))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A7:F' . ($rowIndex))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B7:D' . ($rowIndex))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('F7:F' . ($rowIndex))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
// $sheet->getStyle('F7:F' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// $sheet->getStyle('C7:G' . ($rowIndex - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


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
$filename = 'Report_HN_Cost.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
