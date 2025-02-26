$(function() {

    // var d = new Date();
    // var month = d.getMonth() + 1;
    // var day = d.getDate();
    // var year = d.getFullYear();
    // var output = day + '-' +
    //     (('' + month).length < 2 ? '0' : '') + month + '-' + year;
    // $("#select_Date").val(output);

    
    selection_itemDeproomDetail();
    feeddata_detail_item();
    $("#select_item").select2();

    $("#btn_searchItem").click(function() {
        feeddata_itemSeach();
    });
    

});

function feeddata_detail_item() {
    $.ajax({
        url: "process/use_deproom.php",
        type: 'POST',
        data: {
            'FUNC_NAME': 'feeddata_detail_item',
        },
        success: function(result) {
            var ObjData = JSON.parse(result);
            console.log(ObjData);

            var _tr = `<option value="">ค้นหาอุปกรณ์</option>`;
            $("#select_item").html("");

            if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData, function(kay, value) {


                    _tr += `<option value="${value.itemcode}">${value.itemname}</option>`


                });
            }
            $("#select_item").html(_tr);
        }
    });
}

function feeddata_itemSeach(){
    var txt = $("#select2-select_item-container").text();

    $("#header_item").text(txt);

    $("#modaldetail_searchitem").modal('toggle');

    showDetail_searchItem();
}


function selection_itemDeproomDetail() {
    $.ajax({
        url: "process/use_deproom.php",
        type: 'POST',
        data: {
            'FUNC_NAME': 'selection_itemDeproomDetail',
        },
        success: function(result) {
            var ObjData = JSON.parse(result);
            var detail = ``;
            var detailB = ``;
            if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData.B, function(kay, value) {

                    detailB += `   <div class="card ">
                                        <div class="card-header">
                                            <div class=" text-dark font-weight-bold">${value.name_floor}</div>
                                        </div>
                                        <div class="card-body " >
                                            <div class="row" id="row_detail"> `;

                                            $.each(ObjData[value.ID], function(kay2, value2) {
                                                detailB += ` <div class="col-sm-12 col-md-12 col-lg-2 mt-3">
                                                                <div class="card text-center">
                                                                    <div class="card-body">
                                                                        <div class="row g-0">
                                                                            <div class="col-md-12 text-left">
                                                                                <h5 class="card-title text-dark font-weight-bold" id="header_itemDeproom"> ${value2.departmentroomname} <br> ${settext('headder_label')} </h5>
                                                                                <div class="card-text"> <label style="font-size: 70px;color:#004aad;line-height: 55px;" id="text_itemDeproom">${value2.Qty}</label> <label style="font-size: 32px;color:black;" class="label_item"> คน </label> </div>
                                                                            </div>
                                                                            <div class="col-md-12 text-left">
                                                                                <a href="#" class="btn btn-primary btn-block f18" id="btn_itemDeproom" onclick='showDetail(${value2.id},"${value2.departmentroomname}")' style="background-color:#004aad;"> <label class="mb-0" id="go_itemDeproom">ดูคนไข้ในห้องผ่าตัด</label> </a>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>` ;

                                    });

                                            
                    detailB +=      ` </div>
                                    </div>
                                </div> `;


   


                });
                $("#row_B").html(detailB);



            }



        }
    });
}

function showDetail_searchItem(){
    $.ajax({
        url: "process/use_deproom.php",
        type: 'POST',
        data: {
            'FUNC_NAME': 'showDetail_searchItem',
            'select_item': $("#select_item").val(),
        },
        success: function(result) {
            var ObjData = JSON.parse(result);
            var detail = ``;
            $("#modal_table_detail_searchitem tbody").html("");
            if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData['deproom'], function(kay, value) {

                    detail += `<tr class='color2' onclick='showTr_item(${kay})' id='trmain_item_${kay}'> ` +
                        `<td class="text-center">${value.departmentroomname}</td>` +
                        `<td class="text-center">${value.c}</td>` +
                        ` </tr>`;

                        $.each(ObjData[value.id], function(kayD1, valueD1) {

   

                            detail += `<tr class='trDetail_item_${kay}' hidden> ` +
                            `<td class="text-right">HN : ${valueD1.hn_record_id}</td>` +
                            `<td class="text-center"></td>` +
                            ` </tr>`

                        });


   


                });
                $("#modal_table_detail_searchitem tbody").html(detail);



            }



        }
    });
}

function showTr_item(key){
    // $(".trDetail_" + id).attr('hidden', false);

    $(".color2").css("background-color", "");
    $("#trmain_item_" + key).css("background-color", "#f8aeae");

    

    if($(".trDetail_item_" + key).is(':hidden')){
        $(".trDetail_item_" + key).attr('hidden', false);
    }else{
        $(".trDetail_item_" + key).attr('hidden', true);
    }

}

function showDetail(id,departmentroomname){
    $("#modaldetail").modal('toggle');
    $("#deproomshow").text(departmentroomname);
    
    $.ajax({
        url: "process/use_deproom.php",
        type: 'POST',
        data: {
            'FUNC_NAME': 'showDetail',
            'deproom_id': id,
        },
        success: function(result) {
            var ObjData = JSON.parse(result);
            var detail = ``;
            var _table = "";
            $("#row_table").html("");
            if (!$.isEmptyObject(ObjData)) {
                $.each(ObjData["departmentroomname"], function (kay, value) {
                    if (value.IsStatus == "2") {
                      var text_save = "รอบันทึกใช้กับคนไข้";
                      var text_use = "ใช้งาน";
                      var style_save = 'style="color:#5271ff;font-weight:bold;" ';
                      var style_use = 'style="background-color: #004aad;color:#fff;" ';
                      var status_check = "2";
                    }  if (value.IsStatus == "3") {
                      var text_save = "บันทึกใช้กับคนไข้แล้ว";
                      var text_use = "แก้ไข";
                      var style_save = 'style="color:#00a73e;font-weight:bold;" ';
                      var style_use = 'style="background-color: #ff914d;color:#fff;" ';
                      var status_check = "2";
                    } else {
                      var text_save = "ยังไม่ได้บันทึกใช้กับคนไข้";
                      var text_use = "ใช้งาน";
          
                      var style_save = 'style="color:#ed1c24;font-weight:bold;" ';
                      var style_use = 'style="background-color: #004aad;color:#fff;" ';
          
                      var status_check = "1";
                    }
          
                    _table += `                        <div class="col-md-12">
                                                          <div class="card">
                                                              <div class="card-body clear_card" id='card_${value.DocNo}'>
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                                  <div class="col-md-12">
                                                                                        <div class="row">
                                                                                            <div class="col-md-2">
                                                                                                <div class="form-group ">
                                                                                                    <label style="color:black;font-size: 16px;">HN : </label>
                                                                                                        <input type="text" class="form-control" id="" placeholder="" value="${value.hn_record_id}" disabled style="border-radius: 0px;">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <div class="form-group ">
                                                                                                    <label  style="color:black;font-size: 16px;">เวลา :</label>
                                                                                                        <input type="text" class="form-control" id="" placeholder="" value="${value.CreateDate} ${value.CreateTime}" disabled style="border-radius: 0px;">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <div class="form-group ">
                                                                                                    <label  style="color:black;font-size: 16px;">หัตถการ :</label>
                                                                                                        <input type="text" class="form-control" id="" placeholder="" value="${value.Procedure_TH}" disabled style="border-radius: 0px;">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <div class="form-group ">
                                                                                                    <label style="color:black;font-size: 16px;">แพทย์ :</label>
                                                                                                        <input type="text" class="form-control" id="" placeholder="" value="${value.Doctor_Name}" disabled style="border-radius: 0px;">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3 text-right">
                                                                                                <div class="form-group row">
                                                                                                    <label for="" class="col-sm-12 col-form-label f18" ${style_save}>${text_save}</label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1 text-right">
                                                                                                <i class="fa-solid fa-caret-up" style="font-size:40px;cursor:pointer;color:black;" id='open_${value.DocNo}' value='0' onclick='open_item_sub("${value.DocNo}")'></i>
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
                                                                              <tbody> `;
          
                    $.each(ObjData[value.DocNo], function (kay_sub, value_sub) {
                      _table += `  
                                                                                      <tr>
                                                                                        <td>${
                                                                                          kay_sub +
                                                                                          1
                                                                                        }</td>
                                                                                        <td class='text-center'>${
                                                                                          value_sub.TyeName
                                                                                        }</td>
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

                $("#row_table").html(_table);
                $(".hideall_table").hide();

            }



        }
    });
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

function showTr(key){
    // $(".trDetail_" + id).attr('hidden', false);

    $(".color").css("background-color", "");
    $("#trmain_" + key).css("background-color", "#f8aeae");

    

    if($(".trDetail_" + key).is(':hidden')){
        $(".trDetail_" + key).attr('hidden', false);
    }else{
        $(".trDetail_" + key).attr('hidden', true);
    }

}