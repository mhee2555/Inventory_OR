<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

require_once('tcpdf/tcpdf.php');
require('../connect/connect.php');

date_default_timezone_set("Asia/Bangkok");

$month = $_GET['month'] ?? date('Y-m');

// ======================
// 📌 LOAD DATA (ใช้ร่วม)
// ======================
$sql = "
SELECT 
    DATE(create_date) as d,
    HOUR(create_date) as h,
    AVG(temp_log) as temp,
    AVG(hum_log) as hum
FROM cabinet_temp_hum_log
WHERE DATE_FORMAT(create_date, '%Y-%m') = :month
GROUP BY DATE(create_date), HOUR(create_date)
";

$stmt = $conn->prepare($sql);
$stmt->execute([':month' => $month]);

$data_temp = [];
$data_hum  = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $day = (int)date('d', strtotime($row['d']));
    $hour = (int)$row['h'];

    if ($hour <= 9) $time = '08:00';
    else $time = '16:00';

    $data_temp[$time][$day] = round($row['temp'], 1);
    $data_hum[$time][$day]  = round($row['hum'], 1);
}

// ======================
// 📊 FUNCTION วาดกราฟ
// ======================
function createGraph($data, $minY, $maxY)
{
    $width = 1200;
    $height = 500;

    $img = imagecreate($width, $height);

    $bg = imagecolorallocate($img, 255, 255, 255);
    $line = imagecolorallocate($img, 0, 102, 204);
    $grid = imagecolorallocate($img, 220, 220, 220);
    $text = imagecolorallocate($img, 0, 0, 0);
    $red  = imagecolorallocate($img, 255, 0, 0);

    $left = 80;
    $right = $width - 80;
    $top = 30;
    $bottom = $height - 60;

    // grid
    for ($y = $minY; $y <= $maxY; $y += ($maxY <= 30 ? 1 : 5)) {
        $yPos = (int)($bottom - (($y - $minY) / ($maxY - $minY)) * ($bottom - $top));
        imageline($img, $left, $yPos, $right, $yPos, $grid);
        imagestring($img, 3, 20, $yPos - 7, $y, $text);
    }

    // เส้นประ
    $style = [$red, $red, $red, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT];
    imagesetstyle($img, $style);

        // ตั้ง style เส้นประ
        $style = [
            $red, $red, $red,
            IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT
        ];
        imagesetstyle($img, $style);

        // ===== TEMP (16–27) =====
        if ($maxY == 27) {

            // 18
            $y18 = (int) round(
                $bottom - ((18 - $minY) / ($maxY - $minY)) * ($bottom - $top)
            );
            imageline($img, $left, $y18, $right, $y18, IMG_COLOR_STYLED);
            imagestring($img, 3, 20, $y18 - 7, '18', $red);

            // 20
            $y20 = (int) round(
                $bottom - ((20 - $minY) / ($maxY - $minY)) * ($bottom - $top)
            );
            imageline($img, $left, $y20, $right, $y20, IMG_COLOR_STYLED);
            imagestring($img, 3, 20, $y20 - 7, '20', $red);
        }

        // ===== HUM (30–80) =====
        if ($maxY == 80) {

            $y60 = (int) round(
                $bottom - ((60 - $minY) / ($maxY - $minY)) * ($bottom - $top)
            );

            imageline($img, $left, $y60, $right, $y60, IMG_COLOR_STYLED);
            imagestring($img, 3, 20, $y60 - 7, '60', $red);
        }

    $days = 31;
    $xStep = ($right - $left) / ($days - 1);

    $prev = null;

    for ($d = 1; $d <= $days; $d++) {
        $x = (int)($left + ($d - 1) * $xStep);

        imagestring($img, 2, $x - 8, $bottom + 5, $d, $text);

        $sum = 0;
        $c = 0;
        foreach (['08:00', '16:00'] as $t) {
            if (isset($data[$t][$d])) {
                $sum += $data[$t][$d];
                $c++;
            }
        }

        if ($c == 0) {
            $prev = null;
            continue;
        }

        $value = $sum / $c;

        $y = (int)($bottom - (($value - $minY) / ($maxY - $minY)) * ($bottom - $top));

        imagefilledellipse($img, $x, $y, 8, 8, $line);

        if ($prev) {
            imageline($img, $prev['x'], $prev['y'], $x, $y, $line);
        }

        $prev = ['x' => $x, 'y' => $y];
    }

    ob_start();
    imagepng($img);
    $imgData = ob_get_clean();
    imagedestroy($img);

    return $imgData;
}

// ======================
// 📄 PDF
// ======================
$pdf = new TCPDF('L', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);

// ======================
// 📄 PAGE 1 TEMP
// ======================
$pdf->AddPage();

$pdf->SetFont('thsarabun', '', 12);

$pdf->Cell(0,6,'รายงานอุณหภูมิ (°C) ห้อง คลังเวชภัณฑ์และอุปกรณ์ห้องผ่าตัด',0,1,'C');
$pdf->Cell(0,6,'ศูนย์ศรีพัฒน์ คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่',0,1,'C');
$pdf->Cell(0,6,'ประจำเดือน '.$month,0,1,'C');

$img1 = createGraph($data_temp, 16, 27);

$pdf->Rect(10, 40, 277, 90);
$pdf->Image('@' . $img1, 12, 42, 273, 86);
$pdf->SetXY(10, 135);

$startX = 10;
$totalWidth = 277;

$daysInMonth = date('t', strtotime($month . '-01'));

$firstCol = 25;
$dayWidth = ($totalWidth - $firstCol) / $daysInMonth;

$html = '
<style>
th, td {
    text-align: center;
    vertical-align: middle;
}
</style>

<table border="1" cellpadding="2">
<tr>
<th width="' . $firstCol . '">เวลา</th>';

for ($d = 1; $d <= $daysInMonth; $d++) {
    $html .= "<th width='{$dayWidth}'>$d</th>";
}
$html .= '</tr>';

$times = ['08:00', '16:00'];

foreach ($times as $t) {
    $html .= "<tr><td width='{$firstCol}'>$t</td>";

    for ($d = 1; $d <= $daysInMonth; $d++) {
        $val = $data_temp[$t][$d] ?? '';
        $html .= "<td width='{$dayWidth}'>$val</td>";
    }

    $html .= "</tr>";
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
// ======================
// 📄 PAGE 2 HUM
// ======================
$pdf->AddPage();

$pdf->SetFont('thsarabun','',12);

$pdf->Cell(0,6,'รายงานความชื้นสัมพัทธ์ (% RH) ห้อง คลังเวชภัณฑ์และอุปกรณ์ห้องผ่าตัด',0,1,'C');
$pdf->Cell(0,6,'ศูนย์ศรีพัฒน์ คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่',0,1,'C');
$pdf->Cell(0,6,'ประจำเดือน '.$month,0,1,'C');

$img2 = createGraph($data_hum, 30, 80);

$pdf->Rect(10, 40, 277, 90);
$pdf->Image('@' . $img2, 12, 42, 273, 86);
$pdf->SetXY(10, 135);

$html = '<table border="1" cellpadding="2">
<tr>
<th width="' . $firstCol . '">เวลา</th>';

for ($d = 1; $d <= $daysInMonth; $d++) {
    $html .= "<th width='{$dayWidth}'>$d</th>";
}
$html .= '</tr>';

foreach ($times as $t) {
    $html .= "<tr><td width='{$firstCol}'>$t</td>";

    for ($d = 1; $d <= $daysInMonth; $d++) {
        $val = $data_hum[$t][$d] ?? '';
        $html .= "<td width='{$dayWidth}'>$val</td>";
    }

    $html .= "</tr>";
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
// ======================
ob_end_clean();
$pdf->Output('report.pdf', 'I');
