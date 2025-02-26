<div>




    <h1 class="h3 mb-1 text-gray-800 mt-4">ใช้แล้ว - คืนสต๊อกหลัก</h1>
    <p class="mb-4">อุปกรณ์ใช้แล้ว-คืนสต๊อกหลัก</p>


</div>


<hr>



<div class="row">
    <div class="col-md-3">
        <input type="text" class="form-control datepicker-here" id="select_Date_tab2" data-language='en' data-date-format='dd-mm-yyyy'>
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>

    <div class="col-md-4 mt-3">
        <div class="row">
            <div class="col-md-12">
                <div style="border-radius: 25px;text-align: center;background: linear-gradient(0deg, #FEF2F2, #FEF2F2),linear-gradient(0deg, #FFFFFF, #FFFFFF);">
                    <label style="color: red;font-weight: bold;"> <i class="fa-solid fa-calendar"></i> ผู้ใช้ : <?= $UserName;?></label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="input_stock" placeholder="สแกนคืนห้องตรวจ">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="input_use" placeholder="สแกนใช้แล้ว">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa-solid fa-barcode"></i></div>
                    </div>
                    <input type="text" class="form-control" id="input_main" placeholder="สแกนคืนสต๊อกหลัก">
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-4 mt-3">

        <div class="card">
            <div class="card-header text-dark font-weight-bold h5 text-center">
                ห้องตรวจ
            </div>
            <ul class="list-group" id="ul_DeproomTab2">
                <!-- <li class="list-group-item active">ห้องตรวจ 15</li>
                <li class="list-group-item">ห้องตรวจ 14</li>
                <li class="list-group-item">ห้องตรวจ 13</li> -->
            </ul>
        </div>

    </div>

    <div class="col-md-8 mt-3">
        <table class="table table-hover table-sm " id="table_detailTab2">
            <thead class="table-active" >
                <tr>
                    <th scope="col" style="width: 5%;"></th>
                    <th scope="col">อุปกรณ์สต๊อกห้องตรวจ</th>
                    <th scope="col" style="width: 20%;" class="text-center">สต๊อกห้องตรวจ</th>
                    <th scope="col" style="width: 20%;" class="text-center">ใช้แล้ว</th>
                    <th scope="col" style="width: 20%;" class="text-center">คืนสต๊อกหลัก</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12" style="text-align: end;">
                <button class="btn" id="btn_SendData" style="color:#fff;background: linear-gradient(60.23deg, #2970FF 0.2%, #0040C1 99.99%);">ส่งข้อมูล</button>
            </div>
        </div>

    </div>

</div>