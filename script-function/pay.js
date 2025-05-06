var departmentroomname = "";
var UserName = "";

var procedure_id_Array = [];
var doctor_Array = [];

var procedure_edit_hn_Array = [];
var doctor_edit_hn_Array = [];
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
    onSelect: function (date) {},
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
  $("#input_date_service").val(output);
  $("#input_date_service").datepicker({
    onSelect: function (date) {
      updateService();
    },
  });

  $("#input_date_service_manual").val(output);
  $("#input_date_service_manual").datepicker({
    onSelect: function (date) {},
  });

  $("#input_time_service").change(function (e) {
    updateService();
  });

  $("#history_pay").hide();
  $("#claim").hide();
  $("#pay_manual").hide();
  $("#return").hide();

  $("#radio_pay").css("color", "#bbbbb");
  $("#radio_pay").css("background", "#EAE1F4");

  $("#radio_pay").click(function () {
    $("#radio_pay").css("color", "#bbbbb");
    $("#radio_pay").css("background", "#EAE1F4");

    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");
    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");
    $("#radio_pay_manual").css("color", "black");
    $("#radio_pay_manual").css("background", "");
    $("#radio_return_pay").css("background", "");
    $("#radio_return_pay").css("color", "black");

    $("#pay").show();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();

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
    $("#radio_pay_manual").css("color", "#bbbbb");
    $("#radio_pay_manual").css("background", "#EAE1F4");

    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");
    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");
    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_return_pay").css("background", "");
    $("#radio_return_pay").css("color", "black");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").hide();
    $("#pay_manual").show();
    $("#return").hide();

    $("#input_Hn_pay_manual").focus();

    $("#select_deproom_manual").select2();
    $("#select_doctor_manual").select2();
    $("#select_procedure_manual").select2();

    $("#select_deproom_manual").change(function () {
      set_proceduce($("#select_deproom_manual").val());
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

            $("#select_doctor_manual").val("").trigger("change");

            set_deproom();
          }
        }
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

            $("#select_procedure_manual").val("").trigger("change");
          }
        }
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
    $("#radio_return_pay").css("color", "#bbbbb");
    $("#radio_return_pay").css("background", "#EAE1F4");
    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");
    $("#radio_pay_manual").css("color", "black");
    $("#radio_pay_manual").css("background", "");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#return").show();
    $("#pay_manual").hide();

    feeddata_waitReturn();
    // feeddataClaim();
  });

  $("#radio_history_pay").click(function () {
    $("#radio_history_pay").css("color", "#bbbbb");
    $("#radio_history_pay").css("background", "#EAE1F4");

    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");
    $("#radio_pay_manual").css("color", "black");
    $("#radio_pay_manual").css("background", "");
    $("#radio_return_pay").css("background", "");
    $("#radio_return_pay").css("color", "black");

    $("#pay").hide();
    $("#history_pay").show();
    $("#claim").hide();
    $("#pay_manual").hide();
    $("#return").hide();

    $(".clear_doctor").attr("hidden", true);
    doctor_Array = [];
    $(".clear_procedure").attr("hidden", true);
    procedure_id_Array = [];

    show_detail_history();

    $("#select_deproom_history").select2();
    $("#select_doctor_history").select2();
    $("#select_procedure_history").select2();

    setTimeout(() => {
      $("#select_doctor_history").on("select2:select", function (e) {
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

            $("#row_doctor_history").append(_row);

            $("#select_doctor_history").val("").trigger("change");
          }

          show_detail_history();
        }
      });

      $("#select_procedure_history").on("select2:select", function (e) {
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

            $("#row_procedure_history").append(_row);

            $("#select_procedure_history").val("").trigger("change");
          }

          show_detail_history();
        }
      });
    }, 500);
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

  $("#select_deproom_pay").select2();
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

function Deleteprocedure_editHN(selectedValue) {
  var index = procedure_edit_hn_Array.indexOf(String(selectedValue));
  console.log(index);

  if (index !== -1) {
    procedure_edit_hn_Array.splice(index, 1);
  }

  console.log(procedure_edit_hn_Array);
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
                      <td class="f24 text-left"><i class="fa-solid fa-chevron-up" style='font-size:20px;cursor:pointer;' id='open_${
                        value.id
                      }' value='0' onclick='open_deproom_sub(${
            value.id
          })'></i> ${kay + 1}</td>
                      <td class="f24 text-left">${value.departmentroomname}</td>
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

            if (value2.Procedure_TH == "button") {
              value2.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value2.procedure}")'>หัตถการ</a>`;
            }
            if (value2.Doctor_Name == "button") {
              value2.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value2.doctor}")'>แพทย์</a>`;
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

            _tr += `<tr class='tr_${value.id} all111' ${sty}>
                          <td class='text-center'>
                            <div class="form-check">
                             <input 
                                style="width: 20px;height: 20px;"
                                class="form-check-input position-static clear_checkbox"
                                type="checkbox"
                                id="checkbox_${value2.DocNo}"
                                data-id="${value.id}"
                                data-docno="${value2.DocNo}"
                                data-hn="${value2.hn_record_id}"
                                data-date="${value2.serviceDate}"
                                data-time="${value2.serviceTime}"
                                data-box="${value2.number_box}"
                                data-doctor="${value2.doctorHN}"
                                data-procedure="${value2.procedureHN}" >
                            </div>
                          </td>
                          <td>
                            <div class="row">
                              <div class="col-md-3 text-left"> ${tttt}</div>
                              <div class="col-md-5 text-center">${value2.Procedure_TH}</div>
                              <div class="col-md-4 text-center">${value2.Doctor_Name}</div>

                            </div>
                          
                           </td>
                          <td hidden class='text-center'> <label id='text_balance_${value2.DocNo}' class='f18' style='font-weight:bold;${sty};text-decoration-line: underline;'>${txt}</label> </td>

                        </tr>`;
          });
        });
      }

      $("#table_deproom_pay tbody").html(_tr);

      $(".all111").hide();

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
          el.data("procedure")
        );
      });
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
  procedure
) {
  $("#btn_edit_hn").attr("disabled", false);

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
                      <td>

                                  <div class="d-flex align-items-center">
                                    <span class="mr-2">${value.itemname}</span>
                                    <button class="btn btn-outline-${typename} btn-sm" disabled>${value.TyeName}</button>
                                  </div>

                      
                      </td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18' value="${value.cnt}" disabled id="qty_request_${value.itemcode}"></td>
                      <td class='text-center' style='background-color:#EEFBF9;'><input type='text' class='form-control text-center f18 loop_item_pay' value="${value.cnt_pay}"  data-itemcode='${value.itemcode}' disabled></td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18 loop_item_balance' disabled value="${balance}" id="balance_request_${value.itemcode}"></td>
                   </tr>`;
        });
      }

      $("#table_deproom_DocNo_pay tbody").html(_tr);

      var check_q = 0;
      $(".loop_item_pay").each(function (key_, value_) {
        var qP = parseInt($(this).val());
        if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
          check_q++;
        }
      });

      if (check_q == 0) {
        $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ครบ");
        $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
          "color",
          "#00bf63"
        );
      } else {
        $("#text_balance_" + $("#input_Hn_pay").data("docno")).text("ค้าง");
        $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
          "color",
          "#ed1c24"
        );
      }
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
    success: function (result) {},
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
    return;
  }

  if ($("#input_pay_manual").val() == "") {
    showDialogFailed("กรุณาเลือกรายการ");
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
        } else {
          var ObjData = JSON.parse(result);
          if (!$.isEmptyObject(ObjData)) {
            $.each(ObjData, function (key, value) {
              $(".loop_item_pay").each(function (key_, value_) {
                if ($(this).data("itemcode") == value.ItemCode) {
                  var _QtyRequest = $("#qty_request_" + value.ItemCode).val();
                  var _Qty = $(this).val();

                  if (_QtyRequest == _Qty) {
                    // $("#qty_request_" + value.ItemCode).val(parseInt(_Qty) + 1);
                  }
                  $(this).val(parseInt(_Qty) + 1);

                  var _QtyRequest_2 = $("#qty_request_" + value.ItemCode).val();
                  var _Qty_2 = $(this).val();

                  var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                  if (balance2 < 0) {
                    // balance2 = 0;
                    balance2 = parseInt(_Qty_2) - parseInt(_QtyRequest_2);
                    balance2 = "+" + balance2;
                  }

                  $("#balance_request_" + value.ItemCode).val(balance2);
                }
              });

              var check_q = 0;
              $(".loop_item_pay").each(function (key_, value_) {
                var qP = parseInt($(this).val());
                // alert(qP);
                if (qP < $("#qty_request_" + $(this).data("itemcode")).val()) {
                  check_q++;
                }
              });

              if (check_q == 0) {
                $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
                  "ครบ"
                );
                $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
                  "color",
                  "#00bf63"
                );
              } else {
                $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
                  "ค้าง"
                );
                $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
                  "color",
                  "#ed1c24"
                );
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
                var _Qty = $(this).val();
                // alert(_Qty);
                $(this).val(parseInt(_Qty) - 1);

                var _QtyRequest_2 = $("#qty_request_" + value.ItemCode).val();
                var _Qty_2 = $(this).val();

                // var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                // if (balance2 < 0) {
                //   balance2 = 0;
                // }
                var balance2 = parseInt(_QtyRequest_2) - parseInt(_Qty_2);
                if (balance2 < 0) {
                  // balance2 = 0;
                  balance2 = parseInt(_Qty_2) - parseInt(_QtyRequest_2);
                  balance2 = "+" + balance2;
                }

                $("#balance_request_" + value.ItemCode).val(balance2);
              }
            });

            var check_q = 0;
            $(".loop_item_balance").each(function (key_, value_) {
              var qB = parseInt($(this).val());
              if (qB > 0) {
                check_q++;
              }
            });

            if (check_q == 0) {
              $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
                "ครบ"
              );
              $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
                "color",
                "#00bf63"
              );
            } else {
              $("#text_balance_" + $("#input_Hn_pay").data("docno")).text(
                "ค้าง"
              );
              $("#text_balance_" + $("#input_Hn_pay").data("docno")).css(
                "color",
                "#ed1c24"
              );
            }
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
    $("#open_" + id).val(1);
    $("#open_" + id).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $(".tr_" + id).show(500);

    $("#trbg_" + id).css("background-color", "#EFF8FF");

    // $(".tr_"+id).attr('hidden',false);
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
                                    <button class="btn btn-outline-${typename} btn-sm" disabled>${
            value.TyeName
          }</button>
                                  </div>

                      
                      </td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18' value="${
                        value.cnt
                      }" disabled id="qty_request_${value.itemcode}"></td>
                      <td class='text-center' style='background-color:#EEFBF9;'><input type='text' class='form-control text-center f18 loop_item_pay' value="${
                        value.cnt_pay
                      }"  data-itemcode='${value.itemcode}' disabled></td>
                      <td hidden class='text-center'><input type='text' class='form-control text-center f18 loop_item_balance' disabled value="${balance}" id="balance_request_${
            value.itemcode
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
// $("#select_doctor_history").change(function (e) {
//   show_detail_history();
// });
// $("#select_procedure_history").change(function (e) {
//   show_detail_history();
// });
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
      select_doctor_history: doctor_Array,
      select_procedure_history: procedure_id_Array,
    },
    success: function (result) {
      var _tr = "";
      $("#table_history").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.Procedure_TH == "button") {
            value.Procedure_TH = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Procedure("${value.procedure}")'>หัตถการ</a>`;
          }
          if (value.Doctor_Name == "button") {
            value.Doctor_Name = `<a class="text-primary" style="cursor:pointer;" onclick='showDetail_Doctor("${value.doctor}")'>แพทย์</a>`;
          }

          if (value.cnt_pay > 0) {
            var hidden = "";
          } else {
            var hidden = "hidden";
          }

          if (value.hn_record_id == "") {
            value.hn_record_id = value.number_box;
          }
          if (value.FirstName == null) {
            value.FirstName = '';
          }
          
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.CreateDate}</td>
                      <td class='text-center'>${value.serviceDate}</td>
                      <td class='text-center'>${value.FirstName}</td>
                      <td class='text-center'>${value.hn_record_id}</td>
                      <td class='text-center'>${value.Doctor_Name}</td>
                      <td class='text-center'>${value.Procedure_TH}</td>
                      <td class='text-left'>${value.departmentroomname}</td>
                      <td class='text-center'><button class='btn btn-outline-danger f18' onclick='cancel_item_byDocNo("${
                        value.DocNo
                      }")' >ยกเลิก</button></td>
                      <td class='text-center'><button ${hidden} class='btn f18' style='background-color:#643695;color:#fff;' onclick='show_Report("${
            value.DocNo
          }")'>รายงาน</button></td>
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
            width: "5%",
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
            width: "10%",
            targets: 5,
          },
          {
            width: "15%",
            targets: 6,
          },
          {
            width: "10%",
            targets: 7,
          },
          {
            width: "5%",
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
  window.open("report/phpexcel/Report_Issue_Order_HN.php" + option, "_blank");
});

function show_Report(DocNo) {
  option = "?DocNo=" + DocNo;
  window.open("report/Report_Issue.php" + option, "_blank");
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

function cancel_item_byDocNo(DocNo) {
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
        },
        success: function (result) {
          var ObjData = JSON.parse(result);
          console.log(ObjData);
          $("body").loadingModal("destroy");
          showDialogSuccess("ยกเลิกสำเร็จ");
        },
      });

      setTimeout(() => {
        show_detail_history();
      }, 300);
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
      $("#select_deproom_manual").html(option);
      $("#select_deproom_editHN").html(option);
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
      $("#select_doctor_history").html(option);
      $("#select_doctor_manual").html(option);
      $("#select_doctor_editHN").html(option);
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
      $("#select_procedure_history").html(option);
      $("#select_procedure_manual").html(option);
      $("#select_procedure_editHN").html(option);
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
      $.ajax({
        url: "process/pay.php",
        type: "POST",
        data: {
          FUNC_NAME: "onReturnData",
        },
        success: function (result) {
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
                $.each(ObjData, function (kay, value) {});
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
