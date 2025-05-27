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

<hr>



<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_request">ขอเบิกอุปกรณ์</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_receive">รับอุปกรณ์เข้าคลัง</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_history">ประวัติอุปกรณ์</button>
        </div>
    </div>
</div>

<div id="row_request">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
                    <select class="form-control f18" id="select_typeItem_request"></select>
                </div>

                <div class="col-md-4">
                    <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control  f18" id="input_search_request" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์">
                </div>


                <div class="col-md-12 mt-2">
                    <table class="table table-hover table-sm" id="table_item_request">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">Min</th>
                                <th scope="col" class="text-center" id="">คงเหลือ</th>
                                <th scope="col" class="text-center" id="">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_request">ยืนยัน</button>
                </div>
            </div>


        </div>
        <div class="col-md-6">

            <input type="text" id="input_docnoRQ" hidden>
            <div class="row" style="margin-top: 4.6rem !important;">
                <div class="col-md-12 mt-2">
                    <table class="table table-hover table-sm" id="table_rq">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 text-right mt-2">
                    <button class="btn f18" id="btn_clear_request">ล้างข้อมูล</button>
                    <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_send_request">สร้างใบขอซื้อ</button>
                </div>

            </div>
        </div>
    </div>


</div>

<div id="row_receive">

</div>

<div id="row_history">

</div>




<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>