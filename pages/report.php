<div>
    <div class="container-fluid">
        <div class="row justify-content-end mt-3">
            <div class="col-auto">
                <div class="input-group" style="background-color: #f1f3fb; border-radius: 10px; border: 1px solid #dce0eb; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"
                            style="border: none; background-color: white; font-weight: bold; border-right: 1px solid #dce0eb;">
                            สิทธิ์การเข้าใช้งาน :
                        </span>
                    </div>
                    <input type="text" class="form-control font-weight-bold"
                        id="input_Deproom_Main" disabled
                        style="background-color: #f1f3fb; border: none; color: #000;">
                </div>
            </div>

            <div class="col-auto ml-2">
                <div class="input-group" style="background-color: #f1f3fb; border-radius: 10px; border: 1px solid #dce0eb; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"
                            style="border: none; background-color: white; font-weight: bold; border-right: 1px solid #dce0eb;">
                            ชื่อผู้ใช้งาน :
                        </span>
                    </div>
                    <input type="text" class="form-control font-weight-bold"
                        id="input_Name_Main" disabled
                        style="background-color: #f1f3fb; border: none; color: #000;">
                </div>
            </div>
        </div>
    </div>
</div>

<hr>


<div class="card">
    <div class="card-body">
        <div class="row mt-3">


            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="" style="font-weight: 600;color:black;" class="f18">รายงาน</label>
                        <select class="form-control f18" id="select_report">
                            <option value="1">รายงานเติมอุปกรณ์</option>
                            <option value="2">รายงานเบิกอุปกรณ์</option>
                            <option value="3">รายงานใช้อุปกรณ์</option>
                            <option value="5">สรุปค่าใช้จ่าย OR</option>
                            <option value="6">รายงานจ่ายอุปกรณ์</option>
                            <option value="7">รายงานสต๊อกคงเหลือในคลัง</option>
                            <option value="8">สรุปผู้ป่วยเข้ารับบริการ</option>
                            <option value="9">Operating Room Inventory Tracking</option>


                        </select>
                    </div>
                    <div class="col-md-12 mt-3" id="row_typedate">
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

                    <div class="col-md-12 mt-3" id="row_day_9">
                        <label for="" style="font-weight: 600;color:black;" class="f18">วันที่</label>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control f18" id="select_date1_9" data-language='en' data-date-format='dd-mm-yyyy'>
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



            <div class="col-md-6 text-right ">
                <div class="row">
                    <div class="col-md-12 text-right mt-3">
                        <button class="btn btn-outline-danger f18" id="btn_report" style="width: 200px;line-height: 40px;"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                    </div>
                    <div class="col-md-12 text-right mt-3">
                        <button class="btn btn-outline-success f18" id="btn_excel" style="width: 200px;line-height: 40px;"><i class="fa-solid fa-file-excel"></i> Excel</button>
                    </div>
                    <div class="col-md-12 text-right mt-3">
                        <button class="btn btn-outline-primary f18" id="btn_png" style="width: 200px;line-height: 40px;" hidden><i class="fa-solid fa-images"></i> PNG</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <button class="btn btn-light  f18 " id="btn_reset" style="border-color: black;width: 200px;line-height: 40px;"><i class="fa-solid fa-repeat"></i> รีเซ็ต</button>
    </div>
</div>