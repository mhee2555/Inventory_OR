<!-- 
<div class="row">
  <div class="col-md-6 col-sm-3">
    <h1 class="  mt-4" style="font-size:30px;color:black;font-weight: bold;" id="main1">ระบบบริหารจัดการห้องผ่าตัด</h1>
  </div>
  <div class="col-md-6 col-sm-9 text-right mt-2">
    <div style="background-color:  #179d9a;text-align: center;" class="row">
      <div class="col-md-8 col-sm-7 text-left">
        <label class="f24" style="color:#fff;font-weight: bold;">Carbon Footprint Estimated </label>
      </div>
      <div class="col-md-2 col-sm-2">
        <input class="f24"  disabled type='text' class="form-control" style="width: 157px;    margin-left: -70px;margin-top: 5px;margin-bottom: 5px;" id="text_carbon">
      </div>
      <div class="col-md-2 col-sm-3">
        <label class="f24" style="color:#fff;font-weight: bold;"> kg CO2</label>

      </div>
    </div>
  </div>
</div>  -->



<div class="row" style="background-image: url(assets/img_project/carbon_footprint_estimated.png);background-repeat: round;height: 150px;">

  <div class="col-md-6 ml-3">
    <label class="f24 mt-3" style="color:#101828;font-weight: bold;">Carbon Footprint Estimated </label>
    <br>
    <label class="" style="color:#101828;font-weight: bold;font-size:45px;">450.12</label>
    <!-- <input class="f24"  disabled type='text' class="form-control" style="" id="text_carbon"> -->
    <label class="f18" style="color:#101828;"> kg CO2</label>
    <br>
  </div>
</div>





<div class="row ">






  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_ex" hidden>
    <div class="card text-center">



      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_ex">แจ้งเตือนรายการหมดอายุ</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_ex">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/ex.php" class="btn btn-primary" id="btn_ex" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_ex">ไปยังหน้า อุปกรณ์หมดอายุ <i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_exsoon" hidden>
    <div class="card text-center">

      <div style="position: absolute; top: 15px; right: 15px;">
        <i class="fa-solid fa-bell" style="font-size: 50px; color: #f4a100;"></i>
      </div>

      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_exsoon">แจ้งเตือนรายการใกล้หมดอายุ</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_ExSoon">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/ex.php" class="btn btn-primary" id="btn_exsoon" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_exsoon">ไปยังหน้า อุปกรณ์ใกล้หมดอายุ <i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>




  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_receive_stock" hidden>
    <div class="card text-center">

      <div style="position: absolute; top: 15px; right: 15px;">
        <i class="fa-solid fa-bell" style="font-size: 50px; color: #f4a100;"></i>
      </div>

      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_receive_stock">แจ้งเตือนรับอุปกรณ์เข้าคลังหลักห้องผ่าตัด</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_receive_stock">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-4 text-right">
            <ul class="notification-drop" style="display: inline;">
              <li class="item">
                <i class="fa-regular fa-bell notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button" id="text_receive_stock_bell"></span>
              </li>
            </ul>

            <!-- <img src="assets/img_project/1_icon/fluent-emoji_bell.png" alt="" style="width:50px;"> -->
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/recieve_stock.php" class="btn btn-primary" id="btn_receive_stock" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_receive_stock">ไปยังหน้า รับอุปกรณ์เข้าคลังหลักห้องผ่าตัด<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_use_deproom" hidden>
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_use_deproom">แจ้งเตือนอุปกรณ์ให้ห้องผ่าตัด</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_use_deproom">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> คน </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/use_deproom.php" class="btn btn-primary" id="btn_use_deproom" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_use_deproom">ไปยังหน้า อุปกรณ์ในห้องผ่าตัด<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_damage" hidden>
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_damage">แจ้งเตือนการบันทึกอุปกรณ์ชำรุด</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_damage">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/damaged.php" class="btn btn-primary" id="btn_damage" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_damage">ไปยังหน้า แจ้งเตือนการบันทึกอุปกรณ์ชำรุด<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_addon" hidden>
    <div class="card text-center">

      <div style="position: absolute; top: 15px; right: 15px;">
        <i class="fa-solid fa-bell" style="font-size: 50px; color: #f4a100;"></i>
      </div>


      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_exsoon">แจ้งเตือนห้องผ่าตัดขอเบิกเพิ่ม</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_ExSoon">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="#" class="btn btn-primary" id="btn_exsoon" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_exsoon">ไปยังหน้า ห้องผ่าตัดขอเบิกเพิ่ม<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_nouse" hidden>
    <div class="card text-center">

      <div style="position: absolute; top: 15px; right: 15px;">
        <i class="fa-solid fa-bell" style="font-size: 50px; color: #f4a100;"></i>
      </div>

      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_exsoon">แจ้งเตือนอุปกรณ์ที่ไม่ใช้กับคนไข้</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_nouse">0</label>
              <label class="f24" style="font-size: 28px;color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-4 text-right">
            <ul class="notification-drop" style="display: inline;">
              <li class="item">
                <i class="fa-regular fa-bell notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button" id="text_nouse_bell"></span>
              </li>
            </ul>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/nouse.php" class="btn btn-primary" id="btn_nouse" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_nouse">ไปยังหน้า อุปกรณ์ที่ไม่ใช้กับคนไข้<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_borrow" hidden>
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="header_borrow">แจ้งเตือนยืมของ</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_borrow">0</label>
              <label class="f24" style="color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/borrow.php" class="btn btn-primary" id="btn_borrow" style="font-size: 25px;background-color:#643695;"> <label class="mb-0" id="go_nouse">ไปยังหน้า แจ้งเตือนยืมของ<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_oc">
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="">ติดตามอุปกรณ์</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_oc">0</label>
              <label class="f24" style="color:black;" class="label_item"> รายการ </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/oc.php" class="btn btn-primary" id="btn_oc" style="font-size: 25px;background-color:#643695;"> <label class="mb-0">ไปยังหน้า ติดตามอุปกรณ์<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_hn">
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="">แจ้งเตือนคนไข้</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_hn">0</label>
              <label class="f24" style="color:black;" class="label_hn"> เอกสาร </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/hn_daily.php" class="btn btn-primary" id="btn_hn" style="font-size: 25px;background-color:#643695;"> <label class="mb-0">ไปยังหน้า แจ้งเตือนคนไข้<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-6 mt-3" id="row_request_item">
    <div class="card text-center">
      <div class="card-body">
        <div class="row g-0">
          <div class="col-md-8 text-left">
            <h2 class="card-title text-dark font-weight-bold f24" id="">แจ้งเตือนรับอุปกรณ์เข้าคลัง</h2>
            <div class="card-text"> <label style="font-size: 70px;color:#101828;line-height: 55px;" id="text_request_item">0</label>
              <label class="f24" style="color:black;" class="label_request_item"> เอกสาร </label>
            </div>
          </div>
          <div class="col-md-12 text-left">
            <a href="pages/request_item.php" class="btn btn-primary" id="btn_request_item" style="font-size: 25px;background-color:#643695;"> <label class="mb-0">ไปยังหน้า แจ้งเตือนรับอุปกรณ์เข้าคลัง<i class="fa-solid fa-arrow-right-long" style="font-size: 15px;margin-left: 15px;"></i> </label> </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--  -->


</div>