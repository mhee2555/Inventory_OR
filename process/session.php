<?php
    session_start();

    $return = array();

    $return['UserName'][] = $_SESSION['UserName'];
    $return['deproom'][] = $_SESSION['deproom'];
    $return['RefDepID'][] = $_SESSION['RefDepID'];
    $return['departmentroomname'][] = $_SESSION['departmentroomname'];
    $return['Doctor_Name'][] = $_SESSION['Doctor_Name'];
    $return['doctorID'][] = $_SESSION['doctorID'];
    $return['Lang'][] = $_SESSION['Lang'];
    $return['Userid'][] = $_SESSION['Userid'];
    $return['font'][] = $_SESSION['font'];
    $return['display'][] = $_SESSION['display'];
    $return['EmpCode'][] = $_SESSION['EmpCode'];
    $return['Permission_name'][] = $_SESSION['Permission_name'];


    echo json_encode($return);
?>


