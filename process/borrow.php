<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_borrow') {
        show_detail_borrow($conn, $db);
    }
}

function show_detail_borrow($conn, $db)
{
    $return = [];

    $deproom = $_SESSION['deproom'];
    $RefDepID = $_SESSION['RefDepID'];

    $wheredep = "";
    if ($RefDepID  == '36DEN') {
        $wheredep = "AND deproomdetailsub.dental_warehouse_id = '$deproom' ";
    }

    $select_Sdate = $_POST['select_Sdate'];
    $select_Edate = $_POST['select_Edate'];

    $select_Sdate = explode("-", $select_Sdate);
    $select_Sdate = $select_Sdate[2] . '-' . $select_Sdate[1] . '-' . $select_Sdate[0];

    $select_Edate = explode("-", $select_Edate);
    $select_Edate = $select_Edate[2] . '-' . $select_Edate[1] . '-' . $select_Edate[0];


    $permission = $_SESSION['permission'];

    $wherepermission = "";
    if($permission != '5'){
        $wherepermission = " AND item.warehouseID = $permission ";
    }


    if ($db == 1) {
        $query = "SELECT
                        deproomdetailsub.ID,
                        itemstock.UsageCode,
                        item.itemname,
                        deproom.hn_record_id,
                        deproomdetailsub.hn_record_id_borrow,
                        deproom.number_box
                    FROM
                        deproomdetailsub
                        LEFT JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                        LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                        LEFT JOIN departmentroom AS dep1 ON deproomdetailsub.dental_warehouse_id = dep1.id
                        LEFT JOIN deproomdetail ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                        LEFT JOIN deproom ON deproom.DocNo = deproomdetail.DocNo 
                    WHERE
                        deproomdetailsub.hn_record_id_borrow IS NOT NULL 
                        AND deproomdetailsub.hn_record_id_borrow != ''
                        AND DATE(deproomdetailsub.PayDate) BETWEEN '$select_Sdate' AND '$select_Edate'
                        $wherepermission
                    ORDER BY  deproomdetailsub.ID DESC

    $wheredep ";
    } else {
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
                $wherepermission
                $wheredep  ";
    }

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
