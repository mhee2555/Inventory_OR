var procedure_id_Array = [];
var doctor_Array = [];

$(function () {
  session();

  $("#history").hide();
  // $("#radio_set_hn").css("color", "#bbbbb");
  // $("#radio_set_hn").css("background", "#EAE1F4");

  var now = new Date();
  var hours = String(now.getHours()).padStart(2, "0");
  var minutes = String(now.getMinutes()).padStart(2, "0");
  var currentTime = hours + ":" + minutes;

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

  $("#input_date_service_manual").val(output);
  $("#input_date_service_manual").datepicker({
    onSelect: function (date) {},
  });

  $("#select_date1_search").val(output);
  $("#select_date1_search").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  $("#select_date2_search").val(output);
  $("#select_date2_search").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  $("#input_time_service_manual").val(currentTime);

  $("#radio_set_hn").click(function () {
      $('.tab-button').removeClass('active');
      $(this).addClass('active');

    $("#set_hn").show();
    $("#history").hide();

    // show_detail_deproom_pay();
  });

  $("#radio_history").click(function () {
      $('.tab-button').removeClass('active');
      $(this).addClass('active');

    $("#set_hn").hide();
    $("#history").show();

    show_detail_history();

    // show_detail_deproom_pay();
  });

  select_doctor();
  select_procedure();
  select_deproom();
  $("#select_doctor_manual").select2();
  $("#select_procedure_manual").select2();
  $("#select_deproom_manual").select2();
});

function show_detail_history() {
  $.ajax({
    url: "process/set_hn.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date1_search: $("#select_date1_search").val(),
      select_date2_search: $("#select_date2_search").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_history tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            var title = '';
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          }else{
            var title = `title='${value.Procedure_TH}' `;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          var hidden = "";
          if (
            value.isStatus == "1" ||
            value.isStatus == "2" ||
            value.isStatus == "3"
          ) {
            var hidden = "hidden";
          }

          _tr += `<tr>
                      <td class="f18 text-center" style='line-height: 35px;'>${kay + 1}</td>
                      <td class="f18 text-center" style='line-height: 35px;'>${value.hncode}</td>
                      <td class="f18 text-center" style='line-height: 35px;'>${value.serviceDate} ${
            value.serviceTime
          }</td>
                      <td class="f18 text-left" style='line-height: 35px;'>${value.Doctor_Name}</td>
                      <td class="f18 text-left" style='line-height: 35px;'>${ value.departmentroomname }</td>
                      <td class="f18 text-left" style="line-height: 35px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 300px;" ${title}>${value.Procedure_TH}</td>
                      <td class="f18 text-center" style='width:10%;'><button ${hidden} class='btn btn-primary' style='width:70%;' onclick='showdetail("${
            value.ID
          }","${value.hncode}","${value.serviceDate}","${value.serviceTime}","${
            value.doctor
          }","${value.procedure}","${value.departmentroomid}","${
            value.remark
          }")'>แก้ไข</button></td>
                   </tr>`;
        });
      }

      $("#table_history tbody").html(_tr);
    },
  });
}

function showdetail(
  ID,
  hncode,
  serviceDate,
  serviceTime,
  doctor,
  procedure,
  departmentroomid,
  remark
) {
  // $(".clear_doctor").attr("hidden", true);
  // doctor_Array = [];

  // $("#select_deproom_request").val("");
  // $("#select2-select_deproom_request-container").text("กรุณาเลือกห้องผ่าตัด");

  // $("#select_procedure_request").val("");
  // $("#select2-select_procedure_request-container").text("กรุณาเลือกหัตถการ");
  // $(".clear_procedure").attr("hidden", true);
  // procedure_id_Array = [];
  $("#radio_set_hn").click();

  $("#input_Hn_pay_manual").val(hncode);
  $("#input_Hn_ID").val(ID);
  $("#input_date_service_manual").val(serviceDate);
  $("#input_time_service_manual").val(serviceTime);
  $("#select_deproom_manual").val(departmentroomid).trigger("change");
  $("#input_remark_manual").val(remark);

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_Doctor",
      doctor: doctor,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _row = "";
        $.each(ObjData, function (kay, value) {
          doctor_Array.push(value.ID.toString());
          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='DeleteDoctor(${value.ID})'>
                              <label for="" class="custom-label">${value.Doctor_Name}</label>
                          </div> `;
        });
        $("#row_doctor").append(_row);
      }
    },
  });

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_Procedure",
      procedure: procedure,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _row = "";
        $.each(ObjData, function (kay, value) {
          procedure_id_Array.push(value.ID.toString());

          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='DeleteDoctor(${value.ID})'>
                              <label for="" class="custom-label">${value.Procedure_TH}</label>
                          </div> `;
        });

        $("#row_procedure").append(_row);
      }
    },
  });
}

$("#select_deproom_manual").change(function () {
  set_proceduce($("#select_deproom_manual").val());
  set_doctor($("#select_deproom_manual").val());
});

$("#select_doctor_manual").on("select2:select", function (e) {
  var selectedValue = e.params.data.id; // ดึงค่า value
  var selectedText = e.params.data.text; // ดึงค่า text
  if (selectedValue != "") {
    var index = doctor_Array.indexOf(selectedValue);
    if (index == -1) {
      doctor_Array.push(selectedValue);
      var _row = "";
      _row += `       <div  class='div_${selectedValue}  clear_doctor' onclick='DeleteDoctor(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

      $("#row_doctor").append(_row);

      if ($("#select_deproom_manual").val() == "") {
        set_deproom();
      }
    }
  }
  $("#select_doctor_manual").val("").trigger("change");
});

$("#select_procedure_manual").on("select2:select", function (e) {
  var selectedValue = e.params.data.id; // ดึงค่า value
  var selectedText = e.params.data.text; // ดึงค่า text
  if (selectedValue != "") {
    var index = procedure_id_Array.indexOf(selectedValue);
    if (index == -1) {
      procedure_id_Array.push(selectedValue);
      var _row = "";
      _row += `       <div  class='div_${selectedValue} clear_procedure' onclick='Deletprocedure(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

      $("#row_procedure").append(_row);

      if ($("#select_deproom_manual").val() == "") {
        set_deproom_proceduce();
      }
    }
  }
  $("#select_procedure_manual").val("").trigger("change");
});

$("#btn_clear_manual").click(function () {
  var now = new Date();
  var hours = String(now.getHours()).padStart(2, "0");
  var minutes = String(now.getMinutes()).padStart(2, "0");
  var currentTime = hours + ":" + minutes;

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

  $("#input_Hn_ID").val("");
  $("#input_Hn_pay_manual").val("");
  $("#input_date_service_manual").val(output);
  $("#input_time_service_manual").val(currentTime);

  $("#select_doctor_manual").val("").trigger("change");
  $("#select_deproom_manual").val("").trigger("change");
  $("#select_procedure_manual").val("").trigger("change");

  $("#input_remark_manual").val("");

  $(".clear_doctor").attr("hidden", true);
  doctor_Array = [];
  $(".clear_procedure").attr("hidden", true);
  procedure_id_Array = [];
});

$("#btn_save_hn_manual").click(function () {
  if ($("#input_Hn_pay_manual").val() == "") {
    showDialogFailed("กรุณากรอก เลขประจำตัวคนไข้");
    return;
  }
  if ($("#input_date_service_manual").val() == "") {
    showDialogFailed("กรุณากรอก วันที่");
    return;
  }
  if (doctor_Array.length === 0) {
    showDialogFailed("กรุณาเลือกแพทย์");
    return;
  }
  if ($("#select_deproom_manual").val() == "") {
    showDialogFailed("กรุณาเลือกห้องตรวจ");
    return;
  }
  if (procedure_id_Array.length === 0) {
    showDialogFailed("กรุณาเลือกหัตถการ");
    return;
  }

  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การบันทึก HN ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/set_hn.php",
        type: "POST",
        data: {
          FUNC_NAME: "save_hn",
          input_Hn_ID: $("#input_Hn_ID").val(),
          input_Hn_pay_manual: $("#input_Hn_pay_manual").val(),
          input_date_service_manual: $("#input_date_service_manual").val(),
          input_time_service_manual: $("#input_time_service_manual").val(),
          input_remark_manual: $("#input_remark_manual").val(),
          select_deproom_manual: $("#select_deproom_manual").val(),
          procedure_id_Array: procedure_id_Array,
          doctor_Array: doctor_Array,
        },
        success: function (result) {
          var now = new Date();
          var hours = String(now.getHours()).padStart(2, "0");
          var minutes = String(now.getMinutes()).padStart(2, "0");
          var currentTime = hours + ":" + minutes;

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

          $("#input_Hn_ID").val("");
          $("#input_Hn_pay_manual").val("");
          // $("#input_date_service_manual").val(output);
          $('#input_date_service_manual').data('datepicker').selectDate(new Date());
          $("#input_time_service_manual").val(currentTime);

          $("#select_doctor_manual").val("").trigger("change");
          $("#select_deproom_manual").val("").trigger("change");
          $("#select_procedure_manual").val("").trigger("change");

          $("#input_remark_manual").val("");

          $(".clear_doctor").attr("hidden", true);
          doctor_Array = [];
          $(".clear_procedure").attr("hidden", true);
          procedure_id_Array = [];
        },
      });
    }
  });
});

function DeleteDoctor(selectedValue) {
  var index = doctor_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    doctor_Array.splice(index, 1);
  }

  console.log(doctor_Array);
  $(".div_" + selectedValue).attr("hidden", true);

  // if($("#select_deproom_request").val() == ""){
  set_deproom();
  select_doctor();
  select_procedure();

  $(".clear_procedure").attr("hidden", true);

  $("#btn_routine").attr("disabled", false);
  procedure_id_Array = [];
  // }
  show_detail_history();
}

function Deletprocedure(selectedValue) {
  var index = procedure_id_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    procedure_id_Array.splice(index, 1);
  }

  $("#btn_routine").attr("disabled", false);
  console.log(procedure_id_Array);
  $(".div_" + selectedValue).attr("hidden", true);
}

function set_doctor(select_deproom_request) {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_doctor",
      select_deproom_request: select_deproom_request,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกแพทย์</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Doctor_Name}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_doctor_manual").html(option);
    },
  });
}

function set_proceduce(select_deproom_request) {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_proceduce",
      select_deproom_request: select_deproom_request,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกหัตถการ</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Procedure_TH}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_procedure_manual").html(option);
    },
  });
}

function set_deproom() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom",
      doctor_Array: doctor_Array,
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
      $("#select_deproom_manual").html(option);
    },
  });
}

function set_deproom_proceduce() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom_proceduce",
      procedure_id_Array: procedure_id_Array,
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
      $("#select_deproom_manual").html(option);
    },
  });
}

function select_procedure() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_procedure",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกหัตถการ</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Procedure_TH}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_procedure_manual").html(option);
    },
  });
}
function select_doctor() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_doctor",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกแพทย์</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.Doctor_Name}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_doctor_manual").html(option);
    },
  });
}
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
      $("#select_deproom_manual").html(option);
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

function showDialogFailed(text) {
  Swal.fire({
    title: settext("alert_fail"),
    text: text,
    icon: "error",
  });
}

function settext(key) {
  if (localStorage.lang == "en") {
    return en[key];
  } else {
    return th[key];
  }
}
