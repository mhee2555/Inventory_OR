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

            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 5,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 0, 'R');

            $image_file = "images/logo.png";
            $this->Image($image_file, 10, 10, 20, 10, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        if ($this->page == 1) {



            // $this->SetFont('db_helvethaica_x', 'b', 18);

            // $this->Cell(50, 8,  "  HN Code", 1, 0, 'C');
            // $this->Cell(150, 8,  " 777-666-444-333", 1, 1, 'L');

            // $this->Cell(50, 8,  "  วันที่เข้ารับบริการ", 1, 0, 'C');
            // $this->Cell(150, 8,  " 2024–12-12", 1, 1, 'L');

            // $this->Cell(50, 8,  "  แพทย์", 1, 0, 'C');
            // $this->Cell(150, 8,  " DR. SAKDITOUCH NUNNARK", 1, 1, 'L');

            // $this->Cell(50, 8,  "  หัตถการ", 1, 0, 'C');
            // $this->SetFillColor(215, 235, 255);
            // $this->MultiCell(150, 8,  " Arthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankleArthroscopic debridement ankle", 1, 1, 'L');

            // $this->Cell(50, 8,  "  ห้องผ่าตัด", 1, 0, 'C');
            // $this->Cell(150, 8,  " OPERATING ROOM NO 1", 1, 1, 'L');

            // $this->Cell(50, 8,  "  หมายเหตุ", 1, 0, 'C');
            // $this->Cell(150, 8,  " คนไข้อายุมาก", 1, 1, 'L');



      




            // $this->Ln();
            // $image_file = "images/LOGO_bk.png";
            // $this->Image($image_file, 10, 20, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number
        require('../connect/connect.php');
        // $DocNo = $_GET['DocNo'];

        // $query = " SELECT
        //                 CONCAT(employee.FirstName,' ',employee.LastName ) AS name ,
        //                 FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate
        //             FROM
        //                 deproom
        //                 INNER JOIN users ON deproom.UserCode = users.ID
        //                 INNER JOIN employee ON users.EmpCode = employee.EmpCode
        //                 WHERE
        //                 deproom.DocNo = '$DocNo' ";
        // $meQuery = $conn->prepare($query);
        // $meQuery->execute();
        // while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        //     $_name = $row['name'];
        //     $_serviceDate = $row['serviceDate'];
        // }

        // if ($this->last_page_flag) {


        //     $this->Cell(1, 9,  "                                                     $_name", 0, 0, 'L');
        //     $this->Cell(130, 10,   '                      ผู้สร้างใบขอเบิก : ' . "", 0, 0, 'L');


        //     $this->Cell(1, 9,  "                           $_serviceDate", 0, 0, 'L');
        //     $this->Cell(10, 10,   'วันและเวลา : ' . "", 0, 0, 'L');
        //     // $this->Cell(1, 9,  "         " . $Facdate . "  เวลา   " . $FacTime, 0, 0, 'L');
        //     // $this->Cell(90, 10,   'วันที่' . "", 0, 0, 'L');

        // }


        $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Send_Sterile');
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
$pdf->SetMargins(5, 15, 5);
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
$pdf->SetFont('db_helvethaica_x', 'B', 18);


$round = $_GET['round'];
$select_date1 = $_GET['select_date1'];
$select_date2 = $_GET['select_date2'];

$select_date1 = explode("-", $select_date1);
$select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];

$select_date2 = explode("-", $select_date2);
$select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];

$whereRound = "";
if($round != '0'){
    $whereRound = " AND sendsterile.Round = '$round' ";
}

$query1 = "SELECT
                sendsterile.Round,
                CONVERT ( DATE, sendsterile.DocDate ) AS _date
            FROM
                sendsterile 
            WHERE  CONVERT(DATE,sendsterile.DocDate) BETWEEN  '$select_date1' AND  '$select_date2' $whereRound
            GROUP BY
                CONVERT ( DATE, sendsterile.DocDate ),
                sendsterile.Round ";

$meQuery1 = $conn->prepare($query1);
$meQuery1->execute();
while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
    $_Round = $row1['Round'];
    $_date = $row1['_date'];

    $_cnt_SUDs_create = 0;
    $querySUDs = "SELECT
                        COUNT(sendsterile.ID) AS cnt_SUDs_create
                    FROM
                        sendsterile 
                    WHERE
                        sendsterile.Round = $_Round
                        AND CONVERT ( DATE, sendsterile.DocDate ) = '$_date' 
                        AND sendsterile.hncode IS NOT NULL
                    GROUP BY
                        CONVERT ( DATE, sendsterile.DocDate ),
                        sendsterile.Round ";
    $meQuerySUDs = $conn->prepare($querySUDs);
    $meQuerySUDs->execute();
    while ($rowSUDs = $meQuerySUDs->fetch(PDO::FETCH_ASSOC)) {
        $_cnt_SUDs_create ++;
    }

    $_cnt_Sterile_create = 0;
    $querySUDs = "SELECT
                        COUNT(sendsterile.ID) AS cnt_Sterile_create
                    FROM
                        sendsterile 
                    WHERE
                        sendsterile.Round = $_Round
                        AND CONVERT ( DATE, sendsterile.DocDate ) = '$_date' 
                        AND sendsterile.hncode IS NULL
                    GROUP BY
                        CONVERT ( DATE, sendsterile.DocDate ),
                        sendsterile.Round ";
    $meQuerySUDs = $conn->prepare($querySUDs);
    $meQuerySUDs->execute();
    while ($rowSUDs = $meQuerySUDs->fetch(PDO::FETCH_ASSOC)) {
        $_cnt_Sterile_create ++;
    }


    if($_cnt_Sterile_create > 0){
        $pdf->AddPage('P', 'A4');

        $pdf->Ln(10);

        $pdf->SetFont('db_helvethaica_x', 'b', 16);

        $pdf->Cell(200, 12,  "  รายงานส่งแลกเครื่องมือ ระหว่าง OR และ CSSD ", 1, 1, 'C');

        $pdf->SetFont('db_helvethaica_x', 'b', 16);

        $pdf->Cell(50, 12,  "  วันที่ ", 1, 0, 'C');
        $pdf->Cell(150, 12,  $_date, 1, 1, 'L');

        $pdf->Cell(50, 12,  "  รอบ", 1, 0, 'C');
        $pdf->Cell(150, 12,  $_Round, 1, 1, 'L');


        $pdf->Cell(50, 12,  "  รายงาน Sterile", 0, 1, 'L');

        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                    <thead><tr style="font-size:18px;line-height:35px;">
                    <th width="10 %" align="center">ลำดับ</th>
                    <th width="30 %" align="center">รายการ</th>
                    <th width="20 %"  align="center">ส่ง CSSD</th>
                    <th width="20 %" align="center">ส่ง OR</th>
                    <th width="20 %" align="center">Remark</th>
                    </tr> </thead>';



        $count = 1;
        $querySend = "SELECT
            item.itemname ,
            COUNT(itemstock.ItemCode) AS Qty,
            sendsteriledetail.Remark
        FROM
            sendsterile 
        INNER JOIN sendsteriledetail ON sendsteriledetail.SendSterileDocNo = sendsterile.DocNo
        INNER JOIN itemstock ON itemstock.UsageCode = sendsteriledetail.UsageCode
        INNER JOIN item ON item.itemcode = itemstock.ItemCode
        WHERE
            sendsterile.Round = $_Round
            AND CONVERT ( DATE, sendsterile.DocDate ) = '$_date' 
            AND sendsterile.hncode IS NULL 
            GROUP BY item.itemname , sendsteriledetail.Remark ";


    $meQuerySend = $conn->prepare($querySend);
    $meQuerySend->execute();
    while ($ResultSend = $meQuerySend->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('db_helvethaica_x', 'B', 18);

        $html .= '<tr nobr="true" style="font-size:17px;line-height:30px;">';
        $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
        $html .=   '<td width="30 %" align="left"> ' . $ResultSend['itemname'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Qty'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Qty'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Remark'] . '</td>';
        $html .=  '</tr>';
        $count++;
    }

$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');



    }
    if($_cnt_SUDs_create > 0){
        $pdf->AddPage('P', 'A4');

        $pdf->Ln(10);

        $pdf->SetFont('db_helvethaica_x', 'b', 16);

        $pdf->Cell(200, 12,  "  รายงานส่งแลกเครื่องมือ ระหว่าง OR และ CSSD ", 1, 1, 'C');

        $pdf->SetFont('db_helvethaica_x', 'b', 16);

        $pdf->Cell(50, 12,  "  วันที่ ", 1, 0, 'C');
        $pdf->Cell(150, 12,  $_date, 1, 1, 'L');

        $pdf->Cell(50, 12,  "  รอบ", 1, 0, 'C');
        $pdf->Cell(150, 12,  $_Round, 1, 1, 'L');


        $pdf->Cell(50, 12,  "  รายงาน SUDs", 0, 1, 'L');
        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                    <thead><tr style="font-size:18px;line-height:35px;">
                    <th width="10 %" align="center">ลำดับ</th>
                    <th width="30 %" align="center">รายการ</th>
                    <th width="20 %"  align="center">ส่ง CSSD</th>
                    <th width="20 %" align="center">ส่ง OR</th>
                    <th width="20 %" align="center">Remark</th>
                    </tr> </thead>';



        $count = 1;
        $querySend = "SELECT
            item.itemname ,
            COUNT(itemstock.ItemCode) AS Qty,
            sendsteriledetail.Remark
        FROM
            sendsterile 
        INNER JOIN sendsteriledetail ON sendsteriledetail.SendSterileDocNo = sendsterile.DocNo
        INNER JOIN itemstock ON itemstock.UsageCode = sendsteriledetail.UsageCode
        INNER JOIN item ON item.itemcode = itemstock.ItemCode
        WHERE
            sendsterile.Round = $_Round
            AND CONVERT ( DATE, sendsterile.DocDate ) = '$_date' 
            AND sendsterile.hncode IS NOT NULL
            GROUP BY item.itemname , sendsteriledetail.Remark   ";


    $meQuerySend = $conn->prepare($querySend);
    $meQuerySend->execute();
    while ($ResultSend = $meQuerySend->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('db_helvethaica_x', 'B', 18);

        $html .= '<tr nobr="true" style="font-size:17px;line-height:30px;">';
        $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
        $html .=   '<td width="30 %" align="left"> ' . $ResultSend['itemname'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Qty'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Qty'] . '</td>';
        $html .=   '<td width="20 %" align="center">' . $ResultSend['Remark'] . '</td>';
        $html .=  '</tr>';
        $count++;
    }

$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');
    }


}

// $query = " SELECT
// deproom.DocNo,
// FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate,
// FORMAT(deproom.serviceDate , 'HH:mm') AS serviceTime,
// deproom.hn_record_id,
// doctor.Doctor_Name,
// [procedure].Procedure_TH,
// departmentroom.departmentroomname ,
// doctor.ID AS doctor_ID,
// [procedure].ID AS procedure_ID,
// departmentroom.id AS deproom_ID,
// deproom.Remark
// FROM
// deproom
// INNER JOIN doctor ON doctor.ID = deproom.doctor
// INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID
// INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
// WHERE
// deproom.DocNo = '$DocNo' ";
// $meQuery = $conn->prepare($query);
// $meQuery->execute();
// while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
//     $_hn_record_id = $row['hn_record_id'];
//     $_serviceDate = $row['serviceDate'];
//     $_Doctor_Name = $row['Doctor_Name'];
//     $_departmentroomname = $row['departmentroomname'];
//     $_Remark = $row['Remark'];
//     $_Procedure_TH = $row['Procedure_TH'];
// }


// $pdf->Ln(10);

// $pdf->SetFont('db_helvethaica_x', 'b', 16);

// $pdf->Cell(200, 12,  "  รายงานส่งแลกเครื่องมือ ระหว่าง OR และ CSSD ", 1, 1, 'C');

// $pdf->SetFont('db_helvethaica_x', 'b', 14);

// $pdf->Cell(50, 12,  "  วันที่", 1, 0, 'C');
// $pdf->Cell(150, 12,  $_hn_record_id, 1, 1, 'L');

// $pdf->Cell(50, 12,  "  รอบ", 1, 0, 'C');
// $pdf->Cell(150, 12,  $_serviceDate, 1, 1, 'L');

// $pdf->Ln(5);

// $html = '<table cellspacing="0" cellpadding="2" border="1" >
//     <thead><tr style="font-size:18px;">
//     <th width="10 %" align="center">ลำดับ</th>
//     <th width="50 %" align="center">รายการ</th>
//     <th width="20 %"  align="center">ประเภท</th>
//     <th width="20 %" align="center">จำนวน</th>
//     </tr> </thead>';



// $count = 1;
// $query = "SELECT
//                 item.itemname ,
//                 item.itemcode ,
//                 deproomdetail.ID ,
//                 SUM ( deproomdetail.IsQtyStart ) AS cnt ,
//                 itemtype.TyeName
//                 FROM
//                 deproom
//                 INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
//                 INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
//                 INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
//                 WHERE
//                 deproom.DocNo = '$DocNo' 
//                 AND deproom.IsCancel = 0 
//                 AND deproomdetail.IsCancel = 0 
//                 AND deproomdetail.IsStart = 1
//                 GROUP BY
//                 item.itemname,
//                 item.itemcode,
//                 deproomdetail.ID ,
//                 itemtype.TyeName
//                 ORDER BY item.itemname ASC ";


// $meQuery1 = $conn->prepare($query);
// $meQuery1->execute();
// while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

//     $pdf->SetFont('db_helvethaica_x', 'B', 18);

//     $html .= '<tr nobr="true" style="font-size:15px;">';
//     $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
//     $html .=   '<td width="50 %" align="left"> ' . $Result_Detail['itemname'] . '</td>';
//     $html .=   '<td width="20 %" align="center">' . $Result_Detail['TyeName'] . '</td>';
//     $html .=   '<td width="20 %" align="center">' . $Result_Detail['cnt'] . '</td>';
//     $html .=  '</tr>';
//     $count++;
// }










// $html .= '</table>';
// $pdf->writeHTML($html, true, false, false, false, '');







// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_costSterile_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
