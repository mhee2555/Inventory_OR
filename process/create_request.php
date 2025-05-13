<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_item_request') {
        show_detail_item_request($conn,$db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_request') {
        onconfirm_request($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'show_detail_request_byDocNo') {
        show_detail_request_byDocNo($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'onconfirm_send_request') {
        onconfirm_send_request($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'show_detail_history') {
        show_detail_history($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'cancel_item_byDocNo') {
        cancel_item_byDocNo($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'delete_request_byItem') {
        delete_request_byItem($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'add_request_qty') {
        add_request_qty($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'delete_request_qty') {
        delete_request_qty($conn,$db);
    }  else if ($_POST['FUNC_NAME'] == 'check_routine') {
        check_routine($conn,$db);
    }
}

function check_routine($conn,$db){
    $return = array();
    $select_deproom_request = $_POST['select_deproom_request'];
    $procedure_id_Array = $_POST['procedure_id_Array'];
    $doctor_Array = $_POST['doctor_Array'];

    $procedure_id_Array = implode(",", $procedure_id_Array);
    $doctor_Array = implode(",", $doctor_Array);

    $select = "SELECT
                    routine_detail.itemcode,
                    routine_detail.qty 
                FROM
                    routine_detail
                    INNER JOIN routine ON routine_detail.routine_id = routine.id 
                WHERE
                    routine.doctor = '$doctor_Array' 
                    AND routine.proceduce = '$procedure_id_Array' 
                    AND routine.departmentroomid = '$select_deproom_request' ";
    $meQuery = $conn->prepare($select);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;

}



function add_request_qty($conn,$db)
{
    $return = array();
    $ID = $_POST['ID'];
    $qty = $_POST['qty'];

    $sql2 = " UPDATE deproomdetail SET Qty = $qty  WHERE ID = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($return);
    unset($conn);
    die;
}


function delete_request_qty($conn,$db)
{
    $return = array();
    $ID = $_POST['ID'];
    $qty = $_POST['qty'];

    $sql2 = " UPDATE deproomdetail SET Qty = $qty  WHERE ID = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($return);
    unset($conn);
    die;
}



function delete_request_byItem($conn,$db)
{
    $return = array();
    $ID = $_POST['ID'];

    $sql2 = " DELETE FROM deproomdetail WHERE ID = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($return);
    unset($conn);
    die;
}

function cancel_item_byDocNo($conn,$db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];

    if($db == 1){
        $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = NOW()  WHERE DocNo = '$txt_docno_request' ";
    }else{
        $sql1 = " UPDATE deproom SET IsCancel = 1 , ModifyDate = GETDATE()  WHERE DocNo = '$txt_docno_request' ";
    }
    $sql2 = " DELETE FROM deproomdetail WHERE DocNo = '$txt_docno_request' ";
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}


function onconfirm_send_request($conn,$db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $select_deproom_request = $_POST['select_deproom_request'];
    $input_hn_request = $_POST['input_hn_request'];
    $select_doctor_request = $_POST['select_doctor_request'];
    $select_procedure_request = $_POST['select_procedure_request'];
    $input_remark_request = $_POST['input_remark_request'];
    $select_date_request = $_POST['select_date_request'];
    $select_time_request = $_POST['select_time_request'];
    $text_edit = $_POST['text_edit'];
    $qty_Array = $_POST['qty_Array'];
    $id_Array = $_POST['id_Array'];


    // $select_doctor_request = implode(",", $select_doctor_request);
    // $select_procedure_request = implode(",", $select_procedure_request);

    $select_procedure_request = implode(",", $select_procedure_request);
    $select_doctor_request = implode(",", $select_doctor_request);


    // $id_Array = $_POST['id_Array'];
    // $id_Array = $_POST['id_Array'];


    foreach ($id_Array as $key => $value) {
        $update = "UPDATE deproomdetail SET Qty = '$qty_Array[$key]' WHERE ID = '$value' ";
        $meQueryU = $conn->prepare($update);
        $meQueryU->execute();
    }

    

    $select_date_request = explode("-", $select_date_request);
    $select_date_request = $select_date_request[2] . '-' . $select_date_request[1] . '-' . $select_date_request[0];

    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];

    if($text_edit != 'edit'){
        createhncodeDocNo($conn, $Userid, $DepID, $input_hn_request, $select_deproom_request,0, $select_procedure_request, $select_doctor_request, 'สร้างจากเมนูขอเบิกอุปกรณ์' , $txt_docno_request,$db , $select_date_request,'');
    }


    if($db ==1){
        $sql_ = " UPDATE hncode SET DocDate  = '$select_date_request $select_time_request' WHERE DocNo_SS = '$txt_docno_request' ";
       
       
        $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$select_date_request $select_time_request' , Remark = '$input_remark_request' , hn_record_id = '$input_hn_request' , doctor = '$select_doctor_request' , `procedure` = '$select_procedure_request' , Ref_departmentroomid = '$select_deproom_request' WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    }else{
        $sql1 = " UPDATE deproom SET IsStatus = 1 , serviceDate = '$select_date_request $select_time_request' , Remark = '$input_remark_request' , hn_record_id = '$input_hn_request' , doctor = '$select_doctor_request' , [procedure] = '$select_procedure_request' , Ref_departmentroomid = '$select_deproom_request' WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    }

    $sql2 = " UPDATE deproomdetail SET IsStatus = 3 WHERE DocNo = '$txt_docno_request' AND IsCancel = 0 ";
    $meQuery_ = $conn->prepare($sql_);
    $meQuery_->execute();
    $meQuery1 = $conn->prepare($sql1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}
 

function onconfirm_request($conn,$db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $array_itemcode = $_POST['array_itemcode'];
    $array_qty = $_POST['array_qty'];


    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];


    

    $count = 0;
    if ($txt_docno_request == "") {
        $remark = "สร้างจาก ขอเบิกอุปกรณ์ ";
        $txt_docno_request = createDocNo($conn, $Userid , $DepID , $deproom , $remark ,0 , 0 , 0 , 0, '', '', '', '',$db,0);
    }

    foreach ($array_itemcode as $key => $value) {

        $_cntcheck = 0;
        $queryCheck = "SELECT COUNT( deproomdetail.ItemCode ) AS cntcheck 
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

            if($db == 1){
                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsStart  , IsQtyStart  )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]', 0, NOW(), 0, '$Userid',NOW() , 1 , $array_qty[$key])";
            }else{
                $queryInsert = "INSERT INTO deproomdetail ( DocNo, ItemCode, Qty, IsStatus, PayDate, IsCancel, ModifyUser, ModifyTime , IsStart  , IsQtyStart  )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]', 0, GETDATE(), 0, '$Userid',GETDATE() , 1 , $array_qty[$key])";
            }



            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
        }


        $count++;
    }


    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}



function show_detail_item_request($conn,$db)
{
    $return = array();
    $input_Search = $_POST['input_search_request'];
    $select_typeItem = $_POST['select_typeItem'];

    $wheretype = "";
    if($select_typeItem != ""){
        $wheretype = " AND itemtype.ID = '$select_typeItem' ";
    }

    $query = "SELECT
                    item.itemcode,
                    item.itemname AS Item_name ,
                    itemtype.TyeName
                FROM
                    item
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND item.IsCancel = 0 
                    AND ( item.itemcode LIKE '%$input_Search%'  OR item.itemname LIKE '%$input_Search%' )
                    $wheretype
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

function show_detail_request_byDocNo($conn,$db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $txt_docno_request = $_POST['txt_docno_request'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                deproomdetail.ID ,
                SUM(deproomdetail.Qty) AS cnt ,
                itemtype.TyeName
            FROM
                deproom
                INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
            WHERE
                deproom.DocNo = '$txt_docno_request' 
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

function show_detail_history($conn,$db)
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
        // $whereP = " AND  FIND_IN_SET('$select_procedure_history', deproom.`procedure`) ";
        $whereP = "  AND deproom.`procedure` LIKE '%$select_procedure_history%'  ";
    }
    $whereD = "";
    if (isset($select_doctor_history)) {
        $select_doctor_history = implode(",", $select_doctor_history);
        $whereD = "  AND deproom.`doctor` LIKE '%$select_doctor_history%'  ";
    }

    if($db == 1){

        $whereR = "";
        if($select_deproom_history != ""){
            $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
        }


        $query = " SELECT
                        deproom.DocNo,
                        DATE_FORMAT( deproom.serviceDate, '%d-%m-%Y' ) AS serviceDate,
                        DATE_FORMAT( deproom.serviceDate, '%H:%i' ) AS serviceTime,
                        deproom.hn_record_id,
                        doctor.Doctor_Name,
                        IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH,
                        departmentroom.departmentroomname,
                        doctor.ID AS doctor_ID,
                        `procedure`.ID AS procedure_ID,
                        departmentroom.id AS deproom_ID,
                        deproom.Remark,
                        deproom.doctor,
                        deproom.`procedure` ,
                        deproomdetailsub.ID  AS cnt_id
                    FROM
                        deproom
                        INNER JOIN doctor ON doctor.ID = deproom.doctor
                        LEFT JOIN `procedure` ON deproom.`procedure` = `procedure`.ID
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        LEFT JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        LEFT JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    WHERE
                        DATE( deproom.CreateDate ) BETWEEN '$select_date_history_s'  AND '$select_date_history_l' 
                        AND deproom.IsCancel = 0 
                        AND deproom.IsManual = 0
                        $whereD
                        $whereP
                        $whereR 
                    GROUP BY
                        deproom.DocNo 
                    ORDER BY
                        deproom.ID DESC ";
    }else{

        $whereD = "";
        if($select_doctor_history != ""){
            $whereD = " AND deproom.doctor = '$select_doctor_history'";
        }
        $whereP = "";
        if($select_procedure_history != ""){
            $whereP = " AND deproom.[procedure] = '$select_procedure_history' ";
        }
        $whereR = "";
        if($select_deproom_history != ""){
            $whereR = " AND deproom.Ref_departmentroomid = '$select_deproom_history' ";
        }


        $query = " SELECT
        deproom.DocNo,
        FORMAT(deproom.serviceDate , 'dd-MM-yyyy') AS serviceDate,
        FORMAT(deproom.serviceDate , 'HH:mm') AS serviceTime,
        deproom.hn_record_id,
        doctor.Doctor_Name,
        [procedure].Procedure_TH,
        departmentroom.departmentroomname ,
        doctor.ID AS doctor_ID,
        [procedure].ID AS procedure_ID,
        departmentroom.id AS deproom_ID,
        deproom.Remark
        FROM
            deproom
            INNER JOIN doctor ON doctor.ID = deproom.doctor
            INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID
            INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
        WHERE
            CONVERT(DATE,deproom.CreateDate)  BETWEEN  '$select_date_history_s'  AND '$select_date_history_l' 
            AND deproom.IsCancel = 0
            $whereD
            $whereP
            $whereR 
            ORDER BY  deproom.ID DESC ";
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



