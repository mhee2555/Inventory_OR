var departmentroomname = "";
var UserName = "";
$(function () {
  session();

$("#stock_item").hide();

document.getElementById("input_LocationStock").disabled = true;
// document.getElementById("input_floor").disabled = true;
// document.getElementById("input_row").disabled = true;
Show_store();
  $("#radio_search").css("color", "#bbbbb");
  $("#radio_search").css(
    "background",
    "#EAECF0"
  );

  $("#radio_search").click(function () {
    $("#radio_search").css("color", "#bbbbb");
    $("#radio_search").css(
      "background",
      "#EAECF0"
    );

    $("#radio_stock_item").css("color", "black");
    $("#radio_stock_item").css("background", "");

    $("#search").show();
    $("#stock_item").hide();



  });

  $("#radio_stock_item").click(function () {
    $("#radio_stock_item").css("color", "#bbbbb");
    $("#radio_stock_item").css(
      "background",
      "#EAECF0"
    );

    $("#radio_search").css("color", "black");
    $("#radio_search").css("background", "");

    $("#search").hide();
    $("#stock_item").show();


    $("#select_stock_item").select2();
    $("#select_location_item").select2();
    $("#select_location_floor").select2();

    select_stock();
    setTimeout(() => {
      show_detail_item();
    }, 300);
  });

  // $("#input_search_location").keyup(function () {
  //   var rowID = $("#input_search_location").data('rowID');
  //   var storeName = $("#input_search_location").data('storeName');
  //   Show_store_detail(rowID,storeName);
  // });
  // $("#input_search_floor").keyup(function () {
  //   var rowID = $("#input_search_location").data('rowID');
  //   var storeName = $("#input_search_location").data('storeName');
  //   Show_store_detail(rowID,storeName);
  // });
  // $("#input_search_row").keyup(function () {
  //   var rowID = $("#input_search_location").data('rowID');
  //   var storeName = $("#input_search_location").data('storeName');
  //   Show_store_detail(rowID,storeName);
  // });
});


// stock

function onDeleteLocationDetail(store_locationID,rowID,location){
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onDeleteLocationDetail",
      rowID: rowID,
    },
    success: function (result) {
          Show_store_detail(store_locationID,location);
          
    },
  });
}
function onDeleteLocation(rowID,location){
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "onDeleteLocation",
      rowID: rowID,
    },
    success: function (result) {
          Show_store();
          Show_store_detail(rowID,location);
          
    },
  });
}
function Save_store() {

  var input_stock = $("#input_stock").val();
  var input_LocationStock = $("#input_LocationStock").val();
  var check_edit = $("#check_edit").val();


  if(input_stock==""){
    showDialogFailed("กรุณากรอกชื่อคลัง !!!");
    return;
  }

  if(check_edit == 0){
    $.ajax({
      url: "process/stock_item.php",
      type: "POST",
      data: {
        FUNC_NAME: "Save_store",
        input_stock: input_stock
      },
      success: function (result) {
          if(result==0){
            showDialogFailed("ชื่อรายการคลังซ้ำ !!!");
          }else{
            showDialogSuccess("เพิ่มรายการเรียบร้อย");
            Show_store();
          }
        
      },
    });
  }else if(check_edit == 1){
    $.ajax({
      url: "process/stock_item.php",
      type: "POST",
      data: {
        FUNC_NAME: "Edit_store",
        input_stock: input_stock,
        input_LocationStock: input_LocationStock,
        rowid: $("#check_edit").data('rowid'),
      },
      success: function (result) {
            showDialogSuccess("เพิ่มรายการเรียบร้อย");
            Show_store();
            $("#input_LocationStock").val("");
            $("#input_stock").val("");
            $("#input_LocationStock").attr('disabled',true);
      },
    });
  }else if(check_edit == 2){
    $.ajax({
      url: "process/stock_item.php",
      type: "POST",
      data: {
        FUNC_NAME: "Edit_store_detail",
        input_stock: input_stock,
        input_LocationStock: input_LocationStock,
        input_floor: input_floor,
        input_row: input_row,
        rowid: $("#check_edit").data('rowid'),
      },
      success: function (result) {
            showDialogSuccess("เพิ่มรายการเรียบร้อย");

            $("#input_LocationStock").val("");
            $("#input_floor").val("");
            $("#input_row").val("");
            $("#input_LocationStock").attr('disabled',true);
            $("#input_floor").attr('disabled',true);
            $("#input_row").attr('disabled',true);



            var rowID = $("#input_search_location").data('rowID');
            var storeName = $("#input_search_location").data('storeName');

            Show_store_detail(rowID,storeName);

      },
    });
  }


}
function Show_store() {

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "Show_store",
    },
    success: function (result) {
      var _tr = "";
      $("#table_store").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData['store'], function (kay, value) {

          _tr += `<tr>
                      <td class='text-center' style="width: 10%;">${(kay+1)}</td>
                      <td class='text-left' style="width: 30%;">${value.storeName}</td>
                      <td class='text-center' style="width: 10%;"> <button class="btn btn-outline-secondary f18" onclick='Edit_store(${value.rowID},"${value.storeName}")' ><i class="fa-regular fa-pen-to-square"></i> แก้ไข</button>  &nbsp; &nbsp; &nbsp;  <i class="fa-solid fa-caret-up" style='font-size:30px;cursor:pointer;' id='open_${value.rowID}' value='0' onclick='open_location(${value.rowID})'></i></td>
                   </tr>`;

            $.each(ObjData[value.rowID], function (kay2, value2) {

            var chk = `<div class='form-check form-check-inline'>
                            <input onclick='Show_store_detail(${value2.rowID},"${value2.location}")' class='form-check-input' type='radio' name='inlineRadioOptions' id='inlineRadio1' value='option_"+(kay+1)+"' style='width: 20px;height: 20px;'>                   
                        </div>`;

              _tr += `<tr class='tr_${value.rowID} all111'>
                          <td class='text-center' style="width: 10%;">${chk}</td>
                          <td class='text-left' style="width: 30%;">สถานที่เก็บ : ${value2.location}</td>
                          <td class='text-center' style="width: 10%;"><i onclick='onDeleteLocation(${value2.rowID},"${value2.location}")' class="fa-solid fa-trash" style='font-size: 25px;color: gray;margin-left: 5rem;'></i></td>
                      </tr>`;

            });

        });
      }

      $("#table_store tbody").html(_tr);
      $(".all111").hide();
      
    },
  });
}
// 
function open_location(id) {
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

    $("#trbg_" + id).css("background-color", "#bbb");

    // $(".tr_"+id).attr('hidden',false);
  }
}

function Show_store_detail(rowID,location) {


  
  $("#input_search_location").val(location);

  $("#input_search_location").data('rowID',rowID);

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "Show_store_detail",
      rowID: rowID,
    },
    success: function (result) {
      var _tr = "";
      // $("#table_store_detail").DataTable().destroy();
      $("#table_store_detail tbody").html("");
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

          _tr += `<tr>
                      <td class='text-center' >${(kay+1)}</td>
                      <td class='text-left' >${value.storeName}</td>
                      <td class='text-center' >${value.location}</td>
                      <td class='text-center' >${value.rack}</td>
                      <td class='text-center' >${value.row}</td>
                      <td class='text-center' ><i onclick='onDeleteLocationDetail(${value.store_locationID},${value.rowID},"${value.location}")' class="fa-solid fa-trash" style='font-size: 25px;color: gray;'></i></td>
                   </tr>`;
        });
      }

      $("#table_store_detail tbody").html(_tr);
      
    },
  });
}
function Edit_store_detail(rowID,storeName,location,rack,row){
  $("#input_LocationStock").attr('disabled',false);
  $("#input_floor").attr('disabled',false);
  $("#input_row").attr('disabled',false);
  $("#input_stock").val(storeName);

  $("#input_stock").val(storeName);
  $("#input_LocationStock").val(location);
  $("#input_floor").val(rack);
  $("#input_row").val(row);

  $("#check_edit").val(2);
  $("#check_edit").data('rowid',rowID);
}
function Edit_store(rowID,storeName){



  $("#input_LocationStock").attr('disabled',false);
  $("#input_stock").val(storeName);

  $("#check_edit").val(1);
  $("#check_edit").data('rowid',rowID);

  
}

function Save_store_location() {

  var input_search_location = $("#input_search_location").val();
  var input_search_floor = $("#input_search_floor").val();
  var input_search_row = $("#input_search_row").val();


  if(input_search_location==""){
    showDialogFailed("กรุณาเลือกสถานที่เก็บ !!!");
    return;
  }
  if(input_search_floor==""){
    showDialogFailed("กรุณากรอกชั้น !!!");
    return;
  }
  if(input_search_row==""){
    showDialogFailed("กรุณากรอกแถว !!!");
    return;
  }

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "Save_store_location",
      input_search_location: input_search_location,
      input_search_floor: input_search_floor,
      input_search_row: input_search_row,
      rowID: $("#input_search_location").data('rowID'),
    },
    success: function (result) {

          showDialogSuccess("เพิ่มรายการเรียบร้อย");
          $("#input_search_floor").val("");
          $("#input_search_row").val("");
          Show_store_detail($("#input_search_location").data('rowID'),$("#input_search_location").val());
      
    },
  });

}






// stock

// item
function select_stock() {
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_stock",
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option = `<option value="" selected>กรุณาเลือกคลัง</option>`;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option += `<option value="${value.rowID}" >${value.storeName}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_stock_item").html(option);
    },
  });
}


function select_rowandfloor() {
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_rowandfloor",
      select_location_item: $("#select_location_item").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option1 = `<option value="" selected>กรุณาเลือกโลเคชั่น</option>`;

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option1 += `<option value="${value.rowID}" >${value.rack}/${value.row}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_location_floor").html(option1);

    },
  });
}

function select_location() {
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "select_location",
      select_stock_item: $("#select_stock_item").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);
      var option1 = `<option value="" selected>กรุณาเลือกโลเคชั่น</option>`;

      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          option1 += `<option value="${value.rowID}" >${value.location}</option>`;
        });
      } else {
        option = `<option value="0">ไม่มีข้อมูล</option>`;
      }
      $("#select_location_item").html(option1);

    },
  });
}

$("#select_stock_item").change(function () {
  select_location();
});

$("#select_location_item").change(function () {
  select_rowandfloor();
  // show_detail_item_store();
});

$("#select_location_floor").change(function () {
  show_detail_item_store();
});

$("#select_type_item").change(function () {
  show_detail_item();
});

$("#input_search_item").on("keydown", function (e) {
  show_detail_item();
});

$("#input_search_item_store").on("keydown", function (e) {
  show_detail_item_store();
});

function show_detail_item() {
  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item",
      input_search_item: $("#input_search_item").val(),
      select_type_item: $("#select_type_item").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {


          _tr += `<tr>
                      <td class='text-center' >
                           <div class="form-check form-check-inline">
                              <input style="width: 25px;height: 25px;" class="form-check-input position-static checkbox_itemcode" value="${value.itemcode}" type="checkbox" id="checkbox_${value.itemcode}">
                            </div>
                      ${kay + 1}</td>
                      <td class='text-left'>${value.Item_name}</td>
                      <td class='text-center'>${value.itemcode}</td>
                   </tr>`;
        });
      }

      $("#table_item tbody").html(_tr);
      $("#table_item").DataTable({
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
            width: "30%",
            targets: 1,
          },
          {
            width: "30%",
            targets: 2,
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
    },
  });
}

function show_detail_item_store() {


  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "show_detail_item_store",
      select_location_floor: $("#select_location_floor").val(),
      input_search_item_store: $("#input_search_item_store").val(),
    },
    success: function (result) {
      var _tr = "";
      $("#table_item_store").DataTable().destroy();
      var ObjData = JSON.parse(result);
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {

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
                      <td class='text-center' >
                           <div class="form-check form-check-inline">
                              <input style="width: 25px;height: 25px;" class="form-check-input position-static checkbox_itemcode_delete" value="${value.ItemCode}" type="checkbox" id="checkbox_${value.ItemCode}">
                            </div>
                      ${kay + 1}</td>
                      <td class='text-left'>${value.Item_name}</td>
                      <td class='text-center'>  <button class="btn btn-outline-${typename} btn-sm" disabled>${value.TyeName}</button></td>
                      <td class='text-center'>${value.location}</td>
                      <td class='text-center'>${value.rack}</td>
                      <td class='text-center'>${value.row}</td>
                   </tr>`;
        });
      }

      $("#table_item_store tbody").html(_tr);
      $("#table_item_store").DataTable({
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
            width: "30%",
            targets: 1,
          },
          {
            width: "10%",
            targets: 2,
          },
          {
            width: "20%",
            targets: 3,
          },
          {
            width: "5%",
            targets: 4,
          },
          {
            width: "5%",
            targets: 5,
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
    },
  });
}

$("#btn_save_item").click(function () {

  if($("#select_stock_item").val() == "" || $("#select_stock_item").val() == null){
    showDialogFailed("กรุณา เลือกคลัง");
    return;
  }
  if($("#select_location_item").val() == "" || $("#select_location_item").val() == null){
    showDialogFailed("กรุณา เลือกสถานที่เก็บ");
    return;
  }
  if($("#select_location_floor").val() == "" || $("#select_location_floor").val() == null){
    showDialogFailed("กรุณา เลือกชั้น/แถว");
    return;
  }


  var itemCodeArray = [];

  $(".checkbox_itemcode:checked").each(function () {
    itemCodeArray.push($(this).val()); // Get value of the checkbox
  });

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "save_item",
      itemCodeArray: itemCodeArray,
      select_location_item: $("#select_location_item").val(),
      select_location_floor: $("#select_location_floor").val(),
    },
    success: function (result) {
      if (result == "1") {
        showDialogSuccess("บันทึก สำเร็จ");
        show_detail_item();
        show_detail_item_store();
      }else{
        showDialogFailed("มีรายการซ้ำ " + (result-1) + " ตัว ");
      }

      // $("body").loadingModal("destroy");
      // if (result == "0") {
      //   show_detail_item_save();

      //   if ($("#check_radio").val() == 1) {
      //     show_detail_deproom();
      //   } else {
      //     show_detail_item();
      //   }
      // }
    },
  });


});

$("#btn_delete_item").click(function () {


  var itemCodeArray = [];

  $(".checkbox_itemcode_delete:checked").each(function () {
    itemCodeArray.push($(this).val()); // Get value of the checkbox
  });

  if(itemCodeArray == ""){
    showDialogFailed("กรุณา เลือกรายการ");
    return;
  }

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "delete_item",
      itemCodeArray: itemCodeArray,
    },
    success: function (result) {
      showDialogSuccess("ลบ สำเร็จ");
      show_detail_item();
      show_detail_item_store();
    },
  });


});

$("#btn_switch_item").click(function () {


  var itemCodeArray = [];

  $(".checkbox_itemcode_delete:checked").each(function () {
    itemCodeArray.push($(this).val()); // Get value of the checkbox
  });

  if(itemCodeArray == ""){
    showDialogFailed("กรุณา เลือกรายการ");
    return;
  }

  $.ajax({
    url: "process/stock_item.php",
    type: "POST",
    data: {
      FUNC_NAME: "switch_item",
      itemCodeArray: itemCodeArray,
      select_location_floor: $("#select_location_floor").val(),
    },
    success: function (result) {
      showDialogSuccess("บันทึก สำเร็จ");
      show_detail_item();
      show_detail_item_store();
    },
  });


});


// $(".checkbox_itemcode:checked").each(function () {
//   itemCodeArray.push($(this).val()); // Get value of the checkbox
//   deproomArray.push($(this).data("deproom")); // Get value of the checkbox
//   qtyArray.push(
//     $("#qty_" + $(this).val() + "_" + $(this).data("deproom")).val()
//   ); // Get value of the checkbox
// });

// item




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
