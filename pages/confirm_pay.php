<?php
date_default_timezone_set("Asia/Bangkok");


$doc = $_GET['doc'];



?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ยืนยันการรับอุปกรณ์</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../import/css confirm.php"); ?>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <button class="btn btn-lg mb-3 " style="width: 100%;background-color: #1570EF;color:#fff;">ยืนยัน!</button>

                        <h2 style="color: black;">ยืนยัน การรับอุปกรณ์ !</h2>

                        <img src="../assets/img_project/confrim_pay.png" alt="package" width="200" class="mb-4">

                        <div class="text-start mx-auto" style="max-width: 400px;">
                            <p style="color: black;"><strong>HN Code :</strong> <label for="" id="text_hn"></label></p>
                            <p style="color: black;" id="text_doctor"></p>
                            <p style="color: black;" id="text_procedure"></p>

                            <div class="mb-3">
                                <select class="form-control" id="select_users">
                                </select>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-lg mb-3 " style="width: 100%;background-color: #1570EF;color:#fff;" id="btn_save_item">ยืนยัน การรับอุปกรณ์ !</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_Procedure" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">หัตถการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="table_detail_Procedure">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">หัตถการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_Doctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แพทย์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="table_detail_Doctor">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">แพทย์</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require("../import/js_confirm.php"); ?>

    <script>
        $(function() {
            var doc = '<?php echo $doc; ?>';


            set_users();

            setTimeout(() => {
                check_hn(doc);
            }, 500);
            $("#select_users").select2();



            $("#btn_save_item").click(function() {

                if ($("#select_users").val() == "") {

                    Swal.fire({
                        title: 'ล้มเหลว',
                        text: 'กรุณาเลือกผู้ใช้งาน',
                        icon: "error",
                    });

                    return;
                }
                Swal.fire({
                    title: "ยืนยัน",
                    text: "ยืนยัน! การรับอุปรณ์ ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                }).then((result) => {
                    if (result.isConfirmed) {
                        onUpdateConfirm();
                    }
                });
            });



        });
        
        function onUpdateConfirm() {
            var doc = '<?php echo $doc; ?>';


            $.ajax({
                url: "../process/confirm_pay.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateConfirm',
                    'doc': doc,
                    'select_users': $("#select_users").val(),
                },
                error: function(result) {
                    console.log(result);
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);

                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'บันทึกสำเร็จ',
                            icon: "success",
                            timer: 1000,
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                }
            });
        }

        function check_hn(doc) {


            $.ajax({
                url: "../process/confirm_pay.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'check_hn',
                    'doc': doc,
                },
                error: function(result) {
                    console.log(result);
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);

                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {

                            if (value.Procedure_TH == "button") {
                                value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;

                                var procedure = `<strong>หัตถการ :</strong> <a >${value.Procedure_TH}</a>`;
                            } else {
                                var procedure = `<strong>หัตถการ :</strong> <label >${value.Procedure_TH}</label>`;
                            }
                            if (value.Doctor_Name == "button") {
                                value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;

                                var doctor = `<strong>แพทย์ :</strong> <a >${value.Doctor_Name}</a>`;
                            } else {
                                var doctor = `<strong>แพทย์ :</strong> <label>${value.Doctor_Name}</label>`;
                            }

                            if (value.hn_record_id == '') {
                                value.hn_record_id = doc;
                            }
                            if (value.IsConfirm_pay == 1) {
                                $("#btn_save_item").attr('hidden',true);
                            }
                            
                            $('#select_users').val(value.userConfirm_pay).trigger('change');
                            $("#text_hn").text(value.hn_record_id);
                            $("#text_doctor").html(doctor);
                            $("#text_doctor").html(doctor);
                            $("#text_procedure").html(procedure);
                        });
                    }
                }
            });
        }

        function showDetail_Doctor(doctor) {
            $("#myModal_Doctor").modal("toggle");

            $.ajax({
                url: "../process/pay.php",
                type: "POST",
                data: {
                    FUNC_NAME: "showDetail_Doctor",
                    doctor: doctor,
                },
                success: function(result) {
                    // $("#table_item_claim").DataTable().destroy();
                    $("#table_detail_Doctor tbody").html("");
                    var ObjData = JSON.parse(result);
                    if (!$.isEmptyObject(ObjData)) {
                        var _tr = ``;
                        var allpage = 0;
                        $.each(ObjData, function(kay, value) {
                            _tr += `<tr>
              <td class="text-center">${kay + 1}</td>
              <td class="text-left">${value.Doctor_Name}</td>
            </tr>`;
                        });

                        $("#table_detail_Doctor tbody").html(_tr);
                    }
                },
            });
        }

        function showDetail_Procedure(procedure) {
            $("#myModal_Procedure").modal("toggle");

            $.ajax({
                url: "../process/pay.php",
                type: "POST",
                data: {
                    FUNC_NAME: "showDetail_Procedure",
                    procedure: procedure,
                },
                success: function(result) {
                    // $("#table_item_claim").DataTable().destroy();
                    $("#table_detail_Procedure tbody").html("");
                    var ObjData = JSON.parse(result);
                    if (!$.isEmptyObject(ObjData)) {
                        var _tr = ``;
                        var allpage = 0;
                        $.each(ObjData, function(kay, value) {
                            _tr += `<tr>
              <td class="text-center">${kay + 1}</td>
              <td class="text-left">${value.Procedure_TH}</td>
            </tr>`;
                        });

                        $("#table_detail_Procedure tbody").html(_tr);
                    }
                },
            });
        }

        function set_users() {
            $.ajax({
                url: "../process/process_main/select_main.php",
                type: "POST",
                data: {
                    FUNC_NAME: "set_users",
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);
                    console.log(ObjData);
                    var option = `<option value="" selected>กรุณาเลือกผู้ใช้งาน</option>`;
                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {
                            option += `<option value="${value.ID}" >${value.EmpCode} - ${value.FirstName}</option>`;
                        });
                    } else {
                        option = `<option value="0">ไม่มีข้อมูล</option>`;
                    }
                    $("#select_users").html(option);
                },
            });
        }
    </script>
</body>

</html>