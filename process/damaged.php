<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_damage') {
        show_detail_damage($conn);
    }
}

function show_detail_damage($conn)
{
    $return = [];
    $query = "SELECT
                    damagedetail.Remark,
                    deproomdetailsub.isDamage,
                    departmentroom.departmentroomname ,
                    item.itemname ,
                    damagedetail.images 
                FROM
                    deproomdetailsub
                    INNER JOIN deproomdetail ON deproomdetailsub.Deproomdetail_RowID = deproomdetail.ID
                    INNER JOIN deproom ON deproomdetail.DocNo = deproom.DocNo
                    INNER JOIN damagedetail ON deproomdetailsub.ID = damagedetail.deproomdetailsub_id
                    INNER JOIN departmentroom ON departmentroom.id = deproom.Ref_departmentroomid
                    INNER JOIN itemstock ON itemstock.RowID = deproomdetailsub.ItemStockID
                    INNER JOIN item ON item.itemcode = itemstock.ItemCode 
                WHERE
                    deproomdetailsub.isDamage = 2 ";
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
