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


<div class="card">
    <div class="card-body">
        <div class="row mt-3">


            <div class="col-md-7">

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="" style="font-weight: 600;color:black;" class="f18">รายงาน</label>
                        <select class="form-control f18" id="select_report">
                            <option value="1">รายงานเติมอุปกรณ์</option>
                            <option value="2">รายงานเบิกอุปกรณ์</option>
                            <option value="3">รายงานใช้อุปกรณ์</option>
                            <option value="4">รายงานหยิบอุปกรณ์</option>
                            <option value="5">สรุปค่าใช้จ่าย OR</option>
                            <option value="6">รายงานจ่ายอุปกรณ์</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="" style="font-weight: 600;color:black;" class="f18">ประเภทรายงาน</label>
                        <select class="form-control f18" id="select_type_date">
                            <option value="">ประเภทรายงาน</option>
                            <option value="1">วัน</option>
                            <option value="2">เดือน</option>
                            <option value="3">ปี</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3" id="row_typeday">
                        <label for="" style="font-weight: 600;color:black;" class="f18">รูปแบบ</label>
                        <div class="col-md-8">
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_date" id="radio_date1" checked="">หนึ่งวัน
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_date" id="radio_date2">หลายวัน
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="row_typemonth">
                        <label for="" style="font-weight: 600;color:black;" class="f18">รูปแบบ</label>
                        <div class="col-md-8">
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_month" id="radio_month1" checked="">หนึ่งเดือน
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_month" id="radio_month2">หลายเดือน
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="row_typeyear">
                        <label for="" style="font-weight: 600;color:black;" class="f18">รูปแบบ</label>
                        <div class="col-md-8">
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_year" id="radio_year1" checked="">หนึ่งปี
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" style="color:black;">
                                    <input type="radio" class="form-check-input f18" name="radio_year" id="radio_year2">หลายปี
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="row_day">
                        <label for="" style="font-weight: 600;color:black;" class="f18">วันที่</label>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control f18" id="select_date1" data-language='en' data-date-format='dd-mm-yyyy'>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control f18" id="select_date2" data-language='en' data-date-format='dd-mm-yyyy'>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mt-3" id="row_month">
                        <label for="" style="font-weight: 600;color:black;" class="f18">เดือน</label>

                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control f18" id="select_month1">
                                    <option value="1">มกราคม</option>
                                    <option value="2">กุมภาพันธ์</option>
                                    <option value="3">มีนาคม</option>
                                    <option value="4">เมษายน</option>
                                    <option value="5">พฤษภาคม</option>
                                    <option value="6">มิถุนายน</option>
                                    <option value="7">กรกฎาคม</option>
                                    <option value="8">สิงหาคม</option>
                                    <option value="9">กันยายน</option>
                                    <option value="10">ตุลาคม</option>
                                    <option value="11">พฤศจิกายน</option>
                                    <option value="12">ธันวาคม</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control f18" id="select_month2">
                                <option value="1">มกราคม</option>
                                    <option value="2">กุมภาพันธ์</option>
                                    <option value="3">มีนาคม</option>
                                    <option value="4">เมษายน</option>
                                    <option value="5">พฤษภาคม</option>
                                    <option value="6">มิถุนายน</option>
                                    <option value="7">กรกฎาคม</option>
                                    <option value="8">สิงหาคม</option>
                                    <option value="9">กันยายน</option>
                                    <option value="10">ตุลาคม</option>
                                    <option value="11">พฤศจิกายน</option>
                                    <option value="12">ธันวาคม</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 mt-3" id="row_year">
                        <label for="" style="font-weight: 600;color:black;" class="f18">ปี</label>

                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control f18" id="select_year1">
                                    <option value="2566">2566</option>
                                    <option value="2567">2567</option>
                                    <option value="2568">2568</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control f18" id="select_year2">
                                    <option value="2566">2566</option>
                                    <option value="2567">2567</option>
                                    <option value="2568">2568</option>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-5 mt-5 text-right ">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-light  f18 " id="btn_reset" style="border-color: black;width: 200px;line-height: 40px;"><i class="fa-solid fa-repeat"></i> รีเซ็ต</button>
                            </div>
                            <div class="col-md-12 text-right mt-3">
                                <button class="btn btn-danger f18" id="btn_report" style="width: 200px;line-height: 40px;"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                            </div>
                            <div class="col-md-12 text-right mt-3">
                                <button class="btn btn-success f18 " style="width: 200px;line-height: 40px;"><i class="fa-solid fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>