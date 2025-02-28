<?php



function createhncodeDocNo($conn, $S_UserId, $DepID,  $HnCode, $departmentroomid, $IsStatus, $select_procedure_main, $select_doctor_main, $Remark, $txt_docno_request, $db)
{

    if ($db == 1) {
        $query = "SELECT CONCAT(
                        'HN',
                        SUBSTRING(YEAR(CURDATE()), 3, 2),
                        LPAD(MONTH(CURDATE()), 2, '0'),
                        '-',
                        LPAD(COALESCE(MAX(CAST(SUBSTRING(DocNo, 8, 5) AS UNSIGNED)), 0) + 1, 5, '0')
                    ) AS DocNo
                    FROM hncode
                    WHERE DocNo LIKE CONCAT(
                        'HN',
                        SUBSTRING(YEAR(CURDATE()), 3, 2),
                        LPAD(MONTH(CURDATE()), 2, '0'),
                        '%'
                    ) ";
    } else {
        $query =  "SELECT TOP
                        1 CONCAT (
                            'HN',
                            SUBSTRING ( CONVERT ( VARCHAR, YEAR ( GETDATE( ) ) ), 3, 4 ),
                            RIGHT ( REPLICATE( '0', 2 ) + CONVERT ( VARCHAR, MONTH ( GETDATE( ) ) ), 2 ),
                            '-',
                            RIGHT (
                                REPLICATE( '0', 5 ) + CONVERT (
                                    VARCHAR,
                                    ( COALESCE ( MAX ( CONVERT ( INT, SUBSTRING ( DocNo, 8, 5 ) ) ), 0 ) + 1 ) 
                                ),
                                5 
                            ) 
                        ) AS DocNo 
                    FROM
                        hncode 
                    WHERE
                        DocNo LIKE CONCAT (
                            'HN',
                            SUBSTRING ( CONVERT ( VARCHAR, YEAR ( GETDATE( ) ) ), 3, 4 ),
                            RIGHT ( REPLICATE( '0', 2 ) + CONVERT ( VARCHAR, MONTH ( GETDATE( ) ) ), 2 ),
                            '%' 
                        ) 
                    ORDER BY
                        DocNo DESC ";
    }


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];

        if($db == 1){
            $query3 = "INSERT INTO hncode (DocNo,HnCode,DocDate,ModifyDate,UserCode,DeptID,IsStatus,IsCancel,`procedure`,doctor,departmentroomid ,Remark,DocNo_SS) 
        VALUES ('$_DocNo','$HnCode',NOW(),NOW(),'$S_UserId','$DepID',$IsStatus,0,'$select_procedure_main','$select_doctor_main' , $departmentroomid , '$Remark','$txt_docno_request') ";
        }else{
            $query3 = "INSERT INTO hncode (DocNo,HnCode,DocDate,ModifyDate,UserCode,DeptID,IsStatus,IsCancel,[procedure],doctor,departmentroomid ,Remark,DocNo_SS) 
        VALUES ('$_DocNo','$HnCode',GETDATE(),GETDATE(),'$S_UserId','$DepID',$IsStatus,0,'$select_procedure_main','$select_doctor_main' , $departmentroomid , '$Remark','$txt_docno_request') ";
        }



        $meQuery3 = $conn->prepare($query3);
        $meQuery3->execute();
    }


    return $_DocNo;
}
