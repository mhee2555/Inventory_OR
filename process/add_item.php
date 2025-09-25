<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_daily') {
        show_detail_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item') {
        showDetail_item($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onChangePay') {
        onChangePay($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item2') {
        showDetail_item2($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_item3') {
        showDetail_item3($conn, $db);
    }
}

function onChangePay($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $deproom = $_SESSION['deproom'];



    $query = " UPDATE deproom SET IsAdditem = 2 WHERE  deproom.DocNo = '$DocNo' ";
    $query2 = " UPDATE deproomdetail SET Isaddnew = 2 WHERE  deproomdetail.DocNo = '$DocNo' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function showDetail_item3($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $deproom = $_SESSION['deproom'];



    $query = "SELECT
                    item.itemname,
                    deproomdetail.Qty 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                WHERE  deproom.DocNo = '$DocNo' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}


function showDetail_item2($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $deproom = $_SESSION['deproom'];



    $query = "SELECT
                    item.itemname,
                    deproomdetail.IsQtyStart AS Qty 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                WHERE  deproom.DocNo = '$DocNo' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function showDetail_item($conn, $db)
{
    $return = array();
    $DocNo = $_POST['DocNo'];
    $deproom = $_SESSION['deproom'];



    $query = "SELECT
                    item.itemname,
                    deproomdetail.IsQtyStart AS Qty  
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON deproomdetail.ItemCode = item.itemcode 
                WHERE  deproom.DocNo = '$DocNo'  AND deproomdetail.Isaddnew = 1 ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_daily($conn, $db)
{
    $return = array();
    $select_date1_search1 = $_POST['select_date1_search1'];
    $check_Box = $_POST['check_Box'];

    $select_date1_search = explode("-", $select_date1_search1);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];





    $whereD = "";
    if ($check_Box == 0) {
        $whereD = "  DATE( deproom.serviceDate ) = '$select_date1_search'  AND deproom.IsAdditem = 1 OR  deproom.IsAdditem = 2 OR  deproom.IsAdditem = 3    ";
    }
    if ($check_Box == 1) {
        $whereD = " deproom.IsAdditem = 1 ";
    }
    $Q1 = " SELECT
                deproom.DocNo, 
                DATE_FORMAT(deproom.serviceDate, '%d/%m/%Y' ) AS serviceDate, 
                deproom.hn_record_id, 
                deproom.number_box, 
                deproom.doctor, 
                deproom.`procedure`, 
                deproom.IsAdditem,
                IFNULL( doctor.Doctor_Name, '' ) AS Doctor_Name,
                IFNULL( `procedure`.Procedure_TH, '' ) AS Procedure_TH
            FROM
                deproom
            LEFT JOIN doctor ON doctor.ID = deproom.doctor
            LEFT JOIN `procedure` ON deproom.`procedure` = `procedure`.ID
            WHERE $whereD ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($rowQ1['procedure'], ',')) {
            $rowQ1['Procedure_TH'] = 'button';
        }
        if (str_contains($rowQ1['doctor'], ',')) {
            $rowQ1['Doctor_Name'] = 'button';
        }
        if ($rowQ1['hn_record_id'] == "") {
            $rowQ1['hn_record_id'] = $rowQ1['number_box'] ;
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
