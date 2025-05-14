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
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="manage">จัดการข้อมูลระบบ</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="mapping">Data Mapping</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="routine">จัดการ routine</button>
        </div>
    </div>
</div>


<div id="row_manage">

    <div class="row mb-3 mt-4">
        <div class="col-md-6">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio1">เพิ่มแพทย์</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio2">เพิ่มหัตถการ</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio3">เพิ่มห้องผ่าตัด</button>
                <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;border-color: lightgray;" id="radio4">เพิ่ม User</button>
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
                                <input type="text" class="form-control" id="input_doctorth" autocomplete="off" placeholder="ชื่อแพทย์ ภาษาไทย">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDdoctor" autocomplete="off">
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
                                <button type="button" class="btn" id="btn_clearDoctor" style="border-color:gray;color:black;font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn btn-primary" id="btn_saveDoctor" style="color: #fff;background-color: #643695;color:#fff;font-size:20px;">บันทึก</button>
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
    <div class="mt-3" id="row_procedure_">
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
                                <input type="text" class="form-control" id="input_IDProcedure" autocomplete="off">
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
                                <button type="button" class="btn" id="btn_clearProcedure" style="border-color:gray;color:black;font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveProcedure" style="color: #fff;background-color: #643695;color:#fff;font-size:20px;">บันทึก</button>
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
    <div class="mt-3" id="row_deproom_">
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
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_DeproomName_sub" autocomplete="off" placeholder="ตัวย่อ">
                            </div>
                            <div class="col-md-12 mt-3">
                                <select name="" id="input_DeproomFloor" class="form-control" style="font-size:20px;">
                                </select>
                                <!-- <input type="number" class="form-control" id="input_DeproomFloor" autocomplete="off" > -->
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDDeproom" autocomplete="off">
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
                                <button type="button" class="btn" id="btn_clearDeproom" style="border-color:gray;color:black;font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveDeproom" style="color: #fff;background-color: #643695;color:#fff;font-size:20px;">บันทึก</button>
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
                                    <th scope="col" style="width: 20%;" class="text-center" id="">ห้องตรวจย่อ</th>
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
                                <input type="text" class="form-control" id="input_empcodeUser" autocomplete="off" placeholder="รหัสพนักงาน">
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
                                <input type="text" class="form-control" id="input_IDUser" autocomplete="off">
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
                                <button type="button" class="btn" id="btn_clearUser" style="border-color:gray;color:black;font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveUser" style="color: #fff;background-color: #643695;color:#fff;font-size:20px;">บันทึก</button>
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
</div>


<div id="row_mapping">



    <div id="master">

        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header f18" style="color:black;">เชื่อมโยงข้อมูล แพทย์</div>
                    <div class="card-body">

                        <div class="row position-relative">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label" style="color:black;">แพทย์</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="select_doctor_deproom"></select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label" style="color:black;">ห้องผ่าตัด</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="select_deproom" disabled></select>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- เส้นแบ่งตรงกลาง -->
                            <div class="vertical-divider" style="position: absolute;left: 50%; top: 0;bottom: 0;width: 2px;background-color: black;border: none;transform: translateX(-50%);"></div>

                            <!-- คอลัมน์ขวา -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="display: contents;" id="row_deproom">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn " id="btn_Clear_doctor_deproom" style="border-color:gray;color: black;font-size:20px;"> <i class="fa-solid fa-repeat"></i> รีเซ็ตข้อมูล</button>
                        <button class="btn" id="btn_Save_doctor_deproom" style="color: #fff;background: #643695;font-size:20px;"> <i class="fa-solid fa-arrow-down"></i> บันทึก</button>
                    </div>
                </div>


            </div>

            <div class="col-md-6">


                <div class="card">
                    <div class="card-header f18" style="color:black;">เชื่อมโยงข้อมูล ห้องผ่าตัด</div>
                    <div class="card-body">

                        <div class="row position-relative">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label" style="color:black;">ห้องผ่าตัด</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="select_deproom_proceduce"></select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-3 col-form-label" style="color:black;">หัตถการ</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="select_proceduce" disabled></select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- เส้นแบ่งตรงกลาง -->
                            <div class="vertical-divider" style="position: absolute;left: 50%; top: 0;bottom: 0;width: 2px;background-color: black;border: none;transform: translateX(-50%);"></div>

                            <!-- คอลัมน์ขวา -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="display: contents;" id="row_procedure">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn" id="btn_Clear_deproom_proceduce" style="border-color:gray;color: black;font-size:20px;"> <i class="fa-solid fa-repeat"></i> รีเซ็ตข้อมูล</button>
                        <button class="btn" id="btn_Save_deproom_proceduce" style="color: #fff;background: #643695;font-size:20px;"> <i class="fa-solid fa-arrow-down"></i> บันทึก</button>
                    </div>

                </div>


            </div>





            <div class="col-md-6 mt-3">

                <div class="card">
                    <div class="card-header f18 " style="color:black;">รายการที่บันทึก แพทย์&ห้องผ่าตัด</div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-sm" id="table_detail_doctor">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" id="td_number" class="text-center" class="text-center">ชื่อแพทย์</th>
                                            <th scope="col" style="width: 20%;" class="text-center">ห้องผ่าตัด</th>
                                            <th scope="col" style="width: 20%;" class="text-center">#</th>
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

            <div class="col-md-6 mt-3">

                <div class="card">
                    <div class="card-header f18 " style="color:black;">รายการที่บันทึก ห้องผ่าตัด&หัตถการ</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-sm" id="table_detail_deproom">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" id="td_number" class="text-center" class="text-center">ห้องผ่าตัด</th>
                                            <th scope="col" style="width: 20%;" class="text-center">หัตถการ</th>
                                            <th scope="col" style="width: 20%;" class="text-center">#</th>
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

    </div>






</div>

<div id="row_routine">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">ประเภทอุปกรณ์</label>
                                <div class="input-group">
                                    <select name="" id="select_typeItem" class="form-control f18">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">ชื่ออุปกรณ์</label>
                                <input type="text" class="form-control f18" placeholder="พิมพ์ชื่อค้นหา หรือรหัสอุปกรณ์" id="input_search_request">
                            </div>
                        </div>

                    </div>




                    <table class="table table-hover table-sm" id="table_detail_item">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" id="td_number" class="text-center" class="text-center">ลำดับ</th>
                                <th scope="col" style="width: 20%;" class="text-center">รายการ</th>
                                <th scope="col" style="width: 20%;" class="text-center">ลักษณะการใช้งาน</th>
                                <th scope="col" style="width: 20%;" class="text-center">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="col-md-12 text-right mt-2">
                        <button class="btn f18" style="background-color: #643695;color:#fff;" id="btn_confirm_request">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <input type="text" id="routine_id" hidden>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">แพทย์</label>
                                        <select name="" id="select_doctor_routine" class="form-control f18"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="display: contents;" id="row_doctor_routine"></div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                <label style="color:black;font-weight: 600;">ห้องผ่าตัด</label>
                                <select name="" id="select_deproom_routine" class="form-control f18">
                                </select>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label style="color:black;font-weight: 600;">หัตถการ</label>
                                        <select name="" id="select_procedure_routine" class="form-control f18"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div style="display: contents;" id="row_procedure_routine"></div>
                                </div>
                            </div>

                        </div>


                    </div>




                    <table class="table table-hover table-sm" id="table_item_detail_request">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center" id="">ลำดับ</th>
                                <th scope="col" class="text-center" id="">รายการ</th>
                                <th scope="col" class="text-center" id="">ลักษณะการใช้งาน</th>
                                <th scope="col" class="text-center" id="">จำนวน</th>
                                <th scope="col" class="text-center" id="">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="col-md-12 text-right mt-2">
                        <button class="btn f18 btn-danger" id="btn_clear_routine">ล้างข้อมูล</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label style="color:black;font-weight: 600;">ค้นหา</label>
                        <input type="text" class="form-control f18" placeholder="แพทย์ / ห้องผ่าตัด / หัตถการ" id="input_search_routine">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-sm" id="table_detail_routine">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" id="" class="text-center" class="text-center">ลำดับ</th>
                                <th scope="col" style="width: 20%;" id="" class="text-center" class="text-center">ชื่อแพทย์</th>
                                <th scope="col" style="width: 20%;" class="text-center">ห้องผ่าตัด</th>
                                <th scope="col" style="width: 20%;" class="text-center">หัตถการ</th>
                                <th scope="col" style="width: 5%;" class="text-center">แก้ไข</th>
                                <th scope="col" style="width: 5%;" class="text-center">ลบ</th>
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



<div class="modal fade" id="showDetail_deproom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ห้องผ่าตัด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-sm" id="table_detail_deproom_modal">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">ห้องผ่าตัด</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_Procedure" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">หัตถการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-sm" id="table_detail_Procedure">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">หัตถการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>