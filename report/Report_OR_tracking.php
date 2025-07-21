<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

class InventoryTrackingPDF extends TCPDF
{
    public function Header()
    {
        // // ตั้งค่าฟอนต์
        // $this->SetFont('thsarabun', '', 12);

        // // โลโก้ (สร้างจากข้อความ)
        // $this->SetFont('thsarabun', 'B', 16);
        // $this->SetTextColor(128, 0, 128); // สีม่วง
        // $this->Cell(0, 10, 'S', 0, 1, 'L');
        // $this->SetTextColor(0, 128, 0); // สีเขียว
        // $this->Cell(0, 5, 'S', 0, 1, 'L');

        // // ชื่อโรงพยาบาล
        // $this->SetTextColor(0, 0, 0);
        // $this->SetFont('thsarabun', '', 14);
        // $this->Cell(0, 8, 'ศูนย์ศรีพัฒน์', 0, 1, 'L');

        // // หัวข้อหลัก
        // $this->SetFont('thsarabun', 'B', 16);
        // $this->Cell(0, 10, 'Operating Room Inventory Tracking', 0, 1, 'L');

        // // Operation/Procedure
        // $this->SetFont('thsarabun', '', 12);
        // $this->Cell(0, 8, 'Operation / Procedure: _________________', 0, 1, 'L');

        // // เส้นแบ่ง
        // $this->Line(10, $this->GetY() + 5, 200, $this->GetY() + 5);
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('db_helvethaica_x', '', 10);
        $this->Cell(0, 5, 'Create by: Operating Room Inventory', 0, 1, 'L');
        $this->Cell(0, 5, 'Date: ' . date('d/m/Y'), 0, 1, 'L');
    }
}

// สร้าง PDF
$pdf = new InventoryTrackingPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// ตั้งค่า
$pdf->SetCreator('Inventory System');
$pdf->SetAuthor('Operating Room');
$pdf->SetTitle('Inventory Tracking');

// เพิ่มหน้า

$select_date1_9 = $_GET['date1'];
$select_date1_9 = explode("-", $select_date1_9);
$select_date1_9 = $select_date1_9[2] . '-' . $select_date1_9[1] . '-' . $select_date1_9[0];

$queryCC = " SELECT
                    hncode.DocNo 
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    LEFT JOIN his ON his.DocNo = hncode.DocNo
                    LEFT JOIN doctor ON doctor.ID = hncode.doctor
                    LEFT JOIN `procedure` ON `procedure`.ID = hncode.`procedure`
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    LEFT JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID 
                WHERE
                    DATE( hncode.CreateDate ) = '$select_date1_9' 
                    AND hncode.IsStatus = 1 
                    AND hncode.IsCancel = 0 
                    AND hncode.IsBlock = 0 
                GROUP BY
                    hncode.DocNo 
                ORDER BY
                     hncode.CreateDate ASC  ";



$meQueryCC = $conn->prepare($queryCC);
$meQueryCC->execute();

while ($Result_CC = $meQueryCC->fetch(PDO::FETCH_ASSOC)) {

    $DocNo =   $Result_CC['DocNo'];

    $pdf->AddPage();

    $query = " SELECT 
                    hncode.HnCode,
                    hncode.number_box,
                    DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS date1,
                    DATE_FORMAT(deproom.serviceDate, '%H:%i') AS time1,
                    hncode.`procedure`,
                    doctor.Doctor_Name_EN AS Doctor_Name,
                    departmentroom.departmentroomname_EN ,
                    deproom.Remark
                FROM 
                    hncode
                    LEFT JOIN `procedure` ON hncode.`procedure` = `procedure`.ID
                    LEFT JOIN doctor ON hncode.doctor = doctor.ID
                    INNER JOIN departmentroom ON hncode.departmentroomid = departmentroom.id
                    INNER JOIN deproom ON deproom.DocNo = hncode.DocNo_SS
               	WHERE hncode.DocNo = '$DocNo' ";


    $meQuery1 = $conn->prepare($query);
    $meQuery1->execute();
    while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

        $number_box =   $Result_Detail['number_box'];
        $HnCode =   $Result_Detail['HnCode'];

        if ($HnCode == "") {
            $HnCode = $number_box;
        }
        $_Remark =   $Result_Detail['Remark'];
        $date1 =     $Result_Detail['date1'];
        $time1 =     $Result_Detail['time1'];
        $procedure =     $Result_Detail['procedure'];
        $Doctor_Name =     $Result_Detail['Doctor_Name'];
        $departmentroomname_EN =     $Result_Detail['departmentroomname_EN'];
    }


    $_Procedure_TH = "";
    $query_P = "SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $procedure )  ";
    $meQuery_P = $conn->prepare($query_P);
    $meQuery_P->execute();
    while ($row_P = $meQuery_P->fetch(PDO::FETCH_ASSOC)) {
        $_Procedure_TH .= $row_P['procedure_ids'];
    }



    $pdf->SetX(5);
    $pdf->Cell(50, 35,  "", 1, 0, 'L');
    $pdf->Cell(115, 35,  "", 1, 0, 'L');
    $pdf->Cell(35, 35,  "", 1, 0, 'L');

    $pdf->SetY(36);
    $pdf->SetX(7);
    $pdf->SetFont('db_helvethaica_x', 'B', 10);
    $pdf->Cell(46, 8,  "Operating Room Inventory Tracking", 1, 1, 'C');

    $pdf->SetFont('db_helvethaica_x', 'B', 12);
    $pdf->SetY(13);
    $pdf->SetX(57);
    $pdf->Cell(50, 0,  "Name : - ", 0, 0, 'L');
    $pdf->SetX(110);
    $pdf->Cell(50, 0,  "Nationality : - ", 0, 1, 'L');
    $pdf->SetX(57);
    $pdf->Cell(50, 0,  "HN : " . $HnCode, 0, 0, 'L');
    $pdf->SetX(110);
    $pdf->Cell(50, 0,  "Physicial : " . $Doctor_Name, 0, 1, 'L');
    $pdf->SetX(57);
    $pdf->Cell(50, 0,  "Visit Date : " . $date1, 0, 0, 'L');
    $pdf->SetX(110);
    $pdf->Cell(50, 0,  "Department : OR (ตึกศรีพัฒน์)", 0, 1, 'L');
    $pdf->SetX(57);
    $pdf->Cell(50, 0,  "Visit Time : " . $time1, 0, 0, 'L');


    $image_file = "images/logo1.png";
    $pdf->Image($image_file, 23, 13, 13, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    $pdf->SetY(14);
    $pdf->SetX(178);
    $pdf->Cell(80, 0,  " QR Code HN ", 0, 0, 'L');

    $style = array(
        'border' => false,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    // // write RAW 2D Barcode
    // $this->write2DBarcode($HnCode, 'QRCODE,L', 170, 20, 80, 30, $style, 'N');

    $file = "images/LOGO_bkx.png";

    // 1️⃣ สร้าง QR Code และบันทึกในไฟล์ชั่วคราว
    $ecc = 'H';  // Error correction level (H=High)
    $pixel_size = 10;  // ขนาดของพิกเซล
    $frame_size = 4;  // ขนาดกรอบ
    QRcode::png($HnCode, $file, $ecc, $pixel_size, $frame_size);
    $pdf->Image($file, 175, 18, 25, 25, 'PNG');

    $pdf->SetFont('db_helvethaica_x', 'B', 10);

    $pdf->SetY(45);
    $pdf->SetX(5);
    $pdf->Cell(200, 7,  "", 1, 0, 'L');


    $pdf->SetY(46);
    $pdf->SetX(25);
    $pdf->Cell(0, 0,  $_Procedure_TH, 0, 0, 'L');
    $pdf->SetFont('db_helvethaica_x', 'B', 15);

    $pdf->SetY(45);
    $pdf->SetX(6);
    $pdf->Cell(50, 0,  "Proceduce___________________________________________________________________________________________________", 0, 1, 'L');


    // ตั้งค่าฟอนต์
    $pdf->SetFont('db_helvethaica_x', '', 12);

    // ส่วนข้อมูลผู้ป่วย (ด้านขวา)


    $pdf->SetXY(5, 55);
    $tableWidth = 200;
    $colWidth = $tableWidth / 4; // 4 คอลัมน์
    $rowHeight = 22; // ลดความสูงลงเพื่อให้ 9 แถวพอดี

    for ($row = 0; $row < 9; $row++) { // 9 แถว
        for ($col = 0; $col < 4; $col++) { // 4 คอลัมน์
            $x = 5 + ($col * $colWidth);
            $y = 55 + ($row * $rowHeight);
            $pdf->SetXY($x, $y);
            $pdf->Cell($colWidth, $rowHeight, '', 1, 0, 'C');
        }
    }
}



// บันทึกไฟล์

//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('inventory_tracking' . $ddate . '.pdf', 'I');
