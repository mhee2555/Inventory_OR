<?php
session_start();
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_request') {
        show_detail_request($conn);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_request') {
        onconfirm_request($conn);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_request_byDocNo') {
        show_detail_request_byDocNo($conn);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_cancel_request') {
        onconfirm_cancel_request($conn);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_sned_request') {
        onconfirm_sned_request($conn);
    } else if ($_POST['FUNC_NAME'] == 'oncheck_use_usagecode') {
        oncheck_use_usagecode($conn);
    }  else if ($_POST['FUNC_NAME'] == 'show_detail_use_byDeproom') {
        show_detail_use_byDeproom($conn);
    }  else if ($_POST['FUNC_NAME'] == 'oncheck_return_usagecode') {
        oncheck_return_usagecode($conn);
    }  else if ($_POST['FUNC_NAME'] == 'onconfirm_use') {
        onconfirm_use($conn);
    }  else if ($_POST['FUNC_NAME'] == 'show_detail_useSuccess_byDeproom') {
        show_detail_useSuccess_byDeproom($conn);
    }  else if ($_POST['FUNC_NAME'] == 'show_detail_history_request') {
        show_detail_history_request($conn);
    }
}

function show_detail_history_request($conn)
{
    $return = array();
    $select_date_history = $_POST['select_date_history'];
    $deproom = $_SESSION['deproom'];

    $select_date_history = explode("-", $select_date_history);
    $select_date_history = $select_date_history[2] . '-' . $select_date_history[1] . '-' . $select_date_history[0];

    $query = " SELECT
                    deproom.hn_record_id,
                    doctor.Doctor_Name,
                    doctor.ID AS doctor_ID ,
                    [procedure].ID AS procedure_ID ,
                    [procedure].Procedure_TH,
	                deproom.DocNo 
                FROM
                    deproom
                    INNER JOIN doctor ON deproom.doctor = doctor.ID
                    INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID 
                WHERE
                    deproom.IsStatus = 0
                    AND CONVERT(DATE,deproom.CreateDate) =  '$select_date_history' 
                    AND deproom.departmentroomid = '$deproom' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function onconfirm_use($conn)
{
    $return = array();
    $array_usagecode = $_POST['array_usagecode'];
    $deproom = $_SESSION['deproom'];



    foreach ($array_usagecode as $key => $value) {

        // ==============================
        $queryUpdate = "UPDATE itemstock 
        SET Isdeproom = '2' 
        WHERE
        UsageCode = '$value' ";
        $meQueryUpdate = $conn->prepare($queryUpdate);
        $meQueryUpdate->execute();
        // ==============================

       //  ==============================
            $queryUpdate2 = "UPDATE deproomdetailsub 
            SET IsStatus = 2 
            WHERE
            ID = (SELECT deproomdetailsub.ID FROM deproomdetailsub INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID           
                  AND itemstock.departmentroomid = '$deproom' 
                  AND deproomdetailsub.dental_warehouse_id = '$deproom' 
                  AND itemstock.UsageCode = '$value' 
                  AND itemstock.Isdeproom = '2' ) ";

                //   echo $queryUpdate2;
            $meQueryUpdate2 = $conn->prepare($queryUpdate2);
            $meQueryUpdate2->execute();
      //  ==============================



    }


    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_useSuccess_byDeproom($conn)
{
    $return = array();
    $deproom = $_SESSION['deproom'];
    $select_date_item_use_success = $_POST['select_date_item_use_success'];


    $select_date_item_use_success = explode("-", $select_date_item_use_success);
    $select_date_item_use_success = $select_date_item_use_success[2] . '-' . $select_date_item_use_success[1] . '-' . $select_date_item_use_success[0];

    
    $query = "SELECT
                    item.itemname ,
                    COUNT ( itemstock.ItemCode ) AS count_qty 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE
                    itemstock.Isdeproom = '1' 
                    AND itemstock.departmentroomid = '$deproom ' 
                    AND deproom.departmentroomid = '$deproom ' 
                    AND CONVERT(DATE,deproom.CreateDate) =  '$select_date_item_use_success' 
                GROUP BY
                    item.itemname ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_use_byDeproom($conn)
{
    $return = array();
    $deproom = $_SESSION['deproom'];

    $query = "SELECT
                    deproomdetailsub.ItemStockID,
                    itemstock.UsageCode,
                    item.itemname ,
                    COUNT ( itemstock.ItemCode ) AS count_qty
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE
                    itemstock.Isdeproom = '-2'
                    AND itemstock.departmentroomid = '$deproom' 
                    AND deproom.departmentroomid = '$deproom' 
                GROUP BY
                    deproomdetailsub.ItemStockID,
                    itemstock.UsageCode,
                    item.itemname ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function oncheck_return_usagecode($conn)
{
    $return = array();
    $input_stock_back = $_POST['input_stock_back'];
    $Userid = $_SESSION['Userid'];
    $deproom = $_SESSION['deproom'];

    $query_1 = "SELECT
                    deproomdetailsub.ItemStockID ,
                    deproomdetailsub.ID ,
                    itemstock.UsageCode ,
                    itemstock.departmentroomid 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    itemstock.Isdeproom = '-2'
                    AND itemstock.UsageCode = '$input_stock_back'
                    AND itemstock.departmentroomid = '$deproom' ";

    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ID = $row_1['ID'];
        $_ItemStockID = $row_1['ItemStockID'];
        $_UsageCode =  $row_1['UsageCode'];
        $_departmentroomid =  $row_1['departmentroomid'];

        $count_itemstock++;

  


        // ==============================
        $queryUpdate = "UPDATE itemstock 
        SET Isdeproom = '1' 
        WHERE
        RowID = '$_ItemStockID' ";
        $meQueryUpdate = $conn->prepare($queryUpdate);
        $meQueryUpdate->execute();
        // ==============================

        // ==============================
        // $queryUpdate2 = "UPDATE deproomdetailsub 
        // SET IsStatus = 2 
        // WHERE
        // ID = '$_ID' ";
        // $meQueryUpdate2 = $conn->prepare($queryUpdate2);
        // $meQueryUpdate2->execute();
        // ==============================
    }

    if($count_itemstock == 0){
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    }else{
        echo json_encode($return);
        unset($conn);
        die;
    }

}

function oncheck_use_usagecode($conn)
{
    $return = array();
    $input_use = $_POST['input_use'];
    $Userid = $_SESSION['Userid'];
    $deproom = $_SESSION['deproom'];

    $query_1 = "SELECT
                    deproomdetailsub.ItemStockID ,
                    deproomdetailsub.ID ,
                    itemstock.UsageCode ,
                    itemstock.departmentroomid 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    itemstock.Isdeproom = 1
                    AND itemstock.UsageCode = '$input_use'
                    AND itemstock.departmentroomid = '$deproom' ";

    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ID = $row_1['ID'];
        $_ItemStockID = $row_1['ItemStockID'];
        $_UsageCode =  $row_1['UsageCode'];
        $_departmentroomid =  $row_1['departmentroomid'];

        $count_itemstock++;

  


        // ==============================
        $queryUpdate = "UPDATE itemstock 
        SET Isdeproom = '-2' 
        WHERE
        RowID = '$_ItemStockID' ";
        $meQueryUpdate = $conn->prepare($queryUpdate);
        $meQueryUpdate->execute();
        // ==============================

        // ==============================
        // $queryUpdate2 = "UPDATE deproomdetailsub 
        // SET IsStatus = 2 
        // WHERE
        // ID = '$_ID' ";
        // $meQueryUpdate2 = $conn->prepare($queryUpdate2);
        // $meQueryUpdate2->execute();
        // ==============================
    }

    if($count_itemstock == 0){
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    }else{
        echo json_encode($return);
        unset($conn);
        die;
    }

}

function show_detail_request($conn)
{
    $return = array();
    $input_Search = $_POST['input_Search'];

    $query = "SELECT
                item.itemcode,
                item.itemname AS Item_name 
            FROM
                item
            INNER JOIN itemstock ON item.itemcode = itemstock.ItemCode 
            WHERE
                item.IsNormal = 1 
                AND item.IsCancel = 0 
                AND ( item.itemname LIKE '%$input_Search%' OR item.itemcode LIKE '%$input_Search%' OR itemstock.UsageCode LIKE '%$input_Search%' ) 

            GROUP BY
                item.ItemCode,
                item.itemname ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}




function onconfirm_request($conn)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $array_itemcode = $_POST['array_itemcode'];
    $array_qty = $_POST['array_qty'];

    $select_deproom_request = $_POST['select_deproom_request'];
    $input_hn_request = $_POST['input_hn_request'];
    $select_doctor_request = $_POST['select_doctor_request'];
    $select_procedure_request = $_POST['select_procedure_request'];

    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];




    $count = 0;
    if ($txt_docno_request == "") {
        $remark = "สร้างจาก ขอเบิก ";
        $txt_docno_request = createDocNo($conn, $Userid , $DepID , $select_deproom_request , $remark ,0 , 0 , 0 , 0, $select_procedure_request, $select_doctor_request, $input_hn_request);


        createhncodeDocNo($conn, $Userid, $DepID, $input_hn_request, $select_deproom_request, 1, $select_procedure_request, $select_doctor_request, 'สร้างจากเมนูห้องตรวจใช้แล้ว ของทันตกรรม' , $txt_docno_request);
    }

    foreach ($array_itemcode as $key => $value) {

        $_cntcheck = 0;
        $queryCheck = "SELECT COUNT
                            ( deproomdetail.ItemCode ) AS cntcheck 
                        FROM
                            deproomdetail 
                        WHERE
                            deproomdetail.DocNo = '$txt_docno_request' 
                            AND deproomdetail.ItemCode = '$value' ";


        $meQuery = $conn->prepare($queryCheck);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_cntcheck = $row['cntcheck'];
        }

        if ($_cntcheck > 0) {
            $queryUpdate = "UPDATE deproomdetail 
                            SET Qty = (Qty +  $array_qty[$key]) 
                            WHERE
                                DocNo = '$txt_docno_request' 
                                AND ItemCode = '$value'  ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        } else {
            $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime )
            VALUES
                ( '$txt_docno_request', '$value', '$array_qty[$key]', 0, GETDATE(), 0, '$Userid',GETDATE())";


            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
        }


        $count++;
    }


    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}

function show_detail_request_byDocNo($conn)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $txt_docno_request = $_POST['txt_docno_request'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM ( deproomdetail.Qty ) AS cnt 
            FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
            WHERE
                deproom.DocNo = '$txt_docno_request' 
                AND deproom.IsCancel = 0 
                AND deproomdetail.IsCancel = 0 
            GROUP BY
                item.itemname,
                item.itemcode,
                deproomdetail.ID ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function onconfirm_cancel_request($conn)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];

    $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = GETDATE() , Remark='ยกเลิกเอกสาร' WHERE DocNo = '$txt_docno_request' ";
    $sql2 = " DELETE FROM deproomdetail WHERE DocNo = '$txt_docno_request' ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}

function onconfirm_sned_request($conn)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];

    $sql1 = " UPDATE deproom SET IsStatus = 1 WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    $sql2 = " UPDATE deproomdetail SET IsStatus = 3 WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}
 
