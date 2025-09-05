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
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " " . date('Y');



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
$pdf->SetTitle('Report_exsoon');
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


$GN_WarningExpiringSoonDay = $_GET['GN_WarningExpiringSoonDay'];





$pdf->Cell(0, 10,  " รายงานอุปกรณ์ใกล้หมดอายุ", 0, 1, 'C');




$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="10 %" align="center">ลำดับ</th>
<th width="20 %"  align="center">รหัสอุปกรณ์</th>
<th width="55 %"  align="center">อุปกรณ์</th>
<th width="15 %" align="center">วันหมดอายุ</th>
</tr> </thead>';



$count = 1;
$sum_all = 0;
$query = " SELECT
                itemstock.ItemCode,
                itemstock.UsageCode,
                itemstock.RowID,
                DATE_FORMAT( itemstock.ExpireDate, '%d/%m/%Y' ) AS ExpireDate,
                COUNT( itemstock.Qty ) AS Qty,
            CASE
                    
                    WHEN DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                    AND DATE_ADD( CURDATE(), INTERVAL $GN_WarningExpiringSoonDay DAY ) 
                    AND DATE( itemstock.ExpireDate ) != CURDATE() THEN
                        'ใกล้หมดอายุ' ELSE 'หมดอายุ' 
                    END AS IsStatus,
                CASE
                        
                        WHEN DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                        AND DATE_ADD( CURDATE(), INTERVAL $GN_WarningExpiringSoonDay  DAY ) 
                        AND DATE( itemstock.ExpireDate ) != CURDATE() THEN
                            DATEDIFF(
                                itemstock.ExpireDate,
                            CURDATE()) ELSE DATEDIFF( CURDATE(), itemstock.ExpireDate ) 
                        END AS Exp_day,
                        item.itemname 
                    FROM
                        itemstock
                        LEFT JOIN item ON item.itemcode = itemstock.ItemCode 
                    WHERE
                        itemstock.IsCancel = 0 
                        AND (
                            DATE( itemstock.ExpireDate ) <= CURDATE() 
                            OR DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                            AND DATE_ADD( CURDATE(), INTERVAL  $GN_WarningExpiringSoonDay DAY ) 
                        ) 
                    GROUP BY
                        itemstock.UsageCode 
                    HAVING
                        IsStatus = 'ใกล้หมดอายุ' 
                    ORDER BY
                    item.itemname,
                DATE( itemstock.ExpireDate ) ASC;  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);




        $itemcode = "";
        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
        $html .=   '<td width="20 %" align="center">' .    $Result_Detail['UsageCode'] . '</td>';
        $html .=   '<td width="55 %" align="left">' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="15 %" align="center">' . $Result_Detail['ExpireDate'] . '</td>';
        $html .=  '</tr>';
        $count++;


}

// $html .= '<tr nobr="true" style="font-size:15px;">';
// $html .=   '<td width="90 %" align="center" rowspan="5">ยอดรวมสุทธิ</td>';
// $html .=   '<td width="10 %" align="center">' . $sum_all . '</td>';
// $html .=  '</tr>';


$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_ex_soon_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
