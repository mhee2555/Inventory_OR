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



        // if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');




            $this->SetFont('db_helvethaica_x', 'b', 22);
            $DocNo = $_GET['DocNo'];

            $query = " SELECT
                            hncode.HnCode,
                            FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1,
		                    FORMAT(hncode.ModifyDate , 'HH:mm') AS time1,
                            [procedure].Procedure_EN AS Procedure_TH,
                            doctor.Doctor_Name_EN AS Doctor_Name,
                            departmentroom.departmentroomname_EN 
                        FROM
                            dbo.hncode
                            LEFT JOIN dbo.[procedure] ON hncode.[procedure] = [procedure].ID
                            LEFT JOIN dbo.doctor ON hncode.doctor = doctor.ID
                            INNER JOIN dbo.departmentroom ON hncode.departmentroomid = departmentroom.id
                        WHERE  hncode.DocNo = '$DocNo' ";
            $meQuery1 = $conn->prepare($query);
            $meQuery1->execute();
            while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
              $HnCode =   $Result_Detail['HnCode'];
              $date1 =     $Result_Detail['date1'];
              $time1 =     $Result_Detail['time1'];
              $Procedure_TH =     $Result_Detail['Procedure_TH'];
              $Doctor_Name =     $Result_Detail['Doctor_Name'];
              $departmentroomname_EN =     $Result_Detail['departmentroomname_EN'];


            }

            //   $this->Cell(0, 10,  " รายงานคลัง Center จ่ายอุปกรณ์ให้ห้องตรวจ", 0, 1, 'C');


            $this->SetX(5);
            $this->Cell(50, 35,  "", 1, 0, 'L');
            $this->Cell(115, 35,  "", 1, 0, 'L');
            $this->Cell(35, 35,  "", 1, 0, 'L');


            $this->SetY(40);
            $this->SetX(7);
            $this->SetFont('db_helvethaica_x', 'B', 15);
            $this->Cell(46, 8,  "Medical Instrument Tracking", 1, 1, 'C');


            $this->SetFont('db_helvethaica_x', 'B', 10);
            $this->SetY(15);
            $this->SetX(57);
            $this->Cell(50, 0,  "Name : - ", 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(50, 0,  "Nationality : - ", 0, 1, 'L');
            $this->SetX(57);
            $this->Cell(50, 0,  "HN : ".$HnCode, 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(50, 0,  "Physicial : ".$Doctor_Name, 0, 1, 'L');
            $this->SetX(57);
            $this->Cell(50, 0,  "Visit Date : ".$date1, 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(50, 0,  "Department : Dental Center ", 0, 1, 'L');
            $this->SetX(57);
            $this->Cell(50, 0,  "Birth Date : - ", 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(25, 0,  "Age : - ", 0, 0, 'L');
            $this->Cell(30, 0,  "Sex : - ", 0, 1, 'L');
            $this->SetX(57);
            $this->Cell(50, 0,  "Allergies : - ", 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(25, 0,  "Room : ".$departmentroomname_EN, 0, 1, 'L');
            $this->SetX(57);
            $this->Cell(50, 0,  "Side Effect : - ", 0, 1, 'L');
            //   $this->Cell(54, 8,  "Medical Instrument Tracking", 1, 1, 'C');


            $this->SetY(18);
            $this->SetX(175);
            $this->Cell(80, 0,  " QR Code HN ", 0, 0, 'L');



            // $this->Ln();
            $image_file = "images/LOGO_bk.png";
            $this->Image($image_file, 10, 20, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


            $style = array(
                'border' => false,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            // write RAW 2D Barcode
            $this->write2DBarcode($HnCode, 'QRCODE,L', 170, 20, 80, 30, $style, 'N');

            $this->SetFont('db_helvethaica_x', 'B', 16);
            $this->SetY(50);
            $this->SetX(5);
            $this->Cell(200, 5,  "", 1, 0, 'L');

            $this->SetY(50);
            $this->SetX(6);
            $this->Cell(50, 0,  "Proceduce__________________________________Date_________________________Time_________________________", 0, 0, 'L');

            $this->SetX(30);
            $this->Cell(0, 0,  $Procedure_TH, 0, 0, 'L');
            $this->SetX(110);
            $this->Cell(0, 0,  $date1, 0, 0, 'L');
            $this->SetX(170);
            $this->Cell(0, 0,  $time1, 0, 0, 'L');

            $this->Ln(5);


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
$pdf->SetMargins(5, 60, 5);
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

$DocNo = $_GET['DocNo'];
// $pdf->Ln(42);


$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:13px;">
<th width="5 %" align="center">No</th>
<th width="17 %" align="center">Usage Code</th>
<th width="38 %"  align="center">BarCode</th>
<th width="10 %" align="center">MFG</th>
<th width="10 %" align="center">EXP</th>
<th width="20 %"  align="center">ItemName</th>
</tr> </thead>';

$count = 1;
$Sql_Detail = "SELECT
                    hncode.ID,
                    item.itemname,
                    itemstock.UsageCode,
                    item.itemcode,
                    FORMAT ( itemstock.expDate, 'dd-MM-yyyy' ) AS expDate ,
                    FORMAT ( itemstock.CreateDate, 'dd-MM-yyyy' ) AS CreateDate ,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE
                    hncode.IsStatus = 1
                    AND hncode.IsCancel = 0  
                    AND hncode.DocNo = '$DocNo'
                ORDER BY
                    hncode.ID ASC  ";

$meQuery1 = $conn->prepare($Sql_Detail);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $params = $pdf->serializeTCPDFtagParameters(array($Result_Detail['UsageCode'], 'C39', '', '', 70, 20, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>1), 'N'));

    
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);


    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="5 %" align="center">' . $count . '</td>';
    $html .=   '<td width="17 %" align="left"> ' . $Result_Detail['UsageCode'] . '</td>';
    $html .=   '<td width="38 %" align="center"><tcpdf method="write1DBarcode" params="'.$params.'" /></td>';
    $html .=   '<td width="10 %" align="center">' . $Result_Detail['CreateDate'] . '</td>';
    $html .=   '<td width="10 %" align="center">' . $Result_Detail['expDate'] . '</td>';
    $html .=   '<td width="20 %" align="center">' . $Result_Detail['itemname'] . '</td>';
    $html .=  '</tr>';

    $count++;
}





$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');









// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Hn_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
