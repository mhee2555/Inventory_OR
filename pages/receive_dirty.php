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




    <div class="row mt-2">
        <div class=" col-md-12 col-lg-9  ">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_viewdeproom">แสดงแบบห้องผ่าตัด</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_viewallitem">แสดงแบบรวมรายการ Sterile</button>
            </div>
        </div>
    </div>
</div>

<hr>

<input type="text" id="check_radio" value="1" hidden>

<div>
    <div class="row">
        <div class="col-md-6">
            <div class="row">

                <div class="col-md-12 mt-3">

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_deproom">
                                <thead style="background-color: #cdd6ff;">
                                    <th scope="col" class="text-center" id="" style="width: 10%;"></th>
                                    <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                                    <th scope="col" class="text-center" id="" style="width: 10%;">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <table class="table table-hover table-sm" id="table_item">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 10%;"></th>
                                        <th scope="col" class="text-center" id="">รายการ</th>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_wait_receive" style="color:#fff;background-color:#643695;font-size:20px;">ยืนยัน</button>

                                </div>
                            </div>
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
                            <table class="table table-hover table-sm" id="table_item_save">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="" style="width: 60%;">รายการ</th>
                                        <th scope="col" class="text-center" id="" style="width: 20%;">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">จำนวน</th>
                                        <th scope="col" class="text-center" id="" style="width: 10%;">ชำรุด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn btn-outline-secondary f18" id="btn_cancel" >ยกเลิก</button>
                                    <button class="btn f18" id="btn_send" style="color:#fff;background-color:#643695;font-size:20px;">ส่งไป N Sterile</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Button to Open the Modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportIssueModal">
    Report Issue
</button> -->

<!-- Modal -->
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
                <button type="button" class="btn btn-outline-secondary f18"  data-dismiss="modal" >ยกเลิก</button>
                <button type="button" class="btn f18" style="color:#fff;background-color:#643695;" id="btn_save_damage"> บันทึก</button>
            </div>
        </div>
    </div>
</div>