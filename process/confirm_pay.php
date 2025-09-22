<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';




if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'check_hn') {
        check_hn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateConfirm') {
        onUpdateConfirm($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail') {
        show_detail($conn, $db);
    } else  if ($_POST['FUNC_NAME'] == 'show_detail_item_request') {
        show_detail_item_request($conn, $db);
    } else  if ($_POST['FUNC_NAME'] == 'onconfirm_request') {
        onconfirm_request($conn, $db);
    }
}

function onconfirm_request($conn, $db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $array_itemcode = $_POST['array_itemcode'];
    $array_qty = $_POST['array_qty'];


    $Userid = $_POST['Userid'];
    $DepID = $_POST['DepID'];
    $deproom = $_POST['deproom'];




    $count = 0;
    if ($txt_docno_request == "") {
        $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
        $txt_docno_request = createDocNo($conn, $Userid, $DepID, $deproom, $remark, 0, 1, 0, 0, '', '', '', '', $db, 0);
    }

    foreach ($array_itemcode as $key => $value) {

        $_cntcheck = 0;
        $queryCheck = "SELECT COUNT( deproomdetail.ItemCode ) AS cntcheck  , IsCancel
                        FROM
                            deproomdetail 
                        WHERE
                            deproomdetail.DocNo = '$txt_docno_request' 
                            AND deproomdetail.ItemCode = '$value' ";


        $meQuery = $conn->prepare($queryCheck);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_cntcheck = $row['cntcheck'];
            $_IsCancel = $row['IsCancel'];
        }

        if ($_cntcheck > 0) {

            if ($_IsCancel == 0) {
                $queryUpdate = "UPDATE deproomdetail 
                SET Qty = (Qty +  $array_qty[$key]) , Isaddnew = 1
                WHERE
                    DocNo = '$txt_docno_request' 
                    AND ItemCode = '$value'  ";
            } else {
                $queryUpdate = "UPDATE deproomdetail 
                SET Qty = $array_qty[$key] , IsCancel = 0 , Isaddnew = 1
                WHERE
                    DocNo = '$txt_docno_request' 
                    AND ItemCode = '$value'  ";
            }

            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        } else {

            if ($db == 1) {
                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsStart  , IsQtyStart , Isaddnew  )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]', 0, NOW(), 0, '$Userid',NOW() , 1 , $array_qty[$key] , 1)";
            } else {
                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsStart  , IsQtyStart , Isaddnew )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]', 0, GETDATE(), 0, '$Userid',GETDATE() , 1 , $array_qty[$key] , 1)";
            }



            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
        }



        $query = " UPDATE deproom SET IsAdditem = 1 WHERE  deproom.DocNo = '$txt_docno_request' ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();




        $insert_log = "INSERT INTO log_activity_users (itemCode, qty, isStatus, DocNo, userID, createAt) 
                        VALUES (:itemCode, :qty, :isStatus, :DocNo, :Userid, NOW())";

        $meQuery_log = $conn->prepare($insert_log);

        $meQuery_log->bindParam(':itemCode', $value);
        $meQuery_log->bindParam(':qty', $array_qty[$key]);
        $meQuery_log->bindValue(':isStatus', 1, PDO::PARAM_INT);
        $meQuery_log->bindParam(':DocNo', $txt_docno_request);
        $meQuery_log->bindParam(':Userid', $Userid);


        $meQuery_log->execute();


        $count++;
    }


    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}

function show_detail_item_request($conn, $db)
{
    $return = array();

    $wheretype = "";
    $permission = $_POST['permission'];
    $wherepermission = "";
    if ($permission != '5') {
        $wherepermission = " AND item.warehouseID = $permission ";
    }

    $query = "SELECT
                    item.itemcode,
                    item.itemname AS Item_name ,
                    itemtype.TyeName
                FROM
                    item
                LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND item.IsCancel = 0 
                    AND ( item.itemcode LIKE '%%'  OR item.itemname LIKE '%%' )
                    $wherepermission
                GROUP BY
                    item.ItemCode,
                    item.itemname,
                    itemtype.TyeName
                ORDER BY item.itemname ASC  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail($conn, $db)
{
    $return = array();
    $doc = $_POST['doc'];
    $remark = $_POST['remark'];

    if ($remark == 'sell') {
        $query = " SELECT
                    sell_department_detail.ItemStockID,
                    sell_department_detail.itemCode,
                    item.itemcode2,
                    item.itemname,
                    item.warehouseID,
                    COUNT( sell_department_detail.ItemStockID ) AS cnt_pay 
                FROM
                    sell_department
                    INNER JOIN sell_department_detail ON sell_department_detail.DocNo = sell_department.DocNo
                    LEFT JOIN item ON item.itemcode = sell_department_detail.itemCode 
                WHERE
                    sell_department_detail.DocNo = '$doc' 
                    AND sell_department_detail.ItemStockID IS NOT NULL 
                GROUP BY
                    sell_department_detail.itemCode,
                    item.itemname 
                ORDER BY
                    cnt_pay DESC   ";
    } else {
        $query = " SELECT
                    item.itemname,
                    item.itemcode2,
                    deproomdetail.ID,
                    SUM(deproomdetail.Qty) AS cnt,
                    (SELECT COUNT(deproomdetailsub.ID) FROM deproomdetailsub WHERE deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID) AS cnt_pay,
                    itemtype.TyeName
                    FROM
                    deproom
                    INNER JOIN
                    deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN
                    item ON deproomdetail.ItemCode = item.itemcode
                    INNER JOIN
                    itemtype ON item.itemtypeID = itemtype.ID
                    WHERE
                    deproom.DocNo = '$doc'
                    AND deproom.IsCancel = 0
                    AND deproomdetail.IsCancel = 0
                    GROUP BY
                    item.itemname,
                    item.itemcode2,
                    deproomdetail.ID,
                    itemtype.TyeName
                    ORDER BY
                    item.itemname ASC   ";
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

function onUpdateConfirm($conn, $db)
{
    $return = array();
    $doc = $_POST['doc'];
    $remark = $_POST['remark'];
    $select_users = $_POST['select_users'];


    if ($remark == 'sell') {
        $query = "UPDATE sell_department SET IsConfirm_pay = 1 , userConfirm_pay = $select_users WHERE DocNo ='$doc' ";
    } else {
        $query = "UPDATE deproom SET IsConfirm_pay = 1 , userConfirm_pay = $select_users WHERE DocNo ='$doc' ";
    }

    $meQuery = $conn->prepare($query);
    $meQuery->execute();



    echo json_encode($return);
    unset($conn);
    die;
}

function check_hn($conn, $db)
{
    $return = array();
    $doc = $_POST['doc'];
    $remark = $_POST['remark'];

    if ($remark == 'sell') {
        $query = "SELECT
                    sell_department.departmentID,
                    department.DepName ,
                    IsConfirm_pay,
                    userConfirm_pay
                FROM
                    sell_department
                    INNER JOIN department ON department.ID = sell_department.departmentID 
                WHERE
                    sell_department.DocNo = '$doc'
                GROUP BY
                    department.DepName  ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $row;
        }
    } else {
        $query = "  SELECT
                    deproom.hn_record_id, 
                    deproom.DocNo, 
                    deproom.`procedure`, 
                    deproom.doctor,
                    doctor.Doctor_Name,
                   `procedure`.Procedure_TH,
                   IsConfirm_pay,
                   userConfirm_pay,
                   deproom.number_box
                FROM
                    deproom 
                INNER JOIN doctor ON doctor.ID = deproom.doctor
                INNER JOIN `procedure` ON deproom.`procedure` = `procedure`.ID
                WHERE deproom.DocNo =  '$doc' ";

        // echo $query;
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_procedure = $row['procedure'];
            $_doctor = $row['doctor'];

            if (str_contains($row['procedure'], ',')) {

                $select = " SELECT GROUP_CONCAT(Procedure_TH SEPARATOR ', ') AS procedure_ids FROM `procedure` WHERE `procedure`.ID IN( $_procedure )  ";
                $meQuery_select = $conn->prepare($select);
                $meQuery_select->execute();
                while ($row_select = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
                    $row['Procedure_TH'] = $row_select['procedure_ids'];
                }
            }
            if (str_contains($row['doctor'], ',')) {

                $select = " SELECT GROUP_CONCAT(Doctor_Name SEPARATOR ', ') AS doctor_ids FROM doctor WHERE doctor.ID IN( $_doctor )  ";
                $meQuery_select = $conn->prepare($select);
                $meQuery_select->execute();
                while ($row_select = $meQuery_select->fetch(PDO::FETCH_ASSOC)) {
                    $row['Doctor_Name'] = $row_select['doctor_ids'];
                }
            }

            $return[] = $row;
        }
    }




    echo json_encode($return);
    unset($conn);
    die;
}
