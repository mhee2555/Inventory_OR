var departmentroomname = "";
var UserName = "";
$(function () {
  var now = new Date();
  var hours = String(now.getHours()).padStart(2, "0");
  var minutes = String(now.getMinutes()).padStart(2, "0");
  var currentTime = hours + ":" + minutes;

  // Set the value of the input
  $("#select_time_request").val(currentTime);

  // $("#select_date_request").val(set_date());
  $("#select_date_request").datepicker({
    onSelect: function (date) {},
  });
  $("#select_date_history_s").val(set_date());
  $("#select_date_history_s").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });
  $("#select_date_history_l").val(set_date());
  $("#select_date_history_l").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  session();

  $("#history_create_request").hide();

  $("#radio_create_request").css("color", "#bbbbb");
  $("#radio_create_request").css("background", "#EAECF0");

  $("#radio_create_request").click(function () {
    $("#radio_create_request").css("color", "#bbbbb");
    $("#radio_create_request").css("background", "#EAECF0");

    $("#radio_history_create_request").css("color", "black");
    $("#radio_history_create_request").css("background", "");

    $("#create_request").show();
    $("#history_create_request").hide();
  });

  $("#radio_history_create_request").click(function () {
    $("#radio_history_create_request").css("color", "#bbbbb");
    $("#radio_history_create_request").css("background", "#EAECF0");

    $("#radio_create_request").css("color", "black");
    $("#radio_create_request").css("background", "");

    $("#create_request").hide();
    $("#history_create_request").show();

    show_detail_history();

    $("#select_deproom_history").select2();
    $("#select_doctor_history").select2();
    $("#select_procedure_history").select2();
  });

  show_detail_item_request();
  select_deproom();
  select_procedure();
  select_doctor();

  $("#select_typeItem").select2();
  $("#select_doctor_request").select2();
  $("#select_procedure_request").select2();

  $("#select_deproom_request").select2();

  $("#select_deproom_history").change(function () {
    show_detail_history();
  });
  $("#select_doctor_history").change(function () {
    show_detail_history();
  });
  $("#select_procedure_history").change(function () {
    show_detail_history();
  });

  $(".numonly").on("input", function () {
    this.value = this.value.replace(/[^0-9-]/g, ""); //<-- replace all other than given set of values
  });
});

// create_Request
$("#btn_search_request").click(function () {
  show_detail_item_request();
});

$("#btn_confirm_request").click(function () {
  var count_qty_request = 0;
  $(".loop_qty_request").each(function (key, value) {
    if ($(this).val() == "") {
    } else {
      count_qty_request++;
    }
  });

  if (count_qty_request == 0) {
    showDialogFailed("กรุณากรอกจำนวน");
    return;
  }
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การสร้างใบขอเบิกอุปกรณ์",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_request();
    }
  });
});

$("#btn_clear_request").click(function () {
  $("#table_item_detail_request").DataTable().destroy();
  $("#table_item_detail_request tbody").empty();
  $("#txt_docno_request").text("");

  $("#input_hn_request").val("");
  $("#select_doctor_request").val("");
  $("#select_deproom_request").val("");
  $("#select_procedure_request").val("");
  $("#input_remark_request").val("");
});

$("#input_hn_request").on("keydown", function (e) {
  if (e.keyCode == 32) {
    $("#input_hn_request").val("");
  }
});

$("#input_search_request").on("keydown", function (e) {
  show_detail_item_request();
});

$("#btn_confirm_send_request").click(function () {
  if ($("#txt_docno_request").val() == "") {
    showDialogFailed("กรุณากรอก เพิ่มรายการ");
    return;
  }
  if ($("#input_hn_request").val() == "") {
    showDialogFailed("กรุณากรอก HN Number");
    return;
  }

  if ($("#select_date_request").val() == "") {
    showDialogFailed("กรุณากรอก วันที่");
    return;
  }
  if ($("#select_time_request").val() == "") {
    showDialogFailed("กรุณากรอก เวลาเข้ารับบริการ");
    return;
  }

  if ($("#select_doctor_request").val() == "") {
    showDialogFailed("กรุณาเลือกแพทย์");
    return;
  }
  if ($("#select_deproom_request").val() == "") {
    showDialogFailed("กรุณาเลือกห้องตรวจ");
    return;
  }
  if ($("#select_procedure_request").val() == "") {
    showDialogFailed("กรุณาเลือกหัตถการ");
    return;
  }

  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การส่งข้อมูล ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_send_request();
    }
  });
});

$("#select_typeItem").change(function () {
  show_detail_item_request();
});

function show_detail_item_request() {
  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_request",
      input_search_request: $("#input_search_request").val(),
      select_typeItem: $("#select_typeItem").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.Item_name}</td>
                      <td class='text-center'>${value.TyeName}</td>
                      <td class='text-center'> <img src="assets/img_project/1_icon/ic_fileimg.png" style='width:30%;'></td>
                      <td class='text-center'><input type='text' class='form-control loop_qty_request text-center' data-itemcode="${
                        value.itemcode
                      }"></td>
                   </tr>`;
        });
      }

      $("#table_item_request tbody").html(_tr);
      $("#table_item_request").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
          search: settext("btn_Search"),
          info:
            settext("dataTables_Showing") +
            " _START_ " +
            settext("dataTables_to") +
            " _END_ " +
            settext("dataTables_of") +
            " _TOTAL_ " +
            settext("dataTables_entries") +
            " ",
        },
        columnDefs: [
          {
            width: "10%",
            targets: 0,
          },
          {
            width: "40%",
            targets: 1,
          },
          {
            width: "20%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
          },
          {
            width: "10%",
            targets: 4,
          },
        ],
        info: false,
        scrollX: false,
        scrollCollapse: false,
        visible: false,
        searching: false,
        lengthChange: false,
        fixedHeader: false,
        ordering: false,
      });
      $("th").removeClass("sorting_asc");
      if (_tr == "") {
        $(".dataTables_info").text(
          settext("dataTables_Showing") +
            " 0 " +
            settext("dataTables_to") +
            " 0 " +
            settext("dataTables_of") +
            " 0 " +
            settext("dataTables_entries") +
            ""
        );
      }
    },
  });
}

function onconfirm_request() {
  qty_array = [];
  itemcode_array = [];

  $("#table_item_request")
    .DataTable()
    .rows()
    .every(function () {
      let inputValue = $(this.node()).find("input.loop_qty_request").val();
      if (inputValue != "" && inputValue != "0") {
        qty_array.push(inputValue);
        itemcode_array.push(
          $(this.node()).find("input.loop_qty_request").data("itemcode")
        );
      }
    });

  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_request",
      array_itemcode: itemcode_array,
      array_qty: qty_array,
      txt_docno_request: $("#txt_docno_request").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      $("#txt_docno_request").val(ObjData);
      // $(".loop_qty_request ").val("");
      show_detail_item_request();
      if (ObjData != "") {
        setTimeout(() => {
          show_detail_request_byDocNo();
        }, 200);
        // $("#btn_cancel_request").attr("disabled", false);
        // $("#btn_send_request").attr("disabled", false);
      }
    },
  });
}

function show_detail_request_byDocNo() {
  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request_byDocNo",
      txt_docno_request: $("#txt_docno_request").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_detail_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td>${value.itemname}</td>
                      <td class='text-center'>${value.TyeName}</td>
                      <td class='text-center'><input type="text" class="form-control text-center qty_loop" id="qty_item_${
                        value.ID
                      }" data-id='${value.ID}' value='${value.cnt}'> </td>
                      <td class='text-center'>
                      <img src="assets/img_project/1_icon/ic_trash-1.png" style='width:30%;cursor:pointer;' onclick='delete_request_byItem(${
                        value.ID
                      })'>
                      </td>
                   </tr>`;
        });
      }

      $("#table_item_detail_request tbody").html(_tr);
      $("#table_item_detail_request").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
          search: settext("btn_Search"),
          info:
            settext("dataTables_Showing") +
            " _START_ " +
            settext("dataTables_to") +
            " _END_ " +
            settext("dataTables_of") +
            " _TOTAL_ " +
            settext("dataTables_entries") +
            " ",
        },
        columnDefs: [
          {
            width: "10%",
            targets: 0,
          },
          {
            width: "45%",
            targets: 1,
          },
          {
            width: "25%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
          },
          {
            width: "20%",
            targets: 4,
          },
        ],
        info: false,
        scrollX: false,
        scrollCollapse: false,
        visible: false,
        searching: false,
        lengthChange: false,
        fixedHeader: false,
        ordering: false,
      });
      $("th").removeClass("sorting_asc");
      if (_tr == "") {
        $(".dataTables_info").text(
          settext("dataTables_Showing") +
            " 0 " +
            settext("dataTables_to") +
            " 0 " +
            settext("dataTables_of") +
            " 0 " +
            settext("dataTables_entries") +
            ""
        );
      }
    },
  });
}

function add_request_qty(ID) {
  var qty = $("#qty_item_" + ID).val();

  qty = parseInt(qty) + parseInt(1);
  $("#qty_item_" + ID).val(qty);

  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "add_request_qty",
      ID: ID,
      qty: qty,
    },
    success: function (result) {},
  });
}

function delete_request_qty(ID) {
  var qty = $("#qty_item_" + ID).val();

  qty = parseInt(qty) - parseInt(1);

  if (qty < 0) {
    qty = 0;
  }
  $("#qty_item_" + ID).val(qty);

  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "delete_request_qty",
      ID: ID,
      qty: qty,
    },
    success: function (result) {},
  });
}

function delete_request_byItem(ID) {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยัน! การลบ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/create_request.php",
        type: "POST",
        data: {
          FUNC_NAME: "delete_request_byItem",
          ID: ID,
        },
        success: function (result) {
          var ObjData = JSON.parse(result);

          showDialogSuccess("ลบสำเร็จ");

          setTimeout(() => {
            show_detail_request_byDocNo();
          }, 300);
        },
      });
    }
  });
}

function onconfirm_send_request() {
  var qty_Array = [];
  var id_Array = [];

  $(".qty_loop").each(function () {
    qty_Array.push($(this).val());
    id_Array.push($(this).data("id"));
  });

  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_send_request",
      txt_docno_request: $("#txt_docno_request").val(),
      select_deproom_request: $("#select_deproom_request").val(),
      input_hn_request: $("#input_hn_request").val(),
      select_doctor_request: $("#select_doctor_request").val(),
      select_procedure_request: $("#select_procedure_request").val(),
      input_remark_request: $("#input_remark_request").val(),
      select_date_request: $("#select_date_request").val(),
      select_time_request: $("#select_time_request").val(),
      text_edit: $("#text_edit").val(),
      qty_Array: qty_Array,
      id_Array: id_Array,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("บันทึกสำเร็จ");

      setTimeout(() => {
        $("#table_item_detail_request").DataTable().destroy();
        $("#table_item_detail_request tbody").empty();
        $("#txt_docno_request").val("");
        $("#input_hn_request").val("");
        $("#select_date_request").val("");
        $("#select_time_request").val("");
        $("#text_edit").val("");

        $("#select_doctor_request").val("");
        $("#select2-select_doctor_request-container").text("กรุณาเลือกแพทย์");

        $("#select_deproom_request").val("");
        $("#select2-select_deproom_request-container").text(
          "กรุณาเลือกห้องผ่าตัด"
        );

        $("#select_procedure_request").val("");
        $("#select2-select_procedure_request-container").text(
          "กรุณาเลือกหัตถการ"
        );

        $("#input_remark_request").val("");
      }, 300);
    },
  });
}

// create_Request

// history
function show_detail_history() {
  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date_history_s: $("#select_date_history_s").val(),
      select_date_history_l: $("#select_date_history_l").val(),
      select_deproom_history: $("#select_deproom_history").val(),
      select_doctor_history: $("#select_doctor_history").val(),
      select_procedure_history: $("#select_procedure_history").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_history").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serviceDate}</td>
                      <td class='text-center'>${value.hn_record_id}</td>
                      <td class='text-left'>${value.Doctor_Name}</td>
                      <td class='text-left'>${value.Procedure_TH}</td>
                      <td class='text-center'>${value.departmentroomname}</td>
                      <td class='text-center'><button class='btn btn-outline-dark f18' onclick='edit_item_byDocNo("${
                        value.DocNo
                      }","${value.hn_record_id}","${value.serviceDate}","${
            value.doctor_ID
          }","${value.procedure_ID}","${value.deproom_ID}","${value.Remark}","${
            value.Doctor_Name
          }","${value.Procedure_TH}","${value.departmentroomname}","edit","${
            value.serviceTime
          }")'><i class="fa-regular fa-pen-to-square"></i> แก้ไข</button></td>
                      <td hidden class='text-center'><button class='btn btn-outline-danger f18' onclick='cancel_item_byDocNo("${
                        value.DocNo
                      }")' >ยกเลิก</button></td>
                      <td class='text-center'><button class='btn f18' style='background-color:#1570EF;color:#fff;' onclick='show_Report("${
                        value.DocNo
                      }")'>รายงานขอเบิก</button></td>
                   </tr>`;
        });
      }

      $("#table_history tbody").html(_tr);
      $("#table_history").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
          search: settext("btn_Search"),
          info:
            settext("dataTables_Showing") +
            " _START_ " +
            settext("dataTables_to") +
            " _END_ " +
            settext("dataTables_of") +
            " _TOTAL_ " +
            settext("dataTables_entries") +
            " ",
        },
        columnDefs: [
          {
            width: "5%",
            targets: 0,
          },
          {
            width: "10%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 2,
          },
          {
            width: "15%",
            targets: 3,
          },
          {
            width: "15%",
            targets: 4,
          },
          {
            width: "10%",
            targets: 5,
          },
          {
            width: "8%",
            targets: 6,
          },
          {
            width: "8%",
            targets: 7,
          },
          {
            width: "10%",
            targets: 8,
          },
        ],
        info: false,
        scrollX: false,
        scrollCollapse: false,
        visible: false,
        searching: false,
        lengthChange: false,
        fixedHeader: false,
        ordering: false,
      });
      $("th").removeClass("sorting_asc");
      if (_tr == "") {
        $(".dataTables_info").text(
          settext("dataTables_Showing") +
            " 0 " +
            settext("dataTables_to") +
            " 0 " +
            settext("dataTables_of") +
            " 0 " +
            settext("dataTables_entries") +
            ""
        );
      }
    },
  });
}

$("#btn_show_report").click(function () {
  option = "?select_date_history_s=" + $("#select_date_history_s").val()+"&select_date_history_l=" + $("#select_date_history_l").val();
  window.open("report/phpexcel/Report_Create_Order_HN.php" + option, "_blank");
});

function show_Report(DocNo) {
  option = "?DocNo=" + DocNo;
  window.open("report/Report_create_request.php" + option, "_blank");
}

function cancel_item_byDocNo(DocNo) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การยกเลิก?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/create_request.php",
        type: "POST",
        data: {
          FUNC_NAME: "cancel_item_byDocNo",
          txt_docno_request: DocNo,
        },
        success: function (result) {
          var ObjData = JSON.parse(result);
          console.log(ObjData);

          showDialogSuccess("ยกเลิกสำเร็จ");

          setTimeout(() => {
            show_detail_history();
          }, 300);
        },
      });
    }
  });
}

function edit_item_byDocNo(
  DocNo,
  hn_record_id,
  serviceDate,
  doctor_ID,
  procedure_ID,
  deproom_ID,
  Remark,
  Doctor_Name,
  Procedure_TH,
  departmentroomname,
  text_edit,
  serviceTime
) {
  $("#radio_create_request").click();

  $("#txt_docno_request").val(DocNo);
  $("#input_hn_request").val(hn_record_id);
  $("#select_date_request").val(serviceDate);
  $("#select_doctor_request").val(doctor_ID);
  $("#select_time_request").val(serviceTime);

  $("#select2-select_doctor_request-container").text(Doctor_Name);
  $("#select2-select_deproom_request-container").text(departmentroomname);
  $("#select2-select_procedure_request-container").text(Procedure_TH);

  $("#text_edit").val(text_edit);

  $("#select_deproom_request").val(deproom_ID);
  $("#select_procedure_request").val(procedure_ID);
  $("#input_remark_request").val(Remark);

  show_detail_request_byDocNo();
}

// history

//////////////////////////////////////////////////////////////// select
function select_deproom() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_deproom",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกห้องผ่าตัด</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.id}" >${value.departmentroomname}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_deproom_request").html(option);
      $("#select_deproom_history").html(option);
    },
  });
}

function select_doctor() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_doctor",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกแพทย์</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Doctor_Name}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_doctor_request").html(option);
      $("#select_doctor_history").html(option);
    },
  });
}

function select_procedure() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_procedure",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกหัตถการ</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Procedure_TH}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_procedure_request").html(option);
      $("#select_procedure_history").html(option);
    },
  });
}

//////////////////////////////////////////////////////////////// select

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

      $("#input_Deproom_Main").val(departmentroomname);
      $("#input_Name_Main").val(UserName);
    },
  });
}
function showDialogFailed(text) {
  Swal.fire({
    title: settext("alert_fail"),
    text: text,
    icon: "error",
  });
}
function showDialogSuccess(text) {
  Swal.fire({
    title: settext("alert_success"),
    text: text,
    icon: "success",
    timer: 1000,
  });
}
function convertString(S_Input) {
  var S_QR = "";

  if (S_Input.length > 0) {
    if (S_Input.charCodeAt(0) > 1000) {
      for (var i = 0; i < S_Input.length; i++) {
        S_QR += convertEN(S_Input[i]);
      }
    } else {
      S_QR = S_Input;
    }
  }

  return S_QR;
}
function convertEN(char) {
  switch (char) {
    case "ข":
      return "-";
    case "จ":
      return "0";
    case "ๅ":
      return "1";
    case "/":
      return "2";
    case "-":
      return "3";
    case "ภ":
      return "4";
    case "ถ":
      return "5";
    case "ุ":
      return "6";
    case "ึ":
      return "7";
    case "ค":
      return "8";
    case "ต":
      return "9";
    case "ฤ":
      return "A";
    case "ฺ":
      return "B";
    case "ฉ":
      return "C";
    case "ฏ":
      return "D";
    case "ฎ":
      return "E";
    case "โ":
      return "F";
    case "ฌ":
      return "G";
    case "็":
      return "H";
    case "ณ":
      return "I";
    case "๋":
      return "J";
    case "ษ":
      return "K";
    case "ศ":
      return "L";
    case "?":
      return "M";
    case "์":
      return "N";
    case "ฯ":
      return "O";
    case "ญ":
      return "P";
    case "๐":
      return "Q";
    case "ฑ":
      return "R";
    case "ฆ":
      return "S";
    case "ธ":
      return "T";
    case "๊":
      return "U";
    case "ฮ":
      return "V";
    case '"':
      return "W";
    case ")":
      return "X";
    case "ํ":
      return "Y";
    case "(":
      return "Z";
    case "ฟ":
      return "a";
    case "ิ":
      return "b";
    case "แ":
      return "c";
    case "ก":
      return "d";
    case "ำ":
      return "e";
    case "ด":
      return "f";
    case "เ":
      return "g";
    case "้":
      return "h";
    case "ร":
      return "i";
    case "่":
      return "j";
    case "า":
      return "k";
    case "ส":
      return "l";
    case "ท":
      return "m";
    case "ื":
      return "n";
    case "น":
      return "o";
    case "ย":
      return "p";
    case "ๆ":
      return "q";
    case "พ":
      return "r";
    case "ห":
      return "s";
    case "ะ":
      return "t";
    case "ี":
      return "u";
    case "อ":
      return "v";
    case "ไ":
      return "w";
    case "ป":
      return "x";
    case "ั":
      return "y";
    case "ผ":
      return "z";
    default:
      return " ";
  }
}
function set_date() {
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

  return output;
}
