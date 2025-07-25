<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'check_hn') {
        check_hn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateConfirm') {
        onUpdateConfirm($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail') {
        show_detail($conn, $db);
    }
}

function show_detail($conn, $db)
{
    $return = array();
    $doc = $_POST['doc'];


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


    echo json_encode($return);
    unset($conn);
    die;
}
