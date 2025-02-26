<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'selection_itemNoUse') {
        selection_itemNoUse($conn);
    }else     if ($_POST['FUNC_NAME'] == 'selection_itemborrow') {
        selection_itemborrow($conn);
    }else     if ($_POST['FUNC_NAME'] == 'selection_itemdamage') {
        selection_itemdamage($conn);
    }else     if ($_POST['FUNC_NAME'] == 'onUpdatetime') {
        onUpdatetime($conn);
    }else     if ($_POST['FUNC_NAME'] == 'selection_receive_stock') {
        selection_receive_stock($conn);
    }else     if ($_POST['FUNC_NAME'] == 'onUpdateExsoon') {
        onUpdateExsoon($conn);
    }else     if ($_POST['FUNC_NAME'] == 'selection_Ex') {
        selection_Ex($conn);
    }else     if ($_POST['FUNC_NAME'] == 'selection_ExSoon') {
        selection_ExSoon($conn);
    }else if ($_POST['FUNC_NAME'] == 'selection_use_deproom') {
        selection_use_deproom($conn);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateDisplay') {
        onUpdateDisplay($conn);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateLang') {
        onUpdateLang($conn);
    }
}

function onUpdateLang($conn)
{
    $return = array();
    $Lang = $_POST['Lang'];
    $Userid = $_POST['Userid'];

    $query = "UPDATE users SET Lang = '$Lang' WHERE ID = '$Userid'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    $_SESSION['Lang'] = $Lang;
    echo json_encode($return);
    unset($conn);
    die;
}

function onUpdateDisplay($conn)
{
    $return = array();
    $display = $_POST['display'];
    $Userid = $_POST['Userid'];

    $query = "UPDATE users SET display = '$display' WHERE ID = '$Userid'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    $_SESSION['display'] = $display;
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_use_deproom($conn)
{

    $return = [];
    $query = " SELECT COUNT
                    ( deproom.DocNo ) AS c 
                FROM
                    deproom
                WHERE
                    deproom.IsCancel = 0  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_ExSoon($conn)
{
    $DepID = $_SESSION['DepID'];
    $GN_WarningExpiringSoonDay = $_POST['GN_WarningExpiringSoonDay'];
    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];

    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND itemstock.departmentroomid = '$deproom' ";
    }

    $return = [];
    $query = "SELECT COUNT(DISTINCT itemstock.UsageCode ) AS c 
                FROM
                    itemstock 
                WHERE
                        itemstock.IsCancel = 0 
                        AND itemstock.Isdeproom = 0
                    AND CONVERT ( DATE, itemstock.ExpireDate ) BETWEEN CONVERT ( DATE, GETDATE( ) ) 
                    AND DATEADD( DAY, $GN_WarningExpiringSoonDay, CONVERT ( DATE, GETDATE( ) ) ) 
                    AND CONVERT ( DATE, itemstock.ExpireDate ) != CONVERT ( DATE, GETDATE( ) ) $wheredep ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }

    echo json_encode($return);
    unset($conn);
    die;
}

function selection_Ex($conn)
{
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];

    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND itemstock.departmentroomid = '$deproom' AND  itemstock.IsDeproom = 1  ";
    }else{
        $wheredep = " AND itemstock.Isdeproom = 0 ";
    }

    $return = [];
    $query = "SELECT COUNT(DISTINCT itemstock.UsageCode ) AS c 
                     
                FROM
                    itemstock 
                WHERE
                     itemstock.IsCancel = 0 
                    AND FORMAT ( itemstock.ExpireDate, 'yyyy-MM-dd' ) <= FORMAT ( GETDATE( ), 'yyyy-MM-dd' ) $wheredep  ";

                    // echo  $query;

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function selection_receive_stock($conn)
{
    $return = [];

    $cnt = 0;
    $query = "SELECT COUNT
                    ( sendsterile.DocNo ) AS c 
                FROM
                    sendsterile ";
    // $query = "SELECT
    //                 SUM(payoutdetail.Qty) cnt_detail,
    //                 COUNT(payoutdetailsub.Id) as cnt_sub
    //             FROM
    //                 payout
    //                 INNER JOIN department ON department.ID = payout.DeptID
    //                 INNER JOIN payoutdetail ON payoutdetail.DocNo = payout.DocNo
    //                 INNER JOIN payoutdetailsub ON payoutdetailsub.Payoutdetail_RowID = payoutdetail.ID 
    //             WHERE
    //                 payout.IsCancel = 0 
    //                 AND payout.IsSpecial = 0 
    //                 AND payout.IsBorrow = 0 
    //                 AND payout.DeptID IN ( 387, 388 ) 
    //                 AND ( FORMAT ( payout.CreateDate, 'yyyy-MM-dd' ) = '2024-12-17' ) 
    //                 AND payout.IsStatus IN ( 1, 2, 3, 8 ) 
    //             GROUP BY
    //                 payout.RefDocNo  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        $cnt = $row['c'];
        // if($row['cnt_detail'] == $row['cnt_sub']){

        // }else{
            // $cnt++ ;
        // }

    }

    
    $return[] = $cnt;

    echo json_encode($return);
    unset($conn);
    die;
}

function onUpdateExsoon($conn)
{
    $return = [];
    $Userid = $_POST['Userid'];
    $input_exsoon = $_POST['input_exsoon'];

    $query = "UPDATE configuration_dental SET GN_WarningExpiringSoonDay = $input_exsoon  ";

    $_SESSION['GN_WarningExpiringSoonDay'] = $input_exsoon;


    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function onUpdatetime($conn)
{
    $return = [];
    $Userid = $_POST['Userid'];
    $input_time_out = $_POST['input_time_out'];

    $query = "UPDATE users SET time_out = $input_time_out WHERE ID = '$Userid' ";

    $_SESSION['time_out'] = $input_time_out;


    $meQuery = $conn->prepare($query);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function selection_itemdamage($conn)
{
    $return = [];
    $query = "SELECT COUNT(itemstock.RowID) AS ccc FROM itemstock WHERE  itemstock.IsDamage = 2  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_itemborrow($conn)
{
    $return = [];


    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];
    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND dental_warehouse_id = '$deproom' ";
    }

    $query = "SELECT COUNT
                    ( deproomdetailsub.ID ) AS ccc 
                FROM
                    deproomdetailsub 
                WHERE
                    deproomdetailsub.dental_warehouse_id_borrow IS NOT NULL 
                    $wheredep
                    AND NOT deproomdetailsub.dental_warehouse_id_borrow = 99  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_itemNoUse($conn)
{
    $return = [];
    $query = "SELECT COUNT(itemstock.RowID) AS ccc FROM itemstock WHERE itemstock.IsDeproom = 3  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}