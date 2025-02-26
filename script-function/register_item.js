var departmentroomname = "";
var UserName = "";
$(function () {
  session();

  $("#register_itemSterile").hide();
  $("#register_implant").hide();
  $("#history_item").hide();
  $("#use_limit").hide();

  $("#radio_register_itemSUDs").css("color", "#bbbbb");
  $("#radio_register_itemSUDs").css("background", "#EAECF0");

  $("#radio_register_itemSUDs").click(function () {
    $("#radio_register_itemSUDs").css("color", "#bbbbb");
    $("#radio_register_itemSUDs").css("background", "#EAECF0");

    $("#radio_register_itemSterile").css("color", "black");
    $("#radio_register_itemSterile").css("background", "");
    $("#radio_register_implant").css("color", "black");
    $("#radio_register_implant").css("background", "");
    $("#radio_history_item").css("color", "black");
    $("#radio_history_item").css("background", "");
    $("#radio_use_limit").css("color", "black");
    $("#radio_use_limit").css("background", "");

    $("#register_itemSUDs").show();
    $("#register_itemSterile").hide();
    $("#register_implant").hide();
    $("#history_item").hide();
    $("#use_limit").hide();
  });

  $("#radio_register_itemSterile").click(function () {
    $("#radio_register_itemSterile").css("color", "#bbbbb");
    $("#radio_register_itemSterile").css("background", "#EAECF0");

    $("#radio_register_itemSUDs").css("color", "black");
    $("#radio_register_itemSUDs").css("background", "");
    $("#radio_register_implant").css("color", "black");
    $("#radio_register_implant").css("background", "");
    $("#radio_history_item").css("color", "black");
    $("#radio_history_item").css("background", "");
    $("#radio_use_limit").css("color", "black");
    $("#radio_use_limit").css("background", "");

    $("#register_itemSUDs").hide();
    $("#register_itemSterile").show();
    $("#register_implant").hide();
    $("#history_item").hide();
    $("#use_limit").hide();

    $("#select_Procedure_Sterile").select2();
    $("#select_SterileProcecss_Sterile").select2();
  });

  $("#radio_register_implant").click(function () {
    $("#radio_register_implant").css("color", "#bbbbb");
    $("#radio_register_implant").css("background", "#EAECF0");

    $("#radio_register_itemSUDs").css("color", "black");
    $("#radio_register_itemSUDs").css("background", "");
    $("#radio_register_itemSterile").css("color", "black");
    $("#radio_register_itemSterile").css("background", "");
    $("#radio_history_item").css("color", "black");
    $("#radio_history_item").css("background", "");
    $("#radio_use_limit").css("color", "black");
    $("#radio_use_limit").css("background", "");

    $("#register_itemSUDs").hide();
    $("#register_itemSterile").hide();
    $("#register_implant").show();
    $("#history_item").hide();
    $("#use_limit").hide();

    $("#select_Procedure_implant").select2();
  });

  $("#radio_history_item").click(function () {
    $("#radio_history_item").css("color", "#bbbbb");
    $("#radio_history_item").css("background", "#EAECF0");

    $("#radio_register_itemSUDs").css("color", "black");
    $("#radio_register_itemSUDs").css("background", "");
    $("#radio_register_itemSterile").css("color", "black");
    $("#radio_register_itemSterile").css("background", "");
    $("#radio_register_implant").css("color", "black");
    $("#radio_register_implant").css("background", "");
    $("#radio_use_limit").css("color", "black");
    $("#radio_use_limit").css("background", "");

    $("#register_itemSUDs").hide();
    $("#register_itemSterile").hide();
    $("#register_implant").hide();
    $("#history_item").show();
    $("#use_limit").hide();
  });

  $("#radio_use_limit").click(function () {
    $("#radio_use_limit").css("color", "#bbbbb");
    $("#radio_use_limit").css("background", "#EAECF0");

    $("#radio_register_itemSUDs").css("color", "black");
    $("#radio_register_itemSUDs").css("background", "");
    $("#radio_register_itemSterile").css("color", "black");
    $("#radio_register_itemSterile").css("background", "");
    $("#radio_register_implant").css("color", "black");
    $("#radio_register_implant").css("background", "");
    $("#radio_history_item").css("color", "black");
    $("#radio_history_item").css("background", "");

    $("#register_itemSUDs").hide();
    $("#register_itemSterile").hide();
    $("#register_implant").hide();
    $("#history_item").hide();
    $("#use_limit").show();
  });

  select_procedure();
  select_sterileprocess();
  select_typeDocument();

  $("#select_Procedure_SUDs").select2();
  $("#select_SterileProcecss_SUDs").select2();

  // $("#select_Procedure_SUDs").select2();
  // $("#select_SterileProcecss_SUDs").select2();
  $("#select_typeDocument_SUDs").select2();
});

// itemSUDs

$("#checkbox_InActive_SUDs").click(function () {
  if ($("#checkbox_InActive_SUDs").is(":checked")) {
    $("#text_InActive_SUDs").css("color", "#2196F3");
    $("#checkbox_InActive_SUDs").val(0);
  } else {
    $("#text_InActive_SUDs").css("color", "#ccc");
    $("#checkbox_InActive_SUDs").val(1);
  }
});

$("#radio_detal_item_sud_IN").click(function () {
  $("#table_UsageCode_SUDs").DataTable().destroy();
  $("#table_UsageCode_SUDs tbody").html("");
});
$("#radio_detal_item_sud_A").click(function () {
  showUsageCodeSUDs()
});


$("#image1_SUDs").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});
$("#image2_SUDs").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});

var dr1SUDs = $("#image1_SUDs").dropify();
var dr2SUDs = $("#image2_SUDs").dropify();

dr1SUDs.on("dropify.afterClear ", function (event, element) {
  $("#image1_SUDs").data("value", "default");
});
dr2SUDs.on("dropify.afterClear ", function (event, element) {
  $("#image2_SUDs").data("value", "default");
});

$("#input_ApproveDate_SUDs").val(set_date());
$("#input_ApproveDate_SUDs").datepicker({
  onSelect: function (date) {},
});
$("#input_ExpDate_SUDs").val(set_date());
$("#input_ExpDate_SUDs").datepicker({
  onSelect: function (date) {},
});

$("#btn_SaveItem_SUDs").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การสร้างอุปกรณ์ SUDs",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateItemSUDs();
    }
  });
});

$("#btn_ClearItem_SUDs").click(function () {
  $("#input_ItemCode1_SUDs").val("");
  $("#input_ItemCode2_SUDs").val("");
  $("#input_ItemName_SUDs").val("");
  $("#input_LimitUse_SUDs").val("");
  $("#input_CostPrice_SUDs").val("");
  $("#select_Procedure_SUDs").val("");
  // $("#select2-select_Procedure_SUDs-container").text("กรุณาเลือกหัตถการ");
  $("#select_SterileProcecss_SUDs").val("");
  // $("#select2-select_SterileProcecss_SUDs-container").text(
  //   "กรุณาเลือกประเภทการ Sterile"
  // );
  $("#select_Style_SUDs").val("");
  $("#select_Howto_SUDs").val("");
  $(".dropify-clear").click();

  $("#table_DocNo_SUDs tbody").html("");
  $("#table_UsageCode_SUDs tbody").html("");

  $("#btn_SaveDocNo_SUDs").attr("disabled", true);
});

$("#btn_search_popup").click(function () {
  $("#modal_item_SUDs").modal("toggle");

  setTimeout(() => {
    showItemSUDs();
  }, 500);
});

$("#btn_SaveDocNo_SUDs").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การบันทึก เอกสารประกอบอุปกรณ์ SUDs",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateDocNoSUDs();
    }
  });
});

$("#btn_AddUsage_SUDs").click(function () {
  $("#modal_Additem_SUDs").modal("toggle");

  setTimeout(() => {
    showFromAddItemSUDs();
  }, 500);
});

$("#btn_Modal_SaveUsage_SUDs").click(function () {
  ArraySerie = [];
  Arraylot = [];
  Arrayexp = [];
  Arrayregister = [];
  ArrayQty = [];

  for (let index = 0; index < $("#number_row_SUDs").val(); index++) {
    if ($("#modal_input_qty_" + (index + 1)).val() != "") {

      if($("#modal_input_serie_" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก หมายเลขซีเรียล');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }
      if($("#modal_input_lot_" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก เลขล็อตการผลิต');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }
      ArraySerie.push($("#modal_input_serie_" + (index + 1)).val());
      Arraylot.push($("#modal_input_lot_" + (index + 1)).val());
      Arrayexp.push($("#modal_input_exp_" + (index + 1)).val());
      Arrayregister.push($("#modal_input_register_" + (index + 1)).val());
      ArrayQty.push($("#modal_input_qty_" + (index + 1)).val());
    }else{
        showDialogFailed('กรุณากรอก จำนวน');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
    }
  }

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "SaveUsage_SUDs",
      input_ItemCode1_SUDs: $("#input_ItemCode1_SUDs").val(),
      ArraySerie: ArraySerie,
      Arraylot: Arraylot,
      Arrayexp: Arrayexp,
      Arrayregister: Arrayregister,
      ArrayQty: ArrayQty,
    },
    success: function (result) {
      $("#modal_Additem_SUDs").modal("toggle");
      showUsageCodeSUDs();
    },
  });
});

$("#btn_Modal_AddUsage_SUDs").click(function () {
  var number = $("#number_row_SUDs").val();
  $("#number_row_SUDs").val(parseInt(number) + 1);
  var number_real = $("#number_row_SUDs").val();

  var txt = `   <div class="row">
                  <div class="col-md-2 text-center">
                      <label for="" style="color:black;">ลำดับ</label>
                      <br>
                      <span style="color:black;">${number_real}</span>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">หมายเลขซีเรียล</label>
                          <input type="text" class="form-control f18" id="modal_input_serie_${number_real}" placeholder="หมายเลขซีเรียล">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">เลขล็อตการผลิต</label>
                          <input type="text" class="form-control f18" id="modal_input_lot_${number_real}" placeholder="เลขล็อตการผลิต">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                          <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันลงทะเบียน</label>
                          <input type="text" disabled class="form-control f18 datepicker-here" id="modal_input_register_${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">จำนวน</label>
                          <input type="text" class="form-control f18" id="modal_input_qty_${number_real}" placeholder="จำนวน">
                      </div>
                  </div>
                </div>`;

  $("#row_AdditemSUDs").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
});

$("#btn_Modal_SaveEditUsage_SUDs").click(function () {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "EditUsage_SUDs",
      modal_input_serie: $("#modal_input_serie").val(),
      modal_input_lot: $("#modal_input_lot").val(),
      modal_input_exp: $("#modal_input_exp").val(),
      modal_input_register: $("#modal_input_register").val(),
      modal_input_qty: $("#modal_input_qty").val(),
      UsageCode: $("#modal_input_serie").data("UsageCode"),
    },
    success: function (result) {
      $("#modal_Edititem_SUDs").modal("toggle");
      showUsageCodeSUDs();
    },
  });
});

$("#input_modal_search_Suds").keyup(function () {
  showItemSUDs();
});

function showUsageCodeSUDs() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showUsageCodeSUDs",
      input_ItemCode1_SUDs: $("#input_ItemCode1_SUDs").val(),
    },
    success: function (result) {
      var _tr = "";
      // $("#table_UsageCode_SUDs tbody").html("");
      $("#table_UsageCode_SUDs").DataTable().destroy();

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serielNo}</td>
                      <td class='text-center'>${value.UsageCode}</td>
                      <td class='text-center'>${value.lotNo}</td>
                      <td class='text-center'>${value.expDate}</td>
                      <td class='text-center'>${value.CreateDate}</td>
                      <td class='text-center'>Active</td>
                      <td class='text-center'>-</td>
                      <td class='text-center'> <span style="color:blue;cursor:pointer;"  onclick="showDetail_Usage_SUDs('${
                        value.serielNo
                      }','${value.UsageCode}','${value.lotNo}','${
            value.expDate
          }','${value.CreateDate}')">แก้ไข</span></td>
                   </tr>`;
        });
      }

      $("#table_UsageCode_SUDs tbody").html(_tr);
      $("#table_UsageCode_SUDs").DataTable({
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
          {
            width: "10%",
            targets: 7,
          },
          {
            width: "10%",
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
    },
  });
}

function showDetail_Usage_SUDs(
  serielNo,
  UsageCode,
  lotNo,
  expDate,
  CreateDate
) {
  $("#modal_Edititem_SUDs").modal("toggle");
  $("#modal_input_serie").val(serielNo);
  $("#modal_input_lot").val(lotNo);
  $("#modal_input_exp").val(expDate);
  $("#modal_input_register").val(CreateDate);
  $("#modal_input_qty").val(1);
  $("#modal_input_serie").data("UsageCode", UsageCode);
}

function showFromAddItemSUDs() {
  $("#row_AdditemSUDs").html("");

  var txt = `   <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;">ลำดับ</label>
                        <br>
                        <span style="color:black;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie_1" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot_1" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันลงทะเบียน</label>
                            <input disabled type="text" class="form-control f18 datepicker-here" id="modal_input_register_1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty_1" placeholder="จำนวน">
                        </div>
                    </div>
                </div>`;

  $("#row_AdditemSUDs").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
}

function showItemSUDs() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showItemSUDs",
      input_modal_search_Suds: $("#input_modal_search_Suds").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#modal_table_item_SUDs").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsCancel == "0") {
            value.IsCancel = "Active";
          } else {
            value.IsCancel = "InActive";
          }

          var typename = "";
          if (value.TyeName == "SUDs") {
            typename = "red-text";
          }
          if (value.TyeName == "OR Implant") {
            typename = "primary-text";
          }
          if (value.TyeName == "Sterile") {
            typename = "success-text";
          }

          var red = "";
          if (value.item_document_ID == "red") {
            red = `<i class="fa-solid fa-triangle-exclamation" style='font-size: 25px;color:red;'></i>`;
          }

          _tr += `<tr>
                      <td>${value.itemcode}</td>
                      <td>${red}</td>
                      <td>${value.itemcode2}</td>
                      <td>
                      
                             <div class="d-flex align-items-center">
                                  <span>${value.Item_name}</span>
                                  <span class="${typename} ms-2">${value.TyeName}</span>
                              </div> 
                      
                      </td>
                      <td>${value.IsCancel}</td>
                      <td><span style='color:blue;cursor:pointer;' onclick="showDetail_SUDs('${value.itemcode}','${value.itemcode2}','${value.Item_name}','${value.LimitUse}','${value.CostPrice}','${value.SterileProcessID}','${value.procedureID}','${value.Picture}','${value.Picture2}','${value.IsCancel}','${value.Description}','${value.ReuseDetect}')">เลือก</span></td>
                   </tr>`;
        });
      }

      $("#modal_table_item_SUDs tbody").html(_tr);
      $("#modal_table_item_SUDs").DataTable({
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
            width: "20%",
            targets: 0,
          },
          {
            width: "5%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 2,
          },
          {
            width: "40%",
            targets: 3,
          },
          {
            width: "20%",
            targets: 4,
          },
          {
            width: "20%",
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
    },
  });
}

function showDetail_SUDs(
  itemcode,
  itemcode2,
  Item_name,
  LimitUse,
  CostPrice,
  SterileProcessID,
  procedureID,
  Picture,
  Picture2,
  IsCancel,
  Description,
  ReuseDetect
) {
  $("#modal_item_SUDs").modal("toggle");
  $("#input_ItemCode1_SUDs").val(itemcode);
  $("#input_ItemCode2_SUDs").val(itemcode2);
  $("#input_ItemName_SUDs").val(Item_name);
  $("#input_LimitUse_SUDs").val(LimitUse);
  $("#input_CostPrice_SUDs").val(CostPrice);
  $("#select_SterileProcecss_SUDs").val(SterileProcessID).trigger("change");
  $("#select_Procedure_SUDs").val(procedureID).trigger("change");
  $("#select_Style_SUDs").val(Description);
  $("#select_Howto_SUDs").val(ReuseDetect);

  if (IsCancel == "InActive") {
    $("#checkbox_InActive_SUDs").prop("checked", false);
    $("#text_InActive_SUDs").css("color", "#ccc");
  } else {
    $("#text_InActive_SUDs").css("color", "#2196F3");
    $("#checkbox_InActive_SUDs").prop("checked", true);
  }

  if (Picture == "null" || Picture == "") {
    var drEvent = $("#image1_SUDs").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image1_SUDs").dropify({
      defaultFile: "assets/img/" + Picture,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image1_SUDs").data("value", Picture);
    }, 1000);
  }

  if (Picture2 == "null" || Picture2 == "") {
    var drEvent = $("#image2_SUDs").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image2_SUDs").dropify({
      defaultFile: "assets/img/" + Picture2,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture2;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image2_SUDs").data("value", Picture2);
    }, 1000);
  }

  $("#btn_SaveDocNo_SUDs").attr("disabled", false);
  $("#btn_AddUsage_SUDs").attr("disabled", false);

  setTimeout(() => {
    showDocNoSUDs();
    showUsageCodeSUDs();
  }, 300);
}

function onconfirm_CreateItemSUDs() {

  if($("#input_ItemCode2_SUDs").val() == ""){
    showDialogFailed('กรุณากรอก รหัสอุปกรณ์');
    return;
  }

  if($("#input_ItemName_SUDs").val() == ""){
    showDialogFailed('กรุณากรอก ชื่ออุปกรณ์');
    return;
  }

  if($("#input_LimitUse_SUDs").val() == ""){
    showDialogFailed('กรุณากรอก จำนวนที่ใช้ซ้ำ');
    return;
  }

  if($("#input_CostPrice_SUDs").val() == ""){
    showDialogFailed('กรุณากรอก มูลค่า');
    return;
  }

  if($("#select_Procedure_SUDs").val() == ""){
    showDialogFailed('กรุณาเลือก หัตถการ');
    return;
  }
  if($("#select_SterileProcecss_SUDs").val() == ""){
    showDialogFailed('กรุณาเลือก ประเภทการ Sterile ');
    return;
  }
  var form_data = new FormData();

  var image1_SUDs = $("#image1_SUDs").prop("files")[0];
  var image2_SUDs = $("#image2_SUDs").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateItemSUDs");
  form_data.append("input_ItemCode1_SUDs", $("#input_ItemCode1_SUDs").val());
  form_data.append("input_ItemCode2_SUDs", $("#input_ItemCode2_SUDs").val());
  form_data.append("input_ItemName_SUDs", $("#input_ItemName_SUDs").val());
  form_data.append("input_LimitUse_SUDs", $("#input_LimitUse_SUDs").val());
  form_data.append("input_CostPrice_SUDs", $("#input_CostPrice_SUDs").val());
  form_data.append("select_Procedure_SUDs", $("#select_Procedure_SUDs").val());
  form_data.append(
    "select_SterileProcecss_SUDs",
    $("#select_SterileProcecss_SUDs").val()
  );
  form_data.append("select_Style_SUDs", $("#select_Style_SUDs").val());
  form_data.append("select_Howto_SUDs", $("#select_Howto_SUDs").val());
  form_data.append("checkbox_InActive_SUDs", $("#checkbox_InActive_SUDs").val());
  form_data.append("image1_SUDs", image1_SUDs);
  form_data.append("image2_SUDs", image2_SUDs);
  form_data.append("Data_image1_SUDs", $("#image1_SUDs").data("value"));
  form_data.append("Data_image2_SUDs", $("#image2_SUDs").data("value"));

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);

      showDialogSuccess("บันทึก อุปกรณ์ SUDs สำเร็จ");
      $("#btn_ClearItem_SUDs").click();
    },
  });
}

function onconfirm_CreateDocNoSUDs() {

  if($("#select_typeDocument_SUDs").val() == ""){
    showDialogFailed('กรุณาเลือก ประเภทเอกสาร');
    return;
  }
  if($("#input_DocNo_SUDs").val() == ""){
    showDialogFailed('กรุณากรอก เลขที่ควบคุมเอกสาร');
    return;
  }
  if($("#input_FileDocNo_SUDs").val() == ""){
    showDialogFailed('กรุณาอัพโหลด ไฟล์');
    return;
  }
  var form_data = new FormData();

  var input_FileDocNo_SUDs = $("#input_FileDocNo_SUDs").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateDocNoSUDs");
  form_data.append("input_ItemCode1_SUDs", $("#input_ItemCode1_SUDs").val());
  form_data.append(
    "select_typeDocument_SUDs",
    $("#select_typeDocument_SUDs").val()
  );
  form_data.append("input_DocNo_SUDs", $("#input_DocNo_SUDs").val());
  form_data.append(
    "input_ApproveDate_SUDs",
    $("#input_ApproveDate_SUDs").val()
  );
  form_data.append("input_ExpDate_SUDs", $("#input_ExpDate_SUDs").val());
  form_data.append("checkbox_NoExp_SUDs", $("#checkbox_NoExp_SUDs").val());
  form_data.append("input_Des_SUDs", $("#input_Des_SUDs").val());
  form_data.append("input_FileDocNo_SUDs", input_FileDocNo_SUDs);
  form_data.append(
    "Data_FileDocNo_SUDs",
    $("#input_FileDocNo_SUDs").data("value")
  );

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);

      $("#input_ApproveDate_SUDs").val(set_date());
      $("#input_ExpDate_SUDs").val(set_date());

      $("#input_DocNo_SUDs").val("");
      $("#select_typeDocument").val("");
      $("#select2-select_typeDocument_SUDs-container").text("กรุณาเลือกประเภท");
      $("#input_Des_SUDs").val("");
      $("#input_FileDocNo_SUDs").val("");

      showDialogSuccess("บันทึก เอกสารประกอบอุปกรณ์ SUDs สำเร็จ");
      showDocNoSUDs();
      // $("#btn_ClearItem_SUDs").click();
    },
  });
}

function showDocNoSUDs() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDocNoSUDs",
      input_ItemCode1_SUDs: $("#input_ItemCode1_SUDs").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_DocNo_SUDs tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.DocumentType}</td>
                      <td class='text-center'>${value.DocumentVersion}</td>
                      <td class='text-center'>${value.DocumentNo}</td>
                      <td class='text-center'><a href="assets/file/${
                        value.DocFileName
                      }" target="_blank">${value.DocFileName}</a></td>
                      <td class='text-center'>${value.DocApprovedDate}</td>
                      <td class='text-center'>${value.DocExpireDate}</td>
                      <td class='text-center'>${value.Description}</td>
                   </tr>`;
        });
      }
      $("#table_DocNo_SUDs tbody").html(_tr);
    },
  });
}

// itemSUDs

// itemSterile

$("#radio_detal_item_sterile_A").click(function () {
  $("#table_UsageCode_Sterile").DataTable().destroy();
  $("#table_UsageCode_Sterile tbody").html("");
});
$("#radio_detal_item_sterile_IN").click(function () {
  showUsageCodeSterile()
});


$("#checkbox_InActive_Sterile").click(function () {
  if ($("#checkbox_InActive_Sterile").is(":checked")) {
    $("#text_InActive_Sterile").css("color", "#2196F3");
    $("#checkbox_InActive_Sterile").val(0);
  } else {
    $("#text_InActive_Sterile").css("color", "#ccc");
    $("#checkbox_InActive_Sterile").val(1);
  }
});

$("#image1_Sterile").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});
$("#image2_Sterile").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});

var dr1Sterile = $("#image1_Sterile").dropify();
var dr2Sterile = $("#image2_Sterile").dropify();

dr1Sterile.on("dropify.afterClear ", function (event, element) {
  $("#image1_Sterile").data("value", "default");
});
dr2Sterile.on("dropify.afterClear ", function (event, element) {
  $("#image2_Sterile").data("value", "default");
});

$("#input_ApproveDate_Sterile").val(set_date());
$("#input_ApproveDate_Sterile").datepicker({
  onSelect: function (date) {},
});
$("#input_ExpDate_Sterile").val(set_date());
$("#input_ExpDate_Sterile").datepicker({
  onSelect: function (date) {},
});

$("#btn_SaveItem_Sterile").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การสร้างอุปกรณ์ Sterile",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateItemSterile();
    }
  });
});

$("#btn_ClearItem_Sterile").click(function () {
  $("#input_ItemCode1_Sterile").val("");
  $("#input_ItemCode2_Sterile").val("");
  $("#input_ItemName_Sterile").val("");
  $("#input_CostPrice_Sterile").val("");
  $("#select_Procedure_Sterile").val("");
  // $("#select2-select_Procedure_SUDs-container").text("กรุณาเลือกหัตถการ");
  $("#select_SterileProcecss_Sterile").val("");
  // $("#select2-select_SterileProcecss_SUDs-container").text(
  //   "กรุณาเลือกประเภทการ Sterile"
  // );
  $("#select_Style_Sterile").val("");
  $("#select_Howto_Sterile").val("");
  $(".dropify-clear").click();

  $("#table_DocNo_Sterile tbody").html("");
  $("#table_UsageCode_Sterile tbody").html("");

  $("#btn_SaveDocNo_Sterile").attr("disabled", true);
});

$("#btn_search_popup_Sterile").click(function () {
  $("#modal_item_Sterile").modal("toggle");

  setTimeout(() => {
    showItemSterile();
  }, 500);
});

$("#btn_SaveDocNo_Sterile").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การบันทึก เอกสารประกอบอุปกรณ์ Sterile",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateDocNoSterile();
    }
  });
});

$("#btn_AddUsage_Sterile").click(function () {
  $("#modal_Additem_Sterile").modal("toggle");

  setTimeout(() => {
    showFromAddItemSterile();
  }, 500);
});

$("#btn_Modal_SaveUsage_Sterile").click(function () {
  ArraySerie = [];
  Arraylot = [];
  Arrayexp = [];
  Arrayregister = [];
  ArrayQty = [];

  for (let index = 0; index < $("#number_row_Sterile").val(); index++) {
    if ($("#modal_input_qty_Sterile" + (index + 1)).val() != "") {


      if($("#modal_input_serie_Sterile" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก หมายเลขซีเรียล');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }
      if($("#modal_input_lot_Sterile" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก เลขล็อตการผลิต');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }

      ArraySerie.push($("#modal_input_serie_Sterile" + (index + 1)).val());
      Arraylot.push($("#modal_input_lot_Sterile" + (index + 1)).val());
      Arrayexp.push($("#modal_input_exp_Sterile" + (index + 1)).val());
      Arrayregister.push(
        $("#modal_input_register_Sterile" + (index + 1)).val()
      );
      ArrayQty.push($("#modal_input_qty_Sterile" + (index + 1)).val());
    }else{
      showDialogFailed('กรุณากรอก จำนวน');
      ArraySerie = [];
      Arraylot = [];
      Arrayexp = [];
      Arrayregister = [];
      ArrayQty = [];
      return;
    }
  }

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "SaveUsage_Sterile",
      input_ItemCode1_Sterile: $("#input_ItemCode1_Sterile").val(),
      ArraySerie: ArraySerie,
      Arraylot: Arraylot,
      Arrayexp: Arrayexp,
      Arrayregister: Arrayregister,
      ArrayQty: ArrayQty,
    },
    success: function (result) {
      $("#modal_Additem_Sterile").modal("toggle");
      showUsageCodeSterile();
    },
  });
});

$("#btn_Modal_AddUsage_Sterile").click(function () {
  var number = $("#number_row_Sterile").val();
  $("#number_row_Sterile").val(parseInt(number) + 1);
  var number_real = $("#number_row_Sterile").val();

  var txt = `   <div class="row">
                  <div class="col-md-2 text-center">
                      <label for="" style="color:black;">ลำดับ</label>
                      <br>
                      <span style="color:black;">${number_real}</span>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">หมายเลขซีเรียล</label>
                          <input type="text" class="form-control f18" id="modal_input_serie_Sterile${number_real}" placeholder="หมายเลขซีเรียล">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">เลขล็อตการผลิต</label>
                          <input type="text" class="form-control f18" id="modal_input_lot_Sterile${number_real}" placeholder="เลขล็อตการผลิต">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                          <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_Sterile${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันลงทะเบียน</label>
                          <input type="text" disabled class="form-control f18 datepicker-here" id="modal_input_register_Sterile${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">จำนวน</label>
                          <input type="text" class="form-control f18" id="modal_input_qty_Sterile${number_real}" placeholder="จำนวน">
                      </div>
                  </div>
                </div>`;

  $("#row_AdditemSterile").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
});

$("#btn_Modal_SaveEditUsage_Sterile").click(function () {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "EditUsage_Sterile",
      modal_input_serie_Sterile: $("#modal_input_serie_Sterile").val(),
      modal_input_lot_Sterile: $("#modal_input_lot_Sterile").val(),
      modal_input_exp_Sterile: $("#modal_input_exp_Sterile").val(),
      modal_input_register_Sterile: $("#modal_input_register_Sterile").val(),
      modal_input_qty_Sterile: $("#modal_input_qty_Sterile").val(),
      UsageCode: $("#modal_input_serie_Sterile").data("UsageCode"),
    },
    success: function (result) {
      $("#modal_Edititem_Sterile").modal("toggle");
      showUsageCodeSterile();
    },
  });
});

$("#input_modal_search_Sterile").keyup(function () {
  showItemSterile();
});

function showUsageCodeSterile() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showUsageCodeSterile",
      input_ItemCode1_Sterile: $("#input_ItemCode1_Sterile").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_UsageCode_Sterile").DataTable().destroy();

      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serielNo}</td>
                      <td class='text-center'>${value.UsageCode}</td>
                      <td class='text-center'>${value.lotNo}</td>
                      <td class='text-center'>${value.expDate}</td>
                      <td class='text-center'>${value.CreateDate}</td>
                      <td class='text-center'>Active</td>
                      <td class='text-center'>-</td>
                      <td class='text-center'> <span style="color:blue;cursor:pointer;"  onclick="showDetail_Usage_Sterile('${
                        value.serielNo
                      }','${value.UsageCode}','${value.lotNo}','${
            value.expDate
          }','${value.CreateDate}')">แก้ไข</span></td>
                   </tr>`;
        });
      }

      $("#table_UsageCode_Sterile tbody").html(_tr);
      $("#table_UsageCode_Sterile").DataTable({
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
          {
            width: "10%",
            targets: 7,
          },
          {
            width: "10%",
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
    },
  });
}

function showDetail_Usage_Sterile(
  serielNo,
  UsageCode,
  lotNo,
  expDate,
  CreateDate
) {
  $("#modal_Edititem_Sterile").modal("toggle");
  $("#modal_input_serie_Sterile").val(serielNo);
  $("#modal_input_lot_Sterile").val(lotNo);
  $("#modal_input_exp_Sterile").val(expDate);
  $("#modal_input_register_Sterile").val(CreateDate);
  $("#modal_input_qty_Sterile").val(1);
  $("#modal_input_serie_Sterile").data("UsageCode", UsageCode);
}

function showFromAddItemSterile() {
  $("#row_AdditemSterile").html("");

  var txt = `   <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;">ลำดับ</label>
                        <br>
                        <span style="color:black;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie_Sterile1" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot_Sterile1" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_Sterile1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันลงทะเบียน</label>
                            <input disabled type="text" class="form-control f18 datepicker-here" id="modal_input_register_Sterile1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty_Sterile1" placeholder="จำนวน">
                        </div>
                    </div>
                </div>`;

  $("#row_AdditemSterile").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
}

function showItemSterile() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showItemSterile",
      input_modal_search_Sterile: $("#input_modal_search_Sterile").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#modal_table_item_Sterile").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsCancel == "0") {
            value.IsCancel = "Active";
          } else {
            value.IsCancel = "InActive";
          }

          var typename = "";
          if (value.TyeName == "SUDs") {
            typename = "red-text";
          }
          if (value.TyeName == "OR Implant") {
            typename = "primary-text";
          }
          if (value.TyeName == "Sterile") {
            typename = "success-text";
          }

          var red = "";
          if (value.item_document_ID == "red") {
            red = `<i class="fa-solid fa-triangle-exclamation" style='font-size: 25px;color:red;'></i>`;
          }

          _tr += `<tr>
                      <td>${value.itemcode}</td>
                      <td>${red}</td>
                      <td>${value.itemcode2}</td>
                      <td>
                      
                             <div class="d-flex align-items-center">
                                  <span>${value.Item_name}</span>
                                  <span class="${typename} ms-2">${value.TyeName}</span>
                              </div> 
                      
                      </td>
                      <td>${value.IsCancel}</td>
                      <td><span style='color:blue;cursor:pointer;' onclick="showDetail_Sterile('${value.itemcode}','${value.itemcode2}','${value.Item_name}','${value.CostPrice}','${value.SterileProcessID}','${value.procedureID}','${value.Picture}','${value.Picture2}','${value.IsCancel}','${value.Description}','${value.ReuseDetect}')">เลือก</span></td>
                   </tr>`;
        });
      }

      $("#modal_table_item_Sterile tbody").html(_tr);
      $("#modal_table_item_Sterile").DataTable({
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
            width: "20%",
            targets: 0,
          },
          {
            width: "5%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 2,
          },
          {
            width: "40%",
            targets: 3,
          },
          {
            width: "20%",
            targets: 4,
          },
          {
            width: "20%",
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
    },
  });
}

function showDetail_Sterile(
  itemcode,
  itemcode2,
  Item_name,
  CostPrice,
  SterileProcessID,
  procedureID,
  Picture,
  Picture2,
  IsCancel,
  Description,
  ReuseDetect
) {
  $("#modal_item_Sterile").modal("toggle");
  $("#input_ItemCode1_Sterile").val(itemcode);
  $("#input_ItemCode2_Sterile").val(itemcode2);
  $("#input_ItemName_Sterile").val(Item_name);
  $("#input_CostPrice_Sterile").val(CostPrice);
  $("#select_SterileProcecss_Sterile").val(SterileProcessID).trigger("change");
  $("#select_Procedure_Sterile").val(procedureID).trigger("change");
  $("#select_Style_Sterile").val(Description);
  $("#select_Howto_Sterile").val(ReuseDetect);

  if (IsCancel == "InActive") {
    $("#checkbox_InActive_Sterile").prop("checked", false);
    $("#text_InActive_Sterile").css("color", "#ccc");
  } else {
    $("#text_InActive_Sterile").css("color", "#2196F3");
    $("#checkbox_InActive_Sterile").prop("checked", true);
  }

  if (Picture == "null" || Picture == "") {
    var drEvent = $("#image1_Sterile").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image1_Sterile").dropify({
      defaultFile: "assets/img/" + Picture,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image1_Sterile").data("value", Picture);
    }, 1000);
  }

  if (Picture2 == "null" || Picture2 == "") {
    var drEvent = $("#image2_Sterile").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image2_Sterile").dropify({
      defaultFile: "assets/img/" + Picture2,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture2;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image2_Sterile").data("value", Picture2);
    }, 1000);
  }

  $("#btn_SaveDocNo_Sterile").attr("disabled", false);
  $("#btn_AddUsage_Sterile").attr("disabled", false);

  setTimeout(() => {
    showDocNoSterile();
    showUsageCodeSterile();
  }, 300);
}

function onconfirm_CreateItemSterile() {


  if($("#input_ItemCode2_Sterile").val() == ""){
    showDialogFailed('กรุณากรอก รหัสอุปกรณ์');
    return;
  }

  if($("#input_ItemName_Sterile").val() == ""){
    showDialogFailed('กรุณากรอก ชื่ออุปกรณ์');
    return;
  }


  if($("#input_CostPrice_Sterile").val() == ""){
    showDialogFailed('กรุณากรอก มูลค่า');
    return;
  }

  if($("#select_Procedure_Sterile").val() == ""){
    showDialogFailed('กรุณาเลือก หัตถการ');
    return;
  }
  if($("#select_SterileProcecss_Sterile").val() == ""){
    showDialogFailed('กรุณาเลือก ประเภทการ Sterile ');
    return;
  }


  var form_data = new FormData();

  var image1_Sterile = $("#image1_Sterile").prop("files")[0];
  var image2_Sterile = $("#image2_Sterile").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateItemSterile");
  form_data.append(
    "input_ItemCode1_Sterile",
    $("#input_ItemCode1_Sterile").val()
  );
  form_data.append(
    "input_ItemCode2_Sterile",
    $("#input_ItemCode2_Sterile").val()
  );
  form_data.append(
    "input_ItemName_Sterile",
    $("#input_ItemName_Sterile").val()
  );
  form_data.append(
    "input_CostPrice_Sterile",
    $("#input_CostPrice_Sterile").val()
  );
  form_data.append(
    "select_Procedure_Sterile",
    $("#select_Procedure_Sterile").val()
  );
  form_data.append(
    "select_SterileProcecss_Sterile",
    $("#select_SterileProcecss_Sterile").val()
  );
  form_data.append("select_Style_Sterile", $("#select_Style_Sterile").val());
  form_data.append("select_Howto_Sterile", $("#select_Howto_Sterile").val());
  form_data.append(
    "radio_CheckActive_Sterile",$("#checkbox_InActive_Sterile").val());
  form_data.append("image1_Sterile", image1_Sterile);
  form_data.append("image2_Sterile", image2_Sterile);
  form_data.append("Data_image1_Sterile", $("#image1_Sterile").data("value"));
  form_data.append("Data_image2_Sterile", $("#image2_Sterile").data("value"));

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);

      showDialogSuccess("บันทึก อุปกรณ์ Sterile สำเร็จ");
      $("#btn_ClearItem_Sterile").click();
    },
  });
}

function onconfirm_CreateDocNoSterile() {

  if($("#select_typeDocument_Sterile").val() == ""){
    showDialogFailed('กรุณาเลือก ประเภทเอกสาร');
    return;
  }
  if($("#input_DocNo_Sterile").val() == ""){
    showDialogFailed('กรุณากรอก เลขที่ควบคุมเอกสาร');
    return;
  }
  if($("#input_FileDocNo_Sterile").val() == ""){
    showDialogFailed('กรุณาอัพโหลด ไฟล์');
    return;
  }


  var form_data = new FormData();

  var input_FileDocNo_Sterile = $("#input_FileDocNo_Sterile").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateDocNoSterile");
  form_data.append(
    "input_ItemCode1_Sterile",
    $("#input_ItemCode1_Sterile").val()
  );
  form_data.append(
    "select_typeDocument_Sterile",
    $("#select_typeDocument_Sterile").val()
  );
  form_data.append("input_DocNo_Sterile", $("#input_DocNo_Sterile").val());
  form_data.append(
    "input_ApproveDate_Sterile",
    $("#input_ApproveDate_Sterile").val()
  );
  form_data.append("input_ExpDate_Sterile", $("#input_ExpDate_Sterile").val());
  form_data.append(
    "checkbox_NoExp_Sterile",
    $("#checkbox_NoExp_Sterile").val()
  );
  form_data.append("input_Des_Sterile", $("#input_Des_Sterile").val());
  form_data.append("input_FileDocNo_Sterile", input_FileDocNo_Sterile);
  form_data.append(
    "Data_FileDocNo_Sterile",
    $("#input_FileDocNo_Sterile").data("value")
  );

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);

      $("#input_ApproveDate_Sterile").val(set_date());
      $("#input_ExpDate_Sterile").val(set_date());

      $("#input_DocNo_Sterile").val("");
      $("#select_typeDocument_Sterile").val("");
      $("#select2-select_typeDocument_Sterile-container").text(
        "กรุณาเลือกประเภท"
      );
      $("#input_Des_Sterile").val("");
      $("#input_FileDocNo_Sterile").val("");

      showDialogSuccess("บันทึก เอกสารประกอบอุปกรณ์ Sterile สำเร็จ");
      showDocNoSterile();
      // $("#btn_ClearItem_SUDs").click();
    },
  });
}

function showDocNoSterile() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDocNoSterile",
      input_ItemCode1_Sterile: $("#input_ItemCode1_Sterile").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_DocNo_Sterile tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.DocumentType}</td>
                      <td class='text-center'>${value.DocumentVersion}</td>
                      <td class='text-center'>${value.DocumentNo}</td>
                      <td class='text-center'><a href="assets/file/${
                        value.DocFileName
                      }" target="_blank">${value.DocFileName}</a></td>
                      <td class='text-center'>${value.DocApprovedDate}</td>
                      <td class='text-center'>${value.DocExpireDate}</td>
                      <td class='text-center'>${value.Description}</td>
                   </tr>`;
        });
      }
      $("#table_DocNo_Sterile tbody").html(_tr);
    },
  });
}

// itemSterile

// itemimplant

$("#radio_detal_item_implant_A").click(function () {
  $("#table_UsageCode_implant").DataTable().destroy();
  $("#table_UsageCode_implant tbody").html("");
});
$("#radio_detal_item_implant_IN").click(function () {
  showUsageCodeimplant()
});

$("#checkbox_InActive_implant").click(function () {
  if ($("#checkbox_InActive_implant").is(":checked")) {
    $("#text_InActive_implant").css("color", "#2196F3");
    $("#checkbox_InActive_implant").val(0);
  } else {
    $("#text_InActive_implant").css("color", "#ccc");
    $("#checkbox_InActive_implant").val(1);
  }
});

$("#image1_implant").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});
$("#image2_implant").dropify({
  messages: {
    default: "ลากและวางไฟล์ หรือคลิกเพื่ออัปโหลด",
    replace: "ลากและวาง หรือคลิกเพื่อเปลี่ยน",
    remove: "ลบ",
    error: "เกิดข้อผิดพลาด!",
  },
});

var dr1implant = $("#image1_implant").dropify();
var dr2implant = $("#image2_implant").dropify();

dr1implant.on("dropify.afterClear ", function (event, element) {
  $("#image1_implant").data("value", "default");
});
dr2implant.on("dropify.afterClear ", function (event, element) {
  $("#image2_implant").data("value", "default");
});

$("#input_ApproveDate_implant").val(set_date());
$("#input_ApproveDate_implant").datepicker({
  onSelect: function (date) {},
});
$("#input_ExpDate_implant").val(set_date());
$("#input_ExpDate_implant").datepicker({
  onSelect: function (date) {},
});

$("#btn_SaveItem_implant").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การสร้างอุปกรณ์ implant",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateItemimplant();
    }
  });
});

$("#btn_ClearItem_implant").click(function () {
  $("#input_ItemCode1_implant").val("");
  $("#input_ItemName_implant").val("");
  $("#input_CostPrice_implant").val("");
  $("#select_Procedure_implant").val("");
  $("#select_Style_implant").val("");

  $("#input_Vendor_implant").val("");
  $("#input_SalePrice_implant").val("");

  $(".dropify-clear").click();

  $("#table_DocNo_implant tbody").html("");
  $("#table_UsageCode_implant tbody").html("");

  $("#btn_SaveDocNo_implant").attr("disabled", true);
});

$("#btn_search_popup_implant").click(function () {
  $("#modal_item_implant").modal("toggle");

  setTimeout(() => {
    showItemimplant();
  }, 500);
});

$("#btn_SaveDocNo_implant").click(function () {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การบันทึก เอกสารประกอบอุปกรณ์ implant",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_CreateDocNoimplant();
    }
  });
});

$("#btn_AddUsage_implant").click(function () {
  $("#modal_Additem_implant").modal("toggle");

  setTimeout(() => {
    showFromAddItemimplant();
  }, 500);
});

$("#btn_Modal_SaveUsage_implant").click(function () {
  ArraySerie = [];
  Arraylot = [];
  Arrayexp = [];
  Arrayregister = [];
  ArrayQty = [];

  for (let index = 0; index < $("#number_row_implant").val(); index++) {
    if ($("#modal_input_qty_implant" + (index + 1)).val() != "") {


      if($("#modal_input_serie_implant" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก หมายเลขซีเรียล');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }
      if($("#modal_input_lot_implant" + (index + 1)).val() == ""){
        showDialogFailed('กรุณากรอก เลขล็อตการผลิต');
        ArraySerie = [];
        Arraylot = [];
        Arrayexp = [];
        Arrayregister = [];
        ArrayQty = [];
        return;
      }



      ArraySerie.push($("#modal_input_serie_implant" + (index + 1)).val());
      Arraylot.push($("#modal_input_lot_implant" + (index + 1)).val());
      Arrayexp.push($("#modal_input_exp_implant" + (index + 1)).val());
      Arrayregister.push(
        $("#modal_input_register_implant" + (index + 1)).val()
      );
      ArrayQty.push($("#modal_input_qty_implant" + (index + 1)).val());
    }else{
      showDialogFailed('กรุณากรอก จำนวน');
      ArraySerie = [];
      Arraylot = [];
      Arrayexp = [];
      Arrayregister = [];
      ArrayQty = [];
      return;
    }
  }

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "SaveUsage_implant",
      input_ItemCode1_implant: $("#input_ItemCode1_implant").val(),
      ArraySerie: ArraySerie,
      Arraylot: Arraylot,
      Arrayexp: Arrayexp,
      Arrayregister: Arrayregister,
      ArrayQty: ArrayQty,
    },
    success: function (result) {
      $("#modal_Additem_implant").modal("toggle");
      showUsageCodeimplant();
    },
  });
});

$("#btn_Modal_AddUsage_implant").click(function () {
  var number = $("#number_row_implant").val();
  $("#number_row_implant").val(parseInt(number) + 1);
  var number_real = $("#number_row_implant").val();

  var txt = `   <div class="row">
                  <div class="col-md-2 text-center">
                      <label for="" style="color:black;">ลำดับ</label>
                      <br>
                      <span style="color:black;">${number_real}</span>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">หมายเลขซีเรียล</label>
                          <input type="text" class="form-control f18" id="modal_input_serie_implant${number_real}" placeholder="หมายเลขซีเรียล">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">เลขล็อตการผลิต</label>
                          <input type="text" class="form-control f18" id="modal_input_lot_implant${number_real}" placeholder="เลขล็อตการผลิต">
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                          <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_implant${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">วันลงทะเบียน</label>
                          <input type="text" disabled class="form-control f18 datepicker-here" id="modal_input_register_implant${number_real}"  data-language='en' data-date-format='dd-mm-yyyy'>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="" style="color:black;">จำนวน</label>
                          <input type="text" class="form-control f18" id="modal_input_qty_implant${number_real}" placeholder="จำนวน">
                      </div>
                  </div>
                </div>`;

  $("#row_Additemimplant").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
});

$("#btn_Modal_SaveEditUsage_implant").click(function () {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "EditUsage_implant",
      modal_input_serie_implant: $("#modal_input_serie_implant").val(),
      modal_input_lot_implant: $("#modal_input_lot_implant").val(),
      modal_input_exp_implant: $("#modal_input_exp_implant").val(),
      modal_input_register_implant: $("#modal_input_register_implant").val(),
      modal_input_qty_implant: $("#modal_input_qty_implant").val(),
      UsageCode: $("#modal_input_serie_implant").data("UsageCode"),
    },
    success: function (result) {
      $("#modal_Edititem_implant").modal("toggle");
      showUsageCodeimplant();
    },
  });
});

$("#input_modal_search_implant").keyup(function () {
  showItemimplant();
});

function showUsageCodeimplant() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showUsageCodeimplant",
      input_ItemCode1_implant: $("#input_ItemCode1_implant").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_UsageCode_implant").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serielNo}</td>
                      <td class='text-center'>${value.UsageCode}</td>
                      <td class='text-center'>${value.lotNo}</td>
                      <td class='text-center'>${value.expDate}</td>
                      <td class='text-center'>${value.CreateDate}</td>
                      <td class='text-center'>Active</td>
                      <td class='text-center'>-</td>
                      <td class='text-center'> <span style="color:blue;cursor:pointer;"  onclick="showDetail_Usage_implant('${
                        value.serielNo
                      }','${value.UsageCode}','${value.lotNo}','${
            value.expDate
          }','${value.CreateDate}')">แก้ไข</span></td>
                   </tr>`;
        });
      }

      $("#table_UsageCode_implant tbody").html(_tr);
      $("#table_UsageCode_implant").DataTable({
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
          {
            width: "10%",
            targets: 7,
          },
          {
            width: "10%",
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
    },
  });
}

function showDetail_Usage_implant(
  serielNo,
  UsageCode,
  lotNo,
  expDate,
  CreateDate
) {
  $("#modal_Edititem_implant").modal("toggle");
  $("#modal_input_serie_implant").val(serielNo);
  $("#modal_input_lot_implant").val(lotNo);
  $("#modal_input_exp_implant").val(expDate);
  $("#modal_input_register_implant").val(CreateDate);
  $("#modal_input_qty_implant").val(1);
  $("#modal_input_serie_implant").data("UsageCode", UsageCode);
}

function showFromAddItemimplant() {
  $("#row_Additemimplant").html("");

  var txt = `   <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;">ลำดับ</label>
                        <br>
                        <span style="color:black;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie_implant1" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot_implant1" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_implant1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">วันลงทะเบียน</label>
                            <input disabled type="text" class="form-control f18 datepicker-here" id="modal_input_register_implant1"  data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty_implant1" placeholder="จำนวน">
                        </div>
                    </div>
                </div>`;

  $("#row_Additemimplant").append(txt);
  $(".datepicker-here").datepicker();
  $(".datepicker-here").val(set_date());
}

function showItemimplant() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showItemimplant",
      input_modal_search_implant: $("#input_modal_search_implant").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#modal_table_item_implant").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if (value.IsCancel == "0") {
            value.IsCancel = "Active";
          } else {
            value.IsCancel = "InActive";
          }

          var typename = "";
          if (value.TyeName == "SUDs") {
            typename = "red-text";
          }
          if (value.TyeName == "OR Implant") {
            typename = "primary-text";
          }
          if (value.TyeName == "Sterile") {
            typename = "success-text";
          }

          var red = "";
          if (value.item_document_ID == "red") {
            red = `<i class="fa-solid fa-triangle-exclamation" style='font-size: 25px;color:red;'></i>`;
          }

          _tr += `<tr>
                      <td>${value.itemcode}</td>
                      <td>${red}</td>
                      <td>
                      
                             <div class="d-flex align-items-center">
                                  <span>${value.Item_name}</span>
                                  <span class="${typename} ms-2">${value.TyeName}</span>
                              </div> 
                      
                      </td>
                      <td>${value.IsCancel}</td>
                      <td><span style='color:blue;cursor:pointer;' onclick="showDetail_implant('${value.itemcode}','${value.itemcode2}','${value.Item_name}','${value.CostPrice}','${value.procedureID}','${value.Picture}','${value.Picture2}','${value.IsCancel}','${value.Description}','${value.SupllierID}','${value.SalePrice}')">เลือก</span></td>
                   </tr>`;
        });
      }

      $("#modal_table_item_implant tbody").html(_tr);
      $("#modal_table_item_implant").DataTable({
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
            width: "20%",
            targets: 0,
          },
          {
            width: "5%",
            targets: 1,
          },
          {
            width: "40%",
            targets: 2,
          },
          {
            width: "20%",
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

function showDetail_implant(
  itemcode,
  itemcode2,
  Item_name,
  CostPrice,
  procedureID,
  Picture,
  Picture2,
  IsCancel,
  Description,
  SupllierID,
  SalePrice
) {
  $("#modal_item_implant").modal("toggle");
  $("#input_ItemCode1_implant").val(itemcode);
  $("#input_ItemName_implant").val(Item_name);
  $("#input_CostPrice_implant").val(CostPrice);
  $("#select_Procedure_implant").val(procedureID).trigger("change");
  $("#select_Style_implant").val(Description);

  $("#input_Vendor_implant").val(SupllierID);
  $("#input_SalePrice_implant").val(SalePrice);

  if (IsCancel == "InActive") {
    $("#checkbox_InActive_implant").prop("checked", false);
    $("#text_InActive_implant").css("color", "#ccc");
  } else {
    $("#text_InActive_implant").css("color", "#2196F3");
    $("#checkbox_InActive_implant").prop("checked", true);
  }

  if (Picture == "null" || Picture == "") {
    var drEvent = $("#image1_implant").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image1_implant").dropify({
      defaultFile: "assets/img/" + Picture,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image1_implant").data("value", Picture);
    }, 1000);
  }

  if (Picture2 == "null" || Picture2 == "") {
    var drEvent = $("#image2_implant").dropify({
      defaultFile: "",
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "";
    drEvent.destroy();
    drEvent.init();
  } else {
    var drEvent = $("#image2_implant").dropify({
      defaultFile: "assets/img/" + Picture2,
    });
    drEvent = drEvent.data("dropify");
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = "assets/img/" + Picture2;
    drEvent.destroy();
    drEvent.init();

    setTimeout(() => {
      $("#image2_implant").data("value", Picture2);
    }, 1000);
  }

  $("#btn_SaveDocNo_implant").attr("disabled", false);
  $("#btn_AddUsage_implant").attr("disabled", false);

  setTimeout(() => {
    showDocNoimplant();
    showUsageCodeimplant();
  }, 300);
}

function onconfirm_CreateItemimplant() {


  if($("#input_ItemName_implant").val() == ""){
    showDialogFailed('กรุณากรอก ชื่ออุปกรณ์');
    return;
  }

  if($("#input_CostPrice_implant").val() == ""){
    showDialogFailed('กรุณากรอก ราคาต้นทุน');
    return;
  }

  if($("#select_Procedure_implant").val() == ""){
    showDialogFailed('กรุณาเลือก หัตถการ');
    return;
  }
  if($("#input_SalePrice_implant").val() == ""){
    showDialogFailed('กรุณากรอก ราคาขาย');
    return;
  }
  if($("#input_Vendor_implant").val() == ""){
    showDialogFailed('กรุณากรอก ข้อมูล Vendor');
    return;
  }

  var form_data = new FormData();

  var image1_implant = $("#image1_implant").prop("files")[0];
  var image2_implant = $("#image2_implant").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateItemimplant");
  form_data.append(
    "input_ItemCode1_implant",
    $("#input_ItemCode1_implant").val()
  );
  form_data.append(
    "input_ItemName_implant",
    $("#input_ItemName_implant").val()
  );
  form_data.append(
    "input_CostPrice_implant",
    $("#input_CostPrice_implant").val()
  );
  form_data.append(
    "select_Procedure_implant",
    $("#select_Procedure_implant").val()
  );
  form_data.append("select_Style_implant", $("#select_Style_implant").val());
  form_data.append("input_Vendor_implant", $("#input_Vendor_implant").val());
  form_data.append(
    "input_SalePrice_implant",
    $("#input_SalePrice_implant").val()
  );
  form_data.append(
    "radio_CheckActive_implant",
    $("#checkbox_InActive_implant").val()
  );
  form_data.append("image1_implant", image1_implant);
  form_data.append("image2_implant", image2_implant);
  form_data.append("Data_image1_implant", $("#image1_implant").data("value"));
  form_data.append("Data_image2_implant", $("#image2_implant").data("value"));

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);

      showDialogSuccess("บันทึก อุปกรณ์ implant สำเร็จ");
      $("#btn_ClearItem_implant").click();
    },
  });
}

function onconfirm_CreateDocNoimplant() {

  if($("#select_typeDocument_implant").val() == ""){
    showDialogFailed('กรุณาเลือก ประเภทเอกสาร');
    return;
  }
  if($("#input_DocNo_implant").val() == ""){
    showDialogFailed('กรุณากรอก เลขที่ควบคุมเอกสาร');
    return;
  }
  if($("#input_FileDocNo_implant").val() == ""){
    showDialogFailed('กรุณาอัพโหลด ไฟล์');
    return;
  }


  var form_data = new FormData();

  var input_FileDocNo_implant = $("#input_FileDocNo_implant").prop("files")[0];

  form_data.append("FUNC_NAME", "onconfirm_CreateDocNoimplant");
  form_data.append(
    "input_ItemCode1_implant",
    $("#input_ItemCode1_implant").val()
  );
  form_data.append(
    "select_typeDocument_implant",
    $("#select_typeDocument_implant").val()
  );
  form_data.append("input_DocNo_implant", $("#input_DocNo_implant").val());
  form_data.append(
    "input_ApproveDate_implant",
    $("#input_ApproveDate_implant").val()
  );
  form_data.append("input_ExpDate_implant", $("#input_ExpDate_implant").val());
  form_data.append(
    "checkbox_NoExp_implant",
    $("#checkbox_NoExp_implant").val()
  );
  form_data.append("input_Des_implant", $("#input_Des_implant").val());
  form_data.append("input_FileDocNo_implant", input_FileDocNo_implant);
  form_data.append(
    "Data_FileDocNo_implant",
    $("#input_FileDocNo_implant").data("value")
  );

  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    dataType: "text",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (result) {
      // var ObjData = JSON.parse(result);
      // console.log(ObjData);
      $("#input_ApproveDate_implant").val(set_date());
      $("#input_ExpDate_implant").val(set_date());
      $("#input_DocNo_implant").val("");
      $("#select_typeDocument_implant").val("");
      $("#input_Des_implant").val("");
      $("#input_FileDocNo_implant").val("");

      showDialogSuccess("บันทึก เอกสารประกอบอุปกรณ์ implant สำเร็จ");
      showDocNoimplant();
      // $("#btn_ClearItem_SUDs").click();
    },
  });
}

function showDocNoimplant() {
  $.ajax({
    url: "process/register_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDocNoimplant",
      input_ItemCode1_implant: $("#input_ItemCode1_implant").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_DocNo_implant tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.DocumentType}</td>
                      <td class='text-center'>${value.DocumentVersion}</td>
                      <td class='text-center'>${value.DocumentNo}</td>
                      <td class='text-center'><a href="assets/file/${
                        value.DocFileName
                      }" target="_blank">${value.DocFileName}</a></td>
                      <td class='text-center'>${value.DocApprovedDate}</td>
                      <td class='text-center'>${value.DocExpireDate}</td>
                      <td class='text-center'>${value.Description}</td>
                   </tr>`;
        });
      }
      $("#table_DocNo_implant tbody").html(_tr);
    },
  });
}

// itemimplant

function select_typeDocument() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_typeDocument",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกประเภท</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.DocumentType}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_typeDocument_SUDs").html(option);
      $("#select_typeDocument_Sterile").html(option);
      $("#select_typeDocument_implant").html(option);
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
      $("#select_Procedure_SUDs").html(option);
      $("#select_Procedure_Sterile").html(option);
      $("#select_Procedure_implant").html(option);
    },
  });
}

function select_sterileprocess() {
  $.ajax({
    url: "process/process_main/select_main.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_sterileprocess",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกประเภทการ Sterile</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.ID}" >${value.SterileName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_SterileProcecss_SUDs").html(option);
      $("#select_SterileProcecss_Sterile").html(option);
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

      $("#input_Deproom_Main").val(departmentroomname);
      $("#input_Name_Main").val(UserName);
    },
  });
}

function showDialogFailed(text) {
  Swal.fire({
    title: "ล้มเหลว",
    text: text,
    icon: "error",
  });
}

function showDialogSuccess(text) {
  Swal.fire({
    title: "สำเร็จ",
    text: text,
    icon: "success",
    timer: 1000,
  });
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
