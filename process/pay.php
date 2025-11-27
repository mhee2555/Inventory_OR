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
    } else if ($_POST['FUNC_NAME'] == 'save_edit_hn') {
        save_edit_hn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_history_Return') {
        feeddata_history_Return($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_Permission') {
        showDetail_Permission($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'block_item_byDocNo') {
        block_item_byDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_history_block') {
        show_detail_history_block($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'save_edit_hn_block') {
        save_edit_hn_block($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item_block') {
        showDetail_item_block($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item_history') {
        showDetail_item_history($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkIsaddItem') {
        checkIsaddItem($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_deproom_pay_fix') {
        show_detail_deproom_pay_fix($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_history_ems') {
        show_detail_history_ems($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'save_edit_ems') {
        save_edit_ems($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'checkHNDocNo') {
        checkHNDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'deleteReturn') {
        deleteReturn($conn, $db);
    }
}

function checkHNDocNo($conn, $db)
{
    $return = array();
    $input_searchHN_pay = $_POST['input_searchHN_pay'];
    $select_date_pay = $_POST['select_date_pay'];
    $select_date_pay = explode("-", $select_date_pay);
    $select_date_pay = $select_date_pay[2] . '-' . $select_date_pay[1] . '-' . $select_date_pay[0];

    $query = " SELECT COUNT(deproom.DocNo) AS cnt , 
                      deproom.DocNo  
                FROM deproom 
                WHERE  DATE(deproom.serviceDate) = '$select_date_pay' AND  ( deproom.hn_record_id = '$input_searchHN_pay' OR deproom.number_box = '$input_searchHN_pay' )  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function checkIsaddItem($conn, $db)
{
    $return = array();


    $query = " SELECT COUNT(deproom.DocNo) AS cnt , 
                      deproom.DocNo  
                FROM deproom 
                WHERE deproom.IsAdditem = 2  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $DocNo = $row['DocNo'];
        $return[] = $row;


        $query2 = " UPDATE deproom SET IsAdditem = 3 WHERE  deproom.DocNo = '$DocNo' ";

        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
    }


    echo json_encode($return);
    unset($conn);
    die;
}



function showDetail_item_block($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];


    $query = "SELECT
                    item.itemcode2,
                    item.itemname,
                    SUM(IFNULL( subs.total_qty_weighing, 0 )) AS cnt_pay 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
                    LEFT JOIN ( SELECT Deproomdetail_RowID, SUM( qty_weighing ) AS total_qty_weighing FROM deproomdetailsub GROUP BY Deproomdetail_RowID ) AS subs ON subs.Deproomdetail_RowID = deproomdetail.ID 
                WHERE
                    deproom.DocNo = '$DocNo' 
                    AND deproom.IsCancel = 0 
                    AND deproomdetail.IsCancel = 0 
                GROUP BY
                    item.itemname; ";

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

function showDetail_Permission($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $deproom = $_SESSION['deproom'];


    $query = "SELECT
    permission.Permission,
    item.warehouseID,

    -- จำนวนรายการทั้งหมดที่ IsRequest = 0
    SUM(CASE
        WHEN deproomdetail.IsRequest = 0 THEN deproomdetail.Qty
        ELSE 0
    END) AS cnt,

    -- จำนวนที่ชั่งน้ำหนักรวม (จาก subquery รวม)
    (
        SELECT SUM(subs.qty_weighing)
        FROM deproomdetailsub subs
        WHERE subs.Deproomdetail_RowID IN (
            SELECT d.ID
            FROM deproomdetail d
            INNER JOIN deproom dp ON d.DocNo = dp.DocNo
            WHERE dp.DocNo = '$DocNo'
              AND dp.IsCancel = 0
              AND d.IsCancel = 0
        )
    ) AS cnt_pay,

    -- นับว่ารายการไหนยังไม่ครบ (over)
    SUM(
        CASE
            WHEN IFNULL((
                SELECT SUM(subs.qty_weighing)
                FROM deproomdetailsub subs
                WHERE subs.Deproomdetail_RowID = deproomdetail.ID
            ), 0) < deproomdetail.Qty THEN 1
            ELSE 0
        END
    ) AS cnt_over

FROM deproom
INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
INNER JOIN permission ON permission.PmID = item.warehouseID

WHERE
    deproom.DocNo = '$DocNo'
    AND deproom.IsCancel = 0
    AND deproomdetail.IsCancel = 0

GROUP BY item.warehouseID;
";

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

function feeddata_history_Return($conn, $db)
{
    $input_search_history_return = $_POST['input_search_history_return'];
    $select_date_history_return = $_POST['select_date_history_return'];
    $Userid = $_SESSION['Userid'];



    $select_date_history_return = explode("-", $select_date_history_return);
    $select_date_history_return = $select_date_history_return[2] . '-' . $select_date_history_return[1] . '-' . $select_date_history_return[0];


    $return = [];

    $IsAdmin = $_SESSION['IsAdmin'];

    $return = [];
    if ($IsAdmin == 1) {
        $where = "";
    } else {
        $where = " AND log_return.userID  = '$Userid' ";
    }


    $query = " SELECT
                    item.itemname,
                    itemstock.UsageCode,
                    CONCAT(employee.FirstName , ' ' , employee.LastName) AS FirstName,
                    log_return.DocNo,
	                log_return.createAt  ,
	                deproom.hn_record_id  ,
	                deproom.number_box  
                FROM
                    log_return
                    INNER JOIN itemstock ON log_return.itemstockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN users ON log_return.userID = users.ID
                    INNER JOIN employee ON users.EmpCode = employee.EmpCode 
                    INNER JOIN deproom ON deproom.DocNo = log_return.DocNo 
                WHERE  item.itemname LIKE '%$input_search_history_return%' 
                AND DATE(log_return.createAt) = '$select_date_history_return' 
                 $where
                ORDER BY log_return.createAt DESC ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['hn_record_id'] == '') {
            $row['hn_record_id'] = $row['number_box'];
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}



function deleteReturn($conn, $db)
{
    $return = [];
    $itemcode = $_POST['itemcode'];

    $update = "UPDATE itemstock SET itemstock.IsCross = 0 WHERE itemstock.ItemCode = '$itemcode' AND itemstock.IsCross = 9 ";
    $meQuery = $conn->prepare($update);
    $meQuery->execute();
    
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata_waitReturn($conn, $db)
{
    $DepID = $_SESSION['DepID'];
    $Userid = $_SESSION['Userid'];
    $IsAdmin = $_SESSION['IsAdmin'];
    $isShowUsage = $_POST['isShowUsage'];

    $return = [];
    // if ($IsAdmin == 1) {
    //     $where = "";
    // } else {
    //     $where = "  ";
    // }

    if ($isShowUsage == 1) {
        $query = " SELECT
                        item.itemname,
                        itemstock.UsageCode AS itemcode ,
                        1 AS cnt
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    WHERE
                        itemstock.IsCross = 9
                       AND itemstock.return_userID  = '$Userid'
                    ORDER BY itemstock.ReturnDate DESC ";
    } else {
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
                       AND itemstock.return_userID  = '$Userid'
                    GROUP BY
	                    item.itemname  
                    ORDER BY itemstock.ReturnDate DESC ";
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



function onReturnData($conn, $db)
{




    $Userid = $_SESSION['Userid'];


    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID ,
                    item.item_status,
                    item.itemtypeID2 AS itemtypeID 
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE   itemstock.IsCross = 9
                AND itemstock.return_userID  = '$Userid'  ";


    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];

        $_item_status =  $row_1['item_status'];
        $_itemtypeID =  $row_1['itemtypeID'];


        $count_itemstock++;

        if ($_Isdeproom == 1) {
            $count_itemstock = 0;

            $query_2 = "SELECT
                            deproomdetailsub.ID ,
                            hncode_detail.ID AS hndetail_ID,
                            hncode.DocNo AS DocNoHN,
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
                $_DocNoHN = $row_2['DocNoHN'];
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

                $insert_log = "INSERT INTO log_return (itemstockID, DocNo, userID, itemCode , createAt) 
                            VALUES (:itemstockID, :DocNo, :userID, :itemCode, NOW())";

                $meQuery_log = $conn->prepare($insert_log);

                $meQuery_log->bindParam(':itemstockID', $_RowID);
                $meQuery_log->bindParam(':DocNo', $_DocNo);
                $meQuery_log->bindParam(':userID', $Userid);
                $meQuery_log->bindParam(':itemCode', $_ItemCode);
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

                $check_his = "SELECT his.IsStatus FROM his WHERE DocNo_deproom = '$_DocNo' ";
                $meQuery_his = $conn->prepare($check_his);
                $meQuery_his->execute();

                // exit;
                while ($row_his = $meQuery_his->fetch(PDO::FETCH_ASSOC)) {

                    // ค้นหา DocNo จาก DocNo_SS ก่อน
                    $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                    $stmtDocNo = $conn->prepare($sqlDocNo);
                    $stmtDocNo->execute([$_DocNo]);
                    $row = $stmtDocNo->fetch(PDO::FETCH_ASSOC);

                    if ($row && $row['DocNo']) {
                        $DocNo_real = $row['DocNo'];

                        // 1. UPDATE Qty - 1
                        $update = "UPDATE his_detail 
                                    SET Qty = Qty - 1
                                    WHERE ItemCode = ?
                                    AND Qty > 0
                                    AND DocNo = ?";
                        $stmtUpdate = $conn->prepare($update);
                        $stmtUpdate->execute([$_ItemCode, $DocNo_real]);

                        // 2. DELETE ถ้า Qty = 0
                        $delete = "DELETE FROM his_detail 
                                    WHERE ItemCode = ?
                                    AND DocNo = ?
                                    AND Qty = 0";
                        $stmtDelete = $conn->prepare($delete);
                        $stmtDelete->execute([$_ItemCode, $DocNo_real]);
                    }
                }
            }



            $queryUpdate = "UPDATE itemstock 
            SET Isdeproom = 0 ,
            departmentroomid = '35',
            itemstock.IsCross = NULL
            WHERE
            RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();


            if ($_item_status == 3) {
                if (isset($_DocNoHN) && !empty($_DocNoHN)) {
                    oncheck_delete_pay_mapping_block($conn, $db, $_ItemCode, $_DocNo, $_ModifyDate, $_item_status, $_DocNo, $_itemtypeID, $_DocNoHN, 0);
                    $count_itemstock = 3;
                } else {
                    $count_itemstock = 0;
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
    $Userid = $_SESSION['Userid'];

    $update1 = "UPDATE itemstock SET  itemstock.IsCross = 9 , itemstock.ReturnDate = NOW(), itemstock.return_userID = $Userid  WHERE itemstock.UsageCode = '$UsageCode' LIMIT 1 ";


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
                        itemstock.UsageCode,
                        itemstock.Isdeproom,
                        itemstock.IsCross
                    FROM
                        itemstock
                    WHERE
                        --   ( itemstock.IsCross IS NULL  OR itemstock.IsCross = 0 )
                        -- AND
                         itemstock.UsageCode = '$UsageCode' LIMIT 1 ";



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


    $sql2 = " UPDATE hncode SET DocDate = '$input_date_service'  WHERE DocNo_SS = '$DocNo_pay' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();


    echo json_encode($DocNo_pay);
    unset($conn);
    die;
}


function block_item_byDocNo($conn, $db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $sql_1 = " UPDATE deproom SET IsBlock = 1   WHERE DocNo = '$txt_docno_request' ";
    $sql_2 = " UPDATE hncode SET IsBlock = 1 WHERE DocNo_SS = '$txt_docno_request' ";
    $meQuery1 = $conn->prepare($sql_1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($sql_2);
    $meQuery2->execute();

    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}

function cancel_item_byDocNo($conn, $db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $Remark = $_POST['Remark'];
    $Userid = $_SESSION['Userid'];

    if ($Remark == 'sell') {
        $sql1 = " UPDATE sell_department SET IsCancel = 1 , ModifyDate = NOW()  WHERE DocNo = '$txt_docno_request' ";
        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();



        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID IN (   SELECT
                                                                sell_department_detail.ItemStockID 
                                                            FROM
                                                                sell_department_detail
                                                            WHERE sell_department_detail.DocNo = '$txt_docno_request'  )
        AND departmentroomid = (SELECT departmentID FROM sell_department WHERE sell_department.DocNo = '$txt_docno_request'  ) 
        AND  IsStatus = '9'
        AND DATE(CreateDate) = (  SELECT
                                        DATE( sell_department.serviceDate ) 
                                    FROM
                                        sell_department
                                    WHERE
                                        sell_department.DocNo = '$txt_docno_request'  ) ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();



        $sql3 = "DELETE sell_department_detail
                FROM sell_department_detail
            WHERE sell_department_detail.DocNo = '$txt_docno_request' ";

        $meQuery3 = $conn->prepare($sql3);
        $meQuery3->execute();
    } else {
        $insert_log = "INSERT INTO log_activity_users (itemCode, qty, isStatus, DocNo, userID, createAt) 
                        VALUES ('', :qty, :isStatus, :DocNo, :Userid, NOW())";

        $meQuery_log = $conn->prepare($insert_log);

        $meQuery_log->bindValue(':qty', 0, PDO::PARAM_INT);
        $meQuery_log->bindValue(':isStatus', 9, PDO::PARAM_INT);
        $meQuery_log->bindParam(':DocNo', $txt_docno_request);
        $meQuery_log->bindParam(':Userid', $Userid);


        $meQuery_log->execute();

        if ($db == 1) {
            $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = NOW()  WHERE DocNo = '$txt_docno_request' ";
            $sql_hn = " UPDATE hncode SET IsCancel = 1 WHERE DocNo_SS = '$txt_docno_request' ";
            $sql_his = " UPDATE his SET IsCancel = 1 WHERE DocNo_deproom = '$txt_docno_request' ";
            $sql_set_hn = " UPDATE set_hn SET IsCancel = 1 WHERE DocNo_deproom = '$txt_docno_request' ";
        } else {
            $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = GETDATE()  WHERE DocNo = '$txt_docno_request' ";
            $sql_hn = " UPDATE hncode SET IsCancel = 1 WHERE DocNo_SS = '$txt_docno_request' ";
            $sql_set_hn = " UPDATE set_hn SET IsCancel = 1 WHERE DocNo_deproom = '$txt_docno_request' ";
        }

        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();

        $meQuery_hn = $conn->prepare($sql_hn);
        $meQuery_hn->execute();

        $meQuery_his = $conn->prepare($sql_his);
        $meQuery_his->execute();

        $meQuery_set_hn = $conn->prepare($sql_set_hn);
        $meQuery_set_hn->execute();

        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemCode IN (   SELECT
                                                                                        deproomdetail.ItemCode 
                                                                                    FROM
                                                                                        deproomdetail
                                                                                    WHERE deproomdetail.DocNo = '$txt_docno_request'  )
        AND departmentroomid = (SELECT Ref_departmentroomid FROM deproom WHERE deproom.DocNo = '$txt_docno_request'  ) 
        AND  IsStatus = '1'
        AND DATE(CreateDate) = (  SELECT
                                        DATE( deproom.ServiceDate ) 
                                    FROM
                                        deproom
                                    WHERE
                                        deproom.DocNo = '$txt_docno_request'   ) ";

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


        $sql5 = "DELETE hncode_detail
                FROM hncode_detail
            INNER JOIN hncode ON hncode.DocNo = hncode_detail.DocNo
            WHERE hncode.DocNo_SS = '$txt_docno_request' ";
        $meQuery5 = $conn->prepare($sql5);
        $meQuery5->execute();
    }







    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}


function show_detail_history_block($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_date_history_s = $_POST['select_date_history_s'];
    $select_date_history_l = $_POST['select_date_history_l'];
    $select_deproom_history = $_POST['select_deproom_history'];
    $input_hn_history = $_POST['input_hn_history'];
    $select_doctor_history = $_POST['select_doctor_history'];
    $select_procedure_history = $_POST['select_procedure_history'];
    $check_Box = $_POST['check_Box'];


    $select_date_history_s = explode("-", $select_date_history_s);
    $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

    $select_date_history_l = explode("-", $select_date_history_l);
    $select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];


    $whereP = "";
    if ($select_procedure_history != "") {
        $whereP = "  AND deproom.`procedure` = '$select_procedure_history'  ";
    }
    $whereD = "";
    if ($select_doctor_history != "") {
        $whereD = "  AND deproom.`doctor` = '$select_doctor_history'  ";
    }

    $whereHN = "";
    if ($input_hn_history != "") {
        $whereHN = "  AND  ( deproom.hn_record_id LIKE '%$input_hn_history%' OR deproom.number_box LIKE '%$input_hn_history%' )  ";
    }

    $whereR = "";
    if ($select_deproom_history != "") {
        $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
    }

    $whereDate = "";
    if ($check_Box == 0) {
        $whereDate = " AND  DATE(deproom.serviceDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'  ";
    }
    if ($check_Box == 1) {
        $whereDate = " ";
    }



    $query = " SELECT
                        deproom.DocNo,
                        DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
                        DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
                        DATE_FORMAT(deproom.CreateDate, '%d-%m-%Y') AS CreateDate,
                        COUNT(deproomdetailsub.ID) AS cnt_pay,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,                        
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark,
                        deproom.doctor ,
                        deproom.`procedure`,
                        deproom.number_box,
                        employee.FirstName
                    FROM
                        deproom
                    LEFT JOIN
                        deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    LEFT JOIN
                        deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                    INNER JOIN
                        doctor ON doctor.ID = deproom.doctor
                    LEFT JOIN
                        `procedure` ON deproom.procedure = `procedure`.ID
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    LEFT JOIN users ON users.ID = deproom.userConfirm_pay
	                LEFT JOIN employee ON employee.EmpCode = users.EmpCode
                    WHERE
                            deproom.IsCancel = 0
                        AND deproom.Isblock = 1
                        $whereDate
                        $whereD
                        $whereP
                        $whereR
                        $whereHN
                    GROUP BY deproom.DocNo
                    ORDER BY deproom.ModifyDate DESC ";



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


function showDetail_item_history($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_item_history = $_POST['select_item_history'];
    $select_date_history_s = $_POST['select_date_history_s'];
    $select_date_history_l = $_POST['select_date_history_l'];


    $select_date_history_s = explode("-", $select_date_history_s);
    $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

    $select_date_history_l = explode("-", $select_date_history_l);
    $select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];


    $query = " SELECT
                    deproom.DocNo,
                    DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
                    DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
                    deproom.hn_record_id,
                    doctor.Doctor_Name,
                    IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,                        
                    departmentroom.departmentroomname,
                    doctor.ID AS doctor_ID,
                    `procedure`.ID AS procedure_ID,
                    departmentroom.id AS deproom_ID,
                    deproom.Remark,
                    deproom.doctor,
                    deproom.`procedure`,
                    deproom.number_box,
                    COUNT(deproomdetailsub.ID) AS count_itemstock
                FROM
                    deproom
                INNER JOIN
                    deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN
                    deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                INNER JOIN
                    doctor ON doctor.ID = deproom.doctor
                LEFT JOIN
                    `procedure` ON deproom.procedure = `procedure`.ID
                INNER JOIN
                    departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                LEFT JOIN users ON users.ID = deproom.userConfirm_pay
                WHERE
                    DATE(deproom.ServiceDate) BETWEEN  '$select_date_history_s' AND '$select_date_history_l'
                    AND deproom.IsCancel = 0
                    AND deproomdetail.ItemCode = '$select_item_history'
                GROUP BY deproom.DocNo

                UNION ALL

                SELECT
                    sell_department.DocNo,
                    DATE_FORMAT(sell_department.serviceDate, '%d-%m-%Y') AS serviceDate,
                    DATE_FORMAT(sell_department.serviceDate, '%H:%i') AS serviceTime,
                    department.DepName AS hn_record_id,
                    '' AS Doctor_Name,
                    '' AS Procedure_TH,
                    '' AS  departmentroomname,
                    0 AS doctor_ID,
                    0 AS procedure_ID,
                    sell_department.departmentID AS deproom_ID,
                    'Sell Department' AS Remark,
                    0 AS doctor,
                    0 AS `procedure`,
                    0 AS number_box,
                    COUNT(sell_department_detail.ID) AS count_itemstock
                FROM
                    sell_department
                INNER JOIN
                    sell_department_detail ON sell_department.DocNo = sell_department_detail.DocNo
                INNER JOIN
                    department ON sell_department.departmentID = department.ID
                LEFT JOIN
                    itemstock ON sell_department_detail.ItemStockID = itemstock.RowID
                WHERE
                    DATE(sell_department.serviceDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
                    AND sell_department.IsCancel = 0
                    AND sell_department_detail.ItemCode = '$select_item_history'
                GROUP BY sell_department.DocNo

                ORDER BY serviceDate DESC ";



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($row['procedure'], ',')) {
            $row['Procedure_TH'] = 'button';
        }
        if (str_contains($row['doctor'], ',')) {
            $row['Doctor_Name'] = 'button';
        }

        $return['item'][] = $row;
        $DocNo = $row['DocNo'];


        // $query2 = " SELECT
        //                 COUNT(itemstock.UsageCode) AS count_itemstock
        //             FROM
        //                 deproom
        //                 INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
        //                 INNER JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
        //                 INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
        //             WHERE
        //                 DATE( deproom.ServiceDate ) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
        //                 AND deproom.IsCancel = 0 
        //                 AND deproom.DocNo = '$DocNo' 
        //                 AND deproomdetail.ItemCode = '$select_item_history' 
        //             ORDER BY
        //                 deproom.ModifyDate DESC ";
        // $meQuery2 = $conn->prepare($query2);
        // $meQuery2->execute();
        // while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
        //     $return[$DocNo][] = $row2;
        // }
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function show_detail_history_ems($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];

    $query = "SELECT
                        deproom.DocNo,
                        DATE_FORMAT( deproom.serviceDate, '%d-%m-%Y' ) AS serviceDate,
                        DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
                        DATE_FORMAT( deproom.CreateDate, '%d-%m-%Y' ) AS CreateDate,
                        COUNT( deproomdetailsub.ID ) AS cnt_pay,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark,
                        deproom.doctor,
                        deproom.`procedure`,
                        deproom.number_box,
                        employee.FirstName 
                    FROM
                        deproom
                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                        INNER JOIN doctor ON doctor.ID = deproom.doctor
                        LEFT JOIN `procedure` ON deproom.PROCEDURE = `procedure`.ID
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        LEFT JOIN users ON users.ID = deproom.userConfirm_pay
                        LEFT JOIN employee ON employee.EmpCode = users.EmpCode 
                    WHERE
                         deproom.IsEms = 1 
                
                    GROUP BY
                        deproom.DocNo ";

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

function show_detail_history($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_date_history_s = $_POST['select_date_history_s'];
    $select_date_history_l = $_POST['select_date_history_l'];
    $select_deproom_history = $_POST['select_deproom_history'];
    $input_hn_history = $_POST['input_hn_history'];
    $select_doctor_history = $_POST['select_doctor_history'];
    $select_procedure_history = $_POST['select_procedure_history'];
    $select_deproom_sell_history = $_POST['select_deproom_sell_history'];
    $select_typeSearch_history = $_POST['select_typeSearch_history'];


    $select_date_history_s = explode("-", $select_date_history_s);
    $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];

    $select_date_history_l = explode("-", $select_date_history_l);
    $select_date_history_l = $select_date_history_l[2] . '-' . $select_date_history_l[1] . '-' . $select_date_history_l[0];

    // if (isset($_POST['select_doctor_history'])) {
    // }
    // if (isset($_POST['select_procedure_history'])) {
    // }

    $whereP = "";
    $whereP2 = "";
    if ($select_procedure_history != "") {
        // $select_procedure_history = implode(",", $select_procedure_history);
        // $whereP = " AND  FIND_IN_SET('$select_procedure_history', deproom.`procedure`) ";
        $whereP = "  AND deproom.`procedure` = '$select_procedure_history'  ";
        $whereP2 = " AND  department.DepName LIKE '%$select_procedure_history%'  ";
    }
    $whereD = "";
    $whereD2 = "";
    if ($select_doctor_history != "") {
        // $select_doctor_history = implode(",", $select_doctor_history);
        $whereD = "  AND deproom.`doctor` = '$select_doctor_history'  ";
        $whereD2 = " AND  department.DepName LIKE '%$select_doctor_history%'  ";
    }

    $whereHN = "";
    $whereHN2 = "";
    if ($input_hn_history != "") {
        $whereHN = "  AND  ( deproom.hn_record_id LIKE '%$input_hn_history%' OR deproom.number_box LIKE '%$input_hn_history%' )  ";
        $whereHN2 = " AND  department.DepName LIKE '%$input_hn_history%' ";
    }


    if ($db == 1) {



        $whereR = "";
        $whereR2 = "";
        if ($select_deproom_history != "") {
            $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
            $whereR2 = " AND  department.DepName LIKE '%$select_deproom_history%'  ";
        }

        $whereDD = "";
        $whereDD2 = "";
        if ($select_deproom_sell_history != "") {
            $whereDD = " AND departmentroom.departmentroomname LIKE '%$select_deproom_sell_history%' ";
            $whereDD2 = " AND  sell_department.departmentID = '$select_deproom_sell_history'  ";
        }

        if ($select_typeSearch_history == 5) {
            $whereDD = " AND departmentroom.departmentroomname LIKE '%sdsds%' ";
        }


        $query = "SELECT
                        deproom.DocNo,
                        DATE_FORMAT( deproom.serviceDate, '%d-%m-%Y' ) AS serviceDate,
                        DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
                        DATE_FORMAT( deproom.CreateDate, '%d-%m-%Y' ) AS CreateDate,
                        COUNT( deproomdetailsub.ID ) AS cnt_pay,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark,
                        deproom.doctor,
                        deproom.`procedure`,
                        deproom.number_box,
                        employee.FirstName 
                    FROM
                        deproom
                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                        INNER JOIN doctor ON doctor.ID = deproom.doctor
                        LEFT JOIN `procedure` ON deproom.PROCEDURE = `procedure`.ID
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        LEFT JOIN users ON users.ID = deproom.userConfirm_pay
                        LEFT JOIN employee ON employee.EmpCode = users.EmpCode 
                    WHERE
                        DATE( deproom.CreateDate ) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
                        AND deproom.IsCancel = 0 
                        AND deproom.IsEms = 0 
                         $whereD
                         $whereP
                         $whereR
                         $whereHN
                         $whereDD
                    GROUP BY
                        deproom.DocNo UNION ALL
                    SELECT
                        CAST( sell_department.DocNo AS CHAR ) AS DocNo,
                        DATE_FORMAT( sell_department.ServiceDate, '%d-%m-%Y' ) AS serviceDate,
                        DATE_FORMAT( sell_department.ServiceDate, '%H:%i' ) AS serviceTime,
                        DATE_FORMAT( sell_department.ServiceDate, '%d-%m-%Y' ) AS CreateDate,
                        0 AS cnt_pay,
                        department.DepName AS hn_record_id,
                        '' AS Doctor_Name,
                        '' AS Procedure_TH,
                        '' AS departmentroomname,
                        '' AS doctor_ID,
                        '' AS procedure_ID,
                        sell_department.departmentID AS deproom_ID,
                        'sell' AS Remark,
                        '' AS doctor,
                        '' AS `procedure`,
                        '' AS number_box,
                        '' AS FirstName 
                    FROM
                        sell_department
                        INNER JOIN department ON department.ID = sell_department.departmentID 
                    WHERE
                        DATE( sell_department.serviceDate ) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
                        AND sell_department.IsCancel = 0
                        $whereHN2
                        $whereP2
                        $whereD2
                        $whereR2
                        $whereDD2
                    GROUP BY
                        sell_department.DocNo 
                    ORDER BY
                        CreateDate DESC; ";



        // $query = " SELECT
        //                 deproom.DocNo,
        //                 DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y') AS serviceDate,
        //                 DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
        //                 DATE_FORMAT(deproom.CreateDate, '%d-%m-%Y') AS CreateDate,
        //                 COUNT(deproomdetailsub.ID) AS cnt_pay,
        //                 deproom.hn_record_id,
        //                 doctor.Doctor_Name,
        //                 IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,                        
        //                 departmentroom.departmentroomname,
        //                 doctor.ID AS doctor_ID,
        //                 `procedure`.ID AS procedure_ID,
        //                 departmentroom.id AS deproom_ID,
        //                 deproom.Remark,
        //                 deproom.doctor ,
        //                 deproom.`procedure`,
        //                 deproom.number_box,
        //                 employee.FirstName
        //             FROM
        //                 deproom
        //             LEFT JOIN
        //                 deproomdetail ON deproom.DocNo = deproomdetail.DocNo
        //             LEFT JOIN
        //                 deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
        //             INNER JOIN
        //                 doctor ON doctor.ID = deproom.doctor
        //             LEFT JOIN
        //                 `procedure` ON deproom.procedure = `procedure`.ID
        //             INNER JOIN
        //                 departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
        //             LEFT JOIN users ON users.ID = deproom.userConfirm_pay
        //             LEFT JOIN employee ON employee.EmpCode = users.EmpCode
        //             WHERE
        //                 DATE(deproom.CreateDate) BETWEEN '$select_date_history_s' AND '$select_date_history_l'
        //                 AND deproom.IsCancel = 0
        //                 $whereD
        //                 $whereP
        //                 $whereR
        //                 $whereHN
        //             GROUP BY deproom.DocNo
        //             ORDER BY deproom.ModifyDate DESC ";

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

function save_edit_ems($conn, $db)
{
    $DocNo_editHN_block = $_POST['DocNo_editHN_block'];
    $input_box_pay_editHN_block = $_POST['input_box_pay_editHN_block'];
    $input_Hn_pay_editHN_block = $_POST['input_Hn_pay_editHN_block'];
    $input_date_service_editHN_block = $_POST['input_date_service_editHN_block'];
    $input_time_service_editHN_block = $_POST['input_time_service_editHN_block'];
    $select_deproom_editHN_block = $_POST['select_deproom_editHN_block'];
    $procedure_edit_hn_block_Array = $_POST['procedure_edit_hn_block_Array'];
    $doctor_edit_hn_block_Array = $_POST['doctor_edit_hn_block_Array'];

    $procedure_edit_hn_block_Array = implode(",", $procedure_edit_hn_block_Array);
    $doctor_edit_hn_block_Array = implode(",", $doctor_edit_hn_block_Array);

    $return = array();


    $input_date_service_editHN_block = explode("-", $input_date_service_editHN_block);
    $input_date_service_editHN_block = $input_date_service_editHN_block[2] . '-' . $input_date_service_editHN_block[1] . '-' . $input_date_service_editHN_block[0];





    $update1 = "UPDATE deproom SET
                        number_box = :number_box,
                        hn_record_id = :hn_record_id,
                        serviceDate = :serviceDate,
                        Ref_departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure,
                        IsBlock = 0,
                        IsEms = 0
                WHERE DocNo = :DocNo";

    $stmt = $conn->prepare($update1);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN_block,
        ':hn_record_id' => $input_Hn_pay_editHN_block,
        ':serviceDate' => $input_date_service_editHN_block . ' ' . $input_time_service_editHN_block,
        ':Ref_departmentroomid' => $select_deproom_editHN_block,
        ':doctor' => $doctor_edit_hn_block_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_block_Array,
        ':DocNo' => $DocNo_editHN_block
    ]);

    $update2 = "UPDATE hncode SET
                        number_box = :number_box,
                        HnCode = :hn_record_id,
                        DocDate = :serviceDate,
                        departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure,
                        IsBlock = 0
                WHERE DocNo_SS = :DocNo";

    $stmt = $conn->prepare($update2);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN_block,
        ':hn_record_id' => $input_Hn_pay_editHN_block,
        ':serviceDate' => $input_date_service_editHN_block,
        ':Ref_departmentroomid' => $select_deproom_editHN_block,
        ':doctor' => $doctor_edit_hn_block_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_block_Array,
        ':DocNo' => $DocNo_editHN_block
    ]);




    echo json_encode($return);
    unset($conn);
    die;
}

function save_edit_hn_block($conn, $db)
{
    $DocNo_editHN_block = $_POST['DocNo_editHN_block'];
    $input_box_pay_editHN_block = $_POST['input_box_pay_editHN_block'];
    $input_Hn_pay_editHN_block = $_POST['input_Hn_pay_editHN_block'];
    $input_date_service_editHN_block = $_POST['input_date_service_editHN_block'];
    $input_time_service_editHN_block = $_POST['input_time_service_editHN_block'];
    $select_deproom_editHN_block = $_POST['select_deproom_editHN_block'];
    // $select_doctor_editHN_block = $_POST['select_doctor_editHN_block'];
    // $select_procedure_editHN_block = $_POST['select_procedure_editHN_block'];

    $procedure_edit_hn_block_Array = $_POST['procedure_edit_hn_block_Array'];
    $doctor_edit_hn_block_Array = $_POST['doctor_edit_hn_block_Array'];

    $procedure_edit_hn_block_Array = implode(",", $procedure_edit_hn_block_Array);
    $doctor_edit_hn_block_Array = implode(",", $doctor_edit_hn_block_Array);

    $return = array();


    $input_date_service_editHN_block = explode("-", $input_date_service_editHN_block);
    $input_date_service_editHN_block = $input_date_service_editHN_block[2] . '-' . $input_date_service_editHN_block[1] . '-' . $input_date_service_editHN_block[0];


    $query = "UPDATE itemstock_transaction_detail 
    SET departmentroomid = '$select_deproom_editHN_block'   
    WHERE 
        ItemStockID IN (
            SELECT deproomdetailsub.ItemStockID 
            FROM deproomdetail
            INNER JOIN deproomdetailsub 
                ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
            WHERE deproomdetail.DocNo = '$DocNo_editHN_block'
        )
        AND departmentroomid = (
            SELECT Ref_departmentroomid 
            FROM deproom 
            WHERE deproom.DocNo = '$DocNo_editHN_block'
        )
        AND IsStatus = '1'
        AND DATE(CreateDate) = (
            SELECT DATE(deproomdetailsub.PayDate)
            FROM deproom
            INNER JOIN deproomdetail 
                ON deproom.DocNo = deproomdetail.DocNo
            INNER JOIN deproomdetailsub 
                ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
            WHERE deproom.DocNo = '$DocNo_editHN_block'
            GROUP BY deproom.DocNo
        ) ";

    $meQueryq = $conn->prepare($query);
    $meQueryq->execute();


    $update1 = "UPDATE deproom SET
                        number_box = :number_box,
                        hn_record_id = :hn_record_id,
                        serviceDate = :serviceDate,
                        Ref_departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure,
                        IsBlock = 0
                WHERE DocNo = :DocNo";

    $stmt = $conn->prepare($update1);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN_block,
        ':hn_record_id' => $input_Hn_pay_editHN_block,
        ':serviceDate' => $input_date_service_editHN_block . ' ' . $input_time_service_editHN_block,
        ':Ref_departmentroomid' => $select_deproom_editHN_block,
        ':doctor' => $doctor_edit_hn_block_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_block_Array,
        ':DocNo' => $DocNo_editHN_block
    ]);

    $update2 = "UPDATE hncode SET
                        number_box = :number_box,
                        HnCode = :hn_record_id,
                        DocDate = :serviceDate,
                        departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure,
                        IsBlock = 0
                WHERE DocNo_SS = :DocNo";

    $stmt = $conn->prepare($update2);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN_block,
        ':hn_record_id' => $input_Hn_pay_editHN_block,
        ':serviceDate' => $input_date_service_editHN_block,
        ':Ref_departmentroomid' => $select_deproom_editHN_block,
        ':doctor' => $doctor_edit_hn_block_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_block_Array,
        ':DocNo' => $DocNo_editHN_block
    ]);



    //     $query = "UPDATE itemstock_transaction_detail 
    // SET departmentroomid = '$select_deproom_editHN'   
    // WHERE 
    //     ItemStockID IN (
    //         SELECT deproomdetailsub.ItemStockID 
    //         FROM deproomdetail
    //         INNER JOIN deproomdetailsub 
    //             ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
    //         WHERE deproomdetail.DocNo = '$DocNo_editHN'
    //     )
    //     AND departmentroomid = (
    //         SELECT Ref_departmentroomid 
    //         FROM deproom 
    //         WHERE deproom.DocNo = '$DocNo_editHN'
    //     )
    //     AND IsStatus = '1'
    //     AND DATE(CreateDate) = (
    //         SELECT DATE(deproomdetailsub.PayDate)
    //         FROM deproom
    //         INNER JOIN deproomdetail 
    //             ON deproom.DocNo = deproomdetail.DocNo
    //         INNER JOIN deproomdetailsub 
    //             ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
    //         WHERE deproom.DocNo = '$DocNo_editHN'
    //         GROUP BY deproom.DocNo
    //     ) ";

    // $meQueryq = $conn->prepare($query);
    // $meQueryq->execute();




    // $query_old = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
    // AND ItemCode = '$_ItemCode' 
    // AND departmentroomid = '$__Ref_departmentroomid' 
    // AND  IsStatus = '1'
    // AND DATE(CreateDate) = '$_ModifyDate' ";
    // $meQuery_old = $conn->prepare($query_old);
    // $meQuery_old->execute();


    // echo $doctor_edit_hn_Array;
    // exit;

    echo json_encode($return);
    unset($conn);
    die;
}

function save_edit_hn($conn, $db)
{
    $DocNo_editHN = $_POST['DocNo_editHN'];
    $input_box_pay_editHN = $_POST['input_box_pay_editHN'];
    $input_Hn_pay_editHN = $_POST['input_Hn_pay_editHN'];
    $input_date_service_editHN = $_POST['input_date_service_editHN'];
    $input_time_service_editHN = $_POST['input_time_service_editHN'];
    $select_deproom_editHN = $_POST['select_deproom_editHN'];
    $procedure_edit_hn_Array = $_POST['procedure_edit_hn_Array'];
    $doctor_edit_hn_Array = $_POST['doctor_edit_hn_Array'];

    $return = array();

    $procedure_edit_hn_Array = implode(",", $procedure_edit_hn_Array);
    $doctor_edit_hn_Array = implode(",", $doctor_edit_hn_Array);

    $input_date_service_editHN = explode("-", $input_date_service_editHN);
    $input_date_service_editHN = $input_date_service_editHN[2] . '-' . $input_date_service_editHN[1] . '-' . $input_date_service_editHN[0];

    // $select_deproom  = "";

    $query = "UPDATE itemstock_transaction_detail 
    SET departmentroomid = '$select_deproom_editHN'   ,  CreateDate = '$input_date_service_editHN'
    WHERE 
        ItemStockID IN (
            SELECT deproomdetailsub.ItemStockID 
            FROM deproomdetail
            INNER JOIN deproomdetailsub 
                ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
            WHERE deproomdetail.DocNo = '$DocNo_editHN'
        )
        AND departmentroomid = (
            SELECT Ref_departmentroomid 
            FROM deproom 
            WHERE deproom.DocNo = '$DocNo_editHN'
        )
        AND IsStatus = '1'
        AND DATE(CreateDate) = (
            SELECT DATE(deproom.ServiceDate)
            FROM deproom
            WHERE deproom.DocNo = '$DocNo_editHN'
        ) ";

    $meQueryq = $conn->prepare($query);
    $meQueryq->execute();


    if ($input_Hn_pay_editHN == '') {
        $input_Hn_pay_editHN_x = $input_box_pay_editHN;
    } else {
        $input_Hn_pay_editHN_x = $input_Hn_pay_editHN;
    }

    $qcheck = "SELECT
                    deproom.number_box,
                    deproom.hn_record_id
                FROM
                    deproom
                WHERE
                    deproom.DocNo = '$DocNo_editHN' ";

    // echo $qcheck;
    // exit;
    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_number_box_xx  = $rowq['number_box'];
        $_hn_record_id_xx  = $rowq['hn_record_id'];
    }
    if ($_hn_record_id_xx == '') {
        $_hn_record_id_xx = $_number_box_xx;
    }

    $update0 = "UPDATE deproomdetailsub SET
                        hn_record_id_borrow = :input_Hn_pay_editHN_x
                WHERE hn_record_id_borrow = :_hn_record_id_xx ";

    $stmt0 = $conn->prepare($update0);
    $stmt0->execute([
        ':input_Hn_pay_editHN_x' => $input_Hn_pay_editHN_x,
        ':_hn_record_id_xx' => $_hn_record_id_xx
    ]);


    $update1 = "UPDATE deproom SET
                        number_box = :number_box,
                        hn_record_id = :hn_record_id,
                        serviceDate = :serviceDate,
                        Ref_departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure
                WHERE DocNo = :DocNo";

    $stmt = $conn->prepare($update1);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN,
        ':hn_record_id' => $input_Hn_pay_editHN,
        ':serviceDate' => $input_date_service_editHN . ' ' . $input_time_service_editHN,
        ':Ref_departmentroomid' => $select_deproom_editHN,
        ':doctor' => $doctor_edit_hn_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_Array,
        ':DocNo' => $DocNo_editHN
    ]);

    $update2 = "UPDATE hncode SET
                        number_box = :number_box,
                        HnCode = :hn_record_id,
                        DocDate = :serviceDate,
                        departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure
                WHERE DocNo_SS = :DocNo";

    $stmt = $conn->prepare($update2);
    $stmt->execute([
        ':number_box' => $input_box_pay_editHN,
        ':hn_record_id' => $input_Hn_pay_editHN,
        ':serviceDate' => $input_date_service_editHN,
        ':Ref_departmentroomid' => $select_deproom_editHN,
        ':doctor' => $doctor_edit_hn_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_Array,
        ':DocNo' => $DocNo_editHN
    ]);

    $update3 = "UPDATE set_hn SET
                        hncode = :hn_record_id,
                        serviceDate = :serviceDate,
                        departmentroomid = :Ref_departmentroomid,
                        doctor = :doctor,
                        `procedure` = :procedure
                WHERE DocNo_deproom = :DocNo";

    $stmt = $conn->prepare($update3);
    $stmt->execute([
        ':hn_record_id' => $input_Hn_pay_editHN,
        ':serviceDate' => $input_date_service_editHN . ' ' . $input_time_service_editHN,
        ':Ref_departmentroomid' => $select_deproom_editHN,
        ':doctor' => $doctor_edit_hn_Array, // เห็นว่าคุณส่ง $input_box_pay_editHN ให้ doctor ด้วย ถูกไหมครับ?
        ':procedure' => $procedure_edit_hn_Array,
        ':DocNo' => $DocNo_editHN
    ]);





    // $query_old = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
    // AND ItemCode = '$_ItemCode' 
    // AND departmentroomid = '$__Ref_departmentroomid' 
    // AND  IsStatus = '1'
    // AND DATE(CreateDate) = '$_ModifyDate' ";
    // $meQuery_old = $conn->prepare($query_old);
    // $meQuery_old->execute();


    // echo $doctor_edit_hn_Array;
    // exit;

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
    $input_box_pay_manual = $_POST['input_box_pay_manual'];
    $checkbox_manual_ems = $_POST['checkbox_manual_ems'];

    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];
    $input_remark_manual = $_POST['input_remark_manual'];
    $checkbox_tf = $_POST['checkbox_tf'];


    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $select_procedure_manual = implode(",", $select_procedure_manual);
    $select_doctor_manual = implode(",", $select_doctor_manual);

    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];


    $count = 0;
    $count_itemstock = 0;


    // $count_itemstock++;


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
            $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $input_remark_manual, 0, 0, 0, 0, '', '', $input_Hn_pay_manual, $input_box_pay_manual, $db, 1, $checkbox_manual_ems, $checkbox_tf);
            $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 1, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual, $input_box_pay_manual);

            $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$input_date_service_manual $input_time_service_manual'  , hn_record_id = '$input_Hn_pay_manual' , doctor = '$select_doctor_manual' , `procedure` = '$select_procedure_manual' , Ref_departmentroomid = '$select_deproom_manual' WHERE DocNo = '$input_docNo_deproom_manual' AND IsCancel = 0 ";
            $meQueryUpdate = $conn->prepare($sql1);
            $meQueryUpdate->execute();




            $p = "      SELECT
                                MIN( `procedure`.`status` ) AS status 
                        FROM
                            `procedure` 
                        WHERE
                            `procedure`.ID IN ($select_procedure_manual) ";
            $meQueryp = $conn->prepare($p);
            $meQueryp->execute();
            while ($rowp = $meQueryp->fetch(PDO::FETCH_ASSOC)) {
                $_status = $rowp['status'];
            }

            $item = "SELECT item.ItemCode FROM item WHERE item.item_status2 = $_status OR  item.item_status = 1 ";
            $meQueryp = $conn->prepare($item);
            $meQueryp->execute();
            while ($rowp = $meQueryp->fetch(PDO::FETCH_ASSOC)) {
                $_itemcode = $rowp['ItemCode'];

                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,IsRequest )
                        VALUES
                            ( '$input_docNo_deproom_manual', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

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
                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                deproomdetailsub.PayDate AS ModifyDate
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

                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '$_itemcode'
                                                ) ";

                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'   ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


                    $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                    $stmtDoc = $conn->prepare($sqlDocNo);
                    $stmtDoc->execute([$input_docNo_deproom_manual]);
                    $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $docNo_hn = $row['DocNo'];

                        // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                        $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                        $stmtCheck = $conn->prepare($sqlCheck);
                        $stmtCheck->execute([$docNo_hn, $_itemcode]);
                        $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                        if ($resultCheck) {
                            // เจอแล้ว -> UPDATE Qty +1
                            $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                            $stmtUpdate = $conn->prepare($sqlUpdate);
                            $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                        } else {
                            // ไม่เจอ -> INSERT
                            $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                            $stmtInsert = $conn->prepare($sqlInsert);
                            $stmtInsert->execute([$docNo_hn, $_itemcode]);
                        }
                    }




                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                }
            }
            //  ======================
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
                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                        deproomdetailsub.PayDate AS ModifyDate
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

            $count_itemstock = 1;

            $count_new_item_itemcode++;
            $_ID = $row_2['ID'];
            $_departmentroomid = $row_2['departmentroomid'];
            $_procedure = $row_2['procedure'];
            $_hn_record_id = $row_2['hn_record_id'];
            $_doctor = $row_2['doctor'];
            $_ModifyDate = $row_2['ModifyDate'];


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
            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,Ismanual)
                VALUES
                    ( '$input_docNo_deproom_manual', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW(), 1 )";

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
                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                deproomdetailsub.PayDate AS ModifyDate
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

                $count_itemstock = 1;

                $_ID = $row_2['ID'];
                $_PayDate = $row_2['PayDate'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_Qty_detail = $row_2['Qty'];
                $_Qty_detail_sub = $row_2['cnt_sub'];
                $_ModifyDate = $row_2['ModifyDate'];

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

                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
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
                            item.item_status,
                            item.itemtypeID2 AS itemtypeID ,
                            item.IsSet,
                            CASE
                                    WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                    ELSE 'no_exp'
                                END AS check_exp
                        FROM
                            itemstock 
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode
                        WHERE
                                itemstock.UsageCode = '$input_pay_manual'
                                AND itemstock.IsCancel = 0
                                AND itemstock.Adjust_stock = 0 ";
        // AND itemstock.departmentroomid = '35' 
        // AND itemstock.Isdeproom = '0' 
        // AND itemstock.HNCode = '$input_Hn_pay_manual' ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

            $count_itemstock = 1;
            $_check_exp = $row['check_exp'];
            $_item_status = $row['item_status'];
            $_itemtypeID = $row['itemtypeID'];
            $_IsSet = $row['IsSet'];


            if ($_check_exp == 'no_exp') {
                if ($input_docNo_deproom_manual == "") {
                    $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
                    $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $input_remark_manual, 0, 0, 0, 0, '', '', $input_Hn_pay_manual, $input_box_pay_manual, $db, 1, $checkbox_manual_ems, $checkbox_tf);
                    $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 1, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual, $input_box_pay_manual, $checkbox_tf);

                    $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$input_date_service_manual $input_time_service_manual'  , hn_record_id = '$input_Hn_pay_manual' , doctor = '$select_doctor_manual' , `procedure` = '$select_procedure_manual' , Ref_departmentroomid = '$select_deproom_manual' WHERE DocNo = '$input_docNo_deproom_manual' AND IsCancel = 0 ";
                    $meQueryUpdate = $conn->prepare($sql1);
                    $meQueryUpdate->execute();


                    $p = " SELECT
                                MIN( `procedure`.`status` ) AS status 
                        FROM
                            `procedure` 
                        WHERE
                            `procedure`.ID IN ($select_procedure_manual)  ";
                    $meQueryp = $conn->prepare($p);
                    $meQueryp->execute();
                    while ($rowp = $meQueryp->fetch(PDO::FETCH_ASSOC)) {
                        $_status = $rowp['status'];
                    }

                    $item = "SELECT item.ItemCode FROM item WHERE item.item_status2 = $_status  OR  item.item_status = 1 ";
                    $meQueryp = $conn->prepare($item);
                    $meQueryp->execute();
                    while ($rowp = $meQueryp->fetch(PDO::FETCH_ASSOC)) {
                        $_itemcode = $rowp['ItemCode'];

                        $queryInsert99 = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,IsRequest )
                        VALUES
                            ( '$input_docNo_deproom_manual', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

                        $meQueryInsert99 = $conn->prepare($queryInsert99);
                        $meQueryInsert99->execute();

                        $query_299 = "SELECT
                                deproomdetail.ID,
                                deproom.Ref_departmentroomid AS departmentroomid,
                                deproom.`procedure`,
                                deproom.doctor,
                                deproom.hn_record_id,
                                deproomdetail.ItemCode,
                                deproomdetail.Qty ,
                                deproomdetail.PayDate ,
                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                deproomdetailsub.PayDate AS ModifyDate
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
                        $meQuery_299 = $conn->prepare($query_299);
                        $meQuery_299->execute();
                        while ($row_299 = $meQuery_299->fetch(PDO::FETCH_ASSOC)) {
                            $_ID = $row_299['ID'];
                            $_departmentroomid = $row_299['departmentroomid'];
                            $_procedure = $row_299['procedure'];
                            $_hn_record_id = $row_299['hn_record_id'];
                            $_doctor = $row_299['doctor'];


                            $queryInsert199 = "INSERT INTO deproomdetailsub (
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

                            $queryInsert199 = $conn->prepare($queryInsert199);
                            $queryInsert199->execute();

                            $query99 = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                                        VALUES
                                        ( '0', '$_itemcode','$input_date_service_manual','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                            $meQuery99 = $conn->prepare($query99);
                            $meQuery99->execute();

                            $queryInsert299 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '$_itemcode'
                                                ) ";

                            $query_updateHN99 = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'   ";
                            $query_updateHN99 = $conn->prepare($query_updateHN99);
                            $query_updateHN99->execute();


                            $sqlDocNo99 = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                            $stmtDoc99 = $conn->prepare($sqlDocNo99);
                            $stmtDoc99->execute([$input_docNo_deproom_manual]);
                            $row99 = $stmtDoc99->fetch(PDO::FETCH_ASSOC);

                            if ($row99) {
                                $docNo_hn = $row['DocNo'];

                                // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                                $sqlCheck99 = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                                $stmtCheck99 = $conn->prepare($sqlCheck99);
                                $stmtCheck99->execute([$docNo_hn, $_itemcode]);
                                $resultCheck99 = $stmtCheck99->fetch(PDO::FETCH_ASSOC);

                                if ($resultCheck99) {
                                    // เจอแล้ว -> UPDATE Qty +1
                                    $sqlUpdate99 = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                                    $stmtUpdate99 = $conn->prepare($sqlUpdate99);
                                    $stmtUpdate99->execute([$docNo_hn, $_itemcode]);
                                } else {
                                    // ไม่เจอ -> INSERT
                                    $sqlInsert99 = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                                    $stmtInsert99 = $conn->prepare($sqlInsert99);
                                    $stmtInsert99->execute([$docNo_hn, $_itemcode]);
                                }
                            }




                            $queryInsert299 = $conn->prepare($queryInsert299);
                            $queryInsert299->execute();
                        }
                    }
                    //  ======================

                }

                $_ItemCode = $row['ItemCode'];
                $_Isdeproom =  $row['Isdeproom'];
                $_departmentroomid =  $row['departmentroomid'];
                $_RowID =  $row['RowID'];

                $count_itemstock++;

                $count_itemstock = 0;
                $count_new_item = 0;


                if ($_Isdeproom == 0) {

                    $query_2 = "SELECT
                                        deproomdetail.ID,
                                        deproom.Ref_departmentroomid AS departmentroomid,
                                        deproom.`procedure`,
                                        deproom.doctor,
                                        deproom.hn_record_id,
                                        deproomdetail.ItemCode,
                                        deproomdetail.Qty ,
                                        deproomdetail.PayDate ,
                                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                        $_ModifyDate = $row_2['ModifyDate'];


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
                                                Stockin = 1,
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



                        if ($_item_status == 2 || $_item_status == 3) {
                            oncheck_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, 1, $_itemtypeID, $_IsSet);
                            // $count_itemstock = 2;
                        }
                    }


                    if ($count_new_item  == 0) {

                        $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,Ismanual)
                                            VALUES
                                                ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() ,1)";





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
                                            COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                            deproomdetailsub.PayDate AS ModifyDate
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
                            $_ModifyDate = $row_2['ModifyDate'];

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
                                            Stockin = 1,
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

                            if ($_item_status == 2 || $_item_status == 3) {
                                oncheck_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, 1, $_itemtypeID, $_IsSet);
                                // $count_itemstock = 2;
                            }
                        }
                    }


                    $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
                    $meQueryPay = $conn->prepare($updatePay);
                    $meQueryPay->execute();


                    $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                                    VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                    $meQuery_log = $conn->prepare($insert_log);

                    $meQuery_log->bindParam(':itemCode', $_ItemCode);
                    $meQuery_log->bindParam(':itemstockID', $_RowID);
                    $meQuery_log->bindValue(':isStatus', 6, PDO::PARAM_INT);
                    $meQuery_log->bindParam(':DocNo', $input_docNo_deproom_manual);
                    $meQuery_log->bindParam(':Userid', $Userid);


                    $meQuery_log->execute();
                }


                if ($_Isdeproom == 1) {


                    $query_old = "SELECT
                                        deproomdetailsub.ID,
                                        deproomdetail.ID AS detailID,
                                        hncode_detail.ID AS hndetail_ID,
                                        deproomdetail.ItemCode,
                                        deproomdetail.Qty AS deproom_qty,
                                        hncode_detail.Qty AS hncode_qty ,
                                        deproom.hn_record_id,
                                        DATE(deproom.serviceDate) AS serviceDate ,
                                        deproom.Ref_departmentroomid ,
                                        DATE(deproom.serviceDate)  AS ModifyDate,
                                        deproomdetailsub.PayDate,
                                        deproom.number_box,
                                        deproom.DocNo
                                    FROM
                                        deproom
                                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                        LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                                    WHERE
                                        deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetailsub.ItemStockID = '$_RowID'
                                        AND hncode_detail.ItemStockID = '$_RowID' 
                                        ORDER BY deproomdetailsub.ID DESC
                                        LIMIT 1 ";




                    $meQuery_old = $conn->prepare($query_old);
                    $meQuery_old->execute();
                    while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                        $_DocNo = $row_old['DocNo'];
                        $detailID = $row_old['detailID'];
                        $hndetail_ID = $row_old['hndetail_ID'];
                        $deproom_qty = $row_old['deproom_qty'];
                        $hncode_qty = $row_old['hncode_qty'];
                        $deproomdetailsub_id = $row_old['ID'];
                        $_hn_record_id_borrow = $row_old['hn_record_id'];
                        $_Ref_departmentroomid = $row_old['Ref_departmentroomid'];
                        $_ModifyDate = $row_old['ModifyDate'];
                        $_number_box = $row_old['number_box'];

                        if ($_hn_record_id_borrow == "") {
                            $_hn_record_id_borrow = $_number_box;
                        }
                        $_PayDate = $row_old['PayDate'];
                        // $_datecheck = $row_old['datecheck'];

                    }

                    if ($input_docNo_deproom_manual != $_DocNo) {
                        // if ($input_Hn_pay_manual != $_hn_record_id_borrow  || $input_box_pay_manual != $_number_box || $_PayDate != $_datecheck) {

                        // =======================================================================================================================================

                        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                            AND ItemCode = '$_ItemCode' 
                            AND departmentroomid = '$_Ref_departmentroomid' 
                            AND  IsStatus = '1'
                            AND DATE(CreateDate) = '$_ModifyDate' ";

                        $meQuery = $conn->prepare($query);
                        $meQuery->execute();
                        // =======================================================================================================================================



                        $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                        $meQuery_old_sub = $conn->prepare($update_old_sub);
                        $meQuery_old_sub->execute();

                        $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$hndetail_ID' ";
                        $meQueryD2 = $conn->prepare($queryD2);
                        $meQueryD2->execute();


                        if ($_item_status == 3) {
                            oncheck_delete_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, $_DocNo, 2, $input_docNo_HN_manual, 1);
                            // $count_itemstock = 2;
                        }

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
                                            COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                            deproomdetailsub.PayDate AS ModifyDate
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
                            $_ModifyDate = $row_2['ModifyDate'];
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
                                                    Stockin = 1,
                                                    departmentroomid = '$_departmentroomid'
                                                    WHERE
                                                    RowID = '$_RowID' ";
                            $meQueryUpdate = $conn->prepare($queryUpdate);
                            $meQueryUpdate->execute();
                            // ==============================
                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel)  VALUES             
                                                            (
                                                            '$input_docNo_HN_manual', 
                                                            '$input_pay_manual',
                                                            '$_RowID',
                                                            1, 
                                                            1, 
                                                            0
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

                            if ($_item_status == 2 || $_item_status == 3) {
                                oncheck_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, 1, $_itemtypeID, $_IsSet);
                                // $count_itemstock = 2;
                            }
                        }


                        if ($count_new_item  == 0) {

                            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,Ismanual)
                                                VALUES
                                                    ( '$input_docNo_deproom_manual', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() ,1)";





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
                                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                               deproomdetailsub.PayDate AS ModifyDate
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
                                $_ModifyDate = $row_2['ModifyDate'];

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
                                                Stockin = 1,
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

                                if ($_item_status == 2 || $_item_status == 3) {
                                    oncheck_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, 1, $_itemtypeID, $_IsSet);
                                    // $count_itemstock = 2;
                                }
                            }
                        }


                        $updatePay = "UPDATE deproom SET UserPay = $Userid WHERE deproom.DocNo = '$input_docNo_deproom_manual' ";
                        $meQueryPay = $conn->prepare($updatePay);
                        $meQueryPay->execute();
                        // }
                        // else{
                        //     $count_itemstock = 3;
                        // }

                        $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                            VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                        $meQuery_log = $conn->prepare($insert_log);

                        $meQuery_log->bindParam(':itemCode', $_ItemCode);
                        $meQuery_log->bindParam(':itemstockID', $_RowID);
                        $meQuery_log->bindValue(':isStatus', 6, PDO::PARAM_INT);
                        $meQuery_log->bindParam(':DocNo', $input_docNo_deproom_manual);
                        $meQuery_log->bindParam(':Userid', $Userid);


                        $meQuery_log->execute();
                    } else {
                        $count_itemstock = 3;
                    }
                }
            } else {
                $count_itemstock = '9';
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
        $_ItemCode  = $rowq['itemcode'];
        $check_barcode++;
    }

    $count_itemstock = 0;

    if ($check_barcode > 0) {


        $query_2 = "SELECT
                                deproomdetailsub.ID,
                                hncode_detail.ID AS hndetail_ID,
                                deproomdetail.ItemCode,
                                DATE( deproom.serviceDate ) AS ModifyDate ,
                                deproom.Ref_departmentroomid,
                                deproomdetail.ID AS deproomDetail_ID
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$input_docNo_deproom_manual' 
                                LIMIT 1 ";
        // echo $query_2;
        // exit;
        $meQuery_2 = $conn->prepare($query_2);
        $meQuery_2->execute();
        while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

            $count_itemstock++;

            $return[] = $row_2;

            $_ID = $row_2['ID'];
            $_deproomDetail_ID = $row_2['deproomDetail_ID'];
            $_hndetail_ID = $row_2['hndetail_ID'];
            $_ModifyDate = $row_2['ModifyDate'];
            $_departmentroomid = $row_2['Ref_departmentroomid'];

            // ==============================
            $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
            $meQueryD1 = $conn->prepare($queryD1);
            $meQueryD1->execute();


            $sqlCheck1 = "SELECT Qty FROM deproomdetail WHERE ID = ? ";
            $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
            $stmtCheck1->execute([$_deproomDetail_ID]);
            $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

            if ($resultCheck1) {
                if ($resultCheck1['Qty'] > 1) {
                    // ถ้า Qty มากกว่า 1 -> ลบ 1
                    $sqlUpdate = "UPDATE deproomdetail SET Qty = Qty - 1 WHERE ID = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->execute([$_deproomDetail_ID]);
                } else {
                    // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                    $sqlDelete = "DELETE FROM deproomdetail WHERE ID = ?";
                    $stmtDelete = $conn->prepare($sqlDelete);
                    $stmtDelete->execute([$_deproomDetail_ID]);
                }
            }



            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
            $sqlCheck1 = "SELECT Qty FROM hncode_detail WHERE ID = ? ";
            $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
            $stmtCheck1->execute([$_hndetail_ID]);
            $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

            if ($resultCheck1) {
                if ($resultCheck1['Qty'] > 1) {
                    // ถ้า Qty มากกว่า 1 -> ลบ 1
                    $sqlUpdate = "UPDATE hncode_detail SET Qty = Qty - 1 WHERE ID = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->execute([$_hndetail_ID]);
                } else {
                    // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                    $sqlDelete = "DELETE FROM hncode_detail WHERE ID = ?";
                    $stmtDelete = $conn->prepare($sqlDelete);
                    $stmtDelete->execute([$_hndetail_ID]);
                }
            }


            // $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
            // $meQueryD2 = $conn->prepare($queryD2);
            // $meQueryD2->execute();
            // ==============================

            //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

            $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$input_docNo_deproom_manual' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCode'
                            AND deproomdetail.IsRequest = 1
                        GROUP BY
                            deproomdetail.ID ";
            $meQuery_qq1 = $conn->prepare($qq1);
            $meQuery_qq1->execute();
            while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                if ($row_qq1['cnt_pay'] == '0') {
                    $ID_Detail = $row_qq1['ID'];
                    $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                    $meQueryqq1 = $conn->prepare($queryqq1);
                    $meQueryqq1->execute();
                }
            }
            // =======================================================================================================================================

            $query = "DELETE FROM itemstock_transaction_detail  WHERE  ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND DATE(CreateDate) = '$_ModifyDate' LIMIT 1 ";



            $meQuery = $conn->prepare($query);
            $meQuery->execute();
            // =======================================================================================================================================





        }
    }

    // if ($check_barcode > 0) {

    //     $query_2 = "SELECT
    //                     deproomdetailsub.ID ,
    //                     deproomdetail.ID AS detailID,
    //                     hncode_detail.ID AS hndetail_ID,
    //                     deproomdetail.ItemCode,
    //                     SUM(deproomdetail.Qty) AS deproom_qty,
    //                     SUM(hncode_detail.Qty) AS hncode_qty
    //                 FROM
    //                     deproom
    //                     INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
    //                     LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
    //                     INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
    //                     INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
    //                 WHERE
    //                     deproomdetail.ItemCode = '$_itemcode' 
    //                     AND deproomdetail.DocNo = '$input_docNo_deproom_manual'
    //                     AND hncode_detail.ItemCode = '$_itemcode' ";
    //     // echo $query_2;
    //     // exit;
    //     $meQuery_2 = $conn->prepare($query_2);
    //     $meQuery_2->execute();
    //     while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

    //         $return[] = $row_2;

    //         $_ID = $row_2['ID'];
    //         $_hndetail_ID = $row_2['hndetail_ID'];
    //         $deproom_qty = $row_2['deproom_qty'];
    //         $hncode_qty = $row_2['hncode_qty'];
    //         $detailID = $row_2['detailID'];

    //         // ==============================
    //         if ($deproom_qty == 0) {
    //             $queryD1 = "DELETE FROM deproomdetail WHERE ID =  '$detailID' ";
    //             $meQueryD1 = $conn->prepare($queryD1);
    //             $meQueryD1->execute();
    //         } else {

    //             $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
    //             $meQueryD1 = $conn->prepare($queryD1);
    //             $meQueryD1->execute();

    //             $queryInsert0 = "UPDATE deproomdetail SET Qty = Qty-1 WHERE  deproomdetail.ID = '$detailID' ";
    //             $meQuery0 = $conn->prepare($queryInsert0);
    //             $meQuery0->execute();
    //         }
    //         if ($hncode_qty == 0) {
    //             $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
    //             $meQueryD2 = $conn->prepare($queryD2);
    //             $meQueryD2->execute();
    //         } else {
    //             $queryInsert0 = "UPDATE hncode_detail SET Qty = Qty-1 WHERE  ID =  '$_hndetail_ID' ";
    //             $meQuery0 = $conn->prepare($queryInsert0);
    //             $meQuery0->execute();
    //         }


    //         // ==============================

    //         // =======================================================================================================================================

    //         // if ($db == 1) {
    //         //     $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
    //         // AND ItemCode = '$_ItemCode' 
    //         // AND departmentroomid = '$_departmentroomid' 
    //         // AND  IsStatus = '1'
    //         // AND DATE(CreateDate) = '$input_date_service_manual' ";
    //         // } else {
    //         //     $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
    //         // AND ItemCode = '$_ItemCode' 
    //         // AND departmentroomid = '$_departmentroomid' 
    //         // AND  IsStatus = '1'
    //         // AND CONVERT(DATE,CreateDate) = '$input_date_service_manual' ";
    //         // }

    //         // $meQuery = $conn->prepare($query);
    //         // $meQuery->execute();
    //         // =======================================================================================================================================



    //         // $queryUpdate = "UPDATE itemstock 
    //         // SET Isdeproom = 0 ,
    //         // departmentroomid = '35'
    //         // WHERE
    //         // RowID = '$_RowID' ";
    //         // $meQueryUpdate = $conn->prepare($queryUpdate);
    //         // $meQueryUpdate->execute();
    //         // // ==============================
    //         // $count_itemstock++;
    //     }
    // }

    if ($check_barcode == 0) {
        $query_1 = " SELECT
                        itemstock.ItemCode,
                        itemstock.Isdeproom,
                        itemstock.departmentroomid ,
                        itemstock.RowID ,
                        item.item_status,
                        item.itemtypeID2 AS itemtypeID 
                    FROM
                        itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    WHERE  itemstock.UsageCode = '$input_returnpay_manual'  ";


        $count_itemstock = 0;
        $meQuery_1 = $conn->prepare($query_1);
        $meQuery_1->execute();
        while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

            $_ItemCode = $row_1['ItemCode'];
            $_Isdeproom =  $row_1['Isdeproom'];
            $_departmentroomid =  $row_1['departmentroomid'];
            $_RowID =  $row_1['RowID'];
            $_item_status =  $row_1['item_status'];
            $_itemtypeID =  $row_1['itemtypeID'];

            $count_itemstock++;

            if ($_Isdeproom == 1) {
                $count_itemstock = 0;

                $query_2 = "SELECT
                                deproomdetailsub.ID ,
                                hncode_detail.ID AS hndetail_ID,
                                deproomdetail.ItemCode,
                                DATE(deproom.serviceDate)  AS ModifyDate
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
                    $_ModifyDate = $row_2['ModifyDate'];

                    // ==============================
                    $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
                    $meQueryD1 = $conn->prepare($queryD1);
                    $meQueryD1->execute();

                    $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
                    $meQueryD2 = $conn->prepare($queryD2);
                    $meQueryD2->execute();
                    // ==============================


                    $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$input_docNo_deproom_manual' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCode'
                        GROUP BY
                            deproomdetail.ID ";
                    $meQuery_qq1 = $conn->prepare($qq1);
                    $meQuery_qq1->execute();
                    while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                        if ($row_qq1['cnt_pay'] == '0') {
                            $ID_Detail = $row_qq1['ID'];
                            $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                            $meQueryqq1 = $conn->prepare($queryqq1);
                            $meQueryqq1->execute();
                        }
                    }



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

                $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                            VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                $meQuery_log = $conn->prepare($insert_log);

                $meQuery_log->bindParam(':itemCode', $_ItemCode);
                $meQuery_log->bindParam(':itemstockID', $_RowID);
                $meQuery_log->bindValue(':isStatus', 7, PDO::PARAM_INT);
                $meQuery_log->bindParam(':DocNo', $input_docNo_deproom_manual);
                $meQuery_log->bindParam(':Userid', $Userid);


                $meQuery_log->execute();


                if ($_item_status == 3) {
                    oncheck_delete_pay_mapping($conn, $db, $_ItemCode, $input_docNo_deproom_manual, $input_date_service_manual, $_item_status, $input_docNo_deproom_manual, $_itemtypeID, $input_docNo_HN_manual, 1);
                }
            } else if ($_Isdeproom == 0) {
                $count_itemstock = 2;
            }
        }
    }






    if ($count_itemstock == 0 || $count_itemstock == 2) {
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
    $input_box_pay_manual = $_POST['input_box_pay_manual'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $select_doctor_manual = $_POST['select_doctor_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $select_procedure_manual = $_POST['select_procedure_manual'];
    $input_remark_manual = $_POST['input_remark_manual'];





    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];

    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $select_procedure_manual = implode(",", $select_procedure_manual);
    $select_doctor_manual = implode(",", $select_doctor_manual);


    if ($input_docNo_deproom_manual == "") {
        $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
        $input_docNo_deproom_manual = createDocNo($conn, $Userid, $DepID, $deproom, $input_remark_manual, 0, 0, 0, 0, '', '', $input_Hn_pay_manual, $input_box_pay_manual, $db, 1, 0, 0);
        $input_docNo_HN_manual = createhncodeDocNo($conn, $Userid, $DepID, $input_Hn_pay_manual, $select_deproom_manual, 1, $select_procedure_manual, $select_doctor_manual, 'สร้างจากเมนูขอเบิกอุปกรณ์', $input_docNo_deproom_manual, $db, $input_date_service_manual, $input_box_pay_manual);

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
                                    COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                    deproomdetailsub.PayDate AS ModifyDate    
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
                    $_ModifyDate = $row_2['ModifyDate'];
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate 
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
                        $_ModifyDate = $row_2['ModifyDate'];

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
                                    COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                    deproomdetailsub.PayDate AS ModifyDate 
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
                $_ModifyDate = $row_2['ModifyDate'];
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                    $_ModifyDate = $row_2['ModifyDate'];

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

    $count_itemstock = 0;
    $check_barcode = 0;
    $qcheck = "SELECT
                    item.Barcode,
                    item.itemcode
                FROM
                    item
                WHERE
                    item.Barcode = '$input_returnpay'  ";

    // echo $qcheck;
    // exit;
    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_ItemCode  = $rowq['itemcode'];
        $check_barcode++;
    }

    if ($check_barcode > 0) {


        $query_2 = "SELECT
                                deproomdetailsub.ID,
                                hncode_detail.ID AS hndetail_ID,
                                deproomdetail.ItemCode,
                                DATE( deproom.serviceDate ) AS ModifyDate ,
                                deproom.Ref_departmentroomid,
                                deproomdetail.ID AS deproomDetail_ID
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay' 
                                LIMIT 1 ";
        // echo $query_2;
        // exit;
        $meQuery_2 = $conn->prepare($query_2);
        $meQuery_2->execute();
        while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

            $count_itemstock++;

            $return[] = $row_2;

            $_ID = $row_2['ID'];
            $_deproomDetail_ID = $row_2['deproomDetail_ID'];
            $_hndetail_ID = $row_2['hndetail_ID'];
            $_ModifyDate = $row_2['ModifyDate'];
            $_departmentroomid = $row_2['Ref_departmentroomid'];

            // ==============================
            $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
            $meQueryD1 = $conn->prepare($queryD1);
            $meQueryD1->execute();


            // // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
            // $sqlCheck1 = "SELECT Qty FROM deproomdetail WHERE ID = ? ";
            // $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
            // $stmtCheck1->execute([$_deproomDetail_ID]);
            // $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

            // if ($resultCheck1) {
            //     if ($resultCheck1['Qty'] > 1) {
            //         // ถ้า Qty มากกว่า 1 -> ลบ 1
            //         $sqlUpdate = "UPDATE deproomdetail SET Qty = Qty - 1 WHERE ID = ?";
            //         $stmtUpdate = $conn->prepare($sqlUpdate);
            //         $stmtUpdate->execute([$_deproomDetail_ID]);
            //     } else {
            //         // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
            //         $sqlDelete = "DELETE FROM deproomdetail WHERE ID = ?";
            //         $stmtDelete = $conn->prepare($sqlDelete);
            //         $stmtDelete->execute([$_deproomDetail_ID]);
            //     }
            // }



            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
            $sqlCheck1 = "SELECT Qty FROM hncode_detail WHERE ID = ? ";
            $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
            $stmtCheck1->execute([$_hndetail_ID]);
            $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

            if ($resultCheck1) {
                if ($resultCheck1['Qty'] > 1) {
                    // ถ้า Qty มากกว่า 1 -> ลบ 1
                    $sqlUpdate = "UPDATE hncode_detail SET Qty = Qty - 1 WHERE ID = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->execute([$_hndetail_ID]);
                } else {
                    // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                    $sqlDelete = "DELETE FROM hncode_detail WHERE ID = ?";
                    $stmtDelete = $conn->prepare($sqlDelete);
                    $stmtDelete->execute([$_hndetail_ID]);
                }
            }


            // $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
            // $meQueryD2 = $conn->prepare($queryD2);
            // $meQueryD2->execute();
            // ==============================

            //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

            $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_pay' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCode'
                            AND deproomdetail.IsRequest = 1
                        GROUP BY
                            deproomdetail.ID ";
            $meQuery_qq1 = $conn->prepare($qq1);
            $meQuery_qq1->execute();
            while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                if ($row_qq1['cnt_pay'] == '0') {
                    $ID_Detail = $row_qq1['ID'];
                    $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                    $meQueryqq1 = $conn->prepare($queryqq1);
                    $meQueryqq1->execute();
                }
            }
            // =======================================================================================================================================

            $query = "DELETE FROM itemstock_transaction_detail  WHERE  ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND DATE(CreateDate) = '$_ModifyDate' LIMIT 1 ";



            $meQuery = $conn->prepare($query);
            $meQuery->execute();
            // =======================================================================================================================================





        }
    } else {
        $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID,
                    item.item_status,
                    item.itemtypeID2 AS itemtypeID 
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE  itemstock.UsageCode = '$input_returnpay'  ";


        $count_itemstock = 0;
        $meQuery_1 = $conn->prepare($query_1);
        $meQuery_1->execute();
        while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

            $_ItemCode = $row_1['ItemCode'];
            $_Isdeproom =  $row_1['Isdeproom'];
            $_departmentroomid =  $row_1['departmentroomid'];
            $_RowID =  $row_1['RowID'];
            $_item_status =  $row_1['item_status'];
            $_itemtypeID =  $row_1['itemtypeID'];

            $count_itemstock++;

            if ($_Isdeproom == 1) {
                $count_itemstock = 0;

                $query_2 = "SELECT
                            deproomdetailsub.ID ,
                            hncode_detail.ID AS hndetail_ID,
                            hncode.DocNo ,
	                        deproomdetail.ItemCode,
                            DATE(deproom.serviceDate)  AS ModifyDate
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                            INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                        WHERE
                            deproomdetailsub.ItemStockID = '$_RowID' 
                            AND deproomdetail.DocNo = '$DocNo_pay'
                            AND hncode_detail.ItemStockID = '$_RowID' LIMIT 1";
                // echo $query_2;
                // exit;
                $meQuery_2 = $conn->prepare($query_2);
                $meQuery_2->execute();
                while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

                    $return[] = $row_2;
                    $_ID = $row_2['ID'];
                    $_DocNoHN = $row_2['DocNo'];
                    $_hndetail_ID = $row_2['hndetail_ID'];
                    $_ModifyDate = $row_2['ModifyDate'];

                    // ==============================
                    $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
                    $meQueryD1 = $conn->prepare($queryD1);
                    $meQueryD1->execute();

                    $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
                    $meQueryD2 = $conn->prepare($queryD2);
                    $meQueryD2->execute();
                    // ==============================

                    //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

                    $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_pay' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCode'
                            AND deproomdetail.IsRequest = 1 OR  deproomdetail.Ismanual = 1
                        GROUP BY
                            deproomdetail.ID ";
                    $meQuery_qq1 = $conn->prepare($qq1);
                    $meQuery_qq1->execute();
                    while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                        if ($row_qq1['cnt_pay'] == '0') {
                            $ID_Detail = $row_qq1['ID'];
                            $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                            $meQueryqq1 = $conn->prepare($queryqq1);
                            $meQueryqq1->execute();
                        }
                    }
                    // =======================================================================================================================================

                    if ($db == 1) {
                        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND DATE(CreateDate) = '$_ModifyDate' LIMIT 1 ";
                    } else {
                        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$_departmentroomid' 
                    AND  IsStatus = '1'
                    AND CONVERT(DATE,CreateDate) = '$_ModifyDate' LIMIT 1  ";
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


                    $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                            VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                    $meQuery_log = $conn->prepare($insert_log);

                    $meQuery_log->bindParam(':itemCode', $_ItemCode);
                    $meQuery_log->bindParam(':itemstockID', $_RowID);
                    $meQuery_log->bindValue(':isStatus', 5, PDO::PARAM_INT);
                    $meQuery_log->bindParam(':DocNo', $DocNo_pay);
                    $meQuery_log->bindParam(':Userid', $Userid);


                    $meQuery_log->execute();
                }

                if ($_item_status == 3) {
                    if (isset($_DocNoHN) && !empty($_DocNoHN)) {
                        oncheck_delete_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, $DocNo_pay, $_itemtypeID, $_DocNoHN, 0);
                        $count_itemstock = 3;
                    } else {
                        $count_itemstock = 0;
                    }
                }
            } else if ($_Isdeproom == 0) {
                $count_itemstock = 2;
            }
        }





        $check_his = "SELECT his.IsStatus FROM his WHERE DocNo_deproom = '$DocNo_pay' ";
        $meQuery_his = $conn->prepare($check_his);
        $meQuery_his->execute();

        // exit;
        while ($row_his = $meQuery_his->fetch(PDO::FETCH_ASSOC)) {

            // ค้นหา DocNo จาก DocNo_SS ก่อน
            $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
            $stmtDocNo = $conn->prepare($sqlDocNo);
            $stmtDocNo->execute([$DocNo_pay]);
            $row = $stmtDocNo->fetch(PDO::FETCH_ASSOC);

            if ($row && $row['DocNo']) {
                $DocNo_real = $row['DocNo'];

                // 1. UPDATE Qty - 1
                $update = "UPDATE his_detail 
                                    SET Qty = Qty - 1
                                    WHERE ItemCode = ?
                                    AND Qty > 0
                                    AND DocNo = ?";
                $stmtUpdate = $conn->prepare($update);
                $stmtUpdate->execute([$_ItemCode, $DocNo_real]);

                // 2. DELETE ถ้า Qty = 0
                $delete = "DELETE FROM his_detail 
                                    WHERE ItemCode = ?
                                    AND DocNo = ?
                                    AND Qty = 0";
                $stmtDelete = $conn->prepare($delete);
                $stmtDelete->execute([$_ItemCode, $DocNo_real]);
            }
        }
    }

    if ($count_itemstock == 0 || $count_itemstock == 2 || $count_itemstock == 3) {
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
                                    COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                    deproomdetailsub.PayDate AS ModifyDate
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
                    $_ModifyDate = $row_2['ModifyDate'];
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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                        $_ModifyDate = $row_2['ModifyDate'];

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
                                    COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                    deproomdetailsub.PayDate AS ModifyDate
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
                $_ModifyDate = $row_2['ModifyDate'];


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
                                        COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                    $_ModifyDate = $row_2['ModifyDate'];


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
    $input_box_pay = $_POST['input_box_pay'];



    $input_date_service = explode("-", $input_date_service);
    $input_date_service = $input_date_service[2] . '-' . $input_date_service[1] . '-' . $input_date_service[0];

    $count_new_item_itemcode = 0;
    $check_barcode = 0;
    $qcheck = "SELECT
                    item.Barcode,
                    item.itemcode
                FROM
                    item
                WHERE
                    item.Barcode = '$input_pay'  ";

    // echo $qcheck;
    // exit;
    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $check_barcode++;
    }


    if ($check_barcode > 0) {

        $showdocHN = "SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  ";
        $query_showdocHN = $conn->prepare($showdocHN);
        $query_showdocHN->execute();
        while ($row_showdocHN = $query_showdocHN->fetch(PDO::FETCH_ASSOC)) {
            $input_docNo_HN_manual = $row_showdocHN['DocNo'];
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
                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                        deproomdetailsub.PayDate AS ModifyDate
                    FROM
                        deproomdetail
                        INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    WHERE
                        deproomdetail.ItemCode = '$_itemcode' 
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

            $count_new_item_itemcode++;

            $_ID = $row_2['ID'];
            $_departmentroomid = $row_2['departmentroomid'];
            $_procedure = $row_2['procedure'];
            $_hn_record_id = $row_2['hn_record_id'];
            $_doctor = $row_2['doctor'];
            $_ModifyDate = $row_2['ModifyDate'];



            $queryInsert0 = "UPDATE deproomdetail SET Qty = Qty+1 WHERE  deproomdetail.ID = '$_ID' AND  IsRequest = 1 ";
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
                                        ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
            $meQuery = $conn->prepare($query);
            $meQuery->execute();
            // =======================================================================================================================================




            $sql_hncode = "SELECT COUNT(*) AS cnt 
        FROM hncode_detail 
        WHERE ItemCode = :itemcode 
        AND DocNo = :docno";
            $meQuery_hncode = $conn->prepare($sql_hncode);
            $meQuery_hncode->execute([
                ':itemcode' => $_itemcode,
                ':docno'    => $input_docNo_HN_manual
            ]);
            $row = $meQuery_hncode->fetch(PDO::FETCH_ASSOC);

            if ($row['cnt'] > 0) {
                // ถ้ามี → UPDATE
                $sql_update = "UPDATE hncode_detail 
                   SET Qty = Qty + 1 
                   WHERE ItemCode = :itemcode 
                   AND DocNo = :docno";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute([
                    ':itemcode' => $_itemcode,
                    ':docno'    => $input_docNo_HN_manual
                ]);
            } else {
                // ถ้าไม่มี → INSERT
                $sql_insert = "INSERT INTO hncode_detail (ItemCode, DocNo, Qty) 
                   VALUES (:itemcode, :docno, 1)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->execute([
                    ':itemcode' => $_itemcode,
                    ':docno'    => $input_docNo_HN_manual
                ]);
            }


            $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo_SS = '$input_docNo_HN_manual'  ";
            $query_updateHN = $conn->prepare($query_updateHN);
            $query_updateHN->execute();

            // $queryInsert2 = "UPDATE hncode_detail SET Qty = Qty + 1 WHERE  hncode_detail.ItemCode = '$_itemcode' AND DocNo = '$input_docNo_HN_manual' ";
            // $queryInsert2 = $conn->prepare($queryInsert2);
            // $queryInsert2->execute();


            // 1. ค้นหา DocNo จาก DocNo_SS
            $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
            $stmtDoc = $conn->prepare($sqlDocNo);
            $stmtDoc->execute([$DocNo_pay]);
            $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $docNo_hn = $row['DocNo'];

                // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->execute([$docNo_hn, $_itemcode]);
                $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                if ($resultCheck) {
                    // เจอแล้ว -> UPDATE Qty +1
                    $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                } else {
                    // ไม่เจอ -> INSERT
                    $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->execute([$docNo_hn, $_itemcode]);
                }
            }




            $count_itemstock = 2;
            echo json_encode($count_itemstock);
            unset($conn);
            die;
        }

        if ($count_new_item_itemcode  == 0) {
            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime ,IsRequest )
                VALUES
                    ( '$DocNo_pay', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

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
                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                deproomdetailsub.PayDate AS ModifyDate
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_itemcode' 
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
                $_ID = $row_2['ID'];
                $_PayDate = $row_2['PayDate'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_Qty_detail = $row_2['Qty'];
                $_Qty_detail_sub = $row_2['cnt_sub'];
                $_ModifyDate = $row_2['ModifyDate'];

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
                                        ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();

                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '$_itemcode'
                                                ) ";

                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'   ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();


                $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                $stmtDoc = $conn->prepare($sqlDocNo);
                $stmtDoc->execute([$DocNo_pay]);
                $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $docNo_hn = $row['DocNo'];

                    // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                    $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                    $stmtCheck = $conn->prepare($sqlCheck);
                    $stmtCheck->execute([$docNo_hn, $_itemcode]);
                    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                    if ($resultCheck) {
                        // เจอแล้ว -> UPDATE Qty +1
                        $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                        $stmtUpdate = $conn->prepare($sqlUpdate);
                        $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                    } else {
                        // ไม่เจอ -> INSERT
                        $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                        $stmtInsert = $conn->prepare($sqlInsert);
                        $stmtInsert->execute([$docNo_hn, $_itemcode]);
                    }
                }




                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
            }

            $count_itemstock = 2;
            echo json_encode($count_itemstock);
            unset($conn);
            die;
        }
    }



    if ($check_barcode == 0) {

        $permission = $_SESSION['permission'];
        $wherepermission = "";
        if ($permission != '5') {
            $wherepermission = " AND item.warehouseID = $permission ";
        }


        $query_1 = "        SELECT
                                    itemstock.ItemCode,
                                    itemstock.Isdeproom,
                                    itemstock.RowID ,
                                    itemstock.UsageCode,
                                    itemstock.departmentroomid ,
                                    item.item_status,
                                    item.itemtypeID2 AS itemtypeID ,
                                    item.IsSet,
                                    CASE
                                            WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                            ELSE 'no_exp'
                                        END AS check_exp
                                FROM
                                    itemstock 
                                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                                WHERE
                                        itemstock.UsageCode = '$input_pay' 
                                        AND itemstock.IsCancel = 0
                                        AND itemstock.Adjust_stock = 0
                                        $wherepermission ";


        // echo $query_1;
        // exit;
        $count_itemstock = 0;
        $meQuery_1 = $conn->prepare($query_1);
        $meQuery_1->execute();
        while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

            $_check_exp = $row_1['check_exp'];
            $_item_status = $row_1['item_status'];
            $_itemtypeID = $row_1['itemtypeID'];
            $_IsSet = $row_1['IsSet'];


            if ($_check_exp == 'no_exp') {
                $_ItemCode = $row_1['ItemCode'];
                $_Isdeproom =  $row_1['Isdeproom'];
                $_departmentroomid =  $row_1['departmentroomid'];
                $_RowID =  $row_1['RowID'];

                $count_itemstock++;

                $count_itemstock = 0;
                $count_new_item = 0;

                // stock
                if ($_Isdeproom == 0) {

                    $query_2 = "SELECT
                                        deproomdetail.ID,
                                        deproom.Ref_departmentroomid AS departmentroomid,
                                        deproom.`procedure`,
                                        deproom.doctor,
                                        deproom.hn_record_id,
                                        deproomdetail.ItemCode,
                                        deproomdetail.Qty ,
                                        deproomdetail.PayDate ,
                                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                        $_ModifyDate = $row_2['ModifyDate'];



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
                                Stockin = 1,
                            departmentroomid = '$_departmentroomid'
                            WHERE
                            RowID = '$_RowID' ";
                        $meQueryUpdate = $conn->prepare($queryUpdate);
                        $meQueryUpdate->execute();
                        // ==============================
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                            (
                            (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  LIMIT 1 ), 
                            '$input_pay',
                            '$_RowID',
                            1, 
                            1, 
                            0, 
                            (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                            ) ";


                        // 1. ค้นหา DocNo จาก DocNo_SS
                        $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                        $stmtDoc = $conn->prepare($sqlDocNo);
                        $stmtDoc->execute([$DocNo_pay]);
                        $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            $docNo_hn = $row['DocNo'];

                            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                            $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                            $stmtCheck = $conn->prepare($sqlCheck);
                            $stmtCheck->execute([$docNo_hn, $_ItemCode]);
                            $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                            if ($resultCheck) {
                                // เจอแล้ว -> UPDATE Qty +1
                                $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                                $stmtUpdate = $conn->prepare($sqlUpdate);
                                $stmtUpdate->execute([$docNo_hn, $_ItemCode]);
                            } else {
                                // ไม่เจอ -> INSERT
                                $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                                $stmtInsert = $conn->prepare($sqlInsert);
                                $stmtInsert->execute([$docNo_hn, $_ItemCode]);
                            }
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

                        // ส่วนจ่ายธรรมดา
                        if ($_item_status == 2 || $_item_status == 3) {
                            oncheck_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, 0, $_itemtypeID, $_IsSet);
                            $count_itemstock = 2;
                        }
                    }


                    if ($count_new_item  == 0) {

                        if ($db == 1) {
                            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsRequest )
                            VALUES
                                ( '$DocNo_pay', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() , 1)";
                        } else {
                            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime, IsRequest )
                            VALUES
                                ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE() , 1)";
                        }




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
                                            COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                            deproomdetailsub.PayDate AS ModifyDate
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
                            $_ModifyDate = $row_2['ModifyDate'];


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
                                Stockin = 1,
                                departmentroomid = '$_departmentroomid'
                                WHERE
                                RowID = '$_RowID' ";
                            $meQueryUpdate = $conn->prepare($queryUpdate);
                            $meQueryUpdate->execute();
                            // ==============================

                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  LIMIT 1  ), 
                                '$input_pay',
                                '$_RowID',
                                1, 
                                1, 
                                0
                                ) ";


                            // 1. ค้นหา DocNo จาก DocNo_SS
                            $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                            $stmtDoc = $conn->prepare($sqlDocNo);
                            $stmtDoc->execute([$DocNo_pay]);
                            $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                            if ($row) {
                                $docNo_hn = $row['DocNo'];

                                // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                                $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                                $stmtCheck = $conn->prepare($sqlCheck);
                                $stmtCheck->execute([$docNo_hn, $_ItemCode]);
                                $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                                if ($resultCheck) {
                                    // เจอแล้ว -> UPDATE Qty +1
                                    $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                                    $stmtUpdate = $conn->prepare($sqlUpdate);
                                    $stmtUpdate->execute([$docNo_hn, $_ItemCode]);
                                } else {
                                    // ไม่เจอ -> INSERT
                                    $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                                    $stmtInsert = $conn->prepare($sqlInsert);
                                    $stmtInsert->execute([$docNo_hn, $_ItemCode]);
                                }
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

                            $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                                    VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                            $meQuery_log = $conn->prepare($insert_log);

                            $meQuery_log->bindParam(':itemCode', $_ItemCode);
                            $meQuery_log->bindParam(':itemstockID', $_RowID);
                            $meQuery_log->bindValue(':isStatus', 4, PDO::PARAM_INT);
                            $meQuery_log->bindParam(':DocNo', $DocNo_pay);
                            $meQuery_log->bindParam(':Userid', $Userid);


                            $meQuery_log->execute();



                            if ($_item_status == 2 || $_item_status == 3) {
                                oncheck_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, 0, $_itemtypeID, $_IsSet);
                            }


                            $count_itemstock = 2;



                            // echo json_encode($count_itemstock);
                            // unset($conn);
                            // die;
                        }
                    }

                    $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                                            VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                    $meQuery_log = $conn->prepare($insert_log);

                    $meQuery_log->bindParam(':itemCode', $_ItemCode);
                    $meQuery_log->bindParam(':itemstockID', $_RowID);
                    $meQuery_log->bindValue(':isStatus', 4, PDO::PARAM_INT);
                    $meQuery_log->bindParam(':DocNo', $DocNo_pay);
                    $meQuery_log->bindParam(':Userid', $Userid);


                    $meQuery_log->execute();


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
                                        deproomdetail.Qty AS deproom_qty,
                                        hncode_detail.Qty AS hncode_qty ,
                                        deproom.hn_record_id,
                                        DATE(deproom.serviceDate) AS serviceDate ,
                                        deproom.Ref_departmentroomid ,
                                        DATE(deproom.serviceDate)  AS ModifyDate,
                                        deproom.number_box,
                                        deproom.DocNo,
                                        hncode.DocNo AS hncode_DocNo 
                                    FROM
                                        deproom
                                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                        LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                                    WHERE
                                        deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetailsub.ItemStockID = '$_RowID'
                                        AND hncode_detail.ItemStockID = '$_RowID' 
                                        ORDER BY deproomdetailsub.ID DESC
                                        LIMIT 1 ";


                    $meQuery_old = $conn->prepare($query_old);
                    $meQuery_old->execute();
                    while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                        $detailID = $row_old['detailID'];
                        $hndetail_ID = $row_old['hndetail_ID'];
                        $DocNo_borrow = $row_old['DocNo'];
                        $DocNoHN_borrow = $row_old['hncode_DocNo'];
                        $deproom_qty = $row_old['deproom_qty'];
                        $hncode_qty = $row_old['hncode_qty'];
                        $deproomdetailsub_id = $row_old['ID'];
                        $_hn_record_id_borrow = $row_old['hn_record_id'];
                        $_ModifyDate = $row_old['ModifyDate'];
                        $__Ref_departmentroomid = $row_old['Ref_departmentroomid'];
                        $_number_box = $row_old['number_box'];

                        if ($_hn_record_id_borrow == "") {
                            $_hn_record_id_borrow = $_number_box;
                        }
                    }


                    if ($DocNo_pay != $DocNo_borrow) {


                        $checkqty = "SELECT
                                            SUM( deproomdetail.Qty ) AS deproom_qty ,
                                            (
                                            SELECT
                                            COUNT( hncode_detail.Qty ) AS hncode_qty 
                                        FROM
                                            hncode
                                            LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                                        WHERE
                                            hncode_detail.ID = '$hndetail_ID'
                                            ) AS hncode_qty
                                        FROM
                                            deproom
                                            LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                            LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        WHERE
                                            deproomdetail.ID = '$detailID' ";


                        $meQuery_checkqty = $conn->prepare($checkqty);
                        $meQuery_checkqty->execute();
                        while ($row_checkqty = $meQuery_checkqty->fetch(PDO::FETCH_ASSOC)) {
                            $deproom_qty = $row_checkqty['deproom_qty'];
                            $hncode_qty = $row_checkqty['hncode_qty'];
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


                        // 1. ค้นหา DocNo จาก DocNo_SS
                        $sqlDocNo1 = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                        $stmtDoc1 = $conn->prepare($sqlDocNo1);
                        $stmtDoc1->execute([$DocNo_borrow]);
                        $row1 = $stmtDoc1->fetch(PDO::FETCH_ASSOC);

                        if ($row1) {
                            $docNo_hn1 = $row1['DocNo'];

                            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                            $sqlCheck1 = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                            $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
                            $stmtCheck1->execute([$docNo_hn1, $_ItemCode]);
                            $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

                            if ($resultCheck1) {
                                if ($resultCheck1['Qty'] > 1) {
                                    // ถ้า Qty มากกว่า 1 -> ลบ 1
                                    $sqlUpdate = "UPDATE his_detail SET Qty = Qty - 1 WHERE DocNo = ? AND ItemCode = ?";
                                    $stmtUpdate = $conn->prepare($sqlUpdate);
                                    $stmtUpdate->execute([$docNo_hn1, $_ItemCode]);
                                } else {
                                    // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                                    $sqlDelete = "DELETE FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                                    $stmtDelete = $conn->prepare($sqlDelete);
                                    $stmtDelete->execute([$docNo_hn1, $_ItemCode]);
                                }
                            }
                        }


                        // 1. ค้นหา DocNo จาก DocNo_SS
                        $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                        $stmtDoc = $conn->prepare($sqlDocNo);
                        $stmtDoc->execute([$DocNo_pay]);
                        $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            $docNo_hn = $row['DocNo'];

                            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                            $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                            $stmtCheck = $conn->prepare($sqlCheck);
                            $stmtCheck->execute([$docNo_hn, $_ItemCode]);
                            $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                            if ($resultCheck) {
                                // เจอแล้ว -> UPDATE Qty +1
                                $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                                $stmtUpdate = $conn->prepare($sqlUpdate);
                                $stmtUpdate->execute([$docNo_hn, $_ItemCode]);
                            } else {
                                // ไม่เจอ -> INSERT
                                $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                                $stmtInsert = $conn->prepare($sqlInsert);
                                $stmtInsert->execute([$docNo_hn, $_ItemCode]);
                            }
                        }



                        if ($deproom_qty == 1) {
                            // $update_old_detail = "DELETE FROM deproomdetail WHERE ID =  '$detailID' ";
                            // $meQuery_old_detail = $conn->prepare($update_old_detail);
                            // $meQuery_old_detail->execute();

                            $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                            $meQuery_old_sub = $conn->prepare($update_old_sub);
                            $meQuery_old_sub->execute();
                        } else {
                            // $update_old_detail = "UPDATE deproomdetail SET Qty = Qty-1 WHERE  deproomdetail.ID = '$detailID' ";
                            // $meQuery_old_detail = $conn->prepare($update_old_detail);
                            // $meQuery_old_detail->execute();

                            $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'   ";
                            $meQuery_old_sub = $conn->prepare($update_old_sub);
                            $meQuery_old_sub->execute();
                        }




                        //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

                        $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_borrow' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCode'
                            AND deproomdetail.IsRequest = 1
                        GROUP BY
                            deproomdetail.ID ";
                        $meQuery_qq1 = $conn->prepare($qq1);
                        $meQuery_qq1->execute();
                        while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                            if ($row_qq1['cnt_pay'] == '0') {
                                $ID_Detail = $row_qq1['ID'];
                                $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                                $meQueryqq1 = $conn->prepare($queryqq1);
                                $meQueryqq1->execute();
                            }
                        }

                        $query_old = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                        AND ItemCode = '$_ItemCode' 
                        AND departmentroomid = '$__Ref_departmentroomid' 
                        AND  IsStatus = '1'
                        AND DATE(CreateDate) = '$_ModifyDate' ";
                        $meQuery_old = $conn->prepare($query_old);
                        $meQuery_old->execute();


                        if ($_item_status == 3) {
                            $select = "SELECT hncode.DocNo FROM hncode WHERE DocNo_SS = '$DocNo_pay' ";
                            $meQuery_select = $conn->prepare($select);
                            $meQuery_select->execute();
                            while ($row_select = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
                                $_DocNoHN = $row_select['DocNo'];
                            }
                            oncheck_delete_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, $DocNo_borrow, 2, $_DocNoHN, 0);
                            // $count_itemstock = 2;
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
                                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                                        deproomdetailsub.PayDate AS ModifyDate
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
                            $_ModifyDate = $row_2['ModifyDate'];


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
                                                VALUES (
                                                    :Deproomdetail_RowID,
                                                    :ItemStockID,
                                                    :dental_warehouse_id,
                                                    1,
                                                    1,
                                                    NOW(),
                                                    :hn_record_id,
                                                    :doctor,
                                                    :procedure,
                                                    1,
                                                    :hn_record_id_borrow
                                                )";

                            $stmt = $conn->prepare($queryInsert1);
                            $stmt->execute([
                                ':Deproomdetail_RowID' => $_ID,
                                ':ItemStockID' => $_RowID,
                                ':dental_warehouse_id' => $_departmentroomid,
                                ':hn_record_id' => $_hn_record_id,
                                ':doctor' => $_doctor,
                                ':procedure' => $_procedure,
                                ':hn_record_id_borrow' => $_hn_record_id_borrow
                            ]);





                            // =======================================================================================================================================
                            $query = "INSERT INTO itemstock_transaction_detail (
                                                ItemStockID, 
                                                ItemCode, 
                                                CreateDate, 
                                                departmentroomid, 
                                                UserCode, 
                                                IsStatus, 
                                                Qty,
                                                hncode
                                            )
                                            VALUES (
                                                :ItemStockID,
                                                :ItemCode,
                                                :serviceDate,
                                                :departmentroomid,
                                                :UserCode,
                                                1,
                                                1,
                                                :hncode
                                            )";

                            $stmt = $conn->prepare($query);
                            $stmt->execute([
                                ':ItemStockID'    => $_RowID,
                                ':ItemCode'       => $_ItemCode,
                                ':serviceDate'         => $input_date_service,
                                ':departmentroomid' => $_departmentroomid,
                                ':UserCode'       => $Userid,
                                ':hncode'         => $_hn_record_id
                            ]);

                            // =======================================================================================================================================


                            // ==============================
                            $queryUpdate = "UPDATE itemstock 
                                SET Isdeproom = 1 ,
                                Stockin = 1,
                                departmentroomid = '$_departmentroomid'
                                WHERE
                                RowID = '$_RowID' ";
                            $meQueryUpdate = $conn->prepare($queryUpdate);
                            $meQueryUpdate->execute();
                            // ==============================
                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  LIMIT 1 ), 
                                '$input_pay',
                                '$_RowID',
                                1, 
                                1, 
                                0, 
                                ''
                                ) ";






                            $query_updateHN = "UPDATE hncode 
                                            SET IsStatus = 1  
                                            WHERE HnCode = :hncode 
                                                AND `procedure` = :procedure 
                                                AND doctor = :doctor 
                                                AND departmentroomid = :departmentroomid 
                                                AND DocDate = :docdate";

                            $stmt = $conn->prepare($query_updateHN);
                            $stmt->execute([
                                ':hncode' => $_hn_record_id,
                                ':procedure' => $_procedure,
                                ':doctor' => $_doctor,
                                ':departmentroomid' => $_departmentroomid,
                                ':docdate' => $input_date_service
                            ]);


                            // echo $queryInsert2;
                            // exit;
                            $queryInsert2 = $conn->prepare($queryInsert2);
                            $queryInsert2->execute();
                            $count_itemstock++;

                            $count_new_item++;

                            if ($_item_status == 2 || $_item_status == 3) {
                                oncheck_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, 0, $_itemtypeID, $_IsSet);
                                $count_itemstock = 2;
                            }
                        }

                        // รายการยังไม่มี
                        if ($count_new_item  == 0) {



                            if ($db == 1) {
                                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsRequest )
                                    VALUES
                                        ( '$DocNo_pay', '$_ItemCode', '1', 0,NOW(), 0, '$Userid',NOW() ,1)";
                            } else {
                                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsRequest)
                                    VALUES
                                        ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE(),1)";
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
                                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                                deproomdetailsub.PayDate AS ModifyDate
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
                                $_ModifyDate = $row_2['ModifyDate'];



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
                                                    VALUES (
                                                        :Deproomdetail_RowID, 
                                                        :ItemStockID,
                                                        :dental_warehouse_id,
                                                        1, 
                                                        1, 
                                                        NOW(), 
                                                        :hn_record_id, 
                                                        :doctor, 
                                                        :procedure,
                                                        1,
                                                        :hn_record_id_borrow
                                                    )";

                                $stmt = $conn->prepare($queryInsert1);
                                $stmt->execute([
                                    ':Deproomdetail_RowID' => $_ID,
                                    ':ItemStockID' => $_RowID,
                                    ':dental_warehouse_id' => $_departmentroomid,
                                    ':hn_record_id' => $_hn_record_id,
                                    ':doctor' => $_doctor,
                                    ':procedure' => $_procedure,
                                    ':hn_record_id_borrow' => $_hn_record_id_borrow
                                ]);


                                // $queryInsert1 = $conn->prepare($queryInsert1);
                                // $queryInsert1->execute();
                                // ==============================

                                // =======================================================================================================================================
                                $query = "INSERT INTO itemstock_transaction_detail (
                                                ItemStockID, 
                                                ItemCode, 
                                                CreateDate, 
                                                departmentroomid, 
                                                UserCode, 
                                                IsStatus, 
                                                Qty, 
                                                hncode
                                            ) VALUES (
                                                :ItemStockID,
                                                :ItemCode,
                                                :serviceDate,
                                                :departmentroomid,
                                                :UserCode,
                                                1,
                                                1,
                                                :hncode
                                            )";

                                $stmt = $conn->prepare($query);
                                $stmt->execute([
                                    ':ItemStockID' => $_RowID,
                                    ':ItemCode' => $_ItemCode,
                                    ':serviceDate' => $input_date_service,
                                    ':departmentroomid' => $_departmentroomid,
                                    ':UserCode' => $Userid,
                                    ':hncode' => $_hn_record_id
                                ]);


                                // =======================================================================================================================================


                                $queryUpdate = "UPDATE itemstock 
                                    SET Isdeproom = 1 ,
                                    Stockin = 1,
                                    departmentroomid = '$_departmentroomid'
                                    WHERE
                                    RowID = '$_RowID' ";
                                $meQueryUpdate = $conn->prepare($queryUpdate);
                                $meQueryUpdate->execute();
                                // ==============================

                                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                    (
                                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  LIMIT 1), 
                                    '$input_pay',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";




                                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE hncode.DocNo_SS = '$DocNo_pay'  ";
                                $query_updateHN = $conn->prepare($query_updateHN);
                                $query_updateHN->execute();


                                // echo $queryInsert2;
                                // exit;
                                $queryInsert2 = $conn->prepare($queryInsert2);
                                $queryInsert2->execute();
                                $count_itemstock++;

                                $count_new_item++;


                                $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                                       VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                                $meQuery_log = $conn->prepare($insert_log);

                                $meQuery_log->bindParam(':itemCode', $_ItemCode);
                                $meQuery_log->bindParam(':itemstockID', $_RowID);
                                $meQuery_log->bindValue(':isStatus', 4, PDO::PARAM_INT);
                                $meQuery_log->bindParam(':DocNo', $DocNo_pay);
                                $meQuery_log->bindParam(':Userid', $Userid);


                                $meQuery_log->execute();

                                $count_itemstock = 2;

                                if ($_item_status == 2 || $_item_status == 3) {
                                    oncheck_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, 0, $_itemtypeID, $_IsSet);
                                    $count_itemstock = 2;
                                }

                                // echo json_encode($count_itemstock);
                                // unset($conn);
                                // die;
                            }
                        }

                        $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
                                VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

                        $meQuery_log = $conn->prepare($insert_log);

                        $meQuery_log->bindParam(':itemCode', $_ItemCode);
                        $meQuery_log->bindParam(':itemstockID', $_RowID);
                        $meQuery_log->bindValue(':isStatus', 4, PDO::PARAM_INT);
                        $meQuery_log->bindParam(':DocNo', $DocNo_pay);
                        $meQuery_log->bindParam(':Userid', $Userid);


                        $meQuery_log->execute();
                    } else {
                        $count_itemstock = 3;
                        // echo json_encode($count_itemstock);
                        // unset($conn);
                        // die;
                    }
                }
            } else {

                $count_itemstock = 9;
                echo json_encode($count_itemstock);
                unset($conn);
                die;
            }
        }



        if ($count_itemstock == 0 || $count_itemstock == 2 || $count_itemstock == 3 || $count_itemstock == 9) {
            echo json_encode($count_itemstock);
            unset($conn);
            die;
        } else {
            echo json_encode($return);
            unset($conn);
            die;
        }
    }
}
function oncheck_pay_mapping($conn, $db, $_ItemCode, $DocNo_pay, $input_date_service, $_item_status, $ismanual, $_itemtypeID, $_IsSet_map1)
{
    $Userid = $_SESSION['Userid'];
    $count_new_item_itemcode = 0;
    $qcheck = "SELECT
                    i.Barcode,
                    i.itemcode ,
                    i.IsSet 
                FROM
                    item AS i 
                WHERE
                    EXISTS ( SELECT 1 FROM mapping_item AS m WHERE m.itemCode_main = '$_ItemCode' AND FIND_IN_SET( i.itemcode, m.itemCode_sub ) > 0 ); ";

    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $_IsSet  = $rowq['IsSet'];

        $showdocHN = "SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay'  ";
        $query_showdocHN = $conn->prepare($showdocHN);
        $query_showdocHN->execute();
        while ($row_showdocHN = $query_showdocHN->fetch(PDO::FETCH_ASSOC)) {
            $input_docNo_HN_manual = $row_showdocHN['DocNo'];
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
                        COUNT(deproomdetailsub.ID)  AS cnt_sub,
                        deproomdetailsub.PayDate AS ModifyDate
                    FROM
                        deproomdetail
                        INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    WHERE
                        deproomdetail.ItemCode = '$_itemcode' 
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


            $count_new_item_itemcode++;

            // ต้องการให้เข้าครั้งเดียว
            if ($_itemtypeID != 32 && $_itemtypeID != 33 && $_IsSet_map1 != 3) {


                $_ID = $row_2['ID'];
                $_departmentroomid = $row_2['departmentroomid'];
                $_procedure = $row_2['procedure'];
                $_hn_record_id = $row_2['hn_record_id'];
                $_doctor = $row_2['doctor'];
                $_ModifyDate = $row_2['ModifyDate'];



                $queryInsert0 = "UPDATE deproomdetail SET Qty = Qty+1 WHERE  deproomdetail.ID = '$_ID' AND  IsRequest = 1 ";
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
                                        ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                // =======================================================================================================================================




                $sql_hncode = "SELECT COUNT(*) AS cnt 
                FROM hncode_detail 
                WHERE ItemCode = :itemcode 
                AND DocNo = :docno";
                $meQuery_hncode = $conn->prepare($sql_hncode);
                $meQuery_hncode->execute([
                    ':itemcode' => $_itemcode,
                    ':docno'    => $input_docNo_HN_manual
                ]);
                $row = $meQuery_hncode->fetch(PDO::FETCH_ASSOC);

                if ($row['cnt'] > 0) {
                    // ถ้ามี → UPDATE
                    $sql_update = "UPDATE hncode_detail 
                   SET Qty = Qty + 1 
                   WHERE ItemCode = :itemcode 
                   AND DocNo = :docno";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->execute([
                        ':itemcode' => $_itemcode,
                        ':docno'    => $input_docNo_HN_manual
                    ]);
                } else {
                    // ถ้าไม่มี → INSERT
                    $sql_insert = "INSERT INTO hncode_detail (ItemCode, DocNo, Qty) 
                   VALUES (:itemcode, :docno, 1)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->execute([
                        ':itemcode' => $_itemcode,
                        ':docno'    => $input_docNo_HN_manual
                    ]);
                }


                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo_SS = '$input_docNo_HN_manual'  ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();



                // 1. ค้นหา DocNo จาก DocNo_SS
                $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                $stmtDoc = $conn->prepare($sqlDocNo);
                $stmtDoc->execute([$DocNo_pay]);
                $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $docNo_hn = $row['DocNo'];

                    // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                    $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                    $stmtCheck = $conn->prepare($sqlCheck);
                    $stmtCheck->execute([$docNo_hn, $_itemcode]);
                    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                    if ($resultCheck) {
                        // เจอแล้ว -> UPDATE Qty +1
                        $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                        $stmtUpdate = $conn->prepare($sqlUpdate);
                        $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                    } else {
                        // ไม่เจอ -> INSERT
                        $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                        $stmtInsert = $conn->prepare($sqlInsert);
                        $stmtInsert->execute([$docNo_hn, $_itemcode]);
                    }
                }
            }


            // $count_itemstock = 2;
            // echo json_encode($count_itemstock);
            // unset($conn);
            // die;
        }

        if ($ismanual == 1) {
            $is = " ,Ismanual ";
        } else {
            $is = " ,IsRequest ";
        }

        if ($count_new_item_itemcode  == 0) {

            if ($_IsSet == 2) {

                $query_old = " SELECT
                                    deproomdetailsub.ID,
                                    deproomdetail.ID AS detailID,
                                    hncode_detail.ID AS hndetail_ID,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty AS deproom_qty,
                                    hncode_detail.Qty AS hncode_qty,
                                    deproom.hn_record_id,
                                    DATE( deproom.serviceDate ) AS serviceDate,
                                    deproom.Ref_departmentroomid,
                                    DATE( deproom.serviceDate ) AS ModifyDate,
                                    deproom.number_box,
                                    deproom.DocNo,
                                    hncode.DocNo AS hncode_DocNo 
                                FROM
                                    deproom
                                    LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                    LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                                    LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
                                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                                    INNER JOIN item AS item2 ON hncode_detail.ItemCode = item2.itemcode 
                                WHERE
                                    deproom.DocNo = '$DocNo_pay' 
                                    AND item.IsSet = 1
                                    AND item2.IsSet = 1
                                ORDER BY
                                    deproomdetailsub.ID DESC 
                                    LIMIT 1  ";

                $meQuery_old = $conn->prepare($query_old);
                $meQuery_old->execute();
                while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                    $detailID = $row_old['detailID'];
                    $hndetail_ID = $row_old['hndetail_ID'];
                    $DocNo_borrow = $row_old['DocNo'];
                    $DocNoHN_borrow = $row_old['hncode_DocNo'];
                    $deproom_qty = $row_old['deproom_qty'];
                    $hncode_qty = $row_old['hncode_qty'];
                    $deproomdetailsub_id = $row_old['ID'];
                    $_hn_record_id_borrow = $row_old['hn_record_id'];
                    $_ModifyDate = $row_old['ModifyDate'];
                    $__Ref_departmentroomid = $row_old['Ref_departmentroomid'];
                    $_number_box = $row_old['number_box'];
                    $_ItemCodeIsSet1 = $row_old['ItemCode'];

                    if ($_hn_record_id_borrow == "") {
                        $_hn_record_id_borrow = $_number_box;
                    }

                    $checkqty = "SELECT
                        SUM( deproomdetail.Qty ) AS deproom_qty ,
                        ( SELECT SUM( hncode_detail.Qty ) AS hncode_qty 
                        FROM
                            hncode
                            LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                        WHERE
                            hncode_detail.ID = '$hndetail_ID'
                            ) AS hncode_qty
                        FROM
                            deproom
                            LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                        WHERE
                            deproomdetail.ID = '$detailID' ";


                    $meQuery_checkqty = $conn->prepare($checkqty);
                    $meQuery_checkqty->execute();
                    while ($row_checkqty = $meQuery_checkqty->fetch(PDO::FETCH_ASSOC)) {
                        $deproom_qty = $row_checkqty['deproom_qty'];
                        $hncode_qty = $row_checkqty['hncode_qty'];
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


                    // 1. ค้นหา DocNo จาก DocNo_SS
                    $sqlDocNo1 = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                    $stmtDoc1 = $conn->prepare($sqlDocNo1);
                    $stmtDoc1->execute([$DocNo_borrow]);
                    $row1 = $stmtDoc1->fetch(PDO::FETCH_ASSOC);

                    if ($row1) {
                        $docNo_hn1 = $row1['DocNo'];

                        // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                        $sqlCheck1 = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                        $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
                        $stmtCheck1->execute([$docNo_hn1, $_ItemCodeIsSet1]);
                        $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

                        if ($resultCheck1) {
                            if ($resultCheck1['Qty'] > 1) {
                                // ถ้า Qty มากกว่า 1 -> ลบ 1
                                $sqlUpdate = "UPDATE his_detail SET Qty = Qty - 1 WHERE DocNo = ? AND ItemCode = ?";
                                $stmtUpdate = $conn->prepare($sqlUpdate);
                                $stmtUpdate->execute([$docNo_hn1, $_ItemCodeIsSet1]);
                            } else {
                                // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                                $sqlDelete = "DELETE FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                                $stmtDelete = $conn->prepare($sqlDelete);
                                $stmtDelete->execute([$docNo_hn1, $_ItemCodeIsSet1]);
                            }
                        }
                    }


                    // // 1. ค้นหา DocNo จาก DocNo_SS
                    // $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                    // $stmtDoc = $conn->prepare($sqlDocNo);
                    // $stmtDoc->execute([$DocNo_pay]);
                    // $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                    // if ($row) {
                    //     $docNo_hn = $row['DocNo'];

                    //     // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                    //     $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                    //     $stmtCheck = $conn->prepare($sqlCheck);
                    //     $stmtCheck->execute([$docNo_hn, $_itemcode]);
                    //     $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                    //     if ($resultCheck) {
                    //         // เจอแล้ว -> UPDATE Qty +1
                    //         $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                    //         $stmtUpdate = $conn->prepare($sqlUpdate);
                    //         $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                    //     } else {
                    //         // ไม่เจอ -> INSERT
                    //         $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                    //         $stmtInsert = $conn->prepare($sqlInsert);
                    //         $stmtInsert->execute([$docNo_hn, $_itemcode]);
                    //     }
                    // }



                    $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                    $meQuery_old_sub = $conn->prepare($update_old_sub);
                    $meQuery_old_sub->execute();





                    //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

                    $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_borrow' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_ItemCodeIsSet1'
                            AND deproomdetail.IsRequest = 1 OR  deproomdetail.Ismanual = 1
                        GROUP BY
                            deproomdetail.ID ";
                    $meQuery_qq1 = $conn->prepare($qq1);
                    $meQuery_qq1->execute();
                    while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                        if ($row_qq1['cnt_pay'] == '0') {
                            $ID_Detail = $row_qq1['ID'];
                            $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                            $meQueryqq1 = $conn->prepare($queryqq1);
                            $meQueryqq1->execute();
                        }
                    }

                    $query_old = "DELETE FROM itemstock_transaction_detail  WHERE  ItemCode = '$_ItemCodeIsSet1' 
                        AND departmentroomid = '$__Ref_departmentroomid' 
                        AND  IsStatus = '1'
                        AND DATE(CreateDate) = '$_ModifyDate' ";
                    $meQuery_old = $conn->prepare($query_old);
                    $meQuery_old->execute();
                }
            }

            $cnt_type33 = 0;
            if ($_itemtypeID == 32) {
                $checkTypeID = "SELECT
                            COUNT( item.itemcode ) AS cnt_type33
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                        WHERE
                            deproom.DocNo = '$DocNo_pay' 
                            AND item.itemtypeID2 = '33' 
                            LIMIT 1 ";
                $meQuery_checkTypeID = $conn->prepare($checkTypeID);
                $meQuery_checkTypeID->execute();
                while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                    $cnt_type33 = $row_checkTypeID['cnt_type33'];
                }
            }

            if ($cnt_type33 == 0) {

                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime $is )
                VALUES
                    ( '$DocNo_pay', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

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
                                COUNT(deproomdetailsub.ID )  AS cnt_sub,
                                deproomdetailsub.PayDate AS ModifyDate
                            FROM
                                deproomdetail
                                INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                                LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.ItemCode = '$_itemcode' 
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
                    $_ID = $row_2['ID'];
                    $_PayDate = $row_2['PayDate'];
                    $_departmentroomid = $row_2['departmentroomid'];
                    $_procedure = $row_2['procedure'];
                    $_hn_record_id = $row_2['hn_record_id'];
                    $_doctor = $row_2['doctor'];
                    $_Qty_detail = $row_2['Qty'];
                    $_Qty_detail_sub = $row_2['cnt_sub'];
                    $_ModifyDate = $row_2['ModifyDate'];

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
                                        ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();

                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$input_docNo_HN_manual', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '$_itemcode'
                                                ) ";

                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$input_docNo_HN_manual'   ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();


                    $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                    $stmtDoc = $conn->prepare($sqlDocNo);
                    $stmtDoc->execute([$DocNo_pay]);
                    $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        $docNo_hn = $row['DocNo'];

                        // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                        $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                        $stmtCheck = $conn->prepare($sqlCheck);
                        $stmtCheck->execute([$docNo_hn, $_itemcode]);
                        $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                        if ($resultCheck) {
                            // เจอแล้ว -> UPDATE Qty +1
                            $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                            $stmtUpdate = $conn->prepare($sqlUpdate);
                            $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                        } else {
                            // ไม่เจอ -> INSERT
                            $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                            $stmtInsert = $conn->prepare($sqlInsert);
                            $stmtInsert->execute([$docNo_hn, $_itemcode]);
                        }
                    }




                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                }
            }

            // $count_itemstock = 2;
            // echo json_encode($count_itemstock);
            // unset($conn);
            // die;
        }
    }
}


function oncheck_delete_pay_mapping_block($conn, $db, $_ItemCodex, $DocNo_pay, $input_date_service, $item_status, $DocNo_borrow, $_itemtypeID, $_DocNoHN, $ismanual)
{
    $Userid = $_SESSION['Userid'];

    $qcheck = "SELECT
                    i.Barcode,
                    i.itemcode  ,
                    i.IsSet 
                FROM
                    item AS i 
                WHERE
                    EXISTS ( SELECT 1 FROM mapping_item AS m WHERE m.itemCode_main = '$_ItemCodex' AND FIND_IN_SET( i.itemcode, m.itemCode_sub ) > 0 ); ";

    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $_IsSet  = $rowq['IsSet'];

        $query_old = "SELECT
                        hncode_detail.ID AS hndetail_ID,
                        hncode_detail.ItemCode,
                        hncode_detail.Qty AS hncode_qty,
                        hncode.HnCode AS hn_record_id,
                        DATE( hncode.DocDate ) AS serviceDate,
                        hncode.departmentroomid AS Ref_departmentroomid,
                        DATE( hncode.DocDate ) AS ModifyDate,
                        hncode.number_box,
                        hncode.DocNo_SS AS DocNo,
                        hncode.DocNo AS hncode_DocNo 
                    FROM
                        hncode
                        LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                    WHERE
                        hncode.DocNo_SS = '$DocNo_borrow' 
                        AND hncode_detail.ItemCode = '$_itemcode' 
                    ORDER BY
                        hncode_detail.ID DESC 
                        LIMIT 1 ";

        // $query_old = " SELECT
        //                 deproomdetailsub.ID,
        //                 deproomdetail.ID AS detailID,
        //                 hncode_detail.ID AS hndetail_ID,
        //                 deproomdetail.ItemCode,
        //                 deproomdetail.Qty AS deproom_qty,
        //                 hncode_detail.Qty AS hncode_qty ,
        //                 deproom.hn_record_id,
        //                 DATE(deproom.serviceDate) AS serviceDate ,
        //                 deproom.Ref_departmentroomid ,
        //                 DATE(deproom.serviceDate)  AS ModifyDate,
        //                 deproom.number_box,
        //                 deproom.DocNo,
        //                 hncode.DocNo AS hncode_DocNo 
        //             FROM
        //                 deproom
        //                 LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
        //                 LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
        //                 LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
        //                 LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
        //             WHERE
        //                     deproom.DocNo = '$DocNo_borrow'
        //                 AND deproomdetail.ItemCode = '$_itemcode' 
        //                 AND deproomdetailsub.itemcode_weighing = '$_itemcode'
        //                 AND hncode_detail.ItemCode = '$_itemcode' 
        //                 ORDER BY deproomdetailsub.ID DESC
        //                 LIMIT 1 ";

        $meQuery_old = $conn->prepare($query_old);
        $meQuery_old->execute();
        while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
            $hndetail_ID = $row_old['hndetail_ID'];
            $DocNo_borrow = $row_old['DocNo'];
            $DocNoHN_borrow = $row_old['hncode_DocNo'];
            $hncode_qty = $row_old['hncode_qty'];
            $deproomdetailsub_id = $row_old['ID'];
            $_hn_record_id_borrow = $row_old['hn_record_id'];
            $_ModifyDate = $row_old['ModifyDate'];
            $__Ref_departmentroomid = $row_old['Ref_departmentroomid'];
            $_number_box = $row_old['number_box'];

            if ($_hn_record_id_borrow == "") {
                $_hn_record_id_borrow = $_number_box;
            }
        }

        $cnt_type32 = 0;
        if ($_itemtypeID == 32) {
            $checkTypeID = "    SELECT
                                    COUNT( item.itemcode ) AS cnt_type32 
                                FROM
                                    hncode
                                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                                WHERE
                                    hncode.DocNo_SS = '$DocNo_borrow' 
                                    AND item.itemtypeID2 = '32' 
                                    LIMIT 1 ";

            $meQuery_checkTypeID = $conn->prepare($checkTypeID);
            $meQuery_checkTypeID->execute();
            while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                $cnt_type32 = $row_checkTypeID['cnt_type32'];
            }
        }

        $cnt_type33 = 0;
        if ($_itemtypeID == 33) {

            $checkTypeID = "    SELECT
                                    COUNT( item.itemcode ) AS cnt_type33 
                                FROM
                                    hncode
                                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                                WHERE
                                    hncode.DocNo_SS = '$DocNo_borrow' 
                                    AND item.itemtypeID2 = '33' 
                                    LIMIT 1 ";
            $meQuery_checkTypeID = $conn->prepare($checkTypeID);
            $meQuery_checkTypeID->execute();
            while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                $cnt_type33 = $row_checkTypeID['cnt_type33'];
            }

            if ($cnt_type33 == 0) {

                $cnt_type32in33 = 0;
                if ($_itemtypeID == 33) {

                    $checkTypeID = "    SELECT
                                            COUNT( item.itemcode ) AS cnt_type32 
                                        FROM
                                            hncode
                                            INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                                            INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                                            INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                                        WHERE
                                            hncode.DocNo_SS = '$DocNo_pay' 
                                            AND item.itemtypeID2 = '32' 
                                            LIMIT 1 ";
                    $meQuery_checkTypeID = $conn->prepare($checkTypeID);
                    $meQuery_checkTypeID->execute();
                    while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                        $cnt_type32in33 = $row_checkTypeID['cnt_type32'];
                    }
                }

                // if ($_itemtypeID == 33) {
                //     $cnt_type32in33 = 1;
                // }


                if ($cnt_type32in33 > 0) {

                    if ($ismanual == 1) {
                        $is = " ,Ismanual ";
                    } else {
                        $is = " ,IsRequest ";
                    }


                    $item33 = "SELECT
                                i.Barcode,
                                i.itemcode ,
                                i.IsSet 
                            FROM
                                item AS i 
                            WHERE
                                 i.IsSet = 1 ";
                    $meQuery_item33 = $conn->prepare($item33);
                    $meQuery_item33->execute();
                    while ($row_item33 = $meQuery_item33->fetch(PDO::FETCH_ASSOC)) {
                        $itemcode_33 = $row_item33['itemcode'];
                    }


                    $query_old = " SELECT
                                deproom.Ref_departmentroomid,
                                deproom.hn_record_id
                            FROM
                                deproom
                            WHERE
                            deproom.DocNo = '$DocNo_pay' ";

                    $meQuery_old = $conn->prepare($query_old);
                    $meQuery_old->execute();
                    while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
                        $_departmentroomid = $row_old['Ref_departmentroomid'];
                        $_hn_record_id = $row_old['hn_record_id'];
                    }




                    $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                                    VALUES
                                    ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                    $meQuery = $conn->prepare($query);
                    $meQuery->execute();

                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                            (
                                                '$_DocNoHN', 
                                                '0',
                                                '0',
                                                1, 
                                                1, 
                                                0, 
                                                '$itemcode_33'
                                            ) ";

                    $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$_DocNoHN'   ";
                    $query_updateHN = $conn->prepare($query_updateHN);
                    $query_updateHN->execute();





                    $queryInsert2 = $conn->prepare($queryInsert2);
                    $queryInsert2->execute();
                }
            }
        }





        if ($cnt_type32 == 0 && $cnt_type33 == 0) {

            if (isset($hndetail_ID) && !empty($hndetail_ID)) {

                // $checkqty = "SELECT
                //         SUM( deproomdetail.Qty ) AS deproom_qty ,
                //         ( SELECT SUM( hncode_detail.Qty ) AS hncode_qty 
                //     FROM
                //         hncode
                //         LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                //     WHERE
                //         hncode_detail.ID = '$hndetail_ID'
                //         ) AS hncode_qty
                //     FROM
                //         deproom
                //         LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                //         LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                //     WHERE
                //         deproomdetail.ID = '$detailID' ";

                $checkqty = "	SELECT
                                    SUM( hncode_detail.Qty ) AS hncode_qty 
                                FROM
                                    hncode
                                    LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                                WHERE
                                    hncode_detail.ID = '$hndetail_ID'  ";

                // echo $checkqty;
                // exit;

                $meQuery_checkqty = $conn->prepare($checkqty);
                $meQuery_checkqty->execute();
                while ($row_checkqty = $meQuery_checkqty->fetch(PDO::FETCH_ASSOC)) {
                    $hncode_qty = $row_checkqty['hncode_qty'];
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
            }


            if (isset($__Ref_departmentroomid) && !empty($_ModifyDate)) {
                $query_old = "DELETE FROM itemstock_transaction_detail  WHERE  ItemCode = '$_itemcode' 
                        AND departmentroomid = '$__Ref_departmentroomid' 
                        AND  IsStatus = '1'
                        AND DATE(CreateDate) = '$_ModifyDate' ";
                $meQuery_old = $conn->prepare($query_old);
                $meQuery_old->execute();
            }

            $insert_log = "INSERT INTO log_return (itemstockID, DocNo, userID, itemCode , createAt) 
                            VALUES (0, :DocNo, :userID, :itemCode, NOW())";

            $meQuery_log = $conn->prepare($insert_log);

            $meQuery_log->bindParam(':DocNo', $DocNo_pay);
            $meQuery_log->bindParam(':userID', $Userid);
            $meQuery_log->bindParam(':itemCode', $_itemcode);
            $meQuery_log->execute();
        }
    }
}

function oncheck_delete_pay_mapping($conn, $db, $_ItemCodex, $DocNo_pay, $input_date_service, $item_status, $DocNo_borrow, $_itemtypeID, $_DocNoHN, $ismanual)
{
    $Userid = $_SESSION['Userid'];

    $qcheck = "SELECT
                    i.Barcode,
                    i.itemcode  ,
                    i.IsSet 
                FROM
                    item AS i 
                WHERE
                    EXISTS ( SELECT 1 FROM mapping_item AS m WHERE m.itemCode_main = '$_ItemCodex' AND FIND_IN_SET( i.itemcode, m.itemCode_sub ) > 0 ); ";

    $meQueryq = $conn->prepare($qcheck);
    $meQueryq->execute();
    while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
        $_itemcode  = $rowq['itemcode'];
        $_IsSet  = $rowq['IsSet'];

        $query_old = " SELECT
                        deproomdetailsub.ID,
                        deproomdetail.ID AS detailID,
                        hncode_detail.ID AS hndetail_ID,
                        deproomdetail.ItemCode,
                        deproomdetail.Qty AS deproom_qty,
                        hncode_detail.Qty AS hncode_qty ,
                        deproom.hn_record_id,
                        DATE(deproom.serviceDate) AS serviceDate ,
                        deproom.Ref_departmentroomid ,
                        DATE(deproom.serviceDate)  AS ModifyDate,
                        deproom.number_box,
                        deproom.DocNo,
                        hncode.DocNo AS hncode_DocNo 
                    FROM
                        deproom
                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                        LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo
                        LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                    WHERE
                            deproom.DocNo = '$DocNo_borrow'
                        AND deproomdetail.ItemCode = '$_itemcode' 
                        AND deproomdetailsub.itemcode_weighing = '$_itemcode'
                        AND hncode_detail.ItemCode = '$_itemcode' 
                        ORDER BY deproomdetailsub.ID DESC
                        LIMIT 1 ";

        $meQuery_old = $conn->prepare($query_old);
        $meQuery_old->execute();
        while ($row_old = $meQuery_old->fetch(PDO::FETCH_ASSOC)) {
            $detailID = $row_old['detailID'];
            $hndetail_ID = $row_old['hndetail_ID'];
            $DocNo_borrow = $row_old['DocNo'];
            $DocNoHN_borrow = $row_old['hncode_DocNo'];
            $deproom_qty = $row_old['deproom_qty'];
            $hncode_qty = $row_old['hncode_qty'];
            $deproomdetailsub_id = $row_old['ID'];
            $_hn_record_id_borrow = $row_old['hn_record_id'];
            $_ModifyDate = $row_old['ModifyDate'];
            $__Ref_departmentroomid = $row_old['Ref_departmentroomid'];
            $_number_box = $row_old['number_box'];

            if ($_hn_record_id_borrow == "") {
                $_hn_record_id_borrow = $_number_box;
            }
        }

        $cnt_type32 = 0;
        if ($_itemtypeID == 32) {
            $checkTypeID = "SELECT
                            COUNT( item.itemcode ) AS cnt_type32
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                        WHERE
                            deproom.DocNo = '$DocNo_borrow' 
                            AND item.itemtypeID2 = '32' 
                            LIMIT 1 ";
            $meQuery_checkTypeID = $conn->prepare($checkTypeID);
            $meQuery_checkTypeID->execute();
            while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                $cnt_type32 = $row_checkTypeID['cnt_type32'];
            }
        }

        $cnt_type33 = 0;
        if ($_itemtypeID == 33) {
            $checkTypeID = "SELECT
                            COUNT( item.itemcode ) AS cnt_type33
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                        WHERE
                            deproom.DocNo = '$DocNo_borrow' 
                            AND item.itemtypeID2 = '33' 
                            LIMIT 1 ";
            $meQuery_checkTypeID = $conn->prepare($checkTypeID);
            $meQuery_checkTypeID->execute();
            while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                $cnt_type33 = $row_checkTypeID['cnt_type33'];
            }

            if ($cnt_type33 == 0) {

                $cnt_type32in33 = 0;
                if ($_itemtypeID == 33) {
                    $checkTypeID = "SELECT
                            COUNT( item.itemcode ) AS cnt_type32
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                        WHERE
                            deproom.DocNo = '$DocNo_pay' 
                            AND item.itemtypeID2 = '32' 
                            LIMIT 1 ";
                    $meQuery_checkTypeID = $conn->prepare($checkTypeID);
                    $meQuery_checkTypeID->execute();
                    while ($row_checkTypeID = $meQuery_checkTypeID->fetch(PDO::FETCH_ASSOC)) {
                        $cnt_type32in33 = $row_checkTypeID['cnt_type32'];
                    }
                }

                // if ($_itemtypeID == 33) {
                //     $cnt_type32in33 = 1;
                // }


                if ($cnt_type32in33 > 0) {

                    if ($ismanual == 1) {
                        $is = " ,Ismanual ";
                    } else {
                        $is = " ,IsRequest ";
                    }


                    $item33 = "SELECT
                                i.Barcode,
                                i.itemcode ,
                                i.IsSet 
                            FROM
                                item AS i 
                            WHERE
                                 i.IsSet = 1 ";
                    $meQuery_item33 = $conn->prepare($item33);
                    $meQuery_item33->execute();
                    while ($row_item33 = $meQuery_item33->fetch(PDO::FETCH_ASSOC)) {
                        $itemcode_33 = $row_item33['itemcode'];
                    }
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime $is )
                    VALUES
                    ( '$DocNo_pay', '$itemcode_33', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

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
                            COUNT(deproomdetailsub.ID )  AS cnt_sub,
                            deproomdetailsub.PayDate AS ModifyDate
                        FROM
                            deproomdetail
                            INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo 
                            LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                        WHERE
                            deproomdetail.ItemCode = '$itemcode_33' 
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
                        $_ID = $row_2['ID'];
                        $_PayDate = $row_2['PayDate'];
                        $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];
                        $_Qty_detail = $row_2['Qty'];
                        $_Qty_detail_sub = $row_2['cnt_sub'];
                        $_ModifyDate = $row_2['ModifyDate'];

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
                        '$itemcode_33', 
                        1
                        ) ";

                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();

                        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty,hncode )
                                    VALUES
                                    ( '0', '$_itemcode','$input_date_service','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                        $meQuery = $conn->prepare($query);
                        $meQuery->execute();

                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                            (
                                                '$_DocNoHN', 
                                                '0',
                                                '0',
                                                1, 
                                                1, 
                                                0, 
                                                '$itemcode_33'
                                            ) ";

                        $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$_DocNoHN'   ";
                        $query_updateHN = $conn->prepare($query_updateHN);
                        $query_updateHN->execute();


                        $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                        $stmtDoc = $conn->prepare($sqlDocNo);
                        $stmtDoc->execute([$DocNo_pay]);
                        $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            $docNo_hn = $row['DocNo'];

                            // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                            $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                            $stmtCheck = $conn->prepare($sqlCheck);
                            $stmtCheck->execute([$docNo_hn, $_itemcode]);
                            $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                            if ($resultCheck) {
                                // เจอแล้ว -> UPDATE Qty +1
                                $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                                $stmtUpdate = $conn->prepare($sqlUpdate);
                                $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                            } else {
                                // ไม่เจอ -> INSERT
                                $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                                $stmtInsert = $conn->prepare($sqlInsert);
                                $stmtInsert->execute([$docNo_hn, $_itemcode]);
                            }
                        }




                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                    }
                }
            }
        }





        if ($cnt_type32 == 0 && $cnt_type33 == 0) {

            if (isset($hndetail_ID) && !empty($hndetail_ID)) {

                $checkqty = "SELECT
                        SUM( deproomdetail.Qty ) AS deproom_qty ,
                        ( SELECT SUM( hncode_detail.Qty ) AS hncode_qty 
                    FROM
                        hncode
                        LEFT JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo 
                    WHERE
                        hncode_detail.ID = '$hndetail_ID'
                        ) AS hncode_qty
                    FROM
                        deproom
                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    WHERE
                        deproomdetail.ID = '$detailID' ";


                $meQuery_checkqty = $conn->prepare($checkqty);
                $meQuery_checkqty->execute();
                while ($row_checkqty = $meQuery_checkqty->fetch(PDO::FETCH_ASSOC)) {
                    $deproom_qty = $row_checkqty['deproom_qty'];
                    $hncode_qty = $row_checkqty['hncode_qty'];
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


                // 1. ค้นหา DocNo จาก DocNo_SS
                $sqlDocNo1 = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                $stmtDoc1 = $conn->prepare($sqlDocNo1);
                $stmtDoc1->execute([$DocNo_borrow]);
                $row1 = $stmtDoc1->fetch(PDO::FETCH_ASSOC);

                if ($row1) {
                    $docNo_hn1 = $row1['DocNo'];

                    // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                    $sqlCheck1 = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                    $stmtCheck1 = $conn->prepare($sqlCheck1); // แก้ชื่อเป็น $sqlCheck1 ให้ตรงกัน
                    $stmtCheck1->execute([$docNo_hn1, $_itemcode]);
                    $resultCheck1 = $stmtCheck1->fetch(PDO::FETCH_ASSOC);

                    if ($resultCheck1) {
                        if ($resultCheck1['Qty'] > 1) {
                            // ถ้า Qty มากกว่า 1 -> ลบ 1
                            $sqlUpdate = "UPDATE his_detail SET Qty = Qty - 1 WHERE DocNo = ? AND ItemCode = ?";
                            $stmtUpdate = $conn->prepare($sqlUpdate);
                            $stmtUpdate->execute([$docNo_hn1, $_itemcode]);
                        } else {
                            // ถ้า Qty เท่ากับ 1 -> ลบ record นี้ทิ้ง
                            $sqlDelete = "DELETE FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                            $stmtDelete = $conn->prepare($sqlDelete);
                            $stmtDelete->execute([$docNo_hn1, $_itemcode]);
                        }
                    }
                }


                // 1. ค้นหา DocNo จาก DocNo_SS
                $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                $stmtDoc = $conn->prepare($sqlDocNo);
                $stmtDoc->execute([$DocNo_pay]);
                $row = $stmtDoc->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    $docNo_hn = $row['DocNo'];

                    // 2. เช็คว่า ItemCode มีอยู่ใน his_detail แล้วหรือยัง
                    $sqlCheck = "SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?";
                    $stmtCheck = $conn->prepare($sqlCheck);
                    $stmtCheck->execute([$docNo_hn, $_itemcode]);
                    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                    if ($resultCheck) {
                        // เจอแล้ว -> UPDATE Qty +1
                        $sqlUpdate = "UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?";
                        $stmtUpdate = $conn->prepare($sqlUpdate);
                        $stmtUpdate->execute([$docNo_hn, $_itemcode]);
                    } else {
                        // ไม่เจอ -> INSERT
                        $sqlInsert = "INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)";
                        $stmtInsert = $conn->prepare($sqlInsert);
                        $stmtInsert->execute([$docNo_hn, $_itemcode]);
                    }
                }



                $update_old_sub = "DELETE FROM deproomdetailsub WHERE deproomdetailsub.ID =  '$deproomdetailsub_id'    ";
                $meQuery_old_sub = $conn->prepare($update_old_sub);
                $meQuery_old_sub->execute();





                //check ว่า ตัว IsRequest = 1 เหลือกี่ตัว

                $qq1 = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                        WHERE
                            deproom.DocNo = '$DocNo_borrow' 
                            AND deproom.IsCancel = 0 
                            AND deproomdetail.IsCancel = 0 
                            AND deproomdetail.ItemCode = '$_itemcode'
                            AND deproomdetail.IsRequest = 1 OR  deproomdetail.Ismanual = 1
                        GROUP BY
                            deproomdetail.ID ";
                $meQuery_qq1 = $conn->prepare($qq1);
                $meQuery_qq1->execute();
                while ($row_qq1 = $meQuery_qq1->fetch(PDO::FETCH_ASSOC)) {
                    if ($row_qq1['cnt_pay'] == '0') {
                        $ID_Detail = $row_qq1['ID'];
                        $queryqq1 = "DELETE FROM deproomdetail WHERE ID =  '$ID_Detail' ";
                        $meQueryqq1 = $conn->prepare($queryqq1);
                        $meQueryqq1->execute();
                    }
                }
            }


            if (isset($__Ref_departmentroomid) && !empty($_ModifyDate)) {
                $query_old = "DELETE FROM itemstock_transaction_detail  WHERE  ItemCode = '$_itemcode' 
                        AND departmentroomid = '$__Ref_departmentroomid' 
                        AND  IsStatus = '1'
                        AND DATE(CreateDate) = '$_ModifyDate' ";
                $meQuery_old = $conn->prepare($query_old);
                $meQuery_old->execute();
            }
        }
    }
}



// function oncheck_delete_pay_mapping($conn, $db, $_ItemCodex, $DocNo_pay, $input_date_service, $item_status, $DocNo_borrow, $_itemtypeID, $_DocNoHN, $ismanual)
// {
//     $Userid = isset($_SESSION['Userid']) ? $_SESSION['Userid'] : 0;

//     try {
//         // ---------- BEGIN TRANSACTION ----------
//         $conn->beginTransaction();

//         // 1) หา item ที่ map กับ $_ItemCodex
//         $qMap = "
//             SELECT i.itemcode, i.IsSet
//             FROM item i
//             WHERE EXISTS (
//                 SELECT 1
//                 FROM mapping_item m
//                 WHERE m.itemCode_main = :main
//                   AND FIND_IN_SET(i.itemcode, m.itemCode_sub) > 0
//             )";
//         $stMap = $conn->prepare($qMap);
//         $stMap->execute([':main' => $_ItemCodex]);
//         $mapItems = $stMap->fetchAll(PDO::FETCH_ASSOC);
//         if (!$mapItems) { $conn->commit(); return; }

//         // 2) DocNo (HN) ของใบ borrow และ pay
//         $stDocHn = $conn->prepare("SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1");
//         $stDocHn->execute([$DocNo_borrow]); $row = $stDocHn->fetch(PDO::FETCH_ASSOC);
//         $docNo_hn_borrow = $row ? $row['DocNo'] : null;

//         $stDocHn->execute([$DocNo_pay]);    $row = $stDocHn->fetch(PDO::FETCH_ASSOC);
//         $docNo_hn_pay    = $row ? $row['DocNo'] : null;

//         // 3) นับ itemtype ในเอกสาร (ทำครั้งเดียว)
//         $cnt_type32_borrow = 0; $cnt_type33_borrow = 0; $cnt_type32_in_pay = 0;
//         if ($_itemtypeID == 32 || $_itemtypeID == 33) {
//             $qCnt = "
//                 SELECT i.itemtypeID, COUNT(*) AS cnt
//                 FROM deproomdetail d
//                 JOIN deproom r ON r.DocNo = d.DocNo
//                 JOIN item i    ON i.itemcode = d.ItemCode
//                 WHERE r.DocNo = :doc
//                 GROUP BY i.itemtypeID";
//             $stCnt = $conn->prepare($qCnt);

//             // borrow
//             $stCnt->execute([':doc' => $DocNo_borrow]);
//             foreach ($stCnt->fetchAll(PDO::FETCH_ASSOC) as $c) {
//                 if ((int)$c['itemtypeID'] === 32) $cnt_type32_borrow = (int)$c['cnt'];
//                 if ((int)$c['itemtypeID'] === 33) $cnt_type33_borrow = (int)$c['cnt'];
//             }
//             // pay (ใช้เฉพาะเคส 33)
//             if ($_itemtypeID == 33) {
//                 $stCnt->execute([':doc' => $DocNo_pay]);
//                 foreach ($stCnt->fetchAll(PDO::FETCH_ASSOC) as $c) {
//                     if ((int)$c['itemtypeID'] === 32) $cnt_type32_in_pay = (int)$c['cnt'];
//                 }
//             }
//         }

//         // 4) เตรียม statements ใช้ซ้ำ (ตั้งชื่อพารามิเตอร์ไม่ซ้ำ ป้องกัน HY093)
//         $stLatest = $conn->prepare("
//             SELECT
//                 ds.ID                        AS deproomdetailsub_id,
//                 d.ID                         AS detailID,
//                 hnd.ID                       AS hndetail_ID,
//                 d.Qty                        AS deproom_qty,
//                 hnd.Qty                      AS hncode_qty,
//                 r.hn_record_id,
//                 r.Ref_departmentroomid,
//                 DATE(r.serviceDate)          AS serviceDate,
//                 r.number_box,
//                 r.DocNo                      AS DocNo_borrow,
//                 hn.DocNo                     AS hncode_DocNo
//             FROM deproom r
//             JOIN deproomdetail d
//               ON r.DocNo = d.DocNo AND d.ItemCode = :item1
//             LEFT JOIN deproomdetailsub ds
//               ON ds.Deproomdetail_RowID = d.ID AND ds.itemcode_weighing = :item2
//             JOIN hncode hn
//               ON hn.DocNo_SS = r.DocNo
//             JOIN hncode_detail hnd
//               ON hnd.DocNo = hn.DocNo AND hnd.ItemCode = :item3
//             WHERE r.DocNo = :docno
//             ORDER BY ds.ID DESC
//             LIMIT 1
//         ");

//         $stHNQty  = $conn->prepare("SELECT Qty FROM hncode_detail WHERE ID = ?");
//         $stHNDel  = $conn->prepare("DELETE FROM hncode_detail WHERE ID = ?");
//         $stHNDec  = $conn->prepare("UPDATE hncode_detail SET Qty = Qty - 1 WHERE ID = ?");
//         $stHNto1  = $conn->prepare("UPDATE hncode SET IsStatus = 1 WHERE DocNo = ?");

//         $stHisChk = $conn->prepare("SELECT Qty FROM his_detail WHERE DocNo = ? AND ItemCode = ?");
//         $stHisInc = $conn->prepare("UPDATE his_detail SET Qty = Qty + 1 WHERE DocNo = ? AND ItemCode = ?");
//         $stHisIns = $conn->prepare("INSERT INTO his_detail (DocNo, ItemCode, Qty) VALUES (?, ?, 1)");
//         $stHisDec = $conn->prepare("UPDATE his_detail SET Qty = GREATEST(Qty - 1, 0) WHERE DocNo = ? AND ItemCode = ?");
//         $stHisDel0= $conn->prepare("DELETE FROM his_detail WHERE DocNo = ? AND ItemCode = ? AND Qty = 0");

//         $stDelSub = $conn->prepare("DELETE FROM deproomdetailsub WHERE ID = ?");

//         $stDelReq = $conn->prepare("
//             DELETE d
//             FROM deproomdetail d
//             LEFT JOIN (
//               SELECT Deproomdetail_RowID, SUM(qty_weighing) AS cnt_pay
//               FROM deproomdetailsub
//               GROUP BY Deproomdetail_RowID
//             ) s ON s.Deproomdetail_RowID = d.ID
//             JOIN deproom r ON r.DocNo = d.DocNo
//             WHERE r.DocNo = :doc
//               AND d.ItemCode = :itemcode
//               AND (d.IsRequest = 1 OR d.Ismanual = 1)
//               AND IFNULL(s.cnt_pay,0) = 0
//         ");

//         $stDelTxn = $conn->prepare("
//             DELETE FROM itemstock_transaction_detail
//             WHERE ItemCode = :item
//               AND departmentroomid = :dep
//               AND IsStatus = 1
//               AND CreateDate >= :ds AND CreateDate <= :de
//         ");

//         // เคสเพิ่ม IsSet=1 สำหรับ type 33
//         $stGetSetItem   = $conn->prepare("SELECT itemcode FROM item WHERE IsSet = 1 LIMIT 1");
//         $stInsDepDetail = $conn->prepare("
//             INSERT INTO deproomdetail (DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime, IsRequest, Ismanual)
//             VALUES (:doc, :item, 1, 3, NOW(), 0, :user, NOW(), :isrequest, :ismanual)
//         ");
//         $stGetDepDetail = $conn->prepare("
//             SELECT d.ID,
//                    r.Ref_departmentroomid AS departmentroomid,
//                    r.`procedure`,
//                    r.doctor,
//                    r.hn_record_id
//             FROM deproomdetail d
//             JOIN deproom r ON r.DocNo = d.DocNo
//             WHERE d.DocNo = :doc AND d.ItemCode = :item
//             ORDER BY d.ID DESC
//             LIMIT 1
//         ");
//         $stInsDepSub = $conn->prepare("
//             INSERT INTO deproomdetailsub
//             (Deproomdetail_RowID, dental_warehouse_id, IsStatus, IsCheckPay, PayDate,
//              hn_record_id, doctor, `procedure`, itemcode_weighing, qty_weighing)
//             VALUES (:rowid, :dep, 1, 1, NOW(), :hn, :doc, :proc, :icode, 1)
//         ");
//         $stInsTxn = $conn->prepare("
//             INSERT INTO itemstock_transaction_detail
//             (ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty, hncode)
//             VALUES (0, :icode, :dt, :dep, :user, 1, 1, :hn)
//         ");
//         $stInsHNDet = $conn->prepare("
//             INSERT INTO hncode_detail (DocNo, UsageCode, ItemStockID, Qty, IsStatus, IsCancel, ItemCode)
//             VALUES (:doc, '0', '0', 1, 1, 0, :icode)
//         ");

//         // 5) ลูปตาม item mapping
//         foreach ($mapItems as $mi) {
//             $_itemcode = $mi['itemcode'];

//             // 5.1 โหลดข้อมูลล่าสุดของรายการนี้ในใบ borrow (ป้องกัน HY093 ด้วย :item1,:item2,:item3)
//             $stLatest->execute([
//                 ':item1' => $_itemcode,
//                 ':item2' => $_itemcode,
//                 ':item3' => $_itemcode,
//                 ':docno' => $DocNo_borrow,
//             ]);
//             $latest = $stLatest->fetch(PDO::FETCH_ASSOC);
//             if (!$latest) { continue; }

//             $detailID               = $latest['detailID'];
//             $hndetail_ID            = $latest['hndetail_ID'];
//             $deproomdetailsub_id    = $latest['deproomdetailsub_id'];
//             $_hn_record_id_borrow   = $latest['hn_record_id'] ?: $latest['number_box'];
//             $__Ref_departmentroomid = $latest['Ref_departmentroomid'];
//             $_ModifyDate            = $latest['serviceDate']; // 'YYYY-MM-DD'

//             // 5.2 เคสพิเศษ type 33: ไม่มี type33 ใน borrow แต่ pay มี type32 → เติมชุด IsSet=1
//             if ($_itemtypeID == 33 && $cnt_type33_borrow == 0 && $cnt_type32_in_pay > 0) {
//                 $stGetSetItem->execute();
//                 $itemcode_33 = ($t = $stGetSetItem->fetch(PDO::FETCH_ASSOC)) ? $t['itemcode'] : null;

//                 if ($itemcode_33) {
//                     $stInsDepDetail->execute([
//                         ':doc'       => $DocNo_pay,
//                         ':item'      => $itemcode_33,
//                         ':user'      => $Userid,
//                         ':isrequest' => ($ismanual == 1 ? 0 : 1),
//                         ':ismanual'  => ($ismanual == 1 ? 1 : 0),
//                     ]);

//                     $stGetDepDetail->execute([':doc' => $DocNo_pay, ':item' => $itemcode_33]);
//                     if ($d = $stGetDepDetail->fetch(PDO::FETCH_ASSOC)) {
//                         $stInsDepSub->execute([
//                             ':rowid' => $d['ID'],
//                             ':dep'   => $d['departmentroomid'],
//                             ':hn'    => $d['hn_record_id'],
//                             ':doc'   => $d['doctor'],
//                             ':proc'  => $d['procedure'],
//                             ':icode' => $_itemcode,
//                         ]);

//                         $stInsTxn->execute([
//                             ':icode' => $_itemcode,
//                             ':dt'    => $input_date_service,
//                             ':dep'   => $d['departmentroomid'],
//                             ':user'  => $Userid,
//                             ':hn'    => $d['hn_record_id'],
//                         ]);

//                         $stHNto1->execute([$_DocNoHN]);

//                         if ($docNo_hn_pay) {
//                             $stHisChk->execute([$docNo_hn_pay, $_itemcode]);
//                             if ($stHisChk->fetch(PDO::FETCH_ASSOC)) {
//                                 $stHisInc->execute([$docNo_hn_pay, $_itemcode]);
//                             } else {
//                                 $stHisIns->execute([$docNo_hn_pay, $_itemcode]);
//                             }
//                         }

//                         $stInsHNDet->execute([
//                             ':doc'   => $_DocNoHN,
//                             ':icode' => $_itemcode,
//                         ]);
//                     }
//                 }
//                 continue; // เคสพิเศษเสร็จ ข้ามไปตัวถัดไป
//             }

//             // 5.3 เคสทั่วไป (ตัดจำนวน/ลบ/ย้าย)
//             // hncode_detail: ถ้า Qty <= 1 ลบ, ถ้า >1 ลดลง 1
//             $stHNQty->execute([$hndetail_ID]);
//             $qq = $stHNQty->fetch(PDO::FETCH_ASSOC);
//             if ($qq && (int)$qq['Qty'] <= 1) {
//                 $stHNDel->execute([$hndetail_ID]);
//             } else {
//                 $stHNDec->execute([$hndetail_ID]);
//             }

//             // his_detail (borrow) -1 แล้วถ้า 0 ให้ลบ
//             if ($docNo_hn_borrow) {
//                 $stHisDec->execute([$docNo_hn_borrow, $_itemcode]);
//                 $stHisDel0->execute([$docNo_hn_borrow, $_itemcode]);
//             }

//             // his_detail (pay) +1 (upsert manual)
//             if ($docNo_hn_pay) {
//                 $stHisChk->execute([$docNo_hn_pay, $_itemcode]);
//                 if ($stHisChk->fetch(PDO::FETCH_ASSOC)) {
//                     $stHisInc->execute([$docNo_hn_pay, $_itemcode]);
//                 } else {
//                     $stHisIns->execute([$docNo_hn_pay, $_itemcode]);
//                 }
//             }

//             // ลบ deproomdetailsub ตัวที่จ่ายไว้ก่อนหน้า (ถ้ามี)
//             if (!empty($deproomdetailsub_id)) {
//                 $stDelSub->execute([$deproomdetailsub_id]);
//             }

//             // ลบ deproomdetail ที่เป็น IsRequest/Ismanual แต่ไม่มีจ่ายจริงแล้ว
//             $stDelReq->execute([
//                 ':doc'      => $DocNo_borrow,
//                 ':itemcode' => $_itemcode,
//             ]);

//             // ลบ txn ของวันนั้น (ใช้ช่วงเวลาเพื่อให้ index ทำงาน)
//             if (!empty($_ModifyDate)) {
//                 $stDelTxn->execute([
//                     ':item' => $_itemcode,
//                     ':dep'  => $__Ref_departmentroomid,
//                     ':ds'   => $_ModifyDate . ' 00:00:00',
//                     ':de'   => $_ModifyDate . ' 23:59:59',
//                 ]);
//             }
//         }

//         // ---------- COMMIT ----------
//         $conn->commit();

//     } catch (Exception $e) {
//         if ($conn->inTransaction()) { $conn->rollBack(); }
//         throw $e;
//     }
// }





function show_detail_item_ByDocNo($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $permission = $_SESSION['permission'];

    // $wherepermission = "";
    // if ($permission != '5') {
    //     $wherepermission = " AND item.warehouseID = $permission ";
    // }

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM(deproomdetail.Qty) AS cnt ,
                IFNULL((
				SELECT SUM(deproomdetailsub.qty_weighing) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
				),0) AS cnt_pay,
                itemtype.TyeName,
                deproomdetail.Ismanual,
                deproomdetail.IsRequest,
                item.warehouseID,
                $permission AS permission
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
            ORDER BY deproomdetail.ModifyTime DESC ";

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
            ORDER BY deproomdetail.ModifyTime DESC ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}



function show_detail_deproom_pay_fix($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $input_searchHN_pay = $_POST['input_searchHN_pay'];
    $select_date_pay = $_POST['select_date_pay'];

    $select_date_pay = explode("-", $select_date_pay);
    $select_date_pay = $select_date_pay[2] . '-' . $select_date_pay[1] . '-' . $select_date_pay[0];


    $where = "";
    $where2 = "";
    if ($input_searchHN_pay == "") {
        $where = " deproom.DocNo = '$DocNo' ";
        $where2 = " deproom.DocNo = '$DocNo' ";
    } else {
        $where = "   DATE(deproom.serviceDate) = '$select_date_pay' AND  ( deproom.hn_record_id = '$input_searchHN_pay' OR deproom.number_box = '$input_searchHN_pay' )  ";
    }


    $query = " SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname
                    FROM
                        deproom
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    WHERE
                        $where
                        AND deproom.IsCancel = 0
                        AND deproom.IsBlock = 0
                    GROUP BY
                        departmentroom.id,
                        departmentroom.departmentroomname ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['departmentroomname'][] = $row;
        $_id = $row['id'];


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
                            deproom.`procedure`,
                            deproom.doctor AS doctorHN,
                            deproom.`procedure` AS procedureHN,
                            deproom.number_box,
                            deproom.IsConfirm_pay,
                            SUM(CASE WHEN deproomdetail.IsManual = 1 THEN 1 ELSE 0 END) AS IsManual ,
                            SUM(CASE WHEN deproomdetail.IsRequest = 1 THEN 1 ELSE 0 END) AS IsRequest  ,
	                        COALESCE(his.IsStatus, 0) AS his_IsStatus
                        FROM
                            deproom
                        LEFT JOIN
                            deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        INNER JOIN
                            departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        INNER JOIN
                            doctor ON deproom.doctor = doctor.ID
                        LEFT JOIN
                            `procedure` ON deproom.`procedure` = `procedure`.ID
                        LEFT JOIN 
                            his ON his.DocNo_Deproom = deproom.DocNo 
                        WHERE
                            $where
                            AND deproom.IsCancel = 0
                            AND deproom.IsBlock = 0
                        GROUP BY
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            `procedure`.Procedure_TH,
                            deproom.hn_record_id,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y'),
                            DATE_FORMAT(deproom.serviceDate, '%H:%i')
                        ORDER BY deproom.serviceDate ASC ";


        // echob$query_sub
        // echo $query_sub;
        // exit;
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
            $check_all = 0;
            $check_data = 0;

            $hasRows = false; // ตัวแปรสำหรับเช็คว่ามีข้อมูลหรือไม่
            $querych = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay,
                            deproomdetail.IsRequest 
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

                $hasRows = true;

                if ($rowch['IsRequest'] == 1) {
                    $rowch['cnt'] = 0;
                }



                if ((int)$rowch['cnt_pay'] < (int)$rowch['cnt']) {
                    $check_q++;
                }

                if ($rowch['cnt_pay'] > 0) {
                    $check_all = 1000;
                }
            }


            if (!$hasRows) {
                $check_data = 1;
            }
            if ($check_data == 1) {
                $row_sub['cnt_detail'] = 'ค้าง';
            } else {
                if ($check_q == 0) {

                    $row_sub['cnt_detail'] = 'ครบ';
                } else {

                    if ($check_all == 1000) {
                        $row_sub['cnt_detail'] = 'บางส่วน';
                    } else {
                        $row_sub['cnt_detail'] = 'ค้าง';
                    }
                }
            }



            $return[$_id][] = $row_sub;
        }
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
                    INNER JOIN doctor ON deproom.doctor = doctor.ID
                    WHERE
                        DATE(deproom.serviceDate) = '$select_date_pay'
                        $whereDep
                        AND deproom.IsCancel = 0
                        AND deproom.IsBlock = 0
                        AND deproom.IsEms = 0
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
                        AND deproom.IsBlock = 0
                        AND deproom.IsEms = 0
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
                            deproom.`procedure`,
                            deproom.doctor AS doctorHN,
                            deproom.`procedure` AS procedureHN,
                            deproom.number_box,
                            deproom.IsTF,
                            deproom.IsConfirm_pay,
                            SUM(CASE WHEN deproom.IsManual = 1 THEN 1 ELSE 0 END) AS IsManual ,
                            SUM(CASE WHEN deproomdetail.IsRequest = 1 THEN 1 ELSE 0 END) AS IsRequest  ,
	                        COALESCE(his.IsStatus, 0) AS his_IsStatus,
                              (
                                SELECT
                                    COUNT( lr.id ) 
                                FROM
                                    log_return lr
                                WHERE
                                    lr.DocNo = deproom.DocNo 
                                ) AS cnt_return
                        FROM
                            deproom
                        LEFT JOIN
                            deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        INNER JOIN
                            departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        INNER JOIN
                            doctor ON deproom.doctor = doctor.ID
                        LEFT JOIN
                            `procedure` ON deproom.`procedure` = `procedure`.ID
                        LEFT JOIN 
                            his ON his.DocNo_Deproom = deproom.DocNo 
                        WHERE
                            departmentroom.id = '$_id'
                            AND deproom.IsCancel = 0
                            AND DATE(deproom.serviceDate) = '$select_date_pay'
                            AND deproom.IsBlock = 0
                            AND deproom.IsEms = 0
                        GROUP BY
                            deproom.DocNo,
                            departmentroom.id,
                            departmentroom.departmentroomname,
                            doctor.Doctor_Name,
                            `procedure`.Procedure_TH,
                            deproom.hn_record_id,
                            DATE_FORMAT(deproom.serviceDate, '%d-%m-%Y'),
                            DATE_FORMAT(deproom.serviceDate, '%H:%i')
                        ORDER BY deproom.serviceDate ASC ";
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
                            LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
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
        // echo $query_sub;
        // exit;
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
            $check_all = 0;
            $check_data = 0;

            $hasRows = false; // ตัวแปรสำหรับเช็คว่ามีข้อมูลหรือไม่
            $querych = "SELECT
                            deproomdetail.ID,
                            SUM( deproomdetail.Qty ) AS cnt,
                            IFNULL(( SELECT SUM( deproomdetailsub.qty_weighing ) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID ), 0 ) AS cnt_pay,
                            deproomdetail.IsRequest 
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

                $hasRows = true;

                if ($rowch['IsRequest'] == 1) {
                    $rowch['cnt'] = 0;
                }



                if ((int)$rowch['cnt_pay'] < (int)$rowch['cnt']) {
                    $check_q++;
                }

                if ($rowch['cnt_pay'] > 0) {
                    $check_all = 1000;
                }
            }


            if (!$hasRows) {
                $check_data = 1;
            }
            if ($check_data == 1) {
                $row_sub['cnt_detail'] = 'ค้าง';
            } else {
                if ($check_q == 0) {

                    $row_sub['cnt_detail'] = 'ครบ';
                } else {

                    if ($check_all == 1000) {
                        $row_sub['cnt_detail'] = 'บางส่วน';
                    } else {
                        $row_sub['cnt_detail'] = 'ค้าง';
                    }
                }
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
