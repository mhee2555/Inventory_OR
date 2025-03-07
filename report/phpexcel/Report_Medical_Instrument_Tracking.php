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
$sheet->setTitle("HNCODE");
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
$sheet->mergeCells('E1:K3'); // พิมพ์โดย poseMA
$sheet->mergeCells('E4:K5'); // วันที่พิมพ์
// $sheet->mergeCells('B4:C4'); // เวลา



// --- ใส่ข้อมูล ---


$sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
$sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
$sheet->getCell('E4')->getStyle()->getFont()->setBold(true);


// --- หัวตาราง ---
$sheet->setCellValue('A6', 'ลำดับ');
$sheet->setCellValue('B6', 'รหัสคลังอุปกรณ์ (คลัง Surgical)');
$sheet->setCellValue('C6', 'รายการ');
$sheet->setCellValue('D6', 'Lot No');
$sheet->setCellValue('E6', 'Serial No');
$sheet->setCellValue('F6', 'Exp Lot');
$sheet->setCellValue('G6', 'Qty');
$sheet->setCellValue('H6', 'RefPO');
$sheet->setCellValue('I6', 'วันที่จ่าย');
$sheet->setCellValue('J6', 'HN Code');
$sheet->setCellValue('K6', 'จ่ายให้แผนก');


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

if($db == 1){

    $query = "SELECT
                    hncode.ID,
                    item.itemname,
                    item.LimitUse,
                    itemtype.TyeName,
                    itemstock.UsageCode,
                    item.itemcode,
                    hncode.DocNo,
                    DATE_FORMAT( itemstock.ExpireDate, '%d-%m-%Y' ) AS ExpireDate,
                    DATE_FORMAT( itemstock.expDate, '%d-%m-%Y' ) AS expDate,
                    DATE_FORMAT( hncode.DocDate, '%d-%m-%Y' ) AS DocDate,
                    DATE_FORMAT( itemstock.CreateDate, '%d-%m-%Y' ) AS CreateDate,
                    DATE_FORMAT(hncode.ModifyDate, '%d/%m/%Y') AS date1,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname,
                    hncode_detail.Qty,
                    item2.itemname AS itemname2,
                    item2.itemcode AS itemcode2,
                    itemstock.serielNo,
                    itemstock.lotNo 
                FROM
                    hncode
                    LEFT JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    LEFT JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    LEFT JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                    LEFT JOIN item AS item2 ON item2.ItemCode = hncode_detail.ItemCode 
                WHERE
                    DATE(hncode.DocDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
                    AND hncode.IsStatus = 1 
                    AND hncode.IsCancel = 0 
                    AND hncode_detail.IsStatus != 99 
                ORDER BY
                    hncode.ID ASC ";
    // $query = "SELECT
    //                 hncode.ID,
    //                 item.itemname,
    //                 itemstock.UsageCode,
    //                 item.itemcode2 AS itemcode,
    //                 DATE_FORMAT(itemstock.ExpireDate, '%d-%m-%Y') AS expDate,
    //                 DATE_FORMAT(itemstock.CreateDate, '%d-%m-%Y') AS CreateDate,
    //                 hncode.DocNo,
    //                 hncode.HnCode,
    //                 hncode_detail.Qty,
    //                 departmentroom.departmentroomname,
    //                 itemtype.TyeName,
    //                 item.LimitUse,
    //                 sudslog.UsedCount,
    //                 itemstock.lotNo,
    //                 itemstock.serielNo,
    //                 `procedure`.Procedure_EN AS Procedure_TH,
    //                 DATE_FORMAT(hncode.ModifyDate, '%d/%m/%Y') AS date1,
    //                 doctor.Doctor_Name
    //             FROM
    //                 hncode
    //             INNER JOIN
    //                 departmentroom ON departmentroom.id = hncode.departmentroomid
    //             INNER JOIN
    //                 hncode_detail ON hncode.DocNo = hncode_detail.DocNo
    //             INNER JOIN
    //                 itemstock ON hncode_detail.ItemStockID = itemstock.RowID
    //             INNER JOIN
    //                 item ON itemstock.ItemCode = item.itemcode
    //             INNER JOIN
    //                 itemtype ON item.itemtypeID = itemtype.ID
    //             LEFT JOIN
    //                 sudslog ON sudslog.UniCode = itemstock.UsageCode
    //             LEFT JOIN
    //                 `procedure` ON hncode.`procedure` = `procedure`.ID
    //             LEFT JOIN
    //                 doctor ON doctor.ID = hncode.doctor
    //             WHERE
    //                 DATE(hncode.DocDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
    //                 AND hncode.IsStatus = 1
    //                 AND hncode.IsCancel = 0
    //             ORDER BY
    //                 hncode.ID ASC ";
}else{
    $query = " SELECT
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
                    FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1,
                    doctor.Doctor_Name
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                    LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
                    LEFT JOIN [procedure] ON hncode.[procedure] = [procedure].ID
                    LEFT JOIN  doctor ON doctor.ID = hncode.doctor
                WHERE
                    CONVERT(DATE,hncode.DocDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                    AND hncode.IsStatus = 1
                    AND hncode.IsCancel = 0  
                ORDER BY
                    hncode.ID ASC  ";
}





    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if($row['UsageCode'] == null){
            $row['UsageCode'] = $row['itemcode2'];
            $row['itemname'] = $row['itemname2'];
        }

        $dataArray[] = [$row['UsageCode'], $row['itemname'], $row['lotNo'], $row['serielNo'], $row['ExpireDate'], $row['Qty'], $row['DocNo'], $row['date1'], $row['HnCode'], $row['departmentroomname']];
    }
    
    
    $row = 7;
    $count_cnt = 1;
    foreach ($dataArray as $item) {
        $sheet->setCellValue('A' . $row, (string)$count_cnt);
        $sheet->setCellValue('B' . $row, (string)$item[0]);
        $sheet->setCellValue('C' . $row, (string)$item[1]);
        $sheet->setCellValue('D' . $row, (string)$item[2]);
        $sheet->setCellValue('E' . $row, (string)$item[3]);
        $sheet->setCellValue('F' . $row, (string)$item[4]);
        $sheet->setCellValue('G' . $row, (string)$item[5]);
        $sheet->setCellValue('H' . $row, (string)$item[6]);
        $sheet->setCellValue('I' . $row, (string)$item[7]);
        $sheet->setCellValue('J' . $row, (string)$item[8]);
        $sheet->setCellValue('K' . $row, (string)$item[9]);
        $row++;
        $count_cnt++;
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
// $sheet->getStyle('A6:K' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C7:C' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A7:A' . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
$filename = 'Report_Create_Order_HN.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
