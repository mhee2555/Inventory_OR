var procedure_id_Array = [];
var doctor_Array = [];
var deproom_Array = [];

$(function () {
  click_main();
  click_menu();
  session();





});

function click_main() {
  $("#row_mapping").hide();

  $("#manage").css("color", "#bbbbb");
  $("#manage").css("background", "#EAECF0");

  $("#manage").click(function () {
    $("#manage").css("color", "#bbbbb");
    $("#manage").css("background", "#EAECF0");

    $("#mapping").css("color", "black");
    $("#mapping").css("background", "");
    $("#row_manage").show();
    $("#row_mapping").hide();
  });

  $("#mapping").click(function () {
    $("#mapping").css("color", "#bbbbb");
    $("#mapping").css("background", "#EAECF0");

    $("#manage").css("color", "black");
    $("#manage").css("background", "");
    $("#row_manage").hide();
    $("#row_mapping").show();

    select_deproom();
    select_procedure();
    select_doctor();
  
    $(".select2").select2();
  
  
    show_detail_doctor();
    show_detail_deproom();

    
  });
}

function click_menu() {
  $("#row_procedure_").hide();
  $("#row_deproom_").hide();
  $("#row_users").hide();

  $("#radio1").css("color", "#bbbbb");
  $("#radio1").css("background", "#EAECF0");

  feeddata_detailDoctor();

  $("#radio1").click(function () {
    $("#radio1").css("color", "#bbbbb");
    $("#radio1").css("background", "#EAECF0");

    $("#radio2").css("color", "black");
    $("#radio2").css("background", "");
    $("#radio3").css("color", "black");
    $("#radio3").css("background", "");
    $("#radio4").css("color", "black");
    $("#radio4").css("background", "");

    $("#row_doctor").show();
    $("#row_procedure_").hide();
    $("#row_deproom_").hide();
    $("#row_users").hide();

    feeddata_detailDoctor();
  });

  $("#radio2").click(function () {
    $("#radio2").css("color", "#bbbbb");
    $("#radio2").css("background", "#EAECF0");

    $("#radio1").css("color", "black");
    $("#radio1").css("background", "");
    $("#radio3").css("color", "black");
    $("#radio3").css("background", "");
    $("#radio4").css("color", "black");
    $("#radio4").css("background", "");

    $("#row_doctor").hide();
    $("#row_procedure_").show();
    $("#row_deproom_").hide();
    $("#row_users").hide();

    feeddata_detailProcedure();
  });

  $("#radio3").click(function () {
    $("#radio3").css("color", "#bbbbb");
    $("#radio3").css("background", "#EAECF0");

    $("#radio2").css("color", "black");
    $("#radio2").css("background", "");
    $("#radio1").css("color", "black");
    $("#radio1").css("background", "");
    $("#radio4").css("color", "black");
    $("#radio4").css("background", "");

    $("#row_doctor").hide();
    $("#row_procedure_").hide();
    $("#row_deproom_").show();
    $("#row_users").hide();

    select_floor();
    feeddata_detailDeproom();
  });

  $("#radio4").click(function () {
    $("#radio4").css("color", "#bbbbb");
    $("#radio4").css("background", "#EAECF0");

    $("#radio2").css("color", "black");
    $("#radio2").css("background", "");
    $("#radio3").css("color", "black");
    $("#radio3").css("background", "");
    $("#radio1").css("color", "black");
    $("#radio1").css("background", "");

    $("#row_doctor").hide();
    $("#row_procedure_").hide();
    $("#row_deproom_").hide();
    $("#row_users").show();
    feeddata_detailUser();
  });
}

// ================================================
$("#btn_saveDoctor").click(function () {
  if ($("#input_doctorth").val() == "") {
    showDialogFailed("กรุณาเลือกแพทย์");
    return;
  }
  saveDoctor();
});
function saveDoctor() {

  if ($("#radio_statusDoctor1").is(":checked")) {
    var IsActive = 0;
  } else {
    var IsActive = 1;
  }


  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "saveDoctor",
      input_doctorth: $("#input_doctorth").val(),
      input_IDdoctor: $("#input_IDdoctor").val(),
      IsActive: IsActive,
    },
    success: function (result) {
      showDialogSuccess(result);
      feeddata_detailDoctor();
      showDialogSuccess("บันทึกสำเร็จ");
      $("#input_doctorth").val("");
      $("#input_IDdoctor").val("");
    },
  });
}
function editDoctor(ID, Doctor_Name,IsCancel) {
  $("#input_doctorth").val(Doctor_Name);
  $("#input_IDdoctor").val(ID);

  if (IsCancel == "0") {
    $("#radio_statusDoctor1").prop("checked", true);
  } else {
    $("#radio_statusDoctor2").prop("checked", true);
  }

}

function deleteDoctor(ID) {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยันการลบแพทย์",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "deleteDoctor",
          ID: ID,
        },
        success: function (result) {
          showDialogSuccess("ลบสำเร็จ");
          feeddata_detailDoctor();
        },
      });
    }
  });
}
$("#btn_clearDoctor").click(function () {
  $("#input_doctorth").val("");
  $("#input_IDdoctor").val("");
});
function feeddata_detailDoctor() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_detailDoctor",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      $("#table_detailDoctor").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr> 
                      <td class="text-center">${kay + 1}</td>
                      <td class="text-left">${value.Doctor_Name}</td>
                      <td class="text-center"><label style='color:blue;font-weight:bold;cursor:pointer;' onclick='editDoctor("${
                        value.ID
                      }","${value.Doctor_Name}","${value.IsCancel}")'>แก้ไข</label> | <label style='color:red;font-weight:bold;cursor:pointer;' onclick='deleteDoctor(${
            value.ID
          })'>ลบ</label></td>
                       </tr>`;
        });
      }
      $("#table_detailDoctor tbody").html(_tr);
      $("#table_detailDoctor ").DataTable({
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
          search: settext("btn_Search"),
        },
        columnDefs: [
          {
            width: "10%",
            targets: 0,
          },
          {
            width: "70%",
            targets: 1,
          },
          {
            width: "20%",
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
// ================================================

// ================================================

$("#btn_saveProcedure").click(function () {
  if ($("#input_Procedure").val() == "") {
    showDialogFailed("กรุณาเลือกหัตถการ");
    return;
  }
  saveProcedure();
});

function saveProcedure() {

  if ($("#radio_statusProcedure1").is(":checked")) {
    var IsActive = 1;
  } else {
    var IsActive = 0;
  }

  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "saveProcedure",
      input_Procedure: $("#input_Procedure").val(),
      input_IDProcedure: $("#input_IDProcedure").val(),
      IsActive: IsActive,
    },
    success: function (result) {
      showDialogSuccess(result);
      feeddata_detailProcedure();
      showDialogSuccess("บันทึกสำเร็จ");
      $("#input_Procedure").val("");
      $("#input_IDProcedure").val("");
    },
  });
}

function editProcedure(ID, Procedure_TH , IsActive) {
  $("#input_Procedure").val(Procedure_TH);
  $("#input_IDProcedure").val(ID);

  if (IsActive == "1") {
    $("#radio_statusProcedure1").prop("checked", true);
  } else {
    $("#radio_statusProcedure2").prop("checked", true);
  }
}

function deleteProcedure(ID) {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยันการลบหัตถการ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "deleteProcedure",
          ID: ID,
        },
        success: function (result) {
          showDialogSuccess("ลบสำเร็จ");
          feeddata_detailProcedure();
        },
      });
    }
  });
}

$("#btn_clearProcedure").click(function () {
  $("#input_Procedure").val("");
  $("#input_IDProcedure").val("");
});

function feeddata_detailProcedure() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_detailProcedure",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      $("#table_detailProcedure").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-left">${value.Procedure_TH}</td>` +
            `<td class="text-center"><label style='color:blue;font-weight:bold;cursor:pointer;' onclick='editProcedure("${value.ID}","${value.Procedure_TH}","${value.IsActive}")'>แก้ไข</label> | <label style='color:red;font-weight:bold;cursor:pointer;' onclick='deleteProcedure(${value.ID})'>ลบ</label></td>` +
            ` </tr>`;
        });
      }
      $("#table_detailProcedure tbody").html(_tr);
      $("#table_detailProcedure ").DataTable({
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
          search: settext("btn_Search"),
        },
        columnDefs: [
          {
            width: "10%",
            targets: 0,
          },
          {
            width: "70%",
            targets: 1,
          },
          {
            width: "20%",
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
// ================================================

// ================================================
$("#btn_saveUser").click(function () {
  if ($("#input_empcodeUser").val() == "") {
    showDialogFailed("กรุณากรอก รหัสพนักงาน");
    return;
  }
  if ($("#input_nameUser").val() == "") {
    showDialogFailed("กรุณากรอก ชื่อ");
    return;
  }
  if ($("#input_lastUser").val() == "") {
    showDialogFailed("กรุณากรอก นามสกุล");
    return;
  }
  if ($("#input_userName").val() == "") {
    showDialogFailed("กรุณากรอก userName");
    return;
  }
  if ($("#input_passWord").val() == "") {
    showDialogFailed("กรุณากรอก Password");
    return;
  }
  if ($("#input_empcodeUser").val() == "") {
    showDialogFailed("กรุณากรอก รหัสพนักงาน");
    return;
  }
  saveUser();
});
function saveUser() {

  if ($("#radio_statusUser1").is(":checked")) {
    var IsCancel = 0;
  } else {
    var IsCancel = 1;
  }

  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "saveUser",
      input_empcodeUser: $("#input_empcodeUser").val(),
      input_nameUser: $("#input_nameUser").val(),
      input_lastUser: $("#input_lastUser").val(),
      input_userName: $("#input_userName").val(),
      input_passWord: $("#input_passWord").val(),
      input_IDUser: $("#input_IDUser").val(),
      IsCancel: IsCancel,
    },
    success: function (result) {
      showDialogSuccess(result);
      feeddata_detailUser();
      showDialogSuccess("บันทึกสำเร็จ");
      $("#input_empcodeUser").val("");
      $("#input_nameUser").val("");
      $("#input_lastUser").val("");
      $("#input_userName").val("");
      $("#input_passWord").val("");
      $("#input_IDUser").val("");
    },
  });
}
function editUser(
  ID,
  EmpCode,
  FirstName,
  LastName,
  UserName,
  Password,
  IsCancel
) {
  $("#input_empcodeUser").val(EmpCode);
  $("#input_nameUser").val(FirstName);
  $("#input_lastUser").val(LastName);
  $("#input_userName").val(UserName);
  $("#input_passWord").val(Password);
  $("#input_IDUser").val(ID);

  if (IsCancel == "Active") {
    $("#radio_statusUser1").prop("checked", true);
  } else {
    $("#radio_statusUser2").prop("checked", true);
  }
}

function deleteUser(ID, EmpCode) {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยันการลบ Users",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "deleteUser",
          ID: ID,
          EmpCode: EmpCode,
        },
        success: function (result) {
          showDialogSuccess("ลบสำเร็จ");
          feeddata_detailUser();
        },
      });
    }
  });
}
$("#btn_clearUser").click(function () {
  $("#input_empcodeUser").val("");
  $("#input_nameUser").val("");
  $("#input_lastUser").val("");
  $("#input_userName").val("");
  $("#input_passWord").val("");
  $("#input_IDUser").val("");
});
function feeddata_detailUser() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_detailUser",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      $("#table_detailUser").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsCancel == "0") {
            value.IsCancel = "Active";
          } else {
            value.IsCancel = "InActive";
          }

          _tr += `<tr> 
                      <td class="text-center">${kay + 1}</td>
                      <td class="text-left">${value.EmpCode}</td>
                      <td class="text-left">${value.FirstName}</td>
                      <td class="text-left">${value.LastName}</td>
                      <td class="text-left">${value.UserName}</td>
                      <td class="text-left">${value.Password}</td>
                      <td class="text-left">${value.IsCancel}</td>
                      <td class="text-center"><label style='color:blue;font-weight:bold;cursor:pointer;' onclick='editUser("${
                        value.ID
                      }","${value.EmpCode}","${value.FirstName}","${
            value.LastName
          }","${value.UserName}","${value.Password}","${
            value.IsCancel
          }")'>แก้ไข</label> | <label style='color:red;font-weight:bold;cursor:pointer;' onclick='deleteUser(${
            value.ID
          },"${value.EmpCode}")'>ลบ</label></td>
                       </tr>`;
        });
      }
      $("#table_detailUser tbody").html(_tr);
      $("#table_detailUser").DataTable({
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
          search: settext("btn_Search"),
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
          },
          {
            width: "10%",
            targets: 5,
          },
          {
            width: "5%",
            targets: 6,
          },
          {
            width: "20%",
            targets: 7,
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
// ================================================

// =============DEPROOM===================================
$("#btn_saveDeproom").click(function () {
  if ($("#input_DeproomNameTH").val() == "") {
    showDialogFailed("กรุณากรอก ชื่อห้อง ไทย");
    return;
  }
  if ($("#input_DeproomNameEN").val() == "") {
    showDialogFailed("กรุณากรอก ชื่อห้อง อังกฤษ");
    return;
  }
  if ($("#input_DeproomName_sub").val() == "") {
    showDialogFailed("กรุณากรอก ตัวย่อ");
    return;
  }
  
  
  saveDeproom();
});
function saveDeproom() {
  if ($("#radio_statusDeproom1").is(":checked")) {
    var IsActive = 1;
  } else {
    var IsActive = 0;
  }

  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "saveDeproom",
      input_DeproomNameTH: $("#input_DeproomNameTH").val(),
      input_DeproomNameEN: $("#input_DeproomNameEN").val(),
      input_DeproomName_sub: $("#input_DeproomName_sub").val(),
      input_IDDeproom: $("#input_IDDeproom").val(),
      input_DeproomFloor: $("#input_DeproomFloor").val(),
      IsActive: IsActive
    },
    success: function (result) {
      showDialogSuccess(result);
      feeddata_detailDeproom();
      showDialogSuccess("บันทึกสำเร็จ");
      $("#input_DeproomNameTH").val("");
      $("#input_DeproomNameEN").val("");
      $("#input_DeproomName_sub").val("");
      $("#input_IDDeproom").val("");
    },
  });
}
function editDeproom(
  id,
  departmentroomname,
  departmentroomname_EN,
  ID_floor,
  IsActive,
  departmentroomname_sub
) {
  $("#input_DeproomNameTH").val(departmentroomname);
  $("#input_DeproomNameEN").val(departmentroomname_EN);
  $("#input_DeproomName_sub").val(departmentroomname_sub);

  
  $("#input_DeproomFloor").val(ID_floor);
  $("#input_IDDeproom").val(id);

  if (IsActive == "Active") {
    $("#radio_statusDeproom1").prop("checked", true);
  } else {
    $("#radio_statusDeproom2").prop("checked", true);
  }
}

function deleteDeproom(id) {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยันการลบ ห้องผ่าตัด",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "deleteDeproom",
          id: id,
        },
        success: function (result) {
          showDialogSuccess("ลบสำเร็จ");
          feeddata_detailDeproom();
        },
      });
    }
  });
}
$("#btn_clearDeproom").click(function () {
  $("#input_DeproomNameTH").val("");
  $("#input_DeproomNameEN").val("");
  $("#input_IDDeproom").val("");
  $("#input_DeproomName_sub").val("");

  
});
function feeddata_detailDeproom() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_detailDeproom",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var _tr = ``;
      $("#table_detailDeproom").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsActive == "0") {
            value.IsActive = "InActive";
          } else {
            value.IsActive = "Active";
          }

          _tr += `<tr> 
                      <td class="text-center">${kay + 1}</td>
                      <td class="text-left">${value.departmentroomname}</td>
                      <td class="text-left">${value.departmentroomname_EN}</td>
                      <td class="text-left">${value.departmentroomname_sub}</td>
                      <td class="text-center">${value.floor_id}</td>
                      <td class="text-center">${value.IsActive}</td>
                      <td class="text-center"><label style='color:blue;font-weight:bold;cursor:pointer;' onclick='editDeproom("${value.id}","${value.departmentroomname}","${value.departmentroomname_EN}","${value.ID_floor}","${value.IsActive}","${value.departmentroomname_sub}")'>แก้ไข</label> | <label style='color:red;font-weight:bold;cursor:pointer;' onclick='deleteDeproom(${
            value.id
          })'>ลบ</label></td>
                       </tr>`;
        });
      }
      $("#table_detailDeproom tbody").html(_tr);
      $("#table_detailDeproom").DataTable({
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
          search: settext("btn_Search"),
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
          },
          {
            width: "10%",
            targets: 5,
          },
          {
            width: "10%",
            targets: 6,
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
// ================================================

function select_floor() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_floor",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.name_floor}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#input_DeproomFloor").html(option);
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
function loadScript(url) {
  const script = document.createElement("script");
  script.src = url;
  script.type = "text/javascript";
  script.onload = function () {
    // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
}
function settext(key) {
  if (localStorage.lang == "en") {
    return en[key];
  } else {
    return th[key];
  }
}










$("#select_doctor_deproom").change(function () {
  if ($("#select_doctor_deproom").val() != "") {
    $("#select_deproom").attr("disabled", false);
  } else {
    $("#select_deproom").attr("disabled", true);
  }

  select_deproom_doctor();
});

$("#select_deproom").on("select2:select", function (e) {
  var selectedValue = e.params.data.id; // ดึงค่า value
  var selectedText = e.params.data.text; // ดึงค่า text
  if (selectedValue != "") {
    var index = deproom_Array.indexOf(selectedValue);
    if (index == -1) {
      deproom_Array.push(selectedValue);
      var _row = "";
      _row += `       <div  class='div_${selectedValue} pl-3 clear_deproom' onclick='DeleteDeproom(${selectedValue})'>
                            <label for="" class="custom-label">${selectedText}</label>
                        </div> `;

      $("#row_deproom").append(_row);

      $("#select_deproom").val("").trigger("change");
    }
  }
});

function DeleteDeproom(selectedValue) {
  var index = deproom_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    deproom_Array.splice(index,1);
  }

  console.log(deproom_Array);
  $(".div_" + selectedValue).attr("hidden", true);
}

$("#btn_Save_doctor_deproom").click(function () {
  if (deproom_Array.length === 0) {
    showDialogFailed("กรุณาเลือกห้องผ่าตัด");
    return;
  }

  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การส่งข้อมูล ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_save_doctor();
    }
  });
});



function onconfirm_save_doctor() {

  $.ajax({
    url: "process/mapping.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_save_doctor",
      select_doctor_deproom: $("#select_doctor_deproom").val(),
      deproom_Array: deproom_Array,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      showDialogSuccess("บันทึกสำเร็จ");

      setTimeout(() => {
        $("#select_doctor_deproom").val("");
        $("#select2-select_doctor_deproom-container").text("กรุณาเลือกแพทย์");
        $("#select_deproom").attr("disabled", true);
        $("#row_deproom").html("");
        deproom_Array = [];


        show_detail_doctor();
      }, 300);
    },
  });
}

function select_deproom_doctor() {
  $.ajax({
    url: "process/mapping.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_deproom_doctor",
      select_doctor_deproom: $("#select_doctor_deproom").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);

      $("#row_deproom").html("");
      deproom_Array = [];

      if (!$.isEmptyObject(ObjData)) {



        var _row = "";
        $.each(ObjData, function (kay, value) {

            
            deproom_Array.push(value.id.toString());

          _row += `       <div  class='div_${value.id} pl-3 clear_deproom' onclick='DeleteDeproom(${value.id})'>
                                  <label for="" class="custom-label">${value.departmentroomname}</label>
                              </div> `;
        });

        $("#row_deproom").append(_row);

      }else{

      }

    },
  });


}





$("#btn_Clear_doctor_deproom").click(function () {


    $("#select_doctor_deproom").val("");
    $("#select2-select_doctor_deproom-container").text("กรุณาเลือกแพทย์");

    // $("#select_doctor_deproom").val("").triggerHandler("change");
    $("#select_deproom").attr("disabled", true);
    $("#row_deproom").html("");
    deproom_Array = [];
  });






  $("#select_deproom_proceduce").change(function () {
    if ($("#select_deproom_proceduce").val() != "") {
      $("#select_proceduce").attr("disabled", false);
    } else {
      $("#select_proceduce").attr("disabled", true);
    }
  
    select_proceduce_deproom();
  });

  $("#select_proceduce").on("select2:select", function (e) {
    var selectedValue = e.params.data.id; // ดึงค่า value
    var selectedText = e.params.data.text; // ดึงค่า text
    if (selectedValue != "") {
      var index = procedure_id_Array.indexOf(selectedValue);
      if (index == -1) {
        procedure_id_Array.push(selectedValue);
        var _row = "";
        _row += `       <div  class='div_${selectedValue} pl-3 clear_deproom' onclick='Deleteproceduce(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;
  
        $("#row_procedure").append(_row);
        $("#select_proceduce").val("").trigger("change");
      }
    }
  });
  

  function Deleteproceduce(selectedValue) {
    var index = procedure_id_Array.indexOf(String(selectedValue));
    console.log(index);
  
    if (index !== -1) {
        procedure_id_Array.splice(index,1);
    }
  
    console.log(procedure_id_Array);
    $(".div_" + selectedValue).attr("hidden", true);
  }


  $("#btn_Save_deproom_proceduce").click(function () {
    if (procedure_id_Array.length === 0) {
      showDialogFailed("กรุณาเลือกหัตถการ");
      return;
    }
  
    Swal.fire({
      title: "ยืนยัน",
      text: "ยืนยัน! การส่งข้อมูล ?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        onconfirm_save_deproom();
      }
    });
  });

  function onconfirm_save_deproom() {

    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "onconfirm_save_deproom",
        select_deproom_proceduce: $("#select_deproom_proceduce").val(),
        procedure_id_Array: procedure_id_Array,
      },
      success: function (result) {
        var ObjData = JSON.parse(result);
        console.log(ObjData);
  
        showDialogSuccess("บันทึกสำเร็จ");
  
        setTimeout(() => {
          $("#select_deproom_proceduce").val("");
          $("#select2-select_deproom_proceduce-container").text("กรุณาเลือกแพทย์");
          $("#select_proceduce").attr("disabled", true);
          $("#row_procedure").html("");
          procedure_id_Array = [];
          show_detail_deproom();
        }, 300);
      },
    });
  }

  function select_proceduce_deproom() {
    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "select_proceduce_deproom",
        select_deproom_proceduce: $("#select_deproom_proceduce").val(),
      },
      success: function (result) {
        var ObjData = JSON.parse(result);
  
        $("#row_procedure").html("");
        procedure_id_Array = [];
  
        if (!$.isEmptyObject(ObjData)) {
  
  
  
          var _row = "";
          $.each(ObjData, function (kay, value) {
  
              
             procedure_id_Array.push(value.ID.toString());
  
            _row += `       <div  class='div_${value.ID} pl-3 clear_deproom' onclick='Deleteproceduce(${value.ID})'>
                                    <label for="" class="custom-label">${value.Procedure_TH}</label>
                                </div> `;
          });
  
          $("#row_procedure").append(_row);
  
        }else{
  
        }
  
      },
    });
  
  
  }

  $("#btn_Clear_deproom_proceduce").click(function () {
    $("#select_deproom_proceduce").val("");
    $("#select2-select_deproom_proceduce-container").text("กรุณาเลือกแพทย์");
    $("#select_proceduce").attr("disabled", true);
    $("#row_procedure").html("");
    procedure_id_Array = [];
  });
  
  

  function show_detail_doctor() {
    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "show_detail_doctor",
      },
      success: function (result) {
        $("#table_detail_doctor").DataTable().destroy();
        var ObjData = JSON.parse(result);
        console.log(ObjData);
        var _tr = ``;
        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
  
  
            if (value.departmentroomname == "button") {
              value.departmentroomname = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_deproom("${value.departmentroom_id}")'>ห้องผ่าตัด</a>`;
            }

  
  
            _tr +=
              `<tr > ` +
              `<td class="text-center">${value.Doctor_Name}</td>` +
              `<td class="text-center" >${value.departmentroomname}</td>` +
              `<td class="text-center" > <button class='btn btn-danger' style='color: #fff;font-size:20px;' onclick='delete_doctor(${value.doctor_id})'>ลบ</button> </td>` +
              `<td class="text-center"> <button class='btn' style='color: #fff;background: #1570EF;font-size:20px;' onclick='edit_doctor(${value.doctor_id})'>แก้ไข</button> </td>` +
              ` </tr>`;
          });
        } else {
        }
        $("#table_detail_doctor tbody").html(_tr);
        $("#table_detail_doctor ").DataTable({
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
              width: "30%",
              targets: 0,
            },
            {
              width: "30%",
              targets: 1,
            },
            {
              width: "10%",
              targets: 2,
            },
            {
              width: "10%",
              targets: 3,
            }
          ],
          info: false,
          scrollX: false,
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


  
  function delete_doctor(doctor_id){

    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "delete_doctor",
        doctor_id: doctor_id,
      },
      success: function (result) {
        var ObjData = JSON.parse(result);
        console.log(ObjData);
  
        showDialogSuccess("ลบสำเร็จ");
        show_detail_doctor();

      },
    });

  
  }


  function edit_doctor(doctor_id){
    $('#select_doctor_deproom').val(doctor_id).trigger('change');
  }


  function showDetail_deproom(departmentroom_id) {
    $("#showDetail_deproom").modal("toggle");
  
    $.ajax({
      url: "process/pay.php",
      type: "POST",
      data: {
        FUNC_NAME: "showDetail_deproom",
        departmentroom_id: departmentroom_id,
      },
      success: function (result) {
        // $("#table_item_claim").DataTable().destroy();
        $("#table_detail_deproom_modal tbody").html("");
        var ObjData = JSON.parse(result);
        if (!$.isEmptyObject(ObjData)) {
          var _tr = ``;
          var allpage = 0;
          $.each(ObjData, function (kay, value) {
            _tr += `<tr>
                <td class="text-center">${kay + 1}</td>
                <td class="text-left">${value.departmentroomname}</td>
              </tr>`;
          });
  
          $("#table_detail_deproom_modal tbody").html(_tr);
        }
      },
    });
  }


  function show_detail_deproom() {
    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "show_detail_deproom",
      },
      success: function (result) {
        $("#table_detail_deproom").DataTable().destroy();
        var ObjData = JSON.parse(result);
        console.log(ObjData);
        var _tr = ``;
        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
  
  
            if (value.Procedure_TH == "button") {
                value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure_id}")'>หัตถการ</a>`;
              }

  
  
            _tr +=
              `<tr > ` +
              `<td class="text-center">${value.departmentroomname}</td>` +
              `<td class="text-center" >${value.Procedure_TH}</td>` +
              `<td class="text-center" > <button class='btn btn-danger' style='color: #fff;font-size:20px;' onclick='delete_deproom(${value.departmentroom_id})'>ลบ</button> </td>` +
              `<td class="text-center"> <button class='btn' style='color: #fff;background: #1570EF;font-size:20px;' onclick='edit_deproom(${value.departmentroom_id})'>แก้ไข</button> </td>` +
              ` </tr>`;
          });
        } else {
        }
        $("#table_detail_deproom tbody").html(_tr);
        $("#table_detail_deproom ").DataTable({
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
              width: "30%",
              targets: 0,
            },
            {
              width: "30%",
              targets: 1,
            },
            {
              width: "10%",
              targets: 2,
            },
            {
              width: "10%",
              targets: 3,
            }
          ],
          info: false,
          scrollX: false,
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

  
  function delete_deproom(departmentroom_id){

    $.ajax({
      url: "process/mapping.php",
      type: "POST",
      data: {
        FUNC_NAME: "delete_deproom",
        departmentroom_id: departmentroom_id,
      },
      success: function (result) {
        var ObjData = JSON.parse(result);
        console.log(ObjData);
  
        showDialogSuccess("ลบสำเร็จ");
        show_detail_deproom();

      },
    });

  
  }

  function edit_deproom(departmentroom_id){
    $('#select_deproom_proceduce').val(departmentroom_id).trigger('change');

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
      $("#select_deproom_proceduce").html(option);
      $("#select_deproom").html(option);
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
      $("#select_doctor_deproom").html(option);
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
      $("#select_proceduce").html(option);
    },
  });
}
function settext(key) {
  if (localStorage.lang == "en") {
    return en[key];
  } else {
    return th[key];
  }
}
// //////////////////////////////////////////////////////////////// select
// function showDialogSuccess(text) {
//   Swal.fire({
//     title: settext("alert_success"),
//     text: text,
//     icon: "success",
//     timer: 1000,
//   });
// }

