var departmentroomname = "";
var UserName = "";
$(function () {
  var wrapper = document.getElementById("signature-pad");
  var canvas = wrapper.querySelector("canvas");
  var signaturePad = new SignaturePad(canvas, {
    backgroundColor: "rgb(255, 255, 255)",
  });
  document.getElementById("clear").addEventListener("click", function () {
    signaturePad.clear();
  });

  session();


  
  $("#select_departmentRoom").select2();
  $("#select_deproom_pay").select2();

  $("#select_date_receive").val(set_date());
  $("#select_date_receive").datepicker({
    onSelect: function (date) {
      show_detail_stock();
    },
  });
  $("#select_date_pay").val(set_date());
  $("#select_date_pay").datepicker({
    onSelect: function (date) {
      feeddata_Payout_tab2();
    },
  });
  $("#select_Edate_pay").val(set_date());
  $("#select_Edate_pay").datepicker({
    onSelect: function (date) {
      feeddata_Payout_tab2();
    },
  });
  
  show_detail_stock2();


  $("#paysterile").hide();

  $("#radio_receive").css("color", "#bbbbb");
  $("#radio_receive").css(
    "background","#EAECF0"
  );

  $("#radio_receive").click(function () {
    $("#radio_receive").css("color", "#bbbbb");
    $("#radio_receive").css(
      "background",
      "#EAECF0"
    );

    $("#radio_paysterile").css("color", "black");
    $("#radio_paysterile").css("background", "");

    $("#receive").show();
    $("#paysterile").hide();

    show_detail_stock2();
  });

  $("#radio_paysterile").click(function () {
    $("#radio_paysterile").css("color", "#bbbbb");
    $("#radio_paysterile").css(
      "background",
      "#EAECF0"
    );

    $("#radio_receive").css("color", "black");
    $("#radio_receive").css("background", "");

    $("#receive").hide();
    $("#paysterile").show();



    feeddata_Payout_tab2();

  });





});

function show_detail_stock2() {
  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_stock2",
      select_date_receive: $("#select_date_receive").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_receive_stock").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["RefDocNo"], function (kay, value) {


          _tr +=
            `<tr onclick='showTrDoc2("${value.DocNo}","Requests")'  class=" clear_bg" id="tr_${value.DocNo}" style='cursor:pointer;'> ` +
            `<td class="text-center">${
              kay + 1
            }   <input id='inputArrowDoc_${kay}' value='0' hidden >   </td>` +
            `<td class="text-center"><label style='text-decoration: underline;font-weight:bold;'>${value.DocNo}</label></td>` +
            `<td class="text-center"></td>` +
            `<td class="text-center"> <button class='btn' style='background-color:#7F56D9;color:#ffffff;font-size: 15px;'>Requests</button> </td>` +
            `<td class="text-center">${value.qty}</td>` +
            ` </tr>`;
        });
      }

      $("#table_receive_stock tbody").html(_tr);
      $("#table_receive_stock").DataTable({
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
            width: "20%",
            targets: 1,
          },
          {
            width: "30%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
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

function show_detail_stock() {
  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_stock",
      select_date_receive: $("#select_date_receive").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_receive_stock").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["RefDocNo"], function (kay, value) {
          var qty = 0;
          var qtyS = 0;
          $.each(ObjData[value.RefDocNo], function (kayD1, valueD1) {
            qty++;

            if (valueD1.IsStatus == "3") {
              qtyS++;
            }
          });
          if (qty == qtyS) {
            var textstatus1 = "Complete";
            qtyS++;
          } else {
            var textstatus1 = "Waiting";
          }

          _tr +=
            `<tr onclick='showTrDoc(${kay})'  class="" id="tr_${value.RefDocNo}" style='cursor:pointer;'> ` +
            `<td class="text-center">${
              kay + 1
            }   <input id='inputArrowDoc_${kay}' value='0' hidden >   </td>` +
            `<td class="text-center"><label style='text-decoration: underline;font-weight:bold;'>${value.RefDocNo}</label></td>` +
            `<td class="text-center"></td>` +
            `<td class="text-center">${textstatus1}</td>` +
            `<td class="text-center">${qty}</td>` +
            ` </tr>`;
          $.each(ObjData[value.RefDocNo], function (kayD1, valueD1) {
            if (valueD1.IsStatus == "3") {
              var bg = "colorG";
              var textstatus = "Complete";
            } else {
              var textstatus = "Waiting";
            }
            _tr +=
              `<tr hidden  class="color ${bg} trDetailDoc_${kay}" onclick='setActive_feeddata_payout_detail("${valueD1.DocNo}")' id="tr_${valueD1.DocNo}"> ` +
              `<td class="text-center"></td>` +
              `<td class="text-center">${valueD1.DocNo}</td>` +
              `<td class="text-center">${valueD1.DepName2}</td>` +
              `<td class="text-center">${textstatus}</td>` +
              `<td class="text-center">${valueD1.qty}</td>` +
              ` </tr>`;
          });
        });
      }

      $("#table_receive_stock tbody").html(_tr);
      $("#table_receive_stock").DataTable({
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
            width: "20%",
            targets: 1,
          },
          {
            width: "30%",
            targets: 2,
          },
          {
            width: "10%",
            targets: 3,
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

function showTrDoc2(DocNo,type) {
  $(".clear_bg").css("background-color", "")
  $("#tr_"+DocNo).css("background-color", "#EFF8FF");

  if(type == 'Requests'){
    $("#btn_sendData").attr('disabled',true);
  }else{
    $("#btn_sendData").attr('disabled',false);
  }

  feeddata_Payout_detail2(DocNo);
}
function showTrDoc(id) {
  if ($("#inputArrowDoc_" + id).val() == 0) {
    $("#arrowUp_" + id).attr("hidden", true);
    $("#arrowDown_" + id).attr("hidden", false);
    $(".trDetailDoc_" + id).attr("hidden", false);
    $("#inputArrowDoc_" + id).val(1);
  } else {
    $("#arrowUp_" + id).attr("hidden", false);
    $("#arrowDown_" + id).attr("hidden", true);
    $(".trDetailDoc_" + id).attr("hidden", true);
    $("#inputArrowDoc_" + id).val(0);
  }
}

function showTr(id) {
  if ($("#open_" + id).val() == 1) {
    $("#open_" + id).val(0);
    $("#open_" + id).animate({ rotate: "0deg", scale: "1.25" }, 500);
    $(".trDetail_" + id).hide(300);
  } else {
    $("#open_" + id).val(1);
    $("#open_" + id).animate({ rotate: "180deg", scale: "1.25" }, 500);
    $(".trDetail_" + id).show(500);
  }
}

function setActive_feeddata_payout_detail(DocNo) {
  $(".color").css("background-color", "");
  $("#tr_" + DocNo).css("background-color", "#f8aeae");
  $("#checkall").prop("checked", false);
  $("#btn_sendData").attr("disabled", true);
  // alert(DocNo);
  feeddata_Payout_detail(DocNo);

  $("#input_type_receive").val(1);
}

function feeddata_Payout_detail2(DocNo){
  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_Payout_detail2",
      DocNo: DocNo,
    },
    success: function (result) {
      var _tr = "";
      $("#table_receive_stock_item").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

          _tr +=
            `<tr> ` +
            `<td class="text-center "><input type="checkbox"  class="form-check-input checkAllMain" id="checkAllMain_${kay}" style="width: 25px;height: 20px;"></td>` +
            `<td class="text-left" >${value.itemname}</td>` +
            `<td class="text-center">${value.Qty}</td>` +
            `<td class="text-center">0</td>` +
            `<td class="text-center">${value.Qty}</td>` +
            ` <td class="text-center"></td>  ` +
            ` </tr>`;
        });
      }

      $("#table_receive_stock_item tbody").html(_tr);
      $("#table_receive_stock_item").DataTable({
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
            width: "35%",
            targets: 1,
          },
          {
            width: "15%",
            targets: 2,
          },
          {
            width: "15%",
            targets: 3,
          },
          {
            width: "15%",
            targets: 4,
          },
          {
            width: "5%",
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

function feeddata_Payout_detail(DocNo) {
  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_Payout_detail",
      DocNo: DocNo,
    },
    success: function (result) {
      var _tr = ``;
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["itemcode"], function (kay, value) {
          var countNoCheck = 0;
          var countCheck = 0;
          var countall = 0;
          $.each(ObjData[value.itemcode], function (keyCount, valueCount) {
            if (valueCount.IsStatus == 3) {
              countNoCheck++;
            } else {
              countCheck++;
            }
            countall++;
          });

          var hidden = "";
          var hiddentd = "hidden";

          if (countNoCheck == countall) {
            var hidden = "hidden";
            var hiddentd = "";
          }

          if (value.IsStatus != "3") {
            var bg = 'style="background-color: #f8aeae;"';
          }

          _tr +=
            `<tr ${bg}> ` +
            `<td class="text-center "><input ${hidden} type="checkbox" onclick='checkAll_Main(${kay})' class="form-check-input checkAllMain" id="checkAllMain_${kay}" style="width: 25px;height: 20px;"></td>` +
            `<td class="text-left" onclick='showTr(${kay})'>${value.itemname}</td>` +
            `<td class="text-center" onclick='showTr(${kay})'>${value.CountItem}</td>` +
            `<td class="text-center" onclick='showTr(${kay})'>${countNoCheck}</td>` +
            `<td class="text-center" onclick='showTr(${kay})'>${countCheck}</td>` +
            ` <td class="text-center"><i ${hidden} class="fa-solid fa-caret-up" style='font-size:30px;cursor:pointer;' id='open_${kay}' value='0' onclick='showTr(${kay})'></i></td>  ` +
            ` <td class="text-center" ${hiddentd}></td>  ` +
            ` </tr>`;

          $.each(ObjData[value.itemcode], function (kayD1, valueD1) {
            if (valueD1.IsStatus == 3) {
              var disabled = "disabled";
            } else {
              var disabled = "";
            }
            $("#input_DocNo").val(valueD1.DocNo);

            _tr +=
              `<tr class='trDetail_${kay} all111'  > ` +
              `<td class="text-center ">
                          <input ${disabled} value="${valueD1.UsageCode}"  type="checkbox"  data-itemstockid="${valueD1.RowID}"  data-payoutdetailsubid="${valueD1.Id}"  onclick='checkAll_Sub(${kay})' class="form-check-input checkAllSub_${kay}  checkAllSub" id="checkAllSub_${valueD1.UsageCode}"   style="width: 25px;height: 20px;">
                          </td>` +
              `<td class="text-center"> ${valueD1.UsageCode}</td>` +
              `<td class="text-center">1</td>` +
              `<td class="text-center"></td>` +
              `<td class="text-center"></td>` +
              `<td class="text-center"></td>` +
              ` </tr>`;
          });
        });
      }

      $("#table_receive_stock_item tbody").html(_tr);
      $(".all111").hide();
    },
  });
}

$("#input_scan_back").keypress(function (e) {
  if (e.which == 13) {
    var cnt = 0;
    $(".checkAllSub").each(function (key, value) {
      if (!$(this).is(":disabled")) {
        if ($(this).val() == $("#input_scan_back").val().trim()) {
          if (
            $("#checkAllSub_" + $("#input_scan_back").val().trim()).is(
              ":checked"
            )
          ) {
            showDialogFailed("สแกนซ้ำ");
          }
          $("#checkAllSub_" + $("#input_scan_back").val().trim()).prop(
            "checked",
            true
          );
          cnt++;
        }else{
          showDialogFailed("ไม่พบรหัสนี้ในระบบ");
        }
      } else {
        if ($(this).val() == $("#input_scan_back").val().trim()) {
          showDialogFailed("รหัสนี้ถูกรับเข้าคลังทันตกรรม เรียบร้อยแล้ว");
          cnt++;
        }else{
          showDialogFailed("ไม่พบรหัสนี้ในระบบ");
        }
      }
    });

    $("#input_scan_back").val("");
  }
});

function checkAll_Main(kay) {
  var checktotal = 0;

  if ($("#checkAllMain_" + kay).is(":checked")) {
    $(".checkAllSub_" + kay).each(function (key, value) {
      if ($(this).is(":disabled")) {
        $(this).prop("checked", false);
      } else {
        $(this).prop("checked", true);
      }
    });

    $("#btn_sendData").attr("disabled", false);
  } else {
    $(".checkAllSub_" + kay).each(function (key, value) {
      $(this).prop("checked", false);
    });

    $("#btn_sendData").attr("disabled", true);
  }
}

function checkAll_Sub(kay) {
  var checktotal = 0;
  var countAll = $(".checkAllSub_" + kay).length;

  $(".checkAllSub_" + kay).each(function (key, value) {
    if ($(this).is(":checked")) {
      checktotal++;
    }
  });

  if (checktotal == 0) {
    $("#btn_sendData").attr("disabled", true);
  } else {
    $("#btn_sendData").attr("disabled", false);
  }

  if (checktotal == countAll) {
    $("#checkAllMain_" + kay).prop("checked", true);
  } else {
    $("#checkAllMain_" + kay).prop("checked", false);
  }
}

$("#btn_sendData").click(function () {
  $("#exampleModal").modal("toggle");
  $("#clear").click();
});

$("#btn_save").click(function () {
  onConfirmReceiveItemstock();
});

function onConfirmReceiveItemstock() {
  Swal.fire({
    title: settext("lang_text_confirm"),
    text: "ยืนยันการรับอุปกรณ์เข้าคลัง",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: settext("lang_text_confirm"),
    cancelButtonText: settext("lang_text_cancel"),
  }).then((result) => {
    if (result.isConfirmed) {
      ReceiveItemstock();
    }
  });
}

function ReceiveItemstock() {
  var ArrayItemStockID = [];
  var Arraypayoutdetailsubid = [];

  $(".checkAllSub").each(function (key, value) {
    if ($(this).is(":checked")) {
      ArrayItemStockID.push($(this).data("itemstockid"));
      Arraypayoutdetailsubid.push($(this).data("payoutdetailsubid"));
      // ArrayCnt.push($(this).data('cnt'));
    }
  });

  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "onConfirmReceiveItemstock",
      ArrayItemStockID: ArrayItemStockID,
      Arraypayoutdetailsubid: Arraypayoutdetailsubid,
      select_departmentRoom: $("#select_departmentRoom").val(),
      DocNo: $("#input_DocNo").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $.each(ObjData, function (kay, value) {
        if (value.IsStatus == 3) {
          var wrapper = document.getElementById("signature-pad");
          var canvas = wrapper.querySelector("canvas");
          const dataURL = canvas.toDataURL();
          console.log(dataURL);

          var EmpCode = "<?php echo $EmpCode; ?>";
          var d = new Date();
          var month = d.getMonth() + 1;
          var day = d.getDate();
          var year = d.getFullYear();
          var output =
            year +
            "-" +
            (("" + month).length < 2 ? "0" : "") +
            month +
            "-" +
            (("" + day).length < 2 ? "0" : "") +
            day;

          var dt = new Date();
          if (("" + dt.getHours()).length < 2) {
            var h = "0" + dt.getHours();
          } else {
            var h = dt.getHours();
          }

          if (("" + dt.getMinutes()).length < 2) {
            var m = "0" + dt.getMinutes();
          } else {
            var m = dt.getMinutes();
          }

          if (("" + dt.getSeconds()).length < 2) {
            var s = "0" + dt.getSeconds();
          } else {
            var s = dt.getSeconds();
          }

          var time = h + ":" + m + ":" + s;
          // document.write(time);

          // alert(dateString);

          var file = $("#img1").prop("files")[0];
          var imgbase64 = "none";
          if (file != undefined) {
            var reader = new FileReader();
            var baseString;
            reader.readAsDataURL(file);
            reader.onloadend = function () {
              baseString = reader.result;

              imgbase64 = baseString;
              // console.log(baseString);
            };
          }

          setTimeout(() => {
            const body = {
              return_no: value.DocNo,
              client_id: client_id,
              client_secret: client_secret,
              api_name: Api_ComfirmReturn,
              request_no: value.RefDocNo,
              employee_code: EmpCode,
              signature: dataURL,
              file: imgbase64,
              confirm_date: output,
              confirm_time: time,
            };

            console.log(body);
            $.ajax({
              url: "https://poseintelligence.co.th/api/department/confirm-return/confirm",
              type: "POST",
              contentType: "application/json",
              data: JSON.stringify(body),
              success: function (result) {
                $.each(result, function (kay, value) {
                  Swal.fire({
                    title: value.description,
                  });
                });
              },
            });
          }, 300);
        }
      });

      $("#exampleModal").modal("toggle");
      // $("#table_receive_stock_item tbody").empty();

      // feeddata_Payout_detail2($("#input_DocNo").val());

      setTimeout(() => {
        var check_all = 0;
        var sum_all = 0;
        $(".checkAllSub").each(function (key, value) {
          sum_all++;

            if ($(this).is(":disabled")) {
              check_all++;
            }
            if ($(this).is(":checked")) {
              check_all++;
            }
        });

        if(sum_all == check_all){
          show_detail_stock();
        }

        alert(sum_all + '-' + check_all);
      }, 500);

      

      // feeddata_Payout();
    },
  });
}

// /////////////////////////////////////////////////////////////tab2

function feeddata_Payout_tab2() {
  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_Payout_tab2",
      select_date_pay: $("#select_date_pay").val(),
      select_Edate_pay: $("#select_Edate_pay").val(),
    },
    success: function (result) {
      var _tr = ``;
      var ObjData = JSON.parse(result);

      $("#table_document_sterile").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["RefDocNo"], function (kay, value) {
          var qty = 0;
          var qtyS = 0;
          $.each(ObjData[value.RefDocNo], function (kayD1, valueD1) {
            qty++;

            if (valueD1.IsStatus == "3") {
              qtyS++;
            }
          });
          if (qty == qtyS) {
            var textstatus1 = "Complete";
            qtyS++;
          } else {
            var textstatus1 = "Waiting";
          }

          

          _tr +=
            `<tr> ` +
            `<td class="text-center"><input  value="${value.RefDocNo}"  type="checkbox" onclick='checkDetailTab2()'   class="form-check-input checkbox_detailtab2"  style="width: 25px;height: 20px;"></td>` +
            `<td class="text-center">${value.RefDocNo}</td>` +
            `<td class="text-center">${textstatus1}</td>` +
            `<td class="text-center">${qty}</td>` +
            ` </tr>`;
        });
      }

      $("#table_document_sterile tbody").html(_tr);
    },
  });
}



function checkDetailTab2() {
  var RefDocNo = [];

  $(".checkbox_detailtab2").each(function (key, value) {
    if ($(this).is(":checked")) {
      RefDocNo.push($(this).val());
    }
  });

  $("#btn_showReportTab2").data("RefDocNo", RefDocNo);

  $.ajax({
    url: "process/recieve_stock.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddata_Payout_detail_tab2",
      RefDocNo: RefDocNo,
    },
    success: function (result) {
      var _tr = ``;
      var ObjData = JSON.parse(result);

      $("#table_document_sterile_item").DataTable().destroy();

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr> ` +
            `<td class="text-center">${kay+1}</td>` +
            `<td class="text-left">${value.itemname}</td>` +
            `<td class="text-center">${value.CostPrice}</td>` +
            `<td class="text-center">${value.qty}</td>` +
            `<td class="text-center">${value.totalPrice}</td>` +
            ` </tr>`;
        });
      }

      $("#table_document_sterile_item tbody").html(_tr);
      $("#table_document_sterile_item").DataTable({
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
            width: "10%",
            targets: 0,
          },
          {
            width: "40%",
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

  if (S_Input.length > 0) {
    if (S_Input.charCodeAt(0) > 1000) {
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
