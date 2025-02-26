<div>

    <div class="row">
        <div class="col-md-6">
            <h1 class="h3  mt-4" id="text_rutine1" style="color:black;">ตั้งค่าจ่ายอุปกรณ์ให้ห้องตรวจ</h1>
            <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_rutine2"> ตั้งค่าการจ่ายอุปกรณ์ให้ห้องตรวจ</a> -->
            <p style="margin-bottom: 0rem;color:black;" id="text_rutine3">ตั้งค่าห้องตรวจ และ ตั้งค่าจ่ายอุปกรณ์ให้ห้องตรวจ</p>
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;" id="lang_text_roomcheck">ห้องตรวจ</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="<?= $departmentroomname; ?>" style="font-size: 20px;">
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="<?= $UserName; ?>" style="font-size: 20px;">
            </div>
        </div>
    </div>
</div>


<hr>


<div class="row mb-3">
    <div class="col-md-6">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab1">ตั้งค่าห้องตรวจ</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab2">ตั้งค่าจ่ายอุปกรณ์ให้ห้องตรวจ</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab3">ตั้งค่า</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab4">Max Inventory</button>
        </div>


        <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light active" style="width: 250px;border: 1px solid;font-size: 20px;" id="label_tab1">
                <input type="radio" name="options" id="radio_tab1" autocomplete="off" checked> ตั้งค่าห้องตรวจ
            </label>
            <label class="btn btn-light" style="width: 250px;border: 1px solid;font-size: 20px;" id="label_tab2">
                <input type="radio" name="options" id="radio_tab2" autocomplete="off"> ตั้งค่าจ่ายอุปกรณ์ให้ห้องตรวจ
            </label>
        </div> -->
    </div>
</div>


<!-- <div class="row" style="border: 1px solid #EAECF0;background-color:#F0F9FF;">
        <div class="col-md-3 px-3 mt-2 mb-4 text-center">
            <h1 class="h3 mt-3" style="color:black;font-weight: bold;line-height: 0;">ชั้น 2 </h1>
            <p class="mt-4" style="line-height: 0;">จำนวนห้องทั้งหมด : 10</p>
            <button class="btn" style="background-color: lightskyblue;color: #175CD3;font-size: 20px;font-weight: bold;width: 6rem;">เปิดอยู่ : 8</button>
            <button class="btn" style="background-color: lightgray;color: #475467;font-size: 20px;font-weight: bold;width: 6rem;">ปิดอยู่ : 2</button>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_blue">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_gray">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
            </div>
        </div>
    </div>
    <div class="row" style="border: 1px solid #EAECF0;background-color:#F9F5FF;">
        <div class="col-md-3 px-3 mt-2 mb-4 text-center">
            <h1 class="h3 mt-3" style="color:black;font-weight: bold;line-height: 0;">ชั้น 3 </h1>
            <p class="mt-4" style="line-height: 0;">จำนวนห้องทั้งหมด : 10</p>
            <button class="btn" style="background-color: lightskyblue;color: #175CD3;font-size: 20px;font-weight: bold;width: 6rem;">เปิดอยู่ : 8</button>
            <button class="btn" style="background-color: lightgray;color: #475467;font-size: 20px;font-weight: bold;width: 6rem;">ปิดอยู่ : 2</button>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_blue">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_gray">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
                <div class="col-md-2 text-center mt-2"><button class="btn btn_lutine_white">ห้องตรวจ 201</button></div>
            </div>
        </div>
    </div> -->

<div class="mt-3" id="tab1">

    <div class="row ">

        <div id="floor_Detail">

        </div>
        <!-- <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header text-dark font-weight-bold h5 text-center">
                    ห้องตรวจ
                </div>
                <ul class="list-group" id="ul_deproom" style="max-height:650px;overflow-y:auto;">
                </ul>
            </div>
        </div> -->
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header text-left" style="font-size: 25px;font-weight: bold;color:black;" id="header_Detail">
                    รายละเอียด
                    <label for="" style="color:gray;" id="deproomNameShow"></label>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row" style="font-size: 25px;color: black;" hidden>
                                        <div class="col-3">
                                            <label for="disabledTextInput" class="form-label" id="lang_text_status">สถานะห้อง : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="switch_Open_Close">
                                                <label class="custom-control-label" for="switch_Open_Close" id="lang_text_open">เปิด</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="input_iddeproom" hidden>
                                    <!--                             
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio_open" value="option1">
                                <label class="form-check-label" for="inlineRadio1">เปิด</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio_close" value="option2">
                                <label class="form-check-label" for="inlineRadio2">ปิด</label>
                            </div> -->
                                </div>
                                <div class="col-12">
                                    <div class="form-group" id="col-doctor" style="font-size: 25px;color: black;">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label" id="lang_text_doctor">แพทย์ประจำห้องตรวจ :</label>
                                            <div class="col-sm-5">
                                                <select name="select_doctor" id="select_doctor" class="form-control select2 "></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row" style="font-size: 25px;color: black;">
                                        <div class="col-3">
                                            <label for="" class="form-label" id="text_setting_dep">ตั้งค่าห้องตรวจทันตกรรม : </label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio_stock" value="1">
                                                <label class="form-check-label" for="inlineRadio1" id="text_inlineRadio_stock">สต๊อกห้องตรวจ</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio_dental" value="0">
                                                <label class="form-check-label" for="inlineRadio2" id="text_inlineRadio_dental">คืนคลังทันตกรรม</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button class="btn" id="btn_ModalDoctor" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:25px;">ตารางเวรแพทย์ประจำห้องตรวจ</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<div class="mt-3" id="tab2">

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <select class="form-control" id="select_departmentRoom" style="color:black;font-size:20px;"></select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10 mt-3">
                    <input type="text" id="input_Search" class="form-control" placeholder="ค้นหาจากชื่ออุปกรณ์ หรือ รหัสอุปกรณ์" style="font-size:20px;">
                </div>

                <div class="col-md-2 mt-3">
                    <button class="btn btn-block" id="btn_Search" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ค้นหา</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <table class="table table-hover table-sm" id="table_itemStock">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center" id="td_item1">อุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_qty1">จำนวนเบิก</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="row mt-3">
                        <div class="col-md-12" style="text-align: end;">
                            <button class="btn" id="btn_comfirmPrint" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);" disabled>ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">


                <div class="col-md-12">
                    <table class="table table-hover table-sm" id="table_detailTab1">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" id="td_item2" class="text-center">อุปกรณ์</th>
                                <th scope="col" style="width: 20%;" id="td_qty">จำนวน</th>
                                <th scope="col" style="width: 20%;" id="td_delete">ลบ</th>
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

<div class="mt-3" id="tab3">

    <div class="row mb-3">
        <div class="col-md-6">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio1_tab3">เพิ่มแพทย์</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio2_tab3">เพิ่มหัตถการ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio3_tab3">เพิ่มห้องตรวจ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio4_tab3">เพิ่มUser</button>
            </div>
        </div>
    </div>


    <div class="mt-3" id="tab1_3">
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
    <div class="mt-3" id="tab2_3">
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
    <div class="mt-3" id="tab3_3">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addDeproom_tab3" style="font-size: 25px;color:black;">เพิ่มห้องตรวจ</label>
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
                                                <input type="radio" class="form-check-input" name="radio_typeDeproom" id="radio_typeDeproom1" checked>ห้องตรวจ
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
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_namethdep_tab3">ห้องตรวจไทย</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_nameendep_tab3">ห้องตรวจอังกฤษ</th>
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
    <div class="mt-3" id="tab4_3">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <label id="modal_addUser_tab3" style="font-size: 25px;color:black;">เพิ่ม User</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_empcodeUser_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-2">
                                <input type="text" class="form-control" id="input_nameUser_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_lastUser_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_userName_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">
                                <input type="text" class="form-control" id="input_passWord_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3" hidden>
                                <input type="text" class="form-control" id="input_IDUser_tab3" autocomplete="off" style="font-size: 20px;">
                            </div>
                            <div class="col-md-12 mt-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="font-size: 25px;color:black;" id="radio_statusUser">สถานะ</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser1" checked>Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_statusUser" id="radio_statusUser2">InActive
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12 mt-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" style="font-size: 25px;color:black;" id="radio_roleUser">Role</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser1" checked>CSSD & DSS
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" style="font-size: 25px;color:black;">
                                                <input type="radio" class="form-check-input" name="radio_roleUser" id="radio_roleUser2">Dental Room
                                            </label>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="col-md-12 mt-3 text-right">
                                <button type="button" class="btn" id="btn_clearUser_tab3" style="font-size:20px;">ล้างข้อมูล</button>
                                <button type="button" class="btn " id="btn_saveUser_tab3" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">บันทึก</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
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

<div class="mt-3" id="tab4">
    <div class="row">
        <div class="col-md-6">


            <div class="row">
                <div class="col-md-10 mt-3">
                    <input type="text" id="input_Search_MaxInventory" class="form-control" placeholder="ค้นหาจากชื่ออุปกรณ์ หรือ รหัสอุปกรณ์" style="font-size:20px;">
                </div>

                <div class="col-md-2 mt-3">
                    <button class="btn btn-block" id="btn_Search_MaxInventory" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ค้นหา</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-3">
                    <table class="table table-hover table-sm" id="table_itemStock_MaxInventory">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center" id="td_item4">อุปกรณ์</th>
                                <th scope="col" style="width: 20%;" class="text-center" id="td_qty4">จำนวน Inventory Max</th>
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
<div class="modal fade" id="modal_showPopupDoctor" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_head_tab4">ตารางเวรแพทย์ประจำห้องตรวจ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group w-50">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                            </div>
                            <input type="text" autocomplete="off" style="font-size:25px;" class="form-control datepicker-here w-50" id="select_DateDoctor" data-language="en" data-date-format="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <!-- <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#floor1" role="tab" aria-controls="home" aria-selected="true">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#floor2" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                            </li> -->
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <!-- <div class="tab-pane fade show active" id="floor1" role="tabpanel" >2</div>
                            <div class="tab-pane fade" id="floor2" role="tabpanel">1</div> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>