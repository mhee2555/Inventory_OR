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



        // if ($this->page == 1) {
        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');




        $this->SetFont('db_helvethaica_x', 'b', 22);
        $DocNo = $_GET['DocNo'];

        if ($db == 1) {
            $query = " SELECT 
                            hncode.HnCode,
                            hncode.number_box,
                            DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS date1,
                            DATE_FORMAT(deproom.serviceDate, '%H:%i') AS time1,
                            -- `procedure`.Procedure_EN AS Procedure_TH,
                            -- doctor.Doctor_Name_EN AS Doctor_Name,
                             ( SELECT GROUP_CONCAT( `doctor`.Doctor_Name SEPARATOR ' , ' ) AS Doctor_Name FROM `doctor` WHERE FIND_IN_SET( `doctor`.ID, deproom.`doctor` ) ) AS Doctor_Name,
                             ( SELECT GROUP_CONCAT( `procedure`.Procedure_TH SEPARATOR ' , ' ) AS Procedures FROM `procedure` WHERE FIND_IN_SET( `procedure`.ID, deproom.`procedure` ) ) AS Procedure_TH,
                            departmentroom.departmentroomname_EN ,
                            deproom.Remark
                        FROM 
                            hncode
                            LEFT JOIN `procedure` ON hncode.`procedure` = `procedure`.ID
                            LEFT JOIN doctor ON hncode.doctor = doctor.ID
                            INNER JOIN departmentroom ON hncode.departmentroomid = departmentroom.id
                            INNER JOIN deproom ON deproom.DocNo = hncode.DocNo_SS
                        WHERE 
                            hncode.DocNo = '$DocNo' ";
        } else {
            $query = " SELECT
                            hncode.HnCode,
                            FORMAT(hncode.ModifyDate , 'dd/MM/yyyy') AS date1,
                            FORMAT(hncode.ModifyDate , 'HH:mm') AS time1,
                            [procedure].Procedure_EN AS Procedure_TH,
                            doctor.Doctor_Name_EN AS Doctor_Name,
                            departmentroom.departmentroomname_EN 
                        FROM
                            dbo.hncode
                            LEFT JOIN dbo.[procedure] ON hncode.[procedure] = [procedure].ID
                            LEFT JOIN dbo.doctor ON hncode.doctor = doctor.ID
                            INNER JOIN dbo.departmentroom ON hncode.departmentroomid = departmentroom.id
                        WHERE  hncode.DocNo = '$DocNo' ";
        }

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
            $Procedure_TH =     $Result_Detail['Procedure_TH'];
            $Doctor_Name =     $Result_Detail['Doctor_Name'];
            $departmentroomname_EN =     $Result_Detail['departmentroomname_EN'];
        }

        //   $this->Cell(0, 10,  " รายงานคลัง Center จ่ายอุปกรณ์ให้ห้องตรวจ", 0, 1, 'C');


        $this->SetX(5);
        $this->Cell(50, 35,  "", 1, 0, 'L');
        $this->Cell(115, 35,  "", 1, 0, 'L');
        $this->Cell(35, 35,  "", 1, 0, 'L');


        $this->SetY(40);
        $this->SetX(7);
        $this->SetFont('db_helvethaica_x', 'B', 15);
        $this->Cell(46, 8,  "Medical Instrument Tracking", 1, 1, 'C');


        $this->SetFont('db_helvethaica_x', 'B', 10);
        $this->SetY(15);
        $this->SetX(57);
        $this->Cell(50, 0,  "Name : - ", 0, 0, 'L');
        $this->SetX(110);
        $this->Cell(50, 0,  "Nationality : - ", 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "HN : " . $HnCode, 0, 0, 'L');
        $this->SetX(110);
        $this->Cell(50, 0,  "Physician : " . $Doctor_Name, 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "Visit Date : " . $date1, 0, 0, 'L');
        $this->SetX(110);
        $this->Cell(50, 0,  "Department : OR (ตึกศรีพัฒน์)", 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "Birth Date : - ", 0, 0, 'L');
        $this->SetX(110);
        $this->Cell(25, 0,  "Age : - ", 0, 0, 'L');
        $this->Cell(30, 0,  "Sex : - ", 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "Allergies : - ", 0, 0, 'L');
        $this->SetX(110);
        $this->Cell(25, 0,  "Room : " . $departmentroomname_EN, 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "Side Effect : - ", 0, 1, 'L');
        $this->SetX(57);
        $this->Cell(50, 0,  "หมายเหตุ : " . $_Remark, 0, 1, 'L');
        //   $this->Cell(54, 8,  "Medical Instrument Tracking", 1, 1, 'C');


        $this->SetY(18);
        $this->SetX(175);
        $this->Cell(80, 0,  " QR Code HN ", 0, 0, 'L');



        // $this->Ln();
        $image_file = "images/logo.png";
        $this->Image($image_file, 10, 20, 40, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


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

        // 3️⃣ ใช้ TCPDF->Image() เพื่อนำ QR Code ที่สร้างไปแสดงใน PDF
        $this->Image($file, 175, 25, 25, 25, 'PNG');


        $this->SetFont('db_helvethaica_x', 'B', 16);
        $this->SetY(50);
        $this->SetX(5);
        $this->Cell(200, 15,  "", 1, 0, 'L');

        $this->SetX(30);
        $this->Cell(0, 0,  $Procedure_TH, 0, 0, 'L');


        $this->SetX(16);
        $this->SetY(56);
        $this->Cell(80, 0,  $date1, 0, 0, 'C');

        $this->SetX(150);
        $this->SetY(56);
        $this->Cell(170, 0,  $time1, 0, 0, 'R');


        $this->SetY(50);
        $this->SetX(6);
        $this->Cell(50, 0,  "Procedure_____________________________________________________________________________________________", 0, 1, 'L');
        $this->Cell(50, 0,  " Date___________________________________________________________Time___________________________________", 0, 0, 'L');



        $this->Ln(5);


        // }
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
$pdf->SetTitle('Report_Medical_Instrument_Tracking');
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
$pdf->SetMargins(5, 67, 5);
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

$DocNo = $_GET['DocNo'];
// $pdf->Ln(8);


$html = '<table border="1" cellpadding="4" cellspacing="0" align="center">
<tr style="font-size:13px;">
<th width="5 %" align="center" style="vertical-align: middle;">NO</th>
<th width="14 %" align="center" style="vertical-align: middle;">Usage Code</th>
<th width="11 %"  align="center" style="vertical-align: middle;">QR Code</th>
<th width="11.5 %" align="center" style="vertical-align: middle;">Type</th>
<th width="8.5 %"  align="center" style="vertical-align: middle;">Lot No</th>
<th width="8.5  %"  align="center" style="vertical-align: middle;">serial No</th>
<th width="8.5  %"  align="center" style="vertical-align: middle;">จำนวน</th>
<th width="9 %"  align="center" style="vertical-align: middle;">MFG</th>
<th width="9 %"  align="center" style="vertical-align: middle;">EXP</th>
<th width="15 %"  align="center" style="vertical-align: middle;">Item Name</th>

</tr>';

$count = 1;

if ($db == 1) {
    $Sql_Detail = "SELECT
                        hncode.ID,
                        item.itemname,
                        item.LimitUse,
                        itemtype.TyeName,
                        itemstock.UsageCode,
                        item.itemcode,
                        DATE_FORMAT(itemstock.ExpireDate, '%d-%m-%Y') AS ExpireDate,
                        DATE_FORMAT(itemstock.expDate, '%d-%m-%Y') AS expDate,
                        DATE_FORMAT(hncode.DocDate, '%d-%m-%Y') AS DocDate,
                        DATE_FORMAT(itemstock.CreateDate, '%d-%m-%Y') AS CreateDate,
                        hncode.HnCode,
                        hncode_detail.LastSterileDetailID,
                        departmentroom.departmentroomname,
                        hncode_detail.Qty,
                        item2.itemname AS itemname2,
	                    item2.itemcode AS itemcode2,
                        itemstock.serielNo,
                        itemstock.lotNo
                    FROM
                        hncode
                    LEFT JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    LEFT JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    LEFT JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                    LEFT JOIN item AS item2 ON item2.ItemCode = hncode_detail.ItemCode
                    WHERE
                        hncode.IsStatus = 1
                        AND hncode.IsCancel = 0
                        AND hncode_detail.IsStatus != 99
                        AND hncode.DocNo = '$DocNo'
                    ORDER BY
                        hncode.ID ASC ";
} else {
    $Sql_Detail = "SELECT
    hncode.ID,
    item.itemname,
    itemstock.UsageCode,
    item.itemcode,
    FORMAT ( itemstock.expDate, 'dd-MM-yyyy' ) AS expDate ,
    FORMAT ( itemstock.CreateDate, 'dd-MM-yyyy' ) AS CreateDate ,
    hncode.HnCode,
    hncode_detail.LastSterileDetailID,
    departmentroom.departmentroomname,
    itemtype.TyeName,
    item.LimitUse,
    sudslog.UsedCount,
    itemstock.lotNo,
    itemstock.serielNo
    FROM
        hncode
        INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
        INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
        INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
        INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
        LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
    WHERE
        hncode.IsStatus = 1
        AND hncode.IsCancel = 0  
        AND hncode.DocNo = '$DocNo'
    ORDER BY
        hncode.ID ASC  ";
}


$meQuery1 = $conn->prepare($Sql_Detail);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);




    // $file = "images/LOGO_bkx.png";
    if ($Result_Detail['UsageCode'] == null) {
        $usageCode = $Result_Detail['itemcode2'];
        $itemname = $Result_Detail['itemname2'];
        $file = 'images/temp_qrcode_' . $usageCode . '.png';  // สร้างชื่อไฟล์ QR Code แบบไม่ซ้ำกัน
    } else {
        $usageCode = $Result_Detail['UsageCode'];
        $itemname = $Result_Detail['itemname'];
        $file = 'images/temp_qrcode_' . $usageCode . '.png';  // สร้างชื่อไฟล์ QR Code แบบไม่ซ้ำกัน
    }



    //other parameters
    $ecc = 'H';
    $pixel_size = 10;
    $frame_size = 8;

    // Generates QR Code and Save as PNG
    QRcode::png($usageCode, $file, $ecc, $pixel_size, $frame_size);



    $html .= '<tr nobr="true" style="font-size:13px;"  >';
    $html .=   '<td width="5%"  style="vertical-align: middle;height: 50px;">' . htmlspecialchars($count) . '</td>';
    $html .=   '<td width="14%"  style="vertical-align: middle;">' . htmlspecialchars($usageCode) . '</td>';
    $html .=   '<td width="11%" align="center" style="vertical-align: middle;"> <img src="' . $file . '"  />  </td>';
    $html .=   '<td width="11.5%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['TyeName']) . '</td>';
    $html .=   '<td width="8.5%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['lotNo']) . '</td>';
    $html .=   '<td width="8.5%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['serielNo']) . '</td>';
    $html .=   '<td width="8.5%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['Qty']) . '</td>';
    $html .=   '<td width="9%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['CreateDate']) . '</td>';
    $html .=   '<td width="9%" align="center" style="vertical-align: middle;">' . htmlspecialchars($Result_Detail['ExpireDate']) . '</td>';
    $html .=   '<td width="15%" align="center" style="vertical-align: middle;">' . htmlspecialchars($itemname) . '</td>';
    $html .=  '</tr>';




    $count++;
}





$html .= '</table>';



$pdf->writeHTML($html, true, false, false, false, '');









// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
ob_end_clean();
$pdf->Output('Report_Hn_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
