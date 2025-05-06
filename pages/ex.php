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



<div class="card-body">


    <div class="row mb-3">
        <div class="col-md-12 text-left">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="width: 250px;border: 1px solid;font-size: 24px;font-weight: 600;" id="radio_tab1">ทั้งหมด</button>
                <button type="button" class="btn btn-light" style="width: 250px;border: 1px solid;font-size: 24px;font-weight: 600;" id="radio_tab2">อุปกรณ์ใกล้หมดอายุ</button>
                <button type="button" class="btn btn-light" style="width: 250px;border: 1px solid;font-size: 24px;font-weight: 600;" id="radio_tab3">อุปกรณ์หมดอายุ</button>
            </div>
        </div>


        <div class="col-md-6 mt-3" id="col_sendsterile" >
            <div class="row">
                <div class="col-md-4 text-center">

                    <div class="input-group mb-2">
                        <input type="text" class="form-control f18" id="input_scanexpire" placeholder="สแกนอุปกรณ์" inputmode='none' style="border-right-style: none;" autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text" style="cursor: pointer;background-color: white;" id="qr_use_main"><i class="fa-solid fa-qrcode"></i></div>
                        </div>
                    </div>


                </div>

                <div class="col-md-4 text-center">

                    <div class="input-group mb-2">
                        <input type="text" class="form-control f18" id="input_return_ex" autocomplete="off" placeholder="สแกนอุปกรณ์กลับ" inputmode='none' style="border-color:red;border-right-style: none;">
                        <div class="input-group-append">
                            <div class="input-group-text" style="cursor: pointer;background-color: white;border-color:red;" id="qr_stock_back"><i class="fa-solid fa-qrcode"></i></div>
                        </div>
                    </div>

                </div>

                <div class="col-md-3 text-center">
                    <button class="btn btn-block f18" id="btn_sendNSterile" style="background-color: #643695;color:#fff;">ส่งไป N-Sterile</button>
                    <a href="pages/send-n-sterile.php" class="btn btn-primary" id="btn_send" hidden>cc</a>

                </div>
            </div>

        </div>
    </div>





    <div class="col-md-12 mt-3" id="table_ex">
        <input type="text" id="check_ex" hidden>
        <table class="table table-hover table-sm " id="table_data">
            <thead class="table-active">
                <tr>
                    <!-- <th scope="col" class="text-center" style="width: 20%;"></th> -->
                    <th scope="col" style="width: 10%;" class="text-center" id="td_no">ลำดับ</th>
                    <th scope="col" class="text-center" id="td_usage">รหัสอุปกรณ์</th>
                    <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                    <th scope="col" class="text-center" id="td_ex">วันหมดอายุ</th>
                    <th scope="col" class="text-center" id="td_qty">จำนวน</th>
                    <th scope="col" class="text-center" id="td_status">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr> 
                                <td class="text-center "></td>
                                <td class="text-center"><label >${kay + 1}</label></td>
                                <td class="text-center"><label >${value.UsageCode}</label></td>
                                <td class="text-left"><label >${value.itemname}</label></td>
                                <td class="text-center"><label >${value.ExpireDate}</label</td>
                                <td class="text-center"><label >${value.Qty}</label</td>
                                <td class="text-center"><label ${color}>${value.IsStatus}</label</td>
                                </tr> -->
            </tbody>
        </table>

        <table class="table table-hover table-sm " id="table_data2" hidden>
            <thead class="table-active">
                <tr>
                    <th scope="col" style="width: 10%;" class="text-center" id="td_no2">ลำดับ</th>
                    <th scope="col" class="text-center" id="td_usage2">รหัสอุปกรณ์</th>
                    <th scope="col" class="text-center" id="td_item2">อุปกรณ์</th>
                    <th scope="col" class="text-center" id="td_ex2">วันหมดอายุ</th>
                    <th scope="col" class="text-center" id="td_qty2">จำนวน</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>