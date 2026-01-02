<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

// ------------------------------------------------------------
// helper: จำนวนวันในเดือน + ความกว้างคอลัมน์วัน (รวม 75% เหมือนเดิม)
function getMonthDaysAndWidth($m)
{
    if (in_array($m, ['04', '06', '09', '11'])) {
        return [30, 75 / 30];
    } elseif ($m == '02') {
        return [28, 75 / 28]; // ถ้าต้อง leap year ค่อยปรับ
    } else {
        return [31, 75 / 31];
    }
}

// ------------------------------------------------------------
class MYPDF extends TCPDF
{
    public $select_follow_month;
    public $select_follow_year;
    public $stockid;

    protected $last_page_flag = false;

    public function Close()
    {
        $this->last_page_flag = true;
        parent::Close();
    }

    public function Header()
    {
        require('../config/db.php');
        require('../connect/connect.php');

        $datetime = new DatetimeTH();
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F'))  . " " . date('Y');

        $select_follow_month = $this->select_follow_month;
        $select_follow_year  = $this->select_follow_year;
        $stockid             = $this->stockid;

        // ✅ ชื่อหัวรายงาน (แยกกรณีพิเศษ)
        if ($stockid == -1) {
            $stockID_txt = 'รายการที่ไม่มีในตู้ RFID';
        } else {
            if ($stockid == 2) $stockID_txt = 'RFID SmartCabinet 1';
            else if ($stockid == 1) $stockID_txt = 'RFID SmartCabinet 2';
            else if ($stockid == 3) $stockID_txt = 'RFID SmartCabinet 3';
            else $stockID_txt = '';
        }

        $this->SetFont('db_helvethaica_x', '', 14);
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน ' . $printdate, 0, 1, 'R');

        $this->SetFont('db_helvethaica_x', '', 18);
        $this->Cell(0, 25, "เดือน " . $datetime->getTHmonthFromnum($select_follow_month) . " ปี " . $select_follow_year, 0, 1, 'C');

        if ($stockID_txt !== '') {
            $this->Cell(0, 0, $stockID_txt, 0, 1, 'C');
        }

        $this->Ln(5);

        // โลโก้ (ถ้าไม่อยากให้หน้า -1 มีโลโก้ ให้ใส่เงื่อนไขได้)
        $image_file = "images/logo1.png";
        $this->Image($image_file, 10, 10, 20, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    public function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('db_helvethaica_x', 'i', 12);
        $this->Cell(300, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// ------------------------------------------------------------
// รับเดือน/ปี
$select_month_ok = $_GET['select_month_ok'] ?? '';
$select_year_ok  = $_GET['select_year_ok'] ?? '';

if ($select_month_ok === '' || $select_year_ok === '') {
    die('missing select_month_ok / select_year_ok');
}

// ------------------------------------------------------------
// create PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Follow_item');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(10, 55, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 35);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

// ------------------------------------------------------------
// ✅ RFID เรียงหน้า RFID 1,2,3 = stockID 2,1,3
$rfidOrder = [2, 1, 3];

list($numDays, $width) = getMonthDaysAndWidth($select_month_ok);

// ------------------------------------------------------------
// ✅ 1) หน้า RFID (แต่ละ stockid แยกหน้า) + ช่องวันว่างทั้งหมด
foreach ($rfidOrder as $stockid) {

    // ส่งค่าให้ Header ใช้
    $pdf->select_follow_month = $select_month_ok;
    $pdf->select_follow_year  = $select_year_ok;
    $pdf->stockid             = $stockid;

    $pdf->AddPage('L', 'A4');

    // ตาราง
    $html = '<table cellspacing="0" cellpadding="2" border="1" repeat_header="1">
    <thead>
      <tr nobr="true" style="font-size:18px;color:#fff;background-color:#663399;">
        <th width="5%"  align="center">ลำดับ</th>
        <th width="20%" align="center">อุปกรณ์</th>';

    for ($d = 1; $d <= $numDays; $d++) {
        $html .= '<th width="'.$width.'%" align="center">'.$d.'</th>';
    }
    $html .= '</tr>
    </thead><tbody>';

    // ดึงรายการ item (ใช้แค่เพื่อรู้ว่ามีรายการอะไรบ้าง)
    $sqlItem = "
        SELECT dir.itemcode, dir.itemname
        FROM daily_item_rfid dir
        WHERE MONTH(dir.snapshot_date) = :m
          AND YEAR(dir.snapshot_date)  = :y
          AND dir.stockID = :sid
        GROUP BY dir.itemcode
        ORDER BY dir.itemcode
    ";
    $stmt = $conn->prepare($sqlItem);
    $stmt->execute([
        ':m' => $select_month_ok,
        ':y' => $select_year_ok,
        ':sid' => $stockid
    ]);

    $i = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $itemname = $row['itemname'];

        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .= '<td width="5%"  align="center">'.$i.'</td>';
        $html .= '<td width="20%" align="left">'.$itemname.'</td>';

        // ✅ ช่องวันว่างทั้งหมด
        for ($d = 1; $d <= $numDays; $d++) {
            $html .= '<td width="'.$width.'%" align="center"></td>';
        }

        $html .= '</tr>';
        $i++;
    }

    $html .= '</tbody></table>';

    $pdf->writeHTML($html, true, false, false, false, '');
}

// ------------------------------------------------------------
// ✅ 2) หน้าเพิ่ม: รายการที่ไม่มีในตู้ RFID (Fix list) + ช่องวันว่างทั้งหมด
$pdf->select_follow_month = $select_month_ok;
$pdf->select_follow_year  = $select_year_ok;
$pdf->stockid             = -1;   // ✅ สำคัญ: ให้ Header ขึ้น “รายการที่ไม่มีในตู้ RFID” และไม่ขึ้น RFID SmartCabinet
$pdf->AddPage('L', 'A4');

// Fix list
$fixedList = [
 ['CDH 29 P','CDH 29 P ( 5 )'],
 ['MXSCTLWUC','ALEXIS (laparo c8701) ( 1 )'],
 ['GSTY01','ไส้ Echelon 3.8mm,60 ทอง(9)'],
 ['HEMY03','HEMOLOK สีทอง'],
 ['','ด้าม echelon 45'],
 ['','ด้าม echelon 60'],
 ['ULTY00','ultyrapro 6*11'],
 ['EL5ML','Ligamax clip 5 mm.'],
 ['ทดลองใช้','shoulder drape'],
 ['CRAY00','Craniotomy drape'],
 ['PDSY09','Endo loop'],
 ['DIAI03','Diagnogreen 25 mg'],
 ['','Ligasure (กรรไกร)'],
 ['ENSE00','ENSEAL 25 CM'],
 ['ENSE01','ENSEAL 37 CM'],
 ['','ด้าม echelon 60'],
 ['','ด้าม echelon 45'],
 ['','Ligasure (กรรไกร)'],
 ['','thoracic no.24/no28/no32'],
 ['','เครื่อง ipc'],
 ['','SCD ที่รัดขาno.s/m/l'],
 ['ENDY43','ใส้ GIA สีฟ้า'],
 ['LG006-3','Graper 3 mm อ.อานนท์'],
 ['LOOP05','Surgi-loop 75 (แดงเล็ก)'],
 ['LOOP01','Surgi-loop 76 (แดงใหญ่)'],
 ['LOOP06','Surgi-loop 77 (น้ำเงินเล็ก)'],
 ['LOOP02','Surgi-loop 78 (น้ำเงินใหญ่)'],
 ['LOOP03','Surgi-loop 80 (เหลือง)'],
 ['PATI00','PATENT BLUE'],
 ['STAY02','Starsil Hemostat 1 g'],
 ['PARY07','PT TUBE 1.3'],
 ['TOOL2','Midas 2 mm cut (10BA20)'],
 ['TOOL3','Midas 3 mm cut (10BA30)'],
 ['TOOL4','Midas 4 mm cut (10BA40)'],
 ['TOOLD2','Midas 2 mm dimond (10BA20D)'],
 ['TOOLD3','Midas 3 mm dimond (10BA30D)'],
 ['TOOLD4','Midas 4 mm dimond (10BA40D)'],
 ['TOOLM2.2','Midas MH 2.2 (10MH22)'],
 ['TOOLM3','Midas MH 3.0 (10MH30)'],
 ['TOOLT2.3','Blade neuro (MR8-F2/7TA23)'],
];

// ตารางหน้า fix (ลบคอลัมน์รหัสออก) => 5% ลำดับ + 20% รายการ + 75% วัน = 100%
$htmlFix = '<table cellspacing="0" cellpadding="2" border="1" repeat_header="1">
<thead>
<tr nobr="true" style="font-size:18px;color:#fff;background-color:#663399;">
  <th width="5%"  align="center">ลำดับ</th>
  <th width="20%" align="center">รายการ</th>';

for ($d=1; $d<=$numDays; $d++) {
    $htmlFix .= '<th width="'.$width.'%" align="center">'.$d.'</th>';
}
$htmlFix .= '</tr></thead><tbody>';

$no = 1;
foreach ($fixedList as $r) {

    // เอาทั้ง "รหัส + รายการ" มารวมเป็นข้อความยาวคอลัมน์เดียว
    $code = trim($r[0] ?? '');
    $name = trim($r[1] ?? '');

    $full = ($code !== '' && $name !== '') ? ($code.' | '.$name) : (($code !== '') ? $code : $name);
    $full = htmlspecialchars($full, ENT_QUOTES, 'UTF-8');

    $htmlFix .= '<tr nobr="true" style="font-size:15px;">
      <td width="5%"  align="center">'.$no.'</td>
      <td width="20%" align="left">'.$full.'</td>';

    // ช่องวันว่างทั้งหมด
    for ($d=1; $d<=$numDays; $d++) {
        $htmlFix .= '<td width="'.$width.'%" align="center"></td>';
    }

    $htmlFix .= '</tr>';
    $no++;
}

$htmlFix .= '</tbody></table>';

$pdf->writeHTML($htmlFix, true, false, false, false, '');


// ------------------------------------------------------------
// Output
$ddate = date('d_m_Y');
$pdf->Output('Report_Follow_item_' . $ddate . '.pdf', 'I');
