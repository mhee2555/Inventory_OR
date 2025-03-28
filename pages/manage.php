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

<div class="row mb-3 mt-4">
        <div class="col-md-6">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button"  class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio1">เพิ่มแพทย์</button>
                <button type="button"  class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio2">เพิ่มหัตถการ</button>
                <button type="button"  class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio3">เพิ่มห้องผ่าตัด</button>
                <button type="button"  class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="radio4">เพิ่ม User</button>
            </div>
        </div>
    </div>


    <div class="mt-3" id="row_doctor">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_adddoctor" style="color:black;">เพิ่มแพทย์</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="input_doctorth" autocomplete="off" placeholder="ชื่อแพทย์ ภาษาไทย" >
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDdoctor" autocomplete="off" >
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_statusDoctor">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDoctor" id="radio_statusDoctor1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDoctor" id="radio_statusDoctor2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearDoctor" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn btn-primary" id="btn_saveDoctor" style="color: #fff;background-color: #1570EF;color:#fff;font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailDoctor">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_number" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="">ชื่อแพทย์</th>
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
    <div class="mt-3" id="row_procedure">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addProcedure" style="color:black;">เพิ่มหัตถการ</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_Procedure" autocomplete="off" placeholder="หัตถการ">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDProcedure" autocomplete="off" >
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_statusProcedure">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusProcedure" id="radio_statusProcedure1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusProcedure" id="radio_statusProcedure2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearProcedure" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveProcedure" style="color: #fff;background-color: #1570EF;color:#fff;font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailProcedure">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberPro" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameProcedure">หัตถการ</th>
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
    <div class="mt-3" id="row_deproom">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addDeproom" style="color:black;">เพิ่มห้องตรวจ</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomNameTH" autocomplete="off" placeholder="ชื่อห้อง ไทย">
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomNameEN" autocomplete="off" placeholder="ชื่อห้อง อังกฤษ">
                            </div>
                            <div class="col-md-12 mt-3">
                                <select name="" id="input_DeproomFloor" class="form-control" style="font-size:20px;">
                                </select>
                                <!-- <input type="number" class="form-control" id="input_DeproomFloor" autocomplete="off" > -->
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDDeproom" autocomplete="off" >
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_statusDeproom">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusDeproom" id="radio_statusDeproom2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3" hidden>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_typeDeproom">ประเภท</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_typeDeproom" id="radio_typeDeproom1" checked>ห้องตรวจ
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_typeDeproom" id="radio_typeDeproom2">คลัง
                                            </label>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearDeproom" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveDeproom" style="color: #fff;background-color: #1570EF;color:#fff;font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailDeproom">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberdep" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_namethdep">ห้องตรวจไทย</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameendep">ห้องตรวจอังกฤษ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_floordep">ชั้น</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_statusdep">สถานะ</th>
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
    <div class="mt-3" id="row_users">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addUser" style="color:black;">เพิ่ม User</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_empcodeUser" autocomplete="off"  placeholder="รหัสพนักงาน">
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_nameUser" autocomplete="off" placeholder="ชื่อ">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_lastUser" autocomplete="off" placeholder="นามสกุล">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_userName" autocomplete="off" placeholder="UserName">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_passWord" autocomplete="off" placeholder="Password">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDUser" autocomplete="off" >
                            </div>
                            <div class="col-md-12 mt-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_statusUser">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12 mt-3" hidden>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="color:black;" id="radio_roleUser">Role</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser1" checked>CSSD & DSS
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser2">Dental Room
                                            </label>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearUser" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveUser" style="color: #fff;background-color: #1570EF;color:#fff;font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="table_detailUser">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" id="td_numberuser" class="text-center" class="text-center">ลำดับ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_empuser">รหัสพนักงาน</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameuser">ชื่อ</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_lastuser">นามสกุล</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_username">Username</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_password">Password</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_statususer">สถานะ</th>
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
