var departmentroomname = "";
var UserName = "";
var Userid = "";

$(function () {
  $("#row_department").hide();

  $("#radio_hn").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#row_hn").show();
    $("#row_department").hide();

    setTimeout(() => {
      show_detail_hn();
    }, 500);
  });

  $("#radio_department").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#row_hn").hide();
    $("#row_department").show();

    setTimeout(() => {
      show_detail_department();
    }, 500);
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

  session();
  $("#select_SDate").val(output);
  $("#select_SDate").datepicker({
    onSelect: function (date) {
      show_detail_hn();
    },
  });
  $("#select_EDate").val(output);
  $("#select_EDate").datepicker({
    onSelect: function (date) {
      show_detail_hn();
    },
  });

  $("#select_SDate_department").val(output);
  $("#select_SDate_department").datepicker({
    onSelect: function (date) {
      show_detail_department();
    },
  });
  $("#select_EDate_department").val(output);
  $("#select_EDate_department").datepicker({
    onSelect: function (date) {
      show_detail_department();
    },
  });

  $("#input_type_search").val(1);

  $("#input_search").keypress(function (e) {
    if (e.which == 13) {
      show_detail_hn();

      // feeddata_hncode($(this).val().trim());

      // $("#table_detail_sub tbody").empty();
      // $("#input_search").val("");
    }
  });

  setTimeout(() => {
    show_detail_hn();
  }, 500);
});

$("#a_hnxxx").click(function () {
  $("#btn_input").text("เลข HN Number");
  $("#input_type_search").val(1);
});

$("#a_usage").click(function () {
  $("#btn_input").text("รหัสอุปกรณ์");
  $("#input_type_search").val(2);
});



function show_detail_department() {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_department",
      select_SDate_department: $("#select_SDate_department").val(),
      select_EDate_department: $("#select_EDate_department").val(),
    },
    success: function (result) {
      $("#table_detail_department").DataTable().destroy();
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

          _tr +=
            `<tr class="color2" onclick='setActive_feeddata_sell_detail("${value.DocNo}","${value.his_IsStatus}")' id="tr_${value.DocNo}"> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center" >${value.serviceDate} ${value.serviceTime}</td>` +
            `<td class="text-center" >${value.DepName}</td>` +
            `<td class="text-center" >${value.DocNo}</td>` +
            ` </tr>`;
        });
      } else {
      }
      $("#table_detail_department tbody").html(_tr);
      $("#table_detail_department ").DataTable({
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
        columnDefs: [
          {
            width: "5%",
            targets: 0,
          },
          {
            width: "15%",
            targets: 1,
          },
          {
            width: "15%",
            targets: 2,
          },
          {
            width: "15%",
            targets: 3,
          }
        ],
        info: false,
        scrollX: true,
        scrollCollapse: false,
        visible: false,
        searching: false,
        lengthChange: false,
        autoWidth: false,
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

function setActive_feeddata_sell_detail(DocNo, his_IsStatus) {
  $(".color2").css("background-color", "");
  $("#tr_" + DocNo).css("background-color", "#FEE4E2");

  $("#btn_send_pay_department").data("DocNo", DocNo);

  // $("#btn_Tracking").attr("disabled", false);

  if (his_IsStatus == "null") {
    $("#btn_send_pay_department").attr("disabled", false);
    $("#edit_his_department").attr("disabled", true);
  } else {
    if (his_IsStatus == "2") {
      $("#edit_his_department").attr("disabled", true);
    } else {
      $("#edit_his_department").attr("disabled", true);
    }

    $("#btn_send_pay_department").attr("disabled", true);
    $("#tr_" + DocNo).css("background-color", "lightgreen");
  }

  // alert(DocNo);
  feeddata_sell_detail(DocNo);
}

function feeddata_sell_detail(DocNo) {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_sell_detail",
      DocNo: DocNo,
    },
    success: function (result) {
      $("#table_detail_sub_department").DataTable().destroy();
      var ObjData = JSON.parse(result);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var user_count = "";

          var label = `<label style='color:blue;cursor:pointer;' onclick='open_LotNo("${value.serielNo}","${value.lotNo}","${value.ExpireDate}")' >${value.UsageCode}</label>`;

          _tr +=
            `<tr id='tdDetail_${value.ID}'> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-left">
                  <label style='color: lightgray;max-width: 160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' title='${value.TyeName}'>${value.TyeName}</label>
              </td>` +
            `<td class="text-center" >${label}</td>` +
            `<td class="text-left">${value.itemname}</td>` +
            `<td class="text-center">1</td>` +
            ` </tr>`;
        });
      }
      $("#table_detail_sub_department tbody").html(_tr);
      $("#table_detail_sub_department").DataTable({
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
        columnDefs: [
          {
            width: "3%",
            targets: 0,
          },
          {
            width: "10%",
            targets: 1,
          },
          {
            width: "20%",
            targets: 2,
          },
          {
            width: "27%",
            targets: 3,
          },
          {
            width: "5%",
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
    },
  });
}



function show_detail_hn() {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_hn",
      select_SDate: $("#select_SDate").val(),
      select_EDate: $("#select_EDate").val(),
      input_search: $("#input_search").val(),
      input_type_search: $("#input_type_search").val(),
    },
    success: function (result) {
      $("#table_detail").DataTable().destroy();
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
            var styleP = ``;
            var titleP = ``;
          } else {
            var styleP = `style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' `;
            var titleP = `title="${value.Procedure_TH}"`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          _tr +=
            `<tr class="color" onclick='setActive_feeddata_hncode_detail(${value.ID},"${value.DocNo}","${value.HnCode}","${value.his_IsStatus}")' id="tr_${value.ID}"> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center" >${value.DocDate}</td>` +
            `<td class="text-center" style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' title='${value.HnCode}'>${value.HnCode}</td>` +
            `<td class="text-left" style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' title='${value.departmentroomname}'>${value.departmentroomname}</td>` +
            `<td class="text-left" style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.Doctor_Name}</td>` +
            `<td class="text-left" ${styleP} ${titleP} >${value.Procedure_TH}</td>` +
            ` </tr>`;
        });
      } else {
      }
      $("#table_detail tbody").html(_tr);
      $("#table_detail ").DataTable({
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
        columnDefs: [
          {
            width: "5%",
            targets: 0,
          },
          {
            width: "15%",
            targets: 1,
          },
          {
            width: "15%",
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
            width: "15%",
            targets: 5,
          },
        ],
        info: false,
        scrollX: true,
        scrollCollapse: false,
        visible: false,
        searching: false,
        lengthChange: false,
        autoWidth: false,
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

function feeddata_hncode(input_search) {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_hncode",
      select_SDate: $("#select_SDate").val(),
      select_EDate: $("#select_EDate").val(),
      input_search: input_search,
      input_type_search: $("#input_type_search").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr  class="color" onclick='setActive_feeddata_hncode_detail(${value.ID},"${value.DocNo}","${value.HnCode}")' id="tr_${value.ID}"> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center" >${value.DocDate}</td>` +
            `<td class="text-left" >${value.HnCode}</td>` +
            `<td class="text-left">${value.departmentroomname}</td>` +
            `<td class="text-left">${value.Doctor_Name}</td>` +
            `<td class="text-left">${value.Procedure_TH}</td>` +
            ` </tr>`;
        });
      }
      $("#table_detail tbody").html(_tr);
    },
  });
}

function setActive_feeddata_hncode_detail(ID, DocNo, HnCode, his_IsStatus) {
  $(".color").css("background-color", "");
  $("#tr_" + ID).css("background-color", "#FEE4E2");

  $("#btn_Tracking").data("DocNo", DocNo);

  $("#btn_Tracking").attr("disabled", false);

  if (his_IsStatus == "null") {
    $("#btn_send_pay").attr("disabled", false);
    $("#edit_his").attr("disabled", true);
  } else {
    if (his_IsStatus == "2") {
      $("#edit_his").attr("disabled", false);
    } else {
      $("#edit_his").attr("disabled", true);
    }

    $("#btn_send_pay").attr("disabled", true);
    $("#tr_" + ID).css("background-color", "lightgreen");
  }

  // alert(DocNo);
  feeddata_hncode_detail(DocNo, HnCode);
}
// ========================================================================================HIS
$("#edit_his").click(function () {
  $("#myCustomModal").modal("toggle");
  $("#table_add_his tbody").empty();
  $("#table_return_his tbody").empty();
  set_item();

  setTimeout(() => {
    $("#select_item_his").select2({
      // เพิ่มบรรทัดนี้:
      dropdownParent: $("#myCustomModal"), // หรือถ้ามีปัญหา ให้ลองใช้ $('#myCustomModal .modal-body')
    });
  }, 400);
});

function set_item() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_item",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกอุปกรณ์</option>`; // เปลี่ยนข้อความเริ่มต้น
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.itemcode}" >${value.itemname}</option>`; // คาดว่าค่าที่ต้องการแสดงคือ itemname
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_item_his").html(option); // เปลี่ยน ID ของ select element ที่ต้องการให้แสดงผล
    },
  });
}

// เพิ่มโค้ดนี้เข้าไปใน hn.js
// ตรวจสอบให้แน่ใจว่าอยู่หลังจากการโหลด jQuery และ Select2
// หรืออยู่ภายใน $(function() { ... }); block

$(document).on("change", "#select_item_his", function () {
  var selectedItemCode = $(this).val();
  var selectedItemName = $(this).find("option:selected").text();

  // ตรวจสอบไม่ให้เพิ่มค่าว่าง ("") หรือ "0" หรือค่าที่ไม่ถูกต้อง
  if (
    selectedItemCode === "" ||
    selectedItemCode === "0" ||
    !selectedItemCode
  ) {
    return;
  }

  // ตรวจสอบว่ารายการนี้มีอยู่ในตารางแล้วหรือไม่
  var itemAlreadyInTable = false;
  $("#table_add_his tbody tr").each(function () {
    if ($(this).data("itemcode") === selectedItemCode) {
      // ถ้ามีอยู่แล้ว ให้เพิ่มจำนวน (Quantity) แทน
      var currentQty = parseInt($(this).find("input[name='add_qty']").val());
      // $(this).find("input[name='add_qty']").val(currentQty + 1);
      itemAlreadyInTable = true;
      return false; // ออกจาก loop .each
    }
  });

  if (!itemAlreadyInTable) {
    // ถ้ายังไม่มีในตาราง ให้เพิ่มแถวใหม่
    var newRowHtml = `<tr data-itemcode="${selectedItemCode}">
                              <td>${selectedItemName}</td>
                              <td class="text-center">
                                  <input type="number" name="add_qty" class=" f18 form-control form-control-sm text-center" value="1" min="1" style="width: 70px; display: inline-block;">
                              </td>
                              <td class="text-center">
                                  <button type="button" class="btn btn-danger btn-sm remove-added-item" style="margin-left: 5px;">X</button>
                              </td>
                          </tr>`;
    $("#table_add_his tbody").append(newRowHtml);
  }

  // (เลือกได้) รีเซ็ต dropdown กลับไปที่ค่าเริ่มต้นหลังจากเลือก เพื่อให้เลือกรายการใหม่ได้ง่ายขึ้น
  // หากใช้ Select2 ต้องใช้ trigger("change.select2") ด้วย
  $(this).val("").trigger("change.select2");
});

// Event listener สำหรับปุ่มลบรายการออกจาก table_add_his
$(document).on("click", ".remove-added-item", function () {
  $(this).closest("tr").remove(); // ลบแถวทั้งหมดที่ปุ่มนี้อยู่
});

$("#input_return_item_his").keypress(function (e) {
  if (e.which == 13) {
    var usageCode = convertString($(this).val().trim()); // ดึงค่า Usage Code ที่สแกนมา

    console.log(usageCode);
    if (usageCode === "") {
      Swal.fire("แจ้งเตือน", "กรุณาสแกน Usage Code", "warning");
      return;
    }

    // ตรวจสอบว่า Usage Code นี้ถูกเพิ่มในตาราง table_return_his แล้วหรือยัง
    var itemAlreadyInReturnTable = false;
    $("#table_return_his tbody tr").each(function () {
      if ($(this).data("usagecode") === usageCode) {
        Swal.fire("แจ้งเตือน", "Usage Code นี้ถูกเพิ่มแล้วในรายการ", "info");
        itemAlreadyInReturnTable = true;
        return false; // ออกจาก loop .each
      }
    });

    if (itemAlreadyInReturnTable) {
      // เคลียร์ช่อง input หากรายการถูกเพิ่มแล้ว
      $(this).val("");
      return;
    }

    // ทำการเรียก AJAX เพื่อค้นหาข้อมูลอุปกรณ์จาก Usage Code
    $.ajax({
      url: "process/hn.php",
      type: "POST",
      dataType: "json",
      data: {
        FUNC_NAME: "check_usage",
        usage_code: usageCode,
        DocNo: $("#btn_Tracking").data("DocNo"),
      }, // ส่ง Usage Code ไปยัง API

      success: function (response) {
        // ฟังก์ชันนี้จะทำงานเมื่อ AJAX request สำเร็จ
        if (response.status === "success" && response.data) {
          console.log(2222);
          var item = response.data;

          if (
            $(`#table_return_his tbody tr[data-usagecode="${usageCode}"]`)
              .length > 0
          ) {
            return;
          }

          // เพิ่มรายการอุปกรณ์ที่พบลงในตาราง table_return_his
          var newRowHtml = `<tr data-usagecode="${usageCode}" data-itemcode="${item.item_code || ""
            }">
                                          <td style='max-width: 180px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${item.item_name ||
            "ไม่ระบุชื่ออุปกรณ์"
            }</td>
                                          <td>${usageCode || "ไม่ระบุชื่ออุปกรณ์"
            }</td>
                                          <td class='text-center'>${item.quantity || 1
            }</td>
                                          <td class="text-center">
                                              <button type="button" class="btn btn-danger btn-sm remove-returned-item">X</button>
                                          </td>
                                      </tr>`;
          $("#table_return_his tbody").append(newRowHtml);
        } else {
          Swal.fire(
            "ไม่พบข้อมูล!",
            response.message || "ไม่พบอุปกรณ์สำหรับ Usage Code นี้",
            "error"
          );

          return;
        }
      },
      error: function (xhr, status, error) {
        // ฟังก์ชันนี้จะทำงานเมื่อ AJAX request เกิดข้อผิดพลาด
        console.error("AJAX error: ", status, error, xhr);
        Swal.fire(
          "เกิดข้อผิดพลาด!",
          "ไม่สามารถค้นหาข้อมูลได้ ลองอีกครั้ง",
          "error"
        );
      },
      complete: function () {
        // เคลียร์ช่อง input หลังจาก AJAX call เสร็จสิ้น (ไม่ว่าจะสำเร็จหรือผิดพลาด)
        $("#input_return_item_his").val("");
      },
    });
  }
});

// Event listener สำหรับปุ่มลบรายการออกจาก table_return_his
$(document).on("click", ".remove-returned-item", function () {
  $(this).closest("tr").remove(); // ลบแถวทั้งหมดที่ปุ่มนี้อยู่
});

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
// Event listener เมื่อคลิกปุ่ม "ส่งข้อมูล"
$("#btn_send_his").click(function () {
  var addItems = [];
  var returnItems = [];

  // 1. รวบรวมข้อมูลจาก table_add_his (อุปกรณ์ที่เพิ่ม)
  $("#table_add_his tbody tr").each(function () {
    var itemCode = $(this).data("itemcode");
    var quantity = $(this).find("input[name='add_qty']").val();

    if (itemCode && quantity) {
      addItems.push({
        item_code: itemCode,
        quantity: parseInt(quantity),
      });
    }
  });

  // 2. รวบรวมข้อมูลจาก table_return_his (อุปกรณ์ที่สแกนคืน)
  $("#table_return_his tbody tr").each(function () {
    var usageCode = $(this).data("usagecode");
    var itemCode = $(this).data("itemcode");
    var quantity = parseInt($(this).find("td:nth-child(3)").text());

    if (usageCode && itemCode && quantity) {
      returnItems.push({
        usage_code: usageCode,
        item_code: itemCode,
        quantity: quantity,
      });
    }
  });

  // ตรวจสอบว่ามีข้อมูลจากทั้งสองตารางหรือไม่ ก่อนทำการยืนยัน
  if (addItems.length === 0 && returnItems.length === 0) {
    Swal.fire(
      "แจ้งเตือน",
      "กรุณาเพิ่มอุปกรณ์ หรือ สแกนอุปกรณ์ที่ต้องการส่งข้อมูล",
      "warning"
    );
    return; // หยุดการทำงานถ้าไม่มีรายการใดๆ ในทั้งสองตาราง
  }

  // เพิ่ม Swal Confirmation ที่นี่
  Swal.fire({
    title: "ยืนยันการส่งข้อมูล?",
    text: "คุณต้องการส่งข้อมูลอุปกรณ์เหล่านี้ใช่หรือไม่?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      // ถ้าผู้ใช้กด 'ใช่, ส่งเลย!' ให้ดำเนินการส่งข้อมูล
      var combinedData = {
        // เพิ่ม DocNo ที่นี่
        DocNo: $("#btn_Tracking").data("DocNo"), // ดึงค่า DocNo จาก data attribute ของปุ่ม btn_Tracking
        add_items: addItems,
        return_items: returnItems,
      };

      // ทำการส่งข้อมูลผ่าน AJAX
      $.ajax({
        url: "api/process_all_modal_data.php", // *** โปรดตรวจสอบและเปลี่ยน URL ของ API ของคุณ ***
        type: "POST",
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(combinedData),

        success: function (response) {
          if (response.status === "success") {
            Swal.fire(
              "สำเร็จ!",
              response.message || "ส่งข้อมูลเรียบร้อยแล้ว",
              "success"
            );
            // เคลียร์ทั้งสองตารางและปิด Modal หลังจากส่งข้อมูลสำเร็จ
            $("#table_add_his tbody").empty();
            $("#table_return_his tbody").empty();
            $("#myCustomModal").modal("hide");
          } else {
            Swal.fire(
              "เกิดข้อผิดพลาด!",
              response.message || "ไม่สามารถส่งข้อมูลได้",
              "error"
            );
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error: ", status, error, xhr);
          Swal.fire(
            "เกิดข้อผิดพลาด!",
            "ไม่สามารถส่งข้อมูลได้ ลองอีกครั้ง",
            "error"
          );
        },
      });
    }
  });
});
// ========================================================================================HIS

$("#btn_send_pay_department").click(function () {
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
        url: "process/hn.php",
        type: "POST",
        data: {
          FUNC_NAME: "onHIS_sell",
          DocNo: $("#btn_send_pay_department").data("DocNo"),
        },
        success: function (result) {
          var link = "pages/hn_daily.php";
          $.get(link, function (res) {
            $(".nav-item").removeClass("active");
            $(".nav-item").css("background-color", "");

            $("#ic_search_hndata").attr(
              "src",
              "assets/img_project/2_icon/ic_search_hndata.png"
            );
            $("#menu9").css("color", "#667085");

            $("#conMain").html(res);
            history.pushState({}, "Results for `Cats`", "index.php?s=hn_daily");
            document.title = "hn_daily";

            loadScript("script-function/hn_daily.js");
            loadScript("assets/lang/hn_daily.js");
          });

          // feeddata_waitReturn();
        },
      });
    }
  });
});

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
        url: "process/hn.php",
        type: "POST",
        data: {
          FUNC_NAME: "onHIS",
          DocNo: $("#btn_Tracking").data("DocNo"),
        },
        success: function (result) {
          var link = "pages/hn_daily.php";
          $.get(link, function (res) {
            $(".nav-item").removeClass("active");
            $(".nav-item").css("background-color", "");

            $("#ic_search_hndata").attr(
              "src",
              "assets/img_project/2_icon/ic_search_hndata.png"
            );
            $("#menu9").css("color", "#667085");

            $("#conMain").html(res);
            history.pushState({}, "Results for `Cats`", "index.php?s=hn_daily");
            document.title = "hn_daily";

            loadScript("script-function/hn_daily.js");
            loadScript("assets/lang/hn_daily.js");
          });

          // feeddata_waitReturn();
        },
      });
    }
  });
});

function loadScript(url) {
  const script = document.createElement("script");
  script.src = url;
  script.type = "text/javascript";
  script.onload = function () {
    // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
}

$("#btn_use").click(function () {
  if ($("#btn_Tracking").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_Tracking").data("DocNo");
    window.open("report/Report_use.php" + option, "_blank");
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }
});

$("#btn_Tracking").click(function () {
  if ($("#btn_Tracking").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_Tracking").data("DocNo");
    window.open(
      "report/Report_Medical_Instrument_Tracking.php" + option,
      "_blank"
    );
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }
});

$("#btn_cost").click(function () {
  if ($("#btn_Tracking").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_Tracking").data("DocNo");
    window.open("report/Report_Patient_Cost_Summary.php" + option, "_blank");
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }
});

$("#btn_excel_all").click(function () {
  option =
    "?select_SDate=" +
    $("#select_SDate").val() +
    "&select_EDate=" +
    $("#select_EDate").val() +
    "&Userid=" +
    Userid;
  window.open(
    "report/phpexcel/Report_Medical_Instrument_Tracking.php" + option,
    "_blank"
  );
});

$("#btn_excel_cost").click(function () {

  if ($("#btn_Tracking").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_Tracking").data("DocNo");
    window.open("report/phpexcel/Report_hn_cost.php" + option, "_blank");
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }



});






$("#btn_Tracking_department").click(function () {
  if ($("#btn_send_pay_department").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_send_pay_department").data("DocNo");
    window.open(
      "report/Report_Medical_Instrument_Tracking_sell.php" + option,
      "_blank"
    );
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }
});

$("#btn_cost_department").click(function () {
  if ($("#btn_send_pay_department").data("DocNo") != undefined) {
    option = "?DocNo=" + $("#btn_send_pay_department").data("DocNo");
    window.open("report/Report_Patient_Cost_Summary_sell.php" + option, "_blank");
  } else {
    Swal.fire("ล้มเหลว", "กรุณาเลือกรายการ", "error");
  }
});

$("#btn_excel_all_department").click(function () {
  option =
    "?select_SDate=" +
    $("#select_SDate_department").val() +
    "&select_EDate=" +
    $("#select_EDate_department").val() +
    "&Userid=" +
    Userid;
  window.open(
    "report/phpexcel/Report_Medical_Instrument_Tracking_sell.php" + option,
    "_blank"
  );
});

$("#btn_excel_cost_department").click(function () {
  option = "?DocNo=" + $("#btn_send_pay_department").data("DocNo");
  window.open("report/phpexcel/Report_hn_cost_sell.php" + option, "_blank");
});

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

function feeddata_hncode_detail(DocNo, HnCode) {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_hncode_detail",
      DocNo: DocNo,
      HnCode: HnCode,
      input_type_search: $("#input_type_search").val(),
    },
    success: function (result) {
      $("#table_detail_sub").DataTable().destroy();
      var ObjData = JSON.parse(result);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var user_count = "";
          if (value.TyeName == null) {
            value.TyeName = value.TyeName2;
          }
          if (value.itemname == null) {
            value.itemname = value.itemname2;
          }
          if (value.UsageCode == null) {
            value.UsageCode = value.itemcode2;

            var label = `<label>${value.UsageCode}</label>`;
          } else {
            var label = `<label style='color:blue;cursor:pointer;' onclick='open_LotNo("${value.serielNo}","${value.lotNo}","${value.ExpireDate}")' >${value.UsageCode}</label>`;
          }

          if (value.Qty > 0) {
            _tr +=
              `<tr id='tdDetail_${value.ID}'> ` +
              `<td class="text-center">${kay + 1}</td>` +
              `<td class="text-left">
                  <label style='color: lightgray;max-width: 160px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' title='${value.TyeName}'>${value.TyeName}</label>
              </td>` +
              // `<td class="text-center">${user_count}</td>` +
              `<td class="text-center" >${label}</td>` +
              `<td class="text-left">${value.itemname}</td>` +
              `<td class="text-center">${value.Qty}</td>` +
              ` </tr>`;
          }
        });
      }
      $("#table_detail_sub tbody").html(_tr);
      $("#table_detail_sub").DataTable({
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
        columnDefs: [
          {
            width: "3%",
            targets: 0,
          },
          {
            width: "10%",
            targets: 1,
          },
          {
            width: "20%",
            targets: 2,
          },
          {
            width: "27%",
            targets: 3,
          },
          {
            width: "5%",
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
    },
  });
}

function open_LotNo(serielNo, lotNo, ExpireDate) {
  $("#modal_lotno").modal("toggle");
  if (lotNo == "null" || lotNo == "") {
    lotNo = "ไม่มีข้อมูล";
  }
  if (serielNo == "null" || serielNo == "") {
    serielNo = "ไม่มีข้อมูล";
  }
  $("#lot_no").val(lotNo);
  $("#seriel_no").val(serielNo);
  $("#exp_lot").val(ExpireDate);
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
      Userid = ObjData.Userid;

      $("#input_Deproom_Main").val(Permission_name);
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

function settext(key) {
  if (localStorage.lang == "en") {
    return en[key];
  } else {
    return th[key];
  }
}
