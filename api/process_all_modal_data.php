<?php

session_start();
require '../config/db.php';
require '../connect/connect.php';
// กำหนด Content-Type ของ Response เพื่อให้ JavaScript ทราบว่าเป็น JSON
header('Content-Type: application/json');

// อ่านข้อมูล JSON ที่ส่งมาจาก JavaScript
$input_json = file_get_contents('php://input');

// แปลง JSON string เป็น PHP associative array
$data = json_decode($input_json, true);

// ตรวจสอบว่าการ decode JSON สำเร็จหรือไม่
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(array(
        "status" => "error",
        "message" => "Invalid JSON received: " . json_last_error_msg()
    ));
    exit();
}

// เข้าถึงค่า DocNo
$DocNo = isset($data['DocNo']) ? $data['DocNo'] : null;

// เข้าถึงข้อมูลจากตาราง add_items
$add_items = isset($data['add_items']) ? $data['add_items'] : [];

// เข้าถึงข้อมูลจากตาราง return_items
$return_items = isset($data['return_items']) ? $data['return_items'] : [];


// ตรวจสอบว่า DocNo ไม่เป็นค่าว่าง เพื่อป้องกันปัญหาในการบันทึกข้อมูล
if (empty($DocNo)) {
    echo json_encode(array(
        "status" => "error",
        "message" => "ไม่ได้รับค่า DocNo ที่ถูกต้อง"
    ));
    exit();
}

// ****** คุณสามารถนำค่า $add_items และ $return_items ไปประมวลผลต่อได้ที่นี่ ******
// ตัวอย่าง:
// เริ่มการประมวลผลสำหรับ add_items
foreach ($add_items as $item) {
    $itemCode = $item['item_code'];
    $quantity = $item['quantity']; // นี่คือจำนวนที่ต้องการเพิ่มเข้าไป

    // 1. ตรวจสอบว่ามีข้อมูลในตาราง his_detail อยู่แล้วหรือไม่
    $check_sql = "SELECT ID FROM his_detail WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':DocNo', $DocNo);
    $check_stmt->bindParam(':ItemCode', $itemCode);
    $check_stmt->execute();
    $existing_record = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_record) {
        // 2. ถ้ามีข้อมูลอยู่แล้ว ให้ทำการ UPDATE (เพิ่มจำนวนเข้าไป)
    $update_sql = "UPDATE his_detail SET edit_Qty = COALESCE(edit_Qty, Qty) + :QuantityToAdd WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':QuantityToAdd', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
        $update_stmt->bindParam(':DocNo', $DocNo);
        $update_stmt->bindParam(':ItemCode', $itemCode);
        $update_stmt->execute();

        // ตรวจสอบข้อผิดพลาดในการ UPDATE (ไม่บังคับ แต่แนะนำ)
        // if ($update_stmt->errorCode() != '00000') {
        //     error_log("UPDATE Error: " . print_r($update_stmt->errorInfo(), true));
        //     // สามารถเพิ่ม logic การจัดการข้อผิดพลาด เช่น rollback หรือแจ้งเตือน
        // }

    } else {
        // 3. ถ้าไม่มีข้อมูล ให้ทำการ INSERT รายการใหม่
        $insert_sql = "INSERT INTO his_detail (DocNo, ItemCode, edit_Qty) VALUES (:DocNo, :ItemCode, :Qty)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':DocNo', $DocNo);
        $insert_stmt->bindParam(':ItemCode', $itemCode);
        $insert_stmt->bindParam(':Qty', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
        $insert_stmt->execute();

        // ตรวจสอบข้อผิดพลาดในการ INSERT (ไม่บังคับ แต่แนะนำ)
        // if ($insert_stmt->errorCode() != '00000') {
        //     error_log("INSERT Error: " . print_r($insert_stmt->errorInfo(), true));
        //     // สามารถเพิ่ม logic การจัดการข้อผิดพลาด เช่น rollback หรือแจ้งเตือน
        // }
    }
}


foreach ($return_items as $item) {
    $usageCode = $item['usage_code'];
    $itemCode = $item['item_code']; // รหัสอุปกรณ์ที่คืน
    $quantityToReturn = $item['quantity']; // จำนวนที่คืน (ในกรณีนี้คือ 1 ตามที่โค้ดก่อนหน้าส่งมา)
    // ทำการบันทึกข้อมูลการคืนในฐานข้อมูล


        // 2. ถ้ามีข้อมูลอยู่แล้ว ให้ทำการ UPDATE (เพิ่มจำนวนเข้าไป)
        $update_sql = "UPDATE his_detail SET edit_Qty = COALESCE(edit_Qty, Qty) - 1 WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':DocNo', $DocNo);
        $update_stmt->bindParam(':ItemCode', $itemCode);
        $update_stmt->execute();

        // ตรวจสอบข้อผิดพลาดในการ UPDATE (ไม่บังคับ แต่แนะนำ)
        // if ($update_stmt->errorCode() != '00000') {
        //     error_log("UPDATE Error: " . print_r($update_stmt->errorInfo(), true));
        //     // สามารถเพิ่ม logic การจัดการข้อผิดพลาด เช่น rollback หรือแจ้งเตือน
        // }

   
}


// ส่ง Response กลับไปที่ JavaScript
// คุณอาจจะเพิ่มเงื่อนไขการตรวจสอบว่าข้อมูลถูกบันทึกสำเร็จหรือไม่ ก่อนที่จะส่ง status: success
echo json_encode(array(
    "status" => "success",
    "message" => "ได้รับข้อมูลการเพิ่มและการคืนอุปกรณ์เรียบร้อยแล้ว!"
));

exit();
