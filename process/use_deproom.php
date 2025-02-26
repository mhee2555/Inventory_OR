<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'selection_itemDeproomDetail') {
        selection_itemDeproomDetail($conn);
    } else if ($_POST['FUNC_NAME'] == 'showDetail') {
        showDetail($conn);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_detail_item') {
        feeddata_detail_item($conn);
    } else if ($_POST['FUNC_NAME'] == 'showDetail_searchItem') {
        showDetail_searchItem($conn);
    }
}

function feeddata_detail_item($conn)
{
    $return = array();

    
    $query = "SELECT
                    item.itemcode,
                    item.itemname,
                    item.IsCancel,
                    item.CostPrice 
                FROM
                    item 
                ORDER BY
                    item.itemname ASC ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showDetail_searchItem($conn)
{
    $select_item = $_POST['select_item'];
    $return = [];
    $query = "SELECT
                    departmentroom.departmentroomname ,
                    departmentroom.id ,
                    COUNT ( deproom.DocNo ) AS c 
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN departmentroom ON departmentroom.id = deproom.Ref_departmentroomid 
                WHERE
                    deproom.IsCancel = 0 
                    AND deproomdetail.ItemCode = '$select_item' 
                GROUP BY
                    deproom.DocNo,
                    departmentroom.departmentroomname ,
                    departmentroom.id  ";



        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $return['deproom'][] = $row;

            $query2 = " SELECT
                            deproom.hn_record_id 
                        FROM
                            deproom
                            INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                            INNER JOIN departmentroom ON departmentroom.id = deproom.Ref_departmentroomid 
                        WHERE
                            deproom.IsCancel = 0 
                            AND deproom.Ref_departmentroomid = '$id' 
                            AND deproomdetail.ItemCode = '$select_item' ";
                    $meQuery2 = $conn->prepare($query2);
                    $meQuery2->execute();
                    while ($row2 = $meQuery2->fetch(PDO::FETCH_ASSOC)) {
                        $return[$id][] = $row2;
                    }
        }

        echo json_encode($return);
        unset($conn);
        die;
}



function showDetail($conn)
{
    $deproom = $_POST['deproom_id'];
    $return = [];



    $query = " SELECT
                    deproom.DocNo,
                    deproom.IsStatus,
                    FORMAT(deproom.ServiceDate , 'dd-MM-yyyy') AS CreateDate,
                    FORMAT(deproom.ServiceDate , 'HH:mm') AS CreateTime,
                    doctor.Doctor_Name,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH ,
                    COUNT ( deproomdetailsub.ID ) AS cnt,
                    deproom.Ref_departmentroomid
                FROM
                    deproom
                    INNER JOIN deproomdetail ON deproom.DocNo = deproomdetail.DocNo
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN doctor ON deproom.doctor = doctor.ID
                    INNER JOIN [procedure] ON deproom.[procedure] = [procedure].ID 
                WHERE  deproom.Ref_departmentroomid = '$deproom'
                GROUP BY
                    deproom.DocNo,
                    deproom.ServiceDate,
                    doctor.Doctor_Name,
                    deproom.hn_record_id,
                    [procedure].Procedure_TH,
                    deproom.IsStatus,
                    deproom.Ref_departmentroomid  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return['departmentroomname'][] = $row;
        $_DocNo = $row['DocNo'];
        $query_sub = " SELECT
                            item.itemname,
                            item.itemcode,
                            COUNT ( deproomdetailsub.ID ) AS cnt,
                            itemtype.TyeName
                        FROM
                            deproomdetail
                            INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                            INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                            INNER JOIN item ON itemstock.ItemCode = item.itemcode
                            INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                        WHERE deproomdetail.DocNo = '$_DocNo' 
                        GROUP BY
                            item.itemname,
                            item.itemcode,
                            itemtype.TyeName ";

        $meQuery_sub = $conn->prepare($query_sub);
        $meQuery_sub->execute();
        while ($row_sub = $meQuery_sub->fetch(PDO::FETCH_ASSOC)) {
            $return[$_DocNo][] = $row_sub;
        }
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function selection_itemDeproomDetail($conn)
{



    $qB = "SELECT floor.ID , name_floor
           FROM floor ";
    $meQueryB = $conn->prepare($qB);
    $meQueryB->execute();
    while ($rowB = $meQueryB->fetch(PDO::FETCH_ASSOC)) {
        $ID = $rowB['ID'];
        $return['B'][] = $rowB;

        $query = "SELECT
        departmentroom.floor_id,
        departmentroom.departmentroomname ,
        departmentroom.id ,
        (
            SELECT 	COUNT(deproom.ID) AS c
            FROM
                deproom
            WHERE
                deproom.IsCancel = 0 
                AND deproom.Ref_departmentroomid = departmentroom.id
        ) AS Qty
    FROM
        departmentroom 
    WHERE
        departmentroom.floor_id = '$ID'
        AND departmentroom.IsMainroom = 0
    GROUP BY
        departmentroom.departmentroomname,
        departmentroom.id,
        departmentroom.floor_id 
    ORDER BY  
        departmentroom.floor_id ASC,
        Qty DESC,
        departmentroom.id  ";

        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $return[$ID][] = $row;
        }
    }


    echo json_encode($return);
    unset($conn);
    die;
}
