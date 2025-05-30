<?php


function createDocNo($conn, $S_UserId, $db,$IsManual)
{

    if ($db == 1) {
        $query = " SELECT
                        CONCAT(
                            'RQ',
                            YEAR (
                            CURDATE()),
                            LPAD( MONTH ( CURDATE()), 2, '0' ),
                            '-',
                            LPAD( COALESCE ( MAX( CAST( SUBSTRING( DocNo, 10, 5 ) AS UNSIGNED )), 0 ) + 1, 5, '0' ) 
                        ) AS DocNo 
                    FROM
                        request 
                    WHERE
                        DocNo LIKE CONCAT( 'RQ', YEAR ( CURDATE()), LPAD( MONTH ( CURDATE()), 2, '0' ), '%' )  ";
    } else {
        $query = "SELECT TOP
                        1 CONCAT (
                            'RQ',
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
                        request 
                    WHERE
                        DocNo LIKE CONCAT (
                            'RQ',
                            SUBSTRING ( CONVERT ( VARCHAR, YEAR ( GETDATE( ) ) ), 3, 4 ),
                            RIGHT ( REPLICATE( '0', 2 ) + CONVERT ( VARCHAR, MONTH ( GETDATE( ) ) ), 2 ),
                            '%' 
                        ) 
                    ORDER BY
                        DocNo DESC  ";
    }



    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];

        // if ($db == 1) {
        //     // $query_insert = "INSERT INTO deproom ( DocNo,DocDate, CreateDate, ModifyDate, DeptID, UserCode, IsStatus, Qty, IsCancel, departmentroomid, IsWeb , IsBorrow , Remark , IsAuto , Ref_departmentroomid,`procedure`,doctor,hn_record_id)
        //     // VALUES
        //     //     ( '$_DocNo',NOW(),NOW(),NOW(), '$DepID', '$S_UserId', $IsStatus, 0, 0, '$select_departmentRoom', 1 , $IsBorrow , '$remark' , $IsAuto , '$departmentroomid' , '0', '$select_doctor_request', '$input_hn_request') ";
        // } else {
        //     // $query_insert = "INSERT INTO request ( DocNo, userID , createAt )
        //     // VALUES
        //     //     ( '$_DocNo',GETDATE(),GETDATE(),GETDATE(), '$DepID', '$S_UserId', $IsStatus, 0, 0, '$select_departmentRoom', 1 , $IsBorrow , '$remark' , $IsAuto , '$departmentroomid' , '$select_procedure_request', '$select_doctor_request', '$input_hn_request',$IsManual) ";
        // }


        $sql = "INSERT INTO request ( DocNo, userID, createAt , isStatus ) VALUES ( :DocNo, :userID , NOW(), 0 )";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':DocNo' => $_DocNo,
            ':userID' => $S_UserId
        ]);



        // $meQuery_insert = $conn->prepare($query_insert);
        // $meQuery_insert->execute();
    }


    return $_DocNo;
}
