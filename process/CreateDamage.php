<?php
 

function create_Damage_DocNo($conn,$DepID,$S_UserId,$department_damage)
{


    $query = "SELECT
        ISNULL(
            (
                SELECT
                    TOP 1 CONCAT (
                        'DM',
                        RIGHT (YEAR(getDate()), 2) + RIGHT (
                            '0' + RTRIM(MONTH(CURRENT_TIMESTAMP)),
                            2
                        ),
                        '-',
                        REPLACE(
                            STR(
                                (
                                    CAST (RIGHT(DocNo, 5) AS INT) + 1
                                ),
                                5
                            ),
                            ' ',
                            '0'
                        )
                    ) AS DocNo
                FROM
                    damage
                ORDER BY
                    damage.DocNo DESC
            ),
            CONCAT (
                'DM',
                RIGHT (YEAR(getDate()), 2) + RIGHT (
                    '0' + RTRIM(MONTH(CURRENT_TIMESTAMP)),
                    2
                ),
                '-00001'
            )
        ) AS DocNo ";

    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $_DocNo = $row['DocNo'];

        $query_insert = "INSERT INTO damage ( DocNo , CreateDate , DeptID , UserCode , IsCancel, Remark,departmentroomid )
                        VALUES
                            ( '$_DocNo',GETDATE(), '$DepID', '$S_UserId', 0,'','$department_damage') ";
        $meQuery_insert = $conn->prepare($query_insert);
        $meQuery_insert->execute();
    }


    return $_DocNo;
}
