$(function () {
  $("#checkbox_filter").change(function () {
    $("#select_type").val("");

    setTimeout(() => {
      show_detail_daily();
    }, 500);
  });

  session();

  $("#row_refrain").hide();
  $("#row_his").hide();
  $("#radio_daily").css("color", "#bbbbb");
  $("#radio_daily").css("background", "#EAE1F4");

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

  $("#select_date1_search2").val(output);
  $("#select_date1_search2").datepicker({
    onSelect: function (date) {
      show_detail_refrain();
    },
  });

  $("#select_his_Date").val(output);
  $("#select_his_Date").datepicker({
    onSelect: function (date) {
      show_detail_his_docno();
    },
  });

  show_detail_daily();
  $("#radio_daily").click(function () {
    $("#radio_daily").css("color", "#bbbbb");
    $("#radio_daily").css("background", "#EAE1F4");

    $("#radio_refrain").css("color", "black");
    $("#radio_refrain").css("background", "");
    $("#radio_his").css("color", "black");
    $("#radio_his").css("background", "");

    $("#row_daily").show();
    $("#row_refrain").hide();
    $("#row_his").hide();
    show_detail_daily();
  });

  $("#radio_refrain").click(function () {
    $("#radio_refrain").css("color", "#bbbbb");
    $("#radio_refrain").css("background", "#EAE1F4");

    $("#radio_daily").css("color", "black");
    $("#radio_daily").css("background", "");
    $("#radio_his").css("color", "black");
    $("#radio_his").css("background", "");

    $("#row_refrain").show();
    $("#row_daily").hide();
    $("#row_his").hide();

    show_detail_refrain();
  });

  $("#radio_his").click(function () {
    $("#radio_his").css("color", "#bbbbb");
    $("#radio_his").css("background", "#EAE1F4");

    $("#radio_daily").css("color", "black");
    $("#radio_daily").css("background", "");
    $("#radio_refrain").css("color", "black");
    $("#radio_refrain").css("background", "");

    $("#row_refrain").hide();
    $("#row_daily").hide();
    $("#row_his").show();

    show_detail_his_docno();
    // show_detail_refrain();
  });

  set_his();
});

function set_his() {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_his",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $("#radio_his").css("color", "#bbbbb");
        $("#radio_his").css("background", "#EAE1F4");

        $("#radio_daily").css("color", "black");
        $("#radio_daily").css("background", "");
        $("#radio_refrain").css("color", "black");
        $("#radio_refrain").css("background", "");

        $("#row_refrain").hide();
        $("#row_daily").hide();
        $("#row_his").show();

        show_detail_his_docno();
      }
    },
  });
}

$("#btn_send_pay").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การส่งค่าใช้จ่าย(HIS)  ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "onUPDATE_his",
          ID: $("#btn_send_pay").data("id"),
        },
        success: function (result) {
          show_detail_his_docno();
          $("#table_detail_his tbody").html("");
          $("#btn_send_pay").attr("disabled", true);
        },
      });
    }
  });
});

$("#select_type").change(function () {
  show_detail_daily();
});

function show_detail_his_docno() {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_his_docno",
      select_his_Date: $("#select_his_Date").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_his_docno tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
            var styleP = ``;
            var titleP = ``;
          } else {
            var styleP = `style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 150px;" `;
            var titleP = `title="${value.Procedure_TH}"`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          var txt = "";
          var hid = "";
          if (value.IsStatus == "1") {
            txt = `<button class='btn' style='font-weight: bold;background-color:#643695;color:#fff;'>รอดำเนินการ</button>`;
            var hid = "hidden";
          }
          if (value.IsStatus == "2") {
            txt = `<button class='btn' style="background-color:#1cc88a;color:#fff;font-weight:bold;">ส่งค่าใช้จ่ายเรียบร้อย</button>`;
          }
          var add_Qty = "";
          if (value.IsStatus == "3") {
            txt = `<button class='btn' style="background-color:#1cc88a;color:#fff;font-weight:bold;">ส่งค่าใช้จ่ายเรียบร้อย</button>`;
            var hid = "hidden";
          } else {
            if (value.add_Qty > 0 || value.delete_Qty > 0) {
              add_Qty = `<i style='color:red;' class="fa-solid fa-triangle-exclamation"></i>`;
            }
          }

          if (value.isCancel == "1") {
            txt = `<button class='btn' style="background-color:#e74a3b;color:#fff;font-weight:bold;">ยกเลิก</button>`;
            var hid = "hidden";
          }
          _tr += `<tr class='color' id="tr_${value.ID}"  onclick='setActive_his(${value.ID},"${value.IsStatus}",${value.isCancel},${value.add_Qty},${value.delete_Qty})'>
                      <td class="f18 text-center">${value.createAt}</td>
                      <td class="f18 text-center">${value.HnCode}</td>
                      <td class="f18 text-center">${value.Doctor_Name}</td>
                      <td class="f18 text-center" ${styleP} ${titleP}>${value.Procedure_TH}</td>
                      <td class="f18 text-center">${txt}</td>
                      <td hidden class="f18 text-center"><button class='btn' ${hid} style='font-weight: bold;background-color:#e74a3b;color:#fff;' onclick='edit_his(${value.ID},${value.IsStatus},${value.edit_qty})'>แก้ไข</button></td>
                      <td class="f18 text-center">${add_Qty}</td>
                      </tr>`;
        });
      }

      $("#table_his_docno tbody").html(_tr);
    },
  });
}

function setActive_his(ID, IsStatus,isCancel,add_Qty,delete_Qty) {
  $(".color").css("background-color", "");
  $("#tr_" + ID).css("background-color", "#FEE4E2");

  if (IsStatus == 1 || ( add_Qty > 0 || delete_Qty > 0 ) ) {
    $("#btn_send_pay").attr("disabled", false);
    $("#btn_send_pay").data("id", ID);
  } else {
    $("#btn_send_pay").attr("disabled", true);
  }

  if (isCancel == 1) {
    $("#btn_send_pay").attr("disabled", true);
  }

  show_detail_his(ID, IsStatus);
}

function edit_his(ID, IsStatus, edit_qty) {
  show_detail_his(ID, IsStatus);

  setTimeout(() => {
    $("#btn_send_pay").attr("disabled", false);
    $("#btn_send_pay").data("id", ID);

    $(".unlock_qty").attr("disabled", false);

    // if(edit_qty > 0){
    //   $("#btn_send_pay").attr("disabled", false);
    // }
  }, 500);

  // if(IsStatus == 1){

  // }else{
  //   $("#btn_send_pay").attr('disabled',true);

  // }
}

function show_detail_his(ID, IsStatus) {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_his",
      ID: ID,
    },
    success: function (result) {
      var _tr = "";
      var QQ = 0;
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_detail_his tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var dis = "";
          if (value.IsStatus == "2") {
            dis = `disabled`;
          }

          if (value.edit_Qty == null) {
            value.edit_Qty = "";
          }

          QQ = QQ + parseFloat(parseInt(value.Qty) * parseInt(value.SalePrice));
          _tr += `<tr>
                      <td class="f18 text-center">${value.itemcode2}</td>
                      <td class="f18 text-left">${value.itemname}</td>
                      <td class="f18 text-center"> <input disabled id="qty_item_${value.ID}" ${dis} onblur="updateDetail_qty(${value.ID},'${value.itemcode}')"  class='  numonly form-control' value='${value.Qty}' style='text-align: center;' ></td>
                      <td class="f18 text-center"> <input disabled   class='  numonly form-control' value='${value.add_Qty}' style='text-align: center;' ></td>
                      <td class="f18 text-center"> <input disabled   class='  numonly form-control' value='${value.delete_Qty}' style='text-align: center;' ></td>
                      </tr>`;
        });
      }

      $("#price_xx").text(parseFloat(QQ).toFixed(2));
      $("#table_detail_his tbody").html(_tr);

      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9-]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

function updateDetail_qty(ID, itemcode) {
  $("#qty_item_" + ID).val();
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "updateDetail_qty",
      ID: ID,
      itemcode: itemcode,
      qty: $("#qty_item_" + ID).val(),
    },
    success: function (result) {},
  });
}

function show_detail_refrain() {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_refrain",
      select_date1_search2: $("#select_date1_search2").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_refrain tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          _tr += `<tr>
                      <td class="f18 text-center">${value.hncode}</td>
                      <td class="f18 text-center">${value.serviceDate} ${value.serviceTime}</td>
                      <td class="f18 text-center">${value.Doctor_Name}</td>
                      <td class="f18 text-center">${value.departmentroomname}</td>
                      <td class="f18 text-center">${value.Procedure_TH}</td>
                      <td class="f18 text-center"><button class='btn' style='font-weight: bold;background-color:#643695;color:#fff;' onclick='update_daily(${value.ID})'>สร้างเอกสาร</button></td>
                      <td class="f18 text-center"><button class='btn' style='font-weight: bold;background-color:#e74a3b;color:#fff;' onclick='update_cancel(${value.ID})'>ยกเลิก</button></td>
                   </tr>`;
        });
      }

      $("#table_refrain tbody").html(_tr);
    },
  });
}

function update_cancel(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การยกเลิก ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_cancel",
          ID: ID,
        },
        success: function (result) {
          show_detail_refrain();
        },
      });
    }
  });
}

function update_daily(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การสร้างเอกสาร ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_daily",
          ID: ID,
        },
        success: function (result) {
          show_detail_refrain();
        },
      });
    }
  });
}

function show_detail_daily() {
  if ($("#checkbox_filter").is(":checked")) {
    var check_Box = 1;
  } else {
    var check_Box = 0;
  }

  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_daily",
      select_date1_search1: $("#select_date1_search1").val(),
      select_type: $("#select_type").val(),
      check_Box: check_Box,
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
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

          var x = "";
          if (
            value.isStatus == "0" ||
            value.isStatus == "1" ||
            value.isStatus == "2"
          ) {
            var txt = `<button class='btn f18' style='color:#fff;font-weight: bold;background-color:#643695;' onclick='update_create_request(${value.ID})'>รอดำเนินการ</button>`;
          }
          if (value.isStatus == "3") {
            var txt = `<a  class='btn f18'  href="#" style='font-weight: bold;background-color:#1cc88a;color:#fff;' )'>ดำเนินการเรียบร้อย</a>`;
            x = "hidden";
          }

          if (value.isCancel == "1") {
            var txt = `<a  class='btn f18'  href="#" style='font-weight: bold;background-color:#e74a3b;color:#fff;' )'>ยกเลิก</a>`;
            x = "hidden";
          }

          _tr += `<tr>
                      <td class="f18 text-center">${value.hncode}</td>
                      <td class="f18 text-center">${value.serviceDate} ${value.serviceTime}</td>
                      <td class="f18 text-center">${value.Doctor_Name}</td>
                      <td class="f18 text-center">${value.departmentroomname}</td>
                      <td class="f18 text-center">${value.Procedure_TH}</td>
                      <td class="f18 text-center">${txt}</td>
                      <td class="f18 text-center"><a  class='btn f18' ${x}  href="#" style='font-weight: bold;background-color:#e74a3b;color:#fff;' onclick='update_refrain(${value.ID})'>งด</a></td>
                   </tr>`;
        });
      }

      $("#table_daily tbody").html(_tr);
    },
  });
}

function update_create_request(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การไปหน้าสร้างใบขอเบิกอุปกรณ์ ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_create_request",
          ID: ID,
        },
        success: function (result) {
          show_detail_daily();
          // var link = "pages/create_request.php";
          // $.get(link, function (res) {
          //   $(".nav-item").removeClass("active");
          //   $(".nav-item").css("background-color", "");

          //   $("#ic_mainpage").attr(
          //     "src",
          //     "assets/img_project/2_icon/ic_mainpage.png"
          //   );
          //   $("#menu1").css("color", "#667085");

          //   $("#conMain").html(res);
          //   history.pushState(
          //     {},
          //     "Results for `Cats`",
          //     "index.php?s=create_request"
          //   );
          //   document.title = "create_request";

          //   loadScript("script-function/create_request.js");
          //   loadScript("assets/lang/create_request.js");
          // });
        },
      });
    }
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

function update_refrain(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การงด ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_refrain",
          ID: ID,
        },
        success: function (result) {
          show_detail_daily();
        },
      });
    }
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

      $("#input_Deproom_Main").val(Permission_name);
      $("#input_Name_Main").val(UserName);
    },
  });
}
