<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'update_menu') {
        update_menu($conn, $db);
    }
}

function update_menu($conn, $db)
{
    $return = array();
    $input_userID = $_POST['input_userID'];
    $number = $_POST['number'];
    $menu = $_POST['menu'];


    // ตรวจสอบว่ามี userID อยู่หรือยัง
    $checkSql = "SELECT COUNT(*) as cnt FROM config_menu WHERE userID = :userID";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':userID', $input_userID);
    $checkStmt->execute();
    $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

    // ถ้าไม่มีข้อมูล userID ให้ทำการ INSERT
    if ($checkResult['cnt'] == 0) {
        $insertSql = "INSERT INTO config_menu (userID) VALUES (:userID)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':userID', $input_userID);
        $insertStmt->execute();
    }


    $sql2 = " UPDATE config_menu SET $menu = $number  WHERE userID = '$input_userID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();




    echo json_encode($return);
    unset($conn);
    die;
}
