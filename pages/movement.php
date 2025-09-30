<div>






    <div class="row mt-2">
        <div class=" col-md-12 col-lg-9  ">

            <div class="tab-button-group">
                <button class="tab-button active" id="radio_suds">ความเคลื่อนไหว RFID</button>
                <button class="tab-button" id="radio_sterile">ความเคลื่อนไหวตู้ Weighing</button>
                <button class="tab-button" id="radio_normal">ความเคลื่อนไหว อุปกรณ์ปกติ</button>
                <button class="tab-button" id="radio_restock">ปรับยอดสต๊อก</button>
                <button class="tab-button" id="radio_follow">ติดตามอุปกรณ์</button>
            </div>

            <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_suds">ความเคลื่อนไหว RFID</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_sterile">ความเคลื่อนไหวตู้ Weighing</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_normal">ความเคลื่อนไหว อุปกรณ์ปกติ</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_restock">ปรับยอดสต๊อก</button>
            </div> -->
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
                            <table class="table table-hover " id="table_item_suds1">
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
                            <table class="table table-hover " id="table_item_suds2">
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
                            <table class="table table-hover " id="table_item_suds3">
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
                        <div class="position-relative">
                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date1_rfid" data-language='en' data-date-format='dd-mm-yyyy'>
                            <span class="input-icon">
                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                            </span>
                        </div>


                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group ">
                        <label for="" class="col-form-label " style="color:black;">ค้นหาชื่ออุปกรณ์</label>
                        <input type="text" class="form-control  f18" id="input_search_rfid" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-5 text-right" style="margin-top: 40px;">
                    <button class="btn btn-primary btn_upload_stock" style="margin-right: 10px;">อัพโหลดข้อมูล Stock</button>
                    <button class="btn btn-success btn_manage_stock">จัดการข้อมูล Stock</button>
                </div>



                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table  table-bordered" id="table_DepRoom_rfid_movement">
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

                            <!-- <table class="table table-hover " id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
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

                        <div class="position-relative">
                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date1" data-language='en' data-date-format='dd-mm-yyyy'>
                            <span class="input-icon">
                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                            </span>
                        </div>

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
                <div class="col-md-5 text-right" style="margin-top: 40px;">
                    <button class="btn btn-primary btn_upload_stock" style="margin-right: 10px;">อัพโหลดข้อมูล Stock</button>
                    <button class="btn btn-success btn_manage_stock">จัดการข้อมูล Stock</button>
                </div>


                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table  table-bordered" id="table_DepRoom_movement">
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

                            <!-- <table class="table table-hover " id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
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

                        <div class="position-relative">
                            <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date1_normal" data-language='en' data-date-format='dd-mm-yyyy'>
                            <span class="input-icon">
                                <i class="fa-solid fa-calendar" style="color:black;"></i>
                            </span>
                        </div>

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

                <div class="col-md-5 text-right" style="margin-top: 40px;">
                    <button class="btn btn-primary btn_upload_stock" style="margin-right: 10px;">อัพโหลดข้อมูล Stock</button>
                    <button class="btn btn-success btn_manage_stock">จัดการข้อมูล Stock</button>
                </div>



                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table  table-bordered" id="table_DepRoom_normal_movement">
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

                            <!-- <table class="table table-hover " id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
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

<div id="restock">
    <div class="row">
        <div class="col-md-12" id="row_return">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">

                                <div class="position-relative">
                                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="input_scan_restock">
                                    <span class="input-icon">
                                        <i class="fas fa-qrcode" style="color:black;"></i>
                                    </span>
                                </div>

                                <!-- <div class="input-group mb-2">
                                    <input type="text" class="form-control f18" id="input_scan_restock" autocomplete="off" placeholder="">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                                    </div>

                                </div> -->

                            </div>
                        </div>

                    </div>


                    <table class="table table-hover " id="table_item_restock">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">รหัสใช้งาน</th>
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
</div>

<div id="follow">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;">เดือน</label>
                        <select name="" id="select_follow_month" class="form-control f18">
                            <option value="01">มกราคม</option>
                            <option value="02">กุมภาพันธ์</option>
                            <option value="03">มีนาคม</option>
                            <option value="04">เมษายน</option>
                            <option value="05">พฤษภาคม</option>
                            <option value="06">มิถุนายน</option>
                            <option value="07">กรกฎาคม</option>
                            <option value="08">สิงหาคม</option>
                            <option value="09">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group ">
                        <label for="" class=" col-form-label" style="color:black;">ปี</label>
                        <input type="text" class="form-control f18" id="select_follow_year" data-language='en' data-date-format='yyyy'>
                        <!-- <select name="" id="select_follow_year" class="form-control f18">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select> -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="" class="col-form-label " style="color:black;">ประเภท</label>
                        <select name="" id="select_follow_type" class="form-control f18">
                            <option value="1">สต๊อกนอก</option>
                            <option value="2">สต๊อกใน</option>
                        </select>
                    </div>
                </div>



                <div class="col-md-5 text-right" style="margin-top: 40px;">
                    <button class="btn btn-warning f18" style="margin-right: 10px;width: 130px;" id="btn_add_follow_item">เพิ่มรายการ</button>
                    <button class="btn btn-danger f18" style="margin-right: 10px;width: 130px;" id="btn_pdf_follow_item">PDF</button>
                    <button class="btn btn-success f18" style="width: 130px;" id="btn_excel_follow_item">EXCEL</button>
                </div>



                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12 mt-3  table-responsive">

                                    <table class="table  table-bordered" id="table_follow_item">
                                        <thead>
                                            <tr id="tr_followHard_item">

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
    </div>
</div>


<div class="modal fade" id="modal_upload_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">อัพโหลดข้อมูล Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label for="" style="color:black;">ดาวน์โหลดไฟล์</label>
                        <br>
                        <button class="btn btn-success btn-block" onclick="window.location.href='report/phpexcel/Excel-Master.xlsx' ">Excel</button>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label style="color:black;">อัพโหลด</label>
                        <br>
                        <label class="btn btn-primary btn-block">
                            อัพโหลด Excel <input type="file" id="excelFile" hidden accept=".xls,.xlsx">
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="filename" disabled>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="save_upload_stock">บันทึก</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_manage_stockRFID" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">จัดการข้อมูล Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="" style="color:black;">เลือกอุปกรณ์</label>
                    <select class="form-control f18" id="item_manage_stockRFID"></select>
                </div>
                <div class="form-group">
                    <label for="" style="color:black;">Stock Max</label>
                    <input type="number" class="form-control f18" id="max_manage_stockRFID">
                </div>
                <div class="form-group">
                    <label for="" style="color:black;">Stock Min</label>
                    <input type="number" class="form-control f18" id="min_manage_stockRFID">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="save_manage_stockRFID">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_follow_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">


                    <div class="col-md-12 mt-3">
                        <label for="" style="color:black;">อุปกรณ์</label>
                        <select class="form-control f18" id="select_map_item_sub" ></select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-12"  id="row_item_map">

                            </div>
                        </div>
                    </div>




                </div>

            </div>
        </div>
    </div>
</div>