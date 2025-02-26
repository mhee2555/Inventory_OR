var departmentroomname = "";
var UserName = "";
var deproom = "";
var RefDepID = "";

$(function () {
  $("#request").hide();
  $("#history_request").hide();

  $("#radio_useitem").css("color", "#1570EF");
  $("#radio_useitem").css(
    "background",
    "linear-gradient(0deg, #EFF8FF, #EFF8FF),linear-gradient(0deg, #D0D5DD, #D0D5DD)"
  );

  $("#radio_useitem").click(function () {
    $("#radio_useitem").css("color", "#1570EF");
    $("#radio_useitem").css(
      "background",
      "linear-gradient(0deg, #EFF8FF, #EFF8FF),linear-gradient(0deg, #D0D5DD, #D0D5DD)"
    );

    $("#radio_request").css("color", "black");
    $("#radio_request").css("background", "");
    $("#radio_history_request").css("color", "black");
    $("#radio_history_request").css("background", "");

    $("#use_item").show();
    $("#request").hide();
    $("#history_request").hide();
  });

  $("#radio_request").click(function () {
    $("#radio_request").css("color", "#1570EF");
    $("#radio_request").css(
      "background",
      "linear-gradient(0deg, #EFF8FF, #EFF8FF),linear-gradient(0deg, #D0D5DD, #D0D5DD)"
    );

    $("#radio_useitem").css("color", "black");
    $("#radio_useitem").css("background", "");
    $("#radio_history_request").css("color", "black");
    $("#radio_history_request").css("background", "");

    $("#request").show();
    $("#use_item").hide();
    $("#history_request").hide();

    show_detail_request();
    $("#select_deproom_request").select2();
    $("#select_doctor_request").select2();
    $("#select_procedure_request").select2();

    $("#select_deproom_request").val(deproom);
    $("#select2-select_deproom_request-container").text(departmentroomname);

    if (RefDepID == "36DEN") {
      $("#select_deproom_request").attr("disabled", true);
    }
  });

  $("#radio_history_request").click(function () {
    $("#radio_history_request").css("color", "#1570EF");
    $("#radio_history_request").css(
      "background",
      "linear-gradient(0deg, #EFF8FF, #EFF8FF),linear-gradient(0deg, #D0D5DD, #D0D5DD)"
    );

    $("#radio_useitem").css("color", "black");
    $("#radio_useitem").css("background", "");
    $("#radio_request").css("color", "black");
    $("#radio_request").css("background", "");

    $("#request").hide();
    $("#use_item").hide();
    $("#history_request").show();

    $("#select_date_history").val(set_date());
    show_detail_history_request();
  });
  session();

  $("#select_date_item_use_success").val(set_date());
  setTimeout(() => {
    $("#input_Deproom_Main").val(departmentroomname);
    $("#input_Name_Main").val(UserName);
    show_detail_use_byDeproom();
    show_detail_useSuccess_byDeproom();
  }, 200);

  select_deproom();
  select_doctor();
  select_procedure();
});

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
      var option = `<option value="" selected>กรุณาเลือกห้องตรวจ</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.id}" >${value.departmentroomname}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_deproom_request").html(option);
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
    },
  });
}

//////////////////////////////////////////////////////////////// select

//////////////////////////////////////////////////////////////// request
$("#btn_search_request").click(function () {
  show_detail_request();
});

$("#btn_comfirm_request").click(function () {
  var count_qty_request = 0;
  $(".loop_qty_request").each(function (key, value) {
    if ($(this).val() == "") {
    } else {
      count_qty_request++;
    }
  });

  if ($("#select_deproom_request").val() == "") {
    showDialogFailed("กรุณาเลือกห้องตรวจ");
    return;
  }
  if ($("#input_hn_request").val() == "") {
    showDialogFailed("กรุณากรอก HN Number");
    return;
  }
  if ($("#select_doctor_request").val() == "") {
    showDialogFailed("กรุณาเลือกแพทย์");
    return;
  }
  if ($("#select_procedure_request").val() == "") {
    showDialogFailed("กรุณาเลือกหัตถการ");
    return;
  }
  if (count_qty_request == 0) {
    showDialogFailed("กรุณากรอกจำนวน");
    return;
  }
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: settext("lang_text_confirmRequest"),
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_request();
    }
  });
});

$("#btn_cancel_request").click(function () {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: settext("lang_text_confirmCancelData"),
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_cancel_request();
    }
  });
});

$("#btn_send_request").click(function () {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: settext("lang_text_confirmSendData"),
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_sned_request();
    }
  });
});

function show_detail_request() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request",
      input_Search: $("#input_Search").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                    <td style='width:100px'>${value.Item_name}</td>
                    <td><input type='number' class='form-control loop_qty_request' data-itemcode='${value.itemcode}'  style='font-size:20px;'></td>
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
            width: "20%",
            targets: 1,
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
  var array_itemcode = [];
  var array_qty = [];

  $(".loop_qty_request").each(function (key, value) {
    if ($(this).val() != "") {
      array_itemcode.push($(this).data("itemcode"));
      array_qty.push($(this).val());

      $(this).val("");
    }
  });

  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_request",
      txt_docno_request: $("#txt_docno_request").text(),
      array_itemcode: array_itemcode,
      array_qty: array_qty,
      select_deproom_request: $("#select_deproom_request").val(),
      input_hn_request: $("#input_hn_request").val(),
      select_doctor_request: $("#select_doctor_request").val(),
      select_procedure_request: $("#select_procedure_request").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      $("#txt_docno_request").text(ObjData);
      if (ObjData != "") {
        setTimeout(() => {
          show_detail_request_byDocNo();
        }, 200);
        $("#btn_cancel_request").attr("disabled", false);
        $("#btn_send_request").attr("disabled", false);
      }
    },
  });
}

function onconfirm_cancel_request() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_cancel_request",
      txt_docno_request: $("#txt_docno_request").text(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("ยกเลิกสำเร็จ");

      setTimeout(() => {
        $("#table_item_detail_request").DataTable().destroy();
        $("#table_item_detail_request tbody").empty();
        $("#txt_docno_request").text("");
        $("#btn_cancel_request").attr("disabled", true);
        $("#btn_send_request").attr("disabled", true);
      }, 300);
    },
  });
}

function onconfirm_sned_request() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_sned_request",
      txt_docno_request: $("#txt_docno_request").text(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("บันทึกสำเร็จ");

      setTimeout(() => {
        $("#table_item_detail_request").DataTable().destroy();
        $("#table_item_detail_request tbody").empty();
        $("#txt_docno_request").text("");
        $("#btn_cancel_request").attr("disabled", true);
        $("#btn_send_request").attr("disabled", true);
      }, 300);
    },
  });
}

function show_detail_request_byDocNo() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request_byDocNo",
      txt_docno_request: $("#txt_docno_request").text(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_detail_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td>${value.itemname}</td>
                      <td>${value.cnt}</td>
                      <td><label><i class="fa-solid fa-trash  actionBtn text-danger" title="edit" style="cursor:pointer;"></i></label></td>
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
            width: "80%",
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
//////////////////////////////////////////////////////////////// request

//////////////////////////////////////////////////////////////// use
$("#input_use").keypress(function (e) {
  if (e.which == 13) {
    $("#input_use").val(convertString($(this).val()));
    oncheck_use_usagecode($(this).val());
  }
});
$("#input_stock_back").keypress(function (e) {
  if (e.which == 13) {
    $("#input_stock_back").val(convertString($(this).val()));
    oncheck_return_usagecode($(this).val());
  }
});
$("#btn_send_use").click(function () {
  var count_qty_use = 0;
  $(".loop_qty_pay").each(function (key, value) {
    if ($(this).text() == "") {
    } else {
      count_qty_use++;
    }
  });

  if (count_qty_use == 0) {
    showDialogFailed("กรุณาสแกนใช้");
    return;
  }

  Swal.fire({
    title: settext("lang_text_confirm"),
    text: settext("lang_text_confirmSendData"),
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_use();
    }
  });
});
$("#select_date_item_use_success").datepicker({
  onSelect: function (date) {
    show_detail_useSuccess_byDeproom();
  },
});

function oncheck_use_usagecode(input_use) {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_use_usagecode",
      input_use: input_use,
    },
    success: function (result) {
      if (result == 0) {
        showDialogFailed("ไม่พบข้อมูล");
      } else {
        show_detail_use_byDeproom();
      }
      $("#input_use").val("");
    },
  });
}
function oncheck_return_usagecode(input_stock_back) {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_return_usagecode",
      input_stock_back: input_stock_back,
    },
    success: function (result) {
      if (result == 0) {
        showDialogFailed("ไม่พบข้อมูล");
      } else {
        show_detail_use_byDeproom();
      }
      $("#input_stock_back").val("");
    },
  });
}
function show_detail_use_byDeproom() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_use_byDeproom",
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_use").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.UsageCode}</td>
                      <td>${value.itemname}</td>
                      <td class='text-center loop_qty_pay' data-usagecode='${
                        value.UsageCode
                      }' >${value.count_qty}</td>
                   </tr>`;
        });
      }

      $("#table_item_use tbody").html(_tr);
      $("#table_item_use").DataTable({
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
            width: "40%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 2,
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
function onconfirm_use() {
  var array_usagecode = [];

  $(".loop_qty_pay").each(function (key, value) {
    if ($(this).text() != "") {
      array_usagecode.push($(this).data("usagecode"));
    }
  });

  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_use",
      array_usagecode: array_usagecode,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("สงข้อมูลสำเร็จ");

      setTimeout(() => {
        $("#table_item_use").DataTable().destroy();
        $("#table_item_use tbody").empty();
        show_detail_useSuccess_byDeproom();
      }, 300);
    },
  });
}
function show_detail_useSuccess_byDeproom() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_useSuccess_byDeproom",
      select_date_item_use_success: $("#select_date_item_use_success").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_use_success").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.itemname}</td>
                      <td class='text-center '>${value.count_qty}</td>
                   </tr>`;
        });
      }

      $("#table_item_use_success tbody").html(_tr);
      $("#table_item_use_success").DataTable({
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
            width: "40%",
            targets: 1,
          },
          {
            width: "40%",
            targets: 2,
          },
          {
            width: "20%",
            targets: 2,
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

//////////////////////////////////////////////////////////////// use

//////////////////////////////////////////////////////////////// history
$("#select_date_history").datepicker({
  onSelect: function (date) {
    show_detail_history_request();
  },
});

function show_detail_history_request() {
  $.ajax({
    url: "process/roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history_request",
      select_date_history: $("#select_date_history").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_history_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr class='bg_focus_pay' style='cursor:pointer;'>
                    <td class='text-center'>${value.hn_record_id}</td>
                    <td class='text-left'>${value.Doctor_Name}</td>
                    <td class='text-center'>${value.Procedure_TH}</td>
                    <td class='text-center'><i class="fa-solid fa-pen-to-square" style='color: dodgerblue;corsor:pointer;' onclick='onconform_editDocNo("${value.DocNo}","${value.hn_record_id}","${value.doctor_ID}","${value.Doctor_Name}","${value.procedure_ID}","${value.Procedure_TH}")'></i></td>
                 </tr>`;
        });
      }

      $("#table_history_request tbody").html(_tr);
      $("#table_history_request").DataTable({
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
            width: "30%",
            targets: 0,
          },
          {
            width: "30%",
            targets: 1,
          },
          {
            width: "30%",
            targets: 2,
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
function onconform_editDocNo(
  DocNo,
  hn_record_id,
  doctor_ID,
  Doctor_Name,
  procedure_ID,
  Procedure_TH
) {
  $("#txt_docno_request").text(DocNo);
  $("#input_hn_request").val(hn_record_id);
  $("#select_doctor_request").val(doctor_ID);
  $("#select2-select_doctor_request-container").text(Doctor_Name);
  $("#select_procedure_request").val(procedure_ID);
  $("#select2-select_procedure_request-container").text(Procedure_TH);
  setTimeout(() => {
    $("#radio_request").click();
    show_detail_request_byDocNo();
  }, 300);
}

//////////////////////////////////////////////////////////////// history

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
