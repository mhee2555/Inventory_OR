<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

error_reporting(E_ALL & ~E_WARNING);
//--------------------------------------------------------------------------


class MYPDF extends TCPDF
{
    protected $last_page_flag = false;

    public function Close()
    {
        $this->last_page_flag = true;
        parent::Close();
    }
    //Page header
    public function Header()
    {
        require('../config/db.php');
        require('../connect/connect.php');
        $datetime = new DatetimeTH();
        // date th
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F'))  . " " . date('Y');



        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');






        // if ($this->page == 1) {

        $image_file = "images/logo1.png";
        $this->Image($image_file, 10, 10, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        // }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number


        $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Stock');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(15, 45, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 35);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// หลังจากสร้าง $pdf และ set margin, header, footer เสร็จแล้ว

$pdf->SetFont('db_helvethaica_x', 'b', 16);

$stockIDs = [2, 1, 3]; // ลำดับหน้าที่ต้องการ

foreach ($stockIDs as $idx => $stockID) {

    // หน้าแรกให้ใช้ AddPage ปกติ, หน้าถัดไปก็ AddPage เช่นกัน
    $pdf->AddPage('P', 'A4');

    // ขยับลงมาหน่อย
    $pdf->SetY(20);

    if ($stockID == 2) {
        $stockID_txt = 1;
    }
    if ($stockID == 1) {
        $stockID_txt = 2;
    }
    if ($stockID == 3) {
        $stockID_txt = 3;
    }
    // หัวรายงานกลางหน้า
    $pdf->SetFont('db_helvethaica_x', 'b', 16);
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "รายงานสต๊อกคงเหลือในตู้ SmartCabinet", 0, 1, 'C');

    // แสดงว่าเป็นตู้ / StockID ไหน (จะเขียนคำยังไงก็ปรับได้)
    $pdf->SetFont('db_helvethaica_x', '', 14);
    $pdf->Ln(3);
    $pdf->Cell(0, 8, " RFID SmartCabinet : " . $stockID_txt, 0, 1, 'C');

    // ตั้งฟอนต์สำหรับหัวตาราง
    $pdf->SetFont('db_helvethaica_x', 'B', 18);
    $pdf->Ln(2);

    // สร้างหัวตารางใหม่ทุกหน้า
    $html = '<table cellspacing="0" cellpadding="2" border="1">
    <thead>
        <tr style="font-size:18px;color:#fff;background-color:#663399;">
            <th width="10%" align="center">ลำดับ</th>
            <th width="20%" align="center">รหัสอุปกรณ์</th>
            <th width="50%" align="center">อุปกรณ์</th>
            <th width="20%" align="center">จำนวน</th>
        </tr>
    </thead>';

    $count = 1;

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

    $meQuery1 = $conn->prepare($query);
    $meQuery1->bindParam(':StockID', $stockID, PDO::PARAM_INT);
    $meQuery1->execute();

    while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

        // ถ้าต้องการให้ฟอนต์ในบรรทัด detail เล็กลงหน่อยก็ลด size ได้
        $pdf->SetFont('db_helvethaica_x', '', 15);

        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="10%" align="center">' . $count . '</td>';
        $html .=   '<td width="20%" align="center">' . $Result_Detail['ItemCode'] . '</td>';
        $html .=   '<td width="50%" align="left">'   . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="20%" align="center">' . $Result_Detail['cnt'] . '</td>';
        $html .= '</tr>';

        $count++;
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, false, false, '');
}


// ==================================================================================================================


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$stockIDs = [8, 4, 5]; // ลำดับหน้าที่ต้องการ

foreach ($stockIDs as $idx => $stockID) {

    // หน้าแรกให้ใช้ AddPage ปกติ, หน้าถัดไปก็ AddPage เช่นกัน
    $pdf->AddPage('P', 'A4');

    // ขยับลงมาหน่อย
    $pdf->SetY(20);

    if ($stockID == 8) {
        $stockID_txt = 1;
    }
    if ($stockID == 4) {
        $stockID_txt = 2;
    }
    if ($stockID == 5) {
        $stockID_txt = 3;
    }
    // หัวรายงานกลางหน้า
    $pdf->SetFont('db_helvethaica_x', 'b', 16);
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "รายงานสต๊อกคงเหลือในตู้ Weighing Smart Cabinet ", 0, 1, 'C');

    // แสดงว่าเป็นตู้ / StockID ไหน (จะเขียนคำยังไงก็ปรับได้)
    $pdf->SetFont('db_helvethaica_x', '', 14);
    $pdf->Ln(3);
    $pdf->Cell(0, 8, " Weighing Smart Cabinet  : " . $stockID_txt, 0, 1, 'C');

    // ตั้งฟอนต์สำหรับหัวตาราง
    $pdf->SetFont('db_helvethaica_x', 'B', 18);
    $pdf->Ln(2);

    // สร้างหัวตารางใหม่ทุกหน้า
    $html = '<table cellspacing="0" cellpadding="2" border="1">
    <thead>
        <tr style="font-size:18px;color:#fff;background-color:#663399;">
            <th width="10%" align="center">ลำดับ</th>
            <th width="20%" align="center">รหัสอุปกรณ์</th>
            <th width="50%" align="center">อุปกรณ์</th>
            <th width="20%" align="center">จำนวน</th>
        </tr>
    </thead>';

    $count = 1;

    $query = "SELECT
                itemslotincabinet.itemcode,
                itemname,
                StockID,
                SlotNo,
                Sensor,
                Qty
                FROM
                itemslotincabinet
                LEFT JOIN item ON itemslotincabinet.itemcode = item.itemcode
                WHERE
                itemslotincabinet.StockID = :StockID
                ORDER BY
                SlotNo;  ";

    $meQuery1 = $conn->prepare($query);
    $meQuery1->bindParam(':StockID', $stockID, PDO::PARAM_INT);
    $meQuery1->execute();

    while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

        // ถ้าต้องการให้ฟอนต์ในบรรทัด detail เล็กลงหน่อยก็ลด size ได้
        $pdf->SetFont('db_helvethaica_x', '', 15);

        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="10%" align="center">' . $count . '</td>';
        $html .=   '<td width="20%" align="center">' . $Result_Detail['itemcode'] . '</td>';
        $html .=   '<td width="50%" align="left">'   . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="20%" align="center">' . $Result_Detail['Qty'] . '</td>';
        $html .= '</tr>';

        $count++;
    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, false, false, '');
}




//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Smart_Cabinet_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
