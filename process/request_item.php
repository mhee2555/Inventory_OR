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
    }else if ($_POST['FUNC_NAME'] == 'show_detail_receive') {
        show_detail_receive($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item_ByDocNo') {
        show_detail_item_ByDocNo($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_RQ') {
        onconfirm_RQ($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_history') {
        show_detail_history($conn,$db);
    }else if ($_POST['FUNC_NAME'] == 'showdetail') {
        showdetail($conn,$db);
    }
}

function showdetail($conn,$db){
    $return = array();
    $docnort = $_POST['RtDocNo'];
    $docnorq = $_POST['RqDocNo'];
    $check_show = $_POST['check_show'];

    if($check_show == 0){
    $Q1 = " SELECT
                item.itemcode2 AS itemcode,
                item.itemname,
                insertrfid_detail.QrCode
            FROM
                insertrfid
                INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo
                INNER JOIN item ON insertrfid_detail.ItemCode = item.itemcode 
            WHERE
                    insertrfid.RqDocNo = '$docnorq' 
                AND insertrfid.RtDocNo = '$docnort' ";
    }else{
            $Q1 = " SELECT
                item.itemcode2 AS itemcode,
                item.itemname,
                COUNT(insertrfid_detail.QrCode) AS QrCode
            FROM
                insertrfid
                INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo
                INNER JOIN item ON insertrfid_detail.ItemCode = item.itemcode 
            WHERE
                    insertrfid.RqDocNo = '$docnorq' 
                AND insertrfid.RtDocNo = '$docnort' 
            GROUP BY item.itemcode ";
    }


    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $rowQ1;
    }

    echo json_encode($return);
    unset($conn);
    die;

}

function show_detail_history($conn,$db){
    $return = array();
    $select_date1_search = $_POST['select_date1_search'];
    $select_date2_search = $_POST['select_date2_search'];

    $select_date1_search = explode("-", $select_date1_search);
    $select_date1_search = $select_date1_search[2] . '-' . $select_date1_search[1] . '-' . $select_date1_search[0];

    $select_date2_search = explode("-", $select_date2_search);
    $select_date2_search = $select_date2_search[2] . '-' . $select_date2_search[1] . '-' . $select_date2_search[0];

    $Q1 = " SELECT
                insertrfid.RqDocNo,
                insertrfid.RtDocNo,
                insertrfid.StatusDocNo,
                DATE( insertrfid.Createdate ) AS Createdate,
                TIME( insertrfid.Createdate ) AS Createtime 
            FROM
                insertrfid 
            WHERE
                insertrfid.RqDocNo <> '' 
                AND DATE( insertrfid.Createdate ) BETWEEN '$select_date1_search' AND '$select_date2_search' 
            GROUP BY
                insertrfid.RtDocNo  ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $rowQ1;
    }

    echo json_encode($return);
    unset($conn);
    die;

}

function onconfirm_RQ($conn,$db){
    $return = array();
    $docnort = $_POST['docnort'];
    $docnorq = $_POST['docnorq'];
    $Userid = $_SESSION['Userid'];

    $Q1 = " UPDATE insertrfid SET insertrfid.StatusDocNo = 2 , insertrfid.userID = $Userid WHERE insertrfid.RqDocNo = '$docnorq'   AND insertrfid.RtDocNo = '$docnort'   ";
    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_item_ByDocNo($conn,$db){
    $return = array();
    $docnort = $_POST['docnort'];
    $docnorq = $_POST['docnorq'];

    $Q1 = " SELECT
                item.itemcode,
                item.itemcode2,
                item.itemname,
                COUNT( insertrfid_detail.ID ) AS cnt
            FROM
                insertrfid
                INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo
                INNER JOIN item ON insertrfid_detail.ItemCode = item.itemcode 
            WHERE
                    insertrfid.RqDocNo = '$docnorq' 
                AND insertrfid.RtDocNo = '$docnort'
            GROUP BY
                insertrfid_detail.ItemCode ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {
        $return['item'][] = $rowQ1;
        $_itemcode = $rowQ1['itemcode'];


        $Q2 = " SELECT
                    insertrfid_detail.QrCode 
                FROM
                    insertrfid
                    INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo 
                WHERE
                    insertrfid.RqDocNo = '$docnorq' 
                    AND insertrfid.RtDocNo = '$docnort' 
                    AND insertrfid_detail.ItemCode = '$_itemcode' ";

        $meQ2 = $conn->prepare($Q2);
        $meQ2->execute();
        while ($rowQ2 = $meQ2->fetch(PDO::FETCH_ASSOC)) {
            $return[$_itemcode][] = $rowQ2;
        }
                    
    }

    echo json_encode($return);
    unset($conn);
    die;

}

function show_detail_receive($conn,$db){
    $return = array();
    $select_date1_rq = $_POST['select_date1_rq'];
    $select_date2_rq = $_POST['select_date2_rq'];

    $select_date1_rq = explode("-", $select_date1_rq);
    $select_date1_rq = $select_date1_rq[2] . '-' . $select_date1_rq[1] . '-' . $select_date1_rq[0];

    $select_date2_rq = explode("-", $select_date2_rq);
    $select_date2_rq = $select_date2_rq[2] . '-' . $select_date2_rq[1] . '-' . $select_date2_rq[0];

    $Q1 = " SELECT
                insertrfid.RqDocNo ,
                insertrfid.StatusDocNo 
            FROM
                insertrfid 
            WHERE
                insertrfid.RqDocNo != '' 
                AND DATE(insertrfid.Createdate) BETWEEN  '$select_date1_rq' AND '$select_date2_rq'
            GROUP BY
                insertrfid.RqDocNo ";

    $meQ1 = $conn->prepare($Q1);
    $meQ1->execute();
    while ($rowQ1 = $meQ1->fetch(PDO::FETCH_ASSOC)) {
        $return['rq'][] = $rowQ1;
        $_RqDocNo = $rowQ1['RqDocNo'];


        $Q2 = " SELECT
                    insertrfid.RtDocNo ,
                    insertrfid.StatusDocNo,
                    COUNT(DISTINCT insertrfid_detail.ItemCode) AS cnt
                FROM
                    insertrfid 
                INNER JOIN insertrfid_detail ON insertrfid.DocNo = insertrfid_detail.DocNo
                WHERE
                    insertrfid.RqDocNo = '$_RqDocNo'
                GROUP BY insertrfid.DocNo ";

        $meQ2 = $conn->prepare($Q2);
        $meQ2->execute();
        while ($rowQ2 = $meQ2->fetch(PDO::FETCH_ASSOC)) {
            $return[$_RqDocNo][] = $rowQ2;
        }
                    
    }

    echo json_encode($return);
    unset($conn);
    die;

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
                item.itemcode2 AS itemcode ,
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
                    item.itemcode2,
                    item.itemname AS Item_name,
                    itemtype.TyeName,
                    item.stock_min,
                    COUNT( itemstock.RowID ) AS cnt,
                    ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay,-- คำนวณ remain_balance
                    COUNT( itemstock.RowID ) - ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS remain_balance 
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
                    item.itemcode,
                    item.itemcode2,
                    item.itemname,
                    itemtype.TyeName,
                    item.stock_min 
                ORDER BY COUNT( itemstock.RowID ) - ( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) <  item.stock_min DESC ";

          
    // $query = "SELECT
    //             item.itemcode,
    //             item.itemcode2,
    //             item.itemname AS Item_name,
    //             itemtype.TyeName,
    //             item.stock_min,
    //             COUNT(itemstock.RowID) AS cnt,
	// 			( SELECT COUNT( ID ) FROM itemstock_transaction_detail WHERE ItemCode = item.itemcode AND IsStatus = 1 ) AS cnt_pay
    //         FROM
    //             item
    //             LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
    //             INNER JOIN itemstock ON item.itemcode = itemstock.ItemCode 
    //         WHERE
    //             item.IsNormal = 1 
    //             AND item.IsCancel = 0 
    //             AND ( item.itemcode LIKE '%$input_Search%'  OR item.itemname LIKE '%$input_Search%' )
    //             $wherepermission
    //             $wheretype
    //         GROUP BY
    //             item.ItemCode,
    //             item.itemname,
    //             itemtype.TyeName,
    //             item.stock_min
    //         ORDER BY
    //             CASE WHEN COUNT(itemstock.RowID) < item.stock_min THEN 0 ELSE 1 END,
    //             item.itemname ASC  ";

             


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
         $row['cnt'] = $row['remain_balance'];
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