var departmentroomname = "";
var UserName = "";
$(function () {
  session();

  $("#item_suds").hide();
  $("#history_request").hide();
  $("#row_report").attr('hidden',true);


  
  $("#radio_item_sterile").css("color", "#bbbbb");
  $("#radio_item_sterile").css(
    "background",
    "#EAECF0"
  );

  setTimeout(() => {
    show_detail_item_sterile();
  }, 300);

  $("#radio_item_sterile").click(function () {
    $("#radio_item_sterile").css("color", "#bbbbb");
    $("#radio_item_sterile").css(
      "background",
      "#EAECF0"
    );

    $("#radio_item_suds").css("color", "black");
    $("#radio_item_suds").css("background", "");
    $("#radio_history_request").css("color", "black");
    $("#radio_history_request").css("background", "");

    $("#item_sterile").show();
    $("#item_suds").hide();
    $("#history_request").hide();
    $("#row_report").attr('hidden',true);

    show_detail_item_sterile();

    $("#btn_create_sendsterile").attr("hidden", false);
    // $("#btn_create_sendsterile_sud").attr('hidden',true);
  });

  $("#radio_item_suds").click(function () {
    $("#radio_item_suds").css("color", "#bbbbb");
    $("#radio_item_suds").css(
      "background",
      "#EAECF0"
    );

    $("#radio_item_sterile").css("color", "black");
    $("#radio_item_sterile").css("background", "");
    $("#radio_history_request").css("color", "black");
    $("#radio_history_request").css("background", "");

    $("#item_sterile").hide();
    $("#item_suds").show();
    $("#history_request").hide();
    $("#row_report").attr('hidden',true);

    show_detail_item_suds();

    $("#btn_create_sendsterile").attr("hidden", true);
    // $("#btn_create_sendsterile_sud").attr('hidden',false);
  });

  $("#radio_history_request").click(function () {
    $("#radio_history_request").css("color", "#bbbbb");
    $("#radio_history_request").css(
      "background",
      "#EAECF0"
    );

    $("#radio_item_sterile").css("color", "black");
    $("#radio_item_sterile").css("background", "");
    $("#radio_item_suds").css("color", "black");
    $("#radio_item_suds").css("background", "");

    $("#btn_create_sendsterile").attr("hidden", true);

    $("#item_sterile").hide();
    $("#item_suds").hide();
    $("#history_request").show();
    $("#row_report").attr('hidden',false);

      show_detail_history();
  });

  $("#select_date1").val(set_date());
  $("#select_date1").datepicker({
    onSelect: function (date) {
      show_detail_item_suds();
      show_detail_history();
    },
  });

  $("#select_date2").val(set_date());
  $("#select_date2").datepicker({
    onSelect: function (date) {
      show_detail_item_suds();
      show_detail_history();
    },
  });
});

$("#btn_create_sendsterile").click(function (e) {
  $("#RoundModal").modal('toggle');
});

$("#show_excel").click(function (e) {
  $("#RoundExcelModal").modal('toggle');
});

$("#btn_show_excel").click(function (e) {
  option = "?round=" + $("#round_sent_sterile_excel").val()+"&select_date1=" + $("#select_date1").val()+"&select_date2=" + $("#select_date2").val();
  window.open("report/phpexcel/Report_Send_Sterile.php" + option, "_blank");
});


$("#show_report").click(function (e) {
  $("#RoundReportModal").modal('toggle');
});

$("#btn_show_report").click(function (e) {
  option = "?round=" + $("#round_sent_sterile_report").val()+"&select_date1=" + $("#select_date1").val()+"&select_date2=" + $("#select_date2").val();
  window.open("report/Report_Send_Sterile.php" + option, "_blank");
});


$("#btn_send_sterile").click(function (e) {


  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การส่งไป N Sterile",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
    $("#RoundModal").modal('toggle');
      onconfirm_create_sendsterile();
    }
  });
});



// $("#btn_create_sendsterile_sud").click(function (e) {
//   Swal.fire({
//     title: "ยืนยัน",
//     text: "ยืนยัน การส่งไป N Sterile",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "ยืนยัน",
//     cancelButtonText: "ยกเลิก",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       onconfirm_create_sendsterile_suds();
//     }
//   });
// });

function onconfirm_create_sendsterile() {
  $.ajax({
    url: "process/send-n-sterile.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_create_sendsterile",
      round_sent_sterile: $("#round_sent_sterile").val(),
    },
    success: function (result) {
      show_detail_item_sterile();
    },
  });
}

function onconfirm_create_sendsterile_suds(DocNo) {

  if($("#round_sent_sterile_"+DocNo).val() == 0){
    showDialogFailed('กรุณาเลือกรอบ');
    return;
  }
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การส่งไป N Sterile",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/send-n-sterile.php",
        type: "POST",
        data: {
          FUNC_NAME: "onconfirm_create_sendsterile_suds",
          DocNo: DocNo,
          round_sent_sterile: $("#round_sent_sterile_"+DocNo).val(),


          
        },
        success: function (result) {
          show_detail_item_suds();
        },
      });
    }
  });
}

function show_detail_item_sterile() {
  $.ajax({
    url: "process/send-n-sterile.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_sterile",
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_sterile tbody").html("");

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.check_exp == "ex") {
            var selected_1 = "";
            var selected_2 = "";
            var selected_3 = "selected";
          } else if (value.isClaim == "1" || value.isClaim == "2") {
            var selected_1 = "";
            var selected_2 = "selected";
            var selected_3 = "";
          } else {
            var selected_1 = "selected";
            var selected_2 = "";
            var selected_3 = "";
          }
          var select = ` <select class="form-control f18 select_re " id="select_resteriletype_${value.itemcode}"  onchange='select_resterile("${value.itemcode}")'>
                              <option value="1" ${selected_1}>Sterile Processing</option>    
                              <option value="2" ${selected_2}>Claim</option>    
                              <option value="3" ${selected_3}>Re-Sterile</option>    
                          </select>`;

          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td> ${value.UsageCode} | ${value.itemname}</td>
                      <td class='text-center'>1</td>
                      <td class='text-center' style='width:20%;'>${select}</td>
                      <td class='text-center' style='width:20%;'><input type='text' class="form-control"></td>
                   </tr>`;
        });
      }

      $("#table_item_sterile tbody").html(_tr);
    },
  });
}

function show_detail_history(){
  $.ajax({
    url: "process/send-n-sterile.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date1: $("#select_date1").val(),
      select_date2: $("#select_date2").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item tbody").html("");

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

          var type = 'SUDs';
          if(value.hncode == ''){
            type = 'Sterile ';
          }


          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td class='text-center'>${value.DocNo}</td>
                      <td class='text-center'></td>
                      <td class='text-center'>${type}</td>
                      <td class='text-center'>${value.Doctor_Name}</td>
                      <td class='text-center' >${value.Procedure_TH}</td>
                      <td class='text-center' >${value.hncode}</td>
                      <td class='text-center' >${value.doc_date}</td>
                      <td class='text-center' >${value.doc_time}</td>
                      <td class='text-center' ><label style='color:blue;cursor:pointer;'>แสดงรายละเอียด</label></td>
                      <td class='text-center' >${value.Round}</td>
                      <td class='text-center' ><label style='color:red;cursor:pointer;'>ยกเลิก</label></td>
                   </tr>`;
        });
      }

      $("#table_item tbody").html(_tr);
    },
  });
}

function show_detail_item_suds() {
  $.ajax({
    url: "process/send-n-sterile.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_suds",
      select_date1: $("#select_date1").val(),
      select_date2: $("#select_date2").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_suds tbody").html("");

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["deproom"], function (kay, value) {
          if (value.RefDocNo != null) {
            var ref = value.RefDocNo;
            var option = "";
            var disOption = "disabled";
          } else {
            var ref = `<button class="btn" onclick='onconfirm_create_sendsterile_suds("${value.DocNo}")'   style="color:#fff;background-color:#1570EF;">Create Request</button> `;
            var option = `<option value="0">กรุณาเลือกรอบ</option>`;
            var disOption = "";
          }

          var select1 = "";
          var select2 = "";
          var select3 = "";
          var select4 = "";
          var select5 = "";
          var select6 = "";
          if(value.Round == '1'){
             select1 = "selected";
          }
          if(value.Round == '2'){
             select2 = "selected";
          }
          if(value.Round == '3'){
             select3 = "selected";
          }
          if(value.Round == '4'){
             select4 = "selected";
          }
          if(value.Round == '5'){
             select5 = "selected";
          }
          if(value.Round == '6'){
             select6 = "selected";
          }
          _tr += `<tr id='trbg_${value.DocNo}'>
                      <td class='text-center' >${kay + 1}</td>
                      <td class='text-left'> ${value.hn_record_id}</td>
                      <td class='text-left'>${value.Procedure_TH}</td>
                      <td class='text-center' style='width:10%;'>${
                        value.Doctor_Name
                      }</td>
                      <td class='text-center' style='width:15%;'>  ${ref} </td>
                      <td class='text-center' style='width:10%;'>               <select ${disOption} name="" id="round_sent_sterile_${value.DocNo}" class="form-control">
                                                                                    ${option}
                                                                                    <option value="1" ${select1}>รอบ 1</option>
                                                                                    <option value="2" ${select2}>รอบ 2</option>
                                                                                    <option value="3" ${select3}>รอบ 3</option>
                                                                                    <option value="4" ${select4}>รอบ 4</option>
                                                                                    <option value="5" ${select5}>รอบ 5</option>
                                                                                    <option value="6" ${select6}>รอบ 6</option>
                                                                                </select></td>
                      <td class='text-center'  style='width:10%;'> <i class="fa-solid fa-caret-up" style='font-size:30px;cursor:pointer;' id='open_${
                        value.DocNo
                      }' value='0' onclick='open_deproom_item_sub("${
            value.DocNo
          }")'></i>  </td>
                   </tr>`;

          $.each(ObjData[value.DocNo], function (kay2, value2) {
            var iconD = `<img src="assets/img_project/1_icon/ic_warning.png" style='cursor:pointer;width:4%;' onclick='cancelDamage("${value2.itemname}","${value2.itemcode}","${value2.UsageCode}")'>   `;
            var bg = "style='background-color:#FEE4E2'";
            if (value2.IsDamage != "1") {
              var iconD = `<img src="assets/img_project/1_icon/ic_warning.png" style="cursor:pointer;width:4%;" onclick='open_modalDamage("${value2.itemname}","${value2.itemcode}","${value2.UsageCode}")'></img> `;
              var bg = "";
            }

            _tr += `<tr ${bg} class='tr_${value.DocNo} all111'>
                                  <td class='text-left' colspan="3">${value2.UsageCode} | ${value2.itemname} ${iconD}</td>
                                  <td class='text-center' style='width:10%;'></td>
                                  <td class='text-center' style='width:10%;'></td>
                                  <td class='text-center' style='width:10%;'><input type='text' class="form-control" placeholder="หมายเหตุ"></td>
                                  <td class='text-center' style='width:10%;'></td>


                              </tr>`;
          });
        });
      }

      $("#table_item_suds tbody").html(_tr);
      $(".all111").hide();
    },
  });
}

function cancelDamage(itemname, itemcode, UsageCode){
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การยกเลิกแจ้งชำรุด",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/send-n-sterile.php",
        type: "POST",
        data: {
          FUNC_NAME: "cancelDamage",
          itemcode: itemcode,
          UsageCode: UsageCode,
        },
        success: function (result) {
          show_detail_item_suds();
        },
      });
    }
  });
}

function open_modalDamage(itemname, itemcode, UsageCode) {
  var currentdate = new Date();
  var datetime =
    currentdate.getDate() +
    "/" +
    (currentdate.getMonth() + 1) +
    "/" +
    currentdate.getFullYear() +
    " " +
    currentdate.getHours() +
    ":" +
    currentdate.getMinutes() +
    ":" +
    currentdate.getSeconds();

  $("#input_date_damage").val(datetime);
  $("#input_username_damage").val(UserName);
  $("#input_itemname_damage").val(itemname);
  $("#remark_damage").val("");
  $("#input_itemcode_damage").data("usagecode", UsageCode);

  $("#reportIssueModal").modal("toggle");

  $("#reportIssueModal").modal("toggle");

  $("#image_damage").on("change", function () {
    const file = this.files[0]; // Get the selected file
    if (file) {
      const reader = new FileReader(); // Create a FileReader instance
      reader.onload = function (event) {
        const base64String = event.target.result; // Get the Base64 string
        $("#image64_damage").val(base64String); // Display the Base64 string
        console.log(base64String); // Log to the console
      };
      reader.readAsDataURL(file); // Read the file as a data URL
    } else {
      $("#outputBase64").text("No file selected.");
    }
  });
}

function open_deproom_item_sub(DocNo) {
  if ($("#open_" + DocNo).val() == 1) {
    $("#open_" + DocNo).val(0);
    $("#open_" + DocNo).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + DocNo).hide(300);

    $("#trbg_" + DocNo).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + DocNo).val(1);
    $("#open_" + DocNo).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + DocNo).show(500);

    $("#trbg_" + DocNo).css("background-color", "#EFF8FF");

    // $(".tr_"+id).attr('hidden',false);
  }
}

$("#btn_save_damage").click(function (e) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การแจ้งชำรุด",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_damage();
    }
  });
});

function onconfirm_damage() {
  $.ajax({
    url: "process/send-n-sterile.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_damage",
      input_itemcode_damage: $("#input_itemcode_damage").val(),
      UsageCode: $("#input_itemcode_damage").data("usagecode"),
      remark_damage: $("#remark_damage").val(),
      image64_damage: $("#image64_damage").val(),
    },
    success: function (result) {
      show_detail_item_suds();

      $("#reportIssueModal").modal("toggle");
    },
  });
}

function select_resterile(itemcode) {
  var select = $("#select_resteriletype_" + itemcode).val();
  $(".select_re").val(select);
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
