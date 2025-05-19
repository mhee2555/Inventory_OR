<?php
session_start();
require '../../config/db.php';
require '../../connect/connect.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'select_deproom') {
        select_deproom($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_doctor') {
        select_doctor($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_procedure') {
        select_procedure($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_sterileprocess') {
        select_sterileprocess($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_typeDocument') {
        select_typeDocument($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_type') {
        select_type($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_floor') {
        select_floor($conn);
    } else if ($_POST['FUNC_NAME'] == 'set_deproom') {
        set_deproom($conn);
    } else if ($_POST['FUNC_NAME'] == 'set_proceduce') {
        set_proceduce($conn);
    } else if ($_POST['FUNC_NAME'] == 'set_users') {
        set_users($conn);
    } else if ($_POST['FUNC_NAME'] == 'select_item') {
        select_item($conn);
    } else if ($_POST['FUNC_NAME'] == 'set_doctor') {
        set_doctor($conn);
    } else if ($_POST['FUNC_NAME'] == 'set_deproom_proceduce') {
        set_deproom_proceduce($conn);
    }
}

function set_users($conn)
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


function set_doctor($conn)
{
    $return = array();



    $select_deproom_request = $_POST['select_deproom_request'];

    if ($select_deproom_request != "") {
        $doctor_ids = "";
        $count_doctor = 0;
        $select = " SELECT GROUP_CONCAT(doctor_id SEPARATOR ', ') AS doctor_ids FROM mapping_doctor WHERE mapping_doctor.departmentroom_id LIKE '%$select_deproom_request%'  ";
        $meQuery_select = $conn->prepare($select);
        $meQuery_select->execute();



        $doctor_ids = $meQuery_select->fetchColumn();


        if ($doctor_ids) {

            $query = " SELECT
                                ID,
                                Doctor_Name 
                            FROM
                                `doctor` 
                            WHERE `doctor`.ID IN ($doctor_ids)
                            AND `doctor`.IsActive = 1
                            ORDER BY
                                Doctor_Name ASC  ";
        } else {
            $query = " SELECT
                                ID,
                                Doctor_Name 
                            FROM
                                `doctor` 
                            WHERE `doctor`.IsActive = 1
                            ORDER BY
                                Doctor_Name ASC  ";
        }
    } else {
        $query = " SELECT
                        ID,
                        Doctor_Name 
                    FROM
                        `doctor` 
                    WHERE `doctor`.IsActive = 1
                    ORDER BY
                        Doctor_Name ASC  ";
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

function set_proceduce($conn)
{
    $return = array();



    $select_deproom_request = $_POST['select_deproom_request'];

    if ($select_deproom_request != "") {
        $departmentroom_ids = "";
        $count_doctor = 0;
        $select = " SELECT GROUP_CONCAT(procedure_id SEPARATOR ', ') AS procedure_ids FROM mapping_departmentroom WHERE mapping_departmentroom.departmentroom_id IN( $select_deproom_request )  ";
        $meQuery_select = $conn->prepare($select);
        $meQuery_select->execute();

        $procedure_ids = $meQuery_select->fetchColumn();

 

        if ($procedure_ids) {

            $query = " SELECT
                                ID,
                                Procedure_TH 
                            FROM
                                `procedure` 
                            WHERE `procedure`.ID IN ($procedure_ids)
                            AND `procedure`.IsActive = 1
                            ORDER BY
                                Procedure_TH ASC  ";
        } else {
            $query = " SELECT
                                ID,
                                Procedure_TH 
                            FROM
                                `procedure` 
                            WHERE `procedure`.IsActive = 1
                            ORDER BY
                                Procedure_TH ASC  ";
        }
    } else {
        $query = " SELECT
                        ID,
                        Procedure_TH 
                    FROM
                        `procedure` 
                    WHERE `procedure`.IsActive = 1
                    ORDER BY
                        Procedure_TH ASC  ";
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

function set_deproom_proceduce($conn)
{
    $return = array();

    $procedure_id_Array = "''";
    if (isset($_POST['procedure_id_Array'])) {
        $procedure_id_Array = $_POST['procedure_id_Array'];
        $procedure_id_Array = implode(",", $procedure_id_Array);
    }



    $departmentroom_ids = "";
    $count_doctor = 0;
    $select = " SELECT GROUP_CONCAT(departmentroom_id SEPARATOR ', ') AS departmentroom_ids FROM mapping_departmentroom WHERE mapping_departmentroom.procedure_id IN( $procedure_id_Array )  ";

   
    $meQuery_select = $conn->prepare($select);
    $meQuery_select->execute();



    if($procedure_id_Array != "''"){
        $departmentroom_ids = $meQuery_select->fetchColumn();
    }

    if ($departmentroom_ids) {
        $query = "SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname 
                    FROM
                        departmentroom
                    WHERE departmentroom.id IN ($departmentroom_ids)
                    AND  departmentroom.IsActive = 1
                    ORDER BY departmentroomname ";
    } else {
        $query = "SELECT
                            departmentroom.id,
                            departmentroom.departmentroomname 
                        FROM
                            departmentroom
                        WHERE departmentroom.IsMainroom = 0
                        AND  departmentroom.IsActive = 1
                        ORDER BY departmentroomname ";
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
function set_deproom($conn)
{
    $return = array();

    $doctor_Array = "''";
    if (isset($_POST['doctor_Array'])) {
        $doctor_Array = $_POST['doctor_Array'];
        $doctor_Array = implode(",", $doctor_Array);
    }



    $departmentroom_ids = "";
    $count_doctor = 0;
    $select = " SELECT GROUP_CONCAT(departmentroom_id SEPARATOR ', ') AS departmentroom_ids FROM mapping_doctor WHERE mapping_doctor.doctor_id IN( $doctor_Array )  ";

   
    $meQuery_select = $conn->prepare($select);
    $meQuery_select->execute();



    if($doctor_Array != "''"){
        $departmentroom_ids = $meQuery_select->fetchColumn();
    }

    if ($departmentroom_ids) {
        $query = "SELECT
                        departmentroom.id,
                        departmentroom.departmentroomname 
                    FROM
                        departmentroom
                    WHERE departmentroom.id IN ($departmentroom_ids)
                    AND  departmentroom.IsActive = 1
                    ORDER BY departmentroomname ";
    } else {
        $query = "SELECT
                            departmentroom.id,
                            departmentroom.departmentroomname 
                        FROM
                            departmentroom
                        WHERE departmentroom.IsMainroom = 0
                        AND  departmentroom.IsActive = 1
                        ORDER BY departmentroomname ";
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

function select_floor($conn)
{
    $return = array();

    $query = "  SELECT
                    floor.ID,
                    floor.name_floor
                FROM
                    floor ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_type($conn)
{
    $return = array();

    $query = "  SELECT
                    itemtype.ID,
                    itemtype.TyeName
                FROM
                    itemtype ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
function select_typeDocument($conn)
{
    $return = array();

    $query = "  SELECT
                    document_type.ID,
                    document_type.DocumentType
                FROM
                    document_type ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_sterileprocess($conn)
{
    $return = array();

    $query = "  SELECT
                    sterileprocess.ID,
                    sterileprocess.SterileName
                FROM
                    sterileprocess ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_item($conn)
{
    $return = array();

    $query = "SELECT item.itemcode,
                     item.itemname
              FROM 
                    item  
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

function select_deproom($conn)
{
    $return = array();

    $query = "SELECT
                    departmentroom.id,
                    departmentroom.departmentroomname 
                FROM
                     departmentroom
                WHERE departmentroom.IsMainroom = 0
                AND  departmentroom.IsActive = 1
                ORDER BY departmentroomname ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_doctor($conn)
{
    $return = array();

    $query = "SELECT
                    doctor.ID,
                    doctor.Doctor_Name 
                FROM
                    doctor
                WHERE doctor.IsCancel = 0
                ORDER BY Doctor_Name ASC  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_procedure($conn, $db)
{
    $return = array();

    if ($db == 1) {
        $query = " SELECT
                        ID,
                        Procedure_TH 
                    FROM
                        `procedure` 
                    WHERE `procedure`.IsActive = 1
                    ORDER BY
                        Procedure_TH ASC  ";
    } else {
        $query = "SELECT
        [procedure].ID,
        [procedure].Procedure_TH 
    FROM
        [procedure]
    ORDER BY Procedure_TH ASC ";
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
