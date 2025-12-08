<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

// --------------------------------------------------------
//  คลาส PDF
// --------------------------------------------------------
class MYPDF extends TCPDF
{
    protected $last_page_flag = false;

    public function Close()
    {
        $this->last_page_flag = true;
        parent::Close();
    }

    // Header
    public function Header()
    {
        require('../config/db.php');
        require('../connect/connect.php');
        $datetime = new DatetimeTH();

        // วันที่พิมพ์ (ใช้ปี ค.ศ. แล้วแต่คุณ ถ้าจะเอา พ.ศ. ก็ +543)
        $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " " . (date('Y') + 543);

        if ($this->page == 1) {
            $this->SetFont('db_helvethaica_x', '', 14);

            // โลโก้
            // $image_file = "images/logo1.png";
            // $this->Image($image_file, 10, 10, 15, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
    }

    // Footer
    public function Footer()
    {
        $this->SetY(-25);
        $this->SetFont('db_helvethaica_x', 'i', 12);
        $this->Cell(190, 10, "หน้า " . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// --------------------------------------------------------
// สร้างเอกสาร
// --------------------------------------------------------
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sriphat');
$pdf->SetTitle('Report_Use_hn');
$pdf->SetSubject('Utilization Report');
$pdf->SetKeywords('TCPDF, PDF, Utilization, Patient');

$pdf->SetHeaderData('', 0, '', '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 10, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 27);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// --------------------------------------------------------
// รับค่า date filter จาก GET
// --------------------------------------------------------
$date1       = isset($_GET['date1'])       ? $_GET['date1']       : '';
$date2       = isset($_GET['date2'])       ? $_GET['date2']       : '';


$datetime = new DatetimeTH();
$text_date = '';
$where_date = '';


        $tmp1 = explode("-", $date1);
        $tmp2 = explode("-", $date2);

        $text_date = "ประจำวันที่ " . $tmp1[0] . " " . $datetime->getTHmonthFromnum($tmp1[1]) . " " . $tmp1[2] .
                     " ถึง " . $tmp2[0] . " " . $datetime->getTHmonthFromnum($tmp2[1]) . " " . $tmp2[2];

        $d1 = $tmp1[2] . '-' . $tmp1[1] . '-' . $tmp1[0];
        $d2 = $tmp2[2] . '-' . $tmp2[1] . '-' . $tmp2[0];
        $where_date = "  DATE( hncode.CreateDate ) BETWEEN '$d1' AND '$d2' ";


// --------------------------------------------------------
// เริ่มหน้าแรก
// --------------------------------------------------------
$pdf->AddPage('P', 'A4');
$pdf->SetFont('db_helvethaica_x', 'B', 16);

// หัวรายงานเหมือนรูป
$pdf->Cell(0, 8, 'รายงานสรุปการใช้อุปกรณ์กับคนไข้', 0, 1, 'C');
$pdf->SetFont('db_helvethaica_x', '', 15);
$pdf->Cell(0, 7, 'แผนก ห้องผ่าตัด (OR)', 0, 1, 'C');
$pdf->SetFont('db_helvethaica_x', '', 14);
$pdf->Cell(0, 7, $text_date, 0, 1, 'C');

$pdf->Ln(5);

// --------------------------------------------------------
// ดึงข้อมูลจากฐานข้อมูล
//   *** ตรงนี้คุณต้องปรับ SQL เอง ให้ alias ชื่อฟิลด์ตามที่ใช้ด้านล่าง ***
// --------------------------------------------------------
$sum_patient_cost = 0;
$total_pay_pct    = 0;
$total_use_pct    = 0;
$total_return_pct = 0;
$row_count        = 0;

$sql = "SELECT
            DATE_FORMAT(MIN(x.CreateDate), '%d/%m/%Y') AS CreateDate_th,
            DATE_FORMAT(MIN(x.CreateDate), '%H:%i')    AS CreateTime,
            x.HnCode,
            x.number_box,
            x.DocNo_SS,
            MIN(x.doctor_name)    AS doctor_name,
            MIN(x.procedure_list) AS procedure_list,

            -- รวมจำนวนจ่าย/คืน/ใช้ (เฉพาะที่มี ItemStockID)
            SUM(x.cnt)          AS total_cnt,
            SUM(x.cnt_return)   AS total_return,
            SUM(x.use_per_item) AS total_use,

            100 AS pay_pct,

            CASE
                WHEN SUM(x.cnt) = 0 THEN 0
                ELSE ROUND(SUM(x.use_per_item) / SUM(x.cnt) * 100, 2)
            END AS use_pct,

            CASE
                WHEN SUM(x.cnt) = 0 THEN 0
                ELSE ROUND(SUM(x.cnt_return) / SUM(x.cnt) * 100, 2)
            END AS return_pct,

            -- มูลค่าค่าใช้จ่าย (คิดจากของที่ใช้จริง)
            SUM(x.use_per_item * x.SalePrice) AS total_price

            FROM
            (
            SELECT
                deproom.ServiceDate AS CreateDate,
                hncode.HnCode,
                hncode.number_box,
                hncode.DocNo_SS,

                item.itemname,
                item.itemcode,
                item.itemcode2,
                item.SalePrice,
                item.item_status,

                -- จำนวนที่จ่าย (กัน join ซ้ำ)
                COUNT(DISTINCT deproomdetailsub.ID) AS cnt,

                -- จำนวนที่คืน (จากตารางสรุป log_return)
                IFNULL(r.cnt_return, 0) AS cnt_return,

                -- ใช้จริงต่อ item (กันค่าติดลบในระดับ item ก่อน)
                GREATEST(
                0,
                COUNT(DISTINCT deproomdetailsub.ID) - IFNULL(r.cnt_return, 0)
                ) AS use_per_item,

                -- หมอ + หัตถการ
                MIN(d.Doctor_Name) AS doctor_name,
                GROUP_CONCAT(
                DISTINCT p.`Procedure_EN`
                ORDER BY p.`Procedure_EN`
                SEPARATOR ', '
                ) AS procedure_list

            FROM
                hncode
                INNER JOIN deproom
                ON hncode.DocNo_SS = deproom.DocNo
                INNER JOIN deproomdetail
                ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN deproomdetailsub
                ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID

                -- เอาเฉพาะที่มี ItemStockID (ตัด NULL ทิ้ง)
                INNER JOIN itemstock
                ON itemstock.RowID = deproomdetailsub.ItemStockID

                -- item ผูกกับ itemstock เท่านั้น (ไม่เอา weighing แล้ว)
                INNER JOIN item
                ON item.itemcode = itemstock.ItemCode

                LEFT JOIN doctor d
                ON d.ID = hncode.doctor

                LEFT JOIN `procedure` p
                ON FIND_IN_SET(p.ID, hncode.PROCEDURE) > 0

                -- ตารางสรุปจำนวนคืนต่อ DocNo_SS + ItemCode
                LEFT JOIN (
                SELECT
                    lr.DocNo,
                    COALESCE(is_return.ItemCode, lr.itemCode) AS itemcode,
                    COUNT(*) AS cnt_return
                FROM
                    log_return lr
                    LEFT JOIN itemstock AS is_return
                    ON lr.itemstockID = is_return.RowID
                GROUP BY
                    lr.DocNo,
                    COALESCE(is_return.ItemCode, lr.itemCode)
                ) AS r
                ON r.DocNo    = hncode.DocNo_SS
                AND r.itemcode = item.itemcode

            WHERE
                $where_date
            GROUP BY
                hncode.DocNo_SS,
                deproom.ServiceDate,
                hncode.HnCode,
                hncode.number_box,
                item.itemname,
                item.itemcode,
                item.itemcode2,
                item.SalePrice,
                item.item_status
            ) AS x

            GROUP BY
            x.DocNo_SS,
            x.HnCode,
            x.number_box; ";

// *** เปลี่ยน $conn ให้ตรงกับ object PDO ของคุณ ***
$meQuery = $conn->prepare($sql);
$meQuery->execute();

// --------------------------------------------------------
// สร้างตาราง
// --------------------------------------------------------
$pdf->SetFont('db_helvethaica_x', '', 14);

// ส่วนหัวตาราง (ใช้ HTML + สีหัวข้อ)
// width รวม = 100%
$html  = '<table cellspacing="0" cellpadding="3" border="1">';
$html .= '<thead>
<tr >
    <th width="5%"  align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">ลำดับ</th>
    <th width="10%" align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">วันที่เข้ารับ<br>บริการ</th>
    <th width="12%" align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">รหัสคนไข้</th>
    <th width="9%"  align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">เวลาเข้า<br>รับบริการ</th>
    <th width="18%" align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">หัตถการ</th>
    <th width="13%" align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">อาจารย์<br>แพทย์</th>
    <th width="7%"  align="center" style="font-size:14px;color:#000000;background-color:#D9E1F2;">จ่าย</th>
    <th width="7%"  align="center" style="font-size:14px;color:#000000;background-color:#E2EFDA;">ใช้</th>
    <th width="7%"  align="center" style="font-size:14px;color:#000000;background-color:#FFF2CC;">คืน</th>
    <th width="12%"  align="center" style="font-size:14px;color:#ffffff;background-color:#663399;">ค่าใช้จ่าย<br>คนไข้ (บาท)</th>
</tr>
</thead>';

// -----------------------------------------------------------------
// แถวข้อมูล
// -----------------------------------------------------------------
$no = 1;
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $row_count++;

    // ใช้ total_price แทน patient_cost
    $sum_patient_cost += floatval($row['total_price']);
    $total_pay_pct    += floatval($row['pay_pct']);
    $total_use_pct    += floatval($row['use_pct']);
    $total_return_pct += floatval($row['return_pct']);

    $html .= '<tr nobr="true" style="font-size:13px;">';
    $html .= '<td width="5%"  align="center">' . $no . '</td>';

    // วันที่เข้ารับบริการ
    $html .= '<td width="10%" align="center">' . $row['CreateDate_th'] . '</td>';

    // รหัสคนไข้ (HN)
    $html .= '<td width="12%" align="center">' . $row['HnCode'] . '</td>';

    // เวลาเข้ารับบริการ
    $html .= '<td width="9%"  align="center">' . $row['CreateTime'] . '</td>';

    // หัตถการ (หลายอันคั่นด้วย ,)
    $html .= '<td width="18%" align="left">' . $row['procedure_list'] . '</td>';

    // อาจารย์แพทย์
    $html .= '<td width="13%" align="center">' . $row['doctor_name'] . '</td>';

    // % จ่าย / ใช้ / คืน
    $html .= '<td width="7%"  align="center" style="background-color:#D9E1F2;">' . number_format($row['pay_pct'],    2) . '%</td>';
    $html .= '<td width="7%"  align="center" style="background-color:#E2EFDA;">' . number_format($row['use_pct'],    2) . '%</td>';
    $html .= '<td width="7%"  align="center" style="background-color:#FFF2CC;">' . number_format($row['return_pct'], 2) . '%</td>';

    // ค่าใช้จ่ายคนไข้ (บาท) ใช้ total_price
    $html .= '<td width="12%"  align="right">'  . number_format($row['total_price'], 2) . '</td>';

    $html .= '</tr>';

    $no++;
}
// --------------------------------------------------------
// เติมแถวว่างให้เต็มหน้า (ให้เหมือนในรูปมีหลายแถวว่าง)
// สมมติอยากให้มีอย่างน้อย 10 แถว
// --------------------------------------------------------
// $min_rows = 60;
// $empty_rows = max(0, $min_rows - $row_count);

// for ($i = 0; $i < $empty_rows; $i++) {
//     $html .= '<tr nobr="true" style="font-size:13px;">
//         <td width="5%">&nbsp;</td>
//         <td width="13%">&nbsp;</td>
//         <td width="12%">&nbsp;</td>
//         <td width="9%">&nbsp;</td>
//         <td width="18%">&nbsp;</td>
//         <td width="15%">&nbsp;</td>
//         <td width="7%" style="background-color:#D9E1F2;">&nbsp;</td>
//         <td width="7%" style="background-color:#E2EFDA;">&nbsp;</td>
//         <td width="7%" style="background-color:#FFF2CC;">&nbsp;</td>
//         <td width="7%">&nbsp;</td>
//     </tr>';
// }

// --------------------------------------------------------
// แถว Grand Total (Average Utilization and Patient Costs)
// --------------------------------------------------------
$avg_pay    = ($row_count > 0) ? $total_pay_pct    / $row_count : 0;
$avg_use    = ($row_count > 0) ? $total_use_pct    / $row_count : 0;
$avg_return = ($row_count > 0) ? $total_return_pct / $row_count : 0;

$html .= '
<tr nobr="true" style="font-size:13px;">
    <td width="67%" colspan="6" align="center" style="background-color:#D9D9D9;">
        Grand Total (Average Utilization and Patient Costs)
    </td>

    <td width="7%" align="center" style="background-color:#D9E1F2;">' 
        . ($row_count ? number_format($avg_pay, 2) : '') . '%</td>

    <td width="7%" align="center" style="background-color:#E2EFDA;">' 
        . ($row_count ? number_format($avg_use, 2) : '') . '%</td>

    <td width="7%" align="center" style="background-color:#FFF2CC;">' 
        . ($row_count ? number_format($avg_return, 2) : '') . '%</td>

    <td width="12%" align="right">' 
        . ($row_count ? number_format($sum_patient_cost, 2) : '') . '</td>
</tr>';


$html .= '</table>';

// พ่น HTML ทั้งตารางออกไป
$pdf->writeHTML($html, true, false, false, false, '');

// --------------------------------------------------------
// ข้อความด้านล่างซ้าย (เหมือนในรูป)
// --------------------------------------------------------
$pdf->Ln(6);
$pdf->SetFont('db_helvethaica_x', '', 12);

$Userid = $_GET['Userid'];

$_FirstName = "";
$user = "SELECT
	employee.FirstName 
FROM
	users
	INNER JOIN employee ON users.EmpCode = employee.EmpCode
WHERE users.ID = '$Userid' ";
$meQuery_user = $conn->prepare($user);
$meQuery_user->execute();
while ($row_user = $meQuery_user->fetch(PDO::FETCH_ASSOC)) {
    $_FirstName = $row_user['FirstName'];
}



$printdate_footer = date('d') . " " . $datetime->getTHmonth(date('F')) . " " . (date('Y') + 543);
$pdf->Cell(0, 6, 'พิมพ์รายงานวันที่ : ' . $printdate_footer, 0, 1, 'L');
$pdf->Cell(0, 6, 'พิมพ์รายงานโดย : ' . $_FirstName, 0, 1, 'L'); // ปรับชื่อเองได้

// --------------------------------------------------------
// Output
// --------------------------------------------------------
$ddate = date('d_m_Y');
$pdf->Output('Report_Use_hn' . $ddate . '.pdf', 'I');
