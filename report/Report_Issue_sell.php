<?php
require('../config/db.php');
// include 'phpqrcode/qrlib.php';
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



        if ($this->page == 1) {
            // Set font
            $this->SetFont('db_helvethaica_x', '', 14);

            // Title
            $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');

            // $type_date = $_GET['type_date'];
            // $date1 = $_GET['date1'];
            // $date2 = $_GET['date2'];
            // $month1 = $_GET['month1'];
            // $month2 = $_GET['month2'];
            // $checkday = $_GET['checkday'];
            // $checkmonth = $_GET['checkmonth'];

            // if($type_date == 1){

            //     if($checkday == 1){
            //         $date1 = explode("-", $date1);
            //         $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
            //     }else{
            //         $date1 = explode("-", $date1);
            //         $date2 = explode("-", $date2);

            //         $text_date = "วันที่ใช้อุปกรณ์ : " . $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 ) . " ถึง " .  $date1[0] . " " . $datetime->getTHmonthFromnum($date1[1]) . " " . " พ.ศ." . " " .($date1[2] + 543 );
            //     }
            // }

            // if($type_date == 2){

            //     if($checkmonth == 1){
            //         $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1);
            //     }else{
            //         $text_date = "เดือนที่ใช้อุปกรณ์ : " . $datetime->getTHmonthFromnum($month1) . " ถึง " . $datetime->getTHmonthFromnum($month2);
            //     }
            // }


            $this->SetFont('db_helvethaica_x', 'b', 16);



            $this->Cell(0, 10,  " ใบขายอุปกรณ์ให้หน่วยงาน ", 0, 1, 'C');
            //   $this->Cell(0, 10,  $text_date, 0, 1, 'C');






            $image_file = "images/logo1.png";
            $this->Image($image_file, 10, 5, 10, 15, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);




            $DocNo = $_GET['DocNo'];
            // $pageHeight = $this->getPageHeight();
            $x = 160; // คงที่ตามที่คุณอยากได้
            $y = 30;

            $style = array(
                'border' => true,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0, 0, 0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            // $url = 'http://10.11.9.54/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($DocNo); // หรือ link อะไรก็ได้
            $url = 'http://192.168.2.101:8080/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($DocNo) .'&remark=sell'; // หรือ link อะไรก็ได้


            $this->write2DBarcode($url, 'QRCODE,L', $x, $y, 80, 30, $style, 'N');


            // ข้อความที่ต้องการ
            $text = 'สแกนเพื่อยืนยันรับอุปกรณ์ไปใช้กับผู้ป่วย';

            // เลื่อน cursor ไปที่ตำแหน่ง
            $this->SetXY($x, 60); // ขยับขึ้นจาก QR ประมาณ 8 หน่วย (เผื่อความสวย)
            $this->SetFont('db_helvethaica_x', 'i', 12);
            // วาด Cell ขนาดเท่าความกว้างของ QR แล้วจัดกลาง
            $this->Cell(35, 5, $text, 0, 1, 'C');
        }
    }
    // Page footer
    public function Footer()
    {
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('db_helvethaica_x', 'i', 12);
        // Page number
        $DocNo = $_GET['DocNo'];


        if ($this->last_page_flag) {
        }



        $this->SetY(-15);

        $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Issue_(IOR)');
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
$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 55);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------

// ------------------------------------------------------------------------------

// set font
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetFont('db_helvethaica_x', 'B', 15);

$DocNo = $_GET['DocNo'];

$checkloopDoctor  = "";
$_procedure = "";
$query = "SELECT
                sell_department.DocNo,
                DATE_FORMAT(sell_department.ServiceDate, '%d-%m-%Y') AS serviceDate,
                DATE_FORMAT(sell_department.ServiceDate, '%H:%i') AS serviceTime,
                department.DepName
            FROM
                sell_department
                INNER JOIN department ON department.ID = sell_department.departmentID 
            WHERE
                sell_department.DocNo = '$DocNo'
            GROUP BY
                department.DepName   ";


$meQuery = $conn->prepare($query);
$meQuery->execute();
while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    $DepName = $row['DepName'];
    $_serviceDate = $row['serviceDate'];
    $_serviceTime = $row['serviceTime'];
}



$pdf->Cell(60, 5,  '', 0, 1, 'L');
$pdf->Cell(60, 5,  '', 0, 1, 'L');

$pdf->Cell(60, 5,  "แผนก : " . $DepName, 0, 1, 'L');
$pdf->Cell(130, 5,  "วันที่เข้ารับบริการ : " . $_serviceDate, 0, 1, 'L');
$pdf->Cell(130, 5,  "เวลาเข้ารับบริการ : " . $_serviceTime, 0, 1, 'L');



$pdf->Ln(10);

$pdf->SetFont('db_helvethaica_x', 'B', 18);

$html = '<table cellspacing="0" cellpadding="1" border="1" >
<thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
<th width="12 %" align="center">Code</th>
<th width="80 %"  align="center">Name</th>
<th width="10 %" align="center">Qty</th>
</tr> </thead>';




$count = 1;
    $query = " SELECT
                    sell_department_detail.ItemStockID,
                    sell_department_detail.itemCode,
                    item.itemcode2,
                    item.itemname,
                    item.warehouseID,
                    COUNT( sell_department_detail.ItemStockID ) AS item_count 
                FROM
                    sell_department
                    INNER JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo
                    LEFT JOIN item ON item.itemcode = sell_department_detail.itemCode 
                WHERE
                    sell_department_detail.DocNo = '$DocNo' 
                    AND sell_department_detail.ItemStockID IS NOT NULL 
                GROUP BY
                    sell_department_detail.itemCode,
                    item.itemname 
                ORDER BY
                    item_count DESC  ";

$meQuery1 = $conn->prepare($query);
$meQuery1->execute();
while ($Result_Detail = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('db_helvethaica_x', 'B', 18);

        $html .= '<tr nobr="true" style="font-size:18px;height:30px;">';
        $html .=   '<td width="12 %" align="center" style="line-height:40px;vertical-align: middle;"> ' . $Result_Detail['itemcode2'] . '</td>';
        $html .=   '<td width="80 %" align="left"  style="line-height:40px;vertical-align: middle;"> ' . $Result_Detail['itemname'] . '</td>';
        $html .=   '<td width="10 %" align="center" style="line-height:40px;vertical-align: middle;">' . $Result_Detail['item_count'] . '</td>';
        $html .=  '</tr>';
        $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');






// output the HTML content







//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Issue_(IOR)_' . $ddate . '.pdf', 'I');


//============================================================+
// END OF FILE
//============================================================+
