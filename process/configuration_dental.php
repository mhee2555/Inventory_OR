<?php
session_start();
require '../connect/connect.php';


if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'configuration_dental') {
        configuration_dental($conn);
    }else if ($_POST['FUNC_NAME'] == 'configuration_floor') {
        configuration_floor($conn);
    }else if ($_POST['FUNC_NAME'] == 'showAPI') {
        showAPI($conn);
    }
}
function configuration_dental($conn)
{
    $return = array();

    $query = "SELECT
                DR_RoomCheckDay,
                DR_IsScanUserRoomCheck,
                DR_IsPayRoomCheck,
                PC_IsAllDate,
                UR_IsSendData,
                PC_IsFifo,
                UR_IsAllDate,
                RU_IsUsedScan,
                All_IsCssd,
                DR_IsOpenHn,
                RT_IsRFID,
                GN_WarningExpiringSoonDay
             FROM
                configuration_dental  ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


function configuration_floor($conn)
{
    
    $deproomid = $_POST['deproomid'];
    $return = array();

    $query = "SELECT
                 floor.IsSkip
             FROM
                departmentroom
             INNER JOIN floor ON floor.ID = departmentroom.floor_id
             
             WHERE departmentroom.id =  $deproomid ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}

function showAPI($conn)
{
    
    $Api_Name = $_POST['Api_Name'];
    $return = array();

    $query = " SELECT
                    $Api_Name AS api,
                    client_id , 
                    client_secret
                FROM
                    dbo.api_dental ";


    $meQuery = $conn->prepare($query);
    $meQuery->execute();
    while ($row = $meQuery->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $row;
    }
    echo json_encode($return);
    unset($conn);
    die;
}


