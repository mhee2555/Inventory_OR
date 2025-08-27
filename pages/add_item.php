<div class="row mt-3">
    <div class="col-md-3">
        <div class="form-group row">
            <label style="color:black;font-weight: 600;">วันที่</label>
            <div class="position-relative">
                <input type="text" class="form-control rounded pr-5 f18" placeholder="" id="select_date1_search1" data-language='en' data-date-format='dd-mm-yyyy'>
                <span class="input-icon">
                    <i class="fa-solid fa-calendar" style="color:black;"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-check " style="margin-top: 38px;">
            <input type="checkbox" class="form-check-input" id="checkbox_filter" style="width: 25px;height: 25px;" checked>
            <label class="form-check-label f18 ml-4 mt-1" for="checkbox_filter" style="color:black;font-weight:bold;">แสดงเอกสารคงค้าง</label>
        </div>
    </div>


</div>
<div class="row mt-2">
    <div class="col-md-12 mt-2">
        <table class="table table-hover " id="table_daily">
            <thead c style="background-color: #cdd6ff;">
                <tr>
                    <th scope="col" class="text-center" id="">ลำดับ</th>
                    <th scope="col" class="text-center" id="">เลขประจำตัวผู้ป่วย</th>
                    <th scope="col" class="text-center" id="">แพทย์</th>
                    <th scope="col" class="text-center" id="">หัตถการ</th>
                    <th scope="col" class="text-center" id="">อุปกรณ์ที่ขอเบิก</th>
                    <th scope="col" class="text-center" id="" style='width: 12%;'>#</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="showDetail_item_map" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">อุปกรณ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover " id="table_detail_item_modal">
                    <thead style="background-color: #cdd6ff;">
                        <tr>
                            <th scope="col" class="text-center" id="">ลำดับ</th>
                            <th scope="col" class="text-center" id="">อุปกรณ์</th>
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