<?php
require '../report/phpexcel/vendor/autoload.php'; // PhpSpreadsheet
require '../config/db.php';
require '../connect/connect.php';

use PhpOffice\PhpSpreadsheet\IOFactory;



// 2. ตรวจสอบไฟล์
if (!isset($_FILES['excelFile']['tmp_name'])) {
    exit("❌ ไม่พบไฟล์ที่อัปโหลด");
}

$filePath = $_FILES['excelFile']['tmp_name'];

try {
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $updated = 0;
    $inserted = 0;

    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // ข้ามหัวตาราง

        // สมมุติว่า Excel มีคอลัมน์: id, name, email, age
        $itemcode = (string)$row[1];
        $stock_balance = (string)$row[5];
        $stock_max = (string)$row[6];
        $stock_min = (string)$row[7];

        if($stock_max == '' || $stock_max == null){
            $stock_max = 0;
        }
        if($stock_min == '' || $stock_min == null){
            $stock_min = 0;
        }
        if($stock_balance == '' || $stock_balance == null){
            $stock_balance = 0;
        }

        if($stock_max != 0 || $stock_min !=0 || $stock_balance != 0){
            $updateStmt = $conn->prepare("UPDATE item SET stock_max = ?, stock_min = ?, stock_balance = ? WHERE itemcode = ?");
            $updateStmt->execute([$stock_max, $stock_min, $stock_balance, $itemcode]);
            $updated++;
        }



        // // ตรวจสอบว่ามี record นี้อยู่หรือยัง
        // $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
        // $stmt->execute([$id]);

        // if ($stmt->rowCount() > 0) {
        //     // UPDATE
        //     $updateStmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, age = ? WHERE id = ?");
        //     $updateStmt->execute([$name, $email, $age, $id]);
        //     $updated++;
        // } else {
        //     // INSERT
        //     $insertStmt = $pdo->prepare("INSERT INTO users (id, name, email, age) VALUES (?, ?, ?, ?)");
        //     $insertStmt->execute([$id, $name, $email, $age]);
        //     $inserted++;
        // }
    }
    // exit;
    echo "✅ อัปเดตแล้ว: $updated รายการ<br>➕ เพิ่มใหม่: $inserted รายการ";
} catch (Exception $e) {
    echo "❌ เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
