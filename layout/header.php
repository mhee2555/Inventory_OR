<nav class="navbar navbar-expand navbar-light bg-white shadow py-3">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    <!-- ฝั่งซ้าย: ปรับขนาดฟอนต์ + การแสดงผล -->
    <div class="d-flex align-items-center flex-wrap">
      <span style="font-size: 16px; color: #475467;" id="textSize">ขนาดตัวอักษร : </span>
      <button class="btn clearfont ml-2" style="font-size: 16px; color: #475467;" id="font-small">กก</button>
      <button class="btn clearfont ml-1" style="font-size: 16px; color: #475467; width: 40px; line-height: 25px;" id="font-medium">กก</button>
      <button class="btn clearfont ml-1" style="font-size: 16px; color: #475467; width: 40px; line-height: 25px;" id="font-big">กก</button>

      <span class="ml-4" style="font-size: 16px; color: #475467;" id="disPlay">การแสดงผล : </span>
      <button class="btn cleardisplay ml-2" style="font-size: 16px; color: #1D2939; font-weight: bold;" id="display-1">กก</button>
      <button class="btn cleardisplay ml-1" style="font-size: 16px; color: #1D2939; font-weight: bold;" id="display-2">กก</button>
      <button class="btn cleardisplay ml-1" style="font-size: 16px; color: #1D2939; font-weight: bold;" id="display-3">กก</button>
    </div>

    <!-- ฝั่งขวา: ตั้งค่า + ภาษา -->
    <div class="d-flex align-items-center">
      <!-- ปุ่มตั้งค่า -->
      <i class="fa-solid fa-gear mr-3" style="font-size: 25px; cursor: pointer;" id="btn_setting_timeout"></i>

      <!-- Dropdown ภาษา -->
      <div class="dropdown" hidden>
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="background-color: white;">
          <img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 20%;" class="pr-2">
          <span id="lang-change">ภาษาไทย</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#" id="lang-thai">
            <img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 20%;" class="pr-2"> ภาษาไทย
          </a>
          <a class="dropdown-item" href="#" id="lang-eng">
            <img src="assets/icon_ui/orter/ic_eng.png" alt="" style="width: 20%;" class="pr-2"> ภาษาอังกฤษ
          </a>
        </div>
      </div>
    </div>

  </div>
</nav>
