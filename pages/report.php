<div class="row mt-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header text-center">
                รายงาน
            </div>

            <input type="text" id="input_check" hidden>

            <div class="card-body">
                <table class="table">
                    <tr>
                        <th class="text-center">รายงาน</th>
                    </tr>
                    <tbody>
                        <tr id="tr_report1" style="cursor: pointer;">
                            <td>
                                รายงานคลัง Center จ่ายอุปกรณ์ให้ห้องตรวจ
                            </td>
                        </tr>
                        <tr id="tr_report2" style="cursor: pointer;">
                            <td>
                                รายงานส่งอุปกรณ์ไป N Sterile
                            </td>
                        </tr>
                        <tr id="tr_report3" style="cursor: pointer;">
                            <td>
                                รายงานสต๊อกห้องตรวจประจำวัน
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="min-height: 900px;max-height:900px;">
            <div class="card-header text-center">
                รายละเอียด
            </div>
            <div class="card-body">
                <iframe id="fred" style="border:1px solid #666CCC" title="คู่มือ" frameborder="1" scrolling="auto" height="800" width="100%">
                </iframe>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header text-center">
                เงื่อนไข
            </div>
            <div class="card-body">
                <div class="form-group" id="row_date1" hidden>
                    <label for="">วันที่</label>
                    <input type="text" class="form-control  datepicker-here" id="select_date1" data-language='en' data-date-format='dd/mm/yyyy' style="font-size:20px;">
                </div>
                <div class="form-group" id="row_date2" hidden>
                    <label for="">ถึง</label>
                    <input type="text" class="form-control datepicker-here" id="select_date2" data-language='en' data-date-format='dd/mm/yyyy' style="font-size:20px;">
                </div>
                <div class="form-group" id="row_type" hidden>
                    <label for="">รูปแบบ</label>
                    <select name="" id="select_type" class="form-control" style="font-size:20px;">
                        <option value="1">รวมรายการ</option>
                        <option value="2">แยกรายการ</option>
                    </select>
                </div>
                <div class="form-group" id="row_floor" hidden>
                    <label for="">ชั้น</label>
                    <select name="" id="select_floor" class="form-control" style="font-size:20px;">
                        <option value="">แสดงทั้งหมด</option>
                        <option value="">ชั้น 2</option>
                        <option value="">ชั้น 3</option>
                    </select>
                </div>

                <button class="btn btn-primary" id="btn_Search" style="font-size:20px;color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ค้นหา</button>
            </div>
        </div>
    </div>
</div>