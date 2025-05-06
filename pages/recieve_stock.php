<div hidden>






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





    <div class="row mt-2">
        <div class=" col-md-12 col-lg-9  ">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_receive">รับอุปกรณ์เข้าคลัง</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_paysterile">สรุปค่าใช้จ่ายในการ Sterile</button>
            </div>
        </div>
    </div>
</div>

<hr>


<div hidden>

<div id="receive">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">วันที่</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date_receive" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-6">
                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">คลัง</label>
                        <select class="form-control select2 f18" id="select_departmentRoom">
                            <option value="35">คลังห้องผ่าตัด</option>
                        </select>
                        <input type="text" id="input_DocNo" hidden>
                    </div>
                </div>
                <div class="col-md-12 mt-3">

                    <div class="card">
                        <div class="card-header">
                            <span style="color:black;" class="f24 font-weight-bold">รับอุปกรณ์เข้าคลัง</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_receive_stock">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">เลขเอกสาร</th>
                                        <th scope="col" class="text-center" id=""></th>
                                        <th scope="col" class="text-center" id="">สถานะ</th>
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
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">สแกนเพื่อรับเข้าคลัง</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here" id="input_scan_back" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-solid fa-qrcode"></i></div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-sm" id="table_receive_stock_item">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" id="" style="width: 10%;;">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รายการ</th>
                                <th scope="col" class="text-center" id="" style="background-color: #D1FADF;border-bottom-color: #039855;width:15%;">ส่ง CSSD</th>
                                <th scope="col" class="text-center" id="" style="background-color: #FEF0C7;border-bottom-color: #F79009;width:15%;">รับเข้าคลัง</th>
                                <th scope="col" class="text-center" id="" style="background-color: #F2F4F7;border-bottom-color: #667085;width:10%;">คงเหลือ</th>
                                <th scope="col" class="text-center" id="" style="width: 10%;;">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12" style="text-align: end;">
                            <button class="btn" id="btn_sendData" style="color:#fff;background-color:#643695;font-size:20px;">รับเข้าคลัง</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


<div id="paysterile">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">


                    <div class="form-group">
                        <label style="color:black;font-weight: 600;">วันที่</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date_pay" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-md-4">


                    <div class="form-group">
                        <label style="color:black;font-weight: 600;">วันที่</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_Edate_pay" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label style="color:black;font-weight: 600;">คลัง</label>
                        <select class="form-control select2 f18" id="select_deproom_pay">
                            <option value="35">คลังห้องผ่าตัด</option>
                        </select>
                    </div>



                </div>
                <div class="col-md-12 mt-3">

                    <div class="card">
                        <div class="card-header">
                            <span style="color:black;" class="f24 font-weight-bold">เอกสารส่ง Sterile อุปกรณ์</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_document_sterile">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">เลขเอกสาร</th>
                                        <th scope="col" class="text-center" id="">สถานะ</th>
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
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 text-right">

                <div class="form-group">
                        <button class="btn" style='background-color:#643695;color:#fff;'>พิมพ์รายงานค่าใช้จ่าย</button>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <table class="table table-hover table-sm" id="table_document_sterile_item">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รายการ</th>
                                <th scope="col" class="text-center" id="">ราคา</th>
                                <th scope="col" class="text-center" id="">รับเข้าคลัง</th>
                                <th scope="col" class="text-center" id="">รวม</th>
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
                <button type="button" class="btn " style="color:#fff;background-color:#ed1c24;font-size:20px;" data-dismiss="modal" id="btn_cancel">ยกเลิก</button>
                <button type="button" class="btn" style="color:#fff;background-color:#004aad;font-size:20px;" id="btn_save">บันทึก</button>
            </div>
        </div>
    </div>
</div>


</div>