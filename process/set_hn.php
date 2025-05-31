<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'save_hn') {
        save_hn($conn, $db);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_history') {
        show_detail_history($conn, $db);
    }
}

function show_detail_history($conn, $db)
{
    $return = array();
    $select_date1_search = $_POST['select_date1_search'];
    $select_date2_search = $_POST['select_date2_search'];

    $select_date1_search = explode("-", $select_date1_search);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];
    $select_date2_search = explode("-", $select_date2_search);
    $select_date2_search = $select_date2_search[2] . '-' . $select_date2_search[1] . '-' . $select_date2_search[0];



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
                AND DATE( set_hn.createAt ) BETWEEN '$select_date1_search' 	AND '$select_date2_search' 
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

function save_hn($conn, $db)
{
    $return = array();

    $input_Hn_ID = $_POST['input_Hn_ID'];
    $input_Hn_pay_manual = $_POST['input_Hn_pay_manual'];
    $input_date_service_manual = $_POST['input_date_service_manual'];
    $input_time_service_manual = $_POST['input_time_service_manual'];
    $input_remark_manual = $_POST['input_remark_manual'];
    $select_deproom_manual = $_POST['select_deproom_manual'];
    $procedure_id_Array = $_POST['procedure_id_Array'];
    $doctor_Array = $_POST['doctor_Array'];



    $input_date_service_manual = explode("-", $input_date_service_manual);
    $input_date_service_manual = $input_date_service_manual[2] . '-' . $input_date_service_manual[1] . '-' . $input_date_service_manual[0];


    $procedure_id_Array = implode(",", $procedure_id_Array);
    $doctor_Array = implode(",", $doctor_Array);

    $Userid = $_SESSION['Userid'];


    if($input_Hn_ID == ""){
        $insert_log = "INSERT INTO set_hn (hncode, serviceDate, doctor, departmentroomid, `procedure`, remark, isStatus, userID, createAt) 
                            VALUES (:hncode, '$input_date_service_manual $input_time_service_manual' , :doctor, :departmentroomid, :proceduce, :remark,0, :Userid, NOW())";

        $meQuery_log = $conn->prepare($insert_log);

        $meQuery_log->bindParam(':hncode', $input_Hn_pay_manual);
        $meQuery_log->bindParam(':doctor', $doctor_Array);
        $meQuery_log->bindParam(':departmentroomid', $select_deproom_manual);
        $meQuery_log->bindParam(':proceduce', $procedure_id_Array);
        $meQuery_log->bindParam(':remark', $input_remark_manual);
        $meQuery_log->bindParam(':Userid', $Userid);


        $meQuery_log->execute();
    }else{
        $insert_log = "UPDATE set_hn SET hncode = :hncode,
                                         serviceDate = '$input_date_service_manual $input_time_service_manual' ,
                                          doctor = :doctor, 
                                          departmentroomid = :departmentroomid, 
                                          `procedure` = :proceduce, 
                                          remark = :remark, 
                                          userID = :Userid, 
                                          createAt = NOW() 
                        WHERE ID = '$input_Hn_ID' ";

        $meQuery_log = $conn->prepare($insert_log);

        $meQuery_log->bindParam(':hncode', $input_Hn_pay_manual);
        $meQuery_log->bindParam(':doctor', $doctor_Array);
        $meQuery_log->bindParam(':departmentroomid', $select_deproom_manual);
        $meQuery_log->bindParam(':proceduce', $procedure_id_Array);
        $meQuery_log->bindParam(':remark', $input_remark_manual);
        $meQuery_log->bindParam(':Userid', $Userid);


        $meQuery_log->execute();
    }






    echo json_encode($return);
    unset($conn);
    die;
}
