var departmentroomname = "";
var UserName = "";
$(function () {
  session();

  $("#select_date1").val(set_date());
  $("#select_date1").datepicker({
    onSelect: function (date) {
      selection_item();
    },
  });

  $("#select_date1_rfid").val(set_date());
  $("#select_date1_rfid").datepicker({
    onSelect: function (date) {
      selection_item_rfid();
    },
  });

  $("#select_date1_normal").val(set_date());
  $("#select_date1_normal").datepicker({
    onSelect: function (date) {
      selection_item_normal();
    },
  });
  // $("#select_date2").val(set_date());
  // $("#select_date2").datepicker({
  //   onSelect: function (date) {
  //     selection_item();
  //   },
  // });
  $("#input_search").keyup(function () {
    selection_item();
  });


  $("#input_search_rfid").keyup(function () {
    selection_item_rfid();
  });

  $("#input_search_normal").keyup(function () {
    selection_item_normal();
  });


  $("#suds").hide();
  $("#sterile").hide();
  $("#normal").hide();

  
  
  $("#radio_suds").css("color", "#bbbbb");
  $("#radio_suds").css(
    "background",
    "#EAECF0"
  );

  // selection_itemSuds();

  selection_departmentRoom_rfid();

  setTimeout(() => {
    selection_item_rfid();
  }, 1000);

  $("#radio_suds").click(function () {
    $("#radio_suds").css("color", "#bbbbb");
    $("#radio_suds").css(
      "background",
      "#EAECF0"
    );

    $("#radio_sterile").css("color", "black");
    $("#radio_sterile").css("background", "");

    $("#radio_normal").css("color", "black");
    $("#radio_normal").css("background", "");

    $("#sterile1").show();
    $("#sterile").hide();
    $("#normal").hide();

  });

  $("#radio_sterile").click(function () {
    $("#radio_sterile").css("color", "#bbbbb");
    $("#radio_sterile").css(
      "background",
      "#EAECF0"
    );

    $("#radio_suds").css("color", "black");
    $("#radio_suds").css("background", "");
    $("#radio_normal").css("color", "black");
    $("#radio_normal").css("background", "");

    $("#sterile1").hide();
    $("#sterile").show();
    $("#normal").hide();

    selection_departmentRoom();

    setTimeout(() => {
      selection_item();
    }, 1000);
  });

  $("#input_search_suds").keyup(function () {
    selection_itemSuds();
  });

  $("#radio_normal").click(function () {
    $("#radio_normal").css("color", "#bbbbb");
    $("#radio_normal").css(
      "background",
      "#EAECF0"
    );

    $("#radio_suds").css("color", "black");
    $("#radio_suds").css("background", "");
    $("#radio_sterile").css("color", "black");
    $("#radio_sterile").css("background", "");

    $("#sterile1").hide();
    $("#sterile").hide();
    $("#normal").show();

    selection_departmentRoom_normal();

    setTimeout(() => {
      selection_item_normal();
    }, 1000);
  });
});

function selection_itemSuds() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_itemSuds",
      input_search_suds: $("#input_search_suds").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $("#table_item_suds1 tbody").html("");
      $("#table_item_suds1").DataTable().destroy();

      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          tr += `<tr>
                                <td class='text-center'>${value.itemcode}</td>
                                <td style="text-wrap: nowrap;">${value.itemname}</td>
                                <td class='text-center' style="text-wrap: nowrap;">${value.Qty}</td>
                                <td class='text-center' style="text-wrap: nowrap;"> <span style='color:#004aad;cursor:pointer;'onclick='showDetail_itemSuds("${value.itemcode}","${value.itemname}")'>เลือก</span></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds1 tbody").html(tr);
      $("#table_item_suds1").DataTable({
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
            width: "20%",
            targets: 1,
          },
          {
            width: "20%",
            targets: 2,
          },
          {
            width: "20%",
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

function showDetail_itemSuds(itemcode,itemname) {

  $("#itemCodeSUDs").text(itemcode);
  $("#itemNameSUDs").text(itemname);

  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetail_itemSuds",
      itemcode: itemcode,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $("#table_item_suds2 tbody").html("");
      $("#table_item_suds2").DataTable().destroy();
      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if(value.rack == null){
            value.rack = "";
          }
          if(value.row == null){
            value.row = "";
          }
          if(value.IsCancel == '0'){
            value.IsCancel = "อยู่ในคลัง";
          }else if(value.IsCancel == '1'){
            value.IsCancel = "In Active";
          }

          var btn = "btn btn-primary";

          if(value.location == null){
            value.location = "";
          }
          if(value.IsDeproom == '7'){
            value.departmentroomname = "Create Request";
            var btn = "btn btn-warning";
          }
          if(value.IsDamage == '1' || value.IsDamage == '2'){
            value.departmentroomname = "ชำรุด";
            var btn = "btn btn-danger";
          }
          
          tr += `<tr>
                                <td class='text-center'>${value.UsageCode}</td>
                                <td class='text-center'> <button class="${btn}">${value.departmentroomname}</button></td>
                                <td class='text-center'>${value.location}</td>
                                <td class='text-center'>${value.row}</td>
                                <td class='text-center'>${value.rack}</td>
                                <td class='text-center'> <span style='color:#004aad;cursor:pointer;'onclick='showDetailSub_itemSuds("${value.itemname}","${value.UsageCode}")'>ดูประวัติการใช้งาน</span></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds2 tbody").html(tr);
      $("#table_item_suds2").DataTable({
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
            width: "20%",
            targets: 1,
          },
          {
            width: "20%",
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
            width: "15%",
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

function showDetailSub_itemSuds(itemname,UsageCode){
  $("#item_name").text(itemname);
  $("#item_suds").text(UsageCode);

  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "showDetailSub_itemSuds",
      UsageCode: UsageCode,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      $("#table_item_suds3 tbody").html("");
      console.log(ObjData);
      var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData, function (kay, value) {
          if(value.SterileDate == null){
            value.SterileDate = "";
          }
          if(value.ExpDate == null){
            value.ExpDate = "";
          }

          tr += `<tr>
                                <td class='text-center'>${value.UniCode}</td>
                                <td class='text-center'>${value.UsedCount}</td>
                                <td class='text-center'>${value.HnCode}</td>
                                <td class='text-center'>${value.SterileDate}</td>
                                <td class='text-center'>${value.ExpDate}</td>
                                <td class='text-center'></td>
                                <td class='text-center'></td>
                                <td class='text-center'>${value.FirstName}</td>
                                <td class='text-center'></td>`;
          tr += `</tr>`;
        });
      } else {
      }

      $("#table_item_suds3 tbody").html(tr);
    },
  });
}

function selection_departmentRoom() {
  depRoom = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">รายการ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">จำนวนทั้งหมด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัด</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#D1FADF;border-bottom-color: #12B76A;" class='text-center' rowspan="2" id="">ส่ง CSSD</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEE4E2;border-bottom-color: #D92D20;" class='text-center' rowspan="2" id="">ชำรุด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">คงเหลือ</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep").html(tr2);
      } else {
      }

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;
      $("#tr_TableDephead").html(tr);
    },
  });
}

function selection_item() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item",
      select_date1: $("#select_date1").val(),
      // select_date2: $("#select_date2").val(),
      input_search: $("#input_search").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $('#table_DepRoom').DataTable().destroy();
      $("#table_DepRoom tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          var balance =
            parseInt(value.Qty) -  (parseInt(value.cnt_pay) + parseInt(value.cnt_cssd));

          tr += `<tr>f
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    kay + 1
                                  }</td>
                                  <td style="text-wrap: nowrap;">${
                                    value.itemname
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    value.Qty
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${
                                    value.cnt_pay
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color: #ECFDF3;">${
                                    balance
                                  }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom tbody").html(tr);
      // $('#table_DepRoom').DataTable({
      //     language: {
      //         emptyTable: settext("dataTables_empty"),
      //         paginate: {
      //             next: settext("table_itemStock_next"),
      //             previous: settext("table_itemStock_previous")
      //         },
      //         info: settext("dataTables_Showing") + " _START_ " + settext("dataTables_to") + " _END_ " + settext("dataTables_of") + " _TOTAL_ " + settext("dataTables_entries") + " ",
      //     },
      //     columnDefs: [{
      //         width: '10%',
      //         targets: 0
      //     }],
      //     info: true,
      //     scrollX: true,
      //     scrollCollapse: true,
      //     fixedColumns: {
      //         leftColumns: 6,
      //         rightColumns: 0
      //     },
      //     paging: false,
      //     pageLength: 300,
      //     scrollY: 500,
      //     visible: false,
      //     searching: false,
      //     lengthChange: false,
      //     fixedHeader: true,
      //     ordering: false
      // });

      // $('th').removeClass('sorting_asc');
      // if (tr == "") {
      //     $('.dataTables_info').text(settext("dataTables_Showing") + ' 0 ' + settext("dataTables_to") + ' 0 ' + settext("dataTables_of") + ' 0 ' + settext("dataTables_entries") + '');
      // }
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



function selection_departmentRoom_rfid() {
  depRoom = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom_rfid",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">รายการ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">จำนวนทั้งหมด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัด</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#D1FADF;border-bottom-color: #12B76A;" class='text-center' rowspan="2" id="">ส่ง CSSD</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEE4E2;border-bottom-color: #D92D20;" class='text-center' rowspan="2" id="">ชำรุด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">คงเหลือ</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep_rfid").html(tr2);
      } else {
      }

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;
      $("#tr_TableDephead_rfid").html(tr);
    },
  });
}



function selection_item_rfid() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item_rfid",
      select_date1: $("#select_date1_rfid").val(),
      input_search: $("#input_search_rfid").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $('#table_DepRoom').DataTable().destroy();
      $("#table_DepRoom_rfid tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          var balance =  parseInt(value.cnt) -  (parseInt(value.cnt_pay));

          tr += `<tr>f
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    kay + 1
                                  }</td>
                                  <td style="text-wrap: nowrap;">${
                                    value.itemname
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    value.cnt
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${
                                    value.cnt_pay
                                  }</td>
                                     <td class='text-center' style="text-wrap: nowrap;background-color:#ECFDF3;">${
                                    balance
                                  }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom_rfid tbody").html(tr);
      // $('#table_DepRoom').DataTable({
      //     language: {
      //         emptyTable: settext("dataTables_empty"),
      //         paginate: {
      //             next: settext("table_itemStock_next"),
      //             previous: settext("table_itemStock_previous")
      //         },
      //         info: settext("dataTables_Showing") + " _START_ " + settext("dataTables_to") + " _END_ " + settext("dataTables_of") + " _TOTAL_ " + settext("dataTables_entries") + " ",
      //     },
      //     columnDefs: [{
      //         width: '10%',
      //         targets: 0
      //     }],
      //     info: true,
      //     scrollX: true,
      //     scrollCollapse: true,
      //     fixedColumns: {
      //         leftColumns: 6,
      //         rightColumns: 0
      //     },
      //     paging: false,
      //     pageLength: 300,
      //     scrollY: 500,
      //     visible: false,
      //     searching: false,
      //     lengthChange: false,
      //     fixedHeader: true,
      //     ordering: false
      // });

      // $('th').removeClass('sorting_asc');
      // if (tr == "") {
      //     $('.dataTables_info').text(settext("dataTables_Showing") + ' 0 ' + settext("dataTables_to") + ' 0 ' + settext("dataTables_of") + ' 0 ' + settext("dataTables_entries") + '');
      // }
    },
  });
}


function selection_departmentRoom_normal() {
  depRoom = [];
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_departmentRoom_normal",
      // 'select_floor': $("#select_floor").val(),
      lang: localStorage.lang,
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      console.log(ObjData);

      if (localStorage.lang == "en") {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">No.</th>`;
      } else {
        var tr = `<th class='text-center' style="text-wrap: nowrap;width: 3%;" rowspan="2">ลำดับ</th>`;
      }

      tr += `<th class='text-center' style="text-wrap: nowrap;width: 25%;" rowspan="2" id="td_item">รายการ</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;" class='text-center' rowspan="2" id="">จำนวนทั้งหมด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEF0C7;border-bottom-color: #F79009;" class='text-center' rowspan="2" id="">จ่ายไปห้องผ่าตัด</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#D1FADF;border-bottom-color: #12B76A;" class='text-center' rowspan="2" id="">ส่ง CSSD</th>`;
      // tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#FEE4E2;border-bottom-color: #D92D20;" class='text-center' rowspan="2" id="">ชำรุด</th>`;
      tr += `<th style="text-wrap: nowrap;width: 5%;background-color:#CDF4EC;border-bottom-color: #219E83;" class='text-center' rowspan="2" id="">คงเหลือ</th>`;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["floor"], function (kay, value) {
          var colsp = 0;
          $.each(ObjData[value.ID], function (kay, value) {
            colsp++;
          });
          tr += `<th style="text-wrap: nowrap;" class='text-center' colspan="${colsp}">${value.name_floor}</th>`;
        });

        var tr2 = "";
        $.each(ObjData["floor"], function (kay, value) {
          $.each(ObjData[value.ID], function (kay2, value2) {
            tr2 += `<th style="text-wrap: nowrap;" class='text-center'>${value2.departmentroomname_sub}</th>`;

            depRoom.push(value2.id);
          });
        });
        $("#tr_TableDep_normal").html(tr2);
      } else {
      }

      tr += `<th style="text-wrap: nowrap;" class='text-center' rowspan="2" id="td_all">รวม</th>`;
      $("#tr_TableDephead_normal").html(tr);
    },
  });
}

function selection_item_normal() {
  $.ajax({
    url: "process/movement.php",
    type: "POST",
    data: {
      FUNC_NAME: "selection_item_normal",
      select_date1: $("#select_date1_normal").val(),
      input_search: $("#input_search_normal").val(),
    },
    success: function (result) {
      var ObjData = JSON.parse(result);
      // $('#table_DepRoom').DataTable().destroy();
      $("#table_DepRoom_normal tbody").html("");
      console.log(ObjData);
      var tr = ``;
      // var tr = ``;
      if (!$.isEmptyObject(ObjData)) {
        $.each(ObjData["item"], function (kay, value) {
          var balance =  parseInt(value.cnt) -  (parseInt(value.cnt_pay));

          tr += `<tr>f
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    kay + 1
                                  }</td>
                                  <td style="text-wrap: nowrap;">${
                                    value.itemname
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;">${
                                    value.cnt
                                  }</td>
                                  <td class='text-center' style="text-wrap: nowrap;background-color:#FFFAEB;">${
                                    value.cnt_pay
                                  }</td>
                                     <td class='text-center' style="text-wrap: nowrap;background-color:#ECFDF3;">${
                                    balance
                                  }</td>`;

          var sumcount = 0;
          $.each(depRoom, function (keydep, valuedep) {
            var checkcount = 0;
            $.each(ObjData["detail"], function (kay2, value2) {
              if (value2.ItemCode == value.itemcode) {
                if (valuedep == value2.departmentroomid) {
                  tr += `<td class='text-center' style="text-wrap: nowrap;background-color: gold;">${value2.Qty}</</td>`;
                  checkcount = 1;
                  sumcount += parseInt(value2.Qty);
                }
              }
            });
            if (checkcount == 0) {
              tr += `<td class='text-center' style="text-wrap: nowrap;">0</</td>`;
            }
          });

          tr += `<td class='text-center' style="text-wrap: nowrap;">${sumcount}</</td>`;

          tr += `</tr>`;
        });
      } else {
      }

      $("#table_DepRoom_normal tbody").html(tr);

    },
  });
}

