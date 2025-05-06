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



</div>

<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio_pay">จ่ายอุปกรณ์</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio_pay_manual">จ่ายอุปกรณ์ Manual</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio_return_pay">สแกนอุปกรณ์คืนคลัง</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio_history_pay">ประวัติการจ่ายอุปกรณ์</button>
            <!-- <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio_claim" hidden>เคลม</button> -->
        </div>
    </div>
</div>

<hr>




<div id="pay">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">วันที่</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker-here f18" id="select_date_pay" data-language='en' data-date-format='dd-mm-yyyy'>
                            <div class="input-group-append">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                        <select class="form-control f18" autocomplete="off" id="select_deproom_pay"></select>
                    </div>



                </div>
                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_deproom_pay">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-left" style="width:5%;">ลำดับ</th>
                                        <th scope="col" class="text-center" style="width:40%;">ห้องผ่าตัด</th>
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

                                <div class="col-md-8">
                                    <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                                    <input type='text' class='form-control f18' id="input_box_pay" disabled>
                                </div>
                                <div class="col-md-4">
                                    <button disabled class="btn btn-danger btn-block f18" style="margin-top: 2rem;" id="btn_edit_hn"><i class="fa-solid fa-pen-to-square"></i> แก้ไขข้อมูล</button>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label style="color:black;font-weight: 600;">HN Code</label>
                                    <input type='text' class='form-control f18' id="input_Hn_pay" disabled>
                                </div>
                                <div class="col-md-4 mt-3">

                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                                        <input type="text" class="form-control datepicker-here f18" id="input_date_service" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>


                                </div>
                                <div class="col-md-4 mt-3">

                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                                        <input type="time" class="form-control datepicker-here f18" id="input_time_service" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>


                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">สแกนจ่าย</label>
                                        <input type="text" class="form-control f18" id="input_pay" placeholder="" autocomplete="off">

                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">สแกนคืนคลังหลักห้องผ่าตัด</label>
                                        <input type="text" class="form-control f18" id="input_returnpay" placeholder="" style="border-color: red;" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button id="btn_scan_RFid" class="btn btn-block" style="color:#fff;background-color:#643695;font-size: 13px;margin-top: 2rem !important;line-height: 25px;">จ่ายอุปกรณ์จากตู้ RFID & Weighing</button>
                                </div>
                            </div>


                            <table class="table table-hover table-sm" id="table_deproom_DocNo_pay">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 70%;">รายการ</th>
                                        <!-- <th scope="col" class="text-center" id="">ขอเบิก</th> -->
                                        <th scope="col" class="text-center" id="" style="background-color: #9AEAD8;">สแกนจ่าย</th>
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
</div>

<div id="pay_manual">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label style="color:black;font-weight: 600;">เลขที่กล่อง</label>
                                    <input type='text' class='form-control f18' id="input_box_pay_manual">
                                </div>
                                <div class="col-md-6">
                                    <label style="color:black;font-weight: 600;">HN Code</label>
                                    <input type='text' class='form-control f18' id="input_Hn_pay_manual">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                                        <input type="text" class="form-control datepicker-here f18" id="input_date_service_manual" data-language='en' data-date-format='dd-mm-yyyy'>
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
                                        <label style="color:green;font-weight: 600;">สแกนจ่าย</label>
                                        <input type="text" class="form-control f18" id="input_pay_manual" placeholder="" style="border-color: green;" autocomplete="off">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label style="color:red;font-weight: 600;">สแกนคืนคลังหลักห้องผ่าตัด</label>
                                        <input type="text" class="form-control f18" id="input_returnpay_manual" placeholder="" style="border-color: red;" autocomplete="off">
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


                            <table class="table table-hover table-sm mt-3" id="table_deproom_DocNo_pay_manual">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">ลำดับ</th>
                                        <th scope="col" class="text-center" id="" style="width: 70%;">รายการ</th>
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
</div>

<div id="return">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control f18" id="input_scan_return" autocomplete="off" placeholder="สแกนคืน">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>


                    <table class="table table-hover table-sm" id="table_item_return">
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

                    <div class="col-md-12 text-right mt-2">
                        <button class="btn f18" style="background-color:#643695;color:#fff;" id="btn_send_return_data">ส่งข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="history_pay">

    <div class="form-row align-items-end flex-wrap">
        <!-- วันที่ -->
        <div class="col-md-4">
            <label class="font-weight-bold text-dark">วันที่</label>
            <div class="form-row">
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker-here f18" id="select_date_history_S" data-language='en' data-date-format='dd-mm-yyyy'>
                        <div class="input-group-append">
                            <div class="input-group-text bg-light"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker-here f18" id="select_date_history_L" data-language='en' data-date-format='dd-mm-yyyy'>
                        <div class="input-group-append">
                            <div class="input-group-text bg-light"><i class="fa-regular fa-calendar-days"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ห้องผ่าตัด -->
        <div class="col-md-2">
            <label class="font-weight-bold text-dark">ห้องผ่าตัด</label>
            <select class="form-control f18" id="select_deproom_history"></select>
        </div>

        <!-- แพทย์ -->
        <div class="col-md-2">
            <label class="font-weight-bold text-dark">แพทย์</label>
            <select class="form-control f18" id="select_doctor_history"></select>
        </div>

        <!-- หัตถการ -->
        <div class="col-md-2">
            <label class="font-weight-bold text-dark">หัตถการ</label>
            <select class="form-control f18" id="select_procedure_history"></select>
        </div>

        <!-- HN Code -->
        <div class="col-md-1">
            <label class="font-weight-bold text-dark">HN</label>
            <input type="text" class="form-control f18" id="input_hn_history">
        </div>

        <!-- ปุ่ม Excel -->
        <div class="col-md-1">
            <label class="font-weight-bold text-dark">SUDs</label>
            <button class="btn btn-outline-success btn-block" id="btn_show_report"><i class="fa-solid fa-file-excel"></i> EXCEL</button>
        </div>


    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_history">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">วันที่จ่ายอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
                                        <th scope="col" class="text-center" id="">ผุ้ยืนยัน</th>
                                        <th scope="col" class="text-center" id="">HN Code</th>
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


                    <table class="table table-hover table-sm" id="table_item_claim">
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
                        <label style="color:black;font-weight: 600;">HN Code</label>
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