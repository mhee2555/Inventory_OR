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
                    <td>กรอกคนไข้</td>
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