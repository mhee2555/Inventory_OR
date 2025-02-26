<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'feeddata') {
        feeddata($conn);
    } else if ($_POST['FUNC_NAME'] == 'checkNSterile') {
        checkNSterile($conn);
    }  else if ($_POST['FUNC_NAME'] == 'onSendNsterile') {
        onSendNsterile($conn);
    } 
}

function checkNSterile($conn)
{

    $checkNsterile = $_POST['checkNsterile'];

    $where1 = "";

    $where1 = "	 AND ( itemstock.IsCross = 0 OR itemstock.IsCross = 1 OR itemstock.IsCross IS NULL )";

    $query = "SELECT COUNT
                    ( itemstock.RowID ) AS qty
                FROM
                    itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 	
                WHERE
                    itemstock.Isdeproom = 6
                    AND item.itemtypeID  = 44
                    $where1 ";
    // AND itemstock.RowID IN (  $subItemStockID  ) 

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata($conn)
{
    $DepID = $_SESSION['DepID'];
    $GN_WarningExpiringSoonDay = $_POST['GN_WarningExpiringSoonDay'];

    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND itemstock.departmentroomid = '$deproom'  AND  itemstock.IsDeproom = 1  ";
    }else{
        $wheredep = "AND  itemstock.IsDeproom = 0 ";
    }

    $return = [];
    $query = "SELECT
                    itemstock.ItemCode,
                    itemstock.UsageCode,
                    itemstock.RowID,
                    FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' ) AS ExpireDate,
                    COUNT(itemstock.Qty) AS Qty,
                    CASE WHEN  CONVERT ( DATE, itemstock.ExpireDate ) BETWEEN CONVERT ( DATE, GETDATE( ) )  AND DATEADD( DAY,  $GN_WarningExpiringSoonDay, CONVERT ( DATE, GETDATE( ) ) ) 
                    AND CONVERT ( DATE, itemstock.ExpireDate ) != CONVERT ( DATE, GETDATE( ) )
                    THEN 'ใกล้หมดอายุ' ELSE 'หมดอายุ' END AS IsStatus,

                    CASE WHEN  CONVERT ( DATE, itemstock.ExpireDate ) BETWEEN CONVERT ( DATE, GETDATE( ) ) 
                    AND DATEADD( DAY,  $GN_WarningExpiringSoonDay, CONVERT ( DATE, GETDATE( ) ) ) 
                    AND CONVERT ( DATE, itemstock.ExpireDate ) != CONVERT ( DATE, GETDATE( ) )     
                    THEN DATEDIFF(DAY, CONVERT(DATE,GETDATE()) ,CONVERT(DATE,itemstock.ExpireDate) ) 
                    ELSE DATEDIFF(DAY, CONVERT(DATE,itemstock.ExpireDate)  ,CONVERT(DATE,GETDATE() ) )  
                    END AS Exp_day,

                    item.itemname 
                FROM
                    itemstock
                    LEFT JOIN item ON item.itemcode = itemstock.ItemCode 
                WHERE
                  itemstock.IsCancel = 0 
                $wheredep
                AND (  CONVERT ( DATE, itemstock.ExpireDate )  <= FORMAT ( GETDATE( ), 'yyyy/MM/dd' )
                OR  CONVERT ( DATE, itemstock.ExpireDate ) BETWEEN CONVERT ( DATE, GETDATE( ) )  AND DATEADD( DAY,  $GN_WarningExpiringSoonDay, CONVERT ( DATE, GETDATE( ) ) ) )
                GROUP BY 	itemstock.ItemCode,
                    FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' ),
                    CONVERT ( DATE, itemstock.ExpireDate ),
                    item.itemname,
                    itemstock.UsageCode,
                    itemstock.RowID 
                ORDER BY
                item.itemname,  FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' ) ASC";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function onSendNsterile($conn)
{
    $ArrayItemStockID = $_POST['ArrayItemStockID'];
    $ItemStockID = "";
    foreach ($ArrayItemStockID as $key => $value) {
        $ItemStockID .= $value . ",";
    }

    $RefDepID = $_SESSION['RefDepID'];
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "  itemstock.IsDeproom = 1  ";
    }else{
        $wheredep = "  itemstock.IsDeproom = 0 ";
    }


    $subItemStockID = substr($ItemStockID, 0, strlen($ItemStockID) - 1);
    $return = [];
    $query = " SELECT
                    itemstock.RowID,
                    itemstock.UsageCode,
                    itemstock.ItemCode,
                    itemstock.departmentroomid
                FROM
                    itemstock
                    LEFT JOIN item ON item.itemcode = itemstock.ItemCode 
                WHERE
                    $wheredep 
                    AND itemstock.IsCancel = 0 
                    AND CONVERT ( DATE, itemstock.ExpireDate ) <= FORMAT ( GETDATE( ), 'yyyy/MM/dd' ) 
                    AND itemstock.RowID IN (  $subItemStockID  )  
                ORDER BY
                    item.itemname,
                    FORMAT ( itemstock.ExpireDate, 'dd/MM/yyyy' ) ASC ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_UsageCode = $row['UsageCode'];
        $RowID = $row['RowID'];

        $update = "UPDATE itemstock SET itemstock.IsDeproom = 6 , itemstock.IsCross =  1 WHERE itemstock.RowID = '$RowID' ";
        $meQueryupdate = $conn->prepare($update);
        $meQueryupdate->execute();

        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}