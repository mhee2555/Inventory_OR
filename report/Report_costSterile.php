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
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));



        if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');




            $this->SetFont('db_helvethaica_x', 'b', 22);
            $Ref = $_GET['Ref'];



              $this->Cell(0, 10,  "รายงานสรุปค่าใช้จ่ายในการส่งอุปกรณ์ Sterile", 0, 1, 'C');
              $this->Cell(0, 10,  "แผนกทันตกรรม โรงพยาบาลกรุงเทพ", 0, 1, 'C');






            // $this->Ln();
            $image_file = "images/LOGO_bk.png";
            $this->Image($image_file, 10, 20, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






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
$pdf->SetTitle('Report_Stock_Center');
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
$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
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
$Ref = $_GET['Ref'];
$pdf->Ln(10);
$pdf->Cell(0, 1,  "อ้างอิงเอกสาร Create Request No.", 0, 1, 'L');

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;">
<th width="10 %" align="center">ลำดับ</th>
<th width="30 %" align="center">Request No.</th>
<th width="30 %"  align="center">วันที่</th>
<th width="30 %" align="center">จำนวนเอกสาร Return</th>
</tr> </thead>';


$Ref = explode(",", $Ref);
$RefDocNo_ = "";
foreach ($Ref as $key => $value) {
    $RefDocNo_ .= "'".$value."',"; 
}
$RefDocNo_ = substr($RefDocNo_ , 0, -1);
$count = 1;
$query = "SELECT
            payout.RefDocNo,
            FORMAT ( payout.CreateDate, 'dd/MM/yyyy') AS Date,
            COUNT(payout.RefDocNo) AS Qty
        FROM
		payout
		INNER JOIN department ON department.ID = payout.DeptID
        WHERE
            payout.IsCancel = 0
        AND payout.IsSpecial = 0
        AND payout.IsBorrow = 0
         AND payout.DeptID IN ( 387 , 388)
        AND payout.IsStatus IN (1, 2, 3, 8)
        AND payout.RefDocNo IN ( $RefDocNo_ )
        GROUP BY payout.RefDocNo , FORMAT ( payout.CreateDate, 'dd/MM/yyyy')";

        $meQuery1 = $conn->prepare($query);
        $meQuery1->execute();
        while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            
            $pdf->SetFont('db_helvethaica_x', 'B', 18);

            $html .= '<tr nobr="true" style="font-size:15px;">';
            $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
            $html .=   '<td width="30 %" align="center"> ' . $Result_Detail['RefDocNo'] . '</td>';
            $html .=   '<td width="30 %" align="center">' . $Result_Detail['Date'] . '</td>';
            $html .=   '<td width="30 %" align="center">' . $Result_Detail['Qty'] . '</td>';
            $html .=  '</tr>';
            $count++;
        }










$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');



$pdf->Ln(5);
$pdf->Cell(0, 1,  "สรุปค่าใช้จ่ายการส่งอุปกรณ์ Sterile", 0, 1, 'L');

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;">
<th width="10 %" align="center">ลำดับ</th>
<th width="45 %" align="center">อุปกรณ์</th>
<th width="15 %"  align="center">จำนวน</th>
<th width="15 %" align="center">ราคาต่อหน่วย</th>
<th width="15 %" align="center">ราคารวม</th>
</tr> </thead>';


$count2 = 1;
$query = "SELECT
            item.itemname ,
            COUNT( payoutdetailsub.Qty ) AS qty,
            item.CostPrice,
            (COUNT( payoutdetailsub.Qty ) * item.CostPrice) AS totalPrice
            FROM
                payout
            INNER JOIN department ON department.ID = payout.DeptID
            INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
            INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
            INNER JOIN itemstock ON payoutdetailsub.ItemStockID = itemstock.RowID
            INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            WHERE
                payout.IsCancel = 0
            AND payout.IsSpecial = 0
            AND payout.IsBorrow = 0
             AND payout.DeptID IN ( 387 , 388)
            AND payout.IsStatus IN (1, 2, 3, 8)
            AND payout.RefDocNo IN ( $RefDocNo_ )
            GROUP BY
                item.itemname,
                item.CostPrice ";

        $meQuery1 = $conn->prepare($query);
        $meQuery1->execute();

        $sum_qty  = 0;
        $sum_totalPrice  = 0;
        while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            
            $pdf->SetFont('db_helvethaica_x', 'B', 18);

            $html .= '<tr nobr="true" style="font-size:15px;">';
            $html .=   '<td width="10 %" align="center"> ' . $count2 . '</td>';
            $html .=   '<td width="45 %" align="left"> ' . $Result_Detail['itemname'] . '</td>';
            $html .=   '<td width="15 %" align="right">' . $Result_Detail['qty'] . '</td>';
            $html .=   '<td width="15 %" align="right">' . $Result_Detail['CostPrice'] . '</td>';
            $html .=   '<td width="15 %" align="right">' . $Result_Detail['totalPrice'] . '</td>';
            $html .=  '</tr>';
            $count2++;

            $sum_qty  += $Result_Detail['qty'];
            $sum_totalPrice  += $Result_Detail['totalPrice'];
        }


        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="10 %" align="center"></td>';
        $html .=   '<td width="45 %" align="center">รวม</td>';
        $html .=   '<td width="15 %" align="right">' . number_format($sum_qty) . '</td>';
        $html .=   '<td width="15 %" align="center"></td>';
        $html .=   '<td width="15 %" align="right">' . number_format($sum_totalPrice) . '</td>';
        $html .=  '</tr>';







$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');





// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_costSterile_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
