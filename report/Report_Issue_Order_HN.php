<?php
require('../config/db.php');
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
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);
            // Title

        $DocNo = $_GET['DocNo'];
        $this->Cell(0, 5,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 0, 'R');

        $image_file = "images/logo.png";
        $this->Image($image_file, 10, 5, 15, 8, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        if($db == 1){
            $query = "SELECT
                        deproom.DocNo,
                        DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
                        DATE_FORMAT(deproom.serviceDate, '%H:%i') AS serviceTime,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        `procedure`.Procedure_TH,
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark
                    FROM
                        deproom
                    INNER JOIN
                        doctor ON doctor.ID = deproom.doctor
                    INNER JOIN
                        `procedure` ON deproom.`procedure` = `procedure`.ID
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    WHERE
                        deproom.DocNo = '$DocNo' ";
        }else{
            $query = " SELECT
            deproom.DocNo,
            FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate,
            FORMAT(deproom.serviceDate , 'HH:mm') AS serviceTime,
            deproom.hn_record_id,
            doctor.Doctor_Name,
            [procedure].Procedure_TH,
            departmentroom.departmentroomname ,
            doctor.ID AS doctor_ID,
            [procedure].ID AS procedure_ID,
            departmentroom.id AS deproom_ID,
            deproom.Remark
            FROM
            deproom
            INNER JOIN doctor ON doctor.ID = deproom.doctor
            INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID
            INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
            WHERE
            deproom.DocNo = '$DocNo' ";
        }

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_hn_record_id = $row['hn_record_id'];
            $_serviceDate = $row['serviceDate'];
            $_Doctor_Name = $row['Doctor_Name'];
            $_departmentroomname = $row['departmentroomname'];
            $_Remark = $row['Remark'];
            $_Procedure_TH = $row['Procedure_TH'];
        }

        $this->Ln(9);


        $this->SetFont('db_helvethaica_x', 'b', 14);

        $this->Cell(200, 8, 'รายงานการจ่ายอุปกรณ์กับคนไข้', 1, 1, 'C');


        $this->Cell(50, 11,  "  HN Code", 1, 0, 'L');
        $this->Cell(150, 11, ' ' . $_hn_record_id, 1, 1, 'L');

        $this->Cell(50, 11,  "  วันที่เข้ารับบริการ", 1, 0, 'L');
        $this->Cell(150, 11, ' ' . $_serviceDate, 1, 1, 'L');

        $this->Cell(50, 11,  "  แพทย์", 1, 0, 'L');
        $this->Cell(150, 11, ' ' . $_Doctor_Name, 1, 1, 'L');


        $this->Cell(50, 11,  "  ห้องผ่าตัด", 1, 0, 'L');
        $this->Cell(150, 11, ' ' . $_departmentroomname, 1, 1, 'L');

        $this->Cell(50, 11,  "  หมายเหตุ", 1, 0, 'L');
        $this->Cell(150, 11, ' ' . $_Remark, 1, 1, 'L');


        $this->Ln(2);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('db_helvethaica_x', 'b', 12);
        $this->MultiCell(200, 11,  "     หัตถการ : " . $_Procedure_TH, 1, 1, 'C');
        // 
        $this->Ln(2);


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
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number

        require('../connect/connect.php');
        $DocNo = $_GET['DocNo'];
        $_name1 = "";
        $_name2 = "";
        $_serviceDate = "";

        if($db == 1){
            $query = "SELECT
                        CONCAT(employee1.FirstName, ' ', employee1.LastName) AS name_1,
                        CONCAT(employee2.FirstName, ' ', employee2.LastName) AS name_2,
                        DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS serviceDate
                    FROM
                        deproom
                    INNER JOIN
                        users AS user1 ON deproom.UserCode = user1.ID
                    INNER JOIN
                        users AS user2 ON deproom.UserPay = user2.ID
                    INNER JOIN
                        employee AS employee1 ON user1.EmpCode = employee1.EmpCode
                    INNER JOIN
                        employee AS employee2 ON user2.EmpCode = employee2.EmpCode
                    WHERE
                        deproom.DocNo = '$DocNo' ";
        }else{
            $query = " SELECT
            CONCAT(employee1.FirstName,' ',employee1.LastName ) AS name_1 ,
            CONCAT(employee2.FirstName,' ',employee2.LastName ) AS name_2 ,
            FORMAT(deproom.serviceDate , 'dd/MM/yyyy') AS serviceDate
        FROM
            deproom
            INNER JOIN users AS user1 ON deproom.UserCode = user1.ID
            INNER JOIN users AS user2 ON deproom.UserPay = user2.ID
            INNER JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
            INNER JOIN employee AS employee2 ON user2.EmpCode = employee2.EmpCode
            WHERE
            deproom.DocNo = '$DocNo' ";
        }

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_name1 = $row['name_1'];
            $_name2 = $row['name_2'];
            $_serviceDate = $row['serviceDate'];
        }

        if ($this->last_page_flag) {

            $this->SetX(40);
            $this->Cell(22, 10,   ' ผู้สร้างใบขอเบิก : ' . "", 0, 0, 'L');
            $this->Cell(80, 10,  "$_name1", 0, 0, 'L');


            $this->Cell(15, 10,   'วันและเวลา : ' . "", 0, 0, 'L');
            $this->Cell(20, 9,  $_serviceDate, 0, 1, 'L');

            $this->SetX(40);

            $this->Cell(27, 10,   ' ผู้สแกนจ่ายอุปกรณ์ : ' . "", 0, 0, 'L');
            $this->Cell(75, 10,  "$_name2", 0, 0, 'L');


            $this->Cell(15, 10,   'วันและเวลา : ' . "", 0, 0, 'L');
            $this->Cell(20, 9,  $_serviceDate, 0, 0, 'L');

            // $this->Cell(1, 9,  "                                                           DR. SAKDITOUCH NUNNARK", 0, 0, 'L');
            // $this->Cell(130, 10,   '                      ผู้สแกนจ่ายอุปกรณ์ : ' . "", 0, 0, 'L');


            // $this->Cell(1, 9,  "                           15/02/2025", 0, 0, 'L');
            // $this->Cell(10, 10,   'วันและเวลา : ' . "", 0, 0, 'L');




            // $this->Cell(1, 9,  "         " . $Facdate . "  เวลา   " . $FacTime, 0, 0, 'L');
            // $this->Cell(90, 10,   'วันที่' . "", 0, 0, 'L');

        } else {
            $this->Cell(200, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
        }
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Issue_Order_HN');
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
$pdf->SetMargins(5, 92, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 25);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetFont('db_helvethaica_x', 'B', 18);

$DocNo = $_GET['DocNo'];



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:16px;line-height:35px;">
<th width="10 %" align="center">ลำดับ</th>
<th width="30 %" align="center">รายการ</th>
<th width="15 %"  align="center">ประเภท</th>
<th width="15 %" align="center">จำนวนขอเบิก</th>
<th width="15 %" align="center">จำนวนจ่าย</th>
<th width="15 %" align="center">ค้างจ่าย</th>
</tr> </thead>';


$count = 1;

if($db == 1){
    $query = "SELECT
                    item.itemname,
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
                    deproom.DocNo = '$DocNo'
                    AND deproom.IsCancel = 0
                    AND deproomdetail.IsCancel = 0
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    deproomdetail.ID,
                    itemtype.TyeName
                ORDER BY
                    item.itemname ASC  ";
}else{
    $query = "SELECT
    item.itemname ,
    item.itemcode ,
    deproomdetail.ID ,
    SUM ( deproomdetail.Qty ) AS cnt ,
    (
                        SELECT COUNT(deproomdetailsub.ID) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
    ) AS cnt_pay,
    itemtype.TyeName
    FROM
    deproom
    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
    WHERE
    deproom.DocNo = '$DocNo' 
    AND deproom.IsCancel = 0 
    AND deproomdetail.IsCancel = 0 
    GROUP BY
    item.itemname,
    item.itemcode,
    deproomdetail.ID ,
    itemtype.TyeName 
    ORDER BY item.itemname ASC ";
}


$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $balance =  $Result_Detail['cnt'] - $Result_Detail['cnt_pay'];

    if ($balance < 0) {
        // balance = 0;
        $balance = $Result_Detail['cnt_pay'] - $Result_Detail['cnt'];

        $balance = "+" . $balance;
    }

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .=   '<tr nobr="true" style="font-size:16px;line-height:35px;">';
    $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
    $html .=   '<td width="30 %" align="left"> ' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['TyeName'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['cnt'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $Result_Detail['cnt_pay'] . '</td>';
    $html .=   '<td width="15 %" align="center">' . $balance . '</td>';
    $html .=  '</tr>';
    $count++;
}










$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');







// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_costSterile_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
