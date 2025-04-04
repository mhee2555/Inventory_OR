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
    } else if ($_POST['FUNC_NAME'] == 'oncheck_pay_weighing') {
        oncheck_pay_weighing($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_Procedure') {
        showDetail_Procedure($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_Doctor') {
        showDetail_Doctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_pay_manual') {
        oncheck_pay_manual($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_Returnpay_manual') {
        oncheck_Returnpay_manual($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_pay_rfid_manual') {
        oncheck_pay_rfid_manual($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkScanReturn') {
        checkScanReturn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateReturn') {
        updateReturn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_waitReturn') {
        feeddata_waitReturn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onReturnData') {
        onReturnData($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_deproom') {
        showDetail_deproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_item_ByDocNo_manual') {
        show_detail_item_ByDocNo_manual($conn, $db);
    }
}


function showDetail_deproom($conn, $db)
{
    $return = array();
    $departmentroom_id = $_POST['departmentroom_id'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT departmentroom.id , departmentroom.departmentroomname FROM departmentroom WHERE departmentroom.id IN ($departmentroom_id) ";

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

function showDetail_Doctor($conn, $db)
{
    $return = array();
    $doctor = $_POST['doctor'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT doctor.ID , doctor.Doctor_Name FROM doctor WHERE doctor.ID IN ($doctor) ";

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


function showDetail_Procedure($conn, $db)
{
    $return = array();
    $procedure = $_POST['procedure'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT
                   `procedure`.ID , `procedure`.Procedure_TH 
                FROM
                    `procedure` 
                WHERE
                    `procedure`.ID IN ( $procedure ) ";

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


function feeddata_waitReturn($conn, $db)
{
    $DepID = $_SESSION['DepID'];

    $return = [];

    $query = " SELECT
                        item.itemname,
                        item.itemcode,
                        COUNT(itemstock.UsageCode) AS cnt
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    WHERE
                        itemstock.IsCross = 9
                    GROUP BY
	                    item.itemname  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}



function onReturnData($conn, $db)
{

    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    itemstock
                WHERE   itemstock.IsCross = 9 ";


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
	                        DATE(deproom.serviceDate) AS serviceDate
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
                $serviceDate = $row_2['serviceDate'];

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
                    AND DATE(CreateDate) = '$serviceDate' ";
                } else {
                    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND CONVERT(DATE,CreateDate) = '$serviceDate' ";
                }

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


function updateReturn($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    $update1 = "UPDATE itemstock SET  itemstock.IsCross = 9 WHERE itemstock.UsageCode = '$UsageCode' LIMIT 1 ";

    $meQuery1 = $conn->prepare($update1);
    $meQuery1->execute();

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



function checkScanReturn($conn, $db)
{

    $UsageCode = $_POST['UsageCode'];

    $return = [];

    $query = "SELECT 
                        itemstock.UsageCode
                    FROM
                        itemstock
                    WHERE
                            itemstock.Isdeproom = 1
                        AND  ( itemstock.IsCross IS NULL  OR itemstock.IsCross = 0 )
                        AND itemstock.UsageCode = '$UsageCode' LIMIT 1 ";



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
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
        $sql_hn = " UPDATE hncode SET IsCancel = 1 WHERE DocNo_SS = '$txt_docno_request' ";
    } else {
        $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = GETDATE()  WHERE DocNo = '$txt_docno_request' ";
        $sql_hn = " UPDATE hncode SET IsCancel = 1 WHERE DocNo_SS = '$txt_docno_request' ";
    }

    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();

    $meQuery_hn = $conn->prepare($sql_hn);
    $meQuery_hn->execute();

    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID IN (   SELECT
                                                                deproomdetailsub.ItemStockID 
                                                            FROM
                                                                deproomdetail
                                                                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                            WHERE deproomdetail.DocNo = '$txt_docno_request'  )
    AND departmentroomid = (SELECT Ref_departmentroomid FROM deproom WHERE deproom.DocNo = '$txt_docno_request'  ) 
    AND  IsStatus = '1'
    AND DATE(CreateDate) = (SELECT DATE(deproom.CreateDate) FROM deproom WHERE deproom.DocNo = '$txt_docno_request'  ) ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();


    $sql2 = "UPDATE itemstock  SET Isdeproom = 0 ,  departmentroomid = '35'  WHERE RowID IN (   SELECT
                                                                                                    deproomdetailsub.ItemStockID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                WHERE deproomdetail.DocNo = '$txt_docno_request'  ) ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();


    $sql3 = "DELETE deproomdetailsub
                FROM deproomdetailsub
            INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
            WHERE deproomdetail.DocNo = '$txt_docno_request' ";

    // $sql3 = " DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID IN ( SELECT
    //                                                                             deproomdetailsub.ID 
    //                                                                         FROM
    //                                                                             deproomdetail
    //                                                                             INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
    //                                                                         WHERE deproomdetail.DocNo = '$txt_docno_request'  )  ";

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


    $select_date_history_s = explode("-", $select_date_history_s);
    $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

    $select_date_history_l = explode("-", $select_date_history_l);
    $select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

    if (isset($_POST['select_doctor_history'])) {
        $select_doctor_history = $_POST['select_doctor_history'];
    }
    if (isset($_POST['select_procedure_history'])) {
        $select_procedure_history = $_POST['select_procedure_history'];
    }

    $whereP = "";
    if (isset($select_procedure_history)) {
        $select_procedure_history = implode(",", $select_procedure_history);
        $whereP = " AND  FIND_IN_SET('$select_procedure_history', deproom.`procedure`) ";
    }
    $whereD = "";
    if (isset($select_doctor_history)) {
        $select_doctor_history = implode(",", $select_doctor_history);
        $whereD = " AND  FIND_IN_SET('$select_doctor_history', deproom.`doctor`)  ";
    }


    if ($db == 1) {



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
                        deproom.Remark,
                        deproom.doctor ,
                        deproom.`procedure`
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

        // echo $query;
        // exit;

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
                        deproom.Remark,
                        deproom.doctor ,
                        deproom.`procedure`
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

        if (str_contains($row['procedure'], ',')) {
            $row['Procedure_TH'] = 'button';
        }
        if (str_contains($row['doctor'], ',')) {
            $row['Doctor_Name'] = 'button';
        }


        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function oncheck_pay_manual($conn, $db)
{
    $return = array();
    $input_pay_manual = $_POST['input_pay_manual'];
    $input_docNo_deproom_manual = $_POST['input_docNo_deproom_manual'];
    $input_docNo_HN_manual = $_POST['input_docNo_HN_manual'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];


    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $select_procedure_manual = implode(",", $select_procedure_manual);
    $select_doctor_manual = implode(",", $select_doctor_manual);

    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];


    $count = 0;
    $count_itemstock = 0;


    $count_itemstock++;


    $count_new_item_itemcode = 0;
    $check_barcode = 0;
    $qcheck = "SELECT
                    item.Barcode,
                    item.itemcode
                FROM
                    item
                WHERE
                    item.Barcode = '$input_pay_manual'  ";

    // echo $qcheck;
    // exit;
    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $check_barcode++;
    }

    if ($check_barcode > 0) {

        if ($input_docNo_deproom_manual == "") {
            $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
            $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $remark, 0, 0, 0, 0, '', '', '', $db);
            $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 0, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual);

            $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$input_date_service_manual $input_time_service_manual'  , hn_record_id = '$input_Hn_pay_manual' , doctor = '$select_doctor_manual' , `procedure` = '$select_procedure_manual' , Ref_departmentroomid = '$select_deproom_manual' WHERE DocNo = '$input_docNo_deproom_manual' AND IsCancel = 0 ";
            $meQueryUpdate = $conn->prepare($sql1);
            $meQueryUpdate->execute();
        }


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
                        deproomdetail.ItemCode = '$_itemcode' 
                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
                    GROUP BY
                        deproomdetail.ID,
                        deproom.Ref_departmentroomid,
                        deproom.`procedure`,
                        deproom.doctor,
                        deproom.hn_record_id,
                        deproomdetail.ItemCode ,
                        deproomdetail.Qty,
                        deproomdetail.PayDate ";
        $meQuery_2 = $conn->prepare($query_2);
        $meQuery_2->execute();
        while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

            $count_new_item_itemcode++;

            $_ID = $row_2['ID'];
            $_departmentroomid = $row_2['departmentroomid'];
            $_procedure = $row_2['procedure'];
            $_hn_record_id = $row_2['hn_record_id'];
            $_doctor = $row_2['doctor'];

            $queryInsert0 = "UPDATE deproomdetail SET Qty = Qty+1 WHERE  deproomdetail.ID = '$_ID' ";
            $meQuery0 = $conn->prepare($queryInsert0);
            $meQuery0->execute();

            $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                    Deproomdetail_RowID,
                                                    dental_warehouse_id,
                                                    IsStatus,
                                                    IsCheckPay,
                                                    PayDate,
                                                    hn_record_id,
                                                    doctor,
                                                    `procedure`,
                                                    itemcode_weighing,
                                                    qty_weighing
                                                )
                                                VALUES
                                                (
                                                    '$_ID', 
                                                    '$_departmentroomid',
                                                    1, 
                                                    1, 
                                                    NOW(), 
                                                    '$_hn_record_id', 
                                                    '$_doctor', 
                                                    '$_procedure', 
                                                    '$_itemcode', 
                                                    1
                                                ) ";
            $queryInsert1 = $conn->prepare($queryInsert1);
            $queryInsert1->execute();

            // =======================================================================================================================================
            $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                                        VALUES
                                        ( '0', '$_itemcode','$input_date_service_manual','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
            $meQuery = $conn->prepare($query);
            $meQuery->execute();
            // =======================================================================================================================================

            $queryInsert2 = "UPDATE hncode_detail SET Qty = Qty+1 WHERE  hncode_detail.ItemCode = '$_itemcode' AND DocNo = '$input_docNo_HN_manual' ";

            $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
            $query_updateHN = $conn->prepare($query_updateHN);
            $query_updateHN->execute();

            $queryInsert2 = $conn->prepare($queryInsert2);
            $queryInsert2->execute();
        }

        if ($count_new_item_itemcode  == 0) {
            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                VALUES
                    ( '$input_docNo_deproom_manual', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() )";

            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();


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
                                deproomdetail.ItemCode = '$_itemcode' 
                                AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
                            GROUP BY
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode ,
                                deproomdetail.Qty,
                                deproomdetail.PayDate ";
            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {
                $_ID = $row_2['ID'];
                $_PayDate = $row_2['PayDate'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_Qty_detail = $row_2['Qty'];
                $_Qty_detail_sub = $row_2['cnt_sub'];

                $queryInsert1 = "INSERT INTO deproomdetailsub (
                            Deproomdetail_RowID,
                            dental_warehouse_id,
                            IsStatus,
                            IsCheckPay,
                            PayDate,
                            hn_record_id,
                            doctor,
                            `procedure`,
                            itemcode_weighing,
                            qty_weighing
                        )
                        VALUES
                        (
                            '$_ID', 
                            '$_departmentroomid',
                            1, 
                            1, 
                            NOW(), 
                            '$_hn_record_id', 
                            '$_doctor', 
                            '$_procedure', 
                            '$_itemcode', 
                            1
                        ) ";

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                                        VALUES
                                        ( '0', '$_itemcode','$input_date_service_manual','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();

                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '-',
                                                    '$_itemcode'
                                                ) ";

                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'   ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();

                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
            }
        }
    }

    if ($check_barcode == 0) {
        $query = "        SELECT
                            itemstock.ItemCode,
                            itemstock.Isdeproom,
                            itemstock.RowID ,
                            itemstock.UsageCode,
                            itemstock.departmentroomid ,
                            CASE
                                    WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                    ELSE 'no_exp'
                                END AS check_exp
                        FROM
                            itemstock 
                        WHERE
                                itemstock.UsageCode = '$input_pay_manual' ";
        // AND itemstock.departmentroomid = '35' 
        // AND itemstock.Isdeproom = '0' 
        // AND itemstock.HNCode = '$input_Hn_pay_manual' ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {



            if ($input_docNo_deproom_manual == "") {
                $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
                $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $remark, 0, 0, 0, 0, '', '', '', $db);
                $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 0, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual);

                $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$input_date_service_manual $input_time_service_manual'  , hn_record_id = '$input_Hn_pay_manual' , doctor = '$select_doctor_manual' , `procedure` = '$select_procedure_manual' , Ref_departmentroomid = '$select_deproom_manual' WHERE DocNo = '$input_docNo_deproom_manual' AND IsCancel = 0 ";
                $meQueryUpdate = $conn->prepare($sql1);
                $meQueryUpdate->execute();
            }

            $_ItemCode = $row['ItemCode'];
            $_Isdeproom =  $row['Isdeproom'];
            $_departmentroomid =  $row['departmentroomid'];
            $_RowID =  $row['RowID'];

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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                            `procedure`,
                                            qty_weighing
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
                                            '$_procedure',
                                            1
                                        ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            [procedure],
                                            qty_weighing
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
                                            '$_procedure',
                                            1
                                        ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode )
                                VALUES
                                ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                                                    '$input_docNo_HN_manual', 
                                                    '$input_pay_manual',
                                                    '$_RowID',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                                    ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                                            (
                                                            '$input_docNo_HN_manual', 
                                                            '$input_pay_manual',
                                                            '$_RowID',
                                                            1, 
                                                            1, 
                                                            0, 
                                                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                                            ) ";
                    }


                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


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
                                            ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";
                    } else {
                        $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                                        VALUES
                                            ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
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
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub
                                    FROM
                                        deproomdetail
                                        INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                    WHERE
                                        deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                        $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];

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
                                            `procedure`,
                                            qty_weighing
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
                                                '$_procedure',
                                                1
                                            ) ";
                        } else {
                            $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                Deproomdetail_RowID,
                                                ItemStockID,
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                [procedure],
                                                qty_weighing
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
                                                '$_procedure',
                                                1
                                            ) ";
                        }

                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();
                        // ==============================

                        // =======================================================================================================================================
                        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty , hncode )
                                VALUES
                                ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                                    '$input_docNo_HN_manual',
                                    '$input_pay_manual',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";
                        } else {
                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                    (
                                    '$input_docNo_HN_manual',
                                    '$input_pay_manual',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";
                        }



                        $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                        $query_updateHN = $conn->prepare($query_updateHN);
                        $query_updateHN->execute();


                        // echo $queryInsert2;
                        // exit;
                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;

                        $count_new_item++;



                        $count_itemstock = 2;
                    }
                }


                $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
                $meQueryPay = $conn->prepare($updatePay);
                $meQueryPay->execute();
            }


            if ($_Isdeproom == 1) {

                $query_old = "SELECT
                                    deproomdetailsub.ID,
                                    deproomdetail.ID AS detailID,
                                    hncode_detail.ID AS hndetail_ID,
                                    deproomdetail.ItemCode,
                                    COUNT( deproomdetailsub.ID ) AS deproom_qty,
                                    COUNT(hncode_detail.ID ) AS hncode_qty,
                                    deproom.hn_record_id ,
                                    deproom.Ref_departmentroomid 
                                FROM
                                    deproom
                                    LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                    LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                    LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                                WHERE
                                    deproomdetail.ItemCode = '$_ItemCode' 
                                    AND hncode_detail.UsageCode = '$input_pay_manual' 

                                ORDER BY
                                    deproomdetailsub.ID DESC 
                                    LIMIT 1 ";

                // $query_old = " SELECT
                //                     deproomdetailsub.ID,
                //                     deproomdetail.ID AS detailID,
                //                     hncode_detail.ID AS hndetail_ID,
                //                     deproomdetail.ItemCode,
                //                     SUM( deproomdetail.Qty ) AS deproom_qty,
                //                     COUNT( hncode_detail.Qty ) AS hncode_qty ,
	            //                     deproom.hn_record_id
                //                 FROM
                //                     deproom
                //                     LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                //                     LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                //                     LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                //                     LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                //                 WHERE
                //                     deproomdetail.ItemCode = '$_ItemCode' 
                //                     AND hncode_detail.UsageCode = '$input_pay_manual'
                //                     ORDER BY deproomdetailsub.ID DESC
                //                     LIMIT 1 ";


                $meQuery_old = $conn->prepare($query_old);
                $meQuery_old->execute();
                while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                    $detailID = $row_old['detailID'];
                    $hndetail_ID = $row_old['hndetail_ID'];
                    $deproom_qty = $row_old['deproom_qty'];
                    $hncode_qty = $row_old['hncode_qty'];
                    $deproomdetailsub_id = $row_old['ID'];
                    $_hn_record_id_borrow = $row_old['hn_record_id'];
                    $_Ref_departmentroomid = $row_old['Ref_departmentroomid'];
                }


                // =======================================================================================================================================

                $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                AND ItemCode = '$_ItemCode' 
                AND departmentroomid = '$_Ref_departmentroomid' 
                AND  IsStatus = '1'
                AND DATE(CreateDate) = '$input_date_service_manual' ";

                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================


                // if ($deproom_qty == 1) {
                //     // $update_old_detail = "DELETE FROM deproomdetail WHERE ID =  '$detailID' ";
                //     // $meQuery_old_detail = $conn->prepare($update_old_detail);
                //     // $meQuery_old_detail->execute();

                // } else {
                //     // $update_old_detail = "UPDATE deproomdetail SET Qty = Qty-1 WHERE  deproomdetail.ID = '$detailID' ";
                //     // $meQuery_old_detail = $conn->prepare($update_old_detail);
                //     // $meQuery_old_detail->execute();

                //     $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'   ";
                //     $meQuery_old_sub = $conn->prepare($update_old_sub);
                //     $meQuery_old_sub->execute();
                // }


                
                $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                $meQuery_old_sub = $conn->prepare($update_old_sub);
                $meQuery_old_sub->execute();

                $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$hndetail_ID' ";
                $meQueryD2 = $conn->prepare($queryD2);
                $meQueryD2->execute();


                // if ($hncode_qty == 1) {

                // } else {
                //     $queryInsert0 = "UPDATE hncode_detail SET Qty = Qty-1 WHERE  ID =  '$hndetail_ID' ";
                //     $meQuery0 = $conn->prepare($queryInsert0);
                //     $meQuery0->execute();
                // }



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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
                                GROUP BY
                                    deproomdetail.ID,
                                    deproom.Ref_departmentroomid,
                                    deproom.`procedure`,
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode ,
                                    deproomdetail.Qty,
                                    deproomdetail.PayDate ";


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

                    $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            `procedure`,
                                            qty_weighing,
                                            hn_record_id_borrow
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
                                            '$_procedure',
                                            1,
                                            '$_hn_record_id_borrow'
                                        ) ";


                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode )
                                VALUES
                                ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                                    (
                                                    '$input_docNo_HN_manual', 
                                                    '$input_pay_manual',
                                                    '$_RowID',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                                    ) ";


                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


                    // echo $queryInsert2;
                    // exit;
                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                    $count_itemstock++;

                    $count_new_item++;
                }


                if ($count_new_item  == 0) {

                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                                        VALUES
                                            ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";





                    $meQueryInsert = $conn->prepare($queryInsert);
                    $meQueryInsert->execute();


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
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
                                    GROUP BY
                                        deproomdetail.ID,
                                        deproom.Ref_departmentroomid,
                                        deproom.`procedure`,
                                        deproom.doctor,
                                        deproom.hn_record_id,
                                        deproomdetail.ItemCode ,
                                        deproomdetail.Qty,
                                        deproomdetail.PayDate ";


                    $meQuery_2 = $conn->prepare($query_2);
                    $meQuery_2->execute();
                    while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                        $return[] = $row_2;

                        $_ID = $row_2['ID'];
                        $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];

                        // ==============================

                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            `procedure`,
                                            qty_weighing,
                                            hn_record_id_borrow
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
                                                '$_procedure',
                                                1,
                                            '$_hn_record_id_borrow'
                                            ) ";


                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();
                        // ==============================

                        // =======================================================================================================================================
                        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty , hncode )
                                VALUES
                                ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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

                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                    (
                                    '$input_docNo_HN_manual',
                                    '$input_pay_manual',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";




                        $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                        $query_updateHN = $conn->prepare($query_updateHN);
                        $query_updateHN->execute();


                        // echo $queryInsert2;
                        // exit;
                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;

                        $count_new_item++;



                        $count_itemstock = 2;
                    }
                }


                $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
                $meQueryPay = $conn->prepare($updatePay);
                $meQueryPay->execute();
            }
        }
    }


    $datax = [
        "input_docNo_deproom_manual" => $input_docNo_deproom_manual,
        "input_docNo_HN_manual" => $input_docNo_HN_manual,
        "count_itemstock" => $count_itemstock
    ];


    // if ($count_itemstock == 0) {
    echo json_encode($datax);
    unset($conn);
    die;
    // } else {
    //     echo json_encode($return);
    //     unset($conn);
    //     die;
    // }

}


function oncheck_Returnpay_manual($conn, $db)
{
    $return = array();
    $input_returnpay_manual = $_POST['input_returnpay_manual'];
    $input_docNo_deproom_manual = $_POST['input_docNo_deproom_manual'];
    $input_docNo_HN_manual = $_POST['input_docNo_HN_manual'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];



    // $DocNo_pay = $_POST['DocNo_pay'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];


    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $check_barcode = 0;
    $qcheck = "SELECT
                    item.Barcode,
                    item.itemcode
                FROM
                    item
                WHERE
                    item.Barcode = '$input_returnpay_manual'  ";

    // echo $qcheck;
    // exit;
    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $check_barcode++;
    }

    $count_itemstock = 0;
    if ($check_barcode > 0) {

        $query_2 = "SELECT
                        deproomdetailsub.ID ,
                        deproomdetail.ID AS detailID,
                        hncode_detail.ID AS hndetail_ID,
                        deproomdetail.ItemCode,
                        SUM(deproomdetail.Qty) AS deproom_qty,
                        SUM(hncode_detail.Qty) AS hncode_qty
                    FROM
                        deproom
                        INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                        INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                        INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                    WHERE
                        deproomdetail.ItemCode = '$_itemcode' 
                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
                        AND hncode_detail.ItemCode = '$_itemcode' ";
        // echo $query_2;
        // exit;
        $meQuery_2 = $conn->prepare($query_2);
        $meQuery_2->execute();
        while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

            $return[] = $row_2;

            $_ID = $row_2['ID'];
            $_hndetail_ID = $row_2['hndetail_ID'];
            $deproom_qty = $row_2['deproom_qty'];
            $hncode_qty = $row_2['hncode_qty'];
            $detailID = $row_2['detailID'];

            // ==============================
            if ($deproom_qty == 0) {
                $queryD1 = "DELETE FROM deproomdetail WHERE ID =  '$detailID' ";
                $meQueryD1 = $conn->prepare($queryD1);
                $meQueryD1->execute();
            } else {

                $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
                $meQueryD1 = $conn->prepare($queryD1);
                $meQueryD1->execute();

                $queryInsert0 = "UPDATE deproomdetail SET Qty = Qty-1 WHERE  deproomdetail.ID = '$detailID' ";
                $meQuery0 = $conn->prepare($queryInsert0);
                $meQuery0->execute();
            }
            if ($hncode_qty == 0) {
                $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
                $meQueryD2 = $conn->prepare($queryD2);
                $meQueryD2->execute();
            } else {
                $queryInsert0 = "UPDATE hncode_detail SET Qty = Qty-1 WHERE  ID =  '$_hndetail_ID' ";
                $meQuery0 = $conn->prepare($queryInsert0);
                $meQuery0->execute();
            }


            // ==============================

            // =======================================================================================================================================

            // if ($db == 1) {
            //     $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
            // AND ItemCode = '$_ItemCode' 
            // AND departmentroomid = '$_departmentroomid' 
            // AND  IsStatus = '1'
            // AND DATE(CreateDate) = '$input_date_service_manual' ";
            // } else {
            //     $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
            // AND ItemCode = '$_ItemCode' 
            // AND departmentroomid = '$_departmentroomid' 
            // AND  IsStatus = '1'
            // AND CONVERT(DATE,CreateDate) = '$input_date_service_manual' ";
            // }

            // $meQuery = $conn->prepare($query);
            // $meQuery->execute();
            // =======================================================================================================================================



            // $queryUpdate = "UPDATE itemstock 
            // SET Isdeproom = 0 ,
            // departmentroomid = '35'
            // WHERE
            // RowID = '$_RowID' ";
            // $meQueryUpdate = $conn->prepare($queryUpdate);
            // $meQueryUpdate->execute();
            // // ==============================
            // $count_itemstock++;
        }
    }

    if ($check_barcode == 0) {
        $query_1 = " SELECT
                        itemstock.ItemCode,
                        itemstock.Isdeproom,
                        itemstock.departmentroomid ,
                        itemstock.RowID 
                    FROM
                        itemstock
                    WHERE  itemstock.UsageCode = '$input_returnpay_manual' AND itemstock.Isdeproom = '1' ";


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
                                AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                    AND DATE(CreateDate) = '$input_date_service_manual' ";
                    } else {
                        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                                    AND ItemCode = '$_ItemCode' 
                                    AND departmentroomid = '$_departmentroomid' 
                                    AND  IsStatus = '1'
                                    AND CONVERT(DATE,CreateDate) = '$input_date_service_manual' ";
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


function oncheck_pay_rfid_manual($conn, $db)
{
    $return = array();

    $input_docNo_deproom_manual = $_POST['input_docNo_deproom_manual'];
    $input_docNo_HN_manual = $_POST['input_docNo_HN_manual'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];




    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];

    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $select_procedure_manual = implode(",", $select_procedure_manual);
    $select_doctor_manual = implode(",", $select_doctor_manual);


    if ($input_docNo_deproom_manual == "") {
        $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
        $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $remark, 0, 0, 0, 0, '', '', '', $db);
        $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 0, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual);

        $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$input_date_service_manual $input_time_service_manual'  , hn_record_id = '$input_Hn_pay_manual' , doctor = '$select_doctor_manual' , `procedure` = '$select_procedure_manual' , Ref_departmentroomid = '$select_deproom_manual' WHERE DocNo = '$input_docNo_deproom_manual' AND IsCancel = 0 ";
        $meQueryUpdate = $conn->prepare($sql1);
        $meQueryUpdate->execute();
    }


    if ($db == 1) {
        $query_1 = "SELECT
                        itemstock.ItemCode,
                        itemstock.Isdeproom,
                        itemstock.RowID ,
                        itemstock.UsageCode,
                        CASE
                                WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                ELSE 'no_exp'
                            END AS check_exp
                    FROM
                        itemstock 
                    WHERE
                        itemstock.departmentroomid = '35' 
                        AND itemstock.Isdeproom = '0' 
                        AND itemstock.HNCode = '$input_Hn_pay_manual' ";
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


    // echo $query_1;
    // exit;
    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        // $return[] = $row_1;

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_RowID =  $row_1['RowID'];
        $input_pay =  $row_1['UsageCode'];
        $check_exp =  $row_1['check_exp'];


        $check_exp =  'no_exp';


        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {

            if ($check_exp == 'no_exp') {
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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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

                    // $return[] = $row_2;

                    $_ID = $row_2['ID'];
                    $_PayDate = $row_2['PayDate'];
                    $_departmentroomid = $row_2['departmentroomid'];
                    $_procedure = $row_2['procedure'];
                    $_hn_record_id = $row_2['hn_record_id'];
                    $_doctor = $row_2['doctor'];
                    $_Qty_detail = $row_2['Qty'];
                    $_Qty_detail_sub = $row_2['cnt_sub'];
                    $_ItemCode = $row_2['ItemCode'];
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
                                        `procedure`,
                                        itemcode_weighing,
                                        qty_weighing
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
                                        '$_procedure',
                                        '$_ItemCode',
                                         1
                                    ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                        Deproomdetail_RowID,
                                        ItemStockID,
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        [procedure],
                                        itemcode_weighing,
                                        qty_weighing
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
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        1
                                    ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
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
                        '$input_docNo_HN_manual', 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                         (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID LIMIT 1)
                        ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        '$input_docNo_HN_manual',  
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                         (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }



                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();
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
                            ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";
                    } else {
                        $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                        VALUES
                            ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
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
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub
                                    FROM
                                        deproomdetail
                                        INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                    WHERE
                                        deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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

                        // $return[] = $row_2;

                        $_ID = $row_2['ID'];
                        $_PayDate = $row_2['PayDate'];
                        $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];
                        $_Qty_detail = $row_2['Qty'];
                        $_Qty_detail_sub = $row_2['cnt_sub'];
                        $_ItemCode = $row_2['ItemCode'];

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
                                                `procedure`,
                                                itemcode_weighing,
                                                qty_weighing
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
                                                '$_procedure',
                                                '$_ItemCode',
                                                1
                                            ) ";
                        } else {
                            $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                Deproomdetail_RowID,
                                                ItemStockID,
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                [procedure],
                                                itemcode_weighing,
                                                qty_weighing
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
                                                '$_procedure',
                                                    '$_ItemCode',
                                                    1
                                            ) ";
                        }

                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();
                        // ==============================

                        // =======================================================================================================================================
                        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( $_RowID, '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
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
                            '$input_docNo_HN_manual', 
                            '$input_pay',
                            '$_RowID',
                            1, 
                            1, 
                            0, 
                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                            ) ";
                        } else {
                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                            (
                            '$input_docNo_HN_manual',  
                            '$input_pay',
                            '$_RowID',
                            1, 
                            1, 
                            0, 
                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                            ) ";
                        }

                        $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                        $query_updateHN = $conn->prepare($query_updateHN);
                        $query_updateHN->execute();


                        // echo $queryInsert2;
                        // exit;
                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;

                        $count_new_item++;



                        // $count_itemstock = 2;
                        // echo json_encode($count_itemstock);
                        // unset($conn);
                        // die;
                    }
                }


                $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
                $meQueryPay = $conn->prepare($updatePay);
                $meQueryPay->execute();
            }
        }
    }


    // echo json_encode($return);
    // unset($conn);
    // die;

    oncheck_pay_weighing_manual($conn, $db);

    // if ($count_itemstock == 0) {
    // echo json_encode($return);
    // unset($conn);
    // die;
    // } else {
    //     echo json_encode($return);
    //     unset($conn);
    //     die;
    // }
}

function oncheck_pay_weighing_manual($conn, $db)
{
    $return = array();
    $input_docNo_deproom_manual = $_POST['input_docNo_deproom_manual'];
    $input_docNo_HN_manual = $_POST['input_docNo_HN_manual'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];



    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];

    if ($db == 1) {
        $query_1 = "SELECT
                        itemslotincabinet_detail.id, 
                        itemslotincabinet_detail.itemcode AS ItemCode, 
                        itemslotincabinet_detail.HnCode, 
                        itemslotincabinet_detail.StockID, 
                        itemslotincabinet_detail.Qty, 
                        itemslotincabinet_detail.ModifyDate,
	                    itemslotincabinet_detail.IsDeproom
                    FROM
                        itemslotincabinet_detail
                        WHERE itemslotincabinet_detail.HnCode ='$input_Hn_pay_manual' ";
    } else {
        $query_1 = "  SELECT
                            id, 
                            itemcode AS ItemCode, 
                            HnCode, 
                            StockID, 
                            Qty, 
                            ModifyDate,
                            IsDeproom
                        FROM 
                            itemslotincabinet_detail
                        WHERE 
                            HnCode = '$input_Hn_pay_manual' ";
    }

    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        // $return[] = $row_1;

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['IsDeproom'];
        $_RowID =  $row_1['id'];
        $_Qty =  $row_1['Qty'];
        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {
            // $return = $DocNo_pay;
            // if ($check_exp == 'no_exp') {
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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                    AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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

                // $return[] = $row_2;
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
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        `procedure`,
                                        itemcode_weighing,
                                        qty_weighing
                                    )
                                    VALUES
                                    (
                                        '$_ID', 
                                        '$_departmentroomid',
                                        1, 
                                        1, 
                                        NOW(), 
                                        '$_hn_record_id', 
                                        '$_doctor', 
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        '$_Qty'
                                    ) ";
                } else {
                    $queryInsert1 = "INSERT INTO deproomdetailsub (
                                        Deproomdetail_RowID,
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        [procedure],
                                        itemcode_weighing,
                                        qty_weighing
                                    )
                                    VALUES
                                    (
                                        '$_ID',   
                                        '$_departmentroomid',
                                        1, 
                                        1, 
                                        GETDATE(), 
                                        '$_hn_record_id', 
                                        '$_doctor', 
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        '$_Qty'
                                    ) ";
                }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( '0', '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,'$_Qty','$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================


                // ==============================
                $queryUpdate = "UPDATE itemslotincabinet_detail
                        SET IsDeproom = 1 
                        WHERE
                        id = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================
                if ($db == 1) {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                        (
                        '$input_docNo_HN_manual', 
                        '0',
                        '0',
                        '$_Qty', 
                        1, 
                        0, 
                         '-',
                         '$_ItemCode'
                        ) ";
                } else {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                        (
                        '$input_docNo_HN_manual', 
                        '0',
                        '0',
                        '$_Qty', 
                        1, 
                        0, 
                         '-',
                         '$_ItemCode'
                        ) ";
                }


                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();

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
                            ( '$input_docNo_deproom_manual', '$_ItemCode', '$_Qty', 3,NOW(), 0, '$Userid',NOW() )";
                } else {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                        VALUES
                            ( '$input_docNo_deproom_manual', '$_ItemCode', '$_Qty', 3, GETDATE(), 0, '$Userid',GETDATE())";
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
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub
                                    FROM
                                        deproomdetail
                                        INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                    WHERE
                                        deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
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

                    // $return[] = $row_2;

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
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                `procedure`,
                                                itemcode_weighing,
                                                qty_weighing
                                            )
                                            VALUES
                                            (
                                                '$_ID', 
                                                '$_departmentroomid',
                                                1, 
                                                1, 
                                                NOW(), 
                                                '$_hn_record_id', 
                                                '$_doctor', 
                                                '$_procedure', 
                                                '$_ItemCode', 
                                                '$_Qty'
                                            ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                Deproomdetail_RowID,
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                [procedure],
                                                itemcode_weighing,
                                                qty_weighing
                                            )
                                            VALUES
                                            (
                                                '$_ID', 
                                                '$_departmentroomid',
                                                1, 
                                                1, 
                                                GETDATE(), 
                                                '$_hn_record_id', 
                                                '$_doctor', 
                                                '$_procedure', 
                                                '$_ItemCode', 
                                                '$_Qty'
                                            ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                        VALUES
                        ( '0', '$_ItemCode','$input_date_service_manual','$_departmentroomid', $Userid,1,'$_Qty','$_hn_record_id') ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();
                    // =======================================================================================================================================


                    $queryUpdate = "UPDATE itemslotincabinet_detail
                                        SET IsDeproom = 1 
                                        WHERE
                                        id = '$_RowID' ";
                    $meQueryUpdate = $conn->prepare($queryUpdate);
                    $meQueryUpdate->execute();
                    // ==============================
                    if ($db == 1) {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                                (
                                '$input_docNo_deproom_manual', 
                                '0',
                                '0',
                                '$_Qty', 
                                1, 
                                0, 
                                '-',
                                '$_ItemCode'
                                ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                                (
                                '$input_docNo_deproom_manual',
                                '0',
                                '0',
                                '$_Qty', 
                                1, 
                                0, 
                                '-',
                                '$_ItemCode'
                                ) ";
                    }

                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'  ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();
                    // echo $queryInsert2;
                    // exit;
                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                    $count_itemstock++;

                    $count_new_item++;



                    // $count_itemstock = 2;
                    // echo json_encode($count_itemstock);
                    // unset($conn);
                    // die;
                }
            }


            $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
            $meQueryPay = $conn->prepare($updatePay);
            $meQueryPay->execute();
            // }
        }
    }



    $datax = [
        "input_docNo_deproom_manual" => $input_docNo_deproom_manual,
        "input_docNo_HN_manual" => $input_docNo_HN_manual,
        "count_itemstock" => $count_itemstock
    ];


    // if ($count_itemstock == 0) {
    echo json_encode($datax);
    unset($conn);
    die;


    // if ($count_itemstock == 0) {
    //     echo json_encode($count_itemstock);
    //     unset($conn);
    //     die;
    // } else {
    //     echo json_encode($count_itemstock);
    //     unset($conn);
    //     die;
    // }
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
                        itemstock.UsageCode,
                        CASE
                                WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                ELSE 'no_exp'
                            END AS check_exp
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


    // echo $query_1;
    // exit;
    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        // $return[] = $row_1;

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_RowID =  $row_1['RowID'];
        $input_pay =  $row_1['UsageCode'];
        $check_exp =  $row_1['check_exp'];
        $check_exp = 'no_exp';
        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {

            if ($check_exp == 'no_exp') {
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

                    // $return[] = $row_2;

                    $_ID = $row_2['ID'];
                    $_PayDate = $row_2['PayDate'];
                    $_departmentroomid = $row_2['departmentroomid'];
                    $_procedure = $row_2['procedure'];
                    $_hn_record_id = $row_2['hn_record_id'];
                    $_doctor = $row_2['doctor'];
                    $_Qty_detail = $row_2['Qty'];
                    $_Qty_detail_sub = $row_2['cnt_sub'];
                    $_ItemCode = $row_2['ItemCode'];
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
                                        `procedure`,
                                        itemcode_weighing,
                                        qty_weighing
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
                                        '$_procedure',
                                        '$_ItemCode',
                                         1
                                    ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                        Deproomdetail_RowID,
                                        ItemStockID,
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        [procedure],
                                        itemcode_weighing,
                                        qty_weighing
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
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        1
                                    ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
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
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                         (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID LIMIT 1)
                        ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                         (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }



                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();
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
                    } else {
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

                        // $return[] = $row_2;

                        $_ID = $row_2['ID'];
                        $_PayDate = $row_2['PayDate'];
                        $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];
                        $_Qty_detail = $row_2['Qty'];
                        $_Qty_detail_sub = $row_2['cnt_sub'];
                        $_ItemCode = $row_2['ItemCode'];

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
                                                `procedure`,
                                                itemcode_weighing,
                                                qty_weighing
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
                                                '$_procedure',
                                                '$_ItemCode',
                                                1
                                            ) ";
                        } else {
                            $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                Deproomdetail_RowID,
                                                ItemStockID,
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                [procedure],
                                                itemcode_weighing,
                                                qty_weighing
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
                                                '$_procedure',
                                                    '$_ItemCode',
                                                    1
                                            ) ";
                        }

                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();
                        // ==============================

                        // =======================================================================================================================================
                        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
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
                            (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                            '$input_pay',
                            '$_RowID',
                            1, 
                            1, 
                            0, 
                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                            ) ";
                        } else {
                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                            (
                            (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                            '$input_pay',
                            '$_RowID',
                            1, 
                            1, 
                            0, 
                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                            ) ";
                        }

                        $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                        $query_updateHN = $conn->prepare($query_updateHN);
                        $query_updateHN->execute();


                        // echo $queryInsert2;
                        // exit;
                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;

                        $count_new_item++;



                        // $count_itemstock = 2;
                        // echo json_encode($count_itemstock);
                        // unset($conn);
                        // die;
                    }
                }


                $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$DocNo_pay' ";
                $meQueryPay = $conn->prepare($updatePay);
                $meQueryPay->execute();
            }
        }
    }


    // echo json_encode($return);
    // unset($conn);
    // die;

    oncheck_pay_weighing($conn, $db);

    // if ($count_itemstock == 0) {
    // echo json_encode($return);
    // unset($conn);
    // die;
    // } else {
    //     echo json_encode($return);
    //     unset($conn);
    //     die;
    // }
}

function oncheck_pay_weighing($conn, $db)
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
                        itemslotincabinet_detail.id, 
                        itemslotincabinet_detail.itemcode AS ItemCode, 
                        itemslotincabinet_detail.HnCode, 
                        itemslotincabinet_detail.StockID, 
                        itemslotincabinet_detail.Qty, 
                        itemslotincabinet_detail.ModifyDate,
	                    itemslotincabinet_detail.IsDeproom
                    FROM
                        itemslotincabinet_detail
                        WHERE itemslotincabinet_detail.HnCode ='$hncode' ";
    } else {
        $query_1 = "  SELECT
                            id, 
                            itemcode AS ItemCode, 
                            HnCode, 
                            StockID, 
                            Qty, 
                            ModifyDate,
                            IsDeproom
                        FROM 
                            itemslotincabinet_detail
                        WHERE 
                            HnCode = '$hncode' ";
    }

    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        // $return[] = $row_1;

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['IsDeproom'];
        $_RowID =  $row_1['id'];
        $_Qty =  $row_1['Qty'];
        $count_itemstock++;

        $count_itemstock = 0;
        $count_new_item = 0;


        if ($_Isdeproom == 0) {
            // $return = $DocNo_pay;
            // if ($check_exp == 'no_exp') {
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

                // $return[] = $row_2;
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
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        `procedure`,
                                        itemcode_weighing,
                                        qty_weighing
                                    )
                                    VALUES
                                    (
                                        '$_ID', 
                                        '$_departmentroomid',
                                        1, 
                                        1, 
                                        NOW(), 
                                        '$_hn_record_id', 
                                        '$_doctor', 
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        '$_Qty'
                                    ) ";
                } else {
                    $queryInsert1 = "INSERT INTO deproomdetailsub (
                                        Deproomdetail_RowID,
                                        dental_warehouse_id,
                                        IsStatus,
                                        IsCheckPay,
                                        PayDate,
                                        hn_record_id,
                                        doctor,
                                        [procedure],
                                        itemcode_weighing,
                                        qty_weighing
                                    )
                                    VALUES
                                    (
                                        '$_ID',   
                                        '$_departmentroomid',
                                        1, 
                                        1, 
                                        GETDATE(), 
                                        '$_hn_record_id', 
                                        '$_doctor', 
                                        '$_procedure', 
                                        '$_ItemCode', 
                                        '$_Qty'
                                    ) ";
                }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode)
                        VALUES
                        ( '0', '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,'$_Qty','$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================


                // ==============================
                $queryUpdate = "UPDATE itemslotincabinet_detail
                        SET IsDeproom = 1 
                        WHERE
                        id = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================
                if ($db == 1) {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                        '0',
                        '0',
                        '$_Qty', 
                        1, 
                        0, 
                         '-',
                         '$_ItemCode'
                        ) ";
                } else {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                        '0',
                        '0',
                        '$_Qty', 
                        1, 
                        0, 
                         '-',
                         '$_ItemCode'
                        ) ";
                }


                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();

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
                            ( '$DocNo_pay', '$_ItemCode', '$_Qty', 3,NOW(), 0, '$Userid',NOW() )";
                } else {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                        VALUES
                            ( '$DocNo_pay', '$_ItemCode', '$_Qty', 3, GETDATE(), 0, '$Userid',GETDATE())";
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

                    // $return[] = $row_2;

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
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                `procedure`,
                                                itemcode_weighing,
                                                qty_weighing
                                            )
                                            VALUES
                                            (
                                                '$_ID', 
                                                '$_departmentroomid',
                                                1, 
                                                1, 
                                                NOW(), 
                                                '$_hn_record_id', 
                                                '$_doctor', 
                                                '$_procedure', 
                                                '$_ItemCode', 
                                                '$_Qty'
                                            ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                                Deproomdetail_RowID,
                                                dental_warehouse_id,
                                                IsStatus,
                                                IsCheckPay,
                                                PayDate,
                                                hn_record_id,
                                                doctor,
                                                [procedure],
                                                itemcode_weighing,
                                                qty_weighing
                                            )
                                            VALUES
                                            (
                                                '$_ID', 
                                                '$_departmentroomid',
                                                1, 
                                                1, 
                                                GETDATE(), 
                                                '$_hn_record_id', 
                                                '$_doctor', 
                                                '$_procedure', 
                                                '$_ItemCode', 
                                                '$_Qty'
                                            ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                        VALUES
                        ( '0', '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,'$_Qty','$_hn_record_id') ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();
                    // =======================================================================================================================================


                    $queryUpdate = "UPDATE itemslotincabinet_detail
                                        SET IsDeproom = 1 
                                        WHERE
                                        id = '$_RowID' ";
                    $meQueryUpdate = $conn->prepare($queryUpdate);
                    $meQueryUpdate->execute();
                    // ==============================
                    if ($db == 1) {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1 ), 
                                '0',
                                '0',
                                '$_Qty', 
                                1, 
                                0, 
                                '-',
                                '$_ItemCode'
                                ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID,ItemCode)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service'  LIMIT 1), 
                                '0',
                                '0',
                                '$_Qty', 
                                1, 
                                0, 
                                '-',
                                '$_ItemCode'
                                ) ";
                    }

                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();
                    // echo $queryInsert2;
                    // exit;
                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                    $count_itemstock++;

                    $count_new_item++;



                    // $count_itemstock = 2;
                    // echo json_encode($count_itemstock);
                    // unset($conn);
                    // die;
                }
            }


            $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$DocNo_pay' ";
            $meQueryPay = $conn->prepare($updatePay);
            $meQueryPay->execute();
            // }
        }
    }



    if ($count_itemstock == 0) {
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    } else {
        echo json_encode($count_itemstock);
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
    $departmeneoomID = $_POST['departmeneoomID'];



    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    if ($db == 1) {

        $query_1 = "        SELECT
                                itemstock.ItemCode,
                                itemstock.Isdeproom,
                                itemstock.RowID ,
                                itemstock.UsageCode,
                                itemstock.departmentroomid ,
                                CASE
                                        WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                        ELSE 'no_exp'
                                    END AS check_exp
                            FROM
                                itemstock 
                            WHERE
                                    itemstock.UsageCode = '$input_pay' ";
        // -- AND itemstock.departmentroomid = '35' 
        // -- AND itemstock.Isdeproom = '0' 
        // AND itemstock.HNCode = '$hncode' ";



        // $query_1 = " SELECT
        //                     itemstock.ItemCode,
        //                     itemstock.Isdeproom,
        //                     itemstock.departmentroomid,
        //                     itemstock.RowID,
        //                     IF(DATE(itemstock.ExpireDate) <= CURDATE(), 'exp', 'no_exp') AS check_exp
        //                 FROM
        //                     itemstock
        //                 WHERE
        //                     itemstock.UsageCode = '$input_pay'
        //                     AND itemstock.departmentroomid = '35'
        //                     AND itemstock.Isdeproom = '0'
        //                     AND itemstock.ExpireDate > CURDATE()
        //                     AND (itemstock.IsDamage IS NULL OR itemstock.IsDamage = 0)
        //                     AND (itemstock.IsClaim IS NULL OR itemstock.IsClaim = 0) ";
    } else {

        if ($db == 1) {
            $query_1 = " SELECT 
                            itemstock.ItemCode,
                            itemstock.Isdeproom,
                            itemstock.departmentroomid,
                            itemstock.RowID,
                            IF(itemstock.ExpireDate <= CURDATE(), 'exp', 'no_exp') AS check_exp
                        FROM 
                            itemstock
                        WHERE 
                            itemstock.UsageCode = '$input_pay'
                            AND itemstock.departmentroomid = '35'
                            AND itemstock.Isdeproom = '0'
                            AND itemstock.ExpireDate > NOW()
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

        // stock
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
                                    `procedure`,
                                     qty_weighing
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
                                    '$_procedure',
                                    1
                                ) ";
                } else {
                    $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    [procedure],
                                     qty_weighing
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
                                    '$_procedure',
                                    1
                                ) ";
                }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1 ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                } else {
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1  ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }


                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();


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
                } else {
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
                                            `procedure`,
                                            qty_weighing
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
                                            '$_procedure',
                                            1
                                        ) ";
                    } else {
                        $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            [procedure],
                                            qty_weighing
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
                                            '$_procedure',
                                            1
                                        ) ";
                    }

                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty , hncode )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    } else {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";
                    }



                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


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


        // ยืม
        if ($_Isdeproom == 1) {


            $query_old = " SELECT
                                deproomdetailsub.ID,
                                deproomdetail.ID AS detailID,
                                hncode_detail.ID AS hndetail_ID,
                                deproomdetail.ItemCode,
                                SUM( deproomdetail.Qty ) AS deproom_qty,
                                COUNT( hncode_detail.Qty ) AS hncode_qty ,
	                            deproom.hn_record_id
                            FROM
                                deproom
                                LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND hncode_detail.UsageCode = '$input_pay'
                                ORDER BY deproomdetailsub.ID DESC
                                LIMIT 1 ";


            $meQuery_old = $conn->prepare($query_old);
            $meQuery_old->execute();
            while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                $detailID = $row_old['detailID'];
                $hndetail_ID = $row_old['hndetail_ID'];
                $deproom_qty = $row_old['deproom_qty'];
                $hncode_qty = $row_old['hncode_qty'];
                $deproomdetailsub_id = $row_old['ID'];
                $_hn_record_id_borrow = $row_old['hn_record_id'];
            }


            if ($deproom_qty == 1) {
                $update_old_detail = "DELETE FROM deproomdetail WHERE ID =  '$detailID' ";
                $meQuery_old_detail = $conn->prepare($update_old_detail);
                $meQuery_old_detail->execute();

                $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                $meQuery_old_sub = $conn->prepare($update_old_sub);
                $meQuery_old_sub->execute();
            } else {
                $update_old_detail = "UPDATE deproomdetail SET Qty = Qty-1 WHERE  deproomdetail.ID = '$detailID' ";
                $meQuery_old_detail = $conn->prepare($update_old_detail);
                $meQuery_old_detail->execute();

                $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'   ";
                $meQuery_old_sub = $conn->prepare($update_old_sub);
                $meQuery_old_sub->execute();
            }

            if ($hncode_qty == 1) {
                $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$hndetail_ID' ";
                $meQueryD2 = $conn->prepare($queryD2);
                $meQueryD2->execute();
            } else {
                $queryInsert0 = "UPDATE hncode_detail SET Qty = Qty-1 WHERE  ID =  '$hndetail_ID' ";
                $meQuery0 = $conn->prepare($queryInsert0);
                $meQuery0->execute();
            }




            // echo $update_old_detail ;
            // exit;

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

                $queryInsert1 = "INSERT INTO deproomdetailsub (
                                    Deproomdetail_RowID,
                                    ItemStockID,
                                    dental_warehouse_id,
                                    IsStatus,
                                    IsCheckPay,
                                    PayDate,
                                    hn_record_id,
                                    doctor,
                                    `procedure`,
                                     qty_weighing,
                                     hn_record_id_borrow
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
                                    '$_procedure',
                                    1,
                                    '$_hn_record_id_borrow'
                                ) ";


                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // =======================================================================================================================================
                $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty ,hncode )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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
                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1 ), 
                    '$input_pay',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                     (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";



                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();


                // echo $queryInsert2;
                // exit;
                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
                $count_itemstock++;

                $count_new_item++;
            }


            // รายการยังไม่มี
            if ($count_new_item  == 0) {



                if ($db == 1) {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                        VALUES
                            ( '$DocNo_pay', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() )";
                } else {
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



                    $queryInsert1 = "INSERT INTO deproomdetailsub (
                                            Deproomdetail_RowID,
                                            ItemStockID,
                                            dental_warehouse_id,
                                            IsStatus,
                                            IsCheckPay,
                                            PayDate,
                                            hn_record_id,
                                            doctor,
                                            `procedure`,
                                            qty_weighing,
                                            hn_record_id_borrow
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
                                            '$_procedure',
                                            1,
                                            '$_hn_record_id_borrow'
                                        ) ";


                    $queryInsert1 = $conn->prepare($queryInsert1);
                    $queryInsert1->execute();
                    // ==============================

                    // =======================================================================================================================================
                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty , hncode )
                    VALUES
                    ( $_RowID, '$_ItemCode','$input_date_service','$_departmentroomid', $Userid,1,1 ,'$_hn_record_id') ";
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

                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                        (
                        (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' LIMIT 1), 
                        '$input_pay',
                        '$_RowID',
                        1, 
                        1, 
                        0, 
                        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                        ) ";




                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$input_date_service' ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


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
                IFNULL((
				SELECT SUM(deproomdetailsub.qty_weighing) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
				),0) AS cnt_pay,
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


function show_detail_item_ByDocNo_manual($conn, $db)
{
    $return = array();
    $DocNo = $_POST['input_docNo_deproom_manual'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM(deproomdetail.Qty) AS cnt ,
                IFNULL((
				SELECT SUM(deproomdetailsub.qty_weighing) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
				),0) AS cnt_pay,
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
                        DATE(deproom.serviceDate) = '$select_date_pay'
                        $whereDep
                        AND deproom.IsCancel = 0
                    GROUP BY
                        departmentroom.id,
                        departmentroom.departmentroomname ";
    } else {
        $query = " SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname 
                    FROM
                        deproom
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
                    WHERE
                        CONVERT(DATE,deproom.serviceDate) =  '$select_date_pay' 
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
                            deproom.doctor ,
                            deproom.`procedure`
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
                            AND DATE(deproom.serviceDate) = '$select_date_pay'
                        GROUP BY
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            `procedure`.Procedure_TH,
                            deproom.hn_record_id,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y'),
                            DATE_FORMAT(deproom.serviceDate, '%H:%i') ";
        } else {
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
                        AND CONVERT(DATE,deproom.serviceDate) =  '$select_date_pay' 
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

        // echob$query_sub
        $meQuery_sub = $conn->prepare($query_sub);
        $meQuery_sub->execute();
        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {


            if (str_contains($row_sub['procedure'], ',')) {
                $row_sub['Procedure_TH'] = 'button';
            }
            if (str_contains($row_sub['doctor'], ',')) {
                $row_sub['Doctor_Name'] = 'button';
            }


            $DocNo_ = $row_sub['DocNo'];

            $check_q = 0;
            $querych = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay 
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                        GROUP BY
                            deproomdetail.ID  ";
            $meQuerych = $conn->prepare($querych);
            $meQuerych->execute();
            while ($rowch = $meQuerych->fetch(PDO::FETCH_ASSOC)) {

                if ($rowch['cnt_pay'] < $rowch['cnt']) {
                    $check_q++;
                }
            }

            if ($check_q == 0) {
                $row_sub['cnt_detail'] = 'ครบ';
            } else {
                $row_sub['cnt_detail'] = 'ค้าง';
            }


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
