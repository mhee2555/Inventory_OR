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


<div class="row">

    <div class="col-md-3">
        <div class="form-group ">
            <label style="color:black;font-weight: 600;">วันที่</label>
            <div class="input-group">
                <input type="text" class="form-control datepicker-here f18" id="select_Sdate" data-language="en" data-date-format="dd-mm-yyyy">
                <div class="input-group-append">
                    <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group ">
            <label style="color:black;font-weight: 600;">วันที่</label>
            <div class="input-group">
                <input type="text" class="form-control datepicker-here f18" id="select_Edate" data-language="en" data-date-format="dd-mm-yyyy">
                <div class="input-group-append">
                    <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="color:black;font-size:25px;">
                แจ้งเตือนยืมของ
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm" id="table_deproom_borrow">
                    <thead c style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
                            <th scope="col" class="text-center" id="">โดนยืม HN</th>
                            <th scope="col" class="text-center" id="">HN ที่ยืม</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>