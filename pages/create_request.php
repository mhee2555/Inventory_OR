



<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">

        <div class="tab-button-group">
            <button class="tab-button active" id="radio_create_request">สร้างใบขอเบิกใช้อุปกรณ์กับผู้ป่วย</button>
            <button class="tab-button" id="radio_history_create_request">ประวัติขอเบิกใช้อุปกรณ์กับผู้ป่วย</button>
        </div>



        <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_create_request">สร้างใบขอเบิกใช้อุปกรณ์กับผู้ป่วย</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_history_create_request">ประวัติขอเบิกใช้อุปกรณ์กับผู้ป่วย</button>
        </div> -->
    </div>
</div>
</div>

<hr>


<hr>


<div id="create_request">
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
                        <div class="input-group">
                            <select name="" id="select_typeItem" class="form-control f18">
                                <option value="">เลือกทั้งหมด </option>
                                <option value="42">SUDs</option>
                                <option value="43">Implant</option>
                                <option value="44">Sterile</option>
                            </select>
                        </div>
                    </div>



                </div>

                <div class="col-md-10">

                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                        <input type="text" class="form-control f18" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์" id="input_search_request">
                    </div>
                </div>

                <div class="col-md-2" style="margin-top: 35px;">
                    <button class="btn btn-block f18" style="background-color: #643695;color:#fff;" id="btn_search_request"><i class="fa-solid fa-magnifying-glass"></i> ค้นหา</button>
                </div>

                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover " id="table_item_request">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">ประเภท</th>
                                        <th scope="col" class="text-center" id="">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>





                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_request">ยืนยัน</button>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <input type="text" class="form-control" id="txt_docno_request" placeholder="" hidden>
                                <input type="text" class="form-control" id="text_edit" placeholder="" hidden>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">เลขประจำตัวผู้ป่วย</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control f18 " id="input_hn_request" placeholder="" autocomplete="off">
                                            <input type="text" class="form-control f18 " id="input_set_hn_ID_request" placeholder="" autocomplete="off" hidden>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label style="color:black;font-weight: 600;">วันที่เข้ารับบริการ</label>


                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_request" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <span class="input-icon">
                                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                                            </span>
                                        </div>


                                        <!-- <div class="input-group pr-2">
                                            <input type="text" autocomplete="off" class="form-control datepicker-here f18" id="select_date_request" data-language='en' data-date-format='dd-mm-yyyy'>
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group x">
                                                <label style="color:black;font-weight: 600;">แพทย์</label>
                                                <select class="form-control f18" autocomplete="off" id="select_doctor_request"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display: ruby;" id="row_doctor">
                                        </div>
                                    </div>

                                </div>




                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label style="color:black;font-weight: 600;">เวลาเข้ารับบริการ</label>
                                        <div class="input-group pr-2">
                                            <input type="time" autocomplete="off" class="form-control  f18" id="select_time_request">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                                        <select class="form-control f18" autocomplete="off" id="select_deproom_request"></select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label style="color:black;font-weight: 600;">หัตถการ</label>
                                                <select class="form-control f18" autocomplete="off" id="select_procedure_request"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display: ruby;" id="row_procedure">
                                        </div>
                                    </div>

                                </div>




                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">หมายเหตุ</label>
                                        <input type="text" class="form-control f18" id="input_remark_request" placeholder="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <button class="btn btn-block" style="background-color: #643695;color:#fff;margin-top: 2.2rem;" id="btn_routine">Routine</button>
                                </div>

                            </div>


                            <table class="table table-hover " id="table_item_detail_request">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">จำนวน</th>
                                        <th scope="col" class="text-center" id="">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" id="btn_clear_request">ล้างข้อมูล</button>
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_send_request">ส่งข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="history_create_request">

    <div class="form-row align-items-end flex-wrap">
        <div class="col-md-5">
            <label class="font-weight-bold text-dark">วันที่</label>
            <div class="form-row">
                <div class="col">

                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_s" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>
                </div>
                <div class="col">

                    <div class="position-relative">
                        <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_l" data-language='en' data-date-format='dd-mm-yyyy'>
                        <span class="input-icon">
                            <i class="fa-solid fa-calendar" style="color:black;"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>




        <div class="col-md-3">
            <label class="font-weight-bold text-dark">เงื่อนไข</label>
            <select class="form-control f18" id="select_typeSearch_history">
                <option value="">กรุณาเลือกประเภทการค้นหา</option>
                <option value="1">ห้องผ่าตัด</option>
                <option value="2">แพทย์</option>
                <option value="3">หัตถการ</option>
            </select>
        </div>


        <div class="col-md-3" id="col_deproom_history">
            <label class="font-weight-bold text-dark">ห้องผ่าตัด</label>
            <select class="form-control f18" id="select_deproom_history"></select>
        </div>

        <div class="col-md-3" id="col_doctor_history">
            <label class="font-weight-bold text-dark">แพทย์</label>
            <select class="form-control f18" id="select_doctor_history"></select>
        </div>

        <div class="col-md-3" id="col_procedure_history">
            <label class="font-weight-bold text-dark">หัตถการ</label>
            <select class="form-control f18" id="select_procedure_history"></select>
        </div>


        <div class="col-md-3" id="col_hide">

        </div>

        <div class="col-md-1 text-right">
            <button class="btn btn-outline-success" id="btn_show_report" style="font-size: 18px;width: 120px;"><i class="fa-solid fa-file-excel"></i> EXCEL</button>
        </div>


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
                            <table class="table table-hover " id="table_history">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
                                        <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                        <th scope="col" class="text-center" id="">แพทย์</th>
                                        <th scope="col" class="text-center" id="">หัตถการ</th>
                                        <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">แก้ไข</th>
                                        <th scope="col" class="text-center" id="">รายงานขอเบิก</th>
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


    <!-- <div class="row mr-0 ml-0">
        <div class="col-md-12 ">
            <div class="row mr-0 ml-0">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label style="color:black;font-weight: 600;">วันที่เริ่ม</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_s" data-language='en' data-date-format='dd-mm-yyyy'>
                                    <span class="input-icon">
                                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label style="color:black;font-weight: 600;">วันที่สิ้นสุด</label>


                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date_history_l" data-language='en' data-date-format='dd-mm-yyyy'>
                                    <span class="input-icon">
                                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-2">
                    <label class="font-weight-bold text-dark">เงื่อนไข</label>
                    <select class="form-control f18" id="select_typeSearch_history">
                        <option value="">กรุณาเลือกประเภทการค้นหา</option>
                        <option value="1">ห้องผ่าตัด</option>
                        <option value="2">แพทย์</option>
                        <option value="3">หัตถการ</option>
                    </select>
                </div>

                <div class="col-md-2" id="col_deproom_history">
                    <div class="form-group">
                        <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                        <select class="form-control f18" autocomplete="off" id="select_deproom_history"></select>
                    </div>
                </div>

                <div class="col-md-2" id="col_doctor_history">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">แพทย์</label>
                                <select class="form-control f18" autocomplete="off" id="select_doctor_history"></select>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: ruby;" id="row_doctor_history">
                        </div>
                    </div>
                </div>

                <div class="col-md-2" id="col_procedure_history">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">หัตถการ</label>
                                <select class="form-control f18" autocomplete="off" id="select_procedure_history"></select>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: ruby;" id="row_procedure_history">
                        </div>
                    </div>
                </div>



                <div class="col-md-4" id="col_hide">

                </div>
                <div class="col-md-2" id="col_hide_2">

                </div>

                <div class="col-md-2">
                    <div class="form-group ">
                        <button class="btn  btn-block" style="border-color: gray;color:green;font-weight: bold;" id="btn_show_report"><i class="fa-solid fa-file-excel"></i> EXCEL</button>
                    </div>
                </div>

            </div>
            <div class="col-md-12 mt-3 ">

                <div class="card">

                    <div class="card-body">
                        <table class="table table-hover " id="table_history">
                            <thead style="background-color: #cdd6ff;">
                                <tr>
                                    <th scope="col" class="text-center" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">วันที่รับบริการ</th>
                                    <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                    <th scope="col" class="text-center" id="">แพทย์</th>
                                    <th scope="col" class="text-center" id="">หัตถการ</th>
                                    <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                                    <th scope="col" class="text-center" id="">แก้ไข</th>
                                    <th scope="col" class="text-center" id="">รายงานขอเบิก</th>
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

<!-- <script src="../assets/lang/create_request.js"></script> -->