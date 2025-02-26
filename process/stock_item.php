<?php
session_start();
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'Save_store') {
        Save_store($conn);
    }else     if ($_POST['FUNC_NAME'] == 'Show_store') {
        Show_store($conn);
    }else if ($_POST['FUNC_NAME'] == 'oncheck_pay') {
        oncheck_pay($conn);
    }else if ($_POST['FUNC_NAME'] == 'Edit_store') {
        Edit_store($conn);
    }else if ($_POST['FUNC_NAME'] == 'Show_store_detail') {
        Show_store_detail($conn);
    }else if ($_POST['FUNC_NAME'] == 'Edit_store_detail') {
        Edit_store_detail($conn);
    }else if ($_POST['FUNC_NAME'] == 'select_stock') {
        select_stock($conn);
    }else if ($_POST['FUNC_NAME'] == 'select_location') {
        select_location($conn);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item') {
        show_detail_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'save_item') {
        save_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item_store') {
        show_detail_item_store($conn);
    }else if ($_POST['FUNC_NAME'] == 'delete_item') {
        delete_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'Save_store_location') {
        Save_store_location($conn);
    }else if ($_POST['FUNC_NAME'] == 'select_rowandfloor') {
        select_rowandfloor($conn);
    }else if ($_POST['FUNC_NAME'] == 'switch_item') {
        switch_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'onDeleteLocation') {
        onDeleteLocation($conn);
    }else if ($_POST['FUNC_NAME'] == 'onDeleteLocationDetail') {
        onDeleteLocationDetail($conn);
    }
}

function onDeleteLocationDetail($conn)
{
    $rowID = $_POST['rowID'];

    $return = [];

            $queryInsert2 = "UPDATE store_location_detail SET IsCancel = 1 WHERE rowID = '$rowID' ";
            $meQueryInsert2 = $conn->prepare($queryInsert2);
            $meQueryInsert2->execute();

        $return=1;

        echo json_encode($return);
        unset($conn);
        die;

}
function onDeleteLocation($conn)
{
    $rowID = $_POST['rowID'];

    $return = [];

            $queryInsert1 = "UPDATE store_location SET IsCancel = 1 WHERE rowID = '$rowID' ";
            $meQueryInsert1 = $conn->prepare($queryInsert1);
            $meQueryInsert1->execute();

            $queryInsert2 = "UPDATE store_location_detail SET IsCancel = 1 WHERE store_locationID = '$rowID' ";
            $meQueryInsert2 = $conn->prepare($queryInsert2);
            $meQueryInsert2->execute();

        $return=1;

        echo json_encode($return);
        unset($conn);
        die;

}
function Save_store_location($conn)
{
    $input_search_location = $_POST['input_search_location'];
    $input_search_floor = $_POST['input_search_floor'];
    $input_search_row = $_POST['input_search_row'];
    $rowID = $_POST['rowID'];

    
    $return = [];

            $queryInsert = "INSERT INTO store_location_detail ( store_location_detail.store_locationID ,  store_location_detail.row , store_location_detail.rack )
            VALUES    (  '$rowID', '$input_search_row', '$input_search_floor')";
    
            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
    
    

        $return=1;

        echo json_encode($return);
        unset($conn);
        die;

}
function switch_item($conn)
{
    $itemCodeArray = $_POST['itemCodeArray'];
    $select_location_floor = $_POST['select_location_floor'];

    $return = [];

        foreach ($itemCodeArray as $key => $value) {
            $queryInsert = "DELETE FROM store_detail_item WHERE itemCode = '$value' ";
    
            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
    
            $queryInsert = "INSERT INTO store_detail_item ( store_location_detail_ID, store_detail.itemCode )
            VALUES
                (  '$select_location_floor', '$value')";
    
            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();

        }
        $return=1;

        echo json_encode($return);
        unset($conn);
        die;

}
function delete_item($conn)
{
    $itemCodeArray = $_POST['itemCodeArray'];
    $return = [];

        foreach ($itemCodeArray as $key => $value) {
            $queryInsert = "DELETE FROM store_detail_item WHERE itemCode = '$value' ";
    
            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
    
    

        }
        $return=1;

        echo json_encode($return);
        unset($conn);
        die;

}
function save_item($conn)
{
    $itemCodeArray = $_POST['itemCodeArray'];
    $select_location_item = $_POST['select_location_item'];
    $select_location_floor = $_POST['select_location_floor'];

    
    $return = [];
    $check_insertS = 1;
        foreach ($itemCodeArray as $key => $value) {

            $check_insert = 0;
            $q_check = "SELECT store_detail_item.rowID
                            FROM store_detail_item 
                        WHERE itemCode = '$value' 
                              AND store_location_detail_ID = '$select_location_floor' ";
            $meQueryq = $conn->prepare($q_check);
            $meQueryq->execute();
            while ($rowq = $meQueryq->fetch(PDO::FETCH_ASSOC)) {
                $check_insert++;
            }
            if($check_insert == 0){
                $queryInsert = "INSERT INTO store_detail_item ( store_location_detail_ID, store_detail.itemCode )
                VALUES
                    (  '$select_location_floor', '$value')";
        
                $meQueryInsert = $conn->prepare($queryInsert);
                $meQueryInsert->execute();
            }else{
                $check_insertS ++;
            }
        }
        if($check_insertS > 0){
            $return = $check_insertS;
        }else{
            $return=1;
        }

        echo json_encode($return);
        unset($conn);
        die;

}

function show_detail_item_store($conn)
{
    $return = array();
    $select_location_floor = $_POST['select_location_floor'];
    $input_search_item_store = $_POST['input_search_item_store'];

    $wheretype = "";
    

    $query = "SELECT
                store_detail_item.rowID,
                store_detail_item.ItemCode ,
                item.itemname AS Item_name,
                itemtype.TyeName ,
                store_location.location,
                store_location_detail.row,
                store_location_detail.rack,
	            store.storeName
            FROM
                store_detail_item
                INNER JOIN item ON item.itemcode = store_detail_item.ItemCode
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID 
                INNER JOIN store_location_detail ON store_location_detail.rowID = store_detail_item.store_location_detail_ID 
                INNER JOIN store_location ON store_location.rowID = store_location_detail.store_locationID 
                INNER JOIN store ON store.rowID = store_location.storeID 
            WHERE
                store_detail_item.store_location_detail_ID = '$select_location_floor'
                 AND ( item.itemcode LIKE '%$input_search_item_store%'  OR item.itemname LIKE '%$input_search_item_store%' )  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_item($conn)
{
    $return = array();
    $input_Search = $_POST['input_search_item'];
    $select_typeItem = $_POST['select_type_item'];

    $wheretype = "";
    if($select_typeItem != ""){
        $wheretype = " AND itemtype.ID = '$select_typeItem' ";
    }

    $query = "SELECT
                    item.itemcode,
                    item.itemname AS Item_name,
                    itemtype.TyeName
                FROM
                    item
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND item.IsCancel = 0 
                    AND ( item.itemcode LIKE '%$input_Search%'  OR item.itemname LIKE '%$input_Search%' )
                    -- AND item.itemcode NOT IN (SELECT store_detail_item.ItemCode FROM store_detail_item ) 
                    $wheretype
                GROUP BY
                    item.ItemCode,
                    item.itemname,
                    itemtype.TyeName
                ORDER BY item.itemname ASC  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function select_rowandfloor($conn)
{

    $return = [];
    $select_location_item = $_POST['select_location_item'];

    $query = "  SELECT
                    store_location_detail.rowID,
                    store_location_detail.row,
                    store_location_detail.rack
                FROM
                    store_location_detail 
                WHERE store_location_detail.store_locationID = '$select_location_item'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_location($conn)
{

    $return = [];
    $select_stock_item = $_POST['select_stock_item'];

    $query = "  SELECT
                    store_location.rowID,
                    store_location.location
                FROM
                    store_location 
                WHERE store_location.storeID = '$select_stock_item'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function select_stock($conn)
{

    $return = [];

    $query = "SELECT
                    store.rowID, 
                    store.storeName, 
                    store.siteName
                FROM
                    dbo.store
                    WHERE store.isCancel=0  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function Edit_store_detail($conn)
{
    $input_LocationStock = $_POST['input_LocationStock'];
    $input_floor = $_POST['input_floor'];
    $input_row = $_POST['input_row'];
    $rowid = $_POST['rowid'];

    
    $return = [];


        $return=1;
        $queryInsert = "UPDATE store_detail SET  store_detail.location = '$input_LocationStock', store_detail.row = '$input_row', store_detail.rack = '$input_floor' WHERE  store_detail.rowID = $rowid ";

        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();


        echo json_encode($queryInsert);
        unset($conn);
        die;


}

function Show_store_detail($conn)
{

    $return = [];
    $rowID = $_POST['rowID'];
    
    $query = "SELECT
                    store.storeName,
                    store_location.location,
                    store_location_detail.row,
                    store_location_detail.rack ,
                    store_location_detail.rowID ,
                    store_location_detail.store_locationID 
                FROM
                    dbo.store
                    INNER JOIN dbo.store_location ON store.rowID = store_location.storeID
                    INNER JOIN dbo.store_location_detail ON store_location.RowID = store_location_detail.store_locationID 
                WHERE
                    store_location_detail.store_locationID = '$rowID' AND store_location_detail.IsCancel = 0 ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function Edit_store($conn)
{
    $input_LocationStock = $_POST['input_LocationStock'];
    $rowid = $_POST['rowid'];
    $input_stock = $_POST['input_stock'];

    
        $return = [];
        $queryUpdate = "UPDATE store SET storeName = '$input_stock' WHERE rowID = '$rowid' ";
        $meQueryUpdate = $conn->prepare($queryUpdate);
        $meQueryUpdate->execute();


        $return=1;
        $queryInsert = "INSERT INTO store_location ( store_location.storeID, store_location.location )
        VALUES
            ( '$rowid', '$input_LocationStock')";

        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();


        echo json_encode($queryInsert);
        unset($conn);
        die;


}

function Save_store($conn)
{
    $input_stock = $_POST['input_stock'];
    // $input_LocationStock = $_POST['input_LocationStock'];
    // $input_floor = $_POST['input_floor'];
    // $input_row = $_POST['input_row'];

    $return = [];

    $query = "SELECT
                store.rowID, 
                store.storeName
            FROM
                dbo.store
                WHERE store.storeName ='$input_stock' ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    $rowCount = $meQuery->rowCount();

    if($rowCount>0){
        $return=0;
        echo json_encode($return);
        unset($conn);
        die;
    }else{
        $return=1;
        $queryInsert = "INSERT INTO store ( storeName, isCancel, siteName)
        VALUES
            ( '$input_stock', '0', 'BCM')";


        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();


        echo json_encode($queryInsert);
        unset($conn);
        die;
    }


}

function Show_store($conn)
{

    $return = [];

    $query = "SELECT
                    store.rowID, 
                    store.storeName, 
                    store.siteName
                FROM
                     store
                    WHERE store.isCancel= 0  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $rowID = $row['rowID'];
        $return['store'][] = $row;

        $querysub = " SELECT
                        store_location.rowID, 
                        store_location.location
                    FROM
                         store_location
                        WHERE store_location.storeID = $rowID AND store_location.IsCancel = 0 ";
        $meQuerysub = $conn->prepare($querysub);
        $meQuerysub->execute();
        while ($rowsub = $meQuerysub->fetch(PDO::FETCH_ASSOC)) {
            $return[$rowID][] = $rowsub;
        }


    }
    echo json_encode($return);
    unset($conn);
    die;
}