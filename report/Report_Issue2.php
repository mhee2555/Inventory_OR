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

            // $type_date = $_GET['type_date'];
            // $date1 = $_GET['date1'];
            // $date2 = $_GET['date2'];
            // $month1 = $_GET['month1'];
            // $month2 = $_GET['month2'];
            // $checkday = $_GET['checkday'];
            // $checkmonth = $_GET['checkmonth'];

            // if($type_date == 1){

            //     if($checkday == 1){
            //         $date1 = explode("-", $date1);
            //         $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
            //     }else{
            //         $date1 = explode("-", $date1);
            //         $date2 = explode("-", $date2);

            //         $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 ) . " ถึง " .  $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
            //     }
            // }

            // if($type_date == 2){

            //     if($checkmonth == 1){
            //         $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1);
            //     }else{
            //         $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
            //     }
            // }


            $this->SetFont('db_helvethaica_x', 'b', 16);



            // $this->Cell(0, 10,  " ใบสรุปการจ่ายอุปกรณ์ให้คนไข้ ", 0, 1, 'C');
            //   $this->Cell(0, 10,  $text_date, 0, 1, 'C');






            $image_file = "images/logo1.png";
            $this->Image($image_file, 10, 5, 10, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$pdf->SetTitle('Report_Issue_(IOR)');
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

$type_date = $_GET['type_date'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$month1 = $_GET['month1'];
$month2 = $_GET['month2'];
$checkday = $_GET['checkday'];
$checkmonth = $_GET['checkmonth'];
$checkyear = $_GET['checkyear'];
$year1 = $_GET['year1'];
$year2 = $_GET['year2'];
$datetime = new DatetimeTH();

if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = explode("-", $date1);
        $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543);
    } else {
        $date1 = explode("-", $date1);
        $date2 = explode("-", $date2);

        $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " . ($date1[2] + 543) . " ถึง " .  $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1]) . " " . " พ.ศ." . " " . ($date2[2] + 543);
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $text_date = "เดือน : " . $datetime->getTHmonthFromnum($month1);
    } else {
        $text_date = "เดือน : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
    }
}

if ($type_date == 3) {

    if ($checkyear == 1) {
        $text_date = "ปี : " . $year1;
    } else {
        $text_date = "ปี : " . $year1 . " ถึง " . $year2;
    }
}


if ($type_date == 1) {

    if ($checkday == 1) {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

        $where_date = "AND DATE(deproom.serviceDate) = '$date1'  ";
    } else {
        $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
        $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

        $where_date = "AND DATE(deproom.serviceDate) BETWEEN '$date1' 	AND '$date2' ";
    }
}

if ($type_date == 2) {

    if ($checkmonth == 1) {
        $where_date = "AND MONTH(deproom.serviceDate) = '$month1'  ";

    } else {
        $where_date = "AND MONTH(deproom.serviceDate) BETWEEN '$month1' 	AND '$month2' ";
    }
}

if ($type_date == 3) {

    $year1 = $year1-543;
    $year2 = $year2-543;


    if ($checkyear == 1) {
        $where_date = "AND YEAR(deproom.serviceDate) = '$year1'  ";

    } else {
        $where_date = "AND YEAR(deproom.serviceDate) BETWEEN '$year1' 	AND '$year2' ";
    }
}

$pdf->Cell(0, 10,  "รายงานจ่ายอุปกรณ์ประจำวัน", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




// $checkloopDoctor  = "";
// $_procedure = "";
// $query = "SELECT
//             CONCAT(employee1.FirstName, ' ', employee1.LastName) AS name_1,
//             CONCAT(employee2.FirstName, ' ', employee2.LastName) AS name_2,
//             DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS serviceDate,
//             TIME(deproom.serviceDate) AS serviceTime,
//             deproom.hn_record_id,
//             departmentroom.departmentroomname,
//             deproom.`procedure`,
//             deproom.doctor,
//             doctor.Doctor_Name,
//             doctor.Doctor_Code 
//             FROM
//             deproom
//             LEFT JOIN users AS user1 ON deproom.UserCode = user1.ID
//             LEFT JOIN users AS user2 ON deproom.UserPay = user2.ID
//             LEFT JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
//             LEFT JOIN employee AS employee2 ON user2.EmpCode = employee2.EmpCode
//             LEFT JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
//             LEFT JOIN doctor ON deproom.doctor = doctor.ID 
//             $where_date ";


// $meQuery = $conn->prepare($query);
// $meQuery->execute();
// while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
//     $_name1 = $row['name_1'];
//     $_name2 = $row['name_2'];
//     $_serviceDate = $row['serviceDate'];
//     $_hn_record_id = $row['hn_record_id'];
//     $_procedure = $row['procedure'];
//     $_doctor = $row['doctor'];
//     $_serviceTime = $row['serviceTime'];
//     $_departmentroomname = $row['departmentroomname'];

//     $_Doctor_Name = $row['Doctor_Name'];
//     $_Doctor_Code = $row['Doctor_Code'];

//     if (str_contains($row['doctor'], ',')) {
//         $checkloopDoctor = 'loop';
//     }
// }


// $select = " SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $_procedure )  ";
// $meQuery_select = $conn->prepare($select);
// $meQuery_select->execute();
// while ($row_select = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
//     $_procedure_ids = $row_select['procedure_ids'];
// }


// $pdf->Cell(40, 5,  "เลข HN Code : " . $_hn_record_id, 0, 0, 'L');
// $pdf->Cell(50, 5,  "ชื่อ : - " , 0, 1, 'C');

// $pdf->Cell(130, 5,  "วันที่เข้ารับบริการ : " . $_serviceDate, 0, 1, 'L');
// $pdf->Cell(130, 5,  "เวลาเข้ารับบริการ : " . $_serviceTime, 0, 1, 'L');


// $pdf->SetFillColor(255, 255, 255);
// $pdf->MultiCell(180, 5, "Procedure : " . $_procedure_ids, 0, 'L', 0, 1);

// // $pdf->Cell(130, 5,  "หัตถการ : " . $_procedure_ids, 0, 1, 'L');

// $pdf->Cell(130, 5,  "แพทย์", 0, 1, 'L');

// if ($checkloopDoctor == 'loop') {

//     $_doctor = explode(",", $_doctor);

//     foreach ($_doctor as $key => $value) {

//         $query_D = "SELECT
//                     doctor.ID,
//                     doctor.Doctor_Name ,
//                     doctor.Doctor_Code 
//                 FROM
//                     doctor
//                 WHERE doctor.ID = $value
                    
//                 ORDER BY Doctor_Name ASC  ";


//         $meQuery_D = $conn->prepare($query_D);
//         $meQuery_D->execute();
//         while ($row_D = $meQuery_D->fetch(PDO::FETCH_ASSOC)) {
//             $_Doctor_Name = $row_D['Doctor_Name'];
//             $_Doctor_Code = $row_D['Doctor_Code'];
//         }


//         $pdf->Cell(50, 5, ($key + 1). ". ". $_Doctor_Name, 0, 1, 'L');
//     }
// } else {
//     $pdf->Cell(50, 5,  "1. " . $_Doctor_Name, 0, 1, 'L');
// }


$pdf->Ln(5);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="1" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="12 %" align="center">Code</th>
<th width="30 %" align="center">ItemCode</th>
<th width="50 %"  align="center">Name</th>
<th width="10 %" align="center">Qty</th>
</tr> </thead>';


// $type_date = $_GET['type_date'];
// $date1 = $_GET['date1'];
// $date2 = $_GET['date2'];
// $month1 = $_GET['month1'];
// $month2 = $_GET['month2'];
// $checkday = $_GET['checkday'];
// $checkmonth = $_GET['checkmonth'];


// if($type_date == 1){

//     if($checkday == 1){
//         $date1 = explode("-", $date1);
//         $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

//         $where_date = "WHERE DATE(itemstock.LastCabinetModify) = '$date1'  ";
//     }else{
//         $date1 = explode("-", $date1);
//         $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
//         $date2 = explode("-", $date2);
//         $date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];

//         $where_date = "WHERE DATE(itemstock.LastCabinetModify) BETWEEN '$date1' 	AND '$date2' ";

//     }
// }
// if($type_date == 2){

//     if($checkmonth == 1){
//     }else{
//     }
// }

$count = 1;
$query = "SELECT
            item.itemname,
            item.itemcode2,
            item.itemcode,
            deproomdetail.ID,
            SUM(deproomdetail.Qty) AS cnt,
            (SELECT COUNT(deproomdetailsub.ID) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID) AS cnt_pay,
            itemtype.TyeName
            FROM
            deproom
            INNER JOIN
            deproomdetail ON deproom.DocNo = deproomdetail.DocNo
            INNER JOIN
            item ON deproomdetail.ItemCode = item.itemcode
            INNER JOIN
            itemtype ON item.itemtypeID = itemtype.ID
            WHERE
             deproom.IsCancel = 0
            $where_date
            AND deproomdetail.IsCancel = 0
            GROUP BY
            item.itemname,
            item.itemcode2,
            deproomdetail.ID,
            itemtype.TyeName
            ORDER BY
            item.itemname ASC  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);




    if($Result_Detail['cnt_pay'] > 0){
        $html .= '<tr nobr="true" style="font-size:18px;height:30px;">';
        $html .=   '<td width="12 %" align="center"> ' . $Result_Detail['itemcode2'] . '</td>';
        $html .=   '<td width="30 %" align="center"> ' . $Result_Detail['itemcode'] . '</td>';
        // $html .=   '<td width="36 %" align="center"> ' . $Result_Detail['itemcode'] . '</td>';
        $html .=   '<td width="50 %" align="left"  style="line-height:40px;vertical-align: middle;"> ' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="10 %" align="center">' . $Result_Detail['cnt_pay'] . '</td>';
        $html .=  '</tr>';
        $count++;
    }


}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Issue_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
