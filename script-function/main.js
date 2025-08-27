var GN_WarningExpiringSoonDay = "";
var departmentroomname = "";
var UserName = "";
var display = "";

$(function () {
  session();

  configMenu();

  selection_itemNoUse();
  selection_itemborrow();
  selection_itemdamage();
  selection_receive_stock();
  selection_Ex();
  selection_use_deproom();
  selection_oc();
  selection_hn();
  selection_request_item();
  selection_add_item();

  setTimeout(() => {
    selection_ExSoon();

    if (departmentroomname != "คลังห้องผ่าตัด") {
      $("#row_ex").attr("hidden", false);
      $("#row_exsoon").attr("hidden", false);
      $("#row_receive_stock").attr("hidden", true);
      $("#row_nouse").attr("hidden", true);
      $("#row_borrow").attr("hidden", false);
      $("#row_damage").attr("hidden", true);
      $("#row_request_item").attr("hidden", false);
      $("#row_add_item").attr("hidden", false);
      // $("#row_addon").attr('hidden',false);
    } else {
      $("#row_ex").attr("hidden", false);
      $("#row_exsoon").attr("hidden", false);
      $("#row_receive_stock").attr("hidden", true);
      $("#row_nouse").attr("hidden", true);
      $("#row_borrow").attr("hidden", false);
      $("#row_damage").attr("hidden", true);
      $("#row_request_item").attr("hidden", false);
      $("#row_add_item").attr("hidden", false);
      // $("#row_addon").attr('hidden',false);
    }
  }, 300);
});

function selection_Ex() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_Ex",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (key, value) {
          $("#text_ex").text(value.c);
        });
      }
    },
  });
}

function selection_ExSoon() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_ExSoon",
      GN_WarningExpiringSoonDay: GN_WarningExpiringSoonDay,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (key, value) {
          $("#text_ExSoon").text(value.c);
        });
      }
    },
  });
}

function selection_add_item() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_add_item",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        var c = 0;
        $.each(ObjData, function (key, value) {
          $("#text_add_item").text(value.c);
        });
      }
    },
  });
}

function selection_request_item() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_request_item",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        var c = 0;
        $.each(ObjData, function (key, value) {
          $("#text_request_item").text(value.c);
        });
      }
    },
  });
}

function selection_hn() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_hn",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        var c = 0;
        $.each(ObjData, function (key, value) {
          $("#text_hn").text(value.c);
        });
      }
    },
  });
}

function selection_oc() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_oc",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        var c = 0;
        $.each(ObjData, function (key, value) {
          $("#text_oc").text(value.c);
        });
      }
    },
  });
}

function selection_use_deproom() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_use_deproom",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        var c = 0;
        $.each(ObjData, function (key, value) {
          $("#text_use_deproom").text(value.c);
        });
      }
    },
  });
}

function selection_itemdamage() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_itemdamage",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (key, value) {
          $("#text_damage").text(value.ccc);
        });
      }
    },
  });
}

function selection_itemborrow() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_itemborrow",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (key, value) {
          $("#text_borrow").text(value.ccc);
        });
      }
    },
  });
}

function selection_itemNoUse() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_itemNoUse",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (key, value) {
          $("#text_nouse").text(value.ccc);
          $("#text_nouse_bell").text(value.ccc);
        });
      }
    },
  });
}

function selection_receive_stock() {
  $.ajax({
    url: "process/main.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_receive_stock",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      if (!$.isEmptyObject(ObjData)) {
        $("#text_receive_stock").text(ObjData);
        $("#text_receive_stock_bell").text(ObjData);
      }
    },
  });
}

$("#btn_damage").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=damaged");
    document.title = "damaged";

    loadScript("script-function/damaged.js");
  });
});

$("#btn_nouse").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=nouse");
    document.title = "nouse";

    loadScript("script-function/nouse.js");
  });
});

$("#btn_oc").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=oc");
    document.title = "oc";

    loadScript("script-function/oc.js");
  });
});

$("#btn_request_item").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=request_item");
    document.title = "request_item";

    localStorage.setItem("request_item", "1");
    loadScript("script-function/request_item.js");
  });
});

$("#btn_hn").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=hn_daily");
    document.title = "hn_daily";

    loadScript("script-function/hn_daily.js");
  });
});

$("#btn_borrow").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");

    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=borrow");
    document.title = "borrow";

    loadScript("script-function/borrow.js");
  });
});

$("#btn_receive_stock").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=recieve_stock");
    document.title = "recieve_stock";

    loadScript("script-function/recieve_stock.js");
  });
});

$("#btn_ex").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }
    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=ex");
    document.title = "ex";

    loadScript("script-function/ex.js");
    loadScript("assets/lang/ex.js");
  });
});

$("#btn_exsoon").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=ex");
    document.title = "exsoon";

    loadScript("script-function/exsoon.js");
    loadScript("assets/lang/ex.js");
  });
});

$("#btn_use_deproom").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=use_deproom");
    document.title = "use_deproom";

    loadScript("script-function/use_deproom.js");
    loadScript("assets/lang/use_deproom.js");
  });
});

$("#btn_add_item").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#ic_mainpage").attr("src", "assets/img_project/3_icon/ic_mainpage.png");
    $("#li_main").addClass("active");
    if (display == 2) {
      $("#li_main").css("background-color", "rgb(60, 32, 90)");
    } else {
      $("#li_main").css("background-color", "#643695");
    }

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=use_deproom");
    document.title = "use_deproom";

    loadScript("script-function/add_item.js");
    loadScript("assets/lang/add_item.js");
  });
});

function loadScript(url) {
  const script = document.createElement("script");
  script.src = url;
  script.type = "text/javascript";
  script.onload = function () {
    // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
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
      display = ObjData.display;
    },
  });
}
