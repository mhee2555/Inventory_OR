<div>




    <div class="container-fluid">
        <div class="row justify-content-end mt-3">
            <div class="col-auto">
                <div class="input-group" style="background-color: #f1f3fb; border-radius: 10px; border: 1px solid #dce0eb; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"
                            style="border: none; background-color: white; font-weight: bold; border-right: 1px solid #dce0eb;">
                            สิทธิ์การเข้าใช้งาน :
                        </span>
                    </div>
                    <input type="text" class="form-control font-weight-bold"
                        id="input_Deproom_Main" disabled
                        style="background-color: #f1f3fb; border: none; color: #000;">
                </div>
            </div>

            <div class="col-auto ml-2">
                <div class="input-group" style="background-color: #f1f3fb; border-radius: 10px; border: 1px solid #dce0eb; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"
                            style="border: none; background-color: white; font-weight: bold; border-right: 1px solid #dce0eb;">
                            ชื่อผู้ใช้งาน :
                        </span>
                    </div>
                    <input type="text" class="form-control font-weight-bold"
                        id="input_Name_Main" disabled
                        style="background-color: #f1f3fb; border: none; color: #000;">
                </div>
            </div>
        </div>
    </div>


</div>

<hr>



<div class="row mt-3">
    <div class=" col-md-12 col-lg-9  ">

        <div class="tab-button-group">
            <button class="tab-button active" id="radio_oc">Occurrence Tracking</button>
            <button class="tab-button" id="radio_tracking">ติดตามอุปกรณ์</button>
        </div>

        <!-- <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_oc">Occurrence Tracking</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;border-color: lightgray;" id="radio_tracking">ติดตามอุปกรณ์</button>
        </div> -->
    </div>
</div>

<div id="row_oc">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>

        <div class="col-md-3">
            <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
            <select class="form-control f18" id="select_typeItem"></select>
        </div>

        <div class="col-md-3">
            <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
            <input type="text" class="form-control  f18" id="input_search_request" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์">
        </div>


        <div class="col-md-12 mt-2">
            <table class="table table-hover " id="table_oc">
                <thead c style="background-color: #cdd6ff;">
                    <tr>
                        <th scope="col" class="text-center" id="">อุปกรณ์</th>
                        <th scope="col" class="text-center" id="">Serial อุปกรณ์</th>
                        <th scope="col" class="text-center" id="">Lot.อุปกรณ์</th>
                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                        <th scope="col" class="text-center" id="">HN Code/เลขที่กล่อง</th>
                        <th scope="col" class="text-center" id="">สถานะ</th>
                        <th scope="col" class="text-center" id="">หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div id="row_tracking">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">

                <div class="col-md-6">
                    <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
                    <select class="form-control f18" id="select_typeItem_tracking"></select>
                </div>

                <div class="col-md-6">
                    <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control  f18" id="input_search_tracking" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์">
                </div>


                <div class="col-md-12 mt-2">
                    <table class="table table-hover " id="table_item_tracking">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">ประเภท</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="col-md-6">
            <div class="form-row align-items-end flex-wrap">


                <div class="col-md-6">
                    <label style="color:black;font-weight: 600;">Lot</label>
                    <input type="text" class="form-control  f18" id="input_search_lot_tracking" placeholder="ค้นหา Lot. อุปกรณ์">
                </div>

                <div class="col-md-6 text-right">
                    <label style="color:rgb(100, 54, 149);font-weight: 600;" id="text_itemname"></label>
                </div>



            </div>



            <table class="table table-hover " id="table_lot_tracking">
                <thead c style="background-color: #cdd6ff;">
                    <tr>
                        <th scope="col" class="text-center" id="">Lot. อุปกรณ์</th>
                        <th scope="col" class="text-center" id="">จำนวน</th>
                        <th scope="col" class="text-center" id="">#</th>
                        <th scope="col" class="text-center" id=""></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


        </div>
        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>

                <div class="col-md-3">
                    <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control  f18" id="input_search_lot_detail" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์">
                    <input type="text" class="form-control  f18" id="input_lot_detail" hidden>
                    <input type="text" class="form-control  f18" id="input_lot_itemcode_detail" hidden>
                </div>


                <div class="col-md-12 mt-2">
                    <table class="table table-hover " id="table_lot_detail">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">Serial อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">Lot.อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">HN Code/เลขที่กล่อง</th>
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




<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>