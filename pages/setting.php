<div>





    <div class="row">
        <div class=" col-md-12 col-lg-9  ">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_openconfig">เปิด/ปิดการแสดงผล</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;" id="radio_master">จัดการข้อมูล Master</button>
            </div>
        </div>
    </div>
</div>

<hr>


<div id="openconfig">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover " id="">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" id="" style="background-color: #fff;border: 0px;"></th>
                        <th scope="col" class="text-center" id="" colspan="4" style="background-color: #004aad;border: 0px;color:#fff !important;border-top-left-radius: 25px;border-top-right-radius: 25px;">N-Sterile</th>
                        <th scope="col" class="text-center" id="" colspan="2" style="background-color: #004aad;border: 0px;color:#fff !important;border-top-left-radius: 25px;border-top-right-radius: 25px;">OR</th>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">เมนู</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">User</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">Admin</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">SP</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">MA</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">คลัง</th>
                        <th scope="col" class="text-center" id="" style="background-color: #cdd6ff;">ห้องผ่าตัด</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="master">

    <div class="row mb-3">
        <div class="col-md-6">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: 600;" id="radio1_edit_doctor">เพิ่มแพทย์</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: 600;" id="radio1_edit_Procedure">เพิ่มหัตถการ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: 600;" id="radio1_edit_deproom">เพิ่มห้องผ่าตัด</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: 600;" id="radio1_edit_user">เพิ่มUser</button>
            </div>
        </div>
    </div>


    <div class="mt-3" id="doctor">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_adddoctor_tab3" style="font-size: 25px;color:black;">เพิ่มแพทย์</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="input_doctorth_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_doctoren_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_doctorcode_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDdoctor_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearDoctor_tab3" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn btn-primary" id="btn_saveDoctor_tab3" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailDoctorTab3">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_number_tab3" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameth_tab3">ชื่อแพทย์ไทย</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameen_tab3">ชื่อแพทย์อังกฤษ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_doctorcode_tab3">รหัสแพทย์</th>
                                    <th scope="col" style="width: 20%;" class="text-center">#</th>
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
    <div class="mt-3" id="Procedure">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addProcedure_tab3" style="font-size: 25px;color:black;">เพิ่มหัตถการ</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_Procedure_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDProcedure_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearProcedure_tab3" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveProcedure_tab3" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailProcedureTab3">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberPro_tab3" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameProcedure_tab3">รหัสแพทย์</th>
                                    <th scope="col" style="width: 20%;" class="text-center">#</th>
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
    <div class="mt-3" id="deproom">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addDeproom_tab3" style="font-size: 25px;color:black;">เพิ่มห้องผ่าตัด</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomNameTH_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomNameEN_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomNameSub_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <select name="" id="input_DeproomFloor_tab3" class="form-control select2" style="font-size:20px;">
                                    <option value="1">ชั้น 2</option>
                                    <option value="2">ชั้น 3</option>
                                </select>
                                <!-- <input type="number" class="form-control" id="input_DeproomFloor_tab3" autocomplete="off" style="font-size: 20px;"> -->
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDDeproom_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="font-size: 25px;color:black;" id="radio_statusDeproom">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12 mt-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="font-size: 25px;color:black;" id="radio_typeDeproom">ประเภท</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_typeDeproom" id="radio_typeDeproom1" checked>ห้องผ่าตัด
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_typeDeproom" id="radio_typeDeproom2">คลัง
                                            </label>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearDeproom_tab3" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveDeproom_tab3" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailDeproomTab3">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberdep_tab3" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_namethdep_tab3">ห้องผ่าตัดไทย</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameendep_tab3">ห้องผ่าตัดอังกฤษ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_floordep_tab3">ชั้น</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_statusdep_tab3">สถานะ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_typedep_tab3">ประเภท</th>
                                    <th scope="col" style="width: 20%;" class="text-center">#</th>
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
    <div class="mt-3" id="user">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addUser_tab3" style="font-size: 25px;color:black;">เพิ่ม User</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight:600;">รหัสพนักงาน</label>
                                    <input type="text" class="form-control" id="input_empcodeUser_tab3" autocomplete="off" style="font-size: 20px;">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight:600;">ชื่อ</label>
                                    <input type="text" class="form-control" id="input_nameUser_tab3" autocomplete="off" style="font-size: 20px;">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight:600;">นามสกุล</label>
                                    <input type="text" class="form-control" id="input_lastUser_tab3" autocomplete="off" style="font-size: 20px;">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight:600;">UserName</label>
                                    <input type="text" class="form-control" id="input_userName_tab3" autocomplete="off" style="font-size: 20px;">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="form-group">
                                    <label for="" style="color:black;font-weight:600;">Password</label>
                                    <input type="text" class="form-control" id="input_passWord_tab3" autocomplete="off" style="font-size: 20px;">
                                    </div>
                            </div>
                            <div class="col-md-12 mt-2" hidden>
                                <input type="text" class="form-control" id="input_IDUser_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-3 mt-2">

                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="" style="font-size: 18px;color:black;" id="radio_statusUser">สถานะ</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 18px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 18px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-3 mt-3">

                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="" style="font-size: 18px;color:black;" id="radio_roleUser">Role</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 18px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser1" checked>CSSD & DSS
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 18px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser2">Dental Room
                                            </label>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearUser_tab3" style="font-size:20px;">รีเซ็ตข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveUser_tab3" style="color: #fff;background: #1570EF;font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailUserTab3">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberuser_tab3" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_empuser_tab3">รหัสพนักงาน</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameuser_tab3">ชื่อ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_lastuser_tab3">นามสกุล</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_username_tab3">Username</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_password_tab3">Password</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_statususer_tab3">สถานะ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_roleuser_tab3">Role</th>
                                    <th scope="col" style="width: 20%;" class="text-center">#</th>
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