<?php
session_start();
require '../connect/connect.php';
require '../process/Createdeproom.php';
require '../process/Createhncode.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_deproom') {
        show_detail_deproom($conn);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_Bydeproom') {
        show_detail_Bydeproom($conn);
    } else     if ($_POST['FUNC_NAME'] == 'show_detail_ByDocNo') {
        show_detail_ByDocNo($conn);
    } else     if ($_POST['FUNC_NAME'] == 'onconfirm_return') {
        onconfirm_return($conn);
    }
}

function onconfirm_return($conn)
{
    $return = array();
    $detailsub_id = $_POST['detailsub_id'];
    $DocNo = $_POST['DocNo'];
    $deproomid = $_POST['deproomid'];


    foreach ($detailsub_id as $key => $value) {
        $sql1 = " UPDATE deproomdetailsub SET IsStatus = '5'  WHERE ID = '$value' ";
        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();

        $sql2 = "UPDATE itemstock  SET Isdeproom = 0 ,  departmentroomid = '35'  WHERE RowID IN (   SELECT
                                                                                                        deproomdetailsub.ItemStockID 
                                                                                                    FROM
                                                                                                        deproomdetailsub
                                                                                                    WHERE deproomdetailsub.ID = '$value'  ) ";
        $meQuery2 = $conn->prepare($sql2);
        $meQuery2->execute();

        // =======================================================================================================================================
        $query = "DELETE FROM itemstock_transaction_detail  WHERE ItemStockID IN (   SELECT
                                                                                                deproomdetailsub.ItemStockID 
                                                                                            FROM
                                                                                                deproomdetailsub
                                                                                            WHERE deproomdetailsub.ID = '$value'  )
                            AND departmentroomid = '$deproomid' 
                            AND  IsStatus = '1'  ";
        $meQuery = $conn->prepare($query);
        $meQuery->execute();
        // =======================================================================================================================================



    }

    $cnt = 0;
    $sql = "SELECT COUNT ( deproomdetailsub.ID ) AS cnt 
            FROM
                deproomdetail
                INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID 
            WHERE
                deproomdetail.DocNo = '$DocNo' 
                AND deproomdetailsub.IsStatus = 3 ";
    $meQuery = $conn->prepare($sql);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $cnt = $row['cnt'];
    }

    if ($cnt == '0') {
        $sql1 = " UPDATE deproom SET deproom.IsStatus_return = 2   WHERE deproom.DocNo = '$DocNo' ";
        $meQuery1 = $conn->prepare($sql1);
        $meQuery1->execute();
    }


    echo json_encode($cnt);
    unset($conn);
    die;
}


function show_detail_ByDocNo($conn)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $DocNo = $_POST['DocNo'];


    // $select_date_history_s = explode("-", $select_date_history_s);
    // $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];



    $query = " SELECT
                    item.itemname,
                    itemstock.UsageCode ,
                    deproomdetailsub.IsStatus,
                    deproomdetailsub.ID,
                    itemtype.TyeName
                FROM
                    deproomdetail
                    INNER JOIN deproomdetailsub ON deproomdetail.ID = deproomdetailsub.Deproomdetail_RowID
                    INNER JOIN itemstock ON deproomdetailsub.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN itemtype ON item.itemtypeID = itemtype.ID
                WHERE
                    deproomdetail.DocNo = '$DocNo' 
                   AND (  deproomdetailsub.IsStatus = 3 OR deproomdetailsub.IsStatus = 5)
                   AND ( deproomdetailsub.dental_warehouse_id_borrow IS NULL OR   deproomdetailsub.dental_warehouse_id_borrow = '' )  ";

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
    $DepID = $_SESSION['DepID'];
    // $select_Date = $_POST['select_Date'];


    // $select_Date = explode("-", $select_Date);
    // $select_Date = $select_Date[2] . '-' . $select_Date[1] . '-' . $select_Date[0];


//  AND CONVERT(DATE,deproom.CreateDate) = '$select_Date'

    $query = " SELECT
                    departmentroom.departmentroomname ,
                    departmentroom.id ,
                    (
                        SELECT COUNT(deproom.DocNo) FROM deproom WHERE   deproom.IsStatus_return = 1 	AND deproom.Ref_departmentroomid = departmentroom.id  
                    )	AS cnt 
                FROM
                    departmentroom 
                WHERE departmentroom.IsMainroom = 0
                GROUP BY
                    departmentroom.departmentroomname ,
                    departmentroom.id
                ORDER BY cnt DESC  ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function show_detail_Bydeproom($conn)
{
    $return = array();
    $DepID = $_SESSION['DepID'];
    $id = $_POST['id'];


    // $select_date_history_s = explode("-", $select_date_history_s);
    // $select_date_history_s = $select_date_history_s[2] . '-' . $select_date_history_s[1] . '-' . $select_date_history_s[0];



    // $select_Date = $_POST['select_Date'];


    // $select_Date = explode("-", $select_Date);
    // $select_Date = $select_Date[2] . '-' . $select_Date[1] . '-' . $select_Date[0];
    // -- AND CONVERT(DATE,deproom.CreateDate) = '$select_Date'

    $query = "SELECT
                    deproom.DocNo ,
                    [procedure].Procedure_TH,
                    deproom.hn_record_id ,
                    (

                        SELECT COUNT
                                ( deproomdetailsub.ID ) 
                        FROM
                                deproomdetailsub
                                INNER JOIN deproomdetail ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID 
                        WHERE
                                deproomdetail.DocNo = deproom.DocNo
                                AND  deproomdetailsub.IsStatus = 3
		                        AND ( deproomdetailsub.dental_warehouse_id_borrow IS NULL OR   deproomdetailsub.dental_warehouse_id_borrow = '' )

                ) AS cnt_sub ,
                deproom.IsStatus_return
                FROM
                    dbo.deproom
                    INNER JOIN dbo.[procedure] ON deproom.[procedure] = [procedure].ID
                    INNER JOIN dbo.deproomdetail ON deproom.DocNo = deproomdetail.DocNo 
                WHERE
                    (deproom.IsStatus_return = 1 OR deproom.IsStatus_return = 2)
                    AND deproom.Ref_departmentroomid = $id 
                GROUP BY
                    deproom.DocNo,
                    [procedure].Procedure_TH,
                    deproom.hn_record_id,
                    deproom.IsStatus_return ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
