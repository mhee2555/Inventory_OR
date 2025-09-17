<?php

session_start();
require('../config/db.php');
// include 'phpqrcode/qrlib.php';
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


        $image_file = "images/logo2.jpg";
        $this->Image($image_file, 12, 15, 60, 18, 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);
        if ($this->page == 1) {
        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number


        $this->Cell(180, 10,  "POSEINTELLIGENCE", 0, 0, 'C');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_hn_daily2');
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


$_select_date1_search1 = $_GET['select_date1_search1'];
$select_date1_search = explode("-", $_select_date1_search1);
$select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];


$query = "SELECT
            deproom.ID,
            deproom.isStatus,
            deproom.IsTF,
            deproom.hn_record_id AS hncode,
            deproom.number_box,
            DATE_FORMAT( deproom.serviceDate, '%d/%m/%Y' ) AS serviceDate,
            DATE_FORMAT( TIME( deproom.serviceDate ), '%H:%i' ) AS serviceTime,
            deproom.departmentroomid,
            deproom.remark,
            deproom.DocNo  AS DocNo_deproom,
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
            deproom.serviceDate ASC;  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {



    // set font
    // add a page
    $pdf->AddPage('L', 'A5');
    $pdf->SetFont('db_helvethaica_x', 'B', 20);

    $serviceTime = $Result_Detail['serviceTime'];
    $serviceDate = $Result_Detail['serviceDate'];
    $Doctor_Name = $Result_Detail['Doctor_Name'];
    $Procedure_TH = $Result_Detail['Procedure_TH'];
    $IsTF = $Result_Detail['IsTF'];
    $hncode = $Result_Detail['hncode'];
    $DocNo_deproom = $Result_Detail['DocNo_deproom'];

    if($hncode == ""){
        $hncode = $Result_Detail['number_box'];
    }

    $Procedure_TH = mb_strimwidth($Procedure_TH, 0, 60, '…', 'UTF-8');



    $count = 1;


    $pdf->Cell(0, 27, " ", 0, 1);


    // ขนาด label
    $labelW = 45;


    // Row: เวลา
    $pdf->Cell($labelW, 10, 'Visit Date : .................................................................................................................', 0, 0);
    $pdf->Cell(150, 17, " ", 0, 1);

    // Row: วันที่
    $pdf->Cell($labelW, 10, 'HN Code/Box No : ................................................................................................', 0, 0);
    $pdf->Cell(150, 17, " ", 0, 1);

    // Row: Operation
    $pdf->Cell($labelW, 10, 'Visit Time : .................................................................................................................', 0, 0);
    $pdf->Cell(150, 17, " ", 0, 1);

    // Row: แพทย์
    $pdf->Cell($labelW, 10, 'Operation : .................................................................................................................', 0, 0);
    $pdf->Cell(150, 17, " ", 0, 1);

    // Row: แพทย์
    $pdf->Cell($labelW, 10, 'Physician : .................................................................................................................', 0, 0);
    $pdf->Cell(150, 17, " ", 0, 0);

    $pdf->SetFont('db_helvethaica_x', 'B', 22);


    list($day, $month, $year) = explode('/', $serviceDate);
    $dateFormatted = "$year-$month-$day";

    // หาวันในสัปดาห์ (1=จันทร์, 7=อาทิตย์)
    $dayOfWeek = date('N', strtotime($dateFormatted));


    // กำหนดสีพื้นหลังแต่ละวัน (RGB)
$colors = [
    1 => [253, 253, 150],     // จันทร์
    2 => [255, 105, 180],   // อังคาร
    3 => [0, 128, 0],       // พุธ
    4 => [255, 204, 0],     // พฤหัสบดี
    5 => [0, 102, 204],     // ศุกร์
    6 => [128, 0, 128],     // เสาร์
    7 => [204, 0, 0],       // อาทิตย์
];

    // ตั้งค่าสีพื้นหลังตามวัน
    $pdf->SetFillColor($colors[$dayOfWeek][0], $colors[$dayOfWeek][1], $colors[$dayOfWeek][2]);
    // ตั้งค่าสีตัวอักษร (ดำ)
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('db_helvethaica_x', 'B', 40);
    $pdf->SetY(35);
    $pdf->SetX(40);
    $pdf->Cell(50, 0, $serviceDate, 0, 1, '', true);
    // $pdf->Cell(50, 0, $serviceDate, 0, 1);
    $pdf->SetY(63);
    $pdf->SetX(63);
    $pdf->SetFont('db_helvethaica_x', 'B', 20);
    $pdf->Cell(0, 0, $hncode, 0, 1);
    $pdf->SetY(80);
    $pdf->SetX(45);
    $pdf->Cell(0, 0, $serviceTime, 0, 1);
    $pdf->SetY(96);
    $pdf->SetX(45);
    $pdf->Cell(0, 0, $Procedure_TH, 0, 1);
    $pdf->SetY(113);
    $pdf->SetX(45);
    $pdf->Cell(0, 0, $Doctor_Name, 0, 1);


    // ล้อมกรอบ (optional)

    $pdf->Rect(10, 9, 190, 130); // (x, y, w, h) - ปรับตาม layout จริง

    if($IsTF == 1){
        $pdf->SetY(75);
        $pdf->SetX(60);
        $pdf->SetFont('db_helvethaica_x', 'B', 35);
        $pdf->Cell(20, 0, 'TF', 0, 0, 'C');
    }



    // output the HTML content
    $permission = $_SESSION['permission'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];

    $DocNo = $DocNo_deproom;
    $x = 160; // คงที่ตามที่คุณอยากได้
    $y = 12;

    $style = array(
        'border' => true,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );
    // $url = 'http://10.11.9.54/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($DocNo); // หรือ link อะไรก็ได้
    $url = 'http://192.168.2.101:8080/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($DocNo) . '&remark=issue' . '&permission=' . $permission . '&Userid=' . $Userid . '&DepID=' . $DepID . '&deproom=' . $deproom; // // หรือ link อะไรก็ได้


    $pdf->write2DBarcode($url, 'QRCODE,L', $x, $y, 60, 30, $style, 'N');
}





//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_use_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
