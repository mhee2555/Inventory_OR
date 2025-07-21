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