var procedure_id_Array = [];
var doctor_Array = [];
var deproom_Array = [];

var procedure_routine = [];
var doctor_routine = [];

$(function () {
  click_main();
  click_menu();
  session();
});

function click_main() {
  $("#row_mapping").hide();
  $("#row_routine").hide();

  $("#manage").css("color", "#bbbbb");
  $("#manage").css("background", "#E0D2EF");

  $("#manage").click(function () {
    $("#manage").css("color", "#bbbbb");
    $("#manage").css("background", "#E0D2EF");

    $("#mapping").css("color", "black");
    $("#mapping").css("background", "");
    $("#routine").css("color", "black");
    $("#routine").css("background", "");
    $("#row_manage").show();
    $("#row_mapping").hide();
    $("#row_routine").hide();
  });

  $("#mapping").click(function () {
    $("#mapping").css("color", "#bbbbb");
    $("#mapping").css("background", "#E0D2EF");

    $("#manage").css("color", "black");
    $("#manage").css("background", "");
    $("#routine").css("color", "black");
    $("#routine").css("background", "");
    $("#row_manage").hide();
    $("#row_mapping").show();
    $("#row_routine").hide();

    select_deproom();
    select_procedure();
    select_doctor();

    $("#select_doctor_deproom").select2();
    $("#select_deproom_proceduce").select2();
    $("#select_deproom").select2();
    $("#select_proceduce").select2();

    show_detail_doctor();
    show_detail_deproom();

    $("#select_deproom").attr("disabled", true);
    $("#row_deproom").html("");
    deproom_Array = [];

    $("#select_proceduce").attr("disabled", true);
    $("#row_procedure").html("");
    procedure_id_Array = [];
  });

  $("#routine").click(function () {
    $("#routine").css("color", "#bbbbb");
    $("#routine").css("background", "#E0D2EF");

    $("#manage").css("color", "black");
    $("#manage").css("background", "");
    $("#mapping").css("color", "black");
    $("#mapping").css("background", "");

    $("#row_routine").show();
    $("#row_mapping").hide();
    $("#row_manage").hide();

    show_detail_routine();
    show_detail_item();
    select_type();
    select_doctor();
    select_deproom();
    select_procedure();
    setTimeout(() => {
      $("#select_typeItem").select2();
      $("#select_doctor_routine").select2();
      $("#select_deproom_routine").select2();
      $("#select_procedure_routine").select2();
    }, 500);

    $("#routine_id").val("");

    $("#table_item_detail_request").DataTable().destroy();
    $("#table_item_detail_request tbody").html("");
  });

  $("#select_doctor_routine").on("select2:select", function (e) {
    if ($("#select_doctor_routine").val() == "") {
      select_deproom();
    } else {
      set_deproom();
    }
  });
  //   $("#select_procedure_routine").on("select2:select", function (e) {
  //     if($("#select_procedure_routine").val() == "" ){
  //       select_deproom();
  //     }else{
  //      set_deproom_proceduce();
  //     }
  // });

  $("#select_deproom_routine").on("select2:select", function (e) {
    if ($("#select_deproom_routine").val() == "") {
      select_procedure();
    } else {
      set_proceduce();
    }
  });
}

// $("#select_doctor_routine").on("select2:select", function (e) {
//   var selectedValue = e.params.data.id; // ดึงค่า value
//   var selectedText = e.params.data.text; // ดึงค่า text
//   if (selectedValue != "") {
//     var index = doctor_routine.indexOf(selectedValue);
//     if (index == -1) {

//       doctor_routine.push(selectedValue);
//       var _row = "";
//       _row += `       <div  class='div_${selectedValue}  clear_doctor' >
//                           <label for="" class="custom-label" onclick='DeleteDoctor_routine(${selectedValue})'>${selectedText}</label>
//                       </div> `;

//       $("#row_doctor_routine").append(_row);

//       $("#select_doctor_routine").val("").trigger("change");

//       if($("#routine_id").val() != "" && doctor_routine.length > 0 ){
//         $.ajax({
//           url: "process/manage.php",
//           type: "POST",
//           data: {
//             FUNC_NAME: "save_doctor_routine",
//             doctor_routine: doctor_routine,
//             routine_id: $("#routine_id").val(),
//           },
//           success: function (result) {

//           },
//         });
//       }

//     }
//   }
// });

// $("#select_procedure_routine").on("select2:select", function (e) {
//   var selectedValue = e.params.data.id; // ดึงค่า value
//   var selectedText = e.params.data.text; // ดึงค่า text
//   if (selectedValue != "") {
//     var index = procedure_routine.indexOf(selectedValue);
//     if (index == -1) {
//       procedure_routine.push(selectedValue);
//       var _row = "";
//       _row += `       <div  class='div_${selectedValue} clear_procedure' >
//                           <label for="" class="custom-label" onclick='Deletprocedure_routine(${selectedValue})'>${selectedText}</label>
//                       </div> `;

//       $("#row_procedure_routine").append(_row);

//       $("#select_procedure_routine").val("").trigger("change");

//       if($("#routine_id").val() != "" && procedure_routine.length > 0 ){
//         $.ajax({
//           url: "process/manage.php",
//           type: "POST",
//           data: {
//             FUNC_NAME: "save_procedure_routine",
//             procedure_routine: procedure_routine,
//             routine_id: $("#routine_id").val(),
//           },
//           success: function (result) {

//           },
//         });
//       }

//     }
//   }
// });

function click_menu() {
  $("#row_procedure_").hide();
  $("#row_deproom_").hide();
  $("#row_users").hide();

  $("#radio1").css("color", "#bbbbb");
  $("#radio1").css("background", "#E0D2EF");

  feeddata_detailDoctor();

  $("#radio1").click(function () {
    $("#radio1").css("color", "#bbbbb");
    $("#radio1").css("background", "#E0D2EF");

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
    $("#radio2").css("background", "#E0D2EF");

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
    $("#radio3").css("background", "#E0D2EF");

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
    $("#radio4").css("background", "#E0D2EF");

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

    select_permission();
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
      if (result == "xxxx") {
        showDialogFailed("ชื่อแพทย์ซ้ำ");
      } else {
        showDialogSuccess(result);
        feeddata_detailDoctor();
        showDialogSuccess("บันทึกสำเร็จ");
      }

      $("#input_doctorth").val("");
      $("#input_IDdoctor").val("");
    },
  });
}
function editDoctor(ID, Doctor_Name, IsCancel) {
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
                      <td class="text-center">
                      

                       <button class="btn btn-outline-dark f18" onclick='editDoctor("${
                         value.ID
                       }","${value.Doctor_Name}","${
            value.IsCancel
          }")'  > <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button>
                       <button  class="btn btn-outline-danger f18" onclick='deleteDoctor(${
                         value.ID
                       })'><i class="fa-solid fa-trash-can"></i></button> 
          
          
          </td>
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
        searching: true,
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
      if (result == "xxxx") {
        showDialogFailed("ชื่อหัตถการซ้ำ");
      } else {
        showDialogSuccess(result);
        feeddata_detailProcedure();
        showDialogSuccess("บันทึกสำเร็จ");
      }

      $("#input_Procedure").val("");
      $("#input_IDProcedure").val("");
    },
  });
}

function editProcedure(ID, Procedure_TH, IsActive) {
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
            `<td class="text-center">
            
                       <button class="btn btn-outline-dark f18 edit-btn" data-id="${value.ID}" data-name="${value.Procedure_TH}" data-active="${value.IsActive}" > <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button>
                       <button  class="btn btn-outline-danger f18" onclick='deleteProcedure(${value.ID})'><i class="fa-solid fa-trash-can"></i></button> 
            
            
            
            
            </td>` +
            ` </tr>`;
        });

        document.querySelectorAll(".edit-btn").forEach((btn) => {
          btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const isActive = btn.dataset.active;
            editProcedure(id, name, isActive);
          });
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
        searching: true,
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

      $("#table_detailProcedure").on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        const name = $(this).data("name");
        const isActive = $(this).data("active");
        editProcedure(id, name, isActive);
      });
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
  if ($("#radio_admin1").is(":checked")) {
    var IsAdmin = 1;
  } else {
    var IsAdmin = 0;
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
      select_permission: $("#select_permission").val(),
      IsAdmin: IsAdmin,
      input_IDUser: $("#input_IDUser").val(),
      IsCancel: IsCancel,
    },
    success: function (result) {
      if (result == "1") {
        showDialogFailed("รหัสพนักงานซ้ำ");
      } else if (result == "2") {
        showDialogFailed("UserNameซ้ำ");
      } else {
        showDialogSuccess(result);
        feeddata_detailUser();
        showDialogSuccess("บันทึกสำเร็จ");
      }

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
  IsCancel,
  permission,
  IsAdmin
) {
  $("#input_empcodeUser").val(EmpCode);
  $("#input_nameUser").val(FirstName);
  $("#input_lastUser").val(LastName);
  $("#input_userName").val(UserName);
  $("#input_passWord").val(Password);
  $("#select_permission").val(permission);
  $("#input_IDUser").val(ID);

  if (IsCancel == "Active") {
    $("#radio_statusUser1").prop("checked", true);
  } else {
    $("#radio_statusUser2").prop("checked", true);
  }
  if (IsAdmin == "1") {
    $("#radio_admin1").prop("checked", true);
  } else {
    $("#radio_admin2").prop("checked", true);
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
  $("#select_permission").val("");
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
            var bg = "style='background-color:#219E83;color:#fff;' ";
          } else {
            value.IsCancel = "InActive";
            var bg = "style='background-color:#D92D20;color:#fff;' ";
          }

          _tr += `<tr> 
                      <td class="text-center">${kay + 1}</td>
                      <td class="text-left">${value.EmpCode}</td>
                      <td class="text-left">${value.FirstName}</td>
                      <td class="text-left">${value.LastName}</td>
                      <td class="text-left">${value.UserName}</td>
                      <td class="text-left">${value.Password}</td>
                      <td class="text-left"><button class='btn' ${bg}>  ${
            value.IsCancel
          } </button></td>
                      <td class="text-center">
                      <button class="btn btn-outline-dark f18" onclick='editUser("${
                        value.ID
                      }","${value.EmpCode}","${value.FirstName}","${
            value.LastName
          }","${value.UserName}","${value.Password}","${value.IsCancel}","${
            value.permission
          }","${
            value.IsAdmin
          }")'  > <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button>
                       <button  class="btn btn-outline-danger f18" onclick='deleteUser(${
                         value.ID
                       },"${
            value.EmpCode
          }")'><i class="fa-solid fa-trash-can"></i></button> 
                      </td>
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
        searching: true,
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
      IsActive: IsActive,
    },
    success: function (result) {
      if (result == "xxxx") {
        showDialogFailed("ตัวย่อซ้ำ");
      } else {
        showDialogSuccess(result);
        feeddata_detailDeproom();
        showDialogSuccess("บันทึกสำเร็จ");
      }

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
            var bg = "style='background-color:#D92D20;color:#fff;' ";
          } else {
            value.IsActive = "Active";
            var bg = "style='background-color:#219E83;color:#fff;' ";
          }

          _tr += `<tr> 
                      <td class="text-center">${kay + 1}</td>
                      <td class="text-left">${value.departmentroomname}</td>
                      <td class="text-left">${value.departmentroomname_EN}</td>
                      <td class="text-left">${value.departmentroomname_sub}</td>
                      <td class="text-center">${value.floor_id}</td>
                      <td class="text-center"><button class='btn' ${bg}>  ${
            value.IsActive
          } </button></td>

                      <td class="text-center">
                       <button class="btn btn-outline-dark f18" onclick='editDeproom("${
                         value.id
                       }","${value.departmentroomname}","${
            value.departmentroomname_EN
          }","${value.ID_floor}","${value.IsActive}","${
            value.departmentroomname_sub
          }")'  > <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button>
                       <button  class="btn btn-outline-danger f18" onclick='deleteDeproom(${
                         value.id
                       })'><i class="fa-solid fa-trash-can"></i></button> 

                      </td>
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
        searching: true,
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
    deproom_Array.splice(index, 1);
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
      } else {
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
    procedure_id_Array.splice(index, 1);
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
        $("#select2-select_deproom_proceduce-container").text(
          "กรุณาเลือกแพทย์"
        );
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
      } else {
      }
    },
  });
}

$("#btn_Clear_deproom_proceduce").click(function () {
  $("#select_deproom_proceduce").val("");
  $("#select2-select_deproom_proceduce-container").text("กรุณาเลือกห้องผ่าตัด");
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
            `<td class="text-center" > <button class="btn btn-outline-dark f18"  onclick='edit_doctor(${value.doctor_id})'> <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button> </td>` +
            `<td class="text-center"> <button  class="btn btn-outline-danger f18" onclick='delete_doctor(${value.doctor_id})'><i class="fa-solid fa-trash-can"></i></button> </td>` +
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
          },
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

function delete_doctor(doctor_id) {
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

function edit_doctor(doctor_id) {
  $("#select_doctor_deproom").val(doctor_id).trigger("change");
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
            `<td class="text-center" > <button class="btn btn-outline-dark f18"  onclick='edit_deproom(${value.departmentroom_id})'> <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button> </td>` +
            `<td class="text-center"> <button  class="btn btn-outline-danger f18" onclick='delete_deproom(${value.departmentroom_id})'><i class="fa-solid fa-trash-can"></i></button> </td>` +
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
          },
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

function delete_deproom(departmentroom_id) {
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

function edit_deproom(departmentroom_id) {
  $("#select_deproom_proceduce").val(departmentroom_id).trigger("change");
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

function select_type() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_type",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>เลือกทั้งหมด</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.TyeName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_typeItem").html(option);
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
      $("#select_deproom_proceduce").html(option);
      $("#select_deproom").html(option);
      $("#select_deproom_routine").html(option);
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
      $("#select_doctor_routine").html(option);
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
      $("#select_procedure_routine").html(option);
    },
  });
}

function select_permission() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_permission",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกสังกัด</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.PmID}" >${value.Permission}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_permission").html(option);
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

// item

$("#input_search_routine").keyup(function () {
  show_detail_routine();
});

function show_detail_routine() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_routine",
      input_search_routine: $("#input_search_routine").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_routine").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.Doctor_Name}</td>
                      <td>${value.departmentroomname}</td>
                      <td>${value.Procedure_TH}</td>
                      <td class="text-center" > <button class="btn btn-outline-dark f18"  onclick='edit_routine(${
                        value.id
                      },${value.departmentroom_id},${value.doctor_id},${
            value.procedure_id
          })'> <i class="fa-regular fa-pen-to-square"></i> แก้ไข</button> </td>
                      <td class="text-center"> <button  class="btn btn-outline-danger f18" onclick='delete_routine(${
                        value.id
                      })'><i class="fa-solid fa-trash-can"></i></button> </td>
                   </tr>`;
        });
      }

      $("#table_detail_routine tbody").html(_tr);
      $("#table_detail_routine").DataTable({
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
            width: "20%",
            targets: 1,
          },
          {
            width: "20%",
            targets: 2,
          },
          {
            width: "30%",
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

      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

function show_detail_item() {
  $.ajax({
    url: "process/create_request.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_request",
      input_search_request: $("#input_search_request").val(),
      select_typeItem: $("#select_typeItem").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_item").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center' >${kay + 1}</td>
                      <td>${value.Item_name}</td>
                      <td class='text-center'>${value.TyeName}</td>
                      <td class='text-center'><input type='text' class='numonly form-control loop_qty_request text-center' data-itemcode="${
                        value.itemcode
                      }"></td>
                   </tr>`;
        });
      }

      $("#table_detail_item tbody").html(_tr);
      $("#table_detail_item").DataTable({
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
            width: "40%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
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

      $(".numonly").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ""); //<-- replace all other than given set of values
      });
    },
  });
}

$("#btn_clear_routine").click(function () {
  $("#routine_id").val("");

  show_detail_item();

  $("#table_item_detail_request").DataTable().destroy();
  $("#table_item_detail_request tbody").empty();

  setTimeout(() => {
    $("#select_doctor_routine").val("").trigger("change");
    $("#select_deproom_routine").val("").trigger("change");
    $("#select_procedure_routine").val("").trigger("change");
  }, 500);

  // $("#row_doctor_routine").html("");
  // doctor_routine = [];
  // $("#row_procedure_routine").html("");
  // procedure_routine = [];

  show_detail_routine();
});

$("#select_typeItem").change(function () {
  show_detail_item();
});

$("#btn_confirm_request").click(function () {
  var count_qty_request = 0;
  $(".loop_qty_request").each(function (key, value) {
    if ($(this).val() == "") {
    } else {
      count_qty_request++;
    }
  });

  if ($("#select_doctor_routine").val() == "") {
    showDialogFailed("กรุณาเลือกแพทย์");
    return;
  }
  if ($("#select_deproom_routine").val() == "") {
    showDialogFailed("กรุณาเลือกห้องผ่าตัด");
    return;
  }
  if ($("#select_procedure_routine").val() == "") {
    showDialogFailed("กรุณาเลือกหัตถการ");
    return;
  }

  if (count_qty_request == 0) {
    showDialogFailed("กรุณากรอกจำนวน");
    return;
  }

  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การเพิ่มรายการ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_request();
    }
  });
});

$("#input_search_request").keyup(function () {
  show_detail_item();
});

$("#select_procedure_routine").change(function () {
  if ($("#routine_id").val() != "") {
    $.ajax({
      url: "process/manage.php",
      type: "POST",
      data: {
        FUNC_NAME: "save_procedure_routine",
        procedure_routine: $("#select_procedure_routine").val(),
        routine_id: $("#routine_id").val(),
      },
      success: function (result) {},
    });
  } else {
    show_detail_request_byDocNo_change();
  }
});

$("#select_doctor_routine").change(function () {
  if ($("#routine_id").val() != "") {
    $.ajax({
      url: "process/manage.php",
      type: "POST",
      data: {
        FUNC_NAME: "save_doctor_routine",
        doctor_routine: $("#select_doctor_routine").val(),
        routine_id: $("#routine_id").val(),
      },
      success: function (result) {},
    });
  } else {
    show_detail_request_byDocNo_change();
  }
});

function onconfirm_request() {
  qty_array = [];
  itemcode_array = [];

  $("#table_detail_item")
    .DataTable()
    .rows()
    .every(function () {
      let inputValue = $(this.node()).find("input.loop_qty_request").val();
      if (inputValue != "" && inputValue != "0") {
        qty_array.push(inputValue);
        itemcode_array.push(
          $(this.node()).find("input.loop_qty_request").data("itemcode")
        );
      }
    });

  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_request",
      array_itemcode: itemcode_array,
      array_qty: qty_array,
      select_deproom_routine: $("#select_deproom_routine").val(),
      procedure_routine: $("#select_procedure_routine").val(),
      doctor_routine: $("#select_doctor_routine").val(),
      routine_id: $("#routine_id").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      $("#routine_id").val(ObjData);
      show_detail_item();
      setTimeout(() => {
        show_detail_request_byDocNo();
        show_detail_routine();
      }, 200);
    },
  });
}

function show_detail_request_byDocNo_change() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request_byDocNo_change",
      select_deproom_routine: $("#select_deproom_routine").val(),
      select_procedure_routine: $("#select_procedure_routine").val(),
      select_doctor_routine: $("#select_doctor_routine").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_detail_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          Swal.fire("ผิดพลาด", "มีการบันทึก Master Routine นี้แล้ว", "error");

          $("#select_doctor_routine").val("").trigger("change");
          $("#select_deproom_routine").val("").trigger("change");
          $("#select_procedure_routine").val("").trigger("change");
        });
      }
    },
  });
}

function show_detail_request_byDocNo() {
  $.ajax({
    url: "process/manage.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_request_byDocNo",
      routine_id: $("#routine_id").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_detail_request").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td>${value.itemname}</td>
                      <td class='text-center'>${value.TyeName}</td>
                      <td class='text-center'><input type="text" class="form-control text-center qty_loop" id="qty_item_${
                        value.id
                      }" data-id='${value.id}' value='${value.cnt}'> </td>
                      <td class='text-center'>
                      <img src="assets/img_project/1_icon/ic_trash-1.png" style='width:30%;cursor:pointer;' onclick='delete_request_byItem(${
                        value.id
                      })'>
                      </td>
                   </tr>`;
        });
      }

      $("#table_item_detail_request tbody").html(_tr);
      $("#table_item_detail_request").DataTable({
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
            width: "45%",
            targets: 1,
          },
          {
            width: "25%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
          },
          {
            width: "20%",
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

function delete_request_byItem(ID) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การลบ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "delete_request_byItem",
          ID: ID,
        },
        success: function (result) {
          var ObjData = JSON.parse(result);

          showDialogSuccess("ลบสำเร็จ");

          setTimeout(() => {
            show_detail_request_byDocNo();
          }, 300);
        },
      });
    }
  });
}

// function Deletprocedure_routine(selectedValue) {
//   var index = procedure_routine.indexOf(String(selectedValue));
//   console.log(index);

//   if (index !== -1) {
//     procedure_routine.splice(index, 1);
//   }

//   console.log(procedure_routine);
//   $(".div_" + selectedValue).attr("hidden", true);

//   if($("#routine_id").val() != "" && procedure_routine.length > 0 ){
//     $.ajax({
//       url: "process/manage.php",
//       type: "POST",
//       data: {
//         FUNC_NAME: "save_procedure_routine",
//         procedure_routine: procedure_routine,
//         routine_id: $("#routine_id").val(),
//       },
//       success: function (result) {

//       },
//     });
//   }

// }

// function DeleteDoctor_routine(selectedValue) {
//   var index = doctor_routine.indexOf(String(selectedValue));
//   console.log(index);

//   if (index !== -1) {
//     doctor_routine.splice(index, 1);
//   }

//   console.log(doctor_routine);
//   $(".div_" + selectedValue).attr("hidden", true);

//   if($("#routine_id").val() != "" && doctor_routine.length > 0 ){
//     $.ajax({
//       url: "process/manage.php",
//       type: "POST",
//       data: {
//         FUNC_NAME: "save_doctor_routine",
//         doctor_routine: doctor_routine,
//         routine_id: $("#routine_id").val(),
//       },
//       success: function (result) {

//       },
//     });
//   }

// }

// set_deproom();

//   function set_proceduce() {
//   $.ajax({
//     url: "process/process_main/select_main.php",
//     type: "POST",
//     data: {
//       FUNC_NAME: "set_proceduce",
//       select_deproom_request: $("#select_deproom_routine").val(),
//     },
//     success: function (result) {
//       var ObjData = JSON.parse(result);
//       console.log(ObjData);
//       var option = `<option value="" selected>กรุณาเลือกหัตถการ</option>`;
//       if (!$.isEmptyObject(ObjData)) {
//         $.each(ObjData, function (kay, value) {
//           option += `<option value="${value.ID}" >${value.Procedure_TH}</option>`;
//         });
//       } else {
//         option = `<option value="0">ไม่มีข้อมูล</option>`;
//       }
//       $("#select_procedure_routine").html(option);
//     },
//   });
// }

// function set_doctor() {
//   $.ajax({
//     url: "process/process_main/select_main.php",
//     type: "POST",
//     data: {
//       FUNC_NAME: "set_doctor",
//       select_deproom_request: $("#select_deproom_routine").val(),
//     },
//     success: function (result) {
//       var ObjData = JSON.parse(result);
//       console.log(ObjData);
//       var option = `<option value="" selected>กรุณาเลือกแพทย์</option>`;
//       if (!$.isEmptyObject(ObjData)) {
//         $.each(ObjData, function (kay, value) {
//           option += `<option value="${value.ID}" >${value.Doctor_Name}</option>`;
//         });
//       } else {
//         option = `<option value="0">ไม่มีข้อมูล</option>`;
//       }
//       $("#select_doctor_routine").html(option);
//     },
//   });
// }

function set_deproom_proceduce() {
  var procedure_xx = [];
  procedure_xx.push($("#select_procedure_routine").val().toString());

  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom_proceduce",
      procedure_id_Array: procedure_xx,
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
      $("#select_deproom_routine").html(option);
    },
  });
}

function set_proceduce() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_proceduce",
      select_deproom_request: $("#select_deproom_routine").val(),
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
      $("#select_procedure_routine").html(option);
    },
  });
}

function set_deproom() {
  var doctor_Array_xx = [];
  doctor_Array_xx.push($("#select_doctor_routine").val().toString());
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom",
      doctor_Array: doctor_Array_xx,
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
      $("#select_deproom_routine").html(option);
    },
  });
}

function delete_routine(id) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การลบ Routine",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/manage.php",
        type: "POST",
        data: {
          FUNC_NAME: "delete_routine",
          id: id,
        },
        success: function (result) {
          // var ObjData = JSON.parse(result);
          console.log(result);
          $("#routine_id").val("");
          showDialogSuccess("ลบสำเร็จ");
          show_detail_routine();
        },
      });
    }
  });
}

function edit_routine(id, departmentroom_id, doctor_id, procedure_id) {
  $("#routine_id").val(id);

  $("#select_doctor_routine").val(doctor_id).trigger("change");
  $("#select_deproom_routine").val(departmentroom_id).trigger("change");
  $("#select_procedure_routine").val(procedure_id).trigger("change");

  setTimeout(() => {
    show_detail_request_byDocNo();
    // select_edit_routine();
  }, 300);
  // $.ajax({
  //   url: "process/manage.php",
  //   type: "POST",
  //   data: {
  //     FUNC_NAME: "edit_routine",
  //     id: id,
  //   },
  //   success: function (result) {
  //     // var ObjData = JSON.parse(result);
  //     console.log(result);

  //     showDialogSuccess("ลบสำเร็จ");
  //     show_detail_routine();
  //   },
  // });
}

// function select_edit_routine() {
//   $.ajax({
//     url: "process/manage.php",
//     type: "POST",
//     data: {
//       FUNC_NAME: "select_edit_routine",
//       routine_id: $("#routine_id").val(),
//     },
//     success: function (result) {
//       var ObjData = JSON.parse(result);

//       $("#row_doctor_routine").html("");
//       doctor_routine = [];
//       $("#row_procedure_routine").html("");
//       procedure_routine = [];

//       if (!$.isEmptyObject(ObjData)) {
//         var _row = "";
//         var _row2 = "";
//         $.each(ObjData["doctor"], function (kay2, value2) {
//           doctor_routine.push(value2.doctor_id.toString());

//           _row += `       <div  class='div_${value2.doctor_id}  clear_doctor' >
//                             <label for="" class="custom-label" onclick='DeleteDoctor_routine(${value2.doctor_id})'>${value2.Doctor_Name}</label>
//                         </div> `;
//         });

//         $("#row_doctor_routine").append(_row);

//         $.each(ObjData["proceduce"], function (kay2, value2) {
//           procedure_routine.push(value2.procedure_id.toString());

//           _row2 += `       <div  class='div_${value2.procedure_id}  clear_doctor' >
//                             <label for="" class="custom-label" onclick='Deletprocedure_routine(${value2.procedure_id})'>${value2.Procedure_TH}</label>
//                         </div> `;
//         });

//         $("#row_procedure_routine").append(_row2);
//       }
//     },
//   });
// }

// item
