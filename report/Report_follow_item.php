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

            $select_follow_month = $_GET['select_follow_month'];
            $select_follow_year = $_GET['select_follow_year'];

        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');

        $this->SetFont('db_helvethaica_x', '', 18);
        $this->Cell(0, 50, "เดือน ". $datetime->getTHmonthFromnum($select_follow_month) . " ปี " . $select_follow_year , 0, 1, 'C');




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


        $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
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
$pdf->SetMargins(10, 45, 10);
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
$select_follow_month = $_GET['select_follow_month'];
$select_follow_year = $_GET['select_follow_year'];

// $date1 = explode("-", $date1);
// $text_date = "วันที่ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1])  . " " . date('Y');




// $pdf->SetY(20);


// $pdf->SetFont('db_helvethaica_x', 'b', 16);

// $pdf->Ln(5);


// $pdf->Cell(0, 10,  "รายงานสรุปผู้ป่วยเข้ารับบริการ", 0, 1, 'C');
// $pdf->Cell(0, 10,  $text_date, 0, 1, 'C');




$pdf->SetFont('db_helvethaica_x', 'B', 18);
$pdf->Ln(5);

$num = 0;

$html = '<table cellspacing="0" cellpadding="2" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="5 %" align="center">ลำดับ</th>
<th width="20 %" align="center">อุปกรณ์</th>';


  if ($select_follow_month == '04' || $select_follow_month == '06' || $select_follow_month == '09' || $select_follow_month == '11') {
    $num = 30;
    $width = 75/30;
  } else if ($select_follow_month == '02') {
    $num  = 28;
    $width = 75/28;
  } else {
    $num  = 31;
    $width = 75/31;
  }


for ($i=0; $i < $num; $i++) { 
    $html .= '<th width="' . (string)$width .'%" align="center">' . (string)$i+1 .'</th>';
}


$html .= '</tr> </thead>';

$count = 1;
$query = "SELECT
                daily_stock_item.snapshot_date,
                daily_stock_item.itemcode,
                daily_stock_item.itemname
            FROM
                daily_stock_item
            WHERE daily_stock_item.itemcode IN (SELECT set_item_daily.itemCode FROM set_item_daily)
            AND MONTH(daily_stock_item.snapshot_date) = '$select_follow_month' 
            AND YEAR(daily_stock_item.snapshot_date) = '$select_follow_year' 
            GROUP BY daily_stock_item.itemcode
            ORDER BY daily_stock_item.itemname, daily_stock_item.itemcode  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($row = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $_itemname = $row['itemname'];
    $_itemcode = $row['itemcode'];


        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="5 %" align="center"> ' . (string)$count . '</td>';
        $html .=   '<td width="20 %" align="left"> ' . (string)$_itemname . '</td>';


                $sub = "WITH RECURSIVE calendar AS (
                SELECT DATE('$select_follow_year-$select_follow_month-01') AS DAY
                UNION ALL
                SELECT DAY + INTERVAL 1 DAY
                FROM calendar
                WHERE DAY + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01')
            ),
            d AS (
                -- ดึงของเก่าที่ snapshot ไว้แล้ว (ยกเว้นวันนี้)
                SELECT
                    DATE(ds.snapshot_date) AS snapshot_date,
                    ds.itemcode,
                    ds.itemname,
                    ds.calculated_balance
                FROM daily_stock_item ds
                WHERE ds.itemcode = '$_itemcode'
                AND DATE(ds.snapshot_date) <> CURDATE()

                UNION ALL

                -- 📌 ของวันนี้: ใช้ยอด cnt ของห้อง 35 โดยตรง
                SELECT
                    CURDATE() AS snapshot_date,
                    i.itemcode,
                    i.itemname,
                    IFNULL(s.cnt, 0) AS calculated_balance
                FROM item i
                LEFT JOIN (
                    SELECT ItemCode, COUNT(*) AS cnt
                    FROM itemstock
                    WHERE itemstock.IsCancel = 0
                    AND itemstock.Stockin = 1
                    AND itemstock.Adjust_stock = 0
                    AND itemstock.IsDeproom = 0
                    AND itemstock.departmentroomid = 35
                    GROUP BY ItemCode
                ) s ON s.ItemCode = i.itemcode
                WHERE i.itemcode = '$_itemcode'
            )
            SELECT
                c.DAY AS snapshot_date,
                d.itemcode,
                d.itemname,
                COALESCE(d.calculated_balance, 0) AS calculated_balance
            FROM calendar c
            LEFT JOIN d ON d.snapshot_date = c.DAY
            ORDER BY c.DAY, d.itemcode; ";



            //     $sub = "  WITH RECURSIVE calendar AS (
            //     SELECT DATE('$select_follow_year-$select_follow_month-01') AS day
            //     UNION ALL
            //     SELECT day + INTERVAL 1 DAY
            //     FROM calendar
            //     WHERE day + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01' ) 
            // ),
            // d AS (
            //     SELECT
            //         DATE(ds.snapshot_date) AS snapshot_date,
            //         ds.itemcode,
            //         ds.itemname,
            //         ds.calculated_balance
            //     FROM daily_stock_item ds
            //     WHERE ds.itemcode = '$_itemcode'
            //     AND DATE(ds.snapshot_date) <> CURDATE()

            //     UNION ALL

            //     SELECT
            //         CURDATE() AS snapshot_date,
            //         i.itemcode,
            //         i.itemname,
            //         CASE 
            //             WHEN IFNULL(s.cnt, 0) > IFNULL(i.stock_balance, 0)
            //                 THEN (IFNULL(s.cnt, 0) - IFNULL(tp.cnt_pay, 0))
            //             ELSE (IFNULL(i.stock_balance, 0) - IFNULL(tp.cnt_pay, 0))
            //         END AS calculated_balance
            //     FROM item i

            //     LEFT JOIN (
            //         SELECT ItemCode, COUNT(*) AS cnt
            //         FROM itemstock
            //         GROUP BY ItemCode
            //     ) s ON s.ItemCode = i.itemcode

            //     LEFT JOIN (
            //         SELECT ItemCode, COUNT(*) AS cnt_pay
            //         FROM itemstock_transaction_detail
            //         WHERE IsStatus IN (1, 9)
            //         GROUP BY ItemCode
            //     ) tp ON tp.ItemCode = i.itemcode


            //     WHERE i.itemcode = '$_itemcode'
            // )

            // SELECT
            //     c.day AS snapshot_date,
            //     d.itemcode,
            //     d.itemname,
            //     COALESCE(d.calculated_balance, 0) AS calculated_balance
            // FROM calendar c
            // LEFT JOIN d
            //     ON d.snapshot_date = c.day
            // ORDER BY c.day, d.itemcode;";

                // $sub = "WITH RECURSIVE calendar AS (-- วันแรกของเดือนที่ต้องการ
                //     SELECT
                //         DATE( '$select_follow_year-$select_follow_month-01' ) AS DAY UNION ALL-- ไล่วันไปเรื่อย ๆ จนถึงวันสุดท้ายของเดือน
                //     SELECT DAY
                //         + INTERVAL 1 DAY 
                //     FROM
                //         calendar 
                //     WHERE
                //         DAY + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01' ) 
                //     ) SELECT
                //     c.DAY AS snapshot_date,
                //     d.itemcode,
                //     d.itemname,
                //     COALESCE ( d.calculated_balance, 0 ) AS calculated_balance 
                // FROM
                //     calendar c
                //     LEFT JOIN daily_stock_item d ON DATE( d.snapshot_date ) = c.DAY 
                //     AND d.itemcode = '$_itemcode' 
                // ORDER BY
                //     c.DAY,
                //     d.itemcode; ";
        $meQuery2 = $conn->prepare($sub);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $_calculated_balance = $row2['calculated_balance'];
            $html .=   '<td width="' . (string)$width .'%" align="center"> ' . (string)$_calculated_balance . '</td>';

        }




        $html .=  '</tr>';
        $count++;


}


// $date1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

// $where_date = "WHERE DATE(deproom.serviceDate) = '$date1'  ";



// $count = 1;
// $query = "SELECT
//             CONCAT(employee1.FirstName, ' ', employee1.LastName) AS name_1,
//             CONCAT(employee2.FirstName, ' ', employee2.LastName) AS name_2,
//             DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS serviceDate,
//             TIME(deproom.serviceDate) AS serviceTime,
//             deproom.hn_record_id,
//             departmentroom.departmentroomname,
//             deproom.`procedure`,
//             deproom.doctor,
//             deproom.DocNo,
//             doctor.Doctor_Name,
//             doctor.Doctor_Code ,
//             deproom.number_box  ,
//             deproom.Remark ,
//             `procedure`.Procedure_TH
//             FROM
//             deproom
//             LEFT JOIN users AS user1 ON deproom.UserCode = user1.ID
//             LEFT JOIN users AS user2 ON deproom.UserPay = user2.ID
//             LEFT JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
//             LEFT JOIN employee AS employee2 ON user2.EmpCode = employee2.EmpCode
//             LEFT JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
//             LEFT JOIN doctor ON deproom.doctor = doctor.ID
//             LEFT JOIN `procedure` ON `procedure`.ID = deproom.`procedure` 
//             LEFT JOIN set_hn ON set_hn.DocNo_deproom = deproom.DocNo
//             $where_date  
//             -- AND deproom.DocNo NOT IN (SELECT set_hn.DocNo_deproom FROM set_hn WHERE DATE( set_hn.serviceDate ) = '$date1' AND set_hn.isStatus = 9  )
//             AND deproom.IsCancel = 0
//             AND deproom.IsBlock = 0
//             GROUP BY deproom.DocNo";



// $meQuery1 = $conn->prepare($query);
// $meQuery1->execute();
// while ($row = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
//     $_DocNo = $row['DocNo'];
//     $_name1 = $row['name_1'];
//     $_name2 = $row['name_2'];
//     $_serviceDate = $row['serviceDate'];
//     $_hn_record_id = $row['hn_record_id'];
//     $_procedure = $row['procedure'];
//     $_doctor = $row['doctor'];
//     $_serviceTime = $row['serviceTime'];
//     $_departmentroomname = $row['departmentroomname'];
//     $number_box = $row['number_box'];
//     $Remark = $row['Remark'];

//     $_Procedure_TH = $row['Procedure_TH'];
//     $_Doctor_Name = $row['Doctor_Name'];
//     $_Doctor_Code = $row['Doctor_Code'];

//     if ($_hn_record_id == '') {
//         $_hn_record_id = $number_box;
//     }

//     $checkloopDoctor = "";
//     if ($row['doctor'] !== null && str_contains($row['doctor'], ',')) {
//         $checkloopDoctor = 'loop';
//     }
//     $checkloopProcedure = "";
//     if ($row['procedure'] !== null && str_contains($row['procedure'], ',')) {
//         $checkloopProcedure = 'loop';
//     }

//     if ($checkloopDoctor == 'loop') {

//         $query_D = "SELECT GROUP_CONCAT(Doctor_Name SEPARATOR ', ') AS Doctor_Names FROM doctor WHERE doctor.ID IN( $_doctor )  ";
//         $meQuery_D = $conn->prepare($query_D);
//         $meQuery_D->execute();
//         while ($row_D = $meQuery_D->fetch(PDO::FETCH_ASSOC)) {
//             $_Doctor_Name .= $row_D['Doctor_Names'];
//         }
//     }
//     if ($checkloopProcedure == 'loop') {

//         $_Procedure_TH = "";
//         $query_P = "SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $_procedure )  ";
//         $meQuery_P = $conn->prepare($query_P);
//         $meQuery_P->execute();
//         while ($row_P = $meQuery_P->fetch(PDO::FETCH_ASSOC)) {
//             $_Procedure_TH .= $row_P['procedure_ids'];
//         }

//     }


//     $file = 'images/temp_qrcode_' . $_DocNo . '.png';  // สร้างชื่อไฟล์ QR Code แบบไม่ซ้ำกัน

//     $url = 'http://192.168.2.101:8080/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($_DocNo); // หรือ link อะไรก็ได้


//     //other parameters
//     $ecc = 'H';
//     $pixel_size = 10;
//     $frame_size = 8;

//     // Generates QR Code and Save as PNG
//     QRcode::png($url, $file, $ecc, $pixel_size, $frame_size);

//     $pdf->SetFont('db_helvethaica_x', 'B', 18);

//     $html .= '<tr nobr="true" style="font-size:15px;">';
//     $html .=   '<td width="6 %" align="center"> ' . (string)$count . '</td>';
//     $html .=   '<td width="20 %" align="left"> ' . (string)$_hn_record_id . '</td>';
//     $html .=   '<td width="23 %" align="left">' . (string)$_Procedure_TH . '</td>';
//     $html .=   '<td width="23 %" align="left">' . (string)$_Doctor_Name   . '</td>';
//     $html .=   '<td width="15 %" align="center">' . (string)$_serviceDate . $_serviceTime . '</td>';
//     $html .=   '<td width="15 %" align="center"><img src="' . $file . '"  /> </td>';
//     $html .=  '</tr>';
//     $count++;
// }




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');


// ==================================================================================================================








//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Follow_item_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
