var departmentroomname = "";
var UserName = "";
$(function () {
  session();


  $("#inactive").hide();

  $("#radio_active").css("color", "#bbbbb");
  $("#radio_active").css(
    "background",
    "linear-gradient(0deg, #a6a6a6, #a6a6a6),linear-gradient(0deg, #a6a6a6, #a6a6a6)"
  );

  $("#radio_active").click(function () {
    $("#radio_active").css("color", "#bbbbb");
    $("#radio_active").css(
      "background",
      "linear-gradient(0deg, #a6a6a6, #a6a6a6),linear-gradient(0deg, #a6a6a6, #a6a6a6)"
    );

    $("#radio_inactive").css("color", "black");
    $("#radio_inactive").css("background", "");


    $("#active").show();
    $("#inactive").hide();
  });

  $("#radio_inactive").click(function () {
    $("#radio_inactive").css("color", "#bbbbb");
    $("#radio_inactive").css(
      "background",
      "linear-gradient(0deg, #a6a6a6, #a6a6a6),linear-gradient(0deg, #a6a6a6, #a6a6a6)"
    );

    $("#radio_active").css("color", "black");
    $("#radio_active").css("background", "");


    $("#active").hide();
    $("#inactive").show();

  });



  $("#radio_sud").css("color", "#bbbbb");
  $("#radio_sud").css(
    "background",
    "linear-gradient(0deg, #cae9ff, #cae9ff),linear-gradient(0deg, #cae9ff, #cae9ff)"
  );


  $("#radio_sud").click(function () {
    $("#radio_sud").css("color", "#bbbbb");
    $("#radio_sud").css(
      "background",
      "linear-gradient(0deg, #cae9ff, #cae9ff),linear-gradient(0deg, #cae9ff, #cae9ff)"
    );

    $("#radio_sterile").css("color", "black");
    $("#radio_sterile").css("background", "");


  });

  $("#radio_sterile").click(function () {
    $("#radio_sterile").css("color", "#bbbbb");
    $("#radio_sterile").css(
      "background",
      "linear-gradient(0deg, #cae9ff, #cae9ff),linear-gradient(0deg, #cae9ff, #cae9ff)"
    );

    $("#radio_sud").css("color", "black");
    $("#radio_sud").css("background", "");


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
