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

            $this->Ln(10);


              $this->Cell(0, 10,  "รายงานขอเบิก และ ส่งกลับอุปกรณ์ห้องผ่าตัด", 0, 1, 'C');
              $this->Cell(0, 10,  'Sub Inventory OR', 0, 1, 'C');






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
$pdf->SetTitle('Report_use');
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
$pdf->Ln(20);


$RqDocNo = $_GET['RqDocNo'];
$RtDocNo = $_GET['RtDocNo'];



$pdf->Cell(180, 5,  "เลขที่เอกสาร Request No. :  " . $RqDocNo , 0, 1, 'R');

$pdf->Cell(180, 5,  "เลขที่เอกสาร Return No. : " . $RtDocNo, 0, 1, 'R');




$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="15 %" align="center">ลำดับ</th>
<th width="15 %" align="center">รหัสอุปกรณ์</th>
<th width="25 %"  align="center">อุปกรณ์</th>
<th width="15 %" align="center">ยอดขอเบิก</th>
<th width="15 %" align="center">ยอดส่งกลับ</th>
<th width="15 %" align="center">คงเหลือ</th>
</tr> </thead>';



$count = 1;


    $query = " SELECT
                    item.itemcode2 AS itemcode,
                    item.itemname,
                    rq.request_qty,
                    IFNULL( COUNT( rf.QrCode ), 0 ) AS receive_qty,
                CASE
                        
                        WHEN IFNULL( COUNT( rf.QrCode ), 0 ) > rq.request_qty THEN
                        CONCAT(
                            '+',
                        ( COUNT( rf.QrCode ) - rq.request_qty )) ELSE rq.request_qty - IFNULL( COUNT( rf.QrCode ), 0 ) 
                    END AS remain_qty 
                FROM
                    item
                    LEFT JOIN ( SELECT request_detail.ItemCode, SUM( request_detail.qty ) AS request_qty FROM request_detail WHERE request_detail.DocNo = '$RqDocNo' GROUP BY request_detail.ItemCode ) rq ON rq.ItemCode = item.itemcode
                    LEFT JOIN (
                    SELECT
                        insertrfid_detail.ItemCode,
                        insertrfid_detail.QrCode 
                    FROM
                        insertrfid
                        INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo 
                    WHERE
                        insertrfid.RqDocNo = '$RqDocNo' 
                        AND insertrfid.RtDocNo = '$RtDocNo' 
                    ) rf ON rf.ItemCode = item.itemcode 
                WHERE
                    rq.request_qty IS NOT NULL 
                GROUP BY
                    item.itemcode2,
                    item.itemname,
                    rq.request_qty  ";



$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);



        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="15 %" align="center" > ' . $count . '</td>';
        $html .=   '<td width="15 %" align="left" > ' . $Result_Detail['itemcode'] . '</td>';
        $html .=   '<td width="25 %" align="center" >' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="15 %" align="center" >' . $Result_Detail['request_qty'] . '</td>';
        $html .=   '<td width="15 %" align="center" >' . $Result_Detail['receive_qty'] . '</td>';
        $html .=   '<td width="15 %" align="center" >' . $Result_Detail['remain_qty'] . '</td>';
        $html .=  '</tr>';





    


}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_use_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
