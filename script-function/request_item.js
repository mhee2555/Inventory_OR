$(function () {

  select_type();
  set_menu();
  session();
  show_detail_item_request();
});



$("#select_typeItem_request").change(function () {
  show_detail_item_request();
});

$("#input_search_request").on("keyup", function (e) {
  show_detail_item_request();
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

function onconfirm_send_request() {


  $.ajax({
    url: "process/request_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_send_request",
      txt_docno_request: $("#input_docnoRQ").val()
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

            var color = "";
            var input_cnt = "";
            if(value.cnt < value.stock_min){
                 color = "style='color:red;' ";
                 input_cnt = `<input tyle='text' class='text-center form-control numonly loop_qty_request' data-itemcode="${value.itemcode }" >`;
            }
          _tr += `<tr>
                      <td class='text-center'>${value.itemcode}</td>
                      <td class='text-left'>${value.Item_name}</td>
                      <td class='text-center'>${value.stock_min}</td>
                      <td class='text-center' ${color}>${value.cnt}</td>
                      <td class='text-center'>${input_cnt}</td>
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
            settext("dataTables_Showing") +" _START_ " +settext("dataTables_to") +" _END_ " +settext("dataTables_of") +" _TOTAL_ " +settext("dataTables_entries") +" ",
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
            width: "10%",
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
          }
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


  $("#radio_request").css("color", "#bbbbb");
  $("#radio_request").css("background", "#EAE1F4");

  $("#row_receive").hide();
  $("#row_history").hide();


  $("#radio_request").click(function () {
    $("#radio_request").css("color", "#bbbbb");
    $("#radio_request").css("background", "#EAE1F4");

    $("#radio_receive").css("color", "black");
    $("#radio_receive").css("background", "");
    $("#radio_history").css("color", "black");
    $("#radio_history").css("background", "");

    $("#row_request").show();
    $("#row_receive").hide();
    $("#row_history").hide();
  });

  $("#radio_receive").click(function () {
    $("#radio_receive").css("color", "#bbbbb");
    $("#radio_receive").css("background", "#EAE1F4");

    $("#radio_request").css("color", "black");
    $("#radio_request").css("background", "");
    $("#radio_history").css("color", "black");
    $("#radio_history").css("background", "");

    $("#row_request").hide();
    $("#row_receive").show();
    $("#row_history").hide();
  });

  $("#radio_history").click(function () {
    $("#radio_history").css("color", "#bbbbb");
    $("#radio_history").css("background", "#EAE1F4");

    $("#radio_request").css("color", "black");
    $("#radio_request").css("background", "");
    $("#radio_receive").css("color", "black");
    $("#radio_receive").css("background", "");

    $("#row_request").hide();
    $("#row_receive").hide();
    $("#row_history").show();
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
      $("#select_typeItem_request").select2();

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

      $("#input_Deproom_Main").val(Permission_name);
      $("#input_Name_Main").val(UserName);
    },
  });
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
