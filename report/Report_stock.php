<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

error_reporting(E_ALL & ~E_WARNING);
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



        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');






        // if ($this->page == 1) {

            $image_file = "images/logo1.png";
            $this->Image($image_file, 10, 10, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






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
$pdf->SetTitle('Report_Stock');
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
$pdf->SetMargins(15, 45, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 35);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page

$pdf->AddPage('P', 'A4');



$pdf->SetY(20);


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานสต๊อกคงเหลือในคลัง RFID SmartCabinet", 0, 1, 'C');


$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(15);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="10 %" align="center">ลำดับ</th>
<th width="20 %" align="center">รหัสอุปกรณ์</th>
<th width="40 %"  align="center">อุปกรณ์</th>
<th width="15 %" align="center">จำนวนสติ๊กเกอร์</th>
<th width="15 %" align="center">นำเข้าสินค้าคงคลัง</th>
</tr> </thead>';







$count = 1;

$query = "SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,
                -- ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
                 CASE 
                    WHEN IFNULL(sub.cnt, 0) > IFNULL(sub.stock_balance, 0)
                        THEN (IFNULL(sub.cnt, 0) - IFNULL(sub.cnt_pay, 0))
                    ELSE (IFNULL(sub.stock_balance, 0) - IFNULL(sub.cnt_pay, 0))
                    END AS calculated_balance,
                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage 
            FROM
                (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND (IsStatus = 1 OR IsStatus = 9 ) ) AS cnt_pay,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
                    (
                    SELECT
                        COUNT( RowID ) 
                    FROM
                        itemstock 
                    WHERE
                        ItemCode = item.itemcode 
                        AND ( IsDamage = 0 OR IsDamage IS NULL ) 
                        AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
                    ) AS balance,
                    ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
                FROM
                    item
                    LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
                WHERE
										item.SpecialID = '0' 
                                        AND item.IsCancel = '0'
                                        AND item.item_status != 1
                                        AND item.stock_max IS NOT NULL
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance 
                ) AS sub 
            ORDER BY
            CASE
                    
                    WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
                    0 ELSE 1 
                END,
                sub.cnt DESC ,
                sub.itemname; ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    if ($Result_Detail['cnt'] < $Result_Detail['stock_balance']) {
        $Result_Detail['cnt']  = $Result_Detail['stock_balance'];
    }

    $pdf->SetFont('db_helvethaica_x', 'B', 18);


    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="10 %" align="center" >' . $count . '</td>';
    $html .=   '<td width="20 %" align="center" >' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="40 %" align="left" >' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['cnt'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['calculated_balance'] . '</td>';
    $html .=  '</tr>';
    $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


// ==================================================================================================================


$pdf->AddPage('P', 'A4');




$pdf->SetY(20);


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);

$pdf->Cell(0, 10,  "รายงานสต๊อกคงเหลือในคลัง Weighing Smart Cabinet", 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(15);


$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="10 %" align="center">ลำดับ</th>
<th width="20 %" align="center">รหัสอุปกรณ์</th>
<th width="40 %"  align="center">อุปกรณ์</th>
<th width="15 %" align="center">จำนวนสติ๊กเกอร์</th>
<th width="15 %" align="center">นำเข้าสินค้าคงคลัง</th>
</tr> </thead>';







$count = 1;

$query = "SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,

                -- ใช้ยอดนับจาก itemstock เฉพาะ departmentroomid = 35 เป็น calculated_balance
                IFNULL(sub.cnt_dept35, 0) AS calculated_balance,

                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage
            FROM
            (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,

                    -- นับ itemstock ทั้งหมด (ตาม join เดิม)
                    COUNT(itemstock.RowID) AS cnt,

                    -- ยอดเบิก (IsStatus = 1)
                    ( SELECT COUNT(ID)
                    FROM itemstock_transaction_detail
                    WHERE ItemCode = item.itemcode
                        AND IsStatus = 1
                    ) AS cnt_pay,

                    -- ยอด CSSD (IsStatus = 7)
                    ( SELECT COUNT(ID)
                    FROM itemstock_transaction_detail
                    WHERE ItemCode = item.itemcode
                        AND IsStatus = 7
                    ) AS cnt_cssd,

                    -- ยอด balance (ไม่เสียหาย, ไม่อยู่ dep room ที่ตัดออก)
                    (
                        SELECT COUNT(RowID)
                        FROM itemstock
                        WHERE ItemCode = item.itemcode
                        AND (IsDamage = 0 OR IsDamage IS NULL)
                        AND Isdeproom NOT IN (1,2,3,4,5,6,7,8,9)
                    ) AS balance,

                    -- ยอดที่เป็น damage
                    (
                        SELECT COUNT(RowID)
                        FROM itemstock
                        WHERE ItemCode = item.itemcode
                        AND (IsDamage = 1 OR IsDamage = 2)
                    ) AS damage,

                    -- ⭐ ยอดนับเฉพาะ departmentroomid = 35 ตามเงื่อนไขที่คุณให้มา
                    (
                        SELECT COUNT(*) AS cnt
                        FROM itemstock
                        WHERE itemstock.ItemCode = item.itemcode
                        AND itemstock.IsCancel = 0
                        AND itemstock.Stockin = 1
                        AND itemstock.Adjust_stock = 0
                        AND itemstock.IsDeproom = 0
                        AND itemstock.departmentroomid = 35
                    ) AS cnt_dept35

                FROM item
                LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode
                WHERE
                    item.SpecialID = '2'
                    AND item.IsCancel = '0'
                    AND item.item_status != 1
                    AND item.stock_max IS NOT NULL
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance
            ) AS sub
            ORDER BY
                CASE
                    WHEN (sub.cnt - sub.cnt_pay) < sub.stock_min THEN 0 ELSE 1
                END,
                sub.cnt DESC,
                sub.itemname; ";

// $query = "SELECT
//                 sub.itemname,
//                 sub.itemcode2,
//                 sub.stock_max,
//                 sub.stock_min,
//                 sub.stock_balance,
//                 -- ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
//                 CASE 
//                 WHEN IFNULL(sub.cnt, 0) > IFNULL(sub.stock_balance, 0)
//                     THEN (IFNULL(sub.cnt, 0) - IFNULL(sub.cnt_pay, 0))
//                 ELSE (IFNULL(sub.stock_balance, 0) - IFNULL(sub.cnt_pay, 0))
//                 END AS calculated_balance,
//                 sub.cnt,
//                 sub.cnt_pay,
//                 sub.cnt_cssd,
//                 sub.balance,
//                 sub.damage 
//             FROM
//                 (
//                 SELECT
//                     item.itemname,
//                     item.itemcode2,
//                     item.stock_max,
//                     item.stock_min,
//                     item.stock_balance,
//                     COUNT( itemstock.RowID ) AS cnt,
//                     ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,
//                     ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
//                     (
//                     SELECT
//                         COUNT( RowID ) 
//                     FROM
//                         itemstock 
//                     WHERE
//                         ItemCode = item.itemcode 
//                         AND ( IsDamage = 0 OR IsDamage IS NULL ) 
//                         AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
//                     ) AS balance,
//                     ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
//                 FROM
//                     item
//                     LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
//                 WHERE
// 										item.SpecialID = '2' 
//                                         AND item.IsCancel = '0'
//                                         AND item.item_status != 1
//                                         AND item.stock_max IS NOT NULL
                                        
                                        
//                 GROUP BY
//                     item.itemname,
//                     item.itemcode,
//                     item.stock_max,
//                     item.stock_min,
//                     item.stock_balance 
//                 ) AS sub 
//             ORDER BY
//             CASE
                    
//                     WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
//                     0 ELSE 1 
//                 END,
//                 sub.cnt DESC ,
//                 sub.itemname; ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);
    if ($Result_Detail['cnt'] < $Result_Detail['stock_balance']) {
        $Result_Detail['cnt']  = $Result_Detail['stock_balance'];
    }

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="10 %" align="center" >' . $count . '</td>';
    $html .=   '<td width="20 %" align="center" >' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="40 %" align="left" >' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['cnt'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['calculated_balance'] . '</td>';
    $html .=  '</tr>';
    $count++;
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');

// output the HTML content


// ==================================================================================================================


$pdf->AddPage('P', 'A4');




$pdf->SetY(20);


$pdf->SetFont('db_helvethaica_x', 'b', 16);

$pdf->Ln(5);
// $pdf->Ln(5);


$pdf->Cell(0, 10,  "รายงานสต๊อกคงเหลือในคลัง อุปกรณ์ทั่วไป", 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(15);


$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="10 %" align="center">ลำดับ</th>
<th width="20 %" align="center">รหัสอุปกรณ์</th>
<th width="40 %"  align="center">อุปกรณ์</th>
<th width="15 %" align="center">จำนวนสติ๊กเกอร์</th>
<th width="15 %" align="center">นำเข้าสินค้าคงคลัง</th>
</tr> </thead>';







$count = 1;

$query = "SELECT
                sub.itemname,
                sub.itemcode2,
                sub.stock_max,
                sub.stock_min,
                sub.stock_balance,
                -- ( sub.cnt - sub.cnt_pay ) AS calculated_balance,
                CASE 
                WHEN IFNULL(sub.cnt, 0) > IFNULL(sub.stock_balance, 0)
                    THEN (IFNULL(sub.cnt, 0) - IFNULL(sub.cnt_pay, 0))
                ELSE (IFNULL(sub.stock_balance, 0) - IFNULL(sub.cnt_pay, 0))
                END AS calculated_balance,
                sub.cnt,
                sub.cnt_pay,
                sub.cnt_cssd,
                sub.balance,
                sub.damage 
            FROM
                (
                SELECT
                    item.itemname,
                    item.itemcode2,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 7 ) AS cnt_cssd,
                    (
                    SELECT
                        COUNT( RowID ) 
                    FROM
                        itemstock 
                    WHERE
                        ItemCode = item.itemcode 
                        AND ( IsDamage = 0 OR IsDamage IS NULL ) 
                        AND Isdeproom NOT IN ( 1, 2, 3, 4, 5, 6, 7, 8, 9 ) 
                    ) AS balance,
                    ( SELECT COUNT( RowID ) FROM itemstock WHERE ItemCode = item.itemcode AND ( IsDamage = 1 OR IsDamage = 2 ) ) AS damage 
                FROM
                    item
                    LEFT JOIN itemstock ON itemstock.ItemCode = item.itemcode 
                WHERE
										item.SpecialID = '1' 
                                        AND item.IsCancel = '0'
                                        AND item.item_status != 1
                                        AND item.stock_max IS NOT NULL
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    item.stock_max,
                    item.stock_min,
                    item.stock_balance 
                ) AS sub 
            ORDER BY
            CASE
                    
                    WHEN ( sub.cnt - sub.cnt_pay ) < sub.stock_min THEN
                    0 ELSE 1 
                END,
                sub.cnt DESC ,
                sub.itemname; ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);
    if ($Result_Detail['cnt'] < $Result_Detail['stock_balance']) {
        $Result_Detail['cnt']  = $Result_Detail['stock_balance'];
    }

    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="10 %" align="center" >' . $count . '</td>';
    $html .=   '<td width="20 %" align="center" >' . $Result_Detail['itemcode2'] . '</td>';
    $html .=   '<td width="40 %" align="left" >' . $Result_Detail['itemname'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['cnt'] . '</td>';
    $html .=   '<td width="15 %" align="center" >' . $Result_Detail['calculated_balance'] . '</td>';
    $html .=  '</tr>';
    $count++;
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');

// output the HTML content




//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Stock_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
