$(function () {
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

  $("#select_date1").val(output);
  $("#select_date1").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  $("#select_date2").val(output);
  $("#select_date2").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });

  $("#row_typeday").hide();
  $("#row_day").hide();

  $("#row_typemonth").hide();
  $("#row_month").hide();

  $("#select_date2").hide();
  $("#select_month2").hide();

  $("#radio_date1").click(function (e) {
    if ($("#radio_date1").is(":checked")) {
      $("#select_date2").hide();
    }
  });
  $("#radio_date2").click(function (e) {
    if ($("#radio_date2").is(":checked")) {
      $("#select_date2").show();
    }
  });
  $("#radio_month1").click(function (e) {
    if ($("#radio_month1").is(":checked")) {
      $("#select_month2").hide();
    }
  });
  $("#radio_month2").click(function (e) {
    if ($("#radio_month2").is(":checked")) {
      $("#select_month2").show();
    }
  });

  $("#select_type_date").change(function (e) {
    if ($(this).val() == "") {
      $("#row_typeday").hide();
      $("#row_day").hide();

      $("#row_typemonth").hide();
      $("#row_month").hide();
    }
    if ($(this).val() == "1") {
      $("#row_typeday").show();
      $("#row_day").show();

      $("#row_typemonth").hide();
      $("#row_month").hide();
    }
    if ($(this).val() == "2") {
      $("#row_typeday").hide();
      $("#row_day").hide();

      $("#row_typemonth").show();
      $("#row_month").show();
    }
  });

  $("#btn_report").click(function (e) {
    if ($("#select_type_date").val() != "") {
      if ($("#select_report").val() == 1) {
        if ($("#radio_date1").is(":checked")) {
          var checkday = 1;
        } else {
          var checkday = 2;
        }
        if ($("#radio_month1").is(":checked")) {
          var checkmonth = 1;
        } else {
          var checkmonth = 2;
        }

        var option =
          "?type_date=" +
          $("#select_type_date").val() +
          "&date1=" +
          $("#select_date1").val() +
          "&date2=" +
          $("#select_date2").val() +
          "&month1=" +
          $("#select_month1").val() +
          "&month2=" +
          $("#select_month2").val() +
          "&checkday=" +
          checkday +
          "&checkmonth=" +
          checkmonth;

        window.open("report/Report_Replenishment.php" + option, "_blank");
      }
      if ($("#select_report").val() == 2) {
        if ($("#radio_date1").is(":checked")) {
          var checkday = 1;
        } else {
          var checkday = 2;
        }
        if ($("#radio_month1").is(":checked")) {
          var checkmonth = 1;
        } else {
          var checkmonth = 2;
        }

        var option =
          "?type_date=" +
          $("#select_type_date").val() +
          "&date1=" +
          $("#select_date1").val() +
          "&date2=" +
          $("#select_date2").val() +
          "&month1=" +
          $("#select_month1").val() +
          "&month2=" +
          $("#select_month2").val() +
          "&checkday=" +
          checkday +
          "&checkmonth=" +
          checkmonth;

        window.open("report/Report_Patient_Requisition.php" + option, "_blank");
      }
      if ($("#select_report").val() == 3) {
        if ($("#radio_date1").is(":checked")) {
          var checkday = 1;
        } else {
          var checkday = 2;
        }
        if ($("#radio_month1").is(":checked")) {
          var checkmonth = 1;
        } else {
          var checkmonth = 2;
        }

        var option =
          "?type_date=" +
          $("#select_type_date").val() +
          "&date1=" +
          $("#select_date1").val() +
          "&date2=" +
          $("#select_date2").val() +
          "&month1=" +
          $("#select_month1").val() +
          "&month2=" +
          $("#select_month2").val() +
          "&checkday=" +
          checkday +
          "&checkmonth=" +
          checkmonth;

        window.open("report/Report_Issue.php" + option, "_blank");
      }
      if ($("#select_report").val() == 4) {
        if ($("#radio_date1").is(":checked")) {
          var checkday = 1;
        } else {
          var checkday = 2;
        }
        if ($("#radio_month1").is(":checked")) {
          var checkmonth = 1;
        } else {
          var checkmonth = 2;
        }

        var option =
          "?type_date=" +
          $("#select_type_date").val() +
          "&date1=" +
          $("#select_date1").val() +
          "&date2=" +
          $("#select_date2").val() +
          "&month1=" +
          $("#select_month1").val() +
          "&month2=" +
          $("#select_month2").val() +
          "&checkday=" +
          checkday +
          "&checkmonth=" +
          checkmonth;

        window.open("report/Report_Cabinet_Issue.php" + option, "_blank");
      }
      if ($("#select_report").val() == 5) {
        if ($("#radio_date1").is(":checked")) {
          var checkday = 1;
        } else {
          var checkday = 2;
        }
        if ($("#radio_month1").is(":checked")) {
          var checkmonth = 1;
        } else {
          var checkmonth = 2;
        }

        var option =
          "?type_date=" +
          $("#select_type_date").val() +
          "&date1=" +
          $("#select_date1").val() +
          "&date2=" +
          $("#select_date2").val() +
          "&month1=" +
          $("#select_month1").val() +
          "&month2=" +
          $("#select_month2").val() +
          "&checkday=" +
          checkday +
          "&checkmonth=" +
          checkmonth;

        window.open(
          "report/Report_Patient_Cost_Summary.php" + option,
          "_blank"
        );
      }
    }
  });
});
