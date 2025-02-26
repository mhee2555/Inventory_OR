<nav class="navbar navbar-expand navbar-light  topbar static-top shadow" style="background-color:white;height: 2.5rem !important;">

    <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button> -->


    <!-- Topbar Navbar -->

    <!-- <div class="row " style="width: 100%;">
        <div class="col-md-7">
            <span style="font-size: 25px !important;color: #475467;" id="textSize">ขนาดตัวอักษร : </span>
            <button class="btn clearfont" style="font-size: 20px !important;color: #475467;" id="font-small">A</button>
            <button class="btn clearfont" style="font-size: 25px !important;color: #475467;width: 40px;line-height: 25px;" id="font-medium">A</button>
            <button class="btn clearfont" style="font-size: 30px !important;color: #475467;width: 40px;line-height: 25px;" id="font-big">A</button>


            <span style="font-size: 25px !important;color: #475467;margin-left: 35px;" id="disPlay">การแสดงผล : </span>
            <button class="btn cleardisplay" style="font-size: 25px !important;color: #1D2939;font-weight: bold;" id="display-1">A</button>
            <button class="btn cleardisplay" style="font-size: 25px !important;color: #1D2939;font-weight: bold;" id="display-2">A</button>
            <button class="btn cleardisplay" style="font-size: 25px !important;color: #1D2939;font-weight: bold;" id="display-3">A</button>

        </div>

        <div class="col-md-5 text-right">
            <button class="btn clearlang" style="font-size: 20px !important;color: #475467; display: inline-flex;line-height: 15px;" id="lang-thai" >
                <img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 50%;" class="pr-2">
                <label class="mt-2">ไทย</label>
            </button>
            <button class="btn clearlang" style="font-size: 20px !important;color: #475467; display: inline-flex;line-height: 15px;" id="lang-eng" >
            <img src="assets/icon_ui/orter/ic_eng.png" alt="" style="width:50%;" class="pr-2"> 
                <label class="mt-2">ENG</label>
            </button>
        </div>

    </div> -->
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search w-100">
        <span style="font-size: 16px !important;color: #475467;" id="textSize">ขนาดตัวอักษร : </span>
        <button class="btn clearfont" style="font-size: 16px !important;color: #475467;" id="font-small">กก</button>
        <button class="btn clearfont" style="font-size: 16px !important;color: #475467;width: 40px;line-height: 25px;" id="font-medium">กก</button>
        <button class="btn clearfont" style="font-size: 16px !important;color: #475467;width: 40px;line-height: 25px;" id="font-big">กก</button>


        <span style="font-size: 16px !important;color: #475467;margin-left: 35px;" id="disPlay">การแสดงผล : </span>
        <button class="btn cleardisplay" style="font-size: 16px !important;color: #1D2939;font-weight: bold;" id="display-1">กก</button>
        <button class="btn cleardisplay" style="font-size: 16px !important;color: #1D2939;font-weight: bold;" id="display-2">กก</button>
        <button class="btn cleardisplay" style="font-size: 16px !important;color: #1D2939;font-weight: bold;" id="display-3">กก</button>

    </div>
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0" style="text-align: end;">
        <i class="fa-solid fa-gear" style="font-size: 25px;cursor:pointer;" id="btn_setting_timeout"></i>
    </div>
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 " style="text-align: end;">
        <div class="dropdown">
            <button class="btn  dropdown-toggle" style="background-color: white;" type="button" data-toggle="dropdown" aria-expanded="false">
                <a class="dropdown-item" href="#" style="display: contents;" ><img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 20%;" class="pr-2"> <span id="lang-change">ภาษาไทย</span> </a>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" id="lang-thai"><img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 20%;" class="pr-2"> ภาษาไทย </a>
                <a class="dropdown-item" href="#" id="lang-eng"><img src="assets/icon_ui/orter/ic_eng.png" alt="" style="width: 20%;" class="pr-2">ภาษาอังกฤษ</a>
            </div>
        </div>

    </div>





    <!--  -->
    <!-- <div class="navbar-nav ml-auto">
        <div class="dropdown">
            <button class="btn  dropdown-toggle" style="background-color: white;" type="button" data-toggle="dropdown" aria-expanded="false">
                 ภาษาไทย
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#"><img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 20%;" class="pr-2"> ภาษาไทย</a>
                <a class="dropdown-item" href="#"><img src="assets/icon_ui/orter/ic_eng.png" alt="" style="width: 20%;" class="pr-2">ภาษาอังกฤษ</a>
            </div>
        </div>
        <button class="btn clearlang" style="font-size: 20px !important;color: #475467; display: inline-flex;line-height: 15px;" id="lang-thai">
            <img src="assets/icon_ui/orter/ic_thailand.png" alt="" style="width: 50%;" class="pr-2">
            <label class="mt-2">ไทย</label>
        </button>
        <button class="btn clearlang" style="font-size: 20px !important;color: #475467; display: inline-flex;line-height: 15px;" id="lang-eng">
            <img src="assets/icon_ui/orter/ic_eng.png" alt="" style="width:50%;" class="pr-2">
            <label class="mt-2">ENG</label>
        </button>
    </div>
    <div class="navbar-nav">
        <i class="fa-solid fa-gear" style="font-size: 30px;cursor:pointer;" id="btn_setting_timeout"></i>
    </div> -->

</nav>