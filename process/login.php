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

    if ($input_Scan != "") {
        if($input_UserName != "" && $input_PassWord !=""){
            $where = " WHERE  users.UserName = '$input_UserName' AND users.Password = '$input_PassWord' ";
        }else{
            $where = " WHERE  users.EmpCode = '$input_Scan' ";
        }
    } else {
        $where = " WHERE  users.UserName = '$input_UserName' AND users.Password = '$input_PassWord' ";
    }

    $query = "SELECT 
                users.ID,
                users.UserName AS UserName_login,
                users.Password,
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
             $where  AND users.IsCancel = 0  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['UserName_login'] = $row['UserName_login'];
        $_SESSION['Password'] = $row['Password'];

        $_SESSION['Userid'] = $row['ID'];
        $_SESSION['B_ID'] = $row['B_ID'];
        $_SESSION['DepID'] = $row['DepID'];
        $_SESSION['Lang'] = $row['Lang'];
        $_SESSION['display'] = $row['display'];
        $_SESSION['IsSound'] = $row['IsSound'];
        $_SESSION['font'] = $row['font'];
        $_SESSION['RefDepID'] = $row['RefDepID'];
        $_SESSION['UserName'] = $row['UserName'];
        $_SESSION['DepName2'] = $row['DepName2'];
        $_SESSION['IsAdmin'] = $row['IsAdmin'];
        $_SESSION['EmpCode'] = $row['EmpCode'];
        $_SESSION['time_out'] = $row['time_out'];
        $_SESSION['permission'] = $row['permission'];
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

        
    }


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
                                departmentroom.id = '$select_departmentRoom' ";
        } else {



            $selectName = "SELECT
                                departmentroom.departmentroomname,
                                ISNULL( doctor.ID, 0 ) AS doctorID,
                                ISNULL( doctor.Doctor_Name_EN, '' ) AS Doctor_Name 
                            FROM
                                departmentroom
                                LEFT JOIN doctor ON departmentroom.doctorID = doctor.ID 
                            WHERE
                                departmentroom.id = '$select_departmentRoom' ";
        }

        $meQueryName = $conn->prepare($selectName);
        $meQueryName->execute();
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

    $exsoon = " SELECT
                    configuration_dental.GN_WarningExpiringSoonDay 
                FROM
                    configuration_dental ";
    $meQueryexsoon = $conn->prepare($exsoon);
    $meQueryexsoon->execute();
    while ($rowexsoon = $meQueryexsoon->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['GN_WarningExpiringSoonDay'] = $rowexsoon['GN_WarningExpiringSoonDay'];
    }


    echo json_encode($return);
    unset($conn);
    die;
}


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
