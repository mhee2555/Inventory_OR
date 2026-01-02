<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

// error_reporting(E_ALL & ~E_WARNING);
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

        $select_follow_month = $_GET['select_month_ok'];
        $select_follow_year = $_GET['select_year_ok'];
        $stockid = $_GET['id_hidden_cabinet'];

        if ($stockid == 2) {
            $stockID_txt = 'RFID SmartCabinet 1';
        }
        if ($stockid == 1) {
            $stockID_txt = 'RFID SmartCabinet 2';
        }
        if ($stockid == 3) {
            $stockID_txt = 'RFID SmartCabinet 3';
        }

        if ($stockid == 8) {
            $stockID_txt = 'Weighing Smart Cabinet 1';
        }
        if ($stockid == 4) {
            $stockID_txt = 'Weighing Smart Cabinet 2';
        }
        if ($stockid == 5) {
            $stockID_txt = 'Weighing Smart Cabinet 3';
        }


        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');

        $this->SetFont('db_helvethaica_x', '', 18);
        $this->Cell(0, 25, "เดือน " . $datetime->getTHmonthFromnum($select_follow_month) . " ปี " . $select_follow_year, 0, 1, 'C');
        $this->Cell(0, 0, $stockID_txt, 0, 1, 'C');

        $this->Ln(5);



        // if ($this->page == 1) {


        $image_file = "images/logo1.png";
        $this->Image($image_file, 10, 10, 20, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);






        // }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number


        $this->Cell(300, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Follow_item');
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
$pdf->SetMargins(10, 55, 10);
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

$pdf->AddPage('L', 'A4');

$datetime = new DatetimeTH();
$select_month_ok = $_GET['select_month_ok'];
$select_year_ok = $_GET['select_year_ok'];
$stockid = $_GET['id_hidden_cabinet'];

// $date1 = explode("-", $date1);
// $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1])  . " " . date('Y');




// $pdf->SetY(20);


// $pdf->SetFont('db_helvethaica_x', 'b', 16);

// $pdf->Ln(5);


// $pdf->Cell(0, 10,  "รายงานสรุปผู้ป่วยเข้ารับบริการ", 0, 1, 'C');
// $pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);

$num = 0;

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="5 %" align="center">ลำดับ</th>
<th width="20 %" align="center">อุปกรณ์</th>';


if ($select_month_ok == '04' || $select_month_ok == '06' || $select_month_ok == '09' || $select_month_ok == '11') {
    $num = 30;
    $width = 75 / 30;
} else if ($select_month_ok == '02') {
    $num  = 28;
    $width = 75 / 28;
} else {
    $num  = 31;
    $width = 75 / 31;
}


for ($i = 0; $i < $num; $i++) {
    $html .= '<th width="' . (string)$width . '%" align="center">' . (string)$i + 1 . '</th>';
}


$html .= '</tr> </thead>';

$count = 1;
$query = " SELECT
                dir.snapshot_date,
                dir.itemcode,
                dir.itemname
            FROM
                daily_item_rfid dir
            WHERE 
                MONTH(dir.snapshot_date) = '$select_month_ok'
            AND YEAR(dir.snapshot_date)  = '$select_year_ok'
            AND dir.stockID = '$stockid'
            GROUP BY dir.itemcode  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($row = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $_itemname = $row['itemname'];
    $_itemcode = $row['itemcode'];


    $html .= '<tr nobr="true" style="font-size:15px;">';
    $html .=   '<td width="5 %" align="center"> ' . (string)$count . '</td>';
    $html .=   '<td width="20 %" align="left"> ' . (string)$_itemname . '</td>';

    $sub = "     WITH RECURSIVE calendar AS (
        SELECT DATE('$select_year_ok-$select_month_ok-01') AS DAY
        UNION ALL
        SELECT DAY + INTERVAL 1 DAY
        FROM calendar
        WHERE DAY + INTERVAL 1 DAY <= LAST_DAY('$select_year_ok-$select_month_ok-01')
    ),

    snapshot_data AS (
        -- 📌 snapshot ย้อนหลังจาก daily_item_rfid
        SELECT
            DATE(ds.snapshot_date) AS snapshot_date,
            ds.itemcode,
            ds.itemname,
            ds.qty
        FROM daily_item_rfid ds
        WHERE ds.itemcode = '$_itemcode'
          AND ds.stockID = '$stockid'
          AND MONTH(ds.snapshot_date) = '$select_month_ok '
          AND YEAR(ds.snapshot_date)  = '$select_year_ok'
          AND DATE(ds.snapshot_date) <> CURDATE()
    ),

    today_data AS (
        " . (in_array($stockid, ['1', '2', '3']) ?

        // ---------- 📌 today จาก itemstock (stock 1,2,3) ----------
        "
        SELECT
            CURDATE() AS snapshot_date,
            is2.ItemCode AS itemcode,
            i.itemname,
            COUNT(is2.itemcode) AS qty
        FROM itemstock is2
        LEFT JOIN item i ON is2.itemcode = i.itemcode
        WHERE is2.StockID = '$stockid'
          AND is2.itemcode = '$_itemcode'
        GROUP BY is2.ItemCode, i.itemname
        "
        :

        // ---------- 📌 today จาก itemslotincabinet ----------
        "
        SELECT
            CURDATE() AS snapshot_date,
            isc.itemcode,
            i.itemname,
            IFNULL(isc.Qty, 0) AS qty
        FROM itemslotincabinet isc
        LEFT JOIN item i ON isc.itemcode = i.itemcode
        WHERE isc.stockID = '$stockid'
          AND isc.itemcode = '$_itemcode'
        "
    ) . "
    ),

    d AS (
        SELECT * FROM snapshot_data
        UNION ALL
        SELECT * FROM today_data
    )

    SELECT
        c.DAY AS snapshot_date,
        d.itemcode,
        d.itemname,
        COALESCE(d.qty, 0) AS qty
    FROM calendar c
    LEFT JOIN d ON d.snapshot_date = c.DAY
    ORDER BY c.DAY; ";


    $meQuery2 = $conn->prepare($sub);
    $meQuery2->execute();
    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
        $qty = $row2['qty'];
        $html .=   '<td width="' . (string)$width . '%" align="center"> ' . (string)$qty . '</td>';
    }




    $html .=  '</tr>';
    $count++;
}






$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


// ==================================================================================================================








//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Follow_item_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
