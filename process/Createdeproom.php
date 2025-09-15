<?php


function createDocNo($conn, $S_UserId, $DepID, $select_departmentRoom, $remark, $IsBorrow, $IsStatus, $IsAuto, $departmentroomid, $select_procedure_request, $select_doctor_request, $input_hn_request ,$input_box_pay_manual ,  $db,$IsManual , $checkbox_manual_ems,$IsTF)
{

    if ($db == 1) {
        $query = " SELECT
                        CONCAT(
                            'DR',
                            SUBSTRING( YEAR ( CURDATE()), 3, 2 ),
                            LPAD( MONTH ( CURDATE()), 2, '0' ),
                            '-',
                            LPAD( COALESCE ( MAX( CAST( SUBSTRING( DocNo, 8, 5 ) AS UNSIGNED )), 0 ) + 1, 5, '0' ) 
                        ) AS DocNo 
                    FROM
                        deproom 
                    WHERE
                        DocNo LIKE CONCAT(
                            'DR',
                            SUBSTRING( YEAR ( CURDATE()), 3, 2 ),
                            LPAD( MONTH ( CURDATE()), 2, '0' ),
                        '%' 
                        ) ";
    } else {
        $query = "SELECT TOP
                        1 CONCAT (
                            'DR',
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
                        deproom 
                    WHERE
                        DocNo LIKE CONCAT (
                            'DR',
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

        if ($db == 1) {
            // $query_insert = "INSERT INTO deproom ( DocNo,DocDate, CreateDate, ModifyDate, DeptID, UserCode, IsStatus, Qty, IsCancel, departmentroomid, IsWeb , IsBorrow , Remark , IsAuto , Ref_departmentroomid,`procedure`,doctor,hn_record_id)
            // VALUES
            //     ( '$_DocNo',NOW(),NOW(),NOW(), '$DepID', '$S_UserId', $IsStatus, 0, 0, '$select_departmentRoom', 1 , $IsBorrow , '$remark' , $IsAuto , '$departmentroomid' , '0', '$select_doctor_request', '$input_hn_request') ";
        } else {
            $query_insert = "INSERT INTO deproom ( DocNo,DocDate, CreateDate, ModifyDate, DeptID, UserCode, IsStatus, Qty, IsCancel, departmentroomid, IsWeb , IsBorrow , Remark , IsAuto , Ref_departmentroomid,[procedure],doctor,hn_record_id,IsManual)
            VALUES
                ( '$_DocNo',GETDATE(),GETDATE(),GETDATE(), '$DepID', '$S_UserId', $IsStatus, 0, 0, '$select_departmentRoom', 1 , $IsBorrow , '$remark' , $IsAuto , '$departmentroomid' , '$select_procedure_request', '$select_doctor_request', '$input_hn_request',$IsManual) ";
        }


        $sql = "INSERT INTO deproom (
            DocNo, DocDate, CreateDate, ModifyDate, DeptID, UserCode, IsStatus, Qty, IsCancel,
            departmentroomid, IsWeb, IsBorrow, Remark, IsAuto, Ref_departmentroomid, `procedure`,
            doctor, hn_record_id, number_box ,IsManual , IsEms , IsTF
        ) VALUES (
            :DocNo, NOW(), NOW(), NOW(), :DeptID, :UserCode, :IsStatus, 0, 0,
            :departmentroomid, 1, :IsBorrow, :Remark, :IsAuto, :Ref_departmentroomid, '0',
            :doctor, :hn_record_id , :number_box , :IsManual , :IsEms , :IsTF 
        )";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':DocNo' => $_DocNo,
            ':DeptID' => $DepID,
            ':UserCode' => $S_UserId,
            ':IsStatus' => $IsStatus,
            ':departmentroomid' => $select_departmentRoom,
            ':IsBorrow' => $IsBorrow,
            ':Remark' => $remark,
            ':IsAuto' => $IsAuto,
            ':Ref_departmentroomid' => $departmentroomid,
            ':doctor' => $select_doctor_request,
            ':hn_record_id' => $input_hn_request,
            ':number_box' => $input_box_pay_manual,
            ':IsManual' => $IsManual,
            ':IsEms' => $checkbox_manual_ems,
            ':IsTF' => $IsTF
        ]);



        // $meQuery_insert = $conn->prepare($query_insert);
        // $meQuery_insert->execute();
    }


    return $_DocNo;
}
