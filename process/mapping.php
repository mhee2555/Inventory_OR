<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'onconfirm_save_doctor') {
        onconfirm_save_doctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_deproom_doctor') {
        select_deproom_doctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_save_deproom') {
        onconfirm_save_deproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_proceduce_deproom') {
        select_proceduce_deproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_doctor') {
        show_detail_doctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_deproom') {
        show_detail_deproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_deproom') {
        delete_deproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_doctor') {
        delete_doctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_save_item') {
        onconfirm_save_item($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_item_map') {
        show_detail_item_map($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item_map') {
        showDetail_item_map($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_item_map') {
        delete_item_map($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_item_map') {
        select_item_map($conn, $db);
    }
}

function delete_doctor($conn, $db)
{
    $return = array();
    $doctor_id = $_POST['doctor_id'];



    $query = "DELETE FROM mapping_doctor WHERE mapping_doctor.doctor_id = '$doctor_id' ";
    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}
function delete_deproom($conn, $db)
{
    $return = array();
    $departmentroom_id = $_POST['departmentroom_id'];



    $query = "DELETE FROM mapping_departmentroom WHERE mapping_departmentroom.departmentroom_id = '$departmentroom_id' ";
    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_deproom($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];



    $query = "SELECT
                        departmentroom.departmentroomname,
                        mapping_departmentroom.departmentroom_id,
                        mapping_departmentroom.procedure_id,
                        `procedure`.Procedure_TH 
                    FROM
                        mapping_departmentroom
                        INNER JOIN departmentroom ON mapping_departmentroom.departmentroom_id = departmentroom.id
                        INNER JOIN `procedure` ON mapping_departmentroom.procedure_id = `procedure`.ID ";


    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($row['procedure_id'], ',')) {
            $row['Procedure_TH'] = 'button';
        }


        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_doctor($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];



    $query = "SELECT
                    mapping_doctor.doctor_id,
                    mapping_doctor.departmentroom_id,
                    doctor.Doctor_Name ,
                    departmentroom.departmentroomname 
                FROM
                    mapping_doctor
                    INNER JOIN doctor ON mapping_doctor.doctor_id = doctor.ID 
                    INNER JOIN departmentroom ON departmentroom.id = mapping_doctor.departmentroom_id ";


    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($row['departmentroom_id'], ',')) {
            $row['departmentroomname'] = 'button';
        }


        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_deproom_doctor($conn, $db)
{
    $return = array();

    $select_doctor_deproom = $_POST['select_doctor_deproom'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT mapping_doctor.departmentroom_id  FROM mapping_doctor WHERE mapping_doctor.doctor_id = $select_doctor_deproom ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $departmentroom_id = $row['departmentroom_id'];

        $query2 = "SELECT departmentroom.departmentroomname , departmentroom.id  FROM departmentroom WHERE departmentroom.id IN ($departmentroom_id) ";
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $row2;
        }
    }


    // echo $query;



    echo json_encode($return);
    unset($conn);
    die;
}

function select_proceduce_deproom($conn, $db)
{
    $return = array();

    $select_deproom_proceduce = $_POST['select_deproom_proceduce'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT mapping_departmentroom.procedure_id  FROM mapping_departmentroom WHERE mapping_departmentroom.departmentroom_id = $select_deproom_proceduce ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $procedure_id = $row['procedure_id'];

        $query2 = "SELECT `procedure`.Procedure_TH , `procedure`.ID  FROM `procedure` WHERE `procedure`.ID IN ($procedure_id) ";
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $row2;
        }
    }


    // echo $query;



    echo json_encode($return);
    unset($conn);
    die;
}



function onconfirm_save_doctor($conn, $db)
{
    $return = array();
    $select_doctor_deproom = $_POST['select_doctor_deproom'];
    $deproom_Array = $_POST['deproom_Array'];

    $deproom_Array = implode(",", $deproom_Array);

    $count_doctor = 0;
    $select = " SELECT mapping_doctor.doctor_id FROM mapping_doctor WHERE doctor_id = '$select_doctor_deproom'   ";
    $meQuery_select = $conn->prepare($select);
    $meQuery_select->execute();
    while ($row = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
        $count_doctor++;
    }

    if ($count_doctor == 0) {
        $queryInsert = "INSERT INTO mapping_doctor ( doctor_id , departmentroom_id )
        VALUES
            ( '$select_doctor_deproom' , '$deproom_Array')";
    } else {
        $queryInsert = "UPDATE mapping_doctor SET  departmentroom_id = '$deproom_Array' WHERE doctor_id = '$select_doctor_deproom' ";
    }


    $meQuery1 = $conn->prepare($queryInsert);
    $meQuery1->execute();

    echo json_encode($return);
    unset($conn);
    die;
}





function onconfirm_save_deproom($conn, $db)
{
    $return = array();
    $select_deproom_proceduce = $_POST['select_deproom_proceduce'];
    $procedure_id_Array = $_POST['procedure_id_Array'];

    $procedure_id_Array = implode(",", $procedure_id_Array);

    $count_doctor = 0;
    $select = " SELECT mapping_departmentroom.departmentroom_id FROM mapping_departmentroom WHERE departmentroom_id = '$select_deproom_proceduce'   ";
    $meQuery_select = $conn->prepare($select);
    $meQuery_select->execute();
    while ($row = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
        $count_doctor++;
    }

    if ($count_doctor == 0) {
        $queryInsert = "INSERT INTO mapping_departmentroom ( departmentroom_id , procedure_id )
        VALUES
            ( '$select_deproom_proceduce' , '$procedure_id_Array')";
    } else {
        $queryInsert = "UPDATE mapping_departmentroom SET  procedure_id = '$procedure_id_Array' WHERE departmentroom_id = '$select_deproom_proceduce' ";
    }



    $meQuery1 = $conn->prepare($queryInsert);
    $meQuery1->execute();

    echo json_encode($return);
    unset($conn);
    die;
}



function onconfirm_save_item($conn, $db)
{
    $return = array();
    $select_map_item_main = $_POST['select_map_item_main'];
    $item_Array = $_POST['item_Array'];

    $item_Array = implode(",", $item_Array);

    $count_item = 0;
    $select = " SELECT mapping_item.itemCode_main FROM mapping_item WHERE itemCode_main = '$select_map_item_main'   ";
    $meQuery_select = $conn->prepare($select);
    $meQuery_select->execute();
    while ($row = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
        $count_item++;
    }

    if ($count_item == 0) {
        $queryInsert = "INSERT INTO mapping_item ( itemCode_main , itemCode_sub )
        VALUES
            ( '$select_map_item_main' , '$item_Array')";
    } else {

        $itemCodesArr = explode(",", $item_Array); // แปลงเป็น array

        $itemCodesSql = "'" . implode("','", $itemCodesArr) . "'";

        $queryInsert = "UPDATE mapping_item SET  itemCode_sub = $itemCodesSql WHERE itemCode_main = '$select_map_item_main' ";

    }


    $meQuery1 = $conn->prepare($queryInsert);
    $meQuery1->execute();

    echo json_encode($return);
    unset($conn);
    die;
}


function show_detail_item_map($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];



    $query = " SELECT
                        mapping_item.itemCode_main,
                        mapping_item.itemCode_sub,
                        item1.itemname AS itemname_main,
                        item2.itemname AS itemname_sub 
                    FROM
                        mapping_item
                        INNER JOIN item AS item1 ON item1.itemcode = mapping_item.itemCode_main
                        LEFT JOIN item AS item2 ON item2.itemcode = mapping_item.itemCode_sub ";


    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($row['itemCode_sub'], ',')) {
            $row['itemname_sub'] = 'button';
        }


        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showDetail_item_map($conn, $db)
{
    $return = array();
    $itemCode_sub = $_POST['itemCode_sub'];
    $deproom = $_SESSION['deproom'];

    $itemCodesArr = explode(",", $itemCode_sub); // แปลงเป็น array

    $itemCodesSql = "'" . implode("','", $itemCodesArr) . "'";

    $query = "SELECT item.itemcode , item.itemname FROM item WHERE item.itemcode IN ($itemCodesSql) ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function delete_item_map($conn, $db)
{
    $return = array();
    $itemCode_main = $_POST['itemCode_main'];



    $query = "DELETE FROM mapping_item WHERE mapping_item.itemCode_main = '$itemCode_main' ";
    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function select_item_map($conn, $db)
{
    $return = array();

    $select_map_item_main = $_POST['select_map_item_main'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT mapping_item.itemCode_sub  FROM mapping_item WHERE mapping_item.itemCode_main = '$select_map_item_main' ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $itemCode_sub = $row['itemCode_sub'];

        $itemCodesArr = explode(",", $itemCode_sub); // แปลงเป็น array

        $itemCodesSql = "'" . implode("','", $itemCodesArr) . "'";

        $query2 = "SELECT item.itemcode , item.itemname FROM item WHERE item.itemcode IN ($itemCodesSql) ";


        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $row2;
        }
    }


    // echo $query;



    echo json_encode($return);
    unset($conn);
    die;
}
