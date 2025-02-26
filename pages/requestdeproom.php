<div class="row">
    <div class="col-md-6">
        <h1 class="  mt-4" style="font-size:30px;color:black;font-weight: bold;" id="main1">ระบบทันตกรรม</h1>
        <!-- <label for="" id="label_mainpage">หน้าหลัก  </label> > <a href="#" style="font-size:25px;" id="text_requestdeproom"> ห้องตรวจขอเบิกเพิ่ม</a> -->
    </div>
</div>



<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8 text-dark font-weight-bold" id="headder_label">รายการห้องตรวจขอเบิกเพิ่ม</div>
            <div class="col-md-4 text-right">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <input type="text" class="form-control" id="input_search" placeholder="ค้นหารายการ" autocomplete="off" style="font-size: 25px;">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <button class="btn btn-primary" id="btn_search" style="width: 120px;font-size: 25px;">ค้นหา</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12 mt-3">
            <table class="table table-hover table-sm " id="table_data">
                <thead class="table-active">
                    <tr>
                        <th scope="col" style="width: 10%;" class="text-center" id="td_no">No.</th>
                        <th scope="col" style="width: 20%;" class="text-center" id="td_deproom">ห้องตรวจ</th>
                        <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                        <th scope="col" style="width: 10%;" class="text-center" id="td_qty">จำนวน</th>
                        <th scope="col" style="width: 10%;" class="text-center">#</th>
                        <th hidden scope="col" style="width: 10%;" class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>