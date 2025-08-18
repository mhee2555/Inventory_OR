


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="color:black;font-size:25px;">
                ห้องผ่าตัดส่งคืนอุปกรณ์
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm" id="table_deproom_nouse">
                    <thead c style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                            <th scope="col" class="text-center" id="">จำนวน</th>
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
            <div class="card-header" style="color:black;font-size:25px;" >
            <div class="row">
                    <div class="col-md-6">
                        <span id="text_showdeproom"></span>
                    </div>
                    <div class="col-md-6" hidden>
                    <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_Date" data-language="en" data-date-format="dd-mm-yyyy" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm" id="table_deproom_nouse_bydeproom">
                    <thead c style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">HN</th>
                            <th scope="col" class="text-center" id="">หัตถการ</th>
                            <th scope="col" class="text-center" id="">จำนวนอุปกรณ์</th>
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

<div class="modal fade" id="modal_returnstock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:black;font-size:25px;">คลังห้องผ่าตัดตรวจรับอุปกรณ์คืนจากห้องผ่าตัด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-5">
                        <div class="form-group ">

                            <label for="" class=" col-form-label pt-0" style="color:black;">HN Number</label>
                            <input type="text" class="form-control f18" id="text_hnshow" placeholder="" autocomplete="off" disabled>
                        </div>



                    </div>

                    <div class="col-md-7">
                        <div class="form-group ">
                            <label for="" class=" col-form-label pt-0" style="color:black;">สแกนรหัสอุปกรณ์เพื่อรับกลับเข้าคลัง</label>
                            <input type="text" class="form-control f18" id="input_scan_return" placeholder="" autocomplete="off">
                        </div>
                    </div>


                    <table class="table table-hover table-sm" id="table_item_byDocNo">
                        <thead c style="background-color: #cdd6ff;">
                            <tr>
                                <th scope="col" class="text-center" id="">#</th>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">อุปกรณ์</th>
                                <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" style="background-color: #004aad;color:#fff;" id="btn_save_Return">ยืนยันรับเข้าคลัง</button>
            </div>
        </div>
    </div>
</div>

<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>