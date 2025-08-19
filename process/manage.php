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
    } else if ($_POST['FUNC_NAME'] == 'updateDetail_qty') {
        updateDetail_qty($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'save_deproom_routine') {
        save_deproom_routine($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'feeddata_detailDepartment') {
        feeddata_detailDepartment($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'deleteDepartment') {
        deleteDepartment($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'saveDepartment') {
        saveDepartment($conn, $db);
    }
}

function updateDetail_qty($conn, $db)
{
    $return = array();
    $ID = $_POST['ID'];
    $qty = $_POST['qty'];
    $itemcode = $_POST['itemcode'];




    $Userid = $_SESSION['Userid'];

    $sql2 = " UPDATE routine_detail SET qty = $qty  WHERE id = '$ID' ";
    $meQuery2 = $conn->prepare($sql2);
    $meQuery2->execute();






    echo json_encode($return);
    unset($conn);
    die;
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

function save_deproom_routine($conn)
{
    $routine_id = $_POST['routine_id'];
    $deproom_routine = $_POST['deproom_routine'];

    $query1 = "UPDATE routine SET departmentroomid = '$deproom_routine'   WHERE id = '$routine_id' ";

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
    $input_search_routine = $_POST['input_search_routine'];

    $where = '';
    if ($input_search_routine != "") {
        $where = " WHERE doctor.Doctor_Name LIKE '%$input_search_routine%' OR  `procedure`.Procedure_TH LIKE '%$input_search_routine%' OR  departmentroom.departmentroomname LIKE '%$input_search_routine%'  ";
    }

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
                    INNER JOIN departmentroom ON routine.departmentroomid = departmentroom.id
                    $where  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_request_byDocNo_change($conn, $db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $select_deproom_routine = $_POST['select_deproom_routine'];
    $select_procedure_routine = $_POST['select_procedure_routine'];
    $select_doctor_routine = $_POST['select_doctor_routine'];

    $query = "SELECT
                SUM(routine_detail.qty) AS cnt 
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

    $count_id = 0;

    // if ($input_IDDeproom == "") {
    $check_d = "    SELECT id 
                            FROM   departmentroom 
                            WHERE (departmentroomname_sub = '$input_DeproomName_sub' OR departmentroomname = '$input_DeproomNameTH' OR departmentroomname_EN = '$input_DeproomNameEN' ) ";
    $meQuery_d = $conn->prepare($check_d);
    $meQuery_d->execute();
    while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
        $count_id++;
    }
    // }



    if ($count_id == 0) {
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
    } else {
        echo "xxxx";
        unset($conn);
        die;
    }
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
    function post($key, $default = '') {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    $select_user_rfid     = post('select_user_rfid', '');
    $select_user_weighing = post('select_user_weighing', '');
    $input_empcodeUser    = post('input_empcodeUser', '');
    $input_nameUser       = post('input_nameUser', '');
    $input_lastUser       = post('input_lastUser', '');
    $input_userName       = post('input_userName', '');
    $input_passWord       = post('input_passWord', '');
    $select_permission    = post('select_permission', '');
    $IsCancel             = isset($_POST['IsCancel']) ? (int)$_POST['IsCancel'] : 0;
    $input_IDUser         = post('input_IDUser', '');
    $IsAdmin_new          = isset($_POST['IsAdmin']) ? (int)$_POST['IsAdmin'] : 0;

    // ค่าดีฟอลต์กรณีว่าง
    if ($select_user_rfid === "")     $select_user_rfid = 0;
    if ($select_user_weighing === "") $select_user_weighing = 0;

    try {
        // ใช้ทรานแซคชันเพื่อความสอดคล้องของข้อมูล
        $conn->beginTransaction();

        // ------------------------------------------------------------
        // กรณีเพิ่มผู้ใช้ใหม่ (INSERT)
        // ------------------------------------------------------------
        if ($input_IDUser === "") {
   
            // 1) ตรวจซ้ำ UserName
            $stmt = $conn->prepare("SELECT ID FROM users WHERE UserName = :uname LIMIT 1");
            $stmt->execute([':uname' => $input_userName]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                echo 2; // ซ้ำ UserName
                $conn->rollBack();
                unset($conn);
                die;
            }

            // 2) ตรวจซ้ำ EmpCode
            $stmt = $conn->prepare("SELECT ID FROM users WHERE EmpCode = :emp LIMIT 1");
            $stmt->execute([':emp' => $input_empcodeUser]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                echo 1; // ซ้ำ EmpCode
                $conn->rollBack();
                unset($conn);
                die;
            }

            // 3) INSERT users
            $sqlInsertUser = "INSERT INTO users 
                (EmpCode, UserName, Password, IsCancel, DeptID, display, permission, IsAdmin, IsFingerPrint1, IsFingerPrint2)
                VALUES
                (:emp, :uname, :pwd, :iscancel, 1, 3, :perm, :isadmin, :rfid, :weigh)";
            $stmt = $conn->prepare($sqlInsertUser);
            $stmt->execute([
                ':emp'      => $input_empcodeUser,
                ':uname'    => $input_userName,
                ':pwd'      => $input_passWord, // ถ้าต้องการ hash: password_hash($input_passWord, PASSWORD_DEFAULT)
                ':iscancel' => $IsCancel,
                ':perm'     => $select_permission,
                ':isadmin'  => $IsAdmin_new,
                ':rfid'     => $select_user_rfid,
                ':weigh'    => $select_user_weighing
            ]);
            $newUserId = (int)$conn->lastInsertId();

            // 4) INSERT employee
            $sqlInsertEmp = "INSERT INTO employee (EmpCode, FirstName, LastName, DepID, IsAdmin)
                             VALUES (:emp, :fname, :lname, 1, :isadmin)";
            $stmt = $conn->prepare($sqlInsertEmp);
            $stmt->execute([
                ':emp'     => $input_empcodeUser,
                ':fname'   => $input_nameUser,
                ':lname'   => $input_lastUser,
                ':isadmin' => $IsAdmin_new
            ]);

 

            // 5) INSERT / SETUP config_menu ตามสิทธิ์
            if ($IsAdmin_new == 1) {
                $insertSql = "INSERT INTO config_menu 
                    (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
                    VALUES (:userID,1,1,1,1,1,1,1,1,1,1,1)";
            } else {
                $insertSql = "INSERT INTO config_menu 
                    (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
                    VALUES (:userID,1,1,1,1,1,1,1,1,0,1,0)";
            }
            $stmt = $conn->prepare($insertSql);
            $stmt->execute([':userID' => $newUserId]);

            // 6) INSERT user_cabinet
            $sqlInsertCab = "INSERT INTO user_cabinet (user_id) VALUES (:uid)";
            $stmt = $conn->prepare($sqlInsertCab);
            $stmt->execute([':uid' => $newUserId]);

            $conn->commit();
            echo "insert success";
            unset($conn);
            die;
        }

        // ------------------------------------------------------------
        // กรณีแก้ไขผู้ใช้เดิม (UPDATE)
        // ------------------------------------------------------------
        // ดึง employee.ID คู่กับผู้ใช้เดิม
        $sqlGet = "SELECT employee.ID AS emID, users.EmpCode AS curEmpCode, users.UserName AS curUserName
                   FROM users
                   INNER JOIN employee ON users.EmpCode = employee.EmpCode
                   WHERE users.ID = :id
                   LIMIT 1";
        $stmt = $conn->prepare($sqlGet);
        $stmt->execute([':id' => $input_IDUser]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo 3; // ไม่พบข้อมูลเดิม (หรือจะกำหนด code อื่นก็ได้)
            $conn->rollBack();
            unset($conn);
            die;
        }

        $emID      = (int)$row['emID'];

        // 1) เช็กซ้ำ UserName กับ "คนอื่น"
        $stmt = $conn->prepare("SELECT ID FROM users WHERE UserName = :uname AND ID <> :id LIMIT 1");
        $stmt->execute([':uname' => $input_userName, ':id' => $input_IDUser]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            echo 2; // ซ้ำ UserName
            $conn->rollBack();
            unset($conn);
            die;
        }

        // 2) เช็กซ้ำ EmpCode กับ "คนอื่น"
        $stmt = $conn->prepare("SELECT ID FROM users WHERE EmpCode = :emp AND ID <> :id LIMIT 1");
        $stmt->execute([':emp' => $input_empcodeUser, ':id' => $input_IDUser]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            echo 1; // ซ้ำ EmpCode
            $conn->rollBack();
            unset($conn);
            die;
        }

                $sqlUpdateUser = "UPDATE users SET
                        IsFingerPrint1 = :rfid,
                        IsFingerPrint2 = :weigh,
                        IsAdmin        = :isadmin,
                        EmpCode        = :emp,
                        UserName       = :uname,
                        Password       = :pwd,
                        IsCancel       = :iscancel22,
                        permission     = :perm
                    WHERE ID = :id";

                $params = [
                    ':rfid'     => $select_user_rfid,
                    ':weigh'    => $select_user_weighing,
                    ':isadmin'  => $IsAdmin_new,
                    ':emp'      => $input_empcodeUser,
                    ':uname'    => $input_userName,
                    ':pwd'      => $input_passWord, // ถ้าต้องการ hash: password_hash($input_passWord, PASSWORD_DEFAULT)
                    ':iscancel22' => (int)$IsCancel,
                    ':perm'     => $select_permission,
                    ':id'       => $input_IDUser
                ];

                // echo ออกมาดูก่อน
                echo "<pre>";
                print_r($params);
                echo "</pre>";
                $stmt = $conn->prepare($sqlUpdateUser);
                $stmt->execute($params); 


        // 4) UPDATE employee
        $sqlUpdateEmp = "UPDATE employee SET
                IsAdmin   = :isadmin,
                EmpCode   = :emp,
                FirstName = :fname,
                LastName  = :lname
            WHERE ID = :emid";
        $stmt = $conn->prepare($sqlUpdateEmp);
        $stmt->execute([
            ':isadmin' => $IsAdmin_new,
            ':emp'     => $input_empcodeUser,
            ':fname'   => $input_nameUser,
            ':lname'   => $input_lastUser,
            ':emid'    => $emID
        ]);

        // 5) UPDATE / UPSERT สิทธิ์เมนู ตามสถานะแอดมิน
        if ($IsAdmin_new == 1) {
            $sqlCfg = "UPDATE config_menu SET 
                        main=1, recieve_stock=1, create_request=1, request_item=1, 
                        set_hn=1, pay=1, hn=1, movement=1, manage=1, report=1, permission=1
                       WHERE userID = :userID";
        } else {
            $sqlCfg = "UPDATE config_menu SET 
                        main=1, recieve_stock=1, create_request=1, request_item=1, 
                        set_hn=1, pay=1, hn=1, movement=1, manage=0, report=1, permission=0
                       WHERE userID = :userID";
        }
        $stmt = $conn->prepare($sqlCfg);
        $stmt->execute([':userID' => $input_IDUser]);

        // ถ้าไม่มีแถวถูกอัปเดต (ยังไม่มี config_menu ของ user นี้) -> INSERT ให้
        if ($stmt->rowCount() === 0) {
            if ($IsAdmin_new == 1) {
                $insCfg = "INSERT INTO config_menu 
                    (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
                    VALUES (:userID,1,1,1,1,1,1,1,1,1,1,1)";
            } else {
                $insCfg = "INSERT INTO config_menu 
                    (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
                    VALUES (:userID,1,1,1,1,1,1,1,1,0,1,0)";
            }
            $stmt = $conn->prepare($insCfg);
            $stmt->execute([':userID' => $input_IDUser]);
        }

        $conn->commit();
        echo "insert success";
        unset($conn);
        die;

    } catch (Exception $e) {
        if ($conn && $conn->inTransaction()) {
            $conn->rollBack();
        }
        // คุณอาจ echo code อื่น หรือ ส่งข้อความ error แทน
        echo "error";
        // ใน dev/log จริงควรบันทึก $e->getMessage()
        unset($conn);
        die;
    }
}


// function saveUser($conn)
// {
//     $select_user_rfid = $_POST['select_user_rfid'];
//     $select_user_weighing = $_POST['select_user_weighing'];
//     $input_empcodeUser = $_POST['input_empcodeUser'];
//     $input_nameUser = $_POST['input_nameUser'];
//     $input_lastUser = $_POST['input_lastUser'];
//     $input_userName = $_POST['input_userName'];
//     $input_passWord = $_POST['input_passWord'];
//     $select_permission = $_POST['select_permission'];
//     $IsCancel = $_POST['IsCancel'];
//     $input_IDUser = $_POST['input_IDUser'];
//     $IsAdmin_new = $_POST['IsAdmin'];

//     $IsAdmin = 0;

//     if ($select_user_rfid == "") {
//         $select_user_rfid = 0;
//     }
//     if ($select_user_weighing == "") {
//         $select_user_weighing = 0;
//     }
//     $count_id = 0;
//     if ($input_IDUser == "") {

//         $check_d = "    SELECT ID
//                         FROM   users 
//                         WHERE UserName = '$input_userName' ";
//         $meQuery_d = $conn->prepare($check_d);
//         $meQuery_d->execute();
//         while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
//             $count_id = 2;
//         }
//         $check_d = "    SELECT ID
//                         FROM   users 
//                         WHERE EmpCode = '$input_empcodeUser' ";
//         $meQuery_d = $conn->prepare($check_d);
//         $meQuery_d->execute();
//         while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
//             $count_id = 1;
//         }
//     }

//     if ($count_id == 0) {
//         if ($input_IDUser == "") {
//             $query = "INSERT INTO users ( EmpCode ,  UserName ,  Password ,  IsCancel , DeptID , display , permission, IsAdmin, IsFingerPrint1, IsFingerPrint2) 
//             VALUES             ('$input_empcodeUser'  , '$input_userName'  , '$input_passWord'  , $IsCancel ,1  ,3 , '$select_permission', '$IsAdmin_new', $select_user_rfid, $select_user_weighing) ";

//             $query2 = "INSERT INTO employee ( EmpCode ,  FirstName ,  LastName   , DepID ,IsAdmin) 
//             VALUES             ('$input_empcodeUser'  , '$input_nameUser' , '$input_lastUser',1,$IsAdmin_new) ";



//             $meQuery = $conn->prepare($query);
//             $meQuery->execute();
//             $meQuery2 = $conn->prepare($query2);
//             $meQuery2->execute();


//             $queryE = " SELECT
//                             users.ID 
//                         FROM
//                             users
//                         WHERE users.EmpCode = '$input_empcodeUser' AND users.UserName = '$input_userName' AND users.Password = '$input_passWord' ";
//             $meQueryE = $conn->prepare($queryE);
//             $meQueryE->execute();
//             while ($rowE = $meQueryE->fetch(PDO::FETCH_ASSOC)) {
//                 $_ID = $rowE['ID'];
//             }

//             if ($IsAdmin_new == 1) {
//                 $insertSql = "INSERT INTO config_menu (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
//                 VALUES (:userID,1,1,1,1,1,1,1,1,1,1,1)";
//                 $insertStmt = $conn->prepare($insertSql);
//                 $insertStmt->bindParam(':userID', $_ID);
//                 $insertStmt->execute();
//             } else {
//                 $insertSql = "INSERT INTO config_menu (userID,main,recieve_stock,create_request,request_item,set_hn,pay,hn,movement,manage,report,permission) 
//                 VALUES (:userID,1,1,1,1,1,1,1,1,0,1,0)";
//                 $insertStmt = $conn->prepare($insertSql);
//                 $insertStmt->bindParam(':userID', $_ID);
//                 $insertStmt->execute();
//             }





//             $query3 = "INSERT INTO user_cabinet ( user_id ) 
//             VALUES             ('$_ID' ) ";
//             $meQuery3 = $conn->prepare($query3);
//             $meQuery3->execute();
//         } else {
//             $queryE = " SELECT
//                             employee.ID ,
//                             users.EmpCode,
//                             users.UserName
//                         FROM
//                             users
//                             INNER JOIN employee ON users.EmpCode = employee.EmpCode
//                         WHERE users.ID = '$input_IDUser' ";
//             $meQueryE = $conn->prepare($queryE);
//             $meQueryE->execute();
//             while ($rowE = $meQueryE->fetch(PDO::FETCH_ASSOC)) {
//                 $emID = $rowE['ID'];
//                 $_EmpCode = $rowE['EmpCode'];
//                 $_UserName = $rowE['UserName'];
//             }

//             if ($_EmpCode != $input_empcodeUser && $_UserName != $input_userName) {
//                 $query = "UPDATE users SET IsFingerPrint1 = $select_user_rfid , IsFingerPrint2 = $select_user_weighing ,  IsAdmin = $IsAdmin_new ,  EmpCode = '$input_empcodeUser' , UserName = '$input_userName' , Password = '$input_passWord' , IsCancel = $IsCancel , permission = '$select_permission'
//                     WHERE ID = '$input_IDUser'  ";

//                 $query2 = "UPDATE employee SET IsAdmin = $IsAdmin_new , EmpCode = '$input_empcodeUser' , FirstName = '$input_nameUser' , LastName = '$input_lastUser'
//             WHERE ID = '$emID'  ";

//                 $meQuery = $conn->prepare($query);
//                 $meQuery->execute();
//                 $meQuery2 = $conn->prepare($query2);
//                 $meQuery2->execute();


//                 if ($IsAdmin_new == 1) {
//                     $updateSql = "UPDATE config_menu SET 
//                                 main=1, recieve_stock=1, create_request=1, request_item=1, 
//                                 set_hn=1, pay=1, hn=1, movement=1, manage=1, report=1, permission=1
//                                 WHERE userID = :userID";
//                     $updateStmt = $conn->prepare($updateSql);
//                     $updateStmt->bindParam(':userID', $input_IDUser);
//                     $updateStmt->execute();
//                 } else {
//                     $updateSql = "UPDATE config_menu SET 
//                                 main=1, recieve_stock=1, create_request=1, request_item=1, 
//                                 set_hn=1, pay=1, hn=1, movement=1, manage=0, report=1, permission=0
//                                 WHERE userID = :userID";
//                     $updateStmt = $conn->prepare($updateSql);
//                     $updateStmt->bindParam(':userID', $input_IDUser);
//                     $updateStmt->execute();
//                 }


//                 echo "insert success";
//                 unset($conn);
//                 die;
//             } else {
//                 $count_id = 3;
//                 echo $count_id;
//                 unset($conn);
//                 die;
//             }
//         }
//     } else {
//         echo $count_id;
//         unset($conn);
//         die;
//     }
// }

function feeddata_detailUser($conn, $db)
{
    $return = array();


    $query = " SELECT
                    u.ID,
                    u.EmpCode,
                    e.FirstName,
                    e.LastName,
                    u.UserName,
                    u.`Password` AS xxx,
                    u.IsCancel,
                    u.DeptID,
                CASE
                        
                        WHEN u.permission IS NULL THEN
                        '' ELSE u.permission 
                    END AS permission,
                    u.IsAdmin,
                    ( SELECT GROUP_CONCAT( cabinet_id ORDER BY cabinet_id SEPARATOR ',' ) FROM user_cabinet WHERE user_id = u.ID ) AS cabinet_ids 
                FROM
                    users u
                    INNER JOIN employee e ON u.EmpCode = e.EmpCode ";
    // echo $query;
    // exit;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (!is_null($row['cabinet_ids']) && str_contains($row['cabinet_ids'], ',')) {
            $row['cabinet_ids'] = 'button';
        }
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


    $count_id = 0;
    // if ($input_IDdoctor == "") {
    $check_d = "    SELECT ID
                        FROM   doctor 
                        WHERE Doctor_Name = '$input_doctorth' ";
    $meQuery_d = $conn->prepare($check_d);
    $meQuery_d->execute();
    while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
        $count_id++;
    }
    // }

    if ($count_id == 0) {
        if ($input_IDdoctor == "") {
            $query = "INSERT INTO `doctor` ( Doctor_Name , IsActive) 
            VALUES             ('$input_doctorth' , $IsActive ) ";
        } else {
            $query = "UPDATE `doctor` SET Doctor_Name = '$input_doctorth' , IsActive = $IsActive WHERE ID = '$input_IDdoctor'  ";
        }



        $meQuery = $conn->prepare($query);
        $meQuery->execute();

        echo "insert success";
        unset($conn);
        die;
    } else {
        echo "xxxx";
        unset($conn);
        die;
    }
}

function feeddata_detailDoctor($conn, $db)
{
    $return = array();

    $query = " SELECT
                     `doctor`.ID,
                     `doctor`.Doctor_Name,
                     `doctor`.IsActive
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


function deleteDepartment($conn)
{
    $ID = $_POST['ID'];

    $query = "DELETE FROM department WHERE ID = '$ID' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    echo "delete success";
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

function saveDepartment($conn)
{
    $input_department = $_POST['input_department'];
    $input_IDdepartment = $_POST['input_IDdepartment'];
    $IsCancel = $_POST['IsCancel'];



    $count_id = 0;
    // if ($input_IDProcedure == "") {
    $check_d = "    SELECT ID
                        FROM   department 
                        WHERE DepName = '$input_department' ";
    $meQuery_d = $conn->prepare($check_d);
    $meQuery_d->execute();
    while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
        $count_id++;
    }
    // }


    if ($count_id == 0) {
        if ($input_IDdepartment == "") {
            $stmt = $conn->prepare("INSERT INTO department  (DepName , IsCancel) VALUES (?, ?)");
            $stmt->execute([$input_department, $IsCancel]);
        } else {
            $stmt = $conn->prepare("UPDATE `department` SET DepName = ? , IsCancel = ? WHERE ID = ?");
            $stmt->execute([$input_department,  $IsCancel, $input_IDdepartment]);
        }
        echo "insert success";
        unset($conn);
        die;
    } else {
        echo "xxxx";
        unset($conn);
        die;
    }
}

function saveProcedure($conn)
{
    $input_Procedure = $_POST['input_Procedure'];
    $input_IDProcedure = $_POST['input_IDProcedure'];
    $IsActive = $_POST['IsActive'];



    $count_id = 0;
    // if ($input_IDProcedure == "") {
    $check_d = "    SELECT ID
                        FROM   `procedure` 
                        WHERE Procedure_TH = '$input_Procedure' ";
    $meQuery_d = $conn->prepare($check_d);
    $meQuery_d->execute();
    while ($row_d = $meQuery_d->fetch(PDO::FETCH_ASSOC)) {
        $count_id++;
    }
    // }


    if ($count_id == 0) {
        if ($input_IDProcedure == "") {
            $stmt = $conn->prepare("INSERT INTO `procedure` (Procedure_TH, Procedure_EN, IsActive) VALUES (?, ?, ?)");
            $stmt->execute([$input_Procedure, $input_Procedure, $IsActive]);
        } else {
            $stmt = $conn->prepare("UPDATE `procedure` SET Procedure_TH = ?, Procedure_EN = ?, IsActive = ? WHERE ID = ?");
            $stmt->execute([$input_Procedure, $input_Procedure, $IsActive, $input_IDProcedure]);
        }
        echo "insert success";
        unset($conn);
        die;
    } else {
        echo "xxxx";
        unset($conn);
        die;
    }
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


function  feeddata_detailDepartment($conn, $db)
{
    $return = array();


    $query = " SELECT
                     department.ID,
                     department.DepName,
                     department.IsCancel
                FROM
                     department 
                WHERE IsAutomaticPayout = 0  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
