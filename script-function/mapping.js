var procedure_id_Array = [];
var doctor_Array = [];
var deproom_Array = [];

$(function () {
  select_deproom();
  select_procedure();
  select_doctor();

  $(".select2").select2();


  show_detail_doctor();
  show_detail_deproom();
});

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
//////////////////////////////////////////////////////////////// select
function showDialogSuccess(text) {
  Swal.fire({
    title: settext("alert_success"),
    text: text,
    icon: "success",
    timer: 1000,
  });
}
