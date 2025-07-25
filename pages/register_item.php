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


<div class="row mt-2">
    <div class=" col-md-12 col-lg-12">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_register_itemSUDs">ลงทะเบียนอุปกรณ์ SUDs</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_register_itemSterile">ลงทะเบียนอุปกรณ์ Sterile</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_register_implant">ลงทะเบียนอุปกรณ์ Implant</button>
            <!-- <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_history_item">ประวัติการเรียกใช้อุปกรณ์</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_use_limit">ใช้งานเกินจำนวน</button> -->
        </div>
    </div>
</div>


<hr>


<div class="row" id="register_itemSUDs">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">สถานที่</label>
                            <input type="text" class="form-control" value="BCM" disabled placeholder="สถานที่">
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2 text-right">
                        <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 35px;" id="btn_search_popup">ค้นหาอุปกรณ์</button>
                        <button class="btn f16 mt-2" style="background-color: #ff914d;color:#fff;width: 49% !important;"><i class="fa-solid fa-download"></i> ดาวน์โหลด</button>
                        <button class="btn f16 mt-2" style="background-color: #223f99;color:#fff;width: 49% !important;"><i class="fa-solid fa-upload"></i> อัพโหลด</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">หมายเลขอุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemCode1_SUDs" placeholder="หมายเลขอุปกรณ์" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">รหัสอุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemCode2_SUDs" placeholder="รหัสอุปกรณ์">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemName_SUDs" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:red;font-weight: 600;">จำนวนที่ใช้ซ้ำ <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control f18" id="input_LimitUse_SUDs" style="border-color:red;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:red;font-weight: 600;">มูลค่า(ต้นทุนของใหม่)</label>
                                    <input type="text" class="form-control f18" id="input_CostPrice_SUDs" style="border-color:red;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ใช้กับหัตถการ</label>
                                    <select class="form-control f18" id="select_Procedure_SUDs"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ประเภทการ Sterile</label>
                                    <select class="form-control f18" id="select_SterileProcecss_SUDs"></select>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ลักษณะการใช้งาน</label>
                                    <input type="text" class="form-control f18" id="select_Style_SUDs" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">วิธีตรวจสอบเมื่อใช้งานซ้ำ</label>
                                    <input type="text" class="form-control f18" id="select_Howto_SUDs" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">สถานะ</label>
                                    <br>

                                    <label class="switch">
                                        <input type="checkbox" checked id="checkbox_InActive_SUDs" value="0">
                                        <span class="slider round"></span>
                                    </label>
                                    <label for="" style="color:black;font-weight: 600;color:#2196F3;" id="text_InActive_SUDs">Active</label>


                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_SUDs" id="radio_InActive_SUDs" value="1">
                                        <label class="form-check-label" for="exampleRadios1" style="color:black;font-weight: 600;">
                                            InActive
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_SUDs" id="radio_Active_SUDs" value="0" checked>
                                        <label class="form-check-label" for="exampleRadios2" style="color:black;font-weight: 600;">
                                            Active
                                        </label>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">รายงาน SUDs</label>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-success f18 btn-block"><i class="fa-solid fa-file-csv"></i> Excel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-danger f18 btn-block"><i class="fa-solid fa-file-pdf"></i> ไฟล์ PDF</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>





                    </div>
                    <div class="col-md-2">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="file" id="image1_SUDs" />
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="file" id="image2_SUDs" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn btn-outline-secondary f18 " style="width: 150px;" id="btn_ClearItem_SUDs">รีเซ็ตข้อมูล</button>
                        <button class="btn f18 " style="background-color: #5271ff;color:#fff;width: 100px;" id="btn_SaveItem_SUDs">บันทึก</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
                เอกสารประกอบอุปกรณ์ SUDs
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">ประเภทเอกสาร</label>
                            <select class="form-control f18" id="select_typeDocument_SUDs"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขที่ควบคุมเอกสาร</label>
                            <input type="text" class="form-control f18" id="input_DocNo_SUDs" placeholder="เลขที่ควบคุมเอกสาร">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันที่อนุมัติเอกสาร</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ApproveDate_SUDs" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุ</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ExpDate_SUDs" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2 mt-5">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="checkbox_NoExp_SUDs" value="option1" style="width: 20px;height: 20px;">
                            <label class="form-check-label" for="inlineCheckbox1" style="color:black;font-weight: 600;">ไม่หมดอายุ</label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">คำอธิบาย</label>
                            <input type="text" class="form-control f18" id="input_Des_SUDs" placeholder="คำอธิบาย">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลือกไฟล์</label>
                            <input type="file" class="form-control f18" id="input_FileDocNo_SUDs" accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_SaveDocNo_SUDs" disabled>บันทึก</button>
                        </div>
                    </div>

                </div>


                <div class="row mt-3" id="">
                    <table class="table table-hover " id="table_DocNo_SUDs">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">ประเภท</th>
                                <th scope="col" class="text-center" id="">เวอร์ชั่น</th>
                                <th scope="col" class="text-center" id="">เลขที่ควบคุมเอกสาร</th>
                                <th scope="col" class="text-center" id="">เอกสาร</th>
                                <th scope="col" class="text-center" id="">วันที่อนุมัติเอกสาร</th>
                                <th scope="col" class="text-center" id="">วันหมดอายุ</th>
                                <th scope="col" class="text-center" id="">คำอธิบาย</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_detal_item_sud_A" value="option1" style="width: 20px;height: 20px;" checked>
                        <label class="form-check-label" for="inlineRadio1" style="color:black;font-weight: 600;">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radio_detal_item_sud_IN" value="option2" style="width: 20px;height: 20px;">
                        <label class="form-check-label" for="inlineRadio2" style="color:black;font-weight: 600;">InActive</label>
                    </div>
                </div>



                <div class="row " id="">

                    <div class="col-md-12 mt-3">
                        <table class="table table-hover " id="table_UsageCode_SUDs">
                            <thead style="background-color: #cdd6ff;">
                                <tr>
                                    <th scope="col" class="text-center" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">หมายเลขซีเรียล</th>
                                    <th scope="col" class="text-center" id="">รหัสประจำตัว SUDs</th>
                                    <th scope="col" class="text-center" id="">เลขล็อตการผลิต</th>
                                    <th scope="col" class="text-center" id="">วันหมดอายุจากผู้ผลิต</th>
                                    <th scope="col" class="text-center" id="">วันที่ลงทะเบียน</th>
                                    <th scope="col" class="text-center" id="">สถานะ</th>
                                    <th scope="col" class="text-center" id="">หมายเหตุการชำรุด</th>
                                    <th scope="col" class="text-center" id="">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>


                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button class="btn f18 btn-block" style="background-color: #004aad;color:#fff;margin-top: 30px;" id="btn_AddUsage_SUDs" disabled>เพิ่ม</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>



</div>

<div class="row" id="register_itemSterile">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">สถานที่</label>
                            <input type="text" class="form-control" value="BCM" disabled placeholder="สถานที่">
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2 text-right">
                        <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 35px;" id="btn_search_popup_Sterile">ค้นหาอุปกรณ์</button>
                        <button class="btn f16 mt-2" style="background-color: #ff914d;color:#fff;width: 49% !important;"><i class="fa-solid fa-download"></i> ดาวน์โหลด</button>
                        <button class="btn f16 mt-2" style="background-color: #223f99;color:#fff;width: 49% !important;"><i class="fa-solid fa-upload"></i> อัพโหลด</button>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">หมายเลขอุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemCode1_Sterile" placeholder="หมายเลขอุปกรณ์" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">รหัสอุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemCode2_Sterile" placeholder="รหัสอุปกรณ์">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemName_Sterile" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">มูลค่า(ต้นทุนของใหม่)</label>
                                    <input type="text" class="form-control f18" id="input_CostPrice_Sterile" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ใช้กับหัตถการ</label>
                                    <select class="form-control f18" id="select_Procedure_Sterile"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ประเภทการ Sterile</label>
                                    <select class="form-control f18" id="select_SterileProcecss_Sterile"></select>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ลักษณะการใช้งาน</label>
                                    <input type="text" class="form-control f18" id="select_Style_Sterile" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">วิธีตรวจสอบเมื่อใช้งานซ้ำ</label>
                                    <input type="text" class="form-control f18" id="select_Howto_Sterile" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">สถานะ</label>
                                    <br>
                                    <label class="switch">
                                        <input type="checkbox" checked id="checkbox_InActive_Sterile" value="0">
                                        <span class="slider round"></span>
                                    </label>
                                    <label for="" style="color:black;font-weight: 600;color:#2196F3;" id="text_InActive_Sterile">Active</label>

                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_Sterile" id="radio_InActive_Sterile" value="1">
                                        <label class="form-check-label" for="exampleRadios1" style="color:black;font-weight: 600;">
                                            InActive
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_Sterile" id="radio_Active_Sterile" value="0" checked>
                                        <label class="form-check-label" for="exampleRadios2" style="color:black;font-weight: 600;">
                                            Active
                                        </label>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">รายงาน Sterile</label>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-success f18 btn-block"><i class="fa-solid fa-file-csv"></i> Excel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-danger f18 btn-block"><i class="fa-solid fa-file-pdf"></i> ไฟล์ PDF</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                    </div>
                    <div class="col-md-2">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="file" id="image1_Sterile" />
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="file" id="image2_Sterile" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn btn-outline-secondary f18 " style="width: 150px;" id="btn_ClearItem_Sterile">รีเซ็ตข้อมูล</button>
                        <button class="btn f18 " style="background-color: #5271ff;color:#fff;width: 100px;" id="btn_SaveItem_Sterile">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
                เอกสารประกอบอุปกรณ์ Sterile
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">ประเภทเอกสาร</label>
                            <select class="form-control f18" id="select_typeDocument_Sterile"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขที่ควบคุมเอกสาร</label>
                            <input type="text" class="form-control f18" id="input_DocNo_Sterile" placeholder="เลขที่ควบคุมเอกสาร">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันที่อนุมัติเอกสาร</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ApproveDate_Sterile" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุ</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ExpDate_Sterile" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2 mt-5">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="checkbox_NoExp_Sterile" value="option1" style="width: 20px;height: 20px;">
                            <label class="form-check-label" for="inlineCheckbox1" style="color:black;font-weight: 600;">ไม่หมดอายุ</label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">คำอธิบาย</label>
                            <input type="text" class="form-control f18" id="input_Des_Sterile" placeholder="คำอธิบาย">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลือกไฟล์</label>
                            <input type="file" class="form-control f18" id="input_FileDocNo_Sterile" accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_SaveDocNo_Sterile" disabled>บันทึก</button>
                        </div>
                    </div>

                </div>


                <div class="row mt-3" id="">
                    <table class="table table-hover " id="table_DocNo_Sterile">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">ประเภท</th>
                                <th scope="col" class="text-center" id="">เวอร์ชั่น</th>
                                <th scope="col" class="text-center" id="">เลขที่ควบคุมเอกสาร</th>
                                <th scope="col" class="text-center" id="">เอกสาร</th>
                                <th scope="col" class="text-center" id="">วันที่อนุมัติเอกสาร</th>
                                <th scope="col" class="text-center" id="">วันหมดอายุ</th>
                                <th scope="col" class="text-center" id="">คำอธิบาย</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="form-check form-check-inline">
                        <input checked class="form-check-input" type="radio" name="inlineRadioOptions2" id="radio_detal_item_sterile_A" value="option1" style="width: 20px;height: 20px;" checked>
                        <label class="form-check-label" for="inlineRadio1" style="color:black;font-weight: 600;">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="radio_detal_item_sterile_IN" value="option2" style="width: 20px;height: 20px;">
                        <label class="form-check-label" for="inlineRadio2" style="color:black;font-weight: 600;">InActive</label>
                    </div>
                </div>




                <div class="row mt-3" id="">

                    <div class="col-md-12 mt-3">
                        <table class="table table-hover " id="table_UsageCode_Sterile">
                            <thead style="background-color: #cdd6ff;">
                                <tr>
                                    <th scope="col" class="text-center" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">หมายเลขซีเรียล</th>
                                    <th scope="col" class="text-center" id="">รหัสประจำตัว Sterile</th>
                                    <th scope="col" class="text-center" id="">เลขล็อตการผลิต</th>
                                    <th scope="col" class="text-center" id="">วันหมดอายุจากผู้ผลิต</th>
                                    <th scope="col" class="text-center" id="">วันที่ลงทะเบียน</th>
                                    <th scope="col" class="text-center" id="">สถานะ</th>
                                    <th scope="col" class="text-center" id="">หมายเหตุการชำรุด</th>
                                    <th scope="col" class="text-center" id="">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>


                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button class="btn f18 btn-block" style="background-color: #004aad;color:#fff;margin-top: 30px;" id="btn_AddUsage_Sterile" disabled>เพิ่ม</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row" id="register_implant">

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">สถานที่</label>
                            <input type="text" class="form-control" value="BCM" disabled placeholder="สถานที่">
                        </div>
                    </div>
                    <div class="col-md-7"></div>
                    <div class="col-md-2 text-right">
                        <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 35px;" id="btn_search_popup_implant">ค้นหาอุปกรณ์</button>
                        <button class="btn f16 mt-2" style="background-color: #ff914d;color:#fff;width: 49% !important;"><i class="fa-solid fa-download"></i> ดาวน์โหลด</button>
                        <button class="btn f16 mt-2" style="background-color: #223f99;color:#fff;width: 49% !important;"><i class="fa-solid fa-upload"></i> อัพโหลด</button>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">หมายเลขอุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemCode1_implant" placeholder="หมายเลขอุปกรณ์" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                                    <input type="text" class="form-control f18" id="input_ItemName_implant" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ใช้กับหัตถการ</label>
                                    <select class="form-control f18" id="select_Procedure_implant"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ราคาต้นทุน</label>
                                    <input type="text" class="form-control f18" id="input_CostPrice_implant" placeholder="ราคาต้นทุน">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ราคาขาย</label>
                                    <input type="text" class="form-control f18" id="input_SalePrice_implant" placeholder="ราคาขาย">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ข้อมูล Vendor</label>
                                    <input type="text" class="form-control f18" id="input_Vendor_implant" placeholder="ข้อมูล Vendor">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">ลักษณะการใช้งาน</label>
                                    <input type="text" class="form-control f18" id="select_Style_implant" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">สถานะ</label>
                                    <br>

                                    <label class="switch">
                                        <input type="checkbox" checked id="checkbox_InActive_implant" value="0">
                                        <span class="slider round"></span>
                                    </label>
                                    <label for="" style="color:black;font-weight: 600;color:#2196F3;" id="text_InActive_implant">Active</label>

                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_implant" id="radio_InActive_implant" value="1">
                                        <label class="form-check-label" for="exampleRadios1" style="color:black;font-weight: 600;">
                                            InActive
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio_CheckActive_implant" id="radio_Active_implant" value="0" checked>
                                        <label class="form-check-label" for="exampleRadios2" style="color:black;font-weight: 600;">
                                            Active
                                        </label>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight: 600;">รายงาน implant</label>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-success f18 btn-block"><i class="fa-solid fa-file-csv"></i> Excel</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-danger f18 btn-block"><i class="fa-solid fa-file-pdf"></i> ไฟล์ PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                    </div>
                    <div class="col-md-2">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <input type="file" id="image1_implant" />
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="file" id="image2_implant" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn btn-outline-secondary f18 " style="width: 150px;" id="btn_ClearItem_implant">รีเซ็ตข้อมูล</button>
                        <button class="btn f18 " style="background-color: #5271ff;color:#fff;width: 100px;" id="btn_SaveItem_implant">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
                เอกสารประกอบอุปกรณ์ implant
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">ประเภทเอกสาร</label>
                            <select class="form-control f18" id="select_typeDocument_implant"></select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขที่ควบคุมเอกสาร</label>
                            <input type="text" class="form-control f18" id="input_DocNo_implant" placeholder="เลขที่ควบคุมเอกสาร">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันที่อนุมัติเอกสาร</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ApproveDate_implant" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุ</label>
                            <div class="input-group">
                                <input type="text" class="form-control f18 datepicker-here" id="input_ExpDate_implant" data-language='en' data-date-format='dd-mm-yyyy'>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-light " style="font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2 mt-5">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="checkbox_NoExp_implant" value="option1" style="width: 20px;height: 20px;">
                            <label class="form-check-label" for="inlineCheckbox1" style="color:black;font-weight: 600;">ไม่หมดอายุ</label>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">คำอธิบาย</label>
                            <input type="text" class="form-control f18" id="input_Des_implant" placeholder="คำอธิบาย">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลือกไฟล์</label>
                            <input type="file" class="form-control f18" id="input_FileDocNo_implant" accept="application/pdf">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_SaveDocNo_implant" disabled>บันทึก</button>
                        </div>
                    </div>

                </div>


                <div class="row mt-3" id="">
                    <table class="table table-hover " id="table_DocNo_implant">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">ประเภท</th>
                                <th scope="col" class="text-center" id="">เวอร์ชั่น</th>
                                <th scope="col" class="text-center" id="">เลขที่ควบคุมเอกสาร</th>
                                <th scope="col" class="text-center" id="">เอกสาร</th>
                                <th scope="col" class="text-center" id="">วันที่อนุมัติเอกสาร</th>
                                <th scope="col" class="text-center" id="">วันหมดอายุ</th>
                                <th scope="col" class="text-center" id="">คำอธิบาย</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="form-check form-check-inline">
                        <input checked class="form-check-input" type="radio" name="inlineRadioOptions3" id="radio_detal_item_implant_A" value="option1" style="width: 20px;height: 20px;" checked>
                        <label class="form-check-label" for="inlineRadio1" style="color:black;font-weight: 600;">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions3" id="radio_detal_item_implant_IN" value="option2" style="width: 20px;height: 20px;">
                        <label class="form-check-label" for="inlineRadio2" style="color:black;font-weight: 600;">InActive</label>
                    </div>
                </div>




                <div class="row mt-3" id="">
                    <div class="col-md-12 mt-3">

                        <table class="table table-hover " id="table_UsageCode_implant">
                            <thead style="background-color: #cdd6ff;">
                                <tr>
                                    <th scope="col" class="text-center" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">หมายเลขซีเรียล</th>
                                    <th scope="col" class="text-center" id="">รหัสประจำตัว implant</th>
                                    <th scope="col" class="text-center" id="">เลขล็อตการผลิต</th>
                                    <th scope="col" class="text-center" id="">วันหมดอายุจากผู้ผลิต</th>
                                    <th scope="col" class="text-center" id="">วันที่ลงทะเบียน</th>
                                    <th scope="col" class="text-center" id="">สถานะ</th>
                                    <th scope="col" class="text-center" id="">หมายเหตุการชำรุด</th>
                                    <th scope="col" class="text-center" id="">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button class="btn f18 btn-block" style="background-color: #004aad;color:#fff;margin-top: 30px;" id="btn_AddUsage_implant" disabled>เพิ่ม</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="history_item">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="font-weight: 600;color:black;" class="f24">ค้นหาประวัติการเรียกใช้</span>

                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="" placeholder="ค้นหารหัสอุปกรณ์ หรือ ชื่ออุปกรณ์">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover " id="">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">หมายเลขอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">ชื่ออุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">#</th>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="font-weight: 600;color:black;" class="f24">รายละเอียดเครื่องมือ SUDs</span>

                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="" placeholder="ค้นหารหัสอุปกรณ์ หรือ ชื่ออุปกรณ์">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover " id="">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์ SUDs</th>
                                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">#</th>
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




        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="font-weight: 600;color:black;" class="f24">ประวัติการเรียกใช้</span>
                            <button class="btn btn-outline-secondary f18" disabled> Unicode : S23060001-004</button>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 text-right" style="color:black;font-weight: 600;">

                                </div>
                                <div class="col-md-3 text-right">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1" style="color:black;font-weight: 600;">แก้ไข HN</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions4" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2" style="color:black;font-weight: 600;">ปลดล็อค</label>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="" placeholder="รหัสเครื่องมือSUDs">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-hover " id="">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวนที่ใช้ซ้ำ</th>
                                <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                <th scope="col" class="text-center" id="">วันที่ทำปราศจากเชื้อ</th>
                                <th scope="col" class="text-center" id="">วันหมดอายุ</th>
                                <th scope="col" class="text-center" id="">รหัสใบส่งอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">เลขเอกสารรับเข้าคลัง</th>
                                <th scope="col" class="text-center" id="">รหัสลูกค้า</th>
                                <th scope="col" class="text-center" id="">เลขเบิกใช้เอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">#</th>
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

<div class="row" id="use_limit">
    <div class="col-md-12">
        <table class="table table-hover " id="">
            <thead style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" id="">รหัสอุปกรณ์ SUDs</th>
                    <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                    <th scope="col" class="text-center" id="">กำหนดรอบใช้งาน</th>
                    <th scope="col" class="text-center" id="">ใช้ไปแล้ว</th>
                    <th scope="col" class="text-center" id="">วันที่ครบรอบ</th>
                    <th scope="col" class="text-center" id="">จำนวนที่ใช้ซ้ำ(ปัจจุบัน)</th>
                    <th scope="col" class="text-center" id="">สถานะ</th>
                    <th scope="col" class="text-center" id="">อนุมัติ</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="modal_item_implant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">รายการอุปกรณ์</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="input_modal_search_implant" placeholder="รายการอุปกรณ์">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>


                <table class="table table-hover " id="modal_table_item_implant">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" id="">หมายเลขอุปกรณ์</th>
                            <th scope="col" id="">#</th>
                            <th scope="col" id="">ชื่ออุปกรณ์</th>
                            <th scope="col" id="">สถานะ</th>
                            <th scope="col" id="">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>





            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Additem_implant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <input type="text" id="number_row_implant" value="1" hidden>
                <div id="row_Additemimplant">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button class="btn f18" style="background-color: #004aad;color:#fff;margin-top: 30px;" id="btn_Modal_AddUsage_implant">+</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #004aad;color:#fff;margin-top: 30px;" id="btn_Modal_SaveUsage_implant">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Edititem_implant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;font-weight: 600;">ลำดับ</label>
                        <br>
                        <span style="color:black;font-weight: 600;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie_implant" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot_implant" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_implant" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันลงทะเบียน</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_register_implant" data-language='en' data-date-format='dd-mm-yyyy' disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty_implant" placeholder="จำนวน" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_SaveEditUsage_implant">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_item_Sterile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">รายการอุปกรณ์</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="input_modal_search_Sterile" placeholder="รายการอุปกรณ์">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>


                <table class="table table-hover " id="modal_table_item_Sterile">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" id="">หมายเลขอุปกรณ์</th>
                            <th scope="col" id="">#</th>
                            <th scope="col" id="">รหัสอุปกรณ์</th>
                            <th scope="col" id="">ชื่ออุปกรณ์</th>
                            <th scope="col" id="">สถานะ</th>
                            <th scope="col" id="">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>





            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Additem_Sterile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <input type="text" id="number_row_Sterile" value="1" hidden>
                <div id="row_AdditemSterile">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_AddUsage_Sterile">+</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_SaveUsage_Sterile">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Edititem_Sterile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;font-weight: 600;">ลำดับ</label>
                        <br>
                        <span style="color:black;font-weight: 600;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie_Sterile" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot_Sterile" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp_Sterile" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันลงทะเบียน</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_register_Sterile" data-language='en' data-date-format='dd-mm-yyyy' disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty_Sterile" placeholder="จำนวน" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_SaveEditUsage_Sterile">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_item_SUDs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">รายการอุปกรณ์</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="input_modal_search_Suds" placeholder="รายการอุปกรณ์">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>


                <table class="table table-hover " id="modal_table_item_SUDs">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" id="">หมายเลขอุปกรณ์</th>
                            <th scope="col" id="">#</th>
                            <th scope="col" id="">รหัสอุปกรณ์</th>
                            <th scope="col" id="">ชื่ออุปกรณ์</th>
                            <th scope="col" id="">สถานะ</th>
                            <th scope="col" id="">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>





            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Additem_SUDs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <input type="text" id="number_row_SUDs" value="1" hidden>
                <div id="row_AdditemSUDs">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_AddUsage_SUDs">+</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_SaveUsage_SUDs">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Edititem_SUDs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-2 text-center">
                        <label for="" style="color:black;font-weight: 600;">ลำดับ</label>
                        <br>
                        <span style="color:black;font-weight: 600;">1</span>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">หมายเลขซีเรียล</label>
                            <input type="text" class="form-control f18" id="modal_input_serie" placeholder="หมายเลขซีเรียล">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">เลขล็อตการผลิต</label>
                            <input type="text" class="form-control f18" id="modal_input_lot" placeholder="เลขล็อตการผลิต">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันหมดอายุจากผู้ผลิต</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_exp" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">วันลงทะเบียน</label>
                            <input type="text" class="form-control f18 datepicker-here" id="modal_input_register" data-language='en' data-date-format='dd-mm-yyyy' disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" style="color:black;font-weight: 600;">จำนวน</label>
                            <input type="text" class="form-control f18" id="modal_input_qty" placeholder="จำนวน" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn f18" style="background-color: #5271ff;color:#fff;margin-top: 30px;" id="btn_Modal_SaveEditUsage_SUDs">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>