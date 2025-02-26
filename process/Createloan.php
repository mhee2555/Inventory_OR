<?php
 

 
function createloanDocNo($conn, $S_UserId , $DepID ,  $HnCode , $departmentroomid  ,$IsStatus , $select_site , $Remark)
{


    $query =  "SELECT
                ISNULL(
                (
                SELECT
                TOP 1 CONCAT (
                    'LN',
                    RIGHT (YEAR(getDate()), 2) + RIGHT (
                    '0' + RTRIM(MONTH(CURRENT_TIMESTAMP)),
                    2
                    ),
                    '-',
                    REPLACE(
                    STR(
                    (
                    CAST (RIGHT(loan.DocNo, 4) AS INT) + 1
                    ),
                    4
                    ),
                    ' ',
                    '0'
                    )
                ) AS DocNo
                FROM
                loan
                ORDER BY
                loan.DocNo DESC
                ),
                CONCAT (
                'LN',
                RIGHT (YEAR(getDate()), 2) + RIGHT (
                '0' + RTRIM(MONTH(CURRENT_TIMESTAMP)),
                2
                ),
                '-0001'
                )
                ) AS DocNo ";
    
    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];

        $query3 = "INSERT INTO loan (DocNo,DocDate,CreateDate,ModifyDate,UserCode,DeptID,IsStatus,IsCancel,RefSiteID ,Remark) 
        VALUES ('$_DocNo',GETDATE(),GETDATE(),GETDATE(),'$S_UserId','$DepID',$IsStatus,0,'$select_site', '$Remark') ";
        $meQuery3 = $conn->prepare($query3);
        $meQuery3->execute();
    }


    return $_DocNo;
}
