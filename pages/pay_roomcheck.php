<div>

    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_roomcheck">ห้องตรวจ</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="" style="font-size: 20px;">
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size: 20px;font-weight: bold;" id="lang_text_username">ชื่อผู้ใช้</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="" style="font-size: 20px;">
            </div>
        </div>
    </div>



    <div class="row" hidden>
        <div class="col-md-6">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab2">จ่ายอุปกรณ์ให้ห้องตรวจ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab1">เอกสารห้องตรวจขอเบิกใช้อุปกรณ์</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab3">อุปกรณ์ชำรุด</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab4">สต๊อกห้องตรวจคืนคลัง</button>
            </div>
        </div>
        <div class="col-md-6">
            <button class="btn btn-block bg-light border border-secondary" id="btn_ReportUseItem" style="border: 1px solid;font-size: 30px;font-weight: bold;color: black;" data-target=".bd-example-modal-lg"> รายงานการใช้เครื่องมือ</button>
        </div>
    </div>
</div>



<hr>

<div class="row" id="tab1" hidden>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <label for="" id="lang_text_date">วันที่</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                    <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_Date" data-language='en' data-date-format='dd-mm-yyyy'>
                </div>

            </div>
            <div class="col-md-6">
                <label for="" id="lang_text_roomcheck2">ห้องตรวจ</label>
                <select class="form-control select2" id="select_departmentRoom" style="border-color: red;font-size:20px;"></select>
            </div>
            <div class="col-md-8 mt-3">
                <input type="text" id="input_Search" class="form-control" placeholder="ค้นหาจากชื่ออุปกรณ์ หรือ รหัสอุปกรณ์" style="font-size:20px;">
            </div>

            <div class="col-md-4 mt-3">
                <button class="btn btn-block " id="btn_Search" style="color: #fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ค้นหา</button>
            </div>

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
                        <button class="btn" id="btn_codePrint" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">กรอกรหัสผู้พิมพ์</button>
                        <button class="btn" id="btn_comfirmPrint" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);" disabled>ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 mt-3">
                <!-- <div class="col-md-4"> -->
                <div style="border-radius: 25px;text-align: center;background: linear-gradient(0deg, #EFF6FF, #EFF6FF),linear-gradient(0deg, #FFFFFF, #FFFFFF);">
                    <label style="color:blue;font-weight: bold;font-size:20px;" id="label_DocNo"></label>
                </div>
                <!-- </div> -->
            </div>

            <div class="col-md-12 mt-3">
                <table class="table table-hover table-sm" id="table_detailTab1">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" id="td_item2">อุปกรณ์</th>
                            <th scope="col" style="width: 20%;" id="td_qty2">จำนวน</th>
                            <th scope="col" style="width: 20%;" id="td_delete">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="row mt-3">
                    <div class="col-md-12" style="text-align: end;">
                        <button class="btn btn-danger" id="btn_cancelDataTab1" style="font-size:20px;color:#fff;">ยกเลิกข้อมูล</button>
                        <button class="btn" id="btn_sendDataTab1" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งข้อมูล</button>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- <div class="col-md-6">
        <label for="">&nbsp;</label>
        <button class="btn btn-block bg-light border border-secondary" id="btn_popUpDetail" style="font-size:20px;">ดูข้อมูลเบิก</button>
    </div> -->













</div>

<div class="row" id="pay">

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                    </div>
                    <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_date_pay" data-language='en' data-date-format='dd-mm-yyyy'>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <select class="form-control select2" style="font-size:20px;" id="select_deproom_pay"></select>
            </div>
            <div class="col-md-12 mt-3">

            <div class="col-md-12 mt-3">
                <table class="table table-hover table-sm" id="table_detail_pay">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="td_pay_hn_1">HN No.</th>
                            <th scope="col" class="text-center" id="td_pay_doctor_1">แพทย์</th>
                            <th scope="col" class="text-center" id="td_pay_procedure_1">หัตถการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>



            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="input_pay" placeholder="สแกนจ่าย" style="font-size: 25px;" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group ">
                    <input type="text" class="form-control" id="input_returnpay" placeholder="สแกนคืนสต๊อกหลัก" style="font-size: 25px;background:#FF0033;font-size:20px;" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa-solid fa-qrcode"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <table class="table table-hover table-sm" id="table_detail_byDocNo_pay">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="td_pay_item_2">อุปกรณ์</th>
                            <th scope="col" class="text-center" style="width: 20%;" id="">เบิก</th>
                            <th scope="col" class="text-center" style="width: 20%;" id="">จ่าย</th>
                            <th scope="col" class="text-center" style="width: 20%;" id="td_pay_issue_2">คงเหลือ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="tab3" hidden>

    <input type="text" class="form-control" id="input_iddeproomTab3" hidden>


    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="input_repair_3" placeholder="สแกนชำรุด" style="font-size:20px;">
                <div class="input-group-append">
                    <div class="input-group-text" style="cursor: pointer;" id="qr_repair_3"><i class="fa-solid fa-qrcode"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail1_Tab3">รายการอุปกรณ์ห้องตรวจ</label>
                        </div>
                        <div class="col-6 text-right" hidden>
                            <input autocomplete="off" type="text" class="form-control datepicker-here" id="select_Date_tab3" data-language='en' data-date-format='dd-mm-yyyy' style="font-size:20px;">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">

                            <table class="table table-hover table-sm " id="table_detailTab3Left">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab3_no">ลำดับ</th>
                                        <th scope="col" style="width: 40%;" class="text-center" id="td_tab3_itemname">ห้องตรวจ</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_tab3_qty">จำนวน</th>
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
        <div class="col-lg-8 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail2_Tab3">รายการอุปกรณ์ชำรุด</label>
                        </div>
                        <div class="col-6 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <table class="table table-hover table-sm " id="table_detailTab3Right">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab3_no2">ลำดับ</th>
                                        <th scope="col" style="width: 15%; text-align: center;" id="td_tab3_usage2">รหัสอุปกรณ์</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id="td_tab3_itemname2">ชื่ออุปกรณ์</th>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab3_qty2">จำนวน</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id="td_tab3_remark">หมายเหตุ</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id=""></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_SendDataTab3" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="tab4" hidden>

    <div class="row">
        <div class="col-md-6">
            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab4_1">คืนแบบปกติ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab4_2">คืนแบบออโต้</button>
            </div>
        </div>
    </div>


    <div id="tab4_1">
        <input type="text" class="form-control" id="input_iddeproomTab4" hidden>
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="input_scanback_4" placeholder="สแกนคืน" style="font-size:20px;">
                    <div class="input-group-append">
                        <div class="input-group-text" style="cursor: pointer;" id="qr_scanback_4"><i class="fa-solid fa-qrcode"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12  mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 text-left">
                                <label style="color:black;font-size:25px;" id="header_Detail1_Tab4">รายการอุปกรณ์ห้องตรวจ</label>
                            </div>
                            <div class="col-6 text-right" hidden>
                                <input autocomplete="off" type="text" class="form-control datepicker-here" id="select_Date_tab4" data-language='en' data-date-format='dd-mm-yyyy' style="font-size:20px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">

                                <table class="table table-hover table-sm " id="table_detailTab4Left">
                                    <thead class="table-active">
                                        <tr>
                                            <th scope="col" style="width: 5%;" class="text-center" id="td_tab4_no">ลำดับ</th>
                                            <th scope="col" style="width: 40%;" class="text-center" id="td_tab4_itemname">ห้องตรวจ</th>
                                            <th scope="col" style="width: 20%;" class="text-center" id="td_tab4_qty">จำนวน</th>
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
            <div class="col-lg-8 col-md-12 col-sm-12  mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 text-left">
                                <label style="color:black;font-size:25px;" id="header_Detail2_Tab4">รายการอุปกรณ์คืนห้องตรวจ</label>
                            </div>
                            <div class="col-6 text-right">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <table class="table table-hover table-sm " id="table_detailTab4Right">
                                    <thead class="table-active">
                                        <tr>
                                            <th scope="col" style="width: 5%;" class="text-center" id="td_tab4_no1">ลำดับ</th>
                                            <th scope="col" style="width: 15%; text-align: center;" id="td_tab4_usage1">รหัสอุปกรณ์</th>
                                            <th scope="col" style="width: 30%;" class="text-center" id="td_tab4_itemname1">ชื่ออุปกรณ์</th>
                                            <th scope="col" style="width: 5%;" class="text-center" id="td_tab4_qty1">จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: end;">
                                        <button class="btn" id="btn_SendDataTab4" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="tab4_2">
        <input type="text" class="form-control" id="input_iddeproomTab4_2" hidden>
        <div class="row mt-2">
            <div class="col-lg-12 col-md-12 col-sm-12  mt-2 text-right">
                <button class="btn" id="btn_returnTab4_2" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">เรียกคืนอุปกรณ์กลับคลังทันตกรรม</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-4 col-md-12 col-sm-12  mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 text-left">
                                <label style="color:black;font-size:25px;" id="header_Detail1_Tab4_2">รายการอุปกรณ์ห้องตรวจ</label>
                            </div>
                            <div class="col-6 text-right" hidden>
                                <input autocomplete="off" type="text" class="form-control datepicker-here" id="select_Date_tab4_2" data-language='en' data-date-format='dd-mm-yyyy' style="font-size:20px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">

                                <table class="table table-hover table-sm " id="table_detailTab4Left_2">
                                    <thead class="table-active">
                                        <tr>
                                            <th scope="col" style="width: 5%;" class="text-center" id="td_tab4_no2">ลำดับ</th>
                                            <th scope="col" style="width: 40%;" class="text-center" id="td_tab4_deproom2">ห้องตรวจ</th>
                                            <th scope="col" style="width: 20%;" class="text-center" id="td_tab4_qty2">จำนวน</th>
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
            <div class="col-lg-8 col-md-12 col-sm-12  mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 text-left">
                                <label style="color:black;font-size:25px;" id="header_Detail2_Tab4_2">รายการอุปกรณ์คืนห้องตรวจ</label>
                            </div>
                            <div class="col-6 text-right">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <table class="table table-hover table-sm " id="table_detailTab4Right_2">
                                    <thead class="table-active">
                                        <tr>
                                            <th scope="col" style="width: 5%;" class="text-center" id="">ลำดับ</th>
                                            <th scope="col" style="width: 15%; text-align: center;" id="">รหัสอุปกรณ์</th>
                                            <th scope="col" style="width: 30%;" class="text-center" id="">ชื่ออุปกรณ์</th>
                                            <th scope="col" style="width: 5%;" class="text-center" id="">จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: end;">
                                        <button class="btn" id="btn_SendDataTab4_2" hidden style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>




<div class="modal fade bd-example-modal-lg" id="modal_ReportUseItem" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายงานการใช้เครื่องมือ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <select class="form-control" style="font-size:20px;" id="select_departmentRoom_modal"></select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="input_Search_modal" placeholder="ค้นหาอุปกรณ์">
                    </div>
                    <div class="col-md-4 ">
                        <button class="btn" id="btn_Search_modal" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ค้นหา</button>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-dark font-weight-bold h5 text-center" id="header_Detail3">
                                ห้องตรวจ
                            </div>
                            <ul class="list-group" id="ul_deproom_modal">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table" id="table_detail_modal">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center"></th>
                                    <th scope="col" class="text-center" id="td_item4">อุปกรณ์</th>
                                    <th scope="col" class="text-center" style="width: 20%;" id="td_qty4">จำนวน</th>
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


<div class="modal fade" id="modal_Report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header_Report">สรุปยอดการเบิก</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="recipient-name" class="col-form-label" id="lang_text_date2">วันที่:</label>
                        <input type="text" class="form-control datepicker-here" id="modal_select_Date" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                    <div class="col-md-4 " style="margin-top: 2.4rem!important;">
                        <button class="btn" id="modal_btn_Search_Date" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ค้นหา</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="modal_table_detailTab1">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 10%;" id="td_no">No.</th>
                                    <th scope="col" class="text-center" style="width: 50%;" id="td_item5">อุปกรณ์</th>
                                    <th scope="col" class="text-center" style="width: 20%;" id="td_return">สต๊อกหลัก</th>
                                    <th scope="col" class="text-center" style="width: 20%;" id="td_request">ขอเบิก</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="image-viewer">
    <span class="close">&times;</span>
    <img class="modal-contentx" id="full-image">
</div>