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
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="master">จัดการข้อมูล Master</button>
            <button type="button" class="btn btn-light f24" style="border: 1px solid;font-weight: 600;width:260px;" id="mapping">Data Mapping</button>
        </div>
    </div>
</div>


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

                                <div class="col-md-12 text-right">
                                    <button class="btn btn-danger" id="btn_Clear_doctor_deproom" style="color: #fff;font-size:20px;"> <i class="fa-solid fa-repeat"></i> รีเซ็ต</button>
                                    <button class="btn" id="btn_Save_doctor_deproom" style="color: #fff;background: #643695;font-size:20px;"> <i class="fa-solid fa-arrow-down"></i> บันทึก</button>
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

                                <div class="col-md-12 text-right">
                                    <button class="btn btn-danger" id="btn_Clear_deproom_proceduce" style="color: #fff;font-size:20px;"> <i class="fa-solid fa-repeat"></i> รีเซ็ต</button>
                                    <button class="btn" id="btn_Save_deproom_proceduce" style="color: #fff;background: #643695;font-size:20px;"> <i class="fa-solid fa-arrow-down"></i> บันทึก</button>
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
            </div>


        </div>





        <div class="col-md-6">

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

        <div class="col-md-6">

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