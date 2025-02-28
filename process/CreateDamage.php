<?php
 

function create_Damage_DocNo($conn,$DepID,$S_UserId,$department_damage, $db)
{

    if($db == 1){
        $query = "SELECT CONCAT(
                            'DM',
                            SUBSTRING(CAST(YEAR(CURDATE()) AS CHAR), 3, 2),
                            LPAD(MONTH(CURDATE()), 2, '0'),
                            '-',
                            LPAD(COALESCE(MAX(CAST(SUBSTRING(DocNo, 8, 5) AS UNSIGNED)), 0) + 1, 5, '0')
                        ) AS DocNo
                        FROM damage
                        WHERE DocNo LIKE CONCAT(
                            'DM',
                            SUBSTRING(CAST(YEAR(CURDATE()) AS CHAR), 3, 2),
                            LPAD(MONTH(CURDATE()), 2, '0'),
                            '%'
                        )
                        ORDER BY DocNo DESC
                        LIMIT 1  ";
    }else{
        $query = "SELECT TOP
                    1 CONCAT (
                        'DM',
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
                    damage 
                WHERE
                    DocNo LIKE CONCAT (
                        'DM',
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


        if($db == 1){
            $query_insert = "INSERT INTO damage ( DocNo , CreateDate , DeptID , UserCode , IsCancel, Remark,departmentroomid )
            VALUES
                ( '$_DocNo',NOW(), '$DepID', '$S_UserId', 0,'','$department_damage') ";
        }else{
            $query_insert = "INSERT INTO damage ( DocNo , CreateDate , DeptID , UserCode , IsCancel, Remark,departmentroomid )
            VALUES
                ( '$_DocNo',GETDATE(), '$DepID', '$S_UserId', 0,'','$department_damage') ";
        }


        $meQuery_insert = $conn->prepare($query_insert);
        $meQuery_insert->execute();
    }


    return $_DocNo;
}
