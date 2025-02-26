<?php
session_start();
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_bydeproom_pay') {
        show_detail_bydeproom_pay($conn);
    }else if ($_POST['FUNC_NAME'] == 'onselect_show_detail_byDocNo_pay') {
        onselect_show_detail_byDocNo_pay($conn);
    }else if ($_POST['FUNC_NAME'] == 'oncheck_pay') {
        oncheck_pay($conn);
    }else if ($_POST['FUNC_NAME'] == 'oncheck_Returnpay') {
        oncheck_Returnpay($conn);
    }
}



function oncheck_pay($conn)
{
    $return = array();
    $input_pay = $_POST['input_pay'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    itemstock
                WHERE  itemstock.UsageCode = '$input_pay' AND itemstock.departmentroomid = '35' AND itemstock.Isdeproom = '0' ";

    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];

        $count_itemstock++;

        if($_Isdeproom == 0){
            $count_itemstock = 0;

            $query_2 = "SELECT
                            deproomdetail.ID,
                            deproom.departmentroomid,
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
                            deproom.departmentroomid,
                            deproom.[procedure],
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

                if($_Qty_detail == $_Qty_detail_sub){
                    $count_itemstock = 1;
                    echo json_encode($count_itemstock);
                    unset($conn);
                    die;
                }

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
                $queryInsert1 = $conn->prepare($queryInsert1);
                $queryInsert1->execute();
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
                (SELECT hncode.DocNo FROM hncode  WHERE hncode.HnCode = $_hn_record_id AND hncode.[procedure] = '$_procedure' AND hncode.doctor = '$_doctor' AND hncode.departmentroomid = '$_departmentroomid' AND hncode.DocDate = '$_PayDate' ), 
                '$input_pay',
                '$_RowID',
                1, 
                1, 
                0, 
                 (SELECT LastSterileDetailID FROM itemstock  WHERE itemstock.RowID = $_RowID)
                ) ";

                // echo $queryInsert2;
                // exit;
                $queryInsert2 = $conn->prepare($queryInsert2);
                $queryInsert2->execute();
                $count_itemstock++;
            }
        }


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

function oncheck_Returnpay($conn)
{
    $return = array();
    $input_returnpay = $_POST['input_returnpay'];
    $DocNo_pay = $_POST['DocNo_pay'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

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

        if($_Isdeproom == 1){
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



function onselect_show_detail_byDocNo_pay($conn)
{
    $return = array();
    $DocNo = $_POST['DocNo'];


    $query = " SELECT
                    item.itemname ,
                    item.itemcode ,
                    COUNT(deproomdetailsub.ID) AS cnt ,
                    deproomdetail.Qty AS cnt_deproomdetail ,
	                ( COUNT ( deproomdetailsub.ID ) - deproomdetail.Qty )  AS balance
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    LEFT  JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode
                WHERE
                    deproom.DocNo = '$DocNo'
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    deproomdetail.Qty   ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_bydeproom_pay($conn)
{
    $return = array();
    $select_date_pay = $_POST['select_date_pay'];
    $select_deproom_pay = $_POST['select_deproom_pay'];

    $select_date_pay = explode("-", $select_date_pay);
    $select_date_pay = $select_date_pay[2] . '-' . $select_date_pay[1] . '-' . $select_date_pay[0];

    $query = " SELECT
                    deproom.hn_record_id,
                    doctor.Doctor_Name,
                    [procedure].Procedure_TH,
	                deproom.DocNo 
                FROM
                    deproom
                    INNER JOIN doctor ON deproom.doctor = doctor.ID
                    INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID 
                WHERE
                    deproom.IsStatus = 1
                    AND CONVERT(DATE,deproom.CreateDate) =  '$select_date_pay' 
                    AND deproom.departmentroomid = '$select_deproom_pay' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}