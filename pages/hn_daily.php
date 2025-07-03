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
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_daily">คนไข้ประจำวัน</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_refrain">งด</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_his">ยืนยันการส่งค่าใช้จ่าย (HIS)</button>
        </div>
    </div>
</div>

<div id="row_daily">
    <div class="row">
        <div class="col-md-9">
            <div class="d-flex justify-content-end align-items-center">
                <!-- Checkbox -->
                <div class="form-check mr-2">
                    <input type="checkbox" class="form-check-input" id="checkbox_filter" style="width: 25px;height: 25px;">
                    <label class="form-check-label f18 ml-2 mt-1" for="checkbox_filter" style="color:black;font-weight:bold;">แสดงเอกสารคงค้าง</label>
                </div>

                <!-- Select -->
                <div class="form-group mb-0">
                    <select class="form-control f18" id="select_type" style="min-width: 330px;">
                        <option value="">เลือกทั้งหมด</option>
                        <option value="1">รอดำเนินการ</option>
                        <option value="2">ดำเนินการเรียบร้อย</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group ">
                <div class="input-group">
                    <input type="text" class="form-control datepicker-here f18" id="select_date1_search1" data-language='en' data-date-format='dd-mm-yyyy'>
                    <div class="input-group-append">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-2">
            <table class="table table-hover table-sm" id="table_daily">
                <thead c style="background-color: #cdd6ff;">
                    <tr>
                        <th scope="col" class="text-center" id="">เลขประจำตัวคนไข้</th>
                        <th scope="col" class="text-center" id="">วัน/เวลารับบริการ</th>
                        <th scope="col" class="text-center" id="">แพทย์</th>
                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                        <th scope="col" class="text-center" id="" style="width:30%">หัตถการ</th>
                        <th scope="col" class="text-center" id="">#</th>
                        <th scope="col" class="text-center" id="">#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="row_refrain">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <div class="form-group ">
                <div class="input-group">
                    <input type="text" class="form-control datepicker-here f18" id="select_date1_search2" data-language='en' data-date-format='dd-mm-yyyy'>
                    <div class="input-group-append">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-2">
            <table class="table table-hover table-sm" id="table_refrain">
                <thead c style="background-color: #cdd6ff;">
                    <tr>
                        <th scope="col" class="text-center" id="">เลขประจำตัวคนไข้</th>
                        <th scope="col" class="text-center" id="">วัน/เวลารับบริการ</th>
                        <th scope="col" class="text-center" id="">แพทย์</th>
                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                        <th scope="col" class="text-center" id="">หัตถการ</th>
                        <th scope="col" class="text-center" id="">#</th>
                        <th scope="col" class="text-center" id="">#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="row_his">
    <div class="row">
        <div class="col-md-7">
            <div class="row ">
                <div class="col-md-6  mt-3">
                    <label for="" id="lang_text_date2" style="font-weight: 600;color:black;">วันที่</label>

                    <div class="input-group">
                        <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_his_Date" data-language='en' data-date-format='dd-mm-yyyy' autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-lg-12 mt-3">

                    <table class="table table-hover table-sm " id="table_his_docno">
                        <thead class="table-active sticky-top">
                            <tr>
                                <th scope="col" class="text-center" id="">วันที่</th>
                                <th scope="col" class="text-center" id="">HN Number</th>
                                <th scope="col" class="text-center" id="">แพทย์</th>
                                <th scope="col" class="text-center" id="">หัตถการ</th>
                                <th scope="col" class="text-center" id="">สถานะ</th>
                                <th scope="col" class="text-center" id="">#</th>
                                <th scope="col" class="text-center" id="">#</th>
                            </tr>

                        </thead>
                        <tbody style="line-height: 40px;">

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
        <div class="col-md-5" style="margin-top: 3.1rem !important;">
            <div class="row ">
                <div class="col-md-6 text-left">
                    <button class="btn btn-success" id="btn_send_pay" disabled>ยืนยันการส่งค่าใข้จ่าย (HIS)</button>
                </div>
                <div class="col-md-6 text-right">
                    <span for="" class="f18" style="color:black;font-weight: bold;">ราคารวม</span>
                    <span for="" style="color:black;font-weight: bold;font-size:35px;" id="price_xx">0.00</span>
                    <span for="" class="f18" style="color:black;font-weight: bold;">บาท</span>
                </div>

                <div class="col-md-12 col-lg-12 mt-2">
                    <div class="row">
                        <div class="col-md-12 " id="div_detailleft1">
                            <table class="table table-hover table-sm " id="table_detail_his">
                                <thead class="table-active sticky-top">
                                    <tr>
                                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style='width: 15%;'>จำนวน</th>
                                        <th scope="col" class="text-center" id="" style='width: 15%;'>จำนวนเพิ่ม</th>
                                        <th scope="col" class="text-center" id="" style='width: 15%;'>จำนวนลด</th>
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


<div class="modal fade" id="myModal_Procedure" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">หัตถการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-sm" id="table_detail_Procedure">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">หัตถการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_Doctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แพทย์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-sm" id="table_detail_Doctor">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">แพทย์</th>
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