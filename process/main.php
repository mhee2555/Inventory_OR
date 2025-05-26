<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'selection_itemNoUse') {
        selection_itemNoUse($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'selection_itemborrow') {
        selection_itemborrow($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'selection_itemdamage') {
        selection_itemdamage($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'onUpdatetime') {
        onUpdatetime($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'selection_receive_stock') {
        selection_receive_stock($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'onUpdateExsoon') {
        onUpdateExsoon($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'selection_Ex') {
        selection_Ex($conn,$db);
    }else     if ($_POST['FUNC_NAME'] == 'selection_ExSoon') {
        selection_ExSoon($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'selection_use_deproom') {
        selection_use_deproom($conn,$db);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateDisplay') {
        onUpdateDisplay($conn,$db);
    } else if ($_POST['FUNC_NAME'] == 'onUpdateLang') {
        onUpdateLang($conn,$db);
    } else if ($_POST['FUNC_NAME'] == 'selection_oc') {
        selection_oc($conn,$db);
    }
}

function onUpdateLang($conn,$db)
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

function onUpdateDisplay($conn,$db)
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


function selection_oc($conn,$db)
{

    $permission = $_SESSION['permission'];
    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }

    $return = [];
    $query = " SELECT COUNT(itemstock.IsTracking) AS c 
                FROM
                    itemstock
                INNER JOIN item ON item.itemcode = itemstock.ItemCode
                WHERE
                    itemstock.IsTracking = 1 
                    $wherepermission  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_use_deproom($conn,$db)
{

    $return = [];
    $query = " SELECT COUNT(deproom.DocNo) AS c 
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

function selection_ExSoon($conn,$db)
{
    $DepID = $_SESSION['DepID'];
    $GN_WarningExpiringSoonDay = $_POST['GN_WarningExpiringSoonDay'];
    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];

    $permission = $_SESSION['permission'];
    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }

    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND itemstock.departmentroomid = '$deproom' ";
    }

    $return = [];

    if($db == 1){
        $query = " SELECT
                        COUNT( DISTINCT itemstock.UsageCode ) AS c 
                    FROM
                        itemstock 
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                    WHERE
                        itemstock.IsCancel = 0 
                        AND itemstock.Isdeproom = 0 
                        AND DATE( itemstock.ExpireDate ) BETWEEN CURDATE() 
                        AND DATE_ADD( CURDATE(), INTERVAL $GN_WarningExpiringSoonDay DAY ) 
                        AND DATE( itemstock.ExpireDate ) != CURDATE() $wheredep $wherepermission ";
    }else{
        $query = "SELECT COUNT(DISTINCT itemstock.UsageCode ) AS c 
        FROM
            itemstock 
        INNER JOIN item ON item.itemcode = itemstock.ItemCode
        WHERE
                itemstock.IsCancel = 0 
                AND itemstock.Isdeproom = 0
            AND CONVERT ( DATE, itemstock.ExpireDate ) BETWEEN CONVERT ( DATE, GETDATE( ) ) 
            AND DATEADD( DAY, $GN_WarningExpiringSoonDay, CONVERT ( DATE, GETDATE( ) ) ) 
            AND CONVERT ( DATE, itemstock.ExpireDate ) != CONVERT ( DATE, GETDATE( ) ) $wheredep $wherepermission ";
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

function selection_Ex($conn,$db)
{
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];
    $permission = $_SESSION['permission'];
    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }
    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND itemstock.departmentroomid = '$deproom' AND  itemstock.IsDeproom = 1  ";
    }else{
        $wheredep = " AND itemstock.Isdeproom = 0 ";
    }

    $return = [];

    if($db == 1){
        $query = " SELECT
                        COUNT( DISTINCT itemstock.UsageCode ) AS c 
                    FROM
                        itemstock 
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                    WHERE
                        itemstock.IsCancel = 0 
                        AND DATE_FORMAT( itemstock.ExpireDate, '%Y-%m-%d' ) <= DATE_FORMAT( NOW(), '%Y-%m-%d' ) $wheredep $wherepermission ";
    }else{
        $query = "SELECT COUNT(DISTINCT itemstock.UsageCode ) AS c 
                     
        FROM
            itemstock 
        INNER JOIN item ON item.itemcode = itemstock.ItemCode
        WHERE
             itemstock.IsCancel = 0 
            AND FORMAT ( itemstock.ExpireDate, 'yyyy-MM-dd' ) <= FORMAT ( GETDATE( ), 'yyyy-MM-dd' ) $wheredep $wherepermission  ";
    }


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


function selection_receive_stock($conn,$db)
{
    $return = [];

    $cnt = 0;
    $query = "SELECT COUNT(sendsterile.DocNo) AS c 
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

function onUpdateExsoon($conn,$db)
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

function onUpdatetime($conn,$db)
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

function selection_itemdamage($conn,$db)
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

function selection_itemborrow($conn,$db)
{
    $return = [];


    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];
    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND dental_warehouse_id = '$deproom' ";
    }

    $permission = $_SESSION['permission'];
    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }


    $query = "SELECT
                    COUNT( deproomdetailsub.ID ) AS ccc 
                FROM
                    deproomdetailsub
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                WHERE
                    deproomdetailsub.hn_record_id_borrow IS NOT NULL 
                    AND deproomdetailsub.hn_record_id_borrow <> '' 
                    $wherepermission
                    $wheredep  ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_itemNoUse($conn,$db)
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