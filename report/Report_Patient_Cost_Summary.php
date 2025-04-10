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

            $type_date = $_GET['type_date'];
            $date1 = $_GET['date1'];
            $date2 = $_GET['date2'];
            $month1 = $_GET['month1'];
            $month2 = $_GET['month2'];
            $checkday = $_GET['checkday'];
            $checkmonth = $_GET['checkmonth'];

            if($type_date == 1){

                if($checkday == 1){
                    $date1 = explode("-", $date1);
                    $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
                }else{
                    $date1 = explode("-", $date1);
                    $date2 = explode("-", $date2);

                    $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 ) . " ถึง " .  $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
                }
            }

            if($type_date == 2){

                if($checkmonth == 1){
                    $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1);
                }else{
                    $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
                }
            }


            $this->SetFont('db_helvethaica_x', 'b', 16);

            $this->Ln(10);


              $this->Cell(0, 10,  " ใบสรุปค่าใช้จ่าย OR ", 0, 1, 'C');
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


        $this->Cell(210, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
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
$pdf->Ln(15);


$pdf->Cell(50, 5,  "HN 0655780", 0, 0, 'L');
$pdf->Cell(50, 5,  "ชื่อ ศักดิธัช หนุนนาค", 0, 1, 'R');

$pdf->Cell(130, 5,  "Procedure Laparoscope, ผ่าตัดช่องท้อง", 0, 1, 'L');


$pdf->Cell(130, 5,  "แพทย์", 0, 1, 'L');
$pdf->Cell(50, 5,  "1. นพ0123544221 นายแพทย์สัตยา ศรียาบ", 0, 1, 'L');
$pdf->Cell(50, 5,  "2. นพ0123544221 นายแพทย์สัตยา ศรียาบ", 0, 1, 'L');
$pdf->Cell(50, 5,  "3. นพ0123544221 นายแพทย์สัตยา ศรียาบ", 0, 1, 'L');

$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;">
<th width="6 %" align="center">Code</th>
<th width="20 %" align="center">Barcode</th>
<th width="34 %"  align="center">Name</th>
<th width="10 %" align="center">Oty</th>
<th width="15 %" align="center">Unit Price</th>
<th width="15 %" align="center">Total Price</th>
</tr> </thead>';


$type_date = $_GET['type_date'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$month1 = $_GET['month1'];
$month2 = $_GET['month2'];
$checkday = $_GET['checkday'];
$checkmonth = $_GET['checkmonth'];


if($type_date == 1){
    if($checkday == 1){
        $date1 = explode("-", $date1);
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "WHERE DATE(itemstock.LastCabinetModify) = '$date1'  ";
    }else{
        $date1 = explode("-", $date1);
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = explode("-", $date2);
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
        $where_date = "WHERE DATE(itemstock.LastCabinetModify) BETWEEN '$date1' 	AND '$date2' ";
    }
}
if($type_date == 2){

    if($checkmonth == 1){
    }else{
    }
}

$count = 1;
$query = " SELECT
                item.itemname,
                item.itemcode2,
                COUNT( itemstock.ItemCode ) AS all_,
                ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  ( itemstock.StockID IS NOT NULL ) )		AS qty 
            FROM
                itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            $where_date
            GROUP BY
                item.itemname
            ORDER BY  qty DESC ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="6 %" align="center"> ' . $count . '</td>';
    $html .=   '<td width="20 %" align="center"> ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="34 %" align="left">' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center">' . $Result_Detail['all_'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['qty'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['all_'] -  $Result_Detail['qty']   . '</td>';
    $html .=  '</tr>';
    $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Patient_Cost_Summary_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
