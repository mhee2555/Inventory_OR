<div class="row">
    <div class="col-md-6">
        <h1 class="h3 mb-1  mt-4" style="font-size:30px;color:black;" id="text_send1">ส่งอุปกรณ์ N-Sterile</h1>
        <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_send2"> ส่งอุปกรณ์ N-Sterile</a> -->
        <p style="font-size:25px;color:black;" id="text_send3">สร้างเอกสาร Create Request ไปที่ระบบ N Sterile</p>
    </div>


    <div class="col-md-3 col-sm-6  mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_roomcheck">ห้องตรวจ</div>
            </div>
            <input type="text" class="form-control" id="input_Deproom_Main" disabled value="<?= $departmentroomname; ?>" style="font-size: 20px;">
        </div>
    </div>
    <div class="col-md-3 col-sm-6  mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
            </div>
            <input type="text" class="form-control" id="input_Name_Main" disabled value="<?= $UserName; ?>" style="font-size: 20px;">
        </div>
    </div>
</div>


<hr class="mt-0">


<div class="row ">
    <div class=" col-md-12 col-lg-9  ">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab1">ส่งอุปกรณ์ไป N-Sterile</button>
            <button  type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab2">ประวัติการส่งอุปกรณ์ไป N-Sterile </button>
        </div>
    </div>

</div>


<!-- <div class="row">
    <div class="col-md-9">

    </div>
    <div class="col-md-4 col-lg-3 mt-2" id="row_NameEm2">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">ห้องตรวจ</div>
            </div>
            <input type="text" class="form-control" id="input_Deproom_Main" disabled value="<?= $departmentroomname; ?>" style="font-size: 16px;font-weight: bold;">
        </div>
        <div class="input-group mt-2">
            <div class="input-group-prepend">
                <div class="input-group-text">ชื่อผู้ใช้</div>
            </div>
            <input type="text" class="form-control" id="input_Name_Main" disabled value="<?= $UserName; ?>" style="font-size: 16px;font-weight: bold;">
        </div>
    </div>
</div> -->

<div id="tab1">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-3 mt-3">
            <div class="card">
                <div class="card-header" style="font-weight: bold;color:black;">
                    Create Request
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 ">
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_1">Employee Code</label>
                            <input type="text" id="input_text_1" class="form-control" placeholder="Employee Code" style="font-size: 20px;" value="909999" disabled>
                            <br>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_2">Employee Name</label>
                            <input type="text" id="input_text_2" class="form-control" placeholder="Employee Name" style="font-size: 20px;" value="909999" disabled>
                            <br>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_3">Contact Name</label>
                            <input type="text" id="input_text_3" class="form-control" placeholder="Contact Name" style="font-size: 20px;" value="01DEN-Dental Center (BMC) xx" disabled>
                            <br>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;">Contact Type</label>
                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline  border p-2 rounded-lg w-100">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                        <label class="form-check-label" for="inlineRadio1" style="color:black;">Network</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline  border p-2 rounded-lg w-100">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" disabled>
                                        <label class="form-check-label" for="inlineRadio2" style="color:black;">Commercial</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline  border p-2 rounded-lg w-100">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                                        <label class="form-check-label" for="inlineRadio3" style="color:black;">General</label>
                                    </div>
                                </div>
                            </div>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_4">Hospital</label>
                            <input type="text" id="input_text_4" class="form-control" placeholder="Hospital" style="font-size: 20px;" value="Bangkok Hospital" disabled>
                            <br>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_5">Site Name</label>
                            <input type="text" id="input_text_5" class="form-control" placeholder="Site Name" style="font-size: 20px;" value="BMC" disabled>
                            <br>
                            <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="lang_text_6">Customer Name</label>
                            <input type="text" id="input_text_6" class="form-control" placeholder="Customer Name" style="font-size: 20px;" value="01DEN" disabled>

                            <label for="label_DocNo" class="form-label" style="font-weight: bold;color:black;"></label>



                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-9 mt-3 text">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                            <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Request No :</label>
                                    <input type="text" id="input_RQ" class="form-control" placeholder="Request No" style="font-size: 30px;" value="" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Order No :</label>
                                    <input type="text" id="input_OD" class="form-control" placeholder="Order No" style="font-size: 30px;" value="" disabled>
                                </div>
                                <div class="col-md-4">
            
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Scan Barcode</label>
                                    <input type="text" id="input_scanbarcode" class="form-control" placeholder="Scan Barcode" style="font-size: 30px;" value="">
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">ItemName - ItemCode</label>
                                    <select class="form-control select2" style="font-size: 30px;" id="input_itemname_itemcode">

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Qty</label>
                                    <input type="text" id="input_qty" class="form-control" placeholder="Qty" style="font-size: 30px;" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Request Reason</label>
                                    <select class="form-control " style="font-size: 30px;" id="select_request">
                                    <option value="Sterile">Sterile</option>
                                    <option value="Re-sterile">Re-Sterile</option>
                                    <option value="Claim">Claim</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="disabledTextInput" class="form-label" style="font-weight: bold;color:black;" id="">Remark</label>
                                    <input type="text" id="input_remark" class="form-control" placeholder="Remark" style="font-size: 30px;">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary mt-5 btn-block" style="font-size:30px;" id="btn_addArray">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail">
                            ส่งล้างอุปกรณ์ที่ใช้แล้ว
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 " id="div_detailleft1">
                                    <table class="table table-hover table-sm " id="table_detail">
                                        <thead class="table-active">
                                            <tr>
                                                <th scope="col" style="width: 20%; text-align: center;" id="td_usage">รหัสอุปกรณ์</th>
                                                <th scope="col" class="text-center" id="td_item">ชื่ออุปกรณ์</th>
                                                <th scope="col" class="text-center">sterile</th>
                                                <th scope="col" style="width: 15%;" class="text-center" id="td_qty">จำนวน</th>
                                                <th scope="col" style="width: 15%;" class="text-center" id="">remark</th>
                                                <th scope="col" style="width: 20%;" class="text-center" id="">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_sendDataTab2" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">สร้างเอกสาร Create Request</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div id="tab2" >
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                </div>
                <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_SDate" data-language="en" data-date-format="dd-mm-yyyy" autocomplete="off">
            </div>

        </div>
        <div class="col-md-3">

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                </div>
                <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_EDate" data-language="en" data-date-format="dd-mm-yyyy" autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-hover table-sm " id="tab2_table_detail">
                <thead class="table-active">
                    <tr>
                        <th scope="col" style="width: 5%;" class="text-center" id="th_docSS">Sterile Document No.</th>
                        <th scope="col" style="width: 20%; text-align: center;" id="th_docRQ">Create Request No.</th>
                        <th scope="col" style="width: 40%;" class="text-center" id="th_date">Date</th>
                        <th scope="col" style="width: 20%;" class="text-center" id="th_detail">Details</th>
                        <th scope="col" style="width: 20%;" class="text-center" id="th_edit">#</th>
                        <th scope="col" style="width: 20%;" class="text-center" id="">#</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>

</div>


<div class="modal fade" id="modaldetail_Tab2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table table-hover table-sm" id="modal_tab2_table_itemStock">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                            <th scope="col" class="text-center" id="">ชื่ออุปกรณ์</th>
                            <th scope="col" class="text-center" id="">จำนวนจ่าย</th>
                            <th scope="col" style="width: 15%;" class="text-center" id="">remark</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>