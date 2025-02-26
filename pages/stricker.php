<div class="row">
    <div class="col-md-6">
        <h1 class="h3 mb-1 mt-4" style="font-size:30px;color:black;" id="text_Received1">รับอุุปกรณ์ใช้งานจากห้องตรวจ </h1>
        <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_Received2">รับอุุปกรณ์ใช้งานจากห้องตรวจ</a> -->
        <p class="mb-4" style="font-size:25px;color:black;" id="text_Received3"> อุปกรณ์ที่ใช้งานจากห้องตรวจ </p>
    </div>
    <div class="col-md-3 col-sm-6 mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_roomcheck">ห้องตรวจ</div>
            </div>
            <input type="text" class="form-control" id="input_Deproom_Main" disabled value="<?= $departmentroomname; ?>" style="font-size: 20px;">
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mt-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
            </div>
            <input type="text" class="form-control" id="input_Name_Main" disabled value="<?= $UserName; ?>" style="font-size: 20px;">
        </div>
    </div>
</div>

<hr>



<div class="row">
    <div class="col-md-6">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radiomenu_tab1">รับของใช้แล้ว</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radiomenu_tab2">CSSD แจ้งชำรุด</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radiomenu_tab3">อุปกรณ์ที่ถูกยกเลิก</button>
        </div>
    </div>
</div>



<div class="row " id="tab1">

    <div class="col-md-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header " style="font-weight: bold;color:black;" id="header_Detail">
                อุปกรณ์ที่ห้องตรวจใช้งาน
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12 RU_IsUsedScan2">
                        <div class="input-group mb-2">
                            <input style="font-size: 20px;" type="text" class="form-control" id="input_scan_back" placeholder="สแกนอุปกรณ์กลับ">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 ">

                        <div class="btn-group btn-group-toggle w-100" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab2">แบบแยกห้อง</button>
                            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab1">แบบรวม</button>
                        </div>

                        <!-- <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                            <label class="btn btn-light" style="border: 1px solid;font-size:25px;" id="label_tab2">
                                <input type="radio" name="options" id="radio_tab2" autocomplete="off" checked> แบบแยกห้อง
                            </label>

                            <label class="btn btn-light active" style="border: 1px solid;font-size:25px;" id="label_tab1">
                                <input type="radio" name="options" id="radio_tab1" autocomplete="off"> แบบรวม
                            </label>
                        </div> -->
                    </div>
                </div>

                <input type="text" id="input_type" value="2" hidden>
                <div class="row" style="margin-top:10px;">

                    <div class="col-md-12 " id="div_detailleft2">
                        <table class="table table-hover table-sm " id="table_detailLeft2">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" style="width: 10%;" class="text-center RU_IsUsedScan">
                                        <input type="checkbox" class="form-check-input" id="checkall_one2" style="margin-top: -25px;width: 25px;height: 20px;">
                                    </th>
                                    <th scope="col" style="width: 20%; text-align: left;" id="td_roomcheck"> ห้องตรวจ</th>
                                    <th scope="col" style="width: 10%; text-align: left;"> </th>
                                    <th scope="col" style="width: 30%; text-align: left;"></th>
                                    <th scope="col" style="width: 20%; text-align: left;"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-12 " id="div_detailleft1" hidden>
                        <table class="table table-hover table-sm " id="table_detailLeft">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" style="width: 10%;" class="text-center RU_IsUsedScan">
                                        <input type="checkbox" class="form-check-input" id="checkall_one" style="margin-top: -25px;width: 25px;height: 20px;">
                                    </th>
                                    <th scope="col" style="width: 20%; text-align: center;" id="td_itemcode">รหัสอุปกรณ์</th>
                                    <th scope="col" class="text-center" id="td_item">ชื่ออุปกรณ์</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_qty">จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>






                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn RU_IsUsedScan" hidden id="btn_senddata1" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ยืนยันรับอุปกรณ์ไปส่งล้าง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 mt-3">
        <div class="card">
            <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail2">
                ยืนยันรับอุปกรณ์ที่ห้องตรวจใช้งาน
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12 RU_IsUsedScan2">
                        <div class="input-group mb-2">
                            <input style="font-size: 20px;" type="text" class="form-control" id="input_scan" placeholder="สแกนยืนยันรับอุปกรณ์ที่ห้องตรวจใช้งาน">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                            </div>
                        </div>
                    </div>



                    <!-- <button id="upload-image">Select Image</button> -->


                    <!-- 
                    <div class="col-md-6 col-lg-6">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                            </div>
                            <input type="text" class="form-control" id="input_scan" placeholder="สแกนยืนยันรับอุปกรณ์ที่ห้องตรวจใช้งาน">
                        </div>
                    </div> -->
                </div>

                <!-- <input type="text" id="input_type" value="1" hidden> -->

                <div class="col-md-12">
                    <table class="table table-hover table-sm " id="table_detailRight">
                        <thead class="table-active">
                            <tr>
                                <th scope="col" style="width: 10%;" class="text-center RU_IsUsedScan">
                                    <!-- <input type="checkbox" class="form-check-input" id="checkall_Right" style="margin-top: -25px;width: 40px;height: 20px;"> -->
                                </th>
                                <th scope="col" style="width: 20%; text-align: center;" id="td_itemcode2">รหัสอุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_item2">ชื่ออุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_qty2">จำนวน</th>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

                <div class="row mt-3">
                    <div class="col-md-6" style="text-align: left;">
                        <button class="btn RU_IsUsedScan btn-danger" hidden id="btn_sendDataBackTab2" style="font-size:20px;color:#fff;">ลบ</button>
                    </div>
                    <div class="col-md-6" style="text-align: end;">
                        <button class="btn" id="btn_sendDataTab2" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งข้อมูลไปเมนู ส่งอุปกรณ์ N Sterile</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="row " id="tab2">
    <div class="col-md-12 col-lg-12 mt-3">
        <div class="card">
            <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail_tab2">
                CSSD แจ้งชำรุด
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-hover table-sm " id="table_detail_tab2">
                        <thead class="table-active">
                            <tr>
                                <th scope="col" style="width: 20%; text-align: center;" id="td_itemcode_tab2">รหัสอุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_item_tab2">ชื่ออุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_deproom_tab2">ห้องตรวจ</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_qty_tab2">จำนวน</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_remark_tab2">หมายเหตุ</th>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
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

<div class="row" id="tab3">
    <div class="col-md-12 col-lg-12 mt-3">
        <div class="card">
            <div class="card-header" style="font-weight: bold;color:black;" id="header_Detail_tab3">
                อุปกรณ์ที่ถูกยกเลิก
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-hover table-sm " id="table_detail_tab3">
                        <thead class="table-active">
                            <tr>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
                                <th scope="col" style="width: 20%; text-align: center;" id="td_deproom_tab3">ห้องตรวจ</th>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
                                <th scope="col" style="width: 20%;" class="text-center" id=""></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="row mt-3">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn" id="btn_sendData_Tab3" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งล้างอุปกรณ์ที่ใช้แล้ว</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_damage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แจ้งชำรุด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" id="label_damage" style="font-size: 25px;color:black;"></label>
                        <input type='number' class='form-control' id="qty_damage" style="font-size: 25px;color:black;" value="1" disabled>
                        <input type='text' class='form-control mt-2' id="remark_damage" style="font-size: 25px;color:black;" placeholder="รายละเอียด">
                        <input type='text' class='form-control' id="qty_damage_0" hidden>
                        <input type='text' class='form-control' id="department_damage" hidden>
                        <input type='text' class='form-control' id="itemcode_damage" hidden>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="btn_saveDamage">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_damage_tab3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แจ้งชำรุด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" id="label_damage_tab3" style="font-size: 25px;color:black;"></label>
                        <input type='number' class='form-control' id="qty_damage_tab3" style="font-size: 25px;color:black;">
                        <input type='text' class='form-control' id="qty_damage_0_tab3" hidden>
                        <input type='text' class='form-control' id="department_damage_tab3" hidden>
                        <input type='text' class='form-control' id="itemcode_damage_tab3" hidden>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" id="btn_saveDamage_tab3">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_Imgdamage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Imgdamage">รูปภาพชำรุด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img id="img-result" style="max-width: 400px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>