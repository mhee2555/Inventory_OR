var departmentroomname = "";
var UserName = "";
var Userid = "";

var procedure_id_Array = [];
var doctor_Array = [];

var procedure_edit_hn_Array = [];
var doctor_edit_hn_Array = [];

var procedure_edit_hn_block_Array = [];
var doctor_edit_hn_block_Array = [];
$(function () {
  session();

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




  $("#input_time_service_manual").val(currentTime);

  $("#input_time_service_editHN").val(currentTime);
  $("#input_date_service_editHN").val(output);
  $("#input_date_service_editHN").datepicker({
    onSelect: function (date) { },
  });

  $("#input_date_service_editHN_block").val(output);
  $("#input_date_service_editHN_block").datepicker({
    onSelect: function (date) { },
  });

  $("#select_date_history_return").val(output);
  $("#select_date_history_return").datepicker({
    onSelect: function (date) {
      feeddata_history_Return();
    },
  });

  $("#select_date_pay").val(output);
  $("#select_date_pay").datepicker({
    onSelect: function (date) {
      show_detail_deproom_pay();
    },
  });
  $("#select_date_history_S").val(output);
  $("#select_date_history_S").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });
  $("#select_date_history_L").val(output);
  $("#select_date_history_L").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });
  $("#select_date_history_S_block").val(output);
  $("#select_date_history_S_block").datepicker({
    onSelect: function (date) {
      show_detail_history_block();
    },
  });
  $("#select_date_history_L_block").val(output);
  $("#select_date_history_L_block").datepicker({
    onSelect: function (date) {
      show_detail_history_block();
    },
  });



  $("#input_date_service").val(output);
  $("#input_date_service").datepicker({
    onSelect: function (date) {
      updateService();
    },
  });

  $("#input_date_service_manual").val(output);
  $("#input_date_service_manual").datepicker({
    onSelect: function (date) { },
  });

  $("#select_date_sell").val(output);
  $("#select_date_sell").datepicker({
    onSelect: function (date) {
      show_detail_department();
    },
  });

  $("#input_date_service_sell").val(output);
  $("#input_date_service_sell").datepicker({
    onSelect: function (date) { },
  });

  $("#input_time_service").change(function (e) {
    updateService();
  });

  $("#history_pay").hide();
  $("#claim").hide();
  $("#pay_manual").hide();
  $("#return").hide();
  $("#hn_pay_block").hide();
  $("#sell_deproom").hide();


  $("#radio_pay").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").show();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();
    $("#hn_pay_block").hide();
    $("#sell_deproom").hide();

    show_detail_deproom_pay();
  });

  $("#btn_clear_manual").click(function () {
    $("#input_Hn_pay_manual").val("");
    $("#input_box_pay_manual").val("");

    $("#input_box_pay_manual").attr("disabled", false);
    $("#input_Hn_pay_manual").attr("disabled", false);

    $("#input_date_service_manual").val(output);
    $("#select_doctor_manual").val("").trigger("change");
    $("#select_deproom_manual").val("").trigger("change");
    $("#select_procedure_manual").val("").trigger("change");

    $("#input_remark_manual").val("");
    $("#input_docNo_deproom_manual").val("");
    $("#input_docNo_HN_manual").val("");

    $("#table_deproom_DocNo_pay_manual tbody").html("");

    $(".clear_doctor").attr("hidden", true);
    doctor_Array = [];
    $(".clear_procedure").attr("hidden", true);
    procedure_id_Array = [];
  });

  $("#radio_pay_manual").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").show();
    $("#return").hide();
    $("#hn_pay_block").hide();
    $("#sell_deproom").hide();

    $("#input_Hn_pay_manual").focus();

    $("#select_deproom_manual").select2();
    $("#select_doctor_manual").select2();
    $("#select_procedure_manual").select2();

    $("#select_deproom_manual").change(function () {
      set_proceduce($("#select_deproom_manual").val());
      set_doctor($("#select_deproom_manual").val());
    });
    setTimeout(() => {
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
    }, 500);

    $("#input_Hn_pay_manual").val("");
    $("#input_box_pay_manual").val("");

    $("#input_Hn_pay_manual").attr("disabled", false);
    $("#input_box_pay_manual").attr("disabled", false);

    $("#input_time_service_manual").val(currentTime);
    $("#input_date_service_manual").val(output);
    $("#select_doctor_manual").val("").trigger("change");
    $("#select_deproom_manual").val("").trigger("change");
    $("#select_procedure_manual").val("").trigger("change");
    $("#input_docNo_deproom_manual").val("");
    $("#input_docNo_HN_manual").val("");
    $("#input_remark_manual").val("");
    $("#table_deproom_DocNo_pay_manual tbody").html("");
    $(".clear_doctor").attr("hidden", true);
    doctor_Array = [];
    $(".clear_procedure").attr("hidden", true);
    procedure_id_Array = [];
  });

  $("#radio_return_pay").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#return").show();
    $("#pay_manual").hide();
    $("#hn_pay_block").hide();
    $("#sell_deproom").hide();

    $("#row_return").show();
    $("#row_history_return").hide();

    $("#row_history_return").hide();


    $(".tab-button2").removeClass("active");
    $("#radio_return").addClass("active");


    feeddata_waitReturn();
    // feeddataClaim();
  });

  $("#radio_return").click(function () {
    $(".tab-button2").removeClass("active");
    $(this).addClass("active");
    $("#row_return").show();
    $("#row_history_return").hide();

    feeddata_waitReturn();
    // feeddataClaim();
  });

  $("#radio_history_return").click(function () {
    $(".tab-button2").removeClass("active");
    $(this).addClass("active");

    $("#row_return").hide();
    $("#row_history_return").show();

    feeddata_history_Return();
    // feeddata_waitReturn();
    // feeddataClaim();
  });

  $("#radio_history_pay").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").hide();
    $("#history_pay").show();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();
    $("#hn_pay_block").hide();
    $("#sell_deproom").hide();

    $(".clear_doctor").attr("hidden", true);
    doctor_Array = [];
    $(".clear_procedure").attr("hidden", true);
    procedure_id_Array = [];

    show_detail_history();
    $("#select_typeSearch_history").val('');

    if (!$("#select_deproom_history").hasClass("select2-hidden-accessible")) {
      $("#select_deproom_history").select2();
    }
    if (!$("#select_doctor_history").hasClass("select2-hidden-accessible")) {
      $("#select_doctor_history").select2();
    }
    if (!$("#select_procedure_history").hasClass("select2-hidden-accessible")) {
      $("#select_procedure_history").select2();
    }
    if (!$("#select_item_history").hasClass("select2-hidden-accessible")) {
      $("#select_item_history").select2();
    }

    setTimeout(() => {
      // $("#select_doctor_history").on("select2:select", function (e) {
      //   var selectedValue = e.params.data.id; // ดึงค่า value
      //   var selectedText = e.params.data.text; // ดึงค่า text
      //   if (selectedValue != "") {
      //     var index = doctor_Array.indexOf(selectedValue);
      //     if (index == -1) {
      //       doctor_Array.push(selectedValue);
      //       var _row = "";
      //       _row += `       <div  class='div_${selectedValue}  clear_doctor' onclick='DeleteDoctor(${selectedValue})'>
      //                           <label for="" class="custom-label">${selectedText}</label>
      //                       </div> `;
      //       $("#row_doctor_history").append(_row);
      //       $("#select_doctor_history").val("").trigger("change");
      //     }
      //     show_detail_history();
      //   }
      // });
      // $("#select_procedure_history").on("select2:select", function (e) {
      //   var selectedValue = e.params.data.id; // ดึงค่า value
      //   var selectedText = e.params.data.text; // ดึงค่า text
      //   if (selectedValue != "") {
      //     var index = procedure_id_Array.indexOf(selectedValue);
      //     if (index == -1) {
      //       procedure_id_Array.push(selectedValue);
      //       var _row = "";
      //       _row += `       <div  class='div_${selectedValue} clear_procedure' onclick='Deletprocedure(${selectedValue})'>
      //                           <label for="" class="custom-label">${selectedText}</label>
      //                       </div> `;
      //       $("#row_procedure_history").append(_row);
      //       $("#select_procedure_history").val("").trigger("change");
      //     }
      //     show_detail_history();
      //   }
      // });
    }, 500);

    $("#col_deproom_history").attr("hidden", true);
    $("#col_doctor_history").attr("hidden", true);
    $("#col_procedure_history").attr("hidden", true);
    $("#col_item_history").attr("hidden", true);
    // $("#col_hide_2").attr("hidden", true);
    $("#col_hide").attr("hidden", false);
  });

  $("#radio_hn_pay_block").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();
    $("#hn_pay_block").show();
    $("#sell_deproom").hide();

    $(".clear_doctor_block").attr("hidden", true);
    doctor_Array_block = [];
    $(".clear_procedure_block").attr("hidden", true);
    procedure_id_Array_block = [];

    show_detail_history_block();

    $("#select_typeSearch_history_block").val('');


    if (!$("#select_deproom_history_block").hasClass("select2-hidden-accessible")) {
      $("#select_deproom_history_block").select2();
    }
    if (!$("#select_doctor_history_block").hasClass("select2-hidden-accessible")) {
      $("#select_doctor_history_block").select2();
    }
    if (!$("#select_procedure_history_block").hasClass("select2-hidden-accessible")) {
      $("#select_procedure_history_block").select2();
    }


    $("#col_deproom_history_block").attr("hidden", true);
    $("#col_doctor_history_block").attr("hidden", true);
    $("#col_procedure_history_block").attr("hidden", true);

    $("#col_hide_2_block").attr("hidden", true);
    $("#col_hide_block").attr("hidden", false);

  });


  $("#radio_sell_deproom").click(function () {
    $(".tab-button").removeClass("active");
    $(this).addClass("active");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();
    $("#hn_pay_block").hide();
    $("#sell_deproom").show();

    $("#select_deproom_sell").val("").trigger("change");
    $("#select_deproom_sell").select2();

    $("#select_department_sell_right").val("").trigger("change");
    $("#select_department_sell_right").select2();


  });




  $("#input_hn_history_block").keypress(function (e) {
    if (e.which == 13) {
      show_detail_history_block();
    }
  });

  $("#input_hn_history").keypress(function (e) {
    if (e.which == 13) {
      show_detail_history();
    }
  });

  $("#radio_claim").click(function () {
    $("#radio_claim").css("color", "#bbbbb");
    $("#radio_claim").css("background", "#EAE1F4");

    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");
    $("#radio_pay_manual").css("color", "black");
    $("#radio_pay_manual").css("background", "");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").show();
    $("#pay_manual").hide();

    feeddataClaim();
  });

  show_detail_deproom_pay();
  select_deproom();
  select_doctor();
  select_procedure();
  select_item();
  select_department();
  $("#select_deproom_pay").select2();
});

$("#btn_block_hn").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การงด?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "block_item_byDocNo",
          txt_docno_request: $("#btn_edit_hn").data("docno"),
        },
        success: function (result) {
          var ObjData = JSON.parse(result);
          console.log(ObjData);
          show_detail_deproom_pay();
          showDialogSuccess("บันทึกสำเร็จ");

          $("#btn_edit_hn").attr("disabled", true);
          $("#btn_block_hn").attr("disabled", true);

          $("#input_Hn_pay").val('');
          $("#input_date_service").val('');
          $("#input_time_service").val('');
          $("#input_box_pay").val('');

          $("#table_deproom_DocNo_pay tbody").html("");

        },
      });
    }
  });
});
$("#btn_edit_hn").click(function () {
  $("#myModal_edit_hn").modal("toggle");

  setTimeout(() => {
    $("#select_doctor_editHN").select2({
      dropdownParent: $("#myModal_edit_hn"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });

    $("#select_deproom_editHN").select2({
      dropdownParent: $("#myModal_edit_hn"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });

    $("#select_procedure_editHN").select2({
      dropdownParent: $("#myModal_edit_hn"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });
  }, 500);

  procedure_edit_hn_Array = [];
  doctor_edit_hn_Array = [];

  $("#row_doctor_editHN").html("");
  $("#row_procedure_editHN").html("");

  $("#select_deproom_editHN").change(function () {
    set_proceduce2($("#select_deproom_editHN").val());
  });
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_Doctor",
      doctor: $("#btn_edit_hn").data("doctor"),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _row = "";
        $.each(ObjData, function (kay, value) {
          doctor_edit_hn_Array.push(value.ID.toString());
          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='DeleteDoctor_editHN(${value.ID})'>
                              <label for="" class="custom-label">${value.Doctor_Name}</label>
                          </div> `;
        });
        $("#row_doctor_editHN").append(_row);

        set_deproom2();
      }
    },
  });

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_Procedure",
      procedure: $("#btn_edit_hn").data("procedure"),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _row = "";
        $.each(ObjData, function (kay, value) {
          procedure_edit_hn_Array.push(value.ID.toString());

          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='Deleteprocedure_editHN(${value.ID})'>
                              <label for="" class="custom-label">${value.Procedure_TH}</label>
                          </div> `;
        });

        $("#row_procedure_editHN").append(_row);
      }
    },
  });

  setTimeout(() => {
    $("#select_doctor_editHN").on("select2:select", function (e) {
      var selectedValue = e.params.data.id; // ดึงค่า value
      var selectedText = e.params.data.text; // ดึงค่า text
      if (selectedValue != "") {
        var index = doctor_edit_hn_Array.indexOf(selectedValue);
        if (index == -1) {
          doctor_edit_hn_Array.push(selectedValue);
          var _row = "";
          _row += `       <div  class='div_${selectedValue}  clear_doctor' onclick='DeleteDoctor_editHN(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

          $("#row_doctor_editHN").append(_row);
          set_deproom2();
          $("#select_doctor_editHN").val("").trigger("change");
        }
      }
    });

    $("#select_procedure_editHN").on("select2:select", function (e) {
      var selectedValue = e.params.data.id; // ดึงค่า value
      var selectedText = e.params.data.text; // ดึงค่า text
      if (selectedValue != "") {
        var index = procedure_edit_hn_Array.indexOf(selectedValue);
        if (index == -1) {
          procedure_edit_hn_Array.push(selectedValue);
          var _row = "";
          _row += `       <div  class='div_${selectedValue} clear_procedure' onclick='Deleteprocedure_editHN(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

          $("#row_procedure_editHN").append(_row);

          $("#select_procedure_editHN").val("").trigger("change");
        }
      }
    });
  }, 500);

  // $("#btn_edit_hn").data('docno');
  setTimeout(() => {
    $("#input_box_pay_editHN").data("docno", $("#btn_edit_hn").data("docno"));
    $("#input_box_pay_editHN").val($("#btn_edit_hn").data("numberbox"));
    $("#input_Hn_pay_editHN").val($("#btn_edit_hn").data("hncode"));
    $("#input_date_service_editHN").val($("#btn_edit_hn").data("servicedate"));
    $("#input_time_service_editHN").val($("#btn_edit_hn").data("servicetime"));
    $("#select_deproom_editHN")
      .val($("#btn_edit_hn").data("departmeneoomid"))
      .trigger("change");

    set_proceduce2($("#btn_edit_hn").data("departmeneoomid"));
  }, 500);
});

$("#btn_save_edit_hn").click(function () {
  if (doctor_edit_hn_Array.length == 0) {
    showDialogFailed('กรุณาเลือกแพทย์');
    return;
  }

  if ($("#select_deproom_editHN").val() == "") {
    showDialogFailed('กรุณาเลือกห้องผ่าตัด');
    return;
  }

  if (procedure_edit_hn_Array.length == 0) {
    showDialogFailed('กรุณาเลือกหัตถการ');
    return;
  }
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การแก้ไขข้อมูล ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "save_edit_hn",
          DocNo_editHN: $("#input_box_pay_editHN").data("docno"),
          input_box_pay_editHN: $("#input_box_pay_editHN").val(),
          input_Hn_pay_editHN: $("#input_Hn_pay_editHN").val(),
          input_date_service_editHN: $("#input_date_service_editHN").val(),
          input_time_service_editHN: $("#input_time_service_editHN").val(),
          select_deproom_editHN: $("#select_deproom_editHN").val(),
          procedure_edit_hn_Array: procedure_edit_hn_Array,
          doctor_edit_hn_Array: doctor_edit_hn_Array,
        },
        success: function (result) {
          show_detail_deproom_pay();
          $("#myModal_edit_hn").modal("toggle");
          setTimeout(() => {
            $("#checkbox_" + $("#input_box_pay_editHN").data("docno")).click();
          }, 1000);

          // feeddata_waitReturn();
        },
      });
    }
  });
});

$("#input_pay").keypress(function (e) {
  if (e.which == 13) {
    if ($(this).val().trim() != "") {
      $("#input_pay").val(convertString($(this).val()));
      oncheck_pay($(this).val());
      $("#input_pay").val("");
    }
  }
});

$("#input_pay_manual").keypress(function (e) {
  if (e.which == 13) {
    if ($(this).val().trim() != "") {
      $("#input_pay_manual").val(convertString($(this).val()));
      oncheck_pay_manual($(this).val());
    }
  }
});

$("#input_box_pay_manual").keyup(function (e) {
  if ($(this).val().trim() != "") {
    $("#input_Hn_pay_manual").attr("disabled", true);
  } else {
    $("#input_Hn_pay_manual").attr("disabled", false);
  }
});

$("#input_Hn_pay_manual").keyup(function (e) {
  if ($(this).val().trim() != "") {
    $("#input_box_pay_manual").attr("disabled", true);
  } else {
    $("#input_box_pay_manual").attr("disabled", false);
  }
});

$("#input_returnpay_manual").keypress(function (e) {
  if (e.which == 13) {
    if ($("#input_returnpay_manual") == "") {
      showDialogFailed("กรุณาเลือกรายการ");
      return;
    }

    $("#input_returnpay_manual").val(convertString($(this).val()));
    oncheck_Returnpay_manual($(this).val());
  }
});

$("#input_returnpay").keypress(function (e) {
  if (e.which == 13) {
    if ($(this).val().trim() != "") {
      $("#input_returnpay").val(convertString($(this).val()));
      oncheck_Returnpay($(this).val());
    }
  }
});

$("#select_deproom_pay").change(function (e) {
  show_detail_deproom_pay();
});


function DeleteDoctor_editHN(selectedValue) {
  var index = doctor_edit_hn_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    doctor_edit_hn_Array.splice(index, 1);
  }

  console.log(doctor_edit_hn_Array);

  set_deproom2();
  $(".div_" + selectedValue).attr("hidden", true);
}

function DeleteDoctor_editHN_block(selectedValue) {
  var index = doctor_edit_hn_block_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    doctor_edit_hn_block_Array.splice(index, 1);
  }

  console.log(doctor_edit_hn_block_Array);

  set_deproom2_block();
  $(".div_" + selectedValue).attr("hidden", true);
}



function Deleteprocedure_editHN(selectedValue) {
  var index = procedure_edit_hn_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    procedure_edit_hn_Array.splice(index, 1);
  }

  console.log(procedure_edit_hn_Array);
  $(".div_" + selectedValue).attr("hidden", true);
}

function Deleteprocedure_editHN_block(selectedValue) {
  var index = procedure_edit_hn_block_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    procedure_edit_hn_block_Array.splice(index, 1);
  }

  console.log(procedure_edit_hn_block_Array);
  $(".div_" + selectedValue).attr("hidden", true);
}

function DeleteDoctor(selectedValue) {
  var index = doctor_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    doctor_Array.splice(index, 1);
  }

  console.log(doctor_Array);
  $(".div_" + selectedValue).attr("hidden", true);

  set_deproom();
  select_doctor();
  select_procedure();
  $(".clear_procedure").attr("hidden", true);
  procedure_id_Array = [];
  show_detail_history();
}

function Deletprocedure(selectedValue) {
  var index = procedure_id_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    procedure_id_Array.splice(index, 1);
  }

  console.log(procedure_id_Array);
  $(".div_" + selectedValue).attr("hidden", true);

  show_detail_history();
}

function show_detail_deproom_pay() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_deproom_pay",
      select_deproom_pay: $("#select_deproom_pay").val(),
      select_date_pay: $("#select_date_pay").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_pay").DataTable().destroy();
      $("#table_deproom_pay tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["departmentroomname"], function (kay, value) {
          _tr += `<tr id='trbg_${value.id}'>
                      <td class="f24 text-left"><i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;rotate: 180deg;' id='open_${value.id
            }' value='1' onclick='open_deproom_sub(${value.id
            })'></i> ${kay + 1}</td>
                      <td class="f24 text-left" style='font-weight:bold;'>${value.departmentroomname
            }</td>
                      <td class="" hidden></td>
                   </tr>`;
          $.each(ObjData[value.id], function (kay, value2) {
            if (value2.cnt_detail == "ครบ") {
              var txt = "ครบ";
              var sty = "color:#00bf63 ";
            } else {
              var txt = "ค้าง";
              var sty = "color:#ed1c24 ";
            }

            var titleP = '';
            if (value2.Procedure_TH == "button") {
              value2.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value2.procedure}")'>หัตถการ</a>`;
            } else {
              titleP = `title='${value2.Procedure_TH}'`;
            }

            var titleD = '';
            if (value2.Doctor_Name == "button") {
              value2.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value2.doctor}")'>แพทย์</a>`;
            } else {
              titleD = `title='${value2.Doctor_Name}'`;
            }

            if (value2.hn_record_id == "") {
              var tttt = value2.number_box;
            } else {
              var tttt = value2.hn_record_id;
            }

            if (value2.IsConfirm_pay == 1) {
              var sty = `style=background-color:#00bf63 `;
            } else {
              var sty = ``;
            }

            if (value2.IsManual > 0) {
              var txt = "manual";
              var btn_ = `<span   class="badge" style="width: 120px;background-color: #673ab7; color: white; padding: 0.5em 0.75em; font-size: 14px;">${txt}</span>`;
            } else {
              if (value2.cnt_detail == "ครบ") {
                var txt = "จ่ายแล้วทั้งหมด";
                var btn_ = `<span  onclick='showDetail_Permission("${value2.DocNo}")' class="badge btn-success" style="cursor:pointer; width: 120px; color: white; padding: 0.5em 0.75em; font-size: 14px;" id='textstatus_${value2.DocNo}'>${txt}</span>`;
              } else if (value2.cnt_detail == "บางส่วน") {
                var txt = "จ่ายแล้วบางส่วน";
                var btn_ = `<span  onclick='showDetail_Permission("${value2.DocNo}")' class="badge btn-primary" style="cursor:pointer;  width: 120px; color: white; padding: 0.5em 0.75em; font-size: 14px;" id='textstatus_${value2.DocNo}'>${txt}</span>`;
              } else {
                var txt = "รอดำเนินการ";
                var btn_ = `<span  onclick='showDetail_Permission("${value2.DocNo}")' class="badge btn-danger" style="cursor:pointer;  width: 120px; color: white; padding: 0.5em 0.75em; font-size: 14px;" id='textstatus_${value2.DocNo}'>${txt}</span>`;
              }
            }

            _tr += `<tr class='tr_${value.id} all111' ${sty} id='deproom_${value2.DocNo}'>
                          <td class='text-center' >

              
                          </td>
                          <td colspan="99" style=" padding: 0.75rem 1rem; ">
                              <div class="d-flex align-items-center justify-content-between">
                                <!-- ฝั่งซ้าย -->
                                <div class="d-flex align-items-center flex-wrap">
                                  <input id="checkbox_${value2.DocNo}"
                                        data-id="${value.id}"
                                        data-docno="${value2.DocNo}"
                                        data-hn="${value2.hn_record_id}"
                                        data-date="${value2.serviceDate}"
                                        data-time="${value2.serviceTime}"
                                        data-box="${value2.number_box}"
                                        data-doctor="${value2.doctorHN}"
                                        data-procedure="${value2.procedureHN}" 
                                        data-his_isstatus="${value2.his_IsStatus}"  type="checkbox" class="mr-3 form-check-input position-static clear_checkbox"  style="width: 20px;height: 20px;accent-color: #9A53FF;">

                                  <!-- HN -->
                                  <div class="text-truncate mr-2 text-dark" style="max-width: 150px; font-weight: 500;" title="${tttt}">
                                    ${tttt} 
                                  </div>

                                  <label class="pl-2 pr-2">|</label>
                                      
                                  <!-- Procedure -->
                                  <div class="text-truncate mr-2 text-dark" style="max-width: 200px;" ${titleP}>
                                    ${value2.Procedure_TH} 
                                  </div>

                                    <label class="pl-2 pr-2">|</label>

                                  <!-- Doctor -->
                                  <div class="text-truncate text-dark" style="max-width: 200px;" ${titleD}>
                                    ${value2.Doctor_Name} 
                                  </div>
                                </div>

                                <!-- ฝั่งขวา: ป้าย manual -->
                                <div>
                                  ${btn_}
                                </div>
                              </div>
                            </td>
                          <td hidden class='text-center'> <label id='text_balance_${value2.DocNo}' class='f18' style='font-weight:bold;${sty};text-decoration-line: underline;'>${txt}</label> </td>

                        </tr>`;
          });
        });
      }


      // <div class="form-check">
      //          <input 
      //             style="width: 20px;height: 20px;"
      //             class="form-check-input position-static clear_checkbox"
      //             type="checkbox"
      //             id="checkbox_${value2.DocNo}"
      //             data-id="${value.id}"
      //             data-docno="${value2.DocNo}"
      //             data-hn="${value2.hn_record_id}"
      //             data-date="${value2.serviceDate}"
      //             data-time="${value2.serviceTime}"
      //             data-box="${value2.number_box}"
      //             data-doctor="${value2.doctorHN}"
      //             data-procedure="${value2.procedureHN}" 
      //             data-his_isstatus="${value2.his_IsStatus}" >
      //         </div>


      //  <div class="row">
      //               <div class="col-md-2 text-left"> ${tttt}</div>
      //               <div class="col-md-4 text-left">${value2.Procedure_TH}</div>
      //               <div class="col-md-3 text-center">${value2.Doctor_Name}</div>
      //               <div class="col-md-3 text-center">${btn_}</div>
      //             </div>

      $("#table_deproom_pay tbody").html(_tr);

      $(".all111").show();

      $(".clear_checkbox").on("click", function () {
        const el = $(this);
        oncheck_show_byDocNo(
          el.data("id"),
          el.data("docno"),
          el.data("hn"),
          el.data("date"),
          el.data("time"),
          el.data("box"),
          el.data("doctor"),
          el.data("procedure"),
          el.data("his_isstatus")
        );
      });
    },
  });
}

function showDetail_Permission(DocNo) {
  $("#myModal_Detail_Permission").modal("toggle");

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_Permission",
      DocNo: DocNo,
    },
    success: function (result) {
      $("#table_Detail_Permission tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {
          var txt = "";
          if (value.cnt_over == 0) {
            txt = `<label class='f18' style='font-weight:bold;color:#1cc88a;' >ครบ</label>`;
          } else {
            txt = `<label class='f18' style='font-weight:bold;color:#e74a3b;' >ค้าง</label>`;
          }
          _tr += `<tr>
              <td class="text-left">${value.Permission}</td>
              <td class="text-center">${value.cnt}</td>
              <td class="text-center">${value.cnt_pay}</td>
              <td class="text-center">${txt}</td>
            </tr>`;
        });

        $("#table_Detail_Permission tbody").html(_tr);
      }
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

function oncheck_show_byDocNo(
  departmeneoomID,
  DocNo,
  hn_record_id,
  serviceDate,
  serviceTime,
  number_box,
  doctor,
  procedure,
  his_isstatus
) {
  $("#input_pay").focus();
  $(".all111").css("background-color", "");
  $("#deproom_" + DocNo).css("background-color", "#F9F5FF");

  if (his_isstatus == "2") {
    $("#input_pay").attr("disabled", true);
    $("#input_returnpay").attr("disabled", true);
  } else {
    $("#input_pay").attr("disabled", false);
    $("#input_returnpay").attr("disabled", false);
  }

  $("#btn_edit_hn").attr("disabled", false);
  $("#btn_block_hn").attr("disabled", false);

  $(".clear_checkbox").prop("checked", false);
  $("#checkbox_" + DocNo).prop("checked", true);

  $("#input_Hn_pay").val("HN Code : " + hn_record_id);
  $("#input_Hn_pay").data("docno", DocNo);
  $("#input_Hn_pay").data("hncode", hn_record_id);

  $("#input_Hn_pay").data("departmeneoomid", departmeneoomID);

  $("#input_date_service").val(serviceDate);
  $("#input_time_service").val(serviceTime);
  $("#input_box_pay").val(number_box);

  $("#btn_edit_hn").data("docno", DocNo);
  $("#btn_edit_hn").data("hncode", hn_record_id);
  $("#btn_edit_hn").data("numberbox", number_box);
  $("#btn_edit_hn").data("servicedate", serviceDate);
  $("#btn_edit_hn").data("servicetime", serviceTime);
  $("#btn_edit_hn").data("departmeneoomid", departmeneoomID);
  $("#btn_edit_hn").data("doctor", doctor);
  $("#btn_edit_hn").data("procedure", procedure);

  show_detail_item_ByDocNo();
}

function show_detail_item_ByDocNo() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_ByDocNo",
      DocNo: $("#input_Hn_pay").data("docno"),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_deproom_DocNo_pay").DataTable().destroy();
      $("#table_deproom_DocNo_pay tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var balance = value.cnt - value.cnt_pay;

          if (balance < 0) {
            // balance = 0;
            balance = value.cnt_pay - value.cnt;

            balance = "+" + balance;
          }

          if (value.Ismanual == 1 || value.IsRequest == 1) {
            value.cnt = 0;
            balance = 0;
          }

          var hidden = "";
          if (value.permission != "5") {
            if (value.warehouseID == value.permission) {
              hidden = "";
            } else {
              hidden = "hidden";
            }
          } else {
            hidden = "";
          }

          _tr += `<tr ${hidden} id='trdeproom_${value.itemcode}'>
                      <td>

                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">${value.itemname}</span>
                                    <button class=" btn-sm" disabled>${value.TyeName}</button>
                                  </div>

                      
                      </td>
                      <td  class='text-center' style='background-color:	#B3E5FC '><input type='text' style='  border: none !important;box-shadow: none !important; background: transparent !important;outline: none !important;' class='form-control text-center f18' value="${value.cnt}" disabled id="qty_request_${value.itemcode}"></td>
                      <td class='text-center'  style='background-color:#E0F7FA;'><input type='text'     style='  border: none !important;box-shadow: none !important; background: transparent !important;outline: none !important;' class='form-control text-center f18 loop_item_pay' value="${value.cnt_pay}" data-request='${value.IsRequest}'  data-manual='${value.Ismanual}'   data-itemcode='${value.itemcode}' disabled></td>
                      <td  class='text-center' style='background-color:#FFCDD2;'><input type='text'     style='  border: none !important;box-shadow: none !important; background: transparent !important;outline: none !important;' class='form-control text-center f18 loop_item_balance' disabled value="${balance}" id="balance_request_${value.itemcode}"></td>
                   </tr>`;
        });
      }

      $("#table_deproom_DocNo_pay tbody").html(_tr);

      setTimeout(() => {
        var check_q = 0;
        var check_all = 0;
        var hasRows = false;

        $(".loop_item_pay").each(function (key_, value_) {
          hasRows = true;
          var qP = parseInt($(this).val());
          // alert(qP);
          if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
            check_q++;
          }
          if (qP > 0) {
            check_all = 1;
          }
        });

        if (hasRows == false) {
          console.log("111");
          $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
            "รอดำเนินการ"
          );
          $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
            "btn-danger"
          );
          $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
            "btn-success"
          );
          $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
            "btn-primary"
          );
        } else {
          if (check_q == 0) {
            console.log("222");
            $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
              "จ่ายแล้วทั้งหมด"
            );
            $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
              "btn-danger"
            );
            $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
              "btn-primary"
            );
            $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
              "btn-success"
            );
          } else {
            if (check_all == 1) {
              console.log("333");
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                "จ่ายแล้วบางส่วน"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                "btn-primary"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-success"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-danger"
              );
            } else {
              console.log("444");
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                "รอดำเนินการ"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                "btn-danger"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-success"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-primary"
              );
            }
          }
        }
      }, 500);

      // var check_q = 0;
      // $(".loop_item_pay").each(function (key_, value_) {
      //   var qP = parseInt($(this).val());
      //   if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
      //     check_q++;
      //   }
      // });

      // if (check_q == 0) {
      //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ครบ");
      //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
      //     "color",
      //     "#00bf63"
      //   );
      // } else {
      //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ค้าง");
      //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
      //     "color",
      //     "#ed1c24"
      //   );
      // }
    },
  });
}

function updateService() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "updateService",
      input_date_service: $("#input_date_service").val(),
      input_time_service: $("#input_time_service").val(),
      DocNo_pay: $("#input_Hn_pay").data("docno"),
    },
    success: function (result) { },
  });
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
$("#btn_scan_RFid").click(function (e) {
  showLoading();

  setTimeout(() => {
    oncheck_pay_rfid();
  }, 300);
});

function oncheck_pay_rfid() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_pay_rfid",
      DocNo_pay: $("#input_Hn_pay").data("docno"),
      hncode: $("#input_Hn_pay").data("hncode"),
      input_date_service: $("#input_date_service").val(),
    },
    success: function (result) {
      var itemname = "";
      // var ObjData = JSON.parse(result);
      // $.each(ObjData, function (key, value) {

      //     if(value.check_exp == 'exp'){
      //       itemname += value.UsageCode+',';
      //     }

      // });
      // itemname = itemname.substring(0, itemname.length - 1);

      show_detail_item_ByDocNo();
      $("body").loadingModal("destroy");

      // setTimeout(() => {
      //   var check_q = 0;
      //   $(".loop_item_pay").each(function (key_, value_) {
      //     var qP = parseInt($(this).val());
      //     if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
      //       check_q++;
      //     }
      //   });

      //   if (check_q == 0) {
      //     $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ครบ");
      //     $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
      //       "color",
      //       "#00bf63"
      //     );
      //   } else {
      //     $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ค้าง");
      //     $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
      //       "color",
      //       "#ed1c24"
      //     );
      //   }
      // }, 1000);

      if (itemname != "") {
        Swal.fire({
          title: settext("alert_fail"),
          html: `อุปกรณ์หมดอายุไม่สามารถสแกนจ่ายได้ <br> ${itemname}`,
          icon: "warning",
        });
      }
    },
  });
}

$("#btn_scan_RFid_manual").click(function (e) {
  showLoading();

  setTimeout(() => {
    oncheck_pay_rfid_manual();
  }, 300);
});

function oncheck_pay_rfid_manual() {
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

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_pay_rfid_manual",
      input_Hn_pay_manual: $("#input_Hn_pay_manual").val(),
      input_box_pay_manual: $("#input_box_pay_manual").val(),
      input_docNo_deproom_manual: $("#input_docNo_deproom_manual").val(),
      input_docNo_HN_manual: $("#input_docNo_HN_manual").val(),
      input_date_service_manual: $("#input_date_service_manual").val(),
      input_time_service_manual: $("#input_time_service_manual").val(),
      // select_doctor_manual: $("#select_doctor_manual").val(),
      select_deproom_manual: $("#select_deproom_manual").val(),
      input_remark_manual: $("#input_remark_manual").val(),
      // select_procedure_manual: $("#select_procedure_manual").val(),
      select_doctor_manual: doctor_Array,
      select_procedure_manual: procedure_id_Array,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("body").loadingModal("destroy");
      $("#input_docNo_deproom_manual").val(ObjData.input_docNo_deproom_manual);
      $("#input_docNo_HN_manual").val(ObjData.input_docNo_HN_manual);

      show_detail_item_ByDocNo_manual();
      $("#input_pay_manual").val("");
    },
  });
}

function oncheck_pay_manual(input_pay_manual) {
  if (
    $("#input_Hn_pay_manual").val() == "" &&
    $("#input_box_pay_manual").val() == ""
  ) {
    showDialogFailed("กรุณากรอก เลขที่กล่อง หรือ HN Code");
    $("#input_pay_manual").val("");
    return;
  }

  if ($("#input_date_service_manual").val() == "") {
    showDialogFailed("กรุณาเลือกวันที่");
    $("#input_pay_manual").val("");
    return;
  }

  if ($("#input_pay_manual").val() == "") {
    showDialogFailed("กรุณาเลือกรายการ");
    $("#input_pay_manual").val("");

    return;
  }

  if (doctor_Array.length === 0) {
    showDialogFailed("กรุณาเลือกแพทย์");
    $("#input_pay_manual").val("");

    return;
  }

  if ($("#select_deproom_manual").val() == "") {
    showDialogFailed("กรุณาเลือกห้องตรวจ");
    $("#input_pay_manual").val("");

    return;
  }

  if (procedure_id_Array.length === 0) {
    showDialogFailed("กรุณาเลือกหัตถการ");
    $("#input_pay_manual").val("");

    return;
  }

  if ($("#select_deproom_manual").val() == "") {
    showDialogFailed("กรุณาเลือกห้องตรวจ");
    $("#input_pay_manual").val("");

    return;
  }

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_pay_manual",
      input_pay_manual: input_pay_manual,
      input_Hn_pay_manual: $("#input_Hn_pay_manual").val(),
      input_box_pay_manual: $("#input_box_pay_manual").val(),
      input_docNo_deproom_manual: $("#input_docNo_deproom_manual").val(),
      input_docNo_HN_manual: $("#input_docNo_HN_manual").val(),
      input_date_service_manual: $("#input_date_service_manual").val(),
      input_time_service_manual: $("#input_time_service_manual").val(),
      // select_doctor_manual: $("#select_doctor_manual").val(),
      select_deproom_manual: $("#select_deproom_manual").val(),
      input_remark_manual: $("#input_remark_manual").val(),
      // select_procedure_manual: $("#select_procedure_manual").val(),
      select_doctor_manual: doctor_Array,
      select_procedure_manual: procedure_id_Array,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("body").loadingModal("destroy");

      if (ObjData.count_itemstock == 3) {
        showDialogFailed("สแกนอุปกรณ์ซ้ำ");
        $("#input_pay_manual").val("");
        return;
      }

      if (ObjData.count_itemstock == 0) {
        showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
        $("#input_pay_manual").val("");
        return;
      }

      if (ObjData.count_itemstock == 9) {
        showDialogFailed("รหัสใช้งานหมดอายุไม่สามารถสแกนใช้งานได้");
        $("#input_pay_manual").val("");
        return;
      }

      if (ObjData.input_docNo_deproom_manual == "") {
        showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
      } else {
        $("#input_docNo_deproom_manual").val(
          ObjData.input_docNo_deproom_manual
        );
        $("#input_docNo_HN_manual").val(ObjData.input_docNo_HN_manual);

        setTimeout(() => {
          show_detail_item_ByDocNo_manual();
        }, 500);
      }

      $("#input_pay_manual").val("");
    },
  });

  $("#input_pay_manual").val("");
}

function oncheck_pay(input_pay) {
  if ($("#input_Hn_pay").data("docno") == "") {
    showDialogFailed("กรุณาเลือกห้องผ่าตัด");
    $("#input_pay").val("");
    return;
  }

  // CHECK status
  // var _exp = "";
  // var _Isdeproom = "";
  // $.ajax({
  //   url: "process/pay.php",
  //   type: "POST",
  //   data: {
  //     FUNC_NAME: "check_stataus",
  //     input_pay: input_pay,
  //   },
  //   success: function (result) {
  //     var ObjData = JSON.parse(result);
  //     if (!$.isEmptyObject(ObjData)) {
  //       $.each(ObjData, function (kay, value) {
  //           _exp = value.check_exp;
  //           _Isdeproom = value.Isdeproom;

  //       });
  //     }
  //   },
  // });

  setTimeout(() => {
    // if (_exp == "exp") {
    //   showDialogFailed(settext("alert_expired"));
    //   console.log("exp");
    //   $("#input_pay").val("");
    //   return;
    // }

    // if (_Isdeproom == "2" || _Isdeproom == "4") {
    //   console.log("hn");
    //   $("#input_pay").val("");
    //   search_hn_alert(input_pay);
    //   return;
    // }

    var ArrayItemStockID = [];
    var Arraypayoutdetailsubid = [];

    // $.ajax({
    //   url: "process/pay.php",
    //   type: "POST",
    //   data: {
    //     FUNC_NAME: "oncheckpayauto",
    //     QrCode: input_pay,
    //   },
    //   success: function (result) {
    //     var ObjData = JSON.parse(result);

    //     if (!$.isEmptyObject(ObjData)) {
    //       $.each(ObjData, function (kay, value) {
    //         ArrayItemStockID.push(value.RowId);
    //         Arraypayoutdetailsubid.push(value.Id);

    //         $.ajax({
    //           url: "process/recieve_stock.php",
    //           type: "POST",
    //           data: {
    //             FUNC_NAME: "onConfirmReceiveItemstock_auto",
    //             ArrayItemStockID: ArrayItemStockID,
    //             Arraypayoutdetailsubid: Arraypayoutdetailsubid,
    //             select_departmentRoom: "35",
    //             DocNo: value.DocNo,
    //           },
    //           success: function (result) {},
    //         });
    //       });
    //     }
    //   },
    // });

    $.ajax({
      url: "process/pay.php",
      type: "POST",
      data: {
        FUNC_NAME: "oncheck_pay",
        input_pay: input_pay,
        DocNo_pay: $("#input_Hn_pay").data("docno"),
        hncode: $("#input_Hn_pay").data("hncode"),
        departmeneoomID: $("#input_Hn_pay").data("departmeneoomid"),
        input_date_service: $("#input_date_service").val(),
        input_box_pay: $("#input_box_pay").val(),
      },
      success: function (result) {
        if (result == 0) {
          showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
        } else if (result == 1) {
          showDialogFailed("จ่ายครบแล้ว");
        } else if (result == 2) {
          show_detail_item_ByDocNo();
        } else if (result == 3) {
          showDialogFailed("สแกนอุปกรณ์ซ้ำ");
        } else if (result == 9) {
          showDialogFailed("รหัสใช้งานหมดอายุไม่สามารถสแกนใช้งานได้");
        } else {
          var ObjData = JSON.parse(result);
          if (!$.isEmptyObject(ObjData)) {
            $.each(ObjData, function (key, value) {
              $(".loop_item_pay").each(function (key_, value_) {
                if ($(this).data("itemcode") == value.ItemCode) {
                  if ($(this).data("manual") == 1) {
                    var _Qty = $(this).val();
                    $(this).val(parseInt(_Qty) + 1);
                  } else {
                    var _Qty = $(this).val();
                    $(this).val(parseInt(_Qty) + 1);

                    _Qty = parseInt(_Qty) + 1;

                    var _QtyRequest = $("#qty_request_" + value.ItemCode).val();
                    if (parseInt(_Qty) > parseInt(_QtyRequest)) {
                      var balance = parseInt(_Qty) - parseInt(_QtyRequest);
                      balance = "+" + balance;
                    } else {
                      var balance = parseInt(_QtyRequest) - parseInt(_Qty);
                    }

                    if (
                      $(this).data("request") == "0" &&
                      $(this).data("manual") == "0"
                    ) {
                      $("#balance_request_" + value.ItemCode).val(balance);
                    }

                    console.log(balance);
                  }

                  // var _QtyRequest = $("#qty_request_" + value.ItemCode).val();
                  // var _Qty = $(this).val();

                  // if (_QtyRequest == _Qty) {
                  // }
                  // $(this).val(parseInt(_Qty) + 1);

                  // var _QtyRequest_2 = $("#qty_request_" + value.ItemCode).val();
                  // var _Qty_2 = $(this).val();

                  // var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                  // if (balance2 < 0) {
                  //   balance2 = parseInt(_Qty_2) - parseInt(_QtyRequest_2);
                  //   balance2 = "+" + balance2;
                  // }

                  // $("#balance_request_" + value.ItemCode).val(balance2);
                }
              });
              var check_q = 0;
              var check_all = 0;
              $(".loop_item_pay").each(function (key_, value_) {
                var qP = parseInt($(this).val());
                // alert(qP);
                if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
                  check_q++;
                }
                if (qP > 0) {
                  check_all = 1;
                }
              });

              if (check_q == 0) {
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                  "จ่ายแล้วทั้งหมด"
                );
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass("btn-danger");
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass("btn-primary");
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass("btn-success");

              } else {
                if (check_all == 1) {
                  $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                    "จ่ายแล้วบางส่วน"
                  );
                  $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                    "btn-primary"
                  );
                  $(
                    "#textstatus_" + $("#input_Hn_pay").data("docno")
                  ).removeClass("btn-success");
                  $(
                    "#textstatus_" + $("#input_Hn_pay").data("docno")
                  ).removeClass("btn-danger");

                  console.log("11111");
                } else {
                  console.log("00000");

                  $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                    "รอดำเนินการ"
                  );
                  $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                    "btn-danger"
                  );
                  $(
                    "#textstatus_" + $("#input_Hn_pay").data("docno")
                  ).removeClass("btn-success");
                  $(
                    "#textstatus_" + $("#input_Hn_pay").data("docno")
                  ).removeClass("btn-primary");
                }
              }
            });
          }
        }
        $("#input_pay").val("");
      },
    });
  }, 200);

  // CHECK status
}

function search_hn_alert(input) {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "search_hn",
      input: input,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (localStorage.lang == "en") {
            Swal.fire({
              title: settext("alert_fail"),
              html: ` This serial no. has been scanned for patient use HN <label style='font-weight:bold;text-decoration-line: underline;'>${value.HnCode}</label>
                                              <br> 
                                               <label style='font-weight:bold;text-decoration-line: underline;'>${value.departmentroomname}</label> 
                                              <br> 
                                              วันที่<label style='font-weight:bold;text-decoration-line: underline;'>${value.DocDate}</label> 
                                              <br> 
                                              cannot be issue item.`,
              icon: "warning",
            });
          } else {
            Swal.fire({
              title: settext("alert_fail"),
              html: ` รหัสนี้ถูกสแกนใช้งานกับคนไข้ HN <label style='font-weight:bold;text-decoration-line: underline;'>${value.HnCode}</label>
                                              <br> 
                                               <label style='font-weight:bold;text-decoration-line: underline;'>${value.departmentroomname}</label> 
                                              <br> 
                                              วันที่ <label style='font-weight:bold;text-decoration-line: underline;'>${value.DocDate}</label> `,
              icon: "warning",
            });
          }
        });
      } else {
        showDialogFailed(settext("Not_Found"));
      }
    },
  });
}

function oncheck_Returnpay_manual(input_returnpay_manual) {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_Returnpay_manual",
      input_returnpay_manual: input_returnpay_manual,
      input_Hn_pay_manual: $("#input_Hn_pay_manual").val(),
      input_docNo_deproom_manual: $("#input_docNo_deproom_manual").val(),
      input_docNo_HN_manual: $("#input_docNo_HN_manual").val(),
      input_date_service_manual: $("#input_date_service_manual").val(),
      input_time_service_manual: $("#input_time_service_manual").val(),
      select_doctor_manual: $("#select_doctor_manual").val(),
      select_deproom_manual: $("#select_deproom_manual").val(),
      select_procedure_manual: $("#select_procedure_manual").val(),
    },
    success: function (result) {
      if (result == 2) {
        showDialogFailed("รหัสนี้อยู่คลังสต๊อกห้องผ่าตัด");
      }
      if (result == 0) {
        showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
      } else {
        show_detail_item_ByDocNo_manual();
      }
      $("#input_returnpay_manual").val("");
    },
  });
}

function oncheck_Returnpay(input_returnpay) {
  if ($("#input_Hn_pay").data("docno") == "") {
    showDialogFailed("กรุณาเลือกห้องผ่าตัด");
    $("#input_returnpay").val("");
    return;
  }

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_Returnpay",
      input_returnpay: input_returnpay,
      DocNo_pay: $("#input_Hn_pay").data("docno"),
      select_date_pay: $("#select_date_pay").val(),
      input_date_service: $("#input_date_service").val(),
    },
    success: function (result) {
      if (result == 2) {
        showDialogFailed("รหัสนี้อยู่คลังสต๊อกห้องผ่าตัด");
      }
      if (result == 0) {
        showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
      } else {
        var ObjData = JSON.parse(result);
        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (key, value) {
            $(".loop_item_pay").each(function (key_, value_) {
              if ($(this).data("itemcode") == value.ItemCode) {
                if ($(this).data("manual") == 1) {
                  var _Qty = $(this).val();
                  $(this).val(parseInt(_Qty) - 1);
                } else {
                  var _Qty = $(this).val();
                  $(this).val(parseInt(_Qty) - 1);

                  _Qty = parseInt(_Qty) - 1;

                  var _QtyRequest = $("#qty_request_" + value.ItemCode).val();
                  if (parseInt(_Qty) > parseInt(_QtyRequest)) {
                    var balance = parseInt(_Qty) - parseInt(_QtyRequest);
                    balance = "+" + balance;
                  } else {
                    var balance = parseInt(_QtyRequest) - parseInt(_Qty);
                  }

                  if (
                    $(this).data("request") == "0" &&
                    $(this).data("manual") == "0"
                  ) {
                    $("#balance_request_" + value.ItemCode).val(balance);
                  }

                  console.log(balance);
                }

                // var _Qty = $(this).val();
                // // alert(_Qty);
                // $(this).val(parseInt(_Qty) - 1);

                // var _QtyRequest_2 = $("#qty_request_" + value.ItemCode).val();
                // var _Qty_2 = $(this).val();

                // // var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                // // if (balance2 < 0) {
                // //   balance2 = 0;
                // // }
                // var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                // if (balance2 < 0) {
                //   // balance2 = 0;
                //   balance2 = parseInt(_Qty_2) - parseInt(_QtyRequest_2);
                //   balance2 = "+" + balance2;
                // }

                // $("#balance_request_" + value.ItemCode).val(balance2);
              }
            });

            $(".loop_item_pay").each(function (key_, value_) {
              var qP = parseInt($(this).val());

              if (qP == 0 && $("#qty_request_" + value.ItemCode).val() == 0) {
                $("#trdeproom_" + value.ItemCode).remove();
              }
            });

            var check_q = 0;
            var check_all = 0;
            $(".loop_item_pay").each(function (key_, value_) {
              var qP = parseInt($(this).val());

              if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
                check_q++;
              }
              // alert(qP);

              if (qP > 0) {
                check_all = 1;
              }

              // if(qP == 0)
            });

            if ($(".loop_item_pay").length === 0) {
              check_q++;
            }

            // alert(check_q);
            if (check_q == 0) {
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                "จ่ายแล้วทั้งหมด"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-danger"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).removeClass(
                "btn-primary"
              );
              $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                "btn-success"
              );
            } else {
              if (check_all == 1) {
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                  "จ่ายแล้วบางส่วน"
                );
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                  "btn-primary"
                );
                $(
                  "#textstatus_" + $("#input_Hn_pay").data("docno")
                ).removeClass("btn-success");
                $(
                  "#textstatus_" + $("#input_Hn_pay").data("docno")
                ).removeClass("btn-danger");
              } else {
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).text(
                  "รอดำเนินการ"
                );
                $("#textstatus_" + $("#input_Hn_pay").data("docno")).addClass(
                  "btn-danger"
                );
                $(
                  "#textstatus_" + $("#input_Hn_pay").data("docno")
                ).removeClass("btn-success");
                $(
                  "#textstatus_" + $("#input_Hn_pay").data("docno")
                ).removeClass("btn-primary");
              }
            }

            // var check_q = 0;
            // $(".loop_item_balance").each(function (key_, value_) {
            //   var qB = parseInt($(this).val());
            //   if (qB > 0) {
            //     check_q++;
            //   }
            // });

            // if (check_q == 0) {
            //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
            //     "ครบ"
            //   );
            //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
            //     "color",
            //     "#00bf63"
            //   );
            // } else {
            //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
            //     "ค้าง"
            //   );
            //   $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
            //     "color",
            //     "#ed1c24"
            //   );
            // }
          });
        }
      }
      $("#input_returnpay").val("");
    },
  });
}

function open_deproom_sub(id) {

  if ($("#open_" + id).val() == 1) {
    $("#open_" + id).val(0);
    $("#open_" + id).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + id).hide(300);

    $("#trbg_" + id).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    if ($("#open_" + id).val() == "") {
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
}

function show_detail_item_ByDocNo_manual() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_ByDocNo_manual",
      input_docNo_deproom_manual: $("#input_docNo_deproom_manual").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_deproom_DocNo_pay_manual tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var balance = value.cnt - value.cnt_pay;

          if (balance < 0) {
            // balance = 0;
            balance = value.cnt_pay - value.cnt;

            balance = "+" + balance;
          }

          var typename = "";
          if (value.TyeName == "SUDs") {
            typename = "danger";
          }
          if (value.TyeName == "OR Implant") {
            typename = "primary";
          }
          if (value.TyeName == "Sterile") {
            typename = "success";
          }
          _tr += `<tr>
                      <td  class='text-center'>${kay + 1}</td>
                      <td>

                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">${value.itemname}</span>
                                    <button class="btn btn-outline-${typename} btn-sm" disabled>${value.TyeName
            }</button>
                                  </div>

                      
                      </td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18' value="${value.cnt
            }" disabled id="qty_request_${value.itemcode}"></td>
                      <td class='text-center' style='background-color:#EEFBF9;'><input type='text' class='form-control text-center f18 loop_item_pay' value="${value.cnt_pay
            }"  data-itemcode='${value.itemcode}' disabled></td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18 loop_item_balance' disabled value="${balance}" id="balance_request_${value.itemcode
            }"></td>
                   </tr>`;
        });
      }

      $("#table_deproom_DocNo_pay_manual tbody").html(_tr);
    },
  });
}

// history
$("#select_deproom_history").change(function (e) {
  show_detail_history();
});
$("#select_doctor_history").change(function (e) {
  show_detail_history();
});
$("#select_procedure_history").change(function (e) {
  show_detail_history();
});

$("#select_typeSearch_history").change(function (e) {
  $("#select_deproom_history").val("").trigger("change");
  $("#select_doctor_history").val("").trigger("change");
  $("#select_procedure_history").val("").trigger("change");
  $("#select_item_history").val("").trigger("change");


  if ($(this).val() == "") {
    $("#col_deproom_history").attr("hidden", true);
    $("#col_doctor_history").attr("hidden", true);
    $("#col_procedure_history").attr("hidden", true);
    $("#col_item_history").attr("hidden", true);
    $("#col_hide").attr("hidden", false);
    // $("#col_hide_2").attr("hidden", true);
  }
  if ($(this).val() == "1") {
    $("#col_deproom_history").attr("hidden", false);
    $("#col_doctor_history").attr("hidden", true);
    $("#col_procedure_history").attr("hidden", true);
    $("#col_item_history").attr("hidden", true);
    $("#col_hide").attr("hidden", true);
    // $("#col_hide_2").attr("hidden", false);
  }
  if ($(this).val() == "2") {
    $("#col_deproom_history").attr("hidden", true);
    $("#col_doctor_history").attr("hidden", false);
    $("#col_procedure_history").attr("hidden", true);
    $("#col_item_history").attr("hidden", true);
    $("#col_hide").attr("hidden", true);
    // $("#col_hide_2").attr("hidden", false);
  }
  if ($(this).val() == "3") {
    $("#col_deproom_history").attr("hidden", true);
    $("#col_doctor_history").attr("hidden", true);
    $("#col_procedure_history").attr("hidden", false);
    $("#col_item_history").attr("hidden", true);
    $("#col_hide").attr("hidden", true);
    // $("#col_hide_2").attr("hidden", false);
  }
  if ($(this).val() == "4") {
    $("#col_deproom_history").attr("hidden", true);
    $("#col_doctor_history").attr("hidden", true);
    $("#col_procedure_history").attr("hidden", true);
    $("#col_item_history").attr("hidden", false);
    $("#col_hide").attr("hidden", true);
    // $("#col_hide_2").attr("hidden", false);yy
  }
});

$("#select_item_history").change(function (e) {

  if ($("#select_item_history").val() != "") {
    $("#myModal_Detail_item_history").modal('toggle');

    let selectedText = $("#select_item_history option:selected").text();

    $("#header_item").text(selectedText);

    showDetail_item_history();
  }
});

function showDetail_item_history() {
  $.ajax({
    url: "process/pay.php",
    type: 'POST',
    data: {
      'FUNC_NAME': 'showDetail_item_history',
      select_item_history: $("#select_item_history").val(),
      select_date_history_s: $("#select_date_history_S").val(),
      select_date_history_l: $("#select_date_history_L").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      var detail = ``;
      $("#table_Detail_item_history tbody").html("");
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData['item'], function (kay, value) {


          if (value.Procedure_TH == "button") {
            var title = ``;
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          } else {
            var title = `title='${value.Procedure_TH}' `;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          if (value.hn_record_id == "") {
            value.hn_record_id = value.number_box;
          }

          detail += `<tr class='color2' onclick='showTr_item(${kay})' id='trmain_item_${kay}'>
                      <td class="text-center" style="max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" title='${value.hn_record_id}'>${value.hn_record_id}</td>
                      <td class="text-left" style="max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" ${value.Doctor_Name}>${value.Doctor_Name}</td>
                      <td class="text-left" style="max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" title='${title}'>${value.Procedure_TH}</td>
                      <td class="text-left" style="max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" title='${value.departmentroomname}'>${value.departmentroomname}</td>
                      <td class="text-center">${value.serviceDate} ${value.serviceTime}</td>
                      <td class="text-center">${value.count_itemstock}</td>
                      </tr>`;







        });
        $("#table_Detail_item_history tbody").html(detail);



      }



    }
  });
}


function showTr_item(key) {
  // $(".trDetail_" + id).attr('hidden', false);

  $(".color2").css("background-color", "");
  $("#trmain_item_" + key).css("background-color", "#f8aeae");



  if ($(".trDetail_item_" + key).is(':hidden')) {
    $(".trDetail_item_" + key).attr('hidden', false);
  } else {
    $(".trDetail_item_" + key).attr('hidden', true);
  }

}

// history
$("#select_deproom_history_block").change(function (e) {
  show_detail_history_block();
});
$("#select_doctor_history_block").change(function (e) {
  show_detail_history_block();
});
$("#select_procedure_history_block").change(function (e) {
  show_detail_history_block();
});

$("#select_typeSearch_history_block").change(function (e) {
  $("#select_deproom_history_block").val("").trigger("change");
  $("#select_doctor_history_block").val("").trigger("change");
  $("#select_procedure_history_block").val("").trigger("change");

  if ($(this).val() == "") {
    $("#col_deproom_history_block").attr("hidden", true);
    $("#col_doctor_history_block").attr("hidden", true);
    $("#col_procedure_history_block").attr("hidden", true);
    $("#col_hide_block").attr("hidden", false);
    $("#col_hide_2_block").attr("hidden", true);
  }
  if ($(this).val() == "1") {
    $("#col_doctor_history_block").attr("hidden", true);
    $("#col_procedure_history_block").attr("hidden", true);
    $("#col_hide_block").attr("hidden", true);

    setTimeout(() => {
      $("#col_deproom_history_block").attr("hidden", false);
      $("#col_hide_2_block").attr("hidden", false);
    }, 300);
  }
  if ($(this).val() == "2") {
    $("#col_deproom_history_block").attr("hidden", true);
    $("#col_procedure_history_block").attr("hidden", true);
    $("#col_hide_block").attr("hidden", true);

    setTimeout(() => {
      $("#col_doctor_history_block").attr("hidden", false);
      $("#col_hide_2_block").attr("hidden", false);
    }, 300);
  }
  if ($(this).val() == "3") {
    $("#col_deproom_history_block").attr("hidden", true);
    $("#col_doctor_history_block").attr("hidden", true);
    $("#col_hide_block").attr("hidden", true);

    setTimeout(() => {
      $("#col_procedure_history_block").attr("hidden", false);
      $("#col_hide_2_block").attr("hidden", false);
    }, 300);
  }
});


$("#checkbox_filter").change(function () {
  $("#select_deproom_history_block").val("").trigger("change");
  $("#select_doctor_history_block").val("").trigger("change");
  $("#select_procedure_history_block").val("").trigger("change");
  setTimeout(() => {
    show_detail_history_block();
  }, 500);
});

function show_detail_history_block() {

  if ($("#checkbox_filter").is(":checked")) {
    var check_Box = 1;
  } else {
    var check_Box = 0;
  }

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history_block",
      select_date_history_s: $("#select_date_history_S_block").val(),
      select_date_history_l: $("#select_date_history_L_block").val(),
      select_deproom_history: $("#select_deproom_history_block").val(),
      input_hn_history: $("#input_hn_history_block").val(),
      select_doctor_history: $("#select_doctor_history_block").val(),
      select_procedure_history: $("#select_procedure_history_block").val(),
      check_Box: check_Box,
      // select_doctor_history: doctor_Array,
      // select_procedure_history: procedure_id_Array,
    },
    success: function (result) {
      var _tr = "";
      $("#table_history_block").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            var title = ``;
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          } else {
            var title = `title='${value.Procedure_TH}' `;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          if (value.hn_record_id == "") {
            value.hn_record_id = value.number_box;
          }
          if (value.FirstName == null) {
            value.FirstName = "";
          }

          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serviceDate} ${value.serviceTime
            }</td>
                      <td class='text-center' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.hn_record_id}</td>
                      <td class='text-left' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.Doctor_Name}</td>
                      <td class='text-left' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' ${title}>${value.Procedure_TH}</td>
                      <td class='text-left' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.departmentroomname}</td>
                      <td class='text-center'> <label style="color:blue;cursor:pointer;text-decoration: underline;" onclick="showDetail_item_block('${value.DocNo}')" > อุปกรณ์ </label></td>
                      <td class='text-center'><button class='btn f18 btn-success btn_block' style='width:80%;'  style='color:#fff;'
                                id="btn_block_${value.DocNo}"
                                data-docno="${value.DocNo}"
                                data-hn="${value.hn_record_id}"
                                data-date="${value.serviceDate}"
                                data-time="${value.serviceTime}"
                                data-box="${value.number_box}"
                                data-doctor="${value.doctor}"
                                data-procedure="${value.procedure}" 
                                data-departmentroomname="${value.deproom_ID}" 
                      >อัพเดตข้อมูล</button></td>
                      <td class='text-center'><button class='btn btn-outline-danger f18 ' style='width:80%;' onclick='cancel_item_byDocNo("${value.DocNo}","${value.Remark}")' >ยกเลิก</button></td>
                   </tr>`;
        });
      }

      $("#table_history_block tbody").html(_tr);
      $("#table_history_block").DataTable({
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
            width: "3%",
            targets: 0,
          },
          {
            width: "5%",
            targets: 1,
          },
          {
            width: "5%",
            targets: 2,
          },
          {
            width: "5%",
            targets: 3,
          },
          {
            width: "5%",
            targets: 4,
          },
          {
            width: "5%",
            targets: 5,
          },
          {
            width: "5%",
            targets: 6,
          },
          {
            width: "5%",
            targets: 7,
          },
          {
            width: "5%",
            targets: 8,
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


      $(".btn_block").on("click", function () {
        const el = $(this);
        onclick_show_modal_block(
          el.data("docno"),
          el.data("hn"),
          el.data("date"),
          el.data("time"),
          el.data("box"),
          el.data("doctor"),
          el.data("procedure"),
          el.data("departmentroomname")
        );
      });


    },
  });
}

function showDetail_item_block(DocNo) {
  $("#myModal_Detail_Block").modal("toggle");

  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_item_block",
      DocNo: DocNo,
    },
    success: function (result) {
      $("#table_Detail_item_block tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {

          _tr += `<tr>
              <td class="text-center">${value.itemcode2}</td>
              <td class="text-left">${value.itemname}</td>
              <td class="text-center">${value.cnt_pay}</td>
            </tr>`;
        });

        $("#table_Detail_item_block tbody").html(_tr);
      }
    },
  });

}

function onclick_show_modal_block(docno, hn, date, time, box, doctor, procedure, departmentroomname) {
  $("#myModal_edit_hn_block").modal("toggle");

  $("#input_box_pay_editHN_block").data("docno", docno);
  $("#input_box_pay_editHN_block").val(box);
  $("#input_Hn_pay_editHN_block").val(hn);
  $("#input_date_service_editHN_block").val(date);
  $("#input_time_service_editHN_block").val(time);

  // $("#select_doctor_editHN_block").val(doctor);
  // $("#select_procedure_editHN_block").val(procedure);

  setTimeout(() => {
    $("#select_doctor_editHN_block").select2({
      dropdownParent: $("#myModal_edit_hn_block"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });

    $("#select_deproom_editHN_block").select2({
      dropdownParent: $("#myModal_edit_hn_block"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });

    $("#select_procedure_editHN_block").select2({
      dropdownParent: $("#myModal_edit_hn_block"), // 👈 ต้องชี้ dropdownParent เป็น modal
    });
  }, 500);


  procedure_edit_hn_block_Array = [];
  doctor_edit_hn_block_Array = [];

  $("#row_doctor_editHN_block").html("");
  $("#row_procedure_editHN_block").html("");

  $("#select_deproom_editHN_block").change(function () {
    set_proceduce2_block($("#select_deproom_editHN_block").val());
  });

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
          doctor_edit_hn_block_Array.push(value.ID.toString());
          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='DeleteDoctor_editHN_block(${value.ID})'>
                              <label for="" class="custom-label">${value.Doctor_Name}</label>
                          </div> `;
        });
        $("#row_doctor_editHN_block").append(_row);

        set_deproom2_block();
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
          procedure_edit_hn_block_Array.push(value.ID.toString());

          _row += `       <div  class='div_${value.ID} pl-3 clear_doctor' onclick='Deleteprocedure_editHN_block(${value.ID})'>
                              <label for="" class="custom-label">${value.Procedure_TH}</label>
                          </div> `;
        });

        $("#row_procedure_editHN_block").append(_row);
      }
    },
  });

  setTimeout(() => {
    $("#select_doctor_editHN_block").on("select2:select", function (e) {
      var selectedValue = e.params.data.id; // ดึงค่า value
      var selectedText = e.params.data.text; // ดึงค่า text
      if (selectedValue != "") {
        var index = doctor_edit_hn_block_Array.indexOf(selectedValue);
        if (index == -1) {
          doctor_edit_hn_block_Array.push(selectedValue);
          var _row = "";
          _row += `       <div  class='div_${selectedValue}  clear_doctor' onclick='DeleteDoctor_editHN_block(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

          $("#row_doctor_editHN_block").append(_row);
          set_deproom2_block();
          $("#select_doctor_editHN_block").val("").trigger("change");
        }
      }
    });

    $("#select_procedure_editHN_block").on("select2:select", function (e) {
      var selectedValue = e.params.data.id; // ดึงค่า value
      var selectedText = e.params.data.text; // ดึงค่า text
      if (selectedValue != "") {
        var index = procedure_edit_hn_block_Array.indexOf(selectedValue);
        if (index == -1) {
          procedure_edit_hn_block_Array.push(selectedValue);
          var _row = "";
          _row += `       <div  class='div_${selectedValue} clear_procedure' onclick='Deleteprocedure_editHN_block(${selectedValue})'>
                              <label for="" class="custom-label">${selectedText}</label>
                          </div> `;

          $("#row_procedure_editHN_block").append(_row);

          $("#select_procedure_editHN_block").val("").trigger("change");
        }
      }
    });


    $("#select_deproom_editHN_block").val(departmentroomname).trigger("change");

  }, 500);



}

$("#btn_save_edit_hn_block").click(function () {

  if (doctor_edit_hn_block_Array.length == 0) {
    showDialogFailed('กรุณาเลือกแพทย์');
    return;
  }

  if ($("#select_deproom_editHN_block").val() == "") {
    showDialogFailed('กรุณาเลือกห้องผ่าตัด');
    return;
  }

  if (procedure_edit_hn_block_Array.length == 0) {
    showDialogFailed('กรุณาเลือกหัตถการ');
    return;
  }
  // alert($("#input_box_pay_editHN_block").data("docno"));
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การแก้ไขข้อมูล ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "save_edit_hn_block",
          DocNo_editHN_block: $("#input_box_pay_editHN_block").data("docno"),
          input_box_pay_editHN_block: $("#input_box_pay_editHN_block").val(),
          input_Hn_pay_editHN_block: $("#input_Hn_pay_editHN_block").val(),
          input_date_service_editHN_block: $("#input_date_service_editHN_block").val(),
          input_time_service_editHN_block: $("#input_time_service_editHN_block").val(),
          // select_doctor_editHN_block: $("#select_doctor_editHN_block").val(),
          select_deproom_editHN_block: $("#select_deproom_editHN_block").val(),
          // select_procedure_editHN_block: $("#select_procedure_editHN_block").val(),
          procedure_edit_hn_block_Array: procedure_edit_hn_block_Array,
          doctor_edit_hn_block_Array: doctor_edit_hn_block_Array,
        },
        success: function (result) {


          showDialogSuccess('บันทึกสำเร็จ');

          setTimeout(function () {
            show_detail_history_block();
            $("#myModal_edit_hn_block").modal("toggle");
          }, 500);
        },
      });
    }
  });
});



function show_detail_history() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date_history_s: $("#select_date_history_S").val(),
      select_date_history_l: $("#select_date_history_L").val(),
      select_deproom_history: $("#select_deproom_history").val(),
      input_hn_history: $("#input_hn_history").val(),
      select_doctor_history: $("#select_doctor_history").val(),
      select_procedure_history: $("#select_procedure_history").val(),
      // select_doctor_history: doctor_Array,
      // select_procedure_history: procedure_id_Array,
    },
    success: function (result) {
      var _tr = "";
      $("#table_history").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            var title = `title='${value.Procedure_TH}' `;
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          } else {
            var title = `title='${value.Procedure_TH}' `;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          if (value.cnt_pay > 0) {
            var hidden = `<button class=' btn f18' style='background-color:#643695;color:#fff;width:80%;' onclick='show_Report("${value.DocNo}","${value.Remark}")'>รายงาน</button>`;
          } else {
            var hidden = `<button class=' btn f18 btn-primary ' style='color:#fff;width:80%;'>รอดำเนินการ</button>`;
          }

          if (value.Remark == 'sell') {
            var hidden = `<button  class=' btn f18' style='background-color:#643695;color:#fff;width:80%;' onclick='show_Report("${value.DocNo}","${value.Remark}")'>รายงาน</button>`;
          }

          if (value.hn_record_id == "") {
            value.hn_record_id = value.number_box;
          }
          if (value.FirstName == null) {
            value.FirstName = "";
          }

          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.CreateDate}</td>
                      <td class='text-center'>${value.serviceDate} ${value.serviceTime}</td>
                      <td class='text-center'>${value.FirstName}</td>
                      <td class='text-center' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.hn_record_id}</td>
                      <td class='text-left' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.Doctor_Name}</td>
                      <td class='text-left' style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' ${title}>${value.Procedure_TH}</td>
                      <td class='text-left'   style='max-width: 100px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>${value.departmentroomname}</td>
                      <td class='text-center'><button class='btn btn-outline-danger f18' style='width:80%;' onclick='cancel_item_byDocNo("${value.DocNo}","${value.Remark}")' >ยกเลิก</button></td>
                      <td class='text-center'>${hidden}</td>
                   </tr>`;
        });
      }

      $("#table_history tbody").html(_tr);
      $("#table_history").DataTable({
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
            width: "3%",
            targets: 0,
          },
          {
            width: "5%",
            targets: 1,
          },
          {
            width: "8%",
            targets: 2,
          },
          {
            width: "5%",
            targets: 3,
          },
          {
            width: "5%",
            targets: 4,
          },
          {
            width: "5%",
            targets: 5,
          },
          {
            width: "5%",
            targets: 6,
          },
          {
            width: "5%",
            targets: 7,
          },
          {
            width: "8%",
            targets: 8,
          },
          {
            width: "8%",
            targets: 9,
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

$("#btn_show_report").click(function () {
  option =
    "?select_date_history_s=" +
    $("#select_date_history_S").val() +
    "&select_date_history_l=" +
    $("#select_date_history_L").val();
  window.open(
    "report/phpexcel/Report_Issue_Order_HN.php" + option + "&Userid=" + Userid,
    "_blank"
  );
});

function show_Report(DocNo, Remark) {
  option = "?DocNo=" + DocNo;
  if (Remark == 'sell') {
    window.open("report/Report_Issue_sell.php" + option, "_blank");
  } else {
    window.open("report/Report_Issue.php" + option, "_blank");
  }
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

function cancel_item_byDocNo(DocNo, Remark) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน! การยกเลิก?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      showLoading();

      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "cancel_item_byDocNo",
          txt_docno_request: DocNo,
          Remark: Remark,
        },
        success: function (result) {
          var ObjData = JSON.parse(result);
          console.log(ObjData);
          $("body").loadingModal("destroy");
          showDialogSuccess("ยกเลิกสำเร็จ");

          setTimeout(() => {
            show_detail_history_block();
            show_detail_history();
          }, 300);
        },
      });


    }
  });
}

function edit_item_byDocNo(
  DocNo,
  hn_record_id,
  serviceDate,
  doctor_ID,
  procedure_ID,
  deproom_ID,
  Remark
) {
  $("#radio_create_request").click();

  $("#txt_docno_request").val(DocNo);
  $("#input_hn_request").val(hn_record_id);
  $("#select_date_request").val(serviceDate);
  $("#select_doctor_request").val(doctor_ID);
  $("#select_deproom_request").val(deproom_ID);
  $("#select_procedure_request").val(procedure_ID);
  $("#input_remark_request").val(Remark);

  show_detail_request_byDocNo();
}

// history

//////////////////////////////////////////////////////////////// select


function select_item() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_item",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกอุปกรณ์</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.itemcode}" >${value.itemname}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_item_history").html(option);
    },
  });
}


function select_department() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_department",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกหน่วยงาน</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.DepName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_deproom_sell").html(option);
      $("#select_department_sell_right").html(option);

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
      $("#select_deproom_pay").html(option);
      $("#select_deproom_history").html(option);
      $("#select_deproom_history_block").html(option);
      $("#select_deproom_manual").html(option);
      $("#select_deproom_editHN").html(option);
      $("#select_deproom_editHN_block").html(option);
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
      $("#select_doctor_history_block").html(option);
      $("#select_doctor_history").html(option);
      $("#select_doctor_manual").html(option);
      $("#select_doctor_editHN").html(option);
      $("#select_doctor_editHN_block").html(option);
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
      $("#select_procedure_history_block").html(option);
      $("#select_procedure_history").html(option);
      $("#select_procedure_manual").html(option);
      $("#select_procedure_editHN").html(option);
      $("#select_procedure_editHN_block").html(option);
    },
  });
}

// return

$("#btn_send_return_data").click(function () {
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
      showLoading();

      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "onReturnData",
        },
        success: function (result) {
          $("body").loadingModal("destroy");
          feeddata_waitReturn();
        },
      });
    }
  });
});
$("#input_scan_return").keypress(function (e) {
  if (e.which == 13) {
    $("#input_scan_return").val(convertString($(this).val().trim()));
    $.ajax({
      url: "process/pay.php",
      type: "POST",
      data: {
        FUNC_NAME: "checkScanReturn",
        UsageCode: $(this).val(),
      },
      success: function (result) {
        var ObjData = JSON.parse(result);

        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
            if (value.Isdeproom == 0) {
              showDialogFailed("รหัสนี้อยู่คลังสต๊อกห้องผ่าตัด");
              $("#input_scan_return").val("");
              return;
            }
            if (value.IsCross == 9) {
              showDialogFailed("สแกนรหัสซ้ำ");
              $("#input_scan_return").val("");
              return;
            }
            var UsageCode = value.UsageCode;
            // alert(UsageCode);
            $.ajax({
              url: "process/pay.php",
              type: "POST",
              data: {
                FUNC_NAME: "updateReturn",
                UsageCode: UsageCode,
              },
              success: function (result) {
                feeddata_waitReturn();
              },
            });
          });
        } else {
          showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
        }

        $("#input_scan_return").val("");
      },
    });
  }
});

$("#input_search_history_return").keyup(function (e) {
  feeddata_history_Return();
});
function feeddata_history_Return() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_history_Return",
      input_search_history_return: $("#input_search_history_return").val(),
      select_date_history_return: $("#select_date_history_return").val(),
    },
    success: function (result) {
      // $("#table_item_claim").DataTable().destroy();
      $("#table_history_return").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center">${value.UsageCode}</td>` +
            `<td class="text-left">${value.itemname}</td>` +
            `<td class="text-left">${value.FirstName}</td>` +
            `<td class="text-center">${value.hn_record_id}</td>` +
            ` </tr>`;
        });

        $("#table_history_return tbody").html(_tr);
        $("#table_history_return").DataTable({
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
              width: "2%",
              targets: 0,
            },
            {
              width: "15%",
              targets: 1,
            },
            {
              width: "35%",
              targets: 2,
            },
            {
              width: "10%",
              targets: 3,
            },
            {
              width: "10%",
              targets: 4,
            }
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
      }
    },
  });
}

function feeddata_waitReturn() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_waitReturn",
    },
    success: function (result) {
      // $("#table_item_claim").DataTable().destroy();
      $("#table_item_return tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {
          if (value.cnt > 0) {
            _tr +=
              `<tr> ` +
              `<td class="text-center">${kay + 1}</td>` +
              `<td class="text-center">${value.itemcode}</td>` +
              `<td class="text-left">${value.itemname}</td>` +
              `<td class="text-center">${value.cnt}</td>` +
              ` </tr>`;
          }
        });

        $("#table_item_return tbody").html(_tr);
      }
    },
  });
}

// claim
$("#input_scanclaim").keypress(function (e) {
  if (e.which == 13) {
    $("#input_scanclaim").val(convertString($(this).val().trim()));
    $.ajax({
      url: "process/pay.php",
      type: "POST",
      data: {
        FUNC_NAME: "checkClaim",
        UsageCode: $(this).val(),
      },
      success: function (result) {
        var ObjData = JSON.parse(result);

        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
            var UsageCode = value.UsageCode;
            // alert(UsageCode);
            $.ajax({
              url: "process/pay.php",
              type: "POST",
              data: {
                FUNC_NAME: "updateClaim",
                UsageCode: UsageCode,
              },
              success: function (result) {
                feeddataClaim();
              },
            });
          });
        } else {
          showDialogFailed(settext("alert_noItem"));
        }

        $("#input_scanclaim").val("");
      },
    });
  }
});
$("#input_return_claim").keypress(function (e) {
  if (e.which == 13) {
    $("#input_return_claim").val(convertString($(this).val().trim()));
    $.ajax({
      url: "process/pay.php",
      type: "POST",
      data: {
        FUNC_NAME: "checkClaimReturn",
        UsageCode: $(this).val(),
      },
      success: function (result) {
        var ObjData = JSON.parse(result);

        if (!$.isEmptyObject(ObjData)) {
          $.each(ObjData, function (kay, value) {
            var UsageCode = value.UsageCode;
            // alert(UsageCode);
            $.ajax({
              url: "process/pay.php",
              type: "POST",
              data: {
                FUNC_NAME: "updateClaimReturn",
                UsageCode: UsageCode,
              },
              success: function (result) {
                feeddataClaim();
              },
            });
          });
        } else {
          showDialogFailed(settext("alert_noItem"));
        }

        $("#input_return_claim").val("");
      },
    });
  }
});
$("#btn_send_nsterile_claim").click(function () {
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
      // $('#btn_send').click();

      onSendNsterile();
    }
  });
});

function onSendNsterile() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "checkNSterile",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);

      $.each(ObjData, function (kay, value) {
        if (value.qty != "0") {
          showDialogFailed("มีอุปกรณ์รอส่ง Create Request");
        } else {
          $.ajax({
            url: "process/pay.php",
            type: "POST",
            data: {
              FUNC_NAME: "onSendNsterile",
            },
            success: function (result) {
              var ObjData = JSON.parse(result);
              if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function (kay, value) { });
              }

              if (RefDepID == "36DEN") {
                setTimeout(() => {
                  feeddata();
                }, 500);
              } else {
                setTimeout(() => {
                  $("#btn_send").click();
                }, 200);
              }
            },
          });
        }
      });
    },
  });
}
$("#btn_send").on("click", function (e) {
  e.preventDefault();
  var link = this.href;
  $.get(link, function (res) {
    $(".nav-item").removeClass("active");
    $(".nav-item").css("background-color", "");

    $("#conMain").html(res);
    history.pushState({}, "Results for `Cats`", "index.php?s=send-n-sterile");
    document.title = "send-n-sterile";

    loadScript("script-function/send-n-sterile.js");
  });
});

function feeddataClaim() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddataClaim",
    },
    success: function (result) {
      // $("#table_item_claim").DataTable().destroy();
      $("#table_item_claim tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr> ` +
            `<td class="text-center">${kay + 1}</td>` +
            `<td class="text-center">${value.UsageCode}</td>` +
            `<td class="text-left">${value.itemname}</td>` +
            `<td class="text-center"><input type='text' class='form-control f18' placeholder='หมายเหตุ'></td>` +
            ` </tr>`;
        });

        $("#table_item_claim tbody").html(_tr);
      }
    },
  });
}

// =================================================================================================================



$("#input_pay_sell").keypress(function (e) {
  if (e.which == 13) {
    if ($(this).val().trim() != "") {
      $("#input_pay_sell").val(convertString($(this).val()));
      oncheck_sell($(this).val());
      $("#input_pay_sell").val("");
    }
  }
});

$("#input_returnpay_sell").keypress(function (e) {
  if (e.which == 13) {
    if ($(this).val().trim() != "") {
      $("#input_returnpay_sell").val(convertString($(this).val()));
      oncheck_Returnsell($(this).val());
      $("#input_returnpay_sell").val("");
    }
  }
});


$("#select_deproom_sell").change(function (e) {
  show_detail_department();
});

var preventTrigger = false;

$("#select_department_sell_right").change(function (e) {

  if (preventTrigger) return; // ออกจาก function ทันที

  $("#input_pay_sell").data("docno", '');
  $("#table_deproom_DocNo_pay_sell tbody").html("");

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


  $("#input_time_service_sell").val(currentTime);
  $("#input_date_service_sell").val(output);

});


function oncheck_Returnsell(input_returnpay_sell) {

  if ($("#select_department_sell_right").val() == "") {
    showDialogFailed("กรุณาเลือกหน่วยงาน");
    $("#input_pay_sell").val("");
    return;
  }
  if ($("#input_date_service_sell").val() == "") {
    showDialogFailed("กรุณาเลือกวันที่");
    $("#input_pay_sell").val("");
    return;
  }

  $.ajax({
    url: "process/pay_sell.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_Returnsell",
      input_returnpay_sell: input_returnpay_sell,
      DocNo_pay_sell: $("#input_pay_sell").data("docno"),
      input_date_service_sell: $("#input_date_service_sell").val(),
      input_time_service_sell: $("#input_time_service_sell").val(),
      select_department_sell_right: $("#select_department_sell_right").val(),
    },
    success: function (result) {
      if (result == 2) {
        showDialogFailed("รหัสนี้อยู่คลังสต๊อกห้องผ่าตัด");
      }
      if (result == 0) {
        showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
      } else {
        var ObjData = JSON.parse(result);
        show_detail_item_sell();
        show_detail_department();
      }
      $("#input_returnpay_sell").val("");
    },
  });
}




function oncheck_sell(input_pay_sell) {
  if ($("#select_department_sell_right").val() == "") {
    showDialogFailed("กรุณาเลือกหน่วยงาน");
    $("#input_pay_sell").val("");
    return;
  }
  if ($("#input_date_service_sell").val() == "") {
    showDialogFailed("กรุณาเลือกวันที่");
    $("#input_pay_sell").val("");
    return;
  }
  setTimeout(() => {
    $.ajax({
      url: "process/pay_sell.php",
      type: "POST",
      data: {
        FUNC_NAME: "oncheck_sell",
        input_pay_sell: input_pay_sell,
        DocNo_pay_sell: $("#input_pay_sell").data("docno"),
        input_date_service_sell: $("#input_date_service_sell").val(),
        input_time_service_sell: $("#input_time_service_sell").val(),
        select_department_sell_right: $("#select_department_sell_right").val(),
      },
      success: function (result) {
        if (result == 0) {
          showDialogFailed("QR Code ไม่ถูกต้องไม่พบรหัสนี้ในระบบ");
        } else if (result == 1) {
          showDialogFailed("จ่ายครบแล้ว");
        } else if (result == 2) {
          show_detail_item_ByDocNo();
        } else if (result == 3) {
          showDialogFailed("สแกนอุปกรณ์ซ้ำ");
        } else if (result == 9) {
          showDialogFailed("รหัสใช้งานหมดอายุไม่สามารถสแกนใช้งานได้");
        } else {

          let docNo = JSON.parse(result);
          $("#input_pay_sell").data("docno", docNo);
          show_detail_item_sell();
          show_detail_department();

          // alert(docNo);
          // var ObjData = JSON.parse(result);
          // if (!$.isEmptyObject(ObjData)) {
          //   $.each(ObjData, function (key, value) {
          //     $(".loop_item_pay").each(function (key_, value_) {
          //       if ($(this).data("itemcode") == value.ItemCode) {
          //         if ($(this).data("manual") == 1) {
          //           var _Qty = $(this).val();
          //           $(this).val(parseInt(_Qty) + 1);
          //         } else {
          //           var _Qty = $(this).val();
          //           $(this).val(parseInt(_Qty) + 1);

          //           _Qty = parseInt(_Qty) + 1;

          //           var _QtyRequest = $("#qty_request_" + value.ItemCode).val();
          //           if (parseInt(_Qty) > parseInt(_QtyRequest)) {
          //             var balance = parseInt(_Qty) - parseInt(_QtyRequest);
          //             balance = "+" + balance;
          //           } else {
          //             var balance = parseInt(_QtyRequest) - parseInt(_Qty);
          //           }

          //           if (
          //             $(this).data("request") == "0" &&
          //             $(this).data("manual") == "0"
          //           ) {
          //             $("#balance_request_" + value.ItemCode).val(balance);
          //           }

          //           console.log(balance);
          //         }
          //       }
          //     });
          //   });
          // }
        }
        $("#input_pay_sell").val("");
      },
    });
  }, 200);

  // CHECK status
}

function show_detail_item_sell() {
  $.ajax({
    url: "process/pay_sell.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_sell",
      DocNo: $("#input_pay_sell").data("docno"),
    },
    success: function (result) {
      var _tr = "";
      $("#table_deproom_DocNo_pay_sell tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          var hidden = "";
          if (value.permission != "5") {
            if (value.warehouseID == value.permission) {
              hidden = "";
            } else {
              hidden = "hidden";
            }
          } else {
            hidden = "";
          }

          _tr += `<tr ${hidden} >
                      <td class='text-center'>${kay + 1}</td>
                      <td>${value.itemname}</td>
                      <td class='text-center'  style='background-color:#E0F7FA;'><input type='text'     style='  border: none !important;box-shadow: none !important; background: transparent !important;outline: none !important;' class='form-control text-center f18 ' value="${value.item_count}"   data-itemcode='${value.itemcode}' disabled></td>
                   </tr>`;
        });
      }

      $("#table_deproom_DocNo_pay_sell tbody").html(_tr);



    },
  });
}

function show_detail_department() {
  $.ajax({
    url: "process/pay_sell.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_department",
      select_deproom_sell: $("#select_deproom_sell").val(),
      select_date_sell: $("#select_date_sell").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_deproom_sell tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["department"], function (kay, value) {


          _tr += `<tr id='trbg_${value.departmentID}'>
                      <td class='text-center'>                      
                        <i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;' id='open_${value.departmentID}' value='0' onclick='open_depertment_sell("${value.departmentID}")'></i>
                      </td>
                      <td class='text-center'>${value.DepName}</td>
                   </tr>`;

          $.each(ObjData[value.departmentID], function (kay2, value2) {
            _tr += `<tr style='cursor:pointer;' class='tr_${value.departmentID} all111'  onclick="setActive_department('${value2.DocNo}','${value.departmentID}','${value2.ServiceDate}','${value2.ServiceTime}')" id='trbg_department_${value2.DocNo}'>
                      <td class='text-center' colspan="2">${value2.DocNo}</td>
                   </tr>`;
          });

        });
      }

      $("#table_deproom_sell tbody").html(_tr);
      $(".all111").hide();


    },
  });
}

function setActive_department(DocNo, departmentID, ServiceDate, ServiceTime) {
  $(".all111").css("background-color", "");
  $("#trbg_department_" + DocNo).css("background-color", "rgb(249, 245, 255)");


  $("#input_pay_sell").data("docno", DocNo);
  $("#input_pay_sell").data("docno", DocNo);
  $("#input_pay_sell").data("docno", DocNo);
  preventTrigger = true;
  $("#select_department_sell_right").val(departmentID).trigger("change");
  preventTrigger = false;
  $("#input_date_service_sell").val(ServiceDate);
  $("#input_time_service_sell").val(ServiceTime);
  show_detail_item_sell();
}

function open_depertment_sell(departmentID) {
  if ($("#open_" + departmentID).val() == 1) {
    $("#open_" + departmentID).val(0);
    $("#open_" + departmentID).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $(".tr_" + departmentID).hide(300);

    $("#trbg_" + departmentID).css("background-color", "");

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + departmentID).val(1);
    $("#open_" + departmentID).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + departmentID).show(500);

    $("#trbg_" + departmentID).css("background-color", "#EFF8FF");

    console.log($("#trbg_" + departmentID).length); // ควรได้ค่าเป็น 1

    // $(".tr_"+id).attr('hidden',false);
  }
}

// =================================================================================================================

function set_proceduce2_block(select_deproom_request) {
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
      $("#select_procedure_editHN_block").html(option);
    },
  });
}

function set_proceduce2(select_deproom_request) {
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
      $("#select_procedure_editHN").html(option);
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

function set_deproom2_block() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom",
      doctor_Array: doctor_edit_hn_block_Array,
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
      $("#select_deproom_editHN_block").html(option);
    },
  });
}

function set_deproom2() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "set_deproom",
      doctor_Array: doctor_edit_hn_Array,
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
      $("#select_deproom_editHN").html(option);
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
      Permission_name = ObjData.Permission_name;
      Userid = ObjData.Userid;

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
