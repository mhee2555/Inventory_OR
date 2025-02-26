<div>

    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-1  mt-4" style="font-size:30px;color:black;" id="text_return1">รับอุปกรณ์เข้าคลัง</h1>
            <!-- <label for="" id="label_mainpage">หน้าหลัก  </label> > <a href="#" style="font-size:25px;" id="text_return2"> รับอุปกรณ์เข้าคลัง</a> -->
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_roomcheck">ห้องตรวจ</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="<?= $departmentroomname; ?>" style="font-size: 20px;">
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="<?= $UserName; ?>" style="font-size: 20px;">
            </div>
        </div>
    </div>
</div>

<hr>


<div class="row">
    <div class="col-md-6">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radiomenu_tab1">รับอุปกรณ์เข้าคลัง</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radiomenu_tab2">สรุปค่าใช้จ่ายในการ Sterile</button>
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
<div class="row" id="tab1">

    <div class="col-md-3">
        <label for="" id="lang_text_date">วันที่</label>

        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
            </div>
            <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_Date" data-language='en' data-date-format='dd-mm-yyyy'>
            <input type="text" id="input_type_receive" hidden>
            <input type="text" id="input_DocNo" hidden>
        </div>

    </div>
    <div class="col-md-3">
        <label for="" id="lang_text_stock">คลัง</label>
        <select class="form-control " id="select_departmentRoom" style="font-size:20px;">

        </select>
    </div>
    <div class="col-md-6">
        <label for="">&nbsp;</label>
        <div class="input-group mb-2">
            <input style="font-size: 20px;" type="text" class="form-control" id="input_scan_back" placeholder="สแกนรับของ">
            <div class="input-group-prepend">
                <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
            </div>
        </div>
    </div>

    <div class="col-md-6"></div>
    <div class="col-md-6">
        <button class="btn btn-block btn-primary" style="font-size: 25px;" id="btn_scanrfid"> RFID </button>
    </div>


    <div class="col-md-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail">
                เอกสารรับอุปกรณ์เข้าคลัง
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 ">
                        <table class="table table-sm " id="table_detail">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" style="width: 5%; text-align: center;" id="td_no">No.</th>
                                    <th scope="col" class="text-center" id="td_docRe">เอกสารรับเข้าคลัง</th>
                                    <th scope="col" class="text-center" id="td_dep">แผนก</th>
                                    <th scope="col" class="text-center" id="td_date">สถานะ</th>
                                    <th scope="col" class="text-center" id="td_total">ทั้งหมด</th>
                                    <!-- <th scope="col" class="text-center" id="td_docref">เอกสารอ้างอิง</th> -->
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


    <div class="col-md-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail2">
                อุปกรณ์ที่รับเข้า
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 " id="div_detailleft1">
                        <table class="table table-hover table-sm " id="table_detail_sub">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 20%;" id="td_checkbox">
                                        <input type="checkbox" class="form-check-input" id="checkall" style="margin-top: -25px;width: 25px;height: 20px;">
                                    </th>
                                    <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_qty">จำนวน</th>
                                    <th scope="col" style="width: 10%;" class="text-center" id="td_re">รับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_pen">ค้างรับ</th>
                                    <th scope="col" style="width: 10%;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn" disabled style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);" id="btn_sendData">รับเข้าคลัง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="tab2">

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label for="" id="lang_text_date1">วันที่</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                        <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_Date1tab2" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>

                </div>
                <div class="col-md-6">
                    <label for="" id="lang_text_date2">วันที่</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                        <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_Date2tab2" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>

                </div>
                <div class="col-md-6">
                    <label for="" id="lang_text_stock1">คลัง</label>
                    <select class="form-control " id="select_departmentRoomtab2" style="font-size:20px;">
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-lg-6 mt-3">
            <div class="card">
                <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail_tab2">
                    เอกสารรับอุปกรณ์เข้าคลัง
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 ">
                            <table class="table table-sm " id="table_detail_tab2">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 5%; text-align: center;" id="td_no2">No.</th>
                                        <th scope="col" class="text-center" id="td_docRe2">เอกสารรับเข้าคลัง</th>
                                        <th scope="col" class="text-center" id="td_return2">จำนวน Return</th>
                                        <th scope="col" class="text-center" id="td_select2">เลือก</th>
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

        <div class="col-md-12 col-lg-6 mt-3">
            <div class="card">
                <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail_tab2_2">
                    <div class="row">
                        <div class="col-md-6">
                        อุปกรณ์ที่รับเข้า
                        </div>
                        <div class="col-md-6 text-right">
                        <button class="btn" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);" id="btn_showReportTab2">พิมพ์รายงาน</button>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-sm " id="table_detail_sub_tab2">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" class="text-center" id="td_item2">อุปกรณ์</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_qtyRe2">จำนวนที่รับเข้า</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_qtyUnit2">ราคาต่อหน่วย</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_qtyTotal2">ราคารวม</th>
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
    </div>



</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รับเข้าอุปกรณ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- style="border: 2px solid;height: 310px;width: 530px;" -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-md-12">
                        <div id="signature-pad" class="m-signature-pad">
                            <div class="m-signature-pad--body">
                                <canvas style="border: 2px solid;" id="signature" height=150 width="460"></canvas>
                            </div>
                        </div>


                        <!-- <div class="wrapper">
                            <canvas id="signature-pad" class="signature-pad"></canvas>
                            <button id="clear">Clear</button>
                        </div> -->
                    </div>

                    <div class="col-md-12 col-lg-12 col-md-12 mt-3 text-right">
                        <button id="clear" class="btn btn-secondary">Clear</button>
                    </div>

                    <div class="col-md-12 col-lg-12 col-md-12 mt-3">
                        <input type="file" class="dropify" data-height="200" id="img1" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_cancel">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="btn_save">บันทึก</button>
            </div>
        </div>
    </div>
</div>