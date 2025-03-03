<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';
require '../process/CreateDamage.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_item_surgery') {
        show_detail_item_surgery($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'updateStatus_DocNo') {
        updateStatus_DocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_item_ByDocNo') {
        show_detail_item_ByDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_use') {
        oncheck_use($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_stock_back') {
        oncheck_stock_back($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_send') {
        onconfirm_send($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_damage') {
        onconfirm_damage($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'cancelDamage') {
        cancelDamage($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'searchItemName') {
        searchItemName($conn, $db);
    }
}

function searchItemName($conn, $db)
{
    $return = array();
    $itemcode = $_POST['itemcode'];
    $query = " SELECT
                    item.itemname 
                FROM
                    item
                WHERE item.itemcode = '$itemcode'  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $itemname = $row['itemname'];
    }

        echo json_encode($itemname);
        unset($conn);
        die;
}

function cancelDamage($conn, $db)
{
    $return = array();
    $itemcode = $_POST['itemcode'];
    $UsageCode = $_POST['UsageCode'];
    $DocNo = $_POST['DocNo'];

    
    if($db == 1){
        $query = "SELECT
                        itemstock.RowID,
                        itemstock.UsageCode,
                        deproomdetailsub.ID
                    FROM
                        deproom
                    INNER JOIN
                        deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN
                        item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN
                        deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN
                        itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    WHERE
                        deproom.IsCancel = 0
                        AND (deproomdetailsub.IsStatus = 2 OR deproomdetailsub.IsStatus = 4)
                        AND deproom.DocNo = '$DocNo'
                        AND itemstock.UsageCode = '$UsageCode'
                        AND itemstock.IsDamage = '1'
                    LIMIT 1 ";
    }else{
        $query = " SELECT TOP
                    1 itemstock.RowID ,
                    itemstock.UsageCode,
                    deproomdetailsub.ID 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    deproom.IsCancel = 0 
                    AND ( deproomdetailsub.IsStatus = 2  OR deproomdetailsub.IsStatus = 4  )
                    AND deproom.DocNo = '$DocNo'
                    AND itemstock.UsageCode = '$UsageCode' 
                    AND itemstock.IsDamage = '1'  ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RowID = $row['RowID'];
        $ID = $row['ID'];

        $queryInsert1 = "DELETE FROM damage  WHERE DocNo = (SELECT DocNo FROM damagedetail WHERE deproomdetailsub_id = '$ID' ) ";
        $meQueryInsert1 = $conn->prepare($queryInsert1);
        $meQueryInsert1->execute();

        $queryInsert2 = "DELETE FROM damagedetail  WHERE deproomdetailsub_id = '$ID' ";
        $meQueryInsert2 = $conn->prepare($queryInsert2);
        $meQueryInsert2->execute();

        $update1 = "UPDATE deproomdetailsub SET deproomdetailsub.IsDamage = NULL  WHERE deproomdetailsub.ID = '$ID' ";
        $meQuery1 = $conn->prepare($update1);
        $meQuery1->execute();

        $update2 = "UPDATE itemstock SET itemstock.IsDamage = NULL   WHERE itemstock.RowID = '$RowID' ";
        $meQuery2 = $conn->prepare($update2);
        $meQuery2->execute();


        
        $queryInsertHN = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
        (
        (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo' ), 
        '$UsageCode',
        '$RowID',
        1, 
        1, 
        0, 
        (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $RowID)
        ) ";


        $queryInsertHN = $conn->prepare($queryInsertHN);
        $queryInsertHN->execute();

        // $return[] = $row;
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function onconfirm_damage($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $UsageCode = $_POST['UsageCode'];
    $remark_damage = $_POST['remark_damage'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $image64_damage = $_POST['image64_damage'];
    $input_itemcode_damage = $_POST['input_itemcode_damage'];


    $label_DocNo = create_Damage_DocNo($conn, $DepID, $Userid, "", $db);


    if($db == 1){
        $query = " SELECT
                        itemstock.RowID,
                        itemstock.UsageCode,
                        deproomdetailsub.ID
                    FROM
                        deproom
                    INNER JOIN
                        deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN
                        item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN
                        departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN
                        deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN
                        itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    WHERE
                        deproom.IsCancel = 0
                        AND (deproomdetailsub.IsStatus = 2 OR deproomdetailsub.IsStatus = 4)
                        AND deproom.DocNo = '$DocNo'
                        AND itemstock.UsageCode = '$UsageCode'
                        AND (itemstock.IsDamage IS NULL OR itemstock.IsDamage = '0')
                        AND (itemstock.IsClaim IS NULL OR itemstock.IsClaim = '0')
                    LIMIT 1 ";
    }else{
        $query = " SELECT TOP 1
                    itemstock.RowID ,
                    itemstock.UsageCode,
                    deproomdetailsub.ID
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    deproom.IsCancel = 0 
                    AND ( deproomdetailsub.IsStatus = 2  OR deproomdetailsub.IsStatus = 4  )
                    AND deproom.DocNo = '$DocNo'
                    AND itemstock.UsageCode = '$UsageCode' 
                    AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )
                    AND ( itemstock.IsClaim IS NULL  OR itemstock.IsClaim = '0') ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RowID = $row['RowID'];
        $ID = $row['ID'];

        $queryInsert = "INSERT INTO damagedetail 
        ( DocNo, ItemStockID, ItemCode, Qty, IsStatus, Remark,   IsCancel , deproomdetailsub_id , images  ) 
        VALUES ( '$label_DocNo' , '$RowID','$input_itemcode_damage', 1,0,'$remark_damage',0,$ID , '$image64_damage' )  ";

        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();

        $update1 = "UPDATE deproomdetailsub SET deproomdetailsub.IsDamage = 1  WHERE deproomdetailsub.ID = '$ID' ";
        $meQuery1 = $conn->prepare($update1);
        $meQuery1->execute();

        $update2 = "UPDATE itemstock SET itemstock.IsDamage = 1   WHERE itemstock.RowID = '$RowID' ";
        $meQuery2 = $conn->prepare($update2);
        $meQuery2->execute();


        $cnt_hn = 0;
        $query_hn = "SELECT hncode.DocNo
                        FROM
                            hncode
                            INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                        WHERE  hncode.DocNo_SS = '$DocNo' ";
        $meQuery_hn = $conn->prepare($query_hn);
        $meQuery_hn->execute();
        while ($row_hn = $meQuery_hn->fetch(PDO::FETCH_ASSOC)) {
            $_hn_DocNo = $row_hn['DocNo'];
        }
        $sql3 = "DELETE FROM hncode_detail   WHERE DocNo =  '$_hn_DocNo' AND ItemStockID = '$RowID'  ";
        $meQuery3 = $conn->prepare($sql3);
        $meQuery3->execute();
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function onconfirm_send($conn, $db)
{
    $return = array();
    $DocNo_pay = $_POST['DocNo_pay'];
    $Ref_departmentroomid = $_POST['Ref_departmentroomid'];
    $select_date_surgery = $_POST['select_date_surgery'];

    $select_date_surgery = explode("-", $select_date_surgery);
    $select_date_surgery = $select_date_surgery[2] . '-' . $select_date_surgery[1] . '-' . $select_date_surgery[0];

    $sql1 = " UPDATE deproom SET IsStatus = '3'  WHERE DocNo = '$DocNo_pay' ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();


    // ============================== ตัวแดง
    $queryUpdate = "UPDATE itemstock 
                        SET Isdeproom = 3
                        WHERE itemstock.RowID  IN (   SELECT
                                                            deproomdetailsub.ItemStockID 
                                                        FROM
                                                            deproomdetail
                                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                        WHERE deproomdetail.DocNo = '$DocNo_pay'   ) AND itemstock.IsDeproom = 1 ";
    $meQueryUpdate = $conn->prepare($queryUpdate);
    $meQueryUpdate->execute();


    $sql2 = "    DELETE FROM hncode_detail 
                        WHERE
                            hncode_detail.ItemStockID IN ( SELECT deproomdetailsub.ItemStockID FROM deproomdetail INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID WHERE deproomdetail.DocNo = '$DocNo_pay' AND deproomdetailsub.IsStatus = 1 ) 
                            
                            AND hncode_detail.DocNo = (SELECT hncode.DocNo FROM hncode WHERE DocNo_SS = '$DocNo_pay') ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();



    $sql3 = "UPDATE deproomdetailsub  SET IsStatus = 3   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                                    deproomdetailsub.ID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                WHERE deproomdetail.DocNo = '$DocNo_pay'   ) AND deproomdetailsub.IsStatus = 1 ";
    $meQuery3 = $conn->prepare($sql3);
    $meQuery3->execute();






    // ============================== ตัวแดง





    // ==============================ตัวเขียว Implant
    $queryUpdate2 = "UPDATE itemstock 
        SET Isdeproom = 10
        WHERE itemstock.RowID  IN (   SELECT
                                            deproomdetailsub.ItemStockID 
                                        FROM
                                            deproomdetail
                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                            INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                            INNER JOIN item ON item.itemcode = itemstock.ItemCode
                                        WHERE deproomdetail.DocNo = '$DocNo_pay' AND item.itemtypeID = 43  ) AND itemstock.IsDeproom = 2 ";
    $meQueryUpdate2 = $conn->prepare($queryUpdate2);
    $meQueryUpdate2->execute();

    $sql3 = "UPDATE deproomdetailsub  SET IsStatus = 10   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                    deproomdetailsub.ID 
                                                                                FROM
                                                                                    deproomdetail
                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                                                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                                                                                WHERE deproomdetail.DocNo = '$DocNo_pay' AND item.itemtypeID = 43    ) AND deproomdetailsub.IsStatus = 2 ";
    $meQuery3 = $conn->prepare($sql3);
    $meQuery3->execute();
    // ==============================ตัวเขียว


    // ==============================ตัวเขียว
    // =======================================================================================================================================
    $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID IN (   SELECT
                                                            deproomdetailsub.ItemStockID 
                                                        FROM
                                                            deproomdetail
                                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                            INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                            INNER JOIN item ON item.itemcode = itemstock.ItemCode
                                                        WHERE deproomdetail.DocNo = '$DocNo_pay' AND item.itemtypeID != 43 AND itemstock.IsDeproom = 2    ) 
                                    AND departmentroomid = '$Ref_departmentroomid' 
                                    AND  IsStatus = '1' ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    // =======================================================================================================================================


    $queryUpdate2 = "UPDATE itemstock 
                        SET Isdeproom = 4
                        WHERE itemstock.RowID  IN (   SELECT
                                                            deproomdetailsub.ItemStockID 
                                                        FROM
                                                            deproomdetail
                                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                            INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                            INNER JOIN item ON item.itemcode = itemstock.ItemCode
                                                        WHERE deproomdetail.DocNo = '$DocNo_pay' AND item.itemtypeID != 43    ) AND itemstock.IsDeproom = 2 ";
    $meQueryUpdate2 = $conn->prepare($queryUpdate2);
    $meQueryUpdate2->execute();

    $sql3 = "UPDATE deproomdetailsub  SET IsStatus = 4   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                                    deproomdetailsub.ID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                                                                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                                                                                                WHERE deproomdetail.DocNo = '$DocNo_pay' AND item.itemtypeID != 43    ) AND deproomdetailsub.IsStatus = 2 ";
    $meQuery3 = $conn->prepare($sql3);
    $meQuery3->execute();



    // ==============================ตัวเขียว


    // ==============================ชำรุด

    // =======================================================================================================================================
    $query = " DELETE FROM itemstock_transaction_detail  WHERE ItemStockID IN (   SELECT
                                                                                            deproomdetailsub.ItemStockID 
                                                                                        FROM
                                                                                            deproomdetail
                                                                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                            INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                                                        WHERE deproomdetail.DocNo = '$DocNo_pay' AND itemstock.IsDamage = 1   ) 
                AND departmentroomid = '$Ref_departmentroomid' 
                AND  IsStatus = '1' ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    // =======================================================================================================================================


    $queryUpdate5 = "UPDATE itemstock 
        SET IsDamage = 2
        WHERE itemstock.RowID  IN (   SELECT
                                            deproomdetailsub.ItemStockID 
                                        FROM
                                            deproomdetail
                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        WHERE deproomdetail.DocNo = '$DocNo_pay'   ) AND itemstock.IsDamage = 1 ";
    $meQueryUpdate5 = $conn->prepare($queryUpdate5);
    $meQueryUpdate5->execute();
    // ==============================




    $sql4 = "UPDATE deproomdetailsub  SET IsDamage = 2   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                                    deproomdetailsub.ID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                WHERE deproomdetail.DocNo = '$DocNo_pay'   ) AND deproomdetailsub.IsDamage = 1 ";




    $meQuery4 = $conn->prepare($sql4);
    $meQuery4->execute();

    // ==============================ชำรุด




    $cntX = 0;
    $sql = "SELECT COUNT(deproomdetailsub.ID) AS cnt 
                            FROM
                                deproomdetail
                                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                            WHERE
                                deproomdetail.DocNo = '$DocNo_pay' 
                                AND deproomdetailsub.IsStatus = 3 ";
    $meQuery = $conn->prepare($sql);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $cntX = $row['cnt'];
    }

    if ($cntX > 0) {
        $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 1   WHERE deproom.DocNo = '$DocNo_pay' ";
        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();
    } else {
        $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 0   WHERE deproom.DocNo = '$DocNo_pay' ";
        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();
    }



    $sql_suds = "   SELECT 
                        item.itemcode ,
                        COUNT(sudslog.ID) AS count_suds,
                        ( item.LimitUse + 1 ) AS LimitUse 
                    FROM
                        deproom
                        INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                        INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode
                        INNER JOIN sudslog ON itemstock.UsageCode = sudslog.UniCode 
                    WHERE
                        deproom.DocNo = '$DocNo_pay' 
                    AND item.itemtypeID = 42
                    GROUP BY
                        item.itemcode,
                        item.LimitUse ";

    $meQuery_suds = $conn->prepare($sql_suds);
    $meQuery_suds->execute();
    while ($row_suds = $meQuery_suds->fetch(PDO::FETCH_ASSOC)) {
        if ($row_suds['count_suds'] == $row_suds['LimitUse']) {
            $return[] = $row_suds;
        }
    }




    $cnt_hn = 0;
    $query_hn = "SELECT hncode_detail.ID
                    FROM
                        hncode
                        INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    WHERE  hncode.DocNo_SS = '$DocNo_pay' ";
    $meQuery_hn = $conn->prepare($query_hn);
    $meQuery_hn->execute();
    while ($row_hn = $meQuery_hn->fetch(PDO::FETCH_ASSOC)) {
        $cnt_hn++;
    }

    if ($cnt_hn > 0) {

        if($db == 1){
            $updateHN = "UPDATE hncode SET IsStatus = 1 , DocDate = NOW()  WHERE DocNo_SS = '$DocNo_pay' ";
        }else{
            $updateHN = "UPDATE hncode SET IsStatus = 1 , DocDate = GETDATE()  WHERE DocNo_SS = '$DocNo_pay' ";
        }
        $queryhn = $conn->prepare($updateHN);
        $queryhn->execute();
    }








    echo json_encode($return);
    unset($conn);
    die;
}

function oncheck_stock_back($conn, $db)
{
    $return = array();
    $input_stock_back = $_POST['input_stock_back'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $Ref_departmentroomid = $_POST['Ref_departmentroomid'];
    $select_date_surgery = $_POST['select_date_surgery'];
    $Userid = $_SESSION['Userid'];

    $select_date_surgery = explode("-", $select_date_surgery);
    $select_date_surgery = $select_date_surgery[2] . '-' . $select_date_surgery[1] . '-' . $select_date_surgery[0];
    
    $_RowID = "";

    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID,
                    item.itemtypeID
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE  itemstock.UsageCode = '$input_stock_back' AND itemstock.departmentroomid = '$Ref_departmentroomid' AND ( itemstock.Isdeproom = '2'  OR itemstock.Isdeproom = '4' OR itemstock.Isdeproom = '10'  )  ";

    // echo $query_1;
    // exit;
    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];
        $_itemtypeID =  $row_1['itemtypeID'];
        $count_itemstock++;

        if ($_itemtypeID = '42') {

            if($db == 1){
                $del = "DELETE FROM sudslog
                            WHERE ID = (
                                SELECT ID
                                FROM sudslog
                                WHERE ItemStockID = '$_RowID'
                                ORDER BY ID DESC
                                LIMIT 1 ) "; 
            }else{
                $del = "WITH CTE AS (
                    SELECT TOP (1) *
                    FROM sudslog
                    WHERE ItemStockID = '$_RowID'
                    ORDER BY ID DESC
                )
                DELETE FROM CTE "; 
            }

     
            $meQuery_del = $conn->prepare($del);
            $meQuery_del->execute();
        }


        if ($_Isdeproom == 2 || $_Isdeproom == 4 || $_Isdeproom == 10) {

            // ==============================
            $queryUpdate = "UPDATE itemstock 
                    SET Isdeproom = 1
                    WHERE
                    RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
            // ==============================

            $sql2 = "UPDATE deproomdetailsub  SET IsStatus = 1   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                                deproomdetailsub.ID 
                                                                                            FROM
                                                                                                deproomdetail
                                                                                                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                            WHERE deproomdetail.DocNo = '$DocNo_pay'  AND deproomdetailsub.ItemStockID = '$_RowID' ) ";
            $meQuery2 = $conn->prepare($sql2);
            $meQuery2->execute();

            $count_itemstock = 1;
        }
    }


    $cnt_hn = 0;
    $query_hn = "SELECT hncode.DocNo
                    FROM
                        hncode
                        INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    WHERE  hncode.DocNo_SS = '$DocNo_pay' ";
    $meQuery_hn = $conn->prepare($query_hn);
    $meQuery_hn->execute();
    while ($row_hn = $meQuery_hn->fetch(PDO::FETCH_ASSOC)) {
        $_hn_DocNo = $row_hn['DocNo'];
    }

    // if($cnt_hn == 0){
    //     $updateHN = "UPDATE hncode SET IsStatus = 0 WHERE DocNo_SS = '$DocNo_pay' ";
    //     $queryhn = $conn->prepare($updateHN);
    //     $queryhn->execute();
    // }

    if ($_RowID != "") {
        $sql3 = "DELETE FROM hncode_detail   WHERE DocNo =  '$_hn_DocNo' AND ItemStockID = '$_RowID'  ";
        $meQuery3 = $conn->prepare($sql3);
        $meQuery3->execute();
    }




    $cnt_tran = 0;
    $query_tran = "SELECT ItemStockID
                    FROM
                        itemstock_transaction_detail
                    WHERE  itemstock_transaction_detail.ItemStockID = '$_RowID' 
                    AND itemstock_transaction_detail.IsStatus = 1 ";
    $meQuery_tran = $conn->prepare($query_tran);
    $meQuery_tran->execute();
    while ($row_tran = $meQuery_tran->fetch(PDO::FETCH_ASSOC)) {
        $cnt_tran ++ ;
    }

    if($cnt_hn == 0){
        // =======================================================================================================================================
        $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
        VALUES
        ( $_RowID, '$_ItemCode','$select_date_surgery','$_departmentroomid', $Userid,1,1) ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        // =======================================================================================================================================
    }
   




    echo json_encode($count_itemstock);
    unset($conn);
    die;
}

function oncheck_use($conn, $db)
{
    $return = array();
    $input_use = $_POST['input_use'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $Ref_departmentroomid = $_POST['Ref_departmentroomid'];
    $deproom = $_SESSION['deproom'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    if($db == 1){
        $query_1 = "SELECT
                        itemstock.ItemCode,
                        itemstock.Isdeproom,
                        itemstock.departmentroomid,
                        itemstock.RowID,
                        $deproom,
                        item.itemtypeID,
                        item.LimitUse
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    WHERE
                        itemstock.UsageCode = '$input_use'
                        AND (itemstock.Isdeproom = '1' OR itemstock.Isdeproom = '3' OR itemstock.Isdeproom = '0')
                        AND itemstock.ExpireDate > CURDATE() ";
    }else{
        $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID,
                    $deproom,
                    item.itemtypeID,
                    item.LimitUse
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE  itemstock.UsageCode = '$input_use'   AND ( itemstock.Isdeproom = '1' OR itemstock.Isdeproom = '3' OR itemstock.Isdeproom = '0'  ) 
                AND itemstock.ExpireDate > GETDATE() ";
    }


    // echo $query_1;
    // exit;
    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];
        $_itemtypeID =  $row_1['itemtypeID'];
        $_LimitUse =  $row_1['LimitUse'];

        $count_itemstock++;


        if ($count_itemstock > 0) {

            if ($_itemtypeID == '42') {
                $check_sud = 0;

                if($db == 1){
                    $sql_sud = "SELECT 
                                    sudslog.UsedCount 
                                FROM
                                    sudslog
                                WHERE sudslog.UniCode = '$input_use' ORDER BY sudslog.ID DESC LIMIT 1 ";
                }else{
                    $sql_sud = "SELECT TOP 1
                                    sudslog.UsedCount 
                                FROM
                                    sudslog
                                WHERE sudslog.UniCode = '$input_use' ORDER BY sudslog.ID DESC ";
                }

          
                $meQuery_sud = $conn->prepare($sql_sud);
                $meQuery_sud->execute();
                while ($row_sud = $meQuery_sud->fetch(PDO::FETCH_ASSOC)) {
                    $_UsedCount = $row_sud['UsedCount'];
                    $check_sud++;
                }
                $_DocNoHN = "";

                if($db == 1){
                    $hncode = "SELECT hncode_detail.DocNo 
                                FROM
                                    hncode_detail 
                                WHERE
                                    hncode_detail.ItemStockID  = '$_RowID' 
                                ORDER BY
                                    hncode_detail.ID DESC LIMIT 1 ";
                }else{
                    $hncode = "SELECT TOP
                                    1 hncode_detail.DocNo 
                                FROM
                                    hncode_detail 
                                WHERE
                                    hncode_detail.ItemStockID  = '$_RowID' 
                                ORDER BY
                                    hncode_detail.ID DESC ";
                }

   
                $meQuery_hn = $conn->prepare($hncode);
                $meQuery_hn->execute();
                while ($row_hn = $meQuery_hn->fetch(PDO::FETCH_ASSOC)) {
                    $_DocNoHN = $row_hn['DocNo'];
                }

                if ($check_sud == 0) {
                    $insert_into = "INSERT INTO sudslog (UsedCount,UniCode,ItemStockID,CusCode,HNDocNo) VALUES (0,'$input_use',$_RowID,'$Userid','$_DocNoHN') ";



                    $meQuery_into = $conn->prepare($insert_into);
                    $meQuery_into->execute();
                } else {
                    if ($_UsedCount < $_LimitUse) {
                        $insert_into = "INSERT INTO sudslog (UsedCount,UniCode,ItemStockID,CusCode,HNDocNo) VALUES ( ($_UsedCount+1),'$input_use',$_RowID,'$Userid','$_DocNoHN') ";
                        $meQuery_into = $conn->prepare($insert_into);
                        $meQuery_into->execute();
                    } else {
                        $count_itemstock = 3;
                        echo json_encode($count_itemstock);
                        unset($conn);
                        die;
                    }
                }
            }
        }



        if ($_Isdeproom == 1 || $_Isdeproom == 3) {

            if ($_departmentroomid == $Ref_departmentroomid) {



                //check ยืมข้ามเอกสาร 
                $_DocNo = $DocNo_pay;
                $clear_dep = "  SELECT
                                    deproomdetailsub.IsStatus ,
                                    deproom.DocNo  ,
                                    deproomdetailsub.ID ,
                                    deproom.ServiceDate,
	                                hncode.DocNo AS hn_DocNo
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                    LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                                WHERE
                                    deproomdetailsub.ItemStockID = '$_RowID' 
                                    AND ( deproomdetailsub.IsStatus = 1 OR deproomdetailsub.IsStatus = 3) ";


                $meQuery_clear_dep = $conn->prepare($clear_dep);
                $meQuery_clear_dep->execute();
                while ($row_clear_dep = $meQuery_clear_dep->fetch(PDO::FETCH_ASSOC)) {
                    $_IdSub = $row_clear_dep['ID'];
                    $_DocNo = $row_clear_dep['DocNo'];
                    $_ServiceDate = $row_clear_dep['ServiceDate'];
                    $_hn_DocNo = $row_clear_dep['hn_DocNo'];

                    if ($_DocNo != $DocNo_pay) {
                        $sql2 = "UPDATE deproomdetailsub  SET dental_warehouse_id_borrow = 99 , deproomdetailsub.IsStatus = 99   WHERE deproomdetailsub.ID =  '$_IdSub' ";
                        $meQuery2 = $conn->prepare($sql2);
                        $meQuery2->execute();

                        $sql3 = "UPDATE hncode_detail  SET IsStatus = 99    WHERE DocNo =  '$_hn_DocNo' AND ItemStockID = '$_RowID'  ";
                        $meQuery3 = $conn->prepare($sql3);
                        $meQuery3->execute();

                        $cntX = 0;
                        $sql = "SELECT COUNT(deproomdetailsub.ID ) AS cnt 
                                                FROM
                                                    deproomdetail
                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                                WHERE
                                                    deproomdetail.DocNo = '$_DocNo' 
                                                    AND deproomdetailsub.IsStatus = 3 ";
                        $meQuery = $conn->prepare($sql);
                        $meQuery->execute();
                        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                            $cntX = $row['cnt'];
                        }

                        if ($cntX > 0) {
                            $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 1   WHERE deproom.DocNo = '$_DocNo' ";
                            $meQuery1 = $conn->prepare($sql1);
                            $meQuery1->execute();
                        } else {
                            $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 0   WHERE deproom.DocNo = '$_DocNo' ";
                            $meQuery1 = $conn->prepare($sql1);
                            $meQuery1->execute();
                        }
                    }
                }



                // ==============================
                $queryUpdate = "UPDATE itemstock 
                                SET Isdeproom = 2
                                WHERE
                                RowID = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================

                if ($_DocNo != $DocNo_pay) {

                    $count_id = 0;
                    $count_detail = "SELECT
                                        COUNT(deproomdetail.ID) AS count_id
                                    FROM
                                        deproom
                                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                    WHERE   deproomdetail.ItemCode = '$_ItemCode' 
                                            AND deproomdetail.DocNo = '$DocNo_pay' ";
                    $meQuery_count_detail = $conn->prepare($count_detail);
                    $meQuery_count_detail->execute();
                    while ($row_count_detail = $meQuery_count_detail->fetch(PDO::FETCH_ASSOC)) {
                        $count_id = $row_count_detail['count_id'];
                    }


                    if ($count_id == '0') {
                        $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                        VALUES
                            ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();


                        if($db == 1){
                            $query_2 = "SELECT
                            deproomdetail.ID,
                            -- deproom.Ref_departmentroomid AS departmentroomid,
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
                        }else{
                            $query_2 = "SELECT
                            deproomdetail.ID,
                            -- deproom.Ref_departmentroomid AS departmentroomid,
                            deproom.[procedure],
                            deproom.doctor,
                            deproom.hn_record_id,
                            deproomdetail.ItemCode,
                            deproomdetail.Qty ,
                            deproomdetail.PayDate ,
                            COUNT ( deproomdetailsub.ID )  AS cnt_sub
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
                            // $_departmentroomid = $row_2['departmentroomid'];
                            $_procedure = $row_2['procedure'];
                            $_hn_record_id = $row_2['hn_record_id'];
                            $_doctor = $row_2['doctor'];
                            $_Qty_detail = $row_2['Qty'];
                            $_Qty_detail_sub = $row_2['cnt_sub'];
                            // ==============================

                            if($db == 1){
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
                                    dental_warehouse_id_borrow,
                                    date_borrow
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$deproom',
                                    2, 
                                    1, 
                                    NOW(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure', 
                                    '$_departmentroomid',
                                    '$_ServiceDate'
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
                                    [procedure],
                                    dental_warehouse_id_borrow,
                                    date_borrow
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$deproom',
                                    2, 
                                    1, 
                                    GETDATE(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure', 
                                    '$_departmentroomid',
                                    '$_ServiceDate'
                                ) ";
                            }


                            $queryInsert1 = $conn->prepare($queryInsert1);
                            $queryInsert1->execute();

                            // ==============================

                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                    (
                                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay' ), 
                                    '$input_use',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";


                            $queryInsert2 = $conn->prepare($queryInsert2);
                            $queryInsert2->execute();
                            $count_itemstock++;




                            $count_itemstock = 2;
                            echo json_encode($count_itemstock);
                            unset($conn);
                            die;
                        }
                    } else {

                        $queryInsert = "UPDATE deproomdetail SET Qty = ( Qty + 1 )
                        WHERE deproomdetail.DocNo = '$DocNo_pay' AND ItemCode = '$_ItemCode'   ";
                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();



                        if($db == 1){
                            $query_2 = "SELECT
                            deproomdetail.ID,
                            deproom.`procedure`,
                            deproom.doctor,
                            deproom.hn_record_id,
                            deproomdetail.ItemCode,
                            deproomdetail.Qty ,
                            deproomdetail.PayDate ,
                            COUNT ( deproomdetailsub.ID )  AS cnt_sub
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
                            -- deproom.Ref_departmentroomid AS departmentroomid,
                            deproom.[procedure],
                            deproom.doctor,
                            deproom.hn_record_id,
                            deproomdetail.ItemCode,
                            deproomdetail.Qty ,
                            deproomdetail.PayDate ,
                            COUNT ( deproomdetailsub.ID )  AS cnt_sub
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
                            // $_departmentroomid = $row_2['departmentroomid'];
                            $_procedure = $row_2['procedure'];
                            $_hn_record_id = $row_2['hn_record_id'];
                            $_doctor = $row_2['doctor'];
                            $_Qty_detail = $row_2['Qty'];
                            $_Qty_detail_sub = $row_2['cnt_sub'];
                            // ==============================

                            if($db == 1){
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
                                    dental_warehouse_id_borrow,
                                    date_borrow
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$deproom',
                                    2, 
                                    1, 
                                    NOW(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure', 
                                    '$_departmentroomid',
                                    '$_ServiceDate'
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
                                    [procedure],
                                    dental_warehouse_id_borrow,
                                    date_borrow
                                )
                                VALUES
                                (
                                    '$_ID', 
                                    '$_RowID',
                                    '$deproom',
                                    2, 
                                    1, 
                                    GETDATE(), 
                                    '$_hn_record_id', 
                                    '$_doctor', 
                                    '$_procedure', 
                                    '$_departmentroomid',
                                    '$_ServiceDate'
                                ) ";
                            }

  
                            $queryInsert1 = $conn->prepare($queryInsert1);
                            $queryInsert1->execute();

                            // ==============================

                            $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                    (
                                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay' ), 
                                    '$input_use',
                                    '$_RowID',
                                    1, 
                                    1, 
                                    0, 
                                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                    ) ";


                            $queryInsert2 = $conn->prepare($queryInsert2);
                            $queryInsert2->execute();
                            $count_itemstock++;




                            $count_itemstock = 2;
                            echo json_encode($count_itemstock);
                            unset($conn);
                            die;
                        }
                    }
                } else {
                    $sql2 = "UPDATE deproomdetailsub  SET IsStatus = 2   WHERE deproomdetailsub.ID  IN (   SELECT
                                    deproomdetailsub.ID 
                                FROM
                                    deproomdetail
                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                WHERE deproomdetail.DocNo = '$DocNo_pay'  AND deproomdetailsub.ItemStockID = '$_RowID' ) ";
                    $meQuery2 = $conn->prepare($sql2);
                    $meQuery2->execute();

                    $count_itemstock = 1;



                    $cnt_hn = 0;
                    $query_hn = "SELECT hncode.DocNo
                                            FROM
                                                hncode
                                                INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                                            WHERE  hncode.DocNo_SS = '$DocNo_pay' AND hncode_detail.ItemStockID = '$_RowID'  ";
                    $meQuery_hn = $conn->prepare($query_hn);
                    $meQuery_hn->execute();
                    while ($row_hn = $meQuery_hn->fetch(PDO::FETCH_ASSOC)) {
                        $_hn_DocNo = $row_hn['DocNo'];
                        $cnt_hn++;
                    }

                    if ($cnt_hn == 0) {
                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay' ), 
                                '$input_use',
                                '$_RowID',
                                1, 
                                1, 
                                0, 
                                (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                ) ";


                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                    }
                }
            }

            if ($_departmentroomid != $Ref_departmentroomid) {


                // =======================================================================================================================================
                    $queryDE = "DELETE FROM itemstock_transaction_detail  
                                            WHERE ItemStockID = '$_RowID'
                                            AND departmentroomid = '$_departmentroomid' 
                                            AND  IsStatus = '1'  ";
                $meQueryDE = $conn->prepare($queryDE);
                $meQueryDE->execute();
                // =======================================================================================================================================
                
                // =======================================================================================================================================

                if($db == 1){
                    $queryIN = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode',NOW(),'$Ref_departmentroomid', $Userid,1,1) ";
                }else{
                    $queryIN = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                    VALUES
                    ( $_RowID, '$_ItemCode',GETDATE(),'$Ref_departmentroomid', $Userid,1,1) ";
                }


                $meQueryIN = $conn->prepare($queryIN);
                $meQueryIN->execute();
                // =======================================================================================================================================

                $clear_dep = "  SELECT
                                    deproomdetailsub.IsStatus ,
                                    deproom.DocNo  ,
                                    deproomdetailsub.ID ,
	                                hncode.DocNo AS hn_DocNo
                                FROM
                                    deproomdetail
                                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo
                                    LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                    LEFT JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
                                WHERE
                                    deproomdetailsub.ItemStockID = '$_RowID' 
                                    AND ( deproomdetailsub.IsStatus = 1 OR deproomdetailsub.IsStatus = 3) ";
                $meQuery_clear_dep = $conn->prepare($clear_dep);
                $meQuery_clear_dep->execute();
                while ($row_clear_dep = $meQuery_clear_dep->fetch(PDO::FETCH_ASSOC)) {
                    $_IdSub = $row_clear_dep['ID'];
                    $_hn_DocNo = $row_clear_dep['hn_DocNo'];
                    $_DocNo = $row_clear_dep['DocNo'];

                    $sql2 = "UPDATE deproomdetailsub  SET dental_warehouse_id_borrow = 99 , deproomdetailsub.IsStatus = 99   WHERE deproomdetailsub.ID =  '$_IdSub' ";
                    $meQuery2 = $conn->prepare($sql2);
                    $meQuery2->execute();

                    $sql3 = "UPDATE hncode_detail  SET IsStatus = 99    WHERE DocNo =  '$_hn_DocNo' AND ItemStockID = '$_RowID'  ";
                    $meQuery3 = $conn->prepare($sql3);
                    $meQuery3->execute();



                    $cntX = 0;
                    $sql = "SELECT COUNT(deproomdetailsub.ID) AS cnt 
                                            FROM
                                                deproomdetail
                                                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                                            WHERE
                                                deproomdetail.DocNo = '$_DocNo' 
                                                AND deproomdetailsub.IsStatus = 3 ";
                    $meQuery = $conn->prepare($sql);
                    $meQuery->execute();
                    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                        $cntX = $row['cnt'];
                    }

                    if ($cntX > 0) {
                        $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 1   WHERE deproom.DocNo = '$_DocNo' ";
                        $meQuery1 = $conn->prepare($sql1);
                        $meQuery1->execute();
                    } else {
                        $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 0   WHERE deproom.DocNo = '$_DocNo' ";
                        $meQuery1 = $conn->prepare($sql1);
                        $meQuery1->execute();
                    }
                }














                // ============================== ยืม
                $queryUpdate = "UPDATE itemstock 
                    SET Isdeproom = 2 , 
                        departmentroomid = '$Ref_departmentroomid'
                    WHERE
                    RowID = '$_RowID' ";
                $meQueryUpdate = $conn->prepare($queryUpdate);
                $meQueryUpdate->execute();
                // ==============================

                $count_id = 0;
                $count_detail = "SELECT
                                    COUNT(deproomdetail.ID) AS count_id
                                FROM
                                    deproom
                                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                                WHERE   deproomdetail.ItemCode = '$_ItemCode' 
                                        AND deproomdetail.DocNo = '$DocNo_pay' ";
                $meQuery_count_detail = $conn->prepare($count_detail);
                $meQuery_count_detail->execute();
                while ($row_count_detail = $meQuery_count_detail->fetch(PDO::FETCH_ASSOC)) {
                    $count_id = $row_count_detail['count_id'];
                }

                if ($count_id == '0') {
                    $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                    VALUES
                        ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";
                    $meQueryInsert = $conn->prepare($queryInsert);
                    $meQueryInsert->execute();


                    if($db == 1){
                        $query_2 = "SELECT
                        deproomdetail.ID,
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
                    }else{
                        $query_2 = "SELECT
                        deproomdetail.ID,
                        -- deproom.Ref_departmentroomid AS departmentroomid,
                        deproom.[procedure],
                        deproom.doctor,
                        deproom.hn_record_id,
                        deproomdetail.ItemCode,
                        deproomdetail.Qty ,
                        deproomdetail.PayDate ,
                        COUNT ( deproomdetailsub.ID )  AS cnt_sub
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
                        // $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];
                        $_Qty_detail = $row_2['Qty'];
                        $_Qty_detail_sub = $row_2['cnt_sub'];
                        // ==============================

                        if($db == 1){
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
                                dental_warehouse_id_borrow
                            )
                            VALUES
                            (
                                '$_ID', 
                                '$_RowID',
                                '$deproom',
                                2, 
                                1, 
                                NOW(), 
                                '$_hn_record_id', 
                                '$_doctor', 
                                '$_procedure', 
                                '$_departmentroomid'
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
                                [procedure],
                                dental_warehouse_id_borrow
                            )
                            VALUES
                            (
                                '$_ID', 
                                '$_RowID',
                                '$deproom',
                                2, 
                                1, 
                                GETDATE(), 
                                '$_hn_record_id', 
                                '$_doctor', 
                                '$_procedure', 
                                '$_departmentroomid'
                            ) ";
                        }


                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();

                        // ==============================

                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay' ), 
                                '$input_use',
                                '$_RowID',
                                1, 
                                1, 
                                0, 
                                (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                ) ";


                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;




                        $count_itemstock = 2;
                        echo json_encode($count_itemstock);
                        unset($conn);
                        die;
                    }
                } else {

                    $queryInsert = "UPDATE deproomdetail SET Qty = ( Qty + 1 )
                    WHERE deproomdetail.DocNo = '$DocNo_pay' AND ItemCode = '$_ItemCode'   ";
                    $meQueryInsert = $conn->prepare($queryInsert);
                    $meQueryInsert->execute();


                    if($db == 1){
                        $query_2 = "SELECT
                                        deproomdetail.ID,
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
                    }else{
                        $query_2 = "SELECT
                                    deproomdetail.ID,
                                    deproom.[procedure],
                                    deproom.doctor,
                                    deproom.hn_record_id,
                                    deproomdetail.ItemCode,
                                    deproomdetail.Qty ,
                                    deproomdetail.PayDate ,
                                    COUNT ( deproomdetailsub.ID )  AS cnt_sub
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
                        // $_departmentroomid = $row_2['departmentroomid'];
                        $_procedure = $row_2['procedure'];
                        $_hn_record_id = $row_2['hn_record_id'];
                        $_doctor = $row_2['doctor'];
                        $_Qty_detail = $row_2['Qty'];
                        $_Qty_detail_sub = $row_2['cnt_sub'];
                        // ==============================
                        if($db == 1){
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
                                dental_warehouse_id_borrow
                            )
                            VALUES
                            (
                                '$_ID', 
                                '$_RowID',
                                '$deproom',
                                2, 
                                1, 
                                NOW(), 
                                '$_hn_record_id', 
                                '$_doctor', 
                                '$_procedure', 
                                '$_departmentroomid'
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
                                [procedure],
                                dental_warehouse_id_borrow
                            )
                            VALUES
                            (
                                '$_ID', 
                                '$_RowID',
                                '$deproom',
                                2, 
                                1, 
                                GETDATE(), 
                                '$_hn_record_id', 
                                '$_doctor', 
                                '$_procedure', 
                                '$_departmentroomid'
                            ) ";
                        }


                        $queryInsert1 = $conn->prepare($queryInsert1);
                        $queryInsert1->execute();

                        // ==============================

                        $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                                (
                                (SELECT hncode.DocNo FROM hncode  WHERE hncode.DocNo_SS = '$DocNo_pay' ), 
                                '$input_use',
                                '$_RowID',
                                1, 
                                1, 
                                0, 
                                (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                                ) ";


                        $queryInsert2 = $conn->prepare($queryInsert2);
                        $queryInsert2->execute();
                        $count_itemstock++;




                        $count_itemstock = 2;
                        echo json_encode($count_itemstock);
                        unset($conn);
                        die;
                    }
                }
                // $sql2 = "UPDATE deproomdetailsub  SET IsStatus = 2   WHERE deproomdetailsub.ID  IN (   SELECT
                //                                                                                     deproomdetailsub.ID 
                //                                                                                 FROM
                //                                                                                     deproomdetail
                //                                                                                     INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID

                //                                                                                 WHERE deproomdetail.DocNo = '$DocNo_pay'  AND deproomdetailsub.ItemStockID = '$_RowID' ) ";

                // $meQuery2 = $conn->prepare($sql2);
                // $meQuery2->execute();

                $count_itemstock = 2;
            }
        } else if ($_Isdeproom == 0) {
            // เอาจากคลังทันตกรรม
            $queryUpdate = "UPDATE itemstock 
            SET Isdeproom = 2 , 
                 departmentroomid = '$Ref_departmentroomid'
            WHERE
            RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
            // ==============================

            $count_checkInsert = 0;
            $check_q  = "  SELECT
                                deproomdetail.ID 
                            FROM
                                deproomdetail 
                            WHERE
                                deproomdetail.ItemCode = '$_ItemCode' 
                                AND deproomdetail.DocNo = '$DocNo_pay' ";
            $meQuery_q = $conn->prepare($check_q);
            $meQuery_q->execute();
            while ($row_q = $meQuery_q->fetch(PDO::FETCH_ASSOC)) {
                $count_checkInsert++;
            }

            if ($count_checkInsert == 0) {
                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
                VALUES
                    ( '$DocNo_pay', '$_ItemCode', '1', 0, GETDATE(), 0, '$Userid',GETDATE())";

                $meQueryInsert = $conn->prepare($queryInsert);
                $meQueryInsert->execute();
            }



            if($db == 1){
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

                if($db == 1){
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
                        dental_warehouse_id_borrow
                    )
                    VALUES
                    (
                        '$_ID', 
                        '$_RowID',
                        '$_departmentroomid',
                        2, 
                        1, 
                        NOW(), 
                        '$_hn_record_id', 
                        '$_doctor', 
                        '$_procedure',
                        '35'
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
                        [procedure],
                        dental_warehouse_id_borrow
                    )
                    VALUES
                    (
                        '$_ID', 
                        '$_RowID',
                        '$_departmentroomid',
                        2, 
                        1, 
                        GETDATE(), 
                        '$_hn_record_id', 
                        '$_doctor', 
                        '$_procedure',
                        '35'
                    ) ";
                }

                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();

                // ==============================

                if($db == 1){
                    $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,LastSterileDetailID)  VALUES             
                    (
                    (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = '$_hn_record_id' AND hncode.`procedure` = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                    '$input_use',
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
                    '$input_use',
                    '$_RowID',
                    1, 
                    1, 
                    0, 
                    (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                    ) ";
                }



                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
                $count_itemstock++;




                $count_itemstock = 2;
                echo json_encode($count_itemstock);
                unset($conn);
                die;
            }



            $count_itemstock = 2;
        }
    }

    // $updateHN = "UPDATE hncode SET IsStatus = 1 WHERE DocNo_SS = '$DocNo_pay' ";
    // $queryhn = $conn->prepare($updateHN);
    // $queryhn->execute();


    echo json_encode($count_itemstock);
    unset($conn);
    die;
}

function show_detail_item_ByDocNo($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];

    $query = "SELECT
                    item.itemname ,
                    item.itemcode ,
                    itemstock.UsageCode ,
                    itemstock.Isdeproom  ,
	                deproomdetailsub.dental_warehouse_id_borrow  ,
	                itemstock.IsDamage,
                    itemtype.TyeName ,
                    deproomdetailsub.IsStatus 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID

                WHERE
                    deproom.DocNo = '$DocNo' 
                    AND deproom.IsCancel = 0 
                    AND deproomdetail.IsCancel = 0 ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $dental_warehouse_id_borrow = $row['dental_warehouse_id_borrow'];
        if ($dental_warehouse_id_borrow != '99') {
            $return[] = $row;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function updateStatus_DocNo($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $status_check = $_POST['status_check'];



    $sql1 = " UPDATE deproom SET IsStatus = '$status_check'  WHERE DocNo = '$DocNo' ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();


    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_item_surgery($conn, $db)
{
    $return = array();
    $select_date_surgery = $_POST['select_date_surgery'];
    $deproom = $_SESSION['deproom'];


    $select_date_surgery = explode("-", $select_date_surgery);
    $select_date_surgery = $select_date_surgery[2] . '-' . $select_date_surgery[1] . '-' . $select_date_surgery[0];


    if($db == 1){
        $query = " SELECT
                        deproom.DocNo,
                        deproom.IsStatus,
                        DATE_FORMAT(deproom.ServiceDate, '%d-%m-%Y') AS CreateDate,
                        DATE_FORMAT(deproom.ServiceDate, '%H:%i') AS CreateTime,
                        doctor.Doctor_Name,
                        deproom.hn_record_id,
                        IFNULL(`procedure`.Procedure_TH, '') AS Procedure_TH,
                        COUNT(deproomdetailsub.ID) AS cnt,
                        deproom.Ref_departmentroomid
                    FROM
                        deproom
                    INNER JOIN
                        deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN
                        deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN
                        doctor ON deproom.doctor = doctor.ID
                    LEFT JOIN
                        `procedure` ON deproom.`procedure` = `procedure`.ID
                    WHERE
                        DATE_FORMAT(deproom.ServiceDate, '%Y-%m-%d') = '$select_date_surgery'
                        AND deproom.Ref_departmentroomid = '$deproom'
                    GROUP BY
                        deproom.DocNo,
                        deproom.ServiceDate,
                        doctor.Doctor_Name,
                        deproom.hn_record_id,
                        `procedure`.Procedure_TH,
                        deproom.IsStatus,
                        deproom.Ref_departmentroomid ";
    }else{
        $query = " SELECT
                    deproom.DocNo,
                    deproom.IsStatus,
                    FORMAT(deproom.ServiceDate , 'dd-MM-yyyy') AS CreateDate,
                    FORMAT(deproom.ServiceDate , 'HH:mm') AS CreateTime,
                    doctor.Doctor_Name,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH ,
                    COUNT ( deproomdetailsub.ID ) AS cnt,
                    deproom.Ref_departmentroomid
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN doctor ON deproom.doctor = doctor.ID
                    INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID 
                WHERE  FORMAT(deproom.ServiceDate , 'yyyy-MM-dd') = '$select_date_surgery'
                AND deproom.Ref_departmentroomid = '$deproom'
                GROUP BY
                    deproom.DocNo,
                    deproom.ServiceDate,
                    doctor.Doctor_Name,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH,
                    deproom.IsStatus,
                    deproom.Ref_departmentroomid  ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['departmentroomname'][] = $row;
        $_DocNo = $row['DocNo'];
        $query_sub = " SELECT
                            item.itemname,
                            item.itemcode,
                            COUNT(deproomdetailsub.ID) AS cnt,
                            itemtype.TyeName
                        FROM
                            deproomdetail
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                            INNER JOIN item ON itemstock.ItemCode = item.itemcode
                            INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                        WHERE deproomdetail.DocNo = '$_DocNo' 
                        GROUP BY
                            item.itemname,
                            item.itemcode,
                            itemtype.TyeName ";

        $meQuery_sub = $conn->prepare($query_sub);
        $meQuery_sub->execute();
        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {
            $return[$_DocNo][] = $row_sub;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}
