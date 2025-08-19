<?php
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
        require('../connect/connect.php');
        $datetime = new DatetimeTH();
        // date th
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " " . date('Y');



        if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 5,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 0, 'R');




            // $this->SetFont('db_helvethaica_x', 'b', 18);

            // $this->Cell(50, 8,  "  HN Code", 1, 0, 'C');
            // $this->Cell(150, 8,  " 777-666-444-333", 1, 1, 'L');

            // $this->Cell(50, 8,  "  วันที่เข้ารับบริการ", 1, 0, 'C');
            // $this->Cell(150, 8,  " 2024–12-12", 1, 1, 'L');

            // $this->Cell(50, 8,  "  แพทย์", 1, 0, 'C');
            // $this->Cell(150, 8,  " DR. SAKDITOUCH NUNNARK", 1, 1, 'L');

            // $this->Cell(50, 8,  "  หัตถการ", 1, 0, 'C');
            // $this->SetFillColor(215, 235, 255);
            // $this->MultiCell(150, 8,  " Arthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankle", 1, 1, 'L');

            // $this->Cell(50, 8,  "  ห้องผ่าตัด", 1, 0, 'C');
            // $this->Cell(150, 8,  " OPERATING ROOM NO 1", 1, 1, 'L');
            
            // $this->Cell(50, 8,  "  หมายเหตุ", 1, 0, 'C');
            // $this->Cell(150, 8,  " คนไข้อายุมาก", 1, 1, 'L');








            // $this->Ln();
            // $image_file = "images/LOGO_bk.png";
            // $this->Image($image_file, 10, 20, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number

        // if ($this->last_page_flag) {

            
        //     $this->Cell(1, 9,  "                                                     DR. SAKDITOUCH NUNNARK", 0, 0, 'L');
        //     $this->Cell(130, 10,   '                      ผู้สร้างใบขอเบิก : ' . "", 0, 0, 'L');


        //     $this->Cell(1, 9,  "                           15/02/2025", 0, 0, 'L');
        //     $this->Cell(10, 10,   'วันและเวลา : ' . "", 0, 1, 'L');

        //     $this->Cell(1, 9,  "                                                           DR. SAKDITOUCH NUNNARK", 0, 0, 'L');
        //     $this->Cell(130, 10,   '                      ผู้สแกนจ่ายอุปกรณ์ : ' . "", 0, 0, 'L');


        //     $this->Cell(1, 9,  "                           15/02/2025", 0, 0, 'L');
        //     $this->Cell(10, 10,   'วันและเวลา : ' . "", 0, 0, 'L');
        //     // $this->Cell(1, 9,  "         " . $Facdate . "  เวลา   " . $FacTime, 0, 0, 'L');
        //     // $this->Cell(90, 10,   'วันที่' . "", 0, 0, 'L');

        // }


        $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Sterile_Cost_Date');
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
$pdf->SetMargins(5, 15, 5);
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
$pdf->SetFont('db_helvethaica_x', 'B', 18);
$Ref = $_GET['DocNo'];


$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;">
<th width="10 %" align="center">ลำดับ</th>
<th width="30 %" align="center">เลขเอกสารส่ง Request</th>
<th width="30 %"  align="center">สถานะการรับเข้าคลัง</th>
<th width="30 %" align="center">ค่าใช้จ่ายรวม</th>
</tr> </thead>';




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;">
<th width="10 %" align="center">ลำดับ</th>
<th width="30 %" align="center">รายการ</th>
<th width="20 %"  align="center">ต่อหน่วย</th>
<th width="20 %" align="center">จำนวน</th>
<th width="20 %" align="center">รวม</th>
</tr> </thead>';




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');

// $Ref = explode(",", $Ref);
// $RefDocNo_ = "";
// foreach ($Ref as $key => $value) {
//     $RefDocNo_ .= "'".$value."',"; 
// }
// $RefDocNo_ = substr($RefDocNo_ , 0, -1);
// $count = 1;
// $query = "SELECT
//             payout.RefDocNo,
//             FORMAT ( payout.CreateDate, 'dd/MM/yyyy') AS Date,
//             COUNT(payout.RefDocNo) AS Qty
//         FROM
// 		payout
// 		INNER JOIN department ON department.ID = payout.DeptID
//         WHERE
//             payout.IsCancel = 0
//         AND payout.IsSpecial = 0
//         AND payout.IsBorrow = 0
//          AND payout.DeptID IN ( 387 , 388)
//         AND payout.IsStatus IN (1, 2, 3, 8)
//         AND payout.RefDocNo IN ( $RefDocNo_ )
//         GROUP BY payout.RefDocNo , FORMAT ( payout.CreateDate, 'dd/MM/yyyy')";

//         $meQuery1 = $conn->prepare($query);
//         $meQuery1->execute();
//         while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            
//             $pdf->SetFont('db_helvethaica_x', 'B', 18);

//             $html .= '<tr nobr="true" style="font-size:15px;">';
//             $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
//             $html .=   '<td width="50 %" align="center"> ' . $Result_Detail['RefDocNo'] . '</td>';
//             $html .=   '<td width="20 %" align="center">' . $Result_Detail['Date'] . '</td>';
//             $html .=   '<td width="20 %" align="center">' . $Result_Detail['Qty'] . '</td>';
//             $html .=  '</tr>';
//             $count++;
//         }


















// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_costSterile_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
