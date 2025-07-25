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



    <div class="row">
        <div class=" col-md-12 col-lg-9  ">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width: 200px;" id="radio_search">ค้นหา</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width: 200px;" id="radio_stock_item">คลังและอุปกรณ์</button>
            </div>
        </div>
    </div>
</div>

<hr>
<!--  -->
<div id="search">
    <div class="row">
        <div class="col-md-11">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">คลัง</label>
                        <input type="text" class="form-control" id="input_stock" placeholder="คลัง">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;font-weight: 600;">สถานที่เก็บ</label>
                        <input type="text" class="form-control" id="input_LocationStock" placeholder="สถานที่เก็บ">
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;">ชั้น</label>
                        <input type="text" class="form-control" id="input_floor" placeholder="ชั้น">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" style="color:black;">แถว</label>
                        <input type="text" class="form-control" id="input_row" placeholder="แถว">
                    </div>
                </div> -->

            </div>
        </div>
        <div class="col-md-1">
            <input type="text" id="check_edit" value='0' hidden>
            <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top:30px;" onclick="Save_store();">บันทึก</button>
        </div>
    </div>

    <div class="row mt-3" id="">
        <table class="table table-hover " id="table_store">
            <thead style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" style="width: 10%;" id="">ลำดับ</th>
                    <th scope="col" class="text-center" id="">คลัง</th>
                    <th scope="col" class="text-center" id="">#</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" style="color:black;font-weight: 600;">สถานที่เก็บ</label>
                                <input type="text" class="form-control" id="input_search_location" placeholder="สถานที่เก็บ" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" style="color:black;font-weight: 600;">ชั้น</label>
                                <input type="text" class="form-control" id="input_search_floor" placeholder="ชั้น">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" style="color:black;font-weight: 600;">แถว</label>
                                <input type="text" class="form-control" id="input_search_row" placeholder="แถว">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;margin-top:36px;" onclick="Save_store_location();">บันทึก</button>
                </div>
            </div>

            <div class="row mt-3" id="">
                <table class="table table-hover " id="table_store_detail">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="" style="width: 10%;">ลำดับ</th>
                            <th scope="col" class="text-center" id="" style="width: 50%;">คลัง</th>
                            <th scope="col" class="text-center" id="" style="width: 10%;">สถานที่จัดเก็บ</th>
                            <th scope="col" class="text-center" id="" style="width: 10%;">ชั้นที่</th>
                            <th scope="col" class="text-center" id="" style="width: 10%;">แถว</th>
                            <th scope="col" class="text-center" id="" style="width: 10%;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>

<div id="stock_item">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="" style="color:black;font-weight: 600;">คลัง</label>
                <select class="form-control" id="select_stock_item"></select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="" style="color:black;font-weight: 600;">สถานที่เก็บ</label>
                <select class="form-control" id="select_location_item"></select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="" style="color:black;font-weight: 600;">ชั้น/แถว</label>
                <select class="form-control" id="select_location_floor"></select>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                        <span style="font-weight: 600;color:black;" class="f24">รายการเครื่องมือ</span>
                            
                        </div>
                        <div class="col-md-6 text-right">
                            <select class="form-control" id="select_type_item">
                                <option value="">เลือกทั้งหมด </option>
                                <option value="42">SUDs</option>
                                <option value="43">Implant</option>
                                <option value="44">Sterile</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn f18 btn-block" style="background-color: #5271ff;color:#fff;" id="btn_save_item">บันทึก</button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="text" class="form-control" placeholder="รายการอุปกรณ์" id="input_search_item">
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-hover " id="table_item">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รายการอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์ N-Sterile</th>
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
                    <div class="row">
                        <div class="col-md-12">
                        <span style="font-weight: 600;color:black;" class="f24">รายการคลัง</span>
                            
                        </div>
                        <div class="col-md-10 mt-2">
                            <input type="text" class="form-control" id="input_search_item_store" placeholder="รายการอุปกรณ์">
                        </div>
                        <!-- <div class="col-md-2" >
                            <button class="btn f18 btn-block" style="background-color: #004aad;color:#fff;margin-top: 9px;" id="btn_switch_item">บันทึก</button>
                        </div> -->
                        <div class="col-md-2">
                            <button class="btn f18 btn-block" style="background-color: #ed1c24;color:#fff;margin-top: 9px;" id="btn_delete_item">ลบ</button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-hover " id="table_item_store">
                        <thead style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รายการอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">ประเภทอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">คลัง</th>
                                <th scope="col" class="text-center" id="">ชั้นที่</th>
                                <th scope="col" class="text-center" id="">แถว</th>
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