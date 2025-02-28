<?php
session_start();
require '../config/db.php';
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'onconfirm_CreateItemSUDs') {
        onconfirm_CreateItemSUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showItemSUDs') {
        showItemSUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_CreateDocNoSUDs') {
        onconfirm_CreateDocNoSUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDocNoSUDs') {
        showDocNoSUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'SaveUsage_SUDs') {
        SaveUsage_SUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showUsageCodeSUDs') {
        showUsageCodeSUDs($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'EditUsage_SUDs') {
        EditUsage_SUDs($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_CreateItemSterile') {
        onconfirm_CreateItemSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showItemSterile') {
        showItemSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_CreateDocNoSterile') {
        onconfirm_CreateDocNoSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDocNoSterile') {
        showDocNoSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'SaveUsage_Sterile') {
        SaveUsage_Sterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showUsageCodeSterile') {
        showUsageCodeSterile($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'EditUsage_Sterile') {
        EditUsage_Sterile($conn, $db);
    }else if ($_POST['FUNC_NAME'] == 'onconfirm_CreateItemimplant') {
        onconfirm_CreateItemimplant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showItemimplant') {
        showItemimplant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'onconfirm_CreateDocNoimplant') {
        onconfirm_CreateDocNoimplant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showDocNoimplant') {
        showDocNoimplant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'SaveUsage_implant') {
        SaveUsage_implant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'showUsageCodeimplant') {
        showUsageCodeimplant($conn, $db);
    } else if ($_POST['FUNC_NAME'] == 'EditUsage_implant') {
        EditUsage_implant($conn, $db);
    }
}

function EditUsage_implant($conn, $db)
{
    $return = array();
    $modal_input_serie_implant = $_POST['modal_input_serie_implant'];
    $modal_input_lot_implant = $_POST['modal_input_lot_implant'];
    $modal_input_exp_implant = $_POST['modal_input_exp_implant'];
    $modal_input_register_implant = $_POST['modal_input_register_implant'];
    $modal_input_qty_implant = $_POST['modal_input_qty_implant'];
    $UsageCode = $_POST['UsageCode'];

    $modal_input_exp_implant = $modal_input_exp_implant;
    $modal_input_exp_implant = explode("-", $modal_input_exp_implant);
    $modal_input_exp_implant = $modal_input_exp_implant[2] . '-' . $modal_input_exp_implant[1] . '-' . $modal_input_exp_implant[0];

    $query = "UPDATE itemstock SET
                            serielNo = '$modal_input_serie_implant', 
                            lotNo = '$modal_input_lot_implant', 
                            expDate = '$modal_input_exp_implant',
                            ExpireDate = '$modal_input_exp_implant'
                    WHERE UsageCode = '$UsageCode'  ";

                    $meQuery2 = $conn->prepare($query);
                    $meQuery2->execute();


}

function SaveUsage_implant($conn, $db)
{
    $return = array();
    $ArraySerie = $_POST['ArraySerie'];
    $Arraylot = $_POST['Arraylot'];
    $Arrayexp = $_POST['Arrayexp'];
    $Arrayregister = $_POST['Arrayregister'];
    $ArrayQty = $_POST['ArrayQty'];
    $input_ItemCode1_implant = $_POST['input_ItemCode1_implant'];

    foreach ($ArrayQty as $key => $value) {

        $DateExp = $Arrayexp[$key];
        $DateExp = explode("-", $DateExp);
        $DateExp = $DateExp[2] . '-' . $DateExp[1] . '-' . $DateExp[0];

        $DateRegis = $Arrayregister[$key];
        $DateRegis = explode("-", $DateRegis);
        $DateRegis = $DateRegis[2] . '-' . $DateRegis[1] . '-' . $DateRegis[0];

        for ($i = 0; $i < intval($value); $i++) {


            if($db == 1){
                $gen_usage = "SELECT COALESCE(
                                    (SELECT 
                                        CONCAT(
                                            its.ItemCode,
                                            '-',
                                            LPAD(CAST(SUBSTRING(COALESCE(its.UsageCode, '0'), 11, 3) AS UNSIGNED) + 1, 3, '0')
                                        )
                                    FROM itemstock AS its
                                    WHERE its.ItemCode = '$input_ItemCode1_implant'
                                    ORDER BY its.UsageCode DESC
                                    LIMIT 1),
                                    CONCAT(
                                        '$input_ItemCode1_implant',
                                        '-001'
                                    )
                                ) AS _UsageCode ";
            }else{
                $gen_usage = "SELECT COALESCE
                (
                    (
                    SELECT TOP
                        1 CONCAT (
                            its.ItemCode,
                            '-',
                            RIGHT (
                                REPLICATE( '0',3  ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( its.UsageCode, '0' ), 11, 13 ) ) + 1 ),
                            3 
                            ) 
                        ) 
                    FROM
                        itemstock AS its 
                    WHERE
                        its.ItemCode = '$input_ItemCode1_implant' 
                    ORDER BY
                        its.UsageCode DESC 
                    ),
                    CONCAT (
                        '$input_ItemCode1_implant',
                        '-001' 
                    ) 
                ) AS _UsageCode ";
            }


            $meQuery = $conn->prepare($gen_usage);
            $meQuery->execute();
            while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                $_UsageCode = $row['_UsageCode'];

                $query = "INSERT INTO itemstock ( 
                                                                     CreateDate ,
                                                                     ItemCode,
                                                                     UsageCode, 
                                                                     serielNo, 
                                                                     lotNo, 
                                                                     expDate,
                                                                     Isdeproom,
                                                                     departmentroomid,
                                                                     IsPrintDept,
                                                                     IsStatus,
                                                                     ExpireDate
                                                                    ) VALUES 
                                                                    (
                                                                        '$DateRegis',
                                                                        '$input_ItemCode1_implant',
                                                                        '$_UsageCode' , 
                                                                        '$ArraySerie[$key]' , 
                                                                        '$Arraylot[$key]' , 
                                                                        '$DateExp',
                                                                        0,
                                                                        35,
                                                                        0,
                                                                        5,
                                                                        '$DateExp'
                                                                    )  ";

                $meQuery2 = $conn->prepare($query);
                $meQuery2->execute();
            }
        }
    }
}

function showDocNoimplant($conn, $db)
{
    $return = array();
    $input_ItemCode1_implant = $_POST['input_ItemCode1_implant'];


    if($db == 1){
        $query = " SELECT
                        item_document.ID,
                        item_document.ProductID,
                        item_document.ItemType_ID,
                        item_document.DocumentTypeID,
                        item_document.DocumentNo,
                        DATE(item_document.DocApprovedDate) AS DocApprovedDate,
                        DATE(item_document.DocExpireDate) AS DocExpireDate,
                        item_document.Description,
                        item_document.IsActive,
                        item_document.DocFileName,
                        item_document.DocumentVersion,
                        item_document.SiteName,
                        document_type.DocumentType
                    FROM
                        item_document
                    INNER JOIN
                        document_type ON item_document.DocumentTypeID = document_type.ID
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_implant'
                        AND item_document.IsActive = 1 ";
    }else{
        $query = "SELECT
                item_document.ID,
                item_document.ProductID,
                item_document.ItemType_ID,
                item_document.DocumentTypeID,
                item_document.DocumentNo,
                CONVERT(DATE,item_document.DocApprovedDate) AS DocApprovedDate,
                CONVERT(DATE,item_document.DocExpireDate) AS DocExpireDate,
                item_document.Description,
                item_document.IsActive,
                item_document.DocFileName,
                item_document.DocumentVersion,
                item_document.SiteName ,
	            document_type.DocumentType
            FROM
                dbo.item_document
            INNER JOIN document_type ON item_document.DocumentTypeID = document_type.ID
            WHERE item_document.ProductID = '$input_ItemCode1_implant' AND item_document.IsActive = 1   ";
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

function showItemimplant($conn, $db)
{
    $return = array();
    // $input_Search = $_POST['input_search_request'];
    $input_modal_search_implant = $_POST['input_modal_search_implant'];
    

    $query = "SELECT
                    item.itemcode,
                    item.itemcode2,
                    item.itemname AS Item_name ,
                    itemtype.TyeName ,
                    item.IsCancel,
                    item.CostPrice,
                    item.SalePrice,
                    item.SupllierID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect,
                    (SELECT COUNT(*) FROM item_document WHERE item_document.ProductID = item.itemcode AND item_document.IsActive = 1  ) AS cnt_item_document
                FROM
                    item
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND itemtype.ID = '43'
                    AND ( item.itemname LIKE '%$input_modal_search_implant%' OR item.itemcode LIKE '%$input_modal_search_implant%' )
                GROUP BY
                    item.ItemCode,
                    item.itemname,
                    itemtype.TyeName,
                    item.itemcode2,
                    item.IsCancel,
                    item.CostPrice,
                    item.SalePrice,
                    item.SupllierID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect
                ORDER BY item.itemcode DESC  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['CostPrice'] == null) {
            $row['CostPrice'] = "";
        }
        if ($row['cnt_item_document'] == '0') {
            $row['item_document_ID'] = "red";
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showUsageCodeimplant($conn, $db)
{
    $return = array();
    $input_ItemCode1_implant = $_POST['input_ItemCode1_implant'];

    if($db == 1){
        $query = " SELECT
                        itemstock.serielNo,
                        itemstock.UsageCode,
                        itemstock.lotNo,
                        DATE_FORMAT(itemstock.expDate, '%d-%m-%Y') AS expDate,
                        DATE_FORMAT(itemstock.CreateDate, '%d-%m-%Y') AS CreateDate,
                        itemstock.ItemCode
                    FROM
                        itemstock
                    WHERE
                        itemstock.ItemCode = '$input_ItemCode1_implant';  ";
    }else{
        $query = " SELECT
                    itemstock.serielNo,
                    itemstock.UsageCode,
                    itemstock.lotNo,
                    FORMAT(itemstock.expDate,'dd-MM-yyyy') AS expDate,
                    FORMAT(itemstock.CreateDate,'dd-MM-yyyy') AS CreateDate,
                    itemstock.ItemCode 
                FROM
                    itemstock
                WHERE itemstock.ItemCode = '$input_ItemCode1_implant'  ";
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

function onconfirm_CreateItemimplant($conn, $db)
{
    $input_ItemCode1_implant = $_POST['input_ItemCode1_implant'];
    $input_ItemName_implant = $_POST['input_ItemName_implant'];
    $input_CostPrice_implant = $_POST['input_CostPrice_implant'];
    $select_Procedure_implant = $_POST['select_Procedure_implant'];
    $select_Style_implant = $_POST['select_Style_implant'];
    $radio_CheckActive_implant = $_POST['radio_CheckActive_implant'];

    $input_Vendor_implant = $_POST['input_Vendor_implant'];
    $input_SalePrice_implant = $_POST['input_SalePrice_implant'];


    $Data_image1_implant = $_POST['Data_image1_implant'];
    $Data_image2_implant = $_POST['Data_image2_implant'];

    if (isset($_FILES['image1_implant'])) {
        $filename1 = $_FILES['image1_implant']['name'];
    }
    if (isset($_FILES['image2_implant'])) {
        $filename2 = $_FILES['image2_implant']['name'];
    }

    $return = [];

    if ($input_ItemCode1_implant == "") {

        if($db == 1){
            $genItem = "SELECT CONCAT('I',DATE_FORMAT(CURDATE(), '%y'),DATE_FORMAT(CURDATE(), '%m'),LPAD(CAST(SUBSTRING(COALESCE(item.itemcode, '0'), 4, 6) AS UNSIGNED) + 1, 4, '0')) AS itemCode
                        FROM item
                        WHERE itemcode LIKE '%M%'
                        ORDER BY itemcode DESC
                        LIMIT 1 ";
        }else{
            $genItem = "SELECT TOP
            1 CONCAT (
                'I',
                FORMAT ( GETDATE( ), 'yy' ),
                FORMAT ( GETDATE( ), 'MM' ),
                RIGHT (
                    REPLICATE( '0', 4 ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( item.itemcode, '0' ), 4, 9 ) ) + 1 ), + 4 
                ) 
            ) AS itemCode
        FROM
            item 
        WHERE
            itemcode LIKE '%M%' 
        ORDER BY
            itemcode DESC ";
        }



        $meQuery = $conn->prepare($genItem);
        $meQuery->execute();

        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $I_C = $row['itemCode'];
        }
    } else {
        $I_C = $input_ItemCode1_implant;
    }


    if ($input_ItemCode1_implant == "") {

        if (isset($_FILES['image1_implant'])) {
            copy($_FILES['image1_implant']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = " '$filename1' , ";
        } else {
            $updatePic1 = " NULL , ";
        }
        if (isset($_FILES['image2_implant'])) {
            copy($_FILES['image2_implant']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = " '$filename2' , ";
        } else {
            $updatePic2 = " NULL , ";
        }

    }else{
        if (isset($_FILES['image1_implant'])) {
            copy($_FILES['image1_implant']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = "Picture  = '$filename1' , ";
        } else {
            if ($Data_image1_implant == 'default') {
                $updatePic1 = "Picture  = NULL , ";
            } else {
                $updatePic1 = "";
            }
        }
        if (isset($_FILES['image2_implant'])) {
            copy($_FILES['image2_implant']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = "Picture2  = '$filename2' , ";
        } else {
            if ($Data_image2_implant == 'default') {
                $updatePic2 = "Picture2  = NULL , ";
            } else {
                $updatePic2 = "";
            }
        }
    }


    $return = 1;
    if ($input_ItemCode1_implant == "") {
        $queryInsert = "INSERT INTO item ( itemcode, itemname ,CostPrice  ,IsCancel ,itemtypeID,Picture,Picture2,IsNormal,procedureID,Description,SupllierID,SalePrice)
                        VALUES
                            ( '$I_C',
                            '$input_ItemName_implant',
                            '$input_CostPrice_implant',
                            '$radio_CheckActive_implant',
                            43,
                            $updatePic1 
                            $updatePic2 
                            1,
                            $select_Procedure_implant,
                            '$select_Style_implant',
                            '$input_Vendor_implant',
                            '$input_SalePrice_implant'
                                )";

                        
                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    } else {
        $queryInsert = "UPDATE item SET   itemname = '$input_ItemName_implant',
                                          CostPrice = '$input_CostPrice_implant',
                                          IsCancel = '$radio_CheckActive_implant',
                                          $updatePic1
                                          $updatePic2
                                          IsNormal = 1,
                                          procedureID = $select_Procedure_implant ,
                                          Description = '$select_Style_implant',
                                          SupllierID = '$input_Vendor_implant',
                                          SalePrice = '$input_SalePrice_implant'

                        WHERE itemcode = '$I_C' ";

                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    }



    echo json_encode($queryInsert);
    unset($conn);
    die;
    // }


}

function onconfirm_CreateDocNoimplant($conn, $db)
{
    $input_ItemCode1_implant = $_POST['input_ItemCode1_implant'];
    $select_typeDocument_implant = $_POST['select_typeDocument_implant'];
    $input_DocNo_implant = $_POST['input_DocNo_Sterile'];
    $input_ApproveDate_implant = $_POST['input_ApproveDate_implant'];
    $input_ExpDate_implant = $_POST['input_ExpDate_implant'];
    $checkbox_NoExp_implant = $_POST['checkbox_NoExp_implant'];
    $input_Des_implant = $_POST['input_Des_implant'];
    $Data_FileDocNo_implant = $_POST['Data_FileDocNo_implant'];

    $input_ApproveDate_implant = explode("-", $input_ApproveDate_implant);
    $input_ApproveDate_implant = $input_ApproveDate_implant[2] . '-' . $input_ApproveDate_implant[1] . '-' . $input_ApproveDate_implant[0];

    $input_ExpDate_implant = explode("-", $input_ExpDate_implant);
    $input_ExpDate_implant = $input_ExpDate_implant[2] . '-' . $input_ExpDate_implant[1] . '-' . $input_ExpDate_implant[0];


    if (isset($_FILES['input_FileDocNo_implant'])) {
        $filename1 = $_FILES['input_FileDocNo_implant']['name'];
    }



    $check_row = 0;
    $Version = 1;

    if($db == 1){
        $query1 = " SELECT
                        item_document.ID,
                        item_document.DocumentVersion
                    FROM
                        item_document
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_implant'
                        AND item_document.DocumentTypeID = '$select_typeDocument_implant'
                        AND item_document.IsActive = 1
                    ORDER BY
                        item_document.DocumentVersion DESC
                    LIMIT 1 ";
    }else{
        $query1 = " SELECT TOP 1
                        item_document.ID,
                        item_document.DocumentVersion
                    FROM
                        item_document 
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_implant' 
                        AND item_document.DocumentTypeID = '$select_typeDocument_implant' 
                        AND item_document.IsActive = 1
                    ORDER BY
                        item_document.DocumentVersion DESC ";
        }

    $meQuery = $conn->prepare($query1);
    $meQuery->execute();

    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $check_row++;
        $_ID = $row['ID'];
        $_DocumentVersion = $row['DocumentVersion'];

        $updateD = "UPDATE item_document SET item_document.IsActive = 0 WHERE item_document.ID = '$_ID' ";
        $meQueryD = $conn->prepare($updateD);
        $meQueryD->execute();

        $Version = $_DocumentVersion + 1;
    }

    if (isset($_FILES['input_FileDocNo_implant'])) {
        copy($_FILES['input_FileDocNo_implant']['tmp_name'], '../assets/file/' . $_FILES['input_FileDocNo_implant']['name'] . '-' . $Version . '.pdf');
        $filename1 = $_FILES['input_FileDocNo_implant']['name'] . '-' . $Version . '.pdf';
        $updatePic1 = " '$filename1' , ";
    } else {
        $updatePic1 = " NULL , ";
    }

    $insert = "INSERT INTO item_document (ProductID,ItemType_ID,DocumentTypeID,DocumentNo,DocApprovedDate,DocExpireDate,Description,IsActive,DocFileName,DocumentVersion,SiteName) 
                VALUES 
                (
                    '$input_ItemCode1_implant',
                    44,
                    $select_typeDocument_implant,
                    '$input_DocNo_implant',
                    '$input_ApproveDate_implant',
                    '$input_ExpDate_implant',
                    '$input_Des_implant',
                    1,
                    $updatePic1
                    $Version,
                    'BMC'
                )";
    $meQueryIn = $conn->prepare($insert);
    $meQueryIn->execute();
}



function EditUsage_Sterile($conn, $db)
{
    $return = array();
    $modal_input_serie_Sterile = $_POST['modal_input_serie_Sterile'];
    $modal_input_lot_Sterile = $_POST['modal_input_lot_Sterile'];
    $modal_input_exp_Sterile = $_POST['modal_input_exp_Sterile'];
    $modal_input_register_Sterile = $_POST['modal_input_register_Sterile'];
    $modal_input_qty_Sterile = $_POST['modal_input_qty_Sterile'];
    $UsageCode = $_POST['UsageCode'];

    $modal_input_exp_Sterile = $modal_input_exp_Sterile;
    $modal_input_exp_Sterile = explode("-", $modal_input_exp_Sterile);
    $modal_input_exp_Sterile = $modal_input_exp_Sterile[2] . '-' . $modal_input_exp_Sterile[1] . '-' . $modal_input_exp_Sterile[0];

    $query = "UPDATE itemstock SET
                            serielNo = '$modal_input_serie_Sterile', 
                            lotNo = '$modal_input_lot_Sterile', 
                            expDate = '$modal_input_exp_Sterile',
                            ExpireDate = '$modal_input_exp_Sterile'
                    WHERE UsageCode = '$UsageCode'  ";

                    $meQuery2 = $conn->prepare($query);
                    $meQuery2->execute();


}

function SaveUsage_Sterile($conn, $db)
{
    $return = array();
    $ArraySerie = $_POST['ArraySerie'];
    $Arraylot = $_POST['Arraylot'];
    $Arrayexp = $_POST['Arrayexp'];
    $Arrayregister = $_POST['Arrayregister'];
    $ArrayQty = $_POST['ArrayQty'];
    $input_ItemCode1_Sterile = $_POST['input_ItemCode1_Sterile'];

    foreach ($ArrayQty as $key => $value) {

        $DateExp = $Arrayexp[$key];
        $DateExp = explode("-", $DateExp);
        $DateExp = $DateExp[2] . '-' . $DateExp[1] . '-' . $DateExp[0];

        $DateRegis = $Arrayregister[$key];
        $DateRegis = explode("-", $DateRegis);
        $DateRegis = $DateRegis[2] . '-' . $DateRegis[1] . '-' . $DateRegis[0];

        for ($i = 0; $i < intval($value); $i++) {



            if($db == 1){
                $gen_usage = "SELECT COALESCE(
                                    (SELECT 
                                        CONCAT(
                                            its.ItemCode,
                                            '-',
                                            LPAD(CAST(SUBSTRING(COALESCE(its.UsageCode, '0'), 11, 3) AS UNSIGNED) + 1, 3, '0')
                                        )
                                    FROM itemstock AS its
                                    WHERE its.ItemCode = '$input_ItemCode1_Sterile'
                                    ORDER BY its.UsageCode DESC
                                    LIMIT 1),
                                    CONCAT(
                                        '$input_ItemCode1_Sterile',
                                        '-001'
                                    )
                                ) AS _UsageCode ";
            }else{
                $gen_usage = "SELECT COALESCE
                (
                    (
                    SELECT TOP
                        1 CONCAT (
                            its.ItemCode,
                            '-',
                            RIGHT (
                                REPLICATE( '0',3  ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( its.UsageCode, '0' ), 11, 13 ) ) + 1 ),
                            3 
                            ) 
                        ) 
                    FROM
                        itemstock AS its 
                    WHERE
                        its.ItemCode = '$input_ItemCode1_Sterile' 
                    ORDER BY
                        its.UsageCode DESC 
                    ),
                    CONCAT (
                        '$input_ItemCode1_Sterile',
                        '-001' 
                    ) 
                ) AS _UsageCode ";
            }



            $meQuery = $conn->prepare($gen_usage);
            $meQuery->execute();
            while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                $_UsageCode = $row['_UsageCode'];

                $query = "INSERT INTO itemstock ( 
                                                                     CreateDate ,
                                                                     ItemCode,
                                                                     UsageCode, 
                                                                     serielNo, 
                                                                     lotNo, 
                                                                     expDate,
                                                                     Isdeproom,
                                                                     departmentroomid,
                                                                     IsPrintDept,
                                                                     IsStatus,
                                                                     ExpireDate
                                                                    ) VALUES 
                                                                    (
                                                                        '$DateRegis',
                                                                        '$input_ItemCode1_Sterile',
                                                                        '$_UsageCode' , 
                                                                        '$ArraySerie[$key]' , 
                                                                        '$Arraylot[$key]' , 
                                                                        '$DateExp',
                                                                        0,
                                                                        35,
                                                                        0,
                                                                        5,
                                                                        '$DateExp'
                                                                    )  ";

                $meQuery2 = $conn->prepare($query);
                $meQuery2->execute();
            }
        }
    }
}

function showDocNoSterile($conn, $db)
{
    $return = array();
    $input_ItemCode1_Sterile = $_POST['input_ItemCode1_Sterile'];

    if($db == 1){
        $query = " SELECT
                        item_document.ID,
                        item_document.ProductID,
                        item_document.ItemType_ID,
                        item_document.DocumentTypeID,
                        item_document.DocumentNo,
                        DATE(item_document.DocApprovedDate) AS DocApprovedDate,
                        DATE(item_document.DocExpireDate) AS DocExpireDate,
                        item_document.Description,
                        item_document.IsActive,
                        item_document.DocFileName,
                        item_document.DocumentVersion,
                        item_document.SiteName,
                        document_type.DocumentType
                    FROM
                        item_document
                    INNER JOIN
                        document_type ON item_document.DocumentTypeID = document_type.ID
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_Sterile'
                        AND item_document.IsActive = 1 ";
    }else{
        $query = "SELECT
                item_document.ID,
                item_document.ProductID,
                item_document.ItemType_ID,
                item_document.DocumentTypeID,
                item_document.DocumentNo,
                CONVERT(DATE,item_document.DocApprovedDate) AS DocApprovedDate,
                CONVERT(DATE,item_document.DocExpireDate) AS DocExpireDate,
                item_document.Description,
                item_document.IsActive,
                item_document.DocFileName,
                item_document.DocumentVersion,
                item_document.SiteName ,
	            document_type.DocumentType
            FROM
                dbo.item_document
            INNER JOIN document_type ON item_document.DocumentTypeID = document_type.ID
            WHERE item_document.ProductID = '$input_ItemCode1_Sterile' AND item_document.IsActive = 1   ";
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

function showItemSterile($conn, $db)
{
    $return = array();
    // $input_Search = $_POST['input_search_request'];
    $input_modal_search_Sterile = $_POST['input_modal_search_Sterile'];
    

    $query = "SELECT
                    item.itemcode,
                    item.itemcode2,
                    item.itemname AS Item_name ,
                    itemtype.TyeName ,
                    item.IsCancel,
                    item.CostPrice,
                    item.SterileProcessID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect,
                    (SELECT COUNT(*) FROM item_document WHERE item_document.ProductID = item.itemcode AND item_document.IsActive = 1  ) AS cnt_item_document
                FROM
                    item
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND itemtype.ID = '44'
                    AND ( item.itemname LIKE '%$input_modal_search_Sterile%' OR item.itemcode LIKE '%$input_modal_search_Sterile%' )
                GROUP BY
                    item.ItemCode,
                    item.itemname,
                    itemtype.TyeName,
                    item.itemcode2,
                    item.IsCancel,
                    item.CostPrice,
                    item.SterileProcessID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect
                ORDER BY item.itemcode DESC  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['CostPrice'] == null) {
            $row['CostPrice'] = "";
        }
        if ($row['cnt_item_document'] == '0') {
            $row['item_document_ID'] = "red";
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showUsageCodeSterile($conn, $db)
{
    $return = array();
    $input_ItemCode1_Sterile = $_POST['input_ItemCode1_Sterile'];

    if($db == 1){
        $query = "SELECT
                        itemstock.serielNo,
                        itemstock.UsageCode,
                        itemstock.lotNo,
                        DATE_FORMAT(itemstock.expDate, '%d-%m-%Y') AS expDate,
                        DATE_FORMAT(itemstock.CreateDate, '%d-%m-%Y') AS CreateDate,
                        itemstock.ItemCode
                    FROM
                        itemstock
                    WHERE
                        itemstock.ItemCode = '$input_ItemCode1_Sterile' ";
    }else{
        $query = " SELECT
                    itemstock.serielNo,
                    itemstock.UsageCode,
                    itemstock.lotNo,
                    FORMAT(itemstock.expDate,'dd-MM-yyyy') AS expDate,
                    FORMAT(itemstock.CreateDate,'dd-MM-yyyy') AS CreateDate,
                    itemstock.ItemCode 
                FROM
                    itemstock
                WHERE itemstock.ItemCode = '$input_ItemCode1_Sterile'  ";
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

function onconfirm_CreateItemSterile($conn, $db)
{
    $input_ItemCode1_Sterile = $_POST['input_ItemCode1_Sterile'];
    $input_ItemCode2_Sterile = $_POST['input_ItemCode2_Sterile'];
    $input_ItemName_Sterile = $_POST['input_ItemName_Sterile'];
    $input_CostPrice_Sterile = $_POST['input_CostPrice_Sterile'];
    $select_Procedure_Sterile = $_POST['select_Procedure_Sterile'];
    $select_SterileProcecss_Sterile = $_POST['select_SterileProcecss_Sterile'];
    $select_Style_Sterile = $_POST['select_Style_Sterile'];
    $select_Howto_Sterile = $_POST['select_Howto_Sterile'];
    $radio_CheckActive_Sterile = $_POST['radio_CheckActive_Sterile'];


    $Data_image1_Sterile = $_POST['Data_image1_Sterile'];
    $Data_image2_Sterile = $_POST['Data_image2_Sterile'];

    if (isset($_FILES['image1_Sterile'])) {
        $filename1 = $_FILES['image1_Sterile']['name'];
    }
    if (isset($_FILES['image2_Sterile'])) {
        $filename2 = $_FILES['image2_Sterile']['name'];
    }

    $return = [];

    if ($input_ItemCode1_Sterile == "") {

        if($db == 1){
            $genItem = "SELECT CONCAT(
                                'M',
                                DATE_FORMAT(CURDATE(), '%y'),
                                DATE_FORMAT(CURDATE(), '%m'),
                                LPAD(CAST(SUBSTRING(COALESCE(item.itemcode, '0'), 4, 6) AS UNSIGNED) + 1, 4, '0')
                            ) AS itemCode
                            FROM item
                            WHERE itemcode LIKE '%M%'
                            ORDER BY itemcode DESC
                            LIMIT 1 ";
        }else{
            $genItem = "SELECT TOP
            1 CONCAT (
                'M',
                FORMAT ( GETDATE( ), 'yy' ),
                FORMAT ( GETDATE( ), 'MM' ),
                RIGHT (
                    REPLICATE( '0', 4 ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( item.itemcode, '0' ), 4, 9 ) ) + 1 ), + 4 
                ) 
            ) AS itemCode
        FROM
            item 
        WHERE
            itemcode LIKE '%M%' 
        ORDER BY
            itemcode DESC ";
        }


        $meQuery = $conn->prepare($genItem);
        $meQuery->execute();

        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $I_C = $row['itemCode'];
        }
    } else {
        $I_C = $input_ItemCode1_Sterile;
    }


    if ($input_ItemCode1_Sterile == "") {

        if (isset($_FILES['image1_Sterile'])) {
            copy($_FILES['image1_Sterile']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = " '$filename1' , ";
        } else {
            $updatePic1 = " NULL , ";
        }
        if (isset($_FILES['image2_Sterile'])) {
            copy($_FILES['image2_Sterile']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = " '$filename2' , ";
        } else {
            $updatePic2 = " NULL , ";
        }

    }else{
        if (isset($_FILES['image1_Sterile'])) {
            copy($_FILES['image1_Sterile']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = "Picture  = '$filename1' , ";
        } else {
            if ($Data_image1_Sterile == 'default') {
                $updatePic1 = "Picture  = NULL , ";
            } else {
                $updatePic1 = "";
            }
        }
        if (isset($_FILES['image2_Sterile'])) {
            copy($_FILES['image2_Sterile']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = "Picture2  = '$filename2' , ";
        } else {
            if ($Data_image2_Sterile == 'default') {
                $updatePic2 = "Picture2  = NULL , ";
            } else {
                $updatePic2 = "";
            }
        }
    }


    $return = 1;
    if ($input_ItemCode1_Sterile == "") {
        $queryInsert = "INSERT INTO item ( itemcode, itemcode2, itemname ,CostPrice ,SterileProcessID ,IsCancel ,itemtypeID,Picture,Picture2,IsNormal,procedureID,Description,ReuseDetect)
                        VALUES
                            ( '$I_C',
                            '$input_ItemCode2_Sterile',
                            '$input_ItemName_Sterile',
                            '$input_CostPrice_Sterile',
                            '$select_SterileProcecss_Sterile',
                            '$radio_CheckActive_Sterile',
                            44,
                            $updatePic1 
                            $updatePic2 
                            1,
                            $select_Procedure_Sterile,
                            '$select_Style_Sterile',
                            '$select_Howto_Sterile'
                                )";

                        
                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    } else {
        $queryInsert = "UPDATE item SET   itemcode2 = '$input_ItemCode2_Sterile',
                                          itemname = '$input_ItemName_Sterile',
                                          CostPrice = '$input_CostPrice_Sterile',
                                          SterileProcessID = '$select_SterileProcecss_Sterile' ,
                                          IsCancel = '$radio_CheckActive_Sterile',
                                          $updatePic1
                                          $updatePic2
                                          IsNormal = 1,
                                          procedureID = $select_Procedure_Sterile ,
                                          Description = '$select_Style_Sterile',
                                          ReuseDetect = '$select_Howto_Sterile'

                        WHERE itemcode = '$I_C' ";

                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    }



    echo json_encode($queryInsert);
    unset($conn);
    die;
    // }


}

function onconfirm_CreateDocNoSterile($conn, $db)
{
    $input_ItemCode1_Sterile = $_POST['input_ItemCode1_Sterile'];
    $select_typeDocument_Sterile = $_POST['select_typeDocument_Sterile'];
    $input_DocNo_Sterile = $_POST['input_DocNo_Sterile'];
    $input_ApproveDate_Sterile = $_POST['input_ApproveDate_Sterile'];
    $input_ExpDate_Sterile = $_POST['input_ExpDate_Sterile'];
    $checkbox_NoExp_Sterile = $_POST['checkbox_NoExp_Sterile'];
    $input_Des_Sterile = $_POST['input_Des_Sterile'];
    $Data_FileDocNo_Sterile = $_POST['Data_FileDocNo_Sterile'];

    $input_ApproveDate_Sterile = explode("-", $input_ApproveDate_Sterile);
    $input_ApproveDate_Sterile = $input_ApproveDate_Sterile[2] . '-' . $input_ApproveDate_Sterile[1] . '-' . $input_ApproveDate_Sterile[0];

    $input_ExpDate_Sterile = explode("-", $input_ExpDate_Sterile);
    $input_ExpDate_Sterile = $input_ExpDate_Sterile[2] . '-' . $input_ExpDate_Sterile[1] . '-' . $input_ExpDate_Sterile[0];


    if (isset($_FILES['input_FileDocNo_Sterile'])) {
        $filename1 = $_FILES['input_FileDocNo_Sterile']['name'];
    }



    $check_row = 0;
    $Version = 1;

    if($db == 1){
        $query1 = "SELECT
                        item_document.ID,
                        item_document.DocumentVersion
                    FROM
                        item_document
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_Sterile'
                        AND item_document.DocumentTypeID = '$select_typeDocument_Sterile'
                        AND item_document.IsActive = 1
                    ORDER BY
                        item_document.DocumentVersion DESC
                    LIMIT 1 ";
    }else{
        $query1 = " SELECT TOP 1
                    item_document.ID,
                    item_document.DocumentVersion
                FROM
                    item_document 
                WHERE
                    item_document.ProductID = '$input_ItemCode1_Sterile' 
                    AND item_document.DocumentTypeID = '$select_typeDocument_Sterile' 
                    AND item_document.IsActive = 1
                ORDER BY
                    item_document.DocumentVersion DESC ";
    }

    $meQuery = $conn->prepare($query1);
    $meQuery->execute();

    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $check_row++;
        $_ID = $row['ID'];
        $_DocumentVersion = $row['DocumentVersion'];

        $updateD = "UPDATE item_document SET item_document.IsActive = 0 WHERE item_document.ID = '$_ID' ";
        $meQueryD = $conn->prepare($updateD);
        $meQueryD->execute();

        $Version = $_DocumentVersion + 1;
    }

    if (isset($_FILES['input_FileDocNo_Sterile'])) {
        copy($_FILES['input_FileDocNo_Sterile']['tmp_name'], '../assets/file/' . $_FILES['input_FileDocNo_Sterile']['name'] . '-' . $Version . '.pdf');
        $filename1 = $_FILES['input_FileDocNo_Sterile']['name'] . '-' . $Version . '.pdf';
        $updatePic1 = " '$filename1' , ";
    } else {
        $updatePic1 = " NULL , ";
    }

    $insert = "INSERT INTO item_document (ProductID,ItemType_ID,DocumentTypeID,DocumentNo,DocApprovedDate,DocExpireDate,Description,IsActive,DocFileName,DocumentVersion,SiteName) 
                VALUES 
                (
                    '$input_ItemCode1_Sterile',
                    44,
                    $select_typeDocument_Sterile,
                    '$input_DocNo_Sterile',
                    '$input_ApproveDate_Sterile',
                    '$input_ExpDate_Sterile',
                    '$input_Des_Sterile',
                    1,
                    $updatePic1
                    $Version,
                    'BMC'
                )";
    $meQueryIn = $conn->prepare($insert);
    $meQueryIn->execute();
}

function EditUsage_SUDs($conn, $db)
{
    $return = array();
    $modal_input_serie = $_POST['modal_input_serie'];
    $modal_input_lot = $_POST['modal_input_lot'];
    $modal_input_exp = $_POST['modal_input_exp'];
    $modal_input_register = $_POST['modal_input_register'];
    $modal_input_qty = $_POST['modal_input_qty'];
    $UsageCode = $_POST['UsageCode'];

    $modal_input_exp = $modal_input_exp;
    $modal_input_exp = explode("-", $modal_input_exp);
    $modal_input_exp = $modal_input_exp[2] . '-' . $modal_input_exp[1] . '-' . $modal_input_exp[0];

    $query = "UPDATE itemstock SET
                            serielNo = '$modal_input_serie', 
                            lotNo = '$modal_input_lot', 
                            expDate = '$modal_input_exp',
                            ExpireDate = '$modal_input_exp'
                    WHERE UsageCode = '$UsageCode'  ";

                    $meQuery2 = $conn->prepare($query);
                    $meQuery2->execute();


}

function SaveUsage_SUDs($conn, $db)
{
    $return = array();
    $ArraySerie = $_POST['ArraySerie'];
    $Arraylot = $_POST['Arraylot'];
    $Arrayexp = $_POST['Arrayexp'];
    $Arrayregister = $_POST['Arrayregister'];
    $ArrayQty = $_POST['ArrayQty'];
    $input_ItemCode1_SUDs = $_POST['input_ItemCode1_SUDs'];

    foreach ($ArrayQty as $key => $value) {

        $DateExp = $Arrayexp[$key];
        $DateExp = explode("-", $DateExp);
        $DateExp = $DateExp[2] . '-' . $DateExp[1] . '-' . $DateExp[0];

        $DateRegis = $Arrayregister[$key];
        $DateRegis = explode("-", $DateRegis);
        $DateRegis = $DateRegis[2] . '-' . $DateRegis[1] . '-' . $DateRegis[0];

        for ($i = 0; $i < intval($value); $i++) {

            if($db == 1){
                $gen_usage = "SELECT COALESCE(
                                        (SELECT 
                                            CONCAT(
                                                its.ItemCode,
                                                '-',
                                                LPAD(CAST(SUBSTRING(COALESCE(its.UsageCode, '0'), 11, 3) AS UNSIGNED) + 1, 3, '0')
                                            )
                                        FROM itemstock AS its
                                        WHERE its.ItemCode = '$input_ItemCode1_SUDs'
                                        ORDER BY its.UsageCode DESC
                                        LIMIT 1),
                                        CONCAT(
                                            '$input_ItemCode1_SUDs',
                                            '-001'
                                        )
                                    ) AS _UsageCode ";
            }else{
                $gen_usage = "SELECT COALESCE
                (
                    (
                    SELECT TOP
                        1 CONCAT (
                            its.ItemCode,
                            '-',
                            RIGHT (
                                REPLICATE( '0',3  ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( its.UsageCode, '0' ), 11, 13 ) ) + 1 ),
                            3 
                            ) 
                        ) 
                    FROM
                        itemstock AS its 
                    WHERE
                        its.ItemCode = '$input_ItemCode1_SUDs' 
                    ORDER BY
                        its.UsageCode DESC 
                    ),
                    CONCAT (
                        '$input_ItemCode1_SUDs',
                        '-001' 
                    ) 
                ) AS _UsageCode ";
            }


            $meQuery = $conn->prepare($gen_usage);
            $meQuery->execute();
            while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
                $_UsageCode = $row['_UsageCode'];

                $query = "INSERT INTO itemstock ( 
                                                                     CreateDate ,
                                                                     ItemCode,
                                                                     UsageCode, 
                                                                     serielNo, 
                                                                     lotNo, 
                                                                     expDate,
                                                                     Isdeproom,
                                                                     departmentroomid,
                                                                     IsPrintDept,
                                                                     IsStatus,
                                                                     ExpireDate
                                                                    ) VALUES 
                                                                    (
                                                                        '$DateRegis',
                                                                        '$input_ItemCode1_SUDs',
                                                                        '$_UsageCode' , 
                                                                        '$ArraySerie[$key]' , 
                                                                        '$Arraylot[$key]' , 
                                                                        '$DateExp',
                                                                        0,
                                                                        35,
                                                                        0,
                                                                        5,
                                                                        '$DateExp'
                                                                    )  ";

                $meQuery2 = $conn->prepare($query);
                $meQuery2->execute();
            }
        }
    }
}

function showDocNoSUDs($conn, $db)
{
    $return = array();
    $input_ItemCode1_SUDs = $_POST['input_ItemCode1_SUDs'];

    if($db == 1){
        $query = "SELECT
                    item_document.ID,
                    item_document.ProductID,
                    item_document.ItemType_ID,
                    item_document.DocumentTypeID,
                    item_document.DocumentNo,
                    DATE(item_document.DocApprovedDate) AS DocApprovedDate,
                    DATE(item_document.DocExpireDate) AS DocExpireDate,
                    item_document.Description,
                    item_document.IsActive,
                    item_document.DocFileName,
                    item_document.DocumentVersion,
                    item_document.SiteName,
                    document_type.DocumentType
                FROM
                    item_document
                INNER JOIN
                    document_type ON item_document.DocumentTypeID = document_type.ID
                WHERE
                    item_document.ProductID = '$input_ItemCode1_SUDs'
                    AND item_document.IsActive = 1 ";
    }else{
        $query = "SELECT
                item_document.ID,
                item_document.ProductID,
                item_document.ItemType_ID,
                item_document.DocumentTypeID,
                item_document.DocumentNo,
                CONVERT(DATE,item_document.DocApprovedDate) AS DocApprovedDate,
                CONVERT(DATE,item_document.DocExpireDate) AS DocExpireDate,
                item_document.Description,
                item_document.IsActive,
                item_document.DocFileName,
                item_document.DocumentVersion,
                item_document.SiteName ,
	            document_type.DocumentType
            FROM
                dbo.item_document
            INNER JOIN document_type ON item_document.DocumentTypeID = document_type.ID
            WHERE item_document.ProductID = '$input_ItemCode1_SUDs' AND item_document.IsActive = 1   ";
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

function showItemSUDs($conn, $db)
{
    $return = array();
    $input_modal_search_Suds = $_POST['input_modal_search_Suds'];


    
    $query = "SELECT
                    item.itemcode,
                    item.itemcode2,
                    item.itemname AS Item_name ,
                    itemtype.TyeName ,
                    item.IsCancel,
                    item.LimitUse,
                    item.CostPrice,
                    item.SterileProcessID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect,
                    (SELECT COUNT(*) FROM item_document WHERE item_document.ProductID = item.itemcode AND item_document.IsActive = 1  ) AS cnt_item_document
                FROM
                    item
                INNER JOIN itemtype ON itemtype.ID = item.itemtypeID
                WHERE
                    item.IsNormal = 1 
                    AND itemtype.ID = '42'
                    AND ( item.itemname LIKE '%$input_modal_search_Suds%' OR item.itemcode LIKE '%$input_modal_search_Suds%' )
                GROUP BY
                    item.ItemCode,
                    item.itemname,
                    itemtype.TyeName,
                    item.itemcode2,
                    item.IsCancel,
                    item.LimitUse,
                    item.CostPrice,
                    item.SterileProcessID,
                    item.procedureID, 
                    Picture,
                    Picture2,
                    Description,
                    ReuseDetect
                ORDER BY item.itemcode DESC  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        if ($row['CostPrice'] == null) {
            $row['CostPrice'] = "";
        }
        if ($row['cnt_item_document'] == '0') {
            $row['item_document_ID'] = "red";
        }
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showUsageCodeSUDs($conn, $db)
{
    $return = array();
    $input_ItemCode1_SUDs = $_POST['input_ItemCode1_SUDs'];

    if($db == 1){
        $query = "SELECT
                        itemstock.serielNo,
                        itemstock.UsageCode,
                        itemstock.lotNo,
                        DATE_FORMAT(itemstock.expDate, '%d-%m-%Y') AS expDate,
                        DATE_FORMAT(itemstock.CreateDate, '%d-%m-%Y') AS CreateDate,
                        itemstock.ItemCode
                    FROM
                        itemstock
                    WHERE
                        itemstock.ItemCode = '$input_ItemCode1_SUDs' ";
    }else{
        $query = " SELECT
                    itemstock.serielNo,
                    itemstock.UsageCode,
                    itemstock.lotNo,
                    FORMAT(itemstock.expDate,'dd-MM-yyyy') AS expDate,
                    FORMAT(itemstock.CreateDate,'dd-MM-yyyy') AS CreateDate,
                    itemstock.ItemCode 
                FROM
                    itemstock
                WHERE itemstock.ItemCode = '$input_ItemCode1_SUDs'  ";
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

function onconfirm_CreateItemSUDs($conn, $db)
{
    $input_ItemCode1_SUDs = $_POST['input_ItemCode1_SUDs'];
    $input_ItemCode2_SUDs = $_POST['input_ItemCode2_SUDs'];
    $input_ItemName_SUDs = $_POST['input_ItemName_SUDs'];
    $input_LimitUse_SUDs = $_POST['input_LimitUse_SUDs'];
    $input_CostPrice_SUDs = $_POST['input_CostPrice_SUDs'];
    $select_Procedure_SUDs = $_POST['select_Procedure_SUDs'];
    $select_SterileProcecss_SUDs = $_POST['select_SterileProcecss_SUDs'];
    $select_Style_SUDs = $_POST['select_Style_SUDs'];
    $select_Howto_SUDs = $_POST['select_Howto_SUDs'];
    $radio_CheckActive_SUDs = $_POST['checkbox_InActive_SUDs'];


    $Data_image1_SUDs = $_POST['Data_image1_SUDs'];
    $Data_image2_SUDs = $_POST['Data_image2_SUDs'];

    if (isset($_FILES['image1_SUDs'])) {
        $filename1 = $_FILES['image1_SUDs']['name'];
    }
    if (isset($_FILES['image2_SUDs'])) {
        $filename2 = $_FILES['image2_SUDs']['name'];
    }

    $return = [];

    if ($input_ItemCode1_SUDs == "") {

        if($db == 1){
            $genItem = "SELECT CONCAT(
                            'S',
                            DATE_FORMAT(CURDATE(), '%y'),
                            DATE_FORMAT(CURDATE(), '%m'),
                            LPAD(CAST(SUBSTRING(COALESCE(item.itemcode, '0'), 4, 6) AS UNSIGNED) + 1, 4, '0')
                        ) AS itemCode
                        FROM item
                        WHERE itemcode LIKE '%S%'
                        ORDER BY itemcode DESC
                        LIMIT 1 ";
        }else{
            $genItem = "SELECT TOP
            1 CONCAT (
                'S',
                FORMAT ( GETDATE( ), 'yy' ),
                FORMAT ( GETDATE( ), 'MM' ),
                RIGHT (
                    REPLICATE( '0', 4 ) + CONVERT ( VARCHAR, CONVERT ( INT, SUBSTRING ( COALESCE ( item.itemcode, '0' ), 4, 9 ) ) + 1 ), + 4 
                ) 
            ) AS itemCode
        FROM
            item 
        WHERE
            itemcode LIKE '%S%' 
        ORDER BY
            itemcode DESC ";
        }

        $meQuery = $conn->prepare($genItem);
        $meQuery->execute();

        while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
            $I_C = $row['itemCode'];
        }
    } else {
        $I_C = $input_ItemCode1_SUDs;
    }


    if ($input_ItemCode1_SUDs == "") {

        if (isset($_FILES['image1_SUDs'])) {
            copy($_FILES['image1_SUDs']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = " '$filename1' , ";
        } else {
            $updatePic1 = " NULL , ";
        }
        if (isset($_FILES['image2_SUDs'])) {
            copy($_FILES['image2_SUDs']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = " '$filename2' , ";
        } else {
            $updatePic2 = " NULL , ";
        }

    }else{
        if (isset($_FILES['image1_SUDs'])) {
            copy($_FILES['image1_SUDs']['tmp_name'], '../assets/img/' . $I_C . '1.png');
            $filename1 = $I_C . '1.png';
            $updatePic1 = "Picture  = '$filename1' , ";
        } else {
            if ($Data_image1_SUDs == 'default') {
                $updatePic1 = "Picture  = NULL , ";
            } else {
                $updatePic1 = "";
            }
        }
        if (isset($_FILES['image2_SUDs'])) {
            copy($_FILES['image2_SUDs']['tmp_name'], '../assets/img/' . $I_C . '2.png');
            $filename2 = $I_C . '2.png';
            $updatePic2 = "Picture2  = '$filename2' , ";
        } else {
            if ($Data_image2_SUDs == 'default') {
                $updatePic2 = "Picture2  = NULL , ";
            } else {
                $updatePic2 = "";
            }
        }
    }


    $return = 1;
    if ($input_ItemCode1_SUDs == "") {
        $queryInsert = "INSERT INTO item ( itemcode, itemcode2, itemname,LimitUse ,CostPrice ,SterileProcessID ,IsCancel ,itemtypeID,Picture,Picture2,IsNormal,procedureID,Description,ReuseDetect)
                        VALUES
                            ( '$I_C',
                            '$input_ItemCode2_SUDs',
                            '$input_ItemName_SUDs',
                            '$input_LimitUse_SUDs',
                            '$input_CostPrice_SUDs',
                            '$select_SterileProcecss_SUDs',
                            '$radio_CheckActive_SUDs',
                            42,
                            $updatePic1 
                            $updatePic2 
                            1,
                            $select_Procedure_SUDs,
                            '$select_Style_SUDs',
                            '$select_Howto_SUDs'
                                )";


                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    } else {
        $queryInsert = "UPDATE item SET   itemcode2 = '$input_ItemCode2_SUDs',
                                          itemname = '$input_ItemName_SUDs',
                                          LimitUse = '$input_LimitUse_SUDs',
                                          CostPrice = '$input_CostPrice_SUDs',
                                          SterileProcessID = '$select_SterileProcecss_SUDs' ,
                                          IsCancel = '$radio_CheckActive_SUDs',
                                          $updatePic1
                                          $updatePic2
                                          IsNormal = 1,
                                          procedureID = $select_Procedure_SUDs ,
                                          Description = '$select_Style_SUDs',
                                          ReuseDetect = '$select_Howto_SUDs'

                        WHERE itemcode = '$I_C' ";

                        $meQueryInsert = $conn->prepare($queryInsert);
                        $meQueryInsert->execute();
    }



    echo json_encode($queryInsert);
    unset($conn);
    die;
    // }


}

function onconfirm_CreateDocNoSUDs($conn, $db)
{
    $input_ItemCode1_SUDs = $_POST['input_ItemCode1_SUDs'];
    $select_typeDocument_SUDs = $_POST['select_typeDocument_SUDs'];
    $input_DocNo_SUDs = $_POST['input_DocNo_SUDs'];
    $input_ApproveDate_SUDs = $_POST['input_ApproveDate_SUDs'];
    $input_ExpDate_SUDs = $_POST['input_ExpDate_SUDs'];
    $checkbox_NoExp_SUDs = $_POST['checkbox_NoExp_SUDs'];
    $input_Des_SUDs = $_POST['input_Des_SUDs'];
    $Data_FileDocNo_SUDs = $_POST['Data_FileDocNo_SUDs'];

    $input_ApproveDate_SUDs = explode("-", $input_ApproveDate_SUDs);
    $input_ApproveDate_SUDs = $input_ApproveDate_SUDs[2] . '-' . $input_ApproveDate_SUDs[1] . '-' . $input_ApproveDate_SUDs[0];

    $input_ExpDate_SUDs = explode("-", $input_ExpDate_SUDs);
    $input_ExpDate_SUDs = $input_ExpDate_SUDs[2] . '-' . $input_ExpDate_SUDs[1] . '-' . $input_ExpDate_SUDs[0];


    if (isset($_FILES['input_FileDocNo_SUDs'])) {
        $filename1 = $_FILES['input_FileDocNo_SUDs']['name'];
    }



    $check_row = 0;
    $Version = 1;

    if($db == 1){
        $query1 = "SELECT
                        item_document.ID,
                        item_document.DocumentVersion
                    FROM
                        item_document
                    WHERE
                        item_document.ProductID = '$input_ItemCode1_SUDs'
                        AND item_document.DocumentTypeID = '$select_typeDocument_SUDs'
                        AND item_document.IsActive = 1
                    ORDER BY
                        item_document.DocumentVersion DESC
                    LIMIT 1 ";
    }else{
        $query1 = " SELECT TOP 1
                    item_document.ID,
                    item_document.DocumentVersion
                FROM
                    item_document 
                WHERE
                    item_document.ProductID = '$input_ItemCode1_SUDs' 
                    AND item_document.DocumentTypeID = '$select_typeDocument_SUDs' 
                    AND item_document.IsActive = 1
                ORDER BY
                    item_document.DocumentVersion DESC ";
    }

    $meQuery = $conn->prepare($query1);
    $meQuery->execute();

    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $check_row++;
        $_ID = $row['ID'];
        $_DocumentVersion = $row['DocumentVersion'];

        $updateD = "UPDATE item_document SET item_document.IsActive = 0 WHERE item_document.ID = '$_ID' ";
        $meQueryD = $conn->prepare($updateD);
        $meQueryD->execute();

        $Version = $_DocumentVersion + 1;
    }

    if (isset($_FILES['input_FileDocNo_SUDs'])) {
        copy($_FILES['input_FileDocNo_SUDs']['tmp_name'], '../assets/file/' . $_FILES['input_FileDocNo_SUDs']['name'] . '-' . $Version . '.pdf');
        $filename1 = $_FILES['input_FileDocNo_SUDs']['name'] . '-' . $Version . '.pdf';
        $updatePic1 = " '$filename1' , ";
    } else {
        $updatePic1 = " NULL , ";
    }

    $insert = "INSERT INTO item_document (ProductID,ItemType_ID,DocumentTypeID,DocumentNo,DocApprovedDate,DocExpireDate,Description,IsActive,DocFileName,DocumentVersion,SiteName) 
                VALUES 
                (
                    '$input_ItemCode1_SUDs',
                    42,
                    $select_typeDocument_SUDs,
                    '$input_DocNo_SUDs',
                    '$input_ApproveDate_SUDs',
                    '$input_ExpDate_SUDs',
                    '$input_Des_SUDs',
                    1,
                    $updatePic1
                    $Version,
                    'BMC'
                )";
    $meQueryIn = $conn->prepare($insert);
    $meQueryIn->execute();
}
