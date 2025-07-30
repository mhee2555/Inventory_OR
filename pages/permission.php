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



<div class=" mt-4">
    <form>
        <div class="form-group row">
            <label for="selectUser" class="col-sm-2 col-form-label f18" style="color:black;">กรุณาเลือกชื่อ :</label>
            <div class="col-sm-4">
                <select class="form-control f18" id="selectUser">
                    <option>กรุณาเลือก</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label f18" style="color:black;">ชื่อ :</label>
            <div class="col-sm-10 col-form-label f18">
                 <label for="" id="name_users" class="f18" style="color:black;"></label>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label f18" style="color:black;">สังกัด :</label>
            <div class="col-sm-10 col-form-label f18">
                 <label for="" id="permission_users" class="f18" style="color:black;"></label>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label f18" style="color:black;">สิทธิ์ :</label>
            <div class="col-sm-10 col-form-label f18">
                 <label for="" id="admin_users" class="f18" style="color:black;"></label>
            </div>
        </div>

        <input type="text" id="input_userID" hidden>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="f18" style="background-color: rgb(100, 54, 149);">
                    <th style="color:#fff !important;" class="text-center">เมนู</th>
                    <th style="color:#fff !important;" class="text-center">กำหนดสิทธิการเข้าถึง</th>
                </tr>
            </thead>
            <tbody >
                <tr class="f18">
                    <td>หน้าหลัก</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="main" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>รับอุปกรณ์เข้าคลัง</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="recieve_stock" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>สร้างใบขอเบิกอุปกรณ์</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="create_request" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>ขอเบิกอุปกรณ์</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="request_item" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>กรอกผู้ป่วย</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="set_hn" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>จ่ายอุปกรณ์</td>
                    <td class="text-center"><input type="checkbox" style="width: 50px;height: 30px;" id="pay" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>สืบค้นข้อมูล HN</td>
                    <td class="text-center"><input type="checkbox" style="width: 50px;height: 30px;" id="hn" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>ความเคลื่อนไหว</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="movement" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>จัดการข้อมูลระบบ</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="manage" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>รายงาน</td>
                    <td class="text-center"><input type="checkbox" style="width: 50px;height: 30px;" id="report" class="clear_checkbox"></td>
                </tr>
                <tr>
                    <td>กำหนดสิทธิการเข้าถึง</td>
                    <td class="text-center"><input type="checkbox"  style="width: 50px;height: 30px;" id="permission" class="clear_checkbox"></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>