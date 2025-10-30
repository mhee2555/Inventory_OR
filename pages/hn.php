

<div class="row mt-3">
    <div class=" col-md-12 col-lg-9">

        <div class="tab-button-group">
            <button class="tab-button active" id="radio_hn">สืบค้นข้อมูล ผู้ป่วย</button>
            <button class="tab-button" id="radio_department">สืบค้นข้อมูล หน่วยงาน</button>
        </div>
    </div>
</div>



<hr>



<div id="row_hn" class="row">
    <div class="col-md-6">
        <div class="row ">
            <div class="col-md-6">
                <label for="" id="lang_text_date1" style="font-weight: 600;color:black;">วันที่</label>


                <div class="position-relative">
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_SDate" data-language='en' data-date-format='dd-mm-yyyy'>
                    <span class="input-icon">
                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                    </span>
                </div>
                <!-- <div class="input-group">

                    <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_SDate" data-language='en' data-date-format='dd-mm-yyyy' autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                </div> -->

            </div>
            <div class="col-md-6">
                <label for="" id="lang_text_date2" style="font-weight: 600;color:black;">วันที่</label>

                <div class="position-relative">
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_EDate" data-language='en' data-date-format='dd-mm-yyyy'>
                    <span class="input-icon">
                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                    </span>
                </div>

                <!-- <div class="input-group">
                    <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_EDate" data-language='en' data-date-format='dd-mm-yyyy' autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                </div> -->
            </div>

            <div class="col-md-12 mt-2">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button id="btn_input" class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 18px !important;">เลข HN Number</button>
                        <input type="text" class="form-control" id="input_type_search" hidden>
                        <div class="dropdown-menu" style="font-size: 18px !important;z-index: 9999;">
                            <a class="dropdown-item" href="#" id="a_hnxxx">เลขประจำตัวผู้ป่วย</a>
                            <a class="dropdown-item" href="#" id="a_usage">รหัสอุปกรณ์</a>
                        </div>
                    </div>
                    <input type="text" id="input_search" class="form-control" aria-label="Text input with dropdown button" style="font-size: 25px !important;">
                </div>
            </div>
            <div class="col-md-12 col-lg-12 ">

                <div class="row">
                    <div class="col-md-12 ">
                        <table class="table table-hover  " id="table_detail">
                            <thead class="table-active sticky-top">
                                <tr>
                                    <th scope="col" style="width: 5%; text-align: center;" id="td_no">ลำดับ</th>
                                    <th scope="col" class="text-center" id="td_date">วันที่</th>
                                    <th scope="col" class="text-center" id="td_hn">เลขประจำตัวผู้ป่วย</th>
                                    <th scope="col" class="text-center" id="td_roomcheck">ห้องผ่าตัด</th>
                                    <th scope="col" class="text-center" id="td_doctor">แพทย์</th>
                                    <th scope="col" class="text-center" id="td_procedure">หัตถการ</th>
                                </tr>

                            </thead>
                            <tbody style="line-height: 40px;">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 mt-4">
        <div class="row ">




            <div class="col-md-2">

                <div class="dropdown">
                    <button style="background-color: #643695;color:white;" class=" f18 btn  dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        รายงาน
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index: 9999;">
                        <a class="dropdown-item" href="#" id="btn_excel_cost" style="color: green;">Excel ค่าใช้จ่าย</a>
                        <a class="dropdown-item" href="#" id="btn_excel_all" style="color: green;">Excel All</a>
                        <a class="dropdown-item" href="#" id="btn_cost" style="color: #643695;">สรุปค่าใช้จ่าย</a>
                        <a class="dropdown-item" href="#" id="btn_Tracking" style="color: #643695;">Medical Instrument Tracking</a>
                        <a class="dropdown-item" href="#" id="btn_use" style="color: #643695;">สรุปการใช้อุปกรณ์กับผู้ป่วย</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 pl-0">
                <button class="btn btn-success f18" id="edit_his" disabled>แก้ไขอุปกรณ์</button>
            </div>

            <div class="col-md-6 text-right">
                <button class="btn btn-success" id="btn_send_pay" disabled>ยืนยันการส่งค่าใข้จ่าย (HIS)</button>
            </div>

            <div class="col-md-12 col-lg-12 mt-2">
                <div class="row">
                    <div class="col-md-12 " id="div_detailleft1">
                        <table class="table table-hover  " id="table_detail_sub">
                            <thead class="table-active sticky-top">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 10%;" id="td_no2">ลำดับ</th>
                                    <th scope="col" class="text-center" style="width: 15%;" id="td_date2">ประเภท</th>
                                    <!-- <th scope="col" class="text-center" style="width: 20%;" id="td_usage">จำนวนการใช้งาน</th> -->
                                    <th scope="col" class="text-center" id="td_item">รหัสอุปกรณ์</th>
                                    <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                                    <th scope="col" class="text-center" id="">จำนวน</th>
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

<div id="row_department" class="row">
    <div class="col-md-6">
        <div class="row ">
            <div class="col-md-12">
                <label style="color:black;font-weight: 600;">หน่วยงาน</label>
                <select class="form-control f18" autocomplete="off" id="select_deproom_sell"></select>
            </div>

            <div class="col-md-6 mt-2">
                <label for="" id="lang_text_date1" style="font-weight: 600;color:black;">วันที่</label>


                <div class="position-relative">
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_SDate_department" data-language='en' data-date-format='dd-mm-yyyy'>
                    <span class="input-icon">
                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <label for="" id="lang_text_date2" style="font-weight: 600;color:black;">วันที่</label>

                <div class="position-relative">
                    <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_EDate_department" data-language='en' data-date-format='dd-mm-yyyy'>
                    <span class="input-icon">
                        <i class="fa-solid fa-calendar" style="color:black;"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-12 col-lg-12 mt-2">

                <div class="row">
                    <div class="col-md-12 ">
                        <table class="table table-hover  " id="table_detail_department">
                            <thead class="table-active sticky-top">
                                <tr>
                                    <th scope="col" style="width: 5%; text-align: center;" id="">ลำดับ</th>
                                    <th scope="col" class="text-center" id="">วันที่</th>
                                    <th scope="col" class="text-center" id="">หน่วยงาน</th>
                                    <th scope="col" class="text-center" id="">เลขที่เอกสาร</th>
                                </tr>

                            </thead>
                            <tbody style="line-height: 40px;">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 mt-4">
        <div class="row ">
            <div class="col-md-2">

                <div class="dropdown">
                    <button style="background-color: #643695;color:white;" class=" f18 btn  dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        รายงาน
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="z-index: 9999;">
                        <a class="dropdown-item" href="#" id="btn_excel_cost_department" style="color: green;">Excel ค่าใช้จ่าย</a>
                        <a class="dropdown-item" href="#" id="btn_excel_all_department" style="color: green;">Excel All</a>
                        <a class="dropdown-item" href="#" id="btn_cost_department" style="color: #643695;">สรุปขายให้หน่วยงาน</a>
                        <a class="dropdown-item" href="#" id="btn_Tracking_department" style="color: #643695;">Medical Instrument Tracking</a>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-4 pl-0">
                <button class="btn btn-success f18" id="edit_his_department" disabled>แก้ไขอุปกรณ์</button>
            </div> -->

            <!-- <div class="col-md-6 text-right"> -->
                <button class="btn btn-success" id="btn_send_pay_department" disabled hidden>ยืนยันการส่งค่าใข้จ่าย (HIS)</button>
            <!-- </div> -->

            <div class="col-md-12 col-lg-12 mt-2">
                <div class="row">
                    <div class="col-md-12 " id="div_detailleft1">
                        <table class="table table-hover  " id="table_detail_sub_department">
                            <thead class="table-active sticky-top">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 10%;" id="td_no2">ลำดับ</th>
                                    <th scope="col" class="text-center" style="width: 15%;" id="td_date2">ประเภท</th>
                                    <th scope="col" class="text-center" id="td_item">รหัสอุปกรณ์</th>
                                    <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                                    <th scope="col" class="text-center" id="">จำนวน</th>
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




<div class="modal fade" id="modal_showPopupHN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: 1400px;margin-left: -200px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">HN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="assets/img/imgHN.png" alt="" style="width: 90%;height: 100%;margin-left: 80px;margin-top: 60px;">
                <div style="width: 250px;height: 130px;background-color: #00a99d;margin-top: -42rem;position: absolute;border-radius: 20px;">
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_hnname"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_hncode"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_hndate"></p>
                </div>
                <div style="width: 220px;height: 180px;background-color: #3fa9f5;margin-top: -42rem;margin-left: 19rem;position: absolute;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-top-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;" id="p_washdate"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_washnmachineame"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_washround"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_washstart"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_washend"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_washtestprogram"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_wash"></p>
                </div>
                <div style="width: 250px;height: 100px;background-color: #3fa9f5;margin-top: -15rem;position: absolute;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;" id="p_hndate2"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_itemname"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_usagecode"></p>

                </div>
                <div style="width: 250px;height: 200px;background-color: #3fa9f5;margin-top: -12rem;margin-left: 40rem;position: absolute;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;" id="p_steriledate"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_sterilemachinename"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_sterileround"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_sterilestart"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_sterileend"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;" id="p_steriletestprogram"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_sterile"></p>
                </div>
                <div style="width: 250px;height: 100px;background-color: #3fa9f5;margin-top: -16rem;margin-left: 62rem;position: absolute;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;" id="p_preparename"></p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;" id="p_approvename"></p>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รับเข้าอุปกรณ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div id="signature-pad" class="m-signature-pad">
                            <div class="m-signature-pad--body">
                                <canvas style="    border: 2px solid;height: 310px;width: 530px;"></canvas>
                                <button id="clear" class="btn btn-secondary">Clear</button>
                            </div>
                        </div>
                        <!-- <div class="wrapper">
                            <canvas id="signature-pad" class="signature-pad"></canvas>
                            <button id="clear">Clear</button>
                        </div> -->
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <input type="file" class="dropify" data-height="300" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" id="btn-save" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_lotno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label for="" id="lang_text_date1" style="font-weight: 600;color:black;">Lot No</label>
                        <input type="text" style="font-size:20px;" class="form-control" id="lot_no" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-12">
                        <label for="" id="lang_text_date1" style="font-weight: 600;color:black;">seriel No</label>
                        <input type="text" style="font-size:20px;" class="form-control" id="seriel_no" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-12">
                        <label for="" id="lang_text_date1" style="font-weight: 600;color:black;">Exp Lot</label>
                        <input type="text" style="font-size:20px;" class="form-control" id="exp_lot" autocomplete="off" disabled>
                    </div>
                </div>

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
                <table class="table table-hover " id="table_detail_Procedure">
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

<div class="modal fade" id="myModal_Doctor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แพทย์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover " id="table_detail_Doctor">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">แพทย์</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myCustomModal" tabindex="-1" role="dialog" aria-labelledby="myCustomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3" style="color:black;">สแกนคืน</h5>
                            <div class="form-group">
                                <input type="text" class="form-control f18" placeholder="" id="input_return_item_his">
                            </div>
                            <div class="table-responsive" id="table_return_his">
                                <table class="table table-hover ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ชื่ออุปกรณ์</th>
                                            <th class='text-center'>รหัสอุปกรณ์</th>
                                            <th style="width: 80px; text-align: center;">จำนวน</th>
                                            <th style="width: 100px; text-align: center;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="mb-3" style="color:black;">เพิ่มอุปกรณ์</h5>
                            <div class="form-group">
                                <select class="form-control f18" id="select_item_his">
                                    <option>เลือกอุปกรณ์</option>
                                </select>
                            </div>
                            <div class="table-responsive" id="table_add_his">
                                <table class="table table-hover ">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ชื่ออุปกรณ์</th>
                                            <th style="width: 100px; text-align: center;">จำนวน</th>
                                            <th style="width: 100px; text-align: center;">#</th>
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
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" class="btn btn-light" data-dismiss="modal">ล้างข้อมูล</button>
                <button type="button" class="btn btn-primary" id="btn_send_his">ส่งข้อมูล</button>
            </div>
        </div>
    </div>
</div>