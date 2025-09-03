<div class="row mb-3 mt-3">
    <div class="col-md-6 text-left">

        <div class="tab-button-group">
            <button class="tab-button " id="radio_tab1">ทั้งหมด</button>
            <button class="tab-button" id="radio_tab2">อุปกรณ์ใกล้หมดอายุ</button>
            <button class="tab-button" id="radio_tab3">อุปกรณ์หมดอายุ</button>
        </div>

        <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_tab1">ทั้งหมด</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_tab2">อุปกรณ์ใกล้หมดอายุ</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio_tab3">อุปกรณ์หมดอายุ</button>
            </div> -->
    </div>


    <div class="col-md-6 mt-3 text-right" id="col_sendsterile">
        <div class="row">


            <div class="col-md-5 text-center">

                <select name="" id="select_cut_itemex" class="form-control">
                    <option value="">กรุณาเลือกประเภทการสแกน</option>
                    <option value="1">สแกนตัดออกจากระบบ</option>
                    <option value="2">สแกนตัดออกจากระบบ2</option>
                </select>

            </div>

            <div class="col-md-5 text-center">

                <div class="input-group mb-2">
                    <input type="text" class="form-control f18" id="input_scanexpire" placeholder="สแกนอุปกรณ์" inputmode='none' style="border-right-style: none;" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text" style="cursor: pointer;background-color: white;" id="qr_use_main"><i class="fa-solid fa-qrcode"></i></div>
                    </div>
                </div>


            </div>

            <div class="col-md-2 text-center">
                <button class="btn btn-block f18" id="btn_sendNSterile" style="background-color: #643695;color:#fff;">ส่งข้อมูล</button>
                <a href="pages/send-n-sterile.php" class="btn btn-primary" id="btn_send" hidden>cc</a>

            </div>
        </div>

    </div>






    <div class="col-md-12 mt-3" id="table_ex">
        <input type="text" id="check_ex" hidden>
        <table class="table table-hover  " id="table_data">
            <thead class="table-active">
                <tr>
                    <th scope="col" class="text-center" style="width: 20%;"></th>
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


    </div>

</div>