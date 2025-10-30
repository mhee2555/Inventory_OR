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
        $this->Image($image_file, 10, 10, 20, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






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
$pdf->SetTitle('Report_Replenishment_(IOR)');
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

// set font
// add a page

$pdf->AddPage('P', 'A4');



$type_date = $_GET['type_date'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$month1 = $_GET['month1'];
$month2 = $_GET['month2'];
$checkday = $_GET['checkday'];
$checkmonth = $_GET['checkmonth'];
$year1 = $_GET['year1'];
$year2 = $_GET['year2'];
$datetime = new DatetimeTH();

if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = explode("-", $date1);
        $text_date = "วันที่เติมอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1])  . " " . date('Y');
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่เติมอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . date('Y') . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1])  . " " . date('Y');
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือนที่เติมอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1)." ปี " .$year1;
    } else {
        $text_date = "เดือนที่เติมอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2)." ปี " .$year1;
    }
}

if ($type_date == 3) {

    if ($checkmonth == 1) {
        $text_date = "ปีที่เติมอุปกรณ์ : " . $year1;
    } else {
        $text_date = "ปีที่เติมอุปกรณ์ : " . $year1 . " ถึง " . $year2;
    }
}

$pdf->SetY(20);


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานเติมอุปกรณ์ประจำวันตู้ RFID SmartCabinet", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(5);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="6 %" align="center">ลำดับ</th>
<th width="20 %" align="center">รหัสอุปกรณ์</th>
<th width="36 %"  align="center">อุปกรณ์</th>
<th width="10 %" align="center">ทั้งหมด</th>
<th width="15 %" align="center">เติมอุปกรณ์เข้าตู้</th>
<th width="15 %" align="center">คงเหลือล่าสุด</th>
</tr> </thead>';





if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "WHERE DATE(itemstock.LastCabinetModify) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "WHERE DATE(itemstock.LastCabinetModify) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {
    $year1 = $year1-543;

    if ($checkmonth == 1) {
        $where_date = "WHERE MONTH(itemstock.LastCabinetModify) = '$month1' AND YEAR(itemstock.LastCabinetModify) = '$year1'   ";

    } else {
        $where_date = "WHERE MONTH(itemstock.LastCabinetModify) BETWEEN '$month1' 	AND '$month2' AND YEAR(itemstock.LastCabinetModify) = '$year1'  ";
    }
}

if ($type_date == 3) {
    $year1 = $year1-543;
    $year2 = $year2-543;
    if ($checkyear == 1) {
        $where_date = "WHERE YEAR(itemstock.LastCabinetModify) = '$year1'  ";

    } else {
        $where_date = "WHERE YEAR(itemstock.LastCabinetModify) BETWEEN '$year1' 	AND '$year2' ";
    }
}

$count = 1;

$query = "SELECT
            item.itemname,
            item.itemcode2,
            COUNT(itemstock.ItemCode) AS qty,
            (SELECT COUNT(itemstock.RowID) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND itemstock.StockID != 0 ) AS all_ 
            FROM
            itemstock
            INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            $where_date
            AND itemstock.StockID != 0
            GROUP BY
            item.itemcode ";
// $query = " SELECT
//                 item.itemname,
//                 item.itemcode2,
//                 ( 

//                 SELECT COUNT( itemstock.RowID ) 
//                 FROM itemstock 
//                 WHERE itemstock.ItemCode = item.itemcode 
//                 AND  itemstock.IsStatus = 4 
//                 AND ( itemstock.IsDeproom IS NULL  OR  itemstock.IsDeproom = 0 )
//                 AND ( itemstock.departmentroomid IS NULL  OR  itemstock.departmentroomid = 35 )
//                 )		AS all_  ,
//                 ( 

//                 SELECT COUNT( itemstock.RowID ) 
//                 FROM itemstock 
//                 WHERE itemstock.ItemCode = item.itemcode 
//                 AND  itemstock.IsStatus = 4 
//                 AND  itemstock.IsDeproom IS NULL 
//                 AND  itemstock.departmentroomid IS NULL
                
//                 )		AS qty 
//             FROM
//                 itemstock
//                 INNER JOIN item ON itemstock.ItemCode = item.itemcode 
//             $where_date
//             GROUP BY
//                 item.itemname
//             ORDER BY  qty DESC ";



$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="6 %" align="center"> ' . (string)$count . '</td>';
    $html .=   '<td width="20 %" align="center"> ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="36 %" align="left">' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center">' . $Result_Detail['all_'] -  $Result_Detail['qty']   . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['qty'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['all_'] . '</td>';
    $html .=  '</tr>';
    $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


// ==================================================================================================================


$pdf->AddPage('P', 'A4');

$type_date = $_GET['type_date'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$month1 = $_GET['month1'];
$month2 = $_GET['month2'];
$checkday = $_GET['checkday'];
$checkmonth = $_GET['checkmonth'];


if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = explode("-", $date1);
        $text_date = "วันที่เติมอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1])  . " " . date('Y');
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่เติมอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . date('Y') . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1])  . " " . date('Y');
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือนที่เติมอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1);
    } else {
        $text_date = "เดือนที่เติมอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
    }
}

$pdf->SetY(20);

$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานการเติมอุปกรณ์ประจำวันของตู้ Weighing SmartCabinet", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(5);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="6 %" align="center">ลำดับ</th>
<th width="20 %" align="center">รหัสอุปกรณ์</th>
<th width="36 %"  align="center">อุปกรณ์</th>
<th width="10 %" align="center">ทั้งหมด</th>
<th width="15 %" align="center">เติมอุปกรณ์เข้าตู้</th>
<th width="15 %" align="center">คงเหลือล่าสุด</th>
</tr> </thead>';





if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "AND DATE(itemslotincabinet_detail.ModifyDate) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(itemslotincabinet_detail.ModifyDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(itemslotincabinet_detail.ModifyDate) = '$month1'  ";

    } else {
        $where_date = "AND MONTH(itemslotincabinet_detail.ModifyDate) BETWEEN '$month1' 	AND '$month2' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1-543;
    $year2 = $year2-543;

    if ($checkyear == 1) {
        $where_date = "AND YEAR(itemslotincabinet_detail.ModifyDate) = '$year1'  ";

    } else {
        $where_date = "AND YEAR(itemslotincabinet_detail.ModifyDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}

$count = 1;
$query = " SELECT
                item.itemname,
                item.itemcode2,
                COUNT( itemstock.ItemCode ) AS all_,
                itemslotincabinet_detail.Qty AS qty 
            FROM
                itemslotincabinet_detail
                INNER JOIN item ON itemslotincabinet_detail.itemcode = item.itemcode
                INNER JOIN itemstock ON itemstock.ItemCode = item.itemcode 
            WHERE
                itemslotincabinet_detail.Sign = '+' 
                $where_date
            GROUP BY
                item.itemcode ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="6 %" align="center"> ' . (string)$count . '</td>';
    $html .=   '<td width="20 %" align="center"> ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="36 %" align="left">' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center">' . $Result_Detail['all_'] -  $Result_Detail['qty']   . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['qty'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['all_'] . '</td>';
    $html .=  '</tr>';
    $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');

// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Replenishment_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
