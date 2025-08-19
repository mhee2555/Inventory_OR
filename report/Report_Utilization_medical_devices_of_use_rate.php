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



        // // Set font
        // $this->SetFont('db_helvethaica_x', '', 14);

        // // Title
        // $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');






        if ($this->page == 1) {


        $image_file = "images/logo1.png";
        $this->Image($image_file, 7, 5, 12, 18, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-15);
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
$pdf->SetTitle('Report_Utilization_medical_devices_of_use_rate');
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
$pdf->SetMargins(5, 5, 5);
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
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];



$date1 = explode("-", $date1);
$date2 = explode("-", $date2);
$text_date = "ช่วงวันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " " . $date2[2] . " ถึง " . $date2[0] . " " . $datetime->getTHmonthFromnum($date2[1]) . " " . " " . $date2[2];






$pdf->SetFont('db_helvethaica_x', 'b', 16);



$pdf->Cell(0, 10,  "Utilization medical devices of use rate ", 0, 1, 'C');
$pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 14);
$pdf->Ln(5);



$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:14px;color:#fff;background-color:#663399;height:30px;">
<th width=" 3%" align="center" rowspan="2"><br><br>ลำดับ</th>
<th width=" 7%" align="center" rowspan="2"><br><br>รหัสอุปกรณ์</th>
<th width=" 16%" align="center" rowspan="2"><br><br>อุปกรณ์</th>
<th width=" 3%" align="center" rowspan="2"><br><br>จ่าย</th>
<th width=" 3%" align="center" rowspan="2"><br><br>คืน</th>
<th width=" 3%" align="center" rowspan="2"><br><br>ใช้</th>
<th width=" 7%" align="center" rowspan="2"><br><br>% Utilization <br> use rate</th>
<th width=" 58%" align="center">Trend Analysis</th>
</tr> 

<tr style="font-size:14px;color:#fff;background-color:#663399;height:30px;">
<th width=" 7.85%" align="center" >Moving Avg.<br>3Month</th>
<th width=" 7.85%" align="center">Usage<br>Intensity</th>
<th width=" 7.85%" align="center">Avg.<br>Monthly Usage </th>
<th width=" 6.85%" align="center">Usage<br>Volatility </th>
<th width=" 9.85%" align="center">Volatility<br>Level </th>
<th width=" 9.85%" align="center">Coefficient<br>Variation Percent</th>
<th width=" 7.85%" align="center">Trend<br>Direction </th>
</tr>

</thead>';

$month1 = $date2[2] . '-' . $date2[1];
$month2 = "";
$month3 = "";

$date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
$date2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];



$baseDate = new DateTime($date2);

for ($i = 1; $i <= 2; $i++) {
    $month = clone $baseDate;
    $month->modify("-{$i} months");
    if ($i == 1) {
        $month2 = $month->format("Y-m");
    }
    if ($i == 2) {
        $month3 = $month->format("Y-m");
    }
}

$query = "SELECT *,
            -- Trend Pattern
            CASE
                WHEN usage_jun > usage_may AND usage_may > usage_apr THEN 'Upward Trend'
                WHEN usage_jun < usage_may AND usage_may < usage_apr THEN 'Downward Trend'
                WHEN usage_may > usage_apr AND usage_may > usage_jun THEN 'Peak Pattern'
                WHEN usage_may < usage_apr AND usage_may < usage_jun THEN 'Valley Pattern'
                WHEN ABS(usage_jun - avg_val)/avg_val < 0.1 THEN 'Stable Pattern'
                ELSE 'Fluctuating'
            END AS Trend_Pattern,

            -- Trend Direction
            CASE
                WHEN Relative_Change > 0.2 THEN 'Strong Upward'
                WHEN Relative_Change > 0 THEN 'Moderate Upward'
                WHEN Relative_Change < -0.2 THEN 'Strong Downward'
                WHEN Relative_Change < 0 THEN 'Moderate Downward'
                ELSE 'Stable/Flat'
            END AS Trend_Direction,

            -- CV Interpretation
            CASE
                WHEN CV_percent < 15 THEN 'Very Stable'
                WHEN CV_percent < 25 THEN 'Stable'
                WHEN CV_percent < 50 THEN 'Moderate'
                WHEN CV_percent < 100 THEN 'Unstable'
                ELSE 'Highly Unstable'
            END AS CV_Interpretation,

            -- Usage Intensity
            CASE
                WHEN avg_val >= 100 THEN 'Very High (100+)'
                WHEN avg_val >= 50 THEN 'High (50-99)'
                WHEN avg_val >= 20 THEN 'Medium (20-49)'
                WHEN avg_val >= 5 THEN 'Low (5-19)'
                WHEN avg_val > 0 THEN 'Very Low (1-4)'
                ELSE 'No Usage'
            END AS Usage_Intensity

        FROM (
            SELECT
                i.itemcode,
                i.itemcode2,
                i.itemname,
                i.SalePrice,

                -- Monthly usage
                SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) AS usage_apr,
                SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month2' THEN 1 ELSE 0 END) AS usage_may,
                SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) AS usage_jun,

                -- Total usage (cnt)
                COUNT(ds.ID) AS usage_total,

                -- Return count
                (
                    SELECT COUNT(*)
                    FROM log_return lr
                    LEFT JOIN itemstock isr ON lr.itemstockID = isr.RowID
                    WHERE isr.ItemCode = i.itemcode
                    AND DATE(lr.createAt) BETWEEN '$date1' AND '$date2'
                ) AS cnt_return,

                -- Net usage
                (COUNT(ds.ID) -
                    (
                        SELECT COUNT(*)
                        FROM log_return lr
                        LEFT JOIN itemstock isr ON lr.itemstockID = isr.RowID
                        WHERE isr.ItemCode = i.itemcode
                        AND DATE(lr.createAt) BETWEEN '$date1' AND '$date2'
                    )
                ) AS net_cnt,
                -- % Utilization
                ROUND((
                    (COUNT(ds.ID) -
                        (
                            SELECT COUNT(*)
                            FROM log_return lr
                            LEFT JOIN itemstock isr ON lr.itemstockID = isr.RowID
                            WHERE isr.ItemCode = i.itemcode
                            AND DATE(lr.createAt) BETWEEN '$date1' AND '$date2'
                        )
                    ) / COUNT(ds.ID)
                ) * 100, 2) AS utilization_percent,

                -- Average
                ROUND(COUNT(ds.ID)/3, 2) AS avg_val,

                -- Standard Deviation (σ)
                ROUND(
                    SQRT((
                        POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2) +
                        POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month2' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2) +
                        POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2)
                    ) / 3), 2
                ) AS xxx,

                -- CV Percent
                ROUND(
                    (
                        SQRT(
                            (
                                POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2) +
                                POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month2' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2) +
                                POW(SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3, 2)
                            ) / 3
                        ) / NULLIF(COUNT(ds.ID)/3, 0)
                    ) * 100, 2
                ) AS CV_percent,

                -- Trend Score
                ROUND(
                    50 + (
                        (SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) - COUNT(ds.ID)/3
                        ) * 50 / NULLIF(COUNT(ds.ID)/3, 0)
                    ), 2
                ) AS Trend_Score,

                -- Relative Change
                ROUND((
                    SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END) -
                    SUM(CASE WHEN DATE_FORMAT(d.ServiceDate, '%Y-%m') = '$month1' THEN 1 ELSE 0 END)
                ) / NULLIF(COUNT(ds.ID)/3, 0), 2) AS Relative_Change

            FROM
                deproom d
                INNER JOIN deproomdetail dd ON d.DocNo = dd.DocNo
                INNER JOIN deproomdetailsub ds ON dd.ID = ds.Deproomdetail_RowID
                LEFT JOIN itemstock ist ON ds.ItemStockID = ist.RowID
                LEFT JOIN item i ON ist.ItemCode = i.itemcode
            WHERE
                DATE(d.ServiceDate) BETWEEN '$date1' AND '$date2'
                        AND i.itemcode IS NOT NULL
            GROUP BY
                i.itemcode
        ) AS final_result
        ORDER BY itemname; ";

$count = 1;
$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($row = $meQuery1->fetch(PDO::FETCH_ASSOC)) {


  $pdf->SetFont('db_helvethaica_x', 'B', 18);
  $_itemcode = $row['itemcode'];
  $_itemname = $row['itemname'];
  $_usage_total = $row['usage_total'];
  $_cnt_return = $row['cnt_return'];
  $_net_cnt = $row['net_cnt'];
  $_utilization_percent = $row['utilization_percent'];
  $_avg_val1 = ( $row['usage_apr'] + $row['usage_may'] + $row['usage_jun'] )/3;
  $_Usage_Intensity = $row['Usage_Intensity'];
  $_avg_val = $row['avg_val'];
  $_xxx = $row['xxx'];
  $_CV_Interpretation = $row['CV_Interpretation'];
  $_CV_percent = $row['CV_percent'];
  $_Trend_Direction = $row['Trend_Direction'];

    $html .= '<tr nobr="true" style="font-size:14px;">';
    $html .=   '<td width="3 %" align="center"> ' . (string)$count . '</td>';
    $html .=   '<td width="7 %" align="center"> ' . (string)$_itemcode . '</td>';
    $html .=   '<td width="16 %" align="left">' . (string)$_itemname . '</td>';
    $html .=   '<td width="3 %" align="center">' . (string)$_usage_total   . '</td>';
    $html .=   '<td width="3 %" align="center">' . (string)$_cnt_return .' </td>';
    $html .=   '<td width="3 %" align="center">' . (string)$_net_cnt .'</td>';
    $html .=   '<td width="7 %" align="center">' . (string)$_utilization_percent. '%</td>';
    $html .=   '<td width="7.85 %" align="right">' . (string)number_format($_avg_val1,2)  . '</td>';
    $html .=   '<td width="7.85 %" align="center">' . (string)$_Usage_Intensity. '</td>';
    $html .=   '<td width="7.85 %" align="right">' . (string)$_avg_val. '</td>';
    $html .=   '<td width="6.85 %" align="right">' . (string)$_xxx. '</td>';
    $html .=   '<td width="9.85 %" align="center">' . (string)$_CV_Interpretation. '</td>';
    $html .=   '<td width="9.85 %" align="right">' . (string)$_CV_percent. '</td>';
    $html .=   '<td width="7.85 %" align="center">' . (string)$_Trend_Direction. '</td>';

    $html .=  '</tr>';
    $count ++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


// ==================================================================================================================








//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Utilization_medical_devices_of_use_rate_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
