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
$pdf->Ln(15);


$DocNo = $_GET['DocNo'];

$checkloopDoctor  = "";
$_procedure = "";
$query = "SELECT
                CONCAT( employee1.FirstName, ' ', employee1.LastName ) AS name_1,
								DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS CreateDate,
                TIME(deproom.serviceDate) AS CreateTime,
                hncode.HnCode,
                hncode.number_box,
                hncode.DocNo,
                departmentroom.departmentroomname,
                hncode.`procedure`,
                hncode.doctor,
                doctor.Doctor_Name,
                doctor.Doctor_Code,
                deproom.Remark
            FROM
                hncode
                LEFT JOIN users AS user1 ON hncode.UserCode = user1.ID
                LEFT JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
                LEFT JOIN departmentroom ON hncode.departmentroomid = departmentroom.id
                LEFT JOIN doctor ON hncode.doctor = doctor.ID 
                LEFT JOIN deproom ON deproom.DocNo = hncode.DocNo_SS 
            WHERE
                hncode.DocNo = '$DocNo' ";
$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $_name1 = $row['name_1'];
    $_HnCode = $row['HnCode'];
    $_number_box = $row['number_box'];
    $_procedure = $row['procedure'];
    $_doctor = $row['doctor'];
    $_departmentroomname = $row['departmentroomname'];
    $_Doctor_Name = $row['Doctor_Name'];
    $_Doctor_Code = $row['Doctor_Code'];
    $_CreateDate = $row['CreateDate'];
    $_CreateTime = $row['CreateTime'];
    $_Remark = $row['Remark'];

    if($_HnCode == ""){
        $_HnCode = $_number_box;
    }


    

    if (str_contains($row['doctor'], ',')) {
        $checkloopDoctor = 'loop';
    }
}

$select = " SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $_procedure )  ";
$meQuery_select = $conn->prepare($select);
$meQuery_select->execute();
while ($row_select = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
    $_procedure_ids = $row_select['procedure_ids'];
}

$pdf->Cell(50, 5,  "HN : " . $_HnCode, 0, 0, 'L');
$pdf->Cell(50, 5,  "ชื่อ : - " , 0, 1, 'R');

$pdf->Cell(130, 5,  "วันที่เข้ารับบริการ : " . $_CreateDate, 0, 1, 'L');
$pdf->Cell(130, 5,  "เวลาเข้ารับบริการ : " . $_CreateTime, 0, 1, 'L');

$pdf->Cell(130, 5,   "Procedure : " . $_procedure_ids, 0, 1, 'L');


$pdf->Cell(130, 5,  "แพทย์", 0, 1, 'L');


if ($checkloopDoctor == 'loop') {

    $_doctor = explode(",", $_doctor);

    foreach ($_doctor as $key => $value) {

        $query_D = "SELECT
                    doctor.ID,
                    doctor.Doctor_Name ,
                    doctor.Doctor_Code 
                FROM
                    doctor
                WHERE doctor.ID = $value
                    
                ORDER BY Doctor_Name ASC  ";


        $meQuery_D = $conn->prepare($query_D);
        $meQuery_D->execute();
        while ($row_D = $meQuery_D->fetch(PDO::FETCH_ASSOC)) {
            $_Doctor_Name = $row_D['Doctor_Name'];
            $_Doctor_Code = $row_D['Doctor_Code'];
        }


        $pdf->Cell(50, 5, ($key + 1). ". ". $_Doctor_Name, 0, 1, 'L');
    }
} else {
    $pdf->Cell(50, 5,  "1. " . $_Doctor_Name, 0, 1, 'L');
}

$pdf->Cell(130, 5,   "หมายเหตุ : " . $_Remark, 0, 1, 'L');


$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="12 %" align="center">Code</th>
<th width="30 %" align="center">Barcode</th>
<th width="28 %"  align="center">ชื่อ</th>
<th width="6 %" align="center">Qty</th>
<th width="12 %" align="center">Unit price</th>
<th width="12 %" align="center">Total Price</th>
</tr> </thead>';



$count = 1;
$sum_all = 0;
$query = " SELECT
                item.itemname,
                item.itemcode2,
                item.SalePrice,
                hncode_detail.ID,
                SUM( hncode_detail.Qty ) AS cnt,
                itemtype.TyeName 
            FROM
                hncode
                LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                LEFT JOIN itemstock ON itemstock.RowID = hncode_detail.ItemStockID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN itemtype ON item.itemtypeID = itemtype.ID 
            WHERE
                hncode.DocNo = '$DocNo' 
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
        if($Result_Detail['itemcode2'] != null){
            // $itemcode = strtoupper(preg_replace('/[^A-Z0-9 \-.\$\/\+\%]/', '', $Result_Detail['itemcode2']));
        }

        $params = $pdf->serializeTCPDFtagParameters(array(
            $Result_Detail['itemcode2'], 'C128', '', '', 50, 10, 0.4,
            array(
                'position' => 'S',
                'border' => false,
                'padding' => 0,
                'fgcolor' => array(0,0,0),
                'bgcolor' => array(255,255,255),
                'text' => true,
                'font' => 'thsarabunnew',  // ถ้าใช้ข้อความภาษาไทยประกอบ
                'fontsize' => 10,
                'stretchtext' => 1
            ), 'N'
        ));

        
        // $params = $pdf->serializeTCPDFtagParameters(array($itemcode, 'C39', '', '', 50, 10, 0.4, array('position' => 'S', 'border' => false, 'padding' => 0, 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 8, 'stretchtext' => 1), 'N'));
    
        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="12 %" align="center" style="line-height:50px;"> ' . $Result_Detail['itemcode2'] . '</td>';
        $html .=   '<td width="30 %" align="center"> <tcpdf method="write1DBarcode" params="' . $params . '" /> </td>';
        $html .=   '<td width="28 %" align="left" style="line-height:50px;">' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="6 %" align="center" style="line-height:50px;">' . $Result_Detail['cnt'] . '</td>';
        $html .=   '<td width="12 %" align="right" style="line-height:50px;">' . number_format($Result_Detail['SalePrice'],2) . '</td>';
        $html .=   '<td width="12 %" align="right" style="line-height:50px;">' . number_format( ($Result_Detail['SalePrice'] * $Result_Detail['cnt']) ,2) . '</td>';
        $html .=  '</tr>';
        $count++;

        $sum_all += $Result_Detail['SalePrice'] * $Result_Detail['cnt'];
    }


}

$html .= '<tr nobr="true" style="font-size:15px;">';
$html .=   '<td width="88 %" align="center" rowspan="5">Grand Total</td>';
$html .=   '<td width="12 %" align="center">' . number_format($sum_all,2) . '</td>';
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
