$(function () {
  session();

  $("#radio_oc").css("color", "#bbbbb");
  $("#radio_oc").css("background", "#EAE1F4");

  $("#row_tracking").hide();

  select_type();
  show_detail_oc();

  $("#radio_oc").click(function () {
    $("#radio_oc").css("color", "#bbbbb");
    $("#radio_oc").css("background", "#EAE1F4");

    $("#radio_tracking").css("color", "black");
    $("#radio_tracking").css("background", "");

    $("#row_oc").show();
    $("#row_tracking").hide();

    show_detail_oc();
  });

  $("#radio_tracking").click(function () {
    $("#radio_tracking").css("color", "#bbbbb");
    $("#radio_tracking").css("background", "#EAE1F4");

    $("#radio_oc").css("color", "black");
    $("#radio_oc").css("background", "");

    $("#row_oc").hide();
    $("#row_tracking").show();
    $("#select_typeItem_tracking").select2();

    setTimeout(() => {
      show_detail_item();
    }, 500);
  });
});

$("#select_typeItem_tracking").change(function () {
  show_detail_item();
});

$("#input_search_tracking").on("keyup", function (e) {
  show_detail_item();
});

function show_detail_item() {
  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_request",
      input_search_request: $("#input_search_tracking").val(),
      select_typeItem: $("#select_typeItem_tracking").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_tracking").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr id="tr_${value.itemcode}" class="clear_bg">
                      <td class='text-center'>${value.TyeName}</td>
                      <td class='text-left'>${value.Item_name}</td>
                      <td class='text-center'><label style='color:blue;font-weight:bold;cursor:pointer;' onclick="set_detail_lot('${value.itemcode}')">เลือก</label></td>
                   </tr>`;
        });
      }

      $("#table_item_tracking tbody").html(_tr);
      $("#table_item_tracking").DataTable({
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
            width: "40%",
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
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

$("#input_search_lot_tracking").on("keyup", function () {
  var value = $(this).val().toLowerCase();
  $("#table_lot_tracking tbody tr").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});

function show_detail_lot(itemcode) {
  $.ajax({
    url: "process/oc.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_lot",
      itemcode: itemcode,
    },
    success: function (result) {
      var _tr = "";
      $("#table_lot_tracking").DataTable().destroy();

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var txt = value.lotNo;
          if (value.lotNo == "") {
            txt = "อุปกรณ์ที่ไม่มีเลข Lot.";
          }

          if (value.IsTracking == "0") {
            var hidden = "gold";
          }else{
            var hidden = "red";

          }

          
          _tr += `<tr id="trtracking_${value.lotNo}" class="clear_bg">
                      <td class='text-center'>${txt}</td>
                      <td class='text-center'>${value.cnt}</td>
                      <td class='text-center'><label style='color:blue;font-weight:bold;cursor:pointer;' onclick="set_detail_lot_itemstock('${value.lotNo}','${value.ItemCode}')">เลือก</label></td>
                      <td class='text-center'><i  class="fa-solid fa-circle-exclamation" style="font-size: 30px;color: ${hidden};cursor:pointer;" onclick="set_tracking('${value.lotNo}','${value.ItemCode}','${hidden}')"></i></td>
                   </tr>`;
        });
      }

      $("#table_lot_tracking tbody").html(_tr);
      $("#table_lot_tracking").DataTable({
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
            width: "40%",
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
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

function set_tracking(lotNo, itemcode, txt_check) {
  if (txt_check == "gold") {
    Swal.fire({
      title: "ยืนยัน",
      text: "ยืนยัน การติดตามอุปกรณ์",
      icon: "warning",
      input: "text", // เพิ่ม input
      inputPlaceholder: "กรอกหมายเหตุ",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        let userInput = result.value; // ค่าที่ผู้ใช้กรอกมา

        $.ajax({
          url: "process/oc.php",
          type: "POST",
          data: {
            FUNC_NAME: "set_tracking",
            lotNo: lotNo,
            itemcode: itemcode,
            remark: userInput, // ส่งค่าที่กรอกไปด้วย
            txt_check: txt_check, // ส่งค่าที่กรอกไปด้วย
          },
          success: function (result) {
            showDialogSuccess("บันทึกสำเร็จ");
            show_detail_lot(itemcode);
          },
        });
      }
    });
  }else{
      Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การยกเลิกติดตามอุปกรณ์",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      let userInput = result.value; // ค่าที่ผู้ใช้กรอกมา

      $.ajax({
        url: "process/oc.php",
        type: "POST",
        data: {
          FUNC_NAME: "set_tracking",
          lotNo: lotNo,
          itemcode: itemcode,
          remark: '', // ส่งค่าที่กรอกไปด้วยม,
          txt_check: txt_check
        },
        success: function (result) {
          showDialogSuccess("บันทึกสำเร็จ");
          show_detail_lot(itemcode);
        },
      });
    }
  });
  }




  // Swal.fire({
  //   title: "ยืนยัน",
  //   text: "ยืนยัน การติดตามอุปกรณ์",
  //   icon: "warning",
  //   showCancelButton: true,
  //   confirmButtonColor: "#3085d6",
  //   cancelButtonColor: "#d33",
  //   confirmButtonText: "ยืนยัน",
  //   cancelButtonText: "ยกเลิก",
  // }).then((result) => {
  //   if (result.isConfirmed) {

  //     $.ajax({
  //       url: "process/oc.php",
  //       type: "POST",
  //       data: {
  //         FUNC_NAME: "set_tracking",
  //         lotNo: lotNo,
  //         itemcode: itemcode,
  //       },
  //       success: function (result) {
  //         showDialogSuccess("บันทึกสำเร็จ");
  //       },
  //     });

  //   }
  // });
}

function set_detail_lot_itemstock(lotNo, ItemCode) {
  $(".clear_bg").css("background-color", "");
  $("#trtracking_" + lotNo).css("background-color", "rgb(239, 248, 255)");

  $("#input_lot_itemcode_detail").val(ItemCode);
  $("#input_lot_detail").val(lotNo);

  setTimeout(() => {
    show_detail_itemstock();
  }, 500);
}

$("#input_search_lot_detail").on("keyup", function (event) {
  if (event.key === "Enter") {
    show_detail_itemstock();
  }
});

// $("#input_search_lot_detail").on("keyup", function () {
//   show_detail_itemstock();
// });

function show_detail_itemstock() {
  $.ajax({
    url: "process/oc.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_itemstock",
      lotNo: $("#input_lot_detail").val(),
      itemcode: $("#input_lot_itemcode_detail").val(),
      input_search_lot_detail: $("#input_search_lot_detail").val().trim(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_lot_detail").DataTable().destroy();
      $("#table_lot_detail tbody").html("");
      var matched_tr = ""; // สำหรับเก็บแถวที่ตรงกับ input

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var txt = "";
          var status = "";

          if (value.hn_record_id != null) {
            txt = value.hn_record_id;
          }
          if (value.IsDeproom == "1") {
            status =
              "<label style='color:green;font-weight:bold;'>ถูกใช้งาน</label>";
          }
          if (value.IsDeproom == "0") {
            status =
              "<labe style='color:violet;font-weight:bold;'>อยู่คลัง Stock</label>";
          }
          if (value.check_exp == "exp") {
            status =
              "<labe style='color:red;font-weight:bold;'>หมดอายุ</label>";
          }

          var color = "";
          if ($("#input_search_lot_detail").val().trim() == value.UsageCode) {
            color = `style='background-color:#e74a3b;'`;
          }

          var row_html = `<tr ${color}>
                      <td class='text-center'>${value.itemname}</td>
                      <td class='text-center'>${value.serielNo}</td>
                      <td class='text-center'>${value.lotNo}</td>
                      <td class='text-center'>${value.UsageCode}</td>
                      <td class='text-center'>${txt}</td>
                      <td class='text-center'>${status}</td>
                   </tr>`;

          if ($("#input_search_lot_detail").val().trim() == value.UsageCode) {
            matched_tr = row_html; // ใส่ไว้ก่อน
          } else {
            _tr += row_html;
          }
        });
      }

      $("#table_lot_detail tbody").html(matched_tr + _tr);
      // $("#table_lot_detail").DataTable({
      //   language: {
      //     emptyTable: settext("dataTables_empty"),
      //     paginate: {
      //       next: settext("table_itemStock_next"),
      //       previous: settext("table_itemStock_previous"),
      //     },
      //     search: settext("btn_Search"),
      //     info:
      //       settext("dataTables_Showing") +
      //       " _START_ " +
      //       settext("dataTables_to") +
      //       " _END_ " +
      //       settext("dataTables_of") +
      //       " _TOTAL_ " +
      //       settext("dataTables_entries") +
      //       " ",
      //   },
      //   columnDefs: [
      //     {
      //       width: "20%",
      //       targets: 0,
      //     },
      //     {
      //       width: "10%",
      //       targets: 1,
      //     },
      //     {
      //       width: "10%",
      //       targets: 2,
      //     },
      //     {
      //       width: "10%",
      //       targets: 3,
      //     },
      //     {
      //       width: "10%",
      //       targets: 4,
      //     },
      //     {
      //       width: "10%",
      //       targets: 5,
      //     },
      //   ],
      //   info: false,
      //   scrollX: false,
      //   scrollCollapse: false,
      //   visible: false,
      //   searching: false,
      //   lengthChange: false,
      //   fixedHeader: false,
      //   ordering: false,
      // });
      // $("th").removeClass("sorting_asc");
      // if (_tr == "") {
      //   $(".dataTables_info").text(
      //     settext("dataTables_Showing") +
      //       " 0 " +
      //       settext("dataTables_to") +
      //       " 0 " +
      //       settext("dataTables_of") +
      //       " 0 " +
      //       settext("dataTables_entries") +
      //       ""
      //   );
      // }

      $("#input_search_lot_detail").val("");
      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

function set_detail_lot(itemcode) {
  $(".clear_bg").css("background-color", "");
  $("#tr_" + itemcode).css("background-color", "rgb(239, 248, 255)");

  show_detail_lot(itemcode);
}

$("#select_typeItem").change(function () {
  show_detail_oc();
});

$("#input_search_request").on("keyup", function (e) {
  show_detail_oc();
});

function show_detail_oc() {
  $.ajax({
    url: "process/oc.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_oc",
      input_search_request: $("#input_search_request").val(),
      select_typeItem: $("#select_typeItem").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_oc").DataTable().destroy();

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var txt = "";
          var status = "";
          if (value.IsDeproom == "1") {
            txt = value.hn_record_id;
            status =
              "<label style='color:green;font-weight:bold;'>ถูกใช้งาน</label>";
          }
          if (value.IsDeproom == "0") {
            status =
              "<labe style='color:violet;font-weight:bold;'>อยู่คลัง Stock</label>";
          }
          if (value.check_exp == "exp") {
            status =
              "<labe style='color:red;font-weight:bold;'>หมดอายุ</label>";
          }
          _tr += `<tr >
                      <td class='text-left'>${value.itemname}</td>
                      <td class='text-center'>${value.serielNo}</td>
                      <td class='text-center'>${value.lotNo}</td>
                      <td class='text-center'>${value.UsageCode}</td>
                      <td class='text-center'>${txt}</td>
                      <td class='text-center'>${status}</td>
                      <td class='text-center'>${value.remarkTracking}</td>
                   </tr>`;
        });
      }

      $("#table_oc tbody").html(_tr);
      $("#table_oc").DataTable({
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
            width: "10%",
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
          {
            width: "10%",
            targets: 5,
          },
          {
            width: "10%",
            targets: 5,
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
      $("#select_typeItem").html(option);
      $("#select_typeItem").select2();

      $("#select_typeItem_tracking").html(option);
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

function showDialogSuccess(text) {
  Swal.fire({
    title: settext("alert_success"),
    text: text,
    icon: "success",
    timer: 1000,
  });
}
