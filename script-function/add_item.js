$(function () {
    $("#checkbox_filter").change(function () {
        setTimeout(() => {
            show_detail_daily();
        }, 500);
    });

    session();

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var year = d.getFullYear();
    var output =
        (("" + day).length < 2 ? "0" : "") +
        day +
        "-" +
        (("" + month).length < 2 ? "0" : "") +
        month +
        "-" +
        year;

    $("#select_date1_search1").val(output);
    $("#select_date1_search1").datepicker({
        onSelect: function (date) {
            show_detail_daily();
        },
    });

            show_detail_daily();
});

function show_detail_daily() {
    if ($("#checkbox_filter").is(":checked")) {
         check_Box = 1;
    } else {
         check_Box = 0;
    }

    $.ajax({
        url: "process/add_item.php",
        type: "POST",
        data: {
            FUNC_NAME: "show_detail_daily",
            select_date1_search1: $("#select_date1_search1").val(),
            select_type: $("#select_type").val(),
            check_Box: check_Box,
        },
        success: function (result) {
            var _tr = "";
            $("#table_daily tbody").html("");
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function (kay, value) {
                    if (value.Procedure_TH == "button") {
                        value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
                    }
                    if (value.Doctor_Name == "button") {
                        value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
                    }

                    if (value.IsAdditem == "1" ) {
                        var txt = `<a  class='btn f18'  onclick='onChangePay("${value.DocNo}")'   href="#" style='font-weight: bold;background-color:#643695;color:#fff;width: 100%;' )'>ยืนยัน</a>`;
                    } else {
                        var txt = `<a  class='btn f18'  href="#" style='font-weight: bold;color:#1cc88a;width: 100%;' )'>ยืนยันเรียบร้อย</a>`;
                    }

                    _tr += `<tr>
                      <td class="f18 text-center">${kay + 1}</td>
                      <td class="f18 text-center">${value.hn_record_id}</td>
                      <td class="f18 text-left">${value.Doctor_Name}</td>
                      <td class="f18 text-left">${value.Procedure_TH}</td>
                      <td class="f18 text-center"><a class="text-primary" style="cursor:pointer;" onclick='showDetail_item("${value.DocNo }")' >อุปกรณ์</a></td>
                      <td class="f18 text-center">${txt}</td>
                   </tr>`;
                });
            }

            $("#table_daily tbody").html(_tr);
        },
    });
}

function onChangePay(DocNo) {

    $.ajax({
        url: "process/add_item.php",
        type: "POST",
        data: {
            FUNC_NAME: "onChangePay",
            DocNo: DocNo,
        },
        success: function (result) {
            var link = "pages/pay.php";
            $.get(link, function (res) {
                $(".nav-item").removeClass("active");
                $(".nav-item").css("background-color", "");

                if (display == 2) {
                    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
                    $("#li_pay").css("background-color", "rgb(60, 32, 90)");
                    $("#ic_dispense_equipment").attr("src", "assets/img_project/3_icon/ic_dispense_equipment.png");
                    $("#menu1").addClass("color_menu3");
                } else {
                    if (display == 3) {
                        $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
                        $("#menu1").removeClass("color_menu1");
                        $("#menu1").addClass("color_menu3");
                    } else {
                        $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
                        $("#menu1").addClass("color_menu1");
                        $("#menu1").removeClass("color_menu3");
                    }
                    $("#li_pay").css("background-color", "#643695");
                    $("#ic_dispense_equipment").attr("src", "assets/img_project/3_icon/ic_dispense_equipment.png");
                    $("#menu4").addClass("color_menu1");
                }

                $("#conMain").html(res);
                history.pushState({}, "Results for `Cats`", "index.php?s=pay");
                document.title = "pay";

                loadScript("script-function/pay.js");
                loadScript("assets/lang/pay.js");
            });
        },
    });



}

function loadScript(url) {
    const script = document.createElement("script");
    script.src = url;
    script.type = "text/javascript";
    script.onload = function () {
        // console.log('Script loaded and ready');
    };
    document.head.appendChild(script);
}

function showDetail_item(DocNo) {
    $("#showDetail_item_map").modal("toggle");

    $.ajax({
        url: "process/add_item.php",
        type: "POST",
        data: {
            FUNC_NAME: "showDetail_item",
            DocNo: DocNo,
        },
        success: function (result) {
            // $("#table_item_claim").DataTable().destroy();
            $("#table_detail_item_modal tbody").html("");
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {
                var _tr = ``;
                var allpage = 0;
                $.each(ObjData, function (kay, value) {
                    _tr += `<tr>
                <td class="text-left">${value.itemname}</td>
                <td class="text-center">${value.Qty}</td>
              </tr>`;
                });

                $("#table_detail_item_modal tbody").html(_tr);
            }
        },
    });
}

function showDetail_Doctor(doctor) {
    $("#myModal_Doctor").modal("toggle");

    $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
            FUNC_NAME: "showDetail_Doctor",
            doctor: doctor,
        },
        success: function (result) {
            // $("#table_item_claim").DataTable().destroy();
            $("#table_detail_Doctor tbody").html("");
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {
                var _tr = ``;
                var allpage = 0;
                $.each(ObjData, function (kay, value) {
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
        url: "process/pay.php",
        type: "POST",
        data: {
            FUNC_NAME: "showDetail_Procedure",
            procedure: procedure,
        },
        success: function (result) {
            // $("#table_item_claim").DataTable().destroy();
            $("#table_detail_Procedure tbody").html("");
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {
                var _tr = ``;
                var allpage = 0;
                $.each(ObjData, function (kay, value) {
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

function session() {
    $.ajax({
        url: "process/session.php",
        type: "POST",
        success: function (result) {
            var ObjData = JSON.parse(result);
            departmentroomname = ObjData.departmentroomname;
            UserName = ObjData.UserName;
            deproom = ObjData.deproom;
            RefDepID = ObjData.RefDepID;
            Permission_name = ObjData.Permission_name;
        },
    });
}
