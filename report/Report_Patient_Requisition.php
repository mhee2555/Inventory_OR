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
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));



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
$pdf->SetTitle('Report_Patient_Requisition_(IOR)');
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
$checkyear = $_GET['checkyear'];
$year1 = $_GET['year1'];
$year2 = $_GET['year2'];

$datetime = new DatetimeTH();

if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = explode("-", $date1);
        $text_date = "วันที่เบิกอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543);
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่เบิกอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543) . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1]) . " " . " พ.ศ." . " " . ($date2[2] + 543);
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือนที่เบิกอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) ."ปี " .$year1;
    } else {
        $text_date = "เดือนที่เบิกอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2) ."ปี " .$year1;
    }
}
if ($type_date == 3) {

    if ($checkyear == 1) {
        $text_date = "ปีที่เบิกอุปกรณ์ : " . $year1;
    } else {
        $text_date = "ปีที่เบิกอุปกรณ์ : " . $year1 . " ถึง " . $year2;
    }
}
$pdf->SetY(20);


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานการเบิกอุปกรณ์ตู้ RFID SmartCabinet", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(5);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="6 %" align="center">ลำดับ</th>
<th width="16 %" align="center">รหัสอุปกรณ์</th>
<th width="30 %"  align="center">อุปกรณ์</th>
<th width="10 %" align="center">รหัสใช้งาน</th>
<th width="10 %" align="center">ผู้เบิก</th>
<th width="10 %" align="center">วันที่/เวลา<br>เบิก</th>
<th width="10 %" align="center">HN Code</th>
<th width="10 %" align="center">สถานะ</th>
</tr> </thead>';





if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) = '$month1'  ";

    } else {
        $where_date = "AND MONTH(log_cabinet.ModifyDate) BETWEEN '$month1' 	AND '$month2' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1-543;
    $year2 = $year2-543;

    if ($checkyear == 1) {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) = '$year1'  ";

    } else {
        $where_date = "AND YEAR(log_cabinet.ModifyDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}


$count = 1;
$query = " SELECT
                item.itemcode2,
                item.itemname,
                itemstock.UsageCode,
                CONCAT( employee.FirstName, ' ', employee.LastName ) AS Issue_Name,
                log_cabinet.ModifyDate,
                hncode.HnCode,
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

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="6 %" align="center" style="line-height:40px;vertical-align: middle;" > ' . (string)$count . '</td>';
    $html .=   '<td width="16 %" align="center" style="line-height:40px;vertical-align: middle;"> ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="30 %" align="left" style="line-height:40px;vertical-align: middle;">' .   $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['UsageCode'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['Issue_Name'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['ModifyDate'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['HnCode'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['STATUS'] . '</td>';
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
        $text_date = "วันที่เบิกอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543);
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่เบิกอุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543) . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1]) . " " . " พ.ศ." . " " . ($date2[2] + 543);
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือนที่เบิกอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1)."ปี " .$year1;;
    } else {
        $text_date = "เดือนที่เบิกอุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2)."ปี " .$year1;;
    }
}


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานการเบิกอุปกรณ์ตู้ Weighing Smart Cabinet", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(5);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="6 %" align="center">ลำดับ</th>
<th width="16 %" align="center">รหัสอุปกรณ์</th>
<th width="30 %"  align="center">อุปกรณ์</th>
<th width="10 %" align="center">รหัสใช้งาน</th>
<th width="10 %" align="center">ผู้เบิก</th>
<th width="20 %" align="center">วันที่/เวลา เบิก</th>
<th width="10 %" align="center">Qty</th>
</tr> </thead>';





if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(log_cabinet.ModifyDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if ($type_date == 2) {

    if ($checkmonth == 1) {
    } else {
    }
}

$count = 1;
$query = " SELECT
                item.itemcode2,
                item.itemname,
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

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="6 %" align="center" style="line-height:40px;vertical-align: middle;"> ' . (string)$count . '</td>';
    $html .=   '<td width="16 %" align="center" style="line-height:40px;vertical-align: middle;"> ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="30 %" align="left" style="line-height:40px;vertical-align: middle;">' .   $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center" style="line-height:40px;vertical-align: middle;">' . $Result_Detail['UsageCode'] . '</td>';
    $html .=   '<td width="10 %" align="center" style="line-height:40px;vertical-align: middle;">' . $Result_Detail['Issue_Name'] . '</td>';
    $html .=   '<td width="20 %" align="center" style="line-height:40px;vertical-align: middle;">' . $Result_Detail['ModifyDate'] . '</td>';
    $html .=   '<td width="10 %" align="center" style="line-height:40px;vertical-align: middle;">' . $Result_Detail['Qty'] . '</td>';
    $html .=  '</tr>';
    $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');

// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Patient_Requisition_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
