<?php
 

function createDocNo($conn, $S_UserId , $DepID , $select_departmentRoom , $remark , $IsBorrow ,$IsStatus , $IsAuto , $departmentroomid, $select_procedure_request, $select_doctor_request, $input_hn_request)
{


    $query = "SELECT
    ISNULL(
        (
        SELECT TOP
            1 CONCAT (
                'DR',
                RIGHT ( YEAR ( getDate( ) ), 2 ) + RIGHT ( '0' + RTRIM( MONTH ( CURRENT_TIMESTAMP ) ), 2 ),
                '-',
                REPLACE( STR( ( CAST ( RIGHT ( DocNo, 5 ) AS INT ) + 1 ), 5 ), ' ', '0' ) 
            ) AS DocNo 
        FROM
            deproom 
        ORDER BY
            deproom.DocNo DESC 
        ),
        CONCAT (
            'DR',
            RIGHT ( YEAR ( getDate( ) ), 2 ) + RIGHT ( '0' + RTRIM( MONTH ( CURRENT_TIMESTAMP ) ), 2 ),
            '-00001' 
        ) 
    ) AS DocNo ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];

        $query_insert = "INSERT INTO deproom ( DocNo,DocDate, CreateDate, ModifyDate, DeptID, UserCode, IsStatus, Qty, IsCancel, departmentroomid, IsWeb , IsBorrow , Remark , IsAuto , Ref_departmentroomid,[procedure],doctor,hn_record_id)
                        VALUES
                            ( '$_DocNo',GETDATE(),GETDATE(),GETDATE(), '$DepID', '$S_UserId', $IsStatus, 0, 0, '$select_departmentRoom', 1 , $IsBorrow , '$remark' , $IsAuto , '$departmentroomid' , '$select_procedure_request', '$select_doctor_request', '$input_hn_request') ";
        
        $meQuery_insert = $conn->prepare($query_insert);
        $meQuery_insert->execute();

    }


    return $_DocNo;
}
