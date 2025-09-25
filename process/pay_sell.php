<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';
require '../process/CreateSell.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'oncheck_sell') {
        oncheck_sell($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_item_sell') {
        show_detail_item_sell($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_department') {
        show_detail_department($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'oncheck_Returnsell') {
        oncheck_Returnsell($conn, $db);
    }
}

function oncheck_Returnsell($conn, $db)
{
    $return = array();
    $input_returnpay_sell = $_POST['input_returnpay_sell'];
    $DocNo_pay_sell = isset($_POST['DocNo_pay_sell']) ? $_POST['DocNo_pay_sell'] : '';
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $input_date_service_sell = $_POST['input_date_service_sell'];
    $input_time_service_sell = $_POST['input_time_service_sell'];
    $select_department_sell_right = $_POST['select_department_sell_right'];



    $input_date_service_sell = explode("-", $input_date_service_sell);
    $input_date_service_sell = $input_date_service_sell[2] . '-' . $input_date_service_sell[1] . '-' . $input_date_service_sell[0];

    $count_itemstock = 0;

    $query_1 = " SELECT
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    itemstock
                WHERE  itemstock.UsageCode = '$input_returnpay_sell' ";
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $count_itemstock = 1;

        $_ItemCode = $row_1['ItemCode'];
        $_Isdeproom =  $row_1['Isdeproom'];
        $_departmentroomid =  $row_1['departmentroomid'];
        $_RowID =  $row_1['RowID'];

        $DocNo_old = "";
        $query_2 = "SELECT
                    sell_department_detail.ID,
                    sell_department_detail.itemCode,
                    sell_department_detail.ItemStockID,
                    sell_department_detail.DocNo 
                FROM
                    sell_department
                    INNER JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo 
                WHERE
                    sell_department_detail.ItemCode = '$_ItemCode' 
                    AND sell_department_detail.ItemStockID = '$_RowID'
                    AND sell_department_detail.DocNo = '$DocNo_pay_sell' ";

        $meQuery_2 = $conn->prepare($query_2);
        $meQuery_2->execute();
        while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {
            $DocNo_old =  $row_2['DocNo'];
            $ID_old =  $row_2['ID'];


            $delete1 = "DELETE FROM sell_department_detail WHERE sell_department_detail.ID ='$ID_old' ";
            $meQuery_d1 = $conn->prepare($delete1);
            $meQuery_d1->execute();

            $queryT = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
                    AND ItemCode = '$_ItemCode' 
                    AND departmentroomid = '$select_department_sell_right' 
                    AND  IsStatus = '9'
                    AND DATE(CreateDate) = '$input_date_service_sell' LIMIT 1 ";


            $meQueryT = $conn->prepare($queryT);
            $meQueryT->execute();


        }

        if($DocNo_old == ""){
            $count_itemstock = 0 ;
        }


        // =======================================================================================================================================


    }


    // =======================================================================================================================================


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

function show_detail_department($conn, $db)
{
    $return = array();
    $select_deproom_sell = $_POST['select_deproom_sell'];
    $select_date_sell = $_POST['select_date_sell'];

    $select_date_sell = explode("-", $select_date_sell);
    $select_date_sell = $select_date_sell[2] . '-' . $select_date_sell[1] . '-' . $select_date_sell[0];

    $where = "";
    if ($select_deproom_sell != '') {
        $where = " AND sell_department.departmentID = '$select_deproom_sell'  ";
    }

    $query = "SELECT
                    sell_department.departmentID,
                    department.DepName 
                FROM
                    sell_department
                    INNER JOIN department ON department.ID = sell_department.departmentID 
                WHERE
                    DATE(sell_department.serviceDate) = '$select_date_sell' 
                    AND sell_department.IsCancel = 0
                    $where
                GROUP BY
                    department.DepName  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['department'][] = $row;
        $_departmentID = $row['departmentID'];

        $query2 = "SELECT
                    sell_department.DocNo,
                    DATE_FORMAT( sell_department.ServiceDate, '%d-%m-%Y' ) AS ServiceDate ,
                    TIME(sell_department.ServiceDate) AS ServiceTime

                FROM
                    sell_department
                    INNER JOIN department ON department.ID = sell_department.departmentID 
                WHERE
                    DATE(sell_department.serviceDate) = '$select_date_sell' 
                    AND sell_department.departmentID = '$_departmentID'
                    AND sell_department.IsCancel = 0
                GROUP BY
                    sell_department.DocNo  ";
        $meQuery_sub = $conn->prepare($query2);
        $meQuery_sub->execute();
        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {
            $return[$_departmentID][] = $row_sub;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_item_sell($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $permission = $_SESSION['permission'];



    $query = " SELECT
                    sell_department_detail.ItemStockID,
                    sell_department_detail.itemCode,
                    item.itemname,
                    item.warehouseID,
                    $permission AS permission,
                    COUNT( sell_department_detail.ItemStockID ) AS item_count 
                FROM
                    sell_department
                    INNER JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo
                    LEFT JOIN item ON item.itemcode = sell_department_detail.itemCode 
                WHERE
                    sell_department_detail.DocNo = '$DocNo' 
                    AND sell_department_detail.ItemStockID IS NOT NULL 
                GROUP BY
                    sell_department_detail.itemCode,
                    item.itemname 
                ORDER BY
                    item_count DESC  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function oncheck_sell($conn, $db)
{
    $return = array();
    $input_pay_sell = $_POST['input_pay_sell'];
    $DocNo_pay_sell = isset($_POST['DocNo_pay_sell']) ? $_POST['DocNo_pay_sell'] : '';
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $input_date_service_sell = $_POST['input_date_service_sell'];
    $input_time_service_sell = $_POST['input_time_service_sell'];
    $select_department_sell_right = $_POST['select_department_sell_right'];



    $input_date_service_sell = explode("-", $input_date_service_sell);
    $input_date_service_sell = $input_date_service_sell[2] . '-' . $input_date_service_sell[1] . '-' . $input_date_service_sell[0];


    $count_new_item_itemcode = 0;


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
                            CASE
                                    WHEN DATE(itemstock.ExpireDate) <= DATE(NOW()) THEN 'exp'
                                    ELSE 'no_exp'
                                END AS check_exp
                        FROM
                            itemstock 
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                        WHERE
                                itemstock.UsageCode = '$input_pay_sell' 
                                $wherepermission ";

    // echo $query_1;
    // exit;
    $count_itemstock = 0;
    $meQuery_1 = $conn->prepare($query_1);
    $meQuery_1->execute();
    while ($row_1 = $meQuery_1->fetch(PDO::FETCH_ASSOC)) {

        $_check_exp = $row_1['check_exp'];
        if ($_check_exp == 'no_exp') {


            // echo  $DocNo_pay_sell;
            // exit;
            if ($DocNo_pay_sell == "") {
                $DocNo_pay_sell = createDocNoSell($conn, $Userid, 1, $select_department_sell_right, $input_date_service_sell, $input_time_service_sell, $db);
            }



            $_ItemCode = $row_1['ItemCode'];
            $_Isdeproom =  $row_1['Isdeproom'];
            $_departmentroomid =  $row_1['departmentroomid'];
            $_RowID =  $row_1['RowID'];

            $count_itemstock++;
            $count_new_item = 0;


            // ลบทิ้งก่อน
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
            }

            $DocNo_old = "";
            $query_2 = "SELECT
                                sell_department_detail.ID,
                                sell_department_detail.itemCode,
                                sell_department_detail.ItemStockID,
                                sell_department_detail.DocNo 
                            FROM
                                sell_department
                                INNER JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo 
                            WHERE
                                sell_department_detail.ItemCode = '$_ItemCode' 
                                AND sell_department_detail.ItemStockID = '$_RowID' ";

            $meQuery_2 = $conn->prepare($query_2);
            $meQuery_2->execute();
            while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {
                $DocNo_old =  $row_2['DocNo'];
                $ID_old =  $row_2['ID'];
            }

            if ($DocNo_old != "") {

                if ($DocNo_old != $DocNo_pay_sell) {
                    $delete1 = "DELETE FROM sell_department_detail WHERE sell_department_detail.ID ='$ID_old' ";
                    $meQuery_d1 = $conn->prepare($delete1);
                    $meQuery_d1->execute();
                }

                if ($DocNo_old == $DocNo_pay_sell) {
                    $count_itemstock = 3;
                    echo json_encode($count_itemstock);
                    unset($conn);
                    die;
                }
            }

            $queryInsert1 = "INSERT INTO sell_department_detail (
                                        itemCode,
                                        ItemStockID,
                                        DocNo,
                                        PayDate
                                    )
                                    VALUES
                                    (
                                        '$_ItemCode', 
                                        '$_RowID',
                                        '$DocNo_pay_sell',
                                        NOW()
                                    ) ";
            // echo $queryInsert1;
            // exit;
            $queryInsert1 = $conn->prepare($queryInsert1);
            $queryInsert1->execute();

            // ==============================
            $queryUpdate = "UPDATE itemstock 
                            SET Isdeproom = 0 ,
                            departmentroomid = '35',
                            IsSell = 1
                            WHERE
                            RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
            // ==============================

            // =======================================================================================================================================
            $query = "INSERT INTO itemstock_transaction_detail ( ItemStockID, ItemCode, CreateDate, departmentroomid, UserCode, IsStatus, Qty )
                        VALUES
                        ( $_RowID, '$_ItemCode','$input_date_service_sell $input_time_service_sell' ,'$select_department_sell_right', $Userid,9,1 ) ";
            $meQuery = $conn->prepare($query);
            $meQuery->execute();

            // echo $query;
            // exit;
            // =======================================================================================================================================


        } else {
            $count_itemstock = 9;
            echo json_encode($count_itemstock);
            unset($conn);
            die;
        }
    }



    if ($count_itemstock == 0) {
        echo json_encode($count_itemstock);
        unset($conn);
        die;
    } else {
        echo json_encode($DocNo_pay_sell);
        unset($conn);
        die;
    }
}
