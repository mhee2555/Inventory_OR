var userList = [];

$(function () {
  session();
  select_users();

  $("#selectUser").change(function () {
    var selectedID = $(this).val();
    var selectedUser = userList.find((user) => String(user.ID) === String(selectedID) );

    console.log(selectedUser);
    if (selectedUser) {

      console.log(selectedUser);
      // สมมุติว่ามีช่องแสดงผลข้อมูลใน DOM ที่ต้องการแสดง
      $("#name_users").text( selectedUser.FirstName +" " +selectedUser.LastName +" ( " +selectedUser.EmpCode +" ) " );
      $("#permission_users").text(selectedUser.Permission);

      if (selectedUser.IsAdmin == 1) {

      $(".clear_checkbox").prop("checked", true);
        $(".clear_checkbox").prop("disabled", true);

        var xx = "Admin";



        // $("#manage").prop("disabled", false);
        // $("#permission").prop("disabled", false);
      } else {
        var xx = "User";

        $(".clear_checkbox").prop("disabled", false);


        $("#manage").prop("checked", false);
        $("#permission").prop("checked", false);

        $("#manage").prop("disabled", true);
        $("#permission").prop("disabled", true);
      }
      $("#admin_users").text(xx);

      select_permission(selectedID);
      //   $("#userID").text(selectedUser.ID);
      //   $("#userDepartment").text(selectedUser.Department || 'ไม่มีข้อมูล');
      // เพิ่มเติมได้ตามข้อมูลที่ server ส่งมา
    } else {
      $("#name_users").text("");
      $("#permission_users").text("");
      $("#admin_users").text("");
      $("#input_userID").val("");
      $(".clear_checkbox").prop("checked", false);
    }
  });
});

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

function select_users() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_users",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกผู้ใช้งาน</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          userList = ObjData; // เก็บไว้ใน array

          option += `<option value="${value.ID}" >${value.FirstName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#selectUser").html(option);
      $("#selectUser").select2();
    },
  });
}

function select_permission(selectedID) {
  $("#input_userID").val(selectedID);
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_config_menu",
      selectedID: selectedID,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.main == 1) {
            $("#main").prop("checked", true);
          } else {
            $("#main").prop("checked", false);
          }
          if (value.recieve_stock == 1) {
            $("#recieve_stock").prop("checked", true);
          } else {
            $("#recieve_stock").prop("checked", false);
          }
          if (value.create_request == 1) {
            $("#create_request").prop("checked", true);
          } else {
            $("#create_request").prop("checked", false);
          }
          if (value.request_item == 1) {
            $("#request_item").prop("checked", true);
          } else {
            $("#request_item").prop("checked", false);
          }
          if (value.set_hn == 1) {
            $("#set_hn").prop("checked", true);
          } else {
            $("#set_hn").prop("checked", false);
          }
          if (value.pay == 1) {
            $("#pay").prop("checked", true);
          } else {
            $("#pay").prop("checked", false);
          }
          if (value.hn == 1) {
            $("#hn").prop("checked", true);
          } else {
            $("#hn").prop("checked", false);
          }
          if (value.movement == 1) {
            $("#movement").prop("checked", true);
          } else {
            $("#movement").prop("checked", false);
          }
          if (value.manage == 1) {
            $("#manage").prop("checked", true);
          } else {
            $("#manage").prop("checked", false);
          }
          if (value.report == 1) {
            $("#report").prop("checked", true);
          } else {
            $("#report").prop("checked", false);
          }
          if (value.permission == 1) {
            $("#permission").prop("checked", true);
          } else {
            $("#permission").prop("checked", false);
          }
        });
      } else {
        $(".clear_checkbox").prop("checked", false);
      }
    },
  });
}

$("#main").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }

  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "main",
      },
      success: function (result) {},
    });
  }
});
$("#recieve_stock").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "recieve_stock",
      },
      success: function (result) {},
    });
  }
});
$("#create_request").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "create_request",
      },
      success: function (result) {},
    });
  }
});
$("#request_item").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "request_item",
      },
      success: function (result) {},
    });
  }
});
$("#set_hn").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "set_hn",
      },
      success: function (result) {},
    });
  }
});
$("#pay").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "pay",
      },
      success: function (result) {},
    });
  }
});
$("#hn").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "hn",
      },
      success: function (result) {},
    });
  }
});
$("#movement").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "movement",
      },
      success: function (result) {},
    });
  }
});
$("#manage").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "manage",
      },
      success: function (result) {},
    });
  }
});
$("#report").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "report",
      },
      success: function (result) {},
    });
  }
});
$("#permission").change(function () {
  if ($(this).is(":checked")) {
    var number = 1;
  } else {
    var number = 0;
  }
  if ($("#input_userID").val() != "") {
    $.ajax({
      url: "process/permission.php",
      type: "POST",
      data: {
        FUNC_NAME: "update_menu",
        input_userID: $("#input_userID").val(),
        number: number,
        menu: "permission",
      },
      success: function (result) {},
    });
  }
});
