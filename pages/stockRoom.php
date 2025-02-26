<div class="row">
    <div class="col-md-6">
        <h1 class="  mt-4" style="font-size:30px;color:black;font-weight: bold;" id="main1">ระบบทันตกรรม</h1>
        <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_stockRoom"> ความเคลื่อนไหว</a> -->
    </div>
</div>

<div class="row">




    <div class="col-md-6">

        <div class="btn-group btn-group-toggle" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab1">คลัง Dental จ่ายอุปกรณ์ให้ห้องตรวจ</button>
            <button type="button" class="btn btn-light" style="border: 1px solid;font-size: 25px;font-weight: bold;" id="radio_tab2">สต๊อกของห้องตรวจ</button>
        </div>


        <!-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light active" style="width: 250px;border: 1px solid;font-size: 20px;" id="label_tab1">
                <input type="radio" name="options" id="radio_tab1" autocomplete="off" checked> คลัง Center จ่ายอุปกรณ์ให้ห้องตรวจ
            </label>
            <label class="btn btn-light" style="width: 250px;border: 1px solid;font-size: 20px;" id="label_tab2">
                <input type="radio" name="options" id="radio_tab2" autocomplete="off"> สต๊อกของห้องตรวจ
            </label>
        </div> -->
    </div>


    <!-- <div class=" col-md-12 col-lg-9  ">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light active" style="width: 220px;border: 1px solid;font-size:18px;" id="label_tab1">
                <input type="radio" name="options" id="radio_tab1" autocomplete="off" checked> คลัง Center จ่ายอุปกรณ์ให้ห้องตรวจ
            </label>
            <label class="btn btn-light" style="width: 150px;border: 1px solid;font-size:18px;" id="label_tab2">
                <input type="radio" name="options" id="radio_tab2" autocomplete="off"> สต๊อกของห้องตรวจ
            </label>
        </div>
    </div> -->
</div>

<div id="tab1">
    <div class="row mt-3">
        <div class="col-lg-4">
            <label for="" id="lang_text_date">วันที่</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-light" style="font-size: 20px;font-weight: bold;"><i class="fa-regular fa-calendar-days"></i></div>
                </div>
                <input type="text" style="font-size:20px;" class="form-control datepicker-here" id="select_date1" data-language='en' data-date-format='dd-mm-yyyy'>
            </div>


        </div>

        <div class="col-md-4">
            <label for="" id="lang_text_floor">ชั้น</label>
            <select id="select_floor" class="form-control select2" style="font-size:20px;">
                <option value="0">แสดงทั้งหมด</option>
                <option value="1">ชั้น 2</option>
                <option value="2">ชั้น 3</option>
            </select>
        </div>


        <div class="col-lg-3 mt-3">

        </div>

        <div class="col-md-3 mt-3">
        </div>

    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-6 text-left">
                            <label for="" class="text-dark font-weight-bold h5 " style="font-size: 25px;" id="header_Detail">ความเคลื่อนไหว</label>

                        </div>
                        <div class="col-5 text-right">
                            <input type="text" id="input_Search" class="form-control" placeholder="ค้นหาชื่ออุปกรณ์ หรือ รหัสอุปกรณ์" style="font-size: 20px;">
                        </div>
                        <div class="col-1 text-right">
                            <button class="btn btn-primary btn-block" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);" id="btn_Search">ค้นหา</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mt-3  table-responsive">

                            <table class="table table-sm table-bordered" id="table_DepRoom">
                                <thead>
                                    <tr id="tr_TableDephead">

                                    </tr>
                                    <tr id="tr_TableDep">

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

<div id="tab2">
    <div class="row">

        <div class="col-lg-3 mt-3">
            <input type="text" class="form-control datepicker-here" data-language='en' data-date-format='dd-mm-yyyy' id="select_date2" style="font-size: 20px;">
        </div>
        <div class="col-lg-3 mt-3">
            <select id="select_floor2" class="form-control select2" style="font-size: 20px;">
                <option value="0">เลือกทั้งหมด</option>
                <option value="1">ชั้น 2</option>
                <option value="2">ชั้น 3</option>
            </select>
        </div>

        <div class="col-md-3 mt-3">
            <input type="text" id="input_Search2" class="form-control" placeholder="ค้นหาอุปกรณ์" style="font-size: 20px;">
        </div>

    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-3  table-responsive">

                <table class="table  table-sm table-bordered" id="table_DepRoom2">
                    <thead>
                        <tr id="tr_TableDephead2">

                        </tr>
                        <tr id="tr_TableDep2">

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>



            </div>
        </div>

    </div>


</div>