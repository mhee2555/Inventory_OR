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

<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_set_hn">กรอกข้อมูลคนไข้</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_history">ประวัติคนไข้</button>
        </div>
    </div>
</div>

<hr>

<div id="set_hn">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <label style="color:black;font-weight: 600;">เลขประจำตัวคนไข้</label>
                                    <input type='text' class='form-control f18' id="input_Hn_pay_manual">
                                    <input type='text' class='form-control f18' id="input_Hn_ID" hidden>
                                </div>
                                <div class="col-md-4 ">

                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">วันที่รับบริการ</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker-here f18" id="input_date_service_manual" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เวลารับบริการ</label>
                                        <input type="time" class="form-control datepicker-here f18" id="input_time_service_manual" data-language='en' data-date-format='dd-mm-yyyy'>
                                    </div>
                                </div>


                                <div class="col-md-4">
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


                                <div class="col-md-8">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">หมายเหตุ</label>
                                        <input type="text" class="form-control f18" id="input_remark_manual">
                                    </div>
                                </div>

                                <div class="col-md-2 text-right">
                                    <button id="btn_clear_manual" class="btn btn-block" style=" color:black; border-color:gray;font-size: 18px;margin-top: 2.1rem !important;line-height: 25px;"><i class="fa-solid fa-repeat"></i> รีเซ็ตข้อมูล</button>
                                </div>

                                <div class="col-md-2">
                                    <button id="btn_save_hn_manual" class="btn  btn-block" style="color:#fff;background-color:#643695;font-size: 18px;margin-top: 2.1rem !important;line-height: 25px;">บันทึก</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="history">

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
                                <th scope="col" class="text-center">ลำดับ</th>
                                <th scope="col" class="text-center">เลขที่ประจำตัวคนไข้</th>
                                <th scope="col" class="text-center">วัน/เวลารับบริการ</th>
                                <th scope="col" class="text-center">แพทย์</th>
                                <th scope="col" class="text-center">ห้องผ่าตัด</th>
                                <th scope="col" class="text-center">หัตถการ</th>
                                <th scope="col" class="text-center">#</th>

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