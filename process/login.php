<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'selection_departmentRoom') {
        selection_departmentRoom($conn);
    } else if ($_POST['FUNC_NAME'] == 'LoginUser') {
        LoginUser($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_Doctor') {
        selection_Doctor($conn);
    } else if ($_POST['FUNC_NAME'] == 'ResetPassword') {
        ResetPassword($conn);
    }
}

function ResetPassword($conn)
{
    $identity    = trim($_POST['identity']);      // UserName
    $newPassword = (string)($_POST['new_password']);

    // validate
    if ($identity === '') {
        echo "invalid_identity";
        unset($conn);
        die;
    }
    if (mb_strlen($newPassword) < 8) {
        echo "invalid_password";
        unset($conn);
        die;
    }

    try {
        // หา user จาก UserName (คุณบอกว่าใช้ username อย่างเดียว)
        $stmt = $conn->prepare("SELECT ID, UserName, IsCancel FROM users WHERE UserName = :u LIMIT 1");
        $stmt->execute([':u' => $identity]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || (int)$user['IsCancel'] === 1) {
            echo "notfound";
            unset($conn);
            die;
        }

        // hash (PHP 8.2 / Argon2id)
        $hash = password_hash($newPassword, PASSWORD_ARGON2ID, [
            'memory_cost' => 1 << 16, // 64MB
            'time_cost'   => 4,
            'threads'     => 2,
        ]);

        if ($hash === false) {
            echo "error_hash";
            unset($conn);
            die;
        }

        // update
        $upd = $conn->prepare("UPDATE users SET Password = :p WHERE ID = :id");
        $upd->execute([
            ':p'  => $hash,
            ':id' => $user['ID']
        ]);

        // (optional) log activity เหมือน login (กำหนด isStatus ใหม่ เช่น 98)
        $insert_log = "INSERT INTO log_activity_users (itemCode, itemstockID ,qty, isStatus, DocNo, userID, createAt)
                       VALUES ('', 0, 0, :isStatus, '', :Userid, NOW())";
        $meQuery_log = $conn->prepare($insert_log);
        $meQuery_log->bindValue(':isStatus', 98, PDO::PARAM_INT); // 98 = reset password (กำหนดเอง)
        $meQuery_log->bindValue(':Userid', (int)$user['ID'], PDO::PARAM_INT);
        $meQuery_log->execute();

        echo "success";
        unset($conn);
        die;
    } catch (Exception $e) {
        echo "error";
        unset($conn);
        die;
    }
}



function selection_Doctor($conn)
{
    $return = array();
    // $deproom = $_SESSION['deproom'];


    $query = "SELECT
                    doctor.ID,
                    ISNULL(CONCAT(doctor.Doctor_Name_EN, ' : ' , doctor.Doctor_Code ), '') AS Doctor_Name 
                FROM
                    doctor 
                WHERE
                    doctor.IsActive = 1 
                ORDER BY doctor.Doctor_Name_EN ASC ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_departmentRoom($conn)
{
    $return = array();

    $query = " SELECT
                    departmentroom.id,
                    departmentroom.departmentroomname 
                FROM
                    departmentroom
                WHERE departmentroom.iscancel = 0
                AND departmentroom.IsActive = 1 
                AND departmentroom.IsMainroom = 0
                ORDER BY departmentroom.floor_id , departmentroom.id  ASC  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function LoginUser($conn, $db)
{
    $return = array();
    $input_UserName = $_POST['input_UserName'];
    $input_PassWord = $_POST['input_PassWord'];
    $input_Scan = $_POST['input_Scan'];
    $select_departmentRoom = $_POST['select_departmentRoom'];
    $count = 0;
    $IsAdmin = 0;

    // -------------------------------
    // สร้าง WHERE + params (เดิมใช้ string ต่อ SQL)
    // -------------------------------
    $where = "";
    $params = [];

    if ($input_Scan != "") {
        if ($input_UserName != "" && $input_PassWord != "") {
            // มี user+pass + scan -> หา user ก่อน แล้วค่อย verify pass
            $where = " WHERE users.UserName = :uname ";
            $params[':uname'] = $input_UserName;
        } else {
            // scan อย่างเดียว -> หา EmpCode
            $where = " WHERE users.EmpCode = :emp ";
            $params[':emp'] = $input_Scan;
        }
    } else {
        // ไม่ scan -> หา user ก่อน แล้วค่อย verify pass
        $where = " WHERE users.UserName = :uname ";
        $params[':uname'] = $input_UserName;
    }

    $query = "SELECT 
                users.ID,
                users.UserName AS UserName_login,
                users.Password,             -- เก็บ hash
                users.time_out,
                users.permission,
                permission.Permission,
                users.B_ID,
                users.Lang,
                users.IsSound,
                users.display,
                users.font,
                employee.DepID,
                CONCAT ( 'คุณ ', employee.FirstName , ' ', employee.LastName ) AS UserName,
                department.DepName2,
                department.RefDepID,
                employee.IsAdmin,
                employee.EmpCode 
            FROM
                users
                LEFT JOIN employee ON users.EmpCode = employee.EmpCode
                LEFT JOIN permission ON permission.PmID = users.permission
                LEFT JOIN department ON department.ID = employee.DepID
            $where
            AND users.IsCancel = 0
            LIMIT 1";

    $meQuery = $conn->prepare($query);
    $meQuery->execute($params);
    $row = $meQuery->fetch(PDO::FETCH_ASSOC);

    // ไม่พบ user -> return []
    if (!$row) {
        echo json_encode($return);
        unset($conn);
        die;
    }

    // -------------------------------
    // ตรวจรหัสผ่าน (เฉพาะกรณีที่มีการส่ง password มา)
    // - กรณี scan อย่างเดียว (ไม่ส่ง user/pass) -> อนุญาตผ่านเหมือนเดิม
    // -------------------------------
    $needVerify = false;

    if ($input_Scan != "") {
        if ($input_UserName != "" && $input_PassWord != "") {
            $needVerify = true;
        } else {
            $needVerify = false; // scan อย่างเดียว = ผ่านเหมือนเดิม
        }
    } else {
        $needVerify = true; // ไม่ scan -> ต้อง verify
    }

    if ($needVerify) {
        // ถ้าไม่ได้กรอกรหัสมา ให้ fail
        if (trim($input_PassWord) === '') {
            echo json_encode($return);
            unset($conn);
            die;
        }

        // ตรวจ password แบบ hash
        if (!password_verify($input_PassWord, $row['Password'])) {
            echo json_encode($return);
            unset($conn);
            die;
        }

        // (ไม่บังคับ) อัปเกรด hash ถ้าต้องการ
        if (password_needs_rehash($row['Password'], PASSWORD_ARGON2ID, [
            'memory_cost' => 1 << 16,
            'time_cost'   => 4,
            'threads'     => 2,
        ])) {
            $newHash = password_hash($input_PassWord, PASSWORD_ARGON2ID, [
                'memory_cost' => 1 << 16,
                'time_cost'   => 4,
                'threads'     => 2,
            ]);
            $upd = $conn->prepare("UPDATE users SET Password = :p WHERE ID = :id");
            $upd->execute([':p' => $newHash, ':id' => $row['ID']]);

            // อัปเดตค่าในตัวแปรด้วย (กัน session เก็บของเก่า)
            $row['Password'] = $newHash;
        }
    }

    // -------------------------------
    // ผ่านแล้ว: ทำเหมือนเดิม
    // -------------------------------
    $_SESSION['UserName_login'] = $row['UserName_login'];
    $_SESSION['Password']       = $row['Password']; // เก็บ hash ตามเดิม (แนะนำไม่ต้องเก็บ แต่คงไว้ให้เหมือนเดิม)

    $_SESSION['Userid']      = $row['ID'];
    $_SESSION['B_ID']        = $row['B_ID'];
    $_SESSION['DepID']       = $row['DepID'];
    $_SESSION['Lang']        = $row['Lang'];
    $_SESSION['display']     = $row['display'];
    $_SESSION['IsSound']     = $row['IsSound'];
    $_SESSION['font']        = $row['font'];
    $_SESSION['RefDepID']    = $row['RefDepID'];
    $_SESSION['UserName']    = $row['UserName'];
    $_SESSION['DepName2']    = $row['DepName2'];
    $_SESSION['IsAdmin']     = $row['IsAdmin'];
    $_SESSION['EmpCode']     = $row['EmpCode'];
    $_SESSION['time_out']    = $row['time_out'];
    $_SESSION['permission']  = $row['permission'];
    $_SESSION['Permission_name'] = $row['Permission'];

    $IsAdmin = $row['IsAdmin'];

    $return[] = $row;
    $count++;

    $insert_log = "INSERT INTO log_activity_users (itemCode, itemstockID ,qty, isStatus, DocNo, userID, createAt) 
                   VALUES ('', 0, 0, :isStatus, '', :Userid, NOW())";
    $meQuery_log = $conn->prepare($insert_log);
    $meQuery_log->bindValue(':isStatus', 99, PDO::PARAM_INT);
    $meQuery_log->bindParam(':Userid', $row['ID']);
    $meQuery_log->execute();

    // -------------------------------
    // ส่วน departmentroom เดิม (คงไว้)
    // -------------------------------
    $_departmentroomname = "";
    $_doctorID = "";
    $_Doctor_Name = "";

    if ($select_departmentRoom != "") {

        if ($db == 1) {
            $selectName = "SELECT
                                departmentroom.departmentroomname,
                                IFNULL( doctor.ID, 0 ) AS doctorID,
                                IFNULL( doctor.Doctor_Name_EN, '' ) AS Doctor_Name 
                            FROM
                                departmentroom
                                LEFT JOIN doctor ON departmentroom.doctorID = doctor.ID 
                            WHERE
                                departmentroom.id = :dep ";
        } else {
            $selectName = "SELECT
                                departmentroom.departmentroomname,
                                ISNULL( doctor.ID, 0 ) AS doctorID,
                                ISNULL( doctor.Doctor_Name_EN, '' ) AS Doctor_Name 
                            FROM
                                departmentroom
                                LEFT JOIN doctor ON departmentroom.doctorID = doctor.ID 
                            WHERE
                                departmentroom.id = :dep ";
        }

        $meQueryName = $conn->prepare($selectName);
        $meQueryName->execute([':dep' => $select_departmentRoom]);
        while ($rowName = $meQueryName->fetch(PDO::FETCH_ASSOC)) {
            $_departmentroomname = $rowName['departmentroomname'];
            $_doctorID = $rowName['doctorID'];
            $_Doctor_Name = $rowName['Doctor_Name'];
        }
    }

    if ($IsAdmin == '1') {
        if ($select_departmentRoom != "") {
            $_SESSION['departmentroomname'] = $_departmentroomname;
            $_SESSION['deproom'] = $select_departmentRoom;
        } else {
            $_SESSION['departmentroomname'] = "คลังห้องผ่าตัด";
            $_SESSION['deproom'] = '0';
        }
        $_SESSION['Doctor_Name'] = "";
        $_SESSION['doctorID'] = "0";
    } else {
        $_SESSION['departmentroomname'] = $_departmentroomname;
        $_SESSION['Doctor_Name'] = $_Doctor_Name;
        $_SESSION['doctorID'] = $_doctorID;
        $_SESSION['deproom'] = $select_departmentRoom;
    }

    $exsoon = "SELECT configuration_dental.GN_WarningExpiringSoonDay FROM configuration_dental";
    $meQueryexsoon = $conn->prepare($exsoon);
    $meQueryexsoon->execute();
    while ($rowexsoon = $meQueryexsoon->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['GN_WarningExpiringSoonDay'] = $rowexsoon['GN_WarningExpiringSoonDay'];
    }

    echo json_encode($return);
    unset($conn);
    die;
}


// function LoginUser($conn, $db)
// {
//     $return = array();
//     $input_UserName = $_POST['input_UserName'];
//     $input_PassWord = $_POST['input_PassWord'];
//     $input_Scan = $_POST['input_Scan'];
//     $select_departmentRoom = $_POST['select_departmentRoom'];
//     $count = 0;
//     $IsAdmin = 0;

//     if ($input_Scan != "") {
//         if($input_UserName != "" && $input_PassWord !=""){
//             $where = " WHERE  users.UserName = '$input_UserName' AND users.Password = '$input_PassWord' ";
//         }else{
//             $where = " WHERE  users.EmpCode = '$input_Scan' ";
//         }
//     } else {
//         $where = " WHERE  users.UserName = '$input_UserName' AND users.Password = '$input_PassWord' ";
//     }

//     $query = "SELECT 
//                 users.ID,
//                 users.UserName AS UserName_login,
//                 users.Password,
//                 users.time_out,
//                 users.permission,
//                 permission.Permission,
//                 users.B_ID,
//                 users.Lang,
//                 users.IsSound,
//                 users.display,
//                 users.font,
//                 employee.DepID,
//                 CONCAT ( 'คุณ ', employee.FirstName , ' ', employee.LastName ) AS UserName,
//                 department.DepName2,
//                 department.RefDepID,
//                 employee.IsAdmin,
//                 employee.EmpCode 
//             FROM
//                 users
//                 LEFT JOIN employee ON users.EmpCode = employee.EmpCode
//                 LEFT JOIN permission ON permission.PmID = users.permission
//                 LEFT JOIN department ON department.ID = employee.DepID 
//              $where  AND users.IsCancel = 0  ";


//     $meQuery = $conn->prepare($query);
//     $meQuery->execute();
//     while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
//         $_SESSION['UserName_login'] = $row['UserName_login'];
//         $_SESSION['Password'] = $row['Password'];

//         $_SESSION['Userid'] = $row['ID'];
//         $_SESSION['B_ID'] = $row['B_ID'];
//         $_SESSION['DepID'] = $row['DepID'];
//         $_SESSION['Lang'] = $row['Lang'];
//         $_SESSION['display'] = $row['display'];
//         $_SESSION['IsSound'] = $row['IsSound'];
//         $_SESSION['font'] = $row['font'];
//         $_SESSION['RefDepID'] = $row['RefDepID'];
//         $_SESSION['UserName'] = $row['UserName'];
//         $_SESSION['DepName2'] = $row['DepName2'];
//         $_SESSION['IsAdmin'] = $row['IsAdmin'];
//         $_SESSION['EmpCode'] = $row['EmpCode'];
//         $_SESSION['time_out'] = $row['time_out'];
//         $_SESSION['permission'] = $row['permission'];
//         $_SESSION['Permission_name'] = $row['Permission'];


//         $IsAdmin = $row['IsAdmin'];

//         $return[] = $row;
//         $count++;


//         $insert_log = "INSERT INTO log_activity_users (itemCode, itemstockID ,qty, isStatus, DocNo, userID, createAt) 
//                         VALUES ('', 0, 0, :isStatus, '', :Userid, NOW())";

//         $meQuery_log = $conn->prepare($insert_log);

//         $meQuery_log->bindValue(':isStatus', 99, PDO::PARAM_INT);
//         $meQuery_log->bindParam(':Userid', $row['ID']);


//         $meQuery_log->execute();


//     }


//     $_departmentroomname = "";
//     $_doctorID = "";
//     $_Doctor_Name = "";

//     if ($select_departmentRoom != "") {

//         if ($db == 1) {
//             $selectName = "SELECT
//                                 departmentroom.departmentroomname,
//                                 IFNULL( doctor.ID, 0 ) AS doctorID,
//                                 IFNULL( doctor.Doctor_Name_EN, '' ) AS Doctor_Name 
//                             FROM
//                                 departmentroom
//                                 LEFT JOIN doctor ON departmentroom.doctorID = doctor.ID 
//                             WHERE
//                                 departmentroom.id = '$select_departmentRoom' ";
//         } else {



//             $selectName = "SELECT
//                                 departmentroom.departmentroomname,
//                                 ISNULL( doctor.ID, 0 ) AS doctorID,
//                                 ISNULL( doctor.Doctor_Name_EN, '' ) AS Doctor_Name 
//                             FROM
//                                 departmentroom
//                                 LEFT JOIN doctor ON departmentroom.doctorID = doctor.ID 
//                             WHERE
//                                 departmentroom.id = '$select_departmentRoom' ";
//         }

//         $meQueryName = $conn->prepare($selectName);
//         $meQueryName->execute();
//         while ($rowName = $meQueryName->fetch(PDO::FETCH_ASSOC)) {
//             $_departmentroomname = $rowName['departmentroomname'];
//             $_doctorID = $rowName['doctorID'];
//             $_Doctor_Name = $rowName['Doctor_Name'];
//         }
//     }




//     if ($IsAdmin == '1') {
//         if ($select_departmentRoom != "") {
//             $_SESSION['departmentroomname'] = $_departmentroomname;
//             $_SESSION['deproom'] = $select_departmentRoom;
//         } else {
//             $_SESSION['departmentroomname'] = "คลังห้องผ่าตัด";
//             $_SESSION['deproom'] = '0';
//         }
//         $_SESSION['Doctor_Name'] = "";
//         $_SESSION['doctorID'] = "0";
//     } else {
//         $_SESSION['departmentroomname'] = $_departmentroomname;
//         $_SESSION['Doctor_Name'] = $_Doctor_Name;
//         $_SESSION['doctorID'] = $_doctorID;
//         $_SESSION['deproom'] = $select_departmentRoom;
//     }

//     $exsoon = " SELECT
//                     configuration_dental.GN_WarningExpiringSoonDay 
//                 FROM
//                     configuration_dental ";
//     $meQueryexsoon = $conn->prepare($exsoon);
//     $meQueryexsoon->execute();
//     while ($rowexsoon = $meQueryexsoon->fetch(PDO::FETCH_ASSOC)) {
//         $_SESSION['GN_WarningExpiringSoonDay'] = $rowexsoon['GN_WarningExpiringSoonDay'];
//     }


//     echo json_encode($return);
//     unset($conn);
//     die;
// }


function LoginUser_api()
{
    $return = array();
    $input_UserName = $_POST['input_UserName'];
    $input_PassWord = $_POST['input_PassWord'];
    $select_departmentRoom = $_POST['select_departmentRoom'];
    $count = 0;
    $IsAdmin = 0;

    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'http://110.170.51.71/API_CSSD/api/Authentication',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username": "pose",
                "password": "VTN@pose"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;


    if ($IsAdmin == '1') {
        $_SESSION['deproom'] = '0';
    } else {
        $_SESSION['deproom'] = $select_departmentRoom;
    }



    echo json_encode($return);
    unset($conn);
    die;
}
