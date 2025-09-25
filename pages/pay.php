<div class="row mt-3">
    <div class=" col-md-12 col-lg-9">

        <div class="tab-button-group">
            <button class="tab-button active" id="radio_pay">จ่ายอุปกรณ์</button>
            <button class="tab-button" id="radio_pay_manual">จ่ายอุปกรณ์ Manual</button>
            <button class="tab-button" id="radio_return_pay">สแกนอุปกรณ์คืนคลัง</button>
            <button class="tab-button" id="radio_history_pay">ประวัติการจ่ายอุปกรณ์</button>
            <button class="tab-button" id="radio_hn_pay_block">ผู้ป่วยงดรับบริการ</button>
            <button class="tab-button" id="radio_sell_deproom">ขายให้หน่วยงาน</button>
        </div>



        <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_pay">จ่ายอุปกรณ์</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_pay_manual">จ่ายอุปกรณ์ Manual</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_return_pay">สแกนอุปกรณ์คืนคลัง</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_history_pay">ประวัติการจ่ายอุปกรณ์</button>
        </div> -->
    </div>
</div>

<hr>




<div id="pay">
    <div class="row">
        <div class="col-md-6">



            <div class="row">
                <div class="col-md-4">
                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">วันที่</label>

                        <div class="position-relative">
                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_pay" data-language='en' data-date-format='dd-mm-yyyy'>
                            <span class="input-icon">
                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                            </span>
                        </div>



                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                        <select class="form-control f18" autocomplete="off" id="select_deproom_pay"></select>
                    </div>



                </div>

                <div class="col-md-4">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ค้นหา เลขประจำตัวผู้ป่วย</label>
                        <input class="form-control f18" autocomplete="off" id="input_searchHN_pay">
                    </div>



                </div>
                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover " id="table_deproom_pay">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-left" style="width:10%;">ลำดับ</th>
                                        <th scope="col" class="text-center" style="width:80%;">ห้องผ่าตัด</th>
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
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                                    <input type='text' class='form-control f18' id="input_box_pay" disabled>
                                </div>
                                <div class="col-md-4">
                                    <button disabled class="btn btn-danger btn-block f18" style="margin-top: 2rem;" id="btn_edit_hn"><i class="fa-solid fa-pen-to-square"></i> แก้ไขข้อมูล</button>
                                </div>
                                <div class="col-md-4">
                                    <button disabled class="btn btn-danger btn-block f18" style="margin-top: 2rem;" id="btn_block_hn"><i class="fa-regular fa-circle-xmark"></i> งด </button>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                                    <input type='text' class='form-control f18' id="input_Hn_pay" disabled>
                                </div>
                                <div class="col-md-4 mt-3">

                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>

                                        <div class="position-relative">
                                            <input disabled type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_date_service" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <span class="input-icon">
                                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                                            </span>
                                        </div>


                                        <!-- <input type="text" class="form-control datepicker-here f18" id="input_date_service" data-language='en' data-date-format='dd-mm-yyyy'> -->
                                    </div>


                                </div>
                                <div class="col-md-4 mt-3">

                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                                        <input disabled type="time" class="form-control datepicker-here f18" id="input_time_service" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>


                                </div>
                                <div class="col-md-4 mt-3">




                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">สแกนจ่าย</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_pay">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color:black;"></i>
                                            </span>
                                        </div>

                                        <!-- <input type="text" class="form-control f18" id="input_pay" placeholder="" autocomplete="off"> -->

                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">สแกนคืนคลังหลักห้องผ่าตัด</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_returnpay">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color: #d32f2f;"></i>
                                            </span>
                                        </div>


                                        <!-- <input type="text" class="form-control f18" id="input_returnpay" placeholder="" style="border-color: red;" autocomplete="off"> -->
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button id="btn_scan_RFid" class="btn btn-block" style="color:#fff;background-color:#643695;font-size: 13px;margin-top: 2rem !important;line-height: 25px;">จ่ายอุปกรณ์จากตู้ RFID & Weighing</button>
                                </div>
                            </div>


                            <table class="table table-hover " id="table_deproom_DocNo_pay">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 60%;">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style='background-color:#4fc3f7;'>ขอเบิก</th>
                                        <th scope="col" class="text-center" id="" style="background-color: #9AEAD8;">สแกนจ่าย</th>
                                        <th scope="col" class="text-center" id="" style='background-color:#f36c60;'>คงเหลือ</th>
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

<div id="pay_manual">


    <div class="row mt-3">
        <div class=" col-md-12 col-lg-9  ">

            <div class="tab-button-group">
                <button class="tab-button3 active" id="radio_pay_manual_sub">จ่ายอุปกรณ์ Manual</button>
                <button class="tab-button3" id="radio_ems_manual">เคสฉุกเฉิน</button>
            </div>
        </div>
    </div>



    <div class="row mt-3" id="row_manual">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-9" style="margin-top: -35px !important;">'
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                                            <input type='text' class='form-control f18' id="input_box_pay_manual">
                                        </div>
                                        <div class="col-md-6">
                                            <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                                            <input type='text' class='form-control f18' id="input_Hn_pay_manual">
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-md-1 text-right" style="max-width: 7.333333%;">
                                    <div class="form-check " style="margin-top: 35px;">
                                        <input type="checkbox" class="form-check-input" id="checkbox_tf" style="width: 25px;height: 25px;">
                                        <label class="form-check-label f22 ml-4 mt-1" for="checkbox_tf" style="color:black;font-weight:bold;">TF</label>
                                    </div>
                                </div>

                                <div class="col-md-2 text-right" style="max-width: 15%;">
                                    <div class="form-check " style="margin-top: 35px;">
                                        <input type="checkbox" class="form-check-input" id="checkbox_manual_ems" style="width: 25px;height: 25px;">
                                        <label class="form-check-label f22 ml-4 mt-1" for="checkbox_manual_ems" style="color:black;font-weight:bold;">สแกนจ่ายเคสฉุกเฉิน</label>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_date_service_manual" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <span class="input-icon">
                                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                                        <input type="time" class="form-control datepicker-here f18" id="input_time_service_manual" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>
                                </div>


                                <div class="col-md-4 mt-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group x">
                                                <label style="color:black;font-weight: 600;">แพทย์</label>
                                                <select class="form-control f18" autocomplete="off" id="select_doctor_manual"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <div class="col-md-12" style="display: ruby;" id="row_doctor">
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                                        <select class="form-control f18" autocomplete="off" id="select_deproom_manual"></select>
                                    </div>
                                </div>



                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label style="color:black;font-weight: 600;">หัตถการ</label>
                                                <select class="form-control f18" autocomplete="off" id="select_procedure_manual"></select>
                                            </div>
                                        </div>

                                        <div class="col-md-12" style="display: ruby;" id="row_procedure">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">หมายเหตุ</label>
                                        <input type="text" class="form-control f18" id="input_remark_manual">
                                    </div>
                                </div>











                                <div class="col-md-4 ">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">สแกนจ่าย</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_pay_manual" autocomplete="off">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color:black;"></i>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">สแกนคืนคลังหลักห้องผ่าตัด</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_returnpay_manual" autocomplete="off">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color: #d32f2f;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3" hidden>
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">เอกสาร</label>
                                        <input type="text" class="form-control f18" id="input_docNo_deproom_manual" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3" hidden>
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">เอกสาร HN</label>
                                        <input type="text" class="form-control f18" id="input_docNo_HN_manual" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-2 text-right">
                                    <button id="btn_clear_manual" class="btn btn-block" style=" color:black; border-color:gray;font-size: 18px;margin-top: 2.1rem !important;line-height: 25px;"><i class="fa-solid fa-repeat"></i> รีเซ็ตข้อมูล</button>
                                </div>

                                <div class="col-md-2">
                                    <button id="btn_scan_RFid_manual" class="btn  btn-block" style="color:#fff;background-color:#643695;font-size: 13px;margin-top: 2.1rem !important;line-height: 25px;">จ่ายอุปกรณ์จากตู้ RFID & Weighing</button>
                                </div>


                            </div>


                            <table class="table table-hover  mt-3" id="table_deproom_DocNo_pay_manual">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">ลำดับ</th>
                                        <th scope="col" class="text-center" id="" style="width: 70%;">อุปกรณ์</th>
                                        <!-- <th scope="col" class="text-center" id="">ขอเบิก</th> -->
                                        <th scope="col" class="text-center" id="" style="width: 10%;background-color: #9AEAD8;">สแกนจ่าย</th>
                                        <!-- <th scope="col" class="text-center" id="">คงเหลือ</th> -->
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

    <div class="row mt-3" id="row_ems">
        <div class="col-md-12">
            <table class="table table-hover " id="table_ems">
                <thead style="background-color: #cdd6ff;">
                    <tr>
                        <th scope="col" class="text-center" id="">ลำดับ</th>
                        <th scope="col" class="text-center" id="">แพทย์</th>
                        <th scope="col" class="text-center" id="">หัตถการ</th>
                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                        <th scope="col" class="text-center" id="">#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div id="return">

    <div class="row mt-3">
        <div class=" col-md-12 col-lg-9  ">

            <div class="tab-button-group">
                <button class="tab-button2 active" id="radio_return">สแกนคืนอุปกรณ์</button>
                <button class="tab-button2" id="radio_history_return">ประวัติสแกนคืนอุปกรณ์</button>
            </div>




            <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_return">สแกนคืนอุปกรณ์</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_history_return">ประวัติสแกนคืนอุปกรณ์</button>
            </div> -->
        </div>

        <div class="col-lg-3 text-right">
            <div class="form-check " style="margin-top: 38px;">
                <input type="checkbox" class="form-check-input" id="checkbox_showReturn" style="width: 25px;height: 25px;">
                <label class="form-check-label f18 ml-4 mt-1" for="checkbox_showReturn" style="color:black;font-weight:bold;">แสดงแบบแยกรหัสอุปกรณ์</label>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-12" id="row_return">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">


                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_scan_return" autocomplete="off" placeholder="สแกนคืน">
                                    <span class="input-icon">
                                        <i class="fas fa-qrcode" style="color:black;"></i>
                                    </span>
                                </div>

                                <!-- <div class="input-group mb-2">
                                    <input type="text" class="form-control f18" id="input_scan_return" autocomplete="off" placeholder="สแกนคืน">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                                    </div>

                                </div> -->

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <table class="table table-hover " id="table_item_return">
                            <thead style="background-color: #cdd6ff;">
                                <tr>
                                    <th scope="col" class="text-center" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                    <th scope="col" class="text-center" id="" style="width: 60%;">อุปกรณ์</th>
                                    <th scope="col" class="text-center" id="">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-12 text-right mt-2">
                        <button class="btn f18" style="background-color:#643695;color:#fff;" id="btn_send_return_data">ส่งข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="row_history_return">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label for="" style="color:black;font-weight: 600;">ค้นหา</label>
                                <input type="text" class="form-control f18" id="input_search_history_return" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label for="" style="color:black;font-weight: 600;">วันที่</label>

                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_return" data-language='en' data-date-format='dd-mm-yyyy'>
                                    <span class="input-icon">
                                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover " id="table_history_return">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 5%;">ลำดับ</th>
                                        <th scope="col" class="text-center" id="" style="width:  20%;">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style="width: 30%;">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style="width: 20%;">ผู้คืน</th>
                                        <th scope="col" class="text-center" id="" style="width: 20%;">เลขประจำตัวผู้ป่วย</th>
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

<div id="history_pay">

    <div class="form-row align-items-end flex-wrap">
        <div class="col-md-8">
            <div class="form-row">

                <div class="col">
                    <label class="font-weight-bold text-dark">วันที่เริ่ม</label>
                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_S" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>
                </div>
                <div class="col">
                    <label class="font-weight-bold text-dark">วันที่สิ้นสุด</label>
                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_L" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>
                </div>


                <div class="col">
                    <div class="position-relative">
                        <label class="font-weight-bold text-dark">เลขประจำตัวผู้ป่วย</label>
                        <input type="text" class="form-control f18" id="input_hn_history">
                    </div>
                </div>

                <div class="col">
                    <label class="font-weight-bold text-dark">เงื่อนไข</label>
                    <select class="form-control f18" id="select_typeSearch_history">
                        <option value="">กรุณาเลือกประเภทการค้นหา</option>
                        <option value="1">ห้องผ่าตัด</option>
                        <option value="2">แพทย์</option>
                        <option value="3">หัตถการ</option>
                        <option value="4">อุปกรณ์</option>
                        <option value="5">หน่วยงาน</option>
                    </select>
                </div>


                <div class="col" id="col_deproom_history">
                    <label class="font-weight-bold text-dark">ห้องผ่าตัด</label>
                    <select class="form-control f18" id="select_deproom_history"></select>
                </div>

                <div class="col" id="col_doctor_history">
                    <label class="font-weight-bold text-dark">แพทย์</label>
                    <select class="form-control f18" id="select_doctor_history"></select>
                </div>

                <div class="col" id="col_procedure_history">
                    <label class="font-weight-bold text-dark">หัตถการ</label>
                    <select class="form-control f18" id="select_procedure_history"></select>
                </div>

                <div class="col" id="col_item_history">
                    <label class="font-weight-bold text-dark">อุปกรณ์</label>
                    <select class="form-control f18" id="select_item_history"></select>
                </div>

                <div class="col" id="col_department_history">
                    <label class="font-weight-bold text-dark">หน่วยงาน</label>
                    <select class="form-control f18" id="select_deproom_sell_history"></select>
                </div>


            </div>
        </div>


        <div class="col-md-4 text-right">
            <div class="form-row">
                <div class="col">
                    <button class="btn btn-outline-danger " style="font-size: 18px;width:100%;" id="btn_Show_Report1">สรุปเคสประจำวัน</button>
                </div>
                <div class="col">
                    <button class="btn btn-outline-danger " style="font-size: 18px;width:100%;" id="btn_Show_Report2">ใบติดหน้ากล่อง</button>
                </div>
                <div class="col">
                    <button class="btn btn-outline-success" id="btn_show_report" style="font-size: 15px;width:100%;"><i class="fa-solid fa-file-excel"></i> สถิติการจ่ายอุปกรณ์</button>
                </div>



            </div>
        </div>



        <!-- <div class="col-md-2 text-right">
        </div>

        <div class="col-md-1 text-right">
        </div>
        <div class="col-md-1 text-right">
        </div> -->


        <!-- <div class="col-md-2">
            <label class="font-weight-bold text-dark">HN</label>
            <input type="text" class="form-control f18" id="input_hn_history">
        </div>

        <div class="col-md-2">
            <label class="font-weight-bold text-dark">เงื่อนไข</label>
            <select class="form-control f18" id="select_typeSearch_history">
                <option value="">กรุณาเลือกประเภทการค้นหา</option>
                <option value="1">ห้องผ่าตัด</option>
                <option value="2">แพทย์</option>
                <option value="3">หัตถการ</option>
                <option value="4">อุปกรณ์</option>
            </select>
        </div>


        <div class="col-md-2" id="col_deproom_history">
            <label class="font-weight-bold text-dark">ห้องผ่าตัด</label>
            <select class="form-control f18" id="select_deproom_history"></select>
        </div>

        <div class="col-md-2" id="col_doctor_history">
            <label class="font-weight-bold text-dark">แพทย์</label>
            <select class="form-control f18" id="select_doctor_history"></select>
        </div>

        <div class="col-md-2" id="col_procedure_history">
            <label class="font-weight-bold text-dark">หัตถการ</label>
            <select class="form-control f18" id="select_procedure_history"></select>
        </div>

        <div class="col-md-2" id="col_item_history">
            <label class="font-weight-bold text-dark">อุปกรณ์</label>
            <select class="form-control f18" id="select_item_history"></select>
        </div>

        <div class="col-md-2" id="col_hide">

        </div> -->








    </div>

    <div class="form-row align-items-end flex-wrap">
        <div class="col-md-4">

        </div>
        <div class="col-md-2">

        </div>

        <div class="col-md-2">
            <div class="row mt-2">
                <div class="col-md-12" style="display: ruby;" id="row_doctor_history">
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="row mt-2">
                <div class="col-md-12" style="display: ruby;" id="row_procedure_history">
                </div>
            </div>
        </div>

        <div class="col-md-1">

        </div>

        <div class="col-md-1">

        </div>


    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover" id="table_history">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">วันที่จ่ายอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
                                        <th scope="col" class="text-center" id="">ผุ้ยืนยัน</th>
                                        <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                        <th scope="col" class="text-center" id="">แพทย์</th>
                                        <th scope="col" class="text-center" id="">หัตถการ</th>
                                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">ยกเลิก</th>
                                        <th scope="col" class="text-center" id="">รายงานจ่าย</th>
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
                                            <input type="text" class="form-control f18" id="input_scanclaim" autocomplete="off" placeholder="สแกนอุปกรณ์">
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group ">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control f18" id="input_return_claim" placeholder="สแกนอุปกรณ์กลับ" style="border-color: red;" autocomplete="off">
                                            <div class="input-group-append">
                                                <div class="input-group-text" style="border-color: red;"><i class="fa-solid fa-qrcode"></i></div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <table class="table table-hover " id="table_item_claim">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="" style="width: 60%;">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="col-md-12 text-right mt-2">
                        <button class="btn f18" style="background-color: #004aad;color:#fff;" id="btn_send_nsterile_claim">ส่งไป N-Sterile</button>
                        <a href="pages/send-n-sterile.php" class="btn btn-primary" id="btn_send" hidden>cc</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="hn_pay_block">

    <div class="form-row align-items-end flex-wrap">
        <!-- วันที่ -->
        <div class="col-md-4">
            <label class="font-weight-bold text-dark">วันที่</label>
            <div class="form-row">
                <div class="col">

                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_S_block" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>

                    <!-- <div class="input-group">
                        <input type="text" class="form-control datepicker-here f18" id="select_date_history_S" data-language='en' data-date-format='dd-mm-yyyy'>
                        <div class="input-group-append">
                            <div class="input-group-text bg-light"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                    </div> -->
                </div>
                <div class="col">

                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_L_block" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>

                    <!-- <div class="input-group">
                        <input type="text" class="form-control datepicker-here f18" id="select_date_history_L" data-language='en' data-date-format='dd-mm-yyyy'>
                        <div class="input-group-append">
                            <div class="input-group-text bg-light"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>




        <!-- เลขประจำตัวผู้ป่วย -->
        <div class="col-md-2">
            <label class="font-weight-bold text-dark">เลขประจำตัวผู้ป่วย</label>
            <input type="text" class="form-control f18" id="input_hn_history_block">
        </div>

        <div class="col-md-2">
            <label class="font-weight-bold text-dark">เงื่อนไข</label>
            <select class="form-control f18" id="select_typeSearch_history_block">
                <option value="">กรุณาเลือกประเภทการค้นหา</option>
                <option value="1">ห้องผ่าตัด</option>
                <option value="2">แพทย์</option>
                <option value="3">หัตถการ</option>
            </select>
        </div>


        <!-- ห้องผ่าตัด -->
        <div class="col-md-2" id="col_deproom_history_block">
            <label class="font-weight-bold text-dark">ห้องผ่าตัด</label>
            <select class="form-control f18" id="select_deproom_history_block"></select>
        </div>

        <!-- แพทย์ -->
        <div class="col-md-2" id="col_doctor_history_block">
            <label class="font-weight-bold text-dark">แพทย์</label>
            <select class="form-control f18" id="select_doctor_history_block"></select>
        </div>

        <!-- หัตถการ -->
        <div class="col-md-2" id="col_procedure_history_block">
            <label class="font-weight-bold text-dark">หัตถการ</label>
            <select class="form-control f18" id="select_procedure_history_block"></select>
        </div>



        <div class="col-md-2" id="col_hide_block">

        </div>
        <!-- <div class="col-md-1" id="col_hide_2_block">

        </div> -->

        <div class="col-md-2 text-right">
            <div class="form-check " style="margin-top: 38px;">
                <input type="checkbox" class="form-check-input" id="checkbox_filter" style="width: 25px;height: 25px;">
                <label class="form-check-label f18 ml-4 mt-1" for="checkbox_filter" style="color:black;font-weight:bold;">แสดงทั้งหมด</label>
            </div>
        </div>

    </div>

    <div class="form-row align-items-end flex-wrap">
        <!-- วันที่ -->
        <div class="col-md-4">

        </div>
        <!-- ห้องผ่าตัด -->
        <div class="col-md-2">

        </div>

        <!-- แพทย์ -->
        <div class="col-md-2">
            <div class="row mt-2">
                <div class="col-md-12" style="display: ruby;" id="row_doctor_history_block">
                </div>
            </div>
        </div>

        <!-- หัตถการ -->
        <div class="col-md-2">
            <div class="row mt-2">
                <div class="col-md-12" style="display: ruby;" id="row_procedure_history_block">
                </div>
            </div>
        </div>

        <!-- เลขประจำตัวผู้ป่วย -->
        <div class="col-md-1">

        </div>

        <!-- ปุ่ม Excel -->
        <div class="col-md-1">

        </div>




    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover " id="table_history_block">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
                                        <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                        <th scope="col" class="text-center" id="">แพทย์</th>
                                        <th scope="col" class="text-center" id="">หัตถการ</th>
                                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">อัพเดตข้อมูล</th>
                                        <th scope="col" class="text-center" id="">ยกเลิก</th>
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

<div id="sell_deproom">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">วันที่</label>

                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_sell" data-language='en' data-date-format='dd-mm-yyyy'>
                                    <span class="input-icon">
                                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                                    </span>
                                </div>



                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">หน่วยงาน</label>
                                <select class="form-control f18" autocomplete="off" id="select_deproom_sell"></select>
                            </div>



                        </div>
                        <div class="col-md-12 mt-3">

                            <div class="card">

                                <div class="card-body">
                                    <table class="table table-hover " id="table_deproom_sell">
                                        <thead style="background-color: #cdd6ff;">
                                            <tr>
                                                <th scope="col" class="text-center" style="width:10%;"></th>
                                                <th scope="col" class="text-center" style="width:80%;">หน่วยงาน</th>
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
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-12 mt-2">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">หน่วยงาน</label>
                                        <select class="form-control f18" autocomplete="off" id="select_department_sell_right"></select>
                                    </div>
                                </div>



                                <div class="col-md-6 mt-2">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_date_service_sell" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <span class="input-icon">
                                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                                        <input type="time" class="form-control datepicker-here f18" id="input_time_service_sell" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>
                                </div>







                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">สแกนจ่าย</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_pay_sell" autocomplete="off">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color:black;"></i>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">สแกนคืนคลังหลักห้องผ่าตัด</label>

                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_returnpay_sell" autocomplete="off">
                                            <span class="input-icon">
                                                <i class="fas fa-qrcode" style="color: #d32f2f;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>






                            </div>


                            <table class="table table-hover  mt-3" id="table_deproom_DocNo_pay_sell">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">ลำดับ</th>
                                        <th scope="col" class="text-center" id="" style="width: 70%;">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style="width: 10%;background-color: #9AEAD8;">จำนวน</th>
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
                <table class="table table-hover " id="table_detail_Procedure">
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
                <table class="table table-hover " id="table_detail_Doctor">
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

<div class="modal fade" id="myModal_Detail_Permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover " id="table_Detail_Permission">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">สังกัด</th>
                            <th scope="col" class="text-center" id="">เบิก</th>
                            <th scope="col" class="text-center" id="">จ่าย</th>
                            <th scope="col" class="text-center" id="">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_edit_hn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                        <input type='text' class='form-control f18' id="input_box_pay_editHN">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                        <input type='text' class='form-control f18' id="input_Hn_pay_editHN">
                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                            <input type="text" class="form-control datepicker-here f18" id="input_date_service_editHN" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                            <input type="time" class="form-control datepicker-here f18" id="input_time_service_editHN" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group x">
                                    <label style="color:black;font-weight: 600;">แพทย์</label>
                                    <select class="form-control f18" autocomplete="off" id="select_doctor_editHN"></select>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="col-md-12" style="display: ruby;" id="row_doctor_editHN">
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                            <select class="form-control f18" autocomplete="off" id="select_deproom_editHN"></select>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label style="color:black;font-weight: 600;">หัตถการ</label>
                                    <select class="form-control f18" autocomplete="off" id="select_procedure_editHN"></select>
                                </div>
                            </div>

                            <div class="col-md-12" style="display: ruby;" id="row_procedure_editHN">
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button class="btn-success btn f18" id="btn_save_edit_hn">บันทึก</button>
                <button class="btn-danger btn f18" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_edit_hn_block" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                        <input type='text' class='form-control f18' id="input_box_pay_editHN_block">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                        <input type='text' class='form-control f18' id="input_Hn_pay_editHN_block">
                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                            <input type="text" class="form-control datepicker-here f18" id="input_date_service_editHN_block" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                            <input type="time" class="form-control datepicker-here f18" id="input_time_service_editHN_block" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group x">
                                    <label style="color:black;font-weight: 600;">แพทย์</label>
                                    <select class="form-control f18" autocomplete="off" id="select_doctor_editHN_block"></select>
                                </div>
                            </div>

                            <div class="col-md-12" style="display: ruby;" id="row_doctor_editHN_block">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                            <select class="form-control f18" autocomplete="off" id="select_deproom_editHN_block"></select>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label style="color:black;font-weight: 600;">หัตถการ</label>
                                    <select class="form-control f18" autocomplete="off" id="select_procedure_editHN_block"></select>
                                </div>
                            </div>

                            <div class="col-md-12" style="display: ruby;" id="row_procedure_editHN_block">
                            </div>

                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button class="btn-success btn f18" id="btn_save_edit_hn_block">บันทึก</button>
                <button class="btn-danger btn f18" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_edit_ems" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                        <input type='text' class='form-control f18' id="input_box_pay_ems">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                        <input type='text' class='form-control f18' id="input_Hn_pay_ems">
                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                            <input type="text" class="form-control datepicker-here f18" id="input_date_service_ems" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>
                    <div class="col-md-4 mt-3">

                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                            <input type="time" class="form-control datepicker-here f18" id="input_time_service_ems" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>


                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group x">
                                    <label style="color:black;font-weight: 600;">แพทย์</label>
                                    <select class="form-control f18" autocomplete="off" id="select_doctor_ems"></select>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="col-md-12" style="display: ruby;" id="row_doctor_ems">
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group ">
                            <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                            <select class="form-control f18" autocomplete="off" id="select_deproom_ems"></select>
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label style="color:black;font-weight: 600;">หัตถการ</label>
                                    <select class="form-control f18" autocomplete="off" id="select_procedure_ems"></select>
                                </div>
                            </div>

                            <div class="col-md-12" style="display: ruby;" id="row_procedure_ems">
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button class="btn-success btn f18" id="btn_save_ems">บันทึก</button>
                <button class="btn-danger btn f18" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal_Detail_Block" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover " id="table_Detail_item_block">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
                            <th scope="col" class="text-center" id="">จ่าย</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal_Detail_item_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="color:black;font-weight:bold;" id="header_item"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-sm" id="table_Detail_item_history">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                            <th scope="col" class="text-center" id="">แพทย์</th>
                            <th scope="col" class="text-center" id="">หัตถการ</th>
                            <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                            <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
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


<div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="dateForm" class="modal-content needs-validation" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">เลือกวันที่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="dateInput" style="color:black;">วันที่</label>
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="dateInput" data-language='en' data-date-format='dd-mm-yyyy'>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-danger btn f18" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn-success btn f18" id="btn_Show_Report1_modal">ยืนยัน</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="dateModal2" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="dateForm" class="modal-content needs-validation" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">เลือกวันที่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="ปิด">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="dateInput" style="color:black;">วันที่</label>
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="dateInput2" data-language='en' data-date-format='dd-mm-yyyy'>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-danger btn f18" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn-success btn f18" id="btn_Show_Report2_modal">ยืนยัน</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="showDetail_item_map" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">อุปกรณ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover " id="table_detail_item_modal">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
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