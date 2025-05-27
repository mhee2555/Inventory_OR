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


              $this->Cell(0, 10,  "รายงานสรุปการใช้อุปกรณ์กับคนไข้", 0, 1, 'C');
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
                doctor.Doctor_Code 
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

$pdf->Cell(50, 5,  "HN :" . $_HnCode, 0, 0, 'L');
$pdf->Cell(50, 5,  "ชื่อ : - " , 0, 1, 'R');

$pdf->Cell(83, 5,  "วันที่เข้ารับบริการ : " . $_CreateDate, 0, 0, 'L');
$pdf->Cell(50, 5,  "เวลาเข้ารับบริการ : " . $_CreateTime, 0, 1, 'R');

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



$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="15 %" align="center">รหัสอุปกรณ์</th>
<th width="25 %" align="center">ชื่ออุปกรณ์</th>
<th width="15 %"  align="center">ยอดสแกนจ่าย</th>
<th width="15 %" align="center">ยอดสแกนคืน</th>
<th width="15 %" align="center">ยอดใช้กับคนไข้</th>
<th width="15 %" align="center">รวมค่าใช้จ่าย</th>
</tr> </thead>';



$count = 1;
$sum_all1 = 0;
$sum_all2 = 0;
$sum_all3 = 0;
$sum_all4 = 0;

$sum_all11 = 0;
$sum_all22 = 0;
$sum_all33 = 0;
$sum_all44 = 0;

$query = " SELECT
                item.itemname,
                item.itemcode2,
                item.SalePrice,
                hncode_detail.ID,
                SUM( hncode_detail.Qty ) AS cnt,
                (
                SELECT
                    COUNT( log_return.id ) 
                FROM
                    log_return
                    INNER JOIN itemstock ON log_return.itemstockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE
                        log_return.DocNo = hncode.DocNo_SS 
                    AND item.itemcode = item.itemcode 
                )  AS cnt_return
            FROM
                hncode
                LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                LEFT JOIN itemstock ON itemstock.RowID = hncode_detail.ItemStockID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode 
            WHERE
                hncode.DocNo = '$DocNo' 
            GROUP BY
                item.itemname 
            ORDER BY
                item.itemname ASC  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('db_helvethaica_x', 'B', 18);



    if($Result_Detail['cnt'] != 0){
    
        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="15 %" align="center" style="line-height:50px;"> ' . $Result_Detail['itemcode2'] . '</td>';
        $html .=   '<td width="25 %" align="left" style="line-height:50px;"> ' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="15 %" align="center" style="line-height:50px;">' . $Result_Detail['cnt'] . '</td>';
        $html .=   '<td width="15 %" align="center" style="line-height:50px;">' . $Result_Detail['cnt_return'] . '</td>';
        $html .=   '<td width="15 %" align="center" style="line-height:50px;">' . number_format( ($Result_Detail['cnt'] - $Result_Detail['cnt_return']) ,2) . '</td>';
        $html .=   '<td width="15 %" align="center" style="line-height:50px;">' . number_format( ($Result_Detail['SalePrice'] * $Result_Detail['cnt']) ,2) . '</td>';
        $html .=  '</tr>';
        $count++;

        $sum_all1 += $Result_Detail['cnt'];
        $sum_all2 += $Result_Detail['cnt_return'] ;
        $sum_all3 += ($Result_Detail['cnt'] - $Result_Detail['cnt_return']);
        $sum_all4 += $Result_Detail['SalePrice'] * $Result_Detail['cnt'];




    }


}

        $sum_all11 = ($sum_all1 / $sum_all1) *100 ;
        $sum_all22 = ($sum_all2 / $sum_all1) *100 ;
        $sum_all33 = ($sum_all3 / $sum_all1) *100 ;

$html .= '<tr nobr="true" style="font-size:15px;">';
$html .=   '<td width="40 %" align="center" colspan="2">Grand Total</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all1,2) . '</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all2,2) . '</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all3,2) . '</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all4,2) . '</td>';
$html .=  '</tr>';

$html .= '<tr nobr="true" style="font-size:15px;">';
$html .=   '<td width="40 %" align="center" colspan="2">Utilization use rate</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all11,2) . '%</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all22,2) . '%</td>';
$html .=   '<td width="15 %" align="center">' . number_format($sum_all33,2) . '%</td>';
$html .=   '<td width="15 %" align="center"></td>';
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
