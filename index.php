<?php
// header('HTTP/1.1 200 OK');
session_start();
date_default_timezone_set("Asia/Bangkok");
$page = isset($_GET['s']) ? $_GET['s'] : 'main';
$pay = isset($_GET['pay']) ? $_GET['pay'] : '';
$ex = isset($_GET['ex']) ? $_GET['ex'] : '';

if (!isset($_GET['s'])) {
    header("location:login.php");
    exit(0);
}
$UserName_login = $_SESSION['UserName_login'];
$Password = $_SESSION['Password'];

$UserName = $_SESSION['UserName'];
$deproom = $_SESSION['deproom'];
$RefDepID = $_SESSION['RefDepID'];
$departmentroomname = $_SESSION['departmentroomname'];
$Doctor_Name = $_SESSION['Doctor_Name'];
// $IsStockRoom = $_SESSION['IsStockRoom'];
$doctorID = $_SESSION['doctorID'];
$Lang = $_SESSION['Lang'];
$Userid = $_SESSION['Userid'];
$font = $_SESSION['font'];
$display = $_SESSION['display'];
$EmpCode = $_SESSION['EmpCode'];
$time_out = $_SESSION['time_out'];
$GN_WarningExpiringSoonDay = $_SESSION['GN_WarningExpiringSoonDay'];


if (!isset($_SESSION['UserName'])) {
    header("location:login.php");
    exit(0);
}


?>

<!DOCTYPE html>
<!-- <html lang="en" id="html" onmousemove="afk()"> -->
<html lang="en" id="html">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CSSD</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">

    <?php require("import/css.php"); ?>


</head>

<body id="page-top"></body>

<!-- Page Wrapper -->
<div id="wrapper">

    <?php require("layout/menu.php"); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" style="background-color: white;">

            <?php require("layout/header.php"); ?>


            <div class="container-fluid" id="conMain" style="background-color: white;">

            </div>





        </div>
    </div>

    <!-- Main Content -->

</div>


<!-- <div class="modal fade" id="disabledModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disabled Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" disabled>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                This modal cannot be closed or interacted with.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
            </div>
        </div>
    </div>
</div> -->

<div class="modal fade" id="time_out_Modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" style="top: 200px !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card pl-3 pr-3">
                            <div style="border-bottom: none;text-align: center;display: block;">
                                <i style="font-size: 80px;color: #007bff;margin-bottom: 10px;" class="fa-solid fa-clock"></i>
                                <h5 class="modal-title" id="loginModalLabel" style="color:black;">ระยะเวลา Time Out</h5>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="input_time_out" placeholder="ระยะเวลา Time Out">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">นาที</span>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-primary w-50 " id="save_time_out_Button" style="color:#fff;background-color:#004aad;font-size:20px;">บันทึก</button>
                                </div>
                                <div class="col-md-6 text-left">
                                    <button type="button" class="btn btn-logout w-50 " data-dismiss="modal" style="background-color:#ed1c24;color:#fff;font-size:20px;">ปิด</button>
                                </div>
                            </div> -->
                        </div>

                    </div>


                    <div class="col-md-6">
                        <div class="card pl-3 pr-3">
                            <div style="border-bottom: none;text-align: center;display: block;">
                                <i style="font-size: 80px;color: #007bff;margin-bottom: 10px;" class="fa-solid fa-clock"></i>
                                <h5 class="modal-title" id="loginModalLabel" style="color:black;">วันที่แจ้งเตือนหมดอายุ</h5>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="input_exsoon" placeholder="วัน">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">วัน</span>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-primary w-50 " id="save_ex_soon_Button" style="color:#fff;background-color:#004aad;font-size:20px;">บันทึก</button>
                                </div>
                                <div class="col-md-6 text-left">
                                    <button type="button" class="btn btn-logout w-50 " data-dismiss="modal" style="background-color:#ed1c24;color:#fff;font-size:20px;">ปิด</button>
                                </div>
                            </div> -->



                        </div>

                    </div>
                </div>


            </div>

            <div class="modal-footer" style='justify-content: center;'>
                <div class="row ">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" id="save_ex_soon_Button" style="color:#fff;background-color:#004aad;font-size:20px;width: 100px;">บันทึก</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-logout" data-dismiss="modal" style="background-color:#ed1c24;color:#fff;font-size:20px;width: 100px;">ปิด</button>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;text-align: center;display: block;">
                <span class="icon" style="font-size: 100px;color: #007bff;margin-bottom: 10px;">&#9432;</span> <!-- Unicode info icon -->
                <h5 class="modal-title" id="loginModalLabel" style="color:black;">Login</h5>
            </div>
            <div class="modal-body text-center">
                <p style="color:black;">Please login to continue.</p>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="input_UserName" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="input_PassWord" placeholder="Password">
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: center; border-top: none;">
                <button type="button" class="btn btn-primary" id="loginButton" style="color:#fff;background-color:#004aad;font-size:20px;">Login</button>
                <button type="button" class="btn btn-logout" id="logoutButton" style="background-color:#ed1c24;color:#fff;font-size:20px;">Logout</button>
            </div>
        </div>
    </div>
</div>





<?php require("import/js.php"); ?>


<script>
    <?php include_once('assets/lang/' . $page . '.js'); ?>

    $(function() {
        let isRefreshed = sessionStorage.getItem("isRefreshed");


        if (isRefreshed === "true") {
            sessionStorage.setItem("isRefreshed", "false");
            setTimeout(() => {
                location.href = "login.php";
            }, 300);
            // alert("หน้านี้ถูกรีเฟรช");
        } else {
            // alert("นี่คือการโหลดครั้งแรกของหน้าเว็บ");
        }



        var GN_WarningExpiringSoonDay = '<?php echo $GN_WarningExpiringSoonDay; ?>';
        var time_out = '<?php echo $time_out; ?>';
        var RefDepID = '<?php echo $RefDepID; ?>';

        if (RefDepID == '36DEN') {
            $("#save_ex_soon_Button").attr('disabled', true);
        }

        $("#input_time_out").val(time_out);
        $("#input_exsoon").val(GN_WarningExpiringSoonDay);

        $('#save_time_out_Button').on("click", function(e) {

            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdatetime',
                    'Userid': Userid,
                    'input_time_out': $("#input_time_out").val(),
                },
                success: function(result) {
                    location.reload();
                }
            });
            // $("#time_out_Modal").modal('toggle');
        })

        $('#save_ex_soon_Button').on("click", function(e) {

            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdatetime',
                    'Userid': Userid,
                    'input_time_out': $("#input_time_out").val(),
                },
                success: function(result) {
                    location.reload();
                }
            });

            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateExsoon',
                    'Userid': Userid,
                    'input_exsoon': $("#input_exsoon").val(),
                },
                success: function(result) {
                    location.reload();
                }
            });
            // $("#time_out_Modal").modal('toggle');
        })

        $('#btn_setting_timeout').on("click", function(e) {
            $("#time_out_Modal").modal('toggle');


        })

        var page = '<?php echo $page; ?>';

        setTimeout(() => {
            $('#a_' + page).click();
        }, 300);

        $('#a_main').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                if (display == '3') {
                    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
                    $("#menu1").css('color', 'white');


                    $("#menu2").css('color', '#667085');
                    $("#menu3").css('color', '#667085');
                    $("#menu4").css('color', '#667085');
                    $("#menu5").css('color', '#667085');
                    $("#menu6").css('color', '#667085');
                    $("#menu7").css('color', '#667085');
                    $("#menu8").css('color', '#667085');
                    $("#menu9").css('color', '#667085');
                    $("#menu10").css('color', '#667085');
                    $("#menu11").css('color', '#667085');
                    $("#menu12").css('color', '#667085');
                    $("#menu13").css('color', '#667085');
                    $("#menu14").css('color', '#667085');


                    $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                    $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");
                    $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                    $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                    $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                    $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                    $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                    $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                    $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                    $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                    $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                    $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                    $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");
                    $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");

                }

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#conMain").html(res);
                $("#li_main").addClass("active");
                $("#li_main").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=main');
                document.title = "main";
                loadScript('script-function/main.js');

            });
        })
        $('#a_roomcheck').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#conMain").html(res);
                $("#li_roomcheck").addClass("active");
                $("#li_roomcheck").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=roomcheck');
                document.title = "roomcheck";
                loadScript('script-function/roomcheck.js');
            });
        })
        $('#a_pay_roomcheck').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#conMain").html(res);
                $("#li_pay_roomcheck").addClass("active");
                $("#li_pay_roomcheck").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=pay_roomcheck');
                document.title = "pay_roomcheck";
                loadScript('script-function/pay_roomcheck.js');
            });
        })

        $('#a_recieve_stock').on("click", function(e) {

            var UserName_login = '<?php echo $UserName_login; ?>';
            var Password = '<?php echo $Password; ?>';

            window.open("http://10.11.9.3:8003/Login/Index?user="+UserName_login+"&pass="+Password, "_blank");


            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                if (display == '3') {
                    $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/3_icon/ic_receiveinventory.png");
                    $("#menu2").css('color', 'white');


                    $("#menu1").css('color', '#667085');
                    $("#menu3").css('color', '#667085');
                    $("#menu4").css('color', '#667085');
                    $("#menu5").css('color', '#667085');
                    $("#menu6").css('color', '#667085');
                    $("#menu7").css('color', '#667085');
                    $("#menu8").css('color', '#667085');
                    $("#menu9").css('color', '#667085');
                    $("#menu10").css('color', '#667085');
                    $("#menu11").css('color', '#667085');
                    $("#menu12").css('color', '#667085');
                    $("#menu13").css('color', '#667085');
                    $("#menu14").css('color', '#667085');


                    $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                    $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                    $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                    $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                    $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                    $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                    $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                    $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                    $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                    $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                    $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                    $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");
                    $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");

                }

                $("#conMain").html(res);
                $("#li_recieve_stock").addClass("active");
                $("#li_recieve_stock").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=recieve_stock');
                document.title = "recieve_stock";
                loadScript('script-function/recieve_stock.js');
            });
        })
        $('#a_create_request').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_create_equipment_request").attr("src", "assets/img_project/3_icon/ic_create_equipment_request.png");
                $("#menu3").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");



                $("#conMain").html(res);
                $("#li_create_request").addClass("active");
                $("#li_create_request").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=create_request');
                document.title = "create_request";
                loadScript('script-function/create_request.js');
            });
        })
        $('#a_pay').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_dispense_equipment").attr("src", "assets/img_project/3_icon/ic_dispense_equipment.png");
                $("#menu4").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");


                $("#conMain").html(res);
                $("#li_pay").addClass("active");
                $("#li_pay").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=pay');
                document.title = "pay";
                loadScript('script-function/pay.js');
            });
        })
        $('#a_receive_dirty').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");


                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/3_icon/ic_receive_contaminated_equipment.png");
                $("#menu5").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");


                $("#conMain").html(res);
                $("#li_receive_dirty").addClass("active");
                $("#li_receive_dirty").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=receive_dirty');
                document.title = "receive_dirty";
                loadScript('script-function/receive_dirty.js');
            });
        })
        $('#a_send-n-sterile').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_send_nsterile").attr("src", "assets/img_project/3_icon/ic_send_nsterile.png");
                $("#menu6").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");

                $("#conMain").html(res);
                $("#li_send-n-sterile").addClass("active");
                $("#li_send-n-sterile").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=send-n-sterile');
                document.title = "send-n-sterile";
                loadScript('script-function/send-n-sterile.js');
            });
        })
        $('#a_register_item').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_register_equipment").attr("src", "assets/img_project/3_icon/ic_register_equipment.png");
                $("#menu7").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");

                $("#conMain").html(res);
                $("#li_register_item").addClass("active");
                $("#li_register_item").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=register_item');
                document.title = "register_item";
                loadScript('script-function/register_item.js');
            });
        })
        $('#a_stock_item').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_inventory_tools").attr("src", "assets/img_project/3_icon/ic_inventory_tools.png");
                $("#menu8").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");

                $("#conMain").html(res);
                $("#li_stock_item").addClass("active");
                $("#li_stock_item").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=stock_item');
                document.title = "stock_item";
                loadScript('script-function/stock_item.js');
            });
        })
        $('#a_surgery').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_operation_room").attr("src", "assets/img_project/3_icon/ic_operation_room.png");
                $("#menu15").css('color', 'white');

                $("#menu1").css('color', '#667085');
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");

                $("#conMain").html(res);
                $("#li_surgery").addClass("active");
                $("#li_surgery").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=surgery');
                document.title = "surgery";
                loadScript('script-function/surgery.js');
            });
        })
        $('#a_hn').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_search_hndata").attr("src", "assets/img_project/3_icon/ic_search_hndata.png");
                $("#menu9").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");


                $("#conMain").html(res);
                $("#li_hn").addClass("active");
                $("#li_hn").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=hn');
                document.title = "hn";
                loadScript('script-function/hn.js');
            });
        })
        $('#a_setting').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/3_icon/ic_turnon_offdisplay.png");
                $("#menu10").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");

                $("#conMain").html(res);
                $("#li_setting").addClass("active");
                $("#li_setting").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=setting');
                document.title = "setting";
                loadScript('script-function/setting.js');
            });
        })
        $('#a_movement').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_movement").attr("src", "assets/img_project/3_icon/ic_movement.png");
                $("#menu11").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu12").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png"); 
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
                $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");

                $("#conMain").html(res);
                $("#li_movement").addClass("active");
                $("#li_movement").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=movement');
                document.title = "movement";
                loadScript('script-function/movement.js');
            });
        })
        $('#a_adjuststock').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_adjust_stock").attr("src", "assets/img_project/3_icon/ic_adjust_stock.png");
                $("#menu12").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu13").css('color', '#667085');
                $("#menu14").css('color', '#667085');


                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");

                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");

                $("#conMain").html(res);
                $("#li_adjuststock").addClass("active");
                $("#li_adjuststock").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=adjuststock');
                document.title = "adjuststock";
                loadScript('script-function/adjuststock.js');
            });
        })
        
        $('#a_manage').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/3_icon/ic_turnon_offdisplay.png");
                $("#menu13").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu14").css('color', '#667085');

                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");

                $("#conMain").html(res);
                $("#li_manage").addClass("active");
                $("#li_manage").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=manage');
                document.title = "manage";
                loadScript('script-function/manage.js');
            });
        })

        $('#a_mapping').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {

                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#ic_turnon_offdisplay_3").attr("src", "assets/img_project/3_icon/ic_turnon_offdisplay.png");
                $("#menu14").css('color', 'white');


                $("#menu1").css('color', '#667085');
                $("#menu2").css('color', '#667085');
                $("#menu3").css('color', '#667085');
                $("#menu4").css('color', '#667085');
                $("#menu5").css('color', '#667085');
                $("#menu6").css('color', '#667085');
                $("#menu7").css('color', '#667085');
                $("#menu8").css('color', '#667085');
                $("#menu9").css('color', '#667085');
                $("#menu10").css('color', '#667085');
                $("#menu11").css('color', '#667085');
                $("#menu13").css('color', '#667085');

                $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
                $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_turnon_offdisplay_2").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
                $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
                $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
                $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
                $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
                $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
                $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
                $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
                $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");

                $("#conMain").html(res);
                $("#li_mapping").addClass("active");
                $("#li_mapping").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=mapping');
                document.title = "mapping";
                loadScript('script-function/mapping.js');
            });
        })

        $('#a_return-confirm').on("click", function(e) {
            e.preventDefault();
            var link = this.href;
            $.get(link, function(res) {
                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                $("#conMain").html(res);
                $("#li_return-confirm").addClass("active");
                $("#li_return-confirm").css("background-color", "#5271ff");
                history.pushState({}, "Results for `Cats`", 'index.php?s=return-confirm');
                document.title = "return-confirm";
            });
        })

        function loadScript(url) {
            const script = document.createElement('script');
            script.src = url;
            script.type = 'text/javascript';
            script.onload = function() {
                // console.log('Script loaded and ready');
            };
            document.head.appendChild(script);
        }


        let timer, currSeconds = 0;

        function resetTimer() {

            /* Hide the timer text */
            document.querySelector(".timertext")
                .style.display = 'none';

            /* Clear the previous interval */
            clearInterval(timer);

            /* Reset the seconds of the timer */
            currSeconds = 0;

            /* Set a new interval */



            timer =
                setInterval(startIdleTimer, 1000);
        }

        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;
        window.ontouchstart = resetTimer;
        window.onclick = resetTimer;
        window.onkeypress = resetTimer;

        function startIdleTimer() {

            var time_out = '<?php echo $time_out; ?>';

            let seconds = time_out * 60;

            currSeconds++;


            document.querySelector(".secs")
                .textContent = currSeconds;

            document.querySelector(".timertext")
                .style.display = 'block';

            if (currSeconds == seconds) {

                sessionStorage.setItem("isRefreshed", "true");


                $("#loginModal").modal('toggle');


                $('#loginModal').on('hide.bs.modal', function(e) {
                    e.preventDefault(); // ป้องกันการปิด Modal
                    e.stopImmediatePropagation();
                    return false;
                });


                $("#loginButton").on("click", function() {
                    LoginUser();

                });

                $("#logoutButton").on("click", function() {
                    Swal.fire({
                        title: lang_text_confirm,
                        text: lang_text_confirmLogout,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: lang_text_confirm,
                        cancelButtonText: lang_text_cancel,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "login.php";
                        }
                    });
                });





                // window.location.assign("login.php");
            }
        }
        var Lang = '<?php echo $Lang; ?>';
        var Userid = '<?php echo $Userid; ?>';
        var display = '<?php echo $display; ?>';
        var font = '<?php echo $font; ?>';


        $("#lang-thai").click(function() {
            localStorage.setItem('lang', 'th');


            $("#lang-change").text('ภาษาไทย');

            // $(".clearlang").removeClass('activelang');
            // $("#lang-thai").addClass('activelang');


            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateLang',
                    'Lang': 'th',
                    'Userid': Userid,
                },
                success: function(result) {

                }
            });


            // renderlang();

            setTimeout(() => {
                location.reload();
            }, 500);




        });

        $("#lang-eng").click(function() {

            $("#lang-change").text('english');


            localStorage.setItem('lang', 'en');

            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateLang',
                    'Lang': 'en',
                    'Userid': Userid,
                },
                success: function(result) {}
            });

            // $(".clearlang").removeClass('activelang');
            // $("#lang-eng").addClass('activelang');

            // renderlang();

            setTimeout(() => {
                location.reload();
            }, 500);

        });

        if (Lang == 'en') {
            localStorage.setItem('lang', 'en');
        }
        if (Lang == 'th') {
            localStorage.setItem('lang', 'th');
        }


        if (localStorage.lang == 'th') {
            // $("#lang-thai").addClass('activelang');
            $("#lang-change").text('ภาษาไทย');
            $('title').text('ทันตกรรม');

            var lang_text_confirm = 'ยืนยัน'
            var lang_text_confirmLogout = 'ยืนยัน! การออกจากระบบ!'
            var lang_text_cancel = 'ยกเลิก'
        }
        if (localStorage.lang == 'en') {

            var lang_text_confirm = 'ยืนยัน!'
            $("#lang-change").text('english');
            // $("#lang-eng").addClass('activelang');
            $('title').text('Dental');
            var lang_text_confirm = 'Confirm'
            var lang_text_confirmLogout = 'Confirm! Log out?'
            var lang_text_cancel = 'Cancel'
        }


        renderlang();

        // ====================================================

        $("#display-1").click(function() {
            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateDisplay',
                    'display': '1',
                    'Userid': Userid,
                },
                success: function(result) {}
            });

            localStorage.setItem('display', '1');
            $(".cleardisplay").removeClass('activeFont');
            $("#display-1").addClass('activeFont');

            $("#accordionSidebar").removeClass('display-dark3');
            $("#accordionSidebar").removeClass('display-dark2');
            $("#accordionSidebar").addClass('display-dark1');
            $(".color_menu").addClass('color_menu2');

            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");
            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");



            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");


        });
        $("#display-2").click(function() {
            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateDisplay',
                    'display': '2',
                    'Userid': Userid,
                },
                success: function(result) {}
            });
            localStorage.setItem('display', '2');
            $(".cleardisplay").removeClass('activeFont');
            $("#display-2").addClass('activeFont');

            $("#accordionSidebar").removeClass('display-dark3');
            $("#accordionSidebar").removeClass('display-dark1');
            $("#accordionSidebar").addClass('display-dark2');
            $(".color_menu").addClass('color_menu2');

            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");
            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");



            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");



        });
        $("#display-3").click(function() {
            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateDisplay',
                    'display': '3',
                    'Userid': Userid,
                },
                success: function(result) {}
            });
            localStorage.setItem('display', '3');
            $(".cleardisplay").removeClass('activeFont');
            $("#display-3").addClass('activeFont');

            $("#accordionSidebar").removeClass('display-dark1');
            $("#accordionSidebar").removeClass('display-dark2');
            $("#accordionSidebar").addClass('display-dark3');
            $(".color_menu").addClass('color_menu3');

            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");
            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");



            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");


        });

        if (display == '1') {
            localStorage.setItem('display', '1');
        }
        if (display == '2') {
            localStorage.setItem('display', '2');
        }
        if (display == '3') {
            localStorage.setItem('display', '3');
        }

        if (localStorage.display == '1') {
            $(".clearfont").removeClass('activeFont');
            $("#display-1").addClass('activeFont');

            $("#accordionSidebar").addClass('display-dark1');


            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");

            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");




            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");

        }
        if (localStorage.display == '2') {
            $(".clearfont").removeClass('activeFont');
            $("#display-2").addClass('activeFont');

            $("#accordionSidebar").addClass('display-dark2');

            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");

            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");




            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");

        }
        if (localStorage.display == '3') {
            $(".clearfont").removeClass('activeFont');
            $("#display-3").addClass('activeFont');

            $("#accordionSidebar").addClass('display-dark3');
            // $(".color_menu").addClass('color_menu3');




            $("#ic_operation_room").attr("src", "assets/img_project/2_icon/ic_operation_room.png");

            $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
            $("#ic_setup_equipment_rooms").attr("src", "assets/img_project/2_icon/ic_receiveinventory.png");
            $("#ic_create_equipment_request").attr("src", "assets/img_project/2_icon/ic_create_equipment_request.png");
            $("#ic_dispense_equipment").attr("src", "assets/img_project/2_icon/ic_dispense_equipment.png");
            $("#ic_receive_contaminated_equipment").attr("src", "assets/img_project/2_icon/ic_receive_contaminated_equipment.png");
            $("#ic_send_nsterile").attr("src", "assets/img_project/2_icon/ic_send_nsterile.png");
            $("#ic_register_equipment").attr("src", "assets/img_project/2_icon/ic_register_equipment.png");
            $("#ic_inventory_tools").attr("src", "assets/img_project/2_icon/ic_inventory_tools.png");
            $("#ic_search_hndata").attr("src", "assets/img_project/2_icon/ic_search_hndata.png");
            $("#ic_turnon_offdisplay").attr("src", "assets/img_project/2_icon/ic_turnon_offdisplay.png");
            $("#ic_movement").attr("src", "assets/img_project/2_icon/ic_movement.png");
            $("#ic_adjust_stock").attr("src", "assets/img_project/2_icon/ic_adjust_stock.png");




            $("#li_logout").css('background-color', 'lightgray');
            $("#img_logo").attr("src", "assets/img/logo.png");
        }

        // ======================================================



        $("#font-small").click(function() {

            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateFont',
                    'font': 's',
                    'Userid': Userid,
                },
                success: function(result) {}
            });

            localStorage.setItem('font', 's');
            $(".clearfont").removeClass('activeFont');
            $("#font-small").addClass('activeFont');

            $("#html").removeClass('font-medium');
            $("#html").removeClass('font-big');
            $("#html").addClass('font-small');

        });
        $("#font-medium").click(function() {
            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateFont',
                    'font': 'm',
                    'Userid': Userid,
                },
                success: function(result) {}
            });

            localStorage.setItem('font', 'm');
            $(".clearfont").removeClass('activeFont');
            $("#font-medium").addClass('activeFont');

            $("#html").removeClass('font-small');
            $("#html").removeClass('font-big');
            $("#html").addClass('font-medium');
        });
        $("#font-big").click(function() {
            $.ajax({
                url: "process/main.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateFont',
                    'font': 'b',
                    'Userid': Userid,
                },
                success: function(result) {}
            });
            localStorage.setItem('font', 'b');
            $(".clearfont").removeClass('activeFont');
            $("#font-big").addClass('activeFont');

            $("#html").removeClass('font-small');
            $("#html").removeClass('font-medium');
            $("#html").addClass('font-big');
        });


        if (font == 's') {
            localStorage.setItem('font', 's');
        }
        if (font == 'm') {
            localStorage.setItem('font', 'm');
        }
        if (font == 'b') {
            localStorage.setItem('font', 'b');
        }

        if (localStorage.font == 's') {
            $(".clearfont").removeClass('activeFont');
            $("#font-small").addClass('activeFont');


            $("#html").addClass('font-small');

        }
        if (localStorage.font == 'm') {
            $(".clearfont").removeClass('activeFont');
            $("#font-medium").addClass('activeFont');

            $("#html").addClass('font-medium');

        }
        if (localStorage.font == 'b') {
            $(".clearfont").removeClass('activeFont');
            $("#font-big").addClass('activeFont');

            $("#html").addClass('font-big');

        }




        $("#li_logout").click(function() {


            Swal.fire({
                title: 'ยืนยัน',
                text: 'ยืนยัน! การออกจากระบบ!',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "login.php";
                }
            });


            // $.confirm({
            //     title: 'ยืนยัน !',
            //     content: 'ยืนยันการออกจากระบบ ?',
            //     type: 'red',
            //     autoClose: 'cancel|8000',
            //     buttons: {
            //         cancel: {
            //             text: 'ยกเลิก',
            //             action: function() {}
            //         },
            //         confirm: {
            //             text: "ยืนยัน",
            //             btnClass: 'btn-danger',
            //             action: function() {
            //                 location.href = "login.php";
            //             }
            //         }
            //     }
            // });
        })

    });

    function afk() {}


    function settext(key) {
        if (localStorage.lang == "en") {
            return en[key];
        } else {
            return th[key];
        }
    }


    function renderlang() {
        <?php include_once('assets/lang/' . $page . '_set.js'); ?>
    }



    function LoginUser() {

        var deproom = '<?php echo $deproom; ?>';
        if (deproom == 0) {
            deproom = "";
        }
        $.ajax({
            url: "process/login.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'LoginUser',
                'input_UserName': $("#input_UserName").val(),
                'input_PassWord': $("#input_PassWord").val(),
                'select_departmentRoom': deproom,
                'input_Scan': ""
            },
            error: function(result) {
                console.log(result);
            },
            success: function(result) {
                var ObjData = JSON.parse(result);

                if (!$.isEmptyObject(ObjData)) {

                    //  console.log(result);

                    var IsAdmin = "";

                    $.each(ObjData, function(kay, value) {
                        IsAdmin = value.IsAdmin;
                        console.log(IsAdmin);

                        sessionStorage.setItem("isRefreshed", "false");


                        if (IsAdmin == '0') {
                            if ($("#select_departmentRoom").val() == "") {
                                text = "กรุณาเลือกห้องตรวจ";
                                showDialogFailed(text);
                                return;
                            }
                            location.href = "index.php?s=main";
                        } else if (IsAdmin == '1') {
                            location.href = "index.php?s=main";
                        }
                    });
                } else {
                    text = "ผู้ใช้หรือรหัสผ่านผิด";
                    showDialogFailed(text);
                }






            }
        });
    }
</script>




</body>

</html>