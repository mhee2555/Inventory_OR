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


        
        // $image_file = "images/logo.png";
        // $this->Image($image_file, 10, 5, 15, 8, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $DocNo = $_GET['DocNo'];

            // Set font
            $this->SetFont('db_helvethaica_x', '', 12);

            // Title
            $this->Cell(0, 1,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 0, 'R');

            if($db == 1){
                $query = " SELECT
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
                            LEFT JOIN
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

       
                
                // if (strlen($_Remark) > 45) {
                //     $_Remark = substr($_Remark, 0, 45) . '...';
                //   }
            }
    
    
            $this->Ln(9);
    
    
            $this->SetFont('db_helvethaica_x', 'b', 14);

            $this->SetY(10);
            $this->Cell(138, 5, 'รายงานขอเบิกใช้อุปกรณ์กับคนไข้', 1, 1, 'C');


            $this->Cell(30, 30,  "", 1, 0, 'L');
            $this->Cell(83, 30,  "", 1, 0, 'L');
            $this->Cell(25, 30,  "", 1, 0, 'L');
            



            $this->SetFont('db_helvethaica_x', 'B', 10);
            $this->SetY(18);
            $this->SetX(38);
            $this->Cell(50, 5,  "HN Code : ". $_hn_record_id, 0, 1, 'L');
            $this->SetX(38);
            $this->Cell(50, 5,  "วันที่เข้ารับบริการ : ". $_serviceDate, 0, 1, 'L');
            $this->SetX(38);
            $this->Cell(50, 5,  "แพทย์ : ". $_Doctor_Name, 0, 1, 'L');
            $this->SetX(38);
            $this->Cell(50, 5,  "ห้องผ่าตัด : ". $_departmentroomname, 0, 1, 'L');
            $this->SetX(38);
            $this->Cell(50, 5,  "หมายเหตุ : ". $_Remark, 0, 1, 'L');


            $this->SetY(17);
            $this->SetX(123);
            $this->Cell(80, 0,  " QR Code HN ", 0, 0, 'L');

            $file = "images/LOGO_bkx.png";
            $ecc = 'H';
            $pixel_size = 10;
            $frame_size = 4;
            QRcode::png($_hn_record_id, $file, $ecc, $pixel_size, $frame_size);
            $this->Image($file, 120, 22, 20, 20, 'PNG');


            $image_file = "images/logo1.png";
            $this->Image($image_file, 10, 25, 20, 18, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


            // $this->Cell(138, 8, 'รายงานขอเบิกใช้อุปกรณ์กับคนไข้', 1, 1, 'C');
    
            // $this->Cell(30, 11,  "  HN Code", 1, 0, 'L');
            // $this->Cell(108, 11, "     ".$_hn_record_id, 1, 1, 'L');
    
            // $this->Cell(30, 11,  "  วันที่เข้ารับบริการ", 1, 0, 'L');
            // $this->Cell(108, 11,  "    ".$_serviceDate, 1, 1, 'L');
    
            // $this->Cell(30, 11,  "  แพทย์", 1, 0, 'L');
            // $this->Cell(108, 11,  "    ".$_Doctor_Name, 1, 1, 'L');
    
    
            // $this->Cell(30, 11,  "  ห้องผ่าตัด", 1, 0, 'L');
            // $this->Cell(108, 11,  "    ".$_departmentroomname, 1, 1, 'L');
    
            // $this->Cell(30, 11,  "  หมายเหตุ", 1, 0, 'L');
            // $this->Cell(108, 11, "    ".$_Remark, 1, 1, 'L');
    
            $this->Ln(23);
            $this->SetFillColor(255, 255, 255);
            $this->SetFont('db_helvethaica_x', 'b', 12);
            $this->MultiCell(138, 9,  "    หัตถการ : " . $_Procedure_TH, 1, 1, 'L');
            
            $this->Ln(1);


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
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number
        require('../config/db.php');
        require('../connect/connect.php');
        $DocNo = $_GET['DocNo'];


        if($db == 1){
            $query = "SELECT
                            CONCAT(employee.FirstName, ' ', employee.LastName) AS name,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate
                        FROM
                            deproom
                        INNER JOIN
                            users ON deproom.UserCode = users.ID
                        INNER JOIN
                            employee ON users.EmpCode = employee.EmpCode
                        WHERE
                            deproom.DocNo = '$DocNo' ";
        }else{
            $query = " SELECT
                            CONCAT(employee.FirstName,' ',employee.LastName ) AS name ,
                            FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate
                        FROM
                            deproom
                            INNER JOIN users ON deproom.UserCode = users.ID
                            INNER JOIN employee ON users.EmpCode = employee.EmpCode
                            WHERE
                            deproom.DocNo = '$DocNo' ";
        }


        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_name = $row['name'];
            $_serviceDate = $row['serviceDate'];
        }
 
        if ($this->last_page_flag) {
            $this->SetY(-15);

            $this->SetX(10);
            $this->Cell(20, 1,   ' ผู้สร้างใบขอเบิก : ' . "", 0, 0, 'L');
            $this->Cell(1, 2,  "  $_name", 0, 0, 'L');
    
            $this->SetX(90);
    
            $this->Cell(20, 1,   'วันและเวลา : ' . "", 0, 0, 'R');
            $this->Cell(15, 2,  "$_serviceDate", 0, 0, 'R');
            // $this->Cell(1, 9,  "         " . $Facdate . "  เวลา   " . $FacTime, 0, 0, 'L');
            // $this->Cell(90, 10,   'วันที่' . "", 0, 0, 'L');

        }else{
            
            // $this->SetX(10);
            // $this->Cell(20, 1,   ' ผู้สร้างใบขอเบิก : ' . "", 0, 0, 'L');
            // $this->Cell(1, 2,  "  $_name", 0, 0, 'L');
    
            // $this->SetX(90);
    
            // $this->Cell(20, 1,   'วันและเวลา : ' . "", 0, 0, 'R');
            // $this->Cell(15, 2,  "$_serviceDate", 0, 0, 'R');

            $this->Cell(270, 1,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
        }


    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Create_Order_HN');
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
$pdf->SetMargins(5,58, 5);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 20);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page
// $pdf->SetCellHeightRatio(1);  // Uniform line height
// $pdf->SetCellPadding(2); 
$pdf->AddPage('P', 'A5');
$pdf->SetFont('db_helvethaica_x', 'B', 18);
$DocNo = $_GET['DocNo'];
// $pdf->Ln(85);


$html = '    
    <table cellspacing="0" cellpadding="2" border="1" >
    <thead><tr style="font-size:16px;line-height:35px;">
    <th width="10 %" align="center">ลำดับ</th>
    <th width="50 %" align="center">รายการ</th>
    <th width="20 %"  align="center">ประเภท</th>
    <th width="20 %" align="center">จำนวน</th></thead>
    </tr>';



$count = 1;
$query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM(deproomdetail.IsQtyStart) AS cnt ,
                itemtype.TyeName
                FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                deproom.DocNo = '$DocNo' 
                AND deproom.IsCancel = 0 
                AND deproomdetail.IsCancel = 0 
                -- AND deproomdetail.IsStart = 1
                GROUP BY
                item.itemname,
                item.itemcode,
                deproomdetail.ID ,
                itemtype.TyeName
                ORDER BY item.itemname ASC ";


$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

    $html .= '<tr nobr="true" style="font-size:14px;line-height:30px;">';
    $html .=   '<td width="10 %" align="center"> ' . $count . '</td>';
    $html .=   '<td width="50 %" align="left"> ' . "      " . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="20 %" align="center">' . $Result_Detail['TyeName'] . '</td>';
    $html .=   '<td width="20 %" align="center">' . $Result_Detail['cnt'] . '</td>';
    $html .=  '</tr>';
    $count++;

}










$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');







// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Create_Order_HN' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
