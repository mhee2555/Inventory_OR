<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_deproom_pay') {
        show_detail_deproom_pay($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_item_ByDocNo') {
        show_detail_item_ByDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_pay') {
        oncheck_pay($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_Returnpay') {
        oncheck_Returnpay($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_history') {
        show_detail_history($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'cancel_item_byDocNo') {
        cancel_item_byDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateService') {
        updateService($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkClaim') {
        checkClaim($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateClaim') {
        updateClaim($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddataClaim') {
        feeddataClaim($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkClaimReturn') {
        checkClaimReturn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateClaimReturn') {
        updateClaimReturn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkNSterile') {
        checkNSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onSendNsterile') {
        onSendNsterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkNSterileClaim') {
        checkNSterileClaim($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'check_stataus') {
        check_stataus($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'search_hn') {
        search_hn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_pay_rfid') {
        oncheck_pay_rfid($conn, $db);
    }
}

function search_hn($conn, $db)
{
    $return = array();
    $input_use_main = $_POST['input'];
    $deproom = $_SESSION['deproom'];


    if ($db == 1) {
        $query = "SELECT
                    hncode.HnCode,
                    DATE_FORMAT(HnCode.DocDate, '%d/%m/%Y') AS DocDate,
                    departmentroom.departmentroomname
                FROM
                    deproomdetailsub
                INNER JOIN
                    hncode ON hncode.HnCode = deproomdetailsub.hn_record_id
                INNER JOIN
                    itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                INNER JOIN
                    departmentroom ON departmentroom.id = hncode.departmentroomid
                WHERE
                    itemstock.UsageCode = '$input_use_main'
                ORDER BY
                    deproomdetailsub.ID DESC
                LIMIT 1 ";
    } else {
        $query = "SELECT
                        TOP 1 hncode.HnCode,
                        FORMAT ( HnCode.DocDate, 'dd/MM/yyyy' ) AS DocDate,
                        departmentroom.departmentroomname 
                    FROM
                        deproomdetailsub
                        INNER JOIN hncode ON hncode.HnCode = deproomdetailsub.hn_record_id
                        INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                        INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid 
                    WHERE
                        itemstock.UsageCode = '$input_use_main' 
                    ORDER BY
                        deproomdetailsub.ID DESC ";
    }




    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function onSendNsterile($conn, $db)
{
    $return = [];

    if ($db == 1) {
        $query = " SELECT
                        itemstock.RowID,
                        itemstock.UsageCode,
                        itemstock.ItemCode,
                        itemstock.departmentroomid
                    FROM
                        itemstock
                    LEFT JOIN
                        item ON item.itemcode = itemstock.ItemCode
                    WHERE
                        itemstock.IsCancel = 0
                        AND itemstock.IsClaim = 1
                    ORDER BY
                        item.itemname,
                        DATE_FORMAT(itemstock.ExpireDate, '%d/%m/%Y') ASC ";
    } else {
        $query = " SELECT
                        itemstock.RowID,
                        itemstock.UsageCode,
                        itemstock.ItemCode,
                        itemstock.departmentroomid
                    FROM
                        itemstock
                        LEFT JOIN item ON item.itemcode = itemstock.ItemCode 
                    WHERE
                            itemstock.IsCancel = 0 
                        AND itemstock.IsClaim = 1
                    ORDER BY
                        item.itemname,
                        FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' ) ASC ";
    }

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_UsageCode = $row['UsageCode'];
        $RowID = $row['RowID'];

        $update = "UPDATE itemstock SET itemstock.IsDeproom = 6 , itemstock.IsClaim =  2 WHERE itemstock.RowID = '$RowID' ";
        $meQueryupdate = $conn->prepare($update);
        $meQueryupdate->execute();

        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function checkNSterileClaim($conn, $db)
{


    $where1 = "";


    $query = "SELECT COUNT( itemstock.RowID ) AS qty 
                    FROM
                        itemstock
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    WHERE
                        itemstock.Isdeproom = 6 
                        AND item.itemtypeID  = 44 
                        AND ( itemstock.IsClaim  =  0  OR itemstock.IsClaim IS NULL )
                        AND ( itemstock.IsCross = 0 OR itemstock.IsCross = 1 OR itemstock.IsCross IS NULL )  ";


    // AND itemstock.RowID IN (  $subItemStockID  ) 

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
function checkNSterile($conn, $db)
{


    $where1 = "";

    $where1 = "	 AND ( itemstock.IsCross = 0 OR itemstock.IsCross = 1  )";

    $query = "SELECT COUNT(itemstock.RowID) AS qty
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 	
                WHERE
                    itemstock.Isdeproom = 6
                    AND item.itemtypeID  = 44
                    $where1 ";
    // AND itemstock.RowID IN (  $subItemStockID  ) 

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function updateClaimReturn($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    if ($db == 1) {
        $update1 = "UPDATE itemstock SET  itemstock.IsClaim = null WHERE itemstock.UsageCode = '$UsageCode' LIMIT 1 ";
    } else {
        $update1 = "UPDATE TOP (1) itemstock SET  itemstock.IsClaim = null WHERE itemstock.UsageCode = '$UsageCode' ";
    }
    $meQuery1 = $conn->prepare($update1);
    $meQuery1->execute();

    unset($conn);
    die;
}
function checkClaimReturn($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    $return = [];

    if ($db == 1) {
        $query = " SELECT 
                        itemstock.UsageCode
                    FROM
                        itemstock
                    WHERE
                            itemstock.IsClaim = 1 
                        AND itemstock.UsageCode = '$UsageCode' LIMIT 1 ";
    } else {
        $query = " SELECT TOP 1
                        itemstock.UsageCode
                    FROM
                        itemstock
                    WHERE
                            itemstock.IsClaim = 1 
                        AND itemstock.UsageCode = '$UsageCode'  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddataClaim($conn, $db)
{
    $DepID = $_SESSION['DepID'];

    $return = [];

    if ($db == 1) {
        $query = " SELECT
                        item.itemname,
                        item.itemcode,
                        '1' AS cnt,
                        itemstock.UsageCode
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    WHERE
                        itemstock.IsClaim = 1
                    GROUP BY
                        itemstock.UsageCode,
                        item.itemname,
                        item.itemcode,
                        DATE_FORMAT(itemstock.ExpireDate, '%d/%m/%Y')  ";
    } else {
        $query = "SELECT
                        item.itemname,
                        item.itemcode,
                        '1' AS cnt,
                        itemstock.UsageCode
                    FROM
                        itemstock
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    WHERE
                        itemstock.IsClaim = 1
                        GROUP BY
                        itemstock.UsageCode,
                        item.itemname,
                        item.itemcode,
                        FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' )   ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function updateClaim($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    if ($db == 1) {
        $update1 = "UPDATE itemstock SET  itemstock.IsClaim = 1 WHERE itemstock.UsageCode = '$UsageCode' LIMIT 1 ";
    } else {
        $update1 = "UPDATE TOP (1) itemstock SET  itemstock.IsClaim = 1 WHERE itemstock.UsageCode = '$UsageCode' ";
    }
    $meQuery1 = $conn->prepare($update1);
    $meQuery1->execute();

    unset($conn);
    die;
}


function checkClaim($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    $return = [];

    if ($db == 1) {
        $query = "SELECT 
                        itemstock.UsageCode
                    FROM
                        itemstock
                    WHERE
                            itemstock.Isdeproom IN (0,1)
                        AND  ( itemstock.IsClaim IS NULL  OR itemstock.IsClaim = 0 )
                        AND itemstock.UsageCode = '$UsageCode' LIMIT 1 ";
    } else {
        $query = "SELECT TOP 1
                        itemstock.UsageCode
                    FROM
                        itemstock
                    WHERE
                            itemstock.Isdeproom IN (0,1)
                        AND  ( itemstock.IsClaim IS NULL  OR itemstock.IsClaim = 0 )
                        AND itemstock.UsageCode = '$UsageCode'  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function updateService($conn, $db)
{
    $return = array();
    $DocNo_pay = $_POST['DocNo_pay'];
    $input_date_service = $_POST['input_date_service'];
    $input_time_service = $_POST['input_time_service'];



    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    $sql1 = " UPDATE deproom SET serviceDate = '$input_date_service $input_time_service'  WHERE DocNo = '$DocNo_pay' ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();


    echo json_encode($DocNo_pay);
    unset($conn);
    die;
}

function cancel_item_byDocNo($conn, $db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];


    if ($db == 1) {
        $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = NOW()  WHERE DocNo = '$txt_docno_request' ";
    } else {
        $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = GETDATE()  WHERE DocNo = '$txt_docno_request' ";
    }

    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();


    $sql2 = "UPDATE itemstock  SET Isdeproom = 0 ,  departmentroomid = '35'  WHERE RowID IN (   SELECT
                                                                                                    deproomdetailsub.ItemStockID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                WHERE deproomdetail.DocNo = '$txt_docno_request'  ) ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();


    $sql3 = " DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID IN ( SELECT
                                                                                deproomdetailsub.ID 
                                                                            FROM
                                                                                deproomdetail
                                                                                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                            WHERE deproomdetail.DocNo = '$txt_docno_request'  )  ";
    $meQuery3 = $conn->prepare($sql3);
    $meQuery3->execute();

    $sql4 = " DELETE FROM deproomdetail WHERE DocNo = '$txt_docno_request' ";
    $meQuery4 = $conn->prepare($sql4);
    $meQuery4->execute();





    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}

function show_detail_history($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_date_history_s = $_POST['select_date_history_s'];
    $select_date_history_l = $_POST['select_date_history_l'];
    $select_deproom_history = $_POST['select_deproom_history'];
    $select_doctor_history = $_POST['select_doctor_history'];
    $select_procedure_history = $_POST['select_procedure_history'];

    $select_date_history_s = explode("-", $select_date_history_s);
    $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

    $select_date_history_l = explode("-", $select_date_history_l);
    $select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];


    if ($db == 1) {

        $whereD = "";
        if ($select_doctor_history != "") {
            $whereD = " AND deproom.doctor = '$select_doctor_history'";
        }
        $whereP = "";
        if ($select_procedure_history != "") {
            $whereP = " AND deproom.`procedure` = '$select_procedure_history' ";
        }
        $whereR = "";
        if ($select_deproom_history != "") {
            $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
        }



        $query = " SELECT
                        deproom.DocNo,
                        DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,                        
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark
                    FROM
                        deproom
                    INNER JOIN
                        doctor ON doctor.ID = deproom.doctor
                    LEFT JOIN
                        `procedure` ON deproom.procedure = `procedure`.ID
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    WHERE
                        DATE(deproom.CreateDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
                        AND deproom.IsCancel = 0
                        $whereD
                        $whereP
                        $whereR ";
    } else {

        $whereD = "";
        if ($select_doctor_history != "") {
            $whereD = " AND deproom.doctor = '$select_doctor_history'";
        }
        $whereP = "";
        if ($select_procedure_history != "") {
            $whereP = " AND deproom.[procedure] = '$select_procedure_history' ";
        }
        $whereR = "";
        if ($select_deproom_history != "") {
            $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
        }



        $query = " SELECT
                        deproom.DocNo,
                        FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        [procedure].Procedure_TH,
                        departmentroom.departmentroomname ,
                        doctor.ID AS doctor_ID,
                        [procedure].ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark
                    FROM
                        deproom
                        INNER JOIN dbo.doctor ON doctor.ID = deproom.doctor
                        INNER JOIN dbo.[procedure] ON deproom.[procedure] = [procedure].ID
                        INNER JOIN dbo.departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
                    WHERE
                        CONVERT(DATE,deproom.CreateDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
                        AND deproom.IsCancel = 0
                        $whereD
                        $whereP
                        $whereR ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function oncheck_Returnpay($conn, $db)
{
    $return = array();
    $input_returnpay = $_POST['input_returnpay'];
    $select_date_pay = $_POST['select_date_pay'];
    $input_date_service = $_POST['input_date_service'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];


    $select_date_pay = explode("-", $select_date_pay);
    $select_date_pay = $select_date_pay[2] . '-' . $select_date_pay[1] . '-' . $select_date_pay[0];

    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    itemstock
                WHERE  itemstock.UsageCode = '$input_returnpay' AND itemstock.Isdeproom = '1' ";


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
	                        deproomdetail.ItemCode
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                            INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                        WHERE
                            deproomdetailsub.ItemStockID = '$_RowID' 
                            AND deproomdetail.DocNo = '$DocNo_pay'
                            AND hncode_detail.ItemStockID = '$_RowID' ";
            // echo $query_2;
            // exit;
            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                $return[] = $row_2;

                $_ID = $row_2['ID'];
                $_hndetail_ID = $row_2['hndetail_ID'];

                // ==============================
                $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
                $meQueryD1 = $conn->prepare($queryD1);
                $meQueryD1->execute();

                $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
                $meQueryD2 = $conn->prepare($queryD2);
                $meQueryD2->execute();
                // ==============================

                // =======================================================================================================================================

                if ($db == 1) {
                    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND DATE(CreateDate) = '$input_date_service' ";
                } else {
                    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND CONVERT(DATE,CreateDate) = '$input_date_service' ";
                }

                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================



                $queryUpdate = "UPDATE itemstock 
                SET Isdeproom = 0 ,
                departmentroomid = '35'
                WHERE
                RowID = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================
                $count_itemstock++;
            }
        }
    }

    if ($count_itemstock == 0) {
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    } else {
        echo json_encode($return);
        unset($conn);
        die;
    }
}

function check_stataus($conn, $db)
{
    $input_pay = $_POST['input_pay'];
    $return = array();

    if ($db == 1) {
        $query = " SELECT
                        itemstock.Isdeproom,
                        IF(DATE(itemstock.ExpireDate) <= CURDATE(), 'exp', 'no_exp') AS check_exp
                    FROM
                        itemstock
                    WHERE
                        itemstock.UsageCode = '$input_pay' ";
    } else {
        $query = " SELECT
                        itemstock.Isdeproom,
                        IIF ( CONVERT ( DATE, itemstock.ExpireDate ) <= CONVERT ( DATE, GETDATE( ) ), 'exp', 'no_exp' ) AS check_exp
                    FROM
                        itemstock
                    WHERE  itemstock.UsageCode = '$input_pay'  ";
    }

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}



function oncheck_pay_rfid($conn, $db)
{
    $return = array();
    $DocNo_pay = $_POST['DocNo_pay'];
    $hncode = $_POST['hncode'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $input_date_service = $_POST['input_date_service'];

    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    if ($db == 1) {
        $query_1 = "SELECT
                        itemstock.ItemCode,
                        itemstock.Isdeproom,
                        itemstock.RowID ,
                        itemstock.UsageCode 
                    FROM
                        itemstock 
                    WHERE
                        itemstock.departmentroomid = '35' 
                        AND itemstock.Isdeproom = '0' 
                        AND itemstock.HNCode = '$hncode' ";
    } else {
        $query_1 = "  SELECT
                            itemstock.ItemCode,
                            itemstock.Isdeproom,
                            itemstock.departmentroomid ,
                            itemstock.RowID,
                            IIF ( CONVERT ( DATE, itemstock.ExpireDate ) <= CONVERT ( DATE, GETDATE( ) ), 'exp', 'no_exp' ) AS check_exp
                        FROM
                            itemstock
                        WHERE    itemstock.departmentroomid = '35' 
                            AND itemstock.Isdeproom = '0' 
                            AND itemstock.ExpireDate > GETDATE()
                            AND (itemstock.IsDamage IS NULL OR  itemstock.IsDamage = 0 )
                            AND (itemstock.IsClaim IS NULL OR  itemstock.IsClaim = 0 ) ";
    }


    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_RowID =  $row_1['RowID'];
        $input_pay =  $row_1['UsageCode'];

        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {

            if ($db == 1) {
                $query_2 = "SELECT
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid AS departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode,
                                deproomdetail.Qty ,
                                deproomdetail.PayDate ,
                                COUNT(deproomdetailsub.ID)  AS cnt_sub
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay'
                            GROUP BY
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode ,
                                deproomdetail.Qty,
                                deproomdetail.PayDate ";
            } else {
                $query_2 = "SELECT
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid AS departmentroomid,
                                deproom.[procedure],
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode,
                                deproomdetail.Qty ,
                                deproomdetail.PayDate ,
                                COUNT(deproomdetailsub.ID)  AS cnt_sub
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay'
                            GROUP BY
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid,
                                deproom.[procedure],
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode ,
                                deproomdetail.Qty,
                                deproomdetail.PayDate ";
            }

            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                $return[] = $row_2;

                $_ID = $row_2['ID'];
                $_PayDate = $row_2['PayDate'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_Qty_detail = $row_2['Qty'];
                $_Qty_detail_sub = $row_2['cnt_sub'];
                // ==============================

            if ($db == 1) {
                $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    `procedure`
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$_departmentroomid',
                                    1, 
                                    1, 
                                    NOW(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure'
                                ) ";
            }else{
                $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    [procedure]
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$_departmentroomid',
                                    1, 
                                    1, 
                                    GETDATE(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure'
                                ) ";
            }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1) ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================


                // ==============================
                $queryUpdate = "UPDATE itemstock 
                    SET Isdeproom = 1 ,
                    departmentroomid = '$_departmentroomid'
                    WHERE
                    RowID = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================
                if ($db == 1) {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }else{
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }



                // echo $queryInsert2;
                // exit;
                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
                $count_itemstock++;

                $count_new_item++;
            }


            if ($count_new_item  == 0) {

                if ($db == 1) {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                    VALUES
                        ( '$DocNo_pay', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";
                }else{
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                    VALUES
                        ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
                }




                $meQueryInsert = $conn->prepare($queryInsert);
                $meQueryInsert->execute();


                if ($db == 1) {
                    $query_2 = "SELECT
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid AS departmentroomid,
                                    deproom.`procedure`,
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty ,
                                    deproomdetail.PayDate ,
                                    COUNT(deproomdetailsub.ID )  AS cnt_sub
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                WHERE
                                    deproomdetail.ItemCode = '$_ItemCode' 
                                    AND deproomdetail.DocNo = '$DocNo_pay'
                                GROUP BY
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid,
                                    deproom.`procedure`,
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode ,
                                    deproomdetail.Qty,
                                    deproomdetail.PayDate ";
                }else{
                    $query_2 = "SELECT
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid AS departmentroomid,
                                    deproom.[procedure],
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty ,
                                    deproomdetail.PayDate ,
                                    COUNT(deproomdetailsub.ID )  AS cnt_sub
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                WHERE
                                    deproomdetail.ItemCode = '$_ItemCode' 
                                    AND deproomdetail.DocNo = '$DocNo_pay'
                                GROUP BY
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid,
                                    deproom.[procedure],
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode ,
                                    deproomdetail.Qty,
                                    deproomdetail.PayDate ";
                }

                $meQuery_2 = $conn->prepare($query_2);
                $meQuery_2->execute();
                while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                    $return[] = $row_2;

                    $_ID = $row_2['ID'];
                    $_PayDate = $row_2['PayDate'];
                    $_departmentroomid = $row_2['departmentroomid'];
                    $_procedure = $row_2['procedure'];
                    $_hn_record_id = $row_2['hn_record_id'];
                    $_doctor = $row_2['doctor'];
                    $_Qty_detail = $row_2['Qty'];
                    $_Qty_detail_sub = $row_2['cnt_sub'];

                    // if($_Qty_detail == $_Qty_detail_sub){

                    //     $updateD = "UPDATE deproomdetail SET Qty = Qty+1 WHERE deproomdetail.ID = '$_ID'  ";
                    //     $queryupdateD = $conn->prepare($updateD);
                    //     $queryupdateD->execute();

                    //     $count_itemstock = 1;
                    //     echo json_encode($count_itemstock);
                    //     unset($conn);
                    //     die;
                    // }

                    // ==============================

                    if ($db == 1) {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            `procedure`
                                        )
                                        VALUES
                                        (
                                            '$_ID', 
                                            '$_RowID',
                                            '$_departmentroomid',
                                            1, 
                                            1, 
                                            NOW(), 
                                            '$_hn_record_id', 
                                            '$_doctor', 
                                            '$_procedure'
                                        ) ";
                    }else{
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            [procedure]
                                        )
                                        VALUES
                                        (
                                            '$_ID', 
                                            '$_RowID',
                                            '$_departmentroomid',
                                            1, 
                                            1, 
                                            GETDATE(), 
                                            '$_hn_record_id', 
                                            '$_doctor', 
                                            '$_procedure'
                                        ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1) ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();
                    // =======================================================================================================================================


                    $queryUpdate = "UPDATE itemstock 
                        SET Isdeproom = 1 ,
                        departmentroomid = '$_departmentroomid'
                        WHERE
                        RowID = '$_RowID' ";
                    $meQueryUpdate = $conn->prepare($queryUpdate);
                    $meQueryUpdate->execute();
                    // ==============================

                    if ($db == 1) {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }else{
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }
 

                    // echo $queryInsert2;
                    // exit;
                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                    $count_itemstock++;

                    $count_new_item++;



                    $count_itemstock = 2;
                    echo json_encode($count_itemstock);
                    unset($conn);
                    die;
                }
            }


            $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$DocNo_pay' ";
            $meQueryPay = $conn->prepare($updatePay);
            $meQueryPay->execute();
        }
    }



    if ($count_itemstock == 0) {
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    } else {
        echo json_encode($return);
        unset($conn);
        die;
    }
}

function oncheck_pay($conn, $db)
{
    $return = array();
    $input_pay = $_POST['input_pay'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $hncode = $_POST['hncode'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $input_date_service = $_POST['input_date_service'];

    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    if ($db == 1) {
        $query_1 = " SELECT
                            itemstock.ItemCode,
                            itemstock.Isdeproom,
                            itemstock.departmentroomid,
                            itemstock.RowID,
                            IF(DATE(itemstock.ExpireDate) <= CURDATE(), 'exp', 'no_exp') AS check_exp
                        FROM
                            itemstock
                        WHERE
                            itemstock.UsageCode = '$input_pay'
                            AND itemstock.departmentroomid = '35'
                            AND itemstock.Isdeproom = '0'
                            AND itemstock.ExpireDate > CURDATE()
                            AND (itemstock.IsDamage IS NULL OR itemstock.IsDamage = 0)
                            AND (itemstock.IsClaim IS NULL OR itemstock.IsClaim = 0) ";
    } else {
        $query_1 = "  SELECT
                            itemstock.ItemCode,
                            itemstock.Isdeproom,
                            itemstock.departmentroomid ,
                            itemstock.RowID,
                            IIF ( CONVERT ( DATE, itemstock.ExpireDate ) <= CONVERT ( DATE, GETDATE( ) ), 'exp', 'no_exp' ) AS check_exp
                        FROM
                            itemstock
                        WHERE  itemstock.UsageCode = '$input_pay' 
                            AND itemstock.departmentroomid = '35' 
                            AND itemstock.Isdeproom = '0' 
                            AND itemstock.ExpireDate > GETDATE()
                            AND (itemstock.IsDamage IS NULL OR  itemstock.IsDamage = 0 )
                            AND (itemstock.IsClaim IS NULL OR  itemstock.IsClaim = 0 ) ";
    }


    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];

        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {

            if ($db == 1) {
                $query_2 = "SELECT
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid AS departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode,
                                deproomdetail.Qty ,
                                deproomdetail.PayDate ,
                                COUNT(deproomdetailsub.ID)  AS cnt_sub
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay'
                            GROUP BY
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode ,
                                deproomdetail.Qty,
                                deproomdetail.PayDate ";
            } else {
                $query_2 = "SELECT
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid AS departmentroomid,
                                deproom.[procedure],
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode,
                                deproomdetail.Qty ,
                                deproomdetail.PayDate ,
                                COUNT(deproomdetailsub.ID)  AS cnt_sub
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay'
                            GROUP BY
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid,
                                deproom.[procedure],
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode ,
                                deproomdetail.Qty,
                                deproomdetail.PayDate ";
            }

            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                $return[] = $row_2;

                $_ID = $row_2['ID'];
                $_PayDate = $row_2['PayDate'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_Qty_detail = $row_2['Qty'];
                $_Qty_detail_sub = $row_2['cnt_sub'];
                // ==============================

            if ($db == 1) {
                $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    `procedure`
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$_departmentroomid',
                                    1, 
                                    1, 
                                    NOW(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure'
                                ) ";
            }else{
                $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    [procedure]
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$_departmentroomid',
                                    1, 
                                    1, 
                                    GETDATE(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure'
                                ) ";
            }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1) ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================


                // ==============================
                $queryUpdate = "UPDATE itemstock 
                    SET Isdeproom = 1 ,
                    departmentroomid = '$_departmentroomid'
                    WHERE
                    RowID = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================
                if ($db == 1) {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }else{
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }



                // echo $queryInsert2;
                // exit;
                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
                $count_itemstock++;

                $count_new_item++;
            }


            if ($count_new_item  == 0) {

                if ($db == 1) {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                    VALUES
                        ( '$DocNo_pay', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";
                }else{
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                    VALUES
                        ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
                }




                $meQueryInsert = $conn->prepare($queryInsert);
                $meQueryInsert->execute();


                if ($db == 1) {
                    $query_2 = "SELECT
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid AS departmentroomid,
                                    deproom.`procedure`,
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty ,
                                    deproomdetail.PayDate ,
                                    COUNT(deproomdetailsub.ID )  AS cnt_sub
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                WHERE
                                    deproomdetail.ItemCode = '$_ItemCode' 
                                    AND deproomdetail.DocNo = '$DocNo_pay'
                                GROUP BY
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid,
                                    deproom.`procedure`,
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode ,
                                    deproomdetail.Qty,
                                    deproomdetail.PayDate ";
                }else{
                    $query_2 = "SELECT
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid AS departmentroomid,
                                    deproom.[procedure],
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty ,
                                    deproomdetail.PayDate ,
                                    COUNT(deproomdetailsub.ID )  AS cnt_sub
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                WHERE
                                    deproomdetail.ItemCode = '$_ItemCode' 
                                    AND deproomdetail.DocNo = '$DocNo_pay'
                                GROUP BY
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid,
                                    deproom.[procedure],
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode ,
                                    deproomdetail.Qty,
                                    deproomdetail.PayDate ";
                }

                $meQuery_2 = $conn->prepare($query_2);
                $meQuery_2->execute();
                while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                    $return[] = $row_2;

                    $_ID = $row_2['ID'];
                    $_PayDate = $row_2['PayDate'];
                    $_departmentroomid = $row_2['departmentroomid'];
                    $_procedure = $row_2['procedure'];
                    $_hn_record_id = $row_2['hn_record_id'];
                    $_doctor = $row_2['doctor'];
                    $_Qty_detail = $row_2['Qty'];
                    $_Qty_detail_sub = $row_2['cnt_sub'];

                    // if($_Qty_detail == $_Qty_detail_sub){

                    //     $updateD = "UPDATE deproomdetail SET Qty = Qty+1 WHERE deproomdetail.ID = '$_ID'  ";
                    //     $queryupdateD = $conn->prepare($updateD);
                    //     $queryupdateD->execute();

                    //     $count_itemstock = 1;
                    //     echo json_encode($count_itemstock);
                    //     unset($conn);
                    //     die;
                    // }

                    // ==============================

                    if ($db == 1) {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            [procedure]
                                        )
                                        VALUES
                                        (
                                            '$_ID', 
                                            '$_RowID',
                                            '$_departmentroomid',
                                            1, 
                                            1, 
                                            NOW(), 
                                            '$_hn_record_id', 
                                            '$_doctor', 
                                            '$_procedure'
                                        ) ";
                    }else{
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            [procedure]
                                        )
                                        VALUES
                                        (
                                            '$_ID', 
                                            '$_RowID',
                                            '$_departmentroomid',
                                            1, 
                                            1, 
                                            GETDATE(), 
                                            '$_hn_record_id', 
                                            '$_doctor', 
                                            '$_procedure'
                                        ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1) ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();
                    // =======================================================================================================================================


                    $queryUpdate = "UPDATE itemstock 
                        SET Isdeproom = 1 ,
                        departmentroomid = '$_departmentroomid'
                        WHERE
                        RowID = '$_RowID' ";
                    $meQueryUpdate = $conn->prepare($queryUpdate);
                    $meQueryUpdate->execute();
                    // ==============================

                    if ($db == 1) {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }else{
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }
 

                    // echo $queryInsert2;
                    // exit;
                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                    $count_itemstock++;

                    $count_new_item++;



                    $count_itemstock = 2;
                    echo json_encode($count_itemstock);
                    unset($conn);
                    die;
                }
            }


            $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$DocNo_pay' ";
            $meQueryPay = $conn->prepare($updatePay);
            $meQueryPay->execute();
        }
    }



    if ($count_itemstock == 0) {
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    } else {
        echo json_encode($return);
        unset($conn);
        die;
    }
}

function show_detail_item_ByDocNo($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM(deproomdetail.Qty) AS cnt ,
                (
									SELECT COUNT(deproomdetailsub.ID) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
				) AS cnt_pay,
                itemtype.TyeName
            FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
                INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
            WHERE
                deproom.DocNo = '$DocNo' 
                AND deproom.IsCancel = 0 
                AND deproomdetail.IsCancel = 0 
            GROUP BY
                item.itemname,
                item.itemcode,
                deproomdetail.ID ,
                itemtype.TyeName 
            ORDER BY item.itemname ASC ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_deproom_pay($conn, $db)
{
    $return = array();
    $select_deproom_pay = $_POST['select_deproom_pay'];
    $select_date_pay = $_POST['select_date_pay'];

    $select_date_pay = explode("-", $select_date_pay);
    $select_date_pay = $select_date_pay[2] . '-' . $select_date_pay[1] . '-' . $select_date_pay[0];

    $whereDep = "";
    if ($select_deproom_pay != "") {
        $whereDep = "AND deproom.Ref_departmentroomid = '$select_deproom_pay' ";
    }
    if ($db == 1) {
        $query = " SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname
                    FROM
                        deproom
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    WHERE
                        DATE(deproom.CreateDate) = '$select_date_pay'
                        $whereDep
                        AND deproom.IsCancel = 0
                    GROUP BY
                        departmentroom.id,
                        departmentroom.departmentroomname ";
    }else{
        $query = " SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname 
                    FROM
                        deproom
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
                    WHERE
                        CONVERT(DATE,deproom.CreateDate) =  '$select_date_pay' 
                        $whereDep
                        AND deproom.IsCancel = 0
                    GROUP BY
                        departmentroom.id,
                        departmentroom.departmentroomname  ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['departmentroomname'][] = $row;
        $_id = $row['id'];


        if ($db == 1) {
            $query_sub = "SELECT
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,
                            deproom.hn_record_id,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
                            DATE_FORMAT(deproom.serviceDate, '%H:%i') AS serviceTime,
                            SUM(deproomdetail.Qty) AS cnt_detail,
                            (
                                SELECT COUNT(deproomdetailsub.ID)
                                FROM deproomdetailsub
                                INNER JOIN deproomdetail ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                                WHERE deproomdetail.DocNo = deproom.DocNo
                            ) AS cnt_sub
                        FROM
                            deproom
                        INNER JOIN
                            deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        INNER JOIN
                            departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        INNER JOIN
                            doctor ON deproom.doctor = doctor.ID
                        LEFT JOIN
                            `procedure` ON deproom.`procedure` = `procedure`.ID
                        WHERE
                            departmentroom.id = '$_id'
                            AND deproom.IsCancel = 0
                            AND DATE(deproom.CreateDate) = '$select_date_pay'
                        GROUP BY
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            `procedure`.Procedure_TH,
                            deproom.hn_record_id,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y'),
                            DATE_FORMAT(deproom.serviceDate, '%H:%i') ";
        }else{
            $query_sub = "SELECT
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            [procedure].Procedure_TH,
                            deproom.hn_record_id ,
                            FORMAT(deproom.serviceDate , 'dd-MM-yyyy' ) AS serviceDate ,
                            FORMAT(deproom.serviceDate , 'HH:mm' ) AS serviceTime ,
                            SUM ( deproomdetail.Qty ) AS cnt_detail,		
                            (

                                SELECT COUNT
                                    ( deproomdetailsub.ID ) 
                                FROM
                                    deproomdetailsub
                                    INNER JOIN deproomdetail ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID 
                                WHERE
                                    deproomdetail.DocNo = deproom.DocNo

                            
                            ) AS cnt_sub
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                            INNER JOIN doctor ON deproom.doctor = doctor.ID
                            INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID 
                        WHERE 
                        departmentroom.id = '$_id'  
                        AND deproom.IsCancel = 0  
                        AND CONVERT(DATE,deproom.CreateDate) =  '$select_date_pay' 
                        GROUP BY
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            [procedure].Procedure_TH,
                            deproom.hn_record_id ,
                            FORMAT ( deproom.serviceDate , 'dd-MM-yyyy' ),
                            FORMAT(deproom.serviceDate , 'HH:mm' ) ";
        }


        $meQuery_sub = $conn->prepare($query_sub);
        $meQuery_sub->execute();
        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {
            $return[$_id][] = $row_sub;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function oncheckpayauto($conn, $db)
{
    $QrCode = trim($_POST['QrCode']);
    $return = array();

    $checkquery = 0;

    $query = "SELECT TOP 1
                itemstock.departmentroomid,
                itemstock.Isdeproom,
                itemstock.UsageCode,
                itemstock.IsStatus,
                payoutdetailsub.Id,
                itemstock.RowId,
	            payoutdetail.DocNo
            FROM
                itemstock
                INNER JOIN item ON item.itemcode = itemstock.ItemCode
                LEFT JOIN deproomdetail ON item.itemcode = deproomdetail.ItemCode
                LEFT JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                INNER JOIN payoutdetailsub ON payoutdetailsub.ItemStockID = itemstock.RowId
                INNER JOIN payoutdetail ON payoutdetail.Id = payoutdetailsub.Payoutdetail_RowID
            WHERE
                itemstock.UsageCode = '$QrCode' 
                AND payoutdetailsub.IsStatus = 2
            GROUP BY
                itemstock.UsageCode,
                itemstock.departmentroomid,
                itemstock.Isdeproom,
                itemstock.IsStatus,
                payoutdetailsub.IsStatus,
                payoutdetailsub.Id,
	            payoutdetail.DocNo,
				itemstock.RowId ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }

    echo json_encode($return);
    unset($conn);
    die;
}
