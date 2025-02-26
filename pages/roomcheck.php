<div>






    <div class="row">
        <div class="col-sm-4 col-md-4">
        </div>
        <div class=" col-sm-4 col-md-4 col-lg-4 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_roomcheck">ห้องตรวจ</div>
                </div>
                <input type="text" class="form-control" id="input_Deproom_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-lg-4 mt-3 text-right">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text" id="lang_text_username">ชื่อผู้ใช้</div>
                </div>
                <input type="text" class="form-control" id="input_Name_Main" disabled value="" style="font-weight: bold;">
            </div>
        </div>

    </div>





    <div class="row">
        <div class=" col-md-12 col-lg-9  ">

            <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_useitem">ใช้เครื่องมือ</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_request">ขอเบิก</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_history_request">ประวัติการขอเบิก</button>
                <!-- <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab4" hidden>คืนสต๊อกหลัก</button>
                <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab5" hidden>อุปกรณ์ชำรุด</button> -->
            </div>
        </div>
    </div>
</div>


<hr>

<div id="use_item">

    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="">รายการใช้เครื่องมือกับคนไข้</label>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn" id="" style="font-size:20px;color: black;border-color:black;">ประวัติการใช้เครื่องมือ</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="input_use" placeholder="สแกนใช้แล้ว" inputmode='none' style="font-size: 20px;" autocomplete="off">
                                <div class="input-group-append">
                                    <div class="input-group-text" style="cursor: pointer;" id="qr_use_main"><i class="fa-solid fa-qrcode"></i></div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-6 mt-3 text-right">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="input_stock_back" placeholder="สแกนคืนห้องตรวจ" inputmode='none' style="background:#FF0033;font-size:20px;">
                                <div class="input-group-append">
                                    <div class="input-group-text" style="cursor: pointer;" id="qr_stock_back"><i class="fa-solid fa-qrcode"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <table class="table table-hover table-sm " id="table_item_use">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" class="text-center" id="td_no">ลำดับ</th>
                                        <th scope="col" id="td_usage">รหัสอุปกรณ์</th>
                                        <th scope="col" class="text-center" id="td_itemname">ชื่ออุปกรณ์</th>
                                        <th scope="col" class="text-center" id="td_qty">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_send_use" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail2">รายการอุปกรณ์ห้องตรวจ</label>
                        </div>
                        <div class="col-6 text-right">
                            <input type="text" class="form-control datepicker-here" id="select_date_item_use_success" data-language='en' data-date-format='dd-mm-yyyy' style="font-size: 20px;">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 mt-3">
                        <table class="table table-hover table-sm " id="table_item_use_success">
                            <thead class="table-active">
                                <tr>
                                    <th scope="col" style="width: 5%;" class="text-center" id="td_no2">ลำดับ</th>
                                    <th scope="col" style="width: 40%;" class="text-center" id="td_itemname2">อุปกรณ์</th>
                                    <th scope="col" style="width: 20%;" class="text-center" id="td_qty2">จำนวน</th>
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

<div id="request">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_detail_request_1">รายการอุปกรณ์ห้องตรวจ</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-right mt-2 col-sm-6">
                            <input type="text" id="input_Search" class="form-control" placeholder="ค้นหาอุปกรณ์" style="font-size: 20px;" autocomplete="off">
                        </div>
                        <div class="col-md-1 text-right mt-2 col-sm-6">
                            <button class="btn" id="btn_search_request" style="color: #fff;width: 100px;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ค้นหา</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3  mt-2 col-sm-6">
                            <select class="form-control" style="font-size: 25px;" autocomplete="off" id="select_deproom_request"></select>
                        </div>
                        <div class="col-md-3  mt-2 col-sm-6">
                            <input type="text" class="form-control" style="font-size: 20px;" autocomplete="off" id="input_hn_request" placeholder="กรอก HN Number">
                        </div>
                        <div class="col-md-3  mt-2 col-sm-6">
                            <select class="form-control" style="font-size: 25px;" autocomplete="off" id="select_doctor_request"></select>
                        </div>
                        <div class="col-md-3  mt-2 col-sm-6">
                            <select class="form-control" style="font-size: 25px;" autocomplete="off" id="select_procedure_request"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <table class="table table-hover table-sm" id="table_item_request">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center" id="td_request_itemname_1">อุปกรณ์</th>
                                        <th scope="col" class="text-center" efid="td_request_qty_1">จำนวนเบิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_comfirm_request" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_detail_request_2">รายการขอเบิก</label>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn" id="btn_view_request" style="color: #fff;color:black;border-color:black;font-size:20px;">ดูข้อมูลเบิก</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div style="text-align: center;background: linear-gradient(0deg, #EFF6FF, #EFF6FF),linear-gradient(0deg, #FFFFFF, #FFFFFF);">
                                <label style="color:blue;font-weight: bold;font-size: 30px;" id="txt_docno_request"></label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <table class="table table-hover table-sm" id="table_item_detail_request">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" id="td_request_itemname_2">อุปกรณ์</th>
                                        <th scope="col" style="width: 20%;" id="td_request_qty_2">จำนวน</th>
                                        <th scope="col" style="width: 20%;" id="td_request_delete_2">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row mt-2">
                                <div class="col-md-12" style="text-align: end;">
                                    <button disabled class="btn btn-danger" id="btn_cancel_request" style="color:#fff;font-size:20px;">ยกเลิกข้อมูล</button>
                                    <button disabled class="btn" id="btn_send_request" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div id="history_request">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-right mt-2 col-sm-6">
                            <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_date_history" data-language='en' data-date-format='dd-mm-yyyy'>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <table class="table table-hover table-sm" id="table_history_request">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center" id="">HN No.</th>
                                        <th scope="col" class="text-center" id="">แพทย์</th>
                                        <th scope="col" class="text-center" id="">หัตถการ</th>
                                        <th scope="col" class="text-center" id="">#</th>
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


<div id="tab4" hidden>

    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="input_main_4" placeholder="สแกนคืนสต๊อกหลัก" style="font-size:20px;">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="cursor: pointer;" id="qr_main_4"><i class="fa-solid fa-qrcode"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail2_Tab4">รายการอุปกรณ์คืนสต๊อกหลัก</label>
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
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab4_no2">ลำดับ</th>
                                        <th scope="col" style="width: 20%; text-align: center;" id="td_tab4_usage2">รหัสอุปกรณ์</th>
                                        <th scope="col" style="width: 40%;" class="text-center" id="td_tab4_itemname2">ชื่ออุปกรณ์</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_tab4_qty2">จำนวน</th>
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
        <div class="col-lg-6 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail1_Tab4">รายการอุปกรณ์ห้องตรวจ</label>
                        </div>
                        <div class="col-6 text-right">
                            <input type="text" class="form-control datepicker-here" id="select_Date_tab4" data-language='en' data-date-format='dd-mm-yyyy' style="font-size:20px;">
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
                                        <th scope="col" style="width: 40%;" class="text-center" id="td_tab4_itemname">อุปกรณ์</th>
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

    </div>










    <!-- 
    <div class="col-md-4 mt-3">
        <div class="col-sm-12 col-md-8 col-lg-9">
            <input type="text" class="form-control datepicker-here" id="select_Date_tab4" data-language='en' data-date-format='dd-mm-yyyy'>
        </div>
    </div>

    <div class="col-md-8 mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="input_main_4" placeholder="สแกนคืนสต๊อกหลัก">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-3">

        <table class="table table-hover table-sm " id="table_detailTab4Left">
            <thead class="table-active">
                <tr>
                    <th scope="col" style="width: 5%;" class="text-center">ลำดับ</th>
                    <th scope="col" style="width: 40%;" class="text-center">อุปกรณ์</th>
                    <th scope="col" style="width: 20%;" class="text-center">จำนวน</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>

    <div class="col-md-8 mt-3">
        <table class="table table-hover table-sm " id="table_detailTab4Right">
            <thead class="table-active">
                <tr>
                    <th scope="col" style="width: 5%;" class="text-center">ลำดับ</th>
                    <th scope="col" style="width: 20%; text-align: center;">รหัสอุปกรณ์</th>
                    <th scope="col" style="width: 40%;" class="text-center">ชื่ออุปกรณ์</th>
                    <th scope="col" style="width: 20%;" class="text-center">จำนวน</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12" style="text-align: end;">
                <button class="btn" id="btn_SendDataTab4" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งข้อมูล</button>
            </div>
        </div>

    </div> -->

</div>

<div id="tab5" hidden>

    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="input_repair_5" placeholder="สแกนชำรุด" style="font-size:20px;">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="cursor: pointer;" id="qr_repair_5"><i class="fa-solid fa-qrcode"></i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail2_Tab5">รายการอุปกรณ์ชำรุด</label>
                        </div>
                        <div class="col-6 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <table class="table table-hover table-sm " id="table_detailTab5Right">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab5_no2">ลำดับ</th>
                                        <th scope="col" style="width: 15%; text-align: center;" id="td_tab5_usage2">รหัสอุปกรณ์</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id="td_tab5_itemname2">ชื่ออุปกรณ์</th>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab5_qty2">จำนวน</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id="td_tab5_remark">หมายเหตุ</th>
                                        <th scope="col" style="width: 30%;" class="text-center" id=""></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12" style="text-align: end;">
                                    <button class="btn" id="btn_SendDataTab5" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ส่งข้อมูล</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12  mt-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label style="color:black;font-size:25px;" id="header_Detail1_Tab5">รายการอุปกรณ์ห้องตรวจ</label>
                        </div>
                        <div class="col-6 text-right">
                            <input type="text" class="form-control datepicker-here" id="select_Date_tab5" data-language='en' data-date-format='dd-mm-yyyy' style="font-size:20px;">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-3">

                            <table class="table table-hover table-sm " id="table_detailTab5Left">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col" style="width: 5%;" class="text-center" id="td_tab5_no">ลำดับ</th>
                                        <th scope="col" style="width: 40%;" class="text-center" id="td_tab5_itemname">อุปกรณ์</th>
                                        <th scope="col" style="width: 20%;" class="text-center" id="td_tab5_qty">จำนวน</th>
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






    <!-- <div class="col-md-4 mt-3">
        <div class="col-sm-12 col-md-8 col-lg-9">
            <input type="text" class="form-control datepicker-here" id="select_Date_tab5" data-language='en' data-date-format='dd-mm-yyyy'>
        </div>
    </div>

    <div class="col-md-8 mt-3">
        <div class="row">



            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="input_repair_5" placeholder="สแกนชำรุด">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-3">

        <table class="table table-hover table-sm " id="table_detailTab5Left">
            <thead class="table-active">
                <tr>
                    <th scope="col" style="width: 5%;" class="text-center">ลำดับ</th>
                    <th scope="col" style="width: 40%;" class="text-center">อุปกรณ์</th>
                    <th scope="col" style="width: 20%;" class="text-center">จำนวน</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>

    <div class="col-md-8 mt-3">
        <table class="table table-hover table-sm " id="table_detailTab5Right">
            <thead class="table-active">
                <tr>
                    <th scope="col" style="width: 5%;" class="text-center">ลำดับ</th>
                    <th scope="col" style="width: 20%; text-align: center;">รหัสอุปกรณ์</th>
                    <th scope="col" style="width: 40%;" class="text-center">ชื่ออุปกรณ์</th>
                    <th scope="col" style="width: 20%;" class="text-center">จำนวน</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12" style="text-align: end;">
                <button class="btn" id="btn_SendDataTab5" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งข้อมูล</button>
            </div>
        </div>

    </div> -->

</div>


<div class="modal fade" id="modal_CheckEm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รหัสผู้พิมพ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="input_emCode">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal_showPopupMain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headder_showDetailMainPopup">ประวัติการใช้เครื่องมือ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-lg-2 col-sm-4">
                        <label for="recipient-name" class="col-form-label" id="lang_modal_Date">วันที่:</label>
                        <input type="text" class="form-control datepicker-here" id="modal_select_main_Date" data-language='en' data-date-format='dd-mm-yyyy' style="font-size: 20px;">
                    </div>
                    <div class="col-md-4 col-lg-6 col-sm-4" style="margin-top: 2.9rem!important;">
                        <button class="btn" id="modal_btn_main_Search_Date" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size: 20px;">ค้นหา</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-hover table-sm" id="modal_table_hn">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 5%;" id="td_no">No.</th>
                                    <th scope="col" id="td_date">วันที่</th>
                                    <th scope="col" id="td_time">เวลา</th>
                                    <th scope="col" id="td_hn">HN Number</th>
                                    <th scope="col" id="td_roomcheck">ห้องตรวจ</th>
                                    <th scope="col" id="td_doctor">แพทย์</th>
                                    <th scope="col" id="td_procedure">หัตถการ</th>
                                    <th scope="col" id="td_edit">แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-hover table-sm" id="modal_table_hn_detail">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 5%;" id="td_modal1_no">ลำดับ</th>
                                    <th scope="col" style="width: 10%;" id="td_modal1_usage">รหัสอุปกรณ์</th>
                                    <th scope="col" style="width: 10%;" id="td_modal1_itemname">อุปกรณ์</th>
                                    <th scope="col" class="text-center" style="width: 10%;" id="td_modal1_qty">จำนวน</th>

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

<div class="modal fade" id="modal_showPopupUsageCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UsageCode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-md-12" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-hover table-sm" id="modal_table_detail_UsageCode">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">UsageCode</th>
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
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">ชื่อคนไข้ : Mr.Asad อ้ำนีอ้ำใจ</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                </div>
                <div style="width: 220px;height: 180px;background-color: #3fa9f5;margin-top: -42rem;margin-left: 19rem;position: absolute;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-top-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;">รหัสคนไข้ : 21-001818</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">ชื่อคนไข้ : Mr.Asad อ้ำนีอ้ำใจ</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                </div>
                <div style="width: 250px;height: 100px;background-color: #3fa9f5;margin-top: -15rem;position: absolute;border-top-left-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;">รหัสคนไข้ : 21-001818</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">ชื่อคนไข้ : Mr.Asad อ้ำนีอ้ำใจ</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                </div>
                <div style="width: 250px;height: 200px;background-color: #3fa9f5;margin-top: -12rem;margin-left: 40rem;position: absolute;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;">รหัสคนไข้ : 21-001818</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">ชื่อคนไข้ : Mr.Asad อ้ำนีอ้ำใจ</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                </div>
                <div style="width: 250px;height: 100px;background-color: #3fa9f5;margin-top: -16rem;margin-left: 62rem;position: absolute;border-top-right-radius: 25px;border-bottom-left-radius: 25px;border-bottom-right-radius: 25px;">
                    <p style="color: white;font-size: 20px !important;margin-left: 20px;line-height: 1;">รหัสคนไข้ : 21-001818</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">ชื่อคนไข้ : Mr.Asad อ้ำนีอ้ำใจ</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 1;">151551555</p>
                    <p style="color: white;font-size: 20px !important;    margin-left: 20px;line-height: 0;">151551555</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_showPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="header_popUpDetail">ข้อมูลเบิก</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="recipient-name" class="col-form-label" id="text_popUpDate">วันที่:</label>
                        <input type="text" class="form-control datepicker-here" id="modal_select_Date" data-language='en' data-date-format='dd-mm-yyyy'>
                    </div>
                    <div class="col-md-4 col-sm-4" style="margin-top: 2.7rem!important;">
                        <button class="btn" id="modal_btn_Search_Date" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);font-size:20px;">ค้นหา</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-hover table-sm" id="modal_table_detailTab1">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 10%;" id="td_tab2_PopUp_No">ลำดับ</th>
                                    <th scope="col" style="width: 10%;" id="td_tab2_PopUp_itemname">อุปกรณ์</th>
                                    <th scope="col" style="width: 10%;" id="td_tab2_PopUp_Request">เบิก</th>
                                    <th scope="col" style="width: 10%;" id="td_tab2_PopUp_Issue">จ่าย</th>
                                    <th scope="col" style="width: 10%;" id="td_tab2_PopUp_Remaining">ค้างจ่าย</th>
                                    <th scope="col" style="width: 20%;" id="td_tab2_PopUp_Stock">สต๊อกห้องตรวจ</th>
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

<div class="modal fade" id="modal_showPopupBorrow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ข้อมูลห้องตรวจ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-md-12" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-hover table-sm" id="modal_table_detailBorrow">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 10%;">ลำดับ</th>
                                    <th scope="col" style="width: 40%;">ห้อง</th>
                                    <th scope="col" style="width: 10%;">จำนวน</th>
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


<input type="text" id="qr_number" hidden>
<div class="modal fade" id="modal_ScanQr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SCAN QR CODE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="reader" width="600px" height="600px"></div>
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