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
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F'))  . " " . date('Y');



        if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');



            $this->SetFont('db_helvethaica_x', 'b', 16);

            $this->Ln(7);


              $this->Cell(0, 10,  "รายงานสรุปขายให้หน่วยงาน", 0, 1, 'C');
            //   $this->Cell(0, 10,  $text_date, 0, 1, 'C');






            $image_file = "images/logo1.png";
            $this->Image($image_file, 7, 5, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-15);
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
$pdf->SetAutoPageBreak(TRUE, 15);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetFont('db_helvethaica_x', 'B', 15);
$pdf->Ln(5);


$DocNo = $_GET['DocNo'];

$checkloopDoctor  = "";
$_procedure = "";
$query = "SELECT
                sell_department.DocNo,
                DATE_FORMAT(sell_department.ServiceDate, '%d-%m-%Y') AS serviceDate,
                DATE_FORMAT(sell_department.ServiceDate, '%H:%i') AS serviceTime,
                department.DepName
            FROM
                sell_department
                INNER JOIN department ON department.ID = sell_department.departmentID 
            WHERE
                sell_department.DocNo = '$DocNo'
            GROUP BY
                department.DepName   ";


$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $DepName = $row['DepName'];
    $_serviceDate = $row['serviceDate'];
    $_serviceTime = $row['serviceTime'];
}



$pdf->Cell(60, 5,  '', 0, 1, 'L');

$pdf->Cell(60, 5,  "แผนก : " . $DepName, 0, 1, 'L');
$pdf->Cell(130, 5,  "วันที่เข้ารับบริการ : " . $_serviceDate, 0, 1, 'L');
$pdf->Cell(130, 5,  "เวลาเข้ารับบริการ : " . $_serviceTime, 0, 1, 'L');


$pdf->Ln(3);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="15 %" align="center">รหัสอุปกรณ์</th>
<th width="40 %" align="center">ชื่ออุปกรณ์</th>
<th width="10 %"  align="center">จำนวน</th>
<th width="17.5 %" align="center">Unit price</th>
<th width="17.5 %" align="center">Total Price</th>


</tr> </thead>';



$count = 1;
$sum_all1 = 0;
$sum_all2 = 0;
$sum_all3 = 0;

$query = " SELECT
                item.itemname,
                item.itemcode2,
                item.SalePrice,
                sell_department_detail.ID,
                COUNT( sell_department_detail.ID ) AS cnt,
                itemtype.TyeName 
            FROM
                sell_department
                LEFT JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo
                LEFT JOIN itemstock ON itemstock.RowID = sell_department_detail.ItemStockID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN itemtype ON item.itemtypeID = itemtype.ID 
            WHERE
                sell_department.DocNo = '$DocNo' 
            GROUP BY  item.itemname
            ORDER BY
                item.itemname ASC ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="15 %" align="center" > ' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="40 %" align="left" > ' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="10 %" align="center" >' . $Result_Detail['cnt'] . '</td>';
    $html .=   '<td width="17.5 %" align="right" >' . $Result_Detail['SalePrice'] . '</td>';
    $html .=   '<td width="17.5 %" align="right">' . number_format( ($Result_Detail['SalePrice'] * $Result_Detail['cnt']) ,2). '</td>';
    $html .=  '</tr>';
    $count++;

    $sum_all1 += $Result_Detail['cnt'] ;
    $sum_all2 += $Result_Detail['SalePrice'];
    $sum_all3 += $Result_Detail['SalePrice'] * $Result_Detail['cnt'];







}

$html .= '<tr nobr="true" style="font-size:15px;">';
$html .=   '<td width="55 %" align="center" rowspan="2">Grand Total</td>';
$html .=   '<td width="10 %" align="center">' . number_format($sum_all1) . '</td>';
$html .=   '<td width="17.5 %" align="right"></td>';
$html .=   '<td width="17.5 %" align="right">' . number_format($sum_all3,2) . '</td>';
$html .=  '</tr>';


$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_use_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
