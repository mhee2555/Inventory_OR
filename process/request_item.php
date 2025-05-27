<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createreturn.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_item_request') {
        show_detail_item_request($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_request') {
        onconfirm_request($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_request_byDocNo') {
        show_detail_request_byDocNo($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_send_request') {
        onconfirm_send_request($conn,$db);
    }
}


function onconfirm_send_request($conn,$db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];

    $update = "UPDATE request SET isStatus = 1 WHERE DocNo = '$txt_docno_request' ";
    $meQueryU = $conn->prepare($update);
    $meQueryU->execute();


    echo json_encode($txt_docno_request);
    unset($conn);
    die;

}  
function show_detail_request_byDocNo($conn,$db)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $txt_docno_request = $_POST['txt_docno_request'];

    $query = "SELECT
                item.itemname ,
                item.itemcode ,
                request_detail.ID ,
                SUM(request_detail.Qty) AS cnt ,
                itemtype.TyeName
            FROM
                request
                INNER JOIN request_detail ON request.DocNo = request_detail.DocNo
                INNER JOIN item ON request_detail.itemCode = item.itemcode 
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
            WHERE
                request.DocNo = '$txt_docno_request' 
            GROUP BY
                item.itemname,
                item.itemcode,
                request_detail.ID ,
                itemtype.TyeName
            ORDER BY item.itemname ASC ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function show_detail_item_request($conn,$db)
{
    $return = array();
    $input_Search = $_POST['input_search_request'];
    $select_typeItem = $_POST['select_typeItem'];
    $permission = $_SESSION['permission'];

    $wheretype = "";
    if($select_typeItem != ""){
        $wheretype = " AND itemtype.ID = '$select_typeItem' ";
    }

    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }

    $query = "SELECT
                item.itemcode,
                item.itemname AS Item_name,
                itemtype.TyeName,
                item.stock_min,
                COUNT(itemstock.RowID) AS cnt
            FROM
                item
                LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                INNER JOIN itemstock ON item.itemcode = itemstock.ItemCode 
            WHERE
                item.IsNormal = 1 
                AND item.IsCancel = 0 
                AND ( item.itemcode LIKE '%$input_Search%'  OR item.itemname LIKE '%$input_Search%' )
                $wherepermission
                $wheretype
            GROUP BY
                item.ItemCode,
                item.itemname,
                itemtype.TyeName,
                item.stock_min
            ORDER BY
                CASE WHEN COUNT(itemstock.RowID) < item.stock_min THEN 0 ELSE 1 END,
                item.itemname ASC  ";

             


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function onconfirm_request($conn,$db)
{
    $return = array();
    $txt_docno_request = $_POST['txt_docno_request'];
    $array_itemcode = $_POST['array_itemcode'];
    $array_qty = $_POST['array_qty'];


    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $deproom = $_SESSION['deproom'];


    

    $count = 0;
    if ($txt_docno_request == "") {
        $txt_docno_request = createDocNo($conn, $Userid ,$db,0);
    }

    foreach ($array_itemcode as $key => $value) {

        $_cntcheck = 0;
        $queryCheck = "SELECT COUNT( request_detail.itemCode ) AS cntcheck
                        FROM
                            request_detail 
                        WHERE
                            request_detail.DocNo = '$txt_docno_request' 
                            AND request_detail.itemCode = '$value' ";


        $meQuery = $conn->prepare($queryCheck);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $_cntcheck = $row['cntcheck'];
        }

        if ($_cntcheck > 0) {


                $queryUpdate = "UPDATE request_detail 
                SET Qty = Qty +  $array_qty[$key]
                WHERE
                    DocNo = '$txt_docno_request' 
                    AND itemCode = '$value'  ";

            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        } else {

            if($db == 1){
                $queryInsert = "INSERT INTO request_detail ( DocNo, itemCode, qty , createAt )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]' , NOW()  )";
            }else{
                $queryInsert = "INSERT INTO request_detail ( DocNo, itemCode, qty )
                VALUES
                    ( '$txt_docno_request', '$value', '$array_qty[$key]' , GETDATE() )";
            }



            $meQueryInsert = $conn->prepare($queryInsert);
            $meQueryInsert->execute();
        }





        $count++;
    }


    echo json_encode($txt_docno_request);
    unset($conn);
    die;
}