$(function () {


  session();

  $("#row_refrain").hide();
  $("#radio_daily").css("color", "#bbbbb");
  $("#radio_daily").css("background", "#EAE1F4");

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

  $("#select_date1_search1").val(output);
  $("#select_date1_search1").datepicker({
    onSelect: function (date) {
      show_detail_daily();
    },
  });

  $("#select_date1_search2").val(output);
  $("#select_date1_search2").datepicker({
    onSelect: function (date) {
      show_detail_refrain();
    },
  });

  show_detail_daily();
  $("#radio_daily").click(function () {
    $("#radio_daily").css("color", "#bbbbb");
    $("#radio_daily").css("background", "#EAE1F4");

    $("#radio_refrain").css("color", "black");
    $("#radio_refrain").css("background", "");

    $("#row_daily").show();
    $("#row_refrain").hide();
    show_detail_daily();
  });

  $("#radio_refrain").click(function () {
    $("#radio_refrain").css("color", "#bbbbb");
    $("#radio_refrain").css("background", "#EAE1F4");

    $("#radio_daily").css("color", "black");
    $("#radio_daily").css("background", "");

    $("#row_refrain").show();
    $("#row_daily").hide();

    show_detail_refrain();
  });
});

function show_detail_refrain() {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_refrain",
      select_date1_search2: $("#select_date1_search2").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_refrain tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          _tr += `<tr>
                      <td class="f18 text-center">${value.hncode}</td>
                      <td class="f18 text-center">${value.serviceDate} ${value.serviceTime}</td>
                      <td class="f18 text-center">${value.Doctor_Name}</td>
                      <td class="f18 text-center">${value.departmentroomname}</td>
                      <td class="f18 text-center">${value.Procedure_TH}</td>
                      <td class="f18 text-center"><a  href="#" style='font-weight: bold;color:#643695;' onclick='update_daily(${value.ID})'>สร้างเอกสาร</a></td>
                      <td class="f18 text-center"><a  href="#" style='font-weight: bold;color:#e74a3b;' onclick='update_cancel(${value.ID})'>ยกเลิก</a></td>
                   </tr>`;
        });
      }

      $("#table_refrain tbody").html(_tr);
    },
  });
}

function update_cancel(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การยกเลิก ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_cancel",
          ID: ID,
        },
        success: function (result) {
          show_detail_refrain();
        },
      });
    }
  });
}

function update_daily(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การสร้างเอกสาร ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_daily",
          ID: ID,
        },
        success: function (result) {
          show_detail_refrain();
        },
      });
    }
  });
}

function show_detail_daily() {
  $.ajax({
    url: "process/hn_daily.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_daily",
      select_date1_search1: $("#select_date1_search1").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_daily tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          var x  ="";
          if (value.isStatus == "0") {
            var txt = `<a  href="#" style='font-weight: bold;color:#643695;' onclick='update_create_request(${value.ID})'>รอดำเนินการ</a>`;
          }
          if (value.isStatus == "1" || value.isStatus == "2") {
            var txt = `<a  href="#" style='font-weight: bold;color:#1cc88a;' )'>ดำเนินการเรียบร้อย</a>`;
            x  ="hidden";
          }
          _tr += `<tr>
                      <td class="f18 text-center">${value.hncode}</td>
                      <td class="f18 text-center">${value.serviceDate} ${value.serviceTime}</td>
                      <td class="f18 text-center">${value.Doctor_Name}</td>
                      <td class="f18 text-center">${value.departmentroomname}</td>
                      <td class="f18 text-center">${value.Procedure_TH}</td>
                      <td class="f18 text-center">${txt}</td>
                      <td class="f18 text-center"><a ${x}  href="#" style='font-weight: bold;color:#e74a3b;' onclick='update_refrain(${value.ID})'>งด</a></td>
                   </tr>`;
        });
      }

      $("#table_daily tbody").html(_tr);
    },
  });
}

function update_create_request(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การไปหน้าสร้างใบขอเบิกอุปกรณ์ ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_create_request",
          ID: ID,
        },
        success: function (result) {
            var link = "pages/create_request.php";
            $.get(link, function (res) {
              $(".nav-item").removeClass("active");
              $(".nav-item").css("background-color", "");

              $("#ic_mainpage").attr("src", "assets/img_project/2_icon/ic_mainpage.png");
              $("#menu1").css("color", "#667085");

              $("#conMain").html(res);
              history.pushState({}, "Results for `Cats`", "index.php?s=create_request");
              document.title = "create_request";

              loadScript("script-function/create_request.js");
              loadScript('assets/lang/create_request.js');
              
            });
        },
      });
    }
  });
}

function loadScript(url) {
  const script = document.createElement('script');
  script.src = url;
  script.type = 'text/javascript';
  script.onload = function() {
      // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
}

function update_refrain(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การงด ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/hn_daily.php",
        type: "POST",
        data: {
          FUNC_NAME: "update_refrain",
          ID: ID,
        },
        success: function (result) {
          show_detail_daily();
        },
      });
    }
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
