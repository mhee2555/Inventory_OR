<?php
require 'vendor/autoload.php';

require('../../config/db.php');
require('../../connect/connect.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// ถ้าไม่อยากเห็น warning อื่น ๆ เพิ่มได้ (ไม่บังคับ)
// error_reporting(E_ALL & ~E_WARNING);

// ============================= เตรียมโลโก้ =============================
$logoFile = __DIR__ . '/../images/logo1.png'; // ปรับตามโครงสร้างโฟลเดอร์จริง

// ============================= สร้างไฟล์ Excel =========================
$spreadsheet = new Spreadsheet();

// style พื้นฐานใช้ร่วมกันทุกชีต
$headerFill = [
    'fillType' => Fill::FILL_SOLID,
    'startColor' => ['argb' => 'FF663399'], // ม่วงเข้ม
];
$headerFontWhite = [
    'color' => ['argb' => 'FFFFFFFF'],
];

$styleBorderCenter = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical'   => Alignment::VERTICAL_CENTER,
    ],
];

$styleBorderLeft = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_LEFT,
        'vertical'   => Alignment::VERTICAL_CENTER,
    ],
];

// ฟังก์ชันช่วยสร้างโลโก้ในชีต
function addLogoIfExists($sheet, $logoFile)
{
    if (file_exists($logoFile)) {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath($logoFile);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setHeight(60);
        $drawing->setWorksheet($sheet);
    }
}

// ======================================================================
// RFID SmartCabinet → 3 ชีต: RFID 1, RFID 2, RFID 3
// mapping: StockID 2->1, 1->2, 3->3
// ======================================================================
$rfidStockIDs = [2, 1, 3];

foreach ($rfidStockIDs as $idx => $stockID) {

    // ตัดสินใจว่าชีตแรกใช้ getActiveSheet, ที่เหลือ createSheet
    if ($idx == 0) {
        $sheet = $spreadsheet->getActiveSheet();
    } else {
        $sheet = $spreadsheet->createSheet();
    }

    // mapping เป็นเลขตู้
    if ($stockID == 2) {
        $cabNo = 1;
    } elseif ($stockID == 1) {
        $cabNo = 2;
    } elseif ($stockID == 3) {
        $cabNo = 3;
    } else {
        $cabNo = $stockID;
    }

    // ตั้งชื่อชีต เช่น RFID 1, RFID 2, RFID 3
    $sheet->setTitle('RFID ' . $cabNo);

    // ใส่โลโก้
    addLogoIfExists($sheet, $logoFile);

    // หัวรายงาน
    $sheet->setCellValue('A3', 'รายงานสต๊อกคงเหลือในตู้ SmartCabinet (RFID ' . (string)$cabNo . ')');
    $sheet->mergeCells('A3:D3');
    $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16);

    // จัดความกว้างคอลัมน์หลัก
    $sheet->getColumnDimension('A')->setWidth(10);  // ลำดับ
    $sheet->getColumnDimension('B')->setWidth(20);  // รหัสอุปกรณ์
    $sheet->getColumnDimension('C')->setWidth(40);  // อุปกรณ์
    $sheet->getColumnDimension('D')->setWidth(15);  // จำนวน

    $row = 5;

    // หัวตาราง
    $sheet->setCellValue("A{$row}", 'ลำดับ');
    $sheet->setCellValue("B{$row}", 'รหัสอุปกรณ์');
    $sheet->setCellValue("C{$row}", 'อุปกรณ์');
    $sheet->setCellValue("D{$row}", 'จำนวน');

    $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleBorderCenter);
    $sheet->getStyle("A{$row}:D{$row}")->getFill()->applyFromArray($headerFill);
    $sheet->getStyle("A{$row}:D{$row}")->getFont()->applyFromArray($headerFontWhite);

    $row++;

    // Query ตาม TCPDF
    $query = "
        SELECT
            itemstock.ItemCode,
            item.itemname,
            COUNT(itemstock.itemcode) AS cnt
        FROM
            itemstock
            LEFT JOIN item ON itemstock.itemcode = item.itemcode
        WHERE
            itemstock.StockID = :StockID
        GROUP BY
            itemstock.ItemCode, item.itemname
        ORDER BY
            itemstock.ItemCode
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':StockID', $stockID, PDO::PARAM_INT);
    $stmt->execute();

    $no = 1;
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sheet->setCellValue("A{$row}", (string)$no);
        $sheet->setCellValue("B{$row}", (string)$res['ItemCode']);
        $sheet->setCellValue("C{$row}", (string)$res['itemname']);
        $sheet->setCellValue("D{$row}", (string)$res['cnt']);

        $sheet->getRowDimension($row)->setRowHeight(22);
        $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleBorderCenter);
        $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $row++;
        $no++;
    }
}

// ======================================================================
// Weighing Smart Cabinet → 3 ชีต: Weighing 1, 2, 3
// mapping: StockID 8->1, 4->2, 5->3
// ======================================================================
$weighStockIDs = [8, 4, 5];

foreach ($weighStockIDs as $idx => $stockID) {

    $sheet = $spreadsheet->createSheet();

    // mapping เป็นเลขตู้
    if ($stockID == 8) {
        $cabNo = 1;
    } elseif ($stockID == 4) {
        $cabNo = 2;
    } elseif ($stockID == 5) {
        $cabNo = 3;
    } else {
        $cabNo = $stockID;
    }

    // ตั้งชื่อชีต เช่น Weighing 1, Weighing 2, Weighing 3
    $sheet->setTitle('Weighing ' . $cabNo);

    // ใส่โลโก้
    addLogoIfExists($sheet, $logoFile);

    // หัวรายงาน
    $sheet->setCellValue('A3', 'รายงานสต๊อกคงเหลือในตู้ Weighing Smart Cabinet (' . (string)$cabNo . ')');
    $sheet->mergeCells('A3:D3');
    $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16);

    // จัดคอลัมน์
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(40);
    $sheet->getColumnDimension('D')->setWidth(15);

    $row = 5;

    // หัวตาราง
    $sheet->setCellValue("A{$row}", 'ลำดับ');
    $sheet->setCellValue("B{$row}", 'รหัสอุปกรณ์');
    $sheet->setCellValue("C{$row}", 'อุปกรณ์');
    $sheet->setCellValue("D{$row}", 'จำนวน');

    $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleBorderCenter);
    $sheet->getStyle("A{$row}:D{$row}")->getFill()->applyFromArray($headerFill);
    $sheet->getStyle("A{$row}:D{$row}")->getFont()->applyFromArray($headerFontWhite);

    $row++;

    // Query ตาม TCPDF
    $query2 = "
        SELECT
            itemslotincabinet.itemcode,
            item.itemname,
            itemslotincabinet.StockID,
            itemslotincabinet.SlotNo,
            itemslotincabinet.Sensor,
            itemslotincabinet.Qty
        FROM
            itemslotincabinet
            LEFT JOIN item ON itemslotincabinet.itemcode = item.itemcode
        WHERE
            itemslotincabinet.StockID = :StockID
        ORDER BY
            itemslotincabinet.SlotNo
    ";

    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(':StockID', $stockID, PDO::PARAM_INT);
    $stmt2->execute();

    $no = 1;
    while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $sheet->setCellValue("A{$row}", (string)$no);
        $sheet->setCellValue("B{$row}", (string)$res2['itemcode']);
        $sheet->setCellValue("C{$row}", (string)$res2['itemname']);
        $sheet->setCellValue("D{$row}", (string)$res2['Qty']);

        $sheet->getRowDimension($row)->setRowHeight(22);
        $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleBorderCenter);
        $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $row++;
        $no++;
    }
}

// ตั้ง active sheet กลับไปอันแรก (RFID 1)
$spreadsheet->setActiveSheetIndex(0);

// ========================= ส่งไฟล์ออกให้โหลด ===========================
$filename = 'Report_Smart_Cabinet_' . date('d_m_Y') . '.xlsx';

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Cache-Control: max-age=0");

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
