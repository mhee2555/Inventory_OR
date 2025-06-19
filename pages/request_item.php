<div>




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


</div>

<hr>



<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_request">ขอเบิกอุปกรณ์</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_receive">รับอุปกรณ์เข้าคลัง</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_history">ประวัติอุปกรณ์</button>
        </div>
    </div>
</div>

<div id="row_request">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
                    <select class="form-control f18" id="select_typeItem_request"></select>
                </div>

                <div class="col-md-4">
                    <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control  f18" id="input_search_request" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์">
                </div>


                <div class="col-md-12 mt-2">
                    <table class="table table-hover table-sm" id="table_item_request">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">Min</th>
                                <th scope="col" class="text-center" id="">คงเหลือ</th>
                                <th scope="col" class="text-center" id="">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_request">ยืนยัน</button>
                </div>
            </div>


        </div>
        <div class="col-md-6">

            <input type="text" id="input_docnoRQ" hidden>
            <div class="row" style="margin-top: 4.6rem !important;">
                <div class="col-md-12 mt-2">
                    <table class="table table-hover table-sm" id="table_rq">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" id="btn_clear_request">ล้างข้อมูล</button>
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_send_request">สร้างใบขอซื้อ</button>
                </div>

            </div>
        </div>
    </div>


</div>

<div id="row_receive">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date1_rq" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group ">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date2_rq" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">


                    <table class="table table-hover table-sm" id="table_rq2">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-left" style="width:5%;"></th>
                                <th scope="col" class="text-left" style="width:50%;">เลขเอกสารขอเบิกอุปกรณ์</th>
                                <th scope="col" class="text-center" style="width:10%;">สถานะ</th>
                                <th scope="col" class="text-center" style="width:10%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>






                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row " style="margin-top: 3.3rem !important;">
                <div class="col-md-12">
                    <table class="table table-hover table-sm" id="table_detail_rq">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="" style="width:5%;"></th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_RQ">ยืนยัน</button>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="row_history">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group ">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date1_search" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group ">
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date2_search" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">


                    <table class="table table-hover table-sm" id="table_history">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center">เลขที่เอกสาร RQ</th>
                                <th scope="col" class="text-center">เลขที่เอกสาร RT</th>
                                <th scope="col" class="text-center">วันที่</th>
                                <th scope="col" class="text-center">เวลา</th>
                                <th scope="col" class="text-center">แสดงรายละเอียด</th>
                                <th scope="col" class="text-center">รายงาน</th>
                                <th scope="col" class="text-center">สถานะ</th>

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


<div class="modal fade" id="myModal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 text-right">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" style="color:black;font-weight: bold;" for="customSwitch1">แสดงรวม</label>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-sm" id="table_detail">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
                            <th scope="col" class="text-center" id="qr_change">QrCode</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>