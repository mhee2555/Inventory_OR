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
      $this->Cell(0, 10,  " รายงานส่งอุปกรณ์ไป N Sterile", 0, 1, 'C');

      $image_file = "images/logo.png";
      $this->Image($image_file, 16, 30, 30, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

      $this->Ln(5);
    }
  }
  // Page footer
  public function Footer()
  {
    $this->SetY(-40);
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
$pdf->SetTitle('Report_Send_Nsterile');
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->Ln(5);

$select_date1 = $_GET['select_date1'];



$pdf->SetFont('db_helvethaica_x', 'b', 15);
$pdf->Ln(15);
$pdf->Cell(15, 7,   "สถานที่ : ", 0, 0, 'L');
$pdf->Cell(10, 7,   "Bangkok hospital", 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(40, 7,   "เลขที่เอกสารส่ง N Sterile : ", 0, 0, 'L');
$pdf->Cell(10, 7,   "RQ202311008977", 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(10, 7,   "วันที่ : ", 0, 0, 'L');
$pdf->Cell(10, 7,   $select_date1 , 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(15, 7,   "ผู้บันทึก : ", 0, 0, 'L');
$pdf->Cell(10, 7,   "ลอลา", 0, 0, 'L');
$pdf->Ln();

$_select_date1 = explode("/", $select_date1);
$_select_date1 = $_select_date1[2] . '-' . $_select_date1[1] . '-' . $_select_date1[0];


$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="background-color:#4e73df;color:#fff;">
<th width="10 %" align="center">ลำดับ</th>
<th width="30 %" align="center">รหัสอุปกรณ์</th>
<th width="40 %"  align="center">อุปกรณ์</th>
<th width="20 %" align="center">จำนวน</th>
</tr> </thead>';

  $count = 1;
  $Sql_Detail = " SELECT
                    item.itemcode ,
                    item.itemname  ,
                    itemstock_balance.Qty_Balance 
                  FROM
                  item
                  INNER JOIN itemstock_balance ON item.itemcode = itemstock_balance.ItemCode 
                  AND itemstock_balance.CreateDate = '$_select_date1' ";

  $meQuery1 = $conn->prepare($Sql_Detail);
  $meQuery1->execute();
  while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $html .= '<tr nobr="true">';
    $html .=   '<td width="10 %" align="center">' . $count . '</td>';
    $html .=   '<td width="30 %" align="left"> ' . $Result_Detail['itemcode'] . '</td>';
    $html .=   '<td width="40 %" align="center">' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="20 %" align="center">' . $Result_Detail['Qty_Balance'] . '</td>';

    $html .=  '</tr>';

    $count++;
  }





$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


//     $width = 144;
//     $width1 = 36;
//     $pdf->SetLineWidth(0.3);
//     $pdf->sety($pdf->Gety() - 6.5);
//     $pdf->Cell($width, 5, 'รวมน้ำหนัก', 1, 0, 'C');
//     $pdf->Cell($width1, 5, NUMBER_FORMAT($totalsum_W, 2), 1, 1, 'C');
//     $pdf->Cell($width, 5, 'รวมเงิน', 1, 0, 'C');
//     $pdf->Cell($width1, 5, $TOTAL, 1, 0, 'C');












//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Send_Nsterile_' . $ddate . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
