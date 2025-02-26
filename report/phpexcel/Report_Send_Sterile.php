<?php
require 'vendor/autoload.php';
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;


// สร้างไฟล์ Excel
$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("รายงานส่งแลกเครื่องมือ SUDs");
// --- ใส่โลโก้ ---

$sheet->mergeCells('A1:D5');
$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
$drawing->setCoordinates('A1');
$drawing->setOffsetX(250);
$drawing->setOffsetY(10);
$drawing->setHeight(80);
$drawing->setWorksheet($sheet);



// // --- ผสานเซลล์ ---
$sheet->mergeCells('E1:M3'); // พิมพ์โดย poseMA
$sheet->mergeCells('E4:M5'); // วันที่พิมพ์

$sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
$sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));

$sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

$sheet->getStyle('E1')->getFont()->setSize(15);
$sheet->getStyle('E4')->getFont()->setSize(15);
$sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
$sheet->getCell('E4')->getStyle()->getFont()->setBold(true);

$round = $_GET['round'];
$select_date1 = $_GET['select_date1'];
$select_date2 = $_GET['select_date2'];


$select_date1 = explode("-", $select_date1);
$select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];

$select_date2 = explode("-", $select_date2);
$select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];

$sheet->setCellValue('A6', 'เลขเอกสาร');
$sheet->setCellValue('B6', 'เลขเอกสาร RQ');
$sheet->setCellValue('C6', 'ประเภทอุปกรณ์');
$sheet->setCellValue('D6', 'รอบการใช้งาน');
$sheet->setCellValue('E6', 'แพทย์');
$sheet->setCellValue('F6', 'หัตถการ');
$sheet->setCellValue('G6', 'HN Code');
$sheet->setCellValue('H6', 'เครื่องมือ');
$sheet->setCellValue('I6', 'รหัสรายการ');
$sheet->setCellValue('J6', 'รอบการส่ง N-Sterile');
$sheet->setCellValue('K6', 'วันที่');
$sheet->setCellValue('L6', 'เวลา');
$sheet->setCellValue('M6', 'หมายเหตุ');

$sheet->getColumnDimension('A')->setWidth(14);
$sheet->getColumnDimension('B')->setWidth(14);
$sheet->getColumnDimension('C')->setWidth(14);
$sheet->getColumnDimension('D')->setWidth(14);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(25);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(30);
$sheet->getColumnDimension('I')->setWidth(20);
$sheet->getColumnDimension('J')->setWidth(20);
$sheet->getColumnDimension('K')->setWidth(12);
$sheet->getColumnDimension('L')->setWidth(12);
$sheet->getColumnDimension('M')->setWidth(30);

$sheet->getStyle('A6:M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A6:M6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('BEBEBE');
$sheet->getStyle('A6:M6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));


$whereRound = "";
if($round != '0'){
    $whereRound = " AND sendsterile.Round = '$round' ";
}

$dataArray = [];
$query = "SELECT
                sendsterile.DocNo,
                sendsterile.RefDocNo,
                itemtype.TyeName,
                item.LimitUse,
                sudslog.UsedCount,
                ISNULL(doctor.Doctor_Name,'') AS Doctor_Name,
                ISNULL([procedure].Procedure_TH,'') AS Procedure_TH,
                ISNULL(sendsterile.hncode,'') AS hncode,
                item.itemcode,
                item.itemname,
                itemstock.UsageCode,
                sendsterile.Round,
                FORMAT(sendsterile.DocDate,'dd/MM/yyyy') AS Doc_Date,
                FORMAT(sendsterile.DocDate,'HH:mm:ss') AS Doc_Time
            FROM
                sendsterile
                INNER JOIN sendsteriledetail ON sendsteriledetail.SendSterileDocNo = sendsterile.DocNo
                INNER JOIN itemstock ON itemstock.UsageCode = sendsteriledetail.UsageCode
                INNER JOIN item ON item.itemcode = itemstock.ItemCode
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID 
                LEFT JOIN doctor ON sendsterile.Doctor_ID = doctor.ID
                LEFT JOIN [procedure] ON sendsterile.Procedure_ID = [procedure].ID
                LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
            WHERE
                CONVERT ( DATE, sendsterile.DocDate ) BETWEEN '$select_date1' AND '$select_date2' 
                $whereRound
                AND itemtype.TyeName = 'SUDs'
            ORDER BY
                item.LimitUse DESC";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $dataArray[] =  [
                        $row['DocNo'],
                        $row['RefDocNo'],
                        $row['TyeName'],
                        $row['LimitUse'],
                        $row['UsedCount'],
                        $row['Doctor_Name'],
                        $row['Procedure_TH'],
                        $row['hncode'],
                        $row['UsageCode'],
                        $row['itemname'],
                        $row['Round'],
                        $row['Doc_Date'],
                        $row['Doc_Time']
                        ];
    }

    $row = 7; 
    foreach ($dataArray as $item) {
        $sheet->setCellValue('A' . $row, $item[0]);
        $sheet->setCellValue('B' . $row, $item[1]);
        $sheet->setCellValue('C' . $row, $item[2]);
        $sheet->setCellValue('D' . $row, $item[3].'/'.$item[4]);
        $sheet->setCellValue('E' . $row, $item[5]);
        $sheet->setCellValue('F' . $row, $item[6]);
        $sheet->setCellValue('G' . $row, $item[7]);
        $sheet->setCellValue('H' . $row, $item[9]);
        $sheet->setCellValue('I' . $row, $item[8]);
        $sheet->setCellValue('J' . $row, $item[10]);
        $sheet->setCellValue('K' . $row, $item[11]);
        $sheet->setCellValue('L' . $row, $item[12]);
        $sheet->setCellValue('M' . $row, '');


        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $sheet->getStyle('A' . $row.':'.'M' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
        $row++;
    }

// ============================================================================================================================================================================================
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle("รายงานส่งแลกเครื่องมือ Sterile");
    // --- ใส่โลโก้ ---
    
    $sheet->mergeCells('A1:D5');
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setPath('logo.png'); // เปลี่ยนเป็นไฟล์โลโก้ของคุณ
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(250);
    $drawing->setOffsetY(10);
    $drawing->setHeight(80);
    $drawing->setWorksheet($sheet);
    
    
    
    // // --- ผสานเซลล์ ---
    $sheet->mergeCells('E1:M3'); // พิมพ์โดย poseMA
    $sheet->mergeCells('E4:M5'); // วันที่พิมพ์
    
    $sheet->setCellValue('E1', 'พิมพ์โดย poseMA');
    $sheet->setCellValue('E4', 'วันที่พิมพ์ '.date('d/m/Y'). ' ' .date('H:i:s'));
    
    $sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    
    $sheet->getStyle('E1')->getFont()->setSize(15);
    $sheet->getStyle('E4')->getFont()->setSize(15);
    $sheet->getCell('E1')->getStyle()->getFont()->setBold(true);
    $sheet->getCell('E4')->getStyle()->getFont()->setBold(true);
    
    $round = $_GET['round'];
    $select_date1 = $_GET['select_date1'];
    $select_date2 = $_GET['select_date2'];
    
    
    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];
    
    $select_date2 = explode("-", $select_date2);
    $select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];
    
    $sheet->setCellValue('A6', 'เลขเอกสาร');
    $sheet->setCellValue('B6', 'เลขเอกสาร RQ');
    $sheet->setCellValue('C6', 'ประเภทอุปกรณ์');
    $sheet->setCellValue('D6', 'รอบการใช้งาน');
    $sheet->setCellValue('E6', 'แพทย์');
    $sheet->setCellValue('F6', 'หัตถการ');
    $sheet->setCellValue('G6', 'HN Code');
    $sheet->setCellValue('H6', 'เครื่องมือ');
    $sheet->setCellValue('I6', 'จำนวน');
    $sheet->setCellValue('J6', 'รอบการส่ง N-Sterile');
    $sheet->setCellValue('K6', 'วันที่');
    $sheet->setCellValue('L6', 'เวลา');
    $sheet->setCellValue('M6', 'หมายเหตุ');
    
    $sheet->getColumnDimension('A')->setWidth(14);
    $sheet->getColumnDimension('B')->setWidth(14);
    $sheet->getColumnDimension('C')->setWidth(14);
    $sheet->getColumnDimension('D')->setWidth(14);
    $sheet->getColumnDimension('E')->setWidth(25);
    $sheet->getColumnDimension('F')->setWidth(25);
    $sheet->getColumnDimension('G')->setWidth(20);
    $sheet->getColumnDimension('H')->setWidth(30);
    $sheet->getColumnDimension('I')->setWidth(20);
    $sheet->getColumnDimension('J')->setWidth(20);
    $sheet->getColumnDimension('K')->setWidth(12);
    $sheet->getColumnDimension('L')->setWidth(12);
    $sheet->getColumnDimension('M')->setWidth(30);
    
    $sheet->getStyle('A6:M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A6:M6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('BEBEBE');
    $sheet->getStyle('A6:M6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
    
    
    $whereRound = "";
    if($round != '0'){
        $whereRound = " AND sendsterile.Round = '$round' ";
    }
    
    $dataArray = [];

    $query = " SELECT
                    sendsterile.DocNo,
                    sendsterile.RefDocNo,
                    itemtype.TyeName,
                    item.LimitUse,
                    item.itemcode,
                    item.itemname,
                    sendsterile.Round,
                    FORMAT ( sendsterile.DocDate, 'dd/MM/yyyy' ) AS Doc_Date,
                    FORMAT ( sendsterile.DocDate, 'HH:mm:ss' ) AS Doc_Time,
                    COUNT(itemstock.ItemCode) AS cnt
                FROM 
                    sendsterile
                    INNER JOIN sendsteriledetail ON sendsteriledetail.SendSterileDocNo = sendsterile.DocNo
                    INNER JOIN itemstock ON itemstock.UsageCode = sendsteriledetail.UsageCode
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                    INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    CONVERT ( DATE, sendsterile.DocDate ) BETWEEN '$select_date1' AND '$select_date2' 
                    AND itemtype.TyeName = 'Sterile' 
                    $whereRound
                GROUP BY
                    sendsterile.DocNo,
                    sendsterile.RefDocNo,
                    itemtype.TyeName,
                    item.LimitUse,
                    item.itemcode,
                    item.itemname,
                    sendsterile.Round,
                    FORMAT ( sendsterile.DocDate, 'dd/MM/yyyy' ),
                    FORMAT ( sendsterile.DocDate, 'HH:mm:ss' )  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $dataArray[] =  [
                            $row['DocNo'],
                            $row['RefDocNo'],
                            $row['TyeName'],
                            $row['itemname'],
                            $row['cnt'],
                            $row['Round'],
                            $row['Doc_Date'],
                            $row['Doc_Time']
                            ];
        }
    
        $row = 7; 
        foreach ($dataArray as $item) {
            $sheet->setCellValue('A' . $row, $item[0]);
            $sheet->setCellValue('B' . $row, $item[1]);
            $sheet->setCellValue('C' . $row, $item[2]);
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');
            $sheet->setCellValue('H' . $row, $item[3]);
            $sheet->setCellValue('I' . $row, $item[4]);
            $sheet->setCellValue('J' . $row, $item[5]);
            $sheet->setCellValue('K' . $row, $item[6]);
            $sheet->setCellValue('L' . $row, $item[7]);
            $sheet->setCellValue('M' . $row, '');
    
    
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    
            $sheet->getStyle('A' . $row.':'.'M' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
            $row++;
        }



$spreadsheet->setActiveSheetIndex(0);



// --- บันทึกไฟล์ ---
$writer = new Xlsx($spreadsheet);
$filename = 'Report_Send_Sterile.xlsx';
$writer->save($filename);

// --- ส่งไฟล์ให้ดาวน์โหลด ---
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);
unlink($filename);
exit;
