<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_stock') {
        show_detail_stock($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'feeddata_Payout_detail') {
        feeddata_Payout_detail($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onConfirmReceiveItemstock') {
        onConfirmReceiveItemstock($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_Payout_tab2') {
        feeddata_Payout_tab2($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_Payout_detail_tab2') {
        feeddata_Payout_detail_tab2($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onConfirmReceiveItemstock_auto') {
        onConfirmReceiveItemstock_auto($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_stock2') {
        show_detail_stock2($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_Payout_detail2') {
        feeddata_Payout_detail2($conn, $db);
    }
}

function onConfirmReceiveItemstock_auto($conn, $db)
{
    $return = array();
    $ArrayItemStockID = $_POST['ArrayItemStockID'];
    $Arraypayoutdetailsubid = $_POST['Arraypayoutdetailsubid'];
    $select_departmentRoom = $_POST['select_departmentRoom'];
    $DocNo = $_POST['DocNo'];

    $ItemStockID = "";
    $payoutdetailsubid = "";

    foreach ($ArrayItemStockID as $key => $value) {
        $ItemStockID .= $value . ",";
    }

    foreach ($Arraypayoutdetailsubid as $key => $value) {
        $payoutdetailsubid .= $value . ",";
    }


    $subItemStockID = substr($ItemStockID, 0, strlen($ItemStockID) - 1);
    $subpayoutdetailsubid = substr($payoutdetailsubid, 0, strlen($payoutdetailsubid) - 1);

    updateReceivePayout_auto($conn, $subItemStockID, $subpayoutdetailsubid, 'รับเข้าแผนก', $select_departmentRoom, $db);

    $IsStatus = updateReceivePayout_detail($conn, $DocNo, $db);

    // insertItemStock_Transaction($conn, $subItemStockID, 1);
    // insertItemStock_Balance($conn, $subItemStockID, 1, $select_departmentRoom);

    // echo ($subItemStockID);
    $query = "SELECT payout.IsStatus , payout.DocNo  , payout.RefDocNo FROM payout WHERE payout.DocNo = '$DocNo'  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row1 = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row1;
    }

    echo json_encode($return);


    unset($conn);
    die;
}

function updateReceivePayout_auto($conn, $ItemStockID, $payoutdetailsubid, $remark, $select_departmentRoom, $db)
{

    $DepID = $_SESSION['DepID'];
    $Userid = $_SESSION['Userid'];


    if ($db == 1) {
        $query_updateitemstock = "UPDATE itemstock  
                                    SET		IsStatus = 5, 
                                            IsTag = 0 ,
                                            IsPrintDept = 0 ,
                                            IsConfirmToSend = 0 ,
                                            DepID = $DepID , 
                                            LastReceiveInDeptDate = NOW()
                                    WHERE   RowID IN (  $ItemStockID  ) ";

        $query_updatepayoutdetailsub = "UPDATE payoutdetailsub  
                                    SET		IsStatus = 3, 
                                            ReceiveDateTime = NOW() ,
                                            UserReceiveID =   $Userid  ,
                                            Remark = '$remark' 
                                    WHERE   ID IN (  $payoutdetailsubid  ) ";
    } else {
        $query_updateitemstock = "UPDATE itemstock  
                                    SET		IsStatus = 5, 
                                            IsTag = 0 ,
                                            IsPrintDept = 0 ,
                                            IsConfirmToSend = 0 ,
                                            DepID = $DepID , 
                                            LastReceiveInDeptDate = GETDATE()
                                    WHERE   RowID IN (  $ItemStockID  ) ";

        $query_updatepayoutdetailsub = "UPDATE payoutdetailsub  
                                    SET		IsStatus = 3, 
                                            ReceiveDateTime = GETDATE() ,
                                            UserReceiveID =   $Userid  ,
                                            Remark = '$remark' 
                                    WHERE   ID IN (  $payoutdetailsubid  ) ";
    }


    $meQuery2 = $conn->prepare($query_updateitemstock);
    $meQuery2->execute();






    $meQuery = $conn->prepare($query_updatepayoutdetailsub);
    $meQuery->execute();


    // echo json_encode($return);


}

function show_detail_stock($conn, $db)
{
    $return = [];

    $select_Date = $_POST['select_date_receive'];

    $select_Date = explode("-", $select_Date);
    $select_Date = $select_Date[2] . '-' . $select_Date[1] . '-' . $select_Date[0];


    if ($db == 1) {
        $q1 = " SELECT
                    payout.RefDocNo
                FROM
                    payout
                INNER JOIN
                    department ON department.ID = payout.DeptID
                INNER JOIN
                    payoutdetail ON payoutdetail.DocNo = payout.DocNo
                INNER JOIN
                    payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                WHERE
                    payout.IsCancel = 0
                    AND payout.IsSpecial = 0
                    AND payout.IsBorrow = 0
                    AND payout.DeptID IN (387, 388)
                    AND DATE_FORMAT(payout.CreateDate, '%Y-%m-%d') = '$select_Date'
                    AND payout.IsStatus IN (1, 2, 3, 8)
                GROUP BY
                    payout.RefDocNo ";
    } else {
        $q1 = " SELECT
                    payout.RefDocNo
                FROM
                    payout
                    INNER JOIN department ON department.ID = payout.DeptID
                    INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
                    INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID 
                WHERE
                    payout.IsCancel = 0 
                    AND payout.IsSpecial = 0 
                    AND payout.IsBorrow = 0 
                    AND payout.DeptID IN ( 387, 388 ) 
                    AND ( FORMAT ( payout.CreateDate, 'yyyy-MM-dd' ) = '$select_Date' ) 
                    AND payout.IsStatus IN ( 1, 2, 3, 8 ) 
                GROUP BY
                    payout.RefDocNo ";
    }


    $meQuery = $conn->prepare($q1);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RefDocNo = $row['RefDocNo'];
        $return['RefDocNo'][] = $row;



        if ($db == 1) {
            $query1 = " SELECT
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            DATE_FORMAT(payout.CreateDate, '%d-%m-%Y %H:%i:%s') AS CreateDate,
                            COALESCE(payout.`Desc`, '') AS Descriptions,
                            payout.RefDocNo,
                            payout.IsStatus AS IsStatus,
                            COUNT(payoutdetailsub.ID) AS qty
                        FROM
                            payout
                        INNER JOIN
                            department ON department.ID = payout.DeptID
                        INNER JOIN
                            payoutdetail ON payoutdetail.DocNo = payout.DocNo
                        INNER JOIN
                            payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                        WHERE
                            payout.IsCancel = 0
                            AND payout.IsSpecial = 0
                            AND payout.IsBorrow = 0
                            AND payout.DeptID IN (387, 388)
                            AND DATE_FORMAT(payout.CreateDate, '%Y-%m-%d') = '$select_Date'
                            AND payout.IsStatus IN (1, 2, 3, 8)
                            AND payout.RefDocNo = '$RefDocNo'
                        GROUP BY
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            DATE_FORMAT(payout.CreateDate, '%d-%m-%Y %H:%i:%s'),
                            COALESCE(payout.`Desc`, ''),
                            payout.RefDocNo,
                            payout.IsStatus
                        ORDER BY
                            payout.Id, payout.IsStatus DESC ";
        } else {
            $query1 = "SELECT
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            FORMAT (
                                payout.CreateDate,
                                'dd-MM-yyyy HH:mm:ss'
                            ) AS CreateDate,
                            COALESCE (payout.[Desc], '') AS Descriptions,
                            payout.RefDocNo,
                            payout.IsStatus AS IsStatus,
                            COUNT(payoutdetailsub.ID) AS qty
                        FROM
                            payout
                        INNER JOIN department ON department.ID = payout.DeptID
                        INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
                        INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                        WHERE
                            payout.IsCancel = 0
                        AND payout.IsSpecial = 0
                        AND payout.IsBorrow = 0
                        AND payout.DeptID IN ( 387 , 388)
                        AND (FORMAT (payout.CreateDate, 'yyyy-MM-dd')  = '$select_Date' )
                        AND payout.IsStatus IN (1, 2, 3, 8)
                        AND payout.RefDocNo = '$RefDocNo'
                        GROUP BY
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            FORMAT (
                                payout.CreateDate,
                                'dd-MM-yyyy HH:mm:ss'
                            ),
                            COALESCE (payout.[Desc], ''),
                            payout.RefDocNo,
                            payout.IsStatus
                        ORDER BY
                            payout.Id  , payout.IsStatus DESC ";
        }


        $meQuery1 = $conn->prepare($query1);
        $meQuery1->execute();
        while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            $return[$RefDocNo][] = $row1;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_stock2($conn, $db)
{
    $return = [];

    $select_Date = $_POST['select_date_receive'];

    $select_Date = explode("-", $select_Date);
    $select_Date = $select_Date[2] . '-' . $select_Date[1] . '-' . $select_Date[0];

    $q1 = "SELECT
                sendsterile.DocNo,
                SUM(sendsteriledetail.Qty) AS qty
            FROM
                sendsterile
                INNER JOIN  sendsteriledetail ON sendsterile.DocNo = sendsteriledetail.SendSterileDocNo 
            GROUP BY
                sendsterile.DocNo  ";

    $meQuery = $conn->prepare($q1);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['RefDocNo'][] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function feeddata_Payout_detail($conn, $db)
{
    $return = array();

    $DocNo = $_POST['DocNo'];

    $DepID = $_SESSION['DepID'];


    if ($db == 1) {
        $query = "SELECT
                        item.itemcode,
                        item.itemname,
                        (
                            SELECT COUNT(pds.ID)
                            FROM payoutdetailsub AS pds
                            INNER JOIN payoutdetail AS pd ON pd.ID = pds.Payoutdetail_RowID
                            WHERE pd.DocNo = payoutdetail.DocNo AND pd.itemcode = itemstock.ItemCode
                        ) AS CountItem,
                        payoutdetail.IsStatus
                    FROM
                        payoutdetailsub
                    INNER JOIN
                        payoutdetail ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                    INNER JOIN
                        item ON item.itemcode = payoutdetail.ItemCode
                    INNER JOIN
                        itemstock ON payoutdetailsub.ItemStockID = itemstock.RowId
                    LEFT JOIN
                        occurancetype ON occurancetype.ID = payoutdetailsub.OccuranceTypeID
                    INNER JOIN
                        payout ON payout.DocNo = payoutdetail.DocNo
                    LEFT JOIN
                        employee AS employee_1 ON employee_1.ID = payout.RecipientCode
                    LEFT JOIN
                        employee AS employee_2 ON employee_2.ID = payout.Approve
                    WHERE
                        payoutdetail.DocNo = '$DocNo'
                    GROUP BY
                        item.itemcode,
                        item.itemname,
                        payoutdetail.DocNo,
                        itemstock.ItemCode,
                        payoutdetail.IsStatus
                    ORDER BY
                        item.itemname, payoutdetail.IsStatus ASC ";
    } else {
        $query = "SELECT
                item.itemcode,
                item.itemname,
                (
                SELECT COUNT( pds.ID ) 
                FROM
                    payoutdetailsub AS pds
                    INNER JOIN payoutdetail AS pd ON pd.ID = pds.Payoutdetail_RowID 
                WHERE
                    pd.DocNo = payoutdetail.DocNo 
                    AND pd.itemcode = itemstock.ItemCode 
                ) AS CountItem,
                payoutdetail.IsStatus
            FROM
                payoutdetailsub
                INNER JOIN payoutdetail ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                INNER JOIN item ON item.itemcode = payoutdetail.ItemCode
                INNER JOIN itemstock ON payoutdetailsub.ItemStockID = itemstock.RowId
                LEFT JOIN occurancetype ON occurancetype.ID = payoutdetailsub.OccuranceTypeID
                INNER JOIN payout ON payout.DocNo = payoutdetail.DocNo
                LEFT JOIN employee AS employee_1 ON employee_1.ID = payout.RecipientCode
                LEFT JOIN employee AS employee_2 ON employee_2.ID = payout.Approve 
            WHERE
                payoutdetail.DocNo = '$DocNo'
            GROUP BY
                item.itemcode,
                item.itemname,
                payoutdetail.DocNo,
                itemstock.ItemCode,
                payoutdetail.IsStatus
            ORDER BY
                item.itemname , payoutdetail.IsStatus ASC ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $return['itemcode'][] = $row;
        $itemcode = $row['itemcode'];

        $q1 = "SELECT
                    itemstock.UsageCode,
                    itemstock.RowID,
                    payoutdetailsub.Id,
                    payoutdetailsub.IsStatus,
                    payoutdetail.DocNo
                FROM
                    payoutdetailsub
                    INNER JOIN payoutdetail ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                    INNER JOIN item ON item.itemcode = payoutdetail.ItemCode
                    INNER JOIN itemstock ON payoutdetailsub.ItemStockID = itemstock.RowId
                    LEFT JOIN occurancetype ON occurancetype.ID = payoutdetailsub.OccuranceTypeID
                    INNER JOIN payout ON payout.DocNo = payoutdetail.DocNo
                    LEFT JOIN employee AS employee_1 ON employee_1.ID = payout.RecipientCode
                    LEFT JOIN employee AS employee_2 ON employee_2.ID = payout.Approve 
                WHERE
                    payoutdetail.DocNo = '$DocNo'
                    AND item.itemcode = '$itemcode'
                ORDER BY
                    item.itemname ASC ";

        $meQuery1 = $conn->prepare($q1);
        $meQuery1->execute();
        while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            $return[$itemcode][] = $row1;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata_Payout_detail2($conn, $db)
{
    $return = array();

    $DocNo = $_POST['DocNo'];

    $DepID = $_SESSION['DepID'];


    $query = "SELECT
                    item.itemname ,
                    sendsteriledetail.Qty
                FROM
                    dbo.sendsteriledetail
                    INNER JOIN dbo.item ON sendsteriledetail.UsageCode = item.itemcode
                WHERE SendSterileDocNo = '$DocNo' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function onConfirmReceiveItemstock($conn, $db)
{
    $return = array();
    $ArrayItemStockID = $_POST['ArrayItemStockID'];
    $Arraypayoutdetailsubid = $_POST['Arraypayoutdetailsubid'];
    $select_departmentRoom = $_POST['select_departmentRoom'];
    $DocNo = $_POST['DocNo'];

    $ItemStockID = "";
    $payoutdetailsubid = "";

    foreach ($ArrayItemStockID as $key => $value) {
        $ItemStockID .= $value . ",";
    }

    foreach ($Arraypayoutdetailsubid as $key => $value) {
        $payoutdetailsubid .= $value . ",";
    }


    $subItemStockID = substr($ItemStockID, 0, strlen($ItemStockID) - 1);
    $subpayoutdetailsubid = substr($payoutdetailsubid, 0, strlen($payoutdetailsubid) - 1);

    updateReceivePayout($conn, $subItemStockID, $subpayoutdetailsubid, 'รับเข้าแผนก', $select_departmentRoom, $db);

    $IsStatus = updateReceivePayout_detail($conn, $DocNo, $db);


    // echo ($subItemStockID);
    $query = "SELECT payout.IsStatus , payout.DocNo  , payout.RefDocNo FROM payout WHERE payout.DocNo = '$DocNo'  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row1 = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row1;
    }

    echo json_encode($return);


    unset($conn);
    die;
}

function updateReceivePayout_detail($conn, $DocNo, $db)
{

    $DepID = $_SESSION['DepID'];
    $Userid = $_SESSION['Userid'];

    if ($db == 1) {
        $query_updatepayoutdetail = "UPDATE payoutdetail
                                        SET IsStatus = (
                                            CASE
                                                WHEN (SELECT COUNT(*) FROM payoutdetailsub WHERE Payoutdetail_RowID = payoutdetail.ID AND IsStatus <> 3) = 0 THEN 3
                                                ELSE 2
                                            END
                                        )
                                        WHERE DocNo = '$DocNo' ";

        $query_updatepayout = "UPDATE payout
                                    SET
                                        IsStatus = (
                                            CASE
                                                WHEN (SELECT COUNT(*) FROM payoutdetail WHERE DocNo = payout.DocNo AND IsStatus <> 3) = 0 THEN 3
                                                ELSE 2
                                            END
                                        ),
                                        ModifyDate = NOW(),
                                        Remark = CONCAT(COALESCE(Remark, ''), ', แผนกรับเข้า')
                                    WHERE
                                        DocNo = '$DocNo' ";
    } else {
        $query_updatepayoutdetail = "UPDATE payoutdetail  
                                    SET	payoutdetail.IsStatus = ( CASE WHEN (
                                    (SELECT COUNT(*) FROM 	payoutdetailsub WHERE payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                                    AND payoutdetailsub.IsStatus <> 3 ) = 0 ) THEN 3 ELSE 2 END )   
                                    WHERE payoutdetail.DocNo = '$DocNo' ";

        $query_updatepayout = "UPDATE payout  
                                SET	payout.IsStatus = ( CASE WHEN (
                                (SELECT COUNT(*) FROM 	payoutdetail WHERE 	payoutdetail.DocNo = payout.DocNo
                                AND payoutdetail.IsStatus <> 3 ) = 0 ) THEN 3 ELSE 2 END ) ,
                                payout.ModifyDate = GETDATE(),
                                payout.Remark = CONCAT(COALESCE(Remark, ''), ', แผนกรับเข้า') 
                                WHERE payout.DocNo = '$DocNo' ";
    }





    $meQuery = $conn->prepare($query_updatepayoutdetail);
    $meQuery->execute();
    $meQuery2 = $conn->prepare($query_updatepayout);
    $meQuery2->execute();
}

function updateReceivePayout($conn, $ItemStockID, $payoutdetailsubid, $remark, $select_departmentRoom, $db)
{

    $DepID = $_SESSION['DepID'];
    $Userid = $_SESSION['Userid'];


    if($db == 1){
        $query_updateitemstock = "UPDATE itemstock  
        SET		IsStatus = 5, 
                IsTag = 0 ,
                IsPrintDept = 0 ,
                IsConfirmToSend = 0 ,
                Isdeproom = 0 ,
                departmentroomid = $select_departmentRoom ,
                DepID = $DepID , 
                LastReceiveInDeptDate = NOW()
        WHERE   RowID IN (  $ItemStockID  ) ";
        $meQuery2 = $conn->prepare($query_updateitemstock);
        $meQuery2->execute();
    
    
        $query_updatepayoutdetailsub = "UPDATE payoutdetailsub  
                                            SET		IsStatus = 3, 
                                                    ReceiveDateTime = NOW(),
                                                    UserReceiveID =   $Userid  ,
                                                    Remark = '$remark' 
                                            WHERE   ID IN (  $payoutdetailsubid  ) ";
    }else{
        $query_updateitemstock = "UPDATE itemstock  
    SET		IsStatus = 5, 
            IsTag = 0 ,
            IsPrintDept = 0 ,
            IsConfirmToSend = 0 ,
            Isdeproom = 0 ,
            departmentroomid = $select_departmentRoom ,
            DepID = $DepID , 
            LastReceiveInDeptDate = GETDATE()
    WHERE   RowID IN (  $ItemStockID  ) ";
    $meQuery2 = $conn->prepare($query_updateitemstock);
    $meQuery2->execute();


    $query_updatepayoutdetailsub = "UPDATE payoutdetailsub  
                                        SET		IsStatus = 3, 
                                                ReceiveDateTime = GETDATE() ,
                                                UserReceiveID =   $Userid  ,
                                                Remark = '$remark' 
                                        WHERE   ID IN (  $payoutdetailsubid  ) ";
    }






    $meQuery = $conn->prepare($query_updatepayoutdetailsub);
    $meQuery->execute();


    // echo json_encode($return);


}

function feeddata_Payout_tab2($conn, $db)
{
    $return = array();

    $select_Date1 = $_POST['select_date_pay'];
    $select_Date2 = $_POST['select_Edate_pay'];

    $DepID = $_SESSION['DepID'];
    $select_Date1 = explode("-", $select_Date1);
    $select_Date1 = $select_Date1[2] . '-' . $select_Date1[1] . '-' . $select_Date1[0];

    $select_Date2 = explode("-", $select_Date2);
    $select_Date2 = $select_Date2[2] . '-' . $select_Date2[1] . '-' . $select_Date2[0];


    if($db == 1){
        $q1 = " SELECT
                    payout.RefDocNo
                FROM
                    payout
                INNER JOIN
                    department ON department.ID = payout.DeptID
                INNER JOIN
                    payoutdetail ON payoutdetail.DocNo = payout.DocNo
                INNER JOIN
                    payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                WHERE
                    payout.IsCancel = 0
                    AND payout.IsSpecial = 0
                    AND payout.IsBorrow = 0
                    AND payout.DeptID IN (387, 388)
                    AND DATE_FORMAT(payout.CreateDate, '%Y-%m-%d') BETWEEN '$select_Date1' AND '$select_Date2'
                    AND payout.IsStatus IN (1, 2, 3, 8)
                GROUP BY
                    payout.RefDocNo ";
    }else{
        $q1 = " SELECT
                    payout.RefDocNo
                FROM
                    payout
                    INNER JOIN department ON department.ID = payout.DeptID
                    INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
                    INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID 
                WHERE
                    payout.IsCancel = 0 
                    AND payout.IsSpecial = 0 
                    AND payout.IsBorrow = 0 
                    AND payout.DeptID IN ( 387, 388 ) 
                    AND FORMAT ( payout.CreateDate, 'yyyy-MM-dd' ) BETWEEN '$select_Date1' AND '$select_Date2'
                    AND payout.IsStatus IN ( 1, 2, 3, 8 ) 
                GROUP BY
                    payout.RefDocNo ";
    }
 

    $meQuery = $conn->prepare($q1);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RefDocNo = $row['RefDocNo'];
        $return['RefDocNo'][] = $row;


        if($db == 1){
            $query1 = "SELECT
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            DATE_FORMAT(payout.CreateDate, '%d-%m-%Y %H:%i:%s') AS CreateDate,
                            COALESCE(payout.`Desc`, '') AS Descriptions,
                            payout.RefDocNo,
                            payout.IsStatus AS IsStatus,
                            COUNT(payoutdetailsub.ID) AS qty
                        FROM
                            payout
                        INNER JOIN
                            department ON department.ID = payout.DeptID
                        INNER JOIN
                            payoutdetail ON payoutdetail.DocNo = payout.DocNo
                        INNER JOIN
                            payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                        WHERE
                            payout.IsCancel = 0
                            AND payout.IsSpecial = 0
                            AND payout.IsBorrow = 0
                            AND payout.DeptID IN (387, 388)
                            AND DATE_FORMAT(payout.CreateDate, '%Y-%m-%d') = '$select_Date1'
                            AND payout.IsStatus IN (1, 2, 3, 8)
                            AND payout.RefDocNo = '$RefDocNo'
                        GROUP BY
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            DATE_FORMAT(payout.CreateDate, '%d-%m-%Y %H:%i:%s'),
                            COALESCE(payout.`Desc`, ''),
                            payout.RefDocNo,
                            payout.IsStatus
                        ORDER BY
                            payout.Id, payout.IsStatus DESC ";
        }else{
            $query1 = "SELECT
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            FORMAT (
                                payout.CreateDate,
                                'dd-MM-yyyy HH:mm:ss'
                            ) AS CreateDate,
                            COALESCE (payout.[Desc], '') AS Descriptions,
                            payout.RefDocNo,
                            payout.IsStatus AS IsStatus,
                            COUNT(payoutdetailsub.ID) AS qty
                        FROM
                            payout
                        INNER JOIN department ON department.ID = payout.DeptID
                        INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
                        INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
                        WHERE
                            payout.IsCancel = 0
                        AND payout.IsSpecial = 0
                        AND payout.IsBorrow = 0
                        AND payout.DeptID IN ( 387 , 388)
                        AND FORMAT ( payout.CreateDate, 'yyyy-MM-dd' ) = '$select_Date1'
                        AND payout.IsStatus IN (1, 2, 3, 8)
                        AND payout.RefDocNo = '$RefDocNo'
                        GROUP BY
                            payout.DocNo,
                            payout.Id,
                            department.DepName2,
                            FORMAT (
                                payout.CreateDate,
                                'dd-MM-yyyy HH:mm:ss'
                            ),
                            COALESCE (payout.[Desc], ''),
                            payout.RefDocNo,
                            payout.IsStatus
                        ORDER BY
                            payout.Id  , payout.IsStatus DESC ";
        }



        $meQuery1 = $conn->prepare($query1);
        $meQuery1->execute();
        while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
            $return[$RefDocNo][] = $row1;
        }
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata_Payout_detail_tab2($conn, $db)
{
    $return = array();
    $RefDocNo = $_POST['RefDocNo'];
    $RefDocNo_ = "";
    foreach ($RefDocNo as $key => $value) {
        $RefDocNo_ .= "'" . $value . "',";
    }
    $RefDocNo_ = substr($RefDocNo_, 0, -1);
    $query = "SELECT
                    payoutdetail.Id,
                    item.itemname,
                    	(
	
                            SELECT COUNT(payoutdetailsub.Id) FROM payoutdetailsub WHERE Payoutdetail_RowID = payoutdetail.Id AND payoutdetailsub.IsStatus = 3
                        
                        ) AS qty ,
                    item.CostPrice,
                    (( SELECT COUNT ( payoutdetailsub.Id ) FROM payoutdetailsub WHERE Payoutdetail_RowID = payoutdetail.Id AND payoutdetailsub.IsStatus = 3 ) * item.CostPrice) AS totalPrice
            FROM
                payout
            INNER JOIN department ON department.ID = payout.DeptID
            INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
            INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID
            INNER JOIN itemstock ON payoutdetailsub.ItemStockID = itemstock.RowID
            INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            WHERE
                payout.IsCancel = 0
            AND payout.IsSpecial = 0
            AND payout.IsBorrow = 0
             AND payout.DeptID IN ( 387 , 388)
            AND payout.IsStatus IN (1, 2, 3, 8)
            AND payout.RefDocNo IN ( $RefDocNo_ )
            GROUP BY
                item.itemname,
            item.CostPrice,
	        payoutdetail.Id 
            ORDER BY  item.itemname";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }

    echo json_encode($return);
    unset($conn);
    die;
}
