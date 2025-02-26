var departmentroomname = "";
var UserName = "";
$(function () {
  show_detail_deproom();
  show_detail_item_save();
  session();

  $("#table_item").hide();

  $("#radio_viewdeproom").css("color", "#bbbbb");
  $("#radio_viewdeproom").css(
    "background",
    "#EAECF0"
  );

  $("#radio_viewdeproom").click(function () {
    $("#radio_viewdeproom").css("color", "#bbbbb");
    $("#radio_viewdeproom").css(
      "background",
      "#EAECF0"
    );

    $("#radio_viewallitem").css("color", "black");
    $("#radio_viewallitem").css("background", "");

    $("#table_deproom").show();
    $("#table_item").hide();

    $("#check_radio").val(1);

    show_detail_deproom();
  });

  $("#radio_viewallitem").click(function () {
    $("#radio_viewallitem").css("color", "#bbbbb");
    $("#radio_viewallitem").css(
      "background",
      "#EAECF0"
    );

    $("#radio_viewdeproom").css("color", "black");
    $("#radio_viewdeproom").css("background", "");

    $("#table_deproom").hide();
    $("#table_item").show();

    $("#check_radio").val(2);

    show_detail_item();
  });
});

$("#btn_wait_receive").click(function (e) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การรับอุปกรณ์ใช้แล้ว",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_receive();
    }
  });
});

$("#btn_cancel").click(function (e) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การยกเลิก",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_cancel();
    }
  });
});

$("#btn_send").click(function (e) {
  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "checkNSterile",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $.each(ObjData, function(kay, value) {

        if (value.qty != "0") {
          showDialogFailed("มีอุปกรณ์รอส่ง Create Request");
        } else {
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
              onconfirm_send();
            }
          });
        }
        
      });

    },
  });
});

function onconfirm_send() {
  showLoading();

  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_send",
    },
    success: function (result) {
      showDialogSuccess("ยืนยัน การส่งไปNsterile สำเร็จ");
      $("body").loadingModal("destroy");

      if (result == "0") {
        show_detail_item_save();

        if ($("#check_radio").val() == 1) {
          show_detail_deproom();
        } else {
          show_detail_item();
        }
      }
    },
  });
}
function onconfirm_cancel() {
  showLoading();

  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_cancel",
    },
    success: function (result) {
      showDialogSuccess("ยืนยัน การยกเลิก สำเร็จ");
      $("body").loadingModal("destroy");

      if (result == "0") {
        show_detail_item_save();

        if ($("#check_radio").val() == 1) {
          show_detail_deproom();
        } else {
          show_detail_item();
        }
      }
    },
  });
}

function onconfirm_receive() {
  var itemCodeArray = [];
  var qtyArray = [];
  var deproomArray = [];

  $(".checkbox_itemcode:checked").each(function () {
    itemCodeArray.push($(this).val()); // Get value of the checkbox
    deproomArray.push($(this).data("deproom")); // Get value of the checkbox
    qtyArray.push(
      $("#qty_" + $(this).val() + "_" + $(this).data("deproom")).val()
    ); // Get value of the checkbox
  });

  // console.log(deproomArray);
  showLoading();

  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_receive",
      itemCodeArray: itemCodeArray,
      qtyArray: qtyArray,
      deproomArray: deproomArray,
      check_radio: $("#check_radio").val(),
    },
    success: function (result) {
      showDialogSuccess("ยืนยัน การรับอุปกรณ์ใช้แล้ว สำเร็จ");
      $("body").loadingModal("destroy");
      if (result == "0") {
        show_detail_item_save();

        if ($("#check_radio").val() == 1) {
          show_detail_deproom();
        } else {
          show_detail_item();
        }
      }
    },
  });
}

function show_detail_item_save() {
  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_save",
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_save tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value2) {
          var iconD = `<img src="assets/img_project/1_icon/ic_warning.png" style='cursor:pointer;width:40%;' onclick='cancelDamage("${value2.itemname}","${value2.itemcode}","${value2.UsageCode}")'>   `;
          var bg = "style='background-color:#ed1c24'";
          if (value2.IsDamage != "1") {
            var iconD = `<img src="assets/img_project/1_icon/ic_warning.png" style='cursor:pointer;width:40%;' onclick='open_modalDamage("${value2.itemname}","${value2.itemcode}","${value2.UsageCode}")'>   `;
            var bg = "";
          }

          var typename = "";
          if (value2.TyeName == "SUDs") {
            typename = "danger";
          }
          if (value2.TyeName == "OR Implant") {
            typename = "primary";
          }
          if (value2.TyeName == "Sterile") {
            typename = "success";
          }


          _tr += `<tr ${bg}>
                          <td> 
                          
                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">${value2.itemname}</span>
                                    <button class="btn btn-outline-${typename} btn-sm" disabled>${value2.TyeName}</button>
                                  </div>
                          
                          
                          </td>
                          <td class='text-center'> ${value2.UsageCode}</td>
                          <td class='text-center'>1</td>
                          <td class='text-center'>${iconD}</td>
                          
                        </tr>`;
        });
      }

      $("#table_item_save tbody").html(_tr);
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
        url: "process/receive_dirty.php",
        type: "POST",
        data: {
          FUNC_NAME: "cancelDamage",
          itemcode: itemcode,
          UsageCode: UsageCode,
        },
        success: function (result) {
          show_detail_item_save();
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
  $("#image_damage").val(null);
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
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_damage",
      input_itemcode_damage: $("#input_itemcode_damage").val(),
      UsageCode: $("#input_itemcode_damage").data("usagecode"),
      remark_damage: $("#remark_damage").val(),
      image64_damage: $("#image64_damage").val(),
    },
    success: function (result) {
      // showDialogSuccess("ยืนยัน การส่งไปNsterile สำเร็จ");
      // $('body').loadingModal('destroy');

      // if (result == "0") {
      show_detail_item_save();

      $("#reportIssueModal").modal("toggle");

      //   if($("#check_radio").val() == 1){
      //     show_detail_deproom();
      //   }else{
      //     show_detail_item();
      //   }
      // }
    },
  });
}

function show_detail_item() {
  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item",
    },
    success: function (result) {
      var _tr = "";
      $("#table_item tbody").html("");
      $("#table_deproom tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value2) {
          var typename = "";

          if (value2.TyeName == "SUDs") {
            typename = "danger";
          }
          if (value2.TyeName == "OR Implant") {
            typename = "primary";
          }
          if (value2.TyeName == "Sterile") {
            typename = "success";
          }

          _tr += `<tr>
                          <td><input style="width: 25px;height: 25px;" class="clear_checkbox checkbox_itemcode" value="${value2.itemcode}" data-deproom="0" type="checkbox" ></td>
                          <td> 
                          


                                                            <div class="d-flex align-items-center">
                                                              <span class="mr-2">${value2.itemname}</span>
                                                              <button class="btn btn-outline-${typename} btn-sm" disabled>${value2.TyeName}</button>
                                                            </div>
                          
                          </td>
                          <td class='text-center'> <input type='text' value="${value2.count_item}" class='form-control text-center' id="qty_${value2.itemcode}_0">   </td>
                        </tr>`;
        });
      }

      $("#table_item tbody").html(_tr);
    },
  });
}

function show_detail_deproom() {
  $.ajax({
    url: "process/receive_dirty.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_deproom",
    },
    success: function (result) {
      var _tr = "";
      $("#table_item tbody").html("");
      $("#table_deproom tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["departmentroomname"], function (kay, value) {
          _tr += `<tr id='trbg_${value.id}'>
                      <td class="f24"><i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;' id='open_${value.id}' value='0' onclick='open_deproom_item_sub(${value.id})'></i></td>
                      <td class="f24">${value.departmentroomname}</td>
                      <td class='text-center'></td>
                   </tr>`;

          $.each(ObjData[value.id], function (kay, value2) {
            var typename = "";

            if (value2.TyeName == "SUDs") {
              typename = "danger";
            }
            if (value2.TyeName == "OR Implant") {
              typename = "primary";
            }
            if (value2.TyeName == "Sterile") {
              typename = "success";
            }

            _tr += `<tr class='tr_${value.id} all111' >
                              <td></td>
                          <td>    
                              <div class='row'>
                                  <div class='col-md-1'>
                                    <input style="width: 25px;height: 25px;" class="clear_checkbox checkbox_itemcode"  value="${value2.itemcode}" data-deproom="${value.id}" type="checkbox" >
                                  </div>
                                  <div class='col-md-11'>
                                      <div class="d-flex align-items-center">
                                        <span class="mr-2">${value2.itemname}</span>
                                        <button class="btn btn-outline-${typename} btn-sm" disabled>${value2.TyeName}</button>
                                     </div>
                                  </div>
                              </div>
                                  


                          </td>
                          <td class='text-center'> <input type='text' value="${value2.count_item}" class='form-control text-center' id="qty_${value2.itemcode}_${value.id}">   </td>
                        </tr>`;
          });
        });
      }

      $("#table_deproom tbody").html(_tr);

      $(".all111").hide();
    },
  });
}

function open_deproom_item_sub(id) {
  if ($("#open_" + id).val() == 1) {
    $("#open_" + id).val(0);
    $("#open_" + id).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + id).hide(300);

    $("#trbg_" + id).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + id).val(1);
    $("#open_" + id).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + id).show(500);

    $("#trbg_" + id).css("background-color", "#EFF8FF");

    // $(".tr_"+id).attr('hidden',false);
  }
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
