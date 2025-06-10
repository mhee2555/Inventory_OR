<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_lot') {
        show_detail_lot($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_itemstock') {
        show_detail_itemstock($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'set_tracking') {
        set_tracking($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_detail_oc') {
        show_detail_oc($conn, $db);
    }
}
function show_detail_oc($conn, $db)
{
    $return = array();
    $select_typeItem = $_POST['select_typeItem'];
    $input_search_request = $_POST['input_search_request'];
    $wheretype = "";
    if ($select_typeItem != "") {
        $wheretype = " AND itemtype.ID = '$select_typeItem' ";
    }

    $permission = $_SESSION['permission'];
    $wherepermission = "";
    if ($permission != '5') {
        $wherepermission = " AND item.warehouseID = $permission ";
    }


    $query = "SELECT
                item.itemname,
                itemstock.lotNo,
                itemstock.serielNo,
                itemstock.UsageCode,
                itemstock.remarkTracking,
                CASE
                    WHEN DATE( itemstock.ExpireDate ) <= DATE(
                        NOW()) THEN
                        'exp' ELSE 'no_exp' 
                    END AS check_exp ,
                    itemstock.IsDeproom,
                    deproom.hn_record_id,
                    deproom.number_box
                FROM
                    itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN deproomdetailsub ON deproomdetailsub.ItemStockID = itemstock.RowID
                    LEFT JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    LEFT JOIN deproom ON deproom.DocNo = deproomdetail.DocNo
                    LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    ( item.itemcode LIKE '%$input_search_request%'  OR item.itemname LIKE '%$input_search_request%' OR itemstock.UsageCode LIKE '%$input_search_request%' )
                    AND itemstock.IsTracking = 1
                    $wherepermission
                    $wheretype
                GROUP BY itemstock.UsageCode ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['hn_record_id'] == '') {
            $row['hn_record_id'] = $row['number_box'];
        }
        if ($row['remarkTracking'] == null) {
            $row['remarkTracking'] = '';
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function set_tracking($conn, $db)
{


    $return = array();
    $lotNo = $_POST['lotNo'];
    $itemcode = $_POST['itemcode'];
    $remark = $_POST['remark'];


    $update = "UPDATE itemstock SET IsTracking = 1 , remarkTracking = '$remark'  WHERE  itemstock.ItemCode = '$itemcode'  AND itemstock.lotNo = '$lotNo' ";
    $meQuery = $conn->prepare($update);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}
function show_detail_itemstock($conn, $db)
{
    $return = array();
    $lotNo = $_POST['lotNo'];
    $itemcode = $_POST['itemcode'];
    $input_search_lot_detail = $_POST['input_search_lot_detail'];


    $where = "";
    $whereUsage = "";
    if ($input_search_lot_detail != "") {
        $select_lot = "SELECT itemstock.ItemCode , itemstock.lotNo FROM itemstock WHERE itemstock.UsageCode = '$input_search_lot_detail' ";
        $meQuery_lot = $conn->prepare($select_lot);
        $meQuery_lot->execute();
        while ($row_lot = $meQuery_lot->fetch(PDO::FETCH_ASSOC)) {
                $_ItemCode = $row_lot['ItemCode'];
                $_lotNo = $row_lot['lotNo'];
        }

        $whereUsage = " AND  itemstock.ItemCode = '$_ItemCode' AND itemstock.lotNo = '$_lotNo'  ";



    }else{
        if ($itemcode != "") {
            $where = " AND  itemstock.ItemCode = '$itemcode' AND itemstock.lotNo = '$lotNo'  ";
        }
    }


    $query = "SELECT
                item.itemname,
                itemstock.lotNo,
                itemstock.serielNo,
                itemstock.UsageCode,
                CASE
                    WHEN DATE( itemstock.ExpireDate ) <= DATE(
                        NOW()) THEN
                        'exp' ELSE 'no_exp' 
                    END AS check_exp ,
                    itemstock.IsDeproom,
                    deproom.hn_record_id,
                    deproom.number_box
                FROM
                    itemstock
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN deproomdetailsub ON deproomdetailsub.ItemStockID = itemstock.RowID
                    LEFT JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    LEFT JOIN deproom ON deproom.DocNo = deproomdetail.DocNo
                WHERE
                    itemstock.UsageCode != ''
                    $where
                    $whereUsage
                GROUP BY itemstock.UsageCode ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['hn_record_id'] == '') {
            $row['hn_record_id'] = $row['number_box'];
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_lot($conn, $db)
{
    $return = array();
    $itemcode = $_POST['itemcode'];



    $query = "SELECT
                    itemstock.ItemCode,
                    itemstock.lotNo,
                    COUNT( itemstock.RowID ) AS cnt
                FROM
                    itemstock 
                WHERE
                    itemstock.ItemCode = '$itemcode' 
                GROUP BY
                    itemstock.lotNo  ";




    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
