var departmentroomname = "";
var UserName = "";
$(function () {
  session();

$("#master").hide();

  $("#radio_openconfig").css("color", "#bbbbb");
  $("#radio_openconfig").css(
    "background",
    "#EAECF0"
  );

  $("#radio_openconfig").click(function () {
    $("#radio_openconfig").css("color", "#bbbbb");
    $("#radio_openconfig").css(
      "background",
      "#EAECF0"
    );

    $("#radio_master").css("color", "black");
    $("#radio_master").css("background", "");

    $("#openconfig").show();
    $("#master").hide();



  });

  $("#radio_master").click(function () {
    $("#radio_master").css("color", "#bbbbb");
    $("#radio_master").css(
      "background",
      "#EAECF0"
    );

    $("#radio_openconfig").css("color", "black");
    $("#radio_openconfig").css("background", "");

    $("#openconfig").hide();
    $("#master").show();

  });



  $("#Procedure").hide();
  $("#deproom").hide();
  $("#user").hide();

  $("#radio1_edit_doctor").css("color", "#bbbbb");
  $("#radio1_edit_doctor").css(
    "background",
    "#EAECF0"
  );

  $("#radio1_edit_doctor").click(function () {
    $("#radio1_edit_doctor").css("color", "#bbbbb");
    $("#radio1_edit_doctor").css(
      "background",
      "#EAECF0"
    );

    $("#radio1_edit_Procedure").css("color", "black");
    $("#radio1_edit_Procedure").css("background", "");
    $("#radio1_edit_deproom").css("color", "black");
    $("#radio1_edit_deproom").css("background", "");
    $("#radio1_edit_user").css("color", "black");
    $("#radio1_edit_user").css("background", "");

    $("#doctor").show();
    $("#Procedure").hide();
    $("#deproom").hide();
    $("#user").hide();
  });
  $("#radio1_edit_Procedure").click(function () {
    $("#radio1_edit_Procedure").css("color", "#bbbbb");
    $("#radio1_edit_Procedure").css(
      "background",
      "#EAECF0"
    );

    $("#radio1_edit_doctor").css("color", "black");
    $("#radio1_edit_doctor").css("background", "");
    $("#radio1_edit_deproom").css("color", "black");
    $("#radio1_edit_deproom").css("background", "");
    $("#radio1_edit_user").css("color", "black");
    $("#radio1_edit_user").css("background", "");

    $("#doctor").hide();
    $("#Procedure").show();
    $("#deproom").hide();
    $("#user").hide();
  });
  $("#radio1_edit_deproom").click(function () {
    $("#radio1_edit_deproom").css("color", "#bbbbb");
    $("#radio1_edit_deproom").css(
      "background",
      "#EAECF0"
    );

    $("#radio1_edit_doctor").css("color", "black");
    $("#radio1_edit_doctor").css("background", "");
    $("#radio1_edit_Procedure").css("color", "black");
    $("#radio1_edit_Procedure").css("background", "");
    $("#radio1_edit_user").css("color", "black");
    $("#radio1_edit_user").css("background", "");

    $("#doctor").hide();
    $("#Procedure").hide();
    $("#deproom").show();
    $("#user").hide();
  });

  $("#radio1_edit_user").click(function () {
    $("#radio1_edit_user").css("color", "#bbbbb");
    $("#radio1_edit_user").css(
      "background",
      "#EAECF0"
    );

    $("#radio1_edit_doctor").css("color", "black");
    $("#radio1_edit_doctor").css("background", "");
    $("#radio1_edit_Procedure").css("color", "black");
    $("#radio1_edit_Procedure").css("background", "");
    $("#radio1_edit_deproom").css("color", "black");
    $("#radio1_edit_deproom").css("background", "");

    $("#doctor").hide();
    $("#Procedure").hide();
    $("#deproom").hide();
    $("#user").show();
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
    },
  });
}
