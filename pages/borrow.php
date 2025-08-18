



<div class="row">

    <div class="col-md-3">
        <div class="form-group ">
            <label style="color:black;font-weight: 600;">วันที่</label>

            <div class="position-relative">
                <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_Sdate" data-language='en' data-date-format='dd-mm-yyyy'>
                <span class="input-icon">
                    <i class="fa-solid fa-calendar" style="color:black;"></i>
                </span>
            </div>


        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group ">
            <label style="color:black;font-weight: 600;">วันที่</label>

            <div class="position-relative">
                <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_Edate" data-language='en' data-date-format='dd-mm-yyyy'>
                <span class="input-icon">
                    <i class="fa-solid fa-calendar" style="color:black;"></i>
                </span>
            </div>

        </div>
    </div>


    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="color:black;font-size:25px;">
                แจ้งเตือนยืมของ
            </div>
            <div class="card-body">
                <table class="table table-hover" id="table_deproom_borrow">
                    <thead c style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">รหัสอุปกรณ์</th>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
                            <th scope="col" class="text-center" id="">เลขผู้ป่วยเดิม</th>
                            <th scope="col" class="text-center" id="">เลขผู้ป่วยใหม่</th>
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