<div>

    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_roomcheck">ห้องตรวจ</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="" style="font-size: 20px;">
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="" style="font-size: 20px;">
            </div>
        </div>
    </div>

</div>


<div class="row mt-2">
    <div class=" col-md-12 col-lg-9">
        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: bold;" id="radio_active">Active</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: bold;" id="radio_inactive">InActive</button>
        </div>
    </div>
</div>


<hr>

<div id="active">

    <div class="row mt-2">
        <div class=" col-md-12 col-lg-9">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: bold;" id="radio_sud">อุปกรณ์ SUDs</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: bold;" id="radio_sterile">อุปกรณ์ Sterile</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-8">

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label" style="color:black;">ค้นหาชื่ออุปกรณ์</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="" placeholder="ค้นหาชื่ออุปกรณ์">
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-12 mt-3">

                    <div class="card">

                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table_receive_stock">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                        <th scope="col" class="text-center" id="">รายการ</th>
                                        <th scope="col" class="text-center" id="">#</th>
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
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-4 col-form-label" style="color:black;">สแกน QR Code</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="" placeholder="สแกน QR Code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                        <button class="btn f18" style="background-color: #ed1c24;color:#fff;">ลบ</button>
                                </div>

           


                            </div>


                            <table class="table table-hover table-sm" id="table_receive_stock_item">
                                <thead style="background-color: #cdd6ff;">
                                    <tr>
                                        <th scope="col" class="text-center" id="">#</th>
                                        <th scope="col" class="text-center" id="">รหัสรายการ</th>
                                        <th scope="col" class="text-center" id="">UseCount</th>
                                        <th scope="col" class="text-center" id="">หมดอายุ</th>
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
    </div>

</div>

<div id="inactive">

</div>