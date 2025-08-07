<?php


function createDocNoSell($conn, $S_UserId, $IsStatus, $department, $ServiceDate, $ServiceTime, $db)
{

    if ($db == 1) {
        $query = " SELECT
                        CONCAT(
                            'SD',
                            SUBSTRING( YEAR ( CURDATE()), 3, 2 ),
                            LPAD( MONTH ( CURDATE()), 2, '0' ),
                            '-',
                            LPAD( COALESCE ( MAX( CAST( SUBSTRING( DocNo, 8, 5 ) AS UNSIGNED )), 0 ) + 1, 5, '0' ) 
                        ) AS DocNo 
                    FROM
                        sell_department 
                    WHERE
                        DocNo LIKE CONCAT(
                            'SD',
                            SUBSTRING( YEAR ( CURDATE()), 3, 2 ),
                            LPAD( MONTH ( CURDATE()), 2, '0' ),
                        '%' 
                        ) ";
    } else {
        $query = "SELECT TOP
                        1 CONCAT (
                            'SD',
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
                        sell_department 
                    WHERE
                        DocNo LIKE CONCAT (
                            'SD',
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




        $sql = "INSERT INTO sell_department (
            DocNo, departmentID, IsCancel, serviceDate, CreateDate, ModifyDate, userID 
        ) VALUES (
            :DocNo, :departmentID, 0, CONCAT(:serviceDate, ' ', :ServiceTime), NOW(), NOW(), :userID 
        )";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':DocNo' => $_DocNo,
            ':departmentID' => $department,
            ':serviceDate' => $ServiceDate,
            ':ServiceTime' => $ServiceTime,
            ':userID' => $S_UserId
        ]);



        // $meQuery_insert = $conn->prepare($query_insert);
        // $meQuery_insert->execute();
    }


    return $_DocNo;
}
