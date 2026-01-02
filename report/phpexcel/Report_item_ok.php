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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

// =========================
// รับค่า GET
// =========================
// (Excel ตัวเก่าของคุณใช้ select_follow_month / select_follow_year)
$select_follow_month = $_GET['select_month_ok'];  // '01'..'12'
$select_follow_year  = $_GET['select_year_ok'];   // '2025'
$Userid              = $_GET['Userid'];

$datetime = new DatetimeTH();

// =========================
// ดึงชื่อ user
// =========================
$_FirstName = '';
$sqlUser = "
    SELECT employee.FirstName
    FROM users
    INNER JOIN employee ON users.EmpCode = employee.EmpCode
    WHERE users.ID = :uid
";
$stUser = $conn->prepare($sqlUser);
$stUser->execute([':uid' => $Userid]);
if ($ru = $stUser->fetch(PDO::FETCH_ASSOC)) {
    $_FirstName = $ru['FirstName'];
}

// =========================
// เตรียม info เดือน/วัน
// =========================
$year        = (int)$select_follow_year;
$month       = (int)$select_follow_month;
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$startDate = sprintf('%04d-%02d-01', $year, $month);   // YYYY-MM-01
$endDate   = date('Y-m-t', strtotime($startDate));     // YYYY-MM-t

// array วันที่แบบ Y-m-d
$days = [];
for ($d = 1; $d <= $daysInMonth; $d++) {
    $days[$d] = sprintf('%04d-%02d-%02d', $year, $month, $d);
}

$todayDate = date('Y-m-d');

// =========================
// mapping stockID -> ชื่อ
// =========================
$stockMap = [
    2 => 'RFID SmartCabinet 1',
    1 => 'RFID SmartCabinet 2',
    3 => 'RFID SmartCabinet 3',
    8 => 'Weighing Smart Cabinet 1',
    4 => 'Weighing Smart Cabinet 2',
    5 => 'Weighing Smart Cabinet 3',
];

// =========================
/* สร้างไฟล์ Excel */
// =========================
$spreadsheet = new Spreadsheet();
$sheetIndex  = 0;

foreach ($stockMap as $stockid => $stockName) {

    // ชีทแรกใช้ของเดิม, ชีทต่อ ๆ ไป create ใหม่
    if ($sheetIndex === 0) {
        $sheet = $spreadsheet->getActiveSheet();
    } else {
        $sheet = $spreadsheet->createSheet();
    }

    $sheet->setTitle($stockName);

    // ========= โลโก้ =========
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setPath('logo.png');
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(40);
    $drawing->setOffsetY(25);
    $drawing->setHeight(80);
    $drawing->setWorksheet($sheet);

    // ========= พิมพ์โดย / วันที่พิมพ์ =========
    $sheet->setCellValue('B6', 'พิมพ์โดย ' . $_FirstName);
    $sheet->setCellValue('B7', 'วันที่พิมพ์ ' . date('d/m/Y') . ' ' . date('H:i:s'));
    $sheet->getStyle('B6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $sheet->getStyle('B7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    // ========= หัวเดือน/ปี + ชื่อตู้ =========
    $titleText = 'เดือน ' . $datetime->getTHmonthFromnum($select_follow_month) .
                 ' ปี ' . $select_follow_year .
                 ' - ' . $stockName;

    $sheet->setCellValue('A7', $titleText);
    $sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // ========= หัวตาราง (แถว 8) =========
    $headerRow    = 8;
    $dataStartRow = $headerRow + 1; // 9

    $sheet->setCellValue('A' . $headerRow, 'ลำดับ');
    $sheet->setCellValue('B' . $headerRow, 'อุปกรณ์');

    // หัววันที่ 1..สิ้นเดือน เริ่มคอลัมน์ C
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $colIndex  = $day + 2; // A=1,B=2,C=3...
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $cell      = $colLetter . $headerRow;

        $sheet->setCellValueExplicit($cell, $day, DataType::TYPE_NUMERIC);
        $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    $lastColLetter = Coordinate::stringFromColumnIndex(2 + $daysInMonth);

    // สไตล์หัว
    $sheet->getStyle("A{$headerRow}:{$lastColLetter}{$headerRow}")->applyFromArray([
        'fill' => [
            'fillType'   => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FF663399'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'bold'  => true,
            'color' => ['argb' => 'FFFFFFFF'],
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
        ],
    ]);

    $sheet->getRowDimension($headerRow)->setRowHeight(22);

    // ========= ดึง item ของ stockid นี้ (เหมือน query ด้านนอกใน PDF) =========
    $sqlItems = "
        SELECT
            dir.itemcode,
            MAX(dir.itemname) AS itemname
        FROM daily_item_rfid dir
        WHERE 
            dir.stockID = :stockid
            AND MONTH(dir.snapshot_date) = :month
            AND YEAR(dir.snapshot_date)  = :year
        GROUP BY dir.itemcode
        ORDER BY itemname, dir.itemcode
    ";

    $stItems = $conn->prepare($sqlItems);
    $stItems->execute([
        ':stockid' => $stockid,
        ':month'   => $select_follow_month,
        ':year'    => $select_follow_year,
    ]);
    $items = $stItems->fetchAll(PDO::FETCH_ASSOC);

    if (!$items) {
        // ไม่มี item ใน stock นี้ => ข้ามไป sheet ถัดไป
        $sheetIndex++;
        continue;
    }

    // ========= 1) ดึง snapshot ทั้งเดือน (ยกเว้นวันนี้) =========
    $sqlSnap = "
        SELECT
            DATE(ds.snapshot_date) AS ddate,
            ds.itemcode,
            SUM(ds.qty) AS qty
        FROM daily_item_rfid ds
        WHERE
            ds.stockID = :stockid
            AND ds.snapshot_date >= :startDate
            AND ds.snapshot_date < DATE_ADD(:endDate, INTERVAL 1 DAY)
            AND DATE(ds.snapshot_date) <> CURDATE()
        GROUP BY DATE(ds.snapshot_date), ds.itemcode
    ";

    $stSnap = $conn->prepare($sqlSnap);
    $stSnap->execute([
        ':stockid'   => $stockid,
        ':startDate' => $startDate,
        ':endDate'   => $endDate,
    ]);

    // $snap[itemcode][Y-m-d] = qty
    $snap = [];
    while ($r = $stSnap->fetch(PDO::FETCH_ASSOC)) {
        $icode = $r['itemcode'];
        $ddate = $r['ddate'];   // Y-m-d
        $qty   = (float)$r['qty'];
        $snap[$icode][$ddate] = $qty;
    }

    // ========= 2) ดึง today_data ตามประเภทตู้ =========
    $today = []; // $today[itemcode] = qty

    if (in_array($stockid, [1, 2, 3])) {
        // RFID SmartCabinet: today จาก itemstock
        $sqlToday = "
            SELECT
                is2.ItemCode AS itemcode,
                COUNT(is2.itemcode) AS qty
            FROM itemstock is2
            WHERE is2.StockID = :stockid
            GROUP BY is2.ItemCode
        ";
    } else {
        // Weighing SmartCabinet: today จาก itemslotincabinet
        $sqlToday = "
            SELECT
                isc.itemcode,
                IFNULL(isc.Qty, 0) AS qty
            FROM itemslotincabinet isc
            WHERE isc.stockID = :stockid
        ";
    }

    $stToday = $conn->prepare($sqlToday);
    $stToday->execute([':stockid' => $stockid]);
    while ($rt = $stToday->fetch(PDO::FETCH_ASSOC)) {
        $icode       = $rt['itemcode'];
        $today[$icode] = (float)$rt['qty'];
    }

    // ========= 3) เขียนข้อมูลลง Excel =========
    $row     = $dataStartRow;
    $running = 1;

    foreach ($items as $it) {
        $itemcode = $it['itemcode'];
        $itemname = $it['itemname'];

        // คอลัมน์ A: ลำดับ
        $sheet->setCellValueExplicit("A{$row}", $running, DataType::TYPE_NUMERIC);
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // คอลัมน์ B: ชื่ออุปกรณ์
        $sheet->setCellValueExplicit("B{$row}", $itemname, DataType::TYPE_STRING);

        // คอลัมน์ C..: ค่าประจำวัน 1..สิ้นเดือน
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $colIndex  = $day + 2; // C=3
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $cellAddr  = $colLetter . $row;

            $dateKey = $days[$day]; // Y-m-d
            if ($dateKey === $todayDate) {
                // วันนี้ → ใช้ today_data
                $val = isset($today[$itemcode]) ? $today[$itemcode] : 0;
            } else {
                // วันอื่น → ใช้ snapshot
                $val = isset($snap[$itemcode][$dateKey]) ? $snap[$itemcode][$dateKey] : 0;
            }

            $sheet->setCellValueExplicit($cellAddr, $val, DataType::TYPE_NUMERIC);
            $sheet->getStyle($cellAddr)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // เส้นขอบทั้งแถว
        $sheet->getStyle("A{$row}:{$lastColLetter}{$row}")
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_HAIR);

        $row++;
        $running++;
    }

    // ปรับความกว้างคอลัมน์
    $sheet->getColumnDimension('A')->setWidth(4);
    $sheet->getColumnDimension('B')->setWidth(30);

    // freeze หัว
    $sheet->freezePane('C9');

    $sheetIndex++;
}

// ตั้ง active เป็นชีทแรก
$spreadsheet->setActiveSheetIndex(0);

// =========================
// ส่งออกเป็นไฟล์ Excel
// =========================
$writer   = new Xlsx($spreadsheet);
$filename = "Report_follow_item_cabinet_" . date('Ymd_His') . ".xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Cache-Control: max-age=0");

$writer->save('php://output');
exit;
