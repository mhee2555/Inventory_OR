<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_daily') {
        show_detail_daily($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'update_refrain') {
        update_refrain($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_refrain') {
        show_detail_refrain($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'update_daily') {
        update_daily($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'update_cancel') {
        update_cancel($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'update_create_request') {
        update_create_request($conn, $db);
    }
}

function update_create_request($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];


    $Q1 = " UPDATE set_hn SET isStatus = 1 WHERE set_hn.ID = '$ID' ";
    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();


    echo json_encode($return);
    unset($conn);
    die;


}

function update_cancel($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];


    $Q1 = " UPDATE set_hn SET isCancel = 1 WHERE set_hn.ID = '$ID' ";
    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();


    echo json_encode($return);
    unset($conn);
    die;


}


function update_daily($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];


    $Q1 = " UPDATE set_hn SET isStatus = 0 WHERE set_hn.ID = '$ID' ";
    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();


    echo json_encode($return);
    unset($conn);
    die;


}

function update_refrain($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];


    $Q1 = " UPDATE set_hn SET isStatus = 9 WHERE set_hn.ID = '$ID' ";
    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();


    echo json_encode($return);
    unset($conn);
    die;


}

function show_detail_daily($conn, $db)
{
    $return = array();
    $select_date1_search1 = $_POST['select_date1_search1'];

    $select_date1_search = explode("-", $select_date1_search1);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];




    $Q1 = " SELECT
                set_hn.ID,
                set_hn.isStatus,
                set_hn.hncode,
                DATE(set_hn.serviceDate) AS serviceDate,
                TIME(set_hn.serviceDate) AS serviceTime,
                set_hn.doctor,
                set_hn.departmentroomid,
                set_hn.`procedure`,
                set_hn.remark,
                doctor.Doctor_Name,
                IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                departmentroom.departmentroomname
            FROM
                set_hn
                INNER JOIN doctor ON doctor.ID = set_hn.doctor
                LEFT JOIN `procedure` ON set_hn.`procedure` = `procedure`.ID
                INNER JOIN departmentroom ON set_hn.departmentroomid = departmentroom.id 
                AND DATE( set_hn.createAt ) = '$select_date1_search'
                AND NOT set_hn.isStatus = 9
                AND  set_hn.isCancel = 0 ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($rowQ1['procedure'], ',')) {
            $rowQ1['Procedure_TH'] = 'button';
        }
        if (str_contains($rowQ1['doctor'], ',')) {
            $rowQ1['Doctor_Name'] = 'button';
        }


        $return[] = $rowQ1;


    }

    echo json_encode($return);
    unset($conn);
    die;


    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_refrain($conn, $db)
{
    $return = array();
    $select_date1_search1 = $_POST['select_date1_search2'];

    $select_date1_search = explode("-", $select_date1_search1);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];




    $Q1 = " SELECT
                set_hn.ID,
                set_hn.isStatus,
                set_hn.hncode,
                DATE(set_hn.serviceDate) AS serviceDate,
                TIME(set_hn.serviceDate) AS serviceTime,
                set_hn.doctor,
                set_hn.departmentroomid,
                set_hn.`procedure`,
                set_hn.remark,
                doctor.Doctor_Name,
                IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                departmentroom.departmentroomname
            FROM
                set_hn
                INNER JOIN doctor ON doctor.ID = set_hn.doctor
                LEFT JOIN `procedure` ON set_hn.`procedure` = `procedure`.ID
                INNER JOIN departmentroom ON set_hn.departmentroomid = departmentroom.id 
                AND DATE( set_hn.createAt ) = '$select_date1_search'
                AND  set_hn.isStatus = 9 
                AND  set_hn.isCancel = 0 ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($rowQ1['procedure'], ',')) {
            $rowQ1['Procedure_TH'] = 'button';
        }
        if (str_contains($rowQ1['doctor'], ',')) {
            $rowQ1['Doctor_Name'] = 'button';
        }


        $return[] = $rowQ1;


    }

    echo json_encode($return);
    unset($conn);
    die;


    echo json_encode($return);
    unset($conn);
    die;
}