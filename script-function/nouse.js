var departmentroomname = "";
var UserName = "";

$(function () {
  session();

  $("#select_Date").val(set_date());
  $("#select_Date").datepicker({
    onSelect: function (date) {
      show_detail_deproom();
      $("#table_deproom_nouse_bydeproom tbody").html("");
      // show_detail_Bydeproom($("#select_Date").data('deproom'));
    },
  });

  show_detail_deproom();
});

$("#input_scan_return").keypress(function (e) {
  if (e.which == 13) {
    $("#input_scan_return").val(convertString($(this).val().trim()));
    oncheck_Return($(this).val());
  }
});

$("#btn_save_Return").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การรับเข้าคลัง",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_return();
    }
  });
});

function onconfirm_return() {
  var selectedValues = [];

  $(".form-check-input:checked").each(function () {
    selectedValues.push($(this).val()); // Get value of the checkbox
  });

  $.ajax({
    url: "process/nouse.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_return",
      detailsub_id: selectedValues,
      DocNo: $("#input_scan_return").data("docno"),
      deproomid: $("#input_scan_return").data("deproomid"),
    },
    success: function (result) {
      showDialogSuccess("ยืนยัน รับเข้าคลังสำเร็จ");

      setTimeout(() => {
        $("#modal_returnstock").modal("toggle");
        show_detail_Bydeproom($("#input_scan_return").data("deproomid"));
        show_detail_deproom();
      }, 600);
    },
  });
}

function oncheck_Return(input_scan_return) {
  $("#input_scan_return").val("");

  $("#checkbox_modal_" + input_scan_return).prop("checked", true);

  if ($("#checkbox_modal_" + input_scan_return).is(":checked")) {
  } else {
    showDialogFailed('ไม่พบข้อมูล');
  }

  
}

function show_detail_deproom() {
  $.ajax({
    url: "process/nouse.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_deproom",
      select_Date: $("#select_Date").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_deproom_nouse").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr class='clear_bg' style='cursor:pointer;' id='tr_bg_${
            value.id
          }'  onclick='onShowDetail(${value.id},"${value.departmentroomname}")'>
                        <td class='text-center'>${kay + 1}</td>
                        <td class='text-center'>${value.departmentroomname}</td>
                        <td class='text-center'>${value.cnt}</td>
                     </tr>`;
        });
      }

      $("#table_deproom_nouse tbody").html(_tr);
      $("#table_deproom_nouse").DataTable({
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

function onShowDetail(id, departmentroomname) {
  $(".clear_bg").css("background-color", "");
  $("#tr_bg_" + id).css("background-color", "#de5d5b");

  $("#text_showdeproom").text(departmentroomname);
  $("#select_Date").data("deproom", id);

  show_detail_Bydeproom(id);
}

function show_detail_Bydeproom(id) {
  $.ajax({
    url: "process/nouse.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_Bydeproom",
      id: id,
      select_Date: $("#select_Date").val(),
    },
    success: function (result) {
      var _tr = "";

      $("#table_deproom_nouse_bydeproom tbody").html("");
      // $("#table_deproom_nouse_bydeproom").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsStatus_return == "1") {
            var text = "ยังไม่ได้ยืนยันรับเข้าคลัง";
            var sty =
              "style='background-color:#ed1c24;font-weight:bold;color:#fff;cursor:pointer;' ";
          } else {
            var text = "ยืนยันรับเข้าคลังแล้ว";
            var sty =
              "style='background-color:#00a73e;font-weight:bold;color:#fff;cursor:pointer;' ";
          }
          _tr += `<tr>
                        <td class='text-center'>${kay + 1}</td>
                        <td class='text-center'>${value.hn_record_id}</td>
                        <td class='text-center'>${value.Procedure_TH}</td>
                        <td class='text-center'>${value.cnt_sub}</td>
                        <td class='text-center'  >  <button class='btn' ${sty} onclick='open_modal_returnstock("${
            value.DocNo
          }","${value.hn_record_id}","${id}","${
            value.IsStatus_return
          }")' >${text}</button>   </td>
                     </tr>`;
        });
      }

      $("#table_deproom_nouse_bydeproom tbody").html(_tr);
      // $("#table_deproom_nouse_bydeproom").DataTable({
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
      //       width: "10%",
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
      //        width: "20%",
      //        targets: 4,
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
    },
  });
}

function open_modal_returnstock(
  DocNo,
  hn_record_id,
  deproomID,
  IsStatus_return
) {
  $("#modal_returnstock").modal("toggle");
  $("#text_hnshow").val(hn_record_id);

  $("#input_scan_return").data("docno", DocNo);
  $("#input_scan_return").data("deproomid", deproomID);

  if (IsStatus_return == 1) {
    $("#btn_save_Return").attr("disabled", false);
  } else {
    $("#btn_save_Return").attr("disabled", true);
  }

  setTimeout(() => {
    show_detail_ByDocNo(DocNo);
  }, 500);
}

function show_detail_ByDocNo(DocNo) {
  $.ajax({
    url: "process/nouse.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_ByDocNo",
      DocNo: DocNo,
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_byDocNo tbody").html("");
      // $("#table_item_byDocNo").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsStatus == "5") {
            var checked = "checked disabled";
          } else {
            var checked = "";
          }

          var typename = "";
          if (value.TyeName == "SUDs") {
            typename = "red-text";
          }
          if (value.TyeName == "OR Implant") {
            typename = "primary-text";
          }
          if (value.TyeName == "Sterile") {
            typename = "success-text";
          }

          _tr += `<tr>
                        <td class='text-center'>   <input class="form-check-input" ${checked} type="checkbox" value="${
            value.ID
          }" id="checkbox_modal_${
            value.UsageCode
          }" style="height: 20px;width: 20px;margin-left: -10px;"></td>
                        <td class='text-center'>${kay + 1}</td>
                        <td class='text-center'>
                                  <div class="d-flex align-items-center">
                                  <span>${value.itemname}</span>
                                  <span class="${typename} ms-2">${
            value.TyeName
          }</span>
                              </div> 
                        </td>
                        <td class='text-center'>${value.UsageCode}</td>
                        <td class='text-center'>1</td>
                     </tr>`;
        });
      }

      $("#table_item_byDocNo tbody").html(_tr);
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
