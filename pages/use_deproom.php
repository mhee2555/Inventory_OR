<div>
    <div class="row">
        <div class="col-sm-4 col-md-4 mt-3">
        </div>
        <div class=" col-sm-4 col-md-4 col-lg-4 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_roomcheck">สิทธิ์การเข้าใช้งาน</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_username">ชื่อผู้ใช้งาน</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>
    </div>
</div>





<div class="row mt-3">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-10">
                <select class="form-control f18" id="select_item"></select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block f18" id="btn_searchItem" style="background-color:#004aad;color:#fff;">ค้นหา</button>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>


<div id="row_B" class="mt-3">

</div>

<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="color:black;font-weight:bold;" id="deproomshow"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


            <div class="row" id="row_table">
                        <!-- <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group ">
                                                        <label style="color:black;font-size: 16px;">HN : </label>
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group ">
                                                        <label  style="color:black;font-size: 16px;">เวลา :</label>
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group ">
                                                        <label  style="color:black;font-size: 16px;">หัตถการ :</label>
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group ">
                                                        <label style="color:black;font-size: 16px;">แพทย์ :</label>
                                                            <input type="password" class="form-control" id="" placeholder="" disabled style="border-radius: 0px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-12 col-form-label f18" style="color:#00a73e;font-weight:bold;">บันทึกใช้กับคนไข้แล้ว</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <i class="fa-solid fa-caret-up" style="font-size:40px;cursor:pointer;color:black;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-hover table-sm" id="table_deproom_DocNo_pay">
                                                <thead style="background-color: #cdd6ff;">
                                                    <tr>
                                                        <th scope="col" class="text-center" id="">ลำดับ</th>
                                                        <th scope="col" class="text-center" id="">ประเภท</th>
                                                        <th scope="col" class="text-center" id="">รหัสอุปกรณ์ N-Sterile</th>
                                                        <th scope="col" class="text-center" id="">รายการอุปกรณ์</th>
                                                        <th scope="col" class="text-center" id="">จำนวน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modaldetail_searchitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:black;font-weight:bold;" id="header_item"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table table-hover table-sm" id="modal_table_detail_searchitem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="td_deproom1" style="width: 40%;">ห้องผ่าตัด</th>
                            <th scope="col" class="text-center" id="td_deproom2">จำนวน HN (คน)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>