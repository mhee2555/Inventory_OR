<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'selection_departmentRoom') {
        selection_departmentRoom($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_item') {
        selection_item($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_itemSuds') {
        selection_itemSuds($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_itemSuds') {
        showDetail_itemSuds($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDetailSub_itemSuds') {
        showDetailSub_itemSuds($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_departmentRoom_rfid') {
        selection_departmentRoom_rfid($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_item_rfid') {
        selection_item_rfid($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_item_normal') {
        selection_item_normal($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_departmentRoom_normal') {
        selection_departmentRoom_normal($conn, $db);
    }
}


function selection_item_normal($conn, $db)
{
    $return = array();

    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    $input_search = $_POST['input_search'];
    $select_date1 = $_POST['select_date1'];


    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];



    $_itemcode = array();








    $Q1 = " SELECT
                item.itemname,
                item.itemcode,
                COUNT( itemstock.RowID ) AS cnt,
                ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1  )		AS cnt_pay ,
                ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7  )		AS cnt_cssd ,
                ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  (itemstock.IsDamage  = 0	OR itemstock.IsDamage  IS NULL)  AND itemstock.Isdeproom != 1 AND itemstock.Isdeproom != 2 AND itemstock.Isdeproom != 3  AND itemstock.Isdeproom != 4  AND itemstock.Isdeproom != 5 AND itemstock.Isdeproom != 6 AND itemstock.Isdeproom != 7 AND itemstock.Isdeproom != 8 AND itemstock.Isdeproom != 9)		AS balance , 
                ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  ( itemstock.IsDamage = 1  OR  itemstock.IsDamage = 2 ) )		AS damage 
            FROM
                itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            WHERE
                     ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' ) 
                 AND item.IsSpecial = '1'
            GROUP BY
                item.itemname,
                item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        $return['item'][] = $row1;
        $_itemcode[] = $row1['itemcode'];
    }

    if (count($_itemcode) == 0) {
        $whereItem = " ('') ";
    } else {
        $whereItem = " ( ";
        foreach ($_itemcode as $key => $value) {
            $whereItem .= " '$value' ,";
        }

        $whereItem =  substr($whereItem, 0, -1);

        $whereItem .= " ) ";
    }


    if ($db == 1) {
        $query = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        COUNT(itemstock_transaction_detail.ID) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 1
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 1 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['detail'][] = $row;
    }




    echo json_encode($return);
    unset($conn);
    die;
}


function selection_departmentRoom_normal($conn, $db)
{
    $return = array();
    $lang = $_POST['lang'];
    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    // $select_floor = $_POST['select_floor'];


    $where = "";


    if ($lang == 'en') {
        $Q1 = " SELECT
                    ID, 
                    floor.name_floor_EN AS name_floor
                FROM
                    floor  ";
    } else {
        $Q1 = " SELECT
                    ID, 
                    name_floor
                FROM
                    floor  ";
    }

    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {


        $return['floor'][] = $row1;
        $_ID = $row1['ID'];



        $query = "SELECT
                departmentroom.id,
                departmentroom.departmentroomname,
                departmentroom.departmentroomname_sub 
            FROM
                departmentroom
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_departmentRoom_rfid($conn, $db)
{
    $return = array();
    $lang = $_POST['lang'];
    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    // $select_floor = $_POST['select_floor'];


    $where = "";


    if ($lang == 'en') {
        $Q1 = " SELECT
                    ID, 
                    floor.name_floor_EN AS name_floor
                FROM
                    floor  ";
    } else {
        $Q1 = " SELECT
                    ID, 
                    name_floor
                FROM
                    floor  ";
    }

    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {


        $return['floor'][] = $row1;
        $_ID = $row1['ID'];



        $query = "SELECT
                departmentroom.id,
                departmentroom.departmentroomname,
                departmentroom.departmentroomname_sub 
            FROM
                departmentroom
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_item_rfid($conn, $db)
{
    $return = array();

    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    $input_search = $_POST['input_search'];
    $select_date1 = $_POST['select_date1'];


    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];



    $_itemcode = array();



    // $D = "DELETE 
    //         FROM
    //             hncode_detail 
    //         WHERE
    //             DATE(hncode_detail.CreateDate) = '$select_date1' 
    //             AND hncode_detail.ItemStockID  IN (
    //             SELECT
    //                 itemstock.RowID 
    //             FROM
    //                 itemstock 
    //             WHERE
    //                 itemstock.Isdeproom = '1' 
    //             AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
    //             )
    //             AND hncode_detail.ItemCode IS NULL  ";

    // $meQuery_D = $conn->prepare($D);
    // $meQuery_D->execute();

    // $D2 = "DELETE 
    //         FROM
    //         itemstock_transaction_detail 
    //         WHERE
    //         DATE(itemstock_transaction_detail.CreateDate) = '$select_date1' 
    //         AND itemstock_transaction_detail.ItemStockID IN (
    //         SELECT
    //             itemstock.RowID 
    //         FROM
    //             itemstock 
    //         WHERE
    //             itemstock.Isdeproom = '1' 
    //         AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
    //         )  ";

    // $meQuery_D2 = $conn->prepare($D2);
    // $meQuery_D2->execute();




    $Q1 = " SELECT
                item.itemname,
                item.itemcode,
                COUNT( itemstock.RowID ) AS cnt,
                ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1  )		AS cnt_pay ,
                ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7  )		AS cnt_cssd ,
                ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  (itemstock.IsDamage  = 0	OR itemstock.IsDamage  IS NULL)  AND itemstock.Isdeproom != 1 AND itemstock.Isdeproom != 2 AND itemstock.Isdeproom != 3  AND itemstock.Isdeproom != 4  AND itemstock.Isdeproom != 5 AND itemstock.Isdeproom != 6 AND itemstock.Isdeproom != 7 AND itemstock.Isdeproom != 8 AND itemstock.Isdeproom != 9)		AS balance , 
                ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  ( itemstock.IsDamage = 1  OR  itemstock.IsDamage = 2 ) )		AS damage 
            FROM
                itemstock
                INNER JOIN item ON itemstock.ItemCode = item.itemcode 
            WHERE
                     ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' ) 
                --  AND item.itemtypeID = '44'
            GROUP BY
                item.itemname,
                item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        $return['item'][] = $row1;
        $_itemcode[] = $row1['itemcode'];
    }

    if (count($_itemcode) == 0) {
        $whereItem = " ('') ";
    } else {
        $whereItem = " ( ";
        foreach ($_itemcode as $key => $value) {
            $whereItem .= " '$value' ,";
        }

        $whereItem =  substr($whereItem, 0, -1);

        $whereItem .= " ) ";
    }


    if ($db == 1) {
        $query = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        COUNT(itemstock_transaction_detail.ID) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 1
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 1 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['detail'][] = $row;
    }




    echo json_encode($return);
    unset($conn);
    die;
}


function showDetailSub_itemSuds($conn, $db)
{

    $return = array();
    $UsageCode = $_POST['UsageCode'];

    $query = " SELECT
                    sudslog.UniCode,
                    sudslog.UsedCount,
                    hncode.HnCode,
                    sudslog.SterileDate,
                    sudslog.ExpDate,	
                    employee.FirstName
                FROM
                    sudslog
                    LEFT JOIN hncode ON sudslog.HNDocNo = hncode.DocNo
                    LEFT JOIN deproom ON hncode.DocNo_SS = deproom.DocNo
                    LEFT JOIN users ON deproom.UserCode = users.ID
                    LEFT JOIN employee ON users.EmpCode = employee.EmpCode 
                WHERE sudslog.UniCode = '$UsageCode' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}
function showDetail_itemSuds($conn, $db)
{

    $return = array();
    $itemcode = $_POST['itemcode'];

    $query = " SELECT
                    itemstock.UsageCode,
                    itemstock.RowID,
                    itemstock.IsCancel,
                    itemstock.IsDeproom,
                    itemstock.IsDamage,
                    item.itemname,
                    departmentroom.departmentroomname,
                    store_location_detail.rack ,
                    store_location_detail.row ,
                    store_location.location 
                FROM
                    itemstock
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode
                    LEFT JOIN store_detail_item ON store_detail_item.itemCode = item.itemcode
                    LEFT JOIN store_location_detail ON store_location_detail.rowID = store_detail_item.store_location_detail_ID
                    LEFT JOIN store_location ON store_location.rowID = store_location_detail.store_locationID
                    INNER JOIN departmentroom ON itemstock.departmentroomid = departmentroom.id 
                WHERE
                    item.itemtypeID = 42
                    AND item.itemcode = '$itemcode'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}
function selection_itemSuds($conn, $db)
{

    $return = array();

    $input_search_suds = $_POST['input_search_suds'];

    $query = " SELECT
                    item.itemcode,
                    item.itemname ,
                    COUNT(itemstock.RowID) AS Qty 
                FROM
                    itemstock
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode 
                    INNER JOIN departmentroom ON itemstock.departmentroomid = departmentroom.id 
                WHERE
                    item.itemtypeID = 42 
                    AND ( item.itemname LIKE '%$input_search_suds%' OR item.itemcode LIKE '%$input_search_suds%' )
                GROUP BY
                    item.itemname,
                    item.itemcode ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }


    echo json_encode($return);
    unset($conn);
    die;
}

function selection_departmentRoom($conn, $db)
{
    $return = array();
    $lang = $_POST['lang'];
    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    // $select_floor = $_POST['select_floor'];


    $where = "";


    if ($lang == 'en') {
        $Q1 = " SELECT
                    ID, 
                    floor.name_floor_EN AS name_floor
                FROM
                    floor  ";
    } else {
        $Q1 = " SELECT
                    ID, 
                    name_floor
                FROM
                    floor  ";
    }

    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {


        $return['floor'][] = $row1;
        $_ID = $row1['ID'];



        $query = "SELECT
                departmentroom.id,
                departmentroom.departmentroomname,
                departmentroom.departmentroomname_sub 
            FROM
                departmentroom
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function selection_item($conn, $db)
{
    $return = array();

    $deproom = $_SESSION['deproom'];
    $DepID = $_SESSION['DepID'];
    $input_search = $_POST['input_search'];
    $select_date1 = $_POST['select_date1'];
    // $select_date2 = $_POST['select_date2'];
    // $input_Search = $_POST['input_Search'];

    $select_date1 = explode("-", $select_date1);
    $select_date1 = $select_date1[2] . '-' . $select_date1[1] . '-' . $select_date1[0];

    // $select_date2 = explode("-", $select_date2);
    // $select_date2 = $select_date2[2] . '-' . $select_date2[1] . '-' . $select_date2[0];

    // $where = "";
    // if ($select_floor != 0) {
    //     $where = "AND departmentroom.floor_id = '$select_floor' ";
    // }


    $D = "DELETE 
    FROM
        hncode_detail 
    WHERE
        DATE(hncode_detail.CreateDate) = '$select_date1' 
        AND hncode_detail.ItemStockID  IN (
        SELECT
            itemstock.RowID 
        FROM
            itemstock 
        WHERE
            itemstock.Isdeproom = '1' 
        AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
        )
        AND hncode_detail.ItemCode IS NULL  ";

    $meQuery_D = $conn->prepare($D);
    $meQuery_D->execute();

    $D2 = "DELETE 
    FROM
    itemstock_transaction_detail 
    WHERE
    DATE(itemstock_transaction_detail.CreateDate) = '$select_date1' 
    AND itemstock_transaction_detail.ItemStockID IN (
    SELECT
        itemstock.RowID 
    FROM
        itemstock 
    WHERE
        itemstock.Isdeproom = '1' 
    AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
    )  ";

    $meQuery_D2 = $conn->prepare($D2);
    $meQuery_D2->execute();


    $_itemcode = array();

    $Q1 = " SELECT
                item.itemname,
                item.itemcode,
                itemslotincabinet.Qty,
                ( SELECT SUM( itemstock_transaction_detail.Qty ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1 ) AS cnt_pay,
                ( SELECT SUM( itemstock_transaction_detail.Qty ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7 ) AS cnt_cssd
            FROM
                itemslotincabinet
                INNER JOIN item ON item.itemcode = itemslotincabinet.itemcode 
            WHERE ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' )
            GROUP BY
                item.itemname,
                item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

        if ($row1['cnt_pay'] == null) {
            $row1['cnt_pay'] = 0;
        }
        if ($row1['cnt_cssd'] == null) {
            $row1['cnt_cssd'] = 0;
        }


        $return['item'][] = $row1;
        $_itemcode[] = $row1['itemcode'];
    }

    if (count($_itemcode) == 0) {
        $whereItem = " ('') ";
    } else {
        $whereItem = " ( ";
        foreach ($_itemcode as $key => $value) {
            $whereItem .= " '$value' ,";
        }

        $whereItem =  substr($whereItem, 0, -1);

        $whereItem .= " ) ";
    }


    if ($db == 1) {
        $query = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        SUM(itemstock_transaction_detail.Qty) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 1
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 1 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['detail'][] = $row;
    }




    echo json_encode($return);
    unset($conn);
    die;
}
