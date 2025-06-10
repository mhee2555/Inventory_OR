<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_daily') {
        show_detail_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'update_refrain') {
        update_refrain($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_refrain') {
        show_detail_refrain($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'update_daily') {
        update_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'update_cancel') {
        update_cancel($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'update_create_request') {
        update_create_request($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'set_his') {
        set_his($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_his_docno') {
        show_detail_his_docno($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_his') {
        show_detail_his($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateDetail_qty') {
        updateDetail_qty($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onUPDATE_his') {
        onUPDATE_his($conn, $db);
    }
}

function onUPDATE_his($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];



    $sql2 = " UPDATE his SET IsStatus = 2  WHERE ID = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();





    echo json_encode($return);
    unset($conn);
    die;
}
function updateDetail_qty($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];
    $qty = $_POST['qty'];
    $itemcode = $_POST['itemcode'];




    $Userid = $_SESSION['Userid'];

    $sql2 = " UPDATE his_detail SET Qty = $qty  WHERE ID = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();





    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_his($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];

    $Q1 = " SELECT
                itemtype.TyeName,
                item.itemcode2,
                item.itemname,
                item.itemcode,
                his_detail.Qty,
                his_detail.ID,
	            item.SalePrice,
                his.IsStatus
            FROM
                his
                LEFT JOIN his_detail ON his.DocNo = his_detail.DocNo
                LEFT JOIN item ON his_detail.ItemCode = item.itemcode
                LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
            WHERE
                his.ID = '$ID'   ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $rowQ1;
    }

    echo json_encode($return);
    unset($conn);
    die;


    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_his_docno($conn, $db)
{
    $return = array();
    $select_his_Date = $_POST['select_his_Date'];

    $select_his_Date = explode("-", $select_his_Date);
    $select_his_Date = $select_his_Date[2] . '-' . $select_his_Date[1] . '-' . $select_his_Date[0];




    $Q1 = " SELECT
                his.ID,
                his.IsStatus,
                his.HnCode,
                his.number_box,
                DATE_FORMAT( his.createAt, '%d-%m-%Y' ) AS createAt,
                his.createAt,
                his.doctor,
                his.departmentroomid,
                his.`procedure`,
                doctor.Doctor_Name,
                IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                departmentroom.departmentroomname
            FROM
                his
                INNER JOIN doctor ON doctor.ID = his.doctor
                LEFT JOIN `procedure` ON his.`procedure` = `procedure`.ID
                INNER JOIN departmentroom ON his.departmentroomid = departmentroom.id 
                AND DATE( his.createAt ) = '$select_his_Date'
                AND  ( his.isStatus = 1 OR his.isStatus = 2 ) ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {

        $_HnCode = $rowQ1['HnCode'];
        if ($_HnCode == "") {
            $rowQ1['HnCode'] = $rowQ1['number_box'];
        }


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

function set_his($conn, $db)
{

    $return = array();
    $Q1 = "SELECT
                his.ID 
            FROM
                his 
            WHERE
                his.IsStatus = 0 ";
    $meQuery = $conn->prepare($Q1);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;

        $ID = $row['ID'];

        $Q2 = "UPDATE his SET isStatus = 1 WHERE his.ID = $ID ";
        $meQuery2 = $conn->prepare($Q2);
        $meQuery2->execute();
    }


    echo json_encode($return);
    unset($conn);
    die;
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
    $check_Box = $_POST['check_Box'];

    $select_date1_search = explode("-", $select_date1_search1);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];

    $select_type = $_POST['select_type'];

    $where_t = "";
    if ($select_type == 1) {
        $where_t = " AND  ( set_hn.isStatus = 0 OR set_hn.isStatus = 1 OR set_hn.isStatus = 2 )";
    }
    if ($select_type == 2) {
        $where_t = " AND set_hn.isStatus = 3 ";
    }


    $whereD = "";
    if($check_Box == 0){
        $whereD = " AND DATE( set_hn.createAt ) = '$select_date1_search'  ";
    }
    if($check_Box == 1){
        $whereD = " AND  ( set_hn.isStatus = 0 OR set_hn.isStatus = 1 OR set_hn.isStatus = 2 ) ";
    }
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
                $whereD
                AND NOT set_hn.isStatus = 9
                AND  set_hn.isCancel = 0
                $where_t
            ORDER BY set_hn.isStatus ASC";

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
