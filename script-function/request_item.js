var RqDocNo_x = "";
var RtDocNo_x = "";
var tb_rq2 = null;

$(function () {



  $("#customSwitch1").change(function () {
    if ($(this).is(":checked")) {
      showdetail(RqDocNo_x, RtDocNo_x, 1);
      $("#qr_change").text("จำนวน");
    } else {
      showdetail(RqDocNo_x, RtDocNo_x, 0);
    }
  });

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
  $("#select_date1_rq").val(output);
  $("#select_date1_rq").datepicker({
    onSelect: function (date) {
      show_detail_receive();
    },
  });
  $("#select_date2_rq").val(output);
  $("#select_date2_rq").datepicker({
    onSelect: function (date) {
      show_detail_receive();
    },
  });

  $("#select_date1_search").val(output);
  $("#select_date1_search").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  $("#select_date2_search").val(output);
  $("#select_date2_search").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  select_type();
  set_menu();
  session();
  show_detail_item_request();




  // toggle เปิด/ปิด sub
  $("#table_rq2 tbody").on("click", ".btn-toggle-rq", function () {
    const tr = $(this).closest("tr");
    const row = tb_rq2.row(tr);
    const rq = tr.data("rqdocno");

    if (row.child.isShown()) {
      // หุบ
      row.child.hide();
      $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
    } else {
      // ขยาย
      const childHtml = buildChildTable(rqDetails[rq], rq);
      row.child(childHtml).show();
      $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }
  });

  // checkbox ในแถวลูก
  $("#table_rq2 tbody").on("click", ".clear_checkbox", function (e) {
    e.stopPropagation(); // กันคลิกแล้วไป trigger toggle แถว
    const el = $(this);
    oncheck_show_byDocNo(
      el.data("docnort"),
      el.data("docnorq"),
      el.data("status")
    );
  });






  if (localStorage.request_item == 1) {
    $("#radio_receive").click();
    localStorage.removeItem("request_item");
  } else {
    $("#select_typeItem_request").select2();
  }
});


function initDT_rq2() {
  tb_rq2 = $("#table_rq2").DataTable({
    paging: true,
    pageLength: 10,
    ordering: false,
    lengthChange: false,   // << ปิด Show x entries
    searching: false,
    info: false,
    autoWidth: false,
    retrieve: true, // ถ้ามีแล้วให้ reuse
    language: {
      paginate: {
        previous: "ก่อนหน้า",
        next: "ถัดไป"
      },
      info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
      infoEmpty: "ไม่มีข้อมูล",
      zeroRecords: "ไม่พบข้อมูล"
    }
  });
}



$("#select_typeItem_request").change(function () {
  show_detail_item_request();
});

$("#input_search_request").on("keyup", function (e) {
  show_detail_item_request();
});

$("#input_search_request_rq").on("keyup", function (e) {
  show_detail_request_byDocNo();
});

$("#btn_clear_request").click(function () {
  $("#table_rq").DataTable().destroy();
  $("#table_rq tbody").empty();
  $("#input_docnoRQ").val("");

  select_type();


  show_detail_item_request();
});

$("#btn_confirm_send_request").click(function () {
  if ($("#input_docnoRQ").val() == "") {
    showDialogFailed("กรุณากรอก เพิ่มรายการ");
    return;
  }

  let table = $("#table_rq").DataTable(); // อ้างอิง DataTable instance
  let rowCount = table.rows({ filter: "applied" }).count(); // นับแถวที่ยังแสดงอยู่ (ไม่ถูก filter)

  if (rowCount === 0) {
    showDialogFailed("กรุณาเพิ่มออุปกรณ์");
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


$("#btn_receive_all").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การรับเข้าทั้งหมด ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_receive_all();
    }
  });
});



function onconfirm_send_request() {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_send_request",
      txt_docno_request: $("#input_docnoRQ").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("บันทึกสำเร็จ");

      setTimeout(() => {
        $("#table_rq").DataTable().destroy();
        $("#table_rq tbody").empty();
        $("#input_docnoRQ").val("");

        select_type();
        show_detail_item_request();
      }, 300);
    },
  });
}

function show_detail_item_request() {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_request",
      input_search_request: $("#input_search_request").val(),
      select_typeItem: $("#select_typeItem_request").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var color = "style='line-height: 40px;'";
          var input_cnt = "";
          if (value.stock_min == null) {
            value.stock_min = 0;
          }
          if (value.cntx < value.stock_min) {
            color = "style='color:red;line-height: 40px;' ";
            input_cnt = `<input tyle='text' class='text-center form-control numonly loop_qty_request' data-itemcode="${value.itemcode}" >`;
          }
          _tr += `<tr>
                      <td class='text-center' style='line-height: 40px;'>${value.itemcode2}</td>
                      <td class='text-left' style='line-height: 40px;'>${value.Item_name}</td>
                      <td class='text-center' style='line-height: 40px;'>${value.stock_min}</td>
                      <td class='text-center'  ${color}>${value.cntx}</td>
                      <td class='text-center' style='line-height: 40px;'>${input_cnt}</td>
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
            width: "15%",
            targets: 0,
          },
          {
            width: "40%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
          },
          {
            width: "13%",
            targets: 4,
          },
        ],
        autoWidth: false,
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

      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

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
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_request",
      array_itemcode: itemcode_array,
      array_qty: qty_array,
      txt_docno_request: $("#input_docnoRQ").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      $("#input_docnoRQ").val(ObjData);
      show_detail_item_request();
      if (ObjData != "") {
        setTimeout(() => {
          show_detail_request_byDocNo();
        }, 200);
      }
    },
  });
}

function show_detail_request_byDocNo() {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request_byDocNo",
      txt_docno_request: $("#input_docnoRQ").val(),
      input_search_request_rq: $("#input_search_request_rq").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_rq").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr tr_${value.ID}>
                      <td class='text-center'>${value.itemcode}</td>
                      <td class='text-left'>${value.itemname}</td>
                      <td class='text-center'>${value.cnt}</td>
                   </tr>`;
        });
      }

      $("#table_rq tbody").html(_tr);
      $("#table_rq").DataTable({
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
            targets: 0,
          },
          {
            width: "20%",
            targets: 1,
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

      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9-]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

function set_menu() {
  $("#row_receive").hide();
  $("#row_history").hide();

  $("#radio_request").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#row_request").show();
    $("#row_receive").hide();
    $("#row_history").hide();

    $("#select_typeItem_request").select2();
  });

  $("#radio_receive").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#row_request").hide();
    $("#row_receive").show();
    $("#row_history").hide();

    initDT_rq2();
    show_detail_receive();

  });

  $("#radio_history").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#row_request").hide();
    $("#row_receive").hide();
    $("#row_history").show();

    show_detail_history();
  });
}

function select_type() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_type",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>เลือกทั้งหมด</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.TyeName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_typeItem_request").html(option);

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

function show_detail_history() {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date1_search: $("#select_date1_search").val(),
      select_date2_search: $("#select_date2_search").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_history tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.StatusDocNo == "2") {
            var txt =
              "<label style='color:#1cc88a;font-weight: bold;'>Complete</label>";
          } else {
            var txt = "<label style='color:#643695;'>Waiting</label>";
          }

          _tr += `<tr>
                      <td class="f18 text-center">${value.RqDocNo}</td>
                      <td class="f18 text-center">${value.RtDocNo}</td>
                      <td class="f18 text-center">${value.Createdate}</td>
                      <td class="f18 text-center">${value.Createtime}</td>
                      <td class="f18 text-center"><button class='btn btn-primary f18' onclick='showdetail_popup("${value.RqDocNo}","${value.RtDocNo}")'>แสดงรายละเอียด</button></td>
                      <td class="f18 text-center"><button class="btn f18" style="background-color:#643695;color:#fff;" onclick='show_Report("${value.RqDocNo}","${value.RtDocNo}")'>รายงาน</button></td>
                      <td class="f18 text-center">${txt}</td>
                   </tr>`;
        });
      }

      $("#table_history tbody").html(_tr);
    },
  });
}

function show_Report(RqDocNo, RtDocNo) {
  option = "?RqDocNo=" + RqDocNo + "&RtDocNo=" + RtDocNo;
  window.open("report/request_item.php" + option, "_blank");
}

$("#customSwitch1").click(function () { });

function showdetail_popup(RqDocNo, RtDocNo) {
  RqDocNo_x = RqDocNo;
  RtDocNo_x = RtDocNo;
  $("#myModal_detail").modal("toggle");
  showdetail(RqDocNo, RtDocNo, 0);
}

function showdetail(RqDocNo, RtDocNo, check_show) {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showdetail",
      RqDocNo: RqDocNo,
      RtDocNo: RtDocNo,
      check_show: check_show,
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_detail tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class="f18 text-center">${kay + 1}</td>
                      <td class="f18 text-center">${value.itemcode}</td>
                      <td class="f18 text-left">${value.itemname}</td>
                      <td class="f18 text-center">${value.QrCode}</td>
                   </tr>`;
        });
      }

      $("#table_detail tbody").html(_tr);
    },
  });
}

// function show_detail_receive() {
//   $.ajax({
//     url: "process/request_item.php",
//     type: "POST",
//     data: {
//       FUNC_NAME: "show_detail_receive",
//       select_date1_rq: $("#select_date1_rq").val(),
//       select_date2_rq: $("#select_date2_rq").val(),
//     },
//     success: function (result) {
//       var _tr = "";
//       // $("#table_deproom_pay").DataTable().destroy();
//       $("#table_rq2 tbody").html("");
//       var ObjData = JSON.parse(result);
//       if (!$.isEmptyObject(ObjData)) {
//         $.each(ObjData["rq"], function (kay, value) {
//           _tr += `<tr id='trbg_${value.RqDocNo}'>
//                       <td class="f24 text-left">

//                       <i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;' id='open_${value.RqDocNo}' value='0' onclick='open_receive_sub("${value.RqDocNo}")'></i>

//                       </td>
//                       <td class="f24 text-left">${value.RqDocNo}</td>
//                       <td class="f24 text-left"></td>
//                       <td class="f24 text-left"></td>
//                    </tr>`;
//           $.each(ObjData[value.RqDocNo], function (kay2, value2) {
//             if (value2.StatusDocNo == "2") {
//               var txt = "Complete";
//               var bg_g = "style='background-color: lightgreen;'";
//             } else {
//               var txt = "Waiting";
//               var bg_g = "";
//             }

//             if (value2.type_cre == 1) {
//               var txt2 = "main";
//             } else {
//               var txt2 = "sub";
//             }

//             _tr += `<tr class='tr_${value.RqDocNo} all111' ${bg_g}>
//                        <td class="f24 text-center">

//                                <input 
//                                 style="width: 20px;height: 20px;"
//                                 class="form-check-input position-static clear_checkbox"
//                                 type="checkbox"
//                                 id="checkbox_${value2.RtDocNo}"
//                                 data-docnort="${value2.RtDocNo}"
//                                 data-docnorq="${value.RqDocNo}"
//                                 data-status="${value2.StatusDocNo}"  >



//                        </td>
//                        <td class="f24 text-center">${value2.RtDocNo}(${txt2})</td>
//                        <td class="f24 text-left">${txt}</td>
//                        <td class="f24 text-center">${value2.cnt}</td>
//                     </tr>`;
//           });
//         });
//       }

//       $("#table_rq2 tbody").html(_tr);
//       $(".all111").hide();

//       $(".clear_checkbox").on("click", function () {
//         const el = $(this);
//         oncheck_show_byDocNo(
//           el.data("docnort"),
//           el.data("docnorq"),
//           el.data("status")
//         );
//       });
//     },
//   });
// }

function show_detail_receive() {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_receive",
      select_date1_rq: $("#select_date1_rq").val(),
      select_date2_rq: $("#select_date2_rq").val(),
    },
    success: function (result) {
      var _tr = "";
      rqDetails = {}; // เคลียร์ของเก่า

      var ObjData = JSON.parse(result);

      // destroy datatable เก่า
      if ($.fn.DataTable.isDataTable("#table_rq2")) {
        $("#table_rq2").DataTable().clear().destroy();
      }
      $("#table_rq2 tbody").empty();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["rq"], function (k, value) {

          // เก็บ sub ของแต่ละ RQ ไว้ใน rqDetails
          rqDetails[value.RqDocNo] = ObjData[value.RqDocNo] || [];



          if (value.StatusDocNo == 0) {
            var txt1 = "รอ";
            var bg_g1 = "background-color: lightgreen;";
          } else {
            var txt1 = "เสร็จสิ้น";
            var bg_g1 = "";
          }


          // สร้างแถวหัวอย่างเดียว
          _tr += `
            <tr id="trbg_${value.RqDocNo}" data-rqdocno="${value.RqDocNo}">
              <td class="f24 text-left">
                <i class="fa-solid fa-chevron-down btn-toggle-rq"
                   style="font-size:20px;cursor:pointer;"
                   id="open_${value.RqDocNo}"></i>
              </td>
              <td class="f24 text-left">${value.RqDocNo}</td>
              <td class="f24 text-center">${txt1}</td>
              <td class="f24 text-left"></td>
            </tr>`;
        });
      }

      $("#table_rq2 tbody").html(_tr);

      // สร้าง DataTable ใหม่ (เลขหน้าใช้เฉพาะหัว RQ)
      initDT_rq2();
    },
  });
}

function buildChildTable(list, rqDocNo) {
  if (!list || list.length === 0) {
    return '<div style="padding:5px 20px;">ไม่มีรายการย่อย</div>';
  }

  var html = '<table class="table table-sm mb-0" style="background:#f8f9fa;">';
  $.each(list, function (i, value2) {
    let txt, bg_g;
    if (value2.StatusDocNo == "2") {
      txt = "เสร็จสิ้น";
      bg_g = "background-color: lightgreen;";
    } else {
      txt = "รอ";
      bg_g = "";
    }

    let txt2 = (value2.type_cre == 1) ? "main" : "sub";

    html += `
      <tr style="${bg_g}">
        <td class="f24 text-center" style="width:5%;">
          <input 
            style="width: 20px;height: 20px;"
            class="form-check-input position-static clear_checkbox"
            type="checkbox"
            id="checkbox_${value2.RtDocNo}"
            data-docnort="${value2.RtDocNo}"
            data-docnorq="${rqDocNo}"
            data-status="${value2.StatusDocNo}">
        </td>
        <td class="f24 text-center" style="width:50%;">${value2.RtDocNo} (${txt2})</td>
        <td class="f24 text-center" style="width:10%;">${txt}</td>
        <td class="f24 text-center" style="width:10%;">${value2.cnt}</td>
      </tr>`;
  });
  html += "</table>";
  return html;
}

function oncheck_show_byDocNo(docnort, docnorq, status) {
  if (status == "2") {
    $("#btn_confirm_RQ").attr("disabled", true);
  } else {
    $("#btn_confirm_RQ").attr("disabled", false);
  }
  $(".clear_checkbox").prop("checked", false);
  $("#checkbox_" + docnort).prop("checked", true);

  $("#btn_confirm_RQ").data("docnort", docnort);
  $("#btn_confirm_RQ").data("docnorq", docnorq);

  $("#checkAll").prop('checked', false);
  show_detail_item_ByDocNo(docnort, docnorq);
}

function show_detail_item_ByDocNo(docnort, docnorq) {
  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_ByDocNo",
      docnort: docnort,
      docnorq: docnorq,
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_rq tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          _tr += `<tr id='trbg_${value.itemcode}'>
                      <td class="f24 text-left">
                      <i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;' id='open_${value.itemcode}' value='0' onclick='open_item_sub("${value.itemcode}")'></i>
                      </td>
                      <td class="f24 text-center">${value.itemcode2}</td>
                      <td class="f24 text-left">${value.itemname}</td>
                      <td class="f24 text-center">${value.cnt}</td>
                   </tr>`;
          $.each(ObjData[value.itemcode], function (kay2, value2) {

            var dis = "";
            if (value2.Stockin == 1) {
              dis = 'disabled checked';
            }
            _tr += `<tr class='tr_${value.itemcode} all222'>
                       <td class="f24 text-center"></td>
                       <td class="f24 text-center">

                               <input ${dis}
                                style="width: 20px;height: 20px;"
                                class="form-check-input position-static clear_checkbox2"
                                type="checkbox"  data-qrcode="${value2.QrCode}" >
                       </td>
                       <td class="f24 text-center">${value2.QrCode}</td>
                       <td class="f24 text-center"></td>
                    </tr>`;
          });
        });
      }

      $("#table_detail_rq tbody").html(_tr);
      $(".all222").hide();
    },
  });
}

$(document).on("change", "#checkAll", function () {
  const checked = $(this).is(":checked");

  // เช็คเฉพาะตัวที่ไม่ disabled
  $(".clear_checkbox2:not(:disabled)").prop("checked", checked);
});

$("#btn_confirm_RQ").click(function () {
  if ($("#table_detail_rq tbody tr").length == 0) {
    showDialogFailed("กรุณาเลือกเอกสาร");
    return;
  }
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การบันทึก",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_RQ();
    }
  });
});




function onconfirm_receive_all() {

  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_receive_all",
      select_date1_rq: $("#select_date1_rq").val(),
      select_date2_rq: $("#select_date2_rq").val(),
    },
    success: function (result) {
      $("#table_detail_rq tbody").html("");
      show_detail_receive();
      showDialogSuccess("บันทึกสำเร็จ");
    },
  });
}

function onconfirm_RQ() {
  var checkbox = Array();
  var qrcode = Array();
  var count_all = 0;
  $(".clear_checkbox2").each(function () {
    if ($(this).is(":checked")) {
      checkbox.push(1);
      qrcode.push($(this).data('qrcode'));
    }
    count_all++;
  });



  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_RQ",
      docnort: $("#btn_confirm_RQ").data("docnort"),
      docnorq: $("#btn_confirm_RQ").data("docnorq"),
      checkbox: checkbox,
      qrcode: qrcode,
      count_all: count_all,
    },
    success: function (result) {
      $("#table_detail_rq tbody").html("");
      show_detail_receive();
      showDialogSuccess("บันทึกสำเร็จ");
    },
  });
}

function open_item_sub(itemcode) {
  if ($("#open_" + itemcode).val() == 1) {
    $("#open_" + itemcode).val(0);
    $("#open_" + itemcode).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + itemcode).hide(300);

    $("#trbg_" + itemcode).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + itemcode).val(1);
    $("#open_" + itemcode).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + itemcode).show(500);

    $("#trbg_" + itemcode).css("background-color", "#EFF8FF");
  }
}

function open_receive_sub(RqDocNo) {
  if ($("#open_" + RqDocNo).val() == 1) {
    $("#open_" + RqDocNo).val(0);
    $("#open_" + RqDocNo).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + RqDocNo).hide(300);

    $("#trbg_" + RqDocNo).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + RqDocNo).val(1);
    $("#open_" + RqDocNo).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + RqDocNo).show(500);

    $("#trbg_" + RqDocNo).css("background-color", "#EFF8FF");

    console.log($("#trbg_" + RqDocNo).length); // ควรได้ค่าเป็น 1

    // $(".tr_"+id).attr('hidden',false);
  }
}

//

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
