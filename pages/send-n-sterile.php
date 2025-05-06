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



<hr>

<div>

    <div class="row">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">รหัสผู้ปฏิบัติงาน</label>
                        <input type="text" class="form-control" id="" placeholder="รหัสผู้ปฏิบัติงาน">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">ชื่อผู้ปฏิบัติงาน</label>
                        <input type="text" class="form-control" id="" placeholder="ชื่อผู้ปฏิบัติงาน">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">ชื่อไซต์</label>
                        <input type="text" class="form-control" id="" placeholder="ชื่อไซต์">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">ผู้สร้างใบขอเบิกอุปกรณ์</label>
                        <input type="text" class="form-control" id="" placeholder="ผู้สร้างใบขอเบิกอุปกรณ์">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">ชื่อหน่วยงาน</label>
                        <input type="text" class="form-control" id="" placeholder="ชื่อหน่วยงาน">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">ประเภท</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1" style="color:black;">Network</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2" style="color:black;">Commercial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                            <label class="form-check-label" for="inlineRadio3" style="color:black;">General</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">วันที่เริ่มต้น</label>
                        <input type="text" class="form-control datepicker-here f18" id="select_date1" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">วันที่สิ้นสุด</label>
                        <input type="text" class="form-control datepicker-here f18" id="select_date2" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                </div>


            </div>
        </div>

    </div>

    <div class="row mt-2">
        <div class=" col-md-12 col-lg-8  ">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_item_sterile">อุปกรณ์ประเภท Sterile</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_item_suds">อุปกรณ์ประเภท SUDs</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_history_request">ประวัติการส่ง Create Request</button>
            </div>
        </div>

        <div class=" col-lg-4  text-right" id="row_report">
            <button class="btn btn-success" id="show_excel">EXCEL</button>
            <button class="btn btn-danger" id="show_report">รายงานส่งแลกเครื่องมือ</button>
        </div>
    </div>

    <div class="row mt-3" id="item_sterile">
        <table class="table table-hover table-sm" id="table_item_sterile">
            <thead style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" id="">ลำดับ</th>
                    <th scope="col" class="text-center" id="">รายการ</th>
                    <th scope="col" class="text-center" id="">จำนวน</th>
                    <th scope="col" class="text-center" id="">เหตุผล</th>
                    <th scope="col" class="text-center" id="">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="row mt-3" id="item_suds">
        <table class="table table-hover table-sm" id="table_item_suds">
            <thead style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" id="" style="width: 15%;">ลำดับ</th>
                    <th scope="col" class="text-center" id="">HN Code</th>
                    <th scope="col" class="text-center" id="">หัตถการ</th>
                    <th scope="col" class="text-center" id="">แพทย์</th>
                    <th scope="col" class="text-center" id="">Create Request</th>
                    <th scope="col" class="text-center" id="">รอบการส่ง Nsterile</th>
                    <th scope="col" class="text-center" id="">#</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <div class="row">
        <div class="col-md-12" style="text-align: end;">
            <button class="btn" id="btn_create_sendsterile" style="color:#fff;background-color:#643695;font-size:20px;">ยืนยัน</button>
            <button class="btn" id="btn_create_sendsterile_sud" hidden style="color:#fff;background-color:#643695;font-size:20px;">ยืนยัน</button>
        </div>
    </div>

    <div class="row mt-3" id="history_request">
        <table class="table table-hover table-sm" id="table_item">
            <thead style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" id="">ลำดับ</th>
                    <th scope="col" class="text-center" id="">เลขเอกสาร SS</th>
                    <th scope="col" class="text-center" id="">เลขเอกสาร RQ</th>
                    <th scope="col" class="text-center" id="">ประเภทขอเบิก</th>
                    <th scope="col" class="text-center" id="">แพทย์</th>
                    <th scope="col" class="text-center" id="">หัตถการ</th>
                    <th scope="col" class="text-center" id="">HN Code</th>
                    <th scope="col" class="text-center" id="">วันที่</th>
                    <th scope="col" class="text-center" id="">เวลา</th>
                    <th scope="col" class="text-center" id="">แสดงรายละเอียด</th>
                    <th scope="col" class="text-center" id="">รอบการส่ง N-Sterile</th>
                    <th scope="col" class="text-center" id="">ยกเลิก</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="RoundModal" tabindex="-1" aria-labelledby="RoundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-center w-100" style="color:black;">กรุณาเลือก <br> รอบการส่ง N-Sterile</label>
                            <select name="" id="round_sent_sterile" class="form-control">
                                <option value="1">รอบ 1</option>
                                <option value="2">รอบ 2</option>
                                <option value="3">รอบ 3</option>
                                <option value="4">รอบ 4</option>
                                <option value="5">รอบ 5</option>
                                <option value="6">รอบ 6</option>
                            </select>
                        </div>
                    </div>
                </div>



                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="color:#fff;background-color:#ed1c24;font-size:20px;">ยกเลิก</button>
                    <button type="button" class="btn" style="color:#fff;background-color:#643695;font-size:20px;" id="btn_send_sterile"> บันทึก</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="reportIssueModal" tabindex="-1" aria-labelledby="reportIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="reportIssueModalLabel" style="color:black;">แจ้งชำรุด</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" style="color:black;">ผู้แจ้ง:</label>
                            <input id="input_username_damage" type="text" class="form-control" value="นาย ABC" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" style="color:black;">วันและเวลา:</label>
                            <input id="input_date_damage" type="text" class="form-control" value="" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" style="color:black;">ชื่ออุปกรณ์:</label>
                            <input id="input_itemname_damage" type="text" class="form-control" value="EXAMSET (DENTAL)" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" style="color:black;">รหัสอุปกรณ์:</label>
                            <input id="input_itemcode_damage" type="text" class="form-control" value="BMC2406130151" readonly>
                        </div>
                    </div>

                </div>
                <!-- User Info -->

                <!-- Date and Time -->

                <!-- Equipment Info -->


                <!-- Reason -->
                <div class="mb-3">
                    <label for="reason" class="form-label" style="color:black;">หมายเหตุ:</label>
                    <textarea class="form-control" id="remark_damage" rows="3"></textarea>
                    <!-- <input type="text" class="form-control" id="remark_damage"> -->
                </div>
                <!-- File Upload -->
                <div class="mb-3">
                    <label for="uploadFile" class="form-label" style="color:black;">เพิ่มรูปภาพ:</label>
                    <input type="file" class="form-control" id="image_damage">
                    <input type="text" class="form-control" id="image64_damage" hidden>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" style="color:#fff;background-color:#ed1c24;font-size:20px;">ยกเลิก</button>
                <button type="button" class="btn" style="color:#fff;background-color:#643695;font-size:20px;" id="btn_save_damage"> บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="RoundReportModal" tabindex="-1" aria-labelledby="RoundReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-center w-100" style="color:black;">กรุณาเลือก <br> รอบการส่ง N-Sterile</label>
                            <select name="" id="round_sent_sterile_report" class="form-control">
                                <option value="0">แสดงรอบทั้งหมด</option>
                                <option value="1">รอบ 1</option>
                                <option value="2">รอบ 2</option>
                                <option value="3">รอบ 3</option>
                                <option value="4">รอบ 4</option>
                                <option value="5">รอบ 5</option>
                                <option value="6">รอบ 6</option>
                            </select>
                        </div>
                    </div>
                </div>



                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="color:#fff;background-color:#ed1c24;font-size:20px;">ยกเลิก</button>
                    <button type="button" class="btn" style="color:#fff;background-color:#643695;font-size:20px;" id="btn_show_report">แสดง</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="RoundExcelModal" tabindex="-1" aria-labelledby="RoundExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label text-center w-100" style="color:black;">กรุณาเลือก <br> รอบการส่ง N-Sterile</label>
                            <select name="" id="round_sent_sterile_excel" class="form-control">
                                <option value="0">แสดงรอบทั้งหมด</option>
                                <option value="1">รอบ 1</option>
                                <option value="2">รอบ 2</option>
                                <option value="3">รอบ 3</option>
                                <option value="4">รอบ 4</option>
                                <option value="5">รอบ 5</option>
                                <option value="6">รอบ 6</option>
                            </select>
                        </div>
                    </div>
                </div>



                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="color:#fff;background-color:#ed1c24;font-size:20px;">ยกเลิก</button>
                    <button type="button" class="btn" style="color:#fff;background-color:#643695;font-size:20px;" id="btn_show_excel">แสดง</button>
                </div>
            </div>
        </div>
    </div>
</div>