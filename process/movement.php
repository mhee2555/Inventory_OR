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
    } else if ($_POST['FUNC_NAME'] == 'onSavemanage_stockRFID') {
        onSavemanage_stockRFID($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'show_restock') {
        show_restock($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'save_item_daily') {
        save_item_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'select_set_item_daily') {
        select_set_item_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'delete_item_daily') {
        delete_item_daily($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_follow_item_detail') {
        selection_follow_item_detail($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'clearStock') {
        clearStock($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'selection_item_detail_ok') {
        selection_item_detail_ok($conn, $db);
    }
}

function clearStock($conn, $db)
{
    $return = [];
    $itemcode = $_POST['itemcode'];

    $update = "UPDATE itemstock SET itemstock.Adjust_stock = 1 WHERE itemstock.ItemCode = '$itemcode' AND itemstock.departmentroomid = 35 AND itemstock.IsDeproom = 0 ";
    $meQuery = $conn->prepare($update);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}


function selection_item_detail_ok($conn, $db)
{
    $return = array();
    $select_follow_month  = $_POST['select_follow_month'];
    $select_follow_year   = $_POST['select_follow_year'];
    $input_search_follow  = $_POST['input_search_follow'];
    $stockid              = $_POST['stockid'];

    // ดึงรายการ item ทั้งหมด (หัวตาราง) ตามเดือน/ปี/stockid + เงื่อนไขค้นหา
    $is = " SELECT
            dir.snapshot_date,
            dir.itemcode,
            dir.itemname
        FROM
            daily_item_rfid dir
        WHERE 
            MONTH(dir.snapshot_date) = '$select_follow_month'
        AND YEAR(dir.snapshot_date)  = '$select_follow_year'
        AND dir.stockID = '$stockid'
        AND (
            dir.itemname LIKE '%$input_search_follow%'
            OR dir.itemcode LIKE '%$input_search_follow%'
        )
        GROUP BY dir.itemcode ";

    $meQuery = $conn->prepare($is);
    $meQuery->execute();

    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['item'][] = $row;

        $itemCode = $row['itemcode'];

        // -----------------------------------------
        //  ดึงข้อมูลรายวันของ itemCode นี้ทั้งเดือน
        //  จาก daily_item_rfid + วันนี้จาก itemslotincabinet
        // -----------------------------------------
$sub = "
    WITH RECURSIVE calendar AS (
        SELECT DATE('$select_follow_year-$select_follow_month-01') AS DAY
        UNION ALL
        SELECT DAY + INTERVAL 1 DAY
        FROM calendar
        WHERE DAY + INTERVAL 1 DAY <= LAST_DAY('$select_follow_year-$select_follow_month-01')
    ),

    snapshot_data AS (
        -- 📌 snapshot ย้อนหลังจาก daily_item_rfid
        SELECT
            DATE(ds.snapshot_date) AS snapshot_date,
            ds.itemcode,
            ds.itemname,
            ds.qty
        FROM daily_item_rfid ds
        WHERE ds.itemcode = '$itemCode'
          AND ds.stockID = '$stockid'
          AND MONTH(ds.snapshot_date) = '$select_follow_month'
          AND YEAR(ds.snapshot_date)  = '$select_follow_year'
          AND DATE(ds.snapshot_date) <> CURDATE()
    ),

    today_data AS (
        " . (in_array($stockid, ['1','2','3']) ?

        // ---------- 📌 today จาก itemstock (stock 1,2,3) ----------
        "
        SELECT
            CURDATE() AS snapshot_date,
            is2.ItemCode AS itemcode,
            i.itemname,
            COUNT(is2.itemcode) AS qty
        FROM itemstock is2
        LEFT JOIN item i ON is2.itemcode = i.itemcode
        WHERE is2.StockID = '$stockid'
          AND is2.itemcode = '$itemCode'
        GROUP BY is2.ItemCode, i.itemname
        "
        :

        // ---------- 📌 today จาก itemslotincabinet ----------
        "
        SELECT
            CURDATE() AS snapshot_date,
            isc.itemcode,
            i.itemname,
            IFNULL(isc.Qty, 0) AS qty
        FROM itemslotincabinet isc
        LEFT JOIN item i ON isc.itemcode = i.itemcode
        WHERE isc.stockID = '$stockid'
          AND isc.itemcode = '$itemCode'
        "
        ) . "
    ),

    d AS (
        SELECT * FROM snapshot_data
        UNION ALL
        SELECT * FROM today_data
    )

    SELECT
        c.DAY AS snapshot_date,
        d.itemcode,
        d.itemname,
        COALESCE(d.qty, 0) AS qty
    FROM calendar c
    LEFT JOIN d ON d.snapshot_date = c.DAY
    ORDER BY c.DAY;
";


        $meQuery2 = $conn->prepare($sub);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return[$itemCode][] = $row2;
        }
    }

    echo json_encode($return);
    unset($conn);
    die;
}


function selection_follow_item_detail($conn, $db)
{
    $return = array();
    $select_follow_month = $_POST['select_follow_month'];
    $select_follow_year = $_POST['select_follow_year'];
    $input_search_follow = $_POST['input_search_follow'];


    $is = "SELECT
                daily_stock_item.snapshot_date,
                daily_stock_item.itemcode,
                daily_stock_item.itemname
            FROM
                daily_stock_item
            WHERE daily_stock_item.itemcode IN (SELECT set_item_daily.itemCode FROM set_item_daily)
            AND MONTH(daily_stock_item.snapshot_date) = '$select_follow_month' 
            AND YEAR(daily_stock_item.snapshot_date) = '$select_follow_year' 
            AND (daily_stock_item.itemname LIKE '%$input_search_follow%' OR daily_stock_item.itemcode LIKE '%$input_search_follow%')
            GROUP BY daily_stock_item.itemcode ";


    $meQuery = $conn->prepare($is);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['item'][] = $row;

        $itemCode = $row['itemcode'];

        $sub = "WITH RECURSIVE calendar AS (
                SELECT DATE('$select_follow_year-$select_follow_month-01') AS DAY
                UNION ALL
                SELECT DAY + INTERVAL 1 DAY
                FROM calendar
                WHERE DAY + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01')
            ),
            d AS (
                -- ดึงของเก่าที่ snapshot ไว้แล้ว (ยกเว้นวันนี้)
                SELECT
                    DATE(ds.snapshot_date) AS snapshot_date,
                    ds.itemcode,
                    ds.itemname,
                    ds.calculated_balance
                FROM daily_stock_item ds
                WHERE ds.itemcode = '$itemCode'
                AND DATE(ds.snapshot_date) <> CURDATE()

                UNION ALL

                -- 📌 ของวันนี้: ใช้ยอด cnt ของห้อง 35 โดยตรง
                SELECT
                    CURDATE() AS snapshot_date,
                    i.itemcode,
                    i.itemname,
                    IFNULL(s.cnt, 0) AS calculated_balance
                FROM item i
                LEFT JOIN (
                    SELECT ItemCode, COUNT(*) AS cnt
                    FROM itemstock
                    WHERE itemstock.IsCancel = 0
                    AND itemstock.Stockin = 1
                    AND itemstock.Adjust_stock = 0
                    AND itemstock.IsDeproom = 0
                    AND itemstock.departmentroomid = 35
                    GROUP BY ItemCode
                ) s ON s.ItemCode = i.itemcode
                WHERE i.itemcode = '$itemCode'
            )
            SELECT
                c.DAY AS snapshot_date,
                d.itemcode,
                d.itemname,
                COALESCE(d.calculated_balance, 0) AS calculated_balance
            FROM calendar c
            LEFT JOIN d ON d.snapshot_date = c.DAY
            ORDER BY c.DAY, d.itemcode; ";


        // $sub = "  WITH RECURSIVE calendar AS (
        //         SELECT DATE('$select_follow_year-$select_follow_month-01') AS day
        //         UNION ALL
        //         SELECT day + INTERVAL 1 DAY
        //         FROM calendar
        //         WHERE day + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01' ) 
        //     ),
        //     d AS (
        //         SELECT
        //             DATE(ds.snapshot_date) AS snapshot_date,
        //             ds.itemcode,
        //             ds.itemname,
        //             ds.calculated_balance
        //         FROM daily_stock_item ds
        //         WHERE ds.itemcode = '$itemCode'
        //         AND DATE(ds.snapshot_date) <> CURDATE()

        //         UNION ALL

        //         SELECT
        //             CURDATE() AS snapshot_date,
        //             i.itemcode,
        //             i.itemname,
        //             CASE 
        //                 WHEN IFNULL(s.cnt, 0) > IFNULL(i.stock_balance, 0)
        //                     THEN (IFNULL(s.cnt, 0) - IFNULL(tp.cnt_pay, 0))
        //                 ELSE (IFNULL(i.stock_balance, 0) - IFNULL(tp.cnt_pay, 0))
        //             END AS calculated_balance
        //         FROM item i

        //         LEFT JOIN (
        //             SELECT ItemCode, COUNT(*) AS cnt
        //             FROM itemstock
        //             GROUP BY ItemCode
        //         ) s ON s.ItemCode = i.itemcode

        //         LEFT JOIN (
        //             SELECT ItemCode, COUNT(*) AS cnt_pay
        //             FROM itemstock_transaction_detail
        //             WHERE IsStatus IN (1, 9)
        //             AND itemstock_transaction_detail.hncode != 'T001'
        //             GROUP BY ItemCode
        //         ) tp ON tp.ItemCode = i.itemcode


        //         WHERE i.itemcode = '$itemCode'
        //     )

        //     SELECT
        //         c.day AS snapshot_date,
        //         d.itemcode,
        //         d.itemname,
        //         COALESCE(d.calculated_balance, 0) AS calculated_balance
        //     FROM calendar c
        //     LEFT JOIN d
        //         ON d.snapshot_date = c.day
        //     ORDER BY c.day, d.itemcode;";

        // echo $sub;
        // exit;

        // $sub = "WITH RECURSIVE calendar AS (-- วันแรกของเดือนที่ต้องการ
        //             SELECT
        //                 DATE( '$select_follow_year-$select_follow_month-01' ) AS DAY UNION ALL-- ไล่วันไปเรื่อย ๆ จนถึงวันสุดท้ายของเดือน
        //             SELECT DAY
        //                 + INTERVAL 1 DAY 
        //             FROM
        //                 calendar 
        //             WHERE
        //                 DAY + INTERVAL 1 DAY <= LAST_DAY( '$select_follow_year-$select_follow_month-01' ) 
        //             ) SELECT
        //             c.DAY AS snapshot_date,
        //             d.itemcode,
        //             d.itemname,
        //             COALESCE ( d.calculated_balance, 0 ) AS calculated_balance 
        //         FROM
        //             calendar c
        //             LEFT JOIN daily_stock_item d ON DATE( d.snapshot_date ) = c.DAY 
        //             AND d.itemcode = '$itemCode' 
        //         ORDER BY
        //             c.DAY,
        //             d.itemcode; ";



        $meQuery2 = $conn->prepare($sub);
        $meQuery2->execute();
        while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
            $return[$itemCode][] = $row2;
        }
    }

    echo json_encode($return);
    unset($conn);
    die;
}

function delete_item_daily($conn, $db)
{
    $return = array();
    $itemCode = $_POST['itemCode'];

    $is = "DELETE FROM set_item_daily  WHERE itemCode = '$itemCode' ";

    $meQuery = $conn->prepare($is);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function select_set_item_daily($conn, $db)
{
    $return = array();

    $is = "SELECT
                set_item_daily.itemCode,
                item.itemname 
            FROM
                set_item_daily
                INNER JOIN item ON set_item_daily.itemCode = item.itemcode  ";
    $meQuery = $conn->prepare($is);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }

    echo json_encode($return);
    unset($conn);
    die;
}

function save_item_daily($conn, $db)
{
    $return = array();
    $itemCode = $_POST['itemCode'];

    $is = "INSERT INTO set_item_daily (itemCode) VALUES ('$itemCode') ";
    $meQuery = $conn->prepare($is);
    $meQuery->execute();

    echo json_encode($return);
    unset($conn);
    die;
}

function show_restock($conn, $db)
{

    $return = array();
    $UsageCode = $_POST['UsageCode'];
    $Userid = $_SESSION['Userid'];

    $query = " SELECT
                    item.itemcode2,
                    item.itemname,
                    itemstock.UsageCode,
                    itemstock.ItemCode,
                    itemstock.Isdeproom,
                    itemstock.departmentroomid ,
                    itemstock.RowID 
                FROM
                    item
                    INNER JOIN itemstock ON item.itemcode = itemstock.ItemCode 
                WHERE itemstock.UsageCode = '$UsageCode' ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;

        $_ItemCode = $row['ItemCode'];
        $_Isdeproom =  $row['Isdeproom'];
        $_departmentroomid =  $row['departmentroomid'];
        $_RowID =  $row['RowID'];

        $count_itemstock = 0;

        if ($_Isdeproom == 0) {
            $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID'  ";
            $meQuery = $conn->prepare($query);
            $meQuery->execute();


            $queryUpdate = "UPDATE itemstock 
            SET Isdeproom = 0 ,
            departmentroomid = '35',
            itemstock.Adjust_stock = 0,
            itemstock.IsCross = NULL
            WHERE
            RowID = '$_RowID' ";
            $meQueryUpdate = $conn->prepare($queryUpdate);
            $meQueryUpdate->execute();
        }



        // $query_2 = "SELECT
        //                     deproomdetailsub.ID ,
        //                     hncode_detail.ID AS hndetail_ID,
        //                     deproomdetail.ItemCode,
        //                     deproomdetail.DocNo,
        //                     DATE(deproom.serviceDate) AS ModifyDate,
        //                     deproom.number_box,
        //                     deproom.hn_record_id
        //                 FROM
        //                     deproom
        //                     INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
        //                     INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
        //                     INNER JOIN hncode ON hncode.DocNo_SS = deproom.DocNo 
        //                     INNER JOIN hncode_detail ON hncode_detail.DocNo = hncode.DocNo
        //                 WHERE
        //                     deproomdetailsub.ItemStockID = '$_RowID' 
        //                     AND hncode_detail.ItemStockID = '$_RowID' 
        //                 ORDER BY
        //                     deproomdetailsub.ID DESC LIMIT 1 ";
        // // echo $query_2;
        // // exit;
        // $meQuery_2 = $conn->prepare($query_2);
        // $meQuery_2->execute();
        // while ($row_2 = $meQuery_2->fetch(PDO::FETCH_ASSOC)) {

        //     // $return[] = $row_2;
        //     $_ID = $row_2['ID'];
        //     $_hndetail_ID = $row_2['hndetail_ID'];
        //     $_ModifyDate = $row_2['ModifyDate'];
        //     $_DocNo = $row_2['DocNo'];

        //     $_hn_record_id = $row_2['hn_record_id'];
        //     $_number_box = $row_2['number_box'];

        //     if ($_hn_record_id == "") {
        //         $_hn_record_id = $_number_box;
        //     }

        //     // ==============================
        //     // $queryD1 = "DELETE FROM deproomdetailsub WHERE ID =  '$_ID' ";
        //     // $meQueryD1 = $conn->prepare($queryD1);
        //     // $meQueryD1->execute();

        //     $queryD2 = "DELETE FROM hncode_detail WHERE ID =  '$_hndetail_ID' ";
        //     $meQueryD2 = $conn->prepare($queryD2);
        //     $meQueryD2->execute();
        //     // ==============================


        //     $insert_log = "INSERT INTO log_return (itemstockID, DocNo, userID, createAt) 
        //                     VALUES (:itemstockID, :DocNo, :userID, NOW())";

        //     $meQuery_log = $conn->prepare($insert_log);

        //     $meQuery_log->bindParam(':itemstockID', $_RowID);
        //     $meQuery_log->bindParam(':DocNo', $_DocNo);
        //     $meQuery_log->bindParam(':userID', $Userid);

        //     $meQuery_log->execute();
        //     // =======================================================================================================================================

        //     if ($db == 1) {
        //         $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
        //             AND ItemCode = '$_ItemCode' 
        //             AND departmentroomid = '$_departmentroomid' 
        //             AND  IsStatus = '1'
        //             AND DATE(CreateDate) = '$_ModifyDate' ";
        //     } else {
        //         $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID = '$_RowID' 
        //             AND ItemCode = '$_ItemCode' 
        //             AND departmentroomid = '$_departmentroomid' 
        //             AND  IsStatus = '1'
        //             AND CONVERT(DATE,CreateDate) = '$_ModifyDate' ";
        //     }

        //     $insert_log = "INSERT INTO log_activity_users (itemCode , itemstockID , qty, isStatus, DocNo, userID, createAt) 
        //                     VALUES (:itemCode, :itemstockID, 1, :isStatus, :DocNo, :Userid, NOW())";

        //     $meQuery_log = $conn->prepare($insert_log);

        //     $meQuery_log->bindParam(':itemCode', $_ItemCode);
        //     $meQuery_log->bindParam(':itemstockID', $_RowID);
        //     $meQuery_log->bindValue(':isStatus', 8, PDO::PARAM_INT);
        //     $meQuery_log->bindParam(':DocNo', $_DocNo);
        //     $meQuery_log->bindParam(':Userid', $Userid);


        //     $meQuery_log->execute();

        //     $meQuery = $conn->prepare($query);
        //     $meQuery->execute();
        //     // =======================================================================================================================================
        //     $count_itemstock++;
        // }




    }


    echo json_encode($return);
    unset($conn);
    die;
}

function onSavemanage_stockRFID($conn, $db)
{
    $return = array();

    $item_manage_stockRFID = $_POST['item_manage_stockRFID'];
    $max_manage_stockRFID = $_POST['max_manage_stockRFID'];
    $min_manage_stockRFID = $_POST['min_manage_stockRFID'];
    $balance_manage_stockRFID = $_POST['balance_manage_stockRFID'];



    if ($max_manage_stockRFID != "") {
        $update = "UPDATE item SET  stock_max = '$max_manage_stockRFID' WHERE item.itemcode = '$item_manage_stockRFID' ";
        $meQuery = $conn->prepare($update);
        $meQuery->execute();
    }
    if ($min_manage_stockRFID != "") {
        $update = "UPDATE item SET  stock_min = '$min_manage_stockRFID'   WHERE item.itemcode = '$item_manage_stockRFID' ";
        $meQuery = $conn->prepare($update);
        $meQuery->execute();
    }
    if ($balance_manage_stockRFID != "") {
        $update = "UPDATE item SET  stock_balance = '$balance_manage_stockRFID'  WHERE item.itemcode = '$item_manage_stockRFID' ";
        $meQuery = $conn->prepare($update);
        $meQuery->execute();
    }


    echo json_encode($return);
    unset($conn);
    die;
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


    $permission = $_SESSION['permission'];

    $wherepermission = "";
    if ($permission != '5') {
        $wherepermission = " AND i.warehouseID = $permission ";
    }

    $Q1 = " SELECT
                i.itemname,
                i.itemcode,
                i.stock_max,
                i.stock_min,
                i.stock_balance,
                CASE 
                    WHEN IFNULL(ss.cntx, 0) > IFNULL(i.stock_balance, 0)
                        THEN (IFNULL(ss.cntx, 0) - IFNULL(tp.cnt_pay, 0))
                    ELSE (IFNULL(i.stock_balance, 0) - IFNULL(tp.cnt_pay, 0))
                END AS calculated_balance,
                IFNULL(s.cnt, 0)                 AS cnt,
                IFNULL(ss.cntx, 0)                 AS cntx,
                IFNULL(tp.cnt_pay, 0)            AS cnt_pay,
                IFNULL(tpt.cnt_pay_today, 0)     AS cnt_pay_today, 
                IFNULL(tc.cnt_cssd, 0)           AS cnt_cssd,
                IFNULL(sb.balance, 0)            AS balance,
                IFNULL(dm.damage, 0)             AS damage
            FROM item i

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.IsDeproom = 0
                AND itemstock.departmentroomid = 35
                GROUP BY ItemCode
            ) s ON s.ItemCode = i.itemcode

                LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cntx
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.departmentroomid != '100'
                GROUP BY ItemCode
            ) ss ON ss.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_pay
                FROM itemstock_transaction_detail
                WHERE IsStatus IN (1, 9)
                AND itemstock_transaction_detail.departmentroomid != '100'
                GROUP BY ItemCode
            ) tp ON tp.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT d.ItemCode, COUNT(*) AS cnt_pay_today
                FROM itemstock_transaction_detail d
                WHERE d.IsStatus IN (1, 9)
                AND DATE(d.CreateDate) = '$select_date1'
                GROUP BY d.ItemCode
            ) tpt ON tpt.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_cssd
                FROM itemstock_transaction_detail
                WHERE IsStatus = 7
                GROUP BY ItemCode
            ) tc ON tc.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS balance
                FROM itemstock
                WHERE (IsDamage = 0 OR IsDamage IS NULL)
                AND Isdeproom NOT IN (1,2,3,4,5,6,7,8,9)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) sb ON sb.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS damage
                FROM itemstock
                WHERE IsDamage IN (1, 2)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) dm ON dm.ItemCode = i.itemcode

            WHERE
                (i.itemname LIKE '%$input_search%' OR i.itemcode LIKE '%$input_search%')
                AND i.SpecialID = '1'
                AND i.IsCancel = '0'
                AND i.item_status != 1
                AND i.item_status2 IS NULL
                 $wherepermission
                -- AND i.stock_max IS NOT NULL
            ORDER BY
                CASE WHEN calculated_balance < i.stock_min THEN 0 ELSE 1 END,
                s.cnt DESC,
                i.itemname;";




    // $Q1 = " SELECT
    //             item.itemname,
    //             item.itemcode,
    //             COUNT( itemstock.RowID ) AS cnt,
    //             ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1  )		AS cnt_pay ,
    //             ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7  )		AS cnt_cssd ,
    //             ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  (itemstock.IsDamage  = 0	OR itemstock.IsDamage  IS NULL)  AND itemstock.Isdeproom != 1 AND itemstock.Isdeproom != 2 AND itemstock.Isdeproom != 3  AND itemstock.Isdeproom != 4  AND itemstock.Isdeproom != 5 AND itemstock.Isdeproom != 6 AND itemstock.Isdeproom != 7 AND itemstock.Isdeproom != 8 AND itemstock.Isdeproom != 9)		AS balance , 
    //             ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  ( itemstock.IsDamage = 1  OR  itemstock.IsDamage = 2 ) )		AS damage 
    //         FROM
    //             itemstock
    //             INNER JOIN item ON itemstock.ItemCode = item.itemcode 
    //         WHERE
    //                  ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' ) 
    //              AND item.SpecialID = '1'
    //         GROUP BY
    //             item.itemname,
    //             item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        // if ($row1['cnt'] < $row1['stock_balance']) {
        //     $row1['cnt']  = $row1['stock_balance'];
        // }
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

    if ($db == 1) {
        $query2 = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        COUNT(itemstock_transaction_detail.ID) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 9
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query2 = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 9 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }



    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();
    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
        $return['detailDepID'][] = $row2;
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
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0 AND  departmentroom.IsActive = 1   ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }

    $query = " SELECT
                            department.ID, 
                            department.DepName
                        FROM
                            department  
                        WHERE department.IsAutomaticPayout = 0  
                            ORDER BY department.ID ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['depname'][] = $row;
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
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0  AND  departmentroom.IsActive = 1   ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }


    $query = " SELECT
                            department.ID, 
                            department.DepName
                        FROM
                            department  
                        WHERE department.IsAutomaticPayout = 0  
                            ORDER BY department.ID ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['depname'][] = $row;
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


    $permission = $_SESSION['permission'];

    $wherepermission = "";
    if ($permission != '5') {
        $wherepermission = " AND i.warehouseID = $permission ";
    }

    $Q1 = "SELECT
                i.itemname,
                i.itemcode,
                i.stock_max,
                i.stock_min,
                i.stock_balance,
                CASE 
                    WHEN IFNULL(ss.cntx, 0) > IFNULL(i.stock_balance, 0)
                        THEN (IFNULL(ss.cntx, 0) - IFNULL(tp.cnt_pay, 0))
                    ELSE (IFNULL(i.stock_balance, 0) - IFNULL(tp.cnt_pay, 0))
                END AS calculated_balance,
                IFNULL(s.cnt, 0)          AS cnt,
                IFNULL(ss.cntx, 0)          AS cntx,
                IFNULL(tp.cnt_pay, 0)     AS cnt_pay,
                IFNULL(tpt.cnt_pay_today, 0) AS cnt_pay_today,   -- ⬅️ ยอดจ่ายวันนี้
                IFNULL(tc.cnt_cssd, 0)    AS cnt_cssd,
                IFNULL(sb.balance, 0)     AS balance,
                IFNULL(dm.damage, 0)      AS damage
            FROM item i

            -- JOIN นับ stock ทั้งหมด
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.IsDeproom = 0
                AND itemstock.departmentroomid = 35
                GROUP BY ItemCode
            ) s ON s.ItemCode = i.itemcode

            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cntx
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.departmentroomid != '100'
                GROUP BY ItemCode
            ) ss ON ss.ItemCode = i.itemcode

            -- JOIN นับจ่าย (IsStatus = 1) ทั้งหมด
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_pay
                FROM itemstock_transaction_detail
                WHERE IsStatus  IN (1, 9)
                AND itemstock_transaction_detail.departmentroomid != '100'
                GROUP BY ItemCode
            ) tp ON tp.ItemCode = i.itemcode

            -- JOIN นับจ่ายวันนี้ (IsStatus = 1 เฉพาะวันนี้)
            LEFT JOIN (
                SELECT d.ItemCode, COUNT(*) AS cnt_pay_today
                FROM itemstock_transaction_detail d
                WHERE d.IsStatus IN (1, 9)
                AND DATE(d.CreateDate) = '$select_date1'
                GROUP BY d.ItemCode
            ) tpt ON tpt.ItemCode = i.itemcode

            -- JOIN cssd (IsStatus = 7)
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_cssd
                FROM itemstock_transaction_detail
                WHERE IsStatus = 7
                GROUP BY ItemCode
            ) tc ON tc.ItemCode = i.itemcode

            -- JOIN balance (ของดีที่ยังไม่ออก)
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS balance
                FROM itemstock
                WHERE (IsDamage = 0 OR IsDamage IS NULL)
                AND Isdeproom NOT IN (1,2,3,4,5,6,7,8,9)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) sb ON sb.ItemCode = i.itemcode

            -- JOIN damage
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS damage
                FROM itemstock
                WHERE IsDamage IN (1, 2)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) dm ON dm.ItemCode = i.itemcode

            WHERE
                (i.itemname LIKE '%$input_search%' OR i.itemcode LIKE '%$input_search%')
                AND i.SpecialID = '0'
                AND i.IsCancel = '0'
                $wherepermission
                AND i.item_status != 1
                AND i.item_status2 IS NULL
                -- AND i.stock_max IS NOT NULL
            ORDER BY
                CASE WHEN (IFNULL(s.cnt, 0) - IFNULL(tp.cnt_pay, 0)) < i.stock_min THEN 0 ELSE 1 END,
                s.cnt DESC,
                i.itemname  ";

    // $Q1 = " SELECT
    //             item.itemname,
    //             item.itemcode,
    //             item.stock_max,
    //             item.stock_min,
    //             item.stock_balance,
    //             COUNT( itemstock.RowID ) AS cnt,
    //             ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1  )		AS cnt_pay ,
    //             ( SELECT COUNT( itemstock_transaction_detail.ID ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7  )		AS cnt_cssd ,
    //             ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  (itemstock.IsDamage  = 0	OR itemstock.IsDamage  IS NULL)  AND itemstock.Isdeproom != 1 AND itemstock.Isdeproom != 2 AND itemstock.Isdeproom != 3  AND itemstock.Isdeproom != 4  AND itemstock.Isdeproom != 5 AND itemstock.Isdeproom != 6 AND itemstock.Isdeproom != 7 AND itemstock.Isdeproom != 8 AND itemstock.Isdeproom != 9)		AS balance , 
    //             ( SELECT COUNT( itemstock.RowID ) FROM itemstock WHERE itemstock.ItemCode = item.itemcode AND  ( itemstock.IsDamage = 1  OR  itemstock.IsDamage = 2 ) )		AS damage 
    //         FROM
    //             itemstock
    //             INNER JOIN item ON itemstock.ItemCode = item.itemcode 
    //         WHERE
    //                  ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' ) 
    //              AND item.SpecialID = '0'
    //         GROUP BY
    //             item.itemname,
    //             item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {
        // if ($row1['cnt'] < $row1['stock_balance']) {
        //     $row1['cnt']  = $row1['stock_balance'];
        // }

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

    if ($db == 1) {
        $query2 = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        COUNT(itemstock_transaction_detail.ID) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 9
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query2 = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 9 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }



    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();
    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
        $return['detailDepID'][] = $row2;
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
            WHERE departmentroom.iscancel = 0 AND floor_id = '$_ID'  AND  departmentroom.IsMainroom = 0 AND  departmentroom.IsActive = 1  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$_ID][] = $row;
        }
    }

    $query = " SELECT
                    department.ID, 
                    department.DepName
                FROM
                    department  
                WHERE department.IsAutomaticPayout = 0  
                    ORDER BY department.ID ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['depname'][] = $row;
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


    // $D = "DELETE 
    // FROM
    //     hncode_detail 
    // WHERE
    //     DATE(hncode_detail.CreateDate) = '$select_date1' 
    //     AND hncode_detail.ItemStockID  IN (
    //     SELECT
    //         itemstock.RowID 
    //     FROM
    //         itemstock 
    //     WHERE
    //         itemstock.Isdeproom = '1' 
    //     AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
    //     )
    //     AND hncode_detail.ItemCode IS NULL  ";

    // $meQuery_D = $conn->prepare($D);
    // $meQuery_D->execute();

    // $D2 = "DELETE 
    // FROM
    // itemstock_transaction_detail 
    // WHERE
    // DATE(itemstock_transaction_detail.CreateDate) = '$select_date1' 
    // AND itemstock_transaction_detail.ItemStockID IN (
    // SELECT
    //     itemstock.RowID 
    // FROM
    //     itemstock 
    // WHERE
    //     itemstock.Isdeproom = '1' 
    // AND ( itemstock.HNCode IS NULL OR itemstock.HNCode = '' )
    // )  ";

    // $meQuery_D2 = $conn->prepare($D2);
    // $meQuery_D2->execute();


    $_itemcode = array();

    $permission = $_SESSION['permission'];

    $wherepermission = "";
    if ($permission != '5') {
        $wherepermission = " AND i.warehouseID = $permission ";
    }

    $Q1 = "SELECT
                i.itemname,
                i.itemcode,
                i.stock_max,
                i.stock_min,
                i.stock_balance,
                CASE 
                    WHEN IFNULL(ss.cntx, 0) > IFNULL(i.stock_balance, 0)
                        THEN (IFNULL(ss.cntx, 0) - IFNULL(tp.cnt_pay, 0))
                    ELSE (IFNULL(i.stock_balance, 0) - IFNULL(tp.cnt_pay, 0))
                END AS calculated_balance,
                IFNULL(s.cnt, 0)              AS cnt,
                IFNULL(ss.cntx, 0)            AS cntx,
                IFNULL(tp.cnt_pay, 0)         AS cnt_pay,
                IFNULL(tpt.cnt_pay_today, 0)  AS cnt_pay_today,   -- ⬅️ เพิ่มจ่ายวันนี้
                IFNULL(tc.cnt_cssd, 0)        AS cnt_cssd,
                IFNULL(sb.balance, 0)         AS balance,
                IFNULL(dm.damage, 0)          AS damage
            FROM item i

            -- JOIN นับ stock ทั้งหมด
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.IsDeproom = 0
                AND itemstock.departmentroomid = 35
                GROUP BY ItemCode
            ) s ON s.ItemCode = i.itemcode

                LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cntx
                FROM itemstock
                WHERE itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                AND itemstock.departmentroomid != '100'
                GROUP BY ItemCode
            ) ss ON ss.ItemCode = i.itemcode

            -- JOIN นับจ่ายทั้งหมด (IsStatus = 1)
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_pay
                FROM itemstock_transaction_detail
                WHERE IsStatus IN (1, 9)
                AND itemstock_transaction_detail.departmentroomid != '100'
                GROUP BY ItemCode
            ) tp ON tp.ItemCode = i.itemcode

            -- JOIN นับจ่ายวันนี้ (IsStatus = 1 เฉพาะวันนี้)
            LEFT JOIN (
                SELECT d.ItemCode, COUNT(*) AS cnt_pay_today
                FROM itemstock_transaction_detail d
                WHERE d.IsStatus IN (1, 9)
                AND DATE(d.CreateDate) = '$select_date1'
                GROUP BY d.ItemCode
            ) tpt ON tpt.ItemCode = i.itemcode

            -- JOIN cssd (IsStatus = 7)
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS cnt_cssd
                FROM itemstock_transaction_detail
                WHERE IsStatus = 7
                GROUP BY ItemCode
            ) tc ON tc.ItemCode = i.itemcode

            -- JOIN balance (ยังไม่จ่าย + ไม่เสีย)
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS balance
                FROM itemstock
                WHERE (IsDamage = 0 OR IsDamage IS NULL)
                AND Isdeproom NOT IN (1,2,3,4,5,6,7,8,9)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) sb ON sb.ItemCode = i.itemcode

            -- JOIN damage
            LEFT JOIN (
                SELECT ItemCode, COUNT(*) AS damage
                FROM itemstock
                WHERE IsDamage IN (1, 2)
                AND itemstock.IsCancel = 0
                AND itemstock.Stockin = 1
                AND itemstock.Adjust_stock = 0
                GROUP BY ItemCode
            ) dm ON dm.ItemCode = i.itemcode

            WHERE
                (i.itemname LIKE '%$input_search%' OR i.itemcode LIKE '%$input_search%')
                AND i.SpecialID = '2'
                AND i.IsCancel = '0'
                AND i.item_status != 1
                AND i.item_status2 IS NULL
                -- AND i.stock_max IS NOT NULL
                $wherepermission

            ORDER BY
                CASE WHEN calculated_balance < i.stock_min THEN 0 ELSE 1 END,
                s.cnt DESC,
                i.itemname; ";



    // $Q1 = " SELECT
    //             item.itemname,
    //             item.itemcode,
    //             itemslotincabinet.Qty,
    //             ( SELECT SUM( itemstock_transaction_detail.Qty ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 1 ) AS cnt_pay,
    //             ( SELECT SUM( itemstock_transaction_detail.Qty ) FROM itemstock_transaction_detail WHERE itemstock_transaction_detail.ItemCode = item.itemcode AND itemstock_transaction_detail.IsStatus = 7 ) AS cnt_cssd
    //         FROM
    //             itemslotincabinet
    //             INNER JOIN item ON item.itemcode = itemslotincabinet.itemcode 
    //         WHERE ( item.itemname LIKE '%$input_search%' OR item.itemcode LIKE '%$input_search%' )
    //          AND item.SpecialID = '2'
    //         GROUP BY
    //             item.itemname,
    //             item.itemcode  ";


    $meQuery1 = $conn->prepare($Q1);
    $meQuery1->execute();
    while ($row1 = $meQuery1->fetch(PDO::FETCH_ASSOC)) {

        // if ($row1['cnt'] < $row1['stock_balance']) {
        //     $row1['cnt']  = $row1['stock_balance'];
        // }


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


    if ($db == 1) {
        $query2 = "SELECT
                        itemstock_transaction_detail.ItemCode,
                        COUNT(itemstock_transaction_detail.ID) AS Qty,
                        itemstock_transaction_detail.departmentroomid
                    FROM
                        itemstock_transaction_detail
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                        AND DATE(itemstock_transaction_detail.CreateDate) = '$select_date1'
                        AND itemstock_transaction_detail.IsStatus = 9
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid,
                        itemstock_transaction_detail.ItemCode
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC ";
    } else {
        $query2 = "SELECT 
                            itemstock_transaction_detail.ItemCode ,
                    COUNT ( itemstock_transaction_detail.ID ) AS Qty ,
                            itemstock_transaction_detail.departmentroomid 
                    FROM
                        itemstock_transaction_detail 
                    WHERE
                        itemstock_transaction_detail.ItemCode IN $whereItem
                    AND CONVERT(DATE,itemstock_transaction_detail.CreateDate) = '$select_date1' 
                    AND itemstock_transaction_detail.IsStatus = 9 
                    GROUP BY
                        itemstock_transaction_detail.departmentroomid ,
                        itemstock_transaction_detail.ItemCode 
                    ORDER BY
                        itemstock_transaction_detail.departmentroomid ASC  ";
    }



    $meQuery2 = $conn->prepare($query2);
    $meQuery2->execute();
    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
        $return['detailDepID'][] = $row2;
    }



    echo json_encode($return);
    unset($conn);
    die;
}
