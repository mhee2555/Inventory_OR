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
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_suds">ความเคลื่อนไหว RFID</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_sterile">ความเคลื่อนไหวตู้ Weighing</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_normal">ความเคลื่อนไหว อุปกรณ์ปกติ</button>
            </div>
        </div>
    </div>
</div>

<hr>



<div id="suds">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group ">
                        <label for="" class="col-form-label" style="color:black;font-weight: 600;">ค้นหา</label>
                        <input type="text" class="form-control" id="input_search_suds" placeholder="">
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;font-weight: 600;">คลังหลัก</label>
                         <select class="form-control select2" id=""></select>
                    </div>



                </div>

                <div class="col-md-4" style="margin-top: 2.5rem !important;">
                    <button class="btn f18" style="color:#6f6f6f;">ล้างข้อมูล</button>
                    <button class="btn f18" style="background-color: #643695;color:#fff;">บันทึก</button>


                </div>
                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_item_suds1">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">ชื่ออุปกรณ์</th>
                                        <th scope="col" class="text-center" id="">จำนวน</th>
                                        <th scope="col" class="text-center" id="">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="card">
                            <div class="card-header">
                                <span id="itemCodeSUDs"></span>
                                <br>
                                <span id="itemNameSUDs" style="color: black;font-weight: 600;font-size: 25px;"></span>
                            </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_item_suds2">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">รหัสเครื่องมือ SUDs</th>
                                        <th scope="col" class="text-center" id="">สถานะ</th>
                                        <th scope="col" class="text-center" id="">คลังหลัก</th>
                                        <th scope="col" class="text-center" id="">ชั้น</th>
                                        <th scope="col" class="text-center" id="">แถว</th>
                                        <th scope="col" class="text-center" id="">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6" style="color:black;">ประวัติการเรียกใช้</div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span style="color:black;">ชื่อเครื่องมือ :</span> <span style="color:black;" id="item_name"></span> 
                                        </div>
                                        <div class="col-md-6">
                                            <span style="color:black;">รหัสเครื่องมือ SUDs :</span> <span style="color:black;" id="item_suds"></span> 
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_item_suds3">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">รหัสเครื่องมือ</th>
                                        <th scope="col" class="text-center" id="">จำนวนที่ใช้ซ้ำ (ปัจจุบัน)</th>
                                        <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                                        <th scope="col" class="text-center" id="">วันที่ทำปราศจากเชื้อ</th>
                                        <th scope="col" class="text-center" id="">วันหมดอายุ</th>
                                        <th scope="col" class="text-center" id="">รหัสใบส่งเครื่องมือ</th>
                                        <th scope="col" class="text-center" id="">เลขเอกสารรับเข้าคลัง</th>
                                        <th scope="col" class="text-center" id="">รหัสลูกค้า</th>
                                        <th scope="col" class="text-center" id="">เลขเบิกใช้เครื่องมือ</th>
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

<div id="sterile1">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;">วันที่</label>
                        <input type="text" class="form-control  datepicker-here f18" id="select_date1_rfid" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control  datepicker-here f18" id="select_date2" data-language='en' data-date-format='dd-mm-yyyy'>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-4">

                    <div class="form-group ">
                        <label for="" class="col-form-label " style="color:black;">ค้นหาชื่ออุปกรณ์</label>
                            <input type="text" class="form-control  f18" id="input_search_rfid" autocomplete="off">
                    </div>



                </div>


                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table table-sm table-bordered" id="table_DepRoom_rfid">
                                        <thead>
                                            <tr id="tr_TableDephead_rfid">

                                            </tr>
                                            <tr id="tr_TableDep_rfid">

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- <table class="table table-hover table-sm" id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">รายการ</th>
                                        <th scope="col" class="text-center" id="">จำนวนทั้งหมด</th>
                                        <th scope="col" class="text-center" id="">จ่ายไปห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">ส่ง CSSD</th>
                                        <th scope="col" class="text-center" id="">คงเหลือ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>

<div id="sterile">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;">วันที่</label>
                        <input type="text" class="form-control  datepicker-here f18" id="select_date1" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control  datepicker-here f18" id="select_date2" data-language='en' data-date-format='dd-mm-yyyy'>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-4">

                    <div class="form-group ">
                        <label for="" class="col-form-label " style="color:black;">ค้นหาชื่ออุปกรณ์</label>
                            <input type="text" class="form-control  f18" id="input_search" autocomplete="off">
                    </div>



                </div>


                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table table-sm table-bordered" id="table_DepRoom">
                                        <thead>
                                            <tr id="tr_TableDephead">

                                            </tr>
                                            <tr id="tr_TableDep">

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- <table class="table table-hover table-sm" id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">รายการ</th>
                                        <th scope="col" class="text-center" id="">จำนวนทั้งหมด</th>
                                        <th scope="col" class="text-center" id="">จ่ายไปห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">ส่ง CSSD</th>
                                        <th scope="col" class="text-center" id="">คงเหลือ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>

<div id="normal">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;">วันที่</label>
                        <input type="text" class="form-control  datepicker-here f18" id="select_date1_normal" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control  datepicker-here f18" id="select_date2" data-language='en' data-date-format='dd-mm-yyyy'>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-4">

                    <div class="form-group ">
                        <label for="" class="col-form-label " style="color:black;">ค้นหาชื่ออุปกรณ์</label>
                            <input type="text" class="form-control  f18" id="input_search_normal" autocomplete="off">
                    </div>



                </div>


                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table table-sm table-bordered" id="table_DepRoom_normal">
                                        <thead>
                                            <tr id="tr_TableDephead_normal">

                                            </tr>
                                            <tr id="tr_TableDep_normal">

                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- <table class="table table-hover table-sm" id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">รายการ</th>
                                        <th scope="col" class="text-center" id="">จำนวนทั้งหมด</th>
                                        <th scope="col" class="text-center" id="">จ่ายไปห้องผ่าตัด</th>
                                        <th scope="col" class="text-center" id="">ส่ง CSSD</th>
                                        <th scope="col" class="text-center" id="">คงเหลือ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                        </div>
                    </div>





                </div>
            </div>
        </div>
    </div>
</div>