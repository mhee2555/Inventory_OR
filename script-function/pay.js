var departmentroomname = "";
var UserName = "";
$(function () {
  session();

  $("#select_date_pay").val(set_date());
  $("#select_date_pay").datepicker({
    onSelect: function (date) {
      show_detail_deproom_pay();
    },
  });
  $("#select_date_history_S").val(set_date());
  $("#select_date_history_S").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });
  $("#select_date_history_L").val(set_date());
  $("#select_date_history_L").datepicker({
    onSelect: function (date) {
      show_detail_history();
    },
  });
  $("#input_date_service").val(set_date());
  $("#input_date_service").datepicker({
    onSelect: function (date) {
      updateService();
    },
  });

  $("#input_time_service").change(function (e) {
    updateService();
  });

  $("#history_pay").hide();
  $("#claim").hide();

  $("#radio_pay").css("color", "#bbbbb");
  $("#radio_pay").css("background", "#EAECF0");

  $("#radio_pay").click(function () {
    $("#radio_pay").css("color", "#bbbbb");
    $("#radio_pay").css("background", "#EAECF0");

    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");
    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");

    $("#pay").show();
    $("#history_pay").hide();
    $("#claim").hide();
  });

  $("#radio_history_pay").click(function () {
    $("#radio_history_pay").css("color", "#bbbbb");
    $("#radio_history_pay").css("background", "#EAECF0");

    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");

    $("#pay").hide();
    $("#history_pay").show();
    $("#claim").hide();

    show_detail_history();

    $("#select_deproom_history").select2();
    $("#select_doctor_history").select2();
    $("#select_procedure_history").select2();
  });
  $("#radio_claim").click(function () {
    $("#radio_claim").css("color", "#bbbbb");
    $("#radio_claim").css("background", "#EAECF0");

    $("#radio_pay").css("color", "black");
    $("#radio_pay").css("background", "");
    $("#radio_history_pay").css("color", "black");
    $("#radio_history_pay").css("background", "");

    $("#pay").hide();
    $("#history_pay").hide();
    $("#claim").show();

    feeddataClaim();
  });

  show_detail_deproom_pay();
  select_deproom();
  select_doctor();
  select_procedure();

  $("#select_deproom_pay").select2();
});

$("#input_pay").keypress(function (e) {
  if (e.which == 13) {
    $("#input_pay").val(convertString($(this).val()));
    oncheck_pay($(this).val());
  }
});
$("#input_returnpay").keypress(function (e) {
  if (e.which == 13) {
    $("#input_returnpay").val(convertString($(this).val()));
    oncheck_Returnpay($(this).val());
  }
});
$("#select_deproom_pay").change(function (e) {
  show_detail_deproom_pay();
});

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
                      <td class="f24 text-left">${
                        value.departmentroomname
                      }</td>
                      <td class=""></td>
                   </tr>`;
          $.each(ObjData[value.id], function (kay, value2) {
            if (value2.cnt_sub >= value2.cnt_detail) {
              var txt = "ครบ";
              var sty = "color:#00bf63 ";
            } else {
              var txt = "ค้าง";
              var sty = "color:#ed1c24 ";
            }

            _tr += `<tr class='tr_${value.id} all111' >
                          <td class='text-center'>
                            <div class="form-check">
                              <input style="width: 20px;height: 20px;" class="form-check-input position-static clear_checkbox" type="checkbox" id="checkbox_${value2.DocNo}" onclick='oncheck_show_byDocNo("${value2.DocNo}","${value2.hn_record_id}","${value2.serviceDate}","${value2.serviceTime}")'>
                            </div>
                          </td>
                          <td>
                            <div class="row">
                              <div class="col-md-3 text-left"> ${value2.hn_record_id}</div>
                              <div class="col-md-5 text-center">${value2.Procedure_TH}</div>
                              <div class="col-md-4 text-center">${value2.Doctor_Name}</div>

                            </div>
                          
                           </td>
                          <td class='text-center'> <label id='text_balance_${value2.DocNo}' class='f18' style='font-weight:bold;${sty};text-decoration-line: underline;'>${txt}</label> </td>

                        </tr>`;
          });
        });
      }

      $("#table_deproom_pay tbody").html(_tr);

      $(".all111").hide();

      // $("#table_deproom_pay").DataTable({
      //   language: {
      //     emptyTable: settext("dataTables_empty"),
      //     paginate: {
      //       next: settext("table_itemStock_next"),
      //       previous: settext("table_itemStock_previous"),
      //     },
      //     search: settext("btn_Search"),
      //     info:
      //       settext("dataTables_Showing") +
      //       " _START_ " +
      //       settext("dataTables_to") +
      //       " _END_ " +
      //       settext("dataTables_of") +
      //       " _TOTAL_ " +
      //       settext("dataTables_entries") +
      //       " ",
      //   },
      //   columnDefs: [
      //     {
      //       width: "40%",
      //       targets: 0,
      //     },
      //     {
      //       width: "10%",
      //       targets: 1,
      //     },
      //   ],
      //   info: false,
      //   scrollX: false,
      //   scrollCollapse: false,
      //   visible: false,
      //   searching: false,
      //   lengthChange: false,
      //   fixedHeader: false,
      //   ordering: false,
      // });
      // $("th").removeClass("sorting_asc");
      // if (_tr == "") {
      //   $(".dataTables_info").text(
      //     settext("dataTables_Showing") +
      //       " 0 " +
      //       settext("dataTables_to") +
      //       " 0 " +
      //       settext("dataTables_of") +
      //       " 0 " +
      //       settext("dataTables_entries") +
      //       ""
      //   );
      // }
    },
  });
}

function oncheck_show_byDocNo(DocNo, hn_record_id, serviceDate, serviceTime) {
  $(".clear_checkbox").prop("checked", false);
  $("#checkbox_" + DocNo).prop("checked", true);

  $("#input_Hn_pay").val("HN Code : " + hn_record_id);
  $("#input_Hn_pay").data("docno", DocNo);
  $("#input_Hn_pay").data("hncode", hn_record_id);
  $("#input_date_service").val(serviceDate);
  $("#input_time_service").val(serviceTime);

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
                      <td class='text-center'><input type='text' class='form-control text-center f18' value="${value.cnt}" disabled id="qty_request_${value.itemcode}"></td>
                      <td class='text-center'><input type='text' class='form-control text-center f18 loop_item_pay' value="${value.cnt_pay}"  data-itemcode='${value.itemcode}' disabled></td>
                      <td class='text-center'><input type='text' class='form-control text-center f18 loop_item_balance' disabled value="${balance}" id="balance_request_${value.itemcode}"></td>
                   </tr>`;
        });
      }

      $("#table_deproom_DocNo_pay tbody").html(_tr);
      // $("#table_deproom_DocNo_pay").DataTable({
      //   language: {
      //     emptyTable: settext("dataTables_empty"),
      //     paginate: {
      //       next: settext("table_itemStock_next"),
      //       previous: settext("table_itemStock_previous"),
      //     },
      //     search: settext("btn_Search"),
      //     info:
      //       settext("dataTables_Showing") +
      //       " _START_ " +
      //       settext("dataTables_to") +
      //       " _END_ " +
      //       settext("dataTables_of") +
      //       " _TOTAL_ " +
      //       settext("dataTables_entries") +
      //       " ",
      //   },
      //   columnDefs: [
      //     {
      //       width: "40%",
      //       targets: 0,
      //     },
      //     {
      //       width: "10%",
      //       targets: 1,
      //     },
      //     {
      //       width: "10%",
      //       targets: 2,
      //     },
      //     {
      //       width: "10%",
      //       targets: 3,
      //     },
      //   ],
      //   info: false,
      //   scrollX: false,
      //   scrollCollapse: false,
      //   visible: false,
      //   searching: false,
      //   lengthChange: false,
      //   fixedHeader: false,
      //   ordering: false,
      // });
      // $("th").removeClass("sorting_asc");
      // if (_tr == "") {
      //   $(".dataTables_info").text(
      //     settext("dataTables_Showing") +
      //       " 0 " +
      //       settext("dataTables_to") +
      //       " 0 " +
      //       settext("dataTables_of") +
      //       " 0 " +
      //       settext("dataTables_entries") +
      //       ""
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
      var ObjData = JSON.parse(result);
      $.each(ObjData, function (key, value) {

          if(value.check_exp == 'exp'){
            itemname += value.UsageCode+',';
          }

      });
      itemname = itemname.substring(0, itemname.length - 1);

      show_detail_item_ByDocNo();
      $("body").loadingModal("destroy");

      setTimeout(() => {
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
      }, 300);


      if(itemname != ""){
        Swal.fire({
          title:  settext("alert_fail"),
          html: `อุปกรณ์หมดอายุไม่สามารถสแกนจ่ายได้ <br> ${itemname}`,
          icon: "warning",
        });
      }


      
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
    if (_exp == "exp") {
      showDialogFailed(settext("alert_expired"));
      console.log("exp");
      $("#input_pay").val("");
      return;
    }

    if (_Isdeproom == "2" || _Isdeproom == "4") {
      console.log("hn");
      $("#input_pay").val("");
      search_hn_alert(input_pay);
      return;
    }

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
        input_date_service: $("#input_date_service").val(),
      },
      success: function (result) {
        if (result == 0) {
          showDialogFailed(settext("Not_Found"));
        } else if (result == 1) {
          showDialogFailed("จ่ายครบแล้ว");
        } else if (result == 2) {
          show_detail_item_ByDocNo();
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
      if (result == 0) {
        showDialogFailed(settext("Not_Found"));
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
function show_detail_history() {
  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_history",
      select_date_history_s: $("#select_date_history_S").val(),
      select_date_history_l: $("#select_date_history_L").val(),
      select_deproom_history: $("#select_deproom_history").val(),
      select_doctor_history: $("#select_doctor_history").val(),
      select_procedure_history: $("#select_procedure_history").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_history").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr += `<tr>
                      <td class='text-center'>${kay + 1}</td>
                      <td class='text-center'>${value.serviceDate}</td>
                      <td class='text-center'>${value.hn_record_id}</td>
                      <td class='text-left'>${value.Doctor_Name}</td>
                      <td class='text-left'>${value.Procedure_TH}</td>
                      <td class='text-left'>${value.departmentroomname}</td>
                      <td class='text-center'><button class='btn btn-outline-danger f18' onclick='cancel_item_byDocNo("${
                        value.DocNo
                      }")' >ยกเลิก</button></td>
                      <td class='text-center'><button class='btn f18' style='background-color:#1570EF;color:#fff;' onclick='show_Report("${
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
            width: "10%",
            targets: 3,
          },
          {
            width: "15%",
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
            width: "8%",
            targets: 7,
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
  window.open("report/Report_Issue_Order_HN.php" + option, "_blank");
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
        // $("#table_item_claim").DataTable({
        //   language: {
        //     emptyTable: settext("dataTables_empty"),
        //     paginate: {
        //       next: settext("table_itemStock_next"),
        //       previous: settext("table_itemStock_previous"),
        //     },
        //     info:
        //       settext("dataTables_Showing") +
        //       " _START_ " +
        //       settext("dataTables_to") +
        //       " _END_ " +
        //       settext("dataTables_of") +
        //       " _TOTAL_ " +
        //       settext("dataTables_entries") +
        //       " ",
        //   },
        //   columnDefs: [
        //     {
        //       width: "5%",
        //       targets: 0,
        //       width: "5%",
        //       targets: 1,
        //       width: "70%",
        //       targets: 2,
        //       width: "20%",
        //       targets: 3,
        //     },
        //   ],
        //   info: true,
        //   scrollX: false,
        //   scrollCollapse: false,
        //   visible: false,
        //   searching: false,
        //   lengthChange: false,
        //   fixedHeader: false,
        //   ordering: false,
        // });

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
