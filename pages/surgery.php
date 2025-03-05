






<div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-lg-3 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_roomcheck" style="    background-color: white;border: none;">สิทธิ์การเข้าใช้งาน : </div>
                </div>
                <input type="text" class="form-control f18" id="input_Deproom_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>
        <div class="col-lg-3 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_username" style="    background-color: white;border: none;">ชื่อผู้ใช้งาน : </div>
                </div>
                <input type="text" class="form-control f18" id="input_Name_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>
    </div>





<div class="row mt-3" hidden>
    <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_use">ห้องผ่าตัด</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_claim">เคลม</button>
        </div>
    </div>
</div>


<hr>

<div id="use_item">

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="">รายการใช้เครื่องมือกับคนไข้</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control f18" id="input_use" placeholder="สแกนใช้แล้ว" inputmode='none' style="border-right-style: none;" autocomplete="off">
                                <div class="input-group-append">
                                    <div class="input-group-text" style="cursor: pointer;background-color: white;" id="qr_use_main"><i class="fa-solid fa-qrcode"></i></div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-6 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control f18" id="input_stock_back" autocomplete="off" placeholder="สแกนคืนห้องผ่าตัด" inputmode='none' style="border-color:red;border-right-style: none;">
                                <div class="input-group-append">
                                    <div class="input-group-text" style="cursor: pointer;background-color: white;border-color:red;" id="qr_stock_back"><i class="fa-solid fa-qrcode"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="input_deproom_surgery" placeholder="" inputmode='none' style="font-size: 20px;" autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="input_procedure_surgery" placeholder="" inputmode='none' style="font-size: 20px;" autocomplete="off" disabled>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="input_hn_surgery" placeholder="" inputmode='none' style="font-size: 20px;" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <table class="table table-hover table-sm " id="table_detail_item_byDocNo">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" class="text-center" id="td_no">ลำดับ</th>
                                        <th scope="col" id="td_usage">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="td_itemname">ชื่ออุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">จำนวน</th>
                                        <th scope="col" class="text-center" id="" hidden>ชำรุด</th>
                                    </tr>
                                </thead>
                                <tbody  style="line-height: 40px;">

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_send_use" style="color:#fff;background-color:#1570EF;font-size:20px;">ส่งข้อมูล</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail2">รายการอุปกรณ์ห้องผ่าตัด</label>
                        </div>
                        <div class="col-6 text-right">
                            <input type="text" class="form-control datepicker-here" id="select_date_surgery" data-language='en' data-date-format='dd-mm-yyyy' style="font-size: 20px;">
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row" id="row_table">
                        <!-- <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">เวลา</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12 col-form-label f18" style="color:#00a73e;font-weight:bold;">บันทึกใช้กับคนไข้แล้ว</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <button class="btn f18" style="background-color: #004aad;color:#fff;">ใช้งาน</button>
                                                    <i class="fa-solid fa-caret-up" style="font-size:40px;cursor:pointer;color:black;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">แพทย์</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">HN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">หัตถการ</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">เวลา</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12 col-form-label f18" style="color:#00a73e;font-weight:bold;">บันทึกใช้กับคนไข้แล้ว</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <button class="btn f18" style="background-color: #004aad;color:#fff;">ใช้งาน</button>
                                                    <i class="fa-solid fa-caret-up" style="font-size:40px;cursor:pointer;color:black;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">แพทย์</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">HN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">หัตถการ</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">เวลา</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12 col-form-label f18" style="color:#00a73e;font-weight:bold;">บันทึกใช้กับคนไข้แล้ว</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <button class="btn f18" style="background-color: #004aad;color:#fff;">ใช้งาน</button>
                                                    <i class="fa-solid fa-caret-up" style="font-size:40px;cursor:pointer;color:black;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">แพทย์</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">HN Code</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-4 col-form-label" style="color:black;font-size: 16px;">หัตถการ</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="reportIssueModal" tabindex="-1" aria-labelledby="reportIssueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="reportIssueModalLabel" style="color:black;">แจ้งชำรุด</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" style="color:black;">ผู้แจ้ง:</label>
                                <input id="input_username_damage" type="text" class="form-control" value="นาย ABC" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" style="color:black;">วันและเวลา:</label>
                                <input id="input_date_damage" type="text" class="form-control" value="" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label" style="color:black;">ชื่ออุปกรณ์:</label>
                        <input id="input_itemname_damage" type="text" class="form-control" value="EXAMSET (DENTAL)" readonly>
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label" style="color:black;">รหัสอุปกรณ์:</label>
                        <input id="input_itemcode_damage" type="text" class="form-control" value="BMC2406130151" readonly>
                    </div>
                        </div>

                    </div>
                    <!-- User Info -->

                    <!-- Date and Time -->

                    <!-- Equipment Info -->


                    <!-- Reason -->
                    <div class="mb-3">
                        <label for="reason" class="form-label" style="color:black;">หมายเหตุ:</label>
                        <textarea class="form-control" id="remark_damage" rows="3"></textarea>
                        <!-- <input type="text" class="form-control" id="remark_damage"> -->
                    </div>
                    <!-- File Upload -->
                    <div class="mb-3">
                        <label for="uploadFile" class="form-label" style="color:black;">เพิ่มรูปภาพ:</label>
                        <input type="file" class="form-control" id="image_damage">
                        <input type="text" class="form-control" id="image64_damage" hidden>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn"  data-dismiss="modal" style="color:#fff;background-color:#ed1c24;font-size:20px;">ยกเลิก</button>
                    <button type="button" class="btn" style="color:#fff;background-color:#1570EF;font-size:20px;" id="btn_save_damage"> บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="claim">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group ">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control f18" id="input_scanclaim" autocomplete="off" placeholder="สแกนอุปกรณ์" style="border-right-style: none;">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="cursor: pointer;background-color: white;"><i class="fa-solid fa-qrcode"></i></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group ">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control f18" id="input_return_claim" placeholder="สแกนอุปกรณ์กลับ" style="border-color: red;border-right-style: none;" autocomplete="off">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="cursor: pointer;background-color: white;border-color:red;"><i class="fa-solid fa-qrcode"></i></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <table class="table table-hover table-sm" id="table_item_claim">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" style="background-color: #1570EF;color:#fff;" id="btn_send_nsterile_claim">ส่งไป N-Sterile</button>
                    <a href="pages/send-n-sterile.php" class="btn btn-primary" id="btn_send" hidden>cc</a>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>