<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_borrow') {
        show_detail_borrow($conn,$db);
    }
}

function show_detail_borrow($conn,$db)
{
    $return = [];

    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];
    
    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND deproomdetailsub.dental_warehouse_id = '$deproom' ";
    }

    if($db == 1){
        $query = "SELECT
                        deproomdetailsub.ID,
                        itemstock.UsageCode,
                        item.itemname,
                        deproomdetailsub.dental_warehouse_id,
                        dep1.departmentroomname AS depName,
                        deproomdetailsub.dental_warehouse_id_borrow,
                        dep2.departmentroomname AS depNameBorrow,
                        DATE_FORMAT(deproom.serviceDate, '%H:%i') AS date_,
                        DATE_FORMAT(deproomdetailsub.date_borrow, '%H:%i') AS date_borrow
                    FROM
                        deproomdetailsub
                    INNER JOIN
                        itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN
                        departmentroom AS dep1 ON deproomdetailsub.dental_warehouse_id = dep1.id
                    INNER JOIN
                        departmentroom AS dep2 ON deproomdetailsub.dental_warehouse_id_borrow = dep2.id
                    INNER JOIN
                        deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN
                        deproom ON deproom.DocNo = deproomdetail.DocNo
                    WHERE
                        deproomdetailsub.dental_warehouse_id_borrow IS NOT NULL
                        AND deproomdetailsub.dental_warehouse_id_borrow != 99
                        $wheredep ";
    }else{
        $query = "SELECT
                deproomdetailsub.ID,
                itemstock.UsageCode,
                item.itemname,
                deproomdetailsub.dental_warehouse_id,
                dep1.departmentroomname AS depName ,
                deproomdetailsub.dental_warehouse_id_borrow ,
                dep2.departmentroomname  AS depNameBorrow ,
                FORMAT(deproom.serviceDate, 'HH:mm' ) AS date_  ,
                FORMAT(deproomdetailsub.date_borrow, 'HH:mm' ) AS date_borrow
            FROM
                deproomdetailsub
                INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                INNER JOIN item ON itemstock.ItemCode = item.itemcode
                INNER JOIN departmentroom AS dep1 ON deproomdetailsub.dental_warehouse_id = dep1.id 
                INNER JOIN departmentroom AS dep2 ON deproomdetailsub.dental_warehouse_id_borrow = dep2.id 
                INNER JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
	            INNER JOIN deproom ON deproom.DocNo = deproomdetail.DocNo
            WHERE
                deproomdetailsub.dental_warehouse_id_borrow IS NOT NULL 
                AND NOT deproomdetailsub.dental_warehouse_id_borrow = 99
                $wheredep  ";
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
