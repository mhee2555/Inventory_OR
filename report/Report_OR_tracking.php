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
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('db_helvethaica_x', '', 10);
        $this->Cell(0, 5, 'Create by: Operating Room Inventory', 0, 1, 'L');
        $this->Cell(0, 5, 'Date: ' . date('d/m/Y'), 0, 1, 'L');
    }
}

$pdf = new InventoryTrackingPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Inventory System');
$pdf->SetAuthor('Operating Room');
$pdf->SetTitle('Inventory Tracking');
$pdf->SetMargins(8, 5, 8);
$pdf->SetAutoPageBreak(TRUE, 15);

$select_date1_9 = $_GET['date1'];
$select_date1_9 = explode("-", $select_date1_9);
$select_date1_9 = $select_date1_9[2] . '-' . $select_date1_9[1] . '-' . $select_date1_9[0];

$queryCC = "SELECT hncode.DocNo 
    FROM hncode
    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
    LEFT JOIN his ON his.DocNo = hncode.DocNo
    LEFT JOIN doctor ON doctor.ID = hncode.doctor
    LEFT JOIN `procedure` ON `procedure`.ID = hncode.`procedure`
    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
    LEFT JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID 
    WHERE DATE(hncode.CreateDate) = '$select_date1_9' 
    AND hncode.IsStatus = 1 AND hncode.IsCancel = 0 AND hncode.IsBlock = 0 
    GROUP BY hncode.DocNo 
    ORDER BY hncode.CreateDate ASC";

$meQueryCC = $conn->prepare($queryCC);
$meQueryCC->execute();

while ($Result_CC = $meQueryCC->fetch(PDO::FETCH_ASSOC)) {

    $DocNo = $Result_CC['DocNo'];
    $pdf->AddPage();

    $query = "SELECT 
        hncode.HnCode,
        hncode.number_box,
        DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS date1,
        DATE_FORMAT(deproom.serviceDate, '%H:%i') AS time1,
        hncode.`procedure`,
        departmentroom.departmentroomname_EN,
        ( SELECT GROUP_CONCAT( `doctor`.Doctor_Name SEPARATOR ' , ' ) AS Doctor_Name FROM `doctor` WHERE FIND_IN_SET( `doctor`.ID, deproom.`doctor` ) ) AS Doctor_Name,
        ( SELECT GROUP_CONCAT( `procedure`.Procedure_TH SEPARATOR ' , ' ) AS Procedures FROM `procedure` WHERE FIND_IN_SET( `procedure`.ID, deproom.`procedure` ) ) AS Procedure_TH,
        deproom.Remark
        FROM hncode
        LEFT JOIN `procedure` ON hncode.`procedure` = `procedure`.ID
        LEFT JOIN doctor ON hncode.doctor = doctor.ID
        INNER JOIN departmentroom ON hncode.departmentroomid = departmentroom.id
        INNER JOIN deproom ON deproom.DocNo = hncode.DocNo_SS
        WHERE hncode.DocNo = '$DocNo'";

    $meQuery1 = $conn->prepare($query);
    $meQuery1->execute();
    while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        $number_box = $Result_Detail['number_box'];
        $HnCode = $Result_Detail['HnCode'] ?: $number_box;
        $_Remark = $Result_Detail['Remark'];
        $date1 = $Result_Detail['date1'];
        $time1 = $Result_Detail['time1'];
        $procedure = $Result_Detail['procedure'];
        $Doctor_Name = $Result_Detail['Doctor_Name'];
        $departmentroomname_EN = $Result_Detail['departmentroomname_EN'];
        $_Procedure_TH = $Result_Detail['Procedure_TH'];
    }



    // Top Boxes
    $pdf->SetX(5);
    $pdf->Cell(50, 35, "", 1, 0, 'L');
    $pdf->Cell(115, 35, "", 1, 0, 'L');
    $pdf->Cell(35, 35, "", 1, 0, 'L');

    $pdf->SetY(30);
    $pdf->SetX(7);
    $pdf->SetFont('db_helvethaica_x', 'B', 10);
    $pdf->Cell(46, 8, "Operating Room Inventory Tracking", 1, 1, 'C');

    $pdf->SetFont('db_helvethaica_x', 'B', 12);
    $pdf->SetY(13);
    $pdf->SetX(57); $pdf->Cell(50, 0, "Name : - ", 0, 0, 'L');
    $pdf->SetX(110); $pdf->Cell(50, 0, "Nationality : - ", 0, 1, 'L');
    $pdf->SetX(57); $pdf->Cell(50, 0, "HN : " . $HnCode, 0, 0, 'L');
    $pdf->SetX(110); $pdf->Cell(50, 0, "Physician : " . $Doctor_Name, 0, 1, 'L');
    $pdf->SetX(57); $pdf->Cell(50, 0, "Visit Date : " . $date1, 0, 0, 'L');
    $pdf->SetX(110); $pdf->Cell(50, 0, "Department : OR (ตึกศรีพัฒน์)", 0, 1, 'L');
    $pdf->SetX(57); $pdf->Cell(50, 0, "Visit Time : " . $time1, 0, 0, 'L');

    $image_file = "images/logo1.png";
    $pdf->Image($image_file, 23, 8, 13, 20, 'PNG');

    $pdf->SetY(10);
    $pdf->SetX(178);
    $pdf->Cell(80, 0, " QR Code HN ", 0, 0, 'L');

    $file = "images/LOGO_bkx.png";
    QRcode::png($HnCode, $file, 'H', 10, 4);
    $pdf->Image($file, 175, 14, 25, 25, 'PNG');

    $pdf->SetFont('db_helvethaica_x', 'B', 10);
    $pdf->SetY(40);
    $pdf->SetX(5);
    $pdf->Cell(200, 7, "", 1, 0, 'L');

    $pdf->SetY(41);
    $pdf->SetX(25);
    $pdf->Cell(0, 0, $_Procedure_TH, 0, 0, 'L');
    $pdf->SetFont('db_helvethaica_x', 'B', 15);
    $pdf->SetY(40);
    $pdf->SetX(6);
    $pdf->Cell(50, 0, "Procedure___________________________________________________________________________________________________", 0, 1, 'L');

    // ตารางล่างแบบเต็มหน้า
    $pdf->SetFont('db_helvethaica_x', '', 12);
    $tableTopY = 50;
    $tableBottomY = 285;
    $tableHeight = $tableBottomY - $tableTopY;

    $tableWidth = 200;
    $colCount = 4;
    $rowHeight = 25;
    $rowCount = floor($tableHeight / $rowHeight);
    $colWidth = $tableWidth / $colCount;

    for ($row = 0; $row < $rowCount; $row++) {
        for ($col = 0; $col < $colCount; $col++) {
            $x = 5 + ($col * $colWidth);
            $y = $tableTopY + ($row * $rowHeight);
            $pdf->SetXY($x, $y);
            $pdf->Cell($colWidth, $rowHeight, '', 1, 0, 'C');
        }
    }
}

$ddate = date('d_m_Y');
$pdf->Output('inventory_tracking' . $ddate . '.pdf', 'I');
