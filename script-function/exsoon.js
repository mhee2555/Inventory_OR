var GN_WarningExpiringSoonDay = "";

$(function () {
  session();
  configMenu();

  $("#col_sendsterile").attr("hidden", true);

  $("#radio_tab2").addClass('active');

  // $("#radio_tab2").css("color", "#bbbbb");
  // $("#radio_tab2").css("background", "#EAE1F4");
  // $("#radio_tab1").css("color", "black");
  // $("#radio_tab1").css("background", "");
  // $("#radio_tab3").css("color", "black");
  // $("#radio_tab3").css("background", "");
  $("#table_data").attr("hidden", false);
  $("#table_data2").attr("hidden", true);
  $("#check_ex").val("2");
  feeddata();

  setTimeout(() => {
    feeddata();
  }, 300);
});

$("#radio_tab1").click(function () {
  $("#col_sendsterile").attr("hidden", true);
  $(".tab-button").removeClass("active");
  $(this).addClass("active");
  $("#table_data").attr("hidden", false);
  $("#check_ex").val("1");
  feeddata();
});

$("#radio_tab2").click(function () {
  $("#col_sendsterile").attr("hidden", true);
  $(".tab-button").removeClass("active");
  $(this).addClass("active");
  $("#table_data").attr("hidden", false);
  $("#check_ex").val("2");
  feeddata();
});

$("#radio_tab3").click(function () {
  $("#col_sendsterile").attr("hidden", true);
  $(".tab-button").removeClass("active");
  $(this).addClass("active");

  $("#table_data").attr("hidden", false);
  $("#check_ex").val("3");

  feeddata();
});

$("#input_scanexpire").keypress(function (e) {
  if (e.which == 13) {
    $("#input_scanexpire").val(convertString($(this).val()));
    xxx($("#input_scanexpire").val().trim());
    $("#input_scanexpire").val("");
  }
});

$("#input_return_ex").keypress(function (e) {
  if (e.which == 13) {
    $("#input_return_ex").val(convertString($(this).val()));
    xxx2($("#input_return_ex").val().trim());
    $("#input_return_ex").val("");
  }
});

$("#btn_sendNSterile").click(function () {
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
      // $('#btn_send').click();

      onSendNsterile();
    }
  });
});

function onSendNsterile() {
  var ArrayItemStockID = [];
  var cnt = 0;
  table_data = $("#table_data").DataTable();

  table_data.$('input[type="checkbox"]').each(function () {
    if (this.checked) {
      var checkboxValue = $(this).data("itemstockid");
      ArrayItemStockID.push(checkboxValue);
      cnt++;
    }
  });

  if (ArrayItemStockID == "") {
    ArrayItemStockID.push(0);
  }

  if (cnt == "0") {
    showDialogFailed(settext("alert_noItem"));
    return;
  }

  var nsterile = 1;

  $.ajax({
    url: "process/ex.php",
    type: "POST",
    data: {
      FUNC_NAME: "checkNSterile",
      ArrayItemStockID: ArrayItemStockID,
      checkNsterile: nsterile,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);

      $.each(ObjData, function (kay, value) {
        if (value.qty != "0") {
          showDialogFailed("มีอุปกรณ์รอส่ง Create Request");
        } else {
          $.ajax({
            url: "process/ex.php",
            type: "POST",
            data: {
              FUNC_NAME: "onSendNsterile",
              ArrayItemStockID: ArrayItemStockID,
            },
            success: function (result) {
              var ObjData = JSON.parse(result);
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function (kay, value) {
                  // var departmentroomid = value.departmentroomid;
                  // var RowID = value.RowID;
                  // var ItemCode = value.ItemCode;
                  // onInSertitemstock_Transaction(RowID, ItemCode, departmentroomid, 3, 19);
                  // onItemstock_Balance(ItemCode, 19, 1, 0);
                  // // onItemstock_Balance_sub(ItemCode, 19, 1, departmentroomid, 0);
                });
              }

              if (RefDepID == "36DEN") {
                setTimeout(() => {
                  feeddata();
                }, 500);
              } else {
                setTimeout(() => {
                  $("#btn_send").click();
                }, 200);
              }
            },
          });
        }
      });
    },
  });
}

$("#btn_send").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=send-n-sterile");
    document.title = "send-n-sterile";

    loadScript("script-function/send-n-sterile.js");
  });
});

function feeddata() {
  // $('#table_data').DataTable().destroy();
  // $('#table_data2').DataTable().destroy();
  // $("#table_data tbody").html("");
  // $("#table_data2 tbody").html("");
  $.ajax({
    url: "process/ex.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata",
      GN_WarningExpiringSoonDay: GN_WarningExpiringSoonDay,
      check_ex: $("#check_ex").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $("#table_data").DataTable().destroy();
        $("#table_data tbody").html("");
        var number_ex = 1;

        $.each(ObjData, function (kay, value) {
          var color = "";
          if (value.IsStatus == 'ใกล้หมดอายุ') {
            color = "btn btn-warning ' ";
          } else {
            color = "btn btn-danger ' ";
          }

          console.log($("#check_ex").val());

          if ($("#check_ex").val() == "1") {
            if (value.IsStatus == "ใกล้หมดอายุ") {
              value.IsStatus = "ใกล้หมดอายุ";
            } else if (value.IsStatus == "หมดอายุ") {
              value.IsStatus = "หมดอายุ";
            }
            _tr +=
              `<tr> ` +
              `<td class="text-center"><label >${number_ex}</label></td>` +
              `<td class="text-center"><label >${value.UsageCode}</label></td>` +
              `<td class="text-left"><label >${value.itemname}</label></td>` +
              `<td class="text-center"><label >${value.ExpireDate}</label</td>` +
              `<td class="text-center"><label >${value.Qty}</label</td>` +
              `<td class="text-center"><button class='${color}' style='width: 80%;' disabled>${value.IsStatus}</button></td>` +
              ` </tr>`;

            number_ex++;
          }
          if ($("#check_ex").val() == "2") {
            if (value.IsStatus == "ใกล้หมดอายุ") {
              value.IsStatus = settext("exsoon");
              _tr +=
                `<tr> ` +
                `<td class="text-center"><label >${number_ex}</label></td>` +
                `<td class="text-center"><label >${value.UsageCode}</label></td>` +
                `<td class="text-left"><label >${value.itemname}</label></td>` +
                `<td class="text-center"><label >${value.ExpireDate}</label</td>` +
                `<td class="text-center"><label >${value.Qty}</label</td>` +
                `<td class="text-center"> <button class='${color}' style='width: 80%;' disabled>${value.IsStatus}</button></td>` +
                ` </tr>`;

              number_ex++;
            }
          }
          if ($("#check_ex").val() == "3") {
            if (value.IsStatus == "หมดอายุ") {
              value.IsStatus = settext("ex");
              var disabled = "disabled";
              _tr +=
                `<tr id='tr_${value.UsageCode}'> ` +
                // `<td class="text-center"><input ${disabled} value="${value.UsageCode}"  type="checkbox"    data-itemstockid="${value.RowID}"    class="form-check-input checkAllSub_${kay}  checkAllSub checkAllSubxx_${value.UsageCode}" id="checkAllSub_${value.UsageCode}"   style="width: 25px;height: 20px;"></td>` +
                `<td class="text-center"><label >${number_ex}</label></td>` +
                `<td class="text-center"><label >${value.UsageCode}</label></td>` +
                `<td class="text-left"><label >${value.itemname}</label></td>` +
                `<td class="text-center"><label >${value.ExpireDate}</label</td>` +
                `<td class="text-center"><label >${value.Qty}</label</td>` +
                `<td class="text-center"> <button class='${color}' style='width: 80%;' disabled>${value.IsStatus}</button></td>` +
                ` </tr>`;

              number_ex++;
            }
          }
        });
        $("#table_data tbody").html(_tr);
        $("#table_data").DataTable({
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
          columnDefs: [{
            width: '5%',
            targets: 0
          }, {
            width: '15%',
            targets: 1
          }, {
            width: '20%',
            targets: 2
          }, {
            width: '15%',
            targets: 3
          }, {
            width: '10%',
            targets: 4
          }, {
            width: '10%',
            targets: 5
          }],
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
      }
    },
  });
}
function xxx(IDGroup) {
  table_data = $("#table_data").DataTable();

  var cnt = 0;
  if (
    table_data.$(".checkAllSubxx_" + IDGroup).val() ==
    $("#input_scanexpire").val().trim()
  ) {
    table_data.$(".checkAllSubxx_" + IDGroup).prop("checked", true);

    $("#tr_" + IDGroup).css("background-color", "#FEE4E2");
    cnt++;
  }

  if (cnt == 0) {
    showDialogFailed(settext("alert_noItem"));
  }
}
function xxx2(IDGroup) {
  table_data = $("#table_data").DataTable();

  var cnt = 0;
  if (
    table_data.$(".checkAllSubxx_" + IDGroup).val() ==
    $("#input_return_ex").val().trim()
  ) {
    table_data.$(".checkAllSubxx_" + IDGroup).prop("checked", false);
    cnt++;
  }

  if (cnt == 0) {
    showDialogFailed(settext("alert_noItem"));
  }
}

//////////////////////////////////////////////////////////////// select
function loadScript(url) {
  const script = document.createElement("script");
  script.src = url;
  script.type = "text/javascript";
  script.onload = function () {
    // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
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
function configMenu() {
  $.ajax({
    url: "process/configuration_dental.php",
    type: "POST",
    data: {
      FUNC_NAME: "configuration_dental",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          GN_WarningExpiringSoonDay = value.GN_WarningExpiringSoonDay;
        });
      }
    },
  });
}
