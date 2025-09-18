var departmentroomname = "";
var UserName = "";
var Userid = "";
var item_Array = [];
$(function () {
  $("#excelFile").on("change", function () {
    var fileName = this.files[0]?.name || "";
    $("#filename").val(fileName);
  });

  session();
  select_item();
  $("#select_date1").val(set_date());
  $("#select_date1").datepicker({
    onSelect: function (date) {
      selection_item();
    },
  });

  $("#select_date1_rfid").val(set_date());
  $("#select_date1_rfid").datepicker({
    onSelect: function (date) {
      selection_item_rfid();
    },
  });

  $("#select_date1_normal").val(set_date());
  $("#select_date1_normal").datepicker({
    onSelect: function (date) {
      selection_item_normal();
    },
  });
  // $("#select_date2").val(set_date());
  // $("#select_date2").datepicker({
  //   onSelect: function (date) {
  //     selection_item();
  //   },
  // });
  $("#input_search").keyup(function () {
    selection_item();
  });

  $("#input_search_rfid").keyup(function () {
    selection_item_rfid();
  });

  $("#input_search_normal").keyup(function () {
    selection_item_normal();
  });

  $("#suds").hide();
  $("#sterile").hide();
  $("#normal").hide();
  $("#restock").hide();
  $("#follow").hide();

  // $("#radio_suds").css("color", "#bbbbb");
  // $("#radio_suds").css("background", "#EAE1F4");

  // selection_itemSuds();

  selection_departmentRoom_rfid();

  setTimeout(() => {
    selection_item_rfid();
  }, 1000);

  $("#radio_suds").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#restock").hide();
    $("#sterile1").show();
    $("#sterile").hide();
    $("#normal").hide();
    $("#follow").hide();
  });

  $("#radio_sterile").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#restock").hide();
    $("#sterile1").hide();
    $("#sterile").show();
    $("#normal").hide();
    $("#follow").hide();

    selection_departmentRoom();

    setTimeout(() => {
      selection_item();
    }, 1000);
  });

  $("#input_search_suds").keyup(function () {
    selection_itemSuds();
  });

  $("#radio_normal").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#restock").hide();
    $("#sterile1").hide();
    $("#sterile").hide();
    $("#normal").show();
    $("#follow").hide();

    selection_departmentRoom_normal();

    setTimeout(() => {
      selection_item_normal();
    }, 1000);
  });

  $("#radio_restock").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#restock").show();
    $("#sterile1").hide();
    $("#sterile").hide();
    $("#normal").hide();
    $("#follow").hide();

    $("#table_item_restock tbody").html("");

    // selection_departmentRoom_normal();

    // setTimeout(() => {
    //   selection_item_normal();
    // }, 1000);
  });

  $("#radio_follow").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#follow").show();
    $("#restock").hide();
    $("#sterile1").hide();
    $("#sterile").hide();
    $("#normal").hide();



    var d = new Date();
    var month = d.getMonth() + 1;
    var output = (("" + month).length < 2 ? "0" : "") + month;

    $("#select_follow_month").val(output);


    setTimeout(() => {
      selection_follow_item();
    }, 500);


    setTimeout(() => {
      selection_follow_item_detail();
    }, 1000);

    // selection_departmentRoom_normal();

    // setTimeout(() => {
    //   selection_item_normal();
    // }, 1000);
  });
});


$("#select_follow_month").change(function () {
  selection_follow_item();

  setTimeout(() => {
    selection_follow_item_detail();
  }, 1000);
});

$("#select_follow_year").change(function () {
  selection_follow_item();

  setTimeout(() => {
    selection_follow_item_detail();
  }, 1000);
});

function selection_follow_item() {

  var num = 0;
  var select_follow_month = $("#select_follow_month").val();
  if (select_follow_month == '04' || select_follow_month == '06' || select_follow_month == '09' || select_follow_month == '11') {
    num = 30;
  } else if (select_follow_month == '02') {
    num = 28;
  } else {
    num = 31;
  }



  var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;">ลำดับ</th>`;
  tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;">อุปกรณ์</th>`;

  for (let index = 0; index < num; index++) {
    tr += `<th class='text-center' style="text-wrap: nowrap;">${index + 1}</th>`;
  }

  $("#tr_followHard_item").html(tr);



}

function selection_follow_item_detail() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_follow_item_detail",
      select_follow_month: $("#select_follow_month").val(),
      select_follow_year: $("#select_follow_year").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_follow_item tbody").html("");
      $("#table_follow_item").DataTable().destroy();
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          tr += `<tr>
                    <td class='text-center' style="text-wrap: nowrap;">${kay + 1}</td>
                    <td style="text-wrap: nowrap;">${value.itemname}</td>`;

          $.each(ObjData[value.itemcode], function (kay2, value2) {
            tr += `<td style="text-wrap: nowrap;">${value2.calculated_balance}</td>`;
          });
          tr += `</tr>`;

        });
      } else {
      }

      $("#table_follow_item tbody").html(tr);
      // ถ้าถูก init มาก่อนแล้ว ให้ destroy ก่อน
      // if ($.fn.DataTable.isDataTable("#table_follow_item")) {
      //   $("#table_follow_item").DataTable().destroy();
      // }

      // const tbl = $("#table_follow_item").DataTable({
      //   language: {
      //     emptyTable: settext("dataTables_empty"),
      //     paginate: {
      //       next: settext("table_itemStock_next"),
      //       previous: settext("table_itemStock_previous"),
      //     },
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

      //   autoWidth: false, // ให้เราคุม width เอง
      //   scrollX: true,
      //   scrollCollapse: true,
      //   scrollY: "800px",
      //   fixedColumns: { leftColumns: 2, rightColumns: 0 },
      //   fixedHeader: true,

      //   paging: true,
      //   pageLength: 15,
      //   searching: false,
      //   lengthChange: false,
      //   ordering: false,
      //   info: true,

      //   columnDefs: [
      //     { targets: 0, width: "50px" },
      //     { targets: 1, width: "250px" },

      //   ],
      //   initComplete: function () {
      //     const api = this.api();
      //     api.columns.adjust();
      //     if (api.fixedColumns && api.fixedColumns().relayout)
      //       api.fixedColumns().relayout();
      //   },
      //   drawCallback: function () {
      //     const api = this.api();
      //     api.columns.adjust();
      //     if (api.fixedColumns && api.fixedColumns().relayout)
      //       api.fixedColumns().relayout();
      //   },
      // });

      // // ถ้าตารางเพิ่งถูกโชว์ (เช่น อยู่ในแท็บ) ให้ sync อีกรอบ
      // setTimeout(() => {
      //   tbl.columns.adjust().draw(false);
      //   if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
      //     tbl.fixedColumns().relayout();
      //   }
      // }, 0);

      // // ช่วยเวลา resize
      // $(window).on("resize", () => {
      //   tbl.columns.adjust();
      //   if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
      //     tbl.fixedColumns().relayout();
      //   }
      // });

      // $("th").removeClass("sorting_asc");
      // if (tr == "") {
      //   $(".dataTables_info").text(
      //     settext("dataTables_Showing") +
      //     " 0 " +
      //     settext("dataTables_to") +
      //     " 0 " +
      //     settext("dataTables_of") +
      //     " 0 " +
      //     settext("dataTables_entries") +
      //     ""
      //   );
      // }
    },
  });
}

$("#btn_add_follow_item").click(function () {
  $("#myModal_follow_item").modal("toggle");

  setTimeout(() => {
    $("#select_map_item_sub").select2({
      dropdownParent: $("#myModal_follow_item"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });
  }, 1000);

  select_set_item_daily();
});

$("#select_map_item_sub").on("select2:select", function (e) {
  var selectedValue = e.params.data.id; // ดึงค่า value
  var selectedText = e.params.data.text; // ดึงค่า text
  if (
    selectedValue != "" &&
    selectedValue != $("#select_map_item_main").val()
  ) {
    var index = item_Array.indexOf(selectedValue);
    if (index == -1) {
      item_Array.push(selectedValue);
      var _row = "";
      _row += `       <div  class='div_${selectedValue} pl-3 clear_item_map' onclick='DeleteItemmap("${selectedValue}")'>
                            <label for="" class="custom-label" style='width: 100%;'>${selectedText}</label>
                        </div> `;

      $("#row_item_map").append(_row);
      $("#select_map_item_sub").val("").trigger("change");


      $.ajax({
        url: "process/movement.php",
        type: "POST",
        data: {
          FUNC_NAME: "save_item_daily",
          itemCode: selectedValue,
        },
        success: function (result) {
          selection_follow_item();

          setTimeout(() => {
            selection_follow_item_detail();
          }, 1000);
        },
      });


    } else {
      $("#select_map_item_sub").val("").trigger("change");
    }
  } else {
    $("#select_map_item_sub").val("").trigger("change");
  }

  if (item_Array.length > 0) {
    $("#select_set_mapping_item").attr("disabled", false);
  } else {
    $("#select_set_mapping_item").attr("disabled", true);
  }
});

function select_set_item_daily() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_set_item_daily",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);

      $("#row_item_map").html("");
      item_Array = [];

      if (!$.isEmptyObject(ObjData)) {
        var _row = "";
        $.each(ObjData, function (kay, value) {
          item_Array.push(value.itemCode.toString());

          _row += `       <div  class='div_${value.itemCode} pl-3 clear_deproom' onclick='DeleteItemmap("${value.itemCode}")'>
                                    <label for="" class="custom-label" style='width: 100%;'>${value.itemname}</label>
                                </div> `;
        });

        $("#row_item_map").append(_row);
      } else {
      }
    },
  });
}

function DeleteItemmap(selectedValue) {
  var index = item_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    item_Array.splice(index, 1);

    $.ajax({
      url: "process/movement.php",
      type: "POST",
      data: {
        FUNC_NAME: "delete_item_daily",
        itemCode: selectedValue,
      },
      success: function (result) {

        selection_follow_item();

        setTimeout(() => {
          selection_follow_item_detail();
        }, 1000);


      },
    });
  }

  console.log(item_Array);
  $(".div_" + selectedValue).attr("hidden", true);

}

function convertString(S_Input) {
  var S_QR = "";
  console.log(S_Input.charCodeAt(0));
  if (S_Input.length > 0) {
    if (S_Input.charCodeAt(0) > 1000 || S_Input.charCodeAt(0) == 63) {
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


$("#btn_pdf_follow_item").click(function () {
  option = "?select_follow_month=" + $("#select_follow_month").val() + "&select_follow_year=" + $("#select_follow_year").val();
  window.open("report/Report_follow_item.php" + option + "&Userid=" + Userid, "_blank");
});
$("#btn_excel_follow_item").click(function () {
  option = "?select_follow_month=" + $("#select_follow_month").val() + "&select_follow_year=" + $("#select_follow_year").val();
  window.open("report/phpexcel/Report_follow_item.php" + option + "&Userid=" + Userid, "_blank");
});

$("#input_scan_restock").keypress(function (e) {
  if (e.which == 13) {
    $("#input_scan_restock").val(convertString($(this).val().trim()));

    let usageCode = $(this).val().trim();
    let convertedCode = convertString(usageCode);
    $("#input_scan_restock").val(convertedCode);

    // ตรวจสอบก่อนว่า UsageCode นี้มีในตารางแล้วหรือไม่
    let isDuplicate = false;
    $("#table_item_restock tbody tr").each(function () {
      let codeInRow = $(this).find("td:eq(2)").text().trim(); // คอลัมน์ที่ 3 (index 2) คือ UsageCode
      if (codeInRow === usageCode) {
        isDuplicate = true;
        return false; // ออกจาก each loop
      }
    });

    if (isDuplicate) {
      // ถ้าซ้ำ: ไม่ต้องส่ง Ajax หรือเพิ่มแถว
      $("#input_scan_restock").val("");
      return;
    }

    $.ajax({
      url: "process/movement.php",
      type: "POST",
      data: {
        FUNC_NAME: "show_restock",
        UsageCode: $(this).val(),
      },
      success: function (result) {
        var ObjData = JSON.parse(result);
        var tr = ``;
        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
            tr += `<tr>
                                <td class='text-center'>${value.itemcode2}</td>
                                <td class='text-left'>${value.itemname}</td>
                                <td class='text-center'>${value.UsageCode}</td>
                                <td class='text-center'>อยู่คลัง</td>`;
            tr += `</tr>`;
          });
        } else {
        }
        $("#table_item_restock tbody").append(tr);
        $("#input_scan_restock").val("");
      },
    });
  }
});

function selection_itemSuds() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_itemSuds",
      input_search_suds: $("#input_search_suds").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $("#table_item_suds1 tbody").html("");
      $("#table_item_suds1").DataTable().destroy();

      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          tr += `<tr>
                                <td class='text-center'>${value.itemcode}</td>
                                <td style="text-wrap: nowrap;">${value.itemname}</td>
                                <td class='text-center' style="text-wrap: nowrap;">${value.Qty}</td>
                                <td class='text-center' style="text-wrap: nowrap;"> <span style='color:#004aad;cursor:pointer;'onclick='showDetail_itemSuds("${value.itemcode}","${value.itemname}")'>เลือก</span></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds1 tbody").html(tr);
      $("#table_item_suds1").DataTable({
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
          {
            width: "20%",
            targets: 3,
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

function showDetail_itemSuds(itemcode, itemname) {
  $("#itemCodeSUDs").text(itemcode);
  $("#itemNameSUDs").text(itemname);

  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_itemSuds",
      itemcode: itemcode,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $("#table_item_suds2 tbody").html("");
      $("#table_item_suds2").DataTable().destroy();
      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.rack == null) {
            value.rack = "";
          }
          if (value.row == null) {
            value.row = "";
          }
          if (value.IsCancel == "0") {
            value.IsCancel = "อยู่ในคลัง";
          } else if (value.IsCancel == "1") {
            value.IsCancel = "In Active";
          }

          var btn = "btn btn-primary";

          if (value.location == null) {
            value.location = "";
          }
          if (value.IsDeproom == "7") {
            value.departmentroomname = "Create Request";
            var btn = "btn btn-warning";
          }
          if (value.IsDamage == "1" || value.IsDamage == "2") {
            value.departmentroomname = "ชำรุด";
            var btn = "btn btn-danger";
          }

          tr += `<tr>
                                <td class='text-center'>${value.UsageCode}</td>
                                <td class='text-center'> <button class="${btn}">${value.departmentroomname}</button></td>
                                <td class='text-center'>${value.location}</td>
                                <td class='text-center'>${value.row}</td>
                                <td class='text-center'>${value.rack}</td>
                                <td class='text-center'> <span style='color:#004aad;cursor:pointer;'onclick='showDetailSub_itemSuds("${value.itemname}","${value.UsageCode}")'>ดูประวัติการใช้งาน</span></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds2 tbody").html(tr);
      $("#table_item_suds2").DataTable({
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
          {
            width: "10%",
            targets: 3,
          },
          {
            width: "10%",
            targets: 4,
          },
          {
            width: "15%",
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
    },
  });
}

function showDetailSub_itemSuds(itemname, UsageCode) {
  $("#item_name").text(itemname);
  $("#item_suds").text(UsageCode);

  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetailSub_itemSuds",
      UsageCode: UsageCode,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_item_suds3 tbody").html("");
      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.SterileDate == null) {
            value.SterileDate = "";
          }
          if (value.ExpDate == null) {
            value.ExpDate = "";
          }

          tr += `<tr>
                                <td class='text-center'>${value.UniCode}</td>
                                <td class='text-center'>${value.UsedCount}</td>
                                <td class='text-center'>${value.HnCode}</td>
                                <td class='text-center'>${value.SterileDate}</td>
                                <td class='text-center'>${value.ExpDate}</td>
                                <td class='text-center'></td>
                                <td class='text-center'></td>
                                <td class='text-center'>${value.FirstName}</td>
                                <td class='text-center'></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds3 tbody").html(tr);
    },
  });
}

function selection_departmentRoom() {
  depRoom = [];
  depID = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">อุปกรณ์</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">สต๊อกตั้งต้น</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัดรวม</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#F5DCE0;border-bottom-color: #d5a5a7;" class='text-center' rowspan="2" id="">จ่ายวันนี้</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#91a7ff;border-bottom-color: #5677fc;" class='text-center' rowspan="2" id="">Max</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">สต๊อกคงเหลือ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#4fc3f7;border-bottom-color: #03a9f4;" class='text-center' rowspan="2" id="">Min</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep").html(tr2);
      } else {
      }

      // tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      var coldp = 0;
      $.each(ObjData["depname"], function (kay3, value3) {
        coldp++;
        tr2 += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center' >${value3.DepName}</th>`;
        depID.push(value3.ID);
      });

      tr += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center'  colspan="${coldp}">แผนก</th>`;

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      $("#tr_TableDephead").html(tr);

      $("#tr_TableDep").html(tr2);
    },
  });
}

function selection_item() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item",
      select_date1: $("#select_date1").val(),
      // select_date2: $("#select_date2").val(),
      input_search: $("#input_search").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_DepRoom_movement").DataTable().destroy();
      $("#table_DepRoom_movement tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          // var balance =
          //   parseInt(value.Qty) -
          //   (parseInt(value.cnt_pay) + parseInt(value.cnt_cssd));

          if (value.stock_max == null) {
            value.stock_max = 0;
          }
          if (value.stock_min == null) {
            value.stock_min = 0;
          }
          var color = "";
          if (value.calculated_balance < value.stock_min) {
            color = "color:red;";
          }
          if (value.cnt < value.stock_balance) {
            value.cnt = value.stock_balance;
          }

          tr += `<tr>
                                  <td class='text-center' style="text-wrap: nowrap;">${kay + 1
            }</td>
                                  <td style="text-wrap: nowrap;${color}">${value.itemname
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${value.cnt
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${value.cnt_pay
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#eedadb;">${value.cnt_pay_today
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #d0d9ff;"">${value.stock_max
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#ECFDF3;">${value.calculated_balance
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #b3e5fc;"">${value.stock_min
            }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          // tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          $.each(depID, function (keydepID, valuedepID) {
            // console.log(valuedepID);

            var checkcountDepID = 0;
            $.each(ObjData["detailDepID"], function (kay3, value3) {
              if (value3.ItemCode == value.itemcode) {
                if (valuedepID == value3.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value3.Qty}</</td>`;
                  sumcount += parseInt(value3.Qty);
                  checkcountDepID = 1;
                }
              }
            });
            if (checkcountDepID == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom_movement tbody").html(tr);
      // ถ้าถูก init มาก่อนแล้ว ให้ destroy ก่อน
      if ($.fn.DataTable.isDataTable("#table_DepRoom_movement")) {
        $("#table_DepRoom_movement").DataTable().destroy();
      }

      const tbl = $("#table_DepRoom_movement").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
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

        autoWidth: false, // ให้เราคุม width เอง
        scrollX: true,
        scrollCollapse: true,
        scrollY: "800px",
        fixedColumns: { leftColumns: 8, rightColumns: 0 },
        fixedHeader: true,

        paging: true,
        pageLength: 15,
        searching: false,
        lengthChange: false,
        ordering: false,
        info: true,

        columnDefs: [
          { targets: 0, width: "50px" },
          { targets: 1, width: "250px" },
          { targets: 2, width: "100px" },
          { targets: 3, width: "120px" },
          { targets: 4, width: "110px" },
          { targets: 5, width: "110px" },
          { targets: 6, width: "80px" }, // Max
          { targets: 7, width: "80px" }, // Min  ⇒ เท่ากับคอลัมน์ 5
        ],
        initComplete: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
        drawCallback: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
      });

      // ถ้าตารางเพิ่งถูกโชว์ (เช่น อยู่ในแท็บ) ให้ sync อีกรอบ
      setTimeout(() => {
        tbl.columns.adjust().draw(false);
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      }, 0);

      // ช่วยเวลา resize
      $(window).on("resize", () => {
        tbl.columns.adjust();
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      });
      $("th").removeClass("sorting_asc");
      if (tr == "") {
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

function session() {
  $.ajax({
    url: "process/session.php",
    type: "POST",
    success: function (result) {
      var ObjData = JSON.parse(result);
      departmentroomname = ObjData.departmentroomname;
      UserName = ObjData.UserName;
      Permission_name = ObjData.Permission_name;
      Userid = ObjData.Userid;
    },
  });
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

function showLoading() {
  $("body").loadingModal({
    position: "auto",
    text: "กำลังโหลด...",
    color: "#fff",
    opacity: "0.7",
    backgroundColor: "rgb(0,0,0)",
    animation: "threeBounce",
  });
}

$(".btn_upload_stock").click(function () {
  $("#modal_upload_stock").modal("toggle");
});

$("#save_upload_stock").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การอัพโหลด ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      var fileInput = $("#excelFile")[0];
      var file = fileInput.files[0];

      if (!file) {
        Swal.fire("ผิดพลาด", "กรุณาเลือกไฟล์ก่อน", "error");
        return;
      }
      showLoading();

      var formData = new FormData();
      formData.append("excelFile", file);

      $.ajax({
        url: "process/upload_excel.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          // Swal.fire("สำเร็จ", "อัปโหลดเรียบร้อย", "success");

          setTimeout(() => {
            window.location.reload();
            // $("body").loadingModal("destroy");
          }, 500);
          // หรือแสดงข้อความใน element แทน
          // $('#message').html(response);
        },
        error: function () {
          Swal.fire("ล้มเหลว", "เกิดข้อผิดพลาดระหว่างอัปโหลด", "error");
        },
      });
    }
  });
});

$(".btn_manage_stock").click(function () {
  $("#modal_manage_stockRFID").modal("toggle");
  $("#max_manage_stockRFID").val("");
  $("#min_manage_stockRFID").val("");
  $("#item_manage_stockRFID").val("");
  setTimeout(() => {
    $("#item_manage_stockRFID").select2({
      dropdownParent: $("#modal_manage_stockRFID"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });
  }, 500);
});

$("#save_manage_stockRFID").click(function () {
  if ($("#item_manage_stockRFID").val() == "") {
    Swal.fire("ล้มเหลว", "กรุณาเลือกอุปกรณ์", "error");
    return;
  }

  if (
    $("#max_manage_stockRFID").val() == "" ||
    $("#min_manage_stockRFID").val() == ""
  ) {
    Swal.fire("ล้มเหลว", "กรุณากรอก Max & Min", "error");
    return;
  }
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การบันทึก ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/movement.php",
        type: "POST",
        data: {
          FUNC_NAME: "onSavemanage_stockRFID",
          item_manage_stockRFID: $("#item_manage_stockRFID").val(),
          max_manage_stockRFID: $("#max_manage_stockRFID").val(),
          min_manage_stockRFID: $("#min_manage_stockRFID").val(),
        },
        success: function (result) {
          // selection_item_rfid();

          window.location.reload();

          // $("#modal_manage_stockRFID").modal("toggle");
        },
      });
    }
  });
});

function select_item() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_item",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกอุปกรณ์</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.itemcode}" >${value.itemname}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#item_manage_stockRFID").html(option);
      $("#select_map_item_sub").html(option);
    },
  });
}

function selection_departmentRoom_rfid() {
  depRoom = [];
  depID = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom_rfid",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">อุปกรณ์</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">สต๊อกตั้งต้น</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัดรวม</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#F5DCE0;border-bottom-color: #d5a5a7;" class='text-center' rowspan="2" id="">จ่ายวันนี้</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#91a7ff;border-bottom-color: #5677fc;" class='text-center' rowspan="2" id="">Max</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">สต๊อกคงเหลือ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#4fc3f7;border-bottom-color: #03a9f4;" class='text-center' rowspan="2" id="">Min</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep_rfid").html(tr2);
      } else {
      }

      // tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      var coldp = 0;
      $.each(ObjData["depname"], function (kay3, value3) {
        coldp++;
        tr2 += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center'  >${value3.DepName}</th>`;
        depID.push(value3.ID);
      });

      tr += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center'  colspan="${coldp}" >แผนก</th>`;

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      $("#tr_TableDephead_rfid").html(tr);

      $("#tr_TableDep_rfid").html(tr2);
    },
  });
}

function selection_item_rfid() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item_rfid",
      select_date1: $("#select_date1_rfid").val(),
      input_search: $("#input_search_rfid").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_DepRoom_rfid_movement").DataTable().destroy();
      $("#table_DepRoom_rfid_movement tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          // var balance = parseInt(value.cnt) - parseInt(value.cnt_pay);

          if (value.stock_max == null) {
            value.stock_max = 0;
          }

          if (value.stock_min == null) {
            value.stock_min = 0;
          }
          var color = "";
          if (value.calculated_balance < value.stock_min) {
            color = "color:red;";
          }

          if (value.cnt < value.stock_balance) {
            value.cnt = value.stock_balance;
          }
          tr += `<tr>
                                  <td class='text-center' style="text-wrap: nowrap;">${kay + 1
            }</td>
                                  <td style="text-wrap: nowrap;${color}">${value.itemname
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${value.cnt
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${value.cnt_pay
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#eedadb;">${value.cnt_pay_today
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #d0d9ff;"">${value.stock_max
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#ECFDF3;">${value.calculated_balance
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #b3e5fc;"">${value.stock_min
            }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          // tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          // var sumcount2 = 0;
          $.each(depID, function (keydepID, valuedepID) {
            // console.log(valuedepID);

            var checkcountDepID = 0;
            $.each(ObjData["detailDepID"], function (kay3, value3) {
              if (value3.ItemCode == value.itemcode) {
                if (valuedepID == value3.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value3.Qty}</</td>`;
                  sumcount += parseInt(value3.Qty);
                  checkcountDepID = 1;
                }
              }
            });
            if (checkcountDepID == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom_rfid_movement tbody").html(tr);
      // ถ้าถูก init มาก่อนแล้ว ให้ destroy ก่อน
      if ($.fn.DataTable.isDataTable("#table_DepRoom_rfid_movement")) {
        $("#table_DepRoom_rfid").DataTable().destroy();
      }

      const tbl = $("#table_DepRoom_rfid_movement").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
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

        autoWidth: false, // ให้เราคุม width เอง
        scrollX: true,
        scrollCollapse: true,
        scrollY: "800px",
        fixedColumns: { leftColumns: 8, rightColumns: 0 },
        fixedHeader: true,

        paging: true,
        pageLength: 15,
        searching: false,
        lengthChange: false,
        ordering: false,
        info: true,

        columnDefs: [
          { targets: 0, width: "50px" },
          { targets: 1, width: "250px" },
          { targets: 2, width: "100px" },
          { targets: 3, width: "120px" },
          { targets: 4, width: "110px" },
          { targets: 5, width: "110px" },
          { targets: 6, width: "80px" }, // Max
          { targets: 7, width: "80px" }, // Min  ⇒ เท่ากับคอลัมน์ 5
        ],
        initComplete: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
        drawCallback: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
      });

      // ถ้าตารางเพิ่งถูกโชว์ (เช่น อยู่ในแท็บ) ให้ sync อีกรอบ
      setTimeout(() => {
        tbl.columns.adjust().draw(false);
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      }, 0);

      // ช่วยเวลา resize
      $(window).on("resize", () => {
        tbl.columns.adjust();
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      });

      $("th").removeClass("sorting_asc");
      if (tr == "") {
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

function selection_departmentRoom_normal() {
  depRoom = [];
  depID = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom_normal",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">อุปกรณ์</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">สต๊อกตั้งต้น</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัดรวม</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#F5DCE0;border-bottom-color: #d5a5a7;" class='text-center' rowspan="2" id="">จ่ายวันนี้</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#91a7ff;border-bottom-color: #5677fc;" class='text-center' rowspan="2" id="">Max</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">สต๊อกคงเหลือ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#4fc3f7;border-bottom-color: #03a9f4;" class='text-center' rowspan="2" id="">Min</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep_normal").html(tr2);
      } else {
      }

      // tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      var coldp = 0;
      $.each(ObjData["depname"], function (kay3, value3) {
        coldp++;
        tr2 += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center'  >${value3.DepName}</th>`;
        depID.push(value3.ID);
      });

      tr += `<th style="text-wrap: nowrap;background-color: darkgray;" class='text-center'  colspan="${coldp}"  >แผนก</th>`;

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;

      $("#tr_TableDephead_normal").html(tr);

      $("#tr_TableDep_normal").html(tr2);
    },
  });
}

function selection_item_normal() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item_normal",
      select_date1: $("#select_date1_normal").val(),
      input_search: $("#input_search_normal").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_DepRoom_normal_movement").DataTable().destroy();
      $("#table_DepRoom_normal_movement tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          if (value.stock_max == null) {
            value.stock_max = 0;
          }
          if (value.stock_min == null) {
            value.stock_min = 0;
          }
          var color = "";
          if (value.calculated_balance < value.stock_min) {
            color = "color:red;";
          }

          if (value.cnt < value.stock_balance) {
            value.cnt = value.stock_balance;
          }

          tr += `<tr>
                                  <td class='text-center' style="text-wrap: nowrap;">${kay + 1
            }</td>
                                  <td style="text-wrap: nowrap;${color}">${value.itemname
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${value.cnt
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${value.cnt_pay
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#eedadb;">${value.cnt_pay_today
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #d0d9ff;"">${value.stock_max
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#ECFDF3;">${value.calculated_balance
            }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #b3e5fc;"">${value.stock_min
            }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          // tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          // var sumcount2 = 0;
          $.each(depID, function (keydepID, valuedepID) {
            // console.log(valuedepID);

            var checkcountDepID = 0;
            $.each(ObjData["detailDepID"], function (kay3, value3) {
              if (value3.ItemCode == value.itemcode) {
                if (valuedepID == value3.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value3.Qty}</</td>`;
                  sumcount += parseInt(value3.Qty);
                  checkcountDepID = 1;
                }
              }
            });
            if (checkcountDepID == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom_normal_movement tbody").html(tr);
      // ถ้าถูก init มาก่อนแล้ว ให้ destroy ก่อน
      if ($.fn.DataTable.isDataTable("#table_DepRoom_movement")) {
        $("#table_DepRoom_normal_movement").DataTable().destroy();
      }

      const tbl = $("#table_DepRoom_normal_movement").DataTable({
        language: {
          emptyTable: settext("dataTables_empty"),
          paginate: {
            next: settext("table_itemStock_next"),
            previous: settext("table_itemStock_previous"),
          },
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

        autoWidth: false, // ให้เราคุม width เอง
        scrollX: true,
        scrollCollapse: true,
        scrollY: "800px",
        fixedColumns: { leftColumns: 8, rightColumns: 0 },
        fixedHeader: true,

        paging: true,
        pageLength: 15,
        searching: false,
        lengthChange: false,
        ordering: false,
        info: true,

        columnDefs: [
          { targets: 0, width: "50px" },
          { targets: 1, width: "250px" },
          { targets: 2, width: "100px" },
          { targets: 3, width: "120px" },
          { targets: 4, width: "110px" },
          { targets: 5, width: "110px" },
          { targets: 6, width: "80px" }, // Max
          { targets: 7, width: "80px" }, // Min  ⇒ เท่ากับคอลัมน์ 5
        ],
        initComplete: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
        drawCallback: function () {
          const api = this.api();
          api.columns.adjust();
          if (api.fixedColumns && api.fixedColumns().relayout)
            api.fixedColumns().relayout();
        },
      });

      // ถ้าตารางเพิ่งถูกโชว์ (เช่น อยู่ในแท็บ) ให้ sync อีกรอบ
      setTimeout(() => {
        tbl.columns.adjust().draw(false);
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      }, 0);

      // ช่วยเวลา resize
      $(window).on("resize", () => {
        tbl.columns.adjust();
        if (tbl.fixedColumns && tbl.fixedColumns().relayout) {
          tbl.fixedColumns().relayout();
        }
      });

      $("th").removeClass("sorting_asc");
      if (tr == "") {
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
