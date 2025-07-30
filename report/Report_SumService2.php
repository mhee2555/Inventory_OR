<?php
require('../config/db.php');
include 'phpqrcode/qrlib.php';
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

// error_reporting(E_ALL & ~E_WARNING);

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

        // Set font
        $this->SetFont('db_helvethaica_x', '', 14);

        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . ' ' . $printdate, 0, 1, 'R');

        $image_file = "images/logo1.png";
        $this->Image($image_file, 10, 10, 20, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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

// ตรวจสอบพารามิเตอร์
if (!isset($_GET['date1'])) {
    die('<h2>Error: ไม่พบพารามิเตอร์ date1</h2>');
}

$action = isset($_GET['action']) ? $_GET['action'] : 'select';
$output_format = isset($_GET['format']) ? $_GET['format'] : 'pdf';
$date1 = $_GET['date1'];
$ddate = date('d_m_Y');

// ถ้าขอ cleanup
if (isset($_GET['cleanup']) && isset($_GET['session'])) {
    $session = $_GET['session'];
    $imageDir = 'temp_images';
    $files = glob($imageDir . '/report_' . $session . '_*.png');

    foreach ($files as $file) {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => 'cleaned', 'files' => count($files)]);
    exit;
}

// ฟังก์ชันสร้าง PDF
function createPDF($conn, $date1)
{
    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Hospital System');
    $pdf->SetTitle('Report_Summary_Service');
    $pdf->SetSubject('Patient Report');
    $pdf->SetKeywords('TCPDF, PDF, report, patient');

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

    // add a page
    $pdf->AddPage('P', 'A4');

    $datetime = new DatetimeTH();
    $date1_array = explode("-", $date1);
    $text_date = "วันที่ : " . $date1_array[0] . " " . $datetime->getTHmonthFromnum($date1_array[1]) . " " . " พ.ศ." . " " . ($date1_array[2] + 543);

    $pdf->SetY(20);
    $pdf->SetFont('db_helvethaica_x', 'b', 16);
    $pdf->Ln(5);
    $pdf->Cell(0, 10,  "รายงานสรุปผู้ป่วยเข้ารับบริการ", 0, 1, 'C');
    $pdf->Cell(0, 10,  $text_date, 0, 1, 'C');
    $pdf->SetFont('db_helvethaica_x', 'B', 18);
    $pdf->Ln(5);

    $html = '<table cellspacing="0" cellpadding="2" border="1" >
    <thead><tr style="font-size:18px;color:#fff;background-color:#663399;">
    <th width="6 %" align="center">ลำดับ</th>
    <th width="20 %" align="center">รหัสผู้ป่วย</th>
    <th width="23 %"  align="center">หัตถการ</th>
    <th width="23 %" align="center">แพทย์</th>
    <th width="15 %" align="center">วัน/เวลารับบริการ</th>
    <th width="15 %" align="center">QR Code</th>
    </tr> </thead>';

    $date1_formatted = $date1_array[2] . '-' . $date1_array[1] . '-' . $date1_array[0];
    $where_date = "WHERE DATE(deproom.serviceDate) = '$date1_formatted'  ";

    $count = 1;
    $qrFiles = [];

    $query = "SELECT
                CONCAT(employee1.FirstName, ' ', employee1.LastName) AS name_1,
                CONCAT(employee2.FirstName, ' ', employee2.LastName) AS name_2,
                DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y') AS serviceDate,
                TIME(deproom.serviceDate) AS serviceTime,
                deproom.hn_record_id,
                departmentroom.departmentroomname,
                deproom.`procedure`,
                deproom.doctor,
                deproom.DocNo,
                doctor.Doctor_Name,
                doctor.Doctor_Code ,
                deproom.number_box  ,
                deproom.Remark ,
                `procedure`.Procedure_TH
                FROM
                deproom
                LEFT JOIN users AS user1 ON deproom.UserCode = user1.ID
                LEFT JOIN users AS user2 ON deproom.UserPay = user2.ID
                LEFT JOIN employee AS employee1 ON user1.EmpCode = employee1.EmpCode
                LEFT JOIN employee AS employee2 ON user2.EmpCode = employee2.EmpCode
                LEFT JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                LEFT JOIN doctor ON deproom.doctor = doctor.ID
                LEFT JOIN `procedure` ON `procedure`.ID = deproom.`procedure` 
                LEFT JOIN set_hn ON set_hn.DocNo_deproom = deproom.DocNo
                $where_date  
                AND deproom.DocNo NOT IN (SELECT set_hn.DocNo_deproom FROM set_hn WHERE DATE( set_hn.serviceDate ) = '$date1_formatted' AND set_hn.isStatus = 9  )
                AND deproom.IsCancel = 0
                GROUP BY deproom.DocNo";

    $meQuery1 = $conn->prepare($query);
    $meQuery1->execute();
    while ($row = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];
        $_name1 = $row['name_1'];
        $_name2 = $row['name_2'];
        $_serviceDate = $row['serviceDate'];
        $_hn_record_id = $row['hn_record_id'];
        $_procedure = $row['procedure'];
        $_doctor = $row['doctor'];
        $_serviceTime = $row['serviceTime'];
        $_departmentroomname = $row['departmentroomname'];
        $number_box = $row['number_box'];
        $Remark = $row['Remark'];
        $_Procedure_TH = $row['Procedure_TH'];
        $_Doctor_Name = $row['Doctor_Name'];
        $_Doctor_Code = $row['Doctor_Code'];

        if ($_hn_record_id == '') {
            $_hn_record_id = $number_box;
        }

        $checkloopDoctor = "";
        if ($row['doctor'] !== null && str_contains($row['doctor'], ',')) {
            $checkloopDoctor = 'loop';
        }
        $checkloopProcedure = "";
        if ($row['procedure'] !== null && str_contains($row['procedure'], ',')) {
            $checkloopProcedure = 'loop';
        }

        if ($checkloopDoctor == 'loop') {
            $query_D = "SELECT GROUP_CONCAT(Doctor_Name SEPARATOR ', ') AS Doctor_Names FROM doctor WHERE doctor.ID IN( $_doctor )  ";
            $meQuery_D = $conn->prepare($query_D);
            $meQuery_D->execute();
            while ($row_D = $meQuery_D->fetch(PDO::FETCH_ASSOC)) {
                $_Doctor_Name .= $row_D['Doctor_Names'];
            }
        }
        if ($checkloopProcedure == 'loop') {
            $_Procedure_TH = "";
            $query_P = "SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $_procedure )  ";
            $meQuery_P = $conn->prepare($query_P);
            $meQuery_P->execute();
            while ($row_P = $meQuery_P->fetch(PDO::FETCH_ASSOC)) {
                $_Procedure_TH .= $row_P['procedure_ids'];
            }
        }

        $file = 'images/temp_qrcode_' . $_DocNo . '.png';
        $qrFiles[] = $file;

        $url = 'http://192.168.2.101:8080/Inventory_OR/pages/confirm_pay.php?doc=' . urlencode($_DocNo);
        $ecc = 'H';
        $pixel_size = 10;
        $frame_size = 8;
        QRcode::png($url, $file, $ecc, $pixel_size, $frame_size);

        $pdf->SetFont('db_helvethaica_x', 'B', 18);
        $html .= '<tr nobr="true" style="font-size:15px;">';
        $html .=   '<td width="6 %" align="center"> ' . (string)$count . '</td>';
        $html .=   '<td width="20 %" align="left"> ' . (string)$_hn_record_id . '</td>';
        $html .=   '<td width="23 %" align="left">' . (string)$_Procedure_TH . '</td>';
        $html .=   '<td width="23 %" align="left">' . (string)$_Doctor_Name   . '</td>';
        $html .=   '<td width="15 %" align="center">' . (string)$_serviceDate . $_serviceTime . '</td>';
        $html .=   '<td width="15 %" align="center"><img src="' . $file . '"  /> </td>';
        $html .=  '</tr>';
        $count++;
    }

    $html .= '</table>';
    $pdf->writeHTML($html, true, false, false, false, '');

    return ['pdf' => $pdf, 'qrFiles' => $qrFiles];
}

// ฟังก์ชันหา Ghostscript
function findGhostscript()
{
    $possiblePaths = [
        'C:\\Program Files\\gs\\gs10.02.1\\bin\\gswin64c.exe',
        'C:\\Program Files\\gs\\gs10.01.2\\bin\\gswin64c.exe',
        'C:\\Program Files\\gs\\gs9.56.1\\bin\\gswin64c.exe',
        'C:\\Program Files (x86)\\gs\\gs10.02.1\\bin\\gswin32c.exe',
        'C:\\Program Files (x86)\\gs\\gs9.56.1\\bin\\gswin32c.exe',
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }
    return null;
}

if ($action == 'preview' && $output_format == 'png') {
    // พรีวิวเป็นรูปภาพ
    $pdfData = createPDF($conn, $date1);
    $pdf = $pdfData['pdf'];
    $qrFiles = $pdfData['qrFiles'];

    $tempDir = sys_get_temp_dir();
    $tempPdf = $tempDir . DIRECTORY_SEPARATOR . 'Report_Summary_Service_temp_' . uniqid() . '.pdf';

    try {
        // บันทึก PDF ชั่วคราว
        $pdfContent = $pdf->Output('', 'S');
        file_put_contents($tempPdf, $pdfContent);

        if (!file_exists($tempPdf)) {
            throw new Exception('ไม่สามารถสร้าง PDF ชั่วคราวได้');
        }

        // หา Ghostscript
        $gsPath = findGhostscript();
        if (!$gsPath) {
            throw new Exception('ไม่พบ Ghostscript กรุณาติดตั้ง Ghostscript ก่อนใช้งาน');
        }

        // สร้างโฟลเดอร์สำหรับเก็บรูป
        $imageDir = 'temp_images';
        if (!file_exists($imageDir)) {
            mkdir($imageDir, 0777, true);
        }

        // แปลงทุกหน้าเป็น PNG
        $sessionId = uniqid();
        $tempPngPattern = $imageDir . DIRECTORY_SEPARATOR . 'report_' . $sessionId . '_page_%d.png';

        $command = '"' . $gsPath . '" -dNOPAUSE -dBATCH -sDEVICE=png16m -r200 -sOutputFile="' . $tempPngPattern . '" "' . $tempPdf . '" 2>&1';

        exec($command, $output, $return_var);

        if ($return_var == 0) {
            $pngFiles = glob(str_replace('%d', '*', $tempPngPattern));
            sort($pngFiles);

            if (!empty($pngFiles)) {
                // แสดงหน้าพรีวิว
                echo '<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พรีวิวรายงาน - ' . $date1 . '</title>
    <style>
        body { 
            font-family: "Sarabun", Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background-color: #f5f5f5; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            border-radius: 15px; 
            box-shadow: 0 5px 25px rgba(0,0,0,0.1); 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            padding-bottom: 20px; 
            border-bottom: 3px solid #663399; 
        }
        .header h1 {
            color: #663399;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .slideshow-container {
            position: relative;
            max-width: 100%;
            margin: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .slide {
            display: none;
            text-align: center;
            padding: 30px;
            min-height: 600px;
        }
        .slide.active {
            display: block;
        }
        .slide-header {
            background: linear-gradient(135deg, #663399, #552288);
            color: white;
            padding: 20px;
            margin: -30px -30px 30px -30px;
            font-weight: bold;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .slide img {
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(102, 51, 153, 0.8);
            color: white;
            border: none;
            padding: 15px 20px;
            font-size: 24px;
            cursor: pointer;
            border-radius: 50px;
            z-index: 100;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 51, 153, 0.3);
        }
        .nav-button:hover {
            background: rgba(102, 51, 153, 1);
            transform: translateY(-50%) scale(1.1);
        }
        .prev {
            left: 20px;
        }
        .next {
            right: 20px;
        }
        .dots-container {
            text-align: center;
            background: #f8f9fa;
            margin: 0 -30px -30px -30px;
        }
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: all 0.3s;
        }
        .dot.active, .dot:hover {
            background-color: #663399;
            transform: scale(1.2);
        }
        .slide-controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .slide-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #663399;
            text-align: left;
        }
        .download-buttons { 
            text-align: center; 
            margin: 40px 0; 
            padding: 30px; 
            background: linear-gradient(135deg, #f8f9fa, #e9ecef); 
            border-radius: 12px; 
        }
        .btn { 
            display: inline-block; 
            padding: 15px 30px; 
            margin: 0 15px 10px 15px; 
            background: #663399; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            font-size: 16px;
            transition: all 0.3s; 
            box-shadow: 0 4px 15px rgba(102, 51, 153, 0.3);
        }
        .btn:hover { 
            background: #552288; 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 51, 153, 0.4);
        }
        .btn-secondary { 
            background: #28a745; 
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .btn-secondary:hover { 
            background: #218838; 
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        .btn-back {
            background: #6c757d;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }
        .btn-back:hover {
            background: #545b62;
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }
        .total-pages {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            display: inline-block;
            margin: 15px 0;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .btn-mini {
            display: inline-block;
            padding: 8px 16px;
            background: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
        }
        .btn-mini:hover {
            background: #138496;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">

        
        <!-- Slideshow Container -->
        <div class="slideshow-container">';

                // สร้าง slides
                foreach ($pngFiles as $index => $pngFile) {
                    $pageNumber = $index + 1;
                    $imageUrl = str_replace('\\', '/', $pngFile);
                    $activeClass = ($index === 0) ? 'active' : '';

                    echo '<div class="slide ' . $activeClass . '">
                            <div class="slide-header">
                                <span>📄 หน้าที่ ' . $pageNumber . ' จาก ' . count($pngFiles) . '</span>
                                <a href="?date1=' . urlencode($date1) . '&action=download_single&format=png&page=' . $pageNumber . '&session=' . $sessionId . '" 
                                   class="btn-mini" title="ดาวน์โหลดหน้านี้">
                                   💾 โหลดรูป
                                </a>
                            </div>
                            
     
                            
                            <img src="' . $imageUrl . '" alt="หน้าที่ ' . $pageNumber . '" />
                            
          
                          </div>';
                }

                echo '
            <!-- Navigation buttons -->
            <button class="nav-button prev" onclick="changeSlide(-1)">❮</button>
            <button class="nav-button next" onclick="changeSlide(1)">❯</button>
            
            <!-- Dots indicator -->
            <div class="dots-container">';

                for ($i = 0; $i < count($pngFiles); $i++) {
                    $activeClass = ($i === 0) ? 'active' : '';
                    echo '<span class="dot ' . $activeClass . '" onclick="currentSlide(' . ($i + 1) . ')"></span>';
                }

                echo '
            </div>
        </div>';

                echo '

        
        <script>
            let currentSlideIndex = 0;
            const slides = document.querySelectorAll(".slide");
            const dots = document.querySelectorAll(".dot");
            const totalSlides = slides.length;
            
            // แสดง slide ที่ระบุ
            function showSlide(index) {
                // ซ่อน slide ทั้งหมด
                slides.forEach(slide => slide.classList.remove("active"));
                dots.forEach(dot => dot.classList.remove("active"));
                
                // แสดง slide ที่เลือก
                if (slides[index]) {
                    slides[index].classList.add("active");
                    dots[index].classList.add("active");
                }
                
                currentSlideIndex = index;
            }
            
            // เปลี่ยน slide (ถัดไปหรือก่อนหน้า)
            function changeSlide(direction) {
                let newIndex = currentSlideIndex + direction;
                
                if (newIndex >= totalSlides) {
                    newIndex = 0; // วนกลับไปหน้าแรก
                } else if (newIndex < 0) {
                    newIndex = totalSlides - 1; // ไปหน้าสุดท้าย
                }
                
                showSlide(newIndex);
            }
            
            // ไปยัง slide ที่ระบุโดยตรง
            function currentSlide(index) {
                showSlide(index - 1); // index เริ่มจาก 1
            }
            
            // เพิ่มการควบคุมด้วยคีย์บอร์ด
            document.addEventListener("keydown", function(event) {
                if (event.key === "ArrowLeft") {
                    changeSlide(-1);
                } else if (event.key === "ArrowRight") {
                    changeSlide(1);
                } else if (event.key >= "1" && event.key <= "9") {
                    const pageNum = parseInt(event.key);
                    if (pageNum <= totalSlides) {
                        currentSlide(pageNum);
                    }
                }
            });
            
            // Auto-play slideshow (เลือกใช้)
            let autoPlayInterval;
            
            function startAutoPlay() {
                autoPlayInterval = setInterval(function() {
                    changeSlide(1);
                }, 10000); // เปลี่ยนทุก 10 วินาที
            }
            
            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }
            
            // หยุด auto-play เมื่อ hover
            document.querySelector(".slideshow-container").addEventListener("mouseenter", stopAutoPlay);
            document.querySelector(".slideshow-container").addEventListener("mouseleave", startAutoPlay);
            
            // เริ่ม auto-play
            // startAutoPlay(); // ปิดไว้ก่อน ถ้าต้องการให้เล่นอัตโนมัติให้เปิด
            
            // ลบไฟล์ชั่วคราวหลังจาก 10 นาที
            setTimeout(function() {
                fetch("?cleanup=1&session=' . $sessionId . '")
                .then(response => response.json())
                .then(data => console.log("Cleaned up:", data.files, "files"));
            }, 600000); // 10 minutes
            
            // เพิ่ม loading effect สำหรับรูปใน slides
            document.addEventListener("DOMContentLoaded", function() {
                const images = document.querySelectorAll(".slide img");
                images.forEach(function(img) {
                    img.addEventListener("load", function() {
                        this.style.opacity = "1";
                        this.style.transform = "scale(1)";
                    });
                    img.style.opacity = "0";
                    img.style.transform = "scale(0.95)";
                    img.style.transition = "all 0.5s ease";
                });
                
                // แสดงข้อมูล slide ปัจจุบัน
                console.log("📊 Slideshow พร้อมใช้งาน:", totalSlides, "หน้า");
                console.log("⌨️ ใช้ลูกศรซ้าย-ขวา หรือกดตัวเลข 1-" + Math.min(totalSlides, 9) + " เพื่อเปลี่ยนหน้า");
            });
        </script>
    </div>
</body>
</html>';
            } else {
                throw new Exception('ไม่พบไฟล์ PNG ที่สร้างขึ้น');
            }
        } else {
            throw new Exception('แปลงเป็น PNG ไม่สำเร็จ: ' . implode('\n', $output));
        }

        // ลบ PDF ชั่วคราว
        unlink($tempPdf);
    } catch (Exception $e) {
        if (file_exists($tempPdf)) unlink($tempPdf);

        echo '<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เกิดข้อผิดพลาด</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; text-align: center; }
        .error { background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; padding: 12px 24px; margin: 10px; background: #663399; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>⚠️ เกิดข้อผิดพลาด</h2>
        <div class="error">
            <strong>ข้อผิดพลาด:</strong> ' . htmlspecialchars($e->getMessage()) . '
        </div>
        <p>กรุณาลองใช้รูปแบบอื่น หรือติดต่อผู้ดูแลระบบ</p>
        <a href="?date1=' . urlencode($date1) . '&action=download&format=pdf" class="btn">📄 ดาวน์โหลด PDF แทน</a>
        <a href="?date1=' . urlencode($date1) . '&action=select" class="btn">⬅️ กลับหน้าหลัก</a>
    </div>
</body>
</html>';
    }

    // ลบไฟล์ QR Code ชั่วคราว
    foreach ($qrFiles as $qrFile) {
        if (file_exists($qrFile)) {
            unlink($qrFile);
        }
    }
} elseif ($action == 'download_single' && $output_format == 'png') {
    // ดาวน์โหลดรูปแต่ละหน้า
    $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $session = isset($_GET['session']) ? $_GET['session'] : '';

    if ($session) {
        $imageDir = 'temp_images';
        $pngFile = $imageDir . '/report_' . $session . '_page_' . $page_number . '.png';

        if (file_exists($pngFile)) {
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="Report_Summary_Service_' . $ddate . '_page_' . $page_number . '.png"');
            header('Content-Length: ' . filesize($pngFile));

            readfile($pngFile);
            exit;
        } else {
            // ถ้าไฟล์ไม่มี ให้สร้างใหม่
            $pdfData = createPDF($conn, $date1);
            $pdf = $pdfData['pdf'];
            $qrFiles = $pdfData['qrFiles'];

            $tempDir = sys_get_temp_dir();
            $tempPdf = $tempDir . DIRECTORY_SEPARATOR . 'Report_Summary_Service_temp_' . uniqid() . '.pdf';

            try {
                $pdfContent = $pdf->Output('', 'S');
                file_put_contents($tempPdf, $pdfContent);

                $gsPath = findGhostscript();
                if ($gsPath) {
                    $tempPng = $tempDir . DIRECTORY_SEPARATOR . 'single_page_' . uniqid() . '.png';

                    $command = '"' . $gsPath . '" -dNOPAUSE -dBATCH -sDEVICE=png16m -r300 -dFirstPage=' . $page_number . ' -dLastPage=' . $page_number . ' -sOutputFile="' . $tempPng . '" "' . $tempPdf . '" 2>&1';

                    exec($command, $output, $return_var);

                    if ($return_var == 0 && file_exists($tempPng)) {
                        header('Content-Type: image/png');
                        header('Content-Disposition: attachment; filename="Report_Summary_Service_' . $ddate . '_page_' . $page_number . '.png"');
                        header('Content-Length: ' . filesize($tempPng));

                        readfile($tempPng);
                        unlink($tempPng);
                        unlink($tempPdf);

                        // ลบไฟล์ QR Code ชั่วคราว
                        foreach ($qrFiles as $qrFile) {
                            if (file_exists($qrFile)) {
                                unlink($qrFile);
                            }
                        }
                        exit;
                    }
                }

                unlink($tempPdf);
            } catch (Exception $e) {
                // ถ้าแปลงไม่ได้ ให้ redirect กลับไป
                header('Location: ?date1=' . urlencode($date1) . '&action=select');
                exit;
            }

            // ลบไฟล์ QR Code ชั่วคราว
            foreach ($qrFiles as $qrFile) {
                if (file_exists($qrFile)) {
                    unlink($qrFile);
                }
            }
        }
    }

    // ถ้าไม่สามารถดาวน์โหลดได้ ให้กลับไปหน้าเลือก
    header('Location: ?date1=' . urlencode($date1) . '&action=select');
    exit;
}

//============================================================+
// END OF FILE
//============================================================+
