<?php



function createhncodeDocNo($conn, $S_UserId, $DepID,  $HnCode, $departmentroomid, $IsStatus, $select_procedure_main, $select_doctor_main, $Remark, $txt_docno_request, $db , $select_date_request,$input_box_pay_manual)
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
        //     $query3 = "INSERT INTO hncode (DocNo,HnCode,DocDate,ModifyDate,UserCode,DeptID,IsStatus,IsCancel,`procedure`,doctor,departmentroomid ,Remark,DocNo_SS,number_box) 
        // VALUES ('$_DocNo','$HnCode','$select_date_request',NOW(),'$S_UserId','$DepID',$IsStatus,0,'$select_procedure_main','$select_doctor_main' , $departmentroomid , '$Remark','$txt_docno_request','$input_box_pay_manual') ";
        }else{
            $query3 = "INSERT INTO hncode (DocNo,HnCode,DocDate,ModifyDate,UserCode,DeptID,IsStatus,IsCancel,[procedure],doctor,departmentroomid ,Remark,DocNo_SS) 
        VALUES ('$_DocNo','$HnCode',GETDATE(),GETDATE(),'$S_UserId','$DepID',$IsStatus,0,'$select_procedure_main','$select_doctor_main' , $departmentroomid , '$Remark','$txt_docno_request') ";
        }



        $query3 = "INSERT INTO hncode (
            DocNo, HnCode, DocDate, ModifyDate, UserCode, DeptID, IsStatus, IsCancel, `procedure`,
            doctor, departmentroomid, Remark, DocNo_SS, number_box
        ) VALUES (
            :DocNo, :HnCode, :DocDate, NOW(), :UserCode, :DeptID, :IsStatus, 0, :procedure,
            :doctor, :departmentroomid, :Remark, :DocNo_SS, :number_box
        )";
        
        $stmt3 = $conn->prepare($query3);
        $stmt3->execute([
            ':DocNo' => $_DocNo,
            ':HnCode' => $HnCode,
            ':DocDate' => $select_date_request,
            ':UserCode' => $S_UserId,
            ':DeptID' => $DepID,
            ':IsStatus' => $IsStatus,
            ':procedure' => $select_procedure_main,
            ':doctor' => $select_doctor_main,
            ':departmentroomid' => $departmentroomid,
            ':Remark' => $Remark,
            ':DocNo_SS' => $txt_docno_request,
            ':number_box' => $input_box_pay_manual
        ]);


        // $meQuery3 = $conn->prepare($query3);
        // $meQuery3->execute();
    }


    return $_DocNo;
}
