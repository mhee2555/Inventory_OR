<?php
 

function create_sendsterile_DocNo($conn, $S_RefDocNo , $DepID , $S_UserId, $S_Status, $S_Remark,  $washdep,  $Qty, $S_manual ,$round_sent_sterile,$db)
{

	if($db == 1){
	    $query = "SELECT CONCAT(
						'SS',
						SUBSTRING(CAST(YEAR(CURDATE()) AS CHAR), 3, 2),
						LPAD(MONTH(CURDATE()), 2, '0'),
						'-',
						LPAD(COALESCE(MAX(CAST(SUBSTRING(DocNo, 8, 5) AS UNSIGNED)), 0) + 1, 5, '0')
					) AS DocNo
					FROM sendsterile
					WHERE DocNo LIKE CONCAT(
						'SS',
						SUBSTRING(CAST(YEAR(CURDATE()) AS CHAR), 3, 2),
						LPAD(MONTH(CURDATE()), 2, '0'),
						'%'
					)
					ORDER BY DocNo DESC
					LIMIT 1  ";
	}else{
	    $query = "SELECT TOP
					1 CONCAT (
						'SS',
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
					sendsterile 
				WHERE
					DocNo LIKE CONCAT (
						'SS',
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
			$query_insert = "INSERT INTO sendsterile (DocNo, DocDate, ModifyDate, DeptID, UserCode, Qty, IsCancel, Remark, RefDocNo, IsWeb, IsStatus, IsWashDept, Round)
			VALUES ('$_DocNo', NOW(), NOW(), '$DepID', '$S_UserId', $Qty, 0, '$S_Remark', '$S_RefDocNo', 1, $S_Status, 0, $round_sent_sterile) ";
		}else{
			$query_insert = "INSERT INTO sendsterile ( DocNo,DocDate, ModifyDate, DeptID, UserCode, Qty, IsCancel, Remark, RefDocNo , IsWeb , IsStatus , IsWashDept , Round )
			VALUES
				( '$_DocNo',GETDATE(),GETDATE(), '$DepID', '$S_UserId', $Qty, 0,   '$S_Remark' , '$S_RefDocNo' ,  1 , $S_Status  , 0 , $round_sent_sterile) ";
		}


        
        $meQuery_insert = $conn->prepare($query_insert);
        $meQuery_insert->execute();
    }

    $_SESSION['label_DocNo_SS'] = $_DocNo;

    return $_DocNo;
}
