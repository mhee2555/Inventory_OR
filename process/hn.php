<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';
require '../process/Createdeproom.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'show_detail_hn') {
        show_detail_hn($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'feeddata_hncode_detail') {
        feeddata_hncode_detail($conn, $db);
    } else  if ($_POST['FUNC_NAME'] == 'feeddata_hncode') {
        feeddata_hncode($conn, $db);
    }
}

function feeddata_hncode($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];


    $input_type_search = $_POST['input_type_search'];
    $input_search = $_POST['input_search'];

    $where = "";
    if ($input_type_search == 1) {
        $where = "AND hncode.HnCode LIKE '%$input_search%' ";
    } else {
        $where = "AND itemstock.UsageCode LIKE '%$input_search%' ";
    }

    if ($db == 1) {

        $query = "SELECT
                        hncode.ID,
                        hncode.DocNo,
                        DATE_FORMAT(hncode.DocDate, '%d-%m-%Y') AS DocDate,
                        hncode.HnCode,
                        departmentroom.departmentroomname,
                        COALESCE(doctor.Doctor_Name_EN, '-') AS Doctor_Name,
                        COALESCE(`procedure`.Procedure_EN, '-') AS Procedure_TH
                    FROM
                        hncode
                    INNER JOIN
                        departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN
                        hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN
                        itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN
                        item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN
                        doctor ON doctor.ID = hncode.doctor
                    LEFT JOIN
                        `procedure` ON `procedure`.ID = hncode.`procedure`
                    WHERE
                        hncode.IsStatus = 1
                        AND hncode.IsCancel = 0
                        $where
                    GROUP BY
                        hncode.ID,
                        hncode.DocNo,
                        DATE_FORMAT(hncode.DocDate, '%d-%m-%Y'),
                        hncode.HnCode,
                        departmentroom.departmentroomname,
                        doctor.Doctor_Name_EN,
                        `procedure`.Procedure_EN
                    ORDER BY
                        hncode.ID ASC ";
    } else {
        $query = "SELECT
                        hncode.ID,
                        hncode.DocNo,
                        FORMAT ( hncode.DocDate, 'dd-MM-yyyy' ) AS DocDate ,
                        hncode.HnCode,
                        departmentroom.departmentroomname,
                        ISNULL(doctor.Doctor_Name_EN, '-' ) AS Doctor_Name ,
                        ISNULL( [procedure].Procedure_EN , '-' ) AS Procedure_TH
                    FROM
                        hncode
                        INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                        INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                        INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                        INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                        LEFT JOIN doctor ON doctor.ID = hncode.doctor
                        LEFT JOIN [procedure] ON [procedure].ID = hncode.[procedure]
                    WHERE
                        hncode.IsStatus = 1
                        AND hncode.IsCancel = 0  
                        $where
                        -- AND itemstock.Isdeproom = '1' 
                    GROUP BY 
                        hncode.ID , 
                        hncode.DocNo , 
                        FORMAT ( hncode.DocDate, 'dd-MM-yyyy' ),
                        hncode.HnCode ,
                        departmentroom.departmentroomname,
                        doctor.Doctor_Name_EN,
                        [procedure].Procedure_EN 
                    ORDER BY
                        hncode.ID ASC ";
    }


    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function feeddata_hncode_detail($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];
    $DocNo = $_POST['DocNo'];
    $HnCode = $_POST['HnCode'];



    // $input_type_search = $_POST['input_type_search'];
    // $input_search = $_POST['input_search'];

    // $where = "";
    // if ($input_type_search == 1) {
    //     $where = "AND hncode.HnCode LIKE '%$input_search%' ";
    // }else{
    //     $where = "AND itemstock.UsageCode LIKE '%$input_search%' ";
    // } 


            // $D = "DELETE 
            //         FROM
            //             hncode_detail 
            //         WHERE
            //             hncode_detail.DocNo = '$DocNo' 
            //             AND hncode_detail.ItemStockID NOT IN (
            //             SELECT
            //                 itemstock.RowID 
            //             FROM
            //                 itemstock 
            //             WHERE
            //                 itemstock.Isdeproom = '1' 
            //             AND itemstock.HNCode = '$HnCode' 
            //             )
            //             AND hncode_detail.ItemCode IS NULL  ";

            // $meQuery_D = $conn->prepare($D);
            // $meQuery_D->execute();

            // $D2 = "DELETE 
            // FROM
            //     itemstock_transaction_detail 
            // WHERE
            //     itemstock_transaction_detail.ItemStockID NOT IN (
            //     SELECT
            //         itemstock.RowID 
            //     FROM
            //         itemstock 
            //     WHERE
            //         itemstock.Isdeproom = '1' 
            //     AND itemstock.HNCode = '$HnCode' 
            //     )  ";

    // $meQuery_D2 = $conn->prepare($D2);
    // $meQuery_D2->execute();

    if ($db == 1) {
        $query = " SELECT
                        hncode.ID,
                        item.itemname,
                        item.LimitUse,
                        itemtype.TyeName,
                        itemstock.UsageCode,
                        item.itemcode,
                        DATE_FORMAT(hncode.DocDate, '%d-%m-%Y') AS DocDate,
                        hncode.HnCode,
                        hncode_detail.LastSterileDetailID,
                        departmentroom.departmentroomname,
                        hncode_detail.Qty,
                        item2.itemname AS itemname2,
	                    item2.itemcode AS itemcode2,
                        type2.TyeName AS TyeName2,
                        itemstock.serielNo,
                        itemstock.lotNo,
                        DATE_FORMAT( itemstock.ExpireDate, '%d-%m-%Y' ) AS ExpireDate
                    FROM
                        hncode
                    LEFT JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    LEFT JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    LEFT JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN itemtype ON itemtype.ID = item.itemtypeID
                    LEFT JOIN item AS item2 ON item2.ItemCode = hncode_detail.ItemCode
                    LEFT JOIN itemtype as type2 ON type2.ID = item2.itemtypeID
                    WHERE
                        hncode.IsStatus = 1
                        AND hncode.IsCancel = 0
                        AND hncode_detail.IsStatus != 99
                        AND hncode.DocNo = '$DocNo'
                    ORDER BY
                        hncode.ID ASC;  ";
    } else {
        $query = "SELECT
                    hncode.ID,
                    item.itemname,
                    item.LimitUse,
                    itemtype.TyeName,
                    itemstock.UsageCode,
                    item.itemcode,
                    FORMAT ( hncode.DocDate, 'dd-MM-yyyy' ) AS DocDate ,
                    hncode.HnCode,
                    hncode_detail.LastSterileDetailID,
                    departmentroom.departmentroomname,
                    sudslog.UsedCount
                FROM
                    hncode
                    INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode 
                    INNER JOIN itemtype ON itemtype.ID = item.itemtypeID 
                    LEFT JOIN sudslog ON sudslog.UniCode = itemstock.UsageCode 
                WHERE
                    hncode.IsStatus = 1
                    AND hncode.IsCancel = 0 
                    AND hncode_detail.IsStatus != 99 
                    AND hncode.DocNo = '$DocNo'
                    -- AND ( itemstock.IsDamage IS NULL OR  itemstock.IsDamage = 0 )
                ORDER BY
                    hncode.ID ASC ";
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
function show_detail_hn($conn, $db)
{
    $return = array();
    $deproom = $_SESSION['deproom'];

    $select_SDate = $_POST['select_SDate'];
    $select_SDate = explode("-", $select_SDate);
    $select_SDate = $select_SDate[2] . '-' . $select_SDate[1] . '-' . $select_SDate[0];

    $select_EDate = $_POST['select_EDate'];
    $select_EDate = explode("-", $select_EDate);
    $select_EDate = $select_EDate[2] . '-' . $select_EDate[1] . '-' . $select_EDate[0];

    $input_type_search = $_POST['input_type_search'];
    $input_search = $_POST['input_search'];

    $where = "";
    if ($input_type_search == 1) {
        $where = "AND hncode.HnCode LIKE '%$input_search%' ";
    } else {
        $where = "AND itemstock.UsageCode LIKE '%$input_search%' ";
    }


    if ($db == 1) {
        $query = "SELECT
                    hncode.ID,
                    DATE_FORMAT(hncode.DocDate, '%d-%m-%Y') AS DocDate,
                    hncode.HnCode,
                    hncode.DocNo,
                    departmentroom.departmentroomname,
                    COALESCE(doctor.Doctor_Name_EN, '-') AS Doctor_Name,
                    COALESCE(`procedure`.Procedure_EN, '-') AS Procedure_TH,
                    hncode.doctor ,
                    hncode.`procedure`
                FROM
                    hncode
                INNER JOIN
                    departmentroom ON departmentroom.id = hncode.departmentroomid
                LEFT JOIN
                    doctor ON doctor.ID = hncode.doctor
                LEFT JOIN
                    `procedure` ON `procedure`.ID = hncode.`procedure`
                LEFT JOIN
                        hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                LEFT JOIN
                        itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                WHERE
                    hncode.IsStatus = 1
                    AND hncode.IsCancel = 0
                    $where
                    AND DATE(hncode.DocDate) BETWEEN '$select_SDate' AND '$select_EDate'
                GROUP BY hncode.DocNo
                ORDER BY
                    hncode.ID ASC ";
    } else {
        $query = " SELECT
                        hncode.ID,
                        FORMAT ( hncode.DocDate, 'dd-MM-yyyy' ) AS DocDate ,
                        hncode.HnCode,
                        hncode.DocNo,
                        departmentroom.departmentroomname,
                        ISNULL(doctor.Doctor_Name_EN, '-' ) AS Doctor_Name ,
                        ISNULL( [procedure].Procedure_EN , '-' ) AS Procedure_TH,
                        hncode.doctor ,
                        hncode.`procedure`
                    FROM
                        hncode
                        INNER JOIN departmentroom ON departmentroom.id = hncode.departmentroomid
                        LEFT JOIN doctor ON doctor.ID = hncode.doctor
                        LEFT JOIN [procedure] ON [procedure].ID = hncode.[procedure]
                    WHERE
                        hncode.IsStatus = 1
                        AND hncode.IsCancel = 0  
                        AND	CONVERT ( DATE, hncode.DocDate ) BETWEEN  '$select_SDate'  AND '$select_EDate'
                        -- AND itemstock.Isdeproom = '1' 
                    ORDER BY
                        hncode.ID ASC ";
    }

    // echo $query;
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {

        if (str_contains($row['procedure'], ',')) {
            $row['Procedure_TH'] = 'button';
        }
        if (str_contains($row['doctor'], ',')) {
            $row['Doctor_Name'] = 'button';
        }
        
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}
