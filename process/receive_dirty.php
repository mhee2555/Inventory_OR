<?php
session_start();
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';
require '../process/CreateDamage.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_deproom') {
        show_detail_deproom($conn);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item') {
        show_detail_item($conn);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_receive') {
        onconfirm_receive($conn);
    }else if ($_POST['FUNC_NAME'] == 'show_detail_item_save') {
        show_detail_item_save($conn);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_cancel') {
        onconfirm_cancel($conn);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_send') {
        onconfirm_send($conn);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_damage') {
        onconfirm_damage($conn);
    }else if ($_POST['FUNC_NAME'] == 'checkNSterile') {
        checkNSterile($conn);
    }else if ($_POST['FUNC_NAME'] == 'cancelDamage') {
        cancelDamage($conn);
    }
}

function checkNSterile($conn)
{


    $where1 = "";

    $where1 = "	 AND ( itemstock.IsDamage = 1 OR itemstock.IsDamage = 2 OR itemstock.IsClaim = 1 OR itemstock.IsClaim = 2 )  ";

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
function cancelDamage($conn)
{
    $return = array();
    $itemcode = $_POST['itemcode'];
    $UsageCode = $_POST['UsageCode'];

    


    $query = " SELECT TOP
                    1 itemstock.RowID ,
                    itemstock.UsageCode,
                    deproomdetailsub.ID 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    deproom.IsCancel = 0 
                    AND deproomdetailsub.IsStatus = 6 
                    AND itemstock.UsageCode = '$UsageCode' 
                    AND itemstock.IsDamage = '1'  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RowID = $row['RowID'];
        $ID = $row['ID'];

        $queryInsert1 = "DELETE FROM damage  WHERE DocNo = (SELECT DocNo FROM damagedetail WHERE deproomdetailsub_id = '$ID' ) ";
        $meQueryInsert1 = $conn->prepare($queryInsert1);
        $meQueryInsert1->execute();

        $queryInsert2 = "DELETE FROM damagedetail  WHERE deproomdetailsub_id = '$ID' ";
        $meQueryInsert2 = $conn->prepare($queryInsert2);
        $meQueryInsert2->execute();

        $update1 = "UPDATE deproomdetailsub SET deproomdetailsub.IsDamage = NULL  WHERE deproomdetailsub.ID = '$ID' ";
        $meQuery1 = $conn->prepare($update1);
        $meQuery1->execute();

        $update2 = "UPDATE itemstock SET itemstock.IsDamage = NULL   WHERE itemstock.RowID = '$RowID' ";
        $meQuery2 = $conn->prepare($update2);
        $meQuery2->execute();

        // $return[] = $row;
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}
function onconfirm_damage($conn)
{
    $return = array();
    $input_itemcode_damage = $_POST['input_itemcode_damage'];
    $UsageCode = $_POST['UsageCode'];
    $remark_damage = $_POST['remark_damage'];
    $Userid = $_SESSION['Userid'];
    $DepID = $_SESSION['DepID'];
    $image64_damage = $_POST['image64_damage'];

    
    $label_DocNo = create_Damage_DocNo($conn, $DepID, $Userid, "");


    $query = " SELECT TOP 1
                    itemstock.RowID ,
                    itemstock.UsageCode,
                    deproomdetailsub.ID
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                WHERE
                    deproom.IsCancel = 0 
                    AND deproomdetailsub.IsStatus = 6 
                    AND itemstock.UsageCode = '$UsageCode' 
                     AND (itemstock.IsDamage IS NULL  OR  itemstock.IsDamage = '0' )  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $RowID = $row['RowID'];
        $ID = $row['ID'];

        $queryInsert = "INSERT INTO damagedetail 
        ( DocNo, ItemStockID, ItemCode, Qty, IsStatus, Remark,   IsCancel , deproomdetailsub_id , images  ) 
        VALUES ( '$label_DocNo' , '$RowID','$input_itemcode_damage', 1,0,'$remark_damage',0,$ID , '$image64_damage' )  ";

        $meQueryInsert = $conn->prepare($queryInsert);
        $meQueryInsert->execute();

        $update1 = "UPDATE deproomdetailsub SET deproomdetailsub.IsDamage = 1  WHERE deproomdetailsub.ID = '$ID' ";
        $meQuery1 = $conn->prepare($update1);
        $meQuery1->execute();

        $update2 = "UPDATE itemstock SET itemstock.IsDamage = 1   WHERE itemstock.RowID = '$RowID' ";
        $meQuery2 = $conn->prepare($update2);
        $meQuery2->execute();

        // $return[] = $row;
    }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function onconfirm_send($conn)
{
    $return = array();



        $select = " SELECT 
                        deproomdetailsub.ID ,
                        deproomdetailsub.ItemStockID  ,
                        deproomdetailsub.IsDamage 
                    FROM
                        deproomdetailsub
                        INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                    WHERE
                        itemstock.Isdeproom = 5 
                        AND  deproomdetailsub.IsStatus = 6 
                        AND ( NOT deproomdetailsub.IsDamage = 2 OR deproomdetailsub.IsDamage IS NULL ) ";
        $meQueryselect = $conn->prepare($select);
        $meQueryselect->execute();
        while ($rowselect = $meQueryselect->fetch(PDO::FETCH_ASSOC)) {
            $_ID = $rowselect['ID'];
            $_ItemStockID = $rowselect['ItemStockID'];
            $_IsDamage = $rowselect['IsDamage'];

            if($_IsDamage == '1'){
                $sql1 = " UPDATE deproomdetailsub SET IsDamage = '2'  WHERE ID = '$_ID' ";
                $meQuery1 = $conn->prepare($sql1);
                $meQuery1->execute();
                
                $sql2 = "UPDATE  itemstock SET IsDamage = '2'   WHERE 	itemstock.RowID = '$_ItemStockID' ";
                $meQuery2 = $conn->prepare($sql2);
                $meQuery2->execute();
            }else{
                $sql1 = " UPDATE deproomdetailsub SET IsStatus = '7'  WHERE ID = '$_ID' ";
                $meQuery1 = $conn->prepare($sql1);
                $meQuery1->execute();
                
                $sql2 = "UPDATE  itemstock SET Isdeproom = 6   WHERE 	itemstock.RowID = '$_ItemStockID' ";
                $meQuery2 = $conn->prepare($sql2);
                $meQuery2->execute();
            }



        }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function onconfirm_cancel($conn)
{
    $return = array();



        $select = " SELECT 
                        deproomdetailsub.ID ,
                        deproomdetailsub.ItemStockID 
                    FROM
                        deproomdetailsub
                        INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                    WHERE
                        itemstock.Isdeproom = 5 
                        AND  deproomdetailsub.IsStatus = 6 ";
        $meQueryselect = $conn->prepare($select);
        $meQueryselect->execute();
        while ($rowselect = $meQueryselect->fetch(PDO::FETCH_ASSOC)) {
            $_ID = $rowselect['ID'];
            $_ItemStockID = $rowselect['ItemStockID'];

            $sql1 = " UPDATE deproomdetailsub SET IsStatus = '4'  WHERE ID = '$_ID' ";
            $meQuery1 = $conn->prepare($sql1);
            $meQuery1->execute();
            
            $sql2 = "UPDATE  itemstock SET Isdeproom = 4   WHERE 	itemstock.RowID = '$_ItemStockID' ";
            $meQuery2 = $conn->prepare($sql2);
            $meQuery2->execute();

        }




    $cnt = 0;
    echo json_encode($cnt);
    unset($conn);
    die;
}

function show_detail_item_save($conn)
{
    $return = array();



    $query = " SELECT
                    item.itemname ,
                    item.itemcode ,
                    itemstock.UsageCode ,
                    itemstock.IsDamage,
                    itemtype.TyeName
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID 
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                WHERE
                    deproom.IsCancel = 0 
                    AND deproomdetailsub.IsStatus = 6 
                    AND ( itemstock.IsDamage IS NULL OR itemstock.IsDamage = 1 OR itemstock.IsDamage = 0  )
                ORDER BY itemname , IsDamage DESC ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function onconfirm_receive($conn)
{
    $return = array();
    $itemCodeArray = $_POST['itemCodeArray'];
    $qtyArray = $_POST['qtyArray'];
    $deproomArray = $_POST['deproomArray'];
    $check_radio = $_POST['check_radio'];

    
    foreach ($itemCodeArray as $key => $value) {

        $where = "";
        if($check_radio == '1'){
            $where = "AND itemstock.departmentroomid = '$deproomArray[$key]' ";
        }
        $select = " SELECT TOP ($qtyArray[$key])
                        deproomdetailsub.ID ,
                        deproomdetailsub.ItemStockID 
                    FROM
                        deproomdetailsub
                        INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                    WHERE
                        itemstock.Isdeproom = 4 
                        AND deproomdetailsub.IsStatus = 4
                        $where
                        AND itemstock.ItemCode = '$value'
                        AND ( itemstock.IsDamage IS NULL OR itemstock.IsDamage = 1 OR itemstock.IsDamage = 0  )  ";


        // echo $select;
        // exit;
               
        $meQueryselect = $conn->prepare($select);
        $meQueryselect->execute();
        while ($rowselect = $meQueryselect->fetch(PDO::FETCH_ASSOC)) {
            $_ID = $rowselect['ID'];
            $_ItemStockID = $rowselect['ItemStockID'];


            $sql1 = " UPDATE deproomdetailsub SET IsStatus = '6'  WHERE ID = '$_ID' ";

            $meQuery1 = $conn->prepare($sql1);
            $meQuery1->execute();
            
            $sql2 = "UPDATE itemstock SET Isdeproom = 5   WHERE 	itemstock.RowID = '$_ItemStockID' ";
            $meQuery2 = $conn->prepare($sql2);
            $meQuery2->execute();
            // echo $sql1;
            // echo $sql2;

            // exit;

        }



    }

    $cnt = 0;
    // $sql = "SELECT COUNT ( deproomdetailsub.ID ) AS cnt 
    //         FROM
    //             deproomdetail
    //             INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
    //         WHERE
    //             deproomdetail.DocNo = '$DocNo' 
    //             AND deproomdetailsub.IsStatus = 3 ";
    // $meQuery = $conn->prepare($sql);
    // $meQuery->execute();
    // while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
    //          $cnt = $row['cnt'];
    // }

    // if($cnt == '0'){
    //     $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 2   WHERE deproom.DocNo = '$DocNo' ";
    //     $meQuery1 = $conn->prepare($sql1);
    //     $meQuery1->execute();
    // }


    echo json_encode($cnt);
    unset($conn);
    die;
}

function show_detail_item($conn)
{
    $return = array();



    $query = " SELECT
                    item.itemname ,
                    item.itemcode ,
                    itemtype.TyeName ,
                    COUNT ( deproomdetailsub.IsStatus ) AS count_item
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                WHERE
                         deproom.IsCancel = 0 
                    AND  deproomdetailsub.IsStatus = 4 
                    AND  itemstock.Isdeproom = 4 
	 
                    -- AND ( deproomdetailsub.IsDamage IS NULL OR  deproomdetailsub.IsDamage = 0 )
                    AND ( deproomdetailsub.IsDamage IS NULL OR deproomdetailsub.IsDamage = 1 OR deproomdetailsub.IsDamage = 0 )
                GROUP BY
                    item.itemname,
                    item.itemcode,
                    itemtype.TyeName
                ORDER BY item.itemname ASC   ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_deproom($conn)
{
    $return = array();



    $query = " SELECT
                    departmentroom.id,
                    departmentroom.departmentroomname 
                FROM
                    deproom
                    INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id 
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                    AND deproom.IsCancel = 0 
                    AND deproom.IsStatus = 3 
                    AND deproomdetailsub.IsStatus = 4 
                    AND  itemstock.Isdeproom = 4 
                    AND ( deproomdetailsub.IsDamage IS NULL OR  deproomdetailsub.IsDamage = 0 )
                GROUP BY
                    departmentroom.id,
                    departmentroom.departmentroomname 
                ORDER BY
                    departmentroom.id ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['departmentroomname'][] = $row;
        $_id = $row['id'];

        $query_sub = "SELECT
                        item.itemname,
                        item.itemcode ,
                        item.itemcode ,
                        itemtype.TyeName ,
                        COUNT ( deproomdetailsub.IsStatus ) AS count_item
                    FROM
                        deproom
                        INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                        INNER JOIN item ON item.itemcode = deproomdetail.ItemCode
                        INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                        INNER JOIN departmentroom ON deproom.Ref_departmentroomid = departmentroom.id
                        INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
                        INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID 
                    WHERE
                        departmentroom.id = '$_id' 
                        AND deproom.IsCancel = 0 
                        AND deproomdetailsub.IsStatus = 4 
                        AND  itemstock.Isdeproom = 4 
                        AND ( deproomdetailsub.IsDamage IS NULL OR  deproomdetailsub.IsDamage = 0 )
                    GROUP BY
                        item.itemname,
                        item.itemcode,
                        itemtype.TyeName ";

            $meQuery_sub = $conn->prepare($query_sub);
            $meQuery_sub->execute();
            while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {
                 $return[$_id][] = $row_sub;
            }
    }
    echo json_encode($return);
    unset($conn);
    die;
}