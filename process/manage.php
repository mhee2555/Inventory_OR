<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'feeddata_detailProcedure') {
        feeddata_detailProcedure($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'saveProcedure') {
        saveProcedure($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'deleteProcedure') {
        deleteProcedure($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_detailDoctor') {
        feeddata_detailDoctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'saveDoctor') {
        saveDoctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'deleteDoctor') {
        deleteDoctor($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'saveUser') {
        saveUser($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'deleteUser') {
        deleteUser($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_detailUser') {
        feeddata_detailUser($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_detailDeproom') {
        feeddata_detailDeproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'saveDeproom') {
        saveDeproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'deleteDeproom') {
        deleteDeproom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_request') {
        onconfirm_request($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_request_byDocNo') {
        show_detail_request_byDocNo($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_routine') {
        show_detail_routine($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_routine') {
        delete_routine($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_edit_routine') {
        select_edit_routine($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'save_doctor_routine') {
        save_doctor_routine($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'save_procedure_routine') {
        save_procedure_routine($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_request_byItem') {
        delete_request_byItem($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_request_byDocNo_change') {
        show_detail_request_byDocNo_change($conn, $db);
    }
}

function delete_request_byItem($conn)
{
    $return = array();
    $ID = $_POST['ID'];

    $sql2 = " DELETE FROM routine_detail WHERE id = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();
    echo json_encode($return);
    unset($conn);
    die;
}

function save_procedure_routine($conn)
{
    $routine_id = $_POST['routine_id'];
    $procedure_routine = $_POST['procedure_routine'];

    $query1 = "UPDATE routine SET `proceduce` = '$procedure_routine'   WHERE id = '$routine_id' ";

    $meQuery1 = $conn->prepare($query1);
    $meQuery1->execute();

    unset($conn);
    die;
}

function save_doctor_routine($conn)
{
    $routine_id = $_POST['routine_id'];
    $doctor_routine = $_POST['doctor_routine'];

    $query1 = "UPDATE routine SET doctor = '$doctor_routine'   WHERE id = '$routine_id' ";

    $meQuery1 = $conn->prepare($query1);
    $meQuery1->execute();

    unset($conn);
    die;
}

function select_edit_routine($conn)
{
    $id = $_POST['routine_id'];
    $return = array();


    $query = "SELECT
                    routine.doctor
                    -- doctor.Doctor_Name,
                    -- doctor.ID AS doctor_id
                FROM
                    routine
                    INNER JOIN doctor ON routine.doctor = doctor.ID
                AND routine.id = $id ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $_doctor = $row['doctor'];

        $query2 = "SELECT doctor.Doctor_Name , doctor.ID AS doctor_id FROM doctor WHERE doctor.ID IN ($_doctor) ";
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
        while ($row_doctor = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return['doctor'][] = $row_doctor;
        }

    }

    $query2 = "SELECT
                routine.`proceduce`
                -- `procedure`.Procedure_TH,
                -- `procedure`.ID  AS procedure_id
            FROM
                routine
                INNER JOIN `procedure` ON routine.proceduce = `procedure`.ID
            AND routine.id = $id ";
    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();
    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {

        $_proceduce = $row2['proceduce'];


        $query2 = "SELECT `procedure`.Procedure_TH , `procedure`.ID  AS procedure_id FROM `procedure` WHERE `procedure`.ID IN ($_proceduce) ";
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
        while ($row_proceduce = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return['proceduce'][] = $row_proceduce;
        }

        
    }

    echo json_encode($return);
    unset($conn);
    die;
}

function delete_routine($conn)
{
    $id = $_POST['id'];


    $query1 = "DELETE FROM routine WHERE id = '$id' ";
    $query2 = "DELETE FROM routine_detail WHERE routine_id = '$id' ";

    $meQuery1 = $conn->prepare($query1);
    $meQuery1->execute();
    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();
    echo "delete success";
    unset($conn);
    die;
}

function show_detail_routine($conn, $db)
{
    $return = array();
    $query = "SELECT
                    routine.id,
                    doctor.Doctor_Name,
                    `procedure`.Procedure_TH,
                    departmentroom.departmentroomname ,
                    doctor.ID AS doctor_id,
                    `procedure`.ID  AS procedure_id,
                    departmentroom.id  AS departmentroom_id
                FROM
                    routine
                    INNER JOIN doctor ON routine.doctor = doctor.ID
                    INNER JOIN `procedure` ON routine.proceduce = `procedure`.ID
                    INNER JOIN departmentroom ON routine.departmentroomid = departmentroom.id  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_request_byDocNo_change($conn, $db){
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_deproom_routine = $_POST['select_deproom_routine'];
    $select_procedure_routine = $_POST['select_procedure_routine'];
    $select_doctor_routine = $_POST['select_doctor_routine'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                routine_detail.id ,
                SUM(routine_detail.qty) AS cnt ,
                itemtype.TyeName,
                routine.id as routine_ID
            FROM
                routine
                INNER JOIN routine_detail ON routine.id = routine_detail.routine_id
                INNER JOIN item ON routine_detail.itemcode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
            WHERE
                routine.doctor = '$select_doctor_routine' 
            AND routine.proceduce = '$select_procedure_routine'
            AND routine.departmentroomid = '$select_deproom_routine'
            GROUP BY
                item.itemname,
                item.itemcode,
                routine_detail.id ,
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
function show_detail_request_byDocNo($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $routine_id = $_POST['routine_id'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                routine_detail.id ,
                SUM(routine_detail.qty) AS cnt ,
                itemtype.TyeName
            FROM
                routine
                INNER JOIN routine_detail ON routine.id = routine_detail.routine_id
                INNER JOIN item ON routine_detail.itemcode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
            WHERE
                routine.id = '$routine_id' 
            GROUP BY
                item.itemname,
                item.itemcode,
                routine_detail.id ,
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

function onconfirm_request($conn)
{
    $return = array();
    $select_deproom_routine = $_POST['select_deproom_routine'];
    $procedure_routine = $_POST['procedure_routine'];
    $doctor_routine = $_POST['doctor_routine'];
    $array_itemcode = $_POST['array_itemcode'];
    $array_qty = $_POST['array_qty'];
    $routine_id = $_POST['routine_id'];




    if ($routine_id == "") {
        $sql = "INSERT INTO routine 
                        (doctor, proceduce, departmentroomid, createAt )
                    VALUES 
                        (:doctor, :proceduce, :departmentroomid, NOW())";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':doctor'      => $doctor_routine,
            ':proceduce'   => $procedure_routine,
            ':departmentroomid' => $select_deproom_routine
        ]);

        $sql = "       SELECT routine.id 
                                FROM routine 
                                WHERE 
                                    routine.doctor IN( :doctor ) AND 
                                    routine.proceduce IN( :proceduce ) AND 
                                    routine.departmentroomid = :departmentroomid 
                                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':doctor'           => $doctor_routine,
            ':proceduce'        => $procedure_routine,
            ':departmentroomid' => $select_deproom_routine
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_id = $row['id'];
        }
    } else {
        $_id = $routine_id;
    }


    foreach ($array_itemcode as $key => $value) {

        $_cntcheck = 0;
        $queryCheck = "SELECT COUNT( routine_detail.itemcode ) AS cntcheck 
                        FROM
                            routine_detail 
                        WHERE
                            routine_detail.routine_id = '$_id' 
                            AND routine_detail.itemcode = '$value' ";


        $meQuery = $conn->prepare($queryCheck);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_cntcheck = $row['cntcheck'];
        }

        if ($_cntcheck > 0) {
            $queryUpdate = "UPDATE routine_detail 
                            SET qty = (qty +  $array_qty[$key]) 
                            WHERE
                                routine_detail.routine_id = '$_id' 
                                AND itemcode = '$value'  ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        } else {

            $queryInsert = "INSERT INTO routine_detail (routine_id, itemcode, qty)
            VALUES (:routine_id, :itemcode, :qty)";

            $meQueryInsert = $conn->prepare($queryInsert);

            $meQueryInsert->execute([
                ':routine_id' => $_id,
                ':itemcode'   => $value,
                ':qty'        => $array_qty[$key]
            ]);
        }
    }


    echo json_encode($_id);
    unset($conn);
    die;
}

function deleteDeproom($conn)
{
    $id = $_POST['id'];

    $query = "DELETE FROM departmentroom WHERE id = '$id' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "delete success";
    unset($conn);
    die;
}

function saveDeproom($conn)
{
    $input_DeproomFloor = $_POST['input_DeproomFloor'];
    $input_DeproomNameTH = $_POST['input_DeproomNameTH'];
    $input_DeproomNameEN = $_POST['input_DeproomNameEN'];
    $input_DeproomName_sub = $_POST['input_DeproomName_sub'];
    $input_IDDeproom = $_POST['input_IDDeproom'];
    $IsActive = $_POST['IsActive'];

    $IsAdmin = 0;



    if ($input_IDDeproom == "") {
        $query = "INSERT INTO departmentroom ( departmentroomname ,  floor_id ,  IsActive  ,  departmentroomname_EN ,  IsMainroom , departmentroomname_sub  ) 
        VALUES             ('$input_DeproomNameTH'  , '$input_DeproomFloor'  , $IsActive , '$input_DeproomNameEN'  , 0 , '$input_DeproomName_sub') ";
    } else {
        $query = "UPDATE departmentroom SET   departmentroomname = '$input_DeproomNameTH' , floor_id = $input_DeproomFloor , IsActive = $IsActive , departmentroomname_EN = '$input_DeproomNameEN' , departmentroomname_sub = '$input_DeproomName_sub'
                  WHERE id = '$input_IDDeproom'  ";
    }

    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo "insert success";
    unset($conn);
    die;
}


function feeddata_detailDeproom($conn, $db)
{
    $return = array();


    $query = "SELECT
                    departmentroom.id,
                    departmentroom.departmentroomname,
                    departmentroom.departmentroomname_sub,
                    floor.name_floor  AS floor_id ,
                    floor.ID  AS ID_floor ,
                    departmentroom.IsActive,
                    departmentroom.IsMainroom,
                    departmentroom.departmentroomname_EN,
                    departmentroom.departmentroomname_sub
                FROM
                    departmentroom
                INNER JOIN floor ON departmentroom.floor_id = floor.ID  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function deleteUser($conn)
{
    $ID = $_POST['ID'];
    $EmpCode = $_POST['EmpCode'];


    $query = "DELETE FROM users WHERE ID = '$ID' ";
    $query = "DELETE FROM employee WHERE EmpCode = '$EmpCode' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "delete success";
    unset($conn);
    die;
}

function saveUser($conn)
{
    $input_empcodeUser = $_POST['input_empcodeUser'];
    $input_nameUser = $_POST['input_nameUser'];
    $input_lastUser = $_POST['input_lastUser'];
    $input_userName = $_POST['input_userName'];
    $input_passWord = $_POST['input_passWord'];
    $IsCancel = $_POST['IsCancel'];
    $input_IDUser = $_POST['input_IDUser'];

    $IsAdmin = 0;



    if ($input_IDUser == "") {
        $query = "INSERT INTO users ( EmpCode ,  UserName ,  Password ,  IsCancel , DeptID , display ) 
        VALUES             ('$input_empcodeUser'  , '$input_userName'  , '$input_passWord'  , $IsCancel ,1  ,3 ) ";

        $query2 = "INSERT INTO employee ( EmpCode ,  FirstName ,  LastName   , DepID ,IsAdmin) 
        VALUES             ('$input_empcodeUser'  , '$input_nameUser' , '$input_lastUser',1,1) ";


        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();


        $queryE = " SELECT
                        users.ID 
                    FROM
                        users
                    WHERE users.EmpCode = '$input_empcodeUser' AND users.UserName = '$input_userName' AND users.Password = '$input_passWord' ";
        $meQueryE = $conn->prepare($queryE);
        $meQueryE->execute();
        while ($rowE = $meQueryE->fetch(PDO::FETCH_ASSOC)) {
            $_ID = $rowE['ID'];
        }

        $query3 = "INSERT INTO user_cabinet ( user_id ) 
        VALUES             ('$_ID' ) ";
        $meQuery3 = $conn->prepare($query3);
        $meQuery3->execute();
    } else {
        $queryE = " SELECT
                        employee.ID 
                    FROM
                        users
                        INNER JOIN employee ON users.EmpCode = employee.EmpCode
                    WHERE users.ID = '$input_IDUser' ";
        $meQueryE = $conn->prepare($queryE);
        $meQueryE->execute();
        while ($rowE = $meQueryE->fetch(PDO::FETCH_ASSOC)) {
            $emID = $rowE['ID'];
        }

        $query = "UPDATE users SET  EmpCode = '$input_empcodeUser' , UserName = '$input_userName' , Password = '$input_passWord' , IsCancel = $IsCancel 
                  WHERE ID = '$input_IDUser'  ";

        $query2 = "UPDATE employee SET IsAdmin = $IsAdmin , EmpCode = '$input_empcodeUser' , FirstName = '$input_nameUser' , LastName = '$input_lastUser'
        WHERE ID = '$emID'  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        $meQuery2 = $conn->prepare($query2);
        $meQuery2->execute();
    }


    echo "insert success";
    unset($conn);
    die;
}

function feeddata_detailUser($conn, $db)
{
    $return = array();


    $query = " SELECT
                    users.ID,
                    users.EmpCode,
                    employee.FirstName,
                    employee.LastName,
                    users.UserName,
                    users.Password,
                    users.IsCancel,
                    users.DeptID 
                FROM
                    users
                    INNER JOIN employee ON users.EmpCode = employee.EmpCode   ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function deleteDoctor($conn)
{
    $ID = $_POST['ID'];

    $query = "DELETE FROM `doctor` WHERE ID = '$ID' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "delete success";
    unset($conn);
    die;
}

function saveDoctor($conn)
{
    $input_doctorth = $_POST['input_doctorth'];
    $input_IDdoctor = $_POST['input_IDdoctor'];
    $IsActive = $_POST['IsActive'];


    if ($input_IDdoctor == "") {
        $query = "INSERT INTO `doctor` ( Doctor_Name , IsCancel) 
        VALUES             ('$input_doctorth' , $IsActive ) ";
    } else {
        $query = "UPDATE `doctor` SET Doctor_Name = '$input_doctorth' , IsCancel = $IsActive WHERE ID = '$input_IDdoctor'  ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "insert success";
    unset($conn);
    die;
}

function feeddata_detailDoctor($conn, $db)
{
    $return = array();

    $query = " SELECT
                     `doctor`.ID,
                     `doctor`.Doctor_Name,
                     `doctor`.IsCancel
                FROM
                     `doctor`  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function deleteProcedure($conn)
{
    $ID = $_POST['ID'];

    $query = "DELETE FROM `procedure` WHERE ID = '$ID' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "delete success";
    unset($conn);
    die;
}

function saveProcedure($conn)
{
    $input_Procedure = $_POST['input_Procedure'];
    $input_IDProcedure = $_POST['input_IDProcedure'];
    $IsActive = $_POST['IsActive'];


    if ($input_IDProcedure == "") {


        $stmt = $conn->prepare("INSERT INTO `procedure` (Procedure_TH, Procedure_EN, IsActive) VALUES (?, ?, ?)");
        $stmt->execute([$input_Procedure, $input_Procedure, $IsActive]);

        // $stmt = $conn->prepare("INSERT INTO `procedure` (Procedure_TH, Procedure_EN, IsActive) VALUES (?, ?, ?)");
        // $stmt->bind_param("sss", $input_Procedure, $input_Procedure, $IsActive);
        // $stmt->execute();


        // $query = "INSERT INTO `procedure` ( Procedure_TH , Procedure_EN, IsActive ) 
        // VALUES             ('$input_Procedure'  , '$input_Procedure' , '$IsActive' ) ";

        // $meQuery = $conn->prepare($query);
        // $meQuery->execute();
    } else {

        $stmt = $conn->prepare("UPDATE `procedure` SET Procedure_TH = ?, Procedure_EN = ?, IsActive = ? WHERE ID = ?");
        $stmt->execute([$input_Procedure, $input_Procedure, $IsActive, $input_IDProcedure]);
        // $query = "UPDATE `procedure` SET Procedure_TH = '$input_Procedure' , IsActive = '$IsActive'  WHERE ID = '$input_IDProcedure'  ";


    }



    echo "insert success";
    unset($conn);
    die;
}

function feeddata_detailProcedure($conn, $db)
{
    $return = array();


    $query = " SELECT
                     `procedure`.ID,
                     `procedure`.Procedure_EN AS Procedure_TH,
                     `procedure`.IsActive
                FROM
                     `procedure`  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
