<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';
require '../process/CreateDamage.php';
require '../process/Createsendsterile.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_item_sterile') {
        show_detail_item_sterile($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item_suds') {
        show_detail_item_suds($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_damage') {
        onconfirm_damage($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_create_sendsterile') {
        onconfirm_create_sendsterile($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_create_sendsterile_suds') {
        onconfirm_create_sendsterile_suds($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'cancelDamage') {
        cancelDamage($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_history') {
        show_detail_history($conn,$db);
    }
}

function onconfirm_create_sendsterile_suds($conn,$db)
{
    $return = array();
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $DocNo = $_POST['DocNo'];
    $round_sent_sterile = $_POST['round_sent_sterile'];

        // ==============================ชำรุด
        $queryUpdate5 = "UPDATE itemstock 
        SET IsDamage = 2
        WHERE itemstock.RowID  IN (   SELECT
                                            deproomdetailsub.ItemStockID 
                                        FROM
                                            deproomdetail
                                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        WHERE deproomdetail.DocNo = '$DocNo'   ) AND itemstock.IsDamage = 1 ";
    $meQueryUpdate5 = $conn->prepare($queryUpdate5);
    $meQueryUpdate5->execute();
    // ==============================




    $sql4 = "UPDATE deproomdetailsub  SET IsDamage = 2   WHERE deproomdetailsub.ID  IN (   SELECT
                                                                                                    deproomdetailsub.ID 
                                                                                                FROM
                                                                                                    deproomdetail
                                                                                                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                                                                WHERE deproomdetail.DocNo = '$DocNo'   ) AND deproomdetailsub.IsDamage = 1 ";




    $meQuery4 = $conn->prepare($sql4);
    $meQuery4->execute();

    // ==============================ชำรุด

    if($db == 1){
        $query = "SELECT
                    deproom.DocNo,
                    deproom.hn_record_id,
                    deproom.`procedure`,
                    deproom.doctor 
                FROM
                    itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN deproom ON deproom.DocNo = deproomdetail.DocNo 
                    INNER JOIN `procedure` ON `procedure`.ID = deproom.`procedure` 
                    INNER JOIN doctor ON doctor.ID = deproom.doctor 
                WHERE
                    itemstock.Isdeproom = 6 
                    AND deproomdetailsub.IsStatus = 7 
                    AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )
                    AND item.itemtypeID = 42 
                    AND deproom.DocNo = '$DocNo'
                GROUP BY
                    deproom.DocNo ,
                    deproom.hn_record_id,
                    deproom.`procedure`,
                    deproom.doctor   ";
    }else{
        $query = "SELECT
                    deproom.DocNo,
                    deproom.hn_record_id,
                    deproom.[procedure],
                    deproom.doctor 
                FROM
                    itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN deproom ON deproom.DocNo = deproomdetail.DocNo 
                    INNER JOIN [procedure] ON [procedure].ID = deproom.[procedure] 
                    INNER JOIN doctor ON doctor.ID = deproom.doctor 
                WHERE
                    itemstock.Isdeproom = 6 
                    AND deproomdetailsub.IsStatus = 7 
                    AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )
                    AND item.itemtypeID = 42 
                    AND deproom.DocNo = '$DocNo'
                GROUP BY
                    deproom.DocNo ,
                    deproom.hn_record_id,
                    deproom.[procedure],
                    deproom.doctor   ";
    }



                $meQuery = $conn->prepare($query);
                $meQuery->execute();
                while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                    $_hn_record_id = $row['hn_record_id'];
                    $_procedure = $row['procedure'];
                    $_doctor = $row['doctor'];
                    $_DocNo = $row['DocNo'];

                    $label_DocNo = create_sendsterile_DocNo($conn, "", $DepID, $Userid, 0, "", 0, 0, 0,$round_sent_sterile,$db);

                    $update2  ="UPDATE sendsterile SET hncode = '$_hn_record_id' , Doctor_ID  = '$_doctor' , Procedure_ID = '$_procedure' WHERE DocNo = '$label_DocNo' ";
                    
                    $meQueryupdate2 = $conn->prepare($update2);
                    $meQueryupdate2->execute();

                    $updateSS  ="UPDATE deproom SET RefDocNo = '$label_DocNo' , IsStatus = 4  WHERE DocNo = '$_DocNo' ";
                    $meQueryupdateSS = $conn->prepare($updateSS);
                    $meQueryupdateSS->execute();


                        $queryInsert = "INSERT INTO sendsteriledetail 
                                        ( SendSterileDocNo, 
                                        Qty, 
                                        Remark, 
                                        UsageCode, 
                                        IsSterile, 
                                        IsStatus, 
                                        SSdetail_IsWeb,
                                        RefDocNo 
                                        ) 
                                        SELECT 
                                        '$label_DocNo' ,
                                        1,
                                        '',
                                        itemstock.UsageCode,
                                        0,
                                        0,
                                        -5,
                                        '$label_DocNo' 
                                        FROM itemstock 
                                            INNER JOIN item ON itemstock.ItemCode = item.itemcode
                                            INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                                            INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                        WHERE
                                            itemstock.Isdeproom = 6 
                                        AND deproomdetailsub.IsStatus = 7 
                                        AND item.itemtypeID = 42 
                                        AND deproomdetail.DocNo = '$_DocNo'   ";


                                    $meQueryInsert = $conn->prepare($queryInsert);
                                    $meQueryInsert->execute();


                                    $query_sub = "SELECT
                                                        item.itemname,
                                                        item.itemcode,
                                                        itemstock.UsageCode,
                                                        itemstock.IsDamage,
                                                        itemstock.RowID,
                                                        itemstock.departmentroomid
                                                    FROM
                                                        itemstock
                                                        INNER JOIN item ON itemstock.ItemCode = item.itemcode
                                                        INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                                                        INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                                                    WHERE
                                                        itemstock.Isdeproom = 6 
                                                        AND deproomdetailsub.IsStatus = 7 
                                                        AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )
                                                        AND item.itemtypeID = 42 
                                                        AND deproomdetail.DocNo = '$_DocNo' ";
                                        $meQuery_sub = $conn->prepare($query_sub);
                                        $meQuery_sub->execute();
                                        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {

                                            $_UsageCode = $row_sub['UsageCode'];
                                            $_RowID = $row_sub['RowID'];
                                            $_itemcode = $row_sub['itemcode'];
                                            $_departmentroomid = $row_sub['departmentroomid'];


                                            $update3  = "   UPDATE itemstock
                                            SET Isdeproom = 7
                                            WHERE Isdeproom = 6 AND UsageCode = '$_UsageCode'  ";

                                            $meQueryupdate3 = $conn->prepare($update3);
                                            $meQueryupdate3->execute();


                                            // =======================================================================================================================================
                                            $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                                            VALUES
                                            ( $_RowID, '$_itemcode',GETDATE(),'$_departmentroomid', $Userid,7,1) ";
                                            $meQuery = $conn->prepare($query);
                                            $meQuery->execute();
                                            // =======================================================================================================================================
                                                 
                                        }



                }

    // $label_DocNo = create_sendsterile_DocNo($conn, "", $DepID, $Userid, 0, "", 0, 0, 0);

    // $queryInsert = "INSERT INTO sendsteriledetail 
    //                 ( SendSterileDocNo, 
    //                 ItemStockID, 
    //                 Qty, 
    //                 Remark, 
    //                 UsageCode, 
    //                 IsSterile, 
    //                 IsStatus, 
    //                 SSdetail_IsWeb,
    //                 RefDocNo 
    //                 ) 
    //                 SELECT 
    //                 '$label_DocNo' ,
    //                 itemstock.RowID,
    //                 1,
    //                 itemstock.GenerateDescription,
    //                 itemstock.UsageCode,
    //                 0,
    //                 0,
    //                 -5,
    //                 '$label_DocNo' 
    //                 FROM itemstock 
    //                 INNER JOIN item ON itemstock.ItemCode = item.itemcode
    //                 WHERE 
    //                     itemstock.Isdeproom = 6
    //                 AND item.itemtypeID = 42
    //                 ORDER BY
    //                 itemstock.ItemCode ,
    //                 itemstock.UsageCode ASC  ";


    //             $meQueryInsert = $conn->prepare($queryInsert);
    //             $meQueryInsert->execute();


    // $update2  = "UPDATE itemstock
    //             SET Isdeproom = 7
    //             WHERE Isdeproom = 6 
    //             AND ItemCode IN ( SELECT itemcode FROM item WHERE itemtypeID = 44)  ";

    // $meQueryupdate = $conn->prepare($update2);
    // $meQueryupdate->execute();


    // echo $label_DocNo;



    unset($conn);
    die;
}

function onconfirm_create_sendsterile($conn,$db)
{
    $return = array();
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    $round_sent_sterile = $_POST['round_sent_sterile'];


    
    $label_DocNo = create_sendsterile_DocNo($conn, "", $DepID, $Userid, 0, "", 0, 0, 0, $round_sent_sterile,$db);

    $queryInsert = "INSERT INTO sendsteriledetail 
                    ( SendSterileDocNo, 
                    Qty, 
                    Remark, 
                    UsageCode, 
                    IsSterile, 
                    IsStatus, 
                    SSdetail_IsWeb,
                    RefDocNo 
                    ) 
                    SELECT 
                    '$label_DocNo' ,
                    1,
                    '',
                    itemstock.UsageCode,
                    0,
                    0,
                    -5,
                    '$label_DocNo' 
                  FROM
                        itemstock
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    WHERE
                        itemstock.Isdeproom = 6 
                        AND item.itemtypeID = 44  ";


                $meQueryInsert = $conn->prepare($queryInsert);
                $meQueryInsert->execute();

        // =======================================================================================================================================

        if($db == 1){
            $queryT = "INSERT INTO itemstock_transaction_detail (ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty)
                        SELECT
                            itemstock.RowID,
                            itemstock.ItemCode,
                            NOW(),
                            itemstock.departmentroomid,
                            $Userid,
                            7,
                            1
                        FROM
                            itemstock
                        INNER JOIN
                            item ON itemstock.ItemCode = item.itemcode
                        WHERE
                            itemstock.Isdeproom = 6
                            AND item.itemtypeID = 44
                        GROUP BY
                            itemstock.ItemCode,
                            itemstock.RowID,
                            itemstock.departmentroomid ";
        }else{
            $queryT = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                            SELECT 
                            itemstock.RowID,
                            itemstock.ItemCode,
                            GETDATE(),
                            itemstock.departmentroomid,
                            $Userid,
                            7,
                            1
                        FROM
                                itemstock
                                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                            WHERE
                                itemstock.Isdeproom = 6 
                                AND item.itemtypeID = 44 
                        GROUP BY
                            itemstock.ItemCode,
                            itemstock.RowID,
                            itemstock.departmentroomid  ";
        }


        $meQueryT = $conn->prepare($queryT);
        $meQueryT->execute();
        // =======================================================================================================================================


    $update2  = "UPDATE itemstock
                SET Isdeproom = 7
                WHERE Isdeproom = 6 
                AND ItemCode IN ( SELECT itemcode FROM item WHERE itemtypeID = 44) 	AND (itemstock.IsCross IS NULL OR itemstock.IsCross = 0 )
	                                                                                AND (itemstock.IsClaim IS NULL OR itemstock.IsClaim = 0 ) ";

    $update3  = "UPDATE itemstock
    SET Isdeproom = 9 , itemstock.IsCross = NULL ,  itemstock.IsClaim = NULL
    WHERE Isdeproom = 6 
    AND ItemCode IN ( SELECT itemcode FROM item WHERE itemtypeID = 44) AND ( itemstock.IsCross = 1  OR  itemstock.IsClaim = 2 )  ";

    $meQueryupdate = $conn->prepare($update2);
    $meQueryupdate->execute();
    $meQueryupdate3 = $conn->prepare($update3);
    $meQueryupdate3->execute();

    echo $label_DocNo;



    unset($conn);
    die;
}

function cancelDamage($conn,$db)
{
    $return = array();
    $itemcode = $_POST['itemcode'];
    $UsageCode = $_POST['UsageCode'];

    

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
                        AND deproomdetailsub.IsStatus = 7
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
                    AND deproomdetailsub.IsStatus = 7
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

        // $return[] = $row;
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function onconfirm_damage($conn,$db)
{
    $return = array();
    $input_itemcode_damage = $_POST['input_itemcode_damage'];
    $UsageCode = $_POST['UsageCode'];
    $remark_damage = $_POST['remark_damage'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $image64_damage = $_POST['image64_damage'];

    
    $label_DocNo = create_Damage_DocNo($conn, $DepID, $Userid, "");

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
                        AND deproomdetailsub.IsStatus = 7
                        AND itemstock.UsageCode = '$UsageCode'
                        AND (itemstock.IsDamage IS NULL OR itemstock.IsDamage = '0')
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
                    AND deproomdetailsub.IsStatus = 7 
                    AND itemstock.UsageCode = '$UsageCode' 
                     AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )  ";
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

        // $return[] = $row;
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function show_detail_history($conn,$db){
    $return = array();

    $select_date1 = $_POST['select_date1'];
    $select_date2 = $_POST['select_date2'];

    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];

    $select_date2 = explode("-", $select_date2);
    $select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];


    if($db == 1){
        $query = "SELECT
                        sendsterile.DocNo,
                        COALESCE(doctor.Doctor_Name, '') AS Doctor_Name,
                        COALESCE(`procedure`.Procedure_TH, '') AS Procedure_TH,
                        COALESCE(sendsterile.hncode, '') AS hncode,
                        DATE_FORMAT(sendsterile.DocDate, '%d/%m/%Y') AS doc_date,
                        DATE_FORMAT(sendsterile.DocDate, '%H:%i:%s') AS doc_time,
                        sendsterile.Round
                    FROM
                        sendsterile
                    LEFT JOIN
                        doctor ON sendsterile.Doctor_ID = doctor.ID
                    LEFT JOIN
                        `procedure` ON sendsterile.Procedure_ID = `procedure`.ID
                    WHERE
                        DATE(sendsterile.DocDate) BETWEEN '$select_date1' AND '$select_date2' ";
    }else{
        $query = " SELECT
                    sendsterile.DocNo,
                    ISNULL(doctor.Doctor_Name,'') AS Doctor_Name,
                    ISNULL([procedure].Procedure_TH,'') AS Procedure_TH,
                    ISNULL(sendsterile.hncode,'') AS hncode,
                    FORMAT(sendsterile.DocDate , 'dd/MM/yyyy') AS doc_date,
                    FORMAT(sendsterile.DocDate , 'HH:mm:ss') AS doc_time,
                    sendsterile.Round 
                FROM
                    sendsterile
                
                    LEFT JOIN doctor ON sendsterile.Doctor_ID = doctor.ID
                    LEFT JOIN [procedure] ON sendsterile.Procedure_ID = [procedure].ID
                WHERE  CONVERT(DATE,sendsterile.DocDate) BETWEEN  '$select_date1' AND  '$select_date2'  ";
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

function show_detail_item_sterile($conn,$db)
{
    $return = array();

    if($db == 1){
        $query = " SELECT
                        item.itemname,
                        item.itemcode,
                        itemstock.UsageCode,
                        CASE
                            WHEN itemstock.ExpireDate < CURDATE() THEN 'ex'
                            ELSE 'no_ex'
                        END AS check_exp,
                        itemstock.isClaim
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN
                        deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                    WHERE
                        itemstock.Isdeproom = 6
                        AND item.itemtypeID = 44
                    ORDER BY
                        item.itemname ASC ";
    }else{
        $query = "SELECT
                item.itemname,
                item.itemcode,
                itemstock.UsageCode,
                CASE
                        WHEN itemstock.ExpireDate < GETDATE() THEN 'ex'
                        ELSE 'no_ex'
                END AS check_exp,
	            itemstock.isClaim
            FROM
                itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID 
            WHERE
                itemstock.Isdeproom = 6 
                AND item.itemtypeID = 44
            ORDER BY item.itemname ASC   ";
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

function show_detail_item_suds($conn,$db)
{
    $return = array();
    $select_date1 = $_POST['select_date1'];
    $select_date2 = $_POST['select_date2'];

    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];

    $select_date2 = explode("-", $select_date2);
    $select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];

    if($db == 1){
        $query = "SELECT
                        deproom.DocNo,
                        deproom.hn_record_id,
                        `procedure`.Procedure_TH,
                        doctor.Doctor_Name,
                        deproom.RefDocNo,
                        sendsterile.Round
                    FROM
                        itemstock
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN
                        deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN
                        deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN
                        deproom ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN
                        `procedure` ON `procedure`.ID = deproom.`procedure`
                    INNER JOIN
                        doctor ON doctor.ID = deproom.doctor
                    LEFT JOIN
                        sendsterile ON sendsterile.DocNo = deproom.RefDocNo
                    WHERE
                        ((itemstock.Isdeproom = 6 AND deproomdetailsub.IsStatus = 7) OR deproom.IsStatus = 4)
                        AND item.itemtypeID = 42
                        AND DATE(deproom.CreateDate) BETWEEN '$select_date1' AND '$select_date2'
                    GROUP BY
                        deproom.DocNo,
                        deproom.hn_record_id,
                        `procedure`.Procedure_TH,
                        doctor.Doctor_Name,
                        deproom.RefDocNo,
                        sendsterile.Round ";
    }else{
        $query = "SELECT
                    deproom.DocNo,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH,
                    doctor.Doctor_Name,
                    deproom.RefDocNo,
                    sendsterile.Round
                FROM
                    itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN deproom ON deproom.DocNo = deproomdetail.DocNo 
                    INNER JOIN [procedure] ON [procedure].ID = deproom.[procedure] 
                    INNER JOIN doctor ON doctor.ID = deproom.doctor
                    LEFT JOIN sendsterile ON sendsterile.DocNo = deproom.RefDocNo
                WHERE
                    (  ( itemstock.Isdeproom = 6 AND deproomdetailsub.IsStatus = 7 ) OR deproom.IsStatus = 4 )
                    AND item.itemtypeID = 42 
                    AND CONVERT(DATE,deproom.CreateDate) BETWEEN  '$select_date1' AND  '$select_date2'
                GROUP BY
                    deproom.DocNo ,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH,
                    doctor.Doctor_Name,
                    deproom.RefDocNo,
                    sendsterile.Round ";
    }


    // echo $query;
    // exit;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['deproom'][] = $row;

        $_DocNo = $row['DocNo'];

        $query_sub = "SELECT
                            item.itemname,
                            item.itemcode,
                            itemstock.UsageCode,
                            itemstock.IsDamage
                        FROM
                            itemstock
                            INNER JOIN item ON itemstock.ItemCode = item.itemcode
                            INNER JOIN deproomdetailsub ON itemstock.RowID = deproomdetailsub.ItemStockID
                            INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                        WHERE
                            deproomdetailsub.IsStatus = 7 
                            AND item.itemtypeID = 42 
                            AND deproomdetail.DocNo = '$_DocNo' ";
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