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
        $update_sql = "UPDATE his_detail SET Qty = Qty + :QuantityToAdd , add_Qty = add_Qty + :QuantityToAdd2  WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':QuantityToAdd', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
        $update_stmt->bindParam(':QuantityToAdd2', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
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
        $insert_sql = "INSERT INTO his_detail (DocNo, ItemCode, add_Qty) VALUES (:DocNo, :ItemCode, :Qty)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':DocNo', $DocNo);
        $insert_stmt->bindParam(':ItemCode', $itemCode);
        $insert_stmt->bindParam(':Qty', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
        $insert_stmt->execute();


        $update_sql = "UPDATE his_detail SET Qty = Qty + :Qty   WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':Qty', $quantity, PDO::PARAM_INT); // ใช้ PARAM_INT สำหรับจำนวนเต็ม
        $update_stmt->bindParam(':DocNo', $DocNo);
        $update_stmt->bindParam(':ItemCode', $itemCode);
        $update_stmt->execute();

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
    $update_sql = "UPDATE his_detail SET Qty = Qty - 1 , delete_Qty = delete_Qty + 1  WHERE DocNo = :DocNo AND ItemCode = :ItemCode";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':DocNo', $DocNo);
    $update_stmt->bindParam(':ItemCode', $itemCode);
    $update_stmt->execute();

    // ตรวจสอบข้อผิดพลาดในการ UPDATE (ไม่บังคับ แต่แนะนำ)
    // if ($update_stmt->errorCode() != '00000') {
    //     error_log("UPDATE Error: " . print_r($update_stmt->errorInfo(), true));
    //     // สามารถเพิ่ม logic การจัดการข้อผิดพลาด เช่น rollback หรือแจ้งเตือน
    // }


    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    itemstock
                WHERE   itemstock.UsageCode = '$usageCode' ";


    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];

        $count_itemstock++;

        if ($_Isdeproom == 1) {
            $count_itemstock = 0;

            $query_2 = "SELECT
                            deproomdetailsub.ID ,
                            hncode_detail.ID AS hndetail_ID,
	                        deproomdetail.ItemCode,
	                        deproomdetail.DocNo,
	                        DATE(deproom.serviceDate) AS ModifyDate,
	                        deproom.number_box,
	                        deproom.hn_record_id
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                            INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                        WHERE
                            deproomdetailsub.ItemStockID = '$_RowID' 
                            AND hncode_detail.ItemStockID = '$_RowID' 
                        ORDER BY
	                        deproomdetailsub.ID DESC LIMIT 1 ";
            // echo $query_2;
            // exit;
            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                $return[] = $row_2;
                $_ID = $row_2['ID'];
                $_hndetail_ID = $row_2['hndetail_ID'];
                $_ModifyDate = $row_2['ModifyDate'];
                $_DocNo = $row_2['DocNo'];

                $_hn_record_id = $row_2['hn_record_id'];
                $_number_box = $row_2['number_box'];

                if ($_hn_record_id == "") {
                    $_hn_record_id = $_number_box;
                }

                // ==============================
                // $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
                // $meQueryD1 = $conn->prepare($queryD1);
                // $meQueryD1->execute();

                $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
                $meQueryD2 = $conn->prepare($queryD2);
                $meQueryD2->execute();
                // ==============================


                $insert_log = "INSERT INTO log_return (itemstockID, DocNo, userID, createAt) 
                            VALUES (:itemstockID, :DocNo, :userID, NOW())";

                $meQuery_log = $conn->prepare($insert_log);

                $meQuery_log->bindParam(':itemstockID', $_RowID);
                $meQuery_log->bindParam(':DocNo', $_DocNo);
                $meQuery_log->bindParam(':userID', $Userid);

                $meQuery_log->execute();
                // =======================================================================================================================================

                if ($db == 1) {
                    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND DATE(CreateDate) = '$_ModifyDate' ";
                } else {
                    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND CONVERT(DATE,CreateDate) = '$_ModifyDate' ";
                }

                $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                            VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                $meQuery_log = $conn->prepare($insert_log);

                $meQuery_log->bindParam(':itemCode', $_ItemCode);
                $meQuery_log->bindParam(':itemstockID', $_RowID);
                $meQuery_log->bindValue(':isStatus', 8, PDO::PARAM_INT);
                $meQuery_log->bindParam(':DocNo', $_DocNo);
                $meQuery_log->bindParam(':Userid', $Userid);


                $meQuery_log->execute();

                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================



                // ==============================
                $count_itemstock++;
            }



            $queryUpdate = "UPDATE itemstock 
            SET Isdeproom = 0 ,
            departmentroomid = '35',
            itemstock.IsCross = NULL
            WHERE
            RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        }
    }
}


// ส่ง Response กลับไปที่ JavaScript
// คุณอาจจะเพิ่มเงื่อนไขการตรวจสอบว่าข้อมูลถูกบันทึกสำเร็จหรือไม่ ก่อนที่จะส่ง status: success
echo json_encode(array(
    "status" => "success",
    "message" => "ได้รับข้อมูลการเพิ่มและการคืนอุปกรณ์เรียบร้อยแล้ว!"
));

exit();
