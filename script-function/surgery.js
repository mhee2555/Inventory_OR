var departmentroomname = "";
var UserName = "";
$(function () {
  session();

  $("#select_date_surgery").val(set_date());
  $("#select_date_surgery").datepicker({
    onSelect: function (date) {
      show_detail_item_surgery();
    },
  });

  show_detail_item_surgery();




  $("#claim").hide();

  $("#radio_use").css("color", "#bbbbb");
  $("#radio_use").css(
    "background",
    "#EAECF0"
  );

  $("#radio_use").click(function () {
    $("#radio_use").css("color", "#bbbbb");
    $("#radio_use").css(
      "background",
      "#EAECF0"
    );

    $("#radio_claim").css("color", "black");
    $("#radio_claim").css("background", "");

    $("#use_item").show();
    $("#claim").hide();
  });

  $("#radio_claim").click(function () {
    $("#radio_claim").css("color", "#bbbbb");
    $("#radio_claim").css(
      "background",
      "#EAECF0"
    );

    $("#radio_use").css("color", "black");
    $("#radio_use").css("background", "");

    $("#use_item").hide();
    $("#claim").show();

    feeddataClaim();

  });



});

// =====================================

$("#input_use").keypress(function (e) {
  if (e.which == 13) {
    $("#input_use").val(convertString($(this).val()));
    oncheck_use($(this).val());
  }
});
$("#input_stock_back").keypress(function (e) {
  if (e.which == 13) {
    $("#input_stock_back").val(convertString($(this).val()));
    oncheck_stock_back($(this).val());
  }
});
$("#btn_send_use").click(function (e) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การส่งข้อมูล",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_send();
    }
  });
});

function onconfirm_send(){

  $("#text_save_" + $("#input_hn_surgery").data("docno")).text("บันทึกใช้กับคนไข้แล้ว");
  $("#text_save_" + $("#input_hn_surgery").data("docno")).css("background-color", "#00a73e");

  // $("#text_use_" + $("#input_hn_surgery").data("docno")).text("แก้ไข");
  // $("#text_use_" + $("#input_hn_surgery").data("docno")).css("background-color", "#ff914d");

  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_send",
      DocNo_pay: $("#input_hn_surgery").data("docno"),
      Ref_departmentroomid: $("#input_hn_surgery").data('Ref_departmentroomid'),
      select_date_surgery: $("#select_date_surgery").val(),

      
    },
    success: function (result) {


      $("#input_deproom_surgery").val("");
      $("#input_procedure_surgery").val("");
      $("#input_hn_surgery").val("");
      $("#table_detail_item_byDocNo").DataTable().destroy();
      $("#table_detail_item_byDocNo tbody").empty();


      // var ObjData = JSON.parse(result);
      // if (!$.isEmptyObject(ObjData)) {

      //   var txt = "";
      //   $.each(ObjData, function (kay, value) {
      //     console.log(value.itemcode);
      //     txt +=  value.itemcode + ",";
      //   });

      //   var new_txt = txt.substring(0, txt.length - 1);

      //           Swal.fire({
      //               title: 'ส่งข้อมูลสำเร็จ',
      //               html: `${new_txt} <br> SUDs นี้ Re-Sterile ครบตามกำหนดแล้ว`,
      //               icon: "warning"
      //           });

      // }else{
      // }

      showDialogSuccess('ส่งข้อมูลสำเร็จ');

      show_detail_item_surgery();

    },
  });
}

function oncheck_stock_back(input_stock_back) {
  if ($("#input_hn_surgery").data("docno") == "") {
    showDialogFailed("กรุณาเลือกห้องผ่าตัด");
    $("#input_use").val("");
    return;
  }

  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_stock_back",
      input_stock_back: input_stock_back,
      DocNo_pay: $("#input_hn_surgery").data("docno"),
      Ref_departmentroomid: $("#input_hn_surgery").data('Ref_departmentroomid'),
      select_date_surgery: $("#select_date_surgery").val(),

      
    },
    success: function (result) {
      if (result == 0) {
        showDialogFailed("ไม่พบข้อมูล");
      } else if (result == 1) {
        $("#tr_detail_"+input_stock_back).css('background-color',"#FEE4E2");
        $("#icon_"+input_stock_back).attr('hidden',true);

      }
      $("#input_stock_back").val("");
    },
  });
}

function oncheck_use(input_use) {
  if ($("#input_hn_surgery").data("docno") == undefined) {
    showDialogFailed("กรุณาเลือกคนไข้ที่ต้องการสแกนใช้งานอุปกรณ์");
    $("#input_use").val("");
    return;
  }


  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "oncheck_use",
      input_use: input_use,
      DocNo_pay: $("#input_hn_surgery").data("docno"),
      Ref_departmentroomid: $("#input_hn_surgery").data('Ref_departmentroomid'),

      
    },
    success: function (result) {
      if (result == 0) {
        showDialogFailed("ไม่พบข้อมูล");
      } else if (result == 1) {
        $("#tr_detail_"+input_use).css('background-color',"#D1FADF");
        $("#icon_"+input_use).attr('hidden',false);


      } else if (result == 2) {
        show_detail_item_ByDocNo($("#input_hn_surgery").data("docno"));
      } else if (result == 3) {
        showDialogFailed("ครบรอบรายการ SUDs");
      }else{
        if(result != ""){
          Swal.fire({
            title:  'ล้มเหลว',
            html: `อุปกรณ์หมดอายุไม่สามารถสแกนจ่ายได้ <br> ${result}`,
            icon: "warning",
          });
        }
      } 

      $("#input_use").val("");
    },
  });
}

function show_detail_item_surgery() {
  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_surgery",
      select_date_surgery: $("#select_date_surgery").val(),
    },
    success: function (result) {
      var _table = "";
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["departmentroomname"], function (kay, value) {
          if (value.IsStatus == "2") {
            var text_save = "รอบันทึกใช้กับคนไข้";
            var text_use = `<i class="fa-solid fa-check"></i> ใช้งาน`;
            var style_save = 'style="background-color:#5271ff;font-weight:bold;color:white;" ';
            var style_use = 'btn btn-primary';
            var status_check = "2";
          }  if (value.IsStatus == "3") {
            var text_save = "บันทึกใช้กับคนไข้แล้ว";
            var text_use = `<i class="fa-regular fa-pen-to-square"></i> แก้ไข`;
            var style_save = 'style="background-color:#00a73e;font-weight:bold;color:white;" ';
            var style_use = 'btn btn-outline-secondary ';
            var status_check = "2";
          } else {
            var text_save = "ยังไม่ได้บันทึกใช้กับคนไข้";
            var text_use = `<i class="fa-solid fa-check"></i> ใช้งาน`;

            var style_save = 'style="background-color:#ed1c24;font-weight:bold;color:white;" ';
            var style_use = 'btn btn-primary ';

            var status_check = "1";
          }
          _table += `                        <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body clear_card" id='card_${value.DocNo}'>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                  <div class="col-md-1">
                                                                        <i class="fa-solid fa-chevron-up" style="font-size:20px;cursor:pointer;color:black;" id='open_${value.DocNo}' value='0' onclick='open_item_sub("${value.DocNo}")'></i>
                                                                  </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group ">
                                                                            <label for="" class=" col-form-label f18" style="color:black;font-weight:600;">เวลา</label>
                                                                             <input type="text" class="form-control-plaintext f18" id="" placeholder="" disabled style="border-radius: 0px;"  value="${value.CreateTime}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7 text-right">
                                                                        <button class="f20 btn" id='text_save_${value.DocNo}'  ${style_save}>${text_save}</button>
                                                                        <button class="${style_use}  f20"  id='text_use_${value.DocNo}' onclick='use_docNo("${value.DocNo}",${status_check},"${value.Doctor_Name}","${value.hn_record_id}","${value.Procedure_TH}","${value.Ref_departmentroomid}","${value.IsStatus}")' >${text_use}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                  <div class="col-md-1">
                                                                  </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group ">
                                                                            <label for="" class="col-form-label f18" style="color:black;font-weight:600;">แพทย์</label>
                                                                            <input type="text" class="form-control-plaintext f18" id="" placeholder="" disabled style="border-radius: 0px;" value="${value.Doctor_Name}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group ">
                                                                            <label for="" class="col-form-label f18" style="color:black;font-weight:600;">HN Code</label>
                                                                            <input type="text" class="form-control-plaintext f18" id="" placeholder="" disabled style="border-radius: 0px;" value="${value.hn_record_id}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group ">
                                                                            <label for="" class="col-form-label f18" style="color:black;font-weight:600;">หัตถการ</label>
                                                                            <input type="text" class="form-control-plaintext f18" id="" placeholder="" disabled style="border-radius: 0px;" value="${value.Procedure_TH}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 hideall_table" id='table_${value.DocNo}'>
                                                                <table class="table table-hover table-sm" id="table_deproom_DocNo_pay">
                                                                    <thead style="background-color: #cdd6ff;">
                                                                        <tr>
                                                                            <th scope="col" class="text-center" id="">ลำดับ</th>
                                                                            <th scope="col" class="text-center" id="">ประเภท</th>
                                                                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์ N-Sterile</th>
                                                                            <th scope="col" class="text-center" id="">รายการอุปกรณ์</th>
                                                                            <th scope="col" class="text-center" id="">จำนวน</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style='background-color: white;'> `;

          $.each(ObjData[value.DocNo], function (kay_sub, value_sub) {

            var typename = "";
            if (value_sub.TyeName == "SUDs") {
              typename = "danger";
            }
            if (value_sub.TyeName == "OR Implant") {
              typename = "primary";
            }
            if (value_sub.TyeName == "Sterile") {
              typename = "success";
            }
            

            _table += `  
                                                                            <tr>
                                                                              <td>${
                                                                                kay_sub +
                                                                                1
                                                                              }</td>
                                                                              <td class='text-center'>
                                                                                <button class="btn btn-outline-${typename} btn-sm" disabled>${value_sub.TyeName}</button>
                                                                              </td>
                                                                              <td class='text-center'>${
                                                                                value_sub.itemcode
                                                                              }</td>
                                                                              <td>${
                                                                                value_sub.itemname
                                                                              }</td>
                                                                              <td class='text-center'>${
                                                                                value_sub.cnt
                                                                              }</td>
                                                                            </tr> `;
          });
          _table += `    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> `;
        });
      }

      $("#row_table").html(_table);
      $(".hideall_table").hide();
    },
  });
}

function use_docNo(DocNo, status_check,Doctor_Name,hn_record_id,Procedure_TH,Ref_departmentroomid,IsStatus) {

  if(IsStatus != "3"){
    if (status_check == "1") {
      $("#text_save_" + DocNo).text("รอบันทึกใช้กับคนไข้");
      $("#text_save_" + DocNo).css("background-color", "#5271ff");
  
      $("#text_use_" + DocNo).html(`<i class="fa-solid fa-check"></i> ใช้งาน`);
      $("#text_use_" + DocNo).css("background-color", "#4e73df");
  
      status_check = "2";
    } else if (status_check == "2") {
      $("#text_save_" + DocNo).text("รอบันทึกใช้กับคนไข้");
      $("#text_save_" + DocNo).css("background-color", "#5271ff");
  
      $("#text_use_" + DocNo).html(`<i class="fa-solid fa-check"></i> ใช้งาน`);
      $("#text_use_" + DocNo).css("background-color", "#4e73df");
  
      status_check = "2";
    }
  }


  $(".clear_card").css("background-color", "");
  $("#card_"+DocNo).css("background-color", "#EFF8FF");

  $("#input_deproom_surgery").val(Doctor_Name);
  $("#input_procedure_surgery").val(Procedure_TH);
  $("#input_hn_surgery").val(hn_record_id);

  $("#input_hn_surgery").data('docno',DocNo);
  $("#input_hn_surgery").data('Ref_departmentroomid',Ref_departmentroomid);

  if(IsStatus != "3"){
    $.ajax({
      url: "process/surgery.php",
      type: "POST",
      data: {
        FUNC_NAME: "updateStatus_DocNo",
        DocNo: DocNo,
        status_check: status_check,
      },
      success: function (result) {
        show_detail_item_ByDocNo(DocNo);
      },
    });
  }else{
    show_detail_item_ByDocNo(DocNo);
  }

}

function open_item_sub(DocNo) {
  if ($("#open_" + DocNo).val() == 1) {
    $("#open_" + DocNo).val(0);
    $("#open_" + DocNo).animate({ rotate: "0deg", scale: "1.25" }, 500);

    $("#table_" + DocNo).hide(300);

    // $(".tr_"+id).attr('hidden',true);
  } else {
    $("#open_" + DocNo).val(1);
    $("#open_" + DocNo).animate({ rotate: "180deg", scale: "1.25" }, 500);

    $("#table_" + DocNo).show(500);

    // $(".tr_"+id).attr('hidden',false);
  }
}

function show_detail_item_ByDocNo(DocNo) {
  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_ByDocNo",
      DocNo: DocNo,
    },
    success: function (result) {
      var _tr = "";
      $("#table_detail_item_byDocNo tbody").html("");
      // $("#table_detail_item_byDocNo").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

          var iconD = "";
          if(value.IsStatus == '1'){
            var style = 'style="background-color:#FEE4E2"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }else if(value.IsStatus =='2'){
            var style = 'style="background-color:#D1FADF"';
            var iconD = `<i id='icon_${value.UsageCode}'  style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>  `;
          }else if(value.IsStatus == '3'){
            var style = 'style="background-color:#FEE4E2"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }else if(value.IsStatus =='4'){
            var style = 'style="background-color:#D1FADF"';
            var iconD = `<i id='icon_${value.UsageCode}'  style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>  `;
          }else if(value.IsStatus =='7'){
            var style = 'style="background-color:#D1FADF"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }else if(value.IsStatus =='10'){
            var style = 'style="background-color:#D1FADF"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }else if(value.IsStatus =='6'){
            var style = 'style="background-color:#D1FADF"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }else if(value.IsStatus =='5'){
            var style = 'style="background-color:#FEE4E2"';
            var iconD = `<i id='icon_${value.UsageCode}' hidden style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='open_modalDamage("${value.itemcode}","${value.UsageCode}")'></i>`;
          }

          var styleT = 'style= "" ';
          if(value.IsDamage == '1'){
                style = "";
            var styleT = 'style="color:#FF0033"';
            var iconD = `<i id='icon_${value.UsageCode}'  style='color:red;cursor:pointer;' class="fa-solid fa-triangle-exclamation" onclick='cancelDamage("${value.itemname}","${value.itemcode}","${value.UsageCode}")'></i>  `;
          }
          if( value.IsDamage == '2'){
                style = "";
            var styleT = 'style="color:#FF0033"';
            var iconD = "";
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

          _tr += `<tr ${style} id='tr_detail_${value.UsageCode}'>
                      <td  class="text-center" ${styleT}>${kay + 1 }</td> 
                      <td  ${styleT}>${value.UsageCode}</td>
                      <td >
                                    <div class="d-flex align-items-center">
                                    <span class="mr-2" ${styleT}>${value.itemname}</span>
                                    <button class="btn btn-outline-${typename} btn-sm" disabled>${value.TyeName}</button>
                                  </div>
                      </td>
                      <td   class="text-center" ${styleT}>1</td>
                      <td class="text-center" hidden></td>
                   </tr>`;
        });
      }

      $("#table_detail_item_byDocNo tbody").html(_tr);
      // $("#table_detail_item_byDocNo").DataTable({
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
      //       width: "10%",
      //       targets: 0,
      //     },
      //     {
      //       width: "30%",
      //       targets: 1,
      //     },
      //     {
      //       width: "30%",
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

function cancelDamage(itemname, itemcode, UsageCode){
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การยกเลิกแจ้งชำรุด",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "process/surgery.php",
        type: "POST",
        data: {
          FUNC_NAME: "cancelDamage",
          DocNo: $("#input_hn_surgery").data("docno"),
          itemcode: itemcode,
          UsageCode: UsageCode,
        },
        success: function (result) {
          show_detail_item_ByDocNo($("#input_hn_surgery").data("docno"));
        },
      });
    }
  });
}

function open_modalDamage(itemcode,UsageCode) {
  var currentdate = new Date();
  var datetime =
    currentdate.getDate() +
    "/" +
    (currentdate.getMonth() + 1) +
    "/" +
    currentdate.getFullYear() +
    " " +
    currentdate.getHours() +
    ":" +
    currentdate.getMinutes() +
    ":" +
    currentdate.getSeconds();

  $("#input_date_damage").val(datetime);
  $("#input_username_damage").val(UserName);

  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "searchItemName",
      itemcode: itemcode,
    },
    success: function (result) {
      $("#input_itemname_damage").val(result);
    },
  });


  $("#input_itemcode_damage").val(itemcode);
  $("#input_itemcode_damage").data('usagecode',UsageCode);
  $("#reportIssueModal").modal("toggle");
  $("#remark_damage").val("");
  $("#image_damage").val(null);



    $('#image_damage').on('change', function () {
      const file = this.files[0]; // Get the selected file
      if (file) {
        const reader = new FileReader(); // Create a FileReader instance
        reader.onload = function (event) {
          const base64String = event.target.result; // Get the Base64 string
          $('#image64_damage').val(base64String); // Display the Base64 string
          console.log(base64String); // Log to the console
        };
        reader.readAsDataURL(file); // Read the file as a data URL
      } else {
        $('#outputBase64').text('No file selected.');
      }
    });


}

$("#btn_save_damage").click(function (e) {
  Swal.fire({
    title: "ยืนยัน",
    text: "ยืนยัน การแจ้งชำรุด",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ยืนยัน",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      onconfirm_damage();
    }
  });
});

function onconfirm_damage() {

  $.ajax({
    url: "process/surgery.php",
    type: "POST",
    data: {
      FUNC_NAME: "onconfirm_damage",
      DocNo: $("#input_hn_surgery").data("docno"),
      UsageCode: $("#input_itemcode_damage").data("usagecode"),
      input_itemcode_damage: $("#input_itemcode_damage").val(),
      remark_damage: $("#remark_damage").val(),
      image64_damage: $("#image64_damage").val(),
    },
    success: function (result) {

      show_detail_item_ByDocNo($("#input_hn_surgery").data("docno"));

      $("#reportIssueModal").modal("toggle");


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
      FUNC_NAME: "checkNSterileClaim",
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
                $.each(ObjData, function (kay, value) {
                });
              }

              if (RefDepID == "36DEN") {
                setTimeout(() => {
                  feeddataClaim();
                }, 500);
              } else {
                setTimeout(() => {
                  feeddataClaim();
                }, 200);
              }
            },
          });
        }
      });
    },
  });
}
// $('#btn_send').on("click", function(e) {

//   e.preventDefault();
//   var link = this.href;
//   $.get(link, function(res) {

//       $(".nav-item").removeClass("active");
//       $(".nav-item").css("background-color", "");

//       $("#conMain").html(res);
//       history.pushState({}, "Results for `Cats`", 'index.php?s=send-n-sterile');
//       document.title = "send-n-sterile";

      
//       loadScript('script-function/send-n-sterile.js');
//   });
// })

function feeddataClaim() {



  $.ajax({
    url: "process/pay.php",
    type: "POST",
    data: {
      FUNC_NAME: "feeddataClaim",
    },
    success: function (result) {
    $("#table_item_claim tbody").html("");
      // $("#table_item_claim").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        var _tr = ``;
        var allpage = 0;
        $.each(ObjData, function (kay, value) {
          _tr +=
            `<tr> ` +
            `<td class="text-center"><label >${kay + 1}</label></td>` +
            `<td class="text-center"><label >${value.UsageCode}</label></td>` +
            `<td class="text-left"><label >${value.itemname}</label></td>` +
            `<td class="text-center"><input type='text' class='form-control' placeholder='หมายเหตุ'></td>` +
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
        //       width: "10%",
        //       targets: 0,
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
      }
    },
  });
}
// ====================================

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
      
      if(departmentroomname != "คลังห้องผ่าตัด"){
        $("#lang_text_roomcheck").text("ห้องผ่าตัด");
      }
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
    if (S_Input.charCodeAt(0) > 1000 || S_Input.charCodeAt(0) == 63 ) {
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
  const script = document.createElement('script');
  script.src = url;
  script.type = 'text/javascript';
  script.onload = function() {
      // console.log('Script loaded and ready');
  };
  document.head.appendChild(script);
}
