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
    }
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
    $input_IDDeproom = $_POST['input_IDDeproom'];
    $IsActive = $_POST['IsActive'];

    $IsAdmin = 0;



    if ($input_IDDeproom == "") {
        $query = "INSERT INTO departmentroom ( departmentroomname ,  floor_id ,  IsActive  ,  departmentroomname_EN ,  IsMainroom   ) 
        VALUES             ('$input_DeproomNameTH'  , '$input_DeproomFloor'  , $IsActive , '$input_DeproomNameEN'  , 0 ) ";
    } else {
        $query = "UPDATE departmentroom SET   departmentroomname = '$input_DeproomNameTH' , floor_id = $input_DeproomFloor , IsActive = $IsActive , departmentroomname_EN = '$input_DeproomNameEN'
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
                    departmentroom.departmentroomname_EN 
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
        $query = "INSERT INTO `procedure` ( Procedure_TH , Procedure_EN, IsActive ) 
        VALUES             ('$input_Procedure'  , '$input_Procedure' , '$IsActive' ) ";
    } else {
        $query = "UPDATE `procedure` SET Procedure_TH = '$input_Procedure' , IsActive = '$IsActive'  WHERE ID = '$input_IDProcedure'  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
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
