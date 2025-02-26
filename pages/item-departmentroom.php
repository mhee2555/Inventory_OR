<div class="row">
    <div class="col-md-6">
        <h1 class="  mt-4" style="font-size:30px;color:black;font-weight: bold;" id="main1">ระบบทันตกรรม</h1>
        <!-- <label for="" id="label_mainpage">หน้าหลัก </label> > <a href="#" style="font-size:25px;" id="text_damaged"> รายการชำรุด</a> -->
    </div>
</div>


<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8 text-dark font-weight-bold" id="headder_label">อุปกรณ์ในห้องตรวจ</div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-10">
                        <select class="form-control" style="font-size: 25px;" id="select_item"></select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block" id="btn_searchItem" style="background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);color:white;font-size: 20px;">ค้นหา</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>


        <div id="row_B" class="mt-3">

        </div>
    </div>
</div>

<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="color:black;font-weight:bold;" id="deproomshow"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table table-hover table-sm" id="modal_table_detail">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="td_no">ลำดับ</th>
                            <th scope="col" class="text-center" id="td_item">อุปกรณ์</th>
                            <th scope="col" class="text-center" id="td_qty">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modaldetail_searchitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 style="color:black;font-weight:bold;" id="header_item"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table table-hover table-sm" id="modal_table_detail_searchitem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" id="td_deproom1" style="width: 40%;">ห้องตรวจที่มีอุปกรณ์</th>
                            <th scope="col" class="text-center" id="td_deproom2">จำนวนที่มีในห้อง</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>