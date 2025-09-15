<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';


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



    $sql2 = "UPDATE his 
            SET IsStatus = CASE 
                            WHEN IsStatus = 2 THEN 3 
                            ELSE 2 
                            END 
            WHERE ID = :id";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->bindParam(':id', $ID, PDO::PARAM_INT);
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
                his.IsStatus,
                his_detail.add_Qty,
                his_detail.delete_Qty
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
                DATE_FORMAT( his.DocDate, '%d-%m-%Y' ) AS createAt,
                his.doctor,
                his.departmentroomid,
                his.`procedure`,
                IFNULL( doctor.Doctor_Name, '' ) AS Doctor_Name,
                IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                departmentroom.departmentroomname,
                SUM( his_detail.add_Qty ) AS add_Qty,
                SUM( his_detail.delete_Qty ) AS delete_Qty,
                his.isCancel,
                department.DepName 
            FROM
                his
                LEFT JOIN doctor ON doctor.ID = his.doctor
                LEFT JOIN `procedure` ON his.`procedure` = `procedure`.ID
                LEFT JOIN departmentroom ON his.departmentroomid = departmentroom.id
                INNER JOIN his_detail ON his.DocNo = his_detail.DocNo
                LEFT JOIN department ON department.ID = his.HnCode 
            WHERE
                     DATE( his.DocDate ) = '$select_his_Date'
                AND ( his.isStatus = 1 OR his.isStatus = 2 OR his.isStatus = 3 ) 
            GROUP BY
                his.DocNo ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {

        $_HnCode = $rowQ1['HnCode'];
        $_DepName = $rowQ1['DepName'];
        if ($_HnCode == "") {
            $rowQ1['HnCode'] = $rowQ1['number_box'];
        }

        if (str_contains($rowQ1['procedure'], ',')) {
            $rowQ1['Procedure_TH'] = 'button';
        }
        if (str_contains($rowQ1['doctor'], ',')) {
            $rowQ1['Doctor_Name'] = 'button';
        }

        if ($_DepName != null) {
            $rowQ1['HnCode'] = $rowQ1['DepName'];
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
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    $Q1 = "SELECT
                set_hn.ID,
                set_hn.hncode,
                DATE( set_hn.serviceDate) AS serviceDate,
                TIME( set_hn.serviceDate) AS serviceTime,
                set_hn.doctor,
                set_hn.departmentroomid,
                set_hn.`procedure`,
                set_hn.remark,
                set_hn.isStatus,
                set_hn.userID,
                set_hn.isCancel,
                set_hn.createAt ,
                set_hn.IsTF 
            FROM
                set_hn 
            WHERE set_hn.ID = '$ID' ";
    $meQuery = $conn->prepare($Q1);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;

        $select_deproom_request = $row['departmentroomid'];
        $input_hn_request = $row['hncode'];
        $select_procedure_request = $row['procedure'];
        $select_doctor_request = $row['doctor'];
        $ID = $row['ID'];
        $remark = $row['remark'];
        $serviceDate = $row['serviceDate'];
        $serviceTime = $row['serviceTime'];
        $IsTF = $row['IsTF'];
    }


    $txt_docno_request = createDocNo($conn, $Userid, $DepID, $select_deproom_request, $remark, 0, 0, 0, 0, '', '', $input_hn_request, '', $db, 0,0,$IsTF);

    $sql1 = " UPDATE deproom SET IsStatus = 0 , serviceDate = '$serviceDate $serviceTime'  , hn_record_id = '$input_hn_request' , doctor = '$select_doctor_request' , `procedure` = '$select_procedure_request' , Ref_departmentroomid = '$select_deproom_request' WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    $meQueryUpdate = $conn->prepare($sql1);
    $meQueryUpdate->execute();
    $DocNo_hn = createhncodeDocNo($conn, $Userid, $DepID, $input_hn_request, $select_deproom_request, 1, $select_procedure_request, $select_doctor_request, 'สร้างจากเมนูขอเบิกอุปกรณ์', $txt_docno_request, $db, $serviceDate, '');





                    $p = "  SELECT
                                    MIN( `procedure`.`status` ) AS status 
                            FROM
                                `procedure` 
                            WHERE
                                `procedure`.ID IN ($select_procedure_request)  ";
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
                            ( '$txt_docno_request', '$_itemcode', 1, 3,NOW(), 0, '$Userid',NOW() , 1)";

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
                                AND deproomdetail.DocNo = '$txt_docno_request'
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
                                        ( '0', '$_itemcode','$serviceDate','$_departmentroomid', $Userid,1,1,'$_hn_record_id') ";
                $meQuery = $conn->prepare($query);
                $meQuery->execute();

                $queryInsert2 = "INSERT INTO hncode_detail (DocNo,UsageCode,ItemStockID,Qty,IsStatus,IsCancel,ItemCode)  VALUES             
                                                (
                                                    '$DocNo_hn', 
                                                    '0',
                                                    '0',
                                                    1, 
                                                    1, 
                                                    0, 
                                                    '$_itemcode'
                                                ) ";

                $query_updateHN = "UPDATE hncode SET IsStatus = 1  WHERE DocNo = '$DocNo_hn'   ";
                $query_updateHN = $conn->prepare($query_updateHN);
                $query_updateHN->execute();


                $sqlDocNo = "SELECT DocNo FROM his WHERE DocNo_deproom = ? LIMIT 1";
                $stmtDoc = $conn->prepare($sqlDocNo);
                $stmtDoc->execute([$txt_docno_request]);
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



    $select = "SELECT
                    routine_detail.itemcode,
                    routine_detail.qty 
                FROM
                    routine_detail
                    INNER JOIN routine ON routine_detail.routine_id = routine.id 
                WHERE
                    routine.doctor = '$select_doctor_request' 
                    AND routine.proceduce = '$select_procedure_request' 
                    AND routine.departmentroomid = '$select_deproom_request' ";
    $meQuery = $conn->prepare($select);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $_itemcode = $row['itemcode'];
        $_qty = $row['qty'];


        $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsStart  , IsQtyStart  )
                VALUES
                    ( '$txt_docno_request', '$_itemcode', '$_qty', 0, NOW(), 0, '$Userid',NOW() , 1 , $_qty)";


        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();




        //  ======================

        // $return[] = $row;
        // $delete = "DELETE FROM deproomdetail WHERE DocNo = '$txt_docno_request' ";
        // $meQuerydelete = $conn->prepare($delete);
        // $meQuerydelete->execute();
    }



    $Q1 = " UPDATE set_hn SET isStatus = 3 , DocNo_deproom = '$txt_docno_request' WHERE set_hn.ID = '$ID' ";
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
        $where_t = " AND  ( set_hn.isStatus = 0 OR set_hn.isStatus = 1 OR set_hn.isStatus = 2 ) AND NOT set_hn.isCancel = 1 ";
    }
    if ($select_type == 2) {
        $where_t = " AND set_hn.isStatus = 3 AND NOT set_hn.isCancel = 1 ";
    }


    $whereD = "";
    if ($check_Box == 0) {
        $whereD = " AND DATE( set_hn.createAt ) = '$select_date1_search'  ";
    }
    if ($check_Box == 1) {
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
                departmentroom.departmentroomname,
                set_hn.isCancel
            FROM
                set_hn
                INNER JOIN doctor ON doctor.ID = set_hn.doctor
                LEFT JOIN `procedure` ON set_hn.`procedure` = `procedure`.ID
                INNER JOIN departmentroom ON set_hn.departmentroomid = departmentroom.id 
                $whereD
                AND NOT set_hn.isStatus = 9
                $where_t
            ORDER BY set_hn.serviceDate DESC ";

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

    $check_Box = $_POST['check_Box'];

    $whereDate = "";
    if ($check_Box == 0) {
        $whereDate = "AND  DATE( set_hn.createAt ) = '$select_date1_search'  ";
    }
    if ($check_Box == 1) {
        $whereDate = " ";
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
            WHERE
                 set_hn.isStatus = 9 
                 $whereDate
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
