var departmentroomname = "";
var UserName = "";

$(function () {


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
  show_detail_hn();

  $("#input_type_search").val(1);


  $("#input_search").keypress(function (e) {
    if (e.which == 13) {
      feeddata_hncode($(this).val().trim());

      $("#table_detail_sub tbody").empty();
      $("#input_search").val("");
    }
  });
});





  $("#a_hnxxx").click(function () {
    $("#btn_input").text("เลข HN Number");
    $("#input_type_search").val(1);
  });

  $("#a_usage").click(function () {
    $("#btn_input").text("รหัสอุปกรณ์ SUDs");
    $("#input_type_search").val(2);
  });

function show_detail_hn() {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_hn",
      select_SDate: $("#select_SDate").val(),
      select_EDate: $("#select_EDate").val(),
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
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }




          _tr +=
            `<tr class="color" onclick='setActive_feeddata_hncode_detail(${value.ID},"${value.DocNo}","${value.HnCode}")' id="tr_${value.ID}"> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center" >${value.DocDate}</td>` +
            `<td class="text-left" >${value.HnCode}</td>` +
            `<td class="text-left">${value.departmentroomname}</td>` +
            `<td class="text-left">${value.Doctor_Name}</td>` +
            `<td class="text-left">${value.Procedure_TH}</td>` +
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
            width: "10%",
            targets: 0,
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

function setActive_feeddata_hncode_detail(ID, DocNo,HnCode) {
  $(".color").css("background-color", "");
  $("#tr_" + ID).css("background-color", "#FEE4E2");

  $("#btn_Tracking").data("DocNo", DocNo);

  $("#btn_Tracking").attr("disabled", false);

  $("#btn_Tracking").click(function () {
    option = "?DocNo=" + $("#btn_Tracking").data("DocNo");
    window.open("report/Report_Medical_Instrument_Tracking.php" + option, "_blank");
  });

  // alert(DocNo);
  feeddata_hncode_detail(DocNo,HnCode);
}

$("#btn_excel_all").click(function () {
  option = "?select_SDate=" + $("#select_SDate").val()+"&select_EDate=" + $("#select_EDate").val();
  window.open("report/phpexcel/Report_Medical_Instrument_Tracking.php" + option, "_blank");
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


function feeddata_hncode_detail(DocNo,HnCode) {
  $.ajax({
    url: "process/hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_hncode_detail",
      DocNo: DocNo,
      HnCode:HnCode,
      input_type_search: $("#input_type_search").val(),
    },
    success: function (result) {
      $("#table_detail_sub").DataTable().destroy();
      var ObjData = JSON.parse(result);
      var _tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

            var user_count = "";
            if(value.TyeName == null){
              value.TyeName = value.TyeName2;
            }
            if(value.itemname == null){
              value.itemname = value.itemname2;
            }
            if(value.UsageCode == null){
              value.UsageCode = value.itemcode2;

              var label = `<label>${value.UsageCode}</label>`;
            }else{
              var label = `<label style='color:blue;cursor:pointer;' onclick='open_LotNo(${value.serielNo},"${value.lotNo}","${value.ExpireDate}")' >${value.UsageCode}</label>`;
            }
            

          _tr +=
            `<tr id='tdDetail_${value.ID}'> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center">
                <button class="btn btn-sm" disabled>${value.TyeName}</button>
            </td>` +
            // `<td class="text-center">${user_count}</td>` +
            `<td class="text-center" >${label}</td>` +
            `<td class="text-left">${value.itemname}</td>` +
            `<td class="text-center">${value.Qty}</td>` +
            ` </tr>`;
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
            width: "10%",
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
    },
  });
}

function open_LotNo(serielNo,lotNo,ExpireDate){
  $("#modal_lotno").modal('toggle');
  if(lotNo == 'null'){
    lotNo = "";
  }
  if(serielNo == 'null'){
    serielNo = "";
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
