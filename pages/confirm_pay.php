<?php
date_default_timezone_set("Asia/Bangkok");


$doc = $_GET['doc'];
$permission = $_GET['permission'];
$Userid = $_GET['Userid'];
$DepID = $_GET['DepID'];
$deproom = $_GET['deproom'];
$remark = $_GET['remark'];



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
                        <label class="mb-3 " style="width: 100%;color: #643695;font-size: 40px;font-weight: bold;">ยืนยัน!</label>

                        <h2 style="color: black;">ยืนยัน การรับอุปกรณ์ !</h2>

                        <img src="../assets/img_project/confrim_pay.png" alt="package" width="200" class="mb-4">

                        <div class="text-left mx-auto" style="max-width: 400px;">
                            <p style="color: black;"><strong id="text_change_hn">HN Code :</strong> <label for="" id="text_hn"></label></p>
                            <p style="color: black;" id="text_doctor"></p>
                            <p style="color: black;" id="text_procedure"></p>

                            <div class="mb-3">
                                <select class="form-control" id="select_users">
                                </select>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-lg mb-2 " style="width: 100%;background-color: #643695;color:#fff;" id="btn_save_item">ยืนยัน การรับอุปกรณ์ !</button>
                            </div>

                            <div class="mb-2">
                                <button class="btn btn-lg mb-3 " style="width: 100%;background-color: #1cc88a;color:#fff;" id="btn_show_item">ขอเบิก</button>
                            </div>

                        </div>
                    </div>

                    <table class="table table-hover table-sm" id="table_detail">
                        <thead style="background-color: #643695;">
                            <tr>
                                <th scope="col" class="text-center" id="">Code</th>
                                <th scope="col" class="text-center" id="">Name</th>
                                <th scope="col" class="text-center" id="">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ขอเบิก</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-sm" id="table_detail_add_item">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btn_add_item_modal">บันทึก</button>
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
            var remark = '<?php echo $remark; ?>';
            var permission = '<?php echo $permission; ?>';
            var Userid = '<?php echo $Userid; ?>';
            var DepID = '<?php echo $DepID; ?>';
            var deproom = '<?php echo $deproom; ?>';








            show_detail(doc, remark);
            set_users();

            setTimeout(() => {
                check_hn(doc, remark);
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


            $("#btn_show_item").click(function() {
                show_detail_item_request();
                $("#myModal_addItem").modal('toggle');
            });

            $("#btn_add_item_modal").click(function() {

                var count_qty_request = 0;
                $(".loop_qty_request").each(function(key, value) {
                    if ($(this).val() == "") {} else {
                        count_qty_request++;
                    }
                });

                if (count_qty_request == 0) {
                    showDialogFailed("กรุณากรอกจำนวน");
                    return;
                }
                Swal.fire({
                    title: "ยืนยัน",
                    text: "ยืนยัน การขอเบิก",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                }).then((result) => {
                    if (result.isConfirmed) {

              




                        onconfirm_request(doc,permission,Userid,DepID,deproom);
                    }
                });


                // addItem_item_request(doc);
            });





        });


        function onconfirm_request(doc,permission,Userid,DepID,deproom) {
            qty_array = [];
            itemcode_array = [];

            $("#table_detail_add_item")
                .DataTable()
                .rows()
                .every(function() {
                    let inputValue = $(this.node()).find("input.loop_qty_request").val();
                    if (inputValue != "" && inputValue != "0") {
                        qty_array.push(inputValue);
                        itemcode_array.push(
                            $(this.node()).find("input.loop_qty_request").data("itemcode")
                        );
                    }
                });

            $.ajax({
                url: "../process/confirm_pay.php",
                type: "POST",
                data: {
                    FUNC_NAME: "onconfirm_request",
                    array_itemcode: itemcode_array,
                    array_qty: qty_array,
                    txt_docno_request: doc,
                    permission: permission,
                    Userid: Userid,
                    DepID: DepID,
                    deproom: deproom,

                },
                success: function(result) {
                    var ObjData = JSON.parse(result);
                    console.log(ObjData);

                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'บันทึกสำเร็จ',
                        icon: "success",
                        timer: 1000,
                    });

                    $("#myModal_addItem").modal('toggle');


                    // $("#txt_docno_request").val(ObjData);
                    // show_detail_item_request();
                    // if (ObjData != "") {
                    // setTimeout(() => {
                    //     show_detail_request_byDocNo();
                    // }, 200);
                    // }
                },
            });
        }

        function settext(key) {
            if (localStorage.lang == "en") {
                return en[key];
            } else {
                return th[key];
            }
        }

        function show_detail_item_request() {
            var permission = '<?php echo $permission; ?>';

            $.ajax({
                url: "../process/confirm_pay.php",
                type: "POST",
                data: {
                    FUNC_NAME: "show_detail_item_request",
                    permission: permission,
                },
                success: function(result) {
                    var _tr = "";
                    $("#table_detail_add_item tbody").html("");
                    $("#table_detail_add_item").DataTable().destroy();
                    var ObjData = JSON.parse(result);
                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {
                            _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.Item_name}</td>
                      <td class='text-center'><input type='text' class='numonly form-control loop_qty_request text-center' data-itemcode="${value.itemcode}"></td>
                   </tr>`;
                        });
                    }

                    $("#table_detail_add_item tbody").html(_tr);
                    $("#table_detail_add_item").DataTable({
                        // language: {
                        //     emptyTable: settext("dataTables_empty"),
                        //     paginate: {
                        //         next: settext("table_itemStock_next"),
                        //         previous: settext("table_itemStock_previous"),
                        //     },
                        //     search: settext("btn_Search"),
                        //     info: settext("dataTables_Showing") +
                        //         " _START_ " +
                        //         settext("dataTables_to") +
                        //         " _END_ " +
                        //         settext("dataTables_of") +
                        //         " _TOTAL_ " +
                        //         settext("dataTables_entries") +
                        //         " ",
                        // },
                        columnDefs: [{
                                width: "10%",
                                targets: 0,
                            },
                            {
                                width: "80%",
                                targets: 1,
                            },
                            {
                                width: "10%",
                                targets: 2,
                            }
                        ],
                        autoWidth: false,
                        info: false,
                        scrollX: false,
                        scrollCollapse: false,
                        visible: false,
                        searching: true,
                        lengthChange: false,
                        fixedHeader: false,
                        ordering: false,
                        responsive: true,
                        pagingType: "simple_numbers", // หรือ "simple" ถ้าต้องการแค่ Prev/Next
                        language: {
                            paginate: {
                                previous: "‹",
                                next: "›"
                            },
                            search: "ค้นหา:", // เปลี่ยนข้อความ Search เป็น ค้นหา

                        }
                    });
                    $("th").removeClass("sorting_asc");
                    // if (_tr == "") {
                    //     $(".dataTables_info").text(
                    //         settext("dataTables_Showing") +
                    //         " 0 " +
                    //         settext("dataTables_to") +
                    //         " 0 " +
                    //         settext("dataTables_of") +
                    //         " 0 " +
                    //         settext("dataTables_entries") +
                    //         ""
                    //     );
                    // }

                    $(".numonly").on("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
                    });
                },
            });
        }

        function show_detail(doc, remark) {

            $.ajax({
                url: "../process/confirm_pay.php",
                type: "POST",
                data: {
                    FUNC_NAME: "show_detail",
                    doc: doc,
                    remark: remark,
                },
                success: function(result) {
                    var _tr = "";
                    // $("#table_deproom_pay").DataTable().destroy();
                    $("#table_detail tbody").html("");
                    var ObjData = JSON.parse(result);
                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {

                            _tr += `<tr>
                            <td class="f18 text-center">${value.itemcode2}</td>
                            <td class="f18 text-left">${value.itemname}</td>
                            <td class="f18 text-center">${value.cnt_pay}</td>
                        </tr>`;
                        });
                    }

                    $("#table_detail tbody").html(_tr);
                },
            });
        }

        function onUpdateConfirm() {
            var doc = '<?php echo $doc; ?>';
            var remark = '<?php echo $remark; ?>';


            $.ajax({
                url: "../process/confirm_pay.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'onUpdateConfirm',
                    'doc': doc,
                    'remark': remark,
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

        function check_hn(doc, remark) {


            $.ajax({
                url: "../process/confirm_pay.php",
                type: 'POST',
                data: {
                    'FUNC_NAME': 'check_hn',
                    'doc': doc,
                    'remark': remark,
                },
                error: function(result) {
                    console.log(result);
                },
                success: function(result) {
                    var ObjData = JSON.parse(result);

                    if (!$.isEmptyObject(ObjData)) {
                        $.each(ObjData, function(kay, value) {


                            if (remark == 'sell') {

                                $("#text_change_hn").text('แผนก : ');
                                $("#text_hn").text(value.DepName);
                                if (value.IsConfirm_pay == 1) {
                                    $("#btn_save_item").attr('hidden', true);
                                }
                                $('#select_users').val(value.userConfirm_pay).trigger('change');
                            } else {
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
                                    value.hn_record_id = value.number_box;
                                }
                                if (value.IsConfirm_pay == 1) {
                                    $("#btn_save_item").attr('hidden', true);
                                }

                                $('#select_users').val(value.userConfirm_pay).trigger('change');
                                $("#text_hn").text(value.hn_record_id);
                                $("#text_doctor").html(doctor);
                                $("#text_doctor").html(doctor);
                                $("#text_procedure").html(procedure);
                            }


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