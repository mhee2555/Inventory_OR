<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'feeddata_detail_item') {
        feeddata_detail_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'feeddata_detail_usage') {
        feeddata_detail_usage($conn);
    }else if ($_POST['FUNC_NAME'] == 'onDeleteUsage') {
        onDeleteUsage($conn);
    }
}

function onDeleteUsage($conn)
{

    $ArrayItemStockID = $_POST['ArrayItemStockID'];
    $UsageCode = "";
    foreach ($ArrayItemStockID as $key => $value) {
        $UsageCode .= $value . ",";
    }

    $UsageCode_ = substr($UsageCode, 0, strlen($UsageCode) - 1);
    $query = "UPDATE itemstock SET  IsDeproom = 100 WHERE itemstock.RowID IN (  $UsageCode_  )  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();


    unset($conn);
    die;
}

function feeddata_detail_usage($conn)
{
    $return = array();
    $itemcode = $_POST['itemcode'];


    
    $query = "SELECT
                    itemstock.UsageCode, 
                    itemstock.RowID, 
                    FORMAT(itemstock.PackDate ,'dd/MM/yyyy') AS PackDate, 
                    FORMAT(itemstock.ExpireDate  ,'dd/MM/yyyy') AS  ExpireDate,
                    itemstock.Isdeproom
                FROM
                    itemstock
                WHERE NOT Isdeproom IN (8,9,100) AND itemstock.ItemCode = '$itemcode' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata_detail_item($conn)
{
    $return = array();
    $check_active = $_POST['check_active'];


    $query = " SELECT
                    item.itemcode, 
                    item.itemname,
                    item.IsCancel,
                    item.cost_new_item,
                    item.vendors,
                    item.Isbhq,
                    item.CostPrice
                FROM
                    item
                WHERE item.IsCancel = '$check_active'
                ORDER BY item.itemname ASC";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}