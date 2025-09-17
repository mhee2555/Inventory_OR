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

            $_select_date1_search1 = $_GET['select_date1_search1'];
            $date1 = explode("-", $_select_date1_search1);
            $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];


            $weekday_map = [
                'Sunday'    => 'อาทิตย์',
                'Monday'    => 'จันทร์',
                'Tuesday'   => 'อังคาร',
                'Wednesday' => 'พุธ',
                'Thursday'  => 'พฤหัสบดี',
                'Friday'    => 'ศุกร์',
                'Saturday'  => 'เสาร์'
            ];

            $day = date('l', strtotime($date1));


            $this->SetFont('db_helvethaica_x', 'b', 16);

            $this->Ln(5);

            // 
            $this->Cell(0, 10, "วัน...................วันที่..........เดือน.......................ปี..........", 0, 1, 'C');

            $this->SetY(9);


            if ($weekday_map[$day] == 'พฤหัสบดี') {
                $this->SetX(68);
            } else {
                $this->SetX(70);
            }
            $this->Cell(0, 10, $weekday_map[$day], 0, 1, 'L');


            $date = explode("-", $_select_date1_search1);

            $this->SetY(9);
            $this->SetX(97);
            $this->Cell(0, 10, $date[0], 0, 1, 'L');


            $this->SetY(9);
            $this->SetX(115);
            $this->Cell(0, 10, $datetime->getTHmonthFromnum($date[1]), 0, 1, 'L');


            $this->SetY(9);
            $this->SetX(140);
            $this->Cell(0, 10, $date[2], 0, 1, 'L');
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
$pdf->SetTitle('Report_hn_daily1');
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
$pdf->SetMargins(15, 20, 15);
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




$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="10 %" align="center">ลำดับ</th>
<th width="20 %" align="center">เวลา</th>
<th width="30 %"  align="center">Operation</th>
<th width="20 %" align="center">HN</th>
<th width="20 %" align="center">อาจารย์</th>
</tr> </thead>';

$_select_date1_search1 = $_GET['select_date1_search1'];


$select_date1_search = explode("-", $_select_date1_search1);
$select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];

$count = 1;

$query = "SELECT
            deproom.ID,
            deproom.isStatus,
            deproom.hn_record_id AS hncode,
            deproom.number_box,
            deproom.IsTF,
            DATE( deproom.serviceDate ) AS serviceDate,
            DATE_FORMAT( TIME( deproom.serviceDate ), '%H:%i' ) AS serviceTime,
            deproom.departmentroomid,
            deproom.remark,
            departmentroom.departmentroomname,
            deproom.isCancel,
            ( SELECT GROUP_CONCAT( doctor.Doctor_Name SEPARATOR ' , ' ) FROM doctor WHERE FIND_IN_SET( doctor.ID, deproom.doctor ) ) AS Doctor_Name,
            ( SELECT GROUP_CONCAT( `procedure`.Procedure_TH SEPARATOR ' , ' ) FROM `procedure` WHERE FIND_IN_SET( `procedure`.ID, deproom.`procedure` ) ) AS Procedure_TH 
        FROM
            deproom
            INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
            AND DATE( deproom.serviceDate ) = '$select_date1_search' 
            AND deproom.DocNo NOT IN (SELECT set_hn.DocNo_deproom FROM set_hn WHERE DATE( set_hn.serviceDate ) = '$select_date1_search' AND set_hn.isCancel = 1  AND DocNo_deproom IS NOT NULL  )
            AND NOT deproom.isStatus = 9 
            AND  deproom.isCancel = 0
        ORDER BY
            deproom.serviceDate ASC; ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

$serviceTime = $Result_Detail['serviceTime'];
$Doctor_Name = $Result_Detail['Doctor_Name'];
$Procedure_TH = $Result_Detail['Procedure_TH'];
$hncode = $Result_Detail['hncode'];
$IsTF = $Result_Detail['IsTF'];

    if($hncode == ""){
        $hncode = $Result_Detail['number_box'];
    }

    if($IsTF == 1){
        $IsTF = 'TF';
    }else{
        $IsTF = "";
    }


$html .= '<tr nobr="true" style="font-size:18px;">';
$html .=   '<td width="10 %" align="center" > ' . $count . '</td>';
$html .=   '<td width="20 %" align="center" > ' . $serviceTime . ' ' . $IsTF . ' </td>';
$html .=   '<td width="30 %" align="left" >' . $Procedure_TH . '</td>';
$html .=   '<td width="20 %" align="left" >' . $hncode . '</td>';
$html .=   '<td width="20 %" align="left">' . $Doctor_Name . '</td>';
$html .=  '</tr>';
$count++;







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
