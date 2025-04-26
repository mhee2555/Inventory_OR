<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
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



        if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');



            $this->SetFont('db_helvethaica_x', 'b', 16);





            //   $this->Cell(0, 10,  $text_date, 0, 1, 'C');






            $image_file = "images/logo1.png";
            $this->Image($image_file, 10, 10, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        }
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
$pdf->SetTitle('Report_Patient_Cost_Summary_(IOR)');
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
$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 27);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetFont('db_helvethaica_x', 'B', 15);
// $pdf->Ln(15);


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

$checkloopDoctor  = "";
$_procedure = "";

$datetime = new DatetimeTH();


if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = explode("-", $date1);
        $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543);
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543) . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1]) . " " . " พ.ศ." . " " . ($date2[2] + 543);
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือน : " . $datetime->getTHmonthFromnum($month1);
    } else {
        $text_date = "เดือน : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
    }
}

if ($type_date == 3) {

    if ($checkyear == 1) {
        $text_date = "ปี : " . $year1;
    } else {
        $text_date = "ปี : " . $year1 . " ถึง " . $year2;
    }
}


if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "WHERE DATE(hncode.CreateDate) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "WHERE DATE(hncode.CreateDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $where_date = "WHERE MONTH(hncode.CreateDate) = '$month1'  ";

    } else {
        $where_date = "WHERE MONTH(hncode.CreateDate) BETWEEN '$month1' 	AND '$month2' ";
    }
}

if ($type_date == 3) {
    $year1 = $year1-543;
    $year2 = $year2-543;
    if ($checkyear == 1) {
        $where_date = "WHERE YEAR(hncode.CreateDate) = '$year1'  ";

    } else {
        $where_date = "WHERE YEAR(hncode.CreateDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}

$pdf->Cell(0, 10,  " ใบสรุปค่าใช้จ่าย OR ", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="8 %" align="center">Code</th>
<th width="30 %" align="center">ItemCode</th>
<th width="32 %"  align="center">Name</th>
<th width="10 %" align="center">Qty</th>
<th width="10 %" align="center">Unit Price</th>
<th width="10 %" align="center">Total Price</th>
</tr> </thead>';



$count = 1;
$query = " SELECT
                item.itemname,
                item.itemcode,
                item.itemcode2,
                hncode_detail.ID,
                SUM( hncode_detail.Qty ) AS cnt,
                itemtype.TyeName 
            FROM
                hncode
                LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                LEFT JOIN itemstock ON itemstock.RowID = hncode_detail.ItemStockID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN itemtype ON item.itemtypeID = itemtype.ID 
            $where_date
            GROUP BY  item.itemname
            ORDER BY
                item.itemname ASC ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $style = array(
        'position' => '',
        'align' => 'S',
        'stretch' => false,
        'fitwidth' => false,
        'cellfitalign' => '',
        'border' => false,
        'hpadding' => 0,
        'vpadding' => 0,
        'fgcolor' => array(0,0,0),
        'bgcolor' => false,
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 4,
        'stretchtext' => 4
    );

    // $params = $pdf->serializeTCPDFtagParameters(array(
    //     $Result_Detail['itemcode'], 'C39', '', '', 53, 9, 0.4, $style, 'N'  // เปลี่ยนจาก 8 เป็น 12
    // ));


    if($Result_Detail['cnt'] != 0){
        $itemcode = "";
        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="8 %" align="center"> ' . $Result_Detail['itemcode2'] . '</td>';
        $html .=   '<td width="30 %" align="center">' . $Result_Detail['itemcode'] . '</td>';
        $html .=   '<td width="32 %" align="left">' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="10 %" align="center">' . $Result_Detail['cnt'] . '</td>';
        $html .=   '<td width="10 %" align="center">0</td>';
        $html .=   '<td width="10 %" align="center">0</td>';
        $html .=  '</tr>';
        $count++;
    }


}

$html .= '<tr nobr="true" style="font-size:15px;">';
$html .=   '<td width="90 %" align="center" rowspan="5">Grand Total</td>';
$html .=   '<td width="10 %" align="center">0</td>';
$html .=  '</tr>';


$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Patient_Cost_Summary_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
