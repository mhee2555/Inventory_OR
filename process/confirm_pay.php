<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'check_hn') {
        check_hn($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'onUpdateConfirm') {
        onUpdateConfirm($conn, $db);
    }
}

function onUpdateConfirm($conn, $db)
{
    $return = array();
    $doc = $_POST['doc'];
    $select_users = $_POST['select_users'];

    
    $query = "UPDATE deproom SET IsConfirm_pay = 1 , userConfirm_pay = $select_users WHERE DocNo ='$doc' ";

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


    $query = "  SELECT
                    deproom.hn_record_id, 
                    deproom.DocNo, 
                    deproom.`procedure`, 
                    deproom.doctor,
                    doctor.Doctor_Name,
                   `procedure`.Procedure_TH,
                   IsConfirm_pay
                FROM
                    deproom 
                INNER JOIN doctor ON doctor.ID = deproom.doctor
                INNER JOIN `procedure` ON deproom.`procedure` = `procedure`.ID
                WHERE deproom.DocNo =  '$doc' ";

    // echo $query;
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

