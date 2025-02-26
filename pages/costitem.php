<div>

    <div class="row">
        <div class="col-md-6">
            <h1 class="h3  mt-4" id="text_rutine1" style="color:black;">ต้นทุนอุปกรณ์ทันตกรรม</h1>
            <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_rutine2"> ตั้งค่าการจ่ายอุปกรณ์ให้ห้องตรวจ</a> -->
            <!-- <p style="margin-bottom: 0rem;color:black;" id="text_rutine3">ต้นทุนอุปกรณ์ทันตกรรม</p> -->
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;" id="lang_text_roomcheck">ห้องตรวจ</div>
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
</div>


<hr>

<div class="row">
    <div class="col-md-6">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;width:100px;" id="radio_active">Active</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;width:100px;" id="radio_inactive">InActive</button>
        </div>

        <input type="text" hidden id="check_active" value="0">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-sm" id="table_item">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width: 5%;" class="text-center" class="text-center" id="td_no">ลำดับ</th>
                            <th scope="col" style="width: 20%;" class="text-center" id="td_item">รายการ</th>
                            <th scope="col" style="width: 20%;" class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <label id="text_itemname" style="font-size: 25px;color:black;font-weight:bold;"></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" style="color:black;font-size:25px;" id="text_cost1">ต้นทุนการ Sterile</label>
                        <input type="text" class="form-control" id="input_costprice" autocomplete="off" style="font-size: 20px;" disabled>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="" style="color:black;font-size:25px;" id="text_cost2">ต้นทุนอุปกรณ์ใหม่</label>
                        <input type="text" class="form-control" id="input_costnewitem" autocomplete="off" style="font-size: 20px;">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="" style="color:black;font-size:25px;" id="text_cost3">บริษัทที่สั่งซื้อ</label>
                        <input type="text" class="form-control" id="input_vendors" autocomplete="off" style="font-size: 20px;">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="" style="color:black;font-size:25px;" id="text_cost4">ประเภทของรายการ</label>
                        <br>
                        <div class="form-check-inline">
                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                <input type="radio" class="form-check-input" name="radio_vendors" id="radio_vendors_1">
                                <label id="radio_vendors_1_text">ยืมบริษัท</label>
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                <input type="radio" class="form-check-input" name="radio_vendors" id="radio_vendors_2" checked>
                                <label id="radio_vendors_2_text">radio_vendors_2</label>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="" style="color:black;font-size:25px;" id="text_cost5">สถานะ</label>
                        <br>
                        <div class="form-check-inline">
                            <label class="form-check-label" style="font-size: 25px;color:black;" >
                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom1">
                                <label id="radio_statusDeproom1_text">Active</label>
                                
                                
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" style="font-size: 25px;color:black;" >
                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom2">
                                <label id="radio_statusDeproom2_text">InActive</label>
                                
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3" hidden>
                        <input type="text" class="form-control" id="input_itemcode_hidden" autocomplete="off" style="font-size: 20px;">
                    </div>
                    <div class="col-md-12 mt-3 text-right">
                        <button type="button" class="btn" id="btn_clear" style="font-size:20px;">ล้างข้อมูล</button>
                        <button type="button" class="btn btn-primary" id="btn_save" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">บันทึก</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>