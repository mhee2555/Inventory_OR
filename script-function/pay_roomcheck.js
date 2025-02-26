var departmentroomname = "";
var UserName = "";
var UserName = "";
var DocNo_pay = "";
$(function () {
  session();

  setTimeout(() => {
    $("#input_Deproom_Main").val(departmentroomname);
    $("#input_Name_Main").val(UserName);
    $("#select_date_pay").val(set_date());
  }, 200);

  select_deproom();
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
      var option = `<option value="" selected>กรุณาเลือกห้องผ่าตัด</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.id}" >${value.departmentroomname}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_deproom_pay").html(option);
      $("#select_deproom_pay").select2();
    },
  });
}
//////////////////////////////////////////////////////////////// select

//////////////////////////////////////////////////////////////// pay
$("#select_date_pay").datepicker({
  onSelect: function (date) {
    show_detail_bydeproom_pay();
  },
});
$("#select_deproom_pay").change(function () {
  show_detail_bydeproom_pay();
});
$("#input_pay").keypress(function (e) {
  if (e.which == 13) {
    $("#input_pay").val(convertString($(this).val()));
    oncheck_pay($(this).val());
  }
});
$("#input_returnpay").keypress(function (e) {
  if (e.which == 13) {
    $("#input_returnpay").val(convertString($(this).val()));
    oncheck_Returnpay($(this).val());
  }
});


function show_detail_bydeproom_pay() {
  $.ajax({
    url: "process/pay_roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_bydeproom_pay",
      select_deproom_pay: $("#select_deproom_pay").val(),
      select_date_pay: $("#select_date_pay").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_pay").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr class='bg_focus_pay' style='cursor:pointer;' onclick='onselect_show_detail_byDocNo_pay("${value.DocNo}")'  id='tr_deproom_pay_${value.DocNo}'>
                    <td>${value.hn_record_id}</td>
                    <td class='text-center'>${value.Doctor_Name}</td>
                    <td class='text-center'>${value.Procedure_TH}</td>
                 </tr>`;
        });
      }

      $("#table_detail_pay tbody").html(_tr);
      $("#table_detail_pay").DataTable({
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

function onselect_show_detail_byDocNo_pay(DocNo) {
  $(".bg_focus_pay").css("background-color", "");
  $("#tr_deproom_pay_" + DocNo).css("background-color", "#C3EEFA");
  DocNo_pay = DocNo;

  $.ajax({
    url: "process/pay_roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "onselect_show_detail_byDocNo_pay",
      DocNo: DocNo,
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_byDocNo_pay").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr style='cursor:pointer;' >
                        <td class='text-left'>${value.itemname}</td>
                        <td class='text-center'><input type='number' class='form-control text-center' style='font-size:20px;' disabled value="${value.cnt_deproomdetail}"></td>
                        <td class='text-center'><input type='number' class='form-control text-center loop_item_pay' style='font-size:20px;' disabled value="${value.cnt}" data-itemcode='${value.itemcode}'></td>
                        <td class='text-center'><input type='number' class='form-control text-center' style='font-size:20px;' disabled value="${value.balance}"></td>
                     </tr>`;
        });
      }

      $("#table_detail_byDocNo_pay tbody").html(_tr);
      $("#table_detail_byDocNo_pay").DataTable({
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
            width: "70%",
            targets: 0,
          },
          {
            width: "10%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 1,
          },
          {
            width: "10%",
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

function oncheck_pay(input_pay) {

  if(DocNo_pay == ""){
    showDialogFailed('กรุณาเลือกห้องผ่าตัด');
    $("#input_pay").val("");
    return;
  }

  $.ajax({
    url: "process/pay_roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_pay",
      input_pay: input_pay,
      DocNo_pay: DocNo_pay,
    },
    success: function (result) {

        if(result == 0){
            showDialogFailed('ไม่พบข้อมูล');
        }else if(result == 1){
            showDialogFailed('จ่ายครบแล้ว');
        }
        else{
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {

                $.each(ObjData, function(key, value) {

                    $(".loop_item_pay").each(function (key_, value_) {
                        if ($(this).data('itemcode') == value.ItemCode) {
                          var _Qty =  $(this).val();
                          $(this).val(parseInt(_Qty) + 1);
                        }
                      });

                });



            }
        }
      $("#input_pay").val("");
    },
  });
}

function oncheck_Returnpay(input_returnpay) {

  if(DocNo_pay == ""){
    showDialogFailed('กรุณาเลือกห้องผ่าตัด');
    $("#input_returnpay").val("");
    return;
  }

  $.ajax({
    url: "process/pay_roomcheck.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_Returnpay",
      input_returnpay: input_returnpay,
      DocNo_pay: DocNo_pay,
    },
    success: function (result) {

        if(result == 0){
            showDialogFailed('ไม่พบข้อมูล');
        }
        else{
            var ObjData = JSON.parse(result);
            if (!$.isEmptyObject(ObjData)) {

                $.each(ObjData, function(key, value) {

                    $(".loop_item_pay").each(function (key_, value_) {
                        if ($(this).data('itemcode') == value.ItemCode) {
                          var _Qty =  $(this).val();
                          // alert(_Qty);
                          $(this).val(parseInt(_Qty) - 1);
                        }
                      });


                });



            }
        }
      $("#input_returnpay").val("");
    },
  });
}


//////////////////////////////////////////////////////////////// pay

//////////////////////////////////////////////////////////////// select

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

function session() {
  $.ajax({
    url: "process/session.php",
    type: "POST",
    success: function (result) {
      var ObjData = JSON.parse(result);
      departmentroomname = ObjData.departmentroomname;
      UserName = ObjData.UserName;
    },
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
